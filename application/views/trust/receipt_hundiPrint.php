<!--for printing --><div id="printScreen" style="display:none">
	<page style="margin-top:25px;margin-left:75%;width:115%;margin-right:75%;margin-height:auto;">
		<form>
			<div style="margin-top:45px;"></div>
			<center><span class="eventsFont2" style="font-size:14px;font-family:switzerland;"><strong><?=$eventCounter[0]["RECEIPT_TET_NAME"]; ?></strong></span></center><br/>
			<div style="margin-top:-8px;"></div>
			<center class="eventsFont2" style="font-size:14px;font-family:switzerland;"><strong>
				<?=$templename[0]["TRUST_NAME"]?>
			</strong></center>
			<div style="margin-top:52px;"></div>
			<center style="padding-bottom:4px;"><span class="eventsFont2" style="display:none;font-size:11px;" id="duplicate"><strong><?="Duplicate";?>&nbsp;</strong></span><span class="eventsFont2" style="font-size:11px;"><strong>Hundi Receipt</strong></span></center>
			<span class="eventsFont2" style="font-size:11px;letter-spacing:1px;"><strong>Receipt Date&nbsp;</strong>: <?=$eventCounter[0]["TET_RECEIPT_DATE"];?></span><br/>
			<span class="eventsFont2" style="font-size:11px;letter-spacing:1px;"><strong>Receipt No.&nbsp;&nbsp;&nbsp;</strong>: <?=$eventCounter[0]['TET_RECEIPT_NO'] ?></span>
			<div style="margin-bottom:6px;"></div>
			<span class="eventsFont2" style="font-size:11px;letter-spacing:1px;" ><strong>Amount&nbsp;: Rs. <?=$eventCounter[0]['TET_RECEIPT_PRICE'] ?>/- <?=AmountInWords($eventCounter[0]['TET_RECEIPT_PRICE']);?></strong></span>
			<div style="margin-bottom:6px;"></div>
			<?php if($eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD_NOTES'] != "") { ?>
				<span style="font-size:11px"><strong>Payment Mode&nbsp;: </strong><?=$eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD']; ?></span><br/>
				<?php if($eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD'] == "Cheque") { ?>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Cheque Number&nbsp;: </strong><?=$eventCounter[0]['CHEQUE_NO']; ?></span>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Cheque Date&nbsp;: </strong><?=$eventCounter[0]['CHEQUE_DATE']; ?></span><br/>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Bank&nbsp;: </strong><?=$eventCounter[0]['BANK_NAME']; ?></span>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Branch&nbsp;: </strong><?=$eventCounter[0]['BRANCH_NAME']; ?></span><br/>
				<?php } else if($eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD'] == "Credit / Debit Card") { ?>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Transaction Id: </strong><?=$eventCounter[0]['TRANSACTION_ID']; ?></span><br/>
				<?php } ?>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Notes: </strong><?=$eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD_NOTES'] ?></span><br/>
			<?php } ?><br/>
			<span style="float:right;font-size:11px;letter-spacing:1px;padding-right:6px;"><strong>Issued By: </strong><?=$eventCounter[0]['TET_RECEIPT_ISSUED_BY'] ?></span>
			<center style="clear:both;font-size:20px;">*************************</center>
		</form>
	</page>
</div><!--for printing ends -->
	
<div class="container">
	<form class="form-group">
			<div class="row form-group">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-left:0px;">
					<div class="col-lg-3 col-md-4  col-sm-4 col-xs-12">
					<span class="eventsFont2" style="font-size:20px;">Trust Event Seva Receipt</span>
					</div>
					<div class="col-lg-7  col-md-6 col-sm-7 col-xs-10">
						<center><label class="eventsFont2 samFont1"><?=$eventCounter[0]["RECEIPT_TET_NAME"]; ?></label></center>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-1 col-xs-2" style="padding-right:0px;">
					<?php if(@$fromAllReceipt == "1") { ?>
					<a class="pull-right" style="border:none; outline:0;" href="<?=@$_SESSION['actual_link'] ?>" title="Back"><img style="border:none; outline: 0;margin-top: 1px;" src="<?php echo base_url(); ?>images/back_icon.svg"></a>
					<?php }else { ?>
					<a class="pull-right" style="border:none; outline:0;" href="<?=site_url() ?>Receipt/receipt_hundi" title="Back"><img style="border:none; outline: 0;margin-top: 1px;" src="<?php echo base_url(); ?>images/back_icon.svg"></a>
					<?php } ?>
					</div>
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="padding-left:0px">
				<div style="clear:both;" class="form-group">
					<span class="eventsFont2">Receipt Date: <?=$eventCounter[0]["TET_RECEIPT_DATE"];?></span></br>
				</div>
				<div style="clear:both;" class="form-group">
				
					<span style="" class="eventsFont2">Total Amount: <?=$eventCounter[0]['TET_RECEIPT_PRICE'] ?></span></br>
					<span style="" class="eventsFont2"><?=AmountInWords($eventCounter[0]['TET_RECEIPT_PRICE']);?></span></br>

				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="padding-right:0px;margin-bottom:3em;">
				  
				<div class="form-group">
					<span style="float:right" class="eventsFont2">Receipt Number: <?=$eventCounter[0]['TET_RECEIPT_NO'] ?></span>	
				</div></br>
				
				<div class="form-group">
					<?php if($eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD_NOTES'] != "") { ?>
					<span style="font-size:18px;"><strong>Event Name: </strong><?=$eventCounter[0]['RECEIPT_TET_NAME'] ?></span>
					<?php } ?>
				</div>	
				<?php if($eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD'] != "") { ?>
					<div class="form-group text-right">
						<span style="font-size:18px;"><strong>Mode of Payment: </strong><?=$eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD'] ?></span>
					</div>
				<?php } ?>
				<?php if($eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD'] == "Cheque") { ?>
					<div class="form-group text-right">
						<span style="font-size:15px;"><strong>Cheque Number: </strong><?=$eventCounter[0]['CHEQUE_NO']; ?></span>
					</div>
					<div class="form-group text-right">
						<span style="font-size:15px;"><strong>Cheque Date: </strong><?=$eventCounter[0]['CHEQUE_DATE']; ?></span>
					</div>
					<div class="form-group text-right">
						<span style="font-size:15px;"><strong>Bank: </strong><?=$eventCounter[0]['BANK_NAME']; ?></span>
					</div>
					<div class="form-group text-right">
						<span style="font-size:15px;"><strong>Branch: </strong><?=$eventCounter[0]['BRANCH_NAME']; ?></span>
					</div>
				<?php } ?>
							  
				<?php if($eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD'] == "Credit / Debit Card") { ?>
							<div class="form-group text-right">
								<span style="font-size:15px;"><strong>Transaction Id: </strong><?=$eventCounter[0]['TRANSACTION_ID']; ?></span>
							</div>
							
				<?php } ?> 
						
				<div class="form-group">
				  <?php if($eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD_NOTES'] != "") { ?>
					<span style="float:right;font-size:18px;"><strong>Payment Notes: </strong><?=$eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD_NOTES'] ?></span><br/>
				  <?php } ?>
				</div>		
						
				<span style="float:right;font-size:18px;"><strong>Issued By: </strong><?=$eventCounter[0]['TET_RECEIPT_ISSUED_BY'] ?></span>
			</div>
			  
			<div class="form-group">
				<center>
					<?php if($eventCounter[0]['TET_RECEIPT_ACTIVE'] == 0) { ?>	
						<?php } else { ?>
							<button type="button" id="print" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-print"></span> Print Receipt</button>
							<?php if($this->session->userdata('userGroup') == 1 || $this->session->userdata('userGroup') == 6) { ?>
								<?php if($eventCounter[0]['AUTHORISED_STATUS'] == "No") { ?>
									<button type="button" id="cancel" onclick="show_cancelled('<?php echo $eventCounter[0]['TET_RECEIPT_ID']; ?>','<?php echo $eventCounter[0]['TET_RECEIPT_NO']; ?>')" class="btn btn-default btn-lg"><span style="top: 2px;" class="glyphicon glyphicon-remove-circle"></span> Cancel Receipt</button>
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
				<button type="button" class="close" data-dismiss="modal" style="margin-top:-14px;">&times;</button>
				<h4 class="modal-title">Add Cancellation Notes</h4>
			</div>
			<div class="modal-body" id="cancelleddet" style="overflow-y: auto;max-height: 330px;">
				<textarea id="cancelNotes" rows="4" cols="50" style="width: 100%;resize:vertical;"></textarea>		
				<button type="button" id="submitNotes" class="btn btn-default pull-right">SAVE</button>
			</div>
		</div>
	</div>
</div>
<form id="submitForm" action="<?php echo site_url(); ?>TrustReceipt/save_cancel_note_event_hundi/" class="form-group" role="form" enctype="multipart/form-data" method="post">
	<input type="hidden" id="rId" name="rId">
	<input type="hidden" id="rNo" name="rNo">
	<input type="hidden" id="cNote" name="cNote">
</form>	
<script>
	var receiptId = "<?=@$eventCounter[0]['TET_RECEIPT_ID'] ?>";
	
	//These two lines for showing re print
	if('<?php echo $eventCounter[0]['PRINT_STATUS']?>' == 1)
	$('#print').html(" Re-Print Receipt");
	
	//These three lines to show duplicate on receipt for the first time
	if('<?php echo @$duplicate; ?>' != "no") {
		if('<?php echo $eventCounter[0]['PRINT_STATUS']?>' == 1)
			$('#duplicate').show();
	}
	
	var duplicate = 0; 
	
	var print = function() {
		var newWin = window.frames["print_frame"]; 
		newWin.document.write('<html><head><link href="<?php echo  base_url(); ?>css/print.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/quickSand.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/fonts.googleapis.css" rel="stylesheet" type="text/css"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" crossorigin="anonymous"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-theme.min.css" crossorigin="anonymous"><link href="<?php echo  base_url(); ?>css/jquery-ui.theme.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.structure.min.css" rel="stylesheet"</head>' + '<body onload="window.print()" style="min-height:90%;">'+ $('#printScreen').html() +'</body></html>');
		newWin.document.close();
	}
	
	$('#print').on('click',function() {
		let url = "<?=site_url(); ?>TrustEvents/saveEventPrintHistory"
		$.post(url,{'receiptId':receiptId,'printStatus':1});
		
		if(duplicate == 1) {
			$('#duplicate').show();
		}
		print();
		$('#print').html(" Re-Print Receipt");
		duplicate++;
	});
	
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
