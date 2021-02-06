@extends('Layout.app')
@section('content')
<style></style>
<div class="padding_10_12">
    <div class="div_section padding_10">
        <h1 class="no_margin">Dashboard</h1>
    </div>
</div>
<div class="padding_10_12">
    <div class="row">
        <div class="col">
            <div class="container-fluid">
                <div class="row div_section padding_10 height-200 no_padding">
                    <div class="col" style="background: #B80C09;"></div>
                    <div class="col" style="background: #6B2B06;"></div>
                    <div class="col" style="background: #E5E7E6;"></div>
                    <div class="col" style="background: #B7B5B3;"></div>
                    <div class="col" style="background: #141301;"></div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="container-fluid">
                <div class="row div_section padding_10 height-200 no_padding">
                    <div class="col" style="background: #FFFFFC;"></div>
                    <div class="col" style="background: #000000;"></div>
                    <div class="col" style="background: #BEB7A4;"></div>
                    <div class="col" style="background: #FF7F11;"></div>
                    <div class="col" style="background: #FF3F00;"></div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="container-fluid">
                <div class="row div_section padding_10 height-200 no_padding">
                    <div class="col" style="background: #E8E9F3;"></div>
                    <div class="col" style="background: #CECECE;"></div>
                    <div class="col" style="background: #A6A6A8;"></div>
                    <div class="col" style="background: #272635;"></div>
                    <div class="col" style="background: #B1E5F2;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="padding_10_12">
    <div class="row">
        <div class="col">
            <div class="container-fluid">
                <div class="row div_section padding_10 height-200 no_padding">
                    <div class="col" style="background: #3D5A80;"></div>
                    <div class="col" style="background: #98C1D9;"></div>
                    <div class="col" style="background: #E0FBFC;"></div>
                    <div class="col" style="background: #EE6C4D;"></div>
                    <div class="col" style="background: #293241;"></div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="container-fluid">
                <div class="row div_section padding_10 height-200 no_padding">
                    <div class="col" style="background: #FF8811;"></div>
                    <div class="col" style="background: #F4D06F;"></div>
                    <div class="col" style="background: #FFF8F0;"></div>
                    <div class="col" style="background: #9DD9D2;"></div>
                    <div class="col" style="background: #392F5A;"></div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="container-fluid">
                <div class="row div_section padding_10 height-200 no_padding">
                    <div class="col" style="background: #B3001B;"></div>
                    <div class="col" style="background: #262626;"></div>
                    <div class="col" style="background: #255C99;"></div>
                    <div class="col" style="background: #7EA3CC;"></div>
                    <div class="col" style="background: #CCAD8F;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="padding_10_12">
    <div class="row">
        <div class="col">
            <div class="container-fluid">
                <div class="row div_section padding_10 height-200 no_padding">
                    <div class="col" style="background: #E0E0E2;"></div>
                    <div class="col" style="background: #81D2C7;"></div>
                    <div class="col" style="background: #B5BAD0;"></div>
                    <div class="col" style="background: #7389AE;"></div>
                    <div class="col" style="background: #416788;"></div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="container-fluid">
                <div class="row div_section padding_10 height-200 no_padding">
                    <div class="col" style="background: #0A0903;"></div>
                    <div class="col" style="background: #FF0000;"></div>
                    <div class="col" style="background: #FF8200;"></div>
                    <div class="col" style="background: #FFC100;"></div>
                    <div class="col" style="background: #FFEAAE;"></div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="container-fluid">
                <div class="row div_section padding_10 height-200 no_padding">
                    <div class="col" style="background: #00072D;"></div>
                    <div class="col" style="background: #001C55;"></div>
                    <div class="col" style="background: #0A2472;"></div>
                    <div class="col" style="background: #0E6BA8;"></div>
                    <div class="col" style="background: #A6E1FA;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('addscriptscontent')
<script>
    $(document).ready(function() {
        $("#table input").click(function() {
            $('#text').animate({
                'color': '#e73c27'
            }, 500, function() {
                $('#text').animate({
                    'color': '#000'
                }, 500);
            });
        });

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




    });

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
</script>
@endsection
