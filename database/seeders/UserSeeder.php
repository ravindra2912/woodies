<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
			'first_name' => 'Admin',
			'last_name' => 'Admin',
			'email' => 'admin@gmail.com',
			'mobile' => 1111111111,
			'role_id' => 1,
			'password' => Hash::make('password')
		]);

       


    }
}




