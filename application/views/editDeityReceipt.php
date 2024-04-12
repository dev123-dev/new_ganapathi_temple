 <style>
    .datepicker {
      z-index: 1600 !important; /* has to be larger than 1050 */
    } .chequeDate2 {
      z-index: 1600 !important; /* has to be larger than 1050 */
    }
</style>
 <?php 
				// $this->output->enable_profiler(TRUE);
					$arrDate = [];
					for($i = 0; $i < count($deityCounter); ++$i) {
						$arrDate[$i] = $deityCounter[$i]["SO_DATE"];
					}
					
					usort($arrDate, function($a, $b) {
						$dateTimestamp1 = strtotime($a);
						$dateTimestamp2 = strtotime($b);

						return $dateTimestamp1 < $dateTimestamp2 ? -1: 1;
					});

					$minDate = $arrDate[0];
					$maxDate = $arrDate[count($arrDate) - 1];
			 ?>
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
					
					foreach($deityCounter as $result) {
							$sevaName[$i] = $result["SO_SEVA_NAME"];
							$date[$i] = $result["SO_DATE"];
							if(intval($result["SO_QUANTITY"]) != 0)
								$count = intval($result["SO_QUANTITY"]);
							else 
								$count = 1;
							$qty[$i] =  intval($count);
							$sevaAmt[$i] = intval($result["SO_PRICE"]);
							$actualPrice[$i] = intval($result["SO_PRICE"]);
							$actualQty[$i] = intval($result["SO_QUANTITY"]);
							$isSeva[$i] =  $result['SO_IS_SEVA'];
							++$i;
						
					}
					
					//making duplicate to single
					
					// $qty = [];
					// $date = [];
					// $sevaName = [];
					// $sevaAmt = [];
					// $isSeva = [];
					// $actualPrice = [];
					// $actualQty = [];
					// $i = 0;
					// $count = 1;
					
					// foreach($deityCounter as $result) {
						
						// if(empty($sevaName)) {
							// $sevaName[$i] = $result["SO_SEVA_NAME"];
							// $date[$i] = $result["SO_DATE"];
							// if(intval($result["SO_QUANTITY"]) != 0)
								// $count = intval($result["SO_QUANTITY"]);
							// else 
								// $count = 1;
							// $qty[$i] =  intval($count);
							// $sevaAmt[$i] = intval($result["SO_PRICE"]);
							// $actualPrice[$i] = intval($result["SO_PRICE"]);
							// $actualQty[$i] = intval($result["SO_QUANTITY"]);
							// $isSeva[$i] =  $result['SO_IS_SEVA'];
						// }else if($sevaName[$i] == $result["SO_SEVA_NAME"] && $date[$i] == $result["SO_DATE"]) {
							// $sevaName[$i] = $result["SO_SEVA_NAME"];
							// $date[$i] = $result["SO_DATE"];
							
							// if(intval($result["SO_QUANTITY"]) != 0)
								// $count += intval($result["SO_QUANTITY"]);
							// else 
								// ++$count;
							// $actualQty[$i] = intval($result["SO_QUANTITY"]);
							// $count += intval($result["SO_QUANTITY"]);
							// $qty[$i] = $count;
							// $actualPrice[$i] = intval($result["SO_PRICE"]);
							// $sevaAmt[$i] += intval($result["SO_PRICE"]);
							// $isSeva[$i] =  $result['SO_IS_SEVA'];
							
						// }else if($sevaName[$i] != $result["SO_SEVA_NAME"] && $date[$i] != $result["SO_DATE"]) {
							
							// $sevaName[++$i] = $result["SO_SEVA_NAME"];
							// $actualQty[$i] = intval($result["SO_QUANTITY"]);
							// $sevaAmt[$i] = intval($result["SO_PRICE"]);
							// $actualPrice[$i] = intval($result["SO_PRICE"]);
							// $date[$i] = $result["SO_DATE"];
							// $count = intval($result["SO_QUANTITY"]);
							// if(intval($result["SO_QUANTITY"]) != 0)
								// $count = intval($result["SO_QUANTITY"]);
							// else 
								// $count = 1;
							// $qty[$i] = intval($count);
							// $isSeva[$i] =  $result['SO_IS_SEVA'];
						// }else if($sevaName[$i] == $result["SO_SEVA_NAME"] && $date[$i] != $result["SO_DATE"]) {
							
							// $sevaName[++$i] = $result["SO_SEVA_NAME"];
							// $actualPrice[$i] = intval($result["SO_PRICE"]);
							// $sevaAmt[$i] = intval($result["SO_PRICE"]);
							// $actualQty[$i] = intval($result["SO_QUANTITY"]);
							// $date[$i] = $result["SO_DATE"];
							// if(intval($result["SO_QUANTITY"]) != 0)
								// $count = intval($result["SO_QUANTITY"]);
							// else 
								// $count = 1;
							// $qty[$i] = intval($count);
							// $isSeva[$i] =  $result['SO_IS_SEVA'];
						// }
					// }
				?>
				
	<!--for printing --><div id="printScreen" style="display:none;">
	<?php for($s = 0; $s < count($sevaName); ++$s) { ?>
		<page style="margin-top:25px;margin-left:75%;width:115%;margin-right:75%;">
			<form>
				<!--<center><span class="eventsFont2 samFont2">
					<?=$deityCounter[0]["RECEIPT_DEITY_NAME"]; ?>
					
				</span></center><br/>-->
					<center class="eventsFont2" style="font-size:14px;margin-top:8px;font-family:switzerland;padding-top:30px;"><strong>
						<?=$templename[0]["TEMPLE_NAME"]?>
					</strong></center>
					<div style="margin-top:75px;"></div>
				<!--<center class="eventsFont2">
					V.T. Road, UDUPI.
				</center>
				<center class="eventsFont2">
					Phone : 2520860
				</center><br/>-->
				<center class="eventsFont2" style="display:none;font-size:11px;padding-bottom:4px;" id="duplicate"><strong><?="Duplicate Receipt "?></strong></center><br/>
				<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2">Receipt Date&nbsp;: <?=$deityCounter[0]["RECEIPT_DATE"];?></span><br/>
				<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2">Receipt No&nbsp;&nbsp;&nbsp;&thinsp;: <?=$deityCounter[0]['RECEIPT_NO'] ?></span>
				<div style="margin-bottom:5px;"></div>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Name&emsp;&ensp;&ensp;&nbsp;&thinsp;: <?=$deityCounter[0]['RECEIPT_NAME'] ?></strong></span><br/>
				<?php if($deityCounter[0]['RECEIPT_PHONE'] != "") { ?>
					<span style="font-size:11px;letter-spacing:1px;">Number&ensp;&ensp;&ensp;: <?=$deityCounter[0]['RECEIPT_PHONE'] ?></span><br/>
				<?php } ?>
				<?php if($deityCounter[0]['RECEIPT_RASHI'] != "") { ?>
					<span style="font-size:11px;letter-spacing:1px;">Rashi&ensp;&ensp;&ensp;&nbsp;&nbsp;&thinsp;&thinsp;: <?=$deityCounter[0]['RECEIPT_RASHI'] ?></span><br/>
				<?php } ?>
				<?php if($deityCounter[0]['RECEIPT_NAKSHATRA'] != "") { ?>
					<span style="font-size:11px;letter-spacing:1px;">Nakshatra&nbsp;: <?=$deityCounter[0]['RECEIPT_NAKSHATRA'] ?></span><br/>
				<?php } ?>
				<?php if($deityCounter[0]['RECEIPT_RASHI'] != "" || $deityCounter[0]['RECEIPT_PHONE'] != "" || $deityCounter[0]['RECEIPT_NAKSHATRA'] != "") { ?>
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
							<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2">Price Rs.&nbsp; <?=$actualPrice[$s]; ?>/- <?=AmountInWords($actualPrice[$s]);?><br/><!-- <br/> -->
							<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Total Amount&nbsp;: <?=$subTotal ?><?=AmountInWords($subTotal);?></strong></span>
						<?php } else {
							//echo $sevaAmt[$s];
						 ?>
							<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Seva&nbsp;: <?=$sevaName[$s] ?></strong></span><br/>
							<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Date&nbsp;: <?=$date[$s] ?></strong></span><br/>
							<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Price Rs.&nbsp; <?=$sevaAmt[$s]; ?>/- <?=AmountInWords($sevaAmt[$s]);?></strong></span>
						<?php } ?>
					<br/><!-- <br/> -->
				<span style="font-size:11px;letter-spacing:1px;">Payment Mode&nbsp;: <?=$deityCounter[0]['RECEIPT_PAYMENT_METHOD']; ?></span><br/>
				<?php if($deityCounter[0]['RECEIPT_PAYMENT_METHOD'] == "Cheque") { ?>
					<span style="font-size:11px;letter-spacing:1px;">Cheque Number&nbsp;: <?=$deityCounter[0]['CHEQUE_NO']; ?></span>
					<span style="font-size:11px;letter-spacing:1px;">Cheque Date&nbsp;: <?=$deityCounter[0]['CHEQUE_DATE']; ?></span>
					<span style="font-size:11px;letter-spacing:1px;">Bank&nbsp;: <?=$deityCounter[0]['BANK_NAME']; ?></span>
					<span style="font-size:11px;letter-spacing:1px;">Branch&nbsp;: <?=$deityCounter[0]['BRANCH_NAME']; ?></span><br/>
				<?php } else if($deityCounter[0]['RECEIPT_PAYMENT_METHOD'] == "Credit / Debit Card") { ?><br/>
					<span style="font-size:11px;letter-spacing:1px;">Transaction Id&nbsp;: <?=$deityCounter[0]['TRANSACTION_ID']; ?></span><br/>
				<?php } ?>
					<?php if($deityCounter[0]['RECEIPT_PAYMENT_METHOD_NOTES'] != "") { ?>
						<span style="font-size:11px;letter-spacing:1px;">Notes&nbsp;: <?=$deityCounter[0]['RECEIPT_PAYMENT_METHOD_NOTES'] ?></span>
					<?php } ?><br/><br/>
					<span style="font-size:11px;float:right;letter-spacing:1px;">Issued By&nbsp;: <?=$deityCounter[0]['RECEIPT_ISSUED_BY'] ?></span><br/>
					<span style="font-size:7px;letter-spacing:1px;padding-top:2px;" class="print"><strong><span style="color:red;">* </span>  Seva Prasadam should be collected on the same day of the seva </strong></span>
			</form>
		</page>
	<?php } ?>
	</div><!--for printing ends -->
	
	<div class="container">
		<form class="form-group">
			  <div class="form-group">
				<center><label class="eventsFont2 samFont1"><?=$deityCounter[0]["RECEIPT_DEITY_NAME"]; ?></label></center>
				<?php if(@$fromAllReceipt == "1") { ?>
					<a class="pull-right" style="border:none; outline:0;" href="<?=$_SESSION['actual_link'] ?>" title="Back"><img style="border:none; outline: 0;margin-top: -71px;" src="<?php echo base_url(); ?>images/back_icon.svg"></a>
				<?php }else { ?>
					<a class="pull-right" style="border:none; outline:0;" href="<?=site_url() ?>Sevas/" title="Back"><img style="border:none; outline: 0;margin-top: -71px;" src="<?php echo base_url(); ?>images/back_icon.svg"></a>
				<?php } ?>
			  </div>
			  <div class="form-group">
				<span class="eventsFont2">Receipt Date: <?=$deityCounter[0]["RECEIPT_DATE"];?></span>
				<span style="float:right;clear:both;margin-top: -25px;" class="eventsFont2">Receipt Number: <?=$deityCounter[0]['RECEIPT_NO'] ?></span>
			  </div>
			  
			  <div class="form-group">
				<span style="font-size:18px;"><strong>Name: </strong><?=$deityCounter[0]['RECEIPT_NAME'] ?></span>
				<?php if($deityCounter[0]['RECEIPT_RASHI'] != "") { ?>
					<span style="float:right;clear:both;font-size:18px;"><strong>Rashi: </strong><?=$deityCounter[0]['RECEIPT_RASHI'] ?></span>
				<?php } ?>
			  </div>
			  
			   <div class="form-group">
				<?php if($deityCounter[0]['RECEIPT_PHONE'] != "") { ?>
					<span style="font-size:18px;"><strong>Number: </strong><?=$deityCounter[0]['RECEIPT_PHONE'] ?></span>
				<?php } ?>
				<?php if($deityCounter[0]['RECEIPT_NAKSHATRA'] != "") { ?>
					<span style="float:right;clear:both;font-size:18px;"><strong>Nakshatra: </strong><?=$deityCounter[0]['RECEIPT_NAKSHATRA'] ?></span>
				<?php } ?>
			  </div>
			 
			  <?php if($deityCounter[0]['DATE_TYPE'] != "") { ?>
				  <div class="form-group">
						<span style="font-size:18px;"><strong>Date Range: </strong><?=$deityCounter[0]['DATE_TYPE'] ?> from <?=$minDate; ?> to <?=$maxDate; ?></span>
				  </div>
			  <?php } ?>
			  
			  <div class="clear:both;table-responsive">
				<table id="eventSeva" class="table table-bordered">
					<thead>
					  <tr>
						<th>Sl. No.</th>
						<th>Deity Name</th>
						<th>Seva Name</th>
						<th>Qty</th>
						<th>Seva Date</th>
						<th>Seva Amount</th>
						<th>Total Seva Amount</th>
						<th>Op</th>
					  </tr>
					</thead>
					<tbody id="eventUpdate">
					<?php 
					$i = 1;
					
					$subTotal = 0;
					foreach($deityCounter as $result) {
						$SO_ID = $result['SO_ID'];
						$SO_SEVA_ID = $result["SO_SEVA_ID"];
						$SO_IS_SEVA = $result["SO_IS_SEVA"];
						$SO_DATE = $result["SO_DATE"];
						$SO_NAME = $result['SO_SEVA_NAME'];
						$SO_PRICE = $result["SO_PRICE"];
						$receiptNo = $deityCounter[0]['RECEIPT_NO'];
						$receiptName = $deityCounter[0]['RECEIPT_NAME'];
						$receiptPhone = $deityCounter[0]['RECEIPT_PHONE'];
						$deityName = $result["SO_DEITY_NAME"];
						$deityId = $result["SO_DEITY_ID"];
						$revisionChecker = $result["REVISION_PRICE_CHECKER"];
						
						$qty = @$result["SO_QUANTITY"];
						if($qty == "" || $qty == "0") {
							$qty = 1;
						}
						
						$total = ($result["SO_PRICE"] * $qty);
						$subTotal += $total;
						
						echo "<tr><td>".$i++."</td>";
						echo "<td>". $result["SO_DEITY_NAME"]."</td>";
						echo "<td>". $result["SO_SEVA_NAME"]."</td>";
						echo "<td>". $qty."</td>";
						echo "<td class='sevaDate'>". $result["SO_DATE"]."</td>";
						echo "<td>". $result["SO_PRICE"]."</td>";
						echo "<td>". $total ."</td>";
						echo "<td style='display:none;' class='soSevaId'>". $SO_SEVA_ID ."</td>";
						if($result["UPDATED_SO_DATE"] == "" && $result["SO_IS_SEVA"] == "1" && strtotime($result["SO_DATE"]) >= strtotime(date('d-m-Y')))
							echo "<td style=''><a title='Edit' onClick='edit($SO_ID, $SO_SEVA_ID, $SO_IS_SEVA, \"$SO_DATE\", \"$SO_NAME\", $SO_PRICE, \"$receiptName\", \"$receiptPhone\", \"$deityName\", \"$deityId\", \"$receiptNo\", $revisionChecker)';><span style='color:#800000' class='glyphicon glyphicon-pencil'></span></a></td>";
						echo "</tr>";
					}
					?>
					</tbody>
				</table>
			  </div>
			   <div class="form-group">
				<span style="float:right" class="eventsFont2">Total Amount: <?=$subTotal ?></span>
			  </div>
			  
			   <div class="form-group">
				<span style="font-size:18px"><strong>Mode Of Payment: </strong><?=$deityCounter[0]['RECEIPT_PAYMENT_METHOD']; ?></span>
				<?php if($deityCounter[0]['RECEIPT_PAYMENT_METHOD'] == "Cheque") { ?><br/>
					<span style="font-size:18px;margin-left:15px;"><strong>Cheque Number: </strong><?=$deityCounter[0]['CHEQUE_NO']; ?></span><br/>
					<span style="font-size:18px;margin-left:15px;"><strong>Cheque Date: </strong><?=$deityCounter[0]['CHEQUE_DATE']; ?></span><br/>
					<span style="font-size:18px;margin-left:15px;"><strong>Bank: </strong><?=$deityCounter[0]['BANK_NAME']; ?></span><br/>
					<span style="font-size:18px;margin-left:15px;"><strong>Branch: </strong><?=$deityCounter[0]['BRANCH_NAME']; ?></span><br/>
				<?php } else if($deityCounter[0]['RECEIPT_PAYMENT_METHOD'] == "Credit / Debit Card") { ?><br/>
					<span style="font-size:18px;margin-left:15px;"><strong>Transaction Id: </strong><?=$deityCounter[0]['TRANSACTION_ID']; ?></span><br/>
				<?php } ?><br/>
				<?php if($deityCounter[0]['RECEIPT_PAYMENT_METHOD_NOTES'] != "") { ?>
					<span style="font-size:18px;"><strong>Notes: </strong><?=$deityCounter[0]['RECEIPT_PAYMENT_METHOD_NOTES'] ?></span><br/>
				<?php } ?><br/>
					<span style="font-size:18px;float:right"><strong>Issued By: </strong><?=$deityCounter[0]['RECEIPT_ISSUED_BY'] ?></span>
			  </div>
		</form>
		
		<form id="editForm" style="display:none;margin-left: -13px;" method="post" action="<?=site_url()?>\Receipt\updateReceipt">
			<div class="form-inline">
				<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
					<label for="seva">Seva Date <span style="color:#800000;">*</span></label>
					<div class="form-group">
						<div class="input-group input-group-sm multiDate">
							<input id="multiDate" type="text" value="" class="form-control todayDate2" placeholder="dd-mm-yyyy">
							<div class="input-group-btn">
							  <button class="btn btn-default todayDate" type="button">
								<i class="glyphicon glyphicon-calendar"></i>
							  </button>
							</div>
						</div><br/><br/>
						<button type="button" id="update" class="btn btn-default btn-md"><span class="glyphicon glyphicon-edit"></span> Update Receipt</button>
					</div>
				</div>
			</div>
		</form>
	
	</div>
	
	<div class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myLargeModalLabel" id="modalShow">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header" id="modal-header" style="display:none;">
					<h4 class="modal-title">Information</h4>
				</div>
				<div class="modal-header" id="modal-header1" style="display:none;">
					<h4 class="modal-title">Kanike Receipt</h4>
				</div>
				<div class="modal-body" id="modal-body" style="overflow-y: auto;max-height: 80vmin;display:none;">
					
				</div>
				
				<div class="modal-body" id="modal-body1" style="overflow-y: auto;max-height: 80vmin;display:none;">
					<div class="form-group col-lg-6">
						<label  class="control-label" for="inputEmail3">Name : </label>&nbsp;&nbsp;<span id="receiptName"></span>
					</div>
					
					<div class="form-group col-lg-6">
						<label  class="control-label" for="inputEmail3">Phone : </label>&nbsp;&nbsp;<span id="receiptPhone"></span>
					</div>
				  
					<div class="form-group col-lg-6">
						<label  class="control-label" for="inputEmail3">Deity : </label>&nbsp;&nbsp;<span id="deityName"></span>
					</div>
					
					<div class="form-group col-lg-6" style="display:none;">
						<label  class="control-label" for="inputEmail3">Deity Id : </label>&nbsp;&nbsp;<span id="deityId"></span>
					</div>
					
					<div class="form-group col-lg-6" style="display:none;">
						<label  class="control-label" for="inputEmail3">Receipt No : </label>&nbsp;&nbsp;<span id="receiptNo"></span>
					</div>
				  
					<div class="form-group col-lg-6">
						<label class="control-label" for="inputEmail3">Amount : &nbsp;&nbsp;<span id="amt" style="font-size:18px;"></span></label>
					</div>

					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-8" style="margin-bottom: 2em;">
						<div class="form-inline">
						  <label for="modeOfPayment">Mode Of Payment <span style="color:#800000;">*</span> : </label>
						  <select id="modeOfPayment" name="modeOfPayment" class="form-control">
							<option value="">Select Payment Mode</option>
							<option value="Cash">Cash</option>
							<option value="Cheque">Cheque</option>
							<option value="Direct Credit">Direct Credit</option>
							<option value="Credit / Debit Card">Credit / Debit Card</option>
						  </select>
						</div>
					</div>
					
					<div style="display:none" id="showChequeList">
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-8" style="margin-bottom: 2em;">
							<div class="form-inline">
								<label for="chequename">Cheque No: <span style="color:#800000;">*</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="text" class="form-control form_contct2" id="chequeNo" placeholder="" name="chequeNo">
							</div>
						</div>
							
						<div class="col-lg-5 col-md-5 col-sm-12 col-xs-8" style="margin-bottom: 2em;">
							<div class="form-group">
								<label for="chequedates">Cheque Date: <span style="color:#800000;">*</span></label>&nbsp;&nbsp;
								<div class="input-group input-group-sm">
									<input id="chequeDate" name="chequeDate" type="text" value="" class="form-control form_contct2 chequeDate2" placeholder="dd-mm-yyyy">
									<div class="input-group-btn">
									  <button class="btn btn-default chequeDate" type="button">
										<i class="glyphicon glyphicon-calendar"></i>
									  </button>
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-10" style="margin-bottom: 2em;">
							<div class="form-inline">
							  <label for="bankname">Bank Name: <span style="color:#800000;">*</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							  <input type="text" class="form-control form_contct2" id="bank" placeholder="" name="bank">
							</div>
						</div>
						
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-10" style="margin-bottom: 2em;">
							<div class="form-inline">
							  <label for="branchname">Branch Name: <span style="color:#800000;">*</span></label>&nbsp;&nbsp;
							  <input type="text" class="form-control form_contct2" id="branch" placeholder="" name="branch">
							</div>
						</div>
					</div>

					<div style="display:none;" id="showDebitCredit">
						<div class="form-inline col-lg-6" style="margin-bottom: 2em;">
							<label for="name">Transaction Id:
								<span style="color:#800000;">*</span>
							</label>&nbsp;&nbsp;
							<input type="text" class="form-control form_contct2" id="transactionId" placeholder="" name="transactionId">
						</div>
					</div>
		  
					<div class="form-group col-lg-12">
						<label for="comment">Payment Notes: </label>
						<textarea class="form-control" rows="4" id="paymentNotes" name="paymentNotes"></textarea>
					</div>
				</div>

				<div class="modal-footer text-left" id="modal-footer" style="text-align:left;display:none;">
					<label>Are you sure you want to continue..?</label>
					<br/>
					<button style="width: 15%;" type="button" class="btn btn-default sevaButton" id="dateChange">Continue</button>
					<button style="width: 15%;" type="button" class="btn btn-default sevaButton" data-dismiss="modal">Cancel</button>
				</div>
				
				<div class="modal-footer text-left" id="modal-footer1" style="text-align:left;display:none;">
					<label>Are you sure you want to continue..?</label>
					<br/>
					<button style="width: 15%;" type="button" class="btn btn-default sevaButton" id="kanikeSubmit">Continue</button>
					<button style="width: 15%;" type="button" class="btn btn-default sevaButton" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>

	<iframe style="width:76mm;height:1px;visibility:hidden;" id="printing-frame" name="print_frame" src="about:blank"></iframe>
	
<script>
	var receiptId = "<?=@$deityCounter[0]['RECEIPT_ID'] ?>"
	var currentTime = new Date("<?=date('D M d Y H:i:s O'); ?>");
	var id1 = "";
	var soDate1 = "";
	var sevaId1 = "";
	
	var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + (Number(currentTime.getDate())+1));
	if('<?php echo @$duplicate; ?>' != "no") {
		$('#duplicate').show();
	}
	
	var currentTime = new Date("<?=date('Y-m-d'); ?>")
	var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
	var maxDate = new Date(currentTime.getFullYear(), currentTime.getMonth() + 12, +0); // one day before next month
	
	var duplicate = 0; 
	var print = function() {
		var newWin = window.frames["print_frame"]; 
		newWin.document.write('<html><head><link href="<?php echo  base_url(); ?>css/print.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/quickSand.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/fonts.googleapis.css" rel="stylesheet" type="text/css"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" crossorigin="anonymous"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-theme.min.css" crossorigin="anonymous"><link href="<?php echo  base_url(); ?>css/jquery-ui.theme.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.structure.min.css" rel="stylesheet"</head>' + '<body onload="window.print()">'+ $('#printScreen').html() +'</body></html>');
		newWin.document.close();
	}
	var revision = ""
	var revisionChecker = ""
	var sevaName = ""
	var receiptNo = ""
	var receiptName = ""
	var receiptPhone = ""
	var deityName = ""
	var deityId = ""
	var multiDate = "";
	var sevaPrice = 0
	function edit(id, sevaId, isSeva, soDate, sevaName2, sevaPrice2,receiptName2,receiptPhone2,deityName2,deityId2,receiptNo2, revisionChecker2) {
	
		//$SO_ID, $SO_SEVA_ID, $SO_IS_SEVA, \"$SO_DATE\"
		$('#multiDate').val("");
		$('#multiDateHidden').val("");
		$('#updateId').val("");
		id1 = id;
		sevaId1 = sevaId;
		isSeva1 = isSeva;
		soDate1 = soDate;
		sevaName = sevaName2;
		sevaPrice = sevaPrice2;
		receiptNo = receiptNo2;
		receiptName = receiptName2;
		receiptPhone = receiptPhone2;
		deityName = deityName2;
		deityId = deityId2;
		revisionChecker = revisionChecker2;
		paymentNotes = "Test " + "(<?=$deityCounter[0]['RECEIPT_NO'] ?>) ";
		//check for revision
		let url = "<?=base_url()?>Receipt/getRevision"
		
		$.post(url,{sevaId:sevaId}, function(data) {
			revision = JSON.parse(data)
			// console.log(revision)
			
			if(revisionChecker == 1) {
				
				let revisDate = new Date(revision[0].REVISION_DATE.toString().split("-").reverse())
				let rowDate = new Date(soDate1.toString().split("-").reverse())
				var minDate = revisDate;
					
				$("#multiDate").datepicker({
					minDate: minDate,
					
					dateFormat: 'dd-mm-yy',
					autoclose: false,
					onSelect: function (selectedDate) {
						$('#selDate').html($('#multiDate').val());
						$('#multiDate').blur();
						$('#multiDate').css('border-color', "#000000");
					}
				});
				
			}else {
				var currentTime = new Date("<?=date('Y-m-d'); ?>")
				var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
				var maxDate = new Date(currentTime.getFullYear(), currentTime.getMonth() + 12, +0); // one day before next month
				$("#multiDate").datepicker({
					minDate: minDate,
					
					dateFormat: 'dd-mm-yy',
					autoclose: false,
					onSelect: function (selectedDate) {
						$('#selDate').html($('#multiDate').val());
						$('#multiDate').blur();
						$('#multiDate').css('border-color', "#000000");
					}
				});
			}
		});
		
		$('#editForm').slideDown();
	}
	
	$('#update').on('click', function() {
		$('#modal-header1').hide();
		$('#modal-body1').hide();
		$('#modal-footer1').hide();
		
		$('#modal-header').fadeIn("slow");
		$('#modal-body').fadeIn("slow");
		$('#modal-footer').fadeIn("slow");
		
		multiDate = $('#multiDate').val();

		if(!multiDate) {
			alert("Information","Please Enter valid Date")
			return;
		}
		
		let sevaDates = document.getElementsByClassName("sevaDate");
		let soSevaId = document.getElementsByClassName("soSevaId");
		let count = 0;
		for(i = 0; i < sevaDates.length; ++i) {
			if(((sevaDates[i].innerHTML).trim() == multiDate) && ((soSevaId[i].innerHTML).trim() == sevaId1)) {
				++count;
			}
		}
		
		if(count != 0) {
			alert("Information","Date already taken");
			return;
		}
		console.log(revision)
		if(revisionChecker != 1) {
			let selDate = new Date(multiDate.toString().split("-").reverse())
			let oldSevaDate = new Date(soDate1.toString().split("-").reverse())
			let revisDate = new Date(revision[0].REVISION_DATE.toString().split("-").reverse())
			if(oldSevaDate < revisDate) {
				if(selDate >= revisDate) {
					console.log(sevaName)
					console.log(sevaPrice)
					$('#modal-body').html("Seva Price for <strong>'" +sevaName + "'</strong> will be revised to <strong>&#8377; " + revision[0].SEVA_PRICE +" </strong> from <strong>" +revision[0].REVISION_DATE +".</strong> The difference amount &#8377; <strong>" +(Number(revision[0].SEVA_PRICE) - sevaPrice) +"</strong> will be taken as kanike receipt in a name of Sevadhar")
					$('.modal').modal();
				}
			} else {
				$.post("<?=site_url()?>Receipt/updateReceipt",{'multiDatehidden': multiDate.toString(), 'updateId': id1}, function(e) {
					location.reload();
				 });
			}
		}else {
			$.post("<?=site_url()?>Receipt/updateReceipt",{'multiDatehidden': multiDate.toString(), 'updateId': id1}, function(e) {
				location.reload();
			});
		}
		
		//$.post("<?=site_url()?>Receipt/updateReceipt",{'multiDatehidden': multidate, 'updateId': id1}, function(e) {
			//location.reload();
		 //});
	});
		
	$('#dateChange').on('click', function() {
		$('#modal-header').hide();
		$('#modal-body').hide();
		$('#modal-footer').hide(); 
		
		$('#modal-header1').fadeIn("slow");
		$('#modal-body1').fadeIn("slow");
		$('#modal-footer1').fadeIn("slow");
		
		$('#receiptNo').html(receiptNo);
		$('#receiptName').html(receiptName);
		$('#receiptPhone').html(receiptPhone);
		$('#deityName').html(deityName);
		$('#deityId').html(deityId);
		$('#amt').html((Number(revision[0].SEVA_PRICE) - sevaPrice));
		$('#paymentNotes').html(paymentNotes);
	});
	
	$('#kanikeSubmit').on('click', function() {
		var count = 0;
		let amt = (Number(revision[0].SEVA_PRICE) - sevaPrice)
		
		$('select').each(function(){
			var id = this.id;
			if($('#' + id).val() != "") {
				$('#' + id).css('border-color', "#000000");
				if($('#' + id).val() == "Cheque") {
					if (document.getElementById("chequeNo").value.length == 6) {
						$('#chequeNo').css('border-color', "#000000");
					} else {
						$('#chequeNo').css('border-color', "#FF0000");
						++count;
					}
					
					if (document.getElementById("chequeDate").value != "") {
						$('#chequeDate').css('border-color', "#000000");
					} else {
						$('#chequeDate').css('border-color', "#FF0000");
						++count;
					}
					
					if (document.getElementById("bank").value != "") {
						$('#bank').css('border-color', "#000000");
					} else {
						$('#bank').css('border-color', "#FF0000");
						++count;
					}
					
					if (document.getElementById("branch").value != "") {
						$('#branch').css('border-color', "#000000");
					} else {
						$('#branch').css('border-color', "#FF0000");
						++count;
					}
				} else if($('#' + id).val() == "Credit / Debit Card") {
					if (document.getElementById("transactionId").value != "") {
						$('#transactionId').css('border-color', "#000000");
					} else {
						$('#transactionId').css('border-color', "#FF0000");
						++count;
					}
				}
			} else {
				$('#' + id).css('border-color', "#FF0000");
				++count;
			}
		});
		
		if(count != 0) {
			alert("Information","Please fill required fields","OK");
			return false;
		} else {
			$.post("<?=site_url()?>Receipt/updateKanike",{'modeOfPayment': $('#modeOfPayment').val(),'branch': $('#branch').val(),'bank': $('#bank').val(),'chequeDate': $('#chequeDate').val(),'chequeNo': $('#chequeNo').val(),'transactionId': $('#transactionId').val(),'paymentNotes': $('#paymentNotes').val(),'amount': $('#amt').html(),'receiptPhone': $('#receiptPhone').html(),'receiptName': $('#receiptName').html(),'deityName': $('#deityName').html(), 'deityId': $('#deityId').html(), 'receiptNo': $('#receiptNo').html()}, function(e) {
				$.post("<?=site_url()?>Receipt/updateReceipt",{'multiDatehidden': multiDate, 'updateId': id1}, function(e) {
					location.href = "<?=site_url()?>Receipt/receipt_donationKanikePrint";
				});
			});
		}
	});
	
	$('.todayDate').on('click', function() {
		$("#multiDate").focus();
	});
	
	$('#modeOfPayment').on('change', function () {
		if (this.value == "Cheque") {
			$('#showChequeList').fadeIn("slow");
			$('#showDebitCredit').fadeOut("slow");
		} else if (this.value == "Credit / Debit Card") {
			$('#showChequeList').fadeOut("slow");
			$('#showDebitCredit').fadeIn("slow");
		} else {
			$('#showChequeList').fadeOut("slow");
			$('#showDebitCredit').fadeOut("slow");
		}

	});
	
	$('#print').on('click',function() {
		let url = "<?=site_url(); ?>Receipt/saveDeityPrintHistory"
		$.post(url,{'receiptId':receiptId})
		
		if(duplicate == 1) {
			$('#duplicate').show();
		}
		print();
		$('#print').html(" Re-Print Receipt");
		duplicate++;
	});
	
	//location.href = "<?=site_url()?>";
	
	//INPUT KEYPRESS
	$(':input').on('keypress change', function() {
		var id = this.id;
		$('#' + id).css('border-color', "#000000");
	});
	
	//SELECT CHANGE
	$('select').on('change', function() {
		var id = this.id;
		$('#' + id).css('border-color', "#000000");
	});
	
	<!-- Amount Validation -->
	$('#amt').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^0-9]/g, function(str) { return ''; } ) );
	});
	
	<!-- Cheque Number Validation -->
	$('#chequeNo').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^0-9]/g, function(str) { return ''; } ) );
	});
	
	<!-- Transaction Id Validation -->
	$('#transactionId').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^A-Za-z0-9]/g, function(str) { return ''; } ) );
	});
	
	var readOnlyLength = ("Test " + "(<?=$deityCounter[0]['RECEIPT_NO'] ?>) ").length;
	$('#paymentNotes').on('keydown', function(event) {
		var $field = $(this);
		if ((event.which != 37 && (event.which != 39))
			&& ((this.selectionStart < readOnlyLength)
			|| ((this.selectionStart == readOnlyLength) && (event.which == 8)))) {
			return false;
		}
	});      
	
	//Cheque Datefield
	var currentTime = new Date()
	var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
	var maxDate =  new Date(currentTime.getFullYear(), currentTime.getMonth() +12, +0); // one day before next month
	
	$( ".chequeDate2" ).datepicker({ 
		minDate: minDate, 
		maxDate: maxDate,
		dateFormat: 'dd-mm-yy'
	});
	
	$('.chequeDate').on('click', function() {
		$( ".chequeDate2" ).focus();
	});
</script>
