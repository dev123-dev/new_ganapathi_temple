<!-- TRUST_INKIND_CODE -->
<!--please kindly note that all the lines added here are with a purpose which is carefully handled, modify only if you have understood the worKing properly-->
<!--for printing --><div id="printScreen" style="display:none">
<page style="margin-top:25px;margin-left:75%;width:115%;margin-right:75%;">
		<form>
			<div style="margin-top:45px;"><!--This is required for correct spacing do not remove--></div>
			<center><span class="eventsFont2" style="font-size:14px;font-family:switzerland;"><strong>SLVSST</strong></span></center><br/>
			<div style="margin-top:-8px;"><!--This is required for correct spacing do not remove--></div>
			<center class="eventsFont2" style="font-size:14px;font-family:switzerland;"><strong>
				<?=$templename[0]["TRUST_NAME"]?>
			</strong></center>
			<div style="margin-top:52px;"><!--This is required for correct spacing do not remove--></div>
			<center style="padding-bottom:4px;"><span class="eventsFont2" style="display:none;font-size:11px;" id="duplicate"><strong><?="Duplicate";?>&nbsp;</strong></span><span class="eventsFont2" style="font-size:12px;"><strong>Trust Inkind Receipt</strong></span></center>
			<span style="font-size:11px;letter-spacing:1px;"><strong>Receipt Date&nbsp;</strong>: <?=$eventCounter[0]["RECEIPT_DATE"];?></span><br/>
			<span style="font-size:11px;letter-spacing:1px;"><strong>Receipt No.&nbsp;&nbsp;&nbsp;</strong>: <?=$eventCounter[0]['TR_NO'] ?></span>
			<div style="margin-bottom:6px;"><!--This is required for correct spacing do not remove--></div>
			<span style="font-size:11px;letter-spacing:1px;"><strong>Name&emsp;&ensp;&ensp;&nbsp;&thinsp;: <?=$eventCounter[0]['RECEIPT_NAME'] ?></strong></span><br/>
			<span style="font-size:11px;letter-spacing:1px;"><strong>Number&nbsp;&nbsp;&thinsp;&thinsp; </strong>: <?=$eventCounter[0]['RECEIPT_NUMBER'] ?></span><br/>
			<span style="font-size:11px;letter-spacing:1px;"><strong>Pan No&nbsp;&nbsp;&thinsp;&thinsp; </strong>: <?=$eventCounter[0]['RECEIPT_PAN_NO'] ?></span><br/>
			<span style="font-size:11px;letter-spacing:1px;"><strong>Adhaar No&nbsp;&nbsp;&thinsp;&thinsp; </strong>: <?=$eventCounter[0]['RECEIPT_ADHAAR_NO'] ?></span><br/>
			<span style="font-size:11px;letter-spacing:1px;"><strong>Email&emsp;&ensp;&nbsp;&nbsp;&thinsp; </strong>: <?=$eventCounter[0]['RECEIPT_EMAIL'] ?></span><br/>
			<span style="font-size:11px;letter-spacing:1px;"><strong>Address&nbsp;&nbsp;&thinsp;&thinsp;&thinsp;</strong>: <?=$eventCounter[0]['RECEIPT_ADDRESS'] ?></span>
			<div style="margin-bottom:6px;"><!--This is required for correct spacing do not remove--></div>
			<table id="eventSeva" width="80%;" style="margin-bottom:0px;border:1px solid black;">
			<thead>
				<tr style="border:1px solid black;">
					<th style="font-size:11px;text-align:center;border:1px solid black;">Sl. No.</th>
					<th style='font-size:11px;text-align:center;border:1px solid black;'>Items</th>
					<th style='font-size:11px;text-align:center;border:1px solid black;'>Qty</th>
					<th style="font-size:11px;text-align:center;border:1px solid black;">Estimated Price</th>
					<th style="font-size:11px;text-align:center;border:1px solid black;">Description</th>
				</tr>
			</thead>
			<tbody id="eventUpdate">
			<?php 
				$i = 1;
				foreach($eventCounter as $result) {
					echo "<tr style='border:1px solid black;'><td style='font-size:11px;text-align:center;border:1px solid black;'>".$i++."</td>";
					echo "<td style='font-size:11px;border:1px solid black;'>". $result["IK_ITEM_NAME"]."</td>";
					echo "<td style='font-size:11px;text-align:center;border:1px solid black;'>". $result["IK_ITEM_QTY"]." " . $result["IK_ITEM_UNIT"].
					"</td>";
					echo "<td style='font-size:11px;border:1px solid black;text-align:left;'>". $result["IK_APPRX_AMT"]."</td>";
					echo "<td style='font-size:11px;border:1px solid black;text-align:left;'>". $result["IK_ITEM_DESC"]."</td>";
				}
			?>
			</tbody>
			</table>
			<div style="margin-bottom:6px;"><!--This is required for correct spacing do not remove--></div>
			<span style="font-size:11px;letter-spacing:1px;"><strong>Notes&nbsp;: </strong><?=$eventCounter[0]['TR_PAYMENT_METHOD_NOTES']; ?></span><br/><br/>
			<span style="font-size:11px;float:right;letter-spacing:1px;padding-right:6px;"><strong>Issued By&nbsp;: </strong><?=$eventCounter[0]['RECEIPT_ISSUED_BY'] ?></span>
			<center style="clear:both;font-size:20px;">*************************</center><br/><br/>
		</form>
</page>
</div><!--for printing ends -->
	
<div class="container">
	<form class="form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-left:0px;padding-right:0px;margin-bottom:2em;" >
			<div class="col-lg-3 col-md-4  col-sm-4 col-xs-12" style="padding-left:0px;">
				<span class="eventsFont2" style="font-size:20px;">Trust Inkind Receipt</span>
			</div>
			<div class="col-lg-7 col-md-6 col-sm-7 col-xs-10">
				<center><label class="eventsFont2 samFont1">SLVSST</label></center>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-1 col-xs-2" style="padding-right:0px;">
				<a class="pull-right" style="border:none; outline:0;" href="<?=$_SESSION['actual_link'] ?>" title="Back"><img style="border:none; outline: 0;margin-top: 1px;" src="<?php echo base_url(); ?>images/back_icon.svg"></a>
			</div>
		</div>
		<div class="form-group">
			<span class="eventsFont2">Receipt Date: <?=$eventCounter[0]["RECEIPT_DATE"];?></span>
			<span style="clear:both;float:right;font-size:18px;" class="eventsFont2">Receipt Number: <?=$eventCounter[0]['TR_NO'] ?></span>
		</div>
			  
		<div class="form-group">
			<?php if(trim($eventCounter[0]['RECEIPT_PAN_NO']) != "") { ?>
				<span style="font-size:18px;"><strong>Pan No: </strong><?=$eventCounter[0]['RECEIPT_PAN_NO'] ?></span>
			<?php } ?> 	
			<?php if(trim($eventCounter[0]['RECEIPT_ADHAAR_NO']) != "") { ?>
				<span style="float:right;font-size:18px;"><strong>Adhaar No: </strong><?=$eventCounter[0]['RECEIPT_ADHAAR_NO'] ?></span>
			<?php } ?> 
		</div>

		<div class="form-group">
			<span style="font-size:18px;"><strong>Name: </strong><?=$eventCounter[0]['RECEIPT_NAME'] ?></span>
			<?php if(trim($eventCounter[0]['RECEIPT_NUMBER']) != "") { ?>
				<span style="float:right;font-size:18px;"><strong>Number: </strong><?=$eventCounter[0]['RECEIPT_NUMBER'] ?></span>
			<?php } ?> 
		</div>
		  
		<div class="form-group">
			<?php if($eventCounter[0]['RECEIPT_EMAIL'] != "") { ?>
				<span style="float: right;font-size:18px;"><strong>Email: </strong><?=$eventCounter[0]['RECEIPT_EMAIL'] ?></span>
			<?php } ?> 
		</div>
		<div style="clear:both"><!--This is required for correct spacing do not remove--></div><br/>
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
				<?php if($eventCounter[0]['RECEIPT_ADDRESS'] != "") { ?>
					<span style="font-size:18px;"><strong>Address: </strong><?=$eventCounter[0]['RECEIPT_ADDRESS']; ?></span>
				<?php } ?>
				<?php if($eventCounter[0]['TR_PAYMENT_METHOD_NOTES'] != "") { ?>
					<span style="font-size:18px;float:right;"><strong>Notes: </strong><?=$eventCounter[0]['TR_PAYMENT_METHOD_NOTES']; ?></span>
				<?php } ?>
			</div>
			  
			<div class="form-group">
					<center><button type="button" id="print" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-print"></span> Print Receipt</button></center>
			</div>
	</form>
</div>
	
<iframe style="width:76mm;height:1px;visibility:hidden;" id="printing-frame" name="print_frame" src="about:blank"></iframe>
	
<script>
	var receiptId = "<?=@$eventCounter[0]['TR_ID'] ?>";
	
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
	
	//location.href = "<?=site_url()?>";
</script>
