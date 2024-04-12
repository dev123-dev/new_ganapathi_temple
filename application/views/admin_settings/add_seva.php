<form action="<?php echo site_url(); ?>admin_settings/Admin_setting/save_deity_seva" enctype="multipart/form-data" method="post" accept-charset="utf-8" onsubmit="return field_validation()">
	<section id="section-register" class="bg_register">
		<div class="container-fluid sub_reg ">	
		<!-- START Content -->
			<div class="container-fluid container">
			<!-- START Row -->
				<div class="row-fluid">
					<div class="span12 widget lime">               
						<h3 class="registr"><span class="icon icone-crop"></span>Add Seva</h3>                 
					</div>           
				</div>	
				<br/>
				<section class="body">
					<div class="body-inner">    
						<div class="row form-group">
							<div class="control-group col-md-6 col-lg-6 col-sm-6 col-xs-12">
								<label class="control-label color_black">Deity Name <span style="color:#800000;">*</span></label>
								<div class="controls">
									<?php foreach($deity as $result) { ?>
											<?php if($result->DEITY_ID == $id) { ?>
												<input type="hidden" name="deityId" value="<?php echo $result->DEITY_ID; ?>">
											<?php 
												break; 
											} ?>	
										<?php } ?>	
									<?php if($edit == 1) { ?>
										<select class="form-control register_form" id="deity_name" name="deity_name" disabled>	
									<?php  } else { ?>
										<select class="form-control register_form" id="deity_name" name="deity_name">	
									<?php } ?>
										<?php foreach($deity as $result) { ?>
											<?php if($result->DEITY_ID == $id) { ?>
												<option selected value="<?php echo $result->DEITY_ID; ?>"><?php echo $result->DEITY_NAME; ?></option> 
											<?php } else { ?>
												<option value="<?php echo $result->DEITY_ID; ?>"><?php echo $result->DEITY_NAME; ?></option> 
											<?php } ?>		
										<?php } ?>	
									</select>
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
							
							<div class="control-group col-md-6 col-lg-6 col-sm-6 col-xs-12">
								<label class="control-label color_black">Seva Name <span style="color:#800000;">*</span></label>
								<div class="controls">
									<input name="seva_name" id="seva_name" type="text" class="span6  form-control register_form" value="">
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>                    
						</div>
						
						<div class="row form-group">
							<div class="control-group col-md-6 col-lg-6 col-sm-6 col-xs-12">
								<label class="control-label color_black">Seva Description</label>
								<div class="controls">
									<textarea rows="5" name="seva_desc" id="seva_desc" style="resize: none;" class="span6 form-control register_form" ></textarea>
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
							
							<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
								<label class="control-label color_black mandPrice">Seva Price <span style="color:#800000;">*</span></label>
								<label class="control-label color_black unmandPrice" style="display:none;">Seva Price </label>
								<div class="controls">
									<input name="seva_price" id="seva_price" type="text" class="span6  form-control register_form" onkeyup="checkPriceVal(event)" value="">
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
							
							<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
								<label class="control-label color_black">Seva Active <span style="color:#800000;">*</span></label>
								<div class="controls">
									<select class="form-control register_form" id="seva_active" name="seva_active">		
										<option selected value="">Select Status</option>									
										<option value="1">Active</option>
										<option value="0">Deactive</option> 									
									</select>
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
							<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-12" style="margin-top:1.3em;">
								<label class="control-label color_black">Seva Type <span style="color:#800000;">*</span></label>
								<div class="controls">
									<select class="form-control register_form" id="seva_type" name="seva_type">		
										<option selected value="">Select Type</option>									
										<option value="Regular">Regular</option>
										<option value="Occasional">Occasional</option> 									
									</select>
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
						<div class="row form-group">
							<div><label class="control-label color_black" style=";margin-left:15px;margin-top:1.3em;">Seva / Prasad <span style="color:#800000">*</span></label></div>
							<div class="control-group col-md-1 col-lg-1 col-sm-1 col-xs-3" style="margin-left:0em">
								<div class="radio ">
								  <label style="font-weight:bold;"><input id="seva_Radio" type="radio" value="1" name="OptRadio" onclick="GetChangeBorderColor()"> Seva</label>
								</div>
							</div>
							
							<div class="control-group col-md-1 col-lg-1 col-sm-1 col-xs-1">
								<div class="radio">
								  <label style="font-weight:bold;"><input id="prasad_Radio" type="radio" value="0" name="OptRadio" onclick="GetChangeBorderColor()"> Prasad</label> 
								</div>
							</div>
						</div>
						</div>
						
						<div class="row form-group">
						<div><label class="control-label color_black" style=";margin-left:15px;">Seva BelongsTo <span style="color:#800000">*</span></label></div>
							<div class="control-group col-md-1 col-lg-1 col-sm-1 col-xs-2">
								<div class="radio ">
									<label style="font-weight:bold;"><input id="d_Radios" type="radio" value="Deity" name="OptRadios" onclick="GetChangeBorderColor2()" /> Deity</label>
								</div>
							</div>
							<div class="control-group col-md-1 col-lg-1 col-sm-1 col-xs-2 xs">
									<div class="radio ">
											<label style="font-weight:bold;"><input id="s_Radios" type="radio" value="Shashwath" name="OptRadios" onclick="GetChangeBorderColor2()"/> Shashwath</label> 
									</div>
							</div>
							<div class="control-group col-md-1 col-lg-1 col-sm-1 col-xs-2 xs">
								<div class="radio ">
									<label style="font-weight:bold;margin-left:35px;"><input id="ds_Radios" type="radio" value="Deity/Shashwath" name="OptRadios" onclick="GetChangeBorderColor2()"/> Deity/Shashwath</label> 
								</div>
							</div>
							<div class="control-group col-md-1 col-lg-9 col-sm-1 col-xs-2 xs" style="display: none;" id="excludeDiv">
								<div class="radio ">
									<label class="checkbox-inline" style="font-weight:bold;margin-left:21em;margin-top:-3px;"><input type="checkbox" id="Exclude" name="Exclude" onclick="">exclude Shashwath from Deity Sevas Report</label>
								</div>
							</div>
						</div>
						
						<div class="row form-group">
							<div class="control-inline col-md-2 col-lg-1 col-sm-2 col-xs-4" style="font-size:15px;margin-top:1em;">
								<label class="checkbox-inline" style="font-weight:bold;">
									<input type="checkbox" id="revision" name="revision" onclick="selectOnlyThis(this.id)">Revision
								</label>
							</div>
							
							<div class="control-inline col-md-2 col-lg-1 col-sm-2 col-xs-4" style="font-size:15px;margin-top:1em;">
								<label class="checkbox-inline" style="font-weight:bold;">
									<input type="checkbox" id="booking" name="booking" onclick="GetSelect(this.id)">Booking
								</label>
							</div>
							
							<div class="control-inline col-md-2 col-lg-1 col-sm-2 col-xs-4" style="font-size:15px;margin-top:1em;">
								<label class="checkbox-inline" style="font-weight:bold;">
									<input type="checkbox" id="token" name="token">Token
								</label>
							</div>
							<div class="control-group col-md-1 col-lg-8 col-sm-1 col-xs-2 xs" style="display: none;" id="minDiv">
								<div class="form-inline" style="font-weight:bold;margin-left:21em;margin-top:1em;">
									<label for="name">Shashwath Minimum Corpus <span style="color:#800000;">*</span></label>
										<input style="width:130px;font-size:24px;" value="" type="text" class="form-control form_contct2" id="minprice" placeholder="1000" name="minprice">
								</div>
							</div>
						</div>
						
						<div class="row form-group" id="chkDisplay" style="display:none;">	
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<label for="revision">Revision Date <span style="color:#800000;">*</span></label>
								<div class="multiDate">
									<div class="input-group input-group-sm col-lg-6 col-md-6 col-sm-8 col-xs-6">
										<input id="todayDate" name="todayDate" type="datefield" value="" class="form-control todayDate" placeholder="dd-mm-yyyy" />
										<div class="input-group-btn">
											<button class="btn btn-default todayDateBtn" type="button">
												<i class="glyphicon glyphicon-calendar"></i>
											</button>
										</div>
									</div>
								</div>
							</div>
							
							<div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
								<div class="form-inline">
									<label for="name">Revision Price <span style="color:#800000;">*</span></label><br/>
									<input style="width:80px;font-size:24px;" type="text" class="form-control form_contct2" id="price" placeholder="100" name="price">
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
								<button type="submit" class="btn btn-default btn-md custom"><strong>SAVE</strong></button>
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
	//FOR DATEFIELD
	var currentTime = new Date()
    var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
	var maxDate =  new Date(currentTime.getFullYear(), currentTime.getMonth() +12, +0); // one day before next month
    $( ".todayDate" ).datepicker({ 
		minDate: minDate, 
		maxDate: maxDate,
		dateFormat: 'dd-mm-yy'
    });
     
	$('.todayDateBtn').on('click', function() {
		$( ".todayDate" ).focus();
	})
	
	//CONDITION FOR CHECKING ONLY ONE CHECK BOX
	function GetSelect(id) {
		if(document.getElementById(id).checked == false) {
			$('.unmandPrice').css('display', "none");
			$('.mandPrice').css('display', "block");
			$("#revision").attr("disabled", false);
		} else {
			$('.unmandPrice').css('display', "block");
			$('.mandPrice').css('display', "none");
			$("#revision").attr("disabled", true);
			$('#revision').prop('checked', false);
		}
	}
	
	//CONDITION FOR CHECKING ONLY ONE CHECK BOX
	function selectOnlyThis(id) {
		if(document.getElementById(id).checked == true) {
			$('#chkDisplay').fadeIn( "slow" );
			$("#booking").attr("disabled", true);
		} else {
			$('#chkDisplay').fadeOut( "slow" );
			$("#booking").attr("disabled", false);
		}
	}

    function golist(url){
		location.href = "<?php echo site_url();?>"+url;
    }
	
	<!-- Check If Price Is Zero -->
	function checkPriceVal(evt){
		inputPrice = evt.currentTarget;
		if($(inputPrice).val() && Number($(inputPrice).val()) == 0 && $('#seva_type').val() != "Occasional"){
			$(inputPrice).val("");
		} 			
	}
	
	<!-- Seva Name Validation -->
	$('#seva_name').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^A-Za-z0-9(),. ]/g, function(str) { return ''; } ) );
	});
	
	<!-- Seva Desc Validation -->
	$('#seva_desc').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^A-Za-z ]/g, function(str) { return ''; } ) );
	});
	
	<!-- Seva Price Validation -->
	$('#seva_price').keyup(function() {
		if($('#seva_type').val() != "Occasional") {
			var $th = $(this);
			$th.val( $th.val().replace(/[^0-9]/g, function(str) { return ''; } ) );
		}
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
	
	<!-- Change Radio Border Color -->
	function GetChangeBorderColor() {
		$('#seva_Radio').css('border-color', "#00000");
		$('#prasad_Radio').css('border-color', "#000000");
	}
	
	function GetChangeBorderColor2() {
		$('#d_Radios').css('border-color', "#00000");
		$('#s_Radios').css('border-color', "#000000");
		$('#ds_Radios').css('border-color', "#00000");

		if($('#s_Radios').prop('checked') == true || $('#ds_Radios').prop('checked') == true) {
			document.getElementById("excludeDiv").style.display="block";
			document.getElementById("minDiv").style.display="block";
		}
		else{
			document.getElementById("excludeDiv").style.display="none";
			document.getElementById("minDiv").style.display="none";
			document.getElementById("Exclude").checked = false; 
		}
	}
	
	<!-- Validating Fields -->
	function field_validation() {
		var count = 0;
		
		if (document.getElementById("seva_name").value != "") {
			$('#seva_name').css('border-color', "#000000");
		} else {
			$('#seva_name').css('border-color', "#FF0000");
			++count;
		}
		
		if($('#booking').prop('checked') == false) {
			if (document.getElementById("seva_price").value != "") {
				$('#seva_price').css('border-color', "#000000");
			} else {
				$('#seva_price').css('border-color', "#FF0000");
				++count;
			}
		}
		
		if (document.getElementById("seva_type").value != "") {
			$('#seva_type').css('border-color', "#000000");
		} else {
			$('#seva_type').css('border-color', "#FF0000");
			++count;
		}
		
		$('select').each(function(){
			var id = this.id;
			if($('#' + id).val() != "") {
				$('#' + id).css('border-color', "#000000");
			} else {
				$('#' + id).css('border-color', "#FF0000");
				++count;
			}
		});
		
		if($('#seva_Radio').prop('checked') == true || $('#prasad_Radio').prop('checked') == true) {
			$('#seva_Radio').css('border-color', "#000000");
			$('#prasad_Radio').css('border-color', "#000000");
		} else {
			$('#seva_Radio').css('border-color', "#FF0000");
			$('#prasad_Radio').css('border-color', "#FF0000");
			++count;
		}
		
		if($('#d_Radios').prop('checked') == true || $('#s_Radios').prop('checked') == true || $('#ds_Radios').prop('checked') == true) {
			$('#d_Radios').css('border-color', "#000000");
			$('#s_Radios').css('border-color', "#000000");
			$('#ds_Radios').css('border-color', "#000000");
		} else {
			$('#d_Radios').css('border-color', "#FF0000");
			$('#s_Radios').css('border-color', "#FF0000");
			$('#ds_Radios').css('border-color', "#FF0000");
			++count;
		}
		
		if($('#revision').prop('checked') == true) {
			if (document.getElementById("todayDate").value != "") {
				$('#todayDate').css('border-color', "#000000");
			} else {
				$('#todayDate').css('border-color', "#FF0000");
				++count;
			}
			
			if (document.getElementById("price").value != "") {
				$('#price').css('border-color', "#000000");
			} else {
				$('#price').css('border-color', "#FF0000");
				++count;
			}
		} 
		
		if(count != 0) {
			alert("Information","Please fill required fields","OK");
			return false;
		}
	}
</script>