<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->unique()->phoneNumber,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'google_id' => $this->faker->optional()->uuid,
            'facebook_id' => $this->faker->optional()->uuid,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'bank_name' => $this->faker->company,
            'account_no' => $this->faker->bankAccountNumber,
            'account_holder' => $this->faker->name,
            'id_info' => $this->faker->unique()->numerify('ID##########'),
            'id_proof' => $this->faker->optional()->imageUrl(),
            'kyc_status' => $this->faker->randomElement(['not_submitted', 'submitted', 'under_review', 'additional_info_required', 'approved', 'rejected']),
            'kyc_remarks' => $this->faker->optional()->sentence,
            'kyc_submitted_at' => $this->faker->optional()->dateTimeThisYear,
            'kyc_processed_at' => $this->faker->optional()->dateTimeThisYear,
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * Indicate that the user should have a personal team.
     *
     * @return $this
     */
    public function withPersonalTeam()
    {
        if (! Features::hasTeamFeatures()) {
            return $this->state([]);
        }

        return $this->has(
            Team::factory()
                ->state(function (array $attributes, User $user) {
                    return ['name' => $user->name.'\'s Team', 'user_id' => $user->id, 'personal_team' => true];
                }),
            'ownedTeams'
        );
    }
}
