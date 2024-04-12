<?php 
	// $this->output->enable_profiler(TRUE);
	// print_r($_SESSION);
 ?>
<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<!--Heading And Refresh Button-->
	<div class="row form-group">
		<div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
			<span class="eventsFont2">Current Event Sevas Report: <span class="samFont"><?php echo $events[0]->ET_NAME; ?></span></span>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
			<a style="width:24px; height:24px" class="pull-right img-responsive" href="<?=site_url()?>Report/event_seva_report" title="Refresh"><img title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
		</div>
	</div>
	
	<!--DateField, Reports Button And Combobox -->
	<div class="row form-group">
		<form id="tddate" enctype="multipart/form-data" method="post" accept-charset="utf-8">
			<input type="hidden" name="radioOpt" id="radioOpt" value="<?=@$radioOpt; ?>">
			<input type="hidden" name="allDates" id="allDates" value="<?=@$allDates; ?>">
			<?php if(isset($date)) { ?>
				<input type="hidden" name="tdate" id="tdate" value="<?php echo $date; ?>">
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
				
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-9" style="margin-bottom:1em;display:none;">
			  <select id="deity" name="deity" class="form-control" disabled>
				<?php foreach($events as $result) { ?>
					<option value="<?php echo $result->ET_ID; ?>"><?php echo $result->ET_NAME; ?></option>
				<?php } ?>
			  </select>
			</div>
		
			<div class="col-lg-2 col-md-1 col-sm-1 col-xs-9">
			
			  <select id="sevas" name="sevas" class="form-control" onchange="get_seva_change(this.value)">
				<option value="All">All</option>
				<?php foreach($events_seva as $result) { ?>
					<?php if($sevaId == $result->ET_SO_SEVA_ID) { ?>
						<option selected value="<?php echo $result->ET_SO_SEVA_ID; ?>"><?php echo $result->ET_SO_SEVA_NAME; ?></option>
					<?php } else { ?>
						<option value="<?php echo $result->ET_SO_SEVA_ID; ?>"><?php echo $result->ET_SO_SEVA_NAME; ?></option>
					<?php } ?>
				<?php } ?>
			  </select>
			</div>
			<!--HIDDEN FIELDS -->
			<input type="hidden" name="sevaid" id="sevaid">
		</form>
		
		<form id="report" enctype="multipart/form-data" method="post" accept-charset="utf-8">
			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 text-right pull-right">
				<button type="button" onclick="generateAddPDF();" class="btn btn-default  Exlbl">Export Label</button>&nbsp;&nbsp;&nbsp;
				<a onclick="GetSendField()"><img style="width:24px; height:24px" title="Download Excel Report" src="<?=site_url();?>images/excel_icon.svg"/></a>&nbsp;&nbsp;
				<a onclick="generatePDF()"><img style="width:24px; height:24px" title="Download PDF Report" src="<?=site_url();?>images/pdf_icon.svg"/></a>&nbsp;&nbsp;
				<a onClick="print();"><img style="width:24px; height:24px" title="Print Report" src="<?=site_url();?>images/print_icon.svg"/></a>
			</div>
			<!--HIDDEN FIELDS -->
			<input type="hidden" name="SId" id="SId">
			<input type="hidden" name="dateField" id="dateField">
			<input type="hidden" name="allDates" id="allDateField" value="<?=@$allDates; ?>">
			<input type="hidden" name="radioOpt" id="radioOptField" value="<?=@$radioOpt; ?>">
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
						<th>Seva</th>
						<th>Name</th>
						<th>Phone</th>
						<th>Receipt No.</th>
					  </tr>
					</thead>
					<tbody>
						<?php foreach($seva_report as $result) { ?>
							<tr class="row1">
								<td><?php echo $result->ET_SO_SEVA_NAME; ?></td>
								<td><?php echo $result->ET_RECEIPT_NAME; ?></td>
								<!--<?php // if($result->ET_RECEIPT_RASHI != "" && $result->ET_RECEIPT_NAKSHATRA != "") { ?>
									<td><?php //echo $result->ET_RECEIPT_RASHI ." (".$result->ET_RECEIPT_NAKSHATRA.")"; ?></td>
								<?php //} else { ?>
									<td></td>
								<?php //} ?>-->
								<td><?php echo $result->ET_RECEIPT_PHONE; ?></td> 
								<td><?php echo $result->ET_RECEIPT_NO; ?></td> 
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
	
	<!--Total Sevas TextField -->
	<div class= "row">
			<label class="pull-right" for="sevaAmount" style="font-size:18px;margin-right:15px;margin-top: -3.5em;">Total Sevas: <span id="totalSeva"><?php echo $Count; ?></span></label>  
						
	</div>
</div>

<script>
	//GET SEND POST FIELDS
	var between = [];
	
	function GetSendField() {
		document.getElementById('SId').value = $('#sevas').val();
		document.getElementById('dateField').value = $('#todayDate').val();
		url = "<?php echo site_url(); ?>Report/event_sevas_report_excel";
		$("#report").attr("action",url)
		$("#report").submit();
	}
	
	function generateAllDates() {
		between = [];
		var sDate1 = "";
		
		var start = $("#fromDate").datepicker("getDate");
		end = $("#toDate").datepicker("getDate");
		console.log(start)
		currentDate = new Date(start),
		between = [];
		while (currentDate <= end) {
			console.log(currentDate);
			between.push(("0" + currentDate.getDate()).slice(-2) + "-" + ("0" + (currentDate.getMonth() + 1)).slice(-2) + "-" + currentDate.getFullYear());	
			
			currentDate.setDate(currentDate.getDate() + 1);
		}
		newDate = between.join("|")
		console.log(newDate)
		document.getElementById('allDates').value = newDate;
		document.getElementById('allDateField').value =  newDate;
	}
	
	if("<?=$radioOpt; ?>" == "date") {
		$('#multiDateRadio').attr("checked", "checked")
		$('#EveryRadio').css('pointer-event','none');
		$('#multiDateRadio').css('pointer-event','auto');
		$('#selDate').html("");
		$('.multiDate').fadeIn();
		$('#fromDate').val("");
		$('#toDate').val("");
		$('.EveryRadio').hide();
		$('#radioOpt').val("date");
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
	
	$('#EveryRadio').on('click', function() {
		$('#EveryRadio').css('pointer-event','auto');
		$('#multiDateRadio').css('pointer-event','none');
		$('.EveryRadio').fadeIn();
		$('#selDate').html("");
		$('.multiDate').hide();
		$('#radioOpt').val("multiDate");
		$('#todayDate').datepicker('setDate', null);
		document.getElementById('radioOptField').value = "multiDate";
		url = "<?php echo site_url(); ?>Report/event_seva_report";
		$("#report").attr("action",url)
		$("#report").submit();
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
		document.getElementById('radioOptField').value = "date";
		url = "<?php echo site_url(); ?>Report/event_seva_report";
		$("#report").attr("action",url)
		$("#report").submit();
	});
	
	$('.todayDateBtn').on('click', function() {
		$( ".todayDate" ).focus();
	})
	
	$('.toDate').on('click', function() {
		$( ".toDate2" ).focus();
	})
	
	$('.fromDate').on('click', function() {
		$( ".fromDate2" ).focus();
	})
	
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
		} else {
			if(!$('#toDate').val()) {
				$('#toDate').css('border', "1px solid #FF0000"); 
				++count
			} else {
				$('#toDate').css('border', "1px solid #000000"); 
			}
			
			if(!$('#fromDate').val()) {
				$('#fromDate').css('border', "1px solid #FF0000"); 
				++count
			} else {
				$('#fromDate').css('border', "1px solid #000000"); 
			}
			
			if(count == 0) {
				generateAllDates();
			}
		}
		
		if(count != 0) {
			alert("Information","Please fill required fields","OK");
			return false;
		}
		
		document.getElementById('SId').value = $('#sevas').val();
		document.getElementById('dateField').value = $('#todayDate').val();

		url = "<?php echo site_url(); ?>generatePDF/create_sevaReceiptpdf";
		$("#report").attr("action",url)
		$("#report").submit();
	}
	
	
	function generateAddPDF() {
		var radio = $('#radioOpt').val();
		let count = 0;
		if(radio == "date"){
			if(!$('#todayDate').val()) {
				$('#todayDate').css('border', "1px solid #FF0000"); 
				++count
			} else {
				$('#todayDate').css('border', "1px solid #000000");
			}
		} else {
			if(!$('#toDate').val()) {
				$('#toDate').css('border', "1px solid #FF0000"); 
				++count
			} else {
				$('#toDate').css('border', "1px solid #000000"); 
			}
			
			if(!$('#fromDate').val()) {
				$('#fromDate').css('border', "1px solid #FF0000"); 
				++count
			} else {
				$('#fromDate').css('border', "1px solid #000000"); 
			}
			
			if(count == 0) {
				generateAllDates();
			}
		}
		
		if(count != 0) {
			alert("Information","Please fill required fields","OK");
			return false;
		}
		
		document.getElementById('SId').value = $('#sevas').val();
		document.getElementById('dateField').value = $('#todayDate').val();

		url = "<?php echo site_url(); ?>EventGenerationFPDF/eventAddress";
		$("#report").attr("action",url)
		$("#report").submit();
	}
	
	
	
	
	function print() {
		let url = "<?php echo site_url(); ?>generatePDF/create_sevaReceiptSession";
		radioOpt = document.getElementById('radioOptField').value;
		allDates = document.getElementById('allDates').value
		$.post(url,{'SId':$('#sevas').val(),'dateField':$('#todayDate').val(),'radioOpt':radioOpt, 'allDates':allDates}, function(data) {
			let url2 = "<?php echo site_url(); ?>generatePDF/create_sevaReceiptPrint";
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
		} else {
			if(!$('#fromDate').val()) {
				$('#fromDate').css('border', "1px solid #FF0000"); 
				++count
			} else {
				$('#fromDate').css('border', "1px solid #000000"); 
			}
			 
			if(count == 0)
				generateAllDates();
		}
		
		if(count != 0) {
			alert("Information","Please fill required fields","OK");
			return false;
		}
		
		document.getElementById('tdate').value = date;
		document.getElementById('sevaid').value = $('#sevas').val();
		url = "<?php echo site_url(); ?>Report/event_date_change_report";
		$("#tddate").attr("action",url)
		$("#tddate").submit();
	}

	//ON CHANGE OF PAYMENT MODE
	function get_seva_change(sevaId) {
		var radio = $('#radioOpt').val();
		let count = 0;
		if(radio == "date"){
			if(!$('#todayDate').val()) {
				$('#todayDate').css('border', "1px solid #FF0000"); 
				++count
			} else {
				$('#todayDate').css('border', "1px solid #000000"); 
			}
		} else {
			if(!$('#fromDate').val()) {
				$('#fromDate').css('border', "1px solid #FF0000"); 
				++count
			} else {
				$('#fromDate').css('border', "1px solid #000000"); 
			}
			
			if(count == 0)
				generateAllDates();
		}
		
		if(count != 0) {
			alert("Information","Please fill required fields","OK");
			return false;
		}
		document.getElementById('sevaid').value = sevaId;
		document.getElementById('tdate').value = $('#todayDate').val();
		url = "<?php echo site_url(); ?>Report/event_date_change_report";
		$("#tddate").attr("action",url)
		$("#tddate").submit();
	}
	
	//FOR DATEFIELD
	var currentTime = new Date()
    var minDate = new Date(currentTime.getFullYear()); //one day next before month , + currentTime.getDate()
    var maxDate =  new Date(currentTime.getFullYear(), currentTime.getMonth() +12, +0); // one day before next month
    $( ".todayDate" ).datepicker({ 
		minDate: minDate, 
		//maxDate: maxDate,
		dateFormat: 'dd-mm-yy',
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50",
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
	
	/*$( ".toDate" ).datepicker({ 
		minDate: minDate, 
		maxDate: maxDate,
		dateFormat: 'dd-mm-yy'
    });*/
     
	$('.toDateBtn').on('click', function() {
		$( ".todayDate" ).focus();
	})
</script>