<?php
namespace App\Observers;

use App\Models\Product;

class ProductObserver
{

    public function creating(Product $product)
    {
        $lastProduct = Product::orderBy('code', 'desc')->first();

        if ($lastProduct && preg_match('/MPC(\d+)/', $lastProduct->code, $matches)) {
            $nextNumber = intval($matches[1]) + 1;
        } else {
            $nextNumber = 1000;
        }

        $product->code = 'MPC' . $nextNumber;

    }
}
