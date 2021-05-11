@extends('Layout.app')
@section('content')
<style>

</style>
<div>
    <div class=" h1_weight_700 shadow_patch">
        <div id="textbox" class="">
            <p class="alignleft bold_heavy bold_font_heading">Client <label class="grey_small_text"
                    id="totalclient"></label></p>
            <a href="{{url('SuperAdmin/superadmin-creation')}}">
                <p class="alignright">
                    <span class="btn_with_icon">
                        Add <i class="feather icon-plus-circle  small_icon"></i>
                    </span>
                </p>
            </a>
        </div>
        <div style="clear: both;"></div>
        <div>
            <div class="row ">
                <div class="col-md-12 col-sm-12 col-xs-12 padding_15">
                    <table class="table yajra-datatable width_100" id="example3">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Logo</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Time Zone</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('addscriptscontent')
<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var path = {!! json_encode(url('/')) !!};
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#table input").click(function() {
            $('#text').animate({
                'color': '#e73c27'
            }, 500, function() {
                $('#text').animate({
                    'color': '#000'
                }, 500);
            });
        });


        showDatatable();
    });
    function showDatatable() {
        $('#example3').DataTable().clear().destroy();
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


            ajax : {
                url : path + '/SuperAdmin/all-superadmins',
                type : 'post',
                data : {_token: CSRF_TOKEN},
                complete: function (data) {
                    var Totalvalue = data.responseJSON.recordsFiltered;
                    $("#totalclient").text(Totalvalue);
                }
            },

            columns: [
                // {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },

                {
                    data: 'LOGO',
                    name: 'LOGO'
                },
                {
                    data: 'Name',
                    name: 'Name'
                },

                {
                    data: 'SUPEMAILID',
                    name: 'SUPEMAILID'
                },
                {
                    data: 'TIMEZONE',
                    name: 'TIMEZONE'

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

    function deleteClient(id) {

        var r = confirm("Are you Sure You Want To Super Admin");
        if (r == true) {
            // alert(path);
            $.ajax({
                url: path  +  '/SuperAdmin/delete-superadmin',
                type: 'POST',
                data: {
                    clientid: id
                },
                success: function(data) {
                    var response = data.trim();
                    if (response == 'DONE') {
                        alert('Client Deleted Succesfully');
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
