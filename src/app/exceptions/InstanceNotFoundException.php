<?php

declare(strict_types=1);

namespace App\Exceptions;

class InstanceNotFoundException extends \Exception
{
    protected $message = 'Instance not found';
}
