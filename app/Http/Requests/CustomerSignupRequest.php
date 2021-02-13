<?php

namespace App\Http\Requests;

use App\Rules\Rebase\SubdomainIsNotBanned;
use Illuminate\Foundation\Http\FormRequest;

class CustomerSignupRequest extends FormRequest
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
            'sub' => ['required', 'unique:lookup,sub', 'min:3', 'max:100', new SubdomainIsNotBanned()],
            'plan' => ['required'],
            'name' => ['required', 'max:200', 'string'],
            'email' => ['required', 'email', 'max:200'],
            'line1' => ['required', 'string'],
            'city' => ['required', 'string'],
            'state' => ['required', 'string'],
            'postal_code' => ['required', 'string', 'max:5'],
            'agreed_to_terms' => ['required'],
            'agreed_to_privacy' => ['required'],
        ];
    }
}
