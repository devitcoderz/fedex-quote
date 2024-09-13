<?php

namespace App\Http\Controllers\Admin;

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

class DashController extends Controller
{
    public function dashboard(){
        return view("admin.dashboard");
    }

    public function shipment_orders(){
        $orders = Order::with('user')->orderBy("id","desc")->get()->toArray();
        return view("admin.shipment.orders",compact('orders'));
    }
}
