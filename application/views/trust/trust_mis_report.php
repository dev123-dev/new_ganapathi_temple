<?php error_reporting(0); ?>
<div style="clear:both;" class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<div class="row form-group">							
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
			<span class="eventsFont2">Trust MIS Report</span>
			<a class="pull-right" style="margin-left:5px;" href="<?=site_url()?>TrustReport/trust_mis_report" title="Refresh"><img style="width:24px; height:24px;" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
		</div>
	</div>	
	
	<div class="row form-group">
		<form id="tddate" enctype="multipart/form-data" method="post" accept-charset="utf-8">
			<input type="hidden" name="radioOpt" id="radioOpt" value="<?=@$radioOpt; ?>">
			<input type="hidden" name="fromDates" id="fromDates" value="<?=@$fromDate; ?>">
			<input type="hidden" name="toDates" id="toDates" value="<?=@$toDate; ?>">
			<?php if(isset($date)) { ?>
				<input type="hidden" name="tdate" id="tdate" value="<?=@$date; ?>">
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
			<!--SINGLE DATE -->
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
			<!--MULTI DATE -->
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
		</form>
		<form id="report" enctype="multipart/form-data" method="post" accept-charset="utf-8">
			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-4 text-right pull-right">
				<a onclick="GetSendField()" style="cursor:pointer;"><img style="width:24px; height:24px" title="Download Excel Report" src="<?=site_url();?>images/excel_icon.svg"/></a>&nbsp;&nbsp;
				<a onclick="generatePDF()"><img style="width:24px; height:24px;" title="Download PDF Report" src="<?=site_url();?>images/pdf_icon.svg"/></a>&nbsp;&nbsp;
				<a onClick="print();"><img style="width:24px; height:24px;" title="Print Report" src="<?=site_url();?>images/print_icon.svg"/></a>				
			</div>
			<input type="hidden" name="dateField" id="dateField">
			<input type="hidden" name="tdate" id="tdateDeity" value="<?=@$date; ?>">
			<input type="hidden" name="radioOpt" id="radioOptField" value="<?=@$radioOpt; ?>">
			<input type="hidden" name="fromDates" id="fromDatesField" value="<?=@$fromDate; ?>">
			<input type="hidden" name="toDates" id="toDatesField" value="<?=@$toDate; ?>">
		</form>
	</div>
</div>
<!--DATAGRID-->
<div class="container">
	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
					  <tr>
						<th>Financial Head Name</th>
						<th style="width:20%;">Quantity</th>
						<th style="width:10%;">Amount</th>
					  </tr>
					</thead>
					<tbody>
						<?php $Count = 0; foreach($report_details as $result) { $Count += $result['QTY']; ?>
							<tr class="row1">
								<td><?php echo $result['FH_NAME']; ?></td>
								<td><?php echo $result['QTY']; ?></td>
								<td><?php echo $result['PRICE']; ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	<!--Total Sevas TextField -->
	<div class="row form-group" style="display:none;">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label class="pull-right" for="sevaAmount">Total: <span id="totalSeva"><?php echo @$Count; ?></span></label>  
		</div>
	</div>

	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Receipt No</th>
							<th>Name</th>
							<th>Item Name</th>
							<th>Quantity</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($inkind_report_details as $result) {
							echo "<tr>";
							echo "<td>".$result['TR_NO']."</td>";
							echo "<td>".$result['RECEIPT_NAME']."</td>";
							echo "<td>".$result['IK_ITEM_NAME']."</td>";
							echo "<td>".$result['amount']." ".$result['IK_ITEM_UNIT']."</td>";
							echo "</tr>";
						} ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	<!--Total Sevas TextField -->
	<div class="row form-group" style="display:none;">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label class="pull-right" for="sevaAmount">Total: <span id="totalSeva"><?php echo @$Count; ?></span></label>  
		</div>
	</div>
</div>

<!--CHANGE OF PAGE-->
<form id="changePage" enctype="multipart/form-data" method="post" accept-charset="utf-8">
	<input type="hidden" name="radioOpt" id="radioOptDeity" value="<?=@$radioOpt; ?>">
	<input type="hidden" name="fromDates" id="fromDatesDeity" value="<?=@$fromDate; ?>">
	<input type="hidden" name="toDates" id="toDatesDeity" value="<?=@$toDate; ?>">
	<input type="hidden" name="tdate" id="tdateDeity" value="<?=@$date; ?>">
	<input type="hidden" name="deityId" id="deityId">
	<input type="hidden" name="deityName" id="deityName">
</form>
<script>
	//ON LOAD RADIO BUTTON
	if("<?=$radioOpt; ?>" == "date") {
		$('#multiDateRadio').attr("checked", "checked");
		$('#EveryRadio').css('pointer-event','none');
		$('#multiDateRadio').css('pointer-event','auto');
		$('#selDate').html("");
		$('.multiDate').fadeIn();
		$('#fromDate').val("");
		$('#toDate').val("");
		$('#tDate').val("");
		$('.EveryRadio').hide();
		$('#radioOpt').val("date");
		document.getElementById('tdate').value = "<?php echo date('d-m-Y'); ?>";
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
	
	//ON CLICK RADIO BUTTON
	$('#EveryRadio').on('click', function() {
		$('#EveryRadio').css('pointer-event','auto');
		$('#multiDateRadio').css('pointer-event','none');
		$('.EveryRadio').fadeIn();
		$('#selDate').html("");
		$('.multiDate').hide();
		$('#radioOpt').val("multiDate");
		$('#todayDate').datepicker('setDate', null);
		document.getElementById('radioOptField').value = "multiDate";
		url = "<?php echo site_url(); ?>TrustReport/trust_mis_report";
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
		$('#tDate').val("");
		document.getElementById('tdate').value = "<?php echo date('d-m-Y'); ?>";
		document.getElementById('radioOptField').value = "date";
		url = "<?php echo site_url(); ?>TrustReport/trust_mis_report";
		$("#tddate").attr("action",url)
		$("#tddate").submit();
	});
	
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
			document.getElementById('tdate').value = $('#todayDate').val();
		} else {
			if(!$('#fromDate').val()) {
				$('#fromDate').css('border', "1px solid #FF0000"); 
				++count
			} else {
				$('#fromDate').css('border', "1px solid #000000"); 
			}
			
			document.getElementById('fromDates').value = $('#fromDate').val();
			document.getElementById('toDates').value = $('#toDate').val();
		}
		
		if($('#fromDate').val() != "" && !$('#toDate').val()) {
			return false;
		} else if($('#toDate').val() != "" && !$('#fromDate').val()) {
			return false;
		}
		
		if(count != 0) {
			alert("Information","Please fill required fields","OK");
			return false;
		}
		
		document.getElementById('tdate').value = date;
		url = "<?php echo site_url(); ?>TrustReport/get_filter_change";
		$("#tddate").attr("action",url)
		$("#tddate").submit();
	}
	
	//CREATE EXCEL
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
			document.getElementById('dateField').value = $('#todayDate').val();
			document.getElementById('tdate').value = $('#todayDate').val();
			document.getElementById('tdateDeity').value = $('#todayDate').val();
		} else {
			if(!$('#fromDate').val()) {
				$('#fromDate').css('border', "1px solid #FF0000"); 
				++count
			} else {
				$('#fromDate').css('border', "1px solid #000000"); 
			}
			
			document.getElementById('fromDatesField').value = $('#fromDate').val();
			document.getElementById('toDatesField').value = $('#toDate').val();
		}
		
		if($('#fromDate').val() != "" && !$('#toDate').val()) {
			return false;
		} else if($('#toDate').val() != "" && !$('#fromDate').val()) {
			return false;
		}
		
		if(count != 0) {
			alert("Information","Please fill required fields","OK");
			return false;
		}
		
		url = "<?php echo site_url(); ?>TrustReport/trust_mis_report_excel";
		$("#report").attr("action",url)
		$("#report").submit();
	}
	
	//CREATE PDF
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
			document.getElementById('dateField').value = $('#todayDate').val();
			document.getElementById('tdate').value = $('#todayDate').val();
		} else {
			if(!$('#fromDate').val()) {
				$('#fromDate').css('border', "1px solid #FF0000"); 
				++count
			} else {
				$('#fromDate').css('border', "1px solid #000000"); 
			}
			
			document.getElementById('fromDatesField').value = $('#fromDate').val();
			document.getElementById('toDatesField').value = $('#toDate').val();
		}
		
		if($('#fromDate').val() != "" && !$('#toDate').val()) {
			return false;
		} else if($('#toDate').val() != "" && !$('#fromDate').val()) {
			return false;
		}
		
		if(count != 0) {
			alert("Information","Please fill required fields","OK");
			return false;
		}
		
		url = "<?php echo site_url(); ?>generatePDF/create_trustMISpdf";
		$("#report").attr("action",url)
		$("#report").submit();
	}
	
	//CREATE PRINT
	function print() {
		let url = "<?php echo site_url(); ?>generatePDF/create_trustMISSession";
		radioOpt = document.getElementById('radioOptField').value;
		fromDates = document.getElementById('fromDatesField').value;
		toDates = document.getElementById('toDatesField').value;
		$.post(url,{'dateField':$('#todayDate').val(),'radioOpt':radioOpt,'fromDates':fromDates,'toDates':toDates}, function(data) {
			let url2 = "<?php echo site_url(); ?>generatePDF/create_trustMISPrint";
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
	
	//FOR DATEFIELD
	var currentTime = new Date()
    var minDate = new Date(currentTime.getFullYear()); //one day next before month , + currentTime.getDate()
    var maxDate =  new Date(currentTime.getFullYear(), currentTime.getMonth() +12, +0); // one day before next month
    $( ".todayDate" ).datepicker({ 
		minDate: minDate, 
		//maxDate: maxDate,
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50",
		dateFormat: 'dd-mm-yy'
    });
	
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
     
	$('.todayDateBtn').on('click', function() {
		$( ".todayDate" ).focus();
	})
	
	$( ".toDate" ).datepicker({ 
		minDate: minDate, 
		maxDate: maxDate,
		dateFormat: 'dd-mm-yy'
    });
     
	$('.toDateBtn').on('click', function() {
		$( ".todayDate" ).focus();
	})
</script>