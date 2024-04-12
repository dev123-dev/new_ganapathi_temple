<form action="<?php echo site_url(); ?>admin_settings/Admin_setting/update_inkind" enctype="multipart/form-data" method="post" accept-charset="utf-8" onsubmit="return field_validation()">
	<section id="section-register" class="bg_register">
		<div class="container-fluid sub_reg ">	
		<!-- START Content -->
			<div class="container-fluid container">
			<!-- START Row -->
				<div class="row-fluid">
					<div class="span12 widget lime">               
						<h3 class="registr"><span class="icon icone-crop"></span>Edit Inkind Item</h3>                 
					</div>           
				</div>	
				<br/>
				<section class="body">
					<div class="body-inner">    
						<div class="row form-group">							
							<div class="control-group col-md-4 col-lg-4 col-sm-4 col-xs-12">
								<label class="control-label color_black">Item Name <span style="color:#800000;">*</span></label>
								<div class="controls">
									<input name="item_name" id="item_name" type="text" class="span6  form-control register_form" value="<?php echo $inkind_items[0]->INKIND_ITEM_NAME; ?>">
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div> 

							<div class="control-group col-md-1 col-lg-1 col-sm-1 col-xs-12">
								<label class="control-label color_black">Unit <span style="color:#800000;">*</span></label>
								<div class="controls">
									<input name="unit_name" id="unit_name" type="text" class="span6  form-control register_form" value="<?php echo $inkind_items[0]->INKIND_UNIT; ?>">
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div> 
						</div>
						<!--HIDDEN FIELDS-->
						<input name="inkindId" id="inkindId" type="hidden" value="<?php echo $inkind_items[0]->INKIND_ITEM_ID; ?>">
						
						<div class="row form-group">
							<div class="control-group col-md-5 col-lg-5 col-sm-5 col-xs-12">
								<label class="control-label color_black">Inkind Description</label>
								<div class="controls">
									<textarea rows="5" name="inkind_desc" id="inkind_desc" style="resize: none;" class="span6 form-control register_form" ><?php echo $inkind_items[0]->INKIND_DESC; ?></textarea>
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
								<button type="button" class="btn btn-default btn-md" onclick="golist('admin_settings/Admin_setting/inkind_items');"><strong>CANCEL</strong></button>
							</div>
						</div>
					</div>
			   </section>
		  </div>
		</div>
	</section>
</form>
<script>
	$('#unit_name').keypress(function (e) {
		var regex = new RegExp("^[a-zA-Z-]+$");
		var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
		if (regex.test(str)) {
			return true;
		}

		e.preventDefault();
		return false;
	});

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

    function golist(url){
		location.href = "<?php echo site_url();?>"+url;
    }
</script>