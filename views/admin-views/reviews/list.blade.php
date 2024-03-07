@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('Review List'))

@section('content')
    <div class="content container-fluid">


        <div class="card card-body">
            <div class="row border-bottom pb-3 align-items-center mb-20">
                <div class="col-sm-4 col-md-6 col-lg-8 mb-2 mb-sm-0">
                    <h5 class="text-capitalize d-flex gap-2 align-items-center">
                        {{ \App\CPU\Helpers::translate('review_table') }}
                        <span class="badge badge-soft-dark radius-50 fz-12">{{ $reviews->total() }}</span>
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
                                placeholder="{{ \App\CPU\Helpers::translate('Search by Product or Customer') }}"
                                aria-label="Search orders" value="{{ $search }}" required>
                            <button type="submit" class="btn btn--primary btn-primary">{{ \App\CPU\Helpers::translate('search') }}</button>
                        </div>
                    </form>
                    <!-- End Search -->
                </div>
            </div>

            <form action="{{ url()->current() }}" method="GET">
                <div class="row gy-3 align-items-end">
                    <div class="col-md-4">
                        <div>
                            <label for="product" class="title-color d-flex">{{ \App\CPU\Helpers::translate('choose') }}
                                {{ \App\CPU\Helpers::translate('product') }}</label>
                            <select class="form-control" name="product_id">
                                <option value="" selected>
                                    --{{ \App\CPU\Helpers::translate('select_product') }}--</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}"
                                        {{ $product_id == $product->id ? 'selected' : '' }}>
                                        {{ Str::limit($product->name, 20) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div>
                            <label for="customer" class="title-color d-flex">{{ \App\CPU\Helpers::translate('choose') }}
                                {{ \App\CPU\Helpers::translate('customer') }}</label>
                            <select class="form-control" name="customer_id">
                                <option value="" selected>
                                    --{{ \App\CPU\Helpers::translate('select_customer') }}--</option>
                                @foreach ($customers as $item)
                                    <option value="{{ isset($item->id) ? $item->id : $customer_id }}"
                                        {{ $customer_id != null && $customer_id == $item->id ? 'selected' : '' }}>
                                        {{ Str::limit($item->name) }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div>
                            <label for="status" class="title-color d-flex">{{ \App\CPU\Helpers::translate('choose') }}
                                {{ \App\CPU\Helpers::translate('status') }}</label>
                            <select class="form-control" name="status">
                                <option value="" selected>
                                    --{{ \App\CPU\Helpers::translate('select_status') }}--</option>
                                <option value="1" {{ $status != null && $status == 1 ? 'selected' : '' }}>
                                    {{ \App\CPU\Helpers::translate('active') }}</option>
                                <option value="0" {{ $status != null && $status == 0 ? 'selected' : '' }}>
                                    {{ \App\CPU\Helpers::translate('inactive') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div>
                            <label for="from" class="title-color d-flex">{{ \App\CPU\Helpers::translate('from') }}</label>
                            <input type="date" name="from" id="from_date" value="{{ $from }}"
                                class="form-control"
                                title="{{ \App\CPU\Helpers::translate('from') }} {{ \App\CPU\Helpers::translate('date') }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div>
                            <label for="to" class="title-color d-flex">{{ \App\CPU\Helpers::translate('to') }}</label>
                            <input type="date" name="to" id="to_date" value="{{ $to }}"
                                class="form-control"
                                title="{{ ucfirst(\App\CPU\Helpers::translate('to')) }} {{ \App\CPU\Helpers::translate('date') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div>
                            <button id="filter" type="submit" class="btn btn--primary btn-primary btn-block filter">
                                <i class="tio-filter-list nav-icon"></i>
                                {{ \App\CPU\Helpers::translate('filter') }}
                            </button>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div>
                            <button type="button" class="btn btn-outline--primary text-nowrap btn-block" data-toggle="dropdown">
                                <i class="tio-download-to"></i>
                                {{ \App\CPU\Helpers::translate('export') }}
                                <i class="tio-chevron-down"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a class="dropdown-item" >{{ \App\CPU\Helpers::translate('Excel') }}</a></li>
                                <div class="dropdown-divider"></div>
                            </ul>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- End Page Header -->
        <div class="card mt-20">
            <div class="table-responsive datatable-custom">
                <table
                    class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100"
                    style="text-align: {{ Session::get('direction') === 'rtl' ? 'right' : 'left' }}">
                    <thead class="thead-light thead-50 text-capitalize">
                        <tr>
                            <th>{{ \App\CPU\Helpers::translate('SL') }}</th>
                            <th>{{ \App\CPU\Helpers::translate('Product') }}</th>
                            <th>{{ \App\CPU\Helpers::translate('Customer') }}</th>
                            <th>{{ \App\CPU\Helpers::translate('the rating') }}</th>
                            <th>{{ \App\CPU\Helpers::translate('the comment') }}</th>
                            <th>{{ \App\CPU\Helpers::translate('date & time') }}</th>
                            @if(Helpers::module_permission_check('customer_reviews.enable,customer_reviews.disable'))
                            <th class="text-center">{{ \App\CPU\Helpers::translate('status') }}</th>
                            @endif
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
                                    @if(Helpers::module_permission_check('customer_reviews.enable,customer_reviews.disable'))
                                    <td>
                                        <center>
                                            <label class="switcher">
                                                <input type="checkbox" class="switcher_input"
                                                id="{{$review['id']}}" {{$review->status == 1?'checked':''}}>
                                                <span class="switcher_control"></span>
                                            </label>
                                        </center>
                                    </td>
                                    @endif
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="table-responsive mt-4">
                <div class="px-4 d-flex justify-content-lg-end">
                    <!-- Pagination -->
                    {!! $reviews->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    @if(Helpers::module_permission_check('customer_reviews.enable,customer_reviews.disable'))
    <script>
        $(document).on('change', '.switcher_input', function () {
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
                url: "{{route('admin.reviews.bulk-status')}}",
                method: 'POST',
                data: {
                    ids: id,
                    status: status,
                    boolRes: true,
                },
                success: function (data) {
                    if(data == true) {
                        toastr.success('{{\App\CPU\Helpers::translate('Status updated successfully')}}');
                    }
                    else if(data.success == false) {
                        toastr.error('{{\App\CPU\Helpers::translate('Status updated failed. Product must be approved')}}');
                        setTimeout(function(){
                            location.reload();
                        }, 2000);
                    }
                }
            });
        });
    </script>
    @endif
@endpush

@push('script_2')
    <script>
        $(document).on('ready', function() {
            // INITIALIZATION OF DATATABLES
            // =======================================================
            // var datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));

            $('#column1_search').on('keyup', function() {
                datatable
                    .columns(1)
                    .search(this.value)
                    .draw();
            });

            $('#column2_search').on('keyup', function() {
                datatable
                    .columns(2)
                    .search(this.value)
                    .draw();
            });

            $('#column3_search').on('change', function() {
                datatable
                    .columns(3)
                    .search(this.value)
                    .draw();
            });

            $('#column4_search').on('keyup', function() {
                datatable
                    .columns(4)
                    .search(this.value)
                    .draw();
            });


            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function() {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });
    </script>
    <script>
        $(document).on('change', '#from_date', function() {
            from_date = $(this).val();
            if (from_date) {
                $("#to_date").prop('required', true);
            }
        });
    </script>
    <script>
        $('#from_date , #to_date').change(function() {
            let fr = $('#from_date').val();
            let to = $('#to_date').val();
            if (fr != '' && to != '') {
                if (fr > to) {
                    $('#from_date').val('');
                    $('#to_date').val('');
                    toastr.error('Invalid date range!', Error, {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            }

        })
    </script>
@endpush
