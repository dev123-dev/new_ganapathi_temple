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
								<h3>Users</h3>
							</div>
							<div class="col-md-2 col-lg-2 col-sm-2 col-xs-2 text-right">
								<?php if(isset($_SESSION['Add'])) { ?>
									<a style="border:none; outline:0;" href="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/add_user" title="Add User"><img style="border:none; outline: 0;margin-top:1.4em;margin-bottom:.5em;" src="<?php echo base_url(); ?>images/add_icon.svg"></a>
								<?php } ?>
							</div>
						</div>
						<div class="body-inner no-padding table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th style="width:20%;"><strong>Name</strong></th>
										<th style="width:40%;"><strong>Address</strong></th>
										<th style="width:15%;"><strong>Email/Phone</strong></th>
										<th style="width:5%;"><strong>Group</strong></th>
										<th style="width:5%;"><strong>Status</strong></th>
										<?php if((isset($_SESSION['Edit']) || isset($_SESSION['Active_Deactive']))) { ?>
											<th><strong><center>Operations</center></strong></th>
										<?php } ?>
									</tr>
								</thead>
								<tbody>
									<?php foreach($admin_settings_users as $result) { ?>
										<tr class="row1">
											<td><?php echo $result->USER_FULL_NAME; ?></td>
											<td><?php echo $result->USER_ADDRESS; ?></td>
											<td><?php echo $result->USER_EMAIL; ?><br/><?php echo $result->USER_PHONE; ?></td>
											<td><?php echo $result->GROUP_NAME; ?></td>
											<?php if($result->USER_ACTIVE == "1") { ?>
												<td><?php echo "Active"; ?></td>
											<?php } else { ?>
												<td><?php echo "Deactive"; ?></td> 
											<?php } ?>
											<?php if((isset($_SESSION['Edit']) && isset($_SESSION['Active_Deactive']))) { ?>
													<td class="text-center" width="45%">
														<?php if($this->session->userdata('userGroup') == "6" || $this->session->userdata('userGroup') == "1") { ?>
															<a style="border:none; outline: 0;" href="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/change_password/<?php echo $result->USER_ID; ?>" title="Change Password" ><img style=" width:24px; height:24px;border:none; outline: 0;" src="<?php echo	base_url(); ?>images/Change_pswd.svg"></a>
														<?php } ?>
														<a style="border:none; outline: 0;" href="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/edit_user/<?php echo $result->USER_ID; ?>" title="Edit User Details" ><img style="border:none; outline: 0;" src="<?php echo	base_url(); ?>images/edit_icon.svg"></a>
														
														<?php if($result->USER_ACTIVE == "1") { ?>
															<a style="border:none; outline: 0;" title="Deactivate User"><img style="cursor:pointer;border:none; outline: 0;" src="<?php echo base_url(); ?>images/delete.svg" onclick="GetStatusChange('<?php echo $result->USER_ACTIVE; ?>','<?php echo $result->USER_FULL_NAME; ?>','<?php echo $result->USER_ID; ?>','<?php echo $result->USER_GROUP; ?>','<?php echo $result->USER_TYPE; ?>');"></a>
														<?php } else { ?>
															<a style="border:none; outline: 0;" title="Activate User"><img style="cursor:pointer;border:none; outline: 0;" src="<?php echo base_url(); ?>images/delete.svg" onclick="GetStatusChange('<?php echo $result->USER_ACTIVE; ?>','<?php echo $result->USER_FULL_NAME; ?>','<?php echo $result->USER_ID; ?>','<?php echo $result->USER_GROUP; ?>','<?php echo $result->USER_TYPE; ?>');"></a>
														<?php } ?>
														<!--<a style="border:none; outline: 0;" title="Deactive User"><img style="cursor:pointer;border:none; outline: 0;" src="<?php //echo base_url(); ?>images/delete.svg" onclick="GetStatusChange('<?php //echo $result->USER_ACTIVE; ?>','<?php //echo $result->USER_FULL_NAME; ?>','<?php //echo $result->USER_ID; ?>','<?php //echo $result->USER_GROUP; ?>','<?php //echo $result->USER_TYPE; ?>');"></a>-->
													</td>
											<?php } else if(isset($_SESSION['Edit'])) { ?>
													<td class="text-center" width="45%">
														<?php if($this->session->userdata('userGroup') == "6" || $this->session->userdata('userGroup') == "6") { ?>
															<a style="border:none; outline: 0;" href="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/change_password/<?php echo $result->USER_ID; ?>" title="Change Password" ><img style=" width:24px; height:24px;border:none; outline: 0;" src="<?php echo	base_url(); ?>images/Change_pswd.svg"></a>
														<?php } ?>
														<a style="border:none; outline: 0;" href="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/edit_user/<?php echo $result->USER_ID; ?>" title="Edit User Details" ><img style="border:none; outline: 0;" src="<?php echo	base_url(); ?>images/edit_icon.svg"></a>
													</td>
											<?php } else if(isset($_SESSION['Active_Deactive'])) { ?>
													<td class="text-center" width="45%">
														<?php if($result->USER_ACTIVE == "1") { ?>
															<a style="border:none; outline: 0;" title="Deactivate User"><img style="cursor:pointer;border:none; outline: 0;" src="<?php echo base_url(); ?>images/delete.svg" onclick="GetStatusChange('<?php echo $result->USER_ACTIVE; ?>','<?php echo $result->USER_FULL_NAME; ?>','<?php echo $result->USER_ID; ?>','<?php echo $result->USER_GROUP; ?>','<?php echo $result->USER_TYPE; ?>');"></a>
														<?php } else { ?>
															<a style="border:none; outline: 0;" title="Activate User"><img style="cursor:pointer;border:none; outline: 0;" src="<?php echo base_url(); ?>images/delete.svg" onclick="GetStatusChange('<?php echo $result->USER_ACTIVE; ?>','<?php echo $result->USER_FULL_NAME; ?>','<?php echo $result->USER_ID; ?>','<?php echo $result->USER_GROUP; ?>','<?php echo $result->USER_TYPE; ?>');"></a>
														<?php } ?>
													</td>
											<?php } ?>
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
	function GetStatusChange(status,userName,id,groupid,groupName) {
		if(status == 1) {
			alertDialogUser("Warning","Are you sure, you want to <strong>deactivate</strong> the <strong>"+ userName +"</strong>?","Deactivate",true,id,groupid,0,groupName);
		} else {
			alertDialogUser("Warning","Are you sure, you want to <strong>activate</strong> the <strong>"+ userName +"</strong>?","Activate",true,id,groupid,1,groupName);
		}
	}
</script>