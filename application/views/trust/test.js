$('#timepickerFrom').timepicker({
	defaultTime: ''
});

$('#timepickerTo').timepicker({
	defaultTime: ''
});

var arr = arr || {};
var bgNo = 1;
var between = [];
var seva_date = "";
var date_type = "";

$('#multiDateRadio').click();

$('#submit').on('click', function () {
	let count = 0;
	let number = $('#phone').val()
	let name = $('#name').val()
	let address = $('#address').val()
	let tableContent = getTableValues();

	if (tableContent['hallComboName'].length == 0) {
		alert("Information", "Add atleast one seva to submit.")
		return;
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

	let hallComboName = [];
	let date = [];
	let sevaId = [];
	let userId = [];
	let deityId = [];
	let deityName = [];
	let isSeva = [];

	let url = "<?=site_url(); ?>SevaBooking/generateBookingReceipt";

	for (let i = 0; i < tableContent['hallComboName'].length; ++i) {
		hallComboName[i] = tableContent['hallComboName'][i].innerHTML.trim();
		isSeva[i] = tableContent['isSeva'][i].innerHTML.trim();
		deityName[i] = tableContent['deityName'][i].innerHTML.trim();
		date[i] = tableContent['date'][i].innerHTML.trim();
		sevaId[i] = tableContent['sevaId'][i].innerHTML.trim();
		userId[i] = tableContent['userId'][i].innerHTML.trim();
		deityId[i] = tableContent['deityId'][i].innerHTML.trim();
	}

	$.post(url, { 'hallComboName': JSON.stringify(hallComboName), 'deityName': JSON.stringify(deityName), 'date': JSON.stringify(date), 'sevaId': JSON.stringify(sevaId), 'userId': JSON.stringify(userId), 'deityId': JSON.stringify(deityId), 'isSeva': JSON.stringify(isSeva), 'name': name, 'number': number, 'address': address }, function (e) {
		console.log(e)
		if (e == "success")
			location.href = "<?=site_url(); ?>SevaBooking/printBookingReceipt";
		else
			alert("Something went wrong, Please try again after some time");
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

function validateSubmit() {
	//TO CHECK FOR TIME ALLOWED TO ENTER
	var startTime = "<?php echo $_SESSION['time'][0]->TIME_FROM; ?>";
	var endTime = "<?php echo $_SESSION['time'][0]->TIME_TO; ?>";
	var now = new Date();

	var startDate = dateObj(startTime); // get date objects
	var endDate = dateObj(endTime);

	var open = now < endDate && now > startDate ? true : false; // compare
	if (open) {
		alert("Information", "You are not allowed to book sevas till " + endTime);
		return false;
	}
	//TO CHECK FOR TIME ALLOWED TO ENTER ENDS HERE

	let count = 0;
	let number = $('#phone').val()
	let name = $('#name').val()
	let address = $('#address').val();
	let tableContent = getTableValues();

	if (tableContent['hallComboName'].length == 0) {
		alert("Information", "Add atleast one seva to submit.")
		return;
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

	let hallComboName = [];

	let date = [];


	let sevaId = [];
	let userId = [];
	let deityId = [];
	let deityName = [];
	let isSeva = [];
	let url = "<?=site_url(); ?>Receipt/generateDeityReceipt";

	$('#hallTbody2').html("");

	$('.modal-body').html('<div class="table-responsive"><table class="table table-bordered"><thead><tr><th>Deity Name</th><th>Seva Name</th><th>Seva Date</th></tr></thead><tbody id="hallTbody2"></tbody></table></div>')

	for (i = 0; i < tableContent['hallComboName'].length; ++i) {
		$('#hallTbody2').append("<tr>");
		$('#hallTbody2').append("<td>" + tableContent['deityName'][i].innerHTML + "</td>");
		$('#hallTbody2').append("<td>" + tableContent['hallComboName'][i].innerHTML + "</td>");
		$('#hallTbody2').append("<td>" + tableContent['date'][i].innerHTML + "</td>");
		$('#hallTbody2').append("</tr><br/>");
	}

	$('.modal-body').append("<label>DATE:</label> " + "08-05-2018" + "<br/>");
	$('.modal-body').append("<label>NAME:</label> " + name + "");
	if (number)
		$('.modal-body').append(",&nbsp;&nbsp;<label>NUMBER:</label> " + number + "");

	if (address)
		$('.modal-body').append(",&nbsp;&nbsp;<label>Address:</label> " + address + "");

	$('.modal-body').append("<br/>");

	$('.modal').modal();
	$('.bs-example-modal-lg').focus();
}

var price = 0;
var total = 0;

function addRow() {
	let tableContent = getTableValues();

	let duplicate = checkDuplicate();
	if (duplicate != 0)
		return;

	let hallCombo = $('#hallCombo option:selected');

	let name = $('#name').val();
	let hellComboId = hallCombo.val();
	let hallComboName = hallCombo.attr("data-name");
	let timepickerFrom = $('#timepickerFrom').val();
	let timepickerTo = $('#timepickerTo').val();

	let date = "";
	let count = "";

	date = $("#multiDate").val();

	count = validate("multiDate", "name");

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


	$('#hallTable').append('<tr class="' + si + ' si1"><td style="display:none;" class="si">' + si + '</td><td style="display:none;" class="hellComboId">' + hellComboId + '</td><td class="hallComboName">' + hallComboName + '</td><td class="date">' + date + '</td><td class="timepickerFrom">' + timepickerFrom + '</td><td class="timepickerTo">' + timepickerTo + '</td><td class="link1"><a style="cursor:pointer;" onClick="updateTable(' + si + ');"><img style="width:24px; height:24px;" title="delete" src="<?=site_url(); ?>images/delete1.svg"></a></td></tr>');
	si++;

	let tableContent2 = getTableValues();

	console.log(JSON.stringify(tableContent2))

	// $.post("<?=site_url(); ?>Trust/getFinancialHead",{

	// }, function(e) {

	// })
}

function updateTable(si) {
	let si1 = document.getElementsByClassName(si);
	si1[0].remove();
	let tableValues = getTableValues();

	for (let i = 0; i < tableValues['sevaCombo'].length; ++i) {
		tableValues['si'][i].innerHTML = (i + 1);
		tableValues['link1'][i].innerHTML = '<a style="cursor:pointer;" onClick="updateTable(' + (i + 1) + ');"><img style="width:24px; height:24px;" title="delete" src="<?=site_url(); ?>images/delete1.svg"></a>';
		tableValues['si1'][i].className = (i + 1) + " si1";
	}

	let tableContent = getTableValues();

}

var currentTime = new Date()
var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
var maxDate = new Date(currentTime.getFullYear(), currentTime.getMonth() + 12, +0); // one day before next month
var eventDates = {};
var arr = <?= $TRUST_BLOCK_DATE_TIME; ?> || [];
// dd/mm/yyyy

for (let i = 0; i < arr.length; ++i) {

	if (!arr[i]['TBDT_FROM_TIME'] && !arr[i]['TBDT_TO_TIME']) {
		let dte = arr[i]['TBDT_DATE'].split("-");
		eventDates[new Date(dte[1] + '-' + dte[0] + '-' + dte[2])] = "some msg";
	}
}

$("#multiDate").datepicker({
	minDate: minDate,
	maxDate: maxDate,
	dateFormat: 'dd-mm-yy',
	onSelect: function (selectedDate) {
		$('#selDate').html($('#multiDate').val());
		$('#multiDate').css('border-color', "#ccc");
	},
	beforeShowDay: function (date) {
		var highlight = eventDates[date];
		if (highlight) {
			return [true, "event", highlight];
		} else {
			return [true, '', ''];
		}
	}
});

function addAdvancePymtTable() {
	let tVal = '<tr><th style="text-align:center;"><div style="margin:0;" class="checkbox"><label><input type="checkbox" value="">Option 1</label></div></th><th style="text-align:center;"><div style="margin:0;" class="checkbox"><label><input type="checkbox" value="">Option 1</label></div></th></tr>';

	$('#advancePymtTableBody').append(tVal);
}

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
	let si = document.getElementsByClassName('si');
	let date = document.getElementsByClassName('date');
	let link1 = document.getElementsByClassName('link1');
	let hallComboName = document.getElementsByClassName('hallComboName');
	let hellComboId = document.getElementsByClassName('hellComboId');
	let timepickerFrom = document.getElementsByClassName('timepickerFrom');
	let timepickerTo = document.getElementsByClassName('timepickerTo');

	return {
		si1: si1,
		si: si,
		date: date,
		price: price,
		link1: link1,
		hallComboName: hallComboName,
		hellComboId: hellComboId,
		timepickerFrom: timepickerFrom,
		timepickerTo: timepickerTo
	}
}
