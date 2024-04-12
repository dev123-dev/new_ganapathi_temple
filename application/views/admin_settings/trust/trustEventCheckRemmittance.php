<style>
    .datepicker {
      z-index: 1600 !important; /* has to be larger than 1050 */
    } .chequedate {
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
								<h3 style="font-weight:600">Event Cheque Remmittance</h3>
							</div>
						</div>
						
						<!-- below code is added by adithya for the dropdown of cheque remittence modal -->
						<?php

						     $data = array(); // Initializing an empty array
                             if (is_array($bank)) {
                                 foreach ($bank as $result) {
                             		 array_push($data,$result);		
                                 }
                             } else {
                                 echo "The variable is not an array.";
                             }
                        ?>
						<!-- modal code end  -->

						
						<form action="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/SearcheventChequeRemmittance" id="chequeNumberSubmit" enctype="multipart/form-data" 	 method="post" accept-charset="utf-8">
							<div class="row form-group" style="margin-top:-0.8em;"> 
								<div class="col-lg-2 col-md-3 col-sm-4 col-xs-9">
									<div class="input-group input-group-sm">
										<input autocomplete="off" type="text" id="chequeNumber" name="chequeNumber" value="<?=@$cheque_Number?>" class="form-control" placeholder="Cheque Number">
										<div class="input-group-btn">
										  <button class="btn btn-default name_phone" name="button" value="cn" type="submit">
											<i class="glyphicon glyphicon-search"></i>
										  </button>
										</div>
									</div>
								</div>
								<div class="pull-right" style="padding-right:15px">
								<a style="text-decoration:none;cursor:pointer;pull-right;" href="<?=site_url()?>admin_settings/Admin_Trust_setting/eventChequeRemmittance" title="Refresh"><img style="width:24px;height:24px;margin-top:10px;" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
								</div>
							</div>
						</form>
						<div class="body-inner no-padding table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th style="width:18%;"><strong>Receipt Date.</strong></th>
										<th style="width:24%;"><strong>Receipt Name</strong></th>
										<th style="width:5%;"><strong>Receipt Type</strong></th>
										<th style="width:5%;"><strong>Receipt Amount</strong></th>
										<th style="width:15%;"><strong>Cheque No.</strong></th>
										<th style="width:10%;"><strong>Cheque Date</strong></th>
										<th style="width:12%;"><strong>Bank</strong></th>
										<th style="width:12%;"><strong>Branch</strong></th>
										<!-- <th style="width:10%;"><strong>Payment Status</strong></th> -->
										<?php if(isset($_SESSION['Authorise'])) { ?>
											<th style="width:2%;"><strong>Operations</strong></th>
										<?php } ?>
									</tr>
								</thead>
								<tbody>
									<?php foreach($checkRemmittance as $result) { ?>
										<tr class="row1">
                                       
								<td><?php echo date('d-m-Y',strtotime($result->TEUC_EOD_DATE)); ?></td>
								<td><?php if($result->TET_RECEIPT_NAME != NULL) echo $result->TET_RECEIPT_NAME; else echo "-"; ?></td>
								<td><?php if($result->TET_RECEIPT_CATEGORY_TYPE != NULL) echo $result->TET_RECEIPT_CATEGORY_TYPE; else echo "-"; ?></td>
								<td><?php if($result->TEUC_CHEQUE != Null) echo $result->TEUC_CHEQUE; else echo $result->TEUC_CHEQUE_DEPOSIT; ?></td>
								<td><?php if($result->TEUC_CHEQUE_NO != NULL) echo $result->TEUC_CHEQUE_NO; else echo "-"; ?></td>	
								<td><?php echo date('d-m-Y',strtotime($result->TEUC_DATE)); ?></td>						
								<td><?php if($result->TEUC_BANK_NAME != NULL) echo $result->TEUC_BANK_NAME ;?></td>
								<td><?php if($result->TEUC_BRANCH_NAME != NULL) echo $result->TEUC_BRANCH_NAME ; ?></td>

								<?php if(@$_SESSION['userGroup'] == "1" || @$_SESSION['userGroup'] == "6" || @$_SESSION['userGroup'] == "2" ){ ?><td style="text-align:center;">
									<a style="margin-left:9px;" onclick="editEOD('<?=$result->TET_RECEIPT_NO; ?>','<?=$result->TET_RECEIPT_NAME; ?>','<?=$result->TET_RECEIPT_CATEGORY_TYPE; ?>','<?=$result->TEUC_CHEQUE_NO; ?>','<?=$result->TEUC_CHEQUE_DATE; ?>','<?php echo str_replace("'","\'",$result->TEUC_BANK_NAME);?>','<?php echo str_replace("'","\'",$result->TEUC_BRANCH_NAME);?>','<?=$result->TEUC_CHEQUE; ?>','<?=$result->TEUC_ID; ?>','<?=$result->TEUC_EOD_DATE; ?>','<?=$result->TEUC_RECEIPT_ID; ?>')" title="Bank Deposit"><img style="margin-right:4px;width:24px; height:24px" src="<?=site_url();?>images/edit_icon.svg"/></a>
								</td><?php } ?>
							</tr>
									<?php } ?>
								</tbody>
							</table>
							<ul class="pagination pagination-sm">
								<?=$pages; ?>
							</ul>
						</div>
						
					</section>
				</div>
			</div>
		</div>
	</div>

</section>

<!-- Modal -->
<div class="modal fade" id="chequeRemmittance" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 style="font-weight:600;" class="modal-title text-center">Cheque Remmittance</h4>
			</div>
			<div class="modal-body">
              
					<div class="form-group">
						<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
							<label for="inputLimit" ><span style="font-weight:600;">Name: </span></label><span id="name"></span>
						</div>
						
						<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
							<label for="inputLimit" ><span style="font-weight:600;">Amount: </span></label><span id="chequeAmount"></span>
							
						</div>
					</div>
					<div class="form-group">
						<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
							<label for="inputLimit" ><span style="font-weight:600;">Cheque No.:</span></label><span id="ChequeNum"></span>
						</div>
						
						<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
							<label for="seva"><span style="font-weight:600;">Cheque Date:</span></label><span id="Chequedate"></span>
							
						</div>
					</div>
					
					<div style="clear:both;" class="form-group">
						<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
							<label for="inputLimit" ><span style="font-weight:600;">Bank: </span> </label><span id="BankName"></span>
							
						</div>
						
						<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
							<label for="inputLimit" ><span style="font-weight:600;">Branch: </span> </label><span id="BranchName"></span>
							
						</div>
					</div>
                    <!-- adding dropdown by adithya start -->
                    
                    <div style="clear:both;" class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    						<div class="form-inline">
                    							
                    							<label for="bank">To Bank  <span style="color:#800000;">*</span></label>&nbsp;&nbsp;
                    							<select id="addBank" name="addBank" class="form-control">
                    								<option value="0">Select Bank</option>
                    								<?php foreach($data as $result) {  ?>
                    									<option value="<?=$result->T_FGLH_ID; ?>">
                    									               <?=$result->T_FGLH_NAME; ?>
                    									</option>
                    								<?php } ?>
                    							</select>
                    						</div>
                    					</div>
                    				</div>
                    <!-- adding dropdown by adithya end -->


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
					
					<div id="errMsg" class="form-group col-lg-9 col-md-9 col-sm-9 col-xs-9" style="margin-top:.4em;display:none;color:red;">
				</div>
					<!-- HIDDEN -->
					<div class="modal-footer">
						<button type="button" id="saveSubmit" class="btn btn-default">SAVE</button>
					</div>
			</div>
		</div>
	</div>
</div>
<!-- admin_settings/Admin_Trust_setting/edit_chequeRemmittance/  -->
  <form id="submitForm" 
  action="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/edit_chequeRemmittance" 
  id="chequeRemmittanceForm" class="form-group" role="form" enctype="multipart/form-data" method="post">
  <input type="hidden" id="TET_RECEIPT_NO" name="TET_RECEIPT_NO">
  <input type="hidden" id="total1" name="total" value="">
  <input type="hidden" id="bank1" name="bank" value="">
  <input type="hidden" id="EUC_CHEQUE_NO" name="TEUC_CHEQUE_NO">
  <input type="hidden" id="EUC_CHEQUE_DATE" name="TEUC_CHEQUE_DATE">
  <input type="hidden" id="EUC_BANK_NAME" name="TEUC_BANK_NAME">
  <input type="hidden" id="EUC_BRANCH_NAME" name="TEUC_BRANCH_NAME">
  <input type="hidden" id="isDeposited" name="chequedate">
  <input type="hidden" id="updateId" name="updateId">
  <input type="hidden" id="TEUC_RECEIPT_ID" name="TEUC_RECEIPT_ID">   <!--here TEUC_RECEIPT_ID is id of trust_event_receipt primary key -->
  </form>
<script>
// TEUC_RECEIPT_ID
// ADDING the editEOD by adithya start//////////////////////////////////
function editEOD(TET_RECEIPT_NO,TET_RECEIPT_NAME,TET_RECEIPT_CATEGORY_TYPE,TEUC_CHEQUE_NO,TEUC_CHEQUE_DATE,TEUC_BANK_NAME,TEUC_BRANCH_NAME,TEUC_CHEQUE,TEUC_ID,TEUC_EOD_DATE,TEUC_RECEIPT_ID) {

let url = "<?=site_url()?>admin_settings/Admin_Trust_setting/checkPreviousPendingDate";
$.post(url, {
	date:TEUC_EOD_DATE
},function(e) {

	if(e == "success") {
		$('#TET_RECEIPT_NO').val(TET_RECEIPT_NO);
		$('#receiptCategory').val(TET_RECEIPT_CATEGORY_TYPE);
		$('#ChequeNum').html(TEUC_CHEQUE_NO);
		$('#Chequedate').html(TEUC_CHEQUE_DATE);
		$('#BankName').html(TEUC_BANK_NAME);
		$('#BranchName').html(TEUC_BRANCH_NAME);
		$('#chequeAmount').html(TEUC_CHEQUE);
        $('#name').html(TET_RECEIPT_NAME);      
		$('#total1').val(TEUC_CHEQUE);
		$('#EUC_CHEQUE_NO').val(TEUC_CHEQUE_NO);
		$('#EUC_CHEQUE_DATE').val(TEUC_CHEQUE_DATE);
		$('#EUC_BANK_NAME').val(TEUC_BANK_NAME);
		$('#EUC_BRANCH_NAME').val(TEUC_BRANCH_NAME);
		$('#TEUC_RECEIPT_ID').val(TEUC_RECEIPT_ID);
		$('#updateId').val(TEUC_ID);
		callModal();
	} else {
		alert("Information", "Please Clear cheque for previous EOD date(s).");
	}
});
}
// ADDING the editEOD by adithya end//////////////////////////////////


	$('#chequedate').val("");
	$('#chequedate').css('border-color','black');
	$( ".chequedate" ).datepicker({
		dateFormat: 'dd-mm-yy',
		onSelect: function (selectedDate) {
			$('#isDeposited').val(selectedDate);
			$('#chequedate').css('border-color','black');
		}
	});
	
	$('.todayDate').on('click',function() {
		$( ".chequedate" ).focus();
	})

	// // checking start
	let selOpt = $('#addBank option:selected').val();
				$('#bank1').val(selOpt);
				console.log("hello",selOpt)
	// // checking end
	
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
		if($('#chequedate').val() != "") {
			$('#submitForm').submit();
		} else { 
			$('#chequedate').css('border-color','red');
			$('#chequeRemmittance').effect( "shake" );
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

	$(function() {	
		$('#saveSubmit').on('click', function() {
			document.getElementById("errMsg").style.display = "none";   
			let bank = $('#addBank option:selected').val();       
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
			if(count == 0) {
				$('#chequeRemmittance').effect( "shake" );
				return;
			} else {
	
				$('#submitForm').submit();
				$('#save').hide();
			}
			
		});
	});

	$("#addBank").on("change", function() {
	
		if($("#addBank option:selected").val()) {
			let bank = $("#addBank option:selected").val();
			$('#bank1').val(bank);                          //added by adithya for Bank value to be passed to controller from addBank field

			$("#addBank").css("border-color","#000000");
		} else {
			$("#addBank").css("border-color","#FF0000");
		}
	});
</script>
