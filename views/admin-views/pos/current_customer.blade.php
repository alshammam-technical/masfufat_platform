<div class="card-body px-0">
    <div class="media">
        <div class="mr-3 ml-3">
            <img
                class="avatar rounded-circle avatar-70" style="width: 75px;height: 42px"
                onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                src="{{asset('storage/app/public/user')}}/{{$customer->store_informations['image'] ?? ''}}"
                alt="Image">
        </div>
        <div class="media-body d-flex flex-column gap-1">
            <span class="title-color hover-c1"><strong>{{$customer['f_name'].' '.$customer['l_name']}}</strong></span>
            <span class="title-color">
                <strong>{{\App\Model\Order::where('customer_id',$customer['id'])->count()}} </strong>{{\App\CPU\Helpers::translate('orders')}}
            </span>
            <span class="title-color"><strong>{{$customer['phone']}}</strong></span>
            <span class="title-color">{{$customer['email']}}</span>
        </div>
        <div class="media-body text-right">
            {{--<i class="tio-chevron-right text-body"></i>--}}
        </div>
    </div>
</div>
