@extends('layouts.back-end.app-seller')

@section('title', \App\CPU\Helpers::translate('Product Add'))

@push('css_or_js')
    <link href="{{ asset('public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="row">
            <div class="d-flex flex-wrap gap-2 align-items-center mb-3 col-lg-5">
                <h2 class="h1 mb-0 d-flex gap-2">
                    <img src="{{asset('/public/assets/back-end/img/inhouse-product-list.png')}}" alt="">
                    {{\App\CPU\Helpers::translate('Add New Product')}}
                </h2>
            </div>
            <!-- End Page Title -->

            <div class="col-lg-7" hidden>
                <div class="d-flex table-actions flex-wrap justify-content-end mx-3">
                    <div class="d-flex">
                    <button disabled class="btn btn-info my-2 btn-icon-text m-2" onclick="$('.products-dataTable').addClass('gridTable');$('.dataTables_scrollBody').css('max-height','650px')">
                        <i class="fa fa-th"></i>
                    </button>
                    <button disabled class="btn btn-info ti-menu-alt my-2 btn-icon-text m-2" onclick="$('.products-dataTable').removeClass('gridTable');$('.dataTables_scrollBody').css('max-height',dataTables_scrollBody_height)">
                        <i class="fa fa-table"></i>
                    </button>
                    <a title="{{Helpers::translate('Add new')}}" class="btn ti-plus btn-success my-2 btn-icon-text m-2" href="{{route('seller.product.add-new')}}">
                        <i class="fa fa-plus"></i>
                    </a>
                    <button title="{{Helpers::translate('Add from')}}" class="btn btn-info mdi mdi-arrange-bring-forward btnAddFrom my-2 btn-icon-text m-2" disabled>
                        <i class="fa fa-clone"></i>
                    </button>

                    <button disabled class="btn ti-save btn-success my-2 btn-icon-text m-2 " style="display: none"
                    onclick="$('.table').removeClass('editMode');$('.edit-btn').show();$(this).hide();saveTableChanges()">
                        <i class="fa fa-save"></i>
                    </button>

                    <button title="{{Helpers::translate('Edit')}}" class="btn btn-info my-2 btn-icon-text m-2 edit-btn"
                    onclick="check()">
                        <i class="fa fa-save"></i>
                    </button>

                    <button title="{{Helpers::translate('Delete')}}" class="btnDeleteRow btn ti-trash btn-danger my-2 btn-icon-text m-2"
                    disabled
                    >
                        <i class="fa fa-trash"></i>
                    </button>
                    <form hidden action="{{route('seller.product.bulk-delete')}}" method="post" id="bulk-delete">
                        @csrf @method('delete')
                        <input type="text" name="ids" class="ids" value="{{$product['id']}}">
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
                                <a aria-expanded="false" aria-haspopup="true" class="dropdown-item dropdown-toggle" data-toggle="dropdown" id="droprightMenuButton" type="button"
                                onclick='$(".dt-button-collection").remove();'>
                                    <i class="ti-angle-down"></i>
                                    {{\App\CPU\Helpers::translate('Import/Export')}}
                                </a>
                                <div aria-labelledby="droprightMenuButton" class="dropdown-menu tx-13" style="position: absolute;will-change: transform;top: -10%;left: -100%;transform: translate3d(0px, 145px, 0px);">
                                    <a class="dropdown-item" href="{{route('seller.product.bulk-export')}}">
                                        {{\App\CPU\Helpers::translate('export to excel')}}
                                    </a>
                                    <a class="dropdown-item" href="{{route('seller.product.bulk-import')}}">
                                        {{\App\CPU\Helpers::translate('import from excel')}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12">
                <form class="product-form" action="{{ route('seller.product.store') }}" method="POST"
                    style="text-align: {{ Session::get('direction') === 'rtl' ? 'right' : 'left' }};"
                    enctype="multipart/form-data" id="product_form">
                    @csrf
                    <div class="card">
                        <div class="px-4 pt-3">
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
                            <ul class="nav nav-tabs lightSlider w-fit-content mb-4">
                                @foreach (Helpers::get_langs() as $lang)
                                    <li class="nav-item">
                                        <a class="nav-link text-capitalize lang_link {{ $lang == ($default_lang ?? session()->get('local')) ?  'active' : '' }}"
                                        href="#"
                                        id="{{ $lang }}-link">
                                            <img class="ml-2" width="20" src="{{asset('public/assets/front-end')}}/img/flags/{{$lang}}.png">
                                            {{ \App\CPU\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')' }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="card-body">
                            @foreach (Helpers::get_langs() as $lang)
                                <div class="{{ $lang != $default_lang ? 'd-none' : '' }} lang_form"
                                    id="{{ $lang }}-form">
                                    <div class="form-group">
                                        <label class="title-color"
                                            for="{{ $lang }}_name">{{ \App\CPU\Helpers::translate('name') }}
                                            ({{ strtoupper($lang) }})
                                        </label>
                                        <input type="text" {{ $lang == ($default_lang ?? session()->get('local')) ?  'required' : '' }} name="name[]"
                                            id="{{ $lang }}_name" class="form-control" placeholder="New Product" onchange="translateName(event,'.card-body','input[name=\'name[]\']')">
                                    </div>
                                    <input type="hidden" name="lang[]" value="{{ $lang }}">
                                    <div class="form-group pt-4">
                                        <label class="title-color"
                                            for="{{ $lang }}_description">{{ \App\CPU\Helpers::translate('description') }}
                                            ({{ strtoupper($lang) }})</label>
                                        <textarea name="description[]" class="textarea editor-textarea">{{ old('details') }}</textarea>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="card mt-2 rest-part">
                        <div class="card-header">
                            <h4 class="mb-0">{{\App\CPU\Helpers::translate('General Info')}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 d-flex align-items-center gap-2">
                                <label class="mb-0 title-color" for="switcher">
                                    {{\App\CPU\Helpers::translate('a featured product')}} :
                                </label>
                                <label class="switcher title-color">
                                    <input type="checkbox" class="switcher_input"
                                    value="1"
                                        name="featured">
                                    <span class="switcher_control"></span>
                                </label>
                            </div>
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label for="name" class="title-color">{{ \App\CPU\Helpers::translate('product_type') }}</label>
                                    <select name="product_type" id="product_type" class="form-control" required>
                                        <option value="physical" {{ $product->product_type=='physical' ? 'selected' : ''}}>{{ \App\CPU\Helpers::translate('physical') }}</option>
                                        @if(isset($digital_product_setting))
                                        <option value="digital" {{ $product->product_type=='digital' ? 'selected' : ''}}>{{ \App\CPU\Helpers::translate('digital') }}</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-4" id="digital_product_type_show">
                                    <label for="digital_product_type" class="title-color">{{ \App\CPU\Helpers::translate("digital_product_type") }}</label>
                                    <select name="digital_product_type" id="digital_product_type" class="form-control" required>
                                        <option value="{{ old('category_id') }}" {{ !$product->digital_product_type ? 'selected' : ''}} disabled>---Select---</option>
                                        <option value="ready_after_sell" {{ $product->digital_product_type=='ready_after_sell' ? 'selected' : ''}}>{{ \App\CPU\Helpers::translate("Ready After Sell") }}</option>
                                        <option value="ready_product" {{ $product->digital_product_type=='ready_product' ? 'selected' : ''}}>{{ \App\CPU\Helpers::translate("Ready Product") }}</option>
                                    </select>
                                </div>
                                <div class="col-md-4" id="digital_file_ready_show">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="digital_file_ready" class="title-color">{{ \App\CPU\Helpers::translate("ready_product_upload") }}</label>
                                            <input type="file" name="digital_file_ready" id="digital_file_ready" class="form-control">
                                            <div class="mt-1 text-info">File type: jpg, jpeg, png, gif, zip, pdf</div>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="h-100 mt-5">
                                                <a href="{{asset("storage/app/public/product/digital-product/$product->digital_file_ready")}}" target="_blank">{{ $product->digital_file_ready }}</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label for="name" class="title-color">{{\App\CPU\Helpers::translate('Category')}}</label>
                                    <div class="form-control w-100 p-0">
                                        <select
                                            class="SumoSelect-custom"
                                            multiple
                                            id="category_id"
                                            onchange="getRequest('{{url('/')}}/seller/product/get-categories?parent_id='+this.value,'sub-category-select','select')">
                                            @foreach($categories as $category)
                                                <option
                                                    value="{{$category['id']}}" >{{$category['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="hidden" name="category_id" />
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="title-color"
                                               for="exampleFormControlInput1">{{ \App\CPU\Helpers::translate('product_code_sku') }}
                                            <span class="text-danger">*</span>
                                            <a class="style-one-pro" style="cursor: pointer;"
                                               onclick="document.getElementById('generate_number').value = getRndInteger()">{{ \App\CPU\Helpers::translate('generate') }}
                                                {{ \App\CPU\Helpers::translate('code') }}</a></label>
                                        <input type="text" id="generate_number" name="code"
                                               class="form-control"  value="{{ $product->code  }}" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label for="name" class="title-color">{{\App\CPU\Helpers::translate('Brand')}}</label>
                                    <select
                                        class="js-example-basic-multiple js-states js-example-responsive form-control"
                                        name="brand_id">
                                        <option value="{{null}}" selected disabled>---{{\App\CPU\Helpers::translate('Select')}}---</option>
                                        @foreach($br as $b)
                                            <option
                                                value="{{$b['id']}}" {{ $b->id==$product->brand_id ? 'selected' : ''}} >{{$b['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 physical_product_show">
                                    <div class="form-group">
                                        <label for="name" class="title-color">{{\App\CPU\Helpers::translate('Unit')}}</label>
                                        <select
                                            class="js-example-basic-multiple js-states js-example-responsive form-control"
                                            name="unit">
                                            @foreach(\App\CPU\Helpers::units() as $x)
                                                <option
                                                    value={{$x}} {{ $product->unit==$x ? 'selected' : ''}}>{{$x}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-2 rest-part physical_product_show">
                        <div class="card-header">
                            <h4 class="mb-0">{{ \App\CPU\Helpers::translate('Variations') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-end">
                                <div class="col-md-6">
                                    <div class="mb-3 d-flex align-items-center gap-2">
                                        <label for="colors" class="title-color mb-0">
                                            {{ \App\CPU\Helpers::translate('Colors') }} :
                                        </label>
                                        <label class="switcher">
                                            <input type="checkbox" class="switcher_input" value="{{ old('colors_active') }}"
                                                name="colors_active">
                                            <span class="switcher_control"></span>
                                        </label>
                                    </div>
                                    <select
                                        class="js-example-basic-multiple js-states js-example-responsive form-control color-var-select"
                                        name="colors[]" multiple="multiple" id="colors-selector" disabled>
                                        @foreach (\App\Model\Color::orderBy('name', 'asc')->get() as $key => $color)
                                            <option value="{{ $color->code }}">
                                                {{ $color['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="attributes" class="title-color">
                                        {{ \App\CPU\Helpers::translate('Attributes') }} :
                                    </label>
                                    <select
                                        class="js-example-basic-multiple js-states js-example-responsive form-control"
                                        name="choice_attributes[]" id="choice_attributes" multiple="multiple">
                                        @foreach (\App\Model\Attribute::orderBy('name', 'asc')->get() as $key => $a)
                                            <option value="{{ $a['id'] }}">
                                                {{ $a['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-12 mt-2 mb-2">
                                    <div class="customer_choice_options" id="customer_choice_options"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-2 rest-part">
                        <div class="card-header">
                            <h4 class="mb-0">{{ \App\CPU\Helpers::translate('Product price & stock') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-end">
                                <div class="col-md-6 form-group">
                                    <label class="title-color">{{ \App\CPU\Helpers::translate('Unit price') }}</label>
                                    <input type="number" min="0" step="0.01"
                                        placeholder="{{ \App\CPU\Helpers::translate('Unit price') }}" name="unit_price"
                                        value="{{ old('unit_price') }}" class="form-control" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="title-color">{{ \App\CPU\Helpers::translate('Purchase price') }}</label>
                                    <input type="number" min="0" step="0.01"
                                        placeholder="{{ \App\CPU\Helpers::translate('Purchase price') }}"
                                        value="{{ old('purchase_price') }}" name="purchase_price"
                                        class="form-control" required>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label class="title-color">{{ \App\CPU\Helpers::translate('Tax') }}</label>
                                    <label class="text-info">{{ \App\CPU\Helpers::translate('Percent') }} ( % )</label>
                                    <input type="number" min="0" value="0" step="0.01"
                                        placeholder="{{ \App\CPU\Helpers::translate('Tax') }}" name="tax"
                                        value="{{ old('tax') }}" class="form-control">
                                    <input name="tax_type" value="percent" class="d-none">
                                </div>

                                <div class="col-md-4 form-group">
                                    <label class="title-color">{{ \App\CPU\Helpers::translate('Discount') }}</label>
                                    <input type="number" min="0" value="0"
                                           step="0.01" placeholder="{{ \App\CPU\Helpers::translate('Discount') }}"
                                           name="discount" class="form-control" required>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label class="title-color">{{ \App\CPU\Helpers::translate('Discount_Type') }}</label>
                                    <select class="js-example-basic-multiple js-states js-example-responsive demo-select2 w-100"
                                        name="discount_type">
                                        <option value="flat">{{ \App\CPU\Helpers::translate('Flat') }}</option>
                                        <option value="percent">{{ \App\CPU\Helpers::translate('Percent') }}</option>
                                    </select>
                                </div>

                                <div class="col-12 form-group sku_combination" id="sku_combination"></div>

                                <div class="col-md-3 form-group physical_product_show" id="quantity">
                                    <label class="title-color">{{ \App\CPU\Helpers::translate('total') }}
                                        {{ \App\CPU\Helpers::translate('Quantity') }}</label>
                                    <input type="number" min="0" value="0" step="1"
                                            placeholder="{{ \App\CPU\Helpers::translate('Quantity') }}" name="current_stock"
                                            class="form-control" required>
                                </div>
                                <div class="col-md-3 form-group" id="minimum_order_qty">
                                    <label class="title-color">
                                        {{ \App\CPU\Helpers::translate('minimum_order_quantity') }}</label>
                                    <input type="number" min="1" value="1" step="1"
                                        placeholder="{{ \App\CPU\Helpers::translate('minimum_order_quantity') }}" name="minimum_order_qty"
                                        class="form-control" required>
                                </div>
                                <div class="col-md-3 form-group physical_product_show" id="shipping_cost">
                                    <label class="title-color">{{ \App\CPU\Helpers::translate('shipping_cost') }} </label>
                                    <input type="number" min="0" value="" step="1"
                                        placeholder="{{ \App\CPU\Helpers::translate('shipping_cost') }}" name="shipping_cost"
                                        class="form-control" required>
                                </div>
                                <div class="col-md-3 form-group physical_product_show" id="shipping_cost_multy">
                                    <div>
                                        <label
                                            class="title-color">{{ \App\CPU\Helpers::translate('shipping_cost_multiply_with_quantity') }}
                                        </label>
                                    </div>
                                    <div>
                                        <label class="switcher">
                                            <input type="checkbox" class="switcher_input" name="multiplyQTY">
                                            <span class="switcher_control"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-2 mb-2 rest-part">
                        <div class="card-header">
                            <h4 class="mb-0">{{ \App\CPU\Helpers::translate('seo_section') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label class="title-color">{{ \App\CPU\Helpers::translate('Meta Title') }}</label>
                                    <input type="text" name="meta_title" placeholder="" class="form-control">
                                </div>

                                <div class="col-md-8 form-group">
                                    <label class="title-color">{{ \App\CPU\Helpers::translate('Meta Description') }}</label>
                                    <textarea rows="10" type="text" name="meta_description" class="form-control"></textarea>
                                </div>

                                <div class="col-md-4 form-group">
                                    <div class="">
                                        <label class="title-color">{{ \App\CPU\Helpers::translate('Meta Image') }}</label>
                                    </div>
                                    <div class="border border-dashed">
                                        <div class="row" id="meta_img"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-2 rest-part">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <div class="mb-2">
                                        <label class="title-color">{{ \App\CPU\Helpers::translate('Youtube video link') }}</label>
                                        <span class="text-info"> (
                                            {{ \App\CPU\Helpers::translate('optional, please provide embed link not direct link') }}.
                                            )</span>
                                    </div>
                                    <input type="text" name="video_link"
                                        placeholder="{{ \App\CPU\Helpers::translate('EX') }} : https://www.youtube.com/embed/5R06LRdUCSE"
                                        class="form-control" required>
                                </div>

                                <div class="col-md-8 form-group">
                                    <div class="mb-2">
                                        <label class="title-color">{{ \App\CPU\Helpers::translate('Upload product images') }}</label>
                                        <span class="text-info">* ( {{ \App\CPU\Helpers::translate('ratio') }} 1:1 )</span>
                                    </div>
                                    <div class="p-2 border border-dashed">
                                        <div class="row" id="coba"></div>
                                    </div>

                                </div>

                                <div class="col-md-4 form-group">
                                    <div class="mb-2">
                                        <label for="name" class="title-color text-capitalize">{{ \App\CPU\Helpers::translate('Upload thumbnail') }}</label>
                                        <span class="text-info">* ( {{ \App\CPU\Helpers::translate('ratio') }} 1:1 )</span>
                                    </div>
                                    <div>
                                        <div class="row" id="thumbnail"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-end gap-3 mt-3" hidden>
                        <button type="reset" class="btn btn-secondary">{{ \App\CPU\Helpers::translate('reset') }}</button>
                        <button type="button" onclick="check()" class="btn btn--primary btn-primary">{{ \App\CPU\Helpers::translate('Submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('public/assets/back-end') }}/js/tags-input.min.js"></script>
    <script src="{{ asset('public/assets/back-end/js/spartan-multi-image-picker.js') }}"></script>
    <script>
        $(function() {
            $("#coba").spartanMultiImagePicker({
                fieldName: 'images[]',
                maxCount: 10,
                rowHeight: 'auto',
                groupClassName: 'col-6',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{ asset('public/assets/back-end/img/400x400/img2.jpg') }}',
                    width: '100%',
                },
                dropFileLabel: "Drop Here",
                onAddRow: function(index, file) {

                },
                onRenderedPreview: function(index) {

                },
                onRemoveRow: function(index) {

                },
                onExtensionErr: function(index, file) {
                    toastr.error(
                    '{{ \App\CPU\Helpers::translate('Please only input png or jpg type file') }}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function(index, file) {
                    toastr.error('{{ \App\CPU\Helpers::translate('File size too big') }}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });

            $("#thumbnail").spartanMultiImagePicker({
                fieldName: 'image',
                maxCount: 1,
                rowHeight: 'auto',
                groupClassName: 'col-12',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{ asset('public/assets/back-end/img/400x400/img2.jpg') }}',
                    width: '100%',
                },
                dropFileLabel: "Drop Here",
                onAddRow: function(index, file) {

                },
                onRenderedPreview: function(index) {

                },
                onRemoveRow: function(index) {

                },
                onExtensionErr: function(index, file) {
                    toastr.error(
                    '{{ \App\CPU\Helpers::translate('Please only input png or jpg type file') }}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function(index, file) {
                    toastr.error('{{ \App\CPU\Helpers::translate('File size too big') }}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });

            $("#meta_img").spartanMultiImagePicker({
                fieldName: 'meta_image',
                maxCount: 1,
                rowHeight: '280px',
                groupClassName: 'col-12',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{ asset('public/assets/back-end/img/400x400/img2.jpg') }}',
                    width: '90%',
                },
                dropFileLabel: "Drop Here",
                onAddRow: function(index, file) {

                },
                onRenderedPreview: function(index) {

                },
                onRemoveRow: function(index) {

                },
                onExtensionErr: function(index, file) {
                    toastr.error(
                    '{{ \App\CPU\Helpers::translate('Please only input png or jpg type file') }}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function(index, file) {
                    toastr.error('{{ \App\CPU\Helpers::translate('File size too big') }}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileUpload").change(function() {
            readURL(this);
        });


        $(".js-example-theme-single").select2({
            theme: "classic"
        });

        $(".js-example-responsive").select2({
            // dir: "rtl",
            width: 'resolve'
        });
    </script>

    <script>
        function getRequest(route, id, type) {
            $.get({
                url: route,
                dataType: 'json',
                success: function(data) {
                    if (type == 'select') {
                        $('#' + id).empty().append(data.select_tag);
                    }
                },
            });
        }

        $('input[name="colors_active"]').on('change', function() {
            if (!$('input[name="colors_active"]').is(':checked')) {
                $('#colors-selector').prop('disabled', true);
            } else {
                $('#colors-selector').prop('disabled', false);
            }
        });

        $('#choice_attributes').on('change', function() {
            $('#customer_choice_options').html(null);
            $.each($("#choice_attributes option:selected"), function() {
                //console.log($(this).val());
                add_more_customer_choice_option($(this).val(), $(this).text());
            });
        });

        function add_more_customer_choice_option(i, name) {
            let n = name.split(' ').join('');
            $('#customer_choice_options').append(
                '<div class="row"><div class="col-md-3"><input type="hidden" name="choice_no[]" value="' + i +
                '"><input type="text" class="form-control" name="choice[]" value="' + n +
                '" placeholder="{{ trans('Choice Title') }}" readonly></div><div class="col-lg-9"><input type="text" class="form-control" name="choice_options_' +
                i +
                '[]" placeholder="{{ trans('Enter choice values') }}" data-role="tagsinput" onchange="update_sku()"></div></div>'
                );

            $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput();
        }


        $('#colors-selector').on('change', function() {
            update_sku();
        });

        $('input[name="unit_price"]').on('keyup', function() {
            let product_type = $('#product_type').val();
            if(product_type === 'physical') {
                update_sku();
            }
        });

        function update_sku() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: '{{ route('seller.product.sku-combination') }}',
                data: $('#product_form').serialize(),
                success: function(data) {
                    $('#sku_combination').html(data.view);
                    if (data.length > 1) {
                        $('#quantity').hide();
                    } else {
                        $('#quantity').show();
                    }
                }
            });
        }

        $(document).ready(function() {
            // color select select2
            $('.color-var-select').select2({
                templateResult: colorCodeSelect,
                templateSelection: colorCodeSelect,
                escapeMarkup: function(m) {
                    return m;
                }
            });

            function colorCodeSelect(state) {
                var colorCode = $(state.element).val();
                if (!colorCode) return state.text;
                return "<span class='color-preview' style='background-color:" + colorCode + ";'></span>" + state
                    .text;
            }
        });
    </script>

    <script>
        function check() {
            Swal.fire({
                title: '{{ \App\CPU\Helpers::translate('Are you sure') }}?',
                text: '{{ \App\CPU\Helpers::translate('Want to add this product') }}',
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#377dff',
                cancelButtonText: 'No',
                confirmButtonText: 'Yes',
                reverseButtons: true
            }).then((result) => {
                for (instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }
                var formData = new FormData(document.getElementById('product_form'));
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post({
                    url: '{{ route('seller.product.store') }}',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        // console.log(data.errors);
                        // return false;
                        if (data.errors) {
                            for (var i = 0; i < data.errors.length; i++) {
                                var nm = data.errors[i].code.indexOf('.') >= 0 ? data.errors[i].code.replace('.','[')+']' : data.errors[i].code;
                                var result = nm.match(/\[(.*)\]/);
                                if(result){
                                    if(!isNaN(parseInt(result[1]))){
                                        nm = nm.replace(result[0],'[]')
                                    }
                                }
                                $("input[name='"+nm+"']").addClass("error_required");
                                $("input[name='"+nm+"']").closest('.foldable-section').slideDown();
                            }
                            toastr.error("{{ Helpers::translate('Please fill all red bordered fields') }}", {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        } else {
                            toastr.success(
                            '{{ \App\CPU\Helpers::translate('product added successfully') }}!', {
                                CloseButton: true,
                                ProgressBar: true
                            });
                            $('#product_form').submit();
                        }
                    }
                });
            })
        };
    </script>


    <script>
        $(".lang_link").click(function(e) {
            e.preventDefault();
            $(".lang_link").removeClass('active');
            $(".lang_form").addClass('d-none');
            $(this).addClass('active');

            let form_id = this.id;
            let lang = form_id.split("-")[0];
            console.log(lang);
            $("#" + lang + "-form").removeClass('d-none');
            if (lang == '{{ $default_lang }}') {
                $(".rest-part").removeClass('d-none');
            } else {
                $(".rest-part").addClass('d-none');
            }
        })

        $(document).ready(function(){
            product_type();
            digital_product_type();

            $('#product_type').change(function(){
                product_type();
            });

            $('#digital_product_type').change(function(){
                digital_product_type();
            });
        });

        function product_type(){
            let product_type = $('#product_type').val();

            if(product_type === 'physical'){
                $('#digital_product_type_show').hide();
                $('#digital_file_ready_show').hide();
                $('.physical_product_show').show();
                $('#digital_product_type').val($('#digital_product_type option:first').val());
                $('#digital_file_ready').val('');
            }else if(product_type === 'digital'){
                $('#digital_product_type_show').show();
                $('.physical_product_show').hide();

            }
        }

        function digital_product_type(){
            let digital_product_type = $('#digital_product_type').val();
            if (digital_product_type === 'ready_product') {
                $('#digital_file_ready_show').show();
            } else if (digital_product_type === 'ready_after_sell') {
                $('#digital_file_ready_show').hide();
                $("#digital_file_ready").val('');
            }
        }
    </script>

    {{-- ck editor --}}
    <script src="{{ asset('/') }}vendor/ckeditor/ckeditor/ckeditor.js"></script>
    <script src="{{ asset('/') }}vendor/ckeditor/ckeditor/adapters/jquery.js"></script>
    <script>
        $('.textarea').ckeditor({
            contentsLangDirection: '{{ Session::get('direction') }}',
        });
    </script>

    {{-- ck editor --}}
@endpush
