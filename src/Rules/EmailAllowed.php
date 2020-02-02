<?php

namespace LSurma\LaravelBlacklist\Rules;

use App\UserAuth\Models\Blacklist;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use LSurma\LaravelBlacklist\Consts\Type;
use LSurma\LaravelBlacklist\LaravelBlacklistServiceProvider;

class EmailAllowed implements Rule
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
        $emailDomain = Str::afterLast($value, "@");
        $model = LaravelBlacklistServiceProvider::getBlacklistModel();

        $domainBlacklisted = $model::whereType(Type::EMAIL_DOMAIN)->whereValue($emailDomain)->exists();
        $emailBlacklisted = $model::whereType(Type::EMAIL)->whereValue($value)->exists();
        
        return !$domainBlacklisted && !$emailBlacklisted;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return Lang::get('blacklist::validation.email');
    }
}