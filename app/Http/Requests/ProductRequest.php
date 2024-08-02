<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProductRequest extends FormRequest
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
            'category_id' => 'required|exists:categories,id',
            'name' => 'required',
            'image' => 'required|max:1024',
            'description' => 'required',
            'price' => 'required',
            'quantity' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'O id do usuário é obrigatório',
            'user_id.exists' => 'Este usuário não existe',
            'category_id.required' => 'O id da categoria é obrigatório',
            'category_id.exists' => 'Essa categoria não existe',
            'name.required' => 'O nome do produto é obrigatório.',
            'image.required' => 'É obrigatório o envio de uma imagem.',
            'description.required' => 'A descrição é obrigatória',
            'price.required' => 'A preço é obrigatório',
            'quantity.required' => 'A quantidade é obrigatória'
        ];
    }
}
