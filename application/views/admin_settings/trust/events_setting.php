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
							<div class="col-md-2 col-lg-2 col-sm-2 col-xs-8 no-pad">
								<h3>Events</h3>
							</div>
							<div class="col-md-10 col-lg-10 col-sm-10 col-xs-4 text-right">
								<?php if(isset($_SESSION['Add'])) { ?>
									<a id="addButton" style="border:none; outline:0;" href="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/add_event" title="Add New Event"><img style="border:none; outline: 0;margin-top:1.4em;margin-bottom:.5em;" src="<?php echo base_url(); ?>images/add_icon.svg"></a>
								<?php } ?>
							</div>
						</div>
						<div class="body-inner no-padding table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th style="width:60%;"><strong>Event Name</strong></th>
										<th style="width:10%;"><strong>Event From</strong></th>
										<th style="width:10%;"><strong>Event To</strong></th>
										<th style="width:12%;"><strong>Status</strong></th>
										<?php if((isset($_SESSION['Add']) || isset($_SESSION['Edit']))) { ?>
											<th><strong>Operations</strong></th>
										<?php } ?>
									</tr>
								</thead>
								<tbody>
									<?php foreach($admin_settings_events as $result) { ?>
										<tr class="row1">
											<td><a style="color:#800000;" href="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/events_seva_details/<?php echo $result->TET_ID; ?>"><?php echo $result->TET_NAME; ?></a></td>
											<td><?php echo $result->TET_FROM_DATE_TIME; ?></td>
											<td><?php echo $result->TET_TO_DATE_TIME; ?></td>
											<?php if($result->TET_ACTIVE == "1") { ?>
												<td><?php echo "Active"; ?></td>
											<?php } else { ?>
												<td><?php echo "Deactive"; ?></td> 
											<?php } ?>
											
											<?php if(isset($_SESSION['Add']) && isset($_SESSION['Edit'])) { ?>	
												<td class="text-center" width="30%">
													<a style="border:none; outline: 0;" href="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/edit_event/<?php echo $result->TET_ID; ?>" title="Edit Event Details" ><img style="border:none; outline: 0;" src="<?php echo	base_url(); ?>images/edit_icon.svg"></a>&nbsp;&nbsp;
													<a style="border:none; outline:0;" href="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/add_event_seva/<?php echo $result->TET_ID; ?>" title="Add Seva for <?php echo $result->TET_NAME; ?>"><img style="border:none; outline: 0;" src="<?php echo base_url(); ?>images/add_icon.svg"></a>
												</td>
											<?php } else if(isset($_SESSION['Add'])) { ?>
												<td class="text-center" width="30%">
													<a style="border:none; outline:0;" href="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/add_event_seva/<?php echo $result->TET_ID; ?>" title="Add Seva for <?php echo $result->TET_NAME; ?>"><img style="border:none; outline: 0;" src="<?php echo base_url(); ?>images/add_icon.svg"></a>
												</td>
											<?php } else if(isset($_SESSION['Edit'])) { ?>
												<td class="text-center" width="30%">
													<a style="border:none; outline: 0;" href="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/edit_event/<?php echo $result->TET_ID; ?>" title="Edit Event Details" ><img style="border:none; outline: 0;" src="<?php echo	base_url(); ?>images/edit_icon.svg"></a>
												</td>
											<?php } ?>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
						<div class="row form-group"> 
							<div class="col-md-6 col-lg-6 col-sm-8 col-xs-10 no-pad">
							<?php if($event != 0) { ?>
								<h3>Seva - <?php echo $event[0]->TET_NAME; ?></h3>
							<?php } else { ?>
								<h3>Seva</h3>
							<?php } ?>
							</div>
							<div class="col-md-6 col-lg-6 col-sm-4 col-xs-2 text-right">
								<?php if(isset($_SESSION['Add'])) { ?>
									<?php if($event != 0) { ?>
										<a style="border:none; outline:0;" href="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/add_event_seva/<?php echo $event[0]->TET_ID; ?>" title="Add Seva for <?php echo $event[0]->TET_NAME; ?>"><img style="border:none; outline: 0;margin-top:1.4em;margin-bottom:.5em;" src="<?php echo base_url(); ?>images/add_icon.svg"></a>
									<?php } ?>
								<?php } ?>
							</div>
						</div>
						<div class="body-inner no-padding  table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th style="width:60%;"><strong>Event Seva Name</strong></th>
										<th style="width:10%;"><strong><center>Price (Rs.)</center></strong></th>
										<th style="width:10%;"><strong>Status</strong></th>
										<?php if(isset($_SESSION['Add'])) { ?>
											<th style="width:5%;"><strong>Limit/Stock</strong></th>
										<?php } ?>
										<?php if((isset($_SESSION['Add']) || isset($_SESSION['Edit']))) { ?>
											<th style="width:10%;"><strong><center>Operations</center></strong></th>
										<?php } ?>
									</tr>
								</thead>
								<tbody>
									<?php foreach($admin_settings_event_seva as $result) { ?>
										<tr class="row1">
											<td><a style="color:#800000;" href="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/edit_event_seva/<?php echo $result->TET_SEVA_ID; ?>"><?php echo $result->TET_SEVA_NAME; ?></a></td>
											<td><center><?php echo $result->TET_SEVA_PRICE; ?></center></td>
											<?php if($result->TET_SEVA_ACTIVE == "1") { ?>
												<td><?php echo "Active"; ?></td>
											<?php } else { ?>
												<td><?php echo "Deactive"; ?></td> 
											<?php } ?>
											<?php if(isset($_SESSION['Add'])) { ?>
												<td><center>
													<?php if($result->TET_SEVA_QUANTITY_CHECKER	== "1") { ?>
														<?php if($result->IS_SEVA == 1) { ?>
															<a style="border:none; outline:0;" href="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/get_limit_details/<?php echo $result->TET_SEVA_ID; ?>" title="Add Limit for <?php echo $result->TET_SEVA_NAME; ?>"><img style="border:none; outline: 0;" src="<?php echo base_url(); ?>images/add_icon.svg"></a></center>	
														<?php } else { ?>
															<a style="border:none; outline:0;" href="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/get_limit_details/<?php echo $result->TET_SEVA_ID; ?>" title="Add Stock for <?php echo $result->TET_SEVA_NAME; ?>"><img style="border:none; outline: 0;" src="<?php echo base_url(); ?>images/add_icon.svg"></a></center>
														<?php } ?>
														<!--<a style="border:none; outline:0;" href="<?php //echo site_url(); ?>admin_settings/Admin_setting/get_limit_details/<?php //echo $result->ET_SEVA_ID; ?>" title="Add Seva"><img style="border:none; outline: 0;" src="<?php echo base_url(); ?>images/add_icon.svg"></a></center>-->
													<?php } else { ?>
														<?php if($result->IS_SEVA == 1) { ?>
															<a style="border:none; outline:0;cursor:pointer;" onclick="alert('Information','Please check the \'Quantity Checker\' checkbox for this seva to add limit.','OK')" title="Add Limit for <?php echo $result->TET_SEVA_NAME; ?>"><img style="border:none; outline: 0;" src="<?php echo base_url(); ?>images/add_icon.svg"></a></center>
														<?php } else { ?>
															<a style="border:none; outline:0;cursor:pointer;" onclick="alert('Information','Please check the \'Quantity Checker\' checkbox for this seva to add stock.','OK')" title="Add Stock for <?php echo $result->TET_SEVA_NAME; ?>"><img style="border:none; outline: 0;" src="<?php echo base_url(); ?>images/add_icon.svg"></a></center>
														<?php } ?>
													<?php } ?>
												</td>
											<?php } ?>
										
											<?php if(isset($_SESSION['Active_Deactive']) && isset($_SESSION['Edit'])) { ?>
													<td class="text-center">
														<a style="border:none; outline: 0;" href="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/edit_event_seva/<?php echo $result->TET_SEVA_ID; ?>" title="Edit Seva Details" ><img style="border:none; outline: 0;" src="<?php echo base_url(); ?>images/edit_icon.svg"></a>&nbsp;&nbsp;
														<?php if($result->TET_SEVA_ACTIVE == "1") { ?>
															<a style="border:none; outline: 0;"  title="Deactivate <?php echo $result->TET_SEVA_NAME; ?>"><img style="cursor:pointer;border:none; outline: 0;" src="<?php echo base_url(); ?>images/delete.svg" onclick="GetStatusChange('<?php echo $result->TET_SEVA_ACTIVE; ?>','<?php echo $result->TET_SEVA_NAME; ?>','<?php echo $result->TET_NAME; ?>','<?php echo $result->TET_SEVA_ID; ?>');"></a>
														<?php } else { ?>
															<a style="border:none; outline: 0;"  title="Activate <?php echo $result->TET_SEVA_NAME; ?>"><img style="cursor:pointer;border:none; outline: 0;" src="<?php echo base_url(); ?>images/delete.svg" onclick="GetStatusChange('<?php echo $result->TET_SEVA_ACTIVE; ?>','<?php echo $result->TET_SEVA_NAME; ?>','<?php echo $result->TET_NAME; ?>','<?php echo $result->TET_SEVA_ID; ?>');"></a>
														<?php } ?>
														<!--<a style="border:none; outline: 0;"  title="Deactive <?php //echo $result->ET_SEVA_NAME; ?>"><img style="cursor:pointer;border:none; outline: 0;" src="<?php //echo base_url(); ?>images/delete.svg" onclick="GetStatusChange('<?php //echo $result->ET_SEVA_ACTIVE; ?>','<?php //echo $result->ET_SEVA_NAME; ?>','<?php //echo $result->ET_NAME; ?>','<?php //echo $result->ET_SEVA_ID; ?>');"></a>-->
													</td>
											<?php } else if(isset($_SESSION['Active_Deactive'])) { ?>
													<td class="text-center">
														<?php if($result->TET_SEVA_ACTIVE == "1") { ?>
															<a style="border:none; outline: 0;"  title="Deactivate <?php echo $result->TET_SEVA_NAME; ?>"><img style="cursor:pointer;border:none; outline: 0;" src="<?php echo base_url(); ?>images/delete.svg" onclick="GetStatusChange('<?php echo $result->TET_SEVA_ACTIVE; ?>','<?php echo $result->TET_SEVA_NAME; ?>','<?php echo $result->TET_NAME; ?>','<?php echo $result->TET_SEVA_ID; ?>');"></a>
														<?php } else { ?>
															<a style="border:none; outline: 0;"  title="Activate <?php echo $result->TET_SEVA_NAME; ?>"><img style="cursor:pointer;border:none; outline: 0;" src="<?php echo base_url(); ?>images/delete.svg" onclick="GetStatusChange('<?php echo $result->TET_SEVA_ACTIVE; ?>','<?php echo $result->TET_SEVA_NAME; ?>','<?php echo $result->TET_NAME; ?>','<?php echo $result->TET_SEVA_ID; ?>');"></a>
														<?php } ?>
													</td>
											<?php } else if(isset($_SESSION['Edit'])) { ?>
													<td class="text-center">
														<a style="border:none; outline: 0;" href="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/edit_event_seva/<?php echo $result->TET_SEVA_ID; ?>" title="Edit Seva Details" ><img style="border:none; outline: 0;" src="<?php echo base_url(); ?>images/edit_icon.svg"></a>&nbsp;&nbsp;
													</td>
											<?php } ?>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
						
						<div class="row form-group"> 
							<div class="col-md-6 col-lg-6 col-sm-8 col-xs-12 no-pad">
								<h3> Seva Limit/Stock</h3>
							</div>
						</div>
						<div class="body-inner no-padding table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th style="width:70%;"><strong>Seva Name</strong></th>
										<th style="width:10%;"><strong>Date</strong></th>
										<th style="width:5%;"><strong>Limit/Stock</strong></th>
										<?php if(isset($_SESSION['Edit'])) { ?>
											<th style="width:5%;"><strong>Operation</strong></th>
										<?php } ?>
									</tr>
								</thead>
								<tbody>
									<?php foreach($admin_settings_event_seva_limit as $result) { ?>
										<tr class="row1">
											<td><?php echo $result->TET_SEVA_NAME; ?></td>
											<td><?php echo $result->TET_SEVA_DATE; ?></td>
											<td><center><?php echo $result->TET_SEVA_LIMIT; ?></center></td>
											<?php if(isset($_SESSION['Edit'])) { ?>
												<?php if($result->IS_SEVA != 0) { ?>
													<td><center><a style="border:none; outline: 0;" onclick="GetAddToHiddenLimit('<?php echo $result->TET_SEVA_DATE ?>','<?php echo $result->TET_SEVA_LIMIT; ?>','<?php echo $result->TET_SL_ID; ?>','<?php echo $result->TET_SEVA_COUNTER; ?>','<?php echo $result->TET_SEVA_ID; ?>')" role="button" data-toggle="modal" title="Edit limit for <?php echo $result->TET_SEVA_NAME; ?>"><img style="border:none; outline: 0;" src="<?php echo base_url(); ?>images/edit_icon.svg"></a></center></td>
												<?php } else { ?>
													<td><!--<center><a style="border:none; outline: 0;" onclick="GetAddToHiddenStock('<?php echo $result->TET_SEVA_DATE ?>','<?php echo $result->TET_SEVA_LIMIT; ?>','<?php echo $result->TET_SL_ID; ?>')" role="button" data-toggle="modal" title="Edit"><img style="border:none; outline: 0;" src="<?php echo base_url(); ?>images/edit_icon.svg"></a></center>--></td>
												<?php } ?>
											<?php } ?>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Modal -->
<div class="modal fade" id="Limits" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title text-center">EDIT LIMIT</h4>
			</div>
			<div class="modal-body">
                <form action="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/get_edit_limit_main/" id="qty" class="form-horizontal" role="form" enctype="multipart/form-data" method="post">
					<div class="form-group">
						<label  class="col-sm-2 control-label" for="inputDate">Date</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="sevadate" name="sevadate" readonly value="<?php echo $this->input->post('date'); ?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputLimit" >Limit</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="sevalimit" name="sevalimit" onkeyup="checkPriceVal(event)" value="<?php echo $this->input->post('limit'); ?>"/>
						</div>
					</div>
					<!-- HIDDEN -->
					<input type="hidden" id="id" name="id">
					<input type="hidden" id="counter" name="counter">
					<input type="hidden" id="seva_id" name="seva_id" value="<?php echo $admin_settings_event_seva[0]->TET_SEVA_ID; ?>">
					<input type="hidden" id="sevaLimit_id" name="sevaLimit_id" value="<?php echo $admin_settings_event_seva[0]->TET_SEVA_ID; ?>">
					<div class="modal-footer">
						<button type="button" class="btn btn-default" onclick="GetSubmitForm()">SAVE</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="Stocks" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title text-center">EDIT STOCK</h4>
			</div>
			<div class="modal-body">
                <form action="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/get_edit_stock_main/" id="qtyStock" class="form-horizontal" role="form" enctype="multipart/form-data" method="post">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputLimit" >Stock</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="sevastock" name="sevastock" onkeyup="checkPriceVal(event)" value="<?php echo $this->input->post('limit'); ?>"/>
						</div>
					</div>
					<!-- HIDDEN -->
					<input type="hidden" id="idST" name="idST">
					<input type="hidden" id="seva_idST" name="seva_idST" value="<?php echo $admin_settings_event_seva[0]->TET_SEVA_ID; ?>">
					<div class="modal-footer">
						<button type="button" class="btn btn-default" onclick="GetSubmitFormStock()">SAVE</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>	
	<!-- Limit Validation -->
	$('#sevalimit').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^0-9]/g, function(str) { return ''; } ) );
	});

	<!-- Stock Validation -->
	$('#sevastock').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^0-9]/g, function(str) { return ''; } ) );
	});
	
	<!-- Check If Price Is Zero -->
	function checkPriceVal(evt){
		inputLS = evt.currentTarget;
		if($(inputLS).val() && Number($(inputLS).val()) == 0){
			$(inputLS).val("");
		} 			
	}
	
	//FORM SUBMIT
	function GetSubmitForm() {
		if(document.getElementById('sevalimit').value == "") {
			$('#sevalimit').css('border-color','red');
			$('#Limits').shake(); 
		} else {
			var url = "<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/get_count_seva_offered_main";
			$.post(url, {'sevaid':$('#sevaLimit_id').val(),'date':$('#sevadate').val()}, function(e) {
				if(Number(document.getElementById('sevalimit').value) >= Number(e)){
					document.getElementById("qty").submit();	
				} else {
					alert('Information','You cannot set limit lesser than sevas booked.','OK');
				}
			});
		}
	}

	//FORM SUBMIT STOCK
	function GetSubmitFormStock() {
		if(document.getElementById('sevastock').value == "") {
			$('#sevastock').css('border-color','red');
			$('#Stocks').shake(); 
		} else {
			document.getElementById("qtyStock").submit();	
		}	
	}
	
	//GET ADD TO POP UP
	function GetAddToHiddenLimit(date,name,id,counter,limitId) {
		document.getElementById('sevadate').value = date;
		document.getElementById('sevalimit').value = name;
		document.getElementById('id').value = id;
		document.getElementById('counter').value = counter;
		document.getElementById('sevaLimit_id').value = limitId;
		$('#Limits').modal('show'); 	
	}
	
	//GET ADD TO POP UP STOCK
	function GetAddToHiddenStock(date,name,id) {
		document.getElementById('sevastock').value = name;
		document.getElementById('idST').value = id;
		$('#Stocks').modal('show'); 	
	}
	
	//STATUS CHANGE
	function GetStatusChange(status,sevaName,eventName,id) {
		if(status == 1) {
			alertTrustDialog("Warning","Are you sure, you want to <strong>deactivate</strong> the <strong>"+ sevaName +"</strong> for <strong>"+ eventName +"</strong>?","Deactivate",true,id,0);
		} else {
			alertTrustDialog("Warning","Are you sure, you want to <strong>activate</strong> the <strong>"+ sevaName +"</strong> for <strong>"+ eventName +"</strong>?","Activate",true,id,1);
		}
	}
</script>