<form action="<?php echo site_url(); ?>admin_settings/Admin_setting/update_deity_seva" id="form" enctype="multipart/form-data" method="post" accept-charset="utf-8" onsubmit="return field_validation()">
	<section id="section-register" class="bg_register">
		<div class="container-fluid sub_reg ">	
		<!-- START Content -->
			<div class="container-fluid container">
			<!-- START Row -->
				<div class="row-fluid">
					<div class="span12 widget lime">               
						<h3 class="registr"><span class="icon icone-crop"></span>Edit Seva</h3>                 
					</div>           
				</div>	
				<br/>
				<section class="body">
					<div class="body-inner">    
						<div class="row form-group">
							<div class="control-group col-md-6 col-lg-6 col-sm-6 col-xs-12">
								<label class="control-label color_black">Deity Name <span style="color:#800000;">*</span></label>
								<div class="controls">
									<select class="form-control register_form" id="deity_name" name="deity_name" disabled>		
										<?php foreach($deity as $result) { ?>
											<?php if($result->DEITY_ID == $deity_seva[0]->DEITY_ID) { ?>
												<option selected value="<?php echo $result->DEITY_ID; ?>"><?php echo $result->DEITY_NAME; ?></option> 
											<?php } else { ?>
												<option value="<?php echo $result->DEITY_ID; ?>"><?php echo $result->DEITY_NAME; ?></option> 
											<?php } ?>		
										<?php } ?>		
										<!-- HIDDEN FIELDS -->
										<input name="deity_id" id="deity_id" type="hidden" value="<?php echo $deity_seva[0]->DEITY_ID; ?>">
									</select>
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
							
							<div class="control-group col-md-6 col-lg-6 col-sm-6 col-xs-12">
								<label class="control-label color_black">Seva Name <span style="color:#800000;">*</span></label>
								<div class="controls">
									<input name="seva_name" id="seva_name" type="text" class="span6  form-control register_form" value="<?php echo $deity_seva[0]->SEVA_NAME; ?>">
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>                    
						</div>
						
						<div class="row form-group">
							<div class="control-group col-md-6 col-lg-6 col-sm-6 col-xs-12">
								<label class="control-label color_black">Seva Description</label>
								<div class="controls">
									<textarea rows="5" name="seva_desc" id="seva_desc" style="resize: none;" class="span6 form-control register_form" ><?php echo $deity_seva[0]->SEVA_DESC; ?></textarea>
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
							
							<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
								<?php if($deity_seva[0]->BOOKING == 0) { ?>
									<label class="control-label color_black mandPrice">Seva Price <span style="color:#800000;">*</span></label>
									<label class="control-label color_black unmandPrice" style="display:none;">Seva Price </label>
								<?php } else { ?>
									<label class="control-label color_black mandPrice" style="display:none;">Seva Price <span style="color:#800000;">*</span></label>
									<label class="control-label color_black unmandPrice">Seva Price </label>
								<?php } ?>
								<div class="controls">
									<?php if($deity_seva[0]->REVISION_STATUS == 0) { ?>
										<input name="seva_price" id="seva_price" type="text" class="span6  form-control register_form" onkeyup="checkPriceVal(event)" value="<?php echo $deity_seva[0]->SEVA_PRICE; ?>">
										<!-- HIDDEN FIELDS -->
										<input name="price" id="price" type="hidden" value="<?php echo $deity_seva[0]->SEVA_PRICE; ?>">
										<span class="form-input-info positioning" style="color:#FF0000"></span>
									<?php } else { ?>
										<input name="seva_price" id="seva_price" type="text" class="span6  form-control register_form" onkeyup="checkPriceVal(event)" value="<?php echo $deity_seva[0]->OLD_PRICE; ?>">
										<!-- HIDDEN FIELDS -->
										<input name="price" id="price" type="hidden" value="<?php echo $deity_seva[0]->OLD_PRICE; ?>">
										<span class="form-input-info positioning" style="color:#FF0000"></span>
									<?php } ?>
								</div>
							</div>
							
							<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
								<label class="control-label color_black">Seva Active <span style="color:#800000;">*</span></label>
								<div class="controls">
									<select class="form-control register_form" id="seva_active" name="seva_active">		
										<?php if($deity_seva[0]->SEVA_ACTIVE == 0) { ?>
											<option value="1">Active</option>
											<option selected value="0">Deactive</option> 
										<?php } else { ?>
											<option selected value="1">Active</option>
											<option value="0">Deactive</option> 
										<?php } ?>										
									</select>
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
							
							<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-12" style="margin-top:1.3em;">
								<label class="control-label color_black">Seva Type <span style="color:#800000;">*</span></label>
								<div class="controls">
									<select class="form-control register_form" id="seva_type" name="seva_type">		
										<?php if($deity_seva[0]->SEVA_TYPE == "Occasional") { ?>
											<option value="Regular">Regular</option>
											<option selected value="Occasional">Occasional</option> 
										<?php } else { ?>
											<option selected value="Regular">Regular</option>
											<option value="Occasional">Occasional</option> 
										<?php } ?>										
									</select>
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
							
							<div class="row form-group">
								<div><label class="control-label color_black" style=";margin-left:15px;margin-top:1.3em;">Seva / Prasad <span style="color:#800000">*</span></label></div>
								<div class="control-group col-md-1 col-lg-1 col-sm-1 col-xs-2">
									<div class="radio pull-left">
										<?php if($deity_seva[0]->IS_SEVA == 1) { ?>
											<label style="font-weight:bold;"><input id="seva_Radio" type="radio" value="1" name="OptRadio" onclick="GetChangeBorderColor()" checked> Seva</label>
										<?php } else { ?>
											<label style="font-weight:bold;"><input id="seva_Radio" type="radio" value="1" name="OptRadio" onclick="GetChangeBorderColor()"> Seva</label>
										<?php } ?>
									</div>
								</div>
								
								<div class="control-group col-md-1 col-lg-1 col-sm-1 col-xs-2">
									<div class="radio pull-left">
										<?php if($deity_seva[0]->IS_SEVA == 0) { ?>
											<label style="font-weight:bold;"><input id="prasad_Radio" type="radio" value="0" name="OptRadio" onclick="GetChangeBorderColor()" checked> Prasad</label> 
										<?php } else { ?>
											<label style="font-weight:bold;"><input id="prasad_Radio" type="radio" value="0" name="OptRadio" onclick="GetChangeBorderColor()"> Prasad</label> 
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
						
						<div class="row form-group">
						<div><label class="control-label color_black" style=";margin-left:15px;">Seva BelongsTo <span style="color:#800000">*</span></label></div>
							<div class="control-group col-md-1 col-lg-1 col-sm-1 col-xs-2 ">
									<div class="radio ">
										<?php if($deity_seva[0]->SEVA_BELONGSTO == "Deity") { ?>
											<label style="font-weight:bold;"><input id="d_Radios" type="radio" value="Deity" name="OptRadios" onclick="ChangeBorderColor()" checked /> Deity</label>
										<?php } else { ?>
											<label style="font-weight:bold;"><input id="d_Radios" type="radio" value="Deity" name="OptRadios" onclick="ChangeBorderColor()" /> Deity</label>
										<?php } ?>
									</div>
							</div>
							<div class="control-group col-md-1 col-lg-1 col-sm-1 col-xs-2 xs">
									<div class="radio ">
										<?php if($deity_seva[0]->SEVA_BELONGSTO == "Shashwath") { ?>
											<label style="font-weight:bold;"><input id="s_Radios" type="radio" value="Shashwath" name="OptRadios" onclick="ChangeBorderColor()" checked /> Shashwath</label> 
										<?php } else { ?>
											<label style="font-weight:bold;"><input id="s_Radios" type="radio" value="Shashwath" name="OptRadios" onclick="ChangeBorderColor()" /> Shashwath</label> 
										<?php } ?>
									</div>
							</div>
							<div class="control-group col-md-1 col-lg-1 col-sm-1 col-xs-2 xs">
									<div class="radio ">
										<?php if($deity_seva[0]->SEVA_BELONGSTO == "Deity/Shashwath") { ?>
											<label style="font-weight:bold;margin-left:35px;"><input id="ds_Radios" type="radio" value="Deity/Shashwath" name="OptRadios" onclick="ChangeBorderColor()" checked /> Deity/Shashwath</label> 
										<?php } else { ?>
											<label style="font-weight:bold;margin-left:35px;"><input id="ds_Radios" type="radio" value="Deity/Shashwath" name="OptRadios" onclick="ChangeBorderColor()" /> Deity/Shashwath</label> 
										<?php } ?>
									</div>
							</div>
							<div class="control-group col-md-1 col-lg-9 col-sm-1 col-xs-2 xs" style="display: none;" id="excludeDiv">
								<div class="radio ">
									<?php if($deity_seva[0]->SEVA_INCL_EXCL == "Exclude") { ?>
										<label class="checkbox-inline" style="font-weight:bold;margin-left:21em;margin-top:-3px;"><input type="checkbox" id="Exclude" name="Exclude" onclick="" checked>exclude Shashwath from Deity Sevas Report</label>
									<?php } else { ?>
										<label class="checkbox-inline" style="font-weight:bold;margin-left:21em;margin-top:-3px;"><input type="checkbox" id="Exclude" name="Exclude" onclick="">exclude Shashwath from Deity Sevas Report</label>
									<?php } ?>
								</div>
							</div>
						</div>
						
						<div class="row form-group">
							<div class="control-inline col-md-2 col-lg-1 col-sm-4 col-xs-4" style="font-size:15px;margin-top:1em;">
								<label class="checkbox-inline" style="font-weight:bold;">
									<?php if($deity_seva[0]->REVISION_STATUS == 0 && $deity_seva[0]->BOOKING == 0) { ?>
										<input type="checkbox" id="revision" name="revision" onclick="selectOnlyThis(this.id)">Revision
									<?php } else if($deity_seva[0]->REVISION_STATUS == 0 ) { ?>
										<input type="checkbox" id="revision" name="revision" disabled onclick="selectOnlyThis(this.id)">Revision
									<?php } else { ?>	
										<input type="checkbox" id="revision" name="revision" checked onclick="selectOnlyThis(this.id)">Revision
									<?php } ?>
									<!-- HIDDEN FIELDS -->
									<input name="oldStatus" id="oldStatus" type="hidden" value="<?php echo $deity_seva[0]->REVISION_STATUS; ?>">
								</label>
							</div>
							<div class="control-inline col-md-2 col-lg-1 col-sm-4 col-xs-4" style="font-size:15px;margin-top:1em;">
								<label class="checkbox-inline" style="font-weight:bold;">
									<?php if($deity_seva[0]->REVISION_STATUS == 0 && $deity_seva[0]->BOOKING == 0) { ?>
										<input type="checkbox" class = "switch1" id="booking" name="booking" onclick="GetSelect(this.id)">Booking
									<?php } else if( $deity_seva[0]->BOOKING == 0) { ?>
										<input type="checkbox" class = "switch1" id="booking" name="booking" disabled onclick="GetSelect(this.id)">Booking
									<?php } else { ?>	
										<input type="checkbox" class = "switch1" id="booking" name="booking" onclick="GetSelect(this.id)" checked>Booking
									<?php } ?>
									<!-- HIDDEN FIELDS -->
									<input name="bookingStatus" id="bookingStatus" type="hidden" value="<?php echo $deity_seva[0]->BOOKING; ?>">
								</label>
							</div>
							<div class="control-inline col-md-2 col-lg-1 col-sm-4 col-xs-4" style="font-size:15px;margin-top:1em;">
								<label class="checkbox-inline" style="font-weight:bold;">
									<?php if( $deity_seva[0]->IS_TOKEN == 0) { ?>
										<input type="checkbox" class = "switch1" id="token" name="token">Token
									<?php } else { ?>	
										<input type="checkbox" class = "switch1" id="token" name="token" checked>Token
									<?php } ?>
									<!-- HIDDEN FIELDS -->
									<input name="tokenStatus" id="tokenStatus" type="hidden" value="<?php echo $deity_seva[0]->IS_TOKEN; ?>">
								</label>
							</div>
							<div class="control-group col-md-1 col-lg-8 col-sm-1 col-xs-2 xs"  id="minDiv">
								<div class="form-inline" style="font-weight:bold;margin-left:21em;margin-top:1em;">
									<label for="name">Shashwath Minimum Corpus <span style="color:#800000;">*</span></label>
										<input style="width:130px;font-size:24px;" value="<?php echo $deity_seva[0]->SHASH_PRICE; ?>" type="text" class="form-control form_contct2" id="minprice" placeholder="1000" name="minprice">
										<!-- HIDDEN FIELDS -->
										<!-- <input name="oldprice" id="oldprice" type="hidden" value="<?php echo $deity_seva[0]->OLD_PRICE; ?>"> -->
								</div>
							</div>
						</div>
						
						<?php if($deity_seva[0]->REVISION_STATUS == 0) { ?>
							<div class="row form-group" id="chkDisplay" style="display:none;">	
						<?php } else { ?>	
							<div class="row form-group" id="chkDisplay" style="display:block;">	
						<?php } ?>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<label for="revision">Revision Date <span style="color:#800000;">*</span></label>
								<div class="multiDate">
									<div class="input-group input-group-sm col-lg-6 col-md-6 col-sm-8 col-xs-6">
										<input id="todayDate" name="todayDate" type="datefield" value="<?php echo $deity_seva[0]->REVISION_DATE; ?>" class="form-control todayDate" placeholder="dd-mm-yyyy" />
										<!-- HIDDEN FIELDS -->
										<input name="olddate" id="olddate" type="hidden" value="<?php echo $deity_seva[0]->REVISION_DATE; ?>">
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
									<?php if($deity_seva[0]->REVISION_STATUS == 0) { ?>
										<input style="width:80px;font-size:24px;" value="<?php echo $deity_seva[0]->OLD_PRICE; ?>" type="text" class="form-control form_contct2" id="revprice" placeholder="100" name="revprice">
										<!-- HIDDEN FIELDS -->
										<input name="oldprice" id="oldprice" type="hidden" value="<?php echo $deity_seva[0]->OLD_PRICE; ?>">
									<?php } else { ?>
										<input style="width:80px;font-size:24px;" value="<?php echo $deity_seva[0]->SEVA_PRICE; ?>" type="text" class="form-control form_contct2" id="revprice" placeholder="100" name="revprice">
										<!-- HIDDEN FIELDS -->
										<input name="oldprice" id="oldprice" type="hidden" value="<?php echo $deity_seva[0]->SEVA_PRICE; ?>">
									<?php } ?>
								</div>
							</div>
						</div>
						
						<div class="row form-group">
							<div class="control-group col-md-12 col-lg-12 col-sm-12 col-xs-12">
								<label class="control-label" style="color:#800000;font-size: 12px;"><i>* Indicates mandatory fields.</i></label>
							</div>
						</div>
						
						<!-- HIDDEN FIELDS -->
						<input name="seva_id" id="seva_id" type="hidden" value="<?php echo $deity_seva[0]->SEVA_ID; ?>">
						
						<div class="row form-group">
							<div class="control-group col-md-6 col-lg-6 col-sm-6 col-xs-12 text-left">
								<button type="button" onclick="return submitform();" class="btn btn-default btn-md" ><strong>UPDATE</strong></button>
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
	$(document).ready(function(){
		if($('#s_Radios').prop('checked') == true || $('#ds_Radios').prop('checked') == true) {
			document.getElementById("excludeDiv").style.display="block";
			document.getElementById("minDiv").style.display="block";
		}
		else{
			document.getElementById("excludeDiv").style.display="none";
			document.getElementById("minDiv").style.display="none";
		}
	 });

	function submitform(){
		if($('#token').prop('checked') == true) {
			if($('#seva_price').val() == 0 || $('#seva_price').val() == "" ){
				alert("Information","Please enter a valid Seva Price ");	
				return false;
			} else {
		        checkSevasForDeactivation();
			} 
		}
		checkSevasForDeactivation();
	} 

	function checkSevasForDeactivation(){
		let seva_id = $('#seva_id').val();
		let seva_active = $('#seva_active').val();
		let url = "<?=site_url()?>admin_settings/Admin_setting/checkForSeva";
		if(seva_active == 0){
			$.post(url, { 'seva_id': seva_id}, function (e) {
				if(e > 0){
					alert("Information","You cannot Deactive this seva!!. There are active Shashwath sevas","OK");
					return;
				} else {
					$("#form").prop('action','<?php echo site_url(); ?>admin_settings/Admin_setting/update_deity_seva');
					$("#form").submit();
				}
			});
		}else{
			$("#form").prop('action','<?php echo site_url(); ?>admin_settings/Admin_setting/update_deity_seva');
			$("#form").submit();
		}
	}
	
    $("#booking").change(function() {
		if(this.checked) {
			$('#seva_price').val('0');
		} 
    });
    $('input.switch1').on('change', function() {
    $('input.switch1').not(this).prop('checked', false);  
    });   
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
	
	<!-- Change Radio Border Color -->
	function GetChangeBorderColor() {
		$('#seva_Radio').css('border-color', "#000000");
		$('#prasad_Radio').css('border-color', "#000000");
	}
	
	function ChangeBorderColor() {
		$('#d_Radios').css('border-color', "#000000");
		$('#s_Radios').css('border-color', "#000000");
		$('#ds_Radios').css('border-color', "#000000");

		if($('#s_Radios').prop('checked') == true || $('#ds_Radios').prop('checked') == true) {
			document.getElementById("excludeDiv").style.display="block";
			document.getElementById("minDiv").style.display="block";
		}
		else{
			document.getElementById("excludeDiv").style.display="none";
			document.getElementById("minDiv").style.display="none";
		}
	}
	
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