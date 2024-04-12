<?php 
	//$this->output->enable_profiler(TRUE);
	//print_r("<pre>");
	//print_r($_SESSION);
	//print_r("</pre>");
?>
<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<!--Heading And Refresh Button-->
	<div class="row form-group">
		<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
			<span class="eventsFont2">SLVT EVENT POSTAGE GROUP</span>
		</div>
		<div class="col-lg-1 col-md-2 col-sm-2 col-xs-2" id="AddSub"  onclick="checkForExport()"  data-hint="Label Generation">
			<img class="pull-right" style="width:24px; height:24px;margin-right: -30px;" title="labelGeneration" src="<?=site_url();?>images/labelicon.png"/>
		</div>

		<div class="col-lg-1 col-md-2 col-sm-2 col-xs-2">
			<a style="width:24px; height:24px;margin-right: 15px;" class="pull-right img-responsive" onClick="clearSessionValues()" href="<?=site_url()?>EventPostage/postage_group" title="Refresh"><img title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
		</div>
	</div>
</div>

<div class="container">
	<form id="frmPostage" method="POST">
		<div class="form-group col-lg-3 col-md-3 col-sm-4 col-xs-12" style="margin-bottom:1em;">
			<select id="slvtEventPostageGrps" name="slvtEventPostageGrps" class="form-control">
				<option value="All" <?php if($_SESSION['chosenCategory'] == 'All') echo 'selected'; else echo''; ?>>All</option>
				<option value="Seva" <?php if($_SESSION['chosenCategory'] == 'Seva') echo 'selected'; else echo ''; ?>>Seva</option>
				<option value="Donation" <?php if($_SESSION['chosenCategory'] == 'Donation') echo 'selected'; else echo ''; ?>>Donation/Kanike</option>
				<option value="Inkind" <?php if($_SESSION['chosenCategory'] == 'Inkind') echo 'selected'; else echo ''; ?>>Inkind</option>
			</select>
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
						</tr>
					</thead>
					<tbody>
						<!-- <?php foreach($allCollection as $result) { ?>
							<tr class="row1">
								<td><?php echo $result->ET_RECEIPT_NO; ?></td>
								<td><?php echo $result->ET_RECEIPT_DATE; ?></td>
								<td><?php echo $result->ET_RECEIPT_NAME; ?></td>
								<td><?php echo $result->ET_RECEIPT_PHONE; ?></td>
								<td><?php echo $result->ET_RECEIPT_ADDRESS; ?></td>
								<td><?php echo $result->ET_RECEIPT_PAYMENT_METHOD; ?></td>
							</tr>
						<?php } ?> -->
					</tbody>
				</table>
			</div>
			<div class="row">
				<ul class="pagination pagination-sm" style="margin-left:15px;margin-top: -1em;">
					<?=$pages; ?>
				</ul>
				<?php if($total_rows != 0) { ?>
					<label  class="pull-right" style="font-size:18px;margin-right:15px;margin-top: -1em;"><?php echo $_SESSION['chosenCategory'] ?> Addresses: <strong><?php echo $total_rows ?></strong></label>
				<?php } else { ?>
					<label> </label>
				<?php } ?>
			</div>
		</div>
	</form>
</div>
<script>
	function checkForExport() {
		var php_var = "<?php echo $total_rows; ?>";								
		if(php_var == '0') {
			alert('There are no Records to export.');
		} else {						
			url = "<?php echo site_url(); ?>EventPostage/unset_session_postage";
			$.post(url,{'SelectedReceiptID':JSON.parse(sessionStorage.getItem("SelectedReceiptID"))}, function(e) {					
				window.open('<?php echo site_url(); ?>GenerationSLVTEventPostageFPDF','_blank'); 
			});		
		}
	}

	//ON CHANGE OF SELECTION
	$('#slvtEventPostageGrps').on('change', function () {
		url = "<?php echo site_url(); ?>EventPostage/slvt_postage_data";
		$('#frmPostage').attr('action', url).submit();
		clearSessionValues();
	});

	var arrSelectedReceiptID = [];
	var arrLocalItems = []; 
	var arrItems = []; 
	var arrTotalItemsFromDB = [];
	var totItemsFromDB = 0; 
	
	$(document).ready(function() {
		let arrTotDBItems = <?php echo $fullCollection; ?>;
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
	   	arrItems = <?php echo $allCollection; ?>;
	    for(var i = 0; i < arrItems.length; i++) {
	    	if(sessionStorage.getItem("SelectAll") !== null && sessionStorage.getItem("SelectAll") == "true") {
    			$("#all_users").prop('checked', true);
    			$('#tblPostageGrp').append('<tr class="row1"><td><center><input id="checkerId_'+i+'" type="checkbox" onchange="GetOnSelection('+arrItems[i]["ET_RECEIPT_ID"]+',this.checked)" checked /></center></td><td class="recId" id="recid_'+i+'" style="display:none;">'+arrItems[i]["ET_RECEIPT_ID"]+'</td><td>'+arrItems[i]["ET_RECEIPT_NO"]+'</td><td>'+arrItems[i]["ET_RECEIPT_DATE"]+'</td><td>'+arrItems[i]["ET_RECEIPT_NAME"]+'</td><td>'+arrItems[i]["ET_RECEIPT_PHONE"]+'</td><td>'+arrItems[i]["ET_RECEIPT_ADDRESS"]+'</td><td>'+arrItems[i]["ET_RECEIPT_PAYMENT_METHOD"]+'</td></tr>');
    		} else {
	    		if(sessionStorage.getItem("SelectedReceiptID") !== null && sessionStorage.getItem("SelectedReceiptID") != "") {
	    			if(arrSelectedReceiptID.indexOf(parseInt(arrItems[i]["ET_RECEIPT_ID"])) > -1) {
	    				arrLocalItems.push(parseInt(arrItems[i]["ET_RECEIPT_ID"]));
	    				$('#tblPostageGrp').append('<tr class="row1"><td><center><input id="checkerId_'+i+'" type="checkbox" onchange="GetOnSelection('+arrItems[i]["ET_RECEIPT_ID"]+',this.checked)" checked /></center></td><td class="recId" id="recid_'+i+'" style="display:none;">'+arrItems[i]["ET_RECEIPT_ID"]+'</td><td>'+arrItems[i]["ET_RECEIPT_NO"]+'</td><td>'+arrItems[i]["ET_RECEIPT_DATE"]+'</td><td>'+arrItems[i]["ET_RECEIPT_NAME"]+'</td><td>'+arrItems[i]["ET_RECEIPT_PHONE"]+'</td><td>'+arrItems[i]["ET_RECEIPT_ADDRESS"]+'</td><td>'+arrItems[i]["ET_RECEIPT_PAYMENT_METHOD"]+'</td></tr>');
	    			} else {
	    				$('#tblPostageGrp').append('<tr class="row1"><td><center><input id="checkerId_'+i+'" type="checkbox" onchange="GetOnSelection('+arrItems[i]["ET_ET_RECEIPT_ID"]+',this.checked)" /></center></td><td class="recId" id="recid_'+i+'" style="display:none;">'+arrItems[i]["ET_ET_RECEIPT_ID"]+'</td><td>'+arrItems[i]["ET_RECEIPT_NO"]+'</td><td>'+arrItems[i]["ET_RECEIPT_DATE"]+'</td><td>'+arrItems[i]["ET_RECEIPT_NAME"]+'</td><td>'+arrItems[i]["ET_RECEIPT_PHONE"]+'</td><td>'+arrItems[i]["ET_RECEIPT_ADDRESS"]+'</td><td>'+arrItems[i]["ET_RECEIPT_PAYMENT_METHOD"]+'</td></tr>');
	    			}
	    		} else {
	    			$('#tblPostageGrp').append('<tr class="row1"><td><center><input id="checkerId_'+i+'" type="checkbox" onchange="GetOnSelection('+arrItems[i]["ET_RECEIPT_ID"]+',this.checked)" /></center></td><td class="recId" id="recid_'+i+'" style="display:none;">'+arrItems[i]["ET_RECEIPT_ID"]+'</td><td>'+arrItems[i]["ET_RECEIPT_NO"]+'</td><td>'+arrItems[i]["ET_RECEIPT_DATE"]+'</td><td>'+arrItems[i]["ET_RECEIPT_NAME"]+'</td><td>'+arrItems[i]["ET_RECEIPT_PHONE"]+'</td><td>'+arrItems[i]["ET_RECEIPT_ADDRESS"]+'</td><td>'+arrItems[i]["ET_RECEIPT_PAYMENT_METHOD"]+'</td></tr>');
	    		}
		    }
		}
	});	

	function GetOnSelection (receiptId,checker) {
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
		
</script>