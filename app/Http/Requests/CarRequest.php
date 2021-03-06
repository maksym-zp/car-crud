<?php

namespace App\Http\Requests;

use App\Rules\MilageRule;
use App\Rules\DrivetrainRule;
use Illuminate\Foundation\Http\FormRequest;

class CarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=> 'required|string',
            'milage' => [new MilageRule()],
            'drivetrain' => ['sometimes', new DrivetrainRule()],
        ];
    }
}
