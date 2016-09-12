@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row page">
        <div class="col-xs-offset-1 col-xs-10 col-md-12 col-md-offset-0">
            {!! $page->content !!}
        </div>
    </div>
</div>
@endsection
@section('scripts')
@endsection
