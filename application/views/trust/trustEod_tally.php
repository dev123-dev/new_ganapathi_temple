<?php error_reporting(0); 
	//$this->output->enable_profiler(true);
?><!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?=site_url();?>css/sumoselect.min.css" />
<!-- Latest compiled and minified JavaScript -->
<script src="<?=site_url(); ?>js/jquery.sumoselect.min.js"></script>
<style>
    .datepicker {
      z-index: 1600 !important; /* has to be larger than 1050 */
    } .depositdate {
      z-index: 1600 !important; /* has to be larger than 1050 */
    }
	
	.CaptionCont {
		padding:6px !important;
		border-color:black !important;
		border-radius:4px !important;
	}
	
	.error {
		border-color:red !important;
	}
	
	.SumoSelect{position: absolute;top: -7px;left: 68px;width:176%}
</style>
<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<!--Heading And Refresh Button-->
	<div class="row form-group">
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<span class="eventsFont2">Trust E.O.D.  Tally</span>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-right">
			<form id="report" enctype="multipart/form-data" method="post" accept-charset="utf-8">
				<a style="text-decoration:none;cursor:pointer;" href="<?=site_url()?>TrustEOD_Tally" title="Refresh"><img style="width:24px; height:24px" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
			</form>
			
		</div>
	</div>
</div>
	<!-- <?php print_r($eod_tally) ?> -->
<!--Datagrid-->
<div class="container">
	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
					  <tr>
						<th>Receipt Date</th>
						<th>Receipt Name</th>
						<th>Receipt Category</th>
						<th>Cheque No</th>
						<th>Bank</th>
						<th>Cheque Amount</th>
						<th>Event Eod Conf Date</th>
						<?php if(@$_SESSION['userGroup'] == "1" || @$_SESSION['userGroup'] == "6" || @$_SESSION['userGroup'] == "2" ){ ?><th>Operation</th><?php } ?>
					  </tr>
					</thead>
					<tbody>
						<?php foreach($eod_tally as $result) { ?>
							<tr class="row1">

								<td><?php echo date('d-m-Y',strtotime($result->TUC_EOD_DATE)); ?></td>
								<td><?php if($result->RECEIPT_NAME != NULL) echo $result->RECEIPT_NAME; else echo "-"; ?></td>
								<td><?php if($result->FH_NAME != NULL) echo $result->FH_NAME; else echo "-"; ?></td>
								<td><?php if($result->TUC_CHEQUE_NO != NULL) echo $result->TUC_CHEQUE_NO; else echo "-"; ?></td>							
								<td><?php if($result->TUC_BANK_NAME != NULL) echo $result->TUC_BANK_NAME .", ". $result->TUC_BRANCH_NAME; else echo "-"; ?></td>
								<td><?php if($result->TUC_CHEQUE != Null) echo $result->TUC_CHEQUE; else echo $result->TUC_CHEQUE_DEPOSIT; ?></td>
								<td><?php echo date('d-m-Y',strtotime($result->TUC_DATE)); ?></td>

								<?php if(@$_SESSION['userGroup'] == "1" || @$_SESSION['userGroup'] == "6" || @$_SESSION['userGroup'] == "2" ){ ?><td style="text-align:center;">
									<a style="margin-left:9px;" onclick="editEOD('<?=$result->FH_NAME; ?>','<?=$result->TUC_CHEQUE_NO; ?>','<?=$result->TUC_CHEQUE_DATE; ?>','<?php echo str_replace("'","\'",$result->TUC_BANK_NAME);?>','<?php echo str_replace("'","\'",$result->TUC_BRANCH_NAME);?>','<?=$result->TUC_CHEQUE; ?>','<?=$result->TUC_ID; ?>','<?=$result->TUC_EOD_DATE; ?>','<?=$result->TR_ID; ?>')" title="Bank Deposit"><img style="margin-right:4px;width:24px; height:24px" src="<?=site_url();?>images/edit_icon.svg"/></a>
								</td><?php } ?>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="row">
					<ul class="pagination pagination-sm" style="margin-left:15px;margin-top: -1em;">
						<?=$pages; ?>
					</ul>
					<?php if($total_rows != 0) { ?>
						<label  class="pull-right" style="font-size:18px;margin-right:15px;margin-top: -1em;">Pending Cheques: <strong><?php echo $total_rows ?></strong></label>
					<?php } else { ?>
						<label> </label>
					<?php } ?>
				</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="chequeRemmittance" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close topClosePos" data-dismiss="modal">&times;</button>
				<h4 style="font-weight:600;" class="modal-title text-center">Bank Deposit</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
									
					<div style="margin-bottom: 10px;" class="form-inline col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<label for="seva"><span style="font-weight:600;">Deposit Date </span></label>
						<div class="input-group input-group-sm">
							<input name="depositdate" id="depositdate" type="text" value="" class="form-control depositdate" placeholder="dd-mm-yyyy" />
							<div class="input-group-btn">
							  <button class="btn btn-default todayDate" type="button">
								<i class="glyphicon glyphicon-calendar"></i>
							  </button>
							</div>
						</div>
					</div>
					
					<div style="clear:both;" class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-inline">
							
							<label for="bank">To Bank <span style="color:#800000;">*</span></label>&nbsp;&nbsp;
							<select id="addBank" name="addBank" class="form-control">
								<option value="0">Select Bank</option>
								<?php foreach($bank as $result) { ?>
									<option value="<?=$result->T_FGLH_ID; ?>">
										<?=$result->T_FGLH_NAME; ?>
									</option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				
				<div style="clear:both;" id="chequeDiv" class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6" style="margin-top: .4em;">
					<div class="form-inline">
						<label for="inputLimit" ><span style="font-weight:700;">Receipt Category: <span id="receiptCategory"></span></span></label>
					</div>
					<div class="form-inline">
						<label for="inputLimit" ><span style="font-weight:700;">Cheque NO: <span id="ChequeNum"></span></span></label>
					</div>
					<div class="form-inline">
						<label for="inputLimit" ><span style="font-weight:700;">Cheque Date: <span id="Chequedate"></span></span></label>
					</div>
					<div class="form-inline">
						<label for="inputLimit" ><span style="font-weight:700;">Bank Name: <span id="BankName"></span></span></label>
					</div>
					<div class="form-inline">
						<label for="inputLimit" ><span style="font-weight:700;">Branch: <span id="BranchName"></span></span></label>
					</div>
					<div class="form-inline">
						<label for="inputLimit" ><span style="font-weight:700;">Amount: <span id="chequeAmount"></span></span></label>
					</div>
				</div>
				
				<div id="errMsg" class="form-group col-lg-9 col-md-9 col-sm-9 col-xs-9" style="margin-top:.4em;display:none;color:red;">
				</div>
				<!-- HIDDEN -->
				<div id="confirm" class="modal-footer text-left" style="text-align:left;clear: both;display:none;">
					<label>Are you sure you want to save..?</label>
					<br/>
					<button style="width: 8%;" type="button" class="btn btn-default sevaButton" id="submit">Yes</button>
					<button style="width: 8%;" type="button" class="btn btn-default sevaButton" data-dismiss="modal">No</button>
				</div>
				<div id="save" class="modal-footer" style="clear: both;">
					<button type="button" id="saveSubmit" class="btn btn-default">SAVE</button>
				</div>
			</div>
		</div>
	</div>
</div>

<form id="submitForm" action="<?php echo site_url(); ?>TrustEOD_Tally/eodTallySave" class="form-group" role="form" enctype="multipart/form-data" method="post">
	<input type="hidden" id="cheque1" name="cheque" value="">
	<input type="hidden" id="total1" name="total" value="">
	<input type="hidden" id="bank1" name="bank" value="">
	<input type="hidden" id="EUC_CHEQUE_NO" name="TUC_CHEQUE_NO">
	<input type="hidden" id="EUC_CHEQUE_DATE" name="TUC_CHEQUE_DATE">
	<input type="hidden" id="EUC_BANK_NAME" name="TUC_BANK_NAME">
	<input type="hidden" id="EUC_BRANCH_NAME" name="TUC_BRANCH_NAME">
	<input type="hidden" id="depositdate2" name="depositdate">
	<input type="hidden" id="isDeposited" name="isDeposited">
	<input type="hidden" id="updateId" name="TUC_ID">
	<input type="hidden" id="ET_RECEIPT_ID" name="TR_ID">
	
</form>
<script>

	function editEOD(ET_RECEIPT_CATEGORY_TYPE,EUC_CHEQUE_NO,EUC_CHEQUE_DATE,EUC_BANK_NAME,EUC_BRANCH_NAME,EUC_CHEQUE,TUC_ID,EUC_EOD_DATE,ET_RECEIPT_ID) {

		let url = "<?=site_url()?>TrustEOD_Tally/checkPreviousPendingDate/";
		$.post(url, {
			date:EUC_EOD_DATE
		},function(e) {
			if(e == "success") {
				$('#receiptCategory').html(ET_RECEIPT_CATEGORY_TYPE);
				$('#ChequeNum').html(EUC_CHEQUE_NO);
				$('#Chequedate').html(EUC_CHEQUE_DATE);
				$('#BankName').html(EUC_BANK_NAME);
				$('#BranchName').html(EUC_BRANCH_NAME);
				$('#chequeAmount').html(EUC_CHEQUE);

				$('#total1').val(EUC_CHEQUE);
				$('#EUC_CHEQUE_NO').val(EUC_CHEQUE_NO);
				$('#EUC_CHEQUE_DATE').val(EUC_CHEQUE_DATE);
				$('#EUC_BANK_NAME').val(EUC_BANK_NAME);
				$('#EUC_BRANCH_NAME').val(EUC_BRANCH_NAME);
				$('#ET_RECEIPT_ID').val(ET_RECEIPT_ID);
				$('#updateId').val(TUC_ID);
				callModal();
			} else {
				alert("Information", "Please Clear cheque for previous EOD date(s).");
			}
		});
	}

	function callModal(type1) {
		$('#confirm').hide(); 
		$('#save').show();
		document.getElementById("addBank").style.borderColor = "#000000";		
		document.getElementById("addBank").disabled = false;
		document.getElementById("addBank").selectedIndex = "0";
		$('#depositdate').val("");
		$('#total').html("");
		$('#chequeRemmittance').modal();
		document.getElementById("errMsg").style.display = "none";
		
	}

	
	$('#submit').on('click', function() {
		let count = 0;
			if(!$('#depositdate').val()) {
				++count;
				$('#depositdate').css('border-color', "#FF0000");
			} else {
				$('#depositdate').css('border-color', "#000000");
			}
			
			if($('#addBank option:selected').val() == 0) {
				++count;
				$('#addBank').css('border-color', "#FF0000");
			} else {
				$('#addBank').css('border-color', "#000000");
			}

			if(count != 0) {
				$('#chequeRemmittance').effect( "shake" );
				return;
			} else {
				let selOpt = $('#addBank option:selected').val();
				$('#bank1').val(selOpt);
				$('#submitForm').submit();
			}
	});
	

	$('#depositdate').css('border-color','black');
	$( ".depositdate" ).datepicker({
		dateFormat: 'dd-mm-yy',
		onSelect: function (selectedDate) {
			$('#depositdate2').val(selectedDate);
			$('#depositdate').css('border-color', "#000000");
			$('#depositdate').css('border-color','black');
		}
	});
	
	$('.todayDate').on('click',function() {
		$( ".depositdate" ).focus();
	});

	$(function() {	
		$('#saveSubmit').on('click', function() {
			document.getElementById("errMsg").style.display = "none";           
			let count = 0;
			if(!$('#depositdate').val()) {
				++count;
				$('#depositdate').css('border-color', "#FF0000");
			} else {
				$('#depositdate').css('border-color', "#000000");
			}
			
			if($('#addBank option:selected').val() == 0) {
				++count;
				$('#addBank').css('border-color', "#FF0000");
			} else {
				$('#addBank').css('border-color', "#000000");
			}

			if(count != 0) {
				$('#chequeRemmittance').effect( "shake" );
				return;
			} else {
				$('#confirm').show(); 
				$('#save').hide();
			}
			
		});
	});

	$("#addBank").on("change", function() {
		if($("#addBank option:selected").val()) {
			$("#addBank").css("border-color","#000000");
		} else {
			$("#addBank").css("border-color","#FF0000");
		}
	});
	
</script>