@extends('layouts.back-end.app')

@section('title',\App\CPU\Helpers::translate('Emergency_Contact'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{asset('/public/assets/back-end/img/add-new-delivery-man.png')}}" alt="">
                {{\App\CPU\Helpers::translate('Emergency_Contact')}}
            </h2>
        </div>
        <!-- End Page Title -->

        <!-- Page Header -->
        <div class="row">
            <div class="col-12">

                @if(Helpers::module_permission_check('emergency-contact.add'))
                <form action="{{route('admin.delivery-man.emergency-contact.add')}}" method="post" id="edit_contact">
                    @csrf
                    <div class="card">
                        <!-- End Page Header -->
                        <div class="card-body">
                            <h5 class="mb-0 page-header-title d-flex align-items-center gap-2 border-bottom pb-3 mb-3">
                                <i class="tio-user"></i>
                                {{\App\CPU\Helpers::translate('Add_New_Contact_Information')}}
                            </h5>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="title-color d-flex"
                                               for="f_name">{{\App\CPU\Helpers::translate('contact_name')}}</label>
                                        <input type="text" name="name" class="form-control"
                                               placeholder="{{\App\CPU\Helpers::translate('contact_name')}}"
                                               required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="title-color d-flex"
                                               for="exampleFormControlInput1">{{\App\CPU\Helpers::translate('phone')}}</label>
                                        <input dir="ltr" name="phone" class="form-control phoneInput" value="+966"
                                               placeholder="{{\App\CPU\Helpers::translate('EX: +966***********')}}"
                                               required>
                                    </div>
                                </div>

                            </div>
                            <div class="d-flex gap-3 justify-content-end">
                                <button type="reset" id="reset"
                                        class="btn btn-secondary px-4">{{\App\CPU\Helpers::translate('reset')}}</button>
                                <button type="submit" class="btn btn--primary btn-primary px-4 submitbtn">{{\App\CPU\Helpers::translate('submit')}}</button>
                                <button type="submit" class="btn btn--primary btn-primary px-4 savebtn" style="display: none">{{\App\CPU\Helpers::translate('save')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
                @endif

                <div class="card mt-3">
                        <div class="p-3">
                            <div class="row gy-1 align-items-center justify-content-between">
                                <div class="col-auto">
                                    <h5>
                                        {{\App\CPU\Helpers::translate('Contact_information_Table')}}
                                        <span
                                            class="badge badge-soft-dark radius-50 fz-12 ml-1">{{ $contacts->count() }}</span>
                                    </h5>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="datatable" style="text-align: left;"
                                   class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                                <thead class="thead-light thead-50 text-capitalize">
                                <tr>
                                    <th>{{\App\CPU\Helpers::translate('SL')}}</th>
                                    <th class="text-center">{{\App\CPU\Helpers::translate('name')}}</th>
                                    <th class="text-center">{{\App\CPU\Helpers::translate('phone')}}</th>
                                    <th class="text-center">{{\App\CPU\Helpers::translate('status')}}</th>
                                    <th class="text-center">{{\App\CPU\Helpers::translate('action')}}</th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse($contacts as $contact)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td class="text-center text-capitalize">{{ $contact->name }}</td>
                                    <td class="text-center"><a class="title-color hover-c1" href="tel:{{$contact->phone}}">{{$contact->phone}}</a></td>
                                    <td>
                                        <label class="mx-auto switcher">
                                                <input onchange="status_change(this)" type="checkbox" class="switcher_input status"
                                                       data-id="{{$contact->id}}" {{$contact->status == true?'checked':''}}>
                                                <span class="switcher_control"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            @if(Helpers::module_permission_check('emergency-contact.edit'))
                                            <a class="btn btn-outline-primary btn-sm edit" href="javascript:"
                                            onclick="edit_contact('{{ $contact->name }}','{{ $contact->phone }}','{{ $contact->status }}','{{ $contact->id }}')"
                                            title="{{ \App\CPU\Helpers::translate('Edit')}}">
                                                <i class="tio-edit"></i>
                                            </a>
                                            @endif

                                            <a class="btn btn-outline-danger btn-sm delete mx-2" href="javascript:"
                                            onclick="delete_contact('delete-contact-{{$contact->id}}','{{ Helpers::translate('Are you sure?') }}')"
                                            title="{{ \App\CPU\Helpers::translate('Delete')}}">
                                                <i class="tio-delete"></i>
                                            </a>
                                            <form action="{{route('admin.delivery-man.emergency-contact.destroy')}}"
                                                method="post" id="delete-contact-{{$contact->id}}">
                                                @csrf @method('delete')
                                                <input type="hidden" name="id" value="{{ $contact->id }}">
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">
                                            <div class="text-center p-4">
                                                <img class="mb-3 w-160"
                                                     src="{{ asset('public/assets/back-end/svg/illustrations/sorry.svg') }}"
                                                     alt="Image Description">
                                                <p class="mb-0">No data to show</p>
                                            </div>

                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="table-responsive mt-4">
                            <div class="px-4 d-flex justify-content-center justify-content-md-end">
                                <!-- Pagination -->
                                {{ $contacts->links() }}
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>

@endsection

@push('script_2')

    <script>
        @if(Helpers::module_permission_check('emergency-contact.add'))
        function edit_contact(name,phone,status,id){
            $("input[name=name]").val(name);
            $("input[name=phone]").val(phone);
            $("#edit_contact").append("<input type='hidden' value='"+id+"' name='id' />");
            $(".submitbtn").hide();
            $(".savebtn").show();
        }
        @endif

        function status_change(t) {
            let id = $(t).data('id');
            let checked = $(t).prop("checked");
            let status = checked === true ? 1 : 0;

            Swal.fire({
                title: 'Are you sure?',
                text: 'Want to change status',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'No',
                confirmButtonText: 'Yes',
                reverseButtons: true
            }).then((result) => {
                    if (result.value) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: "{{ route('admin.delivery-man.emergency-contact.ajax-status-change') }}",
                            method: 'POST',
                            data: {
                                status: status,
                                id : id
                            },
                            success: function (data) {
                                if(data == 0){
                                    toastr.error("{{ Helpers::translate('Access Denied !') }}")
                                    location.reload()
                                }else{
                                    if (data.fail == 1) {
                                        toastr.error(data.message);
                                    }
                                    toastr.success(data.message);
                                }
                            }
                        });
                    }
                }
            )
        }

    </script>

    <script>
        function delete_contact(id, message) {
            Swal.fire({
                title: '{{\App\CPU\Helpers::translate('Are you sure')}}?',
                text: message,
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'No',
                confirmButtonText: 'Yes',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $('#' + id).submit()
                }
            })
        }

    </script>
@endpush
