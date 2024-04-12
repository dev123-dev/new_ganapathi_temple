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
			<span class="eventsFont2">Booked Pending Receipts</span>
		</div>
	</div>
	<div class="row form-group">
		<form id="tddate" enctype="multipart/form-data" method="post" accept-charset="utf-8">
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
		</form>
		<form id="report" enctype="multipart/form-data" method="post" accept-charset="utf-8">
			<div class="col-offset-lg-4 col-lg-4 col-md-4 col-sm-4 col-xs-12 pull-right text-right">
				<a onclick="GetSendField()" style="cursor:pointer;"><img style="width:24px; height:24px" title="Download Excel Report" src="<?=site_url();?>images/excel_icon.svg"/></a>&nbsp;&nbsp;
				<a onclick="generatePDF()"><img style="width:24px; height:24px" title="Download PDF Report" src="<?=site_url();?>images/pdf_icon.svg"/></a>&nbsp;&nbsp;
				<a style="text-decoration:none;cursor:pointer;pull-right;" href="<?=site_url()?>SevaBooking/BookedPendingReceipt" title="Refresh"><img style="width:24px; height:24px" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
			</div>
			<!--HIDDEN FIELDS -->
			<input type="hidden" name="namephone" id="namephone">
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
							<th style="width:10%;">Booking Date</th>
							<th style="width:15%;"><center>Operation</center></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($PendingReceipt as $result) { ?>
							<tr class="row1">
								<td><?php echo $result->SO_DATE;  ?></td>
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
										<?php if($result->SO_DATE > date("d-m-Y")) { ?>
											<a style="border:none; outline: 0;" onClick="callModal('<?php echo $result->SB_NO; ?>','<?php echo str_replace('"','&#34;',str_replace("'","\'",$result->SB_NAME)); ?>','<?php echo $result->SB_PHONE; ?>','<?php echo str_replace("'","\'",$result->SB_ADDRESS); ?>','<?php echo $result->SO_DEITY_NAME; ?>','<?php echo $result->SO_SEVA_NAME; ?>','<?php echo $result->SO_DATE; ?>','<?php echo $result->SO_ID; ?>')" title="Edit Seva Date" ><img style="border:none; outline: 0;" src="<?php echo	base_url(); ?>images/edit_icon.svg"></a>
										<?php } ?>
										<a style="border:none; outline: 0;" title="Cancellation" onclick="show_cancelled('<?php echo $result->SB_ID; ?>','<?php echo $result->SB_NO; ?>')"><img style="border:none; outline: 0;" src="<?php echo	base_url(); ?>images/delete.svg"></a>
									<?php } ?>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
				
				<!--Total Booking TextField -->
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label class="pull-right" for="totalBooking" style="font-size:18px;margin-top: -0.2px;">Total Booked Pending: <span id="totalSeva" style="font-size:18px"><?php echo $Count; ?></span></label>  
				</div>
				<ul class="pagination pagination-sm" style="margin-top: -30px;">
					<?=$pages; ?>
				</ul>
			</div>
		</div>
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
	//SEARCH NAME AND PHONE
	function get_search() {
		url = "<?php echo site_url(); ?>SevaBooking/BookedPendingOnSearch";
		$("#tddate").attr("action",url);
		$("#tddate").submit();
	}
	
	//GET SEND POST FIELDS EXCELS
	function GetSendField() {
		document.getElementById('namephone').value = $('#name_phone').val();
		url = "<?php echo site_url(); ?>SevaBooking/create_pendingBooking_Excel";
		$("#report").attr("action",url)
		$("#report").submit();
	}
	
	//FOR PDF
	function generatePDF() {
		document.getElementById('namephone').value = $('#name_phone').val();
		url = "<?php echo site_url(); ?>generatePDF/create_pendingBookingPDF";
		$("#report").attr("action",url)
		$("#report").submit();
	}
</script>