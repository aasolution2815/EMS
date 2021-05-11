@extends('Layout.app')
@section('content')
<style>
    /* .lbl {
        position: relative;
        left: -5px;
    }

    .lbl_rdonly {
        position: relative;
        left: 2px;
    } */
</style>
<div>
    <h3 style="
    margin: 10px 10px;
	">{{  $formdata->FORM_NAME}}</h3>
</div>
<div class="main_card" id="maindata">
    <div class="row margin_l_r_0">
        <div class="col-md-3 padd_0 fb_height fb_ovrflow fb_border_right">
            <div class=" 1st">
                <div class="row">
                    <div class="col-md-6 padd_0">
                        <ul id="col2" class="menuuu pad_left">
                            <!--to display lables-->
                            <li id="" class="textboxControl fb_lit">
                                <a class="fb_atg" href="#"> <i class="fa fa-font" aria-hidden="true"></i>
                                    TextBox</a>
                            </li>
                            <li id="" class=" numberControl  fb_lit">
                                <a class="fb_atg" href="#"> <i class="fa fa-font" aria-hidden="true"></i>
                                    Number</a>
                            </li>
                            <li id="" class="textareaControl fb_lit">
                                <a id="" class="fb_atg" href="#"> <i class="fa fa-text-width" aria-hidden="true"></i>
                                    Text Area</a>
                            </li>
                            <li id="" class="emailControl  fb_lit">
                                <a id="" class="fb_atg" href="#"> <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                    Email ID</a>
                            </li>
                            <li id="" class="dateControl  fb_lit">
                                <a id="" class="fb_atg" href="#"> <i class="fa fa-calendar-o" aria-hidden="true"></i>
                                    Date</a>
                            </li>
                            <li id="" class="timeControl  fb_lit">
                                <a id="" class="fb_atg" href="#"> <i class="fa fa-clock-o" aria-hidden="true"></i>
                                    Time</a>
                            </li>

							{{-- <li id="" class="fileuploadControl fb_lit">
								<a id="" class="fb_atg" href="#"> <i class="fa fa-header" aria-hidden="true"></i>
									File Upload</a>
							</li> --}}
                        </ul>
                    </div>
                    <div class="col-md-6 padd_0">
                        <ul id="col2" class="menuuu scnd_pad">
                            <li id="" class="dropdownControl  fb_lit">
                                <a id="" class="fb_atg" href="#"> <i class="fa fa-caret-square-o-down"
                                        aria-hidden="true"></i>
                                    Dropdown</a>
                            </li>
                            <li id="" class="multipleSelectionControl  fb_lit">
                                <a id="" class="fb_atg" href="#"> <i class="fa fa-caret-square-o-down"
                                        aria-hidden="true"></i>
                                    Multi-Select</a>
                            </li>
                            <li id="" class="radioControl  fb_lit">
                                <a id="" class="fb_atg" href="#"> <i class="fa fa-circle-o" aria-hidden="true"></i>
                                    Radio</a>
                            </li>{{--
							<li id="" class="childinputControl  fb_lit">
								<a id="" class="fb_atg" href="#"> <i class="fa fa-child" aria-hidden="true"></i>
									Child Input</a>
							</li>--}}
                            <li id="" class="headingControl  fb_lit">
                                <a id="" class="fb_atg" href="#"> <i class="fa fa-header" aria-hidden="true"></i>
                                    Heading</a>
                            </li>
                            <li id="" class="checkboxControl  fb_lit">
                                <a id="" class="fb_atg" href="#"> <i class="fa fa-check-square-o"
                                        aria-hidden="true"></i>
                                    CheckBox</a>
                            </li>
                            <li id="" class="ratingControl fb_lit">
                                <a class="fb_atg" href="#"> <i class="fa fa-font" aria-hidden="true"></i>
                                    Ratings</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5 padd_0 fb_height fb_ovrflow fb_border_right">
            <div class='2nd pad_10' id=''>
                <table style="width :100%" cellpadding="10" id="form-table">
                    <tbody>
                        <!--to display created fields-->
                        @foreach($fieldsdata as $data)
                        @php
                         $dataa = json_decode($data->field_json);
                        @endphp
                        <tr id="tblrow{{$loop->index}}"
                            onclick='properties_function("update","{{$dataa->controltype}}",this,"{{$data->FEILD_ID}}", {!! json_encode($dataa)!!} )'>
                            @if($dataa->required == 'on') @php $required='required' ; $required_lb='*' ; @endphp @else
                            @php $required='' ; $required_lb='' ; @endphp @endif @if($dataa->readonly == 'on') @php
                            $readonly='readonly' ; @endphp @else @php $readonly='' ; @endphp @endif
                            @if($dataa->controltype == 'textbox')
                            <td>
                                <label id="label{{$loop->index}}">{{$dataa->field_caption}} <span class="require_id">
                                        {{$required_lb}}</span>
                                </label>
                            </td>
                            <td>
                                <input type="text" class="textbox_wd" id="field{{$loop->index}}" name="" {{$required}}
                                    {{$readonly}} placeholder="{{$dataa->placeholder}}" />
                            </td>
                            <td class="contro_width">
                                <button type='button' class="tdbutton" id="field{{$loop->index}}" onclick='deletefield({{$data->
								FEILD_ID}})'> <i class='fa fa-times' aria-hidden='true'></i>
                                </button>
                            </td>@elseif($dataa->controltype == 'number')
                            <td>
                                <label id="label{{$loop->index}}">{{$dataa->field_caption}} <span
                                        class="require_id">{{$required_lb}}</span>
                                </label>
                            </td>
                            <td>
                                <input type="text" class="textbox_wd" id="field{{$loop->index}}" name="" {{$required}}
                                    {{$readonly}} placeholder="{{$dataa->placeholder}}" />
                            </td>
                            <td class="contro_width">
                                <button type='button' class="tdbutton" id="field{{$loop->index}}" onclick='deletefield({{$data->
								FEILD_ID}})'><i class='fa fa-times' aria-hidden='true'></i>
                                </button>
                            </td>@elseif($dataa->controltype == 'textarea')
                            <td>
                                <label id="label{{$loop->index}}">{{$dataa->field_caption}} <span
                                        class="require_id">{{$required_lb}}</span>
                                </label>
                            </td>
                            <td>
                                <textarea id="projectinput9" rows="2" id="field{{$loop->index}}" class="textbox_wd"
                                    name="" {{$required}} {{$readonly}}
                                    placeholder="{{$dataa->placeholder}}">{{$dataa->default_value}}</textarea>
                            </td>
                            <td class="contro_width">
                                <button type='button' class="tdbutton" id="field{{$loop->index}}" onclick='deletefield({{$data->
								FEILD_ID}})'><i class='fa fa-times' aria-hidden='true'></i>
                                </button>
                            </td>@elseif($dataa->controltype == 'email' )
                            <td>
                                <label id="label{{$loop->index}}">{{$dataa->field_caption}} <span
                                        class="require_id">{{$required_lb}} </span>
                                </label>
                            </td>
                            <td>
                                <input type="text" class="textbox_wd" id="field{{$loop->index}}" name="" {{$required}}
                                    {{$readonly}} placeholder="{{$dataa->placeholder}}" />
                            </td>
                            <td class="contro_width">
                                <button type='button' class="tdbutton" id="field{{$loop->index}}" onclick='deletefield( {{$data->
								FEILD_ID}} )'><i class='fa fa-times' aria-hidden='true'></i>
                                </button>
                            </td>@elseif($dataa->controltype == 'date')
                            <td>
                                <label id="label{{$loop->index}}">{{$dataa->field_caption}} <span class="require_id">
                                        {{$required_lb}}</span>
                                </label>
                            </td>
                            <td>
                                <input type="date" class="textbox_wd" id="field{{$loop->index}}" name="date"
                                    {{$required}} placeholder="{{$dataa->placeholder}}" />
                            </td>
                            <td class="contro_width">
                                <button type='button' class="tdbutton" id="field{{$loop->index}}" onclick='deletefield({{$data->
								FEILD_ID}})'><i class='fa fa-times' aria-hidden='true'></i>
                                </button>
                            </td>@elseif($dataa->controltype == 'time')
                            <td>
                                <label id="label{{$loop->index}}">{{$dataa->field_caption}} <span class="require_id">
                                        {{$required_lb}}</span>
                                </label>
                            </td>
                            <td>
                                <input type="time" class="textbox_wd" id="field{{$loop->index}}" name="date"
                                    {{$required}} placeholder="{{$dataa->placeholder}}" />
                            </td>
                            <td class="contro_width">
                                <button type='button' class="tdbutton" id="field{{$loop->index}}" onclick='deletefield({{$data->
								FEILD_ID}})'><i class='fa fa-times' aria-hidden='true'></i>
                                </button>
                            </td>@elseif($dataa->controltype == 'dropdown')
                            <td>
                                <label id="label{{$loop->index}}">{{$dataa->field_caption}} <span class="require_id">
                                        {{$required_lb}}</span>
                                </label>
                            </td>
                            <td>@php $pr_val=$dataa->predefinelist_value; @endphp
                                <select data-placeholder="Select" class="select2 textbox_wd" {{$required}}>
                                    <option value="">Select</option>@foreach ( $pr_val as $id => $listvalue ) @php
                                    $arry_data=$listvalue->FIELD_VALUE; $expld_arry = explode(",",$arry_data); @endphp
                                    @foreach($expld_arry as $arry_datakey => $arry_datavalue)
                                    <option value="{{$arry_datavalue}}">{{$arry_datavalue}}</option>@endforeach
                                    @endforeach
                                </select>
                            </td>
                            <td class="contro_width">
                                <button type='button' class="tdbutton" id="field{{$loop->index}}" onclick='deletefield({{$data->
								FEILD_ID}})'><i class='fa fa-times' aria-hidden='true'></i>
                                </button>
                            </td>@elseif($dataa->controltype == 'multipleselection')
                            <td>
                                <label id="label{{$loop->index}}">{{$dataa->field_caption}} <span
                                        class="require_id">{{$required_lb}} </span>
                                </label>
                            </td>
                            <td>{{-- dfsfddsfds --}} @php $pr_valm=$dataa->predefinelist_value; @endphp
                                <select data-placeholder="Select" class="select2 textbox_wd" multiple="multiple"
                                    {{$required}}>
                                    <option value="">Select</option>@foreach($pr_valm as $pr_valmkey => $pr_valmvalue)
                                    @php $arry_data=$pr_valmvalue->FIELD_VALUE; $exploded_array =
                                    explode(",",$arry_data); @endphp @foreach($exploded_array as $exploded_arraykey =>
                                    $exploded_arrayvalue)
                                    <option value="{{$exploded_arrayvalue}}">{{$exploded_arrayvalue}}</option>
                                    @endforeach @endforeach
                                </select>
                            </td>
                            <td class="contro_width">
                                <button type='button' class="tdbutton" id="field{{$loop->index}}" onclick='deletefield({{$data->
								FEILD_ID}})'><i class='fa fa-times' aria-hidden='true'></i>
                                </button>
                            </td>@elseif($dataa->controltype == 'radiobutton')
                            <td>
                                <label id="label{{$loop->index}}">{{$dataa->field_caption}} <span class="require_id">
                                        {{$required_lb}}</span>
                                </label>
                            </td>
                            <td>@php $pr_val_radio=$dataa->predefinelist_value; @endphp @foreach ($pr_val_radio as $id
                                => $listvalue) @php $arry_data=$listvalue->FIELD_VALUE; $exploded_array =
                                explode(",",$arry_data); @endphp @foreach($exploded_array as $exploded_arraykey =>
                                $exploded_arrayvalue)
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="radio" id="field{{$loop->index}}" name="radiobutton"
                                            value="{{$id}}" {{$required}} {{$readonly}} /> <span
                                            style="margin-right: 30px;"> {{$exploded_arrayvalue}} </span>
                                    </div>
                                </div>@endforeach @endforeach</td>
                            <td class="contro_width">
                                <button type='button' class="tdbutton" id="field{{$loop->index}}" onclick='deletefield({{$data->
								FEILD_ID}})'><i class='fa fa-times' aria-hidden='true'></i>
                                </button>
                            </td>
                            @elseif($dataa->controltype == 'childinput')
                            <td>
                                <label id="label{{$loop->index}}">{{$dataa->field_caption}} <span class="require_id">
                                        {{$required_lb}}</span>
                                </label>
                            </td>
                            <td>
                                <input type="text" class="textbox_wd" id="field{{$loop->index}}" name="" {{$required}}
                                    {{$readonly}} placeholder="{{$dataa->placeholder}}" />
                            </td>
                            <td class="contro_width">
                                <button type='button' class="tdbutton" id="field{{$loop->index}}" onclick='deletefield({{$data->
								FEILD_ID}})'> <i class='fa fa-times' aria-hidden='true'></i>
                                </button>
                            </td>@elseif($dataa->controltype == 'heading')
                            <td colspan='2'>
                                <h3 id="heading{{$loop->index}}">{{$dataa->field_caption}}</h3>
                                <input type="hidden" {{$required}} {{$readonly}}>
                                <hr>
                            </td>
                            <td class="contro_width">
                                <button type='button' class="tdbutton" id="field{{$loop->index}}" onclick='deletefield({{$data->
								FEILD_ID}})'><i class='fa fa-times' aria-hidden='true'></i>
                                </button>
                            </td>{{--
							<hr>--}}
                            @elseif($dataa->controltype == 'checkbox')
                            <td>
                                <label id="label{{$loop->index}}">{{$dataa->field_caption}} <span class="require_id">
                                        {{$required_lb}}</span>
                                </label>
                            </td>
                            <td>@php $pr_val_checkbox=$dataa->predefinelist_value; @endphp @foreach ($pr_val_checkbox as
                                $id => $listvalue) @php $arry_data=$listvalue->FIELD_VALUE; $exploded_array =
                                explode(",",$arry_data); @endphp @foreach($exploded_array as $exploded_arraykey =>
                                $exploded_arrayvalue)
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="checkbox" id="field{{$loop->index}}" name="checkbox"
                                            value="{{$id}}" {{$required}} {{$readonly}} /> <span
                                            style="margin-right: 30px;"> {{$exploded_arrayvalue}} </span>
                                    </div>
                                </div>@endforeach @endforeach</td>
                            <td class="contro_width">
                                <button type='button' class="tdbutton" id="field{{$loop->index}}" onclick='deletefield({{$data->
								FEILD_ID}})'><i class='fa fa-times' aria-hidden='true'></i>
                                </button>
                            </td>@elseif($dataa->controltype == 'fileupload')
                            <td>
                                <label id="label{{$loop->index}}">{{$dataa->field_caption}} <span class="require_id">
                                        {{$required_lb}}</span>
                                </label>
                            </td>
                            <td>
                                <input type="file" class="textbox_wd" id="field{{$loop->index}}" name="fileupload"
                                    {{$required}} {{$readonly}} />
                            </td>
                            <td class="contro_width">
                                <button type='button' class="tdbutton" id="field{{$loop->index}}" onclick='deletefield({{$data->
								FEILD_ID}})'><i class='fa fa-times' aria-hidden='true'></i>
                                </button>
                            </td>@elseif($dataa->controltype == 'ratings' )
                            <td>
                                <label id="label{{$loop->index}}">{{$dataa->field_caption}} <span class="require_id">
                                        {{$required_lb}}</span>
                                </label>
                            </td>
                            <td>
                                <fieldset class="rate" id="label{{$loop->index}}">
                                    <input type="radio" id="field{{$loop->index}}-1" name="rating" value="5.0" />
                                    <label for="field{{$loop->index}}-1" title="5 stars"></label>
                                    <input type="radio" id="field{{$loop->index}}-2" name="rating" value="4.5" />
                                    <label class="half" for="field{{$loop->index}}-2" title="4 1/2 stars"></label>
                                    <input type="radio" id="field{{$loop->index}}-3" name="rating" value="4.0" />
                                    <label for="field{{$loop->index}}-3" title="4 stars"></label>
                                    <input type="radio" id="field{{$loop->index}}-4" name="rating" value="3.5" />
                                    <label class="half" for="field{{$loop->index}}-4" title="3 1/2 stars"></label>
                                    <input type="radio" id="field{{$loop->index}}-5" name="rating" value="3.0" />
                                    <label for="field{{$loop->index}}-5" title="3 stars"></label>
                                    <input type="radio" id="field{{$loop->index}}-6" name="rating" value="2.5" />
                                    <label class="half" for="field{{$loop->index}}-6" title="2 1/2 stars"></label>
                                    <input type="radio" id="field{{$loop->index}}-7" name="rating" value="2.0" />
                                    <label for="field{{$loop->index}}-7" title="2 stars"></label>
                                    <input type="radio" id="field{{$loop->index}}-8" name="rating" value="1.5" />
                                    <label class="half" for="field{{$loop->index}}-8" title="1 1/2 stars"></label>
                                    <input type="radio" id="field{{$loop->index}}-9" name="rating" value="1.0" />
                                    <label for="field{{$loop->index}}-9" title="1 star"></label>
                                    <input type="radio" id="field{{$loop->index}}-10" name="rating" value="0.5" />
                                    <label class="half" for="field{{$loop->index}}-10" title="1/2 star"></label>
                                    <input type="radio" id="field{{$loop->index}}-11" name="rating" value="0.0" />
                                    <label for="field{{$loop->index}}-11" title="No star"></label>
                                </fieldset>
                            </td>
                            <td class="contro_width">
                                <button type='button' class="tdbutton" id="field{{$loop->index}}" onclick='deletefield({{$data->
								FEILD_ID}})'><i class='fa fa-times' aria-hidden='true'></i>
                                </button>
                            </td>@endif
                        </tr>@endforeach</tbody>
                </table>
            </div>
        </div>
        <div class="col-md-4 padd_0 fb_height fb_ovrflow">
            <div class='3rd pad_10'>
                <form class="form form-horizontal" name="" action="" id="propertiesForm" method="post"
                    autocomplete="off" onkeypress="return event.keyCode != 13;">
                    <input type="hidden" value="{{csrf_token()}}" name="_token" />
                    <input type="hidden" value="{{  $formdata->FORMID }}" name="formid" />
                    <div class='' id='control_properties'></div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('addscriptscontent')
<script>
    function Custom_feild(select, rowid) {
	if (select.value == 'Custom') {
		Dynamic_patch = '<label>Custom Field Caption</label><input type="text" name="Custom_Field" class="form-control" required><input id="btnAdd" type="button" value="Add" onclick="btnclick()"/><br /><div id="TextBoxContainer"></div>';
		$("#edit_predefine").empty();
		$('#Custom_div').append(Dynamic_patch);
	} else {
		Dynamic_patch_1 = '<label>Do you want to edit this list values</label> <input type="checkbox" name="edit_pre_val" value="Yes" onchange="check_predefine(this)"><div id="edited_predfn_patch"></div>';
		$("#edit_predefine").empty();
		$('#edit_predefine').append(Dynamic_patch_1);
		$('#Custom_div').empty();
	}
}
function check_predefine(id) {
	if ($(id).is(":checked")) {
		var predefine_list_value = $("#predefinelist_id").val();
		var new_pred_val = predefine_list_value.replace(/_/g, ' ');
		var base_url = {!!json_encode(url('/'))!!};
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			url: base_url + '/predefine_lists',
			type: 'POST',
			data: {
				predefine_list_value: predefine_list_value,
			},
			success: function (data) {
				console.log('Data', data)
				var Dynamic_patch_2 = [];
				Dynamic_patch_2.push(' <label>Custom Field Caption</label><input type="text" name="Custom_Field" class="form-control" value="' + new_pred_val + '" readonly>');
				for (let ww = 0; ww < data.length; ww++) {
					Dynamic_patch_2.push('<div><input name = "DynamicTextBox[]" type="text" value = "' + data[ww] + '" />&nbsp;' + '<input type="button" value="Remove" class="remove" /></div>');
				}
				Dynamic_patch_2.push('<input id="btnAdd" type="button" value="Add" onclick="btnclick()"/><br /><div id="TextBoxContainer"></div>');
				$("#edited_predfn_patch").empty();
				$('#edited_predfn_patch').append(Dynamic_patch_2);
				// return;
			},
			complete: function (data) {
				// console.log('Datasadfsadfsad', data)
				// return;
			}
		})
		// Dynamic_patch_2 = '<input name = "DynamicTextBox[]" type="text" value = "' + value + '" />&nbsp;' + '<input type="button" value="Remove" class="remove" />';
		// console.log(" CHeckedddd");
		// $("#edited_predfn_patch").empty();
		// $('#edited_predfn_patch').append(Dynamic_patch_2);
	} else {
		$("#edited_predfn_patch").empty();
		console.log("UN - CHeckedddd");
	}
}
//diaplay input tags
jQuery(document).ready(function ($) {
	var autoid = autoids();
	// alert(autoid)
	var type = '"new"';
	var key = '""';
	$('.textboxControl').click(function () {
		var controlType = '"textbox"';
		var data = '{"required":true,"readonly":"","controltype":"textbox","type":"normal","placeholder":"","field_length":"100","default_value":"","session_value":"","field_caption":"","validation_id":""}';
		var box_html = $("<tr id='tblrow" + autoid + "'><td onclick='properties_function(" + type + "," + controlType + "," + autoid + "," + key + "," + data + ")'> <label id='label" + autoid + "'>TextBox</label></td><td onclick='properties_function(" + type + "," + controlType + "," + autoid + "," + key + "," + data + ")'> <input name='value" + autoid + "' type='text' class='form-control' /></td><td> <button type='button' class='tdbutton' id='deletebutton" + autoid + "' onclick='deleteFun(" + autoid + ")'><i class='fa fa-times' aria-hidden='true'></button></td></tr>");
		$('#form-table').append(box_html);
		box_html.fadeIn('slow');
	});
	$('.ratingControl').click(function () {
		var controlType = '"ratings"';
		var data = '{"controltype":"ratings","required":true,"readonly":"","field_caption":"","type":"normal","validation_id":"0"}';
		// var box_html = $("<tr id='tblrow"+autoid+"' onclick='properties_function("+type+","+controlType+","+autoid+","+key+","+data+")' ><td  colspan = '2'><label id='ratings"+autoid+"'>Untitled</label><hr></td><td><button type='button' class='tdbutton' id = 'deletebutton"+autoid+"'  onclick='deleteFun("+autoid+")'><i class='fa fa-times' aria-hidden='true'></button></td></tr>");
		var rating_ui = '<fieldset class="rate"><input type="radio" id="rating10" name="rating" value="5.0" /><label for="rating10" title="5 stars"></label><input type="radio" id="rating9" name="rating" value="4.5" /><label class="half" for="rating9"title="4 1/2 stars"></label><input type="radio" id="rating8" name="rating" value="4.0" /><label for="rating8" title="4 stars"></label><input type="radio" id="rating7" name="rating" value="3.5" /><label class="half" for="rating7"title="3 1/2 stars"></label><input type="radio" id="rating6" name="rating" value="3.0" /><label for="rating6" title="3 stars"></label><input type="radio" id="rating5" name="rating" value="2.5" /><label class="half" for="rating5"title="2 1/2 stars"></label><input type="radio" id="rating4" name="rating" value="2.0" /><label for="rating4" title="2 stars"></label><input type="radio" id="rating3" name="rating" value="1.5" /><label class="half" for="rating3"title="1 1/2 stars"></label><input type="radio" id="rating2" name="rating" value="1.0" /><label for="rating2" title="1 star"></label><input type="radio" id="rating1" name="rating" value="0.5" /><label class="half" for="rating1"title="1/2 star"></label><input type="radio" id="rating0" name="rating" value="0.0" /><label for="rating0" title="No star"></label></fieldset>'
		var box_html = $("<tr id='tblrow" + autoid + "' onclick='properties_function(" + type + "," + controlType + "," + autoid + "," + key + "," + data + ")' ><td ><label  id='label" + autoid + "'>Ratings</label></td><td>" + rating_ui + "</td><td><button type='button' class='tdbutton' id = 'deletebutton" + autoid + "'  onclick='deleteFun(" + autoid + ")'><i class='fa fa-times' aria-hidden='true'></button></td></tr>");
		$('#form-table').append(box_html);
		box_html.fadeIn('slow');
		// var data = '{"required":true,"readonly":"","controltype":"ratings","type":"normal","placeholder":"","field_length":"100","default_value":"","session_value":"","field_caption":"","validation_id":""}';
		// var box_html = $("<tr id='tblrow"+autoid+"' onclick='properties_function("+type+","+controlType+","+autoid+","+key+","+data+")' ><td ><label  id='label"+autoid+"'>Untitled</label></td><td><input name='value"+autoid+"' type='text'  class='form-control'/></td><td><button type='button' class='tdbutton' id = 'deletebutton"+autoid+"'  onclick='deleteFun("+autoid+")'><i class='fa fa-times' aria-hidden='true'></button></td></tr>");
		// $('#form-table').append(box_html);
		box_html.fadeIn('slow');
	});
	$('.numberControl').click(function () {
		var controlType = '"number"';
		var data = '{"required":true,"readonly":"","controltype":"number","type":"normal","placeholder":"","field_length":"10","default_value":"","field_caption":"","validation_id":"0"}';
		var box_html = $("<tr id='tblrow" + autoid + "' onclick='properties_function(" + type + "," + controlType + "," + autoid + "," + key + "," + data + ")'><td ><label  id='label" + autoid + "'>Number</label></td><td><input name='value" + autoid + "' type='number'  class='form-control'/></td><td><button type='button' class='tdbutton' id = 'deletebutton" + autoid + "'  onclick='deleteFun(" + autoid + ")'><i class='fa fa-times' aria-hidden='true'></button></td></tr>");
		$('#form-table').append(box_html);
		box_html.fadeIn('slow');
	});
	$('.textareaControl').click(function () {
		var controlType = '"textarea"';
		var data = '{"required":true,"readonly":"","controltype":"textarea","type":"normal","placeholder":"","field_length":"100","default_value":"","field_caption":"","validation_id":""}';
		var box_html = $("<tr id='tblrow" + autoid + "' onclick='properties_function(" + type + "," + controlType + "," + autoid + "," + key + "," + data + ")' ><td ><label id='label" + autoid + "'>Textarea</label></td><td><textarea name='' class='form-control'></textarea> </td><td><button type='button' class='tdbutton' id = 'deletebutton" + autoid + "'  onclick='deleteFun(" + autoid + ")'><i class='fa fa-times' aria-hidden='true'></button></td></tr>");
		$('#form-table').append(box_html);
		box_html.fadeIn('slow');
	});
	$('.emailControl').click(function () {
		var controlType = '"email"';
		var data = '{"required":true,"readonly":"","controltype":"email","type":"normal","placeholder":"","field_length":"100","default_value":"","field_caption":"","validation_id":"0"}';
		var box_html = $("<tr id='tblrow" + autoid + "' onclick='properties_function(" + type + "," + controlType + "," + autoid + "," + key + "," + data + ")' ><td ><label id='label" + autoid + "'>Email</label></td><td><input name='' type='email' class='form-control' /></td><td><button type='button' class='tdbutton' id = 'deletebutton" + autoid + "'  onclick='deleteFun(" + autoid + ")'><i class='fa fa-times' aria-hidden='true'></button></td></tr>");
		$('#form-table').append(box_html);
		box_html.fadeIn('slow');
	});
	$('.dateControl').click(function () {
		var controlType = '"date"';
		var data = '{"required":true,"readonly":"","controltype":"date","type":"normal","placeholder":"","field_length":"100","default_value":"","field_caption":"","validation_id":"0"}';
		var box_html = $("<tr id='tblrow" + autoid + "' onclick='properties_function(" + type + "," + controlType + "," + autoid + "," + key + "," + data + ")' ><td ><label id='label" + autoid + "'>Date</label></td><td><input name='' type='date'  class='form-control calender ' onkeydown='return false' /></td><td><button type='button' class='tdbutton' id = 'deletebutton" + autoid + "'  onclick='deleteFun(" + autoid + ")'><i class='fa fa-times' aria-hidden='true'></button></td></tr>");
		$('#form-table ').append(box_html);
		box_html.fadeIn('slow');
	});
	$('.timeControl').click(function () {
		var controlType = '"time"';
		var data = '{"required":true,"readonly":"","controltype":"time","type":"normal","placeholder":"","field_length":"100","default_value":"","field_caption":"","validation_id":"0"}';
		var box_html = $("<tr id='tblrow" + autoid + "' onclick='properties_function(" + type + "," + controlType + "," + autoid + "," + key + "," + data + ")' ><td ><label id='label" + autoid + "'>Time</label></td><td><input name='' type='time'  class='form-control calender ' onkeydown='return false' /></td><td><button type='button' class='tdbutton' id = 'deletebutton" + autoid + "'  onclick='deleteFun(" + autoid + ")'><i class='fa fa-times' aria-hidden='true'></button></td></tr>");
		$('#form-table ').append(box_html);
		box_html.fadeIn('slow');
	});
	$('.dropdownControl').click(function () {
		var controlType = '"dropdown"';
		var data = '{"required":true,"readonly":"","controltype":"dropdown","type":"normal","field_length":"100","default_value":"","field_caption":"","validation_id":"0"}';
		var box_html = $("<tr id='tblrow" + autoid + "' onclick='properties_function(" + type + "," + controlType + "," + autoid + "," + key + "," + data + ")' ><td ><label id='label" + autoid + "'>Dropdown</label></td><td><select name='' class='form-control' data-placeholder='Select'></select></td><td><button type='button' class='tdbutton' id = 'deletebutton" + autoid + "'  onclick='deleteFun(" + autoid + ")'><i class='fa fa-times' aria-hidden='true'></button></td></tr>");
		$('#form-table').append(box_html);
		box_html.fadeIn('slow');
	});
	$('.multipleSelectionControl').click(function () {
		var controlType = '"multipleselection"';
		var data = '{"required":true,"readonly":"","controltype":"multipleselection","type":"normal","field_length":"100","default_value":"","field_caption":"","validation_id":"0"}';
		var box_html = $("<tr id='tblrow" + autoid + "' onclick='properties_function(" + type + "," + controlType + "," + autoid + "," + key + "," + data + ")' ><td ><label id='label" + autoid + "'>Multiselect</label></td><td><select name='' class='form-control' data-placeholder='Select'></select></td><td><button type='button' class='tdbutton' id = 'deletebutton" + autoid + "'  onclick='deleteFun(" + autoid + ")'><i class='fa fa-times' aria-hidden='true'></button></td></tr>");
		$('#form-table ').append(box_html);
		box_html.fadeIn('slow');
	});
	$('.radioControl').click(function () {
		var controlType = '"radiobutton"';
		var data = '{"required":true,"readonly":"","type":"normal","controltype":"radiobutton","field_caption":"","validation_id":"0"}';
		var box_html = $("<tr id='tblrow" + autoid + "' onclick='properties_function(" + type + "," + controlType + "," + autoid + "," + key + "," + data + ")'><td ><label class='radio-inline' id='label" + autoid + "'>Radio</label></td><td><div class='row'><div class='col-md-12'><input name='' type='radio' class='' /> Option 1 </div></div><div class='row'><div class='col-md-12'><input name='' type='radio' class='' /> Option 2</div></div><div class='row'><div class='col-md-12'><input name='' type='radio' class='' /> Option 3</div></div></td><td><button type='button' class='tdbutton' id = 'deletebutton" + autoid + "'  onclick='deleteFun(" + autoid + ")'><i class='fa fa-times' aria-hidden='true'></button></td></tr>");
		$('#form-table ').append(box_html);
		box_html.fadeIn('slow');
	});
	$('.childinputControl').click(function () {
		var controlType = '"childinput"';
		var data = '{"required":true,"readonly":"","controltype":"childinput","type":"normal","placeholder":"","field_length":"100","default_value":"","field_caption":"","validation_id":""}';
		var box_html = $("<tr id='tblrow" + autoid + "' onclick='properties_function(" + type + "," + controlType + "," + autoid + "," + key + "," + data + ")' ><td ><label  id='label" + autoid + "'>Untitled</label></td><td><input name='value" + autoid + "' type='text'  class='form-control'/></td><td><button type='button' class='tdbutton' id = 'deletebutton" + autoid + "'  onclick='deleteFun(" + autoid + ")'><i class='fa fa-times' aria-hidden='true'></button></td></tr>");
		$('#form-table').append(box_html);
		box_html.fadeIn('slow');
	});
	$('.headingControl').click(function () {
		var controlType = '"heading"';
		var data = '{"controltype":"heading","required":true,"readonly":"","field_caption":"","type":"normal","validation_id":"0"}';
		var box_html = $("<tr id='tblrow" + autoid + "' onclick='properties_function(" + type + "," + controlType + "," + autoid + "," + key + "," + data + ")' ><td  colspan = '2'><h1 id='heading" + autoid + "'>Sample Heading</h1><hr></td><td><button type='button' class='tdbutton' id = 'deletebutton" + autoid + "'  onclick='deleteFun(" + autoid + ")'><i class='fa fa-times' aria-hidden='true'></button></td></tr>");
		$('#form-table').append(box_html);
		box_html.fadeIn('slow');
	});
	$('.checkboxControl').click(function () {
		var controlType = '"checkbox"';
		var data = '{"required":true,"readonly":"","type":"normal","controltype":"checkbox","field_caption":"","validation_id":"0"}';
		var box_html = $("<tr id='tblrow" + autoid + "' onclick='properties_function(" + type + "," + controlType + "," + autoid + "," + key + "," + data + ")'><td ><label class='radio-inline' id='label" + autoid + "'>Checkbox</label></td><td><div class='row'><div class='col-md-12'><input name='' type='checkbox' class='' /> <span class='checkmark mar_right'>Option 1</span> </div></div><div class='row'><div class='col-md-12'><input name='' type='checkbox' class='' /> Option 2</div></div><div class='row'><div class='col-md-12'><input name='' type='checkbox' class='' /> Option 3</div></div></td><td><button type='button' class='tdbutton' id = 'deletebutton" + autoid + "'  onclick='deleteFun(" + autoid + ")'><i class='fa fa-times' aria-hidden='true'></button></td></tr>");
		$('#form-table ').append(box_html);
		box_html.fadeIn('slow');
	});
	$('.fileuploadControl').click(function () {
		var controlType = '"fileupload"';
		var data = '{"required":true,"readonly":"","controltype":"fileupload","type":"normal","field_length":"100","field_caption":"","validation_id":""}';
		var box_html = $("<tr id='tblrow" + autoid + "' onclick='properties_function(" + type + "," + controlType + "," + autoid + "," + key + "," + data + ")' ><td ><label id='label" + autoid + "'>FileUpload</label></td><td><input 'type='file'  class = 'form-control' name = 'file[]'  id='file' value=''  multiple='multiple' /> </td><td><button type='button' class='tdbutton' id = 'deletebutton" + autoid + "'  onclick='deleteFun(" + autoid + ")'><i class='fa fa-times' aria-hidden='true'></button></td></tr>");
		$('#form-table ').append(box_html);
		box_html.fadeIn('slow');
	});
});
function give_heading(val, rowId) {
	$("#heading" + rowId).text(val);
}

function give_rating_heading(val, rowId) {
	$("#ratings" + rowId).text(val);
}

function give_placeholder(val, rowId) {
	$("#field" + rowId).attr("placeholder", val);
}

function give_caption(val, rowId) {
	$("#label" + rowId).text(val);
}
//enable-disable session field
function give_defaultvalue(val, rowId) {
	$("#field" + rowId).attr("value", val);
	if (val != '') {
		$("#session_value").prop('disabled', true);
	} else {
		$("#session_value").prop('disabled', false);
	}
}
function trim(el) {
	el.value = el.value.
	replace(/(^\s*)|(\s*$)/gi, ""). // removes leading and trailing spaces
	replace(/[ ]{2,}/gi, " "). // replaces multiple spaces with one space
	replace(/\n +/, "\n"); // Removes spaces after newlines
	return;
}
// <!--remove fields -->
function deleteFun(id) {
	$('tbody').on('click', "#deletebutton" + id, function () {
		$("#control_properties").empty();
		var aa = $(this).parent();
		$(aa).parent().fadeOut("slow", function () {
			$(this).remove();
			$("[id = 'buttons']").removeAttr("disabled");
			// properties_function("");
		});
		return false;
	});
}
// <!--display form for field creation-->
function properties_function(type, controltype, element, id, data) {
	// console.log(data)
	document.getElementById("control_properties").innerHTML = "";
	if (type == 'new') {
		var rowId = element;
	} else {
		var rowId = parseInt($(element).closest('tr').rowIndex);
	}
	/* var voptions = '';
			voptions += '<option value="/^[a-zA-Z0-9 ]+$/" >Alphanumeric Only</option>';
			voptions += '<option value="/^[0-9 ]+$/" >Numeric Only</option>';
		voptions += '<option value="/^[a-zA-Z ]+$/" >Character Only</option>'; */
	var validations = {!!json_encode($validation_arr)!!};
	var voptions = '';
	for (var i = 0; i < validations.length; i++) {
		if (data.validation_id == validations[i].v_id) {
			if (data.hasOwnProperty('formid')) {
				voptions += '<option selected value=' + validations[i].v_id + '>' + validations[i].v_name + '</option>';
			} else {
				voptions += '<option  value=' + validations[i].v_id + '>' + validations[i].v_name + '</option>';
			}
		} else {
			voptions += '<option  value=' + validations[i].v_id + '>' + validations[i].v_name + '</option>';
		}
	}
	var session_value = '';
	if (controltype == 'textbox') {
        session_value += '<option value=fullname>Full Name</option>';
        session_value += '<option value=EMAILID >Email ID</option>';
        session_value += '<option value=pan_card >Pan Card</option>';
		document.getElementById("control_properties").innerHTML = "<div class='row'><div class='col-md-12'><div class='form-group'> <label for='projectinput3'>Control Type: TextBox</label></div></div></div> <input type='hidden' name='controltype' value='" + controltype + "' /><div class='row'><div class='col-md-12'><div class='form-group'> <label for='projectinput3'>Field Caption</label><span style='color:red'> *</span> <input type='text' name='field_caption' required value='" + data.field_caption + "' onchange='return trim(this)' class='form-control' title='Only Character and Number Allow!!' onblur=test(this, 'validtxtbox') onkeyup='give_caption(this.value," + rowId + ")'><div style='color:red' id='validtxtbox'></div></div></div></div><div class='row'><div class='col-md-12'><div class='form-group'> <label for='projectinput3'>Placeholder</label> <input type='text' title='Only Character and Number Allow!!' class='form-control' onblur=test(this, 'validplaceholder') name='placeholder' onchange='return trim(this)' value='" + data.placeholder + "' onkeyup='give_placeholder(this.value," + rowId + ")' /><div style='color:red' id='validplaceholder'></div></div></div></div><div class='row'><div class='col-md-12'><div class='form-group'> <label for='projectinput3'>Field Length</label><span style='color:red'> *</span> <input type='text' required class='form-control' onchange='return trim(this)' name='field_length' id='field_length' value='" + data.field_length + "'></div></div></div><div class='row'><div class='col-md-12'><div class='form-group'> <label for='projectinput3'>Session Value</label> <select data-placeholder='Choose a Session' class='select2 form-control' name='session_value' id='session_value'><option value=''>---Select---</option>" + session_value + "</select></div></div></div><div class='row'><div class='col-md-12'><div class='form-group'> <label for='projectinput3'>Validation</label><span style='color:red'> *</span> <select data-placeholder='Choose a Country' class='select2 form-control' name='validation_id' required><option value='' selected>--Select--</option>" + voptions + "</select></div></div></div><div class='row'><div class='col-md-12'> <input type='checkbox' name='required' id='required' class='mar_left'><span class='checkmark mar_right'><label for='required' class='lbl'>Required</label></span> <input type='checkbox' style='margin-left:8px;' name='readonly' id='readonly' /><span class='checkmark'><label for='readonly' class='lbl_rdonly'>Readonly</label></span></div></div> <input type='hidden' name='fieldkey' value='" + id + "' /> <input type='hidden' name='type' value='" + type + "' /><center> <button type='submit' class='btn-sm btn btn-info waves-effect waves-light newbtn hvr-glow box-shadow-3 mar_top' name='submit' id='submitform'>Submit <span class='btn-label3'></span> </button></center>";
		if (data.required == "on") {
			$('#required').prop('checked', true);
		} else {
			$('#required').prop('checked', false);
		}
		if (data.readonly == "on") {
			$('#readonly').prop('checked', true);
		} else {
			$('#readonly').prop('checked', false);
		}
		if (data.session_value != '') {
			$("#default_value").prop('disabled', true);
		} else {
			$("#default_value").prop('disabled', false);
		}
		// $('#session_value').change(function () {
		// 	var session_value=$("#session_value").val();
		// 	if(session_value != '')
		// 	{
		// 		$("#default_value").prop('disabled',true);
		// 	}
		// 	else
		// 	{
		// 		$("#default_value").prop('disabled',false);
		// 	}
		// });
		$("#session_value").val(data.session_value).attr("selected", "selected");
	} else if (controltype == 'number') {
        session_value += '<option value=mob_no>Mobile No</option>';
        session_value += '<option value=addhar_no>Adhar No</option>';
		document.getElementById("control_properties").innerHTML = "<div class='row'><div class='col-md-12'><div class='form-group'> <label for='projectinput3'>Control Type: Number</label></div></div></div> <input type='hidden' name='controltype' value='" + controltype + "' /><div class='row'><div class='col-md-12'><div class='form-group'> <label for='projectinput3'>Field Caption</label><span style='color:red'> *</span> <input type='text' name='field_caption' required value='" + data.field_caption + "' onchange='return trim(this)' class='form-control' title='Only Character and Number Allow!!' onblur=test(this, 'validtxtbox') onkeyup='give_caption(this.value," + rowId + ")'><div style='color:red' id='validtxtbox'></div></div></div></div><div class='row'><div class='col-md-12'><div class='form-group'> <label for='projectinput3'>Placeholder</label> <input type='text' title='Only Character and Number Allow!!' class='form-control' onblur=test(this, 'validplaceholder') name='placeholder' onchange='return trim(this)' value='" + data.placeholder + "' onkeyup='give_placeholder(this.value," + rowId + ")' /><div style='color:red' id='validplaceholder'></div></div></div></div><div class='row'><div class='col-md-12'><div class='form-group'> <label for='projectinput3'>Field Length</label><span style='color:red'> *</span> <input type='text' required class='form-control' onchange='return trim(this)' name='field_length' id='field_length' value='" + data.field_length + "'></div></div></div><div class='row'><div class='col-md-12'><div class='form-group'> <label for='projectinput3'>Session Value</label> <select data-placeholder='Choose a Session' class='select2 form-control' name='session_value' id='session_value'><option value=''>---Select---</option>" + session_value + "</select></div></div></div><div class='row'><div class='col-md-12'> <input type='checkbox' name='required' id='required' class='mar_left'><span class='checkmark mar_right'><label for='required' class='lbl'>Required</label></span> <input type='checkbox' style='margin-left:8px;' name='readonly' id='readonly' /><span class='checkmark'><label for='readonly' class='lbl_rdonly'>Readonly</label></span></div></div> <input type='hidden' name='fieldkey' value='" + id + "' /> <input type='hidden' name='type' value='" + type + "' /><center> <button type='submit' class='btn-sm btn btn-info waves-effect waves-light newbtn hvr-glow box-shadow-3 mar_top' name='submit' id='submitform'>Submit <span class='btn-label3'></span> </button></center>";
		if (data.required == "on") {
			$('#required').prop('checked', true);
		} else {
			$('#required').prop('checked', false);
		}
		if (data.readonly == "on") {
			$('#readonly').prop('checked', true);
		} else {
			$('#readonly').prop('checked', false);
		}
        if (data.session_value != '') {
			$("#default_value").prop('disabled', true);
		} else {
			$("#default_value").prop('disabled', false);
		}
        $("#session_value").val(data.session_value).attr("selected", "selected");
	} else if (controltype == 'textarea') {
		document.getElementById("control_properties").innerHTML = "<div class='row'><div class='col-md-12'><div class='form-group'><label for='projectinput3'>Control Type: " + controltype + "</label></div></div></div><input type='hidden' name = 'controltype' value='" + controltype + "'/><div class='row'><div class='col-md-12'><div class='form-group'><label for='projectinput3'>Field Caption</label><span style='color:red'> *</span><input autofocus type ='text' name='field_caption' required value='" + data.field_caption + "' onchange='return trim(this)' class = 'form-control'  title='Only Character and Number Allow!!' onblur=test(this,'validtxtbox') onkeyup='give_caption(this.value," + rowId + ")'><div style='color:red' id='validtxtbox'></div></div></div></div><div class='row'><div class='col-md-12'><div class='form-group'><label for='projectinput3'>Placeholder</label><input type ='text' title='Only Character and Number Allow!!' class = 'form-control' onblur=test(this,'validplaceholder') name = 'placeholder' onchange='return trim(this)' value = '" + data.placeholder + "' onkeyup='give_placeholder(this.value," + rowId + ")'/><div style='color:red' id='validplaceholder'></div></div></div></div><div class='row'><div class='col-md-12'><div class='form-group'><label for='projectinput3'>Field Length</label><span style='color:red'> *</span><input type ='text' required class = 'form-control' onchange='return trim(this)' name = 'field_length' id='field_length' value = '" + data.field_length + "'></div></div></div><div class='row'><div class='col-md-12'><div class='form-group'><label for='projectinput3'>Default Value</label><input type ='text' onchange='return trim(this)' class = 'form-control' name = 'default_value'  id = 'default_value' value = '" + data.default_value + "' ></div></div></div><div class='row'><div class='col-md-12'><div class='form-group'><label for='projectinput3'>Validation</label><select data-placeholder='Choose a Validation' class='select2 form-control'  name='validation_id' ><option value='' >--Select--</option>" + voptions + "</select></div></div></div><div class='row'><div class='col-md-12'><input type='checkbox' name = 'required' id='required'  class ='mar_left'><span class='checkmark mar_right'><label for='required' class='lbl'>Required</label></span><input type='checkbox' style='margin-left:8px;' name = 'readonly' id='readonly' /><span class='checkmark'><label for='readonly' class='lbl_rdonly'>Readonly</label></span></div></div><input type='hidden' name = 'fieldkey' value ='" + id + "'/><input type='hidden' name = 'type' value ='" + type + "'/><center><button type='submit'  class='btn-sm btn btn-info waves-effect waves-light newbtn hvr-glow box-shadow-3 mar_top' name='submit' id='submitform'> Submit  <span class='btn-label3'></span></button></center>";
		if (data.required == "on") {
			$('#required').prop('checked', true);
		} else {
			$('#required').prop('checked', false);
		}
		if (data.readonly == "on") {
			$('#readonly').prop('checked', true);
		} else {
			$('#readonly').prop('checked', false);
		}
	} else if (controltype == 'email') {
        session_value += '<option value=PERSONAL_EMAIL >Personal Email</option>';
        session_value += '<option value=EMAILID>Offical Email</option>';
		document.getElementById("control_properties").innerHTML = "<div class='row'><div class='col-md-12'><div class='form-group'> <label for='projectinput3'>Control Type: Email</label></div></div></div> <input type='hidden' name='controltype' value='" + controltype + "' /><div class='row'><div class='col-md-12'><div class='form-group'> <label for='projectinput3'>Field Caption</label><span style='color:red'> *</span> <input autofocus type='text' value='" + data.field_caption + "' class='form-control' name='field_caption' onchange='return trim(this)' title='Only Character and Number Allow!!' onblur=test(this, 'validtxtbox') required onkeyup='give_caption(this.value," + rowId + ")' /><div style='color:red' id='validtxtbox'></div></div></div></div><div class='row'><div class='col-md-12'><div class='form-group'> <label for='projectinput3'>Placeholder</label> <input type='text' title='Only Character and Number Allow!!' class='form-control' onblur=test(this, 'validplaceholder') name='placeholder' onchange='return trim(this)' value='" + data.placeholder + "' onkeyup='give_placeholder(this.value," + rowId + ")' /><div style='color:red' id='validplaceholder'></div></div></div></div><div class='row'><div class='col-md-12'><div class='form-group'> <label for='projectinput3'>Field Length</label><span style='color:red'> *</span> <input type='text' required onchange='return trim(this)' class='form-control' name='field_length' value='" + data.field_length + "'></div></div></div><div class='row'><div class='col-md-12'><div class='form-group'> <label for='projectinput3'>Session Value</label> <select data-placeholder='Choose a Session' class='select2 form-control' name='session_value' id='session_value'><option value=''>---Select---</option>" + session_value + "</select></div></div></div><div class='row'><div class='col-md-12'> <input type='checkbox' name='required' id='required' class='mar_left'><span class='checkmark mar_right'><label for='required' class='lbl'>Required</label></span> <input type='checkbox' name='readonly' id='readonly' /><span class='checkmark'><label for='readonly' class='lbl_rdonly'>Readonly</label></span></div></div> <input type='hidden' name='fieldkey' value='" + id + "' /> <input type='hidden' name='type' value='" + type + "' /> <input type='hidden' name='validation_id' value='0' /><center> <button type='submit' class='btn-sm btn btn-info waves-effect waves-light newbtn hvr-glow box-shadow-3 mar_top' name='submit' id='submitform'>Submit <span class='btn-label3'></span> </button></center>";
		if (data.required == "on") {
			$('#required').prop('checked', true);
		} else {
			$('#required').prop('checked', false);
		}
		if (data.readonly == "on") {
			$('#readonly').prop('checked', true);
		} else {
			$('#readonly').prop('checked', false);
		}
        $("#session_value").val(data.session_value).attr("selected", "selected");
	} else if (controltype == 'date') {
		document.getElementById("control_properties").innerHTML = "<div class='row'><div class='col-md-12'><div class='form-group'><label for='projectinput3'>Control Type: " + controltype + "</label></div></div></div><input type='hidden' name = 'controltype' value='" + controltype + "'/><div class='row'><div class='col-md-12'><div class='form-group'><label for='projectinput3'>Field Caption</label><span style='color:red'> *</span><input autofocus type ='text' value='" + data.field_caption + "' class = 'form-control' name = 'field_caption' onchange='return trim(this)' required onkeyup='give_caption(this.value," + rowId + ")' title='Only Character and Number Allow!!' onblur=test(this,'validtxtbox')><div style='color:red' id='validtxtbox'></div></div></div></div><div class='row'><div class='col-md-12'><input type='checkbox' name = 'required' id='required'  class ='mar_left'><span class='checkmark mar_right'><label for='required' class='lbl'>Required</label></span></div></div><input type='hidden' name = 'fieldkey' value ='" + id + "'/><input type='hidden' name = 'type' value ='" + type + "'/><input type='hidden' name = 'validation_id' value = '0'/><input type='hidden' name = 'readonly' value = 'off'/><center><button type='submit'  class='btn-sm btn btn-info waves-effect waves-light newbtn hvr-glow box-shadow-3 mar_top' name='submit' id='submitform'> Submit   <span class='btn-label3'></span></button></center>";
		if (data.required == "on") {
			$('#required').prop('checked', true);
		} else {
			$('#required').prop('checked', false);
		}
	} else if (controltype == 'time') {
		document.getElementById("control_properties").innerHTML = "<div class='row'><div class='col-md-12'><div class='form-group'><label for='projectinput3'>Control Type: " + controltype + "</label></div></div></div><input type='hidden' name = 'controltype' value='" + controltype + "'/><div class='row'><div class='col-md-12'><div class='form-group'><label for='projectinput3'>Field Caption</label><span style='color:red'> *</span><input autofocus type ='text' value='" + data.field_caption + "' class = 'form-control' name = 'field_caption' onchange='return trim(this)' required onkeyup='give_caption(this.value," + rowId + ")' title='Only Character and Number Allow!!' onblur=test(this,'validtxtbox')><div style='color:red' id='validtxtbox'></div></div></div></div><div class='row'><div class='col-md-12'><input type='checkbox' name = 'required' id='required'  class ='mar_left'><span class='checkmark mar_right'><label for='required' class='lbl'>Required</label></span></div></div><input type='hidden' name = 'fieldkey' value ='" + id + "'/><input type='hidden' name = 'type' value ='" + type + "'/><input type='hidden' name = 'validation_id' value = '0'/><input type='hidden' name = 'readonly' value = 'off'/><center><button type='submit'  class='btn-sm btn btn-info waves-effect waves-light newbtn hvr-glow box-shadow-3 mar_top' name='submit' id='submitform'> Submit   <span class='btn-label3'></span></button></center>";
		if (data.required == "on") {
			$('#required').prop('checked', true);
		} else {
			$('#required').prop('checked', false);
		}
	} else if (controltype == 'dropdown') {
		var predefinelists = {!!json_encode($feild_name_dd)!!};
		var fieldsdatas = {!!json_encode($fieldsdata)!!};
		var str_rep_Custom_filed_value = '';
		for (let index = 0; index < fieldsdatas.length; index++) {
			const element = fieldsdatas[index];
			if (id == element.FEILD_ID) {
				var get_feild_data = fieldsdatas[index]['field_json'];
				var dhsd = JSON.parse(get_feild_data);
				var Custom_filed_value = dhsd['Custom_Field'];
				if (Custom_filed_value != '') {
					str_rep_Custom_filed_value = Custom_filed_value.replace(/ /g, "_");
				}
				// console.log(Custom_filed_value);
			}
		}
		var predefinelist_options = '';
		for (var i = 0; i < predefinelists.length; i++) {
			var res = predefinelists[i].split(",");
			for (let kk = 0; kk < res.length; kk++) {
				var valll = res[kk];
				var single_val = valll.replace(/_/g, ' ');
				if (str_rep_Custom_filed_value == res[kk]) {
					predefinelist_options += '<option selected value=' + str_rep_Custom_filed_value + '>' + Custom_filed_value + '</option>';
				} else {
					predefinelist_options += '<option value=' + res[kk] + '>' + single_val + '</option>';
				}
			}
		}
		var dynamic_dropdwn_feilds = '<div id="Custom_div"></div>';
		var Edit_predefine_list = '<div id="edit_predefine"></div>';
		document.getElementById("control_properties").innerHTML = "<div class='row'><div class='col-md-12'><div class='form-group'><label for='projectinput3'>Control Type: Dropdown</label></div></div></div><input type='hidden' name = 'controltype' value='" + controltype + "'/><div class='row'><div class='col-md-12'><div class='form-group'><label for='projectinput3'>Field Caption</label><span style='color:red'> *</span><input autofocus type ='text' value='" + data.field_caption + "' class = 'form-control' required name = 'field_caption' onchange='return trim(this)' onkeyup='give_caption(this.value," + rowId + ")' title='Only Character and Number Allow!!' onblur=test(this,'validtxtbox')><div style='color:red' id='validtxtbox'></div></div></div></div><div class='row'><div class='col-md-12'><div class='form-group'><label for='projectinput3'>Predefinelist</label><span style='color:red'> *</span><select required class='select2 form-control'  name='predefinelist_id' id='predefinelist_id' onchange='Custom_feild(this," + id + ")' ><option value='' >--Select--</option><option value='Custom' >Custom</option>" + predefinelist_options + "</select>" + Edit_predefine_list + "</div></div></div>" + dynamic_dropdwn_feilds + "<div class='row'><div class='col-md-12'><input type='checkbox' name = 'required' id='required'  class ='mar_left'><span class='checkmark mar_right'><label for='required' class='lbl'>Required</label></span></div></div><input type='hidden' name = 'fieldkey' value ='" + id + "'/><input type='hidden' name = 'type' value ='" + type + "'/><input type='hidden' name = 'validation_id' value = '0'/><input type='hidden' name = 'readonly' value = 'off'/><center><button type='submit'  class='btn-sm btn btn-info waves-effect waves-light newbtn hvr-glow box-shadow-3 mar_top' name='submit' id='submitform'> Submit   <span class='btn-label3'></span></button></center>";
		if (data.required == "on") {
			$('#required').prop('checked', true);
		} else {
			$('#required').prop('checked', false);
		}
	} else if (controltype == 'multipleselection') {
		var predefinelists = {!!json_encode($feild_name_dd)!!};
		var fieldsdatas = {!!json_encode($fieldsdata)!!};
		var str_rep_Custom_filed_value = '';
		for (let index = 0; index < fieldsdatas.length; index++) {
			const element = fieldsdatas[index];
			if (id == element.FEILD_ID) {
				var get_feild_data = fieldsdatas[index]['field_json'];
				var dhsd = JSON.parse(get_feild_data);
				var Custom_filed_value = dhsd['Custom_Field'];
				str_rep_Custom_filed_value = Custom_filed_value.replace(/ /g, "_");
			}
		}
		var predefinelist_options = '';
		for (var i = 0; i < predefinelists.length; i++) {
			var res = predefinelists[i].split(",");
			for (let kk = 0; kk < res.length; kk++) {
				var valll = res[kk];
				var single_val = valll.replace(/_/g, ' ');
				if (str_rep_Custom_filed_value == res[kk]) {
					console.log("jiiii");
					predefinelist_options += '<option selected value=' + str_rep_Custom_filed_value + '>' + Custom_filed_value + '</option>';
				} else {
					console.log("dfssdsdds");
					predefinelist_options += '<option value=' + res[kk] + '>' + single_val + '</option>';
				}
			}
		}
		var dynamic_dropdwn_feilds = '<div id="Custom_div"></div>';
		var Edit_predefine_list = '<div id="edit_predefine"></div>';
		document.getElementById("control_properties").innerHTML = "<div class='row'><div class='col-md-12'><div class='form-group'><label for='projectinput3'>Control Type: Multiple selection</label></div></div></div><input type='hidden' name = 'controltype' value='" + controltype + "'/><div class='row'><div class='col-md-12'><div class='form-group'><label for='projectinput3'>Field Caption</label><span style='color:red'> *</span><input autofocus type ='text' value='" + data.field_caption + "' class = 'form-control' name = 'field_caption' onchange='return trim(this)'  required onkeyup='give_caption(this.value," + rowId + ")' title='Only Character and Number Allow!!' onblur=test(this,'validtxtbox')><div style='color:red' id='validtxtbox'></div></div></div></div><div class='row'><div class='col-md-12'><div class='form-group'><label for='projectinput3'>Predefinelist</label><span style='color:red'>*</span><select required class='select2 form-control'  name='predefinelist_id' id='predefinelist_id' onchange='Custom_feild(this," + id + ")'><option value='' >--Select--</option><option value='Custom' >Custom</option>" + predefinelist_options + "</select>" + Edit_predefine_list + "</div></div></div>" + dynamic_dropdwn_feilds + "<div class='row'><div class='col-md-12'><input type='checkbox' name = 'required' id='required'  class ='mar_left'><span class='checkmark mar_right'><label for='required' class='lbl'>Required</label></span></div></div><input type='hidden' name = 'fieldkey' value ='" + id + "'/><input type='hidden' name = 'type' value ='" + type + "'/><input type='hidden' name = 'validation_id' value = '0'/><input type='hidden' name = 'readonly' value = 'off'/><center><button type='submit'  class='btn-sm btn btn-info waves-effect waves-light newbtn hvr-glow box-shadow-3 mar_top' name='submit' id='submitform'> Submit   <span class='btn-label3'></span></button></center>";
		if (data.required == "on") {
			$('#required').prop('checked', true);
		} else {
			$('#required').prop('checked', false);
		}
	} else if (controltype == 'radiobutton') {
		var predefinelists = {!!json_encode($feild_name_dd)!!};
		var fieldsdatas = {!!json_encode($fieldsdata)!!};
		var str_rep_Custom_filed_value = '';
		for (let index = 0; index < fieldsdatas.length; index++) {
			const element = fieldsdatas[index];
			if (id == element.FEILD_ID) {
				var get_feild_data = fieldsdatas[index]['field_json'];
				var dhsd = JSON.parse(get_feild_data);
				var Custom_filed_value = dhsd['Custom_Field'];
				str_rep_Custom_filed_value = Custom_filed_value.replace(/ /g, "_");
			}
		}
		var predefinelist_options = '';
		for (var i = 0; i < predefinelists.length; i++) {
			var res = predefinelists[i].split(",");
			for (let kk = 0; kk < res.length; kk++) {
				var valll = res[kk];
				var single_val = valll.replace(/_/g, ' ');
				if (str_rep_Custom_filed_value == res[kk]) {
					console.log("jiiii");
					predefinelist_options += '<option selected value=' + str_rep_Custom_filed_value + '>' + Custom_filed_value + '</option>';
				} else {
					console.log("dfssdsdds");
					predefinelist_options += '<option value=' + res[kk] + '>' + single_val + '</option>';
				}
			}
		}
		var dynamic_dropdwn_feilds = '<div id="Custom_div"></div>';
		var Edit_predefine_list = '<div id="edit_predefine"></div>';
		document.getElementById("control_properties").innerHTML = "<div class='row'><div class='col-md-12'><div class='form-group'><label for='projectinput3'>Control Type: Radio</label></div></div></div><input type='hidden' name = 'controltype' value='" + controltype + "'/><div class='row'><div class='col-md-12'><div class='form-group'><label for='projectinput3'>Field Caption</label><span style='color:red'> *</span><input autofocus type ='text' value='" + data.field_caption + "' class = 'form-control' name = 'field_caption' onchange='return trim(this)' required onkeyup='give_caption(this.value," + rowId + ")' title='Only Character and Number Allow!!' onblur=test(this,'validtxtbox')><div style='color:red' id='validtxtbox'></div></div></div></div><div class='row'><div class='col-md-12'><div class='form-group'><label for='projectinput3' >Predefinelist</label><span style='color:red'> *</span><select required class='select2 form-control'  name='predefinelist_id' id='predefinelist_id' onchange='Custom_feild(this," + id + ")'><option value='' >--Select--</option><option value='Custom' >Custom</option>" + predefinelist_options + "</select>" + Edit_predefine_list + "</div></div></div>" + dynamic_dropdwn_feilds + "<div class='row'><div class='col-md-12'><input type='checkbox' name = 'required' id='required'  class ='mar_left'><span class='checkmark mar_right'><label for='required' class='lbl'>Required</label></span></div></div><input type='hidden' name = 'fieldkey' value ='" + id + "'/><input type='hidden' name = 'type' value ='" + type + "'/><input type='hidden' name = 'validation_id' value = '0'/><input type='hidden' name = 'readonly' value = 'off'/><center><button type='submit'  class='btn-sm btn btn-info waves-effect waves-light newbtn hvr-glow box-shadow-3 mar_top' name='submit' id='submitform'> Submit   <span class='btn-label3'></span></button></center>";
		if (data.required == "on") {
			$('#required').prop('checked', true);
		} else {
			$('#required').prop('checked', false);
		}
	} else if (controltype == 'childinput') {
		document.getElementById("control_properties").innerHTML = "<div class='row'><div class='col-md-12'><div class='form-group'><label for='projectinput3'>Control Type: " + controltype + "</label></div></div></div><input type='hidden' name = 'controltype' value='" + controltype + "'/><div class='row'><div class='col-md-12'><div class='form-group'><label for='projectinput3'>Field Caption</label><span style='color:red'> *</span><input autofocus type ='text' name='field_caption' required value='" + data.field_caption + "' onchange='return trim(this)' class = 'form-control'  title='Only Character and Number Allow!!' onblur=test(this,'validtxtbox') onkeyup='give_caption(this.value," + rowId + ")'><div style='color:red' id='validtxtbox'></div></div></div></div><div class='row'><div class='col-md-12'><div class='form-group'><label for='projectinput3'>Placeholder</label><input type ='text' title='Only Character and Number Allow!!' class = 'form-control' onblur=test(this,'validplaceholder') name = 'placeholder' onchange='return trim(this)' value = '" + data.placeholder + "' onkeyup='give_placeholder(this.value," + rowId + ")'/><div style='color:red' id='validplaceholder'></div></div></div></div><div class='row'><div class='col-md-12'><div class='form-group'><label for='projectinput3'>Field Length</label><span style='color:red'> *</span><input type ='text' required class = 'form-control' onchange='return trim(this)' name = 'field_length' id='field_length' value = '" + data.field_length + "'></div></div></div><div class='row'><div class='col-md-12'><div class='form-group'><label for='projectinput3'>Default Value</label><input type ='text' onchange='return trim(this)' class = 'form-control' name = 'default_value'  id = 'default_value' value = '" + data.default_value + "' ></div></div></div><div class='row'><div class='col-md-12'><div class='form-group'><label for='projectinput3'>Validation</label><span style='color:red'> *</span><select data-placeholder='Choose a Country' class='select2 form-control'  name='validation_id' required><option value='' >--Select--</option>" + voptions + "</select></div></div></div><div class='row'><div class='col-md-12'><input type='checkbox' name = 'required' id='required'  class ='mar_left'><span class='checkmark mar_right'><label for='required' class='lbl'>Required</label></span></div></div><input type='hidden' name = 'fieldkey' value ='" + id + "'/><input type='hidden' name = 'type' value ='" + type + "'/><center><button type='submit'  class='btn-sm btn btn-info waves-effect waves-light newbtn hvr-glow box-shadow-3 mar_top' name='submit' id='submitform'> Submit  <span class='btn-label3'></span></button></center>";
		if (data.required == "on") {
			$('#required').prop('checked', true);
		} else {
			$('#required').prop('checked', false);
		}
		if (data.readonly == "on") {
			$('#readonly').prop('checked', true);
		} else {
			$('#readonly').prop('checked', false);
		}
	} else if (controltype == 'heading') {
		document.getElementById("control_properties").innerHTML = "<div class='row'><div class='col-md-12'><div class='form-group'><label for='projectinput3'>Control Type: " + controltype + "</label></div></div></div><input type='hidden' name = 'controltype' value='" + controltype + "'/><div class='row'><div class='col-md-12'><div class='form-group'><label for='projectinput3'>Heading</label><span style='color:red'> *</span><input autofocus type ='text' required value='" + data.field_caption + "' class = 'form-control' name = 'field_caption' onchange='return trim(this)' onkeyup='give_heading(this.value," + rowId + ")'/></div></div></div><input type='hidden' name = 'fieldkey' value = '" + id + "'/><input type='hidden' name = 'type' value ='" + type + "'/><input type='hidden' name = 'validation_id' value = '0'/><input type='hidden' name = 'readonly' value = 'off'/><center><button type='submit' class='btn-sm btn btn-info waves-effect waves-light newbtn hvr-glow box-shadow-3 mar_top' name='submit' id='submitform'> Submit   <span class='btn-label3'></span>  </button></center>";
	} else if (controltype == 'checkbox') {
		var predefinelists = {!!json_encode($feild_name_dd)!!};
		var fieldsdatas = {!!json_encode($fieldsdata)!!};
		var str_rep_Custom_filed_value = '';
		for (let index = 0; index < fieldsdatas.length; index++) {
			const element = fieldsdatas[index];
			if (id == element.FEILD_ID) {
				var get_feild_data = fieldsdatas[index]['field_json'];
				var dhsd = JSON.parse(get_feild_data);
				var Custom_filed_value = dhsd['Custom_Field'];
				str_rep_Custom_filed_value = Custom_filed_value.replace(/ /g, "_");
			}
		}
		var predefinelist_options = '';
		for (var i = 0; i < predefinelists.length; i++) {
			var res = predefinelists[i].split(",");
			for (let kk = 0; kk < res.length; kk++) {
				var valll = res[kk];
				var single_val = valll.replace(/_/g, ' ');
				if (str_rep_Custom_filed_value == res[kk]) {
					console.log("jiiii");
					predefinelist_options += '<option selected value=' + str_rep_Custom_filed_value + '>' + Custom_filed_value + '</option>';
				} else {
					console.log("dfssdsdds");
					predefinelist_options += '<option value=' + res[kk] + '>' + single_val + '</option>';
				}
			}
		}
		var dynamic_dropdwn_feilds = '<div id="Custom_div"></div>';
		var Edit_predefine_list = '<div id="edit_predefine"></div>';
		document.getElementById("control_properties").innerHTML = "<div class='row'><div class='col-md-12'><div class='form-group'><label for='projectinput3'>Control Type: CheckBox</label></div></div></div><input type='hidden' name = 'controltype' value='" + controltype + "'/><div class='row'><div class='col-md-12'><div class='form-group'><label for='projectinput3'>Field Caption</label><span style='color:red'> *</span><input autofocus type ='text' value='" + data.field_caption + "' class = 'form-control' name = 'field_caption' onchange='return trim(this)' required onkeyup='give_caption(this.value," + rowId + ")' title='Only Character and Number Allow!!' onblur=test(this,'validtxtbox')><div style='color:red' id='validtxtbox'></div></div></div></div><div class='row'><div class='col-md-12'><div class='form-group'><label for='projectinput3' >Predefinelist</label><span style='color:red'> *</span><select required class='select2 form-control'  name='predefinelist_id' id='predefinelist_id' onchange='Custom_feild(this," + id + ")'><option value='' >--Select--</option><option value='Custom' >Custom</option>" + predefinelist_options + "</select>" + Edit_predefine_list + "</div></div></div>" + dynamic_dropdwn_feilds + "<div class='row'><div class='col-md-12'><input type='checkbox' name = 'required' id='required'  class ='mar_left'><span class='checkmark mar_right'><label for='required' class='lbl'>Required</label></span></div></div><input type='hidden' name = 'fieldkey' value ='" + id + "'/><input type='hidden' name = 'type' value ='" + type + "'/><input type='hidden' name = 'validation_id' value = '0'/><input type='hidden' name = 'readonly' value = 'off'/><center><button type='submit'  class='btn-sm btn btn-info waves-effect waves-light newbtn hvr-glow box-shadow-3 mar_top' name='submit' id='submitform'> Submit   <span class='btn-label3'></span></button></center>";
		if (data.required == "on") {
			$('#required').prop('checked', true);
		} else {
			$('#required').prop('checked', false);
		}
	} else if (controltype == 'fileupload') {
		document.getElementById("control_properties").innerHTML = "<div class='row'><div class='col-md-12'><div class='form-group'><label for='projectinput3'>Control Type: " + controltype + "</label></div></div></div><input type='hidden' name = 'controltype' value='" + controltype + "'/><div class='row'><div class='col-md-12'><div class='form-group'><label for='projectinput3'>Field Caption</label><span style='color:red'> *</span><input autofocus type ='text' value='" + data.field_caption + "' class = 'form-control' name = 'field_caption' onchange='return trim(this)' required onkeyup='give_caption(this.value," + rowId + ")' title='Only Character and Number Allow!!' onblur=test(this,'validtxtbox')><div style='color:red' id='validtxtbox'></div></div></div></div><br/><div class='row'><div class='col-md-12'><input type='checkbox' name = 'required' id='required'  class ='mar_left'><span class='checkmark mar_right'><label for='required' class='lbl'>Required</label></span></div></div><input type='hidden' name = 'readonly' value = 'off'/><input type='hidden' name = 'fieldkey' value ='" + id + "'/><input type='hidden' name = 'type' value ='" + type + "'/><center><button type='submit'  class='btn-sm btn btn-info waves-effect waves-light newbtn hvr-glow box-shadow-3 mar_top' name='submit' id='submitform'> Submit   <span class='btn-label3'></span></button></center>";
	} else if (controltype == 'ratings') {
		document.getElementById("control_properties").innerHTML = "<div class='row'><div class='col-md-12'><div class='form-group'><label for='projectinput3'>Control Type: " + controltype + "</label></div></div></div><input type='hidden' name = 'controltype' value='" + controltype + "'/><div class='row'><div class='col-md-12'><div class='form-group'><label for='projectinput3'>Field Caption</label><span style='color:red'> *</span><input  type ='text' name='field_caption' required value='" + data.field_caption + "' onchange='return trim(this)' class = 'form-control'  title='Only Character and Number Allow!!' onblur=test(this,'validtxtbox') onkeyup='give_caption(this.value," + rowId + ")'></div></div></div><div class='row'><div class='col-md-12'><input type='checkbox' name = 'required' id='required'  class ='mar_left'><span class='checkmark mar_right'><label for='required' class='lbl'>Required</label></span></div></div><input type='hidden' name = 'readonly' value = 'off'/><input type='hidden' name = 'fieldkey' value ='" + id + "'/><input type='hidden' name = 'type' value ='" + type + "'/><center><button type='submit'  class='btn-sm btn btn-info waves-effect waves-light newbtn hvr-glow box-shadow-3 mar_top' name='submit' id='submitform'> Submit  <span class='btn-label3'></span></button></center>";
	}
}
function btnclick() {
	var div = $("<div />");
	div.html(GetDynamicTextBox(""));
	$("#TextBoxContainer").append(div);
}

function get_values() {
	var values = "";
	$("input[name=DynamicTextBox]").each(function () {
		values += $(this).val() + "\n";
	});
	// alert(values);
}
$(function () {
	$("body").on("click", ".remove", function () {
		$(this).closest("div").remove();
	});
});
function GetDynamicTextBox(value) {
	return '<input name = "DynamicTextBox[]" type="text" value = "' + value + '" />&nbsp;' + '<input type="button" value="Remove" class="remove" />'
}
// <!--validate caption name-->
function test(self, id) {
	var val = self.value;
	if (/^[ a-zA-Z0-9 -_&@#$%*'^.?!-]*$/.test(val) == false) {
		document.getElementById(id).innerHTML = "Invalid Name..!!";
		$("#submitform").attr("disabled", "disabled");
		return self.focus();
		//return false;
	} else if (val.length >= 500) {
		document.getElementById(id).innerHTML = "Length should be less than 500..!!";
		$("#submitform").attr("disabled", true);
		return self.focus();
		//return false;
	} else {
		document.getElementById(id).innerHTML = "";
		$('#submitform').removeAttr('disabled');
	}
}
</script>
<!--to get fields count-->
<script>
    function autoids() {
	var data;
	formid = '{{$formdata->FORMID}}';
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	var base_url = {!!json_encode(url('/'))!!};
	$.ajax({
		url: base_url + '/fieldautoids',
		type: 'post',
		async: false,
		data: {
			formid: formid,
			_token: CSRF_TOKEN
		},
		success: function (resp) {
			if (resp == '') {
				data = 1;
			} else {
				data = resp;
			}
		}
	});
	return data;
}
</script>
<!-- form submit -->
<script>
    $('#propertiesForm').submit(function (e) {
	e.preventDefault();
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	var formData = $(this).serialize(); //console.log(formData);return false;
	var base_url = {!!json_encode(url('/'))!!};
	$.ajax({
		type: 'POST',
		url: base_url + '/hrisfield',
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		data: formData,
		success: function (data) {
			alert('Field Created/Updated Successfully..!!');
			// location.reload();
			// swal({ title: "", text:"Field Created/Updated Successfully..!!", type: "success" }, function(){ location.reload();
			// });
		}
	});
});
</script>

<!--- delete fields in form -->
<script>
    function deletefield(id) {
	formid = '{{$formdata->FORMID}}';
	var r = confirm("Are you sure?You won't be able to revert this!");
	if (r == true) {
		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
		var base_url = {!!json_encode(url('/'))!!};
		$.ajax({
			url: base_url + '/hrisfieldsdelete',
			type: 'post',
			data: {
				formid: formid,
				id: id,
				_token: CSRF_TOKEN
			},
			success: function (data) {
				alert('Field has been deleted')
				location.reload();
				// swal({ title: "Deleted", text:"Field has been deleted", type: "success" }, function(){ location.reload(); });
				// $("#formfields1").html(data);
				// document.getElementById("control_properties").innerHTML = "";
			}
		});
	}
}
$(".require_id").css("color", "red");
</script>
<!-- change field sequence  -->
<script src="{{ asset('/public/assets/js/RowSorter.js') }}"></script>
<script src="https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.min.js"></script>
<script>
    $("#form-table").rowSorter({
	onDrop: function (tbody, row, newindex, oldIndex) {
		var oldIndex = oldIndex + 1;
		var newindex = newindex + 1;
		var one = oldIndex;
		var two = newindex;
		var base_url = {!!json_encode(url('/'))!!};
		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
		formid = '{{$formdata->FORMID}}';
		$.ajax({
			type: 'post',
			data: {
				'one': one,
				'two': two,
				'form_id': formid,
				_token: CSRF_TOKEN,
			},
			url: base_url + '/hrisupdatesequences',
			success: function (data) {}
		})
	}
});
</script>
@endsection
