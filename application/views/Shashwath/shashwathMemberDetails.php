<?php error_reporting(0); ?>
<div style="clear:both;" class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<div class="row form-group">	
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="row form-group">							
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
			<span class="eventsFont2">New Sevadhar</span>
			<a class="pull-right" style="margin-left:5px;" href="<?=site_url()?>Report/deity_mis_report" title="Refresh"><img style="width:24px; height:24px;" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
		</div>
	</div>	
		<div style="clear:both;" class="w5-row"> 
			<?php $i = 1;$j = 20;$name = array('Sevadhar Details','Seva Details');
				for($k =0 ; $k<2 ;$k++) { ?>
					<a href="#" onclick="openCity(event, '<?=$i++;?>');">
						<div id="<?=$j--;?>" class="w5-third tablink w5-bottombar w5-hover-light-grey w5-padding"><?php echo $name[$k];?></div>
					</a>
			<?php } ?>
		</div>
		</br>	
	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			
			<div id="1" class="w5-container city">

				<div class= "col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class= "col-lg-6 col-md-6 col-sm-12 col-xs-9">
						<div class="form-group">
						  <label for="name">Name<span style="color:#800000;">*</span></label>
						  <input type="text" autocomplete="off" class="form-control form_contct2" id="name" placeholder="" name="name"/>
						</div>
					</div>
				
					<div class= "col-lg-6 col-md-6 col-sm-12 col-xs-9">
						<div class="form-group">
						  <label for="number">Number</label>
						  <input type="text" autocomplete="off" class="form-control form_contct2" id="phone" placeholder="" name="phone">
						</div>
					</div>
					<div class= "col-lg-6 col-md-6 col-sm-12 col-xs-9">
						<div class="form-group">
						  <label for="rashi">Rashi</label>
						  <input type="hidden" id="baseurl" name="baseurl" value="<?php echo site_url();?>" />
							<div class="dropdown">
								<input type="text" autocomplete="off" class="form-control form_contct2" id="rashi" placeholder="" name="rashi">
								<ul class="dropdown-menu txtpin" style="margin-left:0px;margin-right:0px;max-height:400px;" role="menu" aria-labelledby="dropdownMenu"  id="DropdownRashi">
								</ul>
							</div>
						</div>
					</div>
				
					<div class= "col-lg-6 col-md-6 col-sm-12 col-xs-9">
						<div class="form-group">
						  <label for="nakshatra">Nakshatra </label>
						  <input type="hidden" id="baseurl" name="baseurl" value="<?php echo site_url(); ?>" />
							<div class="dropdown">
								<input type="text" autocomplete="off" class="form-control form_contct2" id="nakshatra" placeholder="" name="nakshatra">
								<ul class="dropdown-menu txtpin1" style="margin-left:0px;margin-right:0px;max-height:400px;" role="menu" aria-labelledby="dropdownMenu"  id="Dropdownnakshatra">
								</ul>
							</div>
						</div>
					</div></br>
					<div class= "col-lg-6 col-md-6 col-sm-12 col-xs-9">
						<div class="form-group">
						<input type="radio" name="calendar" value="Hindu" style="margin-right: 0"  onchange="calendarHindu();"/> Hindu
						<input type="radio" name="calendar" value="Gregorian"  style="margin-right: 0"  onchange="calendarGregorian();" checked /> Gregorian
						</div>
					</div>
					<div class= "col-lg-12 col-md-12 col-sm-12 col-xs-12" id="HinduCal" hidden>
						<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<select>
									<option value="Paddya">Paddya</option>
									<option value="Bidige">Bidige</option>
									<option value="Thadige">Thadige</option>
									<option value="Chauthi">Chauthi</option>
								</select>
							</div>
						</div>
						<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<select>
									<option value="Chaitra">Chaitra</option>
									<option value="Vaishaka">Vaishaka</option>
									<option value="Jyesta">Jyesta</option>
									<option value="Ashada">Ashada</option>
									<option value="Shravana">Shravana</option>
								</select>
							</div>
						</div>
						<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<select>
									<option value="Shudha">Shudha</option>
									<option value="Bhaula">Bhaula</option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="GregorianCal" >
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="input-group input-group-sm form-group">
							<input id="todayDate" name="todayDate" type="text" value="" class="form-control todayDate3" placeholder="dd-mm-yyyy" readonly = "readonly" onchange="" >
							<div class="input-group-btn">
								<button class="btn btn-default todayDate" type="button">
									<i class="glyphicon glyphicon-calendar"></i>
								</button>
							</div>
						</div>
					</div>
					</div>
				</div>
				<div class= "col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class= "col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-group">
						  <label for="name">Address<span style="color:#800000;">*</span></label>
						  <input type="text" autocomplete="off" class="form-control form_contct2" id="name" placeholder="Addressline1" name="name"/>
						</div>
					</div>
					<div class= "col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-group">
						  <input type="text" autocomplete="off" class="form-control form_contct2" id="name" placeholder="Addressline2" name="name"/>
						</div>
					</div>
					<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="form-group">
						  <input type="text" autocomplete="off" class="form-control form_contct2" id="name" placeholder="City" name="name"/>
						</div>
					</div>
					<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="form-group">
						  <input type="text" autocomplete="off" class="form-control form_contct2" id="name" placeholder="Country" name="name"/>
						</div>
					</div>
					<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="form-group">
						  <input type="text" autocomplete="off" class="form-control form_contct2" id="name" placeholder="Pin Code" name="name"/>
						</div>
					</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="container-fluid">
						<center>
							<button type="button" onClick="" class="btn btn-default btn-lg">Submit</button>
						</center>
					</div>
				</div>
			</div>
			
		</div>
	</div>
		
	<div id="2" class="w5-container city">
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
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<div class="col-lg-7 col-md-12 col-sm-6 col-xs-12">
				<div class="form-group">
					<label for="deityCombo">Deity </label>
					<select onChange="deityComboChange();" id="deityCombo" class="form-control">
						<?php foreach($deity as $result) { ?>
						<option value="<?=$result['DEITY_ID']; ?>">
							<?=$result['DEITY_NAME']; ?>
							</option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-9 col-xs-12">
				<div class="form-group">
					<label for="sevaCombo">Seva </label>
					<select onChange="sevaComboChange();" id="sevaCombo" class="form-control">

					</select>
					
					<label for="sevaAmount" id="revDate" style="display:none;float:right;">
						<span style="color:#800000;">* <span style="font-size: 12px;" id="revRate"></span></span>
					</label>
			
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 deityCol">
			<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
				<div class="form-group">
					<label for="sevaAmount">Seva Amount:
						<br/>
						<span style="font-size: 24px;" id="setPrice"></span>
					</label>
				</div>
			</div>
			<div style="display:none;" class="col-lg-9 col-md-9 col-sm-8 col-xs-12 showAdd">
				<a onClick="addRow()">
					<img style="width:24px; height:24px;" class="img-responsive pull-right" title="Add Seva" src="<?=site_url();?>images/add.svg"
					/>
				</a>
			</div>
			<div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 isSeva1">
				<div style="clear:both;" class="form-group">
					<div class="radio">
						<a onClick="addRow()">
						<img style="width:24px; height:24px" class="img-responsive pull-right" title="Add Seva" src="<?=site_url();?>images/add.svg">
						</a>
					</div>
				</div>
			</div>
		</div>
		<!-- Row -->
	</div>
	<!-- Row -->
</div>
<div style="clear:both;" class="container">
	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<label for="sevaAmount">Selected Seva Dates:
					<span style="font-size: 15px;" id="selDate"></span>
				</label>
			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="table-responsive">
					<table id="eventSeva" class="table table-bordered">
						<thead>
							<tr>
								<th>Sl. No.</th>
								<th>Deity Name.</th>
								<th>Seva Name</th>
								<th>Period</th>
								<th style="width:50px;">Remove</th>
							</tr>
						</thead>
						<tbody id="eventUpdate">
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="row form-group">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label class="pull-right" for="sevaAmount">Total Amount:
						<span id="totalAmount">0</span>
					</label>
				</div>
			</div>
		</div>
		
	</div>
</div>

<div class="container">
	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-8">
				<div class="form-group">
					<label><input style="margin-right: 6px;" onClick="hidePostageAmt(this);" type="checkbox" name="postage" id="postage" value="1">Postage</label>
					<div class="form-group">
						<input style="width:50%;visibility:hidden;" type="text" style="display:hidden;" class="form-control form_contct2" id="postageAmt" placeholder="Amount" name="postageAmt"/>
					</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:0px;">
					<input type="text" class="form-control form_contct2" id="addLine1" placeholder="Address Line1" name="addLine1"/><br>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:0px;">
					<input type="text" class="form-control form_contct2" id="addLine2" placeholder="Address Line2" name="addLine2"/><br>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding:0px;">
					<input type="text" class="form-control form_contct2" id="city" placeholder="City" name="city"/><br>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding-left:5px;padding-right:5px;">
					<input type="text" class="form-control form_contct2" id="country" placeholder="Country" name="country"/><br>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding:0px;">
					<input type="text" class="form-control form_contct2" id="pincode" placeholder="Pincode" name="pincode"/><br>
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
							</select>
						</div>
		
						<div style="padding-top: 15px; display:none;margin-left: -14px;" id="showChequeList">
							<div class="form-group col-xs-10">
								<label for="name">Cheque No:
									<span style="color:#800000;">*</span>
								</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="text" class="form-control form_contct2" id="chequeNo" placeholder="" name="chequeNo">
							</div>
		
							<div style="padding-top: 15px;" class="form-group col-xs-10">
								<label for="rashi">Cheque Date:
									<span style="color:#800000;">*</span>
								</label>&nbsp;&nbsp;
								<div class="input-group input-group-sm">
									<input id="chequeDate" type="text" value="<?=date(" d-m-Y ")?>" class="form-control chequeDate2 form_contct2" placeholder="dd-mm-yyyy">
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
								<input type="text" class="form-control form_contct2" id="bank" placeholder="" name="bank">
							</div>
		
							<div style="padding-top: 15px;" class="form-group col-xs-12">
								<label for="nakshatra">Branch Name:
									<span style="color:#800000;">*</span>
								</label>&nbsp;&nbsp;
								<input type="text" class="form-control form_contct2" id="branch" placeholder="" name="branch">
							</div>
						</div>
		
						<div style="padding-top: 15px; display:none;margin-left: -14px;" id="showDebitCredit">
							<div class="form-group col-xs-10">
								<label for="name">Transaction Id:
									<span style="color:#800000;">*</span>
								</label>&nbsp;&nbsp;
								<input type="text" class="form-control form_contct2" id="transactionId" placeholder="" name="transactionId">
							</div>
						</div>
				<div class="form-group">
					<label for="comment">Payment Notes: </label>
					<textarea class="form-control" rows="5" id="paymentNotes"></textarea>
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
</div>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Deity Seva Preview</h4>
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
<input type="hidden" id="radioOpt" value="multiDateRadio" />
<!-- single Date -->
<div class="container">
	<center>
		<button type="button" onClick="validateSubmit();" class="btn btn-default btn-lg">
			<span class="glyphicon glyphicon-print"></span> Submit & Print</button>
	</center>
</div>
	
		</div>
		
	</div>
</div>
<script src="<?=site_url()?>js/autoComplete.js"></script>

<script>
	//INPUT KEYPRESS
	$(':input').on('keypress change', function() {
		var id = this.id;
		try {$('#' + id).css('border-color', "#000000");}catch(e) {}
		
	});

	function hidePostageAmt(ths) {
		let postageAmt = document.getElementById('postageAmt');
		if(ths.checked) {
			postageAmt.style.visibility='visible';
			postageAmt.value='';
		} else {
			postageAmt.style.visibility='hidden';
			postageAmt.value='';
		}
	}

	var arr = arr || {};
	var bgNo = 1;
	var everySelectedOption = "Day";
	var between = [];
	var seva_date = "";
	var date_type = "";

	$('#multiDateRadio').click();

	$('#modeOfPayment').on('change', function () {
		if (this.value == "Cheque") {
			$('#showChequeList').fadeIn("slow");
			$('#showDebitCredit').fadeOut("slow");
		}
		else if (this.value == "Credit / Debit Card") {
			$('#showChequeList').fadeOut("slow");
			$('#showDebitCredit').fadeIn("slow");
		}
		else {
			$('#showChequeList').fadeOut("slow");
			$('#showDebitCredit').fadeOut("slow");
		}

	});
	
	function resetDates() {
		if(($('#multiDate').val()).trim().length == 0) {
			$('#multiDate').multiDatesPicker('resetDates');
			$('#multiDate').trigger("click")
		}
	}

	$('#submit').on('click', function () {
		let count = 0;
		let number = $('#phone').val()
		let name = $('#name').val()
		let rashi = $('#rashi').val()
		let nakshatra = $('#nakshatra').val()
		let paymentNotes = $('#paymentNotes').val();
		let chequeNo = "";
		let bank = "";
		let chequeDate = "";
		let branch = "";
		let tableContent = getTableValues();
		let modeOfPayment = $('#modeOfPayment option:selected').val();
		let transactionId = $('#transactionId').val();
		let postage = 0;
		let postageAmt = 0;
		if(document.getElementById("postage").checked == true) {
			postage = 1;
			postageAmt = $('#postageAmt').val();
		} else {
			postage = 0;
			postageAmt = 0;
		}
		
		let addressLine1 = $('#addLine1').val();
		let addressLine2 = $('#addLine2').val();
		let city = $('#city').val();
		let country = $('#country').val();
		let pincode = $('#pincode').val();
		
		if (tableContent['sevaName'].length == 0) {
			alert("Information", "Add atleast one seva to submit.");
			return;
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
			if (transactionId) {
				$('#transactionId').css('border-color', "#800000");
			} else {
				$('#transactionId').css('border-color', "#FF0000");
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

		let sevaName = [];
		let address = $('#address').val();
		let qty = [];
		let date = [];
		let price = [];
		let amt = [];
		let sevaId = [];
		let userId = [];
		let quantityChecker = [];
		let deityId = [];
		let deityName = [];
		let isSeva = [];
		let revFlag = [];
		let total = $('#totalAmount').html().trim();
		let url = "<?=site_url()?>Receipt/generateDeityReceipt";

		for (let i = 0; i < tableContent['sevaName'].length; ++i) {
			sevaName[i] = tableContent['sevaName'][i].innerHTML.trim();
			isSeva[i] = tableContent['isSeva'][i].innerHTML.trim();
			deityName[i] = tableContent['deityName'][i].innerHTML.trim();
			qty[i] = tableContent['qty'][i].innerHTML.trim();
			date[i] = tableContent['date'][i].innerHTML.trim();
			price[i] = tableContent['price'][i].innerHTML.trim();
			amt[i] = tableContent['amt'][i].innerHTML.trim();
			sevaId[i] = tableContent['sevaId'][i].innerHTML.trim();
			userId[i] = tableContent['userId'][i].innerHTML.trim();
			quantityChecker[i] = tableContent['quantityChecker'][i].innerHTML.trim();
			deityId[i] = tableContent['deityId'][i].innerHTML.trim();
			revFlag[i] = tableContent['revFlag'][i].innerHTML.trim();
		}
		
		$.post(url, { 'transactionId': transactionId, 'chequeNo': chequeNo, 'branch': branch, 'bank': bank, 'chequeDate': chequeDate, 'modeOfPayment': modeOfPayment, 'sevaName': JSON.stringify(sevaName), 'deityName': JSON.stringify(deityName), 'qty': JSON.stringify(qty), 'date': JSON.stringify(date), 'price': JSON.stringify(price), 'amt': JSON.stringify(amt), 'sevaId': JSON.stringify(sevaId), 'userId': JSON.stringify(userId), 'quantityChecker': JSON.stringify(quantityChecker), 'revFlag': JSON.stringify(revFlag), 'deityId': JSON.stringify(deityId), 'isSeva': JSON.stringify(isSeva), 'total': total, 'name': name, 'number': number, 'rashi': rashi, 'nakshatra': nakshatra, 'paymentNotes': paymentNotes, 'date_type': date_type, 'postage': postage, 'postageAmt': postageAmt, 'addressLine1': addressLine1, 'addressLine2': addressLine2, 'city': city, 'country': country, 'pincode': pincode,'address':address }, function (e) {

			e1 = e.split("|")
			if (e1[0] == "success")
				location.href = "<?=site_url();?>Receipt/printDeityReceipt";
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

	function validateSubmit() {
		//TO CHECK FOR TIME ALLOWED TO ENTER
		var startTime = "<?php echo $_SESSION['time'][0]->TIME_FROM; ?>";
		var endTime = "<?php echo $_SESSION['time'][0]->TIME_TO; ?>";
		var now = new Date();

		var startDate = dateObj(startTime); // get date objects
		var endDate = dateObj(endTime);

		var open = now < endDate && now > startDate ? true : false; // compare
		if (open) {
			alert("Information", "You are not allowed to book sevas till " + endTime);
			return false;
		}
		//TO CHECK FOR TIME ALLOWED TO ENTER ENDS HERE

		let count = 0;
		let number = $('#phone').val()
		let name = $('#name').val()
		let rashi = $('#rashi').val()
		let nakshatra = $('#nakshatra').val()
		let paymentNotes = $('#paymentNotes').val();
		let chequeNo = "";
		let bank = "";
		let chequeDate = "";
		let branch = "";
		let tableContent = getTableValues();
		let modeOfPayment = $('#modeOfPayment option:selected').val();
		let transactionId = $('#transactionId').val();

		
		if ($('#qty').val() > 50) {
			alert("Information", "Please add quantity less than 50");
			return;
		}
		
		if (tableContent['sevaName'].length == 0) {
			alert("Information", "Add atleast one seva to submit.");
			return;
		}

		$("#address").val("");
		let ths = document.getElementById('postage');
		let postageAmt = $('#postageAmt'); 
		let addLine1 = $('#addLine1'); 
		let addLine2 = $('#addLine2'); 
		let city = $('#city');
		let country = $('#country');
		let pincode = $('#pincode');
		let address = "";
		if(ths.checked) {
			if(postageAmt.val().trim().length > 0) {
				postageAmt.css('border-color', "#800000");
			} else {
				postageAmt.css('border-color', "#FF0000");
				count++;
			}
			
			if(addLine1.val().trim().length > 0) {
				address += addLine1.val() + ", ";
				addLine1.css('border-color', "#800000");
			} else {
				addLine1.css('border-color', "#FF0000");
				count++;
			}
			
			if(addLine2.val().trim().length > 0) {
				address += addLine2.val() + ", ";
			}
			
			if(city.val().trim().length > 0) {
				address += city.val() + ", ";
				city.css('border-color', "#800000");
			} else {
				city.css('border-color', "#FF0000");
				count++;
			}
			
			if(country.val().trim().length > 0) {
				address += country.val() + ", ";
				country.css('border-color', "#800000");
			} else {
				country.css('border-color', "#FF0000");
				count++;
			}
			
			if(pincode.val().trim().length > 0) {
				address += pincode.val();
				pincode.css('border-color', "#800000");
			} else {
				pincode.css('border-color', "#FF0000");
				count++;
			}
			
			//address =  + ", " + addLine2.val() + ", " + city.val() + ", " + country.val() + ", " + pincode.val();
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
			
			if(country.val().trim().length > 0) {
				address += country.val() + ", ";
				
			}
			
			if(pincode.val().trim().length > 0) {
				address += pincode.val();
			}
			$('#address').val(address);
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
			if (transactionId) {
				$('#transactionId').css('border-color', "#800000");
			} else {
				$('#transactionId').css('border-color', "#FF0000");
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

		let sevaName = [];
		let qty = [];
		let date = [];
		let price = [];
		let amt = [];
		let sevaId = [];
		let userId = [];
		let quantityChecker = [];
		let deityId = [];
		let deityName = [];
		let isSeva = [];
		let total = $('#totalAmount').html().trim();
		let url = "<?=site_url()?>Receipt/generateDeityReceipt";

		$('#eventUpdate2').html("");

		$('.modal-body').html('<div class="table-responsive"><table class="table table-bordered"><thead><tr><th><center>Sl. No.</center></th><th>Deity Name</th><th>Seva Name</th><th><center>Qty</center></th><th><center>Seva Date</center></th><th><center>Seva Amount</center></th></tr></thead><tbody id="eventUpdate2"></tbody></table></div>')

		for (i = 0; i < tableContent['sevaName'].length; ++i) {
			$('#eventUpdate2').append("<tr>");
			$('#eventUpdate2').append("<td><center>" + tableContent['si'][i].innerHTML + "</center></td>");
			$('#eventUpdate2').append("<td>" + tableContent['deityName'][i].innerHTML + "</td>");
			$('#eventUpdate2').append("<td>" + tableContent['sevaName'][i].innerHTML + "</td>");
			$('#eventUpdate2').append("<td><center>" + tableContent['qty'][i].innerHTML + "</center></td>");
			$('#eventUpdate2').append("<td><center>" + tableContent['date'][i].innerHTML + "</center></td>");
			$('#eventUpdate2').append("<td><center>" + tableContent['price'][i].innerHTML + "</center></td>");
			$('#eventUpdate2').append("</tr><br/>");
		}

		$('.modal-body').append("<label>DATE:</label> " + "<?=date('d-m-Y'); ?>" + "<br/>");
		$('.modal-body').append("<label>NAME:</label> " + name + "");
		if (number)
			$('.modal-body').append(",&nbsp;&nbsp;<label>NUMBER:</label> " + number + "");

		if (rashi)
			$('.modal-body').append(",&nbsp;&nbsp;<label>RASHI:</label> " + rashi + "");
		if (nakshatra)
			$('.modal-body').append(",&nbsp;&nbsp;<label>NAKSHATRA:</label> " + nakshatra + "");

		$('.modal-body').append("<br/>");
		
		if(address)
			$('.modal-body').append("<label>ADDRESS:</label> "+ address +"<br/>");
		
		$('.modal-body').append("<label>TOTAL SEVA AMOUNT:</label> " + total + "<br/>");
		if(ths.checked) {
			if(postageAmt.val().trim().length > 0) {
				$('.modal-body').append("<label>POSTAGE AMOUNT:</label> " + postageAmt.val() + "<br/>");
			}
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

		$('.modal').modal();
		$('.bs-example-modal-lg').focus();
	}

	function deityComboChange() {
		bgNo = $('#deityCombo').val();
		$('#sevaCombo').html("");
		for (let i = 0; i < arr.length; ++i) {
			if (arr[i]['DEITY_ID'] == bgNo)
				if(arr[i]['REVISION_STATUS'] == 1)
					$('#sevaCombo').append('<option value="' + arr[i]['DEITY_ID'] + "|" + arr[i]['SEVA_ID'] + "|" + arr[i]['SEVA_NAME'] + "|" + arr[i]['USER_ID'] + "|" + arr[i]['SEVA_PRICE'] + "|" + arr[i]['QUANTITY_CHECKER'] + "|" + arr[i]['IS_SEVA'] + "|" + arr[i]['OLD_PRICE'] + "|" + arr[i]['REVISION_STATUS'] + "|" + arr[i]['REVISION_DATE'] + '">' + arr[i]['SEVA_NAME'] + " = &#8377; " + arr[i]['OLD_PRICE'] + '</option>');
				else
					$('#sevaCombo').append('<option value="' + arr[i]['DEITY_ID'] + "|" + arr[i]['SEVA_ID'] + "|" + arr[i]['SEVA_NAME'] + "|" + arr[i]['USER_ID'] + "|" + arr[i]['SEVA_PRICE'] + "|" + arr[i]['QUANTITY_CHECKER'] + "|" + arr[i]['IS_SEVA'] + "|" + arr[i]['OLD_PRICE'] + "|" + arr[i]['REVISION_STATUS'] + "|" + arr[i]['REVISION_DATE'] + '">' + arr[i]['SEVA_NAME'] + " = &#8377; " + arr[i]['SEVA_PRICE'] + '</option>');
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
				$('#sevaCombo').append('<option value="' + arr[i]['DEITY_ID'] + "|" + arr[i]['SEVA_ID'] + "|" + arr[i]['SEVA_NAME'] + "|" + arr[i]['USER_ID'] + "|" + arr[i]['SEVA_PRICE'] + "|" + arr[i]['QUANTITY_CHECKER'] + "|" + arr[i]['IS_SEVA'] + '">' + arr[i]['SEVA_NAME'] + " = &#8377; " + arr[i]['SEVA_PRICE'] + '</option>');
		}

		let sevaCombo = getSevaCombo();
		
		$('#setPrice').html(sevaCombo.sevaPrice);
		
		if ($('#radioOpt').val() != "EveryRadio") {
			if (sevaCombo.quantityChecker == "1") {
				$('.qtyOpt').fadeIn("slow");
			} else {
				$('.qtyOpt').hide();
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
		$('.qtyOpt').hide();
		$('#multiDate').css('border-color', "#ccc");
		$('#fromDate').css('border-color', "#ccc");
		$('#toDate').css('border-color', "#ccc");
		$('#qty').css('border-color', "#800000");
		$('#qty').val(1);
		$('#radioOpt').val("EveryRadio");
		$('#fromDate').datepicker('setDate', null);
		$('#toDate').datepicker('setDate', null);
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
		$('#qty').css('border-color', "#800000");
		$('#selDate').html("");
		let sevaCombo = getSevaCombo();
		if (sevaCombo.isSeva == "0") {
			$('.isSeva1').hide();
			$('.showAdd').show();
		} else {
			$('.isSeva1').fadeIn("slow");
			$('.showAdd').hide();
		}
		$('.qtyOpt').fadeIn("slow");
		$('.everyDay').hide();
		$('#fromDate').val("");
		$('#qty').val(1);
		$('#toDate').val("");
		$('.EveryRadio').hide();
		$('#radioOpt').val("multiDateRadio");
		everySelectedOption = "Day"
		$('#fromDate').datepicker('setDate', null);
		$('#toDate').datepicker('setDate', null);
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
				$('.qtyOpt').fadeIn("slow");
			} else {
				$('.qtyOpt').hide();
			}
		} else {

		}
		
		if(sevaCombo.revision_status == 1) {
			$('#setPrice').html(sevaCombo.old_price);
			let newDate = new Date(((sevaCombo.revision_date).toString().split("-").reverse()))
			// newDate.setDate(newDate.getDate()-1);
			// console.log(newDate.getYear())
			$('#revRate').html("Revision Rate: &#8377; "+ sevaCombo.sevaPrice + " from " +((newDate.getDate()<10)?"0"+newDate.getDate():newDate.getDate())+ "-"+(((newDate.getMonth()+1)<10)?"0"+(newDate.getMonth()+1):(newDate.getMonth()+1))+ "-"+newDate.getFullYear())
			$('#revDate').css("display","inline")
		}
		else {
			$('#setPrice').html(sevaCombo.sevaPrice);
			$('#revDate').css("display","none")
		}
		

		if ($('#radioOpt').val() != "EveryRadio") {
			if (sevaCombo.quantityChecker == "1") {
				$('.qtyOpt').fadeIn("slow");
			} else {
				$('.qtyOpt').hide();
			}
		} else {

		}
	}

	var currentTime = new Date()
	var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
	var maxDate = new Date(currentTime.getFullYear(), currentTime.getMonth() + 12, +0); // one day before next month

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
	let rashi = $('#rashi').val()
	let nakshatra = $('#nakshatra').val();
	let sevaCombo1 = getSevaCombo();
	let sevaCombo = $('#sevaCombo option:selected').html();
	let sevaName = sevaCombo1.sevaName;
	let isSeva = sevaCombo1.isSeva;
	let sevaPrice = Number($('#setPrice').html());
	let deityId = sevaCombo1.deityId;
	let userId = sevaCombo1.userId;
	let sevaId = sevaCombo1.sevaId;
	let quantityChecker = sevaCombo1.quantityChecker;
	let deityCombo = $('#deityCombo option:selected').html().trim();
	let setPrice = Number($('#setPrice').html())
	let date = "";
	let count = 0;
	let revisionStatus = sevaCombo1.revision_status
	let revision_date = sevaCombo1.revision_date
	let revision_price = sevaCombo1.sevaPrice;
	let oldPrice = sevaCombo1.old_price
	let revFlag = 0;
		
		date = $("#multiDate").val();

		date2 = date.split(",");
		
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
		
		let qty = date2.length;

		if (qty <= 0)
			qty = 1;

		if ($('#radioOpt').val() != "EveryRadio") {
			if (sevaCombo1.quantityChecker == "1") {
				$('.qtyOpt').fadeIn("slow");

				qty = $('#qty').val();

				if (qty) {
					$('#qty').css('border-color', "#800000");
				} else {
					$('#qty').css('border-color', "#FF0000");
					++count;
				}

				if (sevaCombo1.isSeva == "0") {
					$('.isSeva1').hide();
					$('.showAdd').show();
				} else {
					$('.isSeva1').fadeIn("slow");
					$('.showAdd').hide();
					
					if (date) {
						$('#multiDate').css('border-color', "#ccc");
					} else {
						$('#multiDate').css('border-color', "#FF0000");
						++count;
					}
				}


			} else {
				$('.qtyOpt').hide();
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
		} else {
			if (between.length != 0) {
				$('#fromDate').css('border-color', "#ccc");
				$('#toDate').css('border-color', "#ccc");
			} else {
				$('#fromDate').css('border-color', "#FF0000");
				$('#toDate').css('border-color', "#FF0000");
				++count;
			}
		}

		if (count != 0) {
			alert("Information", "Please fill required fields", "OK");
			return;
		}

		let si = $('#eventSeva tr:last-child td:first-child').html();
		if (!si)
			si = 1
		else
			++si;

		let amt = 0;

		if (everySelectedOption == "Week") {
			date_type = "Every " + $('#selWeek').val()
		} else if (everySelectedOption == "Month") {
			// let mnth = getSuffix(Number($('#selMonth').val()))
			let mnth = getSuffix(Number($('#selMonth').val()))
			date_type = mnth + " of Every Month";
		} else if (everySelectedOption == "Day" && $('#radioOpt').val() != "multiDateRadio") {
			date_type = "Everyday ";
		} else {
			date_type = "";
		}
		
		$('#fromDate').val("");
		$('#toDate').val("");
		$('#multiDate').val("");
		$('#selDate').html("");
		$('#fromDate').datepicker('setDate', null);
		$('#toDate').datepicker('setDate', null);
		$('#multiDate').multiDatesPicker('resetDates');
		
		if (between.length == 0 && $('#radioOpt').val() != "EveryRadio") {
			for (let i = 0; i < date2.length; ++i) {
				//Code To Handle Revision Price
				var correctSevaNormalPrice = ((revisionStatus == 0)?sevaPrice:((compareSevaDateWithRevisionDate(date2[i].trim(),revision_date.trim()))?revision_price:sevaPrice));

				amt = correctSevaNormalPrice * qty;

				sevaCombo = sevaCombo.split('=')[0] + "= ₹ " + correctSevaNormalPrice.toString();

				$('#eventSeva').append('<tr class="' + si + ' si1"><td class="si">' + si + '</td><td class="deityName">' + deityCombo + '</td><td class="sevaCombo">' + sevaCombo + '</td><td class="qty">' + qty + '</td><td class="date">' + date2[i] + '</td><td style="display:none;" class="price">' + correctSevaNormalPrice + '</td><td class="amt">' + amt + '</td><td class="link1"><a style="cursor:pointer;" onClick="updateTable(' + si + ');"><img style="width:24px; height:24px;" title="delete" src="<?=base_url()?>images/delete1.svg"></a></td><td style="display:none;" class="sevaName">' + sevaName + '</td><td style="display:none;" class="quantityChecker">' + quantityChecker + '</td><td style="display:none;" class="deityId">' + deityId + '</td><td style="display:none;" class="userId">' + userId + '</td><td style="display:none;" class="sevaId">' + sevaId + '</td><td style="display:none;" class="isSeva">' + isSeva + '</td><td style="display:none;" class="revFlag">' + revFlag + '</td></tr>');
				si++;
				total += amt

			}
			$('#totalAmount').html(total);
		} else if (between.length != 0) {
			for (let i = 0; i < between.length; ++i) {
				//Code To Handle Revision Price
				var correctSevaBetweenPrice = ((revisionStatus == 0)?sevaPrice:((compareSevaDateWithRevisionDate(between[i].trim(),revision_date.trim()))?revision_price:sevaPrice));

				amt = correctSevaBetweenPrice * qty;

				sevaCombo = sevaCombo.split('=')[0] + "= ₹ " + correctSevaBetweenPrice.toString();

				$('#eventSeva').append('<tr class="' + si + ' si1"><td class="si">' + si + '</td><td class="deityName">' + deityCombo + '</td><td class="sevaCombo">' + sevaCombo + '</td><td class="qty">' + qty + '</td><td class="date">' + between[i] + '</td><td style="display:none;" class="price">' + correctSevaBetweenPrice + '</td><td class="amt">' + amt + '</td><td class="link1"><a style="cursor:pointer;" onClick="updateTable(' + si + ');"><img style="width:24px; height:24px;" title="delete" src="<?=base_url()?>images/delete1.svg"></a></td><td style="display:none;" class="sevaName">' + sevaName + '</td><td style="display:none;" class="quantityChecker">' + quantityChecker + '</td><td style="display:none;" class="deityId">' + deityId + '</td><td style="display:none;" class="userId">' + userId + '</td><td style="display:none;" class="sevaId">' + sevaId + '</td><td style="display:none;" class="isSeva">' + isSeva + '</td><td style="display:none;" class="revFlag">' + revFlag + '</td></tr>');
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

	$("#multiDate").multiDatesPicker({
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
				let currentDate = ($('#multiDate').val()).toString().substring(0,10)
				currentDate = currentDate.split("-").reverse();
				
				currentDate = new Date(currentDate)
				
				let newDate = new Date(revision_date.split("-").reverse())
				if(currentDate >= newDate) {
					$('#sevaCombo :selected').html(selVal[0] + " = &#8377; " +sevaCom.sevaPrice)
					$('#setPrice').html(sevaCom.sevaPrice);
					
				} else { $("#setPrice").html(oldPrice); $('#sevaCombo :selected').html(selVal[0] + " = &#8377; " +oldPrice)}
			} else {
				$('#sevaCombo :selected').html(selVal[0] + " = &#8377; " +sevaCom.sevaPrice)
				$('#setPrice').html(sevaCom.sevaPrice);
			}
			$('#selDate').html($('#multiDate').val());
			$('#multiDate').css('border-color', "#ccc");
		}
	});

	function checkDuplicate() {
		let duplicate = 0;
		let qty = $('#qty').val();
		let sevaCombo1 = getSevaCombo();
		let sevaName = sevaCombo1.sevaName;
		let tableValues = getTableValues();
		if (between.length == 0) {
			date = $("#selDate").text();
			date2 = date.split(",");
		}

		for (let j = 0; j < tableValues['sevaName'].length; ++j) {
			if (duplicate != 0)
				break;
			if (between.length == 0) {
				for (let i = 0; i < date2.length; ++i) {
					if (date2[i] == tableValues['date'][j].innerHTML.trim() && sevaName == tableValues['sevaName'][j].innerHTML.trim() && tableValues['deityId'][j].innerHTML.trim() == sevaCombo1.deityId) {
						alert("Information", sevaName + " Already Exists on " + date2[i])
						++duplicate;
						break;
					}
				}
			} else {
				for (let i = 0; i < between.length; ++i) {
					if (between[i] == tableValues['date'][j].innerHTML.trim() && sevaName == tableValues['sevaName'][j].innerHTML.trim() && tableValues['deityId'][j].innerHTML.trim() == sevaCombo1.deityId) {
						alert("Information", sevaName + " Already Exists on " + between[i])
						++duplicate;
						break;
					}
				}
			}
		}
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

	$('#pincode').keyup(function (e) {
		var $th = $(this);
		if (e.keyCode != 46 && e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 38 && e.keyCode != 39 && e.keyCode != 40) {
			$th.val($th.val().replace(/[^0-9]/g, function (str) { return ''; }));
		} return;
	});
	
	$('#postageAmt').keyup(function (e) {
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

	$('#qty').keyup(function (e) {
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

	$("#toDate").datepicker({
		minDate: minDate,
		maxDate: maxDate,
		dateFormat: 'dd-mm-yy'
	});

	function dateRange() {
		var currentTime = new Date()
		var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
		var maxDate = new Date(currentTime.getFullYear(), currentTime.getMonth() + 12, +0); // one day before next month
		$("#toDate").datepicker({
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
		var start = $("#fromDate").datepicker("getDate");
		end = $("#toDate").datepicker("getDate");
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

	$("#fromDate").datepicker({
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
			
			$('#toDate').datepicker('setDate', null);
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
			revision_date: sevaCombo[9]
		}
	}

	function getTableValues() {
		let si1 = document.getElementsByClassName('si1');
		let si = document.getElementsByClassName('si');
		let sevaCombo = document.getElementsByClassName('sevaCombo');
		let qty = document.getElementsByClassName('qty');
		let date = document.getElementsByClassName('date');
		let price = document.getElementsByClassName('price');
		let amt = document.getElementsByClassName('amt');
		let link1 = document.getElementsByClassName('link1');
		let sevaName = document.getElementsByClassName('sevaName');
		let deityName = document.getElementsByClassName('deityName');
		let sevaId = document.getElementsByClassName('sevaId');
		let userId = document.getElementsByClassName('userId');
		let deityId = document.getElementsByClassName('deityId');
		let quantityChecker = document.getElementsByClassName('quantityChecker');
		let isSeva = document.getElementsByClassName('isSeva');
		let revFlag = document.getElementsByClassName("revFlag");
		return {
			si1: si1,
			si: si,
			sevaCombo: sevaCombo,
			sevaName: sevaName,
			qty: qty,
			date: date,
			price: price,
			amt: amt,
			deityName: deityName,
			link1: link1,
			sevaId: sevaId,
			userId: userId,
			deityId: deityId,
			isSeva: isSeva,
			quantityChecker: quantityChecker,
			revFlag: revFlag
		}
	}
</script>

<script>
	function openCity(evt, cityName) {
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
	}
 	function calendarHindu() {
		document.getElementById('HinduCal').style.display = "block";
		document.getElementById('GregorianCal').style.display = "none";
	} 
	function calendarGregorian() {
		document.getElementById('HinduCal').style.display = "none";
		document.getElementById('GregorianCal').style.display = "block";
	} 
		$( ".todayDate3" ).datepicker({ 
		changeMonth: true,
		changeYear: true,
		//minDate: minDate, 
		//maxDate: maxDate,
		dateFormat: 'dd-mm-yy',
		'yearRange': "2007:+50"
	});
	$('.todayDate').on('click', function() {
		$( ".todayDate3" ).focus();
});
</script>