<?php

namespace App\Utils;
use DateTime;

class StringUtils
{
    static function  monthNumberToName(int $month): string
    {
        return DateTime::createFromFormat('!m', $month)->format('F');
    }
}