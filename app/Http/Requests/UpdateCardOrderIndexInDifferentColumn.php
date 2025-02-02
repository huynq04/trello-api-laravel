<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCardOrderIndexInDifferentColumn extends FormRequest
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
            'card_id' => ['required', 'integer', 'exists:cards,id'],
            'next_column_id' => ['required', 'integer', 'exists:columns,id'],
            'next_card_order_index' => ['required', 'array'],
            'prev_card_order_index' => ['sometimes', 'array'],
        ];
    }
}
