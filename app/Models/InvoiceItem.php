<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $table   = 'invoice_items';
    protected $guarded = ['id'];



    public function product()
    {
        return $this->belongsTo(Product::class);
    }


}
