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

                {{ Form::open(array('route' => ['address.store'], 'class'=>'form-horizontal group-border stripped', 'id'=>'form')) }}

                    <div class="form-group">
                        <label class="col-lg-2 col-md-3 control-label">{{trans('messages.deliver_district')}}</label>
                        <div class="col-lg-10 col-md-9">
                            <div class="row">
                                <div class="col-xs-4 col-lg-4 col-md-4">
                                    <select class="form-control" name="country_id" id="country">
                                    </select>
                                    <label class="help-block" for=""></label>
                                </div>
                                <div class="col-xs-4 col-lg-4 col-md-4">
                                    <select class="form-control" name="province_id" id="province">
                                        <option value="">{{trans("messages.select_porvince")}}</option>
                                    </select>
                                    <label class="help-block" for=""></label>
                                </div>
                                <div class="col-xs-4 col-lg-4 col-md-4">
                                    <select class="form-control" name="city_id" id="city">
                                        <option value="">{{trans("messages.select_city")}}</option>
                                    </select>
                                    <label class="help-block" for=""></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End .form-group  -->
                    <div class="form-group">
                        <label class="col-lg-2 col-md-3 control-label" for="">{{trans('messages.detailed_address')}}</label>
                        <div class="col-lg-10 col-md-9">
                            <textarea class="form-control" rows="2" name="detailed_address"></textarea>
                            <label class="help-block" for=""></label>
                        </div>
                    </div>
                    <!-- End .form-group  -->
                    <div class="form-group">
                        <label class="col-lg-2 col-md-3 control-label" for="">{{trans('messages.zip')}}</label>
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
                        <label class="col-lg-2 col-md-3 control-label">{{trans('messages.full_name')}}</label>
                        <div class="col-lg-10 col-md-9">
                            <div class="row">
                                <div class="col-xs-8 col-lg-4 col-md-4">
                                    <input class="form-control" placeholder="{{trans('messages.first_name')}}" type="text" name="first_name" />
                                    <label class="help-block" for=""></label>
                                </div>
                                <div class="col-xs-4 col-lg-2 col-md-2">
                                    <input class="form-control" placeholder="{{trans('messages.last_name')}}" type="text" name="last_name" />
                                    <label class="help-block" for=""></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End .form-group  -->
                    <div class="form-group">
                        <label class="col-lg-2 col-md-3 control-label" for="">{{trans('messages.phone_number')}}</label>
                        <div class="col-lg-10 col-md-9">
                            <input class="form-control" type="text" name="phone_number">
                            <label class="help-block" for=""></label>
                        </div>
                    </div>
                    <!-- End .form-group  -->
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="row">
                                <label class="col-lg-2 col-md-3 control-label" for=""></label>
                                <div class="col-lg-10 col-md-9">
                                    <button type="submit" class="btn btn-info btn-submit">{{trans('messages.save')}}</button>
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
@include('address.js')
<script>
$().ready(function(){

    setCountry();
    $('#country').change(function(){
        country_id = $(this).val();
        province_id = null;
        city_id = null;
        setProvince();
        //setCity();
    })



    $('#form').ajaxForm({
        dataType: 'json',
        success: function(json) {
            if(json.ret == 0){
                $('#form .help-block').empty();
                $('#form div').removeClass('has-error');
                //window.location.reload();
                location.href='{{route("address.index")}}';
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
	//$("#mask-phone").mask("(999) 999-9999", {completed:function(){alert("Callback action after complete");}});
})
</script>
@endsection
