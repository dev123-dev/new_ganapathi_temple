<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<!--Heading And Refresh Button-->
	<div class="row form-group">
		<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
			<span class="eventsFont2">Auction Item Report: <span class="samFont"><?php echo $events[0]->TET_NAME; ?></span></span>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="margin-top: 1em;">
			<a style="width:24px; height:24px" class="pull-right img-responsive" href="<?=site_url()?>TrustReport/auction_report" title="Refresh"><img title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
		</div>
	</div>
	
	<!--DateField, Reports Button -->
	<div class="row form-group">
		<form id="tddate" enctype="multipart/form-data" method="post" accept-charset="utf-8">
			<div class="multiDate">
				<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5" style="margin-bottom:1em;">
					<div class="input-group input-group-sm">
						<input id="todayDate" name="todayDate" type="text" value="<?php echo $date; ?>" class="form-control todayDate" placeholder="dd-mm-yyyy" onchange="get_datefield_change(this.value)">
						<div class="input-group-btn">
						  <button class="btn btn-default todayDateBtn" type="button">
							<i class="glyphicon glyphicon-calendar"></i>
						  </button>
						</div>
					</div>
					<?php if(isset($date)) {?>
						<input type="hidden" name="tdate" id="tdate" value="<?php echo $date; ?>">
					<?php } ?>
				</div>
			</div>
		</form>
		
		<form id="report" enctype="multipart/form-data" method="post" accept-charset="utf-8">
			<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right pull-right">
				<a onclick="GetSendField()" style="cursor:pointer;"><img style="width:24px; height:24px" title="Download Excel Report" src="<?=site_url();?>images/excel_icon.svg"/></a>&nbsp;&nbsp;
				<a onclick="generatePDF()"><img style="width:24px; height:24px" title="Download PDF Report" src="<?=site_url();?>images/pdf_icon.svg"/></a>&nbsp;&nbsp;
				<a onClick="print();"><img style="width:24px; height:24px" title="Print Report" src="<?=site_url();?>images/print_icon.svg"/></a>
			</div>
			<!--HIDDEN FIELDS -->
			<input type="hidden" name="dateField" id="dateField">
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
						<th style="width:10%;">Reference No.</th>
						<th style="width:20%;">Name</th>
						<th style="width:20%;">Phone</th>
						<th style="width:20%;">Category</th>
						<th>Saree Details</th>
					  </tr>
					</thead>
					<tbody>
						<?php foreach($auction_item_report as $result) { ?>
							<tr class="row1">
								<td><?php echo $result->ITEM_REF_NO; ?></td>
								<td><?php echo $result->AIL_NAME; ?></td>
								<td><?php echo $result->AIL_NUMBER; ?></td>
								<td><?php echo $result->AIL_AIC_NAME; ?></td>
								<td><?php echo $result->AIL_ITEM_DETAILS; ?></td>
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
	//FOR DATEFIELD
	var currentTime = new Date()
	var fromDate = "<?=$events[0]->TET_FROM_DATE_TIME; ?>";
	var toDate = "<?=$events[0]->TET_TO_DATE_TIME; ?>"; 
	fromDate = fromDate.split("-");
	toDate = toDate.split("-");
	var minDate = new Date(Number(fromDate[2]), (Number(fromDate[1])-1), +(Number(fromDate[0]))); 
	var maxDate =  new Date(Number(toDate[2]), (Number(toDate[1])-1), + Number(toDate[0]));
	
	$( ".todayDate" ).datepicker({ 
		maxDate: maxDate,
		minDate: minDate,
		dateFormat: 'dd-mm-yy'
    });
     
	$('.todayDateBtn').on('click', function() {
		$( ".todayDate" ).focus();
	});
	
	//CREATE Print
	function print() {
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
		let url = "<?php echo site_url(); ?>generatePDF/create_trustAuctionItemSession";
		$.post(url,{'date':$('#todayDate').val()}, function(data) {
			let url2 = "<?php echo site_url(); ?>generatePDF/create_trustAuctionItemPrint";
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
	
	//CREATE PDF
	function generatePDF() {
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
		document.getElementById('tdate').value = $('#todayDate').val();
		url = "<?php echo site_url(); ?>generatePDF/create_trustAuctionItemPDF";
		$("#tddate").attr("action",url)
		$("#tddate").submit();
	}
	
	//CREATE EXCEL
	function GetSendField() {
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
		document.getElementById('tdate').value = $('#todayDate').val();
		url = "<?php echo site_url(); ?>TrustReport/event_auction_report_excel";
		$("#tddate").attr("action",url)
		$("#tddate").submit();
	}
	
	//ON CHANGE OF DATEFIELD
	function get_datefield_change(date) {
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
		document.getElementById('tdate').value = date;
		url = "<?php echo site_url(); ?>TrustReport/get_change_datefield";
		$("#tddate").attr("action",url)
		$("#tddate").submit();
	}
</script>
