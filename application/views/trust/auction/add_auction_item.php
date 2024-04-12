<form id="formSub" action="<?php echo site_url(); ?>TrustAuction/auction_item_details" enctype="multipart/form-data" method="post" accept-charset="utf-8">
	<div class="container py-3 mt-3">
		<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
		<!--Heading And Refresh Button-->
		<div class="row form-group">
			<div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
				<span class="eventsFont2">Add Auction Item List</span>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
				<a style="width:24px; height:24px" class="pull-right img-responsive" href="<?=site_url()?>TrustAuction/add_auction_item_list" title="Reset"><img src="<?=site_url();?>images/refresh.svg"/></a>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-6 text-left">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;">
					<div class="form-inline">
						<label for="name">Name: <span style="color:#800000;">*</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="text" class="form-control form_contct2" value="<?=@$name;?>" id="name" placeholder="Akash" name="name" style="width: 70%;">
					</div>
				</div>
				
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;">
					<div class="form-inline">
					  <label for="number">Number: <span style="color:#800000;">*</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					  <input type="text" class="form-control form_contct2" id="number" value="<?=@$number;?>" placeholder="9876543210" name="number" style="width: 70%;">
					</div>
				</div>
				
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;">
					<div class="form-inline">
					  <label for="number">Email: </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					  <input type="email" class="form-control form_contct2" id="email" value="<?=@$email;?>" placeholder="akash.svrna@gmail.com" name="email" style="width: 70%;">
					</div>
				</div>
				
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;">
					<div class="form-inline">
					  <label for="number">Address: </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					  <textarea class="form-control" rows="5" id="address" name="address" placeholder="Near Classic Chaya, Santhakatte" style="resize:none;width: 100%;"><?=@$address;?></textarea>
					</div>
				</div>
			</div>
			
			<div class="col-md-6 text-left">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;">
					<label for="number">Event: </label>
					<span class="eventsFont2 samFont"> <?=$event['TET_NAME']; ?></span>
				</div>
				
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="margin-bottom: 2em;">
					<div class="form-group">
					  <label for="item">Item: <span style="color:#800000;">*</span></label>
					  <select onChange="setSaree();" id="item" name="item" class="form-control">
							<option value="">Select Item</option>
							<?php foreach($items as $item)
								echo "<option value='".$item->AI_ID."|".$item->AI_NAME."|".$item->AI_PREFIX."|".$item->AI_STATUS."|".$item->AI_COUNTER."|".$item->USER_ID."'>".$item->AI_NAME."</option>";
							 ?>
					  </select>
					</div>
				</div>
				
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="margin-bottom: 1em;">
					<div class="form-group">
					  <label for="comment">Item Details: <span style="color:#800000;">*</span></label>
					  <textarea class="form-control" rows="2" style="resize:none;" id="sareeDetails" name="sareeDetails"><?=@$itemDetails;?></textarea>
					</div>
				</div>
				
				<div class="saree" style="display:none;">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="margin-bottom: 1em;">
						<div class="form-group">
						  <label for="sareeFor">Saree For: <span style="color:#800000;">*</span></label>
						  <select id="sareeFor" name="sareeFor" class="form-control">
									<option value="">Select Item</option>
									<?php foreach($saree as $item)
										echo "<option value='".$item->AIC_ID."|".$item->AIC_NAME."|".$item->AI_ID."|".$item->AIC_STATUS."'>".$item->AIC_NAME."</option>";
									 ?>
						  </select>
						</div>
					</div>
					
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="margin-bottom: 1em;">
						<div class="form-group">
							<label for="sevaDate">Seva Date: <span style="color:#800000;">*</span></label>
							<div class="input-group input-group-sm">
								<input type="text" id="sevadate" name="sevadate" class="form-control todayDate2" placeholder="dd-mm-yyyy" />
								<div class="input-group-btn">
									<button class="btn btn-default todayDate" type="button">
										<i class="glyphicon glyphicon-calendar"></i>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
					
				<div class="col-lg-12 col-md-12 col-sm-8 col-xs-12">
					<div class="form-group">
					  <label for="number">Item Price: <span style="color:#800000;">*</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					  <input type="text" class="form-control form_contct2" value="<?=@$price;?>" id="price" placeholder="" name="price" style="width: 40%;" onkeyup="checkPriceVal(event)">
					</div>
				</div>
				
				<div class="row form-group" style="margin-left:.3em;">
					<div class="control-group col-md-12 col-lg-12 col-sm-12 col-xs-12">
						<label class="control-label" style="color:#800000;font-size: 12px;"><i>* Indicates mandatory fields.</i></label>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Auction Item Preview</h4>
			</div>
			<div class="modal-body" id="creditdet" style="overflow-y: auto;max-height: 80vmin;">
				
			</div>
			<div class="modal-footer text-left" style="text-align:left;">
				<label>Are you sure you want to save..?</label><br/>
				<button style="width: 8%;" type="button" class="btn btn-default sevaButton" id="submit2">Yes</button>
				<button style="width: 8%;" type="button" class="btn btn-default sevaButton" data-dismiss="modal">No</button>
			</div>
		</div>
	  </div>
	</div>
	
	<!-- HIDDEN FIELDS -->
	<input type="hidden" id="eventId" name="eventId" value="<?=$event['TET_ID']; ?>">
	<input type="hidden" id="eventName" name="eventName" value="<?=$event['TET_NAME']; ?>">
	
	<div class="container">
		<div class="row form-group pull-right">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<button style="padding-left:40px;padding-right:40px;" type="button" onClick="field_validation()" class="btn btn-default btn-lg">Save</button>
			</div>
		</div>
	</div>
</form>
<script>


	$(document).ready(function(){
		$("#name").keypress(function(event){
			var inputValue = event.which;
			// allow letters and whitespaces only.
			if(!(inputValue >= 65 && inputValue <= 122) && (inputValue != 32 && inputValue != 0)) { 
				event.preventDefault(); 
			}
		});
	});

	function setSaree() {
		$item = ($('#item').val()).split("|");
		
		if($item[0] == "2")
			$('.saree').fadeIn( "slow" );
		else
			$('.saree').hide();

	}
	
	<!-- Submit Form -->
	$('#submit2').on('click', function() {
		$('#formSub').submit();
	});
	<!-- Amount Validation -->
	$('#price').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^0-9]/g, function(str) { return ''; } ) );
	});
	
	<!-- Phone Validation -->
	var blnDigitConfirm = false; //When a particular digit is set for 10 or for 11
	var blnDigitSet = 0; //When a particular digit is set in this case 10 digits for mobile number and 11 digits for a landline
	$('#number').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^0-9]/g, function(str) { return ''; } ) );
		
		if(!blnDigitConfirm && $th.val().length <= 11) {
			if($th.val().length == 10) {
				var res = $th.val().match(/^[0][1-9]\d{9}$|^[1-9]\d{9}$/g);
				if(res == $th.val()) { 
					blnDigitConfirm = true;
					blnDigitSet = 10;
				}
				else 
					blnDigitConfirm = false;
			}
			
			if(!blnDigitConfirm && $th.val().length == 11) {
				var res = $th.val().match(/^[0][1-9]\d{9}$|^[1-9]\d{9}$/g);
				if(res == $th.val()) {
					blnDigitConfirm = true;
					blnDigitSet = 11;
				}
				else { 
					if(blnDigitSet == 10) {
						$th.val($th.val().substring(0,10));
						blnDigitConfirm = false;
					}
				}
			}
		} else {
			if(blnDigitSet == 10) {
				$th.val($th.val().substring(0,10));
				blnDigitConfirm = false;
			}
			
			if(blnDigitSet == 11) {
				$th.val($th.val().substring(0,11));
				blnDigitConfirm = false;
			}
		}	
	});
	
	<!-- Check If Price Is Zero -->
	function checkPriceVal(evt){
		inputLS = evt.currentTarget;
		if($(inputLS).val() && Number($(inputLS).val()) == 0){
			$(inputLS).val("");
		} 			
	}
	
	<!-- Validating Fields -->
	function field_validation() {	
		var count = 0;
		let name = document.getElementById("name").value
		let number = document.getElementById("number").value
		let email = document.getElementById("email").value
		let price = document.getElementById("price").value
		let item = $('#item').val();
		let itemSel = $('#item option:selected').text();
		let itemDetails = $('#sareeDetails').val();
		
		let sareeFor = $('#sareeFor').val();
		let sareeForDet = $('#sareeFor option:selected').text();
		let sevadate = $('#sevadate').val();
		let address = $('#address').val();
		let heading = $('.samFont').html();
		
		if($('#number').val() != "") {
			if($('#number').val().length < 10) {
				alert("Information", "Please add a 10 digit mobile or a 11 digit landline.");
				return;
			}
		}
		
		if(item[0] != "2") {
			var res = validate("name", "number", "price","item","sareeDetails","sevadate,", "sareeFor,")
		} else {
			var res = validate("name", "number", "price","item","sareeDetails","sevadate", "sareeFor")
		}
		
		if(res == "") {
			alert("Information","Please fill required fields","OK");
			return false;
		} else {
			let url = "<?=site_url()?>TrustAuction/checkHarivanaExist"
			
			$.post(url, {'item':item,'sareeFor':sareeFor,'sevadate':sevadate},function(e) {
				if(e == "success") {
					$('.modal-body').html("<label class='samFont eventsFont2'><center>"+ heading +"</center></label><br/>");
					$('.modal-body').append("<label>DATE:</label> "+ "<?=date('d-m-Y'); ?>" +"<br/>");
					$('.modal-body').append("<label>NAME:</label> "+ name +"<br/>");
					$('.modal-body').append("<label>NUMBER:</label> "+ number +"<br/>");
					if(email)
						$('.modal-body').append("<label>EMAIL:</label> "+ email +"<br/>");
					
					if(address)
						$('.modal-body').append("<label>ADDRESS:</label> "+ address +"<br/>");	
					$('.modal-body').append("<label>ITEM:</label> "+ itemSel +"<br/>");
					if(itemDetails)
						$('.modal-body').append("<label>ITEM DETAILS:</label> "+ itemDetails +"<br/>");
					if(item[0] == "2") {
						$('.modal-body').append("<label>SAREE FOR:</label> "+ sareeForDet +"<br/>");
						$('.modal-body').append("<label>SEVA DATE:</label> "+ sevadate +"<br/>");
					}
					$('.modal-body').append("<label>AMOUNT:</label> Rs:"+ price +"/-<br/>");
					
					$('.modal').modal();
					$('.bs-example-modal-lg').focus();
					return true;
				} else {
					if(item[0] != "2") {
						$.confirm({
							title: "Information",
							content: "Harivana is already been added for this event",
							type: 'red',
							typeAnimated: true,
							closeIcon:close,
							buttons: {
								tryAgain: {
									text: "OK",
									btnClass: 'btn-red',
									action: function(){						
									}
								},
							}
						});
					} else if(sareeFor[0] == "3") {
						$.confirm({
							title: "Information",
							content: "Immersion Saree is already been added for this event",
							type: 'red',
							typeAnimated: true,
							closeIcon:close,
							buttons: {
								tryAgain: {
									text: "OK",
									btnClass: 'btn-red',
									action: function(){						
									}
								},
							}
						});
					} else if(sareeFor[0] == "1") {
						$.confirm({
							title: "Information",
							content: "Deity Saree is already been added for "+sevadate+" date",
							type: 'red',
							typeAnimated: true,
							closeIcon:close,
							buttons: {
								tryAgain: {
									text: "OK",
									btnClass: 'btn-red',
									action: function(){						
									}
								},
							}
						});
					} else if(sareeFor[0] == "4") {
						$.confirm({
							title: "Information",
							content: "Procession Saree is already been added for this event",
							type: 'red',
							typeAnimated: true,
							closeIcon:close,
							buttons: {
								tryAgain: {
									text: "OK",
									btnClass: 'btn-red',
									action: function(){						
									}
								},
							}
						});
					}
				}
			});
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
	
	//DATEFIELD
	var currentTime = new Date()
	
	var fromDate = "<?=$activeDate[0]->TET_FROM_DATE_TIME; ?>";
	if(fromDate < "<?=date('d-m-Y'); ?>") {
		fromDate = "<?=date('d-m-Y'); ?>";
	}
	
	var toDate = "<?=$activeDate[0]->TET_TO_DATE_TIME; ?>"; 
	fromDate = fromDate.split("-");
	toDate = toDate.split("-");
	
	// var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + (Number(currentTime.getDate())+1)); //one day next before month
	// var maxDate =  new Date(currentTime.getFullYear(), currentTime.getMonth() +12, +0); // one day before next month
	
	var minDate = new Date(Number(fromDate[2]), (Number(fromDate[1])-1), +(Number(fromDate[0]))); 
	var maxDate =  new Date(Number(toDate[2]), (Number(toDate[1])-1), + Number(toDate[0]));
	
	$( ".todayDate2" ).datepicker({ 
		minDate: minDate, 
		maxDate: maxDate,
		dateFormat: 'dd-mm-yy'
	});
	
	$('.todayDate').on('click', function() {
		$( ".todayDate2" ).focus();
	})
</script>