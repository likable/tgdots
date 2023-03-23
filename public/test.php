<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;
use Src\Models\Anekdot;
use Src\Log;

$dotenv = new Dotenv(true);
$dotenv->load(__DIR__ . '/../.env');

$dbUser = getenv('DB_USER');

echo date('H:i:s l') . "<br><br>";


$anekdot = new Anekdot();
$randomAnekdot = $anekdot->getRandom()['text'];
echo $randomAnekdot;

Log::make($randomAnekdot);

//print_r($anekdot->getRandom());
