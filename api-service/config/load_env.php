<?php

declare(strict_types=1);

use Dotenv\Dotenv;

// Detect env (dev|prod|test)
$env = $_ENV['APP_ENV'] ?? $_SERVER['APP_ENV'] ?? 'dev';
$envFile = '.env.' . $env;

$dotenv = Dotenv::createImmutable(BASE_DIR, $envFile);
$dotenv->load();
