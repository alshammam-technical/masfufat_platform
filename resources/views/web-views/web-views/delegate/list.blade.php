@extends('layouts.front-end.app')

@section('title',\App\CPU\Helpers::translate('Employee List'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')

    <div class="content container-fluid min-h-[500px]">
        <!-- Page Title -->
        <div class="row mb-2">
            <div class="col-lg-12">
                <div style="display: flex; align-items: center; width: 100%;">
                    <nav aria-label="breadcrumb" style="flex-grow: 1;width: 100%;">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ Helpers::translate('Employees') }}</a></li>
                                <li class="breadcrumb-item mx-1" aria-current="page">
                                <a class="text-primary font-weight-bold" href="#">
                                    {{ Helpers::translate('Employees list') }}
                                </a>
                            </li>
                        </ol>
                    </nav>
                    @if (\App\CPU\Helpers::store_module_permission_check('my_account.employees.add'))
                    <a title="{{Helpers::translate('Add new Epmloyee')}}" class="btn ti-plus btn-warning my-2 btn-icon-text m-2" href="{{route('delegates.add')}}" target="_blank">
                        <span class="mx-1">{{Helpers::translate('Add new Epmloyee')}}</span><i class="fa fa-plus mx-2"></i>
                    </a>
                    @endif
                </div>

            </div>
        </div>
        <!-- End Page Title -->


        <div class="card box-shadow-sm">
            <div style="overflow: auto">
                <table class="table display nowrap" id="tickets_table" style="width:100%">
                    <thead>
                    <tr style="background: #f8f8f8">
                        <td class="lg:hidden md:hidden sm:table-cell text-center"></td>
                        <td class="tdBorder text-center">
                            <div class="py-2"><span
                                    class="d-block spandHeadO ">{{\App\CPU\Helpers::translate('number')}}</span></div>
                        </td>
                        <td class="tdBorder text-center">
                            <div class="py-2"><span
                                    class="d-block spandHeadO ">{{\App\CPU\Helpers::translate('name')}}</span></div>
                        </td>
                        <td class="tdBorder text-center">
                            <div class="py-2"><span
                                    class="d-block spandHeadO ">{{\App\CPU\Helpers::translate('email')}}</span></div>
                        </td>
                        <td class="tdBorder text-center">
                            <div class="py-2"><span
                                    class="d-block spandHeadO ">{{\App\CPU\Helpers::translate('phone')}}</span></div>
                        </td>
                        @if (\App\CPU\Helpers::store_module_permission_check('my_account.employees.enabled'))
                        <td class="tdBorder text-center">
                            <div class="py-2">
                                <span class="d-block spandHeadO">
                                    {{\App\CPU\Helpers::translate('Status')}}
                                </span>
                            </div>
                        </td>
                        @endif

                        <td class="tdBorder text-center">
                            <div class="py-2"><span
                                    class="d-block spandHeadO">{{\App\CPU\Helpers::translate('Action')}} </span></div>
                        </td>
                    </tr>
                    </thead>

                    <tbody>

                        @forelse($delegates as $key=>$ds)
                        <tr>
                            <td class="lg:hidden md:hidden sm:table-cell text-center"></td>
                            <td class="bodytr font-weight-bold text-center py-3" style="color: #673bb7">
                                <span class="marl">{{$key+1}}</span>
                            </td>
                            <td class="bodytr font-weight-bold text-center py-3" style="color: #673bb7">
                                <a href="{{route('delegates.edit',[$ds['id']])}}" class="marl">{{$ds['name']}}</a>
                            </td>
                            <td class="bodytr text-center py-3">
                                <a href="mailto:{{$ds['email']}}"><span>{{$ds['email']}}</span></a>
                            </td>
                            <td class="bodytr text-center py-3"><a href="tel:{{$ds['phone']}}"><span class="" dir="ltr">{{$ds['phone']}}</span></a></td>
                            @if (\App\CPU\Helpers::store_module_permission_check('my_account.employees.enabled'))
                            @if ($ds['id'] != "01")
                            @if (auth('delegatestore')->check() && $ds['id'] != auth('delegatestore')->user()->id || auth('customer')->check())
                            <td class="bodytr text-center py-3"><span class=""><label class="switcher mt-1 d-inline-block">
                                <input type="checkbox" class="status-employee switcher_input"
                                        id="{{$ds['id']}}" {{$ds->status == 1?'checked':''}}>
                                <span class="switcher_control"></span>
                            </label></span></td>
                            @endif
                            @endif
                            @endif


                            <td class="bodytr text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    @if (auth('delegatestore')->check() && $ds['id'] != auth('delegatestore')->user()->id || auth('customer')->check())
                                    @if ($ds['id'] != "01")
                                    @if (\App\CPU\Helpers::store_module_permission_check('my_account.employees.edit'))
                                    <a  class="btn btn-primary bg-transparent border-0"
                                        title="{{\App\CPU\Helpers::translate('Edit')}}"
                                        href="{{route('delegates.edit',[$ds['id']])}}">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22H15C20 22 22 20 22 15V13" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M16.04 3.01976L8.16 10.8998C7.86 11.1998 7.56 11.7898 7.5 12.2198L7.07 15.2298C6.91 16.3198 7.68 17.0798 8.77 16.9298L11.78 16.4998C12.2 16.4398 12.79 16.1398 13.1 15.8398L20.98 7.95976C22.34 6.59976 22.98 5.01976 20.98 3.01976C18.98 1.01976 17.4 1.65976 16.04 3.01976Z" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M14.91 4.1499C15.58 6.5399 17.45 8.4099 19.85 9.0899" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>

                                    </a>
                                    @endif

                                    @if (\App\CPU\Helpers::store_module_permission_check('my_account.employees.delete'))
                                    <a class="btn btn-danger bg-transparent border-0"
                                        title="{{\App\CPU\Helpers::translate('Delete')}}"
                                        href="javascript:"
                                        onclick="form_alert('delegates-{{$ds['id']}}',' {{\App\CPU\Helpers::translate('Do you Want to remove this Employee?')}}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M21.0736 5.23C19.4636 5.07 17.8536 4.95 16.2336 4.86V4.85L16.0136 3.55C15.8636 2.63 15.6436 1.25 13.3036 1.25H10.6836C8.35358 1.25 8.13357 2.57 7.97358 3.54L7.76358 4.82C6.83358 4.88 5.90358 4.94 4.97358 5.03L2.93358 5.23C2.51358 5.27 2.21358 5.64 2.25358 6.05C2.29358 6.46 2.65358 6.76 3.07358 6.72L5.11358 6.52C10.3536 6 15.6336 6.2 20.9336 6.73C20.9636 6.73 20.9836 6.73 21.0136 6.73C21.3936 6.73 21.7236 6.44 21.7636 6.05C21.7936 5.64 21.4936 5.27 21.0736 5.23Z" fill="#FF000F"/>
                                            <path d="M19.2317 8.14C18.9917 7.89 18.6617 7.75 18.3217 7.75H5.6817C5.3417 7.75 5.0017 7.89 4.7717 8.14C4.5417 8.39 4.4117 8.73 4.4317 9.08L5.0517 19.34C5.1617 20.86 5.3017 22.76 8.7917 22.76H15.2117C18.7017 22.76 18.8417 20.87 18.9517 19.34L19.5717 9.09C19.5917 8.73 19.4617 8.39 19.2317 8.14ZM13.6617 17.75H10.3317C9.9217 17.75 9.5817 17.41 9.5817 17C9.5817 16.59 9.9217 16.25 10.3317 16.25H13.6617C14.0717 16.25 14.4117 16.59 14.4117 17C14.4117 17.41 14.0717 17.75 13.6617 17.75ZM14.5017 13.75H9.5017C9.0917 13.75 8.7517 13.41 8.7517 13C8.7517 12.59 9.0917 12.25 9.5017 12.25H14.5017C14.9117 12.25 15.2517 12.59 15.2517 13C15.2517 13.41 14.9117 13.75 14.5017 13.75Z" fill="#FF000F"/>
                                          </svg>
                                    </a>

                                    <form action="{{route('delegates.delete',[$ds['id']])}}"
                                            method="post" id="delegates-{{$ds['id']}}">
                                        @csrf @method('delete')
                                    </form>
                                    @endif
                                    @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
        $(document).on('change', '.status-employee', function () {
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
                url: "{{route('delegates.status-update')}}",
                method: 'POST',
                data: {
                    id: id,
                    status: status
                },
                success: function (data) {
                    toastr.success('{{\App\CPU\Helpers::translate('Status updated successfully')}}');
                }
            });
        });
    </script>
@endpush
