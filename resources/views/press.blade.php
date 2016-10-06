@extends('layouts.app')
@section('content')
<div class="container">
    @foreach ($types as $type)
    <div class="row press">
        <div style="width:164px;text-align:center;" class="pull-left">
            <img src="{{asset($type->thumb)}}">
            <h4 style="margin:10px 10px;">{{$type->title}}</h4>
        </div>
        <div style="margin-left:186px;padding-right:60px;">
            <div class="rows">
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
