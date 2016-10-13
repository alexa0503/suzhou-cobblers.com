@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row item-row">
        <div class="container" id="item">
            <div class="col-md-3 visible-md visible-lg">
                <div>
                    <img src="/uploads/green-tea-200x200.gif">
                </div>
                <div class="list-group">
                    @foreach ($types as $t)
                    <a href="{{route('product.index',['type'=>$t->id])}}" class="list-group-item @if (Request::get('type') == $t->id){{'active'}}@endif">{{$t->title}}</a>
                    @endforeach
                </div>
            </div>
            <div class="col-md-9 col-xs-12">
                <div class="type visible-xs">{{trans('messages.back')}} <a href="{{route('product.index',['type'=>$type->id])}}">{{$type->title}}</a></div>
                <div class="product-show">
                    <div class="bxslider">
                        <ul>
                            @foreach ($product->images as $image)
                            <li><img src="{{asset($image->image_path)}}" width="580" height="580"/></li>
                            @endforeach
                        </ul>
                    </div>

                    <h2>{{$product->title}}</h2>
                    <h4>{{trans('messages.price.word_symbol')}} {{$product->price}}</h4>
                    <div class="div-row">
                        <select name="size" id="item-size">
                            <option value="">{{trans('messages.select_size')}}</option>
                                @foreach ($product->sizes as $size_type)
                                <option value="{{$size_type}}">{{$size_type}}</option>
                                @endforeach
                        </select>
                        <a href="#" class="product-size"  data-toggle="modal" data-target="#size-type"><img src="{{asset('assets/images/icon-size.png')}}"/></a>
                    </div>
                    <div class="div-row">
                        {{trans('messages.qty')}}: <input name="num" class="num" id="item-num" value="1" size="4">
                        <a class="btn btn-add-cart" href="{{route('cart.store',['id'=>$product->id])}}">{{trans('messages.add_cart')}}</a>
                    </div>
                    <div id="list-item">
                        <ul class="list-group">
                            <li class="list-group-item"><h3>+{{trans('messages.product_desc')}}</h3><p>{!! $product->desc !!}</p></li>
                            <li class="list-group-item"><h3>+{{trans('messages.return_desc')}}</h3><p>{{$product->return_desc}}</p></li>
                            <li class="list-group-item"><h3>+{{trans('messages.clean_desc')}}</h3><p>{{$product->clean_desc}}</p></li>
                        </ul>
                    </div>
                    <div class="recommended">
                        <h3>{{trans('messages.may_like')}}</h3>
                        @foreach ($products as $p)
                        <div class="col-md-6 col-xs-6">
                        <a href="{{route('product.show',['id'=>$p->id])}}"><img src="{{asset($p->previewImage)}}" /></a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="size-type" tabindex="-1" role="dialog" aria-labelledby="size-type">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4>Size Chart</h4>
      </div>
      <div class="modal-body">
          {!! $size_type_desc !!}
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script src="{{asset('/assets/js/jquery.bxslider.min.js')}}"></script>
<script>
$(document).ready(function() {
    $('.bxslider ul').bxSlider();
    $('.product-show .list-group li').click(function(){
        $('.product-show .list-group li p').hide();
        $(this).find('p').show();
    })
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
