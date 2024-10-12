<?php

use Illuminate\Queue\Worker;
use Illuminate\Queue\WorkerOptions;

require_once __DIR__ . '/boot_laravel.php';

// 队列 Worker 监听任务
$app = app();

/** @var Worker $worker */
$worker = $app['queue.worker'];
echo "Listening to queue... \n";

$options = new WorkerOptions();
while (true) {
    pcntl_signal_dispatch();   // 处理信号
    $worker->runNextJob('redis', 'default', $options);  // redis 连接和队列名称
}
