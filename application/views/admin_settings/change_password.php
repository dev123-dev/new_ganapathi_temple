<form action="<?php echo site_url(); ?>admin_settings/Admin_setting/insert_change_password" enctype="multipart/form-data" method="post" accept-charset="utf-8" onsubmit="return field_validation()">
	<section id="section-register" class="bg_register">
		<div class="container-fluid sub_reg ">	
		<!-- START Content -->
			<div class="container-fluid container">
			<!-- START Row -->
				<div class="row-fluid">
					<div class="span12 widget lime">               
						<h3 class="registr"><span class="icon icone-crop"></span>Change Password: <?php echo $users[0]->USER_FULL_NAME; ?></h3>                 
					</div>           
				</div>	
				<br/>
				<section class="body">
					<div class="body-inner">    						
						<div class="row form-group">
							<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
								<label class="control-label color_black">New Password</label>
								<div class="controls">
									<input name="user_pswd" id="user_pswd" type="password" class="span6  form-control register_form" value="">
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
							
							<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
								<label class="control-label color_black">Confirm Password</label>
								<div class="controls">
									<input name="confirm_pswd" id="confirm_pswd" type="password" class="span6  form-control register_form" value="">
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
						</div>
						
						<!--HIDDEN FIELD -->
						<input name="userid" id="userid" type="hidden" value="<?php echo $id; ?>">
						
						<div class="row form-group">
							<div class="control-group col-md-6 col-lg-6 col-sm-6 col-xs-12 text-left">
								<button type="submit" class="btn btn-default btn-md"><strong>SAVE</strong></button>
								<button type="button" class="btn btn-default btn-md" onclick="golist('admin_settings/Admin_setting/users_setting');"><strong>CANCEL</strong></button>
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
	
	<!-- Validating Fields -->
	function field_validation() {
		var count = 0;		
		var msg = "Please fill required fields";
		var pswd = document.getElementById("user_pswd").value;
		var conpswd = document.getElementById("confirm_pswd").value;
		
		$('input[type=password]').each(function(){
			var id = this.id;
			if($('#' + id).val() != "") {
				$('#' + id).css('border-color', "#000000");
			} else {
				$('#' + id).css('border-color', "#FF0000");
				++count;
			}
		});
		
		if(pswd != conpswd) {
			msg = "Password and Confirm Password is not matching";
			++count;
		}
		
		if(count != 0) {
			alert("Information",msg,"OK");
			return false;
		}
	}

    function golist(url){
		location.href = "<?php echo site_url();?>"+url;
    }
</script>