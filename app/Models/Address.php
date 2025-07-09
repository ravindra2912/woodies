<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes;
	
	public $table = 'addresses';
    public $primaryKey = 'id';
	
	  public $timestamps = true;
	  
	public function user_data(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
