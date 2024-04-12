<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<!-- HEADING AND REFRESH BUTTON -->
	<div class="row form-group">
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<span class="eventsFont2">Donation/Kanike</span>
		</div>
		<form action="<?=site_url();?>admin_settings/Admin_setting/searchDonation" enctype="multipart/form-data" method="post" accept-charset="utf-8"">
			<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
				<div class="input-group input-group-sm">
					<input autocomplete="" type="text" id="name" name="name" value="<?=@$name; ?>" class="form-control" placeholder="Name">
					<div class="input-group-btn">
					  <button class="btn btn-default name_phone" type="submit">
						<i class="glyphicon glyphicon-search"></i>
					  </button>
					</div>
				</div>
			</div>
		</form>
		
		<div class="col-lg-4 col-md-2 col-sm-2 col-xs-12">
			<a style="width:24px; height:24px" class="pull-right img-responsive" href="<?=site_url()?>admin_settings/Admin_setting/donation_kanike_details" titile="Reset"><img title="reset" src="<?=site_url();?>images/refresh.svg"/></a>
		</div>
	</div>
	
	<!--SEARCH FIELD -->
	
</div>

<!-- DATAGRID -->
<div class="container">
	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
					  <tr>
						<th>Receipt No.</th>
						<th>Name</th>
						<th>Amount</th>
						<th width="10%">Operation</th>
					  </tr>
					</thead>
					<tbody>
						<?php foreach($donation as $result) { ?>
							<tr class="row1">
								<td><?php echo $result->ET_RECEIPT_NO; ?></td>
								<td><?php echo $result->ET_RECEIPT_NAME; ?></td>
								<td><?php echo $result->ET_RECEIPT_PRICE; ?></td>
								<td><center><a style="border:none; outline: 0;" href="<?php echo site_url(); ?>admin_settings/Admin_setting/edit_donation/<?php echo $result->ET_RECEIPT_ID; ?>" title="Edit Details" ><img style="border:none; outline: 0;" src="<?php echo base_url(); ?>images/edit_icon.svg"></a>&nbsp;&nbsp;</center></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
				<ul class="pagination pagination-sm">
					<?=$pages; ?>
				</ul>
			</div>
		</div>
	</div>
</div>

<script>	
	
</script>