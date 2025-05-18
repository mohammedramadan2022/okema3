<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Safe extends Model
{
    use HasFactory;

    protected $guarded = array('id');


    public function transactions()
    {
        return $this->hasMany(SafesTransaction::class, 'safe_id');
    }

    public function scopeActive()
    {
        return $this->where('is_active', 1);
    }
}
