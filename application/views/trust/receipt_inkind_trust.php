<!-- TRUST_INKIND_CODE -->
<div class="container">
	<img class="img-responsive bgImg2 bg1" src="<?=site_url()?>images/TempleLogo.png" />
	<img class="img-responsive bgImg2 bg2" src="<?=site_url()?>images/LAKSHMI.jpg" style="display:none;"/>
	<img class="img-responsive bgImg2 bg3" src="<?=site_url()?>images/HANUMANTHA.jpg" style="display:none;" />
	<img class="img-responsive bgImg2 bg4" src="<?=site_url()?>images/GARUDA.jpg" style="display:none;"/>
	<img class="img-responsive bgImg2 bg5" src="<?=site_url()?>images/GANAPATHI.jpg" style="display:none;"/>
	<!--Heading And Refresh Button-->
	<div class="row form-group">
		<div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
			<span class="eventsFont2">Trust Inkind Receipt</span>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
			<a style="width:24px; height:24px" class="pull-right img-responsive" href="<?=site_url()?>TrustReceipt/receipt_inkind_trust" title="Reset"><img title="Reset" src="<?=site_url();?>images/refresh.svg"/></a>
		</div>
	</div>
	
	<!--Receipt Date And Receipt Number-->
	<div class="row form-group">
		<div class="col-lg-6 col-md-6 col-sm-5 col-xs-12">
			<span class="eventsFont2">Receipt Date: <?=date("d-m-Y")?></span>
		</div>
		<!--<div class="col-lg-6 col-md-6 col-sm-7 col-xs-12">
			<span class="eventsFont2 pull-right">Receipt Number: SLVT/2017-18/IK/1</span>
		</div>-->
	</div>
	
	<div class="row">
	   <div class="col-md-6 text-left">
			<!--Name, Number, Email and Address-->
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;">
				<div class="form-inline">
					<label for="name">Name <span style="color:#800000;">*</span></label></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="text" class="form-control form_contct2" id="name" placeholder="Akash" name="name" style="width: 70%;">
				</div>
			</div>
			
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;">
				<div class="form-inline">
				  <label for="number">Number </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				  <input type="text" class="form-control form_contct2" id="number" placeholder="9876543210" name="number" style="width: 70%;">
				</div>
			</div>

			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;">
				<div class="form-inline">
				  <label for="number">Pan No </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				  <input type="text" class="form-control form_contct2" id="panNo" placeholder="Pan No" name="text" style="width: 70%;">
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;">
				<div class="form-inline">
				  <label for="number">Adhaar No </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				  <input type="text" class="form-control form_contct2" id="adhaarNo" placeholder="Adhaar No" name="text" style="width: 70%;">
				</div>
			</div>
			
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;">
				<div class="form-inline">
				  <label for="number">Email </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				  <input type="text" class="form-control form_contct2" id="email" placeholder="akash.svrna@gmail.com" name="email" style="width: 70%;">
				</div>
			</div>

			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;">
				<div class="form-inline">
					<label><input style="margin-right: 6px;" id="postage" name="postage" onClick="hidePostageAmt(this);" type="checkbox" value="1">Postage</label>
					
					<input style="width:50%;visibility:hidden;" type="text" style="display:hidden;" value='0' class="form-control form_contct2" id="postageAmt" placeholder="Amount" name="postageAmt">
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<input type="text" class="form-control form_contct2" id="addLine1" placeholder="Address Line1" name="addLine1"><br>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<input type="text" class="form-control form_contct2" id="addLine2" placeholder="Address Line2" name="addLine2"><br>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
				<input type="text" class="form-control form_contct2" id="city" placeholder="City" name="city"><br>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding-left:5px;padding-right:5px;">
				<input type="text" class="form-control form_contct2" id="country" placeholder="Country" name="country"><br>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
				<input type="text" class="form-control form_contct2" id="pincode" placeholder="Pincode" name="pincode"><br>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="display:none;margin-bottom: 1.5em;">
				<div class="form-inline">
				  <label for="number">Address </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				  <textarea class="form-control" rows="5" style="resize:none;" id="address" name="address" placeholder="Near Classic Chaya, Santhakatte" style="width: 100%;"></textarea>
				</div>
			</div>
		</div>
		
		<div class="col-md-6 text-left">
			<div class="sevaDate">	
				<!--Event and Amount-->
				<div style="display:none;" class="form-inline col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;">
					<div class="form-group">
						<div class="radio pull-left" style="margin-top: 0.3em;">
						  <label class="radio-inline" style="font-weight: bold;" onclick="GetChangeRadio('deity')"><input id="deity_Radio" type="radio" value="" name="optradio"> Deity</label> 
						</div>&nbsp;&nbsp;
						<select id="deity" name="deity" onChange="deityComboChange();" class="form-control">
							<?php foreach($deity as $result) { ?>
								<option value="<?php echo $result->DEITY_ID ."|". $result->DEITY_NAME ?>"><?php echo $result->DEITY_NAME ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;">
					<label for="number">TO : <span class="eventsFont2 samFont"> SLVSST</span></label>
					
				</div>
			</div>
			<!-- HIDDEN FIELD -->
			<input name="selRadio" id="selRadio" type="hidden">
			<input name="name" id="name" type="hidden">
			<!--Item Donated-->
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="form-inline">
				  <label for="name">Items </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				  <select id="items_inkind" name="items_inkind" class="form-control" onchange="GetOtherTextInput(this.value)">
						<?php foreach ($inkind_item as $results) { ?> 
							<option value = "<?php echo $results->INKIND_ITEM_ID .'/'.$results->INKIND_UNIT .'/'.$results->INKIND_ITEM_NAME; ?>"><?php echo $results->INKIND_ITEM_NAME; ?></option>
						<?php } ?>
						<option value = "Others">Others</option>
				  </select><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				  <input type="text" class="form-control form_contct2" id="item_donated" placeholder="Others" name="item_donated" style="display:none;margin-top:.2em;margin-bottom: .5em;">
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;">
				<div class="form-inline">
					  <label for="name">Estimated Price :  </label></label>
					  <input style="width:100px;padding: 6px 12px;" type="text" class="form_contct2" id="estimatedprice" name="estimatedprice">
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;">
				<div class="form-inline">
					  <label for="name">Description : </label></label>
					  <textarea class="form-control" rows="2" id="paymentNotes" name="paymentNotes" style="resize:none;width: 350px;"></textarea>		  
				</div>	
			</div>
			<!--Quantity-->
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;">
				<div class="form-inline">
				  <label for="name">Quantity <span style="color:#800000;">*</span></label></label>
				  <input style="width:80px;padding: 6px 12px;" type="text" class="form_contct2" id="qty" placeholder="10" name="qty">
				  <input style="width:80px;padding: 6px 12px;" type="text" class="form_contct2" id="unit_measure" placeholder="Kgs" name="unit_measure">
				  <a style="border:none; outline: 0;padding: 6px 12px;" class="form_contct2 add-author" onClick="addRow()" title="Add Item"><img style="border:none; outline: 0;" src="<?php echo base_url(); ?>images/add_icon.svg"></a>
				</div>
			</div>
			<div class="" style="visibility:hidden; margin-bottom: 1.5em;position:absolute;">
					<div class="form-group">
						<div class="radio pull-left" style="margin-top: 0.3em;">
						  <label class="radio-inline" style="font-weight: bold;cursor: default;" onclick="GetChangeRadio('event')"><input style="visibility:hidden;cursor: default;" id="event_Radio" type="radio" value="" name="optradio" checked> Event</label>
						</div>&nbsp;&nbsp;
						<select id="events" name="events" class="form-control">
							<?php foreach($events as $result) { ?>
								<option value="<?php echo $result->TET_ID ."|". $result->TET_NAME ?>"><?php echo $result->TET_NAME ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
			<!--Datagrid-->
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;">
				<div class="table-responsive">
					<table class="table table-bordered" id="inkind-list">
						<thead>
						  <tr>
							<th>Sl.No</th>
							<th>Items</th>
							<th>Qty</th>
							<th>Estimated Price</th>
							<th>Description</th>
							<th>Op</th>
						  </tr>
						</thead>
						<tbody id="eventUpdate">
						 
						</tbody>
					</table>
				</div>
			</div>
			
			<!--Notes-->
			<!-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 1.5em;">
				<div class="form-group">
				  <label for="comment">Notes:</label>
				  <textarea class="form-control" rows="5" style="resize:none;" id="paymentNotes" name="paymentNotes"></textarea>
				</div>
			</div> -->
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
			<h4 class="modal-title">Trust Inkind Preview</h4>
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

<div class="container">
	<div class="row form-group pull-right">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<button type="button" onClick="checkConfirmTime('<?php echo date('d-m-Y');?>');" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-print"></span> Submit & Print</button>
		</div>
	</div>
</div>
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

	$('#pincode').keyup(function(e) {
		var $th = $(this);
		if(e.keyCode != 46 && e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 38 && e.keyCode != 39 && e.keyCode != 40) {
			$th.val( $th.val().replace(/[^0-9]/g, function(str) { return ''; } ) );
		}return;
	});
	
	$('#postageAmt').keyup(function(e) {
		var $th = $(this);
		if(e.keyCode != 46 && e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 38 && e.keyCode != 39 && e.keyCode != 40) {
			$th.val( $th.val().replace(/[^0-9]/g, function(str) { return ''; } ) );
		}return;
	});
	
	function hidePostageAmt(ths) {
		let postageAmt = document.getElementById('postageAmt');
		if(ths.checked) {
			postageAmt.style.visibility='hidden';
			postageAmt.value='';
		} else {
			postageAmt.style.visibility='hidden';
			postageAmt.value='';
		}
	}
	
	$('#submit2').on('click', function() {
		var count = 0;
		if (document.getElementById("name").value != "") {
			$('#name').css('border-color', "#000000");
		} else {
			$('#name').css('border-color', "#FF0000");
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
		
		//Validation For Table
		let url = "<?=site_url()?>TrustReceipt/receipt_inkind_save_trust"
		let tableItem = [];
		let tableQty = [];
		let tableItemId = [];
		let tablePrice = [];
		let tableNotes = [];
		
		tableItemObj = document.getElementsByClassName('tableInkind');
		tableQtyObj = document.getElementsByClassName('tableQty');
		tableItemIdObj = document.getElementsByClassName('tableItemId');
		tablePriceObj = document.getElementsByClassName('tablePrice');
		tableNotesObj = document.getElementsByClassName('tableNotes');
		
		for(let i = 0; i < tableItemObj.length; ++i) {
			tableItem[i] = tableItemObj[i].innerHTML.trim();
			tableQty[i] = tableQtyObj[i].innerHTML.trim();
			tableItemId[i] = tableItemIdObj[i].innerHTML.trim();
			tablePrice[i] = tablePriceObj[i].innerHTML.trim();
			tableNotes[i] = tableNotesObj[i].innerHTML.trim();
		}
		
		if(tableItem == "" && tableQty == "" && tablePrice == "" && tableNotes == "") {
			++count;
		} 
		
		let postage = 0;
		if(document.getElementById("postage").checked == true) {
			postage = 1;
		} else {
			postage = 0;
		}
		let postageAmt = $('#postageAmt').val();
		let addressLine1 = $('#addLine1').val();
		let addressLine2 = $('#addLine2').val();
		let city = $('#city').val();
		let country = $('#country').val();
		let pincode = $('#pincode').val();
		let address = $('#address').val();
		
		if ((document.getElementById("deity_Radio").checked == false) && (document.getElementById("event_Radio").checked == false)) {
			$('#event_Radio').css('border-color', "#FF0000");
			$('#deity_Radio').css('border-color', "#FF0000");
			++count;
		}
		if(tableItem == "") {
			alert("Information","Please add any one item to submit","OK");
			$("#address").val("");
		} else if(count != 0) {
			alert("Information","Please fill required fields","OK");
			$("#address").val("");
		} else {
			$.post(url, {'name':$('#name').val(),'panNo':$('#panNo').val(),'adhaarNo':$('#adhaarNo').val(),'email':$('#email').val(),'number':$('#number').val(),'address':$('#address').val(),'paymentNotes':'','event':$('#events').val(), 'deity':$('#deity').val() ,'selRadio':$('#selRadio').val(),'tableItemId':JSON.stringify(tableItemId),'tableItem':JSON.stringify(tableItem),'tableQty':JSON.stringify(tableQty),'tablePrice':JSON.stringify(tablePrice),'tableNotes':JSON.stringify(tableNotes),'postage': postage, 'postageAmt': postageAmt, 'addressLine1': addressLine1, 'addressLine2': addressLine2, 'city': city, 'country': country, 'pincode': pincode,'address':address}, function(e) {
				if(e == "success")
					location.href = "<?=site_url();?>TrustReceipt/receipt_inkindPrint_trust";
				else {
					alert(e);
				}
			})
		}
	})
	
	//CHANGE IMAGE ON COMBOBOX
	var arr = arr || {};
	var bgNo = 1;
	
	function deityComboChange() {
		arrDeity = ($('#deity').val()).split('|');
		bgNo = arrDeity[0];
		
		for(i = 1; i <= 5; ++i)
			if(i == bgNo)
				$('.bg'+i).slideDown();
			else
				$('.bg'+i).slideUp();
	}

	$(document).ready(function() {
		document.getElementById("events").disabled = false;
			document.getElementById("deity").disabled = true;  
			$('#event_Radio').css('border-color', "#000000");
			$('#deity_Radio').css('border-color', "#000000");
			document.getElementById("selRadio").value = 2;
	});

	//Radio Change
	function GetChangeRadio(selected) {
		if(selected == "deity") {
			document.getElementById("deity").disabled = false;  
			document.getElementById("events").disabled = true;  
			$('#event_Radio').css('border-color', "#000000");
			$('#deity_Radio').css('border-color', "#000000");
			document.getElementById("selRadio").value = 1;
		} else {
			document.getElementById("events").disabled = false;
			document.getElementById("deity").disabled = true;  
			$('#event_Radio').css('border-color', "#000000");
			$('#deity_Radio').css('border-color', "#000000");
			document.getElementById("selRadio").value = 2;
		}
	}

	//Radio Button
	$( document ).ready(function() {
		// document.getElementById("deity").disabled = true;  
		// document.getElementById("events").disabled = true;  
		// document.getElementById("unit_measure").disabled = true;  
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
	
	<!-- Quantity Validation -->
	$('#qty').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^0-9.]/g, function(str) { return ''; } ) );
	});
	$('#estimatedprice').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^0-9]/g, function(str) { return ''; } ) );
	});
	
	<!-- Unit Measure Validation -->
	$('#unit_measure').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^A-Za-z.]/g, function(str) { return ''; } ) );
	});
	
	//COMPARING DATES
	function dateObj(d) { // date parser ...
		var parts = d.split(/:|\s/),
			date  = new Date();
		if (parts.pop().toLowerCase() == 'pm') {
			parts[0] = ((+parts[0]) + 12).toString();
		}
		date.setHours(+parts.shift());
		date.setMinutes(+parts.shift());
		return date;
	}
	
	function checkConfirmTime(date) {
		$.ajax({
            type: "POST",
            url: "<?php echo base_url();?>TrustEvents/check_event_eod_confirm_date_time",
            success: function (response) {
				if(response == 0){
					field_validation();
				} else {
					alert("Information","The EOD for " +date+ " already generated");
				}
			}
        }); 
	}
	<!-- Validating Fields -->
	function field_validation() {
		//TO CHECK FOR TIME ALLOWED TO ENTER
		var startTime = "<?php echo $_SESSION['time'][0]->TIME_FROM; ?>";
		var endTime   = "<?php echo $_SESSION['time'][0]->TIME_TO; ?>";
		var now       = new Date();

		var startDate = dateObj(startTime); // get date objects
		var endDate   = dateObj(endTime);

		var open = now < endDate && now > startDate ? true : false; // compare
		if(open) {
			alert("Information","You are not allowed to book sevas till " + endTime);
			return false;
		} 
		
		if($('#number').val() != "") {
			if($('#number').val().length < 10) {
				alert("Information", "Please add a 10 digit mobile or a 11 digit landline.");
				return;
			}
		}
		
		//TO CHECK FOR TIME ALLOWED TO ENTER
		
		var count = 0;
		if (document.getElementById("name").value != "") {
			$('#name').css('border-color', "#000000");
		} else {
			$('#name').css('border-color', "#FF0000");
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
		
		let name = document.getElementById("name").value;
		let number = document.getElementById("number").value;
		let email = document.getElementById("email").value;
		let panNo = document.getElementById("panNo").value;
		let adhaarNo = document.getElementById("adhaarNo").value;
		let modeOfPayment = $('#modeOfPayment option:selected').val();
		let paymentNotes = $('#paymentNotes').val();
		let address = $('#address').val();
		let chequeNo = $('#chequeNo').val();
		let chequeDate = $('#chequeDate').val();
		let bank = $('#bank').val();
		let branch = $('#branch').val();
		let transactionId = $('#transactionId').val();
		let deity = $('#deity option:selected').html();
		let event = $('#events option:selected').html();
		
		//Validation For Table
		let url = "<?=site_url()?>TrustReceipt/receipt_inkind_save_trust"
		let tableItem = [];
		let tableQty = [];
		let tableItemId = [];
		let tablePrice = [];
		let tableNotes = [];
		
		tableItemObj = document.getElementsByClassName('tableInkind');
		tableQtyObj = document.getElementsByClassName('tableQty');
		tableItemIdObj = document.getElementsByClassName('tableItemId');
		tablePriceObj = document.getElementsByClassName('tablePrice');
		tableNotesObj = document.getElementsByClassName('tableNotes');
		
		for(let i = 0; i < tableItemObj.length; ++i) {
			tableItem[i] = tableItemObj[i].innerHTML.trim();
			tableQty[i] = tableQtyObj[i].innerHTML.trim();
			tableItemId[i] = tableItemIdObj[i].innerHTML.trim();
			tablePrice[i] = tablePriceObj[i].innerHTML.trim();
			tableNotes[i] = tableNotesObj[i].innerHTML.trim();
		}
		
		if(tableItem == "" && tableQty == ""  && tablePrice == "" && tableNotes == "") {
			++count;
		} 
		
		if ((document.getElementById("deity_Radio").checked == false) && (document.getElementById("event_Radio").checked == false)) {
			$('#event_Radio').css('border-color', "#FF0000");
			$('#deity_Radio').css('border-color', "#FF0000");
			++count;
		}
		
		$("#address").val("");
		let ths = document.getElementById('postage');
		let postageAmt = $('#postageAmt'); 
		let addLine1 = $('#addLine1'); 
		let addLine2 = $('#addLine2'); 
		let city = $('#city');
		let country = $('#country');
		let pincode = $('#pincode');
		
		if(ths.checked) {		
			if(addLine1.val().trim().length > 0) {
				address += addLine1.val() + ", ";
				addLine1.css('border-color', "#800000");
			} else {
				addLine1.css('border-color', "#FF0000");
				count++;
			}
			
			if(addLine2.val().trim().length > 0) {
				address += addLine2.val() + ", ";
			}
			
			if(city.val().trim().length > 0) {
				address += city.val() + ", ";
				city.css('border-color', "#800000");
			} else {
				city.css('border-color', "#FF0000");
				count++;
			}
			
			if(country.val().trim().length > 0) {
				address += country.val() + ", ";
				country.css('border-color', "#800000");
			} else {
				country.css('border-color', "#FF0000");
				count++;
			}
			
			if(pincode.val().trim().length > 0) {
				address += pincode.val();
				pincode.css('border-color', "#800000");
			} else {
				pincode.css('border-color', "#FF0000");
				count++;
			}
			
			//address =  + ", " + addLine2.val() + ", " + city.val() + ", " + country.val() + ", " + pincode.val();
			$('#address').val(address);
			$('[data-dismiss=modal]').on('click', function (e) {
				$('#address').val("");
			});
		} else {
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
			$('[data-dismiss=modal]').on('click', function (e) {
				$('#address').val("");
			});
		}
		
		if(tableItem == "") {
			alert("Information","Please add any one item to submit","OK");
			$("#address").val("");
		} else if(count != 0) {
			alert("Information","Please fill required fields","OK");
			$("#address").val("");
		} else {
			
			$('#eventUpdate2').html("");
			$('.modal-body').html('<div class="table-responsive"><table class="table table-bordered"><thead><tr><th><center>Sl. No.</center></th><th>Items</th><th><center>Qty</center></th><th><center>Estimated Price</center></th><th><center>Description</center></th></tr></thead><tbody id="eventUpdate2"></tbody></table></div>')
			let tableItem = [];
			let tableQty = [];
			let tableItemId = [];
			let tablePrice = [];
			let tableNotes = [];

			tableItemObj = document.getElementsByClassName('tableInkind');
			tableQtyObj = document.getElementsByClassName('tableQty');
			tableItemIdObj = document.getElementsByClassName('tableItemId');
			tablePriceObj = document.getElementsByClassName('tablePrice');
			tableNotesObj = document.getElementsByClassName('tableNotes');	
			
			for(let i = 0; i < tableItemObj.length; ++i) {
				$('#eventUpdate2').append("<tr>");
				$('#eventUpdate2').append("<td><center>"+ (i+1) +"</center></td>");
				$('#eventUpdate2').append("<td>"+ tableItemObj[i].innerHTML.trim() +"</td>");
				$('#eventUpdate2').append("<td><center>"+ tableQtyObj[i].innerHTML.trim() +"</center></td>");
				$('#eventUpdate2').append("<td><center>"+ tablePriceObj[i].innerHTML.trim() +"</center></td>");
				$('#eventUpdate2').append("<td><center>"+ tableNotesObj[i].innerHTML.trim() +"</center></td>");
				$('#eventUpdate2').append("</tr>");
			}
			
			$('.modal-body').append("<label>DATE:</label> "+ "<?=date('d-m-Y'); ?>" +"<br/>");
			$('.modal-body').append("<label>NAME:</label> "+ name +"<br/>");
			
			if(number)
				$('.modal-body').append("<label>NUMBER:</label> "+ number +"<br/>");

			if(panNo)
				$('.modal-body').append("<label>PAN NO:</label> "+ panNo +"<br/>");

			if(adhaarNo)
				$('.modal-body').append("<label>ADHAAR NO:</label> "+ adhaarNo +"<br/>");

			if(email)
				$('.modal-body').append("<label>EMAIL:</label> "+ email +"<br/>");
			
			if(address)
				$('.modal-body').append("<label>ADDRESS:</label> "+ address +"<br/>");		
			
			if(ths.checked) {
				if(postageAmt.val().trim().length > 0) {
					$('.modal-body').append("<label>POSTAGE AMOUNT:</label> " + postageAmt.val() + "<br/>");
				}
			}
			if(modeOfPayment == "Cheque") {
				$('.modal-body').append("<label>CHEQUE NO:</label> "+ chequeNo +",&nbsp;&nbsp;");
				$('.modal-body').append("<label>CHEQUE DATE:</label> "+ chequeDate +",&nbsp;&nbsp;");
				$('.modal-body').append("<label>BANK:</label> "+ bank +",&nbsp;&nbsp;");
				$('.modal-body').append("<label>BRANCH:</label> "+ branch +"<br/>");
			
			} else if(modeOfPayment == "Credit / Debit Card") {
					$('.modal-body').append("<label>TRANSACTION ID:</label> "+ transactionId +"<br/>");
			}
				
			// if(paymentNotes)
			// 	$('.modal-body').append("<label>PAYMENT NOTES:</label> "+ paymentNotes +"<br/>");
			
			$('.modal').modal();
			$('.bs-example-modal-lg').focus();
			return false;
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
	
	//SELECT CHANGE
	$('radio').on('change', function() {
		var id = this.id;
		$('#' + id).css('border-color', "#000000");
	});
		
	//Cheque Datefield
	var currentTime = new Date()
	var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
	var maxDate =  new Date(currentTime.getFullYear(), currentTime.getMonth() +12, +0); // one day before next month
	
	$( ".chequeDate2" ).datepicker({
		dateFormat: 'dd-mm-yy'
	});
					
	$('.chequeDate').on('click', function() {
		$( ".chequeDate2" ).focus();
	});
	
	//DEFAULT HIDE TEXT BOX OF INKIND OTHER ITEM
	$( document ).ready(function() {
		$('#item_donated').slideUp();
		$('#unit_measure').val("kgs");
	});
	
	//Display TextBox For Others
	function GetOtherTextInput(item_donated)
	{
		var res = item_donated.split("/");
		if(res[0] == 'Others'){
			$('#item_donated').slideDown();	
			$('#unit_measure').val("");
			$('#unit_measure').val(res[1]);
			$('#qty').val("");
			$("#unit_measure").css('pointer-events', 'auto');
			document.getElementById("unit_measure").disabled = false;  
		} else {
			$('#qty').val("");
			$('#item_donated').slideUp();
			$('#unit_measure').val(res[1]);
			$("#unit_measure").css('pointer-events', 'none');
			document.getElementById("unit_measure").disabled = true;  
		}
	}
	
	//ADD ROW
	var tableContent = [];
	function addRow() {
		var count = 0;
		if($('#items_inkind').val() == "Others") {
			if(document.getElementById("item_donated").value != "") {
				$('#item_donated').css('border-color', "#000000");
			} else {
				$('#item_donated').css('border-color', "#FF0000");
				++count;
			}
			
			if(document.getElementById("qty").value != "") {
				$('#qty').css('border-color', "#000000");
			} else {
				$('#qty').css('border-color', "#FF0000");
				++count;
			}
			
			if(document.getElementById("unit_measure").value != "") {
				$('#unit_measure').css('border-color', "#000000");
			} else {
				$('#unit_measure').css('border-color', "#FF0000");
				++count;
			}
		} else {
			if(document.getElementById("qty").value != "") {
				$('#qty').css('border-color', "#000000");
			} else {
				$('#qty').css('border-color', "#FF0000");
				++count;
			}
			
			if(document.getElementById("unit_measure").value != "") {
				$('#unit_measure').css('border-color', "#000000");
			} else {
				$('#unit_measure').css('border-color', "#FF0000");
				++count;
			}
			// if(document.getElementById("paymentNotes").value != "") {
			// 	$('#paymentNotes').css('border-color', "#000000");
			// } else {
			// 	$('#paymentNotes').css('border-color', "#FF0000");
			// 	++count;
			// }

			// if(document.getElementById("estimatedprice").value != "") {
			// 	$('#estimatedprice').css('border-color', "#000000");
			// } else {
			// 	$('#estimatedprice').css('border-color', "#FF0000");
			// 	++count;
			// }
		}
			
		
		if(count != 0) {
			alert("Information","Please fill required fields","OK");
		} else {
			var data = $('#items_inkind option:selected').val();
			if(data == "Others") {
				data = document.getElementById("qty").value + "/" + document.getElementById("unit_measure").value;
				var items = document.getElementById("item_donated").value;
			} else {
				var items = $('#items_inkind option:selected').text();
			}
			var arr = data.split('/');
			
			if($('#items_inkind option:selected').text() == "Others") {
				var itemid = 0;
			} else {
				var itemid = arr[0];
			}
			var qty = document.getElementById("qty").value + " " +arr[1];
			var estimatedprice = document.getElementById("estimatedprice").value;
			var paymentNotes = document.getElementById("paymentNotes").value;
			let si = $('#inkind-list tr:last-child td:first-child').html();
			if(!si)
				si = 1
			else
				++si;
			
			tableContent[si-1] = '<td class="tableItemId" style="display:none">'+ itemid +'</td><td class="tableInkind">'+ items + '<td class="tableQty">'+ qty + '</td><td class="tablePrice">'+ estimatedprice + '</td><td class="tableNotes">'+ paymentNotes + '</td>';
			
			$('#inkind-list').append('<tr><td>'+si+'</td><td class="tableItemId" style="display:none">'+ itemid +'</td><td class="tableInkind">'+ items + '</td><td class="tableQty">'+ qty + '</td><td class="tablePrice">'+ estimatedprice + '</td><td class="tableNotes">'+ paymentNotes + '</td><td><a style="cursor:pointer;" onClick="updateTable('+ (si-1) +');"><img style="width:24px; height:24px;" title="delete" src="../images/delete1.svg"></td></tr>');
		}
	}
	
	//UPDATE ROW
	function updateTable(si) {
		tableContent2 = [];
		tableContent3 = [];	
		tableContent4 = [];
		tableContent5 = [];
		for(var i = 0, j = 1, s = 0; i < tableContent.length; i++) {
			console.log("i " + i + "\n\n")
			console.log("tableContent2" + tableContent2);
			console.log("tableContent3" + tableContent3);
			if(i != si) {
					tableContent2[s] = '<tr><td>'+ j +'</td>' + tableContent[i] + '<td><a style="cursor:pointer;" onClick="updateTable('+ s +');"><img style="width:24px; height:24px;" title="delete" src="../images/delete1.svg"></td></tr>';
					tableContent3[s] = tableContent[i];
					++j;
					++s;
			}
		}
		
		si = s;
		tableContent = tableContent3;
		console.log(" tableContent " + tableContent.length + " tableContent " + tableContent)
		
		$('#eventUpdate').html(tableContent2)
	}
</script>
