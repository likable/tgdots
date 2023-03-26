<?php

declare(strict_types=1);

namespace Src\Models;

use PDO;
use Src\DB;

final class Like
{
    public const TABLE_NAME = 'likes';

    /** @var PDO $pdo */
    private $pdo;

    public function __construct()
    {
        $this->pdo = DB::getPDO();
    }

    public function insertRow(int $telegramId, int $anekdotId, int $score): void
    {
        $query = 'INSERT INTO ' . self::TABLE_NAME . ' (telegram_id, anekdot_id, score) VALUES (?, ?, ?)';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$telegramId, $anekdotId, $score]);
    }

    /**
     * Проверка наличия реакции пользователя по конкретному анекдоту за последнее время, указанное в $period
     *
     * @param int $telegramId UserId в Телеграме
     * @param int $anekdotId
     * @param int $period Время в секундах относительно текущего времени в течение которого идёт проверка
     * @return bool
     */
    public function isLikeExist(int $telegramId, int $anekdotId, int $period = 86400): bool
    {
        $query = 'SELECT id FROM ' . self::TABLE_NAME . ' WHERE telegram_id = ? AND anekdot_id = ? AND created_at > NOW() - INTERVAL ? SECOND LIMIT 1';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$telegramId, $anekdotId, $period]);

        return (bool) $stmt->fetchColumn();
    }
}