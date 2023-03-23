<?php

declare(strict_types=1);

namespace Src\Models;

use PDO;
use Src\DB;

final class Anekdot
{
    public const TABLE_NAME = 'anekdots';

    /** @var PDO $pdo */
    private $pdo;

    public function __construct()
    {
        $this->pdo = DB::getPDO();
    }

    public function getCount()
    {
        $query = 'SELECT COUNT(*) FROM ' . self::TABLE_NAME;
        $stmt = $this->pdo->query($query);

        return $stmt->fetchColumn();
    }

    public function getById($id)
    {
        $query = 'SELECT anekdot FROM ' . self::TABLE_NAME . ' WHERE id = ? LIMIT 1';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id]);

        return $stmt->fetchColumn();
    }

    public function getRandom()
    {
        $count = (int) $this->getCount();
        $id = rand(1, $count);
        $text = $this->getById($id);

        return compact('id', 'text');
    }
}