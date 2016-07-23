@extends('cms.layout')

@section('content')
    <div class="page-content sidebar-page right-sidebar-page clearfix">
        <!-- .page-content-wrapper -->
        <div class="page-content-wrapper">
            <div class="page-content-inner">
                <!-- Start .page-content-inner -->
                <div id="page-header" class="clearfix">
                    <div class="page-header">
                        <h2>订单查看</h2>
                    </div>

                </div>
                <!-- Start .row -->
                <div class="row" style="min-height:800px;">
                    <div class="col-lg-12">
                        <!-- col-lg-12 start here -->
                        <div class="panel panel-default">
                            <!-- Start .panel -->
                            <div class="panel-body">
                                {{ Form::open(array('route' => ['admin.order.update',$order->id], 'class'=>'form-horizontal group-border stripped', 'method'=>'PUT', 'id'=>'form')) }}
                                  <div class="form-group">
                                    <label for="" class="col-lg-2 col-md-3 control-label">订单编号</label>
                                    <div class="col-lg-10 col-md-9">
                                        <p class="form-control-static">{{$order->order_no}}</p>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="" class="col-lg-2 col-md-3 control-label">总计</label>
                                    <div class="col-lg-10 col-md-9">
                                        <p class="form-control-static">{{$order->price_symbol}} {{$order->total_fee}}</p>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="" class="col-lg-2 col-md-3 control-label">物品总价</label>
                                    <div class="col-lg-10 col-md-9">
                                        <p class="form-control-static">{{$order->price_symbol}} {{$order->items_fee}}</p>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="" class="col-lg-2 col-md-3 control-label">运费</label>
                                    <div class="col-lg-10 col-md-9">
                                        <p class="form-control-static">{{$order->price_symbol}} {{$order->deliver_fee}}</p>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="" class="col-lg-2 col-md-3 control-label">购买用户</label>
                                    <div class="col-lg-10 col-md-9">
                                        <p class="form-control-static"><a href="{{route('admin.user.show',['id'=>$order->user->id])}}">{{$order->user->email}}</a></p>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="" class="col-lg-2 col-md-3 control-label">创建时间</label>
                                    <div class="col-lg-10 col-md-9">
                                        <p class="form-control-static">{{$order->created_at}}</p>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="" class="col-lg-2 col-md-3 control-label">购买产品</label>
                                    <div class="col-lg-10 col-md-9">
                                        <div class="form-control-static">
                                                @foreach ($order->products as $product)
                                                <div class="bg-success" style="padding:20px;background-color:#d0d0d0;">
                                                <p>产品名称：<a href="{{route('admin.product.show',['id'=>$product->product_id])}}" target="_blank">{{$product->product_name}}</a></p>
                                                <p>产品尺寸：{{$product->size}}</p>
                                                <p>购买数量：{{$product->qty}}</p>
                                                <p>产品单价：{{$product->unit_price}}</p>
                                                </div>
                                                @endforeach
                                        </div>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="" class="col-lg-2 col-md-3 control-label">快递方式</label>
                                    <div class="col-lg-10 col-md-9">
                                        <p class="form-control-static">{{$order->deliver->name}}</p>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="" class="col-lg-2 col-md-3 control-label">收货人姓名</label>
                                    <div class="col-lg-10 col-md-9">
                                        <p class="form-control-static">{{$order->consignee_first_name}} {{$order->consignee_last_name}}</p>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="" class="col-lg-2 col-md-3 control-label">收货人电话</label>
                                    <div class="col-lg-10 col-md-9">
                                        <p class="form-control-static">{{$order->consignee_phone_number}}</p>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="" class="col-lg-2 col-md-3 control-label">收货人地址</label>
                                    <div class="col-lg-10 col-md-9">
                                        <p class="form-control-static">
                                            {{$order->detail_address}}
                                        </p>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="" class="col-lg-2 col-md-3 control-label">收货邮编</label>
                                    <div class="col-lg-10 col-md-9">
                                        <p class="form-control-static">
                                            {{$order->consignee_zip_code}}
                                        </p>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="" class="col-lg-2 col-md-3 control-label">买家留言</label>
                                    <div class="col-lg-10 col-md-9">
                                        <p class="form-control-static">
                                            {{$order->buyer_message}}
                                        </p>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="" class="col-lg-2 col-md-3 control-label">订单状态</label>
                                    <div class="col-lg-10 col-md-9">
                                        <p class="form-control-static">
                                            {{ trans('messages.order_status.'.$order->status) }}
                                        </p>
                                    </div>
                                  </div>
                                  @if ($order->status == 1)
                                  <div class="form-group">
                                    <label for="" class="col-lg-2 col-md-3 control-label">物流号</label>
                                    <div class="col-lg-10 col-md-9">
                                        <input type="text" name="deliver_no" id="deliver_no" class="form-control" value="">
                                        <label class="help-block" for="deliver_no"></label>
                                    </div>
                                  </div>
                                  @elseif ($order->status > 1)
                                  <div class="form-group">
                                    <label for="" class="col-lg-2 col-md-3 control-label">物流号</label>
                                    <div class="col-lg-10 col-md-9">
                                        <p class="form-control-static">
                                            {{$order->deliver_no}}
                                        </p>
                                    </div>
                                  </div>
                                  @endif
                                  @if ($order->status >= 0 and $order->status <= 2 )
                                  <div class="form-group">
                                      <label class="col-lg-2 col-md-3 control-label"></label>
                                        <div class="col-lg-10 col-md-9">
                                            @if ($order->status == 1)
                                            <input name="status" value="2" type="hidden" />
                                            <button type="submit" class="btn btn-primary btn-deliver">发货</button>
                                            @elseif ($order->status == 0)
                                            <input name="status" value="-1" type="hidden" />
                                            <button type="submit" class="btn btn-primary btn-close">关闭订单</button>
                                            @elseif ($order->status == 2)
                                            <input name="status" value="3" type="hidden" />
                                            <button type="submit" class="btn btn-primary btn-complete">完成订单</button>
                                            @endif
                                        </div>
                                  </div>
                                  @endif
                                  {{ Form::close() }}
                            </div>
                        </div>
                        <!-- End .panel -->
                    </div>
                </div>
                <!-- End .row -->
            </div>
            <!-- End .page-content-inner -->
        </div>
        <!-- / page-content-wrapper -->
    </div>
@endsection
@section('scripts')
<script>
$(document).ready(function() {
    $('#form').ajaxForm({
        dataType: 'json',
        success: function() {
            $('#form .form-group .help-block').empty();
            $('#form .form-group').removeClass('has-error');
            location.reload();
            //location.href='{{route("admin.product.index")}}';
        },
        error: function(xhr){
            var json = jQuery.parseJSON(xhr.responseText);
            console.log(json);
            var keys = Object.keys(json);
            //console.log(keys);
            $('#form .form-group .help-block').empty();
            $('#form .form-group').removeClass('has-error');
            $('#form .form-group').each(function(){
                var name = $(this).find('input,textarea,select').attr('name');
                if( jQuery.inArray(name, keys) != -1){
                    $(this).addClass('has-error');
                    $(this).find('.help-block').html(json[name]);
                }
            })
        }
    });
});
</script>
@endsection
