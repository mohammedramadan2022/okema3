<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
                'name' => "required|unique:roles,name,".$this->id,
                'permission' => 'nullable|array',
                'permission.*' => 'nullable',
            ];
        }
        else{
            return [
                'name' => "required|unique:roles,name",
                'permission' => 'nullable|array',
                'permission.*' => 'nullable',
            ];
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'يرجى إدخال اسم الدور.',
            'name.unique' => 'اسم الدور تم استخدامه من قبل.',
            'permission.array' => 'الصلاحيات يجب أن تكون في مصفوفة.',
            'permission.*.nullable' => 'يمكنك ترك الصلاحيات فارغة.',
        ];
    }
}
