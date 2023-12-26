<?php

namespace App\Http\Requests;

use GSVnet\Forum\VisibilityLevel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StartThreadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // All users can make a thread (middleware makes sure their accounts are approved).
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'body' => 'required',
            'subject' => 'required|min:3',
            'tags' => 'required|array|max:3',
            'visibility' => Rule::enum(VisibilityLevel::class)
        ];
    }
}
