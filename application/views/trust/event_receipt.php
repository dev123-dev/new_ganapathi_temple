<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="col-lg-4 col-md-4  col-sm-4 col-xs-12">
				<span class="eventsFont2">Seva Receipt</span>
			</div>
			<div class="col-lg-6  col-md-6 col-sm-7 col-xs-10">
				<span class="eventsFont2 samFont1"><?=$event['TET_NAME']; ?></span>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-1 col-xs-2">
				<a style="width:24px; height:24px" class="pull-right img-responsive" href="<?=site_url()?>TrustEvents/event_receipt" title="Reset"><img title="Reset" src="<?=site_url();?>images/refresh.svg"/></a>
			</div>
		</div>
	</div>
	
	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="col-lg-6 col-md-6 col-sm-6 show-large hidden-xs">
				<span class="eventsFont2">Receipt Date: <?=date("d-m-Y")?></span>
			</div>
			<!--<div class="col-lg-6 col-md-6 col-sm-6 hidden-xs">
				<span class="eventsFont2 pull-right">Receipt Number: BSM/2017-18/SN/2</span>
			</div>-->
			
			<div class="hidden-md hidden-lg hidden-sm show-small col-xs-12">
				<span class="eventsFont2">Receipt Date: <?=date("d-m-Y")?></span>
			</div>
		</div>
	</div>
	
	
<div class="row">
	<div class= "col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<div class= "col-lg-6 col-md-6 col-sm-12 col-xs-9">
			<div class="form-group">
			  <label for="name">Name <span style="color:#800000;">*</span></label>
			  <input type="text" class="form-control form_contct2" id="name" placeholder="" name="name">
			</div>
		</div>
	
		<div class= "col-lg-6 col-md-6 col-sm-12 col-xs-9">
			<div class="form-group">
			  <label for="number">Number </label>
			  <input type="text" class="form-control form_contct2" id="phone" placeholder="" name="phone">
			</div>
		</div>
		<div class= "col-lg-6 col-md-6 col-sm-12 col-xs-9">
			<div class="form-group">
			  <label for="rashi">Rashi </label>
			  <input type="hidden" id="baseurl" name="baseurl" value="<?php echo site_url(); ?>" />
				<div class="dropdown">
					<input type="text" class="form-control form_contct2" id="rashi" placeholder="" name="rashi">
					<ul class="dropdown-menu txtpin" style="margin-left:0px;margin-right:0px;max-height:400px;" role="menu" aria-labelledby="dropdownMenu"  id="DropdownRashi">
					</ul>
				</div>
			</div>
		</div>
	
		<div class= "col-lg-6 col-md-6 col-sm-12 col-xs-9">
			<div class="form-group">
			  <label for="nakshatra">Nakshatra </label>
			  <input type="hidden" id="baseurl" name="baseurl" value="<?php echo site_url(); ?>" />
				<div class="dropdown">
					<input type="text" class="form-control form_contct2" id="nakshatra" placeholder="" name="nakshatra">
					<ul class="dropdown-menu txtpin1" style="margin-left:0px;margin-right:0px;max-height:400px;" role="menu" aria-labelledby="dropdownMenu"  id="Dropdownnakshatra">
					</ul>
				</div>
			</div>
		</div>
		<!-- new code for pan and adhaar start by adithya -->
		<div class= "col-lg-6 col-md-6 col-sm-12 col-xs-9">
			<div class="form-group">
			  <label for="pan">Pan No </label>
			  <input type="hidden" id="baseurl" name="baseurl" value="<?php echo site_url(); ?>" />
					<input type="text" class="form-control form_contct2" id="pan" placeholder="AJRJR2345T" name="pan">
			</div>
		</div>
	
		<div class= "col-lg-6 col-md-6 col-sm-12 col-xs-9">
			<div class="form-group">
			  <label for="Adhaar">Adhaar No </label>
			  <input type="hidden" id="baseurl" name="baseurl" value="<?php echo site_url(); ?>" />
					<input type="text" class="form-control form_contct2" id="adhaar" placeholder="9876543211235" name="adhaar">
			</div>
		</div>
		<!-- new code for pan and adhaar end by adithya -->
	</div> <!-- first column ends -->

	<div class= "col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<div class= "col-lg-6 col-md-8 col-sm-12 col-xs-9">
			<div class="form-group">
			  <label for="seva">Seva <span style="color:#800000;">*</span></label>
			 
			  <select id="sevaCombo" class="form-control">
			   <option value="" selected="selected">Select Seva Name</option>
				<?php foreach($eventSeva as $result) { ?>
					<option value="<?=$result['TET_SEVA_PRICE'].'|' . $result['TET_SEVA_QUANTITY_CHECKER'] . "|".$result['IS_SEVA'] ."|".$result['TET_SEVA_ID']."|".$result['RESTRICT_DATE']; ?>">
						<?=$result['TET_SEVA_NAME']. " = &#8377; " .$result['TET_SEVA_PRICE']; ?>
					</option>
				<?php } ?>
			  </select>
			</div>
		</div>
		<div class= "col-lg-4 col-md-5 col-sm-7 col-xs-6">
			<div class="sevaDate">
					<label for="seva">Seva Date <span style="color:#800000;">*</span></label>
					<div class="form-group">
						<div class="input-group input-group-sm multiDate">
							<input id="multiDate" type="text" value="" class="form-control todayDate2" placeholder="dd-mm-yyyy" readonly>
							<div class="input-group-btn">
							  <button class="btn btn-default todayDate" type="button">
								<i class="glyphicon glyphicon-calendar"></i>
							  </button>
							</div>
						</div>
						
						<div style="display:none;" class="input-group input-group-sm multiDate1">
							<input id="multiDate1" type="text" value="" class="form-control todayDate2" placeholder="dd-mm-yyyy">
							<div class="input-group-btn">
							  <button class="btn btn-default todayDate1" type="button">
								<i class="glyphicon glyphicon-calendar"></i>
							  </button>
							</div>
						</div>
					</div>
			</div>
		</div>
		<div class="col-lg-offset-0 col-lg-2 col-md-offset-5 col-md-2 col-sm-offset-3 col-sm-2 col-xs-offset-4 col-xs-2">
			<label></label>
			<div class="form-group">
				<?php if(isset($_SESSION['Add'])) { ?>
					<a onClick="checkConfirmTime('<?php echo date('d-m-Y');?>');"><img style="width:24px; height:24px;margin-top:5px;" class="img-responsive pull-right" title="Add Seva" src="<?=site_url();?>images/add_icon.svg"/></a>
				<?php } ?>
			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
				<div class="form-group">
					<label for="sevaAmount">Seva Amount: <br/><span style="font-size: 31px;" id="setPrice"></span></label>  
				</div>
			</div>
			
			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
				<div class="sevaAvailable" style="display:none;">
					<label for="name">Seva Available: <br/><span style="font-size: 31px;" class="form-group" id="sevaAvailable"></span><span id="booked" class="form-group"></span></label>
				</div>
				<div class="stockAvailable" style="display:none;">
					<label for="name">Stock Available: <span style="font-size: 31px;" class="form-group" id="stockAvailable"></span></label>
				</div>
			</div>
			
			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
				<div style="margin-left: 3px;" class="quantity" style="display:none;">
					<div class="form-group">
					  <label for="name">Quantity <span style="color:#800000;">*</span></label>
					  <input style="width:70px;font-size:24px;" type="text" value="1" class="form-control form_contct2" oninput="inputQuantity(this.value)" id="qty" placeholder="1" name="qty">
					</div>
				</div>	
			</div>
		</div>
	</div>
	<div class="container">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="row form-group">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label class="selDate" for="sevaAmount"><strong style="font-weight: 700;font-size: 17px;">Selected Seva Dates: <span style="font-size: 15px;" id="selDate"></span></strong></label>  
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="display:none;margin-bottom: 1.5em;">
		<div class="form-inline">
		  <label for="number">Address </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  <textarea class="form-control" rows="5" id="address" name="address" style="resize:none;" placeholder="Near Classic Chaya, Santhakatte" style="width: 100%;"></textarea>
		</div>
	</div>
	<div class="container">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="row form-group">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="table-responsive">
						<table id="eventSeva" class="table table-bordered">
							<thead>
							  <tr>
								<th>Sl. No.</th>
								<th>Seva Name</th>
								<th>Qty</th>
								<th>Seva Date</th>
								<th>Seva Amount</th>
								<th>Total Seva Amount</th>
								<th style="width:50px;">Remove</th>
							  </tr>
							</thead>
							<tbody id="eventUpdate">
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="row form-group">
				<div class="col-lg-offset-9 col-lg-3 col-md-12 col-sm-12 col-xs-12">
					<label style="font-size:18px" for="sevaAmount">Total Amount: <span id="totalAmount">0</span></label>  
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row form-group">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-8">
					<div class="form-group">
						<label><input style="margin-right: 6px;" id="postage" name="postage" onClick="hidePostageAmt(this);" type="checkbox" value="1">Postage</label>
						<div class="form-group">
							<input style="width:50%;visibility:hidden;" type="text" style="display:hidden;" class="form-control form_contct2" id="postageAmt" placeholder="Amount" name="postageAmt">
						</div>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:0px;">
						<input type="text" class="form-control form_contct2" id="addLine1" placeholder="Address Line1" name="addLine1"><br>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:0px;">
						<input type="text" class="form-control form_contct2" id="addLine2" placeholder="Address Line2" name="addLine2"><br>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding:0px;">
						<input type="text" class="form-control form_contct2" id="city" placeholder="City" name="city"><br>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding-left:5px;padding-right:5px;">
						<input type="text" class="form-control form_contct2" id="country" placeholder="Country" name="country"><br>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding:0px;">
						<input type="text" class="form-control form_contct2" id="pincode" placeholder="Pincode" name="pincode"><br>
					</div>
				</div>
				
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					  <label for="modeOfPayment">Mode Of Payment: <span style="color:#800000;">*</span></label>
					  <select id="modeOfPayment" class="form-control">
						<option value="">Select Payment Mode</option>
						<option value="Cash">Cash</option>
						<option value="Cheque">Cheque</option>
						<option value="Direct Credit">Direct Credit</option>
						<option value="Credit / Debit Card">Credit / Debit Card</option>
					  </select>
					</div>
					
					<div style="padding-top: 15px; display:none;margin-left: -14px;" id="showChequeList">
						<div class="form-group col-xs-10">
							<label for="name">Cheque No: <span style="color:#800000;">*</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="text" class="form-control form_contct2" id="chequeNo" placeholder="" name="chequeNo">
						</div>
						
						<div style="padding-top: 15px;" class="form-group col-xs-10">
							<label for="rashi">Cheque Date: <span style="color:#800000;">*</span></label>&nbsp;&nbsp;
							<div class="input-group input-group-sm">
								<input id="chequeDate" type="text" value="<?=date("d-m-Y")?>" class="form-control chequeDate2 form_contct2" placeholder="dd-mm-yyyy">
								<div class="input-group-btn">
								  <button class="btn btn-default chequeDate" type="button">
									<i class="glyphicon glyphicon-calendar"></i>
								  </button>
								</div>
							</div>
						</div>
						
						<div style="padding-top: 15px;" class="form-group col-xs-12">
						  <label for="number">Bank Name: <span style="color:#800000;">*</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						  <input type="text" class="form-control form_contct2" id="bank" placeholder="" name="bank">
						</div>
						
						<div style="padding-top: 15px;" class="form-group col-xs-12">
						  <label for="nakshatra">Branch Name: <span style="color:#800000;">*</span></label>&nbsp;&nbsp;
						  <input type="text" class="form-control form_contct2" id="branch" placeholder="" name="branch">
						</div>
					</div>
					
				<!-- laz new-->
						<div style="padding-top: 15px; display:none;margin-left: -14px;" id="showDebitCredit">
							<div class="form-group col-xs-10">
								<label for="bank">To Bank <span style="color:#800000;">*</span></label>&nbsp;&nbsp;
								<select id="DCtobank" name="DCtobank" class="form-control">
								<option value="0">Select Bank</option>
								<?php foreach($terminal as $result) { echo "$result"; ?>
									<option value="<?=$result->T_FGLH_ID; ?>">
										<?=$result->T_FGLH_NAME; ?>
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
									<option value="<?=$result->T_FGLH_ID; ?>">
										<?=$result->T_FGLH_NAME; ?>
									</option>
									<?php } ?>
							</select>
							</div>
						</div>
						<!-- laz.. -->
					<div class="form-group">
					  <label for="comment">Payment Notes: </label>
					  <textarea class="form-control" rows="5" style="resize:none;" id="paymentNotes"></textarea>
					</div>
					
					<div class="row form-group">
						<div class="control-group col-md-12 col-lg-12 col-sm-12 col-xs-12">
							<label class="control-label" style="color:#800000;font-size: 12px;"><i>* Indicates mandatory fields.</i></label>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Event Seva Preview</h4>
			</div>
			<div class="modal-body" id="creditdet" style="overflow-y: auto;max-height: 80vmin;">
				
			</div>
			
			<div class="modal-footer text-left" style="text-align:left;">
				<label>Are you sure you want to save..?</label><br/>
				<button style="width: 8%;" type="button" class="btn btn-default sevaButton" id="submit">Yes</button>
				<button style="width: 8%;" type="button" class="btn btn-default sevaButton" data-dismiss="modal">No</button>
			</div>
		</div>
	  </div>
	</div>
	
	<div class="container">
		<center><button type="button" onClick="validateSubmit();" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-print"></span> Submit & Print</button></center>
	</div>
<script src="<?=site_url()?>js/autoCompleteTrust.js"></script>
<script>



	$(document).ready(function(){
		$("#name").keypress(function(event){
			var inputValue = event.which;
			// allow letters and whitespaces only.
			if(!(inputValue >= 65 && inputValue <= 122) && (inputValue != 32 && inputValue != 0)) { 
				event.preventDefault(); 
			}
		});
	});


	function hidePostageAmt(ths) {
		let postageAmt = document.getElementById('postageAmt');
		if(ths.checked) {
			postageAmt.style.visibility='visible';
			postageAmt.value='';
		} else {
			postageAmt.style.visibility='hidden';
			postageAmt.value='';
		} 
	}
	
	                                                                 //function to check if quantity is greater than 50
	var tempQty;
	function inputQuantity(qtyValue) { 
		if (isNaN(qtyValue)){
			  document.getElementById('qty').value = '';
		} else if(document.getElementById('qty').value == 0) { 
			 document.getElementById('qty').value = '';
		} else if(qtyValue < 51){
			tempQty = qtyValue;
		} else {
			$('#qty').val(tempQty);
			console.log(tempQty);
			alert("Information","Quantity cannot exceed 50","OK");
		}
	}
	
	//INPUT KEYPRESS
	$(':input').on('keypress change', function() {
		var id = this.id;
		$('#' + id).css('border-color', "#000000");
	});

	var price = 0;
	var total = 0;
	var tableContent = [];
	var eventSeva = "";
	var availableDates = [];
	var limit = [];
	var currentTime = new Date()
	var sevaLimit = "";
	var currentSevaLength = 0;
	var fromDate = "<?=$activeDate[0]->TET_FROM_DATE_TIME; ?>";
	
	let currentDate12 = fromDate.split("-");
		
		let day = currentDate12[0];
		let month = currentDate12[1];
		let year = currentDate12[2];
		
		let date = new Date(Number(year),(Number(month)-1),Number(day));
		let date2 = new Date(Number("<?=date('Y')?>"),(Number("<?=date('m')?>")-1),Number("<?=date('d')?>"));
		
	if(date < date2) {
		fromDate = "<?=date('d-m-Y'); ?>";
	}
	var toDate = "<?=$activeDate[0]->TET_TO_DATE_TIME; ?>"; 
	fromDate = fromDate.split("-");
	toDate = toDate.split("-");
	
	var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + (Number(currentTime.getDate())+1)); //one day next before month
	var maxDate =  new Date(currentTime.getFullYear(), currentTime.getMonth() +12, +0); // one day before next month
	
	var minDate1 = new Date(Number(fromDate[2]), (Number(fromDate[1])-1), +(Number(fromDate[0]))); 
	var maxDate1 =  new Date(Number(toDate[2]), (Number(toDate[1])-1), + Number(toDate[0]));

	
	
	$('#submit').on('click', function() {
		if(tableContent.length == 0) {
			alert("Information", "Add atleast one seva to submit.")
			return;
		}
		
		let count = 0;
		let flghBank = "";														
		let modeOfPayment = $('#modeOfPayment option:selected').val();
                                                                      // REMOVED FROM COMMENT BY ADITHYA this is for Direct credit/debit credit option of payment
                                                                      // toBank  = Direct credit   , DCtoBank = Debit/credit card
		let toBank = $('#tobank option:selected').val();						
		let DCtoBank = $('#DCtobank option:selected').val();
                                                                       // TILL HERE 
		// let toBank = " ";				                           //adithya
		// let DCtoBank =	" ";			                           //adithya
		let transactionId = $('#transactionId').val();
		let chequeNo = "";
		let chequeDate = "";
		let bank = "";
		let branch = "";
		let name = $('#name').val() 
		let multiDate =	"";	
		let pan = $('#pan').val();
		let adhaar = $('#adhaar').val()
		
		if($('.multiDate').is(':visible')) {
			multiDate = $('#multiDate').val();
			if(multiDate){
				$('#multiDate').css('border-color', "#000000")
			} else {
				$('#multiDate').css('border-color', "#FF0000");
			}
			multiDate1 = 'multiDate'
		} else if($('.multiDate1').is(':visible')) {
			multiDate = $('#multiDate1').val();
			multiDate1 = 'multiDate1'
			if(multiDate){
				$('#multiDate1').css('border-color', "#000000")
			} else {
				$('#multiDate1').css('border-color', "#FF0000");
			}
		} 
		let number = $('#phone').val() 
		let rashi = $('#rashi').val() 
		let nakshatra = $('#nakshatra').val()
		let qty = $('#qty').val()
		let paymentNotes = $('#paymentNotes').val();
		let sevaCombo = $('#sevaCombo option:selected').val();
		let etName = "<?=@$event['TET_NAME']; ?>"
		let etId = "<?=@$event['TET_ID']; ?>"
			if(modeOfPayment == "Cheque") {
				chequeNo = $('#chequeNo').val();
				chequeDate = $('#chequeDate').val();
				bank = $('#bank').val();
				branch = $('#branch').val();
				
				if(chequeNo.length == 6) {
					$('#chequeNo').css('border-color', "#800000");
				} else {
					$('#chequeNo').css('border-color', "#FF0000");
					++count;
				}
				
				if(chequeDate){
					$('#chequeDate').css('border-color', "#800000");
				} else {
					$('#chequeDate').css('border-color', "#FF0000");
					++count;
				}
				
				if(bank){
					$('#bank').css('border-color', "#800000");
				} else {
					$('#bank').css('border-color', "#FF0000");
					++count;
				}
				
				if(branch){
					$('#branch').css('border-color', "#800000");
				} else {
					$('#branch').css('border-color', "#FF0000");
					++count;
				}
			} 
			else if (modeOfPayment == "Credit / Debit Card") {								//done by adithya on 5-1-24
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
			}																				
		}
		else if (modeOfPayment == "Direct Credit") {	
			flghBank = $('#tobank').val();								                   //done by adithya on 5-1-2024
			if (toBank!=0) {
				
				$('#tobank').css('border-color', "#800000");
			} else {
				$('#tobank').css('border-color', "#FF0000");
				++count;
			}																			
		} 
			else {
				$('#chequeNo').css('border-color', "#800000");
				$('#branch').css('border-color', "#800000");
				$('#bank').css('border-color', "#800000");
				$('#chequeDate').css('border-color', "#800000");
			}
			
			if(modeOfPayment) {
				$('#modeOfPayment').css('border-color', "#000000")
					
			} else {
					$('#modeOfPayment').css('border-color', "#FF0000")
					++count;
			}
		
		if(tableContent.length == 0) { 
			if(eventSeva[1] == 1 && eventSeva[2] != 1) {                                    //qty picker
				if(qty != "" && qty != 0) {
					$('#qty').css('border-color', "#000000")
				} else {
					$('#qty').css('border-color', "#FF0000")
					++count;
				}
				
			} else if(eventSeva[2] == 1 && eventSeva[1] == 1) {
				if(qty && qty != 0) {
					$('#qty').css('border-color', "#000000")
					
				} else {
					$('#qty').css('border-color', "#FF0000")
					++count;
				}
				
				if(multiDate) {
					
					$('#'+multiDate1).css('border-color', "#000000")
					
				} else {
					$('#'+multiDate1).css('border-color', "#FF0000")
					++count;
				}
				
			} else {
				if(multiDate) {
					$('#'+multiDate1).css('border-color', "#000000")
					
				} else {
					$('#'+multiDate1).css('border-color', "#FF0000")
					++count;
				}
			}
			
			if(name) {
				$('#name').css('border-color', "#000000")	
			} else {
				$('#name').css('border-color', "#FF0000")
				++count;
			}
			
			if(sevaCombo) {
				$('#sevaCombo').css('border-color', "#000000")	
			} else {
				$('#sevaCombo').css('border-color', "#FF0000")
				++count;
			}
		}
		
		if(count == 0) {
			let postage = 0;
			if(document.getElementById("postage").checked == true) {
				postage = 1;
			} else {
				postage = 0;
			}
			let postageAmt = $('#postageAmt').val();
			let addressLine1 = $('#addLine1').val();
			let addressLine2 = $('#addLine2').val();
			let city = $('#city').val();
			let country = $('#country').val();
			let pincode = $('#pincode').val();
			
			let address = $('#address').val();
			let url = "<?=site_url()?>TrustEvents/generateSevaReceipt"
			let tableSevaCombo = [];
			let tableQty = [];
			let tableDate = [];
			let tablePrice = [];
			let tableAmt = [];
			let hiddenEventId = [];
			let hiddenIsSeva = [];
			
			tableSevaComboObj = document.getElementsByClassName('tableSevaCombo');
			hiddenIsSevaObj = document.getElementsByClassName('hiddenIsSeva');
			tableQtyObj = document.getElementsByClassName('tableQty');
			tableDateObj = document.getElementsByClassName('tableDate');
			tablePriceObj = document.getElementsByClassName('tablePrice');
			tableAmtObj = document.getElementsByClassName('tableAmt');
			hiddenEventIdObj = document.getElementsByClassName('hiddenEventId');
			let error = 0;

			const today = new Date();
			const yyyy = today.getFullYear();
			let mm = today.getMonth() + 1;
			let dd = today.getDate();
			if (dd < 10) dd = '0' + dd;
			if (mm < 10) mm = '0' + mm;
			const formattedToday = dd + '-' + mm + '-' + yyyy;
			
			for(let i = 0; i < tableSevaComboObj.length; ++i) {
				tableSevaCombo[i] = tableSevaComboObj[i].innerHTML.trim();
				tableQty[i] = tableQtyObj[i].innerHTML.trim();
				tableDate[i] = tableDateObj[i].innerHTML.trim() ? tableDateObj[i].innerHTML.trim() : formattedToday;
				tablePrice[i] = tablePriceObj[i].innerHTML.trim();
				hiddenEventId[i] = hiddenEventIdObj[i].innerHTML.trim();
				hiddenIsSeva[i] = hiddenIsSevaObj[i].innerHTML.trim();
			}
			

			$.post(url, {
				'transactionId':transactionId,
				'etName':etName,
				'etId':etId,
				'chequeNo':chequeNo,
				'branch':branch,
				'bank':bank,
				'chequeDate':chequeDate,
				'modeOfPayment':modeOfPayment,
				'hiddenEventId':JSON.stringify(hiddenEventId),
				'hiddenIsSeva':JSON.stringify(hiddenIsSeva),
				'tableSevaCombo':JSON.stringify(tableSevaCombo),
				'tableQty':JSON.stringify(tableQty),
				'tableDate':JSON.stringify(tableDate),
				'tablePrice':JSON.stringify(tablePrice),
				'tableAmt':JSON.stringify(tableAmt),
				'totalAmt':total,
				'name':name,
				'number':number,
				'rashi':rashi,
				'nakshatra':nakshatra,
				'paymentNotes':paymentNotes,
				'postage': postage,
				'postageAmt': postageAmt,
				'addressLine1': addressLine1,
				'addressLine2': addressLine2,
				'city': city,
				'country': country,
				'pincode': pincode,
				'address':address,
				'pan':pan,
				'adhaar':adhaar,
				'flghBank': flghBank 
						}, function(e) {
				
				e1 = e.split("|")
				if(e1[0] == "success")
					location.href = "<?=site_url();?>TrustEvents/printSevaReceipt";
				else if(e1[0] == "stock"){
					alert("Information", "Your Quantity exceed Current Stock for " + e1[1]);
				} else if(e1[0] == "limit"){
					alert("Information","All Sevas are currently Reserved on Date " + e1[2] + " for " + e1[1])
				} else {
					alert("Something went wrong " + e);
				}
		 })
			
		} else
			alert("Information","Please fill required fields","OK");
	});
	
	var totalStockAvailable = 0;	
	// $('#qty').keydown((e)=> {
		// if($('#qty').val().length == 10  && e.keyCode != 46
        // && e.keyCode != 8) {
			// e.preventDefault();
		// }
	// }); for length

	<!-- Cheque Number Validation -->
	$('#chequeNo').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^0-9]/g, function(str) { return ''; } ) );
	});
	
	<!-- Transaction Id Validation -->
	$('#transactionId').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^A-Za-z0-9]/g, function(str) { return ''; } ) );
	});
	
	<!-- Rashi Validation -->
	$('#rashi').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^A-Za-z]/g, function(str) { return ''; } ) );
	});
	
	<!-- Nakshatra Validation -->
	$('#nakshatra').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^A-Za-z]/g, function(str) { return ''; } ) );
	});
	
	<!-- Phone Validation -->
	var blnDigitConfirm = false;                                                //When a particular digit is set for 10 or for 11
	var blnDigitSet = 0;                                                       //When a particular digit is set in this case 10 digits for mobile number and 11 digits for a landline
	$('#phone').keyup(function (e) {
		var $th = $(this);
		$th.val( $th.val().replace(/[^0-9]/g, function(str) { return ''; } ) );
		
		if(!blnDigitConfirm && $th.val().length <= 11) {
			if($th.val().length == 10) {
				var res = $th.val().match(/^[0][1-9]\d{9}$|^[1-9]\d{9}$/g);
				if(res == $th.val()) { 
					blnDigitConfirm = true;
					blnDigitSet = 10;
				}
				else 
					blnDigitConfirm = false;
			}
			
			if(!blnDigitConfirm && $th.val().length == 11) {
				var res = $th.val().match(/^[0][1-9]\d{9}$|^[1-9]\d{9}$/g);
				if(res == $th.val()) {
					blnDigitConfirm = true;
					blnDigitSet = 11;
				}
				else { 
					if(blnDigitSet == 10) {
						$th.val($th.val().substring(0,10));
						blnDigitConfirm = false;
					}
				}
			}
		} else {
			if(blnDigitSet == 10) {
				$th.val($th.val().substring(0,10));
				blnDigitConfirm = false;
			}
			
			if(blnDigitSet == 11) {
				$th.val($th.val().substring(0,11));
				blnDigitConfirm = false;
			}
		}
	});
	
	$('#qty').keyup(function(e) {
		var $th = $(this);
		
		if(e.keyCode != 46 && e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 38 && e.keyCode != 39 && e.keyCode != 40) {
			$th.val( $th.val().replace(/[^0-9]/g, function(str) { return ''; } ) );
		}return;
	});
	
	function checkDuplicate() {
		let url = "<?=site_url()?>Events/generateSevaReceipt"
		let tableSevaCombo = [];
		let tableQty = [];
		let tableDate = [];
		let duplicate = 0;
		let qty = $('#qty').val();
		let sevaCombo1 = $('#sevaCombo option:selected').html().split("=")
		let sevaCombo = sevaCombo1[0];
		
		if($('.multiDate').is(':visible')) {
			multiDate = $('#multiDate').val();
		} else if($('.multiDate1').is(':visible')) {
			multiDate = $('#multiDate1').val();
		}
		
		date = $("#selDate").text();
		
		date2 = date.split(",");
		
		tableSevaComboObj = document.getElementsByClassName('tableSevaCombo');
		tableQtyObj = document.getElementsByClassName('tableQty');
		tableDateObj = document.getElementsByClassName('tableDate');
		
		for(let i = 0; i < tableSevaComboObj.length; ++i) {
			if(duplicate != 0)
						break;
			tableSevaCombo[i] = tableSevaComboObj[i].innerHTML.trim();
			tableQty[i] = tableQtyObj[i].innerHTML.trim();
			tableDate[i] = tableDateObj[i].innerHTML.trim();
			
			if(eventSeva[1] == 1 && eventSeva[2] != 1) {
				for(let k = 0; k < date2.length; ++k) {
					if(sevaCombo.trim() == tableSevaCombo[i].trim()) {
						alert("Information", sevaCombo + " Already Exists")
						++duplicate;
						break;
					}
				}
				
			}else if(eventSeva[2] == 1) {
				let multidateArray = multiDate.split(",");
				for(let j = 0; j < multidateArray.length; ++j) {
					date = multidateArray[j];
					if(date == tableDate[i].trim() && sevaCombo.trim() == tableSevaCombo[i].trim()) {
						alert("Information", sevaCombo + " Already Exists on " + multidateArray[j])
						++duplicate;
						break;
					}
				}
				
			}
			
		}
		
		return Number(duplicate);
	}
	
	//COMPARING DATES
	function dateObj(d) { // date parser ...
		var parts = d.split(/:|\s/),
			date  = new Date();
		if (parts.pop().toLowerCase() == 'pm') {
			parts[0] = ((+parts[0]) + 12).toString();
		} 
		
		date.setHours(+parts.shift());
		date.setMinutes(+parts.shift());
		return date;
	}
	
	function validateSubmit() {
		//TO CHECK FOR TIME ALLOWED TO ENTER
		var startTime = "<?php echo $_SESSION['time'][0]->TIME_FROM; ?>";
		var endTime   = "<?php echo $_SESSION['time'][0]->TIME_TO; ?>";
		var now       = new Date();
		
		var startDate = dateObj(startTime); // get date objects
		var endDate   = dateObj(endTime);
		
		var open = now < endDate && now > startDate ? true : false; // compare
		if(open) {
			alert("Information","You are not allowed to book sevas till " + endTime);
			return false;
		} 
		
		if($('#phone').val() != "") {
			if($('#phone').val().length < 10) {
				alert("Information", "Please add a 10 digit mobile or a 11 digit landline.");
				return;
			}
		}
		
		//TO CHECK FOR TIME ALLOWED TO ENTER ENDS HERE
		
		if(tableContent.length == 0) {
			alert("Information", "Add atleast one seva to submit.")
			return;
		}
		
		let count = 0;
		let modeOfPayment = $('#modeOfPayment option:selected').val();
		let toBank = $('#tobank option:selected').val();												//adithya
		let DCtoBank = $('#DCtobank option:selected').val();											//adithya
		let transactionId = $('#transactionId').val();
		let chequeNo = "";
		let chequeDate = "";
		let bank = "";
		let branch = "";
		let name = $('#name').val() 
		let multiDate =	"";	
		if($('.multiDate').is(':visible')) {
			multiDate = $('#multiDate').val();
			if(multiDate){
				$('#multiDate').css('border-color', "#000000")
			} else {
				$('#multiDate').css('border-color', "#FF0000");
			}
			multiDate1 = 'multiDate'
		} else if($('.multiDate1').is(':visible')) {
			multiDate = $('#multiDate1').val();
			multiDate1 = 'multiDate1'
			if(multiDate){
				$('#multiDate1').css('border-color', "#000000")
			} else {
				$('#multiDate1').css('border-color', "#FF0000");
			}
		} 
		let number = $('#phone').val() 
		let rashi = $('#rashi').val() 
		let nakshatra = $('#nakshatra').val()
		let qty = $('#qty').val()
		let paymentNotes = $('#paymentNotes').val();
		let sevaCombo = $('#sevaCombo option:selected').val();
		let etName = "<?=@$event['TET_NAME']; ?>"
		let etId = "<?=@$event['TET_ID']; ?>"
		let heading = etName;
			if(modeOfPayment == "Cheque") {
				chequeNo = $('#chequeNo').val();
				chequeDate = $('#chequeDate').val();
				bank = $('#bank').val();
				branch = $('#branch').val();
				
				if(chequeNo.length == 6) {
					$('#chequeNo').css('border-color', "#800000");
				} else {
					$('#chequeNo').css('border-color', "#FF0000");
					++count;
				}
				
				if(chequeDate){
					$('#chequeDate').css('border-color', "#800000");
				} else {
					$('#chequeDate').css('border-color', "#FF0000");
					++count;
				}
				
				if(bank){
					$('#bank').css('border-color', "#800000");
				} else {
					$('#bank').css('border-color', "#FF0000");
					++count;
				}
				
				if(branch){
					$('#branch').css('border-color', "#800000");
				} else {
					$('#branch').css('border-color', "#FF0000");
					++count;
				}
			}else if (modeOfPayment == "Credit / Debit Card") {								//it was in comment before edited 
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
		}else if (modeOfPayment == "Direct Credit") {									//laz
			if (toBank!=0) {
				
				$('#tobank').css('border-color', "#800000");
			} else {
				$('#tobank').css('border-color', "#FF0000");
				++count;
			}																			//laz..
		}  else {
				$('#chequeNo').css('border-color', "#800000");
				$('#branch').css('border-color', "#800000");
				$('#bank').css('border-color', "#800000");
				$('#chequeDate').css('border-color', "#800000");
			}
			
			if(modeOfPayment) {
				$('#modeOfPayment').css('border-color', "#000000")	
			} else {
				$('#modeOfPayment').css('border-color', "#FF0000")
				++count;
			}
		
		if(tableContent.length == 0) { 
			if(eventSeva[1] == 1 && eventSeva[2] != 1) { //qty picker
				if(qty != "" && qty != 0) {
					$('#qty').css('border-color', "#000000")
				} else {
					$('#qty').css('border-color', "#FF0000")
					++count;
				}
				
			} else if(eventSeva[2] == 1 && eventSeva[1] == 1) {
				if(qty && qty != 0) {
					$('#qty').css('border-color', "#000000")
					
				} else {
					$('#qty').css('border-color', "#FF0000")
					++count;
				}
				
				if(multiDate) {
					$('#'+multiDate1).css('border-color', "#000000")
				} else {
					$('#'+multiDate1).css('border-color', "#FF0000")
					++count;
				}
				
			} else {
				if(multiDate) {
					$('#'+multiDate1).css('border-color', "#000000")
				} else {
					$('#'+multiDate1).css('border-color', "#FF0000")
					++count;
				}
			}
			
			if(name) {
				$('#name').css('border-color', "#000000")	
			} else {
				$('#name').css('border-color', "#FF0000")
				++count;
			}
			
			if(sevaCombo) {
				$('#sevaCombo').css('border-color', "#000000")	
			} else {
				$('#sevaCombo').css('border-color', "#FF0000")
				++count;
			}
		}
		
		$("#address").val("");
		let ths = document.getElementById('postage');
		let postageAmt = $('#postageAmt'); 
		let addLine1 = $('#addLine1'); 
		let addLine2 = $('#addLine2'); 
		let city = $('#city');
		let country = $('#country');
		let pincode = $('#pincode');
		let address = "";
		if(ths.checked) {
			if(postageAmt.val().trim().length > 0) {
				postageAmt.css('border-color', "#800000");
			} else {
				postageAmt.css('border-color', "#FF0000");
				count++;
			}
			
			if(addLine1.val().trim().length > 0) {
				address += addLine1.val() + ", ";
				addLine1.css('border-color', "#800000");
			} else {
				addLine1.css('border-color', "#FF0000");
				count++;
			}
			
			if(addLine2.val().trim().length > 0) {
				address += addLine2.val() + ", ";
			}
			
			if(city.val().trim().length > 0) {
				address += city.val() + ", ";
				city.css('border-color', "#800000");
			} else {
				city.css('border-color', "#FF0000");
				count++;
			}
			
			if(country.val().trim().length > 0) {
				address += country.val() + ", ";
				country.css('border-color', "#800000");
			} else {
				country.css('border-color', "#FF0000");
				count++;
			}
			
			if(pincode.val().trim().length > 0) {
				address += pincode.val();
				pincode.css('border-color', "#800000");
			} else {
				pincode.css('border-color', "#FF0000");
				count++;
			}
			
			//address =  + ", " + addLine2.val() + ", " + city.val() + ", " + country.val() + ", " + pincode.val();
			$('#address').val(address);
		} else {
			if(addLine1.val().trim().length > 0) {
				address += addLine1.val() + ", ";
			}
			
			if(addLine2.val().trim().length > 0) {
				address += addLine2.val() + ", ";
			}
			
			if(city.val().trim().length > 0) {
				address += city.val() + ", ";
			}
			
			if(country.val().trim().length > 0) {
				address += country.val() + ", ";
				
			}
			
			if(pincode.val().trim().length > 0) {
				address += pincode.val();
			}
			$('#address').val(address);
		}
		
		if(count == 0) {		
			$('#eventUpdate2').html("");
			$('.modal-body').html('<div class="table-responsive"><table class="table table-bordered"><thead><tr><th><center>Sl. No.</center></th><th>Seva Name</th><th><center>Qty</center></th><th><center>Seva Date</center></th><th><center>Seva Amount</center></th><th><center>Total Amount</center></th></tr></thead><tbody id="eventUpdate2"></tbody></table></div>')
			
			tableSevaComboObj = document.getElementsByClassName('tableSevaCombo');
			hiddenIsSevaObj = document.getElementsByClassName('hiddenIsSeva');
			tableQtyObj = document.getElementsByClassName('tableQty');
			tableDateObj = document.getElementsByClassName('tableDate');
			tablePriceObj = document.getElementsByClassName('tablePrice');
			tableAmtObj = document.getElementsByClassName('tableAmt');
			hiddenEventIdObj = document.getElementsByClassName('hiddenEventId');
			let error = 0;
				
			for(let i = 0; i < tableSevaComboObj.length; ++i) {
				$('#eventUpdate2').append("<tr>");
				$('#eventUpdate2').append("<td><center>"+ (i+1) +"</center></td>");
				$('#eventUpdate2').append("<td>"+ tableSevaComboObj[i].innerHTML.trim() +"</td>");
				$('#eventUpdate2').append("<td><center>"+ tableQtyObj[i].innerHTML.trim() +"</center></td>");
				$('#eventUpdate2').append("<td><center>"+ tableDateObj[i].innerHTML.trim() +"</center></td>");
				$('#eventUpdate2').append("<td><center>"+ tablePriceObj[i].innerHTML.trim() +"</center></td>");
				$('#eventUpdate2').append("<td><center>"+ tableAmtObj[i].innerHTML.trim() +"</center></td>");
				$('#eventUpdate2').append("</tr><br/>");
			}
			$('.modal-body').append("<label class='samFont eventsFont2'><center>"+ heading +"</center></label><br/>");	
			$('.modal-body').append("<label>DATE:</label> "+ "<?=date('d-m-Y'); ?>" +"<br/>");
			$('.modal-body').append("<label>NAME:</label> "+ name +"");
			if(number)
				$('.modal-body').append(",&nbsp;&nbsp;<label>NUMBER:</label> "+ number +"");	
		
			if(rashi)
				$('.modal-body').append(",&nbsp;&nbsp;<label>RASHI:</label> "+ rashi +"");	
			if(nakshatra)
				$('.modal-body').append(",&nbsp;&nbsp;<label>NAKSHATRA:</label> "+ nakshatra +"");
		
			$('.modal-body').append("<br/>");
			if(address)
				$('.modal-body').append("<label>ADDRESS:</label> "+ address +"<br/>");
			
			$('.modal-body').append("<label>TOTAL AMOUNT:</label> "+ total +"<br/>");
			if(ths.checked) {
				if(postageAmt.val().trim().length > 0) {
					$('.modal-body').append("<label>POSTAGE AMOUNT:</label> " + postageAmt.val() + "<br/>");
				}
			}
			$('.modal-body').append("<label>MODE OF PAYMENT:</label> "+ modeOfPayment +"<br/>");
			
			if(modeOfPayment == "Cheque") {
				$('.modal-body').append("<label>CHEQUE NO:</label> "+ chequeNo +",&nbsp;&nbsp;");
				$('.modal-body').append("<label>CHEQUE DATE:</label> "+ chequeDate +",&nbsp;&nbsp;");
				$('.modal-body').append("<label>BANK:</label> "+ bank +",&nbsp;&nbsp;");
				$('.modal-body').append("<label>BRANCH:</label> "+ branch +"<br/>");
			
				} else if(modeOfPayment == "Credit / Debit Card") {
					$('.modal-body').append("<label>TRANSACTION ID:</label> "+ transactionId +"<br/>");
				}
				
				if(paymentNotes)
					$('.modal-body').append("<label>PAYMENT NOTES:</label> "+ paymentNotes +"<br/>");
				
				$('.modal').modal();
				$('.bs-example-modal-lg').focus();
				
		} else
			alert("Information","Please fill required fields","OK");
	}
	
	$('#pincode').keyup(function(e) {
		var $th = $(this);
		if(e.keyCode != 46 && e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 38 && e.keyCode != 39 && e.keyCode != 40) {
			$th.val( $th.val().replace(/[^0-9]/g, function(str) { return ''; } ) );
		}return;
	});
	
	$('#postageAmt').keyup(function(e) {
		var $th = $(this);
		if(e.keyCode != 46 && e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 38 && e.keyCode != 39 && e.keyCode != 40) {
			$th.val( $th.val().replace(/[^0-9]/g, function(str) { return ''; } ) );
		}return;
	});
	
	// $(':input').on('keypress', function() {
		// var id = this.id;
		// $('#' + id).css('border-color', "#000000");
	// });
	
	$('select').on('change', function() {
		var id = this.id;
		$('#' + id).css('border-color', "#000000");
	});
	
		//check for which form is displayed
	var showScreenSize = "";
	
	if($('.show-large').is(':visible')) {
		showScreenSize = "large";
	} else if($('.show-small').is(':visible')) {
		showScreenSize = "small";
	}
	//check for which form is displayed ends
	
		$('#todayDateRadio').on('click', function() {
			$('#multiDate').val("");
			$('.multiDate').css('pointer-event','none');
			$('.selDate').fadeOut();
			$('#selDate').html("");
		});
		
		$('#multiDateRadio').on('click', function() {
			$('#todayDateRadio').css('pointer-event','none');
			$('.selDate').fadeIn();
		});
		
		$('#sevaCombo').on('change', function() {
		
			$('#multiDate1').css('border-color', "#000000")
			$('#multiDate').css('border-color', "#000000")
			eventSeva = this.value
			eventSeva = eventSeva.split("|");
			limit = [];
			availableDates = [];
			currentSevaLength = 0;
			$('#qty').val(1);
			$('#selDate').html("");
			$('#setPrice').html("");
			$('#multiDate').multiDatesPicker('resetDates');
			$('#multiDate1').datepicker('setDate', null);
			$('#sevaAvailable').html("");
			$('#booked').html("");
			$('#stockAvailable').html("");
			$('#multiDate').multiDatesPicker('resetDates');
			$('#multiDate1').datepicker('setDate', null);
			console.log("eventSeva",eventSeva)
			$.post("<?=site_url()?>TrustEvents/getSevaLimit", {'idName':eventSeva[3],'stock':eventSeva[2]}, function(e) {
				limit = JSON.parse(e);

				if(limit.length > 0) {
					if(eventSeva[1] == 1 && eventSeva[2] != 1) {
						$('.sevaAvailable').slideUp();
						$('.stockAvailable').slideDown();
						
						limitStock = 0;
						for(let i = 0; i < limit.length; ++i) {
								limitStock += Number(limit[i]['TET_SEVA_LIMIT']);
						}
						
						console.log(limitStock);
						
						$.post('<?=site_url()?>TrustEvents/getStock', {'id':eventSeva[3],'stock':eventSeva[2]}, function(d) {
							
							var totalStock = JSON.parse(d);
							// console.log(totalStock)
							var totalStock1 = 0;
							for(let i = 0; i < totalStock.length; ++i) {
									totalStock1 += Number(totalStock[i]['TET_SO_QUANTITY']);
							}
							console.log(totalStock1)
							totalStockAvailable = (Number(limitStock) - Number(totalStock1))
							if(totalStockAvailable > 0)
								$('#stockAvailable').html(totalStockAvailable)
							else
								$('#stockAvailable').html(0)
							// console.log(totalStockAvailable)
							
						});
				
					}
					else if(eventSeva[2] == 1) {
						$('.sevaAvailable').slideDown();
						$('.stockAvailable').slideUp();
						for(let i = 0; i < limit.length; ++i) {
							availableDates[i] = limit[i]['TET_SEVA_DATE'].replace(/(^|-)0+/g, "$1");
						}
						$('.multiDate').slideUp();
						$('.multiDate1').slideDown();
					}
				}else {
					$('.sevaAvailable').slideUp();
					$('.stockAvailable').slideUp();
					$("#multiDate").multiDatesPicker({
						minDate: minDate1, 
						maxDate: maxDate1,
						dateFormat: 'dd-mm-yy',
						autoclose: false,
						onSelect: function (selectedDate) {
							$('#multiDate').css('border-color', "#000000")
							$('#selDate').html($('#multiDate').val());
							$('#multiDate').blur();
							$('#multiDate').css('border-color', "#000000");
						}
					});
					
					$('.multiDate').slideDown();
					$('.multiDate1').slideUp();
				}
			});
			if(eventSeva[1] == 1 && eventSeva[2] != 1) {
				$('.sevaDate').slideUp();
				$('.selDate').slideUp();
				$('.quantity').slideDown('slow');
				
				
			}else if(eventSeva[2] == 1 && eventSeva[1] == 1) {
				$('.quantity').slideDown('slow');
				$('.sevaDate').slideDown('slow');
				$('.selDate').slideDown();
			}else {
				$('.quantity').slideUp();
				$('.sevaDate').slideDown('slow');
				$('.selDate').slideDown();
			}
			$('#setPrice').html(eventSeva[0]);
			price = Number(eventSeva[0]);
			
			if(eventSeva[4] == 1) {
				
				$('#multiDate1').css({'border-color':"#000000","cursor":"no-drop"})
				$('#multiDate').css({'border-color':"#000000","cursor":"no-drop"})
				$('.todayDate').css({'border-color':"#000000","cursor":"no-drop"})
				$('.todayDate1').css({'border-color':"#000000","cursor":"no-drop"})
				
				$('#multiDate1').prop( "disabled", true );
				$('#multiDate').prop( "disabled", true );
				$('.todayDate').prop( "disabled", true );
				$('.todayDate1').prop( "disabled", true );
				
				$('#multiDate1').val("<?=date('d-m-Y')?>");
				$('#multiDate').val("<?=date('d-m-Y')?>");
				$('#selDate').html($('#multiDate').val());
			}else {
			
				$('#multiDate1').css("cursor","auto")
				$('#multiDate').css("cursor","auto")
				$('.todayDate').prop( "disabled", false );
				$('.todayDate1').prop( "disabled", false );
				$('#multiDate1').prop( "disabled", false );
				$('#multiDate').prop( "disabled", false );
			}
			
		})
		
		$('#modeOfPayment').on('change', function () {							//laz
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
		
	function checkConfirmTime(date) {
		$.ajax({
            type: "POST",
            url: "<?php echo base_url();?>TrustEvents/check_event_eod_confirm_date_time",
            success: function (response) {
				if(response == 0){
					addRow();
				} else {
					alert("Information","The EOD for " +date+ " already generated");
				}
			}
        }); 
	}		
	function addRow() {
		let duplicate = checkDuplicate();
		if(duplicate != 0)
			return;
		let count = 0;
		let modeOfPayment = $('#modeOfPayment option:selected').val();
		let chequeNo = "";
		let chequeDate = "";
		let bank = "";
		let branch = "";
		let name = $('#name').val();
		let multiDate =	"";	
		
		let number = $('#phone').val() 
		let rashi = $('#rashi').val() 
		let nakshatra = $('#nakshatra').val()
		let qty = $('#qty').val()
		
		if($('.multiDate').is(':visible')) {
			multiDate = $('#multiDate').val();
			if(multiDate){
				$('#multiDate').css('border-color', "#000000")
			}else {
				$('#multiDate').css('border-color', "#FF0000");
			}
		} else if($('.multiDate1').is(':visible')) {
			multiDate = $('#multiDate1').val();
			if(multiDate){
				$('#multiDate1').css('border-color', "#000000")
			}else {
				$('#multiDate1').css('border-color', "#FF0000");
			}
			if(multiDate) {
				if(Number($('#sevaAvailable').html().trim()) < qty) {
					alert("Information","All Sevas are currently Reserved on this Date " + multiDate)
					return 0;
				}
			}
		}
		
		let sevaCombo = $('#sevaCombo option:selected').val();
		
		if(eventSeva[1] == 1 && eventSeva[2] != 1) { //qty picker
			if(qty && qty != 0) {
				$('#qty').css('border-color', "#000000")
			}else {
				$('#qty').css('border-color', "#FF0000")
				++count;
			}
			
			if(totalStockAvailable < qty) {
				alert("Information", "Your Quantity exceed Current Stock ");
				return;
			}
			
		}else if(eventSeva[2] == 1 && eventSeva[1] == 1) {
			if(qty && qty != 0) {
				$('#qty').css('border-color', "#000000")
				
			}else {
				$('#qty').css('border-color', "#FF0000")
				++count;
			}
			
			if(multiDate) {
				$('#multiDate').css('border-color', "#000000")
				
			}else {
				$('#multiDate').css('border-color', "#FF0000")
				++count;
			}
			
		}else {
			if(multiDate) {
				$('#multiDate').css('border-color', "#000000")
				
			}else {
				$('#multiDate').css('border-color', "#FF0000")
				++count;
			}
		}
		
		if(name) {
			$('#name').css('border-color', "#000000")
				
		}else {
				$('#name').css('border-color', "#FF0000")
				++count;
		}
		
		if(sevaCombo) {
			$('#sevaCombo').css('border-color', "#000000")
				
		}else {
				$('#sevaCombo').css('border-color', "#FF0000")
				++count;
		}
		
		if(modeOfPayment == "Cheque") {
			let chequeNo = $('#chequeNo').val();
			let chequeDate = $('#chequeDate').val();
			let bank = $('#bank').val();
			let branch = $('#branch').val();
			if(chequeNo.length == 6) {
				$('#chequeNo').css('border-color', "#800000");
			}else {
				$('#chequeNo').css('border-color', "#FF0000");
				++count;
			}
			
			if(chequeDate){
				$('#chequeDate').css('border-color', "#800000");
			}else {
				$('#chequeDate').css('border-color', "#FF0000");
				++count;
			}
			
			if(bank){
				$('#bank').css('border-color', "#800000");
			}else {
				$('#bank').css('border-color', "#FF0000");
				++count;
			}
			
			if(branch){
				$('#branch').css('border-color', "#800000");
			}else {
				$('#branch').css('border-color', "#FF0000");
				++count;
			}
		}else {
			$('#chequeNo').css('border-color', "#800000");
			$('#branch').css('border-color', "#800000");
			$('#bank').css('border-color', "#800000");
			$('#chequeDate').css('border-color', "#800000");
		}
		
		if(count == 0) {
			let name = $('#name').val() 
			let number = $('#phone').val() 
			let rashi = $('#rashi').val() 
			let nakshatra = $('#nakshatra').val()
			let sevaCombo1 = $('#sevaCombo option:selected').html().split("=")
			let sevaCombo = sevaCombo1[0];
			let setPrice = Number($('#setPrice').html())
			let date = "";
			
			
			date = $("#selDate").text();
			
		
			date2 = date.split(",");
			let qty = 0;
			
			if(eventSeva[1] == 1 && eventSeva[2] != 1) {
				$('.sevaDate').slideUp();
				$('.selDate').slideUp();
				$('.quantity').slideDown('slow');
				qty = Number($('#qty').val());
				
			}else if(eventSeva[2] == 1 && eventSeva[1] == 1) {
				$('.quantity').slideDown('slow');
				$('.sevaDate').slideDown('slow');
				qty = Number($('#qty').val());
			}else {
				$('.quantity').slideUp();
				$('.sevaDate').slideDown('slow');
				$('.selDate').slideDown();
				qty = 1;
			}
			
			let amt = price * qty;
			
			total += amt
			$('#totalAmount').html(total);
			
			let si = $('#eventSeva tr:last-child td:first-child').html();
			if(!si)
				si = 1
			else
				++si;
			
			if(eventSeva[2] == 1 && eventSeva[1] == 1) {
				let multidateArray = multiDate.split(",");
				for(let i = 0; i < multidateArray.length; ++i) {
					date = multidateArray[i];
					tableContent[si-1] = '<td class="tableSevaCombo">'+ sevaCombo + '</td><td class="hiddenEventId" style="display:none">'+ eventSeva[3] +'</td>' +'<td class="hiddenIsSeva" style="display:none">' + eventSeva[2] + '</td>' + '<td class="tableQty">'+ qty + '</td><td class="tableDate">'+ date + '</td><td class="tablePrice">'+ price + '</td><td class="tableAmt">'+ amt + '</td>';
					
					$('#eventSeva').append('<tr><td class="tableSi">'+si+'</td><td class="tableSevaCombo">'+ sevaCombo + '</td><td class="hiddenEventId" style="display:none">' + eventSeva[3] + '</td>'+'<td class="hiddenIsSeva" style="display:none">' + eventSeva[2] + '</td>' + '<td class="tableQty">'+ qty + '</td><td class="tableDate">'+ date + '</td><td class="tablePrice">'+ price + '</td><td class="tableAmt">'+ amt + '</td><td><a style="cursor:pointer;" onClick="updateTable('+ (si-1) +');"><img style="width:24px; height:24px;" title="delete" src="../images/delete1.svg"></td></tr>');
					++si;
				}
				//updateTable(0)
				
				tableAmt = document.getElementsByClassName('tableAmt');
		
				total = 0;
				for(let k = 0; k < tableAmt.length; ++k) {
					total += Number(tableAmt[k].innerHTML);
				}
				
				$('#totalAmount').html(total);
				
			}else {
				for(let i = 0; i < date2.length; ++i) {
					tableContent[si-1] = '<td class="tableSevaCombo">'+ sevaCombo + '</td><td class="hiddenEventId" style="display:none">' + eventSeva[3] + '</td>' +'<td class="hiddenIsSeva" style="display:none">' + eventSeva[2] + '</td>' + '<td class="tableQty">'+ qty + '</td><td class="tableDate">'+ date2[i] + '</td><td class="tablePrice">'+ price + '</td><td class="tableAmt">'+ amt + '</td>';
					
					$('#eventSeva').append('<tr><td class="tableSi">'+si+'</td><td class="tableSevaCombo">'+ sevaCombo + '</td><td  class="hiddenEventId" style="display:none">' + eventSeva[3] + '</td>'+'<td class="hiddenIsSeva" style="display:none">' + eventSeva[2] + '</td>' + '<td class="tableQty">'+ qty + '</td><td class="tableDate">'+ date2[i] + '</td><td class="tablePrice">'+ price + '</td><td class="tableAmt">'+ amt + '</td><td><a style="cursor:pointer;" onClick="updateTable('+ (si-1) +');"><img style="width:24px; height:24px;" title="delete" src="../images/delete1.svg"></td></tr>');
					++si;
				}
				//updateTable(0)
				tableAmt = document.getElementsByClassName('tableAmt');
		
				total = 0;
				for(let k = 0; k < tableAmt.length; ++k) {
					total += Number(tableAmt[k].innerHTML);
				}
				
				$('#totalAmount').html(total);
			}
			
			$('#qty').val(1);
			$('#stockAvailable').html("");
			$('#sevaCombo').val("")
			$('#selDate').html("");
			$('#setPrice').html("");
			$('#multiDate').multiDatesPicker('resetDates');
			$('#multiDate1').datepicker('setDate', null);
			$('#sevaAvailable').html("");
			$('#booked').html("");
		}else
			alert("Information","Please fill required fields","OK");
	}
	
	function updateTable(si) {
		tableContent2 = [];
		tableContent3 = [];
		for(var i = 0, j = 1, s = 0; i < tableContent.length; i++) {
			if(i != si) {
					tableContent2[s] = '<tr><td class="tableSi">'+ j +'</td>' + tableContent[i] + '<td><a style="cursor:pointer;" onClick="updateTable('+ s +');"><img style="width:24px; height:24px;" title="delete" src="../images/delete1.svg"></td></tr>';
					tableContent3[s] = tableContent[i];
					++j;
					++s;
			}
		}
		
		si = s;
		tableContent = tableContent3;
		
		$('#eventUpdate').html(tableContent2)
		
		tableAmt = document.getElementsByClassName('tableAmt');
		
		total = 0;
		for(let k = 0; k < tableAmt.length; ++k) {
			total += Number(tableAmt[k].innerHTML);
		}
		
		$('#totalAmount').html(total);
	}

	function available(date) {
		// console.log(date)
	  dmy = date.getDate() + "-" + (date.getMonth()+1) + "-" + date.getFullYear();
	  if ($.inArray(dmy, availableDates) != -1) {
		return [true, "","Available"];
	  } else {
		return [false,"","unAvailable"];
	  }
	}
	
	
		$("#multiDate1").datepicker({
		beforeShowDay: available,
		dateFormat: 'dd-mm-yy',
		minDate: minDate1, 
		maxDate: maxDate1,
		autoclose: false,
		onSelect: function (selectedDate) {
			$('#multiDate1').css('border-color', "#000000")
			$('#selDate').html($('#multiDate1').val());
			$('#multiDate').blur();
			$('#multiDate').css('border-color', "#000000");
			$.post('<?=site_url()?>TrustEvents/getSevaOffered',{'id':eventSeva[3], 'sevadate':selectedDate}, (e)=>{
				
				if(e.length > 0) {
					var currentSeva = JSON.parse(e);
					currentSevaLength = currentSeva.length;
					if(limit.length > 0) {
						if(eventSeva[2] == 1) {
							for(let i = 0; i < limit.length; ++i) {
								if(limit[i]['TET_SEVA_DATE'] == selectedDate) {
									currentSevaLength = (limit[i]['TET_SEVA_LIMIT'] - currentSevaLength);
									break;
								}
							}
							//alert(currentSevaLength)
							if(Number(currentSevaLength) > 0) {
								
								var booked = " (" + currentSeva.length + ")";
								$('#booked').html(booked);
								$('#sevaAvailable').html(currentSevaLength);
							} else {
								$('#sevaAvailable').html("0"); 
								$('#booked').html(""); 
							}
						}
					}
				}
			})
		}
	});

	$('.todayDate').on('click', function() {
		
		$("#multiDate").focus();
	});
	
	$('.todayDate1').on('click', function() {
		$("#multiDate1").focus();
	});
	
	$( ".chequeDate2" ).datepicker({
		dateFormat: 'dd-mm-yy'
	});
					
	$('.chequeDate').on('click', function() {
		$( ".chequeDate2" ).focus();
	});
</script>