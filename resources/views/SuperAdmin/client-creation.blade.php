@extends('Layout.app')
@section('content')

<style></style>
<div>
    <div class="h1_weight_700 shadow_patch">
        <div id="textbox" class="">
            <p class="alignleft bold_heavy bold_font_heading" id="add_client">Add Client</p>
            <p class="alignright margin-top_10">
                <a href="javascript:history.back()"><span class="btn_with_icon" style="margin-right: 15px;"><i
                            class="feather icon-corner-up-left  small_icon_left"></i>
                        Back </span></a>
            </p>
        </div>
        <div style="clear: both;"></div>
        <form action="#" id="client_form">
            <div id="form_patch">
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12 margin_bottom_10">
                        <div style="text-align: center;margin-top: 30px;">
                            <label for="name" class="label_patch">Company Logo</label>
                            <div class="container">
                                <div class="avatar-upload">
                                    <div class="avatar-edit">
                                        <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />
                                        <label for="imageUpload"></label>
                                    </div>
                                    <div class="avatar-preview">
                                        <div id="imagePreview" style="background-image: url({{$images}});">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-8 col-sm-12 col-xs-12 margin_bottom_10">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12 margin_bottom_10">
                                <div style="margin-top: 30px;">
                                    <label for="name" class="label_patch">Company Name</label>
                                    <div class="inputWithIcon">
                                        <input type="text" id="company_name"
                                            class="input_text margin_top_0 form-control" placeholder="Company Name"
                                            required="" data-parsley-trigger="blur"
                                            data-parsley-required-message="Required">
                                        <i class="feather icon-briefcase inside_input_icon"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 margin_bottom_10">
                                <div style="margin-top: 30px;">
                                    <label for="name" class="label_patch">Admin Name</label>
                                    <div class="inputWithIcon">
                                        <input type="text" id="admin_name" required="" data-parsley-trigger="blur"
                                            data-parsley-required-message="Required"
                                            class="input_text margin_top_0 form-control" placeholder="Admin Name">
                                        <i class="feather icon-user inside_input_icon"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 margin_bottom_10">
                                <div>
                                    <label for="name" class="label_patch">Employee Code</label>
                                    <div class="inputWithIcon">
                                        <input type="text" id="empcode_format"
                                            class="input_text margin_top_0 form-control" placeholder="Employee Code"
                                            required="" data-parsley-trigger="blur"
                                            data-parsley-required-message="Required">
                                        <i class="feather icon-hash inside_input_icon"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 margin_bottom_10">
                                <div>
                                    <label for="name" class="label_patch">Prefix</label>
                                    <div class="inputWithIcon">
                                        <input type="text" id="client_prefix"
                                            class="input_text margin_top_0 form-control" placeholder="Prefix"
                                            required="" data-parsley-trigger="blur"
                                            data-parsley-required-message="Required">
                                        <i class="feather icon-user inside_input_icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4 col-sm-6 col-xs-12 margin_bottom_10">
                        <div>
                            <label for="name" class="label_patch">Email-ID</label>
                            <div class="inputWithIcon">
                                <input type="email" id="admin_emailid" class="input_text margin_top_0 form-control"
                                    placeholder="Email-ID" autocomplete="nope" required="" data-parsley-trigger="blur"
                                    onkeyup="checkemailId()" data-parsley-required-message="Required">
                                <i class="feather icon-mail inside_input_icon"></i>
                                <span id="present_or_not">

                                </span>


                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12 margin_bottom_10">
                        <div class="row">
                            <div class="col-md-8 col-sm-6 col-xs-12 margin_bottom_10">
                                <div>
                                    <label for="name" class="label_patch">Password</label><a href="#"
                                        style="font-size: 11px;" data-toggle="tooltip" data-placement="top"
                                        title="Must Contain 10 Charcter Atlest 1 Uper Case ,Lower Case, Number, and Special Charter @,#,_,-"><i
                                            class="feather icon-info inside_input_icon"
                                            style="font-size: 15px;"></i></a>
                                    <div class="inputWithIcon">
                                        <input type="password" id="user_password"
                                            class="input_text margin_top_0 form-control" placeholder="Password"
                                            autocomplete="new-password" required="" data-parsley-trigger="blur"
                                            data-parsley-required-message="Required"
                                            data-parsley-pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z])(?=.*[@#_-]).{6,}"
                                            data-parsley-pattern-message="Invalid Parten">
                                        <i class="feather icon-lock inside_input_icon"></i>
                                        <span toggle="#user_password"
                                            class="feather icon-eye field-icon toggle-password"></span>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12 margin_bottom_10"
                                style="padding: 0;margin-top: 3px;">
                                <div>
                                    <label for="name" class="label_patch"></label>
                                    <div class="inputWithIcon">
                                        <button class="aut_g" onclick="Autogenratepass(event)">Auto-Generate</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12 margin_bottom_10">
                        <div>
                            <label for="name" class="label_patch">Contact Info</label>
                            <div class="inputWithIcon">
                                <input type="number" id="contatct_info" class="input_text margin_top_0 form-control"
                                    placeholder="Contact Info" required="" data-parsley-trigger="blur"
                                    data-parsley-required-message="Required">
                                <i class="feather icon-hash inside_input_icon"></i>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12 margin_bottom_10">
                        <div>
                            <label for="name" class="label_patch">User Limit</label>
                            <div class="inputWithIcon">
                                <input type="number" id="user_lmit" required="" data-parsley-trigger="blur"
                                    data-parsley-required-message="Required"
                                    class="input_text margin_top_0 form-control" placeholder="User Limit">
                                <i class="feather icon-user inside_input_icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12 margin_bottom_10">
                        <div>
                            <label for="name" class="label_patch">Start Date</label>
                            <div class="inputWithIcon">
                                <input type="date" iname="startdate" id="startdate" required=""
                                    data-parsley-trigger="blur" data-parsley-required-message="Required"
                                    class="input_text margin_top_0 form-control" placeholder="Your name"
                                    value="{{date('Y-m-d')}}">
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
                                        onchange="checktype(this)" required="" data-parsley-trigger="blur"
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
                                <input type="number" id="no_of_days" disabled onkeyup="getDate(this)" required=""
                                    data-parsley-trigger="blur" data-parsley-required-message="Required"
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
                                    data-parsley-trigger="blur" data-parsley-required-message="Required"
                                    class="input_text margin_top_0 form-control" placeholder="End Date" disabled>
                                <i class="feather icon-calendar inside_input_icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12 margin_bottom_10">
                        <div>
                            <label for="name" class="label_patch">Website</label>
                            <div class="inputWithIcon">
                                <input type="text" id="website" class="input_text margin_top_0 form-control"
                                    placeholder="Website">
                                <i class="feather icon-globe inside_input_icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12 margin_bottom_10">
                        <div>
                            <label for="name" class="label_patch">Time Zone</label>
                            <div class="">
                                <select class="form-control drop_down_select" id="time_zone" required=""
                                    data-parsley-trigger="blur" data-parsley-required-message="Required">
                                    <option value="">Select Time Zone</option>
                                    @foreach ($ALLTIMEZONE as $key => $value)
                                    <optgroup label="{{$key}}">
                                        @foreach ($value as $item)
                                        <option value="{{$item[0]}}">{{$item[1]}}</option>
                                        @endforeach
                                    </optgroup>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12 margin_bottom_10">
                        <div>
                            <label for="name" class="label_patch">Location</label>
                            <div class="">
                                <select class="form-control drop_down_select" id="locaton" required=""
                                    data-parsley-trigger="blur" data-parsley-required-message="Required">
                                    <option value="">Select Location</option>
                                    @foreach ($LOCATION as $contties)
                                        <option value="{{$contties->id}}">{{$contties->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="textbox" class="">
                    <p class="alignright">
                        <button class="cancel_btnn btnn">Cancel</button>
                        <button class="primary_btnn btnn" onclick="addClient(event)">Submit</button>
                    </p>
                </div>
            </div>
        </form>
        <div id="import_patch" class="hide">
            <div class="col-md-12 col-sm-12 col-xs-12 padding_10">
                <div>
                    <div class="file-drop-area file_up_back">
                        <span class="fake-btn">Choose files</span>
                        <span class="file-msg">or drag and drop files here</span>
                        <input class="file-input" type="file">
                    </div>
                    <br>
                    <div id="textbox" class="">
                        <p class="alignright">
                            <button class="cancel_btnn btnn">Cancel</button>
                            <button class="primary_btnn btnn">Submit</button>
                        </p>
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
    var vailidemail = false ;
    var vailidusername = false ;
    var base_url = {!!json_encode(url('/')) !!};
    $(document).ready(function() {
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


    $(".toggle-password").click(function() {

        $(this).toggleClass("icon-eye icon-eye-off");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });


    ////////////      Single File Upload       ///////////////

    var $fileInput = $('.file-input');
    var $droparea = $('.file-drop-area');

    // highlight drag area
    $fileInput.on('dragenter focus click', function() {
        $droparea.addClass('is-active');
    });

    // back to normal state
    $fileInput.on('dragleave blur drop', function() {
        $droparea.removeClass('is-active');
    });

    // change inner text
    $fileInput.on('change', function() {
        var filesCount = $(this)[0].files.length;
        var $textContainer = $(this).prev();

        if (filesCount === 1) {
            // if single file is selected, show file name
            var fileName = $(this).val().split('\\').pop();
            $textContainer.text(fileName);
        } else {
            // otherwise show number of files
            $textContainer.text(filesCount + ' files selected');
        }
    });


    ///////////     image upload js with preview  //////////////////////

    function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            // console.log(e.target.result)
            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#imageUpload").change(function() {
    readURL(this);
});

function addClient(event) {
    var bg = $('#imagePreview').css('background-image');
        bg = bg.replace('url(','').replace(')','').replace(/\"/gi, "");
        var isValid = true;
        $('#client_form').each( function() {
            if ($(this).parsley().validate() !== true) isValid = false;
        });
        if (isValid) {
            event.preventDefault();
            if(vailidemail) {
                var company_name = $("#company_name").val();
                var admin_name = $("#admin_name").val();
                var admin_emailid = $("#admin_emailid").val();
                var user_password = $("#user_password").val();
                var empcode_format = $("#empcode_format").val();
                var client_prefix = $("#client_prefix").val();
                var contatct_info = $("#contatct_info").val();
                var user_lmit = $("#user_lmit").val();
                var startdate = $("#startdate").val();
                var type = $("#type_auth").val();
                var no_of_days = $("#no_of_days").val();
                var expiry_date = $("#liciencedate").val();
                var website = $("#website").val();
                var time_zone = $("#time_zone").val();
                var locaton = $("#locaton").val();
                // var logo = $('#preview').attr('src');
                var logo = bg;
                // return;
                $.ajax({
                    url: base_url  +  '/SuperAdmin/save-client-creation',
                    type: 'POST',
                    data: {
                        company_name:company_name,
                        admin_name:admin_name,
                        admin_emailid:admin_emailid,
                        user_password:user_password,
                        empcode_format:empcode_format,
                        client_prefix:client_prefix,
                        contatct_info:contatct_info,
                        user_lmit:user_lmit,
                        type: type,
                        no_of_days:no_of_days,
                        startdate: startdate,
                        expiry_date:expiry_date,
                        logo: logo,
                        website: website,
                        time_zone: time_zone,
                        locaton: locaton,
                    },
                    success: function(data) {
                        var response = data.trim();
                        if (response == 'DBPRESENT') {
                            alert('Prefix Already Used');
                            $("#client_prefix").val('');
                        } else if (response == 'EMAILPRESENT') {
                            alert('Email Id Already Used');
                            $("#admin_emailid").val('');
                        } else if (response == 'ErrorInDB') {
                            alert('Something Went Wrong In Creation Of Database');
                        } else if (response == 'DONE') {
                            alert('Client Created Succesfully');
                            window.history.back();
                        }else  {
                            alert('Something Went Wrong');
                        }
                    },
                });
            } else {
                alert('Email Is Not Valid');
                $("#admin_emailid").removeClass( "is-valid" );
                        $("#admin_emailid").addClass( "is-invalid text-danger" );
                        $('<span class="error_input_patch"> <i class="feather icon-x error_inputcolor"><label for="name" class="error_label">Email In Use</label></i> </span>').appendTo("#present_or_not");
                $("#admin_emailid").val('');
            }

        }
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

    function checkemailId() {

        if ($('#admin_emailid').parsley().isValid()) {
            $("#admin_emailid").removeClass( "is-valid" );

            vailidemail = false ;
            $.ajax({
                url: base_url  +  '/getvaild-email',
                type: 'POST',
                data: {
                    emailId:$('#admin_emailid').val(),
                },
                success: function(data) {
                    var response = data.trim();
                    console.log(response);
                    if (response == 'TRUE') {
                        vailidemail = true ;
                        $("#present_or_not").text('');
                        $("#admin_emailid").removeClass( "is-invalid text-danger" );
                        $("#admin_emailid").addClass( "is-valid" );
                    } else if (response == 'FALSE') {
                        vailidemail = false ;
                        $("#admin_emailid").removeClass( "is-valid" );
                        $("#admin_emailid").addClass( "is-invalid text-danger" );
                        $('<span class="error_input_patch"> <i class="feather icon-x error_inputcolor"><label for="name" class="error_label">Email In Use</label></i> </span>').appendTo("#present_or_not");
                    } else {
                        vailidemail = false ;
                        $("#admin_emailid").removeClass( "is-valid" );
                        $("#admin_emailid").addClass( "is-invalid text-danger" );
                        $('<span class="error_input_patch"> <i class="feather icon-x error_inputcolor"><label for="name" class="error_label">Email In Use</label></i> </span>').appendTo("#present_or_not");
                    }
                    // console.log(vailidemail);
                },
            });
        } else {
            vailidemail = false ;
        }
    }
</script>

<script>
    function Autogenratepass(e) {
        e.preventDefault()
        var pass = password_generator(10);
        $("#user_password").val(pass);
        // alert();
    }
    function password_generator( len ) {
    var length = (len)?(len):(6);
    var string = "abcdefghijklmnopqrstuvwxyz"; //to upper
    var numeric = '0123456789';
    var punctuation = '@#_-';
    var password = "";
    var character = "";
    var crunch = true;
    while( password.length<length ) {
        entity1 = Math.ceil(string.length * Math.random()*Math.random());
        entity2 = Math.ceil(numeric.length * Math.random()*Math.random());
        entity3 = Math.ceil(punctuation.length * Math.random()*Math.random());
        hold = string.charAt( entity1 );
        hold = (password.length%2==0)?(hold.toUpperCase()):(hold);
        character += hold;
        character += numeric.charAt( entity2 );
        character += punctuation.charAt( entity3 );
        password = character;
    }
    password=password.split('').sort(function(){return 0.5-Math.random()}).join('');
    return password.substr(0,len);
}
</script>
@endsection
