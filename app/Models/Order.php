<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded =[];


    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class,'product_order')->withPivot('quantity');
    }

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function scopeSearch($query)
    {
        return $query->when(request()->search,function($q) {
            return $q->whereHas('client' , function ($query){
                return $query->where('name' ,'like','%'.request()->search.'%');
            });
        });
    }
}
