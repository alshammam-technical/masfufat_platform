@extends('admin-views.education.frontend.user.layouts.dash')
@section('title', \App\CPU\Helpers::translate(Open new ticket', 'tickets'))
@section('back', route('user.tickets'))
@section('content')
    <form action="{{ route('user.tickets.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="vr__card dash__forms mb-3">
            <div class="row g-3 mb-3">
                <div class="col-lg-6">
                    <label class="form-label">{{ \App\CPU\Helpers::translate(Subject', 'tickets') }} : <span
                            class="red">*</span></label>
                    <input type="subject" name="subject" class="form-control" required value="{{ old('subject') }}">
                </div>
                <div class="col-lg-6">
                    <label class="form-label">{{ \App\CPU\Helpers::translate(Priority', 'tickets') }} : <span
                            class="red">*</span></label>
                    <select name="priority" class="form-select form-control" required>
                        <option value="0" @if (old('priority') == 0) selected @endif>{{ \App\CPU\Helpers::translate(Normal', 'tickets') }}</option>
                        <option value="1" @if (old('priority') == 1) selected @endif>{{ \App\CPU\Helpers::translate(Low', 'tickets') }}</option>
                        <option value="2" @if (old('priority') == 2) selected @endif>{{ \App\CPU\Helpers::translate(High', 'tickets') }}</option>
                        <option value="3" @if (old('priority') == 3) selected @endif>{{ \App\CPU\Helpers::translate(Urgent', 'tickets') }}</option>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ \App\CPU\Helpers::translate(Message', 'tickets') }} : <span
                        class="red">*</span></label>
                <textarea name="message" class="form-control" rows="10" required>{{ old('message') }}</textarea>
            </div>
            <div class="vr__dash__nice__button mb-3">
                <label class="form-label">{{ \App\CPU\Helpers::translate(Files', 'tickets') }} :
                    <small>(<strong>{{ \App\CPU\Helpers::translate(Supported types', 'tickets') }} :</strong>
                        {{ __('JPG, JPEG, PNG, PDF') }})</small></label>
                <div class="input-group">
                    <input type="file" name="attachments[]" class="form-control"
                        accept="image/png, image/jpeg, image/jpg, application/pdf">
                    <button class="btn btn-dark" type="button" id="vr__addfiles__btn"><i
                            class="fa fa-plus"></i></button>
                </div>
                <div id="vr__showFiles__input"></div>
            </div>
            <div class="vr__dash__nice__button">
                <button class="btn btn-primary" type="submit"><i
                        class="far fa-paper-plane me-2"></i>{{ \App\CPU\Helpers::translate(Send', 'tickets') }}</button>
            </div>
        </div>
    </form>
@endsection
