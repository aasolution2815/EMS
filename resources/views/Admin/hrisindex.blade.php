@extends('Layout.app')
@section('content')
<style>
</style>
<div>
	<div class="h1_weight_700 shadow_patch">
		<div id="textbox" class="">
			<p class="alignleft bold_heavy bold_font_heading" id="add_client">Forms</p>
			<p class="alignright margin-top_10"> <a href="javascript:history.back()"><span class="btn_with_icon" style="margin-right: 15px;"><i
                            class="feather icon-corner-up-left  small_icon_left"></i>
                        Back </span></a>
			</p>
		</div>
		<div style="clear: both;"></div>
		<form action="#" id="fieldform">
			<div id="form_patch">
				<div class="row">
					<div class="col-md-4 col-sm-6 col-xs-12 padding_10">
						<div>
							<label for="name" class="input_label_light">Form Name</label>
							<div class="inputWithIcon">
								<input type="text" class="input_text margin_top_0" id="form_name" placeholder="Form Name" required="" data-parsley-trigger="blur" data-parsley-required-message="Required"> <i class="feather icon-user inside_input_icon"></i>
							</div>
						</div>
					</div>
				</div>
				<div id="textbox" class="">
					<p class="alignright">
						<button class="primary_btnn btnn" onclick="addModules(event)">Submit</button>
					</p>
				</div>
			</div>
			<div id="Edit_form_patch" style="display: none">
				<div class="row">
					<input type="hidden" id="hidden_form_id" value="">
					<div class="col-md-4 col-sm-6 col-xs-12 padding_10">
						<div>
							<label for="name" class="input_label_light">Form Name</label>
							<div class="inputWithIcon">
								<input type="text" class="input_text margin_top_0" id="edit_form_name" placeholder="Form Name" required="" data-parsley-trigger="blur" data-parsley-required-message="Required"> <i class="feather icon-user inside_input_icon"></i>
							</div>
						</div>
					</div>
				</div>
				<div id="textbox" class="">
					<p class="alignright">{{--
						<button class="cancel_btnn btnn">Cancel</button>--}}
						<button class="primary_btnn btnn" onclick="updateData(event)">Submit</button>
					</p>
				</div>
			</div>
		</form>
		<div style="clear: both;"></div>
		<div>
			<div class="row ">
				<div class="col-md-12 col-sm-12 col-xs-12 padding_10">
					<table class="table yajra-datatable" id="example1">
						<thead>
							<tr>
								<th>No</th>
								<th>Frorm Name</th>
								<th>Created At</th>
								<th>View</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
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
$(document).ready(function () {
	$('#fieldform').parsley({
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
});;
showDatatable();
function showDatatable() {
	$('#example1').DataTable().clear().destroy();
	var table = $('.yajra-datatable').DataTable({
		language: {
			searchPlaceholder: '',
			search: '<i class="feather icon-search">',
			info: "Displaying _START_ to _END_ from _TOTAL_ ",
			paginate: {
				next: '<i class="feather icon-chevron-right mid_icon">',
				previous: '<i class="feather icon-chevron-left mid_icon">'
			}
		},
		processing: true,
		serverSide: true,
		// "order": [[ 10, "desc" ], [ 9, 'asc' ]], //or asc
		ajax: {
			url: path + '/hrisformlist',
			type: 'post',
			data: {
				_token: CSRF_TOKEN
			},
			complete: function (data) {}
		},
		columns: [
			// {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
			{
				data: 'DT_RowIndex',
				name: 'DT_RowIndex'
			}, {
				data: 'form_name',
				name: 'form_name'
			}, {
				data: 'DATE',
				name: 'DATE'
			}, {
				data: 'view_form',
				name: 'view_form'
			}, {
				data: 'action',
				name: 'action',
				orderable: true,
				searchable: true
			},
		],
	});
}
function addModules(event) {
	event.preventDefault();
	$('#edit_form_name').removeAttr('required');
	var isValid = true;
	$('#fieldform').each(function () {
		if ($(this).parsley().validate() !== true) isValid = false;
	});
	if (isValid) {
		var formname = $("#form_name").val();
		$.ajax({
			url: path + '/Admin/formsubmit',
			type: 'POST',
			data: {
				formname: formname,
			},
			success: function (data) {
				var response = data.trim();
				if (response == 'DONE') {
					alert('Form Added Succesfully');
					showDatatable();
				} else if (response == 'Already') {
					alert('Form Already Exits');
					$("#form_name").val('');
				} else if (response == 'Required') {
					alert('Form is Mandatory');
				} else {
					alert('Something Went Wrong');
				}
			},
		});
	}
}
function onedit(id, event, name) {
	$("#form_patch").hide();
	$("#Edit_form_patch").show();
	$("#edit_form_name").val(name);
	$("#hidden_form_id").val(id);
	// alert(name);
}
function updateData(event) {
	event.preventDefault();
	var isValid = true;
	// alert()
	$('#form_name').removeAttr('required');
	$('#fieldform').each(function () {
		if ($(this).parsley().validate() !== true) isValid = false;
	});
	if (isValid) {
		var formname = $("#edit_form_name").val();
		var hidden_form_id = $("#hidden_form_id").val();
		$.ajax({
			url: path + '/Admin/formupdate',
			type: 'POST',
			data: {
				formname: formname,
				heddienId: hidden_form_id,
			},
			success: function (data) {
				var response = data.trim();
				if (response == 'DONE') {
					alert('Form Updated Succesfully');
					$("#Edit_form_patch").hide();
					$("#form_patch").show();
					showDatatable();
				} else if (response == 'Already') {
					alert('Form Already Exits');
					// $("#Edit_form_patch").val('');
				} else if (response == 'Required') {
					alert('Form is Mandatory');
				} else {
					alert('Something Went Wrong');
				}
			},
		});
	}
}
</script>
@endsection
