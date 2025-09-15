<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColors extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'hex_code',
        'description',
    ];

    function products()
    {
        return $this->hasMany(Products::class, 'product_color_id');
    }
}
