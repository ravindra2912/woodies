<?php

namespace Database\Seeders;

use App\Models\Setting;
use Carbon\Carbon;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SEOSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
			'seo_title' => 'Demo Title',
			'seo_tags' => 'demoseotags',
			'seo_description' => 'demo description',
		]);

       


    }
}




