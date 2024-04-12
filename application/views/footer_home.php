<form id="shashwathForm" method="post" action="<?php echo site_url();?>Shashwath/">
	<input type="hidden" id="genDate" name="generateDate" />
</form>
<style>
	.wrapFDexpiretrust{
	background-color: #800000;
	position: relative;
	display: inline-block;
	float: left;
	width: 75px;
	height: 60px;
	background-color: #800000;
	border-bottom: 1px solid #FDFDD9;	
}
.wrapChequePendingtrust{
	position: relative;
	display: inline-block;
	float: left;
	width: 75px;
	height: 60px;
	background: #800000;
	border-bottom: 1px solid #FDFDD9;
}

.wrapFDexpiretrust .tooltiptrustFd {
	visibility: hidden;
	background-color: #FDFDD9;
	color: #800000;
	text-align: center;
	border-radius: 6px;
	padding: 5px 0;
	border: 1px solid #800000;

	/* Position the tooltip */
	position: absolute;
	z-index: 1;
	top: 15px;
	left: 76px;
}

.wrapFDexpiretrust:hover .tooltiptrustFd {
	visibility: visible;
}
.wrapSecondtrust{
	/* width: 75px;
	height: 210px;
	border: 1px solid #800000;
	position: absolute;
	top: 0;
	left: 0;
	z-index: 10; */
}
.wrapChequePendingtrust .tooltiptrustChequePending {
	visibility: hidden;
	background-color: #FDFDD9;
	color: #800000;
	text-align: center;
	border-radius: 6px;
	padding: 5px 0;
	border: 1px solid #800000;

	/* Position the tooltip */
	position: absolute;
	z-index: 1;
	top: 15px;
	left: 76px;
}
.wrapChequePendingtrust:hover .tooltiptrustChequePending{
	visibility: visible;
}
.wrapSecond{
	width: 75px;
	height: 210px;
	/* border: 1px solid #800000; */
	position: absolute;
	background-color: #FDFDD9;
	top: 0;
	left: 0;
	z-index: 10;
}

	</style>

<?php if(isset($_SESSION['trustLogin']))if($_SESSION['trustLogin']== 0) {  ?>
	<?php if(isset($_SESSION['Notification'])) {?>
		<div class="wrapNotification" style="width:80px !important;display:block;">
		<?php } else { ?>
			<div class="wrapNotification" style="width:80px !important;display:none;">
			<?php } ?>
			<div class="wrapMain">

			</div>
			<div class="wrapSecond">
			    <div class="wrapHeader">
					<center><span class="glyphicon glyphicon-info-sign" style="color: #FDFDD9; font-size: 24px;"></span></center>
				</div>
                <?php if((isset($_SESSION['Shashwath_Seva']))) {?>
				<div class="wrapShashSeva">					
					<span class="badge41"></span>
					<div class="txtShashGenerate">
						<a class = "spnGenerate1" style="cursor:pointer; color: #FDFDD9;" href="#"><span class="spnGenerate" style="color:#FDFDD9; font-size:12px;">Shashwath Generate</span></a>
					</div>
					<span class="tooltipShashSeva">Shashwath Seva already generated for <?php echo date('d-m-Y', strtotime(date('d-m-Y'). ' + 2 days'))?></span>
				</div>
                <?php } ?>
                <?php if((isset($_SESSION['Shashwath_Loss_Report']))) {?>
				<div class="wrapShashLoss">
					<span class="badge42"></span>
					<div class="txtShashLoss">
						<a class = "spnLoss1" style="cursor:pointer; color: #FDFDD9;" href="#"><span class="spnLoss" style="color#FDFDD9; font-size:12px;">Shashwath Loss<span></a>
						</div>
						<span class="tooltipShashLoss"></span>
				</div>
                <?php }?>
                <?php if((isset($_SESSION['Shashwath_Seva']))) {?>
				<div class="wrapShSevaPrice">
						<span class="badge43"></span>
						<div class="txtShashPrice">
							<a class="lblStyle1" style="cursor:pointer; color: #FDFDD9;" href="#" ><span class="spnPrice" style="color:#FDFDD9; font-size:12px;">Shashwath Price</span></a>
						</div>
						<span class="tooltipShashPrice"></span>
				</div> 
                <?php }?>
				<?php if($this->session->userdata('userGroup') == 1 || 
					         $this->session->userdata('userGroup') == 6 || 
							 $this->session->userdata('userGroup') == 2) { ?>
                          
						<div class="wrapFDexpire">
							<span class="badge44"></span>
							<div class="txtfdexpire">
								<a class="lblStyle1" style="cursor:pointer; color: #FDFDD9;" href="#" ><span class="spnPrice" style="color:#FDFDD9; font-size:12px;">FD Expiry Details</span></a>
							</div>
							<span class="tooltipFd"></span>
					    </div> 

						<div class="wrapChequePending">
							<span class="badge45"></span>
							<div class="txtfdexpire">
								<a class="lblStyle1" style="cursor:pointer; color: #FDFDD9;" href="#" ><span class="spnPrice" style="color:#FDFDD9; font-size:12px;">Cheque Pending</span></a>
							</div>
							<span class="tooltipChequePending"></span>
						</div> 


						<?php if((isset($_SESSION['Event_EOD_Tally']))) {?>
						<div class="wrapEventChequePending">
							<span class="badge50"></span>
							<div class="txtChequePending">
								<a class="lblStyle1" style="cursor:pointer; color: #FDFDD9;" href="#" ><span class="spnPrice" style="color:#FDFDD9; font-size:12px;">Event Cheque Pending</span></a>
							</div>
							<span class="tooltipEventChequePending"></span>
						</div> 
			        <?php }?>

                    <!-- adding finance part cheque pending by adithya -->
                    <?php if((isset($_SESSION['Deity_Cheque_Remmittance']))) {?>
						<div class="wrapFinanceChequePending">
							<span class="badge51"></span>
							<div class="txtChequePending">
								<a class="lblStyle1" style="cursor:pointer; color: #FDFDD9;" href="#" ><span class="spnPrice" style="color:#FDFDD9; font-size:12px;">Finance Cheque Pending</span></a>
							</div>
							<span class="tooltipFinanceChequePending"></span>
						</div> 
			        <?php }?>

					



				<?php } ?>
			</div>			
		</div>

	<?php } else { ?>			
	<?php if(isset($_SESSION['Notification'])) {?>
		<div class="wrapNotification" style="width:80px !important;display:block;">
	<?php } else { ?>
			<div class="wrapNotification" style="width:80px !important;display:none;">
	<?php } ?>
		<div class="wrapMain">
		</div>
		<div class="wrapSecondtrust bg-danger">
			<div class="wrapHeader">					
				<center><span class="glyphicon glyphicon-info-sign" style="color: #FDFDD9; font-size: 24px;"></span></center>
			</div>
			
			<?php if($this->session->userdata('userGroup') == 1 || $this->session->userdata('userGroup') == 6 || $this->session->userdata('userGroup') == 2) { ?>
				<div class="wrapFDexpiretrust">
					<span class="badge46"></span>
					<div class="txtfdexpire">
						<a class="lblStyle1" style="cursor:pointer; color: #FDFDD9;"  href="#" >
							<span class="spnPrice" style="color:#FDFDD9; font-size:12px;" >FD Expiry Details</span></a>
					</div>
					  <span class="tooltiptrustFd"></span>
				</div> 

				<div class="wrapChequePendingtrust">
					<span class="badge47"></span>
					<div class="txtfdexpire">
						<a class="lblStyle1" style="cursor:pointer; color: #FDFDD9;" href="#" >
						<span class="spnPrice" style="color:#FDFDD9; font-size:12px;">Cheque Pending </span></a>
					</div>
					<span class="tooltiptrustChequePending"></span>
				</div> 

<!-- adding Event eod tally notification  for trust start -->
<?php  if(isset($_SESSION['E.O.D_Tally_Trust'])) {?>
						<div class="wrapFinanceTrustEventChequePending">
							<span class="badge52"></span>
							<div class="txtChequePending">
								<a class="lblStyle1" style="cursor:pointer; color: #FDFDD9;" href="#" ><span class="spnPrice" style="color:#FDFDD9; font-size:12px;">Event Cheque Pending </span></a>
							</div>
							<span class="tooltipFinanceTrustEventChequePending"></span>
						</div> 
				<?php }?>
<!-- end -->

				<!-- adding finance part cheque pending by adithya for trust-->
                <?php  if(isset($_SESSION['Cheque_Remmittance'])) {?>
						<div class="wrapFinanceTrustChequePending">
							<span class="badge49"></span>
							<div class="txtChequePending">
								<a class="lblStyle1" style="cursor:pointer; color: #FDFDD9;" href="#" ><span class="spnPrice" style="color:#FDFDD9; font-size:12px;">Finance Cheque Pending</span></a>
							</div>
							<span class="tooltipFinanceTrustChequePending"></span>
						</div> 
				<?php }?>
						
			<?php } ?>		
		</div>
	<?php } ?>

		<footer class="footer">			
			<div class="right-float"><a class="footerBtn">Powered By: Pinnacle Technologies</a></div>			
		</footer>

		<!-- Modal -->
		<script type="text/javascript">
			if(window.location.pathname == "/SLVT/login" || window.location.pathname == "/SLVT/"){
				$(".wrapNotification").hide();
			}
			$(document).ready(function(){
				$('.wrapShashSeva').click(function() {
					getProgressSpinner();
					$('#genDate').val("<?php echo date('d-m-Y', strtotime(date('d-m-Y'). ' + 2 days')); ?>");
					$('#shashwathForm').submit();
				});

				$('.wrapShashLoss').click(function() {
					location.href = "<?php echo site_url();?>Shashwath/lossReport";
				});

				$('.wrapShSevaPrice').click(function() {
					location.href = "<?php echo site_url();?>Shashwath/addSevaPrice";
				});

				$('.wrapFDexpire').click(function() {
					location.href = "<?php echo site_url();?>finance/Fddetails";
				});

				$('.wrapFDexpiretrust').click(function() {
			        location.href = "<?php echo site_url();?>Trustfinance/Fddetails";
	            });

	            $('.wrapChequePending').click(function() {
	            	location.href = "<?php echo site_url();?>EOD_Tally";
	            });

	            $('.wrapChequePendingtrust').click(function() {
	            	location.href = "<?php echo site_url();?>TrustEOD_Tally";
	            });

				$('.wrapFinanceChequePending').click(function(){
					location.href = "<?php echo site_url();?>admin_settings/Admin_setting/deityChequeRemmittance";
				});

				$('.wrapFinanceTrustChequePending').click(function(){
					location.href = "<?php echo site_url();?>admin_settings/Admin_Trust_setting/trustChequeRemmittance";
				});

				$('.wrapFinanceTrustEventChequePending').click(function(){
					location.href= "<?php echo site_url();?>TrustEventEOD_Tally/";
				})

				$('.wrapEventChequePending').click(function(){
					location.href ="<?php echo site_url();?>admin_settings/Admin_setting/chequeRemmittance";
				});
	            		
			});

			
		if('<?php if(isset($_SESSION['Notification'])) echo $_SESSION['Notification'] ?>' == 'Notif_Right' && '<?php if(isset($_SESSION['blnShashwathSevaExists'])) echo $_SESSION['blnShashwathSevaExists']; ?>' == 'false'){
				if('<?php if(isset($_SESSION['countGenerateSeva'])) echo $_SESSION['countGenerateSeva']?>' > 0){
					$('.badge41').html('<?php if(isset($_SESSION['countGenerateSeva'])) echo $_SESSION['countGenerateSeva'] ?>');
					$('.tooltipShashSeva').html("<?php if(isset($_SESSION['countGenerateSeva'])) echo $_SESSION['countGenerateSeva'] ?> Shashwath Seva not generated on <?php echo date('d-m-Y', strtotime(date('d-m-Y'). ' + 2 days'));?>");
				} else { 
					$('.spnGenerate1').css({"text-decoration": "none",  "pointer-events": "none"});
					$('.badge41').html(0);
					$('.tooltipShashSeva').html("No Shashwath Seva to generate on <?php  echo date('d-m-Y', strtotime(date('d-m-Y'). ' + 2 days'));?>");
				}
		} else { 
				$('.spnGenerate1').css({"text-decoration": "none",  "pointer-events": "none"});
				$('.badge41').html(0);
				$('.tooltipShashSeva').html("Shashwath Seva generated on <?php echo date('d-m-Y', strtotime(date('d-m-Y'). ' + 2 days'));?>");
		}

		if('<?php if(isset($_SESSION['countLossSeva'])) echo $_SESSION['countLossSeva']?>' > 0){
				$('.badge42').html(<?php if(isset($_SESSION['countLossSeva'])) echo $_SESSION['countLossSeva'] ?>);
				$('.tooltipShashLoss').html("<?php if(isset($_SESSION['countLossSeva'])) echo $_SESSION['countLossSeva'] ?> Shashwath Seva(s) have incurred loss. Please click and check");
			} else {
				$('.spnLoss1').css({"text-decoration": "none",  "pointer-events": "none"});
				$('.badge42').html(0);
				$('.tooltipShashLoss').html("No Shashwath Seva(s) have incurred loss");
		}

		if('<?php if(isset($_SESSION['sevaOfferedNoPriceCount'])) echo $_SESSION['sevaOfferedNoPriceCount'] ?>' > 0){
				$('.badge43').html('<?php if(isset($_SESSION['sevaOfferedNoPriceCount'])) echo $_SESSION['sevaOfferedNoPriceCount'] ?>');
				$('.tooltipShashPrice').html("<?php if(isset($_SESSION['sevaOfferedNoPriceCount'])) echo $_SESSION['sevaOfferedNoPriceCount'] ?> Shashwath Seva(s) need to add Seva Price. Please click and check");
			} else {
				$('.lblStyle1').css({"text-decoration": "none",  "pointer-events": "none"});
				$('.badge43').html(0);
				$('.tooltipShashPrice').html("No Shashwath Seva(s) to add Seva Price");
		}

		if('<?php if(isset($_SESSION['fdExpCount'])) echo $_SESSION['fdExpCount'] ?>' > 0){
				$('.badge44').html('<?php if(isset($_SESSION['fdExpCount'])) echo $_SESSION['fdExpCount'] ?>');
				$('.tooltipFd').html("<?php if(isset($_SESSION['fdExpCount'])) echo $_SESSION['fdExpCount'] ?> All the Details of Matured FD's");
			} else {
				$('.lblStyle1').css({"text-decoration": "none",  "pointer-events": "none"});
				$('.badge44').html(0);
				$('.tooltipFd').html("No Expired FD's");
		}

		if('<?php if(isset($_SESSION['pending_cheques'])) echo $_SESSION['pending_cheques'] ?>' > 0){
				$('.badge45').html('<?php if(isset($_SESSION['pending_cheques'])) echo $_SESSION['pending_cheques'] ?>');
				$('.tooltipChequePending').html("<?php if(isset($_SESSION['pending_cheques'])) echo $_SESSION['pending_cheques'] ?> Cheques Pending");
			} else {
				$('.lblStyle1').css({"text-decoration": "none",  "pointer-events": "none"});
				$('.badge45').html(0);
				$('.tooltipChequePending').html("No Cheque Pending");
		}

////////////////////////// adding the finance part cheque pending by adithya start
        if('<?php if(isset($_SESSION['Deity_Cheque_Remmittance'])) echo $_SESSION['Deity_Cheque_RemmittanceCount'] ?>' > 0){
				$('.badge51').html('<?php if(isset($_SESSION['Deity_Cheque_RemmittanceCount'])) echo $_SESSION['Deity_Cheque_RemmittanceCount'] ?>');
				$('.tooltipFinanceChequePending').html("<?php if(isset($_SESSION['Deity_Cheque_RemmittanceCount'])) echo $_SESSION['Deity_Cheque_RemmittanceCount'] ?> Cheques Pending");
			} else {
				$('.lblStyle1').css({"text-decoration": "none",  "pointer-events": "none"});
				$('.badge51').html(0);
				$('.tooltipFinanceChequePending').html("No Cheque Pending");
		}

		if('<?php if(isset($_SESSION['Event_EOD_Tally'])) echo $_SESSION['Event_Cheque_RemmittanceCount'] ?>' > 0){
				$('.badge50').html('<?php if(isset($_SESSION['Event_Cheque_RemmittanceCount'])) echo $_SESSION['Event_Cheque_RemmittanceCount'] ?>');
				$('.tooltipEventChequePending').html("<?php if(isset($_SESSION['Event_Cheque_RemmittanceCount'])) echo $_SESSION['Event_Cheque_RemmittanceCount'] ?> Cheques Pending");
			} else {
				$('.lblStyle1').css({"text-decoration": "none",  "pointer-events": "none"});
				$('.badge50').html(0);
				$('.tooltipEventChequePending').html("No Cheque Pending");
		}
///////////////////////// adding the finance part cheque pendng by adithya end 

        if('<?php if(isset($_SESSION['fdTrustExpCount'])) echo $_SESSION['fdTrustExpCount'] ?>' > 0){
         		$('.badge46').html('<?php if(isset($_SESSION['fdTrustExpCount'])) echo $_SESSION['fdTrustExpCount'] ?>');
         		$('.tooltiptrustFd').html("<?php if(isset($_SESSION['fdTrustExpCount'])) echo $_SESSION['fdTrustExpCount'] ?> All the Details of Matured FD's");
         	} else {
         		$('.lblStyle1').css({"text-decoration": "none","pointer-events": "none"});
         		$('.badge46').html(0);
         		$('.tooltiptrustFd').html("No Expired FD's");
        }
         
        if('<?php if(isset($_SESSION['Trust_pending_cheques'])) echo $_SESSION['Trust_pending_cheques'] ?>' > 0){
         		$('.badge47').html('<?php if(isset($_SESSION['Trust_pending_cheques'])) echo $_SESSION['Trust_pending_cheques'] ?>');
         		$('.tooltiptrustChequePending').html("<?php if(isset($_SESSION['Trust_pending_cheques'])) echo $_SESSION['Trust_pending_cheques'] ?> Cheques Pending");
         	} else {
         		$('.lblStyle1').css({"text-decoration": "none",  "pointer-events": "none"});
         		$('.badge47').html(0);
         		$('.tooltiptrustChequePending').html("No Cheque Pending");
        }
			// tooltipFinanceTrustChequePending
		if('<?php if(isset($_SESSION['Cheque_Remmittance'])) echo $_SESSION['Cheque_RemmittanceCount'] ?>' > 0){
         		$('.badge49').html('<?php if(isset($_SESSION['Cheque_RemmittanceCount'])) echo $_SESSION['Cheque_RemmittanceCount'] ?>');
         		$('.tooltipFinanceTrustChequePending').html("<?php if(isset($_SESSION['Cheque_RemmittanceCount'])) echo $_SESSION['Cheque_RemmittanceCount'] ?> Cheques Pending");
         	} else {
         		$('.lblStyle1').css({"text-decoration": "none",  "pointer-events": "none"});
         		$('.badge49').html(0);
         		$('.tooltipFinanceTrustChequePending').html("No Cheque Pending");
        }

		// tooltipFinanceTrustEventChequePending
		if('<?php if(isset($_SESSION['E.O.D_Tally_Trust'])) echo $_SESSION['Trust_Event_EOD_Count'] ?>' > 0){
         		$('.badge52').html('<?php if(isset($_SESSION['Trust_Event_EOD_Count'])) echo $_SESSION['Trust_Event_EOD_Count'] ?>');
         		$('.tooltipFinanceTrustEventChequePending').html("<?php if(isset($_SESSION['Trust_Event_EOD_Count'])) echo $_SESSION['Trust_Event_EOD_Count'] ?> Cheques Pending");
         	} else {
         		$('.lblStyle1').css({"text-decoration": "none",  "pointer-events": "none"});
         		$('.badge52').html(0);
         		$('.tooltipFinanceTrustEventChequePending').html("No Cheque Pending");
        }
//USED FOR MENU
if("<?=@$whichTab?>") {
	if("<?=@$whichTab?>" == "sevas")
		$('.deitySevas').addClass("active");
	else if("<?=@$whichTab?>" == "eventSevas")
		$('.eventSevas').addClass("active");
	else if("<?=@$whichTab?>" == "receipt")
		$('.receipt').addClass("active");
	else if("<?=@$whichTab?>" == "report")
		$('.reports').addClass("active");
	else if("<?=@$whichTab?>" == "auction")
		$('.auction').addClass("active");
	else if("<?=@$whichTab?>" == "booking")
		$('.booking').addClass("active");
	else if("<?=@$whichTab?>" == "deityEOD")
		$('.deityEOD').addClass("active");
	else if("<?=@$whichTab?>" == "eventEOD")
		$('.eventEOD').addClass("active");
	else if("<?=@$whichTab?>" == "hallEventEODReport")
		$('.hallEventEODReport').addClass("active");
	else if("<?=@$whichTab?>" == "hallBooking")
		$('.hallBooking').addClass("active");
	else if("<?=@$whichTab?>" == "hallReceipt")
		$('.hallReceipt').addClass("active");
	else if("<?=@$whichTab?>" == "hallReport")
		$('.hallReport').addClass("active");
	else if("<?=@$whichTab?>" == "hallEODReport")
		$('.hallEODReport').addClass("active");
	else if("<?=@$whichTab?>" == "hallEventEODReport")
		$('.hallEventEODReport').addClass("active");
	else if("<?=@$whichTab?>" == "eventToken")
		$('.eventToken').addClass("active");
	else if("<?=@$whichTab?>" == "deityToken")
		$('.deityToken').addClass("active");
	else if("<?=@$whichTab?>" == "postage")
		$('.postage').addClass("active");
	else if("<?=@$whichTab?>" == "eventpostage")
		$('.eventpostage').addClass("active");
	else if("<?=@$whichTab?>" == "eventtrustpostage")
		$('.eventtrustpostage').addClass("active");
	else if("<?=@$whichTab?>" == "trustAuction")
		$('.trustAuction').addClass("active");
	else if("<?=@$whichTab?>" == "shashwath")
		$('.shashwath').addClass("active");
	else if("<?=@$whichTab?>" == "Jeernodhara")
		$('.Jeernodhara').addClass("active");
	else if("<?=@$whichTab?>" == "Finance")
		$('.finance').addClass("active");
}


	//$(".overlay").show();
	//$('#dvLoading').fadeOut(2000);
	
	//ALERT BOX
	function alert(title,msg, btnTxt="Ok",close=false,action="") {	
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
							// e
						// var key = e.which;
						//  if(key == 13)  // the enter key code
						//   {
						//     $('input[class = btn-red]').click();
						//     return false;  
						//   }
					}	
				},
			}
		});
	}
	
	if("<?=@$this->session->userdata('loggedHistory');?>") {
		// setTimeout(function(){ window.location.href="<?=site_url()?>"+"home/logout" }, 900000);
	}

	//update Receipt
	function alert2(title,msg, btnTxt="Ok",close=false,action="") {
		$.confirm({
			title: title,
			content: msg,
			type: 'red',
			typeAnimated: true,
			closeIcon:close,
			buttons: {
				"Update Receipt": {
					text: btnTxt,
					btnClass: 'btn-red',
					action: function(){
						$('#editForm1').submit();
					}
				},
			}
		});
	}
	
	//ALERT DIALOG BOX
	function alertDialog(title,msg, btnTxt="Ok",close=false,action="",status) {
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
						url = "<?php echo site_url(); ?>admin_settings/Admin_setting/update_seva_event_status";
						$.post(url,{id:action, status:status}, function(e){
							if(e == 'Success') 
								location.href = "<?php echo site_url(); ?>admin_settings/Admin_setting/events_setting";
						});	
					}
				},
			}
		});
	}
	
	//ALERT DIALOG BOX
	function alertTrustDialog(title,msg, btnTxt="Ok",close=false,action="",status) {
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
						url = "<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/update_seva_event_status";
						$.post(url,{id:action, status:status}, function(e){
							if(e == 'Success') 
								location.href = "<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/events_setting";
						});	
					}
				},
			}
		});
	}
	
	//ALERT DIALOG BOX FOR FINANCIAL HEAD SETTING
	function alertFinancial(title,msg, btnTxt="Ok",close=false,action="",status) {
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
						url = "<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/update_financial_head_status";
						$.post(url,{id:action, status:status}, function(e){
							if(e.trim() == 'Success') 
								location.href = "<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/hall_setting";
						});	
					}
				},
			}
		});
	}
	
	//ALERT DIALOG BOX FOR HALL SETTING
	function alertBlockDate(title,msg, btnTxt="Ok",close=false,action="",status) {
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
						url = "<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/update_block_date_status";
						$.post(url,{id:action, status:status}, function(e){
							if(e.trim() == 'Success') 
								location.href = "<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/block_date_setting";
						});	
					}
				},
			}
		});
	}
	
	//ALERT DIALOG BOX FOR HALL SETTING
	function alertHall(title,msg, btnTxt="Ok",close=false,action="",status) {
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
						url = "<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/update_hall_status";
						$.post(url,{id:action, status:status}, function(e){
							if(e.trim() == 'Success') 
								location.href = "<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/hall_setting";
						});	
					}
				},
			}
		});
	}
	
	//ALERT DIALOG BOX
	function alertSeva(title,msg, btnTxt="Ok",close=false,action="",status) {
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
						url = "<?php echo site_url(); ?>admin_settings/Admin_setting/update_seva_status";
						$.post(url,{id:action, status:status}, function(e){
							if(e == 'Success') 
			    				window.location.reload();
								location.href = "<?php echo site_url(); ?>admin_settings/Admin_setting/deity_seva_setting";

						});	
					}
				},
			}
		});
	}
	
	function showTrustHeadsDetails(name,msg) {
		$.dialog({
			title: name,
			content:msg
		});
	}
                                                                      
	//ALERT DIALOG BOX
	function alertTEOD(title,msg, btnTxt="Ok",close=false,action="",status) {
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
						let url = "<?=site_url()?>TrustEOD/trustEod_save/";
						let cash = $('#Cash2').val();
						let cheque = $('#Cheque2').val();
						let directCredit = $('#directCredit2').val();
						let card = $('#Card2').val();
						let total = $('#TotalAmount2').val();

						$.post(url, {
							"cash":cash,
							"cheque":cheque,
							"directCredit":directCredit,
							"card":card,
							"totalAmt":total,
							"selectedDate":"<?=@$selectedDate; ?>",
						}, function(data) {
							if(data == "success") {
								document.getElementById("eodForm").submit();
							}else {
								alert("Information","Something went Wrong, Please try again later.");
							}
						});
					}
				},
				cancel: {
					text: "No"
				}
			}
		});
	}
	
	//ALERT DIALOG BOX
	function alertTrustEventEOD(title,msg, btnTxt="Ok",close=false,action="",status) {
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
						let url = "<?=site_url()?>TrustEventEOD/eventEod_save/";
						let cash = $('#Cash2').val();
						let cheque = $('#Cheque2').val();
						let directCredit = $('#directCredit2').val();
						let card = $('#Card2').val();
						let total = $('#TotalAmount2').val();

						$.post(url, {
							"cash":cash,
							"cheque":cheque,
							"directCredit":directCredit,
							"card":card,
							"totalAmt":total,
							"selectedDate":"<?=@$selectedDate; ?>",
						}, function(data) {
							// alert(data);
							if(data == "success") {
								document.getElementById("eodForm").submit();
							} else {
								alert("Information","Something went Wrong, Please try again later.");
							}
						});
					}
				},
				cancel: {
					text: "No"
				}
			}
		});
	}
	
	//ALERT DIALOG BOX
	function alertEventEOD(title,msg, btnTxt="Ok",close=false,action="",status) {
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
						let url = "<?=site_url()?>EventEOD/eventEod_save/";
						let cash = $('#Cash2').val();
						let cheque = $('#Cheque2').val();
						let directCredit = $('#directCredit2').val();
						let card = $('#Card2').val();
						let total = $('#TotalAmount2').val();

						$.post(url, {
							"cash":cash,
							"cheque":cheque,
							"directCredit":directCredit,
							"card":card,
							"totalAmt":total,
							"selectedDate":"<?=@$selectedDate; ?>",
						}, function(data) {
							// alert(data);
							if(data == "success") {
								document.getElementById("eodForm").submit();
							} else {
								alert("Information","Something went Wrong, Please try again later.");
							}
						});
					}
				},
				cancel: {
					text: "No"
				}
			}
		});
	}
	
	//ALERT DIALOG BOX
	function alertEOD(title,msg, btnTxt="Ok",close=false,action="",status) {
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
						let url = "<?=site_url()?>EOD/deityEod_save/";
						let cash = $('#Cash2').val();
						let cheque = $('#Cheque2').val();
						let directCredit = $('#directCredit2').val();
						let card = $('#Card2').val();
						let total = $('#TotalAmount2').val();

						$.post(url, {
							"cash":cash,
							"cheque":cheque,
							"directCredit":directCredit,
							"card":card,
							"totalAmt":total,
							"selectedDate":"<?=@$selectedDate; ?>",
						}, function(data) {
							// alert(data);
							if(data == "success") {
								document.getElementById("eodForm").submit();
							} else {
								alert("Information","Something went Wrong, Please try again later.");
							}
						});
					}
				},
				cancel: {
					text: "No"
				}
			}
		});
	}

	function alertRegenerateEOD(title,msg, btnTxt="Ok",close=false,action="",status) {
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
						let url = "<?=site_url()?>EOD/deityRegenerateEod_save/";

						$.post(url, {							
							"selectedDate":"<?=@$selectedDate; ?>",
						}, function(data) {
							// alert(data);
							if(data == "success") {
								document.getElementById("eodForm").submit();
							} else {
								alert("Information","Something went Wrong, Please try again later.");
							}
						});
					}
				},
				cancel: {
					text: "No"
				}
			}
		});
	}

	//ALERT DIALOG BOX
	function alertTrustAuction(title,msg, btnTxt="Ok",close=false,action="",status) {
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
						url = "<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/update_auction_item_status";
						$.post(url,{id:action, status:status}, function(e){
							if(e == 'Success') 
								location.href = "<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/auction_setting";
						});	
					}
				},
			}
		});
	}

	//ALERT DIALOG BOX
	function alertAuction(title,msg, btnTxt="Ok",close=false,action="",status) {
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
						url = "<?php echo site_url(); ?>admin_settings/Admin_setting/update_auction_item_status";
						$.post(url,{id:action, status:status}, function(e){
						
							if(e == 'Success') 
                            console.log(e)   //need this console because while testing if i remove this console then page was not refreshing so the result was not getting refreshed added by adithya
							location.href = "<?php echo site_url(); ?>admin_settings/Admin_setting/auction_setting";
						});	
					}
				},
			}
		});
	}
	
	//ALERT DIALOG BOX
	function alertSevaOther(title,msg, btnTxt="Ok",close=false,action="",status,deityid) {
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
						url = "<?php echo site_url(); ?>admin_settings/Admin_setting/update_seva_status";
						$.post(url,{id:action, status:status}, function(e){
							if(e == 'Success') 
								location.href = "<?php echo site_url(); ?>admin_settings/Admin_setting/deity_seva_details/"+deityid;
						});	
					}
				},
			}
		});
	}
	
	//ALERT DIALOG BOX
	function alertDialogUser(title,msg, btnTxt="Ok",close=false,action="",groupid,status,groupName) {
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
						url = "<?php echo site_url(); ?>admin_settings/Admin_setting/update_user_status";
						$.post(url,{id:action, status:status, gid:groupid}, function(e){
							if(e == 'Success') 
								location.href = "<?php echo site_url(); ?>admin_settings/Admin_setting/users_setting";
							else if(e == "Failed")
								alert("Information","Please active the group <strong>" + groupName + "</strong> before activating user","OK");
						});	
					}
				},
			}
		});
	}
	
	//ALERT DIALOG BOX
	function alertDialogGroup(title,msg, btnTxt="Ok",close=false,action="",status) {
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
						url = "<?php echo site_url(); ?>admin_settings/Admin_setting/update_group_status";
						$.post(url,{id:action, status:status}, function(e){
							if(e == 'Success') 
								location.href = "<?php echo site_url(); ?>admin_settings/Admin_setting/groups_setting";
						});	
					}
				},
			}
		});
	}
	
	//ALERT DIALOG BOX
	function alertDialogSeva(title,msg, btnTxt="Ok",close=false,action="",status,eventid) {
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
						url = "<?php echo site_url(); ?>admin_settings/Admin_setting/update_seva_event_status";
						$.post(url,{id:action, status:status}, function(e){
							if(e == 'Success') 
								location.href = "<?php echo site_url(); ?>admin_settings/Admin_setting/events_seva_details/"+eventid;
						});
						
					}
				},
			}
		});
	}
	
	//ALERT DIALOG BOX
	function alertTrustDialogSeva(title,msg, btnTxt="Ok",close=false,action="",status,eventid) {
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
						url = "<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/update_seva_event_status";
						$.post(url,{id:action, status:status}, function(e){
							if(e == 'Success') 
								location.href = "<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/events_seva_details/"+eventid;
						});
						
					}
				},
			}
		});
	}
	
	//CONFIRM BOX
	function confirm(title,msg, btnTxt="Yes", yesAction, closeAction="No",close=false) {
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
						location.href = yesAction
					}
				},
				close: function () {
					if(closeAction)
						location.href = closeAction
				}
			}
		});
	}
	
	//CONFIRM BOX
	function confirmResetCounter(title,msg, yesAction, action, closeAction="No",close=false) { 
		$.confirm({
			title: title,
			content: msg,
			type: 'red',
			typeAnimated: true,
			closeIcon:close,
			buttons: {
				tryAgain: {
					text: "Yes",
					btnClass: 'btn-red',
					action: function(){
						$.post(yesAction,{id:action}, function(e){
							if(e == 'Success') 
								location.href = "<?php echo site_url(); ?>admin_settings/Admin_setting/receipt_setting";
						});	
					}
				},
				No: {
					btnClass: 'btn-red',
					action: function() {
						return;
					}
				}
			}
		});
	}
	
	//CONFIRM BOX for finance voucher Counter
	function confirmResetVoucherCounter(title,msg, yesAction, action, closeAction="No",close=false) { 
		$.confirm({
			title: title,
			content: msg,
			type: 'red',
			typeAnimated: true,
			closeIcon:close,
			buttons: {
				tryAgain: {
					text: "Yes",
					btnClass: 'btn-red',
					action: function(){
						$.post(yesAction,{id:action}, function(e){
							if(e == 'Success') 
								location.href = "<?php echo site_url(); ?>finance/voucherCounter";
						});	
					}
				},
				No: {
					btnClass: 'btn-red',
					action: function() {
						return;
					}
				}
			}
		});
	}

	function confirmMultiPrintDeityReceipt(title,msg, yesAction, action, closeAction="No",close=false) { 
		let confirmReturn = $.confirm({
			title: "Print",
			content: '<div class="radio"><label><input id="single" class="eventsFont form-control" type="radio" value="" name="optradio" style="border-color: rgb(0, 0, 0);" checked> Single  </label><label style=" padding-left: 29px;"><input id="combined" class="eventsFont form-control" type="radio" value="" name="optradio"> Combined</label></div>',
			type: 'red',
			typeAnimated: true,
			closeIcon:close,
			buttons: {
				tryAgain: {
					text: "Print",
					btnClass: 'btn-red',
					action: function(){
						if($('#single').prop("checked")) {
							var newWin = window.frames["print_frame"]; 
							newWin.document.write('<html><head><link href="<?php echo  base_url(); ?>css/print.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/quickSand.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/fonts.googleapis.css" rel="stylesheet" type="text/css"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" crossorigin="anonymous"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-theme.min.css" crossorigin="anonymous"><link href="<?php echo  base_url(); ?>css/jquery-ui.theme.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.structure.min.css" rel="stylesheet"</head>' + '<body onload="window.print()" style="min-height:90%;">'+ $('#printScreen').html() +'</body></html>');
							newWin.document.close();
						} else {
							var newWin = window.frames["print_frame"]; 
							newWin.document.write('<html><head><link href="<?php echo  base_url(); ?>css/print.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/quickSand.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/fonts.googleapis.css" rel="stylesheet" type="text/css"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" crossorigin="anonymous"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-theme.min.css" crossorigin="anonymous"><link href="<?php echo  base_url(); ?>css/jquery-ui.theme.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.structure.min.css" rel="stylesheet"</head>' + '<body onload="window.print()" style="min-height:90%;">'+ $('#printScreenCombine').html() +'</body></html>');
							newWin.document.close();
						}
					}
				},
				Cancel: {
					btnClass: 'btn-red',
					action: function() {

					}
				}
			}
		});
	}

	function confirmMultiPrintSevaReceipt(title,msg, yesAction, action, closeAction="No",close=false) { 
		let confirmReturn = $.confirm({
			title: "Print",
			content: '<div class="radio"><label><input id="single" class="eventsFont form-control" type="radio" value="" name="optradio" style="border-color: rgb(0, 0, 0);" checked> Single  </label><label style=" padding-left: 29px;"><input id="combined" class="eventsFont form-control" type="radio" value="" name="optradio"> Combined</label></div>',
			type: 'red',
			typeAnimated: true,
			closeIcon:close,
			buttons: {
				tryAgain: {
					text: "Print",
					btnClass: 'btn-red',
					action: function(){
						if($('#single').prop("checked")) {
							var newWin = window.frames["print_frame"]; 
							newWin.document.write('<html><head><link href="<?php echo  base_url(); ?>css/print.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/quickSand.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/fonts.googleapis.css" rel="stylesheet" type="text/css"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" crossorigin="anonymous"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-theme.min.css" crossorigin="anonymous"><link href="<?php echo  base_url(); ?>css/jquery-ui.theme.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.structure.min.css" rel="stylesheet"</head>' + '<body onload="window.print()" style="min-height:90%;">'+ $('#printScreen').html() +'</body></html>');
							newWin.document.close();
						} else {
							var newWin = window.frames["print_frame"]; 
							newWin.document.write('<html><head><link href="<?php echo  base_url(); ?>css/print.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/quickSand.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/fonts.googleapis.css" rel="stylesheet" type="text/css"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" crossorigin="anonymous"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-theme.min.css" crossorigin="anonymous"><link href="<?php echo  base_url(); ?>css/jquery-ui.theme.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.structure.min.css" rel="stylesheet"</head>' + '<body onload="window.print()" style="min-height:90%;">'+ $('#printScreenCombine').html() +'</body></html>');
							newWin.document.close();
						}
					}
				},
				Cancel: {
					btnClass: 'btn-red',
					action: function() {

					}
				}
			}
		});
	}

	function confirmMultiPrintDonationReceipt(title,msg, yesAction, action, closeAction="No",close=false) { 
		let confirmReturn = $.confirm({
			title: "Print",
			content: '<div class="radio"><label><input id="single" class="eventsFont form-control" type="radio" value="" name="optradio" style="border-color: rgb(0, 0, 0);" checked> Normal  </label><label style=" padding-left: 29px;"><input id="combined" class="eventsFont form-control" type="radio" value="" name="optradio"> Special</label></div>',
			type: 'red',
			typeAnimated: true,
			closeIcon:close,
			buttons: {
				tryAgain: {
					text: "Print",
					btnClass: 'btn-red',
					action: function(){
						if($('#single').prop("checked")) {
							var newWin = window.frames["print_frame"]; 
							newWin.document.write('<html><head><link href="<?php echo  base_url(); ?>css/print.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/quickSand.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/fonts.googleapis.css" rel="stylesheet" type="text/css"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" crossorigin="anonymous"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-theme.min.css" crossorigin="anonymous"><link href="<?php echo  base_url(); ?>css/jquery-ui.theme.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.structure.min.css" rel="stylesheet"</head>' + '<body onload="window.print()" style="min-height:90%;">'+ $('#printScreen').html() +'</body></html>');
							newWin.document.close();
						} else {
							let A5printContent = $('#A5print').html();

							var newWin = window.frames["print_frame"]; 
							newWin.document.write(`<!DOCTYPE html>
								<html lang="en">
								<head>
								<meta charset="UTF-8">
								<meta name="viewport" content="width=device-width, initial-scale=1.0">
								<meta http-equiv="X-UA-Compatible" content="ie=edge">
								<link rel="stylesheet" href="<?=site_url(); ?>css/printA5.css">
								<style>
								@page { size: A5 }
								/*.testBack {
									content: '';
									display: block;
									position: absolute;
									width: 100%;
									height: 100%;
									background:  url('http://www.visitnorwich.co.uk/assets/Uploads/Events-images/Theatre-generic.jpg');
									opacity: 0.2;
									z-index: -1;
								}*/
								</style>
								<title>print Preview</title>
								</head><body class="A5" onload="window.print()">${A5printContent}</body>
								</html>`);
							newWin.document.close();
						}
					}
				},
				Cancel: {
					btnClass: 'btn-red',
					action: function() {

					}
				}
			}
		});
	}

	function confirmMultiPrintKanikeReceipt(title,msg, yesAction, action, closeAction="No",close=false) { 
		let confirmReturn = $.confirm({
			title: "Print",
			content: '<div class="radio"><label><input id="single" class="eventsFont form-control" type="radio" value="" name="optradio" style="border-color: rgb(0, 0, 0);" checked> Normal  </label><label style=" padding-left: 29px;"><input id="combined" class="eventsFont form-control" type="radio" value="" name="optradio"> Special</label></div>',
			type: 'red',
			typeAnimated: true,
			closeIcon:close,
			buttons: {
				tryAgain: {
					text: "Print",
					btnClass: 'btn-red',
					action: function(){
						if($('#single').prop("checked")) {
							var newWin = window.frames["print_frame"]; 
							newWin.document.write('<html><head><link href="<?php echo  base_url(); ?>css/print.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/quickSand.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/fonts.googleapis.css" rel="stylesheet" type="text/css"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" crossorigin="anonymous"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-theme.min.css" crossorigin="anonymous"><link href="<?php echo  base_url(); ?>css/jquery-ui.theme.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.structure.min.css" rel="stylesheet"</head>' + '<body onload="window.print()" style="min-height:90%;">'+ $('#printScreen').html() +'</body></html>');
							newWin.document.close();
						} else {
							let A5printContent = $('#A5print').html();

							var newWin = window.frames["print_frame"]; 
							newWin.document.write(`<!DOCTYPE html>
								<html lang="en">
								<head>
								<meta charset="UTF-8">
								<meta name="viewport" content="width=device-width, initial-scale=1.0">
								<meta http-equiv="X-UA-Compatible" content="ie=edge">
								<link rel="stylesheet" href="<?=site_url(); ?>css/printA5.css">
								<style>
								@page { size: A5 }
								/*.testBack {
									content: '';
									display: block;
									position: absolute;
									width: 100%;
									height: 100%;
									background:  url('http://www.visitnorwich.co.uk/assets/Uploads/Events-images/Theatre-generic.jpg');
									opacity: 0.2;
									z-index: -1;
								}*/
								</style>
								<title>print Preview</title>
								</head><body class="A5" onload="window.print()">${A5printContent}</body>
								</html>`);
							newWin.document.close();
						}
					}
				},
				Cancel: {
					btnClass: 'btn-red',
					action: function() {

					}
				}
			}
		});
	}

	//CONFIRM BOX
	function confirmTrustResetCounter(title,msg, yesAction, action, closeAction="No",close=false) { 
		$.confirm({
			title: title,
			content: msg,
			type: 'red',
			typeAnimated: true,
			closeIcon:close,
			buttons: {
				tryAgain: {
					text: "Yes",
					btnClass: 'btn-red',
					action: function(){
						$.post(yesAction,{id:action}, function(e){
							
							if(e == 'Success') 
								location.href = "<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/receipt_setting";
						});	
					}
				},
				No: {
					btnClass: 'btn-red',
					action: function() {
						return;
					}
				}
			}
		});
	}
	//CONFIRM BOX
	function deactivateBookingSecond(title,msg, url, HB_ID, closeAction="No",close=false) { 
		$.confirm({
			title: title,
			content: msg,
			type: 'red',
			typeAnimated: true,
			closeIcon:close,
			buttons: {
				tryAgain: {
					text: "Yes",
					btnClass: 'btn-red',
					action: function(){
						$.post(url, {
							HB_ID
						}, function(data) {
							console.log(data)
							if(!data) {
								location.reload();
							}else {
								alert("information", "Something went Wrong")
							}
						})
					}
				},
				No: {
					btnClass: 'btn-red',
					action: function() {
						return;
					}
				}
			}
		});
	}
	
	//CONFIRM BOX
	function deactivateBooking(title,msg, url, HBL_ID, closeAction="No",close=false) { 
		$.confirm({
			title: title,
			type: 'red',
			typeAnimated: true,
			closeIcon:close,
			content: msg + 
			'<form action="" class="formName">' +
			'<div class="form-group"><br>' +
			'<label>Cancellation Reason</label>' +
			'<textarea type="text" placeholder="Enter here" class="reason form-control" required />' +
			'</div>' +
			'</form>',
			buttons: {
				tryAgain: {
					text: "Yes",
					btnClass: 'btn-red',
					action: function(){
						var cancelReason = this.$content.find('.reason').val();
						if(cancelReason == "") {
							this.$content.find('.reason').css('border-color', "#ff0000");
							return false;
						}
						$.post(url, {
							HBL_ID, cancelReason
						}, function(data) {
							console.log(data)
							if(!data) {
								location.reload();
							} else {
								alert("information", "Something went Wrong")
							}
						})
					}
				},
				No: {
					btnClass: 'btn-red',
					action: function() {
						return;
					}
				}
			}
		});
	}
	
	//CHECK FOR LETTERS
	function CheckForLetterOnly(event, key) {   
		if (window.event) {
			var charCode = window.event.keyCode;
		} else if (event) {
			var charCode = event.which;
		} else { 
			return true; 
		}
		
		if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123))
			return true;
		else
			return false;
	} 
	
	//CHECK FOR NUMBERS
	function CheckForNumbersOnly(event, key) {
		//alert(key.value);
		if (window.event) {
			var charCode = window.event.keyCode;
		} else if (e) {
			var charCode = e.which;
		} else { 
			return true; 
		} 
		
		if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			return false;
		}
		return true;
	}
	
	$('.eventSevas').mouseenter(function() {
		$(".badge12").effect( "bounce", {times:3}, "slow");
		$(".badge13").effect( "bounce", {times:3}, "slow");
	});
	
	$('.deitySevas').mouseenter(function() {
		$(".badge14").effect( "bounce", {times:3}, "slow");
		$(".badge15").effect( "bounce", {times:3}, "slow");
	});
	
	$('.shashwath').mouseenter(function() {
		$(".badge22").effect( "bounce", {times:3}, "slow");
		$(".badge22").effect( "bounce", {times:3}, "slow");
	});

	// $('.btn-red').mouseenter(function() {
	// 	document.getElementByClass("btn-red").click();
	// });
	
	//validate
	function validate(...items) {
		let obj = {};
		let count = 0;
		
		items.forEach((item)=> {
			if(item.includes(",")) {
				var res = item.slice(0,item.indexOf(","));
				obj[res] = $('#' +  res).val().trim();
				$('#' + res).css('border-color', "#800000");
			} else if(($('#' + item).val()).trim().length == 0) {
				$('#' + item).css('border-color', "#FF0000");
				++count;
			} else {
				$('#' + item).css('border-color', "#800000");
				obj[item] = $('#' +  item).val().trim();
			}
		});
		
		// for(var i = 0; i < items.length; ++i) {
			// let item = items[i];
			// if(item.includes(",")) {
				// var res = item.slice(0,item.indexOf(","));
				// obj[item] = $('#' +  res).val().trim();
			// }else if(($('#' + items[i]).val()).trim().length == 0) {
				// $('#' + items[i]).css('border-color', "#FF0000");
				// ++count;
			// } else {
				// $('#' + items[i]).css('border-color', "#800000");
				// obj[items[i]] = $('#' +  items[i]).val().trim();
			// }
		// } 
		
		if(count == 0)
			return obj;
		else
			return "";
	}
	
	$('#chequeNo').on('keyup', function(e) {
		this.value.replace("\s","")
		if(this.value.length > 6)
			$('#chequeNo').val((this.value.substr(0,6)))
	});
	
	//ALERT DIALOG BOX
	function deActivateCheque(title,msg, btnTxt="Ok",close=false,action="",status) {
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
						// alert(action)
						// alert(status)
						$.post("<?=site_url(); ?>EOD_TALLY/deactivateCheque",{
							"DUC_ID":status,
							"DUC_CHEQUE_ID":action,
							
						},function(e) {
							location.reload();
						});
					}
				},
				cancel: {
					text: "No"
				}
			}
		});
	}
	
	//ALERT DIALOG BOX
	function deActivateChequeTrustEvent(title,msg, btnTxt="Ok",close=false,action="",status) {
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
						// alert(action)
						// alert(status)
						$.post("<?=site_url(); ?>TrustEventEOD_TALLY/deactivateCheque",{
							"DUC_ID":status,
							"DUC_CHEQUE_ID":action,
							
						},function(e) {
							location.reload();
						});
					}
				},
				cancel: {
					text: "No"
				}
			}
		});
	}
	
	//ALERT DIALOG BOX
	function deActivateChequeTrust(title,msg, btnTxt="Ok",close=false,action="",status) {
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
						// alert(action)
						// alert(status)
						$.post("<?=site_url(); ?>TrustEOD_Tally/deactivateCheque",{
							"TUC_ID":status,
							"TUC_CHEQUE_ID":action,
							
						},function(e) {
							location.reload();
						});
					}
				},
				cancel: {
					text: "No"
				}
			}
		});
	}
	
	//CONFIRM FOR GENERATING SEVA BOX
	function alertGenerateSevaDialog(title,msg,close=false) { 
		$.confirm({
			title: title,
			content: msg,
			type: 'red',
			typeAnimated: true,
			closeIcon:close,
			buttons: {
				tryAgain: {
					text: "Yes",
					btnClass: 'btn-red',
					action: function(){
						$('#generateSevaId').attr('action', "<?php echo site_url();?>Shashwath/generateSeva").submit();
					}
				},
				No: {
					btnClass: 'btn-red',
					action: function() {
						return;
					}
				}
			}
		});
	} 

</script>

</body>  
</html>
