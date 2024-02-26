<?php

namespace App\Http\Requests\Api;

use App\Services\Api\Response\HasApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class ApiRequest extends FormRequest
{
    use HasApiResponse;
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->failedResponse($validator->errors()->toArray(),'Validation errors'));
    }

    public function authorize(): bool
    {
        return true;
    }

}
