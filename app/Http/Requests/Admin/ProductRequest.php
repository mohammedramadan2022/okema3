<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        $product = $this->route('product');
        if ($product){
            return [
                'name'          => 'required|string|max:255|unique:products,name,'.$product->id,
                'original_code' => 'required|string|max:255|unique:products,original_code,'.$product->id,
                'category_id'   => 'required|exists:categories,id',
                'sale_price'    => 'required|numeric',
                'buy_price'    => 'required|numeric',
                'description'   => 'required|string|max:255',
                'is_active'     => 'required'
            ];
        }
        else{
            return [
                'name'          => 'required|string|max:255|unique:products,name',
                'original_code' => 'required|string|max:255|unique:products,original_code',
                'category_id'   => 'required|exists:categories,id',
                'sale_price'    => 'required|numeric',
                'buy_price'    => 'required|numeric',
                'description'   => 'required|string|max:255',
                'is_active'     => 'required'
            ];
        }

    }
}
