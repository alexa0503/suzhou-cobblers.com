@extends('cms.layout')

@section('content')
    <div class="page-content sidebar-page right-sidebar-page clearfix">
        <!-- .page-content-wrapper -->
        <div class="page-content-wrapper">
            <div class="page-content-inner">
                <!-- Start .page-content-inner -->
                <div id="page-header" class="clearfix">
                    <div class="page-header">
                        <h2>{{$page->title}}<small>@if (App::getLocale() == 'zh-cn') 中文 @else 英文 @endif</small></h2>
                    </div>
                    <div class="header-stats">
                        <div class="spark clearfix">
                        </div>

                    </div>
                </div>
                <!-- Start .row -->
                <div class="row">
                    @foreach ($page->properties as $property)
                    {!! $property->desc !!}
                    @endforeach
                </div>
                <!-- End .row -->
            </div>
            <!-- End .page-content-inner -->
        </div>
        <!-- / page-content-wrapper -->
    </div>
@endsection
@section('scripts')
@endsection
