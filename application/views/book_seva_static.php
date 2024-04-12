<form id="formSub" action="<?php echo site_url(); ?>SevaBooking/add_book_Seva_Save/" enctype="multipart/form-data" method="post" accept-charset="utf-8">
	<div class="container">
		<img class="img-responsive bgImg2 bg1" src="<?=site_url()?>images/TempleLogo.png" />
		<img class="img-responsive bgImg2 bg2" src="<?=site_url()?>images/LAKSHMI.jpg" style="display:none;" />
		<img class="img-responsive bgImg2 bg3" src="<?=site_url()?>images/HANUMANTHA.jpg" style="display:none;" />
		<img class="img-responsive bgImg2 bg4" src="<?=site_url()?>images/GARUDA.jpg" style="display:none;" />
		<img class="img-responsive bgImg2 bg5" src="<?=site_url()?>images/GANAPATHI.jpg" style="display:none;" />
		<div class="row form-group">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="col-lg-4 col-md-4  col-sm-4 col-xs-12">
					<span class="eventsFont2">Seva Receipt</span>
				</div>
				<div class="col-lg-4  col-md-5 col-sm-6 col-xs-6">
					<span class="eventsFont2 samFont1"></span>
				</div>
				<div class="col-lg-offset-2 col-lg-2  col-md-offset-0 col-md-3 col-sm-offset-0 col-sm-2 col-xs-offset-3 col-xs-3">
					<a style="width:24px; height:24px" class="pull-right img-responsive" href="<?=site_url()?>SevaBooking/add_book_Seva/<?php echo $getBooking[0]->SB_ID; ?>" titile="Reset">
						<img title="reset" src="<?=site_url();?>images/refresh.svg" />
					</a>
				</div>
			</div>
		</div>

		<div class="row form-group">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<span class="eventsFont2">Receipt Date: <?php echo date('d-m-Y'); ?></span>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
					<div class="form-group">
						<label for="name" style="font-size: 17px;">Name : <span id="name" style="font-size: 18px;"><?php echo $getBooking[0]->SB_NAME; ?></span></label>
						<!--HIDDEN FIELD-->
						<input type="hidden" id="sbname" name="sbname" value="<?php echo $getBooking[0]->SB_NAME; ?>">
						<input type="hidden" id="sbid" name="sbid" value="<?php echo $getBooking[0]->SB_ID; ?>">
						<input type="hidden" id="soid" name="soid" value="<?php echo $getBooking[0]->SO_ID; ?>">
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
					<div class="form-group">
						<?php if($getBooking[0]->SB_PHONE != "") { ?>
							<label for="number" style="font-size: 17px;">Number : <span id="phone" style="font-size: 18px;"><?php echo $getBooking[0]->SB_PHONE; ?></span></label>
						<?php } else { ?>
							<label for="number" style="font-size: 17px;"> <span id="phone" style="font-size: 18px;"></span></label>
						<?php } ?>
						<!--HIDDEN FIELD-->
						<input type="hidden" id="sbphone" name="sbphone" value="<?php echo $getBooking[0]->SB_PHONE; ?>">
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					<div class="form-group">
						<?php if($getBooking[0]->SB_ADDRESS != "") { ?>
							<label for="address" style="font-size: 17px;">Address : <span id="address" style="font-size: 18px;"><?php echo $getBooking[0]->SB_ADDRESS; ?></span></label>
						<?php } else { ?>
							<label for="address" style="font-size: 17px;"> <span id="address" style="font-size: 18px;"></span></label>
						<?php } ?>
						<!--HIDDEN FIELD-->
						<input type="hidden" id="sbaddress" name="sbaddress" value="<?php echo $getBooking[0]->SB_ADDRESS; ?>">
					</div>
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<div class="col-lg-7 col-md-12 col-sm-6 col-xs-12">
					<div class="form-group">
						<label for="DeityCombo" style="font-size: 17px;">Deity : <span id="deityName" style="font-size: 18px;"><?php echo $getBooking[0]->SO_DEITY_NAME; ?></span></label>
						<!--HIDDEN FIELD-->
						<input type="hidden" id="sbdeityname" name="sbdeityname" value="<?php echo $getBooking[0]->SO_DEITY_NAME; ?>">
						<input type="hidden" id="sbdeityid" name="sbdeityid" value="<?php echo $getBooking[0]->SO_DEITY_ID; ?>">
					</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-9 col-xs-12">
					<div class="form-group">
						<label for="seva" style="font-size: 17px;">Seva : <span id="sevaName" style="font-size: 18px;"><?php echo $getBooking[0]->SO_SEVA_NAME; ?></span></label>
						<!--HIDDEN FIELD-->
						<input type="hidden" id="sbsevaname" name="sbsevaname" value="<?php echo $getBooking[0]->SO_SEVA_NAME; ?>">
						<input type="hidden" id="sbsevaid" name="sbsevaid" value="<?php echo $getBooking[0]->SO_SEVA_ID; ?>">
					</div>
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 deityCol">
				<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 isSeva1">
					<div class="form-group">
						<label for="number" style="font-size: 17px;">Seva Date : <span id="sevaDate" style="font-size: 18px;"><?php echo $getBooking[0]->SO_DATE; ?></span></label>
						<!--HIDDEN FIELD-->
						<input type="hidden" id="sbsevadate" name="sbsevadate" value="<?php echo $getBooking[0]->SO_DATE; ?>">
					</div>
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 deityCol">
				<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 isSeva1">
					<div class="form-inline">
						<label for="number" style="font-size: 17px;">Seva Amount : <span style="color:#800000;">*</span</label>
						<input style="width:90px;font-size:24px;" type="text" onkeyup="checkPriceVal(event)" class="form-control form_contct2" id="amount" placeholder="1000" name="amount">
					</div>
				</div>
			</div>
			<!-- Row -->
		</div>
		<!-- Row -->
	</div>
	<div class="container">
		<div class="row form-group">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="form-inline col-lg-6 col-md-6 col-sm-6 col-xs-8">
					<div class="form-group">
					  <label for="modeOfPayment" style="font-size: 17px;">Mode Of Payment : <span style="color:#800000;">*</span></label>
					  <select id="modeOfPayment" name="modeOfPayment" class="form-control">
						<option value="">Select Payment Mode</option>
						<option value="Cash">Cash</option>
						<option value="Cheque">Cheque</option>
						<option value="Direct Credit">Direct Credit</option>
						<option value="Credit / Debit Card">Credit / Debit Card</option>
					  </select>
					</div>
					
					<div style="padding-top: 15px; display:none;margin-left: -14px;" id="showChequeList">
						<div class="form-group col-xs-10">
							<label for="name">Cheque No: <span style="color:#800000;">*</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="text" class="form-control form_contct2" id="chequeNo" placeholder="" name="chequeNo">
						</div>
						
					<div style="padding-top: 15px;" class="form-group col-xs-10">
						<label for="rashi">Cheque Date: <span style="color:#800000;">*</span></label>&nbsp;&nbsp;
						<div class="input-group input-group-sm">
							<input id="chequeDate" name="chequeDate" type="text" value="<?=date("d-m-Y")?>" class="form-control chequeDate2 form_contct2" placeholder="dd-mm-yyyy">
							<div class="input-group-btn">
								<button class="btn btn-default chequeDate" type="button">
								   <i class="glyphicon glyphicon-calendar"></i>
								</button>
							</div>
						</div>
					</div>
						
						<div style="padding-top: 15px;" class="form-group col-xs-12">
						  <label for="number">Bank Name: <span style="color:#800000;">*</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						  <input type="text" class="form-control form_contct2" id="bank" placeholder="" name="bank">
						</div>
						
						<div style="padding-top: 15px;" class="form-group col-xs-12">
						  <label for="nakshatra">Branch Name: <span style="color:#800000;">*</span></label>&nbsp;&nbsp;
						  <input type="text" class="form-control form_contct2" id="branch" placeholder="" name="branch">
						</div>
					</div>
					<!-- laz new-->
					<div style="padding-top: 15px; display:none;margin-left: -14px;" id="showDebitCredit">
						<div class="form-group col-xs-10"  style="margin-bottom: 1em;">
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
							<label for="name">Transaction Id: <span style="color:#800000;">*</span></label>&nbsp;&nbsp;
							<input type="text" class="form-control form_contct2" id="transactionId" placeholder="" name="transactionId">
						</div>
					</div>
					<!-- laz new ..-->
					<!-- SLAP -->
					<!-- laz -->
					
					<div style="padding-top: 15px; display:none;margin-left: -14px;" id="showDirectCredit">
						<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-10" style="margin-bottom: 2em;">
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
				</div>
				
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="form-group">
					  <label for="comment" style="font-size: 17px;">Payment Notes : </label>
					  <textarea class="form-control" rows="5" id="paymentNotes" name="paymentNotes"></textarea>
					</div>
					
					<div class="row form-group">
						<div class="control-group col-md-12 col-lg-12 col-sm-12 col-xs-12">
							<label class="control-label" style="color:#800000;font-size: 12px;"><i>* Indicates mandatory fields.</i></label>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade bs-example-modal-lg" id="bookSeva" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="modTitle">Seva Receipt Preview</h4>
				</div>
				<div class="modal-body" id="creditdet" style="overflow-y: auto;max-height: 80vmin;">

				</div>
				<div id="errMsg" class="modal-body" style="overflow-y:auto;max-height:80vmin;margin-top:.4em;display:none;color:red;font-weight:bold;">
				</div>
				<div class="modal-footer text-left" style="text-align:left;" id="btnHide">
					<label>Are you sure you want to save..?</label>
					<br/>
					<button style="width: 8%;" type="button" class="btn btn-default sevaButton" id="submit2">Yes</button>
					<button style="width: 8%;" type="button" class="btn btn-default sevaButton" data-dismiss="modal">No</button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="container">
		<div class="row form-group pull-right">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<button type="button" class="btn btn-default btn-lg" onClick="field_validation()"><span class="glyphicon glyphicon-print"></span> Submit & Print</button>
			</div>
		</div>
	</div>
</form>
<script>
	$('#submit2').on('click', function() {
		let urlSeva = "<?=site_url()?>SevaBooking/checkSevaBookingPayment";
		$.post(urlSeva, {'sbId':$('#sbid').val()}, function(e) {
			if (e == "success") {
				$('#formSub').submit();
			} else if(e == "failed") {
				document.getElementById("modTitle").innerHTML = "Information";
				document.getElementById("creditdet").style.display = "none";
				document.getElementById("btnHide").style.display = "none";
				document.getElementById("errMsg").style.display = "block";
				document.getElementById('errMsg').innerHTML = "Please note receipt has already been generated for this booking!";
				$('#bookSeva').effect( "shake" );
			}
		});
	})

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
	
	<!-- Price Validation -->
	$('#amount').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^0-9]/g, function(str) { return ''; } ) );
	});
	
	<!-- Check If Price Is Zero -->
	function checkPriceVal(evt){
		inputPrice = evt.currentTarget;
		if($(inputPrice).val() && Number($(inputPrice).val()) == 0){
			$(inputPrice).val("");
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
	
	var currentTime = new Date();
	var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(),+(Number(currentTime.getDate())+1));//one day next before month
	var maxDate = new Date(currentTime.getFullYear(), currentTime.getMonth() +12, +0); // one day before next month
	
	$( ".chequeDate2" ).datepicker({
		dateFormat: 'dd-mm-yy'
	});
					
	$('.chequeDate').on('click', function() {
		$( ".chequeDate2" ).focus();
	});
	
	<!-- Validating Fields -->
	function field_validation() {
		var count = 0;
		
		let name = $('#name').html();
		let phone = $('#phone').html();
		let sevaDate = $('#sevaDate').html();
		let amount = document.getElementById("amount").value;
		let deityName = $('#deityName').html();
		let sevaName = $('#sevaName').html();
		let modeOfPayment = $('#modeOfPayment option:selected').val();
		let toBank = $('#tobank option:selected').val();												//laz
		let DCtoBank = $('#DCtobank option:selected').val();											//laz new
		let paymentNotes = $('#paymentNotes').val();
		let address = $('#address').val();
		let chequeNo = $('#chequeNo').val();
		let chequeDate = $('#chequeDate').val();
		let bank = $('#bank').val();
		let branch = $('#branch').val();
		let transactionId = $('#transactionId').val();
		
		if (document.getElementById("amount").value != "") {
			$('#amount').css('border-color', "#000000");
		} else {
			$('#amount').css('border-color', "#FF0000");
			++count;
		}
		
		$('select').each(function(){
			var id = this.id;
			if($('#' + id).val() != "") {
				$('#' + id).css('border-color', "#000000");
				if($('#' + id).val() == "Cheque") {
					if (document.getElementById("chequeNo").value != "" && document.getElementById("chequeNo").value.length == 6) {
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
			$('.modal-body').append("<label>DEITY:</label> "+ deityName +"<br/>");
			$('.modal-body').append("<label>SEVA:</label> "+ sevaName +"<br/>");
			$('.modal-body').append("<label>NAME:</label> "+ name +"<br/>");
			if(phone)
				$('.modal-body').append("<label>NUMBER:</label> "+ phone +"<br/>");
			
			if(address)
				$('.modal-body').append("<label>ADDRESS:</label> "+ address +"<br/>");		
			
			$('.modal-body').append("<label>SEVA DATE:</label> "+ sevaDate +"<br/>");
			
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
</script>