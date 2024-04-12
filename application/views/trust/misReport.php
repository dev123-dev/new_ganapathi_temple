<style>
	.city {display:none;}
</style>
<?php 
	// $this->output->enable_profiler(TRUE);
	//for donation amount
	$totalDonation = 0;
	foreach($donation_details as $amt) {
		$totalDonation += $amt['TET_RECEIPT_PRICE'];
		$totalDonation += $amt['POSTAGE_PRICE'];
	}
	$_SESSION['donation'] = $totalDonation;


	//for donation cancelled amount
	$totalcancelledDonation = 0;
	foreach($cancelled_donation_details as $amt) {
		$totalcancelledDonation += $amt['TET_RECEIPT_PRICE'];
		$totalcancelledDonation += $amt['POSTAGE_PRICE'];
	}
	$_SESSION['canceled_donation'] = $totalcancelledDonation;                              //?

	//for donation amount
	$totalHundi = 0;
	foreach($hundi as $amt) {
		$totalHundi += $amt['TET_RECEIPT_PRICE'];
	}
	$_SESSION['hundi'] = $totalHundi;
	
	//for cencelled hundi amount
	$cancelledTotalHundi = 0;
	foreach($hundicancelled as $amt) {
		$cancelledTotalHundi += $amt['TET_RECEIPT_PRICE'];
	}
	$_SESSION['cancelledTotalHundi'] = $cancelledTotalHundi;
?>
	
<div id="print" style="display:none;">
	<?php if(!empty($seva)) { ?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
				  <tr>
					<th style="width:30%">Seva Name</th>
					<th style="width:10%">Sevas Booked</th>
					<th style="width:15%">Amount</th>
					<th style="width:15%">Postage</th>
				  </tr>
				</thead>
				<tbody>
				   <?php foreach($seva as $result) {
						echo "<tr>";
						echo "<td>".$result['TET_SO_SEVA_NAME']."</td>";
						echo "<td>".$result['SUM(TET_SO_QUANTITY)']."</td>";
						echo "<td>".$result['SUM(TET_SO_QUANTITY*TET_SO_PRICE)']."</td>";
						echo "<td>".$result['POSTAGE_PRICE']."</td>";
						echo "</tr>";
					} ?>
				</tbody>
			</table>
		</div><br/>
	<?php } ?>
	<div class="table-responsive">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th style="width:30%">Receipt Name</th>
					<th style="width:10%">Total</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						Donation/Kanike
					</td>
					<td>
						<?=$totalDonation;?>
					</td>
				</tr>	
				<tr>
					<td>
						Hundi
					</td>
					<td>
						<?=$totalHundi;?>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<br/>
	<?php if(!empty($inkind)) { ?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th style="width:30%">Item Name</th>
						<th style="width:10%">Quantity</th>
					</tr>
				</thead>
				<tbody>
				   <?php foreach($inkind as $result) {
						echo "<tr>";
						echo "<td>".$result['IK_ITEM_NAME']."</td>";
						echo "<td>".$result['amount']." ".$result['IK_ITEM_UNIT']."</td>";
						echo "</tr>";
					} ?>
				</tbody>
			</table>
		</div><br/>
	<?php } ?>
</div> <!-- for printing -->
	
<!-- START Content -->	
<!-- START Row -->
<div style="clear:both;" class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<div class="row form-group">							
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
			<span class="eventsFont2">Current MIS Event Report: <span class="samFont"><?php echo $event['TET_NAME']; ?></span></span>
			<a class="pull-right" style="margin-left:5px;" href="<?=site_url()?>TrustReport/misReport" title="Refresh"><img style="width:24px; height:24px;" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
		</div>
	</div>					
	<div class="row form-group">
		<form action="<?=site_url();?>TrustReport/misReport" id="dateChange" enctype="multipart/form-data" method="post" accept-charset="utf-8" onsubmit="return field_validation();">
			<input type="hidden" name="date" value="<?=@$date; ?>" id="date" value="">
			<input type="hidden" name="load" id="load" value="">
			<input type="hidden" name="allDates" id="allDates" value="<?=@$allDates; ?>">
			<input type="hidden" name="radioOpt" id="radioOpt" value="<?=$radioOpt; ?>">
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
						<input style="border-radius:2px;" id="todayDate" name="todayDate" type="text" value="<?=@$date; ?>" class="form-control todayDate"  onchange="GetDataOnDate(this.value,'<?php echo site_url()?>TrustReport/misReport')" placeholder="dd-mm-yyyy" readonly="readonly"/>
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
							<input name="fromDate" onchange="GetDataOnDate(this.value,'<?php echo site_url()?>TrustReport/misReport')" id="fromDate" type="text" class="form-control fromDate2" value="<?=@$fromDate; ?>" placeholder="From: dd-mm-yyyy" readonly="readonly"/>
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
							<input name="toDate" onchange="GetDataOnDate(this.value,'<?php echo site_url()?>TrustReport/misReport')" id="toDate" type="text" value="<?=@$toDate; ?>" class="form-control toDate2" placeholder="To: dd-mm-yyyy" readonly="readonly"/>
							<div class="input-group-btn">
								<button class="btn btn-default toDate" type="button">
									<i class="glyphicon glyphicon-calendar"></i>
								</button>
							</div>
						</div>
					</div>
				</div>				
			</div>
			
			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-4 text-right pull-right">
				<a onclick="GetSendField()" style="cursor:pointer;"><img style="width:24px; height:24px" title="Download Excel Report" src="<?=site_url();?>images/excel_icon.svg"/></a>&nbsp;&nbsp;
				<a onclick="generatePDF()"><img style="width:24px; height:24px;" title="Download PDF Report" src="<?=site_url();?>images/pdf_icon.svg"/></a>&nbsp;&nbsp;
				<a onClick="printPage();"><img style="width:24px; height:24px;" title="Print Report" src="<?=site_url();?>images/print_icon.svg"/></a>				
			</div>
		</form>
	</div>
	
	<div style="clear:both;" class="w3-row"> 
		<?php  
			$i = 1;$j = 10;
			foreach($eventReceiptCategory as $result) { ?>
				<a href="#" onclick="openCity(event, '<?=$i++;?>');">
					<div id="<?=$j--;?>" class="w3-third tablink w3-bottombar w3-hover-light-grey w3-padding"><?=$result['TET_RECEIPT_CATEGORY_TYPE'];?></div>
				</a>
		<?php } ?>
	</div>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div id="1" class="w3-container city">
			<br/><br/>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Seva Name</th>
							<th>Sevas Qty</th>
							<th>Amount</th>
							<th>Postage</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($seva as $result) {
							echo "<tr>";
							echo "<td>".$result['TET_SO_SEVA_NAME']."</td>";
							echo "<td>".$result['SUM(TET_SO_QUANTITY)']."</td>";
							echo "<td>".$result['SUM(TET_SO_QUANTITY*TET_SO_PRICE)']."</td>";
							echo "<td>".$result['POSTAGE_PRICE']."</td>";
							echo "<td>".($result['SUM(TET_SO_QUANTITY*TET_SO_PRICE)'] + $result['POSTAGE_PRICE'])."</td>";
							echo "</tr>";
						} ?>
					</tbody>
				</table>
			</div>

			<br/><br/>
			<h3>Cancelled</h3>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Seva Name</th>
							<th>Sevas Qty</th>
							<th>Amount</th>
							<th>Postage</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($cancelledSeva as $result) {
							echo "<tr>";
							echo "<td>".$result['TET_SO_SEVA_NAME']."</td>";
							echo "<td>".$result['SUM(TET_SO_QUANTITY)']."</td>";
							echo "<td>".$result['SUM(TET_SO_QUANTITY*TET_SO_PRICE)']."</td>";
							echo "<td>".$result['POSTAGE_PRICE']."</td>";
							echo "<td>".($result['SUM(TET_SO_QUANTITY*TET_SO_PRICE)'] + $result['POSTAGE_PRICE'])."</td>";
							echo "</tr>";
						} ?>
					</tbody>
				</table>
			</div>	
		</div>
						
		<div id="2" class="w3-container city">
			<br/><br/>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Receipt No</th>
							<th>Name</th>
							<th>Address</th>
							<th>Phone</th>
							<th>Amount</th>
							<th>Postage</th>
							<th>Payment Notes</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($donation_details as $result) {
							echo "<tr>";
							echo "<td>".$result['TET_RECEIPT_NO']."</td>";
							echo "<td>".$result['TET_RECEIPT_NAME']."</td>";
							echo "<td>".$result['TET_RECEIPT_ADDRESS']."</td>";
							echo "<td>".$result['TET_RECEIPT_PHONE']."</td>";
							echo "<td>".$result['TET_RECEIPT_PRICE']."</td>";
							echo "<td>".$result['POSTAGE_PRICE']."</td>";
							echo "<td>".$result['TET_RECEIPT_PAYMENT_METHOD_NOTES']."</td>";
							echo "</tr>";
						} ?>
					</tbody>
				</table>
			</div>
			<h3>Total Amount: <?=$totalDonation;?></h3>


			<br/><br/>
			<h3>Cancelled</h3>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Receipt Number</th>
							<th>Name</th>
							<th>Amount</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($cancelled_donation_details as $result) {
							echo "<tr>";
							echo "<td>".$result['TET_RECEIPT_NO']."</td>";
							echo "<td>".$result['TET_RECEIPT_NAME']."</td>";
							echo "<td>".$result['TET_RECEIPT_PRICE']."</td>";
							echo "</tr>";
						} ?>
					</tbody>
				</table>
			</div>
			<h3>Total Cancelled Amount: <?=$totalcancelledDonation;?></h3>
		</div>
			



		<div id="3" class="w3-container city">
			<br/><br/>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Receipt No</th>
							<th>Deity Name</th>
							<th>Amount</th>
							<th>Payment Notes</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($hundi as $result) {
							echo "<tr>";
							echo "<td>".$result['TET_RECEIPT_NO']."</td>";
							echo "<td>".$result['RECEIPT_TET_NAME']."</td>";
							echo "<td>".$result['TET_RECEIPT_PRICE']."</td>";
							echo "<td>".$result['TET_RECEIPT_PAYMENT_METHOD_NOTES']."</td>";
							echo "</tr>";
						} ?>
					</tbody>
				</table>
			</div>
			<br/>
			<h3>Total Amount: <?=$totalHundi;?></h3>
			<br/><br/>
			<h3>Cancelled</h3>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Receipt No</th>
							<th>Deity Name</th>
							<th>Amount</th>
							<th>Payment Notes</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($hundicancelled as $result) {
							echo "<tr>";
							echo "<td>".$result['TET_RECEIPT_NO']."</td>";
							echo "<td>".$result['RECEIPT_TET_NAME']."</td>";
							echo "<td>".$result['TET_RECEIPT_PRICE']."</td>";
							echo "<td>".$result['TET_RECEIPT_PAYMENT_METHOD_NOTES']."</td>";
							echo "</tr>";
						} ?>
					</tbody>
				</table>
			</div>
			<br/>
			<h3>Total Amount: <?=$cancelledTotalHundi;?></h3>


		</div>
			
		<div id="4" class="w3-container city">
			<br/><br/>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<!-- // Suraksha Code -->
							<th>Receipt No</th>
							<th>Name</th>
							<th>Item Name</th>
							<th>Quantity</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($inkind as $result) {
							echo "<tr>";
							// Suraksha Code
							echo "<td>".$result['TET_RECEIPT_NO']."</td>";
							echo "<td>".$result['TET_RECEIPT_NAME']."</td>";
							echo "<td>".$result['IK_ITEM_NAME']."</td>";
							echo "<td>".$result['amount']." ".$result['IK_ITEM_UNIT']."</td>";
							echo "</tr>";
						} ?>
					</tbody>
				</table>
			</div>			
		</div>
	</div>		
</div>
<form method="post" id="report">
	<input type="hidden" id="outputType" name="outputType" />
	<input type="hidden" name="dateHidden" value="<?=@$date; ?>" id="dateHidden">
	<input type="hidden" name="fromDateHidden" id="fromDateHidden" value="<?=@$fromDate; ?>">
	<input type="hidden" name="toDateHidden" id="toDateHidden" value="<?=@$toDate; ?>">
	<input type="hidden" name="radioOptHidden" id="radioOptHidden" value="<?=$radioOpt; ?>">
</form>
<script>
	//For Displaying First Time Selected
	document.getElementById('1').style.display = "block";
	$("#10").addClass("w3-border-red");
		
	var currentTime = new Date()
	var maxDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month

	$( ".todayDate" ).datepicker({
		//maxDate: maxDate,
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50",
		dateFormat: 'dd-mm-yy',
	});
	
	$(".fromDate2").datepicker({
		//maxDate: maxDate,
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50",
		dateFormat: 'dd-mm-yy'
	});
	
	$(".toDate2").datepicker({
		//maxDate: maxDate,
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50",
		dateFormat: 'dd-mm-yy'
	});
	
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
	
	//GET SEND POST FIELDS
	function GetSendField() {
		var start = $("#fromDate");
		var end = $("#toDate"); 
		var todayDate = $("#todayDate"); 
		var count = 0;
		
		if(document.getElementById("EveryRadio").checked) {
			if(!start.val()) {
				start.css('border-color','red');
				++count;
			} else 
				start.css('border-color','#ccc');
				
			if(!end.val()) {
				end.css('border-color','red');
				++count;
			} else 
				end.css('border-color','#ccc');
		} else {
			if(!todayDate.val()) {
				todayDate.css('border-color','red');
				++count;
			} else 
				todayDate.css('border-color','#ccc');
		}
		
		if(count != 0) {
			alert("Information","Please select required field");
			return;
		}
		
		url = "<?php echo site_url(); ?>TrustReport/event_mis_report_excel";
		$("#dateChange").attr("action",url)
		$("#dateChange").submit();
	}
	
	function generatePDF() {
		var start = $("#fromDate");
		var end = $("#toDate"); 
		var todayDate = $("#todayDate"); 
		var count = 0;
		
		if(document.getElementById("EveryRadio").checked) {
			if(!start.val()) {
				start.css('border-color','red');
				++count;
			} else 
				start.css('border-color','#ccc');
				
			if(!end.val()) {
				end.css('border-color','red');
				++count;
			} else 
				end.css('border-color','#ccc');
		} else {
			if(!todayDate.val()) {
				todayDate.css('border-color','red');
				++count;
			} else 
				todayDate.css('border-color','#ccc');
		}
		
		if(count != 0) {
			alert("Information","Please select required field");
			return;
		}
		
		let url = "<?php echo site_url(); ?>generatePDF/create_trustEventMisReceiptSessionPrint";
		$.post(url,{'radioOptHidden':$('#radioOptHidden').val(),'dateHidden':$('#dateHidden').val(),'toDateHidden':$('#toDateHidden').val(),'fromDateHidden':$('#fromDateHidden').val()}, function(data) {
			if(data == 1) {
				url = "<?php echo site_url(); ?>generatePDF/create_trustEventMisReceipt";
				$("#report").attr("action",url);
				$('#outputType').val("pdf");
				$("#report").submit();	
			}
		});	
	}
	
	function printPage() {
		var start = $("#fromDate");
		var end = $("#toDate"); 
		var todayDate = $("#todayDate"); 
		var count = 0;
		
		if(document.getElementById("EveryRadio").checked) {
			if(!start.val()) {
				start.css('border-color','red');
				++count;
			} else 
				start.css('border-color','#ccc');
				
			if(!end.val()) {
				end.css('border-color','red');
				++count;
			} else 
				end.css('border-color','#ccc');
		} else {
			if(!todayDate.val()) {
				todayDate.css('border-color','red');
				++count;
			} else 
				todayDate.css('border-color','#ccc');
		}
		
		if(count != 0) {
			alert("Information","Please select required field");
			return;
		}
		
		let url = "<?php echo site_url(); ?>generatePDF/create_trustEventMisReceiptSessionPrint";
		$.post(url,{'radioOptHidden':$('#radioOptHidden').val(),'dateHidden':$('#dateHidden').val(),'toDateHidden':$('#toDateHidden').val(),'fromDateHidden':$('#fromDateHidden').val()}, function(data) {
			if(data == 1) {
				let url2 = "<?php echo site_url(); ?>generatePDF/create_trustEventMisReceipt";
				var win = window.open(
					url2,
					'_blank');
				setTimeout(function(){ win.print();}, 1000); //setTimeout(function(){ win.close();}, 5000);		
			}
		});				
	}
			
	function field_validation() {
		var count = 0;
		var radio = $('#radioOpt').val();
		if(radio == "date"){
			if(!$('#todayDate').val()) {
				$('#todayDate').css('border', "1px solid #FF0000"); 
				++count
			} else {
				$('#todayDate').css('border', "1px solid #000000"); 
			}
		} else {
			if(!$('#fromDate').val()) {
				$('#fromDate').css('border', "1px solid #FF0000"); 
				++count
			} else {
				$('#fromDate').css('border', "1px solid #000000"); 
			}
		}
		
		if(count != 0) {
			alert("Information","Please fill required fields","OK");
			return false;
		}
	}
	 
	function GetDataOnDate(receiptDate,url) {
		between = [];
		document.getElementById('date').value = receiptDate;
		document.getElementById('load').value = "DateChange";
		document.getElementById('toDateHidden').value = $('#toDate').val();
		document.getElementById('dateHidden').value =  receiptDate;
		document.getElementById('fromDateHidden').value = $('#fromDate').val();
		var sDate1 = "";
		
		var start = $("#fromDate").datepicker("getDate");
		end = $("#toDate").datepicker("getDate");
		var todayDate = $('#todayDate').val();
		
		//console.log(start)
		currentDate = new Date(start),
		between = [];
		while (currentDate <= end) { 
			//console.log(currentDate);
			between.push(("0" + currentDate.getDate()).slice(-2) + "-" + ("0" + (currentDate.getMonth() + 1)).slice(-2) + "-" + currentDate.getFullYear());	
			
			currentDate.setDate(currentDate.getDate() + 1);
		}
			
		if(between.length == 0)
			between.push(("0" + currentDate.getDate()).slice(-2) + "-" + ("0" + (currentDate.getMonth() + 1)).slice(-2) + "-" + currentDate.getFullYear());
		
		newDate = between.join("|")
		//console.log(newDate)
		document.getElementById('allDates').value = newDate;
		$("#dateChange").attr("action",url)
		if(document.getElementById("EveryRadio").checked) {
			if(start && end) {
				$("#dateChange").submit();
			}
		} else {
			if(todayDate)
				$("#dateChange").submit();
		}
	}

	function openCity(evt, cityName) {
		var i, x, tablinks;
		x = document.getElementsByClassName("city");
		for (i = 0; i < x.length; i++) {
			x[i].style.display = "none";
		}
		tablinks = document.getElementsByClassName("tablink");
		for (i = 0; i < x.length; i++) {
			tablinks[i].className = tablinks[i].className.replace(" w3-border-red", "");
		}
		document.getElementById(cityName).style.display = "block";
		evt.currentTarget.firstElementChild.className += " w3-border-red";
	}
</script> 