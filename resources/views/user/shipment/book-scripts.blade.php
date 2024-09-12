<script>
$(document).ready(function(){
    var from = {};
    var to = {}
    var package = {};
    var shipping = {};
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
                    <span class="error text-danger"></span>
                </div>
            </div>
            <div class="col-xl-6 col-xxl-6">
                <div class="mb-3">
                    <label for="fedex_last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                    <input type="text" name="fedex_last_name" id="fedex_last_name" class="form-control form-control-lg">
                    <span class="error text-danger"></span>
                </div>
            </div>
      
             <div class="col-xl-6 col-xxl-6">
                <div class="mb-3">
                    <label for="fedex_phone_number" class="form-label">Phone Number <span class="text-danger">*</span></label>
                    <input type="text" name="fedex_phone_number" id="fedex_phone_number" class="form-control form-control-lg">
                    <span class="error text-danger"></span>
                </div>
            </div>
             <div class="col-xl-6 col-xxl-6">
                <div class="mb-3">
                    <label for="fedex_email" class="form-label">Email</label>
                    <input type="text" name="fedex_email" id="fedex_email" class="form-control form-control-lg">
                    <span class="error text-danger"></span>
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
        $(".error").html('')
        
        var btnRates = $(this);
        btnRates.html("loading...");

        from.address_type = $('input[name="from_address_type"]:checked').val();
        from.first_name = $("#from_first_name").val()
        from.last_name = $("#from_last_name").val()
        from.company = $("#from_company").val()
        from.street_1 = $("#from_street_1").val()
        from.street_2 = $("#from_street_2").val()
        from.city = $("#from_city").val()
        from.state = $("#from_state").val()
        from.zipcode = $("#from_zipcode").val()
        from.phone_number = $("#from_phone_number").val()
        from.save_to_address_book = $("#from_save_to_address_book").is(":checked")
        from.make_address_default = $("#from_make_address_default").is(":checked")

        
        //========

        to.address_type = $('input[name="to_address_type"]:checked').val(); //fedex , new
        to.save_to_address_book = $("#to_save_to_address_book").is(":checked");

        if(to.address_type == 'new'){
            to.first_name = $("#to_first_name").val();
            to.last_name = $("#to_last_name").val();
            to.company = $("#to_company").val();
            to.street_1 = $("#to_street_1").val();
            to.street_2 = $("#to_street_2").val();
            to.city = $("#to_city").val();
            to.state = $("#to_state").val();
            to.zipcode = $("#to_zipcode").val();
            to.phone_number = $("#to_phone_number").val();
            to.email = $("#to_email").val();
        }else if(to.address_type == 'fedex'){
            to.first_name = $("#fedex_first_name").val();
            to.last_name = $("#fedex_last_name").val();
            to.zipcode = $("#fedex_search_by_zipcode").val();
            to.phone_number = $("#fedex_phone_number").val();
            to.email = $("#fedex_email").val();

            to.street_1 = $("#facility").find(':selected').data('street_1');
            to.street_2 = $("#facility").find(':selected').data('street_2');
            to.city = $("#facility").find(':selected').data('city');
            to.state = $("#facility").find(':selected').data('state');
            var contact = $("#facility").find(':selected').data('contact');

            to.company = contact.companyName;

        }

       

        package.weight = $("#weight").val();
        package.length = $("#length").val();
        package.width = $("#width").val();
        package.height = $("#height").val();
        package.description = $("#description").val();
        package.shipment_date = $("#shipment_date").val();


        $.ajax({
            url:"{{route('user.shipment.book.validation.ajax')}}",
            type:"post",
            data:{
                validate:"form1",
                from:from,
                to:to,
                package:package
            },
            success:function(response){
                console.log(response)
                if(response.code == 200){ // success
                    console.log(response)
                    // if (response.response[0] &&
                    //     response.response[0].customerMessages[0] &&
                    //     response.response[0].customerMessages[0].code & 
                    //     response.response[0].customerMessages[0].code == 'STANDARDIZED.ADDRESS.NOTFOUND') {
                    //         toastr.error("From address not found");
                    //         return false;
                      
                    // }

                    // if (response.response[1] &&
                    //     response.response[1].customerMessages[0] &&
                    //     response.response[1].customerMessages[0].code & 
                    //     response.response[1].customerMessages[0].code == 'STANDARDIZED.ADDRESS.NOTFOUND') {
                    //         toastr.error("To address not found");
                    //         return false;
                      
                    // }
                    

                    var from_address = from.street_1+" "+from.city+", "+from.state+", "+from.zipcode;
                    $("#confirm_from_address_container").html(`
                    <div class="mb-3">
                        <label class="form-check form-check-inline">
                            <input class="form-check-input" checked type="radio"  name="confirm_from_address" id="confirm_from_address"  value="from">
                            <span class="form-check-label" id="confirm_from_address_text">
                                `+from_address+`
                            </span>
                        </label>
                    </div>
                    `);

                    var to_address = to.street_1+" "+to.city+", "+to.state+", "+to.zipcode;
                    $("#confirm_to_address_container").html(`
                    <div class="mb-3">
                        <label class="form-check form-check-inline">
                            <input class="form-check-input" checked type="radio"  name="confirm_to_address" id="confirm_to_address"  value="to">
                            <span class="form-check-label" id="confirm_to_address_text">
                                `+to_address+`
                            </span>
                        </label>
                    </div>
                    `);
                    $("#form-1").hide();
                    $("#form-2").show();

                    
                    
                   
                }else if(response.code == 202){ // form erros
                    console.log(response.errors)
                    toastr.error(response.msg);
                    if(response.errors.from){
                        $.each(response.errors.from,function(i,e){
                            $.each(e,function(index,error){
                                $("#from_"+i).next('span.error').html(error)
                            })
                        })
                    }

                    var to_prefix  =to.address_type == 'new' ? 'to' : 'fedex';
 
                    if(response.errors.to){
                        $.each(response.errors.to,function(i,e){
                            $.each(e,function(index,error){
                                $("#"+to_prefix+"_"+i).next('span.error').html(error)
                            })
                        })
                    }

                    if(response.errors.package){
                        $.each(response.errors.package,function(i,e){
                            $.each(e,function(index,error){
                                $("#"+i).next('span.error').html(error)
                            })
                        })
                    }
                }else if(response.code == 201){ // toast erros
                    console.log('address validation api error')
                    console.log(response.response)
                    if(response.response.errors){
                        $.each(response.response.errors,function(i,e){
                            if(e.code){
                                toastr.error(e.message)
                            }
                        })
                    }
                   
                }else{ //  unknow code
                    // toastr.error("Unknown Code");
                }

                btnRates.html("Get Rates")
            },
            error:function(err,errI){
                console.log(err)
                console.log(errI)
            }
        })

    })

    function changeDateFormat(date){
        // const dateStr = '2024-09-10T08:00:00';
        const dateStr = date;
        const dateObj = new Date(dateStr);

        // Define options for formatting
        const options = {
        weekday: 'long', // "Tuesday"
        year: 'numeric', // "2024"
        month: 'short', // "Sep"
        day: 'numeric', // "10"
        hour: 'numeric', // "10"
        minute: 'numeric', // "30"
        hour12: true, // "AM/PM"
        };

        // Format the date according to the options
        const formattedDate = dateObj.toLocaleString('en-US', options);
        return formattedDate;
        // console.log(formattedDate); // Example output: "Tuesday, Sep 10, 2024, 8:00 AM"

    }

    $(document).on("click","#btn-confirm-address",function(){

        $.ajax({
            url:"{{route('user.shipment.book.rates-and-transit-times.ajax')}}",
            type:"post",
            data:{
                from:from,
                to:to,
                package:package
            },
            success:function(response){
                console.log(response)
                if(response.code == 200){ // success
                    console.log("RATE FETCH API SUCCESS")
                    console.log(response)
                    var ratesHtml = '';
                    $.each(response.response,function(i,e){
                        var dateToDisplay = changeDateFormat(e.commit.dateDetail.dayFormat);
                        ratesHtml += `
                        <tr>
                            <td>
                                <div class="mb-3">
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio"  name="service_type" id="service_type_`+i+`" data-total-amount="`+e.ratedShipmentDetails[0].totalNetFedExCharge+`"  value="`+e.serviceType+`">
                                        <span class="form-check-label">
                                            <b>`+e.serviceName+`</b> <br>Arriving `+dateToDisplay+`
                                        </span>
                                    </label>
                                </div>
                            </td>
                            <td><b>`+e.ratedShipmentDetails[0].totalNetCharge+`</b><br><small>Retail</small></td>
                            <td><b class="text-danger">`+e.ratedShipmentDetails[0].totalDiscounts+`</b><br><small>You Save</small></td>
                            <td><b class="text-success">`+e.ratedShipmentDetails[0].totalNetFedExCharge+`</b><br><small>Your Cost</small></td>
                        </tr>
                        `;
                    });

                    
                    $("#rates-table tbody").html(ratesHtml)
                    $("#display_from_name").html(from.first_name + " "+from.last_name);
                    $("#display_from_company").html(from.company);
                    $("#display_from_street").html(from.street_1);
                    $("#display_from_city_state_zipcode").html(from.city+", "+from.state+", "+from.zipcode);

                    $("#display_to_name").html(to.first_name + " "+to.last_name);
                    $("#display_to_company").html(to.company);
                    $("#display_to_street").html(to.street_1);
                    $("#display_to_city_state_zipcode").html(to.city+", "+to.state+", "+to.zipcode);

                    $("#display_pkg_description").html(package.description);
                    $("#display_pkg_dimention").html(package.length+"X"+package.width+"X"+package.height);
                    $("#display_pkg_weight").html(package.weight);

                    $("#form-2").hide();
                    $("#form-3").show();
                   
                }else if(response.code == 202){ // form erros
                    console.log(response.errors)
                    toastr.error(response.msg);
                   
                }else if(response.code == 201){ // toast erros
                    console.log('Rate Fetch API ERROR')
                    console.log(response.response)
                    if(response.response.errors){
                        $.each(response.response.errors,function(i,e){
                            if(e.code){
                                toastr.error(e.message)
                            }
                        })
                    }
                   
                }else{ //  unknow code
                    console.log('unknown code')
                    console.log(response)
                    // toastr.error("Unknown Code");
                }

            },
            error:function(err,errI){
                console.log(err)
                console.log(errI)
            }
        })
    })
    

    $(document).on("click","#btn-continue-to-checkout",function(){
        shipping.service_type = $('input[name="service_type"]:checked').val();
        shipping.amount = $('input[name="service_type"]:checked').data('total-amount')
        
        $.ajax({
            url:"{{route('user.shipment.book.checkout.ajax')}}",
            type:"post",
            data:{
                from:from,
                to:to,
                package:package,
                shipping:shipping
            },
            success:function(response){
                console.log(response)
                if(response.code == 200){ // success
                    console.log("BOOK CHECKOUT SUCCESS")
                    console.log(response)

                    window.location.href = response.redirect;
                    
                }else if(response.code == 202){ // form erros
                    console.log(response.errors)
                    toastr.error(response.msg);
                   
                }else if(response.code == 201){ // toast erros
                    console.log('BOOK CHECKOUT ERROR')
                    console.log(response.response)
                    // if(response.response.errors){
                    //     $.each(response.response.errors,function(i,e){
                    //         if(e.code){
                    //             toastr.error(e.message)
                    //         }
                    //     })
                    // }
                   
                }else{ //  unknow code
                    console.log('unknown code')
                    console.log(response)
                    // toastr.error("Unknown Code");
                }

            },
            error:function(err,errI){
                console.log(err)
                console.log(errI)
            }
        })
    })
})
</script>