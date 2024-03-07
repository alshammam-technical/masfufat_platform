@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('Coupon Add'))

@push('css_or_js')
    <link href="{{ asset('public/assets/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{ asset('public/assets/back-end/css/custom.css')}}?v=2" rel="stylesheet">
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
                            <a>
                                {{Helpers::translate('coupon_setup')}}
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
    <!-- End Page Title -->

        <!-- Content Row -->
        <div class="row">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('admin.coupon.store-coupon')}}" method="post">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 col-lg-4 form-group">
                                    <label for="name" class="title-color font-weight-medium d-flex">{{\App\CPU\Helpers::translate('coupon_type')}}</label>
                                    <select class="form-control" id="coupon_type" name="coupon_type" required>
                                        <option disabled selected>{{\App\CPU\Helpers::translate('Select_coupon_type')}}</option>
                                        <option value="discount_on_purchase">{{\App\CPU\Helpers::translate('Discount_on_Purchase')}}</option>
                                        <option value="free_delivery">{{\App\CPU\Helpers::translate('Free_Delivery')}}</option>
                                        <option value="first_order">{{\App\CPU\Helpers::translate('First_Order')}}</option>
                                    </select>
                                </div>
                                <div class="col-md-6 col-lg-4 form-group">
                                    <label for="name" class="title-color font-weight-medium d-flex">{{\App\CPU\Helpers::translate('coupon_title')}}</label>
                                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" id="title"
                                           placeholder="{{\App\CPU\Helpers::translate('مثال: قسيمة اليوم الوطني')}}" required>
                                </div>
                                <div class="col-md-6 col-lg-4 form-group">
                                    <div class="d-flex justify-content-between">
                                        <label for="name" class="title-color font-weight-medium text-capitalize">{{\App\CPU\Helpers::translate('coupon_code')}}</label>
                                        <a href="javascript:void(0)" class="float-right c1 fz-12" onclick="generateCode()">{{\App\CPU\Helpers::translate('generate_code')}}</a>
                                    </div>
                                    <input type="text" name="code" value=""
                                           class="form-control" id="code"
                                           placeholder="{{\App\CPU\Helpers::translate('Ex')}}: EID100" required>
                                </div>
                                <div class="col-md-6 col-lg-4 form-group first_order">
                                    <label for="name" class="title-color font-weight-medium d-flex">{{\App\CPU\Helpers::translate('Coupon owner')}}</label>
                                    <select class="form-control" name="coupon_bearer" id="coupon_bearer" >
                                        <option disabled selected>{{\App\CPU\Helpers::translate('Select_coupon_owner')}}</option>
                                        <option value="seller">{{\App\CPU\Helpers::translate('seller')}}</option>
                                        <option value="inhouse">{{\App\CPU\Helpers::translate('admin')}}</option>
                                    </select>
                                </div>
                                <div class="col-md-6 col-lg-4 form-group coupon_by first_order">
                                    <label for="name" class="title-color font-weight-medium d-flex">{{\App\CPU\Helpers::translate('seller')}}</label>
                                    <select class="js-example-basic-multiple js-states js-example-responsive form-control" name="seller_id" id="seller_wise_coupon">
                                        <option disabled selected>{{\App\CPU\Helpers::translate('select seller')}}</option>
                                    </select>
                                </div>
                                <div class="col-md-6 col-lg-4 form-group coupon_type first_order">
                                    <label for="name" class="title-color font-weight-medium d-flex">{{\App\CPU\Helpers::translate('customer')}}</label>
                                    <select class="js-example-basic-multiple js-states js-example-responsive form-control" name="customer_id" >
                                        <option disabled selected>{{\App\CPU\Helpers::translate('Select customer')}}</option>
                                        <option value="0">{{\App\CPU\Helpers::translate('all customer')}}</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 col-lg-4 form-group first_order">
                                    <label
                                        for="exampleFormControlInput1" class="title-color font-weight-medium d-flex">{{\App\CPU\Helpers::translate('Number of times per customer')}}</label>
                                    <input type="number" name="limit" value="{{ old('limit') }}" min="0" id="coupon_limit" class="form-control"
                                           placeholder="{{\App\CPU\Helpers::translate('EX')}}: 10">
                                </div>
                                <div class="col-md-6 col-lg-4 form-group free_delivery">
                                    <label for="name" class="title-color font-weight-medium d-flex">{{\App\CPU\Helpers::translate('discount_type')}}</label>
                                    <select id="discount_type" class="form-control w-100" name="discount_type"
                                            onchange="checkDiscountType(this.value)">
                                        <option value="amount">{{\App\CPU\Helpers::translate('Amount')}}</option>
                                        <option value="percentage">{{\App\CPU\Helpers::translate('percentage (%)')}}</option>
                                    </select>
                                </div>
                                <div class="col-md-6 col-lg-4 form-group free_delivery">
                                    <label for="name" class="title-color font-weight-medium d-flex">{{\App\CPU\Helpers::translate('Discount_Amount')}} <span id="discount_percent"> (%)</span></label>
                                    <input type="number" min="1" max="1000000" name="discount" value="{{ old('discount') }}" class="form-control"
                                           id="discount"
                                           placeholder="{{\App\CPU\Helpers::translate('Ex: 500')}}">
                                </div>
                                <div class="col-md-6 col-lg-4 form-group">
                                    <label for="name" class="title-color font-weight-medium d-flex">{{\App\CPU\Helpers::translate('minimum_purchase (SAR)')}}</label>
                                    <input type="number" min="1" max="1000000" name="min_purchase" value="{{ old('min_purchase') }}" class="form-control"
                                        id="minimum purchase"
                                        placeholder="{{\App\CPU\Helpers::translate('Ex: 100')}}">
                                </div>
                                <div class="col-md-6 col-lg-4 form-group free_delivery" id="max-discount">
                                    <label for="name" class="title-color font-weight-medium d-flex">{{\App\CPU\Helpers::translate('maximum_discount (SAR)')}}</label>
                                    <input type="number" min="1" max="1000000" name="max_discount" value="{{ old('max_discount') }}"
                                        class="form-control" id="maximum discount"
                                        placeholder="{{\App\CPU\Helpers::translate('Ex: 5000')}}" >
                                </div>
                                <div class="col-md-6 col-lg-4 form-group">
                                    <label for="name" class="title-color font-weight-medium d-flex">{{\App\CPU\Helpers::translate('start_date')}}</label>
                                    <input id="start_date" type="date" name="start_date" value="{{ old('start_date') }}" class="form-control"
                                        placeholder="{{\App\CPU\Helpers::translate('start date')}}" required>
                                </div>
                                <div class="col-md-6 col-lg-4 form-group">
                                    <label for="name" class="title-color font-weight-medium d-flex">{{\App\CPU\Helpers::translate('expire_date')}}</label>
                                    <input id="expire_date" type="date" name="expire_date" value="{{ old('expire_date') }}" class="form-control"
                                        placeholder="{{\App\CPU\Helpers::translate('expire date')}}" required>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-end flex-wrap gap-10">
                                <button type="reset" class="btn btn-secondary px-4">{{\App\CPU\Helpers::translate('reset')}}</button>
                                <button type="submit" class="btn btn--primary px-4">{{\App\CPU\Helpers::translate('Submit')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-20">
            <div class="col-md-12">
                <div class="card">
                    <div class="px-3 py-4">
                        <div class="row justify-content-between align-items-center flex-grow-1">
                            <div class="col-sm-4 col-md-6 col-lg-8 mb-2 mb-sm-0">
                                <h5 class="mb-0 text-capitalize d-flex gap-2">
                                    {{\App\CPU\Helpers::translate('coupon_list')}}
                                    <span class="badge badge-soft-dark radius-50 fz-12 ml-1">{{ $cou->total() }}</span>
                                </h5>
                            </div>
                            <div class="col-sm-8 col-md-6 col-lg-4">
                                <!-- Search -->
                                <form action="{{ url()->current() }}" method="GET">
                                    <div class="input-group input-group-merge input-group-custom">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tio-search"></i>
                                            </div>
                                        </div>
                                        <input id="datatableSearch_" type="search" name="search" class="form-control"
                                               placeholder="{{\App\CPU\Helpers::translate('Search by Title or Code or Discount Type')}}"
                                               value="{{ $search }}" aria-label="Search orders" required>
                                        <button type="submit" class="btn btn--primary">{{\App\CPU\Helpers::translate('search')}}</button>
                                    </div>
                                </form>
                                <!-- End Search -->
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="datatable"
                                class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table {{ Session::get('direction') === 'rtl' ? 'text-right' : 'text-left' }}">
                            <thead class="thead-light thead-50 text-capitalize">
                            <tr>
                                <th>{{\App\CPU\Helpers::translate('SL')}}</th>
                                <th>{{\App\CPU\Helpers::translate('coupon')}}</th>
                                <th>{{\App\CPU\Helpers::translate('coupon_type')}}</th>
                                <th>{{\App\CPU\Helpers::translate('Duration')}}</th>
                                <th>{{\App\CPU\Helpers::translate('user_limit')}}</th>
                                <th>{{\App\CPU\Helpers::translate('discount_bearer')}}</th>
                                <th>{{\App\CPU\Helpers::translate('Status')}}</th>
                                <th class="text-center">{{\App\CPU\Helpers::translate('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cou as $k=>$c)
                                <tr>
                                    <td >{{$cou->firstItem() + $k}}</td>
                                    <td>
                                        <div>{{substr($c['title'],0,20)}}</div>
                                        <strong>{{\App\CPU\Helpers::translate('coupon_code')}}: {{$c['code']}}</strong>
                                    </td>
                                    <td class="text-capitalize">{{\App\CPU\Helpers::translate(str_replace('_',' ',$c['coupon_type']))}}</td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            <span>{{date('Y/m/d',strtotime($c['start_date']))}} - </span>
                                            <span>{{date('Y/m/d',strtotime($c['expire_date']))}}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span>{{\App\CPU\Helpers::translate('Frequency of use')}} : <strong>{{ $c['limit'] }},</strong></span>
                                        <span class="ml-1">{{\App\CPU\Helpers::translate('Used')}} : <strong>{{ $c['order_count'] }}</strong></span>
                                    </td>
                                    <td>{{ Helpers::translate($c['coupon_bearer'] == 'inhouse' ? 'admin':$c['coupon_bearer']) }}</td>
                                    <td>
                                        <label class="switcher">
                                            <input type="checkbox" class="switcher_input"
                                                    onclick="location.href='{{route('admin.coupon.status',[$c['id'],$c->status?0:1])}}'"
                                                    class="toggle-switch-input" {{$c->status?'checked':''}}>
                                            <span class="switcher_control"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-10 justify-content-center">
                                            <button class="btn btn-outline--primary square-btn btn-sm mr-1" onclick="get_details(this)" data-id="{{ $c['id'] }}" data-toggle="modal" data-target="#exampleModalCenter">
                                                <img src="{{asset('/public/assets/back-end/img/eye.svg')}}" class="svg" alt="">
                                            </button>
                                            <a class="btn btn-outline--primary btn-sm edit"
                                            href="{{route('admin.coupon.update',[$c['id']])}}"
                                            title="{{ \App\CPU\Helpers::translate('Edit')}}"
                                            >
                                                <i class="tio-edit"></i>
                                            </a>
                                            <a class="btn btn-outline-danger btn-sm delete"
                                                href="javascript:"
                                                onclick="form_alert('coupon-{{$c['id']}}','Want to delete this coupon ?')"
                                                title="{{\App\CPU\Helpers::translate('delete')}}"
                                                >
                                                <i class="tio-delete"></i>
                                            </a>
                                            <form action="{{route('admin.coupon.delete',[$c['id']])}}"
                                                method="post" id="coupon-{{$c['id']}}">
                                                @csrf @method('delete')
                                            </form>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="modal fade" id="quick-view" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered coupon-details" role="document">
                                <div class="modal-content" id="quick-view-modal">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive mt-4">
                        <div class="px-4 d-flex justify-content-lg-end">
                            <!-- Pagination -->
                            {{$cou->links()}}
                        </div>
                    </div>

                    @if(count($cou)==0)
                        <div class="text-center p-4">
                            <img class="mb-3 w-160" src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg"
                                 alt="Image Description">
                            <p class="mb-0">{{\App\CPU\Helpers::translate('No data to show')}}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>

    $(document).ready(function() {
            generateCode();

            $('#discount_percent').hide();
            let discount_type = $('#discount_type').val();
            if (discount_type == 'amount') {
                $('#max-discount').hide()
            } else if (discount_type == 'percentage') {
                $('#max-discount').show()
            }

            $('#start_date').attr('min',(new Date()).toISOString().split('T')[0]);
            $('#expire_date').attr('min',(new Date()).toISOString().split('T')[0]);
        });

        $("#start_date").on("change", function () {
            $('#expire_date').attr('min',$(this).val());
        });

        $("#expire_date").on("change", function () {
            $('#start_date').attr('max',$(this).val());
        });

        function get_details(t){
            let id = $(t).data('id')

            $.ajax({
                type: 'GET',
                url: '{{route('admin.coupon.quick-view-details')}}',
                data: {
                    id: id
                },
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#loading').hide();
                    $('#quick-view').modal('show');
                    $('#quick-view-modal').empty().html(data.view);
                }
            });
        }

        function checkDiscountType(val) {
            if (val == 'amount') {
                $('#max-discount').hide()
            } else if (val == 'percentage') {
                $('#max-discount').show()
            }
        }

        function  generateCode(){
            let code = Math.random().toString(36).substring(2,12);
            $('#code').val(code)
        }


</script>

    <script src="{{asset('public/assets/back-end')}}/js/select2.min.js"></script>
    <script>
        $(".js-example-theme-single").select2({
            theme: "classic"
        });

        $(".js-example-responsive").select2({
            width: 'resolve'
        });
    </script>

    <!-- Page level plugins -->
    <script src="{{asset('public/assets/back-end')}}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset('public/assets/back-end')}}/js/demo/datatables-demo.js"></script>

<script>
    $('#discount_type').on('change', function (){
        let type = $('#discount_type').val();
        if(type === 'amount'){
            $('#discount').attr({
                'placeholder': 'Ex: 500',
                "max":"1000000"
            });
            $('#discount_percent').hide();
        }else if(type === 'percentage'){
            $('#discount').attr({
                "max":"100",
                "placeholder":"Ex: 10%"
            });
            $('#discount_percent').show();
        }
    });
    $('#coupon_bearer').on('change', function (){
        let coupon_bearer = $('#coupon_bearer').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '{{route('admin.coupon.ajax-get-seller')}}',
            data: {
                coupon_bearer: coupon_bearer
            },
            success: function (result) {
                $("#seller_wise_coupon").html(result);
            }
        });
    });

    $('#coupon_type').on('change', function (){
        let discount_type = $('#discount_type').val();
        let type = $('#coupon_type').val();

        if(type === 'free_delivery'){
            if (discount_type === 'amount') {
                $('.first_order').show();
                $('.free_delivery').hide();
            } else if (discount_type === 'percentage') {
                $('.first_order').show();
                $('.free_delivery').hide();
            }
        }else if(type === 'first_order'){
            if (discount_type === 'amount') {
                $('.free_delivery').show();
                $('.first_order').hide();
                $('#max-discount').hide()
            } else if (discount_type === 'percentage') {
                $('.free_delivery').show();
                $('.first_order').hide();
                $('#max-discount').show()
            }
        }else{
            if (discount_type === 'amount') {
                $('.first_order').show();
                $('.free_delivery').show();
                $('#max-discount').hide()
            } else if (discount_type === 'percentage') {
                $('.first_order').show();
                $('.free_delivery').show();
                $('#max-discount').show()
            }
        }
    });
</script>
@endpush
