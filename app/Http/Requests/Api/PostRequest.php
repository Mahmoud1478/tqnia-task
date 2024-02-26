<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required','string','max:255'],
            'body' => ['required','string',],
            'cover_image' => [
                Rule::when($this->method()=='POST',['required'],['nullable']),
                'image',
                'max:10240'
            ],
            'pinned' => ['required','boolean'],
            'tags' => ['required','array'],
            'tags.*' => ['required','numeric','exists:tags,id'],
            'user_id' => [],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'pinned' => $this->boolean('pinned'),
            'user_id' => auth()->id()
        ]);
    }
}
