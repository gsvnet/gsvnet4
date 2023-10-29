<?php

namespace App\Http\Requests;

use GSVnet\Core\Enums\GenderEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateGenderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Note that $this->user() and $this->user are different entities.
        $member = $this->user;
        return $this->user()->can('user.manage.gender', $member);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'gender' => [new Enum(GenderEnum::class)]
        ];
    }
}
