<?php
namespace App\Observers;

use App\Models\PurchaseInvoice;
use Illuminate\Support\Facades\DB;

class PurchaseInvoiceObserver
{

    /**
     * Handle the Invoice "creating" event.
     *
     * @param  \App\Models\PurchaseInvoice  $invoice
     * @return void
     */
    public function creating(PurchaseInvoice $invoice)
    {
        $invoice->created_by     = auth()->guard('admin')->user()->id ?? 0;
        $invoice->updated_by     = auth()->guard('admin')->user()->id ?? 0;
        $invoice_number          = PurchaseInvoice::max('invoice_number');
        $invoice->invoice_number = $invoice_number + 1;

    }

    public function created($model)
    {

        DB::afterCommit(function () use ($model) {

            $total = 0;
            foreach ($model->details as $detail) {
                $total += $detail->quantity * $detail->price;
            }
            $model->total = $total;
            $model->save();
        });
    }

    public function updating($model)
    {
        $total = 0;
        foreach ($model->details as $detail) {
            $total += $detail->quantity * $detail->price;
        }
        $model->total = $total;
    }
}
