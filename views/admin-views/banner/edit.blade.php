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
                            <a href="{{route('admin.banner.list')}}">
                                {{Helpers::translate('banner')}}
                            </a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a>
                                {{Helpers::translate('banner_update_form')}}
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
        <!-- End Page Title -->

        <!-- Content Row -->
        <div class="row" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('admin.banner.update',[$banner['id']])}}" method="post" enctype="multipart/form-data"
                              class="banner_form">
                            @csrf
                            @method('put')
                            <div class="row align-items-center">
                                <div class="col-md-6 mb-5 mb-lg-0">
                                    <div class="form-group">
                                        <input type="hidden" id="id" name="id">
                                        <label for="name" class="title-color text-capitalize">{{ \App\CPU\Helpers::translate('banner_URL')}}</label>
                                        <input type="text" name="url" class="form-control" value="{{$banner['url']}}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="name" class="title-color text-capitalize">{{\App\CPU\Helpers::translate('banner_type')}}</label>
                                        <select class="js-example-responsive form-control w-100"
                                                name="banner_type" required>
                                            <option value="Main Banner" {{$banner['banner_type']=='Main Banner'?'selected':''}}>Main Banner</option>
                                            <option value="Footer Banner" {{$banner['banner_type']=='Footer Banner'?'selected':''}}>Footer Banner</option>
                                            <option value="Popup Banner" {{$banner['banner_type']=='Popup Banner'?'selected':''}}>Popup Banner</option>
                                            <option value="Main Section Banner" {{$banner['banner_type']=='Main Section Banner'?'selected':''}}>{{ \App\CPU\Helpers::translate('Main Section Banner')}}</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="resource_id" class="title-color text-capitalize">{{\App\CPU\Helpers::translate('resource_type')}}</label>
                                        <select onchange="display_data(this.value)"
                                                class="js-example-responsive form-control w-100"
                                                name="resource_type" required>
                                            <option value="product" {{$banner['resource_type']=='product'?'selected':''}}>Product</option>
                                            <option value="category" {{$banner['resource_type']=='category'?'selected':''}}>Category</option>
                                            <option value="shop" {{$banner['resource_type']=='shop'?'selected':''}}>Shop</option>
                                            <option value="brand" {{$banner['resource_type']=='brand'?'selected':''}}>Brand</option>
                                        </select>
                                    </div>

                                    <div class="form-group" id="resource-product" style="display: {{$banner['resource_type']=='product'?'block':'none'}}">
                                        <label for="product_id" class="title-color text-capitalize">{{\App\CPU\Helpers::translate('product')}}</label>
                                        <select class="js-example-responsive form-control w-100"
                                                name="product_id">
                                            @foreach(\App\Model\Product::active()->get() as $product)
                                                <option value="{{$product['id']}}" {{$banner['resource_id']==$product['id']?'selected':''}}>{{$product['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group" id="resource-category" style="display: {{$banner['resource_type']=='category'?'block':'none'}}">
                                        <label for="name" class="title-color text-capitalize">{{\App\CPU\Helpers::translate('category')}}</label>
                                        <select class="js-example-responsive form-control w-100"
                                                name="category_id">
                                            @foreach(\App\CPU\CategoryManager::parents() as $category)
                                                <option value="{{$category['id']}}" {{$banner['resource_id']==$category['id']?'selected':''}}>{{$category['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group" id="resource-shop" style="display: {{$banner['resource_type']=='shop'?'block':'none'}}">
                                        <label for="shop_id" class="title-color text-capitalize">{{\App\CPU\Helpers::translate('shop')}}</label>
                                        <select class="js-example-responsive form-control w-100"
                                                name="shop_id">
                                            @foreach(\App\Model\Shop::active()->get() as $shop)
                                                <option value="{{$shop['id']}}" {{$banner['resource_id']==$shop['id']?'selected':''}}>{{$shop['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group" id="resource-brand" style="display: {{$banner['resource_type']=='brand'?'block':'none'}}">
                                        <label for="brand_id" class="title-color text-capitalize">{{\App\CPU\Helpers::translate('brand')}}</label>
                                        <select class="js-example-responsive form-control w-100"
                                                name="brand_id">
                                            @foreach(\App\Model\Brand::all() as $brand)
                                                <option value="{{$brand['id']}}" {{$banner['resource_id']==$brand['id']?'selected':''}}>{{$brand['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                </div>
                                <div class="col-md-6">
                                    <div class="px-0 mb-5">
                                        <ul class="nav nav-tabs lightSlider w-fit-content mb-0 px-6">
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
                                        <?php
                                        if (count($banner['translations'])) {
                                            $translate = [];
                                            foreach ($banner['translations'] as $t) {
                                                if ($t->locale == $lang && $t->key == "name") {
                                                    $name = $t->value;
                                                }
                                                if ($t->locale == $lang && $t->key == "image") {
                                                    $img = $t->value;
                                                }
                                            }
                                        }
                                        ?>
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
                                                src="{{asset('storage/app/public/banner')}}/{{ \App\CPU\Helpers::get_prop('App\Model\Banner',$banner->id,'image',$lang) }}"
                                                alt=""/>
                                        </center>
                                    </div>
                                    @endforeach
                                </div>

                                <div class="col-md-12 mt-3 d-flex justify-content-end gap-3">
                                    <button type="submit" class="btn btn--primary btn-primary px-4">{{ \App\CPU\Helpers::translate('update')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
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
            if (lang == '{{session()->get("local")}}') {
                $(".from_part_2").removeClass('d-none');
            } else {
                $(".from_part_2").addClass('d-none');
            }
        });

        $(".js-example-theme-single").select2({
            theme: "classic"
        });

        $(".js-example-responsive").select2({
            // dir: "rtl",
            width: 'resolve'
        });

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
        function mbimagereadURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#mbImageviewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#mbimageFileUploader").change(function () {
            mbimagereadURL(this);
        });

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
@endpush
