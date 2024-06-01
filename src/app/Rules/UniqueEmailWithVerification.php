<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;


class UniqueEmailWithVerification implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        \Log::info('Validating email: ' . $value);
        $user = DB::table('users')
            ->where('email', $value)
            ->whereNotNull('email_verified_at')
            ->first();

        if ($user) {
            \Log::info('User found with email_verified_at not null: ' . $value);
        } else {
            \Log::info('No user found or email_verified_at is null: ' . $value);
        }
            return !$user;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'そのメールアドレスはすでに登録があります';
    }
}
