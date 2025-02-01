<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCardRequest extends FormRequest
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
            'title' => ['required', 'string', 'min:3', 'max:50', 'regex:/^\S(.*\S)?$/'],
            'column_id' => ['required', 'integer', 'exists:columns,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title is required',
            'title.string' => 'Title must be a string',
            'title.min' => 'Title length must be at least 3 characters long',
            'title.max' => 'Title length must be less than or equal to 50 characters long',
            'title.regex' => 'Title must not have leading or trailing whitespace',

            'column_id.required' => 'Column ID is required',
            'column_id.integer' => 'Column ID must be an integer',
            'column_id.exists' => 'Column ID does not exist',
        ];
    }
}
