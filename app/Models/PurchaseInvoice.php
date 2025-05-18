<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInvoice extends Model
{
    use HasFactory;


protected $fillable = [
        'supplier_id',
        'store_id',
        'invoice_date',
        'note',
        'total',
        'invoice_number',
        'created_by',
    ];


    public function details()
    {
        return $this->hasMany(PurchaseInvoiceDetail::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
