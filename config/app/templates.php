<?php

return [
    'sea' => [
        'template' => 'sea-template.xlsx',
        'sheets' => [
            'sea' => 'Фрахт',
            'sea-with-service' => 'Фрахт сквозным сервисом',
            'sea-with-drop' => 'Фрахт с дропом',
            'container-drop' => 'Дроп контейнеров',
            'container-rent' => 'Аренда контейнеров',
        ],
    ],
    'train' => [
        'template' => 'train-template.xlsx',
        'sheets' => [
            'train' => 'ЖД',
            'train-alternative' => 'ЖД альтернатива',
        ],
    ],
    'train-service' => [
        'template' => 'train-service-template.xlsx',
        'sheets' => [
            'train-service' => 'ЖД Сквозные сервисы',
        ],
    ],
    'auto' => [
        'template' => 'auto-template.xlsx',
        'sheets' => [
            'auto' => 'АВТОДОСТАВКА',
        ],
    ],
];