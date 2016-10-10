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
			<div class="pull-right">
				<a href="{{url('/_locale',['locale'=>'en','url'=>base64_encode(Request::getUri())])}}">English</a>
				<a href="{{url('/_locale',['locale'=>'zh-cn','url'=>base64_encode(Request::getUri())])}}">中文</a>
			</div>
		</div>
	</div>
	<nav class="navbar navbar-default navbar-static-top navbar-transparent" id="navbar-custom">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="{{url('/')}}">
					<img class="dark-logo" src="{{asset('/assets/images/logo.png')}}" height="90" alt="Suzhou Cobblers">
				</a>
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#custom-collapse">
					<img src="{{asset('/assets/images/icon-menu.png')}}" />
				</button>
			</div>
			<div class="collapse navbar-collapse" id="custom-collapse">
				@include('navbar')
			</div>
		</div>
	</nav>
	<nav class="navbar navbar-default navbar-fixed-bottom" id="nav-bottom">
	  <div class="container">
		  <ul class="nav nav-pills nav-justified">
		  <!--
		    <li role="presentation"><a href="{{url('types')}}">{{trans('messages.new_items')}}</a></li>
		    <li role="presentation" class="dropup">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
					{{trans('messages.account_manage')}} <span class="caret"></span>
				</a>
				<ul class="dropdown-menu">
		          <li><a href="{{route('address.index')}}">{{trans('messages.address')}}</a></li>
		          <li><a href="{{route('account.profile')}}">{{trans('messages.profile')}}</a></li>
		        </ul>
			</li>
			-->
		    <li role="presentation"><a href="{{route('order.index')}}">{{trans('messages.my_orders')}}</a></li>
		    <li role="presentation"><a href="{{url('cart')}}"><i class="glyphicon glyphicon-shopping-cart"></i> <span class="badge" style="display:none;" id="cart-num">0</span></a></li>
		  </ul>
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
				<p class="social-img">
					<a href="https://twitter.com/suzhou_cobblers" target="_blank" rel="nofollow"><img src="{{asset('/assets/images/icon-twitter.png')}}" /></a>
					<a href="https://www.facebook.com/Suzhou-Cobblers-196740377153/?ref=bookmarks" target="_blank"><img src="{{asset('/assets/images/icon-facebook.png')}}" /></a>
					<a href="http://weibo.com/1944985263/profile?topnav=1&wvr=6" target="_blank"><img src="{{asset('/assets/images/icon-weibo.png')}}" /></a>
					<a href="https://www.instagram.com/suzhou_cobblers/" target="_blank"><img src="{{asset('/assets/images/icon-flickr.png')}}" /></a>
					<a href="https://www.pinterest.com/suzhoucobblers/" target="_blank"><img src="{{asset('/assets/images/icon-pinterest.png')}}" /></a>
					<a href="http://www.tripadvisor.cn/Attraction_Review-g308272-d1175749-Reviews-Suzhou_Cobblers_Boutique-Shanghai.html" target="_blank"><img src="{{asset('/assets/images/icon-tripadvisor.png')}}" /></a>
				</p>
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
			var h = $(window).height() - $('#footer').height() - 279;
			if ($('#mainContet').height() < $(window).height() - 400) {
				$('#mainContet').height(h);
			}

		    var url = '{{route("cart.count")}}';
		    $.getJSON(url,function(json){
		        $('#cart-num').show().text(json.data.num);
		    });
		})
	</script>
    @yield('scripts')
</body>

</html>
