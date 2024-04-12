<div class="container-fluid" >	
	<!-- START Content -->
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<div class="container-fluid container">
		<!-- START Row -->
		<div class="row form-group">
			<div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">               
				<h3><span class="icon icone-crop"></span>Edit Postage Address:</h3> 
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4" style = "padding-top:10px;">
				<a class="pull-right" style="border:none; outline:0;" href="<?=site_url() ?>postage/postage_group" title="Back"><img style="border:none; outline: 0;" src="<?php echo base_url();?>images/back_icon.svg"></a>
			</div>
		</div>
		<form id ="postAddrsForm" action="<?php echo site_url(); ?>Postage/update_postage_adrs_details/" enctype="multipart/form-data" method="post" accept-charset="utf-8">
			<div style = "padding-top:15px;">
				<div class="body-inner">    						
					<div class="row ">
						<div class="control-group col-md-4 col-lg-6 col-sm-4 col-xs-8">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:0px;">
								<label>Name : <?php echo $postageAdrs[0]->RECEIPT_NAME; ?></label><br><br>
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:0px;">
								<input type="text" class="form-control form_contct2" id="addLine1" placeholder="Address Line1" name="addLine1" value="<?php echo $postageAdrs[0]->ADDRESS_LINE1; ?>" /><br>
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:0px;">
								<input type="text" class="form-control form_contct2" id="addLine2" placeholder="Address Line2" name="addLine2"  value="<?php echo $postageAdrs[0]->ADDRESS_LINE2; ?>"/><br>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding:0px;">
								<input type="text" class="form-control form_contct2" id="city" placeholder="City" name="city"  value="<?php echo $postageAdrs[0]->CITY; ?>"/><br>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding-left:5px;padding-right:5px;">
								<input type="text" class="form-control form_contct2" id="country" placeholder="Country" name="country"  value="<?php echo $postageAdrs[0]->COUNTRY; ?>" /><br>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding:0px;">
								<input type="text" class="form-control form_contct2" id="pincode" placeholder="Pincode" name="pincode"  value="<?php echo $postageAdrs[0]->PINCODE; ?>"/><br>
							</div>
						</div> 					
					</div>

						<div class="control-group col-md-6 col-lg-8 col-sm-6 col-xs-12 text-center"	>
							<br/>

							<input type="hidden"  name="RECEIPT_ID" value="<?php echo $postageAdrs[0]->RECEIPT_ID; ?>" />  
							<input type="hidden"  name="address" id="address"  />  
							<button type="button" id="submited" class="btn btn-default btn-md custom"><strong>UPDATE</strong></button>&nbsp;
							<button type="button" id = "cancelButton" class="btn btn-default btn-md custom"><strong>CANCEL</strong></button>
						</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script>

	
	$('#submited').on('click',function(e){
		let addLine1 = $('#addLine1'); 
		let addLine2 = $('#addLine2'); 
		let city = $('#city');
		let country = $('#country');
		let pincode = $('#pincode');
		let address = "";
		if(addLine1.val().trim().length > 0) {
			address += addLine1.val() + ", ";
		}
		
		if(addLine2.val().trim().length > 0) {
			address += addLine2.val() + ", ";
		}
		
		if(city.val().trim().length > 0) {
			address += city.val() + ", ";
		}
		
		if(country.val().trim().length > 0) {
			address += country.val() + ", ";
			
		}
		
		if(pincode.val().trim().length > 0) {
			address += pincode.val();
		}
		$('#address').val(address);
		$('#postAddrsForm').submit();
	});
	
	$('#cancelButton').on('click',function(e){
		window.location = "<?=site_url(); ?>postage/postage_group";	
	});

</script>