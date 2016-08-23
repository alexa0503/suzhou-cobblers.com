@extends('cms.layout')

@section('content')
    <div class="page-content sidebar-page right-sidebar-page clearfix">
        <!-- .page-content-wrapper -->
        <div class="page-content-wrapper">
            <div class="page-content-inner">
                <!-- Start .page-content-inner -->
                <div id="page-header" class="clearfix">
                    <div class="page-header">
                        <h2>产品分类 - 编辑<small>@if (App::getLocale() == 'zh-cn') 中文 @else 英文 @endif</small></h2>
                    </div>
                </div>
                <!-- Start .row -->
                <div class="row">
                    <div class="col-lg-12">
                        <!-- col-lg-12 start here -->
                        <div class="panel panel-default">
                            <!-- Start .panel -->
                            <div class="panel-body pt0 pb0">
                                {{ Form::open(array('route' => ['admin.deliver.fee.update',$fee->id], 'class'=>'form-horizontal group-border stripped', 'id'=>'form', 'method'=>'PUT', 'role'=>'form')) }}
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">快递方式</label>
                                        <div class="col-lg-10 col-md-9">
                                            <select name="type" class="form-control">
                                                <option value="">请选择快递方式</option>
                                                @foreach ($types as $type)
                                                <option value="{{$type->id}}" @if ($fee->type_id == $type->id){{'selected="selected"'}}@endif>{{$type->name}}</option>
                                                @endforeach
                                            </select>
                                            <label class="help-block" for="type"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label class="col-lg-2 col-md-3 control-label" for="">值</label>
                                        <div class="col-lg-10 col-md-9">
                                            <div class="row" id="new-value">
                                                @foreach ($fee->value as $key=>$value)
                                                <div class="col-lg-3 col-md-3">
                                                    <div class="input-daterange input-group">
                                                        <input type="text" value="{{$key}}" class="form-control" name="key[]">
                                                        <span class="input-group-addon">:</span>
                                                        <input type="text" value="{{$value}}" class="form-control" name="value[]">
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            <label class="help-block" for="key">数量：价格，例如2：30表示购买数量少于等于2的时候单件邮费为20，单位为所属快递方式。
                                                <a href="#" id="icon-new"><i class="fa fa-plus"></i>增加</a></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label for="" class="col-lg-2 col-md-3 control-label">地区</label>
                                        <div class="col-lg-10 col-md-9">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6">
                                                    <select name="country" id="country" class="form-control">
                                                        <option value="">请选择国家</option>
                                                        @foreach ($countries as $country)
                                                        <option value="{{$country->id}}">{{$country->name_cn}}</option>
                                                        @endforeach
                                                    </select>
                                                    <label class="help-block" for="country"></label>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <select name="province" id="province" class="form-control">
                                                        <option value="">请选择省份/无</option>
                                                    </select>
                                                    <label class="help-block" for="province"></label>
                                                </div>
                                            </div>
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
var provinces = {!! $json_provinces !!};
$(document).ready(function() {
    @if ($fee->city->parent_id == null)
    $('#country').val('{{$fee->city_id}}');
    @else
    $('#country').val('{{$fee->city->parent_id}}');
    getCites('{{$fee->city->parent_id}}','{{$fee->city_id}}');
    @endif
    function getCites(id, city_id){
        var html = '<option value="">请选择省份/无</option>';
        $('#province').html(html);
        if(provinces[id]){
            $.each(provinces[id],function(index,value){
                var options = '<option value="'+value.id+'"';
                if(city_id == value.id){
                    options += ' selected="selected"';
                }

                options += '>'+value.name+'</option>';
                $('#province').append(options);
            })
        }
    }
    $('#country').change(function(event){
        var id = $(this).val();
        getCites(id);
    });
    $('#icon-new').click(function(){
        var outer_html = $('#new-value div')[0].outerHTML ;
        console.log(outer_html);
        $('#new-value').append(outer_html);
    })
    $('#form').ajaxForm({
        dataType: 'json',
        success: function() {
            $('#form .form-group .help-block').empty();
            $('#form .form-group').removeClass('has-error');
            location.href='{{route("admin.deliver.fee.index")}}';
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

});
</script>
@endsection
