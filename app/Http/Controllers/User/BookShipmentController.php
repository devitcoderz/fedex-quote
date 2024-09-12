<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use App\Services\FedExService;
use App\Services\CartService;

use App\Models\State;
use App\Models\Order;

use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\Charge;


use Auth;

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
        $response =  $fedex->fedexLocationByPincode("90630");
        echo "<pre>"; print_r($response); die;
        // $from = [
        //     'streets' => [
        //         '2970 S Hermitage Rd'
        //     ],
        //     'city'=>'Hermitage',
        //     'state'=>'PA',
        //     'zipcode'=>'44444',
        // ];
        // $to = [
        //     'streets' => [
        //         '2451 palm dr'
        //     ],
        //     'city'=>'Signal Hill',
        //     'state'=>'CA',
        //     'zipcode'=>'90755',
        // ];
        // $response =  $fedex->fedexAddressValidation($from,$to);
        // $response =  $fedex->fedexServiceAvailability();

        $from =[
            'city'=>'BEDFORD',
            'state'=>'OH',
            'zipcode'=>'44444'
        ];
        $to = [
            'city'=>'Jamaica',
            'state'=>'NY',
            'zipcode'=>'11430'
        ];
        $package = [
            'weight'=>10,
            'length'=>10,
            'width'=>10,
            'height'=>10
        ];
        $response = $fedex->fedexRatesAndTransitTimes($from,$to,$package);
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
                'phone_number' => 'required|numeric|min:10',
                'company'=>'required|min:5',
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
                'phone_number' => 'required|numeric|min:10',
                'company'=>'required|min:5',
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
                'description'=>'required|string',
                
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
                    'msg'=>'Something went wrong with api call',
                    'response'=>$response['response']
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

    public function rates_and_transit_times_ajax(FedExService $fedex,Request $request){
        
        $input = $request->all();

       
        $response = $fedex->fedexRatesAndTransitTimes($input['from'],$input['to'],$input['package']);


        if($response['status_code'] == 200){
            $respo = $response['response']['output']['rateReplyDetails'];
            $finalResult = [
                'success'=>true,
                'code'=>200,
                'msg'=>'Validation Success',
                'response'=>$respo
            ];
        }else{
            return "inside 201";
            $finalResult = [
                "success"=>false,
                'code'=>201,
                'msg'=>'Something went wrong with api call',
                'response'=>$response
            ];
        }

        return $finalResult;
    }
    
    public function book_checkout_ajax(Request $request,CartService $cart){
        $from  = $request->from;
        $to  = $request->to;
        $package  = $request->package;
        $shipping  = $request->shipping;

        $shippingDetails = [
            'from'=>$from,
            'to'=>$to,
            'package'=>$package,
            'shipping'=>$shipping
        ];

        Session::put("checkout",$shippingDetails);

        $finalResult = [
            'success'=>true,
            'code'=>200,
            'msg'=>'Checkout Created',
            'checkout'=>$shippingDetails,
            'redirect'=> route('user.checkout')
        ];

        return $finalResult;
    }

    public function checkout(){
        if(!Session::has('checkout')){
            return redirect()->route('user.dashboard');
        }

        $checkout = Session::get("checkout");
        // dd($checkout);
        return view('user.checkout.checkout',compact('checkout'));
    }

    public function checkout_submit(FedExService $fedex,Request $request){
        $checkout = Session::get("checkout");
        $from = $checkout['from'];
        $to = $checkout['to'];
        $package = $checkout['package'];
        $shipping = $checkout['shipping'];

        

        // Determine the correct Stripe secret key based on the environment
        $stripeKey = config('services.stripe.env') === 'production'
            ? config('services.stripe.live_secret')
            : config('services.stripe.test_secret');

        // Set the Stripe secret key
        Stripe::setApiKey($stripeKey);

        // Create the charge
        $charge = Charge::create([
            'amount' => $shipping['amount'] * 100, // amount in cents
            'currency' => 'usd',
            'source' => $request->stripeToken,
            'description' => 'Payment Description',
        ]);

        $chargeId = $charge->id;
        $amountCaptured = $charge->amount_captured;
        $balanceTransactionId = $charge->balance_transaction;
        $isCaptured = $charge->captured; //true/false
        $TxnCreatedAt = $charge->created; // 1726088491 // timestamp
        $receipt_url = $charge->receipt_url;
        $status = $charge->status; // succeeded
        

        if($isCaptured && $status == 'succeeded'){
            $user_id = Auth::user()->id;
            $order_data = [
                'user_id'=>$user_id,

                'from_address_type'=>$from['address_type'],
                'from_first_name'=>$from['first_name'],
                'from_last_name'=>$from['last_name'],
                'from_company'=>$from['company'],
                'from_street_1'=>$from['street_1'],
                'from_street_2'=>$from['street_2'],
                'from_city'=>$from['city'],
                'from_state'=>$from['state'],
                'from_zipcode'=>$from['zipcode'],
                'from_phone_number'=>$from['phone_number'],
                'from_save_to_address_book'=>$from['save_to_address_book'],
                'from_make_address_default'=>$from['make_address_default'],
        
                'to_address_type'=>$to['address_type'],
                'to_save_to_address_book'=>$to['save_to_address_book'],
                'to_first_name'=>$to['first_name'],
                'to_last_name'=>$to['last_name'],
                'to_zipcode'=>$to['zipcode'],
                'to_phone_number'=>$to['phone_number'],
                'to_email'=>$to['email'],
                'to_street_1'=>$to['street_1'],
                'to_city'=>$to['city'],
                'to_state'=>$to['state'],
        
                'package_weight'=>$package['weight'],
                'package_length'=>$package['length'],
                'package_width'=>$package['width'],
                'package_height'=>$package['height'],
                'package_description'=>$package['description'],
                'package_shipment_date'=>$package['shipment_date'],
        
                'shipping_service_type'=>$shipping['service_type'],
                'shipping_amount'=>$shipping['amount'],
        
                'stripe_charge_id'=>$chargeId,
                'stripe_amount_captured'=>$amountCaptured,
                'stripe_balance_transaction_id'=>$balanceTransactionId,
                'stripe_is_captured'=>$isCaptured,
                'stripe_txn_created_at'=>$TxnCreatedAt,
                'stripe_receipt_url'=>$receipt_url,
                'stripe_status'=>$status,
                'stripe_response'=>json_encode($charge),

            ];  
            
            $order = Order::create($order_data);
            if($order->id){
                
                $response = $fedex->fedexShipping($from,$to,$package,$shipping);
                if($response['status_code'] == 200){
                    $respo = $response['response']['output']['transactionShipments'][0];
                    $masterTrackingNumber = $respo['masterTrackingNumber'];
                    $shipDatestamp = $respo['shipDatestamp']; //2024-09-14
                    $serviceName = $respo['serviceName'];
                    $serviceCategory = $respo['serviceCategory'];

                    $deliveryDatestamp = $respo['pieceResponses'][0]['deliveryDatestamp'];
                    if(isset($respo['pieceResponses'][0]['packageDocuments'][0]['encodedLabel'])){
                        $image = $respo['pieceResponses'][0]['packageDocuments'][0]['encodedLabel'];
                        $image_type = "encodedLabel";

                        $imageData = base64_decode($image);
                        $fileName = 'image_'.$user_id."_". time() . '.png'; 
                        $filePath = public_path('images/' . $fileName);

                        // Ensure the directory exists
                        if (!File::exists(public_path('images'))) {
                            File::makeDirectory(public_path('images'), 0755, true);
                        }
                    
                        // Save the decoded image data as a file
                        file_put_contents($filePath, $imageData);
            
                        $image = $fileName;
                    }else{
                        $image = $respo['pieceResponses'][0]['packageDocuments'][0]['url'];
                        $image_type = "url";
                    }

                    $carrierCode = $respo['completedShipmentDetail']['carrierCode'];

                    $fedex_respo = json_encode($response);

                    $update_order = [
                        'fedex_master_tracking_number'=>$masterTrackingNumber,
                        'fedex_ship_datestamp'=>$shipDatestamp,
                        'fedex_service_name'=>$serviceName,
                        'fedex_service_category'=>$serviceCategory,
                        'fedex_delivery_datestamp'=>$deliveryDatestamp,
                        'fedex_carrier_code'=>$carrierCode,
                        'fedex_image_type'=>$image_type,
                        'fedex_image'=>$image,
                        'fedex_status_code'=>$response['status_code'],
                        "fedex_response"=>json_encode($response),
                    ];

                    $updated = Order::where("id",$order->id)->update($update_order);
                    if($updated){
                        return redirect()->route('user.orders')->with("success",['Shipping label created. you can download you shipping lable.']);
                    }else{
                        return redirect()->route('user.checkout')->with("error",['Something went wrong with updating order']);
                    }
                }else{
                    Order::where("id",$order->id)->update([
                        'fedex_status_code'=>$response['status_code'],
                        "fedex_response"=>json_encode($response),
                    ]);
                    return redirect()->route('user.checkout')->with("error",['Something went wrong with fedex api.']);
                }
            }else{
                return redirect()->route('user.checkout')->with("error",['Something went wrong with creating order']);
            }
        }else{
            return redirect()->route('user.checkout')->with("error",['Payment Failed']);
        }
    }
}
