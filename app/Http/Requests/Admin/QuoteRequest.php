<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UniqueWithClient;

class QuoteRequest extends FormRequest
{

    public function rules(): array
    {

        return [
            'client_id'    => 'required|integer|exists:clients,id',
           'quote_id'   => [
                'required',
                new UniqueWithClient('quotes', 'quote_id', 'client_id', null)
            ],
            'quote_date'   => 'required|date',
            'due_date'     => 'required|date|after:quote_date',
//            'status'       => 'required|in:0,1',

            'product_id' => 'required|array|min:1',
            'product_id.*' => 'required',
            'quantity'     => 'required|array|min:1',
            'quantity.*'   => 'required|integer|min:1',
            'unit' => 'required|array|min:1',
            'unit.*' => 'required|string',
            'price'        => 'required|array|min:1',
            'price.*'      => 'required|numeric|min:0',

        ];
    }
}
