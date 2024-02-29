@extends('backend.layouts.form')
@section('title', $user->firstname . ' ' . $user->lastname . ' | Details')
@section('back', route('users.index'))
@section('content')
    <div class="row">
        <div class="col-lg-3">
            @include('backend.includes.userlist')
        </div>
        <div class="col-lg-9">
            <form id="vironeer-submited-form" action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card custom-card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 my-1">
                                <label class="form-label">{{ __('Account status') }} : </label>
                                <input type="checkbox" name="status" data-toggle="toggle" data-on="{{ __('Active') }}"
                                    data-off="{{ __('Banned') }}" @if ($user->status) checked @endif>
                            </div>
                            <div class="col-lg-4 my-1">
                                <label class="form-label">{{ __('Email status') }} : </label>
                                <input type="checkbox" name="email_status" data-toggle="toggle"
                                    data-on="{{ __('Verified') }}" data-off="{{ __('Unverified') }}"
                                    @if (!is_null($user->email_verified_at)) checked @endif>
                            </div>
                            <div class="col-lg-4 my-1">
                                <label class="form-label">{{ __('Two-Factor Authentication') }} : </label>
                                <input id="2faCheckbox" type="checkbox" name="google2fa_status" data-toggle="toggle"
                                    data-on="{{ __('Active') }}" data-off="{{ __('Disabled') }}"
                                    @if ($user->google2fa_status) checked @endif>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Firstname') }} :<span
                                            class="red">*</span></label>
                                    <input type="firstname" name="firstname" class="form-control"
                                        value="{{ $user->firstname }}" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Lastname') }} :<span
                                            class="red">*</span></label>
                                    <input type="lastname" name="lastname" class="form-control"
                                        value="{{ $user->lastname }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Username') }} :<span
                                    class="red">*</span></label>
                            <input type="username" name="username" class="form-control" value="{{ $user->username }}"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('E-mail Address') }} :<span
                                    class="red">*</span></label>
                            <div class="input-group mb-3">
                                <input type="email" name="email" class="form-control" value="{{ $user->email }}"
                                    required>
                                <button class="btn btn-dark" type="button" data-bs-toggle="modal"
                                    data-bs-target="#sendMailModal"><i
                                        class="far fa-paper-plane me-2"></i>{{ __('Send Email') }}</button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Phone number') }} :<span
                                    class="red">*</span></label>
                            <input type="mobile" name="mobile" class="form-control" value="{{ $user->mobile }}"
                                required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">{{ __('Country') }} :</label>
                            <select name="country" class="form-select">
                                <option value="" selected disabled>{{ __('Choose') }}</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}" @if ($country->name == @$user->address->country) selected @endif>{{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="sendMailModal" tabindex="-1" aria-labelledby="sendMailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sendMailModalLabel">{{ __('Send Mail to ') }}{{ $user->email }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('users.sendmail', $user->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Subject') }} : <span
                                            class="red">*</span></label>
                                    <input type="subject" name="subject" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Reply to') }} : <span
                                            class="red">*</span></label>
                                    <input type="email" name="reply_to" class="form-control"
                                        value="{{ adminAuthInfo()->email }}" required>
                                </div>
                            </div>
                        </div>
                        <textarea name="message" id="content-small" rows="10" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ __('Send') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
