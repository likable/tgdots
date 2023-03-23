<?php

declare(strict_types=1);

namespace Src;

final class Log
{
    public static function make(string $text): void
    {
        $fileName = __DIR__ . '/../logs/' . date('d-m-Y') . '.log';
        $text = date('[H:i:s]') . "\n{$text}\n\n";

        file_put_contents($fileName, $text, FILE_APPEND);
    }
}