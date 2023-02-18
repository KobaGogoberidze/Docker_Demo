<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\Interfaces\CommunicationInterface;

class SmsService implements CommunicationInterface
{
    public function send(array $to, string $template): bool
    {
        sleep(1);

        return true;
    }
}
