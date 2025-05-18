<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Quote extends Model
{
    use HasFactory;
    const DRAFT = 0;

//    const CONVERTED = 1;

//    const STATUS_ALL = 2;
    const STATUS_ARR = [
        self::DRAFT => 'Draft',
//        self::CONVERTED => 'Converted',
//        self::STATUS_ALL => 'All',
    ];



    protected $guarded = ['id'];

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            /*************  ✨ Codeium Command ⭐  *************/


//                 protected $fillable = [
//
//                     'id',
//                     'quote_id',
//                     'client_id',
//                     'quote_date',
//                     'due_date',
//                     'amount',
//                     'final_amount',
//                     'discount_type',
//                     'discount',
//                     'note',
//                     'term',
//                     'recurring',
//                     'status',
//                     'shop_name',
//                     'location',
//                     'type',
//                     'created_by',
//                     'updated_by',
//                     'deleted_by',
//
//
//
//                 ]   ;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       /******  eb8d73d2-a789-4233-9806-8baa655f2db3  *******/
    public function items()
    {
        return $this->hasMany(QuoteItem::class);
    }
public function client()
    {
        return $this->belongsTo(Client::class);
    }

//    public static function generateUniqueQuoteId(): string
//    {
//        $quoteId = mb_strtoupper(Str::random(6));
//        while (true) {
//            $isExist = self::whereQuoteId($quoteId)->exists();
//            if ($isExist) {
//                self::generateUniqueQuoteId();
//            }
//            break;
//        }
//
//        return $quoteId;
//    }
}
