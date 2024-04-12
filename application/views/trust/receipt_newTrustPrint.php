<div id="printScreen" style="display:none">
		 <page style="margin-top:25px;margin-left:75%;width:115%;margin-right:75%;">
			<form>
				<div style="margin-top:50px;"></div>
				<center><span class="eventsFont2" style="font-size:14px;font-family:switzerland;"><strong>
				<?=$templename[0]["TRUST_NAME"]?></strong>
				</span></center>
				<div style="margin-top:80px;"></div>
				<center class="eventsFont2" style="display:none;font-size:11px;letter-spacing:1px;" id="initial"><strong><?php if($trustCounter[0]["HB_ID"]!= 0) echo "Hall Receipt"; else echo "Trust Receipt"; ?></strong></center>
				<center class="eventsFont2" style="display:none;font-size:11px;letter-spacing:1px;" id="duplicate"><strong><?php if($trustCounter[0]["HB_ID"]!= 0) echo "Duplicate Hall Receipt"; else echo "Duplicate Receipt"; ?></strong></center>
				<div style="margin-bottom:6px;"></div>
				<span class="eventsFont2" style="font-size:11px;letter-spacing:1px;"><strong>Receipt Date&nbsp;: </strong><?=$trustCounter[0]["RECEIPT_DATE"];?></span><br/>
				<span class="eventsFont2" style="font-size:11px;letter-spacing:1px;"><strong>Receipt No.&nbsp;&nbsp;&nbsp;: </strong><?=$trustCounter[0]['TR_NO'] ?></span>
				<div style="margin-bottom:6px;"></div>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Name&emsp;&ensp;&ensp;&nbsp;&thinsp;: <?=$trustCounter[0]['RECEIPT_NAME'] ?></strong></span><br/>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Number&ensp;&ensp;&ensp;: </strong><?=$trustCounter[0]['RECEIPT_NUMBER'] ?></span><br/>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Email&emsp;&ensp;&nbsp;&nbsp;&thinsp;&thinsp;: </strong><?=$trustCounter[0]['RECEIPT_EMAIL'] ?></span>
				<div style="margin-bottom:6px;"></div>
				<span class="eventsFont2" style="font-size:11px;letter-spacing:1px;"><strong>Amount&nbsp;: Rs. <?=$trustCounter[0]['FH_AMOUNT'] ?>/- <?=AmountInWords($trustCounter[0]['FH_AMOUNT']);?></strong></span><br/>
				<span style="font-size:11px;"><strong>Towards&nbsp;&thinsp;&thinsp;: <?php echo $trustCounter[0]["FH_NAME"]; ?></span></strong>
				<div style="margin-bottom:6px;"></div>
				<span style="font-size:11px"><strong>Payment Mode&nbsp;&nbsp;&nbsp;&thinsp;&thinsp;: </strong><?=$trustCounter[0]['RECEIPT_PAYMENT_METHOD']; ?></span><br/>
				<?php if($trustCounter[0]['RECEIPT_PAYMENT_METHOD'] == "Cheque") { ?>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Cheque Number&nbsp;: </strong><?=$trustCounter[0]['CHEQUE_NO']; ?></span>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Cheque Date&nbsp;: </strong><?=$trustCounter[0]['CHEQUE_DATE']; ?></span><br/>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Bank&nbsp;: </strong><?=$trustCounter[0]['BANK_NAME']; ?></span>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Branch&nbsp;: </strong><?=$trustCounter[0]['BRANCH_NAME']; ?></span><br/>
				<?php } else if($trustCounter[0]['RECEIPT_PAYMENT_METHOD'] == "Credit / Debit Card") { ?>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Transaction Id&nbsp;: </strong><?=$trustCounter[0]['TRANSACTION_ID']; ?></span><br/>
				<?php } ?>
				<?php if($trustCounter[0]['RECEIPT_ADDRESS'] != "") { ?>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Address&nbsp;:</strong><?=$trustCounter[0]['RECEIPT_ADDRESS'] ?></span><br/>
				<?php } ?>
				<?php if($trustCounter[0]['TR_PAYMENT_METHOD_NOTES'] != "") { ?>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Notes&nbsp;: </strong><?=$trustCounter[0]['TR_PAYMENT_METHOD_NOTES'] ?></span><br/>
				<?php } ?><br/>
				<span style="font-size:11px;letter-spacing:1px;padding-right:8px;" class="pull-right"><strong>Issued By&nbsp;: </strong><?=$trustCounter[0]['ENTERED_BY_NAME'] ?></span>
				<center style="clear:both;font-size:25px;letter-spacing:1px;">*************************</center>
			</form>
		</page>	
</div><!--for printing ends -->

<div class="container">
		<form class="form-group">
			<div class="col-lg-12" style="z-index: 15;">
				<div class="form-group">
					<?php if(@$fromAllReceipt == "1") { ?>
						<a class="pull-right" style="border:none; outline:0; " href="<?=$_SESSION['actual_link'] ?>" title="Back"><img style="border:none; outline: 0;" src="<?php echo base_url(); ?>images/back_icon.svg"></a>
					<?php } else { ?>
						<a class="pull-right" style="border:none; outline:0;" href="<?=$_SESSION['actual_link']; ?>" title="Back"><img style="border:none; outline: 0;" src="<?php echo base_url(); ?>images/back_icon.svg"></a>
					<?php } ?>
				</div>
			</div>
			<div class="col-lg-12">
				<p style="text-align:center; margin-top:-28px;" class="samFont1">Trust Receipt</p>
			</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="form-group">
						<span class="eventsFont2">Receipt Date: <?=$trustCounter[0]["RECEIPT_DATE"];?></span>
					</div>
				  
					<div class="form-group">
						<span style="font-size:18px;"><strong>Name: </strong><?=$trustCounter[0]['RECEIPT_NAME'] ?></span>
					</div>
			 
					<div class="form-group">
						<span style="font-size:18px;"><strong>Financial Head: </strong><?=$trustCounter[0]["FH_NAME"]; ?></span>
					</div>
				  
					<?php if($trustCounter[0]['RECEIPT_NUMBER'] != "") { ?>
						<div class="form-group">
							<span style="font-size:18px;"><strong>Number: </strong><?=$trustCounter[0]['RECEIPT_NUMBER'] ?></span>
						</div>
					<?php } ?>
				  
					<?php if($trustCounter[0]['RECEIPT_EMAIL'] != "") { ?>
						<div class="form-group">
							<span style="font-size:18px;"><strong>Email: </strong><?=$trustCounter[0]['RECEIPT_EMAIL'] ?></span>
						</div>
					<?php } ?>
				  
					
					<?php if($trustCounter[0]['RECEIPT_ADDRESS'] != "") { ?>
						<div class="form-group">
							<span style="font-size:18px;"><strong>Address: </strong><?=$trustCounter[0]['RECEIPT_ADDRESS'] ?></span>
						</div>
					<?php } ?>
				</div>
			  
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="form-group text-right">
						<span style="clear:both;" class="eventsFont2">Receipt Number: <?=$trustCounter[0]['TR_NO'] ?></span>
					</div>
				
					<div class="form-group text-right">
						<span style="font-size:18px;"><strong>Amount: </strong><?=$trustCounter[0]['FH_AMOUNT'] ?></span><br/>
					</div>
					<!-- pra -->
						<div class="form-group text-right">
							<span style="font-size:18px;float:right;"><?=AmountInWords($trustCounter[0]['FH_AMOUNT']); ?></span></br>
					   </div>
				
					<?php if($trustCounter[0]['RECEIPT_PAYMENT_METHOD'] != "") { ?>
						<div class="form-group text-right">
							<span style="font-size:18px;"><strong>Mode of Payment: </strong><?=$trustCounter[0]['RECEIPT_PAYMENT_METHOD'] ?></span>
						</div>
					<?php } ?>
				  
					<?php if($trustCounter[0]['RECEIPT_PAYMENT_METHOD'] == "Cheque") { ?>
						<div class="form-group text-right">
							<span style="font-size:15px;"><strong>Cheque Number: </strong><?=$trustCounter[0]['CHEQUE_NO']; ?></span>
						</div>
						<div class="form-group text-right">
							<span style="font-size:15px;"><strong>Cheque Date: </strong><?=$trustCounter[0]['CHEQUE_DATE']; ?></span>
						</div>
						<div class="form-group text-right">
							<span style="font-size:15px;"><strong>Bank: </strong><?=$trustCounter[0]['BANK_NAME']; ?></span>
						</div>
						<div class="form-group text-right">
							<span style="font-size:15px;"><strong>Branch: </strong><?=$trustCounter[0]['BRANCH_NAME']; ?></span>
						</div>
				  <?php } ?>
				  
				   <?php if($trustCounter[0]['RECEIPT_PAYMENT_METHOD'] == "Credit / Debit Card") { ?>
						<div class="form-group text-right">
							<span style="font-size:15px;"><strong>Transaction Id: </strong><?=$trustCounter[0]['TRANSACTION_ID']; ?></span>
						</div>
					<?php } ?> 
					
					<?php if($trustCounter[0]['TR_PAYMENT_METHOD_NOTES'] != "") { ?>
						<div class="form-group text-right">
							<span style="font-size:18px;"><strong>Payment Notes: </strong><?=$trustCounter[0]['TR_PAYMENT_METHOD_NOTES'] ?></span>
						</div>
					<?php } ?>
					
					<?php if($trustCounter[0]['ENTERED_BY_NAME'] != "") { ?>
						<div class="form-group text-right">
							<span style="font-size:18px;"><strong>Issued By: </strong><?=$trustCounter[0]['ENTERED_BY_NAME'] ?></span>
						</div>
					<?php } ?>
				
				</div>
			  
			  <div style="clear:both;" class="form-group">
					<center>
						<?php if($trustCounter[0]['TR_ACTIVE'] == 0) { ?>
							
						<?php } else { ?>
							<button type="button" id="print" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-print"></span> Print Receipt</button>
							<?php if($this->session->userdata('userGroup') == 1 || $this->session->userdata('userGroup') == 6) { ?>
								<?php if($trustCounter[0]['AUTHORISED_STATUS'] == "No") { ?>
									<button type="button" id="cancel" onclick="show_cancelled('<?php echo $trustCounter[0]['TR_ID']; ?>','<?php echo $trustCounter[0]['TR_NO']; ?>')" class="btn btn-default btn-lg"><span style="top: 2px;" class="glyphicon glyphicon-remove-circle"></span> Cancel Receipt</button>
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
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Add Cancellation Notes</h4>
			</div>
			<div class="modal-body" id="cancelleddet" style="overflow-y: auto;max-height: 330px;">
				<textarea id="cancelNotes" rows="4" cols="50" style="width: 100%;"></textarea>		
				<button type="button" id="submitNotes" class="btn btn-default pull-right">SAVE</button>
			</div>
		</div>
	</div>
</div>
<form id="submitForm" action="<?php echo site_url(); ?>TrustReceipt/save_cancel_note/" class="form-group" role="form" enctype="multipart/form-data" method="post">
	<input type="hidden" id="rId" name="rId">
	<input type="hidden" id="rNo" name="rNo">
	<input type="hidden" id="cNote" name="cNote">
</form>
<script>
	var receiptId = "<?=@$trustCounter[0]['TR_ID'] ?>";
	
	//these Three lines are to display duplictae  
		if('<?php echo $trustCounter[0]['PRINT_STATUS']?>' == 1)
			$('#duplicate').show();
		else
			$('#initial').show();
	
	//these two lines are to display re-print  
	if('<?php echo $trustCounter[0]['PRINT_STATUS']?>' == 1)
		$('#print').html(" Re-Print Receipt");
	
	var duplicate = 0; 

	var print = function() {
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
		let url = "<?=site_url(); ?>TrustReceipt/saveTrustPrintHistory"
		$.post(url,{'receiptId':receiptId,'printStatus':1})
		if(duplicate == 1) {
			$('#duplicate').show();
			$('#initial').hide();
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
