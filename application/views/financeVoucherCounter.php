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
							<div class="col-md-10 col-lg-10 col-sm-10 col-xs-10 no-pad">
								<h3>Finance Voucher Counter</h3>
							</div>
						</div>
						<div class="body-inner no-padding table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th style="width:60%;"><strong>Voucher Name</strong></th>
										<th style="width:15%;"><strong>Voucher Format</strong></th>
										<th style="width:15%;"><strong>Voucher Counter</strong></th>
										<th style="width:10%;"><strong><center>Operations</center></strong></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($finance_voucher_counter as $result) { ?>
										<tr class="row1">
											<td><?php echo $result->FVC_NAME; ?></td>
											<td><?php echo $result->FVC_ABBR1." / ".$result->FVC_ABBR2; ?></td>
											<td><?php echo $result->FVC_COUNTER; ?></td>
											<td>
												<center>
													<a style="border:none; outline: 0;" title="Reset Finance Voucher Counter"><img onclick="GetResetCounter('<?php echo $result->FVC_NAME; ?> Voucher','<?php echo site_url(); ?>finance/update_finance_voucher_counter/','<?php echo $result->FVC_ID; ?>')" style=" width:24px; height:24px;border:none; outline: 0;" src="<?php echo base_url(); ?>images/Change_pswd.svg"></a>
													<a style="border:none; outline: 0;" href="<?php echo site_url(); ?>finance/edit_finance_voucher_details/<?php echo $result->FVC_ID; ?>" title="Edit Receipt Details" ><img style="border:none; outline: 0;" src="<?php echo	base_url(); ?>images/edit_icon.svg"></a>
													
												</center>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
	//RESET COUNTER
	function GetResetCounter(name,url,id) {
		confirmResetVoucherCounter("Warning","Are you sure, you want to reset counter for <strong>"+ name +"</strong>?",url,id);
	}
</script>