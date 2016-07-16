<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="format-detection" content="telephone=no" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<meta http-equiv="x-ua-compatible" content="IE=edge" />
	<meta name="description" content="">
	<meta name="author" content="alexa">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{env('PAGE_TITLE')}}</title>
	<link href="{{asset('/assets/css/bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{asset('/assets/css/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet">
	<link href="{{asset('/assets/css/common.css')}}" rel="stylesheet">

	<link rel="icon" type="image/x-icon" href="{{asset('/assets/images/favicon.png')}}" />
	<!--移动端版本兼容 -->
	<script type="text/javascript">
		var phoneWidth = parseInt(window.screen.width);
		var phoneScale = phoneWidth / 640;
		var ua = navigator.userAgent;
		if (/Android (\d+\.\d+)/.test(ua)) {
			var version = parseFloat(RegExp.$1);
			if (version > 2.3) {
				document.write('<meta name="viewport" content="width=640, minimum-scale = ' + phoneScale + ', maximum-scale = ' + phoneScale + ', target-densitydpi=device-dpi , user-scalable=no">');
			} else {
				document.write('<meta name="viewport" content="width=640, target-densitydpi=device-dpi , user-scalable=no">');
			}
		} else {
			document.write('<meta name="viewport" content="width=640, minimum-scale=0.1, maximum-scale=1.0 , user-scalable=no" />');
		}
	</script>
	<!--移动端版本兼容 end -->
</head>

<body>
	<div class="page-header">
		<div class="container">
			<div class="pull-left">
				<a href="{{url('/_locale',['locale'=>'en','url'=>base64_encode(Request::getUri())])}}">English</a>
				<a href="{{url('/_locale',['locale'=>'zh-cn','url'=>base64_encode(Request::getUri())])}}">中文</a>
			</div>
			<div class="pull-right">
				<!--<a href="{{url('/')}}"><i class="glyphicon glyphicon-cog"></i></a>-->
				@if (Auth::guard('web')->check())
				<span>{{trans('messages.welcome')}},<a href="{{route('account')}}">{{Auth::guard('web')->user()->name}}</a></span> | <a href="{{url('logout')}}" style="margin-right:10px;">{{trans('messages.logout')}}</a>
				@else
				<span>{{trans('messages.welcome')}},{{trans('messages.guest')}}</span> | <a href="{{url('login')}}" style="margin-right:10px;">{{trans('messages.login')}}</a>
				@endif
				<a href="{{route('cart.index')}}"><i class="glyphicon glyphicon-shopping-cart"></i></a>
			</div>
		</div>
	</div>
	<nav class="navbar navbar-default navbar-static-top navbar-transparent" id="navbar-custom">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="{{url('/')}}">
					<img class="dark-logo" src="{{asset('/assets/images/logo.png')}}" alt="Suzhou Cobblers">
				</a>
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#custom-collapse">
					<img src="{{asset('/assets/images/icon-menu.png')}}" />
					<!--<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>-->
				</button>
			</div>
			<div class="collapse navbar-collapse" id="custom-collapse">
				@include('navbar')
			</div>
		</div>
	</nav>
	<div id="mainContet">
        @yield('content')

	</div>

	<div id="footer">
		<div class="container">
			<div class="text-left">
				<p>
					Copyright &copy; 2015 Suzhou Cobblers - All rights reserved
				</p>
				<!--<p class="social-img">
					<a href="https://twitter.com/suzhou_cobblers" target="_blank" rel="nofollow"><img src="{{asset('/assets/images/16-twitter.png')}}" /></a>
					<a href="http://weibo.com/suzhoucobblers" target="_blank" rel="nofollow"><img src="{{asset('/assets/images/16-sinaweibo.png')}}" /></a>
					<a href="http://www.flickr.com/photos/suzhou-cobblers/" target="_blank" rel="nofollow"><img src="{{asset('/assets/images/16-flickr.png')}}" /></a>
					<span id="TA_socialButtonBubbles326" class="social-img TA_socialButtonBubbles">
														<a target="_blank" href="http://www.tripadvisor.com/Attraction_Review-g308272-d1175749-Reviews-Suzhou_Cobblers_Boutique-Shanghai.html"><img src="http://www.tripadvisor.com/img/cdsi/img2/branding/socialWidget/20x28_green-21693-2.png"/></a>
												</span>
					<script src="http://www.jscache.com/wejs?wtype=socialButtonBubbles&amp;uniq=326&amp;locationId=1175749&amp;color=green&amp;size=rect&amp;lang=en_US&amp;display_version=2"></script>
				</p>-->
			</div>
		</div>
	</div>
	<script src="{{asset('/assets/js/jquery.min.js')}}"></script>
	<script src="{{asset('/assets/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('/assets/js/jquery.bootstrap-touchspin.min.js')}}"></script>
	<script src="{{asset('/assets/js/jquery.checkAll.js')}}"></script>
	<script>
		$().ready(function() {
			$.ajaxSetup({
	            headers: {
	                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	            }
	        });
			var h = $(window).height() - $('#footer').height() - 197;
			if ($('#mainContet').height() < $(window).height() - 200) {
				$('#mainContet').height(h);
			}
		})
	</script>
    @yield('scripts')
</body>

</html>
