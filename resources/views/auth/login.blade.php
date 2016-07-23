@extends('layouts.app')
@section('content')

<!-- Start login container -->
<div class="container login-container">
    <div class="login-panel panel panel-default plain animated bounceIn">
        <!-- Start .panel -->
        <div class="panel-heading">
            {{trans('messages.need_login')}}
        </div>
        <div class="panel-body">
            <form class="form-horizontal mt0" method="post" action="{{ url('/login') }}" id="login-form" role="form">
                {!! csrf_field() !!}
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <div class="col-lg-12">
                        <div class="input-group input-icon">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                            <input type="text" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="您的Email ...">
                            @if ($errors->has('email'))
                                <label id="email-error" class="help-block" for="email">{{ $errors->first('email') }}</label>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <div class="col-lg-12">
                        <div class="input-group input-icon">
                            <span class="input-group-addon"><i class="fa fa-key"></i></span>
                            <input type="password" name="password" id="password" class="form-control" value="" placeholder="您的密码">
                            @if ($errors->has('password'))
                                <label id="password-error" class="help-block" for="password">{{ $errors->first('password') }}</label>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-group mb0">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-8">
                        <div class="checkbox-custom">
                            <!--<input type="checkbox" name="remember" id="remember" value="option">
                            <label for="remember">记住我 ?</label>-->
                            <a href="{{url('password/reset')}}">{{trans('messages.forgot_password')}}</a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-4 mb25">
                        <div class="text-right">
                            <a class="btn" href="{{url('register')}}">{{trans('messages.register')}}</a>
                            <button class="btn btn-default" type="submit">{{trans('messages.login')}}</button>
                        </div>

                    </div>
                </div>
            </form>
        </div>

    </div>
    <!-- End .panel -->
</div>
<!-- End login container -->
@endsection
@section('scripts')
@endsection
