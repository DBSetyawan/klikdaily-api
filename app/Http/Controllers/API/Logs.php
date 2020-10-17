<?php

namespace App\Http\Controllers\API;

use App\Models\Log;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Resources\LogResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Responsefail;

class Logs extends Controller
{
    public function getByLogs($location_id){
        $d = Log::whereIn('location_id', [$location_id])->get();

        // dd($d);

        if($d->isEmpty()){
            
            return Responsefail::fails(400, "Failed, logs not found");

        } else {


            foreach ($d as $key => $value) {
                # code...
                $location_id = $value->location_id;
                $location_name = $value->location_name;
                $product = $value->product;
                $current_qty = $value->location->quantity;
                $dsa[] = $value;
    
            }
    
            foreach ($dsa as $key => $value) {
    
                $logs[$key] = Arr::only($value->toArray(),['id','created_at','type','adjustment','quantity']);
                unset($value->location);
                
            }
    
                return LogResponse::success(200, $logs, "Success, log found", $location_id, $location_name, $product, $current_qty);

        }

    }
}
