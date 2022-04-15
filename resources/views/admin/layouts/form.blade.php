<!DOCTYPE html>
<html lang="en">	
<head>		
	<meta name="description" content="">		
	<meta name="author" content="Mosaddek">		
	<meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">		
	<meta name="csrf-token" content="{{ csrf_token() }}">	
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="Materialize is a Material Design Admin Template,It's modern, responsive and based on Material Design by Google.">
  <meta name="keywords" content="materialize, admin template, dashboard template, flat admin template, responsive admin template, eCommerce dashboard, analytic dashboard">
  <meta name="author" content="ThemeSelect">	
   <link rel="icon" href="{{ url('public/frontend/img/images/img/favicon.ico') }}" type="image/gif" sizes="16x16">
  <link rel="shortcut icon" type="image/x-icon" href="{{ url('/public/app-assets/images/favicon/favicon-32x32.png') }}">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">		
	<title>@yield('title')</title>		
  <link rel="stylesheet" type="text/css" href="{{ url('/public/app-assets/vendors/vendors.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('/public/app-assets/vendors/flag-icon/css/flag-icon.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('/public/app-assets/vendors/dropify/css/dropify.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('/public/app-assets/vendors/data-tables/css/jquery.dataTables.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('/public/app-assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('/public/app-assets/vendors/data-tables/css/select.dataTables.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('/public/app-assets/css/themes/vertical-modern-menu-template/materialize.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('/public/app-assets/css/themes/vertical-modern-menu-template/style.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('/public/app-assets/css/pages/data-tables.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('/public/app-assets/css/pages/page-users.css')}}"><!-- 
  <link rel="stylesheet" href="{{ url('/public/app-assets/vendors/select2/select2.min.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ url('/public/app-assets/vendors/select2/select2-materialize.css') }}" type="text/css"> -->
  <link rel="stylesheet" type="text/css" href="{{ url('/public/app-assets/css/pages/app-chat.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ url('/public/app-assets/css/pages/dashboard.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('/public/app-assets/css/custom/custom.css') }}">
  @yield('css')	
	</head>	
  <body class="vertical-layout vertical-menu-collapsible page-header-dark vertical-modern-menu preload-transitions 2-columns   " data-open="click" data-menu="vertical-modern-menu" data-col="2-columns">
    @include('admin.includes.header')			
			<!--header end-->			
			<!--sidebar start-->		
				@include('admin.includes.sidebar')			
				<!--sidebar end-->			
				<!--main content start-->	
				<div id="main">
          @yield('content')			
        <div class="content-overlay"></div>
      </div>
    @include('admin.includes.footer')		
  <script src="{{ url('/public/app-assets/js/vendors.min.js') }}"></script>
  <script src="{{ url('/public/app-assets/vendors/dropify/js/dropify.min.js') }}"></script>
  <script src="{{ url('/public/app-assets/vendors/jquery-validation/jquery.validate.min.js') }}"></script>
  <script src="{{ url('/public/app-assets/vendors/data-tables/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ url('/public/app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ url('/public/app-assets/vendors/data-tables/js/dataTables.select.min.js') }}"></script>
  <script src="{{ url('/public/app-assets/js/plugins.js') }}"></script>
  <script src="{{ url('/public/app-assets/js/search.js') }}"></script>
  <script src="{{ url('/public/app-assets/js/custom/custom-script.js') }}"></script>
  <script src="{{ url('/public/app-assets/js/scripts/customizer.js') }}"></script>
  <script src="{{ url('/public/app-assets/js/scripts/data-tables.js') }}"></script>
  <script src="{{ url('/public/app-assets/js/scripts/dashboard-ecommerce.js') }}"></script>
  <script src="{{ url('/public/app-assets/js/scripts/form-file-uploads.js') }}"></script>
  <script src="{{ url('/public/app-assets/js/scripts/page-users.js') }}"></script>
  <script src="{{ url('/public/app-assets/vendors/select2/select2.full.min.js')}}"></script>
  <script src="{{ url('/public/app-assets/js/scripts/app-chat.js')}}"></script>
  </body>
</html>
<script type="text/javascript">
$("#ImageMedias").change(function () {
  if (typeof (FileReader) != "undefined") {
    var dvPreview = $("#divImageMediaPreview");
    dvPreview.html("");            
    $($(this)[0].files).each(function () {
      var file = $(this);                
        var reader = new FileReader();
        reader.onload = function (e) {
          var img = $("<img />");
          img.attr("style", "width: 150px; height:100px; padding: 10px");
          img.attr("src", e.target.result);
          dvPreview.append(img);
        }
        reader.readAsDataURL(file[0]);                
    });
  } else {
    alert("This browser does not support HTML5 FileReader.");
  }
});</script>
 
	    @yield('js')	

	</body></html>