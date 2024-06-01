<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class EmailVerified implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $email;

    public function __construct($email)
    {
        $this->email = $email;
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
        // return User::where($attribute, $value)->whereNotNull('email_verified_at')->exists();

        return (new User)->where('email', $this->email)->whereNotNull('email_verified_at')->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '本人確認が完了していません。';
    }
}
