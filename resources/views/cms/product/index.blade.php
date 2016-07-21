@extends('cms.layout')

@section('content')
    <div class="page-content sidebar-page right-sidebar-page clearfix">
        <!-- .page-content-wrapper -->
        <div class="page-content-wrapper">
            <div class="page-content-inner">
                <!-- Start .page-content-inner -->
                <div id="page-header" class="clearfix">
                    <div class="page-header">
                        <h2>产品管理<small>@if (App::getLocale() == 'zh-cn') 中文 @else 英文 @endif</small></h2>
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
                                    <div class="col-md-2 col-xs-12 ">
                                        <form method="get" enctype="application/x-www-form-urlencoded" id="form-type" class="form-inline">
                                            <select name="type"  class="form-control input-md" id="product-type">
                                                <option value="">选择分类/所有</option>
                                                @foreach ($types as $type)
                                                <option value="{{$type->id}}" @if (Request::get('type') == $type->id)selected="selected"@endif>{{$type->localeProperty->name}}</option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </div>
                                    <div class="col-md-10 col-xs-12">
                                        <div id="responsive-datatables_filter" class="dataTables_filter">
                                            <form method="get" enctype="application/x-www-form-urlencoded">
                                                <label><input type="search" class="form-control input-sm" placeholder="请输入产品名称" aria-controls="responsive-datatables" name="title" value="{{Request::get('title')}}"></label>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <table id="basic-datatables" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>产品名</th>
                                        <th>价格[@if (App::getLocale() == 'zh-cn') ￥ @else $ @endif]</th>
                                        <th>库存</th>
                                        <th>分类</th>
                                        <th>状态</th>
                                        <th style="width:200px;">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $product->title }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->stock }}</td>
                                        <td><a href="">{{ $product->type->title }}</a></td>
                                        <td class="product-status">@if ($product->is_active == 0)<font color="red">下架</font>@else正常@endif</td>
                                        <td>
                                            <a href="{{route('admin.product.status',['id'=>$product->id])}}" class="btn btn-xs btn-default product-update-status">@if ($product->is_active == 0)上架@else下架@endif</a>
                                            <a href="{{route('admin.product.edit',['id'=>$product->id])}}" class="btn btn-xs btn-default">编辑</a>
                                            <a href="{{route('admin.product.show',['id'=>$product->id])}}" class="btn btn-xs btn-default">查看</a>
                                            <a href="{{route('admin.product.destroy',['id'=>$product->id])}}" class="btn btn-xs btn-warning delete">删除</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="dataTables_paginate paging_bootstrap" id="basic-datatables_paginate">
                                            {!! $products->links() !!}
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
    $('#product-type').change(function(){
        $('#form-type').submit();
    })
    $('.product-update-status').click(function(){
        var obj1 = $(this);
        var url = $(this).attr('href');
        var obj2 = $(this).parents('td').parent('tr');
        $.ajax(url, {
            dataType: 'json',
            method: 'PUT',
            success: function(json){
                if(json.ret == 0){
                    var text1 = obj1.text();
                    var text2 = obj2.find('.product-status').text();
                    if( text1 == '下架' ){
                        obj1.text('上架');
                    }
                    else{
                        obj1.text('下架');
                    }
                    if( text2 == '正常'){
                        obj2.find('.product-status').html('<font color="red">下架</font>');
                    }
                    else{
                        obj2.find('.product-status').html('正常');
                    }
                }
            },
            error: function(){
                alert('请求失败~');
            }
        });
        return false;
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
