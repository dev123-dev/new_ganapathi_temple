<?php
	
	$date = [];
	$sevaName = [];
	$sevaAmt = [];
	$isSeva = [];
	$i = 0;
		
	foreach($deityCounter as $result) {
		$sevaName[$i] = $result["SEVA_NAME"];
		$sevaQty[$i] = $result["SEVA_QTY"];
		$deityName[$i] = $result["DEITY_NAME"];
		$receiptNo[$i] = $result["RECEIPT_NO"];
		$date[$i] = $result["ENG_DATE"];
		$corpus[$i] = $result["RECEIPT_PRICE"];
		$masa[$i] = $result["MASA"];
		$paksha[$i] = $result["BASED_ON_MOON"];
		$thithi[$i] = $result["THITHI_NAME"];
		$payment[$i] = $result["RECEIPT_PAYMENT_METHOD"];
		$receiptId[$i] = $result["RECEIPT_ID"];
		$sevaNotes[$i] = $result["SEVA_NOTES"];
		$isSeva[$i] =  1;
		++$i;
	}
	
?> 

<!--for printing -->
<div id="printScreen" style="display:none;">
<?php for($s = 0; $s < count($sevaName); ++$s) { ?>
			<page style="margin-top:25px;width:715px;margin-left:7%;">
				<form>
					<!--<center><span class="eventsFont2 samFont2">
					<?=$deityCounter[$s]["RECEIPT_DEITY_NAME"]; ?>
					</span></center>-->
					<center class="eventsFont2" style="font-size:14px;margin-top:74px;font-family:switzerland"><strong><?=$templename[0]["TEMPLE_NAME"]?></strong></center>
					<div style="margin-top:65px;"></div>
					<center class="eventsFont2" style="display:none;font-size:14px;" id="original<?=$s?>"><strong><?="Shashwath Receipt "?></strong></center>
					<center class="eventsFont2" style="display:none;font-size:14px;" id="duplicate<?=$s?>"><strong><?="Duplicate Shashwath Receipt "?></strong></center>
					<table style="margin-top:6px;">
					<tr>
					<td width="74%"><span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><b>Receipt No&nbsp;&thinsp;:</b> <?=$receiptNo[$s]; ?></span></td>
					<td width="74%"><span style="font-size:11px;letter-spacing:1px;margin-left:34px;float:right;" class="eventsFont2"><b>Receipt Date&nbsp;:</b> <?=$deityCounter[$s]["RECEIPT_DATE"];?></span></td>
					</tr>
					<tr>
					<td width="74%">
					<span style="font-size:11px;letter-spacing:1px;"><strong>Manual Receipt No:</strong>&thinsp; <?=$deityCounter[$s]['SS_RECEIPT_NO'] ?></span><br/>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&thinsp;&thinsp;&thinsp;&thinsp;: <?=$deityCounter[$s]['RECEIPT_NAME'] ?></strong></span><br/>
					<?php if($deityCounter[$s]['RECEIPT_PHONE'] != "") { ?>
						<span style="font-size:11px;letter-spacing:1px;"><strong>Number&nbsp;&nbsp;&nbsp;&thinsp;&thinsp;&thinsp;&thinsp;: </strong><?=$deityCounter[$s]['RECEIPT_PHONE'] ?></span><br/>
					<?php } else { ?>
						<span style="font-size:11px;letter-spacing:1px;"><strong>Number&nbsp;&nbsp;&nbsp;&thinsp;&thinsp;&thinsp;&thinsp;: </strong><?=$deityCounter[$s]['RECEIPT_PHONE'] ?></span><br/>
					<?php } ?>
					<?php if($deityCounter[$s]['RECEIPT_ADDRESS'] != "") { ?>
						<span style="font-size:11px;letter-spacing:1px;"><strong>Address&nbsp;&nbsp;&nbsp;&thinsp;&thinsp;&thinsp;&thinsp;: </strong><?=$deityCounter[$s]['RECEIPT_ADDRESS'] ?></span>
						<div style="margin-top:5px;"></div>
					<?php } else { ?>
						<span style="font-size:11px;letter-spacing:1px;"><strong>Address&nbsp;&nbsp;&nbsp;&thinsp;&thinsp;&thinsp;&thinsp;: </strong><?=$deityCounter[$s]['RECEIPT_ADDRESS'] ?></span>
						<div style="margin-top:5px;"></div>
					<?php } ?>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Deity&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&thinsp;&thinsp;&thinsp;&thinsp;:<span style="font-size:12px;letter-spacing:1px;text-align:center;">&thinsp;<?=$deityName[$s]; ?></span></strong></span>
					<div style="margin-top:5px;"></div>
					
					<span style="font-size:11px;letter-spacing:1px;"><strong>Date&nbsp;&nbsp;&nbsp;&nbsp;&thinsp;&nbsp;&nbsp;&nbsp;&thinsp;&thinsp;&thinsp;&thinsp;: </strong><?=$date[$s]; ?></span>
					<div style="margin-top:5px;"></div>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Masa&nbsp;: </strong><?=$masa[$s]; ?></span>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Paksha&nbsp;: </strong><?=$paksha[$s]; ?></span>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Thithi&nbsp;: </strong><?=$thithi[$s]; ?></span>
					</td>
					<td width="74%" align="right">
					<?php if($deityCounter[$s]['RECEIPT_RASHI'] != "") { ?>
						<span style="font-size:11px;letter-spacing:1px;float:right;"><strong>Rashi&nbsp;:</strong><?=$deityCounter[$s]['RECEIPT_RASHI'] ?></span></br>
					<?php } ?>
					<?php if($deityCounter[$s]['RECEIPT_NAKSHATRA'] != "") { ?>
						<span style="font-size:11px;letter-spacing:1px;float:right;"><strong>Nakshatra&nbsp;: </strong><?=$deityCounter[$s]['RECEIPT_NAKSHATRA'] ?></span></br>
					<?php } ?>
					</td>
					</tr>
					</table>
					<table border="1" style="margin-top:15px;">
				    <tr>
					<td align="center" width="40%">
					<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Seva</strong></span>
					</td>
					<td align="center" width="6%">
					<span style="font-size:11px;letter-spacing:1px;"><strong>Corpus </strong></span>
					<br/>
					</td>
					<td align="center" width="35%">
					<span style="font-size:11px;letter-spacing:1px;"><strong>Purpose </strong></span>
					</td>
					</tr>
					<tr>
					<td align="center">
					<span style="font-size:11px;letter-spacing:1px;text-align:center;"><?=$sevaName[$s] ?></span>
					</td>
					<td align="center">
					<span style="font-size:11px;letter-spacing:1px;text-align:center;"><?=$corpus[$s]; ?></span>
					</td>
					<td align="center">
					<span style="font-size:11px;letter-spacing:1px;text-align:center;"><?=$sevaNotes[$s]; ?></span>
					</td>
					</tr>
					</table>
					<div style="margin-top:5px;"></div>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Total Amount: Rs. <?=$corpus[$s] ?>/- <?=AmountInWords($corpus[$s]);?></strong></span><br/>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Payment Mode&nbsp;: </strong><?=$deityCounter[$s]['RECEIPT_PAYMENT_METHOD']; ?></span><br/>
					<?php if($deityCounter[$s]['RECEIPT_PAYMENT_METHOD'] == "Cheque") { ?>
						<span style="font-size:11px;letter-spacing:1px;"><strong>Cheque Number&nbsp;: </strong><?=$deityCounter[$s]['CHEQUE_NO']; ?></span>
						<span style="font-size:11px;letter-spacing:1px;"><strong>Cheque Date&nbsp;: </strong><?=$deityCounter[$s]['CHEQUE_DATE']; ?></span>
						<span style="font-size:11px;letter-spacing:1px;"><strong>Bank&nbsp;: </strong><?=$deityCounter[$s]['BANK_NAME']; ?></span>
						<span style="font-size:11px;letter-spacing:1px;"><strong>Branch&nbsp;: </strong><?=$deityCounter[$s]['BRANCH_NAME']; ?></span><br/>
					<?php } else if($deityCounter[$s]['RECEIPT_PAYMENT_METHOD'] == "Credit / Debit Card") { ?>
						<span style="font-size:11px;letter-spacing:1px;"><strong>Transaction Id&nbsp;: </strong><?=$deityCounter[$s]['TRANSACTION_ID']; ?></span><br/>
					<?php } ?>
					<?php if($deityCounter[$s]['RECEIPT_PAYMENT_METHOD_NOTES'] != "") { ?>
						<span style="font-size:11px;letter-spacing:1px;"><strong>Notes&nbsp;: </strong><?=$deityCounter[$s]['RECEIPT_PAYMENT_METHOD_NOTES'] ?></span>
					<?php } ?>
					<span style="font-size:11px;float:right;letter-spacing:1px;margin-top:30px;"><strong>Issued By&nbsp;: </strong><?=$deityCounter[$s]['RECEIPT_ISSUED_BY'] ?></span><br/>
					<center style="clear:both;font-size: 20px;">*************************</center>
				</form>
			</page>
<?php } ?>
</div><!--for printing ends -->
	
	<div class="container">
			<form class="form-group">
				
				<div class="form-group">
					<span class="eventsFont2">Shashwath Member Receipt</span>
				</div>
				 
				<div class="form-group">
					<a class="pull-right" style="border:none; outline:0;" href="<?=site_url() ?>Shashwath/shashwath_member" title="Back"><img style="border:none; outline: 0;margin-top: -77px;" height="30px" width="35px" src="<?php echo base_url(); ?>images/back_icon.svg"></a>
				</div>
				  
				<div class="form-group">
					<span style="font-size:18px;"><strong>Name: </strong><?=$deityCounter[count($sevaName)-1]['RECEIPT_NAME'] ?></span>
					<?php if($deityCounter[count($sevaName)-1]['RECEIPT_RASHI'] != "") { ?>
						<span style="float:right;clear:both;font-size:18px;margin-top: -27px;"><strong>Rashi: </strong><?=$deityCounter[count($sevaName)-1]['RECEIPT_RASHI'] ?></span>
					<?php } ?>
				</div>
				<div class="form-group">
						<?php if($deityCounter[count($sevaName)-1]['SS_RECEIPT_NO'] != "") { ?>
						<span style="font-size:18px;"><strong>Manual Receipt No: </strong><?=$deityCounter[count($sevaName)-1]['SS_RECEIPT_NO'] ?></span>
					<?php } ?>
				</div>  
				<div class="form-group">
					<?php if($deityCounter[count($sevaName)-1]['RECEIPT_PHONE'] != "") { ?>
						<span style="font-size:18px;"><strong>Number: </strong><?=$deityCounter[count($sevaName)-1]['RECEIPT_PHONE'] ?></span>
					<?php } ?>
					<?php if($deityCounter[count($sevaName)-1]['RECEIPT_NAKSHATRA'] != "") { ?>
						<span style="float:right;clear:both;font-size:18px;"><strong>Nakshatra: </strong><?=$deityCounter[count($sevaName)-1]['RECEIPT_NAKSHATRA'] ?></span>
					<?php } ?>
				</div>
				  
				<div class="clear:both;table-responsive">
					<table id="eventSeva" class="table table-bordered table-hover">
						<thead>
							<tr>				
								<th>Sl. No.</th>
								<th>Receipt Number</th>
								<th>Deity Name</th>
								<th>Seva Name</th>
								<th>Qty</th>
								<th>Thithi</th>
								<th>Date</th>
								<th>Week/Month</th>
								<th>Period</th>
								<th>Corpus</th>
								<th>Pay Mode</th>
								<th>Issued by</th>
								<?php if($this->session->userdata('userGroup') == 1 || $this->session->userdata('userGroup') == 6) { if($result['AUTHORISED_STATUS'] == 'No') { ?>
									<th>Cancel</th>
								<?php } } ?>
							</tr>
						</thead>
		
						<tbody id="eventUpdate">
							<?php
								$i = 1;
								if(isset($deityCounter)) {
									foreach($deityCounter as $result) {
											echo "<tr><td>".$i."</td>";
											echo "<td>".$result['RECEIPT_NO']."</td>";
											echo "<td>".$result['DEITY_NAME']."</td>";
											echo "<td>".$result['SEVA_NAME']."</td>";
											echo "<td>".$result['SEVA_QTY']."</td>";
											echo "<td>".$result['THITHI_CODE']."</td>";
											echo "<td>".$result['ENG_DATE']."</td>";								
											echo "<td>".$result['EVERY_WEEK_MONTH']."</td>";
											echo "<td>".$result['PERIOD_NAME']."</td>";							
											echo "<td>".$result['RECEIPT_PRICE']."</td>";
											echo "<td>".$result['RECEIPT_PAYMENT_METHOD']."</td>";
											echo "<td>".$result['RECEIPT_ISSUED_BY']."</td>";
											if($this->session->userdata('userGroup') == 1 || $this->session->userdata('userGroup') == 6) { 
												if($result['AUTHORISED_STATUS'] == 'No') { 
													echo "<td><button type='button' style='width:80px' id='cancel".$result['RECEIPT_ID']."' onclick='show_cancelled(".$result['RECEIPT_ID'].",".$result['SM_ID'].",\"".$result['RECEIPT_NO']."\")' class='btn btn-default'>Cancel</button></td></tr>";
												} else {
													echo "</tr>";
												}
												$i++;
											}
									}
								}
							?>
						</tbody>
					</table>
				</div>			
			</form>
			</div>
	
	<div class="form-group">
		<center>
				<button type="button" id="print" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-print"></span> Print Receipt</button>
		</center>
	</div>
	
	<iframe style="width:76mm;height:1px;visibility:hidden;" id="printing-frame" name="print_frame" src="about:blank"></iframe>

<!-- Cancelled Modal2 -->
	<div id="myModalCancelled" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content" style="padding-bottom:1em;">
				<div class="modal-header">
					<button type="button" class="close topClosePos" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add Cancellation Notes</h4>
				</div>
				<div class="modal-body" id="cancelleddet" style="overflow-y: auto;max-height: 330px;">
					<textarea id="cancelNotes" rows="4" cols="50" style="width: 100%;"></textarea>		
					<button type="button" id="submitNotes" class="btn btn-default pull-right">SAVE</button>
				</div>
			</div>
		</div>
	</div>

	<form id="submitForm" action="<?php echo site_url(); ?>Receipt/shashwath_cancel_note/" class="form-group" role="form" enctype="multipart/form-data" method="post">
		<input type="hidden" id="rId" name="rId"/>
		<input type="hidden" id="rNo" name="rNo"/>
		<input type="hidden" id="cNote" name="cNote"/>
		<input type="hidden" id="smId" name="smId"/>
	</form>

<script>
	if('<?php echo $deityCounter[0]['PRINT_STATUS']?>' == 1) {
		$('#print').html(" Re-Print Receipt");
		for(i=0;i<'<?=count($deityCounter)?>';i++){	
			$('#duplicate'+i).show();
		}
	}
	
	if('<?php echo $deityCounter[0]['PRINT_STATUS']?>' != 1) {
		for(i=0;i<'<?=count($deityCounter)?>';i++){
			$('#original'+i).show();
		}
	}
	
	<?php $ShashwathReceiptId = ''; foreach($deityCounter as $result) { 
		if($ShashwathReceiptId != '') { $comma = ','; } else $comma = '';
		$ShashwathReceiptId .= $comma.$result['RECEIPT_ID'];
	} ?>
		
	var ShashwathReceiptId = <?php echo json_encode($ShashwathReceiptId);?>;
	//console.log(ShashwathReceiptId);
	
	var duplicate = 0;
	
	function print() {
		var newWin = window.frames["print_frame"]; 
		newWin.document.write('<html><head><link href="<?php echo  base_url(); ?>css/print.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/quickSand.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/fonts.googleapis.css" rel="stylesheet" type="text/css"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" crossorigin="anonymous"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-theme.min.css" crossorigin="anonymous"><link href="<?php echo  base_url(); ?>css/jquery-ui.theme.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.structure.min.css" rel="stylesheet"</head>' + '<body onload="window.print()">'+ $('#printScreen').html() +'</body></html>');
		newWin.document.close();
	}
			
	$('#print').on('click',function(e) {
		let url = "<?=site_url(); ?>Receipt/saveDeityPrintHistory"
		$.post(url,{'ShashwathReceiptId':ShashwathReceiptId})
		if(duplicate == 1) {
			var i;
			for(i=0;i<'<?php echo count($deityCounter)?>';i++){
				$('#duplicate'+i).show();
				$('#original'+i).hide();
			}
		} 
		print();
		$('#print').html(" Re-Print Receipt");
		duplicate++;
	}); 
	
	//Cancelled Model
	function show_cancelled(id,smId,rNo) {
		console.log(id);
		$('#rId').val(id);
		$('#rNo').val(rNo);
		$('#smId').val(smId);
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