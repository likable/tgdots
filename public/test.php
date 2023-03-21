<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv(true);
$dotenv->load(__DIR__ . '/../.env');

$dbUser = getenv('DB_USER');
echo "User: {$dbUser} <br>";
