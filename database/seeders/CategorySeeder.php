<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\OrderStatus;
use Carbon\Carbon;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		Category::create([
			'name' => 'Man',
			'slug' => 'man',
			'status' => 'Active',
		]);

		Category::create([
			'name' => 'T-Shirt',
			'parent_id' => 1,
			'slug' => 't-shirt',
			'status' => 'Active',
		]);

		Category::create([
			'name' => 'Polo T-Shirt',
			'parent_id' => 2,
			'slug' => 'polo t-shirt',
			'status' => 'Active',
		]);



		$orderstatus = ['Pending', 'Accepted', 'Ready for Shiping', 'Shipped', 'Out for Delivery', 'Delivered', 'Canceled', 'Return Requested', 'Returned'];

		foreach ($orderstatus as $status) {
			OrderStatus::create([
				'name' => $status
			]);
		}
	}
}
