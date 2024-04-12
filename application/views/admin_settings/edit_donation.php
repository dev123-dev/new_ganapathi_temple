<form action="<?php echo site_url(); ?>admin_settings/Admin_setting/update_donation" enctype="multipart/form-data" method="post" accept-charset="utf-8" onsubmit="return field_validation()">
	<section id="section-register" class="bg_register">
		<div class="container-fluid sub_reg ">	
		<!-- START Content -->
			<div class="container-fluid container">
			<!-- START Row -->
				<div class="row-fluid">
					<div class="span12 widget lime">               
						<h3 class="registr"><span class="icon icone-crop"></span>Edit Donation</h3>                 
					</div>           
				</div>	
				<br/>
				<section class="body">
					<div class="body-inner">    
						<div class="row form-group">
							<div class="control-group col-md-6 col-lg-6 col-sm-6 col-xs-12">
								<label class="control-label color_black">Name <span style="color:#800000;">*</span></label>
								<div class="controls">
									<input name="name" id="name" type="text" class="span6  form-control register_form" value="<?php echo $edit_donation[0]->ET_RECEIPT_NAME; ?>">
									<input type="hidden" name="id" id="id" value="<?php echo $edit_donation[0]->ET_RECEIPT_ID; ?>">
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
							
							<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
								<label class="control-label color_black">Price</label>
								<div class="controls">
									<input name="price" id="price" type="text" class="span6  form-control register_form" onkeyup="checkPriceVal(event)" disabled value="<?php echo $edit_donation[0]->ET_RECEIPT_PRICE; ?>">
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
							
							<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
								<label class="control-label color_black">Receipt No.</label>
								<div class="controls">
									<input name="price" id="price" type="text" class="span6  form-control register_form" onkeyup="checkPriceVal(event)" disabled value="<?php echo $edit_donation[0]->ET_RECEIPT_NO; ?>">
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
								<button type="button" class="btn btn-default btn-md" onclick="window.history.back();"><strong>CANCEL</strong></button>
							</div>
						</div>
					</div>
			   </section>
		  </div>
		</div>
	</section>
</form>
<script>
	<!-- Check If Price Is Zero -->
	function checkPriceVal(evt){
		inputPrice = evt.currentTarget;
		if($(inputPrice).val() && Number($(inputPrice).val()) == 0){
			$(inputPrice).val("");
		} 			
	}

	<!-- Price Validation -->
	$('#price').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^0-9]/g, function(str) { return ''; } ) );
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
</script>