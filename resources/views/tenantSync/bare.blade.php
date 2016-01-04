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

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

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
				  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				    <span class="sr-only">Toggle navigation</span>
				    <span class="icon-bar"></span>
				    <span class="icon-bar"></span>
				    <span class="icon-bar"></span>
				  </button>

				  <a class="navbar-brand p-r-md" href="/"><img src="/images/logo.png" alt="TenantSync"/></a>

				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

					@if(\Auth::check())
					<ul class="nav navbar-nav navbar-right p-r">
						<li class="dropdown">
							<a href="/logout" class="">
						  		<span class="fa fa-circle-o-notch"></span>
							</a>
						  <!-- <ul class="dropdown-menu" role="menu">
						    <li><a href="#">Action</a></li>
						    <li><a href="#">Another action</a></li>
						    <li><a href="#">Something else here</a></li>
						    <li class="divider"></li>
						    <li><a href="#">Separated link</a></li>
						  </ul> -->
						</li>
					</ul>
					@endif

					@yield('topmenu')
				
				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
		</nav>
	</header>

	<div class="page-content-wrapper">
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
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>


	<script src="/js/all.js"></script>
	<!-- <script src="/js/chart.js"></script> -->
	<script src="/js/vendor.js"></script>
	<script src="/js/plugins.js"></script>

	@yield('scripts')

</body>
</html>





