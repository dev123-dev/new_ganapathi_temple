<?php 
	//$this->output->enable_profiler(TRUE);
	// error_reporting(0);
 ?>
<style>
    .datepicker {
      z-index: 1600 !important; /* has to be larger than 1050 */
    } .editsevadate {
      z-index: 1600 !important; /* has to be larger than 1050 */
    }
</style>
<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<div class="row form-group">
		<div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
			<span class="eventsFont2">All Booked Sevas</span>
		</div>
	</div>
	<div class="row form-group">
		<form id="tddate" enctype="multipart/form-data" method="post" accept-charset="utf-8">
			<?php if(isset($date)) {?>
				<input type="hidden" name="tdate" id="tdate" value="<?php echo $date; ?>">
			<?php } ?>
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
						<input style="border-radius:2px;" id="todayDate" name="todayDate" type="text" value="<?=@$date; ?>" class="form-control todayDate"  onchange="get_datefield_change(this.value)" placeholder="dd-mm-yyyy" readonly = "readonly" />
						<div class="input-group-btn">
							<button class="btn btn-default toDateBtn" type="button">
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
							<input name="fromDate" onchange="get_datefield_change(this.value)" id="fromDate" type="text" class="form-control fromDate2" value="<?=@$fromDate; ?>" placeholder="From: dd-mm-yyyy" readonly="readonly" />
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
							<input name="toDate" onchange="get_datefield_change(this.value)" id="toDate" type="text" value="<?=@$toDate; ?>" class="form-control toDate2" placeholder="To: dd-mm-yyyy" readonly="readonly" />
							<div class="input-group-btn">
								<button class="btn btn-default toDate" type="button">
									<i class="glyphicon glyphicon-calendar"></i>
								</button>
							</div>
						</div>
					</div>
				</div>				
			</div>
			
			<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
				<div class="input-group input-group-sm">
					<input autocomplete="" type="text" id="name_phone" name="name_phone" value="<?=@$name_phone; ?>" class="form-control" placeholder="Name / Phone">
					<div class="input-group-btn">
						<button class="btn btn-default name_phone" type="submit" onclick="return get_search()">
							<i class="glyphicon glyphicon-search"></i>
						</button>
					</div>
				</div>
			</div>
			
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-9">
			  <select id="modeOfPayment" name="modeOfPayment" class="form-control" onchange="get_payment_mode_change(this.value)">
				<?php if(isset($PMode)) {?>
					<?php if($PMode == "All") { ?>
						<option selected value="All">All = <?php if($All != "") { echo $All; } else { echo "0";} ?></option>
					<?php } else { ?>
						<option value="All">All = <?php if($All != "") { echo $All; } else { echo "0";} ?></option>
					<?php } ?>
					<?php if($PMode == "Pending") { ?>
						<option selected value="Pending">Pending = <?php if($Pending != "") { echo $Pending; } else { echo "0"; } ?></option>
					<?php } else { ?>
						<option value="Pending">Pending = <?php if($Pending != "") { echo $Pending; } else { echo "0"; } ?></option>
					<?php } ?>
					<?php if($PMode == "Completed") { ?>
						<option selected value="Completed">Completed = <?php if($Completed != "") { echo $Completed; } else { echo "0"; } ?></option>
					<?php } else { ?>
						<option value="Completed">Completed = <?php if($Completed != "") { echo $Completed; } else { echo "0"; } ?></option>
					<?php } ?> 
					<?php if($PMode == "Cancelled") { ?>
						<option selected value="Cancelled">Cancelled = <?php if($Cancelled != "") { echo $Cancelled; } else { echo "0"; } ?></option>
					<?php } else { ?>
						<option value="Cancelled">Cancelled = <?php if($Cancelled != "") { echo $Cancelled; } else { echo "0"; } ?></option>
					<?php } ?>
				<?php } else { ?>
						<option value="All">All = <?php if($All != "") { echo $All; } else { echo "0";} ?></option>
						<option value="Pending">Pending = <?php if($Pending != "") { echo $Pending; } else { echo "0"; } ?></option>
						<option value="Completed">Completed = <?php if($Completed != "") { echo $Completed; } else { echo "0"; } ?></option>
						<option value="Cancelled">Cancelled = <?php if($Cancelled != "") { echo $Cancelled; } else { echo "0"; } ?></option>
				<?php } ?>
			  </select>
			  <!--HIDDEN FIELDS -->
			  <input type="hidden" name="paymentMethod" id="paymentMethod">
			</div>
		</form>
		<form id="report" enctype="multipart/form-data" method="post" accept-charset="utf-8">
			<div class="col-offset-lg-4 col-lg-4 col-md-4 col-sm-4 col-xs-12 pull-right text-right">
				<?php if(isset($_SESSION['Add'])) { ?>
					<a style="margin-left: 9px;pull-right;" href="<?=site_url()?>SevaBooking/book_Seva" title="Book Seva"><img style="width:24px; height:24px" src="<?=site_url();?>images/add_icon.svg"/></a>&nbsp;&nbsp;
				<?php } ?>
				<a onclick="GetSendField()" style="cursor:pointer;"><img style="width:24px; height:24px" title="Download Excel Report" src="<?=site_url();?>images/excel_icon.svg"/></a>&nbsp;&nbsp;
				<a onclick="generatePDF()"><img style="width:24px; height:24px" title="Download PDF Report" src="<?=site_url();?>images/pdf_icon.svg"/></a>&nbsp;&nbsp;
				<a style="text-decoration:none;cursor:pointer;pull-right;" href="<?=site_url()?>SevaBooking/index" title="Refresh"><img style="width:24px; height:24px" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
			</div>
			<!--HIDDEN FIELDS -->
			<input type="hidden" name="payMode" id="payMode">
			<input type="hidden" name="dateField" id="dateField">
			<input type="hidden" name="namephone" id="namephone">
			<input type="hidden" name="allDates" id="allDateField" value="<?=@$allDates; ?>">
			<input type="hidden" name="radioOpt" id="radioOptField" value="<?=@$radioOpt; ?>">
		</form>
	</div>
</div>

<div class="container">
	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th style="width:10%;">Seva Date</th>
							<th style="width:10%;">Booking No.</th>
							<th style="width:10%;">Name (Phone)</th>
							<th style="width:15%;">Address</th>
							<th style="width:15%;">Deity</th>
							<th style="width:15%;">Seva</th>
							<th style="width:5%;">Amount</th>
							<th style="width:10%;">Date</th>
							<th style="width:15%;"><center>Operation</center></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($getBooking as $result) { ?>
							<tr class="row1">
								<td><?php echo $result->SO_DATE; ?></td>
								<?php if($result->SB_ACTIVE == 0) { ?>
									<td style="text-decoration:line-through;"> <?php echo $result->SB_NO; ?></td>
								<?php } else { ?>
									<td> <?php echo $result->SB_NO; ?></td>
								<?php } ?>
								<?php if($result->SB_PHONE != ""){ ?>
									<td><?php echo $result->SB_NAME; ?><br/><?php echo "("; echo $result->SB_PHONE; echo")"; ?></td>
								<?php } else { ?>
									<td><?php echo $result->SB_NAME; ?></td>
								<?php } ?>
								<td><?php echo $result->SB_ADDRESS; ?></td>
								<td><?php echo $result->SO_DEITY_NAME; ?></td>
								<td><?php echo $result->SO_SEVA_NAME; ?></td>
								<?php if($result->SO_PRICE == 0) { ?>
									<td></td>
								<?php } else { ?>
									<td><?php echo $result->SO_PRICE; ?></td>
								<?php } ?>
								<td><?php echo $result->SB_DATE; ?></td>
								<td class="text-center" width="10%">
										<?php if(($result->SB_PAYMENT_STATUS == 0 && $result->SB_ACTIVE != 0)) { ?>
											<a style="border:none; outline: 0;" href="<?php echo site_url(); ?>SevaBooking/add_book_seva/<?php echo$result->SB_ID; ?>" title="Generate Receipt"><img style="border:none; outline: 0;" width="24px" height="24px" src="<?php echo base_url(); ?>images/check_icon.svg"></a>
											<?php if($result->SO_DATE >= date("d-m-Y")) { ?>
												<a style="border:none; outline: 0;" onClick="callModal('<?php echo $result->SB_NO; ?>','<?php echo str_replace('"','&#34;',str_replace("'","\'",$result->SB_NAME)); ?>','<?php echo $result->SB_PHONE; ?>','<?php echo str_replace("'","\'",$result->SB_ADDRESS); ?>','<?php echo $result->SO_DEITY_NAME; ?>','<?php echo $result->SO_SEVA_NAME; ?>','<?php echo $result->SO_DATE; ?>','<?php echo $result->SO_ID; ?>')" title="Edit Seva Date" ><img style="border:none; outline: 0;" src="<?php echo	base_url(); ?>images/edit_icon.svg"></a>
											<?php } ?>
											<a style="border:none; outline: 0;" title="Cancellation" onclick="show_cancelled('<?php echo $result->SB_ID; ?>','<?php echo $result->SB_NO; ?>')"><img style="border:none; outline: 0;" src="<?php echo	base_url(); ?>images/delete.svg"></a>
										<?php } ?>
									</td>
								<!-- <td class="text-center" width="10%">
									<?php if(($result->SB_PAYMENT_STATUS == 0 && $result->SB_ACTIVE != 0)) { ?>
										<?php if($result->SB_PAYMENT_STATUS == 0) { ?>
											<a style="border:none; outline: 0;" href="<?php echo site_url(); ?>SevaBooking/add_book_seva/<?php echo$result->SB_ID; ?>" title="Generate Receipt"><img style="border:none; outline: 0;" width="24px" height="24px" src="<?php echo base_url(); ?>images/check_icon.svg"></a>
										<?php } else { ?> 
											<a style="border:none; outline: 0;" title="Generate Receipt" onclick="alert('Information','Seva Receipt has been already generated for this booking (<?php echo $result->SB_NO; ?>).','OK',true,'')"><img style="border:none; outline: 0;" width="24px" height="24px" src="<?php echo base_url(); ?>images/check_icon.svg"></a>
										<?php } ?>
										<?php if($result->UPDATED_SO_DATE == "") { ?>
											<a style="border:none; outline: 0;" onClick="callModal('<?php echo $result->SB_NO; ?>','<?php echo str_replace('"','&#34;',str_replace("'","\'",$result->SB_NAME)); ?>','<?php echo $result->SB_PHONE; ?>','<?php echo str_replace("'","\'",$result->SB_ADDRESS); ?>','<?php echo $result->SO_DEITY_NAME; ?>','<?php echo $result->SO_SEVA_NAME; ?>','<?php echo $result->SO_DATE; ?>','<?php echo $result->SO_ID; ?>')" title="Edit Seva Date" ><img style="border:none; outline: 0;" src="<?php echo	base_url(); ?>images/edit_icon.svg"></a>
										<?php } else { ?>
											<a style="border:none; outline: 0;" title="Edit Seva Date" onclick="alert('Information','Seva date has been already edited.','OK',true,'')"><img style="border:none; outline: 0;" src="<?php echo	base_url(); ?>images/edit_icon.svg"></a>
										<?php } ?>
										<a style="border:none; outline: 0;" title="Cancellation" onclick="show_cancelled('<?php echo $result->SB_ID; ?>','<?php echo $result->SB_NO; ?>')"><img style="border:none; outline: 0;" src="<?php echo	base_url(); ?>images/delete.svg"></a>
									<?php } ?>
								</td> -->
							</tr>
						<?php } ?>
					</tbody>
				</table>
				
			</div>
		</div>
	</div>
	<!--Total Booking TextField -->
	<div class= "row">
		<ul class="pagination pagination-sm" style="margin-left:15px;margin-top: -1em;">
			<?=$pages; ?>
		</ul>
		<?php if($Count != 0) { ?>
		<label class="pull-right" style="font-size:18px;margin-right:15px;margin-top: -1em;">Total Booking: <strong style="font-size:18px"><?php echo $Count ?></strong></label>
		<?php } ?>					
	</div>
</div>

<!-- Cancelled Modal2 -->
<div id="myModalCancelled" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content" style="padding-bottom:1em;">
			<div class="modal-header">
				<button type="button" class="close topClosePos" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Add Cancellation Notes</h4>
			</div>
			<div class="modal-body" id="cancelleddet" style="overflow-y: auto;max-height: 330px;">
				<textarea id="cancelNotes" rows="4" cols="50" style="width: 100%;"></textarea>		
				<button type="button" id="submitNotes" class="btn btn-default pull-right">SAVE</button>
			</div>
		</div>
	</div>
</div>
<form id="cancelForm" action="<?php echo site_url(); ?>Receipt/save_cancel_note_booking/" class="form-group" role="form" enctype="multipart/form-data" method="post">
	<input type="hidden" id="rId" name="rId">
	<input type="hidden" id="rNo" name="rNo">
	<input type="hidden" id="cNote" name="cNote">
</form>
<!-- Modal -->
<div class="modal fade" id="editBooking" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close topClosePos" data-dismiss="modal">&times;</button>
				<h4 style="font-weight:600;" class="modal-title text-center">Edit Seva Date</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<label for="inputLimit" ><span style="font-weight:600;">Booking No : </span></label><span id="bookingno"></span>
					</div>
				
					<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<label for="inputLimit" ><span style="font-weight:600;">Seva Date : </span> </label><span id="sevadate"></span>
					</div>
				
					<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<label for="inputLimit" ><span style="font-weight:600;">Deity : </span> </label><span id="deity"></span>
					</div>
					
					<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<label for="inputLimit" ><span style="font-weight:600;">Seva : </span> </label><span id="seva"></span>
					</div>
					
					<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<label for="inputLimit" ><span style="font-weight:600;">Name : </span></label><span id="name"></span>
					</div>
					
					<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6" id="divPhone">
						<label for="inputLimit" ><span style="font-weight:600;">Phone : </span></label><span id="phone"></span>
					</div>
					
					<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6" id="divAddress">
						<label for="seva"><span style="font-weight:600;">Address : </span></label><span id="address"></span>
					</div>
				</div>
				
				<div style="clear:both;" class="form-group">
					<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<label for="seva"><span style="font-weight:600;">Seva Date : </span><span style="color:#800000;">*</span></label>
						<div class="input-group input-group-sm">
							<input name="editsevadate" id="editsevadate" type="text" value="" class="form-control editsevadate" placeholder="dd-mm-yyyy" />
							<div class="input-group-btn">
								<button class="btn btn-default todayDate5" type="button">
									<i class="glyphicon glyphicon-calendar"></i>
								</button>
							</div>
						</div>
					</div>
				</div>
				<!-- HIDDEN -->
				<div class="modal-footer">
					<button type="button" id="submit" class="btn btn-default">SAVE</button>
				</div>
			</div>
		</div>
	</div>
</div>
<form id="submitForm" action="<?php echo site_url(); ?>SevaBooking/edit_book_seva/" class="form-group" role="form" enctype="multipart/form-data" method="post">
	<input type="hidden" id="soId" name="soId" value="">
	<input type="hidden" id="editsevadate2" name="editsevadate2" value="">
</form>
<script>
	//CANCELLATION STARTS HERE
	function show_cancelled(id,rNo) {
		$('#rId').val(id);
		$('#rNo').val(rNo);
		$('#cancelleddet').html();
		$('#myModalCancelled').modal('show');  
	}
	
	$('#cancelNotes').keyup(function() {
		if($('#cancelNotes').val() != "") {
			$('#cancelNotes').css('border-color', "#000000");
		} else {
			$('#cancelNotes').css('border-color', "#FF0000");
		}
	});
	
	$('#submitNotes').on('click', function() {
		if($('#cancelNotes').val() != "") {
			$('#cNote').val($('#cancelNotes').val());
			$('#cancelForm').submit();
		} else {
			$('#myModalCancelled').effect( "shake" );
			$('#cancelNotes').css('border-color', "#FF0000");
		}
	});
	//CANCELLATION ENDS HERE

	var between = [];
	
	function generateAllDates() {
		between = [];
		var sDate1 = "";
		var start = $("#fromDate").datepicker("getDate");
		end = $("#toDate").datepicker("getDate");
		// console.log(start)
		currentDate = new Date(start),
		between = [];
		while (currentDate <= end) {
			// console.log(currentDate);
			between.push(("0" + currentDate.getDate()).slice(-2) + "-" + ("0" + (currentDate.getMonth() + 1)).slice(-2) + "-" + currentDate.getFullYear());	
			
			currentDate.setDate(currentDate.getDate() + 1);
		}
		newDate = between.join("|")
		// console.log(newDate)
		document.getElementById('allDates').value = newDate;
	}
	
	$('#submit').on('click', function() {
		if($('#editsevadate').val() != "") {
			$('#submitForm').submit();
		} else { 
			$('#editsevadate').css('border-color','red');
			$('#chequeRemmittance').shake(); 
		}
	});
	
	var currentTime = new Date()
	var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
	var maxDate = new Date(currentTime.getFullYear(), currentTime.getMonth() + 12, +0); // one day before next month
	
	
	$('#editsevadate').val("");
	$('#editsevadate').css('border-color','black');
	$( ".editsevadate" ).datepicker({
		minDate: minDate,
		maxDate: maxDate,
		dateFormat: 'dd-mm-yy',
		onSelect: function (selectedDate) {
			$('#editsevadate2').val(selectedDate);
			$('#editsevadate').css('border-color','black');
		}
	});
	
	$('.todayDate5').on('click',function() {
		$( ".editsevadate" ).focus();
	});
	
	//OPEN MODAL FOR EDIT DATE
	function callModal(bookingno, name, phone, address, deity, seva, sevadate, soId) {
		$('#editsevadate').css('border-color','black');
		$('#editsevadate').val("");
		$('#name').html(" "+name);
		$('#phone').html(" "+phone);
		if(phone == "") {
			$('#divPhone').css('display','none');
		} else {
			$('#divPhone').css('display','block');
		}
		$('#address').html(" "+address);
		if(address == "") {
			$('#divAddress').css('display','none');
		} else {
			$('#divAddress').css('display','block');
		}
		$('#deity').html(" "+deity);
		$('#seva').html(" "+seva);
		$('#sevadate').html(" "+sevadate);
		$('#bookingno').html(" "+bookingno);
		$('#soId').val(soId);
		$('#editBooking').modal();
	}
	
	//ON CHANGE OF PAYMENT MODE
	function get_payment_mode_change(paymentMode) {
		var radio = $('#radioOpt').val();
		let count = 0;
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
			
			if(count == 0)
				generateAllDates();
		}
		
		if(count != 0) {
			alert("Information","Please fill required fields","OK");
			return false;
		}
		
		document.getElementById('paymentMethod').value = paymentMode;
		url = "<?php echo site_url(); ?>SevaBooking/seva_booking_on_change_date";
		$("#tddate").attr("action",url)
		$("#tddate").submit();
	}
	
	//ON CHANGE OF DATEFIELD
	function get_datefield_change(date) {
		var radio = $('#radioOpt').val();
		let count = 0;
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
			
			if(count == 0)
				generateAllDates();
		} 
		
		if(count != 0) {
			alert("Information","Please fill required fields","OK");
			return false;
		}
		document.getElementById('tdate').value = date;
		document.getElementById('paymentMethod').value = $('#modeOfPayment').val();
		url = "<?php echo site_url(); ?>SevaBooking/seva_booking_on_change_date";
		$("#tddate").attr("action",url);
		$("#tddate").submit();
	}
	
	//SEARCH NAME AND PHONE
	function get_search() {
		var radio = $('#radioOpt').val();
		let count = 0;
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
			
			if(count == 0)
				generateAllDates();
		} 
		
		if(count != 0) {
			alert("Information","Please fill required fields","OK");
			return false;
		}
		document.getElementById('paymentMethod').value = $('#modeOfPayment').val();
		url = "<?php echo site_url(); ?>SevaBooking/seva_booking_on_change_date";
		$("#tddate").attr("action",url);
		$("#tddate").submit();
	}
	
	//GET SEND POST FIELDS EXCELS
	function GetSendField() {
		var radio = $('#radioOpt').val();
		let count = 0;
		if(radio == "date"){
			if(!$('#todayDate').val()) {
				$('#todayDate').css('border', "1px solid #FF0000"); 
				++count
			} else {
				$('#todayDate').css('border', "1px solid #000000");
			}
		} else {
			if(!$('#toDate').val()) {
				$('#toDate').css('border', "1px solid #FF0000"); 
				++count
			} else {
				$('#toDate').css('border', "1px solid #000000"); 
			}
			
			if(!$('#fromDate').val()) {
				$('#fromDate').css('border', "1px solid #FF0000"); 
				++count
			} else {
				$('#fromDate').css('border', "1px solid #000000"); 
			}
			
			if(count == 0) {
				generateAllDates();
			}
		}
		
		if(count != 0) {
			alert("Information","Please fill required fields","OK");
			return false;
		}
		
		document.getElementById('namephone').value = $('#name_phone').val();
		document.getElementById('payMode').value = $('#modeOfPayment').val();
		document.getElementById('dateField').value = $('#todayDate').val();
		url = "<?php echo site_url(); ?>SevaBooking/seva_booking_report_excel";
		$("#report").attr("action",url)
		$("#report").submit();
	}
	
	//FOR PDF
	function generatePDF() {
		var radio = $('#radioOpt').val();
		let count = 0;
		if(radio == "date"){
			if(!$('#todayDate').val()) {
				$('#todayDate').css('border', "1px solid #FF0000"); 
				++count
			} else {
				$('#todayDate').css('border', "1px solid #000000");
			}
		} else {
			if(!$('#toDate').val()) {
				$('#toDate').css('border', "1px solid #FF0000"); 
				++count
			} else {
				$('#toDate').css('border', "1px solid #000000"); 
			}
			
			if(!$('#fromDate').val()) {
				$('#fromDate').css('border', "1px solid #FF0000"); 
				++count
			} else {
				$('#fromDate').css('border', "1px solid #000000"); 
			}
			
			if(count == 0) {
				generateAllDates();
			}
		}
		
		if(count != 0) {
			alert("Information","Please fill required fields","OK");
			return false;
		}
		
		document.getElementById('namephone').value = $('#name_phone').val();
		document.getElementById('payMode').value = $('#modeOfPayment').val();
		document.getElementById('dateField').value = $('#todayDate').val();
		
		url = "<?php echo site_url(); ?>generatePDF/create_sevaBookingPDF";
		$("#report").attr("action",url)
		$("#report").submit();
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
		$('#name_phone').val("");
		$('.EveryRadio').hide();
		$('#radioOpt').val("date");
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
	} else {
		$('#EveryRadio').css('pointer-event','auto');
		$('#multiDateRadio').css('pointer-event','none');
		$('.EveryRadio').fadeIn();
		$('#selDate').html("");
		$('.multiDate').hide();
		$('#radioOpt').val("multiDate");
		$('#EveryRadio').attr("checked", "checked")
	}
	
	//FOR DATEFIELD
	var currentTime = new Date()
    var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
    var maxDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
    $( ".todayDate" ).datepicker({ 
		yearRange:'2007:+50',
		maxDate: "+25y +3m +1w",
		dateFormat: 'dd-mm-yy',
		changeMonth:true,
		changeYear:true,
		
    });
     
	$('.todayDate').on('click', function() {
		$( ".todayDate" ).focus();
	})
	
	$(".fromDate2").datepicker({ 
		//maxDate: maxDate,
		dateFormat: 'dd-mm-yy',
		changeMonth:true,
		changeYear:true,
		'yearRange': "2007:+5",
	});
	
	$(".toDate2").datepicker({
		//maxDate: maxDate,
		dateFormat: 'dd-mm-yy',
		changeMonth:true,
		changeYear:true,
		'yearRange': "2007:+5",
	});
	
	// $( ".toDate" ).datepicker({
		// //maxDate: maxDate,
		// dateFormat: 'dd-mm-yy',
		// changeMonth:true,
		// changeYear:true,
	// });
     
	$('.toDateBtn').on('click', function() {
		$( ".todayDate" ).focus();
	})
	
	$('.toDate').on('click', function() {
		$( ".toDate2" ).focus();
	})
	
	$('.fromDate').on('click', function() {
		$( ".fromDate2" ).focus();
	})
</script>