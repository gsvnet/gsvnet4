<?php

namespace Database\Factories;

use GSVnet\Core\Enums\UserTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $middleNames = ['', 'van', 'van der'];

        return [
            'firstname' => $this->faker->firstName,
            'middlename' => $this->faker->randomElement($middleNames),
            'lastname' => $this->faker->lastName,
            'username' => $this->faker->userName,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'type' => $this->faker->randomElement(UserTypeEnum::cases()),
            'approved' => $this->faker->boolean(90)
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    public function memberReunistType(): UserFactory {
        return $this->state(function (array $attributes) {
            return [
                'type' => $this->faker->randomElement([
                    UserTypeEnum::MEMBER,
                    UserTypeEnum::REUNIST
                ])
            ];
        });
    }

    public function profileType(): UserFactory {
        return $this->state(function (array $attributes) {
            return [
                'type' => $this->faker->randomElement([
                    UserTypeEnum::POTENTIAL,
                    UserTypeEnum::MEMBER,
                    UserTypeEnum::REUNIST
                ])
            ];
        });
    }

    public function noProfileType(): UserFactory {
        return $this->state(function (array $attributes) {
            return [
                'type' => $this->faker->randomElement([
                    UserTypeEnum::VISITOR,
                    UserTypeEnum::INTERNAL_COMMITTEE,
                    UserTypeEnum::EXMEMBER
                ])
            ];
        });
    }
}
