@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row" style="margin-bottom:30px;">
        <div class="row">
            <div class="col-xs-3 col-md-3">
                <img src="/assets/images/buy.jpg" style="margin-top:-20px;" width="170">
            </div>
            <div class="col-xs-9 col-md-9">
                <!--<h3>{{trans('messages.new_items')}}</h3>-->
                <div style="margin-left:20px;">
                <img src="/assets/images/new-1.jpg" width="100" height="100"><img src="/assets/images/new-2.jpg" width="100" height="100"><img src="/assets/images/new-3.jpg" width="100" height="100"><img src="/assets/images/new-4.jpg" width="100" height="100">
                </div>
            </div>
        </div>

        <div class="row">
            @foreach ( $types as $k => $type)
            <div class="col-xs-12 col-md-6 item-type">
                <div class="row">
                    <div class="col-xs-3 col-md-5">
                        <a href="{{route('product.index',['type'=>$type->id])}}"><img  style="padding-top:20px;" src="{{asset($type->thumb)}}"></a>
                    </div>
                    <div class="col-xs-7 col-md-5">
                        <div  style="margin-left:30px;">
                        <h3 style="margin-bottom:20px;"><a href="{{route('product.index',['type'=>$type->id])}}" style="color:#ccc;">{{$type->title}}</a></h3>
                        <p>{!! $type->desc !!}</p>
                        </div>
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
