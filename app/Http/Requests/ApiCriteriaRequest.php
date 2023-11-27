<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiCriteriaRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "title" => "required|string",
            "description" => "nullable|string",
            "value" => "required|numeric",
         ];
    }
}
