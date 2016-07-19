@extends('layouts.app')
@section('content')
<div class="container">
    <div class="col-md-4 visible-md visible-lg" id="custom-list">
        <div class="list-group">
            @foreach ($types as $type)
            <a href="{{route('product.index',['type'=>$type->id])}}" class="list-group-item @if (Request::get('type') == $type->id){{'active'}}@endif">{{$type->title}}</a>
            @endforeach
        </div>
    </div>
    <div class="col-md-8 col-xs-12">
        <div class="row item-row">
            @foreach ($products as $product)
            <div class="col-xs-11 col-md-12 col-xs-offset-1 col-md-offset-0 item-thumb">
                <a href="{{route('product.show',['id'=>$product->id])}}">
                    @foreach ($product->images as $image)
                    <img src="{{asset($image->image_path)}}" width="160" height="160">
                    @endforeach
                </a>
                <h4>{{$product->title}}<small>{{trans('messages.price.symbol')}}{{$product->price}}</small></h4>
                <p class="desc1">
                    {!! $product->desc !!}
                </p>
                <p class="desc2">
                    ＊{{trans('messages.return_desc')}}：{{$product->return_desc}}
                </p>
                <p class="desc2">
                    ＊{{trans('messages.clean_desc')}}：{{$product->clean_desc}}
                </p>
                <!--<a class="btn btn-primary btn-add-cart" data-url="{{route('cart.create',['id'=>$product->id])}}"><i class="glyphicon glyphicon-shopping-cart"></i> {{trans('messages.add_cart')}}</a>-->
                <a class="btn btn-primary" href="{{route('product.show',['id'=>$product])}}"><i class="glyphicon glyphicon-zoom-in"></i> {{trans('messages.view_detail')}}</a>
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
