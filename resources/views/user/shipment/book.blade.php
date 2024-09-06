@extends('user.layouts.app')

@section('content')
<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3"><strong>Book</strong> Shipment</h1>
        <form id="form-1" action="#" method="post">
            @csrf
            <div class="row">
                <div class="col-xl-6 col-xxl-6 d-flex">
                    <div class="w-100">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">From</h5>
                                    </div>

                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle" data-feather="truck"></i>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-check form-check-inline">
                                                <input class="form-check-input" checked type="radio"  name="from_address_type" id="from_address_type"  value="new">
                                                <span class="form-check-label">
                                                  New Address
                                                </span>
                                            </label>
                                        </div>
                                        <div class="new-address">
                                            <div class="mb-3">
                                                <label for="from_first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                                <input type="text" name="from_first_name" id="from_first_name" class="form-control form-control-lg">
                                                <span class="error text-danger"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="from_last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                                <input type="text" name="from_last_name" id="from_last_name" class="form-control form-control-lg">
                                                <span class="error text-danger"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="from_company" class="form-label">Company</label>
                                                <input type="text" name="from_company" id="from_company" class="form-control form-control-lg">
                                                <span class="error text-danger"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="from_street_1" class="form-label">Street 1 <span class="text-danger">*</span></label>
                                                <input type="text" name="from_street_1" id="from_street_1" class="form-control form-control-lg">
                                                <span class="error text-danger"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="from_street_2" class="form-label">Street 2</label>
                                                <input type="text" name="from_street_2" id="from_street_2" class="form-control form-control-lg">
                                                <span class="error text-danger"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="from_city" class="form-label">City <span class="text-danger">*</span></label>
                                                <input type="text" name="from_city" id="from_city" class="form-control form-control-lg">
                                                <span class="error text-danger"></span>
                                            </div>
    
                                            <div class="mb-3">
                                                <label for="from_state" class="form-label">State</label>
                                                <select name="from_state" id="from_state" class="form-select">
                                                    <option value="">Select State</option>
                                                    @foreach ($states as $k=>$v)
                                                    <option value="{{$v->code}}">{{$v->code}} - {{$v->state}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="error text-danger"></span>
                                            </div>
    
                                            <div class="mb-3">
                                                <label for="from_zipcode" class="form-label">Zip Code <span class="text-danger">*</span></label>
                                                <input type="text" name="from_zipcode" id="from_zipcode" class="form-control form-control-lg">
                                                <span class="error text-danger"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="from_phone_number" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                                <input type="text" name="from_phone_number" id="from_phone_number" class="form-control form-control-lg">
                                                <span class="error text-danger"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-check form-check-inline">
                                                    <input name="from_save_to_address_book" id="from_save_to_address_book" class="form-check-input" type="checkbox">
                                                    <span class="form-check-label">
                                                      Save to address book
                                                    </span>
                                                </label>

                                                <label class="form-check form-check-inline">
                                                    <input class="form-check-input" name="from_make_address_default" id="from_make_address_default" type="checkbox">
                                                    <span class="form-check-label">
                                                      Make it default
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                                
                    </div>
                </div>

                <div class="col-xl-6 col-xxl-6 d-flex">
                    <div class="w-100">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">To</h5>
                                    </div>

                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle" data-feather="map-pin"></i>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            
                                            <label class="form-check form-check-inline">
                                                <input class="form-check-input"  type="radio" name="to_address_type" id="to_address_type_fedex"  value="fedex">
                                                <span class="form-check-label">
                                                    Ship to a FedEx Facility
                                                </span>
                                            </label>
                                            <label class="form-check form-check-inline">
                                                <input class="form-check-input" checked type="radio"  name="to_address_type" id="to_address_type_new"  value="new">
                                                <span class="form-check-label">
                                                  New Address
                                                </span>
                                            </label>
                                        </div>
                                        <div id="to-new-address">
                                            
                                            <div class="mb-3">
                                                <label for="to_first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                                <input type="text" name="to_first_name" id="to_first_name" class="form-control form-control-lg">
                                                <span class="error text-danger"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="to_last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                                <input type="text" name="to_last_name" id="to_last_name" class="form-control form-control-lg">
                                                <span class="error text-danger"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="to_company" class="form-label">Company</label>
                                                <input type="text" name="to_company" id="to_company" class="form-control form-control-lg">
                                                <span class="error text-danger"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="to_street_1" class="form-label">Street 1 <span class="text-danger">*</span></label>
                                                <input type="text" name="to_street_1" id="to_street_1" class="form-control form-control-lg">
                                                <span class="error text-danger"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="to_street_2" class="form-label">Street 2</label>
                                                <input type="text" name="to_street_2" id="to_street_2" class="form-control form-control-lg">
                                                <span class="error text-danger"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="to_city" class="form-label">City <span class="text-danger">*</span></label>
                                                <input type="text" name="to_city" id="to_city" class="form-control form-control-lg">
                                                <span class="error text-danger"></span>
                                            </div>
    
                                            <div class="mb-3">
                                                <label for="to_state" class="form-label">State</label>
                                                <select name="to_state" id="to_state" class="form-select">
                                                    <option value="">Select State</option>
                                                    @foreach ($states as $k=>$v)
                                                    <option value="{{$v->code}}">{{$v->code}} - {{$v->state}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="error text-danger"></span>
                                            </div>
    
                                            <div class="mb-3">
                                                <label for="to_zipcode" class="form-label">Zip Code <span class="text-danger">*</span></label>
                                                <input type="text" name="to_zipcode" id="to_zipcode" class="form-control form-control-lg">
                                                <span class="error text-danger"></span>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6 col-xxl-6">
                                                    <div class="mb-3">
                                                        <label for="to_phone_number" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                                        <input type="text" name="to_phone_number" id="to_phone_number" class="form-control form-control-lg">
                                                        <span class="error text-danger"></span>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-xl-6 col-xxl-6">
                                                    <div class="mb-3">
                                                        <label for="to_email" class="form-label">Email</label>
                                                        <input type="text" name="to_email" id="to_email" class="form-control form-control-lg">
                                                        <span class="error text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="mb-3">
                                                <label class="form-check form-check-inline">
                                                    <input class="form-check-input" name="to_save_to_address_book" id="to_save_to_address_book" type="checkbox">
                                                    <span class="form-check-label">
                                                      Save to address book
                                                    </span>
                                                </label>

                                                
                                            </div>
                                        </div>

                                        <div id="to-fedex-address" style="display: none;">
                                            <div class="row">
                                                <div class="col-xl-8 col-xxl-8">
                                                    <div class="mb-3">
                                                        <label for="fedex_search_by_zipcode" class="form-label">Search by zipcode <span class="text-danger">*</span></label>
                                                        <input type="text" name="fedex_search_by_zipcode" id="fedex_search_by_zipcode" class="form-control form-control-lg">
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-xxl-2">
                                                    <div class="mb-3 mt-3">
                                                        <button class="btn btn-sm btn-info mt-3" type="button" id="btn-fedex_search_by_zipcode">Search</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="fedex-search-by-zipcode-respo">
                                                
                                            </div>
                                            
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
                                        <h5 class="card-title">Shipment Date</h5>
                                    </div>

                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle" data-feather="calander"></i>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="row">
                                    <div class="col">
                                        <p>Your label can be used for 30 days, but choosing your desired shipment date will give you a more accurate delivery date in the quote.</p>
                                        <div class="mb-3">
                                            <label for="shipment_date" class="form-label"></label>
                                            <select name="shipment_date" id="shipment_date" class="form-select">
                                                @foreach ($shipment_dates as $k=>$v)
                                                <option value="{{$k}}">{{$v}}</option>
                                                @endforeach
                                            </select>
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
                                        <h5 class="card-title">Package</h5>
                                    </div>

                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle" data-feather="calander"></i>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="row">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col-xl-3 col-xxl-3">
                                                <div class="mb-3">
                                                    <label for="weight" class="form-label">Weight <span class="text-danger">*</span></label>
                                                    <input type="text" name="weight" id="weight" class="form-control form-control-lg" placeholder="Round upto nearest pound">
                                                    <span class="error text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-xxl-3">
                                                <div class="mb-3">
                                                    <label for="length" class="form-label">Length <span class="text-danger">*</span></label>
                                                    <input type="text" name="length" id="length" class="form-control form-control-lg" placeholder="Round upto nearest inch">
                                                    <span class="error text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-xxl-3">
                                                <div class="mb-3">
                                                    <label for="width" class="form-label">Width <span class="text-danger">*</span></label>
                                                    <input type="text" name="width" id="width" class="form-control form-control-lg" placeholder="Round upto nearest inch">
                                                    <span class="error text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-xxl-3">
                                                <div class="mb-3">
                                                    <label for="height" class="form-label">Height <span class="text-danger">*</span></label>
                                                    <input type="text" name="height" id="height" class="form-control form-control-lg" placeholder="Round upto nearest inch">
                                                    <span class="error text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-xxl-12">
                                                <div class="mb-3">
                                                    <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                                    <input type="text" name="description" id="description" class="form-control form-control-lg" placeholder="">
                                                    <span class="error text-danger"></span>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-xxl-12">
                                                <div class="mb-3">
                                                   <button type="button" class="btn btn-success" id="btn-get-rates" style="float: right;">Get Rates</button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <form id="form-2" action="#" method="post" style="display: none;">
            <div class="row">
                <div class="col-xl-6 col-xxl-6 d-flex">
                    <div class="w-100">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">From</h5>
                                    </div>

                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle" data-feather="truck"></i>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="row">
                                    <div class="col" id="confirm_from_address_container">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </form>
    </div>
</main>
@endsection

@section('scripts')
@include('user.shipment.book-scripts')
@endsection

@section('styles')
<style>
.currentDay td{
    font-weight: bold;
}
</style>
@endsection

