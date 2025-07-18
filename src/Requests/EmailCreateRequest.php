<?php

namespace admin\emails\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [                   
            'title' => 'required|string|min:3|max:100|unique:emails,title',
            'subject' => 'nullable|string|max:255',
            'description' => 'required|string|min:3|max:65535',
            'status' => 'required|in:0,1',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
