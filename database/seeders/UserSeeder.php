<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()
            ->count(15)
            ->state(new \Illuminate\Database\Eloquent\Factories\Sequence(
                fn($sequence) => [
                    'email' => 'student' . ($sequence->index + 1) . '@gmail.com',
                    'role' => 'student',
                ],
            ))
            ->create();

        User::factory()
            ->count(3)
            ->state(new \Illuminate\Database\Eloquent\Factories\Sequence(
                fn($sequence) => [
                    'email' => 'lecturer' . ($sequence->index + 1) . '@gmail.com',
                    'role' => 'lecturer',
                ],
            ))
            ->create();

        User::factory()
            ->count(1)
            ->state(new \Illuminate\Database\Eloquent\Factories\Sequence(
                fn($sequence) => [
                    'email' => 'admin' . ($sequence->index + 1) . '@gmail.com',
                    'role' => 'admin',
                ],
            ))
            ->create();
    }
}
