<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

	<head>

		<!-- CSRF Token -->

		<meta name="csrf-token" content="{{ csrf_token() }}">

 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

    <meta name="description" content="Materialize is a Material Design Admin Template,It's modern, responsive and based on Material Design by Google.">

    <meta name="keywords" content="materialize, admin template, dashboard template, flat admin template, responsive admin template, eCommerce dashboard, analytic dashboard">

    <meta name="author" content="ThemeSelect">

		<link rel="shortcut icon" href="img/favicon.png">

<style type="text/css">

      .login-css {

    max-width: 330px;

    margin: 0 auto;

    margin-top: 50px;

}

    </style>

		<title>PitchApp - {{ __('Admin Login') }}</title>



		<link rel="apple-touch-icon" href="{{ url('/public/app-assets/images/favicon/apple-touch-icon-152x152.png') }}">

        <link rel="icon" href="{{ url('public/frontend/img/images/img/favicon.ico') }}" type="image/gif" sizes="16x16">

	    <!-- Bootstrap core CSS -->

	    <link href="{{ url('/public/app-assets/vendors/vendors.min.css') }}" rel="stylesheet">

	    <link href="{{ url('/public/app-assets/css/themes/vertical-dark-menu-template/materialize.css') }}" rel="stylesheet">

	    <!--external css-->

	    <link href="{{ url('/public/app-assets/css/themes/vertical-dark-menu-template/style.css') }}" rel="stylesheet" />

		<!-- Custom styles for this template -->

		 <link href="{{ url('/public/app-assets/css/pages/login.css') }}" rel="stylesheet">

   		 <link href="{{ url('/public/app-assets/css/custom/custom.css') }}" rel="stylesheet" />



	</head>

	<body class="vertical-layout page-header-light vertical-menu-collapsible vertical-dark-menu preload-transitions 1-column login-bg   blank-page blank-page" data-open="click" data-menu="vertical-dark-menu" data-col="1-column">

		<div class="row">

        <div class="col s12">

		<div class="container">

        <div id="login-page" class="row">

                    <div class="col s12 m6 l4 z-depth-4 card-panel border-radius-6 login-card bg-opacity-8">

            @yield('content')

        

		</div>

	</div></div>

		 <div class="content-overlay"></div>

        </div>

    </div>

		<script src="{{ url('/public/app-assets/js/vendors.min.js') }}"></script>

		<script src="{{ url('/public/app-assets/js/plugins.js') }}"></script>

		<script src="{{ url('/public/app-assets/js/search.js') }}"></script>

		<script src="{{ url('/public/app-assets/js/custom/custom-script.js') }}"></script>

	</body>

</html>

