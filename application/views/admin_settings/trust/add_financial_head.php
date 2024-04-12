<form action="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/save_financial_head" enctype="multipart/form-data" method="post" accept-charset="utf-8" onsubmit="return field_validation()">
	<section id="section-register" class="bg_register">
		<div class="container-fluid sub_reg ">	
		<!-- START Content -->
			<div class="container-fluid container">
			<!-- START Row -->
				<div class="row-fluid">
					<div class="span12 widget lime">               
						<h3 class="registr"><span class="icon icone-crop"></span>Add Financial Head</h3>                 
					</div>           
				</div>	
				<br/>
				<section class="body">
					<div class="body-inner">    
						<div class="row form-group">	
                            <!-- adding here by adithya -->
                            <div class="control-group col-md-4 col-lg-4 col-sm-4 col-xs-4">
							<label class="control-label color_black">Select Ledger to Assign <span style="color:#800000;">*</span></label>
								<div class="controls">
                                          <select id="ledgerId" name="ledgerId" class="form-control" autofocus>
                                              <?php   if(!empty($ledger)) {
                                                 foreach($ledger as $row1) { 
                                                  if($row1->T_FGLH_ID == $ledgerId) { ?> 
                                                    <option value="<?php echo $row1->T_FGLH_ID;?>" selected><?php echo $row1->T_FGLH_NAME;?></option>
                                                  <?php } else { ?> 
                                                    <option value="<?php echo $row1->T_FGLH_ID;?>"><?php echo $row1->T_FGLH_NAME;?></option>
                                                <?php } } } ?>
                                                <input type="hidden" name="todayDateVal" id="todayDateVal">
                                          </select>
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
						     </div> 
                            <!-- adding ends -->
							<div class="control-group col-md-4 col-lg-4 col-sm-4 col-xs-4">
								<label class="control-label color_black">Financial Name  <span style="color:#800000;">*</span></label>
								<div class="controls">
									<input name="financial_name" id="financial_name" type="text" class="span6  form-control register_form" value="">
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div> 

							<div class="control-group col-md-4 col-lg-4 col-sm-4 col-xs-4">
								<label class="control-label color_black">Financial Active <span style="color:#800000;">*</span></label>
								<div class="controls">
									<select class="form-control register_form" id="financial_active" name="financial_active">		
										<option selected value="">Select Status</option>									
										<option value="1">Active</option>
										<option value="0">Deactive</option> 									
									</select>
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
								<button type="button" class="btn btn-default btn-md" onclick="golist('admin_settings/Admin_Trust_setting/hall_setting');"><strong>CANCEL</strong></button>
							</div>
						</div>
					</div>
			   </section>
		  </div>
		</div>
	</section>
</form>
<script>
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