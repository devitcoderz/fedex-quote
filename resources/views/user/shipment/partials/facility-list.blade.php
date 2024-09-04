<p>{{$respo['response']['output']['resultsReturned']}} FedEx facilities found within 100 miles.</p>
<label for="">Select a Facility</label>
<select class="form-select" name="facility" id="facility">
    @foreach ($respo['response']['output']['locationDetailList'] as $k=>$v)
    <option
    data-sotrehours={{json_encode($v['storeHours'])}}
    data-currentday="{{strtoupper(date('l'))}}"
     value="{{$v['contactAndAddress']['address']['streetLines'][0]}}, {{$v['contactAndAddress']['address']['city']}} {{$v['contactAndAddress']['address']['stateOrProvinceCode']}} {{$v['contactAndAddress']['address']['postalCode']}} {{$v['contactAndAddress']['address']['countryCode']}}"
     >
     {{$v['contactAndAddress']['address']['streetLines'][0]}}, {{$v['contactAndAddress']['address']['city']}} {{$v['contactAndAddress']['address']['stateOrProvinceCode']}} {{$v['contactAndAddress']['address']['postalCode']}} {{$v['contactAndAddress']['address']['countryCode']}} - {{$v['contactAndAddress']['address']['stateOrProvinceCode']}} {{$v['contactAndAddress']['address']['postalCode']}} {{$v['distance']['value']}} Miles
    </option>
    @endforeach
</select>

<div id="facility-info"></div> 