<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateNameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Note that $this->user() and $this->user are different entities:
        // The former retrieves the currently authenticated user,
        // while the latter uses route-model binding to get the user
        // from the URI.
        $member = $this->user;
        return $this->user()->can('user.manage.name', $member);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'firstname' => 'required',
            'lastname' => 'required'
        ];
    }
}
