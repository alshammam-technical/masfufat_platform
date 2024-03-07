@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('Deal Of The Day'))

@push('css_or_js')
    <link href="{{ asset('public/assets/select2/css/select2.min.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="content container-fluid">
    <!-- Page Title -->
    <div class="mb-3">
        <h2 class="h1 mb-0 text-capitalize d-flex gap-2">
            <img width="20" src="{{asset('/public/assets/back-end/img/deal_of_the_day.png')}}" alt="">
            {{\App\CPU\Helpers::translate('deal_of_the_day')}}
        </h2>
    </div>
    <!-- End Page Title -->
    @php
        $language=\App\Model\BusinessSetting::where('type','pnc_language')->first();
        $language = $language->value ?? null;
        $language = json_decode($language);
        $default_lang = session()->get('local');
        if (($key = array_search($default_lang, $language)) !== false) {
            unset($language[$key]);
        }
        array_unshift($language,$default_lang);
        $language = json_encode($language);
    @endphp
    <!-- Content Row -->
    @if(Helpers::module_permission_check('marketing.deal.day.add'))
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.deal.day')}}" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};" method="post">
                        @csrf
                        @php
                                                $language=\App\Model\BusinessSetting::where('type','pnc_language')->first();
                                                $language = $language->value ?? null;
                                                $language = json_decode($language);
                                                $default_lang = session()->get('local');
                                                if (($key = array_search($default_lang, $language)) !== false) {
                                                    unset($language[$key]);
                                                }
                                                array_unshift($language,$default_lang);
                                                $language = json_encode($language);
                                            @endphp

                        @php($default_lang = json_decode($language)[0])
                        <ul class="nav nav-tabs lightSlider w-fit-content mb-4">
                            @foreach(Helpers::get_langs() as $lang)
                                <li class="nav-item text-capitalize">
                                    <a class="nav-link lang_link {{$lang == ($default_lang ?? session()->get('local')) ? 'active':''}}"
                                       href="#"
                                       id="{{$lang}}-link"><img class="ml-2" width="20" src="{{asset('public/assets/front-end')}}/img/flags/{{$lang}}.png">{{\App\CPU\Helpers::get_language_name($lang).'('.strtoupper($lang).')'}}</a>
                                </li>
                            @endforeach
                        </ul>

                        <div class="form-group">
                            @foreach(Helpers::get_langs() as $lang)
                                <div class="row {{$lang != $default_lang ? 'd-none':''}} lang_form" id="{{$lang}}-form">
                                    <div class="col-md-12">
                                        <label for="name">{{ \App\CPU\Helpers::translate('Todays offer list display name')}} ({{strtoupper($lang)}})</label>
                                        <input type="text" name="title[]" class="form-control" id="title"
                                               placeholder="{{\App\CPU\Helpers::translate('Ex')}} : {{\App\CPU\Helpers::translate('LUX')}}"
                                               {{$lang == ($default_lang ?? session()->get('local')) ? 'required':''}}>
                                    </div>
                                </div>
                                <input type="hidden" name="lang[]" value="{{$lang}}" id="lang">
                            @endforeach
                            <div class="row">
                                <div class="col-md-12 mt-3">
                                    <label for="name" class="title-color">{{ \App\CPU\Helpers::translate('choose the product')}}</label>
                                    <select
                                        class="js-example-basic-multiple js-states js-example-responsive form-control"
                                        name="product_id">
                                        <option value="" disabled selected>
                                            {{ \App\CPU\Helpers::translate('choose the product')}}
                                        </option>
                                        @foreach (\App\Model\Product::orderBy('name', 'asc')->get() as $key => $product)
                                            <option value="{{ $product->id }}">
                                                {{$product['name']}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <button type="reset" id="reset" class="btn btn-secondary">{{ \App\CPU\Helpers::translate('reset')}}</button>
                            <button type="submit" class="btn btn--primary btn-primary">{{ \App\CPU\Helpers::translate('submit')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row mt-20">
        <div class="col-md-12">
            <div class="card">
                <div class="px-3 py-4">
                    <div class="row align-items-center">
                        <div class="col-sm-4 col-md-6 col-lg-8 mb-2 mb-sm-0">
                            <h5 class="d-flex align-items-center gap-2">
                                {{ \App\CPU\Helpers::translate('offer_of_the_day lists')}}
                                <span class="badge badge-soft-dark radius-50 fz-12">{{ $deals->total() }}</span>
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
                                        placeholder="{{\App\CPU\Helpers::translate('Search by offer of the day list display name')}}" aria-label="Search orders" value="{{ $search }}" required>
                                    <button type="submit" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('search')}}</button>
                                </div>
                            </form>
                            <!-- End Search -->
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                            class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                        <thead class="thead-light thead-50 text-capitalize">
                        <tr>
                            <th>{{ \App\CPU\Helpers::translate('SL')}}</th>
                            <th>{{ \App\CPU\Helpers::translate('Todays offer list display name')}}</th>
                            <th>{{ \App\CPU\Helpers::translate('product name')}}</th>
                            <th>{{ \App\CPU\Helpers::translate('status')}}</th>
                            <th class="text-center">{{ \App\CPU\Helpers::translate('action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($deals as $k=>$deal)
                            <tr>
                                <th>{{$deals->firstItem()+ $k}}</th>
                                <td><a href="#" target="_blank" class="font-weight-semibold title-color hover-c1">{{$deal['title']}}</a></td>

                                <td>{{isset($deal->product)==true?$deal->product->name:'\App\CPU\Helpers::translate("not selected")'}}</td>

                                <td>
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher_input status"
                                                id="{{$deal['id']}}" {{$deal->status == 1?'checked':''}}>
                                        <span class="switcher_control"></span>
                                    </label>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-10">
                                        <a  title="{{ trans ('Edit')}}"
                                            href="{{route('admin.deal.day-update',[$deal['id']])}}"
                                            class="btn btn-outline--primary btn-sm edit">

                                            <i class="tio-edit"></i>
                                        </a>
                                        <a  title="{{ trans ('Delete')}}"
                                            class="btn btn-outline-danger btn-sm delete"
                                            id="{{$deal['id']}}">
                                            <i class="tio-delete"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="table-responsive mt-4">
                    <div class="px-4 d-flex justify-content-lg-end">
                        <!-- Pagination -->
                        {{$deals->links()}}
                    </div>
                </div>

                @if(count($deals)==0)
                    <div class="text-center p-4">
                        <img class="mb-3 w-160" src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg" alt="Image Description">
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
        $(".lang_link").click(function (e) {
            e.preventDefault();
            $(".lang_link").removeClass('active');
            $(".lang_form").addClass('d-none');
            $(this).addClass('active');

            let form_id = this.id;
            let lang = form_id.split("-")[0];
            console.log(lang);
            $("#" + lang + "-form").removeClass('d-none');
            if (lang == '{{$default_lang}}') {
                $(".from_part_2").removeClass('d-none');
            } else {
                $(".from_part_2").addClass('d-none');
            }
        });
    </script>

    <script src="{{asset('public/assets/back-end')}}/js/select2.min.js"></script>
    <script>
        $(".js-example-theme-single").select2({
            theme: "classic"
        });

        $(".js-example-responsive").select2({
            width: 'resolve'
        });

        // Call the dataTables jQuery plugin
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });

        $(document).on('change', '.status', function () {
            var id = $(this).attr("id");
            if ($(this).prop("checked") == true) {
                var status = 1;
            } else if ($(this).prop("checked") == false) {
                var status = 0;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.deal.day-status-update')}}",
                method: 'POST',
                data: {
                    id: id,
                    status: status
                },
                success: function (data) {
                    if(data == 1){
                        toastr.success('{{ Helpers::translate('Status updated successfully')}}');
                    }else{
                        toastr.error("{{ Helpers::translate('Access Denied !') }}")
                    }
                    location.reload();
                }
            });
        });
    </script>

    <script>
        $(document).on('click', '.delete', function () {
            var id = $(this).attr("id");
            Swal.fire({
                title: "{{\App\CPU\Helpers::translate('Are_you_sure_delete_this')}}?",
                text: "{{\App\CPU\Helpers::translate('You_will_not_be_able_to_revert_this')}}!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{\App\CPU\Helpers::translate('Yes')}}, {{\App\CPU\Helpers::translate('delete_it')}}!',
                type: 'warning',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{route('admin.deal.day-delete')}}",
                        method: 'POST',
                        data: {id: id},
                        success: function () {
                            toastr.success('{{\App\CPU\Helpers::translate('Banner_deleted_successfully')}}');
                            location.reload();
                        }
                    });
                }
            })
        });
    </script>
@endpush
