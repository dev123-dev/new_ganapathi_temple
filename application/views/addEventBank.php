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
								<div class="col-lg-12 col-md-12 col-sm-8 col-xs-8" style = "padding-right:0px;padding-top:10px;">
									<h3 style="margin-top:0px">Add Bank to Direct Credit and Debit /Credit Card</h3>
								</div>
							</div>
							<div class="col-lg-12 col-md-12 col-sm-8 col-xs-8 pull-right text-right" style = "padding-right:0px;padding-bottom:10px;padding-top:10px; margin-top:-4em">
								<a style="text-decoration:none;cursor:pointer;pull-right; margin-left: 5px;" href="<?=site_url()?>finance/addbank" title="Refresh"><img style="width:24px; height:24px" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
							</div>
							<div class="body-inner no-padding table-responsive">
								<table class="table table-bordered table-hover">
									<thead>
										<tr>
											<th style="width:8%;"><center><strong>Receipt Id.</center></strong></th>
											<th style="width:15%;"><center><strong>Receipt Number</center></strong></th>
											<th style="width:10%;"><center><strong>Receipt Date</center></strong></th>
											<th style="width:15%;"><center><strong>Name</center></strong></th>
											<th style="width:6%;"><center><strong>Price</center></strong></th>
											<th style="width:15%;"><center><strong>Payment Method</center></strong></th>
											<th style="width:25%;"><center><strong>Select Bank</center></strong></th>
											<?php if(isset($_SESSION['Authorise'])) { ?>
												<th style="width:1%;"><strong>Operations</strong></th>
											<?php } ?>

										</tr>
									</thead>
									<tbody>
										<?php $i = 1;
										foreach($addbank as $result) {?>												
											<tr class="row1">
												<?php
												echo "<td class='rcp_" . $i . "'><center>". $result->ET_RECEIPT_ID."</center></td>";
												?>
												<td><?php echo $result->ET_RECEIPT_NO;?></td>
												<?php $id1=$result->ET_RECEIPT_ID;?>
												<td><center><?php echo $result->ET_RECEIPT_DATE; ?></center></td>				
												<td><?php echo $result->ET_RECEIPT_NAME; ?></td>
												<td><center><?php echo $result->ET_RECEIPT_PRICE; ?></center></td>
												<td><?php echo $result->ET_RECEIPT_PAYMENT_METHOD; ?></td>
												<td>
													<?php
													echo "<select id='tobank' name='tobank' class='form-control tobank_" . $i . "'>";
													?>
													<option value="0">Select Bank</option>
													<?php foreach($bank as $result) { ?>
														<option value="<?=$result->FGLH_ID; ?>">
															<?=$result->FGLH_NAME; ?>
														</option>
													<?php } ?>
												</select></td>
												<td><center>
													<a style="text-decoration:none;cursor:pointer;color:#800000;" onClick="updateBank('<?php echo $i ?>','<?php echo $id1 ?>')" ><img style="border:none; outline: 0;" width="24px" height="24px" src="<?php echo	base_url(); ?>images/check_icon.svg" /></a></center></td>												
												</tr>
												<?php $i++; }

												?>
											</tbody>
										</table>
										<div class="row-fluid">

											<?php if($bankCount != 0) { ?>
												<label  class="pull-right" style="font-size:18px;margin-right:15px;margin-top: 0em;">Total Records: <strong><?php echo $bankCount ?></strong></label>
											<?php } else { ?>
												<label> </label>
											<?php } ?>
											<div class="pull-right" style="padding-right:15px">
											</div>
										</div>					
									</div>
							</section>
						</div>
				</div>
			</div>
		</div>
	</section>

<form id="submitForm" action="" method="post">
	<input type="hidden" id="id" name="id" />
	<input type="hidden" id="bank1" name="bank1" />
</form>

<script>
	function updateBank(i,rcpid){
		let count=0;
		let bank1 ="";
		bank1 = $('.tobank_'+i).find(":selected").val();
		if (bank1 == 0 ) {
			$('#tobank').css('border-color', "#FF0000");
			++count;
		} else {
			$('#tobank').css('border-color', "#000000");
		}
		if (count != 0) {
			alert("Information", "Please Select Bank", "OK");
			return false;
		}else{
			$('#id').val(rcpid);
			$('#bank1').val(bank1);
			$('#submitForm').attr('action','<?=site_url()?>finance/updateEventBankDetails');
			$('#submitForm').submit();
		}
	}

</script>
