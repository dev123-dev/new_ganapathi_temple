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
							<h3>Item</h3>
						</div>
						<div class="col-md-10 col-lg-10 col-sm-10 col-xs-4 text-right">
							<a style="border:none; outline:0;" href="<?php echo site_url(); ?>admin_settings/Admin_setting/add_auction_item" title="Add "><img style="border:none; outline: 0;margin-top:1.4em;margin-bottom:.5em;" src="<?php echo base_url(); ?>images/add_icon.svg"></a>
						</div>
					</div>
					<section class="body">
						<div class="body-inner no-padding  table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th style="width:75%;"><strong>Item Name </strong></th>
										<th style="width:10%;"><center><strong>Item Prefix</strong></center></th>
										<th style="width:10%;"><center><strong>Item Status</strong></center></th>
										<th style="width:5%;"><center><strong>Operation</strong></center></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($auction_item as $result) { ?>
										<tr class="row1">
											<td><?php echo $result->AI_NAME; ?></td>
											<td><center><?php echo $result->AI_PREFIX; ?></center></td>
											<?php if($result->AI_STATUS == "1") { ?>
												<td><center><?php echo "Active"; ?></center></td>
											<?php } else { ?>
												<td><center><?php echo "Deactive"; ?></center></td> 
											<?php } ?>
											<td><center>
													<?php if($result->AI_STATUS == "0") { ?>
														<a style="border:none; outline: 0;" title="Active <?php echo $result->AI_NAME; ?>"><img onclick="GetStatusChange('<?php echo $result->AI_STATUS; ?>','<?php echo $result->AI_NAME; ?>','<?php echo $result->AI_ID; ?>');" style="cursor:pointer;border:none; outline: 0;" src="<?php echo base_url(); ?>images/delete.svg"></a>
													<?php } else { ?>
														<a style="border:none; outline: 0;" title="Deactive <?php echo $result->AI_NAME; ?>"><img onclick="GetStatusChange('<?php echo $result->AI_STATUS; ?>','<?php echo $result->AI_NAME; ?>','<?php echo $result->AI_ID; ?>');" style="cursor:pointer;border:none; outline: 0;" src="<?php echo base_url(); ?>images/delete.svg"></a>
													<?php } ?>
											</center></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
						
						<div class="row form-group"> 
							<div class="col-md-2 col-lg-2 col-sm-2 col-xs-8 no-pad">
								<h3>Default Bid</h3>
							</div>
							<div class="col-md-10 col-lg-10 col-sm-10 col-xs-4 text-right">
								<a style="border:none; outline:0;" href="<?php echo site_url(); ?>admin_settings/Admin_setting/add_default_bid" title="Add "><img style="border:none; outline: 0;margin-top:1.4em;margin-bottom:.5em;" src="<?php echo base_url(); ?>images/add_icon.svg"></a>
							</div>
						</div>
						
						<div class="body-inner no-padding table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th style="width:75%;"><strong>Item</strong></th>
										<th style="width:10%;"><center><strong>Item Category</strong></center></th>
										<th style="width:10%;"><center><strong>Bid Value</strong></center></th>
										<th style="width:5%;"><center><strong>Operation</strong></center></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($default_bid as $result) { ?>
										<tr class="row1">
											<td><?php echo $result->AI_NAME; ?></td>
											<td><center><?php echo $result->AIC_NAME; ?></center></td>
											<td><center><?php echo $result->DEFAULT_BID_VALUE; ?></center></td>
											<td><center><a style="border:none; outline: 0;" href="<?php echo site_url(); ?>admin_settings/Admin_setting/edit_default_bid/<?php echo $result->IDB_ID; ?>" title="Edit Bid Value"><img style="border:none; outline: 0;" src="<?php echo	base_url(); ?>images/edit_icon.svg"></a></center></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
						
						<div class="row form-group"> 
							<div class="col-md-2 col-lg-2 col-sm-2 col-xs-8 no-pad">
								<h3>Bid Range</h3>
							</div>
							<div class="col-md-10 col-lg-10 col-sm-10 col-xs-4 text-right">
								<a style="border:none; outline:0;" href="<?php echo site_url(); ?>admin_settings/Admin_setting/add_bid_range" title="Add "><img style="border:none; outline: 0;margin-top:1.4em;margin-bottom:.5em;" src="<?php echo base_url(); ?>images/add_icon.svg"></a>
							</div>
						</div>
						
						<div class="body-inner no-padding table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th style="width:35%;"><strong>Item</strong></th>
										<th style="width:10%;"><center><strong>Item Category</strong></center></th>
										<th style="width:20%;"><center><strong>Range Start(Price)</strong></center></th>
										<th style="width:20%;"><center><strong>Range End(Price)</strong></center></th>
										<th style="width:10%;"><center><strong>Min. Bid Value</strong></center></th>
										<th style="width:5%;"><center><strong>Operation</strong></center></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($bid_range as $result) { ?>
										<tr class="row1">
											<td><?php echo $result->AI_NAME; ?></td>
											<td><center><?php echo $result->AIC_NAME; ?></center></td>
											<td><center><?php echo $result->ITEM_FROM_PRICE; ?></center></td>
											<td><center><?php echo $result->ITEM_TO_PRICE; ?></center></td>
											<td><center><?php echo $result->MIN_BID_VALUE; ?></center></td>
											<td><center><a style="border:none; outline: 0;" href="<?php echo site_url(); ?>admin_settings/Admin_setting/edit_bid_range/<?php echo $result->IBR_ID; ?>" title="Edit Bid Value"><img style="border:none; outline: 0;" src="<?php echo	base_url(); ?>images/edit_icon.svg"></a></center></td>
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
	function GetStatusChange(status,itemName,id) {
		if(status == 1) {
			alertAuction("Warning","Are you sure, you want to <strong>deactivate</strong> the <strong>"+ itemName +"</strong>?","Deactivate",true,id,0);
		} else {
			alertAuction("Warning","Are you sure, you want to <strong>activate</strong> the <strong>"+ itemName +"</strong>?","Activate",true,id,1);
		}
	}
</script>