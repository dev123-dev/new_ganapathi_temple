
	<!--for printing --><div id="printScreen" style="display:none">
		<page>
			<form>
				<center><span class="eventsFont2 samFont1"><?=$eventCounter[0]["RECEIPT_TET_NAME"]; ?></span></center><br/><br/>
				<span class="eventsFont2">Receipt Date: <?=$eventCounter[0]["TET_RECEIPT_DATE"];?></span>
				<span style="float:right" class="eventsFont2">Receipt Number: <?=$eventCounter[0]['TET_RECEIPT_NO'] ?></span><br/><br/>
				<span style="font-size:18px;"><strong>Name: </strong><?=$eventCounter[0]['TET_RECEIPT_NAME'] ?></span>
				<?php if($eventCounter[0]['TET_RECEIPT_RASHI'] != "") { ?>
					<span style="clear:both;float:right;font-size:18px;"><strong>Rashi: </strong><?=$eventCounter[0]['TET_RECEIPT_RASHI'] ?></span><br/>
				<?php } ?>
				<?php if($eventCounter[0]['TET_RECEIPT_PHONE'] != "") { ?>
					<span style="font-size:18px;"><strong>Number: </strong><?=$eventCounter[0]['TET_RECEIPT_PHONE'] ?></span>
				<?php } ?>
				<?php if($eventCounter[0]['TET_RECEIPT_NAKSHATRA'] != "") { ?>
					<span style="float: right;font-size:18px;"><strong>Nakshatra: </strong><?=$eventCounter[0]['TET_RECEIPT_NAKSHATRA'] ?></span>
				<?php } ?>
				<br/>
				<br/><br/>
				<table id="eventSeva" class="table table-bordered">
					<thead>
					  <tr>
						<th>Sl. No.</th>
						<th>Seva Name</th>
						<th>Qty</th>
						<th>Seva Date</th>
						<th>Seva Amount</th>
						<th>Total Seva Amount</th>
					  </tr>
					</thead>
					<tbody id="eventUpdate">
					<?php 
					$i = 1;
					
					$subTotal = 0;
					foreach($eventCounter as $result) {

						$qty = @$result["TET_SO_QUANTITY"];
						if($qty == "") {
							$qty = 1;
						}
						
						$total = ($result["TET_SO_PRICE"] * $qty);
						$subTotal += $total;
						
						echo "<tr><td>".$i++."</td>";
						echo "<td>". $result["TET_SO_SEVA_NAME"]."</td>";
						echo "<td>". $qty."</td>";
						echo "<td>". $result["TET_SO_DATE"]."</td>";
						echo "<td>". $result["TET_SO_PRICE"]."</td>";
						echo "<td>". $total ."</td></tr>";
					}
					?>
					</tbody>
				</table>
				<br/>
				<span style="float:right" class="eventsFont2">Total Amount: <?=$subTotal ?><?=AmountInWords($subTotal);?></span><br/>
				<span style="font-size:18px"><strong>Mode Of Payment: </strong><?=$eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD']; ?></span><br/>
				<?php if($eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD'] == "Cheque") { ?><br/>
					<span style="font-size:18px;margin-left:15px;"><strong>Cheque Number: </strong><?=$eventCounter[0]['CHEQUE_NO']; ?></span><br/>
					<span style="font-size:18px;margin-left:15px;"><strong>Cheque Date: </strong><?=$eventCounter[0]['CHEQUE_DATE']; ?></span><br/>
					<span style="font-size:18px;margin-left:15px;"><strong>Bank: </strong><?=$eventCounter[0]['BANK_NAME']; ?></span><br/>
					<span style="font-size:18px;margin-left:15px;"><strong>Branch: </strong><?=$eventCounter[0]['BRANCH_NAME']; ?></span><br/>
				<?php } else if($eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD'] == "Credit / Debit Card") { ?><br/>
					<span style="font-size:18px;margin-left:15px;"><strong>Transaction Id: </strong><?=$eventCounter[0]['TRANSACTION_ID']; ?></span><br/>
				<?php } ?><br/>
				<?php if($eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD_NOTES'] != "") { ?>
					<span style="font-size:18px;"><strong>Notes: </strong><?=$eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD_NOTES'] ?></span><br/>
				<?php } ?>
					<span style="font-size:18px;float:right"><strong>Issued By: </strong><?=$eventCounter[0]['TET_RECEIPT_ISSUED_BY'] ?></span>
			</form>
		</page>
	</div><!--for printing ends -->
	
	<div class="container">
		<form class="form-group">
			  <div class="form-group">
				<center><label class="eventsFont2 samFont1"><?=$eventCounter[0]["RECEIPT_TET_NAME"]; ?></label></center>
				<a class="pull-right" style="border:none; outline:0;" href="<?=$_SESSION['actual_link'] ?>" title="Back"><img style="border:none; outline: 0;margin-top: -71px;" src="<?php echo base_url(); ?>images/back_icon.svg"></a>
			  </div>
			  <div class="form-group">
				<span class="eventsFont2">Receipt Date: <?=$eventCounter[0]["TET_RECEIPT_DATE"];?></span>
				<span style="float:right" class="eventsFont2">Receipt Number: <?=$eventCounter[0]['TET_RECEIPT_NO'] ?></span>
			  </div>
			  
			  <div class="form-group">
				<span style="font-size:18px;"><strong>Name: </strong><?=$eventCounter[0]['TET_RECEIPT_NAME'] ?></span>
				<?php if($eventCounter[0]['TET_RECEIPT_RASHI'] != "") { ?>
					<span style="clear:both;float:right;font-size:18px;"><strong>Rashi: </strong><?=$eventCounter[0]['TET_RECEIPT_RASHI'] ?></span>
				<?php } ?>
			  </div>
			  
			   <div class="form-group">
			   <?php if($eventCounter[0]['TET_RECEIPT_PHONE'] != "") { ?>
					<span style="font-size:18px;"><strong>Number: </strong><?=$eventCounter[0]['TET_RECEIPT_PHONE'] ?></span>
				<?php } ?>
				<?php if($eventCounter[0]['TET_RECEIPT_NAKSHATRA'] != "") { ?>
					<span style="float: right;font-size:18px;"><strong>Nakshatra: </strong><?=$eventCounter[0]['TET_RECEIPT_NAKSHATRA'] ?></span>
				<?php } ?>
			  </div>
			  
			  <div class="table-responsive">
				<table id="eventSeva" class="table table-bordered">
					<thead>
					  <tr>
						<th>Sl. No.</th>
						<th>Seva Name</th>
						<th>Qty</th>
						<th>Seva Date</th>
						<th>Seva Amount</th>
						<th>Total Seva Amount</th>
						<th>Operatio</th>
					  </tr>
					</thead>
					<tbody id="eventUpdate">
					<?php 
					$i = 1;
					
					$subTotal = 0;
					foreach($eventCounter as $result) {

						$qty = @$result["TET_SO_QUANTITY"];
						if($qty == "") {
							$qty = 1;
						}
						
						$total = ($result["TET_SO_PRICE"] * $qty);
						$subTotal += $total;
						$TET_SO_ID = $result['TET_SO_ID'];
						$TET_SO_SEVA_ID = $result["TET_SO_SEVA_ID"];
						$TET_SO_IS_SEVA = $result["TET_SO_IS_SEVA"];
						echo "<tr><td>".$i++."</td>";
						echo "<td>". $result["TET_SO_SEVA_NAME"]."</td>";
						echo "<td>". $qty."</td>";
						echo "<td>". $result["TET_SO_DATE"]."</td>";
						echo "<td>". $result["TET_SO_PRICE"]."</td>";
						echo "<td>". $total ."</td>";
						if($result["TET_UPDATED_SO_DATE"] == "" && $result["TET_SO_IS_SEVA"] == "1" && strtotime($result["TET_SO_DATE"]) >= strtotime(date('d-m-Y')))
							echo "<td style='cursor:pointer;border-color: ;'><a title='Edit' onClick='edit($TET_SO_ID, $TET_SO_SEVA_ID, $TET_SO_IS_SEVA)';><span style='color:#800000' class='glyphicon glyphicon-pencil'></span></a></td></tr>";
					}
					?>
					</tbody>
				</table>
			  </div>
			  
			   <div class="form-group">
				<span style="float:right" class="eventsFont2">Total Amount: <?=$subTotal ?></span>
			  </div>
			  
			   <div class="form-group">
				<span style="font-size:18px"><strong>Mode Of Payment: </strong><?=$eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD']; ?></span>
				<?php if($eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD'] == "Cheque") { ?><br/>
					<span style="font-size:18px;margin-left:15px;"><strong>Cheque Number: </strong><?=$eventCounter[0]['CHEQUE_NO']; ?></span><br/>
					<span style="font-size:18px;margin-left:15px;"><strong>Cheque Date: </strong><?=$eventCounter[0]['CHEQUE_DATE']; ?></span><br/>
					<span style="font-size:18px;margin-left:15px;"><strong>Bank: </strong><?=$eventCounter[0]['BANK_NAME']; ?></span><br/>
					<span style="font-size:18px;margin-left:15px;"><strong>Branch: </strong><?=$eventCounter[0]['BRANCH_NAME']; ?></span><br/>
				<?php } else if($eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD'] == "Credit / Debit Card") { ?><br/>
					<span style="font-size:18px;margin-left:15px;"><strong>Transaction Id: </strong><?=$eventCounter[0]['TRANSACTION_ID']; ?></span><br/>
				<?php } ?><br/>
				<?php if($eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD_NOTES'] != "") { ?>
					<span style="font-size:18px;"><strong>Notes: </strong><?=$eventCounter[0]['TET_RECEIPT_PAYMENT_METHOD_NOTES'] ?></span><br/>
				<?php } ?>
					<span style="font-size:18px;float:right"><strong>Issued By: </strong><?=$eventCounter[0]['TET_RECEIPT_ISSUED_BY'] ?></span>
			  </div>
		</form>
		
		<form id="editForm" style="display:none;" method="post" action="<?=site_url()?>\Events\updateReceipt">
			<div class="form-inline">
				<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
					<label for="seva">Seva Date <span style="color:#800000;">*</span></label>
					<div class="form-group">
						<div class="input-group input-group-sm multiDate">
							<input id="multiDate" type="text" value="" class="form-control todayDate2" placeholder="dd-mm-yyyy">
							<div class="input-group-btn">
							  <button class="btn btn-default todayDate" type="button">
								<i class="glyphicon glyphicon-calendar"></i>
							  </button>
							</div>
						</div>
						
						<div style="display:none;" class="input-group input-group-sm multiDate1">
							<input id="multiDate1" type="text" value="" class="form-control todayDate2" placeholder="dd-mm-yyyy">
							<div class="input-group-btn">
							  <button class="btn btn-default todayDate1" type="button">
								<i class="glyphicon glyphicon-calendar"></i>
							  </button>
							</div>
						</div><br/><br/>
						<label class="showSeva" style="display:none;">Available Seva: <span id="sevaAvailable"></span></label><br/>
						<button type="button" id="update" class="btn btn-default btn-md"><span class="glyphicon glyphicon-edit"></span> Update Receipt</button>
					</div>
				</div>
			</div>
		</form>
	</div>
<script>
	var eventSeva = "";
	var availableDates = [];
	var limit = [];
	var sevaLimit = "";
	var id1 = "";
	var sevaId1 = "";
	var isSeva1 = "";
	var currentTime = new Date("<?=date('D M d Y H:i:s O'); ?>");
	
	var fromDate = "<?=$activeDate[0]->TET_FROM_DATE_TIME; ?>"; 
	var toDate = "<?=$activeDate[0]->TET_TO_DATE_TIME; ?>"; 
	fromDate = fromDate.split("-");
	toDate = toDate.split("-");
	
	var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + (Number(currentTime.getDate())+2)); //one day next before month
	var maxDate =  new Date(currentTime.getFullYear(), currentTime.getMonth() +12, +0); // one day before next month
	
	var minDate1 = new Date(Number(fromDate[2]), (Number(fromDate[1])-1), + (Number(fromDate[0])+1)); 
	var maxDate1 =  new Date(Number(toDate[2]), (Number(toDate[1])-1), + Number(toDate[0]));

	function edit(id, sevaId, isSeva) {
		$('#multiDate1').val("");
		$('#multiDate').val("");
		$('#multiDateHidden').val("");
		$('#updateId').val("");
		id1 = id;
		sevaId1 = sevaId;
		isSeva1 = isSeva;

		$('#editForm').slideDown();
		
		$.post("<?=site_url()?>TrustEvents/getSevaLimit", {'idName':sevaId1, 'fromEditReceiptPrint':"1"}, function(e) {

				limit = JSON.parse(e);
				if(limit.length > 0) {
					$('.multiDate').slideUp();
					$('.multiDate1').slideDown();
					$('.showSeva').slideDown();
					for(let i = 0; i < limit.length; ++i) {
						availableDates[i] = limit[i]['TET_SEVA_DATE'].replace(/(^|-)0+/g, "$1");
					}
					$('#multiDate1').focus();
				}else {
					$('.multiDate').slideDown();
					$('.multiDate1').slideUp();
					$('.showSeva').slideUp();
					$('#multiDate').focus();
				}
			});
	}
	
	function available(date) {
	  dmy = date.getDate() + "-" + (date.getMonth()+1) + "-" + date.getFullYear();
	  if ($.inArray(dmy, availableDates) != -1) {
		return [true, "","Available"];
	  } else {
		return [false,"","unAvailable"];
	  }
	}
	
	$('#update').on('click', function() {
		if($('.multiDate').is(':visible')) {
			multiDate = $('#multiDate').val();
		} else if($('.multiDate1').is(':visible')) {
			multiDate = $('#multiDate1').val();
		}
		
		$.post('<?=site_url()?>TrustEvents/getSevaOffered',{'id':sevaId1, 'sevadate':multiDate}, (e)=>{
			if(e.length > 0) {
				var currentSeva = JSON.parse(e);
				currentSevaLength = currentSeva.length;
				if(limit.length > 0) {
					for(let i = 0; i < limit.length; ++i) {
						if(limit[i]['TET_SEVA_DATE'] == multiDate) {
							currentSevaLength = (limit[i]['TET_SEVA_LIMIT'] - currentSevaLength);
							break;
						}
					}
					if(Number(currentSevaLength) > 0) {
						$('#sevaAvailable').html(currentSevaLength);
						$.post("<?=site_url()?>TrustEvents/updateReceipt",{'multiDatehidden':multiDate,'updateId':id1}, function(e) {
							if(e = "success") {
								$.confirm({
									title: "Information",
									content: "Successfully Updated",
									type: 'red',
									typeAnimated: true,
									closeIcon:close,
									buttons: {
										tryAgain: {
											text: "Continue",
											btnClass: 'btn-red',
											action: function(){
												location.href = "<?=$_SESSION['actual_link']; ?>"
											}
										},
									}
								});
							}
						});
					} else {
						$('#sevaAvailable').html("0");
						alert("Information", "Sevas are reserved for this Date " + multiDate)
					}
				} else {
					$.post("<?=site_url()?>TrustEvents/updateReceipt",{'multiDatehidden':multiDate,'updateId':id1}, function(e) {
						$.confirm({
							title: "Information",
							content: "Successfully Updated",
							type: 'red',
							typeAnimated: true,
							closeIcon:close,
							buttons: {
								tryAgain: {
									text: "Continue",
									btnClass: 'btn-red',
									action: function(){
										location.href = "<?=$_SESSION['actual_link']; ?>"
									}
								},
							}
						});
					});
				}
			} else {
				$.post("<?=site_url()?>TrustEvents/updateReceipt",{'multiDatehidden':multiDate,'updateId':id1}, function(e) {
					$.confirm({
						title: "Information",
						content: "Successfully Updated",
						type: 'red',
						typeAnimated: true,
						closeIcon:close,
						buttons: {
							tryAgain: {
								text: "Continue",
								btnClass: 'btn-red',
								action: function(){
									location.href = "<?=$_SESSION['actual_link']; ?>"
								}
							},
						}
					});
				});
			}
		});
		// alert($('#multiDateHidden').val())
		// alert($('#updateId').val())
		
	});
	
	$("#multiDate1").datepicker({
		beforeShowDay: available,
		dateFormat: 'dd-mm-yy',
		minDate: minDate1, 
		maxDate: maxDate1,
		autoclose: false,
		onSelect: function (selectedDate) {
			$.post('<?=site_url()?>TrustEvents/getSevaOffered',{'id':sevaId1, 'sevadate':selectedDate}, (e)=>{
				if(e.length > 0) {
					var currentSeva = JSON.parse(e);
					currentSevaLength = currentSeva.length;
					if(limit.length > 0) {
						
						for(let i = 0; i < limit.length; ++i) {
							if(limit[i]['TET_SEVA_DATE'] == selectedDate) {
								currentSevaLength = (limit[i]['TET_SEVA_LIMIT'] - currentSevaLength);
								break;
							}
						}
						if(Number(currentSevaLength) > 0)
							$('#sevaAvailable').html(currentSevaLength);
						else
							$('#sevaAvailable').html("0");
						
					}
				}
			})
		}
	});
	
	$("#multiDate").datepicker({
		minDate: minDate1, 
		maxDate: maxDate1,
		dateFormat: 'dd-mm-yy',
		autoclose: false,
		onSelect: function (selectedDate) {
			$('#selDate').html($('#multiDate').val());
			$('#multiDate').blur();
			$('#multiDate').css('border-color', "#000000");
		}
	});
	
	
	$('.todayDate').on('click', function() {
		$("#multiDate").focus();
	});
	
	$('.todayDate1').on('click', function() {
		$("#multiDate1").focus();
	});
	
	var print = function() {
		var newWindow = window.open();
		newWindow.document.write('<html><head><link href="<?php echo  base_url(); ?>css/print.css" rel="stylesheet"><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous"><link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/style.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/bootstrap-modal-shake.css" rel="stylesheet"></head><body>');
		newWindow.document.write($('#printScreen').html());
		newWindow.document.write('</body></html>');
		newWindow.document.close();
		setTimeout(function(){ newWindow.print();newWindow.close();}, 1000);
	}
	
	$('#print').on('click',function() {
		print();
		$('#print').html(" Re-Print Receipt");
	});
	
	//location.href = "<?=site_url()?>";
</script>
