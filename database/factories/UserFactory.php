<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // default password
            'role' => 'user', // default role
            'remember_token' => Str::random(10),
        ];
    }

    // Tambahkan state untuk admin
    public function admin(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'), // bisa ganti sesuai keinginan
        ]);
    }
}