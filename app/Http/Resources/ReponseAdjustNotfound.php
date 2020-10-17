<?php

namespace App\Http\Resources;

class ReponseAdjustNotfound
{
   protected static $response = [

            'status_code' => null,
            'error_message' => null
   ];

   public static function fails($code = null, $message = null){
        
          self::$response['status_code'] = $code;
          self::$response['error_message'] = $message;

        return response()->json(self::$response);

   }

}
