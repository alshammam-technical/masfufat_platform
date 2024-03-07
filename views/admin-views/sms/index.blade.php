@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('Add new sms'))

@push('css_or_js')

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
                                {{Helpers::translate('push_sms')}}
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
        <!-- End Page Title -->

        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            @if(Helpers::module_permission_check('marketing.sms.add'))
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('admin.sms.store')}}" method="post"
                              style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                              enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="title-color text-capitalize"
                                               for="exampleFormControlInput1">{{\App\CPU\Helpers::translate('the message text')}} </label>
                                        <textarea name="description" id="sms_text" class="form-control" required></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <label class="title-color text-capitalize w-100" for="exampleFormControlInput1">
                                            {{\App\CPU\Helpers::translate('send to')}}
                                        </label>

                                        <div class="d-block gap-10 align-items-center mb-2 w-100">
                                            <div class="mx-2 mb-3">
                                                <input type="checkbox" name="email_to[seller]" value="seller" onchange="$(this).next().next().slideToggle()">
                                                <label class="title-color mb-0">{{\App\CPU\Helpers::translate('a seller')}}</label>

                                                <div class="input-group" style="display: none">
                                                    <div class="form-control p-0">
                                                        <select
                                                        class="SumoSelect-custom"
                                                        multiple
                                                        id="sent_to"
                                                        onchange="getRequest('{{url('/')}}/admin/product/get-categories?parent_id='+this.value,'sub-category-select','select')">
                                                            @foreach(\App\Model\Seller::all() as $user)
                                                                <option value="{{$user['id']}}">
                                                                    {{ $user->store_informations['company_name'] ?? $user['name'] }} ,
                                                                    {{ $user->store_informations['phone'] ?? $user['phone'] }} ,
                                                                    {{ Helpers::get_prop('App\countries',$user->store_informations['country'] ?? $user['country'],'name') }} ,
                                                                    {{ Helpers::get_prop('App\areas',$user->store_informations['area'] ?? '','name') }} ,
                                                                    {{ Helpers::get_prop('App\cities',$user->store_informations['city'] ?? $user['city'],'name') }} ,
                                                                    {{ Helpers::get_prop('App\provinces',$user->store_informations['governorate'] ?? '','name') }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <input type="hidden" name="sent_to[seller]" value="{{isset($product_category[0]) ? $product_category[0]->id : ''}}" />
                                                </div>
                                            </div>

                                            <div class="mx-2 mb-3">
                                                <input type="checkbox" name="email_to[store]" value="store" onchange="$(this).next().next().slideToggle()">
                                                <label class="title-color mb-0">{{\App\CPU\Helpers::translate('an online shop')}}</label>

                                                <div class="input-group" style="display: none">
                                                    <div class="form-control p-0">
                                                        <select
                                                        class="SumoSelect-custom"
                                                        multiple
                                                        id="sent_to"
                                                        onchange="getRequest('{{url('/')}}/admin/product/get-categories?parent_id='+this.value,'sub-category-select','select')">
                                                            @foreach(\App\User::where('is_store',true)->get() as $user)
                                                                <option value="{{$user['id']}}">
                                                                    {{ $user->store_informations['company_name'] ?? $user['name'] }} ,
                                                                    {{ $user->store_informations['phone'] ?? $user['phone'] }} ,
                                                                    {{ Helpers::get_prop('App\countries',$user->store_informations['country'] ?? $user['country'],'name') }} ,
                                                                    {{ Helpers::get_prop('App\areas',$user->store_informations['area'] ?? '','name') }} ,
                                                                    {{ Helpers::get_prop('App\cities',$user->store_informations['city'] ?? $user['city'],'name') }} ,
                                                                    {{ Helpers::get_prop('App\provinces',$user->store_informations['governorate'] ?? '','name') }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <input type="hidden" name="sent_to[store]" value="{{isset($product_category[0]) ? $product_category[0]->id : ''}}" />
                                                </div>
                                            </div>

                                            <div class="mx-2 mb-3">
                                                <input type="checkbox" name="email_to[end_user]" value="end_user" onchange="$(this).next().next().slideToggle()">
                                                <label class="title-color mb-0">{{\App\CPU\Helpers::translate('an end user')}}</label>

                                                <div class="input-group" style="display: none">
                                                    <div class="form-control p-0">
                                                        <select
                                                        class="SumoSelect-custom"
                                                        multiple
                                                        id="sent_to"
                                                        onchange="getRequest('{{url('/')}}/admin/product/get-categories?parent_id='+this.value,'sub-category-select','select')">
                                                        @foreach(\App\User::where('is_store',false)->get() as $user)
                                                                <option value="{{$user['id']}}">
                                                                    {{ $user->store_informations['company_name'] ?? $user['name'] }} ,
                                                                    {{ $user->store_informations['phone'] ?? $user['phone'] }} ,
                                                                    {{ Helpers::get_prop('App\countries',$user->store_informations['country'] ?? $user['country'],'name') }} ,
                                                                    {{ Helpers::get_prop('App\areas',$user->store_informations['area'] ?? '','name') }} ,
                                                                    {{ Helpers::get_prop('App\cities',$user->store_informations['city'] ?? $user['city'],'name') }} ,
                                                                    {{ Helpers::get_prop('App\provinces',$user->store_informations['governorate'] ?? '','name') }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <input type="hidden" name="sent_to[end_user]" value="{{isset($product_category[0]) ? $product_category[0]->id : ''}}" />
                                                </div>
                                            </div>

                                            <div class="mx-2 mb-3">
                                                <input type="checkbox" name="email_to[ext]" value="ext" onchange="$(this).next().next().slideToggle()">
                                                <label class="title-color mb-0">{{\App\CPU\Helpers::translate('other numbers')}}</label>

                                                <div class="input-group" style="display: none">
                                                    <input class="form-control" type="text" name="sent_to[ext]">
                                                </div>
                                            </div>

                                        </div>


                                    </div>
                                </div>
                            </div>


                            <div class="d-flex justify-content-end gap-3">
                                <button type="submit" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('Send the sms')}}  </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif

            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <div class="card">
                    <div class="px-3 py-4">
                        <div class="row align-items-center">
                            <div class="col-sm-4 col-md-6 col-lg-8 mb-2 mb-sm-0">
                                <h5 class="mb-0 text-capitalize d-flex align-items-center gap-2">
                                    {{ \App\CPU\Helpers::translate('Push_sms_Table')}}
                                    <span
                                        class="badge badge-soft-dark radius-50 fz-12 ml-1">{{ $smss->total() }}</span>
                                </h5>
                            </div>
                            <div class="col-sm-8 col-md-6 col-lg-4">
                                <form action="{{ url()->current() }}" method="GET">
                                    <div class="input-group input-group-merge input-group-custom">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tio-search"></i>
                                            </div>
                                        </div>
                                        <input id="datatableSearch_" type="search" name="search" class="form-control"
                                               placeholder="{{\App\CPU\Helpers::translate('Search by message text')}}"
                                               aria-label="Search orders" value="{{ $search }}" required>
                                        <button type="submit"
                                                class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('search')}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive datatable-custom">
                        <table style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                               class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                            <thead class="thead-light thead-50 text-capitalize">
                            <tr>
                                <th>{{\App\CPU\Helpers::translate('SL')}} </th>
                                <th>{{\App\CPU\Helpers::translate('message text')}} </th>
                                <th>{{\App\CPU\Helpers::translate('Resend')}} </th>
                            </tr>

                            </thead>

                            <tbody>
                            @foreach($smss as $key=>$sms)
                                <tr>
                                    <td>{{$smss->firstItem()+ $key}}</td>
                                    <td>
                                        {{\Illuminate\Support\Str::limit($sms['description'],40)}}
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" class="btn btn-outline-success square-btn btn-sm"
                                           onclick="resendsms(this)" data-id="{{ $sms->id }}">
                                            <i class="tio-refresh"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <table class="mt-4">
                            <tfoot>
                            {!! $smss->links() !!}
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End Table -->
        </div>
    </div>

@endsection

@push('script_2')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function () {
            readURL(this);
        });

        function resendsms(t) {
            let id = $(t).data('id');

            Swal.fire({
                title: '{{\App\CPU\Helpers::translate("Are_you_sure?")}}',
                text: '{{\App\CPU\Helpers::translate('Resend_sms')}}',
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#161853',
                cancelButtonText: '{{\App\CPU\Helpers::translate("No")}}',
                confirmButtonText: '{{\App\CPU\Helpers::translate("Yes")}}',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '{{ route("admin.sms.resend-sms") }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id
                        },
                        beforeSend: function () {
                            $('#loading').show();
                        },
                        success: function (res) {
                           document.getElementById('sms_text').value = res.description
                        },
                        complete: function () {
                            $('#loading').hide();
                        }
                    });
                }
            })
        }
    </script>
@endpush
