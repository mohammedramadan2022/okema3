<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInvoiceDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function purchaseInvoice()
    {
        return $this->belongsTo(PurchaseInvoice::class);
    }


    public function itemTransactions()
    {
        return $this->morphMany(ProductTransaction::class, 'transactionable');
    }
}
