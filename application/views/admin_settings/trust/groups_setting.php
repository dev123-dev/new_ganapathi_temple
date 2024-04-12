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
								<h3>Groups</h3>
							</div>
							<div class="col-md-2 col-lg-2 col-sm-2 col-xs-2 text-right">
								<?php if(isset($_SESSION['Add'])) { ?>
									<!-- <a style="border:none; outline:0;" href="<?php echo site_url(); ?>admin_settings/Admin_setting/add_group_rights" title="Add Group"><img style="border:none; outline: 0;margin-top:1.4em;margin-bottom:.5em;" src="<?php echo base_url(); ?>images/add_icon.svg"></a> -->
								<?php } ?>
							</div>
						</div>
						<div class="body-inner no-padding table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th style="width:10%;"><strong>Name</strong></th>
										<th style="width:90%;"><strong>Pages Accessed</strong></th>
										<th style="width:5%;"><strong>Rights</strong></th>
										<th style="width:5%;"><strong>Status</strong></th>
										<?php if((isset($_SESSION['Active_Deactive']) || isset($_SESSION['Edit']))) { ?>
											<th><strong>Operations</strong></th>
										<?php } ?>
									</tr>
								</thead>
								<tbody>
									<?php foreach($admin_settings_group_rights as $result) { ?>
										<tr class="row1">
										<?php if($result->GROUP_ID == $user_group_id && $result->GROUP_ID != 6 ){?>
											
											<?php }else{?>

											<td><?php echo $result->GROUP_NAME; ?></td>
											<td><?php echo $result->TP_NAME; ?></td>
											<td><?php echo $result->R_NAME; ?></td>
											<?php if($result->GROUP_ACTIVE == "1") { ?>
												<td><?php echo "Active"; ?></td>
											<?php } else { ?>
												<td><?php echo "Deactive"; ?></td> 
											<?php } ?>
											<?php if((isset($_SESSION['Active_Deactive']) || isset($_SESSION['Edit']))) { ?>
												<td class="text-center" width="30%">
													<a style="border:none; outline: 0;" href="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/edit_group_rights/<?php echo $result->GROUP_ID; ?>" title="Edit Group" ><img style="border:none; outline: 0;" src="<?php echo	base_url(); ?>images/edit_icon.svg"></a>&nbsp;&nbsp;
													<?php if($result->GROUP_ACTIVE == "1") { ?>
														<a style="border:none; outline: 0;" title="Deactivate"><img style="border:none; outline: 0;" src="<?php echo base_url(); ?>images/delete.svg" onclick="GetStatusChangeGroup('<?php echo $result->GROUP_ACTIVE; ?>','<?php echo $result->GROUP_NAME; ?>','<?php echo $result->GROUP_ID; ?>');"></a>
													<?php } else { ?>
														<a style="border:none; outline: 0;" title="Activate"><img style="border:none; outline: 0;" src="<?php echo base_url(); ?>images/delete.svg" onclick="GetStatusChangeGroup('<?php echo $result->GROUP_ACTIVE; ?>','<?php echo $result->GROUP_NAME; ?>','<?php echo $result->GROUP_ID; ?>');"></a>
													<?php } ?>
													<!--<a style="border:none; outline: 0;" title="Deactive"><img style="border:none; outline: 0;" src="<?php //echo base_url(); ?>images/delete.svg" onclick="GetStatusChangeGroup('<?php //echo $result->GROUP_ACTIVE; ?>','<?php //echo $result->GROUP_NAME; ?>','<?php //echo $result->GROUP_ID; ?>');"></a>-->
												</td>
											<?php } else if(isset($_SESSION['Edit'])) { ?>
													<a style="border:none; outline: 0;" href="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/edit_group_rights/<?php echo $result->GROUP_ID; ?>" title="Edit Group" ><img style="border:none; outline: 0;" src="<?php echo	base_url(); ?>images/edit_icon.svg"></a>
											<?php } else if(isset($_SESSION['Active_Deactive'])) { ?>
													<?php if($result->GROUP_ACTIVE == "1") { ?>
														<a style="border:none; outline: 0;" title="Deactivate"><img style="border:none; outline: 0;" src="<?php echo base_url(); ?>images/delete.svg" onclick="GetStatusChangeGroup('<?php echo $result->GROUP_ACTIVE; ?>','<?php echo $result->GROUP_NAME; ?>','<?php echo $result->GROUP_ID; ?>');"></a>
													<?php } else { ?>
														<a style="border:none; outline: 0;" title="Activate"><img style="border:none; outline: 0;" src="<?php echo base_url(); ?>images/delete.svg" onclick="GetStatusChangeGroup('<?php echo $result->GROUP_ACTIVE; ?>','<?php echo $result->GROUP_NAME; ?>','<?php echo $result->GROUP_ID; ?>');"></a>
													<?php } ?>
													<!--<a style="border:none; outline: 0;" title="Deactive"><img style="border:none; outline: 0;" src="<?php //echo base_url(); ?>images/delete.svg" onclick="GetStatusChangeGroup('<?php //echo $result->GROUP_ACTIVE; ?>','<?php //echo $result->GROUP_NAME; ?>','<?php //echo $result->GROUP_ID; ?>');"></a>-->
											<?php } ?>
											<?php }?>
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
	function GetStatusChangeGroup(status,groupName,id) {
		if(status == 1) {
			alertDialogGroup("Warning","Are you sure, you want to <strong>deactivate</strong> the <strong>"+ groupName +" group.</strong>?","Deactivate",true,id,0);
		} else {
			alertDialogGroup("Warning","Are you sure, you want to <strong>activate</strong> the <strong>"+ groupName +" group.</strong>?","Activate",true,id,1);
		}
	}
</script>