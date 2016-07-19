@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default toggle panelMove panelClose panelRefresh">
            <!-- Start .panel -->
            <div class="panel-heading">
                <h4 class="panel-title">{{trans('messages.cart')}}</h4>
            </div>
            <div class="panel-body">
                {{ Form::open(array('route' => ['order.address.store'], 'class'=>'form-horizontal', 'id'=>'form')) }}
                    @if ( count($addresses) > 0 )
                    <div class="form-group row well">
                        <div class="col-lg-2 col-md-3 col-xs-2 text-right">选择地址</div>
                        <div class="col-lg-10 col-md-9 col-xs-10">
                            @foreach ($addresses as $address)
                            <div class="radio-custom">
                                <input data-url="{{route('api.address',['id'=>$address->id])}}" type="radio" name="id" @if ($address->is_default == 1){{'checked="checked"'}}@endif value="{{$address->id}}" class="address-radio" id="address-radio-{{$address->id}}">
                                <label for="address-radio-{{$address->id}}">{{$address->country}},{{$address->province}},{{$address->city}},{{$address->detailed_address}}</label> <a href="{{route('order.address.default',['id'=>$address->id])}}" class="setDefault">[设为默认]</a> <a href="{{route('order.address.delete',['id'=>$address->id])}}" class="addressDelete">[删除]</a>
                            </div>
                            @endforeach
                        </div>

                    </div>
                    <!-- End .form-group  -->
                    @endif
                    <div class="form-group">
                        <label class="col-lg-2 col-md-3 control-label">所在地区</label>
                        <div class="col-lg-10 col-md-9">
                            <div class="row">
                                <div class="col-xs-4 col-lg-4 col-md-4">
                                    <select class="form-control" name="country">
                                        <option value="中国">中国</option>
                                        <option value="美国">美国</option>
                                        <option value="英国">英国</option>
                                    </select>
                                    <label class="help-block" for=""></label>
                                </div>
                                <div class="col-xs-4 col-lg-4 col-md-4">
                                    <select class="form-control" name="province">
                                        <option value="上海市">上海市</option>
                                        <option value="上海市">上海市</option>
                                    </select>
                                    <label class="help-block" for=""></label>
                                </div>
                                <div class="col-xs-4 col-lg-4 col-md-4">
                                    <select class="form-control" name="city">
                                        <option value="长宁区">长宁区</option>
                                        <option value="宝山区">宝山区</option>
                                    </select>
                                    <label class="help-block" for=""></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End .form-group  -->
                    <div class="form-group">
                        <label class="col-lg-2 col-md-3 control-label" for="">详细地址</label>
                        <div class="col-lg-10 col-md-9">
                            <textarea class="form-control" rows="2" name="detailed_address"></textarea>
                            <label class="help-block" for=""></label>
                        </div>
                    </div>
                    <!-- End .form-group  -->
                    <div class="form-group">
                        <label class="col-lg-2 col-md-3 control-label" for="">邮政编码</label>
                        <div class="col-lg-10 col-md-9">
                            <div class="row">
                                <div class="col-xs-6 col-lg-4 col-md-4">
                                    <input class="form-control" type="text" name="zip_code" />
                                    <label class="help-block" for=""></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End .form-group  -->
                    <div class="form-group">
                        <label class="col-lg-2 col-md-3 control-label">收货人姓名</label>
                        <div class="col-lg-10 col-md-9">
                            <div class="row">
                                <div class="col-xs-8 col-lg-4 col-md-4">
                                    <input class="form-control" placeholder="first name" type="text" name="first_name" />
                                    <label class="help-block" for=""></label>
                                </div>
                                <div class="col-xs-4 col-lg-2 col-md-2">
                                    <input class="form-control" placeholder="last name" type="text" name="last_name" />
                                    <label class="help-block" for=""></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End .form-group  -->
                    <div class="form-group">
                        <label class="col-lg-2 col-md-3 control-label" for="">联系电话</label>
                        <div class="col-lg-10 col-md-9">
                            <div class="row">
                                <div class="col-xs-4 col-lg-2 col-md-3">
                                    <select class="form-control" name="phone_district">
                                        <option value="+86">中国大陆 +86</option>
                                        <option value="+86">香港 +852</option>
                                    </select>
                                    <label class="help-block" for=""></label>
                                </div>
                                <div class="col-xs-8 col-lg-10 col-md-9">
                                    <input class="form-control" type="text" name="phone_number">
                                    <label class="help-block" for=""></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End .form-group  -->
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="row">
                                <div class="col-xs-6 col-lg-6 col-md-6">
                                    <div class="text-center">
                                        <a href="{{route('types')}}" class="btn btn-info">{{trans('messages.prev')}}</a>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-lg-6 col-md-6">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-info btn-submit">{{trans('messages.save_next')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                {{ Form::close() }}
                <!-- End .form-group  -->
            </div>
            <!-- End .panel -->
        </div>

    </div>
</div>
@endsection
@section('scripts')
<script src="{{asset('assets/js/jquery.form.js')}}"></script>
<script>
$().ready(function(){
    $('.setDefault').click(function(){
        var url = $(this).attr('href');
        $.ajax(url, {
            method: 'PUT',
            dataType: 'json',
            success: function(json) {

            }
        })
        return false;
    })
    $('.addressDelete').click(function(){
        var url = $(this).attr('href');
        var obj = $(this).parents('.radio-custom');
        $.ajax(url, {
            method: 'DELETE',
            dataType: 'json',
            success: function(json) {
                if(json.ret == 0){
                    obj.remove();
                }
            }
        })
        return false;
    })
    $('#form').ajaxForm({
        dataType: 'json',
        success: function(json) {
            if(json.ret == 0){
                $('#form .help-block').empty();
                $('#form div').removeClass('has-error');
                location.href='{{route("order.create")}}?address='+json.data.id;
            }

        },
        error: function(xhr){
            var json = jQuery.parseJSON(xhr.responseText);
            var keys = Object.keys(json);
            //console.log(keys);
            $('#form .help-block').empty();
            $('#form div').removeClass('has-error');
            $('#form .form-control').each(function(){
                var obj1 = $(this).parent('div');
                var obj2 = $(this).next('.help-block');
                var name = $(this).attr('name');
                //var name = $(this).find('input,textarea,select').attr('name');
                if( jQuery.inArray(name, keys) != -1){
                    obj1.addClass('has-error');
                    obj2.html(json[name]);
                }
            })
        }
    });
    var checked_id = null;
    if( typeof($('.address-radio:checked').val()) != 'undefined'){
        checked_id = $('.address-radio:checked').val();
        var url = $('.address-radio:checked').attr('data-url');
        setAddress(url);
    }

    $('.address-radio').click(function(){
        var id = $(this).val();
        var url = $(this).attr('data-url');
        if( id != checked_id){
            checked_id = id;
            setAddress(url);
        }

    })
    function setAddress(url){
        $.ajax(url, {
            dataType: 'json',
            success: function(json) {
                var keys = Object.keys(json);
                $('#form .form-control').each(function(){
                    var obj1 = $(this);
                    var name = $(this).attr('name');
                    if( jQuery.inArray(name, keys) != -1){
                        obj1.val(json[name]);
                    }
                })
            }
        })
    }
	//$("#mask-phone").mask("(999) 999-9999", {completed:function(){alert("Callback action after complete");}});
})
</script>
@endsection
