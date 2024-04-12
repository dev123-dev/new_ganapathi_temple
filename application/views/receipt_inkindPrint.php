
	<!--for printing samFont1--><div id="printScreen" style="display:none">
		<page style="margin-top:25px;margin-left:75%;width:115%;margin-right:75%;">
			<form>
				<center style="margin-top:45px;"><span class="eventsFont2 " style="font-size:14px;font-family:switzerland;"><strong>
					<?=$eventCounter[0]["RECEIPT_ET_NAME"]; ?>	
				</strong></span></center><br/>
				<center class="eventsFont2" style="font-size:14px;margin-top:-6px;font-family:switzerland;"><strong>
					<?=$templename[0]["TEMPLE_NAME"]?>
				</strong></center>
				<center style="margin-top:50px;"><span class="eventsFont2" style="display:none;font-size:11px;padding-bottom:4px;" id="duplicate"><strong><?="Duplicate";?>&nbsp;</strong></span><span class="eventsFont2" style="font-size:11px;margin-top:35px;padding-bottom:4px;"><strong>InKind Receipt</strong></span></center>
				<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Receipt Date&nbsp;: </strong><?=$eventCounter[0]["ET_RECEIPT_DATE"];?></span><br/>
				<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Receipt No&nbsp;&nbsp;&nbsp;&thinsp;: </strong><?=$eventCounter[0]['ET_RECEIPT_NO'] ?></span><br/>
				<div style="margin-bottom:5px;"></div>
				<span style="font-size:11px;"><strong>Name&nbsp;&nbsp;&nbsp;&thinsp;&thinsp;: <?=$eventCounter[0]['ET_RECEIPT_NAME'] ?></strong></span><br/>
				 <?php if(trim($eventCounter[0]['ET_RECEIPT_PHONE']) != "") { ?>
					<span style="font-size:11px;"><strong>Number&nbsp;: </strong><?=$eventCounter[0]['ET_RECEIPT_PHONE'] ?></span><br/>
				<?php } else { ?>
					<span style="font-size:11px;"><strong>Number&nbsp;: </strong><?=$eventCounter[0]['ET_RECEIPT_PHONE'] ?></span><br/>
				<?php } ?>
				<?php if(trim($eventCounter[0]['ET_PAN_NO']) != "") { ?>
					<span style="font-size:11px;"><strong>Pan No&nbsp;: </strong><?=$eventCounter[0]['ET_PAN_NO'] ?></span><br/>
				<?php } else { ?>
					<span style="font-size:11px;"><strong>Pan No&nbsp;: </strong><?=$eventCounter[0]['ET_PAN_NO'] ?></span><br/>
				<?php } ?>
				<?php if(trim($eventCounter[0]['ET_RECEIPT_PHONE']) != "") { ?>
					<span style="font-size:11px;"><strong>Adhaar No&nbsp;: </strong><?=$eventCounter[0]['ET_ADHAAR_NO'] ?></span><br/>
				<?php } else { ?>
					<span style="font-size:11px;"><strong>Adhaar No&nbsp;: </strong><?=$eventCounter[0]['ET_ADHAAR_NO'] ?></span><br/>
				<?php } ?>
				<?php if($eventCounter[0]['ET_RECEIPT_EMAIL'] != "") { ?>
					<span style="font-size:11px;"><strong>Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&thinsp;: </strong><?=$eventCounter[0]['ET_RECEIPT_EMAIL'] ?></span><br/>
				<?php } else { ?>
					<span style="font-size:11px;"><strong>Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&thinsp;: </strong><?=$eventCounter[0]['ET_RECEIPT_EMAIL'] ?></span><br/>
				<?php } ?>
				<?php if($eventCounter[0]['ET_RECEIPT_ADDRESS'] != "") { ?>
					<span style="font-size:11px;"><strong>Address&nbsp;&thinsp;: </strong><?=$eventCounter[0]['ET_RECEIPT_ADDRESS']; ?></span>
					<div style="margin-bottom:5px;"></div>
				<?php } else { ?>
						<span style="font-size:11px;"><strong>Address&nbsp;&thinsp;: </strong><?=$eventCounter[0]['ET_RECEIPT_ADDRESS']; ?></span>
						<div style="margin-bottom:5px;"></div>
				<?php } ?>
				<table id="eventSeva" width="80%;" style="margin-bottom:0px;border:1px solid black;">
					<thead>
					  <tr style="border:1px solid black;">
						<th style="font-size:11px;text-align:center;border:1px solid black;">Sl. No.</th>
						<th style="font-size:11px;text-align:center;border:1px solid black;">Items</th>
						<th style="font-size:11px;text-align:center;border:1px solid black;">Qty</th>
						<th style="font-size:11px;text-align:center;border:1px solid black;">Estimated Price</th>
						<th style="font-size:11px;text-align:center;border:1px solid black;">Description</th>
					  </tr>
					</thead>
					<tbody id="eventUpdate">
					<?php 
					$i = 1;
					
					foreach($eventCounter as $result) {
						
						echo "<tr style='border:1px solid black;'><td style='font-size:11px;text-align:center;border:1px solid black;'>".$i++."</td>";
						echo "<td style='font-size:11px;border:1px solid black;text-align:left;'>". $result["IK_ITEM_NAME"]."</td>";
						echo "<td style='font-size:11px;text-align:center;border:1px solid black;'>". $result["IK_ITEM_QTY"]." " . $result["IK_ITEM_UNIT"]."</td>";
						echo "<td style='font-size:11px;border:1px solid black;text-align:left;'>". $result["IK_APPRX_AMT"]."</td>";
						echo "<td style='font-size:11px;border:1px solid black;text-align:left;'>". $result["IK_ITEM_DESC"]."</td>";
						
					}
					?>
					</tbody>
				</table>
				<div style="margin-bottom:5px;"></div>
				 <?php if($eventCounter[0]['ET_RECEIPT_PAYMENT_METHOD_NOTES'] != "") { ?>
					<span style="font-size:11px;"><strong>Notes&nbsp;: </strong><?=$eventCounter[0]['ET_RECEIPT_PAYMENT_METHOD_NOTES']; ?></span><br/>
				  <?php } else { ?>
				  <span style="font-size:11px;"><strong>Notes&nbsp;: </strong><?=$eventCounter[0]['ET_RECEIPT_PAYMENT_METHOD_NOTES']; ?></span><br/>
				  <?php } ?>
			       <span style="font-size:11px;float:right;letter-spacing:1px;"><strong>Issued By&nbsp;: </strong><?=$eventCounter[0]['ET_RECEIPT_ISSUED_BY'] ?></span>
			 	   <center style="clear:both;font-size: 20px;">*************************</center>
			</form>
		</page>
	</div><!--for printing ends -->
	
	<div class="container">
		<form class="form-group">
			<div class="form-group">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-left:0px;padding-right:0px">
					<div class="col-lg-4 col-md-4  col-sm-4 col-xs-12" style="padding-left:0px;">
						<span class="eventsFont2" style="font-size:20px;">Event Inkind Receipt</span>
					</div>
					<div class="col-lg-6  col-md-6 col-sm-7 col-xs-10">
						<label class="eventsFont2 samFont1"><?=$eventCounter[0]["RECEIPT_ET_NAME"]; ?></label>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-1 col-xs-2" style="padding-right:0px;">
						<?php if(@$fromAllReceipt == "1") { ?>
							<a class="pull-right" style="border:none; outline:0;" href="<?=$_SESSION['actual_link'] ?>" title="Back"><img style="border:none; outline: 0;margin-top: 5px;" src="<?php echo base_url(); ?>images/back_icon.svg"></a>
						<?php }else { ?>
							<a class="pull-right" style="border:none; outline:0;" href="<?=site_url() ?>Receipt/receipt_inkind" title="Back"><img style="border:none; outline: 0;margin-top: 5px;" src="<?php echo base_url(); ?>images/back_icon.svg"></a>
						<?php } ?>
					</div>
				</div>	
			</div>
			<div class="form-group">
				<span class="eventsFont2">Receipt Date: <?=$eventCounter[0]["ET_RECEIPT_DATE"];?></span>
				<span style="clear:both;float:right;font-size:18px;" class="eventsFont2">Receipt Number: <?=$eventCounter[0]['ET_RECEIPT_NO'] ?></span>
			</div>
			  
			<div class="form-group">
				<span style="font-size:18px;"><strong>Name: </strong><?=$eventCounter[0]['ET_RECEIPT_NAME'] ?></span>
				<?php if(trim($eventCounter[0]['ET_RECEIPT_PHONE']) != "") { ?>
					<span style="float:right;font-size:18px;"><strong>Number: </strong><?=$eventCounter[0]['ET_RECEIPT_PHONE'] ?></span>
				<?php } ?> 
			</div>

			<div class="form-group">
				<?php if(trim($eventCounter[0]['ET_PAN_NO']) != "") { ?>
					<span style="font-size:18px;"><strong>Pan No: </strong><?=$eventCounter[0]['ET_PAN_NO'] ?></span>
				<?php } ?> 
				<?php if(trim($eventCounter[0]['ET_ADHAAR_NO']) != "") { ?>
					<span style="float:right;font-size:18px;"><strong>Adhaar No: </strong><?=$eventCounter[0]['ET_ADHAAR_NO'] ?></span>
				<?php } ?> 
			</div>
			  
			<div class="form-group">
				<?php if($eventCounter[0]['ET_RECEIPT_EMAIL'] != "") { ?>
					<span style="float: right;font-size:18px;"><strong>Email: </strong><?=$eventCounter[0]['ET_RECEIPT_EMAIL'] ?></span>
				 <?php } ?> 
			</div>
			<div style="clear:both"></div><br/>
			<div style="clear:both;" class="table-responsive">
				<table id="eventSeva" class="table table-bordered">
					<thead>
					  <tr>
						<th>Sl. No.</th>
						<th>Items</th>
						<th>Qty</th>
						<th>Estimated Price</th>
						<th>Description</th>
					  </tr>
					</thead>
					<tbody id="eventUpdate">
					<?php 
					$i = 1;
					
					foreach($eventCounter as $result) {
						
						echo "<tr><td>".$i++."</td>";
						echo "<td>". $result["IK_ITEM_NAME"]."</td>";
						echo "<td>". $result["IK_ITEM_QTY"]." " . $result["IK_ITEM_UNIT"]."</td>";
						echo "<td>". $result["IK_APPRX_AMT"]."</td>";
						echo "<td>". $result["IK_ITEM_DESC"]."</td>";
					}
					?>
					</tbody>
				</table>
			  </div>
				<?php if($eventCounter[0]['POSTAGE_PRICE'] != 0) { ?>
					<div class="form-group">
						<span style="float:right;font-size:18px;margin-left:15px;"><strong>Postage Amount: </strong><?=$eventCounter[0]['POSTAGE_PRICE'] ?></span><br/>
					</div>
				<?php } ?> 
			   <div class="form-group">
			   <?php if($eventCounter[0]['ET_RECEIPT_ADDRESS'] != "") { ?>
					<span style="font-size:18px;"><strong>Address: </strong><?=$eventCounter[0]['ET_RECEIPT_ADDRESS']; ?></span>
			   <?php } ?>
				<!-- <?php if($eventCounter[0]['ET_RECEIPT_PAYMENT_METHOD_NOTES'] != "") { ?>
					<span style="font-size:18px;float:right;"><strong>Notes: </strong><?=$eventCounter[0]['ET_RECEIPT_PAYMENT_METHOD_NOTES']; ?></span>
				 <?php } ?> -->
			  </div>
			  
			<div class="form-group">
				<center>
						<button type="button" id="print" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-print"></span> Print Receipt</button>
				</center>
			</div>
		</form>
	</div>
	
	<iframe style="width:76mm;height:1px;visibility:hidden;" id="printing-frame" name="print_frame" src="about:blank"></iframe>

<!-- Cancelled Modal2 
	<div id="myModalCancelled" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content
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
	<form id="submitForm" action="<?php echo site_url(); ?>Receipt/save_cancel_note_event_inkind/" class="form-group" role="form" enctype="multipart/form-data" method="post">
		<input type="hidden" id="rId" name="rId">
		<input type="hidden" id="rNo" name="rNo">
		<input type="hidden" id="cNote" name="cNote">
</form>	-->	
<script>
	var receiptId = "<?=@$eventCounter[0]['ET_RECEIPT_ID'] ?>";
	
	//These two lines for showing re print
	if('<?php echo $eventCounter[0]['PRINT_STATUS']?>' == 1) {
		$('#print').html(" Re-Print Receipt");
		
	}
	
	//These Three lines to show duplicate on receipt for the first time
	if('<?php echo @$duplicate; ?>' != "no") {
		if('<?php echo $eventCounter[0]['PRINT_STATUS']?>' == 1)
			$('#duplicate').show();
	}
	
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
	/* //Cancelled Model
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
	}); */
</script>