<?php error_reporting(0);
	//$this->output->enable_profiler(true);
?>
<style>
	.btn {
		    width: 72px !important;
	}
</style>
<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<!--Heading And Refresh Button-->
	<div class="row form-group">
		<div class="col-lg-4 col-md-10 col-sm-10 col-xs-8">
			<span class="eventsFont2">E.O.D. Report - <?=$event['ET_NAME']; ?></span>
		</div>
		<div class="col-lg-6 col-md-10 col-sm-10 col-xs-8">
			<form action="<?=site_url();?>EventEOD/eod_admin" id="dateChange" enctype="multipart/form-data" method="post" accept-charset="utf-8">
				<div class="col-lg-4 col-md-3 col-sm-4 col-xs-6">
					<div class="input-group input-group-sm">
						<input autocomplete="" id="todayDate" name="todayDate" type="text" value="<?=@$dateFeild;?>" class="form-control todayDate2"  onchange="this.form.submit()" placeholder="dd-mm-yyyy" readonly = "readonly" />
						<div class="input-group-btn">
						  <button class="btn btn-default todayDate" type="button">
							<i class="glyphicon glyphicon-calendar"></i>
						  </button>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
			<a style="width:24px; height:24px" class="pull-right img-responsive" href="<?=site_url()?>EventEOD/eod_admin" title="Refresh"><img title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
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
						<th>Operations</th>
					  </tr>
					</thead>
					<tbody>
						<?php foreach($eod_receipt_report as $result) { ?>
							<tr class="row1">
								<td><?php echo $result->ET_RECEIPT_DATE; ?></td>
								<td><?php echo $result->Cash; ?></td>
								<td><?php echo $result->Cheque; ?></td>
								<td><?php echo $result->DirectCredit; ?></td>
								<td><?php echo $result->CreditDebitCard; ?></td>
								<td><?php echo $result->TotalAmount; ?></td>
								<td><?php if($result->EOD_CONFIRMED_DATE_TIME) echo $result->EOD_CONFIRMED_DATE_TIME; else echo "<center>-</center>"; ?></td>
								<td><?php if($result->EOD_CONFIRMED_BY_NAME) echo $result->EOD_CONFIRMED_BY_NAME; else echo "<center>-</center>"; ?></td>
								<?php if($result->EOD_CONFIRMED_DATE) { ?> 
										<td><center><button type="button" class="btn btn-default btn-sm" onClick='eodOnDate("<?php echo $result->ET_RECEIPT_DATE;?>", "view")'>View</Button></center></td>
								<?php } else { ?>
									<td>
										<?php if(date('d-m-Y') == $result->ET_RECEIPT_DATE) { ?>
												<center><button type="button" class="btn btn-default btn-sm" onClick='eodOnDate("<?php echo $result->ET_RECEIPT_DATE;?>","generate")'>Generate</button></center>		
										<?php } else { ?>
												<center><button type="button" class="btn btn-default btn-sm" onClick='eodOnDate("<?php echo $result->ET_RECEIPT_DATE;?>","generate")'>Generate</button></center>
										<?php } ?>
									</td>	
								<?php } ?>
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
<form id="eodOnDate" method="post">
	<input type="hidden" name="eodDate" id="eodDate"/>
	<input type="hidden" name="receiptType" id="receiptType"/>
</form>
<script>
	function eodOnDate(date, receiptType) {
		$('#eodDate').val(date);
		$('#receiptType').val(receiptType);
		$('#eodOnDate').attr('action',"<?=site_url()?>EventEOD/eventEod_onDate/");
		$('#eodOnDate').submit();
	}
	
	$( ".todayDate2" ).datepicker({ 
		dateFormat: 'dd-mm-yy',
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50"
	});
			
	$('.todayDate').on('click', function() {
		$( ".todayDate2" ).focus();
	});
</script>
