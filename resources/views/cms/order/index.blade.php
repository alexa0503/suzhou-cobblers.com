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
                                <div class="row">
                                    <div class="col-md-8 col-xs-12">
                                        <form class="form-inline" id="status-form" method="get" enctype="application/x-www-form-urlencoded">
                                            <select name="status" class="form-control" id="select-status">
                                                <option value="" @if (empty(Request::input('status'))){{'selected="selected"'}}@endif>选择订单状态/所有</optin>
                                                <option value="-1" @if (Request::input('status') == '-1'){{'selected="selected"'}}@endif>已关闭</optin>
                                                <option value="0" @if (Request::input('status') == '0'){{'selected="selected"'}}@endif>待付款</optin>
                                                <option value="1" @if (Request::input('status') == '1'){{'selected="selected"'}}@endif>待发货</optin>
                                                <option value="2" @if (Request::input('status') == '2'){{'selected="selected"'}}@endif>已发货</optin>
                                                <option value="3" @if (Request::input('status') == '3'){{'selected="selected"'}}@endif>已完成</optin>
                                            </select>
                                        </form>
                                    </div>
                                    <div class="col-md-4 col-xs-12">
                                        <div id="responsive-datatables_filter" class="dataTables_filter">
                                            <form method="get" enctype="application/x-www-form-urlencoded">
                                                <label><input type="search" class="form-control input-sm" placeholder="输入订单号" aria-controls="responsive-datatables" name="order_no" value="{{Request::get('order_no')}}"></label>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <table id="basic-datatables" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>订单编号</th>
                                        <th>用户</th>
                                        <th>收货人姓名</th>
                                        <th>订单总额</th>
                                        <th>订单状态</th>
                                        <th>创建时间</th>
                                        <th style="width:100px;">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($orders as $order)
                                    <tr>
                                        <td><a href="{{route('admin.order.show',['id'=>$order->id])}}" title="点击查看">{{ $order->order_no }}</a></td>
                                        <td><a href="{{route('admin.user.show',['id'=>$order->user->id])}}">{{ $order->user->email }}</a></td>
                                        <td>{{ $order->consignee_first_name }},{{ $order->consignee_last_name }}</td>
                                        <td><span class="label label-info">@if ($order->locale == 'en'){{'$'}}@else{{'￥'}}@endif</span> {{ $order->total_fee }}</td>
                                        <td>{{ trans('messages.order_status.'.$order->status) }}</td>
                                        <td>{{$order->created_at}}</td>
                                        <td>
                                            <a href="{{route('admin.order.show',['id'=>$order->id])}}" class="btn btn-xs btn-default">查看</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="dataTables_paginate paging_bootstrap" id="basic-datatables_paginate">
                                            {!! $orders->links() !!}
                                        </div>
                                    </div>
                                </div>
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
    $('#select-status').change(function(){
        $('#status-form').submit();
    })

    $('.delete').click(function(){
        var url = $(this).attr('href');
        var obj = $(this).parents('td').parent('tr');
        if( confirm('该操作无法返回,是否继续?')){
            $.ajax(url, {
                dataType: 'json',
                method: 'DELETE',
                success: function(json){
                    if(json.ret == 0){
                        obj.remove();
                    }
                },
                error: function(){
                    alert('请求失败~');
                }
            });
        }
        return false;
    })
});
</script>
@endsection
