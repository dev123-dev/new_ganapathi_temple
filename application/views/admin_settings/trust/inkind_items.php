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
								<h3>Inkind Items</h3>
							</div>
							<div class="col-md-2 col-lg-2 col-sm-2 col-xs-2 text-right">
								<?php if(isset($_SESSION['Add'])) { ?>
									<a style="border:none; outline:0;" href="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/add_inkind" title="Add Item"><img style="border:none; outline: 0;margin-top:1.4em;margin-bottom:.5em;" src="<?php echo base_url(); ?>images/add_icon.svg"></a>
								<?php } ?>
							</div>
						</div>
						<div class="body-inner no-padding table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th style="width:10%;"><strong>Date</strong></th>
										<th style="width:15%;"><strong>Item Name</strong></th>
										<th style="width:5%;"><strong>Unit</strong></th>
										<th style="width:65%;"><strong>Item Description</strong></th>
										<?php if(isset($_SESSION['Edit'])) { ?>
											<th><strong>Operations</strong></th>
										<?php } ?>
									</tr>
								</thead>
								<tbody>
									<?php foreach($inkind_items as $result) { ?>
										<tr class="row1">
											<td><?php echo $result->DATE; ?></td>
											<td><?php echo $result->INKIND_ITEM_NAME; ?></td>
											<td><?php echo $result->INKIND_UNIT; ?></td>
											<td><?php echo $result->INKIND_DESC; ?></td>
											<?php if(isset($_SESSION['Edit'])) { ?>
												<td class="text-center" width="30%">
													<a style="border:none; outline: 0;" href="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/edit_inkind/<?php echo $result->INKIND_ITEM_ID; ?>" title="Edit Item" ><img style="border:none; outline: 0;" src="<?php echo	base_url(); ?>images/edit_icon.svg"></a>&nbsp;&nbsp;
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