<?php

namespace App\Enums;

enum StatusEnum: string
{
    case PAYEE = "payée";
    case IMPAYEE = "impayée";


    public static function values(): array
    {
        return [
            self::PAYEE->value,
            self::IMPAYEE->value,
        ];
    }
}
