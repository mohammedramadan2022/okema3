<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStore extends Model
{
protected $table = 'product_store';
protected $guarded = array('id');

    use HasFactory;
}
