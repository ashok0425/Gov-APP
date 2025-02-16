<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $user = User::factory()->create([
            'email' => 'admin@gmail.com',
            'phone' => '9813519397',
            'password' => Hash::make('password'),
        ]);

    }
}
