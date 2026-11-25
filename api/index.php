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

    // Prepare SQLite database in writable /tmp
    $sourceSqlite = __DIR__ . '/../app/Database/aabw.sqlite';
    $targetSqlite = '/tmp/aabw.sqlite';
    if (file_exists($sourceSqlite)) {
        if (!file_exists($targetSqlite) || filesize($targetSqlite) !== filesize($sourceSqlite)) {
            @copy($sourceSqlite, $targetSqlite);
            @chmod($targetSqlite, 0666);
        }
    }
}

// Backward compatibility alias for Myth:Auth on CodeIgniter 4.4+
$ciEntityPath = __DIR__ . '/../vendor/codeigniter4/framework/system/Entity/Entity.php';
if (file_exists($ciEntityPath)) {
    require_once $ciEntityPath;
    if (! class_exists('CodeIgniter\Entity', false)) {
        class_alias('CodeIgniter\Entity\Entity', 'CodeIgniter\Entity');
    }
}

// Forward execution to CodeIgniter 4 Front Controller in public/index.php
require __DIR__ . '/../public/index.php';
