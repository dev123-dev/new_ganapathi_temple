<?php error_reporting(0); ?>
<style>
	.btn {
		    width: 72px !important;
	}
</style>
<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<!--Heading And Refresh Button-->
	<div class="row form-group">
		<div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
			<span class="eventsFont2">E.O.D. Report</span>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
			<a style="width:24px; height:24px" class="pull-right img-responsive" href="<?=site_url()?>EOD" title="Refresh"><img title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
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
						<th>Date</th>
						<th>Cash</th>
						<th>Cheque</th>
						<th>Direct Credit</th>
						<th>Credit / Debit Card</th>
						<th>Total Amount</th>
						<th>Verified Date & Time</th>
						<th>Verified By</th>
						<th>Receipts</th>
					  </tr>
					</thead>
					<tbody>
						<?php foreach($eod_receipt_report as $result) { ?>
							<tr class="row1">
								<td><?php echo $result->RECEIPT_DATE; ?></td>
								<td><?php echo $result->Cash; ?></td>
								<td><?php echo $result->Cheque; ?></td>
								<td><?php echo $result->directCredit; ?></td>
								<td><?php echo $result->Card; ?></td>
								<td><?php echo $result->TotalAmount; ?></td>
								<td><?php if($result->EOD_CONFIRMED_DATE_TIME) echo $result->EOD_CONFIRMED_DATE_TIME; else echo "<center>-</center>"; ?></td>
								<td><?php if($result->EOD_CONFIRMED_BY_NAME) echo $result->EOD_CONFIRMED_BY_NAME; else echo "<center>-</center>"; ?></td>
								<td><?php if($_SESSION['userId'] != "1" && $_SESSION['userId'] != "2" && $_SESSION['userId'] != "6") { ?><center><button onClick='eodOnDate("<?php echo $result->RECEIPT_DATE; ?>")' type="button" class="btn btn-default btn-sm">View</Button></center><?php } ?></td>
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

<form id="eodOnDate" method="post">
	<input type="hidden" name="date" id="date"/>
	
</form>

<script>
	function eodOnDate(date) {
		$('#date').val(date);
		$('#eodOnDate').attr('action',"<?=site_url()?>EOD/deityEod_collection/");
		$('#eodOnDate').submit();
	}
	
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