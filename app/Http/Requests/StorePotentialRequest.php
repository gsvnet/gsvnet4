<?php

namespace App\Http\Requests;

use App\Models\User;
use GSVnet\Core\Enums\GenderEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StorePotentialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Any non-authenticated user is allowed to sign up.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $newUser = is_null($this->user());

        return [
            'photo_path' => 'image',
            'firstname' => 'required',
            'lastname' => 'required',
            'gender' => ['required', Rule::enum(GenderEnum::class)],
            'birthdate' => 'required|date_format:Y-m-d',
            'address' => 'required',
            'zip_code' => 'required',
            'town' => 'required',
            'email' => 'email',
            'phone' => 'required',
            'studentNumber' => '',
            'study' => 'required',
            'username' => Rule::requiredIf($newUser),
            'password' => [Rule::requiredIf($newUser), 'confirmed'],
            'parent_address' => 'required_if:parents-same-address,0',
            'parent_zip_code' => 'required_if:parents-same-address,0',
            'parent_town' => 'required_if:parents-same-address,0',
            'parent_phone' => 'required',
            'parent_email' => 'required|email'
        ];
    }

    /**
     * Get the "after" validation callables for the request.
     */
    public function after(): array
    {
        return [
            function (Validator $validator) {
                $user = $this->user();

                if (!is_null($user) && !$user->isVisitor()) {
                    $validator->errors()->add(
                        'user',
                        'Je hebt je al aangemeld'
                    );
                }
            }
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'photo_path.required' => 'Selecteer een foto van jezelf',
            'photo_path.image' => 'Selecteer een foto van jezelf',
            'firstname.required' => 'Vul je voornaam in',
            'lastname.required' => 'Vul je achternaam in',
            'gender.required' => 'Selecteer je geslacht',
            'gender.in' => 'Selecteer je geslacht',
            'birthdate.required' => 'Vul een geboortedatum in',
            'birthdate.date_format' => 'Vul een geldige geboortedatum in',
            'address.required' => 'Vul een adres in',
            'zip_code.required' => 'Vul een postcode in',
            'town.required' => 'Vul een woonplaats in',
            'email.required_if' => 'Vul een emailadres in',
            'email.email' => 'Vul een geldig emailadres in',
            'phone.required' => 'Vul een telefoonnummer in',
            'study.required' => 'Vul een studie in',
            'username.required_if' => 'Kies een gebruikersnaam',
            'password.required_if' => 'Kies een wachtwoord',
            'password.confirmed' => 'Kies een wachtwoord',
            'parent_address.required_if' => 'Vul het adres van je ouders in',
            'parent_zip_code.required_if' => 'Vul de postcode van je ouders in',
            'parent_town.required_if' => 'Vul de woonplaats van je ouders in',
            'parent_phone.required' => 'Vul het telefoonnummer van je ouders in',
            'parent_email.required' => 'Vul het emailadres van je ouders in',
            'parent_email.email' => 'Vul een geldig emailadres van je ouders in'
        ];
    }
}
