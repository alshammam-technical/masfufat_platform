@extends('layouts.front-end.app')

@section('title', \App\CPU\Helpers::translate('Update Phone'))

@push('css_or_js')
<style>
    @media(max-width:500px){
        #sign_in{
            margin-top: -23% !important;
        }

    }
</style>
@endpush

@section('content')
    <div class="container py-4 py-lg-5 my-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 box-shadow">
                    <div class="card-body">
                        <h2 class="h4 mb-1">{{\App\CPU\Helpers::translate('few_steps_ahead')}}</h2>
                        <p class="font-size-sm text-muted mb-4">{{\App\CPU\Helpers::translate('update_information_to_continue')}}.</p>
                        <form class="needs-validation_" id="sign-up-form" action="{{route('customer.auth.update-phone', $user->id)}}"
                              method="post">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="reg-fn">{{\App\CPU\Helpers::translate('first_name')}}</label>
                                        <input class="form-control" type="text" name="f_name" value="{{ $user->f_name }}" required>
                                        <div class="invalid-feedback">{{\App\CPU\Helpers::translate('Please enter your first name')}}!</div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="reg-ln">{{\App\CPU\Helpers::translate('last_name')}}</label>
                                        <input class="form-control" type="text" name="l_name" value="{{ $user->l_name }}" required>
                                        <div class="invalid-feedback">{{\App\CPU\Helpers::translate('Please enter your last name')}}!</div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="reg-email">{{\App\CPU\Helpers::translate('email_address')}}</label>
                                        <span class="form-control">{{ $user->email }}</span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="reg-phone">{{\App\CPU\Helpers::translate('phone_name')}}</label>
                                        <input class="form-control phoneInput" type="text" name="phone" required>
                                        <div class="invalid-feedback">{{\App\CPU\Helpers::translate('Please enter your phone number')}}!</div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" value="{{$user->id}}" name="id">
                            <button type="submit" class="btn btn-outline-primary">{{\App\CPU\Helpers::translate('update')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
@endpush
