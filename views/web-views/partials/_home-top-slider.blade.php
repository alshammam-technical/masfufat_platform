<style>
    .just-padding {
        padding: 15px;
        border: 1px solid #ccccccb3;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
        height: 100%;
        background-color: white;
    }
    .carousel-control-prev, .carousel-control-next{
        width: 7% !important;
    }
</style>

<div class="row rtl">
    <div class="col-xl-3 d-none d-xl-block">
        <div ></div>
    </div>

    <div class="col-xl-12 col-md-12" style="margin-top: 3px;{{Session::get('direction') === "rtl" ? 'padding-right:0px;' : 'padding-left:0px;'}}">
        @php($main_banner=\App\Model\Banner::where('banner_type','Main Banner')->where('published',1)->orderBy('id','desc')->get())
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                @foreach($main_banner as $key=>$banner)
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{$key}}" class="{{$key==0?'active':''}}"
                    aria-current="true" aria-label="Slide 1"></button>
                @endforeach
            </div>
            <div class="carousel-inner" style="border-radius: 10px">
                @foreach($main_banner as $key=>$banner)
                <div class="carousel-item {{$key==0?'active':''}}" style="max-height: 420px;overflow: hidden;">
                    <a href="{{$banner['url']}}">
                        <img class="d-block w-100"
                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                        src="{{asset('storage/app/public/banner')}}/{{\App\CPU\Helpers::get_prop('App\Model\Banner',$banner['id'],'image',session()->get('local')) ?? $banner['photo']}}"
                        alt="">
                    </a>
                </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">{{\App\CPU\Helpers::translate('Previous')}}</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">{{\App\CPU\Helpers::translate('Next')}}</span>
            </button>
        </div>


    </div>
    <!-- Banner group-->
</div>


<script>
    $(function () {
        $('.list-group-item').on('click', function () {
            $('.glyphicon', this)
                .toggleClass('glyphicon-chevron-right')
                .toggleClass('glyphicon-chevron-down');
        });
    });
</script>
