<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SafeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $safe = $this->route('safe');


        if ($safe){
            return [
                'name' => 'required|string|max:255|unique:safes,name,'.$safe->id,
                'current_balance' => 'required|numeric|min:0',
                'is_active' => 'required'
            ];
        }
        else{
            return [
                'name' => 'required|string|max:255|unique:safes,name',
                'current_balance' => 'required|numeric|min:0',
                'is_active' => 'required'
            ];
        }

    }
}
