<?php

namespace App\Http\Requests;

use App\Rules\PPVMinMax;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Sluggable;

class SaveNewStreamRequest extends FormRequest
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
            'name' => ['required', 'min:5', new Sluggable],
            'price' => [new PPVMinMax('stream')],
        ];
    }
}
