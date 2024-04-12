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
								<h3>Function Type</h3>
							</div>
							<div class="col-md-2 col-lg-2 col-sm-2 col-xs-2 text-right">
								<?php if(isset($_SESSION['Add'])) { ?>
									<a style="border:none; outline:0;" href="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/functionTypeAdd" title="Add Item"><img style="border:none; outline: 0;margin-top:1.4em;margin-bottom:.5em;" src="<?php echo base_url(); ?>images/add_icon.svg"></a>
								<?php } ?>
							</div>
						</div>
						<div class="body-inner no-padding table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										
										<th style="width:15%;"><strong>Function Type</strong></th>
										<th style="width:75%;"><strong>Description</strong></th>
										<?php if(isset($_SESSION['Edit'])) { ?>
											<th style="width:15%;"><strong>Operations</strong></th>
										<?php } ?>
									</tr>
								</thead>
								<tbody>
									<?php foreach($fun as $result) { ?>
										<tr class="row1">
											<td><?php echo $result->FN_NAME; ?></td>
											<td><?php echo $result->FN_DESC; ?></td>
											<?php if(isset($_SESSION['Edit'])) { ?>
												<td class="text-center" width="30%">
													<a style="border:none; outline: 0;" href="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/functionTypeEdit/<?php echo $result->FN_ID; ?>" title="Edit Item" ><img style="border:none; outline: 0;" src="<?php echo	base_url(); ?>images/edit_icon.svg"></a>&nbsp;&nbsp;
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