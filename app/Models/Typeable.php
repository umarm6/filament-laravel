<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Typeable extends Model
{
    /** @use HasFactory<\Database\Factories\TypeableFactory> */
    use HasFactory;

    protected $fillable = [
        'typeable_id',
        'typeable_type',
    ];

    public function typeable(): MorphTo
    {
        return $this->morphTo();
    }

}
