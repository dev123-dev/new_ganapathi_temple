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
		<!--5555--><!--Mode Of Payment, Cheque No, Cheque Date, Bank and Branch and Payment Notes-->
				<div class="row form-group">
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;margin-top:0.7em;">
					<div class="form-inline">
					  <label for="modeOfPayment">Mode Of Payment <span style="color:#800000;padding-right:5px;">*</span></label>
					  <select id="modeOfPayment" name="modeOfPayment" class="form-control">
						<option value="">Select Payment Mode</option>
						<option value="Cash">Cash</option>
						<option value="Cheque">Cheque</option>
						<option value="Direct Credit">Direct Credit</option>
						<option value="Credit / Debit Card">Credit / Debit Card</option>
					  </select>
					</div>
				</div>
				<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" style="margin-top:0.7em;">
						<div class="form-inline">
						  <label for="number">Amount <span style="color:#800000;">*</span></label></label>
						  <input type="text" class="form-control form_contct2" id="amount" placeholder="" name="amount" onkeyup="checkPriceVal(event)" autocomplete="off">
						</div>
				</div>
				</div>
				
				<div style="display:none" id="showChequeList">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-8" style="margin-bottom: 2em;">
						<div class="form-inline">
							<label for="name" style="margin-left:-15px;">Cheque No: </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="text" class="form-control form_contct2" id="chequeNo" placeholder="" name="chequeNo">
						</div>
					</div>
						
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-8" style="margin-bottom: 2em;">
						<div class="form-inline">
							<label for="rashi" style="margin-left:-15px;">Cheque Date: </label>&nbsp;&nbsp;
							<div class="input-group input-group-sm">
								<input id="chequeDate" name="chequeDate" type="text" value="" class="form-control chequeDate2 form_contct2" placeholder="dd-mm-yyyy" readonly="readonly"/>
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
						  <label for="number" style="margin-left:-15px;">Bank Name: </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						  <input type="text" class="form-control form_contct2" style="margin-left:-2px;" id="bank" placeholder="" name="bank">
						</div>
					</div>
					
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-10" style="margin-bottom: 2em;">
						<div class="form-inline">
						  <label for="nakshatra" style="margin-left:-15px;">Branch Name: </label>&nbsp;&nbsp;
						  <input type="text" class="form-control form_contct2" style="margin-left:-2px;" id="branch" placeholder="" name="branch">
						</div>
					</div>
				</div>
				
				<!-- Edited by adithya removed comment -->
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
							<label for="name" style="margin-left: -1em;">Transaction Id: <span style="color:#800000;">*</span></label>&nbsp;&nbsp;
							<input type="text" class="form-control form_contct2" id="transactionId" placeholder="" name="transactionId">
						</div>
					</div>
				</div>
				<!-- Edited part end ..-->
					<!-- SLAP -->
				<!-- Edited by adithy removed comment -->
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
				<!-- Edit part end -->
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="margin-bottom: 1.5em;margin-left:-14px;">
					<div class="form-group">
					  <label for="comment">Payment Notes:</label>
					  <textarea class="form-control" rows="5" style="resize:none;" id="paymentNotes" name="paymentNotes"></textarea>
					</div>
				</div>
				
				<div class="row form-group">
					<div class="control-group col-md-12 col-lg-12 col-sm-12 col-xs-12">
						<label class="control-label" style="color:#800000;font-size: 12px;"><i>* Indicates mandatory fields.</i></label>
					</div>
				</div>
		<!--5555-->
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

		//  let toBank = " "; 												                             //commented by adithya
		// let DCtoBank = " ";	

		let paymentNotes = $('#paymentNotes').val();
		let chequeNo = $('#chequeNo').val();<!--4-->
		let chequeDate = $('#chequeDate').val();<!--4-->
		let bank = $('#bank').val();<!--4-->
		let branch = $('#branch').val();<!--4-->
		let transactionId = $('#transactionId').val();<!--4-->
		
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