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
        #footer1{
            position: absolute !important;
        }
    </style>

@endpush

@section('content')

    <div class="container py-4 py-lg-5 my-4"
         style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};" dir="{{ Session::get('direction') ?? 'rtl' }}">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 box-shadow">
                    {{--  sellerCustomerLoginTabs  --}}
                    <div class="row mt-3 mb-3 ps-1 pe-4">
                        <div class="col-sm-6 text-center mb-1">
                            <a class="w-full whitespace-normal btn @if(Route::is('customer.auth.register')) btn-primary @else btn-white @endif"
                               href="{{route('customer.auth.register')}}"
                               style="width: auto">
                                {{\App\CPU\Helpers::translate('signup for markets')}}
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M29.8134 11.0266L29.4267 7.33329C28.8667 3.30663 27.04 1.66663 23.1334 1.66663H19.9867H18.0134H13.96H11.9867H8.78669C4.86669 1.66663 3.05335 3.30663 2.48002 7.37329L2.12002 11.04C1.98669 12.4666 2.37336 13.8533 3.21336 14.9333C4.22669 16.2533 5.78669 17 7.52002 17C9.20002 17 10.8134 16.16 11.8267 14.8133C12.7334 16.16 14.28 17 16 17C17.72 17 19.2267 16.2 20.1467 14.8666C21.1734 16.1866 22.76 17 24.4134 17C26.1867 17 27.7867 16.2133 28.7867 14.8266C29.5867 13.76 29.9467 12.4133 29.8134 11.0266Z" fill="#FDCD05"/>
                                    <path d="M15.1334 22.2134C13.44 22.3867 12.16 23.8267 12.16 25.5334V29.1867C12.16 29.5467 12.4534 29.84 12.8134 29.84H19.1734C19.5334 29.84 19.8267 29.5467 19.8267 29.1867V26C19.84 23.2134 18.2 21.8934 15.1334 22.2134Z" fill="#FDCD05"/>
                                    <path d="M28.4934 19.2V23.1733C28.4934 26.8533 25.5067 29.84 21.8267 29.84C21.4667 29.84 21.1734 29.5466 21.1734 29.1866V26C21.1734 24.2933 20.6534 22.96 19.64 22.0533C18.7467 21.24 17.5334 20.84 16.0267 20.84C15.6934 20.84 15.36 20.8533 15 20.8933C12.6267 21.1333 10.8267 23.1333 10.8267 25.5333V29.1866C10.8267 29.5466 10.5334 29.84 10.1734 29.84C6.49338 29.84 3.50671 26.8533 3.50671 23.1733V19.2266C3.50671 18.2933 4.42671 17.6666 5.29338 17.9733C5.65338 18.0933 6.01338 18.1866 6.38671 18.24C6.54671 18.2666 6.72005 18.2933 6.88005 18.2933C7.09338 18.32 7.30671 18.3333 7.52005 18.3333C9.06671 18.3333 10.5867 17.76 11.7867 16.7733C12.9334 17.76 14.4267 18.3333 16 18.3333C17.5867 18.3333 19.0534 17.7866 20.2 16.8C21.4 17.7733 22.8934 18.3333 24.4134 18.3333C24.6534 18.3333 24.8934 18.32 25.12 18.2933C25.28 18.28 25.4267 18.2666 25.5734 18.24C25.9867 18.1866 26.36 18.0666 26.7334 17.9466C27.6 17.6533 28.4934 18.2933 28.4934 19.2Z" fill="#FDCD05"/>
                                </svg>
                            </a>
                        </div>
                        <div class="col-sm-6 text-center mb-1">
                            <a class="w-full whitespace-normal btn @if(Route::is('shop.apply')) btn-primary @else btn-white @endif"
                               href="{{route('shop.apply')}}"
                               style="width: auto">
                                {{\App\CPU\Helpers::translate('signup for sellers')}}
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2.66663C8.50663 2.66663 5.66663 5.50663 5.66663 8.99996C5.66663 12.4266 8.34663 15.2 11.84 15.32C11.9466 15.3066 12.0533 15.3066 12.1333 15.32C12.16 15.32 12.1733 15.32 12.2 15.32C12.2133 15.32 12.2133 15.32 12.2266 15.32C15.64 15.2 18.32 12.4266 18.3333 8.99996C18.3333 5.50663 15.4933 2.66663 12 2.66663Z" fill="#FDCD05"/>
                                    <path d="M18.7733 18.8667C15.0533 16.3867 8.98661 16.3867 5.23995 18.8667C3.54661 20 2.61328 21.5334 2.61328 23.1734C2.61328 24.8134 3.54661 26.3334 5.22661 27.4534C7.09328 28.7067 9.54661 29.3334 11.9999 29.3334C14.4533 29.3334 16.9066 28.7067 18.7733 27.4534C20.4533 26.32 21.3866 24.8 21.3866 23.1467C21.3733 21.5067 20.4533 19.9867 18.7733 18.8667Z" fill="#FDCD05"/>
                                    <path d="M26.6534 9.78664C26.8667 12.3733 25.0267 14.64 22.48 14.9466C22.4667 14.9466 22.4667 14.9466 22.4534 14.9466H22.4134C22.3334 14.9466 22.2534 14.9466 22.1867 14.9733C20.8934 15.04 19.7067 14.6266 18.8134 13.8666C20.1867 12.64 20.9734 10.8 20.8134 8.79997C20.72 7.71997 20.3467 6.7333 19.7867 5.8933C20.2934 5.63997 20.88 5.47997 21.48 5.42664C24.0934 5.19997 26.4267 7.14664 26.6534 9.78664Z" fill="#FDCD05"/>
                                    <path d="M29.32 22.12C29.2133 23.4133 28.3867 24.5333 27 25.2933C25.6667 26.0267 23.9867 26.3733 22.32 26.3333C23.28 25.4667 23.84 24.3867 23.9467 23.24C24.08 21.5867 23.2933 20 21.72 18.7333C20.8267 18.0267 19.7867 17.4667 18.6533 17.0533C21.6 16.2 25.3067 16.7733 27.5867 18.6133C28.8133 19.6 29.44 20.84 29.32 22.12Z" fill="#FDCD05"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                    {{--  sellerCustomerLoginTabs  --}}
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
                                            style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};"
                                            required>
                                        <label class="password-toggle-btn">
                                            <input class="custom-control-input" type="checkbox">
                                            <i class="czi-eye password-toggle-indicator"></i>
                                            <span
                                                class="sr-only">{{\App\CPU\Helpers::translate('Show password')}} </span>
                                        </label>
                                    </div>
                                </div>

                                <div class="flex-between row" style="direction: {{ Session::get('direction') }}">
                                    <div class="mt-3">
                                        <div class="text-right">
                                            <a type="button" onclick="$('#register-step-one').fadeOut();$('#register-step-two').fadeIn();onMapLoad()" class="btn bg-primaryColor btn-primary w-full">
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
                                            <input tabindex="1" name="delegate_name" class="form-control"/>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">{{\App\CPU\Helpers::translate('delegates_phone')}} : </label>
                                            <input tabindex="3" name="delegate_phone" class="form-control phoneInput text-left" dir="ltr" value="{{old('phone') ?? '+966'}}" />
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

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="font-weight-bold">{{\App\CPU\Helpers::translate('Store url')}} : </label>
                                            <input tabindex="1" name="site_url" class="form-control"/>
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">{{\App\CPU\Helpers::translate('address')}} : </label>
                                            <input tabindex="1" name="address" class="form-control"/>
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
                                                <img class="w-full" id="viewer1"
                                                onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"/>
                                            </center>
                                        </div>

                                    </div>

                                    <div class="col-md-12 mb-4 formgroup">
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
                                                <img class="w-full" id="viewer2"
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
                                                <img class="w-full" id="viewer3"
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
                                            <a class="btn bg-primaryColor btn-primary w-full" id="sign-up" type="submit" onclick="check()">
                                                {{\App\CPU\Helpers::translate('Create account')}}
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>

                        <div class="col-12 flex-between justify-content-center row p-0 mt-3 text-center" style="direction: {{ Session::get('direction') }}">
                            <div class="mb-0 {{(Session::get('direction') ?? 'rtl') === "rtl" ? '' : 'ml-2'}}">
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
            $("#sign-up").attr('disabled','disabled')
            alert_wait()
            $(".error_required").removeClass('error_required');
            $(".error_required_message").remove();
            var formData = new FormData(document.getElementById('register_form'));
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('customer.auth.check_')}}',
                data: formData,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.errors) {
                        $(".error_required_message").remove();
                        var firstErrorElement = null;
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
                            $("<span class='error_required_message text-danger'>"+data.errors[i].message+"</span>").insertAfter($("input[name='"+nm+"']").closest('.formgroup').find('.title-color'));
                            // Find the input element
                            var inputElement = $("#register_form * input[name='" + nm + "']");
                            inputElement.addClass("error_required");

                            // Check if it's the first error element
                            if (!firstErrorElement) {
                                firstErrorElement = inputElement;
                            }

                            // ... (your existing error message appending code) ...
                            Swal.close()
                            $("#sign-up").removeAttr('disabled')

                        }
                        toastr.error("{{ Helpers::translate('Please fill all red bordered fields') }}", {
                            CloseButton: true,
                            ProgressBar: true
                        });

                        // Scroll to the first error element if exists
                        if (firstErrorElement) {
                            // Check if the first error element is hidden due to being on the first step
                            if ($('#register-step-two').is(':visible') && firstErrorElement.closest('#register-step-one').length > 0) {
                                // If the first error is in the first step, show the first step
                                $('#register-step-two').fadeOut(400, function() {
                                    $('#register-step-one').fadeIn(400, function() {
                                        // Then scroll to the first error element
                                        firstErrorElement.get(0).scrollIntoView({ behavior: 'smooth', block: 'center' });
                                    });
                                });
                            } else {
                                // If it's not hidden, just scroll
                                firstErrorElement.get(0).scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }
                        }

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
