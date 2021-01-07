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

		<!-- Icons css -->
		<link href="{{SB_THEME::getResourceCSS(icons.css)}}" rel="stylesheet">

		<!--  Right-sidemenu css -->
		<link href="{{SB_THEME::getResourcePlugins(sidebar/sidebar.css)}}" rel="stylesheet">

		<!-- P-scroll bar css-->
		<link href="{{SB_THEME::getResourcePlugins(perfect-scrollbar/p-scrollbar.css)}}" rel="stylesheet" />

		<!--  Left-Sidebar css -->
		<link rel="stylesheet" href="{{SB_THEME::getResourceCSS(sidemenu1.css)}}">

		<!--  jnoty css -->
		<link rel="stylesheet" href="{{SB_THEME::getResourceCSS(jnoty.min.css)}}">

		<!--  SweetAlert css -->
		<link rel="stylesheet" href="{{SB_THEME::getResourcePlugins(sweet-alert/sweetalert.css)}}">

		<!--  MapBox CSS -->
		<link href='https://api.mapbox.com/mapbox-gl-js/v2.0.0/mapbox-gl.css' rel='stylesheet' />

        {{SB_THEME::getDynmaicCSS(<?=$_GET['page'];?>)}}

		<!--- Style css --->
		<link href="{{SB_THEME::getResourceCSS(style.css)}}" rel="stylesheet">

		<!--- Dark-mode css --->
		<link href="{{SB_THEME::getResourceCSS(style-dark.css)}}" rel="stylesheet">

		<!--- Animations css-->
		<link href="{{SB_THEME::getResourceCSS(animate.css)}}" rel="stylesheet">

        <script type="text/javascript"> var baseUri = '/ajax/'; </script>
	</head>
	<?php 
	 if(SB_AUTH::checkAuth(2)){
	?>
		<body class="main-body app sidebar-mini dark-theme">
	<?php		
	 }else{
	?>
		<body class="error-page1  dark-theme">
	<?php
	 }
	?>
	
		<!-- Loader -->
		<div id="global-loader">
			<img src="{{SB_THEME::getResourcesImage(loader.svg)}}" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->

		<!-- Page -->
		<div class="page">

