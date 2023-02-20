<?php

declare(strict_types=1);

namespace App;

abstract class Model
{
    protected DB $DB;

    public function __construct()
    {
        $this->DB = App::getDB();
    }
}
