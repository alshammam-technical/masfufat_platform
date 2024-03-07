@extends('layouts.front-end.app')

@section('title',\App\CPU\Helpers::translate('Seller Apply'))

@push('css_or_js')
<link href="{{asset('public/assets/back-end')}}/css/select2.min.css" rel="stylesheet"/>
<link href="{{asset('public/assets/back-end/css/croppie.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>

<link rel="stylesheet" href="{{asset('/public/assets/lightslider/css/lightslider.min-'.session()->get('direction') ?? 'rtl'.'.css')}}">

<meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .lSNext{
            opacity: 1 !important;
            width: 32px;
            display: block;
            top: 5%;
            height: 32px;
            background-image: url(../img/controls.png);
            cursor: pointer;
            position: absolute;
            z-index: 2;
            margin-top: -16px;
            transition: opacity .35s linear 0s;
            background-position: -32px 0;
            right: 0;
        }

        .lSPrev{
            opacity: 1 !important;
            width: 32px;
            display: block;
            top: 5%;
            height: 32px;
            background-image: url(../img/controls.png);
            cursor: pointer;
            position: absolute;
            z-index: 2;
            margin-top: -16px;
            transition: opacity .35s linear 0s;
            background-position: -32px 0;
            right: 89%;
        }

        .lSSlideWrapper.usingCss{
            overflow: hidden;
        }
    </style>
@endpush


@section('content')
    @php($dir = session()->get('direction') ?? 'rtl')
    <style>
        .leaflet-image-layer, .leaflet-layer, .leaflet-marker-icon, .leaflet-marker-shadow, .leaflet-pane, .leaflet-pane>canvas, .leaflet-pane>svg, .leaflet-tile, .leaflet-tile-container, .leaflet-zoom-box{
            top: 42px;
        }
    </style>
    <div class="mx-6 main-card rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">

        <div class="container py-4 py-lg-5 my-4" style="text-align: right;" dir="{{ session('direction') }}">
                <!-- Nested Row within Card Body -->
                <div class="row text-center justify-content-center">
                    <div class="col-md-6">
                        <div class="p-5">
                            <div class="text-start mb-2 ">
                                <h4 class="" > {{\App\CPU\Helpers::translate('Account opening Application')}}</h4>
                                <hr>
                            </div>
                            <form class="card-body" method="POST" action="{{route('shop.apply')}}" id="seller_form"
                            enctype="multipart/form-data"
                            style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                @csrf
                                <div class="row steps" id="step1">
                                    <div class="form-group col-12">
                                        <label>{{\App\CPU\Helpers::translate('company_name')}} : </label>
                                        <input @if(!isset($profile)) name="shop[name]" @else disabled @endif class="form-control" value="{{old('shop[name]') ?? ''}}" />
                                    </div>
                                    <div class="form-group col-6">
                                        <label>{{\App\CPU\Helpers::translate('license_owners_name')}} : </label>
                                        <input @if(!isset($profile)) name="name" @else disabled @endif class="form-control" value="{{old('name')}}" />
                                    </div>

                                    <div class="form-group col-6">
                                        <label>{{\App\CPU\Helpers::translate('license owners phone')}} : </label>
                                        <input @if(!isset($profile)) name="phone" @else disabled @endif class="form-control phoneInput text-left" dir="ltr" value="{{old('phone') ?? '+966'}}" />
                                    </div>

                                    <div class="form-group col-12">
                                        <label>{{\App\CPU\Helpers::translate('Email')}} : </label>
                                        <input readonly onclick="$(this).removeAttr('readonly')" @if(!isset($profile)) name="email" @else disabled @endif class="form-control" value="{{old('email')}}" />
                                    </div>

                                    <div class="form-group col-12">
                                        <label>{{\App\CPU\Helpers::translate('Password')}} : </label>
                                        <div class="password-toggle">
                                            <input readonly onclick="$(this).removeAttr('readonly')" class="form-control" name="password" type="password" id="si-password"
                                                   style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                                   required>
                                            <label class="password-toggle-btn">
                                                <input class="custom-control-input" type="checkbox"><i
                                                    class="czi-eye password-toggle-indicator"></i><span
                                                    class="sr-only">{{\App\CPU\Helpers::translate('Show password')}} </span>
                                            </label>
                                        </div>
                                    </div>
                                    <a href="#" onclick="$('.steps').hide();$('#step2').fadeIn();" type="submit" class="btn btn--primary btn-primary btn-user btn-block"  >{{\App\CPU\Helpers::translate('Next')}} </a>
                                </div>

                                <div class="row steps" id="step2" style="display: none">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="form-group col-12">
                                                <label>{{\App\CPU\Helpers::translate('delegates_name')}} : </label>
                                                <input @if(!isset($profile)) name="delegate_name" @else disabled @endif class="form-control" value="{{old('delegate_name')}}" />
                                            </div>
                                            <div class="form-group col-12">
                                                <label>{{\App\CPU\Helpers::translate('delegates_phone')}} : </label>
                                                <input @if(!isset($profile)) name="delegate_phone" @else disabled @endif class="form-control phoneInput" dir="ltr" value="{{old('delegate_phone') ?? '+966'}}" />
                                            </div>

                                            <div class="form-group col-12">
                                                <label>{{\App\CPU\Helpers::translate('seller_commercial_registration_no')}} : </label>
                                                <input @if(!isset($profile)) name="commercial_registration_no" @else disabled @endif class="form-control" value="{{old('commercial_registration_no')}}" type="number" />
                                            </div>
                                            <div class="form-group col-12">
                                                <label>{{\App\CPU\Helpers::translate('seller tax number')}} : </label>
                                                <input @if(!isset($profile)) name="tax_no" @else disabled @endif class="form-control" value="{{old('tax_no')}}" type="number" />
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group ">
                                                    <label>{{\App\CPU\Helpers::translate('governorate')}} : </label>
                                                    <div class="form-control p-0">
                                                        <select name="governorate" class="SumoSelect-custom seller-governorate">
                                                            <option disabled selected></option>
                                                            @foreach (\App\CPU\Helpers::getGovernorates() as $pr)
                                                            <option value="{{$pr['id']}}">{{ \App\CPU\Helpers::getItemName('provinces','name',$pr['id']) }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>{{\App\CPU\Helpers::translate('the address')}} : </label>
                                                    <input @if(!isset($profile)) name="address" @else disabled @endif class="form-control" value="{{old('address')}}" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <div class="mb-4">
                                                        <p class="locations-card-body w-100 pos-relative wd-150px">
                                                            <div id="location_map_canvas"></div>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-12">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>{{\App\CPU\Helpers::translate('Coordinates')}} - lat : </label>
                                                            <input @if(!isset($profile)) name="lat" id="latitude"  @else disabled @endif aria-describedby="basic-addon1" value="{{old('lat')}}" class="form-control" placeholder="{{\App\CPU\Helpers::translate('Coordinates')}} - lat" type="text" required readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>{{\App\CPU\Helpers::translate('Coordinates')}} - lon : </label>
                                                            <input @if(!isset($profile)) name="lon" id="longitude"  @else disabled @endif aria-describedby="basic-addon1" value="{{old('lon')}}" class="form-control" placeholder="{{\App\CPU\Helpers::translate('Coordinates')}} - lon" type="text" required readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="mb-0"> {{\App\CPU\Helpers::translate('bank_info')}}</h5>
                                            </div>
                                            <div class="card-body"
                                                style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                                <div class="mt-2">
                                                    <div class="form-group">
                                                        <label>{{\App\CPU\Helpers::translate('bank_name')}} :</label>
                                                        <input @if(!isset($profile)) name="bank_name" @else disabled @endif class="form-control" value="{{old('bank_name')}}" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>{{\App\CPU\Helpers::translate('Branch')}} :</label>
                                                        <input @if(!isset($profile)) name="branch" @else disabled @endif class="form-control" value="{{old('branch')}}" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>{{\App\CPU\Helpers::translate('holder_name')}} :</label>
                                                        <input @if(!isset($profile)) name="holder_name" @else disabled @endif class="form-control" value="{{old('holder_name')}}" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>{{\App\CPU\Helpers::translate('account number')}} :</label>
                                                        <input @if(!isset($profile)) name="account_no" @else disabled @endif class="form-control" value="{{old('account_no')}}" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a href="#" onclick="$('.steps').hide();$('#step1').fadeIn();" type="submit" class="btn btn--primary btn-primary btn-user btn-block"  >{{\App\CPU\Helpers::translate('Back')}} </a>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="#" onclick="$('.steps').hide();$('#step3,.step3').fadeIn();" type="submit" class="btn btn--primary btn-primary btn-user btn-block"  >{{\App\CPU\Helpers::translate('Next')}} </a>
                                        </div>
                                    </div>
                                </div>



                                <div class="row steps" id="step3" style="display: none">
                                    <div class="form-group col-12">
                                        <ul class="nav nav-tabs lightSliderr w-fit-content mb-0 px-6 mb-6 mt-4"></ul>
                                            <div role="button" onclick="$('#customFileUpload1').click();" class="bg-white text-center p-3 justify-content-center mb-0" style="border: grey dashed">
                                                {{\App\CPU\Helpers::translate('Seller logo')}}
                                            </div>
                                            <center>
                                                <img class="upload-img-view" id="viewer1" style="display: none"
                                                onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                src="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"/>
                                            </center>

                                            <div class="form-group d-none">
                                                @if(!isset($profile))
                                                <div class="custom-file text-left">
                                                    <input type="file" @if(!isset($profile)) name="image" @else disabled @endif id="customFileUpload1" class="custom-file-input"
                                                        accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                                    <label class="custom-file-label" for="customFileUpload">{{\App\CPU\Helpers::translate('Upload image')}}</label>
                                                </div>
                                                @endif
                                            </div>
                                    </div>

                                    <div class="form-group col-12">
                                        <ul class="nav nav-tabs lightSliderr w-fit-content mb-0 px-6">
                                            @foreach(Helpers::get_langs() as $lang)
                                                <li class="nav-item text-capitalize text-dark">
                                                    <a class="nav-link lang_link text-dark {{$lang == ($default_lang ?? session()->get('local')) ? 'active':''}}"
                                                    role="button" style="color: black !important"
                                                    id="{{$lang}}-link"><img class="ml-2" width="20" src="{{asset('public/assets/front-end')}}/img/flags/{{$lang}}.png">{{\App\CPU\Helpers::get_language_name($lang).'('.strtoupper($lang).')'}}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        @foreach(Helpers::get_langs() as $lang)
                                        <input type="hidden" name="lang[]" value="{{$lang}}">
                                        <div class="form-group {{$lang != ($default_lang ?? session()->get('local')) ? 'd-none':''}} lang_form mt-3"
                                            id="{{$lang}}-form">
                                            <center>
                                                    <img class="upload-img-view viewer"
                                                    onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                    src="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'" />
                                                    <label class="w-100">{{\App\CPU\Helpers::translate('Seller Banner')}}</label>
                                            </center>

                                            <div class="">
                                                @if(!isset($profile))
                                                <div class="custom-file text-left banner-control">
                                                    <input type="file" @if(!isset($profile)) name="banner[{{$lang}}]" @else disabled @endif class="custom-file-input customFileEg1"
                                                        accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                                    <label class="custom-file-label" for="customFileUpload">{{\App\CPU\Helpers::translate('Upload image')}}</label>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                    <div class="form-group col-12">
                                        <ul class="nav nav-tabs lightSliderr w-fit-content mb-0 px-6 mb-6 mt-4"></ul>
                                        <div role="button" onclick="$('#customFileUpload2').click();" class="bg-white text-center p-3 justify-content-center mb-0" style="border: grey dashed">
                                            {{\App\CPU\Helpers::translate('seller_commercial_registration_image (attachment)')}}
                                        </div>
                                        <center>
                                            <img class="upload-img-view" id="viewer2" style="display: none"
                                            src="{{asset('public/assets/front-end/img/image-place-holder.png')}}"/>
                                        </center>
                                    @if(!isset($profile))
                                        <div class="custom-file text-left d-none">
                                            <input type="file" @if(!isset($profile)) name="commercial_registration_img" @else disabled @endif id="customFileUpload2" class="custom-file-input"
                                                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff, .pdf, .doc, .docx|image/*">
                                            <label class="custom-file-label" for="customFileUpload">{{\App\CPU\Helpers::translate('Upload file')}}</label>
                                        </div>
                                    @endif
                                    </div>

                                    <div class="form-group col-12">
                                        <ul class="nav nav-tabs lightSliderr w-fit-content mb-0 px-6 mb-6 mt-4"></ul>
                                        <div role="button" onclick="$('#customFileUpload3').click();" class="bg-white text-center p-3 justify-content-center mb-0" style="border: grey dashed">
                                            {{\App\CPU\Helpers::translate('seller_tax_certificate_image (attachment)')}}
                                        </div>
                                        <center>
                                            <img class="upload-img-view" id="viewer3" style="display: none"
                                                src="{{asset('public/assets/front-end/img/image-place-holder.png')}}"
                                                alt="banner image"/>
                                        </center>
                                    @if(!isset($profile))
                                        <div class="custom-file text-left d-none">
                                            <input type="file" @if(!isset($profile)) name="tax_certificate_img" @else disabled @endif id="customFileUpload3" class="custom-file-input"
                                                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff, .pdf, .doc, .docx|image/*">
                                            <label class="custom-file-label" for="tax_certificate_img">{{\App\CPU\Helpers::translate('Upload file')}}</label>
                                        </div>
                                    @endif
                                    </div>
                                    <div class="form-group d-flex flex-wrap justify-content-between mb-0">

                                        <div class="form-group mb-1">
                                            <strong>
                                                <input type="checkbox" class="mr-1"
                                                    name="remember" id="inputCheckd">
                                            </strong>
                                            <label class="" for="remember">{{\App\CPU\Helpers::translate('i_agree_to_Your_terms')}}<a
                                                    class="font-size-sm" target="_blank" href="{{route('terms')}}">
                                                    {{\App\CPU\Helpers::translate('terms_and_condition')}}
                                                </a></label>
                                        </div>

                                    </div>



                                </div>

                            </form>
                            <div class="row steps step3" style="display: none">
                                <div class="col-md-6">
                                    <a href="#" onclick="$('.steps').hide();$('#step2').fadeIn();" type="submit" class="btn btn--primary btn-primary btn-user btn-block"  >{{\App\CPU\Helpers::translate('Back')}} </a>
                                </div>
                                <div class="col-md-6">
                                    <button onclick="check()" type="submit" class="btn btn--primary btn-primary btn-user btn-block" id="apply">{{\App\CPU\Helpers::translate('Register seller account')}} </button>
                                </div>
                            </div>
                            <hr>
                            <div class="text-center">
                                <a class="small"  href="{{route('seller.auth.login')}}">{{\App\CPU\Helpers::translate('already_have_an_account?_login.')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function check() {
            alert_wait();
            $(".error_required").removeClass('error_required');
            $(".error_required_message").remove();
            var formData = new FormData(document.getElementById('seller_form'));
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('shop.apply')}}',
                data: formData,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.errors) {
                        Swal.close()
                        for (var i = 0; i < data.errors.length; i++) {
                            if(data.errors[i].code == "brand_id"){
                                $("<span class='error_required_message text-danger'>"+data.errors[i].message+"</span>").insertBefore(".brand_id_div");
                            }
                            var nm = data.errors[i].code.indexOf('.') >= 0 ? data.errors[i].code.replace('.','[')+']' : data.errors[i].code;
                            var nmEmptyBrackets
                            var result = nm.match(/\[(.*)\]/);
                            if(result){
                                nmEmptyBrackets = nm.replace(result[0],'[]')
                                if(!isNaN(parseInt(result[1]))){
                                    nm = nm.replace(result[0],'[]')
                                }
                            }
                            if(nm == "country"){
                                $(".sumo_country").addClass("error_required");
                            }
                            if(nm == "area"){
                                $(".sumo_area").addClass("error_required");
                            }
                            if(nm == "city"){
                                $(".sumo_city").addClass("error_required");
                            }
                            if(nm == "governorate"){
                                $(".sumo_governorate").addClass("error_required");
                            }
                            if(nm == "image"){
                                $("input[name='"+nm+"']").parent().addClass("error_required");
                            }
                            if(nm == "banner"){
                                $(".banner-control").addClass("error_required");
                            }
                            if(nm == "commercial_registration_img"){
                                $("input[name='"+nm+"']").parent().addClass("error_required");
                            }
                            if(nm == "tax_certificate_img"){
                                $("input[name='"+nm+"']").parent().addClass("error_required");
                            }
                            $("#seller_form * input[name='"+nm+"']").addClass("error_required");
                            $("input[name='"+nm+"']").closest('.foldable-section').slideDown();
                            $("<span class='error_required_message text-danger'>"+data.errors[i].message+"</span>").appendTo($("input[name='"+nm+"']").closest('.form-group'));
                        }
                        toastr.error("{{ Helpers::translate('Please fill all red bordered fields') }}", {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        $(".steps").hide();
                        $(".step1,#step1").show();
                    } else {
                        Swal.close()
                        toastr.success('{{ Helpers::translate('=updated successfully!') }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        $('#seller_form').submit();
                    }
                }
            });
        }
    </script>

    <script type="text/javascript" src="{{asset('/public/assets/lightslider/js/lightslider.min-'.$dir.'.js')}}"></script>
    <script>
        @php($dir = session()->get('direction'))
        if($(".lightSliderr").hasClass("lightSlider")){}else{
            $(".lightSliderr").lightSlider({
                rtl: {{ ($dir == 'rtl') ? 'true' : 'false' }},
                enableDrag:true,
                enableTouch:true,
                freeMove:true,
                pager:false,
                prevHtml:"<button class='btn btn-primary'><i class='fa fa-angle-{{ ($dir == 'rtl') ? 'right' : 'left' }}'></i></button>",
                nextHtml:"<button class='btn btn-primary'><i class='fa fa-angle-{{ ($dir == 'rtl') ? 'left' : 'right' }}'></i></button>",
            });
        }

        $(".lang_link").click(function (e) {
            e.preventDefault();
            $(".lang_link").removeClass('active');
            $(".lang_form").addClass('d-none');
            $(this).addClass('active');

            let form_id = this.id;
            let lang = form_id.split("-")[0];
            console.log(lang);
            $("#" + lang + "-form").removeClass('d-none');
            if (lang == '{{$default_lang ?? session()->get('local')}}') {
                $(".from_part_2").removeClass('d-none');
            } else {
                $(".from_part_2").addClass('d-none');
            }
        });
    </script>
    <script>
        function readURLBanner(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(input).closest('.form-group').find('.viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $(".customFileEg1").change(function () {
            readURLBanner(this);
        });
    </script>
@endpush

@push('script')
{{--  map  --}}
<script src="https://maps.googleapis.com/maps/api/js?key={{\App\CPU\Helpers::get_business_settings('map_api_key')}}&libraries=places&v=3.49"></script>
<script src="{{ asset('public/assets/front-end/js/bootstrap-select.min.js') }}"></script>
<script>

    function initAutocomplete() {
        var myLatLng = { lat: {{$shipping_latitude??'-33.8688'}}, lng: {{$shipping_longitude??'151.2195'}} };

        const map = new google.maps.Map(document.getElementById("location_map_canvas"), {
            center: { lat: {{$shipping_latitude??'23.8859'}}, lng: {{$shipping_longitude??'45.0792'}} },
            zoom: 16,
            mapTypeId: "roadmap",
            streetViewControl:false,
        });

        //
        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
        });
        addYourLocationButton(map, marker);
        //

        marker.setMap( map );
        var geocoder = geocoder = new google.maps.Geocoder();
        google.maps.event.addListener(map, 'click', function (mapsMouseEvent) {
            var coordinates = JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2);
            var coordinates = JSON.parse(coordinates);
            var latlng = new google.maps.LatLng( coordinates['lat'], coordinates['lng'] ) ;
            marker.setPosition( latlng );
            map.panTo( latlng );

            document.getElementById('latitude').value = coordinates['lat'];
            document.getElementById('longitude').value = coordinates['lng'];

            geocoder.geocode({ 'latLng': latlng }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
                        document.getElementById('address').value = results[1].formatted_address;
                        console.log(results[1].formatted_address);
                    }
                }
            });
        });

        // Create the search box and link it to the UI element.
        const input = document.getElementById("pac-input");
        const searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);
        // Bias the SearchBox results towards current map's viewport.
        map.addListener("bounds_changed", () => {
            searchBox.setBounds(map.getBounds());
        });
        let markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener("places_changed", () => {
            const places = searchBox.getPlaces();

            if (places.length == 0) {
            return;
            }
            // Clear out the old markers.
            markers.forEach((marker) => {
            marker.setMap(null);
            });
            markers = [];
            // For each place, get the icon, name and location.
            const bounds = new google.maps.LatLngBounds();
            places.forEach((place) => {
                if (!place.geometry || !place.geometry.location) {
                    console.log("Returned place contains no geometry");
                    return;
                }
                var mrkr = new google.maps.Marker({
                    map,
                    title: place.name,
                    position: place.geometry.location,
                });

                google.maps.event.addListener(mrkr, "click", function (event) {
                    document.getElementById('latitude').value = this.position.lat();
                    document.getElementById('longitude').value = this.position.lng();

                });

                markers.push(mrkr);

                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });
            map.fitBounds(bounds);
        });
    };
    $(document).on('ready', function () {
        initAutocomplete();

    });

    $(document).on("keydown", "input", function(e) {
      if (e.which==13) e.preventDefault();
    });
</script>
{{--  end map  --}}
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
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer1').attr('src', e.target.result);
                    $('#viewer1').show();
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readURL_(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer2').attr('src', e.target.result);
                    $('#viewer2').show();
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readURL__(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer3').attr('src', e.target.result);
                    $('#viewer3').show();
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readURL___(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer4').attr('src', e.target.result);
                    $('#viewer4').show();
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileUpload1").change(function () {
            readURL(this);
        });

        $("#customFileUpload2").change(function () {
            readURL_(this);
        });

        $("#customFileUpload3").change(function () {
            readURL__(this);
        });

        $("#customFileUpload4").change(function () {
            readURL___(this);
        });
    </script>
    <script>

        function readlogoURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewerLogo').attr('src', e.target.result);
                    $('#viewerLogoshow();
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readBannerURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewerBanner').attr('src', e.target.result);
                    $('#viewerBannshow();
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#LogoUpload").change(function () {
            readlogoURL(this);
        });
        $("#BannerUpload").change(function () {
            readBannerURL(this);
        });
    </script>
@endpush
