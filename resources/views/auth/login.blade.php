<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>PT. BPR SYARIAH AL-FALAH</title>

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
</head>

<body class="login" style="background-color: #54a454">
	<div>
		<a class="hiddenanchor" id="signup"></a>
		<a class="hiddenanchor" id="signin"></a>

		<div class="login_wrapper">
			<div class="animate form login_form">
				<section class="login_content">
					<form action="{{ route('login') }}" method="post">
						@csrf
						<div class="text-center">
							<img src="{{ asset('vendors/build/images/logof.png') }}" style="width: 150px">
						</div>
						<h1>Login Form</h1>
						<div>
							<input name="username" type="text" class="form-control" placeholder="username" required="" />
						</div>
						<div>
							<input type="password" class="form-control" placeholder="Password" required="" name="password" />
						</div>
						<div>
							<button type="submit" class="btn btn-success btn-block"><strong>Login</strong></button>
						</div>

						<div class="clearfix"></div>

						<div class="separator">
						</div>
					</form>
				</section>
			</div>
		</div>
	</div>
</body>

</html>
