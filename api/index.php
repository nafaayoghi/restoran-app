<?php

// Cek apakah sedang berjalan di Vercel atau di Laptop lokal
$isVercel = isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL']);

if ($isVercel) {
    // Pengaturan khusus untuk Vercel (Serverless)
    putenv('APP_STORAGE=/tmp/storage');
    putenv('VIEW_COMPILED_PATH=/tmp/views');
    putenv('LOG_CHANNEL=stderr');
    
    $dirs = [
        '/tmp/storage',
        '/tmp/storage/app',
        '/tmp/storage/framework',
        '/tmp/storage/framework/cache',
        '/tmp/storage/framework/sessions',
        '/tmp/storage/framework/views',
        '/tmp/storage/logs',
        '/tmp/views',
    ];

    foreach ($dirs as $dir) {
        if (!is_dir($dir)) {
            @mkdir($dir, 0777, true);
        }
    }
}

require __DIR__ . '/../public/index.php';