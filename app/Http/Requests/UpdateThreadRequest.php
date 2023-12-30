<?php

namespace App\Http\Requests;

use GSVnet\Forum\VisibilityLevel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateThreadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Retrieve thread by route-model binding
        return $this->user()->can('thread.manage', $this->thread);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'subject' => 'required|min:3',
            'tags' => 'required|array|max:3',
            'visibility' => Rule::enum(VisibilityLevel::class)
        ];
    }
}
