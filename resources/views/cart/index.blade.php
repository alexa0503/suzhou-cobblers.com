@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div id="cart" class="panel panel-default toggle panelMove panelClose panelRefresh">
            <!-- Start .panel -->
            <div class="panel-heading">
                <h4 class="panel-title">{{trans('messages.cart')}}</h4>
            </div>
            <div class="panel-body">
                <!--<div>
                    <div class="checkbox-custom">
                        <input class="check-all" type="checkbox">
                        <label for="masterCheck">全选</label>
                    </div>
                </div>-->
                    @foreach ($items as $item)
                    <div class="row cart-list">
                        <!--<div class="col-xs-1">
                            <div class="checkbox-custom">
                                <input class="check" name="cartId[]" type="checkbox" value="{{$item->rowId}}">
                                <label for="check"></label>
                            </div>
                        </div>-->
                        <div class="col-xs-4">
                            <a href="{{route('product.show',['id'=>$item->id])}}"><img width="140" height="140" src="{{asset($item->options->thumb)}}"></a>
                        </div>
                        <div class="col-xs-8 cart-list-desc">
                            <div class="col-xs-6">
                                <div>
                                {{$item->name}}
                                </div>
                                <div>
                                    {{trans('messages.size')}}:{{$item->options->size}}
                                    <!--<select name="size[]" class="form-group item-size">
                                    <option value="">{{trans('messages.select_size')}}</option>
                                        @foreach ($item->options->sizes as $size_type)
                                        <option value="{{$size_type}}"@if ($size_type == $item->options->size){{' selected="selected"'}}@endif>{{$size_type}}</option>
                                        @endforeach
                                    </select>-->
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div>
                                    <span class="price">{{trans('messages.unit_price')}}: {{trans('messages.price.symbol')}} {{number_format($item->price,2)}}</span>
                                </div>
                                <div>
                                    {{trans('messages.qty')}}: {{$item->qty}}
                                </div>
                                <div>
                                    {{trans('messages.subtotal')}}: {{trans('messages.price.symbol')}}{{$item->subtotal()}}
                                </div>
                                <div style="margin-top:20px;" class="text-left">
                                    <a class="btn-delete-cart" href="{{route('cart.destroy',['id'=>$item->rowId])}}">删除</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @if ( $cart->count() > 0 )
                    <div class="row">
                        <div class="text-right" style="margin-right:120px;">
                            {{trans('messages.total_price')}}: {{trans('messages.price.symbol')}}{{$cart->subtotal()}}
                        </div>
                    </div>
                    <div style="margin-top:60px;" class="row">
                        <div class="col-xs-6 col-lg-6 col-md-6">
                            <div class="text-center">
                                <a href="{{route('types')}}" class="btn btn-info">{{trans('messages.prev')}}</a>
                            </div>
                        </div>
                        <div class="col-xs-6 col-lg-6 col-md-6">
                            <div class="text-center">
                                <a href="{{route('order.address.index')}}" class="btn btn-info btn-submit">{{trans('messages.next')}}</a>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="text-center" style="margin:0 0 30px;"><h4>{{trans('messages.empty_cart')}}</h4></div>
                    @endif
            </div>
            <!-- End .panel -->
        </div>

    </div>
</div>
@endsection
@section('scripts')
<script>
$().ready(function(){
    /*
    $('.panel-body').checkAll({
		masterCheckbox: '.check-all',
		otherCheckboxes: '.check',
		highlightRows: {
            active: true,
            row: 'tr'
        }
    });
    */
    $('.btn-delete-cart').click(function(){
        var url = $(this).attr('href');
        var obj = $(this).parents('.cart-list');
        $.ajax(url,{
            method: 'DELETE',
            dataType: 'JSON',
            success: function(json){
                if(json && json.ret == 0){
                    obj.remove();
                    if($('.panel-body').find('.cart-list').length == 0){
                        location.reload();
                    }
                }
            }
        })
        return false;
    })
})
</script>
@endsection
