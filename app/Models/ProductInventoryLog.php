<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductInventoryLog extends Model
{
    use HasFactory, SoftDeletes;
	public $table = 'product_inventory_logs';
    public $primaryKey = 'id';
}
