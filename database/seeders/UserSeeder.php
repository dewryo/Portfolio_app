<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'ゲスト',
            'email' => 'guest@example.com',
            'password' => Hash::make('password'), 
        ]);
    }
}
