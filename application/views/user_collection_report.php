<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<!--Heading And Refresh Button-->
	<div class="row form-group">
		<div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
			<span class="eventsFont2">User Event Collection Report: <span class="samFont"><?php echo $events[0]->ET_NAME; ?></span></span>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
			<a style="width:24px; height:24px" class="pull-right img-responsive" href="<?=site_url()?>Report/user_collection_report" title="Reset"><img title="reset" src="<?=site_url();?>images/refresh.svg"/></a>
		</div>
	</div>
	
	<div class="row form-group">
		<form id="userFilters" enctype="multipart/form-data" method="post" accept-charset="utf-8">
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
			  <select id="modeOfPayment" name="modeOfPayment" class="form-control" onchange="GetDataOnFilter(this.value,'<?php echo site_url()?>Report/get_data_on_payment')">
				<?php if(isset($payMethod)) {?>
					<?php if($payMethod == "All") { ?>
						<option selected value="All">All = &#8377;<?php if($All->PRICE != "") { echo $All->PRICE; } else { echo "0";} ?></option>
					<?php } else { ?>
						<option value="All">All = &#8377;<?php if($All->PRICE != "") { echo $All->PRICE; } else { echo "0";} ?></option>
					<?php } ?>
					<?php if($payMethod == "Cash") { ?>
						<option selected value="Cash">Cash = &#8377;<?php if($Cash->PRICE != "") { echo $Cash->PRICE; } else { echo "0"; } ?></option>
					<?php } else { ?>
						<option value="Cash">Cash = &#8377;<?php if($Cash->PRICE != "") { echo $Cash->PRICE; } else { echo "0"; } ?></option>
					<?php } ?>
					<?php if($payMethod == "Cheque") { ?>
						<option selected value="Cheque">Cheque = &#8377;<?php if($Cheque->PRICE != "") { echo $Cheque->PRICE; } else { echo "0"; } ?></option>
					<?php } else { ?>
						<option value="Cheque">Cheque = &#8377;<?php if($Cheque->PRICE != "") { echo $Cheque->PRICE; } else { echo "0"; } ?></option>
					<?php } ?>
					<?php if($payMethod == "Credit / Debit Card") { ?>
						<option selected value="Credit / Debit Card">Credit / Debit Card = &#8377;<?php if($Credit_Debit->PRICE != "") { echo $Credit_Debit->PRICE; } else { echo "0"; } ?></option>
					<?php } else { ?>
						<option value="Credit / Debit Card">Credit / Debit Card = &#8377;<?php if($Credit_Debit->PRICE != "") { echo $Credit_Debit->PRICE; } else { echo "0"; } ?></option>
					<?php } ?>
					<?php if($payMethod == "Direct Credit") { ?>
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
			</form>
		</div>
		
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
			<div class="form-inline">
				<?php $amount = 0;
				foreach($TotalAmount as $result) { 
					$amount = (int)($amount) + (int)($result->ET_RECEIPT_PRICE);
				} ?>
				<label for="number" id="Amount" style="font-size:18px;margin-top:.3em;">Rs. <?php echo $amount; ?>/-</label>
			</div>
		</div>
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
						<th>Receipt Type</th>
						<th>Receipt Name</th>
						<th>Payment Mode</th>
						<th>Amount</th>
						<th>Payment Status</th>
					  </tr>
					</thead>
					<tbody>
						<?php foreach($event_receipt_report as $result) { ?>
							<tr class="row1">
								<td><?php echo $result->ET_RECEIPT_NO; ?></td>
								<td><?php echo $result->ET_RECEIPT_CATEGORY_TYPE; ?></td>
								<td><?php echo $result->ET_RECEIPT_NAME; ?></td>
								<?php if($result->ET_RECEIPT_PAYMENT_METHOD == "Cheque") { ?>
									<td><a class="log mymodelcancel" style="color:#800000;" onclick="show_cheque('1','<?php echo $result->CHEQUE_NO ; ?>','<?php echo $result->CHEQUE_DATE; ?>','<?php echo str_replace("'","\'",$result->BANK_NAME); ?>','<?php echo str_replace("'","\'",$result->BRANCH_NAME); ?>','<?php echo $result->TRANSACTION_ID; ?>')"><?php echo $result->ET_RECEIPT_PAYMENT_METHOD; ?></a></td> 
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
								<td><?php echo $result->PAYMENT_STATUS; ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
				<ul class="pagination pagination-sm">
					<?=$pages; ?>
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- User Modal2 -->
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
<!-- User Modal2 -->
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
<script>
	//DATEFIELD AND FILTER CHANGE
	function GetDataOnFilter(payMode,url) {
		document.getElementById('paymentMethod').value = payMode;
		$("#userFilters").attr("action",url)
		$("#userFilters").submit();
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

	//GET SEND POST FIELDS
	function GetSendField() {
		document.getElementById('SId').value = $('#sevas').val();
		document.getElementById('dateField').value = $('#todayDate').val();
		url = "<?php echo site_url(); ?>Report/event_sevas_report_excel";
		$("#report").attr("action",url)
		$("#report").submit();
	}
	
	//ON CHANGE OF DATEFIELD
	function get_datefield_change(date) {
		document.getElementById('tdate').value = date;
		document.getElementById('sevaid').value = $('#sevas').val();
		url = "<?php echo site_url(); ?>Report/event_date_change_report";
		$("#tddate").attr("action",url)
		$("#tddate").submit();
	}

	//ON CHANGE OF PAYMENT MODE
	function get_seva_change(sevaId) {
		document.getElementById('sevaid').value = sevaId;
		document.getElementById('tdate').value = $('#todayDate').val();
		url = "<?php echo site_url(); ?>Report/event_seva_change_report";
		$("#tddate").attr("action",url)
		$("#tddate").submit();
	}
	
	//FOR DATEFIELD
	var currentTime = new Date()
    var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
    var maxDate =  new Date(currentTime.getFullYear(), currentTime.getMonth() +12, +0); // one day before next month
    $( ".todayDate" ).datepicker({ 
		minDate: minDate, 
		maxDate: maxDate,
		dateFormat: 'dd-mm-yy'
    });
     
	$('.todayDateBtn').on('click', function() {
		$( ".todayDate" ).focus();
	})
</script>