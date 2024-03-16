<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id',
        'customer_name',
        'customer_contact',
        'start_date',
        'end_date',
        'return_date',
        'additional_cost',
    ];

    protected $table = 'rentals';
}
