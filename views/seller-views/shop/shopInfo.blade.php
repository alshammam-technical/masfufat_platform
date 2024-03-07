@extends('layouts.back-end.app-seller')
@section('title', \App\CPU\Helpers::translate('Shop view'))
@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
@include('seller-views.business-settings.settings-inline-menu')
    <div class="content container-fluid" style="padding-{{(Session::get('direction') == 'rtl') ? 'right' : 'left'}}: 17%">
        <!-- Page Title -->
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img width="20" src="{{asset('/public/assets/back-end/img/shop-info.png')}}" alt="">
                {{\App\CPU\Helpers::translate('Shop_Info')}}
            </h2>
        </div>
        <!-- End Page Title -->



        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">{{\App\CPU\Helpers::translate('my_shop Info')}} </h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center flex-wrap gap-5">
                            @if($shop->image=='def.png')
                                <div class="text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}">
                                    <img height="200" width="200" class="rounded-circle border"
                                         onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                         src="{{asset('public/assets/back-end')}}/img/shop.png">
                                </div>
                            @else
                                <div class="text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}">
                                    <img src="{{asset('storage/app/public/shop/'.$shop->image)}}"
                                         onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                         class="rounded-circle border"
                                         height="200" width="200" alt="">
                                </div>
                            @endif


                            <div class="">
                                <div class="flex-start">
                                    <h4>{{\App\CPU\Helpers::translate('Name')}} : </h4>
                                    <h4 class="mx-1">{{$shop->name}}</h4>
                                </div>
                                <div class="flex-start">
                                    <h6>{{\App\CPU\Helpers::translate('Phone')}} : </h6>
                                    <h6 class="mx-1">{{$shop->contact}}</h6>
                                </div>
                                <div class="flex-start">
                                    <h6>{{\App\CPU\Helpers::translate('address')}} : </h6>
                                    <h6 class="mx-1">{{$shop->address}}</h6>
                                </div>

                                <div class="flex-start">
                                    <a class="btn btn--primary btn-primary px-4" href="{{route('seller.shop.edit',[$shop->id])}}">{{\App\CPU\Helpers::translate('edit')}}</a>
                                </div>
                            </div>
                            <div class=""></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('script')
    <!-- Page level plugins -->
    <script>
        $("#customFileUploadFI").change(function () {
            read_image(this, 'viewerFI');
        });

        function read_image(input, id) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#' + id).attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
