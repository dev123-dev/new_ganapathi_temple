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
			<span class="eventsFont2">All Hall Booking</span>
		</div>
	</div>
	<div class="row form-group">
		<form id="tddate" enctype="multipart/form-data" method="post" accept-charset="utf-8">
			<?php if(isset($date)) {?>
				<input type="hidden" name="tdate" id="tdate" value="<?php echo $date; ?>">
			<?php } ?>
			<input type="hidden" name="allDates" id="allDates" value="<?=@$allDates; ?>">
			<input type="hidden" name="radioOpt" id="radioOpt" value="<?=$radioOpt; ?>">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="display:none;">
				<div class="radio form-group">
					<label> 
						<input id="multiDateRadio" class="eventsFont form-control" type="radio" value="" name="optradio" checked /> Single Date
					</label>&nbsp;&nbsp;&nbsp;
					<label>
						<input id="EveryRadio" class="eventsFont form-control" type="radio" value="" name="optradio"> Multiple Date
					</label>
				</div>
			</div>
			<!--SINGLE DATE -->
			<div class="multiDate" style="display:none;">
				<div class="col-lg-2 col-md-2 col-sm-3 col-xs-5">
					<div class="input-group input-group-sm">
						<input style="border-radius:2px;" id="todayDate" name="todayDate" type="text" value="<?=@$date; ?>" class="form-control todayDate"  onchange="get_datefield_change(this.value)" placeholder="dd-mm-yyyy" readonly="readonly"/>
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
							<input name="fromDate" onchange="get_datefield_change(this.value)" id="fromDate" type="text" class="form-control fromDate2" value="<?=@$fromDate; ?>" placeholder="From: dd-mm-yyyy" readonly = "readonly" />
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
							<input name="toDate" onchange="get_datefield_change(this.value)" id="toDate" type="text" value="<?=@$toDate; ?>" class="form-control toDate2" placeholder="To: dd-mm-yyyy" readonly = "readonly" />
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
			
			<div style="display:none;" class="col-lg-2 col-md-2 col-sm-2 col-xs-9">
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
				<?php } else { ?>
						<option value="All">All = <?php if($All != "") { echo $All; } else { echo "0";} ?></option>
						<option value="Pending">Pending = <?php if($Pending != "") { echo $Pending; } else { echo "0"; } ?></option>
						<option value="Completed">Completed = <?php if($Completed != "") { echo $Completed; } else { echo "0"; } ?></option>
				<?php } ?>
			  </select>
			  <!--HIDDEN FIELDS -->
			  <input type="hidden" name="paymentMethod" id="paymentMethod">
			</div>
		</form>
		<form id="report" enctype="multipart/form-data" method="post" accept-charset="utf-8">
			<div class="col-offset-lg-4 col-lg-4 col-md-4 col-sm-4 col-xs-12 pull-right text-right">
				<?php if(isset($_SESSION['Add'])) { ?>
					<a style="margin-left: 9px;pull-right;" href="<?=site_url()?>Trust/bookHall" title="Book Hall"><img style="width:24px; height:24px" src="<?=site_url();?>images/add_icon.svg"/></a>&nbsp;&nbsp;
				<?php } ?>
				<a style="text-decoration:none;cursor:pointer;pull-right;" href="<?=site_url()?>Trust" title="Refresh"><img style="width:24px; height:24px" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
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
				<table class="table table-bordered table-hover">
					<thead>
					  <tr>
						<th>Booking Date</th>
						<th>Booking No.</th>
						<th>Name (Phone)</th>
						<th>Hall</th>
						<th>From</th>
						<th>To</th>
						<th>Function Status</th>
						<th>Payment Status</th>
						<th>Operation</th>
					  </tr>
					</thead>
					<tbody>
						<?php foreach($hallBooking as $result) { ?>
							<tr class="row1">
								<td><?php echo date("d-m-Y", strtotime($result["HB_BOOK_DATE"])); ?></td>
								<td><?=$result["HB_NO"]; ?></td>
								<?php if($result["HB_NUMBER"]) { ?>
									<td><?php echo $result["HB_NAME"]." (".$result["HB_NUMBER"].")"; ?></td>
								<?php } else { ?>
									<td><?php echo $result["HB_NAME"]; ?></td>
								<?php } ?>
								<td><?php echo $result["H_NAME"]; ?></td>
								<td><?php echo date('g:i a', strtotime($result["HB_BOOK_TIME_FROM"])); ?></td>
								<td><?php echo date('g:i a', strtotime($result["HB_BOOK_TIME_TO"])); ?></td>
								<?php if($result["IS_DONE"] == "1") { ?>
									<td>Done</td>
								<?php } else if($result["IS_DONE"] == "0") { ?>
									<td>Not Done</td>
								<?php } else { ?>
									<td>Pending</td>
								<?php } ?>
								<?php if($result["HB_PAYMENT_STATUS"] == 1) { ?>
									<td>Partial</td>
								<?php } else if($result["HB_PAYMENT_STATUS"] == 2) { ?>
									<td>Completed</td>
								<?php } else { ?>
									<td>Pending</td>
								<?php } ?>
								<td class="text-center" width="12%">
									<?php  
										$HB_ID = $result['HB_ID'];	
										$H_NAME = $result['H_NAME'];
									?>
									<?php if($result["HB_PAYMENT_STATUS"] != 2) { ?>
										<!-- Generate receipt added this condition by adithya -->
										<?php if($result["HB_PAYMENT_STATUS"] == 0) {?>
										<?php } else {?>
										<a style="border:none; outline: 0;" onClick="check_iconClick(<?=$HB_ID; ?>)" title="Confirm Full Payment"><img style="border:none; outline: 0;" width="24px" height="24px" src="<?php echo base_url(); ?>images/check_icon.svg"></a>
										<?php }?>
										<!-- Add receipt -->
										<a style="border:none; outline: 0;" onClick="add('<?=$HB_ID ?>')" title="Add New Payment"><img style="border:none; outline: 0;" width="24px" height="24px" src="<?php echo base_url(); ?>images/add.svg"></a>
									<?php } ?>
									<!-- Edit receipt -->
									<a style="border:none; outline: 0;" onClick="edit('<?=$HB_ID ?>')" title="Edit Hall Bookings" ><img style="border:none; outline: 0;" src="<?php echo	base_url(); ?>images/edit_icon.svg"></a>
									<!-- Delete receipt -->
									<a style="border:none; outline: 0;" title="Cancel Booking" onClick="delete_icon('<?=$HB_ID ?>')"><img style="border:none; outline: 0;" src="<?php echo	base_url(); ?>images/delete.svg"></a>
								</td>
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
</div>

<!-- Modal -->
<div class="modal fade" id="editBooking" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
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

<form id="operationForm" method="post"action="">
	<input type="hidden" id="HB_ID" name="HB_ID"/>
</form>

<form id="submitForm" action="<?php echo site_url(); ?>SevaBooking/edit_book_seva/" class="form-group" role="form" enctype="multipart/form-data" method="post">
	<input type="hidden" id="soId" name="soId" value="">
	<input type="hidden" id="editsevadate2" name="editsevadate2" value="">
</form>

<div class="modal declineModal fade" id="declineModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Cancellation Reason</h4>
                    </div>
                    <div class="modal-body">
						<input type="hidden" id="HB_IDModal" name="HB_IDModal">
                        <textarea id="cancelNotes" class="form-control"></textarea>
						<span style="font-size:14px;"><strong><i>Note: All the bookings slots with respect to this booking will also be cancelled.</i></strong></span>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">Close</button>
                    <button type="button" id="submitDel" class="btn">Submit</button>
                </div>
            </div>
        </div>
    </div> 

<script>
	var between = [];
	
	$('#submitDel').on("click", function() {
		let url = "<?=site_url() ?>Trust/DeleteBooking";
		let HB_ID = $("#HB_IDModal").val();
		let cancelNotes = $("#cancelNotes").val();

		if(!cancelNotes) {
			$("#cancelNotes").css({"border-color":"red"});
			return;
		} else {
			$("#cancelNotes").css({"border-color":"black"});
		}

		$('.declineModal').modal('toggle');

		$.post(url, {
			HB_ID,
			cancelNotes,
		},function(data) {
			if(!data)
				location.reload();
			console.log(data)
		})
	});

	function check_iconClick(HB_ID) {
		let url = "<?=site_url()?>Trust/check_is_done_hall_booking_list"
		$.post(url, {'HB_ID':HB_ID}, function(data) {
			if(data == "success") {
				let url = "<?=site_url() ?>Trust/ActivateBooking";
				deactivateBookingSecond("Information", "Are you sure you want to confirm <b>complete payment</b>?", url, HB_ID);
			} else {
				alert("Information","Please confirm the function status in Trust E.O.D./Deity E.O.D.");
			}
		});
	}

	function delete_icon(HB_ID) {
		$('.declineModal').modal();
		$("#HB_IDModal").val(HB_ID)
		$("#cancelNotes").val("");
		$("#cancelNotes").css({"border-color":"black"});
	}

	function edit(HB_ID) {
		$('#operationForm').attr("action","<?=site_url(); ?>/Trust/editBooking")
		$('#HB_ID').val(HB_ID);
		$("#operationForm").submit();
	}

	function add(HB_ID) {
		$('#operationForm').attr("action","<?=site_url(); ?>/Trust/addHeads")
		$('#HB_ID').val(HB_ID);
		$("#operationForm").submit();
	}

	function generateAllDates() {
		between = [];
		var sDate1 = "";
		var start = $("#fromDate").datepicker("getDate");
		end = $("#toDate").datepicker("getDate");
		console.log(start)
		currentDate = new Date(start),
		between = [];
		while (currentDate <= end) {
			console.log(currentDate);
			between.push(("0" + currentDate.getDate()).slice(-2) + "-" + ("0" + (currentDate.getMonth() + 1)).slice(-2) + "-" + currentDate.getFullYear());	
			
			currentDate.setDate(currentDate.getDate() + 1);
		}
		newDate = between.join("|")
		console.log(newDate)
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
	
	$('#editsevadate').val("");
	$('#editsevadate').css('border-color','black');
	$( ".editsevadate" ).datepicker({
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
		url = "<?php echo site_url(); ?>Trust/search_booking_receipt";
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
		url = "<?php echo site_url(); ?>Trust/search_booking_receipt";
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
		url = "<?php echo site_url(); ?>Trust/search_booking_receipt";
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
		url = "<?php echo site_url(); ?>SevaBooking/search_booking_receipt";
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
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50",
		dateFormat: 'dd-mm-yy'
    });
     
	$('.todayDate').on('click', function() {
		$( ".todayDate" ).focus();
	})
	
	$(".fromDate2").datepicker({
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50",
		dateFormat: 'dd-mm-yy'
	});
	
	$(".toDate2").datepicker({
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50",
		dateFormat: 'dd-mm-yy'
	});
	
	$( ".toDate" ).datepicker({ 
		
		dateFormat: 'dd-mm-yy'
    });
     
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
<?php 
	//$this->output->enable_profiler(TRUE);
	// error_reporting(0);

	//echo "<pre>"; 
	//print_r($hallBooking); 
	//echo "</pre>";
?>
