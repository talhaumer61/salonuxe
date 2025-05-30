<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $site_title }}</title>
    <!-- Animate Css -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/animate.min.css')}}">
    <!-- Bootstrap Css -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
    <!-- Font Awesome Css -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/font-awesome.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/swiper.min.css')}}">
    <!-- Owl Carousel Css -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/owl.carousel.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/owl.theme.default.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/magnific-popup.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-datepicker3.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-iso.css')}}">
    <!-- Custome Css -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/responsive.css')}}">
    <link rel="shortcut icon" type="image/png" href="{{asset('images/favicon.png')}}">

    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>

</head>

<body>
    <a href="javascript:;" id="return-to-top"> <i class="fas fa-angle-double-up"></i></a>
    <!-- preloader start -->
    {{-- <div id="preloader">
        <div id="status">
            <img src="{{asset('images/loader.gif')}}" id="preloader_image" alt="loader">
        </div>
    </div> --}}

        