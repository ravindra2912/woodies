<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;
	
	public $table = 'categories';
    public $primaryKey = 'id';
	
	public $timestamps = true;

    protected $appends = ['imageurl', 'banner_image_url'];

    public function getImageUrlAttribute()
    {
        return getImage($this->image);
    }

    public function getBannerImageUrlAttribute()
    {
        return getImage($this->banner_img);
    }

    protected function serializeDate(\DateTimeInterface $date){
        return $date->format('Y-m-d H:i:s');
    }

    public function parentCategory(){
        return $this->hasOne(Category::class, 'id', 'parent_id');
    }

    public function category_data(){
        return $this->hasOne(Category::class, 'id', 'parent_id');
    }
	
}
