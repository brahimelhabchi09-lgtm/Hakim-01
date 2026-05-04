<?php

namespace App\Constants;

class OrderStatus
{
    public const EN_COURS = 'en_cours';
    public const CONFIRMEE = 'confirmee';
    public const EXPEDIEE = 'expediee';
    public const LIVREE = 'livree';
    public const ANNULEE = 'annulee';

    public static function all(): array
    {
        return [
            self::EN_COURS,
            self::CONFIRMEE,
            self::EXPEDIEE,
            self::LIVREE,
            self::ANNULEE,
        ];
    }

    public static function labels(): array
    {
        return [
            self::EN_COURS => 'In Progress',
            self::CONFIRMEE => 'Confirmed',
            self::EXPEDIEE => 'Shipped',
            self::LIVREE => 'Delivered',
            self::ANNULEE => 'Cancelled',
        ];
    }
}
