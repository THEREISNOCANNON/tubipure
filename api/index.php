<?php

$storagePath = sys_get_temp_dir().DIRECTORY_SEPARATOR.'tubipure-storage';

$_ENV['LARAVEL_STORAGE_PATH'] = $storagePath;
$_SERVER['LARAVEL_STORAGE_PATH'] = $storagePath;

$deploymentHost = $_SERVER['VERCEL_URL'] ?? getenv('VERCEL_URL');

if (is_string($deploymentHost) && $deploymentHost !== '' && getenv('APP_URL') === false && ! isset($_ENV['APP_URL']) && ! isset($_SERVER['APP_URL'])) {
    $_ENV['APP_URL'] = 'https://'.$deploymentHost;
    $_SERVER['APP_URL'] = 'https://'.$deploymentHost;
}

if (getenv('LOG_CHANNEL') === false && ! isset($_ENV['LOG_CHANNEL']) && ! isset($_SERVER['LOG_CHANNEL'])) {
    $_ENV['LOG_CHANNEL'] = 'stderr';
    $_SERVER['LOG_CHANNEL'] = 'stderr';
}

foreach ([
    $storagePath.'/app/private',
    $storagePath.'/app/public',
    $storagePath.'/framework/cache/data',
    $storagePath.'/framework/sessions',
    $storagePath.'/framework/views',
    $storagePath.'/logs',
] as $directory) {
    if (! is_dir($directory) && ! mkdir($directory, 0775, true) && ! is_dir($directory)) {
        throw new RuntimeException(sprintf('Unable to create the Laravel runtime directory [%s].', $directory));
    }
}

require __DIR__.'/../public/index.php';
