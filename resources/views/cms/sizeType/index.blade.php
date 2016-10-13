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

                                    </div>
                                    <div class="col-md-10 col-xs-12">

                                    </div>
                                </div>
                                <table id="basic-datatables" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>名称</th>
                                        <th>尺码规格</th>
                                        <th>中文描述</th>
                                        <th>英文描述</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($types as $type)
                                    <tr>
                                        <td>{{ $type->name }}</td>
                                        <td>{{ implode(',',unserialize($type->value)) }}</td>
                                        <td>{!! $type->en_desc !!}</td>
                                        <td>{!! $type->zh_cn_desc !!}</td>
                                        <td>
                                            <a href="{{route('admin.size.type.edit',['id'=>$type->id])}}" class="btn btn-xs btn-default" style="margin-left:10px;margin-right:10px;">编辑</a>
                                            <a href="{{route('admin.size.type.destroy',['id'=>$type->id])}}" class="btn btn-xs btn-warning delete">删除</a>
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
                    else{
                        alert(json.msg);
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
