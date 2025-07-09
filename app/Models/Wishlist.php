<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;
	public $table = 'wishlists';
    public $primaryKey = 'id';
	
	public function product_data(){
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
