<?php

namespace App\Http\Controllers\API;

use App\Models\stock;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StocksResponse;

class Stocks extends Controller
{
    public function getAllStocks(){
            $d = stock::all();
    
        return StocksResponse::success(200, $d, "Success");

    }
}
