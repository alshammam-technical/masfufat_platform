@extends('layouts.back-end.app')

@section('title',\App\CPU\Helpers::translate('Deliveryman List'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">

        <!-- Page Title -->
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{asset('/public/assets/back-end/img/deliveryman.png')}}" width="20" alt="">
                {{\App\CPU\Helpers::translate('Deliveryman List')}} <span class="badge badge-soft-dark radius-50 fz-12">{{ $delivery_men->count() }}</span>
            </h2>
        </div>
        <!-- End Page Title -->

        <div class="col-lg-7" hidden>
            <div class="d-flex table-actions flex-wrap justify-content-end mx-3">
                <div class="d-flex">
                <a title="{{Helpers::translate('Add new')}}" class="btn ti-plus btn-success my-2 btn-icon-text m-2" href="{{route('admin.delivery-man.add')}}">
                    <i class="fa fa-plus"></i>
                </a>
                <button title="{{Helpers::translate('Add from')}}" class="btn btn-info mdi mdi-arrange-bring-forward btnAddFrom my-2 btn-icon-text m-2" disabled onclick="addFrom('delivery_men')">
                    <i class="fa fa-clone"></i>
                </button>

                <button title="{{Helpers::translate('Save')}}" class="btn ti-save btn-success my-2 btn-icon-text m-2 save-btn" style="display: none"
                onclick="$('.table').removeClass('editMode');$('.edit-btn').show();$(this).hide();saveTableChanges()">
                    <i class="fa fa-save"></i>
                </button>

                <button title="{{Helpers::translate('Edit')}}" class="btn btn-info my-2 btn-icon-text m-2 edit-btn"
                onclick="$('.table').addClass('editMode');$('.save-btn').show();$(this).hide()">
                    <i class="fa fa-pencil"></i>
                </button>

                <button title="{{Helpers::translate('delete')}}" class="btnDeleteRow btn ti-trash btn-danger my-2 btn-icon-text m-2"
                onclick="form_alert('bulk-delete','Want to delete this item ?')"
                >
                    <i class="fa fa-trash"></i>
                </button>
                <button title="{{Helpers::translate('show/hide columns')}}" class="btn buttons-collection dropdown-toggle buttons-colvis d-none btn-primary my-2 btn-icon-text m-2">
                    <i class="fa fa-toggle"></i>
                </button>
                </div>
                <div class="moreOptions justify-content-center mt-2 mr-2 ml-4">
                    <div class="dropdown dropdown">
                        <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary dropdown-toggle" data-toggle="dropdown" id="droprightMenuButton" type="button" style="height:43px">
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
                        </div>
                    </div>

                </div>
                <div>
                <label class="input-group mt-2" style="height: 34px">
                    <input
                    type="search"
                    class="form-control form-control-sm"
                    placeholder="..."
                    style="border-radius:0px 6px 6px 0px !important;height: 43px"
                    onkeyup="globalSearch(event.target.value)"
                    >
                    <button class="btn search-btn btn-primary" onclick="productsDTsearch()" style="border-radius:6px 0px 0px 6px !important;margin-top:1px">
                    <i class="fa fa-search"></i>
                    </button>
                </label>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 mb-3">
                <!-- Card -->
                <div class="card">
                    <!-- Header -->
                    <div class="px-3 py-4">
                        <div class="d-flex justify-content-between gap-10 flex-wrap align-items-center">
                            <div class="">
                                <form action="{{url()->current()}}" method="GET">
                                    <!-- Search -->
                                    <div class="input-group input-group-merge input-group-custom">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tio-search"></i>
                                            </div>
                                        </div>
                                        <input id="datatableSearch_" type="search" name="search" class="form-control"
                                                placeholder="{{Helpers::translate('Search')}}" aria-label="Search" value="{{$search}}" required>
                                        <button type="submit" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('search')}}</button>

                                    </div>
                                    <!-- End Search -->
                                </form>
                            </div>

                            <div class="d-flex justify-content-end">
                                <a href="{{route('admin.delivery-man.add')}}" class="btn btn--primary btn-primary">
                                    <i class="tio-add"></i>
                                    {{\App\CPU\Helpers::translate('add deliveryman')}}
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- End Header -->

                    <!-- Table -->
                    <div class="table-responsive datatable-custom">
                        <table class="table table-hover table-borderless table-thead-bordered table-align-middle card-table {{ Session::get('direction') === 'rtl' ? 'text-right' : 'text-left' }}">
                            <thead class="thead-light thead-50 text-capitalize table-nowrap">
                            <tr>
                                <th>{{\App\CPU\Helpers::translate('SL')}}</th>
                                <th>{{\App\CPU\Helpers::translate('name')}}</th>
                                <th>{{\App\CPU\Helpers::translate('Contact Info ')}}</th>
                                <th>{{\App\CPU\Helpers::translate('Total_Orders')}}</th>
                                <th>{{\App\CPU\Helpers::translate('Rating')}}</th>
                                <th class="text-center">{{\App\CPU\Helpers::translate('status')}}</th>
                                <th class="text-center">{{\App\CPU\Helpers::translate('action')}}</th>
                            </tr>
                            </thead>

                            <tbody id="set-rows">
                            @forelse($delivery_men as $key=>$dm)
                                <tr>
                                    <td>{{$delivery_men->firstitem()+$key}}</td>
                                    <td>
                                        <div class="media align-items-center gap-10">
                                            <img class="rounded-circle avatar avatar-lg"
                                                 onerror="this.src='{{asset('public/assets/back-end/img/160x160/img1.jpg')}}'"
                                                 src="{{asset('storage/app/public/delivery-man')}}/{{$dm['image']}}">
                                            <div class="media-body">
                                                <a title="Earning Statement"
                                                   class="title-color hover-c1"
                                                   href="{{ route('admin.delivery-man.earning-statement-overview', ['id' => $dm['id']]) }}">
                                                    {{$dm['f_name'].' '.$dm['l_name']}}
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column gap-1">
                                            <div><a class="title-color hover-c1" href="mailto:{{$dm['email']}}"><strong>{{$dm['email']}}</strong></a></div>
                                            <a class="title-color hover-c1" href="tel:+{{$dm['country_code']}}{{$dm['phone']}}">+{{ $dm['country_code'].' '. $dm['phone']}}</a>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.orders.list', ['all', 'delivery_man_id' => $dm['id']]) }}" class="badge fz-14 badge-soft--primary">
                                            <span>{{ $dm->orders_count }}</span>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.delivery-man.rating', ['id' => $dm['id']]) }}" class="badge fz-14 badge-soft-info">
                                            <span>{{ isset($dm->rating[0]->average) ? number_format($dm->rating[0]->average, 2, '.', ' ') : 0 }} <i class="tio-star"></i> </span>
                                        </a>
                                    </td>
                                    <td>
                                        <label class="mx-auto switcher">
                                            <input type="checkbox" class="switcher_input status"
                                                   id="{{$dm['id']}}" {{$dm->is_active == 1?'checked':''}}>
                                            <span class="switcher_control"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center align-items-center gap-10">
                                            <a  class="btn btn-outline--primary btn-sm edit"
                                                title="{{\App\CPU\Helpers::translate('edit')}}"
                                                href="{{route('admin.delivery-man.edit',[$dm['id']])}}">
                                                <i class="tio-edit"></i></a>
                                            <a title="Earning Statement"
                                               class="btn btn-outline-info btn-sm square-btn"
                                               href="{{ route('admin.delivery-man.earning-statement-overview', ['id' => $dm['id']]) }}">
                                                <i class="tio-money"></i>
                                            </a>
                                            <a class="btn btn-outline-danger btn-sm delete" href="javascript:"
                                                onclick="form_alert('delivery-man-{{$dm['id']}}','Want to remove this information ?')"
                                                title="{{ \App\CPU\Helpers::translate('Delete')}}">
                                                <i class="tio-delete"></i>
                                            </a>
                                            <form action="{{route('admin.delivery-man.delete',[$dm['id']])}}"
                                                    method="post" id="delivery-man-{{$dm['id']}}">
                                                @csrf @method('delete')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="text-center p-4">
                                            <img class="mb-3 w-160" src="{{ asset('public/assets/back-end/svg/illustrations/sorry.svg') }}" alt="Image Description">
                                            <p class="mb-0">{{\App\CPU\Helpers::translate('No_delivery_man_found')}}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive mt-4">
                        <div class="px-4 d-flex justify-content-lg-end">
                            <!-- Pagination -->
                            {!! $delivery_men->links() !!}
                        </div>
                    </div>
                </div>
                <!-- End Card -->
            </div>
        </div>
    </div>

@endsection

@push('script_2')
    <script>
        $(document).on('change', '.status', function () {
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
                url: "{{route('admin.delivery-man.status-update')}}",
                method: 'POST',
                data: {
                    id: id,
                    status: status
                },
                success: function (data) {
                    if(data == 0) {
                        toastr.error("{{ Helpers::translate('Access Denied !') }}")
                        location.reload();
                    }else{
                        toastr.success('{{\App\CPU\Helpers::translate('Status updated successfully')}}');
                    }
                }
            });
        });
    </script>
@endpush
