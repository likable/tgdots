<?php

declare(strict_types=1);

namespace Src\Models;

use PDO;
use Src\DB;

final class User
{
    public const TABLE_NAME = 'users';

    /** @var PDO $pdo */
    private $pdo;

    public function __construct()
    {
        $this->pdo = DB::getPDO();
    }

    public function insertRow(int $telegramId, ?string $firstName, ?string $lastName, ?string $nickName): void
    {
        $query = 'INSERT INTO ' . self::TABLE_NAME . ' (telegram_id, first_name, last_name, nick_name) VALUES (?, ?, ?, ?)';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$telegramId, $firstName, $lastName, $nickName]);
    }

    /** Обновить дату последнего запроса пользователя updated_at */
    public function refresh(int $telegramId): void
    {
        $query = 'UPDATE ' . self::TABLE_NAME . ' SET updated_at = NOW() WHERE telegram_id = ?';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$telegramId]);
    }

    /** Существует ли пользователь в таблице */
    public function isExist(int $telegramId)
    {
        $query = 'SELECT id FROM ' . self::TABLE_NAME . ' WHERE telegram_id = ? LIMIT 1';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$telegramId]);

        return (bool) $stmt->fetchColumn();
    }
}