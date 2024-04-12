<?php 
	// $this->output->enable_profiler(TRUE);
	// error_reporting(0);
 ?>
<style>
	.blank_row { background:#FBB917; }
	.blank_row:hover { background:#FBB917; }
</style>
<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<!--Heading And Refresh Button-->
	<div class="row form-group">
		<div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
			<span class="eventsFont2">Deity Sevas Report</span>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
			<a style="width:24px; height:24px" class="pull-right img-responsive" href="<?=site_url()?>Report/deity_sevas_report" titile="Reset"><img title="reset" src="<?=site_url();?>images/refresh.svg"/></a>
		</div>
	</div>
	
	<!--DateField, Reports Button And Combobox -->
	<div class="row form-group">
		<form id="tddate" enctype="multipart/form-data" method="post" accept-charset="utf-8">
			<input type="hidden" name="radioOpt" id="radioOpt" value="<?=@$radioOpt; ?>">
			<input type="hidden" name="radioAllOpt" id="radioAllOpt" value="<?=@$radioAllOpt; ?>">
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
					</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<label>
						<input id="AllRadio" class="eventsFont form-control" type="radio" value="" name="alloptradio"> All Deity
					</label>&nbsp;&nbsp;&nbsp;
					<label>
						<input id="SelectRadio" class="eventsFont form-control" type="radio" value="" name="alloptradio"> Select Deity
					</label>&nbsp;&nbsp;&nbsp;
					<label class="checkbox-inline" style="font-weight:bold;float: right;">
					<input type="checkbox" id="Exclude" name="Exclude" onclick="">exclude certain Shashwath Sevas
					</label>&nbsp;&nbsp;&nbsp;
				</div>
			</div>
			
			<div class="multiDate">
				<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5" style="margin-bottom:1em;">
					<div class="input-group input-group-sm">
						<input id="todayDate" name="todayDate" type="text" value="<?php echo $date; ?>" class="form-control todayDate" placeholder="dd-mm-yyyy" onchange="get_datefield_change(this.value)" readonly = "readonly">
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
							<input autocomplete="off" name="fromDate" onchange="get_datefield_change(this.value)" id="fromDate" type="text" class="form-control fromDate2" value="<?=@$fromDate; ?>" placeholder="From: dd-mm-yyyy" readonly = "readonly" />
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
							<input autocomplete="off" name="toDate" onchange="get_datefield_change(this.value)" id="toDate" type="text" value="<?=@$toDate; ?>" class="form-control toDate2" placeholder="To: dd-mm-yyyy" readonly = "readonly"/>
							<div class="input-group-btn">
								<button class="btn btn-default toDate" type="button">
									<i class="glyphicon glyphicon-calendar"></i>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
				
			<div id="dCombo" style="display:none;">
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
					<select onChange="deity_Combo_Change()" id="deityCombo" name="deityCombo" class="form-control">
						<?php foreach($deity as $result) { ?>
							<?php if(@$deityid == $result->DEITY_ID) { ?>
								<option selected value="<?php echo $result->DEITY_ID; ?>"><?php echo $result->DEITY_NAME; ?></option>
							<?php } else { ?>
								<option value="<?php echo $result->DEITY_ID; ?>"><?php echo $result->DEITY_NAME; ?></option>
							<?php } ?>
						<?php } ?>
					</select>
				</div>
				
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
					<select onChange="seva_Combo_Change(this.value);" id="sevaCombo" name="sevaCombo" class="form-control">
						
					</select>
					<!--HIDDEN FIELD-->
					<input type="hidden" name="sevaid" id="sevaid">
					<input type="hidden" name="deityid" id="deityid">
				</div>
			</div>
		</form>
		
		<form id="report" enctype="multipart/form-data" method="post" accept-charset="utf-8">
			<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 text-right pull-right">
				<a onclick="GetSendField()"><img style="width:24px; height:24px" title="Download Excel Report" src="<?=site_url();?>images/excel_icon.svg"/></a>&nbsp;&nbsp;
				<a onclick="generatePDF()"><img style="width:24px; height:24px" title="Download PDF Report" src="<?=site_url();?>images/pdf_icon.svg"/></a>&nbsp;&nbsp;
				<a onClick="print();"><img style="width:24px; height:24px" title="Print Report" src="<?=site_url();?>images/print_icon.svg"/></a>
			</div>
			<!--HIDDEN FIELDS -->
			<input type="hidden" name="excludeOrInclude" id="excludeOrInclude">
			<input type="hidden" name="SId" id="SId">
			<input type="hidden" name="DId" id="DId">
			<input type="hidden" name="dateField" id="dateField">
			<input type="hidden" name="allDates" id="allDateField" value="<?=@$allDates; ?>">
			<input type="hidden" name="radioOpt" id="radioOptField" value="<?=@$radioOpt; ?>">
			<input type="hidden" name="radioAllOpt" id="radioAllOptField" value="<?=@$radioAllOpt; ?>">
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
						<th>Deity</th>
						<th>Seva</th>
						<th>Quantity</th>
						<th>Receipt/Booking No. (Date)</th> 
						<!-- //Joel Sir 19/04/21 -->
						<th>Name</th>
						<th>Phone No.</th>
					  </tr>
					</thead>
					<tbody>
						<?php foreach($report_details as $result) { 
							if($result['RECEIPT_CATEGORY_ID'] == 7) {
								$qty= $result['SO_SEVA_QTY'];
							}
							else {
								$qty= $result['SEVA_QTY'];
							}
							?>
							<tr class="row1">
								<?php if(@$result['RECEIPT_NO']) { ?>
									
									<!-- //Joel Sir Changes -->
									<td><?php echo $result['DEITY_NAME']; ?></td>
									<td><?php echo $result['SO_SEVA_NAME']; ?></td>
									<td><center><?php echo $qty; ?></center></td>
									<td><?php echo $result['RECEIPT_NO_DATE']; ?></td>
									<td><?php echo $result['RECEIPT_NAME']; ?></td>
									<td><?php echo $result['RECEIPT_PHONE']; ?></td>
								<?php } else { ?>
									<td><?php echo $result['DEITY_NAME']; ?></td>
									<td><?php echo $result['SO_SEVA_NAME']; ?></td>
									<td><center><?php echo $qty; ?></center></td><!-- //Joel Sir Changes -->
									<td><?php echo $result['SB_NO']; ?> (<?php echo $result['SB_DATE']; ?>)</td>
									<td><?php echo $result['SB_NAME']; ?></td>
									<td><?php echo $result['SB_PHONE']; ?></td>
								<?php } ?>
							</tr>
						<?php } ?>
					</tbody>
				</table>
				
			</div>
		</div>
	</div>
	<div class= "row">
		<ul class="pagination pagination-sm" style="margin-left:15px;margin-top: -1em;">
			<?=$pages; ?>
		</ul>
		<!--Total Sevas TextField -->
		<?php if($Count != 0) { ?>
		<label class="pull-right" for="sevaAmount" style="font-size:18px;margin-right:15px;margin-top: -1em;">Total Sevas: <strong style="font-size:18px"><?php echo $Count ?></strong></label>
		<?php } ?>					
	</div>
</div>
<script>
	//ON DEITY COMBO CHANGE GET SEVAS
	function deity_Combo_Change() {
		bgNo = $('#deityCombo').val();
		$('#sevaCombo').html("");
		$('#sevaCombo').append('<option value="All">All</option>');
		for(let i = 0; i < arr.length; ++i) {
			if(arr[i]['SO_DEITY_ID'] == bgNo)
				$('#sevaCombo').append('<option value="' + arr[i]['SO_SEVA_ID'] + '">' + arr[i]['SO_SEVA_NAME'] + '</option>');
		}
		seva_Combo_Change();
	}
	
	function getSevaCombo() {
		let sevaCombo = $('#sevaCombo option:selected').val();
		return {
			sevaId:sevaCombo
		}
	}
	
	(function() {
		$('#sevaCombo').append('<option value="All">All</option>');
		Filter = "<?php echo @$Filter; ?>"; //To Check Normal Load OR Filter Load
		SevaId =  "<?php echo @$sevaId; ?>"; //To Match SevaId On Filter Load
		DeityId =  "<?php echo @$deityid; ?>"; //To Match DeityId On Filter Load
		if(Filter == "Yes") {
			arr = <?php echo $sevas; ?>;
			for(let i = 0; i < arr.length; ++i) {
				if(arr[i]['SO_DEITY_ID'] == DeityId) {
					if(arr[i]['SO_SEVA_ID'] == SevaId) {
						$('#sevaCombo').append('<option value="'+ arr[i]['SO_SEVA_ID'] +'" selected>' + arr[i]['SO_SEVA_NAME'] + '</option>');
					} else {
						$('#sevaCombo').append('<option value="'+ arr[i]['SO_SEVA_ID'] +'">' + arr[i]['SO_SEVA_NAME'] + '</option>');
					}
				}
			}
		} else {
			arr = <?php echo $sevas; ?>;
			for(let i = 0; i < arr.length; ++i) {
				if(arr[i]['SO_DEITY_ID'] == 1) {
					$('#sevaCombo').append('<option value="'+ arr[i]['SO_SEVA_ID'] +'">' + arr[i]['SO_SEVA_NAME'] + '</option>');
				}
			}
		}
	}());
		
	//FOR DATEFIELD
	var currentTime = new Date()
    var minDate = new Date(currentTime.getFullYear()); //one day next before month , + currentTime.getDate()
    var maxDate =  new Date(currentTime.getFullYear(), currentTime.getMonth() +12, +0); // one day before next month
    $( ".todayDate" ).datepicker({ 
		minDate: minDate, 
		//maxDate: maxDate,
		changeMonth:true,
		changeYear:true,
		dateFormat: 'dd-mm-yy',
		'yearRange': "2007:+50"
    });
	
	$(".fromDate2").datepicker({
		//maxDate: maxDate,
		dateFormat: 'dd-mm-yy',
		changeMonth:true,
		changeYear:true,
		'yearRange': "2007:+50"
	});
	
	$(".toDate2").datepicker({
		//maxDate: maxDate,
		dateFormat: 'dd-mm-yy',
		changeMonth:true,
		changeYear:true,
		'yearRange': "2007:+50"
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
	
	//GET SEND POST FIELDS
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
	
	if("<?=$radioOpt; ?>" == "date") {
		$('#multiDateRadio').attr("checked", "checked");
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
	
	if("<?=$radioAllOpt; ?>" == "allDeity") {
		$('#AllRadio').attr("checked", "checked");
		$('#AllRadio').css('pointer-event','auto');
		$('#SelectRadio').css('pointer-event','none');
		$('#radioAllOpt').val("allDeity");
		$('#dCombo').hide();
		document.getElementById('radioAllOptField').value = "allDeity";
	} else {
		$('#SelectRadio').attr("checked", "checked");
		$('#AllRadio').css('pointer-event','none');
		$('#SelectRadio').css('pointer-event','auto');
		$('#radioAllOpt').val("selectedDeity");
		$('#dCombo').fadeIn();
		document.getElementById('radioAllOptField').value = "selectedDeity";
	}
	
	$('#AllRadio').on('click', function() {
		$('#AllRadio').attr("checked", "checked");
		$('#AllRadio').css('pointer-event','auto');
		$('#SelectRadio').css('pointer-event','none');
		$('#radioAllOpt').val("allDeity");
		$('#dCombo').hide();
		document.getElementById('radioAllOptField').value = "allDeity";
		$("#tddate").submit();
	});

	$('#SelectRadio').on('click', function() {
		$('#SelectRadio').attr("checked", "checked");
		$('#AllRadio').css('pointer-event','none');
		$('#SelectRadio').css('pointer-event','auto');
		$('#radioAllOpt').val("selectedDeity");
		$('#dCombo').fadeIn();
		document.getElementById('radioAllOptField').value = "selectedDeity";
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
		document.getElementById('sevaid').value = $('#sevaCombo').val();
		document.getElementById('deityid').value = $('#deityCombo').val();
		url = "<?php echo site_url(); ?>Report/deity_seva_date_change_report";
		$("#tddate").attr("action",url)
		$("#tddate").submit();
	});

	
	$('#EveryRadio').on('click', function() {
		$('#EveryRadio').css('pointer-event','auto');
		$('#multiDateRadio').css('pointer-event','none');
		$('.EveryRadio').fadeIn();
		$('#selDate').html("");
		$('.multiDate').hide();
		$('#radioOpt').val("multiDate");
		$('#todayDate').datepicker('setDate', null);
		document.getElementById('radioOptField').value = "multiDate";
		url = "<?php echo site_url(); ?>Report/deity_sevas_report";
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
		url = "<?php echo site_url(); ?>Report/deity_sevas_report";
		$("#tddate").attr("action",url)
		$("#tddate").submit();
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
		
		document.getElementById('DId').value = $('#deityCombo').val();
		document.getElementById('SId').value = $('#sevaCombo').val();
		document.getElementById('dateField').value = $('#todayDate').val();
		if($('#Exclude').prop('checked') == true) {
			document.getElementById('excludeOrInclude').value ="Exclude";
		} else {
			document.getElementById('excludeOrInclude').value ="Include";
		}
		url = "<?php echo site_url(); ?>Report/deity_sevas_report_excel";
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
		
		document.getElementById('DId').value = $('#deityCombo').val();
		document.getElementById('SId').value = $('#sevaCombo').val();
		document.getElementById('dateField').value = $('#todayDate').val();
		if($('#Exclude').prop('checked') == true) {
			document.getElementById('excludeOrInclude').value ="Exclude";
		} else {
			document.getElementById('excludeOrInclude').value ="Include";
		}
		

		url = "<?php echo site_url(); ?>generatePDF/create_deitySevaReceiptpdf";
		$("#report").attr("action",url)
		$("#report").submit();
	}
	
	//CREATE PRINT
	function print() {
		let sevaExcludeOrInclude="";
		let url = "<?php echo site_url(); ?>generatePDF/create_deitySevaReceiptSession";
		radioOpt = document.getElementById('radioOptField').value;
		radioAllOpt = document.getElementById('radioAllOptField').value;
		allDates = document.getElementById('allDates').value;
		if($('#Exclude').prop('checked') == true) {
			sevaExcludeOrInclude ="Exclude";
		} else {
			sevaExcludeOrInclude ="Include";
		}
		$.post(url,{'DId':$('#deityCombo').val(),'SId':$('#sevaCombo').val(),'dateField':$('#todayDate').val(),'radioOpt':radioOpt,'radioAllOpt':radioAllOpt,'allDates':allDates,'sevaExcludeOrInclude':sevaExcludeOrInclude}, function(data) {
			let url2 = "<?php echo site_url(); ?>generatePDF/create_deitySevaReceiptPrint";
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
	
	//ON SEVA COMBO CHANGE
	function seva_Combo_Change() {
		var radio = $('#radioOpt').val();
		let count = 0;
		let seva = getSevaCombo();
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
		document.getElementById('sevaid').value = seva.sevaId;
		document.getElementById('deityid').value = $('#deityCombo').val();
		url = "<?php echo site_url(); ?>Report/deity_seva_date_change_report";
		$("#tddate").attr("action",url)
		$("#tddate").submit();
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
		document.getElementById('sevaid').value = $('#sevaCombo').val();
		document.getElementById('deityid').value = $('#deityCombo').val();
		url = "<?php echo site_url(); ?>Report/deity_seva_date_change_report";
		$("#tddate").attr("action",url)
		$("#tddate").submit();
	}
</script>
