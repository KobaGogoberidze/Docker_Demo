<?php

declare(strict_types=1);

namespace App\Services;

class SmsService
{
    public function send(array $to, string $template): bool
    {
        sleep(1);

        return true;
    }
}
