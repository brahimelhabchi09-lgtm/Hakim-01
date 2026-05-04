<?php

namespace App\Constants;

class ProductStatus
{
    public const ACTIF = 'actif';
    public const INACTIF = 'inactif';
    public const RUPTURE = 'rupture';

    public static function all(): array
    {
        return [self::ACTIF, self::INACTIF, self::RUPTURE];
    }
}
