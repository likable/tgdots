<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Src\Telegram;
use Src\Message;
use Src\Models\Anekdot;
use Src\Models\Like;
use Src\Models\User;
use Src\Log;
use Src\Helper;
use Exception;

// Принимаем сообщение из Телеграма
$input = file_get_contents('php://input');

// Если нет сообщения, значит пытаются открыть страницу в браузере, редиректим на страницу ошибки
if (empty($input)) {
    header("Location: https://{$_SERVER['HTTP_HOST']}/public/404.html");
}

try {
    $msg = new Message($input);
    $tg = new Telegram();
    $anekdot = new Anekdot();
    $like = new Like();
    $user = new User();

    // Работа с пользователем - сохраняем, обновляем
    if ($user->isExist($msg->getUserId())) {
        $user->refresh($msg->getUserId());
    } else {
        $user->insertRow(
            $msg->getUserId(),
            $msg->getUserFirstName(),
            $msg->getUserLastName(),
            $msg->getUserNickName()
        );
        Log::write('Добавлен новый пользователь с id: ' . $msg->getUserId() . "\nЛог сообщения:\n" . $msg->getRaw());
    }

    if ($msg->isCallback()) {
        $callbackData = $msg->getCallbackDataAsObject();

        // Запись реакции пользователя, но только если её нет для этого анекдота в течение последних суток
        if (!$like->isLikeExist($msg->getUserId(), (int) $callbackData->anekdot_id)) {
            $like->insertRow($msg->getUserId(), (int) $callbackData->anekdot_id, (int) $callbackData->score);
        }

        $count = $anekdot->getCount();
        $randomId = rand(1, $count);
        $text = $anekdot->getById($randomId, true);
        $buttons = Helper::getAnekdotReactionButtons($randomId);

        $result = $tg->sendMessageWithInlineButtons($msg->getUserId(), $text, $buttons);

        // Отправка ошибки разработчику
        if ($result['ok'] === false) {
            $tg->sendMessage($tg->getOwnerId(), "REASON: {$result['error_code']} {$result['description']}");
        }

        exit;
    }

    if (in_array($msg->getTextToLower(), ['/start', 'anekdot', 'анекдот'])) {
        $count = $anekdot->getCount();
        $randomId = rand(1, $count);
        $text = $anekdot->getById($randomId, true);
        $buttons = Helper::getAnekdotReactionButtons($randomId);

        $tg->sendMessageWithInlineButtons($msg->getUserId(), $text, $buttons);
        exit;
    }

    if ($msg->getTextToLower() === '/help') {
        $tg->sendMessage($msg->getUserId(), 'Введите /start для получения анекдота, после нажмите на кнопку эмоции, соответствующую анекдоту');
        exit;
    }

    // default
    $tg->sendMessage($msg->getUserId(), 'Доступные команды: /start /help');
} catch (Exception $e) {
    Log::write($e->getMessage(), 'errors-');
}


