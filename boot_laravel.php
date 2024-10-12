<?php

use demo\Application;
use demo\ErrorHandler;
use Illuminate\Bus\BusServiceProvider;
use Illuminate\Config\Repository;
use Illuminate\Events\EventServiceProvider;
use Illuminate\Log\LogServiceProvider;
use Illuminate\Queue\QueueServiceProvider;
use Illuminate\Redis\RedisServiceProvider;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Facade;

require __DIR__ . '/vendor/autoload.php';

function app($abstract = null, array $parameters = [])
{
    if (is_null($abstract)) {
        return Application::getInstance();
    }

    return Application::getInstance()->make($abstract, $parameters);
}

function now($tz = null)
{
    return Date::now($tz);
}

$app = app();
$config = [
    'database' => [
        'redis' => [
            'default' => [
                'host' => '192.168.0.177',
                'password' => null, // 如果有密码请设置
                'port' => 6379,
                'database' => 0,
            ],
        ],
    ],

    'queue' => [
        'default' => 'redis', // 可以选择 'database'、'redis' 或其他驱动
        'connections' => [
            'database' => [
                'driver' => 'database',
                'table' => 'jobs',
                'queue' => 'default',
                'retry_after' => 90,
            ],

            'redis' => [
                'driver' => 'redis',
                'connection' => 'default',
                'queue' => 'default',
                'retry_after' => 90,
            ],
        ],

        'failed' => [
            'database' => 'mysql',
            'table' => 'failed_jobs',
        ],
    ],

    'logging' => [
        'default' => 'single', // 默认日志通道
        'channels' => [
            'single' => [
                'driver' => 'single',
                'path' => __DIR__ . '/storage/logs/laravel.log', // 日志文件路径
                'level' => 'debug', // 日志级别
            ],
        ],
    ]
];

$config = new Repository($config);
$app->instance('config', $config);
$app->instance('app', $app);
$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    function () use ($app) {
        return new ErrorHandler($app);
    }
);

Facade::setFacadeApplication($app);
$app->registerCoreContainerAliases();

foreach ([
    EventServiceProvider::class,
    LogServiceProvider::class,
    QueueServiceProvider::class,
    RedisServiceProvider::class,
    BusServiceProvider::class,
] as $provider) {
    $app->register($provider);
}
