<page style="margin-top:25px;margin-left:75%;width:115%;height:auto;margin-right:75%;margin-height:auto;">
			<form>
				<div style="margin-top:45px;"></div>
				<center><span class="eventsFont2" style="font-size:16px;"><strong>
					<?=$eventCounter[0]["RECEIPT_TET_NAME"]; ?>	
				</strong></span></center><br/>
				<div style="margin-top:-8px;"></div>
				<center class="eventsFont2" style="font-size:16px;"><strong>
					Sri Lakshmi Venkatesh Seva Samithi Trust
				</strong></center>
				<div style="margin-top:52px;"></div>
				<center class="eventsFont2" style="display:none;font-size:11px;padding-bottom:4px;" id="sevaPrint"><strong>Seva Receipt</strong></center>
				<center class="eventsFont2" style="font-size:11px;padding-bottom:4px;" id="duplicate"><strong><?php if($eventCounter[0]['PRINT_STATUS'] == 1) echo 'Duplicate Seva Receipt'; ?></strong></center>
				<center class="eventsFont2" style="display:none;font-size:11px;padding-bottom:4px;" id="duplicates<?php echo $s ?>"><strong>Duplicate Seva Receipt</strong></center>
				<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Receipt Date&nbsp;: </strong><?=$eventCounter[0]["TET_RECEIPT_DATE"];?></span><br/>
				<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Receipt No&nbsp;&nbsp;&nbsp;&thinsp;: </strong><?=$eventCounter[0]['TET_RECEIPT_NO'] ?></span>
				<div style="margin-bottom:6px;"></div>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Name&emsp;&ensp;&ensp;&nbsp;&thinsp;: <?=$eventCounter[0]['TET_RECEIPT_NAME'] ?></strong></span><br/>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Number&ensp;&ensp;&ensp;: </strong><?=$eventCounter[0]['TET_RECEIPT_PHONE'] ?></span><br/>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Email&emsp;&ensp;&nbsp;&nbsp;&thinsp;&thinsp;: </strong><?=$eventCounter[0]['TET_RECEIPT_EMAIL'] ?></span><br/>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Rashi&ensp;&ensp;&ensp;&nbsp;&nbsp;&thinsp;&thinsp;: </strong><?=$eventCounter[0]['TET_RECEIPT_RASHI'] ?></span><br/>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Nakshatra&nbsp;: </strong><?=$eventCounter[0]['TET_RECEIPT_NAKSHATRA'] ?></span><br/>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Address&nbsp;&nbsp;&thinsp;&thinsp;&thinsp;: </strong><?=$eventCounter[0]['TET_RECEIPT_ADDRESS'] ?></span>
				<div style="margin-bottom:6px;"></div>
				<?php if($eventCounter[0]['TET_RECEIPT_RASHI'] != "" || $eventCounter[0]['TET_RECEIPT_PHONE'] != "" || $eventCounter[0]['TET_RECEIPT_NAKSHATRA'] != "") { ?>
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
							<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Prasad&nbsp;: <?=$sevaName[$s] ?></strong></span><br/>
							<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Quantity&nbsp;: <?=$qty1 ?></strong></span><br/>
							<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Price&nbsp;: Rs. </strong><?=$actualPrice[$s]; ?>/-</span><br/><!-- <br/> -->
							<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Total Amount&nbsp;: <?=$subTotal ?></strong></span>
						<?php } else {
							//echo $sevaAmt[$s];
						 ?>
							<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Seva&nbsp;: <?=$sevaName[$s] ?></strong></span><br/>
							<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Date&nbsp;</strong>: <?=$date[$s] ?></span><br/>
							<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Price&nbsp;: Rs. <?=$sevaAmt[$s]; ?>/-</strong></span>
						<?php } ?>
					<br/><!-- <br/> -->
				<?php if(count($sevaName) == 1) { ?>
				<?php if($eventCounter[0]['POSTAGE_PRICE'] != 0) { ?>				
					<span style="font-size:11px;letter-spacing:1px;"><strong>Postage&nbsp;: Rs. <?=$eventCounter[0]['POSTAGE_PRICE']; ?>/-</strong></span>
					<span style="font-size:11px;letter-spacing:1px;float:right;" class="eventsFont2"><strong>Total&nbsp;: Rs. <span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"></span><?php if(count($sevaName) == 1) { echo $sevaAmt[$s] + $eventCounter[0]['POSTAGE_PRICE']; } else echo $sevaAmt[$s];?>/-</strong></span></br>
				<?php } ?>
				<?php } ?>
				<div style="margin-bottom:6px;"></div>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Payment Mode&nbsp;: </strong><?=$eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD']; ?></span><br/>
				
				<?php if($eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD'] == "Cheque") { ?>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Cheque Number&nbsp;: </strong><?=$eventCounter[0]['CHEQUE_NO']; ?></span>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Cheque Date&nbsp;: </strong><?=$eventCounter[0]['CHEQUE_DATE']; ?></span>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Bank&nbsp;: </strong><?=$eventCounter[0]['BANK_NAME']; ?></span>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Branch&nbsp;: </strong><?=$eventCounter[0]['BRANCH_NAME']; ?></span><br/>
				<?php } else if($eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD'] == "Credit / Debit Card") { ?><br/>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Transaction Id&nbsp;: </strong><?=$eventCounter[0]['TRANSACTION_ID']; ?></span><br/>
				<?php } ?>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Notes&nbsp;: </strong><?=$eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD_NOTES'] ?></span><br/><br/>
				<span style="font-size:11px;margin-left:24.5%;position:fixed;letter-spacing:1px;"><strong>Issued By&nbsp;: </strong><?=$eventCounter[0]['TET_RECEIPT_ISSUED_BY'] ?></span><br/>
				<span style="font-size:7px;letter-spacing:1px;position:fixed;margin-bottom:12px;"><strong><span style="color:red;">* </span> Seva Prasadam should be collected on the same day of the seva </strong></span>
				<!--<center style="clear:both;font-size: 30px;">*************************</center><br/><br/>-->
			</form>
		</page>