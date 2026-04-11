<?php

session_start();

define('BASE_PATH', __DIR__);

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require_once BASE_PATH . '/config/database.php';
require_once BASE_PATH . '/routes/router.php';