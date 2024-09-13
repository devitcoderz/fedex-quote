@extends('admin.layouts.app')

@section('content')
<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3"><strong>Orders</strong> Shipment</h1>
            
        <div class="row">
            <div class="col-xl-12 col-xxl-12 d-flex">
                <div class="w-100">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Orders</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle" data-feather="shopping-cart"></i>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="row">
                                <div class="col">
                                    @if (!empty($orders))
                       
                                    <table class="table">
                                        <tr>
                                            <th>#</th>
                                            <th>User</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Stripe Receipt</th>
                                            <th>Download Label</th>
                                        </tr>
                                        @foreach ($orders as $k=>$v)
                                        <tr>
                                            <td>{{$k+1}}</td>
                                            <td>
                                                <b>{{$v['user']['name']}}</b> <br>
                                                <b>{{$v['user']['email']}}</b><br>
                                            </td>
                                            <td>
                                                <b>Name:</b> {{$v['from_first_name']." ".$v['from_last_name']}}<br>
                                                <b>Company:</b> {{$v['from_company']}}<br>
                                                <b>Address:</b> {{$v['from_street_1']}},{{$v['from_city']}},{{$v['from_state']}},{{$v['from_zipcode']}}
                                            </td>
                                            <td>
                                                <b>Name:</b> {{$v['to_first_name']." ".$v['to_last_name']}}<br>
                                                <b>Company:</b> {{$v['to_company']}}<br>
                                                <b>Address:</b> {{$v['to_street_1']}},{{$v['to_city']}},{{$v['to_state']}},{{$v['to_zipcode']}}
                                            </td>
                                            <td>
                                                <a target="_blank" class="text-info" href="{{$v['stripe_receipt_url']}}">Payment Receipt</a>
                                            </td>
                                            <td>
                                                @if ($v['fedex_image_type'] == 'encodedLabel')
                                                <a target="_blank" class="text-info" href="{{asset('images/'.$v['fedex_image'])}}">Label</a>
                                                @endif
                                                
                                                @if ($v['fedex_image_type'] == 'url')
                                                <a target="_blank" class="text-info" href="{{$v['fedex_image']}}">Label</a>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </table>
                                    @endif

                                    @empty($orders)
                                    <h4>No Orders Yet</h4>
                                    @endempty
                                </div>
                            </div>
                        </div>
                    </div>
                            
                </div>
            </div>    
        </div>
         

        
    </div>
</main>
@endsection

@section('scripts')
@if (Session::has('success'))
<script>
var successMsgs = "{{json_encode(Session::get('success'))}}";
$.each(successMsgs,function(i,e){
    toatr.success(e);
})
</script>
@endif
@endsection

@section('styles')
<style>
.currentDay td{
    font-weight: bold;
}
</style>
@endsection

