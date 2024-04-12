<section id="section-register" class="bg_register">
    <div class="container-fluid sub_reg" style="min-height:100%;">  	
		<!-- START Content -->
		<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
		<div class="container reg_top adminside">
			<!-- START Row -->
			<div class="row-fluid">
				<!-- START Datatable 2 -->
				<div class="span12 widget lime">
					<section class="body">
						<!--DONATION-->
						<div class="row form-group"> 
							<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 no-pad">
								<h3>Deity Donation Special Receipt Price</h3>
							</div>
						</div>
						
						<form action="<?php echo site_url(); ?>admin_settings/Admin_setting/save_donation_special_price" enctype="multipart/form-data" method="post" accept-charset="utf-8" onsubmit="return field_validation_donation()">
							<div class="control-group col-md-2 col-lg-2 col-sm-2 col-xs-12">
								<div class="controls">
									<input name="donation_price" id="donation_price" type="text" placeholder="Price" class="span6  form-control register_form" value="<?php echo $donationPrice->PRICE; ?>">
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>  
						
							<div class="row form-group">
								<div class="control-group col-md-6 col-lg-6 col-sm-6 col-xs-12 text-left">
									<button type="submit" class="btn btn-default btn-md"><strong>UPDATE</strong></button>
								</div>
							</div>
						</form>
						<br><br>
						<!--KANIKE-->
						<div class="row form-group"> 
							<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 no-pad">
								<h3>Deity Kanike Special Receipt Price</h3>
							</div>
						</div>
						
						<form action="<?php echo site_url(); ?>admin_settings/Admin_setting/save_kanike_special_price" enctype="multipart/form-data" method="post" accept-charset="utf-8" onsubmit="return field_validation_kanike()">
							<div class="control-group col-md-2 col-lg-2 col-sm-2 col-xs-12">
								<div class="controls">
									<input name="kanike_price" id="kanike_price" type="text" placeholder="Price" class="span6  form-control register_form" value="<?php echo $kanikePrice->PRICE; ?>">
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div> 
							
							<div class="row form-group">
								<div class="control-group col-md-6 col-lg-6 col-sm-6 col-xs-12 text-left">
									<button type="submit" class="btn btn-default btn-md"><strong>UPDATE</strong></button>
								</div>
							</div>
						</form>
						<!--SUCCESS MESSAGE DISPLAY CODE-->
						<?php
							if (isset($msg)) {
								echo '<span style="color:#800000; font-weight:bold; font-size:16px;" class="text-center msg">' . $msg . '</span>';
							}
						?>
						<!--SUCCESS MESSAGE DISPLAY CODE ENDS HERE-->
					</section>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
	//INPUT KEYPRESS
	$(':input').on('keypress change', function() {
		var id = this.id;
		$('#' + id).css('border-color', "#000000");
	});

	<!-- Donation Price Validation -->
	$('#donation_price').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^0-9]/g, function(str) { return ''; } ) );
	});
	
	<!-- Kanike Price Validation -->
	$('#kanike_price').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^0-9]/g, function(str) { return ''; } ) );
	});
	
	<!-- Donation Validating Fields -->
	function field_validation_donation() {
		var count = 0;
		
		if (document.getElementById("donation_price").value != "") {
			$('#donation_price').css('border-color', "#000000");
		} else {
			$('#donation_price').css('border-color', "#FF0000");
			++count;
		}
		
		if(count != 0) {
			alert("Information","Please select the month","OK");
			return false;
		}
	}
	
	<!-- Kanike Validating Fields -->
	function field_validation_kanike() {
		var count = 0;
		
		if (document.getElementById("kanike_price").value != "") {
			$('#kanike_price').css('border-color', "#000000");
		} else {
			$('#kanike_price').css('border-color', "#FF0000");
			++count;
		}
		
		if(count != 0) {
			alert("Information","Please select the month","OK");
			return false;
		}
	}
</script>