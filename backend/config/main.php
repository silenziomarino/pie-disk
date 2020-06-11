<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'language' => 'ru',
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log', 'db'],
    'modules' => [
        'api' => [
            'class' => backend\modules\api\Api::class,
        ],
        'base' => [
            'class' => backend\modules\base\Base::class,
        ],
        'helpers' => [
            'class' => backend\modules\helpers\Helpers::class,
        ],
//        'gii' => [
//            'class' => \yii\gii\Module::className(),
//            'allowedIPs' => ['*']
//        ]
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],

        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=db;dbname=pie-disk',
            'username' => 'pie_user',
            'password' => '123456',
            'charset' => 'utf8',
            'enableSchemaCache' => true,
            // Продолжительность кеширования схемы.
            'schemaCacheDuration' => 3600,
            // Название компонента кеша, используемого для хранения информации о схеме
            'schemaCache' => 'cache'
        ],
        'user' => [
            'class' => backend\modules\base\components\User::class,
            'identityClass' => backend\modules\base\models\Entity\User::class,
            'enableAutoLogin' => false,
            'loginUrl' => ['/base/user/login']
        ],
        'urlManager' => [
            'class' => \yii\web\UrlManager::class,
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => 'base/home/index',
                ['class' => 'yii\rest\UrlRule','controller' => 'api/v1/type-file','pluralize' => false],
                ['class' => 'yii\rest\UrlRule','controller' => 'api/v1/teg','pluralize' => false],
                ['class' => 'yii\rest\UrlRule','controller' => 'api/v1/file','pluralize' => false],
            ]
        ],
        'assetManager' => [
            'appendTimestamp' => true,
        ],
        'errorHandler' => [
            'class' => \yii\web\ErrorHandler::class,
            'errorAction' => 'base/home/error',
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@backend/modules/base/views'
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',  // Подключаем файловое кэширование данных
        ],
        'authManager' => [
            'class' => \yii\rbac\DbManager::class,
            'cache' => 'cache' //Включаем кеширование
        ],
        'mailer' => [
            'class' => \yii\swiftmailer\Mailer::class,
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'encryption' => 'tls',
                'host' => 'smtp.gmail.com',
                'port' => '587',
                'username' => '', //todo введите email адрес google что бы работало подтверждение регистрации пользователей
                'password' => '', //todo введите пароль email`а что бы работало подтверждение регистрации пользователей
            ],
        ],
    ],
    'params' => $params,
];
