<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
            'author' => 'required',
            'price' => 'required|numeric',
            'published_date' => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Book title is required',
            'author.required' => 'Author name is required',
            'price.required' => 'Price is required',
            'price.numeric' => 'Price must be numeric',
            'published_date.required' => 'Published date is required',
            'published_date.date' => 'Invalid date format',
        ];
    }
}
