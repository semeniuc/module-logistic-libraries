<?php

namespace App\Service;

use Exception;

final class Bitrix24ConnectService
{
    public const VERSION = '1.36';
    public const BATCH_COUNT = 50;         //count batch 1 query
    public const TYPE_TRANSPORT = 'json';  // json or xml
    public const DIR_SECRET = APP_PATH . '/var/key/bitrix/';
    public const IS_SAVE_LOG = false;
    public const DIR_LOG = APP_PATH . '/var/log/bitrix/';

    /**
     * call where install application even url
     * only for rest application, not webhook
     */

    public static function installApp(): array
    {
        $result = [
            'rest_only' => true,
            'install' => false
        ];
        if ($_REQUEST['PLACEMENT'] == 'DEFAULT') {
            $result['rest_only'] = false;
            $result['install'] = self::setAppSettings(
                [
                    'access_token' => htmlspecialchars($_REQUEST['AUTH_ID']),
                    'expires_in' => htmlspecialchars($_REQUEST['AUTH_EXPIRES']),
                    'application_token' => htmlspecialchars($_REQUEST['APP_SID']),
                    'refresh_token' => htmlspecialchars($_REQUEST['REFRESH_ID']),
                    'domain' => htmlspecialchars($_REQUEST['DOMAIN']),
                    'client_endpoint' => 'https://' . htmlspecialchars($_REQUEST['DOMAIN']) . '/rest/',
                ],
                true
            );
        }

        self::setLog(
            [
                'request' => $_REQUEST,
                'result' => $result
            ],
            'installApp'
        );
        return $result;
    }

    /**
     * Generate a request for callCurl()
     *
     * @return mixed array|string|boolean curl-return or error
     * @var $params array method params
     * @var $method string
     */

    public static function call($method, $params = []): mixed
    {
        $arPost = [
            'method' => $method,
            'params' => $params
        ];
        if (defined('C_REST_CURRENT_ENCODING')) {
            $arPost['params'] = self::changeEncoding($arPost['params']);
        }

        $result = self::callCurl($arPost);
        return $result;
    }

    /**
     * @return array
     *
     * @var $arData array
     * @var $halt   int 0 or 1 stop batch on error
     * @example $arData:
     * $arData = [
     *      'find_contact' => [
     *          'method' => 'crm.duplicate.findbycomm',
     *          'params' => [ "entity_type" => "CONTACT",  "type" => "EMAIL", "values" => array("info@bitrix24.com") ]
     *      ],
     *      'get_contact' => [
     *          'method' => 'crm.contact.get',
     *          'params' => [ "id" => '$result[find_contact][CONTACT][0]' ]
     *      ],
     *      'get_company' => [
     *          'method' => 'crm.company.get',
     *          'params' => [ "id" => '$result[get_contact][COMPANY_ID]', "select" => ["*"],]
     *      ]
     * ];
     *
     */

    public static function callBatch($arData, $halt = 0): mixed
    {
        $arResult = [];
        if (is_array($arData)) {
            if (defined('C_REST_CURRENT_ENCODING')) {
                $arData = self::changeEncoding($arData);
            }
            $arDataRest = [];
            $i = 0;
            foreach ($arData as $key => $data) {
                if (!empty($data['method'])) {
                    $i++;
                    if (self::BATCH_COUNT >= $i) {
                        $arDataRest['cmd'][$key] = $data['method'];
                        if (!empty($data['params'])) {
                            $arDataRest['cmd'][$key] .= '?' . http_build_query($data['params']);
                        }
                    }
                }
            }
            if (!empty($arDataRest)) {
                $arDataRest['halt'] = $halt;
                $arPost = [
                    'method' => 'batch',
                    'params' => $arDataRest
                ];
                $arResult = self::callCurl($arPost);
            }
        }
        return $arResult;
    }

    /**
     * Can overridden this method to change the log data storage location.
     *
     * @return bool is successes save log data
     * @var $type   string to more identification log data
     * @var $arData array of logs data
     */

    public static function setLog($arData, $type = ''): bool
    {
        $return = false;

        if (self::IS_SAVE_LOG === true) {
            $path = self::DIR_LOG;
            (file_exists($path)) ?: mkdir($path, 0775, true);

            $dataToJson = [
                date('H:i:s') => [
                    'type' => $type,
                    'data' => $arData,
                ],
            ];

            $file = date("Y-m-d") . ".json";

            if (file_exists($path . $file)) {
                $oldJsonLog = self::expandData(file_get_contents($path . $file));
                $jsonLog = self::wrapData(array_merge($dataToJson, $oldJsonLog));
            } else {
                $jsonLog = self::wrapData($dataToJson);
            }

            $return = file_put_contents($path . $file, $jsonLog);
        }

        return $return;
    }

    /**
     * @return mixed array|string|boolean curl-return or error
     *
     * @var $arParams array
     * $arParams = [
     *      'method'    => 'some rest method',
     *      'params'    => []//array params of method
     * ];
     */
    protected static function callCurl($arParams): mixed
    {
        usleep(500000); // 0.5 sec

        if (!function_exists('curl_init')) {
            return [
                'error' => 'error_php_lib_curl',
                'error_information' => 'need install curl lib'
            ];
        }
        $arSettings = self::getAppSettings();
        if ($arSettings !== false) {
            if (isset($arParams['this_auth']) && $arParams['this_auth'] == 'Y') {
                $url = 'https://oauth.bitrix.info/oauth/token/';
            } else {
                $url = $arSettings["client_endpoint"] . $arParams['method'] . '.' . self::TYPE_TRANSPORT;
                if (empty($arSettings['is_web_hook']) || $arSettings['is_web_hook'] != 'Y') {
                    $arParams['params']['auth'] = $arSettings['access_token'];
                }
            }

            $sPostFields = http_build_query($arParams['params']);

            try {
                $obCurl = curl_init();
                curl_setopt($obCurl, CURLOPT_URL, $url);
                curl_setopt($obCurl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($obCurl, CURLOPT_POSTREDIR, 10);
                curl_setopt($obCurl, CURLOPT_USERAGENT, 'Bitrix24 CRest PHP ' . self::VERSION);
                if ($sPostFields) {
                    curl_setopt($obCurl, CURLOPT_POST, true);
                    curl_setopt($obCurl, CURLOPT_POSTFIELDS, $sPostFields);
                }
                curl_setopt(
                    $obCurl,
                    CURLOPT_FOLLOWLOCATION,
                    (isset($arParams['followlocation']))
                        ? $arParams['followlocation'] : 1
                );
                if (defined("C_REST_IGNORE_SSL") && C_REST_IGNORE_SSL === true) {
                    curl_setopt($obCurl, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($obCurl, CURLOPT_SSL_VERIFYHOST, false);
                }
                $out = curl_exec($obCurl);
                $info = curl_getinfo($obCurl);
                if (curl_errno($obCurl)) {
                    $info['curl_error'] = curl_error($obCurl);
                }
                if (self::TYPE_TRANSPORT == 'xml' && (!isset($arParams['this_auth']) || $arParams['this_auth'] != 'Y')) //auth only json support
                {
                    $result = $out;
                } else {
                    $result = self::expandData($out);
                }
                curl_close($obCurl);

                if (!empty($result['error'])) {
                    if ($result['error'] == 'expired_token' && empty($arParams['this_auth'])) {
                        $result = self::GetNewAuth($arParams);
                    } else {
                        $arErrorInform = [
                            'expired_token' => 'expired token, cant get new auth? Check access oauth server.',
                            'invalid_token' => 'invalid token, need reinstall application',
                            'invalid_grant' => 'invalid grant, check out define BITRIX24_CLIENT_SECRET or BITRIX24_CLIENT_ID',
                            'invalid_client' => 'invalid client, check out define BITRIX24_CLIENT_SECRET or BITRIX24_CLIENT_ID',
                            'QUERY_LIMIT_EXCEEDED' => 'Too many requests, maximum 2 query by second',
                            'ERROR_METHOD_NOT_FOUND' => 'Method not found! You can see the permissions of the application: CRest::call(\'scope\')',
                            'NO_AUTH_FOUND' => 'Some setup error b24, check in table "b_module_to_module" event "OnRestCheckAuth"',
                            'INTERNAL_SERVER_ERROR' => 'Server down, try later'
                        ];
                        if (!empty($arErrorInform[$result['error']])) {
                            $result['error_information'] = $arErrorInform[$result['error']];
                        }
                    }
                }
                if (!empty($info['curl_error'])) {
                    $result['error'] = 'curl_error';
                    $result['error_information'] = $info['curl_error'];
                }

                self::setLog(
                    [
                        'url' => $url,
                        'info' => $info,
                        'params' => $arParams,
                        'result' => $result
                    ],
                    'callCurl'
                );

                return $result;
            } catch (Exception $e) {
                self::setLog(
                    [
                        'message' => $e->getMessage(),
                        'code' => $e->getCode(),
                        'trace' => $e->getTrace(),
                        'params' => $arParams
                    ],
                    'exceptionCurl'
                );

                return [
                    'error' => 'exception',
                    'error_exception_code' => $e->getCode(),
                    'error_information' => $e->getMessage(),
                ];
            }
        } else {
            self::setLog(
                [
                    'params' => $arParams
                ],
                'emptySetting'
            );
        }

        return [
            'error' => 'no_install_app',
            'error_information' => 'error install app, pls install local application '
        ];
    }

    /**
     * Getting a new authorization and sending a request for the 2nd time
     *
     * @return array query result from $arParams
     *
     * @var $arParams array request when authorization error returned
     */

    private static function GetNewAuth($arParams): array
    {
        $result = [];
        $arSettings = self::getAppSettings();
        if ($arSettings !== false) {
            $arParamsAuth = [
                'this_auth' => 'Y',
                'params' =>
                    [
                        'client_id' => $arSettings['BITRIX24_CLIENT_ID'],
                        'grant_type' => 'refresh_token',
                        'client_secret' => $arSettings['BITRIX24_CLIENT_SECRET'],
                        'refresh_token' => $arSettings["refresh_token"],
                    ]
            ];
            $newData = self::callCurl($arParamsAuth);
            if (isset($newData['BITRIX24_CLIENT_ID'])) {
                unset($newData['BITRIX24_CLIENT_ID']);
            }
            if (isset($newData['BITRIX24_CLIENT_SECRET'])) {
                unset($newData['BITRIX24_CLIENT_SECRET']);
            }
            if (isset($newData['error'])) {
                unset($newData['error']);
            }
            if (self::setAppSettings($newData)) {
                $arParams['this_auth'] = 'N';
                $result = self::callCurl($arParams);
            }
        }
        return $result;
    }

    /**
     * @return bool
     * @var $isInstall  bool true if install app by installApp()
     * @var $arSettings array settings application
     */

    private static function setAppSettings($arSettings, $isInstall = false): bool
    {
        $return = false;
        if (is_array($arSettings)) {
            $oldData = self::getAppSettings();
            if ($isInstall != true && !empty($oldData) && is_array($oldData)) {
                $arSettings = array_merge($oldData, $arSettings);
            }
            $return = self::setSettingData($arSettings);
        }
        return $return;
    }

    /**
     * @return mixed setting application for query
     */

    private static function getAppSettings(): mixed
    {
        $arData = self::getSettingData();
        $isCurrData = false;
        if (
            !empty($arData['access_token']) &&
            !empty($arData['domain']) &&
            !empty($arData['refresh_token']) &&
            !empty($arData['application_token']) &&
            !empty($arData['client_endpoint'])
        ) {
            $isCurrData = true;
        }

        return ($isCurrData) ? $arData : false;
    }

    /**
     * Can overridden this method to change the data storage location.
     *
     * @return array setting for getAppSettings()
     */

    protected static function getSettingData(): array
    {
        $return = [];
        if (file_exists(self::DIR_SECRET . "secret.json")) {
            $return = self::expandData(file_get_contents(self::DIR_SECRET . "secret.json"));
            $return['BITRIX24_CLIENT_ID'] = $_ENV["BITRIX24_CLIENT_ID"];
            $return['BITRIX24_CLIENT_SECRET'] = $_ENV["BITRIX24_CLIENT_SECRET"];
        }
        return $return;
    }

    /**
     * @return string json_encode with encoding
     * @var $encoding bool true - encoding to utf8, false - decoding
     *
     * @var $data mixed
     */
    protected static function changeEncoding($data, $encoding = true): array
    {
        if (is_array($data)) {
            $result = [];
            foreach ($data as $k => $item) {
                $k = self::changeEncoding($k, $encoding);
                $result[$k] = self::changeEncoding($item, $encoding);
            }
        } else {
            if ($encoding) {
                $result = iconv(C_REST_CURRENT_ENCODING, "UTF-8//TRANSLIT", $data);
            } else {
                $result = iconv("UTF-8", C_REST_CURRENT_ENCODING, $data);
            }
        }

        return $result;
    }

    /**
     * @return string json_encode with encoding
     * @var $debag bool
     *
     * @var $data mixed
     */
    protected static function wrapData($data, $debag = false): string
    {
        if (defined('C_REST_CURRENT_ENCODING')) {
            $data = self::changeEncoding($data, true);
        }
        $return = json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_PRETTY_PRINT);

        if ($debag) {
            $e = json_last_error();
            if ($e != JSON_ERROR_NONE) {
                if ($e == JSON_ERROR_UTF8) {
                    return 'Failed encoding! Recommended \'UTF - 8\' or set define C_REST_CURRENT_ENCODING = current site encoding for function iconv()';
                }
            }
        }

        return $return;
    }

    /**
     * @return string json_decode with encoding
     * @var $debag bool
     *
     * @var $data mixed
     */
    protected static function expandData($data): array
    {
        $return = json_decode($data, true);
        if (defined('C_REST_CURRENT_ENCODING')) {
            $return = self::changeEncoding($return, false);
        }
        return $return;
    }

    /**
     * Can overridden this method to change the data storage location.
     *
     * @return bool is successes save data for setSettingData()
     * @var $arSettings array settings application
     */

    protected static function setSettingData($arSettings): bool
    {
        (file_exists(self::DIR_SECRET)) ?: mkdir(self::DIR_SECRET, 0775, true);
        return (bool)file_put_contents(self::DIR_SECRET . "secret.json", self::wrapData($arSettings));
    }
}
