<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cars extends Model
{
    use HasFactory;

    protected $table = 'cars';

    protected $fillable = [
        'name',
        'brand',
        'model',
        'no_plat',
        'price',
        'status',
        'image',
    ];

    protected $casts = [
        'price' => 'float',
    ];
}
