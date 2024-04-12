<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
<form action="<?php echo site_url(); ?>finance/save_finance_voucher_details" enctype="multipart/form-data" method="post" accept-charset="utf-8" onsubmit="return field_validation()">
	<section id="section-register" class="bg_register">
		<div class="container-fluid sub_reg ">	
		<!-- START Content -->
			<div class="container-fluid container">
			<!-- START Row -->
				<div class="row-fluid">
					<div class="span12 widget lime">               
						<h3 class="registr"><span class="icon icone-crop"></span>Edit Voucher Details</h3>  
						<?php if($receipt_deity[0]->FVC_ABBR2 == "R" || $receipt_deity[0]->FVC_ABBR2 == "P" || $receipt_deity[0]->FVC_ABBR2 == "J"|| $receipt_deity[0]->FVC_ABBR2 == "C" ) { ?>
							<h6 class="registr"><i>(Receipt, Payment, Journal, Contra)</i></h6>						
						<?php } ?>						
					</div>           
				</div>	
				<br/>
				<section class="body">
					<div class="body-inner">    						
						<div class="row form-group">
							<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
								<label class="control-label color_black">Finance Abbreviation</label>
								<div class="controls">
									<input name="receipt_for" id="receipt_for" type="text" class="span6  form-control register_form" value="<?php echo $receipt_deity[0]->FVC_ABBR1; ?>">
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
							
							<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
								<!--  -->
									<label class="control-label color_black">Voucher Abbreviation</label>
								<!--  -->
								<div class="controls">
									<input name="receipt_format" id="receipt_format" type="text" class="span6  form-control register_form" value="<?php echo $receipt_deity[0]->FVC_ABBR2; ?>">
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
						</div>
						
						<!--HIDDEN FIELD -->
						<input name="receiptid" id="receiptid" type="hidden" value="<?php echo $id; ?>">
						
						<div class="row form-group">
							<div class="control-group col-md-6 col-lg-6 col-sm-6 col-xs-12 text-left">
								<button type="submit" class="btn btn-default btn-md"><strong>SAVE</strong></button>
								<button type="button" class="btn btn-default btn-md" onclick="golist('finance/voucherCounter');"><strong>CANCEL</strong></button>
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