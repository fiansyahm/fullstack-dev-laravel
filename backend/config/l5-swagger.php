<?php
return [
    'default' => 'default',
    'documentations' => [
        'default' => [
            'api' => [
                'title' => 'User Management API',
                'version' => '1.0.0',
                'description' => 'API for managing users in the Fullstack Evaluation Project',
            ],
            'routes' => [
                'api' => 'api/documentation',
            ],
        ],
    ],
    'generate_always' => env('L5_SWAGGER_GENERATE_ALWAYS', false),
    'swagger_version' => env('SWAGGER_VERSION', '3.0'),
    'persist_api' => true,
    'proxy' => false,
    'additional_config_url' => null,
    'operations_sort' => null,
    'validates_definitions' => true,
    'paths' => [
        'docs' => storage_path('api-docs'),
        'docs_json' => 'api-docs.json',
        'docs_yaml' => 'api-docs.yaml',
        'annotations' => base_path('app'),
        'excludes' => [],
        'views' => resource_path('views/vendor/l5-swagger'),
    ],
    'securityDefinitions' => [
        'securitySchemes' => [],
        'security' => [],
    ],
    'constants' => [
        'L5_SWAGGER_CONST_HOST' => env('L5_SWAGGER_CONST_HOST', 'http://localhost:8000'),
    ],
];