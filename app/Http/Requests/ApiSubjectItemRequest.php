<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiSubjectItemRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "title" => "required|string",
            "descriptions" => "nullable|string",
            "star" => "nullable|numeric|min:1|max:5",
            "price" => "nullable|numeric",
            "rating" => "nullable|numeric|min:1|max:5",
            "facility" => "nullable|numeric",
         ];
    }
}
