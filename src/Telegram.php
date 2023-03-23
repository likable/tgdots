<?php

declare(strict_types=1);

namespace Src;

use Symfony\Component\Dotenv\Dotenv;

final class Telegram
{
    private $ch;
    private $token;
    private $ownerId;
    private $pathToScrypt;

    public function __construct()
    {
        $dotenv = new Dotenv(true);
        $dotenv->load(__DIR__ . '/../.env');

        $this->token = getenv('TG_TOKEN');
        $this->ownerId = getenv('TG_OWNER_ID');
        $this->pathToScrypt = getenv('TG_PATH_TO_SCRYPT');

        $this->ch = curl_init();

        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 30);
    }

    public function __destruct()
    {
        curl_close($this->ch);
    }

    public function getOwnerId()
    {
        return $this->ownerId;
    }

    /** Отправка произвольной команды методом GET */
    private function sendGetCommand(string $command)
    {
        $url = 'https://api.telegram.org/bot' . $this->token . $command;

        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_HTTPGET, true);

        $result = curl_exec($this->ch);

        return empty($result) ? null : json_decode($result, true);
    }

    /** Отправка произвольной команды методом POST */
    private function sendPostCommand(string $command, array $data)
    {
        $url = 'https://api.telegram.org/bot' . $this->token . $command;

        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data);

        $result = curl_exec($this->ch);

        return empty($result) ? null : json_decode($result, true);
    }

    // ----------[ GET commands ]----------

    /** Получить информацию о вебхуке */
    public function getHook()
    {
        return $this->sendGetCommand('/getWebhookInfo');
    }

    /** Установить вебхук */
    public function setHook(string $pathToScrypt)
    {
        return $this->sendGetCommand("/setWebhook?url={$pathToScrypt}");
    }

    // ----------[ POST commands ]----------

    /** Отправить простое сообщение */
    public function sendMessage(int $chatId, string $text)
    {
        $data = [
            'chat_id'    => $chatId,
            'text'       => $text,
            'parse_mode' => 'HTML'
        ];

        return $this->sendPostCommand('/sendMessage', $data);
    }

    /**
     * Отправить сообщение с кнопками ответа (внизу экрана)
     *
     * $buttons = [
     *     [
     *         ['text' => 'text-1'],
     *         ['text' => 'text-2'],
     *     ]
     * ];
     */
    public function sendMessageWithReplyButtons(int $chatId, string $text, array $buttons)
    {
        $keyboard = [
            'keyboard'          => $buttons,
            'resize_keyboard'   => true,
            'one_time_keyboard' => true,
        ];

        $data = [
            'chat_id'      => $chatId,
            'text'         => $text,
            'parse_mode'   => 'HTML',
            'reply_markup' => json_encode($keyboard),
        ];

        return $this->sendPostCommand('/sendMessage', $data);
    }

    /**
     * Отправить сообщение с инлайн-кнопками ответа (под сообщением)
     *
     * $buttons = [
     *     [
     *         ['text' => 'text-1', 'callback_data' => 'data-1'],
     *         ['text' => 'text-2', 'callback_data' => 'data-2'],
     *     ]
     * ];
     */
    public function sendMessageWithInlineButtons(int $chatId, string $text, array $buttons)
    {
        $keyboard = [
            'inline_keyboard' => $buttons,
        ];
        
        $data = [
            'chat_id'      => $chatId,
            'text'         => $text,
            'parse_mode'   => 'HTML',
            'reply_markup' => json_encode($keyboard),
        ];

        return $this->sendPostCommand('/sendMessage', $data);
    }
}