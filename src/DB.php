<?php

namespace Src;

use PDO;
use Symfony\Component\Dotenv\Dotenv;

final class DB
{
    public const DB_NAME = 'anekdot';
    public const DB_CHARSET = 'utf8';

    public static function getPDO()
    {
        $dotenv = new Dotenv(true);
        $dotenv->load(__DIR__ . '/../.env');

        $host = getenv('DB_HOST');
        $username = getenv('DB_USER');
        $password = getenv('DB_PASS');
        $dbname = self::DB_NAME;
        $charset = self::DB_CHARSET;

        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        // TODO: try-catch -> log
        return new PDO($dsn, $username, $password, $options);
    }
}