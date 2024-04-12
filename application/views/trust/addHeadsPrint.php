<!--please kindly note that all the lines added here are with a purpose which is carefully handled, modify only if you have understood the worKing properly-->
<?phperror_reporting(0);?>		
<!--for printing --><div id="printScreen" style="display:none;">
<?php global $s; $s = 0; foreach($hallBookingTrust as $result) { $s++; ?>
	<page style="margin-top:25px;margin-left:75%;width:115%;margin-right:75%;margin-height:auto;">
		<form>	
			<div style="margin-top:50px;"><!--This is required for correct spacing do not remove--></div>
			<center class="eventsFont2" style="font-size:14px;font-family:switzerland;">
				<strong><?=$templename[0]["TRUST_NAME"]?></strong>
			</center>
			<div style="margin-top:80px;"><!--This is required for correct spacing do not remove--></div>
			<center class="eventsFont2" style="display:none;font-size:11px;letter-spacing:1px;" id="initial<?=$s?>"><strong><?="Hall Receipt";?></strong></center>
			<center class="eventsFont2" style="display:none;font-size:11px;letter-spacing:1px;" id="duplicate<?=$s?>"><strong><?="Duplicate Hall Receipt";?></strong></center>
			<center class="eventsFont2" style="font-size:11px;letter-spacing:1px;"><strong><?php if($hallBookingTrust[0]['PRINT_STATUS'] == 1) echo "Duplicate Hall Receipt";?>
			</strong></center>
			<div style="margin-bottom:6px;"><!--This is required for correct spacing do not remove--></div>
			<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Receipt Date&nbsp;</strong>: <?=date("d-m-Y",strtotime($result["RECEIPT_DATE"])); ?></span><br/>
			<span style="font-size:11px;letter-spacing:1px;" ><strong>Receipt No.&nbsp;&nbsp;&nbsp;</strong>: <?=$result['TR_NO'] ?></span><br/><br/>
			<span style="font-size:11px;letter-spacing:1px;"><strong>Name&emsp;&ensp;&ensp;&nbsp;&thinsp;: <?=$result['RECEIPT_NAME'] ?></strong></span><br/>
			<span style="font-size:11px;letter-spacing:1px;"><strong>Number&ensp;&ensp;&ensp;: </strong><?=@$result['RECEIPT_NUMBER'] ?></span><br/>
			<span style="font-size:11px;letter-spacing:1px;word-wrap: break-word;"><strong>Address&nbsp;&nbsp;&nbsp;&nbsp;&thinsp;: </strong><?=$result['RECEIPT_ADDRESS'] ?></span><br/>
			<div style="margin-bottom:6px;"><!--This is required for correct spacing do not remove--></div>
			<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Amount&nbsp;&nbsp;: Rs. <?=$result['FH_AMOUNT'] ?>/- <?=AmountInWords($result['FH_AMOUNT']);?></strong></span><br/>
			<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Towards&nbsp;: <?=$result['FH_NAME'] ?></strong></span><br/>
			<div style="margin-bottom:6px;"><!--This is required for correct spacing do not remove--></div>
			<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Payment Mode&nbsp;&nbsp;&nbsp;&thinsp;&thinsp;: </strong><?=$result['RECEIPT_PAYMENT_METHOD'] ?></span><br/>
			<?php if($result["RECEIPT_PAYMENT_METHOD"] == "Cheque") { ?>
				<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2">Cheque Number&nbsp;: <?=$result['CHEQUE_NO'] ?></span>
				<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2">Cheque Date&nbsp;: <?=$result['CHEQUE_DATE'] ?></span><br/>
				<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2">Bank&nbsp;: <?=$result['BANK_NAME'] ?></span>
				<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2">Branch&nbsp;: <?=$result['BRANCH_NAME'] ?></span><br/>
			<?php } else if($result["RECEIPT_PAYMENT_METHOD"] == "Credit / Debit Card") { ?>
				<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2">Transaction Id&nbsp;: <?=$result['TRANSACTION_ID'] ?></span><br/>
			<?php }  ?>
			<br/><!-- <br/> -->
			<span style="font-size:11px;float:right;letter-spacing:1px;"><strong>Issued By&nbsp;</strong>: <?=$result['ENTERED_BY_NAME'] ?></span><br/>
			<center style="clear:both;font-size:20px;">*************************</center><br/><br/>
		</form>
	</page>
<?php } ?>

<?php global $t; $t = 0; foreach($hallBookingTemple as $result) { $t++; ?>
	<page style="margin-top:25px;margin-left:75%;width:115%;margin-right:75%;margin-height:auto;">
		<form>
			<div style="margin-top:50px;"></div>
			<center class="eventsFont2" style="font-size:14px;font-family:switzerland;">
				<strong><?=$templename[0]["TEMPLE_NAME"]?></strong>
			</center>
			<div style="margin-top:80px;"></div>
			<center class="eventsFont2" style="font-size:11px;letter-spacing:1px;">
			<span class="eventsFont2" style="font-size:11px;letter-spacing:1px;"><strong><?php if($hallBookingTemple[0]['PRINT_STATUS'] == 1) echo "Duplicate" ?></strong></span>
			<span  class="eventsFont2" style="display:none;font-size:11px;letter-spacing:1px;" id="duplicates<?=$t?>"><strong>Duplicate</strong></span>
			<?php if($result["RECEIPT_CATEGORY_ID"] == "2") { ?>
			<strong> Donation Receipt</strong>
			<?php } else if($result["RECEIPT_CATEGORY_ID"] == "6") { ?>
			<strong> S.R.N.S Fund Receipt</strong>
			<?php } else { ?>
			<strong> Kanike Receipt</strong>
			<?php } ?>
			</center>
			<div style="margin-bottom:6px;"><!--This is required for correct spacing do not remove--></div>
			<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Receipt Date&nbsp;</strong>: <?=date("d-m-Y",strtotime($result["RECEIPT_DATE"])); ?></span><br/>
			<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Receipt No.&nbsp;&nbsp;&nbsp;</strong>: <?=$result['RECEIPT_NO']; ?></span>
			<div style="margin-bottom:6px;"><!--This is required for correct spacing do not remove--></div>
			<span style="font-size:11px;letter-spacing:1px;"><strong>Deity&nbsp;: <?=$result['RECEIPT_DEITY_NAME']; ?></strong></span><br/>
			<div style="margin-bottom:6px;"><!--This is required for correct spacing do not remove--></div>
			<span style="font-size:11px;letter-spacing:1px;"><strong>Name&nbsp;&nbsp;&nbsp;&nbsp;&thinsp;: <?=$result['RECEIPT_NAME']; ?></strong></span><br/>
			<span style="font-size:11px;letter-spacing:1px;"><strong>Number&nbsp;&thinsp;: </strong><?=$result['RECEIPT_PHONE']; ?></span><br/>
			<span style="font-size:11px;letter-spacing:1px;word-wrap: break-word;"><strong>Address&nbsp;&thinsp;: </strong><?=$result['RECEIPT_ADDRESS'] ?></span><br/>
			<div style="margin-bottom:6px;"><!--This is required for correct spacing do not remove--></div>
			<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Amount&nbsp;: Rs. <?=$result['RECEIPT_PRICE']; ?>/- <?=AmountInWords($result['RECEIPT_PRICE']);?></strong></span>
			<div style="margin-bottom:6px;"><!--This is required for correct spacing do not remove--></div>
			<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Payment Mode&nbsp;: </strong><?=$result['RECEIPT_PAYMENT_METHOD']; ?></span><br/>
			<?php if($result["RECEIPT_PAYMENT_METHOD"] == "Cheque") { ?>
				<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2">Cheque No&nbsp;: <?=$result['CHEQUE_NO']; ?></span><br/>
				<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2">Cheque Date&nbsp;: <?=$result['CHEQUE_DATE']; ?></span><br/>
				<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2">Bank&nbsp;: <?=$result['BANK_NAME']; ?></span><br/>
				<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2">Branch&nbsp;: <?=$result['BRANCH_NAME']; ?></span><br/>
				<?php } else if($result["RECEIPT_PAYMENT_METHOD"] == "Credit / Debit Card") { ?>
				<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2">Transaction Id&nbsp;: <?=$result['TRANSACTION_ID']; ?></span><br/>
				<?php }  ?>
			<br/><!-- <br/> -->
			<span style="font-size:11px;float:right;letter-spacing:1px;"><strong>Issued By&nbsp;</strong>: <?=$result['RECEIPT_ISSUED_BY']; ?></span><br/>
			<center style="clear:both;font-size: 20px;">*************************</center>
		</form>
	</page>
<?php } ?>
</div><!--for printing ends -->

<div class="container">
	<form class="row">
		  <div class="form-group">
			<center><label class="eventsFont2 samFont1"><?="Hall Booking Details" ?></label></center>
			<?php if(@$fromAllReceipt == "1") { ?>
				<a class="pull-right" style="border:none; outline:0;" href="<?=$_SESSION['actual_link'] ?>" title="Back"><img style="border:none; outline: 0;margin-top: -71px;" src="<?php echo base_url(); ?>images/back_icon.svg"></a>
			<?php }else { ?>
				<a class="pull-right" style="border:none; outline:0;" href="<?=site_url() ?>SevaBooking/" title="Back"><img style="border:none; outline: 0;margin-top: -71px;" src="<?php echo base_url(); ?>images/back_icon.svg"></a>
			<?php } ?>
		  </div>
			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<div class="col-lg-12" style="margin-left: -31px;">
					<div class="form-group">
						<span class="eventsFont2">Date: <?=date("d-m-Y",strtotime($hallBooking[0]["HB_DATE"])); ?></span>
					</div>
				</div>

				<div class="col-lg-12" style="margin-left: -31px;">
					<div class="form-group">
						<span class="eventsFont2">Booking No: <?=$hallBooking[0]['HB_NO']; ?></span>
					</div>
				</div>
				
				<div class="col-lg-12" style="margin-left: -31px;">
					<div class="form-group">
						<span style="font-size:18px;"><strong>Name: </strong><?=$hallBooking[0]['HB_NAME'] ?></span>
					</div>
				</div>
			</div>
			
			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<?php if($hallBooking[0]['HB_ADDRESS'] != "") { ?>
					<div class="col-lg-12 text-right" style="width:105%;">  
						<div class="form-group" style="">
							
								<span style="font-size:18px;word-wrap: break-word;"><strong>Address: </strong><?=$hallBooking[0]['HB_ADDRESS'] ?></span>
							
						</div>
					</div>
				<?php } ?>

				<?php if($hallBooking[0]['HB_NUMBER'] != "") { ?>
					<div class="col-lg-12 text-right" style="clear:both;width:105%;">  
						<div class="form-group">
							
								<span style="font-size:18px;"><strong>Number: </strong><?=$hallBooking[0]['HB_NUMBER'] ?></span>
							
						</div>
					</div>
				<?php } ?>
			</div>
		  
		  <div class="clear:both;table-responsive">
			<table id="eventSeva" class="table table-bordered table-hover">
				<thead>
				  <tr>
					<th>Hall Name</th>
					<th>Function Type</th>
					<th>Date</th>
					<th>From</th>
					<th>To</th>
				  </tr>
				</thead>
				<tbody id="eventUpdate">
				<?php 
				$i = 1;
				
				$subTotal = 0;
				foreach($hallBooking as $result) {
					echo "<tr><td>". $result["H_NAME"]."</td>";
					echo "<td>". $result["FN_NAME"]."</td>";
					echo "<td>". $result["HB_BOOK_DATE"]."</td>";
					echo "<td>". date('g:i a', strtotime($result["HB_BOOK_TIME_FROM"]))."</td>";
					echo "<td>". date('g:i a', strtotime($result["HB_BOOK_TIME_TO"]))."</td></tr>";
				}
				?>
				</tbody>
			</table>
		  </div>
	</form>

	
	<div class="row" style="width:105.6%">
		<?php if(count($hallBookingTrust) != 0) { ?>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="margin-left: -17px;">
			<div class="clear:both;table-responsive">
				<table id="eventSeva" class="table table-bordered table-hover">
					<thead>
					<tr><td colspan=5><center>Trust</center></td></tr>
					<tr><th>Hall Book No.</th>
						<th>Name</th>
						<th>Amount</th>
						<th>Payment Details</th>
						<th>Notes</th>
					</tr>
					</thead>
					<tbody id="eventUpdate">
					<?php 
						$i = 1;
						
						$subTotal = 0;
						foreach($hallBookingTrust as $result) {
							echo "<tr><td>".$result["TR_NO"]."</td>";
							echo "<td>". $result["FH_NAME"]."</td>";
							echo "<td>". $result["FH_AMOUNT"]."</td>";
							if($result["RECEIPT_PAYMENT_METHOD"] == "Cheque") {
								echo "<td>Mode of Payment: ". $result["RECEIPT_PAYMENT_METHOD"].", Cheque No: ".$result['CHEQUE_NO'].", Cheque Date: ".$result['CHEQUE_DATE'].", Bank: ".$result['BANK_NAME'].", Branch: ".$result['BRANCH_NAME'].".</td>";
							} else if($result["RECEIPT_PAYMENT_METHOD"] == "Credit / Debit Card") {
								echo "<td>Mode of Payment: ". $result["RECEIPT_PAYMENT_METHOD"].", Transaction Id: ".$result['TRANSACTION_ID']."</td>";
							}else {
								echo "<td>Mode of Payment: ". $result["RECEIPT_PAYMENT_METHOD"]."</td>";
							}
							echo "<td>". $result["TR_PAYMENT_METHOD_NOTES"]."</td>";
						}
					?>
					</tbody>
				</table>
			</div>
			<?php } ?>
		</div>
		<?php if(count($hallBookingTemple) != 0) { ?>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		  <div class="clear:both;table-responsive">
			<table id="eventSeva" class="table table-bordered table-hover">
				<thead>
				<tr><td colspan=5><center>Temple</center></td></tr>
				  <tr>
					<th>Hall Book No.</th>
					<th>Name</th>
					<th>Amount</th>
					<th>Payment Details</th>
					<th>Notes</th>
				  </tr>
				</thead>
				<tbody id="eventUpdate">
				<?php 
					$i = 1;
					$subTotal = 0;
					foreach($hallBookingTemple as $result) {
						echo "<tr><td>".$result["RECEIPT_NO"]."</td>";
						if($result["RECEIPT_CATEGORY_ID"] == "2") {
							echo "<td>Donation</td>";
						} else if($result["RECEIPT_CATEGORY_ID"] == "6") {
							echo "<td>S.R.N.S Fund Receipt</td>";
						} else {
							echo "<td>Kanike</td>";
						}
						echo "<td>". $result["RECEIPT_PRICE"]."</td>";
						if($result["RECEIPT_PAYMENT_METHOD"] == "Cheque") {
							echo "<td>Mode of Payment: ". $result["RECEIPT_PAYMENT_METHOD"].", Cheque No: ".$result['CHEQUE_NO'].", Cheque Date: ".$result['CHEQUE_DATE'].", Bank: ".$result['BANK_NAME'].", Branch: ".$result['BRANCH_NAME'].".</td>";
						} else if($result["RECEIPT_PAYMENT_METHOD"] == "Credit / Debit Card") {
							echo "<td>Mode of Payment: ". $result["RECEIPT_PAYMENT_METHOD"].", Transaction Id: ".$result['TRANSACTION_ID']."</td>";
						} else {
							echo "<td>Mode of Payment: ". $result["RECEIPT_PAYMENT_METHOD"]."</td>";
						}
						echo "<td>". $result["RECEIPT_PAYMENT_METHOD_NOTES"]."</td>";
					}
				?>
				</tbody>
			</table>
		  </div>
		</div>
		<?php } ?>
	</div>
	<div class="form-group">
		<center><button type="button" id="print" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-print"></span> Print Receipt</button></center>
	</div>
</div>

<iframe style="width:76mm;height:1px;visibility:hidden;" id="printing-frame" name="print_frame" src="about:blank"></iframe>

<script>
var hallBookId = "<?=@$hallBooking[0]['HB_ID']; ?>"
var receiptId = "<?=@$hallBookingTemple[0]['RECEIPT_ID']; ?>"

	if('<?php echo @$hallBookingTrust[0]['PRINT_STATUS']?>' == 1)
		$('#print').html(" Re-Print Receipt");
	
	if('<?php echo @$hallBookingTemple[0]['PRINT_STATUS']?>' == 1)
		$('#print').html(" Re-Print Receipt");
	
	
	//these Three lines are to display duplictae  
	if('<?php echo @$hallBookingTrust[0]['PRINT_STATUS']?>' == 1)
			$('#duplicate').show();
		else{
			var i;
			for(i=1;i<'<?php $s = 0; foreach($hallBookingTrust as $result) { $s++; } echo $s+1 ?>';i++){
				if('<?php echo $result['PRINT_STATUS']?>' != 1)
					$('#initial'+i).show();	
			}
	}
	var duplicate = 0; 

var print = function() {
	var newWin = window.frames["print_frame"]; 
	newWin.document.write('<html><head><link href="<?php echo  base_url(); ?>css/print.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/quickSand.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/fonts.googleapis.css" rel="stylesheet" type="text/css"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" crossorigin="anonymous"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-theme.min.css" crossorigin="anonymous"><link href="<?php echo  base_url(); ?>css/jquery-ui.theme.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.structure.min.css" rel="stylesheet"</head>' + '<body onload="window.print()" style="min-height:90%;">'+ $('#printScreen').html() +'</body></html>');
	newWin.document.close();
}

$('#print').on('click',function() {
	let url = "<?=site_url(); ?>TrustReceipt/saveTrustPrintHistory"
	$.post(url,{'hallBookId':hallBookId,'receiptId':receiptId,'printStatus':1,'receiptFromHall':1})
	
	if(duplicate == 1) {
		var i;
		for(i=1;i<'<?php $s = 0; foreach($hallBookingTrust as $result) { $s++; } echo $s+1 ?>';i++){
		if('<?php echo $result['PRINT_STATUS']?>' != 1)
			$('#duplicate'+i).show();	
			
			$('#initial'+i).hide();
		}
		for(i=1;i<'<?php $s = 0; foreach($hallBookingTemple as $result) { $s++; } echo $s+1 ?>';i++){
		if('<?php echo $result['PRINT_STATUS']?>' != 1)
			$('#duplicates'+i).show();
		}
		
	}
	print();
	$('#print').html(" Re-Print Receipt");
	duplicate++;
});

//location.href = "<?=site_url()?>";
</script>
