<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{Session::get('direction')}}" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Title -->

    <title>@yield('title')</title>
    @php($dir = session()->get('direction') == 'rtl' ? 'rtl' : 'ltr')

    <meta name="_token" content="{{csrf_token()}}">
    <!--to make http ajax request to https-->
    <!--    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">-->
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('/storage/app/public/company')}}/{{\App\Model\BusinessSetting::where(['type' => 'seller_fav_icon'])->pluck('value')[0]}}">
    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="{{asset('public/assets/back-end')}}/css/vendor.min.css">
    <link rel="stylesheet" href="{{asset('public/assets/back-end')}}/css/bootstrap.min.css">

    <link rel="stylesheet" href="{{asset('/public/assets/lightslider/css/lightslider.min-'.$dir.'.css')}}">

    {{--  context menu  --}}
    <link rel="stylesheet" href="{{asset('/public/assets/back-end/css/context.bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('/public/assets/back-end/css/context.standalone.css')}}">

    {{-- light box --}}
    <link rel="stylesheet" href="{{asset('public/css/lightbox.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/back-end')}}/vendor/icon-set/style.css">

    <link rel="stylesheet" href="{{asset('public/assets/back-end')}}/css/custom.css?v=3">
    <link rel="stylesheet" href="{{asset('/public/assets/back-end/css/navigation.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- intlTelInput -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css" integrity="sha512-gxWow8Mo6q6pLa1XH/CcH8JyiSDEtiwJV78E+D+QP0EVasFs8wKXq16G8CLD4CJ2SnonHr4Lm/yY2fSI2+cbmw==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <link rel="stylesheet" href="{{asset('public/assets/back-end')}}/vendor/icon-set/style.css">
    <!-- CSS Front Template -->
    <link rel="stylesheet" href="{{asset('public/assets/back-end')}}/css/theme.minc619.css?v=1.0">
    <link rel="stylesheet" href="{{asset('public/assets/back-end')}}/css/style.css">

    <link rel="apple-touch-icon" sizes="180x180"
          href="{{asset('storage/app/public/company')}}/{{$web_config['fav_icon']->value}}">
    <link rel="icon" type="image/png" sizes="32x32"
          href="{{asset('storage/app/public/company')}}/{{$web_config['fav_icon']->value}}">


    @if(Session::get('direction') === "rtl")
    <link rel="stylesheet" href="{{asset('public/assets/back-end')}}/css/menurtl.css">
    @endif
    {{-- light box --}}
    <link rel="stylesheet" href="{{asset('public/css/lightbox.css')}}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-print-2.2.3/cr-1.5.6/fh-3.2.4/kt-2.7.0/r-2.3.0/rr-1.2.8/sb-1.3.4/sl-1.4.0/sr-1.1.1/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/dataTables.bulma.min.css"/>

    {{--  aos  --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <link href="{{ asset('public/assets/back-end/js/darggable/jquery-ui-darggable.css')}}" rel="stylesheet">

    @stack('css_or_js')
    <!-- <style>
        :root {
            --theameColor: #045cff;
        }

        .rtl {
            direction: {{ Session::get('direction') }};
        }

        .select2-results__options {
            text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};
        }

    </style> -->
    <style>
        .datatable * td:not(:first-of-type), .datatable * th:not(:first-of-type), .products-dataTable * td:not(:first-of-type), .products-dataTable * th:not(:first-of-type){
            width: 180px !important;
            min-width: 180px !important;
            max-width: 180px !important;
        }

        .btn.disabled, .btn:disabled{
            background-color: gray !important;
            border: 0;
        }

        // workaround
        .intl-tel-input {
            display: table-cell;
        }
        .intl-tel-input .selected-flag {
            z-index: 4;
        }
        .intl-tel-input .country-list {
            z-index: 5;
        }
        .input-group .intl-tel-input .form-control {
            border-top-left-radius: 4px;
            border-top-right-radius: 0;
            border-bottom-left-radius: 4px;
            border-bottom-right-radius: 0;
        }

        .intl-tel-input, .iti{
            width: 100%;
        }

        .dataTables_info{
            width: 50%;
            text-align-last: start;
            position: absolute;
            display: contents !important;
        }


        .dataTables_info:nth-child(even){
            {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 10% !important;
        }

        .dataTables_paginate{
            top: 40px;
            position: relative;
            {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 1%;
        }


        .SumoSelect{
            width: 100% !important;
        }

        .SumoSelect .select-all{
            height: 40px !important;
        }

        .SumoSelect>.CaptionCont{
            text-align: start
        }

        html body{
            text-align: start !important;
        }

        #myMap{
            width:490px;
            height:265px;
            position:absolute;
            outline:none;
        }

        .breadcrumb-item::before {
            padding-left: 0.5rem;
        }

        .error_required{
            border: red solid !important;
        }

        .navbar-vertical-content * .text-truncate{
            color: white;
        }
    </style>
    <script
        src="{{asset('public/assets/back-end')}}/vendor/hs-navbar-vertical-aside/hs-navbar-vertical-aside-mini-cache.js"></script>
    <link rel="stylesheet" href="{{asset('public/assets/back-end')}}/css/toastr.css">

</head>

<body class="footer-offset">
<!-- Builder -->
@include('layouts.back-end.partials._front-settings')
<!-- End Builder -->
<span class="d-none" id="placeholderImg" data-img="{{asset('public/assets/back-end/img/400x400/img3.png')}}"></span>
{{--loader--}}
<div class="row">
    <div class="col-12 position-fixed z-9999 mt-10rem d--none">
        <div id="loading">
           <center>
            <img width="200"
                 src="{{asset('storage/app/public/company')}}/{{\App\CPU\Helpers::get_business_settings('loader_gif')}}"
                 onerror="this.src='{{asset('public/assets/front-end/img/loader.gif')}}'">
           </center>
        </div>
    </div>
</div>
{{--loader--}}

<!-- JS Preview mode only -->
@include('layouts.back-end.partials-seller._header')
@if(isset($hide_all))
    @if(!$hide_all)
    @include('layouts.back-end.partials-seller._side-bar')
    @endif
@else
@include('layouts.back-end.partials-seller._side-bar')
@endif
<!-- END ONLY DEV -->

<main id="content" role="main" class="main pointer-event">
    <!-- Content -->
@yield('content')
<!-- End Content -->

<!-- Footer -->
@if(isset($hide_all))
    @if(!$hide_all)
    @include('layouts.back-end.partials-seller._footer')
    @endif
@else
@include('layouts.back-end.partials-seller._footer')
@endif
<!-- End Footer -->

    @include('layouts.back-end.partials-seller._modals')

</main>
<!-- ========== END MAIN CONTENT ========== -->

<!-- ========== END SECONDARY CONTENTS ========== -->
<script src="{{asset('public/assets/back-end')}}/js/custom.js"></script>
<!-- JS Implementing Plugins -->

{{--@stack('script')--}}


<!-- JS Front -->
<script src="{{asset('public/assets/back-end')}}/js/vendor.min.js"></script>
<script src="{{asset('public/assets/back-end')}}/js/theme.min.js"></script>
<script src="{{asset('public/assets/back-end')}}/js/sweet_alert.js"></script>
<script src="{{asset('public/assets/back-end')}}/js/toastr.js"></script>
{!! Toastr::message() !!}

@if ($errors->any())
    <script>
        @foreach($errors->all() as $error)
        toastr.error('{{$error}}', Error, {
            CloseButton: true,
            ProgressBar: true
        });
        @endforeach
    </script>
@endif
<!-- JS Plugins Init. -->
<script>
    $(document).on('ready', function () {
        "use strict"

        // Convert SVG code
        // =======================================================
        $("img.svg").each(function () {
            var $img = jQuery(this);
            var imgID = $img.attr("id");
            var imgClass = $img.attr("class");
            var imgURL = $img.attr("src");

            jQuery.get(
            imgURL,
            function (data) {
                // Get the SVG tag, ignore the rest
                var $svg = jQuery(data).find("svg");

                // Add replaced image's ID to the new SVG
                if (typeof imgID !== "undefined") {
                $svg = $svg.attr("id", imgID);
                }
                // Add replaced image's classes to the new SVG
                if (typeof imgClass !== "undefined") {
                $svg = $svg.attr("class", imgClass + " replaced-svg");
                }

                // Remove any invalid XML tags as per http://validator.w3.org
                $svg = $svg.removeAttr("xmlns:a");

                // Check if the viewport is set, else we gonna set it if we can.
                if (
                !$svg.attr("viewBox") &&
                $svg.attr("height") &&
                $svg.attr("width")
                ) {
                $svg.attr(
                    "viewBox",
                    "0 0 " + $svg.attr("height") + " " + $svg.attr("width")
                );
                }

                // Replace image with new SVG
                $img.replaceWith($svg);
            },
            "xml"
            );
        });


        // ONLY DEV
        // =======================================================
        if (window.localStorage.getItem('hs-builder-popover') === null) {
            $('#builderPopover').popover('show')
                .on('shown.bs.popover', function () {
                    $('.popover').last().addClass('popover-dark')
                });

            $(document).on('click', '#closeBuilderPopover', function () {
                window.localStorage.setItem('hs-builder-popover', true);
                $('#builderPopover').popover('dispose');
            });
        } else {
            $('#builderPopover').on('show.bs.popover', function () {
                return false
            });
        }
        // END ONLY DEV
        // =======================================================

        // BUILDER TOGGLE INVOKER
        // =======================================================
        $('.js-navbar-vertical-aside-toggle-invoker').click(function () {
            $('.js-navbar-vertical-aside-toggle-invoker i').tooltip('hide');
        });

        // INITIALIZATION OF MEGA MENU
        // =======================================================
        /*var megaMenu = new HSMegaMenu($('.js-mega-menu'), {
            desktop: {
                position: 'left'
            }
        }).init();*/


        // INITIALIZATION OF NAVBAR VERTICAL NAVIGATION
        // =======================================================
        var sidebar = $('.js-navbar-vertical-aside').hsSideNav();


        // INITIALIZATION OF TOOLTIP IN NAVBAR VERTICAL MENU
        // =======================================================
        $('.js-nav-tooltip-link').tooltip({boundary: 'window'})

        $(".js-nav-tooltip-link").on("show.bs.tooltip", function (e) {
            if (!$("body").hasClass("navbar-vertical-aside-mini-mode")) {
                return false;
            }
        });


        // INITIALIZATION OF UNFOLD
        // =======================================================
        $('.js-hs-unfold-invoker').each(function () {
            var unfold = new HSUnfold($(this)).init();
        });


        // INITIALIZATION OF FORM SEARCH
        // =======================================================
        $('.js-form-search').each(function () {
            new HSFormSearch($(this)).init()
        });


        // INITIALIZATION OF SELECT2
        // =======================================================
        $('.js-select2-custom').each(function () {
            var select2 = $.HSCore.components.HSSelect2.init($(this));
        });


        // INITIALIZATION OF DATERANGEPICKER
        // =======================================================
        $('.js-daterangepicker').daterangepicker();

        $('.js-daterangepicker-times').daterangepicker({
            timePicker: true,
            startDate: moment().startOf('hour'),
            endDate: moment().startOf('hour').add(32, 'hour'),
            locale: {
                format: 'M/DD hh:mm A'
            }
        });


        var start = moment();
        var end = moment();

        function cb(start, end) {
            $('#js-daterangepicker-predefined .js-daterangepicker-predefined-preview').html(start.format('MMM D') + ' - ' + end.format('MMM D, YYYY'));
        }

        $('#js-daterangepicker-predefined').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);


        // INITIALIZATION OF CLIPBOARD
        // =======================================================
        $('.js-clipboard').each(function () {
            var clipboard = $.HSCore.components.HSClipboard.init(this);
        });
    });
</script>

<!-- SumoSelect -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.4.8/sumoselect.min.css" integrity="sha512-vU7JgiHMfDcQR9wyT/Ye0EAAPJDHchJrouBpS9gfnq3vs4UGGE++HNL3laUYQCoxGLboeFD+EwbZafw7tbsLvg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.4.8/jquery.sumoselect.min.js" integrity="sha512-Ut8/+LO2wW6HfMEz1vxHpiwMMQfw7Yf/0PdpTERAbK2VJQt4eVDsmFL269zUCkeG/QcEcc/tcORSrGHlP89nBQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    function iformat(li,originalOption) {
        if(!originalOption.index()){
            if(!originalOption.attr('icon')){
                return li;
            }
        }
        if(!originalOption.attr('icon')){
            return li;
        }
        $('<img class="brFlag ml-1 mr-1" onerror="this.src=\'{{asset("public/assets/front-end/img/image-place-holder.png")}}\'" src="' + originalOption.attr('icon') + '" style="width: 35px" />').insertBefore(li.find("label"));
        li.addClass('opt d-flex')
        return li;
        return $('<li class="opt d-flex"><span><i></i></span><img class="brFlag ml-1 mr-1" onerror="this.src=\'{{asset("public/assets/front-end/img/image-place-holder.png")}}\'" src="' + originalOption.attr('icon') + '" style="width: 25%" /><label>'+originalOption.text()+'</label></li>');
    }
    @if(session()->get('lang-editor') !== 1)
    $('.SumoSelect-custom,.testselect2-custom').SumoSelect({
        search:true,
        placeholder: '{{\App\CPU\Helpers::translate('Select')}}',
        searchText: "...",
        selectAll: true,
        locale: ['{{\App\CPU\Helpers::translate('Ok')}}', '{{\App\CPU\Helpers::translate('Cancel')}}', '{{\App\CPU\Helpers::translate('Select All')}}'],
        captionFormatAllSelected: '{{\App\CPU\Helpers::translate('All Selected')}}! ( {0} )',
        captionFormat: '{0} {{\App\CPU\Helpers::translate('Selected')}}',
        okCancelInMulti:true,
        renderLi: (li, originalOption) => iformat(li,originalOption),
    });
    @endif
</script>
<!-- SumoSelect end -->

<!-- Datatables -->
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-print-2.2.3/cr-1.5.6/fh-3.2.4/kt-2.7.0/r-2.3.0/rr-1.2.8/sb-1.3.4/sl-1.4.0/sr-1.1.1/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/dataTables.bulma.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="{{asset('/public/assets/lightslider/js/lightslider.min-'.$dir.'.js')}}"></script>
<!-- Page level custom scripts -->
@if(session()->get('lang-editor') !== 1)
<script>
    $(".lightSlider").lightSlider({
        rtl: {{ ($dir == 'rtl') ? 'true' : 'false' }},
        enableDrag:true,
        enableTouch:true,
        freeMove:true,
        pager:false,
        autoWidth:false,
        prevHtml:"<button class='btn btn-primary'><i class='fa fa-angle-{{ ($dir == 'rtl') ? 'right' : 'left' }}'></i></button>",
        nextHtml:"<button class='btn btn-primary'><i class='fa fa-angle-{{ ($dir == 'rtl') ? 'left' : 'right' }}'></i></button>",
    });
    setTimeout(function(){
        $(".lightSlider").css('width','fit-content')
    },500)
    var table = $('.datatable').DataTable({
        dom: 'Blfrtip',
        stateSave: true,
        buttons: [
            {
                extend: 'excel',
                text:'<i class="fa fa-file-excel-o"></i>',
                className: 'btn btn-success'
            },
            {
                extend: 'colvis',
                text:'<i class="fa fa-toggle-on"></i>',
                className: 'btn btn-info'
            },
        ],
        //pageLength: {{\App\CPU\Helpers::pagination_limit()}},
        responsive: false,
        colReorder: true,
        fixedHeader: true,
        order: [[ 2, 'asc' ]],
        scrollY: '490px',
        scrollX: true,
        autoWidth:false,
        scrollCollapse: true,
        paginate:false,
        initComplete: function () {
            var btns = $('.dt-button');
            btns.removeClass('dt-button');
            var that = this
            this.api().columns().every( function (e) {
                var column = this;
                var select = $('<input type="text" class="form-control dt-filter" placeholder="" />')
                    .appendTo( $(".theadF tr .theadFilter").eq(column.index()) )
                    .on( 'change keyup', function (e) {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        that.api().columns($(e.target).parent().index())
                            .search($(this).val())
                            .draw();
                    } );
            } );
            $(".buttons-colvis").insertAfter(".btnDeleteRow");
            $(".buttons-colvis").addClass("my-2 btn-icon-text m-2 px-2");
            $('.dataTables_filter').remove();
            $('.dataTables_length').hide();
            $('.datatable tbody').show();

            $('<div class="dataTables_info" role="status" aria-live="polite">{{\App\CPU\Helpers::translate("Selected Records")}}: <span id="table_selected">0</span></div>').appendTo("#DataTables_Table_0_wrapper");
            $('#DataTables_Table_0_info').remove();
        },
        language: {
            "zeroRecords": "Nothing found - sorry",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)"
        }
    });
    $(document).ready(function () {
        var tableActionsParent = $(".table-actions").parent();
        $(".table-actions").appendTo("#actions-bar")
        $(".table-actions").css("white-space","nowrap")
        $(".table-actions").css("display","flex")
        //$(".table-actions").css("padding-right","270px")
        //$(".table-actions").css("padding-left","30px")
        $(".table-actions * .input-group").css("width","200px")
        $(".table-actions").attr("class","table-actions")
        //$(".table-actions").insertBefore(".navbar-nav .nav-item:first")
        $(".changeOnLoad").change();
        $(document).on("change",".select_lang",function(){
            var v = $(this).val();
            if($(this).hasClass("select_lang")){
                $(this).closest('.input-group').find(".inputs_lang").hide();
            }else{
                $(this).closest('.input-group').find(".OptionTypes:not(.OptionTypes_lang)").hide();
            }
            $(this).closest('.input-group').find(`.${v}OptionType`).show();
        })

        table.on('draw',function(){
            $(".dtsb-button").addClass('btn btn-primary bg-primary btnDT')
            $(".dtsb-button").removeClass('dtsb-button')
            $(".dtsb-group").addClass("pt-2")
            $(".dtsb-delete").removeClass("btn-primary")
            $(".dtsb-delete").addClass("btn-danger bg-danger")
            $(".dtsb-dropDown").removeClass("dtsb-dropDown dtsb-italic dtsb-select")
            if($(".selectAllRecords").is(":checked")){
                $(".trSelector").prop('checked',true);
            }else{
                $(".trSelector").prop('checked',false);
            }
        })
        table.draw();

        table.on('page.dt',function(){
            if($(".selectAllRecords").is(":checked")){
                $(".trSelector").prop('checked',true);
            }else{
                $(".trSelector").prop('checked',false);
            }
        })

        $(".btnDT").click(function(){
            $(".dtsb-button").addClass('btn btn-primary bg-primary btnDT')
            $(".dtsb-button").removeClass('dtsb-button')
            $(".dtsb-group").addClass("pt-2")
            $(".dtsb-delete").removeClass("btn-primary")
            $(".dtsb-delete").addClass("btn-danger bg-danger")
            $(".dtsb-dropDown").removeClass("dtsb-dropDown dtsb-italic dtsb-select")
        })



        $(document).on("change",".SumoSelect-custom,.multiselect,.testselect2-custom",function(){
            if($(this).val()){
                $(this).closest('.form-control').next('input').val($(this).val().toString())
            }
        })



        $(".switch_inputs").change((e)=>{
            var v = "off";
            if($(e.target).is(":checked")){
                v = "on";
            }else{
                if($(e.target).hasClass("has_tax")){
                    $("input[name='tax']").val(0);
                }
            }
            var inputsClass = $(e.target).attr("inputsClass")
            $("."+inputsClass).slideUp();
            $("."+inputsClass+"_"+v).slideDown();
        })

    });

    $(document).on('change','.editValue',function(){
        $(this).closest('tr').find('.table-editor-form').addClass('edited');
    })

    function geturl(){
        return '{{route("home")}}';
    }

    function getChildren(objectt, selector, value,ths = null){
        if(value){
            $(ths).closest('.input-group').next('input').val(value.toString())
            var selected = $(selector).find('option:selected').val();
            alert_wait()
            $.ajax({
                url:'{{route("home")}}/seller/getChildren/'+objectt+'/'+value,
                success: function(data){
                    $(selector).html(data);
                    $(selector).find("option[value='"+selected+"']").attr('selected','selected');
                    if(selected){
                        $(selector).change();
                    }
                    $(selector)[0].sumo.reload();
                    Swal.close()
                }
            })
        }else{
            //Swal.close()
        }
    }

    function stateClear(){
        table.state.clear();
        window.location.reload();
    }

    function emptyInput(e,closest,selector){
        $(e.target).closest(closest).find(selector).val('')
    }

    function translate(word){
        $.ajax({
            url:"{{ route('seller.translate-now') }}?word="+word,
            success:function(data){
                return wrod;
            }
        })
    }

    function translateName(e,parent,selector){
        @foreach (\App\CPU\Helpers::get_langs() as $key=>$lang)
            $(e.target).closest(parent).find(selector+":eq({{$key}})").each(function(){
                var ths = $(this);
                if(!$(this).val()){
                    $.ajax({
                        type:'get',
                        url:"{{route('home')}}/seller/g-translate/"+e.target.value+"/{{$lang == 'sa' ? 'ar' : $lang}}",
                        success:function(data){
                            ths.val(data);
                        }
                    })
                }
            })
        @endforeach
    }

    function alert_wait(){
        var timerInterval;
            Swal.fire({
                title: `{{ \App\CPU\Helpers::translate('Please wait')}}...`,
                timerProgressBar: false,
                allowOutsideClick: false,
                showConfirmButton:false,
                didOpen: () => {
                Swal.showLoading();
                },
                willClose: () => {
                    clearInterval(timerInterval);
                },
            }).then((result) => {
            });
    }

    function saveTableChanges(withFiles){
        if($(".table-editor-form.edited").length){
            var timerInterval;
            Swal.fire({
                title: `{{ \App\CPU\Helpers::translate('Please wait')}}...`,
                timerProgressBar: false,
                allowOutsideClick: false,
                showConfirmButton:false,
                didOpen: () => {
                Swal.showLoading();
                },
                willClose: () => {
                    clearInterval(timerInterval);
                },
            }).then((result) => {
            });
        }
        var i = $(".table-editor-form.edited").length - 1;
        $(".table-editor-form.edited").each(function(index,item){
            $(this).append($(this).closest('tr').find('.editValue'));
            var frm = $(this);
            var formData = new FormData(frm[0]);
            if(withFiles){
                $(this).find('input[type=file]').each(function(){
                    formData.append($(this).attr('name'), $(this)[0].files[0]);
                })
            }
            formData.append('boolean_res', 1);
            var url = $(this).attr('action');
            $.ajax({
                type:'post',
                url:url,
                data:formData,
                contentType: false,
                processData: false,
                success:function(){
                    if(i === index){
                        location.reload()
                    }
                },
                error:function(){

                }
            })
            if(i === index){
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1500
                  })
            }
        })
    }

    function globalSearch(value){
        table.search(value).draw()
    }

    function checkAll(checked){
        $(".trSelector").prop('checked',checked);
        if(checked){
            $('.ids').val("all")
            $("#table_selected").text(table.rows().data().length)
            $("tbody").find('tr').addClass('selected')
        }else{
            $('.ids').val("")
            $("#table_selected").text(0)
            $("tbody").find('tr').removeClass('selected')
        }
        if(checked){
            table.rows( ).select();
        }else{
            table.rows( ).deselect();
        }
    }


    function handleRowSelect(e){
        if($(".selectAllRecords").is(":checked")){
            var p;
            if(table.rows('.selected').data().length){
                if(e.checked){
                    $(e).closest('tr').addClass("selected");
                    var p = (parseInt($("#table_selected").text())) + 1;
                }else{
                    $(e).closest('tr').removeClass("selected");
                    var p = (parseInt($("#table_selected").text())) - 1;
                }
                $("#table_selected").text(p)
                var non_selectedCols = []
                $(e).closest('tbody').find('tr:not(.selected)').each(function(e,i){
                    non_selectedCols.push($(this).find('.rowId').text())
                })
                $(".not_ids").val(non_selectedCols)
            }
        }else{
            var p = 0;
            if($("#table_selected").text()){
            }else{
                $("#table_selected").text(0)
            }
            if(e.checked){
                p = parseInt($("#table_selected").text()) + 1;
            }else{
                p = parseInt($("#table_selected").text()) - 1;
            }

            $("#table_selected").text(p)
            $(e).closest("tr").toggleClass('selected');
            var data = table.rows('.selected').data();
            var selectedCols = []
            $('tr.selected').each(function(e,i){
                selectedCols.push($(this).find('.rowId').text())
            })
            $(".ids").val(selectedCols)

            if(data.length == 1){

            }else{
                $(".btn-addFrom").attr("disabled","disabled");
            }
            if(!$(".selectAllRecords").is(":checked") && (table.rows('.selected').data().length)){
                //$("#table_selected").text(data.length)
            }
        }
        if($(".ids").val().includes(",") || !$(".ids").val()){
            $(".btnAddFrom:first").attr('disabled',true);
        }else{
            $(".btnAddFrom").removeAttr('disabled');
        }
    }
</script>
@endif
<!-- Datatables end -->

<script>
    $("#reset").on('click', function (){
        let placeholderImg = $("#placeholderImg").data('img');
        $('#viewer').attr('src', placeholderImg);
        $('.spartan_remove_row').click();
    });

    function openInfoWeb()
    {
        var x = document.getElementById("website_info");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }

    function addFrom(table){
        var id = $(".ids").val()
        if(id){
            location.replace("{{route('seller.clone')}}?table="+table+"&id="+id);
        }
    }
</script>
@stack('script')

<script>
    @if(session()->get('lang-editor') == 1)
    $("a").attr('href','#');
    $("input").attr('placeholder','');
    function update_lang(key, value) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{route('seller.business-settings.language.translate-submit',[session()->get('local') ?? 'sa'])}}",
            method: 'POST',
            data: {
                key: key,
                value: value
            },
            beforeSend: function () {
                $('#loading').show();
            },
            success: function (response) {
                toastr.success('{{ Helpers::translate_only('updated successfully') }}');
            },
            complete: function () {
                $('#loading').hide();
            },
        });
    }
    @endif
</script>

<script src="{{asset('/public/assets/back-end/js/darggable/darggable.js')}}"></script>
<script src="{{asset('/public/assets/back-end/js/darggable/jquery-ui-darggable.min.js')}}"></script>

<script src="{{asset('public/assets/back-end')}}/js/bootstrap.min.js"></script>

    {{--  context menu  --}}
        <link href="{{asset('/public/assets/back-end/css/context.bootstrap.css')}}">
        <link href="{{asset('/public/assets/back-end/css/context.standalone.css')}}">
        <script src="{{asset('/public/assets/back-end/js/context.js')}}"></script>
        <script>
            $( ".fav-sortable" ).sortable({
                stop: function( event, ui ) {
                    var arr = [];
                    $('.fav_item').each(function(){
                        arr.push($(this).attr("item_index"))
                    })
                    $.ajax({
                        url:"{{ route('seller.resortFav') }}",
                        type:'post',
                        data:{
                            _token: "{{ csrf_token() }}",
                            arr: arr
                        },
                        success:function(data){
                            toastr.success("{{ Helpers::translate('items successfully rearranged') }}")
                            $('.fav_item').each(function(el,index){
                                $(this).attr("item_index",el)
                            })
                        }
                    })
                }
            });
        </script>
        <script>
            myFav = {
                id: 'myFav',
                data: [
                    {
                        header: '{{ Helpers::translate("actions") }}'
                    },
                    {
                        icon: 'fa fa-trash',
                        text: '{{ Helpers::translate("remove from favorate") }}',
                        action: function(e, selector) {
                            var el = selector;
                            var i = selector.index();
                            $.ajax({
                                url:"{{ route('seller.removeFromFav') }}",
                                data:{
                                    index: i,
                                },
                                success: function(data){
                                    selector.attr('class','btn ti-plus btn-dark my-2 btn-icon-text m-1');
                                    selector.attr('href','#');
                                    selector.html('<i class="p-2 is_blank"></i>');
                                    selector.insertAfter($("#fav-bar .btn-dark:last"))
                                    $('.fav_item').each(function(el,index){
                                        $(this).attr("item_index",el)
                                    })
                                }
                            })
                        }
                    },
                ]
            };
            myMenu = {
                id: 'myMenu',
                data: [
                    {
                        header: '{{ Helpers::translate("actions") }}'
                    },
                    {
                        icon: 'fa fa-star',
                        text: '{{ Helpers::translate("add to favorate") }}',
                        action: function(e, selector) {
                            if(!$("#fav-bar").find('.is_blank:first').length){
                                Swal.fire('{{ Helpers::translate("your favorate menu is full!") }}')
                                return;
                            }

                            if($("#fav-bar").find('.btn[href="'+selector.attr('href')+'"]').length){
                                Swal.fire('{{ Helpers::translate("Item already exists in your favorate menu") }}')
                                return;
                            }


                            var title_b = selector.find('.text-truncate').attr('t')
                            var title_ = selector.find('.text-truncate').attr('t')
                            $.ajax({
                                url:"{{ route('seller.translate-now') }}?word="+title_,
                                success:function(data){
                                    var class_ = 'fa fa-star'
                                    title_ = data;
                                    if(selector.find('i').attr('class')){
                                        class_ = selector.find('i').attr('class').replace('nav-icon','')
                                    }
                                    $("#fav-bar").find('.is_blank:first').closest('.btn').attr('item_index',$('.fav_item').length)
                                    $("#fav-bar").find('.is_blank:first').closest('.btn').addClass('btn-primary fav_item card-draggable ui-sortable-handle');
                                    $("#fav-bar").find('.is_blank:first').closest('.btn').removeClass('btn-dark');
                                    $("#fav-bar").find('.is_blank:first').closest('.btn').attr('href',selector.attr('href'))
                                    $("#fav-bar").find('.is_blank:first').closest('.btn').attr('title',title_)
                                    $("#fav-bar").find('.is_blank:first').attr('class',class_);
                                    $.ajax({
                                        url: "{{route('seller.addToFav')}}",
                                        type: 'post',
                                        data:{
                                            _token: "{{ csrf_token() }}",
                                            href: selector.attr('href'),
                                            title: title_,
                                            title_b: title_b,
                                            icon: class_
                                        },
                                        success:function(data){
                                            context.attach(".fav_item", myFav);
                                            toastr.success("{{ Helpers::translate('item successfully added to favorate menu') }}")
                                        }
                                    })
                                }
                            })
                        }
                    },
                ]
            };
            context.init({preventDoubleContext: false});
            context.attach(".fav_item", myFav);
            context.attach(".navbar-vertical-content * .nav-link:not(.nav-link-toggle)", myMenu);
        </script>
    {{--  context menu end  --}}

<!-- intlTelInput -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js" integrity="sha512-+gShyB8GWoOiXNwOlBaYXdLTiZt10Iy6xjACGadpqMs20aJOoh+PJt3bwUVA6Cefe7yF7vblX6QwyXZiVwTWGg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    var inputs = $(".phoneInput");
    $(".phoneInput,input[type='number']").attr('inputmode','numeric')
    var iti = [];
    var phoneCountryCode;
    inputs.each(function(index){
        iti[index] = intlTelInput(this);
            phoneCountryCode = iti[index].getSelectedCountryData().dialCode;
        $(document).on("focus",".phoneInput",function(){
            phoneCountryCode = iti[index].getSelectedCountryData().dialCode;
        })
    })

    $(document).on("keydown",".phoneInput",function(){
        if($(this).val().length == ('+'+phoneCountryCode).length){
            $(this).val('+'+phoneCountryCode)
        }
    })

    $(document).on("keyup change",".phoneInput",function(e){
        var countryCode = '+'+phoneCountryCode;
        var value = $(this).val();
        var codeWithZero = countryCode + '0';
        if(value.startsWith(codeWithZero)){
            $(this).val(value.replace(codeWithZero,countryCode));
        }
        if(!value.startsWith(countryCode)){
            $(this).val(countryCode);
        }
        var isnum = /^\d+$/.test(value.replace('+',''))
        if(!isnum){
            $(this).val('+'+value.replace(/[^\d]/g, ""))
        }
    })
</script>

{{-- light box --}}
<script src="{{asset('public/js/lightbox.min.js')}}"></script>
<audio id="myAudio">
    <source src="{{asset('public/assets/back-end/sound/notification.mp3')}}" type="audio/mpeg">
</audio>
<script>
    var audio = document.getElementById("myAudio");

    function playAudio() {
        audio.play();
    }

    function pauseAudio() {
        audio.pause();
    }
</script>
<script>
    get_notifications();
    setInterval(function () {
        get_notifications();
    }, 10000);

    function get_notifications(){
        $.get({
            url: '{{route('seller.get-notifications')}}',
            dataType: 'json',
            success: function (response) {
                let data = response;
                data.forEach(function(item){
                    if(item.count > 0){
                        $(".text-truncate[t='"+item.type+"']").find(".badge-pill,.b-bell").show();
                        $(".text-truncate[t='"+item.type+"']").find(".badge-pill").text(item.count)
                        $(".text-truncate[t='"+item.type+"']").parents(".navbar-vertical-aside-has-menu").find('.nav-link-toggle:first .badge-pill').show()
                    }
                })
            },
        });
    }

    function check_order() {
        location.href = '{{route('seller.orders.list',['status'=>'all'])}}';
    }
</script>
<script>
    $("#search-bar-input").keyup(function () {
        $("#search-card").css("display", "block");
        let key = $("#search-bar-input").val();
        if (key.length > 0) {
            $.get({
                url: '{{url('/')}}/seller/search-function/',
                dataType: 'json',
                data: {
                    key: key
                },
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#search-result-box').empty().html(data.result)
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        } else {
            $('#search-result-box').empty();
        }
    });

    $(document).mouseup(function (e) {
        var container = $("#search-card");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            container.hide();
        }
    });
    @if(session()->get('lang-editor') !== 1)
    function form_alert(id, message) {
        Swal.fire({
            title: '{{\App\CPU\Helpers::translate('Are you sure')}}?',
            text: message,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'No',
            confirmButtonText: 'Yes',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $('#' + id).submit()
            }
        })
    }
    @endif
</script>

@if(session()->get('lang-editor') !== 1)
<script>
    function call_demo() {
        toastr.info('{{\App\CPU\Helpers::translate('Update option is disabled for demo')}}!', {
            CloseButton: true,
            ProgressBar: true
        });
    }
</script>
@endif
<!-- IE Support -->
<script>
    if (/MSIE \d|Trident.*rv:/.test(navigator.userAgent)) document.write('<script src="{{asset('public/assets/back-end')}}/vendor/babel-polyfill/polyfill.min.js"><\/script>');
</script>
@stack('script_2')

<!-- ck editor -->

<!-- ck editor -->

<script>
    //initSample();
</script>

<script>

</script>
<script>
    function getRndInteger() {
        return Math.floor(Math.random() * 90000) + 100000;
    }
</script>
</body>
</html>
