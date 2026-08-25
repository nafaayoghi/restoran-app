<?php

// Aktifkan error reporting penuh agar tidak HTTP 500 polos
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Set storage dan cache path ke /tmp
putenv('APP_STORAGE=/tmp/storage');
putenv('VIEW_COMPILED_PATH=/tmp/views');
putenv('LOG_CHANNEL=stderr');
putenv('SESSION_DRIVER=array');
putenv('CACHE_STORE=array');
putenv('CACHE_DRIVER=array');
putenv('MAINTENANCE_DRIVER=cache');
putenv('MAINTENANCE_STORE=array');

$_ENV['APP_STORAGE'] = '/tmp/storage';
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/views';
$_ENV['LOG_CHANNEL'] = 'stderr';
$_ENV['SESSION_DRIVER'] = 'array';
$_ENV['CACHE_STORE'] = 'array';
$_ENV['CACHE_DRIVER'] = 'array';
$_ENV['MAINTENANCE_DRIVER'] = 'cache';
$_ENV['MAINTENANCE_STORE'] = 'array';

// Buat direktori sementara yang dibutuhkan Laravel
$dirs = [
    '/tmp/storage',
    '/tmp/storage/app',
    '/tmp/storage/framework',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
    '/tmp/views',
    '/tmp/bootstrap/cache',
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
}

// Jalankan aplikasi Laravel
require __DIR__ . '/../public/index.php';