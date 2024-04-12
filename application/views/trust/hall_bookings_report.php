<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<!--Heading And Refresh Button-->
	<div class="row form-group">
		<div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
			<span class="eventsFont2">Hall Bookings Report</span>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
			<a style="width:24px; height:24px" class="pull-right img-responsive" href="<?=site_url()?>/TrustReport/hall_bookings_report" title="Reset"><img title="reset" src="<?=site_url();?>images/refresh.svg"/></a>
		</div>
	</div>
	
	<!--DateField, Reports Button And Combobox -->
	<div class="row form-group">
		<form id="tddate" enctype="multipart/form-data" method="post" accept-charset="utf-8">
			<input type="hidden" name="radioOpt" id="radioOpt" value="<?=@$radioOpt; ?>">
			<input type="hidden" name="allDates" id="allDates" value="<?=@$allDates; ?>">
			<?php if(isset($date)) {?>
				<input type="hidden" name="tdate" id="tdate" value="<?php echo @$date; ?>">
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
						<input id="todayDate" name="todayDate" type="text" value="<?php echo @$date; ?>" class="form-control todayDate" placeholder="dd-mm-yyyy" onchange="get_datefield_change(this.value)" readonly="readonly">
						<div class="input-group-btn">
						  <button class="btn btn-default toDateBtn" type="button">
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
			
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-9" style="margin-bottom:1em;">
			  <select id="hall" name="hall" class="form-control" onchange="get_hall_change(this.value)">
				<option value="All Hall">All Hall</option>
				<?php if(isset($hallId)) { ?>
					<?php foreach($hall_details as $result) { ?>
						<?php if($hallId == $result->H_ID) { ?>
							<option value="<?php echo $result->H_ID; ?>" selected><?php echo $result->H_NAME; ?></option>
						<?php } else { ?>
							<option value="<?php echo $result->H_ID; ?>"><?php echo $result->H_NAME; ?></option>
						<?php } ?>
					<?php } ?>
				<?php } else { ?>
					<?php foreach($hall_details as $result) { ?>
						<option value="<?php echo $result->H_ID; ?>"><?php echo $result->H_NAME; ?></option>
					<?php } ?>
				<?php } ?>
			  </select>
			</div>
		</form>
		<form id="report" enctype="multipart/form-data" method="post" accept-charset="utf-8">
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-right pull-right">
				<a onclick="GetSendField()" style="cursor:pointer;"><img style="width:24px; height:24px" title="Download Excel Report" src="<?=site_url();?>images/excel_icon.svg"/></a>&nbsp;&nbsp;
				<a onclick="generatePDF()"><img style="width:24px; height:24px" title="Download PDF Report" src="<?=site_url();?>images/pdf_icon.svg"/></a>&nbsp;&nbsp;
				<a onClick="print();"><img style="width:24px; height:24px" title="Print Report" src="<?=site_url();?>images/print_icon.svg"/></a>
			</div>
			<!--HIDDEN FIELDS -->
			<input type="hidden" name="payMode" id="payMode">
			<input type="hidden" name="dateField" id="dateField">
			<input type="hidden" name="hallId" id="hallId">
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
						<th>Booking No.</th>
						<th>Name</th>
						<th>Hall Name</th>
						<th>Function Type</th>
						<th>Booking Date</th>
						<th>From Time</th>
						<th>To Time</th>
						<th>Hours</th>
					  </tr>
					</thead>
					<tbody>
						<?php foreach($hall_booking_reports as $result) { ?>
							<tr class="row1">
								<td><?php echo $result->HB_NO; ?></td>
								<td><?php echo $result->HB_NAME; ?></td>
								<td><?php echo $result->H_NAME; ?></td>
								<td><?php echo $result->FN_NAME; ?></td>
								<td><?php echo $result->HB_BOOK_DATE; ?></td>
								<td><?php echo date('g:i a', strtotime($result->HB_BOOK_TIME_FROM)); ?></td>
								<td><?php echo date('g:i a', strtotime($result->HB_BOOK_TIME_TO)); ?></td>
								<?php
									$fromTime = strtotime($result->HB_BOOK_TIME_FROM);
									$toTime = strtotime($result->HB_BOOK_TIME_TO);
									$diff = $toTime - $fromTime;
									$time = $diff; 
									$days = floor($time / (60 * 60 * 24));
									$time -= $days * (60 * 60 * 24);

									$hours = floor($time / (60 * 60));
									$time -= $hours * (60 * 60);

									$minutes = floor($time / 60);
									$time -= $minutes * 60;

									$seconds = floor($time);
									$time -= $seconds;
								?>
								<td><?php echo "{$hours}h {$minutes}m"; ?></td>	
							</tr>
						<?php } ?>
					</tbody>
				</table>
				<!-- <ul class="pagination pagination-sm">
					<?=@$pages; ?>
				</ul> -->
			</div>
		</div>
	</div>
	<!--Total Sevas TextField -->
	<div class= "row">
		<ul class="pagination pagination-sm" style="margin-left:15px;margin-top: -1em;">
			<?=$pages; ?>
		</ul>
		<!--Total Sevas TextField -->
			<label class="pull-right" for="sevaAmount" style="font-size:18px;margin-right:15px;margin-top: -1em;">Total : <span id="totalSeva"><?php echo $Count; ?></span></label>  
						
	</div>
</div>
<script>
	var between = [];
	
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

	function print() {		
		let url = "<?php echo site_url(); ?>generatePDF/create_hallBookingSession";
		radioOpt = document.getElementById('radioOptField').value;
		allDates = document.getElementById('allDates').value;
		$.post(url,{'dateField':$('#todayDate').val(),'hallId':$('#hall').val(),'radioOpt':radioOpt, 'allDates':allDates}, function(data) {
			let url2 = "<?php echo site_url(); ?>generatePDF/create_hallBookingPrint";
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
		
		document.getElementById('dateField').value = $('#todayDate').val();
		document.getElementById('hallId').value = $('#hall').val();
		url = "<?php echo site_url(); ?>generatePDF/create_hallBookingpdf";
		$("#report").attr("action",url)
		$("#report").submit();
	}
	
	//GET SEND POST FIELDS
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
		
		document.getElementById('dateField').value = $('#todayDate').val();
		document.getElementById('hallId').value = $('#hall').val();
		url = "<?php echo site_url(); ?>TrustReport/hall_booking_report_excel";
		$("#report").attr("action",url)
		$("#report").submit();
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
		document.getElementById('hallId').value = $('#hall').val();
		url = "<?php echo site_url(); ?>TrustReport/hall_booking_report_on_change_date";
		$("#tddate").attr("action",url)
		$("#tddate").submit();
	}

	//ON CHANGE OF DEITY
	function get_hall_change(hallId) {
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
		
		document.getElementById('tdate').value = $('#todayDate').val();
		document.getElementById('hallId').value = hallId;
		url = "<?php echo site_url(); ?>TrustReport/hall_booking_report_on_change_date";
		$("#tddate").attr("action",url)
		$("#tddate").submit();
	}
	
	//FOR DATEFIELD
	var currentTime = new Date()
    var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
    var maxDate =  new Date(currentTime.getFullYear(), currentTime.getMonth() +12, +0); // one day before next month
    $( ".todayDate" ).datepicker({ 
		minDate: "-1Y", 
		//maxDate: 0,
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50",
		dateFormat: 'dd-mm-yy'
    });
     
	$('.todayDate').on('click', function() {
		$( ".todayDate" ).focus();
	})
	
	$(".fromDate2").datepicker({
		//maxDate: 0,
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50",
		dateFormat: 'dd-mm-yy'
	});
	
	$(".toDate2").datepicker({
		//maxDate: 0,
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50",
		dateFormat: 'dd-mm-yy'
	});
	
	$( ".toDate" ).datepicker({ 
		//maxDate: 0,
		dateFormat: 'dd-mm-yy'
    });
     
	$('.toDateBtn').on('click', function() {
		$( ".todayDate" ).focus();
	})
	
	$('.toDate').on('click', function() {
		$( ".toDate2" ).focus();
	})
	
	$('.fromDate').on('click', function() {
		$( ".fromDate2" ).focus();
	})
	
	$('#EveryRadio').on('click', function() {
		$('#EveryRadio').css('pointer-event','auto');
		$('#multiDateRadio').css('pointer-event','none');
		$('.EveryRadio').fadeIn();
		$('#selDate').html("");
		$('.multiDate').hide();
		$('#radioOpt').val("multiDate");
		$('#todayDate').datepicker('setDate', null);
		document.getElementById('radioOptField').value = "multiDate";
		url = "<?php echo site_url(); ?>TrustReport/hall_bookings_report";
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
		document.getElementById('radioOptField').value = "date";
		url = "<?php echo site_url(); ?>TrustReport/hall_bookings_report";
		$("#tddate").attr("action",url)
		$("#tddate").submit();
	});
	
	if("<?=@$radioOpt; ?>" == "date") {
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
</script>
