@foreach($products as $product)
    @include('admin-views.pos._single_product',['product'=>$product])
@endforeach
