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
								<h3>Hall</h3>
							</div>
							<div class="col-md-2 col-lg-2 col-sm-2 col-xs-2 text-right">
								<a style="border:none; outline:0;" href="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/add_hall_page" title="Add Hall"><img style="border:none; outline: 0;margin-top:1.4em;margin-bottom:.5em;" src="<?php echo base_url(); ?>images/add_icon.svg"></a>
							</div>
						</div>
						<div class="body-inner no-padding table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th style="width:20%;"><strong>Hall Name</strong></th>
										<th style="width:60%;"><strong>Financial Heads</strong></th>
										<th style="width:10%;"><strong>Status</strong></th>
										<th style="width:10%;"><strong>Operations</strong></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($hallSettings as $result) { ?>
										<tr class="row1">
											<td><?php echo $result->HALL_NAME; ?></td>
											<td><?php echo $result->FH_NAME; ?></td>
											<?php if($result->HALL_ACTIVE == "1") { ?>
												<td><?php echo "Active"; ?></td>
											<?php } else { ?>
												<td><?php echo "Deactive"; ?></td> 
											<?php } ?>
											<td class="text-center">
												<a style="border:none; outline: 0;" href="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/edit_hall_page/<?php echo $result->HALL_ID; ?>" title="Edit Hall" ><img style="border:none; outline: 0;" src="<?php echo	base_url(); ?>images/edit_icon.svg"></a>&nbsp;&nbsp;
												<?php if($result->HALL_ACTIVE == "0") { ?>
													<a style="border:none; outline: 0;" title="Active <?php echo $result->HALL_NAME; ?>"><img onclick="GetStatusChange('<?php echo $result->HALL_ACTIVE; ?>','<?php echo trim($result->HALL_NAME); ?>','<?php echo $result->HALL_ID; ?>');" style="cursor:pointer;border:none; outline: 0;" src="<?php echo base_url(); ?>images/delete.svg"></a>&nbsp;&nbsp;
												<?php } else { ?>
													<a style="border:none; outline: 0;" title="Deactive <?php echo $result->HALL_NAME; ?>"><img onclick="GetStatusChange('<?php echo $result->HALL_ACTIVE; ?>','<?php echo trim($result->HALL_NAME); ?>','<?php echo $result->HALL_ID; ?>');" style="cursor:pointer;border:none; outline: 0;" src="<?php echo base_url(); ?>images/delete.svg"></a>&nbsp;&nbsp;
												<?php } ?>
												<a style="border:none; outline:0;" href="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/add_financial_head_to_hall_page/<?php echo $result->HALL_ID; ?>" title="Add Financial Head"><img style="border:none; outline: 0;" src="<?php echo base_url(); ?>images/add_icon.svg"></a>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
						
						<div class="row form-group"> 
							<div class="col-md-10 col-lg-10 col-sm-10 col-xs-10 no-pad">
								<h3>Financial Head</h3>
							</div>
							<div class="col-md-2 col-lg-2 col-sm-2 col-xs-2 text-right">
								<a style="border:none; outline:0;" href="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/add_financial_head_page" title="Add Financial Head"><img style="border:none; outline: 0;margin-top:1.4em;margin-bottom:.5em;" src="<?php echo base_url(); ?>images/add_icon.svg"></a>
							</div>
						</div>
						
						<div class="body-inner no-padding table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th><strong>Financial Name</strong></th>
										<th style="width:15%;"><strong>Status</strong></th>
										<th style="width:10%;"><strong>Operations</strong></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($financialSettings as $result) { ?>
										<tr class="row1">
											<td><?php echo $result->FH_NAME; ?></td>
											<?php if($result->FH_ACTIVE == "1") { ?>
												<td><?php echo "Active"; ?></td>
											<?php } else { ?>
												<td><?php echo "Deactive"; ?></td> 
											<?php } ?>
											<td class="text-center">
												<a style="border:none; outline: 0;" href="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/edit_financial_head/<?php echo $result->FH_ID; ?>" title="Edit Hall" ><img style="border:none; outline: 0;" src="<?php echo	base_url(); ?>images/edit_icon.svg"></a>&nbsp;&nbsp;
												<?php if($result->FH_ACTIVE == "0") { ?>
													<a style="border:none; outline: 0;" title="Active <?php echo $result->FH_NAME; ?>"><img onclick="GetFinancialStatusChange('<?php echo $result->FH_ACTIVE; ?>','<?php echo trim(str_replace("'","\'",$result->FH_NAME)); ?>','<?php echo $result->FH_ID; ?>');" style="cursor:pointer;border:none; outline: 0;" src="<?php echo base_url(); ?>images/delete.svg"></a>
												<?php } else { ?>
													<a style="border:none; outline: 0;" title="Deactive <?php echo $result->FH_NAME; ?>"><img onclick="GetFinancialStatusChange('<?php echo $result->FH_ACTIVE; ?>','<?php echo trim(str_replace("'","\'",$result->FH_NAME)); ?>','<?php echo $result->FH_ID; ?>');" style="cursor:pointer;border:none; outline: 0;" src="<?php echo base_url(); ?>images/delete.svg"></a>
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
	function GetStatusChange(status,hallName,id) {
		if(status == 1) {
			alertHall("Warning","Are you sure, you want to <strong>deactivate</strong> the <strong>"+ hallName +"</strong>?","Deactivate",true,id,0);
		} else {
			alertHall("Warning","Are you sure, you want to <strong>activate</strong> the <strong>"+ hallName +"</strong>?","Activate",true,id,1);
		}
	}
	
	//FINANCIAL STATUS CHANGE
	function GetFinancialStatusChange(status,financalName,id) {
		if(status == 1) {
			alertFinancial("Warning","Are you sure, you want to <strong>deactivate</strong> the <strong>"+ financalName +"</strong>?","Deactivate",true,id,0);
		} else {
			alertFinancial("Warning","Are you sure, you want to <strong>activate</strong> the <strong>"+ financalName +"</strong>?","Activate",true,id,1);
		}
	}
</script>