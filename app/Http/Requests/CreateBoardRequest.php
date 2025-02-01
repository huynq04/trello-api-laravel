<?php

namespace App\Http\Requests;

use App\Enums\BoardType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateBoardRequest extends FormRequest
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
                'required',
                'string',
                'min:3',
                'max:50',
                'regex:/^\S(.*\S)?$/',
            ],
            'description' => [
                'required',
                'string',
                'min:3',
                'max:256',
            ],
            'type' => [
                'required',
                'string',
                Rule::in([BoardType::Private->value, BoardType::Public->value])
            ],
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

            'description.required' => 'Description is required',
            'description.min' => 'Description must be at least 3 characters long',
            'description.max' => 'Description must be less than or equal to 256 characters long',

            'type.required' => 'Type is required',
            'type.in' => 'Type must be either public or private',
        ];
    }

}
