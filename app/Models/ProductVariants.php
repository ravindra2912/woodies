<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariants extends Model
{
    use HasFactory, SoftDeletes;
	public $table = 'product_variants';
    public $primaryKey = 'id';
	
	public function product_data(){
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
