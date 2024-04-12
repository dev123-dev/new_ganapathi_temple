
﻿<?php error_reporting(0); //print_r($members); ?>
<div style="clear:both;" class="container">
	<img class="img-responsive bgImg2 bg1" src="<?=site_url()?>images/TempleLogo.png" />
	<div class="row form-group">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="row form-group">							
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
					<span class="eventsFont2">Edit Additional Corpus Member Details</span>			

					<div class="col-lg-8 col-md-6 col-sm-4 col-xs-12 pull-right text-right" style="padding:0px 0px 0px;">
						<?php if(isset($_SESSION['member_actual_link'])) { ?>
							<a style="margin-left: 9px;pull-right;" onClick="goBack()" title="Back"><img style="width:24px; height:24px" src="<?=site_url();?>images/back_icon.svg"/></a>

						<?php } ?>

					</div>
				</div>
			</div>	

			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="clear:both;" > 
				<div class="col-lg-5 col-md-12 col-sm-12" style="padding-top:10px;margin-left:0px;">
					<?php $i = 1;$j = 20;$name = array('Shashwath Member','Shashwath Seva Details');
					for($k =0 ; $k<2 ;$k++) { ?>
						<a href="#" id="click" onclick="return openCity(event, '<?=$i++;?>');">
							<div id="<?=$j--;?>" class="w5-half tablink w5-bottombar w5-hover-light-grey w5-padding"><?php echo $name[$k];?></div>
						</a>
					<?php } ?>
				</div> 
			</div>
			<br/><br/>

			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-left:0px;margin-top:2em;">	
				<div id="1" class="w5-container city">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-left:0px;">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive">
								<table id="eventSeva" class ="table-bordered" >
									<thead>
										<tr>
											<th width="2%"><center>Name</center></th>
											<th width="2%"><center>Phone(Additional)</center></th>
											<th width="2%"><center>Raashi</center></th>
											<th width="2%"><center>Nakshathra</center></th>
											<th width="2%"><center>Gotra</center></th>
											<th width="2%"><center>Address</center></th>
											<th width="2%"><center>Remarks</center></th>
										</tr>
									</thead>
									<tbody id="eventUpdate">
										<?php $i = 1;  
										foreach ($members as $result) { ?> 
											<tr>
												<td> <center><?php echo $result->SM_NAME;?></center></td>
												<td><center><?php echo $result->SM_PHONE; ?>,<?php echo $result->SM_PHONE2;?></center></td>
												<td><center><?php echo $result->SM_RASHI; ?></center></td>
												<td><center><?php echo $result->SM_NAKSHATRA; ?></center></td>
												<td><center><?php echo $result->SM_GOTRA; ?></center></td>
												<td> <center><?php echo $result->SM_ADDR1; ?>,<?php echo $result->SM_ADDR2; ?>,<?php echo $result->SM_CITY; ?>,<?php echo $result->SM_STATE; ?>,<?php echo $result->SM_COUNTRY; ?>,<?php echo $result->SM_PIN; ?></center></td>
												<td> <center><?php echo $result->REMARKS; ?></center></td>

											</tr>
											<?php $i++;
										} ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class= "col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class= "col-lg-12 col-md-6 col-sm-12 col-xs-9" style="padding-top:25px;">
							<div class="form-group" >
								<label for="name">Name<span style="color:#800000;">*</span></label>
								<input autocomplete="none" type="text" class="form-control form_contct2" id="name" placeholder="" name="name" value="<?php echo str_replace('"','&#34;',$members[0]->SM_NAME); ?>"/>
								<input type="hidden" id="shashMinId" name="shashMinId" value="<?php echo $members[0]->SM_ID;?>"/>
								<input type="hidden" id="shashMinSsId" name="shashMinSsId" value="<?php echo $members[0]->SS_ID;?>"/>
								<input  type="hidden"  id="shashThithiCode" name="shashThithiCode" value="<?php echo $members[0]->THITHI_CODE;?>"/>
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
								<input autocomplete="none" type="text" class="form-control form_contct2" id="addrline1" placeholder="Address Line1" onkeyup="alphaonlyAdrs(this)" name="name" value="<?php echo str_replace('"','&#34;',$members[0]->SM_ADDR1);?>"/>
							</div>
						</div>
						<div class= "col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<input autocomplete="none" type="text" class="form-control form_contct2" id="addrline2" placeholder="Address Line2" onkeyup="alphaonlyAdrs(this)" name="name" value="<?php echo str_replace('"','&#34;',$members[0]->SM_ADDR2);?>"/>
							</div>
						</div>
						<div class= "col-lg-12 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<input autocomplete="none" type="text" class="form-control form_contct2" id="smcity" placeholder="City" name="name" value="<?php echo $members[0]->SM_CITY;?>"/>
							</div>
						</div>
						<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<input autocomplete="none" type="text" class="form-control form_contct2" id="smstate" placeholder="State" name="name" value="<?php echo $members[0]->SM_STATE;?>"/>
							</div>
						</div>
						<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<input autocomplete="none" type="text" class="form-control form_contct2" id="smcountry" placeholder="Country" name="name" value="<?php echo $members[0]->SM_COUNTRY;?>"/>
							</div>
						</div>
						<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<input autocomplete="none" type="text" class="form-control form_contct2" id="smpin" placeholder="PinCode" name="name" value="<?php echo $members[0]->SM_PIN;?>"/><br/>
							</div>
						</div>
					</div>
					<div class= "col-lg-6 col-md-6 col-sm-6 col-xs-12" style="padding-left:30px;">
						<label for="comment">Remarks: </label>
						<textarea class="form-control" rows="5" style="resize:none;" id="smremarks"><?php echo $members[0]->REMARKS;?></textarea>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:80px;">
						<div class="container-fluid">
							<center>
								<button type="button" onclick = "goToTabShashwathSevaDetails();" class="btn btn-default btn-lg">
									Next  <span class="glyphicon glyphicon-forward"></span>
								</button>
							</center>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="2" class="w5-container city" hidden>
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
			</div>

			<div>
				<div style="clear:both;margin-top:0px;" class="container" >
					<div class="row form-group">
						<?php $i; ?>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-left:0px;">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<h5 style="margin-top:-20px;font-weight: bold;">Deity Name : <?php echo $result->DEITY_NAME; ?></h5>
								<h5 style="font-weight: bold;">Seva Name : <?php echo $result->SEVA_NAME; ?></h5>
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="table-responsive">
									<table id="eventSeva" class ="table-bordered" >
										<thead>
											<tr>
												<th width="1%"><center>Sl.No</center></th>
												<th width="2%"><center>New RNo (Old RNo)</center></th>
												<th width="2%"><center>ReceiptName</center></th>
												<th width="1%"><center>ReceiptDate</center></th>
												<th width="1%"><center>Qty</center></th>
												<th width="2%"><center>Corpus</center></th>
												<th width="1%"><center>Date/Thithi</center></th>
												<th width="1%"><center>Week/Month</center></th>	
												<th width="2%"><center>Purpose</center></th>
												<th width="1%"><center>Postage</center></th>	
												<?php if($MMCount >= 1) { ?>
													<th width="4%"><center>Mandali Member</center></th>
													<th width="1%"><center>OP</center></th>
												<?php } ?>
											</tr>
										</thead>
										<tbody id="eventUpdate">
											<?php $i = 1;
											foreach ($members as $result) { ?> 
												<tr>
													<td width="1%"><center><?php echo $i; ?></center></td>
													<td> <center><?php if($result->SS_RECEIPT_NO != "" ) echo $result->RECEIPT_NO . " (".$result->SS_RECEIPT_NO.")"; else echo $result->RECEIPT_NO; ?></center></td>
													<?php
													echo "<td class='rcp_" . $i . "' style='display:none'><center>". $result->RECEIPT_ID."</center></td>";
													?>
													<?php $id1=$result->RECEIPT_ID;?>
													<td> <center><?php echo $result->RECEIPT_NAME;?></center></td>
													<td  width="1%"> <center><?php echo $result->SS_RECEIPT_DATE;?></center></td>
													<td width="1%"> <center><?php echo $result->SEVA_QTY; ?></center></td>
													<td > <center><?php echo $result->RECEIPT_PRICE; ?></center></td>
													<td width="1%"><center><?php echo $result->ENG_DATE; ?><?php echo $result->THITHI_CODE; ?></center></td>
													<td width="1%"><?php echo $result->EVERY_WEEK_MONTH; ?></td> 
													<td width="2%"><center><?php echo $result->SEVA_NOTES; ?></center></td>
													<td style="color:#800000;" title="<?=$result->POSTAL_ADDR; ?>"><center><?php echo (($result->POSTAGE_CHECK == 1)?"YES":"NO"); ?></center></td>
													<?php if($result->ADDL_MM_PAID_BY == 0) {
														if($MMCount >= 1 ) { ?>
															<td>
																<center>
																	<select id='memberMandaliId' name='memberMandaliId' class='form-control memberMandaliId_<?php	echo $i; ?>'>

																		<option value="0" id="mem">Select Member</option>
																		<?php foreach($mandlimembers as $result) { ?> 
																			<option value="<?=$result['MM_ID']; ?>">
																				<?=$result['MM_NAME']; ?>
																			</option>
																		<?php } ?> 
																	</select>
																</center>
															</td>
															<td>
																<center>
																	<a style="border:none; outline: 0;" onClick="assignMandaliMemberId('<?php echo $i ?>','<?php echo $id1 ?>')"  title="Approve Id" ><img style="border:none; outline: 0;" width="24px" height="24px" src="<?php echo	base_url(); ?>images/check_icon.svg"/></a>
																</center>
															</td>
														<?php } ?> 
													<?php }else{ ?>
														<td><center><?php echo $result->MM_NAME; ?></center></td>
														<td></td>	
													<?php } ?>
												</tr>
												<?php $i++; 
											} ?>
										</tbody>
									</table>
								</div>
								<h4 style="margin-top:10px;padding-right:0px;text-align: end;">Total Corpus: <?php echo $membersTotalCorpus ?></h4>
							</div>
							<center>
								<input type="button" id="update" value="<?php if(isset($_SESSION['Authorise'])) echo "Verify & Merge Corpus"; else echo "Update"; ?>" name="Update"  onClick="updateData('<?php echo $MMCount ?>','<?php echo $result->ADDL_MM_PAID_BY ?>');" class="btn btn-default btn-lg" />
							</center>
						</div>	
					</div>
				</div>
			</div>	
		</div>
	</div>
</div>
<form id="form" action="<?=site_url();?>Receipt/receipt" method="post">
	<input type="hidden" id="smId" name="identity" value="<?php echo $members[0]->SM_ID;?>"/>
	<input type="hidden" id="call" name="" value="<?php echo $call ?>">
</form>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="sevaModal">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Corpus Merge Preview</h4>
			</div>
			<div class="modal-body">

			</div>
			<div class="modal-footer text-left" style="text-align:left;">
				<label>Are you sure you want to Merge this Corpus..?</label>
				<br/>
				<button type="button" style="width: 8%;" class="btn" id="submit" >Yes</button>
				<button type="button" style="width: 8%;" class="btn"  data-dismiss="modal">No</button>
			</div>
		</div>
	</div>
</div> 
<!-- Modal -->

<script src="<?=site_url()?>js/autoComplete.js"></script>

<script>
	$(window).bind("load", function () {
		let which = '<?php echo @$secondTab;?>';
		if (which=='Yes') {
			goToTabShashwathSevaDetails();
		}
	});

	$(document).ready(function() { 
		$('#update').css('display','block');
		$('#submitRecord').css('display','none');
	})

	//var smId="<?php echo $members[0]->SM_ID;?>";
	function updateData($MMCount,$ADDL_MM_PAID_BY) {
	if($ADDL_MM_PAID_BY ==0 ) {
		if($MMCount == 1) {
			let count=0;
			let member2 ="";
			member2 = document.getElementById("mem").value;
			if (member2 == 0) {
				$('#memberMandaliId_').css('border-color', "#FF0000");
				++count;
			} else {
				$('#memberMandaliId_').css('border-color', "#000000");
			}

			 if (count != 0) {
	          alert("Information", "Select Member", "OK");
	          return false;
       		 }
  		 }
  		 $("#sevaModal").modal();
		 $('.modal-body').html("");
		 $('.modal-body').append("<label>DATE:</label> " + "<?=date('d-m-Y'); ?>" + "<br/>");
		 if($('#name').val())
		 	$('.modal-body').append("<label>NAME:</label> " + $('#name').val() + "<br/>");
		 if($('#phone').val())
		 	$('.modal-body').append("<label>PHONE:</label> " + $('#phone').val() + "<br/>");
		 if($('#smremarks').val())
		 	$('.modal-body').append("<label>Remarks:</label> " + $('#smremarks').val() + "<br/>");
		 if ($('#addrline1').val()) 
			$('.modal-body').append("<label>ADDRESS:</label> " + $('#addrline1').val() +", "+ $('#addrline2').val()+", " + $('#smcity').val() +", " + $('#smstate').val() +", "+ $('#smcountry').val() +", " + $('#smpin').val() +"<br/>");
	}else{
			$("#sevaModal").modal();
			$('.modal-body').html("");
			$('.modal-body').append("<label>DATE:</label> " + "<?=date('d-m-Y'); ?>" + "<br/>");
			if($('#name').val())
			 	$('.modal-body').append("<label>NAME:</label> " + $('#name').val() + "<br/>");
			if($('#phone').val())
			 	$('.modal-body').append("<label>PHONE:</label> " + $('#phone').val() + "<br/>");
			if($('#smremarks').val())
			 	$('.modal-body').append("<label>Remarks:</label> " + $('#smremarks').val() + "<br/>");
			if ($('#addrline1').val()) 
				$('.modal-body').append("<label>ADDRESS:</label> " + $('#addrline1').val() +", "+ $('#addrline2').val()+", " + $('#smcity').val() +", " + $('#smstate').val() +", "+ $('#smcountry').val() +", " + $('#smpin').val() +"<br/>");
	  }
}
	
	function alphaonly(input) {
		var regex=/[^a-z&'" ]/gi;
		input.value=input.value.replace(regex,"");
	}

	document.getElementById('1').style.display = "block";
	$("#20").addClass("w5-border-red");

	//INPUT KEYPRESS
	$(':input').on('keypress change', function() {
		var id = this.id;
		try {$('#' + id).css('border-color', "#000000");}catch(e) {}
		
	});


	$('#submit').on('click', function () {
		let count = 0;
		let name = $('#name').val();
		let number = $('#phone').val();
		let number2 = $('#phone2').val();
		let rashi = $('#rashi').val();
		let gotra = $('#gotra').val();
		let nakshatra = $('#nakshatra').val();
		let addrline1 = $('#addrline1').val();
		let addrline2 = $('#addrline2').val();
		let smcity = $('#smcity').val();
		let smstate = $('#smstate').val();
		let smcountry = $('#smcountry').val();
		let smpin = $('#smpin').val();
		let smremarks = $('#smremarks').val();
		//lathesh code
		let receiptLine1 = $('receiptLine1').val()
		


		if (name) {
			$('#name').css('border-color', "#ccc")

		} else {
			$('#name').css('border-color', "#FF0000")
			++count;
		}


		if (count != 0) {
			alert("Information", "Please fill required fields", "OK");
			return false;
		} 
		var shashMinId=$('#shashMinId').val();
		var shashThithiCode=$('#shashThithiCode').val();
		var shashMinSsId=$('#shashMinSsId').val();
		// var smArray ="<?php echo $members;?>";
		let smArray = <?php echo @$selectedMembersSearchItems; ?>; 
		let ssArray = <?php echo @$selectedMembersSearchSsId; ?>; 

		
		let total = 1;
		let url = "<?=site_url()?>Shashwath/shashwathAddlCorpusMergeSave";
		
		$.post(url, {'shashMembId':JSON.stringify(smArray),'shashSsId':JSON.stringify(ssArray),'shashMinId':shashMinId,'shashThithiCode':shashThithiCode, 'shashMinSsId':shashMinSsId,"name": name,"number": number,"number2": number2,"rashi": rashi,"nakshatra": nakshatra,"gotra": gotra, "addrline1": addrline1,"addrline2": addrline2,"smcity": smcity,"smstate": smstate,
			"smcountry": smcountry,"smpin": smpin,"smremarks":smremarks,"receiptLine1":receiptLine1}, function (e) {

				e1 = e.split("|")
				if (e1[0] == "success") {
					let callFrom = $('#call').val();
					window.location.href = "<?=site_url() ?>"+callFrom;
				}
				else
					alert("Something went wrong, Please try again after some time");
			});

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
		document.getElementById('2').style.display = "block";
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

	function validNum(input){
		var regex=/[^0-9 ]/gi;
		input.value=input.value.replace(regex,"");
	}
	$('#smpin').keyup(function (e) {
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

	function goBack(){
		let callFrom = $('#call').val();
		window.location.href = "<?=site_url() ?>"+callFrom;
	}

	function assignMandaliMemberId(i,rcpid){
		let count=0;
		let member1 ="";
		member1 = $('.memberMandaliId_'+i).find(":selected").val();

		if (member1 == 0 ) {
			$('#memberMandaliId_').css('border-color', "#FF0000");
			++count;
		} else {
			$('#memberMandaliId_').css('border-color', "#000000");
		}

		if (count != 0) {
			alert("Information", "Please Select Member", "OK");
			return false;
		}else{
			

			let url = "<?=site_url()?>Shashwath/updateMandaliMemDetails";

			$.post(	url, {"rcpid":rcpid,"mmId":member1}, function (e) {
				e1 = e.split("|")
				if (e1[0] == "success") {
					alert("Information","Additional Corpus Member Paid By Updated","OK");
					window.location.reload();
				}
				else
					alert("Information","Something went wrong, Please try again after some time","OK");
			});
		}
	}
</script>