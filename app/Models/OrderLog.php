<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderLog extends Model
{
    use HasFactory, SoftDeletes;
	
	public $table = 'order_logs';
    public $primaryKey = 'id';
	
	public function status_data(){
        return $this->hasOne(OrderStatus::class, 'id', 'order_status');
    }
}
