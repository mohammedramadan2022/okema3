<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddExpenseRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'safe_id' => 'required|exists:safes,id',
            'expense_id' => 'required|exists:expenses,id',
            'amount' => 'required|numeric',
            'notes' => 'nullable|string|max:255',
        ];
    }
}
