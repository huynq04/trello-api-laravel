<?php

namespace App\Http\Requests;

use App\Enums\BoardType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBoardRequest extends FormRequest
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
            'title' => [
                'string',
                'min:3',
                'max:50',
                'regex:/^\S(.*\S)?$/',
            ],
            'description' => [
                'string',
                'min:3',
                'max:256',
            ],
            'type' => [
                'string',
                Rule::in([BoardType::Private->value, BoardType::Public->value])
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.string' => 'Title must be a string',
            'title.min' => 'Title length must be at least 3 characters long',
            'title.max' => 'Title length must be less than or equal to 50 characters long',
            'title.regex' => 'Title must not have leading or trailing whitespace',

            'description.string' => 'Description must be a string',
            'description.min' => 'Description must be at least 3 characters long',
            'description.max' => 'Description must be less than or equal to 256 characters long',

            'type.string' => 'Type must be a string',
            'type.in' => 'Type must be either public or private',
        ];
    }
}
