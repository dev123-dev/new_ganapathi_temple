<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<style></style> 
		<title>SGT</title>
		<link rel="shortcut icon" href="<?php echo  base_url(); ?>images/TempleLogo.png" type="image/x-icon">
		<link rel="icon" href="<?php echo  base_url(); ?>images/TempleLogo.png" type="image/x-icon">	
		<!-- Bootstrap -->
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" crossorigin="anonymous">
		<!-- Optional theme -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-theme.min.css" crossorigin="anonymous">
		<link href="<?php echo base_url(); ?>css/quickSand.css" rel="stylesheet">
		<script src="<?php echo base_url(); ?>js/jquery-3.2.1.min.js"></script>
		<link href="<?php echo  base_url(); ?>css/jquery-ui.theme.min.css" rel="stylesheet">
		<link href="<?php echo  base_url(); ?>css/jquery-ui.min.css" rel="stylesheet">
		<link href="<?php echo  base_url(); ?>css/jquery-ui.structure.min.css" rel="stylesheet">
		<script src="<?php echo base_url(); ?>js/jquery-ui.min.js"></script>
		<link href="<?php echo base_url(); ?>css/jquery-ui.multidatespicker.css">
		<script src="<?php echo base_url(); ?>js/jquery-ui.multidatespicker.js"></script>
		<link href="<?php echo  base_url(); ?>css/bootstrap-modal-shake.css" rel="stylesheet">
		<link href='<?php echo base_url(); ?>css/fonts.googleapis.css' rel='stylesheet'>
		<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
		<script src="<?php echo base_url();?>js/bootstrap-modal-shake.js"></script>
		<link href="<?php echo  base_url(); ?>css/style.css" rel="stylesheet">
		<!--<link rel="manifest" href="<?php echo base_url(); ?>manifest.json">-->
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<!--[if gt IE 7]> <link rel="stylesheet" type="text/css" href="css/ie8.css" /> <![endif]-->
		<!-- <script type="text/javascript" src="https://s3.amazonaws.com/assets.freshdesk.com/widget/freshwidget.js"></script> -->
		<!-- <script type="text/javascript"> -->
			<!-- FreshWidget.init("", {"queryString": "&widgetType=popup&formTitle=Help+%26+Support&submitTitle=Send&submitThanks=Thank+you.+We'll+get+back+to+you+soon&searchArea=no", "utf8": "✓", "widgetType": "popup", "buttonType": "text", "buttonText": "Support", "buttonColor": "white", "buttonBg": "#006063", "alignment": "2", "offset": "500px", "submitThanks": "Thank you. We'll get back to you soon", "formHeight": "478px;", "url": "https://fatturtleherbs.freshdesk.com"} ); -->
		<!-- </script> -->
		</head>
	<body>
		<nav class="navbar navbar-inverse navbar-fixed-top top_menu" role="navigation">
			<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#"><img src="images/TempleLogo.png" class="log_size"></a>
					<a class="navbar-brand smallBrand" href="#">SHRI MAHA GANAPATHI TEMPLE</a>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav nav_navbr nav-toper log_desktop">
						<!--Add Menu Here 
						<li><a href="#myCarousel" class="menuMob">HOME</a></li>-->
					</ul>
					<ul class="nav navbar-nav nav_navbr navbar-right log_desktop">
						<!-- <li><a class="log" data-toggle="modal" data-target="#myModal" data-keyboard="false" data-backdrop="static">LOGIN</a></li> -->
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">Login
							<span class="caret"></span></a>
							<ul class="dropdown-menu">
							  <li><a data-toggle="modal" data-target="#myModal" data-keyboard="false" data-backdrop="static" onClick="loginTemple()">Login to Temple</a></li>
							  <li><a data-toggle="modal" data-target="#myModal" data-keyboard="false" data-backdrop="static" onClick="loginTrust()">Login to Trust</a></li>
							</ul>
						</li>
					</ul>
				</div>
				<!-- /.navbar-collapse -->
			</div>
			<!-- /.container -->
		</nav>
		<img class="img-responsive bgImg" src="<?=site_url()?>images/TempleLogo.png">
	<script>
		function loginTemple() {
			document.getElementById('trustLogin').checked = false;
			document.getElementById('myModalLabel').innerHTML = "SIGN IN - TEMPLE";
		}
		
		function loginTrust() {
			document.getElementById('trustLogin').checked = true;
			document.getElementById('myModalLabel').innerHTML = "SIGN IN - TRUST";
		}
	</script>