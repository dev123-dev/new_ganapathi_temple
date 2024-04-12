<div class="container" >
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" >
	<div class="row form-group">
		<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12" >
			<span class="eventsFont2">Shashwath Sevas</span>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-2 col-xs-10" style="padding-right:0px;text-align: end;"> 
				<form id="generateSevaId" action="" method="post">	
					<input type="hidden" name="generateDate" value="<?=@$date; ?>" />
					<?php $nextMonthDate = date('d-m-Y');
					 if(strtotime($date)<=strtotime($nextMonthDate.'+1 month')){ ?>
						<button class ="btn btn-default btn-sm custom"  id="generate" >Generate</button>&nbsp;&nbsp;
					<?php } ?>
				</form>
			<!-- <?php if(isset($_SESSION['Authorise']))	{?>	
			 <?php  }?> -->
		</div>
		
		<label class="checkbox-inline" id="excludeLable" style="font-weight:bold;float: right;">
			<input type="checkbox" id="Exclude" name="Exclude" onclick="">exclude certain Shashwath Sevas
		</label>
	</div>
	<form action="" id="dateChange" enctype="multipart/form-data" method="post" accept-charset="utf-8">
		<div class="row form-group" >	
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6" style="padding-left:0px;">
					<div class="input-group input-group-sm">
						<input type="hidden" name="generateDate" value="<?=@$date; ?>" id="date">
						<input type="hidden" name="load" id="load" value="">
						<input autocomplete="" id="todayDate" type="text" value="<?=@$date; ?>" class="form-control todayDate2"  
						onchange="GetSevaOnDate(this.value,'<?php echo site_url()?>Shashwath')" 
						placeholder="dd-mm-yyyy" readonly = "readonly" />
						<div class="input-group-btn">
							<button class="btn btn-default todayDate" type="button">
								<i class="glyphicon glyphicon-calendar"></i>
							</button>
						</div>
					</div>
				</div>

				<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6" style="padding-right:0px;">
					<div class="input-group input-group-sm">
						<input autocomplete="off" type="text" id="name_phpne" name="name_phone" value="<?=@$name_phone?>" class="form-control" placeholder="Name/Phone" />
						<div class="input-group-btn">
							<button class="btn btn-default name_phone" id="submitBut" type="submit">
								<i class="glyphicon glyphicon-search"></i>
							</button>
						</div>
					</div>
				</div>

				<div class="col-lg-3 col-md-12 col-sm-6 col-xs-12">
					<div class="form-group">
						<select onChange="deityComboChange();" id="deityCombo1" name="deityCombo1" class="form-control">
							<option value="" >All Deity</option>
							<?php if(isset($combo)) { ?>
								<?php foreach($deity as $result) { ?>
									<?php if($combo == $result['DEITY_ID']) { ?>
										<option value="<?=$result['DEITY_ID']; ?>" selected><?=$result['DEITY_NAME']; ?></option>
									<?php } else { ?>
										<option value="<?=$result['DEITY_ID']; ?>"><?=$result['DEITY_NAME']; ?></option>
									<?php } ?>
								<?php } ?>
							<?php } else { ?>
								<?php foreach($deity as $result) { ?>
									<option value="<?=$result['DEITY_ID']; ?>"><?=$result['DEITY_NAME']; ?></option>
								<?php } ?>
							<?php } ?> 
						</select>
					</div>
				</div>
				<?php if(isset($sevaCombo)) { ?>
					<input type="hidden" name="" id="sevaComboValue" value="<?php echo $sevaCombo ?>">
				<?php } else { ?>
					<input type="hidden" name="" id="sevaComboValue" value="">
				<?php } ?> 
				<div class="col-lg-3 col-md-12 col-sm-6 col-xs-12" >
					<div class="form-group">
						<select onChange="sevaComboChange();" id="sevaCombo" name="sevaCombo" class="form-control">
							<option value="" >Select sevas</option>
							

						</select>
					</div>
				</div>
			</form>
			
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 " style="padding-right:0px;text-align: end;">
				<form id="genShashwathSevaReport" method="post"> 
					<input type="hidden" name="generateDateForPDFReport" id="generateDateForPDFReport" value="<?=@$date; ?>" />
					<input type="hidden" name="excludeOrInclude"  id="excludeOrInclude">
				</form>
				<!-- <a onClick="printseva();"><img style="width:24px; height:24px" title="Print Report" src="<?=site_url();?>images/print_icon.svg"/></a> -->
				<img style="width:24px; height:24px; " onClick="edit()" title="Monthwise and Masawise Report" src="<?=site_url();?>images/labelicon.png"/>
				<a id="shashPDFReport" onclick="getShaswathSevaPDFReport()"><img style="width:24px; height:24px; margin-top:0.1em;" title="Shashwath Seva Report" src="<?=site_url();?>images/print_icon.svg"/></a>&nbsp;&nbsp;
				<a class="pull-right" onclick="getRefreshShaswathSevaDetails()" style="text-decoration:none;cursor:pointer;" title="Refresh"><img style="width:24px; height:24px;margin-top:0.1em;" id="refreshBut" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row form-group">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-left:0px;">
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th title="Name(Phone)" width="15%">Name (Phone)</th>
								<th title="Deity Name" width="15%">Deity Name</th>
								<th title="Seva (Price)" width="15%">Seva (Price)</th>
								<!-- <th title="Purpose" width="15%">Purpose</th> -->
								<th title="Quantity * Seva Price = Total Price" width="10%">Q * P = T</th>
								<th title="ThithiCode" width="10%">Thithi Code</th>
								<th title="Principal (Interest)" width="15%">Principal (Interest)</th>
								<th title="Seva Deficit" width="9%">Seva Deficit</th>
								<th title="Accumulated Deficit" width="9%">Accu Deficit</th>
								<th title="Total Deficit" width="15%">Tot Def</th>
								<?php if($count_result == false) { ?>
									<th title="Corpus Raise" width="10%">Corpus+</th>
								<?php } ?>
								<th title="Operations">Op</th>
							</tr>
						</thead>
						<tbody>
							<?php if(isset($shashwath_Sevas)) { 
								$count =0;
								foreach($shashwath_Sevas as $result) { ?>
									<tr>
										<td width="10%"><?php echo $result->NAME_PHONE;?></td>
										<td width="20%"><?php echo $result->DEITY_NAME;?></td>
										<td><?php 
										echo $result->SEVA_PRICE;									 
										if(explode(".",$result->SEVA_PRICE)[1] == ' 0/-)' && $count_result == true){
											$todayDate = strtotime(date('d-m-Y'));
											$soDate = strtotime($result->SO_DATE);

											if($todayDate >= $soDate){
												echo "<a onclick='priceAdd(".$shashwath_Sevas[$count]->SO_ID.");'><img style='width:24px; height:24px' class='img-responsive pull-right' title='Add Seva Price' src=".site_url()."images/add.svg></a>";
											}   
										}
										$count ++;     							  
										?>
									</td>
									<!-- <td><?php echo $result->SEVA_NOTES;?></td> -->
									<td><?php echo $result->SEVA_QTY." * ".$result->SEVA_COST." = ".$result->TOTAL_SEVA_COST;?></td>
									<td><?php echo $result->THITHI_CODE;?><?php echo $result->EVERY_WEEK_MONTH;?></td>

									<td><?php echo $result->PRINCIPAL_INTEREST;?></td>
									<td><?php echo $result->SEVA_LOSS;?></td>
									<td><?php echo $result->ACCUMULATED_LOSS;?></td>
									<td class="text-center" width="5%"><?php echo $result->TOTAL_LOSS;?></td>
									<?php if($count_result == false) {  if(explode(".",$result->SEVA_LOSS)[1] == ' 0/-') { ?> 
										<td></td>
									<?php } else { ?>
										<td><center><img id="corpusRaiseBtn" src="<?=base_url()?>images/add_icon.svg" title ="Raise the Corpus" onclick="corpusRaise('<?=$result->SS_ID; ?>','<?=$result->SM_ID; ?>','<?=$result->NAME_PHONE;?>','<?=$result->TOTAL_SEVA_COST;?>','<?=$result->SEVA_CORPUS;?>','<?=$result->SEVA_NAME;?>','<?=$result->NO_OF_SEVAS; ?>','<?=$result->IS_MANDALI; ?>','<?=$result->SHASH_PRICE; ?>','<?=$result->RECEIPT_NO;?>','<?=$result->SM_NAME;?>','<?=$result->SM_ADDR1;?>','<?=$result->SM_ADDR2;?>','<?=$result->SM_CITY;?>','<?=$result->SM_STATE;?>','<?=$result->SM_COUNTRY;?>','<?=$result->SM_PIN;?>','<?=$result->SM_PHONE;?>','<?=$result->DEITY_NAME;?>');"></center></td>
									<?php }} if($count_result == true && $result->EDIT_CHECK == 1) { ?>
										<td><center><a title='Edit Shashwath Seva Offered Date' onclick="changeSevaOfferedDate('<?=$result->SO_ID;?>','<?=$result->SM_NAME;?>','<?=$result->DEITY_NAME;?>','<?=$result->SEVA_NAME;?>','<?=$result->SEVA_NAME;?>','<?=$result->SM_NAME;?>','<?=$result->SM_ADDR1;?>','<?=$result->SM_ADDR2;?>','<?=$result->SM_CITY;?>','<?=$result->SM_STATE;?>','<?=$result->SM_COUNTRY;?>','<?=$result->SM_PIN;?>')";><span style='color:#800000' class='glyphicon glyphicon-pencil'></span></a></center></td>
									<?php } else { ?>
										<td></td>
									<?php } ?>
								</tr>
							<?php }

						} ?>
					</tbody>
				</table>
				<center><h1 id="noRecord" style="display:none;">No Seva Data Available</h1></center>
				<center><h1 id="calendarUpload" style="display:none;">No Calendar Data Available</h1></center>
				<ul class="pagination pagination-sm" style="margin-top: 1px;">
					<?=$pages;?>
				</ul>
				<label style="font-size:18px;margin-top: -0.2px;" class="pull-right">Total Sevas: <strong style="font-size:18px"><?php echo isset($total_countSeva) ? $total_countSeva : 0?></strong></label>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="changeSevaDateModal" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Change Shashwath Seva Offered Date</h4>
					<button type="button" class="close" data-dismiss="modal" style="margin-top:-10px;">&times;</button>
				</div>
				<div class="modal-body">
					<p><b>Name :</b> <span id="mname"></span></p>
					<p><b>Deity Name :</b> <span id="dname"></span></p>
					<p><b>Seva Name :</b> <span id="sname"></span></p>
					<div class="row">
						<div class="col-sm-4">
							<b>New Seva Date :</b>
							<div class="input-group input-group-sm form-group">
								<input autocomplete="off" id="modalmultiDate" type="text" value="" class="form-control modalmultiDate" name="modalmultiDate" placeholder="dd-mm-yyyy" readonly = "readonly" value=""/ >
								<div class="input-group-btn">
									<button class="btn btn-default modalmultiDate" type="button">
										<i class="glyphicon glyphicon-calendar"></i>
									</button>
								</div>
							</div>
						</div>
					</div>
					<span id="displayMsg" style="display: none; color: #FF0000; font-weight: bold;"></span>
					<input type="hidden" name="soId" id="soId"/>	
					<input type="hidden" name="setDate" id="setDate" value="<?=@$date;?>"/>
				</div>
				<div class="modal-footer">
					<button type="button" id="updateSevaDate" class="btn btn-default btn-md"><span class="glyphicon glyphicon-edit"></span>Update Seva Date</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<form action="<?=site_url();?>Shashwath/priceSubmit" id="priceForm" method="post">
		<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Add Seva Price</h4>
						<button type="button" class="close" data-dismiss="modal" style="margin-top:-10px;">&times;</button>
					</div>
					<div class="modal-body">
						<p><b>Name :</b> <span id="sm_name"></span></p>
						<p><b>Seva Name :</b> <span id="seva_name"></span></p>
						<p><b>Seva Price :</b> <input type="text" class = "form_contct2" name="price" id="price" /></p>
						<input type="hidden" name="id" id="id" value="" />
						<input type="hidden" name="selectedDate" id="selectedDate" value="<?=@$date; ?>" />
					</div>
					<div class="modal-footer">
						<input type="submit" class="btn btn-default" value="Submit" />
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	<!--corpus topup-->	

	<div>
		<form id="monthChange" method="post">

			<div class="modal fade bs-example-modal-lg" id="lblGen" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Month/Masawise Shashwath Seva Report</h4>
						</div>

						<div class="modal-body labelGen" id="creditdet" style="overflow-y: auto;max-height: 80vmin;">
							<div class="col-lg-4 col-md-6 col-sm-4 col-xs-6" >
								<select id="modeOfChangeMonth" data-plugin="selectpicker" data-live-search="true" class="form-control"  onchange="GetDataOnMonth(this.value)" >
									<?php if(isset($Date)) {?>
										<?php if($Date == "0") { ?>
											<option value="0" selected="selected">Select Month</option>
										<?php } else { ?>
											<option value="0" selected="selected">Select Month</option>
										<?php } ?>
										<?php if($Date == "-01") { ?>
											<option selected value="-01">January</option>
										<?php } else { ?>
											<option value="-01">January</option>
										<?php } ?>
										<?php if($Date == "-02") { ?>
											<option selected value="-02">February</option>
										<?php } else { ?>
											<option value="-02">February</option>
										<?php } ?>
										<?php if($Date == "-03") { ?>
											<option selected value="-03">March</option>
										<?php } else { ?>
											<option value="-03">March</option>
										<?php } ?>
										<?php if($Date == "-04") { ?>
											<option selected value="-04">April</option>
										<?php } else { ?>
											<option value="-04">April</option>
										<?php } ?>	
										<?php if($Date == "-05") { ?>
											<option selected value="-05">May</option>
										<?php } else { ?>
											<option value="-05">May</option>
										<?php } ?>	
										<?php if($Date == "-06") { ?>
											<option selected value="-06">June</option>
										<?php } else { ?>
											<option value="-06">June</option>
										<?php } ?>
										<?php if($Date == "-07") { ?>
											<option selected value="-07">July</option>
										<?php } else { ?>
											<option value="-07">July</option>
										<?php } ?>
										<?php if($Date == "-08") { ?>
											<option selected value="-08">August</option>
										<?php } else { ?>
											<option value="-08">August</option>
										<?php } ?>
										<?php if($Date == "-09") { ?>
											<option selected value="-09">September</option>
										<?php } else { ?>
											<option value="-09">September</option>
										<?php } ?>
										<?php if($Date == "-10") { ?>
											<option selected value="-10">October</option>
										<?php } else { ?>
											<option value="-10">October</option>
										<?php } ?>
										<?php if($Date == "-11") { ?>
											<option selected value="-11">November</option>
										<?php } else { ?>
											<option value="-11">November</option>
										<?php } ?>
										<?php if($Date == "-12") { ?>
											<option selected value="-12">December</option>
										<?php } else { ?>
											<option value="-12">December</option>
										<?php } ?>
									<?php } else { ?>
										<option value="">Select Month</option>			
										<option value="-01">January</option>
										<option value="-02">February </option>
										<option value="-03">March</option>
										<option value="-04">April</option>
										<option value="-05">May</option>
										<option value="-06">June</option>
										<option value="-07">July</option>
										<option value="-08">August</option>
										<option value="-09">September</option>
										<option value="-10">October</option>
										<option value="-11">November</option>
										<option value="-12">December</option>
									<?php } ?>
								</select>
								<input type="hidden" name="month" id="month">  
							</div>

							<div class="col-lg-4 col-md-6 col-sm-4 col-xs-6">
								<select id="masaCode" data-plugin="selectpicker" data-live-search="true" name="masaCode" class="form-control" onchange="GetDataOnMasa(this.value)">
									<option value="" selected="selected">Select Masa</option>
									<?php   if(!empty($masa)) {
										foreach($masa as $row1) { ?> 
											<option value="<?php echo $row1->MASA_NAME;?>"><?php echo $row1->MASA_NAME;?></option>
										<?php } } ?>
									</select>
								</div>	
								<input type="hidden" name="masa" id="masa">
							</div>

							<div class="modal-footer text-left" style="text-align:left;">
								<label>Are you sure you want to generate..?</label><br/>
								<button style="width: 30%;" type="button" class="btn btn-default sevaButton" onclick="checkForExport()" id="submit2">Submit</button>
								<button style="width: 30%;" type="button" class="btn btn-default sevaButton" data-dismiss="modal">Cancel</button>
							</div>
						</div>

					</div>
				</div>
				<input type="hidden" id="res" value=" " > 
				 <input type="hidden" id="monthno" name="" value="<?php echo $monthno ?>"> 
				 <input type="hidden" id="maxYear" name="" value="<?php echo $maxYear ?>"> 
				 <!-- //prathiksha code -->
				 <!-- //prathiksha code -->																																													
			</form>
		</div>	
	</div>
	<form id="corpusraiseform" action="" method="post">
		<input type="hidden"  id="sevaname" name="sevaname">
		<input type="hidden"  id="receipt_number" name="receipt_number">
		<input type="hidden"  id="nameph" name="nameph">
		<input type="hidden"  id="addr1" name="addr1">
		<input type="hidden"  id="addr2" name="addr2">
		<input type="hidden"  id="sccity" name="sccity">
		<input type="hidden"  id="ssstate" name="ssstate">
		<input type="hidden"  id="sccountry" name="sccountry">
		<input type="hidden"  id="cpin" name="cpin"> 
		<input type="hidden"  id="corpusraiseamt" name="corpusraiseamt">
		<input type="hidden"  id="smphone" name="smphone">
		<input type="hidden"  id="ssid" name="ssid">
		<input type="hidden"  id="deityIdName" name="deityIdName">
		<input type="hidden"  id="smID" name="smID">
		<input type="hidden" id="baseurl" name="baseurl" value="<?php echo $base_url ?>">
	</form>
	<script type="text/javascript">	
		$( document ).ready(function() {
			if(document.getElementById("deityCombo1").value!="")
			{
				document.getElementById('sevaCombo').style.display = "block";
			} else {
				document.getElementById('sevaCombo').style.display = "none";
			}

		});
	//progress bar code starts
	$(window).bind("load", function () {
		$('#work-in-progress').fadeOut(100);
		$('#loading-progress-text').fadeOut(100);
	});
	//progress bar code ends
	$('#price').keyup(function (e) {
		var $th = $(this);
		if (e.keyCode != 46 && e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 38 && e.keyCode != 39 && e.keyCode != 40) {
			$th.val($th.val().replace(/[^0-9]/g, function (str) { return ''; }));
		} return;
	});
	function validNum(input){
		var regex=/[^0-9 ]/gi;
		input.value=input.value.replace(regex,"");
	}
	
	var ROI = "<?php if(isset($calendarCheckRoi[0]) != '') {echo $calendarCheckRoi[0]->CAL_ROI; } else echo 0 ;?>";
	
	function corpusRaise(ssId,smId,namePhne,sAmt,sCorpus,sName,noOfSevas,ismandali,Shashmin_price,receipt,namePhne,corpadd1,corpadd2,corpcity,corpstate,corpcountry,corppin,smphone,deityName){
	
		let presentCorpus=sCorpus;
		let sevaPrice=sAmt;
		let corp = 0;
		corp = Math.ceil(Shashmin_price - presentCorpus);
		if(corp<=0){
			corp =((sevaPrice * 100)/ROI)*noOfSevas;
			corp = Math.ceil(corp - presentCorpus);
		}
		(corp <= 0 ? corp = 0:corp = corp);
		$('#corp').text("Rs. "+corp+"/-");

		$('#corpusraiseamt').val(corp);

		// $('#isMandaliMember').val(ismandali);
		// let arrMandaliMembers = <?php echo @$mandaliMembers; ?>;
		// $('#paidBySelect').html('');
		// $('#paidBySelect').append('<option value="">Select Member</option>');
		// for (let i = 0; i < arrMandaliMembers.length; ++i) {
		// 	if (arrMandaliMembers[i]['SM_ID']==smid) {
		// 		$('#paidBySelect').append('<option value="' + arrMandaliMembers[i]['MM_ID'] + '">' + arrMandaliMembers[i]['MM_NAME'] + '</option>');
		// 	}
		// }
		// if(isMandali == 1){
		// 	document.getElementById('paidByDiv').style.display = "block";
		// } else {
		// 	document.getElementById('paidByDiv').style.display = "none";

		// } 
		$('#smID').val(smId);
		$('#receipt_number').val(receipt);
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
		$('#receipt_number').val(receipt);
		$('#deityIdName').val(deityName);
		
		$('#sevaId').val(ssId);
		$('#smphone').val(smphone);

	
		 $('#corpusraiseform').attr('action','<?=site_url()?>Shashwath/shaswathaddcorpusdetails');
		$('#corpusraiseform').submit();
		
	}
	/* raise corpus */
	$('#modeOfPayment').on('change', function () {
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
			$('#showDebitCredit').fadeOut("slow");
			$('#showChequeList').fadeOut("slow");
			$('#showDirectCredit').fadeIn("slow");
		}
		else {
			$('#showChequeList').fadeOut("slow");
			$('#showDebitCredit').fadeOut("slow");
			$('#showDirectCredit').fadeOut("slow");

		}
	});
	
	$(".chequeDate2").datepicker({
		dateFormat: 'dd-mm-yy',
		changeYear: true,
		changeMonth: true,
		beforeShow: function() {
			setTimeout(function(){
				$('.ui-datepicker').css('z-index', 99999999999999);
			}, 0);
		}
	});
	$('.chequeDate').on('click', function () {
		$(".chequeDate2").focus();
	});

	$(".modalmultiDate").datepicker({ 
		dateFormat: 'dd-mm-yy',
		changeYear: true,
		changeMonth: true,
		minDate: 1,
		yearRange: "1850:+400",
		beforeShow: function() {
			setTimeout(function(){
				$('.ui-datepicker').css('z-index', 99999999999999);
			}, 0);
		}
	});
	$('.modalmultiDate').on('click', function() {
		$( ".modalmultiDate" ).focus();
	});

	function validateCorpus(){
		let count = 0;
		let modeOfPayment = $('#modeOfPayment option:selected').val();
		let transactionId = $('#transactionId').val();
		var corpus = $('#corpus').val();
		var bookreceiptno = $('#bookreceiptno').val();
		if(bookreceiptno) {
			$('#bookreceiptno').css('border-color', "#800000");
		} else {
			$('#bookreceiptno').css('border-color', "#FF0000");
			++count;
		}
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
		} else if (modeOfPayment == "Credit / Debit Card") {
			if (transactionId) {
				$('#transactionId').css('border-color', "#800000");
			} else {
				$('#transactionId').css('border-color', "#FF0000");
				++count;
			}
		} else {
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

		let isMandaliCheck = $('#isMandaliMember').val();
		let paidByCheck = $('#paidBySelect').val();
		if (isMandaliCheck == 1){
			if(paidByCheck) {
				$('#paidBySelect').css('border-color', "#800000");
			} else {
				$('#paidBySelect').css('border-color', "#FF0000");
				++count;
			}
		}
		if (count != 0) {
			alert("Information", "Please fill required fields", "OK");
			return false;
		}
	}


	var soNumber = "";
	function priceAdd(indexVal) {
		document.getElementById("id").value = indexVal ;
		document.getElementById("selectedDate").value = "<?=@$date; ?>";
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>/Shashwath/priceAdd",
			data: { indexVal: indexVal },
			success: function (response) {
				var member = response.split("$");
				$('#sm_name').text(member[0]);
				$('#seva_name').text(member[1]);
				$('#id').val(member[2]);
				$("#myModal").modal();  
			}
		}); 
	}

	var timerShowHideMsg;
	$('#updateSevaDate').click(function() {
		if($('#modalmultiDate').val() != "") {
			if($('#modalmultiDate').val() != $('#setDate').val()) {
				let setDate = $('#setDate').val();
				let soId = $('#soId').val();
				let newDate = $('#modalmultiDate').val();
				$.ajax({
					type: "POST",
					url: "<?php echo base_url();?>/Shashwath/changeShashwathSevaOfferedDate",
					data: {"setDate": setDate,"soId": soId,"newDate": newDate},
					success: function (response) {
						if(response == "success") {
							window.location.href = "<?=site_url()?>Shashwath/";
						} else if(response == "No Generation") {	
							alert("Warning","There are no sevas generated for </br> New Seva Date: <b>"+newDate+"</b> </br>Shashwath Member : <b>"+$('#mname').text()+"</b> </br>Deity : <b>"+$('#dname').text()+"</b> </br>Seva : <b>"+$('#sname').text()+"</b> </br><b><span style='color:#FF0000;'>Please generate sevas for "+newDate+" first</b></span>");
						}  
					}
				});	
			} else {
				$('#displayMsg').text("Please specify new seva date other than "+$('#setDate').val());
				$('#displayMsg').show();
				timerShowHideMsg = setTimeout(hideMsg,1000);
			}	
		} else {
			$('#displayMsg').text("Please specify new seva date");
			$('#displayMsg').show();
			timerShowHideMsg = setTimeout(hideMsg,1000);
		}
	});

	function hideMsg() {
		$('#displayMsg').hide();
		clearTimeout(timerShowHideMsg);
	}


	




	function deityComboChange() {
		bgNo = $('#deityCombo1').val();
		$('#sevaCombo').html("");
		for (let i = 0; i < arr.length; ++i) {
			if (arr[i]['DEITY_ID'] == bgNo)
				if(arr[i]['REVISION_STATUS'] == 1)
					$('#sevaCombo').append('<option value="' + arr[i]['DEITY_ID'] + "|" + arr[i]['SEVA_ID'] + "|" + arr[i]['SEVA_NAME'] + "|" + arr[i]['USER_ID'] + "|" + arr[i]['SEVA_PRICE'] + "|" + arr[i]['QUANTITY_CHECKER'] + "|" + arr[i]['IS_SEVA'] + "|" + arr[i]['OLD_PRICE'] + "|" + arr[i]['REVISION_STATUS'] + "|" + arr[i]['REVISION_DATE']+"|" + arr[i]['SEVA_TYPE'] + '">' + arr[i]['SEVA_NAME']+"  =  "+ (arr[i]['SEVA_TYPE'] == "Occasional" ? "Occasional" :"Regular") + '</option>');
				
				
				else
					$('#sevaCombo').append('<option value="' + arr[i]['DEITY_ID'] + "|" + arr[i]['SEVA_ID'] + "|" + arr[i]['SEVA_NAME'] + "|" + arr[i]['USER_ID'] + "|" + arr[i]['SEVA_PRICE'] + "|" + arr[i]['QUANTITY_CHECKER'] + "|" + arr[i]['IS_SEVA'] + "|" + arr[i]['OLD_PRICE'] + "|" + arr[i]['REVISION_STATUS'] + "|" + arr[i]['REVISION_DATE'] +"|" + arr[i]['SEVA_TYPE'] + '">' + arr[i]['SEVA_NAME'] +"  =  "+((arr[i]['SEVA_TYPE'] == "Occasional") ? "Occasional" :"Regular") + '</option>');
				

			}
			for (i = 1; i <= 5; ++i)
				if (i == bgNo)
					$('.bg' + i).fadeIn("slow");
				else
					$('.bg' + i).hide();
				$("#sevaCombo").val("");
				var url = "<?php echo site_url();?>Shashwath/searchShashwathSeva";
				$("#dateChange").attr("action",url)
				$("#dateChange").submit();

				sevaComboChange();

			}


			(function () {
				arr = <?php echo @$sevas; ?>;
				let num = document.getElementById("deityCombo1").value;
				let sevaComboValue =document.getElementById("sevaComboValue").value;
				for (let i = 0; i < arr.length; ++i) {
					if (arr[i]['DEITY_ID'] == num)
						$('#sevaCombo').append('<option value="' + arr[i]['DEITY_ID'] + "|" + arr[i]['SEVA_ID'] + "|" + arr[i]['SEVA_NAME'] + "|" + arr[i]['USER_ID'] + "|" + arr[i]['SEVA_PRICE'] + "|" + arr[i]['QUANTITY_CHECKER'] + "|" + arr[i]['IS_SEVA'] + '">' + arr[i]['SEVA_NAME'] + "  =  "+((arr[i]['SEVA_TYPE'] == "Occasional") ? "Occasional" :"Regular") + '</option>');
					if(sevaComboValue!=""){
						if (arr[i]['SEVA_ID'] == sevaComboValue)
							$('#sevaCombo').append('<option value="' + arr[i]['DEITY_ID'] + "|" + arr[i]['SEVA_ID'] + "|" + arr[i]['SEVA_NAME'] + "|" + arr[i]['USER_ID'] + "|" + arr[i]['SEVA_PRICE'] + "|" + arr[i]['QUANTITY_CHECKER'] + "|" + arr[i]['IS_SEVA'] + '" selected=selected>' + arr[i]['SEVA_NAME'] + "  =  "+((arr[i]['SEVA_TYPE'] == "Occasional") ? "Occasional" :"Regular") + '</option>');
					}
				}

				let sevaCombo = getSevaCombo();

		//deityComboChange();
	}());


	function sevaComboChange() {
		let sevaCombo = getSevaCombo();

		var url = "<?php echo site_url();?>Shashwath/searchShashwathSeva";
		$("#dateChange").attr("action",url)
		$("#dateChange").submit();
	}


	function getSevaCombo() {
		let sevaCombo = $('#sevaCombo option:selected').val();
		sevaCombo = sevaCombo.split("|");		
		let sevaPrice = sevaCombo[4]

		return {
			deityId: sevaCombo[0],
			sevaId: sevaCombo[1],
			sevaName: sevaCombo[2],
			userId: sevaCombo[3],
			sevaPrice: sevaPrice,
			quantityChecker: sevaCombo[5],
			isSeva: sevaCombo[6],
			old_price: sevaCombo[7],
			revision_status: sevaCombo[8],
			revision_date: sevaCombo[9]

		}
	}


	function changeSevaOfferedDate(soId, mname, dname,sname) {
		$('#modalmultiDate').val('');
		$('#mname').text(mname);
		$('#sname').text(sname);
		$('#dname').text(dname);
		$('#soId').val(soId);
		$("#changeSevaDateModal").modal();  
	}

	var dt = new Date($('#maxYear').val() + "-" + (($('#monthno').val().length == 1)?"0"+$('#monthno').val():$('#monthno').val()) + "-01");
 	dt.setDate( dt.getDate() - 1 );

	$( ".todayDate2" ).datepicker({ 
		minDate: '01-04-2021',
		maxDate: dt.getDate()+"-"+(dt.getMonth()+1)+"-"+dt.getFullYear(),
		dateFormat: 'dd-mm-yy',
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50"
	});
	$('.todayDate').on('click', function() {
		$( ".todayDate2" ).focus();
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

	function GetSevaOnDate(receiptDate,url) {
		document.getElementById('date').value = receiptDate;
		var date = document.getElementById('load').value = "DateChange";
		$("#dateChange").attr("action",url)
		$("#dateChange").submit(); 
		getProgressSpinner();
	}
	

	$('#submitBut').on('click',function(e) {
		var url = "<?php echo site_url();?>Shashwath/searchShashwathSeva";
		$("#dateChange").attr("action",url)
		$("#dateChange").submit();
	});
	
	var shashwathSevas = "<?php echo isset($shashwath_Sevas[0]);?>";
	var existaRecord = "<?php echo $count_result;?>";
	if(existaRecord){
		$('#generate').hide();
		$('#shashPDFReport').show();
		$('#excludeLable').show();
		$('#noRecord').hide();
		$('#calendarUpload').hide();
	} else if(existaRecord != "" && shashwathSevas != ""){
		$('#generate').hide();
		$('#shashPDFReport').show();
		$('#excludeLable').show();
		$('#noRecord').hide();
	} else if(existaRecord == "" && shashwathSevas == ""){
		$('#generate').hide();
		$('#shashPDFReport').hide();
		$('#excludeLable').hide();
		$('#noRecord').show();
	} else	{
		$('#generate').show();
		$('#shashPDFReport').hide();
		$('#excludeLable').hide();
		$('#noRecord').hide();
	}
	
	var calendarCheck = "<?php  echo isset($calendarCheckRoi[0]); ?>";
	if(calendarCheck == "") {
		if(existaRecord){
			$('#calendarUpload').hide();
			$('#noRecord').hide();
		} else {
			$('#calendarUpload').show();
			$('#noRecord').hide();
		}
	}

	$("#generate").on("click", function() {
		//Please find this function in the footer
		alertGenerateSevaDialog("Confirmation", "Please <b>verify data</b> for the date <b><?=@$date; ?></b> before generating. If you have verfied, Please go ahead and press OK",true);
		return false;
	});

	// function getShaswathSevaPDFReport() {
	// 	$('#genShashwathSevaReport').attr('action', "<?php echo site_url();?>generatePDF/createShashwathSevaReportPDF").submit();
	// }

	function getShaswathSevaPDFReport() {
		if($('#Exclude').prop('checked') == true) {
			document.getElementById('excludeOrInclude').value ="Exclude";
		} else {
			document.getElementById('excludeOrInclude').value ="Include";
		}
		let url = "<?php echo site_url(); ?>generatePDF/create_shaswathSevaReportSession";	
		$.post(url,{'generateDateForPDFReport':$('#generateDateForPDFReport').val(),'excludeOrInclude':$('#excludeOrInclude').val()}, function(data) {
			let url2 = "<?php echo site_url(); ?>generatePDF/createShashwathSevaReportPDF";
			if(data == 1) {
				downloadClicked = 0;
				var win = window.open(
				  url2,
				  '_blank'
				);
				setTimeout(function(){ win.print();}, 1000); //setTimeout(function(){ win.close();}, 5000);
			}
		})
	}
	
	function getRefreshShaswathSevaDetails() {
		$('#genDate').val("<?php echo date('d-m-Y'); ?>");
		$('#shashwathForm').submit();
		getProgressSpinner();
		return false;
	}

	function getStartedSpinnerOnPaginatedDataClick() {
		getProgressSpinner();
		return false;
	}
	function GetDataOnMonth(date) {
		document.getElementById('month').value = $('#modeOfChangeMonth').val();
		document.getElementById('masa').value ="";
		document.getElementById('masaCode').value ="";	
	}

	function GetDataOnMasa(masa) {
		document.getElementById('month').value ="";
		document.getElementById('modeOfChangeMonth').value ="";
		document.getElementById('masa').value =$('#masaCode').val();	
	}

	function edit(){
		document.getElementById('masa').value ="";
		document.getElementById('masaCode').value ="";
		document.getElementById('month').value ="";
		document.getElementById('modeOfChangeMonth').value ="";
		
		$('#lblGen').modal();		
	}

	function checkForExport() {
		$month = $('#modeOfChangeMonth').val();
		$masa = $('#masaCode').val();

		if($month == '' && $masa == ''){
			alert('Please Select Month or Masa');	
			return false;
		}else{
			document.getElementById("monthChange").target = "_blank";
			var url = '<?php echo site_url();?>GenerationMonthMasaShashwathSevaReport';
			$("#monthChange").attr("action",url);
			$("#monthChange").submit();	
			// $('#lblGen').modal('toggle') = "none";	
			$('#lblGen').modal('hide');
		}							
	}

	//CREATE PRINT
	// function printseva() {
	// 	let url = "<?php echo site_url(); ?>generatePDF/create_shaswathSevaReceiptSession";	
	// 	$.post(url,{'dateField':$('#todayDate').val()}, function(data) {
	// 		let url2 = "<?php echo site_url(); ?>generatePDF/create_deityshaswathSevaReceiptPrint";
	// 		if(data == 1) {
	// 			downloadClicked = 0;
	// 			var win = window.open(
	// 			  url2,
	// 			  '_blank'
	// 			);
	// 			setTimeout(function(){ win.print();}, 1000); //setTimeout(function(){ win.close();}, 5000);
	// 		}
	// 	})
	// }
</script>