<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteItem extends Model
{
    use HasFactory;

    protected $table   = 'quote_items';
    protected $guarded = ['id'];

//    protected $fillable = [
//        'id',
//        'quote_id',
//        'product_id',
//        'product_name',
//        'quantity',
//        'price',
//        'total',
//    ];


    public function product()
    {

        return $this->belongsTo(Product::class, 'product_id');

}
}
