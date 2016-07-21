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
                                {{ Form::open(array('route' => ['admin.product.update',$product->id], 'class'=>'form-horizontal group-border stripped', 'method'=>'PUT', 'id'=>'form')) }}
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">产品名称</label>
                                        <div class="col-lg-10 col-md-9">
                                            <input type="text" name="product_name" class="form-control" value="{{$product->title}}">
                                            <label class="help-block" for="product_name"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">所属分类</label>
                                        <div class="col-lg-10 col-md-9">
                                            <select name="product_type" class="form-control">
                                                <option value="-1">请选择所属分类</option>
                                                @foreach ($types as $type)
                                                <option value="{{$type->id}}" @if ($type->id == $product->type_id) selected="selected" @endif>
                                                    {{$type->title}}
                                                </option>
                                                @endforeach
                                            </select>
                                            <label class="help-block" for="product_type"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">尺码标准</label>
                                        <div class="col-lg-10 col-md-9">
                                            <select name="product_size_type" class="form-control">
                                                <option value="-1">选择尺码标准</option>
                                                @foreach ($size_types as $size_type)
                                                <option value="{{$size_type->id}}" @if ($size_type->id == $product->size_type_id) selected="selected" @endif>
                                                    {{$size_type->name}}
                                                </option>
                                                @endforeach
                                            </select>
                                            <label class="help-block" for="product_size_type"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">产品库存</label>
                                        <div class="col-lg-10 col-md-9">
                                            <input type="text" name="stock" class="form-control" value="{{ $product->stock }}" id="stock">
                                            <label class="help-block" for="stock"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">产品价格</label>
                                        <div class="col-lg-10 col-md-9">
                                            <input type="text" name="price" class="form-control" value="{{ $product->price }}" id="price">
                                            <label class="help-block" for="price"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">产品描述</label>
                                        <div class="col-lg-10 col-md-9">
                                            <textarea name="desc" class="form-control article-ckeditor">{{ $product->desc }}</textarea>
                                            <label class="help-block" for="desc"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">退换说明</label>
                                        <div class="col-lg-10 col-md-9">
                                            <textarea name="return_desc" class="form-control">{{ $product->return_desc }}</textarea>
                                            <label class="help-block" for="return_desc"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">清洁指南</label>
                                        <div class="col-lg-10 col-md-9">
                                            <textarea name="clean_desc" class="form-control">{{ $product->clean_desc }}</textarea>
                                            <label class="help-block" for="clean_desc"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    @if (App::getLocale() == 'en')
                                    <div class="form-group">
                                        <label class="col-lg-2 col-md-3 control-label" for="">缩略图</label>
                                        <div class="col-lg-10 col-md-9">
                                            <div class="thumb-preview">
                                                @foreach ($product->images as $image)
                                                <img src="{{asset($image->image_path)}}" />
                                                @endforeach
                                            </div>
                                            <input type="file" name="thumb[]" class="filestyle thumb" data-buttonText="Find file" data-buttonName="btn-danger" data-iconName="fa fa-plus" multiple="">
                                            <label class="help-block" for="thumb[]"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    @endif
                                    <div class="form-group">
                                        <label class="col-lg-2 col-md-3 control-label"></label>
                                        <div class="col-lg-10 col-md-9">
                                            <button class="btn btn-default ml15" type="submit">提 交</button>
                                            <a class="btn btn-default ml15" href="{{route('admin.product.index')}}">返回</a>
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

    $('#stock').TouchSpin({
        min: 0,
        max: 999999
    });
    $("#price").TouchSpin({
        min: 0,
        max: 99999,
        step: 0.01,
        decimals: 2,
        prefix: '@if (App::getLocale() == 'zh-cn') ￥ @else $ @endif'
    });
    $('#form').ajaxForm({
        dataType: 'json',
        success: function() {
            $('#form .form-group .help-block').empty();
            $('#form .form-group').removeClass('has-error');
            location.href='{{route("admin.product.show",["id"=>$product->id])}}';
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
    $('.thumb').change(function(){
        $(".thumb-preview").html('');
        for(i = 0; i < this.files.length; i++){
            var reader = new FileReader();
            reader.onload = function (event) {
                $(".thumb-preview").append('<img src="'+event.target.result+'" />');
            }
            reader.readAsDataURL(this.files[i]);
            console.log(this.files[i]);
        }

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
