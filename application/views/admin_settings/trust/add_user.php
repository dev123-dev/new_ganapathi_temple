<form action="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/insert_user" enctype="multipart/form-data" method="post" accept-charset="utf-8" onsubmit="return field_validation()">
	<section id="section-register" class="bg_register">
		<div class="container-fluid sub_reg ">	
		<!-- START Content -->
			<div class="container-fluid container">
			<!-- START Row -->
				<div class="row-fluid">
					<div class="span12 widget lime">               
						<h3 class="registr"><span class="icon icone-crop"></span>Add User</h3>                 
					</div>           
				</div>	
				<br/>
				<section class="body">
					<div class="body-inner">    
						<div class="row form-group">
							<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
								<label class="control-label color_black">FullName <span style="color:#800000;">*</span></label>
								<div class="controls">
									<input name="full_name" id="full_name" type="text" class="span6  form-control register_form" value="">
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
							
							<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
								<label class="control-label color_black">Username <span style="color:#800000;">*</span></label>
								<div class="controls">
									<input name="user_name" id="user_name" type="text" class="span6  form-control register_form" value="">
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
							
							<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
								<label class="control-label color_black">Email</label>
								<div class="controls">
									<input name="user_email" id="user_email" type="email" class="span6  form-control register_form" value="">
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>  

							<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
								<label class="control-label color_black">Phone <span style="color:#800000;">*</span></label>
								<div class="controls">
									<input name="user_phone" id="user_phone" type="text" class="span6  form-control register_form" value="">
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
						</div>
						
						<div class="row form-group">
							<div class="control-group col-md-6 col-lg-6 col-sm-6 col-xs-12">
								<label class="control-label color_black">Address</label>
								<div class="controls">
									<textarea rows="5" name="user_address" id="user_address" style="resize: none;" class="span6 form-control register_form" ></textarea>
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
							
							<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
								<label class="control-label color_black">User Group <span style="color:#800000;">*</span></label>
								<div class="controls">
									<select class="form-control register_form" id="user_group" name="user_group">
										<option selected value="">Select Group</option>	
										<?php foreach($groups as $result) { ?>
											<option value="<?php echo $result->GROUP_ID ."|". $result->GROUP_NAME;?>"><?php echo $result->GROUP_NAME; ?></option>
										<?php } ?>										
									</select>
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
							
							<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
								<label class="control-label color_black">User Active <span style="color:#800000;">*</span></label>
								<div class="controls">
									<select class="form-control register_form" id="user_active" name="user_active">		
										<option selected value="">Select Status</option>									
										<option value="1">Active</option>
										<option value="0">Deactive</option> 									
									</select>
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
							
							<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-12" style="margin-top: 1.3em;">
								<label class="control-label color_black">Password <span style="color:#800000;">*</span></label>
								<div class="controls">
									<input name="user_pswd" id="user_pswd" type="password" class="span6  form-control register_form" value="">
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
							
							<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-12" style="margin-top: 1.3em;">
								<label class="control-label color_black">Confirm Password <span style="color:#800000;">*</span></label>
								<div class="controls">
									<input name="confirm_pswd" id="confirm_pswd" type="password" class="span6  form-control register_form" value="">
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
								<button type="button" class="btn btn-default btn-md" onclick="golist('admin_settings/Admin_Trust_setting/users_setting');"><strong>CANCEL</strong></button>
							</div>
						</div>
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
		
	//SELECT CHANGE
	$('select').on('change', function() {
		var id = this.id;
		$('#' + id).css('border-color', "#000000");
	});
	
	<!-- Full Name Validation -->
	$('#full_name').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^A-Za-z ]/g, function(str) { return ''; } ) );
	});
	
	<!-- User Name Validation -->
	$('#user_name').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^A-Za-z]/g, function(str) { return ''; } ) );
	});
	
	<!-- Price Validation -->
	$('#user_phone').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^0-9]/g, function(str) { return ''; } ) );
	});

	<!-- Validating Fields -->
	function field_validation() {
		var count = 0;
		var msg = "";
		var pswd = document.getElementById("user_pswd").value;
		var conpswd = document.getElementById("confirm_pswd").value;
		
		if(pswd == conpswd) {
			msg = "Please fill required fields";
		} else {
			msg = "Password and Confirm Password is not matching";
			++count;
		}
		
		$('input[type=text]').each(function(){
			var id = this.id;
			if($('#' + id).val() != "") {
				$('#' + id).css('border-color', "#000000");
			} else {
				$('#' + id).css('border-color', "#FF0000");
				++count;
			}
		});
		
		$('input[type=password]').each(function(){
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
			alert("Information",msg,"OK");
			return false;
		}
	}

    function golist(url){
		location.href = "<?php echo site_url();?>"+url;
    }
</script>