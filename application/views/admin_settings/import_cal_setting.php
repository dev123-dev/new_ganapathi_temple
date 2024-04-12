<style>
	.selectSamvatsara {
	  	position: relative;
	  	min-width: 175px;
	}

	.selectSamvatsara:after {
	  	content: '<>';
	  	font: 16px "Consolas", monospace;
	  	color: #800000;
	  	-webkit-transform: rotate(90deg);
	  	-moz-transform: rotate(90deg);
	  	-ms-transform: rotate(90deg);
	  	transform: rotate(90deg);
	  	right: 0px;
	  	top: 2px;
	  	position: absolute;
	  	pointer-events: none;
	}

	.selectSamvatsara select {
	  	-webkit-appearance: none;
	  	-moz-appearance: none;
	  	appearance: none;
	  	
	  	width: 175px;
	  	background: transparent;
	  	border: none;
	  	padding-bottom: 1px;
	}

	.selectMasa {
	  	position: relative;
	  	min-width: 130px;
	}

	.selectMasa:after {
	  	content: '<>';
	  	font: 16px "Consolas", monospace;
	  	color: #800000;
	  	-webkit-transform: rotate(90deg);
	  	-moz-transform: rotate(90deg);
	  	-ms-transform: rotate(90deg);
	  	transform: rotate(90deg);
	  	right: 0px;
	  	top: 2px;
	  	position: absolute;
	  	pointer-events: none;
	}

	.selectMasa select {
	  	-webkit-appearance: none;
	  	-moz-appearance: none;
	  	appearance: none;
	  	
	  	width: 130px;
	  	background: transparent;
	  	border: none;
	  	padding-bottom: 1px;
	}

	.selectBom {
	  	position: relative;
	  	min-width: 127px;
	}

	.selectBom:after {
	  	content: '<>';
	  	font: 16px "Consolas", monospace;
	  	color: #800000;
	  	-webkit-transform: rotate(90deg);
	  	-moz-transform: rotate(90deg);
	  	-ms-transform: rotate(90deg);
	  	transform: rotate(90deg);
	  	right: 0px;
	  	top: 2px;
	  	position: absolute;
	  	pointer-events: none;
	}

	.selectBom select {
	  	-webkit-appearance: none;
	  	-moz-appearance: none;
	  	appearance: none;
	  	
	  	width: 127px;
	  	background: transparent;
	  	border: none;
	  	padding-bottom: 1px;
	}

	.selectThithi {
	  	position: relative;
	  	min-width: 127px;
	}

	.selectThithi:after {
	  	content: '<>';
	  	font: 16px "Consolas", monospace;
	  	color: #800000;
	  	-webkit-transform: rotate(90deg);
	  	-moz-transform: rotate(90deg);
	  	-ms-transform: rotate(90deg);
	  	transform: rotate(90deg);
	  	right: 0px;
	  	top: 2px;
	  	position: absolute;
	  	pointer-events: none;
	}

	.selectThithi select {
	  	-webkit-appearance: none;
	  	-moz-appearance: none;
	  	appearance: none;
	  	
	  	width: 127px;
	  	background: transparent;
	  	border: none;
	  	padding-bottom: 1px;
	}

	.cont {
		width: auto;
		height: 100%;
	}

	.context-menu {
		width: 210px;
		height: auto;
		position: absolute;
		display: none;
		background: #FDFDD9;
		max-height: 410px;
		overflow-y: auto;
		box-shadow: 0 0 20px 0 #ccc;
	} 

	.context-menu ul {
		list-style: none;
		padding: 5px 0px 5px 0px;
	}

	.context-menu ul li {
		padding: 10px 5px 10px 5px;
		cursor: pointer;
	}

	.context-menu ul li:hover {
		background: #800000;
		color: #ffffff;
		border-left: 4px solid #FDFDD9;
	}

	.hideListItem{
		display:none;  
	}

	.context-menu ul li.element-hover {
		background: #800000;
		color: #ffffff;
		border-left: 4px solid #FDFDD9;
	}

	.dtrecord {
		background-color: #800000;
        color: #ffffff;
        width: 30px;
        height: 30px;
        border: none;
	}

	.dtrecord:hover {
		background-color: #FBB917;
        color: #000000;
	}

	button.add-hover {
		background-color: #FBB917;
        color: #000000;
	}
	/*code for progress bar*/
	#work-in-progress2 {
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

	#loading-progress-text2 {
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

	.calrecord{
		color: red;
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
	 from {
	     transform: rotate(0deg);
	 }
	 to {
	     transform: rotate(360deg);
	 }
	}
	 /* progress bar code ends here*/
</style>
<section id="section-register" class="bg_register">
    <div class="container-fluid sub_reg" style="min-height:100%;">  
		<!-- Progress Bar Content -->
	    <div id="work-in-progress2">
	        <div class="work-spinner"></div>
	    </div>	
	    <div id="loading-progress-text2">Loading</div>
		<!-- Progress Bar ends ...(Jquery included)-->
		<!-- START Content -->
		<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
		<div class="container reg_top adminside">
			<!-- START Row -->
			<div class="row-fluid">
				<!-- START Datatable 2 -->
				<div class="span12 widget lime">
					<section class="body">
						
						<div class="row form-group"> 
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
								<span class="eventsFont2">Shashwath Calendar Breakup</span>
							</div>		
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-8" style="margin-top:6px">
								<span style="font-weight:900;">Start Date: </span><?php echo $calStartDate ?> 	
							</div>
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="margin-top:6px">
								<span style="font-weight:900;">End Date: </span><?php echo $calEndDate ?>	
							</div>
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12" style="margin-top:6px">
								<span style="font-weight:900;">ROI: </span><?php echo $rateOfInterest .'%'?> 
							</div>
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 no-pad">
								<a style="width:24px; height:24px;margin-left:.5em;" class="pull-right img-responsive" href="<?=site_url()?>admin_settings/Admin_setting/import_cal_setting" title="Reset"><img src="<?=site_url();?>images/refresh.svg"/></a>

								<a style="cursor:pointer;"><img style="margin-left:10em;width:24px; height:24px" title="Export Calendar Details" id="buttonExcel" src="<?=site_url();?>images/excel_icon.svg"/></a>&nbsp;&nbsp;
								
								<a style="width:24px; height:24px;" class="pull-right img-responsive" title="Import"><img id ="edithide1" onclick="show_import()" src="<?=site_url();?>images/import.svg"  style="display: block;"/></a>

								<a style="width:24px; height:24px;margin-right:.5em;" class="pull-right img-responsive" href="<?=site_url()?>admin_settings/Admin_setting/calendar_display" title="Back"><img id ="edithide2"  src="<?=site_url();?>images/back_icon.svg" /></a>
							</div>
						</div>
						<br />
						<div class="form-group" id="calendar_data">
							<table class="table table-bordered">
								<thead>
								  <tr>
									<th><center>DATE</center></th>
									<th><center>SAMVATSARA</center></th>
									<th><center>MASA</center></th>
									<th><center>SH/BH</center></th>
									<th><center>THITHI</center></th>
									<th><center>CODE</center></th>
									<th><center>NAKSHATRA</center></th>
									<th><center>DAY</center></th>
									<th><center>OPS</center></th>
								  </tr>
								</thead>
								<tbody>
									<?php $i=1; 
									foreach($import_cal_setting as $result) {
										$duplicatevalue=$result->DEACTIVE_STATUS;
										?>
										<tr>
											<?php if($duplicatevalue == 1) { ?>
												<td id="ENG_DATE_<?php echo $i; ?>"  style="width:9%;color: #800000;"><center><?php echo $result->ENG_DATE; ?></center></td>
											<?php } else {?>
												<td id="ENG_DATE_<?php echo $i; ?>"  style="width:9%;"><center><?php echo $result->ENG_DATE; ?></center></td>
											<?php } ?>
											<td style="width:10%"><div class="selectSamvatsara">
												<select id="SAMVATSARA_<?php echo $i; ?>" name="Samvatsara">
													<option style="color: #800000; font-weight: normal;" value="Samvatsara">SELECT SAMVATSARA</option>
													<option style="color: #800000; font-weight: normal;" value="PRABHAVA" <?php if($result->SAMVATSARA == 'PRABHAVA') echo 'selected'; else echo''; ?>>PRABHAVA</option>
													<option style="color: #800000; font-weight: normal;" value="VIBHAVA" <?php if($result->SAMVATSARA == 'VIBHAVA') echo 'selected'; else echo ''; ?>>VIBHAVA</option>
													<option style="color: #800000; font-weight: normal;" value="SUKLA" <?php if($result->SAMVATSARA == 'SUKLA') echo 'selected'; else echo ''; ?>>SUKLA</option>
													<option style="color: #800000; font-weight: normal;" value="PRAMODADUTA" <?php if($result->SAMVATSARA == 'PRAMODADUTA') echo 'selected'; else echo ''; ?>>PRAMODADUTA</option>
													<option style="color: #800000; font-weight: normal;" value="PRAJAPATI" <?php if($result->SAMVATSARA == 'PRAJAPATI') echo 'selected'; else echo ''; ?>>PRAJAPATI</option>
													<option style="color: #800000; font-weight: normal;" value="ANGIRASA" <?php if($result->SAMVATSARA == 'ANGIRASA') echo 'selected'; else echo ''; ?>>ANGIRASA</option>		
													<option style="color: #800000; font-weight: normal;" value="SRIMUKHA" <?php if($result->SAMVATSARA == 'SRIMUKHA') echo 'selected'; else echo ''; ?>>SRIMUKHA</option>		
													<option style="color: #800000; font-weight: normal;" value="BHAVA" <?php if($result->SAMVATSARA == 'BHAVA') echo 'selected'; else echo ''; ?>>BHAVA</option>	


													<option style="color: #800000; font-weight: normal;" value="YUVA" <?php if($result->SAMVATSARA == 'YUVA') echo 'selected'; else echo''; ?>>YUVA</option>
													<option style="color: #800000; font-weight: normal;" value="DHATRU" <?php if($result->SAMVATSARA == 'DHATRU') echo 'selected'; else echo ''; ?>>DHATRU</option>
													<option style="color: #800000; font-weight: normal;" value="ISVARA" <?php if($result->SAMVATSARA == 'ISVARA') echo 'selected'; else echo ''; ?>>ISVARA</option>
													<option style="color: #800000; font-weight: normal;" value="BAHUDHANYA" <?php if($result->SAMVATSARA == 'BAHUDHANYA') echo 'selected'; else echo ''; ?>>BAHUDHANYA</option>
													<option style="color: #800000; font-weight: normal;" value="PRAMATHI" <?php if($result->SAMVATSARA == 'PRAMATHI') echo 'selected'; else echo ''; ?>>PRAMATHI</option>
													<option style="color: #800000; font-weight: normal;" value="VIKRAMA" <?php if($result->SAMVATSARA == 'VIKRAMA') echo 'selected'; else echo ''; ?>>VIKRAMA</option>		
													<option style="color: #800000; font-weight: normal;" value="VRUSHAPRAJA" <?php if($result->SAMVATSARA == 'VRUSHAPRAJA') echo 'selected'; else echo ''; ?>>VRUSHAPRAJA</option>		
													<option style="color: #800000; font-weight: normal;" value="CHITRABHANU" <?php if($result->SAMVATSARA == 'CHITRABHANU') echo 'selected'; else echo ''; ?>>CHITRABHANU</option>	


													<option style="color: #800000; font-weight: normal;" value="SUBHANU" <?php if($result->SAMVATSARA == 'SUBHANU') echo 'selected'; else echo''; ?>>SUBHANU</option>
													<option style="color: #800000; font-weight: normal;" value="TARANA" <?php if($result->SAMVATSARA == 'TARANA') echo 'selected'; else echo ''; ?>>TARANA</option>
													<option style="color: #800000; font-weight: normal;" value="PARTHIVA" <?php if($result->SAMVATSARA == 'PARTHIVA') echo 'selected'; else echo ''; ?>>PARTHIVA</option>
													<option style="color: #800000; font-weight: normal;" value="VYAYA" <?php if($result->SAMVATSARA == 'VYAYA') echo 'selected'; else echo ''; ?>>VYAYA</option>
													<option style="color: #800000; font-weight: normal;" value="SARVAJIT" <?php if($result->SAMVATSARA == 'SARVAJIT') echo 'selected'; else echo ''; ?>>SARVAJIT</option>
													<option style="color: #800000; font-weight: normal;" value="SARVADHARIN" <?php if($result->SAMVATSARA == 'SARVADHARIN') echo 'selected'; else echo ''; ?>>SARVADHARIN</option>		
													<option style="color: #800000; font-weight: normal;" value="VIRODHIN" <?php if($result->SAMVATSARA == 'VIRODHIN') echo 'selected'; else echo ''; ?>>VIRODHIN</option>		
													<option style="color: #800000; font-weight: normal;" value="VIKRTI" <?php if($result->SAMVATSARA == 'VIKRTI') echo 'selected'; else echo ''; ?>>VIKRTI</option>	


													<option style="color: #800000; font-weight: normal;" value="KHARA" <?php if($result->SAMVATSARA == 'KHARA') echo 'selected'; else echo''; ?>>KHARA</option>
													<option style="color: #800000; font-weight: normal;" value="NANDANA" <?php if($result->SAMVATSARA == 'NANDANA') echo 'selected'; else echo ''; ?>>NANDANA</option>
													<option style="color: #800000; font-weight: normal;" value="VIJAYA" <?php if($result->SAMVATSARA == 'VIJAYA') echo 'selected'; else echo ''; ?>>VIJAYA</option>
													<option style="color: #800000; font-weight: normal;" value="JAYA" <?php if($result->SAMVATSARA == 'JAYA') echo 'selected'; else echo ''; ?>>JAYA</option>
													<option style="color: #800000; font-weight: normal;" value="MANMATHA" <?php if($result->SAMVATSARA == 'MANMATHA') echo 'selected'; else echo ''; ?>>MANMATHA</option>
													<option style="color: #800000; font-weight: normal;" value="DURMUKHA" <?php if($result->SAMVATSARA == 'DURMUKHA') echo 'selected'; else echo ''; ?>>DURMUKHA</option>		
													<option style="color: #800000; font-weight: normal;" value="HEVILAMBI" <?php if($result->SAMVATSARA == 'HEVILAMBI') echo 'selected'; else echo ''; ?>>HEVILAMBI</option>		
													<option style="color: #800000; font-weight: normal;" value="VILAMBI" <?php if($result->SAMVATSARA == 'VILAMBI') echo 'selected'; else echo ''; ?>>VILAMBI</option>


													<option style="color: #800000; font-weight: normal;" value="VIKARI" <?php if($result->SAMVATSARA == 'VIKARI') echo 'selected'; else echo''; ?>>VIKARI</option>
													<option style="color: #800000; font-weight: normal;" value="SHARVARI" <?php if($result->SAMVATSARA == 'SHARVARI') echo 'selected'; else echo ''; ?>>SHARVARI</option>
													<option style="color: #800000; font-weight: normal;" value="PLAVA" <?php if($result->SAMVATSARA == 'PLAVA') echo 'selected'; else echo ''; ?>>PLAVA</option>
													<option style="color: #800000; font-weight: normal;" value="SUBHAKRTA" <?php if($result->SAMVATSARA == 'SUBHAKRTA') echo 'selected'; else echo ''; ?>>SUBHAKRTA</option>
													<option style="color: #800000; font-weight: normal;" value="SOBHAKRATHA" <?php if($result->SAMVATSARA == 'SOBHAKRATHA') echo 'selected'; else echo ''; ?>>SOBHAKRATHA</option>
													<option style="color: #800000; font-weight: normal;" value="KRODHIN" <?php if($result->SAMVATSARA == 'KRODHIN') echo 'selected'; else echo ''; ?>>KRODHIN</option>		
													<option style="color: #800000; font-weight: normal;" value="VISVVASU" <?php if($result->SAMVATSARA == 'VISVVASU') echo 'selected'; else echo ''; ?>>VISVVASU</option>		
													<option style="color: #800000; font-weight: normal;" value="PARABHAVA" <?php if($result->SAMVATSARA == 'PARABHAVA') echo 'selected'; else echo ''; ?>>PARABHAVA</option>	


													<option style="color: #800000; font-weight: normal;" value="PLAVANGA" <?php if($result->SAMVATSARA == 'PLAVANGA') echo 'selected'; else echo''; ?>>PLAVANGA</option>
													<option style="color: #800000; font-weight: normal;" value="KILAKA" <?php if($result->SAMVATSARA == 'KILAKA') echo 'selected'; else echo ''; ?>>KILAKA</option>
													<option style="color: #800000; font-weight: normal;" value="SAUMYA" <?php if($result->SAMVATSARA == 'SAUMYA') echo 'selected'; else echo ''; ?>>SAUMYA</option>
													<option style="color: #800000; font-weight: normal;" value="SADHARANA" <?php if($result->SAMVATSARA == 'SADHARANA') echo 'selected'; else echo ''; ?>>SADHARANA</option>
													<option style="color: #800000; font-weight: normal;" value="VIRODHAKRTA" <?php if($result->SAMVATSARA == 'VIRODHAKRTA') echo 'selected'; else echo ''; ?>>VIRODHAKRTA</option>
													<option style="color: #800000; font-weight: normal;" value="PARIDHAVIN" <?php if($result->SAMVATSARA == 'PARIDHAVIN') echo 'selected'; else echo ''; ?>>PARIDHAVIN</option>		
													<option style="color: #800000; font-weight: normal;" value="PRAMADIN" <?php if($result->SAMVATSARA == 'PRAMADIN') echo 'selected'; else echo ''; ?>>PRAMADIN</option>		
													<option style="color: #800000; font-weight: normal;" value="ANANDA" <?php if($result->SAMVATSARA == 'ANANDA') echo 'selected'; else echo ''; ?>>ANANDA</option>


													<option style="color: #800000; font-weight: normal;" value="RAKSASA" <?php if($result->SAMVATSARA == 'RAKSASA') echo 'selected'; else echo''; ?>>RAKSASA</option>
													<option style="color: #800000; font-weight: normal;" value="NALA/ANALA" <?php if($result->SAMVATSARA == 'NALA/ANALA') echo 'selected'; else echo ''; ?>>NALA/ANALA</option>
													<option style="color: #800000; font-weight: normal;" value="PINGALA" <?php if($result->SAMVATSARA == 'PINGALA') echo 'selected'; else echo ''; ?>>PINGALA</option>
													<option style="color: #800000; font-weight: normal;" value="KALAYUKTA" <?php if($result->SAMVATSARA == 'KALAYUKTA') echo 'selected'; else echo ''; ?>>KALAYUKTA</option>
													<option style="color: #800000; font-weight: normal;" value="SIDDHARTHIN" <?php if($result->SAMVATSARA == 'SIDDHARTHIN') echo 'selected'; else echo ''; ?>>SIDDHARTHIN</option>
													<option style="color: #800000; font-weight: normal;" value="RAUDRA" <?php if($result->SAMVATSARA == 'RAUDRA') echo 'selected'; else echo ''; ?>>RAUDRA</option>		
													<option style="color: #800000; font-weight: normal;" value="DURMATI" <?php if($result->SAMVATSARA == 'DURMATI') echo 'selected'; else echo ''; ?>>DURMATI</option>		
													<option style="color: #800000; font-weight: normal;" value="DUNDUBHI" <?php if($result->SAMVATSARA == 'DUNDUBHI') echo 'selected'; else echo ''; ?>>DUNDUBHI</option>
													<option style="color: #800000; font-weight: normal;" value="RUDHIRODGARIN" <?php if($result->SAMVATSARA == 'RUDHIRODGARIN') echo 'selected'; else echo''; ?>>RUDHIRODGARIN</option>
													<option style="color: #800000; font-weight: normal;" value="RAKTAKSIN" <?php if($result->SAMVATSARA == 'RAKTAKSIN') echo 'selected'; else echo ''; ?>>RAKTAKSIN</option>
													<option style="color: #800000; font-weight: normal;" value="KRODHANA/MANYU" <?php if($result->SAMVATSARA == 'KRODHANA/MANYU') echo 'selected'; else echo ''; ?>>KRODHANA/MANYU</option>
													<option style="color: #800000; font-weight: normal;" value="AKSHAYA" <?php if($result->SAMVATSARA == 'AKSHAYA') echo 'selected'; else echo ''; ?>>AKSHAYA</option>

												</select>
											</div></td>
											<td style="width:10%"><div class="selectMasa">
												<select id="MASA_<?php echo $i; ?>" name="Masa" onchange="onChangeOfMasa(this);">
													<option style="color: #800000; font-weight: normal;" value="SELECT MASA">SELECT MASA</option>
													<option style="color: #800000; font-weight: normal;" value="CHA" <?php if($result->MASA == 'CHAITRA') echo 'selected'; else echo''; ?>>CHAITRA</option>
													<option style="color: #800000; font-weight: normal;" value="VAI" <?php if($result->MASA == 'VAISHAKHA') echo 'selected'; else echo ''; ?>>VAISHAKHA</option>
													<option style="color: #800000; font-weight: normal;" value="JYE" <?php if($result->MASA == 'JYESTA') echo 'selected'; else echo ''; ?>>JYESTA</option>
													<option style="color: #800000; font-weight: normal;" value="ASD" <?php if($result->MASA == 'ASHADA') echo 'selected'; else echo ''; ?>>ASHADA</option>
													<option style="color: #800000; font-weight: normal;" value="SHR" <?php if($result->MASA == 'SHRAVANA') echo 'selected'; else echo ''; ?>>SHRAVANA</option>
													<option style="color: #800000; font-weight: normal;" value="BHA" <?php if($result->MASA == 'BHADRAPADA') echo 'selected'; else echo ''; ?>>BHADRAPADA</option>
													<option style="color: #800000; font-weight: normal;" value="ASW" <?php if($result->MASA == 'ASHWIJA') echo 'selected'; else echo ''; ?>>ASHWIJA</option>		
													<option style="color: #800000; font-weight: normal;" value="KAR" <?php if($result->MASA == 'KARTHIKA') echo 'selected'; else echo ''; ?>>KARTHIKA</option>		
													<option style="color: #800000; font-weight: normal;" value="MAR" <?php if($result->MASA == 'MARGASHEERA') echo 'selected'; else echo ''; ?>>MARGASHEERA</option>		
													<option style="color: #800000; font-weight: normal;" value="PUS" <?php if($result->MASA == 'PUSHYA') echo 'selected'; else echo ''; ?>>PUSHYA</option>	
													<option style="color: #800000; font-weight: normal;" value="MAG" <?php if($result->MASA == 'MAGHA') echo 'selected'; else echo ''; ?>>MAGHA</option>		
													<option style="color: #800000; font-weight: normal;" value="PHA" <?php if($result->MASA == 'PHALGUNA') echo 'selected'; else echo ''; ?>>PHALGUNA</option>		
													<option style="color: #800000; font-weight: normal;" value="PUR" <?php if($result->MASA == 'PURUSHOTTAM') echo 'selected'; else echo ''; ?>>PURUSHOTTAM</option>
													<option style="color: #800000; font-weight: normal;" value="ADH" <?php if($result->MASA == 'ADHIKA') echo 'selected'; else echo ''; ?>>ADHIKA</option>
												</select>
											</div></td>
											<td style="width:5%"><div class="selectBom">
												<select id="BOM_<?php echo $i; ?>" name="BOM" onchange="onChangeOfMoon(this);">
													<option style="color: #800000; font-weight: normal;" value="SELECT SH/BH">SELECT SH/BH</option>
													<option style="color: #800000; font-weight: normal;" value="SH" <?php if($result->BASED_ON_MOON == 'SHUDDHA') echo 'selected'; else echo''; ?>>SHUDDHA</option>
													<option style="color: #800000; font-weight: normal;" value="BH" <?php if($result->BASED_ON_MOON == 'BAHULA') echo 'selected'; else echo ''; ?>>BAHULA</option>
												</select>
											</div></td>
											<td style="width:140px"><div class="selectThithi">
												<select id="THITHI_<?php echo $i; ?>" name="THITHI" onchange="onChangeOfThithi(this)" >
													<option style="color: #800000; font-weight: normal;" value="SELECT THITHI">SELECT THITHI</option>
													<option style="color: #800000; font-weight: normal;" value="01" <?php if($result->THITHI_NAME == 'PADYA') echo 'selected'; else echo''; ?>>PADYA</option>
													<option style="color: #800000; font-weight: normal;" value="02" <?php if($result->THITHI_NAME == 'BIDIGE') echo 'selected'; else echo ''; ?>>BIDIGE</option>
													<option style="color: #800000; font-weight: normal;" value="03" <?php if($result->THITHI_NAME == 'TADIGE') echo 'selected'; else echo ''; ?>>TADIGE</option>
													<option style="color: #800000; font-weight: normal;" value="04" <?php if($result->THITHI_NAME == 'CHOWTHI') echo 'selected'; else echo ''; ?>>CHOWTHI</option>
													<option style="color: #800000; font-weight: normal;" value="05" <?php if($result->THITHI_NAME == 'PANCHAMI') echo 'selected'; else echo ''; ?>>PANCHAMI</option>
													<option style="color: #800000; font-weight: normal;" value="06" <?php if($result->THITHI_NAME == 'SHASHTHI') echo 'selected'; else echo ''; ?>>SHASHTHI</option>		
													<option style="color: #800000; font-weight: normal;" value="07" <?php if($result->THITHI_NAME == 'SAPTAMI') echo 'selected'; else echo ''; ?>>SAPTAMI</option>		
													<option style="color: #800000; font-weight: normal;" value="08" <?php if($result->THITHI_NAME == 'ASHTAMI') echo 'selected'; else echo ''; ?>>ASHTAMI</option>	
													<option style="color: #800000; font-weight: normal;" value="09" <?php if($result->THITHI_NAME == 'NAVAMI') echo 'selected'; else echo ''; ?>>NAVAMI</option>		
													<option style="color: #800000; font-weight: normal;" value="10" <?php if($result->THITHI_NAME == 'DASHAMI') echo 'selected'; else echo ''; ?>>DASHAMI</option>		
													<option style="color: #800000; font-weight: normal;" value="11" <?php if($result->THITHI_NAME == 'EKADASHI') echo 'selected'; else echo ''; ?>>EKADASHI</option>
													<option style="color: #800000; font-weight: normal;" value="12" <?php if($result->THITHI_NAME == 'DWADASHI') echo 'selected'; else echo ''; ?>>DWADASHI</option>		
													<option style="color: #800000; font-weight: normal;" value="13" <?php if($result->THITHI_NAME == 'TRAYODASHI') echo 'selected'; else echo ''; ?>>TRAYODASHI</option>		
													<option style="color: #800000; font-weight: normal;" value="14" <?php if($result->THITHI_NAME == 'CHATURDASHI') echo 'selected'; else echo ''; ?>>CHATURDASHI</option>
													<?php if($result->THITHI_NAME == '') { ?>
														<option style="color: #800000; font-weight: normal;" value="15" 		<?php if($result->THITHI_NAME == 'HUNNIME') echo 'selected'; else echo ''; ?>>HUNNIME</option>
													<?php } else { ?>
														<?php if($result->BASED_ON_MOON == 'SHUDDHA') { ?>
															<option style="color: #800000; font-weight: normal;" value="15" 		<?php if($result->THITHI_NAME == 'HUNNIME') echo 'selected'; else echo ''; ?>>HUNNIME</option>
														<?php } else { ?>
															<option style="color: #800000; font-weight: normal;" value="15" 		<?php if($result->THITHI_NAME == 'AMAVASYA') echo 'selected'; else echo ''; ?>>AMAVASYA</option>
														<?php } ?>		
													<?php } ?>
												</select>
											</div></td>
											
											<td id="THITHISC_<?php echo $i; ?>" style="width: 80px">
												<center><?php echo $result->THITHI_SHORT_CODE; ?></center>
											</td>
											<td title="Please right-click for adding Nakshatra" style="width: 170px;" id="cont_<?php echo $i; ?>" class="cont" oncontextmenu="return showContextMenu(this,event)"><?php echo $result->STAR; ?>
												<?php if($result->STAR != "") { ?>
													<a title="Please remove Nakshatra" id="remove_<?php echo $i; ?>" onclick=GetRemoveNakshatra(this)><span style="color: #800000;" class="glyphicon glyphicon-minus-sign"></span></a>
												<?php } ?>
											</td>
											<td id="day_<?php echo $i; ?>" style="width: 3%"><?php echo $result->DAY; ?></td>
											<td>
												<button tabindex="0" class="dtrecord" title="Update Date Record" id="add_<?php echo $i; ?>" onclick=GetAddCalDateRecord(this,<?php echo $result->CAL_ID ?>,<?php echo $result->CAL_YEAR_ID ?>) onfocus=GetCalledWhenFocussedOnAddDate(this) onfocusout=GetCalledWhenFocussedOutOfAddDate(this)><span class="glyphicon glyphicon-save"></span></button>
												<?php if($result->DUPLICATE == 0) { ?>
													<button tabindex="1" class="dtrecord" title="Duplicate Date Record" id="duplicate_<?php echo $i; ?>" onclick=GetConfirmDuplicateDateRecord(this,<?php echo $result->CAL_ID ?>,<?php echo $result->CAL_YEAR_ID ?>)><span class="glyphicon glyphicon-copy"></span></button>
												<?php } else if($result->DUPLICATE > 0) { ?>
													<button tabindex="2" class="dtrecord" title="Remove Duplicate Date Record" id="remduplicate_<?php echo $i; ?>" onclick=GetConfirmRemoveDuplicateDateRecord(this,<?php echo $result->CAL_ID ?>,<?php echo $result->CAL_YEAR_ID ?>,<?php echo $result->DUPLICATE ?>)><span  class="glyphicon glyphicon-minus-sign"></span></button>
												<?php } ?>
												<span id="timerSaved_<?php echo $i; ?>" style="color: #800000; font-size:20px; float: right; display: none;" class="glyphicon glyphicon-ok"></span>
											</td>
										</tr>
									<?php $i++; }  ?>
								</tbody>
							</table>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Import Modal2 -->
<div id="myModalImport" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content" style="padding-bottom:1em;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Import Details</h4>
			</div>
			<div class="modal-body" id="importdet" >
				
					<!--code for importing excel file starts-->
						<div class="container">
							<br />
							<!--<h3>Import Excel Details </h3>-->
							<form method="post" id="import_form" enctype="multipart/form-data">
								<p><label>Select Excel File</label>
								<input type="file" name="file" id="file" required accept=".xls, .xlsx" /></p>
								<br />
								<input type="submit" name="import" value="Import" class="btn btn-info" />
								<input type="hidden" name="calId" id="calId" value = "<?php echo $calId ?>"/>
							</form>
							
						</div>
						<!--code for importing excel file ends-->
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>
<div tabindex="0" id="contextMenu" class="context-menu">
	<ul id="foo">
		<li id="0" class="element-hover">ASHWINI</li>
		<li id="1">BHARANI</li>
		<li id="2">KRITIKA</li>
		<li id="3">ROHINI</li>
		<li id="4">MRIGASHIRSHA</li>
		<li id="5">ARDRA</li>
		<li id="6">PUNARVASU</li>
		<li id="7">PUSHYA</li>
		<li id="8">ASHLESHA</li>
		<li id="9">MAGHA</li>
		<li id="10">HUBBA OR PURVA PHALGUNI</li>
		<li id="11">UTTARA OR UTTARA PHALGUNI</li>
		<li id="12">HASTA</li>
		<li id="13">CHITRA</li>
		<li id="14">SWATHI</li>
		<li id="15">VISAKHA</li>
		<li id="16">ANURADHA</li>
		<li id="17">JYESHTHA</li>
		<li id="18">MULA</li>
		<li id="19">PURVA ASHADHA</li>
		<li id="20">UTTARA ASADHA</li>
		<li id="21">SHRAVANA</li>
		<li id="22">DHANISHTA OR SRAVISTHA</li>
		<li id="23">SHATABHISHA OR SATATARAKA</li>
		<li id="24">PURVA BHADRA</li>
		<li id="25">UTTARA BHADRA</li>
		<li id="26">REVATI</li>
	</ul>
</div>	 

<form id="formGenReport" method="post">
	<input type="hidden" name="dateStart" id="dateStart" value="<?php echo $calStartDate ?> " />
	<input type="hidden" name="dateEnd" id="dateEnd" value="<?php echo $calEndDate ?> " />
</form>	

<script>
	//progress bar code starts
	$(window).bind("load", function () {
        $('#work-in-progress2').fadeOut(100);
        $('#loading-progress-text2').fadeOut(100);
    });
	//progress bar code ends

	$(document).ready(function(){
		
		$('#import_form').on('submit', function(event){
			 $('#myModalImport').modal('toggle');
			event.preventDefault();
			$.ajax({
				url:"<?php echo base_url(); ?>Excel_import/import",
				method:"POST",
				data:new FormData(this),
				contentType:false,
				cache:false,
				processData:false,
				success:function(data){
					$('#file').val('');
					window.location.href = "<?php echo base_url(); ?>admin_settings/Admin_setting/getCalendarRecords";
					alert("Information",data,"OK");

				}
			})
		});
	});

	var eleId = "";
	window.onclick = hideContextMenu;
	window.onkeydown = listenKeys;
	var contextMenu = document.getElementById('contextMenu');

	contextMenu.addEventListener('click', function(eve) {
		$('#'+eleId).html((($('#'+eleId).text().trim() != "")?$('#'+eleId).text().trim()+","+eve.target.innerHTML:eve.target.innerHTML)+
			' <a id=remove_'+eleId.split('_')[1]+' onclick=GetRemoveNakshatra(this)><span style="color: #800000;" class="glyphicon glyphicon-minus-sign"></span></a>');
		$('#add_'+eleId.split('_')[1]).focus();
	});


	function GetCalledWhenFocussedOnAddDate(ele) {
		$("#"+ele.id).addClass("add-hover");
	}

	function GetCalledWhenFocussedOutOfAddDate(ele) {
		$("#"+ele.id).removeClass("add-hover");
	}

	function onFocusOutCall(ele) {
		if($("#MASA_"+ele.id.split('_')[1]).val() != "SELECT MASA" && $("#BOM_"+ele.id.split('_')[1]).val() != "SELECT SH/BH" && $('#THITHI_'+ele.id.split('_')[1]).val() != "SELECT THITHI") {
			contextMenu.style.display = 'block';
			contextMenu.style.left = (ele.offsetParent.offsetLeft+225) + 'px';
			contextMenu.style.top = ele.offsetParent.offsetTop + 'px';
			eleId = "cont_"+ele.id.split('_')[1];
			displayListItemsAccordingly(eleId);
			
			contextMenu.focus();
		}
	}

	$('#contextMenu').on("keydown",function(e) {
        if(e.which == 40 || e.keyCode == 40) {
            if((parseInt($('li.element-hover')[0].id)*50) < 1300) 
            	$('#contextMenu').find("li.element-hover").removeClass("element-hover").next().addClass("element-hover");
        } else if(e.which == 38 || e.keyCode == 38) {
        	if((parseInt($('li.element-hover')[0].id)*50) > 0)
        		$('#contextMenu').find("li.element-hover").removeClass("element-hover").prev().addClass("element-hover");
        } else if(e.which == 13 && e.keyCode == 13) {
        	$('#'+eleId).html((($('#'+eleId).text().trim() != "")?$('#'+eleId).text().trim()+","+$('li.element-hover')[0].innerHTML:$('li.element-hover')[0].innerHTML)+
				' <a id=remove_'+eleId.split('_')[1]+' onclick=GetRemoveNakshatra(this)><span style="color: #800000;" class="glyphicon glyphicon-minus-sign"></span></a>'
			);
			hideContextMenu();
			$('#add_'+eleId.split('_')[1]).focus();
			e.preventDefault();
        } else if(e.which == 9 && e.keyCode == 9) {
        	hideContextMenu();
			$('#add_'+eleId.split('_')[1]).focus();
			e.preventDefault();
        }
		
		$("#contextMenu").scrollTop(0);
		$("#contextMenu").scrollTop((parseInt($('li.element-hover')[0].id)*50)-$("#contextMenu").height());//then set equal to the position of the selected element minus the height of scrolling div
    });

	function displayListItemsAccordingly(id) {
		var ul = document.getElementById("foo");
		var items = ul.getElementsByTagName("li");
		var listItems = $('#'+id).text();
		if(listItems != undefined) {
			for (var i = 0; i < items.length; ++i) {
				if(listItems.search(items[i].innerHTML) != -1) {
					items[i].classList.add('hideListItem');
				} else {
					items[i].classList.remove('hideListItem');
				}
			}	
		}
	}

	function showContextMenu(ele,eve) {
		contextMenu.style.display = 'block';
		contextMenu.style.left = eve.pageX + 'px';
		contextMenu.style.top = eve.pageY + 'px';
		
		eleId = ele.id;
		displayListItemsAccordingly(ele.id);
		return false;
	}

	function GetConfirmRemoveDuplicateDateRecord(ele,CalId,CalYearId,DupCalYearId) {
    	var date = $('#ENG_DATE_'+ele.id.split('_')[1]).text();
    	$.confirm({
			title: "Confirmation",
			content: "Do you want to remove duplicate date <b>("+$('#ENG_DATE_'+ele.id.split('_')[1]).text()+")</b> record?",
			type: 'red',
			typeAnimated: true,
			closeIcon:false,
			buttons: {
				'Yes': {
					action: function() {
						GetRemoveDuplicateDateRecord(ele,CalId,CalYearId,DupCalYearId);						
					}
				},
				'No': {
					// Nothing to do in this case. You can as well omit the action property.
				}
			}
		});
    }

	function GetRemoveDuplicateDateRecord(ele,CalId,CalYearId,DupCalYearId) {
		let url = "<?=site_url()?>admin_settings/Admin_setting/deleteDuplicateDateRecordsBasedOnCalYearId";
		$.post(url, {'CalYearId': CalYearId,'CalId': CalId, 'DupCalYearId': DupCalYearId}, function (e) {
			//e1 = e.split("|")
			if (e.trim() == "success") {
				location.href = "<?=site_url();?>admin_settings/Admin_setting/import_cal_setting";
			} else
				alert("Information","Something went wrong, Please try again after some time");
		});
	}

    function GetConfirmDuplicateDateRecord(ele,CalId,CalYearId) {
    	$.confirm({
			title: "Confirmation",
			content: "Do you want to duplicate date <b>("+$('#ENG_DATE_'+ele.id.split('_')[1]).text()+")</b> record?",
			type: 'red',
			typeAnimated: true,
			closeIcon:false,
			buttons: {
				'Yes': {
					action: function() {
						GetDuplicateDateRecord(ele,CalId,CalYearId);						
					}
				},
				'No': {
					// Nothing to do in this case. You can as well omit the action property.
				}
			}
		});
    }

	function GetDuplicateDateRecord(ele,CalId,CalYearId) {
		let url = "<?=site_url()?>admin_settings/Admin_setting/duplicateDateRecordsBasedOnCalYearId";
		$.post(url, {'CalYearId': CalYearId,'CalId': CalId, 'EngDate': $('#ENG_DATE_'+ele.id.split('_')[1]).text(), 'Samvatsara': $('#SAMVATSARA_'+ele.id.split('_')[1]).val(), 'TSC': $('#THITHISC_'+ele.id.split('_')[1]).text(), 'Thithi': $('#THITHI_'+ele.id.split('_')[1]+" option:selected").text(), 'Bom': $("#BOM_"+ele.id.split('_')[1]+" option:selected").text(), 'Masa': $("#MASA_"+ele.id.split('_')[1]+" option:selected").text(), 'Star': $('#cont_'+ele.id.split('_')[1]).text().trim(), Day: $('#day_'+ele.id.split('_')[1]).text()}, function (e) {

			//e1 = e.split("|")
			if (e.trim() == "success") {
				location.href = "<?=site_url();?>admin_settings/Admin_setting/import_cal_setting";
			} else
				alert("Information","Something went wrong, Please try again after some time");
		});
	}

	function GetAddCalDateRecord(ele,CalId,CalYearId) {
	
		if($('#SAMVATSARA_'+ele.id.split('_')[1]).val() == "SELECT SAMVATSARA" || $('#THITHI_'+ele.id.split('_')[1]).val() == "SELECT THITHI" || $("#BOM_"+ele.id.split('_')[1]).val() == "SELECT SH/BH" || $("#MASA_"+ele.id.split('_')[1]).val() == "SELECT MASA" 
		 /* || $('#cont_'+ele.id.split('_')[1]).text().trim() == "" */
		) {
			alert("Information","Please select appropriate SAMVATSARA, MASA, SH/BH, THITHI and NAKSHATRA options for the Date <b>("+$('#ENG_DATE_'+ele.id.split('_')[1]).text()+")</b>");
			return;
		}

		let url = "<?=site_url()?>admin_settings/Admin_setting/updateDateRecordsBasedOnCalYearId";
		$.post(url, {'CalYearId': CalYearId,'CalId': CalId, 'EngDate': $('#ENG_DATE_'+ele.id.split('_')[1]).text(), 'Samvatsara': $('#SAMVATSARA_'+ele.id.split('_')[1]).val(), 'TSC': $('#THITHISC_'+ele.id.split('_')[1]).text(), 'Thithi': $('#THITHI_'+ele.id.split('_')[1]+" option:selected").text(), 'Bom': $("#BOM_"+ele.id.split('_')[1]+" option:selected").text(), 'Masa': $("#MASA_"+ele.id.split('_')[1]+" option:selected").text(), 'Star': $('#cont_'+ele.id.split('_')[1]).text().trim()}, function (e) {

			//e1 = e.split("|")
			if (e.trim() == "success") {
				if($("#SAMVATSARA_"+(parseInt(ele.id.split("_")[1])+1)).val() == "Samvatsara") {
					$("#SAMVATSARA_"+(parseInt(ele.id.split("_")[1])+1)).val($("#SAMVATSARA_"+ele.id.split("_")[1]).val());	
					$("#SAMVATSARA_"+(parseInt(ele.id.split("_")[1])+1)).focus();
				}
				window.location.reload();
				$("#timerSaved_"+ele.id.split('_')[1]).show();
				var id = setInterval(hideTickMarkAfterInterval, 2000);
			  	function hideTickMarkAfterInterval() {
			    	clearInterval(id);
			    	$("#timerSaved_"+ele.id.split('_')[1]).hide();
			    	$('#add_'+eleId.split('_')[1]).removeClass("add-hover");

			  	}	
			}else if(e.trim() == "failed"){
				alert("Information","Please enter valid Thithi for Duplicate date");

			} else
				alert("Information","Something went wrong, Please try again after some time");
		});
	}
	
	function GetRemoveNakshatra(ele) {
		$('#cont_'+ele.id.split('_')[1]).html('');
	}

	function hideContextMenu() {
		contextMenu.style.display = 'none';
	}

	function listenKeys(event) {
		var keyCode = event.which || event.keyCode;
		if(keyCode == 27) {
			hideContextMenu();
		}
	}

	function onChangeOfMoon(ele) {
		if($("#MASA_"+ele.id.split('_')[1]).val() != "SELECT MASA") {
			if($('#'+ele.id).val() == "BH") {
				$("#THITHI_"+ele.id.split('_')[1]+" option[value='15']").remove();
				$("#THITHI_"+ele.id.split('_')[1]).append('<option style="color: #800000; font-weight: normal;" value="30">AMAVASYA</option>');	
			} else {
				$("#THITHI_"+ele.id.split('_')[1]+" option[value='15']").remove();
				$("#THITHI_"+ele.id.split('_')[1]+" option[value='30']").remove();
				$("#THITHI_"+ele.id.split('_')[1]).append('<option style="color: #800000; font-weight: normal;" value="15">HUNNIME</option>');	
			}
		} else {
			$('#'+ele.id).val('SELECT SH/BH');
			alert("Information","Please select appropriate MASA for the Date <b>("+$('#ENG_DATE_'+ele.id.split('_')[1]).text()+")</b>");
		}
		//ABHIPRAA CODE
		if($("#MASA_"+ele.id.split('_')[1]).val() != "SELECT MASA" && $("#THITHI_"+ele.id.split('_')[1]).val() != "SELECT THITHI") {
			$("#THITHISC_"+ele.id.split('_')[1]).html('<center>'+$("#MASA_"+ele.id.split('_')[1]).val()+$("#BOM_"+ele.id.split('_')[1]).val()+$("#THITHI_"+ele.id.split('_')[1]).val()+'</center>');
		}
		//END 
		
	}
	//ABHIPRA CODE
	function onChangeOfMasa(ele) {
		if($("#THITHI_"+ele.id.split('_')[1]).val() != "SELECT THITHI" && $("#BOM_"+ele.id.split('_')[1]).val() != "SELECT SH/BH") {
			$("#THITHISC_"+ele.id.split('_')[1]).html('<center>'+$("#MASA_"+ele.id.split('_')[1]).val()+$("#BOM_"+ele.id.split('_')[1]).val()+$("#THITHI_"+ele.id.split('_')[1]).val()+'</center>');
		}
	}
	//ENDS

	function onClickOfSamvatsara(ele) {
		//$("#SAMVATSARA_"+ele.id.split('_')[1]+" option[value='Samvatsara']").remove();
	}

	function onChangeOfThithi(ele) {
		if($("#MASA_"+ele.id.split('_')[1]).val() != "SELECT MASA" && $("#BOM_"+ele.id.split('_')[1]).val() != "SELECT SH/BH") {
			$("#THITHISC_"+ele.id.split('_')[1]).html('<center>'+$("#MASA_"+ele.id.split('_')[1]).val()+$("#BOM_"+ele.id.split('_')[1]).val()+$("#THITHI_"+ele.id.split('_')[1]).val()+'</center>');
		} else {
			$('#'+ele.id).val('SELECT THITHI');
			alert("Information","Please select appropriate MASA or Shuddha/Bahula for the Date <b>("+$('#ENG_DATE_'+ele.id.split('_')[1]).text()+")</b>");
		}
	}

	//code for importing excel file ends
    if('<?php echo $editStatus ?>' == 0){
		$("#edithide").hide();
    }

	$('#submitform').on('click',function(){
		 $('#formval').submit();
	});

	//DATEFIELD
	var currentTime = new Date()
	var minDate = "-1Y"; //one day next before month
	var maxDate =  0; // one day before next month
	$( ".todayDate2" ).datepicker({ 
		minDate: minDate, 
		maxDate: maxDate,
		dateFormat: 'dd-mm-yy'
	});
			
	$('.todayDate').on('click', function() {
		$( ".todayDate2" ).focus();
	})

	//DATEFIELD AND FILTER CHANGE
	function GetDataOnDate(date,url) {
		document.getElementById('date').value = date;
		document.getElementById('paymentMethod').value = $('#modeOfPayment').val();
		document.getElementById('users_id').value = $('#users').val();
		$("#dateChange").attr("action",url)
		$("#dateChange").submit();
	}
	
	//DATEFIELD AND FILTER CHANGE
	function GetDataOnUser(users,url) {
		document.getElementById('date').value = $('#todayDate').val();
		document.getElementById('users_id').value = users;
		document.getElementById('paymentMethod').value = $('#modeOfPayment').val();
		$("#dateChange").attr("action",url)
		$("#dateChange").submit();
	}
	
	//DATEFIELD AND FILTER CHANGE
	function GetDataOnFilter(payMode,url) {
		document.getElementById('date').value = $('#todayDate').val();
		document.getElementById('users_id').value = $('#users').val();
		document.getElementById('paymentMethod').value = payMode;
		$("#dateChange").attr("action",url)
		$("#dateChange").submit();
	}
	
	//SHOW MODAL
	function show_import() {
		$('#myModalImport').modal('show');  
	}
	// new code for export
	$('#buttonExcel').on('click',function(e){
		var url = '<?php echo site_url();?>admin_settings/Admin_setting/CalendarReportExcel';
		//$('#dateForReport').val(document.getElementById('todayDate').value);

		$("#formGenReport").attr("action",url);
		$("#formGenReport").submit(); 
	});


	//IMPORT DETAILS
	function save_import() {
		var users = ($('#users_active').val()).split("|");
		var events = ($('#events_active').val()).split("|");
		
		document.getElementById('userId').value = users[0];
		document.getElementById('userName').value = users[1];
		document.getElementById('eventId').value = events[0];
		document.getElementById('eventName').value = events[1];
		return true;
	}

	$('.table-responsive').on('show.bs.dropdown', function () {
	     $('.table-responsive').css( "overflow", "inherit" );
	});

	$('.table-responsive').on('hide.bs.dropdown', function () {
	     $('.table-responsive').css( "overflow", "auto" );
	})
</script>