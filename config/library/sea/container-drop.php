<?php

return [
    'entityType' => [
        'dev' => 159,
        'prod' => 1044,
    ],
    'rows' => [
        'first' => 3,
    ],
    'columns' => [
        'pod' => [
            'id' => [
                'dev' => 'UF_CRM_7_POD',
                'prod' => null,
            ],
            'column' => 'A'
        ],
        'terminal' => [
            'id' => [
                'dev' => 'UF_CRM_7_TERMINAL',
                'prod' => null,
            ],
            'column' => 'B'
        ],
        'destination' => [
            'id' => [
                'dev' => 'UF_CRM_7_DESTINATION',
                'prod' => 'UF_CRM_7_DESTINATION',
            ],
            'column' => 'A'
        ],
        'contractor' => [
            'id' => [
                'dev' => 'UF_CRM_7_CONTRACTOR',
                'prod' => 'UF_CRM_7_CONTRACTOR',
            ],
            'column' => 'B'
        ],
        'cost20Dry' => [
            'id' => [
                'dev' => 'UF_CRM_7_COST_20DRY',
                'prod' => 'UF_CRM_7_COST_20DRY',
            ],
            'column' => 'C'
        ],
        'cost40Hc' => [
            'id' => [
                'dev' => 'UF_CRM_7_COST_40HC',
                'prod' => 'UF_CRM_7_COST_40HC',
            ],
            'column' => 'D'
        ],

        'priceValidFrom' => [
            'id' => [
                'dev' => 'UF_CRM_7_PRICE_VALID_FROM',
                'prod' => 'UF_CRM_7_PRICE_VALID_FROM',
            ],
            'column' => 'E'
        ],
        'priceValidTill' => [
            'id' => [
                'dev' => 'UF_CRM_7_PRICE_VALID_TILL',
                'prod' => 'UF_CRM_7_PRICE_VALID_TILL',
            ],
            'column' => 'F'
        ],
        'comment' => [
            'id' => [
                'dev' => 'UF_CRM_7_COMMENT',
                'prod' => 'UF_CRM_7_COMMENT',
            ],
            'column' => 'G'
        ],
    ],
];