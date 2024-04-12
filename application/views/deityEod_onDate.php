<?php error_reporting(0); ?>
<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<!--Heading And Refresh Button-->
	<div class="row form-group">
		<div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
			<span class="eventsFont2">E.O.D (<?php echo $selectedDate; ?>)</span>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
			<a style="width:24px; height:24px" class="pull-right img-responsive" href="<?=@$_SESSION['actual_link']; ?>" title="back"><img title="Back" src="<?=site_url();?>images/back_icon.svg"/></a>
		</div>
	</div>

	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
					  <tr>
						<th>User Details</th>
						<th>Cash</th>
						<th>Cheque</th>
						<th>Direct Credit</th>
						<th>Credit / Debit Card</th>
						<th>Grand Total</th>
						<th>Verified</th>
						<th>Receipts</th>
					  </tr>
					</thead>
					<tbody>
						<?php $Cash = 0; $TotalAmount= 0; $Cheque = 0; $DirectCredit = 0; $Card = 0; $TotalAuthorised; foreach($eod_receipt_report as $result) { ?>
							<tr class="row1">
							<?php 
							
								$Cash += $result->Cash;
								$Cheque += $result->Cheque;
								$DirectCredit += $result->DirectCredit;
								$Card += $result->CreditDebitCard;
								$TotalAmount += $result->TotalAmount; 
								$TotalAuthorised += $result->AUTHORISED_STATUS; ?>
								
								<?php if($result->AUTHORISED_STATUS != 0) { ?>
									<?php if($selectedDate != date('d-m-Y') || strtotime(date('H:i:s')) >= strtotime($timeSettings['TIME_FROM']) && strtotime(date('H:i:s')) <= strtotime($timeSettings['TIME_TO'])) { ?>
										<td><a style='cursor:pointer;color:#800000;text-decoration:none;' onClick="eodUserCollection('<?php echo $selectedDate; ?>','<?php echo $result->RECEIPT_ISSUED_BY; ?>','<?php echo $result->RECEIPT_ISSUED_BY_ID; ?>')"><?php echo $result->RECEIPT_ISSUED_BY; ?></a></td>
									<?php } else { ?>
										<td><?php echo $result->RECEIPT_ISSUED_BY; ?></td>
									<?php } ?>
								<?php } else { ?>
									<td><?php echo $result->RECEIPT_ISSUED_BY; ?></td>
								<?php } ?>
													
								<td><?php echo $result->Cash; ?></td>
								<td><?php echo $result->Cheque; ?></td>
								<td><?php echo $result->DirectCredit; ?></td>
								<td><?php echo $result->CreditDebitCard; ?></td>
								<td><?php echo $result->TotalAmount; ?></td>
								<?php if($result->AUTHORISED_STATUS != 0) { ?>
									<td>No</td>
								<?php } else { ?>
									<td>Yes</td>
								<?php } ?>
								<td><?php if($_SESSION['userId'] != "1" && $_SESSION['userId'] != "2" && $_SESSION['userId'] != "6") { ?><center><button onClick="eodUserCollectionViewBtn('<?php echo $selectedDate; ?>','<?php echo $result->RECEIPT_ISSUED_BY; ?>','<?php echo $result->RECEIPT_ISSUED_BY_ID; ?>')" style="width: 72px;" type="button" class="btn btn-default btn-sm">View</Button></center><?php } ?></td>
							</tr>
						
						<?php } ?>
						<tr style="background:#FBB917;"><td colspan="8"></td></tr><tr>
							<td><strong>Total</strong></td>
							<td><strong><?=$Cash; ?></strong></td>
							<td><strong><?=$Cheque; ?></strong></td>
							<td><strong><?=$DirectCredit; ?></strong></td>
							<td><strong><?=$Card; ?></strong></td>
							<td><strong><?=$TotalAmount; ?></strong></td>
							<td></td>
							<td></td>
						</tr>
					</tbody>
				</table>
			</div>
			
			<?php if($receiptType == "generate" && $TotalAuthorised == 0) { ?>
				<button type="button" class="btn btn-default btn-lg pull-right" onClick='alertEOD("Confirm","Are you sure, you want to Generate EOD","Yes",false,"action")'>Confirm E.O.D.</button>
			<?php } else if($receiptType == "generate" && $TotalAuthorised != 0) { ?>
				<button disabled type="button" class="btn btn-default btn-lg pull-right" style="background: #b8b8bd;color:black;" onClick='alertEOD("Confirm","Are you sure, you want to Generate EOD","Yes",false,"action")'>Confirm E.O.D.</button>
			<?php } else { ?>
				<?php if($alredyGeneratedCount > 0 && $regeneratePending > 0 && $TotalAuthorised == 0) {?>
					<button type="button" class="btn btn-default btn-lg" onClick='alertRegenerateEOD("Confirm","Are you sure, you want to Regenerate EOD","Yes",false,"action")'>Regenerate E.O.D.</button>
				<?php } ?>
				<button type="button" class="btn btn-default btn-lg pull-right" onClick='print("<?php echo $selectedDate; ?>");'>Print E.O.D.</button>
			<?php } ?>
		</div>
	</div>

	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="transferDetails" style="display: none; ">
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
					  <tr>
						<th>User Details</th>
						<th>Receipt No.</th>
						<th>Receipt Type</th>
						<th>Receipt Name</th>
						<th>Payment Mode</th>
						
					  
						<th>Receipts</th>
					  </tr>
					</thead>
					<tbody>
						<?php $Card = 0; $TotalAuthorised;
						foreach($eod_transfer_report as $result) { ?>
							<tr class="row1">
								<td><?php echo $result->RECEIPT_ISSUED_BY; ?></td>
								<td><?php echo $result->RECEIPT_NO; ?></td>
								<td><?php echo $result->RECEIPT_CATEGORY_TYPE; ?></td>
								<td><?php echo $result->RECEIPT_NAME; ?></td>

								<td><?php echo $result->RECEIPT_PRICE; ?></td>
								<!-- <?php if($result->AUTHORISED_STATUS != 0) { ?>
									<td>No</td>
								<?php } else { ?>
									<td>Yes</td>
								<?php } ?> -->
								<td><center><button onClick="gotofinancedaybook('<?=$result->FGLH_ID; ?>','<?php echo str_replace("'","\'",$result->FGLH_NAME);?>','<?=$result->VOUCHER_NO; ?>','<?=$result->FLT_DATE; ?>')" style="width: 72px;" type="button" class="btn btn-default btn-sm">View</Button></center></td>
									
									<!-- '<?php echo $selectedDate; ?>','<?php echo $result->RECEIPT_ISSUED_BY; ?>','<?php echo $result->RECEIPT_ISSUED_BY_ID; ?>' -->
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			
		</div>
	</div>
	
	<form id="eodForm" method="post" action="<?=site_url()?>EOD/deityEod_onDate/">
		<input type="hidden" value="<?=@$_SESSION['selectedDate']; ?>" name="eodDate" />
		<input type="hidden" value="view" name="receiptType" />
	</form>
	
	<input type="hidden" id="Cash2" value="<?=$Cash; ?>" />
	<input type="hidden" id="Cheque2" value="<?=$Cheque; ?>" />
	<input type="hidden" id="directCredit2" value="<?=$DirectCredit; ?>" />
	<input type="hidden" id="Card2" value="<?=$Card; ?>" />
	<input type="hidden" id="TotalAmount2" value="<?=$TotalAmount; ?>" />
	

	<form id="eodUser" method="post">
		<input type="hidden" name="userId" id="userId"/>
		<input type="hidden" name="userName" id="userName"/>
		<input type="hidden" name="date" id="date"/>
	</form>

	<form id="financedaybookdetailform" method="post">
		<input type="hidden" name="FGLH_ID" id="FGLH_ID"/>
		<input type="hidden" name="FGLH_NAME" id="FGLH_NAME"/>
		<input type="hidden" name="VOUCHER_NO" id="VOUCHER_NO"/>
		<input type="hidden" name="FLT_DATE" id="FLT_DATE"/>
		<input type="hidden" id="baseurl" name="baseurl" value="<?php echo $base_url ?>" />
		
	</form>
</div>

<script>
	function eodOnDate(date) {
		$('#date').val(date);
		$('#eodOnDate').attr('action',"<?=site_url()?>EOD/deityEod_collection/");
		$('#eodOnDate').submit();
	}
	function eodUserCollection(date,username,uid) {
		let url = "<?=site_url()?>EOD/checkPreviousPendingDate/";

		$.post(url, {
			date:date
		},function(e) {
			if(e == "success") {
				$('#date').val(date);
				$('#userName').val(username);
				$('#userId').val(uid);
				$('#eodUser').attr('action',"<?=site_url()?>EOD/deityEod_usercollection/");
				$('#eodUser').submit();
			} else {
				alert("Information", "Please Confirm E.O.D. Report for previous date(s), starting from ("+e+")");
			}
		});
	}
	
	function eodUserCollectionViewBtn(date,username,uid) {
		$('#date').val(date);
		$('#userName').val(username);
		$('#userId').val(uid);
		
		$('#eodUser').attr('action',"<?=site_url()?>EOD/deityEodUsercollection/");
		$('#eodUser').submit();	
	}

	function gotofinancedaybook(FGLH_ID,FGLH_NAME,VOUCHER_NO,FLT_DATE) {
		$('#FGLH_ID').val(FGLH_ID);
		$('#FGLH_NAME').val(FGLH_NAME);
		$('#VOUCHER_NO').val(VOUCHER_NO);
		$('#FLT_DATE').val(FLT_DATE);
		

		$('#financedaybookdetailform').attr('action',"<?=site_url()?>finance/dayBookDetail");
		$('#financedaybookdetailform').submit();
			
	}

	function print(date) {
		console.log(date);
		let url = "<?php echo site_url(); ?>generatePDF/create_eodReceiptSession";
		$.post(url,{'date':date}, function(data) {
			let url2 = "<?php echo site_url(); ?>generatePDF/create_eodReceiptPrint";
			if(data == 1) {
				downloadClicked = 0;
				var win = window.open(
				  url2,
				  '_blank'
				);
				setTimeout(function(){ win.print();}, 1000); //setTimeout(function(){ win.close();}, 5000);
			}
		});
	}
	$(document).ready(function() {
		sessionStorage.removeItem("SelectedReceiptID");
		sessionStorage.removeItem("SelectAll");; 
		 let arrTotDBItems = <?php echo $eod_transfer; ?>;
		 for (let i = 0; i < arrTotDBItems.length; ++i) {
            if (arrTotDBItems[i]['RECEIPT_PAYMENT_METHOD'] == "Transfer"){
               document.getElementById('transferDetails').style.display = "block";
            }else{
				document.getElementById('transferDetails').style.display = "none";
			}
        }
	});

</script>
