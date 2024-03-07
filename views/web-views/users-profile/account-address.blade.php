@push('css_or_js')
    <link rel="stylesheet" media="screen" href="{{asset('public/assets/front-end')}}/vendor/nouislider/distribute/nouislider.min.css"/>
    <link rel="stylesheet" href="{{ asset('public/assets/front-end/css/bootstrap-select.min.css') }}" />
    {{--  <script src="{{ asset('public/assets/front-end/js/bootstrap-select.min.js') }}"></script>  --}}

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

            display: inline-block;
            margin-top: 5px !important;
            font-size: 13px !important;
            color: #030303;
        }

        .font-name {
            font-weight: 600;
            font-size: 15px;
            padding-bottom: 6px;
            color: #030303;
        }

        .modal-footer {
            border-top: none;
        }

        .cz-sidebar-body h3:hover + .divider-role {
            border-bottom: 3px solid {{$web_config['primary_color']}} !important;
            transition: .2s ease-in-out;
        }

        label {
            font-size: 15px;
            margin-bottom: 8px;
            color: #030303;

        }

        .nav-pills .nav-link.active {
            box-shadow: none;
            color: #ffffff !important;
        }

        .modal-header {
            border-bottom: none;
        }

        .nav-pills .nav-link {
            padding-top: .575rem;
            padding-bottom: .575rem;
            background-color: #ffffff;
            color: #050b16 !important;
            font-size: .9375rem;
            border: 1px solid #e4dfdf;
        }

        .nav-pills .nav-link :hover {
            padding-top: .575rem;
            padding-bottom: .575rem;
            background-color: #ffffff;
            color: #050b16 !important;
            font-size: .9375rem;
            border: 1px solid #e4dfdf;
        }

        .nav-pills .nav-link.active, .nav-pills .show > .nav-link {
            color: #fff;
            background-color: {{$web_config['primary_color']}};
        }

        .iconHad {
            color: {{$web_config['primary_color']}};
            padding: 4px;
        }

        .iconSp {
            margin-top: 0.70rem;
        }

        .fa-lg {
            padding: 4px;
        }

        .fa-trash {
            color: #FF4D4D;
        }

        .namHad {
            color: #030303;
            position: absolute;
            padding-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 13px;
            padding-top: 8px;
        }

        .donate-now {
            list-style-type: none;
            margin: 25px 0 0 0;
            padding: 0;
        }

        .donate-now li {
            float: left;
            margin: {{Session::get('direction') === "rtl" ? '0 0 0 5px' : '0 5px 0 0'}};
            width: 100px;
            height: 40px;
            position: relative;
            padding: 22px;
            text-align: center;
        }

        .donate-now label,
        .donate-now input {
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .donate-now input[type="radio"] {
            opacity: 0.01;
            z-index: 100;
        }

        .donate-now input[type="radio"]:checked + label,
        .Checked + label {
            background: {{$web_config['primary_color']}};
            color: white !important;
            border-radius: 7px;
        }

        .donate-now label {
            padding: 5px;
            border: 1px solid #CCC;
            cursor: pointer;
            z-index: 90;
        }

        .donate-now label:hover {
            background: #DDD;
        }

        #edit{
            cursor: pointer;
        }
        .pac-container { z-index: 100000 !important; }

        .filter-option{
            display: block;
            width: 100%;
            height: calc(1.5em + 1.25rem + 2px);
            padding: 0.625rem 1rem;
            font-size: .9375rem;
            font-weight: 400;
            line-height: 1.5;
            color: #4b566b;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #dae1e7;
            border-radius: 0.3125rem;
            box-shadow: 0 0 0 0 transparent;
            transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .btn-light + .dropdown-menu{
            transform: none !important;
            top: 41px !important;
        }

        @media (max-width: 600px) {
            .sidebar_heading h1 {
                text-align: center;
                color: aliceblue;
                padding-bottom: 17px;
                font-size: 19px;
            }
        }
        #location_map_canvas{
            height: 100%;
        }
        @media only screen and (max-width: 768px) {
            /* For mobile phones: */
            #location_map_canvas{
                height: 200px;
            }
        }
    </style>
@endpush

    <div class="modal fade rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-md-12"><h5 class="modal-title font-name ">{{\App\CPU\Helpers::translate('add_new_address')}}</h5></div>
                    </div>
                </div>
                <div class="modal-body">
                    <form action="{{route('address-store')}}" method="post">
                        @csrf
                        @php($store = auth('customer')->user()->store_informations)
                        <!-- Tab panes -->
                        <div class="form-row mb-1">
                            <div class="form-group col-md-6">
                                <label for="person_name">{{\App\CPU\Helpers::translate('address name')}}</label>
                                <input class="form-control" type="text" id="title"
                                    name="title"
                                    required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="person_name">{{\App\CPU\Helpers::translate('contact_person_name')}}</label>
                                <input class="form-control" type="text" id="person_name"
                                    value="{{ $store['company_name'] }}"
                                    name="name"
                                    required>
                            </div>


                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">{{ \App\CPU\Helpers::translate('The receiving person mobile number')}}
                                <span
                                style="color: red">*</span></label>
                                <div class="form-group  w-100 col-lg-12">
                                    <input tabindex="3" name="phone" class="form-control phoneInput text-left" dir="ltr" value="{{ $store['phone'] ?? '+966'}}" />
                                </div>
                            </div>
                            <div class="col-mh-6"></div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label
                                        for="exampleInputEmail1">{{ \App\CPU\Helpers::translate('Country')}}
                                        <span
                                            style="color: red">*</span></label>
                                    <select name="country" id="" class="form-control SumoSelect-custom" data-bs-live-search="true" required
                                    onchange="$('#area_id,.area_id').attr('disabled',1);$('#area_id_loading').show();$.get('{{route('get-shipping-areas')}}?code='+$(this).val()).then(d=>{$('#area_id,.area_id').html(d);$('#area_id,.area_id').removeAttr('disabled');$('#area_id_loading').hide();$('#area_id').SumoSelect().sumo.reload()})">
                                        <option></option>
                                        @foreach (\App\CPU\Helpers::getCountries() as $country)
                                            <option @if($store['country'] == $country['id']) selected @endif value="{{ $country->code }}" icon="{{ $country->photo }}">
                                                {{ \App\CPU\Helpers::getItemName('countries','name',$country->id) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label
                                        for="exampleInputEmail1">{{ \App\CPU\Helpers::translate('Governorate')}}
                                        <span style="color: red">*</span></label>
                                    <select name="area_id" id="area_id" class="form-control SumoSelect-custom" data-bs-live-search="true" required></select>
                                    <span class="text-warning" id="area_id_loading" style="display: none;">{{ Helpers::translate('Please wait') }}</span>
                                    <input type="hidden" id="area_id_hidden" >
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="zip_code">{{\App\CPU\Helpers::translate('zip_code')}}</label>
                                @if($zip_restrict_status)
                                    <select name="zip" class="form-control selectpicker" data-bs-live-search="true" id="" required>
                                        @foreach($delivery_zipcodes ?? [] as $zip)
                                            <option value="{{ $zip->zipcode }}" >{{ $zip->zipcode }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <input class="form-control" type="number" id="zip_code" name="zip" required>
                                @endif
                            </div>
                            <div class="col-md-6">

                            </div>

                            <div class="form-group col-lg-6">
                                <label
                                    for="exampleInputEmail1">{{ \App\CPU\Helpers::translate('Street - neighborhood')}}<span
                                        style="color: red">*</span></label>
                                <textarea class="form-control" id="address"
                                          type="text"
                                          name="address" required></textarea>
                            </div>

                        </div>

                        @if (1==2)
                        <div class="form-row mb-1">
                            <div class="form-group col-md-12">
                                <label for="own_address">{{\App\CPU\Helpers::translate('address')}}</label>
                                <textarea class="form-control" id="address"
                                    type="text"  name="address" required>{{$shippingAddress->address}}</textarea>
                            </div>
                            <div class="form-group col-md-12">
                                <input id="pac-input" class="controls rounded" style="height: 3em;width:fit-content;" title="{{\App\CPU\Helpers::translate('search_your_location_here')}}" type="text" placeholder="{{\App\CPU\Helpers::translate('search_here')}}"/>
                                <div style="height: 200px;" id="location_map_canvas"></div>
                            </div>
                        </div>
                        @endif
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{\App\CPU\Helpers::translate('close')}}</button>
                            <button type="submit" class="btn btn--primary text-light">{{\App\CPU\Helpers::translate('Add')}}</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <div class="row mt-6">
        <!-- Sidebar-->

    <!-- Content  -->
        <section class="col-lg-12 col-md-12">
            <div class="card box-shadow-sm">
                <div class="card-body bg-light">
                    <div class="row">
                        <div class="col-lg-12 col-md-12  d-flex justify-content-between overflow-hidden">
                            <div class="col-sm-4">
                                <h1 class="h3  mb-0 folot-left headerTitle">{{\App\CPU\Helpers::translate('ADDRESSES')}}</h1>
                            </div>
                            <div class="mt-2 col-sm-4" style="text-align: end">
                                <button type="submit" class="btn btn--primary" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" id="add_new_address">{{\App\CPU\Helpers::translate('add_new_address')}}
                                </button>
                            </div>
                        </div>
                        @foreach($shippingAddresses as $shippingAddress)
                            <section class="col-lg-6 col-md-6 mb-4 mt-5">
                                <div class="card" style="text-transform: capitalize;">

                                        <div class="card-header p-3 pb-0" style="padding: 5px;">

                                            <div class="row">
                                                <label for="a25" class="col-6">
                                                    {{\App\CPU\Helpers::translate('permanent')}}
                                                </label>
                                                <div class="col-6 text-end">
                                                    <div class="form-check form-switch p-0">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="addressAs" value="permanent"
                                                        {{ $shippingAddress->address_type == 'permanent' ? 'checked' : ''}}
                                                        />
                                                      </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-body mt-3" style="padding: {{Session::get('direction') === "rtl" ? '0 13px 15px 15px' : '0 15px 15px 13px'}};">

                                            <div class="d-flex justify-content-between" style="padding: 5px;">
                                                <div>
                                                    <span class="fw-bold">
                                                        {{$shippingAddress->title ?? $shippingAddress->address_type }}
                                                    </span>
                                                </div>

                                                <div class="d-flex justify-content-between">
                                                    <a class="bg-black ps-1 rounded wd-25 ht-25" title="Edit Address" id="edit" href="{{route('address-edit',$shippingAddress->id)}}">
                                                        <i class="ri-pencil-fill text-white fa-md"></i>
                                                    </a>

                                                    <a class="ps-1 pt-1 rounded wd-25 ht-25" title="Delete Address" href="{{ route('address-delete',['id'=>$shippingAddress->id])}}" onclick="return confirm('{{\App\CPU\Helpers::translate('Are you sure you want to Delete')}}?');" id="delete">
                                                        <i class="ri-delete-bin-5-fill text-danger fa-lg"></i>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="form-row mb-1">
                                                <label for="person_name" class="col-6">
                                                    <strong>
                                                        {{\App\CPU\Helpers::translate('contact_person_name')}}:
                                                    </strong>
                                                </label>
                                                <div class="col-6 text-end">
                                                    {{$shippingAddress->contact_person_name}}
                                                </div>
                                            </div>

                                            <div class="form-row mb-1">
                                                <label for="person_name" class="col-6">
                                                    <strong>
                                                        {{ \App\CPU\Helpers::translate('The receiving person mobile number')}}:
                                                    </strong>
                                                </label>
                                                <div class="col-6 text-end" dir="ltr">
                                                    {{$shippingAddress->phone}}
                                                </div>
                                            </div>

                                            <div class="form-row mb-1">
                                                <strong class="col-6">
                                                    {{ \App\CPU\Helpers::translate('Country')}}:
                                                </strong>
                                                <div class="col-6 text-end">
                                                    <select name="country" disabled id="" data-bs-live-search="true" required style="color: black;font-weight:bold;border: none;text-align-last: end;border: none;background-blend-mode: hue;width: 95px;float: left;text-align-last:end;height:32px;margin-top:-10px" class="p-0 form-control bg-white">
                                                        <option></option>
                                                        @foreach (\App\CPU\Helpers::getCountries() as $country)
                                                            <option @if($country->code == $shippingAddress->country) selected @endif value="{{ $country->code }}" icon="{{ $country->photo }}">
                                                                {{ \App\CPU\Helpers::getItemName('countries','name',$country->id) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>



                                            <div class="form-row mb-1">
                                                <strong class="col-6">
                                                    {{ \App\CPU\Helpers::translate('Governorate')}}:
                                                </strong>
                                                <div class="col-6 text-end">
                                                    <select disabled name="area_id" id="area_id{{$shippingAddress->id}}" data-bs-live-search="true" required style="color: black;font-weight:bold;border: none;text-align-last: end;border: none;background-blend-mode: hue;width: 95px;float: left;text-align-last:end;height:32px;margin-top:-10px" class="p-0 form-control bg-white"></select>
                                                    <span class="text-warning area_id" id="area_id_loading" style="display: none;">{{ Helpers::translate('Please wait') }}</span>
                                                    <input type="hidden" id="area_id_hidden" value="{{$shippingAddress->area_id ?? '0'}}">
                                                </div>
                                            </div>
                                            <script>
                                                $('#area_id{{$shippingAddress->id}}').attr('disabled',1);$('#area_id{{$shippingAddress->id}}_loading').show();$.get('{{route('get-shipping-areas')}}?code={{$shippingAddress->country}}').then(d=>{$('#area_id{{$shippingAddress->id}}').html(d);$('#area_id{{$shippingAddress->id}}_loading').hide();$('#area_id{{$shippingAddress->id}}').find('option[value={{$shippingAddress->area_id}}]').attr("selected","selected")})
                                            </script>


                                            <div class="form-row mb-1">
                                                <strong class="col-6">
                                                        {{\App\CPU\Helpers::translate('zip_code')}}:
                                                </strong>
                                                <div class="col-6 text-end">
                                                    {{$shippingAddress->zip}}
                                                </div>
                                            </div>

                                            <div class="form-row mb-1">
                                                <strong class="col-6">
                                                    {{ \App\CPU\Helpers::translate('Street - neighborhood')}}:
                                                </strong>
                                                <div class="col-6 text-end">
                                                    {{$shippingAddress->address}}
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                            </section>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>




    <script>
        $(document).ready(function (){
            $('.address_type_li').on('click', function (e) {
                // e.preventDefault();
                $('.address_type_li').find('.address_type').removeAttr('checked', false);
                $('.address_type_li').find('.component').removeClass('active_address_type');
                $(this).find('.address_type').attr('checked', true);
                $(this).find('.address_type').removeClass('add_type');
                $('#defaultValue').removeClass('add_type');
                $(this).find('.address_type').addClass('add_type');

                $(this).find('.component').addClass('active_address_type');
            });
        })

        $('#addressUpdate').on('click', function(e){
            e.preventDefault();
            let addressAs, address, name, zip, city, state, country, phone;

            addressAs = $('.add_type').val();

            address = $('#own_address').val();
            name = $('#person_name').val();
            zip = $('#zip_code').val();
            city = $('#city').val();
            state = $('#own_state').val();
            country = $('#own_country').val();
            phone = $('#own_phone').val();

            let id = $(this).attr('data-bs-id');

            if (addressAs != '' && address != '' && name != '' && zip != '' && city != '' && state != '' && country != '' && phone != '') {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{route('address-update')}}",
                    method: 'POST',
                    data: {
                        id : id,
                        addressAs: addressAs,
                        address: address,
                        name: name,
                        zip: zip,
                        city: city,
                        state: state,
                        country: country,
                        phone: phone
                    },
                    success: function () {
                        toastr.success('{{\App\CPU\Helpers::translate('Address Update Successfully')}}.');
                        location.reload();


                    }
                });
            }else{
                toastr.error('{{\App\CPU\Helpers::translate('All input field required')}}.');
            }

        });
    </script>
    <style>
        .modal-backdrop {
            z-index: 0 !important;
            display: none;
        }
    </style>
