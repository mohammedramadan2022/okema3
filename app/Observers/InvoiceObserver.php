<?php

namespace App\Observers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\ProductStore;
use App\Models\Store;
use Illuminate\Support\Facades\DB;

class InvoiceObserver
{

    public function creating(Invoice $invoice)
    {
        $invoice->created_by = auth()->guard('admin')->user()->id ?? 0;
        $invoice->updated_by = auth()->guard('admin')->user()->id ?? 0;
        $lastInvoice = Invoice::where('client_id', $invoice->client_id)
            ->orderBy(DB::raw('CAST(invoice_id AS UNSIGNED)'), 'DESC')
            ->first();
        $client = Client::whereId($invoice->client_id)->first();
        $invoice->invoice_id = $lastInvoice ? $lastInvoice->invoice_id + 1 : ($client ? $client->invoice_start : 1);
    }

    public function created($model)
    {

        DB::afterCommit(function () use ($model) {

            $total = 0;
            foreach ($model->items as $item) {

                    $total += $item->quantity * $item->price;
                if ($item->product_id) {
                    if ($product = $item->product) {
                        $product->productStores()
                            ->where('store_id', Store::first()->id)
                            ->first()?->decrement('quantity', $item->quantity);
                    }
                }

            }
            $model->amount = $total;
            $model->final_amount = $total;
            $model->save();
        });
    }
}
