@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row item-row">
        <div class="container" id="item">
            <div class="col-md-4 visible-md visible-lg">
                <div>
                    <img src="/uploads/green-tea-200x200.gif">
                </div>
                <div class="list-group">
                    @foreach ($types as $type)
                    <a href="{{route('product.index',['type'=>$type->id])}}" class="list-group-item @if ($product->type_id == $type->id){{'active'}}@endif">{{$type->title}}</a>
                    @endforeach
                </div>
            </div>
            <div class="col-md-8 col-xs-12">
                <div class="row">
                    <h3 style="margin:-10px 0 20px 0;">{{$product->title}}</h3>
                    <div class="item-gallery col-md-6">
                        <div class="item-image">
                            <img src="{{asset('assets/images/space.gif')}}" width="300" height="300">
                        </div>
                        <div class="item-small-images">
                            @foreach ($product->images as $image)
                            <img src="{{asset($image->image_path)}}" width="90" height="90">
                            @endforeach
                        </div>
                    </div>
                    <div class="item-description col-md-6">
                        <h3>{{$product->title}}<small>{{trans('messages.stock')}}:{{$product->stock}}</small><h3>
                        <h4>Price: {{trans('messages.price.word_symbol')}}{{$product->price}}<h4>
                        <!--<span class="label label-info">{{trans('messages.stock')}}: {{$product->stock}}</span>-->
                        <div class="rows">
                            <ul class="list-group list-inline">
                                <li><select name="size" id="item-size">
                                <option value="">{{trans('messages.select_size')}}</option>
                                    @foreach ($product->sizes as $size_type)
                                    <option value="{{$size_type}}">{{$size_type}}</option>
                                    @endforeach
                                </select></li>
                                <li><a href="#">{{trans('messages.check_size')}}</a></li>
                                <li><div style="width:120px;padding:0;">
                                    <input name="num" class="" id="item-num" value="1" size="6"></div>
                                <div class="clearfix"></div></li>
                            </ul>
                        </div>

                            <a class="btn btn-primary btn-add-cart" href="{{route('cart.store',['id'=>$product->id])}}"><i class="glyphicon glyphicon-shopping-cart"></i> {{trans('messages.add_cart')}}</a>

                            <div class="desc2">
                                <ul class="list-group">
                                    <li class="list-group-item">+{{trans('messages.product_desc')}}<p>{!! $product->desc !!}</p></li>
                                    <li class="list-group-item">+{{trans('messages.return_desc')}}<p>{{$product->return_desc}}</p></li>
                                    <li class="list-group-item">+{{trans('messages.clean_desc')}}<p>{{$product->clean_desc}}</p></li>
                                </ul>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@section('scripts')
<script>
$(document).ready(function() {
    $('.desc2 li').click(function(){
        $('.desc2 li p').hide();
        $(this).find('p').show();
    })
    $('#item-num').TouchSpin({
        min: 1,
        max: 999999
    });
    var img = $('.item-small-images img').attr('src');
    $('.item-image img').attr('src', img);
    $('.item-small-images img').on('click mouseover',function(){
        var img = $(this).attr('src');
        $('.item-image img').attr('src', img);
    })
    $('.btn-add-cart,.btn-buy').click(function(){
        var url = $(this).attr('href');
        var size = $('#item-size').val();
        var num = $('#item-num').val();
        var obj = $(this);
        if( size == ''){
            alert('{{trans("messages.error.size")}}');
        }
        else if( parseInt(num) != num || parseInt(num) < 1 ){
            alert('{{trans("messages.error.num")}}');
        }
        else{
            $.ajax(url,{
                data: {size:size,num:num},
                method:'POST',
                dataType: 'JSON',
                success: function(json){
                    if( json && json.ret == 0){
                        $('#cart-num').text(json.data.num);
                        if(obj.hasClass('btn-one-buy')){
                        }
                    }
                    else{
                        alert(json.msg);
                    }

                },
                error: function(){
                    alert('something error');
                }
            })
        }
        return false;
    })
});
</script>
@endsection
