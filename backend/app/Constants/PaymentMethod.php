<?php

namespace App\Constants;

class PaymentMethod
{
    public const STRIPE = 'stripe';
    public const PAYPAL = 'paypal';
    public const CASH_ON_DELIVERY = 'cod';

    public static function all(): array
    {
        return [self::STRIPE, self::PAYPAL, self::CASH_ON_DELIVERY];
    }
}
