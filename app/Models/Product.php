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
    protected $appends = ['image_path' , 'profit_percent'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class , 'product_order')->withPivot('quantity');
    }

    public function getImagePathAttribute($value)
    {
        return asset('uploads/product_images/' . $this->image);
    }

    public function getProfitPercentAttribute($value)
    {
        $profit = $this->sell_price - $this->purchase_price ;
        return round( $profit * 100  /  $this->purchase_price ,2 );
    }

    public function scopeSearch($query)
    {
        return $query->when(request()->search,function($q) {
            return $q->whereTranslationLike('name' ,'%'.request()->search.'%');
        });
    }

    public function scopeFilter($query)
    {
        return $query->when(request()->category_id,function($q) {
            return $q->where('category_id' ,request()->category_id);
        });
    }
}
