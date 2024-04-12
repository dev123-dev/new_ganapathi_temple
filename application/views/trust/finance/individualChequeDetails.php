<?php error_reporting(0); ?>
<div class="container">
<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />

<div class="row form-group">							
	<div class="col-lg-12 col-md-12 col-sm-8 col-xs-8" style = "padding-right:0px;padding-top:10px;">
			<h3 style="margin-top:0px">Cheque Details of <?php echo $CHEQUE_BOOK_NAME ?></h3>
	</div>
</div>

<div class="col-offset-lg-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-right text-right" style = "padding-right:0px;padding-bottom:0px; margin-top:-3em">
	<a  style="margin-left: 5px; "class="pull-right" style="border:none; outline:0;"  title="Back" href="<?=$_SESSION['actual_link'] ?>"><img style="border:none; outline: 0; width:24px; height:24px" src="<?php echo base_url();?>images/back_icon.svg"></a>
</div>

<div class="row form-group">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
				  <tr>
					<th width="10%"><center>Cheque No.</center></th>
					<th width="10%"><center>Status</center></th>
					<th width="10%"><center>Date</center></th>
					<th width="20%"><center>Favouring Name</center></th>
					<th width="15%"><center>Voucher No.</center></th>
					<th width="10%"><center>Cheque Date</center></th>
					<th width="10%"><center>Reconciled Date</center></th>
					<th width="10%"><center>Cancel/Activate</center></th>
					<th width="20%"><center>MultiPayment</center></th>
				  </tr>
				</thead>
				<tbody>
					<?php foreach($indChequeDetail as $result) { ?>
						<tr>
							<td><center><?php echo $result->T_CHEQUE_NO; ?></center></td>
							<?php if($result->T_FCD_STATUS == "Cancelled") { 
							$cancelNotes = str_replace("'","\'",$result->CHEQUE_CANCELLED_NOTES);?>
							<td><a class="log mymodelcancel" style="color:#800000;" onclick="show_cancelled('<?php echo $cancelNotes; ?>')"><?php echo $result->T_FCD_STATUS; ?></a></td>
							<?php } else { ?>
								<td><?php echo $result->T_FCD_STATUS; ?></td>
							<?php } ?>
							<td><center><?php echo $result->T_FLT_DATE; ?></center></td>
							<td><?php echo $result->T_FAVOURING_NAME; ?></td>
							<td><?php echo $result->T_VOUCHER_NO; ?></td>
							<td><center><?php echo $result->T_CHEQUE_DATE; ?></center></td>
							<td><center><?php echo $result->T_RECONCILED_DATE; ?></center></td>	
							<td>
								<?php if($result->T_FCD_STATUS == "Unreconciled" || $result->T_FCD_STATUS == "Available") { ?>
									<center><a  style="margin-left: 5px; " style="border:none; outline:0;"  title="Cancel Cheque" onClick="callCancelModal('<?=$result->T_FGLH_ID?>','<?=$result->T_CHEQUE_NO; ?>','<?=$result->T_FCD_STATUS; ?>','<?=$result->T_FCD_ID;?>','<?=$result->T_VOUCHER_NO;?>','<?=$result->T_FCBD_ID;?>');"><img style="border:none; outline: 0; width:24px; height:24px" src="<?php echo base_url();?>images/delete.svg"></a></center>
								<?php } ?>
								<?php if($result->T_FCD_STATUS == "Cancelled" && $result->FLT_DATE == "")  { ?>
									<center><a  style="margin-left: 5px; " style="border:none; outline:0;"  title="Activate Cheque" onClick="ActivateCancelledCheque('<?=$result->T_FCD_ID;?>','<?=$result->T_FCBD_ID;?>');"><img style="border:none; outline: 0; width:24px; height:24px" src="<?php echo base_url();?>images/check_icon.svg"></a></center>
								<?php } ?>
							</td>
							<td>
								<?php if($result->T_FCD_STATUS == "Available" || $result->T_FCD_STATUS == "Unreconciled"  ) { ?>
                    			<center><a  style="margin-left: 5px; " style="border:none; outline:0;"  title="MultiPayment" onClick="MultiPaymentCheque('<?=$result->T_CHEQUE_NO; ?>','<?=$result->T_FCD_STATUS; ?>','<?=$result->T_FCBD_ID;?>');"><img style="border:none; outline: 0; width:24px; height:24px" src="<?php echo base_url();?>images/duplicate.svg"></a> 
								<?php } ?>
								<?php if($result->T_FCD_STATUS == "Available" && $result->IS_MULTI_PAYMENT == 1) { ?>
                    			<a  style="margin-left: 5px; " style="border:none; outline:0;"  title="Delete MultiPayment Cheque" onClick="DeleteMultiPaymentCheque('<?=$result->T_FCD_ID;?>');"><img style="border:none; outline: 0; width:24px; height:24px" src="<?php echo base_url();?>images/trash.svg"></a> </center>
								<?php } ?>
							</td>

						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
	 <div class= "row">
		<ul class="pagination pagination-sm" style="margin-left:30px;margin-top: 0.2em;">
			<?=$pages; ?>
		</ul>
		<!--Total Bank TextField -->
		<?php if($indChequeCount != 0) { ?>
		<label class="pull-right"  style="font-size:18px;margin-right:30px;margin-top:0.1em;">Total Cheques: <strong style="font-size:18px"><?php echo $indChequeCount ?></strong></label>
		<?php } else { ?>
		<label> </label>
		<?php } ?>					
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="chequeCancellationModal" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 style="font-weight:600;" class="modal-title text-center">Cheque Cancellation</h4>
			</div>
			<div class="modal-body">
				<div style="clear:both;" class="form-group">
					<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<label for="inputLimit" ><span style="font-weight:600;">Cheque No.:</span></label><span id="cancellationChequeNo"></span>
					</div>
					
					<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<label for="seva"><span style="font-weight:600;">Cheque Status:</span></label><span id="cancellationStatus"></span>
					</div>
				</div>
				<div style="clear:both;" class="form-group">
					<div class="form-group col-lg-12 col-md-6 col-sm-6 col-xs-6">
						<label for="inputLimit" ><span style="font-weight:600;">Cancellation Notes:<span style="color:#800000;">*</span> </span> </label>
						<!-- <input name="cancelledNotes" id="cancelledNotes" type="text" value="" class="form-control" placeholder="Cancelled Notes" /> -->
						 <textarea class="form-control" rows="5" name="cancelledNotes" id="cancelledNotes" placeholder="Reason for Cheque Cancellation" style="width:100%;height:100%;resize:none;"></textarea>
					</div>
				</div>
				<!-- HIDDEN -->
				<div class="modal-footer">
					<button type="button" id="cancellationSubmit" class="btn btn-default">SAVE</button>
				</div>
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
				<h4 class="modal-title">Cancelled Notes</hactivateCancelledCheque4>
			</div>
			<div class="modal-body" id="cancelleddet" style="overflow-y: auto;max-height: 330px;color:#800000;">
			</div>
		</div>
	</div>
</div> 

  <form id="submitCancellationForm" action="<?php echo site_url(); ?>Trustfinance/cancelCheque" class="form-group" role="form" enctype="multipart/form-data" method="post">	
	<input type="hidden" id="chequeCancellationNotes" name="chequeCancellationNotes" value="">
	<input type="hidden" id="cancellationChequeNumber" name="cancellationChequeNumber" value="">
	<input type="hidden" id="cancellationChequeStatus" name="cancellationChequeStatus" value="">
	<input type="hidden" id="cancellationVoucherNo" name="cancellationVoucherNo" value="">
	<input type="hidden" id="cancellationFcdid" name="cancellationFcdid" value="">
	<input type="hidden" id="cancellationFcbdid" name="cancellationFcbdid" value="">
	<input type="hidden" id="cancellationFglhId" name="cancellationFglhId" value="<?php echo $indChequeDetail[0]->FGLH_ID ?>">
	<input type="hidden" id="cancellationRedirectPath" name="cancellationRedirectPath" value="IndividualChequeDetails">
  </form>

  <form id="activateCancelledChequeForm" action="" method="post">
	<input type="hidden" id="fcdid" name="fcdid" />
	<input type="hidden" id="fcbdid" name="fcbdid" />
  </form>
	

  <form id="submitMultiPaymentForm" action="<?php echo site_url(); ?>Trustfinance/multipaymentCheque" class="form-group" role="form" enctype="multipart/form-data" method="post">	
		<input type="hidden" id="fcbid" name="fcbid" value="">
		<input type="hidden" id="chequestatus" name="chequestatus" value="">
		<input type="hidden" id="chequeno" name="chequeno" value="">
  </form>

  <form id="deletesubmitMultiPaymentForm" action="<?php echo site_url(); ?>Trustfinance/deletemultipaymentCheque" class="form-group" role="form" enctype="multipart/form-data" method="post">	
		<input type="hidden" id="fcdidno" name="fcdidno" value="">
  </form>

<!-- Modal -->
<div class="modal fade" id="chequeMultiPaymentModal" role="dialog">
	<div class="modal-dialog modal-md">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" style="margin-top: -15px;" class="close" data-dismiss="modal">&times;</button>
				<h4 style="font-weight:600;" class="modal-title text-center">Cheque For Multiple Payment</h4>
			</div>
			<div class="modal-body">
			<label>Are you sure you want to activate this cheque for Multi Payment..?</label>
			</div>
			<div class="modal-footer text-right" style="text-align:right;">
		          
		         <button type="button" style="width: 8%;" class="btn " id="ReplaceSubmitConfirm">Yes</button>
		         <button type="button" style="width: 8%;" class="btn " data-dismiss="modal">No</button>
      	    </div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="deletechequeMultiPaymentModal" role="dialog">
	<div class="modal-dialog modal-md">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" style="margin-top: -15px;" class="close" data-dismiss="modal">&times;</button>
				<h4 style="font-weight:600;" class="modal-title text-center">Cheque For Multiple Payment</h4>
			</div>
			<div class="modal-body">
			<label>Are you sure you want to delete this cheque..?</label>
			</div>
			<div class="modal-footer text-right" style="text-align:right;">
		         <button type="button" style="width: 8%;" class="btn " id="DeleteSubmitConfirm">Yes</button>
		         <button type="button" style="width: 8%;" class="btn " data-dismiss="modal">No</button>
      	    </div>		
		</div>
	</div>
</div>
</div>
<script type="text/javascript">
	function goback(){
       window.history.back();
    }

    function callCancelModal(T_FGLH_ID,CHEQUE_NO,FCD_STATUS,FCD_ID,VOUCHER_NO,FCBD_ID) {
        console.log(T_FGLH_ID);
		$('#cancellationChequeNo').html(" "+CHEQUE_NO);
		$('#cancellationStatus').html(" "+FCD_STATUS);		
		$('#cancellationChequeNumber').val(CHEQUE_NO);
		$('#cancellationChequeStatus').val(FCD_STATUS);
		$('#cancellationVoucherNo').val(VOUCHER_NO);
		$('#cancellationFcdid').val(FCD_ID);
		$('#cancellationFcbdid').val(FCBD_ID);
        $('#cancellationFglhId').val(T_FGLH_ID);
		$('#chequeCancellationModal').modal();
	}

	$('#cancellationSubmit').on('click', function() {
		if($('#cancelledNotes').val() != "") {
			let cancellationNotes = $('#cancelledNotes').val();
			$('#chequeCancellationNotes').val(cancellationNotes);
			$('#submitCancellationForm').submit();
		} else { 
			$('#cancelledNotes').css('border-color','red');
			$('#chequeCancellation').effect( "shake" );
		}
	});

	function show_cancelled(cancelNotes) {
		$('#cancelleddet').html(cancelNotes);
		$('#myModalCancelled').modal('show');  
	}

	function ActivateCancelledCheque(FCD_ID,FCBD_ID){
		$('#fcdid').val(FCD_ID);
		$('#fcbdid').val(FCBD_ID);
		$('#activateCancelledChequeForm').attr('action','<?=site_url()?>Trustfinance/activateCancelledCheque');
		$('#activateCancelledChequeForm').submit();
	}
	function MultiPaymentCheque(CHEQUE_NO,FCD_STATUS,FCBD_ID){
		$('#chequeno').val(CHEQUE_NO);
		$('#chequestatus').val(FCD_STATUS);
		$('#fcbid').val(FCBD_ID);
		$('#chequeMultiPaymentModal').modal();
	}

	$('#ReplaceSubmitConfirm').on('click', function() {
	
		$('#fcbid').val($('#fcbid').val());
		$('#chequestatus').val($('#chequestatus').val());
		$('#chequeno').val($('#chequeno').val());

	$('#submitMultiPaymentForm').submit();
	
	});

	function DeleteMultiPaymentCheque(FCD_ID){
		$('#fcdidno').val(FCD_ID);
		$('#deletechequeMultiPaymentModal').modal();

	}

	$('#DeleteSubmitConfirm').on('click', function() {

		$('#fcdidno').val($('#fcdidno').val());
		$('#deletesubmitMultiPaymentForm').submit();

	});
	
</script>
