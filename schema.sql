CREATE DATABASE IF NOT EXISTS anekdot
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;

USE anekdot;

CREATE TABLE IF NOT EXISTS anekdots (
    id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    anekdot      TEXT NOT NULL,
    anekdot_hash VARCHAR(40) NOT NULL UNIQUE,
    tag_values   VARCHAR(128) NOT NULL -- поле удобно для парсинга, если буду использовать теги, создать таблицу соответствий anekdot_tags
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS likes (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    telegram_id BIGINT UNSIGNED NOT NULL,
    anekdot_id  INT UNSIGNED NOT NULL,
    score       TINYINT UNSIGNED NOT NULL, -- оценка от 1 до 5
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX telegram_id_index (telegram_id),
    INDEX anekdot_id_index (anekdot_id),
    INDEX score_index (score)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS users (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    telegram_id BIGINT UNSIGNED NOT NULL,
    first_name  VARCHAR(128),
    last_name   VARCHAR(128),
    nick_name   VARCHAR(128),
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP, -- последний запрос к боту
    INDEX telegram_id_index (telegram_id)
) ENGINE = InnoDB;
