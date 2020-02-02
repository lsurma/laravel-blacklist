<?php

namespace LSurma\LaravelBlacklist\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Lang;
use LSurma\LaravelBlacklist\Consts\Type;
use LSurma\LaravelBlacklist\LaravelBlacklistServiceProvider;

class PasswordAllowed implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $model = LaravelBlacklistServiceProvider::getBlacklistModel();

        $blacklisted = $model::whereType(Type::PASSWORD)->whereValue($value)->exists();
        
        return !$blacklisted;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return Lang::get('blacklist::validation.password');
    }
}