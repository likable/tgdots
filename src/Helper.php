<?php

declare(strict_types=1);

namespace Src;

final class Helper
{
    public static function getAnekdotReactionButtons(int $anekdotId = 0): array
    {
        return [
            [
                ['text' => hex2bin('F09FA4A6E2808DE29982EFB88F'), 'callback_data' => '{"score":1,"anekdot_id":' . $anekdotId . '}'],
                ['text' => hex2bin('F09F9890'), 'callback_data' => '{"score":2,"anekdot_id":' . $anekdotId . '}'],
                ['text' => hex2bin('F09F988A'), 'callback_data' => '{"score":3,"anekdot_id":' . $anekdotId . '}'],
                ['text' => hex2bin('F09F9884'), 'callback_data' => '{"score":4,"anekdot_id":' . $anekdotId . '}'],
                ['text' => hex2bin('F09F9882'), 'callback_data' => '{"score":5,"anekdot_id":' . $anekdotId . '}'],
            ]
        ];
    }
}