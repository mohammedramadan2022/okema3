<?php
namespace App\Http\Requests\Admin\purchase;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseInvoiceRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'supplier_id'  => 'required|integer|exists:suppliers,id',
            'store_id'     => 'required|integer|exists:stores,id',
            'invoice_date' => 'required|date',
            'note'         => 'nullable|string',
            'product_id'   => 'required|array',
            'product_id.*' => 'required|integer|exists:products,id',
            'quantity'     => 'required|array',
            'quantity.*'   => 'required|integer',
            'price'        => 'required|array',
            'price.*'      => 'required|integer',

        ];
    }
}
