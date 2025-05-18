<?php

namespace App\Http\Requests\Admin;

use App\Rules\UniqueWithClient;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MaintenanceQuoteRequest extends FormRequest
{

    public function rules(): array
    {

        return [
            'client_id' => 'required|integer|exists:clients,id',
            'quote_id' => [
                'required',
                new UniqueWithClient('quotes', 'quote_id', 'client_id', null)
            ],
            'quote_date' => 'required|date',
            'due_date' => 'required|date|after:quote_date',
            'status' => 'required|in:0,1',
            'shop_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'product_name' => 'required|array|min:1',
            'product_name.*' => 'required|string',
            'quantity' => 'required|array|min:1',
            'quantity.*' => 'required|integer|min:1',
            'unit' => 'required|array|min:1',
            'unit.*' => 'required|string',
            'price' => 'required|array|min:1',
            'price.*' => 'required|numeric|min:0',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
