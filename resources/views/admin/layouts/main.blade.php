<!DOCTYPE html>

<html class="loading" lang="en" data-textdirection="ltr">

<head>		

 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

    <meta name="description" content="Materialize is a Material Design Admin Template,It's modern, responsive and based on Material Design by Google.">

    <meta name="keywords" content="materialize, admin template, dashboard template, flat admin template, responsive admin template, eCommerce dashboard, analytic dashboard">

    <meta name="author" content="ThemeSelect">

    <title>Bolt Delivery App -Dashboard</title>    

    <!-- <link rel="apple-touch-icon" href="{{ url('/public/app-assets/images/favicon/apple-touch-icon-152x152.png') }}"> -->

    <link rel="shortcut icon" type="image/x-icon" href="{{ url('/public/app-assets/images/favicon/favicon-32x32.png') }}">

   <!--  <link rel="icon" href="{{ url('public/frontend/img/images/img/favicon.ico') }}" type="image/gif" sizes="16x16"> -->



    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- BEGIN: VENDOR CSS-->

    <link rel="stylesheet" type="text/css" href="{{ url('/public/app-assets/vendors/vendors.min.css') }}">

    <!-- END: VENDOR CSS-->

    <!-- BEGIN: Page Level CSS-->

    <link rel="stylesheet" type="text/css" href="{{ url('/public/app-assets/css/themes/vertical-gradient-menu-template/materialize.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ url('/public/app-assets/css/themes/vertical-gradient-menu-template/style.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ url('/public/app-assets/css/pages/dashboard.css') }}">

    <!-- END: Page Level CSS-->

    <!-- BEGIN: Custom CSS-->

    <link rel="stylesheet" type="text/css" href="{{ url('/public/app-assets/css/custom/custom.css') }}">

    <!-- END: Custom CSS-->	



		@yield('css')	



	</head>	

<body class="vertical-layout page-header-light vertical-menu-collapsible vertical-gradient-menu preload-transitions 2-columns   " data-open="click" data-menu="vertical-gradient-menu" data-col="2-columns">



		   	



			<!--header start-->			



			@include('admin.includes.header')			



			<!--header end-->			



			<!--sidebar start-->		



				@include('admin.includes.sidebar')			



				<!--sidebar end-->			



				<!--main content start-->	



				<div id="main">



      <div class="row">



        <div class="col s12">



          <div class="container">



            <div class="section">		



					@yield('content')			



					<!--main content end-->	



			</div><!-- START RIGHT SIDEBAR NAV -->







<!-- END RIGHT SIDEBAR NAV -->



          </div>



          <div class="content-overlay"></div>



        </div>



      </div>



    </div>		



					<!--footer start-->			



					@include('admin.includes.footer')		



					  <!-- END: Footer-->

    <!-- BEGIN VENDOR JS-->

    <script src="{{ url('/public/app-assets/js/vendors.min.js') }}"></script>

    <!-- BEGIN VENDOR JS-->

    <!-- BEGIN PAGE VENDOR JS-->

    <script src="{{ url('/public/app-assets/vendors/chartjs/chart.min.js') }}"></script>

    <!-- END PAGE VENDOR JS-->

    <!-- BEGIN THEME  JS-->

    <script src="{{ url('/public/app-assets/js/plugins.js') }}"></script>

    <script src="{{ url('/public/app-assets/js/search.js') }}"></script>

    <script src="{{ url('/public/app-assets/js/custom/custom-script.js') }}"></script>

    <script src="{{ url('/public/app-assets/js/scripts/customizer.js') }}"></script>

    <!-- END THEME  JS-->

    <!-- BEGIN PAGE LEVEL JS-->

    <script src="{{ url('/public/app-assets/js/scripts/dashboard-analytics.js') }}"></script>

    <!-- END PAGE LEVEL JS-->

     </script>	



	    @yield('js')	



	</body></html>