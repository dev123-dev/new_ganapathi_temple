<style>
	.blank_row { background:#FBB917; }
	.blank_row:hover { background:#FBB917; }
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
					<div class="row form-group"> 
						<div class="col-md-2 col-lg-2 col-sm-2 col-xs-8 no-pad">
							<h3>Deity</h3>
						</div>
						<div class="col-md-10 col-lg-10 col-sm-10 col-xs-4 text-right">
							<a style="border:none; outline:0;" href="<?php echo site_url(); ?>admin_settings/Admin_setting/add_deity" title="Add Deity"><img style="border:none; outline: 0;margin-top:1.4em;margin-bottom:.5em;" src="<?php echo base_url(); ?>images/add_icon.svg"></a>
						</div>
					</div>
					<section class="body">
						<div class="body-inner no-padding  table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th style="width:82%;"><strong>Deity Name</strong></th>
										<th style="width:10%;"><strong>Sevas Count</strong></th>
										<th style="width:10%;"><strong>Status</strong></th>
										<th><strong>Operations</strong></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($admin_settings_deity as $result) { ?>
										<tr class="row1">
											<td><a style="color:#800000;" href="<?php echo site_url(); ?>admin_settings/Admin_setting/deity_seva_details/<?php echo $result->DEITY_ID; ?>"><?php echo $result->DEITY_NAME; ?></a></td>
											<td><center><?php echo $result->SEVACOUNT; ?></center></td> 
											<?php if($result->DEITY_ACTIVE == "1") { ?>
												<td><?php echo "Active"; ?></td>
											<?php } else { ?>
												<td><?php echo "Deactive"; ?></td> 
											<?php } ?>
											
											<td class="text-center" width="30%">
												<a style="border:none; outline: 0;" href="<?php echo site_url(); ?>admin_settings/Admin_setting/edit_deity/<?php echo $result->DEITY_ID; ?>" title="Edit Deity" ><img style="border:none; outline: 0;" src="<?php echo	base_url(); ?>images/edit_icon.svg"></a>&nbsp;&nbsp;
												<a style="border:none; outline: 0;" href="<?php echo site_url(); ?>admin_settings/Admin_setting/add_seva/<?php echo $result->DEITY_ID; ?>" title="Add Seva"><img style="border:none; outline: 0;" src="<?php echo base_url(); ?>images/add_icon.svg"></a>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
						<div class="row form-group"> 
							<div class="col-md-2 col-lg-2 col-sm-2 col-xs-8 no-pad">
								<h3>Seva</h3>
							</div>
							<div class="col-md-10 col-lg-10 col-sm-10 col-xs-4 text-right">
								<a style="border:none; outline:0;" href="<?php echo site_url(); ?>admin_settings/Admin_setting/add_seva_other" title="Add Seva"><img style="border:none; outline: 0;margin-top:1.4em;margin-bottom:.5em;" src="<?php echo base_url(); ?>images/add_icon.svg"></a>
							</div>
						</div>
						
						<div class="body-inner no-padding table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th style="width:20%;"><strong>Deity Name</strong></th>
										<th style="width:30%;"><strong>Seva Name</strong></th>
										<th style="width:10%;"><strong>Seva BelongsTo</strong></th>
										<th style="width:8%;"><strong>Seva Type</strong></th>
										<th style="width:8%;"><strong>Price (Rs.)</strong></th>
										<th style="width:10%;"><strong>Rev. Price (Rs.) / Date</strong></th>
										<th style="width:15%;"><strong>Shashwath Min Corpus</strong></th>
										<th style="width:10%;"><strong>Status</strong></th>
										<th><strong>Operations</strong></th>
									</tr>
								</thead>
								<tbody>
									<?php $name = ""; $i = 0;  foreach($admin_settings_seva as $result) { ?>
										<?php if($name == $result->DEITY_NAME) { ?> <!--Condition To Check Same Name-->
											<tr class="row1">
												<td><?php echo '"'; ?></td>
												<td><?php echo $result->SEVA_NAME; ?></td>
												<td><?php echo $result->SEVA_BELONGSTO; ?></td>
												<td><?php echo $result->SEVA_TYPE;?></td>

												<?php if($result->REVISION_STATUS == 1) { ?>
													<td><center><?php echo $result->OLD_PRICE; ?></center></td>
													<td><center><?php echo $result->SEVA_PRICE ." / ". $result->REVISION_DATE ?></center></td>
													<!-- <td></td> -->
												<?php } else { ?>
													<td><center><?php echo $result->SEVA_PRICE; ?></center></td>
													<td></td>
												<?php } ?>

												<td><?php echo $result->SHASH_PRICE;?></td>

												<?php if($result->SEVA_ACTIVE == "1") { ?>
													<td><center><?php echo "Active"; ?></center></td>
												<?php } else { ?>
													<td><center><?php echo "Deactive"; ?></center></td> 
												<?php } ?>
												<td class="text-center" width="30%">
													<a style="border:none; outline: 0;" href="<?php echo site_url(); ?>admin_settings/Admin_setting/edit_seva/<?php echo $result->SEVA_ID; ?>" title="Edit Seva" ><img style="border:none; outline: 0;" src="<?php echo	base_url(); ?>images/edit_icon.svg"></a>&nbsp;&nbsp;
													<?php if($result->SEVA_ACTIVE == "0") { ?>
														<a style="border:none; outline: 0;" title="Active <?php echo $result->SEVA_NAME; ?>"><img onclick="GetStatusChange('<?php echo $result->SEVA_ACTIVE; ?>','<?php echo trim($result->SEVA_NAME); ?>','<?php echo $result->DEITY_NAME; ?>','<?php echo $result->SEVA_ID; ?>');" style="cursor:pointer;border:none; outline: 0;" src="<?php echo base_url(); ?>images/delete.svg"></a>
													<?php } else { ?>
														<a style="border:none; outline: 0;" title="Deactive <?php echo $result->SEVA_NAME; ?>"><img onclick="GetStatusChange('<?php echo $result->SEVA_ACTIVE; ?>','<?php echo trim($result->SEVA_NAME); ?>','<?php echo $result->DEITY_NAME; ?>','<?php echo $result->SEVA_ID; ?>');" style="cursor:pointer;border:none; outline: 0;" src="<?php echo base_url(); ?>images/delete.svg"></a>
													<?php } ?>
												</td>
											</tr>
										<?php } else { $name = $result->DEITY_NAME; ?>
											<!--FOR BLANK SPACE IN DATAGRID-->
											<?php if($i != 0) { ?>
												<tr class="blank_row"><td colspan="9"></td></tr>
											<?php } ?>
											<!--FOR BLANK SPACE IN DATAGRID ENDS HERE-->
											<tr class="row1">
												<td><?php echo $result->DEITY_NAME; ?></td>
												<td><?php echo $result->SEVA_NAME; ?></td>
												<td><?php echo $result->SEVA_BELONGSTO; ?></td>
												<td><?php echo $result->SEVA_TYPE; ?></td>
												<?php if($result->REVISION_STATUS == 1) { ?>
													<td><center><?php echo $result->OLD_PRICE; ?></center></td>
													<td><center><?php echo $result->SEVA_PRICE ." / ". $result->REVISION_DATE ?></center></td>
												<?php } else { ?>
													<td><center><?php echo $result->SEVA_PRICE; ?></center></td>
													<td></td>
												<?php } ?>
												<td><?php echo $result->SHASH_PRICE;?></td>
												<?php if($result->SEVA_ACTIVE == "1") { ?>
													<td><center><?php echo "Active"; ?></center></td>
												<?php } else { ?>
													<td><center><?php echo "Deactive"; ?></center></td>
												<?php } ?>
												<td class="text-center" width="30%">
													<a style="border:none; outline: 0;" href="<?php echo site_url(); ?>admin_settings/Admin_setting/edit_seva/<?php echo $result->SEVA_ID; ?>" title="Edit Seva" ><img style="border:none; outline: 0;" src="<?php echo	base_url(); ?>images/edit_icon.svg"></a>&nbsp;&nbsp;
													<?php if($result->SEVA_ACTIVE == "0") { ?>
														<a style="border:none; outline: 0;" title="Active <?php echo $result->SEVA_NAME; ?>"><img style="cursor:pointer;border:none; outline: 0;" onclick="GetStatusChange('<?php echo $result->SEVA_ACTIVE; ?>','<?php echo $result->SEVA_NAME; ?>','<?php echo $result->DEITY_NAME; ?>','<?php echo $result->SEVA_ID; ?>');" src="<?php echo base_url(); ?>images/delete.svg"></a>
													<?php } else { ?>
														<a style="border:none; outline: 0;" title="Deactive <?php echo $result->SEVA_NAME; ?>"><img style="cursor:pointer;border:none; outline: 0;" onclick="GetStatusChange('<?php echo $result->SEVA_ACTIVE; ?>','<?php echo $result->SEVA_NAME; ?>','<?php echo $result->DEITY_NAME; ?>','<?php echo $result->SEVA_ID; ?>');" src="<?php echo base_url(); ?>images/delete.svg"></a>
													<?php } ?>
												</td>
											</tr>
										<?php $i++; } ?>
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
	function GetStatusChange(status,sevaName,deityName,id) {
		if(status == 1) {
			alertSeva("Warning","Are you sure, you want to <strong>deactivate</strong> the <strong>"+ sevaName +"</strong> for <strong>"+ deityName +"</strong>?","Deactivate",true,id,0);
		} else {
			alertSeva("Warning","Are you sure, you want to <strong>activate</strong> the <strong>"+ sevaName +"</strong> for <strong>"+ deityName +"</strong>?","Activate",true,id,1);
		}
	}
</script>