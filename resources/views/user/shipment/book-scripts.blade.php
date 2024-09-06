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

        var from = {};
        var to = {}
        var package = {};
        
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
            to.city = $("#facility").find(':selected').data('city');
            to.state = $("#facility").find(':selected').data('state');
        }

       

        package.weight = $("#weight").val();
        package.length = $("#length").val();
        package.width = $("#width").val();
        package.height = $("#height").val();
        package.description = $("#description").val();


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
                    if(response.response[0].customerMessages){

                    }
                    var from_address = from.street_1+" "+from.city+", "+from.state+", "+from.zipcode;
                    $("#confirm_from_address_container").html(`
                    <div class="mb-3">
                        <label class="form-check form-check-inline">
                            <input class="form-check-input" checked type="radio"  name="confirm_from_address" id="confirm_from_address"  value="new">
                            <span class="form-check-label" id="confirm_from_address_text">
                                `+from_address+`
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
                    // toastr.error(result.error)
                }else{ //  unknow code
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