<?php

namespace App\Http\Requests;

use GSVnet\Core\Enums\SenateFunctionEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSenateMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Handled by Senates\MembersController constructor
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
            'function' => ['required', Rule::enum(SenateFunctionEnum::class)]
        ];
    }
}
