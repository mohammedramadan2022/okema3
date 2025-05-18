<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $safe = $this->route('expense');


        if ($safe){
            return [
                'name' => 'required|string|max:255|unique:expenses,name,'.$safe->id,
                'is_active' => 'required'
            ];
        }
        else{
            return [
                'name' => 'required|string|max:255|unique:expenses,name',
                'is_active' => 'required'
            ];
        }

    }
}
