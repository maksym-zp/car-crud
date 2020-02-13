<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MilageRule implements Rule
{
    const MAXVALUE = 100000;
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
        return $value <= self::MAXVALUE;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The milage can`t be more than '. self::MAXVALUE;
    }
}
