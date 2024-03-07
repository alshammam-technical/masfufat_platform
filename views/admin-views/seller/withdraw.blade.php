@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('Withdraw Request'))

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
                            <a>
                                {{Helpers::translate('withdraws list')}}
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
        <!-- End Page Title -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="p-3">
                        <div class="row gy-1 align-items-center justify-content-between">
                            <div class="col-auto">
                                <h5>
                                {{ \App\CPU\Helpers::translate('Withdraw Request Table')}}
                                    <span class="badge badge-soft-dark radius-50 fz-12 ml-1">{{ $withdraw_req->total() }}</span>
                                </h5>
                            </div>
                            <div class="col-auto">
                                <select name="withdraw_status_filter" onchange="status_filter(this.value)" class="custom-select min-w-120">
                                    <option value="all" {{session()->has('withdraw_status_filter') && session('withdraw_status_filter') == 'all'?'selected':''}}>{{\App\CPU\Helpers::translate('All')}}</option>
                                    <option value="approved" {{session()->has('withdraw_status_filter') && session('withdraw_status_filter') == 'approved'?'selected':''}}>{{\App\CPU\Helpers::translate('Approved requests')}}</option>
                                    <option value="denied" {{session()->has('withdraw_status_filter') && session('withdraw_status_filter') == 'denied'?'selected':''}}>{{\App\CPU\Helpers::translate('Denied requests')}}</option>
                                    <option value="pending" {{session()->has('withdraw_status_filter') && session('withdraw_status_filter') == 'pending'?'selected':''}}>{{\App\CPU\Helpers::translate('Pending requests')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="datatable"
                                style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                            <thead class="thead-light thead-50 text-capitalize">
                            <tr>
                                <th>{{\App\CPU\Helpers::translate('SL')}}</th>
                                <th>{{\App\CPU\Helpers::translate('The balance to be withdrawn')}}</th>

                                <th>{{ \App\CPU\Helpers::translate('Seller name') }}</th>
                                <th>{{\App\CPU\Helpers::translate('date & time of withdraw')}}</th>
                                <th class="text-center">{{\App\CPU\Helpers::translate('status')}}</th>
                                <th class="text-center">{{\App\CPU\Helpers::translate('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($withdraw_req as $k=>$wr)
                                <tr>
                                    <td scope="row">{{$withdraw_req->firstItem()+$k}}</td>
                                    <td>{{\App\CPU\BackEndHelper::set_symbol(($wr['amount']))}}</td>

                                    <td>
                                        @if (isset($wr->seller))
                                            <a href="{{route('admin.sellers.view',$wr->seller_id)}}" class="title-color hover-c1">{{ $wr->seller->company_name }}</a>
                                        @else
                                        <a href="#">{{\App\CPU\Helpers::translate('not_found')}}</a>
                                        @endif
                                    </td>
                                    <td>{{Carbon\Carbon::parse($wr->created_at)->format('Y/m/d H:i')}}</td>
                                    <td class="text-center">
                                        @if($wr->approved==0)
                                            <label class="badge badge-soft-primary">{{\App\CPU\Helpers::translate('Pending_')}}</label>
                                        @elseif($wr->approved==1)
                                            <label class="badge badge-soft-success">{{\App\CPU\Helpers::translate('Approved_')}}</label>
                                        @else
                                            <label class="badge badge-soft-danger">{{\App\CPU\Helpers::translate('Denied_')}}</label>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            @if (isset($wr->seller))
                                            <a href="{{route('admin.sellers.withdraw_view',[$wr['id'],$wr->seller['id']])}}"
                                                class="btn btn-outline-info btn-sm square-btn"
                                                title="{{\App\CPU\Helpers::translate('View')}}">
                                                <i class="tio-invisible"></i>
                                                </a>
                                            @else
                                            <a href="#">
                                                {{\App\CPU\Helpers::translate('action_disabled')}}
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if(count($withdraw_req)==0)
                            <div class="text-center p-4">
                                <img class="mb-3 w-160"
                                        src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg"
                                        alt="Image Description">
                                <p class="mb-0">{{\App\CPU\Helpers::translate('No_data_to_show')}}</p>
                            </div>
                    @endif
                    </div>

                    <div class="table-responsive mt-4">
                        <div class="px-4 d-flex justify-content-center justify-content-md-end">
                            <!-- Pagination -->
                            {{$withdraw_req->links()}}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection


@push('script_2')
  <script>
      function status_filter(type) {
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.post({
              url: '{{route('admin.withdraw.status-filter')}}',
              data: {
                  withdraw_status_filter: type
              },
              beforeSend: function () {
                  $('#loading').show()
              },
              success: function (data) {
                 location.reload();
              },
              complete: function () {
                  $('#loading').hide()
              }
          });
      }
  </script>
@endpush
