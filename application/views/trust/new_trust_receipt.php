<form id="formSub" action="<?php echo site_url(); ?>TrustReceipt/save_new_trust_receipt" enctype="multipart/form-data" method="post" accept-charset="utf-8">
	<div class="container">
		<img class="img-responsive bgImg2 bg1" src="<?=site_url()?>images/TempleLogo.png" />
		<img class="img-responsive bgImg2 bg2" src="<?=site_url()?>images/LAKSHMI.jpg" style="display:none;"/>
		<img class="img-responsive bgImg2 bg3" src="<?=site_url()?>images/HANUMANTHA.jpg" style="display:none;" />
		<img class="img-responsive bgImg2 bg4" src="<?=site_url()?>images/GARUDA.jpg" style="display:none;"/>
		<img class="img-responsive bgImg2 bg5" src="<?=site_url()?>images/GANAPATHI.jpg" style="display:none;"/>
		<!--Heading And Refresh Button-->
		<div class="row form-group">
			<div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
				<span class="eventsFont2">Trust Receipt </span>
			</div>
			<br/>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
				<a style="width:24px; height:24px" class="pull-right img-responsive" href="<?=site_url()?>TrustReceipt/new_trust_receipt" title="Reset"><img title="Reset" src="<?=site_url();?>images/refresh.svg" /></a>
			</div>
		</div>
		
		<!--Receipt Date And Receipt Number-->
		<div class="row form-group">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<span class="eventsFont2" style="font-size:16px;">Receipt Date: <?=date("d-m-Y")?></span>
			</div>
			<!--<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<span class="eventsFont2 pull-right">Receipt Number: SLVT/2017-18/SN/1</span>
			</div>-->
		</div>
		
		<div class="row">
			<!--Name, Number, Email and Address-->
			<div class="col-md-6 text-left">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;">
					<div class="form-inline">
						<label for="name">Name <span style="color:#800000;">*</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="text" class="form-control form_contct2" id="name" placeholder="Akash" name="name" style="width: 70%;">
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
					  <label for="number">Address </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					  <textarea class="form-control" rows="5" id="address" name="address" placeholder="Near Classic Chaya, Santhakatte" style="resize:none;width: 100%;"></textarea>
					</div>
				</div>
			</div>
			
			<div class="col-md-6 text-left">
				<!--Event and Amount-->	
				<div class="form-inline col-lg-12 col-md-12 col-sm-12 col-xs-8" style="margin-bottom: 1.5em;">
					<div class="form-group">
						<label for="financialHeads">Financial Heads <span style="color:#800000;">*</span></label>&nbsp;&nbsp;&nbsp;&nbsp;
						<select id="financialHeads" name="financialHeads" class="form-control">
							<option value="">Select Financial Head</option>
							<?php foreach($financialHeads as $result) { ?>
								<option value="<?php echo $result->FH_ID ."|". $result->FH_NAME ?>"><?php echo $result->FH_NAME ?></option>
							<?php } ?>
						  </select>
					</div>
				</div>
				
				<div class="col-lg-12 col-md-12 col-sm-8 col-xs-12" style="margin-bottom: 1.5em;">
					<div class="form-inline">
					  <label for="number">Amount <span style="color:#800000;">*</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					  <input type="text" class="form-control form_contct2" id="amount" placeholder="" name="amount" style="width: 40%;">
					</div>
				</div>
				
				<!--Mode Of Payment, Cheque No, Cheque Date, Bank and Branch and Payment Notes-->
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-8" style="margin-bottom: 1.5em;">
					<div class="form-inline">
					  <label for="modeOfPayment">Mode Of Payment <span style="color:#800000;">*</span></label>&nbsp;&nbsp;&nbsp;&nbsp;
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
				
				<!-- Removed comment by adithya on 08-1-24 -->
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
				<!-- Removed comment by adithya end-->
				
				
					<!-- SLAP -->
				<!-- Removed Comment by adithya on 8-1-24 -->
				<div style="padding-top: 15px; display:none;" id="showDirectCredit">
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
				<!-- comment end -->
				

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;">
					<div class="form-group">
					  <label for="comment">Payment Notes:</label>
					  <textarea class="form-control" rows="5" id="paymentNotes" style="resize:none;" name="paymentNotes"></textarea>
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
				<h4 class="modal-title">Trust Receipt Preview</h4>
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
	<!-- Validating Fields -->
	$('#submit2').on('click', function() {
		$('#formSub').submit();
	})

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
            url: "<?php echo base_url();?>TrustReceipt/check_eod_confirm_date_time",
            success: function (response) {
				if(response == 0){
					field_validation();
				} else {
					alert("Information","The EOD for " +date+ " already generated");
				}
			}
        }); 
	}
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
		
		let name = document.getElementById("name").value
		let number = document.getElementById("number").value
		let email = document.getElementById("email").value
		let amount = document.getElementById("amount").value
		let financialHead = $('#financialHeads option:selected').html();
		let modeOfPayment = $('#modeOfPayment option:selected').val();
		//  let toBank = "";											//laz
		//  let DCtoBank = "";					
		 let toBank = $('#tobank option:selected').val();								//uncommented by adithya
		 let DCtoBank = $('#DCtobank option:selected').val();							//uncommented by adithya
		let paymentNotes = $('#paymentNotes').val();
		let address = $('#address').val();
		let chequeNo = $('#chequeNo').val();
		let chequeDate = $('#chequeDate').val();
		let bank = $('#bank').val();
		let branch = $('#branch').val();
		let transactionId = $('#transactionId').val();
		let pan = $('#pan').val();
		let adhaar =$('#adhaar').val();
		
		if($('#number').val() != "") {
			if($('#number').val().length < 10) {
				alert("Information", "Please add a 10 digit mobile or a 11 digit landline.");
				return;
			}
		}

		if (document.getElementById("name").value != "") {
			$('#name').css('border-color', "#000000");
		} else {
			$('#name').css('border-color', "#FF0000");
			++count;
		}
				
		if (document.getElementById("amount").value != "") {
			$('#amount').css('border-color', "#000000");
		} else {
			$('#amount').css('border-color', "#FF0000");
			++count;
		}

		if(amount >= 10000 && pan == ""){
			
			$('#pan').css('border-color', "#FF0000");
			++count;
		}else{
			$('#pan').css('border-color', "#000000");
		}
				
				
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
				}  else if($('#' + id).val() == "Credit / Debit Card") {						//laz new
					if (DCtoBank != 0) {                                                     //uncommented from here till
						$('#DCtobank').css('border-color', "#800000");
					} else {
						$('#DCtobank').css('border-color', "#FF0000");
						++count;
					}                                                                         //here
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
				}                               					     				//here																			//LAZ..
			} else {
				$('#' + id).css('border-color', "#FF0000");
				++count;
			}
		});
		
			if (modeOfPayment == "Credit / Debit Card") {							//laz new extra
			if (DCtoBank != 0) {                                                 //uncommented from here till
				$('#DCtobank').css('border-color', "#800000");
			} else {
				$('#DCtobank').css('border-color', "#FF0000");
				++count;
			}                                                                    //here
			if (transactionId) {
				$('#transactionId').css('border-color', "#800000");
			} else {
				$('#transactionId').css('border-color', "#FF0000");
				++count;
			}																		
		} 
		else if (modeOfPayment == "Direct Credit") {			               //uncommented from here						
			if (toBank!=0) {
				$('#tobank').css('border-color', "#800000");
			} else {
				$('#tobank').css('border-color', "#FF0000");
				++count;
			}																			
		} 																		//here
		console.log("count",count)

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

			$('.modal-body').append("<label>Financial Head:</label> "+ financialHead +"<br/>");
			$('.modal-body').append("<label>AMOUNT:</label> "+ amount +"<br/>");

			if(pan)
			$('.modal-body').append("<label>Pan No:</label> "+ pan +"<br/>");

			if(adhaar)
			$('.modal-body').append("<label>Adhaar No:</label> "+ adhaar +"<br/>");


			if(modeOfPayment == "Cheque") {
				$('.modal-body').append("<label>CHEQUE NO:</label> "+ chequeNo +",&nbsp;&nbsp;");
				$('.modal-body').append("<label>CHEQUE DATE:</label> "+ chequeDate +",&nbsp;&nbsp;");
				$('.modal-body').append("<label>BANK:</label> "+ bank +",&nbsp;&nbsp;");
				$('.modal-body').append("<label>BRANCH:</label> "+ branch +"<br/>");
			} else if(modeOfPayment == "Credit / Debit Card") {
				$('.modal-body').append("<label>TRANSACTION ID:</label> "+ transactionId +"<br/>");
			}
				
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
	
	<!-- Phone Validation -->
	var blnDigitConfirm = false; //When a particular digit is set for 10 or for 11
	var blnDigitSet = 0; //When a particular digit is set in this case 10 digits for mobile number and 11 digits for a landline
	$('#number').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^0-9]/g, function(str) { return ''; } ) );
		
		if(!blnDigitConfirm && $th.val().length <= 11) {
			if($th.val().length == 10) {
				var res = $th.val().match(/^[0][1-9]\d{9}$|^[1-9]\d{9}$/g);
				if(res == $th.val()) { 
					blnDigitConfirm = true;
					blnDigitSet = 10;
				}
				else 
					blnDigitConfirm = false;
			}
			
			if(!blnDigitConfirm && $th.val().length == 11) {
				var res = $th.val().match(/^[0][1-9]\d{9}$|^[1-9]\d{9}$/g);
				if(res == $th.val()) {
					blnDigitConfirm = true;
					blnDigitSet = 11;
				}
				else { 
					if(blnDigitSet == 10) {
						$th.val($th.val().substring(0,10));
						blnDigitConfirm = false;
					}
				}
			}
		} else {
			if(blnDigitSet == 10) {
				$th.val($th.val().substring(0,10));
				blnDigitConfirm = false;
			}
			
			if(blnDigitSet == 11) {
				$th.val($th.val().substring(0,11));
				blnDigitConfirm = false;
			}
		}	
	});
	
	<!-- Cheque Number Validation -->
	$('#chequeNo').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^0-9]/g, function(str) { return ''; } ) );
	});
	
	<!-- Transaction Id Validation -->
	$('#transactionId').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^A-Za-z0-9]/g, function(str) { return ''; } ) );
	});
	
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