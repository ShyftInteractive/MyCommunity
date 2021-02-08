<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class MediaRequest extends FormRequest
{

    protected function prepareForValidation()
    {

        $filename = Str::of($this->file->getClientOriginalName())->beforeLast('.');
        $extension = Str::of($this->file->getClientOriginalName())->afterLast('.');
        $normalizedName = Str::slug(Str::lower($filename));

        $this->merge([
            'name' => "{$normalizedName}.{$extension}",
            'extension' => (string) $extension,
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
            'name' => ['bail', 'required', 'max:255', Rule::unique('workspace.media')->where('workspace_id', $this->workspace_id)],
            'file' => 'bail|required|file|mimes:jpeg,jpg,png,gif,svg,webp,csv,txt,xlx,xls,pdf,doc,docx,pages,numbers,mp3,mp4,mov'
        ];
    }
}
