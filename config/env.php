<?php

$config_env = parse_ini_file(BASE_PATH . '/.env');

return [
    'DB_HOST' => $config_env['DB_HOST'] ?? 'localhost',
    'DB_NAME' => $config_env['DB_NAME'] ?? '',
    'DB_USER' => $config_env['DB_USER'] ?? '',
    'DB_PASS' => $config_env['DB_PASS'] ?? '',
];