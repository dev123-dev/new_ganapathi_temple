<form action="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/update_event/<?php if($this->session->userdata('EtId') != "") { echo $this->session->userdata('EtId');  } else { echo $admin_settings_events[0]->TET_ID; } ?>" enctype="multipart/form-data" method="post" accept-charset="utf-8" onsubmit="return field_validation()">
	<section id="section-register" class="bg_register">
		<div class="container-fluid sub_reg ">	
		<!-- START Content -->
			<div class="container-fluid container">
			<!-- START Row -->
				<div class="row-fluid">
					<div class="span12 widget lime">               
						<h3 class="registr"><span class="icon icone-crop"></span>Edit Event </h3>                 
					</div>           
				</div>	
				<br/>
				<section class="body">
					<div class="body-inner">    
						<div class="row form-group">
							<div class="control-group col-md-6 col-lg-6 col-sm-6 col-xs-12">
								<label class="control-label color_black">Event Name <span style="color:#800000;">*</span></label>
								<div class="controls">
									<input name="event_name" id="event_name" type="text" class="span6  form-control register_form" value="<?php if($this->session->userdata('EtName') != "") { echo $this->session->userdata('EtName');  } else {  echo $admin_settings_events[0]->TET_NAME; } ?>">
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>

							<div class="control-group col-md-2 col-lg-2 col-sm-2 col-xs-12">
								<label class="control-label color_black">Event From <span style="color:#800000;">*</span></label>
								<div class="controls">
									<div class="input-group input-group-sm">
										<input name="todayDateFrom" id="todayDateFrom" type="text" value="<?php if($this->session->userdata('EtFrom') != "") { echo $this->session->userdata('EtFrom');  } else { echo $admin_settings_events[0]->TET_FROM_DATE_TIME; } ?>" class="form-control todayDateFrom" placeholder="dd-mm-yyyy">
										<div class="input-group-btn">
											<button class="btn btn-default todayDateFromBtn" type="button">
												<i class="glyphicon glyphicon-calendar"></i>
											</button>
										</div>
									</div>
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div> 
							
							<div class="control-group col-md-2 col-lg-2 col-sm-2 col-xs-12">
								<label class="control-label color_black">Event To <span style="color:#800000;">*</span></label>
								<div class="controls">
									<div class="input-group input-group-sm">
										<input name="todayDateTo" id="todayDateTo" type="text" value="<?php if($this->session->userdata('EtTo') != "") { echo $this->session->userdata('EtTo');  } else { echo $admin_settings_events[0]->TET_TO_DATE_TIME; } ?>" class="form-control todayDateTo" placeholder="dd-mm-yyyy">
										<div class="input-group-btn">
											<button class="btn btn-default todayDateToBtn" type="button">
												<i class="glyphicon glyphicon-calendar"></i>
											</button>
										</div>
									</div>
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>

							<div class="control-group col-md-2 col-lg-2 col-sm-2 col-xs-12">
								<label class="control-label color_black">Event Status <span style="color:#800000;">*</span></label>
								<div class="controls">
									<select class="form-control register_form" id="event_active" name="event_active">		
										<?php if($admin_settings_events[0]->TET_ACTIVE == 0) { ?>
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

						<!-- adding the committie dropdown by adithya on 8-1-24 start -->
						<div class="row form-group">
							<div class="control-group col-md-2 col-lg-2 col-sm-2 col-xs-12">
								<label class="control-label color_black">Select Committee <span style="color:#800000;">*</span></label>
								<div class="controls">
                                          <select id="CommitteeId" name="CommitteeId" class="form-control" onChange="onCommitteeChange();"autofocus>
                                              <?php   if(!empty($committee)) {
                                                 foreach($committee as $row1) { 
                                                  if($row1->T_COMP_ID == $compId) { ?> 
                                                    <option value="<?php echo $row1->T_COMP_ID;?>" selected><?php echo $row1->T_COMP_NAME;?></option>
                                                  <?php } else { ?> 
                                                    <option value="<?php echo $row1->T_COMP_ID;?>"><?php echo $row1->T_COMP_NAME;?></option>
                                                <?php } } } ?>
                                                <input type="hidden" name="todayDateVal" id="todayDateVal">
                                          </select>
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
						<!-- adding the committie dropdown by adithya on 8-1-24 end -->
						
						<div class="row form-group">
							<div class="control-group col-md-12 col-lg-12 col-sm-12 col-xs-12">
								<label class="control-label" style="color:#800000;font-size: 12px;"><i>* Indicates mandatory fields.</i></label>
							</div>
						</div>
						
						<div class="row form-group">
							<div class="control-group col-md-6 col-lg-6 col-sm-6 col-xs-12 text-left">
								<button type="submit" class="btn btn-default btn-md"><strong>UPDATE</strong></button>
								<button type="button" class="btn btn-default btn-md" onclick="golist('admin_settings/Admin_Trust_setting/events_setting');"><strong>CANCEL</strong></button>
							</div>
						</div>
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
	<!-- REMOVE SUCCESS MESSAGE -->
	setTimeout(function(){ $('.msg').html(''); }, 10000);
	
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