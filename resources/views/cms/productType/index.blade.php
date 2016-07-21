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
                                    <th>缩略图</th>
                                    <th>标题</th>
                                    <th>描述</th>
                                    <th style="min-width:120px">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($types as $type)
                                <tr>
                                    <td><img src="{{ asset($type->thumb) }}" style="max-width:200px;max-height:100px;" /></td>
                                    @if(isset($type->localeProperty))
                                    <td>{{ $type->localeProperty->name }}</td>
                                    <td>{{ strip_tags($type->localeProperty->desc) }}</td>
                                    @else
                                    <td>{{$type->title}}</td>
                                    <td>--</td>
                                    @endif
                                    <td>
                                        <a href="{{route('admin.products.type.edit',['id'=>$type->id])}}" class="btn btn-xs btn-default">编辑</a>
                                            <a href="{{route('admin.products.type.destroy',['id'=>$type->id])}}" class="btn btn-xs btn-warning delete">删除</a>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <div class="dataTables_paginate paging_bootstrap" id="basic-datatables_paginate">
                                        {!! $types->links() !!}
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
