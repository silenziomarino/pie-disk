<?php
return [
    'id' => 'app-backend-tests',
    'components' => [
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
        'request' => [
            'cookieValidationKey' => 'test',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=db;dbname=test-pie-disk',
            'username' => 'pie_user',
            'password' => '123456',
            'charset' => 'utf8',
            'enableSchemaCache' => true,
            // Продолжительность кеширования схемы.
            'schemaCacheDuration' => 3600,
            // Название компонента кеша, используемого для хранения информации о схеме
            'schemaCache' => 'cache'
        ],
    ],
];
