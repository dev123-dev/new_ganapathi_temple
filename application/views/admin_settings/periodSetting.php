<?php error_reporting(0); ?>
<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<div class="row form-group">							
		<div class="col-lg-12 col-md-12 col-sm-8 col-xs-8" style = "padding-right:0px;padding-top:10px;">
				<h3 style="margin-top:0px">Shashwath Period Settings</h3>
		</div>
	</div>
	<div class="col-offset-lg-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-right text-right" style = "padding-right:0px;padding-bottom:0px; margin-top:-3em">
			<a style="margin-left: 9px;pull-right;" href="<?=site_url()?>admin_settings/Admin_setting/add_period" title="Add period"><img style="width:24px; height:24px" src="<?=site_url();?>images/add_icon.svg"/></a>
			<a style="text-decoration:none;cursor:pointer;pull-right;" href="<?=site_url()?>admin_settings/Admin_setting/period_setting/" title="Refresh"><img style="width:24px; height:24px" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
	</div>
	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
					  <tr>
						<th width="30%"><center>Period Name</center></th>
						<th width="30%"><center>Period</center></th>
						<th width="30%"><center>Period Status</center></th>
						<th><center>Operations</center></th>
					  </tr>
					</thead>
					<tbody>
					<?php foreach($periodDetails as $result) { ?>
					<tr>
						<td><center><?php echo $result->PERIOD_NAME; ?></center></td>
						<td><center><?php echo $result->PERIOD; ?></center></td>
						<?php if($result->P_STATUS == 1) { ?>
						<td><center>Active</center></td>
						<?php } else { ?>
						<td><center>Deactive</center></td>
						<?php }?>
						<td class="text-center" width="30%">
						<a style="border:none; outline: 0;" href="#" title="Edit Period" ><img style="border:none; outline: 0;" onclick = "editPeriod(<?php echo $result->SP_ID.",'".$result->PERIOD_NAME."',".$result->PERIOD.",".$result->P_STATUS;?>)" src="<?php echo	base_url(); ?>images/edit_icon.svg"></a>&nbsp;&nbsp;
						</td>	
					</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<form id="editPeriodForm" method="post" action="<?php echo site_url();?>admin_settings/Admin_setting/edit_period_setting">
	<input type="hidden" value="" name="sp_id" id="spid"/>
	<input type="hidden" value="" name="pname" id="pname"/>
	<input type="hidden" value="" name="period" id="period"/>
	<input type="hidden" value="" name="pstatus" id="pstatus"/>
</form>
<script>
	function editPeriod(spid,pname,period,pstatus){
		$('#spid').val(spid);
		$('#pname').val(pname);
		$('#period').val(period);
		$('#pstatus').val(pstatus);
		$('#editPeriodForm').submit();
	}
</script>
