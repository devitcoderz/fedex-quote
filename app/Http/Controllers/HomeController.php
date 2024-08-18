<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\FedExService;

class HomeController extends Controller
{
   
    public function index(){
        return view('index');
    }

    public function getQuickQuote(Request $request,FedExService $fedexService)
    {
        $request->validate([
            "from_zip"=>"required",
            "to_zip"=>"required",
            'weight'=>'required',
            'length'=>'required',
            'width'=>'required',
            'height'=>'required'
        ],$request->all());

        $data = $request->all();
        $quote = $fedexService->getShippingRate($data);

        // echo "<pre>"; print_r($rateResponse);
        return view("pages.quick-quote",compact('quote'));
    }
}



