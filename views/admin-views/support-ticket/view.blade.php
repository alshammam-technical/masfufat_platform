@extends('layouts.back-end.app')
@section('title', \App\CPU\Helpers::translate('Support Ticket'))
@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="{{asset('public/assets/back-end/css/croppie.css')}}" rel="stylesheet">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img width="20" src="{{asset('/public/assets/back-end/img/support_ticket.png')}}" alt="">
                {{\App\CPU\Helpers::translate('support_tickets list')}}
                <span class="badge badge-soft-dark radius-50 fz-14">{{ $tickets->total() }}</span>
            </h2>
        </div>
        <!-- End Page Title -->

        <div class="row mt-20">
            <div class="col-md-12">
                <div class="">
                    <div class="px-3 py-4 mb-3 border-bottom">
                        <div class="d-flex flex-wrap justify-content-between gap-3 align-items-center">
                            <div style="width: 30%">
                                <!-- Search -->
                                <form action="{{ url()->current() }}" method="GET">
                                    <div class="input-group input-group-merge input-group-custom">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tio-search"></i>
                                            </div>
                                        </div>
                                        <input id="datatableSearch_" type="search" name="search" class="form-control"
                                               placeholder="{{\App\CPU\Helpers::translate('Search Ticket by ticket number or Subject...')}}"
                                               aria-label="Search orders" value="{{ $search }}">
                                        <button type="submit"
                                                class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('search')}}</button>
                                    </div>
                                </form>
                                <!-- End Search -->
                            </div>
                            <div class="">
                                <div class="d-flex flex-wrap flex-sm-nowrap gap-3 justify-content-end">
                                    @php($priority=request()->has('priority')?request()->input('priority'):'')

                                    @php($status=request()->has('status')?request()->input('status'):'')
                                    <select class="form-control border-color-c1 w-160"
                                            onchange="filter_tickets('status',this.value)">
                                        <option value="all">{{ Helpers::translate('All') }}</option>
                                        <option value="pending" {{$status=='pending'?'selected':''}}>{{ Helpers::translate('new') }}</option>
                                        <option value="open" {{$status=='open'?'selected':''}}>{{ Helpers::translate('open') }}</option>
                                        <option value="close" {{$status=='close'?'selected':''}}>{{ Helpers::translate('closed') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    @foreach($tickets as $key =>$ticket)
                        <div class="border-bottom mb-3 pb-3">
                            <div class="card">
                                <div
                                    class="card-body align-items-center d-flex flex-wrap justify-content-between gap-3 border-bottom">
                                    <div class="media gap-3">
                                        <img class="avatar avatar-lg"
                                             src="{{asset('storage/app/public/user')}}/{{$ticket->customer->store_informations['image']??""}}"
                                             alt="">
                                        <div class="media-body">
                                            <h6 class="mb-0 {{Session::get('direction') === "rtl" ? 'text-right' : 'text-left'}}">{{$ticket->customer->name??""}}</h6>
                                            <div class="mb-2 fz-12 {{Session::get('direction') === "rtl" ? 'text-right' : 'text-left'}}">{{$ticket->customer->email??""}}</div>
                                            <div
                                                class="d-none d-lg-flex justify-content-between align-items-center">
                                                <div class="d-flex w-100 text-light text-center {{Session::get('direction') === "rtl" ? 'ml-3' : 'mr-3'}}">
                                                    <div class="font-size-ms px-3">
                                                        <div class="font-weight-medium text-dark">{{\App\CPU\Helpers::translate('support Ticket number')}}</div>
                                                        <div class="text-dark">{{$ticket['id']}}</div>
                                                    </div>
                                                    <div class="font-size-ms px-3">
                                                        <div class="font-weight-medium text-dark">{{\App\CPU\Helpers::translate('The date and time of ticket registration')}}</div>
                                                        <div class="text-dark">{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$ticket['created_at'])->format('Y/m/d H:i')}}</div>
                                                    </div>
                                                    <div class="font-size-ms px-3">
                                                        <div class="font-weight-medium text-dark">{{\App\CPU\Helpers::translate('The last update on the ticket')}}</div>
                                                        <div class="text-dark">{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$ticket['updated_at'])->format('Y/m/d H:i')}}</div>
                                                    </div>
                                                    <div class="font-size-ms px-3">
                                                        <div class="font-weight-medium text-dark">{{\App\CPU\Helpers::translate('Type')}}</div>
                                                        <div class="text-dark">{{Helpers::translate($ticket['type'])}}</div>
                                                    </div>
                                                    @if (1==2)
                                                    <div class="font-size-ms px-3">
                                                        <div class="font-weight-medium text-dark" style="color:black">{{\App\CPU\Helpers::translate('Priority')}}</div>
                                                        <span class="badge badge-warning text-dark">{{Helpers::translate($ticket['type'])}}</span>
                                                    </div>
                                                    @endif
                                                    <div class="font-size-ms px-3">
                                                        <div class="font-weight-medium" style="color: black">{{\App\CPU\Helpers::translate('Status')}}</div>
                                                        @if($ticket['status']=='open')
                                                            <span class="badge badge-secondary">{{$ticket['status'] == "close" ? Helpers::translate('closed') : Helpers::translate($ticket['status'])}}</span>
                                                        @else
                                                            <span class="badge badge-secondary">{{$ticket['status'] == "close" ? Helpers::translate('closed') : Helpers::translate($ticket['status'])}}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <label class="switcher">
                                        <input class="switcher_input status" type="checkbox"
                                               {{$ticket->status=='open'?'checked':''}} id="{{$ticket->id}}">
                                        <span class="switcher_control"></span>
                                    </label>
                                </div>
                                <div
                                    class="card-body align-items-end d-flex flex-wrap flex-md-nowrap justify-content-between gap-4">
                                    <div>
                                        {{$ticket->description}}
                                    </div>
                                    <div class="text-nowrap">
                                        <a class="btn btn--primary btn-primary"
                                           href="{{route('admin.support-ticket.singleTicket',$ticket['id'])}}">
                                            <i class="tio-open-in-new"></i> {{\App\CPU\Helpers::translate('view')}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="table-responsive mt-4">
                    <div class="px-4 d-flex justify-content-lg-end">
                        <!-- Pagination -->
                        {{$tickets->links()}}
                    </div>
                </div>

                @if(count($tickets)==0)
                    <div class="text-center p-4">
                        <img class="mb-3 w-160"
                             src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg"
                             alt="Image Description">
                        <p class="mb-0">{{\App\CPU\Helpers::translate('No data to show')}}</p>
                    </div>
                @endif
            </div>
        </div>
    @endsection

    @push('script')
        <!-- Page level plugins -->
            <script src="{{asset('public/assets/back-end')}}/vendor/datatables/jquery.dataTables.min.js"></script>
            <script
                src="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

            <script>
                // Call the dataTables jQuery plugin
                $(document).ready(function () {
                    $('#dataTable').DataTable();
                });
            </script>

            <!-- Page level custom scripts -->
            <script src="{{asset('public/assets/back-end/js/croppie.js')}}"></script>
            <script>
                $(document).on('change', '.status', function () {
                    var id = $(this).attr("id");
                    if ($(this).prop("checked") === true) {
                        var status = 'open';
                    } else if ($(this).prop("checked") === false) {
                        var status = 'close';
                    }

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{route('admin.support-ticket.status')}}",
                        method: 'POST',
                        data: {
                            id: id,
                            status: status
                        },
                        success: function (data) {
                            if(data == 1){
                                toastr.success("{{ Helpers::translate('Ticket status updated successfully') }}");
                            }else{
                                toastr.error("{{ Helpers::translate('Access Denied !') }}")
                                location.reload()
                            }
                        }
                    });
                });

                function filter_tickets(param, value) {
                    let text = window.location;
                    let redirect_to = '';
                    let polished = removeURLParameter(text.toString(), param);
                    if (polished.includes('?')) {
                        redirect_to = polished + '&' + param + '=' + value;
                    } else {
                        redirect_to = polished + '?' + param + '=' + value;
                    }

                    location.href = redirect_to;
                }

                function removeURLParameter(url, parameter) {
                    var urlparts = url.split('?');
                    if (urlparts.length >= 2) {
                        var prefix = encodeURIComponent(parameter) + '=';
                        var pars = urlparts[1].split(/[&;]/g);
                        for (var i = pars.length; i-- > 0;) {
                            if (pars[i].lastIndexOf(prefix, 0) !== -1) {
                                pars.splice(i, 1);
                            }
                        }
                        return urlparts[0] + (pars.length > 0 ? '?' + pars.join('&') : '');
                    }
                    return url;
                }
            </script>
    @endpush
