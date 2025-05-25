<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        if ($this->id){
            return [
                'name' => 'required|string|max:255|unique:countries,name,'.$this->id,
                'country_code' => 'required|string|max:255|unique:countries,country_code,'.$this->id,
                'is_active' => 'required'
            ];
        }
        else{
            return [
                'name' => 'required|string|max:255|unique:countries,name',
                'country_code' => 'required|string|max:255|unique:countries,country_code',
                'is_active' => 'required'];
        }

    }
}
