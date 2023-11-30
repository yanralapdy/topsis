<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiResultRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "title" => "required|string",
            "descriptions" => "nullable|string",
            "star" => "nullable|integer|between:0,5",
            "price" => "nullable|numeric",
            "rating" => "nullable|integer|between:0,5",
            "facility" => "nullable|string",
         ];
    }
}
