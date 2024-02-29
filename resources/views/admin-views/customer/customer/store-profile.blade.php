<style>
    .switcher .switcher_control {
        background-color: #ccc; /* لون رمادي للحالة غير المفعلة */
    }

    .switcher .switcher_control.active {
        background-color: #34C759; /* لون أخضر للحالة المفعلة */
    }
</style>
    <div class="row bg-purple-50 p-4" style="border-radius: 10px">
        @if (!isset($new) && !isset($profile))
        <div class=" w-storeProfile col-lg-2 ref _store_info">
            <div class="form-group">
                <label>{{\App\CPU\Helpers::translate('Store Account number')}} : </label>
                <input tabindex="0" name="vendor_account_number" class="form-control" value="{{($store['vendor_account_number'] ?? '')}}" />
            </div>
        </div>
        @endif

        <div class=" w-storeProfile col-lg-2 ref _store_info">
            <div class="form-group">
                <label>{{\App\CPU\Helpers::translate('company_name')}} : </label>
                <input tabindex="1" name="company_name" class="form-control" value="{{($store['company_name'] ?? '')}}" />
            </div>
        </div>

        <div class="form-group  w-storeProfile col-lg-2  ref _owner_info">
            <label>{{\App\CPU\Helpers::translate('license_owners_name')}}: </label>
            <input tabindex="2"  name="name" class="form-control" value="{{ ($customer->is_store ?? null) ? $store['name'] ?? '' : $customer['name'] ?? ''}}" />
        </div>

        <div class="form-group  w-storeProfile col-lg-2 ref _owner_info">
            <label>{{\App\CPU\Helpers::translate('license owners phone')}}: </label>
            <input tabindex="3" name="phone" class="form-control phoneInput text-left" dir="ltr" value="{{$customer['phone'] ?? '+966'}}" />
        </div>

        <div class=" w-storeProfile col-lg-2 ref _store_info">
            <div class="form-group">
                <label>{{\App\CPU\Helpers::translate('Email')}} : </label>
                <input tabindex="4" readonly onfocus="$(this).removeAttr('readonly')" name="email" class="form-control" autocomplete="off" value="{{($customer['email'] ?? '')}}" />
            </div>
        </div>
        <div class=" w-storeProfile col-lg-2 ref _store_info">
            <div class="form-group">
                <label>{{\App\CPU\Helpers::translate('Password')}} : </label>
                <div class="password-toggle">
                    <input tabindex="5" readonly onfocus="$(this).removeAttr('readonly')" class="form-control" name="password" type="password" id="password2"
                           style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};"
                           required>
                    {{--  <label class="password-toggle-btn">
                        <input class="custom-control-input" type="checkbox"><i
                            class="czi-eye password-toggle-indicator"></i><span
                            class="sr-only">{{\App\CPU\Helpers::translate('Show password')}} </span>
                    </label>  --}}
                    <span class="fa fa-eye-slash toggle-password" style="position: absolute;left: 10%;top: 46%;cursor: pointer;"></span>
                </div>
            </div>
        </div>

        <div class=" w-storeProfile col-lg-3 ref _comm_info">
            <div class="form-group">
                <label>{{\App\CPU\Helpers::translate('delegates_name')}} : </label>
                <input tabindex="7" name="delegate_name" class="form-control" value="{{($store['delegate_name'] ?? '')}}" />
            </div>
        </div>
        <div class=" w-storeProfile col-lg-3 ref _comm_info">
            <div class="form-group">
                <label>{{\App\CPU\Helpers::translate('delegates_phone')}} : </label>
                <input tabindex="8" name="delegate_phone" class="form-control phoneInput" dir="ltr" value="{{($store['delegate_phone'] ?? '+966')}}" />
            </div>
        </div>

        <div class=" w-storeProfile col-lg-2 ref _files_info">
            <div class="form-group">
                <label>{{\App\CPU\Helpers::translate('commercial_registration_no')}} : </label>
                <input tabindex="9" name="commercial_registration_no" type="text" pattern="\d*" t="number" class="form-control" value="{{($store['commercial_registration_no'] ?? '')}}" />
            </div>
        </div>

        <div class="@if (!isset($new))  w-storeProfile col-lg-2 @else  w-storeProfile col-lg-4 @endif ref _store_info">
            <div class="form-group">
                <label>{{\App\CPU\Helpers::translate('tax number')}} : </label>
                <input tabindex="10" name="tax_no" type="text" pattern="\d*" t="number" class="form-control" value="{{($store['tax_no'] ?? '')}}" />
            </div>
        </div>



        @if (!isset($new))
        @if(\App\Model\BusinessSetting::where('type','pricing_levels')->first()->value ?? '')
        <div class=" w-storeProfile col-lg-2 ref _store_info">
            <div class="form-group">
                <label>{{\App\CPU\Helpers::translate('pricing level')}} : </label>
                <div class="form-control p-0">
                    <select tabindex="11" class="text-dark SumoSelect-custom testselect2-custom" name="pricing_level">
                        <option value="">{{\App\CPU\Helpers::translate('Choose')}}</option>
                        @foreach (\App\CPU\Helpers::getPricingLevels() as $pl)
                        <option @if(($store['pricing_level'] ?? "") !== "" && ($store['pricing_level'] ?? "") !== "0" && in_array($pl->id,explode(',',$store['pricing_level'] ?? ''))) selected @endif value="{{$pl->id}}">
                            {{ \App\CPU\Helpers::getTranslation('App\Model\pricing_levels',$pl['id'],'name') }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        @endif
        @endif

        <div class=" w-storeProfile col-lg-3 ref _location_info">
            <div class="form-group">
                <label>{{\App\CPU\Helpers::translate('governorate')}} : </label>
                <div class="form-control p-0">
                    <select name="governorate" class="SumoSelect-custom seller-governorate">
                        <option></option>
                        @foreach (\App\CPU\Helpers::getGovernorates() as $pr)
                            <option @if(($store['governorate'] ?? '') == $pr['id']) selected @endif value="{{$pr['id']}}">{{ \App\CPU\Helpers::getItemName('provinces','name',$pr['id']) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class=" w-storeProfile col-lg-3 ref _store_info">
            <div class="form-group">
                <label>{{\App\CPU\Helpers::translate('Store url')}} : </label>
                <input tabindex="18" name="site_url" class="form-control" value="{{($store['site_url'] ?? '')}}" />
            </div>
        </div>

        <div class=" w-storeProfile col-lg-3 ref _store_info">
            <div class="form-group">
                <label>{{\App\CPU\Helpers::translate('Store account manager')}} : </label>
                <div class="form-control p-0">
                    <select tabindex="11" class="text-dark SumoSelect-custom manag" name="manager_id">
                        <option value="">{{\App\CPU\Helpers::translate('Choose')}}</option>
                        @isset($customer)
                        @foreach ($employee as $e)
                            <option value="{{$e->id}}" {{ ($customer->manager_id == $e->id) ? 'selected' : '' }}>
                                {{ $e->name }}
                            </option>
                        @endforeach
                        @endisset
                    </select>
                </div>
            </div>
        </div>

        <div class="inputgroup w-storeProfile col-lg-3 ref _store_info">
            <div class="form-group">
                <label>{{\App\CPU\Helpers::translate('Store activity')}} : </label>
                <div class="form-control p-0">
                    <select tabindex="11" class="text-dark SumoSelect-custom s_activity" name="activity">
                        <option value="">{{\App\CPU\Helpers::translate('Choose')}}</option>
                        @isset($customer)
                        @foreach ($sentences ?? [] as $index => $sentence)
                        <option value="{{ $sentence }}" {{ ($customer->activity == $sentence) ? 'selected' : ''}}>{{ $sentence }}</option>
                        @endforeach
                        @endisset
                    </select>
                </div>
            </div>
        </div>

        <div class="col-lg-4  ref _location_info">
            <div class="p-0">
                <div class="mb-4">
                    <p class="locations-card-body w-full pos-relative wd-150px">
                        <div id="location_map_canvas"></div>
                    </p>
                </div>
            </div>
        </div>
        <div class="row  w-storeProfile col-lg-3 ref _location_info">
            <div class=" w-storeProfile col-lg-12">
                <div class="form-group">
                    <label>{{\App\CPU\Helpers::translate('Coordinates')}} - {{ Helpers::translate('longitude') }} : </label>
                    <input tabindex="13" name="lon" id="longitude"  aria-describedby="basic-addon1" value="{{($store['lon'] ?? '')}}" class="form-control" placeholder="{{\App\CPU\Helpers::translate('Coordinates')}} - lon" type="text" required readonly>
                </div>
            </div>
            <div class=" w-storeProfile col-lg-12">
                <div class="form-group">
                    <label>{{\App\CPU\Helpers::translate('Coordinates')}} - {{ Helpers::translate('latitude') }} : </label>
                    <input tabindex="12" name="lat" id="latitude"  aria-describedby="basic-addon1" value="{{($store['lat'] ?? '')}}" class="form-control" placeholder="{{\App\CPU\Helpers::translate('Coordinates')}} - lat" type="text" required readonly>
                </div>
            </div>
            <div class=" w-storeProfile col-lg-12">
                <div class="form-group">
                    <label>{{\App\CPU\Helpers::translate('address')}} : </label>
                    <input tabindex="14" name="address" class="form-control" value="{{($store['address'] ?? '')}}" />
                </div>
            </div>
        </div>

        <div class="inputgroup w-storeProfile col-lg-2 ref _store_info">
            <div class="form-group" style="position: relative;width: 185px">
                @include('admin-views.business-settings.imgUpload'
                ,[
                    'caption' => Helpers::translate('Store Image'),
                    'imgId' => 'viewer1',
                    'inputId' => 'customFileUpload1',
                    'inputName' => 'image',
                    'src' => asset('storage/app/public/user/'.($store['image'] ?? ''))
                ])
            </div>
        </div>

        <div class=" w-storeProfile col-lg-2 ref _files_info">
            <div class="form-group">
                <center>
                    <img class="upload-img-view" id="viewer2"
                    @if($store['commercial_registration_img'] ?? '')
                    role="button"
                    onclick="window.open('{{asset('storage/app/public/user')}}/{{($store['commercial_registration_img'] ?? '')}}')"
                    @endif
                    src="{{asset('storage/app/public/user')}}/{{($store['commercial_registration_img'] ?? '')}}" alt="banner image"
                    onerror="this.src='{{($store['commercial_registration_img'] ?? '') ? asset('public/assets/front-end/img/download.png') : asset('public/assets/front-end/img/image-place-holder.png')}}'"
                    />
                </center>
            </div>
            <div class="form-group">
                <label>{{\App\CPU\Helpers::translate('commercials_registrations_image')}} : </label>
                <div class="custom-file text-left">
                    <input tabindex="16" type="file" name="commercial_registration_img" id="customFileUpload2" class="custom-file-input"
                    accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff, .doc, .docx, .pdf|image/*">
                    <label class="custom-file-label" for="customFileUpload">{{\App\CPU\Helpers::translate('Upload image')}}</label>
                </div>
            </div>
        </div>



        <div class=" w-storeProfile col-lg-2 ref _files_info">
            <div class="form-group">
                <center>
                    <img class="upload-img-view" id="viewer3"
                    @if($store['tax_certificate_img'] ?? '')
                    role="button"
                    onclick="window.open('{{asset('storage/app/public/user')}}/{{($store['tax_certificate_img'] ?? '')}}')"
                    @endif
                    src="{{asset('storage/app/public/user')}}/{{($store['tax_certificate_img'] ?? '')}}" alt="banner image"
                    onerror="this.src='{{($store['tax_certificate_img'] ?? '') ? asset('public/assets/front-end/img/download.png') : asset('public/assets/front-end/img/image-place-holder.png')}}'"
                    />
                </center>
            </div>
            <div class="form-group">
                <label>{{\App\CPU\Helpers::translate('shop_tax_certificates_image')}} : </label>
                <div class="custom-file text-left">
                    <input tabindex="17" type="file" name="tax_certificate_img" id="customFileUpload3" class="custom-file-input"
                    accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff, .doc, .docx, .pdf|image/*">
                    <label class="custom-file-label" for="tax_certificate_img">{{\App\CPU\Helpers::translate('Upload image')}}</label>
                </div>
            </div>
        </div>

        <div class="col-lg-12 ref _employees">
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
                            <td class="tdBorder text-center">
                                <div class="py-2">
                                    <span class="d-block spandHeadO">
                                        {{\App\CPU\Helpers::translate('Status')}}
                                    </span>
                                </div>
                            </td>

                            <td class="tdBorder text-center">
                                <div class="py-2"><span
                                        class="d-block spandHeadO">{{\App\CPU\Helpers::translate('Action')}} </span></div>
                            </td>
                        </tr>
                        </thead>

                        <tbody>
                            @php($delegates = \App\Model\DelegatedStore::where('store_id',$customer->id ?? null)->get())
                            @forelse($delegates as $key=>$ds)
                            <tr>
                                <td class="lg:hidden md:hidden sm:table-cell text-center"></td>
                                <td class="bodytr font-weight-bold text-center py-3" style="color: #673bb7">
                                    <span class="marl">{{$key+1}}</span>
                                </td>
                                <td class="bodytr font-weight-bold text-center py-3" style="color: #673bb7">
                                    <a href="#">{{$ds['name']}}</a>
                                </td>
                                <td class="bodytr text-center py-3">
                                    <a href="mailto:{{$ds['email']}}"><span>{{$ds['email']}}</span></a>
                                </td>
                                <td class="bodytr text-center py-3"><a href="tel:{{$ds['phone']}}"><span class="" dir="ltr">{{$ds['phone']}}</span></a></td>
                                <td class="bodytr text-center py-3">
                                    <span class="">
                                        <label class="switcher mt-1 d-inline-block">
                                            <input type="checkbox" class="status-employee switcher_input"
                                                   id="{{$ds['id']}}" {{$ds->status == 1?'checked':''}}>
                                            <span class="switcher_control swit {{$ds->status == 1?'active':''}}"></span>
                                        </label>
                                    </span>
                                </td>



                                <td class="bodytr text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a  class="btn btn-primary bg-transparent border-0"
                                            title="{{\App\CPU\Helpers::translate('view')}}" target="_blank"
                                            href="{{route('admin.stores.delegate-loginAs',[$ds['id']])}}">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M15.5799 11.9999C15.5799 13.9799 13.9799 15.5799 11.9999 15.5799C10.0199 15.5799 8.41992 13.9799 8.41992 11.9999C8.41992 10.0199 10.0199 8.41992 11.9999 8.41992C13.9799 8.41992 15.5799 10.0199 15.5799 11.9999Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M11.9998 20.2702C15.5298 20.2702 18.8198 18.1902 21.1098 14.5902C22.0098 13.1802 22.0098 10.8102 21.1098 9.40021C18.8198 5.80021 15.5298 3.72021 11.9998 3.72021C8.46984 3.72021 5.17984 5.80021 2.88984 9.40021C1.98984 10.8102 1.98984 13.1802 2.88984 14.5902C5.17984 18.1902 8.46984 20.2702 11.9998 20.2702Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>

                                        </a>
                                        <a class="btn btn-danger bg-transparent border-0"
                                            title="{{\App\CPU\Helpers::translate('Delete')}}"
                                            href="javascript:"
                                            onclick="form_alert('delegates-{{$ds['id']}}',' {{\App\CPU\Helpers::translate('Do you Want to remove this Employee?')}}')">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M21 5.98047C17.67 5.65047 14.32 5.48047 10.98 5.48047C9 5.48047 7.02 5.58047 5.04 5.78047L3 5.98047" stroke="#FF000F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M8.5 4.97L8.72 3.66C8.88 2.71 9 2 10.69 2H13.31C15 2 15.13 2.75 15.28 3.67L15.5 4.97" stroke="#FF000F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M18.8499 9.14062L18.1999 19.2106C18.0899 20.7806 17.9999 22.0006 15.2099 22.0006H8.7899C5.9999 22.0006 5.9099 20.7806 5.7999 19.2106L5.1499 9.14062" stroke="#FF000F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M10.3301 16.5H13.6601" stroke="#FF000F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M9.5 12.5H14.5" stroke="#FF000F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </a>

                                        <form action="{{route('delegates.delete',[$ds['id']])}}"
                                                method="post" id="delegates-{{$ds['id']}}">
                                            @csrf @method('delete')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@push('script')
    <script>
        // jQuery script to toggle the password visibility
        $(document).ready(function() {
            $('.toggle-password').click(function() {
                // Check the input type of the password field
                let input = $('#password2');
                let icon = $(this);
                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                } else {
                    input.attr('type', 'password');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                }
            });
        });
    </script>
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
        $(document).ready(function(){
            $('.status-employee').change(function() {
                if(this.checked) {
                    $(this).next('.switcher_control').addClass('active');
                } else {
                    $(this).next('.switcher_control').removeClass('active');
                }
            });
        });

        $("#customFileUpload1").change(function () {
            read_image(this, 'viewer1');
        });

        function read_image(input, id) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#' + id).attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

    </script>

@endpush
