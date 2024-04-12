<div class="container">
    <img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
    <div class="row form-group">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg-10 col-md-10  col-sm-11 col-xs-10">
                <span class="eventsFont2">Bid Auction Item</span>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-1 col-xs-2">
                <a style="width:24px; height:24px" class="pull-right img-responsive" href="<?=site_url()?>TrustAuction/bid_auction_item" title="Reset"><img title="Reset" src="<?=site_url();?>images/refresh.svg"/></a>
            </div>
        </div>
    </div> 
	<form method="post" action="<?=site_url()?>TrustAuction/bid_auction_preview" id="form">
		<div class="row form-group">
			<div class="col-md-6 text-left">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;">
					<label for="number">Event: </label>
					<span class="eventsFont2 samFont"> <?=$event['TET_NAME']; ?></span>
				</div>
				
				<div class="form-inline col-lg-5 col-md-6 col-sm-6 col-xs-12" style="margin-bottom: 1.5em;">
					<div class="form-group">
						<label for="deity">Item:</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<select id="item" name="item" onChange="itemComboChange(this.value)" class="form-control">
							<option value="">Select item</option>
							<?php foreach($items as $item)
								echo "<option value='".$item->AIL_ITEM_ID."|".$item->AIL_ID."|".$item->AIL_ITEM_NAME."'>".$item->AIL_ITEM_NAME."</option>";
							?>
						</select>
					</div>
				</div>
					
				<div class="form-inline col-lg-7 col-md-6 col-sm-6 col-xs-12" style="margin-bottom: 1.5em;">
					<div class="form-group">
						<label for="deity">Item Reference No:</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<select id="itemRef" name="itemRef" onChange="itemRefComboChange(this.value)" class="form-control">
							<option value="">Select Ref No.</option>
							<?php 	foreach($itemsLists as $item) {
										if(($item->AIL_AIC_ID == 1 && $item->AIC_SEVA_DATE != date('d-m-Y')) || ($item->AIL_AIC_ID != 1) && ($item->AIL_AIC_ID != 3)) {
											echo "<option style='display:none;' value='".$item->AIL_ID."|".$item->AIL_NAME."|".$item->AIL_NUMBER."|".$item->AIL_EMAIL."|".$item->AIL_ADDRESS."|".$item->AIL_EVENT_NAME."|".$item->AIL_EVENT_ID."|".$item->ITEM_REF_NO."|".$item->AIL_ITEM_STATUS."|".$item->AIL_ITEM_ID."|".$item->AIL_ITEM_NAME."|".$item->AIL_AIC_ID."|".$item->AIL_AIC_NAME."|".$item->AIC_SEVA_DATE."|".$item->AIL_ITEM_DETAILS."|".$item->AIL_ITEM_PRICE."'>".$item->ITEM_REF_NO."</option>";
										}
									}
							?>
						</select>
					</div>
				</div>
				
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="itemDetails" style="display:none;">
					<div class="form-group">
						<label for="number">Item Details: </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<textarea class="form-control" rows="5" id="itemDet" name="itemDet" placeholder="" style="resize:none;width:100%;" readonly>
						</textarea>
					</div>
				</div>
				
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label class="eventsFont2 samFont" for="number">Minimum Bid Value:</label>
					<label class="eventsFont2 samFont" id="price" name="price"></label>
				</div>
			</div>
			
			<div class="col-md-6 text-left">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;">
					<div class="form-inline">
						<label for="name">Name: <span style="color:#800000;">*</span>
						</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="text" class="form-control form_contct2" id="name" placeholder="Akash" name="name" style="width: 70%;">
					</div>
				</div>
				
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;">
					<div class="form-inline">
						<label for="name">Number: <span style="color:#800000;">*</span>
						</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="text" class="form-control form_contct2" id="phone" placeholder="9876543210" name="phone" style="width: 70%;">
					</div>
				</div>
				
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;">
					<div class="form-inline">
						<label for="name">Email:
						</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="text" class="form-control form_contct2" id="email" placeholder="akash.svrna@gmail.com" name="email" style="width: 70%;">
					</div>
				</div>
				
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;">
					<div class="form-group">
						<label for="number">Address: </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<textarea class="form-control" rows="5" style="resize:none;" style="resize:none;" id="address" name="address" placeholder="" style="width: 100%;"></textarea>
					</div>
				</div>
				
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="form-inline">
						<label for="name">Bid Price: <span style="color:#800000;">*</span>
						</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="text" class="form-control form_contct2" id="bidPrice" placeholder="1" name="bidPrice" style="width: 20%;">
					</div>
				</div>
			</div>
		</div>
	</form>
    <div class="row" style="margin-left:.3em;">
        <div class="col-lg-offset-6 col-lg-6 col-md-offset-6 col-sm-offset-6 col-xs-offset-0 col-sm-6 col-xs-12 col-md-6">
            <div class="row form-group text-left pull-left">
                <div class="control-group col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <br/>
                    <label class="control-label" style="color:#800000;font-size: 12px;"><i>* Indicates mandatory fields.</i>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- HIDDEN FIELDS -->
    <input type="hidden" id="eventId" name="eventId" value="<?=$event['TET_ID']; ?>">
    <input type="hidden" id="eventName" name="eventName" value="<?=$event['TET_NAME']; ?>">

    <div class="row form-group pull-right">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <button style="padding-left: 40px;padding-right: 40px;" type="button" onClick="field_validation()" class="btn btn-default btn-lg"></span>Bid</button>
            </div>
        </div>
	</div>
</div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title">Bid Auction Item Details</h4>
		</div>
		<div class="modal-body" id="creditdet" style="overflow-y: auto;max-height: 80vmin;">
			
		</div>
		
		<div class="modal-footer text-left" style="text-align:left;">
			<label>Are you sure you want to save..?</label><br/>
			<button style="width: 8%;" type="button" class="btn btn-default sevaButton" id="submit">Yes</button>
			<button style="width: 8%;" type="button" class="btn btn-default sevaButton" data-dismiss="modal">No</button>
		</div>
    </div>
  </div>
</div>

<script>
	$('#bidPrice').keyup(function(e) {
		var $th = $(this);
		if(e.keyCode != 46 && e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 38 && e.keyCode != 39 && e.keyCode != 40) {
			$th.val( $th.val().replace(/[^0-9]/g, function(str) { return ''; } ) );
		}return;
	});
	
	<!-- Phone Validation -->
	var blnDigitConfirm = false; //When a particular digit is set for 10 or for 11
	var blnDigitSet = 0; //When a particular digit is set in this case 10 digits for mobile number and 11 digits for a landline
	$('#phone').keyup(function (e) {
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
	
	$('#submit').on('click', function() {
		$('#form').submit();
	});
	
    function itemComboChange(id) {
		$("#itemRef").val("");
		var res = id.split("|");
		$("#itemRef > option").each(function() {
			let id = (this.value).split("|");
			
			if(id[9] == res[0]) {
				$(this).show();
				console.log(this.value);
			}else if(this.value == "") {
				$(this).show();
			}else {
				$(this).hide();
			}
		});
		
    }

	function itemRefComboChange(id) {
		document.getElementById('price').innerHTML = "";
		document.getElementById('itemDet').value = "";
		if(id != "") {
			var res = id.split("|");
			let url = "<?php echo site_url(); ?>TrustAuction/get_saree_details";
			$.post(url,{'id':res[0]}, function(data) {
				if(data){
					var result = data.split("|");
					document.getElementById('price').innerHTML = "Rs:" + result[0] + "/-";
					$("#itemDetails").show();
					document.getElementById('itemDet').value = result[1];
				}
			});
		}
	}
	
    function field_validation() {
		var url = "<?=site_url()?>TrustAuction/saveBid";
		var name = $('#name').val();
		var phone = $('#phone').val();
		var email = $('#email').val();
		var address = $('#address').val();
		var itemDet = $('#itemDet').val();
		var bidPrice = $('#bidPrice').val();
		var item = $('#item').val();
		var itemRef = $('#itemRef').val();
		
		var item1 = $('#item option:selected').text();
		var itemRef1 = $('#itemRef option:selected').text();
		
		if($('#phone').val() != "") {
			if($('#phone').val().length < 10) {
				alert("Information", "Please add a 10 digit mobile or a 11 digit landline.");
				return;
			}
		}
		
		var res = validate("name", "phone", "bidPrice", "item", "itemRef", "itemDet,", "address,", "email,")
		console.log(res);
		if(res != "") {
			$('.modal-body').html("");
			$('.modal-body').append("<div class='col-lg-4 col-md-4 col-sm-4 col-xs-12'><label>Event: "+ "<?=$event['TET_NAME']; ?>" +"</label></div>");
			
			$('.modal-body').append("<div class='col-lg-4 col-md-4 col-sm-4 col-xs-12'><label>Item: "+ item1 +"</label></div>");
			$('.modal-body').append("<div class='col-lg-4 col-md-4 col-sm-4 col-xs-12'><label>Item Reference No: "+ itemRef1 +"</label></div>");
			$('.modal-body').append("<div class='col-lg-4 col-md-4 col-sm-4 col-xs-12'><label>Name: "+ name +"</label></div>");
			if(phone)
				$('.modal-body').append("<div class='col-lg-4 col-md-4 col-sm-4 col-xs-12'><label>Number: "+ phone +"</label></div>");
			if(email)
				$('.modal-body').append("<div class='col-lg-4 col-md-4 col-sm-4 col-xs-12'><label>Email: "+ email +"</label></div>");
			$('.modal-body').append("<div class='col-lg-4 col-md-4 col-sm-4 col-xs-12'><label>Item Details: "+ itemDet +"</label></div>");
			if(address)
				$('.modal-body').append("<div class='col-lg-4 col-md-4 col-sm-4 col-xs-12'><label>Address: "+ address +"</label></div>");
			$('.modal-body').append("<div class='col-lg-4 col-md-4 col-sm-4 col-xs-12'><label>Bid price: "+ bidPrice +"</label></div>");
			$('.modal').modal();
		} else {
			alert("Information","Please fill required fields","OK");
		}
    }
</script>