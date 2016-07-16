@extends('cms.layout')

@section('content')
    <div class="page-content sidebar-page right-sidebar-page clearfix">
        <!-- .page-content-wrapper -->
        <div class="page-content-wrapper">
            <div class="page-content-inner">
                <!-- Start .page-content-inner -->
                <div id="page-header" class="clearfix">
                    <div class="page-header">
                        <h2>产品分类 - 添加<small>@if (App::getLocale() == 'zh-cn') 中文 @else 英文 @endif</small></h2>
                    </div>
                </div>
                <!-- Start .row -->
                <div class="row">
                    <div class="col-lg-12">
                        <!-- col-lg-12 start here -->
                        <div class="panel panel-default">
                            <!-- Start .panel -->
                            <div class="panel-body pt0 pb0">
                                {{ Form::open(array('route' => ['admin.products.type.store'], 'class'=>'form-horizontal group-border stripped', 'id'=>'form')) }}
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">标题</label>
                                        <div class="col-lg-10 col-md-9">
                                            <input type="text" name="title" class="form-control" value="">
                                            <label class="help-block" for="title"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">描述</label>
                                        <div class="col-lg-10 col-md-9">
                                            <textarea name="desc" class="form-control article-ckeditor"></textarea>
                                            <label class="help-block" for="desc"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label class="col-lg-2 col-md-3 control-label" for="">缩略图</label>
                                        <div class="col-lg-10 col-md-9">
                                            <img src="" class="img-polaroid thumb-image" style="max-width:200px;max-height:200px;margin-bottom:20px;" class="hidden" />
                                            <input type="file" name="thumb" class="filestyle thumb" data-buttonText="Find file" data-buttonName="btn-danger" data-iconName="fa fa-plus">
                                            <label class="help-block" for="thumb"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label class="col-lg-2 col-md-3 control-label"></label>
                                        <div class="col-lg-10 col-md-9">
                                            <button class="btn btn-default ml15" type="submit">提 交</button>
                                            <a class="btn btn-default ml15" href="{{route('admin.products.type.index')}}">返回</a>
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
            location.href='{{route("admin.products.type.index")}}';
        },
        error: function(xhr){
            var json = jQuery.parseJSON(xhr.responseText);
            var keys = Object.keys(json);
            //console.log(keys);
            $('#form .form-group .help-block').empty();
            $('#form .form-group').removeClass('has-error');
            $('#form .form-group').each(function(){
                var name = $(this).find('input,textarea').attr('name');
                if( jQuery.inArray(name, keys) != -1){
                    $(this).addClass('has-error');
                    $(this).find('.help-block').html(json[name]);
                }
            })
        }
    });

    $('.thumb').change(function(){
        var reader = new FileReader();
        reader.onload = function (event) {
            $(".thumb-image").attr("src", event.target.result).show();
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
