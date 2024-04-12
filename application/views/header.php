<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function AmountInWords(float $amount) {
   $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
   // Check if there is any number after decimal
   $amt_hundred = null;
   $count_length = strlen($num);
   $x = 0;
   $string = array();
   $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
     3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
     7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
     10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
     13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
     16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
     19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
     40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
     70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
    $here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
    while( $x < $count_length ) {
      $get_divider = ($x == 2) ? 10 : 100;
      $amount = floor($num % $get_divider);
      $num = floor($num / $get_divider);
      $x += $get_divider == 10 ? 1 : 2;
      if ($amount) {
       $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
       $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
       $string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
        }
   else $string[] = null;
   }
   $implode_to_Rupees = implode('', array_reverse($string));
   $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';
   return ($implode_to_Rupees ? ' ('.$implode_to_Rupees . 'Rupees Only)' : '') ;
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>SLVT</title>
	<link rel="shortcut icon" href="<?php echo  base_url(); ?>images/TempleLogo.png" type="image/x-icon">
	<link rel="icon" href="<?php echo  base_url(); ?>images/TempleLogo.png" type="image/x-icon">	
    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-theme.min.css">
	<link href="<?php echo base_url(); ?>css/quickSand.css" rel="stylesheet">
    <link href="<?php echo  base_url(); ?>css/bootstrap-modal-shake.css" rel="stylesheet">
    <link href="<?php echo  base_url(); ?>css/owl.carousel.css" rel="stylesheet">
	<link href="<?php echo  base_url(); ?>css/jquery-ui.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/jquery-ui.multidatespicker.css">
	<link href="<?php echo base_url(); ?>css/sumoselect.css">
	<script src="<?php echo base_url(); ?>js/jquery-3.2.1.min.js"></script>
	<link href="<?php echo  base_url(); ?>css/jquery-ui.theme.min.css" rel="stylesheet">
    <link href="<?php echo  base_url(); ?>css/jquery-ui.structure.min.css" rel="stylesheet">
	<script src="<?php echo base_url(); ?>js/jquery-ui.min.js"></script>
	<script src="<?php echo base_url(); ?>js/jquery-ui.multidatespicker.js"></script>
    <link href='<?php echo base_url(); ?>css/fonts.googleapis.css' rel='stylesheet' type='text/css'>
	<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery-confirm.min.css">
	<script src="<?php echo base_url(); ?>js/jquery-confirm.js"></script>
	<link href="<?php echo  base_url(); ?>css/tooltip.css" rel="stylesheet">
	<link href="<?php echo  base_url(); ?>css/w3.css" rel="stylesheet">
	<link href="<?php echo  base_url(); ?>css/w4.css" rel="stylesheet">
	<link href="<?php echo  base_url(); ?>css/w5.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/notification.css">
	<link rel="stylesheet" href="<?php echo  base_url(); ?>css/bootstrap-timepicker.min.css" />
	<link rel="stylesheet" href="<?php echo  base_url(); ?>css/font-awesome.css" />
	<script src="<?php echo  base_url(); ?>js/bootstrap-timepicker.min.js"></script>
	<script src="<?php echo base_url(); ?>js/header.js"></script>
	<script src="<?php echo base_url(); ?>js/jquery.sumoselect.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.e-calendar.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery.e-calendar.css"/>
	<!--<link rel="manifest" href="<?php echo base_url(); ?>manifest.json">-->
	<style>
		@media (max-width: 1200px) {
			.navbar-header { float: none; }
			.navbar-left,.navbar-right { float: none !important; }
			.navbar-toggle { display: block; }
			.navbar-collapse { border-top: 1px solid transparent; box-shadow: inset 0 1px 0 rgba(255,255,255,0.1); }
			.navbar-fixed-top { top: 0; border-width: 0 0 1px; }
			.navbar-collapse.collapse { display: none!important; }
			.navbar-nav { float: none!important; margin-top: 7.5px; }
			.navbar-nav>li { float: none; }
			.navbar-nav>li>a { padding-top: 10px; padding-bottom: 10px; }
			.collapse.in{ display:block !important; }
			.navbar-collapse.in { overflow-y: auto !important; overflow-x:hidden !important; }
			.navbar-nav .open .dropdown-menu { position: static; float: none; width: auto; margin-top: 0; background-color: transparent;
				border: 0; box-shadow: none; }
			.navbar-nav .open .dropdown-menu>li>a, .navbar-nav .open .dropdown-menu .dropdown-header { padding: 5px 15px 5px 25px; }
			.navbar-inverse .navbar-nav .open .dropdown-menu>li>a { color: #999; }
			.navbar-inverse .navbar-nav .open .dropdown-menu>li>a:hover, 
			.navbar-inverse .navbar-nav .open .dropdown-menu>li>a:focus { color: #fff; 
				background-color: transparent; background-image:none; }
		}
	</style>
	<?php if($_SESSION['trustLogin'] != "1") { ?>
	<link href="<?php echo  base_url(); ?>css/style.css" rel="stylesheet">
	<?php } else { ?>
	<link href="<?php echo  base_url(); ?>css/trust_style.css" rel="stylesheet">
	<?php } ?>
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!--[if gt IE 7]> <link rel="stylesheet" type="text/css" href="css/ie8.css" /> <![endif]-->
	<script>
		var tabId = sessionStorage.ID ? sessionStorage.ID : sessionStorage.ID = Math.random();
	</script>
	<style>
	
		.badge12 { position: absolute;top: 0px;left: 40px;padding: 3px 4px 1px 3px;border: 2px solid white;border-radius:100px;
			background: -webkit-linear-gradient(top, #fdfdd9 0%,#fdfdd9 100%);
			box-shadow: 0 1px 2px rgba(0,0,0,.5), 0 1px 4px rgba(0,0,0,.4), 0 0 1px rgba(0,0,0,.7) inset, 0 10px 0px rgba(255,255,255,.11) inset; -webkit-background-clip: padding-box;font:bold 12px/15px "Helvetica Neue", sans-serif;color: #800000;
			text-decoration: none;text-shadow: 0 -1px 0 rgba(0,0,0,.6);z-index: 1;
		}
		
		.badge13 {
			position: absolute;top: 0px;left: 60px;padding: 2px 5px 0px 5px;border: 2px solid white;border-radius:100px;
			background: -webkit-linear-gradient(top, #fdfdd9 0%,#fdfdd9 100%);
			box-shadow: 0 1px 2px rgba(0,0,0,.5), 0 1px 4px rgba(0,0,0,.4), 0 0 1px rgba(0,0,0,.7) inset, 0 10px 0px rgba(255,255,255,.11) inset; -webkit-background-clip: padding-box;font:bold 12px/15px "Helvetica Neue", sans-serif; 
			color: #800000;text-decoration: none;text-shadow: 0 -1px 0 rgba(0,0,0,.6);z-index: 1;
		}
		
		.badge14 {
			position: absolute;top: 0px;left: 52px;padding: 2px 5px 0px 5px;border: 2px solid white;border-radius:100px;
			background: -webkit-linear-gradient(top, #fdfdd9 0%,#fdfdd9 100%);
			box-shadow: 0 1px 2px rgba(0,0,0,.5), 0 1px 4px rgba(0,0,0,.4), 0 0 1px rgba(0,0,0,.7) inset, 0 10px 0px rgba(255,255,255,.11) inset; -webkit-background-clip: padding-box;font:bold 12px/15px "Helvetica Neue", sans-serif; 
			color: #800000;text-decoration: none;text-shadow: 0 -1px 0 rgba(0,0,0,.6);z-index: 1;
		}
		
		.badge15 {
			position: absolute;top: 0px;left: 44px;padding: 3px 4px 1px 3px;border: 2px solid white;border-radius:100px;
			background: -webkit-linear-gradient(top, #fdfdd9 0%,#fdfdd9 100%);
			box-shadow: 0 1px 2px rgba(0,0,0,.5), 0 1px 4px rgba(0,0,0,.4), 0 0 1px rgba(0,0,0,.7) inset, 0 10px 0px rgba(255,255,255,.11) inset; -webkit-background-clip: padding-box;font:bold 12px/15px "Helvetica Neue", sans-serif;
			color: #800000;text-decoration: none;text-shadow: 0 -1px 0 rgba(0,0,0,.6);z-index: 1;
		}
		
		.badge16 {
			position: absolute;top: 0px;left: 66px;padding: 2px 5px 0px 5px;border: 2px solid white;border-radius:100px;
			background: -webkit-linear-gradient(top, #fdfdd9 0%,#fdfdd9 100%);
			box-shadow: 0 1px 2px rgba(0,0,0,.5), 0 1px 4px rgba(0,0,0,.4), 0 0 1px rgba(0,0,0,.7) inset, 0 10px 0px rgba(255,255,255,.11) inset; -webkit-background-clip: padding-box;font:bold 12px/15px "Helvetica Neue", sans-serif; 
			color: #800000;text-decoration: none;text-shadow: 0 -1px 0 rgba(0,0,0,.6);z-index: 1;
		}
		
		.badge17 {
			position: absolute;top: 0px;left: 60px;padding: 3px 4px 1px 3px;border: 2px solid white;border-radius:100px;
			background: -webkit-linear-gradient(top, #fdfdd9 0%,#fdfdd9 100%);
			box-shadow: 0 1px 2px rgba(0,0,0,.5), 0 1px 4px rgba(0,0,0,.4), 0 0 1px rgba(0,0,0,.7) inset, 0 10px 0px rgba(255,255,255,.11) inset; -webkit-background-clip: padding-box;font:bold 12px/15px "Helvetica Neue", sans-serif;
			color: #800000;text-decoration: none;text-shadow: 0 -1px 0 rgba(0,0,0,.6);z-index: 1;
		}

		.badge18 {
			position: absolute;top: 0px;left: 112px;padding: 2px 5px 0px 5px;border: 2px solid white;border-radius:100px;
			background: -webkit-linear-gradient(top, #fdfdd9 0%,#fdfdd9 100%);
			box-shadow: 0 1px 2px rgba(0,0,0,.5), 0 1px 4px rgba(0,0,0,.4), 0 0 1px rgba(0,0,0,.7) inset, 0 10px 0px rgba(255,255,255,.11) inset; -webkit-background-clip: padding-box;font:bold 12px/15px "Helvetica Neue", sans-serif; 
			color: #800000;text-decoration: none;text-shadow: 0 -1px 0 rgba(0,0,0,.6);z-index: 1;
		}
		
		.badge19 {
			position: absolute;top: 0px;left: 106px;padding: 3px 4px 1px 3px;border: 2px solid white;border-radius:100px;
			background: -webkit-linear-gradient(top, #fdfdd9 0%,#fdfdd9 100%);
			box-shadow: 0 1px 2px rgba(0,0,0,.5), 0 1px 4px rgba(0,0,0,.4), 0 0 1px rgba(0,0,0,.7) inset, 0 10px 0px rgba(255,255,255,.11) inset; -webkit-background-clip: padding-box;font:bold 12px/15px "Helvetica Neue", sans-serif;
			color: #800000;text-decoration: none;text-shadow: 0 -1px 0 rgba(0,0,0,.6);z-index: 1;
		}

		.badge20 {
			position: absolute;top: 0px;left: 86px;padding: 2px 5px 0px 5px;border: 2px solid white;border-radius:100px;
			background: -webkit-linear-gradient(top, #fdfdd9 0%,#fdfdd9 100%);
			box-shadow: 0 1px 2px rgba(0,0,0,.5), 0 1px 4px rgba(0,0,0,.4), 0 0 1px rgba(0,0,0,.7) inset, 0 10px 0px rgba(255,255,255,.11) inset; -webkit-background-clip: padding-box;font:bold 12px/15px "Helvetica Neue", sans-serif; 
			color: #800000;text-decoration: none;text-shadow: 0 -1px 0 rgba(0,0,0,.6);z-index: 1;
		}

		.badge21 {
			position: absolute;top: 0px;left: 106px;padding: 3px 4px 1px 3px;border: 2px solid white;border-radius:100px;
			background: -webkit-linear-gradient(top, #fdfdd9 0%,#fdfdd9 100%);
			box-shadow: 0 1px 2px rgba(0,0,0,.5), 0 1px 4px rgba(0,0,0,.4), 0 0 1px rgba(0,0,0,.7) inset, 0 10px 0px rgba(255,255,255,.11) inset; -webkit-background-clip: padding-box;font:bold 12px/15px "Helvetica Neue", sans-serif;
			color: #800000;text-decoration: none;text-shadow: 0 -1px 0 rgba(0,0,0,.6);z-index: 1;
		}
		
		.badge22 {
			position: absolute;top: 0px;left: 92px;padding: 2px 5px 0px 5px;border: 2px solid white;border-radius:100px;
			background: -webkit-linear-gradient(top, #fdfdd9 0%,#fdfdd9 100%);
			box-shadow: 0 1px 2px rgba(0,0,0,.5), 0 1px 4px rgba(0,0,0,.4), 0 0 1px rgba(0,0,0,.7) inset, 0 10px 0px rgba(255,255,255,.11) inset; -webkit-background-clip: padding-box;font:bold 12px/15px "Helvetica Neue", sans-serif; 
			color: #800000;text-decoration: none;text-shadow: 0 -1px 0 rgba(0,0,0,.6);z-index: 1;
		}
		.badge23 {
			position: absolute;top: 0px;left: 60px;padding: 3px 4px 1px 3px;border: 2px solid white;border-radius:100px;
			background: -webkit-linear-gradient(top, #fdfdd9 0%,#fdfdd9 100%);
			box-shadow: 0 1px 2px rgba(0,0,0,.5), 0 1px 4px rgba(0,0,0,.4), 0 0 1px rgba(0,0,0,.7) inset, 0 10px 0px rgba(255,255,255,.11) inset; -webkit-background-clip: padding-box;font:bold 12px/15px "Helvetica Neue", sans-serif;
			color: #800000;text-decoration: none;text-shadow: 0 -1px 0 rgba(0,0,0,.6);z-index: 1;
		}
		
		
	select {
		color:black !important;
	}
		
	@media (max-width: 767px) {
		.xs{
		margin-left:12px; }
	}

	.custom {
		width: 78px !important;
	}

	@media (max-width: 767px) {
		.roi-top{
			margin-top:20px;
		}
	}

	.topClosePos{
	 margin-top:-0.6em !important;
    }
	
	a.notifDate:hover {
		color:#800000;
	} 
	/*code for progress bar*/
	#work-in-progress {
	  position: fixed;
	  width: 100%;
	  height: 100%;
	  font-size: 100px;
	  top: 50%;
	  text-align: center;
	  vertical-align: middle;
	  color: #00000;
	  z-index: 100000;
	}

	#loading-progress-text{
	  position: fixed;
	  width: 100%;
	  height: 100%;
	  top: 55%;
	  font-size: 20px;
	  font-weight: bold;
	  color: black;
	  text-align: center;
	  vertical-align: middle;
	  z-index: 100000;
	}

	.work-spinner {
	  background-color: #fdfdd9;
	  border: 9px solid rgba(128, 0, 0, 0.92);
	  opacity: .9;
	  border-left: 5px solid rgba(0,0,0,0);
	  border-radius: 120px;
	  
	  width: 100px; 
	  height: 100px;
	  margin: 0 auto;
	  -moz-animation: spin .5s infinite linear;
	  -webkit-animation: spin .5s infinite linear;
	  -o-animation: spin .5s infinite linear;
	  animation: spin .5s infinite linear;
	}

	@-moz-keyframes spin {
	 from {
	     -moz-transform: rotate(0deg);
	 }
	 to {
	     -moz-transform: rotate(360deg);
	 }
	}

	@-webkit-keyframes spin {
	 from {
	     -webkit-transform: rotate(0deg);
	 }
	 to {
	     -webkit-transform: rotate(360deg);
	 }
	}

	@keyframes spin {
	 from {
	     transform: rotate(0deg);
	 }
	 to {
	     transform: rotate(360deg);
	 }
	}
	@-o-keyframes spin {
	 from {transform: rotate(0deg);}
	 to {transform: rotate(360deg);}
	}
	 /* progress bar code ends here*/
</style>
</style>
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top top_menu" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<?php if(isset($_SESSION['Deity_Sevas'])) { ?>
					<a class="navbar-brand" href="<?=site_url()?>Sevas"><img src="<?php echo  base_url(); ?>images/TempleLogo.png" class="log_size"></a>
				<?php } else { ?>
					<a class="navbar-brand" href="<?=site_url()?>"><img src="<?php echo  base_url(); ?>images/TempleLogo.png" class="log_size"></a>
				<?php } ?>
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav nav_navbr nav-toper log_desktop">

				<?php if(isset($_SESSION['Deity_Sevas']) && $_SESSION['trustLogin'] != "1") { ?>
						<li class="deitySevas">
							<a href="<?=site_url()?>Sevas/">Sevas 
								<?php if(@$_SESSION['deityCount'] != "") { ?>
									<?php if(strlen($_SESSION['deityCount']) == "1") { ?>
										<span class="badge14"><?=$_SESSION['deityCount'];?></span>
									<?php } else { ?>
										<span class="badge15"><?=$_SESSION['deityCount'];?></span>
									<?php } ?>
								<?php } ?>
							</a>
						</li>
				<?php } ?>
					
					<!---shashwath -->
				<?php /*print_r($_SESSION);*/ if((isset($_SESSION['Shashwath'])) || isset($_SESSION['Shashwath_Seva'])|| isset($_SESSION['Shashwath_Member'])|| isset($_SESSION['Shashwath_Loss_Report'])|| isset($_SESSION['Shashwath_New_Member']) && $_SESSION['trustLogin'] != "1") { ?>
						<li class="dropdown shashwath">
							<a  class="dropdown-toggle text" data-toggle="dropdown">Shashwath 
							<?php if(@$_SESSION['shashwathCount'] != "") { ?>
									<?php if(strlen($_SESSION['shashwathCount']) == "1") { ?>
										<span class="badge22"><?=$_SESSION['shashwathCount'];?></span>
									<?php } else { ?>
										<span class="badge23"><?=$_SESSION['shashwathCount'];?></span>
									<?php } ?>
							<?php } ?>
							</a>
								<ul class="dropdown-menu" id="double-click">
									<?php if(isset($_SESSION['Shashwath_Seva'])) { ?>
										<li ><a onclick="getShashwathSevaAndProgress()" style="color: #565656;font-weight: 600;font-size: 15px;text-shadow: none;">Shashwath Seva</a></li>             
									<?php } ?>
									<?php if(isset($_SESSION['Shashwath_Member'])) { ?>
										<li ><a href="<?php echo site_url();?>Shashwath/shashwath_member" style="color: #565656;font-weight: 600;font-size: 15px;text-shadow: none;">Shashwath Members</a></li>             
									<?php } ?>
									<?php if(isset($_SESSION['Shashwath_New_Member'])) { ?>
										<li><a href="<?php echo site_url();?>Shashwath/addMember" style="color: #565656;font-weight: 600;font-size: 15px;text-shadow: none;">Shashwath New Member</a></li>
									<?php } ?>
									<?php if(isset($_SESSION['Shashwath_Loss_Report'])) { ?>
										<li ><a href="<?php echo site_url();?>Shashwath/lossReport" style="color: #565656;font-weight: 600;font-size: 15px;text-shadow: none;">Shashwath Loss Report</a></li>             
									<?php } ?>
									<?php if(isset($_SESSION['Shashwath_Existing_Import'])) { ?>	
										<li><a href="<?php echo site_url();?>admin_settings/Admin_setting/existing_import_setting">Shashwath Existing Import</a></li>
									<?php } ?>
									<!-- <li><a href="<?php echo site_url();?>Shashwath/smRefIssue">Shashwath Duplicate Record</a></li>	 -->
								</ul>	
						</li>
				<?php } ?>
				
				<!--jeernodhara-->
				<?php if((isset($_SESSION['Jeernodhara'])) || isset($_SESSION['Jeernodhara_Kanike'])|| isset($_SESSION['Jeernodhara_Hundi'])|| isset($_SESSION['Jeernodhara_Inkind'])|| isset($_SESSION['Jeernodhara_Daily_Report']) && $_SESSION['trustLogin'] != "1") { ?>
				 <li class="dropdown Jeernodhara">
							<a  class="dropdown-toggle text" data-toggle="dropdown">Jeernodhara</a>
								<ul class="dropdown-menu">
									<?php if(isset($_SESSION['Jeernodhara_Kanike'])) { ?>
										<li><a href="<?php echo site_url();?>Jeernodhara/Jeernodhara_Kanike/" style="color: #565656;font-weight: 600;font-size: 15px;text-shadow: none;">Jeernodhara Kanike</a></li>             
									<?php } ?>
									<?php if(isset($_SESSION['Jeernodhara_Hundi'])) { ?>
										<li><a href="<?php echo site_url();?>Jeernodhara/Jeernodhara_Hundi/" style="color: #565656;font-weight: 600;font-size: 15px;text-shadow: none;">Jeernodhara Hundi</a></li>             
									<?php } ?>
									<?php if(isset($_SESSION['Jeernodhara_Inkind'])) { ?>
										<li><a href="<?php echo site_url();?>Jeernodhara/Jeernodhara_Inkind/" style="color: #565656;font-weight: 600;font-size: 15px;text-shadow: none;">Jeernodhara Inkind</a></li>
									<?php } ?>
									<?php if(isset($_SESSION['Jeernodhara_Daily_Report'])) { ?>
										<li><a href="<?php echo site_url();?>Receipt/daily_report/" style="color: #565656;font-weight: 600;font-size: 15px;text-shadow: none;">Jeernodhara Daily Report</a></li>             
									<?php } ?>
								</ul>	
						</li>
				<?php } ?>

				<?php if(isset($_SESSION['Deity_Token']) && $_SESSION['trustLogin'] != "1") { ?>
						<li class="deityToken">
							<a href="<?=site_url();?>Sevas/deity_token">Deity Token</a>
						</li>
				<?php } ?>

				<?php if(isset($_SESSION['Event_Sevas']) && $_SESSION['trustLogin'] != "1") { ?>
						<li <?php if(@$_SESSION['eventActiveCount'] == 0) echo "style='display:none;'"?> class="eventSevas">
							<a href="<?=site_url();?>Events/">Events
								<?php if(@$_SESSION['sevaCount'] != "") { ?>
									<?php if(strlen($_SESSION['sevaCount']) == "1") { ?>
										<span class="badge13"><?=$_SESSION['sevaCount'];?></span>
									<?php } else { ?>
										<span class="badge12"><?=$_SESSION['sevaCount'];?></span>
									<?php } ?>
								<?php } ?>
							</a>
						</li>
				<?php } ?>

				<?php if(isset($_SESSION['Event_Token']) && $_SESSION['trustLogin'] != "1") { ?>

						<li <?php if(@$_SESSION['eventActiveCount'] == 0) echo "style='display:none;'"?> class="eventToken">
							<a href="<?=site_url();?>Events/event_token">Event Token</a>
						</li>
				<?php } ?>

				<?php if((isset($_SESSION['Book_Seva']) || isset($_SESSION['All_Booked_Sevas']) || isset($_SESSION['Booked_Pending_Receipts'])) && $_SESSION['trustLogin'] != "1") {  ?>
						<li class="dropdown booking">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">Booking</a>
							<ul class="dropdown-menu">
								<?php if(isset($_SESSION['Book_Seva'])) { ?>
									<li><a href="<?php echo site_url();?>SevaBooking/book_Seva/">Book Seva</a></li>
								<?php } ?>
								<?php if(isset($_SESSION['All_Booked_Sevas'])) { ?>
								<li><a href="<?php echo site_url();?>SevaBooking/">All Booked Sevas</a></li>
								<?php } ?>
								<?php if(isset($_SESSION['Booked_Pending_Receipts'])) { ?>
								<li><a href="<?php echo site_url();?>SevaBooking/BookedPendingReceipt">Booked pending Receipts</a></li>
								<?php } ?>
							</ul>
						</li>
				<?php } ?>
				<?php 
				if($_SESSION['trustLogin'] != "1") {
						if((isset($_SESSION['All_Deity_Receipt'])) || (isset($_SESSION['All_Event_Receipt'])) || (isset($_SESSION['Deity_Seva'])) || (isset($_SESSION['Deity_Donation'])) || (isset($_SESSION['Deity_Kanike'])) || (isset($_SESSION['Event_Seva'])) || (isset($_SESSION['Event_Donation/Kanike'])) || (isset($_SESSION['Deity/Event_Hundi'])) || (isset($_SESSION['Deity/Event_Inkind']))) { ?>
							<li class="dropdown receipt">
								<a class="dropdown-toggle" data-toggle="dropdown" href="#">Receipt</a>
								<ul class="dropdown-menu">
									<?php if(isset($_SESSION['All_Deity_Receipt'])) { ?>
										<li><a href="<?php echo site_url();?>Receipt/all_receipt_deity">All Deity Receipt</a></li>
									<?php } ?>
									<?php if(isset($_SESSION['All_Event_Receipt'])) { ?>
										<li <?php if(@$_SESSION['eventActiveCount'] == 0) echo "style='display:none;'"?> ><a href="<?php echo site_url();?>Receipt/all_receipt">All Event Receipt</a></li>
									<?php } ?>
									<?php if(isset($_SESSION['Deity_Seva'])) { ?>
										<li><a href="<?php echo site_url();?>Receipt/deitySevaReceipt">Deity Seva</a></li>
									<?php } ?>
									<?php if(isset($_SESSION['Deity_Donation'])) { ?>
										<li><a href="<?php echo site_url();?>Receipt/receipt_deity_donation">Deity Donation</a></li>
									<?php } ?>
									<?php if(isset($_SESSION['Deity_Kanike'])) { ?>
										<li><a href="<?php echo site_url();?>Receipt/receipt_deity_kanike">Deity Kanike</a></li>
									<?php } ?>	
									<?php if(isset($_SESSION['Event_Seva'])) { ?>	
										<li <?php if(@$_SESSION['eventActiveCount'] == 0) echo "style='display:none;'"?> ><a href="<?php echo site_url();?>Events/event_receipt">Event Seva</a></li>
									<?php } ?>	
									<?php if(isset($_SESSION['Event_Donation/Kanike'])) { ?>
										<li <?php if(@$_SESSION['eventActiveCount'] == 0) echo "style='display:none;'"?> ><a href="<?php echo site_url();?>Receipt/receipt_donation">Event Donation/Kanike</a></li>
									<?php } ?>	
									<?php if(isset($_SESSION['Deity/Event_Hundi'])) { ?>
										<?php if(@$_SESSION['eventActiveCount'] == 0) { ?>
											<li><a href="<?php echo site_url();?>Receipt/receipt_hundi">Deity Hundi</a></li>
										<?php } else { ?>
											<li><a href="<?php echo site_url();?>Receipt/receipt_hundi">Deity/Event Hundi</a></li>
										<?php } ?>	
									<?php } ?>	
									<?php if(isset($_SESSION['Deity/Event_Inkind'])) { ?>
										<?php if(@$_SESSION['eventActiveCount'] == 0) { ?>
											<li><a href="<?php echo site_url();?>Receipt/receipt_inkind">Deity InKind</a></li>
										<?php } else { ?>
											<li><a href="<?php echo site_url();?>Receipt/receipt_inkind">Deity/Event InKind</a></li>
										<?php } ?>	
									<?php } ?>	
									<?php if(isset($_SESSION['SRNS_Fund'])) { ?>
										<li><a href="<?php echo site_url();?>Receipt/receipt_srns_fund">S.R.N.S. Fund</a></li>
									<?php } ?>	
								</ul>
							</li>
						<?php } ?>
				<?php if((isset($_SESSION['Deity_Receipt_Report'])) || (isset($_SESSION['Deity_Seva_Report'])) || (isset($_SESSION['Deity_MIS_Report'])) || (isset($_SESSION['Current_Event_Receipt_Report'])) || (isset($_SESSION['Current_Event_Seva_Report'])) || (isset($_SESSION['Current_Event_MIS_Report'])) || (isset($_SESSION['User_Event_Collection_Report'])) || (isset($_SESSION['Temple_Day_Book'])) || (isset($_SESSION['Temple_Inkind_Report']))) { ?>
						<li class="dropdown reports">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">Reports</a>
							<ul class="dropdown-menu">
								<?php if($this->session->userdata('userGroup') == 4 || $this->session->userdata('userGroup') == 1 || $this->session->userdata('userGroup') == 6 || $this->session->userdata('userGroup') == 2 ||
							          $this->session->userdata('userGroup') == 3) { ?>
									<?php if(isset($_SESSION['Deity_Receipt_Report'])) { ?>	
										<li><a href="<?php echo site_url();?>Report/deity_receipt_report">Deity Receipt Report</a></li>
									<?php } ?>		
									<?php if(isset($_SESSION['Deity_Seva_Report'])) { ?>	
										<li><a href="<?php echo site_url();?>Report/deity_sevas_report">Deity Sevas Report</a></li>
									<?php } ?>		
									<?php if(isset($_SESSION['Deity_MIS_Report'])) { ?>	
										<li><a href="<?php echo site_url();?>Report/deity_mis_report">Deity MIS Report</a></li>
									<?php } ?>	
									<?php if(isset($_SESSION['Deity_Seva_Summary'])) { ?>	
										<li><a href="<?php echo site_url();?>Report/deity_seva_summary">Deity Seva Summary</a></li>
									<?php } ?>
									<?php if(isset($_SESSION['Temple_Day_Book'])) { ?>	
										<li><a href="<?php echo site_url();?>Report/temple_day_book">Day Book</a></li>
									<?php } ?>
									<?php if(isset($_SESSION['Temple_Inkind_Report'])) { ?>	
										<li><a href="<?php echo site_url();?>Report/temple_inkind_report">Inkind Report</a></li>
									<?php } ?>
									<?php if(isset($_SESSION['Current_Event_Receipt_Report'])) { ?>	
										<li <?php if(@$_SESSION['eventActiveCount'] == 0) echo "style='display:none;'"?> ><a href="<?php echo site_url();?>Report/event_receipt_report">Current Event Receipt Report</a></li>
									<?php } ?>		
									<?php if(isset($_SESSION['Current_Event_Seva_Report'])) { ?>	
										<li <?php if(@$_SESSION['eventActiveCount'] == 0) echo "style='display:none;'"?> ><a href="<?php echo site_url();?>Report/event_seva_report">Current Event Sevas Report</a></li>
									<?php } ?>	
									<?php if(isset($_SESSION['Event_Seva_Summary'])) { ?>	
										<li <?php if(@$_SESSION['eventActiveCount'] == 0) echo "style='display:none;'"?> ><a href="<?php echo site_url();?>Report/summary_sevas_on_event">Event Seva Summary</a></li>
									<?php } ?>										
								<?php } ?>
								<?php if($this->session->userdata('userGroup') == 1 || $this->session->userdata('userGroup') == 6 || $this->session->userdata('userGroup') == 2) { ?>
									<?php if(isset($_SESSION['Current_Event_MIS_Report'])) { ?>	
										<li <?php if(@$_SESSION['eventActiveCount'] == 0) echo "style='display:none;'"?> ><a href="<?php echo site_url();?>Report/misReport">Current Event MIS Report</a></li>
									<?php } ?>								
									<?php if(isset($_SESSION['User_Event_Collection_Report'])) { ?>	
										<li <?php if(@$_SESSION['eventActiveCount'] == 0) echo "style='display:none;'"?>><a href="<?php echo site_url();?>Report/user_collection_report_admin">User Event Collection Report</a></li>
									<?php } ?>
								<?php } else { ?>
									<?php if(isset($_SESSION['User_Event_Collection_Report'])) { ?>	
										<li <?php if(@$_SESSION['eventActiveCount'] == 0) echo "style='display:none;'"?> ><a href="<?php echo site_url();?>Report/user_collection_report">User Event Collection Report</a></li>
									<?php } ?>	
								<?php } ?>
											
							</ul>
						</li>
				<?php } ?>

				<?php if((isset($_SESSION['Add_Auction_Item'])) || (isset($_SESSION['Bid_Auction_Item'])) || (isset($_SESSION['Auction_Receipt'])) || (isset($_SESSION['Saree_Outward_Report'])) || (isset($_SESSION['Auction_Item_Report']))) { ?>
						<li <?php if(@$_SESSION['eventActiveCount'] == 0) echo "style='display:none;'"?> class="dropdown auction">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">Auction</a>
							<ul class="dropdown-menu">
								<?php if(isset($_SESSION['Add_Auction_Item'])) { ?>	
									<li><a href="<?php echo site_url();?>Auction/add_auction_item_list">Add Auction Item</a></li>
								<?php } ?>		
								<?php if(isset($_SESSION['Bid_Auction_Item'])) { ?>	
									<li><a href="<?php echo site_url();?>Auction/bid_auction_item">Bid Auction Item</a></li>
								<?php } ?>		
								<?php if(isset($_SESSION['Auction_Receipt'])) { ?>	
									<li><a href="<?php echo site_url();?>Auction/issue_auction">Auction Receipt</a></li>
								<?php } ?>		
								<?php if(isset($_SESSION['Saree_Outward_Report'])) { ?>	
									<li><a href="<?php echo site_url();?>Report/saree_outward_report">Saree Outward Report</a></li>
								<?php } ?>		
								<?php if(isset($_SESSION['Auction_Item_Report'])) { ?>	
									<li><a href="<?php echo site_url();?>Report/auction_report">Auction Item Report</a></li>
								<?php } ?>		
							</ul>
						</li>
				<?php } ?>
				<?php if((isset($_SESSION['Postage']))) { ?>
						<li class="postage">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">Postage
								<?php if(@$_SESSION['dispatchCount'][0]->CNT != "0") { ?>
									<?php if(strlen($_SESSION['dispatchCount'][0]->CNT) == "1") { ?>
										<span class="badge16"><?=$_SESSION['dispatchCount'][0]->CNT;?></span>
									<?php } else { ?>
										<span class="badge17"><?=$_SESSION['dispatchCount'][0]->CNT;?></span>
									<?php } ?>
								<?php } ?>
							</a>
							<ul class="dropdown-menu">
								<?php if(isset($_SESSION['Dispatch_Collection'])) { ?>	
									<li><a href="<?=site_url();?>Postage/dispatch_collection">Dispatch Pending</a></li>
								<?php } ?>
								<?php if(isset($_SESSION['All_Postage_Collection'])) { ?>	
									<li><a href="<?=site_url();?>Postage/all_postage_collection">All Postage Collection</a></li>
								<?php } ?>
								<?php if(isset($_SESSION['Postage_Group'])) { ?>	
									<li><a href="<?=site_url();?>Postage/postage_group">SLVT Postage Group</a></li>
								<?php } ?>
							</ul>
						</li>
				<?php } ?>
				<?php if((isset($_SESSION['Event_Postage'])) && $_SESSION['trustLogin'] != "1") { ?>
						<li <?php if(@$_SESSION['eventActiveCount'] == 0) echo "style='display:none;'"?> class="eventpostage">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">Event Postage
								<?php if(@$_SESSION['eventDispatchCount'][0]->CNT != "0") { ?>
									<?php if(strlen($_SESSION['eventDispatchCount'][0]->CNT) == "1") { ?>
										<span class="badge18"><?=$_SESSION['eventDispatchCount'][0]->CNT;?></span>
									<?php } else { ?>
										<span class="badge19"><?=$_SESSION['eventDispatchCount'][0]->CNT;?></span>
									<?php } ?>
								<?php } ?>
							</a>
							<ul class="dropdown-menu">
								<?php if(isset($_SESSION['Event_Dispatch_Collection'])) { ?>	
									<li><a href="<?=site_url();?>EventPostage/dispatch_collection">Event Dispatch Pending</a></li>
								<?php } ?>
								<?php if(isset($_SESSION['All_Event_Postage_Collection'])) { ?>	
									<li><a href="<?=site_url();?>EventPostage/all_postage_collection">All Event Postage Collection</a></li>
								<?php } ?>
								<?php if(isset($_SESSION['SLVT_Event_Postage_Group'])) { ?>	
									<li><a href="<?=site_url();?>EventPostage/postage_group">SLVT Event Postage Group</a></li>
								<?php } ?>
							</ul>
						</li>
				<?php } ?>
				<?php if((isset($_SESSION['Deity_EOD'])) || (isset($_SESSION['EOD_Tally']))) { ?>
						<li class="deityEOD">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">Deity E.O.D.</a>
							<ul class="dropdown-menu">
								<?php if($this->session->userdata('userGroup') == 1 || $this->session->userdata('userGroup') == 6) { ?>
									<li><a href="<?=site_url();?>EOD/eod_admin">E.O.D. Report</a></li>
								<?php } else { ?>
									<li><a href="<?=site_url();?>EOD/">E.O.D. Report</a></li>
								<?php } ?>
								<?php if(isset($_SESSION['EOD_Tally'])) { ?>	
									<li><a href="<?php echo site_url();?>EOD_Tally">E.O.D. Tally</a></li>
								<?php } ?>	
							</ul>
						</li>
				<?php } ?>	
                <?php if((isset($_SESSION['Event_EOD'])) || (isset($_SESSION['Event_EOD_Tally']))) { ?>
						<li <?php if(@$_SESSION['eventActiveCount'] == 0) echo "style='display:none;'"?> class="eventEOD">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">Event E.O.D.</a>
							<ul class="dropdown-menu">
								<?php if($this->session->userdata('userGroup') == 1 || $this->session->userdata('userGroup') == 6) { ?>
									<li <?php if(@$_SESSION['eventActiveCount'] == 0) echo "style='display:none;'"?>><a href="<?=site_url();?>eventEOD/eod_admin">E.O.D. Report</a></li>
								<?php } else { ?>
									<li <?php if(@$_SESSION['eventActiveCount'] == 0) echo "style='display:none;'"?>><a href="<?=site_url();?>eventEOD">E.O.D. Report</a></li>
								<?php } ?>
								<?php if(isset($_SESSION['Event_EOD_Tally'])) { ?>	
									<li <?php if(@$_SESSION['eventActiveCount'] == 0) echo "style='display:none;'"?>><a href="<?php echo site_url();?>eventEOD_Tally">E.O.D. Tally</a></li>
								<?php } ?>	
							</ul>
						</li>
                <?php } ?>

					<?php if((isset($_SESSION['Finance_Receipts'])) || 
					    (isset($_SESSION['Finance_Payments'])) || 
					    (isset($_SESSION['Finance_Journal'])) || 
					    (isset($_SESSION['Finance_Contra'])) || 
					    (isset($_SESSION['Balance_Sheet'])) || 
					    (isset($_SESSION['Income_and_Expenditure'])) || 
					    (isset($_SESSION['Receipts_and_Payments'])) || 
					    (isset($_SESSION['Trial_Balance'])) || 
					    (isset($_SESSION['Finance_Add_Groups'])) || 
					    (isset($_SESSION['Finance_Add_Ledgers'])) || 
					    (isset($_SESSION['Finance_Add_Opening_Balance']))) { ?>
						<!-- finance -->
						<li class="dropdown finance">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">Finance</a>
							<ul class="dropdown-menu">
								<?php if((isset($_SESSION['Finance_Receipts'])) ||(isset($_SESSION['Finance_Payments'])) || (isset($_SESSION['Finance_Journal'])) || (isset($_SESSION['Finance_Contra'])) ){ ?>
								<li class="dropdown-submenu">
									<a href="#" class="" data-toggle="dropdown">Finance Vouchers
									</a>
									<ul class="dropdown-menu" style="float:right;right:auto;">
										<?php if(isset($_SESSION['Finance_Receipts'])) { ?>
											<li><a href="<?php echo site_url();?>finance/Receipt">Receipt</a></li>
										<?php } ?>
										<?php if(isset($_SESSION['Finance_Payments'])) { ?>			
											<li><a href="<?php echo site_url();?>finance/Payment">Payments</a></li>				
										<?php } ?>
										<?php if(isset($_SESSION['Finance_Journal'])) { ?>			
											<li><a href="<?php echo site_url();?>finance/Journal">Journal</a></li>
										<?php } ?>
										<?php if(isset($_SESSION['Finance_Contra'])) { ?>
											<li><a href="<?php echo site_url();?>finance/Contra">Contra</a></li>
										<?php } ?>
									</ul>
								</li>
								<?php } ?>	
								<?php if((isset($_SESSION['Balance_Sheet'])) ||(isset($_SESSION['Income_and_Expenditure'])) || (isset($_SESSION['Receipts_and_Payments'])) || (isset($_SESSION['Trial_Balance'])) || (isset($_SESSION['Finance_Day_Book'])) ){ ?>
							    	<li class="dropdown-submenu">
									<a href="#" class="" data-toggle="dropdown">Reports
									</a>
									<ul class="dropdown-menu" style="float:right;right:auto;">
										<?php if(isset($_SESSION['Balance_Sheet'])) { ?>
											<li><a  href="<?php echo site_url();?>finance/displayBalanceSheet" id="btnBal" >Balance Sheet</a></li>	
										<?php } ?>
										<?php if(isset($_SESSION['Income_and_Expenditure'])) { ?>	
											<li><a href="<?php echo site_url();?>finance/displayIncomeAndExpenditure" id="btnIE" >Income & Expenditure</a></li>
										<?php } ?>
										<?php if(isset($_SESSION['Receipts_and_Payments'])) { ?>	
											<li><a href="<?php echo site_url();?>finance/displayReceiptAndPayment" id="btnRP" >Receipts & Payments</a></li>
										<?php } ?>
										<?php if(isset($_SESSION['Trial_Balance'])) { ?>
											<li><a href="<?php echo site_url();?>finance/displayTrialBalance"  id="btnRP" >Trail Balance</a></li>
										<?php } ?>
										<?php if(isset($_SESSION['Finance_Day_Book'])) { ?>
											<li><a href="<?php echo site_url();?>finance/dayBook">Day Book</a></li>
										<?php } ?>
										<!-- href="<?php echo site_url();?>finance/dispTrialBalance" -->
									</ul> 
								</li>
								<?php } ?>	
								<?php if((isset($_SESSION['Finance_Add_Groups'])) ||(isset($_SESSION['Finance_Add_Ledgers'])) || (isset($_SESSION['Finance_Add_Opening_Balance'])) || (isset($_SESSION['All_Ledgers_and_Groups'])) ){ ?>
								<li class="dropdown-submenu">
									<a href="#" class="" data-toggle="dropdown">Groups & Ledgers
									</a>
									<ul class="dropdown-menu" style="float:right;right:auto;">
										<?php if(isset($_SESSION['Finance_Add_Groups'])) { ?>
											<li><a href="<?php echo site_url();?>finance/Group">Add Group</a></li>	
										<?php } ?>
										<?php if(isset($_SESSION['Finance_Add_Ledgers'])) { ?>	
											<li><a href="<?php echo site_url();?>finance/Ledger">Add Ledgers</a></li>
										<?php } ?>
										<?php if(isset($_SESSION['Finance_Add_Opening_Balance'])) { ?>
											<li><a href="<?php echo site_url();?>finance/OpeningBal">Add Opening Balance</a></li>	
										<?php } ?>
										<?php if(isset($_SESSION['All_Ledgers_and_Groups'])) { ?>
											<li><a href="<?php echo site_url();?>finance/allGroupLedgerDetails">All Ledgers and Groups</a></li>	
										<?php } ?>	
										<?php if(isset($_SESSION['All_Ledgers_and_Groups'])) { ?>
											<li><a href="<?php echo site_url();?>finance/groupAndLedgerList">Ledgers and Groups List</a></li>	
										<?php } ?>	
										<li><a href="<?php echo site_url();?>finance/addCommittee">Add Committee</a></li>	
				
									</ul>
								</li>
								<?php } ?>	
							</ul>
						</li>

				<?php } ?>
				<?php } ?>
				<?php if(isset($_SESSION['Event_Seva']) && $_SESSION['trustLogin'] == "1") { ?>
					<li <?php if(@$_SESSION['eventActiveCount'] == 0) echo "style='display:none;'"?> class="eventSevas">
						<a href="<?=site_url();?>TrustEvents">Events
							<?php if(@$_SESSION['sevaCount'] != "") { ?>
								<?php if(strlen($_SESSION['sevaCount']) == "1") { ?>
									<span class="badge13"><?=$_SESSION['sevaCount'];?></span>
								<?php } else { ?>
									<span class="badge12"><?=$_SESSION['sevaCount'];?></span>
								<?php } ?>
							<?php } ?>
						</a>
					</li>
				<?php } ?>
				<?php if(isset($_SESSION['Trust_Event_Token'])) { ?>
					<li <?php if(@$_SESSION['eventActiveCount'] == 0) echo "style='display:none;'"?> class="eventToken">
						<a href="<?=site_url();?>TrustEvents/event_token">Event Token</a>
					</li>
				<?php } ?>
				<?php if((isset($_SESSION['Book_Hall'])) || (isset($_SESSION['All_Hall_Bookings']))) { ?>
					<li class="hallBooking">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Hall </a>
						<ul class="dropdown-menu">
							<?php if(isset($_SESSION['Book_Hall'])) { ?>
								<li><a href="<?=site_url()?>Trust/bookHall">Book Hall</a></li>
							<?php } ?>
							<?php if(isset($_SESSION['All_Hall_Bookings'])) { ?>	
								<li><a href="<?php echo site_url();?>Trust">All Hall Bookings</a></li>
							<?php } ?>	
						</ul>
					</li>
				<?php } ?>
				<?php if(((isset($_SESSION['All_Trust_Receipt'])) || (isset($_SESSION['New_Trust_Receipt'])) || (isset($_SESSION['All_Event_Receipt'])) || (isset($_SESSION['Event_Seva'])) || (isset($_SESSION['Event_Donation/Kanike'])) || (isset($_SESSION['Deity/Event_Hundi'])) || (isset($_SESSION['Deity/Event_Inkind']))) && $_SESSION['trustLogin'] == "1") { ?>
					<li class="hallReceipt">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Receipt</a>
						<ul class="dropdown-menu">
							<?php if(isset($_SESSION['New_Trust_Receipt'])) { ?>
								<li><a href="<?=site_url()?>TrustReceipt/new_trust_receipt">New Trust Receipt</a></li>
							<?php } ?>
							<?php if(isset($_SESSION['Deity/Event_Inkind'])) { ?>
								<li><a href="<?php echo site_url();?>TrustReceipt/receipt_inkind_trust">Trust InKind</a></li>
							<?php } ?>	
							<?php if(isset($_SESSION['All_Trust_Receipt'])) { ?>	
								<li><a href="<?php echo site_url();?>TrustReceipt/all_trust_receipt">All Trust Receipt</a></li>
							<?php } ?>	
							<?php if(isset($_SESSION['All_Event_Receipt'])) { ?>
								<li <?php if(@$_SESSION['eventActiveCount'] == 0) echo "style='display:none;'"?> ><a href="<?php echo site_url();?>TrustReceipt/all_receipt">All Event Receipt</a></li>
							<?php } ?>
							<?php if(isset($_SESSION['Event_Seva'])) { ?>	
								<li <?php if(@$_SESSION['eventActiveCount'] == 0) echo "style='display:none;'"?> ><a href="<?=site_url(); ?>TrustEvents/event_receipt">Event Seva</a></li>
							<?php } ?>	
							<?php if(isset($_SESSION['Event_Donation/Kanike'])) { ?>
								<li <?php if(@$_SESSION['eventActiveCount'] == 0) echo "style='display:none;'"?> ><a href="<?php echo site_url();?>TrustReceipt/receipt_donation">Event Donation/Kanike</a></li>
							<?php } ?>	
							<?php if(isset($_SESSION['Deity/Event_Hundi'])) { ?>
								<li <?php if(@$_SESSION['eventActiveCount'] == 0) echo "style='display:none;'"?> ><a href="<?php echo site_url();?>TrustReceipt/receipt_hundi">Event Hundi</a></li>
							<?php } ?>	
							<?php if(isset($_SESSION['Deity/Event_Inkind'])) { ?>
								<li <?php if(@$_SESSION['eventActiveCount'] == 0) echo "style='display:none;'"?> ><a href="<?php echo site_url();?>TrustReceipt/receipt_inkind">Event InKind</a></li>
							<?php } ?>	
						</ul>
					</li>
				<?php } ?>
				<?php if(((isset($_SESSION['Add_Auction_Item'])) || (isset($_SESSION['Bid_Auction_Item'])) || (isset($_SESSION['Auction_Receipt'])) || (isset($_SESSION['Saree_Outward_Report'])) || (isset($_SESSION['Auction_Item_Report']))) && $_SESSION['trustLogin'] == "1") { ?>
					<li <?php if(@$_SESSION['eventActiveCount'] == 0) echo "style='display:none;'"?> class="dropdown trustAuction">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Auction</a>
						<ul class="dropdown-menu">
							<?php if(isset($_SESSION['Add_Auction_Item'])) { ?>	
								<li><a href="<?php echo site_url();?>TrustAuction/add_auction_item_list">Add Auction Item</a></li>
							<?php } ?>		
							<?php if(isset($_SESSION['Bid_Auction_Item'])) { ?>	
								<li><a href="<?php echo site_url();?>TrustAuction/bid_auction_item">Bid Auction Item</a></li>
							<?php } ?>		
							<?php if(isset($_SESSION['Auction_Receipt'])) { ?>	
								<li><a href="<?php echo site_url();?>TrustAuction/issue_auction">Auction Receipt</a></li>
							<?php } ?>		
							<?php if(isset($_SESSION['Saree_Outward_Report'])) { ?>	
								<li><a href="<?php echo site_url();?>TrustReport/saree_outward_report">Saree Outward Report</a></li>
							<?php } ?>		
							<?php if(isset($_SESSION['Auction_Item_Report'])) { ?>	
								<li><a href="<?php echo site_url();?>TrustReport/auction_report">Auction Item Report</a></li>
							<?php } ?>		
						</ul>
					</li>
				<?php } ?>
				<?php if(((isset($_SESSION['Trust_Receipt_Report'])) || (isset($_SESSION['Trust_MIS_Report'])) || (isset($_SESSION['Current_Event_Receipt_Report'])) || (isset($_SESSION['Current_Event_Seva_Report'])) || (isset($_SESSION['Current_Event_MIS_Report'])) || (isset($_SESSION['User_Event_Collection_Report'])) || (isset($_SESSION['Trust_Day_Book'])) || (isset($_SESSION['Trust_Inkind_Report']))) && $_SESSION['trustLogin'] == "1") { ?>
					<li class="hallReport">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Report</a>
						<ul class="dropdown-menu">
							<?php if(isset($_SESSION['Trust_Receipt_Report'])) { ?>
								<li><a href="<?=site_url()?>TrustReport/trust_receipt_report">Trust Receipt Report</a></li>
							<?php } ?>
							<?php if(isset($_SESSION['Trust_MIS_Report'])) { ?>	
								<li><a href="<?php echo site_url();?>TrustReport/trust_mis_report">Trust MIS Report</a></li>
							<?php } ?>
							<?php if(isset($_SESSION['Hall_Bookings_Report'])) { ?>	
								<li><a href="<?php echo site_url();?>TrustReport/hall_bookings_report">Hall Bookings Report</a></li>
							<?php } ?>
							<?php if(isset($_SESSION['Trust_Day_Book'])) { ?>	
								<li><a href="<?php echo site_url();?>TrustReport/trust_day_book">Day Book Report</a></li>
							<?php } ?>
							<?php if(isset($_SESSION['Trust_Inkind_Report'])) { ?>	<!-- To display Trust Inkind Report  -->
								<li><a href="<?php echo site_url();?>TrustReport/t_inkind_report">Inkind Report</a></li>
							<?php } ?>
							 <?php if(isset($_SESSION['Trust_Receipt_Report'])) { ?>	
								<li><a href="<?php echo site_url();?>TrustReport/trust_inkind_report">Event Inkind Report</a></li>
							<?php } ?> 
							<?php if(isset($_SESSION['Current_Event_Receipt_Report'])) { ?>	
								<li <?php if(@$_SESSION['eventActiveCount'] == 0) echo "style='display:none;'"?> ><a href="<?php echo site_url();?>TrustReport/event_receipt_report">Current Event Receipt Report</a></li>
							<?php } ?>		
							<?php if(isset($_SESSION['Current_Event_Seva_Report'])) { ?>	
								<li <?php if(@$_SESSION['eventActiveCount'] == 0) echo "style='display:none;'"?> ><a href="<?php echo site_url();?>TrustReport/event_seva_report">Current Event Sevas Report</a></li>
							<?php } ?>
							<?php if(isset($_SESSION['Event_Seva_Summary'])) { ?>	
								<li <?php if(@$_SESSION['eventActiveCount'] == 0) echo "style='display:none;'"?> ><a href="<?php echo site_url();?>TrustReport/summary_sevas_on_event">Event Seva Summary</a></li>
							<?php } ?>							
							<?php if($this->session->userdata('userGroup') == 1 || $this->session->userdata('userGroup') == 6 || $this->session->userdata('userGroup') == 2) { ?>
								<?php if(isset($_SESSION['Current_Event_MIS_Report'])) { ?>	
									<li <?php if(@$_SESSION['eventActiveCount'] == 0) echo "style='display:none;'"?> ><a href="<?php echo site_url();?>TrustReport/misReport">Current Event MIS Report</a></li>
								<?php } ?>	
								<?php if(isset($_SESSION['User_Event_Collection_Report'])) { ?>	
									<li <?php if(@$_SESSION['eventActiveCount'] == 0) echo "style='display:none;'"?>><a href="<?php echo site_url();?>TrustReport/user_collection_report_admin">User Event Collection Report</a></li>
								<?php } ?>
							<?php } else { ?>
								<?php if(isset($_SESSION['User_Event_Collection_Report'])) { ?>	
									<li <?php if(@$_SESSION['eventActiveCount'] == 0) echo "style='display:none;'"?> ><a href="<?php echo site_url();?>TrustReport/user_collection_report">User Event Collection Report</a></li>
								<?php } ?>	
							<?php } ?>
						</ul>
					</li>
				<?php } ?>
				<?php if((isset($_SESSION['Event_Postage'])) && $_SESSION['trustLogin'] == "1") {  ?>
					<li <?php if(@$_SESSION['eventActiveCount'] == 0) echo "style='display:none;'"?> class="eventtrustpostage">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Event Postage
							<?php if(@$_SESSION['trustEventDispatchCount'][0]->CNT != "0") { ?>
								<?php if(strlen($_SESSION['trustEventDispatchCount'][0]->CNT) == "1") { ?>
									<span class="badge18"><?=$_SESSION['trustEventDispatchCount'][0]->CNT;?></span>
								<?php } else { ?>
									<span class="badge19"><?=$_SESSION['trustEventDispatchCount'][0]->CNT;?></span>
								<?php } ?>
							<?php } ?>
						</a>
						<ul class="dropdown-menu">
							<?php if(isset($_SESSION['Event_Dispatch_Collection'])) { ?> 	
								<li><a href="<?=site_url();?>TrustEventPostage/dispatch_collection">Event Dispatch Pending</a></li>
							<?php } ?>
							<?php if(isset($_SESSION['All_Event_Postage_Collection'])) { ?>	
								<li><a href="<?=site_url();?>TrustEventPostage/all_postage_collection">All Event Postage Collection</a></li>
							<?php } ?>
							<?php if(isset($_SESSION['Trust_Event_Postage_Group'])) { ?>	
								<li><a href="<?=site_url();?>TrustEventPostage/postage_group">Trust Event Postage Group</a></li>
							<?php } ?>
						</ul>
					</li>
				<?php } ?>
				<?php if((isset($_SESSION['E.O.D_Report'])) || (isset($_SESSION['E.O.D_Tally_Trust'])) && $_SESSION['trustLogin'] == "1") { ?>
					<li class="hallEODReport">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Trust E.O.D.</a>
						<ul class="dropdown-menu">
							<?php if(isset($_SESSION['E.O.D_Report'])) { ?>
								<?php if($this->session->userdata('userGroup') == 1 || $this->session->userdata('userGroup') == 6) { ?>
									<li><a href="<?=site_url()?>TrustEOD/eod_admin">E.O.D. Report</a></li>
								<?php } else { ?>
									<li><a href="<?=site_url()?>TrustEOD/">E.O.D. Report</a></li>
								<?php } ?>
							<?php } ?>
							<?php if(isset($_SESSION['E.O.D_Tally_Trust'])) { ?>	
								<li><a href="<?php echo site_url();?>TrustEOD_Tally">E.O.D. Tally</a></li>
							<?php } ?>
						</ul>
					</li>
				<?php } ?>
				<?php if((isset($_SESSION['Event_E.O.D_Report'])) || (isset($_SESSION['Event_E.O.D_Tally'])) && $_SESSION['trustLogin'] == "1") { ?>
					<li <?php if(@$_SESSION['eventActiveCount'] == 0) echo "style='display:none;'"?> class="hallEventEODReport">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Event E.O.D.</a>
						<ul class="dropdown-menu">
							<?php if(isset($_SESSION['Event_E.O.D_Report'])) { ?>
								<?php if($this->session->userdata('userGroup') != "" /* $this->session->userdata('userGroup') == 1 || $this->session->userdata('userGroup') == 6 */) { ?>
									<li <?php if(@$_SESSION['eventActiveCount'] == 0) echo "style='display:none;'"?>><a href="<?=site_url()?>TrustEventEOD/eod_admin">E.O.D. Report </a></li>
								<?php } else { ?>
									<li <?php if(@$_SESSION['eventActiveCount'] == 0) echo "style='display:none;'"?>><a href="<?=site_url()?>TrustEventEOD/">E.O.D. Report </a></li>
								<?php } ?>
							<?php } ?>
							<?php if(isset($_SESSION['Event_E.O.D_Tally'])) { ?>	
								<li <?php if(@$_SESSION['eventActiveCount'] == 0) echo "style='display:none;'"?>><a href="<?php echo site_url();?>TrustEventEOD_Tally/">E.O.D. Tally</a></li>
							<?php } ?>
						</ul>
					</li>
				<?php } ?>
		
<!-- adding Trust related code start by adithya on 19-12-23 -->
	           <?php if((isset($_SESSION['Trust_Finance_Receipts'])) || 
	            (isset($_SESSION['Trust_Finance_Payments'])) ||
				(isset($_SESSION['Trust_Finance_Journal'])) || 
				(isset($_SESSION['Trust_Finance_Contra'])) ||
				(isset($_SESSION['Trust_Balance_Sheet'])) ||
				(isset($_SESSION['Trust_Income_and_Expenditure'])) || 
				(isset($_SESSION['Trust_Receipts_and_Payments'])) || 
				(isset($_SESSION['Trust_Trial_Balance'])) || 
				(isset($_SESSION['Trust_Finance_Add_Groups'])) || 
				(isset($_SESSION['Trust_Finance_Add_Ledgers'])) || 
				(isset($_SESSION['Trust_Finance_Add_Opening_Balance'])) || 
				(isset($_SESSION['Trust_Finance_Day_Book']))|| 
				(isset($_SESSION['Trust_All_Ledgers_and_Groups']))) { 
					?>
				<!-- finance -->
					<li class="dropdown finance">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Finance</a>
						<ul class="dropdown-menu">
							
							<li class="dropdown-submenu">
								<a href="#" class="" data-toggle="dropdown">Finance Vouchers
								</a>
								<ul class="dropdown-menu" style="float:right;right:auto;">
									<?php if(isset($_SESSION['Trust_Finance_Receipts'])) { ?>	
										<li><a href="<?php echo site_url();?>Trustfinance/Receipt">Receipt</a></li>
									<?php } ?>
									<?php if(isset($_SESSION['Trust_Finance_Payments'])) { ?>	
										<li><a href="<?php echo site_url();?>Trustfinance/Payment">Payments</a></li>				
									<?php } ?>
									<?php if(isset($_SESSION['Trust_Finance_Journal'])) { ?>		
										<li><a href="<?php echo site_url();?>Trustfinance/Journal">Journal</a></li>
									<?php } ?>
									<?php if(isset($_SESSION['Trust_Finance_Contra'])) { ?>	
										<li><a href="<?php echo site_url();?>Trustfinance/Contra">Contra</a></li>
									<?php } ?>
								</ul>
							</li>
							<li class="dropdown-submenu">
									<a href="#" class="" data-toggle="dropdown">Reports
									</a>
									<ul class="dropdown-menu" style="float:right;right:auto;">
									<?php if(isset($_SESSION['Trust_Balance_Sheet'])) { ?>	
											<li><a  href="<?php echo site_url();?>Trustfinance/displayBalanceSheet" id="btnBal" >Balance Sheet</a></li>	
										<?php } ?>
										<?php if(isset($_SESSION['Trust_Income_and_Expenditure'])) { ?>	
											<li><a href="<?php echo site_url();?>Trustfinance/displayIncomeAndExpenditure" id="btnIE" >Income & Expenditure</a></li>
										<?php } ?>
										<?php if(isset($_SESSION['Trust_Receipts_and_Payments'])) { ?>	
											<li><a href="<?php echo site_url();?>Trustfinance/displayReceiptAndPayment" id="btnRP" >Receipts & Payments</a></li>
										<?php } ?>
										<?php if(isset($_SESSION['Trust_Trial_Balance'])) { ?>	
											<li><a href="<?php echo site_url();?>Trustfinance/displayTrialBalance"  id="btnRP" >Trail Balance</a></li>
										<?php } ?>
										<?php if(isset($_SESSION['Trust_Finance_Day_Book'])) { ?>	
											<li><a href="<?php echo site_url();?>Trustfinance/dayBook">Day Book</a></li>
										<?php } ?>
										<!-- href="<?php echo site_url();?>finance/dispTrialBalance" -->
									</ul> 
								</li>			
						
								
							<?php if((isset($_SESSION['Trust_Finance_Add_Groups'])) ||(isset($_SESSION['Trust_Finance_Add_Ledgers'])) || (isset($_SESSION['Trust_Finance_Add_Opening_Balance'])) ||
							 (isset($_SESSION['Trust_All_Ledgers_and_Groups'])) ){ ?>
							<li class="dropdown-submenu">
								<a href="#" class="" data-toggle="dropdown">Groups & Ledgers
								</a>
								<ul class="dropdown-menu" style="float:right;right:auto;">
								<?php if(isset($_SESSION['Trust_Finance_Add_Groups'])) { ?>	
										<li><a href="<?php echo site_url();?>Trustfinance/Group">Add Group</a></li>	
									<?php } ?>
									<?php if(isset($_SESSION['Trust_Finance_Add_Ledgers'])) { ?>	
										<li><a href="<?php echo site_url();?>Trustfinance/Ledger">Add Ledgers</a></li>
									<?php } ?>
									<?php if(isset($_SESSION['Trust_Finance_Add_Opening_Balance'])) { ?>	
										<li><a href="<?php echo site_url();?>Trustfinance/OpeningBal">Add Opening Balance</a></li>	
									<?php } ?>
									<?php if(isset($_SESSION['Trust_All_Ledgers_and_Groups'])) { ?>	
										<li><a href="<?php echo site_url();?>Trustfinance/allGroupLedgerDetails">All Ledgers and Groups</a></li>	
									<?php } ?>	
									<?php if(isset($_SESSION['Trust_All_Ledgers_and_Groups'])) { ?>	
										<li><a href="<?php echo site_url();?>Trustfinance/groupAndLedgerList">Ledgers and Groups List</a></li>	
									<?php } ?>	
									<li><a href="<?php echo site_url();?>Trustfinance/addCommittee">Add Committee</a></li>	
			
								</ul>
							</li>
							<?php } ?>	
						</ul>
					</li>
				<?php } ?>
<!-- adding trust related code end by adithya 19-12-23 -->

				</ul> 
				
				<ul class="nav navbar-nav nav_navbr navbar-right log_desktop">
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?=ucfirst($_SESSION['userName']); ?> <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<?php if($_SESSION['trustLogin'] != "1") {
									if($this->session->userdata('userGroup') == 1 || 
									   $this->session->userdata('userGroup') == 6 || 
									   $this->session->userdata('userGroup') == 4 || 
									   $this->session->userdata('userGroup') == 2) { ?>				
									<?php if((isset($_SESSION['Bank_Settings'])) || 
									      (isset($_SESSION['Financial_Month'])) || 
										  (isset($_SESSION['Deity_Seva_Settings'])) || 
										  (isset($_SESSION['Event_Seva_Settings'])) || 
										  (isset($_SESSION['Receipt_Settings'])) ||
										  (isset($_SESSION['Kanike_Settings'])) || 
										  (isset($_SESSION['Shashwath_Period_Settings'])) || 
										  (isset($_SESSION['Shashwath_Calendar_Settings'])) ||
										  (isset($_SESSION['Shashwath_Festival_Settings'])) || 
										  (isset($_SESSION['Time_Settings'])) || 
										  (isset($_SESSION['Group_Settings'])) || 
										  (isset($_SESSION['Users_Settings'])) || 
										  (isset($_SESSION['Deity_Special_Receipt_Price'])) || 
										  (isset($_SESSION['Import_Settings'])) || 
										  (isset($_SESSION['Auction_Settings']))) { ?>
										<li class="dropdown-submenu"><a href="#" class="" data-toggle="dropdown">Settings</a>
											<ul class="dropdown-menu" style="float:left;left:auto;right:100%;">
												<?php if(isset($_SESSION['Deity_Seva_Settings'])) { ?>	
													<li><a href="<?php echo site_url();?>admin_settings/Admin_setting/deity_seva_setting">Deity Seva Settings</a></li>
												<?php } ?>		
												<?php if(isset($_SESSION['Event_Seva_Settings'])) { ?>	
													<li><a href="<?php echo site_url();?>admin_settings/Admin_setting/events_setting">Event Seva Settings</a></li>
												<?php } ?>
												
												
												<!--jeernodhara settings-->
												<li class="dropdown-submenu" style="display:none;"><a href="#" class="" data-toggle="dropdown">Jeernodhara Settings</a>
													<ul class="dropdown-menu" style="float:left;left:auto;right:100%;">
														<?php if(isset($_SESSION['Receipt_Settings'])) { ?>	
													<li><a href="<?php echo site_url();?>admin_settings/Admin_setting/jeernodhara_receipt_setting">Receipt Settings</a></li>
													<?php } ?>			
													</ul>	
												</li>
												
												
												<!--Shashwath menu code >need to change session variables-->
											<?php if((isset($_SESSION['Shashwath_Period_Settings']))||
												         (isset($_SESSION['Shashwath_Calendar_Settings'])) ||
														 (isset($_SESSION['Shashwath_Festival_Settings']))  ) {?>										
												<li class="dropdown-submenu"><a href="#" class="" data-toggle="dropdown">Shashwath Settings</a>
													<ul class="dropdown-menu" style="float:left;left:auto;right:100%;">
														<?php if(isset($_SESSION['Shashwath_Period_Settings'])) { ?>	
													<li><a href="<?php echo site_url();?>admin_settings/Admin_setting/period_setting">Shashwath Period Settings</a></li>
													<?php } ?>		
													<?php if(isset($_SESSION['Shashwath_Calendar_Settings'])) { ?>	
													<li><a href="<?php echo site_url();?>admin_settings/Admin_setting/calendar_display">Shashwath Calendar Settings</a></li>
													<?php } ?>
													<!-- // SHASHWATH FESTIVAL SETTING STARTS SURAKSHA	 -->
													<?php if(isset($_SESSION['Shashwath_Festival_Settings'])) { ?>								
													<li><a href="<?php echo site_url();?>admin_settings/Admin_setting/festival_setting">Shashwath Festival Settings</a></li>
													<?php } ?>
													</ul>
												</li>
											<?php }?>
												
												<!--Shashwath menu code >need to change session variables-->
												
												<?php if(isset($_SESSION['Receipt_Settings'])) { ?>	
													<li><a href="<?php echo site_url();?>admin_settings/Admin_setting/receipt_setting">Receipt Settings</a></li>
												<?php } ?>

												<!-- Finance Settings -->
												<?php if((isset($_SESSION['Finance_Prerequisites'])) || 
												(isset($_SESSION['Voucher_Counter'])) || 
												(isset($_SESSION['Bank_Cheque_Configuration'])) ) { ?>
												<li class="dropdown-submenu"><a href="#" class="" data-toggle="dropdown">Finance Settings</a>		
													<ul class="dropdown-menu" style="float:left;left:auto;right:100%;">
														<?php if(isset($_SESSION['Finance_Prerequisites'])) { ?>
															<li><a href="<?php echo site_url();?>finance/Prerequisites">Finance Prerequisites</a></li>
														<?php } ?>	
														<?php if(isset($_SESSION['Voucher_Counter'])) { ?>	
															<li><a href="<?php echo site_url();?>finance/voucherCounter">Voucher Counter</a></li>
														<?php } ?>
														<?php if(isset($_SESSION['Bank_Cheque_Configuration'])) { ?>	
															<li><a href="<?php echo site_url();?>finance/chequeConfiguartion">Bank Cheque Configuration</a></li>

														<?php } ?>
														<li><a href="<?php echo site_url();?>finance/addbank">Add Deity Bank </a></li>
														<li><a href="<?php echo site_url();?>finance/addEventBank">Add Event Bank </a></li>
													</ul>
													
													
												</li>
												<?php } ?>	
												<!-- Finance Settings Ends-->

												<?php if(isset($_SESSION['Kanike_Settings'])) { ?>	
													<li><a href="<?php echo site_url();?>admin_settings/Admin_setting/kanike_setting">Kanike Settings</a></li>
												<?php } ?>	
												<?php if(isset($_SESSION['Time_Settings'])) { ?>	
													<li><a href="<?php echo site_url();?>admin_settings/Admin_setting/time_setting">Time Settings</a></li>
												<?php } ?>		
												<?php if(isset($_SESSION['Group_Settings'])) { ?>	
													<li><a href="<?php echo site_url();?>admin_settings/Admin_setting/groups_setting">Group Settings</a></li>
												<?php } ?>		
												<?php if(isset($_SESSION['Users_Settings'])) { ?>	
													<li><a href="<?php echo site_url();?>admin_settings/Admin_setting/users_setting">Users Settings</a></li>
												<?php } ?>		
												<?php if(isset($_SESSION['Import_Settings'])) { ?>	
													<li><a href="<?php echo site_url();?>admin_settings/Admin_setting/import_setting">Import Settings</a></li>
												<?php } ?>		
												<?php if(isset($_SESSION['Auction_Settings'])) { ?>	
													<li><a href="<?php echo site_url();?>admin_settings/Admin_setting/auction_setting">Auction Settings</a></li>
												<?php } ?>	
												<?php if(isset($_SESSION['Deity_Special_Receipt_Price'])) { ?>	
													<li><a href="<?php echo site_url();?>admin_settings/Admin_setting/deity_special_receipt_price">Deity Special Receipt Price</a></li>
												<?php } ?>	
												<?php if(isset($_SESSION['Financial_Month'])) { ?>	
													<li><a href="<?php echo site_url();?>admin_settings/Admin_setting/financial_month_setting">Financial Month Settings</a></li>
												<?php } ?>	
												<?php if(isset($_SESSION['Bank_Settings'])) { ?>	
													<li><a href="<?php echo site_url();?>admin_settings/Admin_setting/bank_setting">Bank Settings</a></li>
												<?php } ?>	
											</ul>
										</li>
									<?php } ?>
									<?php if(isset($_SESSION['Print_Deity_Details'])) { ?>	
										<li><a href="<?php echo site_url();?>admin_settings/Admin_setting/print_deity_details">Print Deity Details</a></li>
									<?php } ?>		
									<?php if(isset($_SESSION['Print_Event_Details'])) { ?>	
										<li><a href="<?php echo site_url();?>admin_settings/Admin_setting/print_event_details">Print Event Details</a></li>
									<?php } ?>		
									<?php if(isset($_SESSION['Inkind_Items'])) { ?>	
										<li><a href="<?php echo site_url();?>admin_settings/Admin_setting/inkind_items">Inkind Items</a></li>
									<?php } ?>		
									<?php if(isset($_SESSION['Cheque_Remmittance'])) { ?>	
										<li><a href="<?php echo site_url();?>admin_settings/Admin_setting/chequeRemmittance">Event Cheque  Reconciliation</a></li>
									<?php } ?>	
									<?php if(isset($_SESSION['Deity_Cheque_Remmittance'])) { ?>	
										<li><a href="<?php echo site_url();?>admin_settings/Admin_setting/deityChequeRemmittance">Deity Cheque Reconciliation</a></li>
									<?php } ?>	
									<?php if(isset($_SESSION['Change_Donation/Kanike'])) { ?>	
										<li><a href="<?php echo site_url();?>admin_settings/Admin_setting/donation_kanike_details">Change Donation/Kanike</a></li>
									<?php } ?>	
									<?php if(isset($_SESSION['Back_Up'])) { ?>	
										<li><a onclick="getDbBackupAndProgress()">Generate BackUp</a></li>
									<?php } ?>		
							<?php } else if($this->session->userdata('userGroup') == 2) { ?>
									<?php if(isset($_SESSION['Inkind_Items'])) { ?>	
										<li><a href="<?php echo site_url();?>admin_settings/Admin_setting/inkind_items">Inkind Items</a></li>
									<?php } ?>		
									<?php if(isset($_SESSION['Cheque_Remmittance'])) { ?>	
										<li><a href="<?php echo site_url();?>admin_settings/Admin_setting/chequeRemmittance">Event Cheque Remmittance</a></li>
									<?php } ?>	
									<?php if(isset($_SESSION['Deity_Cheque_Remmittance'])) { ?>	
										<li><a href="<?php echo site_url();?>admin_settings/Admin_setting/deityChequeRemmittance">Deity Cheque Remmittance</a></li>
									<?php } ?>	
									<?php if(isset($_SESSION['Back_Up'])) { ?>	
										<li><a onclick="getDbBackupAndProgress()">Generate BackUp</a></li>
									<?php } ?>	
							<?php } ?>
						<?php } else { ?>
							<?php if((isset($_SESSION['Auction_Settings'])) ||
							 (isset($_SESSION['Trust_Import_Settings'])) || 
							 (isset($_SESSION['Check_Remmittance'])) || 
							 (isset($_SESSION['Users_Settings'])) || 
							 (isset($_SESSION['Group_Settings'])) || 
							 (isset($_SESSION['Hall_Settings'])) || 
							 (isset($_SESSION['Block_Date_Settings'])) ||
							 (isset($_SESSION['Bank_Settings'])) || 
							 (isset($_SESSION['Event_Seva_Settings'])) ||
							 (isset($_SESSION['Receipt_Settings']))) { ?>
							<li class="dropdown dropdown-submenu open"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Settings</a>
								<ul class="dropdown-menu" style="float:left;left:-150%;right:100%;">
										<?php if(isset($_SESSION['Users_Settings'])) { ?>	
											<li><a href="<?php echo site_url();?>admin_settings/Admin_Trust_setting/users_setting">Users Settings</a></li>
										<?php } ?>	
										<!-- adding the code of finance prerequi by adithya on 20-12-2023 start -->
											<!-- Finance Settings -->
										<?php if((isset($_SESSION['Trust_Finance_Prerequisites'])) ||
										 (isset($_SESSION['Trust_Voucher_Counter'])) || 
										 (isset($_SESSION['Trust_Bank_Cheque_Configuration'])) ) { ?>
											<li class="dropdown-submenu"><a href="#" class="" data-toggle="dropdown">Finance Settings</a>		
												<ul class="dropdown-menu" style="float:left;left:auto;right:100%;">
													<?php if(isset($_SESSION['Trust_Finance_Prerequisites'])) { ?>	
														<li><a href="<?php echo site_url();?>Trustfinance/Prerequisites">Finance Prerequisites</a></li>
													<?php } ?>		
													<?php if(isset($_SESSION['Trust_Voucher_Counter'])) { ?>	
														<li><a href="<?php echo site_url();?>Trustfinance/voucherCounter">Voucher Counter</a></li>
													<?php } ?>		
													<?php if(isset($_SESSION['Trust_Bank_Cheque_Configuration'])) { ?>	
														<li><a href="<?php echo site_url();?>Trustfinance/chequeConfiguartion">Bank Cheque Configuration</a></li>
													<?php } ?>		
													<?php if(isset($_SESSION['Inkind_Items'])) { ?>	
														<!-- <li><a href="<?php echo site_url();?>Trustfinance/addbank">Add Deity Bank </a></li> -->
													<?php } ?>		
													<?php if(isset($_SESSION['Inkind_Items'])) { ?>	
														<!-- <li><a href="<?php echo site_url();?>Trustfinance/addEventBank">Add Event Bank </a></li> -->
													<?php } ?>		
												</ul>													
											</li>
										<?php } ?>	
										<!-- Finance Settings Ends-->
            
										<!-- adding the code of finance prereqi by adithya on 20-12-2023 end -->
										<?php if(isset($_SESSION['Group_Settings'])) { ?>	
											<li><a href="<?php echo site_url();?>admin_settings/Admin_Trust_setting/groups_setting">Group Settings</a></li>
										<?php } ?>		
										<?php if(isset($_SESSION['Hall_Settings'])) { ?>	
											<li><a href="<?php echo site_url();?>admin_settings/Admin_Trust_setting/hall_setting">Hall & Financial Head Settings</a></li>
										<?php } ?>
										<?php if(isset($_SESSION['Block_Date_Settings'])) { ?>	
											<li><a href="<?php echo site_url();?>admin_settings/Admin_Trust_setting/block_date_setting">Block Date Settings</a></li>
										<?php } ?>
										<?php if(isset($_SESSION['Bank_Settings'])) { ?>	
											<li><a href="<?php echo site_url();?>admin_settings/Admin_Trust_setting/bank_setting">Bank Settings</a></li>
										<?php } ?>
										<?php if(isset($_SESSION['Event_Seva_Settings'])) { ?>	
											<li><a href="<?php echo site_url();?>admin_settings/Admin_Trust_setting/events_setting">Event Seva Settings</a></li>
										<?php } ?>		
										<?php if(isset($_SESSION['Receipt_Settings'])) { ?>	
											<li><a href="<?php echo site_url();?>admin_settings/Admin_Trust_setting/receipt_setting">Receipt Settings</a></li>
										<?php } ?>	
										<?php if(isset($_SESSION['Trust_Import_Settings'])) { ?>	
											<li><a href="<?php echo site_url();?>admin_settings/Admin_Trust_setting/import_setting">Import Settings</a></li>
										<?php } ?>
										<?php if(isset($_SESSION['Auction_Settings'])) { ?>	
											<li><a href="<?php echo site_url();?>admin_settings/Admin_Trust_setting/auction_setting">Auction Settings</a></li>
										<?php } ?>		
								</ul>
								</li>
							<?php } ?>
						<?php } ?>
						<?php if(isset($_SESSION['Cheque_Remmittance']) && $_SESSION['trustLogin'] == "1") { ?>	
							<!-- <li><a href="<?php echo site_url();?>admin_settings/Admin_Trust_setting/eventChequeRemmittance">Event Cheque Remmittance</a></li> -->
						<?php } ?>	
						<?php if(isset($_SESSION['Check_Remmittance']) && $_SESSION['trustLogin'] == "1") { ?>	
							<li><a href="<?php echo site_url();?>admin_settings/Admin_Trust_setting/trustChequeRemmittance">Trust Cheque Reconcilation</a></li>
						<?php } ?>
						<?php if(isset($_SESSION['Inkind_Items']) && $_SESSION['trustLogin'] == "1") { ?>	
							<li><a href="<?php echo site_url();?>admin_settings/Admin_Trust_setting/inkind_items">Inkind Items</a></li>
						<?php } ?>	
						<?php if(isset($_SESSION['Function_Types']) && $_SESSION['trustLogin'] == "1") { ?>	
							<li><a href="<?php echo site_url();?>admin_settings/Admin_Trust_setting/function_types">Function Types</a></li>
						   <li><a href="<?php echo site_url();?>admin_settings/Admin_Trust_setting/reset_password">Reset Password</a></li>

						<?php } ?>
						<?php if($_SESSION['trustLogin'] !== "1") { ?>	
						<li><a href="<?php echo site_url();?>admin_settings/Admin_setting/reset_password">Reset Password </a></li>
						<?php } ?>	
						<li><a href="<?=site_url(); ?>home/logout">Sign out</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>
<!-- Progress Bar Content -->
<div  id="work-in-progress" style="display:none;" >
    <div class="work-spinner"></div>
</div>	
<div id="loading-progress-text" style="display: none;">Loading</div>


<script>
	$(document).ready(function() {
		$("#clickMe").on('dblclick click',function(e){
			if(e.type == "click"){$("#double-click").hide();window.location.href = '<?php echo site_url();?>SevaBooking/'}else if(e.type == "dblclick"){$("#double-click").show();}else{};
		});
	})
	// Progress Bar Content
	function getShashwathSevaAndProgress() {
		$('#genDate').val("<?php echo date('d-m-Y'); ?>");
		$('#shashwathForm').submit();
		getProgressSpinner();
		return false;
	}

	function getProgressSpinner(){
		document.getElementById("work-in-progress").style.display = "block";
		document.getElementById("loading-progress-text").style.display = "block";
	}

	// Progress Bar Content
	function getDbBackupAndProgress() {
		getProgressSpinner();
		let url = "<?=site_url()?>admin_settings/Admin_setting/backup";
		$.post(url, { }, function (e) {
			e1 = e.split("|")
			if (e1[0] == "success") {
				window.open(e1[1],'_blank');
		        $('#work-in-progress').fadeOut(100);
		        $('#loading-progress-text').fadeOut(100);
			} else {
				alert("Something went wrong, Please try again after some time");
			}
		});
	}

</script>
