<section id="section-register" class="bg_register">
    <div class="container-fluid sub_reg" style="min-height:100%;">  	
		<!-- START Content -->
		<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
		<div class="container reg_top adminside">
			<!-- START Row -->
			<div class="row-fluid">
				<!-- START Datatable 2 -->
				<div class="span12 widget lime">
					<div class="row form-group"> 
						<div class="col-md-9 col-lg-9 col-sm-8 col-xs-8 no-pad">
							<?php if($admin_settings_event_seva[0]->IS_SEVA != 0) { ?>
								<h3>Seva Limit</h3>
							<?php } else { ?>
								<h3>Seva Stock</h3>
							<?php } ?>
						</div>
						<div class="col-md-3 col-lg-3 col-sm-4 col-xs-4 text-right"> 
							<a style="border:none; outline:0;" href="<?php echo site_url(); ?>admin_settings/Admin_setting/events_setting" title="Back"><img style="border:none; outline: 0;margin-top:1.4em;margin-bottom:.5em;" src="<?php echo base_url(); ?>images/back_icon.svg"></a>
						</div>
					</div>
					<form id="formLimit" enctype="multipart/form-data" method="post" accept-charset="utf-8">
						<div class="row form-group"> 
							<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-10" style="margin-bottom:1em;">
								<label class="control-label color_black">Seva Name</label>
								<div class="controls">
									<input name="seva_name" id="seva_name" type="text" class="span6  form-control register_form" readonly value="<?php echo $admin_settings_event_seva[0]->ET_SEVA_NAME; ?>">
									<span class="form-input-info positioning" style="color:#FF0000"></span>
									<!-- HIDDEN FIELD -->
									<input name="seva_id" id="seva_id" type="hidden" value="<?php echo $admin_settings_event_seva[0]->IS_SEVA ."¶". $admin_settings_event_seva[0]->ET_SEVA_ID; ?>">
								</div>
							</div>
							<?php if($admin_settings_event_seva[0]->IS_SEVA != 0) { ?>
								<div class="control-group col-md-3 col-lg-2 col-sm-3 col-xs-6" style="margin-bottom:1em;">
									<label class="control-label color_black">Date</label>
									<div class="controls">
										<div class="input-group input-group-sm">
											<input id="todayDateFrom" name="todayDateFrom" type="text" class="form-control todayDateFrom" placeholder="dd-mm-yyyy" readonly value="">
											<div class="input-group-btn">
												<button class="btn btn-default todayDateFromBtn" type="button">
													<i class="glyphicon glyphicon-calendar"></i>
												</button>
											</div>
										</div>
										<span class="form-input-info positioning" style="color:#FF0000"></span>
									</div>
								</div>
								<div class="control-group col-md-2 col-lg-1 col-sm-2 col-xs-4">
									<div class="controls">
										<label class="control-label color_black">Day Limit</label>
										<input name="Limit" id="Limit" type="text" class="span6  form-control register_form" onkeyup="checkPriceVal(event)">
										<span class="form-input-info positioning" style="color:#FF0000"></span>
									</div>
								</div> 
								<br/>
								
								<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-2">
									<div class="controls">
										<label class="control-label color_black"></label>
										<a style="border:none; outline:0;cursor:pointer;" onclick="return GetValidationAndLimit('<?php echo site_url(); ?>admin_settings/Admin_setting/get_add_limit_stock/1')" title="Add Limit"><img style="border:none; outline: 0;margin-top:.8em;margin-bottom:.5em;" src="<?php echo base_url(); ?>images/add_icon.svg"></a>
									</div>
								</div>
							<?php } else { ?>								
								<div class="control-group col-md-2 col-lg-1 col-sm-2 col-xs-4">
									<div class="controls">
										<label class="control-label color_black">Stock</label>
										<input type="text" class="span6  form-control register_form" id="Stock" name="Stock" onkeyup="checkPriceVal(event)">
									</div>
								</div> 
								<br/>
								
								<div class="control-group col-md-6 col-lg-6 col-sm-6 col-xs-6">
									<div class="controls">
										<label class="control-label color_black"></label>
										<a style="border:none; outline:0;cursor:pointer;" onclick="return GetValidationAndStock('<?php echo site_url(); ?>admin_settings/Admin_setting/get_add_limit_stock/2')" title="Add Stock"><img style="border:none; outline: 0;margin-top:.8em;margin-bottom:.5em;" src="<?php echo base_url(); ?>images/add_icon.svg"></a>
										 
										<label class="control-label color_black"></label> 
										<a style="border:none; outline:0;cursor:pointer;" onclick="return GetValidationAndEditStock('<?php echo site_url(); ?>admin_settings/Admin_setting/get_remove_stock/')" title="Remove Stock"><img style="border:none; outline: 0;margin-top:.8em;margin-bottom:.5em;" src="<?php echo base_url(); ?>images/minus_icon.svg"></a>
									</div>
								</div>
							<?php }  ?>
						</div>
						<?php if($admin_settings_event_seva[0]->IS_SEVA != 1) { ?>
							<div class="row form-group"> 
								<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 no-pad" style="font-size:20px;">
									<label class="control-label color_black">Stock Available :</label>
									<label class="control-label color_black" id="stAval" name="stAval"><?php echo (int)($laddu_available->AVA_QTY) - (int)($laddu_sold->SOLD_QTY); ?></label>
								</div>
							</div>
						<?php } ?>
						
						<div class="body-inner no-padding table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th style="width:10%;"><strong>Date Time</strong></th>
										<th style="width:10%;"><strong>Added By</strong></th>
										<?php if($admin_settings_event_seva[0]->IS_SEVA != 0) { ?>
											<th style="width:3%;"><strong>Seva Date</strong></th>
										<?php } ?>
										<?php if($admin_settings_event_seva[0]->IS_SEVA != 0) { ?>
											<th style="width:1%;"><strong>Limit</strong></th>
										<?php } else { ?>
											<th style="width:1%;"><strong>Stock</strong></th>
										<?php } ?>
										<?php if($admin_settings_event_seva[0]->IS_SEVA != 0) { ?>
											<th style="width:1%;"><strong>Operation</strong></th>
										<?php } ?>	
									</tr>
								</thead>
								<tbody>
									<?php foreach($admin_settings_event_seva_limit as $result) { ?>
										<tr class="row1">
											<td><?php echo $result->ESTDATETIME; ?></td>
											<td><?php echo $result->USER_FULL_NAME; ?></td>
											<?php if($admin_settings_event_seva[0]->IS_SEVA != 0) { ?>
												<td><?php echo $result->ET_SEVA_DATE; ?></td>
											<?php } ?>
											<?php if($admin_settings_event_seva[0]->IS_SEVA != 0) { ?>
											<td><center><?php echo $result->ET_SEVA_LIMIT; ?></center></td>
											<?php }?>
											<?php if($admin_settings_event_seva[0]->IS_SEVA != 0) { ?>
											<?php if($result->ET_IS_SEVA != 0) { ?>
												<td><center><a style="border:none; outline: 0;" onclick="GetAddToHiddenLimit('<?php echo $result->ET_SEVA_DATE ?>','<?php echo $result->ET_SEVA_LIMIT; ?>','<?php echo $result->ET_SL_ID; ?>','<?php echo $result->ET_SEVA_COUNTER; ?>')" role="button" data-toggle="modal" title="Edit"><img style="border:none; outline: 0;" src="<?php echo base_url(); ?>images/edit_icon.svg"></a></center></td>
											<?php } else { ?>
												<!--<td><center><a style="border:none; outline: 0;" onclick="GetAddToHiddenStock('<?php echo $result->ET_SEVA_DATE ?>','<?php echo $result->ET_SEVA_LIMIT; ?>','<?php echo $result->ET_SL_ID; ?>')" role="button" data-toggle="modal" title="Edit"><img style="border:none; outline: 0;" src="<?php echo base_url(); ?>images/edit_icon.svg"></a></center></td>-->
											<?php } ?>
											<?php }?>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
						<!-- HIDDEN TEXTBOX -->
						<input type="hidden" id="date" name="date">
						<input type="hidden" id="limit" name="limit">
						
						<!--SUCCESS MESSAGE DISPLAY CODE-->
						<?php
							if ($this->session->userdata('msg') == TRUE) {
								echo '<span style="color:#800000; font-weight:bold; font-size:16px;" class="text-center msg">' . $this->session->userdata('msg') . '</span>';
								$this->session->set_userdata('msg', '');
							}
						?>
						<!--SUCCESS MESSAGE DISPLAY CODE ENDS HERE-->
					</form>
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
                <form action="<?php echo site_url(); ?>admin_settings/Admin_setting/get_edit_limit/" id="qty" class="form-horizontal" role="form" enctype="multipart/form-data" method="post">
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
					<input type="hidden" id="seva_id" name="seva_id" value="<?php echo $admin_settings_event_seva[0]->ET_SEVA_ID; ?>">
					<div class="modal-footer">
						<button type="button" class="btn btn-default" onclick="GetSubmitFormLimit()">SAVE</button>
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
                <form action="<?php echo site_url(); ?>admin_settings/Admin_setting/get_edit_stock/" id="qtyStock" class="form-horizontal" role="form" enctype="multipart/form-data" method="post">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputLimit" >Stock</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="sevastock" name="sevastock" onkeyup="checkPriceVal(event)" value="<?php echo $this->input->post('limit'); ?>"/>
						</div>
					</div>
					<!-- HIDDEN -->
					<input type="hidden" id="idST" name="idST">
					<input type="hidden" id="seva_idST" name="seva_idST" value="<?php echo $admin_settings_event_seva[0]->ET_SEVA_ID; ?>">
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

	//FORM SUBMIT LIMIT
	function GetSubmitFormLimit() {
		if(document.getElementById('sevalimit').value == "") {
			$('#sevalimit').css('border-color','red');
			$('#Limits').shake(); 
		} else {
			var url = "<?php echo site_url(); ?>admin_settings/Admin_setting/get_count_seva_offered";
			$.post(url, {'sevaid':$('#seva_id').val(),'date':$('#sevadate').val()}, function(e) {
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
	
	//GET ADD TO POP UP LIMIT
	function GetAddToHiddenLimit(date,name,id,counter) {
		document.getElementById('sevadate').value = date;
		document.getElementById('sevalimit').value = name;
		document.getElementById('id').value = id;
		document.getElementById('counter').value = counter;
		$('#Limits').modal('show'); 	
	}
	
	//GET ADD TO POP UP STOCK
	function GetAddToHiddenStock(date,name,id) {
		document.getElementById('sevastock').value = name;
		document.getElementById('idST').value = id;
		$('#Stocks').modal('show'); 	
	}

	//VALIDATION AND ADD LIMIT
	function GetValidationAndLimit(url) {
		var count = 0;
		
		if(!$('#todayDateFrom').val()) {
			$('#todayDateFrom').css('border', "1px solid #FF0000"); 
			++count
			
		} else {
			$('#todayDateFrom').css('border', "1px solid #000000"); 
		}
		
		if(!$('#Limit').val()) {
			$('#Limit').css('border-color', "1px solid #FF0000"); 
			++count
			
		} else {
			$('#Limit').css('border-color', "1px solid #000000"); 
		}
		
		if(count != 0) {
			alert("Information","Please fill required fields","OK");
			return false;
		}
		$("#formLimit").attr("action",url)
		$("#formLimit").submit();
	}
	
	//VALIDATION AND ADD STOCK
	function GetValidationAndStock(url) {
		var count = 0;
		
		if(!$('#Stock').val()) {
			$('#Stock').css('border-color', "1px solid #FF0000"); 
			++count
			
		} else {
			$('#Stock').css('border-color', "1px solid #000000"); 
		}
		
		if(count != 0) {
			alert("Information","Please fill required fields","OK");
			return false;
		}
		$("#formLimit").attr("action",url)
		$("#formLimit").submit();
	}
	
	//VALIDATION AND EDIT STOCK
	function GetValidationAndEditStock(url) {
		if(Number($('#stAval').html()) < Number($('#Stock').val())) {
			alert("Information","Please enter the stock less then stock available.","OK");
			return false;
		}
		
		var count = 0;
		
		if(!$('#Stock').val()) {
			$('#Stock').css('border-color', "1px solid #FF0000"); 
			++count
			
		} else {
			$('#Stock').css('border-color', "1px solid #000000"); 
		}
		
		if(count != 0) {
			alert("Information","Please fill required fields","OK");
			return false;
		}
		$("#formLimit").attr("action",url)
		$("#formLimit").submit();
	}
	
	//INPUT KEYPRESS
	$(':input').on('keypress change', function() {
		var id = this.id;
		$('#' + id).css('border-color', "#000000");
	});
	
	<!-- Check If Price Is Zero -->
	function checkPriceVal(evt){
		inputLS = evt.currentTarget;
		if($(inputLS).val() && Number($(inputLS).val()) == 0){
			$(inputLS).val("");
		} 			
	}
	
	<!-- Limit Validation -->
	$('#Limit').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^0-9]/g, function(str) { return ''; } ) );
	});
	
	<!-- Stock Validation -->
	$('#Stock').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^0-9]/g, function(str) { return ''; } ) );
	});
	
	//DATEFIELD
	var currentTime = new Date()
    var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
    var maxDate =  new Date(currentTime.getFullYear(), currentTime.getMonth() +12, +0); // one day before next month
    
	$( ".todayDateFrom" ).datepicker({ 
		minDate: minDate, 
		maxDate: maxDate,
		dateFormat: 'dd-mm-yy'
    });
     
	$('.todayDateFromBtn').on('click', function() {
		$( ".todayDateFrom" ).focus();
	})
</script>