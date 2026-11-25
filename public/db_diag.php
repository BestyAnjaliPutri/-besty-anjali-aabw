<?php
header('Content-Type: text/plain; charset=utf-8');

// Simple diagnostic script to inspect DB connection settings on Vercel
$getEnv = static function ($keys) {
    foreach ((array)$keys as $key) {
        $val = getenv($key);
        if ($val !== false && $val !== null && $val !== '') return $val;
        if (isset($_ENV[$key]) && $_ENV[$key] !== '') return $_ENV[$key];
        if (isset($_SERVER[$key]) && $_SERVER[$key] !== '') return $_SERVER[$key];
    }
    return null;
};

$host = $getEnv(['database_default_hostname', 'database.default.hostname', 'DB_HOST', 'MYSQLHOST', 'TIDB_HOST']);
$user = $getEnv(['database_default_username', 'database.default.username', 'DB_USER', 'MYSQLUSER', 'DB_USERNAME', 'TIDB_USER']);
$pass = $getEnv(['database_default_password', 'database.default.password', 'DB_PASSWORD', 'DB_PASS', 'MYSQLPASSWORD', 'TIDB_PASSWORD']);
$db   = $getEnv(['database_default_database', 'database.default.database', 'DB_DATABASE', 'DB_NAME', 'MYSQLDATABASE', 'TIDB_DATABASE']);
$port = $getEnv(['database_default_port', 'database.default.port', 'DB_PORT', 'MYSQLPORT', 'TIDB_PORT']);

echo "=== DATABASE CONFIG ON SERVER ===\n";
echo "Host: " . ($host ?: '(empty)') . "\n";
echo "Port: " . ($port ?: '3306') . "\n";
echo "Database: " . ($db ?: '(empty)') . "\n";
echo "User: " . ($user ? (substr($user, 0, 4) . '***' . substr($user, -3) . ' [length=' . strlen($user) . ']') : '(empty)') . "\n";
echo "Pass length: " . ($pass !== null ? strlen($pass) : '(null)') . "\n";

echo "\n=== ATTEMPTING RAW PDO CONNECTION ===\n";
$portNum = (int)($port ?: 3306);
$dsn = "mysql:host=$host;port=$portNum;dbname=$db;charset=utf8mb4";
try {
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 5,
    ];
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "SUCCESS! Connected to MySQL server.\n";
    $v = $pdo->query('SELECT VERSION()')->fetchColumn();
    echo "Server Version: $v\n";
} catch (Exception $e) {
    echo "PDO Error: " . $e->getMessage() . " (Code: " . $e->getCode() . ")\n";
}

// Test with SSL if TiDB
if (str_contains((string)$host, 'tidbcloud.com') || $portNum === 4000) {
    echo "\n=== ATTEMPTING TIDB SSL PDO CONNECTION ===\n";
    try {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_TIMEOUT => 5,
            PDO::MYSQL_ATTR_SSL_CA => __DIR__ . '/../app/Config/isrgrootx1.pem',
            PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
        ];
        $pdo = new PDO($dsn, $user, $pass, $options);
        echo "SUCCESS! Connected via TiDB SSL.\n";
    } catch (Exception $e) {
        echo "TiDB SSL Error: " . $e->getMessage() . "\n";
    }
}
