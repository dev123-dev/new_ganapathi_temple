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
								<h3>Event</h3>
							</div>
						</div>
						<div class="body-inner no-padding table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th style="width:60%;"><strong>Receipt For</strong></th>
										<th style="width:15%;"><strong>Receipt Format</strong></th>
										<th style="width:15%;"><strong>Receipt Counter</strong></th>
										<th style="width:10%;"><strong><center>Operations</center></strong></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($admin_settings_receipt_event as $result) { ?>
										<tr class="row1">
											<?php 
												if($result->TET_ABBR2 == "IK") {
													$receipt_for = $result->TET_NAME." - Inkind";
												} else {
													$receipt_for = $result->TET_NAME." - Seva, Donation/Kanike, Hundi";
												}
											?>
											<td><?php echo $receipt_for; ?></td>
											<td><?php echo $result->TET_ABBR1." / ".$result->TET_ABBR2; ?></td>
											<td><?php echo $result->TET_RECEIPT_COUNTER; ?></td>
											<td>
												<center>
													<a style="border:none; outline: 0;" title="Reset Event Counter"><img onclick="GetResetCounter('Events','<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/update_event_receipt_counter/','<?php echo $result->TET_RECEIPT_COUNTER_ID; ?>')" style=" width:24px; height:24px;border:none; outline: 0;" src="<?php echo base_url(); ?>images/Change_pswd.svg"></a>
													<a style="border:none; outline: 0;" href="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/edit_event_receipt_details/<?php echo $result->TET_RECEIPT_COUNTER_ID; ?>" title="Edit Receipt Details" ><img style="border:none; outline: 0;" src="<?php echo	base_url(); ?>images/edit_icon.svg"></a>
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
		confirmTrustResetCounter("Warning","Are you sure, you want to reset counter for <strong>"+ name +"</strong>?",url,id);
	}
</script>