<!DOCTYPE html>
<html lang="en">
	<head>

        <meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="SyncroB.it HotSpot Manager">
		<meta name="Author" content="SyncroB.it">
		<meta name="Keywords" content="helium,hotspot,manager"/>

		<!-- Title -->
		<title> {{SB_CORE::getSetting(app_name)}} </title>

		<!-- Favicon -->
		<link rel="icon" href="{{SB_THEME::getResourcesImage(brand/favicon.png)}}" type="image/x-icon"/>

		<!--- Internal Fontawesome css-->
		<link href="{{SB_THEME::getResourcePlugins(fontawesome-free/css/all.min.css)}}" rel="stylesheet">

		<!---Ionicons css-->
		<link href="{{SB_THEME::getResourcePlugins(ionicons/css/ionicons.min.css)}}" rel="stylesheet">

		<!---Internal Typicons css-->
		<link href="{{SB_THEME::getResourcePlugins(typicons.font/typicons.css)}}" rel="stylesheet">

		<!---Internal Feather css-->
		<link href="{{SB_THEME::getResourcePlugins(feather/feather.css)}}" rel="stylesheet">

		<!---Internal Falg-icons css-->
		<link href="{{SB_THEME::getResourcePlugins(flag-icon-css/css/flag-icon.min.css)}}" rel="stylesheet">

		<!-- Style css -->
		<link href="{{SB_THEME::getResourceCSS(style.css)}}" rel="stylesheet">

		<!-- Dark-mode css -->
		<link href="{{SB_THEME::getResourceCSS(style-dark.css)}}" rel="stylesheet">

	</head>
	<body class="main-body dark-theme">
		
		<!-- Page -->
		<div class="page">
		
			<!-- Main-error-wrapper -->
			<div class="main-error-wrapper page page-h">
				<img src="{{SB_THEME::getResourcesImage(media/403.png)}}" class="error-page" alt="error">
				<h2>Oopps. Access denied.</h2>
				<h6>We are sorry, but you do not have access to this page or resource.</h6><a class="btn btn-outline-danger" href="/">Back to Home</a>
			</div>
			<!-- /Main-error-wrapper -->
			
		</div>
		<!-- End Page -->

		<!-- JQuery min js -->
		<script src="{{SB_THEME::getResourcePlugins(jquery/jquery.min.js)}}"></script>

		<!-- Bootstrap Bundle js -->
		<script src="{{SB_THEME::getResourcePlugins(bootstrap/js/bootstrap.bundle.min.js)}}"></script>

		<!-- Ionicons js -->
		<script src="{{SB_THEME::getResourcePlugins(ionicons/ionicons.js)}}"></script>

		<!-- Moment js -->
		<script src="{{SB_THEME::getResourcePlugins(moment/moment.js)}}"></script>

		<!-- eva-icons js -->
		<script src="{{SB_THEME::getResourceJs(eva-icons.min.js)}}"></script>

		<!-- custom js -->
		<script src="{{SB_THEME::getResourceJs(custom.js)}}"></script>

	</body>
</html>