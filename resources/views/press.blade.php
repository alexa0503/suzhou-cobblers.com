@extends('layouts.app')
@section('content')
<div class="container">
    @foreach ($types as $type)
    <div class="rows"><h4 style="font-weight:normal;">{{$type->title}}</h4></div>
    <div class="row press">
        <div class="col-xs-offset-0 col-xs-3 col-md-3 col-md-offset-0">
            <img src="{{asset($type->thumb)}}">
        </div>
        <div class="col-xs-9 col-md-9">
            <div class="row">
                @foreach ($type->subPresses as $press)
                <div class="press-list">
                    <img src="{{asset($press->thumb)}}" height="108">
                    <div><p>{{$press->title}}</p></div>
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
