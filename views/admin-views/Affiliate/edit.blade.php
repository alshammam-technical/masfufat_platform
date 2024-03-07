@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('Edit'))

@push('css_or_js')
    <link href="{{asset('public/assets/back-end')}}/css/select2.min.css" rel="stylesheet"/>
    <link href="{{asset('public/assets/back-end/css/croppie.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="content container-fluid">
    <!-- Page Title -->
    <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
        <h2 class="h1 mb-0 align-items-center d-flex gap-2">
            <img width="20" src="{{asset('/public/assets/back-end/img/package.png')}}" alt="">
            {{\App\CPU\Helpers::translate('Edit')}}
        </h2>
    </div>

    <div class="col-lg-7" style="display: none">
        <div class="d-flex table-actions flex-wrap justify-content-end mx-3">
            <div class="d-flex">
            <a title="{{Helpers::translate('Add new')}}" class="btn ti-plus btn-success my-2 btn-icon-text m-2" href="{{route('admin.Affiliate.add-new')}}">
                <i class="fa fa-plus"></i>
            </a>
            <button title="{{Helpers::translate('Add from')}}" class="btn btn-info mdi mdi-arrange-bring-forward btnAddFrom my-2 btn-icon-text m-2">
                <i class="fa fa-clone"></i>
            </button>

            <button class="btn ti-save btn-success my-2 btn-icon-text m-2 "
            onclick="$('.btn-save').click()">
                <i class="fa fa-save"></i>
            </button>


            <button title="{{Helpers::translate('Delete')}}" class="btnDeleteRow btn ti-trash btn-danger my-2 btn-icon-text m-2"
            onclick="form_alert('bulk-delete','Want to delete this item ?')"
            >
                <i class="fa fa-trash"></i>
            </button>
            <button title="{{Helpers::translate('show/hide columns')}}" class="btn buttons-collection dropdown-toggle buttons-colvis d-none btn-primary my-2 btn-icon-text m-2">
                <i class="fa fa-toggle"></i>
            </button>
            </div>
            <div class="moreOptions justify-content-center mt-2 mr-2 ml-4">
                <div class="dropdown dropdown">
                    <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary dropdown-toggle" data-toggle="dropdown" id="droprightMenuButton" type="button" style="height:43px">
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
                        <a aria-expanded="false" aria-haspopup="true" class="dropdown-item bulk-import-export dropdown-toggle" data-toggle="dropdown" id="droprightMenuButton" type="button"
                        onclick='$(".dt-button-collection").remove();'>
                            <i class="ti-angle-down"></i>
                            {{\App\CPU\Helpers::translate('Import/Export')}}
                        </a>
                        <div aria-labelledby="droprightMenuButton" class="dropdown-menu tx-13" style="position: absolute;will-change: transform;top: -10%;left: -100%;transform: translate3d(0px, 145px, 0px);">

                            <a class="dropdown-item bulk-export" href="{{route('admin.Affiliate.bulk-export')}}">
                                {{\App\CPU\Helpers::translate('export to excel')}}
                            </a>
                            <a class="dropdown-item bulk-import" href="{{route('admin.Affiliate.bulk-import')}}">
                                {{\App\CPU\Helpers::translate('import from excel')}}
                            </a>
                        </div>
                    </div>
                </div>

            </div>
            <div>
            <label class="input-group mt-2" style="height: 34px">
                <input
                type="search"
                class="form-control form-control-sm"
                placeholder="..."
                style="border-radius:0px 6px 6px 0px !important;height: 43px"
                onkeyup="globalSearch(event.target.value)"
                >
                <button class="btn search-btn btn-primary" onclick="productsDTsearch()" style="border-radius:6px 0px 0px 6px !important;margin-top:1px">
                <i class="fa fa-search"></i>
                </button>
            </label>
            </div>
        </div>
    </div>
    <!-- End Page Title -->

    {{--  @isset($b['id'])  --}}
    <div class="row my-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <form>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-control p-0">
                                    <select name="filter_type" class="SumoSelect-custom" onchange="$('.form_filter').hide();$('.form_filter_'+$(this).val()).show()">
                                        <option value="daily">{{ Helpers::translate('daily') }}</option>
                                        <option value="weekly">{{ Helpers::translate('weekly') }}</option>
                                        <option value="monthly">{{ Helpers::translate('monthly') }}</option>
                                        <option value="yearly">{{ Helpers::translate('yearly') }}</option>
                                        <option value="from_beginning">{{ Helpers::translate('from_beginning') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-5 form_filter form_filter_daily">
                                <input type="date" class="form-control filter_day" />
                            </div>

                            <div class="col-lg-5 form_filter form_filter_weekly" style="display: none">
                                <div class="form-control p-0">
                                    <select class="SumoSelect-custom" name="filter_week">
                                        <option value="this_week">{{ Helpers::translate('this weeek') }}</option>
                                        <option value="this_week">{{ Helpers::translate('past weeek') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3 form_filter form_filter_monthly" style="display: none">
                                <div class="form-control p-0">
                                    <select class="SumoSelect-custom" name="filter_monthly">
                                        <option value="january">{{ Helpers::translate('January') }}</option>
                                        <option value="february">{{ Helpers::translate('February') }}</option>
                                        <option value="march">{{ Helpers::translate('March') }}</option>
                                        <option value="april">{{ Helpers::translate('April') }}</option>
                                        <option value="may">{{ Helpers::translate('May') }}</option>
                                        <option value="june">{{ Helpers::translate('June') }}</option>
                                        <option value="july">{{ Helpers::translate('July') }}</option>
                                        <option value="august">{{ Helpers::translate('August') }}</option>
                                        <option value="september">{{ Helpers::translate('September') }}</option>
                                        <option value="october">{{ Helpers::translate('October') }}</option>
                                        <option value="november">{{ Helpers::translate('November') }}</option>
                                        <option value="december">{{ Helpers::translate('December') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-2 form_filter form_filter_monthly" style="display: none">
                                <div class="form-control p-0">
                                    <select class="SumoSelect-custom" name="filter_m_year">
                                        @for($i = \Carbon\Carbon::now()->year; $i >= \Carbon\Carbon::now()->year - 8; $i--)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-5 form_filter form_filter_yearly" style="display: none">
                                <div class="form-control p-0">
                                    <select class="SumoSelect-custom" name="filter_year">
                                        @for($i = \Carbon\Carbon::now()->year; $i >= \Carbon\Carbon::now()->year - 8; $i--)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-5 form_filter form_filter_from_beginning" style="display: none">

                            </div>

                            <div class="col-lg-1">
                                <button class="btn btn-success">{{ Helpers::translate('Show') }}</button>
                            </div>
                        </div>
                    </form>
                    <div class="row mt-3">
                        <div class="col-3">
                            <div class="row">
                                <center class="w-100 text-center justify-content-center">
                                    <i class="h1 fa fa-ticket"></i>
                                </center>
                            </div>
                            <div class="row">
                                <center class="w-100 text-center justify-content-center">
                                    <div class="ticket-total cm-strong h2">{{$st['using_times'] ?? '0'}}</div>
                                </center>
                            </div>

                            <div class="row">
                                <center class="w-100 text-center justify-content-center">
                                    <p class="h2"> {{ Helpers::translate('times used') }} </p>
                                </center>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="row">
                                <center class="w-100 text-center justify-content-center">
                                    <i class="h1 tio-money"></i>
                                </center>
                            </div>
                            <div class="row">
                                <center class="w-100 text-center justify-content-center">
                                    <div class="money-total cm-strong h2">{{$st['total_earning'] ?? '0'}}</div>
                                </center>
                            </div>

                            <div class="row">
                                <center class="w-100 text-center justify-content-center">
                                    <p class="h2"> {{ Helpers::translate('earning total') }} </p>
                                </center>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="row">
                                <center class="w-100 text-center justify-content-center">
                                    <i class="h1 tio-shopping-cart"></i>
                                </center>
                            </div>
                            <div class="row">
                                <center class="w-100 text-center justify-content-center">
                                    <div class="cart-total cm-strong h2">{{$st['total_selling'] ?? '0'}}</div>
                                </center>
                            </div>

                            <div class="row">
                                <center class="w-100 text-center justify-content-center">
                                    <p class="h2"> {{ Helpers::translate('selling total') }} </p>
                                </center>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="row">
                                <center class="w-100 text-center justify-content-center">
                                    <i class="h1 fa fa-user"></i>
                                </center>
                            </div>
                            <div class="row">
                                <center class="w-100 text-center justify-content-center">
                                    <div class="user-total cm-strong h2">{{$st['new_customers'] ?? '0'}}</div>
                                </center>
                            </div>

                            <div class="row">
                                <center class="w-100 text-center justify-content-center">
                                    <p class="h2"> {{ Helpers::translate('new customers') }} </p>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--  @endisset  --}}

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <form action="{{$b['id'] ? route('admin.Affiliate.store',['id' => $b['id'] ?? null]) : route('admin.Affiliate.add-new')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="title-color" for="name">{{ \App\CPU\Helpers::translate('marketer_name')}}</label>
                                    <input type="text" name="marketer_name"
                                    value="{{ $b['marketer_name'] ?? '' }}"
                                            class="form-control" id="marketer_name"
                                            placeholder="{{ \App\CPU\Helpers::translate('marketer_name')}}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="title-color" for="name">{{ \App\CPU\Helpers::translate('marketer_email')}}</label>
                                    <input type="text" name="marketer_email"
                                    value="{{ $b['marketer_email'] ?? '' }}"
                                            class="form-control" id="marketer_email"
                                            placeholder="{{ \App\CPU\Helpers::translate('marketer_email')}}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="title-color" for="name">{{ \App\CPU\Helpers::translate('marketer_city')}}</label>
                                    <input type="text" name="marketer_city"
                                    value="{{ $b['marketer_city'] ?? '' }}"
                                            class="form-control" id="marketer_city"
                                            placeholder="{{ \App\CPU\Helpers::translate('marketer_city')}}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="title-color" for="name">{{ \App\CPU\Helpers::translate('notes')}}</label>
                                    <input type="text" name="notes"
                                    value="{{ $b['notes'] ?? '' }}"
                                            class="form-control" id="notes"
                                            placeholder="{{ \App\CPU\Helpers::translate('notes')}}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="title-color" for="name">{{ \App\CPU\Helpers::translate('commission_type')}}</label>
                                    <div class="form-control p-0">
                                        <select name="commission_type" class="SumoSelect-custom" onchange="$('.type').hide();$('.type_'+$(this).val()).show()">
                                            <option @if($b['commission_type'] == "static") selected @endif value="static">{{ Helpers::translate('fixed amount') }}</option>
                                            <option @if($b['commission_type'] == "percent") selected @endif value="percent">{{ Helpers::translate('percent') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 type type_static" @if(isset($b['commission_type']) && $b['commission_type'] !== "static") style="display: none" @endif>
                                <div class="form-group">
                                    <label class="title-color" for="name">{{ \App\CPU\Helpers::translate('the amount')}}</label>
                                    <input type="text" name="amount"
                                    value="{{ $b['amount'] ?? '' }}"
                                            class="form-control" id="amount"
                                            placeholder="{{ \App\CPU\Helpers::translate('the amount')}}" />
                                </div>
                            </div>
                            <div class="col-md-6 type type_percent" @if($b['commission_type'] !== "percent") style="display: none" @endif>
                                <div class="form-group">
                                    <label class="title-color" for="name">{{ \App\CPU\Helpers::translate('percentage')}}</label>
                                    <input type="text" name="percent"
                                    value="{{ $b['percent'] ?? '' }}"
                                            class="form-control" id="percent"
                                            placeholder="{{ \App\CPU\Helpers::translate('percentage')}}" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="title-color" for="name">{{ \App\CPU\Helpers::translate('apply_to')}}</label>
                                    <div class="form-control p-0">
                                        <select name="apply_to" class="SumoSelect-custom">
                                            <option value="all_orders">{{ Helpers::translate('all orders') }}</option>
                                            <option value="first_order">{{ Helpers::translate('first order only') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="title-color" for="name">{{ \App\CPU\Helpers::translate('show_total_sales')}}</label>
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher_input" name="show_total_sales"
                                        id="s_{{$b['id']}}" {{$b->show_total_sales == 'on'?'checked':''}}>
                                        <span class="switcher_control"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3" hidden>
                            <button type="submit" class="btn btn--primary btn-primary px-4 btn-save" hidden>{{ \App\CPU\Helpers::translate('update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--modal-->
    @include('shared-partials.image-process._image-crop-modal',['modal_id'=>'package-image-modal','width'=>1000,'margin_left'=>'-53%'])
    <!--modal-->
</div>
@endsection

@push('script')
<script>
    <script src="{{asset('public/assets/back-end')}}/js/select2.min.js"></script>
    <script>
        $(".js-example-theme-single").select2({
            theme: "classic"
        });

        $(".js-example-responsive").select2({
            width: 'resolve'
        });
    </script>

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileUpload").change(function () {
            readURL(this);
        });
    </script>
@endpush
