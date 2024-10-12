<?php

pcntl_signal(SIGALRM, function() {
    echo "SIGALRM received." . date('Y-m-d H:i:s'). "\n";
    pcntl_alarm(5);
});

pcntl_alarm(5);

// 主循环
echo "Waiting for SIGALRM signal for 5 seconds...\n";
while (true) {
    // 检查是否有信号到达
    if (pcntl_signal_dispatch()) {
        echo "Signal dispatched." . date('H:i:s'). "\n";
    }

    // 可以在这里执行其他任务
    usleep(1000000); // 暂停 100 毫秒
}
