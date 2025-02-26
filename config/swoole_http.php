<?php

return [
    'server' => [
        'host' => '0.0.0.0',
        'port' => 8010,
        'options' => [
            'worker_num' => swoole_cpu_num(),
            'task_worker_num' => swoole_cpu_num(),
            'daemonize' => false,
            'log_file' => storage_path('logs/swoole.log'),
            'log_level' => SWOOLE_LOG_INFO,
        ],
    ],
    'providers' => [
        SwooleTW\Http\LumenServiceProvider::class,
    ],
];
