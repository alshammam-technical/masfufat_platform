@extends('layouts.front-end.app')

@section('title', \App\CPU\Helpers::translate('Register'))

@push('css_or_js')
    <style>
        @media (max-width: 500px) {
            #sign_in {
                margin-top: -23% !important;
            }

        }

        .lvml {
            behavior: url(#default#VML);
            display: inline-block;
            position: absolute
        }
    </style>

@endpush

@section('content')

    <div class="container py-4 py-lg-5 my-4"
         style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};" dir="{{ Session::get('direction') ?? 'rtl' }}">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 box-shadow">
                    <div class="card-body">
                        <h2 class="h4 mb-4">{{\App\CPU\Helpers::translate('new_account')}}</h2>
                        <form class="needs-validation_" action="{{route('customer.auth.sign-up')}}" id="register_form"
                              method="post" id="sign-up-form" enctype="multipart/form-data">
                            @csrf
                            <div id="register-step-one">

                                <div class="form-group">
                                    <label class="font-weight-bold">{{\App\CPU\Helpers::translate('company_name')}} : </label>
                                    <input tabindex="1" name="company_name" class="form-control" value="{{(old('company_name') ?? '')}}" />
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">{{\App\CPU\Helpers::translate('license_owners_name')}} : </label>
                                            <input tabindex="2"  name="name" class="form-control" value="{{ ($customer->is_store ?? null) ? old('name') ?? '' : old('name') ?? ''}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">{{\App\CPU\Helpers::translate('license owners phone')}} : </label>
                                            <input tabindex="3" name="phone" class="form-control phoneInput text-left" dir="ltr" value="{{old('phone') ?? '+966'}}" />
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="font-weight-bold">{{\App\CPU\Helpers::translate('Email')}} : </label>
                                    <input tabindex="1" name="email" class="form-control" value="{{(old('email') ?? '')}}" />
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold">{{\App\CPU\Helpers::translate('Password')}} : </label>
                                    <div class="password-toggle">
                                        <input tabindex="5" readonly onfocus="$(this).removeAttr('readonly')" class="form-control" name="password" type="password" id="si-password"
                                            style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                            required>
                                        <label class="password-toggle-btn">
                                            <input class="custom-control-input" type="checkbox">
                                            <i class="czi-eye password-toggle-indicator"></i>
                                            <span
                                                class="sr-only">{{\App\CPU\Helpers::translate('Show password')}} </span>
                                        </label>
                                    </div>
                                </div>


                                {{--  <div class="form-group flex-wrap justify-content-between" dir="ltr">
                                    <div class="form-group mb-1">

                                        <label class="" for="remember">{{\App\CPU\Helpers::translate('i_agree_to_Your')}}<a
                                                class="font-size-sm" target="_blank" href="{{route('terms')}}">
                                                {{\App\CPU\Helpers::translate('terms_and_condition')}}
                                        </a></label>
                                        <strong>
                                            <input type="checkbox" class="mr-1"
                                                name="remember" id="inputCheckd">
                                        </strong>
                                    </div>
                                </div>  --}}

                                <div class="flex-between row" style="direction: {{ Session::get('direction') }}">
                                    <div class="mt-3">
                                        <div class="text-right">
                                            <a type="button" onclick="$('#register-step-one').fadeOut();$('#register-step-two').fadeIn();onMapLoad()" class="btn btn--primary btn-primary w-100">
                                                {{\App\CPU\Helpers::translate('Next')}}
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div id="register-step-two" style="display: none;">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">{{\App\CPU\Helpers::translate('delegates_name')}} : </label>
                                            <input tabindex="1" name="delegate_phone" class="form-control"/>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">{{\App\CPU\Helpers::translate('delegates_phone')}} : </label>
                                            <input tabindex="3" name="phone" class="form-control phoneInput text-left" dir="ltr" value="{{old('phone') ?? '+966'}}" />
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="font-weight-bold">{{\App\CPU\Helpers::translate('commercial_registration_no')}} : </label>
                                            <input tabindex="1" name="commercial_registration_no" class="form-control"/>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="font-weight-bold">{{\App\CPU\Helpers::translate('tax number')}} : </label>
                                            <input tabindex="1" name="tax_no" class="form-control"/>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">{{\App\CPU\Helpers::translate('address')}} : </label>
                                            <input tabindex="1" name="address" class="form-control"/>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">{{\App\CPU\Helpers::translate('province')}} : </label>
                                            <div class="form-control p-0">
                                                <select name="governorate" class="SumoSelect-custom seller-governorate">
                                                    <option></option>
                                                    @foreach (\App\CPU\Helpers::getGovernorates() as $pr)
                                                        <option @if(($store['governorate'] ?? '') == $pr['id']) selected @endif value="{{$pr['id']}}">{{ \App\CPU\Helpers::getItemName('provinces','name',$pr['id']) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="font-weight-bold">{{\App\CPU\Helpers::translate('set address on map')}} : </label>
                                            <div class="input-group form-control p-0">
                                                <div class="input-group-prepend" role="button">
                                                    <a type="button" class="btn btn-white border-0 ht-40 p-0 m-1 wd-75"  data-bs-toggle="modal" data-effect="effect-scale" id="basic-addon1">
                                                        <i class="fa fa-map-marker text-black"></i>
                                                    </a>
                                                </div>

                                                <input tabindex="1" placeholder="{{Helpers::translate('select from map')}}" class="bg-white border-0 py-0 ht-100p" readonly/>
                                            </div>
                                            <div id="location_map_canvas"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">{{\App\CPU\Helpers::translate('Coordinates')}} - {{ Helpers::translate('longitude') }} : </label>
                                            <input tabindex="1" name="lon" id="longitude"  id="longitude" class="form-control"/>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">{{\App\CPU\Helpers::translate('Coordinates')}} - {{ Helpers::translate('latitude') }} : </label>
                                            <input tabindex="1" name="lat" id="latitude"  id="latitude" class="form-control"/>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <div class="title-color mb-0 d-flex gap-1 align-items-center">{{\App\CPU\Helpers::translate('Store Image')}} <span class="text-info">(Ratio 1:1)</span></div>
                                        <div class="form-group m-0 mt-2">
                                            <div class="custom-file text-left d-none">
                                                <input tabindex="15" type="file" name="image" id="customFileUpload1" class="custom-file-input"
                                                    accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                                <label class="custom-file-label" for="customFileUpload">{{\App\CPU\Helpers::translate('Upload image')}}</label>
                                            </div>
                                        </div>
                                        <div role="button" onclick="$('#customFileUpload1').click();" class="bg-white text-center p-3 justify-content-center mb-0" style="border: grey dashed">
                                            {{\App\CPU\Helpers::translate('Store Image')}} <span class="text-info">(Ratio 1:1)</span>
                                        </div>
                                        <div class="form-group" style="display: none">
                                            <center>
                                                <img class="w-100" id="viewer1"
                                                onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"/>
                                            </center>
                                        </div>

                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <div class="title-color mb-2 d-flex gap-1 align-items-center">{{\App\CPU\Helpers::translate('commercials_registrations_image')}} <span class="text-info">(Ratio 1:1)</span></div>
                                        <div class="form-group d-none">
                                            <div class="custom-file text-left">
                                                <input tabindex="16" type="file" name="commercial_registration_img" id="customFileUpload2" class="custom-file-input"
                                                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff, .doc, .docx, .pdf|image/*">
                                                <label class="custom-file-label" for="customFileUpload">{{\App\CPU\Helpers::translate('Upload image')}}</label>
                                            </div>
                                        </div>
                                        <div role="button" onclick="$('#customFileUpload2').click();" class="bg-white text-center p-3 justify-content-center mb-0" style="border: grey dashed">
                                            {{\App\CPU\Helpers::translate('commercials_registrations_image')}} <span class="text-info">(Ratio 1:1)</span>
                                        </div>
                                        <div class="form-group" style="display: none">
                                            <center>
                                                <img class="w-100" id="viewer2"
                                                @if($store['commercial_registration_img'] ?? '')
                                                role="button"
                                                onclick="window.open('{{asset('storage/app/public/user')}}/{{($store['commercial_registration_img'] ?? '')}}')"
                                                @endif
                                                onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                />
                                            </center>
                                        </div>

                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <div class="title-color mb-2 d-flex gap-1 align-items-center">{{\App\CPU\Helpers::translate('shop_tax_certificates_image')}} <span class="text-info">(Ratio 1:1)</span></div>
                                        <div class="form-group d-none">
                                            <div class="custom-file text-left">
                                                <input tabindex="17" type="file" name="tax_certificate_img" id="customFileUpload3" class="custom-file-input"
                                                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff, .doc, .docx, .pdf|image/*">
                                                <label class="custom-file-label" for="tax_certificate_img">{{\App\CPU\Helpers::translate('Upload image')}}</label>
                                            </div>
                                        </div>

                                        <div role="button" onclick="$('#customFileUpload3').click();" class="bg-white text-center p-3 justify-content-center mb-0" style="border: grey dashed">
                                            {{\App\CPU\Helpers::translate('shop_tax_certificates_image')}} <span class="text-info">(Ratio 1:1)</span>
                                        </div>

                                        <div class="form-group" style="display: none">
                                            <center>
                                                <img class="w-100" id="viewer3"
                                                @if($store['tax_certificate_img'] ?? '')
                                                role="button"
                                                onclick="window.open('{{asset('storage/app/public/user')}}/{{($store['tax_certificate_img'] ?? '')}}')"
                                                @endif
                                                onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                />
                                            </center>
                                        </div>

                                    </div>

                                </div>

                                <div class="row p-3 pb-2">
                                    <a type="button" onclick="$('#register-step-two').fadeOut();$('#register-step-one').fadeIn();onMapLoad()" class="btn btn-white w-25">
                                        {{\App\CPU\Helpers::translate('Previous')}}
                                    </a>
                                </div>
                                <div class="flex-between row" style="direction: {{ Session::get('direction') }}">
                                    <div class="mt-3">
                                        <div class="text-right">
                                            <button class="btn btn--primary btn-primary w-100" id="sign-up" type="submit" onclick="check()">
                                                {{\App\CPU\Helpers::translate('Create account')}}
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>

                        <div class="col-12 flex-between justify-content-center row p-0 mt-3 text-center" style="direction: {{ Session::get('direction') }}">
                            <div class="mb-0 {{Session::get('direction') === "rtl" ? '' : 'ml-2'}}">
                                <h6>
                                    {{ \App\CPU\Helpers::translate('already have an account?') }}
                                    <a href="{{route('customer.auth.login')}}">
                                        <strong class="text-primary">
                                            {{ Helpers::translate('Login') }}
                                        </strong>
                                    </a>
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="mapModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

            </div>
        </div>
    </div>
@endsection

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

        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
        });

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
    <script>
        function check() {
            $(".error_required").removeClass('error_required');
            $(".error_required_message").remove();
            var formData = new FormData(document.getElementById('register_form'));
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('customer.auth.sign-up')}}',
                data: formData,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.errors) {
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
                            if(nm == "pricing_level"){
                                $(".sumo_pricing_level").addClass("error_required");
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
                            $("#register_form * input[name='"+nm+"']").addClass("error_required");
                            $("input[name='"+nm+"']").closest('.foldable-section').slideDown();
                            $("<span class='error_required_message text-danger'>"+data.errors[i].message+"</span>").appendTo($("input[name='"+nm+"']").closest('.form-group'));
                        }
                        toastr.error("{{ Helpers::translate('Please fill all red bordered fields') }}", {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    } else {
                        toastr.success('{{ Helpers::translate('Done!') }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        $('#register_form').submit();
                    }
                }
            });
        }
    </script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer1').attr('src', e.target.result);
                    $('#viewer1').closest('div').show()
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readURL_(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer2').attr('src', e.target.result);
                    $('#viewer2').closest('div').show()
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readURL__(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer3').attr('src', e.target.result);
                    $('#viewer3').closest('div').show()
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readURL___(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer4').attr('src', e.target.result);
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
        $('#inputCheckd').change(function () {
            // console.log('jell');
            if ($(this).is(':checked')) {
                $('#sign-up').removeAttr('disabled');
            } else {
                $('#sign-up').attr('disabled', 'disabled');
            }

        });

    </script>
@endpush
