<?php

namespace App\Constants;

class PaymentStatus
{
    public const PENDING = 'pending';
    public const COMPLETED = 'completed';
    public const FAILED = 'failed';
    public const REFUNDED = 'refunded';

    public static function all(): array
    {
        return [self::PENDING, self::COMPLETED, self::FAILED, self::REFUNDED];
    }
}
