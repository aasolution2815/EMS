@extends('Layout.app')
@section('content')
<style>
</style>
<div>
    <div class="h1_weight_700 shadow_patch">
        <div id="textbox" class="">
            <p class="alignleft bold_heavy bold_font_heading" id="">Document Configration</p>
            <p class="alignright margin-top_10"> <a href="javascript:history.back()"><span class="btn_with_icon"
                        style="margin-right: 15px;"><i class="feather icon-corner-up-left  small_icon_left"></i>
                        Back </span></a>
            </p>
        </div>
        <div style="clear: both;"></div>
        <form action="#" id="email_form">
            <div id="form_patch">
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12 padding_10">
                        <div>
                            <label for="name" class="input_label_light">Email id</label>
                            <div class="inputWithIcon">
                                <input type="email" class="input_text margin_top_0" id="emai_id"
                                    placeholder="Email Id" required="" data-parsley-trigger="blur"
                                    data-parsley-required-message="Required">
                                <i class="feather icon-user inside_input_icon"></i>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 padding_10">
                        <div>
                            <label for="name" class="input_label_light">Incomming Server</label>
                            <div class="inputWithIcon">
                                <input type="text" class="input_text margin_top_0" id="email_incomming_server"
                                    placeholder="Incomming Server" required="" data-parsley-trigger="blur"
                                    data-parsley-required-message="Required">
                                <i class="feather icon-user inside_input_icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 padding_10">
                        <div>
                            <label for="name" class="input_label_light">Outgoing Server</label>
                            <div class="inputWithIcon">
                                <input type="text" class="input_text margin_top_0" id="email_out_server"
                                    placeholder="Outgoing Server" required="" data-parsley-trigger="blur"
                                    data-parsley-required-message="Required">
                                <i class="feather icon-user inside_input_icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12 padding_10">
                        <div>
                            <label for="name" class="input_label_light">Port</label>
                            <div class="inputWithIcon">
                                <input type="text" class="input_text margin_top_0" id="email_port"
                                    placeholder="Port" required="" data-parsley-trigger="blur"
                                    data-parsley-required-message="Required">
                                <i class="feather icon-user inside_input_icon"></i>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 padding_10">
                        <div>
                            <label for="name" class="input_label_light">Password</label>
                            <div class="inputWithIcon">
                                <input type="password" class="input_text margin_top_0" id="email_password"
                                    placeholder="Password" required="" data-parsley-trigger="blur"
                                    data-parsley-required-message="Required" autocomplete="new-password">
                                <i class="feather icon-user inside_input_icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="textbox" class="">
                    <p class="alignright">
                        <button class="cancel_btnn btnn">Cancel</button>
                        <button class="primary_btnn btnn" onclick="saveconfigration(event)">Submit</button>
                    </p>
                </div>
            </div>
        </form>
        <div style="clear: both;"></div>
    </div>
</div>
@endsection
@section('addscriptscontent')
<script>
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var path = {!! json_encode(url('/')) !!};
$(document).ready(function () {
	$('#email_form').parsley({
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
				window.location.href = "/";
			} else {
				alert("An error occurred: " + status + "nError: " + error);
			}
		}
	});
});
function saveconfigration(event) {
	event.preventDefault();
	var isValid = true;
	$('#email_form').each(function () {
		if ($(this).parsley().validate() !== true) isValid = false;
	});
	if (isValid) {
        var emai_id = $("#emai_id").val();
        var email_incomming_server = $("#email_incomming_server").val();
        var email_out_server = $("#email_out_server").val();
        var email_port = $("#email_port").val();
        var email_password = $("#email_password").val();
		$.ajax({
			url: path + '/save-emailconfigration',
			type: 'POST',
			data: {
				emai_id: emai_id,
                email_incomming_server: email_incomming_server,
				email_out_server: email_out_server,
				email_port: email_port,
                email_password: email_password
			},
			success: function (data) {
                console.log(data);
                return
				var response = data.trim();
				if (response == 'Done') {
					alert('Document Added Succesfully');
					showDatatable();
				} else if (response == 'Already') {
					alert('Document Already Exits');
					$("#doc_name").val('');
				} else if (response == 'Mandatory') {
                    alert('All Feild Are Mandatory')
                } else if (response == 'NoChild') {
                    alert('Please Put Atlese One Child')
                } else {
					alert('Something Went Wrong');
				}
			},
		});
	}
}
</script>
@endsection
