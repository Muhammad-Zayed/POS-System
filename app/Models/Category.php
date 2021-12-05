<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;


class Category extends Model
{
    use HasFactory, Translatable;

    protected $guarded = [];
    public $translatedAttributes = ['name'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function scopeSearch($query)
    {
        return $query->when(request()->search,function($q) {
            return $q->where('name' ,'like','%'.request()->search.'%');
        });
    }
}
