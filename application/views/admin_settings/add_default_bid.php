<form action="<?php echo site_url(); ?>admin_settings/Admin_setting/save_default_bid" enctype="multipart/form-data" method="post" accept-charset="utf-8" onsubmit="return field_validation()">
	<section id="section-register" class="bg_register">
		<div class="container-fluid sub_reg ">	
		<!-- START Content -->
			<div class="container-fluid container">
			<!-- START Row -->
				<div class="row-fluid">
					<div class="span12 widget lime">               
						<h3 class="registr"><span class="icon icone-crop"></span>Add Default Bid</h3>                 
					</div>           
				</div>	
				<br/>
				<section class="body">
					<div class="body-inner">    
						<div class="row form-group">							
							<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
								<label class="control-label color_black">Item <span style="color:#800000;">*</span></label>
								<div class="controls">
									<select onChange="setSaree();" class="form-control register_form" id="item" name="item">		
										<option selected value="">Select Item</option>
										<?php foreach($auction_item as $result) { ?>
											<option value="<?php echo $result->AI_ID;?>"><?php echo $result->AI_NAME; ?></option>
										<?php } ?>
									</select>
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
							
							<div style="display:none;" class="item_Cat">
								<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
									<label class="control-label color_black">Item Category <span style="color:#800000;">*</span></label>
									<div class="controls">
										<select class="form-control register_form" id="item_category" name="item_category">		
											<option selected value="">Select Item Category</option>									
											<?php foreach($auction_category as $result) { ?>
												<option value="<?php echo $result->AIC_ID;?>"><?php echo $result->AIC_NAME;?></option>
											<?php } ?>
										</select>
										<span class="form-input-info positioning" style="color:#FF0000"></span>
									</div>
								</div> 
							</div>
							
							<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
								<label class="control-label color_black">Bid Value <span style="color:#800000;">*</span></label>
								<div class="controls">
									<input name="bid_value" id="bid_value" type="text" class="span6  form-control register_form" value="">
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
								<button type="button" class="btn btn-default btn-md" onclick="golist('admin_settings/Admin_setting/auction_setting');"><strong>CANCEL</strong></button>
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

    function golist(url){
		location.href = "<?php echo site_url();?>"+url;
    }
	
	//ON COMBO CHANGE DISPLAY CATEGORY
	function setSaree() {
		$item = $('#item').val();
		if($item == "2")
			$('.item_Cat').fadeIn( "slow" );
		else
			$('.item_Cat').hide();
	}
	
	<!-- Name Validation -->
	$('#bid_value').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^0-9 ]/g, function(str) { return ''; } ) );
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
		
		$item = $('#item').val();
		if($item == "2") {
			$('select').each(function(){
				var id = this.id;
				if($('#' + id).val() != "") {
					$('#' + id).css('border-color', "#000000");
				} else {
					$('#' + id).css('border-color', "#FF0000");
					++count;
				}
			});
		} else {
			$('select').each(function(){
				var id = "item";
				if($('#' + id).val() != "") {
					$('#' + id).css('border-color', "#000000");
				} else {
					$('#' + id).css('border-color', "#FF0000");
					++count;
				}
			});
		}
		
		if(count != 0) {
			alert("Information","Please fill required fields","OK");
			return false;
		}
	}
</script>