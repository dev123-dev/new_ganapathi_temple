<?php
error_reporting(0); ?>
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
<div style="clear:both;" class="container">
	<div  class="form-group">
		<center><label class="eventsFont2 samFont1"><?="Hall Booking"; ?></label></center>
		<a class="pull-right" style="border:none; outline:0;" href="<?=$_SESSION['actual_link']; ?>" title="Back"><img style="border:none; outline: 0;margin-top: -71px;" src="<?php echo base_url(); ?>images/back_icon.svg"></a>
	</div>
			
	<div class="col-lg-6">
		<div style="margin-left:-32px;" class="col-lg-12">
			<div class="form-group">
				<span class="eventsFont2">Date: <?=date("d-m-Y",strtotime($hallBooking[0]["HB_DATE"])); ?></span>
			</div>
		</div>
				
		<div style="margin-left:-32px;" class="col-lg-12">
			<div class="form-group">
				<span style="font-size:18px;"><strong>Name: </strong><?=$hallBooking[0]['HB_NAME']; ?></span>
			</div>
		</div>
		
		<div style="margin-left:-32px;" class="col-lg-12">
			<div class="form-group">
				<span style="font-size:18px;"><strong>Booking No.: </strong><?=$hallBooking[0]['HB_NO']; ?></span>
			</div>
		</div>
	</div>
			
	<div class="col-lg-6">
		<div class="col-lg-12">
			<?php if($hallBooking[0]['HB_ADDRESS'] != "") { ?>
					<div class="col-lg-12 text-right">  
						<div class="form-group" style="margin-right: -45px;">
							<span style="font-size:18px;word-wrap: break-word;"><strong>Address: </strong><?=$hallBooking[0]['HB_ADDRESS']; ?></span>
						</div>
					</div>
				<?php } ?>

			<?php if($hallBooking[0]['HB_NUMBER'] != "") { ?>
					<div class="col-lg-12 text-right">  
						<div class="form-group" style="margin-right: -45px;">
							<span style="font-size:18px;"><strong>Number: </strong><?=$hallBooking[0]['HB_NUMBER']; ?></span>
						</div>
					</div>
				<?php } ?>
		</div>
	</div>
</div>

<div class="container">
	<div class="clear:both; table-responsive">
		<table id="someNode" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>Hall Name</th>
					<th>Function Type</th>
					<th>Date</th>
					<th>From</th>
					<th>To</th>
					<th>Function Status</th>
					<th>Status</th>
					<th>Operation</th>
				</tr>
			</thead>
			<tbody id="eventUpdate">
			<?php 
			$i = 1;
			
			$subTotal = 0;
			foreach($hallBooking as $result) {
				echo "<tr><td>". $result["H_NAME"]."</td>";
				echo "<td>". $result["FN_NAME"]."</td>";
				echo "<td>". $result["HB_BOOK_DATE"]."</td>";
				echo "<td>". date('g:i a', strtotime($result["HB_BOOK_TIME_FROM"]))."</td>";
				echo "<td>". date('g:i a', strtotime($result["HB_BOOK_TIME_TO"]))."</td>";
				if($result["IS_DONE"] == "1") {
					echo "<td>Done</td>";
				} else if($result["IS_DONE"] == "0") {
					echo "<td>Not Done</td>";
				} else {
					echo "<td>Pending</td>";
				} 
				if($result["HBL_ACTIVE"] == "1") {
					echo "<td>Confirmed</td>";
					$HBL_ID = $result["HBL_ID"];
					$H_NAME = $result["H_NAME"];
					$FROM = date('g:i a', strtotime($result["HB_BOOK_TIME_FROM"]));
					$TO = date('g:i a', strtotime($result["HB_BOOK_TIME_TO"]));
				?>	
					<td><a style="border:none; outline: 0;" onClick="edit('<?=$HBL_ID; ?>','<?=$H_NAME; ?>','<?=$FROM; ?>','<?=$TO; ?>')" title="Deactive" ><img style="border:none; outline: 0;" src="<?php echo	base_url(); ?>images/delete.svg"></a></td>;
				<?php } else {
					echo "<td>Cancelled</td>";
					echo "<td></td>";
				}
				echo "</tr>";
			}
			?>
			</tbody>
		</table>
	</div>
	
	<div class="row">
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
				<label for="seva" style="margin-right: 8px;" class="pull-left">Date: </label>
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
							<img style="width:24px; height:24px" class="img-responsive pull-right" title="Add Hall" src="<?=site_url(); ?>images/add.svg">
						</a>
					</div>
				</div>
		</div>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<span id="alreadyBook" style="color:red;font-size:14px;font-weight:900"></span>
		</div>

		
		<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
			<div class="form-group">
				<label for="funcType">Function Type </label>
				<select id="funcType" class="form-control">
					<?php foreach($fun as $result) { ?>
						<option data-name="<?=$result->FN_NAME; ?>" value="<?=$result->FN_ID; ?>">
							<?=$result->FN_NAME; ?>
						</option>
					<?php } ?>
				</select>
			</div>
		</div>
	
								
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">			
			<div class="table-responsive">
				<table id="hallTable" class="table table-bordered">
					<thead>
						<tr>
							<th>Hall Name.</th>
							<th>Function Type</th>
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
	</div>
</div>

<div class="container">
	<center>
		<button type="button" onclick="validateSubmit();" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-submit"></span>Add Booking</button>
	</center>
</div>

<div class="modal previewModal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
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
<iframe style="width:76mm;height:1px;visibility:hidden;" id="printing-frame" name="print_frame" src="about:blank"></iframe>

<script>
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

//MULTI DATE INPUT KEYPRESS
$('#multiDate').on('keypress change click', function() {
	$('#multiDate').css({"border-color":"black"});
});

function edit(HBL_ID,H_NAME,FROM,TO) {
	let url = "<?=site_url() ?>Trust/deactivateEditBooking";
	deactivateBooking("Information", "Are you sure you want to cancel the booking slot for <b>" + H_NAME + "</b> from <b>" + FROM + "</b> to <b>" + TO + " ?</b>", url, HBL_ID)
}

//for bookHall Trust

$('#multiDate').datepicker('destroy');
document.getElementById("someNode").previousSibling.nodeValue = "";
let selBookTime = "";

var arr = arr || {};
var bgNo = 1;
var between = [];
var seva_date = "";
var date_type = "";

$('#multiDateRadio').click();

$('#submit').on('click', function () {
	$('.previewModal').modal("toggle");
	let count = 0;
	let tableContent = getTableValues();

	if (tableContent['hallComboName'].length == 0) {
		alert("Information", "Book atleast one Hall to submit.");
		return;
	}

	//get hall booking table values
	tableContent = getJsonTableValues();
	let hellComboId = tableContent['hellComboId'];
	let hallComboName = tableContent['hallComboName'];
	let funComboId = tableContent['funComboId'];
	let funComboName = tableContent['funComboName'];
	let timepickerFrom = tableContent['timepickerFrom24hrs'];
	let timepickerTo = tableContent['timepickerTo24hrs'];
	let date = tableContent['date'];
	let HB_ID = "<?=$HB_ID; ?>"
	
	let url = "<?=site_url()?>Trust/editHallBookingSave"
	
	$.post(url, {
		hellComboId,
		hallComboName,
		timepickerFrom,
		funComboId,
		funComboName,
		timepickerTo,
		date,
		HB_ID
	}, function(e) {
		if(!e) {
			location.reload();
		}
	});
});

function validateSubmit() {
	let count = 0;
	let tableContent = getTableValues();
	
	// if($('#phone').val() != "") {
	// 	if($('#phone').val().length < 10) {
	// 		alert("Information", "Please add a 10 digit mobile or a 11 digit landline.");
	// 		return;
	// 	}
	// }

	if (tableContent['hallComboName'].length == 0) {
		alert("Information", "Book atleast one Hall to submit.")
		return;
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

	$('.previewModalBody').html("<label>DATE:</label> " + "<?=date('d-m-Y'); ?>");
	$('.previewModalBody').append("<br/>");
	$('#eventUpdate2').html("");
	$('.previewModalBody').append('<div class="table-responsive"><table class="table table-bordered"><thead><tr><th>Hall Name</th><th>Function Type</th><th>Date</th><th><center>From</center></th><th><center>To</center></th></tr></thead><tbody id="eventUpdate2"></tbody></table></div>')

	for (i = 0; i < tableContent.hallComboName.length; ++i) {
		$('#eventUpdate2').append("<tr>");
		$('#eventUpdate2').append("<td><center>" + tableContent['hallComboName'][i].innerHTML + "</center></td>");
		$('#eventUpdate2').append("<td>" + tableContent['funComboName'][i].innerHTML + "</td>");
		$('#eventUpdate2').append("<td><center>" + tableContent['date'][i].innerHTML + "</center></td>");
		$('#eventUpdate2').append("<td>" + tableContent['timepickerFrom'][i].innerHTML + "</td>");
		$('#eventUpdate2').append("<td>" + tableContent['timepickerTo'][i].innerHTML + "</td>");
		$('#eventUpdate2').append("</tr><br/>");
	}

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
		alert("Information", "Please change from/to time", "OK");
		return false;
	} else {
		$('#timepickerFrom').css({"border-color":"black"});
		$('#timepickerTo').css({"border-color":"black"});
	}
	
	if(selBookTime) {
		let highlight = selBookTime.split("|");
		for(let i = 0; i < highlight.length-1; ++i) {
			resevedTimeFrom = highlight[i];
			resevedTimeTo = highlight[++i];

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

$('#timepickerFrom').timepicker({
	defaultTime: ''
});

$('#timepickerTo').timepicker({
	defaultTime: ''
});

function addRow() {
	// let tableContent = getTableValues();
	let duplicate = checkDuplicate();
	if (duplicate != 0)
		return;

	let hallCombo = $('#hallCombo option:selected');
	let funcType = $('#funcType option:selected');

	// let name = $('#name').val();
	let hellComboId = hallCombo.val();
	let hallComboName = hallCombo.attr("data-name");
	let funComboId = funcType.val();
	let funComboName = funcType.attr("data-name");
	let timepickerFrom = $('#timepickerFrom').val();
	let timepickerTo = $('#timepickerTo').val();

	if(timepickerFrom != "" && timepickerTo != "") {
		if(!checkDateTime(timepickerFrom, timepickerTo)) {
			selBookTime = "";
			return;
		}
	}
	
	let date = "";
	let count = "";

	date = $("#multiDate").val();
	count = validate("multiDate");

	if (!count) {
		alert("Information", "Please fill required fields", "OK");
		return;
	}

	if(timepickerFrom == "" || timepickerTo == "") {
		if(timepickerFrom == "") {
			$('#timepickerFrom').css({"border-color":"red"});
		}
		if(timepickerTo == "") {
			$('#timepickerTo').css({"border-color":"red"});
		}
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
	$('#alreadyBook').html("");
	$('#timepickerFrom').timepicker('setTime', null);
	$('#timepickerTo').timepicker('setTime', null);
	$('#selDate').html("");
	$('#multiDate').datepicker('setDate', null);

	$('#hallTable').append('<tr class="' + si + ' si1"><td style="display:none;" class="si">' + si + '</td><td style="display:none;" class="hellComboId">' + hellComboId + '</td><td style="display:none;" class="funComboId">' + funComboId + '</td><td style="display:none;" class="timepickerFrom24hrs">' + convertTimeTo24hrs(timepickerFrom) + '</td><td style="display:none;" class="timepickerTo24hrs">' + convertTimeTo24hrs(timepickerTo) + '</td><td class="hallComboName">' + hallComboName + '</td><td class="funComboName">' + funComboName + '</td><td class="date">' + date + '</td><td class="timepickerFrom">' + timepickerFrom + '</td><td class="timepickerTo">' + timepickerTo + '</td><td class="link1"><a style="cursor:pointer;" onClick="updateTable(' + si + ');"><img style="width:24px; height:24px;" title="Delete" src="<?=site_url(); ?>images/delete1.svg"></a></td></tr>');
	si++;

	$('#addHeadsTemple').html("");
	$('#addHeadsTrust').html("");
	$('#headsTempleDisplay').hide();
	$('#headsTrustDisplay').hide();

	
}

function getJsonTableValues() {
	let tableContent = getTableValues();
		let hellComboId = [];
		let hallComboName = [];
		let funComboId = [];
		let funComboName = [];
		let timepickerFrom = [];
		let timepickerTo = [];
		let date = [];
		
		let timepickerTo24hrs = [];
		let  timepickerFrom24hrs = [];
		

		for (i = 0; i < tableContent['hallComboName'].length; ++i) {
			hellComboId[i] = tableContent['hellComboId'][i].innerHTML;
			hallComboName[i] = tableContent['hallComboName'][i].innerHTML;
			funComboId[i] = tableContent['funComboId'][i].innerHTML;
			funComboName[i] = tableContent['funComboName'][i].innerHTML;
			timepickerFrom[i] = tableContent['timepickerFrom'][i].innerHTML;
			timepickerTo[i] = tableContent['timepickerTo'][i].innerHTML;
			date[i] = tableContent['date'][i].innerHTML;
			timepickerTo24hrs[i] = tableContent['timepickerTo24hrs'][i].innerHTML;
			timepickerFrom24hrs[i] = tableContent['timepickerFrom24hrs'][i].innerHTML;
		}

		return {
			"hellComboId": JSON.stringify(hellComboId),
			"hallComboName": JSON.stringify(hallComboName),
			"funComboId": JSON.stringify(funComboId),
			"funComboName": JSON.stringify(funComboName),
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
		tableValues['link1'][i].innerHTML = '<a style="cursor:pointer;" onClick="updateTable(' + (i + 1) + ');"><img style="width:24px; height:24px;" title="Delete" src="<?=site_url(); ?>images/delete1.svg"></a>';
		tableValues['si1'][i].className = (i + 1) + " si1";
	}

	$('#addHeadsTemple').html("");
	$('#addHeadsTrust').html("");
	$('#headsTempleDisplay').hide();
	$('#headsTrustDisplay').hide();
}

$('#hallCombo').on('change', function() {
	$('#multiDate').datepicker('setDate', null);
	$('#multiDate').datepicker('destroy');
	$('#alreadyBook').html("");
	$('#timepickerFrom').timepicker('setTime', null);
	$('#timepickerTo').timepicker('setTime', null);

	let hallCombo = $('#hallCombo option:selected');
	let hellComboId = hallCombo.val();
	let hallComboName = hallCombo.attr("data-name");

	var currentTime = new Date()
	var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
	var maxDate = new Date(currentTime.getFullYear(), currentTime.getMonth() + 12, +0); // one day before next month
	let eventDates = [];
	var arr = <?= $TRUST_BLOCK_DATE_TIME; ?> || [];
	console.log(arr);
	// dd/mm/yyyy

	for (let i = 0; i < arr.length; ++i) {
		if(arr[i]['H_ID'] == hellComboId) {
			if (!arr[i]['TBDT_FROM_TIME'] && !arr[i]['TBDT_TO_TIME']) {
				let dte = arr[i]['TBDT_DATE'].split("-");
				eventDates[new Date(dte[1] + '-' + dte[0] + '-' + dte[2])] = "noDates";
			} else {
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
			try {
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
				} else {
					$('#alreadyBook').html("");
				}
			} catch(e) {
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
    time[5] = +time[0] < 12 ? ' am' : ' pm';
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

function getTableValues() {
	let si1 = document.getElementsByClassName('si1');
	// alert(si1[0].innerHTML)
	let si = document.getElementsByClassName('si');
	let date = document.getElementsByClassName('date');
	// alert(date[0].innerHTML)
	let link1 = document.getElementsByClassName('link1');
	let hallComboName = document.getElementsByClassName('hallComboName');
	let hellComboId = document.getElementsByClassName('hellComboId');
	let funComboName = document.getElementsByClassName('funComboName');
	let funComboId = document.getElementsByClassName('funComboId');
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
		funComboName: funComboName,
		funComboId: funComboId,
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

		$('#addHeadsTemple').append(`<tr class="${si}si1Temple si1Temple"><td style="display:none;" class="siTemple">${si}</td><td style="display:none;" class="transactionIdTemple">${transactionId}</td><td style="display:none;" class="branchTemple">${branch}</td><td style="display:none;" class="modeOfPaymentTemple">${modeOfPayment}</td><td style="display:none;" class="chequeNoTemple">${chequeNo}</td><td style="display:none;" class="chequeDateTemple">${chequeDate}</td><td style="display:none;" class="bankTemple">${bank}</td><td style="display:none;" class="idTempleHeads">${idHeads}</td>><td style="display:none;" class="typeTempleHeads">${typeHeads}</td><td class="nameTempleHeads">${nameHeads}</td><td class="amtTemple">${amt} </td><td class="modeOfPaymentTemple1"><a onClick="showTrustHeadsDetails('${title}', '${msg}')">${modeOfPayment}</td><td class="pymtNotesTemple">${pymtNotesTemple}</td><td class="link1Temple"><a style="cursor:pointer;" onClick="updateTempleTable(${si});"><img style="width:24px; height:24px;" title="Delete" src="<?=site_url(); ?>images/delete1.svg"></a></td></tr>`);
		
	} else if (modeOfPayment == "Credit / Debit Card") {

		let title = "Credit / Debit Card Details";
		let msg = `Transaction Id: ${transactionId} <br/>`;

		$('#addHeadsTemple').append(`<tr class="${si}si1Temple si1Temple"><td style="display:none;" class="siTemple">${si}</td><td style="display:none;" class="transactionIdTemple">${transactionId}</td><td style="display:none;" class="branchTemple">${branch}</td><td style="display:none;" class="modeOfPaymentTemple">${modeOfPayment}</td><td style="display:none;" class="chequeNoTemple">${chequeNo}</td><td style="display:none;" class="chequeDateTemple">${chequeDate}</td><td style="display:none;" class="bankTemple">${bank}</td><td style="display:none;" class="idTempleHeads">${idHeads}</td>><td style="display:none;" class="typeTempleHeads">${typeHeads}</td><td class="nameTempleHeads">${nameHeads}</td><td class="amtTemple">${amt} </td><td class="modeOfPaymentTemple1"><a onClick="showTrustHeadsDetails('${title}', '${msg}')">${modeOfPayment}</td><td class="pymtNotesTemple">${pymtNotesTemple}</td><td class="link1Temple"><a style="cursor:pointer;" onClick="updateTempleTable(${si});"><img style="width:24px; height:24px;" title="Delete" src="<?=site_url(); ?>images/delete1.svg"></a></td></tr>`);

	} else {
		$('#addHeadsTemple').append('<tr class="' + si + 'si1Temple si1Temple"><td style="display:none;" class="siTemple">' + si + '</td><td style="display:none;" class="transactionIdTemple">' + transactionId + '</td><td style="display:none;" class="branchTemple">' + branch + '</td><td style="display:none;" class="modeOfPaymentTemple">' + modeOfPayment + '</td><td style="display:none;" class="chequeNoTemple">' + chequeNo + '</td><td style="display:none;" class="chequeDateTemple">' + chequeDate + '</td><td style="display:none;" class="bankTemple">' + bank + '</td><td style="display:none;" class="idTempleHeads">' + idHeads + '</td>><td style="display:none;" class="typeTempleHeads">' + typeHeads + '</td><td class="nameTempleHeads">' + nameHeads + '</td><td class="amtTemple">' + amt + '</td><td class="modeOfPaymentTemple1">' + modeOfPayment + '</td><td class="pymtNotesTemple">' + pymtNotesTemple + '</td><td class="link1Temple"><a style="cursor:pointer;" onClick="updateTempleTable(' + si + ');"><img style="width:24px; height:24px;" title="Delete" src="<?=site_url(); ?>images/delete1.svg"></a></td></tr>');
		
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
		tableValues['link1Temple'][i].innerHTML = '<a style="cursor:pointer;" onClick="updateTempleTable(' + (i + 1) + ');"><img style="width:24px; height:24px;" title="Delete" src="<?=site_url(); ?>images/delete1.svg"></a>';
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

		$('#addHeadsTrust').append(`<tr class="${si}si1Trust si1Trust"><td style="display:none;" class="siTrust">${si}</td><td style="display:none;" class="transactionIdTrust">${transactionId}</td><td style="display:none;" class="branchTrust">${branch}</td><td style="display:none;" class="modeOfPaymentTrust">${modeOfPayment}</td><td style="display:none;" class="chequeNoTrust">${chequeNo}</td><td style="display:none;" class="chequeDateTrust">${chequeDate}</td><td style="display:none;" class="bankTrust">${bank}</td><td style="display:none;" class="idTrustHeads">${idHeads} </td>><td style="display:none;" class="typeTrustHeads">${typeHeads}</td><td class="nameTrustHeads">${nameHeads}</td><td class="amtTrust">${amt}</td><td class="modeOfPaymentTrust1"><a onClick="showTrustHeadsDetails('${title}', '${msg}')">${modeOfPayment}</a></td><td class="pymtNotesTrust">${pymtNotes}</td><td class="link1Trust"><a style="cursor:pointer;" onClick="updateTrustTable(${si});"><img style="width:24px; height:24px;" title="Delete" src="<?=site_url(); ?>images/delete1.svg"></a></td></tr>`);
		
	} else if (modeOfPayment == "Credit / Debit Card") {
		let title = "Credit / Debit Card Details";
		let msg = `Transaction Id: ${transactionId} <br/>`;

		$('#addHeadsTrust').append(`<tr class="${si}si1Trust si1Trust"><td style="display:none;" class="siTrust">${si}</td><td style="display:none;" class="transactionIdTrust">${transactionId}</td><td style="display:none;" class="branchTrust">${branch}</td><td style="display:none;" class="modeOfPaymentTrust">${modeOfPayment}</td><td style="display:none;" class="chequeNoTrust">${chequeNo}</td><td style="display:none;" class="chequeDateTrust">${chequeDate}</td><td style="display:none;" class="bankTrust">${bank}</td><td style="display:none;" class="idTrustHeads">${idHeads} </td>><td style="display:none;" class="typeTrustHeads">${typeHeads}</td><td class="nameTrustHeads">${nameHeads}</td><td class="amtTrust">${amt}</td><td class="modeOfPaymentTrust1"><a onClick="showTrustHeadsDetails('${title}', '${msg}')">${modeOfPayment}</a></td><td class="pymtNotesTrust">${pymtNotes}</td><td class="link1Trust"><a style="cursor:pointer;" onClick="updateTrustTable(${si});"><img style="width:24px; height:24px;" title="Delete" src="<?=site_url(); ?>images/delete1.svg"></a></td></tr>`);

	} else {
		
		$('#addHeadsTrust').append('<tr class="' + si + 'si1Trust si1Trust"><td style="display:none;" class="siTrust">' + si + '</td><td style="display:none;" class="transactionIdTrust">' + transactionId + '</td><td style="display:none;" class="branchTrust">' + branch + '</td><td style="display:none;" class="modeOfPaymentTrust">' + modeOfPayment + '</td><td style="display:none;" class="chequeNoTrust">' + chequeNo + '</td><td style="display:none;" class="chequeDateTrust">' + chequeDate + '</td><td style="display:none;" class="bankTrust">' + bank + '</td><td style="display:none;" class="idTrustHeads">' + idHeads + '</td>><td style="display:none;" class="typeTrustHeads">' + typeHeads + '</td><td class="nameTrustHeads">' + nameHeads + '</td><td class="amtTrust">' + amt + '</td><td class="modeOfPaymentTrust1">' + modeOfPayment + '</td><td class="pymtNotesTrust">'+pymtNotes+'</td><td class="link1Trust"><a style="cursor:pointer;" onClick="updateTrustTable(' + si + ');"><img style="width:24px; height:24px;" title="Delete" src="<?=site_url(); ?>images/delete1.svg"></a></td></tr>');
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
		tableValues['link1Trust'][i].innerHTML = '<a style="cursor:pointer;" onClick="updateTrustTable(' + (i + 1) + ');"><img style="width:24px; height:24px;" title="Delete" src="<?=site_url(); ?>images/delete1.svg"></a>';
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
		alert("Information","Entered amount exceeds total amount");
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
			} else {
				addTempleHeads();
			}

		}
}
</script>
<?php 
	// $this->output->enable_profiler(TRUE);
// error_reporting(0);
?>
