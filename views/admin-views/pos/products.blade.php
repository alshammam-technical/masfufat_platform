@php($dir = session()->get('direction'))
<!--to make http ajax request to https-->
<!--    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">-->
<!-- Favicon -->
<link rel="shortcut icon" href="{{asset('/storage/app/public/company')}}/{{\App\Model\BusinessSetting::where(['type' => 'admin_fav_icon'])->pluck('value')[0]}}">
<!-- Font -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
<!-- CSS Implementing Plugins -->
<link rel="stylesheet" href="{{asset('public/assets/back-end')}}/css/vendor.min.css">
<link rel="stylesheet" href="{{asset('public/assets/back-end')}}/css/bootstrap.min.css">

<link rel="stylesheet" href="{{asset('/public/assets/lightslider/css/lightslider.min-'.$dir.'.css')}}">

{{-- light box --}}
<link rel="stylesheet" href="{{asset('public/css/lightbox.css')}}">
<link rel="stylesheet" href="{{asset('public/assets/back-end')}}/vendor/icon-set/style.css">

<link rel="stylesheet" href="{{asset('public/assets/back-end')}}/css/custom.css">
<link rel="stylesheet" href="{{asset('/public/assets/back-end/css/navigation.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- intlTelInput -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css" integrity="sha512-gxWow8Mo6q6pLa1XH/CcH8JyiSDEtiwJV78E+D+QP0EVasFs8wKXq16G8CLD4CJ2SnonHr4Lm/yY2fSI2+cbmw==" crossorigin="anonymous" referrerpolicy="no-referrer" />


<link rel="stylesheet" href="{{asset('public/assets/back-end')}}/vendor/icon-set/style.css">
<!-- CSS Front Template -->
<link rel="stylesheet" href="{{asset('public/assets/back-end')}}/css/theme.minc619.css?v=1.0">
<link rel="stylesheet" href="{{asset('public/assets/back-end')}}/css/style.css">

<link rel="apple-touch-icon" sizes="180x180"
        href="{{asset('storage/app/public/company')}}/{{$web_config['fav_icon']->value}}">
<link rel="icon" type="image/png" sizes="32x32"
        href="{{asset('storage/app/public/company')}}/{{$web_config['fav_icon']->value}}">


@if(Session::get('direction') === "rtl")
<link rel="stylesheet" href="{{asset('public/assets/back-end')}}/css/menurtl.css">
@endif
{{-- light box --}}
<link rel="stylesheet" href="{{asset('public/css/lightbox.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-print-2.2.3/cr-1.5.6/fh-3.2.4/kt-2.7.0/r-2.3.0/rr-1.2.8/sb-1.3.4/sl-1.4.0/sr-1.1.1/datatables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/dataTables.bulma.min.css"/>

{{--  aos  --}}
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<div class="card" dir="{{ $dir }}">
    <h5 class="p-3 m-0 bg-light text-start">{{\App\CPU\Helpers::translate('Product_Section')}}</h5>
    <div class="px-3 py-4 @if($hide_all) mx-3 @endif">
        <div class="row gy-1">
            <form class="col-sm-8 row" id="products_filter">
                <input type="hidden" name="hide_all" value="{{$hide_all}}">
                <div class="col-sm-6 px-1">
                    <div class="input-group d-flex justify-content-end h-100">
                        <select name="category_id" id="category" class="form-control SumoSelect-custom w-100" title="select category" onchange="$(this).closest('form').submit()">
                            <option value="">{{\App\CPU\Helpers::translate('All Categories')}}</option>
                            @foreach ($categories as $item)
                            <option value="{{$item->id}}" {{$category==$item->id?'selected':''}}>
                                {{\App\CPU\Helpers::getItemName('categories','name',$item->id)}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 px-1">
                    <div class="input-group d-flex justify-content-end h-100">
                        <select name="brand_id" id="brand" class="form-control SumoSelect-custom w-100" title="select brand" onchange="$(this).closest('form').submit()">
                            <option value="">{{\App\CPU\Helpers::translate('All Brands')}}</option>
                            @foreach ($brands as $item)
                            <option value="{{$item->id}}" {{$brand==$item->id?'selected':''}}>
                                {{\App\CPU\Helpers::getItemName('brands','name',$item->id)}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
            <div class="col-sm-4 px-1">
                <form class="">
                    <input type="hidden" name="hide_all" value="{{$hide_all}}">
                    <!-- Search -->
                    <div class="input-group">
                        <input id="search" autocomplete="off" type="text" value="{{$keyword?$keyword:''}}"
                        name="search" class="form-control search-bar-input" placeholder="{{\App\CPU\Helpers::translate('Search by Name, code, or item number')}}"
                        aria-label="Search here">
                        <div class="input-group-append">
                            <div class="input-group-text rounded-{{(session()->get('direction') == 'ltr') ? 'right' : 'left'}}">
                                <i class="tio-search"></i>
                            </div>
                        </div>
                        <diV class="card pos-search-card w-4 position-absolute z-index-1 w-100">
                            <div id="pos-search-box" class="card-body search-result-box d--none"></div>
                        </diV>
                    </div>
                    <!-- End Search -->
                </form>
            </div>
        </div>
    </div>
    <div class="card-body pt-2" id="items">
        <div class="pos-item-wrap">
            @foreach($products as $product)
                @include('admin-views.pos._single_product',['product'=>$product])
            @endforeach
        </div>
    </div>

    <div class="table-responsive mt-6 mb-5">
        <div class="px-4 d-flex justify-content-lg-end">
            @if(1 == 2)
            <!-- Pagination -->
            {!!$products->withQueryString()->links()!!}
            @endif
        </div>
    </div>
</div>

@push('script')
    <script>
        var skip = 0;
        $(document).ready(function(){
            $(".pos-item-wrap").on("scroll",function(e){
                var formData = $("#products_filter").serialize();
                var ths = $(this);
                var tbody = $(this);
                var elem = $(e.currentTarget);
                if (elem[0].scrollHeight - elem.scrollTop() <= elem.outerHeight() + 10) {
                    skip = skip + 25
                    $.ajax({
                        url:"{{route('admin.pos.products-lazy')}}?skip="+skip,
                        data: formData,
                        success:function(data){
                            $(data).appendTo(tbody);
                            if(allRecSelected){
                                checkAll_p(allRecSelected);
                            }
                        }
                    })
                }
            })
        })
    </script>
@endpush
