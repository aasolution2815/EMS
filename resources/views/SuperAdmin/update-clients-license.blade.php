@extends('Layout.app')
@section('content')
<style>
    .error_label_select2{
        position: relative;
        margin: 0px 5px;
        font-size: 11px;
        top: 55px;
    }
</style>
<div>
    <div class=" h1_weight_700 shadow_patch">
        <div id="textbox" class="">
            <p class="alignleft bold_heavy bold_font_heading">Update LiCense <label class="grey_small_text"
                    id="totalclient"></label></p>
                    <p class="alignright margin-top_10">
                        <a href="javascript:history.back()"><span class="btn_with_icon" style="margin-right: 15px;"><i  class="feather icon-corner-up-left  small_icon_left"></i>
                             Back </span></a>

                    </p>
        </div>
        <div style="clear: both;"></div>
        <div>
            <form action="#" id="clientpanel">
                <div class="row padding_5">
                    <div class="col-md-12 col-sm-12 col-xs-12 padding_10">
                        <label for="name" class="dropdown_label_light">Select Client</label>
                        <div>
                            <select class="js-example-basic-single" id="clientids" name="clientids" required="" data-parsley-trigger="blur" data-parsley-required-message="Required">
                                <option value=""></option>
                                @foreach ($data as $client)
                                <option value="{{$client->CLIENT_ID}}">{{$client->COMPANYNAME}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 padding_10 centered">

                        <button class="cancel_btnn btnn" onclick="closePanel(event)">Cancel</button>
                        <button class="primary_btnn btnn" onclick="openPannel(event)">Show results</button>
                    </div>
                </div>
            </form>

        </div>
        <div id="textbox" class="">

            <div class="">
                <div class="accordion" id="accordionExample">
                    <div class="card">
                        <div class="card-head" id="headingTwo">

                        </div>

                    </div>
                </div>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                <div>
                    <div class="row ">
                        <div class="col-md-12 col-sm-12 col-xs-12 padding_15">
                            <form action="#" id="client_form">
                                <div id="form_patch">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-6 col-xs-12 margin_bottom_10">
                                            <div>
                                                <label for="name" class="label_patch">User Limit</label>
                                                <div class="inputWithIcon">
                                                    <input type="number" id="user_lmit" required=""
                                                        data-parsley-trigger="blur"
                                                        data-parsley-required-message="Required"
                                                        class="input_text margin_top_0 form-control"
                                                        placeholder="User Limit">
                                                    <i class="feather icon-user inside_input_icon"></i>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 margin_bottom_10">
                                            <div>
                                                <label for="name" class="label_patch">Start Date</label>
                                                <div class="inputWithIcon">
                                                    <input type="date" iname="startdate" id="startdate" required=""
                                                        data-parsley-trigger="blur"
                                                        data-parsley-required-message="Required"
                                                        class="input_text margin_top_0 form-control"
                                                        placeholder="Your name" value="{{date('Y-m-d')}}">
                                                    <i class="feather icon-calendar inside_input_icon"></i>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 margin_bottom_10">
                                            <div>
                                                <label for="name" class="label_patch">Select Type of expiry</label>
                                                <div class="inputWithIcon">
                                                    <i class="feather icon-hash inside_dropdown_icon"></i>
                                                    <div class="">
                                                        <select class="form-control drop_down_select" id="type_auth"
                                                            onchange="checktype(this)" required=""
                                                            data-parsley-trigger="blur"
                                                            data-parsley-required-message="Required">
                                                            <option value="">Select Type</option>
                                                            <option value="Days">Days</option>
                                                            <option value="Month">Month</option>
                                                            <option value="Year">Year</option>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 margin_bottom_10">
                                            <div>
                                                <label for="name" class="label_patch">No. of Days</label>
                                                <div class="inputWithIcon">
                                                    <input type="number" id="no_of_days"
                                                        onkeyup="getDate(this)" required="" data-parsley-trigger="blur"
                                                        data-parsley-required-message="Required"
                                                        class="input_text margin_top_0 form-control"
                                                        placeholder="No. of Days / Month / Year">
                                                    <i class="feather icon-hash inside_input_icon"></i>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 margin_bottom_10">
                                            <div>
                                                <label for="name" class="label_patch">End Date</label>
                                                <div class="inputWithIcon">
                                                    <input type="date" name="liciencedate" id="liciencedate" required=""
                                                        data-parsley-trigger="blur"
                                                        data-parsley-required-message="Required"
                                                        class="input_text margin_top_0 form-control"
                                                        placeholder="End Date" >
                                                    <i class="feather icon-calendar inside_input_icon"></i>

                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div id="textbox" class="">
                                        <p class="alignright">
                                            <button class="primary_btnn btnn" onclick="addClient(event)">Submit</button>
                                        </p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="clear: both;"></div>

    </div>
</div>
@endsection
@section('addscriptscontent')
<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var path = {!! json_encode(url('/')) !!};
    $(document).ready(function() {
        $(".js-example-basic-single").select2({
            placeholder: "Select Client",
            allowClear:true
        });
        $('#clientpanel').parsley({
            errorClass: 'is-invalid text-danger',
            successClass: 'is-valid', // Comment this option if you don't want the field to become green when valid. Recommended in Google material design to prevent too many hints for user experience. Only report when a field is wrong.
            errorsWrapper: '<span class="form-error error_label_select2"><i class="feather icon-x error_inputcolor"></i></span>',
            errorTemplate: '<span></span>',
            trigger: 'change'
        });
        $('#client_form').parsley({
            errorClass: 'is-invalid text-danger',
            successClass: 'is-valid', // Comment this option if you don't want the field to become green when valid. Recommended in Google material design to prevent too many hints for user experience. Only report when a field is wrong.
            errorsWrapper: '<span class="form-error error_label"><i class="feather icon-x error_inputcolor"></i></span>',
            errorTemplate: '<span></span>',
            trigger: 'change'
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            error: function (x, status, error) {
                if (x.status == 403) {
                    alert("Sorry, your session has expired. Please login again to continue");
                    window.location.href ="/";
                } else {
                    alert("An error occurred: " + status + "nError: " + error);
                }
            }
        });
    });
    function openPannel(event) {
        var isValid = true;
        $('#clientpanel').each( function() {
            if ($(this).parsley().validate() !== true) isValid = false;
        });
        if (isValid) {
            var clientids = $("#clientids").val();
            // alert(clientids);
            $.ajax({
                url: path  +  '/SuperAdmin/get-client-details',
                type: 'POST',
                data: {
                    clientids:clientids,
                },
                success: function(data) {
                    var USERLIMIT = data.USERLIMITS;
                    var AUTHENTICATION_START = data.AUTHENTICATION_START;
                    var AUTHENTICATION_TYPE = data.AUTHENTICATION_TYPE;
                    var AUTHENTICATION_NUMBER = data.AUTHENTICATION_NUMBER;
                    var AUTHENTICATION_END = data.AUTHENTICATION_END;
                    $("#user_lmit").val(USERLIMIT);
                    $("#startdate").val(AUTHENTICATION_START);
                    $("#type_auth").val(AUTHENTICATION_TYPE);
                    $("#no_of_days").val(AUTHENTICATION_NUMBER);
                    $("#liciencedate").val(AUTHENTICATION_END);
                    $("#collapseTwo").collapse('show');
                },
            })

            event.preventDefault();
        }
    }

    function addClient(event) {
        event.preventDefault();
        var isValid = true;
        $('#client_form').each( function() {
            if ($(this).parsley().validate() !== true) isValid = false;
        });
        if (isValid) {

            var clientids = $("#clientids").val();
            var user_lmit = $("#user_lmit").val();
            var startdate = $("#startdate").val();
            var type = $("#type_auth").val();
            var no_of_days = $("#no_of_days").val();
            var expiry_date = $("#liciencedate").val();
            $.ajax({
                url: path  +  '/SuperAdmin/update-client-licienses',
                type: 'POST',
                data: {
                    clientids:clientids,
                    user_lmit:user_lmit,
                    type: type,
                    no_of_days:no_of_days,
                    startdate: startdate,
                    expiry_date:expiry_date,
                },
                success: function(data) {
                    var response = data.trim();
                    if (response == 'DONE') {
                        alert('Licenses Updated Succesfully');
                        location.reload();
                        // window.history.back();
                    }else  {
                        alert('Something Went Wrong');
                    }
                },
            });

        }
    }
    function closePanel(event) {
        $('#client_form').get(0).reset()
        $("#collapseTwo").collapse('hide');
        event.preventDefault();
    }
    function getDate(atrr) {
        var getnumber = $(atrr).val();
        var gettype = $("#type_auth").val();
        var mydate = $("#startdate").val();
        // alert(gettype);
        if (gettype == 'Days') {
            if(!getnumber == ''){
                var days = parseInt(getnumber);

                var d = new Date(mydate);
                var year = d.getFullYear();
                var month = d.getMonth();
                var day = d.getDate();
                var finaldateindays = new Date(year , month , day+ days);
                var formateddate = formateDate(finaldateindays, '/')
                var formateddate2 = formateDate(finaldateindays, '-')

                $('#liciencedate').attr('disabled',false);
                $("#liciencedate").val(formateddate2)
                console.log(formateddate2);
            } else {
                $('#liciencedate').attr('disabled',true);
                $("#liciencedate").val('')

            }
        }  else if (gettype == 'Month') {
            if(!getnumber == ''){
                var months = parseInt(getnumber);
                var d = new Date(mydate);

                var year = d.getFullYear();
                var month = d.getMonth();
                var day = d.getDate();
                var addmonths = month + months;
                var finaldateindays = new Date(year , addmonths , day);
                var formateddate2 = formateDate(finaldateindays, '-')
                $('#liciencedate').attr('disabled',false);
                $("#liciencedate").val(formateddate2)
                console.log(formateddate2);
            } else {
                $('#liciencedate').attr('disabled',true);
                $("#liciencedate").val('')

            }
        } else if (gettype == 'Year') {
            if(!getnumber == ''){
                var years = parseInt(getnumber);
                var d = new Date(mydate);
                var year = d.getFullYear();
                var month = d.getMonth();
                var day = d.getDate();
                var addyears = parseInt(year) + years;
                var finaldateinyears = new Date(addyears, month, day);
                var formateddate2 = formateDate(finaldateinyears, '-')
                $('#liciencedate').attr('disabled',false);
                $("#liciencedate").val(formateddate2)
                console.log(formateddate2);
            } else {
                $('#liciencedate').attr('disabled',true);
                $("#liciencedate").val('')

            }
        } else {
            $('#liciencedate').attr('disabled',true);
                $("#liciencedate").val('')

        }
    }

    function formateDate(date_format,formate) {
        // alert(date_format)
        var d1 = date_format.getDate().toString();
        var m1 = (date_format.getMonth()+1).toString();
        // console.log(m1);
        var date = d1.padStart(2, '0');
        var month = m1.padStart(2, '0');
        var gettheformat = '';
        if (formate == '/') {
            gettheformat = date+'/'+ month +'/'+date_format.getFullYear();
        } else {
            gettheformat = date_format.getFullYear()+'-'+ month +'-'+date;
        }

        return gettheformat
    }

    function checktype(atrr) {
        var gettype = $(atrr).val();
        // alert(gettype);
        if (gettype == 'Days') {
            $("#no_of_days").val("");
            $('#no_of_days').attr('disabled',false);
            $("#no_of_days").attr("placeholder", "No Of Days");
            $("#liciencedate").val('')

        } else if (gettype == 'Month') {
            $("#no_of_days").val("");
            $('#no_of_days').attr('disabled',false);
            $("#no_of_days").attr("placeholder", "No Of Month");
            $("#liciencedate").val('')

        } else if (gettype == 'Year') {
            $("#no_of_days").val("");
            $('#no_of_days').attr('disabled',false);
            $("#no_of_days").attr("placeholder", "No Of Year");
            $("#liciencedate").val('')

        } else {
            $("#no_of_days").val("");
            $('#no_of_days').attr('disabled',true);
            $("#no_of_days").attr("placeholder", "No Of Days / Month / Year");
            $("#liciencedate").val('')

        }

    }
</script>
@endsection
