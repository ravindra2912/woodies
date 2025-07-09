<?php

namespace App\Imports;

use Auth;
use Str;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportProduct implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
     public function collection(Collection $rows)
    {
		$c = 0;
        foreach ($rows as $row) 
        {
			if($c != 0){
				if($row[0] != ''){
					$name = trim($row[0]);
					$slug = Str::slug($name);
					
					$product = new Product();
					$product->user_id = Auth::user()->id;
					$product->name = $name;
					$product->slug = $slug;
					$product->category_id = $row[1];
					$product->price = $row[2];
					$product->brand = $row[3];
					$product->quantity = $row[4];
					$product->description = $row[5];
					$product->short_description = $row[6];
					$product->additional_information = $row[7];
					$product->SEO_description = $row[8];
					$product->SEO_tags = $row[9];
					$product->is_variants = $row[10];
					$product->is_replacement = $row[11];
					$product->replacement_days = $row[12];
					$product->is_tax_applicable = $row[13];
					$product->igst = $row[14];
					$product->cgst = $row[15];
					$product->sgst = $row[16];
					$product->status = $row[17];
					$product->save();
				}
			}
			$c++;
        }
    }
}
