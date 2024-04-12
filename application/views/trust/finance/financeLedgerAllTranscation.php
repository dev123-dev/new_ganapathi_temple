<?php error_reporting(0); ?>
<div class="container">
<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />

<div class="row form-group">							
	<div class="col-lg-3 col-md-10 col-sm-10 col-xs-8" style = "padding-right:0px;padding-top:10px;">
			<h3 style="margin-top:0px"><b>All Ledger Transcation </b></h3>
	</div>
</div>
 <form id="tddate" enctype="multipart/form-data" method="post" accept-charset="utf-8">
	<input type="hidden" name="radioOpt" id="radioOpt" value="<?=@$radioOpt; ?>">
	<input type="hidden" name="allDates" id="allDates" value="<?=@$allDates; ?>">
	<input type="hidden" name="FGLH_ID" id="FGLH_ID" value="<?=@$FGLH_ID; ?>">
	<input type="hidden" name="CommitteeIdVal" id="CommitteeIdVal" value="<?php echo $compId; ?>">
	<?php if(isset($date)) {?>
		<input type="hidden" name="tdate" id="tdate" value="<?php echo $date; ?>">
	<?php } ?>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-left: -15px;">
		<div class="radio form-group">
			<label> 
				<input id="multiDateRadio" class="eventsFont form-control" type="radio" value="" name="optradio"/> Single Date
			</label>&nbsp;&nbsp;&nbsp;
			<label>
				<input id="EveryRadio" class="eventsFont form-control" type="radio" value="" name="optradio"/> Multiple Date
			</label>
		</div>
	</div>
	<div class="multiDate" style=" margin-left: -15px;">
		<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5" style="margin-bottom:1em;">
			<div class="input-group input-group-sm">
				<input id="todayDate" name="todayDate" type="text" value="<?php echo $date; ?>" class="form-control todayDate" placeholder="dd-mm-yyyy" readonly = "readonly" onchange="get_datefield_change(this.value)" autocomplete="off">
				<div class="input-group-btn">
				  <button class="btn btn-default toDateBtn" type="button">
					<i class="glyphicon glyphicon-calendar"></i>
				  </button>
				</div>
			</div>
		</div>
	</div>
	<div class="EveryRadio" style="display:none; margin-left: -15px;">
		<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6" style="width: 200px;">
			<div class="form-group">
				<div class="input-group input-group-sm">
					<input name="fromDate" onchange="get_datefield_change(this.value)" id="fromDate" type="text" class="form-control fromDate2" value="<?=@$fromDate; ?>" placeholder="From: dd-mm-yyyy" readonly = "readonly" autocomplete="off" />
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
					<input name="toDate" onchange="get_datefield_change(this.value)" id="toDate" type="text" value="<?=@$toDate; ?>" class="form-control toDate2" placeholder="To: dd-mm-yyyy" readonly = "readonly" autocomplete="off" />
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


<div class="col-lg-12 col-md-12 col-sm-8 col-xs-8 pull-right text-right" style = "padding-right:0px;padding-bottom:10px;padding-top:10px; margin-top:-4em">
	<a style="text-decoration:none;cursor:pointer;pull-right;" href="<?=site_url()?>Trustfinance/allLedgerTranscation" title="Refresh"><img style="width:24px; height:24px" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
	<?php if(isset($_SESSION['group_and_ledger_link'])) { ?>
		<a style="margin-left: 9px;pull-right;" href="<?=$_SESSION['group_and_ledger_link'] ?>" title="Back"><img style="width:24px; height:24px" src="<?=site_url();?>images/back_icon.svg"/></a>
	<?php } ?>
</div>

<div class="row form-group">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
				  <tr>
					<th width="10%"><center>Date</center></th>
					<th width="25%"><center>Particular</center></th>
					<th width="15%"><center>Voucher Type</center></th>
					<th width="15%"><center>Voucher Number</center></th>
					 <th width="10%"><center>Debit Amount</center></th> 
					 <th width="10%"><center>Credit Amount</center></th> 
				  </tr>
				</thead>
				<tbody>
					<?php foreach($dayBook as $result) { ?>
						<tr>
							<?php $voucherType = $result->T_VOUCHER_NO; ?>
							<td><center><?php echo $result->T_FLT_DATE; ?></center></td>
							<td><a style="text-decoration:none;cursor:pointer;color:#800000;" onClick="dayBookDetail('<?=$result->T_FGLH_ID; ?>','<?php echo str_replace("'","\'",$result->T_FGLH_NAME);?>','<?=$result->T_VOUCHER_NO; ?>','<?=$result->T_FLT_DATE; ?>')"><?php echo $result->FGLH_NAME; ?></a></td>
							<!-- <td><?php echo $result->FGLH_NAME; ?></td> -->
							<td><?php echo $result->VOUCHER_TYPE; ?></td>
							<td><?php echo $result->T_VOUCHER_NO; ?></td>
							 <td><center><?php echo $result->T_FLT_DR ?></center></td>
							<td><center><?php echo $result->T_FLT_CR; ?></center></td>

						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		 <div class="pull-right" style="padding-right:0px;">
			<?php if($bookCount != 0) { ?>
				 <label  style="font-size:18px;margin-top:-5em;">Total Records: <strong style="font-size:18px"><?php echo $bookCount; ?></strong></label> 
			<?php } else { ?>
				<label> </label>
			<?php } ?>
		</div> 
	 	<ul class="pagination pagination-sm" style="margin-top: 1px">
			<?=$pages; ?>
		</ul> 
	</div>
</div>

</div>

</div>

<input type="hidden" name="allDates" id="allDateField" value="<?=@$allDates; ?>">
<input type="hidden" name="radioOpt" id="radioOptField" value="<?=@$radioOpt; ?>">

<form id="dayBookDetailForm" action="" method="post">
	<input type="hidden" id="FGLH_ID" name="FGLH_ID" />
	<input type="hidden" id="FGLH_NAME" name="FGLH_NAME" />
	<input type="hidden" id="VOUCHER_NO" name="VOUCHER_NO" />
	<input type="hidden" id="FLT_DATE" name="FLT_DATE" />
	<input type="hidden" id="baseurl" name="baseurl" value="<?php echo $base_url ?>" />
</form>

<form method="post" id="report">
	<input type="hidden" id="outputType" name="outputType" />
	<input type="hidden" name="dateHidden" value="<?=@$date; ?>" id="dateHidden">
	<input type="hidden" name="fromDateHidden" id="fromDateHidden" value="<?=@$fromDate; ?>">
	<input type="hidden" name="toDateHidden" id="toDateHidden" value="<?=@$toDate; ?>">
	<input type="hidden" name="radioOptHidden" id="radioOptHidden" value="<?=$radioOpt; ?>">
	<input type="hidden" name="tdate" id="tdate" value="<?=@$date; ?>">
	<input type="hidden" name="Committechange" id="Committechange">
	<input type="hidden" name="vocherChange" id="vocherChange" >
	<input type="hidden" name="paymentChange" id="paymentChange" >

</form>

<script>
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
		url = "<?php echo site_url(); ?>Trustfinance/all_ledger_transcation_on_change_date";
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
		dateFormat: 'dd-mm-yy',
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50"
    });
     
	$('.todayDate').on('click', function() {
		$( ".todayDate" ).focus();
	})
	
	$(".fromDate2").datepicker({
		//maxDate: 0,
		dateFormat: 'dd-mm-yy',
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50"
	});
	
	$(".toDate2").datepicker({
		//maxDate: 0,
		dateFormat: 'dd-mm-yy',
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50"
	});
	
	$( ".toDate" ).datepicker({ 
		maxDate: 0,
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
		url = "<?php echo site_url(); ?>Trustfinance/allLedgerTranscation";
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
		url = "<?php echo site_url(); ?>Trustfinance/allLedgerTranscation";
		$("#tddate").attr("action",url)
		$("#tddate").submit();
	});
	
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

	function dayBookDetail(FGLH_ID,FGLH_NAME,VOUCHER_NO,FLT_DATE){
		$('#FGLH_ID').val(FGLH_ID);
		$('#FGLH_NAME').val(FGLH_NAME);
		$('#VOUCHER_NO').val(VOUCHER_NO);
		$('#FLT_DATE').val(FLT_DATE);
		$('#dayBookDetailForm').attr('action','<?=site_url()?>Trustfinance/dayBookDetail');
		$('#dayBookDetailForm').submit();
	}

	function onCommitteeChange(){
        $('#frmCommitteeChange').submit();     
    }
</script>