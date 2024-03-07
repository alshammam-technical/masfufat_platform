@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('Banner'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                                {{Helpers::translate('banner')}}
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
        <!-- End Page Title -->

        <!-- Content Row -->
        @if(Helpers::module_permission_check('marketing.banner.add'))
        <div class="row pb-4 d--none" id="main-banner"
             style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 text-capitalize">{{ \App\CPU\Helpers::translate('banner_form')}}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.banner.store')}}" method="post" enctype="multipart/form-data"
                              class="banner_form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="hidden" id="id" name="id">
                                        <label for="name"
                                               class="title-color text-capitalize">{{ \App\CPU\Helpers::translate('banner_URL')}}</label>
                                        <input type="text" name="url" class="form-control" id="url" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="name"
                                               class="title-color text-capitalize">{{\App\CPU\Helpers::translate('banner_type')}}</label>
                                        <select class="js-example-responsive form-control w-100"
                                                name="banner_type" required>
                                            <option value="Main Banner">{{ \App\CPU\Helpers::translate('Main Banner')}}</option>
                                            <option
                                                value="Footer Banner">{{ \App\CPU\Helpers::translate('Footer Banner')}}</option>
                                            <option
                                                value="Popup Banner">{{ \App\CPU\Helpers::translate('Popup Banner')}}</option>
                                            <option
                                                value="Main Section Banner">{{ \App\CPU\Helpers::translate('Main Section Banner')}}</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="resource_id"
                                               class="title-color text-capitalize">{{\App\CPU\Helpers::translate('resource_type')}}</label>
                                        <select onchange="display_data(this.value)"
                                                class="js-example-responsive form-control w-100"
                                                name="resource_type" required>
                                            <option value="product">{{ \App\CPU\Helpers::translate('Product_')}}</option>
                                            <option value="category">{{ \App\CPU\Helpers::translate('Category_')}}</option>
                                            <option value="shop">{{ \App\CPU\Helpers::translate('Shop')}}</option>
                                            <option value="brand">{{ \App\CPU\Helpers::translate('Brand_')}}</option>
                                        </select>
                                    </div>

                                    <div class="form-group" id="resource-product">
                                        <label for="product_id"
                                               class="title-color text-capitalize">{{\App\CPU\Helpers::translate('product')}}</label>
                                        <select class="js-example-responsive form-control w-100"
                                                name="product_id">
                                            @foreach(\App\Model\Product::active()->get() as $product)
                                                <option value="{{$product['id']}}">{{$product['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group d--none" id="resource-category">
                                        <label for="name"
                                               class="title-color text-capitalize">{{\App\CPU\Helpers::translate('category')}}</label>
                                        <select class="js-example-responsive form-control w-100"
                                                name="category_id">
                                            @foreach(\App\CPU\CategoryManager::parents() as $category)
                                                <option value="{{$category['id']}}">{{$category['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group d--none" id="resource-shop">
                                        <label for="shop_id" class="title-color">{{\App\CPU\Helpers::translate('shop')}}</label>
                                        <select class="w-100 js-example-responsive form-control" name="shop_id">
                                            @foreach(\App\Model\Shop::active()->get() as $shop)
                                                <option value="{{$shop['id']}}">{{$shop['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group d--none" id="resource-brand">
                                        <label for="brand_id"
                                               class="title-color text-capitalize">{{\App\CPU\Helpers::translate('brand')}}</label>
                                        <select class="js-example-responsive form-control w-100"
                                                name="brand_id">
                                            @foreach(\App\Model\Brand::all() as $brand)
                                                <option value="{{$brand['id']}}">{{$brand['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="px-0 mb-5">
                                        <ul class="nav nav-tabs lightSlider_ w-fit-content mb-0 px-6">
                                            @foreach(\App\CPU\Helpers::get_langs() as $lang)
                                                <li class="nav-item text-capitalize">
                                                    <a class="nav-link lang_link {{$lang == ($default_lang ?? session()->get('local')) ? 'active':''}}"
                                                    href="#"
                                                    id="{{$lang}}-link">
                                                    <img class="ml-2" width="20" src="{{asset('public/assets/front-end')}}/img/flags/{{$lang}}.png">
                                                    {{ucfirst(\App\CPU\Helpers::get_language_name($lang)).'('.strtoupper($lang).')'}}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @php($default_lang = session()->get('local') ?? 'sa')
                                    @foreach(\App\CPU\Helpers::get_langs() as $lang)
                                    <div class="form-group {{$lang !== $default_lang ? 'd-none':''}} lang_form"
                                        id="{{$lang}}-form">
                                        <label for="name">{{ \App\CPU\Helpers::translate('Image')}} ({{$lang}})</label><span
                                            class="ml-1 text-info">( {{\App\CPU\Helpers::translate('ratio')}} 4:1 )</span>
                                        <br>
                                        <div class="custom-file text-left mb-6 mt-0 pt-0">
                                            <input type="file" name="image[]" id="mbimageFileUploader"
                                                    class="custom-file-input customFileEg1"
                                                    accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                            <input type="hidden" name="lang[]" value="{{$lang}}">
                                            <label class="custom-file-label"
                                                    for="mbimageFileUploader">{{\App\CPU\Helpers::translate('choose file')}}</label>
                                        </div>
                                        <center>
                                            <img
                                                class="upload-img-view viewer"
                                                id="mbImageviewer"
                                                src="{{asset('public/assets/front-end/img/placeholder.png')}}"
                                                alt=""/>
                                        </center>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mt-3 d-flex justify-content-end flex-wrap gap-10">
                                <button class="btn btn-secondary cancel px-4" type="reset">{{ \App\CPU\Helpers::translate('reset')}}</button>
                                <button id="add" type="submit"
                                        class="btn btn--primary btn-primary px-4">{{ \App\CPU\Helpers::translate('save')}}</button>
                                <button id="update"
                                   class="btn btn--primary btn-primary d--none text-white">{{ \App\CPU\Helpers::translate('update')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="row" id="banner-table">
            <div class="col-md-12">
                <div class="card">
                    <div class="px-3 py-4">
                        <div class="row align-items-center">
                            <div class="col-md-4 col-lg-6 mb-2 mb-md-0">
                                <h5 class="mb-0 text-capitalize d-flex gap-2">
                                    {{ \App\CPU\Helpers::translate('banner_table')}}
                                    <span
                                        class="badge badge-soft-dark radius-50 fz-12">{{ $banners->total() }}</span>
                                </h5>
                            </div>
                            <div class="col-md-8 col-lg-6">
                                <div
                                    class="d-flex align-items-center justify-content-md-end flex-wrap flex-sm-nowrap gap-2">
                                    <!-- Search -->
                                    <form action="{{ url()->current() }}" method="GET">
                                        <div class="input-group input-group-merge input-group-custom">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="tio-search"></i>
                                                </div>
                                            </div>
                                            <input id="datatableSearch_" type="search" name="search"
                                                   class="form-control"
                                                   placeholder="{{ \App\CPU\Helpers::translate('Search_by_Banner_Type')}}"
                                                   aria-label="Search orders" value="{{ $search }}">
                                            <button type="submit" class="btn btn--primary btn-primary">
                                                {{ \App\CPU\Helpers::translate('Search')}}
                                            </button>
                                        </div>
                                    </form>
                                    <!-- End Search -->

                                    <div id="banner-btn">
                                        <button onclick="ls()" id="main-banner-add" class="btn btn--primary btn-primary text-nowrap">
                                            <i class="tio-add"></i>
                                            {{ \App\CPU\Helpers::translate('add_banner')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="columnSearchDatatable"
                               style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                               class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                            <thead class="thead-light thead-50 text-capitalize">
                            <tr>
                                <th class="pl-xl-5">{{\App\CPU\Helpers::translate('SL')}}</th>
                                <th>{{\App\CPU\Helpers::translate('image')}}</th>
                                <th>{{\App\CPU\Helpers::translate('banner_type')}}</th>
                                <th>{{\App\CPU\Helpers::translate('status')}}</th>
                                <th class="text-center">{{\App\CPU\Helpers::translate('action')}}</th>
                            </tr>
                            </thead>
                            @foreach($banners as $key=>$banner)
                                <tbody>
                                <tr id="data-{{$banner->id}}">
                                    <td class="pl-xl-5">{{$banners->firstItem()+$key}}</td>
                                    <td>
                                        <img class="ratio-4:1" width="80"
                                             onerror="this.src='{{asset('public/assets/front-end/img/placeholder.png')}}'"
                                             src="{{asset('storage/app/public/banner')}}/{{ \App\CPU\Helpers::get_prop('App\Model\Banner',$banner->id,'image') }}">
                                    </td>
                                    <td>{{ Helpers::translate($banner->banner_type) }}</td>
                                    <td>
                                        <label class="switcher">
                                            <input type="checkbox" class="switcher_input status"
                                                   id="{{$banner->id}}" <?php if ($banner->published == 1) echo "checked" ?>>
                                            <span class="switcher_control"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-10 justify-content-center">
                                            <a class="btn btn-outline--primary btn-sm cursor-pointer edit"
                                               title="{{ \App\CPU\Helpers::translate('Edit')}}"
                                               href="{{route('admin.banner.edit',[$banner['id']])}}">
                                                <i class="tio-edit"></i>
                                            </a>
                                            <a class="btn btn-outline-danger btn-sm cursor-pointer delete"
                                               title="{{ \App\CPU\Helpers::translate('Delete')}}"
                                               id="{{$banner['id']}}">
                                                <i class="tio-delete"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            @endforeach
                        </table>
                    </div>

                    <div class="table-responsive mt-4">
                        <div class="px-4 d-flex justify-content-lg-end">
                            <!-- Pagination -->
                            {{$banners->links()}}
                        </div>
                    </div>

                    @if(count($banners)==0)
                        <div class="text-center p-4">
                            <img class="mb-3 w-160"
                                 src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg"
                                 alt="Image Description">
                            <p class="mb-0">{{ \App\CPU\Helpers::translate('No_data_to_show')}}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(".js-example-theme-single").select2({
            theme: "classic"
        });

        $(".js-example-responsive").select2({
            // dir: "rtl",
            width: 'resolve'
        });

        function ls(){
            @if(Helpers::module_permission_check('marketing.banner.add'))
            $(".lightSlider_").lightSlider({
                rtl: {{ (session('direction') == 'rtl') ? 'true' : 'false' }},
                enableDrag:true,
                enableTouch:true,
                freeMove:true,
                autoWidth:false,
                pager:false,
                vThumbWidth:'120px',
                prevHtml:"<button class='btn btn-primary'><i class='fa fa-angle-{{ (session('direction') == 'rtl') ? 'right' : 'left' }}'></i></button>",
                nextHtml:"<button class='btn btn-primary'><i class='fa fa-angle-{{ (session('direction') == 'rtl') ? 'left' : 'right' }}'></i></button>",
            });
            $(".lightSlider_").css('height','50px')
            @else
            toastr.error("{{ Helpers::translate('Access Denied !') }}")
            @endif
        }

        @foreach(Helpers::get_langs() as $lang)
            $("#thumbnail_{{$lang}}").spartanMultiImagePicker({
                fieldName: 'image[{{$lang}}]',
                maxCount: 1,
                rowHeight: 'auto',
                groupClassName: 'col-3',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{asset('public/assets/back-end/img/400x400/img2.jpg')}}',
                    width: '100%',
                },
                dropFileLabel: "Drop Here",
                onAddRow: function (index, file) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    toastr.error('{{\App\CPU\Helpers::translate('Please only input png or jpg type file')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function (index, file) {
                    toastr.error('{{\App\CPU\Helpers::translate('File size too big')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
            @endforeach

        function display_data(data) {

            $('#resource-product').hide()
            $('#resource-brand').hide()
            $('#resource-category').hide()
            $('#resource-shop').hide()

            if (data === 'product') {
                $('#resource-product').show()
            } else if (data === 'brand') {
                $('#resource-brand').show()
            } else if (data === 'category') {
                $('#resource-category').show()
            } else if (data === 'shop') {
                $('#resource-shop').show()
            }
        }
    </script>
    <script>


        $(".lang_link").click(function (e) {
            e.preventDefault();
            $(this).closest('.card').find(".lang_link").removeClass('active');
            $(this).closest('.card').find(".lang_form").addClass('d-none');
            $(this).addClass('active');

            let form_id = this.id;
            let lang = form_id.split("-")[0];
            $("#" + lang + "-form").removeClass('d-none');
            if (lang == '{{$default_lang ?? 'sa'}}') {
                $(this).closest('.card').find(".rest-part").removeClass('d-none');
            } else {
                $(this).closest('.card').find(".rest-part").addClass('d-none');
            }
        })


        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(input).closest('.form-group').find('.viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $(".customFileEg1").change(function () {
            readURL(this);
        });

    </script>
    <script>
        $('#main-banner-add').on('click', function () {
            $('#main-banner').show();
        });

        $('.cancel').on('click', function () {
            $('.banner_form').attr('action', "{{route('admin.banner.store')}}");
            $('#main-banner').hide();
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
                url: "{{route('admin.banner.status')}}",
                method: 'POST',
                data: {
                    id: id,
                    status: status
                },
                success: function (data) {
                    if (data == 500) {
                        toastr.error("{{ Helpers::translate('Access Denied !') }}")
                        location.reload();
                    }
                    else if (data == 1) {
                        toastr.success('{{\App\CPU\Helpers::translate('Banner_published_successfully')}}');
                    } else {
                        toastr.success('{{\App\CPU\Helpers::translate('Banner_unpublished_successfully')}}');
                    }
                }
            });
        });

        $(document).on('click', '.delete', function () {
            var id = $(this).attr("id");
            Swal.fire({
                title: "{{\App\CPU\Helpers::translate('Are_you_sure_delete_this_banner')}}?",
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
                        url: "{{route('admin.banner.delete')}}",
                        method: 'POST',
                        data: {id: id},
                        success: function (response) {
                            if(response == 1){
                                toastr.success('{{\App\CPU\Helpers::translate('Banner_deleted_successfully')}}');
                                $('#data-' + id).hide();
                            }else{
                                toastr.error("{{ Helpers::translate('Access Denied !') }}")
                            }
                        }
                    });
                }
            })
        });
    </script>
    <!-- Page level plugins -->
@endpush
