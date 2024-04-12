<style>
	.city {display:none;}
</style>
<?php 
	//$this->output->enable_profiler(TRUE);
	//for donation amount
	$totalDonation = 0;
	foreach($donation as $amt) {
		$totalDonation += $amt['RECEIPT_PRICE'];
		$totalDonation += $amt['POSTAGE_PRICE'];
	}
	$_SESSION['donation'] = $totalDonation;
	
	//for srns amount
	$totalSRNS = 0;
	foreach($srns as $amt) {
		$totalSRNS += $amt['RECEIPT_PRICE'];
		$totalSRNS += $amt['POSTAGE_PRICE'];
	}
	$_SESSION['srns'] = $totalSRNS;

	//for kanike amount
	$totalKanike = 0;
	foreach($kanike as $amt) {
		$totalKanike += $amt['RECEIPT_PRICE'];
		$totalKanike += $amt['POSTAGE_PRICE'];
	}
	$_SESSION['kanike'] = $totalKanike;
	
	//for kanike cancelled amount
	$cancelledTotalKanike = 0;
	foreach($cancelledKanike as $amt) {
		$cancelledTotalKanike += $amt['RECEIPT_PRICE'];
	}
	$_SESSION['CancelledKanike'] = $cancelledTotalKanike;
	
	//for Jeerno kanike amount
	$totalJeernoKanike = 0;
	foreach($jeernokanike as $amt) {
		$totalJeernoKanike += $amt['RECEIPT_PRICE'];
		$totalJeernoKanike += $amt['POSTAGE_PRICE'];
	}
	$_SESSION['jeernokanike'] = $jeernokanike;
	$_SESSION['totjeernokanike'] = $totalJeernoKanike;
	
	//for Jeerno kanike cancelled amount
	$cancelledTotalJeernoKanike = 0;
	foreach($cancelledJeernoKanike as $amt) {
		$cancelledTotalJeernoKanike += $amt['RECEIPT_PRICE'];
	}
	$_SESSION['CancelledJeernoKanike'] = $cancelledTotalJeernoKanike;	

	//for hundi amount
	$totalHundi = 0;
	foreach($hundi as $amt) {
		$totalHundi += $amt['RECEIPT_PRICE'];
	}
	$_SESSION['hundiOne'] = $hundi;
	$_SESSION['hundi'] = $totalHundi;
	
	//for hundi amount
	$cancelledTotalHundi = 0;
	foreach($hundicancelled as $amt) {
		$cancelledTotalHundi += $amt['RECEIPT_PRICE'];
	}
	$_SESSION['cancelledhundiOne'] = $hundicancelled;
	$_SESSION['cancelledTotalHundi'] = $cancelledTotalHundi;
	
	//for Jeerno hundi amount
	$totalJeernoHundi = 0;
	foreach($jeernohundi as $amt) {
		$totalJeernoHundi += $amt['RECEIPT_PRICE'];
	}
	$_SESSION['jeernohundiOne'] = $jeernohundi;
	$_SESSION['totjeernohundi'] = $totalJeernoHundi;
	
	//for Jeerno hundi amount cancelled
	$cancelledTotalJeernoHundi = 0;
	foreach($jeernohundicancelled as $amt) {
		$cancelledTotalJeernoHundi += $amt['RECEIPT_PRICE'];
	}
	$_SESSION['cancelledjeernohundiOne'] = $jeernohundicancelled;
	$_SESSION['cancelledtotjeernohundi'] = $cancelledTotalJeernoHundi;
	
	//for cancelled donation amount
	$cancelledTotalDonation = 0;
	foreach($cancelledDonation as $amt) {
		$cancelledTotalDonation += $amt['RECEIPT_PRICE'];
	}
	$_SESSION['CancelledDonation'] = $cancelledTotalDonation;
	
	//for cancelled srns amount
	$cancelledTotalSRNS = 0;
	foreach($cancelledSRNS as $amt) {
		$cancelledTotalSRNS += $amt['RECEIPT_PRICE'];
	}
	$_SESSION['CancelledSRNS'] = $cancelledTotalSRNS;
?>
	
<!-- START Content -->	
<!-- START Row -->
<div style="clear:both;" class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<div class="row form-group">							
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
			<span class="eventsFont2">Deity MIS Report </span>
			<a class="pull-right" style="margin-left:5px;" href="<?=site_url()?>Report/deity_mis_report" title="Refresh"><img style="width:24px; height:24px;" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
		</div>
	</div>					
	<div class="row form-group">
		<form action="<?=site_url();?>Report/deity_mis_report" id="dateChange" enctype="multipart/form-data" method="post" accept-charset="utf-8" onsubmit="return field_validation();">
			<input type="hidden" name="date" value="<?=@$date; ?>" id="date" value="">
			<input type="hidden" name="load" id="load" value="">
			<input type="hidden" name="allDates" id="allDates" value="<?=@$allDates; ?>">
			<input type="hidden" name="radioOpt" id="radioOpt" value="<?=$radioOpt; ?>">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="radio form-group">
					<label> 
						<input id="multiDateRadio" class="eventsFont form-control" type="radio" value="" name="optradio" /> Single Date
					</label>&nbsp;&nbsp;&nbsp;
					<label>
						<input id="EveryRadio" class="eventsFont form-control" type="radio" value="" name="optradio"> Multiple Date
					</label>
				</div>
			</div>
			<!--SINGLE DATE -->
			<div class="multiDate">
				<div class="col-lg-2 col-md-2 col-sm-3 col-xs-5">
					<div class="input-group input-group-sm">
						<input style="border-radius:2px;" id="todayDate" name="todayDate" type="text" value="<?=@$date; ?>" class="form-control todayDate"  onchange="GetDataOnDate(this.value,'<?php echo site_url()?>Report/deity_mis_report')" placeholder="dd-mm-yyyy" readonly="readonly"/>
						<div class="input-group-btn">
							<button class="btn btn-default todayDateBtn" type="button">
								<i class="glyphicon glyphicon-calendar"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
			<!--MULTI DATE -->
			<div class="EveryRadio" style="display:none;">
				<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
					<div class="form-group">
						<div class="input-group input-group-sm">
							<input name="fromDate" onchange="GetDataOnDate(this.value,'<?php echo site_url()?>Report/deity_mis_report')" id="fromDate" type="text" class="form-control fromDate2" value="<?=@$fromDate; ?>" placeholder="From: dd-mm-yyyy" readonly="readonly"/>
							<div class="input-group-btn">
								<button class="btn btn-default fromDate" type="button">
									<i class="glyphicon glyphicon-calendar"></i>
								</button>
							</div>	
						</div>		
					</div>			
				</div>				
				
				<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
					<div class="form-group">
						<div class="input-group input-group-sm">
							<input name="toDate" onchange="GetDataOnDate(this.value,'<?php echo site_url()?>Report/deity_mis_report')" id="toDate" type="text" value="<?=@$toDate; ?>" class="form-control toDate2" placeholder="To: dd-mm-yyyy" readonly="readonly"/>
							<div class="input-group-btn">
								<button class="btn btn-default toDate" type="button">
									<i class="glyphicon glyphicon-calendar"></i>
								</button>
							</div>
						</div>
					</div>
				</div>				
			</div>
			
			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-4 text-right pull-right">
				<a onclick="GetSendField()" style="cursor:pointer;"><img style="width:24px; height:24px" title="Download Excel Report" src="<?=site_url();?>images/excel_icon.svg"/></a>&nbsp;&nbsp;
				<a onclick="generatePDF()"><img style="width:24px; height:24px;" title="Download PDF Report" src="<?=site_url();?>images/pdf_icon.svg"/></a>&nbsp;&nbsp;
				<a onClick="printPage();"><img style="width:24px; height:24px;" title="Print Report" src="<?=site_url();?>images/print_icon.svg"/></a>				
			</div>
		</form>
	</div>
	
	<div style="clear:both;" class="w5-row"> 
		<?php $i = 1;$j = 20;
			foreach($deityReceiptCategory as $result) { ?>
				<a href="#" onclick="openCity(event, '<?=$i++;?>');">
					<div id="<?=$j--;?>" class="w5-third tablink w5-bottombar w5-hover-light-grey w5-padding" style="width:14%"><?=$result['RECEIPT_CATEGORY_TYPE'];?></div>
				</a>
		<?php } ?>
	</div>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div id="1" class="w5-container city">
			<br/><br/>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Deity Name</th>
							<th>Seva Name</th>
							<th>Sevas Qty</th>
							<th>Amount</th>
<!-- 							<th>Postage</th>
							<th>Total</th> -->
						</tr>
					</thead>
					<tbody>
						<?php foreach($seva as $result){
							echo "<tr>";
							echo "<td>".$result['SO_DEITY_NAME']."</td>";
							echo "<td>".$result['SO_SEVA_NAME']."</td>";
							echo "<td>".@$result['if(SO_IS_SEVA = 1, count(SO_SEVA_NAME), SUM(SO_QUANTITY))']."</td>";
							echo "<td>".@$result['if(SO_IS_SEVA = 1, SUM(SO_PRICE), SUM(SO_QUANTITY * SO_PRICE))']."</td>";
							// echo "<td>".@$result['POSTAGE_PRICE']."</td>";
							// echo "<td>".(@$result['if(SO_IS_SEVA = 1, SUM(SO_PRICE), SUM(SO_QUANTITY * SO_PRICE))'] + @$result['POSTAGE_PRICE'])."</td>";
							echo "</tr>";
						}?>
					</tbody>
				</table>
			</div>

			<!-- <h3>Postage</h3> -->
			<div class= "row">
				<?php 
				//for total Seva Postage amount
					$totalSevaPostage = 0;	
					foreach($sevaPostage as $amt) {
						$totalSevaPostage += $amt['POSTAGE_PRICE'];	
					}
					$_SESSION['totalSevaPostage'] = $totalSevaPostage;
				?>	
				<label class="pull-right" style="font-size:18px;margin-right:15px;margin-top: -1em;">Postage Total Amount: <strong style="font-size:18px"><?php echo $totalSevaPostage ?></strong></label>	
			</div>

			<h3>Revision</h3>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Deity Name</th>
							<th>Seva Name</th>
							<th>Sevas Qty</th>
							<th>Amount</th>
							<th>Postage</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($revision as $result) {
							echo "<tr>";
							echo "<td>".$result['SO_DEITY_NAME']."</td>";
							echo "<td>".$result['SO_SEVA_NAME']."</td>";
							echo "<td>".@$result['if(SO_IS_SEVA = 1, count(SO_SEVA_NAME), SUM(SO_QUANTITY))']."</td>";
							echo "<td>".@$result['if(SO_IS_SEVA = 1, SUM(SO_PRICE), SUM(SO_QUANTITY * SO_PRICE))']."</td>";
							echo "<td>".@$result['POSTAGE_PRICE']."</td>";
							echo "</tr>";
						} ?>
					</tbody>
				</table>
			</div>

			<h3>Booking</h3>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Deity Name</th>
							<th>Seva Name</th>
							<th>Sevas Qty</th>
							<th>Amount</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($booking as $result) {
							echo "<tr>";
							echo "<td>".$result['SO_DEITY_NAME']."</td>";
							echo "<td>".$result['SO_SEVA_NAME']."</td>";
							echo "<td>".@$result['if(SO_IS_SEVA = 1, count(SO_SEVA_NAME), SUM(SO_QUANTITY))']."</td>";
							echo "<td>".@$result['if(SO_IS_SEVA = 1, SUM(SO_PRICE), SUM(SO_QUANTITY * SO_PRICE))']."</td>";
							echo "</tr>";
						} ?>
					</tbody>
				</table>
			</div>	
			
			<h3>Cancelled</h3>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Deity Name</th>
							<th>Seva Name</th>
							<th>Sevas Qty</th>
							<th>Amount</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($cancelled as $result) {
							echo "<tr>";
							echo "<td>".$result['SO_DEITY_NAME']."</td>";
							echo "<td>".$result['SO_SEVA_NAME']."</td>";
							echo "<td>".@$result['if(SO_IS_SEVA = 1, count(SO_SEVA_NAME), SUM(SO_QUANTITY))']."</td>";
							echo "<td>".@$result['if(SO_IS_SEVA = 1, SUM(SO_PRICE), SUM(SO_QUANTITY * SO_PRICE))']."</td>";
							echo "</tr>";
						} ?>
					</tbody>
				</table>
			</div>
			
			<h3>Booking Cancelled</h3>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Booking Date (Booking No.)</th>
							<th>Deity Name</th>
							<th>Seva Name</th>
							<th>Cancelled Type</th>
							<th>Cancelled By</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($bookingCancelled as $result) {
						    echo "<tr>";
							echo "<td>".$result['SB_DATE']." (".$result['SB_NO'].")"."</td>";
							echo "<td>".$result['SO_DEITY_NAME']."</td>";
							echo "<td>".$result['SO_SEVA_NAME']."</td>";
							if($result['SB_DEACTIVE_BY'] == "System"){
								echo "<td>Auto</td>";
							} else {
								echo "<td>Manual</td>";
							}
							echo "<td>".$result['SB_DEACTIVE_BY']."</td>";
							echo "</tr>";
						}?>
					</tbody>
				</table>
			</div>
		</div>
		
		<div id="2" class="w5-container city">
			<br/><br/>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Receipt No</th>
							<th>Deity Name</th>
							<th>Name</th>
							<th>Address</th>
							<th>Phone</th>
							<th>Amount</th>
							<th>Payment Notes</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($donation_details as $result) {
							echo "<tr>";
							echo "<td>".$result['RECEIPT_NO']."</td>";
							echo "<td>".$result['RECEIPT_DEITY_NAME']."</td>";
							echo "<td>".$result['RECEIPT_NAME']."</td>";
							echo "<td>".$result['RECEIPT_ADDRESS']."</td>";
							echo "<td>".$result['RECEIPT_PHONE']."</td>";
							echo "<td>".$result['RECEIPT_PRICE']."</td>";
							echo "<td>".$result['RECEIPT_PAYMENT_METHOD_NOTES']."</td>";
							echo "</tr>";
						} ?>
					</tbody>
				</table>
			</div>
			<br/>
			<h3>Total Amount: <?=$totalDonation;?></h3>
			
			<br/><br/>
			<h3>Cancelled</h3>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Receipt No</th>
							<th>Deity Name</th>
							<th>Name</th>
							<th>Address</th>
							<th>Phone</th>
							<th>Amount</th>
							<th>Payment Notes</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($cancelled_donation_details as $result) {
							echo "<tr>";
							echo "<td>".$result['RECEIPT_NO']."</td>";
							echo "<td>".$result['RECEIPT_DEITY_NAME']."</td>";
							echo "<td>".$result['RECEIPT_NAME']."</td>";
							echo "<td>".$result['RECEIPT_ADDRESS']."</td>";
							echo "<td>".$result['RECEIPT_PHONE']."</td>";
							echo "<td>".$result['RECEIPT_PRICE']."</td>";
							echo "<td>".$result['RECEIPT_PAYMENT_METHOD_NOTES']."</td>";
							echo "</tr>";
						} ?>
					</tbody>
				</table>
			</div>
			<br/>
			<h3>Total Amount: <?=$cancelledTotalDonation;?></h3>
		</div>
		
		<div id="3" class="w5-container city">
			<br/><br/>
			<?php foreach($allActiveKanike as $row) {
				$indTotal = 0;
				echo "<h3>".$row['KANIKE_NAME']."</h3>";
				?>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Receipt No</th>
							<th>Deity Name</th>
							<th>Name</th>
							<th>Address</th>
							<th>Phone</th>
							<th>Amount</th>
							<th>Payment Notes</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($kanike_details as $result) {
							if($row['KS_ID']==$result['KANIKE_FOR']){
								echo "<tr>";
								echo "<td>".$result['RECEIPT_NO']."</td>";
								echo "<td>".$result['RECEIPT_DEITY_NAME']."</td>";
								echo "<td>".$result['RECEIPT_NAME']."</td>";
								echo "<td>".$result['RECEIPT_ADDRESS']."</td>";
								echo "<td>".$result['RECEIPT_PHONE']."</td>";
								echo "<td>".$result['RECEIPT_PRICE']."</td>";
								echo "<td>".$result['RECEIPT_PAYMENT_METHOD_NOTES']."</td>";
								echo "</tr>";
								$indTotal += ($result['RECEIPT_PRICE'] + $result['POSTAGE_PRICE']);
							}
						} 
						?>
					</tbody>
				</table>
				<h5 style="float: right">Total: <?=$indTotal;?></h5>
			</div>
			<?php }  ?>
			<h3><b>Total Kanike Amount: <?=$totalKanike;?></b></h3>
			
			<br/><br/>
			<h3>Cancelled</h3>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Receipt No</th>
							<th>Deity Name</th>
							<th>Name</th>
							<th>Address</th>
							<th>Phone</th>
							<th>Amount</th>
							<th>Payment Notes</th>
							<th>Kanike For</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($cancelled_kanike_details as $result) {
							echo "<tr>";
							echo "<td>".$result['RECEIPT_NO']."</td>";
							echo "<td>".$result['RECEIPT_DEITY_NAME']."</td>";
							echo "<td>".$result['RECEIPT_NAME']."</td>";
							echo "<td>".$result['RECEIPT_ADDRESS']."</td>";
							echo "<td>".$result['RECEIPT_PHONE']."</td>";
							echo "<td>".$result['RECEIPT_PRICE']."</td>";
							echo "<td>".$result['RECEIPT_PAYMENT_METHOD_NOTES']."</td>";
							echo "<td>".$result['KANIKE_NAME']."</td>";
							echo "</tr>";
						} ?>
					</tbody>
				</table>
			</div>
			<br/>
			<h3>Total Amount: <?=$cancelledTotalKanike;?></h3>
		</div>
			
		<div id="4" class="w5-container city">
			<br/><br/>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Receipt No</th>
							<th>Deity Name</th>
							<th>Amount</th>
							<th>Payment Notes</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($hundi as $result) {
							echo "<tr>";
							echo "<td>".$result['RECEIPT_NO']."</td>";
							echo "<td>".$result['RECEIPT_DEITY_NAME']."</td>";
							echo "<td>".$result['RECEIPT_PRICE']."</td>";
							echo "<td>".$result['RECEIPT_PAYMENT_METHOD_NOTES']."</td>";
							echo "</tr>";
						} ?>
					</tbody>
				</table>
			</div>
			<br/>
			<h3>Total Amount: <?=$totalHundi;?></h3>
			<br/><br/>
			<h3>Cancelled</h3>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Receipt No</th>
							<th>Deity Name</th>
							<th>Amount</th>
							<th>Payment Notes</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($hundicancelled as $result) {
							echo "<tr>";
							echo "<td>".$result['RECEIPT_NO']."</td>";
							echo "<td>".$result['RECEIPT_DEITY_NAME']."</td>";
							echo "<td>".$result['RECEIPT_PRICE']."</td>";
							echo "<td>".$result['RECEIPT_PAYMENT_METHOD_NOTES']."</td>";
							echo "</tr>";
						} ?>
					</tbody>
				</table>
			</div>
			<br/>
			<h3>Total Amount: <?=$cancelledTotalHundi;?></h3>
		</div>
			
		<div id="5" class="w5-container city">
			<br/><br/>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Deity Name</th>
							<th>Item Name</th>
							<th>Quantity</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($inkind as $result) {
							echo "<tr>";
							echo "<td>".$result['RECEIPT_DEITY_NAME']."</td>";
							echo "<td>".$result['DY_IK_ITEM_NAME']."</td>";
							echo "<td>".$result['amount']." ".$result['DY_IK_ITEM_UNIT']."</td>";
							echo "</tr>";
						} ?>
					</tbody>
				</table>
			</div>			
		</div>
		
		<div id="6" class="w5-container city">
			<br/><br/>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Receipt No</th>
							<th>Deity Name</th>
							<th>Name</th>
							<th>Address</th>
							<th>Phone</th>
							<th>Amount</th>
							<th>Payment Notes</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($srns_details as $result) {
							echo "<tr>";
							echo "<td>".$result['RECEIPT_NO']."</td>";
							echo "<td>".$result['RECEIPT_DEITY_NAME']."</td>";
							echo "<td>".$result['RECEIPT_NAME']."</td>";
							echo "<td>".$result['RECEIPT_ADDRESS']."</td>";
							echo "<td>".$result['RECEIPT_PHONE']."</td>";
							echo "<td>".$result['RECEIPT_PRICE']."</td>";
							echo "<td>".$result['RECEIPT_PAYMENT_METHOD_NOTES']."</td>";
							echo "</tr>";
						} ?>
					</tbody>
				</table>
			</div>
			<br/>
			<h3>Total Amount: <?=$totalSRNS;?></h3>
			<br/><br/>
			<h3>Cancelled</h3>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Receipt No</th>
							<th>Deity Name</th>
							<th>Name</th>
							<th>Address</th>
							<th>Phone</th>
							<th>Amount</th>
							<th>Payment Notes</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($cancelled_srns_details as $result) {
							echo "<tr>";
							echo "<td>".$result['RECEIPT_NO']."</td>";
							echo "<td>".$result['RECEIPT_DEITY_NAME']."</td>";
							echo "<td>".$result['RECEIPT_NAME']."</td>";
							echo "<td>".$result['RECEIPT_ADDRESS']."</td>";
							echo "<td>".$result['RECEIPT_PHONE']."</td>";
							echo "<td>".$result['RECEIPT_PRICE']."</td>";
							echo "<td>".$result['RECEIPT_PAYMENT_METHOD_NOTES']."</td>";
						    echo "</tr>";
						} ?>
					</tbody>
				</table>
			</div>
			<br/>
			<h3>Total Amount: <?=$cancelledTotalSRNS;?></h3>
		</div>
		
		<div id="7" class="w5-container city">
			<br/><br/>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th width="30%">Deity Name</th>
							<th>Seva Name</th>
							<th width="10%">Sevas Qty</th>
							<th>Corpus</th>
							<th>Seva Notes</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($shashwath as $result) {
							echo "<tr>";
							echo "<td>".$result['DEITY_NAME']."</td>";
							echo "<td>".$result['SEVA_NAME']."</td>";
							echo "<td>".$result['QTY']."</td>";
							echo "<td>".$result['TOTAL']."</td>";
							echo "<td>".$result['SEVA_NOTES']."</td>";
							echo "</tr>";
						} ?>
					</tbody>
				</table>
			</div>
			<br/>
			<!--<h3>Total Amount: <?=$result['if(RECEIPT_ACTIVE = 1, SUM(RECEIPT_PRICE))'];?></h3>-->
			<br/><br/>
			<h3>Cancelled</h3>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th width="30%">Deity Name</th>
							<th>Seva Name</th>
							<!--<th width="10%">Phone</th>-->
							<th>Corpus</th>
							<th>Cancellation Notes</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($cancelled_shashwath as $result) {
							echo "<tr>";
							echo "<td>".$result['DEITY_NAME']."</td>";
							echo "<td>".$result['SEVA_NAME']."</td>";
						//	echo "<td>".$result['RECEIPT_PHONE']."</td>";
							echo "<td>".$result['RECEIPT_PRICE']."</td>";
							echo "<td>".$result['CANCEL_NOTES']."</td>";
						    echo "</tr>";
						} ?>
					</tbody>
				</table>
			</div>
		</div>
			
		<div id="8" class="w5-container city">
			<br/><br/>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Receipt No</th>
							<th>Name</th>
							<th>Address</th>
							<th>Phone</th>
							<th>Amount</th>
							<th>Payment Notes</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($jeerno_kanike_details as $result) {
							echo "<tr>";
							echo "<td>".$result['RECEIPT_NO']."</td>";
							echo "<td>".$result['RECEIPT_NAME']."</td>";
							echo "<td>".$result['RECEIPT_ADDRESS']."</td>";
							echo "<td>".$result['RECEIPT_PHONE']."</td>";
							echo "<td>".$result['RECEIPT_PRICE']."</td>";
							echo "<td>".$result['RECEIPT_PAYMENT_METHOD_NOTES']."</td>";
							echo "</tr>";
						} ?>
					</tbody>
				</table>
			</div>
			<br/>
			<h3>Total Amount: <?=$totalJeernoKanike;?></h3>
			
			<br/><br/>
			<h3>Cancelled</h3>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Receipt No</th>
							<th>Name</th>
							<th>Address</th>
							<th>Phone</th>
							<th>Amount</th>
							<th>Payment Notes</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($cancelled_jeerno_kanike_details as $result) {
							echo "<tr>";
							echo "<td>".$result['RECEIPT_NO']."</td>";
							echo "<td>".$result['RECEIPT_NAME']."</td>";
							echo "<td>".$result['RECEIPT_ADDRESS']."</td>";
							echo "<td>".$result['RECEIPT_PHONE']."</td>";
							echo "<td>".$result['RECEIPT_PRICE']."</td>";
							echo "<td>".$result['RECEIPT_PAYMENT_METHOD_NOTES']."</td>";
							echo "</tr>";
						} ?>
					</tbody>
				</table>
			</div>
			<br/>
			<h3>Total Amount: <?=$cancelledTotalJeernoKanike;?></h3>
		</div>
			
		<div id="9" class="w5-container city">
			<br/><br/>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Receipt No</th>
							<!--<th>Deity Name</th>-->
							<th>Amount</th>
							<th>Payment Notes</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($jeernohundi as $result) {
							echo "<tr>";
							echo "<td>".$result['RECEIPT_NO']."</td>";
							// echo "<td>".$result['RECEIPT_DEITY_NAME']."</td>";
							echo "<td>".$result['RECEIPT_PRICE']."</td>";
							echo "<td>".$result['RECEIPT_PAYMENT_METHOD_NOTES']."</td>";
							echo "</tr>";
						} ?>
					</tbody>
				</table>
			</div>
			<br/>
			<h3>Total Amount: <?=$totalJeernoHundi;?></h3>
			<br/><br/>
			<h3>Cancelled</h3>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Receipt No</th>
							<!--<th>Deity Name</th>-->
							<th>Amount</th>
							<th>Payment Notes</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($jeernohundicancelled as $result) {
							echo "<tr>";
							echo "<td>".$result['RECEIPT_NO']."</td>";
							// echo "<td>".$result['RECEIPT_DEITY_NAME']."</td>";
							echo "<td>".$result['RECEIPT_PRICE']."</td>";
							echo "<td>".$result['RECEIPT_PAYMENT_METHOD_NOTES']."</td>";
							echo "</tr>";
						} ?>
					</tbody>
				</table>
			</div>
			<br/>
			<h3>Total Amount: <?=$cancelledTotalJeernoHundi;?></h3>
		</div>
			
		<div id="10" class="w5-container city">
			<br/><br/>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<!--<th>Deity Name</th>-->
							<th>Item Name</th>
							<th>Quantity</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($jeernoinkind as $result) {
							echo "<tr>";
							echo "<td>".$result['DY_IK_ITEM_NAME']."</td>";
							echo "<td>".$result['amount']." ".$result['DY_IK_ITEM_UNIT']."</td>";
							echo "</tr>";
						} ?>
					</tbody>
				</table>
			</div>			
		</div>
			
		</div>
	</div>		
</div>
<form method="post" id="report">
	<input type="hidden" id="outputType" name="outputType" />
	<input type="hidden" name="dateHidden" value="<?=@$date; ?>" id="dateHidden">
	<input type="hidden" name="fromDateHidden" id="fromDateHidden" value="<?=@$fromDate; ?>">
	<input type="hidden" name="toDateHidden" id="toDateHidden" value="<?=@$toDate; ?>">
	<input type="hidden" name="radioOptHidden" id="radioOptHidden" value="<?=$radioOpt; ?>">
</form>
<script>
	//For Displaying First Time Selected
	document.getElementById('1').style.display = "block";
	$("#20").addClass("w5-border-red");
	
	var currentTime = new Date()
	var maxDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month

	$( ".todayDate" ).datepicker({
		//maxDate: maxDate,
		dateFormat: 'dd-mm-yy',
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50",
	});
	
	$(".fromDate2").datepicker({
		//maxDate: maxDate,
		dateFormat: 'dd-mm-yy',
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50",
	});
	
	$(".toDate2").datepicker({
		//maxDate: maxDate,
		dateFormat: 'dd-mm-yy',
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50",
	});
	
	if("<?=$radioOpt; ?>" == "date") {
		$('#multiDateRadio').attr("checked", "checked")
		$('#EveryRadio').css('pointer-event','none');
		$('#multiDateRadio').css('pointer-event','auto');
		$('#selDate').html("");
		$('.multiDate').fadeIn();
		$('#fromDate').val("");
		$('#toDate').val("");
		$('.EveryRadio').hide();
		$('#radioOpt').val("date");
		$('#radioOptHidden').val("date");
	} else {
		$('#EveryRadio').css('pointer-event','auto');
		$('#multiDateRadio').css('pointer-event','none');
		$('.EveryRadio').fadeIn();
		$('#selDate').html("");
		$('.multiDate').hide();
		$('#radioOpt').val("multiDate");
		$('#radioOptHidden').val("multiDate");
		$('#EveryRadio').attr("checked", "checked")
	}
	
	$('#EveryRadio').on('click', function() {
		$('#EveryRadio').css('pointer-event','auto');
		$('#multiDateRadio').css('pointer-event','none');
		$('.EveryRadio').fadeIn();
		$('#selDate').html("");
		$('.multiDate').hide();
		$('#radioOpt').val("multiDate");
		$('#radioOptHidden').val("multiDate");
		$('#todayDate').datepicker('setDate', null);
	});
	
	$('#multiDateRadio').on('click', function() {
		$('#EveryRadio').css('pointer-event','none');
		$('#multiDateRadio').css('pointer-event','auto');
		$('#selDate').html("");
		$('.multiDate').fadeIn();
		$('#fromDate').val("");
		$('#toDate').val("");
		$('.EveryRadio').hide();
		$('#radioOpt').val("date");
		$('#radioOptHidden').val("date");
		$('#todayDate').datepicker('setDate', null);
	});
	
	$('.todayDateBtn').on('click', function() {
		$( ".todayDate" ).focus();
	})
	
	$('.toDate').on('click', function() {
		$( ".toDate2" ).focus();
	})
	
	$('.fromDate').on('click', function() {
		$( ".fromDate2" ).focus();
	})
	
	//GET SEND POST FIELDS
	function GetSendField() {
		var start = $("#fromDate");
		var end = $("#toDate"); 
		var todayDate = $("#todayDate"); 
		var count = 0;
		
		if(document.getElementById("EveryRadio").checked) {
			if(!start.val()) {
				start.css('border-color','red');
				++count;
			} else 
				start.css('border-color','#ccc');
				
			if(!end.val()) {
				end.css('border-color','red');
				++count;
			} else 
				end.css('border-color','#ccc');
		} else {
			if(!todayDate.val()) {
				todayDate.css('border-color','red');
				++count;
			} else 
				todayDate.css('border-color','#ccc');
		}
		
		if(count != 0) {
			alert("Information","Please select required field");
			return;
		}
		
		
		url = "<?php echo site_url(); ?>Report/deity_mis_report_excel";
		$("#dateChange").attr("action",url)
		$("#dateChange").submit();
	}
	
	function generatePDF() {
		var start = $("#fromDate");
		var end = $("#toDate"); 
		var todayDate = $("#todayDate"); 
		var count = 0;
		
		if(document.getElementById("EveryRadio").checked) {
			if(!start.val()) {
				start.css('border-color','red');
				++count;
			} else 
				start.css('border-color','#ccc');
				
			if(!end.val()) {
				end.css('border-color','red');
				++count;
			} else 
				end.css('border-color','#ccc');
		} else {
			if(!todayDate.val()) {
				todayDate.css('border-color','red');
				++count;
			} else 
				todayDate.css('border-color','#ccc');
		}
		
		if(count != 0) {
			alert("Information","Please select required field");
			return;
		}
		
		let url = "<?php echo site_url(); ?>generatePDF/create_deityMisReceiptSession";
		$.post(url,{'radioOptHidden':$('#radioOptHidden').val(),'dateHidden':$('#dateHidden').val(),'toDateHidden':$('#toDateHidden').val(),'fromDateHidden':$('#fromDateHidden').val()}, function(data) {
			if(data == 1) {
				url = "<?php echo site_url(); ?>generatePDF/create_deityMisReceipt";
				$("#report").attr("action",url);
				$('#outputType').val("pdf");
				$("#report").submit();		
			}
		});
	}
	
	function printPage() {
		var start = $("#fromDate");
		var end = $("#toDate"); 
		var todayDate = $("#todayDate"); 
		var count = 0;
		
		if(document.getElementById("EveryRadio").checked) {
			if(!start.val()) {
				start.css('border-color','red');
				++count;
			} else 
				start.css('border-color','#ccc');
				
			if(!end.val()) {
				end.css('border-color','red');
				++count;
			} else 
				end.css('border-color','#ccc');
		} else {
			if(!todayDate.val()) {
				todayDate.css('border-color','red');
				++count;
			} else 
				todayDate.css('border-color','#ccc');
		}
		
		if(count != 0) {
			alert("Information","Please select required field");
			return;
		}
		
		let url = "<?php echo site_url(); ?>generatePDF/create_deityMisReceiptSession";
		$.post(url,{'radioOptHidden':$('#radioOptHidden').val(),'dateHidden':$('#dateHidden').val(),'toDateHidden':$('#toDateHidden').val(),'fromDateHidden':$('#fromDateHidden').val()}, function(data) {
			if(data == 1) {
				let url2 = "<?php echo site_url(); ?>generatePDF/create_deityMisReceipt";
				var win = window.open(
					url2,
					'_blank');
				setTimeout(function(){ win.print();}, 1000); //setTimeout(function(){ win.close();}, 5000);			
			}
		});
	}
			
	function field_validation() {
		var count = 0;
		var radio = $('#radioOpt').val();
		if(radio == "date"){
			if(!$('#todayDate').val()) {
				$('#todayDate').css('border', "1px solid #FF0000"); 
				++count
			} else {
				$('#todayDate').css('border', "1px solid #000000"); 
			}
		} else {
			if(!$('#fromDate').val()) {
				$('#fromDate').css('border', "1px solid #FF0000"); 
				++count
			} else {
				$('#fromDate').css('border', "1px solid #000000"); 
			}
		}
		
		if(count != 0) {
			alert("Information","Please fill required fields","OK");
			return false;
		}
	}
	 
	function GetDataOnDate(receiptDate,url) {
		between = [];
		document.getElementById('date').value = receiptDate;
		document.getElementById('load').value = "DateChange";
		document.getElementById('toDateHidden').value = $('#toDate').val();
		document.getElementById('dateHidden').value =  receiptDate;
		document.getElementById('fromDateHidden').value = $('#fromDate').val();
		var sDate1 = "";
		
		var start = $("#fromDate").datepicker("getDate");
		var end = $("#toDate").datepicker("getDate");
		var todayDate = $('#todayDate').val();
		
		currentDate = new Date(start),
		between = [];
		while (currentDate <= end) { 
			console.log(currentDate);
			between.push(("0" + currentDate.getDate()).slice(-2) + "-" + ("0" + (currentDate.getMonth() + 1)).slice(-2) + "-" + currentDate.getFullYear());	
			currentDate.setDate(currentDate.getDate() + 1);
		}
		
		if(between.length == 0)
			between.push(("0" + currentDate.getDate()).slice(-2) + "-" + ("0" + (currentDate.getMonth() + 1)).slice(-2) + "-" + currentDate.getFullYear());
		
		newDate = between.join("|")
		console.log(newDate)
		document.getElementById('allDates').value = newDate;
		$("#dateChange").attr("action",url)
		
		if(document.getElementById("EveryRadio").checked) {
			if(start && end) {
				$("#dateChange").submit();
			}
		} else {
			if(todayDate)
				$("#dateChange").submit();
		}
	}

	function openCity(evt, cityName) {
		var i, x, tablinks;
		x = document.getElementsByClassName("city");
		for (i = 0; i < x.length; i++) {
			x[i].style.display = "none";
		}
		tablinks = document.getElementsByClassName("tablink");
		for (i = 0; i < x.length; i++) {
			tablinks[i].className = tablinks[i].className.replace(" w5-border-red", "");
		}
		document.getElementById(cityName).style.display = "block";
		evt.currentTarget.firstElementChild.className += " w5-border-red";
	}
</script> 
