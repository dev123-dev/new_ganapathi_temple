<form action="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/update_hall_details" enctype="multipart/form-data" method="post" accept-charset="utf-8" onsubmit="return field_validation()">
	<section id="section-register" class="bg_register">
		<div class="container-fluid sub_reg ">	
		<!-- START Content -->
			<div class="container-fluid container">
			<!-- START Row -->
				<div class="row-fluid">
					<div class="span12 widget lime">               
						<h3 class="registr"><span class="icon icone-crop"></span>Edit Hall</h3>                 
					</div>           
				</div>	
				<br/>
				<section class="body">
					<div class="body-inner">    
						<div class="row form-group">							
							<div class="control-group col-md-6 col-lg-6 col-sm-6 col-xs-12">
								<label class="control-label color_black">Hall Name <span style="color:#800000;">*</span></label>
								<div class="controls">
									<input name="hall_name" id="hall_name" type="text" class="span6  form-control register_form" value="<?php echo $hall_details[0]->HALL_NAME; ?>">
									<input name="hall_id" id="hall_id" type="hidden" value="<?php echo $hall_details[0]->HALL_ID; ?>">
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div> 

							<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
								<label class="control-label color_black">Hall Active <span style="color:#800000;">*</span></label>
								<div class="controls">
									<select class="form-control register_form" id="hall_active" name="hall_active">		
										<?php if($hall_details[0]->HALL_ACTIVE == 0) { ?>
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
						<label class="control-label color_black">Active Financial Heads</label>
						<div class="row form-group">	
							<div class="control-inline col-md-12 col-lg-12 col-sm-12 col-xs-12" style="font-size:15px;margin-top:.2em;">
								<?php foreach($financialHeads as $result) { ?>
									<label class="checkbox-inline" style="font-weight:bold;">
										<input type="checkbox" class="sel" checked onclick="selectOnlyThis(this.id)" id="<?php echo $result->FH_ID; ?>" name="<?php echo $result->FH_NAME; ?>"><?php echo $result->FH_NAME; ?>
									</label>
								<?php } ?>
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
								<button type="button" class="btn btn-default btn-md" onclick="golist('admin_settings/Admin_Trust_setting/hall_setting');"><strong>CANCEL</strong></button>
							</div>
						</div>
					</div>
			   </section>
		  </div>
		</div>
	</section>
	<!--HIDDEN FIELD-->
	<input type="hidden" name="hfhId" id="hfhId">
</form>
<script>
	var finalValue = '';
	//CONDITION FOR CHECKING ONLY ONE CHECK BOX
	function selectOnlyThis(id) {
		if(document.getElementById(id).checked == false) {
			if(finalValue == "") {
				finalValue += id;
			} else {
				finalValue += "," + id;
			}
			$('#hfhId').val(finalValue);
		} else {
			var res = finalValue.split(",");
			finalValue = '';
			for (i = 0; i < res.length; i++) { 
				if(res[i] != id) {
					if(finalValue == "") {
						finalValue += res[i];
					} else {
						finalValue += "," + res[i];
					}
				}
			}
			$('#hfhId').val(finalValue);
		}
	}

    function golist(url){
		location.href = "<?php echo site_url();?>"+url;
    }
	
	<!-- Name Validation -->
	$('#deity_name').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^A-Za-z ]/g, function(str) { return ''; } ) );
	});
	
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
</script>