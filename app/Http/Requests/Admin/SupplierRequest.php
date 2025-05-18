<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        if ($this->id){
            return [
                'name' => 'required|string|max:255|unique:suppliers,name,'.$this->id,
                'is_active' => 'required'
            ];
        }
        else{
            return [
                'name' => 'required|string|max:255|unique:suppliers,name',
                'is_active' => 'required'];
        }

    }
}
