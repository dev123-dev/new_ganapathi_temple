<form action="<?php echo site_url(); ?>admin_settings/Admin_setting/update_bank_details" enctype="multipart/form-data" method="post" accept-charset="utf-8" onsubmit="return field_validation()">
	<section id="section-register" class="bg_register">
		<div class="container-fluid sub_reg ">	
		<!-- START Content -->
			<div class="container-fluid container">
			<!-- START Row -->
				<div class="row-fluid">
					<div class="span12 widget lime">               
						<h3 class="registr"><span class="icon icone-crop"></span>Edit Bank</h3>                 
					</div>           
				</div>	
				<br/>
				<section class="body">
					<div class="body-inner">    
						<div class="row form-group">
							<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
								<label class="control-label color_black">Account No. <span style="color:#800000;">*</span></label>
								<div class="controls">
									<input name="account_no" id="account_no" type="text" class="span6  form-control register_form" value="<?php echo $bank_details[0]->ACCOUNT_NO; ?>">
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
						
							<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
								<label class="control-label color_black">Bank Name <span style="color:#800000;">*</span></label>
								<div class="controls">
									<input name="bank_name" id="bank_name" type="text" class="span6  form-control register_form" value="<?php echo $bank_details[0]->BANK_NAME; ?>">
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
							
							<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
								<label class="control-label color_black">Branch Name <span style="color:#800000;">*</span></label>
								<div class="controls">
									<input name="branch_name" id="branch_name" type="text" class="span6  form-control register_form" value="<?php echo $bank_details[0]->BANK_BRANCH; ?>">
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
							
							<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
								<label class="control-label color_black">IFSC Code </label>
								<div class="controls">
									<input name="ifsc_code" id="ifsc_code" type="text" class="span6  form-control register_form" value="<?php echo $bank_details[0]->BANK_IFSC_CODE; ?>">
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
								<button type="submit" class="btn btn-default btn-md"><strong>SAVE</strong></button>
								<button type="button" class="btn btn-default btn-md" onclick="golist('admin_settings/Admin_setting/bank_setting');"><strong>CANCEL</strong></button>
							</div>
						</div>
						<!--HIDDEN FIELD-->
						<input name="bank_id" id="bank_id" type="hidden" value="<?php echo $bank_details[0]->BANK_ID; ?>">
					</div>
					<!--HIDDEN FIELD-->
					<input name="page" id="page" type="hidden" value="<?php echo @$status; ?>">
			   </section>
		  </div>
		</div>
	</section>
</form>
<script>
    function golist(url){
		location.href = "<?php echo site_url();?>"+url;
    }
	
	//INPUT KEYPRESS
	$(':input').on('keypress change', function() {
		var id = this.id;
		$('#' + id).css('border-color', "#000000");
	});
		
	<!-- Validating Fields -->
	function field_validation() {
		var count = 0;
		
		if (document.getElementById("bank_name").value != "") {
			$('#bank_name').css('border-color', "#000000");
		} else {
			$('#bank_name').css('border-color', "#FF0000");
			++count;
		}
		
		if (document.getElementById("branch_name").value != "") {
			$('#branch_name').css('border-color', "#000000");
		} else {
			$('#branch_name').css('border-color', "#FF0000");
			++count;
		}
		
		if(count != 0) {
			alert("Information","Please fill required fields","OK");
			return false;
		}
	}
</script>