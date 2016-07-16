@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row" style="margin-bottom:30px;">
        <div class="row">
            <div class="col-xs-4 col-md-3">
                <img src="/assets/images/buy.jpg" style="margin-top:30px;">
            </div>
            <div class="col-xs-8 col-md-9">
                <h3>{{trans('messages.new_items')}}</h3>
                <img src="/assets/images/new-1.jpg" width="120" height="120">
                <img src="/assets/images/new-2.jpg" width="120" height="120">
                <img src="/assets/images/new-3.jpg" width="120" height="120">
                <img src="/assets/images/new-4.jpg" width="120" height="120">
                <img src="/assets/images/new-5.jpg" width="120" height="120">
                <img src="/assets/images/new-6.jpg" width="120" height="120">
            </div>
        </div>

        <div class="row">
            @foreach ( $types as $k => $type)
            <div class="col-xs-12 col-md-6 item-type">
                <div class="row">
                    <div class="col-xs-4 col-md-5">
                        <a href="{{route('product.index',['type'=>$type->id])}}"><img  style="padding-top:20px;" src="{{asset($type->thumb)}}"></a>
                    </div>
                    <div class="col-xs-8 col-md-5">
                        <h4><a href="{{route('product.index',['type'=>$type->id])}}">{{$type->title}}</a></h4>
                        <p>{!! $type->desc !!}</p>
                    </div>
                </div>
            </div>
            @if ($k%2 == 1 and $k != 0)
            <div class="clearfix visible-md-block"></div>
            @endif
            @endforeach
        </div>
    </div>
</div>
@endsection
@section('scripts')
@endsection
