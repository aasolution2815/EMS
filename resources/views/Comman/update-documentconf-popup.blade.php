<form action=""  id="update_form">
    <div id="form_patch">
        <div class="row">
            @php
                $isreruired = '';
                $display = 'none';
                // print_r($DOCDETAILS);
            @endphp
            @if ($type == 'update')
            @php
                $isreruired = 'required';
            @endphp
            <div class="col-md-4 col-sm-4 col-xs-12 padding_10">
                <div>
                    <label for="name" class="input_label_light">Document Name</label>
                    <div class="inputWithIcon">
                        <input type="text" class="input_text margin_top_0" id="update_doc_name"
                            placeholder="Document name" {{$isreruired}} data-parsley-trigger="blur"
                            data-parsley-required-message="Required" value="{{$DOCDETAILS[0]->DOCUMENT_SET_NAME}}"   data-parsley-errors-container="#updatemodname">
                        <i class="feather icon-user inside_input_icon"></i>
                        <span class="form-error error_label" id="updatemodname">
                            <i class="feather icon-x error_inputcolor"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12 padding_10">
                <div>
                    <label for="name" class="input_label_light">Document Description</label>
                    <div class="inputWithIcon">
                        <textarea id="updatew3review" name="w3review" rows="4" cols="50" name="description"
                            placeholder="Document Description"  class="textarea_p">{{$DOCDETAILS[0]->DOCUMENT_DESCRIPTION}}</textarea>
                    </div>
                </div>
            </div>
            @endif

            <div class="col-md-4 col-sm-4 col-xs-12 padding_10">
                <div>
                    <label for="name" class="dropdown_label_light">Parrent Document</label>
                    <div>
                        <select class="js-example-basic-single" name="updateisparrent_doc" id="updateisparrent_doc"
                            required="" onchange="isparrentdocumentupdate(this)" data-parsley-trigger="blur"
                            data-parsley-required-message="Required" data-parsley-errors-container="#catid">
                            <option value="No"
                            @if ($DOCDETAILS[0]->ISPARENT_DOCUMENT == 'No')
                            {{'selected'}}
                            @endif
                            >No</option>
                            <option value="Yes"
                            @if ($DOCDETAILS[0]->ISPARENT_DOCUMENT == 'Yes')
                                {{'selected'}}
                            @endif
                            >Yes</option>
                        </select> <span class="form-error error_label" id="catid">
                            <i class="feather icon-x error_inputcolor"></i></span>
                    </div>
                </div>
            </div>
            @php
                if($DOCDETAILS[0]->ISPARENT_DOCUMENT == 'Yes'){
                    $display = 'block';
                }
            @endphp
            <div class="col-md-12 col-sm-12 col-xs-12 padding_10">
                <div id="update_allrcrods" style="display: {{$display}}">
                    <div id="update_all_child_doc">
                        <label for="name" class="input_label_light">Child Document</label>
                        @if (count($CHILDDETAILS) > 0)
                        @foreach ($CHILDDETAILS as $childs)
                        <div class="row" id="{{ $childs->CHILD_DOC_ID}}">
                            <div class="col-md-7 col-sm-7 col-xs-12 padding_10">
                                <div>
                                    <div class="inputWithIcon">
                                        <input type="text" class="input_text margin_top_0" id="updatechilddocname_{{ $childs->CHILD_DOC_ID}}"
                                            placeholder="Document name" name="child_doc" data-parsley-trigger="blur" value="{{$childs->SUB_DOCUMENT_NAME}}"
                                            data-parsley-required-message="Required"
                                            data-parsley-errors-container="#updatechildfileerror_{{ $childs->CHILD_DOC_ID}}"> <i
                                            class="feather icon-user inside_input_icon"></i>
                                        <span class="form-error error_label" id="updatechildfileerror_{{ $childs->CHILD_DOC_ID}}">
                                            <i class="feather icon-x error_inputcolor"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12 padding_10">
                                <div>
                                    <label for="name" class="input_label_light">Document Description</label>
                                    <div class="inputWithIcon">
                                        <textarea id="updatechilddiscription_{{ $childs->CHILD_DOC_ID}}" name="w3review" rows="4" cols="50"
                                            placeholder="Document Description" name="description"
                                            class="textarea_p">{{$childs->SUB_DOCUMENT_DESCRIPTION}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 col-sm-1 col-xs-12 padding_10">
                                <div>
                                    <div id="textbox" class="">
                                        <p class="alignright">
                                            <button class="cancel_btnn btnn" onclick="removefeild(event, '{{ $childs->CHILD_DOC_ID}}')">Cancel</button>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="row" id="0">
                            <div class="col-md-7 col-sm-7 col-xs-12 padding_10">
                                <div>
                                    <div class="inputWithIcon">
                                        <input type="text" class="input_text margin_top_0" id="updatechilddocname_0" required
                                            placeholder="Document name" name="child_doc" data-parsley-trigger="blur"
                                            data-parsley-required-message="Required"
                                            data-parsley-errors-container="#updatechildfileerror_0"> <i
                                            class="feather icon-user inside_input_icon"></i>
                                        <span class="form-error error_label" id="updatechildfileerror_0">
                                            <i class="feather icon-x error_inputcolor"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12 padding_10">
                                <div>
                                    <label for="name" class="input_label_light">Document Description</label>
                                    <div class="inputWithIcon">
                                        <textarea id="updatechilddiscription_0" name="w3review" rows="4" cols="50"
                                            placeholder="Document Description" name="description"
                                            class="textarea_p"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 col-sm-1 col-xs-12 padding_10">
                                <div>
                                    <div id="textbox" class="">
                                        <p class="alignright">
                                            <button class="cancel_btnn btnn" onclick="removefeild(event, '0')">Cancel</button>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="row" id="0">
                            <div class="col-md-7 col-sm-7 col-xs-12 padding_10">
                                <div>
                                    <div class="inputWithIcon">
                                        <input type="text" class="input_text margin_top_0" id="updatechilddocname_0"
                                            placeholder="Document name" name="child_doc" data-parsley-trigger="blur"
                                            data-parsley-required-message="Required"
                                            data-parsley-errors-container="#updatechildfileerror_0"> <i
                                            class="feather icon-user inside_input_icon"></i>
                                        <span class="form-error error_label" id="updatechildfileerror_0">
                                            <i class="feather icon-x error_inputcolor"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12 padding_10">
                                <div>
                                    <label for="name" class="input_label_light">Document Description</label>
                                    <div class="inputWithIcon">
                                        <textarea id="updatechilddiscription_0" name="w3review" rows="4" cols="50"
                                            placeholder="Document Description" name="description"
                                            class="textarea_p"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 col-sm-1 col-xs-12 padding_10">
                                <div>
                                    <div id="textbox" class="">
                                        <p class="alignright">
                                            <button class="cancel_btnn btnn" onclick="removefeild(event, '0')">Cancel</button>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        {{-- --}}
                    </div>
                    <div>
                        <div id="textbox" class="">
                            <p class="alignright">
                                <button class="primary_btnn btnn"
                                    onclick="Addmorefilesupdate(event)">Add</button>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div id="textbox" class="">
            <p class="alignright">
                <button class="primary_btnn btnn" onclick="updateconfigration(event, '{{$ID}}')">Submit</button>
            </p>
        </div>
    </div>
</form>
<div style="clear: both;"></div>
<script>
    $('.js-example-basic-single').select2();
</script>
