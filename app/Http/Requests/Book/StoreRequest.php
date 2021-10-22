<?php

namespace App\Http\Requests\Book;

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
            'title' => ['required' , 'string'],
            'published_at' => ['required' , 'integer' , 'min:1800' , 'max:' . date('Y')],
            'description' => ['required' , 'string'],
            'image' => ['required' , 'image'],
            'authors' => ['required' , 'array'],
            'authors.*' => ['required' , 'integer' , 'exists:authors,id' , 'distinct'],
        ];
    }
}
