<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //created admin
        User::create([
            'name'=>'Admin',
            'email'=>'admin@gmail.com',
            'is_admin'=>1,
            'password'=>Hash::make('admin'),
        ]);

        User::create([
            'name'=>'user',
            'email'=>'user@gmail.com',
            'is_admin'=>0,
            'password'=>Hash::make('user'),
        ]);

    }
}
