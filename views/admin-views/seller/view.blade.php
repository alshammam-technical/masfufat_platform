@extends('layouts.back-end.app')

@section('title', $seller->shop? $seller->shop->name : \App\CPU\Helpers::translate("Shop Name"))

@push('css_or_js')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Title -->
            <div class="col-lg-6 pt-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\Helpers::translate('Dashboard')}}</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="{{ route('admin.sellers.seller-list') }}">
                                {{Helpers::translate('seller_list')}}
                            </a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a>
                                {{Helpers::translate('seller_details')}}
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
            <!-- End Page Title -->

        <!-- Page Heading -->
        <!-- Page Header -->
        <div class="page-header">
            <div class="flex-between row mx-1">
                <div>
                    <h1 class="page-header-title">{{ $seller->shop? $seller->shop->name : "Shop Name : Update Please" }}</h1>
                </div>
            </div>
            <!-- Nav Scroller -->
            <div class="js-nav-scroller hs-nav-scroller-horizontal">
                <!-- Nav -->
                <ul class="nav nav-tabs flex-wrap page-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link active"
                           href="{{ route('admin.sellers.view',$seller->id) }}">{{\App\CPU\Helpers::translate('seller primary data')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           href="{{ route('admin.sellers.view',['id'=>$seller->id, 'tab'=>'order']) }}">{{\App\CPU\Helpers::translate('Order')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           href="{{ route('admin.sellers.view',['id'=>$seller->id, 'tab'=>'product']) }}">{{\App\CPU\Helpers::translate('seller Products')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           href="{{ route('admin.sellers.view',['id'=>$seller->id, 'tab'=>'setting']) }}">{{\App\CPU\Helpers::translate('Setting')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           href="{{ route('admin.sellers.view',['id'=>$seller->id, 'tab'=>'transaction']) }}">{{\App\CPU\Helpers::translate('Transaction')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           href="{{ route('admin.sellers.view',['id'=>$seller->id, 'tab'=>'review']) }}">{{\App\CPU\Helpers::translate('Review')}}</a>
                    </li>

                </ul>
                <!-- End Nav -->
            </div>
            <!-- End Nav Scroller -->
        </div>
        <!-- End Page Header -->

        <div class="row">
            <div class="col-lg-5"></div>
            <div class="col-lg-7" hidden>
                <div class="d-flex table-actions flex-wrap justify-content-end mx-3">
                    <div class="d-flex">
                    <a title="{{Helpers::translate('Add new')}}" class="btn ti-plus btn-success my-2 btn-icon-text m-2" href="{{route('admin.sellers.seller-add')}}">
                        <i class="fa fa-plus"></i>
                    </a>
                    <button title="{{Helpers::translate('Add from')}}" class="btn btn-info mdi mdi-arrange-bring-forward btnAddFrom my-2 btn-icon-text m-2">
                        <i class="fa fa-clone"></i>
                    </button>


                    <button title="{{Helpers::translate('Edit')}}" class="btn btn-info my-2 btn-icon-text m-2 save-btn"
                    onclick="$('.btn-save').click()">
                        <i class="fa fa-save"></i>
                    </button>

                    <button title="{{Helpers::translate('delete')}}" class="btnDeleteRow btn ti-trash btn-danger my-2 btn-icon-text m-2"
                    onclick="form_alert('bulk-delete','Want to delete this item ?')"
                    >
                        <i class="fa fa-trash"></i>
                    </button>
                    <form hidden action="{{route('admin.sellers.bulk-delete')}}" method="post" id="bulk-delete">
                        @csrf @method('delete')
                        <input type="text" name="ids" class="ids" value="{{$seller['id']}}">
                        <input type="text" name="back" value="1">
                    </form>
                    <button disabled class="btn buttons-collection dropdown-toggle buttons-colvis d-none btn-primary my-2 btn-icon-text m-2">
                        <i class="fa fa-toggle"></i>
                    </button>
                    </div>
                    <div class="moreOptions justify-content-center mt-2 mr-2 ml-4">
                        <div class="dropdown dropdown">
                            <button disabled aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary dropdown-toggle" data-toggle="dropdown" id="droprightMenuButton" type="button" style="height:43px">
                                <i class="ti-bag"></i>
                            </button>
                            <div aria-labelledby="droprightMenuButton" class="dropdown-menu">
                                <a class="dropdown-item" href="#"
                                onclick="form_alert('bulk-enable','Are you sure ?')"
                                >
                                    <i class="ti-check"></i>{{\App\CPU\Helpers::translate('enable')}}
                                </a>
                                <a class="dropdown-item" href="#"
                                onclick="form_alert('bulk-disable','Are you sure ?')"
                                >
                                    <i class="ti-close"></i>{{\App\CPU\Helpers::translate('diable')}}
                                </a>
                                <a class="dropdown-item" href="#" onclick="stateClear()">
                                    <i class=""></i> {{\App\CPU\Helpers::translate('Restore Defaults')}}
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="ti-reload"></i>{{\App\CPU\Helpers::translate('refresh')}}
                                </a>
                                <a aria-expanded="false" aria-haspopup="true" class="dropdown-item dropdown-toggle bulk-import-export" data-toggle="dropdown" id="droprightMenuButton" type="button"
                                onclick='$(".dt-button-collection").remove();'>
                                    <i class="ti-angle-down"></i>
                                    {{\App\CPU\Helpers::translate('Import/Export')}}
                                </a>
                                <div aria-labelledby="droprightMenuButton" class="dropdown-menu tx-13" style="position: absolute;will-change: transform;top: -10%;left: -100%;transform: translate3d(0px, 145px, 0px);">
                                    <a class="dropdown-item bulk-export" href="{{route('admin.sellers.seller-add')}}">
                                        {{\App\CPU\Helpers::translate('export to excel')}}
                                    </a>
                                    <a class="dropdown-item bulk-import" href="{{route('admin.sellers.seller-add')}}">
                                        {{\App\CPU\Helpers::translate('import from excel')}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">

                <div class="row justify-content-between align-items-center g-2 mb-3">
                    <div class="col-sm-6">
                        <h4 class="d-flex align-items-center text-capitalize gap-10 mb-0">
                            <img width="20" class="mb-1" src="{{asset('/public/assets/back-end/img/admin-wallet.png')}}" alt="">
                            {{\App\CPU\Helpers::translate('Seller_Wallet')}}
                        </h4>
                    </div>
                </div>

                <div class="row g-2" id="order_stats">
                    <div class="col-lg-4">
                        <!-- Card -->
                        <div class="card h-100 d-flex justify-content-center align-items-center">
                            <div class="card-body d-flex flex-column gap-10 align-items-center justify-content-center">
                                <img width="48" class="mb-2" src="{{asset('/public/assets/back-end/img/withdraw.png')}}" alt="">
                                <h3 class="for-card-count mb-0 fz-24">{{ $seller->wallet ? \App\CPU\BackEndHelper::set_symbol(($seller->wallet->total_earning)) : 0 }}</h3>
                                <div class="font-weight-bold text-capitalize mb-30">
                                    {{\App\CPU\Helpers::translate('Withdrawable_balance')}}
                                </div>
                            </div>
                        </div>
                        <!-- End Card -->
                    </div>
                    <div class="col-lg-8">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="card card-body h-100 justify-content-center">
                                    <div class="d-flex gap-2 justify-content-between align-items-center">
                                        <div class="d-flex flex-column align-items-start">
                                            <h3 class="mb-1 fz-24">{{ $seller->wallet ? \App\CPU\BackEndHelper::set_symbol(($seller->wallet->pending_withdraw)) : 0}}</h3>
                                            <div class="text-capitalize mb-0">{{\App\CPU\Helpers::translate('Pending_Withdraw')}}</div>
                                        </div>
                                        <div>
                                            <img width="40" class="mb-2" src="{{asset('/public/assets/back-end/img/pw.png')}}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-body h-100 justify-content-center">
                                    <div class="d-flex gap-2 justify-content-between align-items-center">
                                        <div class="d-flex flex-column align-items-start">
                                            <h3 class="mb-1 fz-24">{{ $seller->wallet ? \App\CPU\BackEndHelper::set_symbol(($seller->wallet->commission_given)) : 0}}</h3>
                                            <div class="text-capitalize mb-0">{{\App\CPU\Helpers::translate('Total_Commission_given')}}</div>
                                        </div>
                                        <div>
                                            <img width="40" src="{{asset('/public/assets/back-end/img/tcg.png')}}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-body h-100 justify-content-center">
                                    <div class="d-flex gap-2 justify-content-between align-items-center">
                                        <div class="d-flex flex-column align-items-start">
                                            <h3 class="mb-1 fz-24">{{$seller->wallet ? \App\CPU\BackEndHelper::set_symbol(($seller->wallet->withdrawn)) : 0}}</h3>
                                            <div class="text-capitalize mb-0">{{\App\CPU\Helpers::translate('Aready_Withdrawn')}}</div>
                                        </div>
                                        <div>
                                            <img width="40" src="{{asset('/public/assets/back-end/img/aw.png')}}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-body h-100 justify-content-center">
                                    <div class="d-flex gap-2 justify-content-between align-items-center">
                                        <div class="d-flex flex-column align-items-start">
                                            <h3 class="mb-1 fz-24">{{ $seller->wallet ? \App\CPU\BackEndHelper::set_symbol(($seller->wallet->delivery_charge_earned)) : 0}}</h3>
                                            <div class="text-capitalize mb-0">{{\App\CPU\Helpers::translate('total_delivery_charge_earned')}}</div>
                                        </div>
                                        <div>
                                            <img width="40" src="{{asset('/public/assets/back-end/img/tdce.png')}}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-body h-100 justify-content-center">
                                    <div class="d-flex gap-2 justify-content-between align-items-center">
                                        <div class="d-flex flex-column align-items-start">
                                            <h3 class="mb-1 fz-24">{{ $seller->wallet ? \App\CPU\BackEndHelper::set_symbol(($seller->wallet->total_tax_collected)) : 0}}</h3>
                                            <div class="text-capitalize mb-0">{{\App\CPU\Helpers::translate('total_tax_given')}}</div>
                                        </div>
                                        <div>
                                            <img width="40" src="{{asset('/public/assets/back-end/img/ttg.png')}}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-body h-100 justify-content-center">
                                    <div class="d-flex gap-2 justify-content-between align-items-center">
                                        <div class="d-flex flex-column align-items-start">
                                            <h3 class="mb-1 fz-24">{{ $seller->wallet ? \App\CPU\BackEndHelper::set_symbol(($seller->wallet->collected_cash)) : 0}}</h3>
                                            <div class="text-capitalize mb-0">{{\App\CPU\Helpers::translate('collected_cash')}}</div>
                                        </div>
                                        <div>
                                            <img width="40" src="{{asset('/public/assets/back-end/img/cc.png')}}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('admin-views.seller.seller-account')
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
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer1').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readURL_(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer2').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readURL__(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer3').attr('src', e.target.result);
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
@endpush
