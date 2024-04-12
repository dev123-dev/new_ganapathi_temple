<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<!--Heading And Refresh Button-->
	<div class="row form-group">
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<span class="eventsFont2">E.O.D. User Collection (<?php echo @$UserDate; ?>) - <?php echo @$UserName; ?></span>
		</div>
		<form method="post" id="backEod" action="<?=@$_SESSION['actual_link2']; ?>" style="display:none;">
					<input type="hidden" name="eodDate" value="<?=@$_SESSION['selectedDate']?>">
					<input type="hidden" name="receiptType" value="<?=@$_SESSION['receiptType']?>">
		</form>

		<form id="approveId" enctype="multipart/form-data" method="post" accept-charset="utf-8">
			<!--HIDDEN FIELD USED FOR SELECTED CHECKBOX-->
			<input type="hidden" name="userIdChk" id="userIdChk" />
			<input type="hidden" name="userNameChk" id="userNameChk"/>
			<input type="hidden" name="dateChk" id="dateChk"/>
		
			<!--HIDDEN FIELD USED FOR SELECTED CHECKBOX-->
			<input type="hidden" name="checkVal" id="checkVal"/>
			
			<!--HIDDEN FIELD USED FOR PAYMENT AND USER FILTER ON APPROVE-->
			<input type="hidden" name="paymentApprove" id="paymentApprove"/>
			
			<!--HIDDEN FIELD USED FOR SELECTED ID ON APPROVE-->
			<input type="hidden" name="selectApprove" id="selectApprove"/>
			
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">			
				<a class="pull-right img-responsive" href="<?=$_SESSION['actual_link'];?>" title="back"><img style="width:24px; height:24px;margin-right:10px;cursor:pointer" title="Back" src="<?=site_url();?>images/back_icon.svg"/>
				</a>
			</div>
		</form>
	</div>
	
	<div class="row form-group">
		<form id="userFilters" enctype="multipart/form-data" method="post" accept-charset="utf-8">
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
			  <select id="modeOfPayment" name="modeOfPayment" class="form-control" onchange="GetDataOnFilter(this.value,'<?php echo site_url()?>EOD/get_data_on_userFilter/1','<?php echo $UserDate ?>','<?php echo $UserName ?>','<?php echo $UserId ?>')">
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
			  <input type="hidden" name="userId" id="userId" />
			  <input type="hidden" name="userName" id="userName"/>
			  <input type="hidden" name="date" id="date"/>
			</div>
		</form>
		<div style="display:none;" class="control-inline col-md-9 col-lg-9 col-sm-12 col-xs-12 text-right" style="font-size:15px;margin-top:.2em;">
			<?php if(isset($_SESSION['all_users'])) { ?>
				<label class="checkbox-inline">
					<input type="checkbox" id="all_users" name="all_users" checked onclick="selectOnlyThis(this.id)">Select All
				</label>
			<?php } else { ?>
				<label class="checkbox-inline">
					<input type="checkbox" id="all_users" name="all_users" onclick="selectOnlyThis(this.id)">Select All
				</label>
			<?php } ?>
			<?php if(isset($_SESSION['this_page'])) { ?>
				<label class="checkbox-inline">
					<input type="checkbox" id="this_page" name="this_page" checked onclick="selectOnlyThis(this.id)">Select This Page
				</label>
			<?php } else { ?>
				<label class="checkbox-inline">
					<input type="checkbox" id="this_page" name="this_page" onclick="selectOnlyThis(this.id)">Select This Page
				</label>
			<?php } ?>
		</div>
	</div>
</div>

<!--Datagrid -->
<div class="container">
	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
					  <tr>
						<th>Receipt No.</th>
						<th>Receipt Type</th>
						<th>Receipt Name</th>
						<th>Payment Mode</th>
						<th>Amount</th>
						<th>Postage</th>
						<th>Grand Total</th>
						<th>Payment Status</th>
					  </tr>
					</thead>
					<tbody>
						<?php $selectedId = ""; 
							foreach($receipt_report as $result) { ?>
							<tr class="row1">
								<td><?php echo $result->RECEIPT_NO; ?></td>
								<td><?php echo $result->RECEIPT_CATEGORY_TYPE; ?></td>
								<td><?php echo $result->RECEIPT_NAME; ?></td>
								<?php if($result->RECEIPT_PAYMENT_METHOD == "Cheque") { ?>
									<td><a class="log mymodelcancel" style="color:#800000;" onclick="show_cheque('1','<?php echo $result->CHEQUE_NO ; ?>','<?php echo $result->CHEQUE_DATE; ?>','<?php echo $result->BANK_NAME; ?>','<?php echo $result->BRANCH_NAME; ?>','<?php echo $result->TRANSACTION_ID; ?>')"><?php echo $result->RECEIPT_PAYMENT_METHOD; ?></a></td> 
								<?php } else if($result->RECEIPT_PAYMENT_METHOD == "Credit / Debit Card") { ?>
									<td><a class="log mymodelcancel" style="color:#800000;" onclick="show_cheque('2','<?php echo $result->CHEQUE_NO ; ?>','<?php echo $result->CHEQUE_DATE; ?>','<?php echo $result->BANK_NAME; ?>','<?php echo $result->BRANCH_NAME; ?>','<?php echo $result->TRANSACTION_ID; ?>')"><?php echo $result->RECEIPT_PAYMENT_METHOD; ?></a></td> 
								<?php } else { ?>
									<td><?php echo $result->RECEIPT_PAYMENT_METHOD; ?></td>
								<?php } ?>
								<td><?php echo $result->RECEIPT_PRICE; ?></td>
								<td><?php echo $result->POSTAGE_PRICE; ?></td>
								<td><?php echo ($result->RECEIPT_PRICE) + ($result->POSTAGE_PRICE); ?></td>
								<td><?php echo $result->PAYMENT_STATUS; ?></td>
							</tr>
						<?php } ?>
						<!--HIDDEN FIELD USED FOR PASS ID'S-->
						<input type="hidden" name="selectedId" id="selectedId" value="<?php echo $selectedId; ?>"/>
					</tbody>
				</table>
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
	//GET UNSELECT ALL USERS
	function GetUnselect(receiptId) {
		var str = $('#selectedId').val();
		var res = str.split(",");
		var selId = "";
		var checkInput = document.getElementsByClassName("sel");
		if($('#' + receiptId).prop('checked') == true) {
			for(var i = 0; i < checkInput.length; i++) {
				if(checkInput[i].checked == true) {
					selId += checkInput[i].id + ",";
				}
			}
			document.getElementById('selectedId').value = selId;
		} else {
			for(var i = 0; i < checkInput.length; i++) {
				if(checkInput[i].checked == true) {
					selId += checkInput[i].id + ",";
				}
			}
			document.getElementById('selectedId').value = selId;
		}
		
		document.getElementById('selectApprove').value = $('#selectedId').val();
		document.getElementById('paymentApprove').value = $('#modeOfPayment').val();
		if($('#all_users').prop('checked') == true) {
			document.getElementById("checkVal").value = "";
			document.getElementById("pageVal").value = "";
			document.getElementById("all_users").checked = false;
			url = "<?php echo site_url(); ?>EOD/get_unset_session";
			$.post(url,{'select':'this_page'});
		} else if($('#all_users').prop('checked') == false && $('#this_page').prop('checked') == false && document.getElementById("pageVal").value == ""){
			let count = 0;
			var inputs = document.getElementsByClassName("sel");
			for (var i = 0; i < inputs.length; i++) { 
				if(inputs[i].checked == true) {
				   ++count;
				}
			}
			if(count == inputs.length) {
				document.getElementById("checkVal").value = "all_users";
				document.getElementById("all_users").checked = true;
				url = "<?php echo site_url(); ?>EOD/get_set_session";
				$.post(url,{'select':'all_users'});
			}
		} else if($('#this_page').prop('checked') == true) {
			document.getElementById("this_page").checked = false;
			document.getElementById("pageVal").value = "this_page";
		}
	}

	//GET REFESH
	function GetRefresh(urlFirst) {
		url = "<?php echo site_url(); ?>EOD/get_unset_session";
		$.post(url,{'select':'all_users'}, function(e) {
			location.href = urlFirst;
		});
	}

	function approveSubmit(date,username,uid) {
		$('#dateChk').val(date);
		$('#userNameChk').val(username);
		$('#userIdChk').val(uid);
		url = "<?php echo site_url(); ?>EOD/approve_Submit";
		$("#approveId").attr("action",url)
		$("#approveId").submit();
	}

	//DATEFIELD AND FILTER CHANGE
	function GetDataOnFilter(payMode,url,date,username,uid) {
		$('#date').val(date);
		$('#userName').val(username);
		$('#userId').val(uid);
		document.getElementById('paymentMethod').value = payMode;
		$("#userFilters").attr("action",url)
		$("#userFilters").submit();
	}

	//CONDITION FOR CHECKING ONLY ONE CHECK BOX
	function selectOnlyThis(id) {
		document.getElementById('selectApprove').value = $('#selectedId').val();
		document.getElementById('paymentApprove').value = $('#modeOfPayment').val();
		var inputs = document.getElementsByClassName("sel");
		for (var i = 0; i < inputs.length; i++) { 
			inputs[i].checked = false;
		}
		
		let count = 0;
		for (var i = 0; i < inputs.length; i++) { 
            if (inputs[i].type == "checkbox") {
				for (var i = 0; i < inputs.length; i++) { 
				   if(inputs[i].checked == true) {
					   ++count;
				   }
				}
			}
		}
		
		if(count == inputs.length && $('#'+id).prop('checked') == false) {
			for (var i = 0; i < inputs.length; i++) { 
               inputs[i].checked = false;
			}
		} else if(count == 0 && $('#'+id).prop('checked') == true) {
			for (var i = 0; i < inputs.length; i++) { 
               inputs[i].checked = true;
			}
		} else if(count == inputs.length && $('#'+id).prop('checked') == true) {
			for (var i = 0; i < inputs.length; i++) { 
               inputs[i].checked = true;
			}
		}

		if(id == "all_users") {
			document.getElementById("this_page").checked = false;
			if($('#'+id).prop("checked") == true) {
				document.getElementById("checkVal").value = "all_users";
				url = "<?php echo site_url(); ?>EOD/get_set_session";
				$.post(url,{'select':'all_users'});
			} else {
				document.getElementById("checkVal").value = "";
				url = "<?php echo site_url(); ?>EOD/get_unset_session";
				$.post(url,{'select':'this_page'});
			}
		} else if(id == "this_page") {
			if($('#'+id).prop("checked") == true) {
				document.getElementById("checkVal").value = "this_page";
			} else {
				document.getElementById("checkVal").value = "";
			}
			document.getElementById("all_users").checked = false;
			url = "<?php echo site_url(); ?>EOD/get_unset_session";
			$.post(url,{'select':'this_page'});
		}
	}

	//MODEL FOR CHEQUE AND CREDIT CARD
	function show_cheque(id,cheqNo,cheqDate,Bank,Branch,transactionId){
        var c_url ="<?php echo site_url(); ?>EOD/View";
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
	});
</script>
