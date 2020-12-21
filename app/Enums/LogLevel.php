<?php

declare(strict_types=1);

namespace App\Enums;

class LogLevel extends BaseEnum
{
    const DEBUG = 1;

    const INFO = 2;

    const WARNING = 3;

    const ERROR = 4;

    const ALERT = 5;
}
