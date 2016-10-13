@extends('layouts.app')
@section('content')
<div class="container">
    <div class="col-md-12 col-xs-12">
        <div class="row item-row">
            <div class="row">
            <div class="item-topper-01">
                <div class="item-topper-02"><img src="{{asset('assets/images/top-new-product-02.png')}}" height=200 style="margin-top:10px;" /></div>
                <img src="{{asset('assets/images/top-new-product-03.png')}}" width="100%" class="visible-xs" />
                <img src="{{asset('assets/images/top-new-product-01.png')}}" width="1280" class="visible-md visible-lg" />
            </div>
            </div>
            <div class="type visible-xs">{{trans('messages.new_items')}}</div>
            @foreach ($products as $product)
            <div class="item-thumb">
            <a href="{{route('product.show',['id'=>$product->id])}}">
                <img src="{{asset($product->previewImage)}}" width="293" height="293">
            </a>
            <h3>{{$product->title}}<!--<small style="font-size:0.8em;">库存状态:有库存</small>--></h3>
            <h4>{{trans('messages.price.word_symbol')}} {{$product->price}}</h4>
            <!--<a class="btn btn-primary btn-add-cart" data-url="{{route('cart.create',['id'=>$product->id])}}"><i class="glyphicon glyphicon-shopping-cart"></i> {{trans('messages.add_cart')}}</a>-->
            <!--<a class="btn btn-primary" href="{{route('product.show',['id'=>$product])}}"><i class="glyphicon glyphicon-zoom-in"></i> {{trans('messages.view_detail')}}</a>-->
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
$(document).ready(function() {
    var url = '{{route("cart.count")}}';
    $.getJSON(url,function(json){
        $('#cart-num').text(json.data.num);
    });

});
</script>
@endsection
