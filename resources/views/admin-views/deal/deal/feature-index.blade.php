@extends('layouts.back-end.app')
@section('title', \App\CPU\Helpers::translate('featured_deal'))
@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex gap-2">
                {{\App\CPU\Helpers::translate('featured_deal')}}
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
        @if(Helpers::module_permission_check('marketing.deal.feature.add'))
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('admin.deal.flash')}}" style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};" method="post">
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
                            <ul class="nav nav-tabs lightSlider sm:w-fit-content w-full mb-0 px-6">
                                @foreach(Helpers::get_langs() as $lang)
                                    <li class="nav-item text-capitalize">
                                        <a class="nav-link lang_link {{$lang == ($default_lang ?? session()->get('local')) ? 'active':''}}" href="#"
                                           id="{{$lang}}-link"><img class="ml-2" width="20" src="{{asset('public/assets/front-end')}}/img/flags/{{$lang}}.png">
                                           {{\App\CPU\Helpers::get_language_name($lang).'('.strtoupper($lang).')'}}</a>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="form-group">
                                <div class="row">
                                    <input type="text" name="deal_type" value="feature_deal"  class="d-none">
                                    @foreach(Helpers::get_langs() as $lang)
                                        <div class="col-md-12 {{$lang != $default_lang ? 'd-none':''}} lang_form" id="{{$lang}}-form">
                                            <label for="name" class="title-color text-capitalize">{{ \App\CPU\Helpers::translate('feature_deals group name')}} ({{strtoupper($lang)}})</label>
                                            <input type="text" name="title[]" class="form-control" id="title"
                                                   placeholder="{{\App\CPU\Helpers::translate('Ex')}} : {{\App\CPU\Helpers::translate('LUX')}}" {{$lang == ($default_lang ?? session()->get('local')) ? 'required':''}}>
                                        </div>
                                        <input type="hidden" name="lang[]" value="{{$lang}}" id="lang">
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mt-3">
                                        <label for="name" class="title-color text-capitalize">{{ \App\CPU\Helpers::translate('Special offers start date')}}</label>
                                        <input type="date" name="start_date" required class="form-control">
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <label for="name" class="title-color text-capitalize">{{ \App\CPU\Helpers::translate('Special offers end date')}}</label>
                                        <input type="date" name="end_date" required class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-3">
                                <button type="submit" class="btn bg-primaryColor btn-primary bg-primaryColor w-full sm:w-auto">{{ \App\CPU\Helpers::translate('submit')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <!--modal-->

        <div class="row mt-20">
            <div class="col-md-12">
                <div class="card">
                    <div class="px-3 py-4">
                        <div class="row align-items-center">
                            <div class="col-sm-4 col-md-6 col-lg-8 mb-2 mb-sm-0">
                                <h5 class="mb-0 text-capitalize align-items-center d-flex gap-2">
                                    {{ \App\CPU\Helpers::translate('feature_deals groups list')}}
                                    <span class="badge badge-soft-dark radius-50 fz-12">{{ $flash_deals->total() }}</span>
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
                                               placeholder="{{\App\CPU\Helpers::translate('Search by feature_deals group name')}}" aria-label="Search orders" value="{{ $search }}" required>
                                        <button type="submit" class="btn bg-primaryColor btn-primary bg-primaryColor">{{\App\CPU\Helpers::translate('search')}}</button>
                                    </div>
                                </form>
                                <!-- End Search -->
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="datatable"
                                style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};"
                                class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-full">
                            <thead class="thead-light thead-50 text-capitalize">
                            <tr>
                                <th>{{ \App\CPU\Helpers::translate('SL')}}</th>
                                <th>{{ \App\CPU\Helpers::translate('feature_deals group name')}}</th>
                                <th>{{ \App\CPU\Helpers::translate('Special offers start date')}}</th>
                                <th>{{ \App\CPU\Helpers::translate('Special offers end date')}}</th>
                                <th>{{ \App\CPU\Helpers::translate('active / expired')}}</th>
                                <th>{{ \App\CPU\Helpers::translate('status')}}</th>
                                <th class="text-center">{{ \App\CPU\Helpers::translate('action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($flash_deals as $k=>$deal)
                                <tr>
                                    <th>{{$k+1}}</th>
                                    <td>{{$deal['title']}}</td>
                                    <td>{{date('Y/m/d',strtotime($deal['start_date']))}}</td>
                                    <td>{{date('Y/m/d',strtotime($deal['end_date']))}}</td>
                                    <td>
                                        @if(\Carbon\Carbon::parse($deal['end_date'])->endOfDay()->isPast())
                                        <span class="badge badge-soft-danger"> {{ \App\CPU\Helpers::translate('expired')}} </span>
                                        @else
                                        <span class="badge badge-soft-success"> {{ \App\CPU\Helpers::translate('active')}} </span>
                                        @endif
                                    </td>
                                    <td>
                                        <label class="switcher">
                                            <input type="checkbox" class="switcher_input status"
                                                    id="{{$deal['id']}}" {{$deal->status == 1?'checked':''}}>
                                            <span class="switcher_control"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center gap-10">
                                            <a class="h-30 d-flex gap-2 align-items-center btn btn-soft-info btn-sm border-info" href="{{route('admin.deal.add-product',[$deal['id']])}}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 9 9" fill="none" class="svg replaced-svg">
                                                    <path d="M9 3.9375H5.0625V0H3.9375V3.9375H0V5.0625H3.9375V9H5.0625V5.0625H9V3.9375Z" fill="#00A3AD"></path>
                                                </svg>
                                                {{ Helpers::translate('Add Product') }}
                                            </a>

                                            <a title="{{ trans ('Edit')}}" href="{{route('admin.deal.edit',[$deal['id']])}}" class="btn btn-outline--primary btn-sm edit">
                                                <i class="tio-edit"></i>
                                            </a>

                                            <a title="{{\App\CPU\Helpers::translate('Edit')}}" href="#"
                                                onclick="form_alert('delete_deal{{ $deal['id'] }}','Are you sure ?')"
                                                class="btn btn-outline--primary btn-sm edit">
                                                <i class="tio-delete"></i>
                                            </a>
                                            <form id="delete_deal{{ $deal['id'] }}" method="post"
                                                action="{{ route('admin.deal.featured-delete',['id'=>$deal['id']]) }}">
                                                @csrf
                                            </form>
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
                            {{$flash_deals->links()}}
                        </div>
                    </div>

                    @if(count($flash_deals)==0)
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

        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>

    <script>
        $(document).on('change', '.featured', function () {
            var id = $(this).attr("id");
            if ($(this).prop("checked") == true) {
                var featured = 1;
            } else if ($(this).prop("checked") == false) {
                var featured = 0;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.deal.featured-update')}}",
                method: 'POST',
                data: {
                    id: id,
                    featured: featured
                },
                success: function () {
                    toastr.success('{{\App\CPU\Helpers::translate('Status updated successfully')}}');
                    // location.reload();
                }
            });
        });
        $(document).on('change', '.status', function () {
            var id = $(this).attr("id");
            if ($(this).prop("checked") === true) {
                var status = 1;
            } else if ($(this).prop("checked") === false) {
                var status = 0;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.deal.feature-status')}}",
                method: 'POST',
                data: {
                    id: id,
                    status: status
                },
                success: function (data) {
                    if(data == 1){
                        toastr.success('{{\App\CPU\Helpers::translate('Status updated successfully')}}');
                    }else{
                        toastr.error("{{ Helpers::translate('Access Denied !') }}")
                    }
                    setTimeout(function (){
                        location.reload();
                    },1000);
                }
            });
        });

    </script>

    <!-- Page level custom scripts -->

    <script>
        $(document).ready(function () {
            // color select select2
            $('.color-var-select').select2({
                templateResult: colorCodeSelect,
                templateSelection: colorCodeSelect,
                escapeMarkup: function (m) {
                    return m;
                }
            });

            function colorCodeSelect(state) {
                var colorCode = $(state.element).val();
                if (!colorCode) return state.text;
                return "<span class='color-preview' style='background-color:" + colorCode + ";'></span>" + state.text;
            }
        });
    </script>
@endpush
