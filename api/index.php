<?php

/**
 * ==============================================================================
 * Vercel Serverless PHP Entrypoint for CodeIgniter 4
 * ==============================================================================
 */

// If behind Vercel SSL reverse proxy, ensure HTTPS flag is recognized
if ((isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
    || getenv('VERCEL') || isset($_SERVER['VERCEL'])) {
    $_SERVER['HTTPS'] = 'on';
    $_SERVER['SERVER_PORT'] = 443;
}

// On Vercel, ensure writable subdirectories exist in /tmp
if (getenv('VERCEL') || isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL'])) {
    $writableDirs = ['cache', 'session', 'logs', 'debugbar', 'uploads'];
    foreach ($writableDirs as $dir) {
        $path = '/tmp/' . $dir;
        if (!is_dir($path)) {
            @mkdir($path, 0777, true);
        }
    }
}

// Forward execution to CodeIgniter 4 Front Controller in public/index.php
require __DIR__ . '/../public/index.php';
