<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
      protected $fillable = [
        'location_id', 'location_id',
        'product', 'current_qty','location_name',
        'logs','adjustment','type','quantity'
    ];

    public function location(){

      return $this->BelongsTo(stock::class, 'location_id');
    }
}
