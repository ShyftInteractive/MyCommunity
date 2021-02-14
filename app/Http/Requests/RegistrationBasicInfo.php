<?php

namespace App\Http\Requests;

use App\Rules\Rebase\SubdomainIsNotBanned;
use Illuminate\Foundation\Http\FormRequest;

class RegistrationBasicInfo extends FormRequest
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
            'email' => ['required', 'email', 'max:200'],
            'name' => ['required', 'string', 'max:200'],
        ];
    }
}
