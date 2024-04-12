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
		
			$sevaName[$i] = $result["TET_SO_SEVA_NAME"];
			$date[$i] = $result["TET_SO_DATE"];
			if(intval($result["TET_SO_QUANTITY"]) != 0)
				$count = intval($result["TET_SO_QUANTITY"]);
			else 
				$count = 1;
			$qty[$i] =  intval($count);
			$sevaAmt[$i] = intval($result["TET_SO_PRICE"]);
			$actualPrice[$i] = intval($result["TET_SO_PRICE"]);
			$actualQty[$i] = intval($result["TET_SO_QUANTITY"]);
			$isSeva[$i] =  $result['TET_SO_IS_SEVA'];
			++$i;
	}
?>

<!--for printing -->
<div id="printScreen" style="display:none;">
	<?php $num = 0; 
	for($s = 0; $s < count($sevaName); ++$s) { ?>
		<?php if(count($sevaName) > 1) { 
			if($num == 0) { 
				if($eventCounter[0]['POSTAGE_PRICE'] != 0) { ?>
					<page style="margin-top:25px;margin-left:75%;width:115%;margin-right:75%;">
						<form>
							<div style="margin-top:38px;"><!--This is required for correct spacing do not remove-->						
							</div>
							<center><span class="eventsFont2 " style="font-size:14px;font-family:switzerland;"><strong>
								<?=$eventCounter[0]["RECEIPT_TET_NAME"]; ?>	
								</strong></span>
							</center><br/>
							<div style="padding-top:-3px;"><!--This is required for correct spacing do not remove-->
							</div>
							<center class="eventsFont2" style="font-size:14px;font-family:switzerland;"><strong>
							<?=$templename[0]["TRUST_NAME"]?>
								</strong>
							</center>
							<div style="margin-top:45px;">						
							</div>
							<center class="eventsFont2" id="duplicatePostage1" style="font-size:11px;letter-spacing:1px;"><strong><?php if($eventCounter[0]['PRINT_STATUS'] == 1) echo 'Duplicate' ?> Postage Receipt</strong>
							</center>
							<center class="eventsFont2" style="display:none;font-size:11px;" id="duplicatePostage2"><strong>Duplicate Postage Receipt</strong>
							</center>
							<div style="margin-bottom:6px;"><!--This is required for correct spacing do not remove--></div>
							<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2">Receipt Date&nbsp;: <?=$eventCounter[0]["TET_RECEIPT_DATE"];?></span><br/>
							<span style="font-size:11px;letter-spacing:1px;"><strong>Postage&nbsp;: Rs. <?=$eventCounter[0]['POSTAGE_PRICE']; ?>/- <?=AmountInWords($eventCounter[0]['POSTAGE_PRICE']);?></strong></span><br/><br/>
							<span style="font-size:11px;float:right;letter-spacing:1px;"><strong>Issued By&nbsp;</strong>: <?=$eventCounter[0]['TET_RECEIPT_ISSUED_BY'] ?></span><br/>
							<center style="clear:both;font-size: 20px;">*************************</center>
						</form>
					</page>
				<?php $num++;}
			}
		} ?>

		<page style="margin-top:25px;margin-left:75%;width:115%;height:auto;margin-right:75%;margin-height:auto;">
			<form>
				<div style="margin-top:45px;"><!--This is required for correct spacing do not remove-->				
				</div>
				<center><span class="eventsFont2" style="font-size:14px;font-family:switzerland;"><strong>
						<?=$eventCounter[0]["RECEIPT_TET_NAME"]; ?>	
					</strong></span>
				</center><br/>
				<div style="margin-top:-8px;">
				</div>
				<center class="eventsFont2" style="font-size:14px;font-family:switzerland;"><strong>
						<?=$templename[0]["TRUST_NAME"]?>
					</strong>
				</center>
				<div style="margin-top:52px;"><!--This is required for correct spacing do not remove-->
				</div>
				<center class="eventsFont2" style="display:none;font-size:11px;padding-bottom:4px;" id="sevaPrint<?php echo $s ?>"><strong>Seva Receipt</strong></center>
				<center class="eventsFont2" style="font-size:11px;padding-bottom:4px;" id="duplicate"><strong><?php if($eventCounter[0]['PRINT_STATUS'] == 1) echo 'Duplicate Seva Receipt'; ?></strong></center>
				<center class="eventsFont2" style="display:none;font-size:11px;padding-bottom:4px;" id="duplicates<?php echo $s ?>"><strong>Duplicate Seva Receipt</strong></center>
				<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Receipt Date&nbsp;: </strong><?=$eventCounter[0]["TET_RECEIPT_DATE"];?></span><br/>
				<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Receipt No&nbsp;&nbsp;&nbsp;&thinsp;: </strong><?=$eventCounter[0]['TET_RECEIPT_NO'] ?></span>
					
				<div style="margin-bottom:6px;"><!--This is required for correct spacing do not remove-->
				</div>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Name&emsp;&ensp;&ensp;&nbsp;&thinsp;: <?=$eventCounter[0]['TET_RECEIPT_NAME'] ?></strong></span><br/>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Number&ensp;&ensp;&ensp;: </strong><?=$eventCounter[0]['TET_RECEIPT_PHONE'] ?></span><br/>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Email&emsp;&ensp;&nbsp;&nbsp;&thinsp;&thinsp;: </strong><?=$eventCounter[0]['TET_RECEIPT_EMAIL'] ?></span><br/>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Rashi&ensp;&ensp;&ensp;&nbsp;&nbsp;&thinsp;&thinsp;: </strong><?=$eventCounter[0]['TET_RECEIPT_RASHI'] ?></span><br/>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Nakshatra&nbsp;: </strong><?=$eventCounter[0]['TET_RECEIPT_NAKSHATRA'] ?></span><br/>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Address&nbsp;&nbsp;&thinsp;&thinsp;&thinsp;: </strong><?=$eventCounter[0]['TET_RECEIPT_ADDRESS'] ?></span>
				<div style="margin-bottom:6px;"><!--This is required for correct spacing do not remove-->
				</div>
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
				<?php if(intval($isSeva[$s]) == 0) { //echo $actualPrice[$s]." x ".$qty1." = ".$sevaAmt[$s]; ?>
					<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Prasad&nbsp;: <?=$sevaName[$s] ?></strong></span><br/>
					<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Quantity&nbsp;: <?=$qty1 ?></strong></span><br/>
					<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Price&nbsp;: Rs. <?=$actualPrice[$s]; ?>/- <?=AmountInWords($actualPrice[$s]);?></strong></span><br/><!-- <br/> -->
					<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Amount&nbsp;: <?=$subTotal ?><?=AmountInWords($subTotal);?></strong></span>
				<?php } else { //echo $sevaAmt[$s]; ?>
					<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Seva&nbsp;: <?=$sevaName[$s] ?></strong></span><br/>
					<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Date&nbsp;: <?=$date[$s] ?></strong></span><br/>
					<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Quantity&nbsp;: <?=$qty1 ?></strong></span><br/>
					<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Price&nbsp;: Rs. <?=$actualPrice[$s]; ?>/- <?=AmountInWords($actualPrice[$s]);?></strong></span><br/><!-- <br/> -->
					<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Total Amount&nbsp;: <?=$subTotal ?><?=AmountInWords($subTotal);?>
<!-- 
					
					<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Seva&nbsp;: <?=$sevaName[$s] ?></strong></span><br/>
					<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Date&nbsp;</strong>: <?=$date[$s] ?></span><br/>
					<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Price&nbsp;: Rs. <?=$sevaAmt[$s]; ?>/-<?=AmountInWords($sevaAmt[$s]);?></strong></span> -->
				<?php } ?>
				<br/><!-- <br/> -->
				<?php if(count($sevaName) == 1) { ?>
					<?php if($eventCounter[0]['POSTAGE_PRICE'] != 0) { ?>				
						<span style="font-size:11px;letter-spacing:1px;"><strong>Postage&nbsp;: Rs. <?=$eventCounter[0]['POSTAGE_PRICE']; ?>/-<?=AmountInWords($eventCounter[0]['POSTAGE_PRICE']);?></strong></span>
						<span style="font-size:11px;letter-spacing:1px;float:right;" class="eventsFont2"><strong>Total&nbsp;: Rs. <span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"></span>	<?php if(count($sevaName) == 1) { echo $sevaAmt[$s] + $eventCounter[0]['POSTAGE_PRICE'].'/-'. AmountInWords($sevaAmt[$s] + $eventCounter[0]['POSTAGE_PRICE']); }
								 else { echo $sevaAmt[$s].'/-'.AmountInWords($sevaAmt[$s]); }?>
							</strong></span></br>
					<?php } ?>
				<?php } ?>
					<div style="margin-bottom:6px;"><!--This is required for correct spacing do not remove--></div>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Payment Mode&nbsp;: </strong><?=$eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD']; ?></span><br/>
				<?php if($eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD'] == "Cheque") { ?>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Cheque Number&nbsp;: </strong><?=$eventCounter[0]['CHEQUE_NO']; ?></span>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Cheque Date&nbsp;: </strong><?=$eventCounter[0]['CHEQUE_DATE']; ?></span>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Bank&nbsp;: </strong><?=$eventCounter[0]['BANK_NAME']; ?></span>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Branch&nbsp;: </strong><?=$eventCounter[0]['BRANCH_NAME']; ?></span><br/>
				<?php } else if($eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD'] == "Credit / Debit Card") { ?>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Transaction Id&nbsp;&thinsp;: </strong><?=$eventCounter[0]['TRANSACTION_ID']; ?></span><br/>
				<?php } ?>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Notes&nbsp;: </strong><?=$eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD_NOTES'] ?></span><br/><br/>
					<span style="font-size:11px;margin-left:24.5%;float:right;letter-spacing:1px;"><strong>Issued By&nbsp;: </strong><?=$eventCounter[0]['TET_RECEIPT_ISSUED_BY'] ?></span><br/>
					<span style="font-size:7px;letter-spacing:1px;margin-bottom:12px;"><strong><span style="color:red;">* </span> Seva Prasadam should be collected on the same day of the seva </strong></span>
					<!--<center style="clear:both;font-size: 30px;">*************************</center><br/><br/>-->
			</form>
		</page>
	<?php } ?>
</div>
<!--for printing ends -->

<!-- AbhiPra Code -->
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
		// $checkDeity = $deityCounter[0]['SO_DEITY_NAME'];
		$checkDate = $eventCounter[0]['TET_SO_DATE'];
		$checkCount = 0; 
		foreach($eventCounter as $result) {
			if($checkDate != $result["TET_SO_DATE"]) {
				++$checkCount;
				break;
			}
		}
						
		//making duplicate to single
		$totalPrice = 0;
		if($checkCount == 0) {
			foreach($eventCounter as $result) {
				$totalPrice += intval($result["TET_SO_PRICE"]);
				if(empty($sevaName)) {
					// $deityName[$i] = $result["SO_DEITY_NAME"];
					$sevaName[$i] = $result["TET_SO_SEVA_NAME"];
					$date[$i] = $result["TET_SO_DATE"];
					if(intval($result["TET_SO_QUANTITY"]) != 0)
						$count = intval($result["TET_SO_QUANTITY"]);
					else 
						$count = 1;
						$qty[$i] =  intval($count);
						$sevaAmt[$i] = intval($result["TET_SO_PRICE"]);
						$actualPrice[$i] = intval($result["TET_SO_PRICE"]);
						$actualQty[$i] = intval($result["TET_SO_QUANTITY"]);
						$isSeva[$i] =  $result['TET_SO_IS_SEVA'];
				}else {
					$sevaName[$i] .= ", ". $result["TET_SO_SEVA_NAME"];
					$date[$i] .= ", ". $result["TET_SO_DATE"];
				}
			}
			$duplicateSevas = [];
			foreach($sevaName as $arr) {
				array_push($duplicateSevas, array_count_values(explode(", ",$arr)));
			}
		}else {
			foreach($eventCounter as $result) {
				if(empty($sevaName)) {
					// $deityName[$i] = $result["SO_DEITY_NAME"];
					$sevaName[$i] = $result["TET_SO_SEVA_NAME"];
					$date[$i] = $result["TET_SO_DATE"];
					if(intval($result["TET_SO_QUANTITY"]) != 0)
						$count = intval($result["TET_SO_QUANTITY"]);
					else 
						$count = 1;
						$qty[$i] =  intval($count);
						$sevaAmt[$i] = intval($result["TET_SO_PRICE"]);
						$actualPrice[$i] = intval($result["TET_SO_PRICE"]);
						$actualQty[$i] = intval($result["TET_SO_QUANTITY"]);
						$isSeva[$i] =  $result['TET_SO_IS_SEVA'];
				}else if($sevaName[$i] == $result["TET_SO_SEVA_NAME"] && $date[$i] == $result["TET_SO_DATE"]) {
					$date[$i] .= ", ". $result["TET_SO_DATE"];	
					if(intval($result["TET_SO_QUANTITY"]) != 0)
						$count += intval($result["TET_SO_QUANTITY"]);
					else 
						++$count;
					$actualQty[$i] = intval($result["TET_SO_QUANTITY"]);
					$count += intval($result["TET_SO_QUANTITY"]);
					$qty[$i] = $count;
					$actualPrice[$i] += intval($result["TET_SO_PRICE"]);
					$sevaAmt[$i] += intval($result["TET_SO_PRICE"]);
					$isSeva[$i] =  $result['TET_SO_IS_SEVA'];							
				}else if($sevaName[$i] == $result["TET_SO_SEVA_NAME"] && $date[$i]  != $result["TET_SO_DATE"]) {		
					$date[$i] .= ", ". $result["TET_SO_DATE"];			
					$actualQty[$i] = intval($result["TET_SO_QUANTITY"]);
					$sevaAmt[$i] = intval($result["TET_SO_PRICE"]);
					$actualPrice[$i] += intval($result["TET_SO_PRICE"]);
					$count = intval($result["TET_SO_QUANTITY"]);
					if(intval($result["TET_SO_QUANTITY"]) != 0)
						$count = intval($result["TET_SO_QUANTITY"]);
					else 
						$count = 1;
					$qty[$i] = intval($count);
					$isSeva[$i] =  $result['TET_SO_IS_SEVA'];
				}else {	
					// print_r($sevaName[$i]. " else " . $result["SO_SEVA_NAME"]. "<br/>" .$deityName[$i] ." else " . $result["SO_DEITY_NAME"] ." <br/>". $date[$i]. " else " .$result["SO_DATE"] );
						$i++;
					// print_r("<pre>");
					// print_r("else");
					// print_r("</pre>");
						// $deityName[$i] = $result["SO_DEITY_NAME"];
						$sevaName[$i] = $result["TET_SO_SEVA_NAME"];			
						$date[$i] = $result["TET_SO_DATE"];
					// print_r($sevaName[$i]. " ++i " . $result["SO_SEVA_NAME"]. "<br/>" .$deityName[$i] ." ++i " . $result["SO_DEITY_NAME"] ." <br/>". $date[$i]. " ++i " .$result["SO_DATE"] );
						
						$actualPrice[$i] = intval($result["TET_SO_PRICE"]);
						$sevaAmt[$i] = intval($result["TET_SO_PRICE"]);
						$actualQty[$i] = intval($result["TET_SO_QUANTITY"]);
						$date[$i] = $result["TET_SO_DATE"];
						if(intval($result["TET_SO_QUANTITY"]) != 0)
							$count = intval($result["TET_SO_QUANTITY"]);
						else 
							$count = 1;
						$qty[$i] = intval($count);
						$isSeva[$i] =  $result['TET_SO_IS_SEVA'];				
				}
			}		
		}
		$duplicateDates = [];
		foreach($date as $arr) {
			array_push($duplicateDates, array_count_values(explode(", ",$arr)));
		}
	?>

<!--for printing combine save seva and deity -->
	<div id="printScreenCombine" style="display:none;">
		<?php if($eventCounter[0]['POSTAGE_PRICE'] != 0){ ?>
			<page style="margin-top:25px;margin-left:75%;width:115%;margin-right:75%;">
				<form>
					<div style="margin-top:38px;"><!--This is required for correct spacing do not remove-->						
					</div>
					<center><span class="eventsFont2 " style="font-size:14px;font-family:switzerland;"><strong>
							<?=$eventCounter[0]["RECEIPT_TET_NAME"]; ?>	
						</strong></span>
					</center><br/>
					<div style="padding-top:-3px;"><!--This is required for correct spacing do not remove-->
					</div>
					<center class="eventsFont2" style="font-size:14px;font-family:switzerland;"><strong>
								<?=$templename[0]["TRUST_NAME"]?>
						</strong>
					</center>
					<div style="margin-top:45px;">						
					</div>
					<center class="eventsFont2" style="font-size:11px;padding-bottom:4px;" id="duplicatePostage1"><strong><?php if($eventCounter[0]['PRINT_STATUS'] == 1) echo 'Duplicate' ?> Postage Receipt</strong>
					</center>
					<center class="eventsFont2" style="display:none;font-size:11px;padding-bottom:4px;" id="duplicatePostage2"><strong>Duplicate Postage Receipt</strong></center>
					<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2">Receipt Date&nbsp;:<?=$eventCounter[0]["TET_RECEIPT_DATE"];?></span><br/>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Postage&nbsp;: Rs. <?=$eventCounter[0]['POSTAGE_PRICE']; ?>/-<?=AmountInWords($eventCounter[0]['POSTAGE_PRICE']);?></strong></span><br/><br/>		
						<span style="font-size:11px;float:right;letter-spacing:1px;">Issued By&nbsp;: <?=$eventCounter[0]['TET_RECEIPT_ISSUED_BY'] ?></span><br/>
						<center style="clear:both;font-size: 20px;">*************************</center>
				</form>
			</page>
		<?php } ?>
		<?php for($s = 0; $s < count($sevaName); ++$s) { 
				// $seva = count($sevaName);
				// print_r($seva);
		?>
			<page style="margin-top:25px;margin-left:75%;width:115%;margin-right:75%;" data-size="A6">
				<form>
					<div style="margin-top:45px;"><!--This is required for correct spacing do not remove-->				
					</div>
					<center><span class="eventsFont2" style="font-size:14px;font-family:switzerland;"><strong>
						<?=$eventCounter[0]["RECEIPT_TET_NAME"]; ?>	
						</strong></span>
					</center><br/>
					<div style="margin-top:-8px;">
					</div>
					<center class="eventsFont2" style="font-size:14px;font-family:switzerland;"><strong>
							<?=$templename[0]["TRUST_NAME"]?>
						</strong>
					</center>
					<div style="margin-top:52px;"><!--This is required for correct spacing do not remove-->
					</div>
					<center class="eventsFont2" style="display:none;font-size:11px;padding-bottom:4px;" id="sevaPrints<?=$s?>"><strong>Seva Receipt</strong></center>
					<center class="eventsFont2"  style="font-size:11px;padding-bottom:4px;" id="duplicate"><strong><?php if($eventCounter[0]['PRINT_STATUS'] == 1) echo 'Duplicate Seva Receipt' ?></strong></center>
					<center class="eventsFont2" style="display:none;font-size:11px;padding-bottom:4px;" id="duplicates<?=$s?>"><strong>Duplicate Seva Receipt</strong></center>
					<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Receipt Date&nbsp;:</strong> <?=$eventCounter[0]["TET_RECEIPT_DATE"];?></span><br/>
					<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Receipt No&nbsp;&nbsp;&nbsp;&thinsp;:</strong> <?=$eventCounter[0]['TET_RECEIPT_NO'] ?></span>
					<div style="margin-bottom:6px;"></div>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Name&emsp;&ensp;&ensp;&nbsp;&thinsp;: <?=$eventCounter[0]['TET_RECEIPT_NAME'] ?></strong></span><br/>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Number&ensp;&ensp;&ensp;:</strong> <?=$eventCounter[0]['TET_RECEIPT_PHONE'] ?></span><br/>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Rashi&ensp;&ensp;&ensp;&nbsp;&nbsp;&thinsp;&thinsp;:</strong> <?=$eventCounter[0]['TET_RECEIPT_RASHI'] ?></span><br/>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Nakshatra&nbsp;: </strong><?=$eventCounter[0]['TET_RECEIPT_NAKSHATRA'] ?></span><br/>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Address&nbsp;&nbsp;&thinsp;&thinsp;&thinsp;:</strong> <?=$eventCounter[0]['TET_RECEIPT_ADDRESS'] ?></span>
					<div style="margin-bottom:6px;"></div>
					<?php 
						$subTotal = 0;
						$totalAmt = 0;
						$qty1 = intval($qty[$s]);
						$totalAmt = intval($actualPrice[$s]) * intval($qty1);
						$subTotal += $totalAmt;
					?> 
					<?php if(intval($isSeva[$s]) == 0) { //echo $actualPrice[$s]." x ".$qty1." = ".$sevaAmt[$s]; ?>
						<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Prasad&nbsp;: <?=$sevaName[$s] ?></strong></span><br/>
						<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Quantity&nbsp;: <?=$qty1 ?></strong></span><br/>
						<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Price&nbsp;: Rs. <?=$actualPrice[$s]; ?>/- <?=AmountInWords($actualPrice[$s]);?></strong></span><br/><!-- <br/> -->
						<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Total Amount&nbsp;: <?=$subTotal ?><?=AmountInWords($subTotal);?></strong></span>
					<?php } else { ?>
							<?php if($checkCount == 0) {
								$dateDup = array_unique(explode(", ", $date[$s]))[0]; ?>
								<?php 
									$sevaDup = "";
									foreach($duplicateSevas[0] as $key => $value) {
										if($duplicateSevas[0][$key] > 1) {
											$sevaDup .= $key." ( ".$duplicateSevas[0][$key]." ), "; 
										?>
										<?php } else { 
											$sevaDup .= $key . ", ";	 
										?>	
										<?php } ?>
									<?php }
									$sevaDup = implode(", ",array_unique(explode(", ", $sevaDup)));
									if(substr($sevaDup, -2) == ", ")
										$sevaDup = substr($sevaDup, 0, -2);
									?>
									<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Seva&nbsp;: <?=$sevaDup; ?></strong></span><br/>
							<?php } else { ?>
									<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Seva&nbsp;: <?=$sevaName[$s] ?></strong></span><br/>
									<?php 
										$dateDup = "";								
										foreach(explode(", ",$date[$s]) as $arrResDate) {
											if($duplicateDates[$s][$arrResDate] > 1) {
												$dateDup .= $arrResDate." ( ".$duplicateDates[$s][$arrResDate]." ), "; 
											?>
											<?php	} else { 
												$dateDup .= $arrResDate . ", ";	 
											?>
											<?php } ?>
									<?php } 
									$dateDup = implode(", ",array_unique(explode(", ", $dateDup)));
									if(substr($dateDup, -2) == ", ")
										$dateDup = substr($dateDup, 0, -2) ?>
							<?php } ?>
							<span style="font-size:8px;letter-spacing:1px;" class="eventsFont2"><strong>Date&nbsp;: <?=$dateDup; ?></strong></span><br/><br/>
							<?php if($checkCount != 0) { ?>
									<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Price&nbsp;: Rs. <?=$actualPrice[$s]; ?>/-<?=AmountInWords($actualPrice[$s]);?></strong></span>
							<?php } ?>
							<?php if($checkCount == 0) { ?>
								<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Total Amount&nbsp;: <?=$totalPrice ?><?=AmountInWords($totalPrice);?></strong></span>
							<?php } ?>
					<?php } ?> 
					<br/><!-- <br/> -->
					<!-- <?php if($deityCounter[0]['POSTAGE_PRICE'] != 0) { ?>
						<span style="font-size:11px;letter-spacing:1px;"><strong>Postage&nbsp;: Rs. <?=$deityCounter[0]['POSTAGE_PRICE']; ?>/- <?=AmountInWords($deityCounter[0]['POSTAGE_PRICE']);?></strong></span><br/>
					<?php } ?> -->
					<span style="font-size:11px;letter-spacing:1px;"><strong>Payment Mode&nbsp;:</strong> <?=$eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD']; ?></span><br/>
					<?php if($eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD'] == "Cheque") { ?>
						<span style="font-size:11px;letter-spacing:1px;"><strong>Cheque Number&nbsp;:</strong> <?=$eventCounter[0]['CHEQUE_NO']; ?></span>
						<span style="font-size:11px;letter-spacing:1px;"><strong>Cheque Date&nbsp;: </strong><?=$eventCounter[0]['CHEQUE_DATE']; ?></span>
						<span style="font-size:11px;letter-spacing:1px;"><strong>Bank&nbsp;: </strong><?=$eventCounter[0]['BANK_NAME']; ?></span>
						<span style="font-size:11px;letter-spacing:1px;"><strong>Branch&nbsp;:</strong> <?=$eventCounter[0]['BRANCH_NAME']; ?></span><br/>
					<?php } else if($eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD'] == "Credit / Debit Card") { ?><br/>
						<span style="font-size:11px;letter-spacing:1px;"><strong>Transaction Id&nbsp;: </strong><?=$eventCounter[0]['TRANSACTION_ID']; ?></span><br/>
					<?php } ?>
					<?php if($eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD_NOTES'] != "") { ?>
						<span style="font-size:11px;letter-spacing:1px;"><strong>Notes&nbsp;: </strong><?=$eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD_NOTES'] ?></span>
					<?php } ?><br/><br/>
					<span style="font-size:11px;float:right;letter-spacing:1px;position: static;"><strong>Issued By&nbsp;:</strong> <?=$eventCounter[0]['TET_RECEIPT_ISSUED_BY'] ?></span><br/>
					<span style="font-size:7px;letter-spacing:1px;position: static;"><strong><span style="color:red;">* </span> Seva Prasadam should be collected on the same day of the seva </strong></span><br/>
							<!--<center style="clear:both;font-size: 30px;">*************************</center>-->
				</form>
			</page>
				<!-- <?php if(@$deity_type != "") break; ?> -->
		<?php } ?>
	</div>
<!--for printing ends -->
	
<div class="container">
	<form class="form-group">
		<div class="row form-group">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="col-lg-4 col-md-4  col-sm-4 col-xs-12" style="padding-left:0px;">
					<span class="eventsFont2" style="font-size:20px;">Trust Event Seva Receipt</span>
				</div>
				<div class="col-lg-6  col-md-6 col-sm-7 col-xs-10">
					<center><label class="eventsFont2 samFont1"><?=$eventCounter[0]["RECEIPT_TET_NAME"]; ?></label></center>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-1 col-xs-2" style="padding-right:0px;">
					<a class="pull-right" style="border:none; outline:0;" href="<?=$_SESSION['actual_link'] ?>" title="Back"><img style="border:none; outline: 0;margin-top:1px;" src="<?php echo base_url(); ?>images/back_icon.svg"></a>
				</div>
			</div>
		</div>
			
		<div class="form-group">
			<span class="eventsFont2">Receipt Date: <?=$eventCounter[0]["TET_RECEIPT_DATE"];?></span>
			<span style="float:right;clear:both;" class="eventsFont2">Receipt Number: <?=$eventCounter[0]['TET_RECEIPT_NO'] ?></span>
		</div>
			  
		<div class="form-group">
			<span style="font-size:18px;"><strong>Name: </strong><?=$eventCounter[0]['TET_RECEIPT_NAME'] ?></span>
			<?php if($eventCounter[0]['TET_RECEIPT_RASHI'] != "") { ?>
					<span style="float:right;font-size:18px;"><strong>Rashi: </strong><?=$eventCounter[0]['TET_RECEIPT_RASHI'] ?></span>
			<?php } ?>
		</div>
			  
		<div class="form-group">
			<?php if($eventCounter[0]['TET_RECEIPT_PHONE'] != "") { ?>
				<span style="font-size:18px;"><strong>Number: </strong><?=$eventCounter[0]['TET_RECEIPT_PHONE'] ?></span>
			<?php } ?>
			<?php if($eventCounter[0]['TET_RECEIPT_NAKSHATRA'] != "") { ?>
				<span style="float:right;clear:both;font-size:18px;"><strong>Nakshatra: </strong><?=$eventCounter[0]['TET_RECEIPT_NAKSHATRA'] ?></span>
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
							$qty = @$result["TET_SO_QUANTITY"];
							if($qty == "") {
								$qty = 1;
							}
							
							$total = ($result["TET_SO_PRICE"] * $qty);
							$subTotal += $total;
							
							echo "<tr><td>".$i++."</td>";
							echo "<td>". $result["TET_SO_SEVA_NAME"]."</td>";
							echo "<td>". $qty."</td>";
							echo "<td>". $result["TET_SO_DATE"]."</td>";
							echo "<td>". $result["TET_SO_PRICE"]."</td>";
							echo "<td>". $total ."</td></tr>";
						}
					?>
				</tbody>
			</table>
		</div>

		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-left" style="padding-left:0px">
			<div class="form-group">
				<?php if($eventCounter[0]['TET_RECEIPT_ADDRESS'] != "") { ?>
					<div class="form-group">
						<span style="font-size:18px;"><strong>Address: </strong><?=$eventCounter[0]['TET_RECEIPT_ADDRESS'] ?></span>
					</div>
				<?php } ?> 
				<span style="font-size:18px"><strong>Mode Of Payment: </strong><?=$eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD']; ?></span>
				<?php if($eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD'] == "Cheque") { ?><br/>
					<span style="font-size:18px;"><strong>Cheque Number: </strong><?=$eventCounter[0]['CHEQUE_NO']; ?></span><br/>
					<span style="font-size:18px;"><strong>Cheque Date: </strong><?=$eventCounter[0]['CHEQUE_DATE']; ?></span><br/>
					<span style="font-size:18px;"><strong>Bank: </strong><?=$eventCounter[0]['BANK_NAME']; ?></span><br/>
					<span style="font-size:18px;"><strong>Branch: </strong><?=$eventCounter[0]['BRANCH_NAME']; ?></span><br/>
				<?php } else if($eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD'] == "Credit / Debit Card") { ?><br/>
					<span style="font-size:18px;"><strong>Transaction Id: </strong><?=$eventCounter[0]['TRANSACTION_ID']; ?></span><br/>
				<?php } ?><br/>
				<?php if($eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD_NOTES'] != "") { ?>
					<span style="font-size:18px;"><strong>Notes: </strong><?=$eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD_NOTES'] ?></span><br/>
				<?php } ?><br/>
			</div>
		</div>

		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right" style="padding-left:0px;">
			<div class="form-group ">
				<span style="float:right " class="eventsFont2">Total Amount: <?=$subTotal ?></span></br>
			</div>
			<div class="form-group ">
				<span style="float:right; font-size:18px;margin-left:15px;" ><?=AmountInWords($subTotal);?></span></br>
			</div>
				<?php if($eventCounter[0]['POSTAGE_PRICE'] != 0) { ?>
					<div class="form-group">
						<span style="float:right;font-size:18px;margin-left:15px;"><strong>Postage Amount: </strong><?=$eventCounter[0]['POSTAGE_PRICE'] ?></span>
						 <br/> 
					</div>
				<?php } ?> 
				<div class="form-group ">
					<span style="float:right;font-size:18px;margin-left:15px;"> <?=AmountInWords($eventCounter[0]['POSTAGE_PRICE']);?></span></br>
				</div>
				<div class="form-group ">
					<span style="font-size:18px;float:right;"><strong>Issued By: </strong><?=$eventCounter[0]['TET_RECEIPT_ISSUED_BY'] ?></span><br/>
				</div>
				</br>
		</div>

		<div class="">
			<div class="form-group">
				<center>
					<?php if($eventCounter[0]['TET_RECEIPT_ACTIVE'] == 0) { ?>	
					<?php } else { ?>
						<button type="button" id="print" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-print"></span> Print Receipt</button>
						<?php if($this->session->userdata('userGroup') == 1 || $this->session->userdata('userGroup') == 6) { ?>
							<?php if($eventCounter[0]['AUTHORISED_STATUS'] == "No") { ?>
								<button type="button" id="cancel" onclick="show_cancelled('<?php echo $eventCounter[0]['TET_RECEIPT_ID']; ?>','<?php echo $eventCounter[0]['TET_RECEIPT_NO']; ?>')" class="btn btn-default btn-lg"><span style="top: 2px;" class="glyphicon glyphicon-remove-circle"></span> Cancel Receipt</button>
							<?php } ?>
						<?php } ?>
					<?php } ?>
				</center>
			</div>
		</div>
	</form>
</div>

<iframe style="width:76mm;height:1px;visibility:hidden;" id="printing-frame" name="print_frame" src="about:blank">
</iframe>

<!-- Cancelled Modal2 -->
<div id="myModalCancelled" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content" style="padding-bottom:1em;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" style="margin-top:-14px;">&times;</button>
				<h4 class="modal-title">Add Cancellation Notes</h4>
			</div>
			<div class="modal-body" id="cancelleddet" style="overflow-y: auto;max-height: 330px;">
				<textarea id="cancelNotes" rows="4" cols="50" style="width: 100%;resize:vertical;"></textarea>		
				<button type="button" id="submitNotes" class="btn btn-default pull-right">SAVE</button>
			</div>
		</div>
	</div>
</div>

<form id="submitForm" action="<?php echo site_url(); ?>TrustReceipt/save_cancel_note_event/" class="form-group" role="form" enctype="multipart/form-data" method="post">
	<input type="hidden" id="rId" name="rId" />
	<input type="hidden" id="rNo" name="rNo" />
	<input type="hidden" id="cNote" name="cNote" />
</form>	

<script>
	var receiptId = "<?=@$eventCounter[0]['TET_RECEIPT_ID'] ?>"

	//These two lines for showing re print
	if('<?php echo $eventCounter[0]['PRINT_STATUS']?>' == 1)
		$('#print').html(" Re-Print Receipt");

	if('<?php echo $eventCounter[0]['PRINT_STATUS']?>' != 1){
		for(i=0;i<'<?php echo count($eventCounter)?>';i++){
		   $('#sevaPrint'+i).show();	
		}
		for(i=0;i<'<?=count($eventCounter)?>';i++){
			$('#sevaPrints'+i).show();	
			console.log('#sevaPrints'+i);
		}
	}

	//These three lines to show duplicate on receipt for the first time
	if('<?php echo $eventCounter[0]['PRINT_STATUS']?>' == 1)
		$('#duplicate').show();

	var duplicate = 0; 

	var print = function() {		
		if(document.getElementById("eventUpdate").children.length > 1) {
			// console.log("<?=@$deity_type; ?>".substr(0,5))
			// var deity_type = "<?=@$deity_type; ?>".substr(0,5);
			// if(deity_type != "Every")
				confirmMultiPrintSevaReceipt();
			// else singlePrint();
		} else singlePrint();
	}

	function singlePrint() {
		var newWin = window.frames["print_frame"]; 
		newWin.document.write('<html><head><link href="<?php echo  base_url(); ?>css/print.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/quickSand.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/fonts.googleapis.css" rel="stylesheet" type="text/css"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" crossorigin="anonymous"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-theme.min.css" crossorigin="anonymous"><link href="<?php echo  base_url(); ?>css/jquery-ui.theme.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.structure.min.css" rel="stylesheet"</head>' + '<body onload="window.print()" style="min-height:90%;">'+ $('#printScreen').html() +'</body></html>');
		newWin.document.close();
	}
	
	$('#print').on('click',function(e){
		let url = "<?=site_url(); ?>TrustEvents/saveEventPrintHistory"
		$.post(url,{'receiptId':receiptId,'printStatus':1})
		
		<?php if($eventCounter[0]['PRINT_STATUS'] != 1) { ?>
			if(duplicate == 1){
				var i;
				for(i=0;i<'<?php echo count($eventCounter)?>';i++){
					$('#duplicate'+i).show();
					$('#sevaPrint'+i).hide();
					$('#duplicatePostage2').show();
				}
				for(i=0;i<'<?php echo count($eventCounter)?>';i++) {
					$('#duplicates'+i).show();
					$('#sevaPrints'+i).hide();
				}
			}  else {
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


