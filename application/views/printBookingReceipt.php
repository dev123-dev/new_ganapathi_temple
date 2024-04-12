<?php
				
					$date = [];
					$sevaName = [];
					
					$isSeva = [];
				
					$i = 0;
					$count = 1;
					
					foreach($deityCounter as $result) {
							$sevaName[$i] = $result["SO_SEVA_NAME"];
							$date[$i] = $result["SO_DATE"];
							$isSeva[$i] =  $result['SO_IS_SEVA'];
							++$i;
						
					}
?>
<!--for printing --><div id="printScreen" style="display:none;">
		<?php for($s = 0; $s < count($sevaName); ++$s) { ?>
			<page style="margin-top:25px;margin-left:75%;width:115%;margin-right:75%;">
				<form>	
					<div style="margin-top:50px;"><!--This is required for correct spacing do not remove--></div>
					<center class="eventsFont2" style="font-size:16px;font-style:bold;font-family:switzerland;">
						<?=$templename[0]["TEMPLE_NAME"]?>
					</center>
					<div style="margin-top:80px;"><!--This is required for correct spacing do not remove--></div>
					<center class="eventsFont2" style="font-size:11px;letter-spacing:1px;padding-bottom:4px;" id="duplicates"><strong>Seva Booking Receipt</strong></center>
					<center class="eventsFont2" style="display:none;font-size:11px;letter-spacing:1px;padding-bottom:4px;" id="duplicate"><strong><?="Duplicate Seva Booking Receipt "?></strong></center>
					<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Booking Date&nbsp;</strong>: <?=$deityCounter[0]["SB_DATE"];?></span><br/>
					<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Booking No.&nbsp;</strong>: <?=$deityCounter[0]['SB_NO'] ?></span>
					<div style="margin-bottom:5px;"></div>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Name&nbsp;&nbsp;&nbsp;&nbsp;: <?=$deityCounter[0]['SB_NAME'] ?></strong></span><br/>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Number&nbsp;: </strong><?=$deityCounter[0]['SB_PHONE'] ?></span><br/>
					<span style="font-size:11px;letter-spacing:1px;word-wrap: break-word;"><strong>Address&nbsp;</strong>: <?=ucfirst($deityCounter[0]['SB_ADDRESS']) ?></span>
					<div style="margin-bottom:5px;"></div>
					<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Deity&nbsp;&thinsp;: <?=@$deityCounter[0]["SO_DEITY_NAME"]; ?></strong></span><br/>
					<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Seva&nbsp;&thinsp;: <?=$sevaName[$s] ?></strong></span><br/>
					<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Date&nbsp;&thinsp;: <?=$date[$s] ?></strong></span><br/><br/>
					<span style="font-size:11px;float:right;letter-spacing:1px;float:right;"><strong>Issued By&nbsp;</strong>: <?=$deityCounter[0]['SB_ISSUED_BY'] ?></span><br/>
					<center style="clear:both;font-size: 20px;">*************************</center><br/><br/>
				</form>
			</page>
		<?php } ?>
	</div><!--for printing ends -->
	
	<div class="container">
		<form class="row">
			  <div class="form-group">
				<center><label class="eventsFont2 samFont1"><?=$deityCounter[0]["SO_DEITY_NAME"]; ?></label></center>
				<?php if(@$fromAllReceipt == "1") { ?>
					<a class="pull-right" style="border:none; outline:0;" href="<?=$_SESSION['actual_link'] ?>" title="Back"><img style="border:none; outline: 0;margin-top: -71px;" src="<?php echo base_url(); ?>images/back_icon.svg"></a>
				<?php }else { ?>
					<a class="pull-right" style="border:none; outline:0;" href="<?=site_url() ?>SevaBooking/" title="Back"><img style="border:none; outline: 0;margin-top: -71px;" src="<?php echo base_url(); ?>images/back_icon.svg"></a>
				<?php } ?>
			  </div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div class="col-lg-12" style="margin-left: -31px;">
						<div class="form-group">
							<span class="eventsFont2">Booking Date: <?=$deityCounter[0]["SB_DATE"];?></span>
						</div>
					</div>
					
					<div class="col-lg-12" style="margin-left: -31px;">
						<div class="form-group">
							<span style="font-size:18px;"><strong>Name: </strong><?=$deityCounter[0]['SB_NAME'] ?></span>
						</div>
					</div>
					
					<?php if($deityCounter[0]['SB_PHONE'] != "") { ?>
						<div class="col-lg-12" style="margin-left: -31px;">  
							<div class="form-group">
								
									<span style="font-size:18px;"><strong>Number: </strong><?=$deityCounter[0]['SB_PHONE'] ?></span>
								
							</div>
						</div>
					<?php } ?>
					
				</div>
				
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div class="col-lg-12 text-right">
						<div class="form-group" style="margin-right: -27px;">
							<span class="eventsFont2">Booking Number: <?=$deityCounter[0]['SB_NO'] ?></span>
						</div>
					</div>
					
					<?php if($deityCounter[0]['SB_ADDRESS'] != "") { ?>
						<div class="col-lg-12 text-right">  
							<div class="form-group" style="margin-right: -27px;">
								
									<span style="font-size:18px;word-wrap: break-word;"><strong>Address: </strong><?=$deityCounter[0]['SB_ADDRESS'] ?></span>
								
							</div>
						</div>
					<?php } ?>
				</div>
			  
			  <div class="clear:both;table-responsive">
				<table id="eventSeva" class="table table-bordered table-hover">
					<thead>
					  <tr>
						<th>Deity Name</th>
						<th>Seva Name</th>
						<th>Seva Date</th>
					  </tr>
					</thead>
					<tbody id="eventUpdate">
					<?php 
					$i = 1;
					
					$subTotal = 0;
					foreach($deityCounter as $result) {

						
						
						
						echo "<td>". $result["SO_DEITY_NAME"]."</td>";
						echo "<td>". $result["SO_SEVA_NAME"]."</td>";
						
						echo "<td>". $result["SO_DATE"]."</td>";
						
					}
					?>
					</tbody>
				</table>
			  </div>
			  <div class="form-group">
					<center><button type="button" id="print" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-print"></span> Print Receipt</button></center>
			  </div>
		</form>
	</div>
	
	<iframe style="width:76mm;height:1px;visibility:hidden;" id="printing-frame" name="print_frame" src="about:blank"></iframe>
	
<script>
	var receiptId = "<?=@$deityCounter[0]['SB_ID'] ?>"
	
	//these two lines are to display re-print  
	if('<?php echo @$duplicate; ?>' != "no") 
		$('#print').html(" Re-Print Receipt");
	
	var duplicate = 0; 
	var print = function() {
		var newWin = window.frames["print_frame"]; 
		newWin.document.write('<html><head><link href="<?php echo  base_url(); ?>css/print.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/quickSand.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/fonts.googleapis.css" rel="stylesheet" type="text/css"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" crossorigin="anonymous"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-theme.min.css" crossorigin="anonymous"><link href="<?php echo  base_url(); ?>css/jquery-ui.theme.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.structure.min.css" rel="stylesheet"</head>' + '<body onload="window.print()" style="min-height:90%;">'+ $('#printScreen').html() +'</body></html>');
		newWin.document.close();
	}
	
	$('#print').on('click',function() {
		let url = "<?=site_url(); ?>Receipt/saveDeityPrintHistory"
		$.post(url,{'receiptId':receiptId})
		
		if(duplicate == 1) {
			$('#duplicate').show();
			$('#duplicates').hide();
		}
		print();
		$('#print').html(" Re-Print Receipt");
		duplicate++;
	});
	
	//location.href = "<?=site_url()?>";
</script>
