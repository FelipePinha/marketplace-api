<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6'
        ];
    }

    public function messages()
    {
       return [
            'name' => 'O nome é obrigatório.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'Email inválido.',
            'email.unique' => 'Este email já foi cadastrado.',
            'password.required' => 'A senha é obrigatória.', 
            'password.confirmed' => 'As senhas precisam ser iguais.',
            'password.min' => 'A senha deve ter mais do que 6 caractéres.' 
       ];
    }
}
