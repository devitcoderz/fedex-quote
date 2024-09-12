@extends('user.layouts.app')

@section('content')
{{-- {{dd($checkout)}} --}}
<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">Checkout</h1>
        {{-- <form id="form-3" action="" method="POST"> --}}
            <div class="row">
                <div class="col-xl-3 col-xxl-3 d-flex">
                    <div class="w-100">
                        <div class="card" style="height: 90%">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">From</h5>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col" style="line-height: 0.5rem;s">
                                            <p id="display_from_name">{{$checkout['from']['first_name']." ".$checkout['from']['last_name']}}</p>
                                            <p id="display_from_company">{{$checkout['from']['company']}}</p>
                                            <p id="display_from_street">{{$checkout['from']['street_1']}}</p>
                                            <p id="display_from_city_state_zipcode">{{$checkout['from']['city']}},{{$checkout['from']['state']}},{{$checkout['from']['zipcode']}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-xxl-3 d-flex">
                    <div class="w-100">
                        <div class="card" style="height: 90%">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">To</h5>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col" style="line-height: 0.5rem;s">
                                            <p id="display_from_name">{{$checkout['to']['first_name']." ".$checkout['to']['last_name']}}</p>
                                            {{-- <p id="display_from_company">{{$checkout['to']['company']}}</p> --}}
                                            <p id="display_from_street">{{$checkout['to']['street_1']}}</p>
                                            <p id="display_from_city_state_zipcode">{{$checkout['to']['city']}},{{$checkout['to']['state']}},{{$checkout['to']['zipcode']}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-xxl-3 d-flex">
                    <div class="w-100">
                        <div class="card" style="height: 90%">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Package</h5>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col" style="line-height: 0.5rem;s">
                                            <p id="display_pkg_description">{{$checkout['package']['description']}}</p>
                                            <p id="display_pkg_dimention">{{$checkout['package']['length']}}X{{$checkout['package']['width']}}X{{$checkout['package']['height']}}</p>
                                            <p id="display_pkg_weight">{{$checkout['package']['weight']}}</p>
                                            <p>&nbsp;</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-xxl-3 d-flex">
                    <div class="w-100">
                        <div class="card" style="height: 90%">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Pice</h5>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col" style="line-height: 0.5rem;s">
                                            <p id="price"><b>Your Price:</b> ${{$checkout['shipping']['amount']}}</p>
                                            {{-- <p id="display_pkg_dimention">Company</p>
                                            <p id="display_pkg_weight">Street</p>
                                            <p>&nbsp;</p> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-xxl-12 d-flex">
                    <div class="w-100">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Stripe Payment</h5>
                                    </div>

                                    <div class="col-auto">
                                        {{-- Selected Ship Date: Monday Sep 09, 2024 --}}
                                        
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col" style="line-height: 1rem;">
                                        <form id="payment-form" action="{{route('user.checkout.submit')}}" method="post">
                                            @csrf
                                            <div class="form-row">
                                              <label for="card-number-element">Card Number</label>
                                              <div id="card-number-element"></div> <!-- Card number element -->
                                            </div>
                                          
                                            <div class="form-row">
                                              <label for="card-expiry-element">Expiration Date</label>
                                              <div id="card-expiry-element"></div> <!-- Expiry date element -->
                                            </div>
                                          
                                            <div class="form-row">
                                              <label for="card-cvc-element">CVC</label>
                                              <div id="card-cvc-element"></div> <!-- CVC element -->
                                            </div>
                                          
                                            <!-- Display errors if any -->
                                            <div id="card-errors" role="alert"></div>
                                          
                                            <button type="submit" >Pay Now</button>
                                            
                                          </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {{-- </form> --}}
    </div>
</main>
@endsection

@section('scripts')
@include('user.checkout.checkout-scripts')
@if (Session::has('error'))
<script>
var errs = "{{json_encode(Session::get('error'))}}";
$.each(errs,function(i,e){
    toastr.error(e);
})
</script>
@endif
@endsection

@section('styles')
<script src="https://js.stripe.com/v3/"></script>
<style>
    #card-number-element, #card-expiry-element, #card-cvc-element {
      border: 1px solid #ccc;
      padding: 10px;
      border-radius: 4px;
      margin-bottom: 10px;
    }
  
    #card-errors {
      color: red;
      margin-top: 10px;
    }
  
    button {
      background-color: #28a745;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
  
    button:hover {
      background-color: #218838;
    }
  </style>
  
  
@endsection


