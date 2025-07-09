<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductReview extends Model
{
    use HasFactory, SoftDeletes;
	public $table = 'product_reviews';
    public $primaryKey = 'id';
	
	public $timestamps = true;
	protected function serializeDate(\DateTimeInterface $date){
        return $date->format('Y-m-d H:i:s');
    }
	
	public function User_data(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
	
	public function product_data(){
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
