<form action="<?php echo site_url(); ?>admin_settings/Admin_setting/save_financial_setting" enctype="multipart/form-data" method="post" accept-charset="utf-8" onsubmit="return field_validation()">
	<section id="section-register" class="bg_register">
		<!-- START Content -->
		<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
		<div class="container-fluid sub_reg ">	
		<!-- START Content -->
			<div class="container-fluid container">
			<!-- START Row -->
				<div class="row-fluid">
					<div class="span12 widget lime">               
						<h3 class="registr"><span class="icon icone-crop"></span>Financial Month Setting</h3>                 
					</div>           
				</div>	
				<br/>
				<section class="body">
					<div class="body-inner">    						
						<div class="row form-group">
							<div class="control-group col-md-2 col-lg-2 col-sm-2 col-xs-12">
								<label class="control-label color_black">Select Month <span style="color:#800000;">*</span></label>
								<div class="controls">
									<select class="form-control register_form" id="fin_month" name="fin_month">
										<option value="">Select Month</option>		
										<?php if($fMonth->MONTH_IN_NUMBER == 1) { ?>
											<option selected value="1|January">January</option>
										<?php } else { ?>
											<option value="1|January">January</option>
										<?php } ?>
										
										<?php if($fMonth->MONTH_IN_NUMBER == 2) { ?>
											<option selected value="2|February">February</option>
										<?php } else { ?>
											<option value="2|February">February</option>
										<?php } ?>
										
										<?php if($fMonth->MONTH_IN_NUMBER == 3) { ?>
											<option selected value="3|March">March</option> 
										<?php } else { ?>
											<option value="3|March">March</option> 
										<?php } ?>
										
										<?php if($fMonth->MONTH_IN_NUMBER == 4) { ?>
											<option selected value="4|April">April</option> 
										<?php } else { ?>
											<option value="4|April">April</option> 
										<?php } ?>
										
										<?php if($fMonth->MONTH_IN_NUMBER == 5) { ?>
											<option selected value="5|May">May</option>
										<?php } else { ?>
											<option value="5|May">May</option>
										<?php } ?>
										
										<?php if($fMonth->MONTH_IN_NUMBER == 6) { ?>
											<option selected value="6|June">June</option> 
										<?php } else { ?>
											<option value="6|June">June</option> 
										<?php } ?>
										
										<?php if($fMonth->MONTH_IN_NUMBER == 7) { ?>
											<option selected value="7|July">July</option> 
										<?php } else { ?>
											<option value="7|July">July</option> 
										<?php } ?>
										
										<?php if($fMonth->MONTH_IN_NUMBER == 8) { ?>
											<option selected value="8|August">August</option> 
										<?php } else { ?>
											<option value="8|August">August</option> 
										<?php } ?>
										
										<?php if($fMonth->MONTH_IN_NUMBER == 9) { ?>
											<option selected value="9|September">September</option>
										<?php } else { ?>
											<option value="9|September">September</option>
										<?php } ?>
										
										<?php if($fMonth->MONTH_IN_NUMBER == 10) { ?>
											<option selected value="10|October">October</option> 
										<?php } else { ?>
											<option value="10|October">October</option> 
										<?php } ?>
										
										<?php if($fMonth->MONTH_IN_NUMBER == 11) { ?>
											<option selected value="11|November">November</option> 
										<?php } else { ?>
											<option value="11|November">November</option> 
										<?php } ?>
										
										<?php if($fMonth->MONTH_IN_NUMBER == 12) { ?>
											<option selected value="12|December">December</option> 
										<?php } else { ?>
											<option value="12|December">December</option> 
										<?php } ?>
									</select>
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
						</div>
						
						<div class="row form-group">
							<div class="control-group col-md-6 col-lg-6 col-sm-6 col-xs-12 text-left">
								<button type="submit" class="btn btn-default btn-md"><strong>SAVE</strong></button>
								<button type="button" class="btn btn-default btn-md" onclick="golist('Events');"><strong>CANCEL</strong></button>
							</div>
						</div>
						<!--SUCCESS MESSAGE DISPLAY CODE-->
						<?php
							if (isset($msg)) {
								echo '<span style="color:#800000; font-weight:bold; font-size:16px;" class="text-center msg">' . $msg . '</span>';
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
	//SELECT CHANGE
	$('select').on('change', function() {
		var id = this.id;
		$('#' + id).css('border-color', "#000000");
	});
	
	<!-- Validating Fields -->
	function field_validation() {
		var count = 0;
		
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
			alert("Information","Please select the month","OK");
			return false;
		}
	}
	
	function golist(url){
		location.href = "<?php echo site_url();?>"+url;
    }
</script>