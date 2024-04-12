<div class="container">
	<form class="form-group" method="post" action="<?php echo site_url(); ?>TrustAuction/issue_auction_receipt_save">
		<div class="col-lg-12">
			<div class="form-group">
				<center><label class="eventsFont2 samFont1"><?=$event['TET_NAME']; ?></label></center>
				<input type="hidden" name="eventName" id="eventName" value="<?=$event['TET_NAME']; ?>"/>
				<input type="hidden" name="eventId" id="eventId" value="<?=$event['TET_ID']; ?>"/>
				<?php if(@$fromAllReceipt == "1") { ?>
					<a class="pull-right" style="border:none; outline:0;" href="<?=$_SESSION['actual_link'] ?>" title="Back"><img style="border:none; outline: 0;margin-top: -71px;" src="<?php echo base_url(); ?>images/back_icon.svg"></a>
				<?php } else { ?>
					<a class="pull-right" style="border:none; outline:0;" href="<?=site_url() ?>TrustAuction/issue_auction" title="Back"><img style="border:none; outline: 0;margin-top: -71px;" src="<?php echo base_url(); ?>images/back_icon.svg"></a>
				<?php } ?>
			</div>
		</div>
		  
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">		
			<div class="form-group">
				<label for="name" style="font-size:18px;"><strong>Name: </label></strong>
				<span style="font-size:16px;" class=""><?php echo $auction_receipt[0]->BIL_NAME; ?></span>
				<input type="hidden" name="bilId" id="bilId" value="<?php echo $auction_receipt[0]->BIL_ID; ?>"/>
				<input type="hidden" name="bilRefNo" id="bilRefNo" value="<?php echo $auction_receipt[0]->BID_REF_NO; ?>"/>
				<input type="hidden" name="name" id="name" value="<?php echo $auction_receipt[0]->BIL_NAME; ?>"/>
			</div>
		
			<div class="form-group">
				<label for="number" style="font-size:18px;"><strong>Number: </label></strong>
				<span style="font-size:16px;" class=""><?php echo $auction_receipt[0]->BIL_NUMBER; ?></span>
				<input type="hidden" name="number" id="number" value="<?php echo $auction_receipt[0]->BIL_NUMBER; ?>"/>
			</div>
		  
			<div class="form-group">
				<label for="email" style="font-size:18px;"><strong>Email: </label></strong>
				<span style="font-size:16px;" class=""><?php echo $auction_receipt[0]->BIL_EMAIL; ?></span>
				<input type="hidden" name="email" id="email" value="<?php echo $auction_receipt[0]->BIL_EMAIL; ?>"/>
			</div> 
			
			<div class="form-group">
				<label for="address" style="font-size:18px;"><strong>Address: </label></strong>
				<span style="font-size:16px;" class=""><?php echo $auction_receipt[0]->BIL_ADDRESS; ?></span>
				<input type="hidden" name="address" id="address" value="<?php echo $auction_receipt[0]->BIL_ADDRESS; ?>"/>
			</div>

			<div class="form-group">
				<label for="bidPrice" style="font-size:18px;"><strong>Bid Price: </label></strong>
				<span style="font-size:16px;" class=""><?php echo $auction_receipt[0]->BIL_BID_PRICE; ?></span>
				<input type="hidden" name="bidPrice" id="bidPrice" value="<?php echo $auction_receipt[0]->BIL_BID_PRICE; ?>"/>
			</div>
		</div>
		  
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="form-group text-right">
				<label for="item" style="font-size:18px;"><strong>Item: </label></strong>
				<span style="font-size:16px;" class=""><?php echo $auction_receipt[0]->BIL_ITEM_NAME; ?></span>
				<input type="hidden" name="item" id="item" value="<?php echo $auction_receipt[0]->BIL_ITEM_NAME; ?>"/>
				<input type="hidden" name="itemId" id="itemId" value="<?php echo $auction_receipt[0]->BIL_ITEM_ID; ?>"/>
			</div>
		
			<div class="form-group text-right">
				<label for="itemRefernceNo" style="font-size:18px;"><strong>Item Reference No: </label></strong>
				<span style="font-size:16px;" class=""><?php echo $auction_receipt[0]->ITEM_REF_NO; ?></span>
				<input type="hidden" name="itemRefernceNo" id="itemRefernceNo" value="<?php echo $auction_receipt[0]->ITEM_REF_NO; ?>"/>
			</div>			
		  
			<div class="form-group text-right">
				<label for="itemDetails" style="font-size:18px;"><strong>Item Details: </label></strong>
				<span style="font-size:16px;" class=""><?php echo $auction_receipt[0]->BIL_ITEM_DETAILS; ?></span>
				<input type="hidden" name="itemDetails" id="itemDetails" value="<?php echo $auction_receipt[0]->BIL_ITEM_DETAILS; ?>"/>
			</div>
			
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-8 text-right" style="margin-bottom: 1em;">
				<div class="form-inline">
				  <label for="modeOfPayment">Mode Of Payment: <span style="color:#800000;">*</span></label>
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
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-8 text-right" style="margin-bottom: 1em;">
					<div class="form-inline">
						<label for="chequeNo">Cheque No: <span style="color:#800000;">*</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="text" class="form-control form_contct2" id="chequeNo" placeholder="" name="chequeNo">
					</div>
				</div>
					
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-8 text-right" style="margin-bottom: 1em;">
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
				
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-10 text-right" style="margin-bottom: 1em;">
					<div class="form-inline">
					  <label for="bankName">Bank Name: <span style="color:#800000;">*</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					  <input type="text" class="form-control form_contct2" id="bank" placeholder="" name="bank">
					</div>
				</div>
				
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-10 text-right" style="margin-bottom: 1em;">
					<div class="form-inline">
					  <label for="branchName">Branch Name: <span style="color:#800000;">*</span></label>&nbsp;&nbsp;
					  <input type="text" class="form-control form_contct2" id="branch" placeholder="" name="branch">
					</div>
				</div>
			</div>
			
			<!-- laz new -->
			<div style="display:none;" id="showDebitCredit">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-10 text-right" style="margin-bottom: 1em;">
					<div class="form-inline" style="margin-bottom: 1em;">
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
			<!-- laz new ..-->

			<!-- SLAP -->
			<!-- laz -->
			<div style="display:none;" id="showDirectCredit">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-10 text-right" style="margin-bottom: 1em;">
					<div class="form-inline">
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
			</div>
			<!-- laz.. -->
		</div>
		<div style="clear:both;" class="form-group">
			<center><button type="submit" onClick="return field_validation()" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-print"></span> Submit & Print</button></center>
		</div>
	</form>
</div>
<script>
	<!-- Validating Fields -->
	function field_validation() {		
		let modeOfPayment = $('#modeOfPayment option:selected').val();	
		var count = 0;
		$('select').each(function(){
			var id = this.id;
			if($('#' + id).val() != "") {
				$('#' + id).css('border-color', "#000000");
				if($('#' + id).val() == "Cheque") {
					if (document.getElementById("chequeNo").value != "") {
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
					if (document.getElementById("DCtobank").value != 0) {
						$('#DCtobank').css('border-color', "#800000");
					} else {
						$('#DCtobank').css('border-color', "#FF0000");
						++count;
					}
					if (document.getElementById("transactionId").value != "") {
						$('#transactionId').css('border-color', "#000000");
					} else {
						$('#transactionId').css('border-color', "#FF0000");
						++count;
					}
				} else if($('#' + id).val() == "Direct Credit") {							//LAZ
					if (document.getElementById("tobank").value != 0) {
						$('#tobank').css('border-color', "#000000");
					} else {
						$('#tobank').css('border-color', "#FF0000");
						++count;
					}
				}
			} else {
				$('#' + id).css('border-color', "#FF0000");
				++count;
			}
		});

		if (modeOfPayment == "Credit / Debit Card") {							//laz new extra
			if (document.getElementById("DCtobank").value != 0) {
				$('#DCtobank').css('border-color', "#800000");
			} else {
				$('#DCtobank').css('border-color', "#FF0000");
				++count;
			}
			if (document.getElementById("transactionId").value != "") {
				$('#transactionId').css('border-color', "#800000");
			} else {
				$('#transactionId').css('border-color', "#FF0000");
				++count;
			}																		
		} else if (modeOfPayment == "Direct Credit") {									
			if (document.getElementById("tobank").value != 0) {
				$('#tobank').css('border-color', "#800000");
			} else {
				$('#tobank').css('border-color', "#FF0000");
				++count;
			}																			
		} 																		//laz new extra ..
		
		if(count != 0) {
			alert("Information","Please fill required fields","OK");
			return false;
		} 
	}

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
		minDate: minDate, 
		maxDate: maxDate,
		dateFormat: 'dd-mm-yy'
	});
					
	$('.chequeDate').on('click', function() {
		$( ".chequeDate2" ).focus();
	});
</script>