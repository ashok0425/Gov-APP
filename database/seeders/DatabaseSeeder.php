<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $user = User::factory()->create([
            'email' => 'customer@email.com',
            'phone' => '9813519397',
            'kyc_status' => User::KYC_STATUS_APPROVED,
        ]);
        Address::factory(5)->create(['user_id' => $user->id]);
        Payment::factory(10)->create(['user_id' => $user->id]);

        User::factory(10)->create()->each(function ($user) {
            Address::factory(5)->create(['user_id' => $user->id]);
            Payment::factory(10)->create(['user_id' => $user->id]);
        });

        // $this->call([
        //     ProductCategorySeeder::class,
        //     ProductSeeder::class,
        // ]);
    }
}
