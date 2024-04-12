<?php error_reporting(0); ?>
<div class="container">
<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
<div class="row form-group">							
	<div class="col-lg-12 col-md-12 col-sm-8 col-xs-8" style = "padding-right:0px;padding-top:10px;">
			<h3 style="margin-top:0px">Shashwath Calendar Details</h3>
	</div>
</div>
<div class="col-offset-lg-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-right text-right" style = "padding-right:0px;padding-bottom:0px; margin-top:-3em">
	<a style="margin-left: 9px;pull-right;" href="<?=site_url()?>admin_settings/Admin_setting/add_calendar" title="Add calendar"><img style="width:24px; height:24px" src="<?=site_url();?>images/add_icon.svg"/></a>
	<a style="text-decoration:none;cursor:pointer;pull-right;" href="<?=site_url()?>admin_settings/Admin_setting/calendar_display/" title="Refresh"><img style="width:24px; height:24px" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
</div>
<div class="row form-group">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
				  <tr>
					<th width="20%"><center>Calendar Start Date</center></th>
					<th width="20%"><center>Calendar End Date</center></th>
					<th width="20%"><center>Calendar ROI</center></th>
					<th width="10%"><center>Operations</center></th>
				  </tr>
				</thead>
				<tbody>
					<?php foreach($calendar as $result) { ?>
						<tr>
							<td><center><?php echo $result->CAL_START_DATE; ?></center></td>
							<td><center><?php echo $result->CAL_END_DATE; ?></center></td>
							<td><center><?php echo $result->CAL_ROI; ?></center></td>
							<?php if($result->EDIT_STATUS == 1) { ?>
							<td><center><a style="border:none; outline: 0;" href="#" onclick = "viewcalendar(<?php echo $result->CAL_ID.",'".$result->CAL_START_DATE."','".$result->CAL_END_DATE."',".$result->CAL_ROI.",".$result->EDIT_STATUS;?>)" title="View Calendar" ><img style="border:none; outline: 0;" src="<?php echo base_url(); ?>images/view_icon.png"></a>&nbsp;&nbsp;
							<a style="border:none; outline: 0;" href="#" title="Edit Period" onclick = "editcalendar(<?php echo $result->CAL_ID.",'".$result->CAL_START_DATE."','".$result->CAL_END_DATE."',".$result->CAL_ROI;?>)" ><img style="border:none; outline: 0;" src="<?php echo base_url(); ?>images/edit_icon.svg"></a></center>
							</td>
							<?php } else { ?>
							<td><center><a style="border:none; outline: 0;" href="#" onclick = "viewcalendar(<?php echo $result->CAL_ID.",'".$result->CAL_START_DATE."','".$result->CAL_END_DATE."',".$result->CAL_ROI.",".$result->EDIT_STATUS;?>)" title="View Calendar" ><img style="border:none; outline: 0;" src="<?php echo base_url(); ?>images/view_icon.png"></a>&nbsp;&nbsp;
							</center></td>
							<?php } ?>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<div class="pull-right" style="padding-right:0px;">
		<?php if($calendarCount != 0) { ?>
			<label  style="font-size:18px;margin-top:1em;">Total Records: <strong style="font-size:18px"><?php echo $calendarCount; ?></strong></label>
		<?php } else { ?>
			<label> </label>
		<?php } ?>
		</div>
		<ul class="pagination pagination-sm">
			<?=$pages; ?>
		</ul>
	</div>
</div>
</div>
<form id="editPeriodForm" method="post" action="<?php echo site_url();?>Shashwath/editCalendar">
	<input type="hidden" value="" name="calId" id="cal_id"/>
	<input type="hidden" value="" name="calstDate" id="cal_stdate"/>
	<input type="hidden" value="" name="calEndDate" id="cal_enddate"/>
	<input type="hidden" value="" name="calRoi" id="cal_roi"/>
</form>

<form id="ViewForm" method="post" action="<?php echo site_url();?>admin_settings/Admin_setting/getCalendarRecords">
	<input type="hidden" value="" name="calId" id="cal_id2"/>
	<input type="hidden" value="" name="calstDate" id="cal_stdate2"/>
	<input type="hidden" value="" name="calEndDate" id="cal_enddate2"/>
	<input type="hidden" value="" name="calRoi" id="cal_roi2"/>
	<input type="hidden" value="" name="editStatus" id="edit_status"/>
</form>
<script>
	function editcalendar(calid,calstdate,calenddate,calroi){
		$('#cal_id').val(calid);
		$('#cal_stdate').val(calstdate);
		$('#cal_enddate').val(calenddate);
		$('#cal_roi').val(calroi);
		$('#editPeriodForm').submit();
	}
	function viewcalendar(calid,calstdate,calenddate,calroi,editstatus){
		$('#cal_id2').val(calid);
		$('#cal_stdate2').val(calstdate);
		$('#cal_enddate2').val(calenddate);
		$('#cal_roi2').val(calroi);
		$('#edit_status').val(editstatus);
		$('#ViewForm').submit();
	}
</script>
