@extends('layouts.front-end.app')

@section('title',\App\CPU\Helpers::translate('My Support Tickets'))

@push('css_or_js')
    <style>
        .headerTitle {
            font-size: 24px;
            font-weight: 600;
            margin-top: 1rem;
        }

        body {
            font-family: 'Titillium Web', sans-serif
        }

        .product-qty span {
            font-size: 14px;
            color: #6A6A6A;
        }

        .font-nameA {
            font-weight: 600;
            display: inline-block;
            margin-bottom: 0;
            font-size: 17px;
            color: #030303;
        }

        .spandHeadO {
            font-weight: 600 !important;
            font-size: 14px !important;

        }

        .tdBorder {
            text-align: center;
        }

        .bodytr {
            text-align: center;
        }

        .modal-footer {
            border-top: none;
        }

        .sidebarL h3:hover + .divider-role {
            border-bottom: 3px solid {{$web_config['primary_color']}}         !important;
            transition: .2s ease-in-out;
        }

        .marl {
            margin-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 7px;
        }

        tr td {
            padding: 3px 5px !important;
        }

        td button {
            padding: 3px 13px !important;
        }

        @media (max-width: 600px) {
            .sidebar_heading {
                background: {{$web_config['primary_color']}};
            }

            .sidebar_heading h1 {
                text-align: center;
                color: aliceblue;
                padding-bottom: 17px;
                font-size: 19px;
            }
        }
    </style>
    <style>
        thead{
            background-color: #F8F8F8;
            border-radius: 11px;
        }

        thead * td{
            padding-top: 15px !important;
            padding-bottom: 15px !important;
        }

        .tdBorder {
            border: none;
            text-align: center;
        }
        tr td, tr th{
            width: 14.28571428571429%;
        }

        .card-footer{
            border: none !important;
            background-color: #F8F8F8 !important;
        }

        .pagination{
            background-color: white;
        }

        .page-item.active,.page-item.active .page-link{
            background-color: #0084F4 !important;
            border-radius: 0px !important;
        }

        .table, .dataTables_scrollHead{
            background-color: white;
            border: white;
        }

        td{
            color: black
        }

        .table th, .table td{
            border: none;
        }
    </style>
@endpush

@section('content')

    <div class="modal fade rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};" id="open-ticket" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg  " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-md-12"><h5
                                class="modal-title font-nameA ">{{\App\CPU\Helpers::translate('submit_new_ticket')}}</h5></div>
                        @if(1==2)
                        <div class="col-md-12" style=" color: #030303;  margin-top: 1rem;">
                            <span>{{\App\CPU\Helpers::translate('you_will_get_response')}}.</span>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="modal-body">
                    <form class="mt-3" method="post" action="{{route('ticket-submit')}}" id="open-ticket">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="firstName">{{\App\CPU\Helpers::translate('Ticket title')}}</label>
                                <input type="text" class="form-control" id="ticket-subject" name="ticket_subject"
                                       required>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="">
                                    <label class="" for="inlineFormCustomSelect">{{\App\CPU\Helpers::translate('Type')}}</label>
                                    <select class="custom-select " id="ticket-type" name="ticket_type" required>
                                        <option
                                            value="Website problem">{{\App\CPU\Helpers::translate('problem in website or app')}}</option>
                                        <option value="Partner request">{{\App\CPU\Helpers::translate('partner_request')}}</option>
                                        <option value="Complaint">{{\App\CPU\Helpers::translate('Complaint')}}</option>
                                        <option
                                        value="Info inquiry">{{\App\CPU\Helpers::translate('inquiry')}} </option>
                                        <option value="Complaint">{{\App\CPU\Helpers::translate('Help on request')}}</option>
                                    </select>
                                </div>
                            </div>
                            @if(1==2)
                            <div class="form-group col-md-6">
                                <div class="">
                                    <label class="" for="inlineFormCustomSelect">{{\App\CPU\Helpers::translate('Priority')}}</label>
                                    <select class="form-control custom-select" id="ticket-priority"
                                            name="ticket_priority" required>
                                        <option value>{{\App\CPU\Helpers::translate('choose_priority')}}</option>
                                        <option value="Urgent">{{\App\CPU\Helpers::translate('Urgent')}}</option>
                                        <option value="High">{{\App\CPU\Helpers::translate('High')}}</option>
                                        <option value="Medium">{{\App\CPU\Helpers::translate('Medium')}}</option>
                                        <option value="Low">{{\App\CPU\Helpers::translate('Low')}}</option>
                                    </select>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="detaaddressils">{{\App\CPU\Helpers::translate('Text')}}</label>
                                <textarea class="form-control" rows="6" id="ticket-description"
                                          name="ticket_description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer" style="padding: 0px!important;">
                            <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">{{\App\CPU\Helpers::translate('close')}}</button>
                            <button type="submit" class="btn btn--primary text-light">{{\App\CPU\Helpers::translate('submit_a_ticket')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4 mt-3 rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
        <!-- Content  -->
            <section class="col-lg-12 col-md-12">
                <!-- Toolbar-->
                <!-- Tickets list-->
                @php($allTickets =App\Model\SupportTicket::where('customer_id', auth('customer')->id())->get())
                <div class="card box-shadow-sm">
                    <div style="overflow: auto">
                        <table class="table">
                            <thead>
                            <tr style="background: #f8f8f8">
                                <td class="tdBorder" style="width: 10%;">
                                    <div class="py-2"><span
                                            class="d-block spandHeadO ">{{\App\CPU\Helpers::translate('support Ticket number')}}</span></div>
                                </td>
                                <td class="tdBorder" style="width: 15%;">
                                    <div class="py-2"><span
                                            class="d-block spandHeadO ">{{\App\CPU\Helpers::translate('Ticket title')}}</span></div>
                                </td>
                                <td class="tdBorder" style="width: 20%;">
                                    <div class="py-2 {{Session::get('direction') === "rtl" ? 'mr-2' : 'ml-2'}}"><span
                                            class="d-block spandHeadO ">{{\App\CPU\Helpers::translate('The date and time of ticket registration')}}</span>
                                    </div>
                                </td>
                                <td class="tdBorder" style="width: 30%;">
                                    <div class="py-2"><span class="d-block spandHeadO">{{\App\CPU\Helpers::translate('Type')}}</span>
                                    </div>
                                </td>
                                <td class="tdBorder" style="width: 9%;">
                                    <div class="py-2">
                                        <span class="d-block spandHeadO">
                                            {{\App\CPU\Helpers::translate('Status')}}
                                        </span>
                                    </div>
                                </td>

                                <td class="tdBorder" style="width: 7%;">
                                    <div class="py-2"><span
                                            class="d-block spandHeadO">{{\App\CPU\Helpers::translate('Action')}} </span></div>
                                </td>
                            </tr>
                            </thead>

                            <tbody>

                            @foreach($allTickets as $ticket)
                                <tr>
                                    <td class="bodytr font-weight-bold" style="color: {{$web_config['primary_color']}}">
                                        <span class="marl">{{$ticket['id']}}</span>
                                    </td>
                                    <td class="bodytr font-weight-bold" style="color: {{$web_config['primary_color']}}">
                                        <span class="marl">{{$ticket['subject']}}</span>
                                    </td>
                                    <td class="bodytr">
                                        <span>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$ticket['created_at'])->format('Y-m-d h:i A')}}</span>
                                    </td>
                                    <td class="bodytr"><span class="">{{ Helpers::translate($ticket['type']) }}</span></td>
                                    <td class="bodytr"><span class="">{{ $ticket['status'] == "close" ? Helpers::translate('closed') : Helpers::translate($ticket['status']) }}</span></td>


                                    <td class="bodytr d-flex pe-4">
                                        <a class="text-light pt-2 px-3" href="{{route('support-ticket.index',$ticket['id'])}}">
                                            <i class="fa fa-eye text-info"></i>
                                        </a>

                                        <a href="javascript:"
                                           onclick="Swal.fire({
                                               title: '{{\App\CPU\Helpers::translate('Do you want to delete this?')}}',
                                               showDenyButton: true,
                                               showCancelButton: true,
                                               confirmButtonColor: '{{$web_config['primary_color']}}',
                                               cancelButtonColor: '{{$web_config['secondary_color']}}',
                                               confirmButtonText: `{{\App\CPU\Helpers::translate('Yes')}}`,
                                               denyButtonText: `{{\App\CPU\Helpers::translate("Don't Delete")}}`,
                                               }).then((result) => {
                                               if (result.value) {
                                               Swal.fire('Deleted!', '', 'success')
                                               location.href='{{ route('support-ticket.delete',['id'=>$ticket->id])}}';
                                               } else{
                                               Swal.fire('Cancelled', '', 'info')
                                               }
                                               })"
                                           id="delete" class=" marl">
                                            <i class="ri-delete-bin-5-fill" style="font-size: 25px; color:#e81616;"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-light card box-shadow-sm text-center px-4 py-3 mt-5">
                    <div class="mt-3 text-center justify-content-center align-self-center w-25">
                        <button type="submit" class="btn btn--primary py-3 w-100 float-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}" data-bs-toggle="modal"
                            data-bs-target="#open-ticket">
                            {{\App\CPU\Helpers::translate('add_new_ticket')}}
                        </button>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('script')
@endpush
