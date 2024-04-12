<form action="<?php echo site_url(); ?>admin_settings/Admin_setting/save_time" enctype="multipart/form-data" method="post" accept-charset="utf-8" onsubmit="return field_validation()">
	<section id="section-register" class="bg_register">
		<div class="container-fluid sub_reg ">	
			<!-- START Content -->
			<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
			<div class="container-fluid container">
			<!-- START Row -->
				<div class="row-fluid">
					<div class="span12 widget lime">               
						<h3 class="registr"><span class="icon icone-crop"></span>Seva Restricted Time:</h3> 
						<h6><i><?php if(isset($_SESSION['time'])) { echo "(".$_SESSION['time'][0]->TIME_FROM . " - " . $_SESSION['time'][0]->TIME_TO.")"; } ?></i></h6>
					</div>           
				</div>	
				<br/>
				<section class="body">
					<div class="body-inner">    						
						<div class="row form-group">
							<div class="control-group col-md-2 col-lg-2 col-sm-2 col-xs-12">
								<label class="control-label color_black">Time From</label>
								<div class="controls">
									<div class="input-group bootstrap-timepicker timepicker">
										<input id="timepickerFrom" name="timepickerFrom" type="text" class="form-control input-small">
										<span id="timeFrom" style="background-color:#FBB917;" class="input-group-addon pointer"><i class="glyphicon glyphicon-time"></i></span>
									</div>
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div> 
							
							<div class="control-group col-md-2 col-lg-2 col-sm-2 col-xs-12">
								<label class="control-label color_black">Time To</label>
								<div class="controls">
									<div class="input-group bootstrap-timepicker timepicker">
										<input id="timepickerTo" name="timepickerTo" type="text" class="form-control input-small">
										<span id="timeTo" style="background-color:#FBB917;" class="input-group-addon pointer"><i class="glyphicon glyphicon-time"></i></span>
									</div>
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
						</div>
											
						<div class="row form-group">
							<div class="control-group col-md-6 col-lg-6 col-sm-6 col-xs-12 text-left">
								<button type="submit" class="btn btn-default btn-md"><strong>SAVE</strong></button>
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
			
		if(count != 0) {
			alert("Information","Please fill required fields","OK");
			return false;
		}
	}
	
	$('#timepickerFrom').timepicker({
		defaultTime:''
	});
	
	$('#timepickerTo').timepicker({
		defaultTime:''
	});
	
	$('#timeFrom').click(function(){
		$('#timepickerFrom').focus();
	});
	
	$('#timeTo').click(function(){
		$('#timepickerTo').focus();
	});
</script>