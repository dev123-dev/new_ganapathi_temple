<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png">
	<!--Heading And Refresh Button-->
	<div class="row form-group">
		<div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
			<span class="eventsFont2"><?=$templename[0]["TEMPLE_NAME"]?> Day Book</span>
		</div>
		
	</div>
	<!--DateField, Reports Button And Combobox -->
	<div class="row">
		<form id="tddate" enctype="multipart/form-data" method="post" accept-charset="utf-8">
			<input type="hidden" name="radioOpt" id="radioOpt" value="<?=@$radioOpt; ?>">
			<input type="hidden" name="allDates" id="allDates" value="<?=@$allDates; ?>">
			<?php if(isset($date)) {?>
				<input type="hidden" name="tdate" id="tdate" value="<?php echo $date; ?>">
			<?php } ?>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="radio form-group">
					<label> 
						<input id="multiDateRadio" class="eventsFont form-control" type="radio" value="" name="optradio"/> Single Date
					</label>&nbsp;&nbsp;&nbsp;
					<label>
						<input id="EveryRadio" class="eventsFont form-control" type="radio" value="" name="optradio"/> Multiple Date
					</label>
				</div>
			</div>
			<div class="multiDate">
				<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5" style="margin-bottom:1em;">
					<div class="input-group input-group-sm">
						<input id="todayDate" name="todayDate" type="text" value="<?php echo $date; ?>" class="form-control todayDate" placeholder="dd-mm-yyyy" readonly = "readonly" onchange="get_datefield_change(this.value)" autocomplete="off">
						<div class="input-group-btn">
						  <button class="btn btn-default toDateBtn" type="button">
							<i class="glyphicon glyphicon-calendar"></i>
						  </button>
						</div>
					</div>
				</div>
			</div>
			
			<div class="EveryRadio" style="display:none;">
				<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
					<div class="form-group">
						<div class="input-group input-group-sm">
							<input name="fromDate" onchange="get_datefield_change(this.value)" id="fromDate" type="text" class="form-control fromDate2" value="<?=@$fromDate; ?>" placeholder="From: dd-mm-yyyy" readonly = "readonly" autocomplete="off" />
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
							<input name="toDate" onchange="get_datefield_change(this.value)" id="toDate" type="text" value="<?=@$toDate; ?>" class="form-control toDate2" placeholder="To: dd-mm-yyyy" readonly = "readonly" autocomplete="off" />
							<div class="input-group-btn">
							  <button class="btn btn-default toDate" type="button">
								<i class="glyphicon glyphicon-calendar"></i>
							  </button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- NEWCODE_28-03_START -->
			<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
				<div class="form-group">
					<select id="receipts_Filter" class="form-control" onchange="GetDataOnFilter(this.value)" style="padding: 1px 6px;height:30px;">
						<?php if(isset($receiptCat)) {?>
							<?php if($receiptCat == "0") { ?>
								<option selected value="0">All Receipt</option>
							<?php } else { ?>
								<option value="0">All Receipt</option>
							<?php } ?>
							<?php if($receiptCat == "1") { ?>
								<option selected value="1">Deity Seva</option>
							<?php } else { ?>
								<option value="1">Deity Seva</option>
							<?php } ?>
							<?php if($receiptCat == "2") { ?>
								<option selected value="2">Deity Donation</option>
							<?php } else { ?>
								<option value="2">Deity Donation</option>
							<?php } ?>
							<?php if($receiptCat == "3") { ?>
								<option selected value="3">Deity Kanike</option>
							<?php } else { ?>
								<option value="3">Deity Kanike</option>
							<?php } ?>
							<?php if($receiptCat == "4") { ?>
								<option selected value="4">Deity Hundi</option>
							<?php } else { ?>
								<option value="4">Deity Hundi</option>
							<?php } ?>	
							<?php if($receiptCat == "5") { ?>
								<option selected value="5">Deity InKind</option>
							<?php } else { ?>
								<option value="5">Deity InKind</option>
							<?php } ?>	
							<?php if($receiptCat == "6") { ?>
								<option selected value="6">SRNS Fund</option>
							<?php } else { ?>
								<option value="6">SRNS Fund</option>
							<?php } ?>
							<?php if($receiptCat == "7") { ?>
								<option selected value="7">Shashwath</option>
							<?php } else { ?>
								<option value="7">Shashwath</option>
							<?php } ?>
							<?php if($receiptCat == "8") { ?>
								<option selected value="8">Jeernodhara Kanike</option>
							<?php } else { ?>
								<option value="8">Jeernodhara Kanike</option>
							<?php } ?>
							<?php if($receiptCat == "9") { ?>
								<option selected value="9">Jeernodhara Hundi</option>
							<?php } else { ?>
								<option value="9">Jeernodhara Hundi</option>
							<?php } ?>
							<?php if($receiptCat == "10") { ?>
								<option selected value="10">Jeernodhara Inkind</option>
							<?php } else { ?>
								<option value="10">Jeernodhara Inkind</option>
							<?php } ?>
							<?php } else { ?>
							<option value="0">All Receipt</option>
							<option value="1">Deity Seva</option>
							<option value="2">Deity Donation</option>
							<option value="3">Deity Kanike</option>
							<option value="4">Deity Hundi</option>
							<option value="5">Deity InKind</option>
							<option value="6">SRNS Fund</option>
							<option value="7">Shashwath</option>
							<option value="8">Jeernodhara Kanike</option>
							<option value="9">Jeernodhara Hundi</option>
							<option value="10">Jeernodhara Inkind</option>
							
						<?php } ?>
					</select>
				</div>
				<input type="hidden" name="receiptCat" id="receiptCat">
			</div>
			<!-- NEWCODE_28-03_END -->

			<div style="display:none;" class="col-lg-3 col-md-3 col-sm-3 col-xs-9" style="margin-bottom:1em;display:none;">
			  <select id="deity" name="deity" class="form-control" onchange="get_deity_change(this.value)">
				<option value="All Deity">All Deity</option>
				<?php if(isset($deityId)) { ?>
					<?php foreach($deity as $result) { ?>
						<?php if($deityId == $result->DEITY_ID) { ?>
							<option value="<?php echo $result->DEITY_ID; ?>" selected><?php echo $result->DEITY_NAME; ?></option>
						<?php } else { ?>
							<option value="<?php echo $result->DEITY_ID; ?>"><?php echo $result->DEITY_NAME; ?></option>
						<?php } ?>
					<?php } ?>
				<?php } else { ?>
					<?php foreach($deity as $result) { ?>
						<option value="<?php echo $result->DEITY_ID; ?>"><?php echo $result->DEITY_NAME; ?></option>
					<?php } ?>
				<?php } ?>
			  </select>
			</div>
		
			<div style="display:none;" class="col-lg-2 col-md-2 col-sm-2 col-xs-9">
			  <select id="modeOfPayment" name="modeOfPayment" class="form-control" onchange="get_payment_mode_change(this.value)">
				<?php if(isset($PMode)) {?>
					<?php if($PMode == "All") { ?>
						<option selected value="All">All = &#8377;<?php if($All->PRICE != "") { echo $All->PRICE; } else { echo "0";} ?></option>
					<?php } else { ?>
						<option value="All">All = &#8377;<?php if($All->PRICE != "") { echo $All->PRICE; } else { echo "0";} ?></option>
					<?php } ?>
					<?php if($PMode == "Cash") { ?>
						<option selected value="Cash">Cash = &#8377;<?php if($Cash->PRICE != "") { echo $Cash->PRICE; } else { echo "0"; } ?></option>
					<?php } else { ?>
						<option value="Cash">Cash = &#8377;<?php if($Cash->PRICE != "") { echo $Cash->PRICE; } else { echo "0"; } ?></option>
					<?php } ?>
					<?php if($PMode == "Cheque") { ?>
						<option selected value="Cheque">Cheque = &#8377;<?php if($Cheque->PRICE != "") { echo $Cheque->PRICE; } else { echo "0"; } ?></option>
					<?php } else { ?>
						<option value="Cheque">Cheque = &#8377;<?php if($Cheque->PRICE != "") { echo $Cheque->PRICE; } else { echo "0"; } ?></option>
					<?php } ?>
					<?php if($PMode == "Credit / Debit Card") { ?>
						<option selected value="Credit / Debit Card">Credit / Debit Card = &#8377;<?php if($Credit_Debit->PRICE != "") { echo $Credit_Debit->PRICE; } else { echo "0"; } ?></option>
					<?php } else { ?>
						<option value="Credit / Debit Card">Credit / Debit Card = &#8377;<?php if($Credit_Debit->PRICE != "") { echo $Credit_Debit->PRICE; } else { echo "0"; } ?></option>
					<?php } ?>
					<?php if($PMode == "Direct Credit") { ?>
						<option selected value="Direct Credit">Direct Credit = &#8377;<?php if($Direct->PRICE != "") { echo $Direct->PRICE; } else { echo "0"; } ?></option>
					<?php } else { ?>
						<option value="Direct Credit">Direct Credit = &#8377;<?php if($Direct->PRICE != "") { echo $Direct->PRICE; } else { echo "0"; } ?></option>
					<?php } ?>
				<?php } else { ?>
						<option value="All">All = &#8377;<?php if($All->PRICE != "") { echo $All->PRICE; } else { echo "0";} ?></option>
						<option value="Cash">Cash = &#8377;<?php if($Cash->PRICE != "") { echo $Cash->PRICE; } else { echo "0"; } ?></option>
						<option value="Cheque">Cheque = &#8377;<?php if($Cheque->PRICE != "") { echo $Cheque->PRICE; } else { echo "0"; } ?></option>
						<option value="Credit / Debit Card">Credit / Debit Card = &#8377;<?php if($Credit_Debit->PRICE != "") { echo $Credit_Debit->PRICE; } else { echo "0"; } ?></option>
						<option value="Direct Credit">Direct Credit = &#8377;<?php if($Direct->PRICE != "") { echo $Direct->PRICE; } else { echo "0"; } ?></option>
				<?php } ?>
			  </select>
			  <!--HIDDEN FIELDS -->
			  <input type="hidden" name="paymentMethod" id="paymentMethod">
			</div>
			
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<div class="form-inline">
					<?php 
						$amount = 0; $cash = 0; $cheque = 0; $debitCredit = 0; $directCredit = 0; 
						if(!empty($temple_day_bookTotal)) {
							$cash = $temple_day_bookTotal->CASH;
							$cheque = $temple_day_bookTotal->CHEQUE;
							$directCredit = $temple_day_bookTotal->DIRECTCREDIT;
							$debitCredit = $temple_day_bookTotal->CREDITDEBIT;
							$amount = $temple_day_bookTotal->GRANDTOTAL;
					    } 
					?>
					<label for="number" id="Amount" style="font-size:18px;margin-top:.3em;"><a onClick="alert('Grand Total Summary', '<b>Grand Total</b> : &#8377;<?=$amount?><br/><b>Cash</b> : &#8377;<?=$cash?><br/><b>Cheque</b> : &#8377;<?=$cheque?><br/><b>Credit / Debit Card</b> : &#8377;<?=$debitCredit?><br/><b>Direct Credit</b> : &#8377;<?=$directCredit?>')" style="color:#800000;">Grand Total: &#8377;<?php echo $amount; ?></a></label>
				</div>
			</div> 
		</form>
		<form id="report" enctype="multipart/form-data" method="post" accept-charset="utf-8">
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-right pull-right">
				<a onclick="GetSendField()" style="cursor:pointer;"><img style="width:24px; height:24px" title="Download Excel Report" src="<?=site_url();?>images/excel_icon.svg"/></a>&nbsp;&nbsp;
				<a style="width:24px; height:24px" class="pull-right img-responsive" href="<?=site_url()?>/Report/temple_day_book" title="Reset"><img title="reset" src="<?=site_url();?>images/refresh.svg"/></a>
			</div>
			
			<!--HIDDEN FIELDS -->
			<input type="hidden" name="payMode" id="payMode">
			<input type="hidden" name="dateField" id="dateField">
			<input type="hidden" name="deityId" id="deityId">
			<input type="hidden" name="allDates" id="allDateField" value="<?=@$allDates; ?>">
			<input type="hidden" name="radioOpt" id="radioOptField" value="<?=@$radioOpt; ?>">
		</form>
	</div>
</div>

<!--Datagrid -->
<style>
	.table td.fit,
	.table th.fit {
		white-space: nowrap;
		width:1%;
	}
</style>
<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>Rt No</th>
						<th>Date</th>
						<th>For</th>
						<th>Type</th>
						<th>Seva Name</th>
						<th>Deity/Event</th>
						<th>Name</th>
						<th>Estimated Price</th>
						<th>Description</th>
						<th>Mode</th>
						<th>Qty</th>
						<th>Amount</th>
						<th>Postage</th>
						<th>Total</th>
						<th>Payment Notes</th>
						<!-- <th>User</th> -->
						<th>Pay Status</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($temple_day_book as $result) { ?>
						<tr class="row1">
							<?php if($result->rType != "") { ?>
								<?php if($result->status == "Cancelled") { ?>
									<td><strike><?php echo $result->rNo; ?></strike></td>
								<?php } else { ?>
									<?php if($result->receiptFor == "Deity" || $result->receiptFor == "Deity (Hall)" || $result->receiptFor == "Jeernodhara" ) { ?>
										<td> <a onClick="printReceiptDeity('<?=$result->rNo; ?>','<?=$result->rId; ?>','<?=$result->rCatId; ?>')" style="color:#800000;"><?php echo $result->rNo; ?></a></td>									
									<?php } else { ?>
										<td> <a onClick="printReceiptEvents('<?=$result->rNo; ?>','<?=$result->rId; ?>','<?=$result->rCatId; ?>')" style="color:#800000;"><?php echo $result->rNo; ?></a></td>
									<?php } ?>
								<?php } ?>
							<?php } else { ?>
									<td></td>
							<?php } ?>
							<?php if($result->rType != "") { ?>
									<td><?php echo $result->rDate; ?></td>
							<?php } else { ?>
									<td></td>
							<?php } ?>
							<?php if($result->rType != "") { ?>
									<td><?php echo $result->receiptFor; ?></td>
							<?php } else { ?>
									<td></td>
							<?php } ?>
							<td><?php echo $result->rType; ?></td>
							<td><?php echo $result->sevaName; ?></td>
							<td><?php echo $result->dtetName; ?></td>
							<td><?php echo $result->rName; ?></td>
							<?php if($result->rType == 'Inkind'|| $result->rType == 'Jeernodhara-Inkind') { ?>
									<td><?php echo $result->apprxAmt; ?> </td>
								<?php } else { ?>
									<td>-</td>
								<?php } ?>
								<?php if($result->rType == 'Inkind' || $result->rType == 'Jeernodhara-Inkind') { ?>
									<td> <?php echo $result->itemDesc; ?> </td>
								<?php } else { ?>
									<td>-</td>
								<?php } ?>
							<td><?php echo $result->rPayMethod; ?></td>	
							<?php if($result->rType == "Inkind" || $result->rType == "Jeernodhara-Inkind") { ?>
								<td><?php echo $result->sevaQty; ?></td>
							<?php } else { ?>
								<td>-</td>
							<?php } ?>
							<td><?php echo $result->amt; ?></td>
							<?php if($result->rType == "Seva") { ?>
								<td><?php echo $result->amtPostage; ?></td>	
							<?php } else { ?>
								<td></td>
							<?php } ?>
							<td><?php echo $result->total; ?></td>
							<td><?php echo $result->RPMNotes; ?></td>
							<!-- <td><?php echo $result->user; ?></td>	 -->
							<?php if($result->status == "Cancelled") { 
							$cancelNotes = str_replace("'","\'",$result->cnclNotes);
							?>
							<td><a class="log mymodelcancel" style="color:#800000;" onclick="show_cancelled('<?php echo $cancelNotes; ?>')"><?php echo $result->status; ?></a></td>
							<?php } else { ?>
								<td><?php echo $result->status; ?></td>
							<?php } ?>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<!-- <ul class="pagination pagination-sm">
				<?=$pages; ?>
			</ul> -->

		</div>
	</div>
	<!--Total DayBook TextField -->
	<div class= "row">
		<ul class="pagination pagination-sm" style="margin-left:15px;margin-top: 0em;">
			<?=$pages; ?>
		</ul>
		<?php if($total_rows != 0) { ?>
		<label class="pull-right" style="font-size:18px;margin-right:15px;margin-top: 0em;">Total Booking: <strong style="font-size:18px"><?php echo $total_rows ?></strong></label>
		<?php } ?>					
	</div>
	<div class= "row col-lg-12 col-md-12 ">
		<a style="color: #800000;font-size:16px;font-weight: bold;"  href="<?=site_url()?>/finance/dayBook" title="View all the Financial Voucher Report">Click here to view Finance Day Book</a>
	</div>
</div>
<!-- Cheque Modal2 -->
<div id="myModalCheque" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content" style="padding-bottom:1em;">
			<div class="modal-header">
				<button type="button" class="close topClosePos" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Cheque Details</h4>
			</div>
			<div class="modal-body" id="cheqdet" style="overflow-y: auto;max-height: 330px;">
			</div>
		</div>
	</div>
</div> 
<!-- Transaction Modal2 -->
<div id="myModalCredit" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content" style="padding-bottom:1em;">
			<div class="modal-header">
				<button type="button" class="close topClosePos" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Credit/Debit Details</h4>
			</div>
			<div class="modal-body" id="creditdet" style="overflow-y: auto;max-height: 330px;">
			</div>
		</div>
	</div>
</div> 
<!-- Cancelled Modal2 -->
<div id="myModalCancelled" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content" style="padding-bottom:1em;">
			<div class="modal-header">
				<button type="button" class="close topClosePos" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Cancelled Notes</h4>
			</div>
			<div class="modal-body" id="cancelleddet" style="overflow-y: auto;max-height: 330px;">
			</div>
		</div>
	</div>
</div> 
	<form id="receiptForm" action="" method="post">
		<input type="hidden" id="receiptId" name="receiptId" />
		<input type="hidden" id="receiptFormat1" name="receiptFormat1" />
	</form>

	<form id="sevaForm" action="<?=site_url(); ?>Events/printSevaReceipt" method="post">
		<input type="hidden" id="receiptFormat2" name="receiptFormat2" />
	</form>

	<form id="receiptFormDeity" action="" method="post">
			<input type="hidden" id="receiptIdDeity" name="receiptId" />
			<input type="hidden" id="receiptFormat1Deity" name="receiptFormatDeity1" />
	</form>

	<form id="deityForm" action="<?=site_url()?>Receipt/printDeityReceipt" method="post">	
		<input type="hidden" id="receiptFormat2deity" name="receiptFormat2" />
		<input type="hidden" id="deityReceiptId" name="deityReceiptId" />
	</form>
<script>	
	var between = [];

	function printReceiptEvents(receiptFormat,receiptId,catId) {
		if(catId == 1) {
			$('#receiptFormat2').val(receiptFormat);
			$('#sevaForm').submit();
		} else if(catId == 2) {
			$('#receiptId').val(receiptId);
			$('#receiptFormat1').val(receiptFormat);
			$('#receiptForm').attr('action','<?=site_url() ?>Receipt/receipt_donationPrint');
			$('#receiptForm').submit();
		} else if(catId == 3) {
			$('#receiptId').val(receiptId);
			$('#receiptFormat1').val(receiptFormat);
			$('#receiptForm').attr('action','<?=site_url() ?>Receipt/receipt_hundiPrint');
			$('#receiptForm').submit();
		} else {
			$('#receiptId').val(receiptId);
			$('#receiptFormat1').val(receiptFormat);
			$('#receiptForm').attr('action','<?=site_url() ?>Receipt/receipt_inkindPrint');
			$('#receiptForm').submit();
		}
	}

	//ADD Receipt
	function printReceiptDeity(receiptFormat,receiptId,catId) {
		if(catId == 1) {
			$('#deityReceiptId').val(receiptId);
			$('#receiptFormat2deity').val(receiptFormat);			
			$('#deityForm').submit();
		} else if(catId == 2) {
			$('#receiptIdDeity').val(receiptId);
			$('#receiptFormat1Deity').val(receiptFormat);
			$('#receiptFormDeity').attr('action','<?=site_url()?>Receipt/receipt_donationDeityPrint');
			$('#receiptFormDeity').submit();
		} else if(catId == 3) {
			$('#receiptIdDeity').val(receiptId);
			$('#receiptFormat1Deity').val(receiptFormat);
			$('#receiptFormDeity').attr('action','<?=site_url()?>Receipt/receipt_donationKanikePrint');
			$('#receiptFormDeity').submit();
		} else if(catId == 4) {
			$('#receiptIdDeity').val(receiptId);
			$('#receiptFormat1Deity').val(receiptFormat);
			$('#receiptFormDeity').attr('action','<?=site_url()?>Receipt/receipt_hundiPrint');
			$('#receiptFormDeity').submit();
		} else if(catId == 5) {
			$('#receiptIdDeity').val(receiptId);
			$('#receiptFormat1Deity').val(receiptFormat);
			$('#receiptFormDeity').attr('action','<?=site_url()?>Receipt/receipt_inkindPrint');
			$('#receiptFormDeity').submit();
		} else if(catId == 6) {
			$('#receiptIdDeity').val(receiptId);
			$('#receiptFormat1Deity').val(receiptFormat);
			$('#receiptFormDeity').attr('action','<?=site_url()?>Receipt/receipt_SRNSDeityPrint');
			$('#receiptFormDeity').submit();			
		} else if(catId == 7) {
			$('#receiptIdDeity').val(receiptId);
			$('#receiptFormat1Deity').val(receiptFormat);
			$('#receiptFormDeity').attr('action','<?=site_url()?>Receipt/receipt_ShaswathPrint');
			$('#receiptFormDeity').submit();
		} else if(catId == 8) {
			$('#receiptIdDeity').val(receiptId);
			$('#receiptFormat1Deity').val(receiptFormat);
			$('#receiptFormDeity').attr('action','<?=site_url()?>Receipt/jeernodhara_kanikePrint');
			$('#receiptFormDeity').submit();
		} else if(catId == 9) {
			$('#receiptIdDeity').val(receiptId);
			$('#receiptFormat1Deity').val(receiptFormat);
			$('#receiptFormDeity').attr('action','<?=site_url()?>Receipt/jeernodhara_hundiPrint');
			$('#receiptFormDeity').submit();
		} else if(catId == 10) {
			$('#receiptIdDeity').val(receiptId);
			$('#receiptFormat1Deity').val(receiptFormat);
			$('#receiptFormDeity').attr('action','<?=site_url()?>Receipt/jeernodhara_inkindPrint');
			$('#receiptFormDeity').submit();
		}
	}
	
	function generateAllDates() {
		between = [];
		var sDate1 = "";
		
		var start = $("#fromDate").datepicker("getDate");
		end = $("#toDate").datepicker("getDate");
		console.log(start)
		currentDate = new Date(start),
		between = [];
		while (currentDate <= end) {
			console.log(currentDate);
			between.push(("0" + currentDate.getDate()).slice(-2) + "-" + ("0" + (currentDate.getMonth() + 1)).slice(-2) + "-" + currentDate.getFullYear());	
			
			currentDate.setDate(currentDate.getDate() + 1);
		}
		newDate = between.join("|")
		console.log(newDate)
		document.getElementById('allDates').value = newDate;
		document.getElementById('allDateField').value =  newDate;
	}

	//Cancelled Model
	function show_cancelled(cancelNotes) {
		var c_url ="<?php echo site_url(); ?>Report/ViewCancelled";
        $.ajax({
			url: c_url,
			data: {'cancelNotes':cancelNotes},          
			type: 'post', 
			success: function(data){  
				$('#cancelleddet').html(data);
				$('#myModalCancelled').modal('show');  
			},
			error: function(data) {
				alert("Error Occured!");
			}
		}); 
	}
	
	//Cheque Model
	function show_cheque(id,cheqNo,cheqDate,Bank,Branch,transactionId){
        var c_url ="<?php echo site_url(); ?>Report/View";
        $.ajax({
			url: c_url,
			data: {'id':id, 'cheqNo': cheqNo, 'cheqDate': cheqDate, 'Bank': Bank, 'Branch': Branch, 'TransactionId': transactionId},          
			type: 'post', 
			success: function(data){  
				if(id == '1') {
					$('#cheqdet').html(data);
					$('#myModalCheque').modal('show');  
				} else if(id == '2') {
					$('#creditdet').html(data);
					$('#myModalCredit').modal('show');  
				}
			},
			error: function(data) {
				alert("Error Occured!");
			}
		});         
    }
	
	//GET SEND POST FIELDS
	function GetSendField() {
		var radio = $('#radioOpt').val();
		let count = 0;
		if(radio == "date"){
			if(!$('#todayDate').val()) {
				$('#todayDate').css('border', "1px solid #FF0000"); 
				++count
			} else {
				$('#todayDate').css('border', "1px solid #000000");
			}
		} else {
			if(!$('#toDate').val()) {
				$('#toDate').css('border', "1px solid #FF0000"); 
				++count
			} else {
				$('#toDate').css('border', "1px solid #000000"); 
			}
			
			if(!$('#fromDate').val()) {
				$('#fromDate').css('border', "1px solid #FF0000"); 
				++count
			} else {
				$('#fromDate').css('border', "1px solid #000000"); 
			}
			
			if(count == 0) {
				generateAllDates();
			}
		}
		
		if(count != 0) {
			alert("Information","Please fill required fields","OK");
			return false;
		}
		
		// document.getElementById('tdate').value = date;
		document.getElementById('paymentMethod').value = $('#modeOfPayment').val();
		document.getElementById('deityId').value = $('#deity').val();
		url = "<?php echo site_url(); ?>Report/temple_day_book_excel";
		$("#tddate").attr("action",url)
		$("#tddate").submit();
	}
	
	function generatePDF() {
		var radio = $('#radioOpt').val();
		let count = 0;
		if(radio == "date"){
			if(!$('#todayDate').val()) {
				$('#todayDate').css('border', "1px solid #FF0000"); 
				++count
			} else {
				$('#todayDate').css('border', "1px solid #000000");
			}
		} else {
			if(!$('#toDate').val()) {
				$('#toDate').css('border', "1px solid #FF0000"); 
				++count
			} else {
				$('#toDate').css('border', "1px solid #000000"); 
			}
			
			if(!$('#fromDate').val()) {
				$('#fromDate').css('border', "1px solid #FF0000"); 
				++count
			} else {
				$('#fromDate').css('border', "1px solid #000000"); 
			}
			
			if(count == 0) {
				generateAllDates();
			}
		}
		
		if(count != 0) {
			alert("Information","Please fill required fields","OK");
			return false;
		}
		
		document.getElementById('payMode').value = $('#modeOfPayment').val();
		document.getElementById('dateField').value = $('#todayDate').val();
		document.getElementById('deityId').value = $('#deity').val();
		url = "<?php echo site_url(); ?>generatePDF/create_deityReceiptpdf";
		$("#report").attr("action",url)
		$("#report").submit();
	}
	
	function print() {		
		let url = "<?php echo site_url(); ?>generatePDF/create_deityReceiptSession";
		radioOpt = document.getElementById('radioOptField').value;
		allDates = document.getElementById('allDates').value;
		$.post(url,{'payMode':$('#modeOfPayment').val(),'dateField':$('#todayDate').val(),'deityId':$('#deity').val(),'radioOpt':radioOpt, 'allDates':allDates}, function(data) {
			let url2 = "<?php echo site_url(); ?>generatePDF/create_deityReceiptPrint";
			if(data == 1) {
					downloadClicked = 0;
					var win = window.open(
					  url2,
					  '_blank'
					);
					
					setTimeout(function(){ win.print();}, 1000); //setTimeout(function(){ win.close();}, 5000);
				}
		})
	}
	
	//ON CHANGE OF DATEFIELD
	function get_datefield_change(date) {
		var radio = $('#radioOpt').val();
		let count = 0;
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
			
			if(count == 0)
				generateAllDates();
		} 
		
		if(count != 0) {
			alert("Information","Please fill required fields","OK");
			return false;
		}
		document.getElementById('tdate').value = date;
		document.getElementById('paymentMethod').value = $('#modeOfPayment').val();
		document.getElementById('deityId').value = $('#deity').val();
		url = "<?php echo site_url(); ?>Report/temple_day_book_on_change_date";
		$("#tddate").attr("action",url)
		$("#tddate").submit();
	}
	
	//ON CHANGE OF DEITY
	function get_deity_change(deityId) {
		var radio = $('#radioOpt').val();
		let count = 0;
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
			
			if(count == 0)
				generateAllDates();
		} 
		
		if(count != 0) {
			alert("Information","Please fill required fields","OK");
			return false;
		}
		
		document.getElementById('tdate').value = $('#todayDate').val();;
		document.getElementById('paymentMethod').value = $('#modeOfPayment').val();
		document.getElementById('deityId').value = deityId;
		url = "<?php echo site_url(); ?>Report/temple_day_book_on_change_date";
		$("#tddate").attr("action",url)
		$("#tddate").submit();
	}
	
	//ON CHANGE OF PAYMENT MODE
	function get_payment_mode_change(paymentMode) {
		var radio = $('#radioOpt').val();
		let count = 0;
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
			
			if(count == 0)
				generateAllDates();
		}
		
		if(count != 0) {
			alert("Information","Please fill required fields","OK");
			return false;
		}
		
		document.getElementById('paymentMethod').value = paymentMode;
		document.getElementById('tdate').value = $('#todayDate').val();
		document.getElementById('deityId').value = $('#deity').val();
		url = "<?php echo site_url(); ?>Report/temple_day_book_on_change_date";
		$("#tddate").attr("action",url)
		$("#tddate").submit();
	}
	
	//FOR DATEFIELD
	var currentTime = new Date()
    var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
    var maxDate =  new Date(currentTime.getFullYear(), currentTime.getMonth() +12, +0); // one day before next month
    $( ".todayDate" ).datepicker({ 
		minDate: "-1Y", 
		//maxDate: 0,
		dateFormat: 'dd-mm-yy',
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50"
    });
     
	$('.todayDate').on('click', function() {
		$( ".todayDate" ).focus();
	})
	
	$(".fromDate2").datepicker({
		//maxDate: 0,
		dateFormat: 'dd-mm-yy',
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50"
	});
	
	$(".toDate2").datepicker({
		//maxDate: 0,
		dateFormat: 'dd-mm-yy',
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50"
	});
	
	$( ".toDate" ).datepicker({ 
		maxDate: 0,
		dateFormat: 'dd-mm-yy'
    });
     
	$('.toDateBtn').on('click', function() {
		$( ".todayDate" ).focus();
	})
	
	$('.toDate').on('click', function() {
		$( ".toDate2" ).focus();
	})
	
	$('.fromDate').on('click', function() {
		$( ".fromDate2" ).focus();
	})
	
	$('#EveryRadio').on('click', function() {
		$('#EveryRadio').css('pointer-event','auto');
		$('#multiDateRadio').css('pointer-event','none');
		$('.EveryRadio').fadeIn();
		$('#selDate').html("");
		$('.multiDate').hide();
		$('#radioOpt').val("multiDate");
		$('#todayDate').datepicker('setDate', null);
		document.getElementById('radioOptField').value = "multiDate";
		url = "<?php echo site_url(); ?>Report/temple_day_book";
		$("#tddate").attr("action",url)
		$("#tddate").submit();
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
		document.getElementById('radioOptField').value = "date";
		url = "<?php echo site_url(); ?>Report/temple_day_book";
		$("#tddate").attr("action",url)
		$("#tddate").submit();
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
		document.getElementById('radioOptField').value = "date";
	} else {
		$('#EveryRadio').css('pointer-event','auto');
		$('#multiDateRadio').css('pointer-event','none');
		$('.EveryRadio').fadeIn();
		$('#selDate').html("");
		$('.multiDate').hide();
		$('#radioOpt').val("multiDate");
		$('#EveryRadio').attr("checked", "checked")
		document.getElementById('radioOptField').value = "multiDate";
	}

	// NEWCODE_28-03_START
	function GetDataOnFilter(receiptCat) {
		document.getElementById('receiptCat').value = receiptCat;
		url = "<?php echo site_url(); ?>Report/temple_day_book_on_change_date";
		$("#tddate").attr("action",url)
		$("#tddate").submit();
	}
</script>
