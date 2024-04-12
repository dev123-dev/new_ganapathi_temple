<?php error_reporting(0);
	//$this->output->enable_profiler(true);
?>
<style>
	.btn {
		    width: 72px !important;
	}
</style>
<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<!--Heading And Refresh Button-->
	<div class="row form-group">
		<div class="col-lg-2 col-md-10 col-sm-10 col-xs-8">
			<span class="eventsFont2">E.O.D. Report </span>
		</div>
		<div class="col-lg-8 col-md-10 col-sm-10 col-xs-8">
			<form action="<?=site_url();?>EOD/eod_admin" id="dateChange" enctype="multipart/form-data" method="post" accept-charset="utf-8">
				<div class="col-lg-4 col-md-3 col-sm-4 col-xs-6">
					<div class="input-group input-group-sm">
						<input autocomplete="" id="todayDate" name="todayDate" type="text" value="<?=@$dateFeild;?>" class="form-control todayDate2"  onchange="this.form.submit()" placeholder="dd-mm-yyyy" readonly = "readonly" />
						<div class="input-group-btn">
						  <button class="btn btn-default todayDate" type="button">
							<i class="glyphicon glyphicon-calendar"></i>
						  </button>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
			<a style="width:24px; height:24px" class="pull-right img-responsive" href="<?=site_url()?>EOD/eod_admin" title="Refresh"><img title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
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
						<th>Date</th>
						<th>Cash</th>
						<th>Cheque</th>
						<th>Direct Credit</th>
						<th>Credit / Debit Card</th>
						<th>Total Amount</th>
						<th>Verified Date & Time</th>
						<th>Verified By</th>
						<th>Operations</th>
					  </tr>
					</thead>
					<tbody>
						<?php foreach($eod_receipt_report as $result) { ?>
							<tr class="row1">
								<td><?php echo $result->RECEIPT_DATE; ?></td>
								<td><?php echo $result->Cash; ?></td>
								<td><?php echo $result->Cheque; ?></td>
								<td><?php echo $result->DirectCredit; ?></td>
								<td><?php echo $result->CreditDebitCard; ?></td>
								<td><?php echo $result->TotalAmount; ?></td>
								<td><?php if($result->EOD_CONFIRMED_DATE_TIME) echo $result->EOD_CONFIRMED_DATE_TIME; else echo "<center>-</center>"; ?></td>
								<td><?php if($result->EOD_CONFIRMED_BY_NAME) echo $result->EOD_CONFIRMED_BY_NAME; else echo "<center>-</center>"; ?></td>
								<?php if($result->EOD_CONFIRMED_DATE) { ?> 
										<td><center><button type="button" class="btn btn-default btn-sm" onClick='eodOnDate("<?php echo $result->RECEIPT_DATE;?>", "view")'>View</Button></center></td>
								<?php } else { ?>
									<td>
										<?php if(date('d-m-Y') == $result->RECEIPT_DATE) { ?>
												<center><button type="button" class="btn btn-default btn-sm" onClick='eodOnDate("<?php echo $result->RECEIPT_DATE;?>","generate")'>Generate</button></center>		
										<?php } else { ?>
												<center><button type="button" class="btn btn-default btn-sm" onClick='eodOnDate("<?php echo $result->RECEIPT_DATE;?>","generate")'>Generate</button></center>
										<?php } ?>
									</td>	
								<?php } ?>
							</tr>
						
						<?php } ?>
					</tbody>
				</table>
				<ul class="pagination pagination-sm">
					<?=$pages; ?>
				</ul>
			</div>
		</div>
	</div>
	<!-- <form id="tempGen" method="post">
		<button type="button" class="btn btn-default" onClick='tempGenerate()'>Temp</button>
	</form> -->
</div>
<form id="eodOnDate" method="post">
	<input type="hidden" name="eodDate" id="eodDate"/>
	<input type="hidden" name="receiptType" id="receiptType"/>
</form>

<!-- Modal -->
<div class="modal previewModal fade bs-example-modal-lg" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-lg" style="width: 1450px;">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Function Confirmation</h4>
				<span style="font-size:12px;"><strong><i>Please note: Check the checkbox in 'Function Status' if the function is done, if function is not held please do provide the reason.</i></strong></span>
			</div>
			<form id="funcConfirm" enctype="multipart/form-data" method="post" accept-charset="utf-8">
				<div class="modal-body previewModalBody" style="overflow-y: auto;max-height: 60vmin;">					
				</div>
				<!--HIDDEN FIELD-->
				<input type="hidden" name="hidDate" id="hidDate"/>
				<input type="hidden" name="hidRecType" id="hidRecType"/>
				<div class="modal-footer text-left" style="text-align:left;">
					<label>Are you sure you want to save..?</label>
					<br/>
					<button style="width: 8%;" type="button" id="submit" class="btn btn-default sevaButton">Yes</button>
					<button style="width: 8%;" type="button" class="btn btn-default sevaButton" data-dismiss="modal">No</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	//SUBMIT FUNCTION OF POPUP
	$('#submit').on('click', function () {
		var count = 0;
		var inputs = document.getElementsByClassName("checkHall");
		
		for (var i = 0; i < inputs.length; i++) { 
		   if(inputs[i].checked == false) {
				var resText = (inputs[i].id).split("Hall");
				var textBoxId = "textHall" + resText[1];
				if(document.getElementById(textBoxId).value == "") {
					$('#' + textBoxId).css('border-color', "#FF0000");
					++count;
				}
		   }
		}
		
		if(count != 0) {
			alert("Information","Please fill required fields","OK");
			return false;
		}
		
		var postValue = "";
		for (var m = 0; m < inputs.length; m++) { 
			var resText = (inputs[m].id).split("Hall");
			var textBoxId = "textHall" + resText[1];
			if(inputs[m].checked == false) {
			   postValue +=  resText[1] + "$0$" + document.getElementById(textBoxId).value;
			} else if(inputs[m].checked == true) {
			   postValue +=  resText[1] + "$1$" + document.getElementById(textBoxId).value;
			}
			postValue += "#";
		}
		
		let url = "<?=site_url()?>Receipt/save_function_details"
		$.post(url, {'postVal':postValue}, function(data) {
			if(data == "success") {
				$('#eodDate').val(document.getElementById('hidDate').value);
				$('#receiptType').val(document.getElementById('hidRecType').value);
				$('#eodOnDate').attr('action',"<?=site_url()?>EOD/deityEod_onDate/");
				$('#eodOnDate').submit();
			}
		});
	});

	//ON CLICK ON TEXTBOX THIS FUNCTION CALLED
	function selectTextBox(id) {
		var myId = "textHall" + id;
		if(document.getElementById(myId).value == "") {
			$('#' + myId).css('border-color', "#FF0000");
		} else {
			$('#' + myId).css('border-color', "#000000");
		}
	}
	
	//ON CLICK ON CHECKBOX THIS FUNCTION CALLED
	function selectCheckBox(id) {
		var myId = "textHall" + id;
		if($('#checkHall'+id).prop("checked") == true) {
			document.getElementById(myId).disabled = true;
			$('#' + myId).css('border-color', "#000000");
		} else {
			document.getElementById(myId).disabled = false;
			$('#' + myId).css('border-color', "#FF0000");
		}
	}
	
	function eodOnDate(date, receiptType) {
		document.getElementById('hidDate').value = date;
		document.getElementById('hidRecType').value = receiptType;
		if(receiptType == 'generate') {
			var res = date.split("-");
			date = res[2]+"-"+res[1]+"-"+res[0];
			let url = "<?=site_url()?>Receipt/get_function_details";
			$.post(url, {'date': date}, function (data) {
				if(data != "[]") {
					var finalRes = JSON.parse(data);
					$('#hallUpdate').html("");
					$('.previewModalBody').html('<div class="table-responsive"><table class="table table-bordered"><thead><tr><th>Booking No.</th><th>Name (Phone)</th><th>Hall</th><th>Booking Date (Time)</th><th>Amount</th><th>Function Status</th></tr></thead><tbody id="hallUpdate"></tbody></table></div>');

					for (i = 0; i < finalRes.length; ++i) {
						var amount = finalRes[i]['AMOUNT'];
						var price = finalRes[i]['PRICE'];
						$('#hallUpdate').append("<tr>"); 
						$('#hallUpdate').append("<td><center>" + finalRes[i]['HB_NO'] + "</center></td>");
						if(finalRes[i]['HB_NUMBER'] != "") {
							$('#hallUpdate').append("<td>" + finalRes[i]['HB_NAME'] + " (" + finalRes[i]['HB_NUMBER'] + ")</td>");
						} else {
							$('#hallUpdate').append("<td>" + finalRes[i]['HB_NAME'] + "</td>");
						}
						$('#hallUpdate').append("<td>" + finalRes[i]['H_NAME'] + "</td>");
						$('#hallUpdate').append("<td>" + finalRes[i]['HB_BOOK_DATE'] + " (" + finalRes[i]['HB_BOOK_TIME_FROM'] + " - " + finalRes[i]['HB_BOOK_TIME_TO'] + ")</td>");
						if((amount != null) && (price != null)) {
							$('#hallUpdate').append("<td><center>" + (parseInt(amount) + parseInt(price)) + "</center></td>");
						} else if(amount != null) {
							$('#hallUpdate').append("<td><center>" + amount + "</center></td>");
						} else if(price != null) {
							$('#hallUpdate').append("<td><center>" + price + "</center></td>");
						} else {
							$('#hallUpdate').append("<td><center>0</center></td>");
						}
						$('#hallUpdate').append("<td><center><input style='width:20px;height:20px;margin:0;' type='checkbox' onclick='selectCheckBox("+ finalRes[i]['HBL_ID'] +")' class='checkHall' id=checkHall"+ finalRes[i]['HBL_ID'] +">  <textarea type='text' onkeyup='selectTextBox("+ finalRes[i]['HBL_ID'] +")' class='textHall' id='textHall"+ finalRes[i]['HBL_ID'] +"'/></center></td>");
						$('#hallUpdate').append("</tr><br/>");
					}

					$('.previewModal').modal();
				} else {
					$('#eodDate').val(document.getElementById('hidDate').value);
					$('#receiptType').val(document.getElementById('hidRecType').value);
					$('#eodOnDate').attr('action',"<?=site_url()?>EOD/deityEod_onDate/");
					$('#eodOnDate').submit();
				}
			});
		} else {
			$('#eodDate').val(date);
			$('#receiptType').val(receiptType);
			$('#eodOnDate').attr('action',"<?=site_url()?>EOD/deityEod_onDate/");
			$('#eodOnDate').submit();
		}
	}

	$( ".todayDate2" ).datepicker({ 
		dateFormat: 'dd-mm-yy',
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50"
	});
			
	$('.todayDate').on('click', function() {
		$( ".todayDate2" ).focus();
	});

	// function tempGenerate() {
	// 	$('#tempGen').attr('action',"<?=site_url()?>EOD/temporaryGenerate/");
	// 	$('#tempGen').submit();
	// }
</script>
