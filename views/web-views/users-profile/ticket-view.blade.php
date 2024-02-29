@extends('layouts.front-end.app')

@section('title',\App\CPU\Helpers::translate('Support Ticket'))

@push('css_or_js')
    <style>
        .text-pre-wrap {
            white-space: pre-wrap;
        }
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
            color: #FFFFFF !important;
            font-weight: 600 !important;
            font-size: 14px !important;

        }

        .tdBorder {
            border-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'left' : 'right'}}: 1px solid #f7f0f0;
            text-align: center;
        }

        .bodytr {
            border: 1px solid #dadada;
            text-align: center;
        }

        .sellerName {
            font-size: 15px;
            font-weight: 600;
        }

        .modal-footer {
            border-top: none;
        }

        .sidebarL h3:hover + .divider-role {
            border-bottom: 3px solid {{$web_config['primary_color']}}                !important;
            transition: .2s ease-in-out;
        }

        .marl {
            margin-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}: 7px;
        }
        .badge-warning{
            color:white;
            background: {{$web_config['primary_color']}};

        }
        .badge-secondary{
            color:white;
            background: {{$web_config['secondary_color']}};
        }
        .badge-success {

        }

         .for-margin-sms{
            margin-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}: 56.3333333333%;
         }
         @media(max-width:475px){
            .for-margin-sms {
            margin-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}: 0.333333%;
           }
         }
        @media (max-width: 600px) {
            .sidebar_heading {
                background: {{$web_config['primary_color']}}
                }





            .sidebar_heading h1 {
                text-align: center;
                color: aliceblue;
                padding-bottom: 17px;
                font-size: 19px;
            }
        }
    </style>
@endpush

@section('content')
@php($storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id())
@php($user = \App\User::find($storeId))
    <!-- Page Title-->
    <div class="container rtl" style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-9 sidebar_heading">
                <h1 class="h3  mb-0 float-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}} headerTitle">{{\App\CPU\Helpers::translate('SUPPORT TICKET ANSWER')}}</h1>
            </div>
        </div>
    </div>
    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-3 rtl" style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
        <!-- Content  -->
            <section class="col-lg-12">
                <!-- Toolbar-->
                <div
                    class="d-none d-lg-flex justify-content-between align-items-center pt-lg-3 pb-4 pb-lg-5 mb-lg-4">
                    <div class="d-flex w-full text-light text-center {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'ml-3' : 'mr-3'}}">
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
                        <div class="ticket-attachments">
                            <div class="font-weight-medium" style="color: black">{{\App\CPU\Helpers::translate('Attachments')}}</div>
                            <ul>
                                @foreach($ticket->attachments as $attachment)
                                <li>
                                    @if(in_array($attachment->file_type, ['jpg', 'jpeg', 'png']))
                                        <!-- عرض الصورة مع Lightbox -->
                                        <a href="{{ asset('storage/app/'.$attachment->file_path) }}" data-lightbox="attachment-gallery" data-title="{{ $attachment->file_name }}">
                                            Image
                                        </a>
                                    @elseif($attachment->file_type === 'pdf')
                                        <!-- أيقونة PDF -->
                                        <a href="{{ asset('storage/app/'.$attachment->file_path) }}" download>
                                            <i class="fas fa-file-pdf"></i> {{ $attachment->file_name }}
                                        </a>
                                    @elseif($attachment->file_type === 'mp4')
                                        <!-- أيقونة فيديو -->
                                        video
                                    @elseif($attachment->file_type === 'xlsx' || $attachment->file_type === 'xls')
                                        <!-- أيقونة Excel -->
                                        <a href="{{ asset('storage/app/'.$attachment->file_path) }}" download>
                                            <i class="fas fa-file-excel"></i> {{ $attachment->file_name }}
                                        </a>
                                    @elseif($attachment->file_type === 'docx')
                                        <!-- أيقونة Word -->
                                        <a href="{{ asset('storage/app/'.$attachment->file_path) }}" download>
                                            <i class="fas fa-file-word"></i> {{ $attachment->file_name }}
                                        </a>
                                    @endif
                                </li>
                            @endforeach

                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Ticket details (visible on mobile)-->
                <div class="d-flex d-lg-none flex-wrap bg-secondary text-center rounded-lg pt-4 px-4 pb-1 mb-4">
                    <div class="font-size-sm px-3 pb-3">
                        <div class="font-weight-medium">{{\App\CPU\Helpers::translate('Date Submitted')}}</div>
                        <div
                            class="text-muted">{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$ticket['created_at'])->format('Y/m/d H:i')}}</div>
                    </div>
                    <div class="font-size-sm px-3 pb-3">
                        <div class="font-weight-medium">{{\App\CPU\Helpers::translate('Last Updated')}}</div>
                        <div
                            class="text-muted">{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$ticket['updated_at'])->format('Y/m/d H:i')}}</div>
                    </div>
                    <div class="font-size-sm px-3 pb-3">
                        <div class="font-weight-medium">{{\App\CPU\Helpers::translate('Type')}}</div>
                        <div class="text-muted">{{$ticket['type']}}</div>
                    </div>
                    <div class="font-size-sm px-3 pb-3">
                        <div class="font-weight-medium">{{\App\CPU\Helpers::translate('Priority')}}</div>
                        <span class="badge badge-warning">{{$ticket['priority']}}</span>
                    </div>
                    <div class="font-size-sm px-3 pb-3">
                        <div class="font-weight-medium">{{\App\CPU\Helpers::translate('Status')}}</div>
                        @if($ticket['status']=='open')
                            <span class="badge btn btn-secondary">{{$ticket['status']}}</span>
                        @else
                            <span class="badge btn btn-secondary">{{$ticket['status']}}</span>
                        @endif
                    </div>
                    <div class="ticket-attachments">
                            <div class="font-weight-medium" style="color: black">{{\App\CPU\Helpers::translate('Attachments')}}</div>
                            <ul>
                                @foreach($ticket->attachments as $attachment)
                                <li>
                                    @if(in_array($attachment->file_type, ['jpg', 'jpeg', 'png']))
                                        <!-- عرض الصورة مع Lightbox -->
                                        <a href="{{ asset('storage/app/'.$attachment->file_path) }}" data-lightbox="attachment-gallery" data-title="{{ $attachment->file_name }}">
                                            <img src="{{ asset('storage/app/'.$attachment->file_path) }}" alt="{{ $attachment->file_name }}" style="max-width: 100%; max-height: 100%;">
                                        </a>
                                    @elseif($attachment->file_type === 'pdf')
                                        <!-- أيقونة PDF -->
                                        <a href="{{ asset('storage/app/'.$attachment->file_path) }}" download>
                                            <i class="fas fa-file-pdf"></i> {{ $attachment->file_name }}
                                        </a>
                                    @elseif($attachment->file_type === 'mp4')
                                        <!-- أيقونة فيديو -->
                                        <video width="100%" controls>
                                            <source src="{{ asset('storage/app/' . $attachment->file_path) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                    @elseif($attachment->file_type === 'xlsx' || $attachment->file_type === 'xls')
                                        <!-- أيقونة Excel -->
                                        <a href="{{ asset('storage/app/'.$attachment->file_path) }}" download>
                                            <i class="fas fa-file-excel"></i> {{ $attachment->file_name }}
                                        </a>
                                    @elseif($attachment->file_type === 'docx')
                                        <!-- أيقونة Word -->
                                        <a href="{{ asset('storage/app/'.$attachment->file_path) }}" download>
                                            <i class="fas fa-file-word"></i> {{ $attachment->file_name }}
                                        </a>
                                    @endif
                                </li>
                            @endforeach

                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Comment-->

                {{-- <div class="media pb-4" style="text-align: right;">

                </div> --}}
                <div class="col-sm-6 col-lg-5 media p-4  for-margin-sms bg-light rounded @if($ticket['description'] == '') d-none  @endif" style="overflow-wrap: anywhere;">
                    <img class="rounded-circle" style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'left' : 'right'}}; height:40px; width:40px;"
                         onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                         src="{{asset('storage/app/public/profile')}}/{{$user->image}}"
                         alt="{{$user->name}}"/>
                    <div class="media-body {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'pr-3' : 'pl-3'}}" style="width: -webkit-fill-available;">
                        <h6 class="font-size-md mb-2">{{$user->name}}</h6>
                        <p class="font-size-md mb-1 text-pre-wrap">{{$ticket['description']}}</p>
                        @foreach($ticket->attachments as $attachment)
                        <li>
                            @if(in_array($attachment->file_type, ['jpg', 'jpeg', 'png']))
                                <!-- عرض الصورة مع Lightbox -->
                                <a href="{{ asset('storage/app/'.$attachment->file_path) }}" data-lightbox="attachment-gallery" data-title="{{ $attachment->file_name }}">
                                    <img src="{{ asset('storage/app/'.$attachment->file_path) }}" alt="{{ $attachment->file_name }}" style="max-width: 100%; max-height: 100%;">
                                </a>
                            @elseif($attachment->file_type === 'pdf')
                                <!-- أيقونة PDF -->
                                <a href="{{ asset('storage/app/'.$attachment->file_path) }}" download>
                                    <i class="fas fa-file-pdf"></i> {{ $attachment->file_name }}
                                </a>
                            @elseif($attachment->file_type === 'mp4')
                                <!-- أيقونة فيديو -->
                                {{--  <a href="{{ asset('storage/app/'.$attachment->file_path) }}" download>
                                    <i class="fas fa-file-video"></i> {{ $attachment->file_name }}
                                </a>  --}}
                                <video width="100%" controls>
                                    <source src="{{ asset('storage/app/' . $attachment->file_path) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                            @elseif($attachment->file_type === 'xlsx' || $attachment->file_type === 'xls')
                                <!-- أيقونة Excel -->
                                <a href="{{ asset('storage/app/'.$attachment->file_path) }}" download>
                                    <i class="fas fa-file-excel"></i> {{ $attachment->file_name }}
                                </a>
                            @elseif($attachment->file_type === 'docx')
                                <!-- أيقونة Word -->
                                <a href="{{ asset('storage/app/'.$attachment->file_path) }}" download>
                                    <i class="fas fa-file-word"></i> {{ $attachment->file_name }}
                                </a>
                            @endif
                        </li>
                    @endforeach

                        <span class="font-size-ms text-muted">
                                 <i class="czi-time align-middle {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'ml-2' : 'mr-2'}}"></i>
                            {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$ticket['created_at'])->format('Y-m-d h:i A')}}
                        </span>
                    </div>
                </div>
                @foreach($ticket->conversations as $conversation)
{{--                    {{dd($conversation)}}--}}
                    @if($conversation['customer_message'] == null )
                        <div class="col-sm-6 col-lg-5 media p-4 bg-light rounded mb-5" style="    overflow-wrap: anywhere;">
                            <div class="media-body {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'pr-3' : 'pl-3'}}">
                                @php($admin=\App\Model\Admin::where('id',$conversation['admin_id'])->first())
                                <h6 class="font-size-md mb-2">{{$admin['name']}}</h6>
                                <p class="font-size-md mb-1 text-pre-wrap">{{$conversation['admin_message']}}</p>
                                @foreach($conversation->attachments as $attachment)
                                <div class="mb-1 mt-5 d-flex flex-column align-items-end" style="">
                                    <div style="width: 100%;text-align: center;border: 4px dashed #fdcd05;border-radius: 5px; padding: 2rem;">
                                        <h5 class="font-size-md text-center" style="margin-top: -2.8rem;background-color: #f8f9fa;width: fit-content;margin-bottom: 2rem;">{{\App\CPU\Helpers::translate('attachments')}}</h5>
                                            <a href="{{ asset('storage/app/'.$attachment->file_path) }}" target="_blank">

                                            </a>

                                            @if(in_array($attachment->file_type, ['jpg', 'jpeg', 'png']))
                                <!-- عرض الصورة مع Lightbox -->
                                <a href="{{ asset('storage/app/'.$attachment->file_path) }}" data-lightbox="attachment-gallery" data-title="{{ $attachment->file_name }}">
                                    <img src="{{ asset('storage/app/'.$attachment->file_path) }}" alt="{{ $attachment->file_name }}" style="max-width: 100%; max-height: 100%;">
                                </a>
                            @elseif($attachment->file_type === 'pdf')
                                <!-- أيقونة PDF -->
                                <a href="{{ asset('storage/app/'.$attachment->file_path) }}" download>
                                    <i class="fas fa-file-pdf"></i> {{ $attachment->file_name }}
                                </a>
                            @elseif($attachment->file_type === 'mp4')
                                <!-- أيقونة فيديو -->
                                {{--  <a href="{{ asset('storage/app/'.$attachment->file_path) }}" download>
                                    <i class="fas fa-file-video"></i> {{ $attachment->file_name }}
                                </a>  --}}
                                <video width="100%" controls>
                                    <source src="{{ asset('storage/app/' . $attachment->file_path) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                            @elseif($attachment->file_type === 'xlsx' || $attachment->file_type === 'xls')
                                <!-- أيقونة Excel -->
                                <a href="{{ asset('storage/app/'.$attachment->file_path) }}" download>
                                    <i class="fas fa-file-excel"></i> {{ $attachment->file_name }}
                                </a>
                            @elseif($attachment->file_type === 'docx')
                                <!-- أيقونة Word -->
                                <a href="{{ asset('storage/app/'.$attachment->file_path) }}" download>
                                    <i class="fas fa-file-word"></i> {{ $attachment->file_name }}
                                </a>
                            @endif
                                        </div>
                                </div>
                                @endforeach
                                <span
                                    class="font-size-ms text-muted"> {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$conversation['updated_at'])->format('Y-m-d h:i A')}}</span>
                            </div>
                        </div>
                    @endif
                    @if($conversation['admin_message'] == null)
                        <div class="col-sm-6 col-lg-5 media p-4 for-margin-sms bg-light rounded mb-5">
                            <img class="rounded-circle" height="40" width="40"
                                 onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                 src="{{asset('storage/app/public/profile')}}/{{$user->image}}"
                                 alt="{{$user->name}}"/>
                            <div class="media-body {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'pr-3' : 'pl-3'}}">
                                <h6 class="font-size-md mb-2">{{$user->name}}</h6>
                                <p class="font-size-md mb-1 text-pre-wrap">{{$conversation['customer_message']}}</p>
                                @foreach($conversation->attachments as $attachment)
                                <div class="mb-1 mt-5 d-flex flex-column align-items-end" style="">
                                    <div style="width: 100%;text-align: center;border: 4px dashed #fdcd05;border-radius: 5px; padding: 2rem;">
                                        <h5 class="font-size-md text-center" style="margin-top: -2.8rem;background-color: #f8f9fa;width: fit-content;margin-bottom: 2rem;">{{\App\CPU\Helpers::translate('attachments')}}</h5>
                                            <a href="{{ asset('storage/app/'.$attachment->file_path) }}" target="_blank">

                                            </a>

                                            @if(in_array($attachment->file_type, ['jpg', 'jpeg', 'png']))
                                <!-- عرض الصورة مع Lightbox -->
                                <a href="{{ asset('storage/app/'.$attachment->file_path) }}" data-lightbox="attachment-gallery" data-title="{{ $attachment->file_name }}">
                                    <img src="{{ asset('storage/app/'.$attachment->file_path) }}" alt="{{ $attachment->file_name }}" style="max-width: 100%; max-height: 100%;">
                                </a>
                            @elseif($attachment->file_type === 'pdf')
                                <!-- أيقونة PDF -->
                                <a href="{{ asset('storage/app/'.$attachment->file_path) }}" download>
                                    <i class="fas fa-file-pdf"></i> {{ $attachment->file_name }}
                                </a>
                            @elseif($attachment->file_type === 'mp4')
                                <!-- أيقونة فيديو -->
                                {{--  <a href="{{ asset('storage/app/'.$attachment->file_path) }}" download>
                                    <i class="fas fa-file-video"></i> {{ $attachment->file_name }}
                                </a>  --}}
                                <video width="100%" controls>
                                    <source src="{{ asset('storage/app/' . $attachment->file_path) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                            @elseif($attachment->file_type === 'xlsx' || $attachment->file_type === 'xls')
                                <!-- أيقونة Excel -->
                                <a href="{{ asset('storage/app/'.$attachment->file_path) }}" download>
                                    <i class="fas fa-file-excel"></i> {{ $attachment->file_name }}
                                </a>
                            @elseif($attachment->file_type === 'docx')
                                <!-- أيقونة Word -->
                                <a href="{{ asset('storage/app/'.$attachment->file_path) }}" download>
                                    <i class="fas fa-file-word"></i> {{ $attachment->file_name }}
                                </a>
                            @endif
                                        </div>
                                </div>
                                @endforeach
                                <span class="font-size-ms text-muted">
                                             <i class="czi-time align-middle {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'ml-2' : 'mr-2'}}"></i>
                                    {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$conversation['created_at'])->format('Y-m-d h:i A')}}
                                </span>
                            </div>
                        </div>
                @endif
            @endforeach
            <!-- Leave message-->
                <div class="col-sm-12">
                    <h3 class="h5 mt-2 pt-4 pb-2">{{\App\CPU\Helpers::translate('Leave a Message')}}</h3>
                    <form class="needs-validation" href="{{route('support-ticket.comment',[$ticket['id']])}}"
                          method="post" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="form-group">
                            <textarea class="form-control" name="comment" rows="8"
                                      placeholder="{{\App\CPU\Helpers::translate('Write your message here...')}}" required></textarea>
                            <div class="invalid-tooltip">{{\App\CPU\Helpers::translate('Please write the message')}}!</div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="attachments">{{\App\CPU\Helpers::translate('Attachments')}}</label>
                                <input type="file" class="form-control" id="attachments" name="attachments[]" multiple accept=".jpg, .jpeg, .png, .pdf, .xls, .docx, .mp4">
                                <small>{{\App\CPU\Helpers::translate('Allowed Types: jpg, jpeg, png, pdf, xls, docx, mp4')}}</small>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                            @if (\App\CPU\Helpers::store_module_permission_check('my_account.support_ticket.close_ticket'))
                            @if (App\CPU\Helpers::get_business_settings('enable_close_ticket') == 1)
                            <div class="">
                                <a href="{{route('support-ticket.close',[$ticket['id']])}}" class="btn btn-secondary"
                                   style="color: white">{{\App\CPU\Helpers::translate('close')}}</a>
                            </div>
                            @endif
                            @endif
                            @if (\App\CPU\Helpers::store_module_permission_check('my_account.support_ticket.replay'))
                            <button class="btn bg-primaryColor my-2" type="submit">{{\App\CPU\Helpers::translate('Submit message')}}</button>
                            @endif
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>

@endsection

@push('script')

@endpush
