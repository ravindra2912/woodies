<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderStatus;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use App\Models\ProductImages;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $response = Http::get('https://dummyjson.com/products?limit=20&skip=0');

        // If you want to log or debug the response
        $data = $response->json();
        // dd($data["products"][1]); // or return $data;

        if (isset($data["products"])) {
            foreach ($data["products"] as $product) {
                $newproduct = new Product();
                $newproduct->name = $product['title'];
                $newproduct->slug = Str::slug($product['title']);
                $newproduct->price = $product['price'];
                $newproduct->quantity = $product['stock'];
                $newproduct->is_variants = 0;
                $newproduct->save();

                foreach ($product['images'] as $image) {

                    // / Image URL
                    $imageUrl = $image;

                    // Generate a clean image name (or use your own naming logic)
                    $imageName = Str::random(10) . '.png';

                    // Define the path inside the 'public' disk
                    $path = 'product_images/' . $imageName;

                    // Get the image content from the URL
                    $imageContents = file_get_contents($imageUrl);

                    // Store the image in storage/app/public/product-images
                    Storage::disk('public')->put($path, $imageContents);

                    // Optional: Get the public URL of the stored image
                    // $publicUrl = asset('storage/' . $path);

                    $newproductimage = new ProductImages();
                    $newproductimage->product_id = $newproduct->id;
                    $newproductimage->image = $path;
                    $newproductimage->save();
                }
            }
        }
    }
}
