<div id="A5print" style="display:none;">
<section class="sheet padding-10mm">
  <!-- <img alt = " " src="http://www.visitnorwich.co.uk/assets/Uploads/Events-images/Theatre-generic.jpg" class="testBack"> -->
<strong>
Test Name.<br/>
Test ORG.<br/>
Test Street Address.<br/>
Test City, 400123.<br/>
Test@email.com.<br/><br/>

12-02-2018<br/><br/>

Receipe Name.<br/>
Receipe Ingredients.<br/>
Receipe flavour, 20deg.<br/><br/>

Dear Receipe,<br/><br/>

</strong>
Thank you so much for very generous donation of <strong>6000</strong> to <strong>Test ORG </strong>received on <strong>12-02-2018.</strong><br/><br/>

Briefly mention your organisation and tie it back into specifice event or request the resulted in the donation.<br/><br/>

Provide some personal details about how the donor's gift will be used or their specific role in reaching your organisation's goals.<br/><br/>

Close with another round of thanks and refernce future needs or requests.<br/><br/>
<strong>
Respectfully,<br/><br/>
Signture<br/><br/>
Test name<br/>
Test title<br/><br/>
</strong>
<hr/>
<center>Donation Receipt - Keep for your records </center><br/>
<table style="border:none;">
  <tr>
    <td>
      <strong>Organisation: </strong>
    </td>
    <td>
      Test ORG
    </td>
  </tr>
  <tr>
    <td>
      <strong>Date Received: </strong>
    </td>
    <td>
      09-02-2018
    </td>
  </tr>
  <tr>
    <td>
      <strong>Cash Contribution: </strong>
    </td>
    <td>
      09-02-2018
    </td>
  </tr>
  <tr>
    <td>
      <strong>Item Contribution: </strong>
    </td>
    <td>
      Describes items donated
    </td>
  </tr>
</table><br/>
<em>(if you provide goods or services in exchange for the contribution see IRS publication 1771 to determine if you should include the folloing two paragraphs instead of the above sentence)</em>
  </section>
</div>
<!--for printing --><div id="printScreen" style="display:none">
<page style="margin-top:25px;margin-left:75%;width:115%;margin-right:75%;">
	<form>
		<br/>
		<center class="eventsFont2" style="font-size:14px;margin-top:8px;font-family:switzerland;"><strong>
			<?=$templename[0]["TEMPLE_NAME"]?>		
		</strong></center>
		<center style="margin-top:75px;"><span class="eventsFont2" style="display:none;font-size:11px;padding-bottom:4px;" id="duplicate"><strong><?="Duplicate";?>&nbsp;</strong></span><span class="eventsFont2" style="font-size:11px;padding-bottom:4px;"><strong>Donation Receipt</strong></span></center>
		<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Receipt Date&nbsp;: </strong><?=$deityCounter[0]["RECEIPT_DATE"];?></span><br/>
		<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Receipt No&nbsp;&nbsp;&nbsp;&thinsp;: </strong><?=$deityCounter[0]['RECEIPT_NO'] ?></span><br/>
		<div style="margin-bottom:5px;"></div>
		<span style="font-size:11px;"><strong>Name&nbsp;&nbsp;&nbsp;&thinsp;&thinsp;: <?=$deityCounter[0]['RECEIPT_NAME'] ?></strong></span><br/>
		<?php if($deityCounter[0]['RECEIPT_PHONE'] != "") { ?>
			<span style="font-size:11px;"><strong>Number&nbsp;: </strong><?=$deityCounter[0]['RECEIPT_PHONE'] ?></span><br/>
		<?php } else { ?>
			<span style="font-size:11px;"><strong>Number&nbsp;: </strong><?=$deityCounter[0]['RECEIPT_PHONE'] ?></span><br/>
		<?php } ?>
		<?php if($deityCounter[0]['RECEIPT_EMAIL'] != "") { ?>
			<span style="font-size:11px;"><strong>Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&thinsp;: </strong><?=$deityCounter[0]['RECEIPT_EMAIL'] ?></span><br/>
		<?php } else { ?>
			<span style="font-size:11px;"><strong>Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&thinsp;: </strong><?=$deityCounter[0]['RECEIPT_EMAIL'] ?></span><br/>
		<?php } ?>
		<?php if($deityCounter[0]['RECEIPT_ADDRESS'] != "") { ?>
			<span style="font-size:11px;"><strong>Address&nbsp;&thinsp;: </strong><?=$deityCounter[0]['RECEIPT_ADDRESS'] ?></span>
			<div style="margin-bottom:5px;"></div>
		<?php } else { ?>
			<span style="font-size:11px;"><strong>Address&nbsp;&thinsp;: </strong><?=$deityCounter[0]['RECEIPT_ADDRESS'] ?></span>
			<div style="margin-bottom:5px;"></div>
		<?php } ?>
		<span style="font-size:11px;"><strong>Deity&nbsp;: <?=$deityCounter[0]["RECEIPT_DEITY_NAME"]; ?></span></strong><br/>
		<span style="font-size:11px;" class="eventsFont2" ><strong>Amount&nbsp;: Rs. <?=$deityCounter[0]['RECEIPT_PRICE'] ?>/- <?=AmountInWords($deityCounter[0]['RECEIPT_PRICE']);?></strong></span><br/>
		<div style="margin-bottom:5px;"></div>
		<?php if($deityCounter[0]['POSTAGE_PRICE'] != 0) { ?>
		<span style="font-size:11px;" class="eventsFont2"><strong>Postage&nbsp;: Rs. <?=$deityCounter[0]['POSTAGE_PRICE']; ?><?=AmountInWords($deityCounter[0]['POSTAGE_PRICE']);?></strong></span><br/>
		<?php } ?>
		<span style="font-size:11px;"><strong>Payment Mode&nbsp;: </strong><?=$deityCounter[0]['RECEIPT_PAYMENT_METHOD']; ?></span><br/>
		<?php if($deityCounter[0]['RECEIPT_PAYMENT_METHOD'] == "Cheque") { ?>
			<span style="font-size:11px;"><strong>Cheque Number&nbsp;: </strong><?=$deityCounter[0]['CHEQUE_NO']; ?></span>
			<span style="font-size:11px;"><strong>Cheque Date&nbsp;: </strong><?=$deityCounter[0]['CHEQUE_DATE']; ?></span>
			<span style="font-size:11px;"><strong>Bank&nbsp;: </strong><?=$deityCounter[0]['BANK_NAME']; ?></span>
			<span style="font-size:11px;"><strong>Branch&nbsp;: </strong><?=$deityCounter[0]['BRANCH_NAME']; ?></span><br/>
		<?php } else if($deityCounter[0]['RECEIPT_PAYMENT_METHOD'] == "Credit / Debit Card") { ?>
			<span style="font-size:11px;"><strong>Transaction Id&nbsp;: </strong><?=$deityCounter[0]['TRANSACTION_ID']; ?></span><br/>
		<?php } ?>
			<?php if($deityCounter[0]['RECEIPT_PAYMENT_METHOD_NOTES'] != "") { ?>
				<span style="font-size:11px;"><strong>Notes&nbsp;: </strong><?=$deityCounter[0]['RECEIPT_PAYMENT_METHOD_NOTES'] ?></span><br/>
			<?php } ?><br/>
			<span style="font-size:11px;float:right;letter-spacing:1px;"><strong>Issued By&nbsp;: </strong><?=$deityCounter[0]['RECEIPT_ISSUED_BY'] ?></span><br/>
			<center style="clear:both;font-size: 20px;">*************************</center>
	</form>
</page>	

</div><!--for printing ends -->
<div class="container">
	<form class="form-group">
		<div class="row form-group">
			<div class="col-lg-6 eventsFont2" style="font-size:25px">Deity Donation Print</div>
			<div class="col-lg-6" style="margin-top:0.2em;margin-bottom:3em;padding-right:15px;">
				<div class="form-group">
					<?php if(@$fromAllReceipt == "1") { ?>
						<a class="pull-right" style="border:none; outline:0;" href="<?=$_SESSION['actual_link'] ?>" title="Back"><img alt = " " style="border:none; outline: 0;" src="<?php echo base_url(); ?>images/back_icon.svg"></a>
					<?php }else { ?>
						<a class="pull-right" style="border:none; outline:0;" href="<?=site_url() ?>Receipt/receipt_deity_donation" title="Back"><img alt = " " style="border:none; outline: 0;" src="<?php echo base_url(); ?>images/back_icon.svg"></a>
					<?php } ?>
				</div>
			</div>
		</div>  
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="padding-left:0px">
			<div class="form-group">
				<span class="eventsFont2">Receipt Date: <?=$deityCounter[0]["RECEIPT_DATE"];?></span>
			</div>
		  
			<div class="form-group">
				<span style="font-size:18px;"><strong>Name: </strong><?=$deityCounter[0]['RECEIPT_NAME'] ?></span>
			</div>
	 
			<div class="form-group">
				<span style="font-size:18px;"><strong>Deity: </strong><?=$deityCounter[0]["RECEIPT_DEITY_NAME"]; ?></span>
			</div>
		  
			<?php if($deityCounter[0]['RECEIPT_PHONE'] != "") { ?>
				<div class="form-group">
					<span style="font-size:18px;"><strong>Number: </strong><?=$deityCounter[0]['RECEIPT_PHONE'] ?></span>
				</div>
			<?php } ?>
		  
			<?php if($deityCounter[0]['RECEIPT_EMAIL'] != "") { ?>
				<div class="form-group">
					<span style="font-size:18px;"><strong>Email: </strong><?=$deityCounter[0]['RECEIPT_EMAIL'] ?></span>
				</div>
			<?php } ?>
		  
			
			<?php if($deityCounter[0]['RECEIPT_ADDRESS'] != "") { ?>
				<div class="form-group">
					<span style="font-size:18px;"><strong>Address: </strong><?=$deityCounter[0]['RECEIPT_ADDRESS'] ?></span>
				</div>
			<?php } ?>
		</div>
		  
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="padding-right:0px;margin-bottom:3em;">
			<div class="form-group text-right">
				<span style="clear:both;" class="eventsFont2">Receipt Number: <?=$deityCounter[0]['RECEIPT_NO'] ?></span>
			</div>
			<?php if($deityCounter[0]['POSTAGE_PRICE'] != 0) { ?>
				<div class="form-group">
					<span style="float:right;font-size:18px;margin-left:15px;"><strong>Postage Amount: </strong><?=$deityCounter[0]['POSTAGE_PRICE'] ?></span><br/>
				</div>
			<?php } ?>  
			<div class="form-group text-right">
				<span style="font-size:18px;"><strong>Amount: </strong><?=$deityCounter[0]['RECEIPT_PRICE'] ?></span>
			</div>
			<div class="form-group text-right">
				<span style="font-size:18px;"><?=AmountInWords($deityCounter[0]['RECEIPT_PRICE']);?></span>
			</div>
			
				<?php if($deityCounter[0]['RECEIPT_PAYMENT_METHOD'] != "") { ?>
					<div class="form-group text-right">
						<span style="font-size:18px;"><strong>Mode of Payment: </strong><?=$deityCounter[0]['RECEIPT_PAYMENT_METHOD'] ?></span>
					</div>
				<?php } ?>
			  
				<?php if($deityCounter[0]['RECEIPT_PAYMENT_METHOD'] == "Cheque") { ?>
					<div class="form-group text-right">
						<span style="font-size:15px;"><strong>Cheque Number: </strong><?=$deityCounter[0]['CHEQUE_NO']; ?></span>
					</div>
					<div class="form-group text-right">
						<span style="font-size:15px;"><strong>Cheque Date: </strong><?=$deityCounter[0]['CHEQUE_DATE']; ?></span>
					</div>
					<div class="form-group text-right">
						<span style="font-size:15px;"><strong>Bank: </strong><?=$deityCounter[0]['BANK_NAME']; ?></span>
					</div>
					<div class="form-group text-right">
						<span style="font-size:15px;"><strong>Branch: </strong><?=$deityCounter[0]['BRANCH_NAME']; ?></span>
					</div>
			  <?php } ?>
			  
			   <?php if($deityCounter[0]['RECEIPT_PAYMENT_METHOD'] == "Credit / Debit Card") { ?>
					<div class="form-group text-right">
						<span style="font-size:15px;"><strong>Transaction Id: </strong><?=$deityCounter[0]['TRANSACTION_ID']; ?></span>
					</div>
				<?php } ?> 
				
				<?php if($deityCounter[0]['RECEIPT_PAYMENT_METHOD_NOTES'] != "") { ?>
					<div class="form-group text-right">
						<span style="font-size:18px;"><strong>Payment Notes: </strong><?=$deityCounter[0]['RECEIPT_PAYMENT_METHOD_NOTES'] ?></span>
					</div>
				<?php } ?>
			
			</div>
			  
			<div style="clear:both;" class="form-group">
				<center>
					<?php if($deityCounter[0]['RECEIPT_ACTIVE'] == 0) { ?>
						
					<?php } else { ?>
						<button type="button" id="print" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-print"></span> Print Receipt</button>
						<?php if($this->session->userdata('userGroup') == 1 || $this->session->userdata('userGroup') == 6) { ?>
							<?php if($deityCounter[0]['AUTHORISED_STATUS'] == "No") { ?>
								<button type="button" id="cancel" onclick="show_cancelled('<?php echo $deityCounter[0]['RECEIPT_ID']; ?>','<?php echo $deityCounter[0]['RECEIPT_NO']; ?>')" class="btn btn-default btn-lg"><span style="top: 2px;" class="glyphicon glyphicon-remove-circle"></span> Cancel Receipt</button>
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
<form id="submitForm" action="<?php echo site_url(); ?>Receipt/save_cancel_note_donation/" class="form-group" role="form" enctype="multipart/form-data" method="post">
	<input type="hidden" id="rId" name="rId"/>
	<input type="hidden" id="rNo" name="rNo"/>
	<input type="hidden" id="cNote" name="cNote"/>
</form>
<script>
	var receiptId = "<?=@$deityCounter[0]['RECEIPT_ID'] ?>";
	
	//these two lines are to display duplictae  
	if('<?php echo @$duplicate; ?>' != "no") {
		if('<?php echo $deityCounter[0]['PRINT_STATUS']?>' == 1)
			$('#duplicate').show();
	}
	
	//these two lines are to display re-print  
	if('<?php echo $deityCounter[0]['PRINT_STATUS']?>' == 1)
	$('#print').html(" Re-Print Receipt");
	
	var duplicate = 0; 
	
	var print = function() {
		let paidPrice = Number("<?=@$deityCounter[0]['RECEIPT_PRICE']; ?>");
		let refPrice = Number("<?=@$DEITY_DONATION_SPECIAL_RECEIPT_PRICE->PRICE; ?>");
		
		if(paidPrice >= refPrice)
			confirmMultiPrintDonationReceipt();
		else {
			var newWin = window.frames["print_frame"]; 
			newWin.document.write('<html><head><link href="<?php echo  base_url(); ?>css/print.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/quickSand.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/fonts.googleapis.css" rel="stylesheet" type="text/css"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" crossorigin="anonymous"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-theme.min.css" crossorigin="anonymous"><link href="<?php echo  base_url(); ?>css/jquery-ui.theme.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.structure.min.css" rel="stylesheet"</head>' + '<body onload="window.print()" style="min-height:90%;">'+ $('#printScreen').html() +'</body></html>');
			newWin.document.close();
		}
		//a5 print ends
	}

	$('#print').on('click',function(){
		let url = "<?=site_url(); ?>Receipt/saveDeityPrintHistory"
		$.post(url,{'receiptId':receiptId,'printStatus':1})	
		if(duplicate == 1) {
			$('#duplicate').show();
		}	 
		print();
		$('#print').html("Re-Print Receipt");
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
