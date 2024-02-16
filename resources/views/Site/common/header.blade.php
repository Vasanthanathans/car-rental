<!DOCTYPE HTML>
<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @if (isset($heading))
            {{ $heading . ' - ' . config('myConfig.site_name') }}@else{{ config('myConfig.site_name') }}
        @endif
    </title>
    <link rel="alternate" href="{{ url('/') }}">
    <meta content="{{ config('myConfig.site_name') }}" name="author">
    <meta content="{{ config('myConfig.meta_description') }}" name="description">
    <meta content="{{ config('myConfig.meta_keywords') }}" name="keywords">
    <meta property="og:site_name" content="{{ ucfirst(config('myConfig.site_name')) }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="{{ config('myConfig.meta_title') }}">
    <meta property="og:description" content="{{ config('myConfig.meta_description') }}">
    <meta
        property="og:image"content="@if (isset($meta_image)) {{ env('FILES_BASE_URL') . $meta_image }}@else{{ env('FILES_BASE_URL') . config('myConfig.site_logo') }} @endif">
    <meta property="og:locale" content="en_US">
    <meta name="twitter:widgets:csp" content="on">
    <meta name="twitter:url" content="{{ url('/') }}">
    <meta name="twitter:description" content="{{ config('myConfig.meta_description') }}">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ config('myConfig.meta_title') }}">
    <meta property="fb:app_id" content="{{ config('myConfig.fb_app_id') }}">
    <meta name="twitter:site" content="{{ config('myConfig.twitter_name') }}">
    <meta name="twitter:app:id" content="{{ config('myConfig.twitter_app_id') }}">
    <meta name="twitter:app:name:iphone" content="{{ ucfirst(config('myConfig.site_name')) }}">
    <meta name="twitter:app:name:ipad" content="{{ ucfirst(config('myConfig.site_name')) }}">
    <meta name="twitter:app:name:googleplay" content="{{ ucfirst(config('myConfig.site_name')) }}">
    <meta name="twitter:app:id:googleplay" content="{{ url('/') }}">
    <meta name="twitter:app:url:iphone" content="{{ url('/') }}">
    <meta name="twitter:app:url:ipad" content="{{ url('/') }}">
    <meta name="twitter:app:url:googleplay" content="{{ url('/') }}">
    <link rel="shortcut icon" sizes="76x76" type="image/x-icon"
        href="{{ env('FILES_BASE_URL') . config('myConfig.fav_icon') }}" />
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap"
        rel="stylesheet">
    <!-- Site Script -->
    <link rel="stylesheet" href="{{ asset('asset/siteCss/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/siteCss/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/siteCss/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/siteCss/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/siteCss/icomoon.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/siteCss/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/siteCss/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/siteCss/open-iconic-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/siteCss/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/siteCss/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/siteCss/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/siteCss/style.css') }}">
    <!-- Site Script -->

</head>

<body>
    <header>

        <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">GoDrive<span>Now</span></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
                    aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="oi oi-menu"></span> Menu
                </button>

                <div class="collapse navbar-collapse" id="ftco-nav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item {{ Request::segment(1) == '' ? 'active' : '' }}"><a
                                href="{{ url('/') }}" class="nav-link">Home</a></li>
                        <li class="nav-item {{ Request::segment(1) == 'about' ? 'active' : '' }}"><a
                                href="{{ url('/about') }}" class="nav-link">About</a></li>
                        <li class="nav-item {{ Request::segment(1) == 'services' ? 'active' : '' }}"><a
                                href="{{ url('/services') }}" class="nav-link">Services</a></li>
                        <li class="nav-item {{ Request::segment(1) == 'pricing' ? 'active' : '' }}"><a
                                href="{{ url('/pricing') }}" class="nav-link">Pricing</a></li>
                        <li class="nav-item {{ Request::segment(1) == 'vehicle' ? 'active' : '' }}"><a
                                href="{{ url('/vehicle') }}" class="nav-link">Cars</a></li>
                        <li class="nav-item {{ Request::segment(1) == 'blog' ? 'active' : '' }}"><a
                                href="{{ url('/blog') }}" class="nav-link">Blog</a></li>
                        <li class="nav-item {{ Request::segment(1) == 'contact' ? 'active' : '' }}"><a
                                href="{{ url('/contact') }}" class="nav-link">Contact</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- END nav -->

    </header>
