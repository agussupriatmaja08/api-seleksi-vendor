<?php

use Dedoc\Scramble\Http\Middleware\RestrictedDocsAccess;

return [
    'api_path' => 'api',
    'api_domain' => null,
    'export_path' => 'api.json',

    'info' => [
        'version' => env('API_VERSION', '0.0.1'),
        'description' => '',
    ],

    'ui' => [
        // ... (semua konfigurasi UI Anda tetap sama) ...
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

    // -----------------------------------------------------------------
    // [PERBAIKAN 1] TAMBAHKAN BLOK 'security' INI
    // -----------------------------------------------------------------
    'security' => [
        'schemes' => [
            'BearerAuth' => [ // Beri nama skema Anda
                'type' => 'http',
                'scheme' => 'bearer',
                'bearerFormat' => 'JWT',
                'description' => 'Otentikasi JWT (Bearer Token)',
            ],
        ],
    ],

    // -----------------------------------------------------------------
    // [PERBAIKAN 2] KEMBALIKAN BLOK 'middleware' KE ASLINYA
    // -----------------------------------------------------------------
    'middleware' => [
        'web',
        RestrictedDocsAccess::class,
    ],

    'extensions' => [],

    // (Pastikan tidak ada 'security_schemes' lain di bagian bawah file)
];