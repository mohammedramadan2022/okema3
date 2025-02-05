<?php
// app/Http/Requests/OwnerRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeCountryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255|unique:owners,phone',
            'national_id' => 'required|string|max:255|unique:owners,national_id',
            'register_number' => 'required|string|max:255|unique:owners,register_number',
        ];
    }
}
