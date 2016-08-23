@extends('cms.layout')

@section('content')
    <div class="page-content sidebar-page right-sidebar-page clearfix">
        <!-- .page-content-wrapper -->
        <div class="page-content-wrapper">
            <div class="page-content-inner">
                <!-- Start .page-content-inner -->
                <div id="page-header" class="clearfix">
                    <div class="page-header">
                        <h2>媒体管理<small></h2>
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
                                            <select name="type"  class="form-control input-md" id="press-type">
                                                <option value="">选择分类/主分类</option>
                                                @foreach ($types as $type)
                                                <option value="{{$type->id}}" @if (Request::get('type') == $type->id)selected="selected"@endif>{{$type->title}}</option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </div>
                                    <div class="col-md-10 col-xs-12">

                                    </div>
                                </div>
                                <table id="basic-datatables" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>标题[英文]</th>
                                        <th>标题[中文]</th>
                                        <th>分类</th>
                                        <th>缩略图</th>
                                        <th style="width:120px;">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($presses as $press)
                                    <tr>
                                        <td>{{ $press->title_en }}</td>
                                        <td>{{ $press->title_cn }}</td>
                                        <td>@if ( isset($press->parent) ){{ $press->parent->title }}@else{{ '主分类' }}@endif</td>
                                        <td><img src="{{ asset($press->thumb) }}" style="max-width:200px;max-height:200px;" /></td>

                                        <td>
                                            <a href="{{route('admin.press.edit',['id'=>$press->id])}}" class="btn btn-xs btn-default" style="margin-left:10px;margin-right:10px;">编辑</a>
                                            <a href="{{route('admin.press.destroy',['id'=>$press->id])}}" class="btn btn-xs btn-warning delete">删除</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="dataTables_paginate paging_bootstrap" id="basic-datatables_paginate">
                                            {!! $presses->links() !!}
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
    $('#press-type').change(function(){
        $('#form-type').submit();
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
