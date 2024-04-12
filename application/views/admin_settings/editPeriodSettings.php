<div class="container-fluid">	
			<!-- START Content -->
			<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
			<div class="container-fluid container">
			<!-- START Row -->
				<div class="row form-group">
				<div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">               
					<h3><span class="icon icone-crop"></span>Edit Shashwath Period:</h3> 
				</div>
				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4" style = "padding-top:10px;">
				<a class="pull-right" style="border:none; outline:0;" href="<?=site_url() ?>admin_settings/Admin_setting/period_setting/" title="Back"><img style="border:none; outline: 0;" src="<?php echo base_url();?>images/back_icon.svg"></a>
				</div>
				</div>	
			<form id ="periodForm" action="<?php echo site_url(); ?>Shashwath/update_period_details/" enctype="multipart/form-data" method="post" accept-charset="utf-8">
			<div style = "padding-top:15px;">
					<div class="body-inner">    						
						<div class="row form-group">
							<div class="control-group col-md-4 col-lg-4 col-sm-4 col-xs-8">
								<label class="control-label color_black">Period Name </label>
								<div class="controls" style= "padding-bottom:30px">
								<input type="text" class="form-control form_contct2" value="<?php echo $pname; ?>" id="periodN" placeholder="" name="periodN" autofocus />	
								</div>
							</div> 
							<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-5">
								<label class="control-label color_black">Period </label>
								<input type="number" min='0' class="form-control form_contct2" value="<?php echo $period;?>" id="period" placeholder="" name="period" />
							</div>
						</div>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-left: 0px;">
						<div class="form-group">
							<label for="phone" style="font-size:16px;">Period Status </label></br>
							<div style = "padding-top:10px">
								<?php if($pstatus == 1){?>
								<input type="radio" name="pStatus" value="1" checked> Active&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<?php } else {?>
								<input type="radio" name="pStatus" value="1" > Active&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<?php } ?>
								<?php if($pstatus == 0){?>
								<input type="radio" name="pStatus" value="0" checked> Deactive
								<?php } else {?>
								<input type="radio" name="pStatus" value="0"> Deactive
								<?php } ?>
							</div>
						</div>
					</div>
					<input type="hidden" value=<?php echo $spid ?> name="sPid" /> 
					<div class="row form-group">
						<div class="control-group col-md-6 col-lg-6 col-sm-6 col-xs-12" style = "margin-top:25px;">
							<button type="button" id="submited" class="btn btn-default btn-md custom"><strong>UPDATE</strong></button>&nbsp;
							<button type="button" id="cancelButton" class="btn btn-default btn-md custom"><strong>CANCEL</strong></button>
						</div>
					</div>
				</div>
			</form>
		  </div>
</div>
<script>
	$('#periodN').keyup(function () {
		var $th = $(this);
		$th.val($th.val().replace(/[^A-Za-z0-9 ]/g, function (str) { return ''; }));
	});
	
</script>
<script>
	$('#submited').on('click',function(e){
		if($('#periodN').val() == '' || $('#period').val() == ''){
			alert('Information','Please enter details for Period Name and Period');
		} else 
			$('#periodForm').submit();
	});
	
	$('#cancelButton').on('click',function(e){
		window.location = "<?=site_url(); ?>admin_settings/Admin_setting/period_setting/";	
	});
		
	if(<?php echo $spid ?> == 1){
		$("#periodN").prop("readonly", true);
		$("#period").prop("readonly", true);
	}
</script>

