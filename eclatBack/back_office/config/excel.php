<?php

return [
    'exports' => [
        'chunk_size' => 1000,
        'pre_calculate_formulas' => false,
        'strict_null_comparison' => false,
        'csv' => [
            'delimiter' => ',',
            'enclosure' => '"',
            'line_ending' => PHP_EOL,
            'use_bom' => false,
            'include_separator_line' => false,
            'excel_compatibility' => false,
            'output_encoding' => '',
            'test_auto_detect' => true,
        ],
        'properties' => [
            'creator' => '',
            'lastModifiedBy' => '',
            'title' => '',
            'description' => '',
            'subject' => '',
            'keywords' => '',
            'category' => '',
            'manager' => '',
            'company' => '',
        ],
    ],

    'imports' => [
        'read_only' => true,
        'ignore_empty' => false,
        'heading_row' => [
            'formatter' => 'slug',
        ],
        'csv' => [
            'delimiter' => null,
            'enclosure' => '"',
            'escape_character' => '\\',
            'contiguous' => false,
            'input_encoding' => 'UTF-8',
        ],
        'properties' => [
            'creator' => '',
            'lastModifiedBy' => '',
            'title' => '',
            'description' => '',
            'subject' => '',
            'keywords' => '',
            'category' => '',
            'manager' => '',
            'company' => '',
        ],
    ],

    'extension_detector' => [
        'xlsx' => \Maatwebsite\Excel\Enums\Xlsx::class,
        'xlsm' => \Maatwebsite\Excel\Enums\Xlsx::class,
        'xltx' => \Maatwebsite\Excel\Enums\Xlsx::class,
        'xltm' => \Maatwebsite\Excel\Enums\Xlsx::class,
        'xls' => \Maatwebsite\Excel\Enums\Xls::class,
        'xlt' => \Maatwebsite\Excel\Enums\Xls::class,
        'ods' => \Maatwebsite\Excel\Enums\Ods::class,
        'ots' => \Maatwebsite\Excel\Enums\Ods::class,
        'slk' => \Maatwebsite\Excel\Enums\Slk::class,
        'xml' => \Maatwebsite\Excel\Enums\Xml::class,
        'gnumeric' => \Maatwebsite\Excel\Enums\Gnumeric::class,
        'htm' => \Maatwebsite\Excel\Enums\Html::class,
        'html' => \Maatwebsite\Excel\Enums\Html::class,
        'csv' => \Maatwebsite\Excel\Enums\Csv::class,
        'tsv' => \Maatwebsite\Excel\Enums\Csv::class,
        'pdf' => \Maatwebsite\Excel\Enums\Pdf::class,
    ],

    'value_binder' => [
        'default' => \Maatwebsite\Excel\DefaultValueBinder::class,
    ],

    'cache' => [
        'driver' => 'memory',
        'batch' => [
            'memory_limit' => 60000,
        ],
        'illuminate' => [
            'store' => null,
        ],
    ],

    'transactions' => [
        'handler' => 'db',
        'db' => [
            'connection' => null,
        ],
    ],

    'temporary_files' => [
        'local_path' => storage_path('framework/cache/laravel-excel'),
        'remote_disk' => null,
        'remote_prefix' => null,
        'force_resync_remote' => null,
    ],
];