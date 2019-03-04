<!DOCTYPE html >
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.7
Version: 4.7.1
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8"/>
    <title>{{$settings->name}}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="Preview page of Metronic Admin Theme #3 for bootstrap alerts, notes, tooltips, progress bars, labels, badges, paginations and more"
          name="description"/>
    <meta content="" name="author"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('resources/assets/admin/global/plugins/font-awesome/css/font-awesome.min.css')}}"
          rel="stylesheet" type="text/css"/>
    <link href="{{asset('resources/assets/admin/global/plugins/simple-line-icons/simple-line-icons.min.css')}}"
          rel="stylesheet" type="text/css"/>
    <link href="{{asset('resources/assets/admin/global/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('resources/assets/admin/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}"
          rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{asset('resources/assets/admin/global/css/components.min.css')}}" rel="stylesheet"
          id="style_components" type="text/css"/>
    <link href="{{asset('resources/assets/admin/global/css/plugins.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="{{asset('resources/assets/admin/layouts/layout3/css/layout.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('resources/assets/admin/layouts/layout3/css/themes/default.min.css')}}" rel="stylesheet"
          type="text/css" id="style_color"/>
    <link href="{{asset('resources/assets/admin/custom/custom.css')}}" rel="stylesheet"
          type="text/css"/>
    <!-- END THEME LAYOUT STYLES -->

    @yield('styles')
    <link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->

<body class="page-container-bg-solid page-header-menu-fixed">
<div class="page-wrapper">
    <div class="page-wrapper-row">
        <div class="page-wrapper-top">
            <!-- BEGIN HEADER -->
            <div class="page-header">
                <!-- BEGIN HEADER TOP -->
                <div class="page-header-top">
                    <div class="container">
                        <!-- BEGIN LOGO -->
                        <div class="page-logo">
                            <a href="{{route('home')}}">
                                @if($settings->logo)
                                    <img src="{{$settings->logo}}" alt="logo" class="logo-default" style="max-height: 100%;    margin: 0px;">
                                @else
                                    {{ @$settings->name }}
                                @endif
                            </a>
                        </div>
                        <!-- END LOGO -->
                        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                        <a href="javascript:;" class="menu-toggler"></a>
                        <!-- END RESPONSIVE MENU TOGGLER -->
                        <!-- BEGIN TOP NAVIGATION MENU -->
                        <div class="top-menu">
                            <ul class="nav navbar-nav pull-right">
                                <!-- BEGIN NOTIFICATION DROPDOWN -->
                                <!-- DOC: Apply "dropdown-hoverable" class after "dropdown" and remove data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to enable hover dropdown mode -->
                                <!-- DOC: Remove "dropdown-hoverable" and add data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to the below A element with dropdown-toggle class -->

                                <!-- BEGIN USER LOGIN DROPDOWN -->
                                <li class="dropdown dropdown-user dropdown-dark">
                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"
                                       data-hover="dropdown" data-close-others="true">
                                        <img alt="" class="img-circle"
                                             src="{{asset('resources/assets/admin/layouts/layout3/img/avatar9.jpg')}}">
                                        <span class="username username-hide-mobile">{{$current_user->name}}</span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-default">


                                        @guest
                                            <li>
                                                <a href="{{ route('login') }}">
                                                    <i class="icon-key"></i> Login </a>
                                            </li>
                                        @else
                                            {{--<li>--}}
                                            {{--<a href="">--}}
                                            {{--<i class="icon-user"></i> My Profile </a>--}}
                                            {{--</li>--}}
                                            {{--<li class="divider"></li>--}}
                                            <li><a href="{{ route('logout') }}">
                                                    <i class="icon-logout"></i> Log Out </a>
                                            </li>
                                        @endguest
                                    </ul>
                                </li>
                                <!-- END USER LOGIN DROPDOWN -->

                            </ul>
                        </div>
                        <!-- END TOP NAVIGATION MENU -->
                    </div>
                </div>
                <!-- END HEADER TOP -->
                <!-- BEGIN HEADER MENU -->
                <div class="page-header-menu ">
                    <div class="container">
                        <!-- BEGIN MEGA MENU -->
                        <!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
                        <!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
                        <div class="hor-menu  ">
                            <ul class="nav navbar-nav">
                                    @permission(['dashboard','super'])
                                    <li class="nav-item start">
                                        <a href="{{url('/operate')}}" class="nav-link nav-toggle">
                                            <i class="icon-home"></i>
                                            <span class="title">Dashboard</span>
                                        </a>
                                    </li>
                                    @endpermission
                                @include('generic::layouts.side-bar')


                            </ul>
                        </div>
                        <!-- END MEGA MENU -->
                    </div>
                </div>
                <!-- END HEADER MENU -->
            </div>
            <!-- END HEADER -->
        </div>
    </div>
    <div class="page-wrapper-row full-height">
        <div class="page-wrapper-middle">
            <!-- BEGIN CONTAINER -->
            <div class="page-container">
                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->

                    <!-- BEGIN PAGE CONTENT BODY -->
                    <div class="page-content">
                        <div class="container">
                            <!-- BEGIN PAGE BREADCRUMBS -->

                        @yield('breadcrumb')


                        <!-- END PAGE BREADCRUMBS -->
                            <!-- BEGIN PAGE CONTENT INNER -->
                            <div class="page-content-inner">
                                <div class="row">
                                    @yield('content')
                                </div>
                            </div>
                            <!-- END PAGE CONTENT INNER -->
                        </div>
                    </div>
                    <!-- END PAGE CONTENT BODY -->
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
            </div>
            <!-- END CONTAINER -->
        </div>
    </div>
    <div class="page-wrapper-row">
        <div class="page-wrapper-bottom">
            <!-- BEGIN FOOTER -->
            <!-- BEGIN INNER FOOTER -->
            <div class="page-footer">
                <div class="container"><p class="copyright-v2">
                        {{date('Y')}} &copy; <a target="_blank" href="http://argaam.com/">Argaam</a>
                    </p>
                </div>
            </div>
            <div class="scroll-to-top">
                <i class="icon-arrow-up"></i>
            </div>
            <!-- END INNER FOOTER -->
            <!-- END FOOTER -->
        </div>
    </div>
</div>

<!--[if lt IE 9]>
<script src="{{asset('resources/assets/admin/global/plugins/respond.min.js')}}"></script>
<script src="{{asset('resources/assets/admin/global/plugins/excanvas.min.js')}}"></script>
<script src="{{asset('resources/assets/admin/global/plugins/ie8.fix.min.js')}}"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="{{asset('resources/assets/admin/global/plugins/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{asset('resources/assets/admin/global/plugins/bootstrap/js/bootstrap.min.js')}}"
        type="text/javascript"></script>
<script src="{{asset('resources/assets/admin/global/plugins/js.cookie.min.js')}}" type="text/javascript"></script>
<script src="{{asset('resources/assets/admin/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}"
        type="text/javascript"></script>
<script src="{{asset('resources/assets/admin/global/plugins/jquery.blockui.min.js')}}" type="text/javascript"></script>
<script src="{{asset('resources/assets/admin/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"
        type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{asset('resources/assets/admin/global/plugins/jquery.pulsate.min.js')}}" type="text/javascript"></script>
<script src="{{asset('resources/assets/admin/global/plugins/jquery-bootpag/jquery.bootpag.min.js')}}"
        type="text/javascript"></script>
<script src="{{asset('resources/assets/admin/global/plugins/holder.js')}}" type="text/javascript"></script>

<script src="{{asset('resources/assets/admin/global/scripts/datatable.js')}}"
        type="text/javascript"></script>

<script src="{{asset('resources/assets/admin/global/plugins/datatables/datatables.min.js')}}"
        type="text/javascript"></script>

<script src="{{asset('resources/assets/admin/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}"
        type="text/javascript"></script>
<script src="{{asset('resources/assets/admin/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"
        type="text/javascript"></script>

<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{asset('resources/assets/admin/global/scripts/app.min.js')}}" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->

@yield('tables')


<!-- BEGIN PAGE LEVEL SCRIPTS -->

<script src="{{asset('resources/assets/admin/pages/scripts/table-datatables-buttons.min.js')}}"
        type="text/javascript"></script>

<script src="{{asset('resources/assets/admin/pages/scripts/ui-general.min.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="{{asset('resources/assets/admin/layouts/layout3/scripts/layout.min.js')}}" type="text/javascript"></script>
<script src="{{asset('resources/assets/admin/layouts/layout3/scripts/demo.min.js')}}" type="text/javascript"></script>
<script src="{{asset('resources/assets/admin/layouts/global/scripts/quick-sidebar.min.js')}}"
        type="text/javascript"></script>
<script src="{{asset('resources/assets/admin/layouts/global/scripts/quick-nav.min.js')}}"
        type="text/javascript"></script>
<!-- END THEME LAYOUT SCRIPTS -->
<!-- BEGIN Sweet Alert SCRIPTS -->
<link href="{{asset('resources/assets/admin/global/plugins/sweet-alerts/sweetalert_2.css')}}"
      rel="stylesheet"
      type="text/css"/>
<script src="{{asset('resources/assets/admin/global/plugins/sweet-alerts/sweetalert_2.js')}}"
        type="text/javascript"></script>
@include('generic::flash')
@include('generic::new_notifications')
<!-- END Sweet Alert SCRIPTS -->
@yield('scripts')
</body>

</html>
