<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;

class TagRequest extends ApiRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required', 'string' , 'max:255',Rule::unique('tags')->ignore($this->tag)
            ]
        ];
    }
}
