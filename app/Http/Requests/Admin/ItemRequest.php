<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->id){
            return [
                'name' => 'required|string|max:255|unique:items,name,'.$this->id,
                'category_id' => 'required|integer|exists:categories,id',
                'device_id' => 'required|integer|exists:devices,id',
                'barcode' => 'required|string|max:255|unique:items,barcode,'.$this->id,
                'status' => 'required|in:active,inactive'
            ];
        }
        else{
            return [
                'name' => 'required|string|max:255|unique:items,name',
                'category_id' => 'required|integer|exists:categories,id',
                'device_id' => 'required|integer|exists:devices,id',
                'barcode' => 'required|string|max:255|unique:items,barcode',
                'status' => 'required|in:active,inactive'
            ];
        }
    }
}
