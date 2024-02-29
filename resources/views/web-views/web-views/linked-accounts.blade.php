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

        #content{
            display: flex;
            justify-content: center;
        }
    </style>
@endpush

@section('content')
@php($storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id())
@php($user = \App\User::find($storeId))
<div class="container row" style="padding-bottom:500px !important;">
    @if (\App\CPU\Helpers::store_module_permission_check('my_account.linking_store_API.sallah'))
    <div class="col-lg-2 col-md-2" style="text-align-last: center">
        <a href="{{ route('salla.oauth.redirect') }}" target="_blank">
            <div class="sm:h-44 flex justify-content-center">
                <img class="w-full h-fit" src="{{ asset('/public/assets/companies/salla.png') }}" alt="">
            </div>
            <h3 class="text-center"> {{ Helpers::translate('Salla') }} </h3>
            @php($salla = \Illuminate\Support\Facades\DB::table('oauth_tokens')
            ->where('website', 'salla')
            ->where('user_id', $storeId)
            ->first()->access_token ?? null)
        </a>
        @isset(Helpers::get_salla_store_name($user)->domain)
            @if ($salla)
                <a target="_blank" href={{ Helpers::get_salla_store_name($user)->domain ?? null }} class="btn btn-primary w-full rounded" onclick="copyToClipboard('{{$salla}}');toastr.success('{{ Helpers::translate('Copied successfully') }}', {CloseButton: true,ProgressBar: true});">
                    {{ Helpers::get_salla_store_name($user)->name ?? null }}
                </a>
            @endif
        @else
        <span class="text-center d-block">
            {{ Helpers::translate('No store is linked or Masfufat app is not enabled on Salla yet') }}
        </span>
        @endisset
        <button class="btn btn-primary w-full mt-1" onclick="copyToClipboard('{{ Helpers::getAppToken('name') }}');toastr.success('{{ Helpers::translate('Copied successfully') }}', {CloseButton: true,ProgressBar: true});">
            {{ Helpers::translate('copy app key') }}
        </button>
        @isset(Helpers::get_salla_store_name($user)->domain)
        <button onclick="route_alert('{{ route('linked-accounts-delete',['id'=>'salla']) }}','{{ Helpers::translate('Are you sure') }}')" class="btn btn-danger mt-1">
            <i class="fa fa-trash"></i>
        </button>
        @endisset
    </div>
    @endif
    @if (\App\CPU\Helpers::store_module_permission_check('my_account.linking_store_API.zid'))
    @php($zid = Helpers::get_zid_store_details())
    <div class="col-lg-2 col-md-2">
        <a href="{{ route('zid.oauth.redirect') }}" target="_blank">
            <div class="sm:h-44 flex justify-content-center">
                <img class="w-full h-fit" src="{{ asset('/public/assets/companies/zid.png') }}" alt="">
            </div>
            <h3 class="text-center"> {{ Helpers::translate('Zid') }} </h3>
        </a>

        @isset($zid->user->store->url)
            <a target="_blank" href={{ $zid->user->store->url ?? null }} class="btn btn-primary w-full rounded">
                {{ $zid->user->store->title ?? null }}
            </a>
        @else
        <span class="text-center d-block">
            {{ Helpers::translate('No store is linked or Masfufat app is not enabled on Zid yet') }}
        </span>
        @endisset
        @isset($zid->user->store->url)
        <div class="w-full text-center justify-center">
            <button onclick="route_alert('{{ route('linked-accounts-delete',['id'=>'zid']) }}','{{ Helpers::translate('Are you sure') }}')" class="btn btn-danger mt-1">
                <i class="fa fa-trash"></i>
            </button>
        </div>
        @endisset
    </div>
    @endif
</div>
@push('script')

@endpush

@endsection
