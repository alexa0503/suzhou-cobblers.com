@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default toggle panelMove panelClose panelRefresh">
            <!-- Start .panel -->
            <div class="panel-heading">
                <h4 class="panel-title">{{trans('messages.your_addresses')}}</h4>
            </div>
            <div class="panel-body">
                    @if ( count($addresses) > 0 )
                    <div class="form-group row well">
                        <div class="col-lg-2 col-md-3 col-xs-2 text-right">选择地址</div>
                        <div class="col-lg-10 col-md-9 col-xs-10">
                            @foreach ($addresses as $address)
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-xs-6">{{$address->first_name}} {{$address->last_name}}</div>
                                <div class="col-lg-6 col-md-6 col-xs-6 text-right">{{$address->phone_number}}</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12">
                                {{$address->country->name}}@if ($address->province != null),{{$address->province->name}}@endif @if ($address->city != null),{{$address->city->name}}@endif,{{$address->detailed_address}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-xs-6">
                                    @if ($address->is_default == 1)
                                    <label class="radio-inline">
                                      <input type="radio" name="id" id="inlineRadio3" value="" checked=""> 默认地址
                                    </label>
                                    @else
                                    <label class="radio-inline">
                                      <input type="radio" name="id" id="inlineRadio3" value="{{$address->id}}" data-url="{{route('address.default',['id'=>$address->id])}}" class="set-default"> 设为默认
                                    </label>
                                    @endif
                                </div>
                                <div class="col-lg-6 col-md-6 col-xs-6 text-right">
                                    <a href="{{route('address.show',['id'=>$address->id])}}" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> 编辑</a>
                                    <a href="{{route('address.show',['id'=>$address->id])}}" class="addressDelete btn btn-primary btn-xs"><i class="glyphicon glyphicon-trash"></i> 删除</a></div>
                            </div>
                            <div><hr></div>
                            @endforeach
                            <div class="row">
                                <a class="btn btn-primary" href="{{route('address.create')}}"><i class="glyphicon glyphicon-plus"></i> 新建地址</a>
                            </div>
                        </div>

                    </div>
                    <!-- End .form-group  -->
                    @endif
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
    $('.set-default').click(function(){
        var url = $(this).attr('data-url');
        var obj = $(this).parent();
        $.ajax(url, {
            method: 'PUT',
            dataType: 'json',
            success: function(json) {
                //alert('设置成功');
                //obj.text('默认地址');
                location.reload();
            }
        })
        //return false;
    })
    $('.addressDelete').click(function(){
        var url = $(this).attr('href');
        var obj = $(this).parents('.radio-custom');
        $.ajax(url, {
            method: 'DELETE',
            dataType: 'json',
            success: function(json) {
                if(json.ret == 0){
                    location.reload();
                }
            }
        })
        return false;
    })
})
</script>
@endsection
