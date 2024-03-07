@extends('layouts.back-end.app-seller')

@section('title', \App\CPU\Helpers::translate('POS'))
@section('content')
<!-- Content -->
	<!-- ========================= SECTION CONTENT ========================= -->
	<section class="section-content pt-10 px-6">
		<div class="container-fluid p-0 m-0 w-100">
			<div class="row">
                <div class="col-lg-5 mb-5">
                    <div class="card billing-section-wrap">
                        <h5 class="p-3 m-0 bg-light">{{\App\CPU\Helpers::translate('Billing_Section')}}</h5>
                        <div class="card-body">
                            <label for="end_customers">
                                <input type="checkbox" name="end_customers" id="end_customers">
                                {{ \App\CPU\Helpers::translate('end customers')}}
                            </label>
                            <div class="form-group d-flex gap-2">
                                <select onchange="customer_change(this.value);" id='customer' name="customer_id" data-placeholder="Walk In Customer" class="js-data-example-ajax form-control form-ellipsis">
                                    <option value="0">{{\App\CPU\Helpers::translate('walking_customer')}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="text-capitalize title-color d-flex align-items-center flex-wrap gap-1">
                                    {{\App\CPU\Helpers::translate('current_customer')}} :
                                    <span class="mb-0 w-100" id="current_customer"></span>
                                </label>
                            </div>
                            <div class="d-flex gap-2 flex-wrap flex-sm-nowrap mb-3">
                                <select id='cart_id' name="cart_id" class=" form-control js-select2-custom" onchange="cart_change(this.value);">
                                </select>
                                <a class="btn btn-secondary rounded text-nowrap" onclick="clear_cart()">
                                    {{ \App\CPU\Helpers::translate('clear_cart')}}
                                </a>
                                <a class="btn btn-info rounded text-nowrap" onclick="new_order()">
                                    {{ \App\CPU\Helpers::translate('new_order')}}
                                </a>
                            </div>
                            <div id="cart" class="pb-5">
                                @include('seller-views.pos._cart',['cart_id'=>$cart_id])
                            </div>
                        </div>
                    </div>
				</div>
				<div class="col-lg-7 m-0 p-0 w-100">
                    @include('seller-views.pos.products')
				</div>
			</div>
		</div><!-- container //  -->
	</section>

    <!-- End Content -->
    <div class="modal fade pt-5" id="quick-view" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" id="quick-view-modal">

            </div>
        </div>
    </div>

    @php($order=\App\Model\Order::find(session('last_order')))

    @if($order)
    @php(session(['last_order'=> false]))
    <div class="modal fade py-5" id="print-invoice" tabindex="-1">
        <div class="modal-dialog" style="width: 100%;display: contents">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{\App\CPU\Helpers::translate('Print Invoice')}}</h5>
                    <button id="invoice_close" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body row">
                    <div class="col-md-12">
                        <center>
                            <input id="print_invoice" type="button" class="btn btn--primary btn-primary non-printable" onclick="$('#a-layout').show();$('#roll-layout').hide();printDiv('printableArea')"
                                value="{{\App\CPU\Helpers::translate('Proceed, If thermal printer is ready')}} (A4)."/>
                            <input id="print_invoice" type="button" class="btn btn--primary btn-primary non-printable" onclick="$('#a-layout').hide();$('#roll-layout').show();printDiv('printableArea')"
                                value="{{\App\CPU\Helpers::translate('Proceed, If thermal printer is ready')}} (Roll)."/>
                            <a href="{{url()->previous()}}" class="btn btn-danger non-printable">{{\App\CPU\Helpers::translate('Back')}}</a>
                        </center>
                        <hr class="non-printable">
                    </div>
                    <div class="row m-auto w-100 bg-white" id="printableArea">
                        @include('seller-views.pos.order.invoice')
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endif


@endsection

@push('script_2')
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
<script>

    function delay(callback, ms) {
        var timer = 0;
        return function() {
            var context = this, args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function () {
            callback.apply(context, args);
            }, ms || 0);
        };
    }

    $(document).on('ready', function () {
        $.ajax({
            url: '{{route('seller.pos.get-cart-ids')}}',
            type: 'GET',

            dataType: 'json', // added data type
            beforeSend: function () {
                $('#loading').removeClass('d-none');
                //console.log("loding");
            },
            success: function (data) {
                //console.log(data.cus);
                var output = '';
                    for(var i=0; i<data.cart_nam.length; i++) {
                        output += `<option value="${data.cart_nam[i]}" ${data.current_user==data.cart_nam[i]?'selected':''}>${data.cart_nam[i]}</option>`;
                    }
                    $('#cart_id').html(output);
                    $('#current_customer').html(data.current_customer);
                    $('#cart').empty().html(data.view);

            },
            complete: function () {
                $('#loading').addClass('d-none');
            },
        });
    });

    function form_submit(){
        Swal.fire({
            title: '{{\App\CPU\Helpers::translate('Are you sure')}}?',
            type: 'warning',
            showCancelButton: true,
            showConfirmButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'No',
            confirmButtonText: 'Yes',
            reverseButtons: true
        }).then(function (result) {
            if(result.value){
                $('#order_place').submit();
            }
        });
    }
</script>
<script>
    document.addEventListener("keydown", function(event) {
    "use strict";
    if (event.altKey && event.code === "KeyO")
    {
        $('#submit_order').click();
        event.preventDefault();
    }
    if (event.altKey && event.code === "KeyZ")
    {
        $('#payment_close').click();
        event.preventDefault();
    }
    if (event.altKey && event.code === "KeyS")
    {
        $('#order_complete').click();
        event.preventDefault();
    }
    if (event.altKey && event.code === "KeyC")
    {
        emptyCart();
        event.preventDefault();
    }
    if (event.altKey && event.code === "KeyA")
    {
        $('#add_new_customer').click();
        event.preventDefault();
    }
    if (event.altKey && event.code === "KeyN")
    {
        $('#submit_new_customer').click();
        event.preventDefault();
    }
    if (event.altKey && event.code === "KeyK")
    {
        $('#short-cut').click();
        event.preventDefault();
    }
    if (event.altKey && event.code === "KeyP")
    {
        $('#print_invoice').click();
        event.preventDefault();
    }
    if (event.altKey && event.code === "KeyQ")
    {
        $('#search').focus();
        $("#-pos-search-box").css("display", "none");
        event.preventDefault();
    }
    if (event.altKey && event.code === "KeyE")
    {
        $("#pos-search-box").css("display", "none");
        $('#extra_discount').click();
        event.preventDefault();
    }
    if (event.altKey && event.code === "KeyD")
    {
        $("#pos-search-box").css("display", "none");
        $('#coupon_discount').click();
        event.preventDefault();
    }
    if (event.altKey && event.code === "KeyB")
    {
        $('#invoice_close').click();
        event.preventDefault();
    }
    if (event.altKey && event.code === "KeyX")
    {
        clear_cart();
        event.preventDefault();
    }
    if (event.altKey && event.code === "KeyR")
    {
        new_order();
        event.preventDefault();
    }

});
</script>
<!-- JS Plugins Init. -->
<script>
    jQuery(".search-bar-input").on('keyup',function () {
        //$('#pos-search-box').removeClass('d-none');
        $(".pos-search-card").removeClass('d-none').show();
        let name = $(".search-bar-input").val();
        //console.log(name);
        if (name.length >0) {
            $('#pos-search-box').removeClass('d-none').show();
            $.get({
                url: '{{route('seller.pos.search-products')}}',
                dataType: 'json',
                data: {
                    name: name
                },
                beforeSend: function () {
                    $('#loading').removeClass('d-none');
                },
                success: function (data) {
                    //console.log(data.count);

                    $('.search-result-box').empty().html(data.result);
                    if(data.count==1)
                    {
                        $('.search-result-box').empty().hide();
                        $('#search').val('');
                        quickView(data.id);
                    }

                },
                complete: function () {
                    $('#loading').addClass('d-none');
                },
            });
        } else {
            $('.search-result-box').empty();
        }
    });
</script>
<script>
    "use strict";
    function customer_change(val) {
        //let  cart_id = $('#cart_id').val();
        $.post({
                url: '{{route('seller.pos.remove-discount')}}',
                data: {
                    _token: '{{csrf_token()}}',
                    //cart_id:cart_id,
                    user_id:val
                },
                beforeSend: function () {
                    $('#loading').removeClass('d-none');
                },
                success: function (data) {
                    console.log(data);

                    var output = '';
                    for(var i=0; i<data.cart_nam.length; i++) {
                        output += `<option value="${data.cart_nam[i]}" ${data.current_user==data.cart_nam[i]?'selected':''}>${data.cart_nam[i]}</option>`;
                    }
                    $('#cart_id').html(output);
                    $('#current_customer').html(data.current_customer);
                    $('#cart').empty().html(data.view);
                },
                complete: function () {
                    $('#loading').addClass('d-none');
                }
            });
    }
</script>
<script>
    "use strict";
    function clear_cart()
    {
        let url = "{{route('seller.pos.clear-cart-ids')}}";
        document.location.href=url;
    }
</script>
<script>
    "use strict";
    function new_order()
    {
        let url = "{{route('seller.pos.new-cart-id')}}";
        document.location.href=url;
    }
</script>
<script>
    "use strict";
    function cart_change(val)
    {
        let  cart_id = val;
        let url = "{{route('seller.pos.change-cart')}}"+'/?cart_id='+val;
        document.location.href=url;
    }
</script>
<script>
    "use strict";
    function extra_discount()
    {
        //let  user_id = $('#customer').val();
        let discount = $('#dis_amount').val();
        let type = $('#type_ext_dis').val();
        //let  cart_id = $('#cart_id').val();
        if(discount > 0)
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('seller.pos.discount')}}',
                data: {
                    _token: '{{csrf_token()}}',
                    discount:discount,
                    type:type,
                    //cart_id:cart_id
                },
                beforeSend: function () {
                    $('#loading').removeClass('d-none');
                },
                success: function (data) {
                   // console.log(data);
                    if(data.extra_discount==='success')
                    {
                        toastr.success('{{ \App\CPU\Helpers::translate('extra_discount_added_successfully') }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }else if(data.extra_discount==='empty')
                    {
                        toastr.warning('{{ \App\CPU\Helpers::translate('your_cart_is_empty') }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });

                    }else{
                        toastr.warning('{{ \App\CPU\Helpers::translate('this_discount_is_not_applied_for_this_amount') }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }

                    $('.modal-backdrop').addClass('d-none');
                    $('#cart').empty().html(data.view);

                    $('#search').focus();
                },
                complete: function () {
                    $('.modal-backdrop').addClass('d-none');
                    $(".footer-offset").removeClass("modal-open");
                    $('#loading').addClass('d-none');
                }
            });
        }else{
            toastr.warning('{{ \App\CPU\Helpers::translate('amount_can_not_be_negative_or_zero!') }}', {
                CloseButton: true,
                ProgressBar: true
            });
        }
    }
</script>
<script>
    "use strict";
    function coupon_discount()
    {

        let  coupon_code = $('#coupon_code').val();

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('seller.pos.coupon-discount')}}',
                data: {
                    _token: '{{csrf_token()}}',
                    coupon_code:coupon_code,
                },
                beforeSend: function () {
                    $('#loading').removeClass('d-none');
                },
                success: function (data) {
                    console.log(data);
                    if(data.coupon === 'success')
                    {
                        toastr.success('{{ \App\CPU\Helpers::translate('coupon_added_successfully') }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }else if(data.coupon === 'amount_low')
                    {
                        toastr.warning('{{ \App\CPU\Helpers::translate('this_discount_is_not_applied_for_this_amount') }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }else if(data.coupon === 'cart_empty')
                    {
                        toastr.warning('{{ \App\CPU\Helpers::translate('your_cart_is_empty') }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }
                    else {
                        toastr.warning('{{ \App\CPU\Helpers::translate('coupon_is_invalid') }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }

                    $('#cart').empty().html(data.view);

                    $('#search').focus();
                },
                complete: function () {
                    $('.modal-backdrop').addClass('d-none');
                    $(".footer-offset").removeClass("modal-open");
                    $('#loading').addClass('d-none');
                }
            });

    }
</script>
<script>
    $(document).on('ready', function () {
        @if($order)
        $('#print-invoice').modal('show');
        @endif
    });
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        // location.reload();
    }

    function set_category_filter(id) {
        var nurl = new URL('{!!url()->full()!!}');
        nurl.searchParams.set('category_id', id);
        location.href = nurl;
    }


    $('#search-form').on('submit', function (e) {
        e.preventDefault();
        var keyword= $('#datatableSearch').val();
        var nurl = new URL('{!!url()->full()!!}');
        nurl.searchParams.set('keyword', keyword);
        location.href = nurl;
    });

    function store_key(key, value) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            }
        });
        $.post({
            url: '{{route('seller.pos.store-keys')}}',
            data: {
                key:key,
                value:value,
            },
            success: function (data) {
                toastr.success(key+' '+'{{\App\CPU\Helpers::translate('selected')}}!', {
                    CloseButton: true,
                    ProgressBar: true
                });
            },
        });
    }

    function addon_quantity_input_toggle(e)
    {
        var cb = $(e.target);
        if(cb.is(":checked"))
        {
            cb.siblings('.addon-quantity-input').css({'visibility':'visible'});
        }
        else
        {
            cb.siblings('.addon-quantity-input').css({'visibility':'hidden'});
        }
    }
    function quickView(product_id) {
        $.ajax({
            url: '{{route('seller.pos.quick-view')}}',
            type: 'GET',
            data: {
                product_id: product_id
            },
            dataType: 'json', // added data type
            beforeSend: function () {
                $('#loading').show();
            },
            success: function (data) {
                // console.log("success...");
                // console.log(data);

                // $("#quick-view").removeClass('fade');
                // $("#quick-view").addClass('show');

                $('#quick-view').modal('show');
                $('#quick-view-modal').empty().html(data.view);
            },
            complete: function () {
                $('#loading').hide();
            },
        });
    }

    function checkAddToCartValidity() {
        var names = {};
        $('#add-to-cart-form input:radio').each(function () { // find unique names
            names[$(this).attr('name')] = true;
        });
        var count = 0;
        $.each(names, function () { // then count them
            count++;
        });

        if (($('input:radio:checked').length - 1) == count) {
            return true;
        }
        return false;
    }

    function cartQuantityInitialize() {
        $('.btn-number').click(function (e) {
            e.preventDefault();

            var fieldName = $(this).attr('data-field');
            var type = $(this).attr('data-type');
            var input = $("input[name=quantity]:eq(1)");
            var currentVal = parseInt(input.val());

            if (!isNaN(currentVal)) {
                if (type == 'minus') {

                    if (currentVal > input.attr('min')) {
                        input.val(currentVal - 1).change();
                    }
                    if (parseInt(input.val()) == input.attr('min')) {
                        $(this).attr('disabled', true);
                    }

                } else if (type == 'plus') {
                    if (currentVal < input.attr('max')) {
                        input.val(currentVal + 1).change();
                    }
                    if (parseInt(input.val()) == input.attr('max')) {
                        $(this).attr('disabled', true);
                    }

                }
            } else {
                input.val(0);
            }
        });

        $('.input-number').focusin(function () {
            $(this).data('oldValue', $(this).val());
        });

        $('.input-number').change(function () {

            minValue = parseInt($(this).attr('min'));
            maxValue = parseInt($(this).attr('max'));
            valueCurrent = parseInt($(this).val());

            var name = $(this).attr('name');
            if (valueCurrent >= minValue) {
                $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Cart',
                    text: 'Sorry, the minimum value was reached'
                });
                $(this).val($(this).data('oldValue'));
            }
            if (valueCurrent <= maxValue) {
                $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Cart',
                    text: 'Sorry, stock limit exceeded.'
                });
                $(this).val($(this).data('oldValue'));
            }
        });
        $(".input-number").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                // Allow: Ctrl+A
                (e.keyCode == 65 && e.ctrlKey === true) ||
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
    }

    function getVariantPrice() {
        if ($('#add-to-cart-form input[name=quantity]').val() > 0 && checkAddToCartValidity()) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: '{{ route('seller.pos.variant_price') }}',
                data: $('#add-to-cart-form').serializeArray(),
                success: function (data) {

                    $('#add-to-cart-form #chosen_price_div').removeClass('d-none');
                    $('#add-to-cart-form #chosen_price_div #chosen_price').html(data.price);
                    $('#set-discount-amount').html(data.discount);
                }
            });
        }
    }


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

    function removeFromCart(key) {
        //console.log(key);
        $.post('{{ route('seller.pos.remove-from-cart') }}', {_token: '{{ csrf_token() }}', key: key}, function (data) {

            $('#cart').empty().html(data.view);
            if (data.errors) {
                for (var i = 0; i < data.errors.length; i++) {
                    toastr.error(data.errors[i].message, {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            } else {
                //updateCart();

                toastr.info('{{ \App\CPU\Helpers::translate("Item has been removed from cart")}}', {
                    CloseButton: true,
                    ProgressBar: true
                });
            }


        });
    }

    function emptyCart() {
        Swal.fire({
            title: '{{\App\CPU\Helpers::translate('Are_you_sure?')}}',
            text: '{{\App\CPU\Helpers::translate('You_want_to_remove_all_items_from_cart!!')}}',
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: 'default',
            confirmButtonColor: '#161853',
            cancelButtonText: '{{\App\CPU\Helpers::translate("No")}}',
            confirmButtonText: '{{\App\CPU\Helpers::translate("Yes")}}',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.post('{{ route('seller.pos.emptyCart') }}', {_token: '{{ csrf_token() }}'}, function (data) {
                    $('#cart').empty().html(data.view);
                    toastr.info('{{ \App\CPU\Helpers::translate("Item has been removed from cart")}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                });
            }
        })
    }

    function updateCart() {
        $.post('<?php echo e(route('seller.pos.cart_items')); ?>', {_token: '<?php echo e(csrf_token()); ?>'}, function (data) {
            $('#cart').empty().html(data);
        });
    }

   $(function(){
        $(document).on('click','input[type=number]',function(){ this.select(); });
    });


    function updateQuantity(key,qty,e, variant=null){

        if(qty!==""){
            var element = $( e.target );
            var minValue = parseInt(element.attr('min'));
            // maxValue = parseInt(element.attr('max'));
            var valueCurrent = parseInt(element.val());

            //var key = element.data('key');

            $.post('{{ route('seller.pos.updateQuantity') }}', {_token: '{{ csrf_token() }}', key: key, quantity:qty, variant:variant}, function (data) {

                if(data.product_type==='physical' && data.qty<0)
                {
                    toastr.warning('{{\App\CPU\Helpers::translate('product_quantity_is_not_enough!')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
                if(data.upQty==='zeroNegative')
                {
                    toastr.warning('{{\App\CPU\Helpers::translate('Product_quantity_can_not_be_zero_or_less_than_zero_in_cart!')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
                if(data.qty_update==1){
                    toastr.success('{{\App\CPU\Helpers::translate('Product_quantity_updated!')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
                $('#cart').empty().html(data.view);
            });
        }else{
            var element = $( e.target );
            var minValue = parseInt(element.attr('min'));
            var valueCurrent = parseInt(element.val());

            $.post('{{ route('seller.pos.updateQuantity') }}', {_token: '{{ csrf_token() }}', key: key, quantity:minValue, variant:variant}, function (data) {

                if(data.product_type==='physical' && data.qty<0)
                {
                    toastr.warning('{{\App\CPU\Helpers::translate('product_quantity_is_not_enough!')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
                if(data.upQty==='zeroNegative')
                {
                    toastr.warning('{{\App\CPU\Helpers::translate('Product_quantity_can_not_be_zero_or_less_than_zero_in_cart!')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
                if(data.qty_update==1){
                    toastr.success('{{\App\CPU\Helpers::translate('Product_quantity_updated!')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
                $('#cart').empty().html(data.view);
            });
        }

        // Allow: backspace, delete, tab, escape, enter and .
        if(e.type == 'keydown')
        {
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                // Allow: Ctrl+A
                (e.keyCode == 65 && e.ctrlKey === true) ||
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        }

    };

    // INITIALIZATION OF SELECT2
    // =======================================================
    // $('.js-select2-custom').each(function () {
    //     var select2 = $.HSCore.components.HSSelect2.init($(this));
    // });
    var url = '{{route('seller.pos.shops')}}'
    $("#end_customers").on("change",function(e){
        if($(e.target).is(":checked")){
            url = '{{route('seller.pos.shops')}}'
        }else{
            url = '{{route('seller.pos.customers')}}'
        }
    })



    $('.js-data-example-ajax').select2({
        ajax: {
            url: url,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page,
                    end_customers: $("#end_customers").is(":checked"),
                };
            },
            processResults: function (data) {
                return {
                results: data
                };
            },
            __port: function (params, success, failure) {
                var $request = $.ajax(params);

                $request.then(success);
                $request.fail(failure);

                return $request;
            }
        }
    });

    $('#order_place').submit(function(eventObj) {
        if($('#customer').val())
        {
            $(this).append('<input type="hidden" name="user_id" value="'+$('#customer').val()+'" /> ');
        }
        return true;
    });

</script>
<!-- IE Support -->
<script>
    if (/MSIE \d|Trident.*rv:/.test(navigator.userAgent)) document.write('<script src="{{asset('public/assets/seller')}}/vendor/babel-polyfill/polyfill.min.js"><\/script>');
</script>
@endpush
