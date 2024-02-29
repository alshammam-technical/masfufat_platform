@extends('layouts.front-end.app')

@section('title',\App\CPU\Helpers::translate('My Address'))

@push('css_or_js')
    <link rel="stylesheet" media="screen"
          href="{{asset('public/assets/front-end')}}/vendor/nouislider/distribute/nouislider.min.css"/>
    <link rel="stylesheet" href="{{ asset('public/assets/front-end/css/bootstrap-select.min.css') }}">
    {{--  <script src="{{ asset('public/assets/front-end/js/bootstrap-select.min.js') }}"></script>  --}}

    <style>
        .headerTitle {
            font-size: 24px;
            font-weight: 600;
            margin-top: 1rem;
        }

        body {
            font-family: 'Titillium Web', sans-serif
        }

        .product-qty span {
            font-size: 14px;
            color: #6A6A6A;
        }

        .font-nameA {

            display: inline-block;
            margin-top: 5px !important;
            font-size: 13px !important;
            color: #030303;
        }

        .font-name {
            font-weight: 600;
            font-size: 15px;
            padding-bottom: 6px;
            color: #030303;
        }

        .modal-footer {
            border-top: none;
        }

        .cz-sidebar-body h3:hover + .divider-role {
            border-bottom: 3px solid {{$web_config['primary_color']}} !important;
            transition: .2s ease-in-out;
        }

        label {
            font-size: 15px;
            margin-bottom: 8px;
            color: #030303;

        }

        .nav-pills .nav-link.active {
            box-shadow: none;
            color: #ffffff !important;
        }

        .modal-header {
            border-bottom: none;
        }

        .nav-pills .nav-link {
            padding-top: .575rem;
            padding-bottom: .575rem;
            background-color: #ffffff;
            color: #050b16 !important;
            font-size: .9375rem;
            border: 1px solid #e4dfdf;
        }

        .nav-pills .nav-link :hover {
            padding-top: .575rem;
            padding-bottom: .575rem;
            background-color: #ffffff;
            color: #050b16 !important;
            font-size: .9375rem;
            border: 1px solid #e4dfdf;
        }

        .nav-pills .nav-link.active, .nav-pills .show > .nav-link {
            color: #fff;
            background-color: {{$web_config['primary_color']}};
        }

        .iconHad {
            color: {{$web_config['primary_color']}};
            padding: 4px;
        }

        .iconSp {
            margin-top: 0.70rem;
        }

        .fa-lg {
            padding: 4px;
        }

        .fa-trash {
            color: #FF4D4D;
        }

        .namHad {
            color: #030303;
            position: absolute;
            padding-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}: 13px;
            padding-top: 8px;
        }

        .donate-now {
            list-style-type: none;
            margin: 25px 0 0 0;
            padding: 0;
        }

        .donate-now li {
            float: left;
            margin: {{(Session::get('direction') ?? 'rtl') === "rtl" ? '0 0 0 5px' : '0 5px 0 0'}};
            width: 100px;
            height: 40px;
            position: relative;
            padding: 22px;
            text-align: center;
        }

        .donate-now label,
        .donate-now input {
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .donate-now input[type="radio"] {
            opacity: 0.01;
            z-index: 100;
        }

        .donate-now input[type="radio"]:checked + label,
        .Checked + label {
            background: {{$web_config['primary_color']}};
            color: white !important;
            border-radius: 7px;
        }

        .donate-now label {
            padding: 5px;
            border: 1px solid #CCC;
            cursor: pointer;
            z-index: 90;
        }

        .donate-now label:hover {
            background: #DDD;
        }

        #edit{
            cursor: pointer;
        }
        .pac-container { z-index: 100000 !important; }

        .filter-option{
            display: block;
            width: 100%;
            height: calc(1.5em + 1.25rem + 2px);
            padding: 0.625rem 1rem;
            font-size: .9375rem;
            font-weight: 400;
            line-height: 1.5;
            color: #4b566b;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #dae1e7;
            border-radius: 0.3125rem;
            box-shadow: 0 0 0 0 transparent;
            transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .btn-light + .dropdown-menu{
            transform: none !important;
            top: 41px !important;
        }

        @media (max-width: 600px) {
            .sidebar_heading h1 {
                text-align: center;
                color: aliceblue;
                padding-bottom: 17px;
                font-size: 19px;
            }
        }
        #location_map_canvas,.location_map_canvas{
            height: 100%;
        }
        @media only screen and (max-width: 768px) {
            /* For mobile phones: */
            #location_map_canvas,.location_map_canvas{
                height: 200px;
            }
        }
    </style>
@endpush

@section('content')
<div class="container pb-5 mb-2 mb-md-4 mt-3 rtl" style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">
    <div class="row">
        <!-- Sidebar-->
    <section class="col-lg-12 mt-3 col-md-12">
        <div class="row">
            <div class="col-lg-12 col-md-12  d-flex justify-content-between overflow-hidden">
                <div class="col-md-4">
                    <h1 class="h3  mb-0 folot-left headerTitle">{{\App\CPU\Helpers::translate('UPDATE_ADDRESSES')}}</h1>
                </div>
            </div>
        </div>

            <div class="card">
                <div class="card-body">
                    <div class="col-12">
                        <form action="{{route('address-update')}}" method="post">
                            @csrf

                            <input class="form-control" name="id" type="hidden" value="{{ $shippingAddress->id }}" required>
                            <!-- Tab panes -->
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="person_name">{{\App\CPU\Helpers::translate('address name')}}</label>
                                    <input class="form-control" type="text" id="title"
                                        name="title"
                                        value="{{$shippingAddress->title ?? $shippingAddress->address_type }}"
                                        required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="person_name">{{\App\CPU\Helpers::translate('contact_person_name')}}</label>
                                    <input class="form-control" type="text" id="person_name"
                                        name="name"
                                        value="{{$shippingAddress->contact_person_name}}"
                                        required>
                                </div>


                                <div class="form-group col-md-4">
                                    <label for="exampleInputEmail1">{{ \App\CPU\Helpers::translate('The receiving person mobile number')}}
                                    <span
                                    style="color: red">*</span></label>
                                    <div class="form-group  w-full col-lg-12">
                                        <input tabindex="3" name="phone" class="form-control phoneInput text-left" dir="ltr" value="{{$shippingAddress->phone ?? '+966'}}" />
                                    </div>
                                </div>


                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label
                                            for="exampleInputEmail1">{{ \App\CPU\Helpers::translate('Country')}}
                                            <span
                                                style="color: red">*</span></label>
                                        <select name="country" id="" class="form-control SumoSelect-custom" data-bs-live-search="true" required
                                        onchange="$('#area_id').attr('disabled',1);$('#area_id_loading').show();$.get('{{route('get-shipping-areas')}}?code='+$(this).val()).then(d=>{$('#area_id').html(d);$('#area_id').removeAttr('disabled');$('#area_id_loading').hide();$('#area_id').find('option[value='+$('#area_id_hidden').val()+']').attr('selected','selected');$('#area_id').SumoSelect().sumo.reload()})">
                                            <option></option>
                                            @foreach (\App\CPU\Helpers::getCountries() as $country)
                                                <option @if($country->code == $shippingAddress->country) selected @endif value="{{ $country->code }}" icon="{{ $country->photo }}">
                                                    {{ \App\CPU\Helpers::getItemName('countries','name',$country->id) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label
                                            for="exampleInputEmail1">{{ \App\CPU\Helpers::translate('Governorate')}}
                                            <span style="color: red">*</span></label>
                                        <select name="area_id" id="area_id" class="form-control SumoSelect-custom" data-bs-live-search="true" required>
                                            @if($shippingAddress->country == "SA")
                                            @foreach(Helpers::get_sa_areas() as $key => $area)
                                                <option value="{{ $area->id }}" @if($area->id == $shippingAddress->area_id) selected @endif>
                                                    {{ Helpers::translate($area->name) }}
                                                </option>
                                            @endforeach
                                            @endif
                                        </select>
                                        <span class="text-warning" id="area_id_loading" style="display: none;">{{ Helpers::translate('Please wait') }}</span>
                                        <input type="hidden" id="area_id_hidden" value="{{$shippingAddress->area_id ?? '0'}}">
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="zip_code">{{\App\CPU\Helpers::translate('zip_code')}}</label>
                                    @if($zip_restrict_status)
                                        <select name="zip" class="form-control selectpicker" data-bs-live-search="true" id="" required>
                                            @foreach($delivery_zipcodes as $zip)
                                                <option value="{{ $zip->zipcode }}" {{ $zip->zipcode == $shippingAddress->zip? 'selected' : ''}}>{{ $zip->zipcode }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <input class="form-control" type="text" pattern="\d*" t="number" id="zip_code" name="zip" value="{{$shippingAddress->zip}}" required>
                                    @endif
                                </div>

                                <div class="form-group col-lg-4">
                                    <label
                                        for="exampleInputEmail1">{{ \App\CPU\Helpers::translate('Street - neighborhood')}}<span
                                            style="color: red">*</span></label>
                                    <textarea class="form-control" id="address"
                                              type="text"
                                              name="address" required>{{$shippingAddress->address}}</textarea>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="a25" class="form-control mt-5">
                                            <div>
                                                <div class="form-check" style="padding-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}: 1.25rem;">
                                                    <input type="checkbox" class="address_type" id="a25" name="addressAs" value="permanent" {{ $shippingAddress->address_type == 'permanent' ? 'checked' : ''}} />
                                                    {{\App\CPU\Helpers::translate('permanent')}}
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="own_address">{{\App\CPU\Helpers::translate('address')}}</label>
                                    <textarea class="form-control" id="address"
                                        type="text"  name="address" required>{{$shippingAddress->address}}</textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <input id="pac-input" class="controls rounded __inline-46" title="{{Helpers::translate('search_your_location_here')}}" type="text" placeholder="{{Helpers::translate('search_here')}}"/>
                                    <div class="__h-200px" id="location_map_canvas"></div>
                                </div>
                            </div>

                            @php($shipping_latitude=$shippingAddress->latitude)
                            @php($shipping_longitude=$shippingAddress->longitude)
                            <input type="hidden" id="latitude"
                                name="latitude" class="form-control d-inline"
                                placeholder="Ex : -94.22213" value="{{$shipping_latitude??0}}" required readonly>
                            <input type="hidden"
                                name="longitude" class="form-control"
                                placeholder="Ex : 103.344322" id="longitude" value="{{$shipping_longitude??0}}" required readonly>
                            <div class="modal-footer">
                                <button type="submit" class="btn bg-primaryColor text-light">{{\App\CPU\Helpers::translate('update')}}  </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

    </section>
</div>
@endsection

@push('script')
<script src="https://maps.googleapis.com/maps/api/js?key={{\App\CPU\Helpers::get_business_settings('map_api_key')}}&libraries=places&v=3.49"></script>
<script src="{{ asset('public/assets/front-end/js/bootstrap-select.min.js') }}"></script>
<script>

    function initAutocomplete() {
        var myLatLng = { lat: {{$shipping_latitude??'23.8859'}}, lng: {{$shipping_longitude??'45.0792'}} };

        const map = new google.maps.Map(document.getElementById("location_map_canvas"), {
            center: { lat: {{$shipping_latitude??'23.8859'}}, lng: {{$shipping_longitude??'45.0792'}} },
            zoom: 18,
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
@endpush
