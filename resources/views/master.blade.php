<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="images/favicon.ico" type="image/ico" />

	<title>SPK-Promosi</title>

	<!-- Bootstrap -->
	<link href="{{ asset('vendors/resource/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="{{ asset('vendors/resource/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
	<!-- NProgress -->
	<link href="{{ asset('vendors/resource/nprogress/nprogress.css') }}" rel="stylesheet">
	<!-- iCheck -->
	<link href="{{ asset('vendors/resource/iCheck/skins/flat/green.css') }}" rel="stylesheet">

	<!-- bootstrap-progressbar -->
	<link href="{{ asset('vendors/resource/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}"
		rel="stylesheet">
	<!-- JQVMap -->
	<link href="{{ asset('vendors/resource/jqvmap/dist/jqvmap.min.css') }}" rel="stylesheet" />
	<!-- bootstrap-daterangepicker -->
	<link href="{{ asset('vendors/resource/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">

	<!-- Custom Theme Style -->
	<link href="{{ asset('vendors/build/css/custom.min.css') }}" rel="stylesheet">

	<!-- Datatables -->

	<link href="{{ asset('vendors/resource/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('vendors/resource/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('vendors/resource/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}"
		rel="stylesheet">
	<link href="{{ asset('vendors/resource/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}"
		rel="stylesheet">
	<link href="{{ asset('vendors/resource/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}"
		rel="stylesheet">

	<!-- Livewire -->
	@livewireStyles

	@yield('styles')
</head>

<body class="nav-md">
	<div class="container body">
		<div class="main_container">
			<div class="col-md-3 left_col">
				<div class="left_col scroll-view">
					<div class="navbar nav_title" style="border: 0;">

						<a href="#" class="site_title">
							{{-- <img src="{{ asset('vendors/build/images/logo.png') }}" class="profile_pic" style="width: 50px"> --}}
							<i class="fa fa-edit"></i>
							<span>&nbsp;SPK - Promosi
								Jabatan</span>
						</a>
						{{-- <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>Gentelella
                                Alela!</span></a> --}}
					</div>

					<div class="clearfix"></div>

					<!-- menu profile quick info -->
					{{-- <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="images/img.jpg" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2>John Doe</h2>
                        </div>
                    </div> --}}
					<!-- /menu profile quick info -->

					<br />

					<!-- sidebar menu -->
					<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
						<div class="menu_section">
							<h3>Menu</h3>
							<ul class="nav side-menu">
								<li>
									<a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i>Dashboard</a>
								</li>
								<li><a><i class="fa fa-edit"></i> Penilaian <span class="fa fa-chevron-down"></span></a>
									<ul class="nav child_menu">
										<li>
											<a href="{{ route('penilaian.index') }}">
												<i class="fa fa-calculator"></i>Penilaian</a>
										</li>
										<li>
											<a href="{{ route('kriteria.index') }}">
												<i class="fa fa-bar-chart"></i>Kriteria</a>
										</li>
										<li><a href="index2.html"><i class="fa fa-print"></i>Rekap</a></li>
									</ul>
								</li>
							</ul>
							<ul class="nav side-menu">
								<li>
									<a href="{{ route('karyawan.index') }}"><i class="fa fa-users"></i>Karyawan</a>
								</li>
							</ul>
						</div>


						{{-- <div class="menu_section">
							<ul class="nav side-menu">
								@if (Auth::user()->role == 'Admin')
									<li>
										<a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i>Dashboard</a>
									</li>
									<li>
										<a href="{{ route('penilaian.index') }}"><i class="fa fa-calculator"></i>Penilaian</a>
									</li>
									<li>
										<a href="{{ route('karyawan.index') }}"><i class="fa fa-users"></i>Karyawan</a>
									</li>
									<li>
										<a href="{{ route('kriteria.index') }}"><i class="fa fa-bar-chart"></i>Kriteria</a>
									</li>
									<li>
										<a href="{{ route('subkriteria.index') }}"><i class="fa fa-bar-chart"></i>Sub
											Kriteria</a>
									</li>
								@elseif(Auth::user()->role == 'Karyawan')
									<li>
										<a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i>Dashboard</a>
									</li>
									<li>
										<a href="{{ route('penilaian.index') }}"><i class="fa fa-calculator"></i>Penilaian</a>
									</li>
								@endif

							</ul>
						</div> --}}

					</div>
					<!-- /sidebar menu -->

					<!-- /menu footer buttons -->
					{{-- <div class="sidebar-footer hidden-small">
                        <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html"
                            style="color:rgba(255, 0, 0, 0.67) ">
                            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                        </a>
                    </div> --}}
					<!-- /menu footer buttons -->
				</div>
			</div>

			<!-- top navigation -->
			<div class="top_nav">
				<div class="nav_menu">
					<div class="nav toggle">
						<a id="menu_toggle"><i class="fa fa-bars"></i></a>
					</div>
					<nav class="nav navbar-nav">
						<ul class=" navbar-right">
							<li class="nav-item dropdown open" style="padding-left: 15px;">
								<a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown"
									data-toggle="dropdown" aria-expanded="false">
									{{-- <i class="fa fa-user"></i> <span>{{ Auth::user()->name }} -
										{{ Auth::user()->role }}</span> --}}
								</a>
								<div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
									{{-- <a class="dropdown-item" href="login.html"><i
                                            class="fa fa-sign-out pull-right"></i>
                                        Log Out</a> --}}
									{{-- <form method="POST" action="{{ route('logout') }}">
										@csrf

										<a href="#" class="dropdown-item" onclick="event.preventDefault(); this.closest('form').submit();">
											<i class="fa fa-sign-out pull-right"></i> Log Out
										</a>
									</form> --}}
								</div>


							</li>

						</ul>
					</nav>
				</div>
			</div>
			<!-- /top navigation -->

			<!-- page content -->
			<div class="right_col" role="main">
				<div class="row">
					<div class="col-md-12 col-sm-12 ">
						@yield('content')
					</div>
				</div>
			</div>
			<!-- /page content -->

			<!-- footer content -->
			{{-- <footer>
                <div class="pull-right">
                    Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
                </div>
                <div class="clearfix"></div>
            </footer> --}}
			<!-- /footer content -->
		</div>
	</div>

	@yield('scripts')

	<!-- jQuery -->
	<script src="{{ asset('vendors/resource/jquery/dist/jquery.min.js') }}"></script>
	<!-- Bootstrap -->
	<script src="{{ asset('vendors/resource/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
	<!-- FastClick -->
	<script src="{{ asset('vendors/resource/fastclick/lib/fastclick.js') }}"></script>
	<!-- NProgress -->
	<script src="{{ asset('vendors/resource/nprogress/nprogress.js') }}"></script>
	<!-- Chart.js -->
	<script src="{{ asset('vendors/resource/Chart.js/dist/Chart.min.js') }}"></script>
	<!-- gauge.js -->
	<script src="{{ asset('vendors/resource/gauge.js/dist/gauge.min.js') }}"></script>
	<!-- bootstrap-progressbar -->
	<script src="{{ asset('vendors/resource/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
	<!-- iCheck -->
	<script src="{{ asset('vendors/resource/iCheck/icheck.min.js') }}"></script>
	<!-- Skycons -->
	<script src="{{ asset('vendors/resource/skycons/skycons.js') }}"></script>
	<!-- Flot -->
	<script src="{{ asset('vendors/resource/Flot/jquery.flot.js') }}"></script>
	<script src="{{ asset('vendors/resource/Flot/jquery.flot.pie.js') }}"></script>
	<script src="{{ asset('vendors/resource/Flot/jquery.flot.time.js') }}"></script>
	<script src="{{ asset('vendors/resource/Flot/jquery.flot.stack.js') }}"></script>
	<script src="{{ asset('vendors/resource/Flot/jquery.flot.resize.js') }}"></script>
	<!-- Flot plugins -->
	<script src="{{ asset('vendors/resource/flot.orderbars/js/jquery.flot.orderBars.js') }}"></script>
	<script src="{{ asset('vendors/resource/flot-spline/js/jquery.flot.spline.min.js') }}"></script>
	<script src="{{ asset('vendors/resource/flot.curvedlines/curvedLines.js') }}"></script>
	<!-- DateJS -->
	<script src="{{ asset('vendors/resource/DateJS/build/date.js') }}"></script>
	<!-- JQVMap -->
	<script src="{{ asset('vendors/resource/jqvmap/dist/jquery.vmap.js') }}"></script>
	<script src="{{ asset('vendors/resource/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
	<script src="{{ asset('vendors/resource/jqvmap/examples/js/jquery.vmap.sampledata.js') }}"></script>
	<!-- bootstrap-daterangepicker -->
	<script src="{{ asset('vendors/resource/moment/min/moment.min.js') }}"></script>
	<script src="{{ asset('vendors/resource/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

	<!-- Custom Theme Scripts -->
	<script src="{{ asset('vendors/build/js/custom.min.js') }}"></script>

	<!-- Datatables -->
	<script src="{{ asset('vendors/resource/datatables.net/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('vendors/resource/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
	<script src="{{ asset('vendors/resource/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
	<script src="{{ asset('vendors/resource/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}"></script>
	<script src="{{ asset('vendors/resource/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
	<script src="{{ asset('vendors/resource/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
	<script src="{{ asset('vendors/resource/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
	<script src="{{ asset('vendors/resource/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
	<script src="{{ asset('vendors/resource/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
	<script src="{{ asset('vendors/resource/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
	<script src="{{ asset('vendors/resource/datatables.net-responsive-bs/js/responsive.bootstrap.js') }}"></script>
	<script src="{{ asset('vendors/resource/datatables.net-scroller/js/dataTables.scroller.min.js') }}"></script>
	<script src="{{ asset('vendors/resource/jszip/dist/jszip.min.js') }}"></script>
	<script src="{{ asset('vendors/resource/pdfmake/build/pdfmake.min.js') }}"></script>
	<script src="{{ asset('vendors/resource/pdfmake/build/vfs_fonts.js') }}"></script>
</body>

</html>
