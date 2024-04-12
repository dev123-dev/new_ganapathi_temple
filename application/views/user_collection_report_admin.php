<div class="container" >
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<!--Heading And Refresh Button-->
	<div class="row form-group">
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<span class="eventsFont2">User Event Collection Report: <span class="samFont"><?php echo $events[0]->ET_NAME; ?></span></span>
		</div>
		<form id="approveId" enctype="multipart/form-data" method="post" accept-charset="utf-8">
			<!--HIDDEN FIELD USED FOR SELECTED CHECKBOX-->
			<input type="hidden" name="checkVal" id="checkVal"/>
			
			<!--HIDDEN FIELD USED FOR PAYMENT AND USER FILTER ON APPROVE-->
			<input type="hidden" name="paymentApprove" id="paymentApprove"/>
			<input type="hidden" name="userApprove" id="userApprove"/>
			
			<!--HIDDEN FIELD USED FOR SELECTED ID ON APPROVE-->
			<input type="hidden" name="selectApprove" id="selectApprove"/>
			
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
				<a style="width:24px; height:24px;cursor:pointer" class="pull-right" onclick="GetRefresh('<?=site_url()?>Report/user_collection_report_admin')" title="Refresh"><img title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>&nbsp;&nbsp;&nbsp;&nbsp;
				<?php if(isset($_SESSION['Authorise'])) { ?>
					<a class="pull-right" onclick="approveSubmit()" title="Authorise"><img style="width:24px; height:24px;margin-right:10px;cursor:pointer" title="Authorise" src="<?=site_url();?>images/check_icon.svg"/></a>
				<?php } ?>
			</div>
		</form>
	</div>

	<div class="row form-group">
		<form id="userFilters" enctype="multipart/form-data" method="post" accept-charset="utf-8">
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
				<select id="users" name="users" class="form-control" onchange="GetDataOnUser(this.value,'<?php echo site_url()?>Report/get_data_on_filter/1')">
					<option selected value="All Users">All Users</option>
					
					<?php foreach($users as $result) { ?>
						<?php if(isset($user)) { ?>
							<?php if($user == $result->USER_ID) { ?>
								<option selected value="<?php echo $result->USER_ID; ?>"><?php echo $result->USER_FULL_NAME; ?></option>
							<?php } else { ?>
								<option value="<?php echo $result->USER_ID; ?>"><?php echo $result->USER_FULL_NAME; ?></option>
							<?php } ?>
						<?php } else { ?>
							<option value="<?php echo $result->USER_ID; ?>"><?php echo $result->USER_FULL_NAME; ?></option>
						<?php } ?>
					<?php } ?>
				</select>
				 <!--HIDDEN FIELDS -->
				 <input type="hidden" name="users_id" id="users_id">
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
			  <select id="modeOfPayment" name="modeOfPayment" class="form-control" onchange="GetDataOnFilter(this.value,'<?php echo site_url()?>Report/get_data_on_filter/1')">
				<?php if(isset($payMethod)) {?>
					<?php if($payMethod == "All") { ?>
						<option selected value="All">All = &#8377;<?php if($All->PRICE != "") { echo $All->PRICE; } else { echo "0";} ?></option>
					<?php } else { ?>
						<option value="All">All = &#8377;<?php if($All->PRICE != "") { echo $All->PRICE; } else { echo "0";} ?></option>
					<?php } ?>
					<?php if($payMethod == "Cash") { ?>
						<option selected value="Cash">Cash = &#8377;<?php if($Cash->PRICE != "") { echo $Cash->PRICE; } else { echo "0"; } ?></option>
					<?php } else { ?>
						<option value="Cash">Cash = &#8377;<?php if($Cash->PRICE != "") { echo $Cash->PRICE; } else { echo "0"; } ?></option>
					<?php } ?>
					<?php if($payMethod == "Cheque") { ?>
						<option selected value="Cheque">Cheque = &#8377;<?php if($Cheque->PRICE != "") { echo $Cheque->PRICE; } else { echo "0"; } ?></option>
					<?php } else { ?>
						<option value="Cheque">Cheque = &#8377;<?php if($Cheque->PRICE != "") { echo $Cheque->PRICE; } else { echo "0"; } ?></option>
					<?php } ?>
					<?php if($payMethod == "Credit / Debit Card") { ?>
						<option selected value="Credit / Debit Card">Credit / Debit Card = &#8377;<?php if($Credit_Debit->PRICE != "") { echo $Credit_Debit->PRICE; } else { echo "0"; } ?></option>
					<?php } else { ?>
						<option value="Credit / Debit Card">Credit / Debit Card = &#8377;<?php if($Credit_Debit->PRICE != "") { echo $Credit_Debit->PRICE; } else { echo "0"; } ?></option>
					<?php } ?>
					<?php if($payMethod == "Direct Credit") { ?>
						<option selected value="Direct Credit">Direct Credit = &#8377;<?php if($Direct->PRICE != "") { echo $Direct->PRICE; } else { echo "0"; } ?></option>
					<?php } else { ?>
						<option value="Direct Credit">Direct Credit = &#8377;<?php if($Direct->PRICE != "") { echo $Direct->PRICE; } else { echo "0"; } ?></option>
					<?php } ?>
				<?php } else { ?>
						<option value="All">All = &#8377;<?php if($All->PRICE != "") { echo $All->PRICE; } else { echo "0";} ?></option>
						<option value="Cash">Cash = &#8377;<?php if($Cash->PRICE != "") { echo $Cash->PRICE; } else { echo "0"; } ?></option>
						<option value="Cheque">Cheque = &#8377;<?php if($Cheque->PRICE != "") { echo $Cheque->PRICE; } else { echo "0"; } ?></option>
						<option value="Credit / Debit Card">Credit / Debit Card = &#8377;<?php if($Credit_Debit->PRICE != "") { echo $Credit_Debit->PRICE; } else { echo "0"; } ?></option>
						<option value="Direct Credit">Direct Credit = &#8377;<?php if($Direct->PRICE != "") { echo $Direct->PRICE; } else { echo "0"; } ?></option>
				<?php } ?>
			  </select>
			  <!--HIDDEN FIELDS -->
			  <input type="hidden" name="paymentMethod" id="paymentMethod">
			</div>
		</form>
		
		<div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
			<div class="form-inline">
				<?php $amount = 0;
				foreach($TotalAmount as $result) { 
					$amount = (int)($amount) + (int)($result->ET_RECEIPT_PRICE);
				} ?>
				<label for="number" id="Amount" style="font-size:18px;margin-top:.3em;">Rs. <?php echo $amount; ?>/-</label>
			</div>
		</div>
		
		
		<div class="control-inline col-md-5 col-lg-5 col-sm-12 col-xs-12 text-right" style="font-size:15px;margin-top:.2em;">
			<label class="checkbox-inline">
				<input type="checkbox" id="all_users" name="all_users" onclick="selectCheckOptions(this.id, this.checked)">Select All
			</label>
			<label class="checkbox-inline">
				<input type="checkbox" id="this_page" name="this_page" onclick="selectCheckOptions(this.id, this.checked)">Select This Page
			</label>
		</div>
	</div>
</div>

<!--Datagrid -->
<div class="container" style="width: 1250px;">
	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow:hidden ;">
				<div id="eventCollectionContent">
				</div>
				<ul class="pagination pagination-sm">
					<?=$pages; ?>
				</ul>
			</div>
		</div>
	</div>
</div>

<!-- User Modal2 -->
<div id="myModalCheque" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content" style="padding-bottom:1em;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Cheque Details</h4>
			</div>
			<div class="modal-body" id="cheqdet" style="overflow-y: auto;max-height: 330px;">
			</div>
		</div>
	</div>
</div> 
<!-- User Modal2 -->
<div id="myModalCredit" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content" style="padding-bottom:1em;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Credit/Debit Details</h4>
			</div>
			<div class="modal-body" id="creditdet" style="overflow-y: auto;max-height: 330px;">
			</div>
		</div>
	</div>
</div> 
<script>

	//GET REFESH
	function GetRefresh(urlFirst) {
		url = "<?php echo site_url(); ?>Report/get_unset_session";
		$.post(url,{'select':'all_users'}, function(e) {
			location.href = urlFirst;
		});
		clearSessionValues();
	}

	function approveSubmit() {
		$('#selectApprove').val(JSON.parse(sessionStorage.getItem("SelectedReceiptID")));
		
		if($('#all_users').prop('checked') == true) {
			$('#checkVal').val("all_users");
		} else if($('#this_page').prop('checked') == true) {
			$('#checkVal').val("this_page");
		} else {
			$('#checkVal').val("");
		}		
		document.getElementById('paymentApprove').value = $('#modeOfPayment').val();
		document.getElementById('userApprove').value = $('#users').val();
		clearSessionValues();
		url = "<?php echo site_url(); ?>Report/approve_Submit";
		$("#approveId").attr("action",url)
		$("#approveId").submit();
	}
	
	//DATEFIELD AND FILTER CHANGE
	function GetDataOnUser(users,url) {
		clearSessionValues();
		document.getElementById('users_id').value = users;
		$("#userFilters").attr("action",url)
		$("#userFilters").submit();
	}
	
	//DATEFIELD AND FILTER CHANGE
	function GetDataOnFilter(payMode,url) {
		clearSessionValues();
		document.getElementById('users_id').value = $('#users').val();
		document.getElementById('paymentMethod').value = payMode;
		$("#userFilters").attr("action",url)
		$("#userFilters").submit();
	}

	function show_cheque(id,cheqNo,cheqDate,Bank,Branch,transactionId){
        var c_url ="<?php echo site_url(); ?>Report/View";
        $.ajax({
			url: c_url,
			data: {'id':id, 'cheqNo': cheqNo, 'cheqDate': cheqDate, 'Bank': Bank, 'Branch': Branch, 'TransactionId': transactionId},          
			type: 'post', 
			success: function(data){  
				if(id == '1') {
					$('#cheqdet').html(data);
					$('#myModalCheque').modal('show');  
				} else if(id == '2') {
					$('#creditdet').html(data);
					$('#myModalCredit').modal('show');  
				}
			},
			error: function(data) {
				alert("Error Occured!");
			}
		});         
    }

	var arrSelectedReceiptID = [];
	var arrLocalItems = []; 
	var arrItems = []; 
	var arrTotalItemsFromDB = [];
	var totItemsFromDB = 0; 

	$(document).ready(function() {
   		let arrTotDBItems = <?php echo $all_event_receipt_report; ?>;
		for(var m = 0; m < arrTotDBItems.length; m++) {
			arrTotalItemsFromDB.push(parseInt(arrTotDBItems[m]["ET_RECEIPT_ID"]));
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
	   	arrItems = <?php echo $event_receipt_report; ?>;
	   	$('#tblEventUserCollection').html("");
	   	// <div class="container" style="width:1300px"><div class="table-responsive" style="overflow-x:hidden;" ></div></div>
	   	$('#eventCollectionContent').html('<table class="table"><thead><tr><th style="border:1px solid #7d6363"><center></center></th><th style="border:1px solid #7d6363">Receipt No.</th><th style="border:1px solid #7d6363">Receipt Type</th><th style="border:1px solid #7d6363"><center>Receipt Name</center></th><th style="border:1px solid #7d6363"><center>Estimated Price</center></th><th style="border:1px solid #7d6363"><center>Description</center></th><th style="border:1px solid #7d6363"><center>Payment Mode</center></th><th style="border:1px solid #7d6363"><center>Quantity</center></th><th style="border:1px solid #7d6363"><center>Amount</center></th><th style="border:1px solid #7d6363"><center>Postage</center></th><th style="border:1px solid #7d6363"><center>Total</center></th><th style="border:1px solid #7d6363"><center>Payment Status</center></th><th style="border:1px solid #7d6363"><center>Payment Notes</center></th><th style="border:1px solid #7d6363"><center>Entered By</center></th></tr></thead><tbody id="tblEventUserCollection"></tbody></table>')
	    for(var i = 0; i < arrItems.length; i++) {
    		$('#tblEventUserCollection').append('<tr>');
    		$('#tblEventUserCollection').append('<input type="hidden" name="pageVal" id="pageVal"/>');

    		if(sessionStorage.getItem("SelectAll") !== null && sessionStorage.getItem("SelectAll") == "true") {
    			$("#all_users").prop('checked', true);
    			$('#tblEventUserCollection').append('<td style="border:1px solid #7d6363;padding:10px"><center><input id="checkerId_'+i+'" name="checkerId_'+i+'" type="checkbox" onchange="GetUnselect('+arrItems[i]["ET_RECEIPT_ID"]+',this.checked)" checked class="sel" /></center></td><td class="recId" id="recid_'+i+'" style="display:none;">'+arrItems[i]["ET_RECEIPT_ID"]+'</td>');
    		} else {
	    		if(sessionStorage.getItem("SelectedReceiptID") !== null && sessionStorage.getItem("SelectedReceiptID") != "") {
	    			if(arrSelectedReceiptID.indexOf(parseInt(arrItems[i]["ET_RECEIPT_ID"])) > -1) {
	    				arrLocalItems.push(parseInt(arrItems[i]["ET_RECEIPT_ID"]));
				 		$('#tblEventUserCollection').append('<td style="border:1px solid #7d6363;padding:10px"><center><input id="checkerId_'+i+'" name="checkerId_'+i+'" type="checkbox" onchange="GetUnselect('+arrItems[i]["ET_RECEIPT_ID"]+',this.checked)" checked class="sel" /></center></td><td class="recId" id="recid_'+i+'" style="display:none;">'+arrItems[i]["ET_RECEIPT_ID"]+'</td>');
					} else{
						$('#tblEventUserCollection').append('<td style="border:1px solid #7d6363;padding:10px"><center><input id="checkerId_'+i+'" name="checkerId_'+i+'" type="checkbox" onchange="GetUnselect('+arrItems[i]["ET_RECEIPT_ID"]+',this.checked)" class="sel" /></center></td><td class="recId" id="recid_'+i+'" style="display:none;">'+arrItems[i]["ET_RECEIPT_ID"]+'</td>');
					}
				}else{
					$('#tblEventUserCollection').append('<td style="border:1px solid #7d6363;padding:10px"><center><input id="checkerId_'+i+'" name="checkerId_'+i+'" type="checkbox" onchange="GetUnselect('+arrItems[i]["ET_RECEIPT_ID"]+',this.checked)" class="sel" /></center></td><td class="recId" id="recid_'+i+'" style="display:none;">'+arrItems[i]["ET_RECEIPT_ID"]+'</td>');
				}
			}

			$('#tblEventUserCollection').append('<td style="border:1px solid #7d6363;padding:10px">'+arrItems[i]["ET_RECEIPT_NO"] + '</td><td style="border:1px solid #7d6363;padding:10px">'+arrItems[i]["ET_RECEIPT_CATEGORY_TYPE"]+'</td><td style="border:1px solid #7d6363;padding:10px">'+arrItems[i]["ET_RECEIPT_NAME"]+'</td>');
			if(arrItems[i]["ET_RECEIPT_CATEGORY_TYPE"] == "Inkind" || arrItems[i]["ET_RECEIPT_CATEGORY_TYPE"] == "Jeernodhara-Inkind"  ) {
			$('#tblEventUserCollection').append('<td style="border:1px solid #7d6363;padding:10px">'+ arrItems[i]["IK_APPRX_AMT"] +'</td>');

			}else{
				$('#tblEventUserCollection').append('<td style="border:1px solid #7d6363;padding:10px">' +" " + '</td>');
			}

			if(arrItems[i]["ET_RECEIPT_CATEGORY_TYPE"] == "Inkind" || arrItems[i]["ET_RECEIPT_CATEGORY_TYPE"] == "Jeernodhara-Inkind" ) {
			$('#tblEventUserCollection').append('<td style="border:1px solid #7d6363;padding:10px">'+ arrItems[i]["IK_ITEM_DESC"] +'</td>');

			}else{
				$('#tblEventUserCollection').append('<td style="border:1px solid #7d6363;padding:10px">'+" " +'</td>');
			}


			if(arrItems[i]["ET_RECEIPT_PAYMENT_METHOD"] == "Cheque") {
				$('#tblEventUserCollection').append('<td style="border:1px solid #7d6363;padding:10px"><a class="log mymodelcancel" style="color:#800000;" onclick="show_cheque(1,\''+arrItems[i]["CHEQUE_NO"]+'\',\''+ arrItems[i]["CHEQUE_DATE"]+'\',\''+arrItems[i]["BANK_NAME"]+'\',\''+arrItems[i]["BRANCH_NAME"]+'\',\''+arrItems[i]["TRANSACTION_ID"]+'\')">'+arrItems[i]["ET_RECEIPT_PAYMENT_METHOD"]+'</a></td>');
    		} else if (arrItems[i]["ET_RECEIPT_PAYMENT_METHOD"] == "Credit / Debit Card") {
    			$('#tblEventUserCollection').append('<td style="border:1px solid #7d6363;padding:10px"><a class="log mymodelcancel" style="color:#800000;" onclick="show_cheque(2,\''+arrItems[i]["CHEQUE_NO"]+'\',\''+arrItems[i]["CHEQUE_DATE"]+'\',\''+arrItems[i]["BANK_NAME"]+'\',\''+arrItems[i]["BRANCH_NAME"]+'\',\''+arrItems[i]["TRANSACTION_ID"]+'\')">'+arrItems[i]["ET_RECEIPT_PAYMENT_METHOD"]+'</a></td>');
    		} else {
    			$('#tblEventUserCollection').append('<td style="border:1px solid #7d6363;padding:10px">'+arrItems[i]["ET_RECEIPT_PAYMENT_METHOD"]+'</td>');
    		}
    		if(arrItems[i]["ET_RECEIPT_CATEGORY_TYPE"] == 'Inkind') { 
    			$('#tblEventUserCollection').append('<td style="border:1px solid #7d6363;padding:10px">'+arrItems[i]["IK_ITEM_QTY"] +' '+ arrItems[i]["IK_ITEM_UNIT"]+'</td>');
    		} else {
    			$('#tblEventUserCollection').append('<td style="border:1px solid #7d6363;padding:10px">-</td>');
    		}
    		if(arrItems[i]["ET_RECEIPT_CATEGORY_TYPE"] != 'Inkind') { 
    			$('#tblEventUserCollection').append('<td style="border:1px solid #7d6363;padding:10px">'+arrItems[i]["ET_RECEIPT_PRICE"]+'</td>');
    		} else {
    			$('#tblEventUserCollection').append('<td style="border:1px solid #7d6363;padding:10px">-</td>');
    		}
    		$('#tblEventUserCollection').append('<td style="border:1px solid #7d6363;padding:10px">'+arrItems[i]["POSTAGE_PRICE"]+'</td>');
    		$('#tblEventUserCollection').append('<td style="border:1px solid #7d6363;padding:10px">'+(parseInt(arrItems[i]["ET_RECEIPT_PRICE"]) + parseInt(arrItems[i]["POSTAGE_PRICE"]))+'</td>');
    		$('#tblEventUserCollection').append('<td style="border:1px solid #7d6363;padding:10px">'+ arrItems[i]["PAYMENT_STATUS"] +'</td>');
    		$('#tblEventUserCollection').append('<td style="border:1px solid #7d6363;padding:10px">'+ arrItems[i]["ET_RECEIPT_PAYMENT_METHOD_NOTES"] +'</td>');
    		$('#tblEventUserCollection').append('<td style="border:1px solid #7d6363;padding:10px">'+ arrItems[i]["ET_RECEIPT_ISSUED_BY"] +'</td>');
			$('#tblEventUserCollection').append('</tr><br/>');
	    }
	    GetCheckedItems();
	});	

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

			$('#tblEventUserCollection').find("td.recId").each(function(index) {
				if(checker)
					$("#checkerId_"+index).prop('checked', true);
				else
					$("#checkerId_"+index).prop('checked', false);
			});
		} else {
			$("#all_users").prop('checked', false);			
			sessionStorage.setItem("SelectAll", "false");
			$('#tblEventUserCollection').find("td.recId").each(function(index) {
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

	function GetUnselect(receiptId,checker) {
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

</script>