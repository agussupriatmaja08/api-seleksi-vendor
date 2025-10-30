<?php

use Dedoc\Scramble\Http\Middleware\RestrictedDocsAccess;

return [
    'api_path' => 'api',
    'api_domain' => null,
    'export_path' => 'api.json',
    'responses' => [
        // Tambahkan ini untuk menampilkan semua response codes
        'should_exclude_empty' => false,
    ],

    'info' => [
        'version' => env('API_VERSION', '0.0.1'),
        'description' => '',
    ],

    'ui' => [
        'title' => null,
        'theme' => 'light',
        'hide_try_it' => false,
        'hide_schemas' => false,
        'logo' => '',
        'try_it_credentials_policy' => 'include',
        'layout' => 'responsive',
    ],

    'servers' => null,
    'enum_cases_description_strategy' => 'description',
    'enum_cases_names_strategy' => false,
    'flatten_deep_query_parameters' => true,


    'security' => [
        'schemes' => [
            'BearerAuth' => [
                'type' => 'http',
                'scheme' => 'bearer',
                'bearerFormat' => 'JWT',
                'description' => 'Otentikasi JWT (Bearer Token)',
            ],
        ],
    ],


    'middleware' => [
        'web',
        RestrictedDocsAccess::class,
    ],

    'extensions' => [],




];