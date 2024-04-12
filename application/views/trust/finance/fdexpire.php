<style type="text/css">
	table thead th {
		padding: 3px;
		position: sticky;
		top: 0;
		/* z-index: 1;*/
		/*width: 25vw;*/
		background-color: #800000;

	}
</style>

<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" >
	<form action="" id="dateChange" enctype="multipart/form-data" method="post" accept-charset="utf-8">
		<div class="row form-group">
			<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:0em">
				<span class="eventsFont2">Current FD Maturity Details </span>
			</div>
		</div>
		<div class="row form-group" style="margin-top:-0.5em">	
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6" style="padding-left:0px;">
				</div>
			</form>
			<div class="col-lg-8 col-md-6 col-sm-6 col-xs-12 pull-right text-right" style="padding-right:0px;">
				<a style="text-decoration:none;cursor:pointer;pull-right;" href="<?=site_url()?>Trustfinance/Fddetails" title="Refresh"><img style="width:24px; height:24px;margin-top:-0.3em;" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
			</div>
		</div>	
	</div>
</div>

<div class="container">	
	<div class="row form-group"  >
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive"   style="width:100%; height:225px; overflow-x: hidden;">
				<table class=" table table-bordered" >
					<thead>
						<tr>
							<th width="10%">FD Name </th>
							<th width="10%">FD StartDate</th>
							<th width="10%">FD EndDate</th>
							<th width="10%">Interest Rate</th>
							<th width="10%">Period (Months)</th>
							<th width="10%">Amount</th>
							<!-- <th width="7%">Op</th> -->
						</tr>
					</thead>
					<tbody>
						<?php if(isset($fdExpCurrentMonth)){ $count =0;?>
							<?php foreach($fdExpCurrentMonth as $result) {
								$d1=$result->T_FD_MATURITY_START_DATE;
								$d2=$result->T_FD_MATURITY_END_DATE;
								$time_stamp1 = strtotime($d1);
								$time_stamp2 = strtotime($d2);
								$year1 = date('Y', $time_stamp1);
								$year2 = date('Y', $time_stamp2);
								$month1 = date('m', $time_stamp1);
								$month2 = date('m', $time_stamp2); 
								$diff = (($year2 - $year1) * 12) + ($month2 - $month1);
								?> 
								<tr>
									<td width="10%"><a onclick="openFdDetailsWindow('<?=$result->T_FGLH_ID?>')" style="text-decoration:underline;color: #681212" >
										<?php echo $result->T_FGLH_NAME;?> </td>
									<td width="10%"><?php echo $result->T_FD_MATURITY_START_DATE;?></td>
									<td width="10%"><?php echo $result->T_FD_MATURITY_END_DATE;?></td>
									<td width="10%"><?php echo $result->T_FD_INTEREST_RATE;?></td>
									<td width="10%"><?php echo $diff;?></td>
									<td width="10%"><?php echo $result->T_FLT_DR;?></td>
									<!-- <td width="7%">
									<img class="" style=" height:24px" onclick="addInterestModal('<?=$result->T_FGLH_ID ?>','<?=$result->T_FGLH_NAME ;?>','<?=$result->FD_BANK_ID ?>','<?=$result->FD_BANK_NAME ?>','<?=$result->FD_NUMBER ?>')" src="<?=site_url();?>images/add_icon.svg"/>

										<?php echo ($result->T_FLT_DR)*(($diff)/12)*($result->T_FD_INTEREST_RATE)/100;?>
										<img class=" " style=" height:24px" onClick="editLedger('<?=$result->T_FGLH_ID; ?>', 
									                                                          '<?php echo str_replace("'","\'",$result->T_FGLH_NAME);?>',
																							  '<?=$result->T_FGLH_PARENT_ID; ?>',
																							  '<?=$result->T_IS_JOURNAL_STATUS; ?>',
																							  '<?=$result->T_IS_TERMINAL; ?>',
																							  '<?=$result->T_IS_FD_STATUS; ?>',
																							  '<?=$result->T_FD_MATURITY_START_DATE; ?>',
																							  '<?=$result->T_FD_MATURITY_END_DATE; ?>',
																							  '<?=$result->T_FD_INTEREST_RATE; ?>'
																							  )"
									                      src="<?=site_url();?>images/edit_icon.svg"/>
									  
									</td> -->
								</tr>
							<?php }
						} ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
		<!-- Modal -->
</div>
<!-- //////////////////////////////add interest modal start by adithya  ///////////-->
<div class="modal fade" id="addInterest" role="dialog" style=" font-size:large; font-weight:600;">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 style="font-weight:600;" class="modal-title text-center">Add Interest</h4>
			</div>
			<div class="modal-body">	
			<div style="clear:both;" class="form-group">
					<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<label for="inputLimit" >
							<span style="font-weight:600;">FD Number : </span> </label>
						<span style="padding:5px;font-weight:bold" id="FD_NUMBER"></span>
					</div>	
				</div>
			
				<div style="clear:both;" class="form-group">
					<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<label for="inputLimit" >
							<span style="font-weight:600;">Bank Name : </span> </label>
						<span style="padding:5px;font-weight:bold" id="FD_BANK_NAME"></span>
					</div>	
				</div>
				<div style="clear:both;" class="form-group">
					<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<label for="inputLimit" >
							<span style="font-weight:600;">FD Name : </span> </label>
						<span style="padding:5px;font-weight:bold" id="FGLH_NAME"></span>
					</div>	
				</div>
				
				<div style="clear:both;" class="form-group">
					<div class="form-group col-lg-5 col-md-5 col-sm-4 col-xs-5">
						<label for="seva"><span style="font-weight:600;"> FD Credit Date  :  </span><span style="color:#800000;">*</span></label>
					</div>
					<div class='form-group col-lg-4 col-md-4 col-sm-4 col-xs-5' style="margin-left:-50px">
						<div class="input-group input-group-sm " >
							<input name="chequedate" id="chequedate" style="z-index:4444" type="text" value="" class="form-control chequedate" placeholder="dd-mm-yyyy" />
							<div class="input-group-btn">
							  <button class="btn btn-default todayDate" type="button">
								<i class="glyphicon glyphicon-calendar" ></i>
							  </button>
							</div>
						</div>
				    </div>
				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
					<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
					<label  style="margin-left:-10px">FD Interest  : <span style="color:#800000;">*</span> </label>
					</div>

					<div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3 " style="margin-left:-10px">
						  <input type="text" class="form-control form_contct2" id="interest"  placeholder="" name="interest">
					</div>
				</div>
				<!-- HIDDEN -->
				<div class="modal-footer">
					<button type="button" class="btn btn-default" onclick="saveInterest()" >SAVE</button>
				</div>
			</div>
		</div>
	</div>
</div>

<form id="submitForm" >
	
	<input type="hidden" id="FD_BANK_ID" name="FD_BANK_ID" value="">
	<input type="hidden" id="chequedate" name="FD_INTEREST_DATE" value="">
	<input type="hidden" id="FGLH_ID" name="FGLH_ID" value="">

</form>
		<!-- ///////////////////////////// add interest modal end by adithya  -->

<div class="container">
	<div class="row form-group">
		<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:0em">
			<span class="eventsFont2">Total Expaired FD Details </span>
		</div>
	</div>

	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" >
				<table class="table table-bordered">
					<thead>
						<tr>
							<th width="30%">FD Name </th>
							<th width="30%">FD StartDate</th>
							<th width="30%">FD EndDate</th>
							<th width="30%">Interest Rate</th>
							<th width="30%">Period (Months)</th>
							<th width="30%">Amount</th>
							<th width="30%">Interest</th>

						</tr>
					</thead>
					<tbody>
						<?php if(isset($fdAllExp)){ $count =0;?>
							<?php foreach($fdAllExp as $result) { 
								$d1=$result->T_FD_MATURITY_START_DATE;
								$d2=$result->T_FD_MATURITY_END_DATE;
								$time_stamp1 = strtotime($d1);
								$time_stamp2 = strtotime($d2);
								$year1 = date('Y', $time_stamp1);
								$year2 = date('Y', $time_stamp2);
								$month1 = date('m', $time_stamp1);
								$month2 = date('m', $time_stamp2); 
								$diff = (($year2 - $year1) * 12) + ($month2 - $month1);
								?>
								<tr>
									<td width="10%"><?php echo $result->T_FGLH_NAME;?> </td>
									<td width="20%"><?php echo $result->T_FD_MATURITY_START_DATE;?></td>
									<td width="20%"><?php echo $result->T_FD_MATURITY_END_DATE;?></td>
									<td width="20%"><?php echo $result->T_FD_INTEREST_RATE;?></td>
									<td width="20%"><?php echo $diff;?></td>
									<td width="20%"><?php echo $result->T_FLT_DR;?></td>
									<td width="20%"><?php echo ($result->T_FLT_DR)*(($diff)/12)*($result->T_FD_INTEREST_RATE)/100;?></td>	
								</tr>
							<?php }
						} ?>
					</tbody>
				</table>
				<ul class="pagination pagination-sm">
					<?=$pages;?>
				</ul>
			</div>
		</div>
	</div>
		<!-- Modal -->	
</div>

<!-- fd details modal start///////////////////////////////////////////// -->
<div class="modal fade" id="ShowDetails" role="dialog" style=" font-size:large; font-weight:600;">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
		<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 style="font-weight:600;" class="modal-title text-center">FD Details</h4>
		</div>

		<!-- <div class="modal-body">	
			<div style="clear:both;" class="form-group">
					<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<label for="inputLimit" >
							<span style="font-weight:600;">FD Number : </span> </label>
						<span style="padding:5px;font-weight:bold" id="FD_NUMBER"></span>
					</div>	
				</div> -->
			<!-- ///////////////////////////// fd details table start ////////////////////////////-->
	<!-- <div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" >
				<table class="table table-bordered">
					<thead>
						<tr>
							<th width="30%">FD Name </th>	
							<th width="30%">FD Renewal Date</th>
							<th width="30%">Interest Rate</th>
							<th width="30%">Amount</th>
							

						</tr>
					</thead>
					
				</table>
				
			</div>
		</div>
	</div> -->
			<!-- ///////////////////////////// fd details table end -->

			
				<!-- HIDDEN -->
				
			</div>
		</div>
	</div>
</div>
<form id="editLedgerForm" method="post" action="<?php echo site_url();?>trustfinance/editLedger">
	<input type="hidden" value="" name="LEDGER_ID" id="LEDGER_ID"/>
	<input type="hidden" value="" name="LEDGER_NAME" id="LEDGER_NAME"/>
	<input type="hidden" value="" name="LEDGER_PARENT_ID" id="LEDGER_PARENT_ID"/>
	<input type="hidden" value="" name="IS_JOURNAL_STATUS" id="IS_JOURNAL_STATUS"/>
	<input type="hidden" value="" name="IS_FD_STATUS" id="IS_FD_STATUS"/>
	<input type="hidden" value="" name="FD_MATURITY_START_DATE" id="FD_MATURITY_START_DATE"/>
	<input type="hidden" value="" name="FD_MATURITY_END_DATE" id="FD_MATURITY_END_DATE"/>
		<input type="hidden" value="" name="FD_INTEREST_RATE" id="FD_INTEREST_RATE"/>

	<input type="hidden" value="" name="IS_TERMINAL" id="IS_TERMINAL"/>
</form>

<script type="text/javascript">	
	$('#price').keyup(function (e) {
		var $th = $(this);
		if (e.keyCode != 46 && e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 38 && e.keyCode != 39 && e.keyCode != 40) {
			$th.val($th.val().replace(/[^0-9]/g, function (str) { return ''; }));
		} return;
	});

	var currentTime = new Date()
	var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
	var maxDate =  new Date(currentTime.getFullYear(), currentTime.getMonth() +12, +0); // one day before next month
	$( ".todayDate2" ).datepicker({ 
		//minDate: minDate;
		//maxDate: maxDate,
		dateFormat: 'dd-mm-yy',
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50"
	});
	$('.todayDate').on('click', function() {
		$( ".todayDate2" ).focus();
	});
	$('.todayDate').on('click',function() {
		$( ".chequedate" ).focus();
	});
	$('#chequedate').val("");
	$('#chequedate').css('border-color','black');
	$( ".chequedate" ).datepicker({
		dateFormat: 'dd-mm-yy',
		onSelect: function (selectedDate) {
			$('#chequedate2').val(selectedDate);
			$('#chequedate').css('border-color','black');

		} 
	});

	function GetSevaOnDate(receiptDate,url) {
		document.getElementById('date').value = receiptDate;
		$("#dateChange").attr("action",url)
		$("#dateChange").submit(); 
	}

	function addInterestModal(FGLH_ID,FGLH_NAME,FD_BANK_ID,FD_BANK_NAME,FD_NUMBER){
		$('#FGLH_NAME').val(FGLH_NAME);
		$('#FGLH_NAME').text(FGLH_NAME);
		$('#FD_BANK_NAME').val(FD_BANK_NAME);
		$('#FD_BANK_NAME').text(FD_BANK_NAME);
		$('#FD_NUMBER').val(FD_NUMBER);
		$('#FD_NUMBER').text(FD_NUMBER);
		$('#FD_BANK_ID').val(FD_BANK_ID);
		$('#FGLH_ID').val(FGLH_ID);
		$('#addInterest').modal({backdrop: 'static', keyboard: false});
		$('#addInterest').modal({backdrop: 'static', keyboard: false});
	}

	function saveInterest(){
		let FGLH_NAME = $('#FGLH_NAME').val();
		let fd_bank_name = $('#FD_BANK_NAME').val();
		let fd_number = $('#FD_NUMBER').val();
		let fd_bank_id = $('#FD_BANK_ID').val();
		let fd_interest_date = $('#chequedate').val();
        let fd_interest = $('#interest').val();
		let fglh_id = $('#FGLH_ID').val();
		$('#FGLH_NAME').val(FGLH_NAME);
		$('#FD_BANK_NAME').val(fd_bank_name);
		$('#FD_NUMBER').val(fd_number);
		$('#FD_BANK_ID').val(fd_bank_id);
		$('#chequedate').val(fd_interest_date);

		$.post("<?=site_url()?>Trustfinance/addInterest",{'bank':FGLH_NAME,'fd_bank_name':fd_bank_name,'fd_number':fd_number,'fd_bank_id':fd_bank_id,'fd_interest_date':fd_interest_date,'fd_interest':fd_interest,'fglh_id':fglh_id}, 
		 function(e) {
			
						$.confirm({
							title: "Information",
							content: "Successfully Updated",
							type: 'red',
							typeAnimated: true,
							closeIcon:close,
							buttons: {
								tryAgain: {
									text: "Continue",
									btnClass: 'btn-red',
									action: function(){
										location.href = "<?=$_SESSION['actual_link']; ?>"
									}
								},
							}
						});
					});
				}
				function openFdDetailsWindow(FGLH_ID){
	// added by adithya
	$.ajax({ 
		type: "POST",     //using this type i access the data in the controller 
         url: "<?php echo base_url();?>Trustfinance/getInterestDetails",
		data :{FGLH_ID:FGLH_ID},         //this is the id which will be used to fetch the data from fd_details page
		success :function(response){     //here iam sending the response in format only so i just need to call the modal and fill the content inside the modal
			$('.modal-content').html(response);
			// console.log(response)
                    $('#ShowDetails').modal('show');
		}
	}) 	
}
function editLedger(LEDGER_ID,LEDGER_NAME,LEDGER_PARENT_ID,IS_JOURNAL_STATUS,IS_TERMINAL,IS_FD_STATUS,FD_MATURITY_START_DATE,
FD_MATURITY_END_DATE,FD_INTEREST_RATE){
		$('#LEDGER_ID').val(LEDGER_ID);
		$('#LEDGER_NAME').val(LEDGER_NAME);
		$('#LEDGER_PARENT_ID').val(LEDGER_PARENT_ID);
		$('#IS_JOURNAL_STATUS').val(IS_JOURNAL_STATUS);
		$('#IS_TERMINAL').val(IS_TERMINAL);
		$('#IS_FD_STATUS').val(IS_FD_STATUS);
		$('#FD_MATURITY_START_DATE').val(FD_MATURITY_START_DATE);
		$('#FD_MATURITY_END_DATE').val(FD_MATURITY_END_DATE);
		$('#FD_INTEREST_RATE').val(FD_INTEREST_RATE);
		

		$('#editLedgerForm').submit();
	}
	

</script>