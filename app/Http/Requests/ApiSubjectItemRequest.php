<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiSubjectItemRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "title" => "required|string",
            "description" => "nullable|string",
            "subject_id" => "nullable|integer",
            "star" => "nullable|integer|between:0,5",
            "price" => "nullable|numeric",
            "rating" => "nullable|integer|between:0,5",
         ];
    }
}
