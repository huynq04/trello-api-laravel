<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateColumnRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'board_id' => 'required|exists:boards,id'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The column name is required.',
            'name.string' => 'The column name must be a string.',
            'name.max' => 'The column name must not exceed 255 characters.',
            'board_id.required' => 'The board ID is required.',
            'board_id.exists' => 'The selected board ID is invalid.'
        ];
    }

}
