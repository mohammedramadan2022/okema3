<?php
namespace App\Observers;

use App\Models\ProductStore;

class PurchaseInvoiceDetailsObserver
{

    public function created($model)
    {
        $productStore = ProductStore::where('product_id', $model->product_id)
            ->where('store_id', $model->purchaseInvoice->store_id)
            ->first();

        if ($productStore) {
            $productStore->quantity += $model->quantity;
            $productStore->save();
        } else {
            ProductStore::create([
                'product_id' => $model->product_id,
                'store_id'   => $model->purchaseInvoice->store_id,
                'quantity'   => $model->quantity,
            ]);
        }

        $model->itemTransactions()->create([
            'product_id' => $model->product_id,
            'quantity'   => $model->quantity,

        ]);
    }

}
