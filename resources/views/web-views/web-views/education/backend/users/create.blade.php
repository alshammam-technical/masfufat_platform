@extends('backend.layouts.form')
@section('title', 'Add new user')
@section('container', 'container-max-lg')
@section('back', route('users.index'))
@section('content')
    <div class="card">
        <div class="card-body">
            <form id="vironeer-submited-form" action="{{ route('users.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="avatar text-center py-4">
                    <img id="filePreview" src="{{ asset('images/avatars/default.png') }}" class="rounded-circle mb-3"
                        width="120px" height="120px">
                    <button id="selectFileBtn" type="button"
                        class="btn btn-secondary d-flex m-auto">{{ __('Choose Image') }}</button>
                    <input id="selectedFileInput" type="file" name="avatar" accept="image/png, image/jpg, image/jpeg"
                        hidden>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Firstname') }} :<span
                                    class="red">*</span></label>
                            <input type="firstname" name="firstname" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Lastname') }} :<span
                                    class="red">*</span></label>
                            <input type="lastname" name="lastname" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Username') }} :<span class="red">*</span></label>
                    <input type="username" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('E-mail Address') }} :<span
                            class="red">*</span></label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Country') }} :<span class="red">*</span></label>
                    <select name="country" class="form-select" required>
                        <option value="" selected disabled>{{ __('Choose') }}</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Phone number') }} :<span class="red">*</span></label>
                    <div class="form-number d-flex">
                        <select name="mobile_code" class="form-select flex-shrink-0 w-auto" required>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->code }} ({{ $country->phone }})
                                </option>
                            @endforeach
                        </select>
                        <input type="tel" name="mobile" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Password') }} :<span class="red">*</span></label>
                    <input type="text" name="password" class="form-control" value="{{ $password }}" required>
                </div>
            </form>
        </div>
    </div>
@endsection
