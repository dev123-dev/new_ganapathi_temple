<?php error_reporting(0); ?>
<div style="clear:both;" class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<div class="row form-group">							
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
			<span class="eventsFont2">Deity Seva Summary - <span style="font-size: 17px;"><?php echo $deityName; ?></span></span>
			<a class="pull-right" style="margin-left:5px;" onclick="GetRefresh(event)" title="Refresh"><img style="width:24px; height:24px;" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
			<?php if(isset($_SESSION['Ref'])) { ?>
				<a style="width:24px; height:24px" class="pull-right img-responsive" href="<?=@$_SESSION['actual_link']; ?>" title="back"><img title="Back" src="<?=site_url();?>images/back_icon.svg"/></a>
			<?php } else { ?>
				<a style="width:24px; height:24px" class="pull-right img-responsive" href="<?=site_url()?>Report/deity_seva_summary_Without_Refresh" title="back"><img title="Back" src="<?=site_url();?>images/back_icon.svg"/></a>
			<?php } ?>
		</div>
	</div>	
	<div class="row form-group">
		<form id="tddate" enctype="multipart/form-data" method="post" accept-charset="utf-8">
			<input type="hidden" name="refresh" id="refresh">
			<input type="hidden" name="radioOpt" id="radioOpt" value="<?=@$radioOpt; ?>">
			<input type="hidden" name="fromDates" id="fromDates" value="<?=@$fromDate; ?>">
			<input type="hidden" name="toDates" id="toDates" value="<?=@$toDate; ?>">
			<input type="hidden" name="deityId" id="deityId" value="<?=@$deityId; ?>">
			<input type="hidden" name="deityName" id="deityName" value="<?=@$deityName; ?>">
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
						<input id="todayDate" name="todayDate" type="text" value="<?php echo $date; ?>" class="form-control todayDate" placeholder="dd-mm-yyyy" onchange="get_datefield_change(this.value)">
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
							<input name="fromDate" onchange="get_datefield_change(this.value)" id="fromDate" type="text" class="form-control fromDate2" value="<?=@$fromDate; ?>" placeholder="From: dd-mm-yyyy" />
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
							<input name="toDate" onchange="get_datefield_change(this.value)" id="toDate" type="text" value="<?=@$toDate; ?>" class="form-control toDate2" placeholder="To: dd-mm-yyyy" />
							<div class="input-group-btn">
							  <button class="btn btn-default toDate" type="button">
								<i class="glyphicon glyphicon-calendar"></i>
							  </button>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="control-group col-md-4 col-lg-2 col-sm-4 col-xs-6">
				<select id="summaryType" name="summaryType" class="form-control"  onchange="type_change()" style="height: 30px; width: 200px;">
					<?php if($summaryTypeVal == "allSeva"){ ?>
						<option value="allSeva" style="width: 300px;" selected>All Seva Summary</option>
					<?php }else{?>
						<option value="allSeva" style="width: 300px;">All Seva Summary</option>
					<?php } ?>
					<?php if($summaryTypeVal == "onlyNormalSeva"){ ?>
						<option value="onlyNormalSeva" style="width: 300px;" selected>Only Normal Seva Summary</option>
					<?php }else{?>
						<option value="onlyNormalSeva" style="width: 300px;">Only Normal Seva Summary</option>
					<?php } ?>
					<?php if($summaryTypeVal == "onlyShashwathSeva"){ ?>
						<option value="onlyShashwathSeva" style="width: 300px;" selected>Only Shashwath Seva Summary</option>
					<?php }else{?>
						<option value="onlyShashwathSeva" style="width: 300px;">Only Shashwath Seva Summary</option>
					<?php } ?>
				</select>
			</div>
		</form>
		<form id="report" enctype="multipart/form-data" method="post" accept-charset="utf-8">
			<div class="col-lg-6 col-md-8 col-sm-8 col-xs-4 text-right pull-right">
				<a onclick="GetSendField()" style="cursor:pointer;"><img style="width:24px; height:24px" title="Download Excel Report" src="<?=site_url();?>images/excel_icon.svg"/></a>&nbsp;&nbsp;
				<a onclick="generatePDF()"><img style="width:24px; height:24px;" title="Download PDF Report" src="<?=site_url();?>images/pdf_icon.svg"/></a>&nbsp;&nbsp;
				<a onClick="print();"><img style="width:24px; height:24px;" title="Print Report" src="<?=site_url();?>images/print_icon.svg"/></a>				
			</div>
			<input type="hidden" name="dateField" id="dateField">
			<input type="hidden" name="radioOpt" id="radioOptField" value="<?=@$radioOpt; ?>">
			<input type="hidden" name="fromDates" id="fromDatesField" value="<?=@$fromDate; ?>">
			<input type="hidden" name="toDates" id="toDatesField" value="<?=@$toDate; ?>">
			<input type="hidden" name="deityId" id="deityIdField" value="<?=@$deityId; ?>">
			<input type="hidden" name="deityName" id="deityNameField" value="<?=@$deityName; ?>">
			<input type="hidden" name="summaryType" id="summaryType" value="<?=@$summaryTypeVal; ?>">
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
						<th>Sevas Name</th>
						<th style="width:20%;">Quantity</th>
						<th style="width:10%;">Amount</th>
					  </tr>
					</thead>
					<tbody>
						<?php $Count = 0; $Amount = 0; foreach($report_details as $result) { 
							if($result['SB_ACTIVE'] != "0") {
							$Count += $result['QTY'];$Amount += $result['AMOUNT']; ?>
							<tr class="row1">
								<td><a style="color:#800000;" onClick = "get_display_sevas_details('<?php echo $result['SO_SEVA_ID']; ?>','<?php echo $result['SO_DEITY_NAME']." (".$result['SO_SEVA_NAME'].")"; ?>')"><?php echo $result['SO_SEVA_NAME']; ?></a></td>
								<td><?php echo $result['QTY']; ?></td>
								<td><?php echo $result['AMOUNT']; ?></td>
							</tr>
							<?php } ?>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	<!--Total Sevas TextField -->
	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label class="pull-right" for="sevaAmount" style="font-size:18px;margin-right:15px;margin-top: -1em;">Total Sevas: <span id="totalSeva"><?php echo @$Count; ?></span></label>
			<label class="pull-right" for="sevaAmount" style="font-size:18px;margin-right:15px;margin-top: -1em;padding-right:20px;">Total Amount: <span id="totalSeva"><?php echo @$Amount; ?></span></label>
		</div>
	</div>
</div>

<!--CHANGE OF PAGE-->
<form id="changePage" enctype="multipart/form-data" method="post" accept-charset="utf-8">
	<input type="hidden" name="radioOpt" id="radioOptDeity" value="<?=@$radioOpt; ?>">
	<input type="hidden" name="fromDates" id="fromDatesDeity" value="<?=@$fromDate; ?>">
	<input type="hidden" name="toDates" id="toDatesDeity" value="<?=@$toDate; ?>">
	<input type="hidden" name="tdate" id="tdateDeity" value="<?=@$date; ?>">
	<input type="hidden" name="sevaId" id="sevaId">
	<input type="hidden" name="sevaName" id="sevaName">
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
		$('#EveryRadio').attr("checked", "checked");
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
		url = "<?php echo site_url(); ?>Report/summary_sevas_on_deity";
		$("#tddate").attr("action",url);
		$("#tddate").submit();
	});
	
	$('#multiDateRadio').on('click', function() {
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
		url = "<?php echo site_url(); ?>Report/summary_sevas_on_deity";
		$("#tddate").attr("action",url);
		$("#tddate").submit();
	});
	
	function GetRefresh(e) {
		e.preventDefault();
		$('#EveryRadio').click();
		$('#tDate').val("<?php echo date('d-m-Y'); ?>");
		$('#radioOpt').val("date");
		document.getElementById('radioOptField').value = "date";
		document.getElementById('refresh').value = "refresh";
		url = "<?php echo site_url(); ?>Report/summary_sevas_on_deity";
		$("#tddate").attr("action",url);
		$("#tddate").submit();
	}
	
	//ON CLICK DEITY NAME
	function get_display_sevas_details(Id,Name) {
		document.getElementById('sevaId').value = Id;
		document.getElementById('sevaName').value = Name;
		url = "<?php echo site_url(); ?>Report/sevas_summary_details";
		$("#changePage").attr("action",url);
		$("#changePage").submit();
	}
	
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
		url = "<?php echo site_url(); ?>Report/get_filter_change_sevas";
		$("#tddate").attr("action",url);
		$("#tddate").submit();
	}

	function type_change(){
		document.getElementById('tdate').value = $('#todayDate').val();
		url = "<?php echo site_url(); ?>Report/get_filter_change_sevas";
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
		
		url = "<?php echo site_url(); ?>Report/deity_sevas_summary_excel";
		$("#report").attr("action",url);
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
		
		url = "<?php echo site_url(); ?>generatePDF/create_SevaSummaryReceiptpdf";
		$("#report").attr("action",url);
		$("#report").submit();
	}
	
	//CREATE PRINT
	function print() {
		let url = "<?php echo site_url(); ?>generatePDF/create_SevasSummaryReceiptSession";
		radioOpt = document.getElementById('radioOptField').value;
		fromDates = document.getElementById('fromDatesField').value;
		toDates = document.getElementById('toDatesField').value;
		deityId = document.getElementById('deityIdField').value;
		deityName = document.getElementById('deityNameField').value;
		summaryType = document.getElementById('summaryType').value;
		$.post(url,{'dateField':$('#todayDate').val(),'radioOpt':radioOpt,'fromDates':fromDates,'toDates':toDates,'deityId':deityId,'deityName':deityName,'summaryType':summaryType}, function(data) {
			let url2 = "<?php echo site_url(); ?>generatePDF/create_SevasSummaryReceiptPrint";
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
		maxDate: maxDate,
		dateFormat: 'dd-mm-yy'
    });
	
	$(".fromDate2").datepicker({
		maxDate: maxDate,
		dateFormat: 'dd-mm-yy'
	});
	
	$(".toDate2").datepicker({
		maxDate: maxDate,
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