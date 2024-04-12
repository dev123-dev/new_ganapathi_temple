<div class="container-fluid">	
<!-- START Content -->
<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png"/>
	<div class="container-fluid container">
		<!-- START Row -->
		<div class="row form-group">
			<div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">               
				<h3><span class="icon icone-crop"></span>Edit Calendar Details</h3> 
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4" style = "padding-top:10px;">
			<a class="pull-right" style="border:none; outline:0;" href="<?=site_url() ?>admin_settings/Admin_setting/calendar_display/" title="Back"><img style="border:none; outline: 0;" src="<?php echo base_url();?>images/back_icon.svg"></a>
			</div>
		</div>
		<form id = "calForm" action="<?php echo site_url(); ?>Shashwath/update_Calendar_details/" enctype="multipart/form-data" method="post" accept-charset="utf-8">			<div class="col-lg-12 col-md-8 col-sm-12 col-xs-12" style="padding-left: 0px;padding-top:15px;">
							<div class="col-lg-3 col-md-6 col-sm-5 col-xs-12" style="padding-left:0px;">
								<div class="col-lg-12 col-md-9 col-sm-6 col-xs-12" style="padding-left:0px;padding-bottom:23px;">
									<label class="control-label color_black">Calendar Start Date</label>
								</div>
								<div class="col-lg-9 col-md-8 col-sm-6 col-xs-8" style="padding-left:0px;">
									<div class="input-group input-group-sm">
										<input id="startDate" name="calendarStartDate" type="text" value="<?php echo @$calStartDate?>" class="form-control"  placeholder="dd-mm-yyyy" readonly="readonly"/>
									</div>
								</div>
							</div>
							<div class="col-md-6 col-lg-3 col-sm-5 col-xs-12" style="padding-left:0px;">
								<div class="col-lg-12 col-md-9 col-sm-8 col-xs-12" style="padding-left:0px;padding-bottom:23px;">
									<label class="control-label color_black">Calendar End Date</label>
								</div>
								<div class="col-lg-9 col-md-8 col-sm-6 col-xs-8" style="padding-left:0px;">
									<div class="input-group input-group-sm">
										<input id="endDate" type="text" name="calendarEndDate" value="<?php echo @$calEndDate?>" class="form-control" placeholder="dd-mm-yyyy" readonly="readonly"/>
									</div>
								</div>
							</div>
					</div>
					<div class="col-md-5 col-lg-3 col-sm-12 col-xs-8" style="padding-left:0px;padding-top:40px;">
						<div class="col-md-12 col-lg-8 col-sm-12 col-xs-8" style="padding-left:0px;"><label class="control-label color_black">ROI</label></div>
						<div class="col-md-6 col-lg-8 col-sm-3 col-xs-11" style="padding-left:0px;padding-right:0px;"><input type="number" min='0' class="form-control form_contct2" value="<?php echo $calRoi?>" id="calRoi" name="rateOfInterest" placeholder=""/></div>
					</div>
					<input type="hidden" value="<?php echo $calId?>" name="calendarId" />		
					<div class="row form-group">
						<div class="control-group col-md-12 col-lg-12 col-sm-12 col-xs-12" style = "margin-top:25px;padding-top:30px;">
							<button type="button" id="submited" class="btn btn-default btn-md custom"><strong>UPDATE</strong></button>&nbsp;
							<button type="button" id = "cancelButton" class="btn btn-default btn-md custom"><strong>CANCEL</strong></button>
						</div>
					</div>
		</form>
	</div>
</div>
<script>
$('#submited').on('click',function(e){
	if($('#calRoi').val() == ''){
		alert('Information','Please enter details for Rate of Interest');
	} else 
		$('#calForm').submit();
});

$('#cancelButton').on('click',function(e){
	window.location = "<?=site_url(); ?>admin_settings/Admin_setting/calendar_display/";	
});
</script>