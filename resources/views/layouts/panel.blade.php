<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<base href="{{ url('') }}">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<!-- <link href="{{ asset('theme/img/logo/logo.png') }}" rel="icon"> -->
	<title>{{ config('app.name', 'Laravel') }}</title>
	<link rel="shortcut icon" href="{{ asset('theme/img/favicon.ico') }}" type="image/x-icon">
	<link href="{{ asset('theme/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('theme/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('theme/css/ruang-admin.css') }}" rel="stylesheet">
	<link href="{{ asset('theme/css/flag-icon.min.css') }}" rel="stylesheet">


	<link href="{{ asset('theme/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

</head>

<body id="page-top">
	<div id="wrapper">
		<!-- Sidebar -->
		<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
			<a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
				<div class="sidebar-brand-icon">
				<img src="https://magnumsk.com/view/templates/magnumsk/assets/img/logo.svg" alt="logo">
				</div>
				<div class="sidebar-brand-text mx-3">

					<!-- <a class="navbar-brand" href="{{ url('/') }}">
						{{ config('app.name', 'Laravel') }}
					</a> -->

				</div>
			</a>
			<hr class="sidebar-divider my-0">
			<li class="nav-item active">
				<a class="nav-link" href="{{ route('dashboard') }}">
					<i class="fas fa-fw fa-tachometer-alt"></i>
					<span>{{ __('Dashboard') }}</span></a>
			</li>

			<!-- {{-- @if (auth()->user()->role == 'investor')  --}} -->


			<li class="nav-item">
				<a class="nav-link" href="{{ route('promo') }}">
					<i class="fas fa-ad fa-id-badge2"></i>
					<span>{{ __('Promo') }}</span></a>
			</li>


			<li class="nav-item">
				<a class="nav-link" href="{{ route('finances') }}">
					<i class="fas fa-wallet fa-id-badge"></i>
					<span>{{ __('My finances') }}</span></a>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="{{ route('curator') }}">
					<i class="fas fa-fw fa-user-tie"></i>
					<span>{{ __('Curator') }}</span></a>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="{{ route('partners') }}">
					<i class="fas fa-fw fa-user-friends"></i>
					<span>{{ __('Partners') }}</span></a>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="{{ route('team') }}">
					<i class="fas fa-sitemap fa-id-badge"></i>
					<span>{{ __('Team scheme') }}</span></a>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="{{ route('licenses') }}">
					<i class="fas fa-fw fa-id-badge"></i>
					<span>{{ __('Licenses') }}</span></a>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="{{ route('robots') }}">
					<i class="fas fa-robot fa-id-badge"></i>
					<span>{{ __('Robots') }}</span></a>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="{{ route('news') }}">
					<i class="fas fa-list fa-id-badge"></i>
					<span>{{ __('News') }}</span></a>
			</li>


			@admininvestor
			<hr class="sidebar-divider">
			<div class="sidebar-heading">
				{{ __('Investor') }}
			</div>

			<li class="nav-item">
				<a class="nav-link" href="{{ route('investor_dashboard') }}">
					<i class="fas fa-fw fa-tachometer-alt"></i>
					<span>{{ __('Dashboard') }}</span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ route('investor') }}">
					<i class="fas fa-search-dollar fa-id-badge"></i>
					<span>{{ __('Investor finance') }}</span></a>
			</li>

			@endadmininvestor

			@admin
			<hr class="sidebar-divider">
			<div class="sidebar-heading">
				{{ __('Administration') }}
			</div>

			<li class="nav-item">
				<a class="nav-link" href="{{ route('admin.dashboard') }}">
					<i class="fas fa-fw fa-tachometer-alt"></i>
					<span>{{ __('Dashboard') }}</span></a>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="{{ route('admin.news.index') }}">
					<i class="fas fa-list fa-id-badge"></i>
					<span>{{ __('News') }}</span></a>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="{{ route('admin.robots.index') }}">
					<i class="fas fa-robot fa-id-badge"></i>
					<span>{{ __('Robots') }}</span></a>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="{{ route('admin.users') }}">
					<i class="fas fa-users fa-id-badge"></i>
					<span>{{ __('Users') }}</span></a>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="{{ route('admin.payments') }}">
					<i class="fas fa-money-check-alt fa-id-badge"></i>
					<span>{{ __('Payments') }}</span></a>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="{{ route('admin.licenses') }}">
					<i class="fas fa-fw fa-id-badge"></i>
					<span>{{ __('Licenses') }}</span></a>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="{{ route('admin.promo.index') }}">
					<i class="fas fa-ad fa-id-badge2"></i>
					<span>{{ __('Promo') }}</span></a>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="{{ route('admin.settings.index') }}">
					<i class="fas fa-tools fa-id-badge"></i>
					<span>{{ __('Settings') }}</span></a>
			</li>

			@endadmin

			<!-- 
			<li class="nav-item">
				<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap" aria-expanded="true" aria-controls="collapseBootstrap">
					<i class="far fa-fw fa-window-maximize"></i>
					<span>Bootstrap UI</span>
				</a>
				<div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
					<div class="bg-white py-2 collapse-inner rounded">
						<h6 class="collapse-header">Bootstrap UI</h6>
						<a class="collapse-item" href="alerts.html">Alerts</a>
						<a class="collapse-item" href="buttons.html">Buttons</a>
						<a class="collapse-item" href="dropdowns.html">Dropdowns</a>
						<a class="collapse-item" href="modals.html">Modals</a>
						<a class="collapse-item" href="popovers.html">Popovers</a>
						<a class="collapse-item" href="progress-bar.html">Progress Bars</a>
					</div>
				</div>
			</li>
			<li class="nav-item">
				<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseForm" aria-expanded="true" aria-controls="collapseForm">
					<i class="fab fa-fw fa-wpforms"></i>
					<span>Forms</span>
				</a>
				<div id="collapseForm" class="collapse" aria-labelledby="headingForm" data-parent="#accordionSidebar">
					<div class="bg-white py-2 collapse-inner rounded">
						<h6 class="collapse-header">Forms</h6>
						<a class="collapse-item" href="form_basics.html">Form Basics</a>
						<a class="collapse-item" href="form_advanceds.html">Form Advanceds</a>
					</div>
				</div>
			</li>
			<li class="nav-item">
				<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTable" aria-expanded="true" aria-controls="collapseTable">
					<i class="fas fa-fw fa-table"></i>
					<span>Tables</span>
				</a>
				<div id="collapseTable" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
					<div class="bg-white py-2 collapse-inner rounded">
						<h6 class="collapse-header">Tables</h6>
						<a class="collapse-item" href="simple-tables.html">Simple Tables</a>
						<a class="collapse-item" href="datatables.html">DataTables</a>
					</div>
				</div>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="ui-colors.html">
					<i class="fas fa-fw fa-palette"></i>
					<span>UI Colors</span>
				</a>
			</li>
			<hr class="sidebar-divider">
			<div class="sidebar-heading">
				Examples
			</div>
			<li class="nav-item">
				<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePage" aria-expanded="true" aria-controls="collapsePage">
					<i class="fas fa-fw fa-columns"></i>
					<span>Pages</span>
				</a>
				<div id="collapsePage" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
					<div class="bg-white py-2 collapse-inner rounded">
						<h6 class="collapse-header">Example Pages</h6>
						<a class="collapse-item" href="login.html">Login</a>
						<a class="collapse-item" href="register.html">Register</a>
						<a class="collapse-item" href="404.html">404 Page</a>
						<a class="collapse-item" href="blank.html">Blank Page</a>
					</div>
				</div>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="charts.html">
					<i class="fas fa-fw fa-chart-area"></i>
					<span>Charts</span>
				</a>
			</li> -->
			<hr class="sidebar-divider">
			<div class="version" id="version-ruangadmin"></div>
		</ul>
		<!-- Sidebar -->
		<div id="content-wrapper" class="d-flex flex-column">
			<div id="content">
				<!-- TopBar -->
				<nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
					<button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
						<i class="fa fa-bars"></i>
					</button>
					<ul class="navbar-nav ml-auto">


						<li class="nav-item dropdown mx-3">
							<a class="nav-item nav-link dropdown-toggle mr-md-2" href="#" id="bd-versions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								@if (App::getLocale() == 'en') <span class="flag-icon flag-icon-gb"></span> @endif
								@if (App::getLocale() == 'ru') <span class="flag-icon flag-icon-ru"></span> @endif
							</a>
							<div class="dropdown-menu dropdown-menu-md-right" aria-labelledby="bd-versions">

								<a class="dropdown-item @if (App::getLocale() == 'en') nav-link-child-active @endif" href="{{ route('locale', ['locale' => 'en']) }}"><span class="flag-icon flag-icon-gb mr-2"></span> EN</a>
								<a class="dropdown-item @if (App::getLocale() == 'ru') nav-link-child-active @endif" href="{{ route('locale', ['locale' => 'ru']) }}"><span class="flag-icon flag-icon-ru mr-2"></span> RU</a>

								<!-- <div class="dropdown-divider"></div> -->

							</div>
						</li>



						<!-- <li class="nav-item dropdown no-arrow mx-1">
							<a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fas fa-tasks fa-fw"></i>
								<span class="badge badge-success badge-counter">3</span>
							</a>
							<div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
								<h6 class="dropdown-header">
									Task
								</h6>
								<a class="dropdown-item align-items-center" href="#">
									<div class="mb-3">
										<div class="small text-gray-500">Design Button
											<div class="small float-right"><b>50%</b></div>
										</div>
										<div class="progress" style="height: 12px;">
											<div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</div>
								</a>
								<a class="dropdown-item align-items-center" href="#">
									<div class="mb-3">
										<div class="small text-gray-500">Make Beautiful Transitions
											<div class="small float-right"><b>30%</b></div>
										</div>
										<div class="progress" style="height: 12px;">
											<div class="progress-bar bg-warning" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</div>
								</a>
								<a class="dropdown-item align-items-center" href="#">
									<div class="mb-3">
										<div class="small text-gray-500">Create Pie Chart
											<div class="small float-right"><b>75%</b></div>
										</div>
										<div class="progress" style="height: 12px;">
											<div class="progress-bar bg-danger" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</div>
								</a>
								<a class="dropdown-item text-center small text-gray-500" href="#">View All Taks</a>
							</div>
						</li> -->

						<!-- <div class="topbar-divider d-none d-sm-block"></div> -->


						@auth
						@if (Auth::user()->getMedia('avatars')->first())
						@php ($avatar = Auth::user()->getMedia('avatars')->first()->getUrl('thumb'))
						@else
						@php ($avatar = asset('theme/img/boy.png'))
						@endif

						<li class="nav-item dropdown no-arrow">
							<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<img class="img-profile rounded-circle" src="{{ $avatar }}" style="max-width: 60px">
								<span class="ml-2 d-none d-lg-inline text-white small">{{ Auth::user()->name }}</span>
							</a>
							<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
								<a class="dropdown-item" href="{{ route('profile') }}">
									<i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
									{{ __('Profile') }}
								</a>
								<!-- <a class="dropdown-item" href="#">
									<i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
									Settings
								</a>
								<a class="dropdown-item" href="#">
									<i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
									Activity Log
								</a> -->


								<!-- <a class="dropdown-item" href="{{ route('curator') }}">
									<i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
									{{ __('Curator') }}
								</a> -->

								<!-- <a class="dropdown-item" href="{{ route('partners') }}">
									<i class="fas fa-users fa-sm fa-fw mr-2 text-gray-400"></i>
									{{ __('Partners') }}
								</a> -->

								<!-- <a class="dropdown-item" href="{{ route('licenses') }}">
									<i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
									{{ __('Licenses') }}
								</a> -->







								<div class="dropdown-divider"></div>

								<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
																	document.getElementById('logout-form').submit();">
									{{ __('Logout') }}
								</a>

								<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
									@csrf
								</form>




							</div>
						</li>
						@endauth

					</ul>
				</nav>
				<!-- Topbar -->



				<!--
				@guest
				<li class="nav-item">
					<a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
				</li>

				@if (Route::has('register'))
				<li class="nav-item">
					<a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
				</li>
				@endif

				@else
				<li class="nav-item dropdown">
					<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
						{{ Auth::user()->name }}
					</a>

					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
																	document.getElementById('logout-form').submit();">
							{{ __('Logout') }}
						</a>

						<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
							@csrf
						</form>
					</div>
				</li>
				@endguest
-->




				<!-- Container Fluid-->
				<div class="container-fluid" id="container-wrapper">
					@yield('content')
				</div>
				<!---Container Fluid-->
			</div>
			<!-- Footer -->
			<footer class="sticky-footer bg-white">
				<div class="container my-auto">
					<div class="copyright text-center my-auto">
						<span>copyright &copy; <script>
								document.write(new Date().getFullYear());
							</script> - {{ config('app.name', 'Laravel') }}
						</span>
					</div>
				</div>
			</footer>
			<!-- Footer -->
		</div>
	</div>

	<!-- Scroll to top -->
	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
	</a>

	<script src="{{ asset('theme/vendor/jquery/jquery.min.js') }}"></script>
	<script src="{{ asset('theme/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('theme/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
	<script src="{{ asset('theme/js/ruang-admin.min.js') }}"></script>
	<script src="{{ asset('theme/js/custom.js') }}"></script>
	<script src="{{ asset('theme/vendor/chart.js/Chart.min.js') }}"></script>
	<script src="{{ asset('theme/js/demo/chart-area-demo.js') }}"></script>


	<script src="https://kit.fontawesome.com/fff3308d50.js" crossorigin="anonymous"></script>

	@yield('scripts')

</body>

</html>