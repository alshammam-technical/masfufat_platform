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
            padding- {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'left' : 'right'}}: 1.95rem;
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
<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
{{-- Owl Carousel --}}
<script src="{{asset('public/assets/front-end')}}/js/owl.carousel_.min.js"></script>
{{-- Owl Carousel --}}
{{--  aos  --}}
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<header class="{{session()->get('direction') ?? 'rtl'}} text-light landing" style="background-size:cover;padding-bottom:100px;background-repeat: no-repeat;padding-bottom:23rem">
    <!-- Topbar-->
    <div>
        <div class="navbar-expand-md w-full mx-0 text-center justify-content-center"  >
            <div class="container w-full mx-0 px-0" style="min-width: 100%">
                <div class="row w-full mx-0 sm:text-center" id="navbarCollapse"
                    style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">
                    <div class="col-lg-2">
                        @php($categories=\App\Model\Category::with(['childes.childes'])->where('position', 0)->priority()->paginate(11))
                        <a class="{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'md:ml-3' : 'md:mr-3'}} justify-center sm:block d-flex"
                        href="{{route('home')}}">
                            <img style="width:200px;"

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
                                        <div class="col-md-3 text-center d-lg-none d-md-none"><a class="text-white" href="#about-us-section">{{ Helpers::translate('About_Us') }}</a></div>
                                        <div class="col-md-3 text-center hidden sm:block"><a class="text-white" href="#about-us-section">{{ Helpers::translate('About_Us') }}</a></div>
                                        <div class="col-md-3 text-center"><a class="text-white" href="#features-section1">{{ Helpers::translate('Services') }}</a></div>
                                        <div class="col-md-3 text-center"><a class="text-white" href="#packages-section">{{ Helpers::translate('Packages') }}</a></div>
                                        <div class="col-md-3 text-center"><a class="text-white" href="{{route('contacts')}}">{{ Helpers::translate('Contact Us') }}</a></div>
                                    </div>

                                    <div class="col-md-5 hidden sm:block">
                                        <div class="justify-content-end gap-1 flex">
                                            <button   class="col-lg-4 w-full btn btn-primary border-0 p-0">
                                                <a href="{{route('customer.auth.register')}}" class="fs-18 w-full btn text-white font-weight-bolder px-0">
                                                    {{\App\CPU\Helpers::translate('sing_up')}}
                                                </a>
                                            </button>
                                            <div class="p-2"></div>
                                            <button   class="col-lg-4 w-full btn btn-light border-0 p-0">
                                                <a href="{{route('customer.auth.login')}}" class="text-md w-full btn text-dark font-weight-bolder px-0 text-wrap">
                                                    {{\App\CPU\Helpers::translate('login')}}
                                                </a>
                                            </button>

                                            {{--    --}}
                                            <div class="col-lg-3 btn text-center justify-content-center py-lg-0 py-sm-3 px-sm-0 px-lg-2">
                                                @php( $local = \App\CPU\Helpers::default_lang())
                                                <div
                                                    class="topbar-text dropdown disable-autohide  text-capitalize pt-3 text-center bg-secondary sm:w-full lg"
                                                    style="height:52px;background-color: #f1f1f1;border-radius: 11px">
                                                    <a class="topbar-link" href="#" data-toggle="dropdown">
                                                        @foreach(json_decode($language['value'],true) as $data)
                                                            @if($data['code']==$local)
                                                            <div class="d-flex">
                                                                <img class="{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'mx-2' : 'mx-2'}} wd-auto ht-20"
                                                                    src="{{asset('public/assets/front-end')}}/img/flags/{{$data['code']}}.png"
                                                                    alt="Eng">
                                                                {{$data['name']}}
                                                                <i class="dropdown-toggle mx-2"></i>
                                                            </div>
                                                            @endif
                                                        @endforeach
                                                    </a>
                                                    <ul class="bg-white dropdown-menu dropdown-menu-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}"
                                                        style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">
                                                        @foreach(json_decode($language['value'],true) as $key =>$data)
                                                            @if($data['status']==1)
                                                                <li onclick="alert_wait()">
                                                                    <a class="dropdown-item pb-1 d-flex" href="{{route('lang',[$data['code']])}}">
                                                                        <img class="{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'ml-2' : 'mr-2'}} wd-30 ht-20"
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
        </div>

        <div class="w-full pos-relative"
            style="
            text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">

            <div class="col-lg-1"></div>

            <div class="cloud-1"></div>
            <div class="cloud-2 hidden sm:block"></div>

            <div class="col-lg-12 justify-content-center d-flex sm:px-4 px-0">
                <div class="mt-5 text-center d-sm-block flex-shrink-0 w-full sm:w-3/4"
                href="{{route('home')}}">

                    <p class="h5 text-secondary" style="font-size: 42px;font-weight: bolder;">{{Helpers::translate('The effort is on us and the profits are yours')}}</p>


                    <div class="w-full text-center justify-content-center d-flex mb-3">
                        <h5 class="mt-5 w-75"   style="line-height: 35px;font-weight: bold">
                            {{\App\CPU\Helpers::translate('We provide electronic store owners with products at a wholesale price without capital to start with the storage, shipping and packaging feature')}}
                        </h5>
                    </div>
                    {{--  for mobile  --}}
                    <div class="flex sm:hidden justify-content-center flex-wrap">
                        <div class="col-6">
                            <button   class="w-full rounded-lg bg-yellow-400 border-0">
                                <a href="{{route('customer.auth.register')}}" class="row">
                                    <span class="col-8 text-xs text-wrap w-full btn text-white font-weight-bolder ps-2">{{\App\CPU\Helpers::translate('sing_up')}}</span>
                                    <span class="col-4">
                                        <svg width="67" height="68" viewBox="0 0 37 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g filter="url(#filter0_d_3895_23380)">
                                            <path d="M32.3134 11.027L31.9267 7.33366C31.3667 3.30699 29.54 1.66699 25.6334 1.66699H22.4867H20.5134H16.46H14.4867H11.2867C7.36669 1.66699 5.55335 3.30699 4.98002 7.37366L4.62002 11.0403C4.48669 12.467 4.87336 13.8537 5.71336 14.9337C6.72669 16.2537 8.28669 17.0003 10.02 17.0003C11.7 17.0003 13.3134 16.1603 14.3267 14.8137C15.2334 16.1603 16.78 17.0003 18.5 17.0003C20.22 17.0003 21.7267 16.2003 22.6467 14.867C23.6734 16.187 25.26 17.0003 26.9134 17.0003C28.6867 17.0003 30.2867 16.2137 31.2867 14.827C32.0867 13.7603 32.4467 12.4137 32.3134 11.027Z" fill="white"/>
                                            <path d="M17.6333 22.213C15.94 22.3863 14.66 23.8263 14.66 25.533V29.1863C14.66 29.5463 14.9533 29.8397 15.3133 29.8397H21.6733C22.0333 29.8397 22.3266 29.5463 22.3266 29.1863V25.9997C22.34 23.213 20.7 21.893 17.6333 22.213Z" fill="white"/>
                                            <path d="M30.9933 19.2001V23.1734C30.9933 26.8534 28.0067 29.8401 24.3267 29.8401C23.9667 29.8401 23.6733 29.5468 23.6733 29.1868V26.0001C23.6733 24.2934 23.1533 22.9601 22.14 22.0534C21.2467 21.2401 20.0333 20.8401 18.5267 20.8401C18.1933 20.8401 17.86 20.8534 17.5 20.8934C15.1267 21.1334 13.3267 23.1334 13.3267 25.5334V29.1868C13.3267 29.5468 13.0333 29.8401 12.6733 29.8401C8.99332 29.8401 6.00665 26.8534 6.00665 23.1734V19.2268C6.00665 18.2934 6.92665 17.6668 7.79332 17.9734C8.15332 18.0934 8.51332 18.1868 8.88665 18.2401C9.04665 18.2668 9.21999 18.2934 9.37999 18.2934C9.59332 18.3201 9.80665 18.3334 10.02 18.3334C11.5667 18.3334 13.0867 17.7601 14.2867 16.7734C15.4333 17.7601 16.9267 18.3334 18.5 18.3334C20.0867 18.3334 21.5533 17.7868 22.7 16.8001C23.9 17.7734 25.3933 18.3334 26.9133 18.3334C27.1533 18.3334 27.3933 18.3201 27.62 18.2934C27.78 18.2801 27.9267 18.2668 28.0733 18.2401C28.4867 18.1868 28.86 18.0668 29.2333 17.9468C30.1 17.6534 30.9933 18.2934 30.9933 19.2001Z" fill="white"/>
                                            </g>
                                            <defs>
                                            <filter id="filter0_d_3895_23380" x="0.594238" y="1.66699" width="35.7463" height="36.1729" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                            <feOffset dy="4"/>
                                            <feGaussianBlur stdDeviation="2"/>
                                            <feComposite in2="hardAlpha" operator="out"/>
                                            <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_3895_23380"/>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_3895_23380" result="shape"/>
                                            </filter>
                                            </defs>
                                        </svg>
                                    </span>
                                </a>
                            </button>
                        </div>
                        <div class="col-6">
                            <button
                            class="w-full rounded-lg bg-gray-100 p-0 border-solid border-2 border-gray-400">
                                <a href="{{route('customer.auth.login')}}" class="row">
                                    <span class="col-8 text-xs text-wrap w-full btn text-dark font-weight-bolder px-0">
                                        {{\App\CPU\Helpers::translate('login')}}
                                    </span>
                                    <span class="col-4">
                                        <svg width="67" height="68" viewBox="0 0 37 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g filter="url(#filter0_d_3895_23380)">
                                            <path d="M32.3134 11.027L31.9267 7.33366C31.3667 3.30699 29.54 1.66699 25.6334 1.66699H22.4867H20.5134H16.46H14.4867H11.2867C7.36669 1.66699 5.55335 3.30699 4.98002 7.37366L4.62002 11.0403C4.48669 12.467 4.87336 13.8537 5.71336 14.9337C6.72669 16.2537 8.28669 17.0003 10.02 17.0003C11.7 17.0003 13.3134 16.1603 14.3267 14.8137C15.2334 16.1603 16.78 17.0003 18.5 17.0003C20.22 17.0003 21.7267 16.2003 22.6467 14.867C23.6734 16.187 25.26 17.0003 26.9134 17.0003C28.6867 17.0003 30.2867 16.2137 31.2867 14.827C32.0867 13.7603 32.4467 12.4137 32.3134 11.027Z" fill="white"/>
                                            <path d="M17.6333 22.213C15.94 22.3863 14.66 23.8263 14.66 25.533V29.1863C14.66 29.5463 14.9533 29.8397 15.3133 29.8397H21.6733C22.0333 29.8397 22.3266 29.5463 22.3266 29.1863V25.9997C22.34 23.213 20.7 21.893 17.6333 22.213Z" fill="white"/>
                                            <path d="M30.9933 19.2001V23.1734C30.9933 26.8534 28.0067 29.8401 24.3267 29.8401C23.9667 29.8401 23.6733 29.5468 23.6733 29.1868V26.0001C23.6733 24.2934 23.1533 22.9601 22.14 22.0534C21.2467 21.2401 20.0333 20.8401 18.5267 20.8401C18.1933 20.8401 17.86 20.8534 17.5 20.8934C15.1267 21.1334 13.3267 23.1334 13.3267 25.5334V29.1868C13.3267 29.5468 13.0333 29.8401 12.6733 29.8401C8.99332 29.8401 6.00665 26.8534 6.00665 23.1734V19.2268C6.00665 18.2934 6.92665 17.6668 7.79332 17.9734C8.15332 18.0934 8.51332 18.1868 8.88665 18.2401C9.04665 18.2668 9.21999 18.2934 9.37999 18.2934C9.59332 18.3201 9.80665 18.3334 10.02 18.3334C11.5667 18.3334 13.0867 17.7601 14.2867 16.7734C15.4333 17.7601 16.9267 18.3334 18.5 18.3334C20.0867 18.3334 21.5533 17.7868 22.7 16.8001C23.9 17.7734 25.3933 18.3334 26.9133 18.3334C27.1533 18.3334 27.3933 18.3201 27.62 18.2934C27.78 18.2801 27.9267 18.2668 28.0733 18.2401C28.4867 18.1868 28.86 18.0668 29.2333 17.9468C30.1 17.6534 30.9933 18.2934 30.9933 19.2001Z" fill="white"/>
                                            </g>
                                            <defs>
                                            <filter id="filter0_d_3895_23380" x="0.594238" y="1.66699" width="35.7463" height="36.1729" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                            <feOffset dy="4"/>
                                            <feGaussianBlur stdDeviation="2"/>
                                            <feComposite in2="hardAlpha" operator="out"/>
                                            <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_3895_23380"/>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_3895_23380" result="shape"/>
                                            </filter>
                                            </defs>
                                        </svg>
                                    </span>
                                </a>
                            </button>
                        </div>
                        {{--    --}}
                        <div class="col-6 mt-2">
                            <button   class="w-full rounded-lg bg-primaryColor border-0">
                                <a href="{{route('shop.apply')}}" class="row">
                                    <span class="col-8 text-xs text-wrap w-full btn text-white font-weight-bolder ps-3">{{\App\CPU\Helpers::translate('Register a seller account')}}</span>
                                    <span class="col-4">
                                        <svg width="66" height="68" viewBox="0 0 36 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g filter="url(#filter0_d_3896_240762)">
                                            <path d="M14 2.66699C10.5067 2.66699 7.66669 5.50699 7.66669 9.00033C7.66669 12.427 10.3467 15.2003 13.84 15.3203C13.9467 15.307 14.0534 15.307 14.1334 15.3203C14.16 15.3203 14.1734 15.3203 14.2 15.3203C14.2134 15.3203 14.2134 15.3203 14.2267 15.3203C17.64 15.2003 20.32 12.427 20.3334 9.00033C20.3334 5.50699 17.4934 2.66699 14 2.66699Z" fill="white"/>
                                            <path d="M20.7733 18.8668C17.0533 16.3868 10.9867 16.3868 7.24001 18.8668C5.54668 20.0002 4.61334 21.5335 4.61334 23.1735C4.61334 24.8135 5.54668 26.3335 7.22668 27.4535C9.09334 28.7068 11.5467 29.3335 14 29.3335C16.4533 29.3335 18.9067 28.7068 20.7733 27.4535C22.4533 26.3202 23.3867 24.8002 23.3867 23.1468C23.3733 21.5068 22.4533 19.9868 20.7733 18.8668Z" fill="white"/>
                                            <path d="M28.6534 9.78713C28.8667 12.3738 27.0267 14.6405 24.48 14.9471C24.4667 14.9471 24.4667 14.9471 24.4534 14.9471H24.4134C24.3334 14.9471 24.2534 14.9471 24.1867 14.9738C22.8934 15.0405 21.7067 14.6271 20.8134 13.8671C22.1867 12.6405 22.9734 10.8005 22.8134 8.80046C22.72 7.72046 22.3467 6.73379 21.7867 5.89379C22.2934 5.64046 22.88 5.48046 23.48 5.42713C26.0934 5.20046 28.4267 7.14713 28.6534 9.78713Z" fill="white"/>
                                            <path d="M31.32 22.1199C31.2133 23.4132 30.3867 24.5332 29 25.2932C27.6667 26.0265 25.9867 26.3732 24.32 26.3332C25.28 25.4665 25.84 24.3865 25.9467 23.2399C26.08 21.5865 25.2933 19.9999 23.72 18.7332C22.8267 18.0265 21.7867 17.4665 20.6533 17.0532C23.6 16.1999 27.3067 16.7732 29.5867 18.6132C30.8133 19.5999 31.44 20.8399 31.32 22.1199Z" fill="white"/>
                                            </g>
                                            <defs>
                                            <filter id="filter0_d_3896_240762" x="-2" y="0" width="40" height="40" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                            <feOffset dy="4"/>
                                            <feGaussianBlur stdDeviation="2"/>
                                            <feComposite in2="hardAlpha" operator="out"/>
                                            <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_3896_240762"/>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_3896_240762" result="shape"/>
                                            </filter>
                                            </defs>
                                        </svg>
                                    </span>
                                </a>
                            </button>
                        </div>
                        <div class="col-6 mt-2">
                            <button
                            class="w-full rounded-lg bg-gray-100 p-0 border-solid border-2 border-gray-400">
                                <a href="{{route('seller.auth.login')}}" class="row">
                                    <span class="col-8 text-xs text-wrap w-full btn text-dark font-weight-bolder ps-2">
                                        {{\App\CPU\Helpers::translate('Seller login')}}
                                    </span>
                                    <span class="col-4">
                                        <svg width="66" height="68" viewBox="0 0 36 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g filter="url(#filter0_d_3896_240762)">
                                            <path d="M14 2.66699C10.5067 2.66699 7.66669 5.50699 7.66669 9.00033C7.66669 12.427 10.3467 15.2003 13.84 15.3203C13.9467 15.307 14.0534 15.307 14.1334 15.3203C14.16 15.3203 14.1734 15.3203 14.2 15.3203C14.2134 15.3203 14.2134 15.3203 14.2267 15.3203C17.64 15.2003 20.32 12.427 20.3334 9.00033C20.3334 5.50699 17.4934 2.66699 14 2.66699Z" fill="white"/>
                                            <path d="M20.7733 18.8668C17.0533 16.3868 10.9867 16.3868 7.24001 18.8668C5.54668 20.0002 4.61334 21.5335 4.61334 23.1735C4.61334 24.8135 5.54668 26.3335 7.22668 27.4535C9.09334 28.7068 11.5467 29.3335 14 29.3335C16.4533 29.3335 18.9067 28.7068 20.7733 27.4535C22.4533 26.3202 23.3867 24.8002 23.3867 23.1468C23.3733 21.5068 22.4533 19.9868 20.7733 18.8668Z" fill="white"/>
                                            <path d="M28.6534 9.78713C28.8667 12.3738 27.0267 14.6405 24.48 14.9471C24.4667 14.9471 24.4667 14.9471 24.4534 14.9471H24.4134C24.3334 14.9471 24.2534 14.9471 24.1867 14.9738C22.8934 15.0405 21.7067 14.6271 20.8134 13.8671C22.1867 12.6405 22.9734 10.8005 22.8134 8.80046C22.72 7.72046 22.3467 6.73379 21.7867 5.89379C22.2934 5.64046 22.88 5.48046 23.48 5.42713C26.0934 5.20046 28.4267 7.14713 28.6534 9.78713Z" fill="white"/>
                                            <path d="M31.32 22.1199C31.2133 23.4132 30.3867 24.5332 29 25.2932C27.6667 26.0265 25.9867 26.3732 24.32 26.3332C25.28 25.4665 25.84 24.3865 25.9467 23.2399C26.08 21.5865 25.2933 19.9999 23.72 18.7332C22.8267 18.0265 21.7867 17.4665 20.6533 17.0532C23.6 16.1999 27.3067 16.7732 29.5867 18.6132C30.8133 19.5999 31.44 20.8399 31.32 22.1199Z" fill="white"/>
                                            </g>
                                            <defs>
                                            <filter id="filter0_d_3896_240762" x="-2" y="0" width="40" height="40" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                            <feOffset dy="4"/>
                                            <feGaussianBlur stdDeviation="2"/>
                                            <feComposite in2="hardAlpha" operator="out"/>
                                            <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_3896_240762"/>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_3896_240762" result="shape"/>
                                            </filter>
                                            </defs>
                                        </svg>
                                    </span>
                                </a>
                            </button>
                        </div>
                    </div>
                    {{--    --}}
                    <div class="d-flex justify-content-center">
                        <img src="{{asset('/public/assets/landing/img/heading4.png')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
