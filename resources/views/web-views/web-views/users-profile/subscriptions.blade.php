@extends('layouts.front-end.app')

@section('title',\App\CPU\Helpers::translate('Packages'))

@push('css_or_js')
    <link href="{{asset('public/assets/back-end/css/tags-input.min.css')}}" rel="stylesheet">
    <link href="{{ asset('public/assets/select2/css/select2.min.css')}}" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">

@endpush

@section('content')
<style>



    .package-item {
        text-align: center;
        padding-top: 10px;
        padding-bottom: 10px;
        border-radius: 12px;
        justify-content: center;
        line-height: 50px;
    }

    .package-footer2{
        border-radius: 0px 0px 8px 8px;
    }

    .package-item.odd,.package-footer.odd{
        /* background-image: linear-gradient(to right,#ffdb04 30%, #ffba00 60%); */
        background-color: #5A409B;
    }

    .package-item-a.odd {
        background-color: #ffdb04;
    }

    .package-item-b.odd {
        background-color: #b1ba01;
    }

    .package-item.even,.package-footer.even{
        /* background-image: linear-gradient(to right,#96a4e9 30%, #985dff 60%); */
        background-color: #5A409B;
    }

    .package-item-a.even {
        background-color: #96aae7;
    }

    .package-item-b.even {
        background-color: #0b2bca;
    }

    .package-item-a, .package-item-b{
        padding-top: 40px;
        position: absolute;
    }


    .package-item-a {
        width: 10%;
        border-radius: 0px 0px 0px 19px;
    }

    .package-item-b {
        width: 10%;
        border-radius: 50px 0px 0px 50px;
    }

    .package-icon{
        width: 70px;
        max-width: 70px;
        height: 70px;
        max-height: 70px;
        border-radius: 50px;
    }

    .package-item-icon{
        min-width: 25px;
        height:25px;
        padding:1px;
        font-size: 13px;
        border-radius:50px;
        text-align-last:center;
    }

    .package-item-icon i{
        padding: 5px;
    }
</style>


<!-- Page Content-->
<div class="container pb-5 mb-2 mb-md-4 mt-0 rtl"
     style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};min-width: 100%;margin: 0;">
<div id="packages-section" class="mt-5 w-full mx-0 justify-content-center text-center" dir="{{session()->get('direction') ?? 'rtl'}}">

    <div class="row w-full text-center justify-content-center">
        <div class="row w-full plans-tab">
            <div class="w-50 text-center justify-content-center">
                <div class="col-6 btn btn-primary p-0 orders-tab a-orders-tab btn-white d-inline-flex" style="border-bottom: solid black thin;">
                    <a href="javascript:void(0);" class="w-full text-center" style="display: grid" onclick="$('.order-frames').hide();$('#monthly').show();$('.orders-tab').removeClass('btn-primary');$('.a-orders-tab').addClass('btn-primary')">
                        <p class="text-lg text-center mb-0 p-3 float-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}} headerTitle">
                            {{\App\CPU\Helpers::translate('Monthly plans')}}
                        </p>
                    </a>
                </div>
            </div>
            <div class="w-50 text-center justify-content-center">
                <div class="col-6 btn p-0 orders-tab sync-orders-tab btn-white d-inline-flex" style="border-bottom: solid black thin;">
                    <a href="javascript:void(0);" class="w-full text-center" style="display: grid" onclick="$('.order-frames').hide();$('#yearly').show();$('.orders-tab').removeClass('btn-primary');$('.sync-orders-tab').addClass('btn-primary')">
                        <p class="text-lg text-center mb-0 p-3 float-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}} headerTitle">
                            {{\App\CPU\Helpers::translate('Yearly plans')}}
                        </p>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="justify-content-center text-center w-full">

        <div class="wd-lg-100p justify-content-center text-center order-frames" id="monthly">
            <div class="d-flex flex-wrap mb-5" style="width: 100%;place-content:center">
                @php($evodd = "even")
                @foreach (\App\Package::where('enabled','1')->where(function($q){$q->where('type','monthly')->orWhere('price',0);})->orderBy('price')->get() as $pack)
                <?php
                    if($evodd == "even"){
                        $evodd = "odd";
                    }else{
                        $evodd = "even";
                    }
                ?>
                <div data-bs-aos="flip-right"
                data-bs-aos-duration="500" class="mb-5 mt-5 bg-white sm:mx-4 px-0 wd-400 package-box sm:w-auto w-full" style="border-radius: 12px;height: fit-content;max-height: fit-content;width: 365px" dir="{{(session()->get('direction') ?? 'rtl') == 'ltr' ? 'rtl' : 'ltr'}}">
                    <div class="wd-100p ms-0">
                        <div class="package-item py-4 {{$evodd}}" dir="{{session()->get('direction') ?? 'rtl'}}" style="min-height: 270px">
                            <div>
                                <strong class="h4 text-center text-white fw-bolder w-full p-2 mb-0" style="min-height: 100px">
                                    @php($name = $pack['name'])
                                    @foreach($pack['translations'] as $t)
                                        @if($t->locale == App::getLocale() && $t->key == "name")
                                            @php($name = $t->value)
                                        @else
                                            @php($name = $pack['name'])
                                        @endif
                                    @endforeach
                                    {{$name}}
                                </strong>
                            </div>
                            <div>
                                <strong class="h1 text-white fw-bolder">{{Helpers::currency_converter($pack['price'])}}</strong>
                                <br/>
                                <strong class="h4 text-white fw-bolder" dir="{{session('direction')}}">
                                    @if($pack['price'])
                                    {{\App\CPU\Helpers::translate('per month')}}
                                    @else
                                    {{$pack['period'] .' '. Helpers::translate('days')}}
                                    @endif
                                </strong>

                            </div>

                            {{--    --}}
                            @php($storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id())
                            @php($user = \App\User::find($storeId))
                            @if($user->subscription == $pack['id'] && ($pack['price'] !== "0") && intval($pack['price']) !== 0)
                                <div class="w-full package-footer2 {{$evodd}} bg-success py-2" role="button" onclick="subscribe({{$pack['id']}})">
                                    <a href="#">
                                        @if(App\Model\Subscription::where('user_id',$storeId)->count())
                                        <strong class="h4 text-white fw-bolder bg-success">
                                            {{\App\CPU\Helpers::translate('Current plan')}}
                                            @if (Carbon\Carbon::parse($user->created_at)->addDays($pack->period)->lt(Carbon\Carbon::today()))
                                            <br/>
                                            <strong class="text-white" dir="{{session('direction')}}">
                                                {{ Helpers::customer_exp_days($storeId) }}
                                                @if( Helpers::customer_exp_days($storeId) !== Helpers::translate('Expired'))
                                                {{ Helpers::translate('day/days remaining')}}
                                                @endif
                                            </strong>
                                            @else
                                            <br/>
                                            @php($exp = Carbon\Carbon::parse($user->created_at)->addDays($pack->period))
                                            @php($now = Carbon\Carbon::today())
                                            <strong class="text-danger" dir="{{session('direction')}}">
                                                {{ Helpers::customer_exp_days($storeId) }}
                                                @if( Helpers::customer_exp_days($storeId) !== Helpers::translate('Expired'))
                                                {{ Helpers::translate('day/days remaining')}}
                                                @endif
                                            </strong>
                                            @endif
                                            @if(!$user->is_active)
                                            - {{ Helpers::translate('Expired') }}
                                        </br>
                                        <a href="{{ route('subscriptions-pay',['plan_id' => $pack['id']]) }}">
                                            {{\App\CPU\Helpers::translate('Click here to renew')}}
                                            <a/>
                                            @endif
                                        </strong>
                                        @else
                                        <strong class="h4 text-white fw-bolder bg-warning">
                                            <a href="{{ route('subscriptions-pay',['plan_id' => $pack['id']]) }}" class="w-full d-block">
                                                <strong class="h4 text-white fw-bolder">
                                                    {{\App\CPU\Helpers::translate('Complete the payment process')}}
                                                </strong>
                                            </a>
                                        </strong>
                                        @endif
                                    </a>
                                </div>
                            @elseif($user->subscription == $pack['id'])
                            <div class="w-full package-footer2 {{$evodd}} bg-success py-2" role="button" onclick="subscribe({{$pack['id']}})">
                                <a href="#">
                                    <strong class="h4 text-white fw-bolder bg-success">
                                        {{\App\CPU\Helpers::translate('Current plan')}}
                                        <br/>
                                        <strong class="text-white" dir="{{session('direction')}}">
                                            {{ Helpers::customer_exp_days($storeId) }}
                                            @if( Helpers::customer_exp_days($storeId) !== Helpers::translate('Expired'))
                                            {{ Helpers::translate('day/days remaining')}}
                                            @endif
                                        </strong>
                                    </strong>
                                </a>
                            </div>
                            @else
                            {{--    --}}
                            @if($pack['price'] == "0")
                            @if(!$user->subscription >= 1)
                            <div class="w-full text-center justify-content-center">
                                <a href="{{ route('subscriptions-pay',['plan_id' => 'free']) }}" class="sm:w-1/2 w-11/12 rounded-md py-3 package-footer2 {{$evodd}} py-2 btn-white">
                                    <strong class="h4 text-dark fw-bolder m-0">
                                        {{\App\CPU\Helpers::translate('Subscribe now')}}
                                    </strong>
                                </a>
                            </div>
                            @endif
                            @else
                            @if (\App\CPU\Helpers::store_module_permission_check('my_account.subscriptions.subscribe'))
                            <div class="w-full text-center justify-content-center">
                                <a href="{{ route('subscriptions-pay',['plan_id' => $pack['id']]) }}" class="sm:w-1/2 w-11/12 rounded-md py-3 package-footer2 {{$evodd}} py-2 btn-white">
                                    <strong class="h4 text-dark fw-bolder m-0">
                                        {{\App\CPU\Helpers::translate('Subscribe now')}}
                                    </strong>
                                </a>
                            </div>
                            @endif
                            @endif
                            @endif
                            {{--    --}}

                        </div>
                    </div>
                    <div class="px-5 me-4 mt-4 pt-4 border-bottom border-primary wd-85p" style="margin-inline-start: auto">
                        <strong class="fw-bolder text-primary">
                            @php($desc = $pack['desc'])
                            @foreach($pack['translations'] as $t)
                                @if($t->locale == App::getLocale() && $t->key == "desc")
                                    @php($desc = $t->value)
                                @else
                                    @php($desc = $pack['desc'])
                                @endif
                            @endforeach
                            {{$desc}}
                        </strong>
                    </div>
                    <div class="px-5 packs-services">
                        <ul dir="{{session()->get('direction') ?? 'rtl'}}" class="text-start w-full m-0 p-0" style="list-style-type: none">

                            @foreach (\App\services_packaging::where('enabled','1')->get() as $service)
                            <li class="d-flex my-3">
                                <div class="bg-{{ (in_array($service['id'],explode(',',$pack['services']))) ? 'success' : 'danger'}} package-item-icon">
                                    <i class="fa fa-{{ (in_array($service['id'],explode(',',$pack['services']))) ? 'check' : 'close'}} text-white"></i>
                                </div>
                                <div class="mx-2">
                                    @php($n = $service['name'])
                                    @foreach($service['translations'] as $t)
                                        @if($t->locale == App::getLocale() && $t->key == "name")
                                            @php($n = $t->value)
                                        @else
                                            @php($n = $service['name'])
                                        @endif
                                    @endforeach
                                    {{$n}}
                                </div>
                            </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
                @endforeach



            </div>
        </div>

        <div class="wd-lg-100p justify-content-center text-center order-frames" id="yearly" style="display:none">
            <div class="d-flex flex-wrap mb-5" style="width: 100%;place-content:center">
                @php($evodd = "even")
                @foreach (\App\Package::where('enabled','1')->where(function($q){$q->where('type','yearly')->orWhere('price',0);})->orderBy('price')->get() as $pack)
                <?php
                    if($evodd == "even"){
                        $evodd = "odd";
                    }else{
                        $evodd = "even";
                    }
                ?>
                <div data-bs-aos="flip-right"
                data-bs-aos-duration="500" class="mb-5 mt-5 bg-white sm:mx-4 px-0 wd-400 package-box sm:w-auto w-full" style="border-radius: 12px;height: fit-content;max-height: fit-content;width: 365px" dir="{{(session()->get('direction') ?? 'rtl') == 'ltr' ? 'rtl' : 'ltr'}}">
                    <div class="wd-100p ms-0">
                        <div class="package-item py-4 {{$evodd}}" dir="{{session()->get('direction') ?? 'rtl'}}" style="min-height: 270px">
                            <div>
                                <strong class="h4 text-center text-white fw-bolder w-full p-2 mb-0" style="min-height: 100px">
                                    @php($name = $pack['name'])
                                    @foreach($pack['translations'] as $t)
                                        @if($t->locale == App::getLocale() && $t->key == "name")
                                            @php($name = $t->value)
                                        @else
                                            @php($name = $pack['name'])
                                        @endif
                                    @endforeach
                                    {{$name}}
                                </strong>
                            </div>
                            <div>
                                <strong class="h1 text-white fw-bolder">{{Helpers::currency_converter($pack['price'])}}</strong>
                                <br/>
                                <strong class="h4 text-white fw-bolder" dir="{{session('direction')}}">
                                    @if($pack['price'])
                                    {{\App\CPU\Helpers::translate('per year')}}
                                    @else
                                    {{$pack['period'] .' '. Helpers::translate('days')}}
                                    @endif
                                </strong>
                            </div>
                            {{--    --}}
                            @if($user->subscription == $pack['id'] && intval($pack['price']) !== 0)
                                <div class="w-full package-footer2 {{$evodd}} bg-success py-2" role="button" onclick="subscribe({{$pack['id']}})">
                                    <a href="#">
                                        @if(App\Model\Subscription::where('user_id',$storeId)->count())
                                        <strong class="h4 text-white fw-bolder bg-success">
                                            {{\App\CPU\Helpers::translate('Current plan')}}

                                            @if (Carbon\Carbon::parse($user->created_at)->addDays($pack->period)->lt(Carbon\Carbon::today()))
                                            <br/>
                                            <strong class="text-white" dir="{{session('direction')}}">
                                                {{ Helpers::customer_exp_days($storeId) }}
                                                @if( Helpers::customer_exp_days($storeId) !== Helpers::translate('Expired'))
                                                {{ Helpers::translate('day/days remaining')}}
                                                @endif
                                            </strong>
                                            @else
                                            <br/>
                                            @php($exp = Carbon\Carbon::parse($user->created_at)->addDays($pack->period))
                                            @php($now = Carbon\Carbon::today())
                                            <strong class="text-danger" dir="{{session('direction')}}">
                                                {{ Helpers::customer_exp_days($storeId) }}
                                                @if( Helpers::customer_exp_days($storeId) !== Helpers::translate('Expired'))
                                                {{ Helpers::translate('day/days remaining')}}
                                                @endif
                                            </strong>
                                            @endif
                                            @if(!$user->is_active)
                                            - {{ Helpers::translate('Expired') }}
                                            </br>
                                            <a href="{{ route('subscriptions-pay',['plan_id' => $pack['id']]) }}">
                                                {{\App\CPU\Helpers::translate('Click here to renew')}}
                                            <a/>
                                            @endif
                                        </strong>
                                        @else
                                        <strong class="h4 text-white fw-bolder bg-warning">
                                            <a href="{{ route('subscriptions-pay',['plan_id' => $pack['id']]) }}" class="w-full d-block">
                                                <strong class="h4 text-white fw-bolder">
                                                    {{\App\CPU\Helpers::translate('Complete the payment process')}}
                                                </strong>
                                            </a>
                                        </strong>
                                        @endif
                                    </a>
                                </div>
                            @else
                            {{--    --}}
                            @if($pack['price'] == "0")
                            @if(!$user->subscription >= 1)
                            <div class="w-full text-center justify-content-center">
                                <a href="{{ route('subscriptions-pay',['plan_id' => 'free']) }}" class="sm:w-1/2 w-11/12 rounded-md py-3 package-footer2 {{$evodd}} py-2 btn-white">
                                    <strong class="h4 text-dark fw-bolder m-0">
                                        {{\App\CPU\Helpers::translate('Subscribe now')}}
                                    </strong>
                                </a>
                            </div>
                            @elseif($user->subscription == $pack['id'])
                            <div class="w-full package-footer2 {{$evodd}} bg-success py-2" role="button" onclick="subscribe({{$pack['id']}})">
                                <a href="#">
                                    <strong class="h4 text-white fw-bolder bg-success">
                                        {{\App\CPU\Helpers::translate('Current plan')}}
                                        <br/>
                                        <strong class="text-white" dir="{{session('direction')}}">
                                            {{ Helpers::customer_exp_days($storeId) }}
                                            @if( Helpers::customer_exp_days($storeId) !== Helpers::translate('Expired'))
                                            {{ Helpers::translate('day/days remaining')}}
                                            @endif
                                        </strong>
                                    </strong>
                                </a>
                            </div>
                            @endif
                            @else
                            @if (\App\CPU\Helpers::store_module_permission_check('my_account.subscriptions.subscribe'))
                            <div class="w-full text-center justify-content-center">
                                <a href="{{ route('subscriptions-pay',['plan_id' => $pack['id']]) }}" class="sm:w-1/2 w-11/12 rounded-md py-3 package-footer2 {{$evodd}} py-2 btn-white">
                                    <strong class="h4 text-dark fw-bolder m-0">
                                        {{\App\CPU\Helpers::translate('Subscribe now')}}
                                    </strong>
                                </a>
                            </div>
                            @endif
                            @endif
                            @endif
                            {{--    --}}
                        </div>
                    </div>
                    <div class="px-5 me-4 mt-4 pt-4 border-bottom border-primary wd-85p" style="margin-inline-start: auto">
                        <strong class="fw-bolder text-primary">
                            @php($desc = $pack['desc'])
                            @foreach($pack['translations'] as $t)
                                @if($t->locale == App::getLocale() && $t->key == "desc")
                                    @php($desc = $t->value)
                                @else
                                    @php($desc = $pack['desc'])
                                @endif
                            @endforeach
                            {{$desc}}
                        </strong>
                    </div>
                    <div class="px-5 packs-services">
                        <ul dir="{{session()->get('direction') ?? 'rtl'}}" class="text-start w-full m-0 p-0" style="list-style-type: none">

                            @foreach (\App\services_packaging::where('enabled','1')->get() as $service)
                            <li class="d-flex my-3">
                                <div class="bg-{{ (in_array($service['id'],explode(',',$pack['services']))) ? 'success' : 'danger'}} package-item-icon">
                                    <i class="fa fa-{{ (in_array($service['id'],explode(',',$pack['services']))) ? 'check' : 'close'}} text-white"></i>
                                </div>
                                <div class="mx-2">
                                    @php($n = $service['name'])
                                    @foreach($service['translations'] as $t)
                                        @if($t->locale == App::getLocale() && $t->key == "name")
                                            @php($n = $t->value)
                                        @else
                                            @php($n = $service['name'])
                                        @endif
                                    @endforeach
                                    {{$n}}
                                </div>
                            </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
                @endforeach



            </div>
        </div>

    </div>
</div>
</div>
@endsection

@push('script')

@endpush
