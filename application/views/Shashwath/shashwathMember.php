<?php error_reporting(0); ?>
<div style="clear:both;" class="container">
	<img class="img-responsive bgImg2 bg1" src="<?=site_url()?>images/TempleLogo.png" />
	<div class="row form-group">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="row form-group">							
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
					<span class="eventsFont2">New Sevadhar</span>	
					<a class="pull-right" style="margin-left:5px;" href="<?=site_url()?>Shashwath/addMember" title="Refresh"><img style="width:24px; height:24px;" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
				</div>
			</div>	

			<div style="clear:both;" class="w5-row"> 
				<?php $i = 1;$j = 40;$name = array('Shashwath Member','Mandali Member Details','Shashwath Seva Details');
					for($k =0 ; $k<3 ;$k++) { ?>
						<a href="#" id="click" onclick="return openCity(event, '<?=$i++;?>');">
						<div id="<?=$j--;?>" class="w5-third tablink w5-bottombar w5-hover-light-grey w5-padding"><?php echo $name[$k];?></div>
						</a>
				<?php } ?>
			</div></br>	
			
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-left:0px;">	
				<div id="1" class="w5-container city">
					<div class= "col-lg-12 col-md-6 col-sm-12 col-xs-9">
						<div class="form-group" style="width: 220px;">
						  <label>Is Mandali</label>  
		                	<input type="checkbox" id="ismandali" name="ismandali" class="ismandali" onclick="showMandaliDetails();" /> 
						</div>				                
					</div>
				<div  id="isMemberDiv" class="w5-container ">	
					<div class= "col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class= "col-lg-12 col-md-6 col-sm-12 col-xs-9">
							<div class="form-group" >
								<label for="name">Name<span style="color:#800000;">*</span></label>
								<input autocomplete="none" type="text" class="form-control form_contct2" id="name" placeholder="" name="name" onkeyup="alphaonly(this)"/>
							</div>
						</div>

						<div class= "col-lg-6 col-md-6 col-sm-12 col-xs-9" style="padding-top:25px;">
							<div class="form-group">
								<label for="number">Number<span style="color:#800000;">*</span></label>
								<input autocomplete="off" type="text" class="form-control form_contct2" id="phone" placeholder="" name="phone" >
							</div>
						</div>
						<div class= "col-lg-6 col-md-6 col-sm-12 col-xs-9" style="padding-top:25px;">
							<div class="form-group">
								<label for="number">Additional Number</label>
								<input autocomplete="off" type="text" class="form-control form_contct2" id="phone2" placeholder="" name="phone2" >
							</div>
						</div>

						<!-- new code added by adithya for pan and adhaar start -->
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="padding-top:25px;">
					<div class="form-inline">
					  <label for="pan">Pan No</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					  <input type="text" class="form-control form_contct2" id="pan" placeholder="AJRPU4567R" name="pan" style="">
					</div>
				</div>

				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="padding-top:25px;">
					<div class="form-inline">
					  <label for="Adhaar">Adhaar No</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					  <input type="number" class="form-control form_contct2" id="adhaar" placeholder="321654987784" name="adhaar" style="">
					</div>
				</div>
				<!-- new code added by adithya for pan and adhaar end -->
						
						<div class= "col-lg-6 col-md-6 col-sm-12 col-xs-9" style="padding-top:25px;">
							<div class="form-group">
								<label for="rashi">Rashi</label>
								<input autocomplete="off" type="hidden" id="baseurl" name="baseurl" value="<?php echo site_url(); ?>" />
								<div class="dropdown">
									<input autocomplete="off" type="text" class="form-control form_contct2" id="rashi" onkeyup="alphaonly(this)" placeholder="" name="rashi">
									<ul class="dropdown-menu txtpin" style="margin-left:0px;margin-right:0px;max-height:400px;" role="menu" aria-labelledby="dropdownMenu"  id="DropdownRashi">
									</ul>
								</div>
							</div>
						</div>
						<div class= "col-lg-6 col-md-6 col-sm-12 col-xs-9" style="padding-top:25px;">
							<div class="form-group">
								<label for="nakshatra">Nakshatra </label>
								<input autocomplete="off" type="hidden" id="baseurl" name="baseurl" value="<?php echo site_url(); ?>" />
								<div class="dropdown">
									<input autocomplete="off" type="text" class="form-control form_contct2" id="nakshatra" onkeyup="alphaonly(this)" placeholder="" name="nakshatra">
									<ul class="dropdown-menu txtpin1" style="margin-left:0px;margin-right:0px;max-height:400px;" role="menu" aria-labelledby="dropdownMenu"  id="Dropdownnakshatra">
									</ul>
								</div>
							</div>
						</div>
						<div class= "col-lg-12 col-md-6 col-sm-12 col-xs-9" style="padding-top:20px;">
							<div class="form-group">
								<label for="gotra">Gotra </label>
								<input autocomplete="off" type="hidden" id="baseurl" name="baseurl" value="<?php echo site_url(); ?>" />
								<div class="dropdown">
									<input autocomplete="off" type="text" class="form-control form_contct2" id="gotra" onkeyup="alphaonly(this)" placeholder="" name="Gotra">
									<ul class="dropdown-menu txtpin1" style="margin-left:0px;margin-right:0px;max-height:400px;" role="menu" aria-labelledby="dropdownMenu"  id="Dropdowngotra">
									</ul>
								</div>
							</div>
						</div>
					</div>

					
					<div class= "col-lg-6 col-md-6 col-sm-6 col-xs-12">
						
						<div class= "col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label for="name">Address<span style="color:#800000;">*</span></label>
								<input autocomplete="none" type="text" class="form-control form_contct2" id="addrline1" placeholder="Address Line1" name="name" onkeyup="alphaonlyaddress(this)" maxlength="32" />
							</div>
						</div>
						<div class= "col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<input autocomplete="none" type="text" class="form-control form_contct2" id="addrline2" placeholder="Address Line2"  name="name" onkeyup="alphaonlyaddress(this)" maxlength="32"/>
							</div>
						</div>
						<div class= "col-lg-12 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<input autocomplete="none" type="text" class="form-control form_contct2" id="smcity" onkeyup="alphaonly(this)" placeholder="City" name="name" maxlength="32"/>
							</div>
						</div>
						<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<input autocomplete="none" type="text" class="form-control form_contct2" id="smstate" onkeyup="alphaonly(this)" placeholder="State" name="name" maxlength="32"/>
							</div>
						</div>
						<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<input autocomplete="none" type="text" class="form-control form_contct2" id="smcountry" onkeyup="alphaonly(this)" placeholder="Country" name="name" maxlength="32"/>
							</div>
						</div>
						<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<input autocomplete="none" type="text" class="form-control form_contct2" id="smpin" oninput="inputPincode(this.value)" placeholder="Pincode" name="name" maxlength="32"/></br>
							</div>
						</div>
					</div>
					<div class= "col-lg-6 col-md-6 col-sm-6 col-xs-12" style="padding-left:30px;">
						<label for="comment">Remarks: </label>
						<textarea class="form-control" rows="5" style="resize:none;" onkeyup="alphaonlypurpose(this)" id="smremarks"></textarea>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:80px;">
						<div class="container-fluid">
							<center>
								<button type="button" onclick = "goToTabShashwathSevaDetails();" class="btn btn-default btn-lg">
								Next  <span class="glyphicon glyphicon-forward"></span></button>
								
							</center>
						</div>
					</div>
				</div>

				<div id="isMandaliDiv" class="w5-container " hidden>
					<div class= "col-lg-6 col-md-6 col-sm-6 col-xs-12">
					
						<div class= "col-lg-12 col-md-6 col-sm-12 col-xs-9">
							<div class="form-group" >
								<label for="name">Mandali Name<span style="color:#800000;">*</span></label>
								<input autocomplete="none" type="text" class="form-control form_contct2" id="mandaliName" onkeyup="alphaonly(this)" placeholder="" name="mandaliName" />
							</div>
						</div>

						<div class= "col-lg-6 col-md-6 col-sm-12 col-xs-9" style="padding-top:25px;">
							<div class="form-group">
								<label for="number">Number<span style="color:#800000;">*</span></label>
								<input autocomplete="off" type="text" class="form-control form_contct2" id="mandaliPhone" placeholder="" name="mandaliPhone" >
							</div>
						</div>
						<div class= "col-lg-6 col-md-6 col-sm-12 col-xs-9" style="padding-top:25px;">
							<div class="form-group">
								<label for="number">Additional Number</label>
								<input autocomplete="off" type="text" class="form-control form_contct2" id="mandliPhone2" placeholder="" name="mandliPhone2" >
							</div>
						</div>
					 	<div class= "col-lg-12 col-md-6 col-sm-12 col-xs-9" style="padding-top:25px;">
							<div class="form-group">
								<label for="comment">Remarks: </label>
								<textarea class="form-control" rows="5" style="resize:none;" onkeyup="alphaonlypurpose(this)" id="mandliRemarks"></textarea>
								
							</div>
						</div> 
					</div>
					<div class= "col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class= "col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label for="name">Address<span style="color:#800000;">*</span></label>
								<input autocomplete="none" type="text" class="form-control form_contct2" id="mandliAddrline1" onkeyup="alphaonlyaddress(this)" placeholder="Address Line1" name="mandliAddrline1" maxlength="32"/>
							</div>
						</div>
						<div class= "col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<input autocomplete="none" type="text" class="form-control form_contct2" id="mandliAddrline2" onkeyup="alphaonlyaddress(this)" placeholder="Address Line2" name="mandliAddrline2" maxlength="32"/>
							</div>
						</div>
						<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<input autocomplete="none" type="text" class="form-control form_contct2" id="mandlicity" placeholder="City" onkeyup="alphaonly(this)" name="mandlicity" maxlength="32"/>
							</div>
						</div>
						<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<input autocomplete="none" type="text" class="form-control form_contct2" id="mandliState" onkeyup="alphaonly(this)" placeholder="State" name="mandliState" maxlength="32"/>
							</div>
						</div>
						<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<input autocomplete="none" type="text" class="form-control form_contct2" id="mandliCountry" onkeyup="alphaonly(this)" placeholder="Country" name="mandliCountry" maxlength="32"/>
							</div>
						</div>
						<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<input autocomplete="none" type="text" class="form-control form_contct2" id="mandliPin" oninput="inputPincode(this.value)" placeholder="Pincode" name="mandliPin"/></br>
							</div>
						</div>
					</div>
						
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:80px;">
						<div class="container-fluid">
							<center>
								<button type="button" onclick = "goToTabMandaliMemberDetails();" class="btn btn-default btn-lg">
								Next  <span class="glyphicon glyphicon-forward"></span></button>
							</center>
						</div>
					</div>

			</div>
		</div>
	</div>
	<div id="3" class="w5-container city" hidden>
		<div class="container">
			<img class="img-responsive bgImg2 bg2" src="<?=site_url()?>images/LAKSHMI.jpg" style="display:none;" />
			<img class="img-responsive bgImg2 bg3" src="<?=site_url()?>images/HANUMANTHA.jpg" style="display:none;" />
			<img class="img-responsive bgImg2 bg4" src="<?=site_url()?>images/GARUDA.jpg" style="display:none;" />
			<img class="img-responsive bgImg2 bg5" src="<?=site_url()?>images/GANAPATHI.jpg" style="display:none;" />
			<div class="row form-group">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="col-lg-4  col-md-5 col-sm-6 col-xs-6">
						<span class="eventsFont2 samFont1"></span>
					</div>
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="display:none;margin-bottom: 1.5em;">
				<div class="form-inline">
					<label for="number">Address </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<textarea class="form-control" rows="5" id="address" name="address" placeholder="Near Classic Chaya, Santhakatte" style="width: 100%;"></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div class="row">
						<div class="col-lg-7 col-md-12 col-sm-6 col-xs-12">
							<div class="form-group">
								<label for="deityCombo">Deity<span style="color:#800000;">*</span> </label>
								<select onChange="deityComboChange();" id="deityCombo" class="form-control">
									<?php foreach($deity as $result) { ?>
										<option value="<?=$result['DEITY_ID']; ?>">
											<?=$result['DEITY_NAME']; ?>
										</option>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"  style="padding-left:60px;">
							<div class="form-group">
								<label for="sevaAmount">Corpus Amount:<span style="color:#800000;">*</span>
									<br/>
								</label>
								<input autocomplete="none" type="text" class="form-control form_contct2" id="corpus" placeholder="" name="name"/>
							</div>
						</div>
					</div></br>
					<div class="row">
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<div class="form-group">
								<label for="sevaCombo">Seva<span style="color:#800000;">*</span></label>&emsp;&emsp;<label style="float:right;font-size: 12px;"><span style="color:#800000;" id="minAmt"></span><span style="color:#800000;" id="Sqty"></span><span style="color:#800000;" id="totMinAmt"></span></label>
								<select onChange="sevaComboChange();" id="sevaCombo" class="form-control">

								</select>

								<label for="sevaAmount" id="revDate" style="display:none;float:right;">
									<span style="color:#800000;">* <span style="font-size: 12px;" id="revRate"></span></span>
								</label>

							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<label for="periodCombo">Selection of Period<span style="color:#800000;">*</span></label>
								<select id="periodCombo" class="form-control" style="width: 185px;"><!-- onChange="periodComboChange();"-->
									<?php foreach($period as $result) { ?>
										<option value="<?=$result['SP_ID']; ?>|<?=$result['PERIOD_NAME']; ?>">
											<?=$result['PERIOD_NAME']; ?>
										</option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-1 col-md-2 col-sm-2 col-xs-12 " style="padding-right: 0px;padding-left: 30px;">
					<div class="qtyOpt form-group"  style = "margin-left: 3px; ">
						<label for="sevaQty">Quantity
							<span style="color:#800000;">*</span>
						</label>
						<br/>
						<input style="width:70px;font-size:24px;border-color:#000000;" type="text" value="1" oninput = "inputQuantity(this.value)" class="form-control form_contct2" id="sevaQty" placeholder="1" name="sevaQty">
					</div>
				</div>
				<div class= "col-lg-5 col-md-5 col-sm-12 col-xs-9"style="padding-left:75px;" >
					<div class="form-group">
						<label><input autocomplete="off" type="radio" id="hindu" name="calendar" value="Hindu" style="  margin: 0 5px 0 20px;"  onchange="calendarHindu();" checked/> Hindu</label>
						<label><input autocomplete="off" type="radio" id="gregorian" name="calendar" value="Gregorian"  style="  margin: 0 5px 0 20px;"  onchange="calendarGregorian();"/> Gregorian</label>
						<label><input autocomplete="off" type="radio" id="festivalwise" name="calendar" value="festivalwise"  style="margin: 0 5px 0 20px;"  onchange="calendarFestivalwise();"/> Festivalwise</label>
						<label><input autocomplete="off" type="radio" id="everyWeekMonth" name="calendar" value="everyWeekMonth"  style="margin: 0 5px 0 20px;"  onchange="EveryWeekMonthwise();"/> Every</label>
					</div>
				</div>
				<div class= "col-lg-5 col-md-5 col-sm-5 col-xs-12" id="HinduCal" style="padding-left:78px;" hidden>
					<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="form-group" >
							<select id="masaCode" style="height: 30px;">
								<option value="">Select Masa</option>
								<?php   if(!empty($masa)) {
									foreach($masa as $row1) { ?> 
										<option value="<?php echo $row1->MASA_CODE;?>|<?php echo $row1->MASA_NAME;?>"><?php echo $row1->MASA_NAME;?></option>
									<?php } } ?>
							</select>
						</div>
					</div>
					<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12"  onchange="moon()">
						<div class="form-group" >
							<select id="bomCode" style="height: 30px;">
								<option value="">Select SH/BH</option>
								<?php   if(!empty($moon)) {
									foreach($moon as $row2) { ?> 
										<option value="<?php echo $row2->BOM_CODE;?>|<?php echo $row2->BOM_NAME;?>"><?php echo $row2->BOM_NAME;?></option>
									<?php } } ?>
							</select>
						</div>
					</div>
					<?php $thithi = array($thithi_shudda,$thithi_bahula);?>
					<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="form-group" >
							<select id="thithiCode" style="height: 30px;">
								<option value="">Select Thithi</option>
								<?php  if(!empty($thithi[0])) { 
									foreach($thithi[0] as $row) { ?> 
										<option value="<?php echo $row->THITHI_CODE;?>|<?php echo $row->THITHI_NAME;?>"><?php echo $row->THITHI_NAME;?></option>
								<?php } } ?>
							</select>
						</div>
					</div>
					<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12" style="margin-top:-15px;">
						<div class="form-group">
							<select id="thithiCode1" style="height: 30px;display:none;">
								<option value="">Select Thithi</option>
								<?php  if(!empty($thithi[1])) { 
									foreach($thithi[1] as $row1) { ?> 
										<option value="<?php echo $row1->THITHI_CODE;?>|<?php echo $row1->THITHI_NAME;?>"><?php echo $row1->THITHI_NAME;?></option>
								<?php } } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12" id="GregorianCal" style="padding-left:10px;">
					<div class="row multiDate">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="padding-left:95px;">
							<div class="input-group input-group-sm form-group">
								<input autocomplete="off" id="multiDate" type="text" value="" class="form-control todayDate2" placeholder="dd-mm-yyyy" readonly = "readonly"/ >
								<div class="input-group-btn">
									<button class="btn btn-default todayDate" type="button">
										<i class="glyphicon glyphicon-calendar"></i>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- festival starts-->
				<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12" id="FestvalCal" style="padding-left:10px;">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="padding-left:95px;margin-left: -1em;">
						<div class="form-group" >
							<select id="festivalCode" style="height: 30px; ">
								<option value="">Select Festval Name</option>
								<?php   if(!empty($festival)) {
									foreach($festival as $row1) { ?> 
										<option value="<?php echo $row1->SFS_THITHI_CODE;?>"><?php echo $row1->SFS_NAME;?> - <?php echo $row1->SFS_THITHI_CODE;?></option>
								<?php } } ?>
							</select>
						</div>
					</div>
				</div>
				
					<div class= "col-lg-5 col-md-5 col-sm-5 col-xs-12" id="EveryWeekMonth" style="padding-left:78px;" >
					<div class= "col-lg-3 col-md-4 col-sm-4 col-xs-12" >
						<div class="form-group" >
							<select style="height: 30px;" id="weekMonth"  onchange="weekMonthChange()">
								<option value="">Select Type</option>
								<option value="Year">Year</option>
								<option value="Month">Month</option>
								<option value="Week">Week</option>
								<option value="YearHindu">Year Hindu</option>

							</select>
						</div>
					</div>
					<div class="form-group col-lg-3 col-md-6 col-sm-4 col-xs-6" id="months" style=" display: none; margin-left: 0.5em;" >
							<select id="modeOfChangeMonth" style="height: 30px;"  >
										
									<option value="">Select Month</option>	
									<option value="January">January</option>
									<option value="February">February </option>
									<option value="March">March</option>
									<option value="April">April</option>
									<option value="May">May</option>
									<option value="June">June</option>
									<option value="July">July</option>
									<option value="August">August</option>
									<option value="September">September</option>
									<option value="October">October</option>
									<option value="November">November</option>
									<option value="December">December</option>
							
							</select>
							<input type="hidden" name="month" id="month">  
						</div>
					<div class= "col-lg-2 col-md-4 col-sm-4 col-xs-12" id="First" style="margin-left: 1em;display: none;" >
						<div class="form-group" >
							<select style="height: 30px;" id="everyFivedaysval"  >
								<option value="">Select</option>
								<option value="First">First</option>
								<option value="Second">Second</option>
								<option value="Third">Third</option>
								<option value="Fourth">Fourth</option>
								<option value="Last">Last</option>
							</select>
						</div>
					</div>
				
					<div class= "col-lg-2 col-md-4 col-sm-4 col-xs-12">
						<div class="form-group">
							<select style="height: 30px;  margin-left: 0.8em;" id="selectday" >
								<option value="">Select Day</option>
								<option value="Monday">Monday</option>
								<option value="Tuesday">Tuesday</option>
								<option value="Wednesday">Wednesday</option>
								<option value="Thursday">Thursday</option>
								<option value="Friday">Friday</option>
								<option value="Saturday">Saturday</option>
								<option value="Sunday">Sunday</option>
							</select>
						</div>
					</div>
					<div class= "col-lg-2 col-md-4 col-sm-4 col-xs-12" id="Everyyearmasa" style="margin-left: 1.5em; display: none;" >
						<div class="form-group" >
							<select id="masaevery" style="height: 30px;">
								<option value="">Select Masa</option>
								<?php   if(!empty($masa)) {
									foreach($masa as $row1) { ?> 
										<option value="<?php echo $row1->MASA_CODE;?>|<?php echo $row1->MASA_NAME;?>"><?php echo $row1->MASA_NAME;?></option>
									<?php } } ?>
							</select>
						</div>
					</div>
				</div>
			
				<form action="<?php echo base_url();?>/Shashwath/addMember" method="post" id="code">
					<input autocomplete="off" type="hidden" id="thithi" name="thithi" value=""/>
					<input autocomplete="off" type="hidden" id="masa" name="masa" value=""/>
					<input autocomplete="off" type="hidden" id="moon" name="moon" value=""/>
				</form>
				<div class=" row col-lg-6 col-md-6 col-sm-7 col-xs-12" style="padding-top:0px;margin-left:0px;">
					<div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12" style = "margin-left: 0px;margin-top: 43px;" id="postageId">
						<label><input autocomplete="off" style="margin-right: 6px; font-size:80px;" class="amt" onClick="hidePostageAmt(this);" type="checkbox" name="postage" id="postage" value="1">Postage</label>
					</div>
					<div class="form-group col-lg-9 col-md-6 col-sm-6 " style="padding-left: 25px;">
						<label for="comment">Purpose : </label>
						<textarea class="form-control" rows="3" style="resize:none;" onkeyup="alphaonlypurpose(this)" id="sevaNotes" placeholder = "Seva Note"></textarea>
					</div>
				</div>
			
			</div>
			
		</div>
		<div>
			<div style="clear:both;margin-top:0px;" class="container">
				<div class="row form-group">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="row form-group">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  ">
								<div style="clear:both;padding-right:30px;" class="form-group">
									<div class="radio">
										<a class="hideAdd" onClick="addRow()">
											<img style="width:24px; height:24px" class="img-responsive pull-right" title="Add Seva" src="<?=site_url();?>images/add.svg"/>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-left:0px;">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive">
								<table id="eventSeva" class="table table-bordered">
									<thead>
										<tr>
											<th>Sl. No.</th>
											<th>Deity Name.</th>
											<th>Seva Name</th>
											<th>Qty</th>
											<th>Corpus</th>
											<th>Date</th>
											<th>Thithi</th>
											<th>Week/Month/Year</th>
											<th>Period</th>
											<th>Purpose</th>
											<th>Postage</th>	
											<th>Postal Address</th>	
											<th style="width:50px;">Remove</th>
										</tr>
									</thead>
									<tbody id="eventUpdate">
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="container">
				
				<div class="col-lg-12 col-md-12 col-sm-12" style="padding-top:0px;margin-left:0px;">
					<div class="form-group col-lg-2 col-md-4 col-sm-7 " style = "margin-top: 10px;margin-left:-15px">
						<label><input autocomplete="off" style="margin-right: 10px; font-size:80px;" class="amt" onClick="hideReciptEntry(this);" type="checkbox" name="manualreceipt" id="manualreceipt" value="1" checked="checked" hidden >Reciept Book Details:</label>
					</div>
					<div class="form-group col-lg-2 col-md-3 col-sm-4">
						<input autocomplete="none" type="text" class="form-control form_contct2" id="receiptLine1" placeholder="Book Receipt No" name="receiptLine1"  />
					</div>
					<div  class="input-group input-group-sm form-group col-lg-2 col-md-3 col-sm-4">	
						<input autocomplete="none" type="text" class="form-control receiptLine2 hasDatePicker" placeholder="dd-mm-yyyy" id="receiptLine2" name="receiptLine2" />
						<div class="input-group-btn">
							<button class="btn btn-default receiptLine2" id="receiptLine3" name="receiptLine3" type="button" >
								<i class="glyphicon glyphicon-calendar"></i>
							</button>
						</div>
					</div>							
				</div> 
				<div class="row form-group">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-8"style="margin-top:25px;">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:0px;">
								<input autocomplete="none" type="text" class="form-control form_contct2" id="addLine1" placeholder="Address Line1" name="addLine1" onkeyup="alphaonlyAdrs(this)" disabled /><br>
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:0px;">
								<input autocomplete="none" type="text" class="form-control form_contct2" id="addLine2" placeholder="Address Line2" name="addLine2" onkeyup="alphaonlyAdrs(this)" disabled /><br>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding:0px;">
								<input autocomplete="none" type="text" class="form-control form_contct2" id="city" placeholder="City" name="city" disabled /><br>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding-left:5px;padding-right:5px;">
								<input autocomplete="none" type="text" class="form-control form_contct2" id="state" placeholder="State" name="state" disabled /><br>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding-left:5px;padding-right:5px;">
								<input autocomplete="none" type="text" class="form-control form_contct2" id="country" placeholder="Country" name="country" disabled /><br>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding:0px;">
								<input autocomplete="none" type="text" class="form-control form_contct2" id="pincode" placeholder="Pincode" name="pincode" disabled /><br>
							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label for="modeOfPayment">Mode Of Payment:
									<span style="color:#800000;">*</span>
								</label>
								<select id="modeOfPayment" class="form-control">
									<option value="">Select Payment Mode</option>
									<option value="Cash">Cash</option>
									<option value="Cheque">Cheque</option>
									<option value="Direct Credit">Direct Credit</option>
									<option value="Credit / Debit Card">Credit / Debit Card</option>
									<?php if(isset($_SESSION['Authorise'])){ ?>	
										<option value="Transfer">Adjustment</option>
									<?php } ?>
								</select>
							</div>
							<div style="padding-top: 15px; display:none;margin-left: -14px;" id="showChequeList">
								<div class="form-group col-xs-10">
									<label for="name">Cheque No:
										<span style="color:#800000;">*</span>
									</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input autocomplete="off" type="text" class="form-control form_contct2" id="chequeNo" placeholder="" name="chequeNo">
								</div>

								<div style="padding-top: 15px;" class="form-group col-xs-10">
									<label for="rashi">Cheque Date:
										<span style="color:#800000;">*</span>
									</label>&nbsp;&nbsp;
									<div class="input-group input-group-sm  col-xs-4">
										<input autocomplete="off" id="chequeDate" type="text" value="" class="form-control chequeDate2 form_contct2" placeholder="dd-mm-yyyy">
										<div class="input-group-btn">
											<button class="btn btn-default chequeDate" type="button">
												<i class="glyphicon glyphicon-calendar"></i>
											</button>
										</div>
									</div>
								</div>

								<div style="padding-top: 15px;" class="form-group col-xs-12">
									<label for="number">Bank Name:
										<span style="color:#800000;">*</span>
									</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input autocomplete="off" type="text" class="form-control form_contct2" id="bank" placeholder="" name="bank">
								</div>

								<div style="padding-top: 15px;" class="form-group col-xs-12">
									<label for="nakshatra">Branch Name:
										<span style="color:#800000;">*</span>
									</label>&nbsp;&nbsp;
									<input autocomplete="off" type="text"  class="form-control form_contct2" id="branch" placeholder="" name="branch">
								</div>
							</div>
							
							<div style="padding-top: 15px; display:none;margin-left: -14px;" id="showDebitCredit">
								<div class="form-group col-xs-10">
									<label for="bank">To Bank <span style="color:#800000;">*</span></label>&nbsp;&nbsp;
									<select id="DCtobank" name="DCtobank" class="form-control">
										<option value="0">Select Bank</option>
										<?php foreach($terminal as $result) { ?>
											<option value="<?=$result->FGLH_ID; ?>">
												<?=$result->FGLH_NAME; ?>
											</option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group col-xs-10">
									<label for="name">Transaction Id:
										<span style="color:#800000;">*</span>
									</label>&nbsp;&nbsp;
									<input type="text" class="form-control form_contct2" id="transactionId" placeholder="" name="transactionId">
								</div>
							</div>
							
							<div style="padding-top: 15px; display:none;margin-left: -14px;" id="showDirectCredit">
								<div class="form-group col-xs-10">
									<label for="bank">To Bank <span style="color:#800000;">*</span></label>&nbsp;&nbsp;
									<select id="tobank" name="tobank" class="form-control">
										<option value="0">Select Bank</option>
										<?php foreach($bank as $result) { ?>
											<option value="<?=$result->FGLH_ID; ?>">
												<?=$result->FGLH_NAME; ?>
											</option>
										<?php } ?>
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<label for="comment">Payment Notes: </label>
								<textarea class="form-control" rows="5" style="resize:none;" id="paymentNotes"></textarea>
							</div>
							<div class="row form-group">
								<div class="control-group col-md-12 col-lg-12 col-sm-12 col-xs-12">
									<label class="control-label" style="color:#800000;font-size: 12px;">
										<i>* Indicates mandatory fields.</i>
									</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row form-group" id="showtransfer" style="display: none; margin-left: 3em;" >
					<form id="frmReceipt" action="<?=site_url()?>finance/addReceiptTrans" method="post" enctype="multipart/form-data" accept-charset="utf-8">
            			<div class="row form-group">
                			<div class="control-group col-md-12 col-lg-10 col-sm-12 col-xs-6">
                    			<hr style="border-top:1px solid #800000; width: 780px; margin-left: -11px; margin-bottom: 3px;">
                   				<div class="control-group col-md-12 col-lg-2 col-sm-12 col-xs-6">
                    			</div>
			                    <div class="control-group col-md-12 col-lg-4 col-sm-12 col-xs-6">
			                        <label for="comment">Ledger </label>
			                    </div>
			                    <div class="control-group col-md-12 col-lg-2 col-sm-12 col-xs-6 text-center">
			                        <label for="comment">Debit </label>
			                    </div>
				              
                    			<hr style="border-top:1px solid #800000; width:780px; margin-left: -12px;" />
                			</div>
            			</div>
            			<div class="row form-group" style="margin-top: -35px;">
                			<div class="control-group col-md-12 col-lg-8 col-sm-12 col-xs-6" id="addNewDiv">
                   		 		<div id="idChildContactDiv_1" class ="row">
                        			<div class="control-group col-lg-2 col-md-3 col-sm-3 col-xs-3"  >
			                            <select id="type_1" name="type" class="form-control label_size" disabled style="-webkit-appearance: none;-moz-appearance: none;text-indent: 1px;text-overflow: '';">
			                                <option value="from">FROM</option>
			                            </select>
                        			</div>
                        			<div class="control-group col-lg- col-md-6 col-sm-4 col-xs-4">
                           		 		<select id="ledger_1" class="form-control ledger" name="ledger" style="width:100%" onChange="getLedgerChange(id)">
                                			<option value="">Select Ledger</option>
                               					<?php   if(!empty($ledger)) {
                                    				foreach($ledger as $row1) { ?> 
                                        				<option value="<?php echo $row1->FGLH_ID;?>|<?php echo $row1->BALANCE;?>|<?php echo $row1->FGLH_NAME;?>"><?php echo $row1->FGLH_NAME;?></option>
                                    			<?php } } ?>
                                		</select>
		                                <label for="curBal_1" value="">Cur Bal:
		                                    <span id="curBal_1"></span>
		                                </label>
                            		</div>
		                            <div class="control-group col-lg-2 col-md-2 col-sm-4 col-xs-4 right">
		                                <input type="text" class="form-control amounts text-right dec" name="number" id="debit_1" autocomplete="off" style="width:100%" onkeyup="getCheckedEditedFields(id)" onkeypress="return validateFloatKeyPress(this,event);" />
		                            </div>
		                        
		                            <div class="control-group col-lg-1 col-md-1 col-sm-1 col-xs-1"> 
		                                <a style="text-decoration:none;cursor:pointer;" class="add" id="add_1" onclick="getFinalData()"><img style="width:24px;height:24px" title="Additional Contact Number" src="<?=site_url();?>images/add_icon.svg"/></a>
		                            </div>
                        		</div>
                    		</div>
                		</div>
		                <div class="row form-group " style="margin-top: -30px;">
		                    <div class="control-group col-md-12 col-lg-8 col-sm-12 col-xs-6" >
		                        <hr style="border-top:1px solid #800000;width: 215px; margin-left: 33em; margin-bottom: 3px;" />	            
		                        <div class="control-group col-lg-6 col-md-6 col-sm-3 col-xs-3">
		                        </div>
		                        <div class="control-group col-lg-4 col-md-2 col-sm-12 col-xs-6">              		               
		                            <input type="text" id="debitTot" disabled class="text-right" name="" style="width:100% ;background: transparent; border:none;"> 
		                        </div>		                 
		                    </div>
		                </div>
                		<hr style="border-top:1px solid #800000;width: 215px; margin-left: 33em; margin-top: -10px;" /> 
		                <div class="row form-group" style="margin-top: -20px;">
		                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		                        <div class="form-group">
		                            <label for="comment">Narration </label>
		                            <textarea class="form-control" rows="5" name="naration" onkeyup="alphaonlypurpose(this)" id="naration" placeholder="" style="width:67%;height:100%;resize:none;"></textarea>
		                        </div>
		                    </div>
		                </div>         
            		</form>
				</div>
			</div>
			
			<div class="modal fade bs-example-modal-lg"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Shashwath Seva Preview</h4>
						</div>
						<div class="modal-body" id="creditdet" style="overflow-y: auto;max-height: 80vmin;">

						</div>
						<div class="modal-footer text-left" style="text-align:left;">
							<label>Are you sure you want to save..?</label>
							<br/>
							<button style="width: 8%;" type="button" class="btn btn-default sevaButton" id="submit">Yes</button>
							<button style="width: 8%;" type="button" class="btn btn-default sevaButton" data-dismiss="modal">No</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<input autocomplete="off" type="hidden" id="radioOpt" value="multiDateRadio" />   
		<div class="container">
			<center>
				<button type="button" onClick="validateSubmit();" class="btn btn-default btn-lg">
					<span class="glyphicon glyphicon-print"></span> Submit & Print</button>
			</center>
		</div>
	</div>
	<div id="2" class="w5-container city"  hidden>
		<div id="mandaliMembId" style="display: none;">
		<div class="container">
			<div class="row form-group">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="col-lg-4  col-md-5 col-sm-6 col-xs-6">
						<span class="eventsFont2 samFont1"></span>
					</div>
				</div>
			</div>	
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="display:none;margin-bottom: 1.5em;">
				<div class="form-inline">
					<label for="number">Address </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<textarea class="form-control" rows="5" id="address" name="address" placeholder="Near Classic Chaya, Santhakatte" style="width: 100%;"></textarea>
				</div>
			</div>
			<div class= "col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class= "col-lg-12 col-md-6 col-sm-12 col-xs-9">
					<div class="form-group" >
						<label for="name">Name<span style="color:#800000;">*</span></label>
						<input autocomplete="none" type="text" class="form-control form_contct2" id="mandalimemname" onkeyup="alphaonly(this)" placeholder="" name="mandalimemname" />
					</div>
				</div>
				<div class= "col-lg-6 col-md-6 col-sm-12 col-xs-9" style="padding-top:25px;">
					<div class="form-group">
						<label for="number">Number<span style="color:#800000;">*</span></label>
						<input autocomplete="off" type="text" class="form-control form_contct2" id="mandalimemphone" placeholder="" name="mandalimemphone" >
					</div>
				</div>
				<div class= "col-lg-6 col-md-6 col-sm-12 col-xs-9" style="padding-top:25px;">
					<div class="form-group">
						<label for="number">Additional Number</label>
						<input autocomplete="off" type="text" class="form-control form_contct2" id="mandalimemphone2"  placeholder="" name="mandalimemphone2" >
					</div>
				</div>
				<div class= "col-lg-6 col-md-6 col-sm-12 col-xs-9" style="padding-top:25px;">
					<div class="form-group">
						<label for="rashi">Rashi</label>
						<input autocomplete="off" type="hidden" id="baseurl" name="baseurl" value="<?php echo site_url(); ?>" />
						<div class="dropdown">
							<input autocomplete="off" type="text" class="form-control form_contct2" id="mandalimemrashi" onkeyup="alphaonly(this)" placeholder="" name="mandalimemrashi">
							<ul class="dropdown-menu txtpin" style="margin-left:0px;margin-right:0px;max-height:400px;" role="menu" aria-labelledby="dropdownMenu"  id="DropdownRashi">
							</ul>
						</div>
					</div>
				</div>
				<div class= "col-lg-6 col-md-6 col-sm-12 col-xs-9" style="padding-top:25px;">
					<div class="form-group">
						<label for="nakshatra">Nakshatra </label>
						<input autocomplete="off" type="hidden" id="baseurl" name="baseurl" value="<?php echo site_url(); ?>" />
						<div class="dropdown">
							<input autocomplete="off" type="text" class="form-control form_contct2" id="mandalimemnakshatra" onkeyup="alphaonly(this)" placeholder="" name="mandalimemnakshatra">
							<ul class="dropdown-menu txtpin1" style="margin-left:0px;margin-right:0px;max-height:400px;" role="menu" aria-labelledby="dropdownMenu"  id="Dropdownnakshatra">
							</ul>
						</div>
					</div>
				</div>
				<div class= "col-lg-12 col-md-6 col-sm-12 col-xs-9" style="padding-top:20px;">
					<div class="form-group">
						<label for="gotra">Gotra </label>
						<input autocomplete="off" type="hidden" id="baseurl" name="baseurl" value="<?php echo site_url(); ?>" />
						<div class="dropdown">
							<input autocomplete="off" type="text" class="form-control form_contct2" id="mandalimemGotra" onkeyup="alphaonly(this)" placeholder="" name="mandalimemGotra">
							<ul class="dropdown-menu txtpin1" style="margin-left:0px;margin-right:0px;max-height:400px;" role="menu" aria-labelledby="dropdownMenu"  id="Dropdowngotra">
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class= "col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
					<div class="form-inline">
						<label>Postage</label>  
			            <input type="checkbox" id="ispostage" name="ispostage" class="ispostage" /> 
					</div>
				</div>
				<div class= "col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="form-group">
						<label for="name">Address<span style="color:#800000;">*</span></label>
						<input autocomplete="none" type="text" class="form-control form_contct2" id="mandalimemaddLine1" placeholder="Address Line1" onkeyup="alphaonlypurpose(this)" name="name"/>
					</div>
				</div>
				<div class= "col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="form-group">
						<input autocomplete="none" type="text" class="form-control form_contct2" id="mandalimemaddLine2" placeholder="Address Line2" onkeyup="alphaonlypurpose(this)" name="name"/>
					</div>
				</div>
				<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="form-group">
						<input autocomplete="none" type="text" class="form-control form_contct2" id="mandalimemcity" onkeyup="alphaonly(this)" placeholder="City" name="name"/>
					</div>
				</div>
				<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="form-group">
						<input autocomplete="none" type="text" class="form-control form_contct2" id="mandalimemstate" onkeyup="alphaonly(this)" placeholder="State" name="name"/>
					</div>
				</div>
				<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="form-group">
						<input autocomplete="none" type="text" class="form-control form_contct2" id="mandalimemcountry" onkeyup="alphaonly(this)" placeholder="Country" name="name"/>
					</div>
				</div>
				<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="form-group">
						<input autocomplete="none" type="text" class="form-control form_contct2" id="mandalimempincode" oninput="inputPincode(this.value)" placeholder="Pincode" name="name"/></br>
					</div>
				</div>
				
			</div>
			<div class= "col-lg-6 col-md-6 col-sm-6 col-xs-12" style="padding-left:30px;">
				<label for="comment">Remarks: </label>
				<textarea class="form-control" rows="5" style="resize:none;" onkeyup="alphaonlypurpose(this)" id="mandalimemsmremarks"></textarea>
			</div>	
		</div>
		<div style="clear:both;margin-top:0px;" class="container">
			<div class="row form-group">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="row form-group">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  ">
							<div style="clear:both;padding-right:30px;" class="form-group">
								<div class="radio">
									<a class="hideAdd" onClick="addRow1()">
										<img style="width:24px; height:24px" class="img-responsive pull-right" title="Add Seva" src="<?=site_url();?>images/add.svg"/>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-left:0px;">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="table-responsive">
							<table id="eventSeva1" class="table table-bordered">
								<thead>
									<tr>
										<th>Sl. No.</th>
										<th>Name.</th>
										<th>Phone</th>
										<th>Rashi</th>
										<th>Nakshatra</th>
										<th>Gotra</th>
										<th>Address</th>
										
										<th>Remarks</th>
										<th>Postage</th>
										<th style="width:50px;">Remove</th>
									</tr>
								</thead>
								<tbody id="eventUpdate">
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:80px;">
					<div class="container-fluid">
						<center>
							<button type="button" onclick = "goToTabShashwathSevaDetails();" class="btn btn-default btn-lg">
								Next  <span class="glyphicon glyphicon-forward"></span></button>
						</center>
					</div>
				</div>
			</div>
		</div>
		<div>
		</div>
		<input autocomplete="off" type="hidden" id="radioOpt" value="multiDateRadio" />   		
	</div>
	</div>
</div>
</div>
 
<script src="<?=site_url()?>js/autoComplete.js"></script>
<script>
	var tempQty;
	function inputQuantity(qtyValue) { 
		if (isNaN(qtyValue)){
			document.getElementById('sevaQty').value = '';
		} else if(document.getElementById('sevaQty').value == 0) { 
			document.getElementById('sevaQty').value = '';
		} else if(qtyValue < 51){
			tempQty = qtyValue;
		} else {
			$('#sevaQty').val(tempQty);
			console.log(tempQty);
			alert("Information","Quantity cannot exceed 50","OK");
		}
		let sevaCombo = getSevaCombo();
		$('#Sqty').html(" X " + $('#sevaQty').val() + " = ");
		$('#totMinAmt').html(sevaCombo.shashPrice * $('#sevaQty').val());
	}
	function moon() {
		var m = document.getElementById("bomCode").value.split("|");
		if(m[0] == 'BH') {
			document.getElementById("thithiCode1").style.display ="block";
			document.getElementById("thithiCode").style.display ="none";
		} else {
			document.getElementById("thithiCode1").style.display ="none";
			document.getElementById("thithiCode").style.display ="block";
		}
	}

	// function weekMonthChange(){
	// 	if(document.getElementById("weekMonth").value == "Month") {
	// 		document.getElementById("First").style.display ="block";
	// 	}else{
	// 		document.getElementById("First").style.display ="none";
	// 	}

	// }


	function weekMonthChange(){
		if(document.getElementById("weekMonth").value == "Month") {
			document.getElementById("First").style.display ="block";
			document.getElementById("months").style.display ="none";
			document.getElementById("Everyyearmasa").style.display ="none";

		}else{
			document.getElementById("First").style.display ="none";
			document.getElementById("months").style.display ="none";
			document.getElementById("Everyyearmasa").style.display ="none";


		}

		if(document.getElementById("weekMonth").value =='Year'){
				document.getElementById("First").style.display ="block";
				document.getElementById("weekMonth").style.display ="block";
				document.getElementById("months").style.display ="block";
				document.getElementById("Everyyearmasa").style.display ="none";


		}
			if(document.getElementById("weekMonth").value =='YearHindu'){
			document.getElementById("Everyyearmasa").style.display ="block";
			document.getElementById("First").style.display ="block";
			document.getElementById("weekMonth").style.display ="block";
			document.getElementById("months").style.display ="none";
				

		}
	}


	$('#weekMonth').change(function(){
     $('#First option:first').prop('selected', 'selected');
     $('#selectday option:first').prop('selected', 'selected');
     $('#modeOfChangeMonth option:first').prop('selected', 'selected');
       $('#masaevery option:first').prop('selected', 'selected');
});

	function alphaonly(input) {
		var regex=/[^a-z& ]/gi;
		input.value=input.value.replace(regex,"");
	}

	function alphaonlypurpose(input) {
		var regex=/[^-a-z-0-9 ]/gi;
		input.value=input.value.replace(regex,"");
	}

	function alphaonlyaddress(input) {
		var regex=/[^-a-z-0-9-/()., ]/gi;
		input.value=input.value.replace(regex,"");
	}

	function alphaonlyAdrs(input) {
		var regex=/[^-a-z-0-9.,()/ ]/gi;
		input.value=input.value.replace(regex,"");
	}

	document.getElementById('1').style.display = "block";
	$("#40").addClass("w5-border-red");

	//INPUT KEYPRESS
	$(':input').on('keypress change', function() {
		var id = this.id;
		try {$('#' + id).css('border-color', "#000000");}catch(e) {}
		
	});

	function hidePostageAmt(ths) {	
		if(ths.checked) {
			$("#addLine1").attr("disabled", false);
			$("#addLine2").attr("disabled", false);
			$("#city").attr("disabled", false);
			$("#state").attr("disabled", false);
			$("#country").attr("disabled", false);
			$("#pincode").attr("disabled", false);
			
		
		} else {
			$("#addLine1").attr("disabled", true);
			$("#addLine2").attr("disabled", true);
			$("#city").attr("disabled", true);
			$("#state").attr("disabled", true);
			$("#country").attr("disabled", true);
			$("#pincode").attr("disabled", true);

		}
	}

	
	function GetDataOnDate(receiptDate,url) {
		document.getElementById('date').value = receiptDate;
		document.getElementById('load').value = "DateChange";

		$("#dateChange").attr("action",url)
		$("#dateChange").submit();
	}

	var arr = arr || {};
	var bgNo = 1;
	var everySelectedOption = "Day";
	var between = [];
	var seva_date = "";
	var date_type = "";

	$('#multiDateRadio').click();

	function inputPincode(pinValue) { 
		if (isNaN(pinValue)){
			document.getElementById('smpin').value = '';
			document.getElementById('mandalimempincode').value = '';
			document.getElementById('mandliPin').value = '';
		}
		$('#smpin').prop('maxlength',6);
		$('#mandalimempincode').prop('maxlength',6);
		$('#mandliPin').prop('maxlength',6);	
	}
	
	$('#modeOfPayment').on('change', function () {							//laz
		if (this.value == "Cheque") {
			$('#showChequeList').fadeIn("slow");
			$('#showDebitCredit').fadeOut("slow");
			$('#showDirectCredit').fadeOut("slow");
				$('#showtransfer').fadeOut("slow");
		}
		else if (this.value == "Credit / Debit Card") {
			$('#showChequeList').fadeOut("slow");
			$('#showDebitCredit').fadeIn("slow");
			$('#showDirectCredit').fadeOut("slow");
				$('#showtransfer').fadeOut("slow");

		} 
		else if (this.value == "Direct Credit") {				
			$('#showChequeList').fadeOut("slow");
			$('#showDebitCredit').fadeOut("slow");
			$('#showDirectCredit').fadeIn("slow");
				$('#showtransfer').fadeOut("slow");
		}
		else if (this.value == "Transfer") {
			$('#showtransfer').fadeIn("slow");
			$('#showChequeList').fadeOut("slow");
			$('#showDebitCredit').fadeOut("slow");
			$('#showDirectCredit').fadeOut("slow");
		}														
		else {
			$('#showtransfer').fadeOut("slow");
			$('#showChequeList').fadeOut("slow");
			$('#showDebitCredit').fadeOut("slow");
			$('#showDirectCredit').fadeOut("slow");
		}

	});																	//laz..
	
	function resetDates() {
		if(($('#multiDate').val()).trim().length == 0) {
			$('#multiDate').multiDatesPicker('resetDates');
			$('#multiDate').trigger("click")
		}
	}

	$('#submit').on('click', function () {
		let count = 0;
		let number = $('#phone').val();
		let number2 = $('#phone2').val();
		let name = $('#name').val().trim();
		let rashi = $('#rashi').val();
		let pan = $('#pan').val();
		let adhaar = $('#adhaar').val();
		let gotra = $('#gotra').val().trim();
		let nakshatra = $('#nakshatra').val();
		let paymentNotes = $('#paymentNotes').val().trim();
		let chequeNo = "";
		let bank = "";
		let chequeDate = "";
		let branch = "";
		let fglhBank = "";														//laz new
		let tableContent = getTableValues();
		let modeOfPayment = $('#modeOfPayment option:selected').val();
		let toBank = $('#tobank option:selected').val();						//laz
		let DCtoBank = $('#DCtobank option:selected').val();					//laz new
		let transactionId = $('#transactionId').val();
		let addrline1 = $('#addrline1').val().trim();
		let addrline2 = $('#addrline2').val().trim();
		let smcity = $('#smcity').val().trim();
		let smstate = $('#smstate').val().trim();
		let smcountry = $('#smcountry').val().trim();
		let smpin = $('#smpin').val();
		let smremarks = $('#smremarks').val().trim();
		let sevaNotes = $('#sevaNotes').val().trim();                          
		let sevaType = "";
		let sevaCombo = $('#sevaCombo option:selected').val();
		sevaCombo = sevaCombo.split("|");
		if(sevaCombo[10] == "Occasional"){
			sevaType = "Occasional";
		}else{
			sevaType = "Regular";		
		} 
		let mandaliName =  $('#mandaliName').val().trim();
		let mandaliPhone = $('#mandaliPhone').val();
		let mandliPhone2 = $('#mandliPhone2').val();
		let mandliRemarks = $('#mandliRemarks').val().trim();
		let mandliAddrline1 = $('#mandliAddrline1').val().trim();
		let mandliAddrline2 = $('#mandliAddrline2').val().trim();
		let mandlicity = $('#mandlicity').val().trim();
		let mandliState = $('#mandliState').val().trim();
		let mandliCountry = $('#mandliCountry').val().trim();
		let mandliPin = $('#mandliPin').val();
		let mandaliAddress = "";
		let periodCombo = document.getElementById("periodCombo").value.split("|");
		if(($('#ismandali').prop('checked')) == false){
			$('#ismandali').attr("value", "NO");
		} else {
			$('#ismandali').attr("value", "YES");
		} 
		var ismandali = $('#ismandali').val(); 

		if(ismandali == 'NO'){	
			if (modeOfPayment == "Cheque") {
				chequeNo = $('#chequeNo').val();
				chequeDate = $('#chequeDate').val();
				bank = $('#bank').val().trim();
				branch = $('#branch').val().trim();

				if (chequeNo.length == 6) {
					$('#chequeNo').css('border-color', "#800000");
				} else {
					$('#chequeNo').css('border-color', "#FF0000");
					++count;
				}

				if (chequeDate) {
					$('#chequeDate').css('border-color', "#800000");
				} else {
					$('#chequeDate').css('border-color', "#FF0000");
					++count;
				}

				if (bank) {
					$('#bank').css('border-color', "#800000");
				} else {
					$('#bank').css('border-color', "#FF0000");
					++count;
				}

				if (branch) {
					$('#branch').css('border-color', "#800000");
				} else {
					$('#branch').css('border-color', "#FF0000");
					++count;
				}
			} else if (modeOfPayment == "Credit / Debit Card") {								//laz new
				fglhBank = $('#DCtobank').val();
				if (DCtoBank != 0) {
					$('#DCtobank').css('border-color', "#800000");
				} else {
					$('#DCtobank').css('border-color', "#FF0000");
					++count;
				}
				if (transactionId) {
					$('#transactionId').css('border-color', "#800000");
				} else {
					$('#transactionId').css('border-color', "#FF0000");
					++count;
				}																				//laz new..
			} else if (modeOfPayment == "Direct Credit") {										//laz new
				fglhBank = $('#tobank').val();
				if (toBank) {
					$('#tobank').css('border-color', "#800000");
				} else {
					$('#tobank').css('border-color', "#FF0000");
					++count;
				}																				//laz new..
			}																				
			else {
				$('#chequeNo').css('border-color', "#800000");
				$('#branch').css('border-color', "#800000");
				$('#bank').css('border-color', "#800000");
				$('#chequeDate').css('border-color', "#800000");
			}

			if (name) {
				$('#name').css('border-color', "#ccc")

			} else {
				$('#name').css('border-color', "#FF0000")
				++count;
			}
			if (number) {
				$('#phone').css('border-color', "#ccc")

			} else {
				$('#phone').css('border-color', "#FF0000")
				++count;
			}

			if (count != 0) {
				alert("Information", "Please fill required fields", "OK");
				return false;
			} 
		}
		let masa1 = [];
		let bomcode1 = [];
		let thithiName1 = [];
		let sevaName = [];
		let corpus = [];
		let purpose=[];
		let date = [];
		let dateMonth1=[];
		let price = [];
		let thithi = [];
		let amt = [];
		let sevaId = [];
		let sevaQty = [];
		let userId = [];
		let quantityChecker = [];
		let deityId = [];
		let deityName = [];
		let isSeva = [];
		let revFlag = [];
		let address = [];
		let addressLine1 = [];
		let addressLine2 = [];
		let city = [];
		let state = [];
		let country = [];
		let pincode = [];
		let postage = [];
		let calType1=[];
		let periodId = [];
		let everyweekMonth = [];
		let memmanname = "";
		let memmannumber = "";
		let memmannumber2= "";
		let memmancity = "";
		let memmanstate = "";
		let memmancountry = "";
		let memmanpin = "";
		let memmanremarks = "";
		let memmanismandli = "";
		let memmanaddr1 = "";
		let memmanaddr2 = "";

		if(($('#ismandali').prop('checked')) == false){
			memmanname = name;
			memmannumber = number;
		    memmannumber2= number2;
		    memmancity = smcity;
	        memmanstate = smstate;
		    memmancountry = smcountry;
		    memmanpin = smpin;
		    memmanremarks = smremarks;
		    memmanismandli = 0;
		    memmanaddr1 = addrline1;
		    memmanaddr2 = addrline2;
		} else {
			memmanname = mandaliName;
			memmannumber = mandaliPhone;
		    memmannumber2= mandliPhone2;
		    memmancity =  mandlicity;
	        memmanstate = mandliState;
		    memmancountry = mandliCountry;
		    memmanpin = mandliPin;
		    memmanremarks = mandliRemarks;
		    memmanismandli = 1;
		    memmanaddr1 = mandliAddrline1;
		    memmanaddr2 = mandliAddrline2;
		} 
        let type = [];
	    let ledgers = [];
	    let amount = [];
	    let ledgerName =[];
	    let toLedgerName="";
	    let j=0,pos=0,getLedg=0,dispType="";
	    let countNoJ = $('#countNoJ').val();
	    let naration = $('#naration').val();
		let corpustot=0;
		for (i = 0; i < tableContent['corpus'].length; ++i) {
			corpustot += parseInt(tableContent['corpus'][i].innerHTML);
		}
    	let total = 1;
		let url = "<?=site_url()?>Receipt/generateShashwathReceipt";

		$('.ledger').each(function(i, ele) {
            pos = ele.id.split('_')[1];
            type[j]= $('#type_'+pos).val()
            getLedg = $('#ledger_'+pos).val().split("|");

            ledgers[j]= getLedg[0];
            ledgerName[j]= getLedg[2];

            if(type[j]=="from") {
                amount[j]= $('#debit_'+pos).val()
            }else{
                amount[j]= $('#credit_'+pos).val()
            }
            j++;
        });
		
		for (let i = 0; i < tableContent['sevaName'].length; ++i) {
			sevaName[i] = tableContent['sevaName'][i].innerHTML.trim();
			isSeva[i] = tableContent['isSeva'][i].innerHTML.trim();
			deityName[i] = tableContent['deityName'][i].innerHTML.trim();
			purpose[i] = tableContent['purpose'][i].innerHTML.trim();
			corpus[i] = tableContent['corpus'][i].innerHTML.trim();
			date[i] = tableContent['date'][i].innerHTML.trim();
			dateMonth1[i] = tableContent['dateMonth1'][i].innerHTML.trim();
			price[i] = tableContent['price'][i].innerHTML.trim();
			amt[i] = tableContent['amt'][i].innerHTML.trim();
			sevaId[i] = tableContent['sevaId'][i].innerHTML.trim();
			sevaQty[i] = tableContent['sevaQty'][i].innerHTML.trim();
			userId[i] = tableContent['userId'][i].innerHTML.trim();
			quantityChecker[i] = tableContent['quantityChecker'][i].innerHTML.trim();
			deityId[i] = tableContent['deityId'][i].innerHTML.trim();
			revFlag[i] = tableContent['revFlag'][i].innerHTML.trim();
			thithi[i] = tableContent['thithi'][i].innerHTML.trim();
			masa1[i] = tableContent['masa1'][i].innerHTML.trim();
			bomcode1[i] = tableContent['bomcode1'][i].innerHTML.trim();
			thithiName1[i] = tableContent['thithiName1'][i].innerHTML.trim();
			addressLine1[i] = tableContent['addressLine1'][i].innerHTML.trim();
			addressLine2[i] = tableContent['addressLine2'][i].innerHTML.trim();
			city[i] = tableContent['city'][i].innerHTML.trim();
			state[i] = tableContent['state'][i].innerHTML.trim();
			country[i] = tableContent['country'][i].innerHTML.trim();
			pincode[i] = tableContent['pincode'][i].innerHTML.trim();
			postage[i] = tableContent['postage'][i].innerHTML.trim();
			address[i] = tableContent['address'][i].innerHTML.trim();
			calType1[i] = tableContent['calType1'][i].innerHTML.trim();
			periodId[i] = tableContent['periodId'][i].innerHTML.trim();
			everyweekMonth[i] = tableContent['everyweekMonth'][i].innerHTML.trim();
		}
		
		$.post(url, {'transactionId': transactionId, 'pan':pan,'adhaar':adhaar, 'chequeNo': chequeNo, 'branch': branch, 'bank': bank, 'chequeDate': chequeDate, 'modeOfPayment': modeOfPayment, 'sevaName': JSON.stringify(sevaName),'sevaQty': JSON.stringify(sevaQty), 'deityName': JSON.stringify(deityName), 'corpus': JSON.stringify(corpus),'thithi': JSON.stringify(thithi),'purpose':JSON.stringify(purpose),'date': JSON.stringify(dateMonth1),'sevaId': JSON.stringify(sevaId), 'userId': JSON.stringify(userId), 'quantityChecker': JSON.stringify(quantityChecker), 'revFlag': JSON.stringify(revFlag), 'deityId': JSON.stringify(deityId), 'isSeva': JSON.stringify(isSeva),'masa1':JSON.stringify(masa1),'bomcode1':JSON.stringify(bomcode1),'thithiName1':JSON.stringify(thithiName1), 'memmanname': memmanname, 'memmannumber': memmannumber, 'memmannumber2': memmannumber2, 'rashi': rashi,'gotra': gotra, 'nakshatra': nakshatra, 'paymentNotes': paymentNotes, 'date_type': date_type, 'postage': JSON.stringify(postage), 'addressLine1': JSON.stringify(addressLine1), 'addressLine2': JSON.stringify(addressLine2), 'city': JSON.stringify(city),'state':JSON.stringify(state), 'country': JSON.stringify(country), 'pincode': JSON.stringify(pincode),'address':JSON.stringify(address),'memmanaddr1':memmanaddr1,'memmanaddr2':memmanaddr2,'memmancity':memmancity,'memmanstate':memmanstate,'memmancountry':memmancountry,'memmanpin':memmanpin,'memmanremarks':memmanremarks,'sevaNotes':sevaNotes,'sevaType':sevaType,'calType1':JSON.stringify(calType1),'periodId':JSON.stringify(periodId),'ss_receipt_no':ssreceipt_no,'ss_receipt_date':ssreceipt_date,'fglhBank': fglhBank,'everyweekMonth':  JSON.stringify(everyweekMonth),'memmanismandli':memmanismandli,'type':JSON.stringify(type),'ledgers':JSON.stringify(ledgers),'amount':JSON.stringify(amount),'ledgerName':JSON.stringify(ledgerName),'naration':naration,'corpustot':corpustot }, function (e) {

			e1 = e.split("|")
			if (e1[0] == "success"){

			if(($('#ismandali').prop('checked')) == true){
				var smId =e1[1];
				let tableContent1 = getMandaliTableValues1();
				let address1 = [];
				let addressLine11 = [];
				let addressLine21 = [];
				let city1 = [];
				let state1 = [];
				let country1 = [];
				let pincode1 = [];
				let rashi1 = [];
				let gotra1 = [];
				let nakshatra1 = [];
				let number1 = [];
				let number21 = [];
				let remarks1 = [];
				let name1 = [];
				
				let ispostage = [];
				
				let url1 = "<?=site_url()?>Shashwath/mandalimemberinsert";
				for (let i = 0; i < tableContent1['name'].length; ++i) {
					name1[i] = tableContent1['name'][i].innerHTML.trim();
					number1[i] = tableContent1['number'][i].innerHTML.trim();
					number21[i] = tableContent1['number2'][i].innerHTML.trim();
					rashi1[i] = tableContent1['rashi'][i].innerHTML.trim();
					nakshatra1[i] = tableContent1['nakshatra'][i].innerHTML.trim();
					gotra1[i] = tableContent1['gotra'][i].innerHTML.trim();
					addressLine11[i] = tableContent1['addressLine1'][i].innerHTML.trim();
					addressLine21[i] = tableContent1['addressLine2'][i].innerHTML.trim();
					city1[i] = tableContent1['city'][i].innerHTML.trim();
					state1[i] = tableContent1['state'][i].innerHTML.trim();
					country1[i] = tableContent1['country'][i].innerHTML.trim();
					pincode1[i] = tableContent1['pincode'][i].innerHTML.trim();
					remarks1[i] = tableContent1['remarks'][i].innerHTML.trim();		
					ispostage[i] = tableContent1['ispostage'][i].innerHTML.trim();	

				}
				$.post(url1, {'name1': JSON.stringify(name1),'number1': JSON.stringify(number1),'number21': JSON.stringify(number21),'rashi1': JSON.stringify(rashi1),'gotra1': JSON.stringify(gotra1), 'nakshatra1': JSON.stringify(nakshatra1), 'addressLine11': JSON.stringify(addressLine11), 'addressLine21': JSON.stringify(addressLine21), 'city1': JSON.stringify(city1),'state1':JSON.stringify(state1), 'country1': JSON.stringify(country1), 'pincode1': JSON.stringify(pincode1),'remarks1': JSON.stringify(remarks1),'ispostage': JSON.stringify(ispostage),'smId':smId, 'memmanname': memmanname, 'memmannumber': memmannumber, 'memmannumber2': memmannumber2,'memmanaddr1':memmanaddr1,'memmanaddr2':memmanaddr2,'memmancity':memmancity,'memmanstate':memmanstate,'memmancountry':memmancountry,'memmanpin':memmanpin,'memmanremarks':memmanremarks }, function (e) {
					e1 = e.split("|")
					if (e1[0] == "success")
 					location.href = "<?=site_url();?>Receipt/shashwathReceipt";
					else
						alert("Something went wrong, Please try again after some time");
				});
			}
		}
		else
			alert("Something went wrong, Please try again after some time");
		});
		location.href = "<?=site_url();?>Receipt/shashwathReceipt";
		
	});

	
	function dateObj(d) { // date parser ...
		var parts = d.split(/:|\s/),
		date = new Date();
		if (parts.pop().toLowerCase() == 'pm') {
			parts[0] = ((+parts[0]) + 12).toString();
		}
		date.setHours(+parts.shift());
		date.setMinutes(+parts.shift());
		return date;
	}

	let ths = document.getElementById('postage');
	var ssreceipt_no;
	var ssreceipt_date;

	function validateSubmit() {
		
		let count = 0;
		let number = $('#phone').val()
		let number2 = $('#phone2').val()
		let name = $('#name').val()
		let rashi = $('#rashi').val()
		let gotra = $('#gotra').val()
		let pan = $('#pan').val();
		let adhaar = $('#adhaar').val();
		let nakshatra = $('#nakshatra').val()
		let paymentNotes = $('#paymentNotes').val();
		let chequeNo = "";
		let bank = "";
		let chequeDate = "";
		let branch = "";
		let tableContent = getTableValues();
		let modeOfPayment = $('#modeOfPayment option:selected').val();
		let toBank = $('#tobank option:selected').val();                    //laz
		let DCtoBank = $('#DCtobank option:selected').val();				//laz new
		let transactionId = $('#transactionId').val();	

		if(document.getElementById("manualreceipt").checked == true) {
			if($('#receiptLine1').val() != "" && $('#receiptLine2').val() != "") {
				ssreceipt_no = $('#receiptLine1').val().trim();
				ssreceipt_date = $('#receiptLine2').val();
			} else{
				alert("Information", "Please add receipt details");
				return;	
			}
		} else {
			ssreceipt_no =  "";
			ssreceipt_date = "";
		}
				
	
		let addrline1 = $('#addrline1'); 
		let addrline2 = $('#addrline2'); 
		let smcity = $('#smcity');
		let smstate = $('#smstate');
		let smcountry = $('#smcountry');
		let smpin = $('#smpin');
		let smAddress = "";
		if(($('#ismandali').prop('checked')) == false){
			$('#ismandali').attr("value", "NO");
		} else {
			$('#ismandali').attr("value", "YES");
		} 

		
		let mandaliName =  $('#mandaliName').val();
		let mandaliPhone = $('#mandaliPhone').val();
		let mandliPhone2 = $('#mandliPhone2').val();
		let mandliRemarks = $('#mandliRemarks').val();
		let mandliAddrline1 = $('#mandliAddrline1');
		let mandliAddrline2 = $('#mandliAddrline2');
		let mandlicity = $('#mandlicity');
		let mandliState = $('#mandliState');
		let mandliCountry = $('#mandliCountry');
		let mandliPin = $('#mandliPin');
		let mandaliAddress = "";
		var ismandali = $('#ismandali').val(); 

		if(addLine1.length > 0) {
				address += addLine1 + ", ";
			} else {
			}if(addLine2.length > 0) {
				address += addLine2 + ", ";
			}if(city.length > 0) {
				address += city + ", ";
			}if(state.length > 0) {
				address += state + ", ";
			} else {
			}if(country.length > 0) {
				address += country + ", ";
			} else {
			}if(pincode.length > 0) 
				address += pincode + ", ";

		if(ismandali == 'NO'){	
			if(addrline1.val().trim().length > 0) {
				smAddress += addrline1.val() + ", ";
				addrline1.css('border-color', "#800000");
			} else {
				addrline1.css('border-color', "#FF0000");
				count++;
			}if(addrline2.val().trim().length > 0) {
				smAddress += addrline2.val() + ", ";
			}if(smstate.val().trim().length > 0) {
				smAddress += smstate.val() + ", ";
				smstate.css('border-color', "#800000");
			} else {
				smstate.css('border-color', "#FF0000");
				count++;
			}if(smcountry.val().trim().length > 0) {
				smAddress += smcountry.val() + ", ";
				smcountry.css('border-color', "#800000");
			} else {
				smcountry.css('border-color', "#FF0000");
				count++;
			}
			if (modeOfPayment == "Cheque") {
				chequeNo = $('#chequeNo').val();
				chequeDate = $('#chequeDate').val();
				bank = $('#bank').val();
				branch = $('#branch').val();

				if (chequeNo.length == 6) {
					$('#chequeNo').css('border-color', "#800000");
				} else {
					$('#chequeNo').css('border-color', "#FF0000");
					++count;
				}

				if (chequeDate) {
					$('#chequeDate').css('border-color', "#800000");
				} else {
					$('#chequeDate').css('border-color', "#FF0000");
					++count;
				}

				if (bank) {
					$('#bank').css('border-color', "#800000");
				} else {
					$('#bank').css('border-color', "#FF0000");
					++count;
				}

				if (branch) {
					$('#branch').css('border-color', "#800000");
				} else {
					$('#branch').css('border-color', "#FF0000");
					++count;
				}
			} else if (modeOfPayment == "Credit / Debit Card") {							//laz new
				if (DCtoBank != 0) {
					$('#DCtobank').css('border-color', "#800000");
				} else {
					$('#DCtobank').css('border-color', "#FF0000");
					++count;
				}
				if (transactionId) {
					$('#transactionId').css('border-color', "#800000");
				} else {
					$('#transactionId').css('border-color', "#FF0000");
					++count;
				}
			}																			//laz new.. 
			else if (modeOfPayment == "Direct Credit") {									//laz
				if (toBank!=0) {
					$('#tobank').css('border-color', "#800000");
				} else {
					$('#tobank').css('border-color', "#FF0000");
					++count;
				}																			//laz..
			} else {
				$('#chequeNo').css('border-color', "#800000");
				$('#branch').css('border-color', "#800000");
				$('#bank').css('border-color', "#800000");
				$('#chequeDate').css('border-color', "#800000");
			} 
			if (modeOfPayment == "Transfer") {									//laz
				if($('#debitTot').val() == "" ) {
            		alert("Information","Please fill required fields");
            		return;
        		} if($('#debitTot').val() == 0 ) {
            		alert("Information","Please fill required fields");
           	 		return;
        		}
        		let flag=0;
        		$('.ledger').each(function(i, ele) {
            		pos = ele.id.split('_')[1];
            		if($('#ledger_'+pos).val()=="") {
                		alert("Information","Please fill required fields");
                		flag++;
            		}

        		});
        		if(flag!=0)
            			return;																//laz..
			}
			if (modeOfPayment) {
				$('#modeOfPayment').css('border-color', "#ccc")

			} else {
				$('#modeOfPayment').css('border-color', "#FF0000")
				++count;
			}

			if (name) {
				$('#name').css('border-color', "#ccc")

			} else {
				$('#name').css('border-color', "#FF0000")
				++count;
			}
			if (number) {
				$('#phone').css('border-color', "#ccc")

			} else {
				$('#phone').css('border-color', "#FF0000")
				++count;
			}
			if (count != 0) {
				alert("Information", "Please fill required fields", "OK");
				return false;
			}
		}

		if(ismandali == 'YES') {
			if (mandaliName) {		
				$('#mandaliName').css('border-color', "#ccc")

			} else {
				$('#mandaliName').css('border-color', "#FF0000")
				++count;
			}if (mandaliPhone) {
				$('#mandaliPhone').css('border-color', "#ccc")

			} else {
				$('#mandaliPhone').css('border-color', "#FF0000")
				++count;
			}if(mandliAddrline1.val().trim().length > 0) {
				mandaliAddress += mandliAddrline1.val() + ", ";
				mandliAddrline1.css('border-color', "#800000");
			} else {
				mandliAddrline1.css('border-color', "#FF0000");
				count++;
			}if(mandliAddrline2.val().trim().length > 0) {
				mandaliAddress += mandliAddrline2.val() + ", ";
			}if(mandlicity.val().trim().length > 0) {
				mandaliAddress += mandlicity.val() + ", ";
			}if(mandliState.val().trim().length > 0) {
				mandaliAddress += mandliState.val() + ", ";
				mandliState.css('border-color', "#800000");
			} else {
				mandliState.css('border-color', "#FF0000");
				count++;
			}if(mandliCountry.val().trim().length > 0) {
				mandaliAddress += mandliCountry.val() + ", ";
				mandliCountry.css('border-color', "#800000");
			} else {
				mandliCountry.css('border-color', "#FF0000");
				count++;
			}if(mandliPin.val().trim().length > 0) 
				mandaliAddress += mandliPin.val() + ", ";

				if(addLine1.length > 0) {
				address += addLine1 + ", ";
			} else {
			}if(addLine2.length > 0) {
				address += addLine2 + ", ";
			}if(city.length > 0) {
				address += city + ", ";
			}if(state.length > 0) {
				address += state + ", ";
			} else {
			}if(country.length > 0) {
				address += country + ", ";
			} else {
			}if(pincode.length > 0) 
				address += pincode + ", ";

			if (count != 0) {
				alert("Information", "Please fill required fields", "OK");
				return false;
			}
		}
		
		if (tableContent['sevaName'].length == 0) {
			alert("Information", "Enter all the required fields to submit.");
			return;
		}
		let sevaName = [];
		let sevaQty = [];
		let corpus = [];
		let corpustot=0;
		let Transfertot=0;
		for (i = 0; i < tableContent['corpus'].length; ++i) {
			corpustot +=parseInt(tableContent['corpus'][i].innerHTML);
		}

		let type = [];
	    let ledgers = [];
	    let amount = [];
	    let ledgerName =[];
	    let toLedgerName="";
	    let j=0,position=0,getLedg=0,dispType="";

		$('.ledger').each(function(i, ele) {
            position = ele.id.split('_')[1];
            type[j]= $('#type_'+position).val()
            getLedg = $('#ledger_'+position).val().split("|");

            ledgers[j]= getLedg[0];
            ledgerName[j]= getLedg[2];

            if(type[j]=="from") {
                amount[j] = $('#debit_'+position).val()
                Transfertot +=parseInt(amount[j]);
            }
            j++;
        });

        if (modeOfPayment =="Transfer") {
	        if(corpustot != Transfertot){
				alert("Information", "Corpus amount and adjustmenet amount should be equal", "OK");
				return;
			}
		}
		

		let periodCombo = [];
		
		let amt = [];
		let sevaId = [];
		let userId = [];
		let quantityChecker = [];
		let deityId = [];
		let deityName = [];
		let isSeva = [];
		let address = [];
		let tableContent1 = getMandaliTableValues1();
		
		let address1 = [];
		let name1 = [];
		let number1 = [];
		let rashi1 = [];
		let nakshatra1 = [];
		let gotra1 = [];
		let remarks1 = [];
		let ispostage =[];
		let total = 1
		let url = "<?=site_url()?>Receipt/generateDeityReceipt";

		$('#eventUpdate2').html("");

		$('.modal-body').html('<div class="table-responsive" style="overflow-x:hidden"><table class="table "><thead><tr><th style="border:1px solid #7d6363"><center>Sl. No.</center></th><th style="border:1px solid #7d6363">Deity Name</th><th style="border:1px solid #7d6363">Seva Name</th><th style="border:1px solid #7d6363"><center>Qty</center></th><th style="border:1px solid #7d6363"><center>Corpus</center></th><th style="border:1px solid #7d6363"><center>Seva Date</center></th><th style="border:1px solid #7d6363"><center>Thithi Code</center></th><th style="border:1px solid #7d6363"><center>Week/Month</center></th><th style="border:1px solid #7d6363"><center>Period</center></th><th style="border:1px solid #7d6363"><center>Postage Address</center></th></tr></thead><tbody id="eventUpdate2"></tbody></table></div>')

		for (i = 0; i < tableContent['sevaName'].length; ++i) {
			$('#eventUpdate2').append("<tr>");
			$('#eventUpdate2').append("<td style='border:1px solid #7d6363'><center>" + tableContent['si'][i].innerHTML + "</center></td>");
			$('#eventUpdate2').append("<td style='border:1px solid #7d6363'>" + tableContent['deityName'][i].innerHTML + "</td>");
			$('#eventUpdate2').append("<td style='border:1px solid #7d6363'>" + tableContent['sevaName'][i].innerHTML + "</td>");
			$('#eventUpdate2').append("<td style='border:1px solid #7d6363'><center>" + tableContent['sevaQty'][i].innerHTML + "</center></td>");
			$('#eventUpdate2').append("<td style='border:1px solid #7d6363'><center>" + tableContent['corpus'][i].innerHTML + "</center></td>");
			$('#eventUpdate2').append("<td style='border:1px solid #7d6363'><center>" + tableContent['dateMonth1'][i].innerHTML + "</center></td>");
			$('#eventUpdate2').append("<td style='border:1px solid #7d6363'><center>" + tableContent['thithi'][i].innerHTML + "</center></td>");
			$('#eventUpdate2').append("<td style='border:1px solid #7d6363'><center>" + tableContent['everyweekMonth'][i].innerHTML + "</center></td>");
			$('#eventUpdate2').append("<td style='border:1px solid #7d6363'><center>" + tableContent['periodName'][i].innerHTML + "</center></td>");
			$('#eventUpdate2').append("<td style='border:1px solid #7d6363'><center>" + tableContent['address'][i].innerHTML + "</center></td>");
			$('#eventUpdate2').append("</tr><br/>");
		}

		$('.modal-body').append("<label>DATE:</label> " + "<?=date('d-m-Y'); ?>" + "<br/>");
		if(($('#ismandali').prop('checked')) == false){
			$('.modal-body').append("<label>NAME:</label> " + name + "");
			if (number)
				$('.modal-body').append(",&nbsp;&nbsp;<label>NUMBER:</label> " + number + "");
			if (number2)
				$('.modal-body').append(",&nbsp;&nbsp;<label>NUMBER2:</label> " + number2 + "");
			if (rashi)
				$('.modal-body').append("<label>RASHI:</label> " + rashi + ",&nbsp;&nbsp;");
			if (gotra)
				$('.modal-body').append("<label>GOTRA:</label> " + gotra + ",&nbsp;&nbsp;");
			if (nakshatra)
				$('.modal-body').append("<label>NAKSHATRA:</label> " + nakshatra + "");
			$('.modal-body').append("<br/>");
			if (ssreceipt_no)
				$('.modal-body').append("<label>MANUAL RECEIPTNO:</label> " + ssreceipt_no + ",&nbsp;&nbsp;");
			if (ssreceipt_date)
				$('.modal-body').append("<label>MANUAL RECEIPTDATE:</label> " + ssreceipt_date + "");
			$('.modal-body').append("<br/>");
			if(smAddress)
				$('.modal-body').append("<label>ADDRESS:</label> "+ smAddress +"<br/>");
			if(pan)
			$('.modal-body').append("<label>Pan No:</label> "+ pan +"<br/>");
			if(adhaar)
			$('.modal-body').append("<label>Adhaar No:</label> "+ adhaar +"<br/>");
		
		} else {
			$('.modal-body').append("<label>NAME:</label> " + mandaliName + "");
			if (mandaliPhone)
				$('.modal-body').append(",&nbsp;&nbsp;<label>NUMBER:</label> " + mandaliPhone + "");
			if (mandliPhone2)
				$('.modal-body').append(",&nbsp;&nbsp;<label>NUMBER2:</label> " + mandliPhone2 + "");
			if (mandaliAddress)
				$('.modal-body').append("<label>ADDRESS:</label> " + mandaliAddress + ",&nbsp;&nbsp;");
		} 
		$('.modal-body').append("<label>MODE OF PAYMENT:</label> " + modeOfPayment + "<br/>");

		if (modeOfPayment == "Cheque") {
			$('.modal-body').append("<label>CHEQUE NO:</label> " + chequeNo + ",&nbsp;&nbsp;");
			$('.modal-body').append("<label>CHEQUE DATE:</label> " + chequeDate + ",&nbsp;&nbsp;");
			$('.modal-body').append("<label>BANK:</label> " + bank + ",&nbsp;&nbsp;");
			$('.modal-body').append("<label>BRANCH:</label> " + branch + "<br/>");


		} else if (modeOfPayment == "Credit / Debit Card") {
			$('.modal-body').append("<label>TRANSACTION ID:</label> " + transactionId + "<br/>");
		}

		if (paymentNotes)
			$('.modal-body').append("<label>PAYMENT NOTES:</label> " + paymentNotes + "");
		if (tableContent1['name'].length != 0){
			$('.modal-body').append('<h4>New Mandali Members:</h4>');
			$('.modal-body').append('<div class="table-responsive" style="overflow-x:hidden"><table class="table "><thead><tr><th style="border:1px solid #7d6363"><center>Sl. No.</center></th><th style="border:1px solid #7d6363">Name</th><th style="border:1px solid #7d6363">Phone</th><th style="border:1px solid #7d6363"><center>Rashi</center></th><th style="border:1px solid #7d6363"><center>Nakshatra</center></th><th style="border:1px solid #7d6363"><center>Seva Gotra</center></th><th style="border:1px solid #7d6363"><center>Address</center></th><th style="border:1px solid #7d6363"><center>Remarks</center></th></tr></thead><tbody id="eventUpdate3"></tbody></table></div>')
			$('#eventUpdate3').html("");	

			for (j = 0; j < tableContent1['name'].length; ++j) {
				$('#eventUpdate3').append("<tr>");
				$('#eventUpdate3').append("<td style='border:1px solid #7d6363'><center>" + tableContent1['si'][j].innerHTML + "</center></td>");
				$('#eventUpdate3').append("<td style='border:1px solid #7d6363'>" + tableContent1['name'][j].innerHTML + "</td>");
				$('#eventUpdate3').append("<td style='border:1px solid #7d6363'>" + tableContent1['number'][j].innerHTML + "</td>");
				$('#eventUpdate3').append("<td style='border:1px solid #7d6363'><center>" + tableContent1['rashi'][j].innerHTML + "</center></td>");
				$('#eventUpdate3').append("<td style='border:1px solid #7d6363'><center>" + tableContent1['nakshatra'][j].innerHTML + "</center></td>");
				$('#eventUpdate3').append("<td style='border:1px solid #7d6363'><center>" + tableContent1['gotra'][j].innerHTML + "</center></td>");
				$('#eventUpdate3').append("<td style='border:1px solid #7d6363'><center>" + tableContent1['address'][j].innerHTML + "</center></td>");
				//$('#eventUpdate3').append("<td style='border:1px solid #7d6363'><center>" + tableContent1['price'][j].innerHTML + "</center></td>");
				$('#eventUpdate3').append("<td style='border:1px solid #7d6363'><center>" + tableContent1['remarks'][j].innerHTML + "</center></td>");
				$('#eventUpdate3').append("</tr><br/>");
			}
		}
		$('.modal').modal();
		$('.bs-example-modal-lg').focus();
	}

	function deityComboChange() {
		bgNo = $('#deityCombo').val();
		$('#sevaCombo').html("");
		for (let i = 0; i < arr.length; ++i) {
			if (arr[i]['DEITY_ID'] == bgNo)
				if(arr[i]['REVISION_STATUS'] == 1)
					$('#sevaCombo').append('<option value="' + arr[i]['DEITY_ID'] + "|" + arr[i]['SEVA_ID'] + "|" + arr[i]['SEVA_NAME'] + "|" + arr[i]['USER_ID'] + "|" + arr[i]['SEVA_PRICE'] + "|" + arr[i]['QUANTITY_CHECKER'] + "|" + arr[i]['IS_SEVA'] + "|" + arr[i]['OLD_PRICE'] + "|" + arr[i]['REVISION_STATUS'] + "|" + arr[i]['REVISION_DATE']+"|" + arr[i]['SEVA_TYPE'] + "|" + arr[i]['SHASH_PRICE'] + '">' + arr[i]['SEVA_NAME']+"  =  "+ (arr[i]['SEVA_TYPE'] == "Occasional" ? "Occasional" :"Regular") + '</option>');
				else
					$('#sevaCombo').append('<option value="' + arr[i]['DEITY_ID'] + "|" + arr[i]['SEVA_ID'] + "|" + arr[i]['SEVA_NAME'] + "|" + arr[i]['USER_ID'] + "|" + arr[i]['SEVA_PRICE'] + "|" + arr[i]['QUANTITY_CHECKER'] + "|" + arr[i]['IS_SEVA'] + "|" + arr[i]['OLD_PRICE'] + "|" + arr[i]['REVISION_STATUS'] + "|" + arr[i]['REVISION_DATE'] +"|" + arr[i]['SEVA_TYPE'] + "|" + arr[i]['SHASH_PRICE'] + '">' + arr[i]['SEVA_NAME'] +"  =  "+((arr[i]['SEVA_TYPE'] == "Occasional") ? "Occasional" :"Regular") + '</option>');
		}
		for (i = 1; i <= 5; ++i)
			if (i == bgNo)
				$('.bg' + i).fadeIn("slow");
			else
				$('.bg' + i).hide();

			sevaComboChange();
		}
		(function () {
			arr = <?php echo @$sevas; ?>;
			for (let i = 0; i < arr.length; ++i) {
				if (arr[i]['DEITY_ID'] == 1)
					$('#sevaCombo').append('<option value="' + arr[i]['DEITY_ID'] + "|" + arr[i]['SEVA_ID'] + "|" + arr[i]['SEVA_NAME'] + "|" + arr[i]['USER_ID'] + "|" + arr[i]['SEVA_PRICE'] + "|" + arr[i]['QUANTITY_CHECKER'] + "|" + arr[i]['IS_SEVA'] + "|" + arr[i]['SHASH_PRICE'] + '">' + arr[i]['SEVA_NAME'] + "  =  "+((arr[i]['SEVA_TYPE'] == "Occasional") ? "Occasional" :"Regular") + '</option>');
			}

			let sevaCombo = getSevaCombo();

			$('#setPrice').html(sevaCombo.sevaPrice);

			if ($('#radioOpt').val() != "EveryRadio") {
				if (sevaCombo.quantityChecker == "1") {
					$('.corpus').fadeIn("slow");
				} else {
				}
			} else {
			}
			deityComboChange();
			}());

			$('#transactionId').keyup(function () {
				var $th = $(this);
				$th.val($th.val().replace(/[^A-Za-z0-9]/g, function (str) { return ''; }));
			});

	
	$('#chequeNo').keyup(function () {
		var $th = $(this);
		$th.val($th.val().replace(/[^0-9]/g, function (str) { return ''; }));
	});

	$('#EveryRadio').on('click', function () {
		$('.EveryRadio').fadeIn("slow");
		$('.everyDay').fadeIn("slow");
		$('#selDate').html("");
		$('#multiDate').val("");
		$('.multiDate').hide();
		$('#multiDate').css('border-color', "#ccc");
		$('#fromDate').css('border-color', "#ccc");
		$('#toDate').css('border-color', "#ccc");
		$('#corpus').css('border-color', "#800000");
		$('#corpus').val(1);
		$('#radioOpt').val("EveryRadio");
		$('#fromDate').multiDatesPicker('setDate', null);
		$('#toDate').multiDatesPicker('setDate', null);
		$('#multiDate').multiDatesPicker('resetDates');
		between = [];
		$('#fromDate').css('border-color', "#ccc");
		$('#toDate').css('border-color', "#ccc");
		$('#multiDate').css('border-color', "#ccc");
		date_type = ""
		everySelectedOption = "Day"
	});

	$('#multiDateRadio').on('click', function () {
		date_type = ""
		$('#fromDate').css('border-color', "#ccc");
		$('#toDate').css('border-color', "#ccc");
		$('#multiDate').css('border-color', "#ccc");
		$('#multiDate').css('border-color', "#ccc");
		$('#fromDate').css('border-color', "#ccc");
		$('#toDate').css('border-color', "#ccc");
		$('#corpus').css('border-color', "#800000");
		$('#selDate').html("");
		let sevaCombo = getSevaCombo();
		if (sevaCombo.isSeva == "0") {
			$('.isSeva1').hide();
			$('.showAdd').show();
		} else {
			$('.isSeva1').fadeIn("slow");
			$('.showAdd').hide();
		}
		$('.corpus').fadeIn("slow");
		$('.everyDay').hide();
		$('#fromDate').val("");
		$('#corpus').val(1);
		$('#toDate').val("");
		$('.EveryRadio').hide();
		$('#radioOpt').val("multiDateRadio");
		everySelectedOption = "Day"
		$('#fromDate').multiDatesPicker('setDate', null);
		$('#toDate').multiDatesPicker('setDate', null);
		$('#multiDate').multiDatesPicker('resetDates');
		$('#multiDate').val("");
		$('.multiDate').fadeIn("slow");
		between = [];
	});

	var price = 0;
	var total = 0;

	function sevaComboChange() {
		eventSeva = $('#sevaCombo').val();
		eventSeva = eventSeva.split("|");
		let sevaCombo = getSevaCombo();
		if ($('#radioOpt').val() != "EveryRadio") {
			if (sevaCombo.isSeva == "0") {
				$('.isSeva1').hide();
				$('.showAdd').show();
			} else {
				$('.isSeva1').fadeIn("slow");
				$('.showAdd').hide();
			}

			if (sevaCombo.quantityChecker == "1") {
				$('.corpus').fadeIn("slow");
			} else {
			}
		} else {

		} 	
		if(sevaCombo.revision_status == 1) {
			$('#setPrice').html(sevaCombo.old_price);
			let newDate = new Date(((sevaCombo.revision_date).toString().split("-").reverse()))
			$('#revRate').html("Revision Rate: &#8377; "+ sevaCombo.sevaPrice + " from " +((newDate.getDate()<10)?"0"+newDate.getDate():newDate.getDate())+ "-"+(((newDate.getMonth()+1)<10)?"0"+(newDate.getMonth()+1):(newDate.getMonth()+1))+ "-"+newDate.getFullYear())
			$('#revDate').css("display","inline")
		}
		else {
			$('#setPrice').html(sevaCombo.sevaPrice);
			$('#revDate').css("display","none")
		} 
		if ($('#radioOpt').val() != "EveryRadio") {
			if (sevaCombo.quantityChecker == "1") {
				$('.corpus').fadeIn("slow");
			} else {
			}
		} else {

		} 

		$('#minAmt').html("Minimum Corpus : "+ sevaCombo.shashPrice);
		$('#Sqty').html(" X " + $('#sevaQty').val() + " = ");
		$('#totMinAmt').html(sevaCombo.shashPrice * $('#sevaQty').val());
	}
	var currentTime = new Date()
	var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
	var maxDate = new Date(currentTime.getFullYear(), currentTime.getMonth() + 12, +0); // one day before next month
	let masa1 = [];
	let bomcode1 = [];
	let thithiName1 = [];
	let l=0;

	function addRow() {
		let duplicate = checkDuplicate();
		if (duplicate != 0)
			return;
		let tableContent = getTableValues();
		if (tableContent['sevaName'].length > 0 && $('#radioOpt').val() != "multiDateRadio") {
			alert("Information", "Please remove added seva dates to add new recurring seva dates")
			return;
		}
		let name = $('#name').val()
		let number = $('#number').val()
		let number2 = $('#number').val()
		let rashi = $('#rashi').val()
		let nakshatra = $('#nakshatra').val();
		let sevaCombo1 = getSevaCombo();
		let sevaCombo = $('#sevaCombo option:selected').html();
		let sevaName = sevaCombo1.sevaName;
		let sevaQty = $('#sevaQty').val();
		let isSeva = sevaCombo1.isSeva;
		let sevaPrice = Number($('#corpus').html());
		let deityId = sevaCombo1.deityId;
		let userId = sevaCombo1.userId;
		let sevaId = sevaCombo1.sevaId;
		let quantityChecker = 1;
		let purpose = $('#sevaNotes').val();
		let deityCombo = $('#deityCombo option:selected').html().trim();
		let setPrice = Number($('#setPrice').html())
		let date = "";
		let count = 0;
		let revisionStatus = sevaCombo1.revision_status
		let revision_date = sevaCombo1.revision_date
		let revision_price = sevaCombo1.sevaPrice;
		let oldPrice = sevaCombo1.old_price
		let revFlag = 0;
		let dateMonth1="";
		let datesplit = $("#multiDate").val().split("-");
		let dateMonth =  ( ($('#hindu').prop('checked') || $('#festivalwise').prop('checked')|| $('#everyWeekMonth').prop('checked')) ? $("#multiDate").val() : datesplit[0]+"-"+datesplit[1]);
		let masaCode = $('#masaCode option:selected').val();
		let bomCode = $('#bomCode option:selected').val();
		let thithiCode = $('#thithiCode option:selected').val();
		let thithiCode1 = $('#thithiCode1 option:selected').val();
		let deityComboValue = $('#deityCombo option:selected').val();
		let periodCombo = document.getElementById("periodCombo").value.split("|");		
		if($('#hindu').prop('checked')) {
			if(masaCode != "" && bomCode != ""){
				if(bomCode.split("|")[0] == 'SH') {
					if(thithiCode == ""){
						$('#thithiCode').css('border-color', "#FF0000")
						alert("Information","Please select appropriate Thithi date for seva");
						return;
					}
				} else {				
					if(thithiCode1 == ""){
						$('#thithiCode1').css('border-color', "#FF0000")
						alert("Information","Please select appropriate Thithi date for seva");
						return;
					}
				}
			} else {
				alert("Information","Please first select appropriate Masa, Shuddha/Bahula for hindu date");
				return;
			}
		}
		let festivalCodeVal = $('#festivalCode option:selected').val();
		if($('#festivalwise').prop('checked')) {
			if(festivalCodeVal == ""){

				$('#festivalCode').css('border-color', "#FF0000")
				alert("Information","Please select appropriate Festival for seva");
				return;
			}
		}
		// let everyWeekMonthval = $('#weekMonth option:selected').val();
		// let everyDayVal = $('#selectday option:selected').val();
		// if($('#everyWeekMonth').prop('checked')) {
		// 	if(everyWeekMonthval == ""){
		// 		$('#weekMonth').css('border-color', "#FF0000")
		// 		alert("Information","Please select appropriate Week/Month for seva");
		// 		return;
		// 	}
		// }
		// if($('#everyWeekMonth').prop('checked')) {
		// 	if(everyDayVal == ""){
		// 		$('#selectday').css('border-color', "#FF0000")
		// 		alert("Information","Please select appropriate Day for seva");
		// 		return;
		// 	}
		// }

		let everyWeekMasaval = $('#masaevery option:selected').val();	
		let everyWeekMonthval = $('#weekMonth option:selected').val();
		let everyDayVal = $('#selectday option:selected').val();
		let everyFivedaysval = $('#everyFivedaysval option:selected').val();
		let modeOfChangeMonth = $('#modeOfChangeMonth option:selected').val();
		let weekMonth = $('#weekMonth option:selected').val();
	
		if($('#everyWeekMonth').prop('checked')) {
			// if(weekMonth == ""){
   //      		alert("Information","Please select appropriate option");
   //      		$('#weekMonth').css('border-color', "#FF0000");
   //      		return;
   //      	}
        	// if(everyDayVal == ""){
        	// 	alert("Information","Please select appropriate Day for seva");
        	// 	$('#selectday').css('border-color', "#FF0000");
        	// 	return;
        	// }
        	
        }

		
		if(document.getElementById("weekMonth").value == "Year") {
			if(modeOfChangeMonth == ""){
				$('#modeOfChangeMonth').css('border-color', "#FF0000")
				alert("Information","Please select appropriate Month for seva");
				return;
			}
			
			if(everyFivedaysval == ""){
				$('#everyFivedaysval').css('border-color', "#FF0000")
				alert("Information","Please select appropriate days for seva");
				return;
			}
			
			if(everyDayVal == ""){
				$('#selectday').css('border-color', "#FF0000")
				alert("Information","Please select appropriate day for seva");
				return;
			}	
			
		}

		
		if(document.getElementById("weekMonth").value == "Month") {
			if(everyFivedaysval == ""){
				$('#everyFivedaysval').css('border-color', "#FF0000")
			}
			if(everyDayVal == ""){
				$('#selectday').css('border-color', "#FF0000")
			}							
		}


		if(document.getElementById("weekMonth").value == "Week") {
			if(everyDayVal == ""){
				$('#selectday').css('border-color', "#FF0000")
			}			
			
		}

		if(document.getElementById("weekMonth").value == "YearHindu") {
			
			if(everyFivedaysval == ""){
				$('#everyFivedaysval').css('border-color', "#FF0000");

				return;

			}
			if(everyDayVal == ""){
				$('#selectday').css('border-color', "#FF0000");
				return;
			}
			if(everyWeekMasaval == ""){
				$('#masaevery').css('border-color', "#FF0000")
				alert("Information","Please select appropriate Masa for seva");
				return;

			}							
		}

	

		
		$("#address").val("");
		let ths = document.getElementById('postage');
		let addLine1 = $('#addLine1'); 
		let addLine2 = $('#addLine2'); 
		let city = $('#city');
		let state = $('#state');
		let country = $('#country');
		let pincode = $('#pincode');
		let address = "";
		let counter = 0;	
		if(ths.checked) {
			if(addLine1.val().trim().length > 0) {
				address += addLine1.val() + ", ";
				addLine1.css('border-color', "#000000");
			} else {
				addLine1.css('border-color', "#FF0000");
				counter++;
			}
			
			if(addLine2.val().trim().length > 0) {
				address += addLine2.val() + ", ";
			}
			
			if(city.val().trim().length > 0) {
				address += city.val() + ", ";
				city.css('border-color', "#000000");
			} else {
				city.css('border-color', "#FF0000");
				counter++;
			}

			if(state.val().trim().length > 0) {
				address += state.val() + ", ";
				state.css('border-color', "#000000");
			} else {
				state.css('border-color', "#FF0000");
				counter++;
			}
			
			if(country.val().trim().length > 0) {
				address += country.val() + ", ";
				country.css('border-color', "#000000");
			} else {
				country.css('border-color', "#FF0000");
				counter++;
			}
			
			if(pincode.val().trim().length > 0) {
				address += pincode.val();
				pincode.css('border-color', "#000000");
			} else {
				pincode.css('border-color', "#FF0000");
				counter++;
			} 
			
			$('#address').val(address);
		} else {
			if(addLine1.val().trim().length > 0) {
				address += addLine1.val() + ", ";
			}
			
			if(addLine2.val().trim().length > 0) {
				address += addLine2.val() + ", ";
			}
			
			if(city.val().trim().length > 0) {
				address += city.val() + ", ";
			}

			if(state.val().trim().length > 0) {
				address += state.val() + ", ";
			}
			
			if(country.val().trim().length > 0) {
				address += country.val() + ", ";
			}
			
			if(pincode.val().trim().length > 0) {
				address += pincode.val();
			}

			$('#address').val(address);
		}
		
		if(counter > 0) {
			alert("Information","Please fill Postage Details (Address Line1, City, State, Country, Pincode) when Postage Checker is checked");
			return false;	
		}

		date = $("#multiDate").val();
		if(date == "" && $('#gregorian').prop('checked')){
			alert("Information","Please select date for seva");
			return false;
		}
		else{
			dateMonth1 = dateMonth.split(",");
			date2 = date.split(",");

		}

		if(revisionStatus == 1) {
			let cD = "";
			try {
				cD = new Date(between[0].split("-").reverse())
			} catch(e){
				cD = new Date(date2[0].split("-").reverse())
			}
			let newDate = new Date(revision_date.split("-").reverse())
			console.log(cD);
			console.log(newDate);
			if(cD >= newDate) {
				revFlag = 1
				
			} else { revFlag = 0}
		} else {
			revFlag = 0
		}
		
		let corpus = date2.length;

		if (corpus <= 0)
			corpus = 1;

		if ($('#radioOpt').val() != "EveryRadio") {
			if (quantityChecker == "1") {
				$('.corpus').fadeIn("slow");

				corpus = $('#corpus').val();

				if (corpus) {
					$('#corpus').css('border-color', "#800000");
				} else {
					$('#corpus').css('border-color', "#FF0000");
					++count;
				}
				if (sevaQty) {
					$('#sevaQty').css('border-color', "#000000");
				} else {
					$('#sevaQty').css('border-color', "#FF0000");
					++count;
				}
				if (sevaCombo1.isSeva == "0") {
					$('.isSeva1').hide();
					$('.showAdd').show();
				} else {
					$('.isSeva1').fadeIn("slow");
					$('.showAdd').hide();
				}	
				if (count != 0) {
					alert("Information", "Please fill required fields", "OK");
					return;
				}  	


			} else {
					if (sevaCombo1.isSeva != "0") {
					$('.isSeva1').hide();
					$('.showAdd').show();
					
					if (date) {
						$('#multiDate').css('border-color', "#ccc");
					} else {
						$('#multiDate').css('border-color', "#FF0000");
						++count;
					} 
				}
			}
		}

		if($('#corpus').val() < Number($('#totMinAmt').html()))	{//SLAP
			alert("Information","The Corpus Entered does not match with min Corpus Amount based on qty Provided!!!");
			return;
		}
		let si = $('#eventSeva tr:last-child td:first-child').html();
		if (!si)
			si = 1
		else
			++si;
		let amt = 0;
		$('#fromDate').val("");
		$('#toDate').val("");
		$('#multiDate').val("");
		$('#selDate').html("");
		$('#fromDate').multiDatesPicker('setDate', null);
		$('#toDate').multiDatesPicker('setDate', null);
		$('#multiDate').multiDatesPicker('resetDates');
		$('.amt').val("");

		if (between.length == 0 && $('#radioOpt').val() != "EveryRadio") {		
			for (let i = 0; i < date2.length; ++i) {
				var thithiIndex;	
				let masaCode = document.getElementById("masaCode").value.split("|");
				let bomcode = document.getElementById("bomCode").value.split("|");
				if(bomcode[0] == 'SH') {
					let thithiCode = document.getElementById("thithiCode").value.split("|");
					thithiIndex = thithiCode[0];
				} else {
					let thithiCode1 = document.getElementById("thithiCode1").value.split("|");
					thithiIndex = thithiCode1[0];
				}
				var masa1,bomcode1,thithiName1;
				if($('#hindu').prop('checked')){
					masa1 = masaCode[1];
					bomcode1 = bomcode[1];
					if(bomcode[0] == 'SH') {
						let thithiCode = document.getElementById("thithiCode").value.split("|");
						thithiName1 =thithiCode[1];	
					}else {
						let thithiCode1 = document.getElementById("thithiCode1").value.split("|");
						thithiName1 =thithiCode1[1];
					}
				} else {
					masa1 = "";
					bomcode1 = "";
					thithiName1 ="";
				}
				let thithi="";
				let festivalThithiCode = document.getElementById("festivalCode").value;
				let thithi1 = ( $('#hindu').prop('checked') ? masaCode[0]+bomcode[0]+thithiIndex : ""  );
				let thithi2 = ( $('#festivalwise').prop('checked') ? festivalThithiCode : ""  );
				if(thithi1!="") {
					thithi = thithi1;
				}
				else if(thithi2!="") {
					thithi = thithi2;
				}

				// let WeekMonthCode = document.getElementById("selectday").value;
				// if(document.getElementById("weekMonth").value == "Month") {
				// 	WeekMonthCode = "First_" + WeekMonthCode;
				// }
				let everyMonthval = document.getElementById("masaevery").value.split("|");
				let everyFivedaysval = document.getElementById("everyFivedaysval").value;
				let modeOfChangeMonth = document.getElementById("modeOfChangeMonth").value;
				let WeekMonthCode = document.getElementById("selectday").value;
				if(document.getElementById("weekMonth").value == "Month") {
					WeekMonthCode = everyFivedaysval+"_" + WeekMonthCode;
				} else if(document.getElementById("weekMonth").value == "Year") {
					WeekMonthCode = modeOfChangeMonth+"_" +everyFivedaysval+"_" + WeekMonthCode;
				}else if(document.getElementById("weekMonth").value == "YearHindu") {
					WeekMonthCode = everyMonthval[1]+"_" +everyFivedaysval+"_" + WeekMonthCode;
				}


				let calType = " ";
				if($('#hindu').prop('checked')){
					calType = 'Hindu';
					document.getElementById('HinduCal').style.display = "block";
					document.getElementById("masaCode").selectedIndex = 0;
					document.getElementById("thithiCode").selectedIndex = 0;
					document.getElementById("thithiCode1").selectedIndex = 0;
					document.getElementById("bomCode").selectedIndex = 0;
				} else if($('#gregorian').prop('checked')) {
					calType = 'Gregorian';
					document.getElementById('GregorianCal').style.display = "block";
				} else if($('#festivalwise').prop('checked')){
					calType = 'Festivalwise';
					document.getElementById('FestvalCal').style.display = "block";
				} else if($('#everyWeekMonth').prop('checked')){
					calType = 'Every';
					document.getElementById('EveryWeekMonth').style.display = "block";
					document.getElementById("weekMonth").selectedIndex = 0;
					document.getElementById("selectday").selectedIndex = 0;
				}
				var d = document.getElementById("multiDate").value;
				sevaCombo = sevaCombo.split('=')[0]+"("+sevaCombo.split('=')[1].trim()+")" ;				//+ "= ₹ " +		 	
				if(($('#postage').prop('checked')) == false) {
					$('#postage').attr("value", "NO");
					var vals = $('#postage').val(); 

					$('#eventSeva').append('<tr class="' + si + ' si1"><td class="si">' + si + '</td><td class="deityName">' + deityCombo + '</td><td class="sevaCombo">' + sevaCombo + '</td><td class="sevaQty">' + sevaQty + '</td><td class="corpus">' + corpus + '</td><td class="date" style="display:none;">'+ date2[i] +'</td> <td class="dateMonth1" >'+ dateMonth1[i] +'</td><td class="thithi">'+ thithi +'</td><td class="everyweekMonth">'+ WeekMonthCode +'</td><td class="periodId" style="display:none;">' + periodCombo[0].trim() + '</td><td class="periodName">' + periodCombo[1].trim() + '</td><td style="display:none;" class="price">' + price + '</td><td class="amt" style="display:none;">' +vals+ '</td><td class="purpose">' + purpose +'</td><td class="postage1">' + vals +'</td><td class="address">' + address +'</td><td class="link1"><a style="cursor:pointer;" onClick="updateTable(' + si + ');"><img style="width:24px; height:24px;" title="delete" src="<?=base_url()?>images/delete1.svg"></a></td><td style="display:none;" class="sevaName">' + sevaName + '</td><td style="display:none;" class="quantityChecker">' + quantityChecker + '</td><td style="display:none;" class="deityId">' + deityId + '</td><td style="display:none;" class="userId">' + userId + '</td><td style="display:none;" class="sevaId">' + sevaId + '</td><td style="display:none;" class="isSeva">' + isSeva + '</td><td style="display:none;" class="revFlag">' + revFlag + '</td><td style="display:none;" class="masa1">' + masa1 + '</td><td style="display:none;" class="bomcode1">' + bomcode1 + '</td><td style="display:none;" class="thithiName1">' + thithiName1 + '</td><td style="display:none;" class="addLine1">' + addLine1.val() + '</td><td style="display:none;" class="addLine2">' + addLine2.val() + '</td><td style="display:none;" class="city1">' + city.val() + '</td><td style="display:none;" class="state">' + state.val() + '</td><td style="display:none;" class="country">' + country.val() + '</td><td style="display:none;" class="pincode">' + pincode.val() + '</td><td class="calType1" style="display:none;">' + calType + '</td></tr>');
					si++;
				
				//total += amt
				} else {
					$('#postage').attr("value", "YES");
					var vals = $('#postage').val(); 
					$('#eventSeva').append('<tr class="' + si + ' si1"><td class="si">' + si + '</td><td class="deityName">' + deityCombo + '</td><td class="sevaCombo">' + sevaCombo + '</td><td class="sevaQty">' + sevaQty + '</td><td class="corpus">' + corpus + '</td><td class="date" style="display:none;">'+ date2[i] +'</td><td class="dateMonth1" >'+ dateMonth1[i] +'</td><td class="thithi">'+ thithi +'</td><td class="everyweekMonth">'+ WeekMonthCode +'</td><td class="periodId" style="display:none;">' + periodCombo[0].trim() + '</td><td class="periodName">' + periodCombo[1].trim() + '</td><td style="display:none;" class="price">' + price + '</td><td class="amt" style="display:none;">' +vals+ '</td><td class="purpose">' + purpose +'</td><td class="postage1">' + vals +'</td><td class="address">' + address +'</td><td class="link1"><a style="cursor:pointer;" onClick="updateTable(' + si + ');"><img style="width:24px; height:24px;" title="delete" src="<?=base_url()?>images/delete1.svg"></a></td><td style="display:none;" class="sevaName">' + sevaName + '</td><td style="display:none;" class="quantityChecker">' + quantityChecker + '</td><td style="display:none;" class="deityId">' + deityId + '</td><td style="display:none;" class="userId">' + userId + '</td><td style="display:none;" class="sevaId">' + sevaId + '</td><td style="display:none;" class="isSeva">' + isSeva + '</td><td style="display:none;" class="revFlag">' + revFlag + '</td><td style="display:none;" class="masa1">' + masa1 + '</td><td style="display:none;" class="bomcode1">' + bomcode1 + '</td><td style="display:none;" class="thithiName1">' + thithiName1 + '</td><td style="display:none;" class="addLine1">' + addLine1.val() + '</td><td style="display:none;" class="addLine2">' + addLine2.val() + '</td><td style="display:none;" class="city1">' + city.val() + '</td><td style="display:none;" class="state">' + state.val() + '</td><td style="display:none;" class="country">' + country.val() + '</td><td style="display:none;" class="pincode">' + pincode.val() + '</td><td class="calType1" style="display:none;">' + calType + '</td> </tr>');
					si++;
					
				}
			}
			$('#totalAmount').html(total);
		} else if (between.length != 0) {
			for (let i = 0; i < between.length; ++i) {
				//Code To Handle Revision Price
				var correctSevaBetweenPrice = ((revisionStatus == 0)?sevaPrice:((compareSevaDateWithRevisionDate(between[i].trim(),revision_date.trim()))?revision_price:sevaPrice));			
				sevaCombo = sevaCombo.split('=')[0] + "= ₹" + correctSevaBetweenPrice.toString();
				var e = document.getElementById("periodCombo").value.split("|");
				$('#eventSeva').append('<tr class="' + si + ' si1"><td class="si">' + si + '</td><td class="deityName">' + deityCombo + '</td><td class="sevaCombo">' + sevaCombo + '</td><td class="sevaQty">' + sevaQty + '</td><td class="corpus">' + corpus + '</td><td class="date" style="display:none;">'+date2[i]+'</td><td class="dateMonth1" >'+ dateMonth1[i] +'</td><td class="thithi">'+ thithi +'</td><td class="everyweekMonth">'+ WeekMonthCode +'</td><td class="periodId" style="display:none;">' + periodCombo[0].trim() + '</td><td class="periodName">' + periodCombo[1].trim() + '</td><td class="amt">' + postage + '</td><td class="postage1">' + vals +'</td><td class="address">' + address +'</td><td class="link1"><a style="cursor:pointer;" onClick="updateTable(' + si + ');"><img style="width:24px; height:24px;" title="delete" src="<?=base_url()?>images/delete1.svg"></a></td><td style="display:none;" class="sevaName">' + sevaName + '</td><td style="display:none;" class="quantityChecker">' + quantityChecker + '</td><td style="display:none;" class="deityId">' + deityId + '</td><td style="display:none;" class="userId">' + userId + '</td><td style="display:none;" class="sevaId">' + sevaId + '</td><td style="display:none;" class="isSeva">' + isSeva + '</td><td style="display:none;" class="revFlag">' + revFlag + '</td><td style="display:none;" class="addLine1">' + addLine1.val() + '</td><td style="display:none;" class="addLine2">' + addLine2.val() + '</td><td style="display:none;" class="city1">' + city.val() + '</td><td style="display:none;" class="state">' + state.val() + '</td><td style="display:none;" class="country">' + country.val() + '</td><td style="display:none;" class="pincode">' + pincode.val() + '</td><td class="calType1" style="display:none;">' + calType + '</td></tr>');
				si++;
				total += amt;	
			}
			$('#totalAmount').html(total);
		} else if (between.length == 0) {
			if (everySelectedOption == "Week")
				alert("There is no " + $('#selWeek').val() + " in a week for given date");
			else if (everySelectedOption == "Month")
				alert("There is no " + $('#selMonth').val() + " in a Month for given date");
		}
		between = [];
		if ($('#radioOpt').val() == "multiDateRadio") {
			$('#EveryRadio').attr('disabled', true);
		} else {
			$('#multiDateRadio').attr('disabled', true);
		}	
		updateTable(0)
		$("#corpus").val('');
		document.getElementById('sevaQty').value = 1;		
		$("#postage").prop('checked',false);
		$("#addLine1").val("");
		$("#addLine2").val("");
		$("#city").val("");
		$("#state").val("");
		$("#country").val("");
		$("#pincode").val("");
		$("#address").val("");
		$("#addLine1").attr("disabled", true);
		$("#addLine2").attr("disabled", true);
		$("#city").attr("disabled", true);
		$("#state").attr("disabled", true);
		$("#country").attr("disabled", true);
		$("#pincode").attr("disabled", true);
	}

	function compareSevaDateWithRevisionDate(sevaDate,revDate) {
		sevaDate = new Date(sevaDate.split("-").reverse());
		revDate = new Date(revDate.split("-").reverse());
		if(sevaDate >= revDate) 
			return 1;
		else 
			return 0;		
	}

	function updateTable(si) {
		if(si != 0) {
			let si1 = document.getElementsByClassName(si);
			si1[0].remove();
		}
		let tableValues = getTableValues();
		let total = 0;
		for (let i = 0; i < tableValues['sevaCombo'].length; ++i) {
			tableValues['si'][i].innerHTML = (i + 1);
			tableValues['link1'][i].innerHTML = '<a style="cursor:pointer;" onClick="updateTable(' + (i + 1) + ');"><img style="width:24px; height:24px;" title="delete" src="<?=base_url()?>images/delete1.svg"></a>';
			tableValues['si1'][i].className = (i + 1) + " si1";
			total += Number(tableValues['amt'][i].innerHTML.trim());
		}
		$('#totalAmount').html(total);

		let tableContent = getTableValues();

		if (tableContent['sevaName'].length == 0) {
			$('#EveryRadio').attr('disabled', false);
			$('#multiDateRadio').attr('disabled', false);
		}
	}

	$("#multiDate").datepicker({
		
		maxDate: maxDate,
		dateFormat: 'dd-mm-yy',
		onSelect: function (selectedDate) {
			let sevaCom = getSevaCombo();
			let revisionStatus = sevaCom.revision_status
			let revision_date = sevaCom.revision_date
			let oldPrice = sevaCom.old_price			
			let selVal = $('#sevaCombo :selected').html().split("=")
			if(revisionStatus == 1) {
				let currentDate = ($('#multiDate').val()).toString().substring(0,10)
				currentDate = currentDate.split("-").reverse();
				currentDate = new Date(currentDate)
				let newDate = new Date(revision_date.split("-").reverse())
				if(currentDate >= newDate) {
				} else { 
				}
			} else {
			}
			$('#selDate').html($('#multiDate').val());
			$('#multiDate').css('border-color', "#ccc");
		}
	});

	function checkDuplicate() {
		let duplicate = 0;
		return Number(duplicate);
	}

	$('.todayDate').on('click', function () {
		$("#multiDate").focus();
	});

	$(".chequeDate2").datepicker({
		dateFormat: 'dd-mm-yy'
	});

	$('.chequeDate').on('click', function () {
		$(".chequeDate2").focus();
	});
	
	
	$('#rashi').keyup(function () {
		var $th = $(this);
		$th.val($th.val().replace(/[^A-Za-z]/g, function (str) { return ''; }));
	});
	
	
	$('#nakshatra').keyup(function () {
		var $th = $(this);
		$th.val($th.val().replace(/[^A-Za-z]/g, function (str) { return ''; }));
	});
	$('#pincode').keyup(function (e) {
		var $th = $(this);
		if (e.keyCode != 46 && e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 38 && e.keyCode != 39 && e.keyCode != 40) {
			$th.val($th.val().replace(/[^0-9]/g, function (str) { return ''; }));
		} return;
	});
	
	$('#phone').keyup(function (e) {
		var $th = $(this);
		if (e.keyCode != 46 && e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 38 && e.keyCode != 39 && e.keyCode != 40) {
			$th.val($th.val().replace(/[^0-9]/g, function (str) { return ''; }));
		} return;
	});

	$('#phone2').keyup(function (e) {
		var $th = $(this);
		if (e.keyCode != 46 && e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 38 && e.keyCode != 39 && e.keyCode != 40) {
			$th.val($th.val().replace(/[^0-9]/g, function (str) { return ''; }));
		} return;
	});

	$('#corpus').keyup(function (e) {
		var $th = $(this);

		if (e.keyCode != 46 && e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 38 && e.keyCode != 39 && e.keyCode != 40) {
			$th.val($th.val().replace(/[^0-9]/g, function (str) { return ''; }));
		} return;
	});

	$('#mandalimemphone').keyup(function (e) {
		var $th = $(this);
		if (e.keyCode != 46 && e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 38 && e.keyCode != 39 && e.keyCode != 40) {
			$th.val($th.val().replace(/[^0-9]/g, function (str) { return ''; }));
		} return;
	});

	$('#mandalimemphone2').keyup(function (e) {
		var $th = $(this);
		if (e.keyCode != 46 && e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 38 && e.keyCode != 39 && e.keyCode != 40) {
			$th.val($th.val().replace(/[^0-9]/g, function (str) { return ''; }));
		} return;
	});

	$('#mandalimemprice').keyup(function (e) {
		var $th = $(this);
		if (e.keyCode != 46 && e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 38 && e.keyCode != 39 && e.keyCode != 40) {
			$th.val($th.val().replace(/[^0-9]/g, function (str) { return ''; }));
		} return;
	});

	$('#mandaliPhone').keyup(function (e) {
		var $th = $(this);
		if (e.keyCode != 46 && e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 38 && e.keyCode != 39 && e.keyCode != 40) {
			$th.val($th.val().replace(/[^0-9]/g, function (str) { return ''; }));
		} return;
	});

	$('#mandliPhone2').keyup(function (e) {
		var $th = $(this);
		if (e.keyCode != 46 && e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 38 && e.keyCode != 39 && e.keyCode != 40) {
			$th.val($th.val().replace(/[^0-9]/g, function (str) { return ''; }));
		} return;
	});

	function dateSelect() {
		$('#toDate').val("");
		$('#fromDate').val("");
		getBetweenDates();
		switch ($("#SelectOpt option:selected").text()) {
			case 'Day':
				$('#selWeek').hide();
				$('#selMonth').hide();
				everySelectedOption = "Day";
				break;
			case 'Week':
				$('#selWeek').fadeIn("slow");
				$('#selMonth').hide();
				everySelectedOption = "Week";
				break;
			case 'Month':
				$('#selWeek').hide();
				$('#selMonth').fadeIn("slow");
				everySelectedOption = "Month";
				break;
		}
	}

	$("#toDate").multiDatesPicker({
		minDate: minDate,
		maxDate: maxDate,
		dateFormat: 'dd-mm-yy'
	});

	function dateRange() {
		var currentTime = new Date()
		var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
		var maxDate = new Date(currentTime.getFullYear(), currentTime.getMonth() + 12, +0); // one day before next month
		$("#toDate").multiDatesPicker({
			minDate: minDate,
			maxDate: maxDate,
			dateFormat: 'dd-mm-yy'
		});
	}

	$('#toDate').on('change', function () {
		$('#toDate').css('border-color', "#ccc");
		getBetweenDates();
	});

	function getBetweenDates() {
		let sevaCom = getSevaCombo();
		let revisionStatus = sevaCom.revision_status
		let revision_date = sevaCom.revision_date
		let oldPrice = sevaCom.old_price
		let selVal = $('#sevaCombo :selected').html().split("=")
		
		var sDate1 = "";
		var start = $("#fromDate").multiDatesPicker("getDate");
		end = $("#toDate").multiDatesPicker("getDate");
		if (!end)
			return;

		if (!start)
			return;
		currentDate = new Date(start);
		if (currentDate > end) {
			alert("Please check your From and To date");
			return;
		}
		between = [];
		if ($("#SelectOpt option:selected").text() == "Week") {
			var weekday = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
			while (currentDate <= end) {
				var btnDate = (currentDate).toString();
				var SelectedDay = new Date(btnDate.split('/').reverse().join('/'));
				if (weekday[SelectedDay.getDay()] == $("#selWeek option:selected").text()) {
					between.push(("0" + currentDate.getDate()).slice(-2) + "-" + ("0" + (currentDate.getMonth() + 1)).slice(-2) + "-" + currentDate.getFullYear());
				}
				currentDate.setDate(currentDate.getDate() + 1);
			}
		} else if ($("#SelectOpt option:selected").text() == "Day") {
			//document.getElementById("displayPanel").innerHTML="";
			while (currentDate <= end) {
				var btnDate = (currentDate).toString();
				var SelectedDay = new Date(btnDate.split('/').reverse().join('/'));
				between.push(("0" + currentDate.getDate()).slice(-2) + "-" + ("0" + (currentDate.getMonth() + 1)).slice(-2) + "-" + currentDate.getFullYear());
				currentDate.setDate(currentDate.getDate() + 1);
			}
			for (var i = 0; i < between.length; ++i) {
				sDate1 += between[i] + "<br/>";
				console.log(between[i]);
			}
		} else if ($("#SelectOpt option:selected").text() == "Month") {
			while (currentDate <= end) {
				var btnDate = (currentDate).toString();
				if (currentDate.getDate() == $("#selMonth option:selected").text()) {
					between.push(("0" + currentDate.getDate()).slice(-2) + "-" + ("0" + (currentDate.getMonth() + 1)).slice(-2) + "-" + currentDate.getFullYear());
				}
				currentDate.setDate(currentDate.getDate() + 1);
			}
		}

		if (everySelectedOption == "Day") {
			seva_date = "Everyday from " + $('#fromDate').val() + " to " + $('#toDate').val();
			$('#selDate').html(seva_date);
		} else if (everySelectedOption == "Week") {
			seva_date = "Every " + $('#selWeek').val() + " from " + $('#fromDate').val() + " to " + $('#toDate').val();
			$('#selDate').html(seva_date);
		} else if (everySelectedOption == "Month") {
			// let mnth = getSuffix(Number($('#selMonth').val()))
			let mnth = getSuffix(Number($('#selMonth').val()))
			seva_date = mnth + " of Every Month from " + $('#fromDate').val() + " to " + $('#toDate').val();
			$('#selDate').html(seva_date);
		}
		
		if(revisionStatus == 1) {
			let cD = new Date(between[0].split("-").reverse())
			let newDate = new Date(revision_date.split("-").reverse())
			if(cD >= newDate) {
				$('#sevaCombo :selected').html(selVal[0] + " = &#8377; " +sevaCom.sevaPrice)
				$('#setPrice').html(sevaCom.sevaPrice);
				
			} else { $("#setPrice").html(oldPrice); $('#sevaCombo :selected').html(selVal[0] + " = &#8377; " +oldPrice)}
		} else {
			$('#sevaCombo :selected').html(selVal[0] + " = &#8377; " +sevaCom.sevaPrice)
			$('#setPrice').html(sevaCom.sevaPrice);
		}
	}

	function getSuffix(i) {
		var j = i % 10,
		k = i % 100;
		if (j == 1 && k != 11) {
			return i + "<sup>st</sup>";
		}
		if (j == 2 && k != 12) {
			return i + "<sup>nd</sup>";
		}
		if (j == 3 && k != 13) {
			return i + "<sup>rd</sup>";
		}
		return i + "<sup>th</sup>";
	}

	$("#fromDate").multiDatesPicker({
		minDate: minDate,
		maxDate: maxDate,
		dateFormat: 'dd-mm-yy',
		onSelect: function (selectedDate) {
			
			let sevaCom = getSevaCombo();
			let revisionStatus = sevaCom.revision_status
			let revision_date = sevaCom.revision_date
			let oldPrice = sevaCom.old_price
			let selVal = $('#sevaCombo :selected').html().split("=")
			if(revisionStatus == 1) {
				let currentDate = (selectedDate).toString().substring(0,10)
				currentDate = currentDate.split("-").reverse();
				currentDate = new Date(currentDate)
				let newDate = new Date(revision_date.split("-").reverse())
				if(currentDate >= newDate) {
					$('#sevaCombo :selected').html(selVal[0] + " = &#8377; " +sevaCom.sevaPrice)
					$('#setPrice').html(sevaCom.sevaPrice);
					
				}else { $("#setPrice").html(oldPrice); $('#sevaCombo :selected').html(selVal[0] + " = &#8377; " +oldPrice)}
			}else {
				$('#sevaCombo :selected').html(selVal[0] + " = &#8377; " +sevaCom.sevaPrice)
				$('#setPrice').html(sevaCom.sevaPrice);
			}
			$('#toDate').multiDatesPicker('setDate', null);
			$('#fromDate').css('border-color', "#ccc");
		}
	});

	function getSevaCombo() {
		let sevaCombo = $('#sevaCombo option:selected').val();
		sevaCombo = sevaCombo.split("|");		
		let sevaPrice = sevaCombo[4]
		return {
			deityId: sevaCombo[0],
			sevaId: sevaCombo[1],
			sevaName: sevaCombo[2],
			userId: sevaCombo[3],
			sevaPrice: sevaPrice,
			quantityChecker: sevaCombo[5],
			isSeva: sevaCombo[6],
			old_price: sevaCombo[7],
			revision_status: sevaCombo[8],
			revision_date: sevaCombo[9],
			shashPrice: sevaCombo[11]	
		}
	}

	function getTableValues() {
		let si1 = document.getElementsByClassName('si1');
		let si = document.getElementsByClassName('si');
		let sevaCombo = document.getElementsByClassName('sevaCombo');
		let corpus = document.getElementsByClassName('corpus');
		let date = document.getElementsByClassName('date');
		let dateMonth1 = document.getElementsByClassName('dateMonth1');
		let price = document.getElementsByClassName('price');
		let purpose = document.getElementsByClassName('purpose');
		let amt = document.getElementsByClassName('amt');
		let link1 = document.getElementsByClassName('link1');
		let sevaName = document.getElementsByClassName('sevaName');
		let sevaQty = document.getElementsByClassName('sevaQty');
		let deityName = document.getElementsByClassName('deityName');
		let sevaId = document.getElementsByClassName('sevaId');
		let userId = document.getElementsByClassName('userId');
		let deityId = document.getElementsByClassName('deityId');
		let quantityChecker = document.getElementsByClassName('quantityChecker');
		let isSeva = document.getElementsByClassName('isSeva');
		let revFlag = document.getElementsByClassName("revFlag");
		let thithi = document.getElementsByClassName("thithi");
		let masa1 = document.getElementsByClassName("masa1");
		let bomcode1 = document.getElementsByClassName("bomcode1");
		let thithiName1 = document.getElementsByClassName("thithiName1");
		let address = document.getElementsByClassName("address");
		let postage = document.getElementsByClassName("postage1");
		let addressLine1 = document.getElementsByClassName("addLine1");
		let addressLine2 = document.getElementsByClassName("addLine2");
		let city = document.getElementsByClassName("city1");
		let state = document.getElementsByClassName("state");
		let country = document.getElementsByClassName("country");
		let pincode = document.getElementsByClassName("pincode");	
		let calType1 = document.getElementsByClassName("calType1");	
		let periodId = document.getElementsByClassName("periodId");
		let periodName = document.getElementsByClassName("periodName");
		let everyweekMonth = document.getElementsByClassName("everyweekMonth");

		return {
			si1: si1,
			si: si,
			sevaCombo: sevaCombo,
			sevaName: sevaName,
			sevaQty: sevaQty,
			corpus: corpus,
			thithi:thithi,
			masa1:masa1,
			bomcode1:bomcode1,
			thithiName1:thithiName1,
			date: date,
			dateMonth1:dateMonth1,
			price: price,
			purpose:purpose,
			amt: amt,
			deityName: deityName,
			link1: link1,
			sevaId: sevaId,
			userId: userId,
			deityId: deityId,
			isSeva: isSeva,
			quantityChecker: quantityChecker,
			revFlag: revFlag,
			address: address,
			postage: postage,
			addressLine1: addressLine1,
			addressLine2: addressLine2,
			city: city,
			state: state,
			country: country,
			pincode: pincode,
			calType1:calType1,
			periodId:periodId,
			periodName:periodName,
			everyweekMonth:everyweekMonth
		}
	}
</script>
<script>
	function openCity(evt, cityName) {		
		if(next == ""){
			return false;
		} else {
			var i, x, tablinks;
			x = document.getElementsByClassName("city");
			for (i = 0; i < x.length; i++) {
				x[i].style.display = "none";
			}
			tablinks = document.getElementsByClassName("tablink");
			for (i = 0; i < x.length; i++) {
				tablinks[i].className = tablinks[i].className.replace(" w5-border-red", "");
			}
			document.getElementById(cityName).style.display = "block";
			evt.currentTarget.firstElementChild.className += " w5-border-red"; 
			return true;
		}
	}
	
	//To go to second tab when click to next button
	var next = "";
	function goToTabShashwathSevaDetails() {
		next = 1;
		var i, x, tablinks;
		x = document.getElementsByClassName("city");
		for (i = 0; i < x.length; i++) {
			x[i].style.display = "none";
		}
		tablinks = document.getElementsByClassName("tablink");
		for (i = 0; i < x.length; i++) {
			if(tablinks[i].textContent == "Shashwath Seva Details") 
				tablinks[i].className += " w5-border-red";
			else 
				tablinks[i].className = tablinks[i].className.replace(" w5-border-red", "");
		}
		document.getElementById('3').style.display = "block";
		if(($('#ismandali').prop('checked')) == false){
			document.getElementById("ismandali").checked = false;
		} else {
				document.getElementById("ismandali").checked = true;
		} 
	 
	}

	function goToTabMandaliMemberDetails() {
		next = 1;
		var i, x, tablinks;
		x = document.getElementsByClassName("city");
		for (i = 0; i < x.length; i++) {
			x[i].style.display = "none";
		}
		tablinks = document.getElementsByClassName("tablink");
		for (i = 0; i < x.length; i++) {
			if(tablinks[i].textContent == "Mandali Member Details") 
				tablinks[i].className += " w5-border-red";
			else 
				tablinks[i].className = tablinks[i].className.replace(" w5-border-red", "");
		}
		document.getElementById('2').style.display = "block";
	 	document.getElementById("ismandali").checked = true;
	}

	//festival starts
	document.getElementById('HinduCal').style.display = "block";
	document.getElementById('GregorianCal').style.display = "none";
	document.getElementById('FestvalCal').style.display = "none";
	document.getElementById('EveryWeekMonth').style.display = "none";

	function calendarHindu() { 
		document.getElementById('HinduCal').style.display = "block";
		document.getElementById('GregorianCal').style.display = "none";
		document.getElementById('FestvalCal').style.display = "none";
		document.getElementById('EveryWeekMonth').style.display = "none";		  
	} 
	function calendarGregorian() {
		document.getElementById('HinduCal').style.display = "none";
		document.getElementById('GregorianCal').style.display = "block";
		document.getElementById('FestvalCal').style.display = "none";
		document.getElementById('EveryWeekMonth').style.display = "none";
	} 
	function calendarFestivalwise() {
		document.getElementById('HinduCal').style.display = "none";
		document.getElementById('GregorianCal').style.display = "none";
		document.getElementById('FestvalCal').style.display = "block";
		document.getElementById('EveryWeekMonth').style.display = "none";
	} 
	function EveryWeekMonthwise() {
		document.getElementById('HinduCal').style.display = "none";
		document.getElementById('GregorianCal').style.display = "none";
		document.getElementById('FestvalCal').style.display = "none";
		document.getElementById('EveryWeekMonth').style.display = "block";
	}

	// festival ends	
	$( ".receiptLine2" ).datepicker({ 
		dateFormat: 'dd-mm-yy',
		changeYear: true,
		changeMonth: true,
		yearRange: "1850:+400"
	});

	$('.receiptLine2').on('click', function() {
		$( ".receiptLine2" ).focus();
	});
	
	function showMandaliDetails() {
  		var checkBox = document.getElementById("ismandali");
	  	if (checkBox.checked == true){
	     	document.getElementById("isMandaliDiv").style.display = "block";
	     	document.getElementById("mandaliMembId").style.display = "block"; 	
	     	document.getElementById("isMemberDiv").style.display = "none";
	     	document.getElementById("postageId").style.display = "none";
	   	} else {
	     	document.getElementById("isMemberDiv").style.display = "block";
	     	document.getElementById("postageId").style.display = "block";
	     	document.getElementById("mandaliMembId").style.display = "none";
	     	document.getElementById("isMandaliDiv").style.display = "none";
	  	}
	}

	function addRow1() {
		let tableContent1 = getMandaliTableValues1();
        let name = $('#mandalimemname').val()
        let number = $('#mandalimemphone').val()
        let number2 = $('#mandalimemphone2').val()
        let rashi = $('#mandalimemrashi').val()
        let nakshatra = $('#mandalimemnakshatra').val();
        let gotra = $('#mandalimemGotra').val();
        let remarks = $('#mandalimemsmremarks').val().trim();
        let addLine1 = $('#mandalimemaddLine1').val().trim(); 
        let addLine2 = $('#mandalimemaddLine2').val().trim();
        let city = $('#mandalimemcity').val().trim();
        let state = $('#mandalimemstate').val().trim();
        let country = $('#mandalimemcountry').val().trim();
        let pincode = $('#mandalimempincode').val();
        let address = "";
        let counter = 0;
        let mandaliName= $('#mandaliName').val().trim();
		let mandaliPhone= $('#mandaliPhone').val();
		let mandliPhone2= $('#mandliPhone2').val();
		let mandliRemarks= $('#mandliRemarks').val().trim();
		let mandliAddrline1= $('#mandliAddrline1').val().trim();
		let mandliAddrline2= $('#mandliAddrline2').val().trim();
		let mandlicity= $('#mandlicity').val().trim();
		let mandliState= $('#mandliState').val().trim();
		let mandliCountry= $('#mandliCountry').val().trim();
		let mandliPin= $('#mandliPin').val();
    	if (name) {
			$('#mandalimemname').css('border-color', "#ccc")

		} else {
			$('#mandalimemname').css('border-color', "#FF0000")
			++counter;
		}
		if (number) {
			$('#mandalimemphone').css('border-color', "#ccc")

		} else {
			$('#mandalimemphone').css('border-color', "#FF0000")
			++counter;
		}
		if (addLine1) {
			$('#mandalimemaddLine1').css('border-color', "#ccc")

		} else {
			$('#mandalimemaddLine1').css('border-color', "#FF0000")
			++counter;
		}
		if (state) {
			$('#mandalimemstate').css('border-color', "#ccc")

		} else {
			$('#mandalimemstate').css('border-color', "#FF0000")
			++counter;
		}
		if (country) {
			$('#mandalimemcountry').css('border-color', "#ccc")

		} else {
			$('#mandalimemcountry').css('border-color', "#FF0000")
			++counter;
		}
		if(addLine1.length > 0) {
				address += addLine1 + ", ";
			} else {
				counter++;
			}if(addLine2.length > 0) {
				address += addLine2 + ", ";
			}if(city.length > 0) {
				address += city + ", ";
			}if(state.length > 0) {
				address += state + ", ";
			} else {
				counter++;
			}if(country.length > 0) {
				address += country + ", ";
			} else {
				counter++;
			}if(pincode.length > 0) 
				address += pincode + ", ";
		if (counter != 0) {
			alert("Information", "Please fill required fields", "OK");
			return;
		}  

		$('#address').val(address);

		let si = $('#eventSeva1 tr:last-child td:first-child').html();
		if (!si)
			si = 1
		else
			++si;
		if(($('#ispostage').prop('checked')) == false){
			$('#ispostage').attr("value", "NO");
		} else {
			$('#ispostage').attr("value", "YES");
		} 
		var vals = $('#ispostage').val(); 
		$('#eventSeva1').append('<tr class="' + si + ' siMandali1"><td class="siMandali">' + si + '</td><td class="nameMandali">' + name + '</td><td class="numberMandali">' + number + '</td><td class="number2Mandali"  style="display:none;">' + number2 + '</td><td class="rashiMandali">' + rashi + '</td><td class="nakshatraMandali">' + nakshatra + '</td><td class="gotraMandali">'+gotra+'</td><td class="addressMandali" >'+ address +'</td><td class="remarksMandali">'+ remarks +'</td><td class="addLine1Mandali" style="display:none;">'+ addLine1 +'</td><td class="addLine2Mandali" style="display:none ;">'+ addLine2 +'</td><td class="ispostage1">'+ vals +'</td><td class="cityMandali" style="display:none;">'+ city +'</td><td class="stateMandali" style="display:none;">'+ state +'</td><td class="countryMandali" style="display:none;">'+ country +'</td><td class="pincodeMandali" style="display:none;">'+ pincode +'</td><td class="mandaliName"  style="display:none;" >' + mandaliName + '</td><td class="mandaliPhone"  style="display:none;" >' + mandaliPhone + '</td><td class="mandliPhone2"  style="display:none;">' + mandliPhone2 + '</td><td class="mandliRemarks" style="display:none;">'+ mandliRemarks +'</td><td class="mandliAddrline1" style="display:none;">'+ mandliAddrline1 +'</td><td class="mandliAddrline2" style="display:none ;">'+ mandliAddrline2 +'</td><td class="mandlicity" style="display:none;">'+ mandlicity +'</td><td class="mandliState" style="display:none;">'+ mandliState +'</td><td class="mandliCountry" style="display:none;">'+ mandliCountry +'</td><td class="mandliPin" style="display:none;">'+ mandliPin +'</td><td class="link1" ><a style="cursor:pointer;" onClick="updateTable(' + si + ');"><img style="width:24px; height:24px;" title="delete" src="<?=base_url()?>images/delete1.svg"></a></td></tr>');
				si++;
		$("#mandalimemname").val("");
		$("#mandalimemphone").val("");
		$("#mandalimemphone2").val("");
		$("#mandalimemrashi").val("");
		$("#mandalimemnakshatra").val("");
		$("#mandalimemGotra").val("");
		$("#mandalimemsmremarks").val("");
		$("#mandalimemaddLine1").val("");
		$("#mandalimemaddLine2").val("");
		$("#mandalimemcity").val("");
		$("#mandalimemstate").val("");
		$("#mandalimemcountry").val("");
		$("#mandalimempincode").val("");
	//	$("#mandalimemprice").val("");
	 	document.getElementById("ispostage").checked = false;

	}
	function getMandaliTableValues1() {
		let si1 = document.getElementsByClassName('siMandali1');
		let si = document.getElementsByClassName('siMandali');
		let name = document.getElementsByClassName("nameMandali");	
		let number = document.getElementsByClassName("numberMandali");	
		let number2 = document.getElementsByClassName("number2Mandali");	
		let rashi = document.getElementsByClassName("rashiMandali");	
		let nakshatra = document.getElementsByClassName("nakshatraMandali");	
		let gotra = document.getElementsByClassName("gotraMandali");	
		let remarks = document.getElementsByClassName("remarksMandali");	
		let address = document.getElementsByClassName("addressMandali");
		let postage = document.getElementsByClassName("postage1");
		let addressLine1 = document.getElementsByClassName("addLine1Mandali");
		let addressLine2 = document.getElementsByClassName("addLine2Mandali");
		let city = document.getElementsByClassName("cityMandali");
		let state = document.getElementsByClassName("stateMandali");
		let country = document.getElementsByClassName("countryMandali");
		let pincode = document.getElementsByClassName("pincodeMandali");
		let ispostage = document.getElementsByClassName("ispostage1");

		return {
			si1: si1,
			si: si,
			name:name,
			number:number,
			number2:number2,
			remarks:remarks,
			rashi:rashi,
			nakshatra:nakshatra,
			gotra:gotra,
			remarks:remarks,
			address: address,
			postage: postage,
			addressLine1: addressLine1,
			addressLine2: addressLine2,
			city: city,
			state: state,
			country: country,
			pincode: pincode,
			ispostage:ispostage
		}
	}

    $(document).ready(function() { 
    //To focus modal textbox
    $(document).on("click", "a.add" , function(e) {  
        $(document).ready(function () {
            $('.ledger').change(function () {
                if ($('.ledger option[value="' + $(this).val() + '"]:selected').length > 1) {
                  $(this).val('').change();
                 let pos = this.id.split('_')[1];
                 $('#curBal_'+ pos).html("");
                  return;
            }
        }); 
    });              
    if($('#ledger_'+e.currentTarget.id.split("_")[1]).prop('selectedIndex') == 0) {
        $('#ledger_'+e.currentTarget.id.split("_")[1]).css("border-color","#ff0000");
        alert("Information","Please fill required fields in red");
        return;
    }

    if($('#type_'+e.currentTarget.id.split("_")[1]+' option:selected').text() == "FROM") {
        if($('#debit_'+e.currentTarget.id.split("_")[1]).val() == "" || $('#debit_'+e.currentTarget.id.split("_")[1]).val() == "0") {
            $('#debit_'+e.currentTarget.id.split("_")[1]).css("border-color","#ff0000");
            alert("Information","Please fill required fields in red");
            return;
        }                     
    } else {
        if($('#credit_'+e.currentTarget.id.split("_")[1]).val() == "" || $('#credit_'+e.currentTarget.id.split("_")[1]).val() == "0") {
            $('#credit_'+e.currentTarget.id.split("_")[1]).css("border-color","#ff0000");
            alert("Information","Please fill required fields in red");
            return;  
        }    
    }

    if(parseInt(($('#ledger_'+e.currentTarget.id.split("_")[1]).val()).split('|')[1]) < parseInt(($('#debit_'+e.currentTarget.id.split("_")[1]).val()+ $('#credit_'+e.currentTarget.id.split("_")[1]).val()))) {
        alert("Information","Insufficient Balance");
        return;
    } 

    if(!parseInt(($('#ledger_'+e.currentTarget.id.split("_")[1]).val()).split('|')[1])) {
        alert("Information","Insufficient Balance");
        return;
    }               

    $('#ledger_'+e.currentTarget.id.split("_")[1]).css("border-color","#ccc");
    $("#addNewDiv").append('<div id="idChildContactDiv_'+(parseInt(e.currentTarget.id.split("_")[1])+1)+'" style="padding-top:15px;" class ="row alignContactDiv">     <div class="control-group col-lg-2 col-md-3 col-sm-3 col-xs-3"><select id="type_'+(parseInt(e.currentTarget.id.split("_")[1])+1)+'" name="type"  class="form-control label_size" disabled style="-webkit-appearance: none;-moz-appearance: none;text-indent: 1px;" ><option value="from"  >FROM</option></select></div><div class="control-group col-lg-6 col-md-3 col-sm-3 col-xs-3"> <select id="ledger_'+(parseInt(e.currentTarget.id.split("_")[1])+1)+'"  name="ledger" class="form-control label_size ledger" onChange="getLedgerChange(id)"><option value="">Select Ledger</option><?php   if(!empty($ledger)) { foreach($ledger as $row1) { ?> <option value="<?php echo $row1->FGLH_ID;?>|<?php echo $row1->BALANCE;?>|<?php echo str_replace("'","\'",$row1->FGLH_NAME);?>"><?php echo str_replace("'","\'",$row1->FGLH_NAME);?></option><?php } } ?></select><label for="curBal" value="">Cur Bal:<span id="curBal_'+(parseInt(e.currentTarget.id.split("_")[1])+1)+'"></span></label> </div>    <div class="control-group col-lg-2 col-md-3 col-sm-3 col-xs-3">  <input type="text" class="dec form-control amounts text-right " name="number" autocomplete="off" id="debit_'+(parseInt(e.currentTarget.id.split("_")[1])+1)+'" style="width:100%" onkeyup="getCheckedEditedFields(id)" onkeypress="return validateFloatKeyPress(this,event);"/> </div>          <div id="remove" class="control-group col-lg-1 col-md-1 col-sm-1 col-xs-1 "><a style="text-decoration:none;cursor:pointer;" class="removeContact" id="removeContact_'+(parseInt(e.currentTarget.id.split("_")[1])+1)+'" ><img style="width:24px;height:24px" src="<?=site_url();?>images/delete1.svg"/></a></div><div id="add" class="control-group col-lg-1 col-md-1 col-sm-1 col-xs-1"> <a style="text-decoration:none;cursor:pointer;" class="add" id="add_'+(parseInt(e.currentTarget.id.split("_")[1])+1)+'" onclick="getFinalData()"><img style="width:24px;height:24px"  src="<?=site_url();?>images/add_icon.svg"/></a></div></div>');

        $('#'+e.currentTarget.id).hide();                  

    }); 
	 
    $(document).on("click", "a.removeContact" , function(e) {
        e.preventDefault();
        var clickPos = 0, count = 0;
        $('.ledger').each(function(i, ele) {
            if(ele.id.split('_')[1] == e.currentTarget.id.split('_')[1]) {                      
                clickPos = i+1;  
            }
            count++;
        });
        $(this).parents(".alignContactDiv").remove();
        if(clickPos == count)
            $('#add_'+(parseInt(e.currentTarget.id.split("_")[1])-1)).show();
        	getFinalData();
    }); 
    });

    function alphaonlypurpose(input) {
      var regex=/[^-a-z-0-9 ]/gi;
      input.value=input.value.replace(regex,"");
    }

    function getFinalData() {
        let debit=0,credit=0,debitAmt=0,creditAmt=0;
        $(".amounts").each(function(i, ele) {
            if(ele.id.split('_')[0] == "debit") {
                debit = Number($('#'+ele.id).val());
                debitAmt += debit;
            } else {
                credit = $('#'+ele.id).val();
                credit = Number($('#'+ele.id).val()); 
                creditAmt += credit;
            }
        });
        $('#debitTot').val(debitAmt); 
        // $('#creditTot').val(creditAmt);
    }

    function validateFloatKeyPress(el, evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        var number = el.value.split('.');
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        if(number.length>1 && charCode == 46){
            return false;
        }
        var text = $(el).val();

        if ((text.indexOf('.') != -1) &&
            (text.substring(text.indexOf('.')).length > 2) &&
            (evt.which != 0 && evt.which != 8) &&
            ($(el)[0].selectionStart >= text.length - 2)) {
            event.preventDefault();
        }

        getFinalData();
        return true;
    }

    function getLedgerChange(id) {
        if($('#'+id).prop('selectedIndex') == 0) {
            $('#'+id).css("border-color","#ff0000");
            alert("Information","Ledger Cannot be same as the previously selected ledger");
            return;
        } else {
            $('#'+id).css("border-color","#ccc"); 
        }

        let pos = id.split('_')[1];
        let curLedger = document.getElementById(id).value.split("|");    
        $('#curBal_'+ pos).html(curLedger[1]);

        if(parseInt(($('#'+id).val()).split('|')[1]) < parseInt(($('#debit_'+id.split("_")[1]).val() + $('#credit_'+id.split("_")[1]).val()))) {
            alert("Information","Insufficient Balance");
            $('#debit_'+id.split("_")[1]).val("");
            $('#credit_'+id.split("_")[1]).val("");
            getFinalData();
            return;
        }
    }

    function getCheckedEditedFields(id) {
        if($('#'+id).val() != "") {
            $('#'+id).css("border-color","#ccc");
        } else {
            $('#'+id).css("border-color","#ff0000");
        }

        if(id.split("_")[0]!="credit"){
            if(parseInt(($('#ledger_'+id.split("_")[1]).val()).split('|')[1]) < parseInt($('#'+id).val())) {
                alert("Information","Insufficient Balance");
                $('#'+id).val("");
                getFinalData();
                return;
            }
        }
        getFinalData();
    }

    var currentTime = new Date()
    var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
    var maxDate =  new Date(); // one day before next month
    $( ".todayDate2" ).datepicker({ 
        // minDate: minDate, 
        // maxDate: maxDate,
        'yearRange': "2007:+50",
        dateFormat: 'dd-mm-yy',
        changeMonth:true,
        changeYear:true
    });
     
    $('.todayDate').on('click', function() {
    $( ".todayDate2" ).focus();
    })

    function onCommitteeChange(){
        $('#frmCommitteeChange').submit();   
    }

</script>