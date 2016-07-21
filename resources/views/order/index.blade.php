@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
                <!-- Start .panel -->
                <div class="panel-heading">
                    <h4 class="panel-title">{{trans('messages.my_orders')}}</h4>
                </div>
                <div class="panel-body">
                    @foreach ($orders as $order)
                    <div class="row well" style="margin:10px 20px;">
                        <div class="col-md-12 col-xs-12">
                            <div class="col-md-6 col-xs-6">
                                <div class="row" style="margin-top:4px;">
                                    订单编号:{{$order->order_no}}
                                </div>
                                <div class="row" style="margin-top:4px;">
                                    创建时间:{{$order->created_at}}
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-6 text-right">
                                @if ($order->status == 0)
                                <div class="row">
                                    <span class="label label-warning">{{trans('messages.pay_limit')}}</span></div>
                                <div class="row" style="margin-top:4px;">
                                    <a href="{{route('order.pay',['id'=>$order->id])}}">{{trans('messages.continue_pay')}} [{{trans('messages.payment.'.$order->payment)}}]</a>
                                </div>
                                @else
                                {{trans('messages.order_status.'.$order->status)}}
                                @endif
                            </div>
                        </div>
                        @foreach ($order->products as $product)
                        <div class="col-md-12 col-xs-12" style="margin-top:20px;">
                            <div class="col-md-2 col-xs-3">
                                <img src="{{asset($product->detail->preview_image)}}" width="100" />
                            </div>
                            <div class="col-md-6 col-xs-5">
                                <h4>{{$product->detail->title}}</h4>
                            </div>
                            <div class="col-md-4 col-xs-4 text-right">
                                <h5>{{trans('messages.price.symbol')}} {{$product->unit_price}}</h5>
                                <h5>×{{$product->qty}}</h5>
                            </div>
                        </div>
                        @endforeach
                        <div class="col-md-12 col-xs-12 text-right">
                            <hr>
                            {{trans('messages.total_price')}}:{{trans('messages.price.symbol')}}{{$order->total_fee}} [{{trans('messages.deliver_price')}}:{{trans('messages.price.symbol')}}{{$order->deliver_fee}}]
                        </div>
                    </div>
                    @endforeach
                </div>
                <!-- End .panel -->
            </div>

    </div>
</div>
@endsection
@section('scripts')
<script>
$().ready(function(){
})
</script>
@endsection
