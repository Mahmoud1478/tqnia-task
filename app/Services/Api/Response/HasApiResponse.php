<?php

namespace App\Services\Api\Response;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use \Illuminate\Pagination\LengthAwarePaginator;

trait HasApiResponse
{
    private function makeResponse(
        bool                                               $success,
        array|Collection|JsonResource|LengthAwarePaginator $data = [],
        string                                             $message = '',
        array|Collection                                   $errors = [],
        string                                             $token = ''
    ): JsonResponse
    {
        return response()->json([
            'success' => $success,
            'data' => $data,
            'errors' => $errors,
            'message' => $message,
            'token' => $token,
        ]);
    }

    private function successResponse(array|Collection|JsonResource|LengthAwarePaginator $data): JsonResponse
    {
        return $this->makeResponse(true, $data);
    }

    private function successResponseWithToken(
        array|Collection|JsonResource|LengthAwarePaginator $data, string $token
    ): JsonResponse
    {
        return $this->makeResponse(true, $data, token: $token);
    }

    private function successMessageResponse(string $message): JsonResponse
    {
        return $this->makeResponse(true, message: $message);
    }

    private function failedMessageResponse(string $message): JsonResponse
    {
        return $this->makeResponse(false, message: $message);
    }

    private function failedResponse(
        array|Collection|JsonResource|LengthAwarePaginator $errors, string $message
    ): JsonResponse
    {
        return $this->makeResponse(false, message: $message, errors: $errors);
    }
}
