<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveNewContactMessageRequest extends FormRequest
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

        $additionalRules = [];
        if(getSetting('security.recaptcha_enabled')){
            $additionalRules = [
                'g-recaptcha-response' => 'required|captcha',
            ];
        }

        return array_merge([
            'subject' => 'required|min:5',
            'email' => 'required|email',
            'message' => 'required|min:10',
        ], $additionalRules);
    }
}
