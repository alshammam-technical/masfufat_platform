@extends('layouts.front-end.app')

@section('title',\App\CPU\Helpers::translate('My linked accounts'))

@push('css_or_js')
    <meta property="og:image" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="og:title" content="My linked accounts  of {{$web_config['name']->value}} "/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    <meta property="twitter:card" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="twitter:title" content="My linked accounts  of {{$web_config['name']->value}}"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    <style>
        .headerTitle {
            font-size: 25px;
            font-weight: 700;
            margin-top: 2rem;
        }

        .for-container {
            width: 91%;
            border: 1px solid #D8D8D8;
            margin-top: 3%;
            margin-bottom: 3%;
        }

        .for-padding {
            padding: 3%;
        }
    </style>
@endpush

@section('content')
<div class="container row" style="padding-bottom:500px !important;">
    <div class="col-2">
        <a href="{{ route('salla.oauth.redirect') }}" target="_blank">
            <div style="width:100%;height:180px">
                <img class="w-100" src="{{ asset('/public/assets/companies/salla.png') }}" alt="">
            </div>
            <h3 class="text-center"> {{ Helpers::translate('Salla') }} </h3>
            @php($salla = \Illuminate\Support\Facades\DB::table('oauth_tokens')
            ->where('website', 'salla')
            ->where('user_id', auth('customer')->user()->id)
            ->first()->access_token ?? null)
        </a>
        @isset(Helpers::get_salla_store_name(auth('customer')->user())->domain)
            @if ($salla)
                <a target="_blank" href={{ Helpers::get_salla_store_name(auth('customer')->user())->domain ?? null }} class="btn btn-primary w-100 rounded" onclick="copyToClipboard('{{$salla}}');toastr.success('{{ Helpers::translate('Copied successfully') }}', {CloseButton: true,ProgressBar: true});">
                    {{ Helpers::get_salla_store_name(auth('customer')->user())->name ?? null }}
                </a>
            @endif
        @else
        <span class="text-center d-block">
            {{ Helpers::translate('No store is linked or Masfufat app is not enabled on Salla yet') }}
        </span>
        @endisset
        <button class="btn btn-primary w-100" onclick="copyToClipboard('{{ Helpers::getAppToken('name') }}');toastr.success('{{ Helpers::translate('Copied successfully') }}', {CloseButton: true,ProgressBar: true});">
            {{ Helpers::translate('copy app key') }}
        </button>
    </div>
    <div class="col-2">
        <a href="{{ route('zid.oauth.redirect') }}" target="_blank">
            <div style="width:100%;height:180px">
                <img src="{{ asset('/public/assets/companies/zid.png') }}" alt="">
            </div>
            <h3 class="text-center"> {{ Helpers::translate('Zid') }} </h3>
        </a>
    </div>
</div>
@push('script')

@endpush

@endsection
