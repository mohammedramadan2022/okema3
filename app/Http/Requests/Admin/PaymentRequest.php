<?php

namespace App\Http\Requests\Admin;

use App\Models\Invoice;
use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'client_id' => ['required', 'exists:clients,id'],
            'invoice_id' => ['required', 'exists:invoices,id'],
            'safe_id' => ['required', 'exists:safes,id'],
            'paid_amount' => [
                'required',
                'numeric',
                'min:0.01',
                function ($attribute, $value, $fail) {
                    $invoice = Invoice::find($this->validated('invoice_id'));

                    if ($invoice) {
                        $totalPayments = $invoice->safesTransaction()->sum('amount');
                        $remainingAmount = $invoice->final_amount - $totalPayments;

                        if ($value > $remainingAmount) {
                            $fail(__('messages.paid_amount_exceeds_remaining'));
                        }
                    }
                }
            ],
        ];
    }

    public function messages()
    {
        return [
            'client_id.required' => __('messages.client_required'),
            'client_id.exists' => __('messages.client_not_found'),
            'invoice_id.required' => __('messages.invoice_required'),
            'invoice_id.exists' => __('messages.invoice_not_found'),
            'safe_id.required' => __('messages.safe_required'),
            'safe_id.exists' => __('messages.safe_not_found'),
            'paid_amount.required' => __('messages.paid_amount_required'),
            'paid_amount.numeric' => __('messages.paid_amount_must_be_numeric'),
            'paid_amount.min' => __('messages.paid_amount_min'),
        ];
    }
}
