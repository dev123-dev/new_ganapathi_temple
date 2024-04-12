<?php error_reporting(0); ?>
<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<div class="row form-group">							
		<div class="col-lg-12 col-md-12 col-sm-8 col-xs-8" style = "padding-right:0px;padding-top:10px;">
				<h3 style="margin-top:0px">Shashwath Festival Settings</h3>
		</div>
	</div>
	<div class="col-offset-lg-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-right text-right" style = "padding-right:0px;padding-bottom:0px; margin-top:-3em">
			<a style="margin-left: 9px;pull-right;" href="<?=site_url()?>admin_settings/Admin_setting/add_festival" title="Add Festival"><img style="width:24px; height:24px" src="<?=site_url();?>images/add_icon.svg"/></a>
			<a style="text-decoration:none;cursor:pointer;pull-right;" href="<?=site_url()?>admin_settings/Admin_setting/festival_setting/" title="Refresh"><img style="width:24px; height:24px" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
	</div>
	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
					  <tr>
						<th width="30%"><center>Festival Name</center></th>
						<th width="30%"><center>Thithi Code</center></th>
						<!-- <th width="30%"><center>Period Status</center></th> -->
						<th><center>Operations</center></th>
					  </tr>
					</thead>
					<tbody>
					<?php foreach($festivalDetails as $result) { ?> 
					<tr>
						<td><center><?php echo $result->SFS_NAME; ?></center></td>
						<td><center><?php echo $result->SFS_THITHI_CODE; ?></center></td>
						<td class="text-center" width="30%">
						<a style="border:none; outline: 0;" href="#" title="Edit Festival" ><img style="border:none; outline: 0;" onclick = "editFestival(<?php echo $result->SFS_ID.",'".$result->SFS_NAME."','".$result->SFS_THITHI_CODE."','".$result->SFS_MASA."','".$result->SFS_MOON."','".$result->SFS_THITHI."'";?>)" src="<?php echo	base_url(); ?>images/edit_icon.svg"></a>&nbsp;&nbsp;
						</td>	
					</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<form id="editFestivalForm" method="post" action="<?php echo site_url();?>admin_settings/Admin_setting/edit_festival_setting">
	<input type="hidden" value="" name="SFS_ID" id="SFS_ID"/>
	<input type="hidden" value="" name="SFS_NAME" id="SFS_NAME"/>
	<input type="hidden" value="" name="SFS_THITHI_CODE" id="SFS_THITHI_CODE"/>
	<input type="hidden" value="" name="SFS_MASA" id="SFS_MASA"/>
	<input type="hidden" value="" name="SFS_MOON" id="SFS_MOON"/>
	<input type="hidden" value="" name="SFS_THITHI" id="SFS_THITHI"/>
	
</form>
<script>
	function editFestival(SFS_ID,SFS_NAME,SFS_THITHI_CODE,SFS_MASA,SFS_MOON,SFS_THITHI){
		$('#SFS_ID').val(SFS_ID);
		$('#SFS_NAME').val(SFS_NAME);
		$('#SFS_THITHI_CODE').val(SFS_THITHI_CODE);
		$('#SFS_MASA').val(SFS_MASA);
		$('#SFS_MOON').val(SFS_MOON);
		$('#SFS_THITHI').val(SFS_THITHI);

		$('#editFestivalForm').submit();
	}
</script>
