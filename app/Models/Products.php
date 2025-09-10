<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Products extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function color():  BelongsTo
    {
        return  $this->belongsTo(ProductColors::class,'product_color_id','id');
    }

    public function category():  BelongsTo
    {
        return  $this->belongsTo(ProductCategories::class,'product_category_id','id');
    }

}
