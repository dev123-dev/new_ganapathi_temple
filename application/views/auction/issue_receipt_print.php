<div id="printScreen" style="display:none;">
	<page style="margin-top:25px;margin-left:75%;width:115%;margin-right:75%;">
		<form>
			<center style="margin-top:45px;"><span class="eventsFont2 " style="font-size:14px;font-family:switzerland;"><strong>
			<?=$auction_receipt[0]->AR_EVENT_NAME; ?>
			</strong></span></center><br/>
			<center class="eventsFont2" style="font-size:14px;font-family:switzerland;margin-top:-6px;">
				<strong><?=$templename[0]["TEMPLE_NAME"]?></strong>
			</center>
			<center style="margin-top:50px;"><span class="eventsFont2" style="display:none;font-size:11px;padding-bottom:4px;" id="duplicate"><strong><?="Duplicate Receipt";?></strong></span></center>
			<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Receipt Date&nbsp;: </strong><?=$auction_receipt[0]->AR_RECEIPT_DATE; ?></span><br/>
			<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Receipt No&nbsp;&nbsp;&nbsp;&thinsp;: </strong><?=$auction_receipt[0]->AR_RECEIPT_NO; ?></span><br/>
			<div style="margin-bottom:5px;"></div>
			<span style="font-size:11px;letter-spacing:1px;"><strong>Name&nbsp;&nbsp;&nbsp;&thinsp;&thinsp;: <?=$auction_receipt[0]->AR_NAME; ?></strong></span><br/>
			<span style="font-size:11px;letter-spacing:1px;"><strong>Number&nbsp;&thinsp;: </strong><?=$auction_receipt[0]->AR_NUMBER; ?></span><br/>
			<?php if($auction_receipt[0]->AR_EMAIL) { ?>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&thinsp;&nbsp;: </strong><?=$auction_receipt[0]->AR_EMAIL; ?></span><br/>
			<?php } else { ?>
				<span style="font-size:11px;"><strong>Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&thinsp;&nbsp;: </strong><?=$auction_receipt[0]->AR_EMAIL; ?></span><br/>
			<?php } ?>
			<?php if($auction_receipt[0]->AR_ADDRESS != "") { ?>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Address&nbsp;&nbsp;&nbsp;&thinsp;&thinsp;: </strong><?=$auction_receipt[0]->AR_ADDRESS; ?></span>
				<div style="margin-bottom:5px;"></div>
			<?php } else { ?>
				<span style="font-size:11px;"><strong>Address&nbsp;&nbsp;&nbsp;&thinsp;&thinsp;: </strong><?=$auction_receipt[0]->AR_ADDRESS; ?></span>
				<div style="margin-bottom:5px;"></div>
			<?php } ?>
				<span style="font-size:11px" class="eventsFont2" ><strong>Amount&nbsp;: Rs. <?=$auction_receipt[0]->AR_BID_PRICE; ?>/- <?=AmountInWords($auction_receipt[0]->AR_BID_PRICE);?></strong></span><br/>
				<span style="font-size:11px"><strong>Payment Mode&nbsp;: </strong><?=$auction_receipt[0]->AR_PAYMENT_MODE; ?></span>
				<div style="margin-bottom:5px;"></div>
			<?php if($auction_receipt[0]->AR_PAYMENT_MODE == "Cheque") { ?>
				<span style="font-size:11px;"><strong>Cheque Number&nbsp;: </strong><?=$auction_receipt[0]->AR_CHEQUE_NO; ?></span>
				<span style="font-size:11px;"><strong>Cheque Date&nbsp;: </strong><?=$auction_receipt[0]->AR_CHEQUE_DATE;  ?></span>
				<span style="font-size:11px;"><strong>Bank&nbsp;: </strong><?=$auction_receipt[0]->AR_BANK_NAME; ?></span>
				<span style="font-size:11px;"><strong>Branch&nbsp;: </strong><?=$auction_receipt[0]->AR_BRANCH_NAME; ?></span><br/>
			<?php } else if($auction_receipt[0]->AR_PAYMENT_MODE == "Credit / Debit Card") { ?><br/>
				<span style="font-size:11px;"><strong>Transaction Id&nbsp;: </strong><?=$auction_receipt[0]->AR_TRANSACTION_ID; ?></span><br/>
			<?php } ?>
			<!--<span style="font-size:18px;"><strong>Notes: </strong><?=$notes[0]->ET_RECEIPT_PAYMENT_METHOD_NOTES; ?></span>
			<br/>-->
			<span id="issuedBy" style="font-size:11px;float:right;letter-spacing:1px;"><strong>Issued By&nbsp;: </strong><?=$issuedBy[0]->USER_FULL_NAME; ?></span><br/>
			<center style="clear:both;font-size: 20px;">*************************</center><br/><br/>
		</form>
	</page>
</div>
<div class="container">
	<form class="form-group">
		<div class="col-lg-12">
			<div class="form-group">
				<center><label class="eventsFont2 samFont1"><?=$auction_receipt[0]->AR_EVENT_NAME; ?></label></center>
				<?php if(@$fromAllReceipt == "1") { ?>
					<a class="pull-right" style="border:none; outline:0;" href="<?=@$_SESSION['actual_link'] ?>" title="Back"><img style="border:none; outline: 0;margin-top: -71px;" src="<?php echo base_url(); ?>images/back_icon.svg"></a>
				<?php } else { ?>
					<a class="pull-right" style="border:none; outline:0;" href="<?=site_url() ?>Auction/issue_auction" title="Back"><img style="border:none; outline: 0;margin-top: -71px;" src="<?php echo base_url(); ?>images/back_icon.svg"></a>
				<?php } ?>
			</div>
		</div>
		  
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="form-group">
				<label for="receiptDate" style="font-size:18px;"><strong>Receipt Date: </label></strong>
				<span style="font-size:16px;" class=""><?php echo $auction_receipt[0]->AR_RECEIPT_DATE; ?></span>
			</div>
	 
			<div class="form-group">
				<label for="item" style="font-size:18px;"><strong>Item: </label></strong>
				<span style="font-size:16px;" class=""><?php echo $auction_receipt[0]->AR_ITEM_NAME; ?></span>
			</div>
			
			<div class="form-group">
				<label for="name" style="font-size:18px;"><strong>Name: </label></strong>
				<span style="font-size:16px;" class=""><?php echo $auction_receipt[0]->AR_NAME; ?></span>
			</div>
		
			<div class="form-group">
				<label for="number" style="font-size:18px;"><strong>Number: </label></strong>
				<span style="font-size:16px;" class=""><?php echo $auction_receipt[0]->AR_NUMBER; ?></span>
			</div>
		  
			<?php if($auction_receipt[0]->AR_EMAIL) { ?>
				<div class="form-group">
					<label for="email" style="font-size:18px;"><strong>Email: </label></strong>
					<span style="font-size:16px;" class=""><?php echo $auction_receipt[0]->AR_EMAIL; ?></span>
				</div> 
			<?php } ?>
			
			<?php if($auction_receipt[0]->AR_ADDRESS) { ?>
				<div class="form-group">
					<label for="address" style="font-size:18px;"><strong>Address: </label></strong>
					<span style="font-size:16px;" class=""><?php echo $auction_receipt[0]->AR_ADDRESS; ?></span>
				</div>
			<?php } ?>
			
			<!-- <?php if($auction_receipt[0]->AR_TRANSACTION_ID) { ?> -->
				<!-- <div class="form-group"> -->
					<!-- <label for="itemDetails" style="font-size:18px;"><strong>Item Details: </label></strong> -->
					<!-- <span style="font-size:16px;" class=""><?php echo $auction_receipt[0]->AR_TRANSACTION_ID; ?></span> -->
				<!-- </div> -->
			<!-- <?php } ?> -->
		</div>
		  
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="form-group text-right">
				<label for="receiptNumber" style="font-size:18px;"><strong>Receipt Number: </label></strong>
				<span style="clear:both;" class=""><?php echo $auction_receipt[0]->AR_RECEIPT_NO; ?></span>
			</div>

			<div class="form-group text-right">
				<label for="bidPrice" style="font-size:18px;"><strong>Bid Price: </label></strong>
				<span style="font-size:16px;" class="">Rs:<?php echo $auction_receipt[0]->AR_BID_PRICE; ?>/-</span>
			</div>
			
			<div class="form-group text-right">
				<label for="modeOfPayment" style="font-size:18px;"><strong>Mode Of Payment: </label></strong>
				<span style="font-size:16px;" class=""><?php echo $auction_receipt[0]->AR_PAYMENT_MODE; ?></span>
			</div> 
			
			<?php if($auction_receipt[0]->AR_CHEQUE_NO) { ?>
				<div class="form-group text-right">
					<label for="chequeNo" style="font-size:18px;"><strong>Cheque No: </label></strong>
					<span style="font-size:16px;" class=""><?php echo $auction_receipt[0]->AR_CHEQUE_NO; ?></span>
				</div>
			<?php } ?>
			
			<?php if($auction_receipt[0]->AR_CHEQUE_DATE) { ?>
				<div class="form-group text-right">
					<label for="chequeDate" style="font-size:18px;"><strong>Cheque Date: </label></strong>
					<span style="font-size:16px;" class=""><?php echo $auction_receipt[0]->AR_CHEQUE_DATE; ?></span>
					</div>
			<?php } ?>
			
			<?php if($auction_receipt[0]->AR_BANK_NAME) { ?>
				<div class="form-group text-right">
					<label for="bank" style="font-size:18px;"><strong>Bank: </label></strong>
					<span style="font-size:16px;" class=""><?php echo $auction_receipt[0]->AR_BANK_NAME; ?></span>
				</div>
			<?php } ?>
			
			<?php if($auction_receipt[0]->AR_BRANCH_NAME) { ?>
				<div class="form-group text-right">
					<label for="branch" style="font-size:18px;"><strong>Branch: </label></strong>
					<span style="font-size:16px;" class=""><?php echo $auction_receipt[0]->AR_BRANCH_NAME; ?></span>
				</div>
			<?php } ?>
			
			<?php if($auction_receipt[0]->AR_TRANSACTION_ID) { ?>
				<div class="form-group text-right">
					<label for="transactionId" style="font-size:18px;"><strong>Transaction Id: </label></strong>
					<span style="font-size:16px;" class=""><?php echo $auction_receipt[0]->AR_TRANSACTION_ID; ?></span>
				</div>
			<?php } ?>
		</div>
	  
		<div style="clear:both;" class="form-group">
			<center><button style="padding-left: 25px;padding-right: 25px;" type="button" id="print" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-print"></span> Print</button></center>
		</div>
	</form>
</div>
<iframe style="width:76mm;height:1px;visibility:hidden;" id="printing-frame" name="print_frame" src="about:blank"></iframe>
<script>
	var receiptId = "<?=$auction_receipt[0]->AR_ID;?>";
	console.log(receiptId);
	
	//These two lines for showing re print
	if('<?php echo $auction_receipt[0]->PRINT_STATUS;?>' == 1)
		$('#print').html(" Re-Print Receipt");
	
	//These three lines to show duplicate on receipt for the first time
	if('<?php echo @$duplicate; ?>' != "no") {
		if('<?php echo $auction_receipt[0]->PRINT_STATUS;?>' == 1)
			$('#duplicate').show();
	}
	
	var duplicate = 0; 
	
	var print = function() {
		
		var newWin = window.frames["print_frame"]; 
		newWin.document.write('<html><head><link href="<?php echo  base_url(); ?>css/print.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/quickSand.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/fonts.googleapis.css" rel="stylesheet" type="text/css"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" crossorigin="anonymous"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-theme.min.css" crossorigin="anonymous"><link href="<?php echo  base_url(); ?>css/jquery-ui.theme.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.structure.min.css" rel="stylesheet"</head>' + '<body onload="window.print()" style="min-height:90%;">'+ $('#printScreen').html() +'</body></html>');
		newWin.document.close();
	}
	
	$('#print').on('click',function() {
		let url = "<?=site_url(); ?>Auction/AuctionPrintStatus"
		$.post(url,{'receiptId':receiptId,'printStatus':1});
		if(duplicate == 1) {
			$('#duplicate').show();
		}
		print();
		$('#print').html(" Re-Print Receipt");
		duplicate++;
	});
</script>