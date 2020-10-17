<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adjustment extends Model
{
    use HasFactory;

    protected $table = "adjustments";
    protected $fillable = [
        'location_id', 'location_name',
        'product', 'stock_quantity','adjustment'
    ];
}
