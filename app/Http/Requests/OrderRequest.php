<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'price' => 'required',
            'quantity' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'O id do usuário é obrigatório.',
            'user_id.exists' => 'Esse id de usuário não existe',
            'product_id.required' => 'O id do produto é obrigatório.',
            'product_id.exists' => 'Esse id de produto não existe.',
            'price.required' => 'O preço total é obrigatório.',
            'quantity.required' => 'A quantidade é obrigatória.'
        ];
    }
}
