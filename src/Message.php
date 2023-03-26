<?php

declare(strict_types=1);

namespace Src;

use stdClass;
use RuntimeException;

final class Message
{
    private $raw;
    private $userId;
    private $userFirstName;
    private $userLastName;
    private $userNickName;
    private $date;
    private $text;
    private $isBot = false;
    private $isCallback = false;
    private $callbackData;

    public function __construct(string $message)
    {
        $this->raw = $message;

        $data = json_decode($message);

        if (!empty($data->message)) {
            if (empty($data->message->from->id)) {
                throw new RuntimeException("Сообщение без userId!\n{$message}");
            }

            $this->userId = $data->message->from->id;
            $this->userFirstName = $data->message->from->first_name ?? null;
            $this->userLastName = $data->message->from->last_name ?? null;
            $this->userNickName = $data->message->from->username ?? null;

            $this->isBot = $data->message->from->is_bot ?? false;
            $this->date = $data->message->date ?? null;
            $this->text = $data->message->text ?? null;
        } elseif (!empty($data->callback_query)) {
            if (empty($data->callback_query->from->id)) {
                throw new RuntimeException("Коллбэк-сообщение без userId!\n{$message}");
            }

            $this->isCallback = true;
            $this->callbackData = $data->callback_query->data ?? null;

            $this->userId = $data->callback_query->from->id;
            $this->userFirstName = $data->callback_query->from->first_name ?? null;
            $this->userLastName = $data->callback_query->from->last_name ?? null;
            $this->userNickName = $data->callback_query->from->username ?? null;

            $this->isBot = $data->callback_query->from->is_bot ?? false;
            $this->date = $data->callback_query->message->date ?? null;
        }
    }

    public function getRaw(): string
    {
        return $this->raw;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getUserFirstName(): ?string
    {
        return $this->userFirstName;
    }

    public function getUserLastName(): ?string
    {
        return $this->userLastName;
    }

    public function getUserNickName(): ?string
    {
        return $this->userNickName;
    }

    public function getDate(): ?int
    {
        return $this->date;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function getTextToLower(): string
    {
        return mb_strtolower(trim((string) $this->text), 'UTF-8');
    }

    public function isBot(): bool
    {
        return $this->isBot;
    }

    public function isCallback(): bool
    {
        return $this->isCallback;
    }

    public function getCallbackData(): ?string
    {
        return $this->callbackData;
    }

    public function getCallbackDataAsObject(): ?stdClass
    {
        if (empty($this->callbackData)) {
            return null;
        }

        return json_decode((string) $this->callbackData);
    }
}