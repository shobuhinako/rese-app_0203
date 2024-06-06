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
    protected $userExists;

    public function __construct($email)
    {
        $this->email = $email;
        $this->userExists = User::where('email', $this->email)->exists();
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
        if (!$this->userExists) {
            return false;
        }

        return (new User)->where('email', $this->email)->whereNotNull('email_verified_at')->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if (!$this->userExists) {
            return '登録情報が見つかりません。';
        }

        return '本人確認が完了していません。';
    }
}
