
<?php error_reporting(0); ?>
<div class="container">
<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />

<div class="row form-group">							
	<div class="col-lg-12 col-md-12 col-sm-8 col-xs-8" style = "padding-right:0px;padding-top:10px;">
			<h3 style="margin-top:0px">Add Committee</h3>
	</div>
</div>

<div class="col-lg-12 col-md-12 col-sm-8 col-xs-8 pull-right text-right" style = "padding-right:0px;padding-bottom:10px;padding-top:10px; margin-top:-4em">
	<!-- <a style="margin-left: 9px;pull-right;"data-toggle="modal" data-target="#myModal" title="Add Bank Details"><img style="width:24px; height:24px" src="<?=site_url();?>images/add_icon.svg"/></a> -->
	<a style="text-decoration:none;cursor:pointer;pull-right; margin-left: 5px;" href="<?=site_url()?>finance/addCommittee" title="Refresh"><img style="width:24px; height:24px" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
</div>

<div class="row form-group">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
				  <tr>
					<th width="10%"><center>Committee Id</center></th>
					<th width="20%"><center>Committee Name</center></th>
					<th width="10%"><center>Operation</center></th>
				  </tr>
				</thead>
				<tbody>
					<?php foreach($AllCommittee as $result) { ?>
						<tr>
							<td><center><?php echo $result->COMP_ID; ?></center></td>
							<td><center><?php echo $result->COMP_NAME; ?></center></td>
							<td class="text-center" width="10%"><a style="border:none; outline: 0;" href="#" title="Edit Committee Name" ><img style="border:none; outline: 0;" onclick = "editCommitteeName(<?php echo $result->COMP_ID.",'".$result->COMP_NAME."'";?>)" src="<?php echo	base_url(); ?>images/edit_icon.svg"></a></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
</div>

<form id="frmAddCommitteeDetails" action="<?=site_url()?>finance/addCommitteeDetails" method="post">
	<!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<div class="container-fluid container" id="comitteeDetail"style="">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-left: 0px;">
							<div class="form-group">
								<br>
								<label for="comment" style="text-decoration: ;width: 350px; margin-left: -0.5em;"><span style="font-size: 18px;text-align: center;">Add Committee </span></label></br>
							</div>
						</div>
						<div class="row form-group">
							<div class="control-group col-md-2 col-lg-2 col-sm-2 col-xs-6">
								<label  class="heading" for="comment" style="height: 30px;margin-left: -0.5em; ">Committee Name :</label>	
							</div>		
							<div class="control-group col-md-4 col-lg-4 col-sm-4 col-xs-6">
								<input class="form-control form_contct3" type="text" name="committeename" id="committeename" placeholder="" autocomplete="off"  style="height: 20px;width:100%;margin-left: -50px;font-size: 17px;">
							</div>
						</div>
					</div>
					<div class="">
						<span style="margin-left:10px;color:red;font-weight: bold" id="bid"></span>
					</div>
				</div>  
				 <div class="modal-footer" style="text-align:left;">
	            	<label>Are you sure you want to save..?</label>
	            	<br/>
	            	<button type="button" style="width: 8%;" class="btn " id="submit2" onclick="validateAddCommittee()">Yes</button>
	            	<button type="button" style="width: 8%;" class="btn " data-dismiss="modal">No</button>
	            </div>
			</div>
		</div>
	</div>
</form>

<form id="editformCommittee" action="<?=site_url()?>finance/updateCommitteeName" method="post">
	<!-- Modal -->
	<div id="editCommitteeNameModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<div class="container-fluid container" id="comitteeDetail"style="">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-left: 0px;">
							<div class="form-group">
								<br>
								<label for="comment" style="text-decoration: ;width: 350px; margin-left: -0.5em;"><span style="font-size: 18px;text-align: center;">Edit Committee </span></label></br>
							</div>
						</div>
						<div class="row form-group">
							<div class="control-group col-md-2 col-lg-2 col-sm-2 col-xs-6">
								<label  class="heading" for="comment" style="height: 30px;margin-left: -0.5em; ">Committee Name :</label>	
							</div>		
							<div class="control-group col-md-4 col-lg-4 col-sm-4 col-xs-6">
								<input class="form-control form_contct3" type="text" name="editCommitteeName" id="editCommitteeName" placeholder="" autocomplete="off"  style="height: 20px;width:100%;margin-left: -50px;font-size: 17px;" required>
							</div>
							<input type="hidden" id="compid" name="compid" />
						</div>
					</div>
				</div>  
				 <div class="modal-footer" style="text-align:left;">
	            	<button type="submit" id="submit" class="btn btn-default">Edit</button>
					<button type="button" class="btn" data-dismiss="modal">Cancel</button>
	            </div>
			</div>
		</div>
	</div>
</form>

<script>
 	function validateAddCommittee() {
	   	let committeename = $('#committeename').val();  
	     if($('#committeename').val() == "" ) {
			$('#bid').html("*Please Enter Committee Name");
			  $('#committeename').css('border-color', "#FF0000");
			  return ;
	    } else {
	    	document.getElementById('frmAddCommitteeDetails').submit();
	    }
	}

	function editCommitteeName(compid,compname){
		$('#compid').val(compid);
		$('#editCommitteeName').val(compname);
		$('#editCommitteeNameModal').modal();
	}
	
</script>