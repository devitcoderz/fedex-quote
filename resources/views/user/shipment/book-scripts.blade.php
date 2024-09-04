<script>
$(document).ready(function(){
    $(document).on("change",'input[name="to_address_type"]',function(){
        var addrType = $('input[name="to_address_type"]:checked').val()
        
        $("#to-fedex-address").hide()
        $("#to-new-address").show()
        
        if(addrType === 'fedex'){
            $("#to-new-address").hide()
            $("#to-fedex-address").show()
        }
    })

    $(document).on("click","#btn-fedex_search_by_zipcode",function(){
        var btn = $(this);
        
        var code = $("#fedex_search_by_zipcode").val();

        if(code === ''){
            alert("Enter pincode");
            return false;
        }

        if(isNaN(code) || code.length < 5){
            alert("Pincode must be a numeric and no less than 5 numbers");
            return false;
        }
        btn.html('Loading');
        $.ajax({
            url:"{{route('user.get.fedex-location-by-zipcode.ajax')}}",
            type:"get",
            data:{
                zipcode:code
            },
            success:function(response){
                btn.html('Search');
                if(response.code == 200){// susccess
                    $("#fedex-search-by-zipcode-respo").html(response.data)
                }else if(response.code == 400){ // no result, geo invalid
                    $("#fedex-search-by-zipcode-respo").html(`
                    Invalid Pincode
                    `)
                }else if(response.code == 201){ // token invalid
                    $("#fedex-search-by-zipcode-respo").html(`
                    Invalid Token
                    `)
                }else{ // other api errors
                    console.log(response);
                    $("#fedex-search-by-zipcode-respo").html(`
                    Something went wrong
                    `)
                }
            }
        });
    })

    $(document).on("change","#facility",function(){
        var sotreHours  = $(this).find(':selected').data('sotrehours')
        var currentDay  = $(this).find(':selected').data('currentday')
        var address  = $(this).val()

        var tableHtml = '<table class="table">';
        $.each(sotreHours,function(i,e){
            var current = currentDay === e.dayOfWeek ? 'currentDay' : '';
            var td = '<td>'+e.dayOfWeek+'</td><td colspan="2">CLOSED</td>';
            if(e.operationalHours){
                td = `
                <td>`+e.dayOfWeek+`</td>
                <td> `+e.operationalHours.begins+` - `+e.operationalHours.ends+`</td>
                <td></td>

                `;
            }

            tableHtml += `
            <tr class="`+current+`">
                `+td+`
            </td>
            `;
        })
        tableHtml += '</table>'
        tableHtml += '<p>'+address+'</p>'

        tableHtml += `
        <div class="row">
            <div class="col-xl-6 col-xxl-6">
                <div class="mb-3">
                    <label for="fedex_first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                    <input type="text" name="fedex_first_name" id="fedex_first_name" class="form-control form-control-lg">
                </div>
            </div>
            <div class="col-xl-6 col-xxl-6">
                <div class="mb-3">
                    <label for="fedex_last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                    <input type="text" name="fedex_last_name" id="fedex_last_name" class="form-control form-control-lg">
                </div>
            </div>
      
             <div class="col-xl-6 col-xxl-6">
                <div class="mb-3">
                    <label for="fedex_phone_number" class="form-label">Phone Number <span class="text-danger">*</span></label>
                    <input type="text" name="fedex_phone_number" id="fedex_phone_number" class="form-control form-control-lg">
                </div>
            </div>
             <div class="col-xl-6 col-xxl-6">
                <div class="mb-3">
                    <label for="fedex_email" class="form-label">Email</label>
                    <input type="text" name="fedex_email" id="fedex_email" class="form-control form-control-lg">
                </div>
            </div
        </div
        <div class="mb-3">
            <label class="form-check form-check-inline">
                <input name="fedex_save_to_address_book" id="fedex_save_to_address_book" class="form-check-input" type="checkbox" value="save">
                <span class="form-check-label">
                    Save to address book
                </span>
            </label>
        </div>
        `;
        $("#facility-info").html(tableHtml);
        
    })

    $(document).on("click","#btn-get-rates",function(){
        var from_address_type = $("#from_address_type").val();
        var from_first_name = $("#from_first_name").val()
        var from_company = $("#from_company").val()
        var from_street_1 = $("#from_street_1").val()
        var from_street_2 = $("#from_street_2").val()
        var from_city = $("#from_city").val()
        var from_state = $("#from_state").val()
        var from_zipcode = $("#from_zipcode").val()
        var from_phone_number = $("#from_phone_number").val()
        var from_save_to_address_book = $("#from_save_to_address_book").val()
        var from_make_address_default = $("#from_make_address_default").val()

        
        //========

        var to_address_type = $("#to_address_type").val(); //fedex , new
        var to_first_name = $("#to_first_name").val();
        var to_last_name = $("#to_last_name").val();
        var to_company = $("#to_company").val();
        var to_street_1 = $("#to_street_1").val();
        var to_street_2 = $("#to_street_2").val();
        var to_city = $("#to_city").val();
        var to_state = $("#to_state").val();
        var to_zipcode = $("#to_zipcode").val();
        var to_phone_number = $("#to_phone_number").val();
        var to_email = $("#to_email").val();
        var to_save_to_address_book = $("#to_save_to_address_book").val();

        //==
        var fedex_search_by_zipcode = $("#fedex_search_by_zipcode").val();
        fedex_search_by_zipcode
        



    })
})
</script>