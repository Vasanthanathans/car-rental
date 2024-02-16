<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{ config('myConfig.site_name') }}</title>
    {{-- Jquery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    @yield('header')

    <link rel="stylesheet" href="{{ asset('asset/css/app.min.css') }}">

    <link href="{{ asset('asset/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('asset/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/custom.css') }}">

    <link rel='shortcut icon' type='image/x-icon' href='{{ env('FILES_BASE_URL') . config('myConfig.fav_icon') }}'
        style="width: 2px !important;" />

    <link rel="stylesheet" href="{{ asset('asset/bundles/codemirror/lib/codemirror.css') }}">
    <link rel="stylesheet" href=" {{ asset('asset/bundles/codemirror/theme/duotone-dark.css') }} ">
    <link rel="stylesheet" href=" {{ asset('asset/bundles/jquery-selectric/selectric.css') }}">
    <script src="{{ asset('asset/cdnjs/iziToast.min.js') }}"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('asset/cdncss/iziToast.css') }}" />
    <script src="{{ asset('asset/cdnjs/sweetalert.min.js') }}"></script>
    <script src="{{ asset('asset/script/env.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('asset/style/app.css') }}">

</head>

<body>
    {{-- <div class="loader"></div> --}}

    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar sticky">
                <div class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn">
                                <i data-feather="align-justify"></i></a></li>
                    </ul>
                </div>
                <ul class="navbar-nav navbar-right d-flex align-items-center">
                    <li class="pullDown">
                        <a href="{{ route('home') }}" target="_blank" class="btn btn-success ">Visit Site</a>
                    </li>
                    <li class="dropdown"><a href="#" data-toggle="dropdown"
                            class="nav-link dropdown-toggle nav-link-lg nav-link-user"> <span
                                class="d-sm-none d-lg-inline-block btn btn-light"> {{ __('Log Out') }} </span></a>
                        <div class="dropdown-menu dropdown-menu-right pullDown">

                            <a href="logout" class="dropdown-item has-icon text-danger"> <i
                                    class="fas fa-sign-out-alt"></i>
                                {{ __('Log Out') }}
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="{{ route('admin.index') }}"> <span class="logo-name"> {{ __('App Name') }} </span>
                        </a>
                    </div>
                    <ul class="sidebar-menu">

                        <li class="menu-header">{{ __('Main') }}</li>

                        <li class="sideBarli  indexSideA">
                            <a href="{{ route('admin.index') }}" class="nav-link"><i
                                    class="fas fa-tachometer-alt"></i><span>
                                    {{ __('Dashboard') }} </span></a>
                        </li>
                        @if (AdminHelper::checkPermission('subadmin-view'))
                            <li class="sideBarli  subAdminSideA">
                                <a href="{{ route('admin.subadmins') }}" class="nav-link"><i
                                        class="fa fa-users"></i><span>Admin Users</span></a>
                            </li>
                        @endif
                        @if (AdminHelper::checkPermission('user-view'))
                            <li class="sideBarli  usersSideA">
                                <a href="{{ route('admin.users') }}" class="nav-link"><i class="fa fa-users"></i><span>
                                        {{ __('Users') }} </span></a>
                            </li>
                        @endif
                        @if (AdminHelper::checkPermission('banner-view'))
                            <li class="sideBarli  bannersSideA">
                                <a href="{{ route('admin.banners') }}" class="nav-link"><i
                                        class="far fa-image"></i><span>
                                        {{ __('Banners') }} </span></a>
                            </li>
                        @endif
                        @if (AdminHelper::checkPermission('settings-view'))
                            <li class="menu-header">Settings</li>

                            <li class="sideBarli  settingsSideA">
                                <a href="{{ route('admin.settings') }}" class="nav-link"><i
                                        class="fas fa-cog"></i><span>
                                        {{ __('Settings') }} </span></a>
                            </li>

                            <li class="sideBarli  AdminSettingsSideA">
                                <a href="{{ route('admin.adminSettings') }}" class="nav-link"><i
                                        class="fas fa-cog"></i><span>Admin Settings</span></a>
                            </li>
                        @endif
                        <li class="menu-header">General Settings</li>

                        @if (AdminHelper::checkPermission('cms-view'))
                            <li class="sideBarli  CmsPagesSideA">
                                <a href="{{ route('admin.cmsPages') }}" class="nav-link"><i
                                        class="fas fa-file"></i><span>CMS Pages</span></a>
                            </li>
                        @endif
                        @if (AdminHelper::checkPermission('emailtemplate-view'))
                            <li class="sideBarli  emailTemplateSideA">
                                <a href="{{ route('admin.emailList') }}" class="nav-link"><i
                                        class="fas fa-envelope"></i><span>Email Template</span></a>
                            </li>
                        @endif
                        @if (AdminHelper::checkPermission('fileupload-view'))
                            <li class="sideBarli  fileUploadsSideA">
                                <a href="{{ route('admin.fileUploads') }}" class="nav-link"><i
                                        class="fas fa-upload"></i><span>File Uploads</span></a>
                            </li>
                        @endif
                    </ul>
                </aside>
            </div>


            <!-- Main Content -->
            <div class="main-content">

                @yield('content')

            </div>

        </div>
    </div>



    <script src="{{ asset('asset/js/app.min.js ') }}"></script>


    <script src="{{ asset('asset/bundles/datatables/datatables.min.js ') }}"></script>
    {{-- <script src=" {{ asset('asset/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script> --}}
    <script src="{{ asset('asset/bundles/jquery-ui/jquery-ui.min.js ') }}"></script>
    <script src="{{ asset('asset/js/jquery.validate.min.js') }}"></script>

    <script src=" {{ asset('asset/js/page/datatables.js') }}"></script>

    <script src="{{ asset('asset/js/scripts.js') }}"></script>
    <script src="{{ asset('asset/script/app.js') }}"></script>

    <!-- Custom JS File -->
    <script src="{{ asset('asset/bundles/summernote/summernote-bs4.js ') }}"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.js"
        integrity="sha512-Fd3EQng6gZYBGzHbKd52pV76dXZZravPY7lxfg01nPx5mdekqS8kX4o1NfTtWiHqQyKhEGaReSf4BrtfKc+D5w=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</body>


</html>
