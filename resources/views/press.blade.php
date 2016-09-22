@extends('layouts.app')
@section('content')
<div class="container">
    @foreach ($types as $type)
    <div class="row press">
        <h3 style="font-weight:normal;margin:10px 15px 15px;">{{$type->title}}</h3>
        <div class="col-xs-offset-0 col-xs-3 col-md-3 col-md-offset-0">
            <div style="width:130px;overflow:hidden;"><img src="{{asset($type->thumb)}}"></div>
        </div>
        <div class="col-xs-9 col-md-9">
            <div class="row">
                @foreach ($type->subPresses as $press)
                <div class="press-list">
                    <img src="{{asset($press->thumb)}}" height="108">
                    <div><p style="margin:10px 0 20px;">{{$press->title}}</p></div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    @endforeach
</div>
@endsection
@section('scripts')
@endsection
