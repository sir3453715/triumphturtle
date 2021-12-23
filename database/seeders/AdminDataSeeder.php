<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = User::create([
            'name' => 'Admin',
            'email' => 'nomadot.test@gmail.com',
            'password' => Hash::make('aaa83831425'),
        ]);
        $user->assignRole('administrator');


    }
}
