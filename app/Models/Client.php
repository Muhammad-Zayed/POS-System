<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function scopeSearch($query)
    {
        return $query->when(request()->search,function($q) {
            return $q->
            where('name' ,'like','%'.request()->search.'%');
        });
    }
}
