<?php

namespace App\Http\Resources;

class StocksResponse
{
   protected static $response = [

            'status_code' => null,
            'status_message' => null,
            'stocks' => null,
   ];

   public static function success($code = null, $data = null, $message){
        
       self::$response['status_message'] = $message;
        self::$response['status_code']= $code;
        self::$response['stocks'] = $data;

        return response()->json(self::$response);

   }

}
