@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('Add Order'))

@push('css_or_js')


@endpush
@section('content')

<div class="content container-fluid">
    <!-- Page Title -->
    <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
        <h2 class="h1 mb-0 d-flex align-items-center gap-2">
            <img width="20" src="{{asset('/public/assets/back-end/img/package.png')}}" alt="">
            {{\App\CPU\Helpers::translate('Add Order')}}
        </h2>
    </div>
    <!-- End Page Title -->

    <!-- Content Row -->
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>
                        {{ Helpers::translate('the customer') }}
                    </h3>
                </div>
                <div class="card-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group d-flex align-items-center">
                                <select name="user" id="user" class="form-control " required>
                                    <option value="#">{{ Helpers::translate('customer') }}</option>
                                    @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-success rounded text-nowrap mr-5 ml-5" id="add_new_customer" type="button" data-toggle="modal" data-target="#add-customer" title="Add Customer">
                                    <i class="tio-add"></i>
                                    {{ \App\CPU\Helpers::translate('customer')}}
                                </button>
                                <input type="hidden"  name="cart_id" id="cart_id" value="{{ $cart_id }}">
                                <a href="{{ route('admin.orders.update', ['id' => $cart_id])}}" class="btn btn-primary rounded text-nowrap mr-5 ml-5" id="watch-cart-button" type="button" data-toggle="modal" title="Show Cart" style="display: none;">
                                    <i class="fas fa-shopping-cart"></i>
                                    {{ \App\CPU\Helpers::translate('Cart')}}
                                </a>

                            </div>
                            <div class="d-flex mt-4">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>
                        {{ Helpers::translate('products') }}
                    </h3>

                    <div class="col-lg-8"></div>

                    <a target="_bank" role="button" class="btn btn-primary mx-2" data-target="#products_add" data-toggle="modal">
                        <i class="tio-shopping-cart text-white mx-1"></i>
                        {{ Helpers::translate('Add products to cart') }}
                    </a>

                    <a role="button" class="btn btn-info mx-2" onclick="$('#enable-discount').show();location.replace('#enable-discount')">
                        {{ Helpers::translate('enable discount') }}
                    </a>
                </div>
                <div class="card-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">{{ Helpers::translate('Item Number') }}</th>
                                <th class="text-center">{{ Helpers::translate('product_code_sku') }}</th>
                                <th class="text-center">{{ Helpers::translate('product') }}</th>
                                <th class="text-center">{{ Helpers::translate('quantity') }}</th>
                                <th class="text-center">{{ Helpers::translate('price') }}</th>
                                <th class="text-center">{{ Helpers::translate('Discount on each piece') }}</th>
                                <th class="text-center">{{ Helpers::translate('total') }}</th>
                                <th class="text-center">{{ Helpers::translate('actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($total = 0)
                            @foreach ($cart as $item)
                            <tr>
                                <td class="pt-5 text-center"> {{$item->product_id}} </td>
                                <td class="pt-5 text-center"> {{$item->product['item_number']}} </td>
                                <td class="pt-5 text-center"> {{$item->product['code']}} </td>
                                <td class="text-start" style="width: 660px;">
                                    <a target="_blank" href="{{ route('admin.product.edit', ['id'=>$item->product['id']]) }}">
                                        @php($local = session()->get('local'))
                                        <img class="rounded productImg" width="64"
                                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                        src="{{asset("storage/app/public/product/$local")}}/{{(isset(json_decode($item->product['images'])->$local)) ? json_decode($item->product['images'])->$local[0] ?? '' : ''}}">
                                        {{ Str::limit(\App\CPU\Helpers::get_prop('App\Model\Product',$item->product['id'],'name',session()->get('local') ?? 'sa') ?? $item->product->name, 36) }}
                                    </a>
                                </td>
                                <td style="width: 100px" class="text-center pt-4"> <input style="width: 100px" class="form-control text-center " type="number" min="0" max="100" id="quantity_{{$item->id}}" value="{{ $item->quantity }}"/>  </td>
                                <td style="width: 100px" class="text-center pt-4"> <input style="width: 100px" class="form-control text-center bg-light" readonly disabled type="text" id="price_{{$item->id}}" value="{{ $item->price }}"/>  </td>
                                <td style="width: 100px" class="text-center pt-4"> <input style="width: 100px" class="form-control text-center " type="number" min="0" max="100" id="discount_{{$item->id}}" value="{{ $item->discount }}"/>  </td>
                                <td class="pt-5 text-center">
                                    <span class="calc_price_b" id="calc_price_b_{{$item->id}}" style="display: none">
                                        {{ $item->quantity*$item->price }}
                                        @php($total = $total + ($item->quantity*$item->price))
                                    </span>
                                    <span class="calc_price" id="calc_price_{{$item->id}}">
                                        {{ $item->quantity*$item->price }}
                                        @php($total = $total + ($item->quantity*$item->price))
                                    </span>
                                </td>
                                <td class="pt-3 text-center">
                                    <button class="btn btn-primary mx-1 update_price" onclick="update_price({{$item->id}})">
                                        {{ Helpers::translate('update') }}
                                    </button>
                                    <button class="btn btn-danger mx-1" onclick="form_alert('delete-{{$item->id}}','Want to delete this item ?')">
                                        {{ Helpers::translate('delete') }}
                                    </button>
                                    <form hidden id="delete-{{$item->id}}" action="{{ route('admin.abandoned-carts.delete',['id'=>$item->id]) }}" method="POST">
                                        @csrf
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-end">
                                {{ Helpers::translate('Total') }}:
                            </td>
                            <td colspan="2" style="width: 125px" class="text-start">
                                <span id="total_price_b"></span>
                                <span id="total_price" style="display: none;"></span>
                                <span>{{ \App\CPU\BackEndHelper::set_symbol('') }}</span>
                            </td>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3 pt-6" id="enable-discount" @if(!$offer) style="display: none" @endif>
        @php($o = $offer->offer ?? [])
        @include('admin-views.cart.offer_form',['id'=>$offer['id'] ?? null,'offer'=>1])
        <div class="row w-100 m-0 pt-4">
            <div class="row-12 w-100 px-1 mb-0 mx-3">
                <button class="btn btn-primary w-100" onclick="$('#offer_form').submit()">
                    <i class="tio-send"></i>
                    {{ Helpers::translate('Send the offer') }}
                </button>
            </div>
        </div>
    </div>

    <div class="row w-100 m-0 py-4">
        <div class="row-12 w-100 px-1">
            <button class="btn btn-primary w-100">
                {{ Helpers::translate('complete the order') }}
            </button>
        </div>
    </div>
    <div class="modal fade" id="products_add" tabindex="-1" role="dialog" aria-labelledby="productsModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="height: 90%" role="document">
            <div class="modal-content h-100">
                <div class="modal-header">
                    <h5 class="modal-title">{{\App\CPU\Helpers::translate('Add products to cart')}}</h5><a aria-label="Close" class="close" data-dismiss="modal" type="button" onclick="$('#added_products').val('')"><span aria-hidden="true">&times;</span></a>
                </div>
                <div class="modal-body card-body">
                    <iframe style="width: 100%;height: 80%" scrol src="{{ route('admin.pos.index',['hide_all' => 1]) }}" frameborder="0" scrolling="no"></iframe>
                    <h3>{{ Helpers::translate('added products') }}:</h3>
                    <form id="added_products_form" action="{{ route('admin.orders.addToCart',['cart_group_id'=>$cart_group_id]) }}" method="post" style="max-height: 100px;overflow-y: auto">
                        @csrf
                        <input type="hidden"  name="customer_id" id="customeri" value="">
                    </form>
                </div>

                <div class="modal-footer">
                    <button class="btn ripple btn-success" type="button" onclick="$('#added_products_form').submit()">{{\App\CPU\Helpers::translate('Apply')}}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="quick_sms" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{\App\CPU\Helpers::translate('send sms')}}</h5><a aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></a>
                </div>
                <div class="modal-body card-body">
                    <form action="{{ route('admin.sms.store') }}" method="post" id="quickSms">
                        @csrf
                        <textarea class="w-100" name="description" id="description" style="height: 127px;"></textarea>
                        <input type="hidden" name="email_to[store]" value="store">
                        <input type="hidden"  name="customer_id" id="customeri" value="">
                        <input type="hidden" name="sent_to[store]" id="sent_to_store" value="">

                        @php($selectedUserId = old('customeri'))
                        @php($userId = old('customeri'))
                        @php($customer = \App\User::find($selectedUserId))
                        @if ($customer)
                        @php($phone = $customer->phone)
                        <input type="hidden" name="sent_to[store]" value="{{$phone}}">
                        @else

                        @endif
                    </form>
                </div>
                <div class="modal-footer">
                    <a class="btn ripple btn-success" type="button" onclick="$('#quickSms').click()">{{\App\CPU\Helpers::translate('Send')}}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add-customer" tabindex="-1">
        <div style="width: 97%;display: contents" class="m-5 modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{\App\CPU\Helpers::translate('add_new_customer')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.stores.add-new')}}" method="post" id="product_form"
                          >
                        @csrf
                        @include('admin-views.customer.store-profile')

                        <hr>
                        <button type="submit" id="submit_new_customer" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('submit')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!--modal-->
@include('shared-partials.image-process._image-crop-modal',['modal_id'=>'package-image-modal','width'=>1000,'margin_left'=>'-53%'])
<!--modal-->
</div>
@push('script_2')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userSelect = document.getElementById('user');
        const sentToStoreInput = document.getElementById('customeri');
        const watchCartButton = document.getElementById('watch-cart-button'); // زر مشاهدة
        const cartIdInput = document.getElementById('cart_id');

        userSelect.addEventListener('change', function() {
            const selectedUserId = userSelect.value;
            sentToStoreInput.value = selectedUserId;

            // إجراء طلب AJAX إلى الخادم لفحص وجود سلة التسوق
            const xhr = new XMLHttpRequest();
            xhr.open('POST',"{{route('admin.orders.check_carts')}}"); // قم بتغيير المسار إلى المسار الصحيح لاستدعاء الوظيفة
            xhr.setRequestHeader('Content-Type', 'application/json');
            const csrfToken = document.querySelector('meta[name="_token"]').getAttribute('content');
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

            // إرسال بيانات المستخدم المحدد إلى الخادم
            xhr.send(JSON.stringify({ customer_id: selectedUserId }));

            // انتظر استجابة الخادم
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    cartIdInput.value = response.cart_group_id;
                    $("#watch-cart-button").prop('href','{{ route('home') }}/admin/orders/update/'+response.cart_group_id)
                    // فحص إذا كان لدى العميل سلة تسوق وعرض/إخفاء الزر بناءً على الرد من الخادم
                    if (response.has_cart) {
                        watchCartButton.style.display = 'block'; // إظهار الزر
                    } else {
                        watchCartButton.style.display = 'none'; // إخفاء الزر
                    }
                }
            };
        });
    });
</script>


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

            var userMarker = new google.maps.Marker({
                map: map,
                title: 'My Location'
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
    <script>
        function addToCart(form_id = 'add-to-cart-form') {
            if (checkAddToCartValidity()) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.post({
                    url: '{{ route('seller.pos.add-to-cart') }}',
                    data: $('#' + form_id).serializeArray(),
                    beforeSend: function () {
                        $('#loading').show();
                    },
                    success: function (data) {

                        if (data.data == 1) {
                            Swal.fire({
                                icon: 'info',
                                title: 'Cart',
                                text: '{{ \App\CPU\Helpers::translate("Product already added in cart")}}'
                            });
                            return false;
                        } else if (data.data == 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Cart',
                                text: '{{ \App\CPU\Helpers::translate("Sorry, product is out of stock.")}}'
                            });
                            return false;
                        }
                        $('.call-when-done').click();

                        toastr.success('{{ \App\CPU\Helpers::translate("Item has been added in your cart!")}}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        $('#cart').empty().html(data.view);
                        //updateCart();
                        $('.search-result-box').empty().hide();
                        $('#search').val('');
                    },
                    complete: function () {
                        $('#loading').hide();
                    }
                });
            } else {
                Swal.fire({
                    type: 'info',
                    title: 'Cart',
                    text: '{{ \App\CPU\Helpers::translate("Please choose all the options")}}'
                });
            }
        }
    </script>
@endpush
@push('script')
<script>
    $(".update_price").click();
</script>
<script>
    document.addEventListener("keydown", function(event)) {
        "use strict";
        if (event.altKey && event.code === "KeyA")
        {
            $('#add_new_customer').click();
            event.preventDefault();
        }
    }
</script>
<script>
    setInterval(function () {
        $.get({
            url: '{{route('admin.get-order-data')}}',
            dataType: 'json',
            success: function (response) {
                let data = response.data;
                if (data.new_order > 0) {
                    playAudio();
                    $('#popup-modal').appendTo("body").modal('show');
                }
            },
        });
    }, 10000);
</script>

@endpush
@endsection
