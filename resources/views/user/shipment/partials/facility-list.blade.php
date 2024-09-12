<p>{{$respo['response']['output']['resultsReturned']}} FedEx facilities found within 100 miles.</p>
<label for="">Select a Facility</label>
<select class="form-select" name="facility" id="facility">
    @foreach ($respo['response']['output']['locationDetailList'] as $k=>$v)
    <option
    data-street_1="{{$v['contactAndAddress']['address']['streetLines'][0]}}"
    data-street_2="{{isset($v['contactAndAddress']['address']['streetLines'][1]) ? $v['contactAndAddress']['address']['streetLines'][1] : ''}}"
    data-city="{{$v['contactAndAddress']['address']['city']}}"
    data-state="{{$v['contactAndAddress']['address']['stateOrProvinceCode']}}"
    data-sotrehours={{json_encode($v['storeHours'])}}
    data-currentday="{{strtoupper(date('l'))}}"
    data-contact="{{json_encode($v['contactAndAddress']['contact'])}}"
    
     value="{{$v['contactAndAddress']['address']['streetLines'][0]}}, {{$v['contactAndAddress']['address']['city']}} {{$v['contactAndAddress']['address']['stateOrProvinceCode']}} {{$v['contactAndAddress']['address']['postalCode']}} {{$v['contactAndAddress']['address']['countryCode']}}"
     >
     {{$v['contactAndAddress']['address']['streetLines'][0]}}, {{$v['contactAndAddress']['address']['city']}} {{$v['contactAndAddress']['address']['stateOrProvinceCode']}} {{$v['contactAndAddress']['address']['postalCode']}} {{$v['contactAndAddress']['address']['countryCode']}} - {{$v['contactAndAddress']['address']['stateOrProvinceCode']}} {{$v['contactAndAddress']['address']['postalCode']}} {{$v['distance']['value']}} Miles
    </option>
    @endforeach
</select>
<span id="fedex_street_1"></span>
<span class="error text-danger"></span>
<span id="fedex_city"></span>
<span class="error text-danger"></span>
<span id="fedex_zipcode"></span>
<span class="error text-danger"></span>


<div id="facility-info"></div> 