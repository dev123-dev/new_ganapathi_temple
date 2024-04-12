<?php error_reporting(0); ?>
<div class="container">
<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />

<div class="row form-group">							
	<div class="col-lg-3 col-md-10 col-sm-10 col-xs-8" style = "padding-right:0px;padding-top:10px;">
			<h3 style="margin-top:0px"><b>Finance Day Book For</b></h3>
	</div>
	<!-- <?php print_r($accountOp) ?>
	<?php print_r($accountClosing) ?> -->
	 <div class="col-lg-7 col-md-10 col-sm-10 col-xs-8">
        <form id="tddate" enctype="multipart/form-data" method="post"  accept-charset="utf-8">
        	<div class="col-lg-12 col-md-10 col-sm-10 col-xs-8">
	       		<div class="col-lg-4 col-md-10 col-sm-10 col-xs-8">
		            <select id="CommitteeId" name="CommitteeId" class="form-control" style="margin-left:-20px; margin-top:8px;width: 200px;" onChange="this.form.submit();">
		            	<option value="">All Committee</option>
		              		<?php   if(!empty($committee)) {
		                  foreach($committee as $row1) { 
		                    if($row1->T_COMP_ID == $compId) { ?> 
		                      <option value="<?php echo $row1->T_COMP_ID;?>" selected><?php echo $row1->T_COMP_NAME;?></option>
		                    <?php } else { ?> 
		                      <option value="<?php echo $row1->T_COMP_ID;?>"><?php echo $row1->T_COMP_NAME;?></option>
		                  <?php } } } ?>
		            </select>
		        </div>
		        <div class="col-lg-4 col-md-10 col-sm-10 col-xs-8">
					<select id="voucherType" name="voucherType" class="form-control"  onChange="this.form.submit();" style="width: 200px; margin-top: 8px;" autocomplete="off">
						<?php if($voucherType == ""){ ?>
					  		<option value="" selected>All Vouchers</option>
					  	<?php } else {?>
					  		<option value="">All Vouchers</option>
					  	<?php } ?>
					  	<?php if($voucherType == "R1"){ ?>
				       		<option value="R1" selected> Receipt </option>
				       	<?php } else {?>
					  		<option value="R1"> Receipt </option>
					  	<?php } ?>
				        <?php if($voucherType == "P1"){ ?>
				        	<option value="P1" selected> Payment </option>
				        <?php } else {?>
					  		<option value="P1"> Payment </option>
					  	<?php } ?>
					  	<?php if($voucherType == "J1"){ ?>
				        	<option value="J1" selected> Journal </option>
				        <?php } else {?>
					  		<option value="J1"> Journal </option>
					  	<?php } ?>
				        <?php if($voucherType == "C1"){ ?>
				        	<option value="C1" selected> Contra </option>
				        <?php } else {?>
					  		<option value="C1"> Contra </option>
					  	<?php } ?>
					</select>
				</div>
	            <div class="col-lg-4 col-md-10 col-sm-10 col-xs-8" style="display: none" id="selectPaymentOption">
					<select id="paymentType" name="paymentType" class="form-control"  onChange="this.form.submit();" style="width: 200px; margin-top: 8px;" autocomplete="off" >
						<?php if($paymentType == ""){ ?>
					  		<option value="" selected>All Payment</option>
					  	<?php } else {?>
					  		<option value="">All Payment</option>
					  	<?php } ?>
					  	<?php if($paymentType == "P_PC"){ ?>
				       		<option value="P_PC" selected> Petty Cash </option>
				       	<?php } else {?>
					  		<option value="P_PC"> Petty Cash </option>
					  	<?php } ?>
				        <?php if($paymentType == "P_B"){ ?>
				        	<option value="P_B" selected> Bank </option>
				        <?php } else {?>
					  		<option value="P_B"> Bank </option>
					  	<?php } ?>  
					</select>
				</div>
				 <input type="hidden" name="Committechange" id="Committechange">
           </div>              
      </div>
</div>

	<input type="hidden" name="radioOpt" id="radioOpt" value="<?=@$radioOpt; ?>">
	<input type="hidden" name="allDates" id="allDates" value="<?=@$allDates; ?>">
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
	<a onclick="GetSendField()" style="cursor:pointer;"><img style="width:24px; height:24px" title="Download Excel Report" src="<?=site_url();?>images/excel_icon.svg"/></a>&nbsp;&nbsp;
	<a onclick="generatePDF()"><img style="width:24px; height:24px;" title="Download PDF Report" src="<?=site_url();?>images/pdf_icon.svg"/></a>&nbsp;&nbsp;
	<a style="text-decoration:none;cursor:pointer;pull-right;" href="<?=site_url()?>Trustfinance/dayBook" title="Refresh"><img style="width:24px; height:24px" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
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
							<?php $voucherType = $result->VOUCHER_TYPE; ?>
							<td><center><?php echo $result->T_FLT_DATE; ?></center></td>
							<td>
								<?php if($result->T_TRANSACTION_STATUS == "Cancelled") {?>
									<a style="text-decoration:line-through;cursor:pointer;color:#800000;" onClick="dayBookDetail('<?=$result->T_FGLH_ID; ?>','<?php echo str_replace("'","\'",$result->T_FGLH_NAME);?>','<?=$result->T_VOUCHER_NO; ?>','<?=$result->T_FLT_DATE; ?>')"><?php echo $result->T_FGLH_NAME; ?></a></td>
								<?php } else { ?>
									<a style="text-decoration:none;cursor:pointer;color:#800000;" onClick="dayBookDetail('<?=$result->T_FGLH_ID; ?>','<?php echo str_replace("'","\'",$result->T_FGLH_NAME);?>','<?=$result->T_VOUCHER_NO; ?>','<?=$result->T_FLT_DATE; ?>')"><?php echo $result->T_FGLH_NAME; ?></a>
								<?php } ?>
							</td>
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


<div class="row form-group">
	<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12" >
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
				  <tr>
					<th width="65%"><center>Account</center></th>
					<th width="35%"><center>Opening</center></th> 
				  </tr>
				  </tr>
				</thead>
				<tbody>
					<?php foreach($accountOp as $result) { ?>
						<tr>
						<td><center><?php echo $result->T_FGLH_NAME ?></center></td>
						<td  width="35%" style="text-align: right"><?php echo $result->BALANCE; ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12" style="margin-left: -31px">
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
				  <tr>
					<th><center>Closing</center></th> 
				  </tr>
				  </tr>
				</thead>
				<tbody>
					<?php foreach($accountClosing as $result) { ?>
						<tr>
						<td style="text-align: right"><?php echo $result->BALANCE; ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
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
		document.getElementById('Committechange').value = $('#CommitteeId').val();
		document.getElementById('vocherChange').value = $('#voucherType').val();
		document.getElementById('paymentChange').value = $('#paymentType').val();
		url = "<?php echo site_url(); ?>Trustfinance/day_book_on_check_date";
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
		url = "<?php echo site_url(); ?>Trustfinance/dayBook";
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
		url = "<?php echo site_url(); ?>Trustfinance/dayBook";
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


	function generatePDF() {
		var start = $("#fromDate");
		var end = $("#toDate"); 
		var todayDate = $("#todayDate"); 
		var count = 0;
		
		if(document.getElementById("EveryRadio").checked) {
			if(!start.val()) {
				start.css('border-color','red');
				++count;
			} else 
				start.css('border-color','#ccc');
				
			if(!end.val()) {
				end.css('border-color','red');
				++count;
			} else 
				end.css('border-color','#ccc');
		} else {
			if(!todayDate.val()) {
				todayDate.css('border-color','red');
				++count;
			} else 
				todayDate.css('border-color','#ccc');
		}
		
		if(count != 0) {
			alert("Information","Please select required field");
			return;
		}
		
		let url = "<?php echo site_url(); ?>generatePDF/create_financeDayBookSession";
		$.post(url,{'radioOptHidden':$('#radioOptHidden').val(),'dateHidden':$('#dateHidden').val(),'toDateHidden':$('#toDateHidden').val(),'fromDateHidden':$('#fromDateHidden').val(),'CommitteeId':$('#CommitteeId').val(),'voucherType':$('#voucherType').val(),'paymentType':$('#paymentType').val()}, function(data) {

			if(data == 1) {
				url = "<?php echo site_url(); ?>generatePDF/create_trustdaybookreport";
				$("#report").attr("action",url);
				$('#outputType').val("pdf");
				$("#report").submit();		
			}
		});
	}

	function dayBookDetail(T_FGLH_ID,T_FGLH_NAME,T_VOUCHER_NO,T_FLT_DATE){
		$('#FGLH_ID').val(T_FGLH_ID);
		$('#FGLH_NAME').val(T_FGLH_NAME);
		$('#VOUCHER_NO').val(T_VOUCHER_NO);
		$('#FLT_DATE').val(T_FLT_DATE);
		$('#dayBookDetailForm').attr('action','<?=site_url()?>Trustfinance/dayBookDetail');
		$('#dayBookDetailForm').submit();
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
		
		url = "<?php echo site_url(); ?>Trustfinance/finance_day_book_excel";
		$("#tddate").attr("action",url)
		$("#tddate").submit();
	}

	function onCommitteeChange(){
        $('#frmCommitteeChange').submit();     
    }

	 $(document).ready(function(){
		let vocher = $('#voucherType').val();
		if(vocher == "P1"){
			document.getElementById('selectPaymentOption').style.display = 'block';   
		}else{
			document.getElementById('selectPaymentOption').style.display = 'none';   
		}

	});
</script>