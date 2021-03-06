@extends('Layout.app')
@section('content')

<style></style>
<div>
    <div class="h1_weight_700 shadow_patch">
        <div id="textbox" class="">
            <p class="alignleft bold_heavy bold_font_heading" id="add_client">Edit Superadmins</p>
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
                            <label for="name" class="label_patch">Logo</label>
                            <div class="container">
                                <div class="avatar-upload">
                                    <div class="avatar-edit">
                                        <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />
                                        <label for="imageUpload"></label>
                                    </div>
                                    <div class="avatar-preview">
                                        @php
                                        if ($SUPERADMINDETAILS->LOGO ==NULL || $SUPERADMINDETAILS->LOGO) {
                                            $BACKROUNDURL = $images;
                                        } else {
                                            $BACKROUNDURL = $SUPERADMINDETAILS->LOGO;
                                        }
                                        @endphp
                                        <div id="imagePreview" style="background-image: url({{$BACKROUNDURL}});">
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
                                    <label for="name" class="label_patch">Name</label>
                                    <div class="inputWithIcon">
                                        <input type="text" required="" value="{{$SUPERADMINDETAILS->Name}}"
                                            id="admin_name" data-parsley-trigger="blur"
                                            data-parsley-required-message="Required"
                                            class="input_text margin_top_0 form-control" placeholder="Name">
                                        <i class="feather icon-user inside_input_icon"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 margin_bottom_10">
                                <div style="margin-top: 30px;">
                                    <label for="name" class="label_patch">Email-ID</label>
                                    <div class="inputWithIcon">
                                        <input type="email" id="admin_emailid"
                                            class="input_text margin_top_0 form-control"
                                            value="{{$SUPERADMINDETAILS->SUPEMAILID}}" placeholder="Email-ID"
                                            autocomplete="nope" required="" data-parsley-trigger="blur"
                                            onkeyup="checkemailId()" data-parsley-required-message="Required">
                                        <i class="feather icon-mail inside_input_icon"></i>
                                        <span id="present_or_not">

                                        </span>


                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 margin_bottom_10">
                                <div class="row">
                                    <div class="col-md-8 col-sm-6 col-xs-12 margin_bottom_10">
                                        <div>
                                            <label for="name" class="label_patch">Password</label><a href="#"
                                                style="font-size: 11px;" data-toggle="tooltip" data-placement="top"
                                                title="Must Contain 6 Charcter Atlest 1 Uper Case ,Lower Case, Number, and Special Charter @,#,_,-"><i
                                                    class="feather icon-info inside_input_icon"
                                                    style="font-size: 15px;"></i></a>
                                            <div class="inputWithIcon">
                                                <input type="password" id="user_password"
                                                    class="input_text margin_top_0 form-control" placeholder="Password"
                                                    autocomplete="new-password" required="" data-parsley-trigger="blur"
                                                    value="{{$SUPERADMINDETAILS->DECRYPTPASS}}"
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
                                                <button class="aut_g"
                                                    onclick="Autogenratepass(event)">Auto-Generate</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 margin_bottom_10">
                                <div>
                                    <label for="name" class="label_patch">Time Zone</label>
                                    <div class="">
                                        <select class="form-control drop_down_select" id="time_zone" required=""
                                            data-parsley-trigger="blur" data-parsley-required-message="Required">
                                            <option value="">Select Time Zone</option>
                                            @foreach ($ALLTIMEZONE as $key => $value)
                                            <optgroup label="{{$key}}">
                                                @foreach ($value as $item)
                                                @php
                                                $selected = '';
                                                if ($SUPERADMINDETAILS->TIMEZONE == $item[0]) {
                                                // print_r($value);
                                                $selected = 'selected';
                                                }
                                                @endphp
                                                <option value="{{$item[0]}}" {{$selected}}>{{$item[1]}}</option>
                                                @endforeach
                                            </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="name" class="label_patch">UID</label><a href="#" style="font-size: 11px;"
                            data-toggle="tooltip" data-placement="top" title="Must Contain 14 Charcter Alfa Numreic "><i
                                class="feather icon-info inside_input_icon" style="font-size: 15px;"></i></a>
                        <div class="inputWithIcon">
                            <input type="text" id="uid" required="" data-parsley-trigger="blur"
                                data-parsley-required-message="Required"
                                value="{{$SUPERADMINDETAILS->DECRYPTPASS_UNIQUE_ID}}"
                                class="input_text margin_top_0 form-control" placeholder="UID"
                                data-parsley-pattern="^[A-Za-z0-9-]{14}$" data-parsley-pattern-message="Invalid Parten">
                            <i class="feather icon-user inside_input_icon"></i>
                        </div>
                    </div>
                </div>
                <div id="textbox" class="">
                    <p class="alignright">
                        <button class="cancel_btnn btnn">Cancel</button>
                        <button class="primary_btnn btnn" onclick="editsuperadmin(event)">Submit</button>
                    </p>
                </div>
            </div>
        </form>
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
        checkemailId();
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

function editsuperadmin(event) {
    var bg = $('#imagePreview').css('background-image');
    $("#admin_emailid").removeClass( "is-valid" );
        bg = bg.replace('url(','').replace(')','').replace(/\"/gi, "");
        var isValid = true;
        $('#client_form').each( function() {
            if ($(this).parsley().validate() !== true) isValid = false;
        });
        if (isValid) {
            event.preventDefault();
            if(vailidemail) {
                var admin_name = $("#admin_name").val();
                var admin_emailid = $("#admin_emailid").val();
                var user_password = $("#user_password").val();
                var time_zone = $("#time_zone").val();
                var uid = $("#uid").val();
                var id = "{{$id}}";
                // alert(id);
                // return;
                // var logo = $('#preview').attr('src');
                var logo = bg;
                // return;
                $.ajax({
                    url: base_url  +  '/SuperAdmin/update-superadmins-creation',
                    type: 'POST',
                    data: {
                        admin_name:admin_name,
                        admin_emailid:admin_emailid,
                        user_password:user_password,
                        time_zone:time_zone,
                        uid:uid,
                        logo: logo,
                        id:id
                    },
                    success: function(data) {
                        var response = data.trim();
                        if (response == 'EMAILPRESENT') {
                            alert('Email Id Already Used');
                            $("#admin_emailid").val('');
                        } else if (response == 'ErrorInDB') {
                            alert('Something Went Wrong In Creation Of Database');
                        } else if (response == 'DONE') {
                            alert('Superadmin Updated Succesfully');
                            window.history.back();
                        } else if (response == 'Invaild') {
                            alert('Invaild Input');
                        }  else if (response == 'Require') {
                            alert('All Filleds are Mandatory');
                        } else if (response == 'Invalidemail') {
                            alert('Invalid Email Parten');
                            $("#admin_emailid").val('');
                        } else if (response == 'Invalidpass') {
                            alert('Invalid Password');
                            $("#user_password").val('');
                        } else if (response == 'Invaliduid') {
                            alert('Invalid UID');
                            $("#uid").val('');
                        } else  {
                            alert('Something Went Wrong');
                        }
                    },
                });
            } else {
                alert('Email Is Not Valid');
                        $("#admin_emailid").addClass( "is-invalid text-danger" );
                        $('<span class="error_input_patch"> <i class="feather icon-x error_inputcolor"><label for="name" class="error_label">Email In Use</label></i> </span>').appendTo("#present_or_not");
                $("#admin_emailid").val('');
            }

        }
    }
    function checkemailId() {
        var id = "{{$id}}";
        if ($('#admin_emailid').parsley().isValid()) {
            $("#admin_emailid").removeClass( "is-valid" );

            vailidemail = false ;
            $.ajax({
                url: base_url  +  '/getvaild-email-foredit',
                type: 'POST',
                data: {
                    emailId:$('#admin_emailid').val(),
                    encryptid: id
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
