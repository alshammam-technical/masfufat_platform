@extends('layouts.front-end.app')

@section('title',\App\CPU\Helpers::translate('FAQ'))

@push('css_or_js')
    <meta property="og:image" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="og:title" content="FAQ of {{$web_config['name']->value}} "/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    <meta property="twitter:card" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="twitter:title" content="FAQ of {{$web_config['name']->value}}"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    <style>
        .headerTitle {
            font-size: 25px;
            font-weight: 700;
            margin-top: 2rem;
        }

        body {
            font-family: 'Titillium Web', sans-serif
        }

        .product-qty span {
            font-size: 14px;
            color: #6A6A6A;
        }

        .btn-link {
            color: #4c5056e3;
        }

        .btnF {
            display: inline-block;
            font-weight: normal;
            margin-top: 4%;
            color: #4b566b;
            text-align: center;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-color: transparent;
            border: 1px solid transparent;
            font-size: .9375rem;
            transition: color 0.25s ease-in-out, background-color 0.25s ease-in-out, border-color 0.25s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        @media (max-width: 600px) {
            .sidebar_heading {
                background: {{$web_config['primary_color']}}
            }

            .sidebar_heading h1 {
                text-align: center;
                color: aliceblue;
                padding-bottom: 17px;
                font-size: 19px;
            }

            .headerTitle {

                font-weight: 700;
                margin-top: 1rem;
            }
        }

    </style>
@endpush

@section('content')
    <!-- Page Title-->
    <div class="container rtl">
        <div class="row">
            <div class="col-md-12 sidebar_heading text-start mb-2">
                <h1 class="h3  mb-0 folot-left headerTitle">{{\App\CPU\Helpers::translate('frequently_asked_question')}}</h1>
            </div>
        </div>
        <hr>
    </div>

    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4 mt-3 rtl">
        <div class="row">   <!-- Sidebar-->
            <section class="col-12 mt-3">
                <section class="container pt-4 pb-5mx-0 mx-0">
                    <div class="row pt-0 bg-white">
                        <div class="col-12">
                            <ul class="list-unstyled">
                                @php $length=count($helps); @endphp
                                @php if($length%2!=0){$first=($length+1)/2;}else{$first=$length/2;}@endphp
                                @for($i=0;$i<$first;$i++)
                                    <div>
                                        <div class="card-header p-1 tx-medium my-auto tx-white bg-primary">
                                            <div class="d-flex btn text-white w-full" onclick="$(this).closest('.card-header').next('.foldable-section').slideToggle();$(this).closest('.card-header').find('.toggleAngle').toggle()">
                                                <h4 class="ml-2 mr-2 pt-2 text-white">
                                                    <i class="fa fa-angle-down toggleAngle" style=""></i>
                                                    <i class="fa fa-angle-up toggleAngle" style="display:none"></i>
                                                </h4>
                                                <h5 class="mt-2 text-white">{{ $helps[$i]['question'] }}</h5>
                                            </div>
                                        </div>
                                        <div id="collapseTwo{{ $helps[$i]['id'] }}" class="foldable-section"
                                        style="display: none;text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}"
                                        dir="{{(session()->get('direction') == 'ltr') ? 'ltr' : 'rtl'}}">
                                            <div class="card-body">
                                                <textarea readonly class="form-control border-0 w-full bg-white" cols="5" rows="5">{{ $helps[$i]['answer'] }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                @endfor
                                @for($i=$first;$i<$length;$i++)
                                    <div>
                                        <div class="card-header p-1 tx-medium my-auto tx-white bg-primary">
                                            <div class="d-flex btn text-white w-full" onclick="$(this).closest('.card-header').next('.foldable-section').slideToggle();$(this).closest('.card-header').find('.toggleAngle').toggle()">
                                                <h4 class="ml-2 mr-2 pt-2 text-white">
                                                    <i class="fa fa-angle-down toggleAngle" style=""></i>
                                                    <i class="fa fa-angle-up toggleAngle" style="display:none"></i>
                                                </h4>
                                                <h5 class="mt-2 text-white">{{ $helps[$i]['question'] }}</h5>
                                            </div>
                                        </div>
                                        <div id="collapseTwo{{ $helps[$i]['id'] }}" class="foldable-section"
                                        style="display: none;text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}"
                                        dir="{{(session()->get('direction') == 'ltr') ? 'ltr' : 'rtl'}}">
                                            <div class="card-body">
                                                <textarea readonly class="form-control border-0 w-full bg-white" cols="5" rows="5">{{ $helps[$i]['answer'] }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                @endfor

                            </ul>
                        </div>

                    </div>
                </section>
            </section>
        </div>
    </div>
@endsection


