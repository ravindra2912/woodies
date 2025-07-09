<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VariantName extends Model
{
    use HasFactory, SoftDeletes;
	public $table = 'variant_names';
    public $primaryKey = 'id';
	
	public function variants_data(){
        return $this->hasMany(Variants::class, 'variant_name_id', 'id');
    } 
}
