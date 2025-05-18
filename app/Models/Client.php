<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

//    protected $guarded = [
//        'id',
//    ];

    protected $fillable = [
        'id',
        'name', 'attention',
        'email',
        'contact',
        'is_active',
        'company_name',
        'invoice_start',
        'quote_start',
        'address',
    ];

//    protected $appends = ['name'];

//    public function getFullNameAttribute(): string
//    {
//        return $this->first_name.' '.$this->last_name;
//    }

    public function scopeActive()
    {
        return $this->where('is_active', 1);
    }

    public function expenseTransactions()
    {
        return $this->hasMany(ExpenseTransaction::class, 'client_id');
    }


}
