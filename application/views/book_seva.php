<?php //$this->output->enable_profiler(true); ?>
<?php 
	// print_r($_SESSION);
?>
<style>
th, td {
    padding: 10px;
}
</style>
<div class="container">
	<img class="img-responsive bgImg2 bg1" src="<?=site_url()?>images/TempleLogo.png" />
	<img class="img-responsive bgImg2 bg2" src="<?=site_url()?>images/LAKSHMI.jpg" style="display:none;" />
	<img class="img-responsive bgImg2 bg3" src="<?=site_url()?>images/HANUMANTHA.jpg" style="display:none;" />
	<img class="img-responsive bgImg2 bg4" src="<?=site_url()?>images/GARUDA.jpg" style="display:none;" />
	<img class="img-responsive bgImg2 bg5" src="<?=site_url()?>images/GANAPATHI.jpg" style="display:none;" />
	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="col-lg-4 col-md-4  col-sm-4 col-xs-12">
				<span class="eventsFont2">Seva Booking</span>
			</div>
			<div class="col-lg-4  col-md-5 col-sm-6 col-xs-6">
				<span class="eventsFont2 samFont1"></span>
			</div>
			<div class="col-lg-offset-2 col-lg-2  col-md-offset-0 col-md-3 col-sm-offset-0 col-sm-2 col-xs-offset-3 col-xs-3">
				<a style="width:24px; height:24px" class="pull-right img-responsive" href="<?=site_url()?>SevaBooking/book_Seva" titile="Reset">
					<img title="reset" src="<?=site_url();?>images/refresh.svg" />
				</a>
			</div>
		</div>
	</div>

	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="col-lg-6 col-md-6 col-sm-6 show-large hidden-xs">
				<span class="eventsFont2">Booking Date:
					<?=date("d-m-Y")?>
				</span>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
				<div class="form-group">
					<label for="name">Name
						<span style="color:#800000;">*</span>
					</label>
					<input type="text" class="form-control form_contct2" id="name" placeholder="" name="name" onkeyup="alphaonly(this)">
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
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<div class="col-lg-7 col-md-12 col-sm-6 col-xs-12">
				<div class="form-group">
					<label for="DeityCombo">Deity </label>
					<select onChange="deityComboChange();" id="deityCombo" class="form-control">
						<?php foreach($deity as $result) { ?>
						<option value="<?=$result['DEITY_ID']; ?>">
							<?=$result['DEITY_NAME']; ?>
						</option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-9 col-xs-12">
				<div class="form-group">
					<label for="seva">Seva </label>
					<select onChange="sevaComboChange();" id="sevaCombo" class="form-control">

					</select>					
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 deityCol">
			<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 isSeva1">
				<div class="form-group">
					<label for="seva" style="margin-right: 8px;" class="pull-left">Seva Date: <span style="color:#800000;">*</span></label>
				</div>
				<div style="clear:both;" class="form-group">
					<div class="radio">
						<a class="hideAdd" onClick="checkConfirmTime('<?php echo date('d-m-Y');?>');">
							<img style="width:24px; height:24px" class="img-responsive pull-right" title="Add Seva" src="<?=site_url();?>images/add.svg"
							/>
						</a>
					</div>
					<div class="multiDate">
						<div class="input-group input-group-sm col-lg-6 col-md-6 col-sm-8 col-xs-7">
							<input id="multiDate" type="text" value="" class="form-control todayDate2" placeholder="dd-mm-yyyy" readonly = "readonly"/>
							<div class="input-group-btn">
								<button class="btn btn-default todayDate" type="button">
									<i class="glyphicon glyphicon-calendar"></i>
								</button>
							</div>
						</div>
					</div>
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
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="table-responsive">
					<table id="eventSeva" class="table table-bordered">
						<thead>
							<tr>
								<th>Deity Name.</th>
								<th>Seva Name</th>
								<th>Seva Date</th>
								<th style="width:50px;">Remove</th>
							</tr>
						</thead>
						<tbody id="eventUpdate">
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

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
</div>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Seva Booking Preview</h4>
			</div>
			<div class="modal-body" id="creditdet" style="overflow-y: auto;max-height: 80vmin;">

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
<input type="hidden" id="radioOpt" value="multiDateRadio" />
<!-- single Date -->
<div class="container">
	<center>
		<button type="button" onClick="validateSubmit();" class="btn btn-default btn-lg">
			<span class="glyphicon glyphicon-print"></span> Submit & Print</button>
	</center>
</div>
<script>

	function alphaonly(input) {
	  var regex=/[^a-z& ]/gi;
	  input.value=input.value.replace(regex,"");
	}


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
		
		if (tableContent['sevaName'].length == 0) {
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

		let sevaName = [];
		let date = [];
		let sevaId = [];
		let userId = [];
		let deityId = [];
		let deityName = [];
		let isSeva = [];
		
		let url = "<?=site_url()?>SevaBooking/generateBookingReceipt";
		
		for (let i = 0; i < tableContent['sevaName'].length; ++i) {
			sevaName[i] = tableContent['sevaName'][i].innerHTML.trim();
			isSeva[i] = tableContent['isSeva'][i].innerHTML.trim();
			deityName[i] = tableContent['deityName'][i].innerHTML.trim();
			date[i] = tableContent['date'][i].innerHTML.trim();
			sevaId[i] = tableContent['sevaId'][i].innerHTML.trim();
			userId[i] = tableContent['userId'][i].innerHTML.trim();
			deityId[i] = tableContent['deityId'][i].innerHTML.trim();
		}

		$.post(url, {'sevaName': JSON.stringify(sevaName), 'deityName': JSON.stringify(deityName), 'date': JSON.stringify(date), 'sevaId': JSON.stringify(sevaId), 'userId': JSON.stringify(userId), 'deityId': JSON.stringify(deityId), 'isSeva': JSON.stringify(isSeva), 'name': name, 'number': number, 'address': address}, function (e) {
			console.log(e)
			if (e == "success")
				location.href = "<?=site_url()?>SevaBooking/printBookingReceipt";
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
		
		if($('#phone').val() != "") {
			if($('#phone').val().length < 10) {
				alert("Information", "Please add a 10 digit mobile or a 11 digit landline.");
				return;
			}
		}
		
		//TO CHECK FOR TIME ALLOWED TO ENTER ENDS HERE

		let count = 0;
		let number = $('#phone').val()
		let name = $('#name').val()
		let address = $('#address').val();
		let tableContent = getTableValues();
		
		if (tableContent['sevaName'].length == 0) {
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

		let sevaName = [];
		
		let date = [];
		
	
		let sevaId = [];
		let userId = [];
		let deityId = [];
		let deityName = [];
		let isSeva = [];
		let url = "<?=site_url()?>Receipt/generateDeityReceipt";

		$('#eventUpdate2').html("");

		$('.modal-body').html('<div class="table-responsive"><table class="table table-bordered"><thead><tr><th>Deity Name</th><th>Seva Name</th><th>Seva Date</th></tr></thead><tbody id="eventUpdate2"></tbody></table></div>')

		for (i = 0; i < tableContent['sevaName'].length; ++i) {
			$('#eventUpdate2').append("<tr>");
			$('#eventUpdate2').append("<td>" + tableContent['deityName'][i].innerHTML + "</td>");
			$('#eventUpdate2').append("<td>" + tableContent['sevaName'][i].innerHTML + "</td>");
			$('#eventUpdate2').append("<td>" + tableContent['date'][i].innerHTML + "</td>");
			$('#eventUpdate2').append("</tr><br/>");
		}

		$('.modal-body').append("<label>DATE:</label> " + "<?=date('d-m-Y'); ?>" + "<br/>");
		$('.modal-body').append("<label>NAME:</label> " + name + "");
		if (number)
			$('.modal-body').append(",&nbsp;&nbsp;<label>NUMBER:</label> " + number + "");
		
		if (address)
			$('.modal-body').append(",&nbsp;&nbsp;<label>Address:</label> " + address + "");

		$('.modal-body').append("<br/>");

		$('.modal').modal();
		$('.bs-example-modal-lg').focus();
	}

	function deityComboChange() {
		bgNo = $('#deityCombo').val();
		$('#sevaCombo').html("");
		for (let i = 0; i < arr.length; ++i) {
			if (arr[i]['DEITY_ID'] == bgNo)
				$('#sevaCombo').append('<option value="' + arr[i]['DEITY_ID'] + "|" + arr[i]['SEVA_ID'] + "|" + arr[i]['SEVA_NAME'] + "|" + arr[i]['USER_ID'] + "|" + arr[i]['SEVA_PRICE'] + "|" + arr[i]['QUANTITY_CHECKER'] + "|" + arr[i]['IS_SEVA'] + '">' + arr[i]['SEVA_NAME'] + '</option>');
		}

		for (i = 1; i <= 5; ++i)
			if (i == bgNo)
				$('.bg' + i).fadeIn("slow");
			else
				$('.bg' + i).hide();

		sevaComboChange();
	}

	(function () {
		arr = <?php echo $sevas; ?>;
		
		for (let i = 0; i < arr.length; ++i) {
			if (arr[i]['DEITY_ID'] == 1)
				$('#sevaCombo').append('<option value="' + arr[i]['DEITY_ID'] + "|" + arr[i]['SEVA_ID'] + "|" + arr[i]['SEVA_NAME'] + "|" + arr[i]['USER_ID'] + "|" + arr[i]['SEVA_PRICE'] + "|" + arr[i]['IS_SEVA'] + '">' + arr[i]['SEVA_NAME'] + '</option>');
		}

		let sevaCombo = getSevaCombo();
		deityComboChange();
	}());

	var price = 0;
	var total = 0;

	function sevaComboChange() {
		eventSeva = $('#sevaCombo').val();
		eventSeva = eventSeva.split("|");
		let sevaCombo = getSevaCombo();
		if ($('#radioOpt').val() != "EveryRadio") {
			if (sevaCombo.isSeva == "0") {
				$('.isSeva1').hide();
				$('.showAdd').show();
			} else {
				$('.isSeva1').fadeIn("slow");
				$('.showAdd').hide();
			}

			if (sevaCombo.quantityChecker == "1") {
				$('.qtyOpt').fadeIn("slow");
			} else {
				$('.qtyOpt').hide();
			}
		} else {

		}

		$('#setPrice').html(sevaCombo.sevaPrice);

		if ($('#radioOpt').val() != "EveryRadio") {
			if (sevaCombo.quantityChecker == "1") {
				$('.qtyOpt').fadeIn("slow");
			} else {
				$('.qtyOpt').hide();
			}
		} else {

		}
	}

	var currentTime = new Date()
	var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
	var maxDate = new Date(currentTime.getFullYear(), currentTime.getMonth() + 12, +0); // one day before next month
	
	function checkConfirmTime(date) {
		$.ajax({
            type: "POST",
            url: "<?php echo base_url();?>Receipt/check_eod_confirm_time",
            success: function (response) {
				if(response == 0){
					addRow();
				} else {
					alert("Information","The EOD for " +date+ " already generated");
				}
			}
        }); 
	}

	function addRow() {
		let tableContent = getTableValues();
		
		let duplicate = checkDuplicate();
		if (duplicate != 0)
			return;

		if (tableContent['sevaName'].length > 0 && $('#radioOpt').val() != "multiDateRadio") {
			alert("Information", "Please remove added seva dates to add new recurring seva dates")
			return;
		}

		let name = $('#name').val()
		let number = $('#number').val()
		let sevaCombo1 = getSevaCombo();
		let sevaCombo = $('#sevaCombo option:selected').html();
		let sevaName = sevaCombo1.sevaName;
		let isSeva = sevaCombo1.isSeva;
		let deityId = sevaCombo1.deityId;
		let userId = sevaCombo1.userId;
		let sevaId = sevaCombo1.sevaId;
		let deityCombo = $('#deityCombo option:selected').html().trim();
		let date = "";
		let count = "";

		date = $("#multiDate").val();
		
		count = validate("multiDate","name");

		if (!count) {
			alert("Information", "Please fill required fields", "OK");
			return;
		}

		let si = $('#eventSeva tr:last-child td:first-child').html();
		if (!si)
			si = 1
		else
			++si;

		let amt = 0;

		$('#multiDate').val("");
		$('#selDate').html("");
		$('#multiDate').datepicker('setDate', null);

		
		$('#eventSeva').append('<tr class="' + si + ' si1"><td style="display:none;" class="si">' + si + '</td><td class="deityName">' + deityCombo + '</td><td class="sevaCombo">' + sevaCombo + '</td><td class="date">' + date + '</td><td class="link1"><a style="cursor:pointer;" onClick="updateTable(' + si + ');"><img style="width:24px; height:24px;" title="delete" src="<?=base_url()?>images/delete1.svg"></a></td><td style="display:none;" class="sevaName">' + sevaName + '</td><td style="display:none;" class="deityId">' + deityId + '</td><td style="display:none;" class="userId">' + userId + '</td><td style="display:none;" class="sevaId">' + sevaId + '</td><td style="display:none;" class="isSeva">' + isSeva + '</td></tr>');
		si++;
		
		let tableContent2 = getTableValues();
		
		if(tableContent2['sevaName'].length == 1)
			$('.hideAdd').hide();

		between = []
	}

	function updateTable(si) {
		let si1 = document.getElementsByClassName(si);
		si1[0].remove();
		let tableValues = getTableValues();
		
		for (let i = 0; i < tableValues['sevaCombo'].length; ++i) {
			tableValues['si'][i].innerHTML = (i + 1);
			tableValues['link1'][i].innerHTML = '<a style="cursor:pointer;" onClick="updateTable(' + (i + 1) + ');"><img style="width:24px; height:24px;" title="delete" src="<?=base_url()?>images/delete1.svg"></a>';
			tableValues['si1'][i].className = (i + 1) + " si1";
		}

		let tableContent = getTableValues();

		if (tableContent['sevaName'].length == 0) {
			$('#EveryRadio').attr('disabled', false);
			$('#multiDateRadio').attr('disabled', false);
			$('.hideAdd').fadeIn();
		}
	}

	$("#multiDate").datepicker({
		minDate: minDate,
		maxDate: maxDate,
		dateFormat: 'dd-mm-yy',
		onSelect: function (selectedDate) {
			$('#selDate').html($('#multiDate').val());
			$('#multiDate').css('border-color', "#ccc");
		}
	});

	function checkDuplicate() {
		let duplicate = 0;
		
		let sevaCombo1 = getSevaCombo();
		let sevaName = sevaCombo1.sevaName;
		let tableValues = getTableValues();
		if (between.length == 0) {
			date = $('#multiDate').val()
		}

		for (let j = 0; j < tableValues['sevaName'].length; ++j) {
			if (duplicate != 0)
				break;
			
			if (date == tableValues['date'][j].innerHTML.trim() && sevaName == tableValues['sevaName'][j].innerHTML.trim() && tableValues['deityId'][j].innerHTML.trim() == sevaCombo1.deityId) {
				alert("Information", sevaName + " Already Exists on " + date)
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

	function dateRange() {
		var currentTime = new Date()
		var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
		var maxDate = new Date(currentTime.getFullYear(), currentTime.getMonth() + 12, +0); // one day before next month
		$("#toDate").datepicker({
			minDate: minDate,
			maxDate: maxDate,
			dateFormat: 'dd-mm-yy'
		});
	}

	function getSevaCombo() {
		let sevaCombo = $('#sevaCombo option:selected').val();
		console.log(sevaCombo);
		sevaCombo = sevaCombo.split("|");
		console.log(sevaCombo);
		return {
			deityId: sevaCombo[0],
			sevaId: sevaCombo[1],
			sevaName: sevaCombo[2],
			userId: sevaCombo[3],
			sevaPrice: sevaCombo[4],
			quantityChecker: sevaCombo[5],
			isSeva: sevaCombo[6]
		}
	}

	function getTableValues() {
		let si1 = document.getElementsByClassName('si1');
		let si = document.getElementsByClassName('si');
		let sevaCombo = document.getElementsByClassName('sevaCombo');
		
		let date = document.getElementsByClassName('date');
		
		
		let link1 = document.getElementsByClassName('link1');
		let sevaName = document.getElementsByClassName('sevaName');
		let deityName = document.getElementsByClassName('deityName');
		let sevaId = document.getElementsByClassName('sevaId');
		let userId = document.getElementsByClassName('userId');
		let deityId = document.getElementsByClassName('deityId');
		let quantityChecker = document.getElementsByClassName('quantityChecker');
		let isSeva = document.getElementsByClassName('isSeva');

		return {
			si1: si1,
			si: si,
			sevaCombo: sevaCombo,
			sevaName: sevaName,
			date: date,
			price: price,
			deityName: deityName,
			link1: link1,
			sevaId: sevaId,
			userId: userId,
			deityId: deityId,
			isSeva: isSeva,
			quantityChecker: quantityChecker
		}
	}
</script>