@extends('layouts.app')
@section('content')
<div class="container">
    <div class="panel panel-default toggle panelMove panelClose panelRefresh">
        <!-- Start .panel -->
        <div class="panel-heading">
            <h4 class="panel-title">{{trans('messages.profile')}}</h4>
        </div>
        <div class="panel-body">
            {{ Form::open(array('route' => ['account.profile'], 'class'=>'form-horizontal', 'method'=>'PUT', 'id'=>'form')) }}
                <div class="form-group">
                  <label for="" class="col-lg-2 col-md-3 control-label">{{trans('messages.name')}}</label>
                  <div class="col-lg-10 col-md-9">
                      <p class="form-control-static">{{$user->name}}</p>
                  </div>
                </div>
                <div class="form-group">
                  <label for="" class="col-lg-2 col-md-3 control-label">{{trans('messages.email')}}</label>
                  <div class="col-lg-10 col-md-9">
                      <p class="form-control-static">{{$user->email}}</p>
                  </div>
                </div>
                <div class="form-group">
                  <label for="" class="col-lg-2 col-md-3 control-label">{{trans('messages.created_at')}}</label>
                  <div class="col-lg-10 col-md-9">
                      <p class="form-control-static">{{$user->created_at}}</p>
                  </div>
                </div>
                <div class="form-group">
                  <label for="" class="col-lg-2 col-md-3 control-label">{{trans('messages.updated_at')}}</label>
                  <div class="col-lg-10 col-md-9">
                      <p class="form-control-static">{{$user->updated_at}}</p>
                  </div>
                </div>
            {{ Form::close() }}
        </div>

    </div>
</div>
@endsection
@section('scripts')
@endsection
