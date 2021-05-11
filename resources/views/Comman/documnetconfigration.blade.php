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
        <form action="#" id="module_form">
            <div id="form_patch">
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12 padding_10">
                        <div>
                            <label for="name" class="input_label_light">Document Name</label>
                            <div class="inputWithIcon">
                                <input type="text" class="input_text margin_top_0" id="doc_name"
                                    placeholder="Document name" required="" data-parsley-trigger="blur"
                                    data-parsley-required-message="Required" data-parsley-errors-container="#modname">
                                <i class="feather icon-user inside_input_icon"></i>
                                <span class="form-error error_label" id="modname">
                                    <i class="feather icon-x error_inputcolor"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 padding_10">
                        <div>
                            <label for="name" class="input_label_light">Document Description</label>
                            <div class="inputWithIcon">
                                <textarea id="w3review" name="w3review" rows="4" cols="50" name="description"
                                    placeholder="Document Description" id="description" class="textarea_p"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 padding_10">
                        <div>
                            <label for="name" class="dropdown_label_light">Parrent Document</label>
                            <div>
                                <select class="js-example-basic-single" name="isparrent_doc" id="isparrent_doc"
                                    required="" onchange="isparrentdocument(this)" data-parsley-trigger="blur"
                                    data-parsley-required-message="Required" data-parsley-errors-container="#catid">
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>
                                </select> <span class="form-error error_label" id="catid">
                                    <i class="feather icon-x error_inputcolor"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 padding_10">
                        <div id="allrecords" style="display: none">
                            <div id="all_child_doc">
                                <label for="name" class="input_label_light">Child Document</label>
                                <div class="row" id="0">
                                    <div class="col-md-7 col-sm-7 col-xs-12 padding_10">
                                        <div>
                                            <div class="inputWithIcon">
                                                <input type="text" class="input_text margin_top_0" id="childdocname_0"
                                                    placeholder="Document name" name="child_doc"
                                                    data-parsley-trigger="blur" data-parsley-required-message="Required"
                                                    data-parsley-errors-container="#childfileerror_0"> <i
                                                    class="feather icon-user inside_input_icon"></i>
                                                <span class="form-error error_label" id="childfileerror_0">
                                                    <i class="feather icon-x error_inputcolor"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12 padding_10">
                                        <div>
                                            <label for="name" class="input_label_light">Document Description</label>
                                            <div class="inputWithIcon">
                                                <textarea id="childdiscription_0" name="w3review" rows="4" cols="50"
                                                    placeholder="Document Description" name="description"
                                                    class="textarea_p"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-sm-1 col-xs-12 padding_10">
                                        <div>
                                            <div id="textbox" class="">
                                                <p class="alignright">
                                                    <button class="cancel_btnn btnn"
                                                        onclick="removefeild(event,'0')">Cancel</button>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div id="textbox" class="">
                                    <p class="alignright">
                                        <button class="primary_btnn btnn" onclick="Addmorefiles(event)">Add</button>
                                    </p>
                                </div>
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
        <div>
            <div class="row ">
                <div class="col-md-12 col-sm-12 col-xs-12 padding_10">
                    <table class="table yajra-datatable" id="example1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Document Name</th>
                                <th>Parrent Document</th>
                                <th>Child Document</th>
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
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Document Configration</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" id="dynamicdata">
            </div>
        </div>
    </div>
</div>
@endsection
@section('addscriptscontent')
<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var autoid = 1;
var path = {!! json_encode(url('/')) !!};
var globalarry = [0];
$(document).ready(function () {
	$('#module_form').parsley();
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
			url: path + '/all-documents',
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
				data: 'DOCUMENT_SET_NAME',
				name: 'DOCUMENT_SET_NAME'
			}, {
				data: 'ISPARENT_DOCUMENT',
				name: 'ISPARENT_DOCUMENT'
			}, {
				data: 'childdocuments',
				name: 'childdocuments'
			}, {
				data: 'action',
				name: 'action'
			}
		],
	});
}
function saveconfigration(event) {
	event.preventDefault();
	var isValid = true;
	$('#module_form').each(function () {
		if ($(this).parsley().validate() !== true) isValid = false;
	});
	if (isValid) {
        var parentdocname = $("#doc_name").val();
        var isparrentdoc = $("#isparrent_doc").val();
        var description = $("#w3review").val();
        var childdfilename = [];
        if (isparrentdoc == 'Yes') {
            globalarry.forEach(element => {
                var obj = {};
                var childdocname = $("#childdocname_" + element).val();
                var childdescription = $("#childdiscription_" + element).val();
                obj['documentname'] = childdocname;
                obj['description'] = childdescription;
                childdfilename.push(obj);
                obj = {};
            });
        }
        console.log('Alll Data ', childdfilename)
        // return
		$.ajax({
			url: path + '/save-docconfigration',
			type: 'POST',
			data: {
				parentdocname: parentdocname,
                description: description,
				isparrentdoc: isparrentdoc,
				childdfilename: childdfilename
			},
			success: function (data) {
                console.log(data);
                // return
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
function deleteModuleid(id, event) {
	var r = confirm("Are you Sure You Want To Delete Module");
	if (r == true) {
		// alert(path);
		$.ajax({
			url: path + '/SuperAdmin/delete-modules',
			type: 'POST',
			data: {
				moduleId: id
			},
			success: function (data) {
				var response = data.trim();
				if (response == 'DONE') {
					alert('Module Deleted Succesfully');
					showDatatable();
				} else {
					console.log(response);
					alert('Something Went Wrong');
				}
			},
		})
		// alert("You pressed OK!");
	} else {}
}
function Addmorefiles(e) {
	e.preventDefault();
    globalarry.push(autoid);
	var html = '<div class="row dynamic" id="' + autoid + '"><div class="col-md-7 col-sm-17 col-xs-12 padding_10"><div><div class="inputWithIcon"> <input type="text" class="input_text margin_top_0" id="childdocname_' + autoid + '" placeholder="Document name" name="child_doc" required="" data-parsley-trigger="blur" data-parsley-required-message="Required" data-parsley-errors-container="#childfileerror_' + autoid + '"> <i class="feather icon-user inside_input_icon"></i> <span class="form-error error_label" id="childfileerror_' + autoid + '"> <i class="feather icon-x error_inputcolor"></i></span></div></div></div><div class="col-md-4 col-sm-4 col-xs-12 padding_10"><div> <label for="name" class="input_label_light">Document Description</label><div class="inputWithIcon"><textarea id="childdiscription_' + autoid + '" name="w3review" rows="4" cols="50" placeholder="Document Description" name="description" class="textarea_p"></textarea></div></div></div><div class="col-md-1 col-sm-1 col-xs-12 padding_10"><div><div id="textbox" class=""><p class="alignright"> <button class="cancel_btnn btnn" onclick="removefeild(event, ' + autoid + ')">Cancel</button></p></div></div></div></div>';
	$("#all_child_doc").append(html);
	autoid++;
}
function removefeild(e, id) {
	e.preventDefault();
	// alert(id);
	$("#" + id).remove();
    var removeItem = id;
    globalarry = jQuery.grep(globalarry, function(value) {
        return value != removeItem;
    });
}
function isparrentdocument(thisparm) {
    var changevalue = $(thisparm).val();
    if (changevalue == 'Yes') {
        $("#allrecords").show();
        $("#childdocname_0").attr('required', true);
        $("#childdocname_0").val('');
        $("#childdiscription_0").val('');
        globalarry = [0];
    } else {
        $("#allrecords").hide();
        $("#childdocname_0").attr('required', false);
        globalarry = [];
        $(".dynamic").remove();
    }

}
function change_font_event(params,id) {
        // alert(id);
        var checkboxid = $(params).attr("id");
        var label = checkboxid.concat("_text");
        $.ajax({
			url: path + '/update-documents',
			type: 'POST',
			data: {
				id: id,
                type: 'checkbox'
			},
			success: function (data) {
                // console.log(data);
                if (data == 'Updated') {
                    alert('Document Updated');
                    showDatatable();
                } else {
                    $('#myModal').modal('show');
                    $("#dynamicdata").empty();
                    $("#dynamicdata").append(data);
                }
                if ($(params).is(':checked')) {
                    $('#' + label).animate({
                        'color': '#292929'
                    });
                } else {
                    $('#' + label).animate({
                        'color': '#7d7d7d'
                    });
                }

			},
		});


    }
function Addmorefilesupdate(e) {
    // alert('Hiiiiii');
    e.preventDefault();
    globalarry.push(autoid);
	var html = '<div class="row dynamic" id="' + autoid + '"><div class="col-md-7 col-sm-17 col-xs-12 padding_10"><div><div class="inputWithIcon"> <input type="text" class="input_text margin_top_0" id="childdocname_' + autoid + '" placeholder="Document name" name="child_doc" required="" data-parsley-trigger="blur" data-parsley-required-message="Required" data-parsley-errors-container="#childfileerror_' + autoid + '"> <i class="feather icon-user inside_input_icon"></i> <span class="form-error error_label" id="childfileerror_' + autoid + '"> <i class="feather icon-x error_inputcolor"></i></span></div></div></div><div class="col-md-4 col-sm-4 col-xs-12 padding_10"><div> <label for="name" class="input_label_light">Document Description</label><div class="inputWithIcon"><textarea id="childdiscription_' + autoid + '" name="w3review" rows="4" cols="50" placeholder="Document Description" name="description" class="textarea_p"></textarea></div></div></div><div class="col-md-1 col-sm-1 col-xs-12 padding_10"><div><div id="textbox" class=""><p class="alignright"> <button class="cancel_btnn btnn" onclick="removefeild(event, ' + autoid + ')">Cancel</button></p></div></div></div></div>';
	$("#update_all_child_doc").append(html);
}
function isparrentdocumentupdate(params) {

    var updatechangevalue = $(params).val();
    // alert(updatechangevalue)
    if (updatechangevalue == 'Yes') {
        $("#update_allrcrods").show();
        $("#updatechilddocname_0").attr('required', true);
    } else {
        $("#update_allrcrods").hide();
        $("#updatechilddocname_0").attr('required', false);
    }
}
function updatedocuments(id, e) {
    $.ajax({
			url: path + '/update-documents',
			type: 'POST',
			data: {
				id: id,
                type: 'update'
			},
			success: function (data) {
                // console.log(data);
                $('#myModal').modal('show');
                $("#dynamicdata").empty();
                $("#dynamicdata").append(data);

			},
		});
}
function updateconfigration(e, id) {
    e.preventDefault();
    $('#update_form').parsley();
    var updateisValid = true;
	$('#update_form').each(function () {
		if ($(this).parsley().validate() !== true) updateisValid = false;
	});
	if (updateisValid) {
        var update_doc_name = $("#update_doc_name").val();
        var updateisparrentdoc = $("#updateisparrent_doc").val();
        var updatedescription = $("#updatew3review").val();
        var updatechilddfilename = [];
        if (updateisparrentdoc == 'Yes') {
            var div = document.getElementById("update_all_child_doc");
            $(div).find('div.row').each(function() {
                var elements = $(this);
                var divid = $(elements).attr('id')
                var obj22 = {};
                var updatechilddocname = $("#updatechilddocname_" + divid).val();
                var updatechilddescription = $("#updatechilddiscription_" + divid).val();
                obj22['documentname'] = updatechilddocname;
                obj22['description'] = updatechilddescription;
                updatechilddfilename.push(obj22);
                obj22 = {};
            });
        }
        $.ajax({
			url: path + '/update-docconfigration',
			type: 'POST',
			data: {
				parentdocname: update_doc_name,
                description: updatedescription,
				isparrentdoc: updateisparrentdoc,
				childdfilename: updatechilddfilename,
                updateid: id
			},
			success: function (data) {
                console.log(data);
                // return
				var response = data.trim();
				if (response == 'Done') {
					alert('Document Updated Succesfully');
					showDatatable();
                    $('#myModal').modal('hide');
				} else if (response == 'Already') {
					alert('Document Already Exits');
					$("#update_doc_name").val('');
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
