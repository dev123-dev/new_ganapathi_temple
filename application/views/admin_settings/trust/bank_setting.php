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
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
								<span class="eventsFont2">Financial Head - Bank Setting</span>
							</div>
							<div class="col-md-8 col-lg-8 col-sm-12 col-xs-12 text-right">
								<a style="border:none; outline:0;" href="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/add_bank/1" title="Add Bank"><img style="border:none; outline: 0;margin-top:1.4em;margin-bottom:.5em;" src="<?php echo base_url(); ?>images/add_icon.svg"></a>
							</div>
						</div>
						<div class="body-inner no-padding table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th style="width:20%;"><strong>Account No.</strong></th>
										<th style="width:30%;"><strong>Name</strong></th>
										<th style="width:25%;"><strong>Branch</strong></th>
										<th style="width:20%;"><strong>IFSC Code</strong></th>
										<th style="width:5%;"><strong>Operation</strong></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($bank as $result) { ?>
										<tr class="row1">
											<td><?php echo $result->ACCOUNT_NO; ?></td>
											<td><?php echo $result->BANK_NAME; ?></td>
											<td><?php echo $result->BANK_BRANCH; ?></td>
											<td><?php echo $result->BANK_IFSC_CODE; ?></td>
											<td><center><a style="border:none; outline: 0;" href="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/edit_bank/<?php echo $result->BANK_ID; ?>/1" title="Edit Bank" ><img style="border:none; outline: 0;" src="<?php echo	base_url(); ?>images/edit_icon.svg"></a></center></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
						<br><br>
						<div class="row form-group"> 
							<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
								<span class="eventsFont2">Event - Bank Setting</span>
							</div>
							<div class="col-md-9 col-lg-9 col-sm-12 col-xs-12 text-right">
								<a style="border:none; outline:0;" href="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/add_bank/2" title="Add Bank"><img style="border:none; outline: 0;margin-top:1.4em;margin-bottom:.5em;" src="<?php echo base_url(); ?>images/add_icon.svg"></a>
							</div>
						</div>
						<div class="body-inner no-padding table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th style="width:20%;"><strong>Account No.</strong></th>
										<th style="width:30%;"><strong>Name</strong></th>
										<th style="width:25%;"><strong>Branch</strong></th>
										<th style="width:20%;"><strong>IFSC Code</strong></th>
										<th style="width:5%;"><strong>Operation</strong></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($event_bank as $result) { ?>
										<tr class="row1">
											<td><?php echo $result->ACCOUNT_NO; ?></td>
											<td><?php echo $result->BANK_NAME; ?></td>
											<td><?php echo $result->BANK_BRANCH; ?></td>
											<td><?php echo $result->BANK_IFSC_CODE; ?></td>
											<td><center><a style="border:none; outline: 0;" href="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/edit_bank/<?php echo $result->BANK_ID; ?>/2" title="Edit Bank" ><img style="border:none; outline: 0;" src="<?php echo	base_url(); ?>images/edit_icon.svg"></a></center></td>
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