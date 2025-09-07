<!doctype html><html class="fixed has-top-menu">
	<head>
		<!-- Basic -->
		<meta charset="UTF-8">
		<title>{{ $site_title }}</title>
		<meta name="keywords" content="">
		<meta name="description" content="">
		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<!-- Web Fonts  -->		
		<link href="../../../css?family=Poppins:300,400,500,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
		<!-- Vendor CSS -->
		<link rel="stylesheet" href="{{asset('dashboard/vendor/bootstrap/css/bootstrap.css')}}">		
		<link rel="stylesheet" href="{{asset('dashboard/vendor/animate/animate.compat.css')}}">		
		<link rel="stylesheet" href="{{asset('dashboard/vendor/font-awesome/css/all.min.css')}}">		
		<link rel="stylesheet" href="{{asset('dashboard/vendor/boxicons/css/boxicons.min.css')}}">		
		<link rel="stylesheet" href="{{asset('dashboard/vendor/magnific-popup/magnific-popup.css')}}">		
		<link rel="stylesheet" href="{{asset('dashboard/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css')}}">
		<!-- Specific Page Vendor CSS -->
		<link rel="stylesheet" href="{{asset('dashboard/vendor/jquery-ui/jquery-ui.css')}}">		
		<link rel="stylesheet" href="{{asset('dashboard/vendor/jquery-ui/jquery-ui.theme.css')}}">		
		<link rel="stylesheet" href="{{asset('dashboard/vendor/bootstrap-multiselect/css/bootstrap-multiselect.css')}}">		
		<link rel="stylesheet" href="{{asset('dashboard/vendor/morris/morris.css')}}">
		<!-- Theme CSS -->
		<link rel="stylesheet" href="{{asset('dashboard/css/theme.css')}}">
		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="{{asset('dashboard/css/custom.css')}}">

		<link rel="shortcut icon" type="image/png" href="{{asset('images/favicon.png')}}">
		
		{{-- Timepicker --}}
		<link rel="stylesheet" href="{{asset('dashboard/vendor/bootstrap-timepicker/css/bootstrap-timepicker.css')}}" />
		<!-- Head Libs -->
		<script src="{{asset('dashboard/vendor/modernizr/modernizr.js')}}"></script>
		<script src="{{asset('dashboard/master/style-switcher/style.switcher.localstorage.js')}}"></script>
	</head>
	<body>
		<section class="body">

        @include('salon.sessionMsg')
        @include('salon.navbar')