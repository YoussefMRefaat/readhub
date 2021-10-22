<?php

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'book_id' => ['required' , 'integer' , 'exists:books,id' ],
            'rating' => ['required' , 'integer' , 'min:1' , 'max:5'],
            'comment' => ['nullable' , 'string'],
        ];
    }
}
