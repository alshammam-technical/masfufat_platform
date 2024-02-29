@extends('layouts.back-end.app')
{{--@section('title','Customer')--}}
@section('title', \App\CPU\Helpers::translate('customer_settings'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')

    <div class="content container-fluid" >

        <!-- Page Title -->
        <div class="row" style="margin-bottom: 20px">
            <div class="col-lg-12">
                <div style="display: flex; align-items: center; width: 100%;">
                    <nav aria-label="breadcrumb" style="flex-grow: 1;width: 100%;">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\Helpers::translate('Dashboard')}}</a>
                            </li>
                            <li class="breadcrumb-item text-lg" aria-current="page">{{\App\CPU\Helpers::translate('shops settings')}}</li>
                        </ol>
                    </nav>
                    <button id="help-center-button" class=" my-2 btn-icon-text m-2 btnn" style="border-radius: 10px;" target="_blank">
                        <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                        width="16.000000pt" height="16.000000pt" viewBox="0 0 48.000000 48.000000"
                        preserveAspectRatio="xMidYMid meet">
                        <g transform="translate(0.000000,48.000000) scale(0.100000,-0.100000)"
                        fill="#000000" stroke="none">
                        <path d="M20 460 c-15 -15 -20 -33 -20 -70 l0 -50 180 0 180 0 0 50 c0 84 -13
                        90 -180 90 -127 0 -142 -2 -160 -20z m75 -50 c0 -18 -6 -26 -23 -28 -13 -2
                        -25 3 -28 12 -10 26 4 48 28 44 17 -2 23 -10 23 -28z m100 0 c0 -18 -6 -26
                        -23 -28 -24 -4 -38 18 -28 44 3 9 15 14 28 12 17 -2 23 -10 23 -28z m100 0 c0
                        -18 -6 -26 -23 -28 -24 -4 -38 18 -28 44 3 9 15 14 28 12 17 -2 23 -10 23 -28z"/>
                        <path d="M0 240 l0 -60 93 0 92 0 20 37 c11 21 37 47 60 60 l40 23 -152 0
                        -153 0 0 -60z"/>
                        <path d="M291 242 c-38 -20 -71 -73 -71 -112 0 -62 68 -130 130 -130 62 0 130
                        68 130 130 0 62 -68 130 -130 130 -14 0 -41 -8 -59 -18z m93 -38 c18 -18 21
                        -60 5 -69 -5 -4 -14 -18 -20 -32 -5 -13 -15 -23 -22 -20 -16 6 -11 46 10 69
                        13 15 14 21 4 31 -9 9 -16 7 -29 -11 -18 -23 -32 -21 -32 4 0 19 29 44 50 44
                        10 0 26 -7 34 -16z m-19 -143 c7 -12 -12 -24 -25 -16 -11 7 -4 25 10 25 5 0
                        11 -4 15 -9z"/>
                        <path d="M0 90 c0 -78 18 -90 134 -90 l95 0 -24 43 c-14 23 -25 54 -25 70 l0
                        27 -90 0 -90 0 0 -50z"/>
                        </g>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- End Page Title -->

        <!-- Inlile Menu -->

    <!-- End Inlile Menu -->
        <form action="{{ route('admin.customer.customer-settings-update') }}" method="post"
              enctype="multipart/form-data" id="update-settings">
            @csrf
            <div class="row gy-2 pb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="border-bottom py-3 px-4">
                            <div class="d-flex justify-content-between align-items-center gap-10">
                                <h5 class="mb-0 text-capitalize d-flex align-items-center gap-2">
                                    <i class="tio-wallet"></i>
                                    {{\App\CPU\Helpers::translate('customer_wallet_settings')}} :
                                </h5>

                                <label class="switcher" for="customer_wallet">
                                    <input type="checkbox" class="switcher_input"
                                           onclick="section_visibility('customer_wallet')" name="customer_wallet"
                                           id="customer_wallet" value="1"
                                           data-section="wallet-section" {{isset($data['wallet_status'])&&$data['wallet_status']==1?'checked':''}}>
                                    <span class="switcher_control"></span>
                                </label>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center gap-10 form-control mt-4" id="customer_wallet_section">
                                <span class="title-color">{{\App\CPU\Helpers::translate('refund_to_wallet')}} :</span>

                                <label class="switcher" for="refund_to_wallet">
                                    <input type="checkbox" class="switcher_input" name="refund_to_wallet"
                                           id="refund_to_wallet"
                                           value="1" {{isset($data['wallet_add_refund'])&&$data['wallet_add_refund']==1?'checked':''}}>
                                    <span class="switcher_control"></span>
                                </label>
                            </div>

                            <div class="d-flex justify-content-end mt-3">
                                <button class="btn bg-primaryColor btn-primary px-4 bg-primaryColor">{{\App\CPU\Helpers::translate('Save')}}</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="border-bottom py-3 px-4">
                            <div class="d-flex justify-content-between align-items-center gap-10">
                                <h5 class="mb-0 text-capitalize d-flex align-items-center gap-2">
                                    <i class="tio-award"></i>
                                    {{\App\CPU\Helpers::translate('enable loyalty system (loyalty_points)')}}:
                                </h5>
                                <label class="switcher" for="customer_loyalty_point">
                                    <input type="checkbox" class="switcher_input"
                                           onclick="section_visibility('customer_loyalty_point')"
                                           name="customer_loyalty_point" id="customer_loyalty_point"
                                           data-section="loyalty-point-section"
                                           value="1" {{isset($data['loyalty_point_status'])&&$data['loyalty_point_status']==1?'checked':''}}>
                                    <span class="switcher_control"></span>
                                </label>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="loyalty-point-section" id="customer_loyalty_point_section">
                                <div class="form-group">
                                    <label class="title-color d-flex"
                                           for="loyalty_point_exchange_rate">1 {{\App\CPU\Helpers::currency_code()}}
                                        = {{\App\CPU\Helpers::translate('how_much_point')}}</label>
                                    <input type="text" pattern="\d*" t="number" class="form-control" name="loyalty_point_exchange_rate"
                                           step="1" value="{{$data['loyalty_point_exchange_rate']??'0'}}">
                                </div>
                                <div class="form-group">
                                    <label class="title-color d-flex"
                                           for="intem_purchase_point">{{\App\CPU\Helpers::translate('percentage_of_loyalty_point_on_order_amount')}}</label>
                                    <input type="text" pattern="\d*" t="number" class="form-control" name="item_purchase_point" step=".01"
                                           value="{{$data['loyalty_point_item_purchase_point']??'0'}}">
                                </div>
                                <div class="form-group">
                                    <label class="title-color d-flex"
                                           for="intem_purchase_point">{{\App\CPU\Helpers::translate('minimum_point_to_transfer')}}</label>
                                    <input type="text" pattern="\d*" t="number" class="form-control" name="minimun_transfer_point" min="0"
                                           step="1" value="{{$data['loyalty_point_minimum_point']??'0'}}">
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" id="submit"
                                        class="btn px-4 bg-primaryColor">{{\App\CPU\Helpers::translate('save')}}</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="border-bottom py-3 px-4">
                            <div class="d-flex justify-content-between align-items-center gap-10">
                                <h5 class="mb-0 text-capitalize d-flex align-items-center gap-2">
                                    <i class="tio-truck"></i>
                                    {{\App\CPU\Helpers::translate('enable order tracking')}}:
                                </h5>
                                <label class="switcher" for="order_tracking">
                                    <input type="checkbox" class="switcher_input"
                                           name="order_tracking" id="order_tracking"
                                           value="1" {{isset($data['order_tracking_status'])&&$data['order_tracking_status']==1?'checked':''}}>
                                    <span class="switcher_control"></span>
                                </label>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-end">
                                <button type="submit" id="submit"
                                        class="btn px-4 bg-primaryColor">{{\App\CPU\Helpers::translate('save')}}</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="border-bottom py-3 px-4">
                            <div class="d-flex justify-content-between align-items-center gap-10">
                                <h5 class="mb-0 text-capitalize d-flex align-items-center gap-2">
                                    <i class="tio-sms"></i>
                                    {{\App\CPU\Helpers::translate('enable chat_with_seller')}}:
                                </h5>
                                <label class="switcher" for="chat_with_seller">
                                    <input type="checkbox" class="switcher_input"
                                           name="chat_with_seller" id="chat_with_seller"
                                           value="1" {{isset($data['chat_with_seller_status'])&&$data['chat_with_seller_status']==1?'checked':''}}>
                                    <span class="switcher_control"></span>
                                </label>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-end">
                                <button type="submit" id="submit"
                                        class="btn px-4 bg-primaryColor">{{\App\CPU\Helpers::translate('save')}}</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="border-bottom py-3 px-4">
                            <div class="d-flex justify-content-between align-items-center gap-10">
                                <h5 class="mb-0 text-capitalize d-flex align-items-center gap-2">
                                    <i class="tio-sms"></i>
                                    {{\App\CPU\Helpers::translate('enable chat_with_delivery')}}:
                                </h5>
                                <label class="switcher" for="chat_with_delivery">
                                    <input type="checkbox" class="switcher_input"
                                           name="chat_with_delivery" id="chat_with_delivery"
                                           value="1" {{isset($data['chat_with_delivery_status'])&&$data['chat_with_delivery_status']==1?'checked':''}}>
                                    <span class="switcher_control"></span>
                                </label>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-end">
                                <button type="submit" id="submit"
                                        class="btn px-4 bg-primaryColor">{{\App\CPU\Helpers::translate('save')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="border-bottom py-3 px-4">
                            <div class="d-flex justify-content-between align-items-center gap-10">
                                <h5 class="mb-0 text-capitalize d-flex align-items-center gap-2">
                                    <i class="tio-ticket"></i>
                                    {{\App\CPU\Helpers::translate('enable close_ticket')}}:
                                </h5>
                                <label class="switcher" for="close_ticket">
                                    <input type="checkbox" class="switcher_input"
                                           name="close_ticket" id="close_ticket"
                                           value="1" {{isset($data['enable_close_ticket'])&&$data['enable_close_ticket']==1?'checked':''}}>
                                    <span class="switcher_control"></span>
                                </label>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-end">
                                <button type="submit" id="submit"
                                        class="btn px-4 bg-primaryColor">{{\App\CPU\Helpers::translate('save')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="border-bottom py-3 px-4">
                            <div class="d-flex justify-content-between align-items-center gap-10">
                                <h5 class="mb-0 text-capitalize d-flex align-items-center gap-2">
                                    <i class="tio-delete"></i>
                                    {{\App\CPU\Helpers::translate('enable delete_ticket')}}:
                                </h5>
                                <label class="switcher" for="delete_ticket">
                                    <input type="checkbox" class="switcher_input"
                                           name="delete_ticket" id="delete_ticket"
                                           value="1" {{isset($data['enable_delete_ticket'])&&$data['enable_delete_ticket']==1?'checked':''}}>
                                    <span class="switcher_control"></span>
                                </label>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-end">
                                <button type="submit" id="submit"
                                        class="btn px-4 bg-primaryColor">{{\App\CPU\Helpers::translate('save')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="row gy-2 pb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="border-bottom py-3 px-4">
                        <div class="d-flex justify-content-between align-items-center gap-10">
                            <h5 class="mb-0 text-capitalize d-flex align-items-center gap-2">
                                <i class="tio-sms"></i>
                                {{\App\CPU\Helpers::translate('Names of the stores activities')}}:
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="loyalty-point-section" id="customer_loyalty_point_section">
                            <div class="form-group">
                                <label class="title-color d-flex"
                                       for="intem_purchase_point">{{\App\CPU\Helpers::translate('Names of activities')}}</label>
                                <select id="sentences" class="form-control ">
                                    @foreach ($sentences as $index => $sentence)
                                        <option value="{{ $sentence }}">{{ $sentence }}</option>
                                    @endforeach
                                </select>
                                <button id="editButton" class="btn btn-primary mt-3 ml-4">{{ \App\CPU\Helpers::translate('Edit') }}</button>
                                <button id="deleteButton" class="btn btn-danger mt-3">{{ \App\CPU\Helpers::translate('Delete') }}</button>
                                <input type="text" id="editSentence" class="form-control mt-3" name="new_sentence" style="display: none;">
                                <button id="saveEdit" class="btn bg-primaryColor btn-primary px-4 bg-primaryColor mt-3" style="display: none;">{{ \App\CPU\Helpers::translate('Save') }}</button>
                            </div>
                            <div class="form-group">
                                <form id="wordsForm">
                                    @csrf
                                    <label class="title-color d-flex"
                                    for="intem_purchase_point">{{\App\CPU\Helpers::translate('Add activity names')}}</label>
                                    <textarea class="form-control" name="sentence" rows="4" cols="50"></textarea>
                                    <button type="submit" class="btn bg-primaryColor btn-primary px-4 bg-primaryColor mt-3">{{\App\CPU\Helpers::translate('save')}}</button>
                                </form>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

@endsection
@push('script')
<script>
    $(document).ready(function() {
        var currentSentenceIndex = null;

        $('#editButton').click(function() {
            currentSentenceIndex = $('#sentences').find('option:selected').index();
            var currentSentence = $('#sentences').val();

            $('#editSentence').val(currentSentence).show().focus();
            $('#saveEdit').show();

            $('#sentences').hide();
            $('#editButton').hide();
            $('#deleteButton').hide();
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // حفظ التغييرات بعد التعديل عند الضغط على زر حفظ
        $('#saveEdit').click(function() {
            var updatedSentence = $('#editSentence').val().trim();
            if (updatedSentence === '') {
                alert('لا يمكن أن تكون الجملة فارغة.');
                return;
            }
            $.ajax({
                url: '{{ route('admin.customer.customer-settings-edit-word-activity') }}',
                method: 'POST',
                data: {
                    index: currentSentenceIndex,
                    new_sentence: updatedSentence,
                },
                success: function(response) {
                    $('#sentences option').eq(currentSentenceIndex).text(updatedSentence).val(updatedSentence);
                    $('#editSentence').hide();
                    $('#saveEdit').hide();
                    $('#sentences').show();
                    $('#editButton').show();
                    $('#deleteButton').show();
                    toastr.success('{{\App\CPU\Helpers::translate('Activity name updated successfully.')}}');
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });

        $('#deleteButton').click(function() {
            currentSentenceIndex = $('#sentences').find('option:selected').index();
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "لا يمكنك التراجع عن هذا الحذف!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'نعم، احذفه!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '{{ route('admin.customer.customer-settings-delete-word-activity') }}',
                        method: 'POST',
                        data: {
                            index: currentSentenceIndex,
                        },
                        success: function (response) {
                            $('#sentences option').eq(currentSentenceIndex).remove();
                            toastr.success('{{\App\CPU\Helpers::translate('Activity name deleted successfully.')}}');
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                }
            })
        });

        $('#wordsForm').on('submit', function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{ route('admin.customer.customer-settings-save-word-activity') }}",
                data: $(this).serialize(),
                success: function(response) {
                    toastr.success('{{\App\CPU\Helpers::translate('Activity name added successfully.')}}');
                    location.reload();
                },
                error: function(error) {
                    toastr.success('{{\App\CPU\Helpers::translate('error')}}');
                }
            });
        });
    });
    </script>
@endpush
@push('script_2')
<script>

    <script>
        $(document).on('ready', function () {
            @if (isset($data['wallet_status'])&&$data['wallet_status']!=1)
            $('#customer_wallet_section').attr('style', 'display: none !important');
            @endif

            @if (isset($data['loyalty_point_status'])&&$data['loyalty_point_status']!=1)
            $('.loyalty-point-section').attr('style', 'display: none !important');
            @endif
        });
    </script>

    <script>
        function section_visibility(id) {
            if ($('#' + id).is(':checked')) {
                $('#' + id + '_section').attr('style', 'display: block');
            } else {
                $('#' + id + '_section').attr('style', 'display: none !important');
            }
        }
    </script>

@endpush
