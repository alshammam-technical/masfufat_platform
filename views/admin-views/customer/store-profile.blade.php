

    @isset($customer)
    @if(!isset($new) && !isset($profile))
    @if($customer['is_active'] == 2)
    <div class="flex-start">
        <div><h4>{{\App\CPU\Helpers::translate('Status')}} : </h4></div>
        <div class="mx-1">
            <h4>{!! ($customer['is_active'] ?? '')=='1'?'<label class="badge badge-success">'. Helpers::translate('Active_') .'</label>':'<label class="badge badge-danger">'. Helpers::translate('Rejected') .'</label>' !!}</h4>
        </div>
    </div>
    @else
    <div class="flex-start">
        <div><h4>{{\App\CPU\Helpers::translate('Status')}} : </h4></div>
        <div class="mx-1">
            <h4>{!! ($customer['is_active'] ?? '')=='1'?'<label class="badge badge-success">'. Helpers::translate('Active_') .'</label>':'<label class="badge badge-danger">'. Helpers::translate('In-Active') .'</label>' !!}</h4>
        </div>
    </div>
    @endif
    @endif
    @endisset




    <div class="row">
        @if (!isset($new) && !isset($profile))
        <div class=" w-storeProfile col-lg-2">
            <div class="form-group">
                <label>{{\App\CPU\Helpers::translate('Store Account number')}} : </label>
                <input tabindex="0" name="vendor_account_number" class="form-control" value="{{($store['vendor_account_number'] ?? '')}}" />
            </div>
        </div>
        @endif

        <div class=" w-storeProfile col-lg-2">
            <div class="form-group">
                <label>{{\App\CPU\Helpers::translate('company_name')}} : </label>
                <input tabindex="1" name="company_name" class="form-control" value="{{($store['company_name'] ?? '')}}" />
            </div>
        </div>

        <div class="form-group  w-storeProfile col-lg-2">
            <label>{{\App\CPU\Helpers::translate('license_owners_name')}}: </label>
            <input tabindex="2"  name="name" class="form-control" value="{{ ($customer->is_store ?? null) ? $store['name'] ?? '' : $customer['name'] ?? ''}}" />
        </div>

        <div class="form-group  w-storeProfile col-lg-2">
            <label>{{\App\CPU\Helpers::translate('license owners phone')}}: </label>
            <input tabindex="3" name="phone" class="form-control phoneInput text-left" dir="ltr" value="{{$customer['phone'] ?? '+966'}}" />
        </div>

        <div class=" w-storeProfile col-lg-2">
            <div class="form-group">
                <label>{{\App\CPU\Helpers::translate('Email')}} : </label>
                <input tabindex="4" readonly onfocus="$(this).removeAttr('readonly')" name="email" class="form-control" autocomplete="off" value="{{($customer['email'] ?? '')}}" />
            </div>
        </div>
        <div class=" w-storeProfile col-lg-2">
            <div class="form-group">
                <label>{{\App\CPU\Helpers::translate('Password')}} : </label>
                <div class="password-toggle">
                    <input tabindex="5" readonly onfocus="$(this).removeAttr('readonly')" class="form-control" name="password" type="password" id="si-password"
                           style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                           required>
                    <label class="password-toggle-btn">
                        <input class="custom-control-input" type="checkbox"><i
                            class="czi-eye password-toggle-indicator"></i><span
                            class="sr-only">{{\App\CPU\Helpers::translate('Show password')}} </span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class=" w-storeProfile col-lg-3">
            <div class="form-group">
                <label>{{\App\CPU\Helpers::translate('delegates_name')}} : </label>
                <input tabindex="7" name="delegate_name" class="form-control" value="{{($store['delegate_name'] ?? '')}}" />
            </div>
        </div>
        <div class=" w-storeProfile col-lg-3">
            <div class="form-group">
                <label>{{\App\CPU\Helpers::translate('delegates_phone')}} : </label>
                <input tabindex="8" name="delegate_phone" class="form-control phoneInput" dir="ltr" value="{{($store['delegate_phone'] ?? '+966')}}" />
            </div>
        </div>

        <div class=" w-storeProfile col-lg-2">
            <div class="form-group">
                <label>{{\App\CPU\Helpers::translate('commercial_registration_no')}} : </label>
                <input tabindex="9" name="commercial_registration_no" type="number" class="form-control" value="{{($store['commercial_registration_no'] ?? '')}}" />
            </div>
        </div>

        <div class="@if (!isset($new))  w-storeProfile col-lg-2 @else  w-storeProfile col-lg-4 @endif">
            <div class="form-group">
                <label>{{\App\CPU\Helpers::translate('tax number')}} : </label>
                <input tabindex="10" name="tax_no" type="number" class="form-control" value="{{($store['tax_no'] ?? '')}}" />
            </div>
        </div>



        @if (!isset($new))
        @if(\App\Model\BusinessSetting::where('type','pricing_levels')->first()->value ?? '')
        <div class=" w-storeProfile col-lg-2">
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

        <div class=" w-storeProfile col-lg-3">
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
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="form-group p-0">
                <div class="mb-4">
                    <p class="locations-card-body w-100 pos-relative wd-150px">
                        <div id="location_map_canvas"></div>
                    </p>
                </div>
            </div>
        </div>
        <div class="row  w-storeProfile col-lg-3">
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

        <div class=" w-storeProfile col-lg-2">
            <div class="form-group">
                <center>
                    <img class="upload-img-view" id="viewer1"
                    onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                    src="{{asset('storage/app/public/user')}}/{{($store['image'] ?? '')}}"/>
                </center>
            </div>

            <div class="form-group">
                <div class="title-color mb-2 d-flex gap-1 align-items-center">{{\App\CPU\Helpers::translate('Store Image')}} <span class="text-info">(Ratio 1:1)</span></div>
                <div class="custom-file text-left">
                    <input tabindex="15" type="file" name="image" id="customFileUpload1" class="custom-file-input"
                        accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                    <label class="custom-file-label" for="customFileUpload">{{\App\CPU\Helpers::translate('Upload image')}}</label>
                </div>
            </div>
        </div>

        <div class=" w-storeProfile col-lg-2">
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



        <div class=" w-storeProfile col-lg-2">
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
    </div>


