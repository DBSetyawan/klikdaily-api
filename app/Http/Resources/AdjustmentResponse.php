<?php

namespace App\Http\Resources;

class AdjustmentResponse
{
   protected static $response = [

            'status_code' => null,
            'requested' => null,
            'adjusted' => null,
            'results' => null,
   ];

   public static function adjustchecks($code = null, $data = null, $request = null, $adjusted = null, $invalid){
        
          self::$response['requested'] = $request;
          self::$response['adjusted'] = $adjusted;
          self::$response['status_code']= $code;
          self::$response['results'] = [$data, $invalid];

        return response()->json(self::$response);

   }

}
