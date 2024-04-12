<form action="<?php echo site_url(); ?>admin_settings/Admin_setting/insert_group" enctype="multipart/form-data" method="post" accept-charset="utf-8" onsubmit="return field_validation()">
	<section id="section-register" class="bg_register">
		<div class="container-fluid sub_reg ">	
		<!-- START Content -->
			<div class="container-fluid container">
			<!-- START Row -->
				<div class="row-fluid">
					<div class="span12 widget lime">               
						<h3 class="registr"><span class="icon icone-crop"></span>Add Group Rights</h3>                 
					</div>           
				</div>	
				<br/>
				<section class="body">
					<div class="body-inner">    
						<div class="row form-group">
							<div class="control-group col-md-6 col-lg-6 col-sm-6 col-xs-12">
								<label class="control-label color_black">Group Name <span style="color:#800000;">*</span></label>
								<div class="controls">
									<input name="group_name" id="group_name" type="text" class="span6  form-control register_form" value="">
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
							
							<div class="control-group col-md-6 col-lg-6 col-sm-6 col-xs-12">
								<label class="control-label color_black">Group Active <span style="color:#800000;">*</span></label>
								<div class="controls">
									<select class="form-control register_form" id="group_active" name="group_active">		
										<option selected value="">Select Status</option>									
										<option value="1">Active</option>
										<option value="0">Deactive</option>									
									</select>
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
						</div>
						
						<div class="row form-group">
							<div class="control-group col-md-6 col-lg-6 col-sm-6 col-xs-12">
								<label class="control-label color_black">Group Description</label>
								<div class="controls">
									<textarea rows="5" name="group_desc" id="group_desc" style="resize: none;" class="span6 form-control register_form" ></textarea>
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
							
							<div class="control-inline col-md-6 col-lg-6 col-sm-6 col-xs-12" style="font-size:15px;margin-top:1.5em;">
								<label class="checkbox-inline" style="font-weight:bold;">
									<input type="checkbox" id="add" name="add">Add
								</label>
							
								<label class="checkbox-inline" style="font-weight:bold;">
									<input type="checkbox" id="edit" name="edit">Edit
								</label>
								
								<label class="checkbox-inline" style="font-weight:bold;">
									<input type="checkbox" id="actDct" name="actDct">Active/Deactive
								</label>
								
								<label class="checkbox-inline" style="font-weight:bold;">
									<input type="checkbox" id="authorise" name="authorise">Authorise
								</label>
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
								<button type="button" class="btn btn-default btn-md" onclick="golist('admin_settings/Admin_setting/groups_setting');"><strong>CANCEL</strong></button>
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

    function golist(url){
		location.href = "<?php echo site_url();?>"+url;
    }
</script>
<style>
.badgebox { opacity: 0; }
.badgebox + .badge { text-indent: -999999px; width: 27px; }
.badgebox:focus + .badge { box-shadow: inset 0px 0px 5px; }
.badgebox:checked + .badge { text-indent: 0; }
</style>