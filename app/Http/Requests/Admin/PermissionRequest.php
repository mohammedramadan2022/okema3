<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->id){
            return [
                'name' => "required|unique:permissions,name,".$this->id,
                'guard_name' => 'required|in:admin',
            ];
        }
        else{
            return [
                'name' => "required|unique:permissions,name",
                'guard_name' => 'required|in:admin',
            ];
        }
    }
}
