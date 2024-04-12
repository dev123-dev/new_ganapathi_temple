<?php error_reporting(0); ?>
<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<div class="row form-group">							
		<div class="col-lg-12 col-md-12 col-sm-8 col-xs-8" style = "padding-right:0px;padding-top:10px;">
				<h3 style="margin-top:0px">Kanike Settings</h3>
		</div>
	</div>
	<div class="col-offset-lg-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-right text-right" style = "padding-right:0px;padding-bottom:0px; margin-top:-3em">
			<a style="margin-left: 9px;pull-right;" href="<?=site_url()?>admin_settings/Admin_setting/add_kanike" title="Add Kanike"><img style="width:24px; height:24px" src="<?=site_url();?>images/add_icon.svg"/></a>
			<a style="text-decoration:none;cursor:pointer;pull-right;" href="<?=site_url()?>admin_settings/Admin_setting/kanike_setting/" title="Refresh"><img style="width:24px; height:24px" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
	</div>
	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
					  <tr>
						<th width="40%"><center>Kanike Name</center></th>
						<th width="40%"><center>Status</center></th>
						<th width="20%"><center>Price</center></th>
						<th><center>Operations</center></th>
					  </tr>
					</thead>
					<tbody>
					<?php foreach($kanikeDetails as $result) { ?>
					<tr>
						<td><center><?php echo $result->KANIKE_NAME; ?></center></td>
						<?php if($result->KS_STATUS == 1) { ?>
						<td><center>Active</center></td>
						<?php } else { ?>
						<td><center>Deactive</center></td>
						<?php }?>
						<td><center><?php echo ($result->PRICE > 0 ?  $result->PRICE : "-") ?></center></td>
						<td class="text-center" width="30%">
							<?php if(($result->KANIKE_NAME != 'General Kanike') && ($result->KANIKE_NAME != 'Shashwath Kanike')){ ?>
							<a style="border:none; outline: 0;" href="#" title="Edit Kanike" ><img style="border:none; outline: 0;" onclick = "editKanike(<?php echo $result->KS_ID.",'".$result->KANIKE_NAME."',".$result->KS_STATUS.",".$result->PRICE;?>)" src="<?php echo	base_url(); ?>images/edit_icon.svg"></a>&nbsp;&nbsp;
							<a style="border:none; outline: 0;" title="Deactive <?php echo $result->KANIKE_NAME; ?>"><img onclick="GetStatusChange('<?php echo $result->KS_STATUS; ?>','<?php echo $result->KANIKE_NAME; ?>','<?php echo $result->KANIKE_NAME; ?>','<?php echo $result->KS_ID; ?>');" style="cursor:pointer;border:none; outline: 0;" src="<?php echo base_url(); ?>images/delete.svg"></a>
							<?php }?>
						</td>	
					</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<form id="editKanikeForm" method="post" action="<?php echo site_url();?>admin_settings/Admin_setting/edit_kanike_setting">
	<input type="hidden" value="" name="ksid" id="ksid"/>
	<input type="hidden" value="" name="kname" id="kname"/>
	<input type="hidden" value="" name="kstatus" id="kstatus"/>
	<input type="hidden" value="" name="price" id="price"/>
</form>
<script>
	function editKanike(ksid,kname,kstatus,price){
		$('#ksid').val(ksid);
		$('#kname').val(kname);
		$('#kstatus').val(kstatus);
		$('#price').val(price);
		$('#editKanikeForm').submit();
	}

	function GetStatusChange(status,kanikeName,kanikeName,id) {
		if(status == 1) {
			alertKanike("Warning","Are you sure, you want to <strong>deactivate</strong> the <strong>"+ kanikeName +"</strong>?","Deactivate",true,id,0);
		} else {
			alertKanike("Warning","Are you sure, you want to <strong>activate</strong> the <strong>"+ kanikeName +"</strong>?","Activate",true,id,1);
		}
	}

	//ALERT DIALOG BOX
	function alertKanike(title,msg, btnTxt="Ok",close=false,action="",status) {
		$.confirm({
			title: title,
			content: msg,
			type: 'red',
			typeAnimated: true,
			closeIcon:close,
			buttons: {
				tryAgain: {
					text: btnTxt,
					btnClass: 'btn-red',
					action: function(){
						url = "<?php echo site_url(); ?>admin_settings/Admin_setting/update_kanike_status";
						$.post(url,{id:action, status:status}, function(e){
							if(e == 'Success') 
								location.href = "<?php echo site_url(); ?>admin_settings/Admin_setting/Kanike_setting";
							else
								location.href = "<?php echo site_url(); ?>admin_settings/Admin_setting/Kanike_setting";
						});	
					}
				},
			}
		});
	}
</script>
