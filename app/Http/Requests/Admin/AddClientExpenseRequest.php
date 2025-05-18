<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddClientExpenseRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'safe_id' => 'required|exists:safes,id',
            'client_id' => 'required|exists:clients,id',
            'amount' => 'required|numeric',
            'notes' => 'nullable|string|max:255',
        ];
    }
}
