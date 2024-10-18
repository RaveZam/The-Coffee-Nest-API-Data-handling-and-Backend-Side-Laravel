<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'product_price',
        'category',
        'stocks',
        'img_url',
        'desc'
    ];
    public function sales()
    {
        return $this->hasMany(Sales::class);
    }
    public function test()
    {
        return $this->hasMany(Test::class);
    }
}