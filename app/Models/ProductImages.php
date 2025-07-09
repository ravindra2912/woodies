<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
{
    use HasFactory;

    public $table = 'product_images';
    public $primaryKey = 'id';

    protected $appends = ['imageurl'];

    public function getImageUrlAttribute()
    {
        return getImage($this->image);
    }
}
