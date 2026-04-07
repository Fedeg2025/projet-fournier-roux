<?php

$config_env = parse_ini_file(dirname(__DIR__) . '/.env');

$_ENV['DB_HOST'] = $config_env['DB_HOST'] ?? 'localhost';
$_ENV['DB_NAME'] = $config_env['DB_NAME'] ?? '';
$_ENV['DB_USER'] = $config_env['DB_USER'] ?? '';
$_ENV['DB_PASS'] = $config_env['DB_PASS'] ?? '';