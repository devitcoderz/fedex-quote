<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/" />

	<title>User</title>

	<link href="{{asset('backoffice/css/app.css')}}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="{{asset('notification/toastr/toastr.min.css')}}">
    @yield('styles')
</head>

<body>
	<div class="wrapper">
		@include('user.includes/sidebar')

		<div class="main">
			@include("user.includes.topbar")

			@yield('content')

			@include('user.includes.footer')
		</div>
	</div>

	<script src="{{asset('backoffice/js/app.js')}}"></script>
	<script src="{{asset('backoffice/lib/jquery-3.1.1.js')}}"></script>
	<script src="{{asset('notification/toastr/toastr.min.js')}}"></script>
    <script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    })
    </script>
    @yield('scripts')	
</body>

</html>