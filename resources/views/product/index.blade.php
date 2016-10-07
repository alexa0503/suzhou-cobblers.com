@extends('layouts.app')
@section('content')
<div class="container">
    <div class="col-md-3 visible-md visible-lg" id="custom-list">
        <div class="list-group">
            @foreach ($types as $t)
            <a href="{{route('product.index',['type'=>$t->id])}}" class="list-group-item @if (Request::get('type') == $t->id){{'active'}}@endif">{{$t->title}}</a>
            @endforeach
        </div>
    </div>
    <div class="col-md-9 col-xs-12">
        <div class="row item-row">
            <div class="type visible-xs">{{$type->title}}</div>
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
