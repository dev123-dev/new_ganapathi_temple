<section id="section-register" class="bg_register">
    <div class="container-fluid sub_reg" style="min-height:100%;">  	
		<!-- START Content -->
		<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
		<div class="container reg_top adminside">
			<!-- START Row -->
			<div class="row-fluid">
				<!-- START Datatable 2 -->
				<div class="span12 widget lime">
					<div class="row form-group"> 
						<div class="col-md-9 col-lg-9 col-sm-8 col-xs-8 no-pad">
							<h3>Seva - <?php echo $deity[0]->DEITY_NAME; ?></h3>
						</div>
						<div class="col-md-3 col-lg-3 col-sm-4 col-xs-4 text-right">
							<a style="border:none; outline: 0;" href="<?php echo site_url(); ?>admin_settings/Admin_setting/add_seva/<?php echo $deity[0]->DEITY_ID; ?>" title="Add Seva"><img style="border:none; outline: 0;margin-top:1.4em;margin-bottom:.5em;" src="<?php echo base_url(); ?>images/add_icon.svg"></a>&nbsp;&nbsp;
							<a style="border:none; outline:0;" href="<?php echo site_url(); ?>admin_settings/Admin_setting/deity_seva_setting" title="Back"><img style="border:none; outline: 0;margin-top:1.4em;margin-bottom:.5em;" src="<?php echo base_url(); ?>images/back_icon.svg"></a>
						</div>
					</div>
					<section class="body">
						<div class="body-inner no-padding  table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th style="width:55%;"><strong>Seva Name</strong></th>
										<th style="width:25%;"><strong>Seva BelongsTo</strong></th>
										<th style="width:25%;"><strong>Seva Type</strong></th>
										<th style="width:10%;"><strong>Price(Rs.)</strong></th>
										<th style="width:12%;"><strong>Status</strong></th>
										<th><strong>Operations</strong></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($admin_settings_seva as $result) { ?>
										<tr class="row1">
											<td><?php echo $result->SEVA_NAME; ?></td>
											<td><?php echo $result->SEVA_BELONGSTO; ?></td>
											<td><?php echo $result->SEVA_TYPE; ?></td>
											<td><?php echo $result->SEVA_PRICE; ?></td>
											<?php if($result->SEVA_ACTIVE == "1") { ?>
												<td><?php echo "Active"; ?></td>
											<?php } else { ?>
												<td><?php echo "Deactive"; ?></td> 
											<?php } ?>
											<td class="text-center" width="30%">
												<a style="border:none; outline: 0;" href="<?php echo site_url(); ?>admin_settings/Admin_setting/edit_seva/<?php echo $result->SEVA_ID; ?>" title="Edit Seva" ><img style="border:none; outline: 0;" src="<?php echo	base_url(); ?>images/edit_icon.svg"></a>&nbsp;&nbsp;
												<?php if($result->SEVA_ACTIVE == "0") { ?>
													<a style="border:none; outline: 0;" title="Active <?php echo $result->SEVA_NAME; ?>"><img style="cursor:pointer;border:none; outline: 0;" onclick="GetStatusChange('<?php echo $result->SEVA_ACTIVE; ?>','<?php echo $result->SEVA_NAME; ?>','<?php echo $result->DEITY_NAME; ?>','<?php echo $result->SEVA_ID; ?>','<?php echo $result->DEITY_ID; ?>');" src="<?php echo base_url(); ?>images/delete.svg"></a>
												<?php } else { ?>
													<a style="border:none; outline: 0;" title="Deactive <?php echo $result->SEVA_NAME; ?>"><img style="cursor:pointer;border:none; outline: 0;" onclick="GetStatusChange('<?php echo $result->SEVA_ACTIVE; ?>','<?php echo $result->SEVA_NAME; ?>','<?php echo $result->DEITY_NAME; ?>','<?php echo $result->SEVA_ID; ?>','<?php echo $result->DEITY_ID; ?>');" src="<?php echo base_url(); ?>images/delete.svg"></a>
												<?php } ?>
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
	//STATUS CHANGE
	function GetStatusChange(status,sevaName,deityName,id,deityid) {
		if(status == 1) {
			alertSevaOther("Warning","Are you sure, you want to <strong>deactivate</strong> the <strong>"+ sevaName +"</strong> for <strong>"+ deityName +"</strong>?","Deactivate",true,id,0,deityid);
		} else {
			alertSevaOther("Warning","Are you sure, you want to <strong>activate</strong> the <strong>"+ sevaName +"</strong> for <strong>"+ deityName +"</strong>?","Activate",true,id,1,deityid);
		}
	}
</script>