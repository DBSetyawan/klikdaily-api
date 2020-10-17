<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id',
        'product','quantity'
    ];

    public function location(){

        return $this->hasMany(Log::class, 'id');
      }
}
