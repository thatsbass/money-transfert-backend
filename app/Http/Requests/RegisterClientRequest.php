<?php

// RegisterClientRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterClientRequest extends FormRequest
{
    public function rules()
    {
        return [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|string',
            'role_id' => 'required|integer',
            'address' => 'required|string',
            'CIN' => 'required|string|unique:clients,CIN',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
