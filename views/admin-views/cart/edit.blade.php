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
            <div class="col-lg-6 pt-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\Helpers::translate('Dashboard')}}</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="{{route('admin.abandoned-carts.list')}}">
                                {{Helpers::translate('carts')}}
                            </a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a>
                                {{Helpers::translate('edit')}}
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
    <!-- End Page Title -->

    <!-- Content Row -->
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>
                        {{ Helpers::translate('the customer') }}
                    </h3>
                </div>
                <div class="card-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <div class="row">
                        <div class="col-1">
                            <img
                            class="avatar rounded-circle avatar-70" style="width: 75px;height: 42px"
                            onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                            src="{{asset('storage/app/public/user')}}/{{($customer->store_informations['image'] ?? '')}}"
                            alt="Image">
                        </div>
                        <div class="col-10">
                            <h5 class="px-2">
                                {{ $customer->id ?? null }}
                                -
                                <a target="_blank" href="{{ route('admin.customer.update', ['id'=>$customer['id']]) }}">
                                    {{ $customer->name }}
                                </a>
                            </h5>
                            <div class="d-flex mt-4">
                                <h5 dir="ltr" class="pt-3 px-2"> {{ $customer->phone }} </h5>
                                <a target="_bank" role="button" class="btn btn-primary" href="tel:{{$customer->phone}}">
                                    {{ Helpers::translate('Dial') }}
                                </a>
                                <a target="_bank" role="button" class="btn btn-success mx-2" href="http://wa.me/{{$customer->phone}}">
                                    <i class="tio-whatsapp-outlined text-white mx-1"></i>
                                    {{ Helpers::translate('Whatsapp') }}
                                </a>

                                <a target="_bank" role="button" class="btn btn-primary mx-2" data-target="#quick_sms" data-toggle="modal">
                                    <i class="tio-sms text-white mx-1"></i>
                                    {{ Helpers::translate('Sms') }}
                                </a>

                                <a target="_bank" role="button" class="btn btn-info mx-2" href="mailto:{{$customer->email}}">
                                    <i class="tio-email-outlined text-white mx-1"></i>
                                    {{ Helpers::translate('Email') }}
                                </a>
                            </div>
                            <div class="d-flex mt-4">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>
                        {{ Helpers::translate('products') }}
                    </h3>

                    <div class="col-lg-8"></div>

                    <a target="_bank" role="button" class="btn btn-primary mx-2" data-target="#products_add" data-toggle="modal">
                        <i class="tio-shopping-cart text-white mx-1"></i>
                        {{ Helpers::translate('Add products to cart') }}
                    </a>

                    <a role="button" class="btn btn-info mx-2" onclick="$('#enable-discount').show();location.replace('#enable-discount')">
                        {{ Helpers::translate('enable discount') }}
                    </a>
                </div>
                <div class="card-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">{{ Helpers::translate('Item Number') }}</th>
                                <th class="text-center">{{ Helpers::translate('product_code_sku') }}</th>
                                <th class="text-center">{{ Helpers::translate('product') }}</th>
                                <th class="text-center">{{ Helpers::translate('quantity') }}</th>
                                <th class="text-center">{{ Helpers::translate('price') }}</th>
                                <th class="text-center">{{ Helpers::translate('Discount on each piece') }}</th>
                                <th class="text-center">{{ Helpers::translate('total') }}</th>
                                <th class="text-center">{{ Helpers::translate('actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($total = 0)
                            @foreach ($cart as $item)
                            @if($item->product)
                            <tr>
                                <td class="pt-5 text-center"> {{$item->product['item_number']}} </td>
                                <td class="pt-5 text-center"> {{$item->product['code']}} </td>
                                <td class="text-start" style="width: 660px;">
                                    <a target="_blank" href="{{ route('admin.product.edit', ['id'=>$item->product['id']]) }}">
                                        @php($local = session()->get('local'))
                                        <img class="rounded productImg" width="64"
                                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                        src="{{asset("storage/app/public/product/$local")}}/{{(isset(json_decode($item->product['images'])->$local)) ? json_decode($item->product['images'])->$local[0] ?? '' : ''}}">
                                        {{ Str::limit(\App\CPU\Helpers::get_prop('App\Model\Product',$item->product['id'],'name',session()->get('local') ?? 'sa') ?? $item->product->name, 36) }}
                                    </a>
                                </td>
                                <td style="width: 100px" class="text-center pt-4"> <input style="width: 100px" class="form-control text-center " type="number" min="0" max="100" id="quantity_{{$item->id}}" value="{{ $item->quantity }}"/>  </td>
                                <td style="width: 100px" class="text-center pt-4"> <input style="width: 100px" class="form-control text-center bg-light" readonly disabled type="text" id="price_{{$item->id}}" value="{{ $item->price }}"/>  </td>
                                <td style="width: 100px" class="text-center pt-4"> <input style="width: 100px" class="form-control text-center " type="number" min="0" max="100" id="discount_{{$item->id}}" value="{{ $item->discount }}"/>  </td>
                                <td class="pt-5 text-center">
                                    <span class="calc_price_b" id="calc_price_b_{{$item->id}}" style="display: none">
                                        {{ $item->quantity*$item->price }}
                                        @php($total = $total + ($item->quantity*$item->price))
                                    </span>
                                    <span class="calc_price" id="calc_price_{{$item->id}}">
                                        {{ $item->quantity*$item->price }}
                                        @php($total = $total + ($item->quantity*$item->price))
                                    </span>
                                </td>
                                <td class="pt-3 text-center">
                                    <button class="btn btn-primary mx-1 update_price" onclick="update_price({{$item->id}})">
                                        {{ Helpers::translate('update') }}
                                    </button>
                                    <button class="btn btn-danger mx-1" onclick="form_alert('delete-{{$item->id}}','Want to delete this item ?')">
                                        {{ Helpers::translate('delete') }}
                                    </button>
                                    <form hidden id="delete-{{$item->id}}" action="{{ route('admin.abandoned-carts.delete',['id'=>$item->id]) }}" method="POST">
                                        @csrf
                                    </form>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                        <tfoot>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-end">
                                {{ Helpers::translate('Total') }}:
                            </td>
                            <td colspan="2" style="width: 125px" class="text-start">
                                <span id="total_price_b"></span>
                                <span id="total_price" style="display: none;"></span>
                                <span>{{ \App\CPU\BackEndHelper::set_symbol('') }}</span>
                            </td>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3 pt-6" id="enable-discount" @if(!$offer) style="display: none" @endif>
        @php($o = $offer->offer ?? [])
        @include('admin-views.cart.offer_form',['id'=>$offer['id'] ?? null,'offer'=>1])
        <div class="row w-100 m-0 pt-4">
            <div class="row-12 w-100 px-1 mb-0 mx-3">
                <button class="btn btn-primary w-100" onclick="$('#offer_form').submit()">
                    <i class="tio-send"></i>
                    {{ Helpers::translate('Send the offer') }}
                </button>
            </div>
        </div>
    </div>

    <div class="row w-100 m-0 py-4">
        <div class="row-12 w-100 px-1">
            <button class="btn btn-primary w-100">
                {{ Helpers::translate('complete the order') }}
            </button>
        </div>
    </div>

    <div class="modal fade" id="products_add" tabindex="-1" role="dialog" aria-labelledby="productsModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="height: 90%" role="document">
            <div class="modal-content h-100">
                <div class="modal-header">
                    <h5 class="modal-title">{{\App\CPU\Helpers::translate('Add products to cart')}}</h5><a aria-label="Close" class="close" data-dismiss="modal" type="button" onclick="$('#added_products').val('')"><span aria-hidden="true">&times;</span></a>
                </div>
                <div class="modal-body card-body">
                    <iframe style="width: 100%;height: 80%" scrol src="{{ route('admin.pos.index',['hide_all' => 1]) }}" frameborder="0" scrolling="no"></iframe>
                    <h3>{{ Helpers::translate('added products') }}:</h3>
                    <form id="added_products_form" action="{{ route('admin.abandoned-carts.add_products',['cart_group_id'=>$cart_group_id]) }}" method="post" style="max-height: 100px;overflow-y: auto">
                        @csrf

                    </form>
                </div>

                <div class="modal-footer">
                    <button class="btn ripple btn-success" type="button" onclick="$('#added_products_form').submit()">{{\App\CPU\Helpers::translate('Apply')}}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="quick_sms" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{\App\CPU\Helpers::translate('send sms')}}</h5><a aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></a>
                </div>
                <div class="modal-body card-body">
                    <form action="{{ route('admin.sms.store') }}" method="post" id="quickSms">
                        @csrf
                        <textarea class="w-100" name="description" id="description" style="height: 127px;"></textarea>
                        <input type="hidden" name="email_to[store]" value="store">
                        <input type="hidden" name="sent_to[store]" value="{{$customer->phone}}">
                    </form>
                </div>
                <div class="modal-footer">
                    <a class="btn ripple btn-success" type="button" onclick="$('#quickSms').click()">{{\App\CPU\Helpers::translate('Send')}}</a>
                </div>
            </div>
        </div>
    </div>

    <!--modal-->
    @include('shared-partials.image-process._image-crop-modal',['modal_id'=>'package-image-modal','width'=>1000,'margin_left'=>'-53%'])
    <!--modal-->
</div>

@push('script')
    <script>
        $(".update_price").click();
    </script>
@endpush

@endsection


