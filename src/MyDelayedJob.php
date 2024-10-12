<?php

namespace demo;

use demo\Bus\Dispatchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MyDelayedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function handle()
    {
        // 处理任务逻辑
        echo date("Y-m-d H:i:s\n");
        echo '处理延时任务：' . "\n";
        var_dump($this->data);
        Log::info('处理延时任务：', $this->data);
        echo "\n";
    }
}
