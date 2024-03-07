@extends('layouts.front-end.app')
@php($storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id())
@php($user = \App\User::find($storeId))
@section('title',$user->f_name.' '.$user->l_name)

@push('css_or_js')
<title>{{ Helpers::translate('my account data') }}</title>
    <style>
        .leaflet-image-layer, .leaflet-layer, .leaflet-marker-icon, .leaflet-marker-shadow, .leaflet-pane, .leaflet-pane>canvas, .leaflet-pane>svg, .leaflet-tile, .leaflet-tile-container, .leaflet-zoom-box{
            top: 42px;
        }
    </style>
    <style>
        .headerTitle {
            font-size: 24px;
            font-weight: 600;
            margin-top: 1rem;
        }

        label{
            font-weight: bold;
        }

        .border:hover {
            border: 3px solid{{$web_config['primary_color']}};
            margin-bottom: 5px;
            margin-top: -6px;
        }

        body {
            font-family: 'Titillium Web', sans-serif
        }


        .footer span {
            font-size: 12px
        }

        .product-qty span {
            font-size: 12px;
            color: #6A6A6A;
        }

        .spandHeadO {
            color: {{$web_config['primary_color']}};
            font-weight: 400;
            font-size: 13px;

        }

        .spandHeadO:hover {
            color: {{$web_config['primary_color']}};
            font-weight: 400;
            font-size: 13px;

        }

        .font-name {
            font-weight: 600;
            margin-top: 0px !important;
            margin-bottom: 0;
            font-size: 15px;
            color: #030303;
        }

        .font-nameA {
            font-weight: 600;
            margin-top: 0px;
            margin-bottom: 7px !important;
            font-size: 17px;
            color: #030303;
        }

        label {
            font-size: 16px;
        }

        .photoHeader {
            margin- {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}: 1rem;
            margin- {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'left' : 'right'}}: 2rem;
            padding: 13px;
        }

        .card-header {
            border-bottom: none;
        }

        .sidebarL h3:hover + .divider-role {
            border-bottom: 3px solid {{$web_config['primary_color']}}          !important;
            transition: .2s ease-in-out;
        }

        @media (max-width: 350px) {

            .photoHeader {
                margin-left: 0.1px !important;
                margin-right: 0.1px !important;
                padding: 0.1px !important;

            }
        }

        @media (max-width: 600px) {
            .sidebar_heading {
                background: {{$web_config['primary_color']}};
            }

            .sidebar_heading h1 {
                text-align: center;
                color: aliceblue;
                padding-bottom: 17px;
                font-size: 19px;
            }

            .photoHeader {
                /*margin-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}: 2px !important;
                margin-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'left' : 'right'}}: 1px !important;*/
                padding: 13px;
            }
        }
    </style>
    <style>

        .leaflet-image-layer,.leaflet-layer,.leaflet-marker-icon,.leaflet-marker-shadow,.leaflet-pane,.leaflet-pane>canvas,.leaflet-pane>svg,.leaflet-tile,.leaflet-tile-container,.leaflet-zoom-box {
            position: absolute;
            left: 0;
            top: 0
        }

        .leaflet-container {
            overflow: hidden
        }

        .leaflet-marker-icon,.leaflet-marker-shadow,.leaflet-tile {
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
            -webkit-user-drag: none
        }

        .leaflet-tile::selection {
            background: 0 0
        }

        .leaflet-safari .leaflet-tile {
            image-rendering: -webkit-optimize-contrast
        }

        .leaflet-safari .leaflet-tile-container {
            width: 1600px;
            height: 1600px;
            -webkit-transform-origin: 0 0
        }

        .leaflet-marker-icon,.leaflet-marker-shadow {
            display: block
        }

        .leaflet-container .leaflet-marker-pane img,.leaflet-container .leaflet-overlay-pane svg,.leaflet-container .leaflet-shadow-pane img,.leaflet-container .leaflet-tile,.leaflet-container .leaflet-tile-pane img,.leaflet-container img.leaflet-image-layer {
            max-width: none!important;
            max-height: none!important
        }

        .leaflet-container.leaflet-touch-zoom {
            -ms-touch-action: pan-x pan-y;
            touch-action: pan-x pan-y
        }

        .leaflet-container.leaflet-touch-drag {
            -ms-touch-action: pinch-zoom;
            touch-action: none;
            touch-action: pinch-zoom
        }

        .leaflet-container.leaflet-touch-drag.leaflet-touch-zoom {
            -ms-touch-action: none;
            touch-action: none
        }

        .leaflet-container {
            -webkit-tap-highlight-color: transparent
        }

        .leaflet-container a {
            -webkit-tap-highlight-color: rgba(51,181,229,.4)
        }

        .leaflet-tile {
            filter: inherit;
            visibility: hidden
        }

        .leaflet-tile-loaded {
            visibility: inherit
        }

        .leaflet-zoom-box {
            width: 0;
            height: 0;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            z-index: 800
        }

        .leaflet-overlay-pane svg {
            -moz-user-select: none
        }

        .leaflet-pane {
            z-index: 400
        }

        .leaflet-tile-pane {
            z-index: 200
        }

        .leaflet-overlay-pane {
            z-index: 400
        }

        .leaflet-shadow-pane {
            z-index: 500
        }

        .leaflet-marker-pane {
            z-index: 600
        }

        .leaflet-tooltip-pane {
            z-index: 650
        }

        .leaflet-popup-pane {
            z-index: 700
        }

        .leaflet-map-pane canvas {
            z-index: 100
        }

        .leaflet-map-pane svg {
            z-index: 200
        }

        .leaflet-vml-shape {
            width: 1px;
            height: 1px
        }

        .lvml {
            behavior: url(#default#VML);
            display: inline-block;
            position: absolute
        }

        .leaflet-control {
            position: relative;
            z-index: 800;
            pointer-events: visiblePainted;
            pointer-events: auto
        }

        .leaflet-bottom,.leaflet-top {
            position: absolute;
            z-index: 1000;
            pointer-events: none
        }

        .leaflet-top {
            top: 0
        }

        .leaflet-right {
            right: 0
        }

        .leaflet-bottom {
            bottom: 0
        }

        .leaflet-left {
            left: 0
        }

        .leaflet-control {
            float: left;
            clear: both
        }

        .leaflet-right .leaflet-control {
            float: right
        }

        .leaflet-top .leaflet-control {
            margin-top: 10px
        }

        .leaflet-bottom .leaflet-control {
            margin-bottom: 10px
        }

        .leaflet-left .leaflet-control {
            margin-left: 10px
        }

        .leaflet-right .leaflet-control {
            margin-right: 10px
        }

        .leaflet-fade-anim .leaflet-tile {
            will-change: opacity
        }

        .leaflet-fade-anim .leaflet-popup {
            opacity: 0;
            -webkit-transition: opacity .2s linear;
            -moz-transition: opacity .2s linear;
            transition: opacity .2s linear
        }

        .leaflet-fade-anim .leaflet-map-pane .leaflet-popup {
            opacity: 1
        }

        .leaflet-zoom-animated {
            -webkit-transform-origin: 0 0;
            -ms-transform-origin: 0 0;
            transform-origin: 0 0
        }

        .leaflet-zoom-anim .leaflet-zoom-animated {
            will-change: transform
        }

        .leaflet-zoom-anim .leaflet-zoom-animated {
            -webkit-transition: -webkit-transform .25s cubic-bezier(0,0,.25,1);
            -moz-transition: -moz-transform .25s cubic-bezier(0,0,.25,1);
            transition: transform .25s cubic-bezier(0,0,.25,1)
        }

        .leaflet-pan-anim .leaflet-tile,.leaflet-zoom-anim .leaflet-tile {
            -webkit-transition: none;
            -moz-transition: none;
            transition: none
        }

        .leaflet-zoom-anim .leaflet-zoom-hide {
            visibility: hidden
        }

        .leaflet-interactive {
            cursor: pointer
        }

        .leaflet-grab {
            cursor: -webkit-grab;
            cursor: -moz-grab;
            cursor: grab
        }

        .leaflet-crosshair,.leaflet-crosshair .leaflet-interactive {
            cursor: crosshair
        }

        .leaflet-control,.leaflet-popup-pane {
            cursor: auto
        }

        .leaflet-dragging .leaflet-grab,.leaflet-dragging .leaflet-grab .leaflet-interactive,.leaflet-dragging .leaflet-marker-draggable {
            cursor: move;
            cursor: -webkit-grabbing;
            cursor: -moz-grabbing;
            cursor: grabbing
        }

        .leaflet-image-layer,.leaflet-marker-icon,.leaflet-marker-shadow,.leaflet-pane>svg path,.leaflet-tile-container {
            pointer-events: none
        }

        .leaflet-image-layer.leaflet-interactive,.leaflet-marker-icon.leaflet-interactive,.leaflet-pane>svg path.leaflet-interactive,svg.leaflet-image-layer.leaflet-interactive path {
            pointer-events: visiblePainted;
            pointer-events: auto
        }

        .leaflet-container {
            background: #ddd;
            outline: 0
        }

        .leaflet-container a {
            color: #0078a8
        }

        .leaflet-container a.leaflet-active {
            outline: 2px solid orange
        }

        .leaflet-zoom-box {
            border: 2px dotted #38f;
            background: rgba(255,255,255,.5)
        }

        .leaflet-container {
            font: 12px/1.5 "Helvetica Neue",Arial,Helvetica,sans-serif
        }

        .leaflet-bar {
            box-shadow: 0 1px 5px rgba(0,0,0,.65);
            border-radius: 4px
        }

        .leaflet-bar a,.leaflet-bar a:hover {
            background-color: #fff;
            border-bottom: 1px solid #ccc;
            width: 26px;
            height: 26px;
            line-height: 26px;
            display: block;
            text-align: center;
            text-decoration: none;
            color: #000
        }

        .leaflet-bar a,.leaflet-control-layers-toggle {
            background-position: 50% 50%;
            background-repeat: no-repeat;
            display: block
        }

        .leaflet-bar a:hover {
            background-color: #f4f4f4
        }

        .leaflet-bar a:first-child {
            border-top-left-radius: 4px;
            border-top-right-radius: 4px
        }

        .leaflet-bar a:last-child {
            border-bottom-left-radius: 4px;
            border-bottom-right-radius: 4px;
            border-bottom: none
        }

        .leaflet-bar a.leaflet-disabled {
            cursor: default;
            background-color: #f4f4f4;
            color: #bbb
        }

        .leaflet-touch .leaflet-bar a {
            width: 30px;
            height: 30px;
            line-height: 30px
        }

        .leaflet-touch .leaflet-bar a:first-child {
            border-top-left-radius: 2px;
            border-top-right-radius: 2px
        }

        .leaflet-touch .leaflet-bar a:last-child {
            border-bottom-left-radius: 2px;
            border-bottom-right-radius: 2px
        }

        .leaflet-control-zoom-in,.leaflet-control-zoom-out {
            font: bold 18px 'Lucida Console',Monaco,monospace;
            text-indent: 1px
        }

        .leaflet-touch .leaflet-control-zoom-in,.leaflet-touch .leaflet-control-zoom-out {
            font-size: 22px
        }

        .leaflet-control-layers {
            box-shadow: 0 1px 5px rgba(0,0,0,.4);
            background: #fff;
            border-radius: 5px
        }

        .leaflet-control-layers-toggle {
            background-image: url(images/layers.html);
            width: 36px;
            height: 36px
        }

        .leaflet-retina .leaflet-control-layers-toggle {
            background-image: url(images/layers-2x.html);
            background-size: 26px 26px
        }

        .leaflet-touch .leaflet-control-layers-toggle {
            width: 44px;
            height: 44px
        }

        .leaflet-control-layers .leaflet-control-layers-list,.leaflet-control-layers-expanded .leaflet-control-layers-toggle {
            display: none
        }

        .leaflet-control-layers-expanded .leaflet-control-layers-list {
            display: block;
            position: relative
        }

        .leaflet-control-layers-expanded {
            padding: 6px 10px 6px 6px;
            color: #333;
            background: #fff
        }

        .leaflet-control-layers-scrollbar {
            overflow-y: scroll;
            overflow-x: hidden;
            padding-right: 5px
        }

        .leaflet-control-layers-selector {
            margin-top: 2px;
            position: relative;
            top: 1px
        }

        .leaflet-control-layers label {
            display: block
        }

        .leaflet-control-layers-separator {
            height: 0;
            border-top: 1px solid #ddd;
            margin: 5px -10px 5px -6px
        }

        .leaflet-default-icon-path {
            background-image: url(images/marker-icon.html)
        }

        .leaflet-container .leaflet-control-attribution {
            background: #fff;
            background: rgba(255,255,255,.7);
            margin: 0
        }

        .leaflet-control-attribution,.leaflet-control-scale-line {
            padding: 0 5px;
            color: #333
        }

        .leaflet-control-attribution a {
            text-decoration: none
        }

        .leaflet-control-attribution a:hover {
            text-decoration: underline
        }

        .leaflet-container .leaflet-control-attribution,.leaflet-container .leaflet-control-scale {
            font-size: 11px
        }

        .leaflet-left .leaflet-control-scale {
            margin-left: 5px
        }

        .leaflet-bottom .leaflet-control-scale {
            margin-bottom: 5px
        }

        .leaflet-control-scale-line {
            border: 2px solid #777;
            border-top: none;
            line-height: 1.1;
            padding: 2px 5px 1px;
            font-size: 11px;
            white-space: nowrap;
            overflow: hidden;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            background: #fff;
            background: rgba(255,255,255,.5)
        }

        .leaflet-control-scale-line:not(:first-child) {
            border-top: 2px solid #777;
            border-bottom: none;
            margin-top: -2px
        }

        .leaflet-control-scale-line:not(:first-child):not(:last-child) {
            border-bottom: 2px solid #777
        }

        .leaflet-touch .leaflet-bar,.leaflet-touch .leaflet-control-attribution,.leaflet-touch .leaflet-control-layers {
            box-shadow: none
        }

        .leaflet-touch .leaflet-bar,.leaflet-touch .leaflet-control-layers {
            border: 2px solid rgba(0,0,0,.2);
            background-clip: padding-box
        }

        .leaflet-popup {
            position: absolute;
            text-align: center;
            margin-bottom: 20px
        }

        .leaflet-popup-content-wrapper {
            padding: 1px;
            text-align: left;
            border-radius: 12px
        }

        .leaflet-popup-content {
            margin: 13px 19px;
            line-height: 1.4
        }

        .leaflet-popup-content p {
            margin: 18px 0
        }

        .leaflet-popup-tip-container {
            width: 40px;
            height: 20px;
            position: absolute;
            left: 50%;
            margin-left: -20px;
            overflow: hidden;
            pointer-events: none
        }

        .leaflet-popup-tip {
            width: 17px;
            height: 17px;
            padding: 1px;
            margin: -10px auto 0;
            -webkit-transform: rotate(45deg);
            -moz-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg)
        }

        .leaflet-popup-content-wrapper,.leaflet-popup-tip {
            background: #fff;
            color: #333;
            box-shadow: 0 3px 14px rgba(0,0,0,.4)
        }

        .leaflet-container a.leaflet-popup-close-button {
            position: absolute;
            top: 0;
            right: 0;
            padding: 4px 4px 0 0;
            border: none;
            text-align: center;
            width: 18px;
            height: 14px;
            font: 16px/14px Tahoma,Verdana,sans-serif;
            color: #c3c3c3;
            text-decoration: none;
            font-weight: 700;
            background: 0 0
        }

        .leaflet-container a.leaflet-popup-close-button:hover {
            color: #999
        }

        .leaflet-popup-scrolled {
            overflow: auto;
            border-bottom: 1px solid #ddd;
            border-top: 1px solid #ddd
        }

        .leaflet-oldie .leaflet-popup-content-wrapper {
            -ms-zoom:1}

        .leaflet-oldie .leaflet-popup-tip {
            width: 24px;
            margin: 0 auto
        }

        .leaflet-oldie .leaflet-popup-tip-container {
            margin-top: -1px
        }

        .leaflet-oldie .leaflet-control-layers,.leaflet-oldie .leaflet-control-zoom,.leaflet-oldie .leaflet-popup-content-wrapper,.leaflet-oldie .leaflet-popup-tip {
            border: 1px solid #999
        }

        .leaflet-div-icon {
            background: #fff;
            border: 1px solid #666
        }

        .leaflet-tooltip {
            position: absolute;
            padding: 6px;
            background-color: #fff;
            border: 1px solid #fff;
            border-radius: 3px;
            color: #222;
            white-space: nowrap;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            pointer-events: none;
            box-shadow: 0 1px 3px rgba(0,0,0,.4)
        }

        .leaflet-tooltip.leaflet-clickable {
            cursor: pointer;
            pointer-events: auto
        }

        .leaflet-tooltip-bottom:before,.leaflet-tooltip-left:before,.leaflet-tooltip-right:before,.leaflet-tooltip-top:before {
            position: absolute;
            pointer-events: none;
            border: 6px solid transparent;
            background: 0 0;
            content: ""
        }

        .leaflet-tooltip-bottom {
            margin-top: 6px
        }

        .leaflet-tooltip-top {
            margin-top: -6px
        }

        .leaflet-tooltip-bottom:before,.leaflet-tooltip-top:before {
            left: 50%;
            margin-left: -6px
        }

        .leaflet-tooltip-top:before {
            bottom: 0;
            margin-bottom: -12px;
            border-top-color: #fff
        }

        .leaflet-tooltip-bottom:before {
            top: 0;
            margin-top: -12px;
            margin-left: -6px;
            border-bottom-color: #fff
        }

        .leaflet-tooltip-left {
            margin-left: -6px
        }

        .leaflet-tooltip-right {
            margin-left: 6px
        }

        .leaflet-tooltip-left:before,.leaflet-tooltip-right:before {
            top: 50%;
            margin-top: -6px
        }

        .leaflet-tooltip-left:before {
            right: 0;
            margin-right: -12px;
            border-left-color: #fff
        }

        .leaflet-tooltip-right:before {
            left: 0;
            margin-left: -12px;
            border-right-color: #fff
        }

    </style>
@endpush

@section('content')

    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4 mt-3 rtl"
         style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <!-- Sidebar-->

        <!-- Content  -->
            <section class="col-lg-12 col-md-12">
                <div class="card box-shadow-sm">
                    <div class="card-body bg-light">
                        <div class="mt-3">
                            @php($store = $customerDetail->store_informations)
                            @php($customer = $customerDetail)
                            {{--    --}}
                            <div>
                                @isset($customer)
                                @if(!isset($new) && !isset($profile))
                                @if($customer['is_active'] == 2)
                                <div class="flex-start">
                                    <div><h4>{{\App\CPU\Helpers::translate('Status')}} : </h4></div>
                                    <div class="mx-1">
                                        <h4>{!! ($customer['is_active'] ?? '')=='1'?'<label class="badge badge-success">'. Helpers::translate('Active_') .'</label>':'<label class="badge badge-danger">'. Helpers::translate('Rejected') .'</label>' !!}</h4>
                                    </div>
                                </div>
                                @else
                                <div class="flex-start">
                                    <div><h4>{{\App\CPU\Helpers::translate('Status')}} : </h4></div>
                                    <div class="mx-1">
                                        <h4>{!! ($customer['is_active'] ?? '')=='1'?'<label class="badge badge-success">'. Helpers::translate('Active_') .'</label>':'<label class="badge badge-danger">'. Helpers::translate('In-Active') .'</label>' !!}</h4>
                                    </div>
                                </div>
                                @endif
                                @endif
                                @endisset




                                <div class="row">
                                    @if (!isset($new) && !isset($profile))
                                    <div class="mb-4 col-lg-6">
                                        <div class="form-group">
                                            <label>{{\App\CPU\Helpers::translate('Store Account number')}} : </label>
                                            <p>
                                                {{($store['vendor_account_number'] ?? '')}}
                                            </p>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="mb-4 col-lg-6">
                                        <div class="form-group">
                                            <label>{{\App\CPU\Helpers::translate('company_name')}} : </label>
                                            <p>
                                                {{($store['company_name'] ?? '')}}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="form-group mb-4 col-lg-6">
                                        <label>{{\App\CPU\Helpers::translate('license_owners_name')}}: </label>
                                        <p>
                                            {{ ($customer->is_store ?? null) ? $store['name'] ?? '' : $customer['name'] ?? ''}}
                                        </p>
                                    </div>

                                    <div class="form-group mb-4 col-lg-6">
                                        <label>{{\App\CPU\Helpers::translate('license owners phone')}}: </label>
                                        <p>
                                            {{$customer['phone']}}
                                        </p>
                                    </div>
                                </div>
                                @if (auth('customer')->check())
                                <form class="row" action="{{route('user-update')}}" method="post" enctype="multipart/form-data">
                                    <div class="mb-0 col-lg-6">
                                        <div class="form-group">
                                            <label>{{\App\CPU\Helpers::translate('Email')}} : </label>
                                            @csrf
                                            <input tabindex="4" readonly onfocus="$(this).removeAttr('readonly')" name="email" class="form-control" autocomplete="off" value="{{($customer['email'] ?? '')}}" />
                                        </div>
                                    </div>
                                    <div class="mb-0 col-lg-6"></div>
                                    <div class="mb-0 col-lg-6">
                                        <div class="form-group">
                                            <label>{{\App\CPU\Helpers::translate('Password')}} : </label>
                                            <div class="password-toggle">
                                                <input tabindex="5" readonly onfocus="$(this).removeAttr('readonly')" class="form-control" name="password" type="password" id="si-password"
                                                    style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};"
                                                    required>
                                                <label class="password-toggle-btn">
                                                    <input class="custom-control-input" type="checkbox"><i
                                                        class="czi-eye password-toggle-indicator"></i><span
                                                        class="sr-only">{{\App\CPU\Helpers::translate('Show password')}} </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-0 col-lg-6">
                                        <div class="form-group">
                                            <label>{{\App\CPU\Helpers::translate('repeat_password')}} : </label>
                                            <div class="password-toggle">
                                                <input tabindex="5" readonly onfocus="$(this).removeAttr('readonly')" class="form-control" name="password_confirmation" type="password" id="si-password"
                                                    style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};"
                                                    required>
                                                <label class="password-toggle-btn">
                                                    <input class="custom-control-input" type="checkbox"><i
                                                        class="czi-eye password-toggle-indicator"></i><span
                                                        class="sr-only">{{\App\CPU\Helpers::translate('Show password')}} </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @if (\App\CPU\Helpers::store_module_permission_check('my_account.data.update'))
                                    <div class="row justify-content-end pe-0">
                                        <div class="col-12 text-end pe-0">
                                            <button type="submit" class="btn bg-primaryColor btn-primary btn-save px-4">{{ \App\CPU\Helpers::translate('update')}}</button>
                                        </div>
                                    </div>
                                    @endif
                                </form>
                                @else


                                <form class="row" action="{{route('delegate-update')}}" method="post" enctype="multipart/form-data">
                                    <div class="mb-0 col-lg-6">
                                        <div class="form-group">
                                            <label>{{\App\CPU\Helpers::translate('Email')}} : </label>
                                            @csrf
                                            <input tabindex="4" readonly onfocus="$(this).removeAttr('readonly')" name="email" class="form-control" autocomplete="off" value="{{ auth('delegatestore')->user()->email}}" />
                                        </div>
                                    </div>
                                    <div class="mb-0 col-lg-6"></div>
                                    <div class="mb-0 col-lg-6">
                                        <div class="form-group">
                                            <label>{{\App\CPU\Helpers::translate('Password')}} : </label>
                                            <div class="password-toggle">
                                                <input tabindex="5" readonly onfocus="$(this).removeAttr('readonly')" class="form-control" name="password" type="password" id="si-password"
                                                    style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};"
                                                    required>
                                                <label class="password-toggle-btn">
                                                    <input class="custom-control-input" type="checkbox"><i
                                                        class="czi-eye password-toggle-indicator"></i><span
                                                        class="sr-only">{{\App\CPU\Helpers::translate('Show password')}} </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-0 col-lg-6">
                                        <div class="form-group">
                                            <label>{{\App\CPU\Helpers::translate('repeat_password')}} : </label>
                                            <div class="password-toggle">
                                                <input tabindex="5" readonly onfocus="$(this).removeAttr('readonly')" class="form-control" name="password_confirmation" type="password" id="si-password"
                                                    style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};"
                                                    required>
                                                <label class="password-toggle-btn">
                                                    <input class="custom-control-input" type="checkbox"><i
                                                        class="czi-eye password-toggle-indicator"></i><span
                                                        class="sr-only">{{\App\CPU\Helpers::translate('Show password')}} </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-end pe-0">
                                        <div class="col-12 text-end pe-0">
                                            <button type="submit" class="btn bg-primaryColor btn-primary btn-save px-4">{{ \App\CPU\Helpers::translate('update')}}</button>
                                        </div>
                                    </div>
                                </form>
                                @endif


                                <div class="row">
                                    <div class=" mb-4 col-lg-6">
                                        <div class="form-group">
                                            <label>{{\App\CPU\Helpers::translate('delegates_name')}} : </label>
                                            <p>
                                                {{($store->ChiefCommissioner->name ?? '')}}
                                            </p>
                                        </div>
                                    </div>
                                    <div class=" mb-4 col-lg-6">
                                        <div class="form-group">
                                            <label>{{\App\CPU\Helpers::translate('delegates_phone')}} : </label>
                                            <p>
                                                {{$store->ChiefCommissioner->phone ?? ''}}
                                            </p>
                                        </div>
                                    </div>

                                    <div class=" mb-4 col-lg-6">
                                        <div class="form-group">
                                            <label>{{\App\CPU\Helpers::translate('commercial_registration_no')}} : </label>
                                            <p>
                                                {{$store['commercial_registration_no']}}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="@if (!isset($new))  mb-4 col-lg-6 @else  col-lg-4 @endif">
                                        <div class="form-group">
                                            <label>{{\App\CPU\Helpers::translate('tax number')}} : </label>
                                            {{$store['tax_no']}}
                                        </div>
                                    </div>



                                    @if (!isset($new))
                                    @if(\App\Model\BusinessSetting::where('type','pricing_levels')->first()->value ?? '')
                                    <div class=" mb-4 col-lg-6">
                                        <div class="form-group">
                                            <label>{{\App\CPU\Helpers::translate('pricing level')}} : </label>
                                            <p>
                                                {{ \App\CPU\Helpers::getTranslation('App\Model\pricing_levels',$store['pricing_level'],'name') }}
                                            </p>
                                        </div>
                                    </div>
                                    @endif
                                    @endif

                                    <div class=" mb-4 col-lg-6">
                                        <div class="form-group">
                                            <label>{{\App\CPU\Helpers::translate('governorate')}} : </label>
                                            <p>
                                                {{ \App\CPU\Helpers::getItemName('provinces','name',$store['governorate'] ?? null) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group p-0">
                                            <div class="mb-4">
                                                <div id="location_map_canvas"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row  mb-4 col-lg-6">
                                        <div class=" col-lg-6">
                                            <div class="form-group">
                                                <label>{{\App\CPU\Helpers::translate('Coordinates')}} - {{ Helpers::translate('longitude') }} : </label>
                                                <p>
                                                    {{($store['lon'] ?? '')}}
                                                </p>
                                            </div>
                                        </div>
                                        <div class=" col-lg-6">
                                            <div class="form-group">
                                                <label>{{\App\CPU\Helpers::translate('Coordinates')}} - {{ Helpers::translate('latitude') }} : </label>
                                                <p>
                                                    {{($store['lat'] ?? '')}}
                                                </p>
                                            </div>
                                        </div>
                                        <div class=" col-lg-12">
                                            <div class="form-group">
                                                <label>{{\App\CPU\Helpers::translate('address')}} : </label>
                                                <p>
                                                    {{$store['address'] ?? ''}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class=" mb-4 col-lg-6">
                                        <label>{{\App\CPU\Helpers::translate('Store Image')}} <span class="text-info">(Ratio 1:1)</span> : </label>

                                        <div class="form-group">
                                            <center>
                                                <img class="upload-img-view" id="viewer1"
                                                onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                src="{{asset('storage/app/public/user')}}/{{($store['image'] ?? '')}}"/>
                                            </center>
                                        </div>
                                    </div>

                                    <div class=" mb-4 col-lg-6">
                                        <label>
                                            {{\App\CPU\Helpers::translate('commercials_registrations_image')}}
                                        </label>

                                        <div class="form-group">
                                            <center>
                                                <img class="upload-img-view" id="viewer2"
                                                @if($store['commercial_registration_img'] ?? '')
                                                role="button"
                                                onclick="window.open('{{asset('storage/app/public/user')}}/{{($store['commercial_registration_img'] ?? '')}}')"
                                                @endif
                                                src="{{asset('storage/app/public/user')}}/{{($store['commercial_registration_img'] ?? '')}}" alt="banner image"
                                                onerror="this.src='{{($store['commercial_registration_img'] ?? '') ? asset('public/assets/front-end/img/download.png') : asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                />
                                            </center>
                                        </div>
                                    </div>



                                    <div class=" mb-4 col-lg-6">
                                        <label>
                                            {{\App\CPU\Helpers::translate('shop_tax_certificates_image')}}
                                        </label>

                                        <div class="form-group">
                                            <center>
                                                <img class="upload-img-view" id="viewer3"
                                                @if($store['tax_certificate_img'] ?? '')
                                                role="button"
                                                onclick="window.open('{{asset('storage/app/public/user')}}/{{($store['tax_certificate_img'] ?? '')}}')"
                                                @endif
                                                src="{{asset('storage/app/public/user')}}/{{($store['tax_certificate_img'] ?? '')}}" alt="banner image"
                                                onerror="this.src='{{($store['tax_certificate_img'] ?? '') ? asset('public/assets/front-end/img/download.png') : asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                />
                                            </center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--    --}}

                        </div>
                    </div>
                </div>
            </section>
        </div>
        @include('web-views.users-profile.account-address')
    </div>
@endsection

@push('script')
    <script src="{{asset('public/assets/front-end')}}/vendor/nouislider/distribute/nouislider.min.js"></script>
    <script src="{{asset('public/assets/back-end/js/croppie.js')}}"></script>
    {{--  map  --}}
    {{--  <script src="https://maps.googleapis.com/maps/api/js?key={{Helpers::get_business_settings('map_api_key')}}&libraries=places&v=3.49"></script>
    <script>
        @php($default_location = [])
        @php($default_location['lat'] = '23.8859')
        @php($default_location['lng'] = '45.0792')
        function initAutocomplete() {
            var myLatLng = { lat: {{$default_location?$default_location['lat']:'23.8859'}}, lng: {{$default_location?$default_location['lng']:'45.0792'}} };

            const map = new google.maps.Map(document.getElementById("location_map_canvas"), {
                center: { lat: {{$shipping_latitude??'23.8859'}}, lng: {{$shipping_longitude??'45.0792'}} },
                zoom: 13,
                mapTypeId: "roadmap",
            });

            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
            });

            marker.setMap( map );
            var geocoder = geocoder = new google.maps.Geocoder();
            google.maps.event.addListener(map, 'click', function (mapsMouseEvent) {
                var coordinates = JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2);
                var coordinates = JSON.parse(coordinates);
                var latlng = new google.maps.LatLng( coordinates['lat'], coordinates['lng'] ) ;
                marker.setPosition( latlng );
                map.panTo( latlng );

                document.getElementById('latitude').value = coordinates['lat'];
                document.getElementById('longitude').value = coordinates['lng'];

                geocoder.geocode({ 'latLng': latlng }, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[1]) {
                            document.getElementById('address').value = results[1].formatted_address;
                            console.log(results[1].formatted_address);
                        }
                    }
                });
            });

            // Create the search box and link it to the UI element.
            const input = document.getElementById("pac-input");
            const searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);
            // Bias the SearchBox results towards current map's viewport.
            map.addListener("bounds_changed", () => {
                searchBox.setBounds(map.getBounds());
            });
            let markers = [];
            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place.
            searchBox.addListener("places_changed", () => {
                const places = searchBox.getPlaces();

                if (places.length == 0) {
                return;
                }
                // Clear out the old markers.
                markers.forEach((marker) => {
                marker.setMap(null);
                });
                markers = [];
                // For each place, get the icon, name and location.
                const bounds = new google.maps.LatLngBounds();
                places.forEach((place) => {
                    if (!place.geometry || !place.geometry.location) {
                        console.log("Returned place contains no geometry");
                        return;
                    }
                    var mrkr = new google.maps.Marker({
                        map,
                        title: place.name,
                        position: place.geometry.location,
                    });

                    google.maps.event.addListener(mrkr, "click", function (event) {
                        document.getElementById('latitude').value = this.position.lat();
                        document.getElementById('longitude').value = this.position.lng();

                    });

                    markers.push(mrkr);

                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });
                map.fitBounds(bounds);
            });
        };
        $(document).on('ready', function () {
            initAutocomplete();

        });

        $(document).on("keydown", "input", function(e) {
          if (e.which==13) e.preventDefault();
        });
    </script>  --}}
    {{--  end map  --}}


    {{--  map  --}}
    <script src="https://maps.googleapis.com/maps/api/js?key={{Helpers::get_business_settings('map_api_key')}}&libraries=places"></script>
    <script>
          var myLatLng = { lat: 23.8859, lng: 45.0792 }; // Example coordinates for San Francisco

          var map = new google.maps.Map(document.getElementById('location_map_canvas'), {
            center: myLatLng,
            zoom: 8
          });

          var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: 'Hello World!'
          });

        function getCityName(lat, lng) {
            var latlng = new google.maps.LatLng(lat, lng);
            var geocoder = new google.maps.Geocoder();

            geocoder.geocode({
                'latLng': latlng
            }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        for (var i = 0; i < results[0].address_components.length; i++) {
                            var types = results[0].address_components[i].types;
                            for (var j = 0; j < types.length; j++) {
                                if (types[j] === 'locality' || types[j] === 'administrative_area_level_1' || types[j] === 'administrative_area_level_2') {
                                    console.log(results[0].address_components[i].long_name);
                                    return results[0].address_components[i].long_name;
                                }
                            }
                        }
                    }
                } else {
                    console.log('Geocoder failed due to: ' + status);
                }
            });
        }

        // Call the function with your desired coordinates
        var latitude = 23.8859;
        var longitude = 45.0792;
        getCityName(latitude, longitude);

      </script>
    {{--  end map  --}}
    <script>
        function checkPasswordMatch() {
            var password = $("#password").val();
            var confirmPassword = $("#confirm_password").val();
            $("#message").removeAttr("style");
            $("#message").html("");
            if (confirmPassword == "") {
                $("#message").attr("style", "color:black");
                $("#message").html("{{\App\CPU\Helpers::translate('Please ReType Password')}}");

            } else if (password == "") {
                $("#message").removeAttr("style");
                $("#message").html("");

            } else if (password != confirmPassword) {
                $("#message").html("{{\App\CPU\Helpers::translate('Passwords do not match')}}!");
                $("#message").attr("style", "color:red");
            } else if (confirmPassword.length <= 6) {
                $("#message").html("{{\App\CPU\Helpers::translate('password Must Be 6 Character')}}");
                $("#message").attr("style", "color:red");
            } else {

                $("#message").html("{{\App\CPU\Helpers::translate('Passwords match')}}.");
                $("#message").attr("style", "color:green");
            }

        }

        $(document).ready(function () {
            $("#confirm_password").keyup(checkPasswordMatch);

        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $("#files").change(function () {
            readURL(this);
        });

    </script>
    <script>
        function form_alert(id, message) {
            Swal.fire({
                title: '{{\App\CPU\Helpers::translate('Are you sure')}}?',
                text: message,
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'No',
                confirmButtonText: 'Yes',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $('#' + id).submit()
                }
            })
        }
    </script>

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer1').attr('src', e.target.result);
                    $('#viewer1').show();
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readURL_(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer2').attr('src', e.target.result);
                    $('#viewer2').show();
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readURL__(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer3').attr('src', e.target.result);
                    $('#viewer3').show();
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readURL___(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer4').attr('src', e.target.result);
                    $('#viewer4').show();
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileUpload1").change(function () {
            readURL(this);
        });

        $("#customFileUpload2").change(function () {
            readURL_(this);
        });

        $("#customFileUpload3").change(function () {
            readURL__(this);
        });

        $("#customFileUpload4").change(function () {
            readURL___(this);
        });
    </script>
@endpush
