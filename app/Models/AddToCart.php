<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddToCart extends Model
{
    use HasFactory;
	
	public $table = 'add_to_carts';
    public $primaryKey = 'id';
	
	public $timestamps = true;

    protected function serializeDate(\DateTimeInterface $date){
        return $date->format('Y-m-d H:i:s');
    }
	
	public function product_data(){
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
	
	public function images_data(){
        return $this->hasMany(ProductImages::class, 'product_id', 'product_id')->orderBy('id', 'asc');
    } 
}
