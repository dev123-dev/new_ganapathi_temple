<?php
	$qty = [];
	$date = [];
	$sevaName = [];
	$sevaAmt = [];
	$isSeva = [];
	$actualPrice = [];
	$actualQty = [];
	$i = 0;
	$count = 1;
	foreach($eventCounter as $result) {
		$sevaName[$i] = $result["ET_SO_SEVA_NAME"];
		$date[$i] = $result["ET_SO_DATE"];
		if(intval($result["ET_SO_QUANTITY"]) != 0)
			$count = intval($result["ET_SO_QUANTITY"]);
		else 
			$count = 1;
		$qty[$i] =  intval($count);
		$sevaAmt[$i] = intval($result["ET_SO_PRICE"]);
		$actualPrice[$i] = intval($result["ET_SO_PRICE"]);
		$actualQty[$i] = intval($result["ET_SO_QUANTITY"]);
		$isSeva[$i] =  $result['ET_SO_IS_SEVA'];
		++$i;	
	}
?>
<!--for printing--><div id="printScreen" style="display:none;">
<?php $num = 0; for($s = 0; $s < count($sevaName); ++$s) { ?>
		<?php if(count($sevaName) > 1) { if($num == 0) { if($eventCounter[0]['POSTAGE_PRICE'] != 0) {?>
			<page style="margin-top:25px;margin-left:75%;width:115%;margin-right:75%;">
				<form>
					<center><span class="eventsFont2 " style="font-size:14px;margin-top:30px;margin-left:15px;font-family:switzerland;">
						<?=$eventCounter[0]["RECEIPT_ET_NAME"]; ?>
					</span></center><br/>
					<center class="eventsFont2" style="font-size:14px;margin-top:10px;font-family:switzerland;">
						<?=$templename[0]["TEMPLE_NAME"]?>
					</center>
					<center class="eventsFont2" id="duplicatePostage1"><strong><?php if($eventCounter[0]['PRINT_STATUS'] == 1) echo 'Duplicate' ?> Postage Receipt</strong>
					</center><br/>
					<center class="eventsFont2" style="display:none" id="duplicatePostage2"><strong>Duplicate Postage Receipt</strong></center><br/>
					<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2">Receipt Date: <?=$eventCounter[0]["ET_RECEIPT_DATE"];?></span><br/>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Postage: Rs. <?=$eventCounter[0]['POSTAGE_PRICE']; ?>/- <?=AmountInWords($eventCounter[0]['POSTAGE_PRICE']);?></strong></span><br/><br/>
					<span style="font-size:11px;float:right;letter-spacing:1px;">Issued By: <?=$eventCounter[0]['ET_RECEIPT_ISSUED_BY'] ?></span><br/>
					<center style="clear:both;font-size: 20px;">*************************</center>
				</form>
			</page>
		<?php $num++;}}} ?>
		<page style="margin-top:25px;margin-left:75%;width:115%;margin-right:75%;">
			<form>
				<div style="margin-top:45px;"><!--This is required for correct spacing do not remove--></div>
				<center><span class="eventsFont2 " style="font-size:14px;font-family:switzerland;"><strong>
					<?=$eventCounter[0]["RECEIPT_ET_NAME"]; ?>	
				</strong></span></center><br/>
				<div style="margin-top:-8px;"></div>
				<center class="eventsFont2" style="font-size:14px;font-family:switzerland;"><strong>
					<?=$templename[0]["TEMPLE_NAME"]?>
				</strong></center>
				<div style="margin-top:52px;"></div>	
				<center class="eventsFont2" style="display:none;font-size:11px;padding-bottom:4px;" id="sevaPrint<?php echo $s ?>"><strong>Seva Receipt</strong></center>
				<center class="eventsFont2" style="font-size:11px;padding-bottom:4px;" id="duplicate"><strong><?php if($eventCounter[0]['PRINT_STATUS'] == 1) echo 'Duplicate Seva Receipt'; ?></strong></center>
				<center class="eventsFont2" style="display:none;font-size:11px;padding-bottom:4px;" id="duplicates<?php echo $s ?>"><strong>Duplicate Seva Receipt</strong></center>
				<center class="eventsFont2" style="display:none;font-size:11px;margin-top:50px;padding-bottom:4px;" id="duplicate"><strong><?php if($eventCounter[0]['PRINT_STATUS'] == 1) echo 'Duplicate Receipt' ?></strong></center>
				<center class="eventsFont2" style="display:none;font-size:11px;margin-top:50px;padding-bottom:4px;" id="duplicates<?php echo $s ?>"><strong>Duplicate Receipt</strong></center>
				<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Receipt Date&nbsp;: </strong><?=$eventCounter[0]["ET_RECEIPT_DATE"];?></span><br/>
				<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Receipt No&nbsp;&nbsp;&nbsp;&thinsp;: </strong><?=$eventCounter[0]['ET_RECEIPT_NO'] ?></span>
				<div style="margin-bottom:5px;"></div>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Name&emsp;&ensp;&ensp;&nbsp;&thinsp;: <?=$eventCounter[0]['ET_RECEIPT_NAME'] ?></strong></span><br/>
				<?php if($eventCounter[0]['ET_RECEIPT_PHONE'] != "") { ?>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Number&ensp;&ensp;&ensp;: </strong><?=$eventCounter[0]['ET_RECEIPT_PHONE'] ?></span><br/>
				<?php }else { ?>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Number&ensp;&ensp;&ensp;: </strong><?=$eventCounter[0]['ET_RECEIPT_PHONE'] ?></span><br/>
				<?php } ?>
				<?php if($eventCounter[0]['ET_RECEIPT_RASHI'] != "") { ?>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Rashi&ensp;&ensp;&ensp;&nbsp;&nbsp;&thinsp;&thinsp;: </strong><?=$eventCounter[0]['ET_RECEIPT_RASHI'] ?></span><br/>
				<?php } else { ?>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Rashi&ensp;&ensp;&ensp;&nbsp;&nbsp;&thinsp;&thinsp;: </strong><?=$eventCounter[0]['ET_RECEIPT_RASHI'] ?></span><br/>
				<?php } ?>
				<?php if($eventCounter[0]['ET_RECEIPT_NAKSHATRA'] != "") { ?>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Nakshatra&nbsp;: </strong><?=$eventCounter[0]['ET_RECEIPT_NAKSHATRA'] ?></span><br/>
				<?php } else { ?>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Nakshatra&nbsp;: </strong><?=$eventCounter[0]['ET_RECEIPT_NAKSHATRA'] ?></span><br/>
				<?php } ?>
				<?php if($eventCounter[0]['ET_RECEIPT_ADDRESS'] != "") { ?>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Address&nbsp;&nbsp;&thinsp;&thinsp;&thinsp;: </strong><?=$eventCounter[0]['ET_RECEIPT_ADDRESS'] ?></span><br/><br/>
				<?php } ?>
				<?php if($eventCounter[0]['ET_RECEIPT_RASHI'] != "" || $eventCounter[0]['ET_RECEIPT_PHONE'] != "" || $eventCounter[0]['ET_RECEIPT_NAKSHATRA'] != "") { ?>
					<!-- <br/> -->
				<?php } ?>
				<?php 
					$subTotal = 0;
					
						$totalAmt = 0;
						
						$qty1 = intval($qty[$s]);
						
						$totalAmt = intval($actualPrice[$s]) * intval($qty1);
						
						$subTotal += $totalAmt;
					
					?> 
			
						<?php if(intval($isSeva[$s]) == 0) {
							//echo $actualPrice[$s]." x ".$qty1." = ".$sevaAmt[$s];
						 ?>
							<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Prasad&nbsp: <?=$sevaName[$s] ?></strong></span><br/>
							<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Quantity&nbsp;: <?=$qty1 ?></strong></span><br/>
							<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Price&nbsp;: Rs. <?=$actualPrice[$s]; ?>/-<?=AmountInWords($actualPrice[$s]);?></strong><br/><!-- <br/> -->
							<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Total Amount: <?=$subTotal ?><?=AmountInWords($subTotal);?></strong></span>
						<?php } else {
							//echo $sevaAmt[$s];
						 ?>
							<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Seva&nbsp;: <?=$sevaName[$s] ?></strong></span><br/>
							<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Date&nbsp;: <?=$date[$s] ?></strong></span><br/>
							<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Price&nbsp;:Rs. <?=$sevaAmt[$s]; ?>/- <?=AmountInWords($sevaAmt[$s]);?></strong></span><br/>
							<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Quantity&nbsp;: <?=$qty1 ?></strong></span><br/>
							<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Total Amount: <?=$subTotal ?><?=AmountInWords($subTotal);?></strong></span>
						<?php } ?>
					<br/><!-- <br/> -->
					<?php 
					$postage = $eventCounter[0]['POSTAGE_PRICE'];
					$price = $subTotal;
					$total = intval($price) + intval($postage);
					?>
				<?php if(count($sevaName) == 1) { ?>
				<?php if($eventCounter[0]['POSTAGE_PRICE'] != 0) { ?>				
					<span style="font-size:11px;letter-spacing:1px;"><strong>Postage: Rs. <?=$eventCounter[0]['POSTAGE_PRICE']; ?>/- <?=AmountInWords($eventCounter[0]['POSTAGE_PRICE']);?></strong></span>
					<span style="font-size:11px;letter-spacing:1px;float:right;" class="eventsFont2"><strong>Total Price&nbsp;: Rs. <?=$total;?>/- <?=AmountInWords($total);?></strong></span></br>
				<?php } ?>
				<?php } ?>
				
				<span style="font-size:11px;letter-spacing:1px;"><strong>Payment Mode&nbsp;: </strong><?=$eventCounter[0]['ET_RECEIPT_PAYMENT_METHOD']; ?></span>
				<?php if($eventCounter[0]['ET_RECEIPT_PAYMENT_METHOD'] == "Cheque") { ?>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Cheque Number&nbsp;: </strong><?=$eventCounter[0]['CHEQUE_NO']; ?></span>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Cheque Date&nbsp;: </strong><?=$eventCounter[0]['CHEQUE_DATE']; ?></span>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Bank&nbsp;: </strong><?=$eventCounter[0]['BANK_NAME']; ?></span>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Branch&nbsp;: </strong><?=$eventCounter[0]['BRANCH_NAME']; ?></span><br/>
				<?php } else if($eventCounter[0]['ET_RECEIPT_PAYMENT_METHOD'] == "Credit / Debit Card") { ?><br/>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Transaction Id&nbsp;&thinsp;: </strong><?=$eventCounter[0]['TRANSACTION_ID']; ?></span><br/>
				<?php } ?>
					<?php if($eventCounter[0]['ET_RECEIPT_PAYMENT_METHOD_NOTES'] != "") { ?>
						<span style="font-size:11px;letter-spacing:1px;"><strong>Notes&nbsp;: </strong><?=$eventCounter[0]['ET_RECEIPT_PAYMENT_METHOD_NOTES'] ?></span><br/>
					<?php } ?><br/><br/>
					<span style="font-size:11px;margin-left:25.5%;float:right;letter-spacing:1px;"><strong>Issued By&nbsp;: </strong><?=$eventCounter[0]['ET_RECEIPT_ISSUED_BY'] ?></span><br/>
					<span style="font-size:7px;letter-spacing:1px;"><strong><span style="color:red;">* </span>  Seva Prasadam should be collected on the same day of the seva </strong></span>
			</form>
		</page>
	<?php } ?>
</div><!--for printing ends -->
	
<div class="container">
	<form class="form-group">
		<div class="row form-group">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-left:0px;">
				<div class="col-lg-4 col-md-4  col-sm-4 col-xs-12">
					<span class="eventsFont2" style="font-size:20px;">Event Seva Receipt</span>
				</div>
				<div class="col-lg-6  col-md-6 col-sm-7 col-xs-10">
					<label class="eventsFont2 samFont1"><?=$eventCounter[0]["RECEIPT_ET_NAME"]; ?></label>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-1 col-xs-2" style="padding-right:0px;">
					<a class="pull-right" style="border:none; outline:0;" href="<?=$_SESSION['actual_link'] ?>" title="Back"><img style="border:none; outline: 0;margin-top: 5px;" src="<?php echo base_url(); ?>images/back_icon.svg"></a>
				</div>
			</div>
		</div>
		<div class="form-group">
			<span class="eventsFont2">Receipt Date: <?=$eventCounter[0]["ET_RECEIPT_DATE"];?></span>
			<span style="float:right;clear:both;" class="eventsFont2">Receipt Number: <?=$eventCounter[0]['ET_RECEIPT_NO'] ?></span>
		</div>
		  
		<div class="form-group">
			<span style="font-size:18px;"><strong>Name: </strong><?=$eventCounter[0]['ET_RECEIPT_NAME'] ?></span>
			<?php if($eventCounter[0]['ET_RECEIPT_RASHI'] != "") { ?>
				<span style="float:right;font-size:18px;"><strong>Rashi: </strong><?=$eventCounter[0]['ET_RECEIPT_RASHI'] ?></span>
			<?php } ?>
		</div>
		  
		<div class="form-group">
			<?php if($eventCounter[0]['ET_RECEIPT_PHONE'] != "") { ?>
				<span style="font-size:18px;"><strong>Number: </strong><?=$eventCounter[0]['ET_RECEIPT_PHONE'] ?></span>
			<?php } ?>
			<?php if($eventCounter[0]['ET_RECEIPT_NAKSHATRA'] != "") { ?>
				<span style="float:right;clear:both;font-size:18px;"><strong>Nakshatra: </strong><?=$eventCounter[0]['ET_RECEIPT_NAKSHATRA'] ?></span>
			<?php } ?>
		</div>
		  
		<div class="clear:both;table-responsive">
			<table id="eventSeva" class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>Sl. No.</th>
						<th>Seva Name</th>
						<th>Qty</th>
						<th>Seva Date</th>
						<th>Seva Amount</th>
						<th>Total Seva Amount</th>
					</tr>
				</thead>
				<tbody id="eventUpdate">
					<?php 
					$i = 1;
					
					$subTotal = 0;
					foreach($eventCounter as $result) {

						$qty = @$result["ET_SO_QUANTITY"];
						if($qty == "") {
							$qty = 1;
						}
						
						$total = ($result["ET_SO_PRICE"] * $qty);
						$subTotal += $total;
						
						echo "<tr><td>".$i++."</td>";
						echo "<td>". $result["ET_SO_SEVA_NAME"]."</td>";
						echo "<td>". $qty."</td>";
						echo "<td>". $result["ET_SO_DATE"]."</td>";
						echo "<td>". $result["ET_SO_PRICE"]."</td>";
						echo "<td>". $total ."</td></tr>";
					}
					?>
				</tbody>
			</table>
		</div>
<div class="col-lg-6">
<?php if($eventCounter[0]['ET_RECEIPT_ADDRESS'] != "") { ?>
		<div class="form-group">
			<span style="font-size:18px;"><strong>Address: </strong><?=$eventCounter[0]['ET_RECEIPT_ADDRESS'] ?></span>
		</div>
		<?php } ?>    
		<div class="form-group">
			<span style="font-size:18px"><strong>Mode Of Payment: </strong><?=$eventCounter[0]['ET_RECEIPT_PAYMENT_METHOD']; ?></span>
			<?php if($eventCounter[0]['ET_RECEIPT_PAYMENT_METHOD'] == "Cheque") { ?><br/>
				<span style="font-size:18px;"><strong>Cheque Number: </strong><?=$eventCounter[0]['CHEQUE_NO']; ?></span><br/>
				<span style="font-size:18px;"><strong>Cheque Date: </strong><?=$eventCounter[0]['CHEQUE_DATE']; ?></span><br/>
				<span style="font-size:18px;"><strong>Bank: </strong><?=$eventCounter[0]['BANK_NAME']; ?></span><br/>
				<span style="font-size:18px;"><strong>Branch: </strong><?=$eventCounter[0]['BRANCH_NAME']; ?></span><br/>
			<?php } else if($eventCounter[0]['ET_RECEIPT_PAYMENT_METHOD'] == "Credit / Debit Card") { ?><br/>
				<span style="font-size:18px;"><strong>Transaction Id: </strong><?=$eventCounter[0]['TRANSACTION_ID']; ?></span><br/>
			<?php } ?><br/>
			<?php if($eventCounter[0]['ET_RECEIPT_PAYMENT_METHOD_NOTES'] != "") { ?>
				<span style="font-size:18px;"><strong>Notes: </strong><?=$eventCounter[0]['ET_RECEIPT_PAYMENT_METHOD_NOTES'] ?></span><br/>
			<?php } ?><br/>
		</div>
</div>
		<?php if($eventCounter[0]['POSTAGE_PRICE'] != 0) { ?>
			<div class="form-group">
				<span style="float:right;font-size:18px;margin-left:15px;"><strong>Postage Amount: </strong><?=$eventCounter[0]['POSTAGE_PRICE'] ?></span><br/>
			</div>

			<div class="form-group">
				<span style="float:right;font-size:18px;margin-left:15px;"><?=AmountInWords($eventCounter[0]['POSTAGE_PRICE']);?></span><br/>
			</div>
		<?php } ?>   
		<div class="form-group">
			<span style="float:right" class="eventsFont2">Total Amount: <?=$subTotal ?></span></br>
		</div>
		<div class="form-group">
			<span style="float:right;font-size:18px;margin-left:15px;" ><?=AmountInWords($subTotal);?></span></br>
		</div>
			<span style="font-size:18px;float:right"><strong>Issued By: </strong><?=$eventCounter[0]['ET_RECEIPT_ISSUED_BY'] ?></span></br>

		
		  <div>
		<div class="form-group">
		</br>
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
<form id="submitForm" action="<?php echo site_url(); ?>Receipt/save_cancel_note_event/" class="form-group" role="form" enctype="multipart/form-data" method="post">
	<input type="hidden" id="rId" name="rId">
	<input type="hidden" id="rNo" name="rNo">
	<input type="hidden" id="cNote" name="cNote">
</form>	
<script>


	var receiptId = "<?=@$eventCounter[0]['ET_RECEIPT_ID'] ?>"
	
	//These two lines for showing re print
	if('<?php echo $eventCounter[0]['PRINT_STATUS']?>' == 1)
		$('#print').html(" Re-Print Receipt");
	
	if('<?php echo $eventCounter[0]['PRINT_STATUS']?>' != 1){
		for(i=0;i<'<?php echo count($eventCounter)?>';i++){
			$('#sevaPrint'+i).show();	
		}
	}
	
	var duplicate = 0; 
	
	var print = function() {	
		var newWin = window.frames["print_frame"]; 
		newWin.document.write('<html><head><link href="<?php echo  base_url(); ?>css/print.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/quickSand.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/fonts.googleapis.css" rel="stylesheet" type="text/css"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" crossorigin="anonymous"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-theme.min.css" crossorigin="anonymous"><link href="<?php echo  base_url(); ?>css/jquery-ui.theme.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.structure.min.css" rel="stylesheet"</head>' + '<body onload="window.print()" style="min-height:90%;">'+ $('#printScreen').html() +'</body></html>');
		newWin.document.close();
	}
	
	$('#print').on('click',function(e){
		let url = "<?=site_url(); ?>Events/saveEventPrintHistory"
		$.post(url,{'receiptId':receiptId,'printStatus':1})
		<?php if($eventCounter[0]['PRINT_STATUS'] != 1) { ?>
			if(duplicate == 1){
				var i;
				for(i=0;i<'<?php echo count($eventCounter)?>';i++){
					$('#duplicate'+i).show();
					$('#sevaPrint'+i).hide();
					$('#duplicatePostage2').show();
				}
				for(i=0;i<'<?php echo count($eventCounter)?>';i++){
					$('#duplicates'+i).show();
				}
			} else {
				$('#duplicatePostage1').hide();
			}
		<?php } else ?>
			$('#duplicate').show();
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