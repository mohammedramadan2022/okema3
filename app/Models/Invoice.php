<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

class Invoice extends Model
{
    use HasFactory;
    public const UNPAID = 1;

    public const PAID = 2;
    public const STATUS_ALL = 7;



    const STATUS_ARR = [
        self::PAID => 'PAID',
        self::UNPAID => 'UNPAID',
        self::STATUS_ALL => 'All',
    ];



//    protected $guarded = ['id'];
//
//
//                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            /*************  ✨ Codeium Command ⭐  *************/

    protected $fillable = [

                     'id',
                     'invoice_id',
                     'client_id',
                     'invoice_date',
                     'due_date',
                     'amount',
                     'final_amount',
                     'discount_type',
                     'discount',
                     'note',
                     'term',
                     'recurring',
                     'status',
                     'shop_name',
                     'location',
                     'type',
                     'code',
                     'created_by',
                     'updated_by',
                     'deleted_by',



                 ]  ;
    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public static function generateUniqueInvoiceId(): string
    {
        $invoiceId = mb_strtoupper(Str::random(6));
        while (true) {
            $isExist = self::whereInvoiceId($invoiceId)->exists();
            if ($isExist) {
                self::generateUniqueQuoteId();
            }
            break;
        }

        return $invoiceId;
    }

    public function safesTransaction(): morphMany
    {
        return $this->morphMany(SafesTransaction::class, 'safable');
    }

}
