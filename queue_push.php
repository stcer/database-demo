<?php

use demo\MyDelayedJob;
use Illuminate\Support\Facades\Queue;

require_once __DIR__ . '/laravel_boot.php';

// 创建作业实例并推送到队列
$job = new MyDelayedJob(['key' => 'value']);

// 将作业推送到队列
/** @var Illuminate\Queue\QueueManager $queue */
$queue = app('queue');
$conn = $queue->connection();
$conn->push($job);

// Delay job
Queue::later(now()->addSeconds(10), new MyDelayedJob(['Queue::later']));

// dispatch Delay job
MyDelayedJob::dispatch(["MyDelayedJob::dispatch"])
    ->delay(now()->addSeconds(5))
    ->onConnection('redis')
    ->onQueue('default')
;
