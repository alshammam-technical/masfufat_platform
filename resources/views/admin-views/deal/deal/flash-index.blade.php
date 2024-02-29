@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('Flash Deal'))

@push('css_or_js')
    <link href="{{asset('public/assets/back-end/css/tags-input.min.css')}}" rel="stylesheet">
    <link href="{{ asset('public/assets/select2/css/select2.min.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="content container-fluid">
    <!-- Page Title -->
    <div class="mb-3">
        <h2 class="h1 mb-0 text-capitalize d-flex gap-2">
            {{\App\CPU\Helpers::translate('flash_deals')}}
        </h2>
    </div>
    <!-- End Page Title -->
    <!-- Content Row -->
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
    @if(Helpers::module_permission_check('marketing.deal.flash.add'))
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.deal.flash')}}" method="post" style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};" enctype="multipart/form-data">
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
                        <ul class="nav nav-tabs lightSlider sm:w-fit-content w-full mb-0 px-6">
                            @foreach(Helpers::get_langs() as $lang)
                                <li class="nav-item text-capitalize font-weight-medium">
                                    <a class="nav-link lang_link {{$lang == ($default_lang ?? session()->get('local')) ? 'active':''}}"
                                       href="#"
                                       id="{{$lang}}-link">
                                       <img class="ml-2" width="20" src="{{asset('public/assets/front-end')}}/img/flags/{{$lang}}.png">{{\App\CPU\Helpers::get_language_name($lang).'('.strtoupper($lang).')'}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="row">
                            <div class="col-lg-6">
                                @foreach(Helpers::get_langs() as $lang)
                                    <div class="{{$lang != $default_lang ? 'd-none':''}} lang_form" id="{{$lang}}-form">
                                        <input type="text" name="deal_type" value="flash_deal"  class="d-none">
                                        <div class="form-group">
                                            <label for="name" class="title-color font-weight-medium text-capitalize">{{ \App\CPU\Helpers::translate('Offer group name')}} ({{strtoupper($lang)}})</label>
                                            <input type="text" name="title[]" class="form-control" id="title"
                                                placeholder="{{\App\CPU\Helpers::translate('Ex')}} : {{\App\CPU\Helpers::translate('LUX')}}"
                                                {{$lang == ($default_lang ?? session()->get('local')) ? 'required':''}}>
                                        </div>
                                    </div>
                                    <input type="hidden" name="lang[]" value="{{$lang}}" id="lang">
                                @endforeach
                                <div class="form-group">
                                    <label for="name" class="title-color font-weight-medium text-capitalize">{{ \App\CPU\Helpers::translate('Offers start date')}}</label>
                                    <input type="date" name="start_date" required class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="name" class="title-color font-weight-medium text-capitalize">{{ \App\CPU\Helpers::translate('Offers end date')}}</label>
                                    <input type="date" name="end_date" required class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="form-group" style="position: relative;width: 185px">
                                        <label class="title-color">{{\App\CPU\Helpers::translate('Brand logo')}}</label>
                                        <strong class="text-primary">({{\App\CPU\Helpers::translate('ratio')}} 1:1)</strong>
                                        <span style="position: absolute;bottom: 50px;width: 100%;left: 0;text-align-last: center;">
                                            {{ Helpers::translate('add image') }}
                                        </span>
                                        <img class="upload-img-view viewer border-0" onerror="this.src=def_img" id="viewer"
                                            src="{{asset('storage/app/public/category')}}/1111.png"
                                            alt="" />
                                        <input type="file" name="image" id="customFileUpload"
                                        style="position: absolute;top: 0;height: 100%;"
                                        class="custom-file-input customFileEg1 d-block" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <button type="submit" class="btn bg-primaryColor btn-primary px-4 bg-primaryColor sm:w-auto w-full">{{ \App\CPU\Helpers::translate('submit')}}</button>
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
                            <h5 class="mb-0 text-capitalize d-flex gap-2">
                                {{ \App\CPU\Helpers::translate('flash_deal_table')}}
                                <span class="badge badge-soft-dark radius-50 fz-12">{{ $flash_deal->total() }}</span>
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
                                        placeholder="{{\App\CPU\Helpers::translate('Search by offers group name')}}" aria-label="Search orders" value="{{ $search }}" required>
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
                            class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                        <thead class="thead-light thead-50 text-capitalize">
                        <tr>
                            <th>{{ \App\CPU\Helpers::translate('SL')}}</th>
                            <th>{{ \App\CPU\Helpers::translate('Offer group name')}}</th>
                            <th>{{ \App\CPU\Helpers::translate('Duration')}}</th>
                            <th>{{ \App\CPU\Helpers::translate('status')}}</th>
                            <th>{{ \App\CPU\Helpers::translate('The number of products in the group')}}</th>
                            <th>{{ \App\CPU\Helpers::translate('activation')}}</th>
                            <th class="text-center">{{ \App\CPU\Helpers::translate('action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($flash_deal as $k=>$deal)
                            <tr>
                                <td>{{$flash_deal->firstItem()+ $k}}</td>
                                <td><span class="font-weight-semibold">{{$deal['title']}}</span></td>
                                <td>{{date('Y/m/d',strtotime($deal['start_date']))}} - {{date('Y/m/d',strtotime($deal['end_date']))}}</td>
                                <!-- <td>{{date('Y/m/d',strtotime($deal['end_date']))}}</td> -->
                                <td>
                                    @if(\Carbon\Carbon::parse($deal['end_date'])->endOfDay()->isPast())
                                        <span class="badge badge-soft-danger">{{ \App\CPU\Helpers::translate('expired')}} </span>
                                    @else
                                        <span class="badge badge-soft-success"> {{ \App\CPU\Helpers::translate('active')}} </span>
                                    @endif
                                </td>
                                <td>{{ $deal->products_count }}</td>
                                <td>
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher_input status check_uncheck"
                                                id="{{$deal['id']}}" {{$deal->status == 1?'checked':''}}>
                                        <span class="switcher_control"></span>
                                    </label>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-10">
                                        <a class="h-30 d-flex gap-2 align-items-center btn btn-soft-info btn-sm border-info" href="{{route('admin.deal.add-product',[$deal['id']])}}">
                                            <img src="{{asset('/public/assets/back-end/img/plus.svg')}}" class="svg" alt="">
                                            {{\App\CPU\Helpers::translate('Add Product')}}
                                        </a>

                                        <a title="{{\App\CPU\Helpers::translate('Edit')}}"
                                            href="{{route('admin.deal.update',[$deal['id']])}}"
                                            class="btn btn-white border-0 edit">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22H15C20 22 22 20 22 15V13" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M16.0399 3.02025L8.15988 10.9003C7.85988 11.2003 7.55988 11.7903 7.49988 12.2203L7.06988 15.2303C6.90988 16.3203 7.67988 17.0803 8.76988 16.9303L11.7799 16.5003C12.1999 16.4403 12.7899 16.1403 13.0999 15.8403L20.9799 7.96025C22.3399 6.60025 22.9799 5.02025 20.9799 3.02025C18.9799 1.02025 17.3999 1.66025 16.0399 3.02025Z" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M14.9102 4.15039C15.5802 6.54039 17.4502 8.41039 19.8502 9.09039" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </a>

                                        <a title="{{\App\CPU\Helpers::translate('Edit')}}"
                                            href="#"
                                            onclick="form_alert('delete_deal{{ $deal['id'] }}','Are you sure ?')"
                                            class="btn btn-white border-0 edit">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M21 5.97998C17.67 5.64998 14.32 5.47998 10.98 5.47998C9 5.47998 7.02 5.57998 5.04 5.77998L3 5.97998" stroke="#FF000F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M8.5 4.97L8.72 3.66C8.88 2.71 9 2 10.69 2H13.31C15 2 15.13 2.75 15.28 3.67L15.5 4.97" stroke="#FF000F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M18.8504 9.13989L18.2004 19.2099C18.0904 20.7799 18.0004 21.9999 15.2104 21.9999H8.79039C6.00039 21.9999 5.91039 20.7799 5.80039 19.2099L5.15039 9.13989" stroke="#FF000F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M10.3301 16.5H13.6601" stroke="#FF000F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M9.5 12.5H14.5" stroke="#FF000F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </a>
                                        <form id="delete_deal{{ $deal['id'] }}" method="post" action="{{ route('admin.deal.flash.delete',['id'=>$deal['id']]) }}">
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
                        {{$flash_deal->links()}}
                    </div>
                </div>

                @if(count($flash_deal)==0)
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
    <!-- Page level plugins -->
    <script src="{{asset('public/assets/back-end')}}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Page level custom scripts -->

    <script src="{{asset('public/assets/back-end')}}/js/select2.min.js"></script>
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
                url: "{{route('admin.deal.status-update')}}",
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
                        location.reload()
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
@endpush
