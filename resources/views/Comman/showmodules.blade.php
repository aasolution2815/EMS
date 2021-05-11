@extends('Layout.app')
@section('content')
<?php
$ROLEID = session('RoleId');
?>
<style>
    .error_label_select2 {
        position: relative;
        margin: 0px 5px;
        font-size: 11px;
        top: 55px;
    }
</style>
<div>
    <div class="h1_weight_700 shadow_patch">
        <div id="textbox" class="">
            <p class="alignleft bold_heavy bold_font_heading" id="add_client">Modules</p>
            <p class="alignright margin-top_10">
                <a href="javascript:history.back()"><span class="btn_with_icon" style="margin-right: 15px;"><i
                            class="feather icon-corner-up-left  small_icon_left"></i>
                        Back </span></a>


            </p>
        </div>
        <div style="clear: both;"></div>
        @if (session('RoleId') == '1' || session('RoleId') == '2')
        <form action="#" id="module_form">
            <div id="form_patch">
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12 padding_10">

                        <div>
                            <label for="name" class="input_label_light">Module Name</label>
                            <div class="inputWithIcon">
                                <input type="text" class="input_text margin_top_0" id="module_name"
                                    placeholder="Module name" required="" data-parsley-trigger="blur"
                                    data-parsley-required-message="Required" data-parsley-errors-container="#modname">
                                <i class="feather icon-user inside_input_icon"></i>
                                <span class="form-error error_label" id="modname">
                                    <i class="feather icon-x error_inputcolor"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12 padding_10">

                        <div>
                            <label for="name" class="input_label_light">URL</label>
                            <div class="inputWithIcon">
                                <input type="text" class="input_text margin_top_0" placeholder="Module Url"
                                    id="module_url" placeholder="Module URL" required="" data-parsley-trigger="blur"
                                    data-parsley-required-message="Required" data-parsley-errors-container="#urlclass">
                                <i class="feather icon-user inside_input_icon"></i>
                                <span class="form-error error_label" id="urlclass">
                                    <i class="feather icon-x error_inputcolor"></i></span>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12 padding_10">

                        <div>
                            <label for="name" class="dropdown_label_light">Select Category</label>
                            <div>
                                <select class="js-example-basic-single" name="category_id" id="category_id" required=""
                                    data-parsley-trigger="blur" data-parsley-required-message="Required"
                                    data-parsley-errors-container="#catid">
                                    <option value=""></option>
                                    @foreach ($CATDETAilS as $CAT)
                                    <option value="{{$CAT->CATEGORY_ID}}">{{$CAT->CATEGORYNAME}}</option>
                                    @endforeach
                                </select>
                                <span class="form-error error_label" id="catid">
                                    <i class="feather icon-x error_inputcolor"></i></span>
                                {{-- <div id="startTimeErrorContainer"></div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 padding_10">
                        <div>
                            <label for="name" class="input_label_light">Description</label>
                            <div class="inputWithIcon">
                                <textarea id="w3review" name="w3review" rows="4" cols="50" name="description"
                                    id="description" class="textarea_p"></textarea>
                                <!-- <i class="feather icon-user inside_input_icon"></i> -->
                            </div>
                        </div>
                    </div>
                </div>

                <div id="textbox" class="">
                    <p class="alignright">
                        <button class="cancel_btnn btnn">Cancel</button>
                        <button class="primary_btnn btnn" onclick="addModules(event)">Submit</button>
                    </p>
                </div>
            </div>
        </form>

        <div style="clear: both;"></div>
        @endif

        <div>
            <div class="row ">
                <div class="col-md-12 col-sm-12 col-xs-12 padding_10">
                    <table class="table yajra-datatable" id="example1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Module Name</th>
                                <th>Module Url</th>
                                <th>Module Category</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
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
    $(document).ready(function() {
        $(".js-example-basic-single").select2({
            placeholder: "Select Category",
            allowClear:true
        });
        // $('#module_form').parsley({

        //     errorClass: 'is-invalid text-danger',
        //     successClass: 'is-valid', // Comment this option if you don't want the field to become green when valid. Recommended in Google material design to prevent too many hints for user experience. Only report when a field is wrong.
        //     errorsWrapper: '<span class="form-error error_label "><i class="feather icon-x error_inputcolor"></i></span>',
        //     errorTemplate: '<span></span>',
        //     trigger: 'change'

        // });
        $('#module_form').parsley();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            error: function(x, status, error) {
                if (x.status == 403) {
                    alert("Sorry, your session has expired. Please login again to continue");
                    window.location.href = "/";
                } else {
                    alert("An error occurred: " + status + "nError: " + error);
                }
            }
        });
    });;

    // ------------ Multiple File upload BEGIN ------------
    $('.file__input--file').on('change', function(event) {
        var files = event.target.files;
        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            $("<div class='file__value'><div class='file__value--text'>" + file.name + "</div><div class='file__value--remove' data-id='" + file.name + "' ></div></div>").insertAfter('#file__input');
        }
    });

    //Click to remove item
    $('body').on('click', '.file__value', function() {
        $(this).remove();
    });
    // ------------ Multiple File upload END ------------
    showDatatable();





    function change_font_event(params) {
        var checkboxid = $(params).attr("id");
        var label = checkboxid.concat("_text");
        if ($(params).is(':checked')) {
            $('#' + label).animate({
                'color': '#292929'
            });
        } else {
            $('#' + label).animate({
                'color': '#7d7d7d'
            });
        }
    }



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

            ajax : {
                url : path + '/all-modules',
                type : 'post',
                data : {_token: CSRF_TOKEN},
                complete: function (data) {
                }
            },

            columns: [
                // {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'MODULENAME',
                    name: 'MODULENAME'
                },
                {
                    data: 'MODULELINK',
                    name: 'MODULELINK'
                },
                {
                    data: 'catid',
                    name: 'catid'
                },
                {
                    data: 'MODULEDESCRIPTION',
                    name: 'MODULEDESCRIPTION'
                },
                {
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
        var isValid = true;
        $('#module_form').each(function() {
            if ($(this).parsley().validate() !== true) isValid = false;
        });
        if (isValid) {
            var moduleid = $("#module_name").val();
            var module_url = $("#module_url").val();
            var module_cat = $("#category_id").val();
            var module_description = $("#w3review").val();
            $.ajax({
                url: path  +  '/SuperAdmin/save-modules',
                type: 'POST',
                data: {
                    moduleid:moduleid,
                    module_url:module_url,
                    module_cat:module_cat,
                    module_description:module_description,
                },
                success: function(data) {
                    var response = data.trim();
                    if (response == 'DONE') {
                        alert('Module Added Succesfully');
                        showDatatable();
                    }else if(response == 'Already'){
                        alert('Url Already Exits');
                        $("#module_url").val('');
                    } else  {
                        alert('Something Went Wrong');
                    }
                },
            });
        }
    }
    function deleteModuleid(id,event) {

var r = confirm("Are you Sure You Want To Delete Module");
if (r == true) {
    // alert(path);
    $.ajax({
        url: path  +  '/SuperAdmin/delete-modules',
        type: 'POST',
        data: {
            moduleId: id
        },
        success: function(data) {
            var response = data.trim();
            if (response == 'DONE') {
                alert('Module Deleted Succesfully');
                showDatatable();
            }else  {
                console.log(response);
                alert('Something Went Wrong');
            }
        },
    })
    // alert("You pressed OK!");
} else {
}
}
</script>
@endsection
