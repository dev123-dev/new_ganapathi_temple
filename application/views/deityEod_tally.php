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
			<span class="eventsFont2">E.O.D. Tally </span>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-right">
			<form id="report" enctype="multipart/form-data" method="post" accept-charset="utf-8">
				<a style="text-decoration:none;cursor:pointer;" href="<?=site_url()?>EOD_Tally" title="Refresh"><img style="width:24px; height:24px" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
			</form>
			
		</div>
	</div>
</div>
	
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
						<th>Eod Conf Date</th>
						<?php if(@$_SESSION['userGroup'] == "1" || @$_SESSION['userGroup'] == "6" || @$_SESSION['userGroup'] == "2" ){ ?><th>Operation</th><?php } ?>
					  </tr>
					</thead>
					<tbody>
						<?php foreach($eod_tally as $result) { ?>
							<tr class="row1">

								<td><center><?php echo date('d-m-Y',strtotime($result->DUC_EOD_DATE)); ?></center></td>
								<td><?php if($result->RECEIPT_NAME != NULL) echo $result->RECEIPT_NAME; else echo "-"; ?></td>
								<td><?php if($result->RECEIPT_CATEGORY_TYPE != NULL) echo $result->RECEIPT_CATEGORY_TYPE; else echo "-"; ?></td>
								<td><center><?php if($result->DUC_CHEQUE_NO != NULL) echo $result->DUC_CHEQUE_NO; else echo "-"; ?></center></td>							
								<td><?php if($result->DUC_BANK_NAME != NULL) echo $result->DUC_BANK_NAME .", ". $result->DUC_BRANCH_NAME; else echo "-"; ?></td>
								<td><center><?php if($result->DUC_CHEQUE != Null) echo $result->DUC_CHEQUE; else echo $result->DUC_CHEQUE_DEPOSIT; ?></center></td>
								<td><center><?php echo date('d-m-Y',strtotime($result->DUC_DATE)); ?></center></td>

								<?php if(@$_SESSION['userGroup'] == "1" || @$_SESSION['userGroup'] == "6"  || @$_SESSION['userGroup'] == "2"){ ?>
									<td style="text-align:center;">
									<a style="margin-left:9px;" onclick="editEOD('<?=$result->RECEIPT_CATEGORY_TYPE; ?>','<?=$result->DUC_CHEQUE_NO; ?>','<?=$result->DUC_CHEQUE_DATE; ?>','<?php echo str_replace("'","\'",$result->DUC_BANK_NAME);?>','<?php echo str_replace("'","\'",$result->DUC_BRANCH_NAME);?>','<?=$result->DUC_CHEQUE; ?>','<?=$result->DUC_ID; ?>','<?=$result->DUC_EOD_DATE; ?>','<?=$result->RECEIPT_ID; ?>')" title="Bank Deposit"><img style="margin-right:4px;width:24px; height:24px" src="<?=site_url();?>images/edit_icon.svg"/></a>

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
									<option value="<?=$result->FGLH_ID; ?>">
										<?=$result->FGLH_NAME; ?>
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

<form id="submitForm" action="<?php echo site_url(); ?>EOD_Tally/eodTallySave" class="form-group" role="form" enctype="multipart/form-data" method="post">
	<input type="hidden" id="cheque1" name="cheque" value="">
	<input type="hidden" id="total1" name="total" value="">
	<input type="hidden" id="bank1" name="bank" value="">
	<input type="hidden" id="DUC_CHEQUE_NO" name="DUC_CHEQUE_NO">
	<input type="hidden" id="DUC_CHEQUE_DATE" name="DUC_CHEQUE_DATE">
	<input type="hidden" id="DUC_BANK_NAME" name="DUC_BANK_NAME">
	<input type="hidden" id="DUC_BRANCH_NAME" name="DUC_BRANCH_NAME">
	<input type="hidden" id="depositdate2" name="depositdate">
	<input type="hidden" id="isDeposited" name="isDeposited">
	<input type="hidden" id="updateId" name="updateId">
	<input type="hidden" id="RECEIPT_ID" name="RECEIPT_ID">
</form>
<script>

	function 
	editEOD(RECEIPT_CATEGORY_TYPE,DUC_CHEQUE_NO,DUC_CHEQUE_DATE,DUC_BANK_NAME,DUC_BRANCH_NAME,DUC_CHEQUE,DUC_ID,DUC_EOD_DATE,RECEIPT_ID) {

		let url = "<?=site_url()?>EOD_Tally/checkPreviousPendingDate/";
		$.post(url, {
			date:DUC_EOD_DATE
		},function(e) {
			if(e == "success") {
				$('#receiptCategory').html(RECEIPT_CATEGORY_TYPE);
				$('#ChequeNum').html(DUC_CHEQUE_NO);
				$('#Chequedate').html(DUC_CHEQUE_DATE);
				$('#BankName').html(DUC_BANK_NAME);
				$('#BranchName').html(DUC_BRANCH_NAME);
				$('#chequeAmount').html(DUC_CHEQUE);

				$('#total1').val(DUC_CHEQUE);
				$('#DUC_CHEQUE_NO').val(DUC_CHEQUE_NO);
				$('#DUC_CHEQUE_DATE').val(DUC_CHEQUE_DATE);
				$('#DUC_BANK_NAME').val(DUC_BANK_NAME);
				$('#DUC_BRANCH_NAME').val(DUC_BRANCH_NAME);
				$('#RECEIPT_ID').val(RECEIPT_ID);
				$('#updateId').val(DUC_ID);
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