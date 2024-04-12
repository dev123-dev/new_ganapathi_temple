<section id="section-register" class="bg_register">
    <div class="container-fluid sub_reg" style="min-height:100%;">  	
		<!-- START Content -->
		<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
		<div class="container reg_top adminside">
			<!-- START Row -->
			<div class="row-fluid">
				<!-- START Datatable 2 -->
				<div class="span12 widget lime">
					<section class="body">
						<div class="row form-group"> 
							<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
								<span class="eventsFont2">Import Setting</span>
							</div>
							<form id="dateChange" enctype="multipart/form-data" method="post" accept-charset="utf-8">
								<div class="col-lg-2 col-md-2 col-sm-2 col-xs-8">
									<div class="input-group input-group-sm form-group"> 
										<input id="todayDate" name="todayDate" type="text" value="<?php echo $date; ?>" class="form-control todayDate2" placeholder="dd-mm-yyyy" onchange="GetDataOnDate(this.value,'<?php echo site_url()?>admin_settings/Admin_setting/get_data_on_filter')">
										<div class="input-group-btn">
											<button class="btn btn-default todayDate" type="button">
												<i class="glyphicon glyphicon-calendar"></i>
											</button>
										</div>
										<!--HIDDEN FIELDS -->
										<input type="hidden" name="date" id="date">
									</div>
								</div>
								<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
									<select id="users" name="users" class="form-control" onchange="GetDataOnUser(this.value,'<?php echo site_url()?>admin_settings/Admin_setting/get_data_on_filter')">
										<option selected value="All Users">All Users</option>
										<?php foreach($usersCombo as $result) { ?>
											<?php if(isset($user)) { ?>
												<?php if($user == $result->ET_RECEIPT_ISSUED_BY_ID) { ?>
													<option selected value="<?php echo $result->ET_RECEIPT_ISSUED_BY_ID; ?>"><?php echo $result->ET_RECEIPT_ISSUED_BY; ?></option>
												<?php } else { ?>
													<option value="<?php echo $result->ET_RECEIPT_ISSUED_BY_ID; ?>"><?php echo $result->ET_RECEIPT_ISSUED_BY; ?></option>
												<?php } ?>
											<?php } else { ?>
												<option value="<?php echo $result->ET_RECEIPT_ISSUED_BY_ID; ?>"><?php echo $result->ET_RECEIPT_ISSUED_BY; ?></option>
											<?php } ?>
										<?php } ?>
									</select>
									 <!--HIDDEN FIELDS -->
									 <input type="hidden" name="users_id" id="users_id">
								</div>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
								  <select id="modeOfPayment" name="modeOfPayment" class="form-control" onchange="GetDataOnFilter(this.value,'<?php echo site_url()?>admin_settings/Admin_setting/get_data_on_filter')">
									<?php if(isset($payMethod)) {?>
										<?php if($payMethod == "All") { ?>
											<option selected value="All">All = &#8377;<?php if($All->PRICE != "") { echo $All->PRICE; } else { echo "0";} ?></option>
										<?php } else { ?>
											<option value="All">All = &#8377;<?php if($All->PRICE != "") { echo $All->PRICE; } else { echo "0";} ?></option>
										<?php } ?>
										<?php if($payMethod == "Cash") { ?>
											<option selected value="Cash">Cash = &#8377;<?php if($Cash->PRICE != "") { echo $Cash->PRICE; } else { echo "0"; } ?></option>
										<?php } else { ?>
											<option value="Cash">Cash = &#8377;<?php if($Cash->PRICE != "") { echo $Cash->PRICE; } else { echo "0"; } ?></option>
										<?php } ?>
										<?php if($payMethod == "Cheque") { ?>
											<option selected value="Cheque">Cheque = &#8377;<?php if($Cheque->PRICE != "") { echo $Cheque->PRICE; } else { echo "0"; } ?></option>
										<?php } else { ?>
											<option value="Cheque">Cheque = &#8377;<?php if($Cheque->PRICE != "") { echo $Cheque->PRICE; } else { echo "0"; } ?></option>
										<?php } ?>
									<?php } else { ?>
											<option value="All">All = &#8377;<?php if($All->PRICE != "") { echo $All->PRICE; } else { echo "0";} ?></option>
											<option value="Cash">Cash = &#8377;<?php if($Cash->PRICE != "") { echo $Cash->PRICE; } else { echo "0"; } ?></option>
											<option value="Cheque">Cheque = &#8377;<?php if($Cheque->PRICE != "") { echo $Cheque->PRICE; } else { echo "0"; } ?></option>
									<?php } ?>
								  </select>
								  <!--HIDDEN FIELDS -->
								  <input type="hidden" name="paymentMethod" id="paymentMethod">
								</div>
							</form>
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4 no-pad">
								<a style="width:24px; height:24px;margin-left:.5em;" class="pull-right img-responsive" href="<?=site_url()?>admin_settings/Admin_setting/import_setting" title="Reset"><img src="<?=site_url();?>images/refresh.svg"/></a>
								<a style="width:24px; height:24px;" class="pull-right img-responsive" title="Import"><img onclick="show_import()" src="<?=site_url();?>images/import.svg"/></a>
							</div>
						</div>
						<div class="body-inner no-padding table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th style="width:15%"><strong>Receipt No.</strong></th>
										<th style="width:10%"><strong>Date</strong></th>
										<th style="width:15%"><strong>Name</strong></th>
										<th style="width:20%"><strong>Event Name</strong></th>
										<th style="width:10%"><strong>Payment Mode</strong></th>
										<th style="width:10%"><strong>Amount</strong></th>
										<th style="width:10%"><strong>Entered By</strong></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($app_data as $result) { ?>
										<tr class="row1">
											<?php if($result->ET_RECEIPT_NO == "") { ?>
												<td><a style="color:#800000" onclick="alert('Cancelled Notes','<?=$result->CANCEL_NOTES; ?>')"><?php echo "Cancelled Receipt" ?></a></td>
											<?php } else { ?>
												<td><?php echo $result->ET_RECEIPT_NO; ?></td>
											<?php } ?>
											<td><?php echo $result->ET_RECEIPT_DATE; ?></td>
											<td><?php echo $result->ET_RECEIPT_NAME; ?></td>
											<td><?php echo $result->RECEIPT_ET_NAME; ?></td>
											<td><?php echo $result->ET_RECEIPT_PAYMENT_METHOD; ?></td>
											<td><?php echo $result->ET_RECEIPT_PRICE; ?></td> 
											<td><?php echo $result->ET_RECEIPT_ISSUED_BY; ?></td> 
										</tr>
									<?php  } ?>
								</tbody>
							</table>
							<ul class="pagination pagination-sm">
								<?=$pages; ?>
							</ul>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Import Modal2 -->
<div id="myModalImport" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content" style="padding-bottom:1em;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Import Details</h4>
			</div>
			<div class="modal-body" id="importdet" style="overflow-y: auto;max-height: 330px;">
				<?php echo form_open_multipart(site_url().'admin_settings/Admin_setting/file_import_excel_save', array('onsubmit'=> 'return save_import()')); ?>
					<div class="form-group col-md-8 col-lg-8 col-sm-12 col-xs-12">
						<label class="control-label color_black">Events <span style="color:#800000;">*</span></label>
						<div class="controls">
							<select class="form-control register_form" id="events_active" name="events_active">	
								<?php foreach($events as $result) { ?>						
									<option value="<?php echo $result->ET_ID."|".$result->ET_NAME; ?>"><?php echo $result->ET_NAME; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group col-md-4 col-lg-4 col-sm-12 col-xs-12">
						<label class="control-label color_black">Users <span style="color:#800000;">*</span></label>
						<div class="controls">
							<select class="form-control register_form" id="users_active" name="users_active">		
								<?php foreach($users as $result) { ?>						
									<option value="<?php echo $result->USER_ID."|".$result->USER_FULL_NAME; ?>"><?php echo $result->USER_FULL_NAME; ?></option>
								<?php } ?>							
							</select>
						</div>
					</div>
					<div class="form-group col-md-12 col-lg-12 col-sm-12 col-xs-12">
						<?php
							$data_form=array('name'=>'userfile');
							echo form_upload($data_form);
						?>
						<br/><button type="submit" class="btn sub_form btn_continue">Upload Attachment</button>
						<!--HIDDEN FIELD -->
						<input name="userId" id="userId" type="hidden">
						<input name="userName" id="userName" type="hidden">
						<input name="eventId" id="eventId" type="hidden">
						<input name="eventName" id="eventName" type="hidden">
					</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div> 
<script>
	//DATEFIELD
	var currentTime = new Date()
	var minDate = "-1Y"; //one day next before month
	var maxDate =  0; // one day before next month
	$( ".todayDate2" ).datepicker({ 
		minDate: minDate, 
		maxDate: maxDate,
		dateFormat: 'dd-mm-yy'
	});
			
	$('.todayDate').on('click', function() {
		$( ".todayDate2" ).focus();
	})

	//DATEFIELD AND FILTER CHANGE
	function GetDataOnDate(date,url) {
		document.getElementById('date').value = date;
		document.getElementById('paymentMethod').value = $('#modeOfPayment').val();
		document.getElementById('users_id').value = $('#users').val();
		$("#dateChange").attr("action",url)
		$("#dateChange").submit();
	}
	
	//DATEFIELD AND FILTER CHANGE
	function GetDataOnUser(users,url) {
		document.getElementById('date').value = $('#todayDate').val();
		document.getElementById('users_id').value = users;
		document.getElementById('paymentMethod').value = $('#modeOfPayment').val();
		$("#dateChange").attr("action",url)
		$("#dateChange").submit();
	}
	
	//DATEFIELD AND FILTER CHANGE
	function GetDataOnFilter(payMode,url) {
		document.getElementById('date').value = $('#todayDate').val();
		document.getElementById('users_id').value = $('#users').val();
		document.getElementById('paymentMethod').value = payMode;
		$("#dateChange").attr("action",url)
		$("#dateChange").submit();
	}
	
	//SHOW MODAL
	function show_import() {
		$('#myModalImport').modal('show');  
	}

	//IMPORT DETAILS
	function save_import() {
		var users = ($('#users_active').val()).split("|");
		var events = ($('#events_active').val()).split("|");
		
		document.getElementById('userId').value = users[0];
		document.getElementById('userName').value = users[1];
		document.getElementById('eventId').value = events[0];
		document.getElementById('eventName').value = events[1];
		return true;
	}
</script>