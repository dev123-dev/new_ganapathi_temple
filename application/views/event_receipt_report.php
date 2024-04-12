<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<!--Heading And Refresh Button-->
	<div class="row form-group">
		<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
			<span class="eventsFont2">Current Event Receipt Report: <span class="samFont"><?php echo $events[0]->ET_NAME; ?></span></span>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="margin-top: 1em;">
			<a style="width:24px; height:24px" class="pull-right img-responsive" href="<?=site_url()?>Report/event_receipt_report" title="Refresh"><img title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
		</div>
	</div>
	
	<!--DateField, Reports Button And Combobox -->
	<div class="row form-group">
		<form id="tddate" enctype="multipart/form-data" method="post" accept-charset="utf-8">
			<input type="hidden" name="radioOpt" id="radioOpt" value="<?=@$radioOpt; ?>">
			<input type="hidden" name="allDates" id="allDates" value="<?=@$allDates; ?>">
			<?php if(isset($date)) {?>
					<input type="hidden" name="tdate" id="tdate" value="<?php echo $date; ?>">
				<?php } ?>
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
			<div class="multiDate">
				<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5" style="margin-bottom:1em;">
					<div class="input-group input-group-sm">
						<input id="todayDate" name="todayDate" type="text" value="<?php echo $date; ?>" class="form-control todayDate" placeholder="dd-mm-yyyy" onchange="get_datefield_change(this.value)" readonly="readonly">
						<div class="input-group-btn">
						  <button class="btn btn-default todayDateBtn" type="button">
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
							<input name="fromDate" onchange="get_datefield_change(this.value)" id="fromDate" type="text" class="form-control fromDate2" value="<?=@$fromDate; ?>" placeholder="From: dd-mm-yyyy" readonly="readonly"/>
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
							<input name="toDate" onchange="get_datefield_change(this.value)" id="toDate" type="text" value="<?=@$toDate; ?>" class="form-control toDate2" placeholder="To: dd-mm-yyyy" readonly="readonly"/>
							<div class="input-group-btn">
							  <button class="btn btn-default toDate" type="button">
								<i class="glyphicon glyphicon-calendar"></i>
							  </button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-9" style="margin-bottom:1em;display:none;">
			  <select id="deity" name="deity" class="form-control" disabled>
				<?php foreach($events as $result) { ?>
					<option value="<?php echo $result->ET_ID; ?>"><?php echo $result->ET_NAME; ?></option>
				<?php } ?>
			  </select>
			</div>
<!-- code from abhishek -->

		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
				<select id="users" name="users" class="form-control" onchange="GetDataOnUser(this.value,'<?php echo site_url()?>Report/event_report_on_change_date')">
					<option selected value="All Users">All Users</option>
					
					<?php foreach($users as $result) { ?>
						<?php if(isset($user)) { ?>
							<?php if($user == $result->USER_ID) { ?>
								<option selected value="<?php echo $result->USER_ID; ?>"><?php echo $result->USER_FULL_NAME; ?></option>
							<?php } else { ?>
								<option value="<?php echo $result->USER_ID; ?>"><?php echo $result->USER_FULL_NAME; ?></option>
							<?php } ?>
						<?php } else { ?>
							<option value="<?php echo $result->USER_ID; ?>"><?php echo $result->USER_FULL_NAME; ?></option>
						<?php } ?>
					<?php } ?>
				</select>
				 <!--HIDDEN FIELDS -->
				 <input type="hidden" name="users_id" id="users_id">
			</div>
	<!-- till here -->
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-9">
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
			
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
				<div class="form-inline">
					<?php $amount = 0;
					foreach($TotalAmount as $result) { 
						if($result->ET_RECEIPT_ACTIVE == 1) {
							$amount = (int)($amount) + (int)($result->ET_RECEIPT_PRICE) + (int)($result->POSTAGE_PRICE);
						}
					} ?>
					<label for="number" id="Amount" style="font-size:18px;margin-top:.3em;">Rs: <?php echo $amount; ?></label>
				</div>
			</div>
		</form>
		<form id="report" enctype="multipart/form-data" method="post" accept-charset="utf-8">
			<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 text-right pull-right">
				<a onclick="GetSendField()" style="cursor:pointer;"><img style="width:24px; height:24px" title="Download Excel Report" src="<?=site_url();?>images/excel_icon.svg"/></a>&nbsp;&nbsp;
				<a onclick="generatePDF()"><img style="width:24px; height:24px" title="Download PDF Report" src="<?=site_url();?>images/pdf_icon.svg"/></a>&nbsp;&nbsp;
				<a onClick="print();"><img style="width:24px; height:24px" title="Print Report" src="<?=site_url();?>images/print_icon.svg"/></a>
			</div>
			<!--HIDDEN FIELDS -->
			<input type="hidden" name="payMode" id="payMode">
			<input type="hidden" name="dateField" id="dateField">
			<input type="hidden" name="allDates" id="allDateField" value="<?=@$allDates; ?>">
			<input type="hidden" name="radioOpt" id="radioOptField" value="<?=@$radioOpt; ?>">
		</form>
	</div>
</div>

<!--Datagrid -->
<div class="container">
	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
					  <tr>
						<th>Receipt No.</th>
						<th style="width:10%">RT Date</th>
						<th style="width:10%">RT Type</th>
						<th>Name</th>
						<th>Estimated Price</th>
						<th>Description</th>
						<th>Quantity</th>
						<th>Mode</th>
						<th>Amount</th>
						<th>Postage</th>
						<th>Total</th>
						<th>PT Status</th>
						<th style="width:15%">Authorized Status</th>
						<th>Payment Notes</th>
						<th style="width:15%">Entered By</th>
					  </tr>
					</thead>
					<tbody>
						<?php foreach($event_receipt_report as $result) { ?>
							<tr class="row1">
								<?php if($result->PAYMENT_STATUS == "Cancelled") { ?>
									<td style="text-decoration:line-through;"> <?php echo $result->ET_RECEIPT_NO; ?></td>
								<?php } else { ?>
									<td> <?php echo $result->ET_RECEIPT_NO; ?></td>
								<?php } ?>
								<td><?php echo $result->ET_RECEIPT_DATE; ?></td>
								<td><?php echo $result->ET_RECEIPT_CATEGORY_TYPE; ?></td>
								<td><?php echo $result->ET_RECEIPT_NAME; ?></td>
								<?php if($result->ET_RECEIPT_CATEGORY_TYPE == 'Inkind' || $result->ET_RECEIPT_CATEGORY_TYPE == 'Jeernodhara-Inkind') { ?>
									<td><?php echo $result->IK_APPRX_AMT; ?> </td>
									
								<?php } else { ?>
									<td>-</td>
								<?php } ?>
								<?php if($result->ET_RECEIPT_CATEGORY_TYPE == 'Inkind' || $result->ET_RECEIPT_CATEGORY_TYPE == 'Jeernodhara-Inkind') { ?>
									<td> <?php echo $result->IK_ITEM_DESC; ?> </td>
									
								<?php } else { ?>
									<td>-</td>
								<?php } ?>
								<td><?php echo $result->IK_ITEM_QTY; ?><?php echo $result->IK_ITEM_UNIT; ?></td>
								<?php if($result->ET_RECEIPT_PAYMENT_METHOD == "Cheque") { ?>
									<td><a class="log mymodelcancel" style="color:#800000;" onclick="show_cheque('1','<?php echo $result->CHEQUE_NO ; ?>','<?php echo $result->CHEQUE_DATE; ?>','<?php echo $result->BANK_NAME; ?>','<?php echo $result->BRANCH_NAME; ?>','<?php echo $result->TRANSACTION_ID; ?>')"><?php echo $result->ET_RECEIPT_PAYMENT_METHOD; ?></a></td> 
								<?php } else if($result->ET_RECEIPT_PAYMENT_METHOD == "Credit / Debit Card") { ?>
									<td><a class="log mymodelcancel" style="color:#800000;" onclick="show_cheque('2','<?php echo $result->CHEQUE_NO ; ?>','<?php echo $result->CHEQUE_DATE; ?>','<?php echo $result->BANK_NAME; ?>','<?php echo $result->BRANCH_NAME; ?>','<?php echo $result->TRANSACTION_ID; ?>')"><?php echo $result->ET_RECEIPT_PAYMENT_METHOD; ?></a></td> 
								<?php } else { ?>
									<td><?php echo $result->ET_RECEIPT_PAYMENT_METHOD; ?></td>
								<?php } ?>
								<?php if($result->ET_RECEIPT_CATEGORY_TYPE != "Inkind") { ?>
									<td><?php echo $result->ET_RECEIPT_PRICE; ?></td>
								<?php } else { ?>
									<td></td>
								<?php } ?>
								<td><?php echo $result->POSTAGE_PRICE; ?></td>	
								<td><?php echo ($result->ET_RECEIPT_PRICE) + ($result->POSTAGE_PRICE); ?></td>	
								<?php if($result->PAYMENT_STATUS == "Cancelled") { 
										$cancelNotes = str_replace("'","\'",$result->CANCEL_NOTES);
								?>
									<td><a class="log mymodelcancel" style="color:#800000;" onclick="show_cancelled('<?php echo $cancelNotes; ?>')"><?php echo $result->PAYMENT_STATUS; ?></a></td>
								<?php } else { ?>
									<td><?php echo $result->PAYMENT_STATUS; ?></td>
								<?php } ?>
								<td><?php echo $result->AUTHORISED_STATUS; ?></td>
								<td style="width:20%;word-break: break-all;"><?php echo $result->ET_RECEIPT_PAYMENT_METHOD_NOTES; ?></td>
									<td><?php echo $result->ET_RECEIPT_ISSUED_BY; ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
				<!-- <ul class="pagination pagination-sm">
					<?=$pages; ?>
				</ul> -->
			</div>
		</div>
	</div>
	
	<!--Total Sevas TextField -->
		<div class="row form-group">
		<div class="col-lg-4 col-md-8 col-sm-12 col-xs-12">
			<ul class="pagination pagination-sm" style="margin-left:15px;margin-top: -1em;">
					<?=$pages; ?>
				</ul>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="font-size:18px;margin-top: -1em;">
				<label class="pull-right" for="sevaAmount">Total Receipt: <span id="totalSeva"><?php echo $Count; ?></span></label>  

				<!-- <label class="pull-right" for="sevaAmount">Cancelled Receipt:<strong style="font-size:18px;"></strong> <span id="totalSeva" style="margin-right:30px"><?php echo $CancelledCount; ?></span></label> -->
			</div>  
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="font-size:18px;margin-top: -1em;">
				<label class="pull-right" for="sevaAmount">Cancelled Receipt:<strong style="font-size:18px;"></strong> <span id="totalSeva" style="margin-right:30px"><?php echo $CancelledCount; ?></span></label>
			</div>
	</div>
</div>

<!-- Cheque Modal2 -->
<div id="myModalCheque" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content" style="padding-bottom:1em;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
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
				<button type="button" class="close" data-dismiss="modal">&times;</button>
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
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Cancelled Notes</h4>
			</div>
			<div class="modal-body" id="cancelleddet" style="overflow-y: auto;max-height: 330px;">
			</div>
		</div>
	</div>
</div> 
<!--<style>
td {
	word-break: break-all;
}
</style>-->
<script>
	var between = [];
	
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
	
	function GetDataOnUser(users,url) {
		document.getElementById('users_id').value = users;
		document.getElementById('paymentMethod').value = $('#modeOfPayment').val();
		$("#tddate").attr("action",url)
		$("#tddate").submit();
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
		
		document.getElementById('payMode').value = $('#modeOfPayment').val();
		document.getElementById('dateField').value = $('#todayDate').val();
		url = "<?php echo site_url(); ?>Report/event_receipt_report_excel";
		$("#report").attr("action",url)
		$("#report").submit();
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
		url = "<?php echo site_url(); ?>generatePDF/create_eventReceiptpdf";
		$("#report").attr("action",url)
		$("#report").submit();
	}
	
	function print() {
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
		
		let url = "<?php echo site_url(); ?>generatePDF/create_eventReceiptSession";
		radioOpt = document.getElementById('radioOptField').value;
		allDates = document.getElementById('allDates').value;
		$.post(url,{'payMode':$('#modeOfPayment').val(),'dateField':$('#todayDate').val(),'radioOpt':radioOpt, 'allDates':allDates}, function(data) {
			let url2 = "<?php echo site_url(); ?>generatePDF/create_eventReceiptPrint";
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
	function get_datefield_change(date, users) {
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
		document.getElementById('users_id').value = $('#users').val();
		document.getElementById('paymentMethod').value = $('#modeOfPayment').val();
		url = "<?php echo site_url(); ?>Report/event_report_on_change_date";
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
		}else {
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
		document.getElementById('users_id').value = $('#users').val();
		document.getElementById('tdate').value = $('#todayDate').val();
		url = "<?php echo site_url(); ?>Report/event_report_on_change_date";
		$("#tddate").attr("action",url)
		$("#tddate").submit();
	}
	
	//FOR DATEFIELD
	var currentTime = new Date()
    var maxDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
    $( ".todayDate" ).datepicker({ 
		//maxDate: maxDate,
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50",
		dateFormat: 'dd-mm-yy'
		
    });
     
	$('.todayDateBtn').on('click', function() {
		$( ".todayDate" ).focus();
	})
	
	$(".fromDate2").datepicker({
		//maxDate: maxDate,
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50",
		dateFormat: 'dd-mm-yy'
	});
	
	$(".toDate2").datepicker({
		//maxDate: maxDate,
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50",
		dateFormat: 'dd-mm-yy'
	});
	
	/*$( ".toDate" ).datepicker({ 
		maxDate: maxDate,
		dateFormat: 'dd-mm-yy'
    });*/
     
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
		url = "<?php echo site_url(); ?>Report/event_receipt_report";
		$("#report").attr("action",url)
		$("#report").submit();
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
		url = "<?php echo site_url(); ?>Report/event_receipt_report";
		$("#report").attr("action",url)
		$("#report").submit();
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
</script>