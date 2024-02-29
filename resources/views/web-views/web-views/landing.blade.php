@extends('layouts.landing.app')

@section('content')

<style>

</style>

<div style="margin-top: 10rem"></div>
<div class="row mt-5 mx-5" id="about-us-section" dir="{{session()->get('direction') ?? 'rtl'}}">
    <div class="col-lg-6">
        @php($categories=\App\Model\Category::with(['childes.childes'])->where('position', 0)->priority()->paginate(11))
        <div class="d-none mx-0 text-center d-sm-block {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'ml-3' : 'mr-3'}} flex-shrink-0"
        href="{{route('home')}}">
            <img style="width:60%;"
            data-bs-aos="zoom-in"
            src="{{asset('/public/assets/landing/img/section2_logo.png')}}"
            onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
            alt="{{$web_config['name']->value}}"/>
        </div>

        <p class="w-full text-center mt-5 text-primary">
            <strong class="text-6xl" data-bs-aos="zoom-in">
                {{\App\CPU\Helpers::translate('Whos Masfufat?')}}
            </strong>
        </p>

        <p class="w-full text-center mt-1 text-primary" data-bs-aos="fade-down">
            <strong class="h5 fw-bold">
                {{\App\CPU\Helpers::translate('Masfufat is your success partner in your e-commerce, from adding products to the customer receiving the order without capital or any effort. All you have to do is add products to your website and follow your profits.')}}
            </strong>
        </p>
    </div>

    <div class="col-lg-6">
        @php($categories=\App\Model\Category::with(['childes.childes'])->where('position', 0)->priority()->paginate(11))
        <div class="d-none mx-0 text-end d-sm-block {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'ml-3' : 'mr-3'}} flex-shrink-0"
        href="{{route('home')}}">
            <img style="width:100%;"
            data-bs-aos="fade-left"
            src="{{asset('/public/assets/landing/img/section2_img2.png')}}"
            onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
            alt="{{$web_config['name']->value}}"/>
        </div>
    </div>
</div>

<div class="hidden sm:block">
    <div id="features-section1" class="row mb-5 pos-relative" dir="{{session()->get('direction') ?? 'rtl'}}" style="background: url({{asset('/public/assets/landing/img/section3_bg.png')}});background-repeat: no-repeat;height:750px">
        <div class="col-lg-12 p-0">
            <p class="text-secondary w-full text-center p-5 pos-absolute">
                <div class="li-i-icon"></div>
            </p>
                <strong class="features-title" data-bs-aos="fade-up">
                    {{\App\CPU\Helpers::translate('What characterize Masfufat')}}
                </strong>

            <div class="d-flex flex-nowrap features-list" style="overflow-x: auto">
                <div
                data-bs-aos="fade-down"
                data-bs-aos-duration="500"
                class="wd-lg-25p mn-wd-lg-25p mx-wd-lg-25px wd-sm-100p mx-wd-sm-100p mn-wd-sm-100p text-center">
                    <img class="inline" src="{{asset('/public/assets/landing/img/section3_1.png')}}" alt="">
                    <p class="section3_cols_title text-white">
                        <strong class="h2 text-white">
                            {{\App\CPU\Helpers::translate('without capital')}}
                        </strong>
                    </p>
                    <p class="section3_cols_desc text-white mt-3">
                        <strong class="text-white w-75" style="max-width: 75%">
                            {{\App\CPU\Helpers::translate('In Masfufat, you do not need any capital to start your electronic project')}}
                        </strong>
                    </p>
                </div>
                <div
                data-bs-aos="fade-down"
                data-bs-aos-duration="1000"
                class="wd-lg-25p mn-wd-lg-25p mx-wd-lg-25px wd-sm-100p mx-wd-sm-100p mn-wd-sm-100p text-center">
                    <img class="inline" src="{{asset('/public/assets/landing/img/section3_2.png')}}" alt="">
                    <p class="section3_cols_title text-white">
                        <strong class="h2 text-white">
                            {{\App\CPU\Helpers::translate('Automated linking')}}
                        </strong>
                    </p>
                    <p class="section3_cols_desc text-white mt-3">
                        <strong class="text-white w-75" style="max-width: 75%">
                            {{\App\CPU\Helpers::translate('Linking products, uploading their pictures to the merchant\'s store, receiving orders and shipping them automatically')}}
                        </strong>
                    </p>
                </div>
                <div
                data-bs-aos="fade-down"
                data-bs-aos-duration="1500"
                class="wd-lg-25p mn-wd-lg-25p mx-wd-lg-25px wd-sm-100p mx-wd-sm-100p mn-wd-sm-100p text-center">
                    <img class="inline" src="{{asset('/public/assets/landing/img/section3_3.png')}}" alt="">
                    <p class="section3_cols_title text-white">
                        <strong class="h2 text-white">
                            {{\App\CPU\Helpers::translate('provide products')}}
                        </strong>
                    </p>
                    <p class="section3_cols_desc text-white mt-3">
                        <strong class="text-white w-75" style="max-width: 75%">
                            {{\App\CPU\Helpers::translate('we provide products for your online shop')}}
                        </strong>
                    </p>
                </div>
                <div
                data-bs-aos="fade-down"
                data-bs-aos-duration="3000"
                class="wd-lg-25p mn-wd-lg-25p mx-wd-lg-25px wd-sm-100p mx-wd-sm-100p mn-wd-sm-100p text-center">
                    <img class="inline" src="{{asset('/public/assets/landing/img/section3_4.png')}}" alt="">
                    <p class="section3_cols_title text-white">
                        <strong class="h2 text-white">
                            {{\App\CPU\Helpers::translate('Packaging and shipping')}}
                        </strong>
                    </p>
                    <p class="section3_cols_desc text-white mt-3">
                        <strong class="text-white w-75" style="max-width: 75%">
                            {{\App\CPU\Helpers::translate('Packaging and shipping of products is now our mission as well')}}
                        </strong>
                    </p>
                </div>

            </div>
        </div>
    </div>
</div>

<div id="registerNow-section" data-bs-aos="fade-up" class="row mb-5" dir="{{session()->get('direction') ?? 'rtl'}}">
    <div class="registerSq-div bg-primary px-0">
        <h2 class="text-white">
            {{ Helpers::translate('Create a store account') }}
        </h2>
        <a class="btn btn-secondary bg-secondary text-dark" href="{{ route('customer.auth.register') }}">
            <strong>
                {{ Helpers::translate('Register a store account') }}
            </strong>
        </a>
    </div>

    <div class="registerSq-div bg-secondary px-0">
        <h2>
            {{ Helpers::translate('Create a seller account') }}
        </h2>
        <a class="btn btn-secordary bg-primary" href="{{ route('shop.apply') }}">
            <strong>
                {{ Helpers::translate('Register a seller account') }}
            </strong>
        </a>
    </div>
</div>


<div id="features-section" data-bs-aos="fade-up" class="mb-5 d-lg-none d-md-none" dir="{{session()->get('direction') ?? 'rtl'}}" style="background: url({{asset('/public/assets/landing/img/section3_bg.png')}});background-repeat: no-repeat;height:750px">
    <div class="col-lg-12 p-0">
        <p class="text-secondary w-full text-center px-5 pt-5 pb-0">
            <strong class="w-full text-center text-7xl">
                {{\App\CPU\Helpers::translate('What characterize Masfufat')}}
            </strong>
        </p>
        <div class="container rtl">
            <div class="row justify-content-center">
                <div class="col-md-12 mt-0 mb-4 pb-5" style="border-radius: 16px">
                    <div style="margin-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right:0px' : 'left:0px'}}">
                        <div class="carousel-wrap" >
                            <div class="owl-carousel p-2" dir="ltr" id="owl-carousel">
                                <div class="text-center justify-content-center flex flex-wrap">
                                    <p class="section3_cols_title text-white col-12">
                                        <strong class="h2 text-white">
                                            {{\App\CPU\Helpers::translate('without capital')}}
                                        </strong>
                                    </p>
                                    <img class="inline w-50" src="{{asset('/public/assets/landing/img/section3_1.png')}}" alt="">
                                    <p class="section3_cols_desc text-white mt-3">
                                        <strong class="text-white w-75" style="max-width: 75%">
                                            {{\App\CPU\Helpers::translate('In Masfufat, you do not need any capital to start your electronic project')}}
                                        </strong>
                                    </p>
                                </div>
                                <div class="text-center justify-content-center flex flex-wrap">
                                    <p class="section3_cols_title text-white col-12">
                                        <strong class="h2 text-white">
                                            {{\App\CPU\Helpers::translate('Automated linking')}}
                                        </strong>
                                    </p>
                                    <img class="inline w-50" src="{{asset('/public/assets/landing/img/section3_2.png')}}" alt="">
                                    <p class="section3_cols_desc text-white mt-3">
                                        <strong class="text-white w-75" style="max-width: 75%">
                                            {{\App\CPU\Helpers::translate('Linking products, uploading their pictures to the merchant\'s store, receiving orders and shipping them automatically')}}
                                        </strong>
                                    </p>
                                </div>
                                <div class="text-center justify-content-center flex flex-wrap">
                                    <p class="section3_cols_title text-white col-12">
                                        <strong class="h2 text-white">
                                            {{\App\CPU\Helpers::translate('provide products')}}
                                        </strong>
                                    </p>
                                    <img class="inline w-50" src="{{asset('/public/assets/landing/img/section3_3.png')}}" alt="">
                                    <p class="section3_cols_desc text-white mt-3">
                                        <strong class="text-white w-75" style="max-width: 75%">
                                            {{\App\CPU\Helpers::translate('we provide products for your online shop')}}
                                        </strong>
                                    </p>
                                </div>
                                <div class="text-center justify-content-center flex flex-wrap">
                                    <p class="section3_cols_title text-white col-12">
                                        <strong class="h2 text-white">
                                            {{\App\CPU\Helpers::translate('Packaging and shipping')}}
                                        </strong>
                                    </p>
                                    <img class="inline w-50" src="{{asset('/public/assets/landing/img/section3_4.png')}}" alt="">
                                    <p class="section3_cols_desc text-white mt-3">
                                        <strong class="text-white w-75" style="max-width: 75%">
                                            {{\App\CPU\Helpers::translate('Packaging and shipping of products is now our mission as well')}}
                                        </strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="pb-5" style="padding-top: 10rem"></div>
<div id="packages-section" class="mt-5 w-full mx-0 justify-content-center text-center" dir="{{session()->get('direction') ?? 'rtl'}}">
    <p class="text-center w-full justify-content-center mb-5 pb-5">
        <strong data-bs-aos="fade-down" class="text-5xl text-primary text-center w-25 border-purple-800 border-b-4" style="line-height: normal">
            {{\App\CPU\Helpers::translate('Packages')}}
        </strong>
    </p>

    <div class="w-full text-center justify-content-center d-flex">
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
                data-bs-aos-duration="500" class="mb-5 mt-5 bg-white mx-4 px-0 wd-400 package-box" style="border-radius: 12px;height: fit-content;max-height: fit-content;width: 365px" dir="{{(session()->get('direction') ?? 'rtl') == 'ltr' ? 'rtl' : 'ltr'}}">
                    <div class="wd-100p ms-0">
                        <div class="package-item py-4 {{$evodd}}" dir="{{session()->get('direction') ?? 'rtl'}}">
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
                            <div class="w-full text-center justify-content-center">
                                <a href="{{route('customer.auth.register')}}" class="w-50 package-footer2 {{$evodd}} py-2 btn-white" role="button" onclick="subscribe({{$pack['id']}})">
                                    <strong class="h4 text-dark fw-bolder m-0">
                                        {{\App\CPU\Helpers::translate('Subscribe now')}}
                                    </strong>
                                </a>
                            </div>
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
                data-bs-aos-duration="500" class="mb-5 mt-5 bg-white mx-4 px-0 wd-400 package-box" style="border-radius: 12px;height: fit-content;max-height: fit-content;width: 365px" dir="{{(session()->get('direction') ?? 'rtl') == 'ltr' ? 'rtl' : 'ltr'}}">
                    <div class="wd-100p ms-0">
                        <div class="package-item py-4 {{$evodd}}" dir="{{session()->get('direction') ?? 'rtl'}}">
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
                            <div class="w-full text-center justify-content-center">
                                <a href="{{route('customer.auth.register')}}" class="w-50 package-footer2 {{$evodd}} py-2 btn-white" role="button" onclick="subscribe({{$pack['id']}})">
                                    <strong class="h4 text-dark fw-bolder m-0">
                                        {{\App\CPU\Helpers::translate('Subscribe now')}}
                                    </strong>
                                </a>
                            </div>
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


<div style="padding-top: 10rem"></div>

@endsection

@push('script')
    <script>
    $(document).ready(function(){
        $("#owl-carousel").owlCarousel({
            loop: true,
            touchDrag: true,
            pullDrag: true,
            items:4,
            autoplay: true,
            margin: 0,
            nav: true,
            dots: true,
            autoplayHoverPause: true,
            '{{session('direction')}}': true,
            center: true,
            responsive: {
                //X-Small
                0: {
                    items: 1
                },
                360: {
                    items: 1
                },
                375: {
                    items: 1
                },
                540: {
                    items: 1
                },
                //Small
                576: {
                    items: 1
                },
                //Medium
                768: {
                    items: 1
                },
                //Large
                992: {
                    items: 1
                },
                //Extra large
                1200: {
                    items: 1
                },
                //Extra extra large
                1400: {
                    items: 1
                }
            }
        })
    })

    function subscribe(id){
        location.replace('{{route('customer.auth.register')}}?plan='+id)
    }
    </script>
@endpush

