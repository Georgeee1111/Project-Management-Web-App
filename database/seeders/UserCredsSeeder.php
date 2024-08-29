<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserCredsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
    User::create([
        'name' => 'Georgee',
        'email' => 'georgeeominguito@gmail.com',
        'password' => Hash::make('admin'), 
        'email_verified_at' => now(), 
        'role' => 'admin',
    ]);
    }
}
