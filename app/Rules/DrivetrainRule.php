<?php

namespace App\Rules;

use App\Models\Car;
use Illuminate\Contracts\Validation\Rule;

class DrivetrainRule implements Rule
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
        return in_array($value, Car::DRIVETRAIN) || $value === 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'There is no such option of drivetrain';
    }
}
