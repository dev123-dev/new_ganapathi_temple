<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<!--Heading And Refresh Button-->
	<div class="row form-group">
		<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
			<span class="eventsFont2">Auction Report: <span class="samFont"><?php echo $events[0]->TET_NAME; ?></span></span>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="margin-top: 1em;">
			<a style="width:24px; height:24px" class="pull-right img-responsive" href="<?=site_url()?>TrustReport/auction_report" title="Refresh"><img title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
		</div>
	</div>

	<!-- Reports Button -->
	<div class="row form-group">	
		<!-- Mode Combo -->
		<form id="tddate" enctype="multipart/form-data" method="post" accept-charset="utf-8">
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-9">
				<select id="modeOfPayment" name="modeOfPayment" class="form-control" onchange="get_payment_mode_change(this.value)">
					<?php if(isset($PMode)) { ?>
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
		</form>
		
		<form id="report" enctype="multipart/form-data" method="post" accept-charset="utf-8">
			<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right pull-right">
				<a onclick="GetSendField()" style="cursor:pointer;"><img style="width:24px; height:24px" title="Download Excel Report" src="<?=site_url();?>images/excel_icon.svg"/></a>&nbsp;&nbsp;
				<a onclick="generatePDF()"><img style="width:24px; height:24px" title="Download PDF Report" src="<?=site_url();?>images/pdf_icon.svg"/></a>&nbsp;&nbsp;
				<a onClick="print();"><img style="width:24px; height:24px" title="Print Report" src="<?=site_url();?>images/print_icon.svg"/></a>
			</div>
			<!--HIDDEN FIELDS -->
			<input type="hidden" name="payMode" id="payMode">
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
						<th style="width:10%;">Bid Ref No.</th>
						<th style="width:10%;">Item Ref No.</th>
						<th style="width:30%;">Item Details</th>
						<th style="width:25%;">Bidder Details</th>
						<th style="width:15%;">Payment Mode</th>
						<th style="width:10%;">Bid Price</th>
					  </tr>
					</thead>
					<tbody>
						<?php foreach($auction_report as $result) { ?>
							<tr class="row1">
								<td><?php echo $result->BID_REF_NO; ?></td>
								<td><?php echo $result->ITEM_REF_NO; ?></td>
								<td><?php echo $result->AR_ITEM_DETAILS; ?></td>
								<td><?php echo $result->BIL_NAME; ?></td>
								<td><?php echo $result->AR_PAYMENT_MODE; ?></td>
								<td><?php echo $result->AR_BID_PRICE; ?></td>
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
<script>
	function print() {
		let url = "<?php echo site_url(); ?>generatePDF/create_trustAuctionSession";
		$.post(url,{'payMode':$('#modeOfPayment').val()}, function(data) {
			let url2 = "<?php echo site_url(); ?>generatePDF/create_trustAuctionReportPrint";
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
	
	//GET CREATE PDF
	function generatePDF() {		
		document.getElementById('payMode').value = $('#modeOfPayment').val();
		url = "<?php echo site_url(); ?>generatePDF/create_trustAuctionreportpdf";
		$("#report").attr("action",url)
		$("#report").submit();
	}

	//GET SEND POST FIELDS
	function GetSendField(paymentMethod) {		
		document.getElementById('payMode').value = $('#modeOfPayment').val();
		url = "<?php echo site_url(); ?>TrustReport/auction_report_excel";
		$("#report").attr("action",url)
		$("#report").submit();
	}

	//ON CHANGE OF PAYMENT MODE
	function get_payment_mode_change(paymentMode) {
		document.getElementById('paymentMethod').value = paymentMode;
		url = "<?php echo site_url(); ?>TrustReport/auction_report_payment_mode";
		$("#tddate").attr("action",url)
		$("#tddate").submit();
	}
</script>