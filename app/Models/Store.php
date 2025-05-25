<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Store extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'is_active'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_store')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

}
