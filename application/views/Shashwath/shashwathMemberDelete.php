<?php error_reporting(0); //print_r($members); ?>
<div style="clear:both;" class="container">
	<img class="img-responsive bgImg2 bg1" src="<?=site_url()?>images/TempleLogo.png" />
	
	<div class="row form-group">							
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
			<span class="eventsFont2">Delete Shashwath Member</span>				
			<div class="col-lg-8 col-md-6 col-sm-4 col-xs-12 pull-right text-right" style="padding:0px 0px 0px;">
				<?php if(isset($_SESSION['member_actual_link'])) { ?>
					<a style="margin-left: 9px;pull-right;" href="<?=$_SESSION['member_actual_link'] ?>" title="Back"><img style="width:24px; height:24px" src="<?=site_url();?>images/back_icon.svg"/></a>	
				<?php } ?>				
			</div>
		</div>
	</div>	
	
	<div  class="container">
		<div class="row form-group">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-left:0px;margin-top:2em;">
				<?php if($members[0]->SM_NAME !='' ) {?>
					<div class= "col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="form-group" >
							<label >Name: <span><?php echo str_replace('"','&#34;',$members[0]->SM_NAME); ?></span></label>	 
						</div>
					</div>
				<?php } if($members[0]->SM_PHONE !='' || $members[0]->SM_PHONE2 !=''){ ?>
					<div class= "col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="form-group" >
							<label >Phone(Additional): <span><?php echo $members[0]->SM_PHONE; ?> <?php echo $members[0]->SM_PHONE2;?></span></label>	 
						</div>
					</div>
				<?php } if($members[0]->SM_RASHI !=''){ ?>
					<div class= "col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="form-group" >
							<label >Rashi: <span><?php echo $members[0]->SM_RASHI; ?></span></label>	 
						</div>
					</div>
				<?php } if($members[0]->SM_NAKSHATRA !=''){ ?>
					<div class= "col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="form-group" >
							<label >Nakshathra: <span><?php echo $members[0]->SM_NAKSHATRA; ?></span></label>	 
						</div>
					</div>
				<?php } if($members[0]->SM_GOTRA !=''){ ?>
					<div class= "col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="form-group" >
							<label >Gotra: <span><?php echo $members[0]->SM_GOTRA; ?></span></label>	 
						</div>
					</div>
				<?php } if($members[0]->SM_ADDR1 !='' || $members[0]->SM_ADDR2 !='' || $members[0]->SM_CITY !='' || $members[0]->SM_STATE !='' || $members[0]->SM_PIN !='' || $members[0]->SM_COUNTRY !=''){ ?>
					<div class= "col-lg-12 col-md-6 col-sm-6 col-xs-12">
						<div class="form-group" >
							<label >Address: <span><?php echo $members[0]->SM_ADDR1.','.$members[0]->SM_ADDR2.','.$members[0]->SM_CITY .','. $members[0]->SM_STATE.','.$members[0]->SM_COUNTRY.','.$members[0]->SM_PIN; ?></span></label>	 
						</div>
					</div>
				<?php } if($members[0]->REMARKS !=''){ ?>
					<div class= "col-lg-12 col-md-6 col-sm-6 col-xs-12">
						<div class="form-group" >
							<label >Remarks: <span><?php echo $members[0]->REMARKS; ?></span></label>	 
						</div>
					</div>
				<?php } ?>		
			</div>
			<?php $i; ?>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-left:0px;margin-top:2em;">								
				<div class="table-responsive">
					<table id="eventSeva" class ="table-bordered" >
						<thead>
							<tr>
								<th width="2%"><center>Sl.No</center></th>
								<th width="2%"><center>New RNo (Old RNo)</center></th>
								<th width="2%"><center>Receipt Date</center></th>
								<th width="2%"><center>Deity Name.</center></th>
								<th width="2%"><center>Seva Name</center></th>
								<th width="2%"><center>Qty</center></th>
								<th width="2%"><center>Corpus</center></th>
								<th width="2%"><center>Date</center></th>
								<th width="2%"><center>Thithi</center></th>
								<th width="2%"><center>Week/Month</center></th>	
								<th width="2%"><center>Purpose</center></th>
							</tr>
						</thead>
						<tbody id="eventUpdate">
							<?php $i = 1; ?>
							<?php foreach ($members as $result) { 
								?> 
								<tr>
									<td width="2%"><center><?php echo $i; ?></center></td>
									<td> <center><?php if($result->SS_RECEIPT_NO != "" ) echo $result->RECEIPT_NO . " (".$result->SS_RECEIPT_NO.")"; else echo $result->RECEIPT_NO; ?></center></td>
									<td> <center><?php echo $result->SS_RECEIPT_DATE;?></center></td>
									<td><center><?php echo $result->DEITY_NAME; ?></center></td>
									<td><center><?php echo $result->SEVA_NAME; ?></center></td>
									<td> <center><?php echo $result->SEVA_QTY; ?></center></td>

									<?php if($result->CORPUS_CNT > 1) {?>
										<td><center><a style="color: red;" href="#" onclick="corpusRaiseDetails('<?=$result->SS_ID; ?>')" data-toggle="modal" data-target="#modalCorpusHistory" ><u><?php echo $result->RECEIPT_PRICE;?></u></a></center></td>


									<?php } else if($result->CORPUS_CNT == 1) { ?>
										<td><center><?php echo $result->RECEIPT_PRICE; ?></center></td>
									<?php } ?>



									<td><center><?php echo $result->ENG_DATE; ?></center></td>
									<td><?php echo $result->THITHI_CODE; ?></td> 
									<td><?php echo $result->EVERY_WEEK_MONTH; ?></td> 
									<td width="2%"><center><?php echo $result->SEVA_NOTES; ?></center></td>

								</tr>
								<?php $i++; } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>	
			<div class="modal-footer" >
			    <center><button type="button" class="btn btn-default btn-lg" style="cursor: pointer;" onclick="deleteconfirmModal()">Verify & Delete</button></center>
			</div>
		</div>
	</div>
</div>
<div id="modalCorpusHistory" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><b>Corpus Raise History</b></h4>
			</div>
			<div class="modal-body viewCorpusHistory"  style="overflow-y: auto;max-height: 80vmin;">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div id="modalDeleteConfirm" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><b>Shashwath Member Delete</b></h4>
			</div>
			<form id="deleteForm" action="<?=site_url();?>Shashwath/delete_shashwath_member_submit" id="deleteForm" class="form-group" role="form" enctype="multipart/form-data" method="post">

			<div class="modal-body viewCorpusHistory"  style="overflow-y: auto;max-height: 80vmin;">
				<input type="hidden" id="memberDeleteId" name="memberDeleteId" value="<?php echo $members[0]->SM_ID;?>"/>
				
				<div style="clear:both;" class="form-group">
					<div class="form-group col-lg-12 col-md-6 col-sm-6 col-xs-6">
						<label for="inputLimit" ><span style="font-weight:600;">Reason for Delete:<span style="color:#800000;">*</span> </span> </label>
						<textarea class="form-control" rows="5" name="deleteReason" id="deleteReason" placeholder="Reason for Seva Delete" style="width:100%;height:100%;resize:none;" required></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" id="deleteSubmit" class="btn btn-default">DELETE</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
			</div>
		</form>
		</div>
	</div>
</div>

<!-- <form id="deleteFormSubmit" action="<?=site_url();?>Shashwath/delete_shashwath_member_submit" method="post">
	<input type="hidden" id="memberDeleteId" name="memberDeleteId" value="<?php echo $members[0]->SM_ID;?>"/>
</form> -->
<script src="<?=site_url()?>js/autoComplete.js"></script>
<script>
function corpusRaise(ssId,receipt,sName,namePhne,rec_price,Shashmin_price){
	SSID = ssId;
	let namePhone = namePhne;
	let receiptno = receipt;
	let sevaName = sName;
	let name = namePhne;
	$('#name').text(namePhone);
	$('#receipt').text(receiptno);
	$('#seva').text(sevaName);
	let corp = Math.ceil(Shashmin_price - rec_price);
	(corp <= 0 ? corp = 0:corp = corp);
	$('#corp').text("Rs. "+corp+"/-");
	$('#namePhone').val(namePhone);
	$('#seva_name').val(sevaName);
	$('#receipt_no').val(receiptno);
	$('#ssId').val(ssId);
	$("#corpusModal").modal();  
}
	/* raise corpus */
function corpusRaiseDetails(ssId){
	let SSID = ssId;
	let url = "<?=site_url()?>Shashwath/get_corpus_history";
	$.post(url, {'ss_id': SSID}, function (e) {

		e1 = e.split("|")
		if (e1[0] == "success") {
			arrCorpusDetails = JSON.parse(e1[1]);
			$('#viewCorpusDetails').html('');
			$('.viewCorpusHistory').html('<div class="table-responsive" style ="overflow-x:hidden;"><table class="table"><thead><tr><th style="border:1px solid #7d6363"><center>Sl. No.</center></th><th style="border:1px solid #7d6363"><center>R.No.</center></th><th style="border:1px solid #7d6363"><center>Receipt Date</center></th><th style="border:1px solid #7d6363"><center>Deity Name</center></th><th style="border:1px solid #7d6363"><center>Seva Name</center></th><th style="border:1px solid #7d6363"><center>Qty</center></th><th style="border:1px solid #7d6363"><center>Corpus</center></th></tr></thead><tbody id="viewCorpusDetails" ></tbody></table></div>');
			

			for (i = 0; i < arrCorpusDetails.length; ++i) {
				$('#viewCorpusDetails').append('<tr>');
				$('#viewCorpusDetails').append('<td style="border:1px solid #7d6363"><center>' + (i+1)  + '</center></td>');
				$('#viewCorpusDetails').append('<td style="border:1px solid #7d6363"><center>' + arrCorpusDetails[i].RECEIPT_NO + '</td>');
				$('#viewCorpusDetails').append('<td style="border:1px solid #7d6363"><center>' + arrCorpusDetails[i].RECEIPT_DATE + '</td>');
				$('#viewCorpusDetails').append('<td style="border:1px solid #7d6363"><center>' + arrCorpusDetails[i].DEITY_NAME + '</td>');
				$('#viewCorpusDetails').append('<td style="border:1px solid #7d6363"><center>' + arrCorpusDetails[i].SEVA_NAME + '</td>');
				$('#viewCorpusDetails').append('<td style="border:1px solid #7d6363"><center>' + arrCorpusDetails[i].SEVA_QTY + '</center></td>');
				$('#viewCorpusDetails').append('<td style="border:1px solid #7d6363"><center>' + arrCorpusDetails[i].RECEIPT_PRICE + '</center></td>');
				$('#viewCorpusDetails').append('</tr><br/>');
			}
		}
		else
			alert("Something went wrong, Please try again after some time");
	});
}

function deleteconfirmModal() {
	$('#modalDeleteConfirm').modal();	 
}

// function deleteShashwathDetails(smId) {
// 	$('#memberDeleteId').val(smId);
// 	$('#memberDeleteId').val(smId);
//     $('#deleteFormSubmit').submit();	 
// }

</script>