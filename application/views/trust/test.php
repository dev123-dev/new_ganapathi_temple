<style>
.datepicker {
      z-index: 1600 !important; /* has to be larger than 1050 */
} .chequeDate2 {
	z-index: 1600 !important; /* has to be larger than 1050 */
}

th, td {
    padding: 10px;
}

.eventGrey a {
    background-color: green !important;
    background-image :none !important;
    color: #ffffff !important;
}
.eventOrange a {
    background-color: orange !important;
    background-image :none !important;
    color: #ffffff !important;
}
</style>
<div class="container">
	<img class="img-responsive bgImg2 bg1" src="<?=site_url(); ?>images/TempleLogo.png">
	<img class="img-responsive bgImg2 bg2" src="<?=site_url(); ?>images/LAKSHMI.jpg" style="display:none;">
	<img class="img-responsive bgImg2 bg3" src="<?=site_url(); ?>images/HANUMANTHA.jpg" style="display:none;">
	<img class="img-responsive bgImg2 bg4" src="<?=site_url(); ?>images/GARUDA.jpg" style="display:none;">
	<img class="img-responsive bgImg2 bg5" src="<?=site_url(); ?>images/GANAPATHI.jpg" style="display:none;">
	<div class="row form-group">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			
				<span class="eventsFont2">Hall Booking</span>
			</div>
			
			<div style="float:right;" class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
				<a style="width:24px; height:24px" class="pull-right img-responsive" href="<?=site_url(); ?>SevaBooking/book_Seva" titile="Reset">
					<img title="reset" src="<?=site_url(); ?>images/refresh.svg">
				</a>
			</div>
	</div>

	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			
				<span class="eventsFont2">Booking Date: <?=date("d-m-Y"); ?></span>
			
		</div>
	</div>

	<div class="row">
		
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
				<div class="form-group">
					<label for="name">Name
						<span style="color:#800000;">*</span>
					</label>
					<input type="text" class="form-control form_contct2" id="name" placeholder="" name="name">
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
				<div class="form-group">
					<label for="number">Number </label>
					<input type="text" class="form-control form_contct2" id="phone" placeholder="" name="phone">
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<div class="form-group">
					<label for="address">Address </label>
					<input type="text" class="form-control form_contct2" id="address" placeholder="" name="address">
				</div>
			</div>
		
		<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
			
				<div class="form-group">
					<label for="hallCombo">Hall </label>
					<select id="hallCombo" class="form-control">
						<?php foreach($hall as $result) { ?>
							<option data-name="<?=$result->HALL_NAME; ?>" value="<?=$result->HALL_ID; ?>">
								<?=$result->HALL_NAME; ?>
							</option>
						<?php } ?>
					</select>
				</div>
			
		</div>
		<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
			
			<div class="form-group">
				<label for="seva" style="margin-right: 8px;" class="pull-left">Date: <span style="color:#800000;">*</span></label>
			</div>
			<div style="clear:both;" class="multiDate">
				<div class="input-group input-group-sm col-lg-8 col-md-8 col-sm-12 col-xs-12">
					<input id="multiDate" type="text" value="" class="form-control todayDate2" placeholder="dd-mm-yyyy" />
					<div class="input-group-btn">
						<button class="btn btn-default todayDate" type="button">
							<i class="glyphicon glyphicon-calendar"></i>
						</button>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
			
			
			<label class="control-label color_black">Time From</label>
			<div class="controls">
				<div class="input-group bootstrap-timepicker timepicker">
					<input id="timepickerFrom" name="timepickerFrom" type="text" class="form-control input-small">
					<span id="timeFrom" style="background-color:#FBB917;" class="input-group-addon pointer"><i class="glyphicon glyphicon-time"></i></span>
				</div>
				<span class="form-input-info positioning" style="color:#FF0000"></span>
			</div>
		</div>
							
							
		<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
			<label class="control-label color_black">Time To</label>
			<div class="controls">
				<div class="input-group bootstrap-timepicker timepicker">
					<input id="timepickerTo" name="timepickerTo" type="text" class="form-control input-small">
					<span id="timeTo" style="background-color:#FBB917;" class="input-group-addon pointer"><i class="glyphicon glyphicon-time"></i></span>
				</div>
				<span class="form-input-info positioning" style="color:#FF0000"></span>
			</div>
							
		</div>
		<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
			<div style="clear:both;float:right;margin-top: 19px;" class="form-group">
				<div class="radio">
					<a onclick="addRow()">
						<img style="width:24px; height:24px" class="img-responsive pull-right" title="Add Seva" src="<?=site_url(); ?>images/add.svg">
					</a>
				</div>
			</div>
		</div>
		<!-- Row -->
	</div>
	<!-- Row -->
</div>
<div style="clear:both;" class="container">
	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<span id="alreadyBook" style="color:red;font-size:14px;font-weight:900"></span>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			
				<div class="table-responsive">
					<table id="hallTable" class="table table-bordered">
						<thead>
							<tr>
								<th>Hall Name.</th>
								<th>Date</th>
								<th>From</th>
								<th>To</th>
								<th style="width:50px;">Remove</th>
							</tr>
						</thead>
						<tbody id="hallTbody">
						</tbody>
					</table>
				</div>
		</div>
		
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label class="radio-inline"><input type="radio" onclick="changeSubmitButtonText(1)" value="noPayment" name="pymtType" checked>No Payment</label>
			<label class="radio-inline"><input type="radio" onclick="changeSubmitButtonText(0);" value="advancePayment" name="pymtType">Advance Payment</label>
		</div>
		
		<div id="advancePymtDiv" style="display:none;">
			<div style="margin-top:10px;margin-bottom:10px;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="form-inline">
					<label for="name">Amount
						<span style="color:#800000;">*</span>
					</label>
					<input type="text" class="form-control form_contct2" id="advAmt" placeholder="" name="advAmt">
				</div>
			</div>	
			<div id="advancePymtTableTrust" style="display:none;" class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th style="text-align:center;">Trust</th>
							</tr>
						</thead>
						<tbody id="advanceTrustPymtTableBody">
							
						</tbody>
					</table>
				</div>
			</div>

			<div id="advancePymtTableTemple" style="display:none;" class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th style="text-align:center;">Temple</th>
							</tr>
						</thead>
						<tbody id="advanceTemplePymtTableBody">
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div id="headsTrustDisplay" style="display:none;" class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table id="trustTable" class="table table-bordered">
					<thead>
						<tr>
							<th style="text-align:center;" colspan=5>Trust</th>
						</tr>
						<tr>
							<th style="text-align:center;">Name</th>
							<th style="text-align:center;">Amount</th>
							<th style="text-align:center;">Mode of Payment</th>
							<th style="text-align:center;">Payment Notes</th>
							<th style="text-align:center;">Remove</th>
						</tr>
					</thead>
					<tbody id="addHeadsTrust">
						
					</tbody>
				</table>
			</div>
		</div>

		<div id="headsTempleDisplay" style="display:none;" class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table id="templeTable" class="table table-bordered">
					<thead>
						<tr>
							<th style="text-align:center;" colspan=5>Temple</th>
						</tr>
						<tr>
							<th style="text-align:center;">Name</th>
							<th style="text-align:center;">Amount</th>
							<th style="text-align:center;">Mode of Payment</th>
							<th style="text-align:center;">Payment Notes</th>
							<th style="text-align:center;">Remove</th>
						</tr>
					</thead>
					<tbody id="addHeadsTemple">
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
</div>

<div class="container">
	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="row form-group">
					<div class="control-group col-md-12 col-lg-12 col-sm-12 col-xs-12">
						<label class="control-label" style="color:#800000;font-size: 12px;">
							<i>* Indicates mandatory fields.</i>
						</label>
					</div>
				</div>
			
		</div>
	</div>
</div>

<div class="modal modalHeads fade bs-example-modal-md" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="modalHeadsTitle"></h4>
			</div>
			<div class="modal-body" style="overflow-y: auto;max-height: 80vmin;">
				<input type="hidden" id="idHeads">
				<input type="hidden" id="typeHeads">
				<input type="hidden" id="nameHeads">
				<div style="margin-bottom:10px;clear:both;">
					<div class="form-inline">
						<label for="name">Amount
							<span style="color:#800000;">*</span>
						</label>
						<input type="text" class="form-control form_contct2" id="amtModal" min=1 placeholder="" name="advAmt">
					</div>
				</div>

				<div style="clear:both;" class="form-inline">
					<div class="form-group">
						<label for="modeOfPayment">Mode Of Payment:
							<span style="color:#800000;">*</span>
						</label>
						<select id="modeOfPayment" class="form-control">
							<option value="">Select Payment Mode</option>
							<option value="Cash">Cash</option>
							<option value="Cheque">Cheque</option>
							<option value="Direct Credit">Direct Credit</option>
							<option value="Credit / Debit Card">Credit / Debit Card</option>
						</select>
					</div>
	
					<div style="padding-top: 15px; display:none;margin-left: -14px;" id="showChequeList">
						<div class="form-group col-xs-10">
							<label for="name">Cheque No:
								<span style="color:#800000;">*</span>
							</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="text" class="form-control form_contct2" id="chequeNo" placeholder="" name="chequeNo">
						</div>
	
						<div style="padding-top: 15px;" class="form-group col-xs-10">
							<label for="rashi">Cheque Date:
								<span style="color:#800000;">*</span>
							</label>&nbsp;&nbsp;
							<div class="input-group input-group-sm">
								<input id="chequeDate" type="text" value="<?=date(" d-m-Y ")?>" class="form-control chequeDate2 form_contct2" placeholder="dd-mm-yyyy">
								<div class="input-group-btn">
									<button class="btn btn-default chequeDate" type="button">
										<i class="glyphicon glyphicon-calendar"></i>
									</button>
								</div>
							</div>
						</div>
	
						<div style="padding-top: 15px;" class="form-group col-xs-12">
							<label for="number">Bank Name:
								<span style="color:#800000;">*</span>
							</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="text" class="form-control form_contct2" id="bank" placeholder="" name="bank">
						</div>
	
						<div style="padding-top: 15px;" class="form-group col-xs-12">
							<label for="nakshatra">Branch Name:
								<span style="color:#800000;">*</span>
							</label>&nbsp;&nbsp;
							<input type="text" class="form-control form_contct2" id="branch" placeholder="" name="branch">
						</div>
					</div>
	
					<div style="padding-top: 15px; display:none;margin-left: -14px;" id="showDebitCredit">
						<div class="form-group col-xs-10">
							<label for="name">Transaction Id:
								<span style="color:#800000;">*</span>
							</label>&nbsp;&nbsp;
							<input type="text" class="form-control form_contct2" id="transactionId" placeholder="" name="transactionId">
						</div>
					</div>
				</div>

				<div class="form-group" style="clear:both;margin-top:10px;padding-top: 17px;">
					<label for="comment">Payment Notes:</label>
					<textarea class="form-control" rows="5" id="pymtNotes"></textarea>
				</div>
			</div>

			<div class="modal-footer text-left" style="text-align:left;">
				<button type="button" class="btn btn-default addHeads" onClick="addHeads();">Add Head</button>
			</div>
		</div>
	</div>
</div>

<div class="modal previewModal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Hall Booking Preview</h4>
			</div>
			<div class="modal-body previewModalBody" id="creditdet" style="overflow-y: auto;max-height: 80vmin;">

			</div>

			<div class="modal-footer text-left" style="text-align:left;">
				<label>Are you sure you want to save..?</label>
				<br/>
				<button style="width: 8%;" type="button" class="btn btn-default sevaButton" id="submit">Yes</button>
				<button style="width: 8%;" type="button" class="btn btn-default sevaButton" data-dismiss="modal">No</button>
			</div>
		</div>
	</div>
</div>

<input type="hidden" id="radioOpt" value="multiDateRadio">
<!-- single Date -->
<div class="container">
	<center>
		<button type="button" id="changeBtnText" onclick="validateSubmit();" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-submit"></span>Submit</button>
	</center>
</div>
<script>
	$('#timepickerFrom').timepicker({
	defaultTime: ''
});

$('#timepickerTo').timepicker({
	defaultTime: ''
});

function changeSubmitButtonText(rOpt) {
	if(rOpt == "1") {
		$('#advAmt').val(''); 
		$('#changeBtnText').html('<span class="glyphicon glyphicon-submit"></span> Submit'); 
		$('#addHeadsTemple').html('');
		$('#addHeadsTrust').html('');
		$('#headsTempleDisplay').hide();
		$('#headsTrustDisplay').hide();
		$('#advancePymtDiv').hide();
	}else {
		$('#advancePymtDiv').show();
		$('#changeBtnText').html('<span class="glyphicon glyphicon-print"></span> Submit &amp; Print'); 
	}
}

let selBookTime = "";

var arr = arr || {};
var bgNo = 1;
var between = [];
var seva_date = "";
var date_type = "";

$('#multiDateRadio').click();

$('#modeOfPayment').on('change', function () {
		if (this.value == "Cheque") {
			$('#showChequeList').fadeIn("slow");
			$('#showDebitCredit').fadeOut("slow");
		}
		else if (this.value == "Credit / Debit Card") {
			$('#showChequeList').fadeOut("slow");
			$('#showDebitCredit').fadeIn("slow");
		}
		else {
			$('#showChequeList').fadeOut("slow");
			$('#showDebitCredit').fadeOut("slow");
		}

	});

$('#submit').on('click', function () {
	let pymtType = "";

	if(document.getElementsByName("pymtType")[0].checked) {
		pymtType = "noPayment";
	}else {
		pymtType = "payment";
	}

	let count = 0;
	let phone = $('#phone').val()
	let name = $('#name').val()
	let address = $('#address').val();
	let tableContent = getTableValues();
	let templeContent = getTableValuesTemple();
	let trustContent = getTableValuesTrust();

	if (tableContent['hallComboName'].length == 0) {
		alert("Information", "Book atleast one Hall to submit.")
		return;
	}

	if(pymtType != "noPayment") {
		if (templeContent['nameTempleHeads'].length == 0 && trustContent['nameTrustHeads'].length == 0) {
			alert("Information", "Add atleast one Heads to submit.")
			return;
		}

		let checkTotal = checkTotalMatchHeads();
		if(checkTotal.total != checkTotal.advAmt) {
			alert("Information", "Total amount in the receipts in not equal to total amount");
			return;
		}
	}

	if (name) {
		$('#name').css('border-color', "#ccc")
	} else {
		$('#name').css('border-color', "#FF0000")
		++count;
	}

	if (count != 0) {
		alert("Information", "Please fill required fields", "OK");
		return false;
	}

	//get hall booking table values
	tableContent = getJsonTableValues();
	let hellComboId = tableContent['hellComboId'];
	let hallComboName = tableContent['hallComboName'];
	let timepickerFrom = tableContent['timepickerFrom24hrs'];
	let timepickerTo = tableContent['timepickerTo24hrs'];
	let date = tableContent['date'];

	//get Temple table values
	tableContent = getJsonTableTempleValues();
	let idTempleHeads = tableContent['idTempleHeads'];
	let nameTempleHeads = tableContent['nameTempleHeads'];
	let amtTemple = tableContent['amtTemple'];
	let branchTemple = tableContent['branchTemple'];
	let modeOfPaymentTemple = tableContent['modeOfPaymentTemple'];
	let chequeNoTemple = tableContent['chequeNoTemple'];
	let bankTemple = tableContent['bankTemple'];
	let transactionIdTemple = tableContent['transactionIdTemple'];
	let chequeDateTemple = tableContent['chequeDateTemple'];
	let pymtNotesTemple = tableContent['pymtNotesTemple'];

	//get Trust table values
	tableContent = getJsonTableTrustValues();
	let idTrustHeads = tableContent['idTrustHeads'];
	let nameTrustHeads = tableContent['nameTrustHeads'];
	let amtTrust = tableContent['amtTrust'];
	let transactionIdTrust = tableContent['transactionIdTrust'];
	let branchTrust = tableContent['branchTrust'];
	let modeOfPaymentTrust = tableContent['modeOfPaymentTrust'];
	let chequeNoTrust = tableContent['chequeNoTrust'];
	let chequeDateTrust = tableContent['chequeDateTrust'];
	let bankTrust = tableContent['bankTrust'];
	let pymtNotesTrust = tableContent['pymtNotesTrust'];

	
	let url = "<?=site_url()?>Trust/hallBookingSave"
	
	$.post(url, {
		phone,
		name,
		address,
		pymtType,
		hellComboId,
		hallComboName,
		timepickerFrom,
		timepickerTo,
		date,
		idTempleHeads,
		nameTempleHeads,
		amtTemple,
		branchTemple,
		modeOfPaymentTemple,
		chequeNoTemple,
		bankTemple,
		transactionIdTemple,
		chequeDateTemple,
		pymtNotesTemple,
		idTrustHeads,
		nameTrustHeads,
		amtTrust,
		transactionIdTrust,
		branchTrust,
		modeOfPaymentTrust,
		chequeNoTrust,
		chequeDateTrust,
		bankTrust,
		pymtNotesTrust
	}, function(e) {
		if(!e)
			location.href = "<?=site_url(); ?>/Trust/printHallBooking";
	});
});

//COMPARING DATES
function dateObj(d) { // date parser ...
	var parts = d.split(/:|\s/),
		date = new Date();
	if (parts.pop().toLowerCase() == 'pm') {
		parts[0] = ((+parts[0]) + 12).toString();
	}
	date.setHours(+parts.shift());
	date.setMinutes(+parts.shift());
	return date;
}

$('#advAmt').keyup(function () {
	var $th = $(this);
	$th.val($th.val().replace(/[^0-9]/g, function (str) { return ''; }));
});

$('#amtModal').keyup(function () {
	var $th = $(this);
	$th.val($th.val().replace(/[^0-9]/g, function (str) { return ''; }));
});

function validateSubmit() {
	let pymtType = "";

	if(document.getElementsByName("pymtType")[0].checked) {
		pymtType = "noPayment";
	}else {
		pymtType = "payment";
	}

	let count = 0;
	let number = $('#phone').val()
	let name = $('#name').val()
	let address = $('#address').val();
	let tableContent = getTableValues();
	let templeContent = getTableValuesTemple();
	let trustContent = getTableValuesTrust();

	if (tableContent['hallComboName'].length == 0) {
		alert("Information", "Book atleast one Hall to submit.")
		return;
	}

	if(pymtType != "noPayment") {
		if (templeContent['nameTempleHeads'].length == 0 && trustContent['nameTrustHeads'].length == 0) {
			alert("Information", "Add atleast one Heads to submit.")
			return;
		}

		let checkTotal = checkTotalMatchHeads();
		if(checkTotal.total != checkTotal.advAmt) {
			alert("Information", "Total amount in the receipts in not equal to total amount");
			return;
		}
	}

	if (name) {
		$('#name').css('border-color', "#ccc")
	} else {
		$('#name').css('border-color', "#FF0000")
		++count;
	}

	if (count != 0) {
		alert("Information", "Please fill required fields", "OK");
		return false;
	}

	//get hall booking table values
	tableContent = getTableValues();
	let hellComboId = tableContent['hellComboId'];
	let hallComboName = tableContent['hallComboName'];
	let timepickerFrom = tableContent['timepickerFrom'];
	let timepickerTo = tableContent['timepickerTo'];
	let date = tableContent['date'];

	//get Temple table values
	tableContentTemple = getTableValuesTemple();
	let idTempleHeads = tableContentTemple['idTempleHeads'];
	let nameTempleHeads = tableContentTemple['nameTempleHeads'];
	let amtTemple = tableContentTemple['amtTemple'];
	let branchTemple = tableContentTemple['branchTemple'];
	let modeOfPaymentTemple = tableContentTemple['modeOfPaymentTemple'];
	let chequeNoTemple = tableContentTemple['chequeNoTemple'];
	let bankTemple = tableContentTemple['bankTemple'];
	let transactionIdTemple = tableContentTemple['transactionIdTemple'];
	let chequeDateTemple = tableContentTemple['chequeDateTemple'];
	let pymtNotesTemple = tableContentTemple['pymtNotesTemple'];

	//get Trust table values
	tableContentTrust = getTableValuesTrust();
	let idTrustHeads = tableContentTrust['idTrustHeads'];
	let nameTrustHeads = tableContentTrust['nameTrustHeads'];
	let amtTrust = tableContentTrust['amtTrust'];
	let transactionIdTrust = tableContentTrust['transactionIdTrust'];
	let branchTrust = tableContentTrust['branchTrust'];
	let modeOfPaymentTrust = tableContentTrust['modeOfPaymentTrust'];
	let chequeNoTrust = tableContentTrust['chequeNoTrust'];
	let chequeDateTrust = tableContentTrust['chequeDateTrust'];
	let bankTrust = tableContentTrust['bankTrust'];
	let pymtNotesTrust = tableContentTrust['pymtNotesTrust'];

	$('.previewModalBody').html("<label>DATE:</label> " + "<?=date('d-m-Y'); ?>");
	$('.previewModalBody').append(",&nbsp;&nbsp;<label>NAME:</label> " + name + "");
	if (number)
		$('.previewModalBody').append(",&nbsp;&nbsp;<label>NUMBER:</label> " + number + "");
	
	if (address)
		$('.previewModalBody').append(",&nbsp;&nbsp;<label>address:</label> " + number + "");

	$('.previewModalBody').append("<br/>");

	$('#eventUpdate2').html("");

	$('.previewModalBody').append('<div class="table-responsive"><table class="table table-bordered"><thead><tr><th>Hall Name</th><th>Date</th><th><center>From</center></th><th><center>To</center></th></tr></thead><tbody id="eventUpdate2"></tbody></table></div>')

	for (i = 0; i < tableContent.hallComboName.length; ++i) {
		$('#eventUpdate2').append("<tr>");
		$('#eventUpdate2').append("<td><center>" + tableContent['hallComboName'][i].innerHTML + "</center></td>");
		$('#eventUpdate2').append("<td><center>" + tableContent['date'][i].innerHTML + "</center></td>");
		$('#eventUpdate2').append("<td>" + tableContent['timepickerFrom'][i].innerHTML + "</td>");
		$('#eventUpdate2').append("<td>" + tableContent['timepickerTo'][i].innerHTML + "</td>");
		$('#eventUpdate2').append("</tr><br/>");
	}
	if(pymtType != "noPayment") {
		$('.previewModalBody').append('<br/><div class="table-responsive"><table class="table table-bordered"><thead><tr><th style="text-align:center;" colspan=5>Trust</th></tr><tr><th>Name</th><th>Amount</th><th><center>Payment Details</center></th><th><center>Payment Notes</center></th></tr></thead><tbody id="eventUpdate3"></tbody></table></div>');

	
	//trust
	for (i = 0; i < tableContentTrust.nameTrustHeads.length; ++i) {
		$('#eventUpdate3').append("<tr>");
		$('#eventUpdate3').append("<td><center>" + tableContentTrust['nameTrustHeads'][i].innerHTML + "</center></td>");
		$('#eventUpdate3').append("<td><center>" + tableContentTrust['amtTrust'][i].innerHTML + "</center></td>");
		modeOfPayment = tableContentTrust['modeOfPaymentTrust'][i].innerHTML;
			if (modeOfPayment == "Cheque") {
				$('#eventUpdate3').append("<td><label>Mode Of Payment:</label> " + modeOfPayment + ",&nbsp;&nbsp;<label>CHEQUE NO:</label> " + chequeNoTrust[i].innerHTML + ",&nbsp;&nbsp;<label>CHEQUE DATE:</label> " + chequeDateTrust[i].innerHTML + ",&nbsp;&nbsp;<label>BANK:</label> " + bankTrust[i].innerHTML + ",&nbsp;&nbsp;<label>BRANCH:</label> " + branchTrust[i].innerHTML + "</td>");
				
			}else if (modeOfPayment == "Credit / Debit Card") {
				$('#eventUpdate3').append("<td><label>Mode Of Payment:</label> " + modeOfPayment + ",&nbsp;&nbsp;" + "<label>TRANSACTION ID:</label> " + transactionIdTrust[i].innerHTML + "</td>");
			}else {
				$('#eventUpdate3').append("<td><label>Mode Of Payment:</label> " + modeOfPayment + ",&nbsp;&nbsp;" + "</td>");
			}

		$('#eventUpdate3').append("<td>" + tableContentTrust['pymtNotesTrust'][i].innerHTML + "</td>");
		$('#eventUpdate3').append("</tr><br/>");
	}

	$('.previewModalBody').append('<br/><div class="table-responsive"><table class="table table-bordered"><thead><tr><th style="text-align:center;" colspan=5>Temple</th></tr><tr><th>Name</th><th>Amount</th><th><center>Payment Details</center></th><th><center>Payment Notes</center></th></tr></thead><tbody id="eventUpdate4"></tbody></table></div>');

	//trust
	for (i = 0; i < tableContentTemple.nameTempleHeads.length; ++i) {
		$('#eventUpdate4').append("<tr>");
		$('#eventUpdate4').append("<td><center>" + tableContentTemple['nameTempleHeads'][i].innerHTML + "</center></td>");
		$('#eventUpdate4').append("<td><center>" + tableContentTemple['amtTemple'][i].innerHTML + "</center></td>");
		modeOfPayment = tableContentTemple['modeOfPaymentTemple'][i].innerHTML;
			if (modeOfPayment == "Cheque") {
				$('#eventUpdate4').append("<td><label>Mode Of Payment:</label> " + modeOfPayment + ",&nbsp;&nbsp;<label>CHEQUE NO:</label> " + chequeNoTemple[i].innerHTML + ",&nbsp;&nbsp;<label>CHEQUE DATE:</label> " + chequeDateTemple[i].innerHTML + ",&nbsp;&nbsp;<label>BANK:</label> " + bankTemple[i].innerHTML + ",&nbsp;&nbsp;<label>BRANCH:</label> " + branchTemple[i].innerHTML + "</td>");
				
			}else if (modeOfPayment == "Credit / Debit Card") {
				$('#eventUpdate4').append("<td><label>Mode Of Payment:</label> " + modeOfPayment + ",&nbsp;&nbsp;" + "<label>TRANSACTION ID:</label> " + transactionIdTemple[i].innerHTML + "</td>");
			}else {
				$('#eventUpdate4').append("<td><label>Mode Of Payment:</label> " + modeOfPayment + ",&nbsp;&nbsp;" + "</td>");
			}

		$('#eventUpdate4').append("<td>" + tableContentTemple['pymtNotesTemple'][i].innerHTML + "</td>");
		$('#eventUpdate4').append("</tr><br/>");
	}
}
	// $('.modal-body').append("<label>TOTAL AMOUNT:</label> " + total + "<br/>");

	// $('.modal-body').append("<label>MODE OF PAYMENT:</label> " + modeOfPayment + "<br/>");

	// if (modeOfPayment == "Cheque") {
	// 	$('.modal-body').append("<label>CHEQUE NO:</label> " + chequeNo + ",&nbsp;&nbsp;");
	// 	$('.modal-body').append("<label>CHEQUE DATE:</label> " + chequeDate + ",&nbsp;&nbsp;");
	// 	$('.modal-body').append("<label>BANK:</label> " + bank + ",&nbsp;&nbsp;");
	// 	$('.modal-body').append("<label>BRANCH:</label> " + branch + "<br/>");


	// } else if (modeOfPayment == "Credit / Debit Card") {
	// 	$('.modal-body').append("<label>TRANSACTION ID:</label> " + transactionId + "<br/>");
	// }

	// if (paymentNotes)
	// 	$('.modal-body').append("<label>PAYMENT NOTES:</label> " + paymentNotes + "");

	$('.previewModal').modal();
	$('.bs-example-modal-lg').focus();

}

var price = 0;
var total = 0;

function checkDateTime(timepickerFrom1, timepickerTo1) {
	let hallCombo = $('#hallCombo option:selected');
	let selDate = $("#multiDate").val();
	// let name = $('#name').val();
	let hellComboId = hallCombo.val();

	let resevedTimeFrom = "";
	let resevedTimeTo = "";

	let calTimepickerFrom = convertTimeTo24hrs(timepickerFrom1);
	let calTimepickerTo = convertTimeTo24hrs(timepickerTo1);
	
	let userFromTime = new Date(<?=time(); ?>);
	userFromTime.setHours(calTimepickerFrom.split(":")[0]);
	userFromTime.setMinutes(calTimepickerFrom.split(":")[1]);
	userFromTime.setSeconds(calTimepickerFrom.split(":")[2]);

	let userToTime = new Date(<?=time(); ?>);
	userToTime.setHours(calTimepickerTo.split(":")[0]);
	userToTime.setMinutes(calTimepickerTo.split(":")[1]);
	userToTime.setSeconds(calTimepickerTo.split(":")[2]);

	if(userFromTime >= userToTime) {
		$('#timepickerFrom').css({"border-color":"red"});
		$('#timepickerTo').css({"border-color":"red"});
		alert("Information", "Please fill required fields", "OK");
		return false;
	}else {
		$('#timepickerFrom').css({"border-color":"black"});
		$('#timepickerTo').css({"border-color":"black"});
	}
	
	if(selBookTime) {
		let highlight = selBookTime.split("|");
		for(let i = 0; i < highlight.length-1; ++i) {
			resevedTimeFrom = highlight[i];
			resevedTimeTo = highlight[++i];

			console.log()
			
			// resevedTimeFromHours = Number(resevedTimeFrom.split(":")[0]);
			// resevedTimeFromMin = Number(resevedTimeFrom.split(":")[1]);
			// resevedTimeToHours = Number(resevedTimeTo.split(":")[0]);
			// resevedTimeToMin = Number(resevedTimeTo.split(":")[1]);

			var reservedFromTime = new Date(<?=time(); ?>);
			reservedFromTime.setHours(resevedTimeFrom.split(":")[0]);
			reservedFromTime.setMinutes(resevedTimeFrom.split(":")[1]);
			reservedFromTime.setSeconds(resevedTimeFrom.split(":")[2]);

			var reservedToTime = new Date(<?=time(); ?>);
			reservedToTime.setHours(resevedTimeTo.split(":")[0]);
			reservedToTime.setMinutes(resevedTimeTo.split(":")[1]);
			reservedToTime.setSeconds(resevedTimeTo.split(":")[2]);
			
			
			if(resevedTimeFrom == calTimepickerFrom && resevedTimeTo == calTimepickerTo) {
				alert("Information","Selected Hall is reserved from "+ convertTimeTo12hrs(resevedTimeFrom) + " to " + convertTimeTo12hrs(resevedTimeTo));
				return false;
			}
			
			if(reservedFromTime < userFromTime && reservedToTime > userFromTime) {
				alert("Information","Selected Hall is reserved from "+ convertTimeTo12hrs(resevedTimeFrom) + " to " + convertTimeTo12hrs(resevedTimeTo));
				return false;
			}
			
			if(reservedFromTime < userToTime && reservedToTime > userToTime) {
				alert("Information","Selected Hall is reserved from "+ convertTimeTo12hrs(resevedTimeFrom) + " to " + convertTimeTo12hrs(resevedTimeTo));
				return false;
			}
			
			if(userFromTime < reservedFromTime && userToTime > reservedFromTime) {
				alert("Information","Selected Hall is reserved from "+ convertTimeTo12hrs(resevedTimeFrom) + " to " + convertTimeTo12hrs(resevedTimeTo));
				return false;
			}
			
			if(userFromTime < reservedToTime && userToTime > reservedToTime) {
				alert("Information","Selected Hall is reserved from "+ convertTimeTo12hrs(resevedTimeFrom) + " to " + convertTimeTo12hrs(resevedTimeTo));
				return false;
			}
		}
		
		//check table for reserved time with input
		
	}
	
	let gettime = getJsonTableValues();
	let tableTimeFrom = JSON.parse(gettime.timepickerFrom);
	let tableTimeTo = JSON.parse(gettime.timepickerTo)
	let tablehellCombo = JSON.parse(gettime.hellComboId)
	let tableselDate = JSON.parse(gettime.date)
	
	for(let j =0; j < tableTimeFrom.length; ++j) {

		if(tablehellCombo[j] == hellComboId && selDate == tableselDate[j]) {
		
			resevedTimeFrom = convertTimeTo24hrs(tableTimeFrom[j]);
			resevedTimeTo = convertTimeTo24hrs(tableTimeTo[j]);

			console.log(resevedTimeFrom)
			console.log(resevedTimeTo)
			
			// resevedTimeFromHours = Number(resevedTimeFrom.split(":")[0]);
			// resevedTimeFromMin = Number(resevedTimeFrom.split(":")[1]);
			// resevedTimeToHours = Number(resevedTimeTo.split(":")[0]);
			// resevedTimeToMin = Number(resevedTimeTo.split(":")[1]);

			reservedFromTime = new Date(<?=time(); ?>);
			reservedFromTime.setHours(resevedTimeFrom.split(":")[0]);
			reservedFromTime.setMinutes(resevedTimeFrom.split(":")[1]);
			reservedFromTime.setSeconds(resevedTimeFrom.split(":")[2]);

			reservedToTime = new Date(<?=time(); ?>);
			reservedToTime.setHours(resevedTimeTo.split(":")[0]);
			reservedToTime.setMinutes(resevedTimeTo.split(":")[1]);
			reservedToTime.setSeconds(resevedTimeTo.split(":")[2]);
			
			console.log(reservedFromTime)
			console.log(reservedToTime)
			
			if(resevedTimeFrom == calTimepickerFrom && resevedTimeTo == calTimepickerTo) {
				alert("Information","Selected Hall is reserved from "+ convertTimeTo12hrs(resevedTimeFrom) + " to " + convertTimeTo12hrs(resevedTimeTo));
				return false;
			}
			
			if(reservedFromTime < userFromTime && reservedToTime > userFromTime) {
				alert("Information","Selected Hall is reserved from "+ convertTimeTo12hrs(resevedTimeFrom) + " to " + convertTimeTo12hrs(resevedTimeTo));
				return false;
			}
			
			if(reservedFromTime < userToTime && reservedToTime > userToTime) {
				alert("Information","Selected Hall is reserved from "+ convertTimeTo12hrs(resevedTimeFrom) + " to " + convertTimeTo12hrs(resevedTimeTo));
				return false;
			}
			
			if(userFromTime < reservedFromTime && userToTime > reservedFromTime) {
				alert("Information","Selected Hall is reserved from "+ convertTimeTo12hrs(resevedTimeFrom) + " to " + convertTimeTo12hrs(resevedTimeTo));
				return false;
			}
			
			if(userFromTime < reservedToTime && userToTime > reservedToTime) {
				alert("Information","Selected Hall is reserved from "+ convertTimeTo12hrs(resevedTimeFrom) + " to " + convertTimeTo12hrs(resevedTimeTo));
				return false;
			}
		}
	}
	return true;
}

function addRow() {
	// let tableContent = getTableValues();
	
	let duplicate = checkDuplicate();
	if (duplicate != 0)
		return;

	let hallCombo = $('#hallCombo option:selected');

	// let name = $('#name').val();
	let hellComboId = hallCombo.val();
	let hallComboName = hallCombo.attr("data-name");
	let timepickerFrom = $('#timepickerFrom').val();
	let timepickerTo = $('#timepickerTo').val();

	$('#advancePymtTableTemple').hide();
	$('#advancePymtTableTrust').hide();

	if(!checkDateTime(timepickerFrom, timepickerTo)) {
		selBookTime = "";
		
		return;
	}
	
	let date = "";
	let count = "";

	date = $("#multiDate").val();

	count = validate("multiDate");

	if (!count) {
		alert("Information", "Please fill required fields", "OK");
		return;
	}

	let si = $('#hallTable tr:last-child td:first-child').html();
	if (!si)
		si = 1
	else
		++si;

	let amt = 0;

	$('#multiDate').val("");
	$('#selDate').html("");
	$('#multiDate').datepicker('setDate', null);

	$('#hallTable').append('<tr class="' + si + ' si1"><td style="display:none;" class="si">' + si + '</td><td style="display:none;" class="hellComboId">' + hellComboId + '</td><td style="display:none;" class="timepickerFrom24hrs">' + convertTimeTo24hrs(timepickerFrom) + '</td><td style="display:none;" class="timepickerTo24hrs">' + convertTimeTo24hrs(timepickerTo) + '</td><td class="hallComboName">' + hallComboName + '</td><td class="date">' + date + '</td><td class="timepickerFrom">' + timepickerFrom + '</td><td class="timepickerTo">' + timepickerTo + '</td><td class="link1"><a style="cursor:pointer;" onClick="updateTable(' + si + ');"><img style="width:24px; height:24px;" title="delete" src="<?=site_url(); ?>images/delete1.svg"></a></td></tr>');
	si++;

	// $('#addHeadsTemple').html("");
	// $('#addHeadsTrust').html("");
	// $('#headsTempleDisplay').hide();
	// $('#headsTrustDisplay').hide();

	populateHeadsTable()
}

function populateHeadsTable() {
	$('#advanceTrustPymtTableBody').html("");
	$('#advanceTemplePymtTableBody').html("");
	let tableContent2 = getJsonTableValues();
	
	if(getTableValues().date.length == 0) {
		return;
	}

	let hallId = [];
	
	let tabs = JSON.parse(tableContent2.hellComboId);
	
	$.each(tabs, function(i, el){
		if($.inArray(el, hallId) === -1) hallId.push(el);
	});
	
	let url = "<?=site_url()?>Trust/getFinancialHeads"
	$.post(url, {
		hallId:JSON.stringify(hallId)
	},function(e) {
		let t = JSON.parse(e);
		let templeCatId = [2,3];
		let templeName = ["Donation", "Kanike"];
		let FH_ID = [];
		
		if(t.length == 0) {
			$('#advancePymtTableTrust').hide();
		}else {
			$('#advancePymtTableTrust').show();
		}

		let y = getTableValuesTrust();
		console.log(y);
		for(let i = 0; i < t.length; ++i) {
			FH_ID.push(t[i]['FH_ID'].trim());
			let tVal = `<tr><th style="text-align:center;"><a style="color:#800000" title="Add Trust Heads" onClick="callHeadsModal('${t[i]['FH_ID']}', '${t[i]['FH_NAME']}', 'trust');">${t[i]['FH_NAME']}</a></th></tr>`;

			$('#advanceTrustPymtTableBody').append(tVal);
		}
		
		//$('#addHeadsTrust').html("");
		
		console.log(FH_ID)
		let trustHeads = getTableValuesTrust();//document.getElementsByClassName("idTrustHeads");
		let tableHeadId = "";
		let siTrust = [];
		let w = 0;
		for(let j = 0; j < trustHeads.idTrustHeads.length; j++) {
			if(w == 1) {
				j = 0;
			}
			if(FH_ID.includes(trustHeads.idTrustHeads[j].innerHTML.trim())) {
				w = 0;
			} else {
				siTrust.push(trustHeads.idTrustHeads[j].innerText.trim())
				trustHeads.idTrustHeads[j].parentNode.remove();
				updateTrustTable(0);
				trustHeads = getTableValuesTrust();
				j = 0;
				w = 1;
			}
		}
		
		updateTrustTable(0);
		
		console.log("siTrust");
		console.log(siTrust);

			if(templeName.length == 0) {
				$('#advancePymtTableTemple').hide();
			}else {
				$('#advancePymtTableTemple').show();
			}
		for(let k = 0; k < templeName.length; ++k) { 
			let tVal = `<tr><th style="text-align:center;"><a style="color:#800000" title="Add Temple Heads" onClick="callHeadsModal('${templeCatId[k]}', '${templeName[k]}', 'temple');">${templeName[k]}</a></th></tr>`;

			$('#advanceTemplePymtTableBody').append(tVal);
		}
	});
}

function callHeadsModal(id, name, type) {
	let advAmt = $('#advAmt').val();
	$('#amtModal').css({"border-color":"black"})
	$("#modeOfPayment").val("");
	$("#amtModal").val("");
	$("#chequeNo").val("");
	$("#chequeDate").val("");
	$("#bank").val("");
	$("#branch").val("");
	$("#pymtNotes").val("");
	$("#transactionId").val("");

	$('#modeOfPayment').trigger("change");

	if (advAmt != "0" && advAmt != "") {
		$('#advAmt').css('border-color', "#800000");
	} else {
		$('#advAmt').css('border-color', "#FF0000");
		alert("Information","Please fill the Amount");
		return;
	}

	$('#idHeads').val(id);
	$('#typeHeads').val(type);
	$('#nameHeads').val(name);
	$('#modalHeadsTitle').html("Add " + name + " Head");

	$('.modalHeads').modal();
}

function getJsonTableValues() {
	let tableContent = getTableValues();
		let hellComboId = [];
		let hallComboName = [];
		let timepickerFrom = [];
		let timepickerTo = [];
		let date = [];
		let timepickerTo24hrs = [];
		let  timepickerFrom24hrs = [];
		

		for (i = 0; i < tableContent['hallComboName'].length; ++i) {
			hellComboId[i] = tableContent['hellComboId'][i].innerHTML;
			hallComboName[i] = tableContent['hallComboName'][i].innerHTML;
			timepickerFrom[i] = tableContent['timepickerFrom'][i].innerHTML;
			timepickerTo[i] = tableContent['timepickerTo'][i].innerHTML;
			date[i] = tableContent['date'][i].innerHTML;
			timepickerTo24hrs[i] = tableContent['timepickerTo24hrs'][i].innerHTML;
			timepickerFrom24hrs[i] = tableContent['timepickerFrom24hrs'][i].innerHTML;
		}

		return {
			"hellComboId": JSON.stringify(hellComboId),
			"hallComboName": JSON.stringify(hallComboName),
			"timepickerFrom": JSON.stringify(timepickerFrom),
			"timepickerTo": JSON.stringify(timepickerTo),
			"date": JSON.stringify(date),
			"timepickerTo24hrs": JSON.stringify(timepickerTo24hrs),
			"timepickerFrom24hrs": JSON.stringify(timepickerFrom24hrs),
		}

}

function updateTable(si) {
	let si1 = document.getElementsByClassName(si);
	si1[0].remove();
	let tableValues = getTableValues();

	for (let i = 0; i < tableValues['hallComboName'].length; ++i) {
		tableValues['si'][i].innerHTML = (i + 1);
		tableValues['link1'][i].innerHTML = '<a style="cursor:pointer;" onClick="updateTable(' + (i + 1) + ');"><img style="width:24px; height:24px;" title="delete" src="<?=site_url(); ?>images/delete1.svg"></a>';
		tableValues['si1'][i].className = (i + 1) + " si1";
	}

	// $('#addHeadsTemple').html("");
	// $('#addHeadsTrust').html("");
	// $('#headsTempleDisplay').hide();
	// $('#headsTrustDisplay').hide();

	populateHeadsTable();
}

$('#hallCombo').on('change', function() {
	$('#multiDate').datepicker('setDate', null);
	$('#multiDate').datepicker('destroy');
	

	let hallCombo = $('#hallCombo option:selected');
	let hellComboId = hallCombo.val();
	let hallComboName = hallCombo.attr("data-name");

	var currentTime = new Date()
	var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
	var maxDate = new Date(currentTime.getFullYear(), currentTime.getMonth() + 12, +0); // one day before next month
	let eventDates = [];
	var arr = <?= $TRUST_BLOCK_DATE_TIME; ?> || [];
	// dd/mm/yyyy

	for (let i = 0; i < arr.length; ++i) {
		if(arr[i]['H_ID'] == hellComboId) {
			if (!arr[i]['TBDT_FROM_TIME'] && !arr[i]['TBDT_TO_TIME']) {
				let dte = arr[i]['TBDT_DATE'].split("-");
				eventDates[new Date(dte[1] + '-' + dte[0] + '-' + dte[2])] = "noDates";
			}else {
				let dte = arr[i]['TBDT_DATE'].split("-");
				if(!eventDates[new Date(dte[1] + '-' + dte[0] + '-' + dte[2])])
					eventDates[new Date(dte[1] + '-' + dte[0] + '-' + dte[2])] = arr[i]['TBDT_FROM_TIME'] + "|" + arr[i]['TBDT_TO_TIME'];
				else {
					eventDates[new Date(dte[1] + '-' + dte[0] + '-' + dte[2])] = eventDates[new Date(dte[1] + '-' + dte[0] + '-' + dte[2])] + "|" + arr[i]['TBDT_FROM_TIME'] + "|" + arr[i]['TBDT_TO_TIME'];
				}
			}
		}
	}

	$("#multiDate").datepicker({
		minDate: minDate,
		maxDate: maxDate,
		dateFormat: 'dd-mm-yy',
		onSelect: function (selectedDate) {
			try{
				let dte = selectedDate.split("-");
				let highlight = eventDates[new Date(dte[1] + '-' + dte[0] + '-' + dte[2])];
				selBookTime = "";
				if(highlight != "noDates" && highlight != "") {
					console.log(highlight);
					let fromDate = "";
					let toDate = "";
					let msg = "";
					
					$('#alreadyBook').html("");
					selBookTime = highlight;
					highlight = highlight.split("|");
					for(let i = 0; i < highlight.length-1; ++i) {
						fromDate = highlight[i];
						toDate = highlight[++i];
						if(i == (highlight.length-1))
							msg += "from " + convertTimeTo12hrs(fromDate) + " to " + convertTimeTo12hrs(toDate);
						else
							msg += "from " + convertTimeTo12hrs(fromDate) + " to " + convertTimeTo12hrs(toDate) + ", ";
					}
					 $('#alreadyBook').append(hallComboName + " is already reserved " + msg);
				}else {
					$('#alreadyBook').html("");
				}
			}catch(e) {
				$('#alreadyBook').html("");
			}

		},
		beforeShowDay: function (date) {
			let highlight = eventDates[date];
			
			if(highlight == "noDates") {
				return [false, "eventGrey", highlight];
			}else if(highlight){
				return [true, 'eventOrange', ''];
			}else {
				return [true, '', ''];
			}
		}
	});
});


function convertTimeTo24hrs(newTime) {
	var time = newTime;
	
	var hours = Number(time.match(/^(\d+)/)[1]);
	var minutes = Number(time.match(/:(\d+)/)[1]);
	var AMPM = time.match(/\s(.*)$/)[1];
	if(AMPM == "PM" && hours<12) hours = hours+12;
	if(AMPM == "AM" && hours==12) hours = hours-12;
	var sHours = hours.toString();
	var sMinutes = minutes.toString();
	if(hours<10) sHours = "0" + sHours;
	if(minutes<10) sMinutes = "0" + sMinutes;
	// alert(sHours + ":" + sMinutes);
	
	return sHours +":"+sMinutes + ":00"; 
	
	// return {
		// hours: Number(sHours),
		// minutes: Number(sMinutes)
	// }

}

function convertTimeTo12hrs(time) {
  let str = ("0" + time.split(":")[0]).slice(-2) +":"+ time.split(":")[1]; 
  
  time = str.toString().match(/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];
  console.log(time)

  if (time.length > 1) {
    time = time.slice (1);
    time[5] = +time[0] < 12 ? ' AM' : ' PM';
    time[0] = +time[0] % 12 || 12;
  }
   // alert(time.join (''));
   return time.join('');
}

$('#hallCombo').trigger("change");

function checkDuplicate() {
	let duplicate = 0;


	let hallCombo = $('#hallCombo option:selected');
	let hellComboId = hallCombo.html().trim();
	let hallComboName = hallCombo.attr("data-name");

	let tableValues = getTableValues();

	date = $('#multiDate').val();

	for (let j = 0; j < tableValues['hallComboName'].length; ++j) {
		if (duplicate != 0)
			break;

		if (date == tableValues['date'][j].innerHTML.trim() && hallComboName == tableValues['hallComboName'][j].innerHTML.trim() && tableValues['hellComboId'][j].innerHTML.trim() == hellComboId) {
			alert("Information", hallComboName + " Already Exists on " + date)
			++duplicate;
			break;
		}

	}
	return Number(duplicate);
}

$('.todayDate').on('click', function () {
	$("#multiDate").focus();
});

$('#phone').keyup(function (e) {
	var $th = $(this);
	if (e.keyCode != 46 && e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 38 && e.keyCode != 39 && e.keyCode != 40) {
		$th.val($th.val().replace(/[^0-9]/g, function (str) { return ''; }));
	} return;
});

function getTableValues() {
	let si1 = document.getElementsByClassName('si1');
	// alert(si1[0].innerHTML)
	let si = document.getElementsByClassName('si');
	let date = document.getElementsByClassName('date');
	// alert(date[0].innerHTML)
	let link1 = document.getElementsByClassName('link1');
	let hallComboName = document.getElementsByClassName('hallComboName');
	let hellComboId = document.getElementsByClassName('hellComboId');
	let timepickerFrom = document.getElementsByClassName('timepickerFrom');
	let timepickerTo = document.getElementsByClassName('timepickerTo');
	let timepickerTo24hrs = document.getElementsByClassName('timepickerTo24hrs');
	let timepickerFrom24hrs = document.getElementsByClassName('timepickerFrom24hrs');

	return {
		si1: si1,
		si: si,
		date: date,
		price: price,
		link1: link1,
		hallComboName: hallComboName,
		hellComboId: hellComboId,
		timepickerFrom: timepickerFrom,
		timepickerTo: timepickerTo,
		timepickerTo24hrs: timepickerTo24hrs,
		timepickerFrom24hrs: timepickerFrom24hrs,
	}
}

$(".chequeDate2").datepicker({
	dateFormat: 'dd-mm-yy'
});

$('.chequeDate').on('click', function () {
	$(".chequeDate2").focus();
});

function checkTotalMatchHeads() {
	if($('#amtModal').val() == "0" || $('#advAmt').val().length == 0) {
		$('#amtModal').css({"border-color":"red"})
		return;
	}else {
		$('#amtModal').css({"border-color":"black"})
	}

	let advAmt = Number($('#advAmt').val()) || 0;
	let amtModal = Number($('#amtModal').val()) || 0;
	let total = amtModal;
	let templeValues = getJsonTableTempleValues();
	let trustValues = getJsonTableTrustValues();
	
	let templeValues1 = JSON.parse(templeValues.amtTemple);
	let trustValues1 = JSON.parse(trustValues.amtTrust);

	for(let i = 0; i < templeValues1.length; ++i) {
		total += Number(templeValues1[i]);
	}
	
	for(let j = 0; j < trustValues1.length; ++j) {
		total += Number(trustValues1[j]);
	}
	
	return {
		total,
		advAmt
	}
	// if(total > advAmt) {
	// 	return false;
	// }
	// return true;
}

function addTempleHeads() {
	let idHeads = $('#idHeads').val();
	let typeHeads = $('#typeHeads').val();
	let nameHeads =  $('#nameHeads').val();
	let amt =  $('#amtModal').val();
	$('#amtModal').val("0");

	let modeOfPayment = $('#modeOfPayment option:selected').val();
	let chequeNo = $('#chequeNo').val();
	let chequeDate = $('#chequeDate').val();
	let bank = $('#bank').val();
	let branch = $('#branch').val();
	let transactionId = $('#transactionId').val();
	let pymtNotesTemple = $('#pymtNotes').val();

	let si = $('#templeTable tr:last-child td:first-child').html();
	if (!si)
		si = 1
	else
		++si;

	if (modeOfPayment == "Cheque") {
		let title = "Cheque Details";
		let msg = `Cheque Date: ${chequeDate} <br/> Cheque No: ${chequeNo} <br/> Bank: ${bank} <br/> Branch: ${branch} <br/>`;

		$('#addHeadsTemple').append(`<tr class="${si}si1Temple si1Temple"><td style="display:none;" class="siTemple">${si}</td><td style="display:none;" class="transactionIdTemple">${transactionId}</td><td style="display:none;" class="branchTemple">${branch}</td><td style="display:none;" class="modeOfPaymentTemple">${modeOfPayment}</td><td style="display:none;" class="chequeNoTemple">${chequeNo}</td><td style="display:none;" class="chequeDateTemple">${chequeDate}</td><td style="display:none;" class="bankTemple">${bank}</td><td style="display:none;" class="idTempleHeads">${idHeads}</td>><td style="display:none;" class="typeTempleHeads">${typeHeads}</td><td class="nameTempleHeads">${nameHeads}</td><td class="amtTemple">${amt} </td><td class="modeOfPaymentTemple1"><a style="color:#800000" onClick="showTrustHeadsDetails('${title}', '${msg}')">${modeOfPayment}</td><td class="pymtNotesTemple">${pymtNotesTemple}</td><td class="link1Temple"><a style="cursor:pointer;" onClick="updateTempleTable(${si});"><img style="width:24px; height:24px;" title="delete" src="<?=site_url(); ?>images/delete1.svg"></a></td></tr>`);
		
	}else if (modeOfPayment == "Credit / Debit Card") {

		let title = "Credit / Debit Card Details";
		let msg = `Transaction Id: ${transactionId} <br/>`;

		$('#addHeadsTemple').append(`<tr class="${si}si1Temple si1Temple"><td style="display:none;" class="siTemple">${si}</td><td style="display:none;" class="transactionIdTemple">${transactionId}</td><td style="display:none;" class="branchTemple">${branch}</td><td style="display:none;" class="modeOfPaymentTemple">${modeOfPayment}</td><td style="display:none;" class="chequeNoTemple">${chequeNo}</td><td style="display:none;" class="chequeDateTemple">${chequeDate}</td><td style="display:none;" class="bankTemple">${bank}</td><td style="display:none;" class="idTempleHeads">${idHeads}</td>><td style="display:none;" class="typeTempleHeads">${typeHeads}</td><td class="nameTempleHeads">${nameHeads}</td><td class="amtTemple">${amt} </td><td class="modeOfPaymentTemple1"><a style="color:#800000" onClick="showTrustHeadsDetails('${title}', '${msg}')">${modeOfPayment}</td><td class="pymtNotesTemple">${pymtNotesTemple}</td><td class="link1Temple"><a style="cursor:pointer;" onClick="updateTempleTable(${si});"><img style="width:24px; height:24px;" title="delete" src="<?=site_url(); ?>images/delete1.svg"></a></td></tr>`);

	}else {
		$('#addHeadsTemple').append('<tr class="' + si + 'si1Temple si1Temple"><td style="display:none;" class="siTemple">' + si + '</td><td style="display:none;" class="transactionIdTemple">' + transactionId + '</td><td style="display:none;" class="branchTemple">' + branch + '</td><td style="display:none;" class="modeOfPaymentTemple">' + modeOfPayment + '</td><td style="display:none;" class="chequeNoTemple">' + chequeNo + '</td><td style="display:none;" class="chequeDateTemple">' + chequeDate + '</td><td style="display:none;" class="bankTemple">' + bank + '</td><td style="display:none;" class="idTempleHeads">' + idHeads + '</td>><td style="display:none;" class="typeTempleHeads">' + typeHeads + '</td><td class="nameTempleHeads">' + nameHeads + '</td><td class="amtTemple">' + amt + '</td><td class="modeOfPaymentTemple1">' + modeOfPayment + '</td><td class="pymtNotesTemple">' + pymtNotesTemple + '</td><td class="link1Temple"><a style="cursor:pointer;" onClick="updateTempleTable(' + si + ');"><img style="width:24px; height:24px;" title="delete" src="<?=site_url(); ?>images/delete1.svg"></a></td></tr>');
		
	}

	si++;

	$('.modalHeads').modal('toggle');
	$('#headsTempleDisplay').show();
}

function updateTempleTable(siTemple1) {
	let siTemple = document.getElementsByClassName(siTemple1 + "si1Temple");
	siTemple[0].remove();
	let tableValues = getTableValuesTemple();

	for (let i = 0; i < tableValues['nameTempleHeads'].length; ++i) {
		tableValues['siTemple'][i].innerHTML = (i + 1);
		tableValues['link1Temple'][i].innerHTML = '<a style="cursor:pointer;" onClick="updateTempleTable(' + (i + 1) + ');"><img style="width:24px; height:24px;" title="delete" src="<?=site_url(); ?>images/delete1.svg"></a>';
		tableValues['si1Temple'][i].className = (i + 1) + "si1Temple si1Temple";
	}
}

function getTableValuesTemple() {
	let si1Temple = document.getElementsByClassName('si1Temple');
	let siTemple = document.getElementsByClassName('siTemple');
	let link1Temple = document.getElementsByClassName('link1Temple');

	let idTempleHeads = document.getElementsByClassName('idTempleHeads');
	let typeTempleHeads = document.getElementsByClassName('typeTempleHeads');
	let nameTempleHeads = document.getElementsByClassName('nameTempleHeads');
	let amtTemple = document.getElementsByClassName('amtTemple');
	let pymtNotesTemple = document.getElementsByClassName('pymtNotesTemple');

	let branchTemple = document.getElementsByClassName('branchTemple');
	let modeOfPaymentTemple = document.getElementsByClassName('modeOfPaymentTemple');
	let chequeNoTemple = document.getElementsByClassName('chequeNoTemple');
	let chequeDateTemple = document.getElementsByClassName('chequeDateTemple');
	let bankTemple = document.getElementsByClassName('bankTemple');
	let transactionIdTemple = document.getElementsByClassName('transactionIdTemple');

	return {
		si1Temple: si1Temple,
		siTemple: siTemple,
		link1Temple: link1Temple,
		idTempleHeads: idTempleHeads,
		typeTempleHeads: typeTempleHeads,
		nameTempleHeads: nameTempleHeads,
		amtTemple: amtTemple,
		branchTemple: branchTemple,
		modeOfPaymentTemple: modeOfPaymentTemple,
		chequeNoTemple: chequeNoTemple,
		chequeDateTemple: chequeDateTemple,
		bankTemple: bankTemple,
		pymtNotesTemple: pymtNotesTemple,
		transactionIdTemple: transactionIdTemple
	}
}

function getJsonTableTempleValues() {
	let tableContent = getTableValuesTemple();
		let idTempleHeads = [];
		let typeTempleHeads = [];
		let nameTempleHeads = [];
		let amtTemple = [];
		let branchTemple = [];
		let modeOfPaymentTemple = [];
		let chequeNoTemple = [];
		let chequeDateTemple = [];
		let bankTemple = [];
		let transactionIdTemple = [];
		let pymtNotesTemple = [];
		

		for (i = 0; i < tableContent['nameTempleHeads'].length; ++i) {
			idTempleHeads[i] = tableContent['idTempleHeads'][i].innerHTML;
			typeTempleHeads[i] = tableContent['typeTempleHeads'][i].innerHTML;
			nameTempleHeads[i] = tableContent['nameTempleHeads'][i].innerHTML;
			amtTemple[i] = tableContent['amtTemple'][i].innerHTML;
			branchTemple[i] = tableContent['branchTemple'][i].innerHTML;
			modeOfPaymentTemple[i] = tableContent['modeOfPaymentTemple'][i].innerHTML;
			chequeNoTemple[i] = tableContent['chequeNoTemple'][i].innerHTML;
			chequeDateTemple[i] = tableContent['chequeDateTemple'][i].innerHTML;
			bankTemple[i] = tableContent['bankTemple'][i].innerHTML;
			transactionIdTemple[i] = tableContent['transactionIdTemple'][i].innerHTML;
			pymtNotesTemple[i] = tableContent['pymtNotesTemple'][i].innerHTML;
		}

		return {
			"idTempleHeads": JSON.stringify(idTempleHeads),
			"typeTempleHeads": JSON.stringify(typeTempleHeads),
			"nameTempleHeads": JSON.stringify(nameTempleHeads),
			"amtTemple": JSON.stringify(amtTemple),
			"branchTemple": JSON.stringify(branchTemple),
			"modeOfPaymentTemple": JSON.stringify(modeOfPaymentTemple),
			"chequeNoTemple": JSON.stringify(chequeNoTemple),
			"bankTemple": JSON.stringify(bankTemple),
			"transactionIdTemple": JSON.stringify(transactionIdTemple),
			"pymtNotesTemple": JSON.stringify(pymtNotesTemple),
			"chequeDateTemple": JSON.stringify(chequeDateTemple)
		}

}

function addTrustHeads() {
	
	let idHeads = $('#idHeads').val();
	let pymtNotes = $('#pymtNotes').val();
	let typeHeads = $('#typeHeads').val();
	let nameHeads =  $('#nameHeads').val();
	let amt =  $('#amtModal').val();
	$('#amtModal').val("0");
	let modeOfPayment = $('#modeOfPayment option:selected').val();
	let chequeNo = $('#chequeNo').val();
	let chequeDate = $('#chequeDate').val();
	let bank = $('#bank').val();
	let branch = $('#branch').val();
	let transactionId = $('#transactionId').val();

	let si = $('#trustTable tr:last-child td:first-child').html();
	if (!si)
		si = 1
	else
		++si;
		
	if (modeOfPayment == "Cheque") {
		let title = "Cheque Details";
		let msg = `Cheque Date: ${chequeDate} <br/> Cheque No: ${chequeNo} <br/> Bank: ${bank} <br/> Branch: ${branch} <br/>`;

		$('#addHeadsTrust').append(`<tr class="${si}si1Trust si1Trust"><td style="display:none;" class="siTrust">${si}</td><td style="display:none;" class="transactionIdTrust">${transactionId}</td><td style="display:none;" class="branchTrust">${branch}</td><td style="display:none;" class="modeOfPaymentTrust">${modeOfPayment}</td><td style="display:none;" class="chequeNoTrust">${chequeNo}</td><td style="display:none;" class="chequeDateTrust">${chequeDate}</td><td style="display:none;" class="bankTrust">${bank}</td><td style="display:none;" class="idTrustHeads">${idHeads} </td>><td style="display:none;" class="typeTrustHeads">${typeHeads}</td><td class="nameTrustHeads">${nameHeads}</td><td class="amtTrust">${amt}</td><td class="modeOfPaymentTrust1"><a style="color:#800000" onClick="showTrustHeadsDetails('${title}', '${msg}')">${modeOfPayment}</a></td><td class="pymtNotesTrust">${pymtNotes}</td><td class="link1Trust"><a style="cursor:pointer;" onClick="updateTrustTable(${si});"><img style="width:24px; height:24px;" title="delete" src="<?=site_url(); ?>images/delete1.svg"></a></td></tr>`);
		
	}else if (modeOfPayment == "Credit / Debit Card") {
		let title = "Credit / Debit Card Details";
		let msg = `Transaction Id: ${transactionId} <br/>`;

		$('#addHeadsTrust').append(`<tr class="${si}si1Trust si1Trust"><td style="display:none;" class="siTrust">${si}</td><td style="display:none;" class="transactionIdTrust">${transactionId}</td><td style="display:none;" class="branchTrust">${branch}</td><td style="display:none;" class="modeOfPaymentTrust">${modeOfPayment}</td><td style="display:none;" class="chequeNoTrust">${chequeNo}</td><td style="display:none;" class="chequeDateTrust">${chequeDate}</td><td style="display:none;" class="bankTrust">${bank}</td><td style="display:none;" class="idTrustHeads">${idHeads} </td>><td style="display:none;" class="typeTrustHeads">${typeHeads}</td><td class="nameTrustHeads">${nameHeads}</td><td class="amtTrust">${amt}</td><td class="modeOfPaymentTrust1"><a style="color:#800000" onClick="showTrustHeadsDetails('${title}', '${msg}')">${modeOfPayment}</a></td><td class="pymtNotesTrust">${pymtNotes}</td><td class="link1Trust"><a style="cursor:pointer;" onClick="updateTrustTable(${si});"><img style="width:24px; height:24px;" title="delete" src="<?=site_url(); ?>images/delete1.svg"></a></td></tr>`);

	}else {
		
		$('#addHeadsTrust').append('<tr class="' + si + 'si1Trust si1Trust"><td style="display:none;" class="siTrust">' + si + '</td><td style="display:none;" class="transactionIdTrust">' + transactionId + '</td><td style="display:none;" class="branchTrust">' + branch + '</td><td style="display:none;" class="modeOfPaymentTrust">' + modeOfPayment + '</td><td style="display:none;" class="chequeNoTrust">' + chequeNo + '</td><td style="display:none;" class="chequeDateTrust">' + chequeDate + '</td><td style="display:none;" class="bankTrust">' + bank + '</td><td style="display:none;" class="idTrustHeads">' + idHeads + '</td>><td style="display:none;" class="typeTrustHeads">' + typeHeads + '</td><td class="nameTrustHeads">' + nameHeads + '</td><td class="amtTrust">' + amt + '</td><td class="modeOfPaymentTrust1">' + modeOfPayment + '</td><td class="pymtNotesTrust">'+pymtNotes+'</td><td class="link1Trust"><a style="cursor:pointer;" onClick="updateTrustTable(' + si + ');"><img style="width:24px; height:24px;" title="delete" src="<?=site_url(); ?>images/delete1.svg"></a></td></tr>');
	}

	
	si++;
	$('.modalHeads').modal("toggle");
	$('#headsTrustDisplay').show();
}

function updateTrustTable(siTrust) {
	 
	let si1Trust = document.getElementsByClassName(siTrust+ "si1Trust");
	if(siTrust != 0)
		si1Trust[0].remove();
	let tableValues = getTableValuesTrust();

	for (let i = 0; i < tableValues['nameTrustHeads'].length; ++i) {
		tableValues['siTrust'][i].innerHTML = (i + 1);
		tableValues['link1Trust'][i].innerHTML = '<a style="cursor:pointer;" onClick="updateTrustTable(' + (i + 1) + ');"><img style="width:24px; height:24px;" title="delete" src="<?=site_url(); ?>images/delete1.svg"></a>';
		tableValues['si1Trust'][i].className = (i + 1) + "si1Trust si1Trust";
	}
}

function getTableValuesTrust() {
	let si1Trust = document.getElementsByClassName('si1Trust');
	let siTrust = document.getElementsByClassName('siTrust');
	let link1Trust = document.getElementsByClassName('link1Trust');

	let idTrustHeads = document.getElementsByClassName('idTrustHeads');
	let typeTrustHeads = document.getElementsByClassName('typeTrustHeads');
	let nameTrustHeads = document.getElementsByClassName('nameTrustHeads');
	let amtTrust = document.getElementsByClassName('amtTrust');
	let pymtNotesTrust = document.getElementsByClassName('pymtNotesTrust');

	let transactionIdTrust = document.getElementsByClassName('transactionIdTrust');
	let branchTrust = document.getElementsByClassName('branchTrust');
	let modeOfPaymentTrust = document.getElementsByClassName('modeOfPaymentTrust');
	let chequeNoTrust = document.getElementsByClassName('chequeNoTrust');
	let chequeDateTrust = document.getElementsByClassName('chequeDateTrust');
	let bankTrust = document.getElementsByClassName('bankTrust');

	return {
		si1Trust: si1Trust,
		siTrust: siTrust,
		link1Trust: link1Trust,
		idTrustHeads: idTrustHeads,
		typeTrustHeads: typeTrustHeads,
		nameTrustHeads: nameTrustHeads,
		amtTrust: amtTrust,
		transactionIdTrust: transactionIdTrust,
		branchTrust: branchTrust,
		modeOfPaymentTrust: modeOfPaymentTrust,
		chequeNoTrust: chequeNoTrust,
		chequeDateTrust: chequeDateTrust,
		bankTrust: bankTrust,
		pymtNotesTrust: pymtNotesTrust
	}
}

function getJsonTableTrustValues() {
	let tableContent = getTableValuesTrust();
		let idTrustHeads = [];
		let typeTrustHeads = [];
		let nameTrustHeads = [];
		let amtTrust = [];
		let transactionIdTrust = [];
		let branchTrust = [];
		let modeOfPaymentTrust = [];
		let chequeNoTrust = [];
		let chequeDateTrust = [];
		let bankTrust = [];
		let pymtNotesTrust = [];
		

		for (i = 0; i < tableContent['nameTrustHeads'].length; ++i) {
			idTrustHeads[i] = tableContent['idTrustHeads'][i].innerHTML;
			typeTrustHeads[i] = tableContent['typeTrustHeads'][i].innerHTML;
			nameTrustHeads[i] = tableContent['nameTrustHeads'][i].innerHTML;
			amtTrust[i] = tableContent['amtTrust'][i].innerHTML;
			transactionIdTrust[i] = tableContent['transactionIdTrust'][i].innerHTML;
			branchTrust[i] = tableContent['branchTrust'][i].innerHTML;
			modeOfPaymentTrust[i] = tableContent['modeOfPaymentTrust'][i].innerHTML;
			chequeNoTrust[i] = tableContent['chequeNoTrust'][i].innerHTML;
			chequeDateTrust[i] = tableContent['chequeDateTrust'][i].innerHTML;
			bankTrust[i] = tableContent['bankTrust'][i].innerHTML;
			pymtNotesTrust[i] = tableContent['pymtNotesTrust'][i].innerHTML;
		}

		return {
			"idTrustHeads": JSON.stringify(idTrustHeads),
			"typeTrustHeads": JSON.stringify(typeTrustHeads),
			"nameTrustHeads": JSON.stringify(nameTrustHeads),
			"amtTrust": JSON.stringify(amtTrust),
			"transactionIdTrust": JSON.stringify(transactionIdTrust),
			"branchTrust": JSON.stringify(branchTrust),
			"modeOfPaymentTrust": JSON.stringify(modeOfPaymentTrust),
			"chequeNoTrust": JSON.stringify(chequeNoTrust),
			"chequeDateTrust": JSON.stringify(chequeDateTrust),
			"bankTrust": JSON.stringify(bankTrust),
			"pymtNotesTrust": JSON.stringify(pymtNotesTrust)
		}

}

function addHeads() {
	let checkTotal = checkTotalMatchHeads();
	if(checkTotal.total > checkTotal.advAmt) {
		alert("Information","Your total Amount exceeds");
		return false;
	}
	let modeOfPayment = $('#modeOfPayment option:selected').val();
	let count = 0;

	let amtModal = $('#amtModal').val();

	let typeHeads = $('#typeHeads').val();

	if (amtModal) {
		$('#amtModal').css('border-color', "#800000");
	} else {
		$('#amtModal').css('border-color', "#FF0000");
		++count;
	}
	let transactionId = $('#transactionId').val();
	let chequeNo = "";
	let bank = "";
	let chequeDate = "";
	let branch = "";

	if (modeOfPayment == "Cheque") {
			chequeNo = $('#chequeNo').val();
			chequeDate = $('#chequeDate').val();
			bank = $('#bank').val();
			branch = $('#branch').val();

			if (chequeNo.length == 6) {
				$('#chequeNo').css('border-color', "#800000");
			} else {
				$('#chequeNo').css('border-color', "#FF0000");
				++count;
			}

			if (chequeDate) {
				$('#chequeDate').css('border-color', "#800000");
			} else {
				$('#chequeDate').css('border-color', "#FF0000");
				++count;
			}

			if (bank) {
				$('#bank').css('border-color', "#800000");
			} else {
				$('#bank').css('border-color', "#FF0000");
				++count;
			}

			if (branch) {
				$('#branch').css('border-color', "#800000");
			} else {
				$('#branch').css('border-color', "#FF0000");
				++count;
			}
		} else if (modeOfPayment == "Credit / Debit Card") {
			if (transactionId) {
				$('#transactionId').css('border-color', "#800000");
			} else {
				$('#transactionId').css('border-color', "#FF0000");
				++count;
			}
		} else {
			$('#chequeNo').css('border-color', "#800000");
			$('#branch').css('border-color', "#800000");
			$('#bank').css('border-color', "#800000");
			$('#chequeDate').css('border-color', "#800000");
		}

		if (modeOfPayment) {
			$('#modeOfPayment').css('border-color', "#ccc")

		} else {
			$('#modeOfPayment').css('border-color', "#FF0000")
			++count;
		}

		if(count==0) {
			if(typeHeads == "trust") {
				addTrustHeads();
			}else {
				addTempleHeads();
			}

		}
}
</script>
