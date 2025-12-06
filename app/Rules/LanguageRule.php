<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class LanguageRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^[А-Яа-яЁё\s]+$/u', $value)) {
            $fail(':attribute : Текст может быть только на русском языке!');
        }
    }
}
