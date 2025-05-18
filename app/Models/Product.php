<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class Product extends Model implements HasMedia
{
    use HasFactory, Notifiable, InteractsWithMedia;

    protected $table = 'products';

    protected $fillable = ['name', 'code','original_code' ,'category_id', 'sale_price','buy_price', 'description','is_active'];

    protected $casts = [
        'name'        => 'string',
        'code'        => 'string',
        'category_id' => 'integer',
        'sale_price'  => 'double',
        'buy_price'  => 'double',
        'description' => 'string',
    ];

    const Image = 'product';

    protected $appends = ['product_image'];

    public static $rules = [
        'name' => 'required',
        'code' => 'required|alpha_num|min:3|max:6|unique:products,code',
        'category_id' => 'required',
        'unit_price' => 'required|numeric',
    ];

    public static $messages = [
        'code.required' => 'The product code field is required.',
        'code.size' => 'The product code must be 6 characters.',
        'code.unique' => 'The product code has already been taken.',
    ];

    public function getProductImageAttribute(): string
    {
        /** @var Media $media */
        $media = $this->getMedia(self::Image)->first();
        if (! empty($media)) {
            return $media->getFullUrl();
        }

        return asset('images/default-product.jpg');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }


    public function productStores()
    {
        return $this->hasMany(ProductStore::class);
    }
}
