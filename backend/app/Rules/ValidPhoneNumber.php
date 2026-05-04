<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidPhoneNumber implements Rule
{
    public function passes($attribute, $value): bool
    {
        return preg_match('/^\+?[0-9\s\-()]{8,20}$/', $value);
    }

    public function message(): string
    {
        return 'The :attribute must be a valid phone number.';
    }
}
