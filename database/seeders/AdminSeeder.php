<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create user for admin
        $user = User::create([
            'name' => 'Administrator',
            'email' => 'admin@alumnitpl.sch.id',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create admin record
        Admin::create([
            'user_id' => $user->id,
        ]);
    }
}
