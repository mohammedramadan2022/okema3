<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeActive()
    {
        return $this->where('is_active', 1);
    }

    public function transactions()
    {
     return $this->hasMany(ExpenseTransaction::class, 'expense_id');
    }
}
