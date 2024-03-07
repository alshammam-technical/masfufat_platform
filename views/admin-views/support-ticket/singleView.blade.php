@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('Support Ticket'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">

        <!-- Page Title -->
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img width="20" src="{{asset('/public/assets/back-end/img/support_ticket.png')}}" alt="">
                {{\App\CPU\Helpers::translate('support_ticket')}}
            </h2>
        </div>
        <!-- End Page Title -->

        <div class="card">
            <div class="card-header flex-wrap gap-3">
            @foreach($supportTicket as $ticket )
                <?php
                $userDetails = \App\User::where('id', $ticket['customer_id'])->first();
                $conversations = \App\Model\SupportTicketConv::where('support_ticket_id', $ticket['id'])->get();
                $admin = \App\Model\Admin::get();
                ?>
                <div class="media d-flex gap-3">
                    <img class="rounded-circle avatar" src="{{asset('storage/app/public/user')}}/{{isset($userDetails)?$userDetails->store_informations['image']:''}}"
                            onerror="this.src='{{asset('public/assets/back-end/img/160x160/img1.jpg')}}"
                            alt="{{isset($userDetails)?$userDetails['name']:'not found'}}"/>
                    <div class="media-body">
                        <h6 class="font-size-md mb-1">{{isset($userDetails)?$userDetails['name']:'not found'}}</h6>
                        <div dir="ltr" class="fz-12">{{isset($userDetails)?$userDetails['phone']:''}}</div>
                    </div>
                </div>
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
                            <div class="type font-weight-bold bg-soft--primary c1 px-2 rounded">{{ Helpers::translate($ticket['type']) }}</div>
                        </div>
                        @if (1==2)
                        <div class="font-size-ms px-3">
                            <div class="font-weight-medium text-dark" style="color:black">{{\App\CPU\Helpers::translate('Priority')}}</div>
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
            <div class="card-body">

                <div class="mb-4">
                    <p class="font-size-md message-box message-box_incoming mb-1">{{$ticket['description']}}</p>
                    <span class="fz-12 text-muted d-flex">{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$ticket['created_at'])->format('Y/m/d H:i')}}</span>
                </div>
                @foreach($conversations as $conversation)
                    @if($conversation['admin_message'] ==null )
                        <div class="mb-4">
                            <p class="font-size-md message-box message-box_incoming mb-1">{{$conversation['customer_message']}}</p>
                            <span class="fz-12 text-muted d-flex">{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$conversation['created_at'])->format('Y/m/d H:i')}}</span>
                        </div>
                    @endif
                    @if($conversation['customer_message'] ==null )
                        <div class="mb-4 d-flex flex-column align-items-end">
                            <div>
                                <p class="font-size-md message-box mb-1">{{$conversation['admin_message']}}</p>
                                <span class="fz-12 text-muted d-flex"> {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$conversation['updated_at'])->format('Y/m/d H:i')}}</span>
                            </div>
                        </div>
                    @endif
                @endforeach

                @endforeach
                <!-- Leave message-->
                @if(Helpers::module_permission_check('admin.support-ticket.replay'))
                <h5 class="pt-4 pb-1 d-flex">{{\App\CPU\Helpers::translate('Leave a Message')}}</h5>
                @foreach($supportTicket as $reply)
                    <form class="needs-validation" href="{{route('admin.support-ticket.replay',$reply['id'])}}" method="post"
                        >
                        @csrf
                        <input type="hidden" name="id" value="{{$reply['id']}}">
                        <input type="hidden" name="adminId" value="1">
                        <div class="form-group">
                        <textarea class="form-control" name="replay" rows="8" placeholder=""
                                required></textarea>
                            <div class="invalid-tooltip">{{\App\CPU\Helpers::translate('Please write the message')}}!</div>
                        </div>
                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                            <div class="custom-control custom-checkbox d-block">
                            </div>
                            <button class="btn btn--primary btn-primary px-4" type="submit">{{\App\CPU\Helpers::translate('Reply')}}</button>
                        </div>
                    </form>
                @endforeach
                @endif
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
    <script src="{{asset('public/assets/back-end/js/croppie.js')}}"></script>

@endpush
