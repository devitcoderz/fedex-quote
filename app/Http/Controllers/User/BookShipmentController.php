<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\FedExService;
use Carbon\Carbon;
use App\Models\State;

class BookShipmentController extends Controller
{
    public function book_shipment(){
        $states = State::all();
        $today = Carbon::today();
        $shipment_dates = [];
        for ($i = 0; $i < 7; $i++) {
            $date =  $today->copy()->addDays($i)->format('Y-m-d');

            $fullNameOfDay = date("l",strtotime($date));
            if($fullNameOfDay == 'Saturday' || $fullNameOfDay == 'Sunday'){
                continue;
            }
            $shipment_dates[$date] = date("l M d, Y",strtotime($date));
        }

        return view("user.shipment.book",compact('states','shipment_dates'));
    }

    
    public function test(FedExService $fedex){
        // return $fedex->fedexShipping();
        // $response =  $fedex->fedexLocationByPincode("90630");
        $from = [
            'streets' => [
                '2970 S Hermitage Rd'
            ],
            'city'=>'Hermitage',
            'state'=>'PA',
            'zipcode'=>'44444',
        ];
        $to = [
            'streets' => [
                '2451 palm dr'
            ],
            'city'=>'Signal Hill',
            'state'=>'CA',
            'zipcode'=>'90755',
        ];
        $response =  $fedex->fedexAddressValidation($from,$to);
        // $response =  $fedex->fedexServiceAvailability();
        echo "<pre>"; print_r($response['response']['output']);
    }

    public function get_fedex_location_by_zipcode_ajax(FedExService $fedex,Request $request){
        $code =  $request->zipcode;
        $respo = $fedex->fedexLocationByPincode($code);

 
        if($respo['status_code'] == 200){
            $view = view('user.shipment.partials.facility-list',compact('respo'))->render();
            $finalResult = [
                'success'=>true,
                'code'=>200,
                'data'=>$view
            ];
        }else{
            $finalResult = [
                'success'=>true,
                'code'=>$respo['status_code'],
                'response'=>$respo
            ];
        }

        return $finalResult;
    }

    public function book_shipment_validation_ajax(FedExService $fedex,Request $request){
        $input = $request->all();

        if($input['validate'] == 'form1'){
            $from_valid = true;
            $to_valid = true;
            $package_valid = true;
            
            $from_rules =  [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'street_1' => 'required|string',
                'city' => 'required|string',
                'zipcode' => 'required|numeric|min:5',
                'phone_number' => 'required|numeric|min:5',
            ];
            $from_validator = Validator::make($input['from'],$from_rules);
            
            if($from_validator->fails()){
                $from_valid = false;
                $errors['from'] = $from_validator->getMessageBag()->toArray();    
            }

            $to_rules =  [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'street_1' => 'required|string',
                'city' => 'required|string',
                'zipcode' => 'required|numeric|min:5',
                'phone_number' => 'required|numeric|min:5',
            ];
            $to_validator = Validator::make($input['to'],$to_rules);
            
            if($to_validator->fails()){
                $to_valid = false;
                $errors['to'] = $to_validator->getMessageBag()->toArray();    
            }

            $package_rules =  [
                'weight' => 'required|numeric',
                'length' => 'required|numeric',
                'width' => 'required|numeric',
                'height' => 'required|numeric',
                'description'=>'required|string'
            ];
            $package_validator = Validator::make($input['package'],$package_rules);
            
            if($package_validator->fails()){
                $package_valid = false;
                $errors['package'] = $package_validator->getMessageBag()->toArray();    
            }


            if(!$from_valid || !$to_valid || !$package_valid){
                return [
                    'success'=>false,
                    'code'=>202,
                    'msg'=>'Validation Failed',
                    'errors'=>$errors
                ];
            }


            $from_streets[] = $input['from']['street_1'];
            if(isset($input['from']['street_2']) && !empty($input['from']['street_2'])):
            $from_streets[] = $input['from']['street_2'];
            endif;


            $to_streets[] = $input['to']['street_1'];
            if(isset($input['to']['street_2']) && !empty($input['to']['street_2'])):
            $to_streets[] = $input['to']['street_2'];
            endif;

            
                
            $from = [
                'streets' => $from_streets,
                'city'=>$input['from']['city'],
                'state'=>$input['from']['state'],
                'zipcode'=>$input['from']['zipcode'],
            ];

            $to = [
                'streets' => $to_streets,
                'city'=>$input['to']['city'],
                'state'=>$input['to']['state'],
                'zipcode'=>$input['to']['zipcode'],
            ];

            
            $response =  $fedex->fedexAddressValidation($from,$to);

            if($response['status_code'] == 200){
                $respo = $response['response']['output']['resolvedAddresses'];
                $finalResult = [
                    'success'=>true,
                    'code'=>200,
                    'msg'=>'Validation Success',
                    'response'=>$respo
                ];
            }else{
                $finalResult = [
                    "success"=>false,
                    'code'=>201,
                    'msg'=>'Something went wrong with api call'
                ];
            }
        }else{
            $finalResult = [
                "success"=>false,
                'code'=>201,
                'msg'=>'Invalid Validation Request'
            ];
        }

        return $finalResult;
    }
}
