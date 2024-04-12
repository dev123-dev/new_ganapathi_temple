 <style>
 input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;

}
/*.new
{	
	border:none;
	border-radius: 0px;
	border-bottom: 1px solid #800000;
	font-size: 20px;
}*/
.heading
{
	font-size: 15px;
}
</style>
<?php error_reporting(0); ?>
<div class="container">
<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />

<div class="row form-group">							
	<div class="col-lg-12 col-md-12 col-sm-8 col-xs-8" style = "padding-right:0px;padding-top:10px;">
			<h3 style="margin-top:0px">Cheque Books of <?php echo $FGLH_NAME ?></h3>
	</div>
</div>

<div class="col-lg-12 col-md-12 col-sm-8 col-xs-8 pull-right text-right" style = "padding-right:0px;padding-bottom:10px;padding-top:10px; margin-top:-4em">
	<a style="margin-left: 9px;pull-right;"data-toggle="modal" data-target="#myModal" title="Add Bank Details"><img style="width:24px; height:24px" src="<?=site_url();?>images/add_icon.svg"/></a>
	<a style="text-decoration:none;cursor:pointer;pull-right; margin-left: 5px;" href="<?=site_url()?>finance/chequeDetails" title="Refresh"><img style="width:24px; height:24px" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
	<a  style="margin-left: 5px;  "class="pull-right" style="border:none; outline:0;"  title="Back" href="<?=$_SESSION['actual_link'] ?>"><img style="border:none; outline: 0; width:24px; height:24px" src="<?php echo base_url();?>images/back_icon.svg"></a>
</div>

<div class="row form-group">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
				  <tr>
					<th width="5%"><center>SI. No.</center></th>
					<th width="10%"><center>Cheque Book No.</center></th>
					<th width="6%"><center>From Number</center></th>
					<th width="5%"><center>To Number</center></th>
					<th width="6%"><center>No. Of Cheques</center></th>
					<th width="20%"><center>Cheque Book Name</center></th>
					<th width="5%"><center>Status</center></th>
					<th width="10%"><center>Operation</center></th>
				  </tr>
				</thead>
				<tbody>
					<?php $i=1;
					 foreach($chequeDetail as $result) { ?>
						<tr>
							<td><center><?php echo $i; ?></center></td>
							<td><center><a style="text-decoration:none;cursor:pointer;color:#800000;" onClick="indChequeDetail('<?=$result->FCBD_ID; ?>', '<?=$result->CHEQUE_BOOK_NAME; ?>')"><?php echo $result->CHEQUE_BOOK_NO; ?></a></center></td>
							<td><center><?php echo $result->FROM_NO; ?></center></td>
							<td><center><?php echo $result->TO_NO; ?></center></td>
							<td><center><?php echo $result->NO_OF_CHEQUE; ?></center></td>
							<td><?php echo $result->CHEQUE_BOOK_NAME; ?></td>
							<td><?php echo $result->FCBD_STATUS; ?></td>
							<td>
								<?php if($result->FCBD_STATUS == "Available") { ?>
									<center><a  style="margin-left: 5px; " style="border:none; outline:0;"  title="Activate Cheque Book" onClick="activateCheque('<?=$result->FCBD_ID; ?>')" ><img style="border:none; outline: 0; width:24px; height:24px" src="<?php echo base_url();?>images/check_icon.svg"></a></center>
								<?php } ?>
							</td>
						</tr>
					<?php $i++; 
					}  ?>
				</tbody>
			</table>
		</div>
		<div class="row">
			<ul class="pagination pagination-sm" style="margin-left:15px;margin-top: 0em;">
				<?=$pages; ?>
			</ul>
			<?php if($chequeCount != 0) { ?>
				<label  class="pull-right" style="font-size:18px;margin-right:15px;margin-top: 0em;">Total Cheque Books: <strong><?php echo $chequeCount ?></strong></label>
			<?php } else { ?>
				<label> </label>
			<?php } ?>
		</div>
	</div>
</div>
</div>



<form id="frmAddChequeDetails" action="<?=site_url()?>finance/addAddChequeDetails" method="post">

	<!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">


					<div class="container-fluid container" id="bankdetail"style="">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-left: 0px;">
							<div class="form-group">
								<br>
								<label for="comment" style="text-decoration: ;width: 350px; margin-left: -0.5em;"><span style="font-size: 18px;text-align: center;">Add Cheque Details for </span><span style="color:#800000;font-size: 20px;"><?php echo $BANK_NAME ?></span></label></br>
							</div>
						</div>
						<div class="row form-group">
							<div class="control-group col-md-2 col-lg-2 col-sm-2 col-xs-6">
								<label  class="heading" for="comment" style="height: 30px; ">Name of Cheque Book:<span style="color:#800000;">*</span></label>	
							</div>		
							<div class="control-group col-md-4 col-lg-6 col-sm-4 col-xs-6">
								<input class="form-control form_contct3" type="text" name="chkname" id="chkname" placeholder="" autocomplete="off"  style="height: 30px;width:50%;margin-left: -10px;font-size: 16px;">
							</div>
						</div>
						<div class="row form-group">
							<div class="control-group col-md-2 col-lg-2 col-sm-2 col-xs-6">				               
								<label class="heading" for="comment" style="height: 30px; ">Cheque Book Number:<span style="color:#800000;">*</span></label>
							</div>
							<div class="control-group col-md-4 col-lg-6 col-sm-4 col-xs-6">

								<input class="form-control form_contct3" type="text" name="chkbookno" id="chkbookno"  maxlength="12" size="12" placeholder="" autocomplete="off" style="height: 30px;  width:50%;margin-left: -12px;font-size: 16px;">
								<!-- onkeypress="return isNumberKey(event)" -->
							</div>
						</div>
						<div class="row form-group">

							<div class="control-group col-md-2 col-lg-2 col-sm-2 col-xs-6">			                   
								<label  class="heading" for="comment" style="height: 30px; width: 70%">From Number:<span style="color:#800000;">*</span></label>
							</div>
							<div class="control-group col-md-4 col-lg-4 col-sm-4 col-xs-6">

								<input class="form-control form_contct3" type="text" name="fromno" id="fromno" onkeypress="return isNumberKey(event)"  onkeyup="chkno()"  placeholder="" autocomplete="off" min="0" style="height: 30px; width:30%;margin-left:-12px;font-size: 16px;" maxlength="6">
							</div>
						</div>
						<div class="row form-group">

							<div class="control-group col-md-2 col-lg-2 col-sm-2 col-xs-6">				                    
								<label  class="heading" for="comment" style="height: 30px;width: 70%">To Number:<span style="color:#800000;">*</span></label>
							</div>
							<div class="control-group col-md-4 col-lg-4 col-sm-4 col-xs-6">
							
								<input class="form-control form_contct3" type="text" name="tono" id="tono"   onkeypress="return isNumberKey(event)" onkeyup="chkno()" placeholder="" autocomplete="off"  style="height: 30px;  width:30%;margin-left:-13px;font-size: 16px;"  minlength="4" maxlength="6">
							</div>
						</div>
						<div class="row form-group">

							<div class="control-group col-md-2 col-lg-2 col-sm-2 col-xs-6">				                   
								<label  class="heading" for="comment" style="height: 30px;width: 70%">No of Cheque:</label>
							</div>
							<div class="control-group col-md-4 col-lg-4 col-sm-4 col-xs-6">

								<input class="form-control form_contct3" type="text" name="numberofchk" id="numberofchk" placeholder="" autocomplete="off"  style="height: 30px; width:30%;margin-left:-13px;font-size: 16px; " readonly="readonly" >
							</div>
						</div>
							<input type="hidden" id="FGLH_ID"  name="FGLH_ID" value="<?php echo $FGLH_ID ?>">
							<input type="hidden" id="bankcheque"  name="bankcheque" value="<?php echo $bankcheque ?>">
						</div>

					</div>  
					<div class="">
						<span style="margin-left: 15px;color:red;font-weight: bold" id="bid">* Please enter all mandatory feilds</span>
					</div>
					 <div class="modal-footer" style="text-align:left;">
		            	<label>Are you sure you want to save..?</label>
		            	<br/>
		            	<button type="button" style="width: 8%;" class="btn " id="submit2" onclick="validateAddCheque()">Yes</button>
		            	<button type="button" style="width: 8%;" class="btn " data-dismiss="modal">No</button>
		            	<!-- <button type="button" style="width: 8%;" class="btn " onclick="document.getElementById('frmAddChequeDetails').submit();">Yes</button> -->
		            </div>
				</div>

			</div>

		</div>
	</div>
</form>

<form id="chequeDetailForm" action="" method="post">
	<input type="hidden" id="FCBD_ID" name="FCBD_ID" />
	<input type="hidden" id="CHEQUE_BOOK_NAME" name="CHEQUE_BOOK_NAME" />
</form>


<form id="activateChequeForm" action="" method="post">
	<input type="hidden" id="fcbdid" name="fcbdid" />
	<input type="hidden" id="baseurl" name="baseurl" value="<?php echo $base_url ?>" />
</form>


<script>
	function indChequeDetail(FCBD_ID,CHEQUE_BOOK_NAME){
		$('#FCBD_ID').val(FCBD_ID);
		$('#CHEQUE_BOOK_NAME').val(CHEQUE_BOOK_NAME);
		$('#chequeDetailForm').attr('action','<?=site_url()?>finance/individualChequeDetails');
		$('#chequeDetailForm').submit();
	}

	function activateCheque(FCBD_ID){
		$('#fcbdid').val(FCBD_ID);
		$('#activateChequeForm').attr('action','<?=site_url()?>finance/activateChequeBook');
		$('#activateChequeForm').submit();
	}

	function chkno() {
		 if (txtFirstNumberValue == "")
           txtFirstNumberValue = 0;
       if (txtSecondNumberValue == "")
           txtSecondNumberValue = 0;

      var txtFirstNumberValue = document.getElementById('fromno').value;
      var txtSecondNumberValue = document.getElementById('tono').value;
      var result = parseInt(txtSecondNumberValue)-parseInt(txtFirstNumberValue)+1;
      if (!isNaN(result)) {
         document.getElementById('numberofchk').value = result;
    }
 //    function validNum(input){
	// 	var regex=/[^0-9 ]/gi;
	// 	input.value=input.value.replace(regex,"");
	// }
}

function isNumberKey(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;

	return true;
}
 function validateAddCheque() {
   	let chkname = $('#chkname').val()
    let chkbookno = $('#chkbookno').val()
    let numberofchk = $('#numberofchk').val();
    let fromno = $('#fromno').val();
    let tono = $('#tono').val();
   
    let url = "<?=site_url()?>finance/addAddChequeDetails";
     
     if($('#chkname').val() == "" ) {
		$('#bid').html("*Please Enter Chequename");
		  $('#chkname').css('border-color', "#FF0000");
		  return ;
    } if($('#chkbookno').val() == "" ) {
		$('#bid').html("*Please Enter Cheque Book Number");
		$('#chkbookno').css('border-color', "#FF0000");
		  return ;
    } if($('#fromno').val() == "" ) {
		$('#bid').html("*Please Enter From Number");
		$('#fromno').css('border-color', "#FF0000");
		  return ;
    } if($('#tono').val() == "" ) {
		$('#bid').html("*Please Enter To Number");
		$('#tono').css('border-color', "#FF0000");
		  return ;
    } if(numberofchk <= 0) {
   		$('#bid').html("Cheque Number cannot be zero or less");
      		return;
    } else {
    	document.getElementById('frmAddChequeDetails').submit();
    }
}
	
</script>