<?php

namespace App\Http\Controllers\API;

use App\Models\Log;
use App\Models\stock;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\Adjustment as Adj;
use App\Http\Controllers\API\Logs;
use App\Http\Resources\AdjustmentN;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdjustmentResponse;

class Adjustment extends Controller
{
    public function Adjusted(Request $request){

        $product = stock::all();
        foreach ($product as $value) {
            $products[] = $value->product;
            $location[] = $value->id;

        }

        foreach ($request->product as $key => $value) {
            # code...
            $index = array_search($value, $products);
            if( $index === false){

                $location_id[] = $request->all()['location_id'][$key];
                $adjustment[] = $request->all()['adjustment'][$key];
                $productR[] = $request->all()['product'][$key];

                $filteredqty = Arr::where($adjustment, function ($value, $key) {
                    return is_string($value);
                });

                $filteredproduct = Arr::where($productR, function ($value, $key) {
                    return is_string($value);
                });

                $dataqty = $filteredqty;
                $dataproduct = $filteredproduct;


            } else {

                $location_id[] = $index;
                $dsa[] = $request->all()['location_id'][$key];
                $adjustmentsInarray[] = $request->all()['adjustment'][$key];
                $productR[] = $request->all()['product'][$key];
                
            }
            
        }

        $filtered = Arr::where($location_id, function ($value, $key) {
            return is_string($value);
        });

        $filteredAdjustment = Arr::where($adjustmentsInarray, function ($value, $key) {
            return is_string($value);
        });
        
        $data = $filtered;
        $dataADJ = $filteredAdjustment;
        if(!$data){

            $data_adjustment = count(stock::all());
            $foreachAdjustment = stock::whereIn('id', $dsa)->get();
            foreach ($foreachAdjustment as $key => $value) {

                $prs[] = (array)$value->product;
                $locname[] = $value->location;
                $id[] = $value->id;
                $qty[] = $value->quantity;
                $pr[] = $value->location;

                if($this->check_numb($dataADJ[$key]) == "Positive"){

                    $s[] = $value->quantity + (int)$dataADJ[$key];

                    foreach ($s as $keys => $d) {

                        $datax = [
                            'quantity' => $d
                        ];
                    }

                    $type = "Inbound";

                } else {

                    $s[] = $value->quantity - str_replace("-",'',(int)$dataADJ[$key]);

                    foreach ($s as $keys => $d) {

                        $datax = [
                            'quantity' => $d
                        ];
                    }

                    $type = "Outbound";

                }

                $in[] = $type;

                $sd = stock::where('id',$id[$key])->update($datax);

                $adjustments[] = count((array)$sd);
                
            }
            foreach ($request->location_id as $x => $value) {

                $AF[] = Adj::create([
                    'location_id' => $value,
                    'location_name' => $locname[$x],
                    'product' => $productR[$x],
                    'adjustment' => $dataADJ[$x],
                    'stock_quantity' => $s[$x]
                ]);

                    Log::create([
                        'location_id' => $value,
                        'location_name' => $locname[$x],
                        'product' => $productR[$x],
                        'adjustment' => $dataADJ[$x],
                        'quantity' => $s[$x],
                        'type' => $in[$x],
                    ]);
    
                
            }

            $adjusted = count($adjustments);

                $requested = count($request->all()['location_id']);

                foreach (collect($AF) as $key => $value) {
                    # code...
                    $rest[] = Arr::add(Arr::except($value,['created_at']),'status',"Success");
                }

            return AdjustmentN::adjustchecks(200, $rest, $requested, $adjusted);

        } 
            else {

                $foreachAdjustment = stock::whereNotIn('id', $data)->get();
                foreach ($foreachAdjustment as $key => $value) {

                    $id[] = $value->id;
                    $qty[] = $value->quantity;
                    $pr[] = $value->location;
                    $prs[] = $value->product;
                    $locname[] = $value->location;

                    if($this->check_numb($dataADJ[$key]) == "Positive"){
                        $s[] = $value->quantity + (int)$dataADJ[$key];
                        $logs = [
                            'location_id' => $id,
                            'location_name' => $locname,
                            'product' => $prs,
                            'adjustment' => $request->adjustment,
                            'quantity' => $qty,
                            'type' => "Outbound",
                        ];

                        foreach ($s as $keys => $d) {
    
                            $datas = [
                                'quantity' => $d
                            ];
        
                        }

                        $type = "Inbound";
    
                        $sd = stock::where('id',$id)->update($datas);

                        Log::create([
                            'location_id' => $id[$key],
                            'location_name' => $locname[$key],
                            'product' => $prs[$key],
                            'adjustment' => $dataADJ[$key],
                            'quantity' => $s[$key],
                            'type' => $type,
                        ]);

                    } else {

                        $s[] = $value->quantity - str_replace("-",'',(int)$dataADJ[$key]);

                        $logs = [
                            'location_id' => $id,
                            'location_name' => $locname,
                            'product' => $dataproduct[$key],
                            'adjustment' => $dataqty,
                            'quantity' => $qty,
                            'type' => "Inbound",
                        ];

                        foreach ($s as $keys => $d) {
    
                            $datas = [
                                'quantity' => $d
                            ];
        
                        }
                        
                        $type = "Outbound";
    
                        $sd = stock::where('id',$id)->update($datas);

                        Log::create([
                            'location_id' => $id[$key],
                            'location_name' => $locname[$key],
                            'product' => $prs[$key],
                            'adjustment' => $dataADJ[$key],
                            'quantity' => $s[$key],
                            'type' => $type,
                        ]);

                    }

                    $AF = Adj::create([
                        'location_id' => $id[$key],
                        'location_name' => $pr[$key],
                        'product' => $prs[$key],
                        'adjustment' => $dataADJ[$key],
                        'stock_quantity' => $s[$key]
                    ]);

                    $adjustments[] = count((array)$sd);

                    $f = $id[$key];
                }

                $adjusted = count($adjustments);

                $requested = count($dsa);
    
                $invalid = [
                    'status' => 'Failed',
                    'error_message' => 'Invalid Product',
                    'location_id' => $f,
                    'updated_at' => now()
                ];

            return AdjustmentResponse::adjustchecks(200, $AF, $requested, $adjusted, $invalid);

        }

    }

    protected function check_numb($vals){

    if ( $vals > 0 ) {
          return 'Positive';
      } elseif( $vals < 0 ) {
          return 'Negative';
        }
    }

}
