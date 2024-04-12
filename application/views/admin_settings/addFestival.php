<div class="container-fluid">	
	<!-- START Content -->
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<div class="container-fluid container">
		<!-- START Row -->
		<div class="row form-group">
			<div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">               
				<h3><span class="icon icone-crop"></span>Add Festival:</h3> 
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4" style = "padding-top:10px;">
				<a class="pull-right" style="border:none; outline:0;" href="<?=site_url() ?>admin_settings/Admin_setting/festival_setting/" title="Back"><img style="border:none; outline: 0;" src="<?php echo base_url();?>images/back_icon.svg"></a>
			</div>
		</div>
		<form id = "festivalForm" action="<?php echo site_url(); ?>Shashwath/add_festival_details/" enctype="multipart/form-data" method="post" accept-charset="utf-8">
			<div style = "padding-top:15px;">
				<div class="body-inner">    						
					<div class="row ">
						<div class="control-group col-md-4 col-lg-6 col-sm-4 col-xs-8">
							<label class="control-label color_black">Festival Name </label>
							<div class="controls" style= "padding-bottom:30px">
								<input type="text" class="form-control form_contct2" id="festivalN" placeholder="" name="festivalN" autofocus />	
							</div>
						</div> 					
					</div>


					<div class= "row " >
						<div class= "col-lg-2 col-md-4 col-sm-4 col-xs-12 ">
							<div class="form-group">
								<select id="masaCode" style="height: 30px;">
									<option value="">Select Masa</option>
									<?php   if(!empty($masa)) {
										foreach($masa as $row1) { ?> 
											<option value="<?php echo $row1->MASA_CODE;?>|<?php echo $row1->MASA_NAME;?>"><?php echo $row1->MASA_NAME;?></option>
										<?php }  
									}  ?>
								</select>
							</div>
						</div>
						<div class= "col-lg-2 col-md-4 col-sm-4 col-xs-12"  onchange="moon()">
							<div class="form-group">
								<select id="bomCode" style="height: 30px;">
									<option value="">Select SH/BH</option>
									<?php   if(!empty($moon)) {
										foreach($moon as $row2) { ?> 
											<option value="<?php echo $row2->BOM_CODE;?>|<?php echo $row2->BOM_NAME;?>"><?php echo $row2->BOM_NAME;?></option>
										<?php }  
									}  ?>
								</select>
							</div>
						</div>
						<?php $thithi = array($thithi_shudda,$thithi_bahula);?>
						<div class= "col-lg-2 col-md-4 col-sm-4 col-xs-12" id='thithiCodeDiv' >
							<div class="form-group">
								<select id="thithiCode" style="height: 30px;">
									<option value="">Select Thithi</option>
									<?php  if(!empty($thithi[0])) { 
										foreach($thithi[0] as $row) { ?> 
											<option value="<?php echo $row->THITHI_CODE;?>|<?php echo $row->THITHI_NAME;?>"><?php echo $row->THITHI_NAME;?></option>
										<?php } 
									} ?>
								</select>
							</div>
						</div>
						<div class= "col-lg-2 col-md-4 col-sm-4 col-xs-12"  id='thithiCode1Div' style="display:none;" >
							<div class="form-group">
								<select id="thithiCode1" name="thithiCode1" style="height: 30px" >
									<option value="">Select Thithi</option>
									<?php  if(!empty($thithi[1])) { 
										foreach($thithi[1] as $row1) { ?> 
											<option value="<?php echo $row1->THITHI_CODE;?>|<?php echo $row1->THITHI_NAME;?>"><?php echo $row1->THITHI_NAME;?></option>
										<?php } 
									} ?>
								</select>
							</div>
						</div>

						<input type="hidden" name="tcode" id="tcode" value="">
						<input type="hidden" name="sfsMasa" id="sfsMasa" value="">
						<input type="hidden" name="sfsBasedOnMoon" id="sfsBasedOnMoon" value="">
						<input type="hidden" name="sfsThithi" id="sfsThithi" value="">



						<div class="control-group col-md-6 col-lg-8 col-sm-6 col-xs-12 text-center"	>
							<br/>
							<button type="button" id="submited" class="btn btn-default btn-md custom"><strong>SAVE</strong></button>&nbsp;
							<button type="button" id = "cancelButton" class="btn btn-default btn-md custom"><strong>CANCEL</strong></button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script>
	function moon() {
		var m = document.getElementById("bomCode").value.split("|");
		if(m[0] == 'BH') {
			document.getElementById("thithiCode1Div").style.display ="block";
			document.getElementById("thithiCodeDiv").style.display ="none";
		} else {
			document.getElementById("thithiCode1Div").style.display ="none";
			document.getElementById("thithiCodeDiv").style.display ="block";
		}
	}

	$('#submited').on('click',function(e){
		var thithiIndex;
		let masaCode1 = $('#masaCode option:selected').val();
		let bomCode1 = $('#bomCode option:selected').val();
		let thithiCode0 = $('#thithiCode option:selected').val();
		let thithiCode11 = $('#thithiCode1 option:selected').val();
		if(masaCode1 != "" && bomCode1 != ""){
			if(bomCode1.split("|")[0] == 'SH') {
				if(thithiCode0 == ""){
					$('#thithiCode').css('border-color', "#FF0000")
					alert("Information","Please select appropriate Thithi date for seva");
					return;
				}
			} else {				
				if(thithiCode11 == ""){
					$('#thithiCode1').css('border-color', "#FF0000")
					alert("Information","Please select appropriate Thithi date for seva");
					return;
				}
			}
		} else {
			alert("Information","Please first select appropriate Masa, Shuddha/Bahula for hindu date");
			return;
		}

		let masaCode = document.getElementById("masaCode").value.split("|");
		let bomcode = document.getElementById("bomCode").value.split("|");
		if(bomcode[0] == 'SH') {
			let thithiCode = document.getElementById("thithiCode").value.split("|");
			thithiIndex = thithiCode[0];
		} else {
			let thithiCode1 = document.getElementById("thithiCode1").value.split("|");
			thithiIndex = thithiCode1[0];
		}
		var masa1,bomcode1,thithiName1;

		masa1 = masaCode[1];
		bomcode1 = bomcode[1];
		if(bomcode[0] == 'SH') {
			let thithiCode = document.getElementById("thithiCode").value.split("|");
			thithiName1 =thithiCode[1];	
		}else {
			let thithiCode1 = document.getElementById("thithiCode1").value.split("|");
			thithiName1 =thithiCode1[1];
		}
		let thithi =  masaCode[0]+bomcode[0]+thithiIndex ;
		$("#tcode").val(thithi);
		$("#sfsMasa").val(masaCode[1]);
		$("#sfsBasedOnMoon").val(bomcode[1]);
		$("#sfsThithi").val(thithiName1);

		if($('#festivalN').val() == '' || $('#tcode').val() == ''){
			alert('Information','Please enter details for Festival Name or Thithi Code');
		} else {
			$('#festivalForm').submit();
		}
	});

	$('#cancelButton').on('click',function(e){
		window.location = "<?=site_url(); ?>admin_settings/Admin_setting/festival_setting/";	
	});	

</script>