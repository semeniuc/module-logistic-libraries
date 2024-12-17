<?php

return [
    'entityType' => [
        'dev' => 1046,
        'prod' => 1070,
    ],
    'rows' => [
        'first' => 3,
    ],
    'columns' => [
        'pol' => [
            'id' => [
                'dev' => 'UF_CRM_8_POL',
                'prod' => 'UF_CRM_13_POL',
            ],
            'column' => 'A'
        ],
        'destination' => [
            'id' => [
                'dev' => 'UF_CRM_8_DESTINATION',
                'prod' => 'UF_CRM_13_DESTINATION',
            ],
            'column' => 'B'
        ],
        'contractor' => [
            'id' => [
                'dev' => 'UF_CRM_8_CONTRACTOR',
                'prod' => 'UF_CRM_13_CONTRACTOR',
            ],
            'column' => 'C'
        ],
        'cost20Dry' => [
            'id' => [
                'dev' => 'UF_CRM_8_COST_20DRY',
                'prod' => 'UF_CRM_13_COST_20DRY',
            ],
            'column' => 'D'
        ],
        'cost40Hc' => [
            'id' => [
                'dev' => 'UF_CRM_8_COST_40HC',
                'prod' => 'UF_CRM_13_COST_40HC',
            ],
            'column' => 'E'
        ],

        'priceValidFrom' => [
            'id' => [
                'dev' => 'UF_CRM_8_PRICE_VALID_FROM',
                'prod' => 'UF_CRM_13_PRICE_VALID_FROM',
            ],
            'column' => 'F'
        ],
        'priceValidTill' => [
            'id' => [
                'dev' => 'UF_CRM_8_PRICE_VALID_TILL',
                'prod' => 'UF_CRM_13_PRICE_VALID_TILL',
            ],
            'column' => 'G'
        ],
        'comment' => [
            'id' => [
                'dev' => 'UF_CRM_8_COMMENT',
                'prod' => 'UF_CRM_13_COMMENT',
            ],
            'column' => 'H'
        ],
    ],
];