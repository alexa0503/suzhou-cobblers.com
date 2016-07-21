<p>
{{$order->user->name}}[{{$order->user->email}}]订单支付成功，订单号：{{$order->order_no}}。
</p>
<p>
查看地址：{{route('admin.order.show',['id'=>$order->id])}}。
</p>
