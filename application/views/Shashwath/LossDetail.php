<style>
	.datepicker {
      z-index: 1600 !important; /* has to be larger than 1050 */
} .chequeDate2 {
	z-index: 1600 !important; /* has to be larger than 1050 */
}
</style>
	<div class="container">
	<div class="row form-group">
		<div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
			<span class="eventsFont2">Detailed Loss Report</span>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
			<a class="pull-right" style="border:none; outline:0;"  href="<?=$_SESSION['actual_link'] ?>" title="Back"><img style="border:none; outline: 0;" src="<?php echo base_url(); ?>images/back_icon.svg"></a>
		</div>
	</div>
	<div class="form-group">
			<span style="font-size:18px;"><strong>Receipt No: </strong><?php echo $lossDetail[0]->SS_RECEIPT_NO;?></span><br/><br/>
			<span style="font-size:18px;"><strong>Name: </strong><?php echo $lossDetail[0]->NAME_PHONE;?></span>
			<button class ="btn btn-default btn-sm  pull-right" id="corpusraise" style="width:104px" onclick="corpusRaise();" >Corpus Raise</button>
			<button class ="btn btn-default btn-sm  pull-right" id="losspay"  style="width:104px; margin-right: 10px;" onclick="payLoss();" >Pay Loss</button>
	</div>
	<div class="clear:both;table-responsive">
		<table class="table table-bordered table-hover">
				<thead>
					<tr>				
						<!-- <th><center>Sl. No.</th> -->
						<th width="8%"><center>Date</center></th>
						<th><center>Deity Name</center></th>
						<th><center>Seva Name</center></th>	
						<th width="20%"><center>Qty * Price * NO of Seva = Total Seva Amt</center></th>
						<th><center>Seva Corpus</center></th>
						<th><center>Seva Interest</center></th>
						<th><center>Seva Loss</center></th>
					</tr>
				</thead>
				<tbody id="eventUpdate">
					<?php $count = 1; $sevaLoss = array();$soId = array(); 
					if(isset($lossDetail)){?>
						<?php foreach($lossDetail as $result) {?>
							<tr>
								<!-- <td><center><?php echo $count?></center></td> -->
								<?php if($result->CAL_TYPE == "Every"){?>
									<td><?php echo $result->FINANCIAL_YEAR;?></td>
								<?php } else {?>
									<td><?php echo $result->SO_DATE;?></td>
								<?php } ?>
								<!-- <td><?php echo $result->SS_RECEIPT_NO;?></td> -->
								<td><?php echo $result->SO_DEITY_NAME;?></td>
								<td><?php echo $result->SO_SEVA_NAME;?></td>
								<td><center><?php echo $result->SEVA_QTY." * ".$result->SO_PRICE." * ".$result->NUMSEVAS." = ".$result->TOTAL_SEVA_COST;?></center></td>
								<td><center><?php echo $result->SEVA_CORPUS;?></td>
								<td><center><?php echo $result->SEVA_INTEREST;?></td>
								<td><center><?php echo $result->SUM_SEVA_LOSS;?></center></td>
								<?php $sevaLoss[$count-1] = $result->SEVA_LOSS;?>
								<?php $soId[$count-1] = $result->SO_ID;?>
							</tr>	
							<?php $count++;}}?>		
						</tbody>
					</table>
		<ul class="pagination pagination-sm">
				<?=$pages;?>
		</ul>
	</div>
	<!--corpus topup-->	
<form action="<?=site_url();?>Receipt/addCorpusReceipt" id="addCorpus" method="post">
	<div class="modal fade" id="corpusModal" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
		<div class="modal-header">
		<h4 class="modal-title">Shashwath Seva Corpus Topup</h4>
		  <button type="button" class="close" data-dismiss="modal" style="margin-top:-10px;">&times;</button>
		</div>
		<div class="modal-body">
		  <p><b>Name : <span id="name" ></span></b></p>
		  <p><b>Seva Name : <span id="seva"></span></b></p>
		  <p><b>Additional Corpus : <span id="corp" name="corp"></span></b></p>
		  <p><b>Book Receipt No:</b> <input  autocomplete="off" type="text" class = "form_contct2" name="bookreceiptno" id="bookreceiptno" onkeyup="validNum(this)" maxlength="5"></p>
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-4">
					<b>Receipt Date:</b>
				</div>
				<div class="input-group input-group-sm form-group col-lg-4 col-md-3 col-sm-4">	
					<input autocomplete="none" type="text" class="form-control adlCrpBookDate" placeholder="dd-mm-yyyy" id="adlCrpBookDate" name="adlCrpBookDate" value="" />
					<div class="input-group-btn">
						<button class="btn btn-default adlCrpBookDate" id="adlCrpBookDate3" name="adlCrpBookDate3" type="button" >
							<i class="glyphicon glyphicon-calendar"></i>
						</button>
					</div>
				</div>
			</div>
		  <p><b>Your Corpus :</b> <input  autocomplete="off" type="text" class = "form_contct2" name="corpus" id="corpus" onkeyup="validNum(this)"></p>
			<div class="form-inline">
				<?php if($members[0]->IS_MANDALI == 1){ ?>
					<div class="form-group" style="margin-bottom: 5px">
						<label>Paid By:
							<span style="color:#800000;">*</span>
						</label>
						<select id="paidBy" name="paidBy" class="form-control">
							<option value="">Select Sevadhar</option>
							<?php   if(!empty($mandaliMembers)) {
								foreach($mandaliMembers as $row1) { ?> 
									<option value="<?php echo $row1->MM_ID;?>"><?php echo $row1->MM_NAME;?></option>
								<?php } } ?>
							</select>
						</div><br/>
					<?php } ?>
				<div class="form-group">
					<label for="modeOfPayment">Mode Of Payment:
						<span style="color:#800000;">*</span>
					</label>
					<select id="modeOfPayment" name="modeOfPayment" class="form-control">
						<option value="">Select Payment Mode</option>
						<option value="Cash">Cash</option>
						<option value="Cheque">Cheque</option>
						<option value="Direct Credit">Direct Credit</option>
						<option value="Credit / Debit Card">Credit / Debit Card</option>
					</select>
				</div>
				<div style="margin-top: 10px;display:none;margin-left: -14px;" id="showChequeList">
					<div style="padding-top: 15px;" class="control-group col-md-6 col-lg-6 col-sm-12 col-xs-12">
						<label for="name">Cheque No:
							<span style="color:#800000;">*</span>
						</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="text" class="form-control form_contct2" id="chequeNo" name="chequeNo" placeholder="" autocomplete="off">
					</div>

					<div style="padding-top: 15px;" class="control-group col-md-6 col-lg-6 col-sm-12 col-xs-12">
						<label for="rashi">Cheque Date:
							<span style="color:#800000;">*</span>
						</label>&nbsp;&nbsp;
						<div class="input-group input-group-sm">
							<input  type="text" id="chequeDate" name="checkdate" value="" class="form-control chequeDate2 form_contct2" placeholder="<?=date(" d-m-Y ")?>" autocomplete="off">
							<div class="input-group-btn">
								<button class="btn btn-default chequeDate" type="button">
									<i class="glyphicon glyphicon-calendar"></i>
								</button>
							</div>
						</div>
					</div>
					<div style="padding-top: 15px;clear: both;" class="control-group col-md-6 col-lg-6 col-sm-12 col-xs-12">
						<label for="number">Bank Name:
							<span style="color:#800000;">*</span>
						</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="text" class="form-control form_contct2" name="bank" id="bank" placeholder="" autocomplete="off">
					</div>
					<div style="padding-top: 15px;" class="control-group col-md-6 col-lg-6 col-sm-12 col-xs-12">
						<label for="nakshatra">Branch Name:
							<span style="color:#800000;">*</span>
						</label>&nbsp;&nbsp;
						<input type="text" class="form-control form_contct2"  name="branch" id="branch" placeholder="" autocomplete="off">
					</div>
				</div>
			<!-- laz new-->
						<div style="padding-top: 15px; display:none;margin-left: -14px;" id="showDebitCredit">
							<div class="form-group col-xs-10">
								<label for="bank">To Bank <span style="color:#800000;">*</span></label>&nbsp;&nbsp;
								<select id="DCtobank" name="DCtobank" class="form-control">
								<option value="0">Select Bank</option>
								<?php foreach($terminal as $result) { ?>
									<option value="<?=$result->FGLH_ID; ?>">
										<?=$result->FGLH_NAME; ?>
									</option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group col-xs-10">
								<label for="name">Transaction Id:
									<span style="color:#800000;">*</span>
								</label>&nbsp;&nbsp;
								<input type="text" class="form-control form_contct2" id="transactionId" placeholder="" name="transactionId">
							</div>
						</div>
						<!-- laz new-->

								<!-- //SLAP -->
						<!-- laz -->
						<div style="padding-top: 15px; display:none;margin-left: -14px;" id="showDirectCredit">
							<div class="form-group col-xs-10">
								<label for="bank">To Bank <span style="color:#800000;">*</span></label>&nbsp;&nbsp;
								<select id="tobank" name="tobank" class="form-control">
								<option value="0">Select Bank</option>
								<?php foreach($bank as $result) { ?>
									<option value="<?=$result->FGLH_ID; ?>">
										<?=$result->FGLH_NAME; ?>
									</option>
									<?php } ?>
							</select>
							</div>
						</div>
						<!-- laz.. -->
			</div>
			<div class="form-group" style="clear:both;margin-top:10px;padding-top:17px;">
				<label for="comment">Payment Notes:</label>
				<textarea class="form-control" rows="5" style="resize:none;" id="pymtNotes" name="paymentNotes"></textarea>
			</div>
			<input type="hidden" id="namePhone" name="namePhone" value="<?php echo $lossDetail[0]->NAME_PHONE;?>" />
			<input type="hidden" id="seva_name" name="seva_name" value="<?php echo $lossDetail[0]->SEVA_NAME;?>" />
			<input type="hidden" id="deityName" name="deityName" value="<?php echo $lossDetail[0]->DEITY_NAME;?>" />
			<input type="hidden" id="ssId" name="ssId" value="<?php echo $lossDetail[0]->SS_ID;?>"/>
			<input type="hidden" id="corpusCallFrom" name="corpusCallFrom" value="LossDetail"/>
		</div>
		<div class="modal-footer">
		  <input type="submit" class="btn btn-default" onclick="return validateCorpus();" value="Submit" />
		  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
		</div> 
	</div>
</div>
</form>	
<!--loss pay -->
<form action="<?=site_url();?>Receipt/payLossReceipt"  method="post">
<div class="modal fade" id="sevaLossModal" role="dialog">
	<div class="modal-dialog">
	  <!-- Modal content-->
		<div class="modal-content">
		<div class="modal-header">
		<h4 class="modal-title">Shashwath Seva Loss Pay</h4>
		  <button type="button" class="close" data-dismiss="modal" style="margin-top:-10px;">&times;</button>
		</div>
		<div class="modal-body">
		<p><b>Name : <span id="memberName" ></span></b></p>
		<p><b>Seva Name : <span id="sevaName"></span></b></p>
		<p><b>Current Total Loss : <span id="totalLoss" ></span></b></p>
		<p><b>Loss Amount :</b> <input type="text" class = "form_contct2" name="Loss_Amount" id="Loss_Amount" onkeyup="validNum(this)" autocomplete="off"/></p>
		<div class="form-inline">
			<div class="form-group">
				<label for="lossmodeOfPayment">Mode Of Payment:
					<span style="color:#800000;">*</span>
				</label>
				<select id="lossmodeOfPayment"  name="modeOfPayment" class="form-control">
					<option value="">Select Payment Mode</option>
					<option value="Cash">Cash</option>
					<option value="Cheque">Cheque</option>
					<option value="Direct Credit">Direct Credit</option>
					<option value="Credit / Debit Card">Credit / Debit Card</option>
				</select>
			</div>
			<div style="margin-top: 10px;display:none;margin-left: -14px;" id="lossshowChequeList">
				<div style="padding-top: 15px;" class="control-group col-md-6 col-lg-6 col-sm-12 col-xs-12">
					<label for="name">Cheque No:
						<span style="color:#800000;">*</span>
					</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="text" class="form-control form_contct2" name="chequeNo" id="chequeNo1" placeholder="" autocomplete="off">
				</div>

				<div style="padding-top: 15px;" class="control-group col-md-6 col-lg-6 col-sm-12 col-xs-12">
					<label for="rashi">Cheque Date:
						<span style="color:#800000;">*</span>
					</label>&nbsp;&nbsp;
					<div class="input-group input-group-sm">
						<input  type="text" name="Chequedate" id="Checkdate1" value="" class="form-control chequeDate2 form_contct2" placeholder="<?=date(" d-m-Y ")?>" autocomplete="off">
						<div class="input-group-btn">
							<button class="btn btn-default " type="button">
								<i class="glyphicon glyphicon-calendar"></i>
							</button>
						</div>
					</div>
				</div>

				<div style="padding-top: 15px;clear: both;" class="control-group col-md-6 col-lg-6 col-sm-12 col-xs-12">
					<label for="number">Bank Name:
						<span style="color:#800000;">*</span>
					</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="text" class="form-control form_contct2"  name="bank1" id="bank1" placeholder="" autocomplete="off">
				</div>

				<div style="padding-top: 15px;" class="control-group col-md-6 col-lg-6 col-sm-12 col-xs-12">
					<label for="nakshatra">Branch Name:
						<span style="color:#800000;">*</span>
					</label>&nbsp;&nbsp;
					<input type="text" class="form-control form_contct2" name="branch1" id="branch1"  placeholder="" autocomplete="off">
				</div>
			</div>

			<!-- laz new-->
						<div style="padding-top: 15px; display:none;margin-left: -14px;" id="lossshowDebitCredit">
							<div class="form-group col-xs-10">
								<label for="bank">To Bank <span style="color:#800000;">*</span></label>&nbsp;&nbsp;
								<select id="DCtobank1" name="DCtobank1" class="form-control">
								<option value="0">Select Bank</option>
								<?php foreach($terminal as $result) { ?>
									<option value="<?=$result->FGLH_ID; ?>">
										<?=$result->FGLH_NAME; ?>
									</option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group col-xs-10">
								<label for="name">Transaction Id:
									<span style="color:#800000;">*</span>
								</label>&nbsp;&nbsp;
								<input type="text" class="form-control form_contct2" id="transactionId1" placeholder="" name="transactionId1">
							</div>
						</div>
						<!-- laz new-->
			<!-- //SLAP -->
						<!-- laz -->
						<div style="padding-top: 15px; display:none;margin-left: -14px;" id="lossshowDirectCredit">
							<div class="control-group col-xs-10">
								<label for="bank">To Bank <span style="color:#800000;">*</span></label>&nbsp;&nbsp;
								<select id="tobank1" name="tobank1" class="form-control">
								<option value="0">Select Bank</option>
								<?php foreach($bank as $result) { ?>
									<option value="<?=$result->FGLH_ID; ?>">
										<?=$result->FGLH_NAME; ?>
									</option>
									<?php } ?>
							</select>
							</div>
						</div>
						<!-- laz.. -->
		</div>
			
		<div class="form-group" style="clear:both;margin-top:10px;padding-top:17px;">
			<label for="comment">Payment Notes:</label>
			<textarea class="form-control" rows="5" style="resize:none;" id="pymtNotes" name="paymentNotes"></textarea>
		</div>
		
		<input type="hidden" id="namePhone" name="namePhone" value="<?php echo $lossDetail[0]->NAME_PHONE;?>"/>
		<input type="hidden" id="seva_name" name="seva_name" value="<?php echo $lossDetail[0]->SEVA_NAME;?>"/>
		<input type="hidden" id="deityName" name="deityName" value="<?php echo $lossDetail[0]->DEITY_NAME;?>"/>
		<input type="hidden" id="sevaLoss" name="sevaLoss" value="<?php echo implode(",",$sevaLoss);?>"/>
		<input type="hidden" id="soId" name="soId" value="<?php echo implode(",",$soId);?>"/>
		<input type="hidden" id="ssId" name="ssId" value="<?php echo $lossDetail[0]->SS_ID;?>"/>
		<input type="hidden" id="corpusCallFrom" name="corpusCallFrom" value="LossDetail"/>
		<br/>
		</div>
		<div class="modal-footer">
			<div id="confirm" class="modal-footer text-left" style="text-align:left;clear: both;display:none;">
					<label>Are you sure you want to save..?</label>
					<br/>
					<input type="submit" class="btn btn-default sevaButton" id="submit" value="Yes" >
					<button style="width: 8%;" type="button" class="btn btn-default sevaButton" data-dismiss="modal">No</button>
			</div>
			<div id="save" class="modal-footer" style="clear: both;">
				<button type="button" id="submit"  class="btn btn-default"  onclick="return validateLoss();">SAVE</button>
			</div>
		</div>
		<!-- <div class="modal-footer">
		  <input type="submit" class="btn btn-default" onclick="return validateLoss();" value="Submit" />
		  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div> -->
		</div> 
	</div>
</div>
</form>			
</div>
<div class="container">
	<span style="float:left;margin-top: -3em;font-size:18px;" >Loss Paid:</span>
	    <?php if($lossPaid != 0) { ?>
		<a href="#"  style="margin-left:5em;margin-top: -3em;font-size:18px;text-decoration: none;"  data-toggle="modal" data-target="#modallossHistory" class="pull-left"><u style="color:#800000"> Rs. <?php echo $lossPaid; ?>/-</u></a> 
		<?php } else { ?>
			<span class="pull-left" style="margin-left:5em;margin-top: -3em !important;font-size:18px;"> Rs. <?php echo $lossPaid; ?>/-</span>
		<?php } ?>

	<span style="float:right;margin-top: -3em;font-size:18px;" class="pull-right">Outstanding Loss: <?php echo $lossDetail[0]->TOTAL_LOSS;?></span>
</div>

<div id="modallossHistory" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><b>Paid Loss Report</b></h4>
			</div>
			<div class="modal-body "  style="overflow-y: auto;max-height: 80vmin;overflow-x: auto;">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>				
							<th><center>Paid Date</center></th>
							<th><center>Receipt No</center></th>		
							<th><center>Amount</center></th>
						</tr>
					</thead>
					<tbody >
						<?php   $count = 1;
						if(isset($lossHistory)){?>
							<?php foreach($lossHistory as $result) {?>
								<?php if($result->AMOUNT!=0) {?>
								<tr>
									<!-- <td><center><?php echo $count?></center></td> -->
									<td><center><?php echo $result->RECEIPT_DATE;?></center></td>
									<td><center><?php echo $result->RECEIPT_NO;?></center></td>
									<td><center><?php echo $result->AMOUNT;?></center></td>

								</tr>	
								<?php } ?>	
							<?php $count++;}}?>		
							</tbody>
						</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
	<form id="corpusraiseformlossdetail" action=" " method="post">
		<input type="hidden"  id="nameph" name="nameph">
		<input type="hidden"  id="smphone" name="smphone"> 
		<input type="hidden"   id="deityIdName" name="deityIdName">
		<input type="hidden"  id="addr1" name="addr1">
		<input type="hidden"  id="addr2" name="addr2">
		<input type="hidden"  id="ssstate" name="ssstate">
		<input type="hidden"  id="sscity" name="sscity">
		<input type="hidden"  id="sccountry" name="sccountry">
		<input type="hidden"  id="ssid" name="ssid">
		<input type="hidden"  id="cpin" name="cpin">
		<input type="hidden"  id="sevaname" name="sevaname">
		<input type="hidden"  id="corpusraiseamt" name="corpusraiseamt">
		<input type="hidden"  id="smID" name="smID">
		<input type="hidden" id="baseurl" name="baseurl" value="<?php echo $base_url ?>">
		<input type="hidden" id="corpusCallFrom" name="corpusCallFrom" value="LossDetail"/>
	</form>	
<script>
    var ssId = "<?php echo $lossDetail[0]->SS_ID;?>";
    var namePhone = "<?php echo $lossDetail[0]->NAME_PHONE;?>";
    var sName = "<?php echo $lossDetail[0]->SEVA_NAME;?>";
    var totalLoss = "<?php echo $lossDetail[0]->TOTAL_LOSS;?>";
    var deityName = "<?php echo $lossDetail[0]->DEITY_NAME;?>";
	var sevaPrice = "<?php echo $lossDetail[0]->SEVA_COST;?>";
    var presentCorpus = "<?php echo $lossDetail[0]->TOTAL_CORP;?>";
    var noOfSevas = "<?php echo $lossDetail[0]->NO_OF_SEVAS;?>";
    var ROI = "<?php echo $lossDetail[0]->ROI;?>";
    var Shashmin_price = "<?php echo $lossDetail[0]->SHASH_PRICE;?>";
    var namePhne = "<?php echo $lossDetail[0]->SM_NAME;?>";
    var smphone = "<?php echo $lossDetail[0]->SM_PHONE;?>";
    var corpadd1 = "<?php echo $lossDetail[0]->SM_ADDR1;?>";
    var corpadd2 = "<?php echo $lossDetail[0]->SM_ADDR2;?>";
    var corpcity = "<?php echo $lossDetail[0]->SM_CITY;?>";
    var corpstate = "<?php echo $lossDetail[0]->SM_STATE;?>";
    var corpcountry = "<?php echo $lossDetail[0]->SM_COUNTRY;?>";
    var corppin = "<?php echo $lossDetail[0]->SM_PIN;?>";
    var SM_ID = "<?php echo $lossDetail[0]->SM_ID;?>";
    var shashSevaCost = "<?php echo $lossDetail[0]->SHASH_SEVA_COST;?>";
 

	function corpusRaise(){
		$('#nameph').text(namePhne);
		$('#addr1').val(corpadd1);
		$('#addr2').val(corpadd2);
		$('#sccity').val(corpcity);
		$('#ssstate').val(corpstate);
		$('#sccountry').val(corpcountry);
		$('#cpin').val(corppin);
		$('#ssid').val(ssId);
		$('#nameph').val(namePhne);

		$('#sevaname').val(sName);
	
		$('#deityIdName').val(deityName);
		
		$('#sevaId').val(ssId);
		$('#smphone').val(smphone);
		$('#smID').val(SM_ID);
	 //    var corp =((sevaPrice * 100)/ROI)*noOfSevas;
		// //if(presentCorpus < corp) {
		// corp = Math.ceil(corp - presentCorpus);
		/* }  else {
			corp = 0;
		}  */
		let corp=0;
		corp = Math.ceil(Shashmin_price - presentCorpus);
		if(corp <= 0){
			corp = ((sevaPrice * 100)/ROI)*noOfSevas;
			corp = Math.ceil(corp - presentCorpus);
		}	

		(corp <= 0 ? corp = 0:corp = corp);	
		$('#corp').text("Rs. "+corp+"/-");
		$('#corpusraiseamt').val(corp);

		
		$('#corpusraiseformlossdetail').attr('action','<?=site_url()?>Shashwath/shaswathaddcorpusdetails');
		$('#corpusraiseformlossdetail').submit();
	}
	
	function payLoss(){

		$('#memberName').text(namePhone);
		$('#sevaName').text(sName);
		$('#totalLoss').text(totalLoss);
		$("#sevaLossModal").modal();  

	}

	let lossmodeOfPayment = $('#lossmodeOfPayment option:selected').val();
	let toBank = $('#tobank option:selected').val();						//laz
	let flghBank = "";														//laz new
	let DCtoBank = $('#DCtobank option:selected').val();					//laz new
	
	/* raise corpus */
		$('#modeOfPayment').on('change', function () {						//laz
		if (this.value == "Cheque") {
			$('#showChequeList').fadeIn("slow");
			$('#showDebitCredit').fadeOut("slow");
			$('#showDirectCredit').fadeOut("slow");
		}
		else if (this.value == "Credit / Debit Card") {
			$('#showChequeList').fadeOut("slow");
			$('#showDebitCredit').fadeIn("slow");
			$('#showDirectCredit').fadeOut("slow");

		} 
		else if (this.value == "Direct Credit") {				
			$('#showChequeList').fadeOut("slow");
			$('#showDebitCredit').fadeOut("slow");
			$('#showDirectCredit').fadeIn("slow");
		}														
		else {
			$('#showChequeList').fadeOut("slow");
			$('#showDebitCredit').fadeOut("slow");
			$('#showDirectCredit').fadeOut("slow");
		}

	});																		//laz..
	$(".chequeDate2").datepicker({
		dateFormat: 'dd-mm-yy'
	});

	/* payloss */                                                                //laz
	$('#lossmodeOfPayment').on('change', function () {
		if (this.value == "Cheque") {
			$('#lossshowChequeList').fadeIn("slow");
			$('#lossshowDebitCredit').fadeOut("slow");
			$('#lossshowDirectCredit').fadeOut("slow");
		}
		else if (this.value == "Credit / Debit Card") {
			$('#lossshowChequeList').fadeOut("slow");
			$('#lossshowDebitCredit').fadeIn("slow");
			$('#lossshowDirectCredit').fadeOut("slow");
		}
		else if (this.value == "Direct Credit") {				
			$('#lossshowChequeList').fadeOut("slow");
			$('#lossshowDebitCredit').fadeOut("slow");
			$('#lossshowDirectCredit').fadeIn("slow");
		}
		else {
			$('#lossshowChequeList').fadeOut("slow");
			$('#lossshowDebitCredit').fadeOut("slow");
			$('#lossshowDirectCredit').fadeOut("slow");
		}
	});                                                                           //laz
	
	$(".chequeDate2").datepicker({
		dateFormat: 'dd-mm-yy'
	});
	
	$('.chequeDate').on('click', function () {
		$(".chequeDate2").focus();
	});
	function validNum(input){
		var regex=/[^0-9 ]/gi;
		input.value=input.value.replace(regex,"");
	}
	
	function validateCorpus(){
		let count = 0;
		let modeOfPayment = $('#modeOfPayment option:selected').val();
		let toBank = $('#tobank option:selected').val();						//laz
		let flghBank = "";														//laz new
		let DCtoBank = $('#DCtobank option:selected').val();					//laz new

		 let transactionId = $('#transactionId').val();
		  var bookreceiptno = $('#bookreceiptno').val();
		if(bookreceiptno) {
			$('#bookreceiptno').css('border-color', "#800000");
		} else {
			$('#bookreceiptno').css('border-color', "#FF0000");
			++count;
		}
		var corpus = $('#corpus').val();
		if(corpus) {
				$('#corpus').css('border-color', "#800000");
		} else {
				$('#corpus').css('border-color', "#FF0000");
				++count;
		}
		if(modeOfPayment == "Cheque") {
				chequeNo = $('#chequeNo').val();
				chequeDate = $('#chequeDate').val();
				bank = $('#bank').val();
				branch = $('#branch').val();
				if (chequeNo.length == 6) {
					$('#chequeNo').css('border-color', "#800000");
				} else {
					$('#chequeNo').css('border-color', "#FF0000");
					++count;
				}

				if (chequeDate) {
					$('#chequeDate').css('border-color', "#800000");
				} else {
					$('#chequeDate').css('border-color', "#FF0000");
					++count;
				}

				if (bank) {
					$('#bank').css('border-color', "#800000");
				} else {
					$('#bank').css('border-color', "#FF0000");
					++count;
				}

				if (branch) {
					$('#branch').css('border-color', "#800000");
				} else {
					$('#branch').css('border-color', "#FF0000");
					++count;
				}
		} else if (modeOfPayment == "Credit / Debit Card") {								//laz new
			flghBank = $('#DCtobank').val();
			if (DCtoBank != 0) {
				$('#DCtobank').css('border-color', "#800000");
			} else {
				$('#DCtobank').css('border-color', "#FF0000");
				++count;
			}
			if (transactionId) {
				$('#transactionId').css('border-color', "#800000");
			} else {
				$('#transactionId').css('border-color', "#FF0000");
				++count;
			}																				//laz new..
		}
		else if (modeOfPayment == "Direct Credit") {									//laz
			if (toBank!=0) {
				$('#tobank').css('border-color', "#800000");
			} else {
				$('#tobank').css('border-color', "#FF0000");
				++count;
			}																			//laz..
		}   else {
				$('#chequeNo').css('border-color', "#800000");
				$('#branch').css('border-color', "#800000");
				$('#bank').css('border-color', "#800000");
				$('#chequeDate').css('border-color', "#800000");
		}

		if (modeOfPayment) {
			$('#modeOfPayment').css('border-color', "#ccc")
			
		} else {
			$('#modeOfPayment').css('border-color', "#FF0000")
			++count;
		}

		var adlCrpBookDate = $('#adlCrpBookDate').val();
		if (adlCrpBookDate) {
			$('#adlCrpBookDate').css('border-color', "#ccc")
			
		} else {
			$('#adlCrpBookDate').css('border-color', "#FF0000")
			++count;
		}
		
		var isMandaliCheck="<?php echo $members[0]->IS_MANDALI;?>";
		let paidByCheck = $('#paidBy').val();
		if (isMandaliCheck == 1){
			if(paidByCheck) {
				$('#paidBy').css('border-color', "#800000");
			} else {
				$('#paidBy').css('border-color', "#FF0000");
				++count;
			}
		}

		if (count != 0) {
			alert("Information", "Please fill required fields", "OK");
			return false;
		}
	}

	function validateLoss(){
		let count = 0;
		 let lossmodeOfPayment = $('#lossmodeOfPayment option:selected').val();
		 let toBank1 = $('#tobank1 option:selected').val();						//laz
		 let flghBank1 = "";														//laz new
		let DCtoBank1 = $('#DCtobank1 option:selected').val();					//laz new
		 let transactionId1 = $('#transactionId1').val();
		var Loss_Amount = $('#Loss_Amount').val();
		 if (Loss_Amount) {
					$('#Loss_Amount').css('border-color', "#800000");
				} else {
					$('#Loss_Amount').css('border-color', "#FF0000");
					++count;
				}
		if (lossmodeOfPayment == "Cheque") {
				chequeNo1 = $('#chequeNo1').val();
				Checkdate1 = $('#Checkdate1').val();
				bank1 = $('#bank1').val();
				branch1 = $('#branch1').val();
				if (chequeNo1.length == 6) {
					$('#chequeNo1').css('border-color', "#800000");
				} else {
					$('#chequeNo1').css('border-color', "#FF0000");
					++count;
				}

				if (Checkdate1) {
					$('#Checkdate1').css('border-color', "#800000");
				} else {
					$('#Checkdate1').css('border-color', "#FF0000");
					++count;
				}

				if (bank1) {
					$('#bank1').css('border-color', "#800000");
				} else {
					$('#bank1').css('border-color', "#FF0000");
					++count;
				}

				if (branch1) {
					$('#branch1').css('border-color', "#800000");
				} else {
					$('#branch1').css('border-color', "#FF0000");
					++count;
				}
		} else if (lossmodeOfPayment == "Credit / Debit Card") {								//laz new
			flghBank1 = $('#DCtobank1').val();
			if (DCtoBank1 != 0) {
				$('#DCtobank1').css('border-color', "#800000");
			} else {
				$('#DCtobank1').css('border-color', "#FF0000");
				++count;
			}
			if (transactionId1) {
				$('#transactionId1').css('border-color', "#800000");
			} else {
				$('#transactionId1').css('border-color', "#FF0000");
				++count;
			}																				//laz new..
		}else if (lossmodeOfPayment == "Direct Credit") {									//laz
			if (toBank1!=0) {
				$('#tobank1').css('border-color', "#800000");
			} else {
				$('#tobank1').css('border-color', "#FF0000");
				++count;
			}																			//laz..
		}   else {
				$('#chequeNo1').css('border-color', "#800000");
				$('#branch1').css('border-color', "#800000");
				$('#bank1').css('border-color', "#800000");
				$('#Checkdate1').css('border-color', "#800000");
		}

		if (lossmodeOfPayment) {
			$('#lossmodeOfPayment').css('border-color', "#ccc")
			
		} else {
			$('#lossmodeOfPayment').css('border-color', "#FF0000")
			++count;
		}
		
		if(count != 0) {
					alert("Information", "Please fill required fields", "OK");
				return;
			} else {
				$('#confirm').show(); 
				$('#save').hide();
			}
	}
	
	$('#chequeNo1').on('keyup', function(e) {
		this.value.replace("\s","")
		if(this.value.length > 6)
			$('#chequeNo1').val((this.value.substr(0,6)))
	});

	$(".adlCrpBookDate").datepicker({ 
		dateFormat: 'dd-mm-yy',
		changeYear: true,
		changeMonth: true,
		yearRange: "1850:+400",
		beforeShow: function() {
			setTimeout(function(){
				$('.ui-datepicker').css('z-index', 99999999999999);
			}, 0);
		}
	});
	$('.adlCrpBookDate').on('click', function() {
		$( ".adlCrpBookDate" ).focus();
	});
</script>
