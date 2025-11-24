<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory()->create([
                'name' => 'Administrator',
                'email' => 'admin@alumnitpl.sch.id',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ])->id,
        ];
    }
}
