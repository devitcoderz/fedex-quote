@extends('layouts.app')
@section('content')
<!-- Contact Start -->
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-md-12">
                <table class="table table-responsive">
                    {{-- <tbody>
                        <th>Service</th>
                        <th>Retail</th>
                        <th>You Save</th>
                        <th>Your Cost</th>
                    </tbody> --}}
                    <tbody>
                        @foreach ($quote['output']['rateReplyDetails'] as $service)
                        <tr>
                            <td>
                                <h4>{{$service['serviceDescription']['description']}}</h4>
                                <p>Arriving {{date('l M d,Y h:iA',strtotime($service['commit']['dateDetail']['dayFormat']))}}</p>
                            </td>
                            <td>
                                <p>Retail</p>
                                <h4>{{$service['ratedShipmentDetails'][0]['totalNetCharge']}}</h4>
                            </td>
                            <td>
                                <p>You Save</p>
                                <h4>{{$service['ratedShipmentDetails'][0]['totalDiscounts']}}</h4>
                            </td>
                            <td>
                                <p>Your Cost</p>
                                <h4>{{$service['ratedShipmentDetails'][0]['totalNetFedExCharge']}}</h4>
                            </td>
                        </tr>
                      
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection