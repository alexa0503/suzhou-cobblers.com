@extends('cms.layout')

@section('content')
<div class="page-content sidebar-page right-sidebar-page clearfix">
    <!-- .page-content-wrapper -->
    <div class="page-content-wrapper">
        <div class="page-content-inner">
            <!-- Start .page-content-inner -->
            <div id="page-header" class="clearfix">
                <div class="page-header">
                    <h2>产品分类<small>@if (App::getLocale() == 'zh-cn') 中文 @else 英文 @endif</small></h2>
                </div>
            </div>
            <!-- Start .row -->
            <div class="row" style="min-height:800px;">
                <div class="col-lg-12">
                    <!-- col-lg-12 start here -->
                    <div class="panel panel-default">
                        <!-- Start .panel -->
                        <div class="panel-body">
                            <table id="basic-datatables" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>快递方式</th>
                                    <th>对应地区</th>
                                    <th>值</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($fees as $fee)
                                <tr>
                                    <td>{{$fee->type->name}}</td>
                                    <td>@if ($fee->city_id == null){{'默认'}}@else {{$fee->city->name_cn}}@endif</td>
                                    <td>{{json_encode($fee->value)}}</td>
                                    <td>
                                        <a href="{{route('admin.deliver.fee.edit',['id'=>$fee->id])}}" class="btn btn-xs btn-default">编辑</a>
                                        @if ($fee->id != 1 AND $fee->id != 2)
                                        <a href="{{route('admin.deliver.fee.destroy',['id'=>$fee->id])}}" class="btn btn-xs btn-warning delete">删除</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <div class="dataTables_paginate paging_bootstrap" id="basic-datatables_paginate">
                                        {!! $fees->links() !!}
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
