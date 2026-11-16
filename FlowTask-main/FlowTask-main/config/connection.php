<?php
// Neon/PostgreSQL configuration.
// Set DATABASE_URL in your environment to the value from your Neon project.
// Example: DATABASE_URL=postgresql://<user>:<password>@<host>/<dbname>?sslmode=require

$databaseUrl = getenv('DATABASE_URL');

if (!$databaseUrl) {
    die('Missing DATABASE_URL. Add your Neon PostgreSQL connection string to the environment before starting the app.');
}

$parsed = parse_url($databaseUrl);
if ($parsed === false || empty($parsed['host']) || empty($parsed['path'])) {
    die('Invalid DATABASE_URL. Use the PostgreSQL connection string from your Neon project.');
}

$host = $parsed['host'];
$port = $parsed['port'] ?? 5432;
$dbname = ltrim($parsed['path'], '/');
$user = $parsed['user'] ?? '';
$pass = $parsed['pass'] ?? '';

$conn = pg_connect(sprintf(
    'host=%s port=%d dbname=%s user=%s password=%s sslmode=require',
    $host,
    $port,
    $dbname,
    $user,
    $pass
));

if (!$conn) {
    die('Neon connection failed: ' . pg_last_error());
}
?>
