<?php
// All subprocesses inherit synthetic configuration; run in a network-disabled container.
function check(bool $condition, string $label): void {
    if (!$condition) { throw new RuntimeException($label); }
}
function unavailable_response(array $environment): string {
    $code = 'register_shutdown_function(function () { echo "|STATUS=" . http_response_code(); }); require ' . var_export(__DIR__ . '/../db.php', true) . ';';
    $process = proc_open([PHP_BINARY, '-r', $code], [0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w']], $pipes, null, $environment);
    fclose($pipes[0]);
    $output = stream_get_contents($pipes[1]);
    $errors = stream_get_contents($pipes[2]);
    fclose($pipes[1]); fclose($pipes[2]);
    proc_close($process);
    check(!str_contains($output . $errors, 'synthetic-private-value'), 'Credentials must never be printed');
    return $output;
}
check(unavailable_response(['DB_USER' => '', 'DB_PASSWORD' => '']) === 'Database service unavailable.|STATUS=503', 'Missing credentials must fail with a safe HTTP503 response');
require __DIR__ . '/../database_config.php';
foreach (['DB_USER', 'DB_PASSWORD'] as $missing) {
    putenv('DB_USER=synthetic'); putenv('DB_PASSWORD=synthetic-private-value');
    putenv($missing . '=   ');
    try { database_config(); throw new LogicException('Missing field accepted'); }
    catch (RuntimeException $e) { check(!($e instanceof LogicException), 'Blank credential rejected'); }
}
putenv('DB_USER=synthetic'); putenv('DB_PASSWORD=synthetic-private-value');
putenv('DB_HOST=localhost'); putenv('DB_NAME=synthetic');
$config = database_config();
check($config['user'] === 'synthetic' && $config['password'] === 'synthetic-private-value', 'Configured credentials must be preserved');
check($config['dsn'] === 'mysql:host=localhost;dbname=synthetic;charset=utf8mb4', 'DSN and Unicode charset');
check(unavailable_response(['DB_USER' => 'synthetic', 'DB_PASSWORD' => 'synthetic-private-value', 'DB_HOST' => '127.0.0.1', 'DB_NAME' => 'synthetic']) === 'Database service unavailable.|STATUS=503', 'Unavailable isolated DB must not leak PDO details');
echo "PASS: missing/blank config, configured credentials/charset, safe connection failure, no credential output\n";
