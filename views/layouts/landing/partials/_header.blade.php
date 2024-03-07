<style>

    @font-face{
        font-family:"tajawal";
        src:url("{{asset('public/fonts/Tajawal-Regular.ttf')}}")
    }

    *{
        font-family:"tajawal"
    }

    body{
        background-color: #f1f1f1;
    }

    .card-body.search-result-box {
        overflow: scroll;
        height: 400px;
        overflow-x: hidden;
    }

    .active .seller {
        font-weight: 700;
    }

    .for-count-value {
        position: absolute;

        right: 0.6875rem;;
        width: 1.25rem;
        height: 1.25rem;
        border-radius: 50%;
        color: {{$web_config['primary_color']}};

        font-size: .75rem;
        font-weight: 500;
        text-align: center;
        line-height: 1.25rem;
    }

    .count-value {
        width: 1.25rem;
        height: 1.25rem;
        border-radius: 50%;
        color: {{$web_config['primary_color']}};

        font-size: .75rem;
        font-weight: 500;
        text-align: center;
        line-height: 1.25rem;
    }

    @media (min-width: 992px) {
        .navbar-sticky.navbar-stuck .navbar-stuck-menu.show {
            display: block;
            height: 55px !important;
        }
    }

    @media (min-width: 768px) {
        .navbar-stuck-menu {
            background-color: {{$web_config['primary_color']}};
            line-height: 15px;
            padding-bottom: 6px;
        }

    }

    @media (max-width: 767px) {
        .search_button {
            background-color: transparent !important;
        }

        .search_button .input-group-text i {
            color: {{$web_config['primary_color']}}                              !important;
        }

        .navbar-expand-md .dropdown-menu > .dropdown > .dropdown-toggle {
            position: relative;
            padding- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 1.95rem;
        }

        .mega-nav1 {
            background: white;
            color: {{$web_config['primary_color']}}                              !important;
            border-radius: 3px;
        }

        .mega-nav1 .nav-link {
            color: {{$web_config['primary_color']}}                              !important;
        }
    }

    @media (max-width: 768px) {
        .tab-logo {
            width: 10rem;
        }
    }

    @media (max-width: 360px) {
        .mobile-head {
            padding: 3px;
        }
    }

    @media (max-width: 471px) {
        .navbar-brand img {

        }

        .mega-nav1 {
            background: white;
            color: {{$web_config['primary_color']}}                              !important;
            border-radius: 3px;
        }

        .mega-nav1 .nav-link {
            color: {{$web_config['primary_color']}} !important;
        }
    }
    #anouncement {
        width: 100%;
        padding: 2px 0;
        text-align: center;
        color:white;
    }

    .cloud-1{
        position: absolute;
        width: 162px;
        height: 162px;
        right: 73%;
        top: 269px;
        background: #FDCD05;
        filter: blur(128px);
    }
    .cloud-2{
        position: absolute;
        width: 162px;
        height: 162px;
        left: 73%;
        top: 928px;
        background: #5A409B;
        filter: blur(128px);

    }
</style>

<!-- JavaScript Bundle with Popper -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/popper.min.js"></script>
<script src="https://getbootstrap.com/docs/4.0/dist/js/bootstrap.min.js"></script>

{{--  aos  --}}
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<header class="{{session()->get('direction') ?? 'rtl'}} text-light landing" style="background-size:cover;padding-bottom:100px;background-repeat: no-repeat;padding-bottom:23rem">
    <!-- Topbar-->
    <div>
        <div class="navbar-expand-md w-100 mx-0 text-center justify-content-center"  >
            <div class="container w-100 mx-0 px-0" style="min-width: 100%">
                <div class="row w-100 mx-0" id="navbarCollapse"
                    style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}}; ">
                    <div class="col-lg-2">
                        @php($categories=\App\Model\Category::with(['childes.childes'])->where('position', 0)->priority()->paginate(11))
                        <a class="mx-0 text-start d-sm-block {{Session::get('direction') === "rtl" ? 'ml-3' : 'mr-3'}} flex-shrink-0"
                        href="{{route('home')}}">
                            <img style="width:200px;"
                            data-aos="zoom-in" data-aos-duration="1500"
                            src="{{asset("storage/app/public/company")."/".$web_config['web_logo']->value}}"
                            onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                            alt="{{$web_config['name']->value}}"/>
                        </a>
                    </div>

                    <div class="col-lg-10 text-end d-table" style="vertical-align: middle">
                        <div class="d-table-row">
                            <div class="d-table-cell" style="vertical-align: middle">
                                <div class="row">
                                    <div class="col-md-7 row justify-content-start mt-3">
                                        <div class="col-md-3 text-center"><a class="text-white" href="#about-us-section">{{ Helpers::translate('About_Us') }}</a></div>
                                        <div class="col-md-3 text-center"><a class="text-white" href="#features-section">{{ Helpers::translate('Services') }}</a></div>
                                        <div class="col-md-3 text-center"><a class="text-white" href="#packages-section">{{ Helpers::translate('Packages') }}</a></div>
                                        <div class="col-md-3 text-center"><a class="text-white" href="#contact-section">{{ Helpers::translate('Contact Us') }}</a></div>
                                    </div>

                                    <div class="col-md-5 row justify-content-end">
                                        <button data-aos="flip-up" data-aos-duration="1500" class="col-lg-4 w-100 btn btn-primary border-0 p-0">
                                            <a href="{{route('customer.auth.register')}}" class="fs-18 w-100 btn text-white font-weight-bolder px-0">
                                                {{\App\CPU\Helpers::translate('sing_up')}}
                                            </a>
                                        </button>
                                        <div class="p-2"></div>
                                        <button data-aos="flip-down" data-aos-duration="1500" class="col-lg-5 w-100 btn btn-light border-0 p-0">
                                            <a href="{{route('customer.auth.login')}}" class="fs-18 w-100 btn text-dark font-weight-bolder px-0 text-wrap">
                                                {{\App\CPU\Helpers::translate('login')}}
                                            </a>
                                        </button>

                                        {{--    --}}
                                        <div class="col-lg-2 text-center justify-content-center">
                                            @php( $local = \App\CPU\Helpers::default_lang())
                                            <div
                                                class="topbar-text dropdown disable-autohide  text-capitalize pt-3 text-center bg-secondary"
                                                style="width: 120px;height:52px;background-color: #f1f1f1;border-radius: 11px">
                                                <a class="topbar-link dropdown-toggle" href="#" data-toggle="dropdown">
                                                    @foreach(json_decode($language['value'],true) as $data)
                                                        @if($data['code']==$local)
                                                            <img class="{{Session::get('direction') === "rtl" ? 'ml-2' : 'mr-2'}}" width="20"
                                                                src="{{asset('public/assets/front-end')}}/img/flags/{{$data['code']}}.png"
                                                                alt="Eng">
                                                            {{$data['name']}}
                                                        @endif
                                                    @endforeach
                                                </a>
                                                <ul class="bg-white dropdown-menu dropdown-menu-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}"
                                                    style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                                    @foreach(json_decode($language['value'],true) as $key =>$data)
                                                        @if($data['status']==1)
                                                            <li onclick="alert_wait()">
                                                                <a class="dropdown-item pb-1" href="{{route('lang',[$data['code']])}}">
                                                                    <img class="{{Session::get('direction') === "rtl" ? 'ml-2' : 'mr-2'}}"
                                                                        width="20"
                                                                        src="{{asset('public/assets/front-end')}}/img/flags/{{$data['code']}}.png"
                                                                        alt="{{$data['name']}}"/>
                                                                    <span style="text-transform: capitalize">{{$data['name']}}</span>
                                                                </a>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>

                                        {{--    --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row w-100 pos-relative"
            style="
            text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">

            <div class="col-lg-1"></div>

            <div class="cloud-1"></div>
            <div class="cloud-2"></div>

            <div class="col-lg-12 justify-content-center d-flex">
                <div class="mt-5 text-center d-sm-block flex-shrink-0 w-75"
                href="{{route('home')}}">

                    <p class="h5 text-secondary" style="font-size: 42px;font-weight: bolder;">{{Helpers::translate('The effort is on us and the profits are yours')}}</p>


                    <div class="w-100 text-center justify-content-center d-flex mb-3">
                        <h5 class="mt-5 w-75" data-aos="zoom-in" data-aos-duration="1500" style="line-height: 35px;font-weight: bold">
                            {{\App\CPU\Helpers::translate('We provide electronic store owners with products at a wholesale price without capital to start with the storage, shipping and packaging feature')}}
                        </h5>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button data-aos="flip-up" data-aos-duration="1500" class="col-lg-2 w-100 btn btn-primary border-0 p-0">
                            <a href="{{route('customer.auth.register')}}" class="fs-18 w-100 btn text-white font-weight-bolder px-0">
                                {{\App\CPU\Helpers::translate('sing_up')}}
                            </a>
                        </button>
                        <div class="p-2"></div>
                        <button data-aos="flip-down" data-aos-duration="1500" class="col-lg-2 w-100 btn btn-light border-0 p-0">
                            <a href="{{route('customer.auth.login')}}" class="fs-18 w-100 btn text-dark font-weight-bolder px-0">
                                {{\App\CPU\Helpers::translate('login')}}
                            </a>
                        </button>
                    </div>
                    <div class="d-flex justify-content-center">
                        <img src="{{asset('/public/assets/landing/img/heading4.png')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
