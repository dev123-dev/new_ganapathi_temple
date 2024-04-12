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
								<h3>Block Date</h3>
							</div>
							<div class="col-md-2 col-lg-2 col-sm-2 col-xs-2 text-right">
								<a style="border:none; outline:0;" href="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/add_block_date" title="Add Block Date"><img style="border:none; outline: 0;margin-top:1.4em;margin-bottom:.5em;" src="<?php echo base_url(); ?>images/add_icon.svg"></a>
							</div>
						</div>
						<div class="body-inner no-padding table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th style="width:10%;"><strong>Date</strong></th>
										<th style="width:75%;"><strong>Hall</strong></th>
										<!--<th style="width:10%;"><strong>Time From</strong></th>
										<th style="width:10%;"><strong>Time To</strong></th>-->
										<th style="width:10%;"><strong>Status</strong></th>
										<th style="width:5%;"><strong>Operations</strong></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($block_date_settings as $result) { ?>
										<tr class="row1">
											<td><?php echo $result->TBDT_DATE; ?></td>
											<td><?php echo $result->HALL_NAME; ?></td>
											<!--<td><?php echo $result->TBDT_FROM_TIME; ?></td>
											<td><?php echo $result->TBDT_TO_TIME; ?></td>-->
											<?php if($result->TBDT_ACTIVE == "1") { ?>
												<td><?php echo "Active"; ?></td>
											<?php } else { ?>
												<td><?php echo "Deactive"; ?></td> 
											<?php } ?>
											<td class="text-center">
												<a style="border:none; outline: 0;" href="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/edit_block_date/<?php echo $result->TBDT_ID; ?>" title="Edit Block Date" ><img style="border:none; outline: 0;" src="<?php echo	base_url(); ?>images/edit_icon.svg"></a>
												<?php if($result->HALL_ACTIVE == "0") { ?>
													<a style="border:none; outline: 0;" title="Active <?php echo $result->HALL_NAME; ?>"><img onclick="GetStatusChange('<?php echo $result->TBDT_ACTIVE; ?>','<?php echo trim($result->HALL_NAME); ?>','<?php echo $result->TBDT_ID; ?>');" style="cursor:pointer;border:none; outline: 0;" src="<?php echo base_url(); ?>images/delete.svg"></a>
												<?php } else { ?>
													<a style="border:none; outline: 0;" title="Deactive <?php echo $result->HALL_NAME; ?>"><img onclick="GetStatusChange('<?php echo $result->TBDT_ACTIVE; ?>','<?php echo trim($result->HALL_NAME); ?>','<?php echo $result->TBDT_ID; ?>');" style="cursor:pointer;border:none; outline: 0;" src="<?php echo base_url(); ?>images/delete.svg"></a>
												<?php } ?>
											</td>
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
<script>
	//STATUS CHANGE
	function GetStatusChange(status,hallName,id) {
		if(status == 1) {
			alertBlockDate("Warning","Are you sure, you want to <strong>deactivate</strong> the <strong>"+ hallName +"</strong>?","Deactivate",true,id,0);
		} else {
			alertBlockDate("Warning","Are you sure, you want to <strong>activate</strong> the <strong>"+ hallName +"</strong>?","Activate",true,id,1);
		}
	}
</script>