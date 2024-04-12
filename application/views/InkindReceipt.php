<!DOCTYPE html>
<html>
	<head>
	<title>Inkind Receipt</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<style>
		.marginBottom-0 {margin-bottom:0;}
		.dropdown-submenu{position:relative;}
		.dropdown-submenu>.dropdown-menu{top:0;left:100%;margin-top:-6px;margin-left:-1px;-webkit-border-radius:0 6px 6px 6px;-moz-border-radius:0 6px 6px 		6px;border-radius:0 6px 6px 6px;}
		.dropdown-submenu>a:after{display:block;content:" ";float:right;width:0;height:0;border-color:transparent;border-style:solid;border-width:5px 0 5px 5px;border-left-color:#cccccc;margin-top:5px;margin-right:-10px;}
		.dropdown-submenu:hover>a:after{border-left-color:#555;}
		.dropdown-submenu.pull-left{float:none;}.dropdown-submenu.pull-left>.dropdown-menu{left:-100%;margin-left:10px;-webkit-border-radius:6px 0 6px 6px;-moz-border-radius:6px 0 6px 6px;border-radius:6px 0 6px 6px;}

		.bgImg2{
		max-height:80vmin;
		 margin: auto; 
		 position:fixed;
		 left:0;
		 right:0;
		 margin-left:auto;
		 margin-right:auto;
		 z-index:-2;
		}
	</style>
	</head>
	<body style="background-color:#F1C40F;" name="bodyname" id="bodyId">
		<nav class="navbar navbar-inverse navbar-static-top marginBottom-0" role="navigation">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			  <a class="navbar-brand" href="#" target="_blank">Temple</a>
			</div>
			
			<div class="collapse navbar-collapse" id="navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Seva's Today<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Lakshmi Venkatesha</a>
								<ul class="dropdown-menu">
									<li><a href="#" >Panchamratha Abhisheka</a></li>
									<li><a href="#" >Ksheerabhisheka</a></li>
									<li><a href="#" >Pulukabhisheka</a></li>
									<li><a href="#" >Gangajalabhisheka</a></li>
								</ul>
							</li>
							<li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Lakshmi Devi</a>
								<ul class="dropdown-menu">
									<li><a href="#" >Pulukabhisheka</a></li>
									<li><a href="#" >Kumkumarchana </a></li>
									<li><a href="#" >Sri Saptashathi Parayana </a></li>
									<li><a href="#" >Whole day Seva</a></li>
								</ul>
							</li>
							<li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Mukhya Prana</a>
								<ul class="dropdown-menu">
									<li><a href="#" >Pavamana Abhisheka</a></li>
									<li><a href="#" >Rudrabhisheka</a></li>
								</ul>
							</li>
							<li class="dropdown dropdown-submenu"><a  href="#" class="dropdown-toggle" data-toggle="dropdown">Garuda Venkatesh</a>
								<ul class="dropdown-menu">
									<li><a href="#" >Astothara Pooja</a></li>
									<li><a href="#" >Sukrunde Naivedya</a></li>
								</ul>
							</li>
							<li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown" > MahaGanapathi</a>
								<ul class="dropdown-menu">
									<li><a href="#" >Durvarchana</a></li>
									<li><a href="#" >Apupa Naivedya</a></li>
								</ul>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
		<br/>	
		<label style="font-size:20px;">&nbsp;&nbsp;InKind Receipt</label>
		<br/><br/><br/>	
		<!--<label style="font-size:20px;">&nbsp;&nbsp;Receipt Date:<?php echo 'Today(' . date('d/m/Y'); ?>) </label>
		<label style="font-size:20px;">&nbsp;&nbsp;Receipt Date:&nbsp;<?php echo date('d/m/Y'); ?> </label>
		<label style="font-size:20px;align:right;">&nbsp;&nbsp;Receipt Number: SLVT/2017-18/IK/1&nbsp;</label>-->
		<p style="text-align:left;font-size:20px;"><b>Receipt Date:&nbsp;<?php echo date('d/m/Y'); ?>
		<span style="float:right;font-size:20px;">Receipt Number: SLVT/2017-18/IK/1</b></span>
		</p>
	</body>
</html>
<script>
	$(document).ready(function(){
		$('ul.dropdown-menu [data-toggle=dropdown]').on("click", function() {
		event.preventDefault(); 
		event.stopPropagation(); 
		$(this).parent().siblings().removeClass('open');
		$(this).parent().toggleClass('open');
	   });
	   if(window.innerWidth > 668) {
		$( "ul.dropdown-menu [data-toggle=dropdown]" ).mouseover(function() {
		 event.preventDefault(); 
		 event.stopPropagation(); 
		 $(this).parent().siblings().removeClass('open');
		 $(this).parent().toggleClass('open');
		});
	   }
	});

</script>