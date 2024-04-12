<form action="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/update_block_date" enctype="multipart/form-data" method="post" accept-charset="utf-8" onsubmit="return field_validation()">
	<section id="section-register" class="bg_register">
		<div class="container-fluid sub_reg ">	
			<!-- START Content -->
			<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
			<div class="container-fluid container">
			<!-- START Row -->
				<div class="row-fluid">
					<div class="span12 widget lime">               
						<h3 class="registr"><span class="icon icone-crop"></span>Edit Block Date</h3> 
					</div>           
				</div>	
				<br/>
				<section class="body">
					<div class="body-inner">    						
						<div class="row form-group">
							<div class="control-group col-md-4 col-lg-4 col-sm-4 col-xs-12">
								<label class="control-label color_black">Hall Name <span style="color:#800000;">*</span></label>
								<div class="controls">
									<select class="form-control register_form" id="hall_name" name="hall_name">	
										<?php foreach($hall_details as $result) { ?>
												<?php if($block_date[0]->H_ID == $result->HALL_ID) { ?>
													<option selected value="<?php echo $result->HALL_ID; ?>"><?php echo $result->HALL_NAME; ?></option> 
												<?php } else { ?>
													<option value="<?php echo $result->HALL_ID; ?>"><?php echo $result->HALL_NAME; ?></option> 
												<?php } ?>
										<?php } ?>	
									</select>
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
						
							<div class="control-group col-md-2 col-lg-2 col-sm-2 col-xs-12">
								<label class="control-label color_black">Date <span style="color:#800000;">*</span></label>
								<div class="controls">
									<div class="input-group input-group-sm">
										<input name="todayDateFrom" id="todayDateFrom" type="text" value="<?php echo $block_date[0]->TBDT_DATE; ?>" class="form-control todayDateFrom" placeholder="dd-mm-yyyy">
										<div class="input-group-btn">
											<button class="btn btn-default todayDateFromBtn" type="button">
												<i class="glyphicon glyphicon-calendar"></i>
											</button>
										</div>
									</div>
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div> 
						
							<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
								<label class="control-label color_black">Block Date Active <span style="color:#800000;">*</span></label>
								<div class="controls">
									<select class="form-control register_form" id="block_active" name="block_active">		
										<?php if($block_date[0]->TBDT_ACTIVE == 0) { ?>
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
							<div class="control-group col-md-6 col-lg-6 col-sm-6 col-xs-12 text-left">
								<button type="submit" class="btn btn-default btn-md"><strong>SAVE</strong></button>
								<button type="button" class="btn btn-default btn-md" onclick="window.history.back();"><strong>CANCEL</strong></button>
							</div>
						</div>
						<!--HIDDEN FIELD-->
						<input type="hidden" name="tbdtId" id="tbdtId" value="<?php echo $block_date[0]->TBDT_ID; ?>">
						
						<!--SUCCESS MESSAGE DISPLAY CODE-->
						<?php
							if ($this->session->userdata('msg') == TRUE) {
								echo '<span style="color:#800000; font-weight:bold; font-size:16px;" class="text-center msg">' . $this->session->userdata('msg') . '</span>';
								$this->session->set_userdata('msg', '');
							}
						?>
						<!--SUCCESS MESSAGE DISPLAY CODE ENDS HERE-->
					</div>
			   </section>
		  </div>
		</div>
	</section>
</form>
<script>
	//INPUT KEYPRESS
	$(':input').on('keypress change', function() {
		var id = this.id;
		$('#' + id).css('border-color', "#000000");
	});
	
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
		
		if(count != 0) {
			alert("Information","Please fill required fields","OK");
			return false;
		}
	}
	
	var currentTime = new Date();
    var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
    var maxDate =  new Date(currentTime.getFullYear(), currentTime.getMonth() +12, +0); // one day before next month
    $( ".todayDateFrom" ).datepicker({ 
		minDate: minDate, 
		maxDate: maxDate,
		dateFormat: 'dd-mm-yy'
    });
     
	$('.todayDateFromBtn').on('click', function() {
		$( ".todayDateFrom" ).focus();
	});
	
	$( ".todayDateTo" ).datepicker({ 
		minDate: minDate, 
		maxDate: maxDate,
		dateFormat: 'dd-mm-yy'
    });
     
	$('.todayDateToBtn').on('click', function() {
		$( ".todayDateTo" ).focus();
	});
</script>