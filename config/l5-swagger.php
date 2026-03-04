<?php

return [
    'default' => 'default',
    'documentations' => [
        'default' => [
            'api' => ['title' => 'API Management Portal'],
            'routes' => ['api' => 'api/documentation'],
            'paths' => [
                'use_absolute_path' => false,
                'docs_json' => 'api-docs.json',
                'annotations' => [base_path('app'), base_path('routes')],
            ],
        ],
    ],
];
