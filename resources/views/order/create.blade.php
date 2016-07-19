@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <!-- Start .panel -->
            <div class="panel-heading">
                <h4 class="panel-title">{{trans('messages.cart')}}</h4>
            </div>
            <div class="panel-body">
                {{ Form::open(array('route' => ['order.store'], 'class'=>'form-horizontal', 'id'=>'checkout-form')) }}
                <div class="form-group well" style="margin-left:20px;margin-right:20px;">
                    <div class="row">
                        <div class="col-md-6 col-xs-6">
                            收货人:{{$address->first_name}} {{$address->last_name}}
                        </div>
                        <div class="col-md-6 col-xs-6">{{$address->phone_number}}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            收货地址:{{$address->country->name}}@if ($address->province != null),{{$address->province->name}}@endif @if ($address->city != null),{{$address->city->name}}@endif,{{$address->detailed_address}}
                            <input name="deliver_address" value="{{$address->id}}" type="hidden" />
                        </div>
                    </div>
                </div>
                <!-- End .form-group  -->
                <div class="form-group" style="margin-left:20px;margin-right:20px;">
                    @foreach ($items as $item)
                    <div class="col-md-6 col-xs-12">
                        <div class="row">
                            <div class="col-md-5 col-xs-4">
                                <img width="160" height="160" src="{{asset($item->options->thumb)}}">
                            </div>
                            <div class="col-md-7 col-xs-8">
                                <div class="row">{{$item->name}}</div>
                                <div class="row" style="margin-top:10px;">{{trans('messages.size')}}: {{$item->options->size}}</div>
                                <div class="row" style="margin-top:10px;">
                                    <div class="pull-left" style="color:red;">{{number_format($item->price,2)}}</div>
                                    <div class="pull-right text-right">X{{$item->qty}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row"><img src="{{asset('assets/images/space.gif')}}" width="20"></div>
                    </div>
                    @endforeach
                </div><!-- End .form-group  -->
                <div class="form-group well" style="margin-left:20px;margin-right:20px;">
                    <label class="col-lg-2 col-md-3 col-xs-3 control-label">配送方式:</label>
                    <div class="col-lg-10 col-md-9 col-xs-9">
                        <div class="col-lg-10 col-md-9">
                            <select name="deliver_type" class="form-control">
                                <option value="">选择配送方式</option>
                                <option value="1">EMS:{{trans('messages.price.symbol')}}25</option>
                            </select>
                            <div class="help-block"></div>
                        </div>
                    </div>
                </div>
                <!-- End .form-group  -->
                <div class="form-group well" style="margin-left:20px;margin-right:20px;">
                    <label class="col-lg-2 col-md-3 col-xs-3 control-label">支付方式:</label>
                    <div class="col-lg-10 col-md-9 col-xs-9">
                        <div class="col-md-3 col-xs-6">
                            <input type="radio" name="payment" value="1" id="payment-alipay"/>
                            <label for="payment-alipay"><i><img src="{{asset('assets/images/icon-alipay.png')}}" height="24" alt="支付宝" /></i></label>
                        </div>
                        <div class="col-md-3 col-xs-6">
                            <input type="radio" name="payment" value="2" id="payment-paypal" />
                            <label for="payment-paypal"><i><img src="{{asset('assets/images/icon-paypal.png')}}" height="24" alt="Paypal" /></i></label>
                        </div>
                        <div class="help-block"></div>
                    </div>
                </div>
                <!-- End .form-group  -->
                <div class="form-group well" style="margin-left:20px;margin-right:20px;">
                    <label class="col-lg-2 col-md-3 col-xs-3 control-label">{{trans('messages.buyer_message')}}:</label>
                    <div class="col-lg-10 col-md-9 col-xs-9">
                        <textarea class="form-control" rows="1" name="message"></textarea>
                        <div class="help-block"></div>
                    </div>
                </div>
                <!-- End .form-group  -->
                <div class="form-group well text-right" style="margin-left:20px;margin-right:20px;">
                    共{{$cart->count()}}件商品&nbsp;&nbsp;&nbsp;{{trans('messages.total_price')}}: <font color="red">{{trans('messages.price.symbol')}}{{$cart->subtotal()}}</font>
                </div>
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <!-- End .form-group  -->
                <div class="row" style="margin-left:20px;margin-right:20px;">
                    <div class="rows text-right">
                        <button type="submit" class="btn btn-info btn-submit">{{trans('messages.submit_order')}}</button>
                    </div>
                </div>
                <!-- End .form-group  -->
                {{ Form::close() }}
                <!-- End form  -->
                </div>
            </div>
            <!-- End .panel -->
        </div>

    </div>
</div>
@endsection
@section('scripts')
<script>
$().ready(function(){
    $('#checkout-form').submit(function(){
        if($('#payment').val() == '2'){
            $('#paypal-form').submit();
        }
        //return false;
    })
})
</script>
@endsection
