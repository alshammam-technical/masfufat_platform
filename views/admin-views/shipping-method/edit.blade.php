@extends('layouts.back-end.app')

@push('css_or_js')

@endpush

@section('content')
<div class="content container-fluid">
    <!-- <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\Helpers::translate('Dashboard')}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{\App\CPU\Helpers::translate('Shipping Method Update')}}</li>
        </ol>
    </nav> -->


    <!-- Page Title -->
    <div class="mb-3">
        <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
            <img src="{{asset('/public/assets/back-end/img/business-setup.png')}}" alt="">
            {{\App\CPU\Helpers::translate('Shipping_Method_Update')}}
        </h2>
    </div>
    <!-- End Page Title -->

    <!-- Page Heading -->
    <!-- <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h3 mb-0 text-black-50">{{\App\CPU\Helpers::translate('shipping_method update')}}</h1>
    </div> -->

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <!-- <div class="card-header">
                    {{\App\CPU\Helpers::translate('shipping_method form')}}
                </div> -->
                <div class="card-body">
                    <form action="{{route('admin.business-settings.shipping-method.update',[$method['id']])}}"
                          style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                          method="post">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <div class="row ">
                                <div class="col-md-12">
                                    <label class="title-color" for="title">{{\App\CPU\Helpers::translate('title')}}</label>
                                    <input type="text" name="title" value="{{$method['title']}}" class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row ">
                                <div class="col-md-12">
                                    <label class="title-color" for="duration">{{\App\CPU\Helpers::translate('duration')}}</label>
                                    <input type="text" name="duration" value="{{$method['duration']}}" class="form-control" placeholder="{{\App\CPU\Helpers::translate('Ex')}} : {{\App\CPU\Helpers::translate('4 to 6 days')}}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row ">
                                <div class="col-md-12">
                                    <label class="title-color" for="cost">{{\App\CPU\Helpers::translate('cost')}}</label>
                                    <input type="number" min="0" max="1000000" name="cost" value="{{($method['cost'])}}" class="form-control" placeholder="{{\App\CPU\Helpers::translate('Ex')}} : {{\App\CPU\Helpers::translate('10 $')}}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <label class="title-color" for="tax">{{\App\CPU\Helpers::translate('Value tax')}}</label>
                                    <input type="number" min="0" max="100" name="tax" class="form-control" value="{{($method['tax'])}}"
                                        placeholder="{{\App\CPU\Helpers::translate('Ex')}} : {{\App\CPU\Helpers::translate('10')}} ">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-10 flex-wrap justify-content-end">
                            <button type="submit" class="btn btn--primary btn-primary px-4">{{\App\CPU\Helpers::translate('Update')}}</button>
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
