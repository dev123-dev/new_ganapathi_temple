<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<!--Heading And Refresh Button-->
	<div class="row form-group">
		<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
			<span class="eventsFont2">All Event Receipt</span>
		</div>
		<form id="dateChange" enctype="multipart/form-data" method="post" accept-charset="utf-8" onsubmit="return field_validation()">
			<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
				<div class="input-group-sm form-group">
					<input style="border-radius:2px;" id="receiptNo" name="receiptNo" type="text" value="<?php echo @$receiptNo; ?>" class="form-control" placeholder="Search By Receipt No.">
				</div>
			</div>
			
			<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
				<div class="input-group input-group-sm form-group">
					<input id="todayDate" name="todayDate" type="text" value="<?php echo $date; ?>" class="form-control todayDate2" placeholder="dd-mm-yyyy" onchange="GetDataOnDate(this.value,'<?php echo site_url()?>TrustReceipt/all_receiptSearch')" readonly="readonly">
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
					<select id="receipts_Filter" class="form-control" onchange="GetDataOnFilter(this.value,'<?php echo site_url()?>TrustReceipt/all_receiptSearch')" style="padding: 1px 6px;height:30px;">
						<?php if(isset($Receipt)) {?>
							<?php if($Receipt == "0") { ?>
								<option selected value="0">All Receipt</option>
							<?php } else { ?>
								<option value="0">All Receipt</option>
							<?php } ?>
							<?php //if($Receipt == "7") { ?>
								<!--<option selected value="7">Deity Seva</option>-->
							<?php //} else { ?>
								<!--<option value="7">Deity Seva</option>-->
							<?php //} ?>
							<?php //if($Receipt == "6") { ?>
								<!--<option selected value="6">Deity Donation</option>-->
							<?php //} else { ?>
								<!--<option value="6">Deity Donation</option>-->
							<?php //} ?>
							<?php //if($Receipt == "5") { ?>
								<!--<option selected value="5">Deity Kanike</option>-->
							<?php //} else { ?>
								<!--<option value="5">Deity Kanike</option>-->
							<?php //} ?>
							<?php if($Receipt == "1") { ?>
								<option selected value="1">Event Seva</option>
							<?php } else { ?>
								<option value="1">Event Seva</option>
							<?php } ?>
							<?php if($Receipt == "2") { ?>
								<option selected value="2">Event Donation/Kanike</option>
							<?php } else { ?>
								<option value="2">Event Donation/Kanike</option>
							<?php } ?>	
							<?php if($Receipt == "3") { ?>
								<option selected value="3">Hundi</option>
							<?php } else { ?>
								<option value="3">Hundi</option>
							<?php } ?>	
							<?php if($Receipt == "4") { ?>
								<option selected value="4">InKind</option>
							<?php } else { ?>
								<option value="4">InKind</option>
							<?php } ?>		
						<?php } else { ?>
							<option value="0">All Receipt</option>
							<!--<option value="7">Deity Seva</option>
							<option value="6">Deity Donation</option>
							<option value="5">Deity Kanike</option>-->
							<option value="1">Event Seva</option>
							<option value="2">Event Donation/Kanike</option>
							<option value="3">Event Hundi</option>
							<option value="4">Event InKind</option>
						<?php } ?>
					</select>
				</div>
				<!--HIDDEN FIELDS -->
				<input type="hidden" name="receipt" id="receipt">
			</div>
		</form>
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 text-right">
			<?php if(isset($_SESSION['Add'])) { ?>
				<a class="dropdown-toggle" data-toggle="dropdown" href="#" title="Add Receipt"><img src="<?php echo base_url(); ?>images/add_icon.svg" /></a>
				<ul class="dropdown-menu addDropDown pull-right" style="margin-right:1em;">
					<!--<li><a href="<?php echo site_url();?>Receipt/deitySevaReceipt">Deity Seva</a></li>
					<li><a href="<?php echo site_url();?>Receipt/receipt_deity_donation">Deity Donation</a></li>
					<li><a href="<?php echo site_url();?>Receipt/receipt_deity_kanike">Deity Kanike</a></li>-->
					<li><a href="<?php echo site_url();?>TrustEvents/event_receipt">Event Seva</a></li>
					<li><a href="<?php echo site_url();?>TrustReceipt/receipt_donation">Event Donation/Kanike</a></li>
					<li><a href="<?php echo site_url();?>TrustReceipt/receipt_hundi">Event Hundi</a></li>
					<li><a href="<?php echo site_url();?>TrustReceipt/receipt_inkind">Event InKind</a></li>
				</ul>
			<?php } ?>
			<a class="pull-right" href="<?=site_url()?>TrustReceipt/all_receipt" title="Refresh"><img style=" width:24px; height:24px" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>&nbsp;&nbsp;
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
						<th>Receipt Type</th>
						<th>Name</th>
						<th>Event Name</th>
						<th>Estimated Price</th>
						<th>Description</th>
						<th>Payment Mode</th>
						<th>Amount</th>
						<th>Postage</th>
						<th>Grand Total</th>
						<th>Entered By</th>
						<th>Payment Status</th>
						<th>Authorized Status</th>
						<th>Authorized By</th>
					  </tr>
					</thead>
					<tbody>
						<?php foreach($receipts_details as $result) { ?>
							<tr class="row1">
								<td><a style="text-decoration:none;cursor:pointer;color:#800000;" onClick="printReceipt('<?=$result->TET_RECEIPT_NO; ?>', '<?=$result->TET_RECEIPT_ID; ?>','<?=$result->TET_RECEIPT_CATEGORY_ID;?>')"><?php echo $result->TET_RECEIPT_NO; ?></a></td>
								<td><?php echo $result->TET_RECEIPT_CATEGORY_TYPE; ?></td>
								<td><?php echo $result->TET_RECEIPT_NAME; ?></td>
								<td><?php echo $result->RECEIPT_TET_NAME; ?></td>
								<?php if($result->TET_RECEIPT_CATEGORY_TYPE == 'Inkind') { ?>
									<td><?php echo $result->IK_APPRX_AMT; ?> </td>
								<?php } else { ?>
									<td>-</td>
								<?php } ?>
								<?php if($result->TET_RECEIPT_CATEGORY_TYPE == 'Inkind') { ?>
									<td> <?php echo $result->IK_ITEM_DESC; ?></td>
								<?php } else { ?>
									<td>-</td>
								<?php } ?>
								<td><?php echo $result->TET_RECEIPT_PAYMENT_METHOD; ?></td>
								<?php if($result->TET_RECEIPT_CATEGORY_TYPE != "Inkind") { ?>
									<td><?php echo $result->TET_RECEIPT_PRICE; ?></td>
								<?php } else { ?>
									<td>-</td>
								<?php } ?>
								<?php if($result->TET_RECEIPT_CATEGORY_TYPE == "Seva") { ?>
								<td><?php echo $result->POSTAGE_PRICE; ?></td>
								<?php } else { ?>
									<td>-</td>
								<?php } ?>
								<?php if($result->TET_RECEIPT_CATEGORY_TYPE != "Inkind") { ?>
								<td><?php echo ($result->TET_RECEIPT_PRICE) + ($result->POSTAGE_PRICE); ?></td>
								<?php } else { ?>
									<td>-</td>
								<?php } ?>
								<td><?php echo $result->TET_RECEIPT_ISSUED_BY; ?></td>
								<td><?php echo $result->PAYMENT_STATUS; ?></td>
								<td><?php echo $result->AUTHORISED_STATUS; ?></td>
								<td><?php echo $result->AUTHORISED_BY_NAME; ?></td>
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
<form id="receiptForm" action="" method="post">
	<input type="hidden" id="receiptId" name="receiptId" />
	<input type="hidden" id="receiptFormat1" name="receiptFormat1" />
</form>

<form id="sevaForm" action="<?=site_url()?>TrustEvents/printSevaReceipt" method="post">
	<input type="hidden" id="receiptFormat2" name="receiptFormat2" />
</form>
<script>
	$('#receiptNo').on('keyup', function(e) {
		if(e.which == 13) {
			url = '<?php echo site_url()?>TrustReceipt/all_receiptSearch';
			document.getElementById('date').value = $('#todayDate').val();
			document.getElementById('load').value = "DateChange";
			document.getElementById('receipt').value = $('#receipts_Filter').val();
			
			$("#dateChange").attr("action",url)
			$("#dateChange").submit();
		}
	});
	
	//ADD Receipt
	function printReceipt(receiptFormat,receiptId,catId) {
		if(catId == 1) {
			$('#receiptFormat2').val(receiptFormat);
			$('#sevaForm').submit();
		} else if(catId == 2) {
			$('#receiptId').val(receiptId);
			$('#receiptFormat1').val(receiptFormat);
			$('#receiptForm').attr('action','<?=site_url()?>TrustReceipt/receipt_donationPrint');
			$('#receiptForm').submit();
		} else if(catId == 3) {
			$('#receiptId').val(receiptId);
			$('#receiptFormat1').val(receiptFormat);
			$('#receiptForm').attr('action','<?=site_url()?>TrustReceipt/receipt_hundiPrint');
			$('#receiptForm').submit();
		} else {
			$('#receiptId').val(receiptId);
			$('#receiptFormat1').val(receiptFormat);
			$('#receiptForm').attr('action','<?=site_url()?>TrustReceipt/receipt_inkindPrint');
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

<?php // $this->output->enable_profiler(TRUE); ?>
