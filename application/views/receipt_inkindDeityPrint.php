<!--for printing --><div id="printScreen" style="display:none">
		<page style="margin-top:25px;margin-left:75%;width:115%;margin-right:75%;" data-size="A6">
			<form><br/>
				<center class="eventsFont2" style="font-size:14px;font-family:switzerland;margin-top:8px;"><strong>
					<?=$templename[0]["TEMPLE_NAME"]?>
				</strong></center>
				<center style="margin-top:75px;"><span class="eventsFont2" style="display:none;font-size:11px;padding-bottom:4px;" id="duplicate"><strong><?="Duplicate";?>&nbsp;</strong></span><span class="eventsFont2" style="font-size:11px;padding-bottom:4px;"><strong>InKind Receipt</strong></span></center>
				<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Receipt Date&nbsp;:</strong><?=$deityCounter[0]["RECEIPT_DATE"];?></span><br/>
				<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Receipt No&nbsp;&nbsp;&nbsp;&thinsp;:</strong> <?=$deityCounter[0]['RECEIPT_NO'] ?></span><br/>
				<div style="margin-bottom:5px;"></div>
				<span style="font-size:11px;"><strong>Name&nbsp;&nbsp;&nbsp;&thinsp;&thinsp;: <?=$deityCounter[0]['RECEIPT_NAME'] ?></strong></span><br/>
				 <?php if(trim($deityCounter[0]['RECEIPT_PHONE']) != "") { ?>
					<span style="font-size:11px;"><strong>Number&nbsp;: </strong><?=$deityCounter[0]['RECEIPT_PHONE'] ?></span><br/>
				 <?php } else { ?>
					<span style="font-size:11px;"><strong>Number&nbsp;: </strong><?=$deityCounter[0]['RECEIPT_PHONE'] ?></span><br/>
				<?php } ?>
				 <?php if($deityCounter[0]['RECEIPT_ADHAAR_NO'] != "") { ?>
					<span style="font-size:11px;"><strong>Adhaar No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&thinsp;: </strong><?=$deityCounter[0]['RECEIPT_ADHAAR_NO'] ?></span><br/>
				 <?php } else { ?>
					<span style="font-size:11px;"><strong>Adhaar No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&thinsp;: </strong><?=$deityCounter[0]['RECEIPT_ADHAAR_NO'] ?></span><br/>
				<?php } ?>
				<?php if($deityCounter[0]['RECEIPT_PAN_NO'] != "") { ?>
					<span style="font-size:11px;"><strong>Pan No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&thinsp;: </strong><?=$deityCounter[0]['RECEIPT_PAN_NO'] ?></span><br/>
				 <?php } else { ?>
					<span style="font-size:11px;"><strong>Pan No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&thinsp;: </strong><?=$deityCounter[0]['RECEIPT_PAN_NO'] ?></span><br/>
				<?php } ?>
				 <?php if($deityCounter[0]['RECEIPT_EMAIL'] != "") { ?>
					<span style="font-size:11px;"><strong>Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&thinsp;: </strong><?=$deityCounter[0]['RECEIPT_EMAIL'] ?></span><br/>
				 <?php } else { ?>
					<span style="font-size:11px;"><strong>Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&thinsp;: </strong><?=$deityCounter[0]['RECEIPT_EMAIL'] ?></span><br/>
				<?php } ?>
				 <?php if($deityCounter[0]['RECEIPT_ADDRESS'] != "") { ?>
					<span style="font-size:11px;"><strong>Address&nbsp;&thinsp;: </strong><?=$deityCounter[0]['RECEIPT_ADDRESS']; ?></span>
					<div style="margin-bottom:5px;"></div>
				 <?php } else { ?>
					<span style="font-size:11px;"><strong>Address&nbsp;&thinsp;: </strong><?=$deityCounter[0]['RECEIPT_ADDRESS']; ?></span>
					<div style="margin-bottom:5px;"></div>
				 <?php } ?>
				 <span style="font-size:11px;"><strong>Deity&nbsp;: <?=$deityCounter[0]["RECEIPT_DEITY_NAME"]; ?></span></strong>
				 <div style="margin-bottom:5px;"></div>
				<table id="eventSeva" width="80%;" style="margin-bottom:0px;border:1px solid black;">
					<thead>
					  <tr style="border:1px solid black;">
						<th style="font-size:11px;text-align:center;border:1px solid black;">Sl. No 123.</th>
						<th style="font-size:11px;text-align:center;border:1px solid black;">Items</th>
						<th style="font-size:11px;text-align:center;border:1px solid black;">Qty</th>
						<th style="font-size:11px;text-align:center;border:1px solid black;">Estimated Price</th>
						<th style="font-size:11px;text-align:center;border:1px solid black;">Description</th>
					  </tr>
					</thead>
					<tbody id="eventUpdate">
						<?php 
						$i = 1;
						
						foreach($deityCounter as $result) {
							echo "<tr style='border:1px solid black;text-align:center;'><td style='font-size:11px;border:1px solid black;'>".$i++."</td>";
							echo "<td style='font-size:11px;border:1px solid black;text-align:left;'>". $result["DY_IK_ITEM_NAME"]."</td>";
							echo "<td style='font-size:11px;text-align:center;border:1px solid black;'>". $result["DY_IK_ITEM_QTY"]." " . $result["DY_IK_ITEM_UNIT"]."</td>";
							echo "<td style='font-size:11px;border:1px solid black;text-align:left;'>". $result["DY_IK_APPRX_AMT"]."</td>";
							echo "<td style='font-size:11px;border:1px solid black;text-align:left;'>". $result["DY_IK_ITEM_DESC"]."</td></tr>";
						}
						?>
					</tbody>
				</table>
				<div style="margin-bottom:5px;"></div>
				<!--  <?php if($deityCounter[0]['RECEIPT_PAYMENT_METHOD_NOTES'] != "") { ?>
					<span style="font-size:11px;"><strong>Notes&nbsp;: </strong><?=$deityCounter[0]['RECEIPT_PAYMENT_METHOD_NOTES']; ?></span><br/>
				  <?php } else { ?>
				  <span style="font-size:11px;"><strong>Notes&nbsp;: </strong><?=$deityCounter[0]['RECEIPT_PAYMENT_METHOD_NOTES']; ?></span><br/>
				  <?php } ?> -->
				  <span style="font-size:11px;float:right;letter-spacing:1px;"><strong>Issued By&nbsp;: </strong><?=$deityCounter[0]['RECEIPT_ISSUED_BY'] ?></span><br/>
			</form>
		</page>
	</div><!--for printing ends -->
	
	<div class="container">
		<form class="form-group">
			<div class="form-group">
			  	<div class="row form-group">
					<div class="col-lg-6 eventsFont2" style="font-size:25px">Deity Inkind Print </div>
					<div class="col-lg-6 " style="margin-top:2.55em;margin-bottom:0em;padding-right:15px;">
						<a class="pull-right" style="border:none; outline:0;" href="<?=$_SESSION['actual_link'] ?>" title="Back"><img style="border:none; outline: 0;margin-top: -60px;" src="<?php echo base_url(); ?>images/back_icon.svg"></a>
					</div>
				</div>
			</div>
			<div class="form-group">
				<span class="eventsFont2">Receipt Date: <?=$deityCounter[0]["RECEIPT_DATE"];?></span>
				<span style="margin-right:0px;float:right;font-size:18px;" class="eventsFont2">Receipt Number: <?=$deityCounter[0]['RECEIPT_NO'] ?></span>
			</div>
			  
			<div class="form-group">
				<span style="font-size:18px;"><strong>Name: </strong><?=$deityCounter[0]['RECEIPT_NAME'] ?></span>
				<?php if(trim($deityCounter[0]['RECEIPT_PHONE']) != "") { ?>
					<span style="clear:both;float:right;font-size:18px;"><strong>Number: </strong><?=$deityCounter[0]['RECEIPT_PHONE'] ?></span>
				<?php } ?> 
			</div>

			<div class="form-group">
				<?php if(trim($deityCounter[0]['RECEIPT_PAN_NO']) != "") { ?>
					<span style="font-size:18px;"><strong>Pan No: </strong><?=$deityCounter[0]['RECEIPT_PAN_NO'] ?></span>
				<?php } ?> 
				<?php if(trim($deityCounter[0]['RECEIPT_ADHAAR_NO']) != "") { ?>
					<span style="clear:both;float:right;font-size:18px;"><strong>Adhaar No: </strong><?=$deityCounter[0]['RECEIPT_ADHAAR_NO'] ?></span>
				<?php } ?> 
			</div>
			  
			<div class="form-group">
				<span style="font-size:18px;"><strong>Deity: </strong><?=$deityCounter[0]["RECEIPT_DEITY_NAME"]; ?></span>
				<?php if($deityCounter[0]['RECEIPT_EMAIL'] != "") { ?>
					<span style="float: right;font-size:18px;"><strong>Email: </strong><?=$deityCounter[0]['RECEIPT_EMAIL'] ?></span>
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
					
					foreach($deityCounter as $result) {
						
						echo "<tr><td>".$i++."</td>";
						echo "<td>". $result["DY_IK_ITEM_NAME"]."</td>";
						echo "<td>". $result["DY_IK_ITEM_QTY"]." " . $result["DY_IK_ITEM_UNIT"]."</td>";
						echo "<td>". $result["DY_IK_APPRX_AMT"]."</td>";
						echo "<td>". $result["DY_IK_ITEM_DESC"]."</td>";
					}
					?>
					</tbody>
				</table>
			</div>
			<div class="form-group">
			   <?php if($deityCounter[0]['RECEIPT_ADDRESS'] != "") { ?>
					<span style="font-size:18px;"><strong>Address: </strong><?=$deityCounter[0]['RECEIPT_ADDRESS']; ?></span>
			   <?php } ?>
				<!-- <?php if($deityCounter[0]['RECEIPT_PAYMENT_METHOD_NOTES'] != "") { ?>
					<span style="font-size:18px;float:right;"><strong>Notes: </strong><?=$deityCounter[0]['RECEIPT_PAYMENT_METHOD_NOTES']; ?></span>
				 <?php } ?> -->
				 <span style="clear:both;float:right;font-size:18px;"><strong>Issued By: </strong><?=$deityCounter[0]['RECEIPT_ISSUED_BY'] ?></span>
			</div>
			  
			<div style="clear:both;" class="form-group">
			<center>
					<button type="button" id="print" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-print"></span> Print Receipt</button>
			</center>
			</div>
		</form>
	</div>
	
	<iframe style="width:76mm;height:1px;visibility:hidden;" id="printing-frame" name="print_frame" src="about:blank"></iframe>

<script>
	var receiptId = "<?=@$deityCounter[0]['RECEIPT_ID'] ?>";
	//these three lines are to display duplictae  
	if('<?php echo @$duplicate; ?>' != "no") {
		if('<?php echo $deityCounter[0]['PRINT_STATUS']?>' == 1)
			$('#duplicate').show();
	}
	//these two lines are to display re-print  
	if('<?php echo $deityCounter[0]['PRINT_STATUS']?>' == 1)
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
		let url = "<?=site_url(); ?>Receipt/saveDeityPrintHistory"
		$.post(url,{'receiptId':receiptId,'printStatus':1})
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
	});*/
	
</script>