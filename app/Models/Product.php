<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Product extends Model
{
    use HasFactory , Translatable;

    protected $guarded = [];
    public $translatedAttributes = ['name' , 'description'];
    protected $appends = ['image_path'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function getImagePathAttribute($value)
    {
        return asset('uploads/product_images/' . $this->image);
    }
}
