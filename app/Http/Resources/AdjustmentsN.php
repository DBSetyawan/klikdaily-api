<?php

namespace App\Http\Resources;

class AdjustmentN
{
   protected static $response = [

            'status_code' => null,
            'requested' => null,
            'adjusted' => null,
            'results' => [],
   ];

   public static function adjustchecks($code = null, $data = null, $request = null, $adjusted = null){
        
          self::$response['requested'] = $request;
          self::$response['adjusted'] = $adjusted;
          self::$response['status_code']= $code;
          self::$response['results'] = $data;

        return response()->json(self::$response);

   }

}
