<form id="formSub" action="<?php echo site_url(); ?>Receipt/receipt_jeernodhara_hundi_save" enctype="multipart/form-data" method="post" accept-charset="utf-8">
	<div class="container">
		<img class="img-responsive bgImg2 bg1" src="<?=site_url()?>images/TempleLogo.png"/>
		<img class="img-responsive bgImg2 bg2" src="<?=site_url()?>images/LAKSHMI.jpg" style="display:none;"/>
		<img class="img-responsive bgImg2 bg3" src="<?=site_url()?>images/HANUMANTHA.jpg" style="display:none;"/>
		<img class="img-responsive bgImg2 bg4" src="<?=site_url()?>images/GARUDA.jpg" style="display:none;"/>
		<img class="img-responsive bgImg2 bg5" src="<?=site_url()?>images/GANAPATHI.jpg" style="display:none;"/>
		<!--Heading And Refresh Button-->
		<div class="row form-group">
			<div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
				<span class="eventsFont2"> Jeernodhara Hundi Receipt</span>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
				<a style="width:24px; height:24px" class="pull-right img-responsive" href="<?=site_url()?>Jeernodhara/Jeernodhara_Hundi" title="Reset"><img title="Reset" src="<?=site_url();?>images/refresh.svg"/></a>
			</div>
		</div>



		
				<!--Receipt Date And Receipt Number-->
				<div class="row form-group">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<span class="eventsFont2" style="font-size:16px;">Receipt Date: <?=date("d-m-Y")?></span>
			</div>
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

				<!-- new code added by adithya for pan and adhaar start -->
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;">
					<div class="form-inline">
					  <label for="pan">Pan No</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					  <input type="text" class="form-control form_contct2" id="pan" placeholder="AJRPU4567R" name="pan" style="width: 70%;">
					</div>
				</div>

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;">
					<div class="form-inline">
					  <label for="Adhaar">Adhaar No</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					  <input type="number" class="form-control form_contct2" id="adhaar" placeholder="321654987784" name="adhaar" style="width: 70%;">
					</div>
				</div>
				<!-- new code added by adithya for pan and adhaar end -->
				
				<!-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;">
					<div class="form-inline">
						<label><input style="margin-right: 6px;" id="postage" name="postage" onClick="hidePostageAmt(this);" type="checkbox" value="1">Postage</label>
						
						<input style="width:50%;visibility:hidden;" type="text" style="display:hidden;" value='0' class="form-control form_contct2" id="postageAmt" placeholder="Amount" name="postageAmt"/>
					</div>
				</div> -->
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
					  <textarea class="form-control" rows="5" id="address" name="address" placeholder="Near Classic Chaya, Santhakatte" style="width: 100%;"></textarea>
					</div>
				</div>
			</div>
			
			<div class="col-md-6 text-left">
					
				<div class="form-inline col-lg-12 col-md-12 col-sm-12 col-xs-8" style="margin-bottom: 1.5em;">
				
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
							<label for="name">Cheque No: </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="text" class="form-control form_contct2" id="chequeNo" placeholder="" name="chequeNo">
						</div>
					</div>
						
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-8" style="margin-bottom: 2em;">
						<div class="form-inline">
							<label for="rashi">Cheque Date: </label>&nbsp;&nbsp;
							<div class="input-group input-group-sm">
								<input id="chequeDate" name="chequeDate" type="text" value="" class="form-control chequeDate2 form_contct2" placeholder="dd-mm-yyyy" readonly>
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
						  <label for="number">Bank Name: </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						  <input type="text" class="form-control form_contct2" id="bank" placeholder="" name="bank">
						</div>
					</div>
					
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-10" style="margin-bottom: 2em;">
						<div class="form-inline">
						  <label for="nakshatra">Branch Name: </label>&nbsp;&nbsp;
						  <input type="text" class="form-control form_contct2" id="branch" placeholder="" name="branch">
						</div>
					</div>
				</div>
				
				<!-- laz new -->
				<div style="display:none;" id="showDebitCredit">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-10" style="margin-bottom: 2em;">
						<div class="form-inline col-xs-12" style="margin-left: -14px;margin-bottom: 1em;">
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
						<div class="form-inline">
							<label for="name">Transaction Id: <span style="color:#800000;">*</span></label>&nbsp;&nbsp;
							<input type="text" class="form-control form_contct2" id="transactionId" placeholder="" name="transactionId">
						</div>
					</div>
				</div>
				<!-- laz new ..-->
				
				<!-- SLAP -->
				<!-- laz -->
				<div style="padding-top: 15px; display:none;" id="showDirectCredit">
					<div class="form-inline col-xs-10"  style="margin-bottom: 1em;">
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
				

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;">
					<div class="form-group">
					  <label for="comment">Payment Notes:</label>
					  <textarea class="form-control" rows="5" id="paymentNotes" name="paymentNotes" style="resize:none;"></textarea>
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
				<h4 class="modal-title">Jeernodhara Hundi Preview</h4>
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
	
	<!--Notes
	<div class="container">
		<div class="row form-group">		
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
				  <label for="comment">Notes:</label>
				  <textarea class="form-control" rows="5" id="paymentNotes" name="paymentNotes"></textarea>
				</div>
			</div>
		</div>
		
		<div class="row form-group">
			<div class="control-group col-md-12 col-lg-12 col-sm-12 col-xs-12">
				<label class="control-label" style="color:#800000;font-size: 12px;"><i>* Indicates mandatory fields.</i></label>
			</div>
		</div>
	</div> -->

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
	
	/* function deityComboChange() {
		arrDeity = ($('#deity').val()).split('|');
		bgNo = arrDeity[0];
		
		for(i = 1; i <= 5; ++i)
			if(i == bgNo)
				$('.bg'+i).slideDown();
			else
				$('.bg'+i).slideUp();
	} */

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
		//var selection = document.getElementById("selRadio").value; 
		$.ajax({
            type: "POST",
            url: "<?php echo base_url();?>Receipt/check_eod_confirm_time ",
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
		// new fields added by adithya start
		let name = document.getElementById("name").value
		let number = document.getElementById("number").value
		let email = document.getElementById("email").value
		let address = $('#address').val();
		let pan = $('#pan').val();
		let adhaar = $('#adhaar').val();
		// new fields added by adithya end

		let amount = document.getElementById("amount").value
		let toBank = $('#tobank option:selected').val();												//laz
		let DCtoBank = $('#DCtobank option:selected').val();											//laz new
        let modeOfPayment = $('#modeOfPayment option:selected').val(); <!--4-->
		let paymentNotes = $('#paymentNotes').val();<!--4-->
		let chequeNo = $('#chequeNo').val();<!--4-->
		let chequeDate = $('#chequeDate').val();<!--4-->
		let bank = $('#bank').val();<!--4-->
		let branch = $('#branch').val();<!--4-->
		let transactionId = $('#transactionId').val();<!--4-->



		// new code added by adithya start
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

		if(document.getElementById("amount").value >= 10000 && pan == "" ){
			$('#pan').css('border-color',"#FF0000")
			++count;
		}else{
			$('#pan').css('border-color',"#000000")
		}
		// new code added by adithya end
	
		<!-- $('input[type=text]').each(function(){ -->
		<!-- var id = this.id; -->
		<!-- if($('#' + id).val() != "") { -->
		<!-- $('#' + id).css('border-color', "#000000"); -->
		<!-- } else {
		<!-- $('#' + id).css('border-color', "#FF0000"); -->
		<!-- ++count;
		<!-- } -->
		<!-- }); -->
		
		if($('#amount').val() != "") {
			$('#amount').css('border-color', "#000000");
		} else {
			$('#amount').css('border-color', "#FF0000");
			++count;
		}
	
		$('select').each(function(){
			var id = this.id;
			if($('#' + id).val() != "") {
				$('#' + id).css('border-color', "#000000");
			} else {
				$('#' + id).css('border-color', "#FF0000");
				++count;
			}
		});
		
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
				} else if($('#' + id).val() == "Credit / Debit Card") {						//laz new
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
					}																		//laz new ..
				} else if($('#' + id).val() == "Direct Credit") {							//LAZ
					if (document.getElementById("tobank").value != 0) {
						$('#tobank').css('border-color', "#000000");
					} else {
						$('#tobank').css('border-color', "#FF0000");
						++count;
					}
				}																			//LAZ..
			} else {
				$('#' + id).css('border-color', "#FF0000");
				++count;
			}
		});
		if (modeOfPayment == "Credit / Debit Card") {							//laz new extra
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
		} 																		//laz new extra ..
		
		
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
			
				if(pan)
				$('.modal-body').append("<label>Pan Number:</label> "+ pan +"<br/>");
			
				if(adhaar)
				$('.modal-body').append("<label>Adhaar Number:</label> "+ adhaar +"<br/>");
				
			$('.modal-body').append("<label>AMOUNT:</label> "+ amount +"<br/>");

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
	
	//SELECT CHANGE
	$('radio').on('change', function() {
		var id = this.id;
		$('#' + id).css('border-color', "#000000");
	});

	
	
	// <!-- Amount Validation -->
	$('#amount').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^0-9]/g, function(str) { return ''; } ) );
	});
	
	// <!-- Check If Price Is Zero -->
	function checkPriceVal(evt){
		inputLS = evt.currentTarget;
		if($(inputLS).val() && Number($(inputLS).val()) == 0){
			$(inputLS).val("");
		} 			
	}
	// <!-- Cheque Number Validation -->
	$('#chequeNo').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^0-9]/g, function(str) { return ''; } ) );
	});
	
	<!-- Transaction Id Validation -->
	$('#transactionId').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^0-9]/g, function(str) { return ''; } ) );
	});

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