<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Services\FedExService;

use App\Models\State;

class DashboardController extends Controller
{
    public function index(){
        return view('user.dashboard');
    }

    

}
