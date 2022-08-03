<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserProfile>
 */
class UserProfileFactory extends Factory
{
    private array $studies = ['Wiskunde', 'Geschiedenis', 'Tandheelkunde', 'IB/IO', 'Bedrijfskunde'];
    private array $companies = ['Gadero', 'Bo & Co', 'Mevrouw Verhagen', null];
    private array $professions = ['Schoonmaker', 'Putjesschepper', null];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            // user_id?
            // year_group_id?
            'initials' => strtoupper($this->faker->lexify('??')),
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->streetAddress,
            'zip_code' => $this->faker->postcode,
            'town' => $this->faker->city,
            'country' => $this->faker->country,
            'study' => $this->faker->randomElement($this->studies),
            'birthdate' => $this->faker->dateTimeThisCentury->format('Y-m-d'),
            'gender' => rand(0,1),
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
