<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrdersItems extends Model
{
    use HasFactory, SoftDeletes;
	
	public $table = 'orders_items';
    public $primaryKey = 'id';
	
	public function order_items_data(){
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
