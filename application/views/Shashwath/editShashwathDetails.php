<?php error_reporting(0);?>
<div style="clear:both;" class="container">
	<img class="img-responsive bgImg2 bg1" src="<?=site_url()?>images/TempleLogo.png" />
	<div class="row form-group">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="row form-group">							
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
					<span class="eventsFont2">Edit Member Details</span>			

					<div class="col-lg-8 col-md-6 col-sm-4 col-xs-12 pull-right text-right" style="padding:0px 0px 0px;">
						<?php if(isset($_SESSION['member_actual_link'])) { ?>
							<a style="margin-left: 9px;pull-right;" href="<?=$_SESSION['member_actual_link'] ?>" title="Back"><img style="width:24px; height:24px" src="<?=site_url();?>images/back_icon.svg"/></a>
						<?php } ?>
					</div>
				</div>
			</div>	
			<div style="clear:both;" class="w5-row"> 
				<?php $i = 1;$j = 40;$name = array('Shashwath Member','Mandali Member Details','Shashwath Seva Details');
				for($k =0 ; $k<3 ;$k++) { ?>
					<a href="#" id="click" onclick="return openCity(event, '<?=$i++;?>');">
						<div id="<?=$j--;?>" class="w5-third tablink w5-bottombar w5-hover-light-grey w5-padding"><?php echo $name[$k];?></div>
					</a>
				<?php } ?>
			</div><br/>	
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-left:0px;">	
				<div id="1" class="w5-container city">
					<div  id="isMemberDiv" >	
						<div class= "col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class= "col-lg-12 col-md-6 col-sm-12 col-xs-9" style="padding-top:25px;">
								<div class="form-group" >
									<label for="name">Name<span style="color:#800000;">*</span></label>
									<input autocomplete="none" type="text" class="form-control form_contct2" id="name" onkeyup="alphaonly(this)" placeholder="" name="name" value="<?php echo str_replace('"','&#34;',$members[0]->SM_NAME); ?>"/>
								</div>
							</div>

							<div class= "col-lg-6 col-md-6 col-sm-12 col-xs-9" style="padding-top:25px;">
								<div class="form-group">
									<label for="number">Number<span style="color:#800000;">*</span></label>
									<input autocomplete="none" type="text" class="form-control form_contct2" id="phone" placeholder="" name="phone" value="<?php echo $members[0]->SM_PHONE;?>"/>
								</div>
							</div>
							<div class= "col-lg-6 col-md-6 col-sm-12 col-xs-9" style="padding-top:25px;">
								<div class="form-group">
									<label for="number">Additional Number</label>
									<input autocomplete="none" type="text" class="form-control form_contct2" id="phone2" placeholder="" name="phone2" value="<?php echo $members[0]->SM_PHONE2;?>"/>
								</div>
							</div>
							<div class= "col-lg-6 col-md-6 col-sm-12 col-xs-9" style="padding-top:25px;">
								<div class="form-group">
									<label for="rashi">Rashi</label>
									<input autocomplete="none" type="hidden" id="baseurl" name="baseurl" value="<?php echo site_url(); ?>" />
									<div class="dropdown">
										<input autocomplete="off" type="text" class="form-control form_contct2" id="rashi" placeholder="" name="rashi" value="<?php echo $members[0]->SM_RASHI;?>"/>
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
										<input autocomplete="off" type="text" class="form-control form_contct2" id="nakshatra" placeholder="" name="nakshatra" value="<?php echo $members[0]->SM_NAKSHATRA;?>"/>
										<ul class="dropdown-menu txtpin1" style="margin-left:0px;margin-right:0px;max-height:400px;" role="menu" aria-labelledby="dropdownMenu"  id="Dropdownnakshatra">
										</ul>
									</div>
								</div>
							</div>
							<div class= "col-lg-12 col-md-12 col-sm-12 col-xs-9" style="padding-top:20px;">
								<div class="form-group">
									<label for="gotra">Gotra </label>
									<input autocomplete="off" type="hidden" id="baseurl" name="baseurl" value="<?php echo site_url(); ?>" />
									<div class="dropdown">
										<input autocomplete="off" type="text" class="form-control form_contct2" id="gotra" placeholder="" name="Gotra" value="<?php echo $members[0]->SM_GOTRA;?>"/>
										<ul class="dropdown-menu txtpin1" style="margin-left:0px;margin-right:0px;max-height:400px;" role="menu" aria-labelledby="dropdownMenu"  id="Dropdowngotra">
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class= "col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class= "col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:25px;">
								<div class="form-group">
									<label for="name">Address<span style="color:#800000;">*</span></label>
									<input autocomplete="none" type="text" class="form-control form_contct2" id="addrline1" placeholder="Address Line1" name="name" value="<?php echo str_replace('"','&#34;',$members[0]->SM_ADDR1);?>" maxlength="32" onkeyup="alphaonlyAdrs(this)"/>
								</div>
							</div>
							<div class= "col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="form-group">
									<input autocomplete="none" type="text" class="form-control form_contct2" id="addrline2" placeholder="Address Line2" name="name" value="<?php echo str_replace('"','&#34;',$members[0]->SM_ADDR2);?>" maxlength="32" onkeyup="alphaonlyAdrs(this)"/>
								</div>
							</div>
							<div class= "col-lg-12 col-md-4 col-sm-4 col-xs-12">
								<div class="form-group">
									<input autocomplete="none" type="text" class="form-control form_contct2" id="smcity" placeholder="City" name="name" value="<?php echo $members[0]->SM_CITY;?>" maxlength="32" onkeyup="alphaonlyAdrs(this)"/>
								</div>
							</div>
							<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<div class="form-group">
									<input autocomplete="none" type="text" class="form-control form_contct2" id="smstate" placeholder="State" name="name" value="<?php echo $members[0]->SM_STATE;?>" maxlength="32" onkeyup="alphaonlyAdrs(this)"/>
								</div>
							</div>
							<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<div class="form-group">
									<input autocomplete="none" type="text" class="form-control form_contct2" id="smcountry" placeholder="Country" name="name" value="<?php echo $members[0]->SM_COUNTRY;?>" maxlength="32" onkeyup="alphaonlyAdrs(this)"/>
								</div>
							</div>
							<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<div class="form-group">
									<input autocomplete="none" type="text" class="form-control form_contct2" id="smpin" oninput="inputPincode(this.value)" placeholder="PinCode" name="name" value="<?php echo $members[0]->SM_PIN;?>"/><br/>
								</div>
							</div>
						</div>
						<div class= "col-lg-6 col-md-6 col-sm-6 col-xs-12" style="padding-left:30px;">
							<label for="comment">Remarks: </label>
							<textarea class="form-control" rows="5" style="resize:none;" onkeyup="alphaonlypurpose(this)" id="smremarks"><?php echo $members[0]->REMARKS;?></textarea>
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
					<div id="isMandaliDiv"  hidden>
						<div class= "col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class= "col-lg-12 col-md-6 col-sm-12 col-xs-9" style="padding-top:25px;">
								<div class="form-group" >
									<label for="name">Mandali Name<span style="color:#800000;">*</span></label>
									<input autocomplete="none" type="text" class="form-control form_contct2" id="mandaliName" placeholder="" name="mandaliName" onkeyup="alphaonly(this)" value="<?php echo str_replace('"','&#34;',$members[0]->SM_NAME);?>"/>
								</div>
							</div>

							<div class= "col-lg-6 col-md-6 col-sm-12 col-xs-9" style="padding-top:25px;">
								<div class="form-group">
									<label for="number">Number<span style="color:#800000;">*</span></label>
									<input autocomplete="off" type="text" class="form-control form_contct2" id="mandaliPhone" placeholder="" name="mandaliPhone"  value="<?php echo $members[0]->SM_PHONE;?>"/>
								</div>
							</div>
							<div class= "col-lg-6 col-md-6 col-sm-12 col-xs-9" style="padding-top:25px;">
								<div class="form-group">
									<label for="number">Additional Number</label>
									<input autocomplete="off" type="text" class="form-control form_contct2" id="mandliPhone2" placeholder="" name="mandliPhone2"  value="<?php echo $members[0]->SM_PHONE2;?>"/>
								</div>
							</div>
							<div class= "col-lg-12 col-md-6 col-sm-12 col-xs-9" style="padding-top:25px;">
								<div class="form-group">
									<label for="comment">Remarks: </label>
									<textarea class="form-control" rows="5" style="resize:none;" onkeyup="alphaonlypurpose(this)" id="mandliRemarks"><?php echo $members[0]->REMARKS;?></textarea>

								</div>
							</div> 
						</div>
						<div class= "col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class= "col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="form-group">
									<label for="name">Address<span style="color:#800000;">*</span></label>
									<input autocomplete="none" type="text" class="form-control form_contct2" id="mandliAddrline1" placeholder="Address Line1" name="mandliAddrline1" value="<?php echo str_replace('"','&#34;',$members[0]->SM_ADDR1);?>" maxlength="32" onkeyup="alphaonlyAdrs(this)"/>
								</div>
							</div>
							<div class= "col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="form-group">
									<input autocomplete="none" type="text" class="form-control form_contct2" id="mandliAddrline2" placeholder="Address Line2" name="mandliAddrline2"  value="<?php echo str_replace('"','&#34;',$members[0]->SM_ADDR2);?>" maxlength="32" onkeyup="alphaonlyAdrs(this)"/>
								</div>
							</div>
							<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<div class="form-group">
									<input autocomplete="none" type="text" class="form-control form_contct2" id="mandlicity" placeholder="City" name="mandlicity" value="<?php echo $members[0]->SM_CITY;?>" maxlength="32" onkeyup="alphaonlyAdrs(this)"/>
								</div>
							</div>
							<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<div class="form-group">
									<input autocomplete="none" type="text" class="form-control form_contct2" id="mandliState" placeholder="State" name="mandliState" value="<?php echo $members[0]->SM_STATE;?>" maxlength="32" onkeyup="alphaonlyAdrs(this)"/>
								</div>
							</div>
							<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<div class="form-group">
									<input autocomplete="none" type="text" class="form-control form_contct2" id="mandliCountry" placeholder="Country" name="mandliCountry" value="<?php echo $members[0]->SM_COUNTRY;?>" maxlength="32" onkeyup="alphaonlyAdrs(this)"/>
								</div>
							</div>
							<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<div class="form-group">
									<input autocomplete="none" type="text" class="form-control form_contct2" id="mandliPin" oninput="inputPincodeMandali(this.value,this.id)" placeholder="Pincode" name="mandliPin" value="<?php echo $members[0]->SM_PIN;?>"/><br/>
								</div>
							</div>
						</div>

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:80px;">
							<div class="container-fluid">
								<center>
									<button type="button" onclick = "goToTabMandaliMemberDetails();" class="btn btn-default btn-lg">
										Next  <span class="glyphicon glyphicon-forward"></span>
									</button>
								</center>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="3" class="w5-container city" hidden>
			<div class="container">
				<img class="img-responsive bgImg2 bg1" src="<?=site_url()?>images/TempleLogo.png" />
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
					<div class="col-lg-12ss col-md-8 col-sm-8 col-xs-12">
						<div class="form-group">
							<label for="name">Name : <?php echo str_replace('"','&#34;',$members[0]->SM_NAME); ?></label>
						</div>
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
									<label for="sevaAmount">Corpus Amount:<span style="color:#800000;">*</span><br/></label>
									<input autocomplete="none" type="text" class="form-control form_contct2" id="corpus" placeholder="" name="name" value=""/>
								</div>
							</div>
						</div><br/>
						<div class="row">
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
								<div class="form-group">
									<label for="sevaCombo">Seva<span style="color:#800000;">*</span></label>&emsp;&emsp;<label style="float:right;font-size: 12px;"><span style="color:#800000;" id="minAmt"></span><span style="color:#800000;" id="Sqty"></span><span style="color:#800000;" id="totMinAmt"></span></label>
									<select onChange="sevaComboChange();" id="sevaCombo" class="form-control"></select>
									<label for="sevaAmount" id="revDate" style="display:none;float:right;">
										<span style="color:#800000;">* <span style="font-size: 12px;" id="revRate"></span></span>
									</label>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<div class="form-group">
									<label for="periodCombo">Selection of Period<span style="color:#800000;">*</span></label>
									<select id="periodCombo" class="form-control" style="width: 185px;">
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
							<label for="sevaQty">Quantity<span style="color:#800000;">*</span></label><br/>
							<input style="width:70px;font-size:24px;border-color:#000000;" type="text" value="1" oninput = "inputQuantity(this.value)" class="form-control form_contct2" id="sevaQty" placeholder="1" name="sevaQty" />
						</div>
					</div>
					<div class= "col-lg-5 col-md-5 col-sm-12 col-xs-9"style="padding-left:75px;">
						<div class="form-group">
							<label><input autocomplete="off" type="radio" id="hindu" name="calendar" value="Hindu" style="  margin: 0 5px 0 20px;"  onchange="calendarHindu();" checked/> Hindu</label>
							<label><input autocomplete="off" type="radio" id="gregorian" name="calendar" value="Gregorian"  style="  margin: 0 5px 0 20px;"  onchange="calendarGregorian();"  /> Gregorian</label>
							<label><input autocomplete="off" type="radio" id="festivalwise" name="calendar" value="festivalwise"  style="margin: 0 5px 0 20px;"  onchange="calendarFestivalwise();"/> Festivalwise</label>
							<label><input autocomplete="off" type="radio" id="everyWeekMonth" name="calendar" value="everyWeekMonth"  style="margin: 0 5px 0 20px;"  onchange="EveryWeekMonthwise();"/> Every</label>
						</div>
					</div>
					<div class= "col-lg-5 col-md-5 col-sm-5 col-xs-12" id="HinduCal" style="padding-left:78px;" hidden>
						<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<select id="masaCode" style="height: 30px;">
									<option value="">Select Masa</option>
									<?php   if(!empty($masa)) {
										foreach($masa as $row1) { ?> 
											<option value="<?php echo $row1->MASA_CODE;?>|<?php echo $row1->MASA_NAME;?>"><?php echo $row1->MASA_NAME;?></option>
										<?php } } ?>
								</select>
							</div>
						</div>
						<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12" onchange="moon()">
							<div class="form-group">
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
							<div class="form-group">
								<select id="thithiCode" style="height: 30px;">
									<option value="">Select Thithi</option>
									<?php  if(!empty($thithi[0])) { 
			             //$count = 16;
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
		            					// $count = 16;
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
									<input autocomplete="off" id="multiDate" type="text" value="" class="form-control todayDate2" placeholder="dd-mm-yyyy" readonly = "readonly" value=""/ >
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
					<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12" id="FestvalCal" style="padding-left:10px;margin-left: -1em">
						<div class="col-lg-12 col-md-6 col-sm-6 col-xs-12" style="padding-left:95px;">
							<div class="form-group" style="" >
								<select id="festivalCode" style="height: 30px;width:100% !important ">
									<option value="">Select Festval Name</option>
									<?php   if(!empty($festival)) {
										foreach($festival as $row1) { ?> 
											<option value="<?php echo $row1->SFS_THITHI_CODE;?>"><?php echo $row1->SFS_NAME;?> - <?php echo $row1->SFS_THITHI_CODE;?></option>
										<?php } } ?>
								</select>
							</div>
						</div>
					</div>
					<!-- festival ends-->
					<!-- every week month starts -->
					<div class= "col-lg-5 col-md-5 col-sm-5 col-xs-12" id="EveryWeekMonth" style="padding-left:78px;" >
						<div class= "col-lg-3 col-md-4 col-sm-4 col-xs-12" >
							<div class="form-group" >
								<select style="height: 30px;" id="weekMonth"  onchange="weekMonthChange()">
									<option value="">Select Option</option>
									<option value="Year">Year</option>
									<option value="Month">Month</option>
									<option value="Week">Week</option>
									<option value="YearHindu">Year Hindu</option>
								</select>
							</div>
						</div>
						<div class="form-group col-lg-3 col-md-6 col-sm-4 col-xs-6" id="months" style=" display: none; margin-left: 0.9em;" >
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
								<select style="height: 30px;  margin-left: 1.3em;" id="selectday" >
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
					<!-- every week month ends -->
					<form action="<?php echo base_url();?>/Shashwath/addMember" method="post" id="code">
						<input autocomplete="off" type="hidden" id="thithi" name="thithi" value=""/>
						<input autocomplete="off" type="hidden" id="masa" name="masa" value=""/>
						<input autocomplete="off" type="hidden" id="moon" name="moon" value=""/>
					</form>
					<div class=" row col-lg-6 col-md-6 col-sm-7 col-xs-12" style="padding-top:0px;margin-left:0px;">
						<div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12" style = "margin-left: 0px;margin-top: 43px;">
							<label><input autocomplete="off" style="margin-right: 6px; font-size:80px;" class="amt" onClick="hidePostageAmt(this);" type="checkbox" name="postage" id="postage" value="1"/>Postage</label>
						</div>
						<div class="form-group col-lg-9 col-md-6 col-sm-6 " style="padding-left: 25px;">
							<label for ="comment">Purpose: </label>
							<textarea class="form-control" rows="3" style="resize:none;" id="sevaNotes" onkeyup="alphaonlypurpose(this)" placeholder = "Seva Note" value="<?php echo $members[0]->SEVA_NOTES; ?>"></textarea>
						</div>
					</div>
					<!--row-->
				</div>
				<!--row  -->
			</div>
			<div>
				<div style="clear:both;margin-top:0px;" class="container">
					<div class="row form-group">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="row form-group">
								<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12  ">
									<!-- manually entering receipt number and date for old records-->
									<div class="form-group col-lg-4 col-md-4 col-sm-7 " >
										<label style="font-size: 16px;margin-top: 7px; "><input autocomplete="off" style="margin-right: 10px; font-size:80px;" class="amt" onClick="hideReciptEntry(this);" type="checkbox" name="manualreceipt" id="manualreceipt" value="1" checked="checked" hidden ><u>Reciept Book Details:</u> : <span style="color:#800000;"> * </span></label>
									</div>
									<div class="form-group col-lg-3 col-md-3 col-sm-4">
										<input autocomplete="none" type="text" class="form-control form_contct2" id="receiptLine1" placeholder="Book Receipt No" name="receiptLine1" value="" style="margin-left: -60px" />	
									</div>
									<div  class="input-group input-group-sm form-group col-lg-3 col-md-3 col-sm-4">	
										<input autocomplete="none" type="text" class="form-control receiptLine2 hasDatePicker" placeholder="dd-mm-yyyy" id="receiptLine2" name="receiptLine2" value="" style="margin-left: -50px"/>
										<div class="input-group-btn">
											<button class="btn btn-default receiptLine2" id="receiptLine3" name="receiptLine3" type="button" style="margin-left: -85px">
												<i class="glyphicon glyphicon-calendar"></i>
											</button>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12  ">
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
						<?php $i; ?>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-left:0px;">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="table-responsive">
									<table id="eventSeva" class ="table-bordered" >
										<thead>
											<tr>
												<th width="2%"><center>Sl.No</center></th>
												<th width="2%"><center>New RNo (Old RNo)</center></th>
												<th width="2%"><center>ReceiptDate</center></th>
												<th width="2%"><center>Deity Name.</center></th>
												<th width="2%"><center>Seva Name</center></th>
												<th width="2%"><center>Qty</center></th>
												<th width="2%"><center>Corpus</center></th>
												<th width="2%"><center>Date</center></th>
												<th width="2%"><center>Thithi</center></th>
												<th width="2%"><center>Week/Month/Year</center></th>	
												<th width="2%"><center>Period</center></th>
												<th width="2%"><center>Purpose</center></th>
												<th width="2%"><center>Postage</center></th>	
												<th width="2%"><center>Verification</center></th>
												<th width="2%"><center>Operation</center></th>
											</tr>
										</thead>
										<tbody id="eventUpdate">
											<?php $i = 1; ?>
											<?php foreach ($members as $result) { ?> 
												<tr>
													<td width="2%" class="text-center"><?php echo $i; ?></td>
													<td> <center><?php if($result->SS_RECEIPT_NO != "" ) echo $result->RECEIPT_NO . " (".$result->SS_RECEIPT_NO.")"; else echo $result->RECEIPT_NO; ?></center></td>
													<td> <center><?php echo $result->SS_RECEIPT_DATE;?></center></td>
													<td><center><?php echo $result->DEITY_NAME; ?></center></td>
													<td><center><?php echo $result->SEVA_NAME; ?></center></td>
													<td><center><?php echo $result->SEVA_QTY; ?></center></td>
													<td><center>
													<?php if($result->CORPUS_CNT > 1) {?>
														<a style="color: red;" href="#" onclick="corpusRaiseDetails('<?=$result->SS_ID; ?>')" data-toggle="modal" data-target="#modalCorpusHistory" ><u><?php echo $result->RECEIPT_PRICE; ?></u></a>&nbsp;
													<?php } else if($result->CORPUS_CNT == 1) { ?>
														<?php echo $result->RECEIPT_PRICE; ?>&nbsp;
													<?php } ?>
													<img id="corpusRaiseBtn" src="<?=base_url()?>images/add_icon.svg" title ="Raise the Corpus" onclick="corpusRaise('<?=$result->SS_ID; ?>','<?=$result->RECEIPT_NO;?>','<?=$result->SEVA_NAME;?>','<?=$result->SM_NAME;?>','<?=$result->SM_ADDR1;?>','<?=$result->SM_ADDR2;?>','<?=$result->SM_CITY;?>','<?=$result->SM_STATE;?>','<?=$result->SM_COUNTRY;?>','<?=$result->SM_PIN;?>','<?=$result->RECEIPT_PRICE; ?>','<?=$result->SHASH_PRICE; ?>','<?=$result->SHASH_SEVA_COST; ?>','<?=$result->SEVA_CORPUS;?>','<?=$result->TOTAL_SEVA_COST;?>','<?=$result->NO_OF_SEVAS; ?>','<?=$result->DEITY_NAME;?>','<?=$result->SM_PHONE; ?>','<?=$result->SM_ID; ?>');">
													</center></td>
													<td><center><?php echo $result->ENG_DATE; ?></center></td>
													<td><?php echo $result->THITHI_CODE; ?></td> 
													<td><?php echo $result->EVERY_WEEK_MONTH; ?></td> 
													<td><center><?php echo $result->PERIOD_NAME; ?></center></td>
													<td width="2%"><center><?php echo $result->SEVA_NOTES; ?></center></td>
													<td style="color:#800000;" title="<?=$result->POSTAL_ADDR; ?>"><center><?php echo (($result->POSTAGE_CHECK == 1)?"YES":"NO"); ?></center></td>
													<!-- <td><?php echo $result->POSTAL_ADDR; ?></td> -->
													<td><center><?php if($result->SS_VERIFICATION == 0) echo "No"; else echo "Yes"; ?></center></td>
													<?php $Notes = str_replace("\n"," ", $result->SEVA_NOTES); ?>
													<?php if($result->SS_VERIFICATION == 0){ ?>
														<td><img id="myBtn" src="<?=base_url()?>images/edit_icon.svg" title ="Edit and update Seva Details" onClick="editSevaDetail('<?=$result->SM_ID; ?>','<?=$result->SS_ID; ?>','<?=$result->RECEIPT_NO; ?>', '<?=$result->RECEIPT_ID; ?>','<?=$result->DEITY_ID;?>','<?=$result->SEVA_ID;?>','<?=$result->FIRST_RECEIPT_PRICE;?>','<?=$result->SEVA_QTY;?>','<?=$result->SS_RECEIPT_NO_REF;?>','<?=$result->RECEIPT_DATE;?>','<?=$result->SP_ID;?>','<?php echo str_replace("'","\'",$Notes);?>','<?=$result->MASA;?>','<?=$result->BASED_ON_MOON;?>','<?=$result->THITHI_NAME;?>','<?=$result->THITHI_CODE;?>','<?=$result->ENG_DATE;?>','<?=$result->EVERY_WEEK_MONTH;?>','<?=$result->CAL_TYPE;?>','<?=$result->PERIOD_NAME;?>','<?=$result->SS_VERIFICATION;?>')">
															<img id="deleteSevaBtn"  style="width:24px; height:24px" src="<?=base_url()?>images/trash.svg" title ="delete Seva" onclick="deleteSeva('<?=$result->SM_ID; ?>','<?=$result->SS_ID; ?>','<?=$result->RECEIPT_NO; ?>', '<?=$result->RECEIPT_ID; ?>','<?=$result->DEITY_ID;?>','<?=$result->SEVA_ID;?>','<?=$result->RECEIPT_PRICE;?>','<?=$result->SEVA_QTY;?>','<?=$result->SS_RECEIPT_NO_REF;?>','<?=$result->RECEIPT_DATE;?>','<?=$result->SP_ID;?>','<?php echo str_replace("'","\'",$Notes);?>','<?=$result->THITHI_CODE;?>','<?=$result->ENG_DATE;?>','<?=$result->CAL_TYPE;?>');">
														</td>
													<?php } else if($result->SS_VERIFICATION == 1){ ?>
														<td></td>
													<?php } ?>

												</tr>
											<?php $i++; } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>	
					</div>
				</div>

				<div class="container">
					<div class="row form-group">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-8"style="margin-top:25px;">
								<!--<label><input autocomplete="off" style="margin-right: 6px; font-size:80px;" class="amt" onClick="hidePostageAmt(this);" type="checkbox" name="postage" id="postage" value="1">Postage</label>-->
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:0px;">
									<input autocomplete="none" type="text" class="form-control form_contct2" id="addLine1" placeholder="Address Line1" name="addLine1" disabled onkeyup="alphaonlyAdrs(this)"  maxlength="32"/><br>
								</div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:0px;">
									<input autocomplete="none" type="text" class="form-control form_contct2" id="addLine2" placeholder="Address Line2" name="addLine2" onkeyup="alphaonlyAdrs(this)" disabled  maxlength="32"/><br>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding:0px;">
									<input autocomplete="none" type="text" class="form-control form_contct2" id="city" placeholder="City" name="city" disabled  maxlength="32"/><br>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding-left:5px;padding-right:5px;">
									<input autocomplete="none" type="text" class="form-control form_contct2" id="state" placeholder="State" name="state" disabled  maxlength="32"/><br>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding-left:5px;padding-right:5px;">
									<input autocomplete="none" type="text" class="form-control form_contct2" id="country" placeholder="Country" name="country" disabled  maxlength="32"/><br>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding:0px;">
									<input autocomplete="none" type="text" class="form-control form_contct2" id="pincode" placeholder="Pincode" name="pincode" disabled /><br>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<div class="form-group">
									<label for="modeOfPayment">Mode Of Payment:<span style="color:#800000;">*</span></label>
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
										<label for="name">Cheque No:<span style="color:#800000;">*</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<input autocomplete="off" type="text" class="form-control form_contct2" id="chequeNo" placeholder="" name="chequeNo">
									</div>

									<div style="padding-top: 15px;" class="form-group col-xs-10">
										<label for="rashi">Cheque Date:<span style="color:#800000;">*</span></label>&nbsp;&nbsp;
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
										<label for="number">Bank Name:<span style="color:#800000;">*</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<input autocomplete="off" type="text" class="form-control form_contct2" id="bank" placeholder="" name="bank">
									</div>

									<div style="padding-top: 15px;" class="form-group col-xs-12">
										<label for="nakshatra">Branch Name:<span style="color:#800000;">*</span></label>&nbsp;&nbsp;
										<input autocomplete="off" type="text"  class="form-control form_contct2" id="branch" placeholder="" name="branch">
									</div>
								</div>
								<!-- laz new-->
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
								<!-- laz new-->
								<!-- //SLAP -->
								<!-- laz -->
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
								<!-- laz.. -->
								<div class="form-group">
									<label for="comment">Payment Notes: </label>
									<textarea class="form-control" style="resize:none;" rows="5" id="paymentNotes"></textarea>
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
				<div class="modal fade" id="editModal" role="dialog">
					<div class="modal-dialog"  style="width: 1200px;">
						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<h3 class="modal-title"><b>Shashwath Seva Edit</b></h3>
							</div>
							<div class="modal-body">
								<form role="form">
									<div class="row">
										<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
											<div class="row">
												<div class="col-lg-7 col-md-12 col-sm-6 col-xs-12">
													<div class="form-group">
														<label for="deityCombo">Deity<span style="color:#800000;">*</span> </label>
														<select onChange="editModalDeityComboChange();" id="editModalDeityCombo" class="form-control" style="width: 300px;">
														</select>
													</div>
												</div>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"  style="margin-left: 40px;">
													<div class="form-group">
														<label for="sevaAmount">Corpus Amount:<span style="color:#800000;">*</span><br/></label>
														<input autocomplete="none" type="text" class="form-control form_contct2" id="modalCorpus" placeholder="" name="name" value="" disabled/>
													</div>
												</div>
											</div><br/>
											<div class="row">
												<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
													<div class="form-group">
														<label for="sevaCombo">Seva<span style="color:#800000;">*</span></label>
														<select onChange="editModalSevaComboChange();" id="editModalSevaCombo" class="form-control"></select>
														<label for="sevaAmount" id="revDate" style="display:none;float:right;">
															<span style="color:#800000;">* <span style="font-size: 12px;" id="revRate"></span></span>
														</label>
													</div>
												</div>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
													<div class="form-group">
														<label for="periodCombo">Selection of Period<span style="color:#800000;">*</span></label>
														<select id="modalPeriodCombo" class="form-control" style="width: 230px;">
														</select>
													</div>
												</div>
											</div>	
										</div>
										<div class="col-lg-1 col-md-2 col-sm-2 col-xs-12 " >
											<div class="qtyOpt form-group"  style = "margin-left: 3px; ">
												<label for="modalSevaQty">Quantity<span style="color:#800000;">*</span></label><br/>
												<input style="width:70px;font-size:24px;" type="text" value="1" oninput = "inputModalQuantity(this.value)" class="form-control form_contct2" id="modalSevaQty" placeholder="1" name="modalSevaQty">
											</div>
										</div>
										<div class= "col-lg-5 col-md-5 col-sm-12 col-xs-9" style="padding-left:30px;">
											<div class="form-group">
												<input autocomplete="off" type="radio" id="modalHindu" name="calendar" value="Hindu" style="  margin: 0 5px 0 20px;"  onchange="modalCalendarHindu();" checked/> Hindu
												<input autocomplete="off" type="radio" id="modalGregorian" name="calendar" value="Gregorian"  style="  margin: 0 5px 0 20px;"  onchange="modalCalendarGregorian();"  /> Gregorian
												<input autocomplete="off" type="radio" id="modalFestivalwise" name="calendar" value="festivalwise"  style="margin: 0 5px 0 20px;"  onchange="modalCalendarFestivalwise();"/> Festivalwise
												<input autocomplete="off" type="radio" id="modalEveryWeekMonthwise" name="calendar" value="everyWeekMonth"  style="margin: 0 5px 0 20px;"  onchange="modalWeekMonthwise();"/> Every
											</div>
										</div>
										<div class= "col-lg-5 col-md-5 col-sm-5 col-xs-12" id="modalHinduCal"  style="padding-left:40px;" >
											<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
												<div class="form-group">
													<select id="modalMasaCode" style="height: 30px;">
													</select>
												</div>
											</div>
											<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12" onchange="moonChange()">
												<div class="form-group">
													<select id="modalBomCode" style="height: 30px;width: 110px;">

													</select>
												</div>
											</div>
											<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
												<div class="form-group">
													<select id="modalThithiCode" style="height: 30px;">

													</select>
												</div>
											</div>
											<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12" style="margin-top:-15px;">
												<div class="form-group">
													<select id="modalThithiCode1" style="height: 30px;display:none;">

													</select>
												</div>
											</div>
										</div>
										<div class="col-lg-4 col-md-5 col-sm-5 col-xs-12" id="modalGregorianCal" style="padding-left:10px;" hidden>
											<div class="row ">
												<div class="col-lg-7 col-md-6 col-sm-6 col-xs-12" style="margin-left:40px;">
													<div class="input-group input-group-sm form-group">
														<input autocomplete="off" id="modalmultiDate" type="text" value="" class="form-control modalmultiDate" name="modalmultiDate" placeholder="dd-mm-yyyy" readonly = "readonly" value=""/ >
														<div class="input-group-btn">
															<button class="btn btn-default modalmultiDate" type="button">
																<i class="glyphicon glyphicon-calendar"></i>
															</button>
														</div>
													</div>
												</div>
											</div>
										</div>
										<!-- festival starts-->
										<div class="col-lg-4 col-md-5 col-sm-5 col-xs-12" id="modelFestvalCal" style="padding-left:10px;margin-left: 1.5em" hidden>
											<div class="form-group" style="padding-left:20px;" >
												<select id="modalFestivalCode" style="height: 30px;width: 100% !important ">

												</select>
											</div>		
										</div>
										<!-- festival ends-->
										<!-- every week month starts -->
										<div class= "col-lg-5 col-md-5 col-sm-5 col-xs-12" id="modelEveryWeekMonthcal" style="padding-left:78px; margin-left: -3em;" >
												<div class= "col-lg-3 col-md-4 col-sm-4 col-xs-12" >
													<div class="form-group" >
														<select style="height: 30px;" id="modalweekMonth"  onchange="modelweekMonthChange()">
															<option value="">Select Option</option>
															<option value="Year">Year</option>
															<option value="Month">Month</option>
															<option value="Week">Week</option>
															<option value="YearHindu">Year Hindu</option>
														</select>
													</div>
												</div>
												<div class="form-group col-lg-3 col-md-6 col-sm-4 col-xs-6" id="modalmonths" style=" display: none; margin-left: 0.9em;" >
														<select id="modalmodeOfChangeMonth" style="height: 30px;"  >
																	
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
												<div class= "col-lg-2 col-md-4 col-sm-4 col-xs-12" id="modalFirst" style="margin-left: 1em;display: none;" >
													<div class="form-group" >
														<select style="height: 30px;" id="modaleveryFivedaysval"  >
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
														<select style="height: 30px;  margin-left: 0.8em;" id="modalselectday" >
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
												<div class= "col-lg-2 col-md-4 col-sm-4 col-xs-12" id="modalEveryyearmasa" style="margin-left: 1.5em; display: none;" >
													<div class="form-group" >
														<select id="modalmasaevery" style="height: 30px;">
															<option value="">Select Masa</option>
															<?php   if(!empty($masa)) {
																foreach($masa as $row1) { ?> 
																	<option value="<?php echo $row1->MASA_CODE;?>|<?php echo $row1->MASA_NAME;?>"><?php echo $row1->MASA_NAME;?></option>
																<?php } } ?>
														</select>
													</div>
												</div>
											</div>
										<!-- every week month ends -->
										<div class=" row col-lg-5 col-md-6 col-sm-7 col-xs-12" style="padding-top:0px;margin-left:94px;">
											<div class="form-group col-lg-12 col-md-6 col-sm-6 " style="padding-left: 20px; margin-top: 9px">
												<label for ="comment">Purpose: </label>
												<textarea class="form-control" rows="3" style="resize:none;" onkeyup="alphaonlypurpose(this)" id="modalSevaNotes" placeholder = "Seva Note"></textarea>
											</div>
										</div>
										<div class="col-lg-9 col-md-12 col-sm-12 col-xs-12  " style="padding-top:0px;">
											<!-- manually entering receipt number and date for old records-->
											<div class="form-group col-lg-3 col-md-4 col-sm-7 " >
												<label style="font-size: 16px;margin-top: 7px; "><input autocomplete="on" style="margin-right: 10px; font-size:80px;" class="amt" onClick="modalhideReciptEntry(this);" type="checkbox" name="modalManualReceipt" id="modalManualReceipt" value="1" hidden><u>Old Reciept Details</u> : <span style="color:#800000;"> * </span></label>
											</div>
											<div class="form-group col-lg-3 col-md-3 col-sm-4 " >
												<input autocomplete="none" type="text" class="form-control form_contct2" id="modalreceiptLine1" placeholder="Book Receipt No" name="modalreceiptLine1" value="" />	
											</div>
											<div class="input-group input-group-sm form-group col-lg-3 col-md-3 col-sm-4 oldModalRDate">	
												<input autocomplete="none" type="text" class="form-control modalreceiptLine2" placeholder="dd-mm-yyyy" id="modalreceiptLine2" name="modalreceiptLine2" value="" />
												<div class="input-group-btn">
													<button class="btn btn-default modalreceiptLine2" id="modalreceiptLine3" name="modalreceiptLine3" type="button" >
														<i class="glyphicon glyphicon-calendar"></i>
													</button>
												</div>
											</div>																
										</div>
									</div>
									<input type="hidden" id="modalssVerification" name="modalssVerification" value=""/>
								</form>			         	
							</div>
							<div class="modal-footer" style="margin-top: -10px;">
								<button type="submit" class="btn btn-default" style="cursor: pointer;" onclick="updateShashwathSevaDetails();">Verify & Update</button>
								<button type="submit" class="btn btn-default" data-dismiss="modal"> Cancel</button>
							</div>
						</div>
					</div>
				</div>
				<div class="modal fade bs-example-modal-lg" id="validateModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title">Shashwath Seva Preview</h4>
							</div>
							<div class="modal-body addlShashSeva" id="creditdet" style="overflow-y: auto;max-height: 80vmin;">

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
				<div id="modalCorpusHistory" class="modal fade" role="dialog">
					<div class="modal-dialog modal-lg">
						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title"><b>Corpus Raise History</b></h4>
							</div>
							<div class="modal-body viewCorpusHistory"  style="overflow-y: auto;max-height: 80vmin;">

							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<input autocomplete="off" type="hidden" id="radioOpt" value="multiDateRadio" />   
			<center>
				<input type="button" id="update" value="<?php if(isset($_SESSION['Authorise'])) echo "Verify & Update"; else echo "Update"; ?>" name="Update"  onClick="updateData();" class="btn btn-default btn-lg" />
			</center>
			<center>
				<input type="button"  id="submitRecord" value="<?php if(isset($_SESSION['Authorise'])) echo "Verify & Submit"; else echo "Submit & Save"; ?>" name="submit" onClick="update();validateSubmit();" class="btn btn-default btn-lg" />
			</center>
		</div>
		<!-- NEW_CODE_START -->
		<div id="2" class="w5-container city" hidden>
			<div id="mandaliMembId" style="display: none;">
				<div class="container">
					<img class="img-responsive bgImg2 bg1" src="<?=site_url()?>images/TempleLogo.png" />
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
								<input autocomplete="none" type="text" class="form-control form_contct2" id="mandalimemname" placeholder="" name="mandalimemname" onkeyup="alphaonly(this)"/>
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
								<input autocomplete="off" type="text" class="form-control form_contct2" id="mandalimemphone2" placeholder="" name="mandalimemphone2" >
							</div>
						</div>
						<div class= "col-lg-6 col-md-6 col-sm-12 col-xs-9" style="padding-top:25px;">
							<div class="form-group">
								<label for="rashi">Rashi</label>
								<input autocomplete="off" type="hidden" id="baseurl" name="baseurl" value="<?php echo site_url(); ?>" />
								<div class="dropdown">
									<input autocomplete="off" type="text" class="form-control form_contct2" id="mandalimemrashi" placeholder="" name="mandalimemrashi">
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
									<input autocomplete="off" type="text" class="form-control form_contct2" id="mandalimemnakshatra" placeholder="" name="mandalimemnakshatra">
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
									<input autocomplete="off" type="text" class="form-control form_contct2" id="mandalimemGotra" placeholder="" name="mandalimemGotra">
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
								<input autocomplete="none" type="text" class="form-control form_contct2" id="mandalimemaddLine1" placeholder="Address Line1" name="mandalimemaddLine1"  maxlength="32" onkeyup="alphaonlyAdrs(this)"/>
							</div>
						</div>
						<div class= "col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<input autocomplete="none" type="text" class="form-control form_contct2" id="mandalimemaddLine2" placeholder="Address Line2" name="mandalimemaddLine2" maxlength="32" onkeyup="alphaonlyAdrs(this)"/>
							</div>
						</div>
						<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<input autocomplete="none" type="text" class="form-control form_contct2" id="mandalimemcity" placeholder="City" name="mandalimemcity" maxlength="32" onkeyup="alphaonlyAdrs(this)"/>
							</div>
						</div>
						<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<input autocomplete="none" type="text" class="form-control form_contct2" id="mandalimemstate" placeholder="State" name="mandalimemstate" maxlength="32" onkeyup="alphaonlyAdrs(this)"/>
							</div>
						</div>
						<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<input autocomplete="none" type="text" class="form-control form_contct2" id="mandalimemcountry" placeholder="Country" name="mandalimemcountry" maxlength="32" onkeyup="alphaonlyAdrs(this)"/>
							</div>
						</div>
						<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<input autocomplete="none" type="text" class="form-control form_contct2" id="mandalimempincode" oninput="inputPincodeMandali(this.value,this.id)" placeholder="Pincode" name="mandalimempincode"/><br/>
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
									<table id="eventSeva1" class ="table table-bordered" >
										<thead>
											<tr>
												<th>Sl.No</th>
												<th>Name.</th>
												<th>Phone</th>
												<th>Rashi</th>
												<th>Nakshatra</th>
												<th>Gotra</th>
												<th>Address</th>
												<th>Remarks</th>
												<th>Remove</th>
											</tr>
										</thead>
										<tbody id="eventUpdate1">
											<?php $i = 1; ?>
											<?php foreach ($mandaliMembers as $result) { ?> 
												<tr class='mm_<?php echo $result->MM_ID; ?>'>	<!-- NEW_CODE -->
													<td><?php echo $i; ?></td>
													<td><?php echo $result->MM_NAME;?></td>
													<td><?php echo $result->MM_PHONE; ?>,<?php echo $result->MM_PHONE2; ?></td>
													<td><?php echo $result->MM_RASHI; ?></td>
													<td><?php echo $result->MM_NAKSHATRA; ?></td>
													<td><?php echo $result->MM_GOTRA; ?></td>
													<td><?php echo $result->MM_ADDR1; ?>, <?php echo $result->MM_ADDR2; ?>, <?php echo $result->MM_CITY; ?>, <?php echo $result->MM_STATE; ?>, <?php echo $result->MM_COUNTRY; ?>,<?php echo $result->MM_PIN; ?></td> 
													<td><?php echo $result->MM_REMARKS; ?></td>
													<td><center>
														<img id="myMandaliBtn" src="<?=base_url()?>images/edit_icon.svg" title ="Edit and update Member Details" onClick="editMandaliMemberDetail('<?=$result->SM_ID; ?>','<?php echo str_replace("'","\'",$result->MM_NAME); ?>','<?=$result->MM_PHONE; ?>', '<?=$result->MM_PHONE2; ?>','<?=$result->MM_RASHI;?>','<?=$result->MM_NAKSHATRA;?>','<?=$result->MM_GOTRA;?>','<?php echo str_replace("'","\'",$result->MM_ADDR1);?>','<?php echo str_replace("'","\'",$result->MM_ADDR2);?>','<?=$result->MM_CITY;?>','<?=$result->MM_STATE;?>','<?=$result->MM_COUNTRY;?>','<?=$result->MM_PIN;?>','<?php echo str_replace("'","\'",$result->MM_REMARKS);?>','<?=$result->MM_ID;?>')">
														<img id="deleteManMemBtn"  style="width:24px; height:24px" src="<?=base_url()?>images/trash.svg" title ="delete Member" onclick="deleteMandaliMember('<?=$result->SM_ID; ?>','<?=$result->MM_ID; ?>','<?php echo str_replace("'","\'",$result->MM_NAME); ?>');">

													</center></td>
												</tr>
												<?php $i++; } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:80px;">
							<div class="container-fluid">
								<center>
									<button type="button" onclick = "goToTabShashwathSevaDetails();" class="btn btn-default btn-lg"> Next  <span class="glyphicon glyphicon-forward"></span></button>
								</center>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div>
				<div class="modal fade bs-example-modal-lg"  id="mandalimodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title">Mandali Member Preview</h4>
							</div>
							<div class="modal-body" id="creditdet" style="overflow-y: auto;max-height: 80vmin;">

							</div>
							<div class="modal-footer text-left" style="text-align:left;">
								<label>Are you sure you want to save..?</label>
								<br/>
								<button style="width: 8%;" type="button" class="btn btn-default sevaButton" id="submitmandali">Yes</button>
								<button style="width: 8%;" type="button" class="btn btn-default sevaButton" data-dismiss="modal">No</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<input autocomplete="off" type="hidden" id="radioOpt" value="multiDateRadio" />   		
		</div>
		<!-- NEW_CODE_END -->
	</div>
</div>
<form id="form" action="<?=site_url();?>Receipt/receipt" method="post">
	<input type="hidden" id="smId" name="identity" value="<?php echo $members[0]->SM_ID;?>"/>
</form>
<!--corpus topup-->	
<!-- <form  id="addCorpus" method="post" action="<?=site_url();?>Receipt/addCorpusReceipt"> 
	<div class="modal fade" id="corpusModal" role="dialog">
		<div class="modal-dialog">
			
			<div class="modal-content mod">
				<div class="modal-header">
					<h4 class="modal-title">Shashwath Seva Corpus Topup</h4>
					<button type="button" class="close" data-dismiss="modal" style="margin-top:-10px;">&times;</button>
				</div>
				<div class="modal-body">
					<p><b>Receipt number : <span id="receipt"></span></b></p>
					<p><b>Seva Name : <span id="seva"></span></b></p>
					<p><b>Additional Corpus : <span id="corp" name="corp"></span></b></p>
					<p><b>Book Receipt No:</b> <input  autocomplete="off" type="text" class = "form_contct2" name="bookreceiptno" id="bookreceiptno" onkeyup="validNum(this)">
					<div class="row">
						<div class="col-lg-3 col-md-3 col-sm-4">
							<b>Receipt Date:</b>
						</div>
						<div class="input-group input-group-sm form-group col-lg-4 col-md-3 col-sm-4">	
							<input autocomplete="none" type="text" class="form-control adlCrpBookDate" placeholder="dd-mm-yyyy" id="adlCrpBookDate" name="adlCrpBookDate" value="" />
							<div class="input-group-btn">
								<button class="btn btn-default adlCrpBookDate" id="adlCrpBookDate3" name="adlCrpBookDate3" type="button" >
									<i class="glyphicon glyphicon-calendar"></i>
								</button>
							</div>
						</div>
					</div>
					<p><b>Your Corpus :</b> <input  autocomplete="off" type="text" class = "form_contct2" name="corpus" id="corpus" onkeyup="validNum(this)"></p>
					<div class="form-inline ">
						<?php if($members[0]->IS_MANDALI == 1){ ?>
							<div class="form-group" style="margin-bottom: 5px">
								<label>Paid By:
									<span style="color:#800000;">*</span>
								</label>
								<select id="paidBy" name="paidBy" class="form-control">
									<option value="">Select Sevadhar</option>
									<?php   if(!empty($mandaliMembers)) {
										foreach($mandaliMembers as $row1) { ?> 
											<option value="<?php echo $row1->MM_ID;?>"><?php echo $row1->MM_NAME;?></option>
										<?php } } ?>
									</select>
								</div><br/>
							<?php } ?>

							<div class="form-group">
								<label for="modeOfPayment">Mode Of Payment:
									<span style="color:#800000;">*</span>
								</label>
								<select id="modeOfPayment" name="modeOfPayment" class="form-control">
									<option value="">Select Payment Mode</option>
									<option value="Cash">Cash</option>
									<option value="Cheque">Cheque</option>
									<option value="Direct Credit">Direct Credit</option>
									<option value="Credit / Debit Card">Credit / Debit Card</option>
								</select>
							</div>
							<div style="margin-top: 10px;display:none;margin-left: -14px;" id="showChequeList">
								<div style="padding-top: 15px;" class="control-group col-md-6 col-lg-6 col-sm-12 col-xs-12">
									<label for="name">Cheque No:
										<span style="color:#800000;">*</span>
									</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="text" class="form-control form_contct2" id="chequeNo" name="chequeNo" placeholder="" autocomplete="off" onkeyup="validNum(this)">
								</div>

								<div style="padding-top: 15px;" class="control-group col-md-6 col-lg-6 col-sm-12 col-xs-12">
									<label for="rashi">Cheque Date:
										<span style="color:#800000;">*</span>
									</label>&nbsp;&nbsp;
									<div class="input-group input-group-sm">
										<input  type="text" id="chequeDateM" name="checkdate" value="" class="form-control chequeDate3 form_contct2" placeholder="<?=date(" d-m-Y ")?>" autocomplete="off">
										<div class="input-group-btn">
											<button class="btn btn-default chequeDate1" type="button">
												<i class="glyphicon glyphicon-calendar"></i>
											</button>
										</div>
									</div>
								</div>
								<div style="padding-top: 15px;clear: both;" class="control-group col-md-6 col-lg-6 col-sm-12 col-xs-12">
									<label for="number">Bank Name:
										<span style="color:#800000;">*</span>
									</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="text" class="form-control form_contct2" name="bank" id="bank" placeholder="" autocomplete="off">
								</div>
								<div style="padding-top: 15px;" class="control-group col-md-6 col-lg-6 col-sm-12 col-xs-12">
									<label for="nakshatra">Branch Name:
										<span style="color:#800000;">*</span>
									</label>&nbsp;&nbsp;
									<input type="text" class="form-control form_contct2"  name="branch" id="branch" placeholder="" autocomplete="off">
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

						</div>
						<div class="form-group" style="clear:both;margin-top:10px;padding-top:17px;">
							<label for="comment">Payment Notes:</label>
							<textarea class="form-control" rows="5" style="resize:none;" id="pymtNotes" name="paymentNotes"></textarea>
						</div>
						<input type="hidden" id="namePhone" name="namePhone"/>
						<input type="hidden" id="receipt_no" name="receipt_no"/>
						<input type="hidden" id="seva_name" name="seva_name" value = ""/>
						<input type="hidden" id="deityName" name="deityName" value = "" />
						<input type="hidden" id="ssId" name="ssId" />
						<input type="hidden" id="corpusCallFrom" name="corpusCallFrom" value="ShashSeva"/>
						<input type="hidden" id="add1" name="add1"/>
						<input type="hidden" id="add2" name="add2"/>
						<input type="hidden" id="scity" name="scity"/>
						<input type="hidden" id="sstate" name="sstate"/>
						<input type="hidden" id="scountry" name="scountry"/>
						<input type="hidden" id="pin" name="pin"/>
					</div>
					<div class="modal-footer">
						<input type="submit" class="btn btn-default" onclick="return validateCorpus();" value="Submit" />
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div> 
			</div>
		</div>
		<input type="hidden" name="corpusCallFrom" id="corpusCallFrom" value="shashwathMember">
</form> -->

<div class="modal fade" id="deleteSevaModal" role="dialog">
	<div class="modal-dialog"  style="">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 style="font-weight:600;" class="modal-title text-center">Shashwath Seva Delete</h4>
			</div>
			<form id="deleteForm" action="<?php echo site_url(); ?>Shashwath/deleteShashwathSeva" id="deleteForm" class="form-group" role="form" enctype="multipart/form-data" method="post">
				<div class="modal-body">
					<div style="clear:both;" class="form-group" id="deleteAlert">
						<div class="form-group col-lg-12 col-md-6 col-sm-6 col-xs-6">
							<label><span style="font-weight:600;color:#800000;">This is the last Seva for this member,if you delete this seva,member will be deleted</span></label>
						</div>
					</div>
					<div style="clear:both;" class="form-group">
						<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
							<label for="seva"><span style="font-weight:600;">Deity Name:&nbsp;</span></label><span id="deleteDeityName"></span>
						</div>

						<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
							<label for="inputLimit" ><span style="font-weight:600;">Seva Name:&nbsp;</span></label><span id="deleteSevaName"></span>
						</div>
					</div>
					<div style="clear:both;" class="form-group">
						<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
							<label for="inputLimit" ><span style="font-weight:600;">Corpus:&nbsp;</span></label><span id="deleteCorpus"></span>
						</div>

						<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
							<label for="seva"><span style="font-weight:600;">Qty:&nbsp;</span></label><span id="deleteQty"></span>
						</div>
					</div>
					<div style="clear:both;" class="form-group">
						<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
							<label for="inputLimit" ><span style="font-weight:600;">SS Receipt No:&nbsp;</span></label><span id="deleteSSReceiptNo"></span>
						</div>

						<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
							<label for="seva"><span style="font-weight:600;">SS Receipt Date:&nbsp;</span></label><span id="deleteSSReceiptDate"></span>
						</div>
					</div>
					<div style="clear:both;" class="form-group">
						<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
							<label for="inputLimit" ><span style="font-weight:600;">Thithi Code/Eng Date:&nbsp;</span></label><span id="deleteThithiCode"></span>
						</div>

						<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
							<label for="seva"><span style="font-weight:600;">Purpose:&nbsp;</span></label><span id="deletePurpose"></span>
						</div>
					</div>
					<div style="clear:both;" class="form-group">
						<div class="form-group col-lg-12 col-md-6 col-sm-6 col-xs-6">
							<label for="inputLimit" ><span style="font-weight:600;">Reason for Delete:<span style="color:#800000;">*</span> </span> </label>
							<textarea class="form-control" rows="5" name="deleteSeavaReason" id="deleteSeavaReason" placeholder="Reason for Seva Delete" style="width:100%;height:100%;resize:none;" required></textarea>
						</div>
					</div>
					<!-- HIDDEN -->
					<div class="modal-footer">
						<button type="submit" id="deleteSubmit" class="btn btn-default">DELETE</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
					</div>
				</div>
				<input type="hidden" id="deleteSSID" name="deleteSSID" value="">
				<input type="hidden" id="deleteReceiptId" name="deleteReceiptId" value="">
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="editMandaliMemberModal" role="dialog">
	<div class="modal-dialog" style="width: 1200px;">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title"><b>Edit shashwath mandali member details</b></h3>
			</div>

			<div class="modal-body">
				<div class="container">
					<img class="img-responsive bgImg2 bg1">
					<div class="row form-group">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="col-lg-4  col-md-5 col-sm-6 col-xs-6">
								<span class="eventsFont2 samFont1"></span>
							</div>
						</div>
					</div>

					<div class= "col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class= "col-lg-12 col-md-6 col-sm-12 col-xs-9">
							<div class="form-group" >
								<label for="name">Name<span style="color:#800000;">*</span></label>
								<input autocomplete="none" type="text" class="form-control form_contct2" id="MMname" placeholder="" name="MMname" onkeyup="alphaonly(this)"/>
							</div>
						</div>
						<div class= "col-lg-6 col-md-6 col-sm-12 col-xs-9" style="padding-top:25px;">
							<div class="form-group">
								<label for="number">Number<span style="color:#800000;">*</span></label>
								<input autocomplete="off" type="text" class="form-control form_contct2" id="MMphone" placeholder="" name="MMphone" >
							</div>
						</div>
						<div class= "col-lg-6 col-md-6 col-sm-12 col-xs-9" style="padding-top:25px;">
							<div class="form-group">
								<label for="number">Additional Number</label>
								<input autocomplete="off" type="text" class="form-control form_contct2" id="MMphone2" placeholder="" name="MMphone2" >
							</div>
						</div>
						<div class= "col-lg-6 col-md-6 col-sm-12 col-xs-9" style="padding-top:25px;">
							<div class="form-group">
								<label for="rashi">Rashi</label>
								<div class="dropdown">
									<input autocomplete="off" type="text" class="form-control form_contct2" id="MMrashi" placeholder="" name="MMrashi">
									<ul class="dropdown-menu txtpin" style="margin-left:0px;margin-right:0px;max-height:400px;" role="menu" aria-labelledby="dropdownMenu"  id="DropdownRashi">
									</ul>
								</div>
							</div>
						</div>
						<div class= "col-lg-6 col-md-6 col-sm-12 col-xs-9" style="padding-top:25px;">
							<div class="form-group">
								<label for="nakshatra">Nakshatra </label>
								<div class="dropdown">
									<input autocomplete="off" type="text" class="form-control form_contct2" id="MMnakshatra" placeholder="" name="MMnakshatra">
									<ul class="dropdown-menu txtpin1" style="margin-left:0px;margin-right:0px;max-height:400px;" role="menu" aria-labelledby="dropdownMenu"  id="Dropdownnakshatra">
									</ul>
								</div>
							</div>
						</div>
						<div class= "col-lg-12 col-md-6 col-sm-12 col-xs-9" style="padding-top:20px;">
							<div class="form-group">
								<label for="gotra">Gotra </label>
								<div class="dropdown">
									<input autocomplete="off" type="text" class="form-control form_contct2" id="MMGotra" placeholder="" name="MMGotra">
								</div>
							</div>
						</div>
					</div>
					<div class= "col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class= "col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label for="name">Address<span style="color:#800000;">*</span></label>
								<input autocomplete="none" type="text" class="form-control form_contct2" id="MMaddLine1" placeholder="Address Line1" name="MMaddLine1"  maxlength="32" onkeyup="alphaonlyAdrs(this)"/>
							</div>
						</div>
						<div class= "col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<input autocomplete="none" type="text" class="form-control form_contct2" id="MMaddLine2" placeholder="Address Line2" name="MMaddLine2" maxlength="32" onkeyup="alphaonlyAdrs(this)"/>
							</div>
						</div>
						<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<input autocomplete="none" type="text" class="form-control form_contct2" id="MMcity" placeholder="City" name="MMcity" maxlength="32" onkeyup="alphaonlyAdrs(this)"/>
							</div>
						</div>
						<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<input autocomplete="none" type="text" class="form-control form_contct2" id="MMstate" placeholder="State" name="MMstate" maxlength="32" onkeyup="alphaonlyAdrs(this)"/>
							</div>
						</div>
						<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<input autocomplete="none" type="text" class="form-control form_contct2" id="MMcountry" placeholder="Country" name="MMcountry" maxlength="32" onkeyup="alphaonlyAdrs(this)"/>
							</div>
						</div>
						<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<input autocomplete="none" type="text" class="form-control form_contct2" id="MMpincode" oninput="inputPincodeMandali(this.value,this.id)" placeholder="Pincode" name="MMpincode"/><br/>
							</div>
						</div>
					</div>
					<div class= "col-lg-6 col-md-6 col-sm-6 col-xs-12" style="padding-left:30px;">
						<label for="comment">Remarks: </label>
						<textarea class="form-control" rows="5" style="resize:none;" onkeyup="alphaonlypurpose(this)" id="MMremarks" name="MMremarks"></textarea>
					</div>	
				</div>		         	
			</div>
			<input type="hidden" id="MMID" name="MMID" >
			<!-- </form> -->
			<div class="modal-footer" style="margin-top: -10px;">
				<button type="submit" class="btn btn-default" style="cursor: pointer;" onclick="updateMMDetail()">Update</button>
				<button type="submit" class="btn btn-default" data-dismiss="modal"> Cancel</button>
			</div>

		</div>
	</div>
</div>
<!--Delete  Modal -->
<div class="modal fade" id="deleteMandaliMemberModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content modal-md" >
			<div class="modal-header">
				<h4 style="font-weight:600;" class="modal-title text-center">Confirmation</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">

					<div  class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
						<label for="inputLimit" style="font-size: 14px;" > Member Name:</label>
					</div>
					<div class="col-lg-8 col-md-6 col-sm-6 col-xs-6">
						<input type="text" id="D_Name" style="background: transparent;font-size: 14px; border: none; width: 100%;" name="D_Name" value="" readonly >
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<h5 style="color:#800000">Are you sure you want to delete Mandali member?</h5>
					</div>
				</div>
				<input type="hidden" value="" name="D_SM_ID" id="D_SM_ID"/>
				<input type="hidden" value="" name="D_MM_ID" id="D_MM_ID"/>

			</div>
			<div class="modal-footer">
				<div id="deleteDiv" class="modal-footer" style="clear: both;">
					<button type="button" id="deleteSubmit" onclick="deleteMandaliMemberSubmit()" class="btn btn-default">Delete</button>
					<button type="button" class="btn" data-dismiss="modal">Cancel</button>
				</div>
			</div>

		</div>
	</div>
</div>
<!--Delete  Modal Ends -->
<form id="corpusform" action="" method="post">
	<input type="hidden"  id="sevaname" name="sevaname">
	<input type="hidden"  id="receipt_number" name="receipt_number">
	<input type="hidden"  id="nameph" name="nameph">
	<input type="hidden"  id="deityIdName" name="deityIdName">
	<input type="hidden"  id="addr1" name="addr1">
	<input type="hidden"  id="addr2" name="addr2">
	<input type="hidden"  id="ssstate" name="ssstate">
	<input type="hidden"  id="ssctate" name="ssctate">
	<input type="hidden"  id="sccountry" name="sccountry">
	<input type="hidden"  id="ssid" name="ssid">
	<input type="hidden"  id="cpin" name="cpin">
	<input type="hidden"  id="corpusraiseamt" name="corpusraiseamt">
	<input type="hidden"  id="seseva" name="seseva">
	<input type="hidden"  id="smphone" name="smphone">
	<input type="hidden"  id="smID" name="smID">
	<input type="hidden" id="baseurl" name="baseurl" value="<?php echo $base_url ?>">
	<input type="hidden" id="corpusCallFrom" name="corpusCallFrom" value="shashwathMember"/>
</form>
	
<script src="<?=site_url()?>js/autoComplete.js"></script>
<script>
	var ROI = "<?php if(isset($calendarCheck[0]) != '') {echo $calendarCheck[0]->CAL_ROI; } else echo 0 ;?>";
	// function corpusRaise(ssId,receipt,sName,namePhne,corpadd1,corpadd2,corpcity,corpstate,corpcountry,corppin,rec_price,Shashmin_price,shashSevaCost){
	// 	SSID = ssId;
	// 	let namePhone = namePhne;
	// 	let receiptno = receipt;
	// 	let sevaName = sName;
	// 	let name = namePhne;
	// 	let add1 = corpadd1;
	// 	let add2 = corpadd2;
	// 	let scity = corpcity;
	// 	let sstate = corpstate;
	// 	let scountry = corpcountry;
	// 	let pin = corppin;
	// 	// let presentCorpus = sCorpus;
	// 	$('#name').text(namePhone);
	// 	$('#add1').val(add1);
	// 	$('#add2').val(add2);
	// 	$('#scity').val(scity);
	// 	$('#sstate').val(sstate);
	// 	$('#scountry').val(scountry);
	// 	$('#pin').val(pin);
	// 	$('#receipt').text(receiptno);
	// 	$('#seva').text(sevaName);
	// 	// var corp =((sevaPrice * 100)/ROI);
	// 	// corp = Math.ceil(corp - presentCorpus);
	// 	// let corp = Math.ceil(Shashmin_price - rec_price);
	// 	// (corp <= 0 ? corp = 0:corp = corp);
	// 	let corp=0;
	// 	corp = Math.ceil(Shashmin_price - rec_price);
	// 	if(corp <= 0){
	// 		corp = ((shashSevaCost * 100)/ROI);
	// 		corp = Math.ceil(corp - rec_price);
	// 	}	
	// 	(corp <= 0 ? corp = 0:corp = corp);
	// 	$('#corp').text("Rs. "+corp+"/-");
	// 	$('#namePhone').val(namePhone);
	// 	$('#seva_name').val(sevaName);
	// 	$('#receipt_no').val(receiptno);
	// 	$('#ssId').val(ssId);
	// 	$("#corpusModal").modal();  
	// }

	function corpusRaise(ssId,receipt,sName,namePhne,corpadd1,corpadd2,corpcity,corpstate,corpcountry,corppin,rec_price,Shashmin_price,shashSevaCost,sCorpus,sAmt,noOfSevas,deityName,smphone,smid){
		// $('#sevaname').val(sName);
		$('#receipt_number').val(receipt);
		
		$('#nameph').text(namePhne);
		$('#addr1').val(corpadd1);
		$('#addr2').val(corpadd2);
		$('#sccity').val(corpcity);
		$('#ssstate').val(corpstate);
		$('#sccountry').val(corpcountry);
		$('#cpin').val(corppin);

		let corp = 0;
		corp = Math.ceil(Shashmin_price - rec_price);
		if(corp<=0){
			corp =((shashSevaCost * 100)/ROI)*noOfSevas;
			corp = Math.ceil(corp - rec_price);
		}
		(corp <= 0 ? corp = 0:corp = corp);
		$('#corp').text("Rs. "+corp+"/-");

		$('#corpusraiseamt').val(corp);
		$('#ssid').val(ssId);
		$('#nameph').val(namePhne);

		$('#sevaname').val(sName);
		$('#receipt_number').val(receipt);
		$('#deityIdName').val(deityName);
		
		$('#sevaId').val(ssId);
		$('#smphone').val(smphone);
		$('#smID').val(smid);
		$('#corpusform').attr('action','<?=site_url()?>Shashwath/shaswathaddcorpusdetails');
		$('#corpusform').submit();
	}
	/* raise corpus */
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

	});				
	
	$(".mod .chequeDate3").datepicker({
		dateFormat: 'dd-mm-yy',
		changeYear: true,
		changeMonth: true,
		beforeShow: function() {
			setTimeout(function(){
				$('.ui-datepicker').css('z-index', 99999999999999);
			}, 0);
		}
	});

	$('.mod .chequeDate1').on('click', function () {
		$(".mod .chequeDate3").focus();
	});

	function validateCorpus(){

		let count = 0;
		let modeOfPayment = $('.mod #modeOfPayment option:selected').val();
		let transactionId = $('.mod #transactionId').val();
		var corpus = $('.mod #corpus').val();
		var bookreceiptno = $('.mod #bookreceiptno').val();
		if(bookreceiptno) {
			$('.mod #bookreceiptno').css('border-color', "#800000");
		} else {
			$('.mod #bookreceiptno').css('border-color', "#FF0000");
			++count;
		}

		if(corpus) {
			$('.mod #corpus').css('border-color', "#800000");
		} else {
			$('.mod #corpus').css('border-color', "#FF0000");
			++count;
		}
		if(modeOfPayment == "Cheque") {
			chequeNo = $('.mod #chequeNo').val();
			chequeDate = $('.mod #chequeDateM').val();
			bank = $('.mod #bank').val();
			branch = $('.mod #branch').val();
			if (chequeNo.length == 6) {
				$('.mod #chequeNo').css('border-color', "#800000");
			} else {
				$('.mod #chequeNo').css('border-color', "#FF0000");
				++count;
			}

			if (chequeDate) {
				$('.mod #chequeDateM').css('border-color', "#800000");
			} else {
				$('.mod #chequeDateM').css('border-color', "#FF0000");
				++count;
			}

			if (bank) {
				$('.mod #bank').css('border-color', "#800000");
			} else {
				$('.mod #bank').css('border-color', "#FF0000");
				++count;
			}

			if (branch) {
				$('.mod #branch').css('border-color', "#800000");
			} else {
				$('.mod #branch').css('border-color', "#FF0000");
				++count;
			}
		} else if (modeOfPayment == "Credit / Debit Card") {
			if (transactionId) {
				$('.mod #transactionId').css('border-color', "#800000");
			} else {
				$('.mod #transactionId').css('border-color', "#FF0000");
				++count;
			}
		} else if (modeOfPayment == "Direct Credit") {	
			toBank = $('.mod #tobank').val();
			if (toBank!= 0) {
				$('.mod #tobank').css('border-color', "#800000");
			} else {
				$('.mod #tobank').css('border-color', "#FF0000");
				++count;
			}																				//laz new..
		} else {
			$('.mod #chequeNo').css('border-color', "#800000");
			$('.mod #branch').css('border-color', "#800000");
			$('.mod #bank').css('border-color', "#800000");
			$('.mod #chequeDateM').css('border-color', "#800000");
		}

		if (modeOfPayment) {
			$('.mod #modeOfPayment').css('border-color', "#ccc")
			
		} else {
			$('.mod #modeOfPayment').css('border-color', "#FF0000")
			++count;
		}

		var adlCrpBookDate = $('.mod #adlCrpBookDate').val();
		if (adlCrpBookDate) {
			$('.mod #adlCrpBookDate').css('border-color', "#ccc")
			
		} else {
			$('.mod #adlCrpBookDate').css('border-color', "#FF0000")
			++count;
		}
		
		var isMandaliCheck="<?php echo $members[0]->IS_MANDALI;?>";
		let paidByCheck = $('.mod #paidBy').val();
		if (isMandaliCheck == 1){
			if(paidByCheck) {
				$('.mod #paidBy').css('border-color', "#800000");
			} else {
				$('.mod #paidBy').css('border-color', "#FF0000");
				++count;
			}
		}
		
		if (count != 0) {
			alert("Information", "Please fill required fields", "OK");
			return false;
		}

	}
	 //INPUT KEYPRESS
	 $(':input').on('keypress change', function() {
	 	var id = this.id;
	 	try {$('#' + id).css('border-color', "#000000");}catch(e) {}

	 });
	
	//Corpus Raise History
	var arrCorpusDetails;
	function corpusRaiseDetails(ssId){
		let SSID = ssId;
		let url = "<?=site_url()?>Shashwath/get_corpus_history";
		$.post(url, {'ss_id': SSID}, function (e) {

			e1 = e.split("|")
			if (e1[0] == "success") {
				arrCorpusDetails = JSON.parse(e1[1]);
				arr = arrCorpusDetails[0].IS_MANDALI;

				let Tot_Corpus = 0;
				for (i = 0; i <arrCorpusDetails.length; ++i) {
					Tot_Corpus +=  parseInt(arrCorpusDetails[i].RECEIPT_PRICE);//;
				}
				$('#viewCorpusDetails').html('');
				$('.viewCorpusHistory').html('');
				$('.viewCorpusHistory').append('<h5><b>Deity Name : ' + arrCorpusDetails[0].DEITY_NAME + '</b></h5>');
				$('.viewCorpusHistory').append('<h5><b>Seva Name  : ' + arrCorpusDetails[0].SEVA_NAME + '</b></h5>');
				$('.viewCorpusHistory').append('<h5><b>Total Corpus  : ' + Tot_Corpus + '</b></h5>');
				if(arr == 1){
					$('.viewCorpusHistory').append('<div class="table-responsive" style ="overflow-x:hidden;"><table class="table"><thead><tr><th style="border:1px solid #7d6363"><center>Sl. No.</center></th><th style="border:1px solid #7d6363"><center>Book RNo</center></th><th style="border:1px solid #7d6363"><center>Receipt Date</center></th><th ><center>PaidBy</center></th><th style="border:1px solid #7d6363"><center>New RNo.</center></th><th style="border:1px solid #7d6363"><center>Qty</center></th><th style="border:1px solid #7d6363"><center>Corpus</center></th></tr></thead><tbody id="viewCorpusDetails" ></tbody></table></div>');
				}else{
					$('.viewCorpusHistory').append('<div class="table-responsive" style ="overflow-x:hidden;"><table class="table"><thead><tr><th style="border:1px solid #7d6363"><center>Sl. No.</center></th><th style="border:1px solid #7d6363"><center>Book RNo</center></th><th style="border:1px solid #7d6363"><center>Receipt Date</center></th><th style="border:1px solid #7d6363"><center>New RNo.</center></th><th style="border:1px solid #7d6363"><center>Qty</center></th><th style="border:1px solid #7d6363"><center>Corpus</center></th></tr></thead><tbody id="viewCorpusDetails" ></tbody></table></div>');
				}
				for (i = arrCorpusDetails.length; i > 0; --i) {
					$('#viewCorpusDetails').append('<tr>');
					$('#viewCorpusDetails').append('<td style="border:1px solid #7d6363"><center>' + (i)  + '</center></td>');
					$('#viewCorpusDetails').append('<td style="border:1px solid #7d6363"><center>' + arrCorpusDetails[i-1].SS_RECEIPT_NO_REF + '</td>');
					$('#viewCorpusDetails').append('<td style="border:1px solid #7d6363"><center>' + arrCorpusDetails[i-1].RECEIPT_DATE + '</td>');
					$('#viewCorpusDetails').append('<td style="border:1px solid #7d6363"><center>' + arrCorpusDetails[i-1].RECEIPT_NO + '</td>');
					
					if( arrCorpusDetails[i-1].IS_MANDALI == 1){
						if(arrCorpusDetails[i-1].MM_NAME == null){
							$('#viewCorpusDetails').append('<td style="border:1px solid #7d6363"><center></td>');	
						}else{
							$('#viewCorpusDetails').append('<td style="border:1px solid #7d6363"><center>' + arrCorpusDetails[i-1].MM_NAME + '</td>');
						}
					}
					
					$('#viewCorpusDetails').append('<td style="border:1px solid #7d6363"><center>' + arrCorpusDetails[i-1].SEVA_QTY + '</center></td>');
					$('#viewCorpusDetails').append('<td style="border:1px solid #7d6363"><center>' + arrCorpusDetails[i-1].RECEIPT_PRICE + '</center></td>');
					$('#viewCorpusDetails').append('</tr><br/>');
				}
			}
			else
				alert("Something went wrong, Please try again after some time");
		});
	}

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
		}else{
			document.getElementById("First").style.display ="none";
			document.getElementById("months").style.display ="none";

		}

		if(document.getElementById("weekMonth").value =='Year'){
				document.getElementById("First").style.display ="block";
				document.getElementById("weekMonth").style.display ="block";
				document.getElementById("months").style.display ="block";

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
	
	/*$('#HinduCal').on('click', function () {
		$('#multiDate').datepicker('setDate', null);
		$('#multiDate').datepicker('resetDates');
		$('#multiDate').val(""); 
	});*/

	$(document).ready(function() { 
		$('#update').css('display','block');
		$('#submitRecord').css('display','none');
		
		let afterDelete = "<?php echo @$afterDelete ?>";
		if(afterDelete!=""){
			goToTabShashwathSevaDetails();
		}
	})

	//var smId="<?php echo $members[0]->SM_ID;?>";
	function updateData() {
		var id="<?php echo $members[0]->SM_ID;?>";

		let name = "";
		let number = "";
		let number2 = "";
		let rashi = "";
		let gotra = "";
		let nakshatra = "";
		let addrline1 = "";
		let addrline2 = "";
		let smcity = "";
		let smstate ="";
		let smcountry = "";
		let smpin = "";
		let smremarks = "";
		let receiptLine1 = $('receiptLine1').val();
		
		var isMandaliCheck="<?php echo $members[0]->IS_MANDALI;?>";
		if (isMandaliCheck != 1){
			name = $('#name').val().trim();
			number = $('#phone').val();
			number2= $('#phone2').val();
			smcity = $('#smcity').val().trim();
			smstate =  $('#smstate').val().trim();
			smcountry = $('#smcountry').val().trim();
			smpin = $('#smpin').val();
			smremarks = $('#smremarks').val().trim();
			addrline1 = $('#addrline1').val().trim();
			addrline2 = $('#addrline2').val().trim();
			rashi = $('#rashi').val();
			gotra = $('#gotra').val().trim();
			nakshatra = $('#nakshatra').val();
		} else {
			name = $('#mandaliName').val().trim();
			number = $('#mandaliPhone').val();
			number2= $('#mandliPhone2').val();
			smcity =  $('#mandlicity').val().trim();
			smstate = $('#mandliState').val().trim();
			smcountry = $('#mandliCountry').val().trim();
			smpin = $('#mandliPin').val();
			smremarks = $('#mandliRemarks').val().trim();
			addrline1 = $('#mandliAddrline1').val().trim();
			addrline2 = $('#mandliAddrline2').val().trim();
		}

		$.ajax({
			type: "POST",
			url: "<?= site_url();?>Shashwath/updateMember",
			data: {"id": id,"name": name,"number": number,"number2": number2,"rashi": rashi,"nakshatra": nakshatra,"gotra": gotra, "addrline1": addrline1,"addrline2": addrline2,"smcity": smcity,"smstate": smstate,
			"smcountry": smcountry,"smpin": smpin,"smremarks":smremarks,"receiptLine1":receiptLine1},  // fix: need to append your data to the call
	        //lathesh code ,"receiptLine1":receiptLine1 !!!!!!!!!!!!!!!!!!!!!!
	        success: function (data) {
				//alert(data);
			}
		});
		setTimeout(function(){window.location.href="<?= site_url();?>Shashwath/shashwath_member"},500);		
	}

	function update() {
		var id="<?php echo $members[0]->SM_ID;?>";
		let name = "";
		let number = "";
		let number2 = "";
		let rashi = "";
		let gotra = "";
		let nakshatra = "";
		let addrline1 = "";
		let addrline2 = "";
		let smcity = "";
		let smstate = "";
		let smcountry = "";
		let smpin = "";
		let smremarks = "";
		let receiptLine1 = $('receiptLine1').val();

		var isMandaliCheck="<?php echo $members[0]->IS_MANDALI;?>";
		if (isMandaliCheck != 1){
			name = $('#name').val().trim();
			number = $('#phone').val();
			number2= $('#phone2').val();
			smcity = $('#smcity').val().trim();
			smstate = $('#smstate').val().trim();
			smcountry = $('#smcountry').val().trim();
			smpin = $('#smpin').val();
			smremarks = $('#smremarks').val().trim();
			addrline1 = $('#addrline1').val().trim();
			addrline2 = $('#addrline2').val().trim();
			rashi = $('#rashi').val();
			gotra = $('#gotra').val().trim();
			nakshatra = $('#nakshatra').val();
		} else {
			name = $('#mandaliName').val().trim();
			number = $('#mandaliPhone').val();
			number2= $('#mandliPhone2').val();
			smcity =  $('#mandlicity').val().trim();
			smstate = $('#mandliState').val().trim();
			smcountry = $('#mandliCountry').val().trim();
			smpin = $('#mandliPin').val();
			smremarks = $('#mandliRemarks').val().trim();
			addrline1 = $('#mandliAddrline1').val().trim();
			addrline2 = $('#mandliAddrline2').val().trim();
		}

		$.ajax({
			type: "POST",
			url: "<?= site_url();?>Shashwath/updateMember",
			data: {"id": id,"name": name,"number": number,"number2": number2,"rashi": rashi,"nakshatra": nakshatra, "gotra":gotra, "addrline1": addrline1,"addrline2": addrline2,"smcity": smcity,"smstate": smstate,
			"smcountry": smcountry,"smpin": smpin,"smremarks":smremarks,"receiptLine1":receiptLine1},  // fix: need to append your data to the call
	        //lathesh code ,"receiptLine1":receiptLine1 !!!!!!!!!!!!!!!!!!!!
	        
	        success: function (data) {
				//alert(data);
			}
		});
	}

	function alphaonly(input) {
		var regex=/[^a-z ]/gi;
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
			
			//alert("information","yes");
		} else {
			$("#addLine1").attr("disabled", true);
			$("#addLine2").attr("disabled", true);
			$("#city").attr("disabled", true);
			$("#state").attr("disabled", true);
			$("#country").attr("disabled", true);
			$("#pincode").attr("disabled", true);

		}
	}
	// function hideReciptEntry(ths) {	
	// 	if(ths.checked) {
	// 		$("#receiptLine1").attr("disabled", false);
	// 		$("#receiptLine2").attr("disabled", false);
	// 		$("#receiptLine3").attr("disabled", false);
	// 		//alert("information","yes");
	// 	} else {
	// 		$("#receiptLine1").attr("disabled", true);
	// 		$("#receiptLine2").attr("disabled", true);	
	// 		$("#receiptLine3").attr("disabled", true);
	// 	}
	// }
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
	
	$('#modeOfPayment').on('change', function () {							//laz
		if (this.value == "Cheque") {
			$('#showChequeList').fadeIn("slow");
			$('#showDebitCredit').fadeOut("slow");
			$('#showDirectCredit').fadeOut("slow");
		}
		else if (this.value == "Credit / Debit Card") {
			$('#showChequeList').fadeOut("slow");
			$('#showDebitCredit').fadeIn("slow");
			$('#showDirectCredit').fadeOut("slow");

		} 
		else if (this.value == "Direct Credit") {				
			$('#showChequeList').fadeOut("slow");
			$('#showDebitCredit').fadeOut("slow");
			$('#showDirectCredit').fadeIn("slow");
		}														
		else {
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
		let transactionId = $('#transactionId').val().trim();

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
		if(sevaCombo[10] == 1){
			sevaType = "occasional";
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
			}																				
		} else if (modeOfPayment == "Direct Credit") {									
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

/* 		if (modeOfPayment) {
			$('#modeOfPayment').css('border-color', "#ccc")

		} else {
			$('#modeOfPayment').css('border-color', "#FF0000")
			++count;
		} */

		if (name) {
			$('#name').css('border-color', "#ccc")

		} else {
			$('#name').css('border-color', "#FF0000")
			++count;
		}
		/* if (number) {
			$('#phone').css('border-color', "#ccc")

		} else {
			$('#phone').css('border-color', "#FF0000")
			++count;
		} */

		if (count != 0) {
			alert("Information", "Please fill required fields", "OK");
			return false;
		} 

		let tableContentMM = getMandaliTableValues1();
		if(tableContentMM['name'].length>0){
			var smIdValMM="<?php echo $members[0]->SM_ID;?>";
			let addressMM = [];
			let addressLine1MM = [];
			let addressLine2MM = [];
			let cityMM = [];
			let stateMM = [];
			let countryMM = [];
			let pincodeMM = [];
			let rashiMM = [];
			let gotraMM = [];
			let nakshatraMM = [];
			let numberMM = [];
			let number2MM = [];
			let remarksMM = [];
			let nameMM = [];

			//let total = 1/* $('#totalAmount').html().trim() */;
			let url1 = "<?=site_url()?>Shashwath/newMandalimemberinsert";
			for (let i = 0; i < tableContentMM['name'].length; ++i) {
				nameMM[i] = tableContentMM['name'][i].innerHTML.trim();
				numberMM[i] = tableContentMM['number'][i].innerHTML.trim();
				number2MM[i] = tableContentMM['number2'][i].innerHTML.trim();
				rashiMM[i] = tableContentMM['rashi'][i].innerHTML.trim();
				nakshatraMM[i] = tableContentMM['nakshatra'][i].innerHTML.trim();
				gotraMM[i] = tableContentMM['gotra'][i].innerHTML.trim();
				addressLine1MM[i] = tableContentMM['addressLine1'][i].innerHTML.trim();
				addressLine2MM[i] = tableContentMM['addressLine2'][i].innerHTML.trim();
				cityMM[i] = tableContentMM['city'][i].innerHTML.trim();
				stateMM[i] = tableContentMM['state'][i].innerHTML.trim();
				countryMM[i] = tableContentMM['country'][i].innerHTML.trim();
				pincodeMM[i] = tableContentMM['pincode'][i].innerHTML.trim();
				remarksMM[i] = tableContentMM['remarks'][i].innerHTML.trim();		
			}
			$.post(url1, {'name': JSON.stringify(nameMM),'number': JSON.stringify(numberMM),'number2': JSON.stringify(number2MM),'rashi': JSON.stringify(rashiMM),'gotra': JSON.stringify(gotraMM), 'nakshatra': JSON.stringify(nakshatraMM), 'addressLine1': JSON.stringify(addressLine1MM), 'addressLine2': JSON.stringify(addressLine2MM), 'city': JSON.stringify(cityMM),'state':JSON.stringify(stateMM), 'country': JSON.stringify(countryMM), 'pincode': JSON.stringify(pincodeMM), 'remarks': JSON.stringify(remarksMM),'smIdVal':smIdValMM }, function (e) {
				e1 = e.split("|")
				if (e1[0] == "success"){

				}else
				alert("Something went wrong, Please try again after some time");
			});
		}

		var smId="<?php echo $members[0]->SM_ID;?>";
		let masa1 = [];
		let bomcode1 = [];
		let thithiName1 = [];
		let sevaName = [];
		
		let corpus = [];
		let purpose=[];
		let ssreceipt_no=[];
		let ssreceipt_date=[];
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
		let periodId=[];
		let everyweekMonth = [];

		var isMandaliCheck="<?php echo $members[0]->IS_MANDALI;?>";
		if (isMandaliCheck != 1){
			name = name;
			number = number;
			number2= number2;
			smcity = smcity;
			smstate = smstate;
			smcountry = smcountry;
			smpin = smpin;
			smremarks = smremarks;
			addrline1 = addrline1;
			addrline2 = addrline2;
		} else {
			name = mandaliName;
			number = mandaliPhone;
			number2= mandliPhone2;
			smcity =  mandliPin;
			smstate = mandlicity;
			smcountry = mandliState;
			smpin = mandliPin;
			smremarks = mandliRemarks;
			addrline1 = mandliAddrline1;
			addrline2 = mandliAddrline2;
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

		let total = 1;/* $('#totalAmount').html().trim() */;
		let url = "<?=site_url()?>Receipt/generateReceipt";

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
		if (tableContent['sevaName'].length) {
			for (let i = 0; i < tableContent['sevaName'].length; ++i) {
				sevaName[i] = tableContent['sevaName'][i].innerHTML.trim();
				isSeva[i] = tableContent['isSeva'][i].innerHTML.trim();
				deityName[i] = tableContent['deityName'][i].innerHTML.trim();
				corpus[i] = tableContent['corpus'][i].innerHTML.trim();
				purpose[i] = tableContent['purpose'][i].innerHTML.trim();
				ssreceipt_no[i] = tableContent['ssreceipt_no'][i].innerHTML.trim();
				ssreceipt_date[i] = tableContent['ssreceipt_date'][i].innerHTML.trim();
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
			
			$.post(url, { 'transactionId': transactionId, 'chequeNo': chequeNo, 'branch': branch, 'bank': bank, 'chequeDate': chequeDate, 'modeOfPayment': modeOfPayment, 'sevaName': JSON.stringify(sevaName), 'sevaQty': JSON.stringify(sevaQty),'deityName': JSON.stringify(deityName), 'corpus': JSON.stringify(corpus),'thithi': JSON.stringify(thithi),'purpose':JSON.stringify(purpose),'date': JSON.stringify(dateMonth1),'sevaId': JSON.stringify(sevaId), 'userId': JSON.stringify(userId), 'quantityChecker': JSON.stringify(quantityChecker), 'revFlag': JSON.stringify(revFlag), 'deityId': JSON.stringify(deityId), 'isSeva': JSON.stringify(isSeva),'masa1':JSON.stringify(masa1),'bomcode1':JSON.stringify(bomcode1),'thithiName1':JSON.stringify(thithiName1), 'name': name, 'number': number, 'number2': number2, 'rashi': rashi,'gotra': gotra, 'nakshatra': nakshatra, 'paymentNotes': paymentNotes, 'date_type': date_type, 'postage': JSON.stringify(postage), 'addressLine1': JSON.stringify(addressLine1), 'addressLine2': JSON.stringify(addressLine2), 'city': JSON.stringify(city),'state':JSON.stringify(state), 'country': JSON.stringify(country), 'pincode': JSON.stringify(pincode),'address':JSON.stringify(address), 'addrline1':addrline1,'addrline2':addrline2,'smcity':smcity,'smstate':smstate,'smcountry':smcountry,'smpin':smpin,'smremarks':smremarks,'sevaType':sevaType,'calType1':JSON.stringify(calType1),'periodId':JSON.stringify(periodId),'ss_receipt_no':JSON.stringify(ssreceipt_no),'ss_receipt_date':JSON.stringify(ssreceipt_date), 'sm_id': smId,'fglhBank': fglhBank,'everyweekMonth':  JSON.stringify(everyweekMonth),'type':JSON.stringify(type),'ledgers':JSON.stringify(ledgers),'amount':JSON.stringify(amount),'ledgerName':JSON.stringify(ledgerName),'naration':naration,'corpustot':corpustot }, function (e) {

				e1 = e.split("|")
				if (e1[0] == "success") {
					
				}
				else
					alert("Something went wrong, Please try again after some time");
			});
		}
		$('#form').submit();
	});

	//COMPARING DATES
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
		let number = $('#phone').val();
		let number2 = $('#phone2').val();
		let name = $('#name').val();
		let rashi = $('#rashi').val();
		let gotra = $('#gotra').val();
		let nakshatra = $('#nakshatra').val();
		let paymentNotes = $('#paymentNotes').val();
		let chequeNo = "";
		let bank = "";
		let chequeDate = "";
		let branch = "";
		let tableContent = getTableValues();
		let tableContentMM = getMandaliTableValues1();
		let modeOfPayment = $('#modeOfPayment option:selected').val();
		let toBank = $('#tobank option:selected').val();                    //laz
		let DCtoBank = $('#DCtobank option:selected').val();				//laz new
		let transactionId = $('#transactionId').val();
		if (tableContent['sevaName'].length == 0 && tableContentMM['name'].length == 0) {
			alert("Information", "Enter all the required fields to submit.");
			return;
		}
		//SMAddress
		let addrline1 = $('#addrline1'); 
		let addrline2 = $('#addrline2'); 
		let smcity = $('#smcity');
		let smstate = $('#smstate');
		let smcountry = $('#smcountry');
		let smpin = $('#smpin');
		let smAddress = "";		
		
		if (tableContent['sevaName'].length != 0){
			if(addrline1.val().trim().length > 0) {
				smAddress += addrline1.val() + ", ";
				addrline1.css('border-color', "#800000");
			}	
			if(addrline2.val().trim().length > 0) {
				smAddress += addrline2.val() + ", ";
			}
			
			if(smstate.val().trim().length > 0) {
				smAddress += smstate.val() + ", ";
				smstate.css('border-color', "#800000");
			}	
			if(smcountry.val().trim().length > 0) {
				smAddress += smcountry.val() + ", ";
				smcountry.css('border-color', "#800000");
			}
			
			if(smpin.val().trim().length > 0) {
				smAddress += smpin.val();
				smpin.css('border-color', "#800000");
			} 

			if (name) {
				$('#name').css('border-color', "#ccc")
			} else {
				$('#name').css('border-color', "#FF0000")
				++count;
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
			} else if (modeOfPayment == "Credit / Debit Card") {							
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
			} else if (modeOfPayment == "Direct Credit") {									
				if (toBank!=0) {
					$('#tobank').css('border-color', "#800000");
				} else {
					$('#tobank').css('border-color', "#FF0000");
					++count;
				}																			
			} else {
				$('#chequeNo').css('border-color', "#800000");
				$('#branch').css('border-color', "#800000");
				$('#bank').css('border-color', "#800000");
				$('#chequeDate').css('border-color', "#800000");
			}

			if (modeOfPayment) {
				$('#modeOfPayment').css('border-color', "#ccc")

			} else {
				$('#modeOfPayment').css('border-color', "#FF0000")
				++count;
			}	

			if (count != 0) {
				alert("Information", "Please fill required fields", "OK");
				return false;
			}
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
		let price = [];
		let amt = [];
		let sevaId = [];
		let userId = [];
		let quantityChecker = [];
		let deityId = [];
		let deityName = [];
		let isSeva = [];
		let address = [];

		let total = 1 /* $('#totalAmount').html().trim() */;
		let url = "<?=site_url()?>Receipt/generateDeityReceipt";

		if (tableContent['sevaName'].length != 0){
			$('.addlShashSeva').html('<div class="table-responsive" style="overflow-x:hidden"><table class="table"><thead><tr><th style="border:1px solid #7d6363"><center>Sl. No.</center></th><th style="border:1px solid #7d6363"><center>R.No.</center></th><th style="border:1px solid #7d6363"><center>Receipt Date</center></th><th style="border:1px solid #7d6363">Deity Name</th><th style="border:1px solid #7d6363">Seva Name</th><th style="border:1px solid #7d6363"><center>Qty</center></th><th style="border:1px solid #7d6363"><center>Corpus</center></th><th style="border:1px solid #7d6363"><center>Seva Date</center></th><th style="border:1px solid #7d6363"><center>Thithi Code</center></th><th style="border:1px solid #7d6363"><center>Week/Month</center></th><th style="border:1px solid #7d6363"><center>Period</center></th><th style="border:1px solid #7d6363"><center>Postage Address</center></th></tr></thead><tbody id="eventUpdate2"></tbody></table></div>');

			$('#eventUpdate2').html("");		

			for (i = 0; i < tableContent['sevaName'].length; ++i) {
				$('#eventUpdate2').append("<tr>");
				$('#eventUpdate2').append("<td style='border:1px solid #7d6363'>" + tableContent['si'][i].innerHTML + "</td>");
				$('#eventUpdate2').append("<td style='border:1px solid #7d6363'>" + tableContent['ssreceipt_no'][i].innerHTML + "</td>");
				$('#eventUpdate2').append("<td style='border:1px solid #7d6363'>" + tableContent['ssreceipt_date'][i].innerHTML + "</td>");
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

			$('.addlShashSeva').append("<label>DATE:</label> " + "<?=date('d-m-Y'); ?>" + "<br/>");
			$('.addlShashSeva').append("<label>NAME:</label> " + name + "");
			if (number)
				$('.addlShashSeva').append(",&nbsp;&nbsp;<label>NUMBER:</label> " + number + "");
			if (number2)
				$('.addlShashSeva').append(",&nbsp;&nbsp;<label>NUMBER2:</label> " + number2 + "");
			$('.addlShashSeva').append("<br/>");
			if (rashi)
				$('.addlShashSeva').append("<label>RASHI:</label> " + rashi + ",&nbsp;&nbsp;");
			if (gotra)
				$('.addlShashSeva').append("<label> GOTRA:</label> " + gotra + ",&nbsp;&nbsp;");
			if (nakshatra)
				$('.addlShashSeva').append("<label>NAKSHATRA:</label> " + nakshatra + "");
			$('.addlShashSeva').append("<br/>");
			
			/*if(address)
			$('.addlShashSeva').append("<label>POSTAGE ADDRESS:</label> "+ address +"<br/>");*/
			
			if(smAddress)
				$('.addlShashSeva').append("<label>ADDRESS:</label> "+ smAddress +"<br/>");
			$('.addlShashSeva').append("<label>MODE OF PAYMENT:</label> " + modeOfPayment + "<br/>");

			if (modeOfPayment == "Cheque") {
				$('.addlShashSeva').append("<label>CHEQUE NO:</label> " + chequeNo + ",&nbsp;&nbsp;");
				$('.addlShashSeva').append("<label>CHEQUE DATE:</label> " + chequeDate + ",&nbsp;&nbsp;");
				$('.addlShashSeva').append("<label>BANK:</label> " + bank + ",&nbsp;&nbsp;");
				$('.addlShashSeva').append("<label>BRANCH:</label> " + branch + "<br/>");


			} else if (modeOfPayment == "Credit / Debit Card") {
				$('.addlShashSeva').append("<label>TRANSACTION ID:</label> " + transactionId + "<br/>");
			}else if (modeOfPayment == "Transfer") {
				$('.addlShashSeva').append("<label style='color:#FF0000'>You Cannot Cancel The Transfered / Adjustment Receipt Once it is Suubmitted.</label>");
			}
			if (paymentNotes)
				$('.addlShashSeva').append("<br/><label>PAYMENT NOTES:</label> " + paymentNotes + "");
		}

		if (tableContentMM['name'].length != 0){
			$('.addlShashSeva').append('<h4>New Mandali Members:</h4>');
			$('.addlShashSeva').append('<div class="table-responsive table" style="overflow-x:hidden"><table class="table"><thead><tr><th style="border:1px solid #7d6363"><center>name</center></th><th style="border:1px solid #7d6363"><center>number</center></th><th style="border:1px solid #7d6363">rashi</th><th style="border:1px solid #7d6363">nakshatra</th><th style="border:1px solid #7d6363"><center>gotra</center></th><th style="border:1px solid #7d6363"><center>address</center></th><th style="border:1px solid #7d6363"><center>remarks</center></th></tr></thead><tbody id="mandaliMemUpdate"></tbody></table></div>');

			$('#mandaliMemUpdate').html("");		
			for (i = 0; i < tableContentMM['name'].length; ++i) {
				$('#mandaliMemUpdate').append("<tr>");
				$('#mandaliMemUpdate').append("<td style='border:1px solid #7d6363'>" + tableContentMM['name'][i].innerHTML + "</td>");
				$('#mandaliMemUpdate').append("<td style='border:1px solid #7d6363'>" + tableContentMM['number'][i].innerHTML + ", "+ tableContentMM['number2'][i].innerHTML + "</td>");
				$('#mandaliMemUpdate').append("<td style='border:1px solid #7d6363'>" + tableContentMM['rashi'][i].innerHTML + "</td>");
				$('#mandaliMemUpdate').append("<td style='border:1px solid #7d6363'>" + tableContentMM['nakshatra'][i].innerHTML + "</td>");
				$('#mandaliMemUpdate').append("<td style='border:1px solid #7d6363'><center>" + tableContentMM['gotra'][i].innerHTML + "</center></td>");
				$('#mandaliMemUpdate').append("<td style='border:1px solid #7d6363'><center>" + tableContentMM['addressLine1'][i].innerHTML + ", " + tableContentMM['addressLine2'][i].innerHTML + ", " + tableContentMM['city'][i].innerHTML + ", " + tableContentMM['state'][i].innerHTML + ", " + tableContentMM['country'][i].innerHTML + ", " + tableContentMM['pincode'][i].innerHTML + "</center></td>");
				$('#mandaliMemUpdate').append("<td style='border:1px solid #7d6363'><center>" + tableContentMM['remarks'][i].innerHTML + "</center></td>");
				$('#mandaliMemUpdate').append("</tr><br/>");
			}
		}

		$('#validateModal').modal();
		$('.bs-example-modal-lg').focus();
	}

	function deityComboChange() {
		bgNo = $('#deityCombo').val();
		$('#sevaCombo').html("");
		for (let i = 0; i < arr.length; ++i) {
			if (arr[i]['DEITY_ID'] == bgNo)
				if(arr[i]['REVISION_STATUS'] == 1)
					$('#sevaCombo').append('<option value="' + arr[i]['DEITY_ID'] + "|" + arr[i]['SEVA_ID'] + "|" + arr[i]['SEVA_NAME'] + "|" + arr[i]['USER_ID'] + "|" + arr[i]['SEVA_PRICE'] + "|" + arr[i]['QUANTITY_CHECKER'] + "|" + arr[i]['IS_SEVA'] + "|" + arr[i]['OLD_PRICE'] + "|" + arr[i]['REVISION_STATUS'] + "|" + arr[i]['REVISION_DATE']+"|" + arr[i]['BOOKING'] + "|" + arr[i]['SHASH_PRICE'] + '">' + arr[i]['SEVA_NAME']+"  =  "+ (arr[i]['BOOKING'] == 1 ? "Occasional" :"Regular") + '</option>');
				
				
				else
					$('#sevaCombo').append('<option value="' + arr[i]['DEITY_ID'] + "|" + arr[i]['SEVA_ID'] + "|" + arr[i]['SEVA_NAME'] + "|" + arr[i]['USER_ID'] + "|" + arr[i]['SEVA_PRICE'] + "|" + arr[i]['QUANTITY_CHECKER'] + "|" + arr[i]['IS_SEVA'] + "|" + arr[i]['OLD_PRICE'] + "|" + arr[i]['REVISION_STATUS'] + "|" + arr[i]['REVISION_DATE'] +"|" + arr[i]['BOOKING'] + "|" + arr[i]['SHASH_PRICE'] + '">' + arr[i]['SEVA_NAME'] +"  =  "+((arr[i]['BOOKING'] == 1) ? "Occasional" :"Regular") + '</option>');
				

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
						$('#sevaCombo').append('<option value="' + arr[i]['DEITY_ID'] + "|" + arr[i]['SEVA_ID'] + "|" + arr[i]['SEVA_NAME'] + "|" + arr[i]['USER_ID'] + "|" + arr[i]['SEVA_PRICE'] + "|" + arr[i]['QUANTITY_CHECKER'] + "|" + arr[i]['IS_SEVA'] + "|" + arr[i]['SHASH_PRICE'] + '">' + arr[i]['SEVA_NAME'] + "  =  "+((arr[i]['BOOKING'] == 1) ? "Occasional" :"Regular") + '</option>');
				}

				let sevaCombo = getSevaCombo();

				$('#setPrice').html(sevaCombo.sevaPrice);

				if ($('#radioOpt').val() != "EveryRadio") {
					if (sevaCombo.quantityChecker == "1") {
						$('.corpus').fadeIn("slow");
					} else {
				//$('.corpus').hide();
			}
		} else {

		}
		deityComboChange();
	}());

			$('#transactionId').keyup(function () {
				var $th = $(this);
				$th.val($th.val().replace(/[^A-Za-z0-9]/g, function (str) { return ''; }));
			});

	// < !--Cheque Number Validation-- >
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
		//$('.corpus').hide();
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
			//	$('.corpus').hide();
		}
	} else {

	} 

	if ($('#radioOpt').val() != "EveryRadio") {
		if (sevaCombo.quantityChecker == "1") {
			$('.corpus').fadeIn("slow");
		} else {
				//$('.corpus').hide();
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
		
		$("#update").css('display','none');
		$("#submitRecord").css('display','block');
		
		let duplicate = checkDuplicate();
		if (duplicate != 0)
			return;

		let tableContent = getTableValues();

		if (tableContent['sevaName'].length > 0 && $('#radioOpt').val() != "multiDateRadio") {
			alert("Information", "Please remove added seva dates to add new recurring seva dates")
			return;
		}
		
        //let thithi = document.getElementById("masaCode").value+document.getElementById("bomCode").value+document.getElementById("thithiCode").value;
        let name = $('#name').val()
        let number = $('#number').val()
        let number2 = $('#number2').val()
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
        let ssreceipt_no = $('#receiptLine1').val();
        let ssreceipt_date = $('#receiptLine2').val();
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
        date = $("#multiDate").val();

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
        let everyMonthval = document.getElementById("masaevery").value.split("|");
         let everyWeekMonthval = $('#weekMonth option:selected').val();
		let everyDayVal = $('#selectday option:selected').val();
		let everyFivedaysval = $('#everyFivedaysval option:selected').val();
		let modeOfChangeMonth = $('#modeOfChangeMonth option:selected').val();
		let weekMonth = $('#weekMonth option:selected').val();
	
		if($('#everyWeekMonth').prop('checked')) {
        	// if(everyDayVal == ""){
        	// 	$('#selectday').css('border-color', "#FF0000")

        	// 	alert("Information","Please select appropriate Day for seva");
        	// 	return;
        	// }
        	// if(weekMonth == ""){
        	// 	$('#weekMonth').css('border-color', "#FF0000")
        		
        	// 	alert("Information","Please select appropriate option");
        	// 	return;
        	// }
        }

		if(document.getElementById("weekMonth").value == "Year") {
			if(everyDayVal == ""){
				$('#selectday').css('border-color', "#FF0000")
				 alert("Information","Please select appropriate day for seva");
				 return;
			}
			if(everyFivedaysval == ""){
				$('#everyFivedaysval').css('border-color', "#FF0000")
				 alert("Information","Please select appropriate days for seva");
				 return;
			}
			if(modeOfChangeMonth == ""){
				$('#modeOfChangeMonth').css('border-color', "#FF0000")
				 alert("Information","Please select appropriate Month for seva");
				 return;
			}
			
		}

		if(document.getElementById("weekMonth").value == "Month") {
			if(everyDayVal == ""){
				$('#selectday').css('border-color', "#FF0000")
				 alert("Information","Please select appropriate day for seva");
				 return;
			}
			if(everyFivedaysval == ""){
				$('#everyFivedaysval').css('border-color', "#FF0000")
				 alert("Information","Please select appropriate days for seva");
				 return;
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
        if (receiptLine1) {
			$('#receiptLine1').css('border-color', "#800000");
		} else {
			$('#receiptLine1').css('border-color', "#FF0000");
			++count;
		}
		if (receiptLine2) {
			$('#receiptLine2').css('border-color', "#800000");
		} else {
			$('#receiptLine2').css('border-color', "#FF0000");
			++count;
		}

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

        if(document.getElementById("manualreceipt").checked == true) {
        	if($('#receiptLine1').val() != "" && $('#receiptLine2').val() != "") {
        		ssreceipt_no = $('#receiptLine1').val();
        		ssreceipt_date = $('#receiptLine2').val();
        	} else 
        	count++;
        } else {
        	ssreceipt_no =  "";
        	ssreceipt_date = "";
        }	

        if(date == "" && $('#gregorian').prop('checked')){
        	alert("please select date for seva");
        	return false;
        } else {
        	dateMonth1 = dateMonth.split(",");
        	date2 = date.split(",");
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
				//$('.corpus').hide();
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

	 	if($('#corpus').val() < Number($('#totMinAmt').html()))					//SLAP
	 	{
	 		alert("Information","The Corpus Entered does not match with min Corpus Amount based on qty Provided!!!");
	 		return;
	 	}

	 	let si = $('#eventSeva tr:last-child td:first-child').html();
	 	console.log(si);
	 	if (!si)
	 		si = 1
	 	else
	 		++si;

	 	console.log(si);

	 	let amt = 0;
		//$("#code").submit();
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
				var e = document.getElementById("periodCombo").value.split("|");
				masaCode = document.getElementById("masaCode").value.split("|");
				bomcode = document.getElementById("bomCode").value.split("|");
				if(bomcode[0] == 'SH') {
					thithiCode = document.getElementById("thithiCode").value.split("|");
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
				if(thithi1!="")
				{
					thithi = thithi1;
				}
				else if(thithi2!="")
				{
					thithi = thithi2;
				}
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

			  	let calType1 = " ";
			  	if($('#hindu').prop('checked')){
			  		calType1 = 'Hindu';
			  		document.getElementById('HinduCal').style.display = "block";
			  		document.getElementById("masaCode").selectedIndex = 0;
			  		document.getElementById("thithiCode").selectedIndex = 0;
			  		document.getElementById("thithiCode1").selectedIndex = 0;
			  		document.getElementById("bomCode").selectedIndex = 0;
			  	}else if($('#Gregorian').prop('checked')){
			  		calType1 = 'Gregorian';
			  		document.getElementById('GregorianCal').style.display = "block";
			  	}
			  	else if($('#festivalwise').prop('checked')){
			  		calType1 = 'Festivalwise';
			  		document.getElementById('FestvalCal').style.display = "block";
			  	}
			  	else if($('#everyWeekMonth').prop('checked')){
			  		calType1 = 'Every';
			  		document.getElementById('EveryWeekMonth').style.display = "block";
			  		document.getElementById('First').style.display = "none";

			  		document.getElementById('masaevery').style.display = "none";

			  		document.getElementById("weekMonth").selectedIndex = 0;
			  		document.getElementById("selectday").selectedIndex = 0;
			  		document.getElementById("First").selectedIndex = 0;			//pra code
					document.getElementById("masaevery").selectedIndex = 0;
					document.getElementById("modeOfChangeMonth").selectedIndex = 0;
					document.getElementById("everyFivedaysval").selectedIndex = 0;
			  	}
				//let thithi = ( $('#hindu').prop('checked') ?  document.getElementById("masaCode").value+document.getElementById("bomCode").value+document.getElementById("thithiCode").value : ""  );
				var d = document.getElementById("multiDate").value;
				sevaCombo = sevaCombo.split('=')[0]+"("+sevaCombo.split('=')[1].trim()+")" ;
				//sevaCombo = sevaCombo.split('=')[0]+"("+sevaCombo.split('=')[1]+")" ;				//+ "= ₹ " + correctSevaNormalPrice.toString()

				
				if(($('#postage').prop('checked')) == false){
					$('#postage').attr("value", "NO");
					var vals = $('#postage').val(); 

					$('#eventSeva').append('<tr class="' + si + ' si1"><td class="si text-center">' + si + '</td><td class="ssreceipt_no">' + ssreceipt_no + '</td><td class="ssreceipt_date">' + ssreceipt_date + '</td><td class="deityName">' + deityCombo + '</td><td class="sevaCombo">' + sevaCombo + '</td><td class="sevaQty">' + sevaQty + '</td><td class="corpus">' + corpus + '</td><td class="date" style="display:none;">'+ date2[i] +'</td> <td class="dateMonth1" >'+ dateMonth1[i] +'</td><td class="thithi">'+ thithi +'</td><td class="everyweekMonth">'+ WeekMonthCode +'</td><td class="periodId" style="display:none;">' + periodCombo[0].trim() + '</td><td class="periodName">' + periodCombo[1].trim() + '</td><td style="display:none;" class="price">' + price + '</td><td class="amt" style="display:none;">' +vals+ '</td><td class="purpose">' + purpose +'</td><td style="color:#800000;" title="'+address+'" class="postage1">' + vals +'</td><td style="display:none;"class="address">' + address +'</td><td>No</td><td class="link1"><a style="cursor:pointer;" onClick="updateTable(' + si + ');"><img style="width:24px; height:24px;" title="delete" src="<?=base_url()?>images/delete1.svg"></a></td><td style="display:none;" class="sevaName">' + sevaName + '</td><td style="display:none;" class="quantityChecker">' + quantityChecker + '</td><td style="display:none;" class="deityId">' + deityId + '</td><td style="display:none;" class="userId">' + userId + '</td><td style="display:none;" class="sevaId">' + sevaId + '</td><td style="display:none;" class="isSeva">' + isSeva + '</td><td style="display:none;" class="revFlag">' + revFlag + '</td><td style="display:none;" class="masa1">' + masa1 + '</td><td style="display:none;" class="bomcode1">' + bomcode1 + '</td><td style="display:none;" class="thithiName1">' + thithiName1 + '</td><td style="display:none;" class="addLine1">' + addLine1.val() + '</td><td style="display:none;" class="addLine2">' + addLine2.val() + '</td><td style="display:none;" class="city1">' + city.val() + '</td><td style="display:none;" class="state">' + state.val() + '</td><td style="display:none;" class="country">' + country.val() + '</td><td style="display:none;" class="pincode">' + pincode.val() + '</td><td class="calType1" style="display:none;">' + calType1 + '</td></tr>');
					si++;
				//total += amt
			} else {
				$('#postage').attr("value", "YES");
				var vals = $('#postage').val(); 
					/* var e = document.getElementById("periodCombo").value;
					var vals = ($('#postage').attr('checked') ? 'YES' : 'NO');
					sevaCombo = sevaCombo.split('=')[0] ; */
					//+ "= ₹ " + correctSevaNormalPrice.toString()
					$('#eventSeva').append('<tr class="' + si + ' si1"><td class="si text-center">' + si + '</td><td class="ssreceipt_no">' + ssreceipt_no + '</td><td class="ssreceipt_date">' + ssreceipt_date + '</td><td class="deityName">' + deityCombo + '</td><td class="sevaCombo">' + sevaCombo + '</td><td class="sevaQty">' + sevaQty + '</td><td class="corpus">' + corpus + '</td><td class="date" style="display:none;">'+ date2[i] +'</td><td class="dateMonth1" >'+ dateMonth1[i] +'</td><td class="thithi">'+ thithi +'</td><td class="everyweekMonth">'+ WeekMonthCode +'</td><td class="periodId" style="display:none;">' + periodCombo[0].trim() + '</td><td class="periodName">' + periodCombo[1].trim() + '</td><td style="display:none;" class="price">' + price + '</td><td class="amt" style="display:none;">' +vals+ '</td><td class="purpose">' + purpose +'</td><td style="color:#800000;" title="'+address+'" class="postage1">' + vals +'</td><td style="display:none;"class="address">' + address +'</td><td>No</td><td class="link1"><a style="cursor:pointer;" onClick="updateTable(' + si + ');"><img style="width:24px; height:24px;" title="delete" src="<?=base_url()?>images/delete1.svg"></a></td><td style="display:none;" class="sevaName">' + sevaName + '</td><td style="display:none;" class="quantityChecker">' + quantityChecker + '</td><td style="display:none;" class="deityId">' + deityId + '</td><td style="display:none;" class="userId">' + userId + '</td><td style="display:none;" class="sevaId">' + sevaId + '</td><td style="display:none;" class="isSeva">' + isSeva + '</td><td style="display:none;" class="revFlag">' + revFlag + '</td><td style="display:none;" class="masa1">' + masa1 + '</td><td style="display:none;" class="bomcode1">' + bomcode1 + '</td><td style="display:none;" class="thithiName1">' + thithiName1 + '</td><td style="display:none;" class="addLine1">' + addLine1.val() + '</td><td style="display:none;" class="addLine2">' + addLine2.val() + '</td><td style="display:none;" class="city1">' + city.val() + '</td><td style="display:none;" class="state">' + state.val() + '</td><td style="display:none;" class="country">' + country.val() + '</td><td style="display:none;" class="pincode">' + pincode.val() + '</td><td class="calType1" style="display:none;">' + calType1 + '</td></tr>');
					si++;
				}
			}
			$('#totalAmount').html(total);
		} else if (between.length != 0) {
			for (let i = 0; i < between.length; ++i) {
				//Code To Handle Revision Price
				var correctSevaBetweenPrice = ((revisionStatus == 0)?sevaPrice:((compareSevaDateWithRevisionDate(between[i].trim(),revision_date.trim()))?revision_price:sevaPrice));

				//amt = correctSevaBetweenPrice * qty;
				
				sevaCombo = sevaCombo.split('=')[0] + "= ₹" + correctSevaBetweenPrice.toString();
				var e = document.getElementById("periodCombo").value.split("|");
				
				$('#eventSeva').append('<tr class="' + si + ' si1"><td class="si text-center">' + si + '</td><td class="ssreceipt_no">' + ssreceipt_no + '</td><td class="ssreceipt_date">' + ssreceipt_date + '</td><td class="deityName">' + deityCombo + '</td><td class="sevaCombo">' + sevaCombo + '</td><td class="sevaQty">' + sevaQty + '</td><td class="corpus">' + corpus + '</td><td class="date" style="display:none;">'+date2[i]+'</td><td class="dateMonth1" >'+ dateMonth1[i] +'</td><td class="thithi">'+ thithi +'</td><td class="everyweekMonth">'+ WeekMonthCode +'</td><td class="periodId" style="display:none;">' + periodCombo[0].trim() + '</td><td class="periodName">' + periodCombo[1].trim() + '</td><td class="amt">' + postage + '</td><td style="display:none;" class="address">' + address +'</td><td class="link1"><a style="cursor:pointer;" onClick="updateTable(' + si + ');"><img style="width:24px; height:24px;" title="delete" src="<?=base_url()?>images/delete1.svg"></a></td><td style="display:none;" class="sevaName">' + sevaName + '</td><td style="display:none;" class="quantityChecker">' + quantityChecker + '</td><td style="display:none;" class="deityId">' + deityId + '</td><td style="display:none;" class="userId">' + userId + '</td><td style="display:none;" class="sevaId">' + sevaId + '</td><td style="display:none;" class="isSeva">' + isSeva + '</td><td style="display:none;" class="revFlag">' + revFlag + '</td><td style="display:none;" class="addLine1">' + addLine1.val() + '</td><td style="display:none;" class="addLine2">' + addLine2.val() + '</td><td style="display:none;" class="city1">' + city.val() + '</td><td style="display:none;" class="state">' + state.val() + '</td><td style="display:none;" class="country">' + country.val() + '</td><td style="display:none;" class="pincode">' + pincode.val() + '</td><td class="calType1" style="display:none;">' + calType1 + '</td></tr>');
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
		
		//updateTable(0)
		$("#corpus").val('');
		document.getElementById('sevaQty').value = 1;
		document.getElementById('manualreceipt').checked = true;
		document.getElementById("receiptLine1").value = "";
		document.getElementById("receiptLine2").value = "";
		
		// $("#receiptLine1").attr("disabled", true);
		// $("#receiptLine2").attr("disabled", true);	
		// $("#receiptLine3").attr("disabled", true);//$("#hindu").prop('checked',true);

		

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
		dateFormat: 'dd-mm-yy',
		changeYear: true,
		changeMonth: true,
		yearRange: "1850:+400",
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
					//$('#sevaCombo :selected').html(selVal[0] + " = &#8377; " +sevaCom.sevaPrice)
					//$('#setPrice').html(sevaCom.sevaPrice);
					
				} else { //$("#setPrice").html(oldPrice); $('#sevaCombo :selected').html(selVal[0] + " = &#8377; " +oldPrice)
			}
		} else {
			//	$('#sevaCombo :selected').html(selVal[0] + " = &#8377; " +sevaCom.sevaPrice)
			//	$('#setPrice').html(sevaCom.sevaPrice);
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
	
	// < !--Rashi Validation-- >
	$('#rashi').keyup(function () {
		var $th = $(this);
		$th.val($th.val().replace(/[^A-Za-z]/g, function (str) { return ''; }));
	});
	
	// < !--Nakshatra Validation-- >
	$('#nakshatra').keyup(function () {
		var $th = $(this);
		$th.val($th.val().replace(/[^A-Za-z]/g, function (str) { return ''; }));
	});
	
	/*$('#gotra').keyup(function () {
		var $th = $(this);
		$th.val($th.val().replace(/[^A-Za-z]/g, function (str) { return ''; }));
	});*/

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

	$('#MMphone').keyup(function (e) {
		var $th = $(this);
		if (e.keyCode != 46 && e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 38 && e.keyCode != 39 && e.keyCode != 40) {
			$th.val($th.val().replace(/[^0-9]/g, function (str) { return ''; }));
		} return;
	});

	$('#MMphone2').keyup(function (e) {
		var $th = $(this);
		if (e.keyCode != 46 && e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 38 && e.keyCode != 39 && e.keyCode != 40) {
			$th.val($th.val().replace(/[^0-9]/g, function (str) { return ''; }));
		} return;
	});

	$('#MMpincode').keyup(function (e) {
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
		let ssreceipt_no = document.getElementsByClassName('ssreceipt_no');
		let ssreceipt_date = document.getElementsByClassName('ssreceipt_date');
		let sevaCombo = document.getElementsByClassName('sevaCombo');
		let corpus = document.getElementsByClassName('corpus');
		let purpose = document.getElementsByClassName('purpose');
		let date = document.getElementsByClassName('date');
		let dateMonth1 = document.getElementsByClassName('dateMonth1');
		let price = document.getElementsByClassName('price');
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
		//let period = document.getElementsByClassName("period");
		let periodId = document.getElementsByClassName("periodId");
		let periodName = document.getElementsByClassName("periodName");

		let address = document.getElementsByClassName("address");
		let postage = document.getElementsByClassName("postage1");
		let addressLine1 = document.getElementsByClassName("addLine1");
		let addressLine2 = document.getElementsByClassName("addLine2");
		let city = document.getElementsByClassName("city1");
		let state = document.getElementsByClassName("state");
		let country = document.getElementsByClassName("country");
		let pincode = document.getElementsByClassName("pincode");
		let calType1 = document.getElementsByClassName("calType1");	
		let everyweekMonth = document.getElementsByClassName("everyweekMonth");

		return {
			si1: si1,
			si: si,
			ssreceipt_no: ssreceipt_no,
			ssreceipt_date: ssreceipt_date,
			sevaCombo: sevaCombo,
			sevaName: sevaName,
			sevaQty: sevaQty,
			corpus: corpus,
			purpose:purpose,
			thithi:thithi,
			masa1:masa1,
			bomcode1:bomcode1,
			thithiName1:thithiName1,
			date: date,
			dateMonth1:dateMonth1,
			price: price,
			amt: amt,
			deityName: deityName,
			link1: link1,
			sevaId: sevaId,
			userId: userId,
			deityId: deityId,
			isSeva: isSeva,
			quantityChecker: quantityChecker,
			revFlag: revFlag,
			//period: period,

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



		$( ".receiptLine2" ).datepicker({ 
			dateFormat: 'dd-mm-yy',
			changeYear: true,
			changeMonth: true,
			yearRange: "1850:+400"
		});

		$('.receiptLine2').on('click', function() {
			$( ".receiptLine2" ).focus();
		});

	//functions for shashwath seva edit modal 
	var eCalType;
	document.getElementById('modalHinduCal').style.display = "block";
	document.getElementById('modalGregorianCal').style.display = "none";
	document.getElementById('modelFestvalCal').style.display = "none";
	document.getElementById('modelEveryWeekMonthcal').style.display = "none";	

	function modalCalendarHindu() {
		eCalType = 'Hindu';
		document.getElementById('modalHinduCal').style.display = "block";
		document.getElementById('modalGregorianCal').style.display = "none";
		document.getElementById('modelFestvalCal').style.display = "none";
		document.getElementById('modelEveryWeekMonthcal').style.display = "none";	
	} 

	function modalCalendarGregorian() {
		eCalType = 'Gregorian';
		document.getElementById('modalHinduCal').style.display = "none";
		document.getElementById('modalGregorianCal').style.display = "block";
		document.getElementById('modelFestvalCal').style.display = "none";
		document.getElementById('modelEveryWeekMonthcal').style.display = "none";	
	} 

	function modalCalendarFestivalwise() {
		eCalType = 'Festivalwise';
		document.getElementById('modalHinduCal').style.display = "none";
		document.getElementById('modalGregorianCal').style.display = "none";
		document.getElementById('modelFestvalCal').style.display = "block";
		document.getElementById('modelEveryWeekMonthcal').style.display = "none";	
	}
	function modalWeekMonthwise() {
		eCalType = 'Every';
		document.getElementById('modalHinduCal').style.display = "none";
		document.getElementById('modalGregorianCal').style.display = "none";
		document.getElementById('modelFestvalCal').style.display = "none";
		document.getElementById('modelEveryWeekMonthcal').style.display = "block";	
	}

	$('#modalHinduCal').on('click', function () {
		$('#modalmultiDate').datepicker('setDate', null);
		$('#modalmultiDate').datepicker('resetDates');
		$('#modalmultiDate').val(""); 
	});

	// function modalhideReciptEntry(ths) {	
	// 	if(ths.checked) {
	// 		$('#modalreceiptLine1').val(ssReceiptNo);
	// 		$('#modalreceiptLine2').val(ssReceiptDate);

	// 		$("#modalreceiptLine1").attr("disabled", false);
	// 		$("#modalreceiptLine2").attr("disabled", false);
	// 		$("#modalreceiptLine3").attr("disabled", false);
	// 	} else {
	// 		$('#modalreceiptLine1').val("");
	// 		$('#modalreceiptLine2').val("");

	// 		$("#modalreceiptLine1").attr("disabled", true);
	// 		$("#modalreceiptLine2").attr("disabled", true);	
	// 		$("#modalreceiptLine3").attr("disabled", true);
	// 	}
	// }

	
	$(".adlCrpBookDate").datepicker({ 
		dateFormat: 'dd-mm-yy',
		changeYear: true,
		changeMonth: true,
		yearRange: "1850:+400",
		beforeShow: function() {
			setTimeout(function(){
				$('.ui-datepicker').css('z-index', 99999999999999);
			}, 0);
		}
	});

	$(".modalreceiptLine2").datepicker({ 
		dateFormat: 'dd-mm-yy',
		changeYear: true,
		changeMonth: true,
		yearRange: "1850:+400",
		beforeShow: function() {
			setTimeout(function(){
				$('.ui-datepicker').css('z-index', 99999999999999);
			}, 0);
		}
	});
	$(".modalmultiDate").datepicker({ 
		dateFormat: 'dd-mm-yy',
		changeYear: true,
		changeMonth: true,
		yearRange: "1850:+400",
		beforeShow: function() {
			setTimeout(function(){
				$('.ui-datepicker').css('z-index', 99999999999999);
			}, 0);
		}
	});
	$('.modalmultiDate').on('click', function() {
		$( ".modalmultiDate" ).focus();
	});


	$('.modalreceiptLine2').on('click', function() {
		$( ".modalreceiptLine2" ).focus();
	});

	$('.adlCrpBookDate').on('click', function() {
		$( ".adlCrpBookDate" ).focus();
	});

	var sevaId = 0, receiptId = 0, SSID = 0, sMemberId = 0, ssReceiptNo, ssReceiptDate, calenderType ,thithi_code;
	function editSevaDetail(smId, ssId,rNo,rId,dId,deitySevaId,sAmt,sQty,ssRNo,ssRDate,spId,sPurpose,Masa,Bom,Thithi,thithi_code,ssEngDate,everyWeekMonth,getCalType,periodName,ssVerification) {
		SSID = ssId;
		sMemberId = smId;
		sevaId = deitySevaId;
		receiptId = rId;
		ssReceiptNo = ssRNo;
		ssReceiptDate = ssRDate;
		calenderType = getCalType;
		thithi_code = thithi_code;

		arrDeity = <?php echo @$deityEdit; ?>;
		$('#editModalDeityCombo').html('');
		for (let i = 0; i < arrDeity.length; ++i) {
			if (arrDeity[i]['DEITY_ID'] == dId)
				$('#editModalDeityCombo').append('<option value="' + arrDeity[i]['DEITY_ID'] + '" selected="selected">' + arrDeity[i]['DEITY_NAME'] + '</option>');
			else
				$('#editModalDeityCombo').append('<option value="' + arrDeity[i]['DEITY_ID'] + '">' + arrDeity[i]['DEITY_NAME'] + '</option>');
		}

		arrSevas = <?php echo @$sevas; ?>;
		$('#editModalSevaCombo').html('');
		for (let i = 0; i < arrSevas.length; ++i) {
			if (arrSevas[i]['DEITY_ID'] == dId && arrSevas[i]['SEVA_ID'] == deitySevaId)
				$('#editModalSevaCombo').append('<option value="' + arrSevas[i]['DEITY_ID'] + "|" + arrSevas[i]['SEVA_ID'] + "|" + arrSevas[i]['SEVA_NAME'] + "|" + arrSevas[i]['USER_ID'] + "|" + arrSevas[i]['SEVA_PRICE'] + "|" + arrSevas[i]['QUANTITY_CHECKER'] + "|" +((arrSevas[i]['BOOKING'] == 1) ? "Occasional" :"Regular") +"|"+ arrSevas[i]['IS_SEVA'] + '" selected="selected">' + arrSevas[i]['SEVA_NAME'] + "  =  "+((arrSevas[i]['BOOKING'] == 1) ? "Occasional" :"Regular") + '</option>');
			else { 
				if(arrSevas[i]['DEITY_ID'] == dId) {
					$('#editModalSevaCombo').append('<option value="' + arrSevas[i]['DEITY_ID'] + "|" + arrSevas[i]['SEVA_ID'] + "|" + arrSevas[i]['SEVA_NAME'] + "|" + arrSevas[i]['USER_ID'] + "|" + arrSevas[i]['SEVA_PRICE'] + "|" + arrSevas[i]['QUANTITY_CHECKER'] + "|"+((arrSevas[i]['BOOKING'] == 1) ? "Occasional" :"Regular") +"|" + arrSevas[i]['IS_SEVA'] + '">' + arrSevas[i]['SEVA_NAME'] + "  =  "+((arrSevas[i]['BOOKING'] == 1) ? "Occasional" :"Regular") + '</option>');
				}
			}
		}

		arrPeriod = <?php echo @$periodEdit; ?>;
		$('#modalPeriodCombo').html('');
		for (let i = 0; i < arrPeriod.length; ++i) {
			if (arrPeriod[i]['SP_ID'] == spId)
				$('#modalPeriodCombo').append('<option value="' + arrPeriod[i]['SP_ID'] + '" selected="selected">' + arrPeriod[i]['PERIOD_NAME'] + '</option>');
			else
				$('#modalPeriodCombo').append('<option value="' + arrPeriod[i]['SP_ID'] + '">' + arrPeriod[i]['PERIOD_NAME'] + '</option>');
		}

		arrMasa = <?php echo @$masaEdit; ?>;
		$('#modalMasaCode').html('');
		if(Masa != "") {
			for (let i = 0; i < arrMasa.length; ++i) {
				if (arrMasa[i]['MASA_NAME'] == Masa)
					$('#modalMasaCode').append('<option value="' + arrMasa[i]['MASA_CODE'] + '|' + arrMasa[i]['MASA_NAME'] + '" selected="selected">' + arrMasa[i]['MASA_NAME'] + '</option>');
				else
					$('#modalMasaCode').append('<option value="' + arrMasa[i]['MASA_CODE'] + '|' + arrMasa[i]['MASA_NAME'] + '">' + arrMasa[i]['MASA_NAME'] + '</option>');
			}	
		} else {
			for (let i = 0; i < arrMasa.length; ++i) {
				$('#modalMasaCode').append('<option value="' + arrMasa[i]['MASA_CODE'] + '|' + arrMasa[i]['MASA_NAME'] + '">' + arrMasa[i]['MASA_NAME'] + '</option>');
			}	
		}

		arrMoon = <?php echo @$moonEdit; ?>;
		$('#modalBomCode').html('');
		if(Bom != "") {
			for (let i = 0; i < arrMoon.length; ++i) {
				if (arrMoon[i]['BOM_NAME'] == Bom)
					$('#modalBomCode').append('<option value="' + arrMoon[i]['BOM_CODE'] + '|' + arrMoon[i]['BOM_NAME'] + '" selected="selected">' + arrMoon[i]['BOM_NAME'] + '</option>');
				else
					$('#modalBomCode').append('<option value="' + arrMoon[i]['BOM_CODE'] + '|' + arrMoon[i]['BOM_NAME'] + '">' + arrMoon[i]['BOM_NAME'] + '</option>');
			}	
		} else {
			for (let i = 0; i < arrMoon.length; ++i) {
				$('#modalBomCode').append('<option value="' + arrMoon[i]['BOM_CODE'] + '|' + arrMoon[i]['BOM_NAME'] + '">' + arrMoon[i]['BOM_NAME'] + '</option>');
			}
		}
		
		arrThithiShuddha = <?php echo @$thithi_shudda_edit; ?>;
		$('#modalThithiCode').html('');
		arrThithiBahula = <?php echo @$thithi_bahula_edit; ?>;
		$('#modalThithiCode1').html('');
		if(Bom != "") {
			for (let i = 0; i < arrThithiShuddha.length; ++i) {
				if (arrThithiShuddha[i]['THITHI_NAME'] == Thithi && Bom == "Shuddha") {
					document.getElementById("modalThithiCode1").style.display ="none";
					document.getElementById("modalThithiCode").style.display ="block";
					$('#modalThithiCode').append('<option value="' + arrThithiShuddha[i]['THITHI_CODE'] + '|' + arrThithiShuddha[i]['THITHI_NAME'] + '" selected="selected">' + arrThithiShuddha[i]['THITHI_NAME'] + '</option>');
				}
				else
					$('#modalThithiCode').append('<option value="' + arrThithiShuddha[i]['THITHI_CODE'] + '|' + arrThithiShuddha[i]['THITHI_NAME'] + '">' + arrThithiShuddha[i]['THITHI_NAME'] + '</option>');
			}

			for (let i = 0; i < arrThithiBahula.length; ++i) {
				if (arrThithiBahula[i]['THITHI_NAME'] == Thithi && Bom == "Bahula") {
					document.getElementById("modalThithiCode1").style.display ="block";
					document.getElementById("modalThithiCode").style.display ="none";
					$('#modalThithiCode1').append('<option value="' + arrThithiBahula[i]['THITHI_CODE'] + '|' + arrThithiBahula[i]['THITHI_NAME'] + '" selected="selected">' + arrThithiBahula[i]['THITHI_NAME'] + '</option>');
				}
				else 
					$('#modalThithiCode1').append('<option value="' + arrThithiBahula[i]['THITHI_CODE'] + '|' + arrThithiBahula[i]['THITHI_NAME'] + '">' + arrThithiBahula[i]['THITHI_NAME'] + '</option>');
			}	
		} else {
			for (let i = 0; i < arrThithiShuddha.length; ++i) {
				document.getElementById("modalThithiCode1").style.display ="none";
				document.getElementById("modalThithiCode").style.display ="block";
				$('#modalThithiCode').append('<option value="' + arrThithiShuddha[i]['THITHI_CODE'] + '|' + arrThithiShuddha[i]['THITHI_NAME'] + '">' + arrThithiShuddha[i]['THITHI_NAME'] + '</option>');
			}

			for (let i = 0; i < arrThithiBahula.length; ++i) {
				$('#modalThithiCode1').append('<option value="' + arrThithiBahula[i]['THITHI_CODE'] + '|' + arrThithiBahula[i]['THITHI_NAME'] + '">' + arrThithiBahula[i]['THITHI_NAME'] + '</option>');
			}
		}

		arrFestival = <?php echo @$festivalEdit; ?>;
		$('#modalFestivalCode').html('');
		if(thithi_code != "") {
			for (let i = 0; i < arrFestival.length; ++i) {
				if (arrFestival[i]['SFS_THITHI_CODE'] == thithi_code)
					$('#modalFestivalCode').append('<option value="' + arrFestival[i]['SFS_THITHI_CODE'] + '" selected="selected">' + arrFestival[i]['SFS_NAME'] + ' - ' + arrFestival[i]['SFS_THITHI_CODE'] + '</option>');
				else
					$('#modalFestivalCode').append('<option value="' + arrFestival[i]['SFS_THITHI_CODE'] + '">' + arrFestival[i]['SFS_NAME'] + ' - ' + arrFestival[i]['SFS_THITHI_CODE'] + '</option>');
			}	
		} else {
			for (let i = 0; i < arrFestival.length; ++i) {
				$('#modalFestivalCode').append('<option value="' + arrFestival[i]['SFS_THITHI_CODE'] + '">' + arrFestival[i]['SFS_NAME'] + ' - ' + arrFestival[i]['SFS_THITHI_CODE'] + '</option>');
			}	
		}

		// if (calenderType == "Every"){
		// 	let ewm = everyWeekMonth.split("_")[0];
		// 	if(ewm == "First"){
		// 		$('#modalweekMonth').val("Month");
		// 		document.getElementById("modalFirst").style.display ="block";
		// 		$('#modalselectday').val(everyWeekMonth.split("_")[1]);
		// 	} else {
		// 		$('#modalweekMonth').val("Week");
		// 		document.getElementById("modalFirst").style.display ="none";
		// 		$('#modalselectday').val(everyWeekMonth.split("_")[0]);
		// 	}
		// }

		//	let ewm = everyWeekMonth.split("_")[0];
		// let ewm1 = everyWeekMonth.split("_")[1];
          //let ewm2 = everyWeekMonth.split("_")[2];
				if (calenderType == "Every"){
			let ewm = everyWeekMonth.split("_")[0];
         	 let ewm1 = everyWeekMonth.split("_")[1];
             let ewm2 = everyWeekMonth.split("_")[2];
		

			
			if(ewm == "First" || ewm == "Second" || ewm == "Third" || ewm == "Fourth" ||ewm == "Last"){
				$('#modalweekMonth').val("Month");
			 	document.getElementById("modalFirst").style.display ="block";
			 	document.getElementById("modalmonths").style.display ="none";
			 	$('#modaleveryFivedaysval').val(everyWeekMonth.split("_")[0]);
			 	$('#modalselectday').val(everyWeekMonth.split("_")[1]);
			} else if(ewm == "January" || ewm == "February" || ewm == "March" || ewm == "April" ||ewm == "May" ||ewm == "June"||ewm == "July"||ewm == "August"||ewm == "September"||ewm == "October"||ewm == "November"||ewm == "December"){
				$('#modalweekMonth').val("Year");
		 	 	document.getElementById("modalFirst").style.display ="block";
		 	 	document.getElementById("modalmonths").style.display ="block";
		 	 	$('#modalmodeOfChangeMonth').val(everyWeekMonth.split("_")[0]);
		 	 	$('#modaleveryFivedaysval').val(everyWeekMonth.split("_")[1]);
			 	
		 	 	$('#modalselectday').val(everyWeekMonth.split("_")[2]);
			}  else if(ewm == "Chaitra" || ewm == "Vaishakha" || ewm == "Jyesta" || ewm == "Ashada" ||ewm == "Shravana" ||ewm == "Bhadrapada"||ewm == "Ashwija"||ewm == "Karthika"||ewm == "Margasheera"||ewm == "Pushya"||ewm == "Magha"||ewm == "Phalguna"){
				$('#modalweekMonth').val("YearHindu");
		 	 	document.getElementById("modalFirst").style.display ="block";
		 	 	document.getElementById("modalEveryyearmasa").style.display ="block";
		 	 	//$('#modalmasaevery').val(everyWeekMonth.split("_")[0]);
		 	 	$('#modaleveryFivedaysval').val(everyWeekMonth.split("_")[1]);
		 	 	$('#modalselectday').val(everyWeekMonth.split("_")[2]);
		 	 		let everyMasaVal = everyWeekMonth.split("_")[0];

				$('#modalmasaevery').html('');
				if(everyMasaVal != "") {
					for (let i = 0; i < arrMasa.length; ++i) {
						if (arrMasa[i]['MASA_NAME'] == everyMasaVal)
							$('#modalmasaevery').append('<option value="' + arrMasa[i]['MASA_CODE'] + '|' + arrMasa[i]['MASA_NAME'] + '" selected="selected">' + arrMasa[i]['MASA_NAME'] + '</option>');
						else
							$('#modalmasaevery').append('<option value="' + arrMasa[i]['MASA_CODE'] + '|' + arrMasa[i]['MASA_NAME'] + '">' + arrMasa[i]['MASA_NAME'] + '</option>');
					}	
				} else {
					for (let i = 0; i < arrMasa.length; ++i) {
						$('#modalmasaevery').append('<option value="' + arrMasa[i]['MASA_CODE'] + '|' + arrMasa[i]['MASA_NAME'] + '">' + arrMasa[i]['MASA_NAME'] + '</option>');
					}	
				}
			}
			else {
				$('#modalweekMonth').val("Week");
				document.getElementById("modalFirst").style.display ="none";
		 	 	document.getElementById("modalmonths").style.display ="none";
				$('#modalselectday').val(everyWeekMonth.split("_")[0]);
			}
		}
		
		if(calenderType == "Gregorian") {                         //festival new
			eCalType = "Gregorian";

			$('#modalHindu').prop("checked",false);
			$('#modalGregorian').prop("checked",true);
			$('#modalFestivalwise').prop("checked",false);
			$('#modalEveryWeekMonthwise').prop("checked",false);

			document.getElementById('modalHinduCal').style.display = "none";
			document.getElementById('modalGregorianCal').style.display = "block";
			document.getElementById('modelFestvalCal').style.display = "none";
			document.getElementById('modelEveryWeekMonthcal').style.display = "none";

			$('#modalmultiDate').val(ssEngDate+"-"+(new Date()).getFullYear());
		} else if (calenderType == "Hindu") {
			eCalType = "Hindu";
			$('#modalHindu').prop("checked",true);
			$('#modalGregorian').prop("checked",false);
			$('#modalFestivalwise').prop("checked",false);
			$('#modalEveryWeekMonthwise').prop("checked",false);

			document.getElementById('modalHinduCal').style.display = "block";
			document.getElementById('modalGregorianCal').style.display = "none";
			document.getElementById('modelFestvalCal').style.display = "none";
			document.getElementById('modelEveryWeekMonthcal').style.display = "none";

			$('#modalmultiDate').val("");
		} else if (calenderType == "Festivalwise"){
			eCalType = "Festivalwise";

			$('#modalHindu').prop("checked",false);
			$('#modalGregorian').prop("checked",false);
			$('#modalFestivalwise').prop("checked",true);
			$('#modalEveryWeekMonthwise').prop("checked",false);

			document.getElementById('modalHinduCal').style.display = "none";
			document.getElementById('modalGregorianCal').style.display = "none";
			document.getElementById('modelFestvalCal').style.display = "block";
			document.getElementById('modelEveryWeekMonthcal').style.display = "none";	
			//$('#modelFestvalCal').val(thithi_code);
			$('#modalmultiDate').val("");                       //festival  new
		}else if (calenderType == "Every"){
			eCalType = "Every";

			$('#modalHindu').prop("checked",false);
			$('#modalGregorian').prop("checked",false);
			$('#modalFestivalwise').prop("checked",false);
			$('#modalEveryWeekMonthwise').prop("checked",true);

			document.getElementById('modalHinduCal').style.display = "none";
			document.getElementById('modalGregorianCal').style.display = "none";
			document.getElementById('modelFestvalCal').style.display = "none";
			document.getElementById('modelEveryWeekMonthcal').style.display = "block";	
			//$('#modelFestvalCal').val(thithi_code);
			$('#modalmultiDate').val("");                       //festival  new
		}


		$('#modalCorpus').val(sAmt);
		$('#modalSevaQty').val(sQty);
		$('#modalSevaNotes').val(sPurpose);
		$('#modalreceiptLine1').val(ssRNo);
		$('#modalreceiptLine2').val(ssRDate);
		$('#modalssVerification').val(ssVerification);
		if(ssVerification==1){
			$("#modalManualReceipt").attr("disabled", true);
			$("#modalreceiptLine1").attr("disabled", true);
			$("#modalreceiptLine2").attr("disabled", true);
			$("#modalreceiptLine3").attr("disabled", true);
		}
		// if(ssRNo != "") {
		// 	$("#modalreceiptLine1").attr("disabled", false);
		// 	$("#modalreceiptLine2").attr("disabled", false);
		// 	$("#modalreceiptLine3").attr("disabled", false);

		// 	$("#modalManualReceipt").prop("checked", true);
		// }	
		// else {
		// 	$("#modalreceiptLine1").attr("disabled", true);
		// 	$("#modalreceiptLine2").attr("disabled", true);
		// 	$("#modalreceiptLine3").attr("disabled", true);

		// 	$("#modalManualReceipt").prop("checked", false);
		// }
		$('#editModal').modal();
	}

	function editModalDeityComboChange() {
		dName = $('#editModalDeityCombo').val();
		$('#editModalSevaCombo').html("");
		for (let i = 0; i < arrSevas.length; ++i) {
			if (arrSevas[i]['DEITY_ID'] == dName && arrSevas[i]['SEVA_ID'] == sevaId)
				$('#editModalSevaCombo').append('<option value="' + arrSevas[i]['DEITY_ID'] + "|" + arrSevas[i]['SEVA_ID'] + "|" + arrSevas[i]['SEVA_NAME'] + "|" + arrSevas[i]['USER_ID'] + "|" + arrSevas[i]['SEVA_PRICE'] + "|" + arrSevas[i]['QUANTITY_CHECKER'] + "|" +((arrSevas[i]['BOOKING'] == 1) ? "Occasional" :"Regular") +"|"+ arrSevas[i]['IS_SEVA'] + "|" + ((arrSevas[i]['BOOKING'] == 1) ? "Occasional" :"Regular") + '" selected="selected">' + arrSevas[i]['SEVA_NAME'] + "  =  "+((arrSevas[i]['BOOKING'] == 1) ? "Occasional" :"Regular") + '</option>');
			else {
				if(arrSevas[i]['DEITY_ID'] == dName)
					$('#editModalSevaCombo').append('<option value="' + arrSevas[i]['DEITY_ID'] + "|" + arrSevas[i]['SEVA_ID'] + "|" + arrSevas[i]['SEVA_NAME'] + "|" + arrSevas[i]['USER_ID'] + "|" + arrSevas[i]['SEVA_PRICE'] + "|" + arrSevas[i]['QUANTITY_CHECKER'] + "|" +((arrSevas[i]['BOOKING'] == 1) ? "Occasional" :"Regular") +"|"+ arrSevas[i]['IS_SEVA'] + "|" + ((arrSevas[i]['BOOKING'] == 1) ? "Occasional" :"Regular") + '">' + arrSevas[i]['SEVA_NAME'] + "  =  "+((arrSevas[i]['BOOKING'] == 1) ? "Occasional" :"Regular") + '</option>');
			} 	
		}
	}

	function moonChange() {
		var m = document.getElementById("modalBomCode").value.split("|");
		if(m[0] == 'BH') {
			document.getElementById("modalThithiCode1").style.display ="block";
			document.getElementById("modalThithiCode").style.display ="none";
		} else {
			document.getElementById("modalThithiCode1").style.display ="none";
			document.getElementById("modalThithiCode").style.display ="block";
		}
	}
	
	// function modelweekMonthChange(){
	// 	if(document.getElementById("modalweekMonth").value == "Month") {
	// 		document.getElementById("modalFirst").style.display ="block";
	// 	}else{
	// 		document.getElementById("modalFirst").style.display ="none";
	// 	}

	// }


	function modelweekMonthChange(){
		if(document.getElementById("modalweekMonth").value == "Month") {	
			document.getElementById("modalFirst").style.display ="block";
			document.getElementById("modalmonths").style.display ="none";
			document.getElementById("modalEveryyearmasa").style.display ="none";
		}

		if(document.getElementById("modalweekMonth").value =='Year'){
				document.getElementById("modalFirst").style.display ="block";
				document.getElementById("modalweekMonth").style.display ="block";
				document.getElementById("modalmonths").style.display ="block";
				document.getElementById("modalEveryyearmasa").style.display ="none";
		}

		if(document.getElementById("modalweekMonth").value =='Week'){
				document.getElementById("modalFirst").style.display ="none";
				document.getElementById("modalselectday").style.display ="block";
				document.getElementById("modalmonths").style.display ="none";
				document.getElementById("modalEveryyearmasa").style.display ="none";
		}
		if(document.getElementById("modalweekMonth").value =='YearHindu'){
			document.getElementById("modalEveryyearmasa").style.display ="block";
			document.getElementById("modalFirst").style.display ="block";
			document.getElementById("modalweekMonth").style.display ="block";
			document.getElementById("modalmonths").style.display ="none";			
		}
	}

	$('#modalweekMonth').change(function(){
	     $('#modalFirst option:first').prop('selected', 'selected');
	     $('#modalselectday option:first').prop('selected', 'selected');
	     $('#modalmodeOfChangeMonth option:first').prop('selected', 'selected');
	     $('#modalmasaevery option:first').prop('selected', 'selected');

	});

	var modalTempTableContent;
	function updateShashwathSevaDetails() {
		//Validation Checkings
		if($('#modalCorpus').val() == "" ){
			alert("Information","Please enter Corpus!!!");
			$('#modalCorpus').css('border-color', "#FF0000");
			return ;
		} 
		if($('#modalSevaQty').val() == "" ){
			alert("Information","Please enter SevaQty!!!");
			$('#modalSevaQty').css('border-color', "#FF0000");
			return ;
		}
		if($('#modalmultiDate').val() == "" && $('#modalGregorian').prop('checked')) {
			alert("Information","Please enter Gregorian Date!!!");
			$('#modalmultiDate').css('border-color', "#FF0000");
			return ;
		} 
		if($('#modalEveryWeekMonthwise').prop('checked') && $('#modalweekMonth').val() == "") {
			$('#modalweekMonth').css('border-color', "#FF0000")
			alert("Information","Please select appropriate Week/Month/Year for seva");
			return;
		}
		if($('#modalEveryWeekMonthwise').prop('checked') && $('#modalselectday').val() == "") {
			$('#modalselectday').css('border-color', "#FF0000")
			alert("Information","Please select appropriate Day for seva");
			return;
		}


		let modalweekMonth = $('#modalweekMonth option:selected').val();
		let modaleveryDayVal = $('#modalselectday option:selected').val();
		let modaleveryFivedaysval = $('#modaleveryFivedaysval option:selected').val();
		let modalmodeOfChangeMonth = $('#modalmodeOfChangeMonth option:selected').val();
 		let modaleveryWeekMonthval = $('#modalweekMonth option:selected').val();
 		let modaleveryMonth = $('#modalmasaevery option:selected').val();
		// if(document.getElementById("modalweekMonth").value == "") {
		// 	if(modaleveryDayVal == ""){
		// 		alert("Information","Please select Option!!!");
		// 		$('#modalselectday').css('border-color', "#FF0000");
		// 		return;
		// 	}	
		// 	if(modalweekMonth == ""){
		// 		alert("Information","Please select Option!!!");
		// 		$('#modalweekMonth').css('border-color', "#FF0000");
		// 		return;
		// 	}			
			
		// }

		if(document.getElementById("modalweekMonth").value == "Year") {
			if(modaleveryDayVal == ""){
				alert("Information","Please select appropriate day for seva!!!");
				$('#modalselectday').css('border-color', "#FF0000");
				return;
			}if(modaleveryFivedaysval == ""){
				alert("Information","Please select appropriate days for seva");
				$('#modaleveryFivedaysval').css('border-color', "#FF0000");
				
				return;
			}
			if(modalmodeOfChangeMonth == ""){
				alert("Information","Please select appropriate Month for seva");
				$('#modalmodeOfChangeMonth').css('border-color', "#FF0000");
				
				return;
			}
			
		}

		if(document.getElementById("modalweekMonth").value == "Month") {
			if(modaleveryDayVal == ""){
				alert("Information","Please select appropriate days for seva");
				$('#modalselectday').css('border-color', "#FF0000");
				return;
			}
			if(modaleveryFivedaysval == ""){
				alert("Information","Please select appropriate days for seva");
				$('#modaleveryFivedaysval').css('border-color', "#FF0000");
				return;
			}
			
			
		}

		if(document.getElementById("modalweekMonth").value == "Week") {
			if(modaleveryDayVal == ""){
				alert("Information","Please select appropriate days for seva");
				$('#modalselectday').css('border-color', "#FF0000");
				return;
			}				
		}

		// let modalWeekMonthCode = document.getElementById("modalselectday").value;
	 //  	 // alert(document.getElementById("modalweekMonth").value);
		// 	if(document.getElementById("modalweekMonth").value == "Month") {
		// 		modalWeekMonthCode = "First_" + modalWeekMonthCode;
		// }
		 //INPUT KEYPRESS
		let verificationStatus = $('#modalssVerification').val();

		 modalTempTableContent = getTableValues();
		 var strNewShashSeva = "";
		 for(var j=0;j<modalTempTableContent['sevaName'].length;j++) {
		 	strNewShashSeva += '<tr class="' + modalTempTableContent['si'][j].innerHTML + ' si1"><td class="si">' + modalTempTableContent['si'][j].innerHTML + '</td><td class="ssreceipt_no">' + modalTempTableContent['ssreceipt_no'][j].innerHTML + '</td><td class="ssreceipt_date">' + modalTempTableContent['ssreceipt_date'][j].innerHTML + '</td><td class="deityName">' + modalTempTableContent['deityName'][j].innerHTML + '</td><td class="sevaCombo">' + modalTempTableContent['sevaCombo'][j].innerHTML + '</td><td class="sevaQty">' + modalTempTableContent['sevaQty'][j].innerHTML + '</td><td class="corpus">' + modalTempTableContent['corpus'][j].innerHTML + '</td><td class="date" style="display:none;">'+ modalTempTableContent['date'][j].innerHTML +'</td><td class="dateMonth1" >'+  modalTempTableContent['dateMonth1'][j].innerHTML +'</td><td class="thithi">'+ modalTempTableContent['thithi'][j].innerHTML +'</td><td class="everyweekMonth">'+ modalTempTableContent['everyweekMonth'][j].innerHTML +'</td><td class="periodId" style="display:none;">' + modalTempTableContent['periodId'][j].innerHTML + '</td><td class="periodName" >' + modalTempTableContent['periodName'][j].innerHTML + '</td><td style="display:none;" class="price">' + modalTempTableContent['price'][j].innerHTML + '</td><td class="amt" style="display:none;">' +modalTempTableContent['amt'][j].innerHTML+ '</td><td class="purpose">' + modalTempTableContent['purpose'][j].innerHTML +'</td><td style="color:#800000;" title="' + modalTempTableContent['address'][j].innerHTML +'" class="postage1">' + modalTempTableContent['postage'][j].innerHTML +'</td><td style="display:none;" class="address">' + modalTempTableContent['address'][j].innerHTML +'</td><td>No</td><td class="link1"><a style="cursor:pointer;" onClick="updateTable(' + modalTempTableContent['si'][j].innerHTML + ');"><img style="width:24px; height:24px;" title="delete" src="<?=base_url()?>images/delete1.svg"></a></td><td style="display:none;" class="sevaName">' + modalTempTableContent['sevaName'][j].innerHTML + '</td><td style="display:none;" class="quantityChecker">' + modalTempTableContent['quantityChecker'][j].innerHTML + '</td><td style="display:none;" class="deityId">' + modalTempTableContent['deityId'][j].innerHTML + '</td><td style="display:none;" class="userId">' + modalTempTableContent['userId'][j].innerHTML + '</td><td style="display:none;" class="sevaId">' + modalTempTableContent['sevaId'][j].innerHTML + '</td><td style="display:none;" class="isSeva">' + modalTempTableContent['isSeva'][j].innerHTML + '</td><td style="display:none;" class="revFlag">' + modalTempTableContent['revFlag'][j].innerHTML + '</td><td style="display:none;" class="masa1">' + modalTempTableContent['masa1'][j].innerHTML + '</td><td style="display:none;" class="bomcode1">' + modalTempTableContent['bomcode1'][j].innerHTML + '</td><td style="display:none;" class="thithiName1">' + modalTempTableContent['thithiName1'][j].innerHTML + '</td><td style="display:none;" class="addLine1">' + modalTempTableContent['addressLine1'][j].innerHTML + '</td><td style="display:none;" class="addLine2">' + modalTempTableContent['addressLine2'][j].innerHTML + '</td><td style="display:none;" class="city1">' + modalTempTableContent['city'][j].innerHTML + '</td><td style="display:none;" class="state">' + modalTempTableContent['state'][j].innerHTML + '</td><td style="display:none;" class="country">' + modalTempTableContent['country'][j].innerHTML + '</td><td style="display:none;" class="pincode">' + modalTempTableContent['pincode'][j].innerHTML + '</td><td style="display:none;" class="calType1">' + modalTempTableContent['calType1'][j].innerHTML + '</td></tr>';
		 }

		 let selSevaCombo = getModalSevaCombo();

		 let eDeityId = selSevaCombo.deityId;
		 let eSevaId = selSevaCombo.sevaId;
		 let eSevaType = selSevaCombo.sevaType;

		 let eCorpus = $('#modalCorpus').val();
		 let eSevaQty = $('#modalSevaQty').val();
		 let eSevaPurpose = $('#modalSevaNotes').val().trim();
		// let eSelectday = $('modalselectday').val();
		let eSSReceiptNo = $('#modalreceiptLine1').val().trim();
		let eSSReceiptDate = $('#modalreceiptLine2').val();

		let ePeriodId = document.getElementById("modalPeriodCombo").value.split("|")[0];
		let ePeriodName = document.getElementById("modalPeriodCombo").value.split("|")[1];

		let eEngDate = "", emasa = "", ebom = "", eThithiName = "", eThithiCode = "",eSelectday="";
		if(eCalType == "Hindu") {
			let eMasaCode = document.getElementById("modalMasaCode").value.split("|");
			let eBomCode = document.getElementById("modalBomCode").value.split("|");

			let eThitiCode;
			if(eBomCode[0] == "SH") {
				eThithi = document.getElementById("modalThithiCode").value.split("|");
			} else {
				eThithi = document.getElementById("modalThithiCode1").value.split("|");
			}

			/*//modal festival code start
			let modalFestivalThithiCode = document.getElementById("modalFestivalCode").value;
			let thithi1 = ( $('#modalHindu').prop('checked') ? eMasaCode[0]+eBomCode[0]+eThithi : ""  );
			let thithi2 = ( $('#modalFestivalwise').prop('checked') ? modalFestivalThithiCode : ""  );
			if(thithi1!="")
			{
				eThithiCode = thithi1;
			}
			else if(thithi2!="")
			{
				eThithiCode = thithi2;
			}
			//modal festival code end*/
			eThithiCode = eMasaCode[0]+eBomCode[0]+eThithi[0];
			eEngDate = "";
			eSelectday="";
			emasa = eMasaCode[1];
			ebom = eBomCode[1];
			eThithiName = eThithi[1];

		} else if(eCalType == "Festivalwise") {
			eEngDate = "",emasa = "",ebom = "",eThithiName = "",eThithiCode = "",eSelectday="";  //Festval new
			let modalFestivalThithiCode = document.getElementById("modalFestivalCode").value;
			eThithiCode =modalFestivalThithiCode;
			eEngDate = "";
			eSelectday="";

		} else if(eCalType == "Gregorian"){
			eEngDate = "",emasa = "",ebom = "",eThithiName = "",eThithiCode = "",eSelectday="";
			if($('#modalmultiDate').val() != "") 
				eEngDate = $('#modalmultiDate').val().split("-")[0] + "-" + $('#modalmultiDate').val().split("-")[1];
			eSelectday="";
		} else if(eCalType == "Every") {
			eEngDate = "",emasa = "",ebom = "",eThithiName = "",eThithiCode = "",eSelectday="";  //Festval new
			// let modalSelectDayCode = document.getElementById("modalselectday").value;
			// // let modalWeekMonthCode = document.getElementById("modalselectday").value;
		  // 	 // alert(document.getElementById("modalweekMonth").value);
		  // 	 if(document.getElementById("modalweekMonth").value == "Month") {
		  // 	 	modalSelectDayCode = "First_" + modalSelectDayCode;

	  	 	//}
	  	 	let modaleveryMonthval = document.getElementById("modalmasaevery").value.split("|");
	  		let modaleveryFivedaysval = document.getElementById("modaleveryFivedaysval").value;
			let modalmodeOfChangeMonth = document.getElementById("modalmodeOfChangeMonth").value;
			let modalSelectDayCode = document.getElementById("modalselectday").value;
			if(document.getElementById("modalweekMonth").value == "Month") {
				modalSelectDayCode = modaleveryFivedaysval+"_" + modalSelectDayCode;
			} else if(document.getElementById("modalweekMonth").value == "Year") {
				modalSelectDayCode = modalmodeOfChangeMonth+"_" +modaleveryFivedaysval+"_" + modalSelectDayCode;
			}else if(document.getElementById("modalweekMonth").value == "YearHindu") {
					modalSelectDayCode = modaleveryMonthval[1]+"_" +modaleveryFivedaysval+"_" + modalSelectDayCode;
				}
	  	 eSelectday =modalSelectDayCode;
	  	 eEngDate = "";

	  	}

	  	$.post("<?= site_url();?>Shashwath/updateShashwathSevaDetails", {"smId":sMemberId,"rId": receiptId,"ssId": SSID, "ss_receipt_no":eSSReceiptNo,"ss_receipt_date":eSSReceiptDate,"deityId": eDeityId,"sevaId": eSevaId,"sevaQty": eSevaQty,"sevaType": eSevaType,"calType": eCalType,"thithiCode": eThithiCode,"engDate": eEngDate,"spId": ePeriodId,"periodName": ePeriodName,"masa": emasa,"bom": ebom,"thithi":eThithiName,"purpose":eSevaPurpose,"corpus":eCorpus,"everyweekMonth":eSelectday,"verificationStatus":verificationStatus}
	  		, function (e) {
	  			e1 = e.split("|")
	  			if (e1[0] == "success") {
	  				alert("Information","Seva Details Updated Successfully");
	  				arrUpdSeva = JSON.parse(e1[1]);

	  				$('#eventUpdate').html("");
	  				$("#editModal").modal("hide");

	  				var strTableData = "";
	  				for(var i=1;i<=arrUpdSeva.length;i++){
	  					strTableData =  '<tr><td>'+ i +'</td><td>'
	  					+ ((arrUpdSeva[i-1].SS_RECEIPT_NO != "")?arrUpdSeva[i-1].RECEIPT_NO + ' ('+arrUpdSeva[i-1].SS_RECEIPT_NO + ')':arrUpdSeva[i-1].RECEIPT_NO) +'</td><td>'
	  					+ arrUpdSeva[i-1].SS_RECEIPT_DATE +'</td><td>'
	  					+ arrUpdSeva[i-1].DEITY_NAME +'</td><td>'
	  					+ arrUpdSeva[i-1].SEVA_NAME +'</td><td>'
	  					+ arrUpdSeva[i-1].SEVA_QTY +'</td>';

	  					if(arrUpdSeva[i-1].CORPUS_CNT > 1) {
	  						strTableData += '<td><a style="color: red;" href="#" onclick="corpusRaiseDetails('+ arrUpdSeva[i-1].SS_ID + ')" data-toggle="modal" data-target="#modalCorpusHistory"><u>' + arrUpdSeva[i-1].RECEIPT_PRICE + '</u></a>&nbsp;<img id="corpusRaiseBtn" src="<?=base_url()?>images/add_icon.svg" title ="Raise the Corpus" onclick="corpusRaise(\''+arrUpdSeva[i-1].SS_ID +'\',\''+ arrUpdSeva[i-1].RECEIPT_NO +'\',\''+ arrUpdSeva[i-1].SEVA_NAME +'\',\''+ arrUpdSeva[i-1].SM_NAME +'\',\''+ arrUpdSeva[i-1].SM_ADDR1 +'\',\''+ arrUpdSeva[i-1].SM_ADDR2 +'\',\''+ arrUpdSeva[i-1].SM_CITY +'\',\''+ arrUpdSeva[i-1].SM_STATE +'\',\''+ arrUpdSeva[i-1].SM_COUNTRY +'\',\''+ arrUpdSeva[i-1].SM_PIN +'\',\''+ arrUpdSeva[i-1].RECEIPT_PRICE +'\',\''+ arrUpdSeva[i-1].SHASH_PRICE +'\',\''+ arrUpdSeva[i-1].SHASH_SEVA_COST +'\',\''+ arrUpdSeva[i-1].SEVA_CORPUS +'\',\''+ arrUpdSeva[i-1].TOTAL_SEVA_COST +'\',\''+ arrUpdSeva[i-1].NO_OF_SEVAS +'\',\''+ arrUpdSeva[i-1].DEITY_NAME +'\',\''+ arrUpdSeva[i-1].SM_PHONE +'\',\''+ arrUpdSeva[i-1].SM_ID +'\');"</td>'; 
	  					} else {
	  						strTableData += '<td>' + arrUpdSeva[i-1].RECEIPT_PRICE + '&nbsp;<img id="corpusRaiseBtn" src="<?=base_url()?>images/add_icon.svg" title ="Raise the Corpus" onclick="corpusRaise(\''+arrUpdSeva[i-1].SS_ID +'\',\''+ arrUpdSeva[i-1].RECEIPT_NO +'\',\''+ arrUpdSeva[i-1].SEVA_NAME +'\',\''+ arrUpdSeva[i-1].SM_NAME +'\',\''+ arrUpdSeva[i-1].SM_ADDR1 +'\',\''+ arrUpdSeva[i-1].SM_ADDR2 +'\',\''+ arrUpdSeva[i-1].SM_CITY +'\',\''+ arrUpdSeva[i-1].SM_STATE +'\',\''+ arrUpdSeva[i-1].SM_COUNTRY +'\',\''+ arrUpdSeva[i-1].SM_PIN +'\',\''+ arrUpdSeva[i-1].RECEIPT_PRICE +'\',\''+ arrUpdSeva[i-1].SHASH_PRICE +'\',\''+ arrUpdSeva[i-1].SHASH_SEVA_COST +'\',\''+ arrUpdSeva[i-1].SEVA_CORPUS +'\',\''+ arrUpdSeva[i-1].TOTAL_SEVA_COST +'\',\''+ arrUpdSeva[i-1].NO_OF_SEVAS +'\',\''+ arrUpdSeva[i-1].DEITY_NAME +'\',\''+ arrUpdSeva[i-1].SM_PHONE +'\',\''+ arrUpdSeva[i-1].SM_ID +'\');"</td>';
	  					}

	  					strTableData += '<td>'+ arrUpdSeva[i-1].ENG_DATE +'</td><td>'
	  					+ arrUpdSeva[i-1].THITHI_CODE +'</td><td>'
	  					+ arrUpdSeva[i-1].EVERY_WEEK_MONTH +'</td><td>'
	  					+ arrUpdSeva[i-1].PERIOD_NAME +'</td><td>'
	  					+ arrUpdSeva[i-1].SEVA_NOTES +'</td><td style="color:#800000;" title="'+arrUpdSeva[i-1].POSTAL_ADDR+ '">'
	  					+ ((arrUpdSeva[i-1].POSTAGE_CHECK == 1)? "YES":"NO") +'</td><td>'
	  					+ ((arrUpdSeva[i-1].SS_VERIFICATION == 0)?"No":"Yes") +'</td>';

	  					var Notes1 = arrUpdSeva[i-1].SEVA_NOTES.replace("\n"," "); 
	  					Notes2 = Notes1.replace("'","\'"); 
	  					if(arrUpdSeva[i-1].SS_VERIFICATION == 0) {
	  						strTableData += '<td><img id="myBtn" src="<?=base_url()?>images/edit_icon.svg" onClick="editSevaDetail(\''+arrUpdSeva[i-1].SM_ID+'\',\''+ arrUpdSeva[i-1].SS_ID +'\',\''+ arrUpdSeva[i-1].RECEIPT_NO +'\',\''+ arrUpdSeva[i-1].RECEIPT_ID +'\',\''+ arrUpdSeva[i-1].DEITY_ID  +'\',\''+ arrUpdSeva[i-1].SEVA_ID +'\',\''+ arrUpdSeva[i-1].FIRST_RECEIPT_PRICE +'\',\''+ arrUpdSeva[i-1].SEVA_QTY +'\',\''+ arrUpdSeva[i-1].SS_RECEIPT_NO_REF +'\',\''+ arrUpdSeva[i-1].RECEIPT_DATE +'\',\''+ arrUpdSeva[i-1].SP_ID +'\',\''+ Notes2 +'\',\''+ arrUpdSeva[i-1].MASA +'\',\''+ arrUpdSeva[i-1].BASED_ON_MOON +'\',\''+ arrUpdSeva[i-1].THITHI_NAME +'\',\''+ arrUpdSeva[i-1].THITHI_CODE +'\',\''+ arrUpdSeva[i-1].ENG_DATE +'\',\''+ arrUpdSeva[i-1].EVERY_WEEK_MONTH +'\',\''+ arrUpdSeva[i-1].CAL_TYPE +'\',\''+ arrUpdSeva[i-1].PERIOD_NAME +'\',\''+ arrUpdSeva[i-1].SS_VERIFICATION +'\')"><img id="deleteSevaBtn" style="width:24px; height:24px" src="<?=base_url()?>images/trash.svg"  title ="delete Seva" onClick="deleteSeva(\''+arrUpdSeva[i-1].SM_ID+'\',\''+ arrUpdSeva[i-1].SS_ID +'\',\''+ arrUpdSeva[i-1].RECEIPT_NO +'\',\''+ arrUpdSeva[i-1].RECEIPT_ID +'\',\''+ arrUpdSeva[i-1].DEITY_ID  +'\',\''+ arrUpdSeva[i-1].SEVA_ID +'\',\''+ arrUpdSeva[i-1].FIRST_RECEIPT_PRICE +'\',\''+ arrUpdSeva[i-1].SEVA_QTY +'\',\''+ arrUpdSeva[i-1].SS_RECEIPT_NO_REF +'\',\''+ arrUpdSeva[i-1].RECEIPT_DATE +'\',\''+ arrUpdSeva[i-1].SP_ID +'\',\''+ Notes2 +'\',\''+ arrUpdSeva[i-1].THITHI_CODE +'\',\''+ arrUpdSeva[i-1].ENG_DATE +'\',\''+ arrUpdSeva[i-1].CAL_TYPE +'\')"></td></tr>';

	  					} else {
	  						strTableData += '<td></td></tr>';
	  					}

	  					$('#eventUpdate').append(strTableData);
	  				}

	  				$('#eventUpdate').append(strNewShashSeva);
	  			}
	  			else
	  				alert("Something went wrong, Please try again after some time");
	  		});
}

function getModalSevaCombo() {
	let selectedSevaCombo = $('#editModalSevaCombo option:selected').val();
	selectedSevaCombo = selectedSevaCombo.split("|");

	return {
		deityId: selectedSevaCombo[0],
		sevaId: selectedSevaCombo[1],
		sevaType : selectedSevaCombo[6]
	}
}
var tempModalQty;
function inputModalQuantity(qtyModalValue) { 
	if (isNaN(qtyModalValue)){
		document.getElementById('modalSevaQty').value = '';
	} else if(document.getElementById('modalSevaQty').value == 0) { 
		document.getElementById('modalSevaQty').value = '';
	} else if(qtyModalValue < 51){
		tempModalQty = qtyModalValue;
	} else {
		$('#modalSevaQty').val(tempModalQty);
			// console.log(tempModalQty);
			alert("Information","Quantity cannot exceed 50","OK");
		}
	}

	$('#modalCorpus').keyup(function (e) {
		var $th = $(this);

		if (e.keyCode != 46 && e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 38 && e.keyCode != 39 && e.keyCode != 40) {
			$th.val($th.val().replace(/[^0-9]/g, function (str) { return ''; }));
		} return;
	});

	function validNum(input){
		var regex=/[^0-9 ]/gi;
		input.value=input.value.replace(regex,"");
	}

	function alphaonlypurpose(input) {
		var regex=/[^-a-z-0-9., ]/gi;
		input.value=input.value.replace(regex,"");
	}

	function alphaonlyAdrs(input) {
		var regex=/[^-a-z-0-9.,()/ ]/gi;
		input.value=input.value.replace(regex,"");
	}
	
	function deleteSeva(smId,ssId,rNo,rId,dId,deitySevaId,sAmt,sQty,ssRNo,ssRDate,spId,sPurpose,thithi_code,ssEngDate,getCalType){
		let url = "<?=site_url()?>Shashwath/isSevaGenarated";
		$.post(url, { 'ssId': ssId}, function (e) {
			if(e > 0){
				alert("Information","Generated Sevas Cannot Be Deleted!!","OK");
				return;
			} else {
				arrDeity = <?php echo @$deityEdit; ?>;
				for (let i = 0; i < arrDeity.length; ++i) {
					if (arrDeity[i]['DEITY_ID'] == dId)
						$('#deleteDeityName').html(arrDeity[i]['DEITY_NAME']);
				}

				arrSevas = <?php echo @$sevas; ?>;
				for (let i = 0; i < arrSevas.length; ++i) {
					if (arrSevas[i]['DEITY_ID'] == dId && arrSevas[i]['SEVA_ID'] == deitySevaId)
						$('#deleteSevaName').html( arrSevas[i]['SEVA_NAME']);

				}

				$('#deleteCorpus').html(sAmt);
				$('#deleteQty').html(sQty);
				$('#deletePurpose').html(sPurpose);
				$('#deleteSSReceiptNo').html(ssRNo);
				$('#deleteSSReceiptDate').html(ssRDate);

				$('#deleteSSID').val(ssId);
				$('#deleteReceiptId').val(rId);


				if(getCalType == "Gregorian") {     
					$('#deleteThithiCode').html(ssEngDate+"-"+(new Date()).getFullYear());
				} else if (getCalType == "Hindu") {
					$('#deleteThithiCode').html(thithi_code);
				} else if (getCalType == "Festivalwise"){
					$('#deleteThithiCode').html(thithi_code);
				}

				let sevaCount = <?php echo count($members); ?>;
				if(sevaCount > 1){
					document.getElementById("deleteAlert").style.display ="none";

				} else {
					document.getElementById("deleteAlert").style.display ="block";

				}
				$('#deleteSevaModal').modal();
				
			}
		});
	}

	function inputPincode(pinValue) { 
		if (isNaN(pinValue)){
			document.getElementById('smpin').value = '';
		}
		$('#smpin').prop('maxlength',6);
	}

	function inputPincodeMandali(pinValue,ids) { 
		if (isNaN(pinValue)){
			document.getElementById(ids).value = '';
		}
		$('#'+ids).prop('maxlength',6);
	}
	


	//NEW_CODE_START
	function addRow1() {
		$("#update").css('display','none');
		$("#submitRecord").css('display','block');
		let tableContent = getMandaliTableValues1();
		let name = $('#mandalimemname').val()
		let number = $('#mandalimemphone').val()
		let number2 = $('#mandalimemphone2').val()
		let rashi = $('#mandalimemrashi').val()
		let nakshatra = $('#mandalimemnakshatra').val();
		let gotra = $('#mandalimemGotra').val();
		let remarks = $('#mandalimemsmremarks').val();
		let addLine1 = $('#mandalimemaddLine1').val(); 
		let addLine2 = $('#mandalimemaddLine2').val(); 
		let city = $('#mandalimemcity').val();
		let state = $('#mandalimemstate').val();
		let country = $('#mandalimemcountry').val();
		let pincode = $('#mandalimempincode').val();
		let address = "";
		let count = 0;
		if(addLine1.trim().length > 0) {
			address += addLine1+ ", ";
		}

		if(addLine2.trim().length > 0) {
			address += addLine2+ ", ";
		}

		if(city.trim().length > 0) {
			address += city + ", ";
		}

		if(state.trim().length > 0) {
			address += state + ", ";
		}

		if(country.trim().length > 0) {
			address += country + ", ";
		}

		if(pincode.trim().length > 0) {
			address += pincode;
		}
		$('#address').val(address);

		if (name) {
			$('#mandalimemname').css('border-color', "#ccc")

		} else {
			$('#mandalimemname').css('border-color', "#FF0000")
			++count;
		}
		if (number) {
			$('#mandalimemphone').css('border-color', "#ccc")

		} else {
			$('#mandalimemphone').css('border-color', "#FF0000")
			++count;
		}
		if (addLine1) {
			$('#mandalimemaddLine1').css('border-color', "#ccc")

		} else {
			$('#mandalimemaddLine1').css('border-color', "#FF0000")
			++count;
		}
		if (state) {
			$('#mandalimemstate').css('border-color', "#ccc")

		} else {
			$('#mandalimemstate').css('border-color', "#FF0000")
			++count;
		}
		if (country) {
			$('#mandalimemcountry').css('border-color', "#ccc")

		} else {
			$('#mandalimemcountry').css('border-color', "#FF0000")
			++count;
		}
		if (count != 0) {
			alert("Information", "Please fill required fields", "OK");
			return;
		}  
		let si = $('#eventSeva1 tr:last-child td:first-child').html();
		if (!si)
			si = 1
		else
			++si;
		$('#eventSeva1').append('<tr class="mm_' + si + ' siMandali1"><td class="siMandali">' + si + '</td><td class="nameMandali">' + name + '</td><td class="numberMandali">' + number + '</td><td class="number2Mandali"  style="display:none;">' + number2 + '</td><td class="rashiMandali">' + rashi + '</td><td class="nakshatraMandali">' + nakshatra + '</td><td class="gotraMandali">'+gotra+'</td><td class="addressMandali" >'+ address +'</td><td class="remarksMandali">'+ remarks +'</td><td class="addLine1Mandali" style="display:none;">'+ addLine1 +'</td><td class="addLine2Mandali" style="display:none;">'+ addLine2 +'</td><td class="cityMandali" style="display:none;">'+ city +'</td><td class="stateMandali" style="display:none;">'+ state +'</td><td class="countryMandali" style="display:none;">'+ country +'</td><td class="pincodeMandali" style="display:none;">'+ pincode +'</td><td class="link1" ><a style="cursor:pointer;" onClick="updateMandaliTable(' + si + ');"><img style="width:24px; height:24px;" title="delete" src="<?=base_url()?>images/delete1.svg"></a></td></tr>');
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
	}

	function mandaliSubmit() {
		let count = 0;
		let tableContent = getMandaliTableValues1();
		let smAddress = "";
		let address = [];
		let name = [];
		let number = [];
		let rashi = [];
		let nakshatra = [];
		let gotra = [];
		let remarks = [];

		let total = 1 
		$('#eventUpdate3').html("");

		$('#mandalimodal .modal-body').append("<label>DATE:</label> " + "<?=date('d-m-Y'); ?>" + "<br/>");

		$('#mandalimodal .modal-body').html('<div class="table-responsive" style="overflow-x:hidden"><table class="table "><thead><tr><th style="border:1px solid #7d6363"><center>Sl. No.</center></th><th style="border:1px solid #7d6363">Name</th><th style="border:1px solid #7d6363">Phone</th><th style="border:1px solid #7d6363"><center>Rashi</center></th><th style="border:1px solid #7d6363"><center>Nakshatra</center></th><th style="border:1px solid #7d6363"><center>Seva Gotra</center></th><th style="border:1px solid #7d6363"><center>Address</center></th><th style="border:1px solid #7d6363"><center>Remarks</center></th></tr></thead><tbody id="eventUpdate3"></tbody></table></div>')

		for (i = 0; i < tableContent['name'].length; ++i) {
			$('#eventUpdate3').append("<tr>");
			$('#eventUpdate3').append("<td style='border:1px solid #7d6363'><center>" + tableContent['si'][i].innerHTML + "</center></td>");
			$('#eventUpdate3').append("<td style='border:1px solid #7d6363'>" + tableContent['name'][i].innerHTML + "</td>");
			$('#eventUpdate3').append("<td style='border:1px solid #7d6363'>" + tableContent['number'][i].innerHTML + "</td>");
			$('#eventUpdate3').append("<td style='border:1px solid #7d6363'><center>" + tableContent['rashi'][i].innerHTML + "</center></td>");
			$('#eventUpdate3').append("<td style='border:1px solid #7d6363'><center>" + tableContent['nakshatra'][i].innerHTML + "</center></td>");
			$('#eventUpdate3').append("<td style='border:1px solid #7d6363'><center>" + tableContent['gotra'][i].innerHTML + "</center></td>");
			$('#eventUpdate3').append("<td style='border:1px solid #7d6363'><center>" + tableContent['address'][i].innerHTML + "</center></td>");
			$('#eventUpdate3').append("<td style='border:1px solid #7d6363'><center>" + tableContent['remarks'][i].innerHTML + "</center></td>");
			$('#eventUpdate3').append("</tr><br/>");
		}
		$('#mandalimodal').modal();
		$('.bs-example-modal-lg').focus();
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
			pincode: pincode
		}
	}

	$('#submitmandali').on('click', function () {
		let tableContent = getMandaliTableValues1();
		var smIdVal="<?php echo $members[0]->SM_ID;?>";
		let address = [];
		let addressLine1 = [];
		let addressLine2 = [];
		let city = [];
		let state = [];
		let country = [];
		let pincode = [];
		let rashi = [];
		let gotra = [];
		let nakshatra = [];
		let number = [];
		let number2 = [];
		let remarks = [];
		let name = [];

		let total = 1/* $('#totalAmount').html().trim() */;
		let url = "<?=site_url()?>Shashwath/newMandalimemberinsert";
		for (let i = 0; i < tableContent['name'].length; ++i) {
			name[i] = tableContent['name'][i].innerHTML.trim();
			number[i] = tableContent['number'][i].innerHTML.trim();
			number2[i] = tableContent['number2'][i].innerHTML.trim();
			rashi[i] = tableContent['rashi'][i].innerHTML.trim();
			nakshatra[i] = tableContent['nakshatra'][i].innerHTML.trim();
			gotra[i] = tableContent['gotra'][i].innerHTML.trim();
			addressLine1[i] = tableContent['addressLine1'][i].innerHTML.trim();
			addressLine2[i] = tableContent['addressLine2'][i].innerHTML.trim();
			city[i] = tableContent['city'][i].innerHTML.trim();
			state[i] = tableContent['state'][i].innerHTML.trim();
			country[i] = tableContent['country'][i].innerHTML.trim();
			pincode[i] = tableContent['pincode'][i].innerHTML.trim();
			remarks[i] = tableContent['remarks'][i].innerHTML.trim();		
		}
		$.post(url, {'name': JSON.stringify(name),'number': JSON.stringify(number),'number2': JSON.stringify(number2),'rashi': JSON.stringify(rashi),'gotra': JSON.stringify(gotra), 'nakshatra': JSON.stringify(nakshatra), 'addressLine1': JSON.stringify(addressLine1), 'addressLine2': JSON.stringify(addressLine2), 'city': JSON.stringify(city),'state':JSON.stringify(state), 'country': JSON.stringify(country), 'pincode': JSON.stringify(pincode), 'remarks': JSON.stringify(remarks),'smIdVal':smIdVal }, function (e) {
			e1 = e.split("|")
			if (e1[0] == "success")
				location.href ="<?=site_url()?>Shashwath/shashwath_member";
				// alert("Information","Member inserted succesfully","OK");
				else
					alert("Something went wrong, Please try again after some time");
			});
	});

	function deleteMandaliMember(SM_ID,MM_ID,MM_NAME){
		$('#D_Name').val(MM_NAME);
		$('#D_SM_ID').val(SM_ID);
		$('#D_MM_ID').val(MM_ID);
		$('#deleteMandaliMemberModal').modal({backdrop: 'static', keyboard: false});
	}		
	function deleteMandaliMemberSubmit(){
		let SM_ID = $('#D_SM_ID').val();
		let MM_ID = $('#D_MM_ID').val();
		let url = "<?=site_url()?>Shashwath/mandalimemberDelete";
		$.post(url, {'SM_ID_VAL':SM_ID,'MM_ID_VAL':MM_ID }, function (e) {
			e1 = e.split("|")
			if (e1[0] == "success"){
				let mmRemove = document.getElementsByClassName("mm_"+MM_ID);
				mmRemove[0].remove();
				$("#deleteMandaliMemberModal").modal("hide");
				alert("Information","Member Deleted succesfully","OK");
			}
			else
				alert("Something went wrong, Please try again after some time");
		});
	}

	function editMandaliMemberDetail(SM_ID,MM_NAME,MM_PHONE,MM_PHONE2,MM_RASHI,MM_NAKSHATRA,MM_GOTRA,MM_ADDR1,MM_ADDR2,MM_CITY,MM_STATE,MM_COUNTRY,MM_PIN,MM_REMARKS,MM_ID){
		$('#MMname').val(MM_NAME);
		$('#MMphone').val(MM_PHONE);
		$('#MMphone2').val(MM_PHONE2);
		$('#MMrashi').val(MM_RASHI);
		$('#MMnakshatra').val(MM_NAKSHATRA);
		$('#MMGotra').val(MM_GOTRA);
		$('#MMaddLine1').val(MM_ADDR1);
		$('#MMaddLine2').val(MM_ADDR2);
		$('#MMcity').val(MM_CITY);
		$('#MMstate').val(MM_STATE);
		$('#MMcountry').val(MM_COUNTRY);
		$('#MMpincode').val(MM_PIN);
		$('#MMremarks').val(MM_REMARKS);
		$('#MMID').val(MM_ID);
		$('#editMandaliMemberModal').modal();
	}

	function updateMMDetail(){
		let MM_NAME = $('#MMname').val();
		let MM_PHONE = $('#MMphone').val();
		let MM_PHONE2 = $('#MMphone2').val();
		let MM_RASHI = $('#MMrashi').val();
		let MM_NAKSHATRA = $('#MMnakshatra').val();
		let MM_GOTRA = $('#MMGotra').val();
		let MM_ADDR1 = $('#MMaddLine1').val();
		let MM_ADDR2 = $('#MMaddLine2').val();
		let MM_CITY = $('#MMcity').val();
		let MM_STATE = $('#MMstate').val();
		let MM_COUNTRY = $('#MMcountry').val();
		let MM_PIN = $('#MMpincode').val();
		let MM_REMARKS = $('#MMremarks').val();
		let MM_ID = $('#MMID').val();
		var smIdVal="<?php echo $members[0]->SM_ID;?>";

		modalTempTableContent = getMandaliTableValues1();
		var strNewShashSeva = "";
		for(var j=0;j<modalTempTableContent['name'].length;j++) {
			strNewShashSeva += '<tr class="' + modalTempTableContent['si'][j].innerHTML + ' siMandali1"><td class="siMandali">' + modalTempTableContent['si'][j].innerHTML + '</td><td class="nameMandali">' + modalTempTableContent['name'][j].innerHTML + '</td><td class="numberMandali">' + modalTempTableContent['number'][j].innerHTML + '</td><td class="number2Mandali" style="display:none;">' + modalTempTableContent['number2'][j].innerHTML + '</td>     <td class="rashiMandali">' + modalTempTableContent['rashi'][j].innerHTML + '</td><td class="nakshatraMandali">' + modalTempTableContent['nakshatra'][j].innerHTML + '</td><td class="gotraMandali">' + modalTempTableContent['gotra'][j].innerHTML + '</td><td class="addressMandali">' + modalTempTableContent['address'][j].innerHTML + '</td><td class="remarksMandali">' + modalTempTableContent['remarks'][j].innerHTML + '</td><td class="addLine1Mandali" style="display:none;">' + modalTempTableContent['addressLine1'][j].innerHTML + '</td><td class="addLine2Mandali" style="display:none;">' + modalTempTableContent['addressLine2'][j].innerHTML + '</td><td class="cityMandali" style="display:none;">' + modalTempTableContent['city'][j].innerHTML + '</td><td class="stateMandali" style="display:none;">' + modalTempTableContent['state'][j].innerHTML + '</td><td class="countryMandali" style="display:none;">' + modalTempTableContent['country'][j].innerHTML + '</td><td class="pincodeMandali" style="display:none;">' + modalTempTableContent['pincode'][j].innerHTML + '</td><td class="link1"><a style="cursor:pointer;" onClick="updateMandaliTable(' + modalTempTableContent['si'][j].innerHTML + ');"><img style="width:24px; height:24px;" title="delete" src="<?=base_url()?>images/delete1.svg"></a></td></tr>';			
		}

		let url = "<?=site_url()?>Shashwath/updateMandaliMember";
		$.post(url, {'MMname':MM_NAME,'MMphone':MM_PHONE,'MMphone2':MM_PHONE2,'MMrashi':MM_RASHI,'MMnakshatra':MM_NAKSHATRA,'MMGotra':MM_GOTRA,'MMaddLine1':MM_ADDR1,'MMaddLine2':MM_ADDR2,'MMcity':MM_CITY,'MMstate':MM_STATE,'MMcountry':MM_COUNTRY,'MMpincode':MM_PIN,'MMremarks':MM_REMARKS,'MMID':MM_ID,'smIdVal':smIdVal }, function (e) {
			e1 = e.split("|")
			if (e1[0] == "success"){
				alert("Information","Member Updated succesfully","OK");
				arrUpdMem = JSON.parse(e1[1]);
				$('#eventUpdate1').html("");
				$("#editMandaliMemberModal").modal("hide");
				var strTableData = "";
				for(var i=1;i<=arrUpdMem.length;i++){
					strTableData =  '<tr><td>'+ i +'</td><td>'
					+ arrUpdMem[i-1].MM_NAME +'</td><td>'
					+ arrUpdMem[i-1].MM_PHONE +', '+ arrUpdMem[i-1].MM_PHONE2 +'</td><td>'
					+ arrUpdMem[i-1].MM_RASHI +'</td><td>'
					+ arrUpdMem[i-1].MM_NAKSHATRA +'</td><td>'
					+ arrUpdMem[i-1].MM_GOTRA +'</td><td>'
					+ arrUpdMem[i-1].MM_ADDR1 +', '+ arrUpdMem[i-1].MM_ADDR2+', '+ arrUpdMem[i-1].MM_CITY+', '+ arrUpdMem[i-1].MM_STATE+', '+ arrUpdMem[i-1].MM_COUNTRY+', '+ arrUpdMem[i-1].MM_PIN+'</td><td>'
					+ arrUpdMem[i-1].MM_REMARKS +'</td>';
					
					strTableData += '<td><img id="myMandaliBtn" src="<?=base_url()?>images/edit_icon.svg" title ="Edit and update Member Details" onClick="editMandaliMemberDetail(\''+arrUpdMem[i-1].SM_ID+'\',\''+ arrUpdMem[i-1].MM_NAME +'\',\''+ arrUpdMem[i-1].MM_PHONE +'\',\''+ arrUpdMem[i-1].MM_PHONE2  +'\',\''+ arrUpdMem[i-1].MM_RASHI +'\',\''+ arrUpdMem[i-1].MM_NAKSHATRA +'\',\''+ arrUpdMem[i-1].MM_GOTRA +'\',\''+ arrUpdMem[i-1].MM_ADDR1 +'\',\''+ arrUpdMem[i-1].MM_ADDR2 +'\',\''+ arrUpdMem[i-1].MM_CITY +'\',\''+ arrUpdMem[i-1].MM_STATE +'\',\''+ arrUpdMem[i-1].MM_COUNTRY +'\',\''+ arrUpdMem[i-1].MM_PIN +'\',\''+ arrUpdMem[i-1].MM_REMARKS +'\',\''+ arrUpdMem[i-1].MM_ID +'\')"><img id="deleteManMemBtn" style="width:24px; height:24px" src="<?=base_url()?>images/trash.svg"  title ="delete Member" onClick="deleteMandaliMember(\''+arrUpdMem[i-1].SM_ID+'\',\''+ arrUpdMem[i-1].MM_ID +'\',\''+ arrUpdMem[i-1].MM_NAME +'\')"></td></tr>';
					strTableData += '</tr>';
					$('#eventUpdate1').append(strTableData);
				}
				$('#eventUpdate1').append(strNewShashSeva);
			}
			else
				alert("Something went wrong, Please try again after some time");
		});
	}

	function updateMandaliTable(si) {
		if(si != 0) {
			let si1 = document.getElementsByClassName("mm_"+si);
			si1[0].remove();
		}
	}

	$(document).ready(function() { 
		var isMandaliCheck="<?php echo $members[0]->IS_MANDALI;?>";
		if (isMandaliCheck == 1){
			document.getElementById("isMandaliDiv").style.display = "block";
			document.getElementById("mandaliMembId").style.display = "block"; 	
			document.getElementById("isMemberDiv").style.display = "none";
		} else {
			document.getElementById("isMemberDiv").style.display = "block";
			document.getElementById("mandaliMembId").style.display = "none";
			document.getElementById("isMandaliDiv").style.display = "none";
		}
	})

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
	 	//document.getElementById("ismandali").checked = true;
	}

	//NEW_CODE_END
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

</script>