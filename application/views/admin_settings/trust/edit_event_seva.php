<form action="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/update_event_seva" enctype="multipart/form-data" method="post" accept-charset="utf-8" onsubmit="return field_validation()">
	<section id="section-register" class="bg_register">
		<div class="container-fluid sub_reg ">	
		<!-- START Content -->
			<div class="container-fluid container">
			<!-- START Row -->
				<div class="row-fluid">
					<div class="span12 widget lime">               
						<h3 class="registr"><span class="icon icone-crop"></span>Edit Event Seva</h3>                 
					</div>           
				</div>	
				<br/>
				<section class="body">
					<div class="body-inner">    
						<div class="row form-group">
							<div class="control-group col-md-6 col-lg-6 col-sm-6 col-xs-12">
								<label class="control-label color_black">Event Name</label>
								<div class="controls">
									<input name="event_name" id="event_name" type="text" class="span6  form-control register_form" value="<?php echo $admin_settings_event_seva[0]->TET_NAME; ?>" readonly>
									<input type="hidden" name="event_Id" id="event_Id" value="<?php echo $admin_settings_event_seva[0]->TET_ID; ?>">
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
							
							<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
								<label class="control-label color_black">Seva Price <span style="color:#800000;">*</span></label>
								<div class="controls">
									<input name="seva_price" id="seva_price" type="text" class="span6  form-control register_form" onkeyup="checkPriceVal(event)" value="<?php echo $admin_settings_event_seva[0]->TET_SEVA_PRICE; ?>">
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
							
							<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
								<label class="control-label color_black">Seva Status <span style="color:#800000;">*</span></label>
								<div class="controls">
									<select class="form-control register_form" id="seva_active" name="seva_active">		
										<?php if($admin_settings_event_seva[0]->TET_SEVA_ACTIVE == 0) { ?>
											<option value="1">Active</option>
											<option selected value="0">Deactive</option> 
										<?php } else { ?>
											<option selected value="1">Active</option>
											<option value="0">Deactive</option> 
										<?php } ?>									
									</select>
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>           
						</div>
						
						<div class="row form-group">
							<div class="control-group col-md-6 col-lg-6 col-sm-6 col-xs-12">
								<label class="control-label color_black">Seva Name <span style="color:#800000;">*</span></label>
								<div class="controls">
									<input name="seva_name" id="seva_name" type="text" class="span6  form-control register_form" value="<?php echo $admin_settings_event_seva[0]->TET_SEVA_NAME; ?>">
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>  
							
							<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
								<label class="control-label color_black">Quantity Checker</label>
								<div class="controls">
									<?php if($admin_settings_event_seva[0]->TET_SEVA_QUANTITY_CHECKER == 0) { ?>
										<input type="checkbox" value="1" name="qty_checker" style="width:20px;height:20px;margin:0;">
									<?php } else { ?>
										<input type="checkbox" value="1" name="qty_checker" style="width:20px;height:20px;margin:0;" checked>
									<?php } ?>
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
							
							<div class="control-group col-md-1 col-lg-1 col-sm-1 col-xs-2" style="margin-top:12px;">
								<div class="radio pull-left">
									<?php if($admin_settings_event_seva[0]->IS_SEVA == 1) { ?>
										<label style="font-weight:bold;"><input id="seva_Radio" type="radio" value="1" name="OptRadio" onclick="GetChangeBorderColor()" checked> Seva</label>
									<?php } else { ?>
										<label style="font-weight:bold;"><input id="seva_Radio" type="radio" value="1" name="OptRadio" onclick="GetChangeBorderColor()"> Seva</label>
									<?php } ?>
								</div>
							</div>
							
							<div class="control-group col-md-1 col-lg-1 col-sm-1 col-xs-2" style="margin-top:12px;">
								<div class="radio pull-left">
								<?php if($admin_settings_event_seva[0]->IS_SEVA == 0) { ?>
									<label style="font-weight:bold;"><input id="prasad_Radio" type="radio" value="0" name="OptRadio" onclick="GetChangeBorderColor()" checked> Prasad</label> 
								<?php } else { ?>
									<label style="font-weight:bold;"><input id="prasad_Radio" type="radio" value="0" name="OptRadio" onclick="GetChangeBorderColor()"> Prasad</label> 
								<?php } ?>
								</div>
							</div>
						</div>
						
						<div class="row form-group">
							<div class="control-group col-md-6 col-lg-6 col-sm-6 col-xs-12">
								<label class="control-label color_black">Seva Description</label>
								<div class="controls">
									<textarea rows="5" name="seva_desc" id="seva_desc" style="resize: none;" class="span6 form-control register_form"><?php echo $admin_settings_event_seva[0]->TET_SEVA_DESC; ?></textarea>
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
							
							<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
								<label class="control-label color_black">Restrict Date</label>
								<div class="controls">
								<?php if($admin_settings_event_seva[0]->RESTRICT_DATE == 0) { ?>
									<input type="checkbox" value="1" name="restrict_date" id="restrict_date" style="width:20px;height:20px;margin:0;">
								<?php } else { ?>
									<input type="checkbox" value="1" name="restrict_date" id="restrict_date" style="width:20px;height:20px;margin:0;" checked>
								<?php } ?>
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
							
							<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
								<label class="control-label color_black">Token</label>
								<div class="controls">
								<?php if($admin_settings_event_seva[0]->IS_TOKEN == 0) { ?>
									<input type="checkbox" value="1" name="token" id="token" style="width:20px;height:20px;margin:0;">
								<?php } else { ?>
									<input type="checkbox" value="1" name="token" id="token" style="width:20px;height:20px;margin:0;" checked>
								<?php } ?>
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
						</div>
						
						<div class="row form-group">
							<div class="control-group col-md-12 col-lg-12 col-sm-12 col-xs-12">
								<label class="control-label" style="color:#800000;font-size: 12px;"><i>* Indicates mandatory fields.</i></label>
							</div>
						</div>
						
						<div class="row form-group">
							<div class="control-group col-md-6 col-lg-6 col-sm-6 col-xs-12 text-left">
								<button type="submit" class="btn btn-default btn-md"><strong>UPDATE</strong></button>
								<button type="button" class="btn btn-default btn-md" onclick="window.history.back();"><strong>CANCEL</strong></button>
							</div>
						</div>
						<!--HIDDEN FIELDS -->
						<input type="hidden" name="seva_id" id="seva_id" value="<?php echo $admin_settings_event_seva[0]->TET_SEVA_ID; ?>">
						<input type="hidden" name="price" id="price" value="<?php echo $admin_settings_event_seva[0]->TET_SEVA_PRICE; ?>">
						<input type="hidden" name="price_id" id="price_id" value="<?php echo $admin_settings_event_seva[0]->TET_SEVA_PRICE_ID; ?>">
					</div>
			   </section>
		  </div>
		</div>
	</section>
</form>
<script>
	<!-- Check If Price Is Zero -->
	function checkPriceVal(evt){
		inputPrice = evt.currentTarget;
		if($(inputPrice).val() && Number($(inputPrice).val()) == 0){
			$(inputPrice).val("");
		} 			
	}

	<!-- Price Validation -->
	$('#seva_price').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^0-9]/g, function(str) { return ''; } ) );
	});
	
	<!-- Change Radio Border Color -->
	function GetChangeBorderColor() {
		$('#seva_Radio').css('border-color', "#000000");
		$('#prasad_Radio').css('border-color', "#000000");
	}
	
	<!-- Validating Fields -->
	function field_validation() {
		var count = 0;
		
		$('input[type=text]').each(function(){
			var id = this.id;
			if($('#' + id).val() != "") {
				$('#' + id).css('border-color', "#000000");
			} else {
				$('#' + id).css('border-color', "#FF0000");
				++count;
			}
		});
		
		$('select').each(function(){
			var id = this.id;
			if($('#' + id).val() != "") {
				$('#' + id).css('border-color', "#000000");
			} else {
				$('#' + id).css('border-color', "#FF0000");
				++count;
			}
		});
		
		if($('#seva_Radio').prop('checked') == true || $('#prasad_Radio').prop('checked') == true) {
			$('#seva_Radio').css('border-color', "#000000");
			$('#prasad_Radio').css('border-color', "#000000");
		} else {
			$('#seva_Radio').css('border-color', "#FF0000");
			$('#prasad_Radio').css('border-color', "#FF0000");
			++count;
		}
		
		if(count != 0) {
			alert("Information","Please fill required fields","OK");
			return false;
		}
	}
	
	//INPUT KEYPRESS
	$(':input').on('keypress change', function() {
		var id = this.id;
		$('#' + id).css('border-color', "#000000");
	});
	
	//SELECT CHANGE
	$('select').on('change', function() {
		var id = this.id;
		$('#' + id).css('border-color', "#000000");
	});
	<!-- Validating Fields Ends Here --> 
	
    function golist(url){
		location.href = "<?php echo site_url();?>"+url;
    }
	
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
	
	$( ".todayDateTo" ).datepicker({ 
		minDate: minDate, 
		maxDate: maxDate,
		dateFormat: 'dd-mm-yy'
    });
     
	$('.todayDateToBtn').on('click', function() {
		$( ".todayDateTo" ).focus();
	})
</script>