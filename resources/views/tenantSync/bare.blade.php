<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta id="_token" content="width=device-width, initial-scale=1" value="{{ csrf_token() }}">
	<title>TenantSync</title>

	<!-- Sylesheets -->
	<link href="{{ URL::asset('css/all.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/font-awesome.min.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('fonts/fontawesome-webfont.svg') }}" rel="stylesheet">

	<!-- Fonts -->
	<!-- <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'> -->
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"> -->

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	@yield('head')
</head>
<body>
	<header>
		<nav class="nav navbar-default m-b"> 
			<div class="container-fluid">

				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="nav-header">
					@if(\Auth::check())
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					   	<span class="sr-only">Toggle navigation</span>
					   	<span class="icon-bar"></span>
					   	<span class="icon-bar"></span>
					   	<span class="icon-bar"></span>
					</button>
					@endif

				  	<a class="navbar-brand p-r-md" href="/"><img src="/images/logo.png" alt="TenantSync"/></a>
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse top-nav text-center" id="bs-example-navbar-collapse-1">
					@if(\Auth::check())
					<ul class="nav navbar-nav navbar-right p-r">
						@yield('topmenu')
					</ul>
					@endif
				</div><!-- /.navbar-collapse -->

			</div><!-- /.container-fluid -->
		</nav>
	</header>

		<div id="app" class="page-content-wrapper" style="{visibility: hidden}">
			<div class="container">
				<h2 class="text-info">@yield('heading')</h2>
			</div>

			<div class="container">
			@if ($errors->any())
				<div class="errors col-xs-12">
					<ul>
						@foreach($errors->all() as $error)
						<li class="text-danger">{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif

			@if (session('messages'))
				<div class="errors col-xs-12">
					<ul>
						@foreach(session('messages') as $message)
						<li class="text-success">{{ $message }}</li>
						@endforeach
					</ul>
				</div>
			@endif
			</div>

			<div class="container">
				@yield('content')
			</div>
		</div>
		
		<footer class="footer p-a">
			<div class="container">
				<div class="col-sm-4">
					<span>Copyright Valmar 2015</span>
				</div>
			</div>
		</footer>

		<!-- Scripts -->
		<script src="/js/core.js"></script>
		<script src="/js/app.js"></script>
		
		<script>
			$(window).load(function() {
				var app = document.getElementById('app');
				app.style.visibility = 'hidden';

				setTimeout(function() {
					app.style.visibility = 'visible';
				}, 500);
			});
		</script>

		@yield('scripts')

		<script>
			if(typeof vue === 'undefined') {
				var vue = new Vue({
					el: '#app',

					ready: function() {
						var app = document.getElementById('app');

						app.style.visibility = 'visible';
					},
				});
			}
		</script>

	</div>
</body>
</html>





