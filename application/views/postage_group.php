<?php 
	//$this->output->enable_profiler(TRUE);
	//print_r("<pre>");
	//print_r($slvtPostageGrps."____".$postageCriteria);
	//print_r("</pre>");
?>
<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<!--Heading And Refresh Button-->
	<div class="row form-group">
		<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
			<span class="eventsFont2">SLVT POSTAGE GROUP </span>
		</div>
		<div class="col-lg-1 col-md-2 col-sm-2 col-xs-2" id="AddSub"  data-hint="Label Generation">
			<img class="pull-right" style="width:18px; height:18px; margin-right: -20px;" onClick="edit()" title="Postage Label Generation" src="<?=site_url();?>images/labelicon.png"/>
		</div>
		<div class="col-lg-1 col-md-2 col-sm-2 col-xs-2" id="AddLetters"  data-hint="Letter Generation">
			<a style="margin-right: -10px;" onClick="exportLetters()" title="Postage Letter Generation">
	          <span style="font-size: 17px;" class="glyphicon glyphicon-envelope"></span>
	        </a>
		</div>

		<div class="col-lg-1 col-md-2 col-sm-2 col-xs-2">
			<a style="margin-right: -80px; margin-top: -26px;" class="pull-right img-responsive" onClick="clearSessionValues()" href="<?=site_url()?>Postage/postage_group" title="Refresh"><img style="width: 18px; height: 18px;" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
		</div>
	</div>
</div>
<div class="container">
	<form id="frmPostage" method="POST">

		<div class="form-group col-lg-3 col-md-3 col-sm-4 col-xs-12" style="margin-bottom:1em;">
			<select id="slvtPostageGrps" name="slvtPostageGrps" class="form-control">
				<option value="All Category" <?php if($_SESSION['chosenCategory'] == 'All Category') echo 'selected'; else echo''; ?>>All Category</option>
				<option value="Seva" <?php if($_SESSION['chosenCategory'] == 'Seva') echo 'selected'; else echo ''; ?>>Seva</option>
				<option value="Donation" <?php if($_SESSION['chosenCategory'] == 'Donation') echo 'selected'; else echo ''; ?>>Donation</option>
				<option value="Kanike" <?php if($_SESSION['chosenCategory'] == 'Kanike') echo 'selected'; else echo ''; ?>>Kanike</option>
				<option value="Inkind" <?php if($_SESSION['chosenCategory'] == 'Inkind') echo 'selected'; else echo ''; ?>>Inkind</option>
				<option value="SRNS" <?php if($_SESSION['chosenCategory'] == 'SRNS') echo 'selected'; else echo ''; ?>>SRNS</option>		
				<option value="Shashwath" <?php if($_SESSION['chosenCategory'] == 'Shashwath') echo 'selected'; else echo ''; ?>>Shashwath</option>		
				<option value="Jeernodhara" <?php if($_SESSION['chosenCategory'] == 'Jeernodhara') echo 'selected'; else echo ''; ?>>Jeernodhara</option>	
			</select>	
		</div>

		<div class="form-group col-lg-3 col-md-3 col-sm-4 col-xs-12" style="margin-bottom:1em;">
			<select id="slvtPostageCriteria" name="slvtPostageCriteria" class="form-control">
				<option value="1" <?php if($_SESSION['chosenCriteria'] == '1') echo 'selected'; else echo''; ?>>No Criteria</option>
				<option value="2" <?php if($_SESSION['chosenCriteria'] == '2') echo 'selected'; else echo ''; ?>>Below Rs. 25000</option>
				<option value="3" <?php if($_SESSION['chosenCriteria'] == '3') echo 'selected'; else echo ''; ?>>Rs. 25000 & Above</option>
				<option value="4" <?php if($_SESSION['chosenCriteria'] == '4') echo 'selected'; else echo ''; ?>>Inkind</option>
			</select>
			<input type="hidden" name="postageCriteria" id="postageCriteria" value="<?php echo $_SESSION['chosenCriteria'] ?>" />
		</div>

		<div class="form-group col-lg-3 col-md-3 col-sm-4 col-xs-12" style="margin-bottom:1em;">
			<select id="postageAreaFilter" name="postageAreaFilter" class="form-control">
				<option value="All" <?php if($_SESSION['chosenArea'] == 'All') echo 'selected'; else echo''; ?>>All</option>
				<option value="Udupi" <?php if($_SESSION['chosenArea'] == 'Udupi') echo 'selected'; else echo''; ?>>Udupi</option>
				<option value="Other" <?php if($_SESSION['chosenArea'] == 'Other') echo 'selected'; else echo''; ?>>Other</option>
			</select>
			<input type="hidden" name="postageArea" id="postageArea"/>
		</div>

		<div class="form-group col-lg-12 col-md-3 col-sm-4 col-xs-12" style="margin-bottom:1em;">
			<div class="control-inline col-md-9 col-lg-9 col-sm-12 col-xs-12 " style="font-size:15px;margin-top:.2em;">
				<label class="checkbox-inline">
					<input type="checkbox" id="all_users" name="all_users" onclick="selectCheckOptions(this.id, this.checked)">Select All
				</label>
				<label class="checkbox-inline">
					<input type="checkbox" id="this_page" name="this_page" onclick="selectCheckOptions(this.id, this.checked)">Select This Page
				</label>
			</div>
		</div>

<!-- date fields start -->
	<div class="form-group col-lg-12 col-md-3 col-sm-4 col-xs-12" style="margin-bottom:1em;">
		<input type="hidden" name="date" value="<?=@$date; ?>" id="date" value="">
			<input type="hidden" name="load" id="load" value="">
			<input type="hidden" name="allDates" id="allDates" value="<?=@$allDates; ?>">
			 <input type="hidden" name="radioOpt" id="radioOpt" value="<?=@$radioOpt; ?>">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="radio form-group">
					<label> 
						<input id="multiDateRadio" class="eventsFont form-control" type="radio" value="" name="optradio" /> Single Date
					</label>&nbsp;&nbsp;&nbsp;
					<label>
						<input id="EveryRadio" class="eventsFont form-control" type="radio" value="" name="optradio"> Multiple Date
					</label>
				</div>
			</div>
			<!--SINGLE DATE -->
			<div class="multiDate">
				<div class="col-lg-2 col-md-2 col-sm-3 col-xs-5">
					<div class="input-group input-group-sm">
						<input style="border-radius:2px;" id="todayDate" name="todayDate" type="text" value="<?=@$date; ?>" class="form-control todayDate"  onchange="GetDataOnDate(this.value,'<?php echo site_url()?>Postage/slvt_postage_data')" placeholder="dd-mm-yyyy" readonly="readonly"/>
						<div class="input-group-btn">
							<button class="btn btn-default todayDateBtn" type="button">
								<i class="glyphicon glyphicon-calendar"></i>
							</button>
						</div>
					</div>
				</div>
			</div>

			<!--MULTI DATE -->
			<div class="EveryRadio" style="display:none;">
				<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
					<div class="form-group">
						<div class="input-group input-group-sm">
							<input name="fromDate" onchange="GetDataOnDate(this.value,'<?php echo site_url()?>Postage/slvt_postage_data')" id="fromDate" type="text" class="form-control fromDate2" value="<?=@$fromDate; ?>" placeholder="From: dd-mm-yyyy" readonly="readonly"/>
							<div class="input-group-btn">
								<button class="btn btn-default fromDate" type="button">
									<i class="glyphicon glyphicon-calendar"></i>
								</button>
							</div>	
						</div>		
					</div>			
				</div>				
				
				<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
					<div class="form-group">
						<div class="input-group input-group-sm">
							<input name="toDate" onchange="GetDataOnDate(this.value,'<?php echo site_url()?>Postage/slvt_postage_data')" id="toDate" type="text" value="<?=@$toDate; ?>" class="form-control toDate2" placeholder="To: dd-mm-yyyy" readonly="readonly"/>
							<div class="input-group-btn">
								<button class="btn btn-default toDate" type="button">
									<i class="glyphicon glyphicon-calendar"></i>
								</button>
							</div>
						</div>
					</div>
				</div>				
			</div>
			<!-- date field end -->
	</div>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-bordered" id="tblPostageGrp">
					<thead>
						<tr>
							<th></th>
							<th style="width: 15%;">Receipt No.</th>
							<th>Receipt Date</th>
							<th>Name</th>
							<th>Phone</th>
							<th>Address</th>
							<th>Payment Method</th>
							<th>OP</th>
						</tr>
					</thead>
					<tbody>
						<!-- <!-- <!-- <?php foreach($allCollection as $result) { ?>
							<tr class="row1">
								<td><?php echo $result->RECEIPT_NO; ?></td>
								<td><?php echo $result->RECEIPT_DATE; ?></td>
								<td><?php echo $result->RECEIPT_NAME; ?></td>
								<td><?php echo $result->RECEIPT_PHONE; ?></td>
								<td><?php echo $result->RECEIPT_ADDRESS; ?></td>
								<td><?php echo $result->RECEIPT_PAYMENT_METHOD; ?></td>
								<td class="text-center">
									<a style="border:none; outline: 0;" href="#" title="Edit Postage Address" ><img style="border:none; outline: 0;" onclick = "editPostageAddress(<?php echo $result->RECEIPT_ID ?>)" src="<?php echo	base_url(); ?>images/edit_icon.svg"></a>
								</td>	
							</tr>
						<?php } ?> --> 
					</tbody>
				</table>
				
			</div>
			<div class="row">
				<ul class="pagination pagination-sm" style="margin-left:15px;margin-top: -0.2em;">
					<?=$pages; ?>
				</ul>
				<?php if($total_rows != 0) { ?>
					<label  class="pull-right" style="font-size:18px;margin-right:15px;margin-top: -0.2em;"><?php echo $_SESSION['chosenCategory'] ?> Addresses: <strong><?php echo $total_rows ?></strong></label>
				<?php } else { ?>
					<label> </label>
				<?php } ?>
			</div>
		</div>

	</form>

	

</div>

<div>
	<div class="modal fade bs-example-modal-lg" id="lblGen" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Label Generation</h4>
				</div>
				<div class="modal-body labelGen" id="creditdet" style="overflow-y: auto;max-height: 80vmin;">
					<br/><label>Get Label Start From: </label> <input type=text oninput = "inputQuantity(this.value)" name=startFrom id=startFrom maxlength=2 style=width:10%;><br/>
				</div>
				
				<div class="modal-footer text-left" style="text-align:left;">
					<label>Are you sure you want to generate..?</label><br/>
					<button style="width: 30%;" type="button" class="btn btn-default sevaButton" onclick="checkForExport()" id="submit2">Generate</button>
					<button style="width: 30%;" type="button" class="btn btn-default sevaButton" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
</div>

<form id="editpostageAdrsForm" method="post" action="<?php echo site_url();?>Postage/postage_address_edit">
	<input type="hidden" value="" name="RECEIPT_ID" id="RECEIPT_ID"/>
</form>
<script>

//date script start
// document.getElementById('1').style.display = "block";
// 	$("#20").addClass("w5-border-red");
	
	var currentTime = new Date()
	var maxDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month

	$( ".todayDate" ).datepicker({
		//maxDate: maxDate,
		dateFormat: 'dd-mm-yy',
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50",
	});
	
	$(".fromDate2").datepicker({
		//maxDate: maxDate,
		dateFormat: 'dd-mm-yy',
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50",
	});
	
	$(".toDate2").datepicker({
		//maxDate: maxDate,
		dateFormat: 'dd-mm-yy',
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50",
	});
	
//date script end



	$(document).ready(function() {
		if('<?php echo $_SESSION['chosenCategory'] ?>' == 'Jeernodhara') {
			$('#slvtPostageCriteria').show();
		} else {
			$('#slvtPostageCriteria').hide();
		}
	});
	
	function checkForExport() {
		if($('#startFrom').val() == ""){
			  alert("Information","Please fill the Index Position");
			  return false;
		} else {		
			url = "<?php echo site_url(); ?>Postage/unset_session_postage";
			$.post(url,{'SelectedReceiptID':JSON.parse(sessionStorage.getItem("SelectedReceiptID"))}, function(e) {
				window.open('<?php echo site_url(); ?>GenerationPostageGroupFPDF?startFrom='+$('#startFrom').val(),'_blank'); 
				$('#lblGen').modal('toggle') = "none";
			});											
		}
	}

	//ON CHANGE OF SELECTION
	$('#slvtPostageGrps').on('change', function () {
		clearSessionValues();
		if($('#slvtPostageGrps').val() == "Jeernodhara") {
			$('#slvtPostageCriteria').show();
			$('#postageCriteria').val("1");
		}
		else {
			$('#slvtPostageCriteria').hide();
			$('#postageCriteria').val("1");
		}
		
		url = "<?php echo site_url(); ?>Postage/slvt_postage_data";
		$('#frmPostage').attr('action', url).submit();
	});

	$('#slvtPostageCriteria').on('change', function () {
		clearSessionValues();
		$('#postageCriteria').val($('#slvtPostageCriteria').val());
		url = "<?php echo site_url(); ?>Postage/slvt_postage_data";
		$('#frmPostage').attr('action', url).submit();
	});


	$('#postageAreaFilter').on('change', function () {
		clearSessionValues();
		$('#postageArea').val($('#postageAreaFilter').val());
		url = "<?php echo site_url(); ?>Postage/slvt_postage_data";
		$('#frmPostage').attr('action', url).submit();
	});


	

	//ON CLICK ADD BUTTON
	function edit() {
		var php_var = "<?php echo $total_rows; ?>";								
		if(php_var == '0') {
			alert('There are no Records to export for Label Generation.');
		} else {
			$('#lblGen').modal();
		}
	}

	function exportLetters() {
		var php_var = "<?php echo $total_rows; ?>";								
		if(php_var == '0') {
			alert('There are no Records to export for Letter Generation.');
		} else {
			url = "<?php echo site_url(); ?>Postage/unset_session_postage";
			$.post(url,{'SelectedReceiptID':JSON.parse(sessionStorage.getItem("SelectedReceiptID"))}, function(e) {
				window.open('<?php echo site_url(); ?>GenerationPostageLetterGroupFPDF','_blank');
			});		
		}
	}

	function inputQuantity(lblpos) { 
		if (isNaN(lblpos)){
			  document.getElementById('startFrom').value = '';
		} else if(document.getElementById('startFrom').value == 0) { 
			 document.getElementById('startFrom').value = '';
		} else if(lblpos < 25){
			tempPos = lblpos;
		} else {
			$('#startFrom').val(tempPos);
			console.log(tempPos);
			alert("Information","Quantity cannot exceed 24","OK");
		}
	}

	function editPostageAddress(RECEIPT_ID){
		$('#RECEIPT_ID').val(RECEIPT_ID);

		$('#editpostageAdrsForm').submit();
	}


	var arrSelectedReceiptID = [];
	var arrLocalItems = []; 
	var arrItems = []; 
	var arrTotalItemsFromDB = [];
	var totItemsFromDB = 0; 
	
	$(document).ready(function() {
		let arrTotDBItems = <?php echo $fullCollection; ?>;
		for(var m = 0; m < arrTotDBItems.length; m++) {
			arrTotalItemsFromDB.push(parseInt(arrTotDBItems[m]["RECEIPT_ID"]));
		}
		totItemsFromDB = arrTotalItemsFromDB.length;

		if(sessionStorage.getItem("SelectAll") == "true") {
   			sessionStorage.setItem("SelectedReceiptID",JSON.stringify(arrTotalItemsFromDB)); 	
   		}

	    if(sessionStorage.getItem("SelectedReceiptID") !== null && sessionStorage.getItem("SelectedReceiptID") != "") {
	    	arrSelectedReceiptID = JSON.parse(sessionStorage.getItem("SelectedReceiptID"));
	    } else {
	   		arrSelectedReceiptID = [];
	   	} 
	   	arrItems = <?php echo $allCollection; ?>;
	    for(var i = 0; i < arrItems.length; i++) {
	    	if(sessionStorage.getItem("SelectAll") !== null && sessionStorage.getItem("SelectAll") == "true") {
    			$("#all_users").prop('checked', true);
    			$('#tblPostageGrp').append('<tr class="row1"><td><center><input id="checkerId_'+i+'" type="checkbox" onchange="GetOnSelection('+arrItems[i]["RECEIPT_ID"]+',this.checked)" checked /></center></td><td class="recId" id="recid_'+i+'" style="display:none;">'+arrItems[i]["RECEIPT_ID"]+'</td><td>'+arrItems[i]["RECEIPT_NO"]+'</td><td>'+arrItems[i]["RECEIPT_DATE"]+'</td><td>'+arrItems[i]["RECEIPT_NAME"]+'</td><td>'+arrItems[i]["RECEIPT_PHONE"]+'</td><td>'+arrItems[i]["RECEIPT_ADDRESS"]+'</td><td>'+arrItems[i]["RECEIPT_PAYMENT_METHOD"]+'</td><td class="text-center"><a style="border:none; outline: 0;" href="#" title="Edit Postage Address" ><img style="border:none; outline: 0;" onclick = "editPostageAddress('+arrItems[i]["RECEIPT_ID"]+')" src="<?php echo base_url(); ?>images/edit_icon.svg"></a></td></tr>');
    		} else {
	    		if(sessionStorage.getItem("SelectedReceiptID") !== null && sessionStorage.getItem("SelectedReceiptID") != "") {
	    			if(arrSelectedReceiptID.indexOf(parseInt(arrItems[i]["RECEIPT_ID"])) > -1) {
	    				arrLocalItems.push(parseInt(arrItems[i]["RECEIPT_ID"]));
	    				$('#tblPostageGrp').append('<tr class="row1"><td><center><input id="checkerId_'+i+'" type="checkbox" onchange="GetOnSelection('+arrItems[i]["RECEIPT_ID"]+',this.checked)" checked /></center></td><td class="recId" id="recid_'+i+'" style="display:none;">'+arrItems[i]["RECEIPT_ID"]+'</td><td>'+arrItems[i]["RECEIPT_NO"]+'</td><td>'+arrItems[i]["RECEIPT_DATE"]+'</td><td>'+arrItems[i]["RECEIPT_NAME"]+'</td><td>'+arrItems[i]["RECEIPT_PHONE"]+'</td><td>'+arrItems[i]["RECEIPT_ADDRESS"]+'</td><td>'+arrItems[i]["RECEIPT_PAYMENT_METHOD"]+'</td><td class="text-center"><a style="border:none; outline: 0;" href="#" title="Edit Postage Address" ><img style="border:none; outline: 0;" onclick = "editPostageAddress('+arrItems[i]["RECEIPT_ID"]+')" src="<?php echo base_url(); ?>images/edit_icon.svg"></a></td></tr>');
	    			} else {
	    				$('#tblPostageGrp').append('<tr class="row1"><td><center><input id="checkerId_'+i+'" type="checkbox" onchange="GetOnSelection('+arrItems[i]["RECEIPT_ID"]+',this.checked)" /></center></td><td class="recId" id="recid_'+i+'" style="display:none;">'+arrItems[i]["RECEIPT_ID"]+'</td><td>'+arrItems[i]["RECEIPT_NO"]+'</td><td>'+arrItems[i]["RECEIPT_DATE"]+'</td><td>'+arrItems[i]["RECEIPT_NAME"]+'</td><td>'+arrItems[i]["RECEIPT_PHONE"]+'</td><td>'+arrItems[i]["RECEIPT_ADDRESS"]+'</td><td>'+arrItems[i]["RECEIPT_PAYMENT_METHOD"]+'</td><td class="text-center"><a style="border:none; outline: 0;" href="#" title="Edit Postage Address" ><img style="border:none; outline: 0;" onclick = "editPostageAddress('+arrItems[i]["RECEIPT_ID"]+')" src="<?php echo base_url(); ?>images/edit_icon.svg"></a></td></tr>');
	    			}
	    		} else {
	    			$('#tblPostageGrp').append('<tr class="row1"><td><center><input id="checkerId_'+i+'" type="checkbox" onchange="GetOnSelection('+arrItems[i]["RECEIPT_ID"]+',this.checked)" /></center></td><td class="recId" id="recid_'+i+'" style="display:none;">'+arrItems[i]["RECEIPT_ID"]+'</td><td>'+arrItems[i]["RECEIPT_NO"]+'</td><td>'+arrItems[i]["RECEIPT_DATE"]+'</td><td>'+arrItems[i]["RECEIPT_NAME"]+'</td><td>'+arrItems[i]["RECEIPT_PHONE"]+'</td><td>'+arrItems[i]["RECEIPT_ADDRESS"]+'</td><td>'+arrItems[i]["RECEIPT_PAYMENT_METHOD"]+'</td><td class="text-center"><a style="border:none; outline: 0;" href="#" title="Edit Postage Address" ><img style="border:none; outline: 0;" onclick = "editPostageAddress('+arrItems[i]["RECEIPT_ID"]+')" src="<?php echo base_url(); ?>images/edit_icon.svg"></a></td></tr>');
	    		}
		    }
		}
	});	

	function GetOnSelection(receiptId,checker) {
		if(checker) {
			arrSelectedReceiptID.push(parseInt(receiptId));
			arrLocalItems.push(parseInt(receiptId));	
		} else {
			const sindex = arrSelectedReceiptID.indexOf(receiptId);
			const lindex = arrLocalItems.indexOf(receiptId);
			if (sindex > -1) {
				arrSelectedReceiptID.splice(sindex, 1);
			}

			if(lindex > -1) {
				arrLocalItems.splice(lindex, 1);
			}
		}
		sessionStorage.setItem("SelectedReceiptID",JSON.stringify(arrSelectedReceiptID));
		GetCheckedItems();
	}

	function clearSessionValues(){
		sessionStorage.removeItem("SelectedReceiptID");
		sessionStorage.removeItem("SelectAll");
	}

	function selectCheckOptions(eleId, checker) {
		if(eleId == "all_users") {
			$("#this_page").prop('checked', false);	
			
			if(checker) {
				sessionStorage.setItem("SelectAll", "true");
				arrSelectedReceiptID = arrTotalItemsFromDB;
			}
			else {
				sessionStorage.setItem("SelectAll", "false");
				arrSelectedReceiptID = [];
				arrLocalItems = [];
			}

			$('#tblPostageGrp').find("td.recId").each(function(index) {
				if(checker)
					$("#checkerId_"+index).prop('checked', true);
				else
					$("#checkerId_"+index).prop('checked', false);
			});
		} else {
			$("#all_users").prop('checked', false);			
			sessionStorage.setItem("SelectAll", "false");
			$('#tblPostageGrp').find("td.recId").each(function(index) {
				if(checker) {
					if(arrSelectedReceiptID.indexOf(parseInt($('#recid_'+index).html())) == -1) {
						arrSelectedReceiptID.push(parseInt($('#recid_'+index).html()));
						arrLocalItems.push(parseInt($('#recid_'+index).html()));	
						$("#checkerId_"+index).prop('checked', true);	
					}
				}
				else {
					const sindex = arrSelectedReceiptID.indexOf(parseInt($('#recid_'+index).html()));
					const lindex = arrLocalItems.indexOf(parseInt($('#recid_'+index).html()));
					if (sindex > -1) {
						arrSelectedReceiptID.splice(sindex, 1);
					}

					if(lindex > -1) {
						arrLocalItems.splice(lindex, 1);	
					}
					$("#checkerId_"+index).prop('checked', false);
				}
			});
		}
		sessionStorage.setItem("SelectedReceiptID",JSON.stringify(arrSelectedReceiptID));
		GetCheckedItems();
	}

	function GetCheckedItems() {
		if(sessionStorage.getItem("SelectAll") === null) {
			if(arrItems.length != 0) {
				if(arrLocalItems.length == arrItems.length) {
					document.getElementById("this_page").checked = true;
				} else {
					document.getElementById("this_page").checked = false;
				}
			}
			sessionStorage.setItem("SelectAll", "false");
		} else if(sessionStorage.getItem("SelectAll") == "false") {
			if(arrSelectedReceiptID.length == totItemsFromDB) {
				document.getElementById("all_users").checked = true;
				document.getElementById("this_page").checked = false;
				sessionStorage.setItem("SelectAll", "true");
				return;
			}

			if(arrItems.length != 0) {
				if(arrLocalItems.length == arrItems.length) {
					document.getElementById("this_page").checked = true;
				} else {
					document.getElementById("this_page").checked = false;
				}
			}
		} else if(sessionStorage.getItem("SelectAll") == "true") {
			if(arrSelectedReceiptID.length != totItemsFromDB) {
				document.getElementById("all_users").checked = false;
				sessionStorage.setItem("SelectAll", "false");
			} else {
				document.getElementById("all_users").checked = true;
			}
		}
	}

  
   

   // DATE CHANGE FUNCTION START
function GetDataOnDate(receiptDate,url) {
		between = [];
		document.getElementById('date').value = receiptDate;
		// document.getElementById('load').value = "DateChange";
		var sDate1 = "";
		var start = $("#fromDate").datepicker("getDate");
		var end = $("#toDate").datepicker("getDate");
		var todayDate = $('#todayDate').val();
		
		currentDate = new Date(start)
		between = [];
		while (currentDate <= end) { 
			between.push(("0" + currentDate.getDate()).slice(-2) + "-" + ("0" + (currentDate.getMonth() + 1)).slice(-2) + "-" + currentDate.getFullYear());	
			currentDate.setDate(currentDate.getDate() + 1);
		}
		
		if(between.length == 0)
			between.push(("0" + currentDate.getDate()).slice(-2) + "-" + ("0" + (currentDate.getMonth() + 1)).slice(-2) + "-" + currentDate.getFullYear());
		
		newDate = between.join("|")

		document.getElementById('allDates').value = newDate;
		$("#frmPostage").attr("action",url)
		
		if(document.getElementById("EveryRadio").checked) {
			if(start && end) {
				$("#frmPostage").submit();
			}
		} else {
			if(todayDate)
				$("#frmPostage").submit();
		}
	}

   // DATE CHANGE FUNCTION END
 
 // DATE CHANGE FUNCTION DEFAULT LOADING START
    if("<?=$radioOpt; ?>" == "date") {
		$('#multiDateRadio').attr("checked", "checked")
		$('#EveryRadio').css('pointer-event','none');
		$('#multiDateRadio').css('pointer-event','auto');
		$('#selDate').html("");
		$('.multiDate').fadeIn();
		$('#fromDate').val("");
		$('#toDate').val("");
		$('.EveryRadio').hide();
		$('#radioOpt').val("date");
		$('#radioOptHidden').val("date");
	} else {
		$('#EveryRadio').css('pointer-event','auto');
		$('#multiDateRadio').css('pointer-event','none');
		$('.EveryRadio').fadeIn();
		$('#selDate').html("");
		$('.multiDate').hide();
		$('#radioOpt').val("multiDate");
		$('#radioOptHidden').val("multiDate");
		$('#EveryRadio').attr("checked", "checked")
	}
	
	$('#EveryRadio').on('click', function() {

		$('#EveryRadio').css('pointer-event','auto');
		$('#multiDateRadio').css('pointer-event','none');
		$('.EveryRadio').fadeIn();
		$('#selDate').html("");
		$('.multiDate').hide();
		$('#radioOpt').val("multiDate");
		$('#radioOptHidden').val("multiDate");
		$('#todayDate').datepicker('setDate', null);
	});
	
	$('#multiDateRadio').on('click', function() {

		$('#EveryRadio').css('pointer-event','none');
		$('#multiDateRadio').css('pointer-event','auto');
		$('#selDate').html("");
		$('.multiDate').fadeIn();
		$('#fromDate').val("");
		$('#toDate').val("");
		$('.EveryRadio').hide();
		$('#radioOpt').val("date");
		$('#radioOptHidden').val("date");
		$('#todayDate').datepicker('setDate', null);
	});
	
	$('.todayDateBtn').on('click', function() {
		$( ".todayDate" ).focus();
	})
	
	$('.toDate').on('click', function() {
		$( ".toDate2" ).focus();
	})
	
	$('.fromDate').on('click', function() {
		$( ".fromDate2" ).focus();
	})
 //DATE FUNCTION DEFAULT LOADING END


	
</script>