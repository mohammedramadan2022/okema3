<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{

    public function rules(): array
    {
        $client = $this->route('client');
        if ($client){
            return [
                'name'    => 'required|string|max:255|unique:clients,name,'.$client->id,
                'attention'     => 'required|string|max:255',
                'email'         => 'required',
                'contact'       => 'required',
                'company_name'  => 'required',
                'invoice_start' => 'required',
                'quote_start'   => 'required',
                'address'       => 'required',
                'is_active'     => 'required'
            ];
        }
        else{
            return [
                'name'  => 'required|string|max:255|unique:clients,name',
                'attention'   => 'required|string|max:255',
                'email'       => 'required',
                'contact'     => 'required',
                'company_name' => 'required',
                'invoice_start' => 'required',
                'quote_start' => 'required',
                'address'  => 'required',
                'is_active'   => 'required'
            ];
        }
    }
}
