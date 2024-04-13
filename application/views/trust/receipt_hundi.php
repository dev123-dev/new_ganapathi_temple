<form id="formSub" action="<?php echo site_url(); ?>TrustReceipt/receipt_hundi_save" enctype="multipart/form-data" method="post" accept-charset="utf-8">
	<div class="container">
		<img class="img-responsive bgImg2 bg1" src="<?=site_url()?>images/TempleLogo.png" />
		<img class="img-responsive bgImg2 bg2" src="<?=site_url()?>images/LAKSHMI.jpg" style="display:none;"/>
		<img class="img-responsive bgImg2 bg3" src="<?=site_url()?>images/HANUMANTHA.jpg" style="display:none;" />
		<img class="img-responsive bgImg2 bg4" src="<?=site_url()?>images/GARUDA.jpg" style="display:none;"/>
		<img class="img-responsive bgImg2 bg5" src="<?=site_url()?>images/GANAPATHI.jpg" style="display:none;"/>
		<!--Heading And Refresh Button-->
		<div class="row form-group">
			<div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
				<span class="eventsFont2">Hundi Receipt</span>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
				<a style="width:24px; height:24px" class="pull-right img-responsive" href="<?=site_url()?>TrustReceipt/receipt_hundi" title="Reset"><img title="Reset" src="<?=site_url();?>images/refresh.svg"/></a>
			</div>
		</div>
		
		<!--Receipt Date And Receipt Number-->
		<div class="row form-group">
			<div class="col-lg-6 col-md-6 col-sm-5 col-xs-12">
				<span class="eventsFont2">Receipt Date: <?=date("d-m-Y")?></span>
			</div>
			<!--<div class="col-lg-6 col-md-6 col-sm-7 col-xs-12">
				<span class="eventsFont2 pull-right">Receipt Number: SLVT/2017-18/SN/1</span>
			</div>-->
		</div>
		
		<!--Event and Amount-->
		<div class="row form-group">
			<div class="sevaDate">	
				<div style="display:none;" class="form-inline col-lg-4 col-md-3 col-sm-4 col-xs-12">
					<div class="form-group">
						<div class="radio pull-left" style="margin-top: 0.3em;">
						  <label class="radio-inline"><input id="deity_Radio" type="radio" value="" onclick="GetChangeRadio('deity')" name="optradio"> Deity</label>
						</div>&nbsp;
						<select id="deity" name="deity" onChange="deityComboChange();" class="form-control">
							<?php foreach($deity as $result) { ?>
								<option value="<?php echo $result->DEITY_ID ."|". $result->DEITY_NAME ?>"><?php echo $result->DEITY_NAME ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				
				<div class="col-lg-6 col-md-6 col-sm-4 col-xs-4" style="margin-bottom: 1.5em;">
					<label for="number">Event: </label>
					<?php foreach($events as $result) { ?>
						<span class="eventsFont2 samFont"> <?php echo $result->TET_NAME ?></span>
					<?php } ?>
				</div>
				
				<!-- HIDDEN FIELD -->
				<input name="selRadio" id="selRadio" type="hidden">
				<input name="name" id="name" type="hidden">
				
				<div style="visibility:hidden;position:absolute;" class="form-inline col-lg-3 col-md-3 col-sm-4 col-xs-12">
					<div class="form-group">
						<div class="radio pull-left" style="margin-top: 0.3em;">
						  <label class="radio-inline" style="cursor: default;"><input style="visibility:hidden;cursor: default;" id="events_Radio" type="radio" value="" onclick="GetChangeRadio('event')" name="optradio" checked> Event</label>
						</div>&nbsp;
						<select id="event" name="event" class="form-control">
							<?php foreach($events as $result) { ?>
								<option value="<?php echo $result->TET_ID ."|". $result->TET_NAME ?>"><?php echo $result->TET_NAME ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-6 text-left">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;">
					<div class="form-inline">
						<label for="name">Name <span style="color:#800000;">*</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="text" class="form-control form_contct2" id="name1" placeholder="Akash" name="name1" style="width: 70%;">
					</div>
				</div>
				
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;">
					<div class="form-inline">
					  <label for="number">Number </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					  <input type="text" class="form-control form_contct2" id="number" placeholder="9876543210" name="number" style="width: 70%;">
					</div>
				</div>
				
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;">
					<div class="form-inline">
					  <label for="number">Email </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					  <input type="text" class="form-control form_contct2" id="email" placeholder="akash.svrna@gmail.com" name="email" style="width: 70%;">
					</div>
				</div>

				<!-- new code for adhaar and pan start by adithya -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;">
					<div class="form-inline">
					  <label for="pan">Pan No </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					  <input type="text" class="form-control form_contct2" id="pan" placeholder="AFHYT5678Y" name="pan" style="width: 70%;">
					</div>
				</div>
				
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;">
					<div class="form-inline">
					  <label for="adhaar">Adhaar No </label>&nbsp;
					  <input type="text" class="form-control form_contct2" id="adhaar" placeholder="987456321234" name="adhaar" style="width: 70%;">
					</div>
				</div>
<!-- new code for adhaar and pan end by adithya -->


				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;">
					<div class="form-inline">
						<!-- <label><input style="margin-right: 6px;" id="postage" name="postage" onClick="hidePostageAmt(this);" type="checkbox" value="1">Postage</label>
						<input style="width:50%;visibility:hidden;" type="text" style="display:hidden;" value='0' class="form-control form_contct2" id="postageAmt" placeholder="Amount" name="postageAmt"/> -->
					</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<input type="text" class="form-control form_contct2" id="addLine1" placeholder="Address Line1" name="addLine1"><br>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<input type="text" class="form-control form_contct2" id="addLine2" placeholder="Address Line2" name="addLine2"><br>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<input type="text" class="form-control form_contct2" id="city" placeholder="City" name="city"><br>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding-left:5px;padding-right:5px;">
						<input type="text" class="form-control form_contct2" id="country" placeholder="Country" name="country"><br>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<input type="text" class="form-control form_contct2" id="pincode" placeholder="Pincode" name="pincode"><br>
					</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="display:none;margin-bottom: 1.5em;">
					<div class="form-inline">
					  <label for="number">Address </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					  <textarea class="form-control" rows="5" id="address" style="resize:none;" name="address" placeholder="Near Classic Chaya, Santhakatte" style="width: 100%;"></textarea>
					</div>
				</div>
			</div>
			
			
			<div class="col-md-6 text-left">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;">
					<!-- <label for="number">Event: </label>
					<span class="eventsFont2 samFont"> <?=$event['TET_NAME']; ?></span> -->
				</div>
				
				<div class="col-lg-12 col-md-12 col-sm-8 col-xs-12" style="margin-bottom: 1.5em;">
					<div class="form-inline">
					  <label for="number">Amount <span style="color:#800000;">*</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					  <input type="text" class="form-control form_contct2" id="amount" placeholder="" name="amount" style="width: 40%;" onkeyup="checkPriceVal(event)">
					</div>
				</div>
				
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-8" style="margin-bottom: 2em;">
					<div class="form-inline">
					  <label for="modeOfPayment">Mode Of Payment <span style="color:#800000;">*</span></label>
					  <select id="modeOfPayment" name="modeOfPayment" class="form-control">
						<option value="">Select Payment Mode</option>
						<option value="Cash">Cash</option>
						<option value="Cheque">Cheque</option>
						<option value="Direct Credit">Direct Credit</option>
						<option value="Credit / Debit Card">Credit / Debit Card</option>
					  </select>
					</div>
				</div>
				
				<div style="display:none" id="showChequeList">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-8" style="margin-bottom: 2em;">
						<div class="form-inline">
							<label for="name">Cheque No: <span style="color:#800000;">*</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="text" class="form-control form_contct2" id="chequeNo" placeholder="" name="chequeNo">
						</div>
					</div>
						
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-8" style="margin-bottom: 2em;">
						<div class="form-inline">
							<label for="rashi">Cheque Date: <span style="color:#800000;">*</span></label>&nbsp;&nbsp;
							<div class="input-group input-group-sm">
								<input id="chequeDate" name="chequeDate" type="text" value="" class="form-control chequeDate2 form_contct2" placeholder="dd-mm-yyyy">
								<div class="input-group-btn">
								  <button class="btn btn-default chequeDate" type="button">
									<i class="glyphicon glyphicon-calendar"></i>
								  </button>
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-10" style="margin-bottom: 2em;">
						<div class="form-inline">
						  <label for="number">Bank Name: <span style="color:#800000;">*</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						  <input type="text" class="form-control form_contct2" id="bank" placeholder="" name="bank">
						</div>
					</div>
					
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-10" style="margin-bottom: 2em;">
						<div class="form-inline">
						  <label for="nakshatra">Branch Name: <span style="color:#800000;">*</span></label>&nbsp;&nbsp;
						  <input type="text" class="form-control form_contct2" id="branch" placeholder="" name="branch">
						</div>
					</div>
				</div>
				
			<!-- ADDED BY ADITHYA ON 5-1-24 -->
				<div style="display:none;" id="showDebitCredit">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-10" style="margin-bottom: 2em;">
						<div class="form-inline col-xs-12" style="margin-left: -14px;margin-bottom: 1em;">
							<label for="bank">To Bank <span style="color:#800000;">*</span></label>&nbsp;&nbsp;
							<select id="DCtobank" name="DCtobank" class="form-control">
							<option value="0">Select Bank</option>
							<?php foreach($terminal as $result) { ?>
								<option value="<?=$result->T_FGLH_ID; ?>">
									<?=$result->T_FGLH_NAME; ?>
								</option>
								<?php } ?>
							</select>
						</div>
						<div class="form-inline">
							<label for="name">Transaction Id: <span style="color:#800000;">*</span></label>&nbsp;&nbsp;
							<input type="text" class="form-control form_contct2" id="transactionId" placeholder="" name="transactionId">
						</div>
					</div>
				</div>
				<!-- ADDED BY ADITHYA ON 5-1-24 ..-->
					<!-- SLAP -->
				<!-- ADDED BY ADITHYA ON 5-1-24 -->
				<div style="padding-top: 15px; display:none ;" id="showDirectCredit">
					<div class="form-group col-xs-10">
						<label for="bank">To Bank <span style="color:#800000;">*</span></label>&nbsp;&nbsp;
						<select id="tobank" name="tobank" class="form-control">
						<option value="0">Select Bank</option>
						<?php foreach($bank as $result) { ?>
							<option value="<?=$result->T_FGLH_ID; ?>">
								<?=$result->T_FGLH_NAME; ?>
							</option>
							<?php } ?>
					</select>
					</div>
				</div>
				<!-- ADDED BY ADITHYA ON 5-1-24.. -->
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;">
					<div class="form-group">
					  <label for="comment">Payment Notes:</label>
					  <textarea class="form-control" rows="5" style="resize:none;" id="paymentNotes" name="paymentNotes"></textarea>
					</div>
				</div>
				
				<div class="row form-group" style="margin-left:.3em;">
					<div class="control-group col-md-12 col-lg-12 col-sm-12 col-xs-12">
						<label class="control-label" style="color:#800000;font-size: 12px;"><i>* Indicates mandatory fields.</i></label>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Event Hundi Preview</h4>
			</div>
			<div class="modal-body" id="creditdet" style="overflow-y: auto;max-height: 80vmin;">
				
			</div>
			
			<div class="modal-footer text-left" style="text-align:left;">
				<label>Are you sure you want to save..?</label><br/>
				<button style="width: 8%;" type="button" class="btn btn-default sevaButton" id="submit2">Yes</button>
				<button style="width: 8%;" type="button" class="btn btn-default sevaButton" data-dismiss="modal">No</button>
			</div>
		</div>
	  </div>
	</div>
	<div class="container">
		<div class="row form-group pull-right">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<button type="button" onClick="checkConfirmTime('<?php echo date('d-m-Y');?>');" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-print"></span> Submit & Print</button>
			</div>
		</div>
	</div>
</form>
<script>
	$('#submit2').on('click', function() {
		$('#formSub').submit();
	})
	
	//CHANGE IMAGE ON COMBOBOX
	var arr = arr || {};
	var bgNo = 1;
	
	function deityComboChange() {
		arrDeity = ($('#deity').val()).split('|');
		bgNo = arrDeity[0];
		
		for(i = 1; i <= 5; ++i)
			if(i == bgNo)
				$('.bg'+i).slideDown();
			else
				$('.bg'+i).slideUp();
	}

	//COMPARING DATES
	function dateObj(d) { // date parser ...
		var parts = d.split(/:|\s/),
			date  = new Date();
		if (parts.pop().toLowerCase() == 'pm') {
			parts[0] = ((+parts[0]) + 12).toString();
		}
		date.setHours(+parts.shift());
		date.setMinutes(+parts.shift());
		return date;
	}
	
	
	function checkConfirmTime(date) {
		$.ajax({
            type: "POST",
            url: "<?php echo base_url();?>TrustEvents/check_event_eod_confirm_date_time",
            success: function (response) {
				if(response == 0){
					field_validation();
				} else {
					alert("Information","The EOD for " +date+ " already generated");
				}
			}
        }); 
	}
	<!-- Validating Fields -->
	function field_validation() {
		//TO CHECK FOR TIME ALLOWED TO ENTER
		var startTime = "<?php echo $_SESSION['time'][0]->TIME_FROM; ?>";
		var endTime   = "<?php echo $_SESSION['time'][0]->TIME_TO; ?>";
		var now       = new Date();

		var startDate = dateObj(startTime); // get date objects
		var endDate   = dateObj(endTime);

		var open = now < endDate && now > startDate ? true : false; // compare
		if(open) {
			alert("Information","You are not allowed to book sevas till " + endTime);
			return false;
		} 
		//TO CHECK FOR TIME ALLOWED TO ENTER ENDS HERE
		
		var count = 0;
		
		let amount = document.getElementById("amount").value
		let deity = $('#deity option:selected').html();
		let event = $('#event option:selected').html();
		let modeOfPayment = $('#modeOfPayment option:selected').val(); 
		let toBank = $('#tobank option:selected').val();												//adithya removed comment
		let DCtoBank = $('#DCtobank option:selected').val();											//adithya removed comment
  
		let name = document.getElementById("name1").value
		let number = document.getElementById("number").value
		let email = document.getElementById("email").value
		let pan = $('#pan').val();
		let adhaar =$('#adhaar').val();
		let address = $('#address').val();

		let paymentNotes = $('#paymentNotes').val();
		let chequeNo = $('#chequeNo').val();<!--4-->
		let chequeDate = $('#chequeDate').val();<!--4-->
		let bank = $('#bank').val();<!--4-->
		let branch = $('#branch').val();<!--4-->
		let transactionId = $('#transactionId').val();<!--4-->
		

		if (document.getElementById("name1").value != "") {
			$('#name1').css('border-color', "#000000");
		} else {
			$('#name1').css('border-color', "#FF0000");
			++count;
		}

		if(amount >= 10000 && pan == ""){
			
			$('#pan').css('border-color', "#FF0000");
			++count;
		}else{
			$('#pan').css('border-color', "#000000");
		}
		



		<!--$('input[type=text]').each(function(){-->
			<!--var id = this.id;-->
			<!--if($('#' + id).val() != "") {-->
			<!--$('#' + id).css('border-color', "#000000");-->
			<!--} else {-->
			<!--$('#' + id).css('border-color', "#FF0000");-->
			<!--++count;-->
			<!--}-->
			<!--});-->
			
		<!--7777-->
		if($('#amount').val() != "") {
			$('#amount').css('border-color', "#000000");
		} else {
			$('#amount').css('border-color', "#FF0000");
			++count;
		}
		<!--7777-->		
		
		$('select').each(function(){
			var id = this.id;
			if($('#' + id).val() != "") {
				$('#' + id).css('border-color', "#000000");
			} else {
				$('#' + id).css('border-color', "#FF0000");
				++count;
			}
		});
		
		<!--11111-->
		$('select').each(function(){
			var id = this.id;
			if($('#' + id).val() != "") {
				$('#' + id).css('border-color', "#000000");
				if($('#' + id).val() == "Cheque") {
					if (document.getElementById("chequeNo").value.length == 6) {
						$('#chequeNo').css('border-color', "#000000");
					} else {
						$('#chequeNo').css('border-color', "#FF0000");
						++count;
					}
					
					if (document.getElementById("chequeDate").value != "") {
						$('#chequeDate').css('border-color', "#000000");
					} else {
						$('#chequeDate').css('border-color', "#FF0000");
						++count;
					}
					
					if (document.getElementById("bank").value != "") {
						$('#bank').css('border-color', "#000000");
					} else {
						$('#bank').css('border-color', "#FF0000");
						++count;
					}
					
					if (document.getElementById("branch").value != "") {
						$('#branch').css('border-color', "#000000");
					} else {
						$('#branch').css('border-color', "#FF0000");
						++count;
					}
				} else if($('#' + id).val() == "Credit / Debit Card") {						
					if (DCtoBank != 0) {                                   //uncommented from here till
						$('#DCtobank').css('border-color', "#800000");
					} else {
						$('#DCtobank').css('border-color', "#FF0000");
						++count;
					}                                                      //here
					if (transactionId) {
						$('#transactionId').css('border-color', "#800000");
					} else {
						$('#transactionId').css('border-color', "#FF0000");
						++count;
					}																		//laz new ..
				}
				 else if($('#' + id).val() == "Direct Credit") {							//uncommented from here till
					if (document.getElementById("tobank").value != 0) {
						$('#tobank').css('border-color', "#000000");
					} else {
						$('#tobank').css('border-color', "#FF0000");
						++count;
					}
				}                                                         //here
			} else {
				$('#' + id).css('border-color', "#FF0000");
				++count;
			}
		});


			if (modeOfPayment == "Credit / Debit Card") {							//laz new extra
			if (DCtoBank != 0) {                                                  //uncommented from here till
				$('#DCtobank').css('border-color', "#800000");
			} else {
				$('#DCtobank').css('border-color', "#FF0000");
				++count;
			}                                                                          //here
			if (transactionId) {
				$('#transactionId').css('border-color', "#800000");
			} else {
				$('#transactionId').css('border-color', "#FF0000");
				++count;
			}																		
		} 
		else if (modeOfPayment == "Direct Credit") {									//uncommented from here till
			if (toBank!=0) {
				$('#tobank').css('border-color', "#800000");
			} else {
				$('#tobank').css('border-color', "#FF0000");
				++count;
			}																			
		}                                                                              // here 																		//laz new extra ..
		<!--1111-->
		
		if ((document.getElementById("events_Radio").checked == false) && (document.getElementById("deity_Radio").checked == false)) {
			$('#events_Radio').css('border-color', "#FF0000");
			$('#deity_Radio').css('border-color', "#FF0000");
			++count;
		}	
		
		if(count != 0) {
			alert("Information","Please fill required fields","OK");
			return false;
		} else {
			$('.modal-body').html("<label>DATE:</label> "+ "<?=date('d-m-Y'); ?>" +"<br/>");
			$('.modal-body').append("<label>NAME:</label> "+ name +"<br/>");
			if(number)
				$('.modal-body').append("<label>NUMBER:</label> "+ number +"<br/>");
			
			if(email)
				$('.modal-body').append("<label>EMAIL:</label> "+ email +"<br/>");
			
			if(address)
				$('.modal-body').append("<label>ADDRESS:</label> "+ address +"<br/>");		
			
			$('.modal-body').append("<label>AMOUNT:</label> "+ amount +"<br/>");
			if(pan)
			$('.modal-body').append("<label>Pan No:</label> "+ pan +"<br/>");

			if(adhaar)
			$('.modal-body').append("<label>Adhaar No:</label> "+ adhaar +"<br/>");
			if (document.getElementById("events_Radio").checked == false)
				$('.modal-body').append("<label>DEITY:</label> "+ deity +"<br/>");
			else
				$('.modal-body').append("<label>EVENT:</label> "+ event +"<br/>");
				
			$('.modal-body').append("<label>AMOUNT:</label> "+ amount +"<br/>");
			<!--33333-->
			if(modeOfPayment == "Cheque") {
				$('.modal-body').append("<label>CHEQUE NO:</label> "+ chequeNo +",&nbsp;&nbsp;");
				$('.modal-body').append("<label>CHEQUE DATE:</label> "+ chequeDate +",&nbsp;&nbsp;");
				$('.modal-body').append("<label>BANK:</label> "+ bank +",&nbsp;&nbsp;");
				$('.modal-body').append("<label>BRANCH:</label> "+ branch +"<br/>");
			
			} else if(modeOfPayment == "Credit / Debit Card") {
				$('.modal-body').append("<label>TRANSACTION ID:</label> "+ transactionId +"<br/>");
			}
			<!--3333-->
			if(paymentNotes)
				$('.modal-body').append("<label>PAYMENT NOTES:</label> "+ paymentNotes +"<br/>");

			$('.modal').modal();
			$('.bs-example-modal-lg').focus();
			return false;
		}
	}

	//INPUT KEYPRESS
	$(':input').on('keypress change', function() {
		var id = this.id;
		$('#' + id).css('border-color', "#000000");
	});
	
	//SELECT CHANGE
	$('select').on('change', function() {
		var id = this.id;
		$('#' + id).css('border-color', "#000000");
	});
	
	//SELECT CHANGE
	$('radio').on('change', function() {
		var id = this.id;
		$('#' + id).css('border-color', "#000000");
	});
	
	//Radio Button
	$( document ).ready(function() {
		// document.getElementById("deity").disabled = true;  
		// document.getElementById("event").disabled = true;  
	});
	
	<!-- Amount Validation -->
	$('#amount').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^0-9]/g, function(str) { return ''; } ) );
	});
	
	<!-- Check If Price Is Zero -->
	function checkPriceVal(evt){
		inputLS = evt.currentTarget;
		if($(inputLS).val() && Number($(inputLS).val()) == 0){
			$(inputLS).val("");
		} 			
	}

	$(document).ready(function() {
		document.getElementById("event").disabled = false;
		document.getElementById("deity").disabled = true;  
		$('#events_Radio').css('border-color', "#000000");
		$('#deity_Radio').css('border-color', "#000000");
		document.getElementById("selRadio").value = 2;
	});
	
	//Radio Change
	function GetChangeRadio(selected) {
		if(selected == "deity") {
			document.getElementById("deity").disabled = false;  
			document.getElementById("event").disabled = true;  
			$('#events_Radio').css('border-color', "#000000");
			$('#deity_Radio').css('border-color', "#000000");
			document.getElementById("selRadio").value = 1;
		} else {
			document.getElementById("event").disabled = false;
			document.getElementById("deity").disabled = true;  
			$('#events_Radio').css('border-color', "#000000");
			$('#deity_Radio').css('border-color', "#000000");
			document.getElementById("selRadio").value = 2;
		}
	}
	
	//Payment Combo Box
	$('#modeOfPayment').on('change', function() {
		if(this.value == "Cheque")
			$('#showChequeList').slideDown();
		else
			$('#showChequeList').slideUp();
	})
	
	//Payment Combo Box
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
	
	
	<!--22222-->
	<!-- Cheque Number Validation -->
	$('#chequeNo').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^0-9]/g, function(str) { return ''; } ) );
	});
	
	<!-- Transaction Id Validation -->
	$('#transactionId').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^0-9]/g, function(str) { return ''; } ) );
	});
	<!--22222-->
	
	//Cheque Datefield
	var currentTime = new Date()
	var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
	var maxDate =  new Date(currentTime.getFullYear(), currentTime.getMonth() +12, +0); // one day before next month
	
	$( ".chequeDate2" ).datepicker({
		dateFormat: 'dd-mm-yy'
	});
					
	$('.chequeDate').on('click', function() {
		$( ".chequeDate2" ).focus();
	});
</script>