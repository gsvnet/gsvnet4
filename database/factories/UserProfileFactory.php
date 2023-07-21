<?php

namespace Database\Factories;

use GSVnet\Core\Enums\GenderEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserProfile>
 */
class UserProfileFactory extends Factory
{
    private array $studies = ['Wiskunde', 'Geschiedenis', 'Tandheelkunde', 'IB/IO', 'Bedrijfskunde'];
    private array $companies = ['Gadero', 'Bo & Co', 'Mevrouw Verhagen', 'Thuisbezorgd', null];
    private array $professions = ['Schoonmaker', 'Bezorger', 'Putjesschepper', 'Beveiliger', 'Bedrijfsfeut', null];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            // user_id and year_group_id are taken care of in the user seeder
            'initials' => strtoupper($this->faker->lexify('??')),
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->streetAddress,
            'zip_code' => $this->faker->postcode,
            'town' => $this->faker->city,
            'country' => $this->faker->country,
            'study' => $this->faker->randomElement($this->studies),
            'birthdate' => $this->faker->dateTimeThisCentury->format('Y-m-d'),
            'gender' => $this->faker->randomElement(GenderEnum::cases()),
            'student_number' => 's' . (string) rand(1000000, 5000000),
            'parent_address' => $this->faker->streetAddress,
            'parent_zip_code' => $this->faker->postcode,
            'parent_town' => $this->faker->city,
            'parent_phone' => $this->faker->phoneNumber,
            'parent_email' => $this->faker->safeEmail,
            'inauguration_date' => $this->faker->dateTimeBetween('-10 years', 'now'),
            'company' => $this->faker->randomElement($this->companies),
            'profession' => $this->faker->randomElement($this->professions),
            'business_url' => $this->faker->url
        ];
    }
}
