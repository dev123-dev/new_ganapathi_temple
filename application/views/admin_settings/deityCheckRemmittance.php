<style>
    .datepicker {
      z-index: 1600 !important; /* has to be larger than 1050 */
    } .chequedate {
      z-index: 1600 !important; /* has to be larger than 1050 */
    }
    .chequedatereplace {
      z-index: 1600 !important; /* has to be larger than 1050 */
    }
</style>
<section id="section-register" class="bg_register">
    <div class="container-fluid sub_reg" style="min-height:100%;">  	
		<!-- START Content -->
		<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
		<div class="container reg_top adminside">
			<!-- START Row -->
			<div class="row-fluid">
				<!-- START Datatable 2 -->
				<div class="span12 widget lime">
					<section class="body">
						<div class="row form-group"> 
							<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 no-pad">
								<h3 style="font-weight:600">Deity Cheque Reconciliation</h3>
							</div>
						</div>
						<form action="<?php echo site_url(); ?>admin_settings/Admin_setting/SearchdeityChequeRemmittance" id="chequeNumberSubmit" enctype="multipart/form-data" 	 method="post" accept-charset="utf-8">
							<div class="row form-group" style="margin-top:-0.8em;"> 
								<div class="col-lg-2 col-md-3 col-sm-4 col-xs-9">
									<div class="input-group input-group-sm">
										<input autocomplete="off" type="text" id="chequeNumber" name="chequenumber" value="<?=@$cheque_Number?>" class="form-control" placeholder="Cheque Number">
										<div class="input-group-btn">
										  <button class="btn btn-default name_phone" name="button" value="cn" type="submit">
											<i class="glyphicon glyphicon-search"></i>
										  </button>
										</div>
									</div>
								</div>
								<div class="col-lg-2 col-md-3 col-sm-4 col-xs-9">
									<select id="voucherType" name="voucherType" class="form-control"  onChange="this.form.submit();"autofocus>
										<?php if($voucherType == ""){ ?>
									  		<option value="" selected>All</option>
									  	<?php } else {?>
									  		<option value="">All</option>
									  	<?php } ?>
									  	<?php if($voucherType == "R2"){ ?>
							           		<option value="R2" selected> Receipt </option>
							           	<?php } else {?>
									  		<option value="R2"> Receipt </option>
									  	<?php } ?>
							            <?php if($voucherType == "P2"){ ?>
							            	<option value="P2" selected> Payment </option>
							            <?php } else {?>
									  		<option value="P2"> Payment </option>
									  	<?php } ?>
							            <?php if($voucherType == "C1"){ ?>
							            	<option value="C1" selected> Contra </option>
							            <?php } else {?>
									  		<option value="C1"> Contra </option>
									  	<?php } ?>
         							</select>
								</div>
								<div class="pull-right" style="padding-right:15px">
								<a style="text-decoration:none;cursor:pointer;pull-right;" href="<?=site_url()?>admin_settings/Admin_setting/deityChequeRemmittance" title="Refresh"><img style="width:24px;height:24px;margin-top:10px;" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
								</div>
							</div>
						</form>
						<div class="body-inner no-padding table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th style="width:18%;"><strong>Voucher No.</strong></th>
										<th style="width:10%;"><strong>Deposit/Payment Date</strong></th>
										<th style="width:12%;"><strong>Voucher Type</strong></th>
										<th style="width:20%;"><strong>Receipt/Favouring Name</strong></th>
										<th style="width:5%;"><strong>Amount</strong></th>
										<th style="width:12%;"><strong>Cheque No.</strong></th>
										<th style="width:11%;"><strong>Cheque Date</strong></th>
										<th style="width:12%;"><strong>Bank</strong></th>
										<th style="width:12%;"><strong>Branch</strong></th>
										<th style="width:10%;"><strong>Status</strong></th>
										<?php if(isset($_SESSION['Authorise'])) { ?>
											<th style="width:2%;"><strong>Operations</strong></th>
										<?php } ?>
									</tr>
								</thead>
								<tbody>

									<?php foreach($deityCheckRemmittance as $result) { ?>										
										<tr class="row1">
											<td><?php echo $result->VOUCHER_NO;?></td>
											<td><?php echo $result->FLT_DEPOSIT_PAYMENT_DATE;?></td>
											<td><?php echo $result->VOUCHER_TYPE; ?></td>
											<?php $receiptId = $result->RECEIPT_ID; ?>
											<?php $voucherNo = $result->VOUCHER_NO; ?>
											<?php $voucherType = $result->VOUCHER_TYPE; ?>
											<?php $name = str_replace("'","\'",$result->RECEIPT_FAVOURING_NAME); ?>
											<?php $amt = $result->AMT; ?>
											<?php $chequeNo = $result->CHEQUE_NO; ?>
											<?php $chequeDate = $result->CHEQUE_DATE; ?>
											<?php $bank = str_replace("'","\'",$result->BANK_NAME); ?>
											<?php $branch = str_replace("'","\'",$result->BRANCH_NAME); ?>
											<?php $DEPOSITED_BANK = $result->DEPOSITED_BANK; ?>
											
											<td><?php echo $result->RECEIPT_FAVOURING_NAME; ?></td>
											<td><?php echo $result->AMT; ?></td>
											<td><?php echo $result->CHEQUE_NO; ?></td>
											<td><?php echo $result->CHEQUE_DATE; ?></td>
											<td><?php echo $result->BANK_NAME; ?></td>
											<td><?php echo $result->BRANCH_NAME; ?></td>
											<td><?php echo $result->PAYMENT_STATUS; ?></td>
											<?php if(isset($_SESSION['Authorise'])) { ?>
												<td class="text-center" width="30%">

													<?php if($result->PAYMENT_STATUS == "Pending") { ?>
														<a style="border:none; outline: 0;" onClick="callModal('<?=$name; ?>','<?=$amt; ?>','<?=$chequeNo; ?>','<?=$chequeDate; ?>','<?php echo str_replace("'","\'",$result->BANK_NAME);?>','<?php echo str_replace("'","\'",$result->BRANCH_NAME);?>','<?=$receiptId; ?>','<?=$voucherNo; ?>','<?=$voucherType; ?>','<?php echo str_replace("'","\'",$result->DEPOSITED_BANK);?>');" title="Approve Cheque" ><img style="border:none; outline: 0;" width="24px" height="24px" src="<?php echo	base_url(); ?>images/check_icon.svg"></a>

													<?php } ?>
													<?php if($result->VOUCHER_TYPE != "Receipt") { ?>
														<a  style="margin-left: 5px; " style="border:none; outline:0;"  title="Cancel Cheque" onClick="callCancelModal('<?=$result->CHEQUE_NO; ?>','<?=$result->VOUCHER_NO;?>');"><img style="border:none; outline: 0; width:24px; height:24px" src="<?php echo base_url();?>images/trash.svg"></a>
													<?php } ?>
													<?php if($result->VOUCHER_TYPE == "Receipt") { ?>
													<a  style="margin-left: 5px; " style="border:none; outline:0;"  title="Replace Cheque" onClick="callReplaceModal('<?=$chequeNo; ?>','<?=$chequeDate; ?>','<?php echo str_replace("'","\'",$result->BANK_NAME);?>','<?php echo str_replace("'","\'",$result->BRANCH_NAME);?>','<?=$receiptId; ?>','<?=$voucherNo; ?>','<?php echo str_replace("'","\'",$result->DEPOSITED_BANK);?>');"><img style="border:none; outline: 0; width:24px; height:24px" src="<?php echo base_url();?>images/replace.svg"></a>
													<?php } ?>
												</td>

											<?php } ?>
										</tr>
									<?php } ?>
								</tbody>
							</table>
							<div class="row-fluid">
								<ul class="pagination pagination-sm">
								<?=$pages; ?>
								</ul>
								<div class="pull-right" style="padding-right:15px">
								<h4 style="margin:20px 0;"><?php echo "Total : ".$total_count; ?> </h4>
								</div>

							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Modal -->
<div class="modal fade" id="chequeRemmittance" role="dialog" style=" font-size:large; font-weight:600;">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 style="font-weight:600;" class="modal-title text-center">Deity Cheque Reconciliation</h4>
			</div>
			<div class="modal-body">
				<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<label for="inputLimit" ><span style="font-weight:600;">Payment Method : </span></label> <span id="vochrType"></span>
					</div>
				<div style="clear:both;" class="form-group">
					<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<label for="inputLimit" ><span style="font-weight:600;">Name: </span></label><span id="name"></span>
					</div>
					
					<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<label for="inputLimit" ><span style="font-weight:600;">Amount: </span></label><span id="amt"></span>
					</div>
				</div>
				<div style="clear:both;" class="form-group">
					<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<label for="inputLimit" ><span style="font-weight:600;">Cheque No.:</span></label><span id="chequeNo"></span>
					</div>
					
					<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<label for="seva"><span style="font-weight:600;">Cheque Date:</span></label><span id="chequeDated"></span>
					</div>
				</div>
				
				<div style="clear:both;" class="form-group">
					<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<label for="inputLimit" ><span style="font-weight:600;">Bank: </span> </label><span id="bank"></span>
					</div>
					
					<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<label for="inputLimit" ><span style="font-weight:600;">Branch: </span> </label><span id="branch"></span>
					</div>
				</div>
				<div style="clear:both;" class="form-group">
					<div class="form-group col-lg-12 col-md-6 col-sm-6 col-xs-6">
						<label for="inputLimit" ><span style="font-weight:600;">Deposited Bank: </span> </label><span id="depositedBank"></span>
					</div>
				</div>
				<div style="clear:both;" class="form-group">
					<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<label for="seva"><span style="font-weight:600;">Cheque Credited Date </span><span style="color:#800000;">*</span></label>
						<div class="input-group input-group-sm">
							<input name="chequedate" id="chequedate" type="text" value="" class="form-control chequedate" placeholder="dd-mm-yyyy" />
							<div class="input-group-btn">
							  <button class="btn btn-default todayDate" type="button">
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

<!-- Modal -->
<div class="modal fade" id="chequeReplaceModal" role="dialog">
	<div class="modal-dialog modal-md">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 style="font-weight:600;" class="modal-title text-center">Cheque Replace</h4>
			</div>
			<div class="modal-body">
				<div style="clear:both;" class="form-group">
					<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<label for="inputLimit" >Cheque No : <span style="color:#800000;">*</span></label>
						<input type="text" maxlength="6" class="form-control form_contct2" id="chequeNoreplace" onkeyup="alphaonlynumber(this)" placeholder="" name="chequeNoreplace">
					</div>
					
					<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<label >Cheque Date : <span style="color:#800000;">*</span> </label>
					</div>
					<div class="form-group col-lg-4 input-group " style="padding-left: 15px;">
							<input name="chequedatereplace" id="chequedatereplace" type="text"  value="" class="form-control chequedatereplace" placeholder="dd-mm-yyyy" />
							<div class="input-group-btn">
							  <button class="btn btn-default chequedatereplace2" type="button">
								<i class="glyphicon glyphicon-calendar"></i>
							  </button>
							</div>
					</div>
				</div>
				<div style="clear:both;" class="form-group">
					<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<label>Bank Name : <span style="color:#800000;">*</span> </label>
						  <input type="text" class="form-control form_contct2" id="bankreplace"  onkeyup="alphaonly(this)" placeholder="" name="bankreplace">
					</div>
					<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<label>Branch Name : <span style="color:#800000;">*</span> </label>
						  <input type="text" class="form-control form_contct2" id="branchreplace"  onkeyup="alphaonly(this)" placeholder="" name="branchreplace">
					</div>

				</div>

				<div style="clear:both;" class="form-group">
					<div class="form-group col-lg-12 col-md-6 col-sm-6 col-xs-6">
						<label><span style="font-weight:600;">Reason for Replace : <span style="color:#800000;">*</span> 
						
					</div>
					<div class="form-group col-lg-12 col-md-6 col-sm-6 col-xs-6">
						 <textarea class="form-control" rows="5" name="receiptChequeCancelledNotes" id="receiptChequeCancelledNotes" placeholder="Reason for Cheque Replace" style="width:100%;height:100%;resize:none;"></textarea>
	   					 <input type="hidden" id="replaceChequeDefaultNotes" name="replaceChequeDefaultNotes" value=""/>  	
					</div>
					
				</div>
				
				
			</div>
				<!-- HIDDEN -->
				<div class="modal-footer">
					<button type="button" id="ReplaceSubmit" class="btn btn-default">SAVE</button>
				</div>
					<!-- HIDDEN -->
				<div id="confirm" class="modal-footer text-left" style="text-align:left;clear: both;display:none;">
					<label>Are you sure you want to save..?</label>
					<br/>
					<button style="width: 8%;" type="button" class="btn btn-default sevaButton" id="ReplaceSubmitConfirm">Yes</button>
					<button style="width: 8%;" type="button" class="btn btn-default sevaButton" data-dismiss="modal">No</button>
				</div>
			</div>
		</div>
	</div>
</div>
<form id="submitForm" action="<?php echo site_url(); ?>admin_settings/Admin_setting/edit_deityChequeRemmittance/" id="chequeRemmittanceForm" class="form-group" role="form" enctype="multipart/form-data" method="post">
	<input type="hidden" id="receiptId" name="receiptId" value="">
	<input type="hidden" id="chequedate2" name="chequedate" value="">
	<input type="hidden" id="voucherNo" name="voucherNo" value="">
	<input type="hidden" id="voucherType" name="voucherType" value="">
</form>

<form id="submitCancellationForm" action="<?php echo site_url(); ?>finance/cancelCheque" class="form-group" role="form" enctype="multipart/form-data" method="post">	
	<input type="hidden" id="chequeCancellationNotes" name="chequeCancellationNotes" value="">
	<input type="hidden" id="cancellationChequeNumber" name="cancellationChequeNumber" value="">
	<input type="hidden" id="cancellationChequeStatus" name="cancellationChequeStatus" value="">
	<input type="hidden" id="cancellationVoucherNo" name="cancellationVoucherNo" value="">
	<input type="hidden" id="cancellationRedirectPath" name="cancellationRedirectPath" value="deityChequeRemmittance">

</form>

  <form id="submitReplaceForm" action="<?php echo site_url(); ?>finance/replaceChequeDetails" class="form-group" role="form" enctype="multipart/form-data" method="post">	
	<input type="hidden" id="replaceReceiptChequeCancelledNotes" name="replaceReceiptChequeCancelledNotes" value="">
	<input type="hidden" id="replaceChequeNo" name="replaceChequeNo" value="">
	<input type="hidden" id="replaceChequedate" name="replaceChequedate" value="">
	<input type="hidden" id="replaceBank" name="replaceBank" value="">
	<input type="hidden" id="replaceBranch" name="replaceBranch" value="">
	<input type="hidden" id="replaceVoucherNo" name="replaceVoucherNo" value="">
	<input type="hidden" id="replaceReceiptId" name="replaceReceiptId" value="">
  </form>


<script>
	$('#chequedate').val("");
	$('#chequedate').css('border-color','black');
	$( ".chequedate" ).datepicker({
		dateFormat: 'dd-mm-yy',
		onSelect: function (selectedDate) {
			$('#chequedate2').val(selectedDate);
			$('#chequedate').css('border-color','black');

		} 
	});
	
	$('.todayDate').on('click',function() {
		$( ".chequedate" ).focus();
	});
	

	$( ".chequedatereplace" ).datepicker({
		dateFormat: 'dd-mm-yy',
		onSelect: function (selectedDate) {
			$('#chequedate2').val(selectedDate);
			$('#chequedatereplace').css('border-color','black');

		} 
	});
	
	$('.chequedatereplace2').on('click',function() {
		$( ".chequedatereplace" ).focus();
	});

	function callModal(name, amt, chequeNo, chequeDated, bank, branch, receiptId,voucherNo,voucherType,depositedBank) {
		$('#chequedate').css('border-color','black');
		$('#chequedate').val("");
		$('#name').html(" "+name);
		$('#amt').html(" "+amt+"/-");
		$('#chequeNo').html(" "+chequeNo);
		$('#chequeDated').html(" "+chequeDated);
		$('#bank').html(" "+bank);
		$('#branch').html(" "+branch);
		$('#depositedBank').html(" "+depositedBank);
		$('#receiptId').val(receiptId);
		$('#voucherNo').val(voucherNo);
		$('#voucherType').val(voucherType);
		let vochrType = voucherType;
		$('#vochrType').html(vochrType);
		$('#chequeRemmittance').modal();
	}
	

	$('#submit').on('click', function() {
		if($('#chequedate').val() != "") {
			$('#submitForm').submit();
		} else { 
			$('#chequedate').css('border-color','red');
			$('#chequeRemmittance').effect( "shake" );
		}
	});

 function alphaonlynumber(input) {
      var regex=/[^0-9]/gi;
      input.value=input.value.replace(regex,"");
    }
 function alphaonly(input) {
      var regex=/[^a-z']/gi;
      input.value=input.value.replace(regex,"");

    }
 //INPUT KEYPRESS
    $(':input').on('keypress change', function() {
        var id = this.id;
        try {$('#' + id).css('border-color', "#000000");}catch(e) {}
        $('#confirm').hide();
        $('#ReplaceSubmit').show();
        
    });
	function callCancelModal(CHEQUE_NO,VOUCHER_NO) {
		$('#cancellationChequeNo').html(" "+CHEQUE_NO);
		$('#cancellationStatus').html("Unreconciled");		
		$('#cancellationChequeNumber').val(CHEQUE_NO);
		$('#cancellationChequeStatus').val("Unreconciled");
		$('#cancellationVoucherNo').val(VOUCHER_NO);
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


	 function callReplaceModal(chequeNo, chequeDate, bank, branch, receiptId,voucherNo,depositedBank) {

		$('#replaceChequeDefaultNotes').val("Cheque Number "+chequeNo+" from "+bank+", "+branch+" received on "+chequeDate+" deposited to "+depositedBank+" got cancelled.");
		$('#replaceVoucherNo').val(voucherNo);
		$('#replaceReceiptId').val(receiptId);
		$('#chequeReplaceModal').modal();
	}

	$('#ReplaceSubmit').on('click', function() {
		
		let count = 0;
		if(count != 0) {
				$('#chequeRemmittance').effect( "shake" );
				return;
			} else {
				$('#confirm').show(); 
				$('#ReplaceSubmit').hide();
			}
		if($('#chequedatereplace').val() == "") {
			$('#chequedatereplace').css('border-color','red');
		}else{
			$('#replaceChequedate').val($('#chequedatereplace').val());

		}

		if($('#chequeNoreplace').val() == "") {
			$('#chequeNoreplace').css('border-color','red');
		} else{
				$('#replaceChequeNo').val($('#chequeNoreplace').val());
		}
		if($('#bankreplace').val() == "") {
			$('#bankreplace').css('border-color','red');
		} else{
			$('#replaceBank').val($('#bankreplace').val());
		}
		if($('#branchreplace').val() == "") {
			$('#branchreplace').css('border-color','red');
			$('#chequeReplaceModal').effect( "shake" );
		}  else{
			$('#replaceBranch').val($('#branchreplace').val());
		}
		if($('#receiptChequeCancelledNotes').val() == "") {
			$('#receiptChequeCancelledNotes').css('border-color','red');
		}  else{
			$('#replaceReceiptChequeCancelledNotes').val($('#receiptChequeCancelledNotes').val());
		}
		
});

$('#ReplaceSubmitConfirm').on('click', function() {
	
	$('#replaceReceiptChequeCancelledNotes').val($('#replaceChequeDefaultNotes').val()+" "+$('#receiptChequeCancelledNotes').val());
	$('#submitReplaceForm').submit();
});

	


	
</script>
