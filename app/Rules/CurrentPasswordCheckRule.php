<?php

namespace App\Rules;

use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

class CurrentPasswordCheckRule implements Rule
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
        return Hash::check($value, auth()->user()->password);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $lang = App::getLocale();
        // If user is logged in
        if (Auth::check())
        {
            // Get the user specific language
            // $lang = Auth::user()->language;
        }
        if ($lang == 'tw') {
            return __('當前密碼字段與您的密碼不匹配');
        } else if ($lang == 'ch') {
            return __('当前密码字段与您的密码不匹配');
        } else {
            return __('The current password field does not match your password');
        }
    }
}
