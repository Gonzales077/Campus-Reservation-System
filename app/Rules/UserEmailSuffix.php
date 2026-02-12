<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UserEmailSuffix implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Allow admin@admin email
        if ($value === 'admin@admin') {
            return;
        }

        // Check if email ends with @user
        if (!str_ends_with($value, '@user')) {
            $fail('The ' . $attribute . ' must end with @user (e.g., john.doe@user)');
        }
    }
}
