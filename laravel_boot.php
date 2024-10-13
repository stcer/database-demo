<?php

use demo\Application;
use demo\ErrorHandler;
use Illuminate\Bus\BusServiceProvider;
use Illuminate\Cache\CacheServiceProvider;
use Illuminate\Config\Repository;
use Illuminate\Database\DatabaseServiceProvider;
use Illuminate\Events\EventServiceProvider;
use Illuminate\Filesystem\FilesystemServiceProvider;
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

if (! function_exists('config')) {
    function config($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('config');
        }

        if (is_array($key)) {
            return app('config')->set($key);
        }

        return app('config')->get($key, $default);
    }
}

if (! function_exists('rescue')) {
    function rescue(callable $callback, $rescue = null, $report = true)
    {
        try {
            return $callback();
        } catch (Throwable $e) {
            if (value($report, $e)) {
//                report($e);
            }

            return value($rescue, $e);
        }
    }
}

$app = app();
$config = [
    'app' => 'dev',
    'database' => [
        'redis' => [
            'default' => [
                'host' => '192.168.0.177',
                'password' => null, // 如果有密码请设置
                'port' => 6379,
                'database' => 0,
            ],
        ],
        'default' => env('DB_CONNECTION', 'sqlite'),
        'connections' => [
            'sqlite' => [
                'driver' => 'sqlite',
                'url' => env('DATABASE_URL'),
                'database' => env('DB_DATABASE', __DIR__ . '/storage/db.sqlite'),
                'prefix' => '',
                'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
            ],
            'mysql' => [
                'driver' => 'mysql',
                'url' => env('DATABASE_URL'),
                'host' => env('DB_HOST', '127.0.0.1'),
                'port' => env('DB_PORT', '3306'),
                'database' => env('DB_DATABASE', 'forge'),
                'username' => env('DB_USERNAME', 'forge'),
                'password' => env('DB_PASSWORD', ''),
                'unix_socket' => env('DB_SOCKET', ''),
                'charset' => 'utf8mb4',
                'collation' => null,
                'prefix' => '',
                'prefix_indexes' => true,
                'strict' => true,
                'engine' => null,
            ]
        ]
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
$app->registers([
    EventServiceProvider::class,
    FilesystemServiceProvider::class,
    LogServiceProvider::class,
    QueueServiceProvider::class,
    RedisServiceProvider::class,
    BusServiceProvider::class,
    DatabaseServiceProvider::class,
    CacheServiceProvider::class
]);