@extends('admin-views.education.frontend.user.layouts.dash')
@section('title', \App\CPU\Helpers::translate('user'))
@section('content')
    <div class="vr__settings__v2">
        <div class="row g-3">
            <div class="col-xl-3">
                @include('admin-views.education.frontend.user.includes.list')
            </div>
            <div class="col-xl-9">
                <div class="vr__card">
                    <div class="vr__settings__box">
                        <div class="vr__settings__box__header border-bottom">
                            <h5 class="mb-0">{{ \App\CPU\Helpers::translate('Show Controls') }}</h5>
                        </div>
                        <div class="vr__settings__box__body">
                            <form id="deatilsForm" action="{{ route('user.settings.details.update') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row row-cols-1 row-cols-sm-2 g-3 mb-3">
                                    <div class="col">
                                        <label class="form-label">{{ \App\CPU\Helpers::translate(First Name', 'forms') }} : <span
                                                class="red">*</span></label>
                                        <input type="firstname" name="firstname" class="form-control"
                                            placeholder="{{ \App\CPU\Helpers::translate(First Name', 'forms') }}" maxlength="50"
                                            value="{{ $user->firstname }}" required>
                                    </div>
                                    <div class="col">
                                        <label class="form-label">{{ \App\CPU\Helpers::translate(Last Name', 'forms') }} : <span
                                                class="red">*</span></label>
                                        <input type="lastname" name="lastname" class="form-control"
                                            placeholder="{{ \App\CPU\Helpers::translate(Last Name', 'forms') }}" maxlength="50"
                                            value="{{ $user->lastname }}" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">{{ \App\CPU\Helpers::translate(Email address', 'forms') }} : <span
                                            class="red">*</span></label>
                                    <input type="email" name="email" class="form-control"
                                        placeholder="{{ \App\CPU\Helpers::translate(Email address', 'forms') }}" value="{{ $user->email }}"
                                        required>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">{{ \App\CPU\Helpers::translate(Username', 'forms') }} : </label>
                                            <input class="form-control" placeholder="{{ \App\CPU\Helpers::translate(Username', 'forms') }}"
                                                value="{{ $user->username }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">{{ \App\CPU\Helpers::translate(Phone Number', 'forms') }} : </label>
                                            <div class="input-group">
                                                <input type="text" class="form-control"
                                                    placeholder="{{ \App\CPU\Helpers::translate(Phone Number', 'forms') }}"
                                                    value="{{ $user->mobile }}" readonly>
                                                <button class="btn btn-success" data-bs-toggle="modal"
                                                    data-bs-target="#mobileModal"
                                                    type="button">{{ \App\CPU\Helpers::translate(Change', 'user') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">{{ \App\CPU\Helpers::translate(Country', 'forms') }} : <span
                                            class="red">*</span></label>
                                    <select name="country" class="form-select" required>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" @if ($country->name == @$user->address->country) selected @endif>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button class="btn btn-primary"><i class="far fa-save"></i>
                                    {{ \App\CPU\Helpers::translate(Save Changes', 'user') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="mobileModal" tabindex="-1" aria-labelledby="mobileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('user.settings.details.mobile.update') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">{{ \App\CPU\Helpers::translate(Phone Number', 'forms') }} : <span
                                    class="red">*</span></label>
                            <div class="form-number">
                                <select id="mobile_code" name="mobile_code" class="form-select flex-shrink-0 w-auto">
                                    @foreach ($countries as $country)
                                        <option data-code="{{ $country->code }}" data-id="{{ $country->id }}"
                                            value="{{ $country->id }}" @if ($country->name == @$user->address->country) selected @endif>{{ $country->code }}
                                            ({{ $country->phone }})</option>
                                    @endforeach
                                </select>
                                <input id="mobile" type="tel" name="mobile" class="form-control"
                                    placeholder="{{ \App\CPU\Helpers::translate(Phone Number', 'forms') }}" required>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary w-full me-2">{{ \App\CPU\Helpers::translate(Save', 'user') }}</button>
                            <button type="button" class="btn btn-secondary w-full ms-2"
                                data-bs-dismiss="modal">{{ \App\CPU\Helpers::translate(Close') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
