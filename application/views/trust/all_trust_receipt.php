<?php 
	unset($_SESSION['receiptFormat']);
?>
<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<!--Heading And Refresh Button-->
	<div class="row form-group">
		<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
			<span class="eventsFont2">All Trust Receipt </span>
		</div>
		<form id="dateChange" enctype="multipart/form-data" method="post" accept-charset="utf-8" onsubmit="return field_validation()">
			<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
				<div class="input-group-sm form-group">
					<input style="border-radius:2px;" id="receiptNo" name="receiptNo" type="text" value="<?php echo @$receiptNo; ?>" class="form-control" placeholder="Search By Receipt/Booking No.">
				</div>
			</div>
			
			<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
				<div class="input-group input-group-sm form-group">
					<input autocomplete="off" id="todayDate" name="todayDate" type="text" value="<?php echo $date; ?>" class="form-control todayDate2" placeholder="dd-mm-yyyy" onchange="GetDataOnDate(this.value,'<?php echo site_url()?>TrustReceipt/all_receiptSearch_trust')" readonly="readonly">
					<div class="input-group-btn">
						<button class="btn btn-default todayDate" type="button">
							<i class="glyphicon glyphicon-calendar"></i>
						</button>
					</div>
					<!--HIDDEN FIELDS -->
					<input type="hidden" name="date" id="date">
					<input type="hidden" name="load" id="load">
				</div>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
				<div class="form-group">
					<select style="display:none;" id="receipts_Filter" class="form-control" onchange="GetDataOnFilter(this.value,'<?php echo site_url()?>TrustReceipt/all_receiptSearch_trust')" style="padding: 1px 6px;height:30px;">
						<option selected value="0">All Receipt</option>
						<?php foreach($financialHeads as $result) { ?>
							<option value="<?php echo $result->FH_ID; ?>"><?php echo $result->FH_NAME; ?></option>	
						<?php } ?>
					</select>
				</div>
				<!--HIDDEN FIELDS -->
				<input type="hidden" name="receipt" id="receipt">
			</div>
		</form>
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 text-right">
			<?php if(isset($_SESSION['Add'])) { ?>
				<a href="<?php echo site_url();?>TrustReceipt/new_trust_receipt" title="Add Receipt"><img src="<?php echo base_url(); ?>images/add_icon.svg" /></a>
			<?php } ?>
			<a class="pull-right" href="<?=site_url()?>TrustReceipt/all_trust_receipt" title="Refresh"><img style=" width:24px; height:24px" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>&nbsp;&nbsp;
		</div>
	</div>
</div>

<div class="container">
	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
					  <tr>
						<th>Receipt No.</th>
						<th>Booking No.</th>
						<th>Financial Head</th>
						<th>Name</th>
						<th>Payment Mode</th>
						<th>Amount</th>
						<th>Entered By</th>
						<th>Payment Status</th>
					  </tr>
					</thead>
					<tbody>
						<?php foreach($trust_details as $result) { ?>
							<tr class="row1">
								<td><a style="text-decoration:none;cursor:pointer;color:#800000;" onClick="printReceipt('<?=$result->TR_NO; ?>', '<?=$result->TR_ID; ?>','<?=$result->RECEIPT_CATEGORY_ID;?>')"><?php echo $result->TR_NO; ?></a></td>
								<td><?php echo $result->HB_NO; ?></td>
								<td><?php echo $result->FH_NAME; ?></td>
								<td><?php echo $result->RECEIPT_NAME; ?></td>
								<td><?php echo $result->RECEIPT_PAYMENT_METHOD; ?></td>
								<td><?php echo $result->FH_AMOUNT; ?></td>
								<td><?php echo $result->ENTERED_BY_NAME; ?></td>
								<td><?php echo $result->PAYMENT_STATUS; ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
				<!-- <ul class="pagination pagination-sm">
					<?=$pages; ?>
				</ul> -->
			</div>
			<!--Total Sevas TextField -->
			<div class="row form-group">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					 <ul class="pagination pagination-sm">
					<?=$pages; ?>
					</ul>
					<?php if(@$TotalAmount[0]->AMOUNT != "") { ?>
					<label class="pull-right" for="sevaAmount" style="padding-right:0px;">Total Amount: <span id="totalSeva"><?php echo @$TotalAmount[0]->AMOUNT; ?></span></label>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
<form id="receiptForm" action="" method="post">
	<input type="hidden" id="receiptId" name="receiptId" />
	<input type="hidden" id="receiptFormat1" name="receiptFormatDeity1" />
</form>

<form id="sevaForm" action="<?=site_url()?>Receipt/printDeityReceipt" method="post">
	<input type="hidden" id="receiptFormat2" name="receiptFormat2" />
</form>
<script>
	$('#receiptNo').on('keyup', function(e) {
		if(e.which == 13) {
			url = '<?php echo site_url()?>TrustReceipt/all_receiptSearch_trust';
			document.getElementById('date').value = $('#todayDate').val();
			document.getElementById('load').value = "DateChange";
			document.getElementById('receipt').value = $('#receipts_Filter').val();
			
			$("#dateChange").attr("action",url)
			$("#dateChange").submit();
		}
	});
	
	//ADD Receipt
	function printReceipt(receiptFormat,receiptId,catId) {
		$('#receiptId').val(receiptId);
		$('#receiptFormat1').val(receiptFormat);

		if(catId == 1) {
			$('#receiptForm').attr('action','<?=site_url()?>TrustReceipt/receipt_inkindPrint_trust');
			$('#receiptForm').submit();
		}else{
			$('#receiptForm').attr('action','<?=site_url()?>TrustReceipt/receipt_newTrustPrint');
			$('#receiptForm').submit();
		}
	}

	//DATEFIELD
	var currentTime = new Date()
	var minDate = "-1Y"; //one day next before month
	var maxDate =  0; // one day before next month
	$( ".todayDate2" ).datepicker({ 
		minDate: minDate, 
		//maxDate: maxDate,
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50",
		dateFormat: 'dd-mm-yy'
		
	});
			
	$('.todayDate').on('click', function() {
		$( ".todayDate2" ).focus();
	})
	
	<!-- Validating Fields -->
	function field_validation() {
		var count = 0;
		if(!$('#todayDate').val()) {
			$('#todayDate').css('border', "1px solid #FF0000"); 
			++count
			
		} else {
			$('#todayDate').css('border', "1px solid #000000"); 
		}
		
		if(count != 0) {
			alert("Information","Please fill required fields","OK");
			return false;
		}
	}
	
	//DATEFIELD AND FILTER CHANGE
	function GetDataOnDate(date,url) {
		document.getElementById('date').value = date;
		document.getElementById('load').value = "DateChange";
		document.getElementById('receipt').value = $('#receipts_Filter').val();
		$("#dateChange").attr("action",url)
		$("#dateChange").submit();
	}
	
	//DATEFIELD AND FILTER CHANGE
	function GetDataOnFilter(receipt,url) {
		document.getElementById('date').value = $('#todayDate').val();
		document.getElementById('load').value = "DateChange";
		document.getElementById('receipt').value = receipt;
		$("#dateChange").attr("action",url)
		$("#dateChange").submit();
	}
</script>
