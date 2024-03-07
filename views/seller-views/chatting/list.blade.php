@extends('layouts.back-end.app-seller')
@section('title',\App\CPU\Helpers::translate('Chat List'))
@push('css_or_js')

@endpush

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('seller.dashboard')}}">{{\App\CPU\Helpers::translate('Dashboard')}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{\App\CPU\Helpers::translate('Chattings')}}</li>
        </ol>
    </nav>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h3 mb-0 text-black-50">{{\App\CPU\Helpers::translate('Chatting List')}}</h1>
    </div>

    <div class="row" style="margin-top: 20px">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{\App\CPU\Helpers::translate('Chatting Table')}}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th scope="col">{{\App\CPU\Helpers::translate('SL#')}}</th>
                                <th scope="col">{{\App\CPU\Helpers::translate('Image')}}</th>
                                <th scope="col">{{\App\CPU\Helpers::translate('Customer Name')}}</th>
                                <th scope="col">{{\App\CPU\Helpers::translate('Message')}}</th>
                                <th scope="col">{{\App\CPU\Helpers::translate('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($chattings as $k=>$chatting)
                                <tr>
                                    <td scope="row">{{$k+1}}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <a class="btn btn--primary btn-primary btn-sm view"
                                           href="">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <a href=""
                                           class="btn btn-danger btn-sm " onclick="alert('{{\App\CPU\Helpers::translate('Are You sure to Delete')}}')">
                                            <i class="fa fa-trash"></i>
                                        </a>
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


@endsection

@push('script')
    <!-- Page level plugins -->
    <script src="{{asset('public/assets/back-end')}}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset('public/assets/back-end')}}/js/demo/datatables-demo.js"></script>
@endpush
