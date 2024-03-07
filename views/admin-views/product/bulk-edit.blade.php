@extends('layouts.back-end.app')


@if (request()->has('ids') || isset($ids))
@section('title', Helpers::translate('edit multiple products'))
@else
@section('title', (!$product->id) ? Helpers::translate('Product Add') : Helpers::translate('Product Edit'))
@endif

@push('css_or_js')
    <link href="{{asset('public/assets/back-end/css/tags-input.min.css')}}" rel="stylesheet">
    <link href="{{ asset('public/assets/select2/css/select2.min.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .primary_section * .input-group-text{
            width: 50%;
        }
    </style>
@endpush

@section('content')
    @php
    $local = session()->has('local')?session('local'):'en';
    $admin_shipping = \App\Model\ShippingType::where('seller_id',0)->first();
    $shippingType =isset($admin_shipping)==true?$admin_shipping->shipping_type:'order_wise';
    @endphp
    <!-- Page Heading -->

    <div class="content container-fluid">
        <div class="row">
            <div class="col-lg-5">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\Helpers::translate('Dashboard')}}</a></li>
                        @switch($product->added_by)
                            @case('admin')
                                <li class="breadcrumb-item mx-1" aria-current="page"><a href="{{route('admin.product.list',['type'=>'in_house'])}}">{{\App\CPU\Helpers::translate('Products')}}</a></li>
                                @break
                            @case('seller')
                                @if($product->request_status == 0)
                                @if(\Carbon\Carbon::parse($product->updated_at) == \Carbon\Carbon::parse($product->created_at))
                                <li class="breadcrumb-item mx-1" aria-current="page"><a href="{{route('admin.product.list',['seller', 'status'=>'0'])}}">{{\App\CPU\Helpers::translate('New Products')}}</a></li>
                                @else
                                <li class="breadcrumb-item mx-1" aria-current="page"><a href="{{route('admin.product.updated-product-list')}}">{{\App\CPU\Helpers::translate('updated_products')}}</a></li>
                                @endif
                                @elseif($product->request_status == 1)
                                <li class="breadcrumb-item mx-1" aria-current="page"><a href="{{route('admin.product.list',['seller', 'status'=>'1'])}}">{{\App\CPU\Helpers::translate('Approved Products')}}</a></li>
                                @elseif($product->request_status == 2)
                                <li class="breadcrumb-item mx-1" aria-current="page"><a href="{{route('admin.product.list',['seller', 'status'=>'2'])}}">{{\App\CPU\Helpers::translate('Denied Products')}}</a></li>
                                @endif
                                @break
                            @default

                        @endswitch
                        <li class="breadcrumb-item"><a href="#">{{(!$product->id) ? Helpers::translate('Product Add') : Helpers::translate('Product Edit')}}</a></li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row mt-0">
            <!-- End Page Title -->
            <div class="col-lg-7" hidden>
                <div class="d-flex table-actions flex-wrap justify-content-end mx-3">
                    <div class="d-flex">
                    <a title="{{Helpers::translate('Add new')}}" class="btn ti-plus btn-success my-2 btn-icon-text m-2" href="{{route('admin.product.add-new')}}">
                        <i class="fa fa-plus"></i>
                    </a>
                    <button title="{{Helpers::translate('Add from')}}" class="btn btn-info mdi mdi-arrange-bring-forward btnAddFrom my-2 btn-icon-text m-2" onclick="addFrom('products')"
                    @if(!$product->id)
                    disabled
                    @endif
                    >
                        <i class="fa fa-clone"></i>
                    </button>

                    <button disabled class="btn ti-save btn-success my-2 btn-icon-text m-2 save-btn" style="display: none"
                    onclick="$('.table').removeClass('editMode');$('.edit-btn').show();$(this).hide();saveTableChanges()">
                        <i class="fa fa-save"></i>
                    </button>

                    <button title="{{Helpers::translate('Edit')}}" class="btn btn-info my-2 btn-icon-text m-2 save-btn"
                    onclick="$('.btn-save').click()">
                        <i class="fa fa-save"></i>
                    </button>

                    <button title="{{Helpers::translate('delete')}}" class="btnDeleteRow btn ti-trash btn-danger my-2 btn-icon-text m-2"
                    onclick="form_alert('bulk-delete','Want to delete this item ?')"
                    @if(!$product->id)
                    disabled
                    @endif
                    >
                        <i class="fa fa-trash"></i>
                    </button>
                    <form hidden action="{{route('admin.product.bulk-delete')}}" method="post" id="bulk-delete">
                        @csrf @method('delete')
                        <input type="text" name="ids" class="ids" value="{{$product['id']}}">
                        <input type="text" name="back" value="1">
                    </form>

                    <button disabled class="btn btn-info my-2 btn-icon-text m-2" onclick="$('.products-dataTable').addClass('gridTable');$('.dataTables_scrollBody').css('max-height','650px')">
                        <i class="fa fa-th"></i>
                    </button>
                    <button disabled class="btn btn-info ti-menu-alt my-2 btn-icon-text m-2" onclick="$('.products-dataTable').removeClass('gridTable');$('.dataTables_scrollBody').css('max-height',dataTables_scrollBody_height)">
                        <i class="fa fa-table"></i>
                    </button>

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
                                <a aria-expanded="false" aria-haspopup="true" class="dropdown-item dropdown-toggle bulk-import-export" data-toggle="dropdown" id="droprightMenuButton" type="button"
                                onclick='$(".dt-button-collection").remove();'>
                                    <i class="ti-angle-down"></i>
                                    {{\App\CPU\Helpers::translate('Import/Export')}}
                                </a>
                                <div aria-labelledby="droprightMenuButton" class="dropdown-menu tx-13" style="position: absolute;will-change: transform;top: -10%;left: -100%;transform: translate3d(0px, 145px, 0px);">
                                    <a class="dropdown-item bulk-export" href="{{route('admin.product.bulk-export')}}">
                                        {{\App\CPU\Helpers::translate('export to excel')}}
                                    </a>
                                    <a class="dropdown-item bulk-import" href="{{route('admin.product.bulk-import')}}">
                                        {{\App\CPU\Helpers::translate('import from excel')}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($product['added_by'] == 'seller' && ($product['request_status'] !== "1" || $product['request_status'] == 1))
        <div class="d-flex justify-content-sm-start flex-wrap gap-2 mb-3">
            <div>
                @if($product['request_status'] !== 1 || $product['is_shipping_cost_updated'] == 0)
                    <a href="{{route('admin.product.approve-status', ['id'=>$product['id']])}}"
                        class="btn btn--primary btn-primary">
                        {{\App\CPU\Helpers::translate('Approve')}}
                    </a>
                @endif
            </div>
            <div>
                @if($product['request_status'] == "2")

                @else
                <button class="btn btn-warning" data-toggle="modal" data-target="#publishNoteModal">
                    {{\App\CPU\Helpers::translate('deny')}}
                </button>
                @endif
                <!-- Modal -->
                <div class="modal fade" id="publishNoteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"
                                    id="exampleModalLabel">{{ \App\CPU\Helpers::translate('denied_note') }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form class="form-group"
                                    action="{{ route('admin.product.deny', ['id'=>$product['id']]) }}"
                                    method="post">
                                <div class="modal-body">
                                    <textarea class="form-control" name="denied_note" rows="3"></textarea>
                                    <input type="hidden" name="_token" id="csrf-token"
                                            value="{{ csrf_token() }}"/>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{\App\CPU\Helpers::translate('Close')}}
                                    </button>
                                    <button type="submit" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('Save changes')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @elseif($product['request_status'] == 2)
        <!-- Card -->
        <div class="card mb-3 mb-lg-5 mt-2 mt-lg-3 bg-warning">
            <!-- Body -->
            <div class="card-body text-center">
                <span class="text-dark">{{ $product['denied_note'] }}</span>
            </div>
        </div>
        @endif

        @if(request()->has('ids'))
        <?php
            $ids = request('ids')
        ?>
        @endif
        <!-- Content Row -->
        <div class="card">
            <div class="row">
                <div class="col-md-12">
                    <form class="product-form"
                    @if(request()->has('ids') || isset($ids))
                    action="{{ route('admin.product.bulk-edit') }}"
                    @else
                    action="{{($product->id) ? route('admin.product.update',$product->id) : route('admin.product.update',0)}}"
                    @endif
                    method="post"
                        style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                        enctype="multipart/form-data"
                        id="product_form">
                        <div class="p-3">
                            @if (request()->has('ids') || isset($ids))
                            <h3 class="mb-3" role="button" onclick="$(this).next('div').slideToggle()">
                                {{ Helpers::translate('Products that will be included in the amendments') }}:
                            </h3>
                            <div style="display: none">
                            @foreach (explode(',',$ids) as $idd)
                                <p>
                                    <a target="_blank" href="{{ route('admin.product.edit', $idd) }}">{{ Helpers::get_prop('App\Model\Product',$idd,'name') }}</a>
                                </p>
                            @endforeach
                            </div>
                            <input type="hidden" name="ids" value="{{ $ids }}" />
                            @endif
                        </div>
                        @csrf
                        <div class="card mt-2 rest-part">
                            <div class="card-header p-3 tx-medium my-auto tx-white bg-primary">
                                <div class="d-flex btn text-white w-100" onclick="$(this).closest('.card-header').next('.foldable-section').slideToggle();$(this).closest('.card-header').find('.toggleAngle').toggle()">
                                    <h4 class="ml-2 mr-2 pt-2 text-white">
                                        <i class="fa fa-angle-down toggleAngle" style=""></i>
                                        <i class="fa fa-angle-up toggleAngle" style="display:none"></i>
                                    </h4>
                                    <h5 class="mt-2 text-white">{{\App\CPU\Helpers::translate("the Basic information")}}</h5>
                                </div>
                            </div>
                            <div class="card-body pt-0 px-3 foldable-section">
                                <div class="row">
                                    <div class="card col-lg-4 mt-2 px-3">
                                        <div class="px-3 pt-3">
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
                                            <ul class="nav nav-tabs lightSlider w-fit-content mb-0 px-6">
                                                @foreach(Helpers::get_langs() as $lang)
                                                    <li class="nav-item text-capitalize">
                                                        <a class="nav-link lang_link {{$lang == ($default_lang ?? session()->get('local'))? 'active':''}}" href="#"
                                                        id="{{$lang}}-link"><img class="ml-2" width="20" src="{{asset('public/assets/front-end')}}/img/flags/{{$lang}}.png">{{\App\CPU\Helpers::get_language_name($lang).'('.strtoupper($lang).')'}}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>

                                        <div class="card-body px-2">
                                            @foreach(Helpers::get_langs() as $lang)
                                                <?php
                                                if (count($product['translations'])) {
                                                    $translate = [];
                                                    foreach ($product['translations'] as $t) {

                                                        if ($t->locale == $lang && $t->key == "name") {
                                                            $translate[$lang]['name'] = $t->value;
                                                        }
                                                        if ($t->locale == $lang && $t->key == "description") {
                                                            $translate[$lang]['description'] = $t->value;
                                                        }
                                                        if ($t->locale == $lang && $t->key == "short_desc") {
                                                            $translate[$lang]['short_desc'] = $t->value;
                                                        }
                                                        if ($t->locale == $lang && $t->key == "promo_title") {
                                                            $translate[$lang]['promo_title'] = $t->value;
                                                        }

                                                    }
                                                }
                                                ?>
                                                <div class="{{$lang != session()->get('local')? 'd-none':''}} lang_form" id="{{$lang}}-form">

                                                    <div class="form-group">
                                                        <label class="title-color label-w-btn" for="{{$lang}}_promo_title">{{\App\CPU\Helpers::translate('Promo title position')}}<span class="text-danger"></span>
                                                            ({{strtoupper($lang)}})
                                                        </label>
                                                        <select name="promo_pos[]" id="{{$lang}}_promo_pos" class="form-control">
                                                            <option @if(Helpers::get_prop('App\Model\Product',$product->id,'promo_pos') == 'top-right') selected @endif value="top-right">{{ Helpers::translate('top right') }}</option>
                                                            <option @if(Helpers::get_prop('App\Model\Product',$product->id,'promo_pos') == 'top-left') selected @endif value="top-left">{{ Helpers::translate('top left') }}</option>
                                                            <option @if(Helpers::get_prop('App\Model\Product',$product->id,'promo_pos') == 'bottom-right') selected @endif value="bottom-right">{{ Helpers::translate('bottom right') }}</option>
                                                            <option @if(Helpers::get_prop('App\Model\Product',$product->id,'promo_pos') == 'bottom-left') selected @endif value="bottom-left">{{ Helpers::translate('bottom left') }}</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group px-3">
                                                        <div class="row">
                                                            <div class="col-6 px-1">
                                                                <div class="input-group mb-3">
                                                                    <label class="text-start" style="width: 150px" id="basic-addon1">
                                                                        {{\App\CPU\Helpers::translate('Promo title background color')}}
                                                                    </label>
                                                                    <input name="promo_bg[]" value="{{Helpers::get_prop('App\Model\Product',$product->id,'promo_bg') ?? '#373f50'}}" type="color" class="form-control text-dark">
                                                                </div>
                                                            </div>
                                                            <div class="col-6 px-1">
                                                                <div class="input-group mb-3">
                                                                    <label class="text-start" style="width: 150px" id="basic-addon1">
                                                                        {{\App\CPU\Helpers::translate('Promo title text color')}}
                                                                    </label>
                                                                    <input name="promo_text[]" value="{{Helpers::get_prop('App\Model\Product',$product->id,'promo_text') ?? '#FFFFFF'}}" type="color" class="form-control text-dark">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <input type="hidden" name="lang[]" value="{{$lang}}">

                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="card col-lg-4 mt-2 px-3">
                                        <div class="card-body px-0">
                                            <div class="input-group mb-4 w-100 multiSelect2Div">
                                                <div class="input-group-text bg-primary text-light text-start">
                                                    <span class="" style="width: 276px" id="basic-addon1">{{\App\CPU\Helpers::translate('Category')}}</span>
                                                </div>
                                                <div class="form-control p-0">
                                                    <select
                                                        class="SumoSelect-custom"
                                                        multiple
                                                        id="category_id"
                                                        onchange="getRequest('{{url('/')}}/admin/product/get-categories?parent_id='+this.value,'sub-category-select','select');refreshMainCat(this)">
                                                        @foreach($categories as $category)
                                                            <option value="{{$category['id']}}" {{ (in_array($category->id,explode(',',(isset($product_category[0])) ? $product_category[0]->id : '[]'))) ? 'selected' : ''}}
                                                                icon='{{asset("storage/app/public/category/".(\App\CPU\Helpers::get_prop('App\Model\Category',$category['id'],'image',session()->get('local')) ?? $category->icon))}}'
                                                                >
                                                                {{\App\CPU\Helpers::getItemName('categories','name',$category['id'])}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <input type="hidden" name="category_id" value="{{isset($product_category[0]) ? $product_category[0]->id : ''}}" />
                                            </div>
                                            @php($show_main_category = \App\Model\BusinessSetting::where('type','show_main_category')->first()->value ?? '')
                                            @if($show_main_category)
                                            <div class="input-group mb-4 w-100 multiSelect2Div main_category-container">
                                                <div class="input-group-text bg-primary text-light text-start">
                                                    <span class="" style="width: 276px" id="basic-addon1">{{\App\CPU\Helpers::translate('Main Category')}}</span>
                                                </div>
                                                <div class="form-control p-0">
                                                    <select
                                                        class="SumoSelect-custom"
                                                        id="main_category"
                                                        name="main_category">
                                                        @foreach($categories as $category)
                                                            <option
                                                            @if((in_array($category->id,explode(',',(isset($product_category[0])) ? $product_category[0]->id : '[]')))) @else disabled @endif
                                                            value="{{$category['id']}}" {{ ($product['main_category'] == $category['id']) ? 'selected' : ''}}
                                                                icon='{{asset("storage/app/public/category/".(\App\CPU\Helpers::get_prop('App\Model\Category',$category['id'],'image',session()->get('local')) ?? $category->icon))}}'
                                                                >
                                                                {{\App\CPU\Helpers::getItemName('categories','name',$category['id'])}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>
                                            @endif



                                            <div class="input-group mb-3 select2Div brand_id_div">
                                                <div class="input-group-text bg-primary text-light text-start">
                                                    <span class="" style="width: 276px" id="basic-addon1">{{\App\CPU\Helpers::translate('Brand')}}</span>
                                                </div>
                                                <div class="form-control p-0">
                                                    <select
                                                        class="SumoSelect-custom form-control"
                                                        name="brand_id">
                                                        <option value="{{null}}" selected disabled>---{{\App\CPU\Helpers::translate('Select')}}---</option>
                                                        @foreach($br as $b)
                                                            <option
                                                            icon="{{asset('storage/app/public/brand')}}/{{(\App\CPU\Helpers::get_prop('App\Model\Brand',$b['id'],'image',session()->get('local')) ?? $b['image'])}}"
                                                                value="{{$b['id']}}" {{ $b->id==$product->brand_id ? 'selected' : ''}} >
                                                                @php($name = $b['name'])
                                                                @foreach($b['translations'] as $t)
                                                                    @if($t->locale == App::getLocale() && $t->key == "name")
                                                                        @php($name = $t->value)
                                                                    @else
                                                                        @php($name = $b['name'])
                                                                    @endif
                                                                @endforeach
                                                                {{ $name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                            </div>
                                            </div>






                                            <div class="row px-1">
                                                <div class="col-lg-4 px-2">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-text bg-primary text-light text-start">
                                                            <span class="text-start" style="width: 55px" id="basic-addon1">{{\App\CPU\Helpers::translate('Length')}}</span>
                                                        </div>
                                                        <input name="length" aria-describedby="basic-addon1" value="{{$product->length}}"
                                                        class="form-control text-dark" placeholder="" type="text" required>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 px-2">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-text bg-primary text-light text-start">
                                                            <span class="text-start" style="width: 55px" id="basic-addon1">{{\App\CPU\Helpers::translate('Width')}}</span>
                                                        </div>
                                                        <input name="width" aria-describedby="basic-addon1" value="{{$product->width}}"
                                                        class="form-control text-dark" placeholder="" type="text" required>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 px-2">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-text bg-primary text-light text-start">
                                                            <span class="text-start" style="width: 55px" id="basic-addon1">{{\App\CPU\Helpers::translate('Height')}}</span>
                                                        </div>
                                                        <input name="height" aria-describedby="basic-addon1" value="{{$product->height}}"
                                                        class="form-control text-dark" placeholder="" type="text" required>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row px-1">
                                                <div class="col-lg-4 px-2">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-text bg-primary text-light text-start">
                                                            <span class="text-start" style="width: 55px" id="basic-addon1">{{\App\CPU\Helpers::translate('Size')}}</span>
                                                        </div>
                                                        <input name="size" aria-describedby="basic-addon1" value="{{$product->size}}"
                                                        class="form-control text-dark" placeholder="" type="text" required>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 px-2">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-text bg-primary text-light text-start">
                                                            <span class="text-start" style="width: 55px" id="basic-addon1">{{\App\CPU\Helpers::translate('space')}}</span>
                                                        </div>
                                                        <input name="space" aria-describedby="basic-addon1" value="{{$product->space}}"
                                                        class="form-control text-dark" placeholder="" type="text" required>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 px-2">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-text bg-primary text-light text-start">
                                                            <span class="text-start" style="width: 55px" id="basic-addon1">{{\App\CPU\Helpers::translate('weight')}}</span>
                                                        </div>
                                                        <input name="weight" aria-describedby="basic-addon1" value="{{$product->weight}}"
                                                        class="form-control text-dark" placeholder="" type="text" required>
                                                    </div>
                                                </div>

                                            </div>


                                            <div class="row px-1">
                                                <div class="col-lg-4 px-2">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-text bg-primary text-light text-start">
                                                            <span class="text-start" style="width: 55px" id="basic-addon1">{{\App\CPU\Helpers::translate('Unit')}}</span>
                                                        </div>
                                                        <select

                                                            class="form-control unit-form-control px-1"
                                                            name="unit">
                                                            <option value=""></option>
                                                            @foreach(\App\CPU\Helpers::units() as $x)
                                                                <option
                                                                    value={{$x}} {{ $product->unit==$x ? 'selected' : ''}}>{{$x}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 px-2">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-text bg-primary text-light text-start">
                                                            <span class="text-start" style="width: 55px" id="basic-addon1">{{\App\CPU\Helpers::translate('Made in')}}</span>
                                                        </div>
                                                        <input name="made_in" aria-describedby="basic-addon1" value="{{$product->made_in}}"
                                                        class="form-control text-dark" placeholder="" type="text" required>
                                                    </div>
                                                </div>



                                                <div class="col-lg-4 px-2">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-text bg-primary text-light text-start mx-0 px-2">
                                                            <span class="text-start" style="width: 68px" id="basic-addon1">{{\App\CPU\Helpers::translate('color')}}</span>
                                                        </div>
                                                        <div class="form-group form-group-color p-0 m-0" style="width: 65px">

                                                            <input name="color" value="{{$product->color ?? '#000011'}}" type="color"
                                                            width="85px"
                                                            class="form-control text-dark" >
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            @if(!$product->request_status && $product->id && $product->added_by == "seller")
                                            <div class="bg-light pr-2 pl-2 m-0 mt-1 pt-2 pb-4 rounded-15 w-100">
                                                <p class="text-warning">
                                                    {{ Helpers::translate('Product must be approved to be published on market/app') }}
                                                </p>
                                            </div>
                                            @else
                                            <div class="bg-light pr-2 pl-2 m-0 mt-1 pt-2 pb-4 rounded-15 w-100">
                                                <div class="row mb-4">
                                                    <div class="col-lg-12">
                                                        <div class="mb-3 d-flex align-items-center gap-2">
                                                            <label class="switcher title-color">
                                                                <input type="checkbox" class="switcher_input"
                                                                value="1"
                                                                inputsClass="publish_on_market"
                                                                name="publish_on_market" {{($product['publish_on_market'] || $product['status'])?'checked':''}}>
                                                                <span class="switcher_control"></span>
                                                            </label>
                                                            <label class="mb-0 title-color" for="switcher">
                                                                {{\App\CPU\Helpers::translate('Publish on market')}}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 publish_on_market publish_on_market_on" @if(!$product->publish_on_market) style="display:none" @endif>
                                                        <div class="">
                                                            <div class="input-group mt-0 mb-0">
                                                                <div class="input-group-text bg-primary text-light text-start">
                                                                    <span class="input-group-append border-0 text-light">{{\App\CPU\Helpers::translate('Publish date & time')}}</span>
                                                                </div>
                                                                <input name="publish_on_market_date" class="form-control border-0 fc-datepicker col-4 p-0" placeholder="DD/MM/YYYY" type="date" value="{{$product->publish_on_market_date ?? Carbon\Carbon::now()->format('Y-m-d')}}">
                                                                <input name="publish_on_market_time" class="form-control border-0 col-13" placeholder="HH:mm" type="time" value="{{$product->publish_on_market_time ?? Carbon\Carbon::now()->format('H:i')}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-lg-12">
                                                        <div class="mb-3 d-flex align-items-center gap-2">
                                                            <label class="switcher title-color">
                                                                <input type="checkbox" class="switcher_input"
                                                                value="1"
                                                                inputsClass="publish_on_app"
                                                                name="publish_on_app" {{($product['publish_on_app'])?'checked':''}}>
                                                                <span class="switcher_control"></span>
                                                            </label>
                                                            <label class="mb-0 title-color" for="switcher">
                                                                {{\App\CPU\Helpers::translate('Publish on App')}}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 publish_on_app publish_on_app_on" @if(!$product['publish_on_app']) style="display:none" @endif>
                                                        <div class="input-group mt-0 mb-0">
                                                            <div class="input-group-text bg-primary text-light text-start">
                                                                <span class="input-group-append border-0 text-light">{{\App\CPU\Helpers::translate('Publish date & time')}}</span>
                                                            </div>
                                                            <input name="publish_on_app_date" class="form-control border-0 fc-datepicker col-4 p-0" placeholder="DD/MM/YYYY" type="date" value="{{$product->publish_on_app_date ?? Carbon\Carbon::now()->format('Y-m-d')}}">
                                                                <input name="publish_on_app_time" class="form-control border-0 col-13" placeholder="HH:mm" type="time" value="{{$product->publish_on_app_time ?? Carbon\Carbon::now()->format('H:i')}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3 d-flex align-items-center gap-2">
                                                    <label class="switcher title-color">
                                                        <input type="checkbox" class="switcher_input"
                                                        value="1"
                                                            name="featured" {{($product['featured'])?'checked':''}}>
                                                        <span class="switcher_control"></span>
                                                    </label>
                                                    <label class="mb-0 title-color" for="switcher">
                                                        {{\App\CPU\Helpers::translate('a featured product')}}
                                                    </label>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="card col-lg-4 mt-2 px-3">
                                        <div class="card-body p-0">
                                            <div class="py-2 px-0 row w-100 mx-0">
                                                <div class="col-lg-12 p-0" style="overflow-y: auto;height: 1070px;">
                                                    <div class="input-group mb-2  p-2">
                                                        <div class="w-50 mt-2 pb-4">
                                                            <label class="ckbox">
                                                                <input value="1" class="switch_inputs has_tax" name="has_tax" inputsClass="tax_input" @if ($product->has_tax) checked @endif type="checkbox">
                                                                <span>{{\App\CPU\Helpers::translate('The product is subject to tax')}}</span>
                                                            </label>
                                                        </div>
                                                        <div class="mb-0 tax_input_on tax_input" @if (!$product->has_tax) style="display: none" @endif>
                                                            <input type="number" min="0" value={{ $product->tax }} step="0.01"
                                                            placeholder="{{\App\CPU\Helpers::translate('Tax') }} ({{\App\CPU\Helpers::translate('Percent')}})" name="tax"
                                                            class="form-control" required>
                                                            <input name="tax_type" value="percent" class="d--none">
                                                        </div>
                                                    </div>

                                                    <div class="w-100" style="/*background-color: #f2f2f2*/">
                                                        <div class="input-group mb-2 p-2">
                                                            <div class="w-100">
                                                                <label for="name" class="title-color">{{ \App\CPU\Helpers::translate('product_type') }}</label>
                                                                <select name="product_type" id="product_type" class="form-control" required>
                                                                    <option value="physical" {{ $product->product_type=='physical' ? 'selected' : ''}}>{{ \App\CPU\Helpers::translate('physical') }}</option>
                                                                    @if($digital_product_setting)
                                                                        <option value="digital" {{ $product->product_type=='digital' ? 'selected' : ''}}>{{ \App\CPU\Helpers::translate('digital') }}</option>
                                                                    @endif
                                                                    <option value="booking" {{ $product->product_type=='booking' ? 'selected' : ''}}>{{ \App\CPU\Helpers::translate('appointment booking') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="input-group mb-2 p-2" id="digital_product_type_show">
                                                            <label for="digital_product_type" class="title-color">{{ \App\CPU\Helpers::translate("digital_product_type") }}</label>
                                                            <select name="digital_product_type" id="digital_product_type" class="form-control" required>
                                                                <option value="{{ old('digital_product_type') }}" {{ !$product->digital_product_type ? 'selected' : ''}} disabled>---Select---</option>
                                                                <option value="ready_after_sell" {{ $product->digital_product_type=='ready_after_sell' ? 'selected' : ''}}>{{ \App\CPU\Helpers::translate("Ready After Sell") }}</option>
                                                                <option value="ready_product" {{ $product->digital_product_type=='ready_product' ? 'selected' : ''}}>{{ \App\CPU\Helpers::translate("Ready Product") }}</option>
                                                            </select>
                                                        </div>
                                                        <div class="input-group mb-2 p-2" id="digital_file_ready_show">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label for="digital_file_ready" class="title-color">{{ \App\CPU\Helpers::translate("ready_product_upload") }}</label>
                                                                    <input type="file" name="digital_file_ready" id="digital_file_ready" class="form-control">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p class="h-100 mt-5">
                                                                        <a href="{{asset("storage/app/public/product/digital-product/$product->digital_file_ready")}}" target="_blank">{{ $product->digital_file_ready }}</a>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="input-group mb-2  p-2">
                                                        <div class="w-100">
                                                            <label class="ckbox">
                                                                <input value="1" name="upon_request" @if ($product->upon_request) checked @endif type="checkbox"><span>{{\App\CPU\Helpers::translate('Upon Request')}}</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="input-group mb-2  p-2">
                                                        <div class="w-100">
                                                            <label class="ckbox"><input value="1" name="irreversible" @if ($product->irreversible) checked @endif type="checkbox"><span>{{\App\CPU\Helpers::translate('Irreversible')}}</span></label>
                                                    </div>
                                                    </div>

                                                    <div class="input-group mb-2  p-2">
                                                        <div class="w-100">
                                                            <label class="ckbox">
                                                                <input value="1" class="switch_inputs" inputsClass="warranty_period_input" name="guarantee" @if ($product->guarantee) checked @endif type="checkbox"><span>{{\App\CPU\Helpers::translate('Has a guarantee')}}</span></label>
                                                        </div>
                                                        <div class="input-group mb-0 warranty_period_input_on warranty_period_input" style="display: none">
                                                            <input name="warranty_period" aria-describedby="basic-addon1" value="" class="form-control text-dark" placeholder="{{\App\CPU\Helpers::translate('Warranty period')}}" type="text">
                                                        </div>
                                                    </div>

                                                    <div class="input-group mb-2  p-2">
                                                        <div class="w-100">
                                                            <label class="ckbox"><input value="1" name="attachment" @if ($product->attachment) checked @endif type="checkbox"><span>{{\App\CPU\Helpers::translate('Attach a file upon request')}}</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="input-group mb-2  p-2">
                                                        <div class="w-100">
                                                            <label class="ckbox"><input value="1" name="notable" @if ($product->notable) checked @endif type="checkbox"><span>{{\App\CPU\Helpers::translate('Noteable')}}</span></label>
                                                        </div>
                                                    </div>

                                                    <div class="input-group mb-2  p-2">
                                                        <div class="w-100">
                                                            <label class="ckbox"><input value="1" name="sold_separately" @if ($product->sold_separately) checked @endif type="checkbox"><span>{{\App\CPU\Helpers::translate('Sold separately')}}</span></label>
                                                        </div>
                                                    </div>

                                                    <div class="input-group mb-2  p-2">
                                                        <div class="w-100">
                                                            <label class="ckbox"><input value="1" class="switch_inputs" name="linked_products" inputsClass="linked_products_input" @if ($product->linked_products) checked @endif type="checkbox"><span>{{\App\CPU\Helpers::translate('Linked Products')}}</span></label>
                                                        </div>
                                                        <div class="input-group mb-0 linked_products_input_on linked_products_input"
                                                        @if (!$product->linked_products) style="display: none" @endif>
                                                            <select name="linked_products" multiple="multiple" aria-describedby="basic-addon1" value="" class="testselect2-with-img form-control text-dark" placeholder="{{\App\CPU\Helpers::translate('Linked Products')}}" type="text">
                                                                {{--  @foreach (Helpers::getProducts($product->id) as $c)
                                                                <option
                                                                @if(in_array($c->id,explode(',',$product->linked_products)))
                                                                selected
                                                                @endif
                                                                icon ="{{asset($c->photo)}}"
                                                                value="{{$c->id}}">{{Helpers::getProp('3',Storage::disk('local')->get('lang'),$c->id,'name')}}</option>
                                                                @endforeach  --}}
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="input-group mb-2  p-2">
                                                        <div class="w-100">
                                                            <label class="ckbox">
                                                                <input class="switch_inputs" value="1" inputsClass="purchase_note_input" @if ($product->purchase_note) checked @endif type="checkbox"><span>{{\App\CPU\Helpers::translate('Purchase Note')}}</span></label>
                                                        </div>

                                                        <div class="input-group mb-0 purchase_note_input_on purchase_note_input" style="display: none">
                                                            <input name="purchase_note" aria-describedby="basic-addon1" value="" class="form-control text-dark" placeholder="{{\App\CPU\Helpers::translate('Purchase Note')}}" type="text">
                                                        </div>
                                                    </div>

                                                    <div class="input-group mb-2  p-2">
                                                        <div class="w-100">
                                                            <label class="ckbox"><input value="1" name="allow_pre_order" @if ($product->allow_pre_order) checked @endif type="checkbox"><span>{{\App\CPU\Helpers::translate('Allow pre-order')}}</span></label>
                                                        </div>
                                                    </div>

                                                    <div class="input-group mb-2  p-2">
                                                        <div class="w-100">
                                                            <label class="ckbox" style="white-space: nowrap">
                                                                <input class="switch_inputs" value="1" name="shipping_options" inputsClass="shipping_options_input" @if ($product->shipping_options) checked @endif type="checkbox"><span>{{\App\CPU\Helpers::translate('Shipping options for this product')}}</span></label>
                                                        </div>

                                                        <div class="input-group mb-0 shipping_options_input_on shipping_options_input" style="display: none">
                                                            <select name="shipping_options" aria-describedby="basic-addon1" value="" class="select2 form-control text-dark" placeholder="{{\App\CPU\Helpers::translate('Shipping options for this product')}}" type="text"></select>
                                                        </div>
                                                    </div>

                                                    <div class="input-group mb-2  p-2">
                                                        <div class="w-100">
                                                            <label class="ckbox">
                                                                <input class="switch_inputs" value="1" name="payment_options" inputsClass="payment_options_input" @if ($product->payment_options) checked @endif type="checkbox">
                                                                <span>{{\App\CPU\Helpers::translate('Payment options for this product')}}</span>
                                                            </label>
                                                        </div>

                                                        <div class="input-group mb-0 payment_options_input_on payment_options_input" style="display: none">
                                                            <select name="payment_options" aria-describedby="basic-addon1" value="" class="select2 form-control text-dark" placeholder="{{\App\CPU\Helpers::translate('Shipping options for this product')}}" type="text"></select>
                                                        </div>
                                                    </div>

                                                    <div class="input-group mb-2  p-2">
                                                        <div class="w-100">
                                                            <label class="ckbox">
                                                                <input class="switch_inputs" value="1" name="productprops[is_shareable]"  @if ($product->props['is_shareable'] ?? false) checked @endif type="checkbox"><span>{{\App\CPU\Helpers::translate('is shareable')}}</span></label>
                                                        </div>
                                                    </div>


                                                    <div class="input-group mb-3 hdn_pw_on hdn_pw" @if (!$product->hidden_with_pw) style="display: none" @endif>
                                                        <div class=" input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1">{{\App\CPU\Helpers::translate('Password')}}</span>
                                                        </div>
                                                        <input name="product_pw" value="{{$product->product_pw}}" aria-describedby="basic-addon1" value="" class="form-control" placeholder="{{\App\CPU\Helpers::translate('Password')}}*" type="password" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');">
                                                        <div class="input-group-append pointer togglePassowrd">
                                                            <span class="input-group-text">
                                                                <i class="fa fa-eye-slash"></i>
                                                            </span>
                                                        </div>
                                                    </div>


                                                    <div class="input-group mb-0  p-2">
                                                        <div class="w-100">
                                                            <label class="ckbox"><input value="1" class="switch_inputs" inputsClass="forcountries_input" name="selected_countries" @if ($product->selected_countries) checked @endif type="checkbox"><span>{{\App\CPU\Helpers::translate('The product is only sold to selected countries')}}</span></label>
                                                        </div>
                                                        <div class="input-group mb-0 forcountries_input_on forcountries_input mt-3"
                                                        @if (!$product->selected_countries) style="display: none" @endif
                                                        >

                                                            <select multiple="multiple" aria-describedby="basic-addon1" value="" class="SumoSelect-custom form-control text-dark" placeholder="{{\App\CPU\Helpers::translate('The product is only sold to selected countries')}}" type="text" ="" onchange="getChildren('areas','select.props-area',$(this).val().toString(),this)">
                                                                @foreach (Helpers::getCountries() as $key=>$item)
                                                                    <option
                                                                    @if(in_array($item->id,explode(',',$product['props']['countries'] ?? '') ?? [])) selected @endif
                                                                        value='{{ $item->id }}'> {{Helpers::get_prop('App\countries',$item->id,'name')}} </option>
                                                                @endforeach
                                                            </select>


                                                        </div>
                                                        <input type="hidden" name="productprops[countries]" value="{{$product['props']['countries'] ?? ''}}" />
                                                    </div>





                                                    <div class="input-group mb-2  p-2">
                                                        <div class="w-100">
                                                            <label class="ckbox"><input value="1" class="switch_inputs" inputsClass="forareas_input" name="selected_areas" @if ($product->selected_areas) checked @endif type="checkbox"><span>{{\App\CPU\Helpers::translate('The product is only sold to selected areas')}}</span></label>
                                                        </div>
                                                        <div class="input-group mb-0 forareas_input_on forareas_input mt-3"
                                                        @if (!$product->selected_areas) style="display: none" @endif>

                                                            <select aria-describedby="basic-addon1" value="" multiple  onchange="getChildren('cities','select.props-cities',$(this).val().toString(),this)"
                                                            class="props-area testselect2-custom form-control text-dark" placeholder="{{\App\CPU\Helpers::translate('The product is only sold to selected areas')}}" type="text" ="" >
                                                                @foreach (Helpers::getAreas($product['props']['countries'] ?? '262822') ?? [] as $key=>$item)
                                                                    <option
                                                                    @if(in_array($item->id,explode(',',$product['props']['areas'] ?? '') ?? [])) selected @endif
                                                                        value='{{ $item->id }}'> {{Helpers::get_prop('App\areas',$item->id,'name')}} </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <input type="hidden" name="productprops[areas]" value="{{$product['props']['areas'] ?? ''}}" />
                                                    </div>

                                                    <div class="input-group mb-2  p-2">
                                                        <div class="w-100">
                                                            <label class="ckbox"><input value="1" class="switch_inputs" inputsClass="forcities_input" name="selected_cities" @if ($product->selected_cities) checked @endif type="checkbox"><span>{{\App\CPU\Helpers::translate('The product is only sold to selected cities')}}</span></label>
                                                        </div>
                                                        <div class="input-group mb-0 forcities_input_on forcities_input mt-3"
                                                        @if (!$product->selected_cities) style="display: none" @endif>

                                                            <select aria-describedby="basic-addon1" value="" multiple class="props-cities testselect2-custom form-control text-dark" placeholder="{{\App\CPU\Helpers::translate('The product is only sold to selected cities')}}" type="text" =""
                                                            onchange="getChildren('provinces','select.props-provinces',$(this).val().toString(),this)"
                                                            >
                                                                @foreach (Helpers::getCities($product['props']['areas'] ?? '262822') ?? [] as $key=>$item)
                                                                    <option
                                                                    @if(in_array($item->id,explode(',',$product['props']['cities'] ?? '') ?? [])) selected @endif
                                                                        value='{{ $item->id }}'> {{Helpers::get_prop('App\cities',$item->id,'name')}} </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <input type="hidden" name="productprops[cities]" value="{{$product['props']['cities'] ?? ''}}" />
                                                    </div>

                                                    <div class="input-group mb-2  p-2">
                                                        <div class="w-100">
                                                            <label class="ckbox"><input value="1" class="switch_inputs" inputsClass="forprovinces_input" name="selected_provinces" @if ($product->selected_provinces) checked @endif type="checkbox"><span>{{\App\CPU\Helpers::translate('The product is only sold to selected provinces')}}</span></label>
                                                        </div>
                                                        <div class="input-group mb-0 forprovinces_input_on forprovinces_input mt-3"
                                                        @if (!$product->selected_provinces) style="display: none" @endif>

                                                            <select
                                                            onchange="$(this).closest('.input-group').next('input').val($(this).val().toString())"
                                                            aria-describedby="basic-addon1" value="" multiple class="props-provinces testselect2-custom form-control text-dark" placeholder="{{\App\CPU\Helpers::translate('The product is only sold to selected provinces')}}" type="text" ="">
                                                                @foreach (Helpers::getGovernorates($product['props']['cities'] ?? '262822') ?? [] as $key=>$item)
                                                                    <option
                                                                    @if(in_array($item->id,explode(',',$product['props']['provinces'] ?? '') ?? [])) selected @endif
                                                                        value='{{ $item->id }}'> {{Helpers::get_prop('App\provinces',$item->id,'name')}} </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <input type="hidden" name="productprops[provinces]" value="{{$product['props']['provinces'] ?? ''}}" />
                                                    </div>

                                                    <div class="input-group mb-0  p-2 pb-0">
                                                        <div class="w-100 border p-1">
                                                            <label for="props[selected_countries_show_quantity_always]">
                                                                {{ \App\CPU\Helpers::translate('Show quantity for consumers') }}:
                                                            </label>
                                                            <div class="">
                                                                <label class="rdiobox">
                                                                    <input   name="productprops[selected_countries_show_quantity_always]" value="2" type="radio"  onchange="$('.quantity_number').slideUp()">
                                                                    <span>{{ \App\CPU\Helpers::translate('No') }}</span></label>
                                                            </div>
                                                            <div class="">
                                                                <label class="rdiobox">
                                                                    <input  name="productprops[selected_countries_show_quantity_always]" value="1" type="radio"  onchange="$('.quantity_number').slideUp()">
                                                                    <span>{{ \App\CPU\Helpers::translate('Always') }}</span></label>
                                                            </div>
                                                            <div class="mg-t-20 mg-lg-t-0">
                                                                <label class="rdiobox">
                                                                    <input name="productprops[selected_countries_show_quantity_always]" value="0" type="radio" onchange="$('.quantity_number').slideDown()"

                                                                    >
                                                                    <span>{{ \App\CPU\Helpers::translate('When the quantity is') }}:</span></label>
                                                                <input value="" name="productprops[selected_countries_show_quantity_number]" class="form-control quantity_number" type="number"
                                                                style="display: none" />
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <div class="input-group mb-2  p-2">
                                                        <div class="w-100">
                                                            <label class="ckbox"><input onchange="if(event.target.checked){$('.serialNumbers_on').show()}else{$('.serialNumbers_on').hide()}" value="1" name="enable_serial_numbers" @if ($product->enable_serial_numbers) checked @endif type="checkbox" class="switch_inputs" inputsClass="serialNumbers" /><span>{{\App\CPU\Helpers::translate('Enable Serial Numbers')}}</span></label>
                                                        </div>
                                                    </div>

                                                    <div class="input-group mb-2  p-2">
                                                        <div class="w-100">
                                                            <label class="ckbox"><input value="1" name="enable_multimedia" @if ($product->enable_multimedia) checked @endif type="checkbox" class="switch_inputs" inputsClass="multimediaTab" /><span>{{\App\CPU\Helpers::translate('Enable Multimedia')}}</span></label>
                                                        </div>
                                                    </div>


                                                    <div class="input-group mb-2  p-2">
                                                        <div class="w-100">
                                                            <label class="ckbox"><input onchange="productOptionsSwitch(event,'multi_stores')" value="1" name="multi_stores" @if ($product->multi_stores) checked @endif type="checkbox" class="switch_inputs" inputsClass="multiStores" /><span>{{\App\CPU\Helpers::translate('Multi Stores')}}</span></label>
                                                        </div>
                                                    </div>

                                                    <div class="input-group mb-2  p-2">
                                                        <div class="w-100">
                                                            <label class="ckbox"><input value="1" @if ($product->send_using) checked @endif type="checkbox" class="switch_inputs" inputsClass="sendUsing" />
                                                                <span class="fs-10">{{\App\CPU\Helpers::translate("Send products digital contents to consumer")}}</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="input-group mb-4 w-100 multiSelect2Div sendUsing sendUsing_on" @if (!$product->send_using) style="display:none" @endif>
                                                        <div class="form-control p-0 m-0 border-white bg-white">
                                                            <div class="form-control text-dark m-0 p-0">
                                                                <select multiple class="text-dark testselect2-custom w-100">
                                                                    <option @if(in_array("email",explode(',',$product->send_using) ?? [])) selected @endif value="email"> {{ \App\CPU\Helpers::translate('email') }} </option>
                                                                    <option @if(in_array("sms",explode(',',$product->send_using) ?? [])) selected @endif value="sms"> {{ \App\CPU\Helpers::translate('sms') }} </option>
                                                                    <option @if(in_array("application",explode(',',$product->send_using) ?? [])) selected @endif value="application"> {{ \App\CPU\Helpers::translate('Application') }} </option>
                                                                    <option @if(in_array("website",explode(',',$product->send_using) ?? [])) selected @endif value="website"> {{ \App\CPU\Helpers::translate('Website') }} </option>
                                                                </select>
                                                            </div>
                                                            <input type="hidden" name="send_using" value="{{ $product->send_using }}">
                                                        </div>
                                                    </div>

                                                    @if($shippingType!=='order_wise')
                                                    <div class="input-group mb-2  p-2">
                                                        <div class="w-100">
                                                            <label class="ckbox"><input value="1" name="multiplyQTY" @if ($product->multiply_qty == '1') checked @endif type="checkbox" /><span>{{\App\CPU\Helpers::translate('shipping_cost_multiply_with_quantity')}}</span></label>
                                                        </div>
                                                    </div>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>


                                    </div>



                                </div>
                            </div>
                        </div>





                        @include('admin-views.product.quantityAndStock')

                        <div class="card mt-2 rest-part">
                            <div class="card-header p-3 tx-medium my-auto tx-white bg-primary">
                                <div class="d-flex btn text-white w-100" onclick="$(this).closest('.card-header').next('.foldable-section').slideToggle();$(this).closest('.card-header').find('.toggleAngle').toggle()">
                                    <h4 class="ml-2 mr-2 pt-2 text-white">
                                        <i class="fa fa-angle-up toggleAngle" style=""></i>
                                        <i class="fa fa-angle-down toggleAngle" style="display:none"></i>
                                    </h4>
                                    <h5 class="mt-2 text-white">{{\App\CPU\Helpers::translate("seo_section")}}</h5>
                                </div>
                            </div>
                            <div class="card-body pt-0 px-3 foldable-section" style="display: none">
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label class="title-color">{{\App\CPU\Helpers::translate('Meta Title')}}</label>
                                        <input type="text" name="meta_title" value="{{$product['meta_title']}}" placeholder="" class="form-control">
                                    </div>

                                    <div class="col-md-8 form-group">
                                        <label class="title-color">{{\App\CPU\Helpers::translate('Meta Description')}}</label>
                                        <textarea rows="10" type="text" name="meta_description" class="form-control">{{$product['meta_description']}}</textarea>
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <div class="">
                                            <label class="title-color">{{\App\CPU\Helpers::translate('Meta Image')}}</label>
                                        </div>
                                        <div class="border-dashed">
                                            <div class="row" id="meta_img">
                                                <div class="col-sm-6">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <img class="w-100" height="auto"
                                                                onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                                src="{{asset("storage/app/public/product/meta")}}/{{$product['meta_image']}}"
                                                                alt="Meta image">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-2 rest-part">
                            <div class="card-header p-3 tx-medium my-auto tx-white bg-primary">
                                <div class="d-flex btn text-white w-100" onclick="$(this).closest('.card-header').next('.foldable-section').slideToggle();$(this).closest('.card-header').find('.toggleAngle').toggle();lsCheck(event,this)">
                                    <h4 class="ml-2 mr-2 pt-2 text-white">
                                        <i class="fa fa-angle-up toggleAngle" style=""></i>
                                        <i class="fa fa-angle-down toggleAngle" style="display:none"></i>
                                    </h4>
                                    <h5 class="mt-2 text-white">{{\App\CPU\Helpers::translate("Images & Videos")}}</h5>
                                </div>
                            </div>
                            <div class="card-body pt-0 pl-0 pr-0 foldable-section media-section" style="display: none">
                                <div class="row">

                                    <div class="px-4 pt-3 col-lg-4">
                                        <ul class="nav nav-tabs photos_lightSlider w-fit-content mb-0 lSrtl">
                                            @foreach(Helpers::get_langs() as $lang)
                                                <li class="nav-item text-capitalize">
                                                    <a class="nav-link lang_link__ {{$lang == ($default_lang ?? session()->get('local')) ? 'active':''}}" href="#"
                                                    id="{{$lang}}-link"><img class="ml-2" width="20" src="{{asset('public/assets/front-end')}}/img/flags/{{$lang}}.png">{{\App\CPU\Helpers::get_language_name($lang).'('.strtoupper($lang).')'}}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    <div class="card-body w-100">
                                        @foreach(Helpers::get_langs() as $lang)
                                            <?php
                                            if (count($product['translations'])) {
                                                $translate = [];
                                                foreach ($product['translations'] as $t) {

                                                    if ($t->locale == $lang && $t->key == "name") {
                                                        $translate[$lang]['name'] = $t->value;
                                                    }
                                                    if ($t->locale == $lang && $t->key == "description") {
                                                        $translate[$lang]['description'] = $t->value;
                                                    }

                                                }
                                            }
                                            ?>
                                            <div class="{{$lang != session()->get('local')? 'd-none':''}} lang_form__" id="{{$lang}}-form__">
                                                <div class="col-md-12 mb-4">
                                                    <div class="mb-2">
                                                        <label class="title-color mb-0">{{\App\CPU\Helpers::translate('Youtube video link')}}</label>
                                                        <span class="text-info"> ( {{\App\CPU\Helpers::translate('optional, please provide embed link not direct link')}}. )</span>
                                                    </div>
                                                    <input type="text" value="{{$product['video_url'][$lang] ?? ''}}" name="video_link[{{$lang}}]"
                                                        placeholder="{{\App\CPU\Helpers::translate('EX')}} : https://www.youtube.com/embed/5R06LRdUCSE"
                                                        class="form-control" required>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="mb-2">
                                                        <label class="title-color">{{\App\CPU\Helpers::translate('Upload product images')}}</label>

                                                    </div>
                                                    <div class="p-2">
                                                        <input type="hidden" name="images_indexing[{{$lang}}]" class="images_indexing">
                                                        <div class="row gy-3 flex-nowrap custom-sortable ui-sortable w-100" id="coba_{{$lang}}" style="overflow-x: auto;overflow-y: hidden">
                                                            @php($images = json_decode($product->images)->$lang ?? [])
                                                            @foreach (explode(',',$product['images_indexing'][$lang] ?? '[]') as $key=>$item)
                                                                @isset($images[$key])
                                                                    @php($photo = $images[$key])
                                                                    <div class="col-lg-3 card-draggable product_imgs bg-primary m-3" imgIndex="{{$item}}" style="border-radius: 11px;width: 300px;max-width: 300px;min-width: 300px;;height:250px">
                                                                        <div class="card bg-white h-100" style="position: relative">
                                                                            <div class="card-body text-center pt-0 px-0" style="min-height: 260px">
                                                                                <a href="{{route('admin.product.remove-image',['id'=>$product['id'],'name'=>$photo,'lang'=>$lang])}}"
                                                                                    class="btn btn-danger btn-block" style="width: 50px;position: absolute;">
                                                                                    <i class="fa fa-close"></i>
                                                                                </a>
                                                                                <img height="auto"
                                                                                style="width: 200px"
                                                                                onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                                                src="{{asset("storage/app/public/product/$lang/$photo")}}"
                                                                                alt="Product image" />
                                                                            </div>
                                                                            <div class="w-100 m-0 p-0" style="{{(session()->get('direction') == 'ltr') ? 'right:-1px' : 'left:-1px'}};bottom: -1%;position: absolute;direction: initial;">
                                                                                <a class="btn btn-primary btn-block m-0 img-number" style="width: 50px;height: 50px;">
                                                                                    {{$key + 1}}
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                @endisset
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mt-5">
                                                    <div class="mb-2">
                                                        <label class="title-color">{{\App\CPU\Helpers::translate('Upload product Videos')}}</label>

                                                    </div>
                                                    <div class="p-2">
                                                        <input type="hidden" name="videos_indexing[{{$lang}}]" class="videos_indexing">
                                                        <div class="row gy-3 flex-nowrap overflow-auto custom-sortable ui-sortable" id="videos_{{$lang}}">
                                                            @php($videos = json_decode($product->videos)->$lang ?? [])
                                                            @foreach (explode(',',$product['videos_indexing'][$lang] ?? '[]') as $key=>$item)
                                                                @isset($videos[$item])
                                                                    @php($video = $videos[$item])
                                                                    <div class="col-lg-3 card-draggable product_vids" vidIndex="{{$item}}" style="max-width: 335px;">
                                                                        <div style="position: relative;border-radius: 11px" class="border border-primary border-thick">
                                                                            <label class="file_upload bg-primary" style="width: 100%; height: 260px;border-radius: 11px; cursor: pointer; text-align: center; overflow: hidden; padding: 5px; margin-top: 5px; margin-bottom : 5px; position : relative; display: flex; align-items: center; margin: auto; justify-content: center; flex-direction: column;">
                                                                                <div class="card-body bg-primary px-0 pt-0" style="min-height: 260px">
                                                                                    <a href="{{route('admin.product.remove-video',['id'=>$product['id'],'name'=>$video,'lang'=>$lang])}}"
                                                                                        class="btn btn-danger btn-block m-0" style="width: 50px;margin-bottom: 45px">
                                                                                        <i class="fa fa-close"></i>
                                                                                    </a>
                                                                                    <video style="width: 100%; vertical-align: middle mt-3" class="vid_" controls>
                                                                                        <source src="{{asset("storage/app/public/product/$lang/$video")}}" type="video/mp4" />
                                                                                    </video>
                                                                                </div>
                                                                                <div class="w-100 m-0 p-0" style="{{(session()->get('direction') == 'ltr') ? 'right:-1px' : 'left:-1px'}};bottom: -1%;position: absolute;direction: initial;">
                                                                                    <a class="btn btn-primary btn-block m-0 vid-number" style="width: 50px;height: 50px;">
                                                                                        {{$key + 1}}
                                                                                    </a>
                                                                                </div>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                @endisset
                                                            @endforeach
                                                            <div class="col-3 product_vids spartan_item_wrapper ui-sortable-handle" style="margin-bottom : 20px;max-width: 325px;">
                                                                <div style="position: relative;border-radius: 11px" class="border border-primary border-thick">
                                                                    <label class="file_upload bg-primary" style="width: 100%; height: 260px;border-radius: 11px; cursor: pointer; text-align: center; overflow: hidden; padding: 5px; margin-top: 5px; margin-bottom : 5px; position : relative; display: flex; align-items: center; margin: auto; justify-content: center; flex-direction: column;">
                                                                        <div class="card-body bg-primary px-0 pt-0" style="min-height: 260px">
                                                                            <div class="card-body bg-primary px-0 pt-0" style="min-height: 45px;"></div>
                                                                            <a href="javascript:void(0)" data-spartanindexremove="0" style="position: absolute !important; right : 3px; top: 3px; display : none; background : transparent; border-radius: 3px; width: 30px; height: 30px; line-height : 30px; text-align: center; text-decoration : none; color : #ff0700;" class="spartan_remove_row remove_vid"><i class="tio-add-to-trash"></i></a>
                                                                            <img style="width: 80%; margin: 0 auto; vertical-align: middle;border-radius: 11px" data-spartanindexi="0" src="{{asset('public/assets/front-end/img/video-placeholder.png')}}" class="spartan_image_placeholder">
                                                                            <p data-spartanlbldropfile="0" style="color : #5FAAE1; display: none; width : auto; ">Drop Here</p>
                                                                            <video style="width: 100%; vertical-align: middle mt-3;display: none" class="vid_" controls>
                                                                                <source type="video/mp4" />
                                                                            </video>
                                                                            <input class="form-control spartan_video_input" accept="video/mp4" data-spartanindexinput="0" style="display : none" name="videos[{{$lang}}][]" type="file">
                                                                            <div class="w-100" style="{{(session()->get('direction') == 'ltr') ? 'right:-1px' : 'left:-1px'}};bottom: 0%;position: absolute;direction: initial;">
                                                                                <a class="btn btn-primary btn-block mx-2 vid-number" style="width: 50px;height: 50px;">
                                                                                    {{$key + 1}}
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>




                                </div>
                            </div>
                        </div>

                        <div class="card mt-2 rest-part">
                            <div class="card custom-card">
                                <div class="card-header p-3 tx-medium my-auto tx-white bg-primary">
                                    <div class="d-flex btn text-white w-100" onclick="$(this).closest('.card-header').next('.options-section').slideToggle();$(this).closest('.card-header').find('.toggleAngle').toggle()">
                                        <h4 class="ml-2 mr-2 pt-2 text-white">
                                            <i class="fa fa-angle-up toggleAngle" @if ($product->enable_options == 1) style="display:none" @endif></i>
                                            <i class="fa fa-angle-down toggleAngle" @if ($product->enable_options !== 1) style="display:none" @endif></i>
                                        </h4>
                                        <h5 class="mt-2 text-white">{{\App\CPU\Helpers::translate("Product's Options_")}}</h5>
                                    </div>
                                </div>
                                <div class="card-body pt-0 pl-0 pr-0 options-section"
                                @if ($product->enable_options !== 1)
                                    style="display: none"
                                @endif
                                >
                                <div class="d-flex mt-2 ml-2 mr-2">
                                    <label class="custom-switch px-1">
                                        <input type="checkbox" name="enable_options" class="custom-switch-input productOptionsSwitch" onchange="$('.card-product-options').slideToggle()"
                                        @if ($product->enable_options == 1)
                                        checked
                                        @endif
                                        >
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                    <h5 class="mt-0">{{\App\CPU\Helpers::translate('enable')}} {{\App\CPU\Helpers::translate("Product's Options_")}} </h5>
                                    <span class="h6 mx-1">( {{\App\CPU\Helpers::translate("If the product has multiple options, ex: color, size, ore, etc...")}} )</span>
                                </div>
                                    <div class="card custom-card card-product-options"
                                    style="display: none"
                                    @if ($product->enable_options !== 1)
                                    @endif
                                    >
                                        <div class="card-body justify-content-center">
                                            <div class="w-100 justify-content-center">
                                                <div class="w-100 wk-text-center prop-c">
                                                    <div class="option-container" id="productOptions">
                                                        @php($key = 0)
                                                        @foreach ($product['options'] ?? [] as $item)
                                                        @include('admin-views.product.products-option',['data'=>$item,'key'=>$key,'language'=>$language,'product'=>$product])
                                                        @php($key = $key + 1)
                                                        @endforeach
                                                    </div>
                                                    <div class="add-option-c row justify-content-center w-100 mb-3 mt-2 ml-0 mr-0">
                                                        <a class="btn btn-primary btn-add-option" onclick="newOption()">
                                                            <i class="fa fa-plus"></i> {{\App\CPU\Helpers::translate('Add Option')}}
                                                        </a>
                                                    </div>
                                                    <div class="option-values">
                                                        @php($values_sections)
                                                        {{--  @foreach (\App\CPU\Helpers::getSubProducts($product->id) ?? [] as $key=>$item)
                                                            @include('admin-views.product.option-value-acc',["subProdItem"=>$item,'values_sections'=>$key])
                                                        @endforeach  --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-2 rest-part">
                            <div class="card custom-card">
                                <div class="card-header p-3 tx-medium my-auto tx-white bg-primary">
                                    <div class="d-flex btn text-white w-100" onclick="$(this).closest('.card-header').next('.options-section').slideToggle();$(this).closest('.card-header').find('.toggleAngle').toggle()">
                                        <h4 class="ml-2 mr-2 pt-2 text-white">
                                            <i class="fa fa-angle-down toggleAngle" style="display: none"></i>
                                            <i class="fa fa-angle-up toggleAngle"></i>
                                        </h4>
                                        <h5 class="mt-2 text-white">{{\App\CPU\Helpers::translate("Product's Properties")}}</h5>
                                    </div>
                                </div>



                                <div class="card-body pt-0 pl-0 pr-0 options-section"
                                style="display: none"
                                @if (!count($product['props'] ?? []))
                                @endif
                                >
                                    <div class="card-header">
                                        <div class="row w-100">
                                            <div class="col-10">
                                                <h6 class="fs-17"> {{\App\CPU\Helpers::translate("Product's Properties")}} </h6>
                                            </div>
                                            <div class="col-2 text-align-last-end mb-3">
                                                <a onclick="$('#propsEdit').find('.productsprops-btn-refresh').click();$('.lSSlide').attr('style','')" class="btn btn-primary rounded-pill"
                                                data-target="#propsEdit" data-toggle="modal" data-effect="effect-scale" id="basic-addon1" >
                                                    {{ \App\CPU\Helpers::translate('Coding & modifying a new property') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="productProps">
                                        @foreach ($product['props'] ?? [] as $key=>$item)
                                        @if($key !== "is_shareable" && $key !== "show_product" && $key !== "selected_countries_show_quantity_number" && $key !== "countries" && $key !== "areas" && $key !== "cities" && $key !== "provinces")
                                            @include('admin-views.product.props',['propIndex'=>$key,'item'=>$item])
                                        @endif
                                        @endforeach
                                    </div>
                                    <div class="w-100 m-4">
                                        <a class="btn btn-info add-prop" onclick="newProp()">
                                            <i class="fa fa-plus"></i>
                                            {{ \App\CPU\Helpers::translate('Add') }}
                                        </a>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end pt-0" hidden>
                                    @if($product->request_status == 2)
                                        <button type="button" hidden onclick="check()" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('Update & Publish')}}</button>
                                    @else
                                        <button type="button" hidden onclick="check()" class="btn btn--primary btn-primary btn-save">{{\App\CPU\Helpers::translate('Update')}}</button>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        @if($product->id)

        <!-- Reviews -->
        <div class="card mt-2 rest-part">
            <div class="card-header p-3 tx-medium my-auto tx-white bg-primary">
                <div class="d-flex btn text-white w-100" onclick="$(this).closest('.card-header').next('.foldable-section').slideToggle();$(this).closest('.card-header').find('.toggleAngle').toggle()">
                    <h4 class="ml-2 mr-2 pt-2 text-white">
                        <i class="fa fa-angle-up toggleAngle" style=""></i>
                        <i class="fa fa-angle-down toggleAngle" style="display:none"></i>
                    </h4>
                    <h5 class="mt-2 text-white">{{\App\CPU\Helpers::translate("Rating & Reviews")}}</h5>
                </div>
            </div>
            <div class="card-body pt-0 px-3 foldable-section" style="display: none">
                <div class="card mt-5">
                    <div class="card-body row">
                        <!-- Card -->
                        <div class="card my-3 col-lg-6">
                            <!-- Body -->
                            <div class="card-body">
                                <div class="row align-items-md-center gx-md-5">
                                    <div class="col-md-auto mb-3 mb-md-0">
                                        <div class="d-flex align-items-center">
                                            @php($current_lang = session()->get('local'))
                                            <img
                                                class="avatar avatar-xxl avatar-4by3 {{Session::get('direction') === "rtl" ? 'ml-4' : 'mr-4'}}"
                                                onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                src="{{asset("storage/app/public/product/$current_lang")}}/{{(isset(json_decode($product['images'])->$current_lang)) ? json_decode($product['images'])->$current_lang[0] ?? '' : ''}}"
                                                alt="Image Description">

                                            <div class="d-block">
                                                <h4 class="display-2 text-dark mb-0">{{count($product->rating)>0?number_format($product->rating[0]->average, 2, '.', ' '):0}}</h4>
                                                <p> {{\App\CPU\Helpers::translate('of')}} {{$product->reviews->count()}} {{\App\CPU\Helpers::translate('reviews')}}
                                                    <span class="badge badge-soft-dark badge-pill {{Session::get('direction') === "rtl" ? 'mr-1' : 'ml-1'}}"></span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md">
                                        <ul class="list-unstyled list-unstyled-py-2 mb-0">
                                        @php($total=$product->reviews->count())
                                        <!-- Review Ratings -->
                                            <li class="d-flex align-items-center font-size-sm">
                                                @php($five=\App\CPU\Helpers::rating_count($product['id'],5))
                                                <span
                                                    class="{{Session::get('direction') === "rtl" ? 'ml-3' : 'mr-3'}}">{{\App\CPU\Helpers::translate('5 star')}}</span>
                                                <div class="progress flex-grow-1">
                                                    <div class="progress-bar" role="progressbar"
                                                        style="width: {{$total==0?0:($five/$total)*100}}%;"
                                                        aria-valuenow="{{$total==0?0:($five/$total)*100}}"
                                                        aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="{{Session::get('direction') === "rtl" ? 'mr-3' : 'ml-3'}}">{{$five}}</span>
                                            </li>
                                            <!-- End Review Ratings -->

                                            <!-- Review Ratings -->
                                            <li class="d-flex align-items-center font-size-sm">
                                                @php($four=\App\CPU\Helpers::rating_count($product['id'],4))
                                                <span class="{{Session::get('direction') === "rtl" ? 'ml-3' : 'mr-3'}}">{{\App\CPU\Helpers::translate('4 star')}}</span>
                                                <div class="progress flex-grow-1">
                                                    <div class="progress-bar" role="progressbar"
                                                        style="width: {{$total==0?0:($four/$total)*100}}%;"
                                                        aria-valuenow="{{$total==0?0:($four/$total)*100}}"
                                                        aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="{{Session::get('direction') === "rtl" ? 'mr-3' : 'ml-3'}}">{{$four}}</span>
                                            </li>
                                            <!-- End Review Ratings -->

                                            <!-- Review Ratings -->
                                            <li class="d-flex align-items-center font-size-sm">
                                                @php($three=\App\CPU\Helpers::rating_count($product['id'],3))
                                                <span class="{{Session::get('direction') === "rtl" ? 'ml-3' : 'mr-3'}}">{{\App\CPU\Helpers::translate('3 star')}}</span>
                                                <div class="progress flex-grow-1">
                                                    <div class="progress-bar" role="progressbar"
                                                        style="width: {{$total==0?0:($three/$total)*100}}%;"
                                                        aria-valuenow="{{$total==0?0:($three/$total)*100}}"
                                                        aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span
                                                    class="{{Session::get('direction') === "rtl" ? 'mr-3' : 'ml-3'}}">{{$three}}</span>
                                            </li>
                                            <!-- End Review Ratings -->

                                            <!-- Review Ratings -->
                                            <li class="d-flex align-items-center font-size-sm">
                                                @php($two=\App\CPU\Helpers::rating_count($product['id'],2))
                                                <span class="{{Session::get('direction') === "rtl" ? 'ml-3' : 'mr-3'}}">{{\App\CPU\Helpers::translate('2 star')}}</span>
                                                <div class="progress flex-grow-1">
                                                    <div class="progress-bar" role="progressbar"
                                                        style="width: {{$total==0?0:($two/$total)*100}}%;"
                                                        aria-valuenow="{{$total==0?0:($two/$total)*100}}"
                                                        aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="{{Session::get('direction') === "rtl" ? 'mr-3' : 'ml-3'}}">{{$two}}</span>
                                            </li>
                                            <!-- End Review Ratings -->

                                            <!-- Review Ratings -->
                                            <li class="d-flex align-items-center font-size-sm">
                                                @php($one=\App\CPU\Helpers::rating_count($product['id'],1))
                                                <span class="{{Session::get('direction') === "rtl" ? 'ml-3' : 'mr-3'}}">{{\App\CPU\Helpers::translate('1 star')}}</span>
                                                <div class="progress flex-grow-1">
                                                    <div class="progress-bar" role="progressbar"
                                                        style="width: {{$total==0?0:($one/$total)*100}}%;"
                                                        aria-valuenow="{{$total==0?0:($one/$total)*100}}"
                                                        aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="{{Session::get('direction') === "rtl" ? 'mr-3' : 'ml-3'}}">{{$one}}</span>
                                            </li>
                                            <!-- End Review Ratings -->
                                        </ul>
                                    </div>

                                    <div class="col-12">
                                        <hr>
                                    </div>

                                    <div class="col-lg-4 mb-5 mb-lg-0 d-flex flex-column gap-1">
                                        <div class="flex-start">
                                            <h5 class="">{{$product['name']}}</h5>
                                        </div>
                                        <div class="flex-start">
                                            <span>{{\App\CPU\Helpers::translate('Price')}} : </span>
                                            <span
                                                class="mx-1">{{\App\CPU\BackEndHelper::set_symbol(($product['unit_price']))}}</span>
                                        </div>
                                        <div class="flex-start">
                                            <span>{{\App\CPU\Helpers::translate('TAX')}} : </span>
                                            <span class="mx-1">{{($product['tax'])}} % </span>
                                        </div>
                                        <div class="flex-start">
                                            <span>{{\App\CPU\Helpers::translate('Discount')}} : </span>
                                            <span
                                                class="mx-1">{{ $product->discount_type=='flat'?(\App\CPU\BackEndHelper::set_symbol(($product['discount']))): $product->discount.''.'%'}} </span>
                                        </div>
                                        @if($product->product_type == 'physical')
                                        <div class="flex-start">
                                            <span>{{\App\CPU\Helpers::translate('shipping Cost')}} : </span>
                                            <span class="mx-1">{{ \App\CPU\BackEndHelper::set_symbol(($product->shipping_cost)) }}</span>
                                        </div>
                                        <div class="flex-start">
                                            <span>{{\App\CPU\Helpers::translate('Current Stock')}} : </span>
                                            <span class="mx-1">{{ $product->current_stock }}</span>
                                        </div>
                                        @endif

                                        @if(($product->product_type == 'digital') && ($product->digital_product_type == 'ready_product'))
                                            <div>
                                                <a href="{{asset("storage/app/public/product/digital-product/$product->digital_file_ready")}}" class="btn btn--primary btn-primary py-1 mt-3" download>{{\App\CPU\Helpers::translate('download')}}</a>
                                            </div>
                                        @endif

                                    </div>

                                    <div class="col-lg-8 border-lg-left">
                                        <div> @if (count((is_array($product->colors) ? $product->colors : [])) > 0)
                                                <div class="d-flex align-items-center flex-wrap gap-10 mb-4">
                                                    <div class="">
                                                        <div class="product-description-label">{{\App\CPU\Helpers::translate('Available color')}}:
                                                        </div>
                                                    </div>
                                                    <div class="">
                                                        <ul class="align-items-center d-flex flex-wrap gap-2 list-inline mb-0">
                                                            @foreach (json_decode($product->colors) as $key => $color)
                                                                <li>

                                                                    <label class="mb-0" style="background: {{ $color }};"
                                                                        for="{{ $product->id }}-color-{{ $key }}"
                                                                        data-toggle="tooltip"></label>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="mb-2">{{\App\CPU\Helpers::translate('Product Image')}}</div>
                                            <div class="row g-2">
                                                @foreach (($product->images->$local ?? []) as $key => $photo)
                                                    <div class="col-6 col-md-4 col-lg-3">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <img class="width-100"
                                                                    onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                                    src="{{asset("storage/app/public/product/$photo")}}" alt="Product image">

                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Body -->
                        </div>
                        <!-- End Card -->


                        <div class="card mt-3 col-lg-6">
                            <!-- Table -->
                            <div class="table-responsive datatable-custom">
                                <table class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100"
                                    style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                    <thead class="thead-light thead-50 text-capitalize">
                                    <tr>
                                        <th>{{\App\CPU\Helpers::translate('Reviewer')}}</th>
                                        <th>{{\App\CPU\Helpers::translate('Review')}}</th>
                                        <th>{{\App\CPU\Helpers::translate('Date')}}</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($reviews ?? [] as $review)
                                        @if(isset($review->customer))
                                        <tr>
                                            <td>
                                                <a class="d-flex align-items-center"
                                                href="{{route('admin.customer.view',[$review['customer_id']])}}">
                                                    <div class="avatar avatar-circle">
                                                        <img
                                                            class="avatar-img"
                                                            onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                            src="{{asset('storage/app/public/profile/'.$review->customer->image)}}"
                                                            alt="Image Description">
                                                    </div>
                                                    <div class="{{Session::get('direction') === "rtl" ? 'mr-3' : 'ml-3'}}">
                                                    <span class="d-block h5 text-hover-primary mb-0">{{$review->customer['f_name']." ".$review->customer['l_name']}} <i
                                                            class="tio-verified text-primary" data-toggle="tooltip" data-placement="top"
                                                            title="Verified Customer"></i></span>
                                                        <span class="d-block font-size-sm text-body">{{$review->customer->email??""}}</span>
                                                    </div>
                                                </a>
                                            </td>
                                            <td>
                                                <div class="text-wrap">
                                                    <div class="d-flex mb-2">
                                                        <label class="badge badge-soft-info">
                                                            <span>{{$review->rating}} <i class="tio-star"></i> </span>
                                                        </label>
                                                    </div>

                                                    <p>
                                                        {{$review['comment']}}
                                                    </p>
                                                    @foreach (json_decode($review->attachment) as $img)

                                                        <a class="float-left" href="{{asset('storage/app/public/review')}}/{{$img}}" data-lightbox="mygallery">
                                                            <img class="p-2" width="60" height="60" src="{{asset('storage/app/public/review')}}/{{$img}}" alt="">
                                                        </a>

                                                    @endforeach
                                                </div>
                                            </td>
                                            <td>
                                                {{date('d M Y H:i:s',strtotime($review['updated_at']))}}
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- End Table -->

                            <div class="table-responsive mt-4">
                                <div class="px-4 d-flex justify-content-lg-end">
                                    <!-- Pagination -->
                                    @if(count($reviews))
                                    {!! $reviews->links() !!}
                                    @endif
                                </div>
                            </div>

                            @if(count($reviews)==0)
                                <div class="text-center p-4">
                                    <img class="mb-3 w-160" src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg" alt="Image Description">
                                    <p class="mb-0">{{\App\CPU\Helpers::translate('No data to show')}}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>


        <!-- End Reviews -->
        @endif
    </div>
    @isset($product->slug)
    <a target="_blank" href="{{ route('product', $product->slug) }}"> {{ Helpers::translate('product page in market') }} </a>
    @endisset


        <div class="modal fade" id="propsEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">{{\App\CPU\Helpers::translate('Coding & modifying a new property')}}</h6><a aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></a>
                    </div>
                    <div class="modal-body card-body">
                        <form id="addNewPropForm" method="POST" onsubmit="event.preventDefault()">
                            @csrf
                            <div class="row border rounded-15">
                                <ul class="nav nav-tabs lightSliderr w-100 mb-4">
                                    @foreach(Helpers::get_langs() as $lang)
                                        <li class="nav-item">
                                            <a class="nav-link lang_link_ {{$lang == ($default_lang ?? session()->get('local')) ? 'active':''}}" href="#"
                                                id="{{$lang}}-link">
                                                <img class="ml-2" width="20" src="{{asset('public/assets/front-end')}}/img/flags/{{$lang}}.png">
                                                {{ucfirst(\App\CPU\Helpers::get_language_name($lang)).'('.strtoupper($lang).')'}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="row w-100">
                                    <div class="col-md-6 px-6">
                                        @foreach(Helpers::get_langs() as $lang)
                                            <div class="form-group {{$lang != $default_lang ? 'd-none':''}} lang_form"
                                                    id="{{$lang}}-form_">
                                                <label for="name" class="title-color label-w-btn">
                                                    <img class="ml-2" width="20" src="{{asset('public/assets/front-end')}}/img/flags/{{$lang}}.png">
                                                    {{ \App\CPU\Helpers::translate('Property name')}}<span class="text-danger">*</span> ({{strtoupper($lang)}})
                                                    <a class="btn btn-primary" onclick="emptyInput(event,'.modal-body','.productprops_name')">{{\App\CPU\Helpers::translate('Field dump')}}</a>
                                                </label>
                                                <input type="text" name="name[]" class="form-control productprops_name" id="name" {{$lang == ($default_lang ?? session()->get('local')) ? 'required':''}} onchange="translateName(event,'.modal-body','.productprops_name')">
                                            </div>
                                            <input type="hidden" name="lang[]" value="{{$lang}}">
                                        @endforeach
                                    </div>
                                </div>
                                <div class="w-100 px-4 pb-4">
                                    <button class="btn btn-success" id="addNewPropBtn"> {{ \App\CPU\Helpers::translate('Save') }} </button>
                                </div>
                            </div>
                        </form>
                        {{--  datatable  --}}
                        <div class="row row-sm printable">
                            <div class="col-lg-12">
                                <div class="card custom-card overflow-hidden">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="productsprops-table" class="table table-bordered table-striped text-nowrap table-editor">
                                                <thead>
                                                    <tr>
                                                        @foreach(Helpers::get_langs() as $lang)
                                                            <th class="text-center"> {{\App\CPU\Helpers::translate('name')}} ({{$lang}}) </th>
                                                        @endforeach
                                                        <th></th>
                                                    </tr>
                                                </thead>


                                                <tbody>
                                                    @foreach (\App\CPU\Helpers::getProductsProps() as $pp)
                                                    <?php
                                                    if (count($pp['translations'])) {
                                                        $translate = [];
                                                        foreach ($pp['translations'] as $t) {
                                                            $translate[$t->locale]['name'] = $t->value;
                                                        }
                                                    }
                                                    ?>
                                                    <tr>
                                                        @foreach(Helpers::get_langs() as $lang)
                                                            <td class="text-center"> {{$translate[$lang]['name']?? $pp['name']}} </td>
                                                        @endforeach
                                                        <td class="text-center">
                                                            <button onclick="deletePP(this,{{$pp['id']}})" class="btn btn-danger">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--  datatable end  --}}
                    </div>
                    <div class="modal-footer">
                        <a class="btn ripple btn-secondary" data-dismiss="modal" type="button">{{\App\CPU\Helpers::translate('Close')}}</a>
                    </div>
                </div>
            </div>
        </div>
@endsection

@push('script_2')
    <script src="{{asset('public/assets/back-end')}}/js/tags-input.min.js"></script>
    <script src="{{asset('public/assets/back-end/js/spartan-multi-image-picker.js')}}"></script>
    <script>
        @php($current_lang = session()->get('local'))
        var optionsValues = [];
        var formData = new FormData();
        var imageCount = {{10-count($product->images->$lang ?? [])}};
        var thumbnail = '{{asset("storage/app/public/product/$current_lang")}}/{{(isset(json_decode($product['images'])->$current_lang)) ? json_decode($product['images'])->$current_lang[0] ?? '' : ''}}';
        $(function () {
            @foreach(Helpers::get_langs() as $lang)
            $("#coba_{{$lang}}").spartanMultiImagePicker({
                fieldName: 'images[{{$lang}}][]',
                maxCount: imageCount,
                rowHeight: 'auto',
                groupClassName: 'col-3 product_imgs',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{asset('public/assets/back-end/img/400x400/img2.jpg')}}',
                    width: '100%',
                },
                dropFileLabel: "Drop Here",
                onAddRow: function (index_, file) {
                    var divs = $("#coba_{{$lang}}").closest('.lang_form__');
                    var arr = [];
                    var i = 1;
                    divs.find(".product_imgs").each(function(index,item){
                        var imgIndex = $(this).attr("imgIndex");
                        if(!imgIndex){
                            $(this).attr("imgIndex",index);
                            var imgIndex = $(this).attr("imgIndex");
                        }
                        arr[index] = imgIndex;
                        $(this).find(".img-number").text(i);
                        if(divs.find(".product_imgs").length == i){
                            $(this).append('<div class="w-100 m-0 p-0" style="{{(session()->get("dir") == "ltr") ? "right:3%" : "left:3%"}};bottom: 3%;position: absolute;direction: initial;"><a class="btn btn-primary btn-block m-0 img-number" style="width: 50px;height: 50px;">'+ i +'</a></div>')
                        }
                        i++;
                    })
                    divs.find(".images_indexing").val(arr.toString());
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

            $("#meta_img").spartanMultiImagePicker({
                fieldName: 'meta_image',
                maxCount: 1,
                rowHeight: 'auto',
                groupClassName: 'col-6',
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
        });

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
    </script>

    <script>
        function viewValuesForOptions(){
            optionsValues = [];
            $(".product-option-container").each(function(c,el){
                $(el).find(".option-value-container").each(function(vc,ell){
                    if(!optionsValues[c]){
                        optionsValues[c] = [];
                    }
                    optionsValues[c][vc]=(new Object({
                        "c":c,
                        "vc":vc,
                        "text   ":c + '_' + vc
                    }))
                })
            })
            lastArr = [];
            var temp = [];
            lastArr = [];
            optionsValues.forEach(function(arr){
                if(!lastArr.length){
                    arr.forEach(function(item,index){
                        lastArr[index]= item
                    })
                }else{
                    temp = [];
                    lastArr.forEach(function(item,index){
                        arr.forEach(function(arrItem,arrIndex){
                            var x = [arrItem];
                            if(Array.isArray(item)){
                                item.forEach(function(el){
                                    x.push(el);
                                })
                            }else{
                                x = [item,arrItem];
                            }
                            temp.push(x);
                        })
                        lastArr = temp;
                    })
                }
            })
            formData.set('arr',JSON.stringify(lastArr))
            formData.set('_token',$("[name=csrf-token]").prop("content"))
            formData.set('id',{{$product['id']}})
            $.ajax({
                url:"{{route('admin.product.options.values.add-new.acc')}}?values_sections="+$(".option-value-collapse").length,
                type:"POST",
                processData: false,
                contentType: false,
                data:formData,
                success:function(data){
                    var d = $(data)
                    $(".option-values").html(d);

                    $(".totalQuantity").each(function(){
                        $(this).val(formData.get($(this).attr('name')))
                    })
                    $(".totalQuantity").change();
                    formData.forEach(function(item,key){
                        if(document.getElementsByName(key).length){
                            if(document.getElementsByName(key)[0].type == "checkbox"){
                                document.getElementsByName(key)[0].checked = item === "true"
                                $(document.getElementsByName(key)[0]).change()
                            }else{
                                document.getElementsByName(key)[0].value = item
                            }
                        }
                        if($(document.getElementsByName(key)).hasClass('testselect2-custom')){
                            $(document.getElementsByName(key)).val(item.split(','))
                        }
                    })
                    $(".OptionValue").keyup();
                    //d.find('.fc-datepicker').datepicker();

                    d.find('.select2').select2();
                    d.find('.testselect2-custom').SumoSelect({
                        search:true,
                        placeholder: '{{\App\CPU\Helpers::translate("Select Here")}}',
                        searchText: "{{\App\CPU\Helpers::translate('Search')}}...",
                        selectAll: true,
                        locale: ['{{ \App\CPU\Helpers::translate("Ok") }}', '{{ \App\CPU\Helpers::translate("Cancel") }}', '{{ \App\CPU\Helpers::translate("Select All") }}'],
                        captionFormatAllSelected: '{0} {{ \App\CPU\Helpers::translate("All Selected") }}!',
                        captionFormat: '{0} {{ \App\CPU\Helpers::translate("Selected") }}',
                    });

                    $(".js-example-theme-single").select2({
                        width: 'resolve'
                    });

                    $(".js-example-responsive").select2({
                        width: 'resolve'
                    });

                    d.find('.showAlpha').each(function(i,el){
                        if($(el).val()){
                            $(el).spectrum({
                                color: $(el).val(),
                                showAlpha: true,
                                showInput: true,
                            });
                        }
                    })
                    $(".option_type_select").change();
                    $(".min_quantity_alert").change();
                    if($(".product-option-container").length === 1){
                        $(".option-value-acc").each(function(i,parentEl){
                            var x = 0;
                            $(this).find(".option-value-collapse_span").each(function(){
                                if(x === 1){
                                    return;
                                }
                                if(!$(this).text().length){
                                $(parentEl).hide();
                                }else{
                                    $(parentEl).show();
                                    x = 1;
                                    return;
                                }
                            })
                        })
                    }
                    $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput();
                    $("input[name=enable_serial_numbers]").trigger('change');
                }
            })
        }

        function getRequest(route, id, type) {
            $.get({
                url: route,
                dataType: 'json',
                success: function (data) {
                    if (type == 'select') {
                        $('#' + id).empty().append(data.select_tag);
                    }
                },
            });
        }

        function newProp(){
            $.ajax({
                url:"{{route('admin.product.props.add-new')}}?key="+$(".prop-c-c").length,
                success:function(data){
                    $(data).appendTo('#productProps');
                    $(".js-example-responsive").select2({
                        // dir: "rtl",
                        width: 'resolve'
                    });
                }
            })
        }

        function newOption(){
            var l  = $(".product-option-container").length;
            $.ajax({
                url:"{{route('admin.product.options.add-new')}}?key="+l,
                success:function(data){
                    $(data).appendTo('#productOptions');
                    $(".js-example-responsive").select2({
                        // dir: "rtl",
                        width: 'resolve'
                    });
                }
            })
        }

        function newValue(optionIndex){
            var optionValueIndex = $('#optionValues'+optionIndex).find('.option-value-container').length;
            $.ajax({
                url:"{{route('admin.product.options.values.add-new')}}",
                data:{
                    optionIndex: optionIndex,
                    optionValueIndex: optionValueIndex,
                },
                success:function(data){
                    $(data).appendTo('#optionValues'+optionIndex);
                    $(".js-example-responsive").select2({
                        // dir: "rtl",
                        width: 'resolve'
                    });
                    viewValuesForOptions()
                }
            })
        }

        $('input[name="colors_active"]').on('change', function () {
            if (!$('input[name="colors_active"]').is(':checked')) {
                $('#colors-selector').prop('disabled', true);
            } else {
                $('#colors-selector').prop('disabled', false);
            }
        });

        $('#choice_attributes').on('change', function () {
            $('#customer_choice_options').html(null);
            $.each($("#choice_attributes option:selected"), function () {
                //console.log($(this).val());
                add_more_customer_choice_option($(this).val(), $(this).text());
            });
        });

        function add_more_customer_choice_option(i, name) {
            let n = name.split(' ').join('');
            $('#customer_choice_options').append('<div class="row"><div class="col-md-3"><input type="hidden" name="choice_no[]" value="' + i + '"><input type="text" class="form-control" name="choice[]" value="' + n + '" placeholder="{{\App\CPU\Helpers::translate('Choice Title') }}" readonly></div><div class="col-lg-9"><input type="text" class="form-control" name="choice_options_' + i + '[]" placeholder="{{\App\CPU\Helpers::translate('Enter choice values') }}" data-role="tagsinput" onchange="update_sku()"></div></div>');
            $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput();
        }

        setTimeout(function () {
            $('.call-update-sku').on('change', function () {
                update_sku();
            });
        }, 2000)

        $('#colors-selector').on('change', function () {
            update_sku();
        });

        $('input[name="unit_price"]').on('keyup', function () {
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
                url: '{{route('admin.product.sku-combination')}}',
                data: $('#product_form').serialize(),
                success: function (data) {
                    $('#sku_combination').html(data.view);
                    update_qty();
                    if (data.length > 1) {
                        $('#quantity').hide();
                    } else {
                        $('#quantity').show();
                    }
                }
            });
        }


        $(document).ready(function () {
            $( ".custom-sortable" ).sortable({
                stop: function( event, ui ) {
                    var divs = $(this).closest('.lang_form__');
                    var arr = [];
                    var i = 1;
                    divs.find(".product_imgs").each(function(index,item){
                        var imgIndex = $(this).attr("imgIndex");
                        arr[index] = imgIndex;
                        $(this).find('.img-number').text(i)
                        i++
                    })
                    divs.find(".images_indexing").val(arr.toString());
                }
            });

            $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput();

            setTimeout(function () {
                let category = $("#category_id").val();
                let sub_category = $("#sub-category-select").attr("data-id");
                let sub_sub_category = $("#sub-sub-category-select").attr("data-id");
                getRequest('{{url('/')}}/admin/product/get-categories?parent_id=' + category + '&sub_category=' + sub_category, 'sub-category-select', 'select');
                getRequest('{{url('/')}}/admin/product/get-categories?parent_id=' + sub_category + '&sub_category=' + sub_sub_category, 'sub-sub-category-select', 'select');
            }, 100)
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

            $(document).on("change",".option_type_select",function(){
                var v = $(this).val();
                if($(this).hasClass("select_lang")){
                    $(this).closest(".options-input2").find(".OptionTypes.OptionTypes_lang").hide();
                }else{
                    $(this).closest(".options-input2").find(".OptionTypes:not(.OptionTypes_lang,.inputs_lang)").hide();
                }
                $(this).closest(".options-input2").find(`.${v}OptionType`).show();
            })

            $(".switcher_input").change((e)=>{
                var v = "off";
                if($(e.target).is(":checked")){
                    v = "on";
                }
                var inputsClass = $(e.target).attr("inputsClass")
                $("."+inputsClass).slideUp();
                $("."+inputsClass+"_"+v).slideDown();
            })


            $(document).on("click",".togglePassowrd",function(){
                var el = $(this).closest(".input-group");
                if(el.find("input").attr("type") === "text"){
                    el.find("i").addClass("fa-eye-slash")
                    el.find("i").removeClass("fa-eye")
                    el.find("input").attr("type","password");
                }else{
                    el.find("i").removeClass("fa-eye-slash")
                    el.find("i").addClass("fa-eye")
                    el.find("input").attr("type","text");
                }
            })

            $(document).on("change",".spartan_video_input",function(){
                var parent_ = $(this).closest(".product_vids");
                var html = parent_[0].outerHTML;
                var newEl = $(html).insertAfter(parent_);
                $(newEl).find(".vid-number").text(parent_.parent().find(".product_vids").length);
                var $source = $(this).prev('video').find("source");
                $source[0].src = URL.createObjectURL(this.files[0]);
                $source.parent()[0].load();
                $(this).prev('video').show();
                parent_.find(".spartan_image_placeholder").hide();
                parent_.find(".spartan_remove_row").show();

                var divs = $(this).closest('.lang_form__');
                var arr = [];
                divs.find(".product_vids").each(function(index,item){
                    var vidIndex = index;
                    $(this).attr("vidIndex",index);
                    arr[index] = vidIndex;
                })
                divs.find(".videos_indexing").val(arr.toString());
            })

            $(document).on("click",".remove_vid",function(){
                $(this).closest(".product_vids").remove();
            })

            $(".spartan_video_input").each(function(){
                var divs = $(this).closest('.lang_form__');
                var arr = [];
                divs.find(".product_vids").each(function(index,item){
                    var vidIndex = index;
                    $(this).attr("vidIndex",index);
                    arr[index] = vidIndex;
                })
                divs.find(".videos_indexing").val(arr.toString());
            })
        });
    </script>

    <script>
        function check() {
            @if (request()->has('ids') || isset($ids))
            $('#product_form').submit();
            @else
            $(".error_required").removeClass('error_required');
            $(".error_required_message").remove();
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
                url: '{{route('admin.product.update',$product->id)}}',
                data: formData,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.errors) {
                        for (var i = 0; i < data.errors.length; i++) {
                            if(data.errors[i].code == "brand_id"){
                                $("<span class='error_required_message text-danger'>"+data.errors[i].message+"</span>").insertBefore(".brand_id_div");
                            }
                            var nm = data.errors[i].code.indexOf('.') >= 0 ? data.errors[i].code.replace('.','[')+']' : data.errors[i].code;
                            var result = nm.match(/\[(.*)\]/);
                            if(result){
                                if(!isNaN(parseInt(result[1]))){
                                    nm = nm.replace(result[0],'[]')
                                    $(".lang_link:eq("+result[0].replace('[','').replace(']','')+")").click();
                                }
                            }
                            if(nm == "description[]" || nm == "description"){
                                $("*[class^='cke_editor_textarea'],*[class*='cke_editor_textarea']").addClass("error_required");
                            }
                            if(nm == "unit"){
                                $(".unit-form-control").addClass("error_required");
                            }
                            if(nm == "main_category"){
                                $("<span class='error_required_message text-danger'>"+data.errors[i].message+"</span>").insertBefore(".main_category-container");
                            }
                            if(nm == "show_for_pricing_levels"){
                                $(".show_for_pricing_levels-container").find('.form-control').addClass("error_required");
                            }
                            if(nm == "meta_description"){
                                $("textarea[name='meta_description']").addClass("error_required");
                            }
                            if(nm == "meta_image"){
                                $("#meta_img .product_imgs").addClass("error_required");
                            }
                            if(nm == "images"){
                                $(".media-section").slideDown();
                                $(".product_imgs").addClass("error_required");
                            }
                            if(nm == "videos"){
                                $(".media-section").slideDown();
                                $(".product_vids").find('.border-thick').addClass("error_required");
                            }
                            $("input[name='"+nm+"']").addClass("error_required");
                            $("input[name='"+nm+"']").closest('.foldable-section').slideDown();
                            $("<span class='error_required_message text-danger'>"+data.errors[i].message+"</span>").insertBefore($("input[name='"+nm+"']").closest('.input-group'));
                        }
                        toastr.error("{{ Helpers::translate('Please fill all red bordered fields') }}", {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    } else {
                        toastr.success('{{ Helpers::translate('product updated successfully!') }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        $('#product_form').submit();
                    }
                }
            });
            @endif
        };
    </script>


    <script>
        update_qty();

        function update_qty() {
            var total_qty = 0;
            var qty_elements = $('input[name^="qty_"]');
            for (var i = 0; i < qty_elements.length; i++) {
                total_qty += parseInt(qty_elements.eq(i).val());
            }
            if (qty_elements.length > 0) {

                $('input[name="current_stock"]').attr("readonly", true);
                $('input[name="current_stock"]').val(total_qty);
            } else {
                $('input[name="current_stock"]').attr("readonly", false);
            }
        }

        $('input[name^="qty_"]').on('keyup', function () {
            var total_qty = 0;
            var qty_elements = $('input[name^="qty_"]');
            for (var i = 0; i < qty_elements.length; i++) {
                total_qty += parseInt(qty_elements.eq(i).val());
            }
            $('input[name="current_stock"]').val(total_qty);
        });
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
            if (lang == '{{$default_lang}}') {
                $(this).closest('.card').find(".rest-part").removeClass('d-none');
            } else {
                $(this).closest('.card').find(".rest-part").addClass('d-none');
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
            viewValuesForOptions();

            $(document).on('hide.bs.modal','#propsEdit',function(){
                $.ajax({
                    url:'/productsProps/options?with_deleted=1',
                    success:function(data){
                        $(".propValue_select").each(function(){
                            var selected = $(this).find("option:selected").val();
                            $(this).html(data);
                            $(this).find("option[value="+selected+"]").attr("selected","selected")
                            $(this).find("option[value=deleted]").remove()
                        })
                    }
                })
            });

            @php($dir = session()->get('direction'))
            $(document).on('show.bs.modal','#propsEdit',function(){
                setTimeout(function(){
                    if($(".lightSliderr").hasClass("lightSlider")){}else{
                        $(".lightSliderr").lightSlider({
                            rtl: {{ ($dir == 'rtl') ? 'true' : 'false' }},
                            enableDrag:true,
                            enableTouch:true,
                            freeMove:true,
                            pager:false,
                            prevHtml:"<button class='btn btn-primary'><i class='fa fa-angle-{{ ($dir == 'rtl') ? 'right' : 'left' }}'></i></button>",
                            nextHtml:"<button class='btn btn-primary'><i class='fa fa-angle-{{ ($dir == 'rtl') ? 'left' : 'right' }}'></i></button>",
                        });
                    }
                },1000)
            });



            $("#propsEdit").on("click",".{{'productsprops'}}saveEdits",function(e){
                $.ajax({
                    url:'/productsProps/show',
                    success:function(data){
                        var selectedOp = []
                        $(".propValue_select").each(function(){
                            selectedOp.push($(this).find("option:selected").val())
                        })
                        $(".OptionTypesNewPropName").val('')
                        $(".propValue_select").html("<option></option>"+data.data.map(function(item,index){return "<option value='"+item.id+"'>"+item.props_{{session()->get('local')}}_name+"</option>"}))
                        $(".propValue_select").each(function(index,item){
                            $(this).find("option[value="+selectedOp[index]+"]").attr("selected","selected");
                        })
                    }
                })
            })

            $(document).on("click","#addNewPropBtn",function(e){
                event.preventDefault();
                $.ajax({
                    type:'POST',
                    data:$("#addNewPropForm").serialize(),
                    url:"{{route('admin.productsProps.add-new')}}",
                    success:function(data){
                        $('#propsEdit').find('.productsprops-btn-refresh').click()
                        $("#productsprops-table").find("tbody").append(data[1]);
                        $(".productprops_name").val('');
                        $(".OptionTypesNewPropName").val('')
                        $(".propValue_select").append(data[0])
                        filterPropsOptions();
                    }
                })
            })
        });

        function product_type(){
            let product_type = $('#product_type').val();

            if(product_type === 'physical'){
                $('#digital_product_type_show').hide();
                $('#digital_file_ready_show').hide();
                $('.physical_product_show').show();
                $("#digital_product_type").val($("#digital_product_type option:first").val());
                $("#digital_file_ready").val('');
            }else if(product_type === 'digital'){
                $('#digital_product_type_show').show();
                $('.physical_product_show').hide();

            }
        }

        function lsCheck(event,el){
            setTimeout(function(){
                if($(".photos_lightSlider").hasClass("lightSlider")){}else{
                    $(".photos_lightSlider").lightSlider({
                        rtl: {{ ($dir == 'rtl') ? 'true' : 'false' }},
                        enableDrag:true,
                        enableTouch:true,
                        freeMove:true,
                        autoWidth:false,
                        pager:false,
                        vThumbWidth:'120px',
                        prevHtml:"<button class='btn btn-primary'><i class='fa fa-angle-{{ ($dir == 'rtl') ? 'right' : 'left' }}'></i></button>",
                        nextHtml:"<button class='btn btn-primary'><i class='fa fa-angle-{{ ($dir == 'rtl') ? 'left' : 'right' }}'></i></button>",
                    });
                }
            },1000)
        }

        function digital_product_type(){
                let digital_product_type = $('#digital_product_type').val();
                if (digital_product_type === 'ready_product') {
                    $('#digital_file_ready_show').show();
                } else if (digital_product_type === 'ready_after_sell') {
                    $('#digital_file_ready_show').hide();
                    $("#digital_file_ready").val('');

                    optionsValues.forEach(function(arr){
                        if(!lastArr.length){
                            arr.forEach(function(item,index){
                                lastArr[index]= item
                            })
                        }else{
                            temp = [];
                            lastArr.forEach(function(item,index){
                                arr.forEach(function(arrItem,arrIndex){
                                    var x = [arrItem];
                                    if(Array.isArray(item)){
                                        item.forEach(function(el){
                                            x.push(el);
                                        })
                                    }else{
                                        x = [item,arrItem];
                                    }
                                    temp.push(x);
                                })
                                lastArr = temp;
                            })
                        }
                    })
                formData.set('arr',JSON.stringify(lastArr))
                formData.set('_token',$("[name=csrf-token]").prop("content"))
                formData.set('id',{{$product['id']}})
                $.ajax({
                    url:"{{route('admin.product.options.values.add-new.acc')}}?values_sections="+$(".option-value-collapse").length,
                    type:"POST",
                    processData: false,
                    contentType: false,
                    data:formData,
                    success:function(data){
                        var d = $(data)
                        $(".option-values").html(d);

                        $(".totalQuantity").each(function(){
                            $(this).val(formData.get($(this).attr('name')))
                        })
                        $(".totalQuantity").change();
                        formData.forEach(function(item,key){
                            if(document.getElementsByName(key).length){
                                if(document.getElementsByName(key)[0].type == "checkbox"){
                                    document.getElementsByName(key)[0].checked = item === "true"
                                    $(document.getElementsByName(key)[0]).change()
                                }else{
                                    document.getElementsByName(key)[0].value = item
                                }
                            }
                            if($(document.getElementsByName(key)).hasClass('testselect2-custom')){
                                $(document.getElementsByName(key)).val(item.split(','))
                            }
                        })
                        $(".OptionValue").keyup();
                        //d.find('.fc-datepicker').datepicker();

                        d.find('.select2').select2();
                        d.find('.testselect2-custom').SumoSelect({
                            search:true,
                            placeholder: '{{\App\CPU\Helpers::translate("Select Here")}}',
                            searchText: "{{\App\CPU\Helpers::translate('Search')}}...",
                            selectAll: true,
                            locale: ['{{ \App\CPU\Helpers::translate("Ok") }}', '{{ \App\CPU\Helpers::translate("Cancel") }}', '{{ \App\CPU\Helpers::translate("Select All") }}'],
                            captionFormatAllSelected: '{0} {{ \App\CPU\Helpers::translate("All Selected") }}!',
                            captionFormat: '{0} {{ \App\CPU\Helpers::translate("Selected") }}',
                        });

                        $(".js-example-theme-single").select2({
                            width: 'resolve'
                        });

                        $(".js-example-responsive").select2({
                            width: 'resolve'
                        });

                        d.find('.showAlpha').each(function(i,el){
                            if($(el).val()){
                                $(el).spectrum({
                                    color: $(el).val(),
                                    showAlpha: true,
                                    showInput: true,
                                });
                            }
                        })
                        $(".option_type_select").change();
                        $(".min_quantity_alert").change();
                        if($(".product-option-container").length === 1){
                            $(".option-value-acc").each(function(i,parentEl){
                                var x = 0;
                                $(this).find(".option-value-collapse_span").each(function(){
                                    if(x === 1){
                                        return;
                                    }
                                    if(!$(this).text().length){
                                        $(parentEl).hide();
                                    }else{
                                        $(parentEl).show();
                                        x = 1;
                                        return;
                                    }
                                })
                            })
                        }
                        $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput();
                        $("input[name=enable_serial_numbers]").trigger('change');
                    }
                })
            }
        }

        function deletePP(e,id){
            var tr = $(e).closest("tr")
            var opId = id;
            Swal.fire({
                title: "{{ \App\CPU\Helpers::translate('Are you sure?')}}?",
                text: "{{ \App\CPU\Helpers::translate('You_will_not_be_able_to_revert_this')}}!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{ \App\CPU\Helpers::translate('Yes')}}, {{ \App\CPU\Helpers::translate('delete_it')}}!',
                cancelButtonText: "{{ \App\CPU\Helpers::translate('cancel')}}",
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url:"{{route('admin.productsProps.delete')}}",
                        type:"post",
                        data:{
                            _token: '{{csrf_token()}}',
                            id:id,
                        },
                        success:function(){
                            tr.remove();
                            $(".propValue_select").find("option[value='"+opId+"']").remove();
                        },
                    })
                }
            })
        }

        function viewValuesForOptions(){
            optionsValues = [];
            $(".product-option-container").each(function(c,el){
                $(el).find(".option-value-container").each(function(vc,ell){
                    if(!optionsValues[c]){
                        optionsValues[c] = [];
                    }
                    optionsValues[c][vc]=(new Object({
                        "c":c,
                        "vc":vc,
                        "text   ":c + '_' + vc
                    }))
                })
            })
            lastArr = [];
            var temp = [];
            lastArr = [];
            optionsValues.forEach(function(arr){
                if(!lastArr.length){
                    arr.forEach(function(item,index){
                        lastArr[index]= item
                    })
                }else{
                    temp = [];
                    lastArr.forEach(function(item,index){
                        arr.forEach(function(arrItem,arrIndex){
                            var x = [arrItem];
                            if(Array.isArray(item)){
                                item.forEach(function(el){
                                    x.push(el);
                                })
                            }else{
                                x = [item,arrItem];
                            }
                            temp.push(x);
                        })
                        lastArr = temp;
                    })
                }
            })
            formData.set('arr',JSON.stringify(lastArr))
            formData.set('_token',$("[name=csrf-token]").prop("content"))
            formData.set('id',{{$product['id']}})
            $.ajax({
                url:"{{route('admin.product.options.values.add-new.acc')}}?values_sections="+$(".option-value-collapse").length,
                type:"POST",
                processData: false,
                contentType: false,
                data:formData,
                success:function(data){
                    var d = $(data)
                    $(".option-values").html(d);

                    $(".totalQuantity").each(function(){
                        $(this).val(formData.get($(this).attr('name')))
                    })
                    $(".totalQuantity").change();
                    formData.forEach(function(item,key){
                        if(document.getElementsByName(key).length){
                            if(document.getElementsByName(key)[0].type == "checkbox"){
                                document.getElementsByName(key)[0].checked = item === "true"
                                $(document.getElementsByName(key)[0]).change()
                            }else{
                                document.getElementsByName(key)[0].value = item
                            }
                        }
                        if($(document.getElementsByName(key)).hasClass('testselect2-custom')){
                            $(document.getElementsByName(key)).val(item.split(','))
                        }
                    })
                    $(".OptionValue").keyup();
                    //d.find('.fc-datepicker').datepicker();

                    d.find('.select2').select2();
                    d.find('.testselect2-custom').SumoSelect({
                        search:true,
                        placeholder: '{{\App\CPU\Helpers::translate("Select Here")}}',
                        searchText: "{{\App\CPU\Helpers::translate('Search')}}...",
                        selectAll: true,
                        locale: ['{{ \App\CPU\Helpers::translate("Ok") }}', '{{ \App\CPU\Helpers::translate("Cancel") }}', '{{ \App\CPU\Helpers::translate("Select All") }}'],
                        captionFormatAllSelected: '{0} {{ \App\CPU\Helpers::translate("All Selected") }}!',
                        captionFormat: '{0} {{ \App\CPU\Helpers::translate("Selected") }}',
                    });

                    $(".js-example-theme-single").select2({
                        width: 'resolve'
                    });

                    $(".js-example-responsive").select2({
                        width: 'resolve'
                    });

                    d.find('.showAlpha').each(function(i,el){
                        if($(el).val()){
                            $(el).spectrum({
                                color: $(el).val(),
                                showAlpha: true,
                                showInput: true,
                            });
                        }
                    })
                    $(".option_type_select").change();
                    $(".min_quantity_alert").change();
                    if($(".product-option-container").length === 1){
                        $(".option-value-acc").each(function(i,parentEl){
                            var x = 0;
                            $(this).find(".option-value-collapse_span").each(function(){
                                if(x === 1){
                                    return;
                                }
                                if(!$(this).text().length){
                                $(parentEl).hide();
                                }else{
                                    $(parentEl).show();
                                    x = 1;
                                    return;
                                }
                            })
                        })
                    }
                    $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput();
                    $("input[name=enable_serial_numbers]").trigger('change');
                }
            })
        }
    </script>

    <script>
        $(".lang_link_").click(function (e) {
            e.preventDefault();
            $(".lang_link_").removeClass('active');
            $(".lang_form").addClass('d-none');
            $(this).addClass('active');

            let form_id = this.id;
            let lang = form_id.split("-")[0];
            console.log(lang);
            $("#" + lang + "-form_").removeClass('d-none');
            if (lang == '{{$default_lang}}') {
                $(".from_part_2").removeClass('d-none');
            } else {
                $(".from_part_2").addClass('d-none');
            }
        });

        $(document).on("click",".lang_link_props",function (e) {
            e.preventDefault();
            $(e.target).closest('ul').find(".lang_link_props").removeClass('active');
            $(e.target).closest('ul').next('.row').find(".lang_form_props").addClass('d-none');
            $(this).addClass('active');

            let form_id = this.id;
            let lang = form_id.split("-")[0];
            console.log(lang);
            $(e.target).closest('ul').next('.row').find("." + lang + "-form_props").removeClass('d-none');
            if (lang == '{{$default_lang}}') {
                $(".from_part_2").removeClass('d-none');
            } else {
                $(".from_part_2").addClass('d-none');
            }
        });

        $(".lang_link__").click(function (e) {
            e.preventDefault();
            $(".lang_link__").removeClass('active');
            $(".lang_form__").addClass('d-none');
            $(this).addClass('active');

            let form_id = this.id;
            let lang = form_id.split("-")[0];
            $("#" + lang + "-form__").removeClass('d-none');
            if (lang == '{{$default_lang}}') {
                $(".from_part_2").removeClass('d-none');
            } else {
                $(".from_part_2").addClass('d-none');
            }
        });

        $(".primary_tab").click(function (e) {
            e.preventDefault();
            $(".primary_tab").removeClass('active');
            $(".primary_section").addClass('d-none');
            $(this).addClass('active');

            let form_id = this.id;
            let t = form_id.split("-")[0];
            $("#" + t + "-tab").removeClass('d-none');
        });


    </script>

    {{--ck editor--}}
    <script src="{{asset('/')}}vendor/ckeditor/ckeditor/ckeditor.js"></script>
    <script src="{{asset('/')}}vendor/ckeditor/ckeditor/adapters/jquery.js"></script>
    <script>
        $("#has_discount_check").change();

        @foreach (Helpers::get_langs() as $key=>$lang)
        var editor{{$lang}} = $('.textarea{{$lang}}').ckeditor({
            contentsLangDirection : '{{Session::get('direction')}}',
        });
        CKEDITOR.instances['textarea{{$lang}}'].on("blur", function(e) {
            var val = e.editor.getData();
            if(val){
                @foreach (Helpers::get_langs() as $key=>$lang)
                if(!CKEDITOR.instances['textarea{{$lang}}'].getData()){
                    $.ajax({
                        type:'post',
                        url:"{{route('home')}}/admin/g-translate/{{$lang == 'sa' ? 'ar' : $lang}}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            word: val,
                        },
                        success:function(data){
                            CKEDITOR.instances['textarea{{$lang}}'].setData(data)
                        }
                    })
                }
                @endforeach
            }
        })
        @endforeach
        function emptyDesc(){
            @foreach (Helpers::get_langs() as $key=>$lang)
                CKEDITOR.instances['textarea{{$lang}}'].setData('')
            @endforeach
        }

        function refreshMainCat(ths){
            $('#main_category').find('option').attr('disabled','disabled')
            $('#main_category').SumoSelect().sumo.reload()
            var cats = $(ths).val();
            cats.forEach(function(item,index){
                $('#main_category').find('option[value="'+item+'"]').removeAttr('disabled');
            })
            $('#main_category').SumoSelect().sumo.reload()
        }
    </script>
    {{--ck editor--}}
@endpush
