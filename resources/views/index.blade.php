<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="stylesheet" href="{{asset('/public/assets/css/tailwind.min.css')}}">
    <title>EMS-Employee Mangement System</title>
    @include('Links.links')
    <style>

    </style>

</head>

<body>
    <section class="flex flex-col md:flex-row h-screen items-center">

        <div class=" hidden lg:block w-full md:w-1/2 xl:w-2/3 h-screen">
            <img src="{{asset('/public/assets/images/Backgrounds/pexels-fauxels-3184160.jpg')}}" alt=""
                class="w-full h-full object-cover">
        </div>

        <div class="bg-white w-full md:max-w-md lg:max-w-full md:mx-auto md:mx-0 md:w-1/2 xl:w-1/3 h-screen px-6 lg:px-16 xl:px-12
                  flex items-center justify-center">

            <div class="w-full h-100" style="padding-top: 80px;">

                <!-- <h1 class="text-xl font-bold">Abstract UI</h1> -->

                <h1 class="text-xl md:text-2xl font-bold leading-tight mt-12">Log in to your account</h1>
                @if($errors->any())
                <div class="col-sm-12">
                    <div class="alert  alert-danger alert-dismissible fade show" role="alert">
                        {{$errors->first()}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                @endif
                @if(session()->has('success_message'))
                <div class="alert alert-success">
                    {{ session()->get('success_message') }}
                </div>
                @endif

                <form class="mt-6" action="#" id="login_form" autocomplete="off">
                    <div>
                        <label class="block text-gray-700">Email Address</label>
                        <input type="email" id="username" name="username" placeholder="Enter Email Address"
                            class="w-full px-4 py-3 rounded-lg bg-gray-200 mt-2 border focus:border-blue-500 focus:bg-white focus:outline-none form-control"
                            autofocus autocomplete="off" required="" data-parsley-type="email"
                            data-parsley-trigger="blur" data-parsley-required-message="Required"
                            data-parsley-type-message="Invalid Email">
                    </div>

                    <div class="mt-4">
                        <label class="block text-gray-700">Password</label>
                        <input type="password" id="user_password" name="user_password" placeholder="Enter Password"
                            minlength="6" class="w-full px-4 py-3 rounded-lg bg-gray-200 mt-2 border focus:border-blue-500
                          focus:bg-white focus:outline-none form-control" required="" data-parsley-trigger="blur"
                            data-parsley-required-message="Required"
                            data-parsley-minlength-message="Minimum 6 digt Require" autocomplete="new-password">
                    </div>

                    <div class="text-right mt-2">
                        <a href="#"
                            class="text-sm font-semibold text-gray-700 hover:text-blue-700 focus:text-blue-700">Forgot
                            Password?</a>
                    </div>

                    <button type="button" onclick="authentication(event)" class="w-full block bg-blue-500 hover:bg-blue-400 focus:bg-blue-400 text-white font-semibold rounded-lg
                        px-4 py-3 mt-6">Log In</button>
                </form>
            </div>
        </div>

    </section>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">UID</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                </div>
                <div class="modal-body">
                    <div id="modaldive">
                        <label for="name" class="label_patch">UID</label><a href="#" style="font-size: 11px;"
                            data-toggle="tooltip" data-placement="top" title="Must Contain 14 Charcter Alfa Numreic "><i
                                class="feather icon-info inside_input_icon" style="font-size: 15px;"></i></a>
                        <div class="inputWithIcon">
                            <input type="text" id="uid" required="" data-parsley-trigger="blur"
                                data-parsley-required-message="Required" class="input_text margin_top_0 form-control"
                                placeholder="UID" data-parsley-pattern="^[A-Za-z0-9-]{14}$"
                                data-parsley-pattern-message="Invalid Parten">
                            <i class="feather icon-user inside_input_icon"></i>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="w-full block bg-blue-500 hover:bg-blue-400 focus:bg-blue-400 text-white font-semibold rounded-lg
                    px-4 py-3 mt-6" onclick="oncontinue()">Continue</button>
                </div>
            </div>
        </div>
    </div>

    {{-- <form action="#" id="login_form">
        <input type="text" id="username" name="username" required="" data-parsley-trigger="blur"
            data-parsley-errors-container=".usernameerror">
        <span class="usernameerror"></span>
        <input type="text" id="user_password" name="user_password" required="" data-parsley-trigger="blur"
            data-parsley-errors-container=".user_password">
        <span class="user_password"></span>
        <button id="btn_id" onclick="authentication(event)">Submit</button>
    </form> --}}
</body>
@include('Links.scripts')
<script>
    var base_url = {!!json_encode(url('/')) !!};
    $(document).ready(function() {

        $('#login_form').parsley({
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
    function oncontinue() {
        var uid = $("#uid").val();
        var emailid = $("#username").val();
        // alert(emailid)
        // return
        $.ajax({
            url: base_url  +  '/checkuid',
            type: 'POST',
            data: {
                uid:uid,
                emailid:emailid
            },
            success: function(data) {
                var response = data.trim();
                if (response == 'NotFound') {
                    alert('Email Id  Not Found');
                } else if (response == 'Required') {
                    alert('UID is  Mandatary');
                } else if (response == 'Error') {
                    alert('Something Went Wrong');
                } else if (response == 'Invalid') {
                    alert('Invaild UID');
                } else {
                    window.location.href ="{{route('/dashboard')}}";
                }
            },
        });
    }
    function authentication(event) {

        // $('#loading-image').show();
        // Validate all input fields.
        var isValid = true;
        $('#login_form').each( function() {
            if ($(this).parsley().validate() !== true) isValid = false;
        });
        if (isValid) {
            event.preventDefault();
            var username = $("#username").val();
            var user_password = $("#user_password").val();
            // alert(username);
            $.ajax({
                url: base_url  +  '/checklogin',
                type: 'POST',
                data: {
                    username:username,
                    userPassword:user_password
                },
                success: function(data) {
                    var response = data.trim();
                    // console.log(response)
                    // return;
                    if (response == 'NotFound') {
                        alert('Email Id / Username Not Found');
                    } else if (response == 'NotMatch') {
                        alert('Password DoesNot Match');
                    } else if (response == 'Error') {
                        alert('Your Session Expier Please Login Again');
                    } else if (response == 'NotStarted') {
                        alert('Yor Time Is Not Started');
                    } else if (response == 'Expire') {
                        alert('Yor Liecence Is Expired');
                    }else if (response == 'Check') {
                        // alert('Open Popup Box');
                        $('#myModal').modal('show');
                    } else if (response == 'Error') {
                        alert('Something Went Wrong');
                    } else if (response == 'Stop') {
                        alert('Your Service is Stoped');
                    } else {
                        console.log(response);
                        window.location.href ="{{route('/dashboard')}}";
                        // var ROLEID = response;
                        // if (ROLEID == 1) {
                        //     window.location.href ="SuperAdmin/dashboard";
                        // } else if (ROLEID == 2) {
                        //     window.location.href ="Admin/dashboard";
                        // }  else if (ROLEID == 3) {
                        //     window.location.href ="User/dashboard";
                        // } else if (ROLEID == 4) {
                        //     window.location.href ="User/dashboard";
                        // } else {
                        //     alert('Wait');
                        // }
                    }

                },
            });
        }

    }
</script>

</html>
