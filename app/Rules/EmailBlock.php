<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class EmailBlock implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    private $blackList = [
        'email@hack.net',
    ];

    public function __construct()
    {

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
        return !in_array(strtolower($value), $this->blackList);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute is locked in the system';
    }
}
