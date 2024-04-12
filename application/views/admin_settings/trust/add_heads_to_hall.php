<form action="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/save_financial_head_on_hall" enctype="multipart/form-data" method="post" accept-charset="utf-8" onsubmit="return field_validation()">
	<section id="section-register" class="bg_register">
		<div class="container-fluid sub_reg ">	
			<!-- START Content -->
			<div class="container-fluid container">
				<!-- START Row -->
				<div class="row-fluid">
					<div class="span12 widget lime">               
						<h3 class="registr"><span class="icon icone-crop"></span>Financial Heads For <?php echo @$hall_details[0]->HALL_NAME; ?></h3>                 
					</div>           
				</div>	
				<br/>
				<section class="body">
					<div class="body-inner">    
						<div class="row form-group">							
							<div class="control-inline col-md-12 col-lg-12 col-sm-12 col-xs-12" style="font-size:15px;margin-top:.2em;">
								<?php foreach($financialHeads as $result) { ?>
									<label class="checkbox-inline" style="font-weight:bold;">
										<input type="checkbox" class="sel" onclick="selectOnlyThis(this.id)" id="<?php echo $result->FH_ID; ?>" name="<?php echo $result->FH_NAME; ?>"><?php echo $result->FH_NAME; ?>
									</label>
								<?php } ?>
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
	<input type="hidden" name="hallId" id="hallId" value="<?php echo @$hall_details[0]->HALL_ID; ?>">
</form>
<script>
	var finalValue = '';

    function golist(url){
		location.href = "<?php echo site_url();?>"+url;
    }
	
	//CONDITION FOR CHECKING ONLY ONE CHECK BOX
	function selectOnlyThis(id) {
		if(document.getElementById(id).checked) {
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
	
	<!-- Validating Fields -->
	function field_validation() {
		var count = 0;
		var inputs = document.getElementsByClassName("sel");
		
		for (var i = 0; i < inputs.length; i++) { 
            if (inputs[i].type == "checkbox") {
				for (var i = 0; i < inputs.length; i++) { 
				   if(inputs[i].checked == true) {
					   ++count;
				   }
				}
			}
		}
		
		if(count == 0) {
			alert("Information","Please check atleast one financial head","OK");
			return false;
		}
	}
</script>