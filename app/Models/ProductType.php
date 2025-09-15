<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'api_unique_number',
    ];

    public function products(): BelongsToMany
    {
        return $this->morphedByMany(Products::class, 'typeable');
    }

    public function categories(): BelongsToMany
    {
        return $this->morphedByMany(ProductCategories::class, 'typeable');
    }

}
