<?php

namespace App\Http\Requests\Admin;

use App\Rules\UniqueWithClient;
use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
{

    public function rules(): array
    {

        return [
            'client_id'    => 'required|integer|exists:clients,id',
            'invoice_id'   => [
                'required',
                new UniqueWithClient('invoices', 'invoice_id', 'client_id', null)
            ],
            'invoice_date'   => 'required|date',
            'due_date'     => 'required|date|after:invoice_date',
//            'status'       => 'required|in:0,1',

            'product_id' => 'required|array|min:1',
            'product_id.*' => 'required',
            'quantity'     => 'required|array|min:1',
            'quantity.*'   => 'required|integer|min:1',
            'unit' => 'required|array|min:1',
            'unit.*' => 'required|string',
            'code' => 'required|array|min:1',
            'code.*' => 'required|string',
            'price'        => 'required|array|min:1',
            'price.*'      => 'required|numeric|min:0',

        ];
    }
}
