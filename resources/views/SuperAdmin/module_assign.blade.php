@extends('Layout.app')
@section('content')
<style></style>
<div>
    <div class="h1_weight_700 shadow_patch">
        <div id="textbox" class="">
            <p class="alignleft bold_heavy bold_font_heading" id="add_client">Assign Module</p>
            <p class="alignright">
                <a href="javascript:history.back()"><span class="btn_with_icon" style="margin-right: 15px;"><i
                            class="feather icon-corner-up-left  small_icon_left"></i>
                        Back </span></a>
                <label class="container-checkbox">All Module and Rights
                    <input type="checkbox" name="getallcategory" id="allcategory">
                    <span class="checkmark"></span>
                </label>
            </p>
        </div>
        <div style="clear: both;"></div>
    </div>
    <?php
    for ($mk=0; $mk < count($CATEGORYDETAILS); $mk++) {
        ?>
    <ul id="accordion{{$mk}}" class="static-menu margin-top_10 only_shadow">
        <li>
            <div class="link"><label
                    class="font_size_20 margin-bottom-0">{{$CATEGORYDETAILS[$mk]->CATEGORYNAME}}</label>
                <label class="container-checkbox" style="float: right;margin-right: 25px;         margin-top: 5px;">All
                    Rights
                    <input type="checkbox" name="allcategoryrights_{{$CATEGORYDETAILS[$mk]->CATEGORY_ID}}"
                        id="allcategoryrights_{{$CATEGORYDETAILS[$mk]->CATEGORY_ID}}"
                        value="{{$CATEGORYDETAILS[$mk]->CATEGORY_ID}}"
                        onclick="sellectallrights('{{$CATEGORYDETAILS[$mk]->CATEGORY_ID}}', this, '{{count($DETAILS[$CATEGORYDETAILS[$mk]->CATEGORY_ID])}}')">
                    <span class="checkmark"></span>
                </label>
                <label class="container-checkbox" style="float: right;margin-right: 25px;         margin-top: 5px;">All
                    Modules
                    <input type="checkbox" name="allcategory" id="allcategory_{{$CATEGORYDETAILS[$mk]->CATEGORY_ID}}"
                        value="{{$CATEGORYDETAILS[$mk]->CATEGORY_ID}}"
                        onclick="sellectallmodules('{{$CATEGORYDETAILS[$mk]->CATEGORY_ID}}', this)">
                    <span class="checkmark"></span>
                </label>
            </div>
            <?php
                // echo "<pre>";
                // print_r($DETAILS[$CATEGORYDETAILS[$mk]->CATEGORY_ID]);
                ?>
            <ul class="sub-menu">
                <div style="background: white;padding: 10px;">
                    <?php
                        for ($mj=0; $mj < count($DETAILS[$CATEGORYDETAILS[$mk]->CATEGORY_ID]); $mj++) {
                            $MODID = $DETAILS[$CATEGORYDETAILS[$mk]->CATEGORY_ID][$mj]->MODULEID;
                            if (array_key_exists($MODID,$ALREADYASSGINEDMODULES)) {
                                $MODULECHECKEDSTATUS = 'checked';

                                $STATUS1 = $ALREADYASSGINEDMODULES[$MODID]['ADD'];
                                if ($STATUS1 == 'Yes') {
                                    $ADDSTATUS = 'checked';
                                } else {
                                    $ADDSTATUS = '';
                                }

                                $STATUS2 = $ALREADYASSGINEDMODULES[$MODID]['VIEW'];
                                if ($STATUS2 == 'Yes') {
                                    $VIEWSTATUS = 'checked';
                                } else {
                                    $VIEWSTATUS = '';
                                }
                                $STATUS3 = $ALREADYASSGINEDMODULES[$MODID]['WRITE'];
                                if ($STATUS3 == 'Yes') {
                                    $WRITESTATUS = 'checked';
                                } else {
                                    $WRITESTATUS = '';
                                }
                                $STATUS4 = $ALREADYASSGINEDMODULES[$MODID]['DELETE'];
                                if ($STATUS4 == 'Yes') {
                                    $DELETESTATUS = 'checked';
                                } else {
                                    $DELETESTATUS = '';
                                }
                                $STATUS5 = $ALREADYASSGINEDMODULES[$MODID]['EXPORT'];
                                if ($STATUS5 == 'Yes') {
                                    $EXPORTSTATUS = 'checked';
                                } else {
                                    $EXPORTSTATUS = '';
                                };
                                $STATUS6 = $ALREADYASSGINEDMODULES[$MODID]['IMPORT'];
                                if ($STATUS6 == 'Yes') {
                                    $IMPORTSATUS = 'checked';
                                } else {
                                    $IMPORTSATUS = '';
                                };
                                $STATUS7 = $ALREADYASSGINEDMODULES[$MODID]['UPDATEIMPORT'];
                                if ($STATUS7 == 'Yes') {
                                    $UPDATEIMPORTSATUS = 'checked';
                                } else {
                                    $UPDATEIMPORTSATUS = '';
                                };
                                if ($STATUS1 == 'Yes' && $STATUS2 == 'Yes' && $STATUS3 == 'Yes' && $STATUS4 == 'Yes' && $STATUS5 == 'Yes' && $STATUS6 == 'Yes' && $STATUS7 == 'Yes') {
                                    $FINALRIGHTSTATUS = 'checked';
                                } else {
                                    $FINALRIGHTSTATUS = '';
                                }

                                // echo "Key exists!";
                            } else {
                                $MODULECHECKEDSTATUS = '';
                                $IMPORTSATUS = '';
                                $WRITESTATUS = '';
                                $DELETESTATUS = '';
                                $ADDSTATUS = '';
                                $EXPORTSTATUS = '';
                                $VIEWSTATUS = '';
                                $FINALRIGHTSTATUS = '';
                                $UPDATEIMPORTSATUS = '';

                                // echo "Key does not exist!";
                            }
                        ?>
                    <div class="h1_weight_700 shadow_patch margin-top_10">
                        <div id="textbox" class="">
                            <p class="alignleft bold_font_heading" id="add_client">
                                <label
                                    class="font_size_20">{{$DETAILS[$CATEGORYDETAILS[$mk]->CATEGORY_ID][$mj]->MODULENAME}}</label>
                                <br>
                                <label class="container-checkbox font-size_16">Add
                                    <input type="checkbox" value="Yes" {{$ADDSTATUS}}
                                        class="rightscalss{{$CATEGORYDETAILS[$mk]->CATEGORY_ID}}"
                                        name="rights_{{$CATEGORYDETAILS[$mk]->CATEGORY_ID}}_{{$mj}}"
                                        id="add_{{$DETAILS[$CATEGORYDETAILS[$mk]->CATEGORY_ID][$mj]->MODULEID}}"
                                        onclick="selectrightsfunction('{{$CATEGORYDETAILS[$mk]->CATEGORY_ID}}', '{{$mj}}')">
                                    <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox font-size_16">View
                                    <input type="checkbox" value="Yes" {{$VIEWSTATUS}}
                                        class="rightscalss{{$CATEGORYDETAILS[$mk]->CATEGORY_ID}}"
                                        name="rights_{{$CATEGORYDETAILS[$mk]->CATEGORY_ID}}_{{$mj}}"
                                        id="view_{{$DETAILS[$CATEGORYDETAILS[$mk]->CATEGORY_ID][$mj]->MODULEID}}"
                                        onclick="selectrightsfunction('{{$CATEGORYDETAILS[$mk]->CATEGORY_ID}}', '{{$mj}}')">
                                    <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox font-size_16">Change
                                    <input type="checkbox" value="Yes" {{$WRITESTATUS}}
                                        class="rightscalss{{$CATEGORYDETAILS[$mk]->CATEGORY_ID}}"
                                        name="rights_{{$CATEGORYDETAILS[$mk]->CATEGORY_ID}}_{{$mj}}"
                                        id="writes_{{$DETAILS[$CATEGORYDETAILS[$mk]->CATEGORY_ID][$mj]->MODULEID}}"
                                        onclick="selectrightsfunction('{{$CATEGORYDETAILS[$mk]->CATEGORY_ID}}', '{{$mj}}')">
                                    <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox font-size_16">Delete
                                    <input type="checkbox" value="Yes" {{$DELETESTATUS}}
                                        class="rightscalss{{$CATEGORYDETAILS[$mk]->CATEGORY_ID}}"
                                        name="rights_{{$CATEGORYDETAILS[$mk]->CATEGORY_ID}}_{{$mj}}"
                                        id="delete_{{$DETAILS[$CATEGORYDETAILS[$mk]->CATEGORY_ID][$mj]->MODULEID}}"
                                        onclick="selectrightsfunction('{{$CATEGORYDETAILS[$mk]->CATEGORY_ID}}', '{{$mj}}')">
                                    <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox font-size_16">Import
                                    <input type="checkbox" class="rightscalss{{$CATEGORYDETAILS[$mk]->CATEGORY_ID}}" {{$IMPORTSATUS}}
                                        name="rights_{{$CATEGORYDETAILS[$mk]->CATEGORY_ID}}_{{$mj}}" value="Yes"
                                        id="import_{{$DETAILS[$CATEGORYDETAILS[$mk]->CATEGORY_ID][$mj]->MODULEID}}"
                                        onclick="selectrightsfunction('{{$CATEGORYDETAILS[$mk]->CATEGORY_ID}}', '{{$mj}}')">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="container-checkbox font-size_16">Update Import
                                    <input type="checkbox" class="rightscalss{{$CATEGORYDETAILS[$mk]->CATEGORY_ID}}" {{$UPDATEIMPORTSATUS}}
                                        name="rights_{{$CATEGORYDETAILS[$mk]->CATEGORY_ID}}_{{$mj}}" value="Yes"
                                        id="updateimport_{{$DETAILS[$CATEGORYDETAILS[$mk]->CATEGORY_ID][$mj]->MODULEID}}"
                                        onclick="selectrightsfunction('{{$CATEGORYDETAILS[$mk]->CATEGORY_ID}}', '{{$mj}}')">
                                    <span class="checkmark"></span>
                                </label>



                                <label class="container-checkbox font-size_16">Export
                                    <input type="checkbox" value="Yes" {{$EXPORTSTATUS}}
                                        class="rightscalss{{$CATEGORYDETAILS[$mk]->CATEGORY_ID}}"
                                        name="rights_{{$CATEGORYDETAILS[$mk]->CATEGORY_ID}}_{{$mj}}"
                                        id="export_{{$DETAILS[$CATEGORYDETAILS[$mk]->CATEGORY_ID][$mj]->MODULEID}}"
                                        onclick="selectrightsfunction('{{$CATEGORYDETAILS[$mk]->CATEGORY_ID}}', '{{$mj}}')">
                                    <span class="checkmark"></span>
                                </label>

                            </p>

                            <p class="alignright">
                                <label class="container-checkbox">All Rights
                                    <input type="checkbox"
                                        name="allrigths_{{$CATEGORYDETAILS[$mk]->CATEGORY_ID}}_{{$mj}}"
                                        onclick="selctallrightsfunction('{{$CATEGORYDETAILS[$mk]->CATEGORY_ID}}', '{{$mj}}')" {{$FINALRIGHTSTATUS}}
                                        id="allrigths_{{$CATEGORYDETAILS[$mk]->CATEGORY_ID}}_{{$mj}}">
                                    <span class="checkmark"></span>
                                </label>
                            </p>
                            <p class="alignright">
                                <label class="container-checkbox">Module
                                    <input type="checkbox"
                                        value="{{$DETAILS[$CATEGORYDETAILS[$mk]->CATEGORY_ID][$mj]->MODULEID}}" {{$MODULECHECKEDSTATUS}}
                                        name="allmodules_{{$CATEGORYDETAILS[$mk]->CATEGORY_ID}}"
                                        id="allmodules_{{$CATEGORYDETAILS[$mk]->CATEGORY_ID}}"
                                        onclick="selectmodules('{{$CATEGORYDETAILS[$mk]->CATEGORY_ID}}')">
                                    <span class="checkmark"></span>
                                </label>
                            </p>
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                    <?php
                        }
                        ?>
                </div>
            </ul>
        </li>
    </ul>
    <?php
    }
    ?>
    <div style="clear: both;"></div><br>
    <div id="textbox" class="">
        <p class="alignright">
            <button class="primary_btnn btnn" onclick="AssginModules(event)">Assgin</button>
        </p>
    </div>
</div>
@endsection
@section('addscriptscontent')
<script>
    $(".static-menu div.link").append("<i class='fa fa-chevron-down'></i>");
    $(function() {
        var Accordion = function(el, multiple) {
            this.el = el || {};
            this.multiple = multiple || false;

            var links = this.el.find('.link');
            links.on('click', {
                el: this.el,
                multiple: this.multiple
            }, this.dropdown);
        };

        Accordion.prototype.dropdown = function(e) {
            var $el = e.data.el;
            $this = $(this),
                $next = $this.next();

            $next.slideToggle();
            $this.parent().toggleClass('open');

            if (!e.data.multiple) {
                $el.find('.sub-menu').not($next).slideUp().parent().removeClass('open');
            }
        };
        var count = "{{count($CATEGORYDETAILS)}}";
        for (let index = 0; index < count ; index++) {
            var id = "#accordion" + index;
            var accordion = new Accordion($(id), false);
        }

        // var accordion = new Accordion($('#accordion0'), false);
        // var accordion1 = new Accordion($('#accordion1'), false);
        // var accordion2 = new Accordion($('#accordion2'), false);
        // var accordion3 = new Accordion($('#accordion3'), false);
    });
</script>
<script>
    $("#allcategory").click(function(){
        // alert('dfdf');
    $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
});
$("input[type=checkbox]").click(function() {

    if ($('input[type=checkbox]:checked').length == ($("input[type=checkbox]").length)) {
        $('#allcategory').prop('checked',true);

    } else if ($('input[type=checkbox]:checked').length == ($("input[type=checkbox]").length)-1) {
        $('#allcategory').prop('checked',true);
    } else {
        $("#allcategory").prop("checked", false);
    }
});
</script>
<script>
    $(document).ready(function() {
        var ALLCATEGOREIES = [];
        var jsonarry = '{{ json_encode($DETAILS) }}';
        var app = @json($DETAILS);
        $('input[name="allcategory"]').each(function() {
            ALLCATEGOREIES.push(this.value);
        });
        for (let index5 = 0; index5 < ALLCATEGOREIES.length; index5++) {
            const element5 = ALLCATEGOREIES[index5];
            var GETALLCHECKBOX = $('input[name="allmodules_'+element5+'"]').length
            var GETALLCHECKEDCHECKBOX = $('input[name="allmodules_'+element5+'"]:checked').length
            if (GETALLCHECKBOX == GETALLCHECKEDCHECKBOX) {
                $('#allcategory_'+element5).prop('checked',true);
            }
            var GETCHECKEDCOUNT = 0;
            for (let index6 = 0; index6 < app[element5].length; index6++) {
                var isCHECKED = $('#allrigths_'+element5+'_'+index6).is(':checked');
                if (isCHECKED) {
                    GETCHECKEDCOUNT++;
                }
            }
            if (app[element5].length == GETCHECKEDCOUNT) {
                $('#allcategoryrights_'+element5).prop('checked',true);
            }
        }
        if ($('input[type=checkbox]:checked').length == ($("input[type=checkbox]").length)-1) {
            $('#allcategory').prop('checked',true);
        } else {
            $("#allcategory").prop("checked", false);
        }
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
</script>
<script>
    var base_url = {!!json_encode(url('/')) !!};
    function AssginModules(e) {
        var ALLCHECKEDCATEGOREIES = [];
        var GETCATIEGORIS = [];
        var MODULESWITHRIGHTSARRY = [];
        var GETMODULES = [];
        $('input[name="allcategory"]').each(function() {
            ALLCHECKEDCATEGOREIES.push(this.value);
        });
        var obj = {};
        for (let index = 0; index < ALLCHECKEDCATEGOREIES.length; index++) {
            const element = ALLCHECKEDCATEGOREIES[index];
            var AllModules = [];

            // allmodules_3
            $('input[name="allmodules_'+element+'"]:checked').each(function() {
                AllModules.push(this.value)
                // console.log(this.value);
            });
            var ModulesOBJ = {};
            var MODULEARRY = [];
            for (let index1 = 0; index1 < AllModules.length; index1++) {
                var RightsAARY = {};

                const element1 = AllModules[index1];
                var importdata = $("#import_"+element1).is(':checked');
                if (importdata) {
                    RightsAARY['Import'] = 'Yes';
                } else {
                    RightsAARY['Import'] = 'No';
                }
                var updateimportdata = $("#updateimport_"+element1).is(':checked');
                if (updateimportdata) {
                    RightsAARY['UpdateImport'] = 'Yes';
                } else {
                    RightsAARY['UpdateImport'] = 'No';
                }

                var writedata = $("#writes_"+element1).is(':checked');
                if (writedata) {
                    RightsAARY['Write'] = 'Yes';
                } else {
                    RightsAARY['Write'] = 'No';
                }
                var deletedata = $("#delete_"+element1).is(':checked');
                if (deletedata) {
                    RightsAARY['Delete'] = 'Yes';
                } else {
                    RightsAARY['Delete'] = 'No';
                }
                var adddata = $("#add_"+element1).is(':checked');
                if (adddata) {
                    RightsAARY['Add'] = 'Yes';
                } else {
                    RightsAARY['Add'] = 'No';
                }
                var exportdata = $("#export_"+element1).is(':checked');
                if (exportdata) {
                    RightsAARY['Export'] = 'Yes';
                } else {
                    RightsAARY['Export'] = 'No';
                }
                var viewdata = $("#view_"+element1).is(':checked');
                if (viewdata) {
                    RightsAARY['View'] = 'Yes';
                } else {
                    RightsAARY['View'] = 'No';
                }
                MODULEARRY.push(element1)

                ModulesOBJ[element1] = RightsAARY;
            }

            var objectlength = Object.keys(ModulesOBJ).length;;
            if (objectlength > 0) {
                GETMODULES.push(MODULEARRY)
                GETCATIEGORIS.push(element)
                obj[element] = ModulesOBJ;
            }
        }
        var myJSON = JSON.stringify(obj);
        // console.log(result);
        /**
        console.log("MODULEARRY", GETMODULES);
        console.log("GETCATIEGORIS", GETCATIEGORIS);
        console.log("Data", obj);
        */
        var CLIENTID = "{{$id}}"
        $.ajax({
            url: base_url  +  '/SuperAdmin/assgin-client',
            type: 'POST',
            data: {
                GETMODULES:GETMODULES,
                GETCATIEGORIS:GETCATIEGORIS,
                obj:myJSON,
                CLIENTID:CLIENTID
            },
            success: function(data) {
                var response = data.trim();
                console.log(response);
                // return;
                if ((response == 'Done')) {
                    alert('Module Assign  Succesfully');
                    window.history.back();
                } else if (response == 'Update') {
                    alert('Module Updated  Succesfully');
                    window.history.back();
                }  else if (response == 'Empty') {
                    alert('No Module is Assinged');
                } else {
                    console.log(response);
                    alert('Something Went Wrong');
                }
            },
        });
        e.preventDefault();
    }
function sellectallmodules(catid,thisvar) {
    $("input[name=allmodules_"+catid+"]").prop('checked', $(thisvar).prop('checked'));
}
function sellectallrights(catid,thisvar,count) {
    for (let index = 0; index < count; index++) {
        $("input[name=allrigths_"+catid+"_"+index+"]").prop('checked', $(thisvar).prop('checked'));
        $("input[name=rights_"+catid+"_"+index+"]").prop('checked', $(thisvar).prop('checked'));
    }
}
function selectmodules(catid) {
    if ($('input[name=allmodules_'+catid+']:checked').length == $("input[name=allmodules_"+catid+"]").length) {
        $('#allcategory_'+catid).prop('checked',true);
    } else {
        $("#allcategory_"+catid).prop("checked", false);
    }
}
function selctallrightsfunction(catid, autovalue) {
    if ($('input[name=allrigths_'+catid+'_'+autovalue+']:checked').length == $("input[name=allrigths_"+catid+"_"+autovalue+"]").length) {
        $('#allcategoryrights_'+catid).prop('checked',true);
        $('input[name=rights_'+catid+'_'+autovalue+']').prop('checked',true);
    } else {
        $("#allcategoryrights_"+catid).prop("checked", false);
        $('input[name=rights_'+catid+'_'+autovalue+']').prop('checked',false);
    }
}
function selectrightsfunction(catid, autovalue) {
    if ($('input[name=rights_'+catid+'_'+autovalue+']:checked').length == $('input[name=rights_'+catid+'_'+autovalue+']').length) {
        $('#allrigths_'+catid+'_'+autovalue).prop('checked',true);
    } else {
        $("#allrigths_"+catid+'_'+autovalue).prop("checked", false);
    }
    if ($('.rightscalss'+catid+':checked').length == $('.rightscalss'+catid).length) {
        $('#allcategoryrights_'+catid).prop('checked',true);
    } else {
        $("#allcategoryrights_"+catid).prop("checked", false);
    }
}
</script>
@endsection
