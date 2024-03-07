@extends('layouts.back-end.app')

@section('title',$seller->shop ? $seller->shop->name : \App\CPU\Helpers::translate("shop name not found"))

@section('content')
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex gap-2 align-items-center">
                <img src="{{asset('/public/assets/back-end/img/coupon_setup.png')}}" alt="">
                {{\App\CPU\Helpers::translate('Review_list')}}
            </h2>
        </div>
        <!-- End Page Title -->

        <!-- Page Heading -->
        <div class="flex-between d-sm-flex row align-items-center justify-content-between mb-2 mx-1">
            <div>
                <a href="{{route('admin.sellers.seller-list')}}"
                   class="btn btn--primary btn-primary my-3">{{\App\CPU\Helpers::translate('Back_to_seller_list')}}</a>
            </div>
            <div>
                @if ($seller->status=="pending")
                    <div class="mt-4 pr-2">
                        <div class="flex-between">
                            <div class="mx-1"><h4><i class="tio-shop-outlined"></i></h4></div>
                            <div><h4>{{\App\CPU\Helpers::translate('Seller_request_for_open_a_shop.')}}</h4></div>
                        </div>
                        <div class="text-center">
                            <form class="d-inline-block" action="{{route('admin.sellers.updateStatus')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{$seller->id}}">
                                <input type="hidden" name="status" value="approved">
                                <button type="submit"
                                        class="btn btn--primary btn-primary btn-sm">{{\App\CPU\Helpers::translate('Approve')}}</button>
                            </form>
                            <form class="d-inline-block" action="{{route('admin.sellers.updateStatus')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{$seller->id}}">
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit"
                                        class="btn btn-danger btn-sm">{{\App\CPU\Helpers::translate('reject')}}</button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <!-- Page Header -->
        <div class="page-header">
            <div class="flex-between row mx-1">
                <div>
                    <h1 class="page-header-title">{{ $seller->shop ? $seller->shop->name : "Shop Name : Update Please" }}</h1>
                </div>
            </div>
            <!-- Nav Scroller -->
            <div class="js-nav-scroller hs-nav-scroller-horizontal">
                <!-- Nav -->
                <ul class="nav nav-tabs lightSliderrflex-wrap page-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link "
                           href="{{ route('admin.sellers.view',$seller->id) }}">{{\App\CPU\Helpers::translate('seller primary data')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           href="{{ route('admin.sellers.view',['id'=>$seller->id, 'tab'=>'order']) }}">{{\App\CPU\Helpers::translate('Order')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           href="{{ route('admin.sellers.view',['id'=>$seller->id, 'tab'=>'product']) }}">{{\App\CPU\Helpers::translate('seller Products')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           href="{{ route('admin.sellers.view',['id'=>$seller->id, 'tab'=>'setting']) }}">{{\App\CPU\Helpers::translate('Setting')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           href="{{ route('admin.sellers.view',['id'=>$seller->id, 'tab'=>'transaction']) }}">{{\App\CPU\Helpers::translate('Transaction')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active"
                           href="{{ route('admin.sellers.view',['id'=>$seller->id, 'tab'=>'review']) }}">{{\App\CPU\Helpers::translate('Review')}}</a>
                    </li>
                </ul>
                <!-- End Nav -->
            </div>
            <!-- End Nav Scroller -->
        </div>
        <!-- End Page Header -->
        <div class="content container-fluid p-0">
            <!-- End Page Header -->
            <div class="row gx-2 gx-lg-3">
                <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                    <!-- Card -->
                    <div class="card">
                        <!-- Header -->
                        <div class="px-3 py-4">
                            <div class="row align-items-center">
                                <div class="col-sm-4 col-md-6 col-lg-8 mb-3 mb-sm-0">
                                    <h5 class="mb-0 d-flex gap-1 align-items-center">
                                        {{ Helpers::translate('List of seller product ratings') }}
                                        <span
                                            class="badge badge-soft-dark radius-50 fz-12">{{ $reviews->total() }}</span>
                                    </h5>
                                </div>
                                <div class="col-sm-8 col-md-6 col-lg-4">
                                    <form action="{{ url()->current() }}" method="GET">
                                        <!-- Search -->
                                        <div class="input-group input-group-merge input-group-custom">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="tio-search"></i>
                                                </div>
                                            </div>
                                            <input id="datatableSearch_" type="search" name="search"
                                                   class="form-control"
                                                   placeholder="{{ Helpers::translate('Search by product') }}" aria-label="Search orders"
                                                   value="{{ $search }}">
                                            <button type="submit" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('Search')}}</button>
                                        </div>
                                        <!-- End Search -->
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End Header -->

                        <!-- Table -->
                        <div class="table-responsive datatable-custom">
                            <table id="columnSearchDatatable"
                                   style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                   class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                                <thead class="thead-light thead-50 text-capitalize">
                                    <tr>
                                        <th>{{ \App\CPU\Helpers::translate('SL') }}</th>
                                        <th>{{ \App\CPU\Helpers::translate('The Product') }}</th>
                                        <th>{{ \App\CPU\Helpers::translate('Customer') }}</th>
                                        <th>{{ \App\CPU\Helpers::translate('the rating') }}</th>
                                        <th>{{ \App\CPU\Helpers::translate('the comment') }}</th>
                                        <th>{{ \App\CPU\Helpers::translate('date & time') }}</th>
                                        <th class="text-center">{{ \App\CPU\Helpers::translate('status') }}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($reviews as $key => $review)
                                    @if ($review->product)
                                        <tr>
                                            <td>
                                                {{ $reviews->firstItem()+$key }}
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.product.edit', [$review['product_id']]) }}" class="title-color hover-c1">
                                                    {{ Str::limit($review->product['name'], 25) }}
                                                </a>
                                            </td>
                                            <td>
                                                @if ($review->customer)
                                                    <a href="{{ route('admin.customer.view', [$review->customer_id]) }}" class="title-color hover-c1">
                                                        {{ $review->customer->name }}
                                                    </a>
                                                @else
                                                    <label
                                                        class="badge badge-soft-danger">{{ \App\CPU\Helpers::translate('customer_removed') }}</label>
                                                @endif
                                            </td>
                                            <td>
                                                <label class="badge badge-soft-info mb-0">
                                                    <span class="fz-12 d-flex align-items-center gap-1">{{ $review->rating }} <i class="tio-star"></i>
                                                    </span>
                                                </label>
                                            </td>
                                            <td>
                                                <div class="gap-1">
                                                    <div>{{ $review->comment ? Str::limit($review->comment, 35) : 'No Comment Found' }}</div>
                                                    <br>
                                                    @if($review->attachment)
                                                        @foreach (json_decode($review->attachment) as $img)
                                                            <a href="{{ asset('storage/app/public/review') }}/{{ $img }}"
                                                                data-lightbox="mygallery">
                                                                <img width="60" height="60" src="{{ asset('storage/app/public/review') }}/{{ $img }}"
                                                                    alt="Image">
                                                            </a>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </td>
                                            <td>{{ date('Y/m/d H:i', strtotime($review->created_at)) }}</td>
                                            <td>
                                                <center>
                                                    <label class="switcher">
                                                        <input type="checkbox" class="switcher_input"
                                                        id="{{$review['id']}}" {{$review->status == 1?'checked':''}}>
                                                        <span class="switcher_control"></span>
                                                    </label>
                                                </center>
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
                                {{$reviews->links()}}
                            </div>
                        </div>

                        @if(count($reviews)==0)
                            <div class="text-center p-4">
                                <img class="mb-3 w-160"
                                     src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg"
                                     alt="Image Description">
                                <p class="mb-0">{{ \App\CPU\Helpers::translate('No_data_to_show')}}</p>
                            </div>
                    @endif
                    <!-- End Footer -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')

@endpush
