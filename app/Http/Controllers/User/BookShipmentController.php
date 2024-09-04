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
        $response =  $fedex->fedexLocationByPincode("90630");
        echo "<pre>"; print_r($response['response']['output']);
    }

    public function get_fedex_location_by_zipcode_ajax(FedExService $fedex,Request $request){
        $code =  $request->zipcode;
        $respo = $fedex->fedexLocationByPincode($code);

 
        if($respo['status_code'] == 200){
            $view = view('user.shipment.partials.facility-list',compact('respo'))->render();
            $finalResutl = [
                'success'=>true,
                'code'=>200,
                'data'=>$view
            ];
        }else{
            $finalResutl = [
                'success'=>true,
                'code'=>$respo['status_code'],
                'response'=>$respo
            ];
        }

        return $finalResutl;
    }
}
