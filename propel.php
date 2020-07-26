<?php

$databaseHost = $_ENV['MYSQL_HOST'];
$databasePort = $_ENV['MYSQL_PORT'];
$databaseName = $_ENV['MYSQL_DATABASE'];
$databaseUser = $_ENV['MYSQL_USER'];
$databasePass = $_ENV['MYSQL_PASSWORD'];
$databaseCharset = $_ENV['MYSQL_CHARSET'];

return [
    'propel' => [
        'database' => [
            'connections' => [
                'default' => [
                    'adapter' => 'mysql',
                    'dsn' => 'mysql:host='. $databaseHost .';port='. $databasePort .';dbname='. $databaseName,
                    'user' => $databaseUser,
                    'password' => $databasePass,
                    'settings' => [
                        'charset' => $databaseCharset
                    ],
                ],
            ],
        ],
        'runtime' => [
            'defaultConnection' => 'default',
            'connections' => ['default']
        ],
        'generator' => [
            'defaultConnection' => 'default',
            'connections' => ['default']
        ],
        'paths' => [
            'schemaDir' => __DIR__,
            'outputDir' => __DIR__,
            'phpDir' => __DIR__ . '/App/Domain/Models',
            'migrationDir' => __DIR__ . '/App/Migrations',
            'sqlDir' => __DIR__ . '/App/Migrations/SQL',
        ],
    ]
];