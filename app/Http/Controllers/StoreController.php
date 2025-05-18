<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\ProductStore;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function updateStoreItems(Request $request, $storeId)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:0'
        ]);

        $store = Store::findOrFail($storeId);

        foreach ($request->items as $item) {
            ProductStore::updateOrCreate(
                [
                    'store_id' => $storeId,
                    'product_id' => $item['product_id']
                ],
                [
                    'quantity' => $item['quantity']
                ]
            );
        }

        return response()->json([
            'message' => 'Store items updated successfully',
            'store' => $store->load('products')
        ]);
    }
}
