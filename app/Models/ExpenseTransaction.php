<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ExpenseTransaction extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'expense_transactions';

    public function safesTransaction(): morphMany
    {
        return $this->morphMany(SafesTransaction::class, 'safable');
    }

    public function expense()
    {
        return $this->belongsTo(Expense::class, 'expense_id');
    }
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

  

}
