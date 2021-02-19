<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AvatarRequest extends FormRequest
{

    protected function prepareForValidation()
    {

        $filename = Str::of($this->file->getClientOriginalName())->beforeLast('.');
        $extension = Str::of($this->file->getClientOriginalName())->afterLast('.');
        $normalizedName = Str::slug(Str::lower($filename));

        $this->merge([
            'avatarName' => "{$normalizedName}.{$extension}",
            'avatarExtension' => (string) $extension,
        ]);
    }

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
            'file' => 'bail|required|file|mimes:jpeg,jpg,png,gif,webp'
        ];
    }
}
