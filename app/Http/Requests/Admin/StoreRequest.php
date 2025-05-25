<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'name' => 'required|string|max:255|unique:stores,name' . ($this->id ? ',' . $this->id : ''),
            'is_active' => 'required',
            'type' => 'required|in:user,main',
            'admin_id' => 'required_if:type,user|exists:admins,id',
        ];

    }
}
