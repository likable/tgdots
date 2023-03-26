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

    public function getCount(): int
    {
        $query = 'SELECT COUNT(*) FROM ' . self::TABLE_NAME;
        $stmt = $this->pdo->query($query);

        return (int) $stmt->fetchColumn();
    }

    public function getById(int $id, bool $isForTelegram = false)
    {
        $query = 'SELECT anekdot FROM ' . self::TABLE_NAME . ' WHERE id = ? LIMIT 1';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id]);

        $text = $stmt->fetchColumn();

        // Телеграм пропускает только: <b>, <i>, <a>, <code>, <pre>; <br> вызывает ошибку, перенос строки осуществляется через \n
        if ($isForTelegram) {
            $text = str_replace("<br>", "\n", $text);
        }

        return $text;
    }

    /**
     * @param int $count Количество анекдотов, которое нужно получить в ответе
     * @param bool $isDebugMode В случае true будет вывод всех полей запроса
     * @return array[]
     */
    public function getTop(int $count = 10, bool $isDebugMode = false): array
    {
        $query = 'SELECT a.anekdot, l.anekdot_id, COUNT(l.id) AS likes_count, AVG(l.score) as average_score FROM ' . Like::TABLE_NAME . ' l ';
        $query .= 'LEFT JOIN ' . self::TABLE_NAME . ' a ON l.anekdot_id = a.id ';
        $query .= 'GROUP BY l.anekdot_id ORDER BY average_score DESC LIMIT ?';

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$count]);

        if ($isDebugMode) {
            return $stmt->fetchAll();
        }

        // PDO::FETCH_COLUMN - режим вывода одной колонки, 0 - индекс колонки в запросе (0 - a.anekdot, 1 - l.anekdot_id итд)
        return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }
}