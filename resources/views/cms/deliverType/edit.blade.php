@extends('cms.layout')

@section('content')
    <div class="page-content sidebar-page right-sidebar-page clearfix">
        <!-- .page-content-wrapper -->
        <div class="page-content-wrapper">
            <div class="page-content-inner">
                <!-- Start .page-content-inner -->
                <div id="page-header" class="clearfix">
                    <div class="page-header">
                        <h2>产品管理 - 添加<small>@if (App::getLocale() == 'zh-cn') 中文 @else 英文 @endif</small></h2>
                    </div>
                </div>
                <!-- Start .row -->
                <div class="row">
                    <div class="col-lg-12">
                        <!-- col-lg-12 start here -->
                        <div class="panel panel-default">
                            <!-- Start .panel -->
                            <div class="panel-body pt0 pb0">
                                {{ Form::open(array('route' => ['admin.press.update',$press->id], 'class'=>'form-horizontal group-border stripped', 'method'=>'PUT', 'id'=>'form')) }}
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">标题[英文]</label>
                                        <div class="col-lg-10 col-md-9">
                                            <input type="text" name="title_en" class="form-control" value="{{$press->title_en}}">
                                            <label class="help-block" for="title_en"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">标题[中文]</label>
                                        <div class="col-lg-10 col-md-9">
                                            <input type="text" name="title_cn" class="form-control" value="{{$press->title_cn}}">
                                            <label class="help-block" for="title_cn"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">所属分类</label>
                                        <div class="col-lg-10 col-md-9">
                                            <select name="parent_id" class="form-control">
                                                <option value="">请选择所属分类/主分类</option>
                                                @foreach ($types as $type)
                                                <option value="{{$type->id}}" @if ($type->id == $press->parent_id) selected="selected" @endif>
                                                    {{$type->title}}
                                                </option>
                                                @endforeach
                                            </select>
                                            <label class="help-block" for="product_type"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label class="col-lg-2 col-md-3 control-label" for="">缩略图</label>
                                        <div class="col-lg-10 col-md-9">
                                            <div class="thumb-preview" id="thumb-preview">
                                                <img src="{{asset($press->thumb)}}" />
                                            </div>
                                            <input type="file" name="thumb" class="filestyle" data-buttonText="Find file" data-buttonName="btn-danger" data-iconName="fa fa-plus" id="thumb-file">
                                            <label class="help-block" for="thumb"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label class="col-lg-2 col-md-3 control-label" for="">详细图</label>
                                        <div class="col-lg-10 col-md-9">
                                            <div class="thumb-preview" id="image-preview">
                                                @if (isset($press->image))<img src="{{asset($press->image)}}" />@endif
                                            </div>
                                            <input type="file" name="image" class="filestyle" data-buttonText="Find file" data-buttonName="btn-danger" data-iconName="fa fa-plus" id="image-file">
                                            <label class="help-block" for="image"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label class="col-lg-2 col-md-3 control-label"></label>
                                        <div class="col-lg-10 col-md-9">
                                            <button class="btn btn-default ml15" type="submit">提 交</button>
                                            <a class="btn btn-default ml15" href="{{route('admin.press.index')}}">返回</a>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    {{ Form::close() }}
                            </div>
                        </div>
                        <!-- End .panel -->
                    </div>
                    <!-- col-lg-12 end here -->
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
            location.href='{{route("admin.press.index",["type"=>$press->parent_id])}}';
        },
        error: function(xhr){
            var json = jQuery.parseJSON(xhr.responseText);
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
    $('#thumb-file').change(function(){
        $("#thumb-preview").html('');
        var reader = new FileReader();
        reader.onload = function (event) {
            $("#thumb-preview").append('<img src="'+event.target.result+'" />');
        }
        reader.readAsDataURL(this.files[0]);
    })
    $('#image-file').change(function(){
        $("#image-preview").html('');
        var reader = new FileReader();
        reader.onload = function (event) {
            $("#image-preview").append('<img src="'+event.target.result+'" />');
        }
        reader.readAsDataURL(this.files[0]);
    })

});
</script>
<script src="{{asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js')}}"></script>
<script>
    $('.article-ckeditor').ckeditor({
        filebrowserBrowseUrl: '{!! url('filemanager/index.html') !!}'
    });
</script>
@endsection
