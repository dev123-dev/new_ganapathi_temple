
	<!--for printing --><div id="printScreen" style="display:none">
		<page style="margin-top:25px;margin-left:75%;width:115%;margin-right:75%;" data-size="A6">
			<form>
				<center style="margin-top:45px;"><span class="eventsFont2" style="font-size:14px;font-family:switzerland;margin-top:5px;"><strong><?=$eventCounter[0]["RECEIPT_ET_NAME"]; ?></strong></span></center><br/>
				<center class="eventsFont2" style="font-size:14px;font-family:switzerland;margin-top:-6px;"><strong>
					<?=$templename[0]["TEMPLE_NAME"]?>
				</strong></center>
				<center style="margin-top:50px;"><span class="eventsFont2" style="display:none;font-size:11px;padding-bottom:4px;" id="duplicate"><strong><?="Duplicate";?>&nbsp;</strong></span><span class="eventsFont2" style="font-size:11px;margin-top:35px;padding-bottom:4px;"><strong>Donation/Kanike Receipt</strong></span></center>
				<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Receipt Date&nbsp;: </strong><?=$eventCounter[0]["ET_RECEIPT_DATE"];?></span><br/>
				<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Receipt No&nbsp;&nbsp;&nbsp;&thinsp;: </strong><?=$eventCounter[0]['ET_RECEIPT_NO'] ?></span><br/>
				<div style="margin-bottom:5px;"></div>
				<span style="font-size:11px;"><strong>Name&nbsp;&nbsp;&nbsp;&thinsp;&thinsp;: <?=$eventCounter[0]['ET_RECEIPT_NAME'] ?> </strong></span><br/>
				<?php if($eventCounter[0]['ET_RECEIPT_PHONE'] != "") { ?>
					<span style="font-size:11px;"><strong>Number&nbsp;: </strong><?=$eventCounter[0]['ET_RECEIPT_PHONE'] ?></span><br/>
				<?php } else { ?>
					<span style="font-size:11px;"><strong>Number&nbsp;: </strong><?=$eventCounter[0]['ET_RECEIPT_PHONE'] ?></span><br/>
				<?php } ?>
				<?php if($eventCounter[0]['ET_RECEIPT_EMAIL'] != "") { ?>
					<span style="font-size:11px;"><strong>Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&thinsp;: </strong><?=$eventCounter[0]['ET_RECEIPT_EMAIL'] ?></span><br/>
				<?php } else { ?>
					<span style="font-size:11px;"><strong>Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&thinsp;: </strong><?=$eventCounter[0]['ET_RECEIPT_EMAIL'] ?></span><br/>
				<?php } ?>
				<?php if($eventCounter[0]['ET_RECEIPT_ADDRESS'] != "") { ?>
					<span style="font-size:11px;"><strong>Address&nbsp;&thinsp;: </strong><?=$eventCounter[0]['ET_RECEIPT_ADDRESS'] ?></span>
					<div style="margin-bottom:5px;"></div>
				<?php } else { ?>
					<span style="font-size:11px;"><strong>Address&nbsp;&thinsp;: </strong><?=$eventCounter[0]['ET_RECEIPT_ADDRESS'] ?></span>
					<div style="margin-bottom:5px;"></div>
				<?php } ?>
				<span style="font-size:11px;" class="eventsFont2" ><strong>Amount&nbsp;: Rs. <?=$eventCounter[0]['ET_RECEIPT_PRICE'] ?>/- <?=AmountInWords($eventCounter[0]['ET_RECEIPT_PRICE']);?></strong></span><br/>
				<?php if($eventCounter[0]['POSTAGE_PRICE'] != 0) { ?>
				<span style="font-size:11px;" class="eventsFont2"><strong>Postage&nbsp;: Rs. <?=$eventCounter[0]['POSTAGE_PRICE']; ?><?=AmountInWords($eventCounter[0]['POSTAGE_PRICE']);?></strong></span><br/>
				<?php } ?>
				<span style="font-size:11px"><strong>Payment Mode&nbsp;: </strong><?=$eventCounter[0]['ET_RECEIPT_PAYMENT_METHOD']; ?></span><br/>
				<?php if($eventCounter[0]['ET_RECEIPT_PAYMENT_METHOD'] == "Cheque") { ?>
					<span style="font-size:11px;"><strong>Cheque Number&nbsp;: </strong><?=$eventCounter[0]['CHEQUE_NO']; ?></span>
					<span style="font-size:11px;"><strong>Cheque Date&nbsp;: </strong><?=$eventCounter[0]['CHEQUE_DATE']; ?></span>
					<span style="font-size:11px;"><strong>Bank&nbsp;: </strong><?=$eventCounter[0]['BANK_NAME']; ?></span>
					<span style="font-size:11px;"><strong>Branch&nbsp;: </strong><?=$eventCounter[0]['BRANCH_NAME']; ?></span><br/>
				<?php } else if($eventCounter[0]['ET_RECEIPT_PAYMENT_METHOD'] == "Credit / Debit Card") { ?>
					<span style="font-size:11px;"><strong>Transaction Id&nbsp;: </strong><?=$eventCounter[0]['TRANSACTION_ID']; ?></span><br/>
				<?php } ?>
					<?php if($eventCounter[0]['ET_RECEIPT_PAYMENT_METHOD_NOTES'] != "") { ?>
						<span style="font-size:11px;"><strong>Notes&nbsp;: </strong><?=$eventCounter[0]['ET_RECEIPT_PAYMENT_METHOD_NOTES'] ?></span>
					<?php } ?><br/><br/>
					<span style="font-size:11px;float:right;letter-spacing:1px;"><strong>Issued By&nbsp;:</strong><?=$eventCounter[0]['ET_RECEIPT_ISSUED_BY'] ?></span><br/>
					<center style="clear:both;font-size: 20px;">*************************</center>
			</form>
		</page>
		
		<!--<page>
			<form>
				<center><span class="eventsFont2 samFont1"><?=$eventCounter[0]["RECEIPT_ET_NAME"]; ?></span></center>
				<center class="eventsFont2">
					Sri Laxmi Venkatesh Temple
				</center>
				<center class="eventsFont2">
					V.T. Road, UDUPI
				</center>
				<center class="eventsFont2">
					Phone: 2520860
				</center><br/><br/>
				<?php if($eventCounter[0]['ET_RECEIPT_PHONE'] != "") { ?>
					<?php //$phone = ", " .$eventCounter[0]['ET_RECEIPT_PHONE']; ?>
				<?php } ?>
				<?php if($eventCounter[0]['ET_RECEIPT_EMAIL'] != "") { ?>
					<?php //$email = ", ".$eventCounter[0]['ET_RECEIPT_EMAIL']; ?>
				<?php } ?>
				<?php if($eventCounter[0]['ET_RECEIPT_ADDRESS'] != "") { ?>
						<?php //$address = .", ".$eventCounter[0]['ET_RECEIPT_ADDRESS']; ?>
					<?php } ?>
				<center><span class="eventsFont2">Donation/Kanike Receipt</span></center><br/>
				<span class="eventsFont2">Receipt Date: <?=$eventCounter[0]["ET_RECEIPT_DATE"];?></span><br/>
				<span class="eventsFont2">Receipt Number: <?=$eventCounter[0]['ET_RECEIPT_NO'] ?></span><br/>
				<span style="font-size:18px;"><strong>Received with thanks from: </strong><?=$eventCounter[0]['ET_RECEIPT_NAME']. "" . @$phone. "".@$email."". @$address; ?></span><br/>
				<span class="eventsFont2">a sum of Rupees: <?=$eventCounter[0]['ET_RECEIPT_PRICE'] ?></span><br/>
				<span style="font-size:18px"><strong>By cash/D.D/cheque: </strong><?=$eventCounter[0]['ET_RECEIPT_PAYMENT_METHOD']; ?></span><br/>
				<?php if($eventCounter[0]['ET_RECEIPT_PAYMENT_METHOD'] == "Cheque") { ?><br/>
					<span style="font-size:18px;margin-left:15px;"><strong>Cheque Number: </strong><?=$eventCounter[0]['CHEQUE_NO']; ?></span><br/>
					<span style="font-size:18px;margin-left:15px;"><strong>Cheque Date: </strong><?=$eventCounter[0]['CHEQUE_DATE']; ?></span><br/>
					<span style="font-size:18px;margin-left:15px;"><strong>Bank: </strong><?=$eventCounter[0]['BANK_NAME']; ?></span><br/>
					<span style="font-size:18px;margin-left:15px;"><strong>Branch: </strong><?=$eventCounter[0]['BRANCH_NAME']; ?></span><br/>
				<?php } else if($eventCounter[0]['ET_RECEIPT_PAYMENT_METHOD'] == "Credit / Debit Card") { ?><br/>
					<span style="font-size:18px;margin-left:15px;"><strong>Transaction Id: </strong><?=$eventCounter[0]['TRANSACTION_ID']; ?></span><br/>
				<?php } ?><br/>
					<?php if($eventCounter[0]['ET_RECEIPT_PAYMENT_METHOD_NOTES'] != "") { ?>
						<span style="font-size:18px;"><strong>Notes: </strong><?=$eventCounter[0]['ET_RECEIPT_PAYMENT_METHOD_NOTES'] ?></span><br/>
					<?php } ?>
			</form>
		</page>-->
		
	</div><!--for printing ends -->
	
	<div class="container">
		<form class="form-group">
			<div class="row form-group">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-left:0px;">
					<div class="col-lg-4 col-md-4  col-sm-4 col-xs-12">
					 <span class="eventsFont2">Event Donation Receipt</span>
						</div>
					<div class="col-lg-6  col-md-6 col-sm-7 col-xs-10">
						<label class="eventsFont2 samFont1"><?=$eventCounter[0]["RECEIPT_ET_NAME"]; ?></label>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-1 col-xs-2" style="padding-right:0px;"><!--<?=$_SESSION['actual_link'] ?>-->
						<a class="pull-right" style="border:none; outline:0;" href="<?php echo site_url();?>TrustReceipt/all_receipt" title="Back"><img style="border:none; outline: 0;margin-top: 5px;" src="<?php echo base_url(); ?>images/back_icon.svg"></a>
					</div>
				</div>
			</div>
			  
			  <div class="form-group">
				<span class="eventsFont2">Receipt Date: <?=$eventCounter[0]["ET_RECEIPT_DATE"];?></span>
				<span style="float:right;clear:both;" class="eventsFont2">Receipt Number: <?=$eventCounter[0]['ET_RECEIPT_NO'] ?></span>
			  </div>
				<?php if($eventCounter[0]['POSTAGE_PRICE'] != 0) { ?>
					<div class="form-group">
						<span style="float:right;font-size:18px;clear:both;"><strong>Postage Amount: </strong><?=$eventCounter[0]['POSTAGE_PRICE'] ?></span><br/>
					</div>
				<?php } ?> 
			  <div class="form-group">
				<span style="font-size:18px;"><strong>Name: </strong><?=$eventCounter[0]['ET_RECEIPT_NAME'] ?></span>
				<span style="font-size:18px;float:right;"><strong>Amount: </strong><?=$eventCounter[0]['ET_RECEIPT_PRICE'] ?></span></br>

			  </div>
			  <div class="form-group">
				<span style="font-size:18px;float:right;"><?=AmountInWords($eventCounter[0]['ET_RECEIPT_PRICE']); ?></span><br/>
			 </div>
			  <div class="form-group">
				<?php if($eventCounter[0]['ET_RECEIPT_PHONE'] != "") { ?>
					<span style="font-size:18px;"><strong>Number: </strong><?=$eventCounter[0]['ET_RECEIPT_PHONE'] ?></span>
				<?php } else if($eventCounter[0]['ET_RECEIPT_EMAIL'] != "") {	$email = 1;				?>
					<span style="font-size:18px;"><strong>Email: </strong><?=$eventCounter[0]['ET_RECEIPT_EMAIL'] ?></span>
				<?php } ?>  
				<?php if($eventCounter[0]['ET_RECEIPT_PAYMENT_METHOD'] != "") { ?>
					<span style="font-size:18px;float:right;"><strong>Mode of Payment: </strong><?=$eventCounter[0]['ET_RECEIPT_PAYMENT_METHOD'] ?></span>
				<?php if($eventCounter[0]['ET_RECEIPT_PAYMENT_METHOD'] == "Cheque") { ?><br/>
					<span style="font-size:15px;float:right;clear:both;"><strong>Cheque Number: </strong><?=$eventCounter[0]['CHEQUE_NO']; ?></span>
					<br/>
					<span style="font-size:15px;float:right;clear:both;"><strong>Cheque Date: </strong><?=$eventCounter[0]['CHEQUE_DATE']; ?></span>
					<?php if($eventCounter[0]['ET_RECEIPT_ADDRESS'] != "") { ?>
						<span style="font-size:18px;"><strong>Address: </strong><?=$eventCounter[0]['ET_RECEIPT_ADDRESS'] ?></span>
					<?php } ?>
					<br/>
					<span style="font-size:15px;float:right;clear:both;"><strong>Bank: </strong><?=$eventCounter[0]['BANK_NAME']; ?></span><br/>
					<span style="font-size:15px;float:right;clear:both;"><strong>Branch: </strong><?=$eventCounter[0]['BRANCH_NAME']; ?></span><br/>
				<?php } else if($eventCounter[0]['ET_RECEIPT_PAYMENT_METHOD'] == "Credit / Debit Card") { ?><br/>
					<span style="font-size:15px;float:right;clear:both;"><strong>Transaction Id: </strong><?=$eventCounter[0]['TRANSACTION_ID']; ?></span>
				<?php } ?>
				<?php } ?>
					<?php if($eventCounter[0]['ET_RECEIPT_EMAIL'] != "" && @$email != 1) { ?>
						<span style="font-size:18px;"><strong>Email: </strong><?=$eventCounter[0]['ET_RECEIPT_EMAIL'] ?></span>
					<?php } ?>
					<?php if($eventCounter[0]['ET_RECEIPT_PAYMENT_METHOD_NOTES'] != "") { ?>
						<span style="font-size:18px;float:right;clear:both;"><strong>Payment Notes: </strong><?=$eventCounter[0]['ET_RECEIPT_PAYMENT_METHOD_NOTES'] ?></span>
					<?php } ?>
					<br/>
					<div class="form-group">
					</br>
				<span style="font-size:18px;float:right;letter-spacing:1px;clear:both;"><strong>Issued By: </strong><?=$eventCounter[0]['ET_RECEIPT_ISSUED_BY'] ?></span><br/>
			</div>
			  </div>
			  
			  <div class="form-group">
				<center>
					<?php if($eventCounter[0]['ET_RECEIPT_ACTIVE'] == 0) { ?>
							
					<?php } else { ?>
						<button type="button" id="print" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-print"></span> Print Receipt</button>
						<?php if($this->session->userdata('userGroup') == 1 || $this->session->userdata('userGroup') == 6) { ?>
							<?php if($eventCounter[0]['AUTHORISED_STATUS'] == "No") { ?>
								<button type="button" id="cancel" onclick="show_cancelled('<?php echo $eventCounter[0]['ET_RECEIPT_ID']; ?>','<?php echo $eventCounter[0]['ET_RECEIPT_NO']; ?>')" class="btn btn-default btn-lg"><span style="top: 2px;" class="glyphicon glyphicon-remove-circle"></span> Cancel Receipt</button>
							<?php } ?>
						<?php } ?>
					<?php } ?>
				</center>
			  </div>
		</form>
	</div>
	
	<iframe style="width:76mm;height:1px;visibility:hidden;" id="printing-frame" name="print_frame" src="about:blank"></iframe>
	
<!-- Cancelled Modal2 -->
<div id="myModalCancelled" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content" style="padding-bottom:1em;">
			<div class="modal-header">
				<h4 class="modal-title">Add Cancellation Notes</h4>
				<button type="button" class="close" data-dismiss="modal" style="margin-top:-15px;">&times;</button>
			</div>
			<div class="modal-body" id="cancelleddet" style="overflow-y: auto;max-height: 330px;">
				<textarea id="cancelNotes" rows="4" cols="50" style="width: 100%; resize: vertical;overflow:hidden;"></textarea>		
				<button type="button" id="submitNotes" class="btn btn-default pull-right">SAVE</button>
			</div>
		</div>
	</div>
</div>
<form id="submitForm" action="<?php echo site_url(); ?>Receipt/save_cancel_note_event_donation/" class="form-group" role="form" enctype="multipart/form-data" method="post">
	<input type="hidden" id="rId" name="rId">
	<input type="hidden" id="rNo" name="rNo">
	<input type="hidden" id="cNote" name="cNote">
</form>	
	
<script>
	var receiptId = "<?=@$eventCounter[0]['ET_RECEIPT_ID'] ?>";
	
	//These two lines for showing re print
	if('<?php echo $eventCounter[0]['PRINT_STATUS']?>' == 1)
	$('#print').html(" Re-Print Receipt");
	
	//These three lines to show duplicate on receipt for the first time
	if('<?php echo @$duplicate; ?>' != "no") {
		if('<?php echo $eventCounter[0]['PRINT_STATUS']?>' == 1)
			$('#duplicate').show();
	}
	
	var duplicate = 0;
	
	var print = function(){
		// var newWindow = window.open();
		// newWindow.document.write('<html><head><link href="<?php echo  base_url(); ?>css/print.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/quickSand.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/fonts.googleapis.css" rel="stylesheet" type="text/css"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" crossorigin="anonymous"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-theme.min.css" crossorigin="anonymous"><link href="<?php echo  base_url(); ?>css/jquery-ui.theme.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.structure.min.css" rel="stylesheet"</head><body>');
		// newWindow.document.write($('#printScreen').html());
		// newWindow.document.write('</body></html>');
		// newWindow.document.close();
		// setTimeout(function(){ newWindow.print();newWindow.close();}, 1000);
		
		var newWin = window.frames["print_frame"]; 
		newWin.document.write('<html><head><link href="<?php echo  base_url(); ?>css/print.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/quickSand.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/fonts.googleapis.css" rel="stylesheet" type="text/css"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" crossorigin="anonymous"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-theme.min.css" crossorigin="anonymous"><link href="<?php echo  base_url(); ?>css/jquery-ui.theme.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.structure.min.css" rel="stylesheet"</head>' + '<body onload="window.print()" style="min-height:90%;">'+ $('#printScreen').html() +'</body></html>');
		newWin.document.close();
	}
	
	$('#print').on('click',function() {
		let url = "<?=site_url(); ?>Events/saveEventPrintHistory"
		$.post(url,{'receiptId':receiptId,'printStatus':1});
		if(duplicate == 1) {
			$('#duplicate').show();
		}
		print();
		$('#print').html(" Re-Print Receipt");
		duplicate++;
	});
	//location.href = "<?=site_url()?>";
	//Cancelled Model
	function show_cancelled(id,rNo) {
		$('#rId').val(id);
		$('#rNo').val(rNo);
		$('#cancelleddet').html();
		$('#myModalCancelled').modal('show');  
	}
	
	$('#cancelNotes').keyup(function() {
		if($('#cancelNotes').val() != "") {
			$('#cancelNotes').css('border-color', "#000000");
		} else {
			$('#cancelNotes').css('border-color', "#FF0000");
		}
	});
	
	$('#submitNotes').on('click', function() {
		if($('#cancelNotes').val() != "") {
			$('#cNote').val($('#cancelNotes').val());
			$('#submitForm').submit();
		} else {
			$('#myModalCancelled').effect( "shake" );
			$('#cancelNotes').css('border-color', "#FF0000");
		}
	});
</script>