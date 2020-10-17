<?php

namespace App\Http\Resources;

class LogResponse
{
   protected static $response = [

            'status_code' => null,
            'status' => null,
            'location_id' => null,
            'location_name' => null,
            'product' => null,
            'current_qty' => null,
            'logs' => [],
   ];

   public static function success($code = null, $data = null, $message, $location_id = null, $location_name = null, $product = null, $current_qty = null){
        
          self::$response['status_code'] = $code;
          self::$response['status'] = $message;
          self::$response['location_id']= $location_id;
          self::$response['location_name']= $location_name;
          self::$response['product']= $product;
          self::$response['current_qty']= $current_qty;
          self::$response['logs'] = $data;

        return response()->json(self::$response);

   }

}
