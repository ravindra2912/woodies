<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orders extends Model
{
    use HasFactory, SoftDeletes;
	
	public $table = 'orders';
    public $primaryKey = 'id';

	protected $appends = ['order_date', 'order_status_name'];

	public function getOrderDateAttribute()
    {
        return isset($this->created_at) ? get_date($this->created_at):null;
    }
	
	public function getOrderStatusNAmeAttribute()
    {
        if(isset($this->status)){
			$orderStatus = OrderStatus::find($this->status);
			if($orderStatus){
				return $orderStatus->name;
			}
		}
		return null;
    }
	
	public function order_items_data(){
        return $this->hasMany(OrdersItems::class, 'order_id', 'id')->with(['order_items_data:id']);
    }
	
	public function seller_order_items_data(){
        $q = $this->hasMany(OrdersItems::class, 'order_id', 'id')
		->select('orders_items.*')
		->Join('products', 'products.id', '=', 'orders_items.product_id', 'right');
		if(Auth::user()->role_id != 1){
			$q = $q->where('p.user_id', Auth::user()->id);
		}
		return $q;
    }
	
	public function user_data(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
	
	public function order_status(){
        return $this->hasOne(OrderStatus::class, 'id', 'status');
    }
	
	public function order_logs_status(){
        $res = $this->hasMany(OrderLog::class, 'order_id', 'id')
			->join('order_statuses','order_statuses.id','order_logs.order_status')
			->orderBy('order_logs.created_at','desc')
			->select('order_logs.*','order_statuses.name');
		
		 return $res;
    }
}
