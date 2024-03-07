@extends('layouts.back-end.app-seller')
@section('title', \App\CPU\Helpers::translate('Edit Shipping'))
@push('css_or_js')

@endpush

@section('content')
<div class="content container-fluid">
    <!-- Page Title -->
    <div class="mb-3">
        <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
            <img width="20" src="{{asset('/public/assets/back-end/img/shipping_method.png')}}" alt="">
            {{\App\CPU\Helpers::translate('shipping_method_update')}}
        </h2>
    </div>
    <!-- End Page Title -->

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-capitalize">
                    <h5 class="mb-0">{{\App\CPU\Helpers::translate('shipping_method_update')}}</h5>
                </div>
                <div class="card-body">
                    <form action="{{route('seller.business-settings.shipping-method.update',[$method['id']])}}" method="post"
                          style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <div class="row ">
                                <div class="col-md-12">
                                    <label for="title" class="title-color">{{\App\CPU\Helpers::translate('title')}}</label>
                                    <input type="text" name="title" value="{{$method['title']}}" class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row ">
                                <div class="col-md-12">
                                    <label for="duration" class="title-color">{{\App\CPU\Helpers::translate('duration')}}</label>
                                    <input type="text" name="duration" value="{{$method['duration']}}" class="form-control" placeholder="{{\App\CPU\Helpers::translate('Ex')}} : 4-6 {{\App\CPU\Helpers::translate('days')}}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row ">
                                <div class="col-md-12">
                                    <label for="cost" class="title-color">{{\App\CPU\Helpers::translate('cost')}}</label>
                                    <input type="text" min="0" max="1000000" name="cost" value="{{($method['cost'])}}" class="form-control" placeholder="{{\App\CPU\Helpers::translate('Ex')}} : 10 $">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('Update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')

@endpush
