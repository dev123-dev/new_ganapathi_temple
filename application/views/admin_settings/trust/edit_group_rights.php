<form action="<?php echo site_url(); ?>admin_settings/Admin_Trust_setting/update_group" enctype="multipart/form-data" method="post" accept-charset="utf-8" onsubmit="return field_validation()">
	<section id="section-register" class="bg_register">
		<div class="container-fluid sub_reg ">	
			<!-- START Content -->
			<div class="container-fluid container">
				<!-- START Row -->
				<div class="row-fluid">
					<div class="span12 widget lime">               
						<h3 class="registr"><span class="icon icone-crop"></span>Edit Group Rights</h3>                 
					</div>           
				</div>
				<br/>
				<section class="body">
					<div class="body-inner">    
						<div class="row form-group">
							<!--HIDDEN FIELD -->
							<input name="groupid" id="groupid" type="hidden" value="<?php echo $edit_group[0]->GROUP_ID; ?>">
							<div class="control-group col-md-6 col-lg-6 col-sm-6 col-xs-12">
								<label class="control-label color_black">Group Name <span style="color:#800000;">*</span></label>
								<div class="controls">
									<input name="group_name" id="group_name" type="text" class="span6  form-control register_form" value="<?php echo $edit_group[0]->GROUP_NAME; ?>">
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
							
							<div class="control-group col-md-6 col-lg-6 col-sm-6 col-xs-12">
								<label class="control-label color_black">Group Active <span style="color:#800000;">*</span></label>
								<div class="controls">
									<select class="form-control register_form" id="group_active" name="group_active">		
										<?php if($edit_group[0]->GROUP_ACTIVE == 0) { ?>
											<option value="1">Active</option>
											<option selected value="0">Deactive</option> 
										<?php } else { ?>
											<option selected value="1">Active</option>
											<option value="0">Deactive</option> 
										<?php } ?>										
									</select>
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
						</div>
						
						<div class="row form-group">
							<div class="control-group col-md-6 col-lg-6 col-sm-6 col-xs-12">
								<label class="control-label color_black">Group Description</label>
								<div class="controls">
									<textarea rows="5" name="group_desc" id="group_desc" style="resize: none;" class="span6 form-control register_form" ><?php echo $edit_group[0]->GROUP_DESC; ?></textarea>
									<span class="form-input-info positioning" style="color:#FF0000"></span>
								</div>
							</div>
							
							<div class="control-inline col-md-6 col-lg-6 col-sm-6 col-xs-12" style="font-size:15px;margin-top:1.5em;">
								<?php 
									$add = "";$edit = "";$actDcr = "";$auth = "";$addId = "";$editId = "";$actDctId = "";$authId = "";
									$rights = explode(", ", $edit_group[0]->R_NAME); 
									$grId = explode(", ", $edit_group[0]->GTR_ID); 
									for($i = 0; $i < count($rights); $i++) {
										if(@$rights[$i] == "Add") {
											$add = @$rights[$i]; 
											$addId = @$grId[$i]; 
										} else if(@$rights[$i] == "Edit") {
											$edit = @$rights[$i]; 
											$editId = @$grId[$i];
										} else if(@$rights[$i] == "Active/Deactive") {
											$actDct = @$rights[$i]; 
											$actDctId = @$grId[$i]; 
										} else if(@$rights[$i] == "Authorise") {
											$auth = @$rights[$i]; 
											$authId = @$grId[$i]; 
										}else if(@$rights[$i] == "Notification") {
											$notif = @$rights[$i]; 
											$notifId = @$grId[$i];
										}
									}
								?>
								
								<?php if(@$add == "Add") { ?>
									<label class="checkbox-inline" style="font-weight:bold;">
										<input type="checkbox" id="add" name="add" checked>Add
									</label>
								<?php } else { ?>
									<label class="checkbox-inline" style="font-weight:bold;">
										<input type="checkbox" id="add" name="add">Add
									</label>
								<?php } ?>
								<!--HIDDEN FIELDS-->
								<input type="hidden" id="addId" name="addId" value="<?php echo $addId; ?>">
								
								<?php if(@$edit == "Edit") { ?>
									<label class="checkbox-inline" style="font-weight:bold;">
										<input type="checkbox" id="edit" name="edit" checked>Edit
									</label>
								<?php } else { ?>
									<label class="checkbox-inline" style="font-weight:bold;">
										<input type="checkbox" id="edit" name="edit">Edit
									</label>
								<?php } ?>
								<!--HIDDEN FIELDS-->
								<input type="hidden" id="editId" name="editId" value="<?php echo $editId; ?>">
								
								<?php if(@$actDct == "Active/Deactive") { ?>
									<label class="checkbox-inline" style="font-weight:bold;">
										<input type="checkbox" id="actDct" name="actDct" checked>Active/Deactive
									</label>
								<?php } else { ?>
									<label class="checkbox-inline" style="font-weight:bold;">
										<input type="checkbox" id="actDct" name="actDct">Active/Deactive
									</label>
								<?php } ?>
								<!--HIDDEN FIELDS-->
								<input type="hidden" id="actDctId" name="actDctId" value="<?php echo $actDctId; ?>">
								
								<?php if(@$auth == "Authorise") { ?>
									<label class="checkbox-inline" style="font-weight:bold;">
										<input type="checkbox" id="authorise" name="authorise" checked>Authorise
									</label>
								<?php } else { ?>
									<label class="checkbox-inline" style="font-weight:bold;">
										<input type="checkbox" id="authorise" name="authorise">Authorise
									</label>
								<?php } ?>
								<!--HIDDEN FIELDS-->
								<input type="hidden" id="authoriseId" name="authoriseId" value="<?php echo $authId; ?>">
								<!-- added by adithya for notification -->
								<?php if(@$notif == "Notification") { ?>
									<label class="checkbox-inline" style="font-weight:bold;">
										<input type="checkbox" id="notification" name="notification" checked />Notification
									</label>
								<?php } else { ?>
									<label class="checkbox-inline" style="font-weight:bold;">
										<input type="checkbox" id="notification" name="notification" />Notification
									</label>
								<?php } ?>
								<!-- end -->
							</div>
						</div>
						
						<div class="row form-group">
							<div class="control-group col-md-12 col-lg-12 col-sm-12 col-xs-12">
								<?php 
									$groupSettings = "";$groupSettingsId = "";$userSettings = "";$userSettingsId = "";$hallSettings = "";$hallSettingsId = "";
									$blockDateSettings = "";$blockDateSettingsId = "";$bankSettings = "";$bankSettingsId = "";
									$checkRemmittance = "";$checkRemmittanceId = "";
									$bookHall = "";$bookHallId = "";$allHallBooking = "";$allHallBookingId = "";$auctionSettings = "";$auctionSettingsId = "";
									$newTrustReceipt = "";$newTrustReceiptId = "";$allTrustReceipt = "";$allTrustReceiptId = "";
									$trustReceiptReport = "";$trustReceiptReportId = "";$trustMISReport = "";$trustMISReportId = "";
									$eodReport = "";$eodReportId = "";$eodTally = "";$eodTallyId = "";
									$hallBookingsReport = "";$hallBookingsReportId = "";
									$eventSevaSettings = "";$eventSevaSettingsId = "";$chequeRemmittance = "";$chequeRemmittanceId = "";
									$receiptSettings = "";$receiptSettingsId = "";$inkindItems = "";$inkindItemsId = "";$eventSevas = "";$eventSevasId = "";
									$allEventReceipt = "";$allEventReceiptId = "";$eventSeva = "";$eventSevaId = "";
									$eventDonationKanike = "";$eventDonationKanikeId = "";$deityEventHundi = "";$deityEventHundiId = "";
									$deityEventInkind = "";$deityEventInkindId = "";$currentEventReceiptReport = "";$currentEventReceiptReportId = "";$currentEventSevaReport = "";$currentEventSevaReportId = "";$currentEventMISReport = "";$currentEventMISReportId = "";$userEventCollectionReport = "";$userEventCollectionReportId = "";$eventEodReport = "";$eventEodReportId = "";$eventEodTally = "";$eventEodTallyId = "";
									$TrustDayBook = "";$TrustDayBookId = "";$TrustInkindReport = ""; $TrustInkindReportId = "";$trustEventToken = "";$trustEventTokenId = "";
									$functionType = "";$functionTypeId = "";  
									$eventPostage = "";$eventPostageId = "";
									$eventDispatchCollection = "";$eventDispatchCollectionId = "";
									$allEventPostageCollection = "";$allEventPostageCollectionId = "";
									$trustImportSettings = "";$trustImportSettingsId = "";
									$addAuctionItem = "";$addAuctionItemId = "";$bidAuctionItem = "";$bidAuctionItemId ="";$auctionReceipt = "";$auctionReceiptId = "";$sareeOutwardReport = "";$sareeOutwardReportId = "";$auctionItemReport = "";$auctionItemReportId = "";
									$eventSevaSummary = "";
									$eventSevaSummaryId = "";
									$trustEvtPostageGroup = ""; $trustEvtPostageGroupId = "";

                        //  adding the finance part by Adithya on 19-12-2023 start 
                        //finance
									$financeReceipts = "";$financeReceiptsId = "";
									$financePayments = "";$financePaymentsId = "";
									$financeJournal = "";$financeJournalId = "";
									$financeContra = "";$financeContraId = "";
									$balanceSheet = "";$balanceSheetId = "";
									$incomeAndExpenditure = "";$incomeAndExpenditureId = "";
									$receiptsAndPayments = "";$receiptsAndPaymentsId = "";
									$trialBalance = "";$trialBalanceId = "";
									$financeAddGroups= "";$financeAddGroupsId = "";
									$financeAddLedgers = "";$financeAddLedgersId = "";
									$financeAddOpeningBalance = "";$financeAddOpeningBalanceId= "";
									$allLedgersandGroups = "";$allLedgersandGroupsId= "";
									$financeDayBook = "";$financeDayBookId= "";
									$financePrerequisites  ="";$financePrerequisitesId = "";
									$voucherCounter = ""; $voucherCounterId = ""; 
									$bankChequeConfiguration = ""; $bankChequeConfigurationId = "";

									
                        // adding the finance part by adithya on 19-12-2023 end

									$pages = explode(" , ", $edit_group[0]->TP_NAME); 
									$gmId = explode(", ", $edit_group[0]->GTM_ID); 
									for($j = 0; $j < count($pages); $j++) {
										// echo "@$pages[$j]";
										if(@$pages[$j] == "Group Settings") {
											$groupSettings = @$pages[$j]; 
											$groupSettingsId = @$gmId[$j]; 
										} else if(@$pages[$j] == "Users Settings") {
											$userSettings = @$pages[$j]; 
											$userSettingsId = @$gmId[$j]; 
										} else if(@$pages[$j] == "Hall Settings") {
											$hallSettings = @$pages[$j]; 
											$hallSettingsId = @$gmId[$j]; 
										} else if(@$pages[$j] == "Book Hall") {
											$bookHall = @$pages[$j]; 
											$bookHallId = @$gmId[$j]; 
										} else if(@$pages[$j] == "All Hall Bookings") {
											$allHallBooking = @$pages[$j]; 
											$allHallBookingId = @$gmId[$j]; 
										} else if(@$pages[$j] == "New Trust Receipt") {
											$newTrustReceipt = @$pages[$j]; 
											$newTrustReceiptId = @$gmId[$j]; 
										} else if(@$pages[$j] == "All Trust Receipt") {
											$allTrustReceipt = @$pages[$j]; 
											$allTrustReceiptId = @$gmId[$j]; 
										} else if(@$pages[$j] == "Block Date Settings") {
											$blockDateSettings = @$pages[$j]; 
											$blockDateSettingsId = @$gmId[$j];
										} else if(@$pages[$j] == "Trust Receipt Report") {
											$trustReceiptReport = @$pages[$j]; 
											$trustReceiptReportId = @$gmId[$j];
										} else if(@$pages[$j] == "Trust MIS Report") {
											$trustMISReport = @$pages[$j]; 
											$trustMISReportId = @$gmId[$j];
										} else if(@$pages[$j] == "E.O.D. Report") {
											$eodReport = @$pages[$j]; 
											$eodReportId = @$gmId[$j];
										} else if(@$pages[$j] == "E.O.D. Tally") {
											$eodTally = @$pages[$j]; 
											$eodTallyId = @$gmId[$j];
										} else if(@$pages[$j] == "Bank Settings") {
											$bankSettings = @$pages[$j]; 
											$bankSettingsId = @$gmId[$j];
										} else if(@$pages[$j] == "Hall Bookings Report") {
											$hallBookingsReport = @$pages[$j]; 
											$hallBookingsReportId = @$gmId[$j];
										} else if(@$pages[$j] == "Check Remmittance") {
											$checkRemmittance = @$pages[$j]; 
											$checkRemmittanceId = @$gmId[$j];
										} else if(@$pages[$j] == "Event Seva Settings") {
											$eventSevaSettings = @$pages[$j]; 
											$eventSevaSettingsId = @$gmId[$j]; 
										} else if(@$pages[$j] == "Event Cheque Remmittance") {
											$chequeRemmittance = @$pages[$j]; 
											$chequeRemmittanceId = @$gmId[$j]; 
										} else if(@$pages[$j] == "Receipt Settings") {
											$receiptSettings = @$pages[$j]; 
											$receiptSettingsId = @$gmId[$j]; 
										} else if(@$pages[$j] == "Inkind Items") {
											$inkindItems = @$pages[$j]; 
											$inkindItemsId = @$gmId[$j]; 
										} else if(@$pages[$j] == "Event Sevas") {
											$eventSevas = @$pages[$j]; 
											$eventSevasId = @$gmId[$j];
										} else if(@$pages[$j] == "All Event Receipt") {
											$allEventReceipt = @$pages[$j]; 
											$allEventReceiptId = @$gmId[$j]; 
										} else if(@$pages[$j] == "Event Seva") {
											$eventSeva = @$pages[$j]; 
											$eventSevaId = @$gmId[$j];
										} else if(@$pages[$j] == "Event Donation/Kanike") {
											$eventDonationKanike = @$pages[$j]; 
											$eventDonationKanikeId = @$gmId[$j];
										} else if(@$pages[$j] == "Event Hundi") {
											$deityEventHundi = @$pages[$j]; 
											$deityEventHundiId = @$gmId[$j];
										} else if(@$pages[$j] == "Event Inkind") {
											$deityEventInkind = @$pages[$j]; 
											$deityEventInkindId = @$gmId[$j];
										} else if(@$pages[$j] == "Current Event Receipt Report") {
											$currentEventReceiptReport = @$pages[$j]; 
											$currentEventReceiptReportId = @$gmId[$j];
										} else if(@$pages[$j] == "Current Event Seva Report") {
											$currentEventSevaReport = @$pages[$j]; 
											$currentEventSevaReportId = @$gmId[$j];
										} else if(@$pages[$j] == "Current Event MIS Report") {
											$currentEventMISReport = @$pages[$j]; 
											$currentEventMISReportId = @$gmId[$j];
										} else if(@$pages[$j] == "User Event Collection Report") {
											$userEventCollectionReport = @$pages[$j]; 
											$userEventCollectionReportId = @$gmId[$j];
										} else if(@$pages[$j] == "Event E.O.D. Report") {
											$eventEodReport = @$pages[$j]; 
											$eventEodReportId = @$gmId[$j];
										} else if(@$pages[$j] == "Event E.O.D. Tally") {
											$eventEodTally = @$pages[$j]; 
											$eventEodTallyId = @$gmId[$j];
										} else if(@$pages[$j] == "Trust Day Book") {
											$TrustDayBook = @$pages[$j]; 
											$TrustDayBookId = @$gmId[$j];
										} else if(@$pages[$j] == "Trust Inkind Report") {
											$TrustInkindReport = @$pages[$j]; 
											$TrustInkindReportId = @$gmId[$j];
										} else if(@$pages[$j] == "Trust Event Token") {
											$trustEventToken = @$pages[$j];
											$trustEventTokenId = @$gmId[$j];
										} else if(@$pages[$j] == "Function Types") {
											$functionType = @$pages[$j];
											$functionTypeId = @$gmId[$j];
										} else if(@$pages[$j] == "Event Postage") {
											$eventPostage = @$pages[$j];
											$eventPostageId = @$gmId[$j];
										} else if(@$pages[$j] == "Event Dispatch Collection") {
											$eventDispatchCollection = @$pages[$j];
											$eventDispatchCollectionId = @$gmId[$j];
										} else if(@$pages[$j] == "All Event Postage Collection") {	
											$allEventPostageCollection = @$pages[$j];
											$allEventPostageCollectionId = @$gmId[$j];
										} else if(@$pages[$j] == "Trust Import Settings") {
											$trustImportSettings = @$pages[$j];
											$trustImportSettingsId = @$gmId[$j];
										} else if(@$pages[$j] == "Add Auction Item") {
											$addAuctionItem = @$pages[$j]; 
											$addAuctionItemId = @$gmId[$j];
										} else if(@$pages[$j] == "Bid Auction Item") {
											$bidAuctionItem = @$pages[$j]; 
											$bidAuctionItemId = @$gmId[$j];
										} else if(@$pages[$j] == "Auction Receipt") {
											$auctionReceipt = @$pages[$j]; 
											$auctionReceiptId = @$gmId[$j];
										} else if(@$pages[$j] == "Saree Outward Report") {
											$sareeOutwardReport = @$pages[$j]; 
											$sareeOutwardReportId = @$gmId[$j];
										} else if(@$pages[$j] == "Auction Item Report") {
											$auctionItemReport = @$pages[$j]; 
											$auctionItemReportId = @$gmId[$j];
										} else if(@$pages[$j] == "Auction Settings") {
											$auctionSettings = @$pages[$j]; 
											$auctionSettingsId = @$gmId[$j]; 
										} else if(@$pages[$j] == "Event Seva Summary") {
											$eventSevaSummary = @$pages[$j]; 
											$eventSevaSummaryId = @$gmId[$j]; 
										} else if(@$pages[$j] == "Trust Event Postage Group") {	
											$trustEvtPostageGroup = @$pages[$j];
											$trustEvtPostageGroupId = @$gmId[$j];
										}
										// adding the code for finance part by Adithya on 19-12-2023 start
											//Voucher Counter Suraksha
										else if(@$pages[$j] == "Finance Prerequisites") {
											$financePrerequisites = @$pages[$j]; 
											$financePrerequisitesId = @$gmId[$j]; 
										}//Voucher Counter Suraksha
										 else if(@$pages[$j] == "Voucher Counter") {
											$voucherCounter = @$pages[$j]; 
											$voucherCounterId = @$gmId[$j]; 
										}//Cheque Configuration Suraksha
										 else if(@$pages[$j] == "Cheque Configuration") {
											$bankChequeConfiguration = @$pages[$j]; 
											$bankChequeConfigurationId = @$gmId[$j]; 
										}

										//finance
										else if(@$pages[$j] == "Finance Receipts") {	
											
											$financeReceipts = @$pages[$j];
											$financeReceiptsId = @$gmId[$j];
										}else if(@$pages[$j] == "Finance Payments") {	
											$financePayments = @$pages[$j];
											$financePaymentsId = @$gmId[$j];
										}else if(@$pages[$j] == "Finance Journal") {	
											$financeJournal = @$pages[$j];
											$financeJournalId = @$gmId[$j];
										}else if(@$pages[$j] == "Finance Contra") {	
											$financeContra = @$pages[$j];
											$financeContraId = @$gmId[$j];
										}else if(@$pages[$j] == "Balance Sheet") {	
											$balanceSheet = @$pages[$j];
											$balanceSheetId = @$gmId[$j];
										}else if(@$pages[$j] == "Income and Expenditure") {	
											$incomeAndExpenditure = @$pages[$j];
											$incomeAndExpenditureId = @$gmId[$j];
										}else if(@$pages[$j] == "Receipts and Payments") {	
											$receiptsAndPayments = @$pages[$j];
											$receiptsAndPaymentsId = @$gmId[$j];
										}else if(@$pages[$j] == "Trial Balance") {	
											$trialBalance = @$pages[$j];
											$trialBalanceId = @$gmId[$j];
										}else if(@$pages[$j] == "Finance Add Groups") {	
											$financeAddGroups = @$pages[$j];
											$financeAddGroupsId = @$gmId[$j];
										}else if(@$pages[$j] == "Finance Add Ledgers") {	
											$financeAddLedgers = @$pages[$j];
											$financeAddLedgersId = @$gmId[$j];
										}else if(@$pages[$j] == "Finance Add Opening Balance") {	
											$financeAddOpeningBalance = @$pages[$j];
											$financeAddOpeningBalanceId = @$gmId[$j];
										}else if(@$pages[$j] == "All Ledgers and Groups") {	
											$allLedgersandGroups = @$pages[$j];
											$allLedgersandGroupsId = @$gmId[$j];
										}else if(@$pages[$j] == "Finance Day Book") {	
											$financeDayBook = @$pages[$j];
											$financeDayBookId = @$gmId[$j];
										}
										// finance part end (Adithya)
									}
								?>
								
				<ul class="nav nav-tabs">
		                <!-- ///////////////////// new SETTING adithya ////////////////////////  -->
						<?php if((isset($_SESSION['Auction_Settings'])) ||
							 (isset($_SESSION['Trust_Import_Settings'])) || 
							 (isset($_SESSION['Check_Remmittance'])) || 
							 (isset($_SESSION['Users_Settings'])) || 
							 (isset($_SESSION['Group_Settings'])) || 
							 (isset($_SESSION['Hall_Settings'])) || 
							 (isset($_SESSION['Block_Date_Settings'])) ||
							 (isset($_SESSION['Trust_Voucher_Counter']))||
							 (isset($_SESSION['Trust_Bank_Cheque_Configuration']))||
							 (isset($_SESSION['Bank_Settings'])) || 
							 (isset($_SESSION['Event_Seva_Settings'])) ||
							 (isset($_SESSION['Receipt_Settings']))) { ?>
                                       <li class="active"><a data-toggle="tab" href="#SET">SETTINGS</a></li>									
						<?php }?>	
						<!-- /////////////////////////////new code SETTING end////////////////////////// -->
						
						<!-- ////////////////////////////new code EVENT SEVAS start////////////////// -->
						<?php if(isset($_SESSION['Event_Seva']) && $_SESSION['trustLogin'] == "1") { ?>
									<li><a data-toggle="tab" href="#ES">EVENT SEVAS</a></li>
						<?php }?>
						<!-- ///////////////////////////new code EVENT SEVAS end///////////////////// -->
                       
						<!-- //////////////////////////new code EVENT TOKEN start //////////////// -->
						<?php if(isset($_SESSION['Trust_Event_Token'])) { ?>
									<li><a data-toggle="tab" href="#ET">EVENT TOKEN</a></li>
						<?php }?>
						<!-- //////////////////////////new code EVENT TOKEN end ////////////////// -->

						<!-- //////////////////////////new code HALL start//////////////////////// -->
						<?php if((isset($_SESSION['Book_Hall'])) || (isset($_SESSION['All_Hall_Bookings']))) { ?>
									<li><a data-toggle="tab" href="#HS">HALL</a></li>
						<?php }?>
                         <!--///////////////////////////new code HALL end /////////////////////////  -->
						
						 <!-- //////////////////////////new code RECEIPT start ////////////////// -->
						<?php if(((isset($_SESSION['All_Trust_Receipt'])) || 
						          (isset($_SESSION['New_Trust_Receipt'])) || 
								  (isset($_SESSION['All_Event_Receipt'])) || 
								  (isset($_SESSION['Event_Seva'])) || 
								  (isset($_SESSION['Event_Donation/Kanike'])) || 
								  (isset($_SESSION['Deity/Event_Hundi'])) || 
								  (isset($_SESSION['Deity/Event_Inkind']))) 
								  && $_SESSION['trustLogin'] == "1") { ?>
						           <li><a data-toggle="tab" href="#RECEIPT">RECEIPT</a></li>
						<?php }?>
						<!-- /////////////////////////new code RECEIPT end //////////////////// -->
						
						<!-- ///////////////////////// new code for REPORT start ////////////// -->
						<?php if(((isset($_SESSION['Trust_Receipt_Report'])) || 
						          (isset($_SESSION['Trust_MIS_Report'])) || 
								  (isset($_SESSION['Current_Event_Receipt_Report'])) || 
								  (isset($_SESSION['Current_Event_Seva_Report'])) || 
								  (isset($_SESSION['Current_Event_MIS_Report'])) || 
								  (isset($_SESSION['User_Event_Collection_Report'])) || 
								  (isset($_SESSION['Trust_Day_Book'])) || 
								  (isset($_SESSION['Event_Seva_Summary']))||
								  (isset($_SESSION['Trust_Inkind_Report']))) 
								  && $_SESSION['trustLogin'] == "1") { ?>
								  <li><a data-toggle="tab" href="#REPORT">REPORT</a></li>
						<?php }?>
						<!-- ///////////////////////// new code REPORT end ///////////////////// -->
						
						<!-- //////////////////////// new code AUCTION start /////////////////// -->
						<?php if(((isset($_SESSION['Add_Auction_Item'])) || 
						          (isset($_SESSION['Bid_Auction_Item'])) || 
								  (isset($_SESSION['Auction_Receipt'])) || 
								  (isset($_SESSION['Saree_Outward_Report'])) || 
								  (isset($_SESSION['Auction_Item_Report']))) 
								  && $_SESSION['trustLogin'] == "1") { ?>
									<li><a data-toggle="tab" href="#AUC">AUCTION</a></li>
						<?php }?>
						<!-- /////////////////////// new code AUCTION end ////////////////////// -->
						
						<!-- ////////////////////// new code EVENT POSTAGE start //////////////// -->
						<?php if((isset($_SESSION['Event_Postage'])) ||
					             (isset($_SESSION['Event_Dispatch_Collection']))||
								 (isset($_SESSION['All_Event_Postage_Collection']))||
								 (isset($_SESSION['Trust_Event_Postage_Group']))
						         && $_SESSION['trustLogin'] == "1") {  ?>
									<li><a data-toggle="tab" href="#EVTPOS">EVENT POSTAGE</a></li>
						<?php }?>
						<!-- ////////////////////// new code EVEMT POSTAGE end ////////////////// -->
						
						<!-- ///////////////////// new code TRUST E.O.D start///////////////////////// -->
						<?php if((isset($_SESSION['E.O.D_Report'])) || 
						         (isset($_SESSION['E.O.D_Tally_Trust'])) 
								 && $_SESSION['trustLogin'] == "1") { ?>

									<li><a data-toggle="tab" href="#EOD">TRUST E.O.D.</a></li>
						<?php }?>
						<!-- ///////////////////// new code TRUST E.O.D end //////////////////////// -->
					   
						<!-- ///////////////////// new code EVENT E.O.D start /////////////////// -->
						<?php if((isset($_SESSION['Event_E.O.D_Report'])) || 
						        (isset($_SESSION['Event_E.O.D_Tally'])) && 
								$_SESSION['trustLogin'] == "1") { ?>
						    <li><a data-toggle="tab" href="#EVENTEOD">EVENT E.O.D.</a></li>
						<?php }?>
						<!-- //////////////////// new code EVENT E.O.D end ////////////////////// -->
						
						<!-- //////////////////// new code OTHER start /////////////////////// -->
						<?php if((isset($_SESSION['Cheque_Remmittance'])) ||
						       (isset($_SESSION['Check_Remmittance'])) ||
							   (isset($_SESSION['Inkind_Items'])) || 
							   (isset($_SESSION['Function_Types']))
							   && $_SESSION['trustLogin'] == "1") { ?>	

									<li><a data-toggle="tab" href="#OTHERS">OTHERS</a></li>
						<?php }?>
						<!-- /////////////////// new code OTHER end ////////////////////////// -->

						<!-- ////////////////// new code FINANCE start ////////////////////// -->
						<?php if((isset($_SESSION['Trust_Finance_Receipts'])) || 
	                             (isset($_SESSION['Trust_Finance_Payments'])) ||
				                 (isset($_SESSION['Trust_Finance_Journal'])) || 
				                 (isset($_SESSION['Trust_Finance_Contra'])) ||
				                 (isset($_SESSION['Trust_Balance_Sheet'])) ||
				                 (isset($_SESSION['Trust_Income_and_Expenditure'])) || 
				                 (isset($_SESSION['Trust_Receipts_and_Payments'])) || 
				                 (isset($_SESSION['Trust_Trial_Balance'])) || 
				                 (isset($_SESSION['Trust_Finance_Add_Groups'])) || 
				                 (isset($_SESSION['Trust_Finance_Add_Ledgers'])) || 
				                 (isset($_SESSION['Trust_Finance_Add_Opening_Balance'])) || 
				                 (isset($_SESSION['Trust_Finance_Day_Book']))|| 
				                 (isset($_SESSION['Trust_All_Ledgers_and_Groups']))) { ?>
									<li><a data-toggle="tab" href="#FIN">FINANCE</a></li>
						<?php }?>
						<!-- ///////////////// new code FINANCE end ///////////////////////// -->

				</ul>
								
				   <div class="tab-content">
						<?php if((isset($_SESSION['Event_Seva']))) {?>
						            <div id="ES" class="tab-pane fade">
										<h6>EVENT SEVAS</h6>
										<!--EVENT SEVAS-->
									  <?php if((isset($_SESSION['Event_Seva']))) {?> 
										<?php if(@$eventSevas == "Event Sevas") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="eventSevas" name="eventSevas" checked>Event Sevas
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="eventSevas" name="eventSevas">Event Sevas
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="eventSevasId" name="eventSevasId" value="<?php echo $eventSevasId; ?>">
									  <?php }?>
									</div>
						<?php }?>
						<?php if(isset($_SESSION['Trust_Event_Token'])) { ?>
									  <div id="ET" class="tab-pane fade">
										<h6>EVENT TOKEN</h6>
										<!--EVENT TOKEN-->
									    <?php if((isset($_SESSION['Trust_Event_Token']))) {?>
										<?php if(@$trustEventToken == "Trust Event Token") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="trustEventToken" name="trustEventToken" checked>Event Token
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="trustEventToken" name="trustEventToken">Event Token
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="trustEventTokenId" name="trustEventTokenId" value="<?php echo $trustEventTokenId; ?>">
									    <?php }?>   
									  </div>
						<?php }?>
		                <?php if((isset($_SESSION['Auction_Settings'])) ||
							 (isset($_SESSION['Trust_Import_Settings'])) || 
							 (isset($_SESSION['Check_Remmittance'])) || 
							 (isset($_SESSION['Users_Settings'])) || 
							 (isset($_SESSION['Group_Settings'])) || 
							 (isset($_SESSION['Hall_Settings'])) || 
							 (isset($_SESSION['Block_Date_Settings'])) ||
							 (isset($_SESSION['Bank_Settings'])) || 
							 (isset($_SESSION['Event_Seva_Settings'])) ||
							 (isset($_SESSION['Trust_Bank_Cheque_Configuration']))||
							 (isset($_SESSION['Trust_Finance_Prerequisites'])) ||
							 (isset($_SESSION['Receipt_Settings']))) {  ?>
								<div id="SET" class="tab-pane fade in active">
										<h6>SETTINGS</h6>
										<!-- Adding the finance setting by adithya on 20-12-2023 start -->
											<!-- Finance Prerequisites-->
										<!-- Suraksha -->
									<?php if( (isset($_SESSION['Trust_Finance_Prerequisites']))) {?>
										<?php if(@$financePrerequisites == "Finance Prerequisites") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="financePrerequisites" name="financePrerequisites" checked>Finance Prerequisites
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="financePrerequisites" name="financePrerequisites">Finance Prerequisites
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="financePrerequisitesId" name="financePrerequisitesId" value="<?php echo $financePrerequisitesId; ?>">
									<?php }?>
										<!-- Voucher Counter  -->
										<!-- Suraksha -->
									<?php if( (isset($_SESSION['Trust_Voucher_Counter']))) {?>
										<?php if(@$voucherCounter == "Voucher Counter") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="voucherCounter" name="voucherCounter" checked>Voucher Counter
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="voucherCounter" name="voucherCounter">Voucher Counter
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="voucherCounterId" name="voucherCounterId" value="<?php echo $voucherCounterId; ?>">
									<?php }?>
										<!-- Bank Cheque Configuration -->
										<!-- Suraksha -->
									<?php if((isset($_SESSION['Trust_Bank_Cheque_Configuration']))) {?> 
										<?php if(@$bankChequeConfiguration == "Cheque Configuration") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="bankChequeConfiguration" name="bankChequeConfiguration" checked>Bank Cheque Configuration
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="bankChequeConfiguration" name="bankChequeConfiguration">Bank Cheque Configuration
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="bankChequeConfigurationId" name="bankChequeConfigurationId" value="<?php echo $bankChequeConfigurationId; ?>">
									<?php }?>
										<!-- Adding the finance setting by adithya on 20-12-2023 -->
										<!--USERS SETTINGS-->
									<?php if((isset($_SESSION['Users_Settings']))) {?> 
										<?php if(@$userSettings == "Users Settings") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="userSettings" name="userSettings" checked>Users Settings
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="userSettings" name="userSettings">Users Settings
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="userSettingsId" name="userSettingsId" value="<?php echo $userSettingsId; ?>">
									<?php }?>
										<!--GROUP SETTINGS-->
									<?php if((isset($_SESSION['Group_Settings']))) {?> 
										<?php if(@$groupSettings == "Group Settings") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="groupSettings" name="groupSettings" checked>Group Settings
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="groupSettings" name="groupSettings">Group Settings
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="groupSettingsId" name="groupSettingsId" value="<?php echo $groupSettingsId; ?>">
									<?php }?>
										<!--HALL SETTINGS-->
									<?php if((isset($_SESSION['Hall_Settings']))) {?> 
										<?php if(@$hallSettings == "Hall Settings") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="hallSettings" name="hallSettings" checked>Hall Settings
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="hallSettings" name="hallSettings">Hall Settings
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="hallSettingsId" name="hallSettingsId" value="<?php echo $hallSettingsId; ?>">
									<?php }?>
										<!--BLOCK DATE SETTINGS-->
									<?php if( (isset($_SESSION['Block_Date_Settings']))) {?> 
										<?php if(@$blockDateSettings == "Block Date Settings") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="blockDateSettings" name="blockDateSettings" checked>Block Date Settings
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="blockDateSettings" name="blockDateSettings">Block Date Settings
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="blockDateSettingsId" name="blockDateSettingsId" value="<?php echo $blockDateSettingsId; ?>">
									<?php }?>
										<!--BANK SETTINGS-->
									<?php if((isset($_SESSION['Bank_Settings']))) {?> 
										<?php if(@$bankSettings == "Bank Settings") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="bankSettings" name="bankSettings" checked>Bank Settings
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="bankSettings" name="bankSettings">Bank Settings
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="bankSettingsId" name="bankSettingsId" value="<?php echo $bankSettingsId; ?>">
									<?php }?>
										<!--EVENT SEVA SETTINGS-->
									<?php if((isset($_SESSION['Event_Seva_Settings']))) {?>
										<?php if(@$eventSevaSettings == "Event Seva Settings") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="eventSevaSettings" name="eventSevaSettings" checked>Event Seva Settings
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="eventSevaSettings" name="eventSevaSettings">Event Seva Settings
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="eventSevaSettingsId" name="eventSevaSettingsId" value="<?php echo $eventSevaSettingsId; ?>">
									<?php }?>
										<!--RECEIPT SETTINGS-->
									<?php if((isset($_SESSION['Receipt_Settings']))) {?> 
										<?php if(@$receiptSettings == "Receipt Settings") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="receiptSettings" name="receiptSettings" checked>Receipt Settings
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="receiptSettings" name="receiptSettings">Receipt Settings
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="receiptSettingsId" name="receiptSettingsId" value="<?php echo $receiptSettingsId; ?>">
									<?php }?>
										<!--IMPORT SETTINGS-->
									<?php if((isset($_SESSION['Trust_Import_Settings']))) {?>
										<?php if(@$trustImportSettings == "Trust Import Settings") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="trustImportSettings" name="trustImportSettings" checked>Trust Import Settings
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="trustImportSettings" name="trustImportSettings">Trust Import Settings
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="trustImportSettingsId" name="trustImportSettingsId" value="<?php echo $trustImportSettingsId; ?>">
									<?php }?>
										<!--AUCTION SETTINGS-->
									<?php if((isset($_SESSION['Auction_Settings']))) {?>
										<?php if(@$auctionSettings == "Auction Settings") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="auctionSettings" name="auctionSettings" checked>Auction Settings
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="auctionSettings" name="auctionSettings">Auction Settings
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="auctionSettingsId" name="auctionSettingsId" value="<?php echo $auctionSettingsId; ?>">
									<?php }?>
								</div>
						<?php }?>
						<?php if((isset($_SESSION['Cheque_Remmittance'])) ||
						       (isset($_SESSION['Check_Remmittance'])) ||
							   (isset($_SESSION['Inkind_Items'])) || 
							   (isset($_SESSION['Function_Types']))
							   && $_SESSION['trustLogin'] == "1") { ?>			
						    <div id="OTHERS" class="tab-pane fade">
										<h6>OTHERS</h6>
										<!--FUNCTION TYPES-->
									<?php if((isset($_SESSION['Function_Types']))) {?>
										<?php if(@$functionType == "Function Types") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="functionType" name="functionType" checked>Function Types
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="functionType" name="functionType">Function Types
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="functionTypeId" name="functionTypeId" value="<?php echo $functionTypeId; ?>">
									<?php }?>
										<!--INKIND ITEMS-->
									<?php if((isset($_SESSION['Inkind_Items']))) {?>
										<?php if(@$inkindItems == "Inkind Items") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="inkindItems" name="inkindItems" checked>Inkind Items
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="inkindItems" name="inkindItems">Inkind Items
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="inkindItemsId" name="inkindItemsId" value="<?php echo $inkindItemsId; ?>">
									<?php }?>
										<!--CHEQUE REMMITTANCE-->
										<?php if(@$chequeRemmittance == "Event Cheque Remmittance") { ?>
											<!-- <label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="chequeRemmittance" name="chequeRemmittance" checked>Event Cheque Remmittance -->
											</label>
										<?php } else { ?>
											<!-- <label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="chequeRemmittance" name="chequeRemmittance">Event Cheque Remmittance -->
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<!-- <input type="hidden" id="chequeRemmittanceId" name="chequeRemmittanceId" value="<?php echo $chequeRemmittanceId; ?>"> -->
										<!--CHECK REMMITTANCE-->
									<?php if((isset($_SESSION['Check_Remmittance']))) {?>
										<?php if(@$checkRemmittance == "Check Remmittance") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="checkRemmittance" name="checkRemmittance" checked>Cheque Remmittance
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="checkRemmittance" name="checkRemmittance">Cheque Remmittance
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="checkRemmittanceId" name="checkRemmittanceId" value="<?php echo $checkRemmittanceId; ?>">
									<?php }?>
							</div>
						<?php }?>
						<?php if((isset($_SESSION['Book_Hall'])) || 
						         (isset($_SESSION['All_Hall_Bookings']))) { ?>
									<div id="HS" class="tab-pane fade">
										<h6>HALL</h6>
										<!--BOOK HALL-->
									    <?php if((isset($_SESSION['Book_Hall']))) {?>
										<?php if(@$bookHall == "Book Hall") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="bookHall" name="bookHall" checked>Book Hall
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="bookHall" name="bookHall">Book Hall
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="bookHallId" name="bookHallId" value="<?php echo $bookHallId; ?>">
									    <?php }?>
									    	<!--BOOK HALL-->
									    <?php if((isset($_SESSION['All_Hall_Bookings']))) {?>
										<?php if(@$allHallBooking == "All Hall Bookings") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="allHallBooking" name="allHallBooking" checked>All Hall Bookings
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="allHallBooking" name="allHallBooking">All Hall Bookings
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="allHallBookingId" name="allHallBookingId" value="<?php echo $allHallBookingId; ?>">
									    <?php }?>
									</div>
						<?php }?>
						<?php if(((isset($_SESSION['All_Trust_Receipt'])) || 
						          (isset($_SESSION['New_Trust_Receipt'])) || 
								  (isset($_SESSION['All_Event_Receipt'])) || 
								  (isset($_SESSION['Event_Seva'])) || 
								  (isset($_SESSION['Event_Donation/Kanike'])) || 
								  (isset($_SESSION['Deity/Event_Hundi'])) || 
								  (isset($_SESSION['Deity/Event_Inkind']))) 
								  && $_SESSION['trustLogin'] == "1") { ?>
								<div id="RECEIPT" class="tab-pane fade">
										<h6>RECEIPT</h6>
										<!--NEW TRUST RECEIPT-->
									<?php if((isset($_SESSION['New_Trust_Receipt']))) {?>
										<?php if(@$newTrustReceipt == "New Trust Receipt") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="newTrustReceipt" name="newTrustReceipt" checked>New Trust Receipt
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="newTrustReceipt" name="newTrustReceipt">New Trust Receipt
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="newTrustReceiptId" name="newTrustReceiptId" value="<?php echo $newTrustReceiptId; ?>">
									<?php }?>
										<!--ALL TRUST RECEIPT-->
									<?php if((isset($_SESSION['All_Trust_Receipt']))) {?>
										<?php if(@$allTrustReceipt == "All Trust Receipt") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="allTrustReceipt" name="allTrustReceipt" checked>All Trust Receipt
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="allTrustReceipt" name="allTrustReceipt">All Trust Receipt
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="allTrustReceiptId" name="allTrustReceiptId" value="<?php echo $allTrustReceiptId; ?>">
									<?php }?>
										<!--ALL EVENT RECEIPT-->
									<?php if((isset($_SESSION['All_Event_Receipt']))) {?>
										<?php if(@$allEventReceipt == "All Event Receipt") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="allEventReceipt" name="allEventReceipt" checked>All Event Receipt
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="allEventReceipt" name="allEventReceipt">All Event Receipt
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="allEventReceiptId" name="allEventReceiptId" value="<?php echo $allEventReceiptId; ?>">
									<?php }?>
										<!--EVENT SEVA-->
									<?php if((isset($_SESSION['Event_Seva']))) {?>
										<?php if(@$eventSeva == "Event Seva") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="eventSeva" name="eventSeva" checked>Event Seva
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="eventSeva" name="eventSeva">Event Seva
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="eventSevaId" name="eventSevaId" value="<?php echo $eventSevaId; ?>">
									<?php }?>
										<!--EVENT DONATION/KANIKE-->
									<?php if((isset($_SESSION['Event_Donation/Kanike']))) {?>
										<?php if(@$eventDonationKanike == "Event Donation/Kanike") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="eventDonationKanike" name="eventDonationKanike" checked>Event Donation/Kanike
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="eventDonationKanike" name="eventDonationKanike">Event Donation/Kanike
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="eventDonationKanikeId" name="eventDonationKanikeId" value="<?php echo $eventDonationKanikeId; ?>">
									<?php }?>
										<!--DEITY/EVENT HUNDI-->
									<?php if((isset($_SESSION['Deity/Event_Hundi']))) {?>
										<?php if(@$deityEventHundi == "Event Hundi") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="deityEventHundi" name="deityEventHundi" checked>Event Hundi
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="deityEventHundi" name="deityEventHundi">Event Hundi
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="deityEventHundiId" name="deityEventHundiId" value="<?php echo $deityEventHundiId; ?>">
									<?php }?>
										<!--DEITY/EVENT INKIND-->
									<?php if((isset($_SESSION['Deity/Event_Inkind']))) {?> 
										<?php if(@$deityEventInkind == "Event Inkind") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="deityEventInkind" name="deityEventInkind" checked>Event Inkind
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="deityEventInkind" name="deityEventInkind">Event Inkind
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="deityEventInkindId" name="deityEventInkindId" value="<?php echo $deityEventInkindId; ?>">
									<?php }?>
								</div>
						<?php }?>
						<?php if(((isset($_SESSION['Trust_Receipt_Report'])) || 
						          (isset($_SESSION['Trust_MIS_Report'])) || 
								  (isset($_SESSION['Current_Event_Receipt_Report'])) || 
								  (isset($_SESSION['Current_Event_Seva_Report'])) || 
								  (isset($_SESSION['Current_Event_MIS_Report'])) || 
								  (isset($_SESSION['User_Event_Collection_Report'])) || 
								  (isset($_SESSION['Trust_Day_Book'])) || 
								  ((isset($_SESSION['Hall_Bookings_Report'])))||
								  (isset($_SESSION['Event_Seva_Summary']))||
								  (isset($_SESSION['Trust_Inkind_Report']))) 
								  && $_SESSION['trustLogin'] == "1") { ?>
								<div id="REPORT" class="tab-pane fade">
										<h6>REPORT</h6>
										<!--TRUST RECEIPT REPORT-->
									<?php if((isset($_SESSION['Trust_Receipt_Report']))) {?>
										<?php if(@$trustReceiptReport == "Trust Receipt Report") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="trustReceiptReport" name="trustReceiptReport" checked>Trust Receipt Report
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="trustReceiptReport" name="trustReceiptReport">Trust Receipt Report
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="trustReceiptReportId" name="trustReceiptReportId" value="<?php echo $trustReceiptReportId; ?>">
									<?php }?>
										<!--TRUST MIS REPORT-->
									<?php if( (isset($_SESSION['Trust_MIS_Report']))) {?>
										<?php if(@$trustMISReport == "Trust MIS Report") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="trustMISReport" name="trustMISReport" checked>Trust MIS Report
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="trustMISReport" name="trustMISReport">Trust MIS Report
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="trustMISReportId" name="trustMISReportId" value="<?php echo $trustMISReportId; ?>">
									<?php }?>
										<!--HALL BOOKINGS REPORT-->
                                    <?php if((isset($_SESSION['Hall_Bookings_Report']))) {?>
										<?php if(@$hallBookingsReport == "Hall Bookings Report") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="hallBookingsReport" name="hallBookingsReport" checked>Hall Bookings Report
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="hallBookingsReport" name="hallBookingsReport">Hall Bookings Report
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="hallBookingsReportId" name="hallBookingsReportId" value="<?php echo $hallBookingsReportId; ?>">
								    <?php }?>
										<!--DAY BOOK REPORT-->
									<?php if( (isset($_SESSION['Trust_Day_Book']))) {?>
										<?php if(@$TrustDayBook == "Trust Day Book") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="TrustDayBook" name="TrustDayBook" checked>Day Book Report
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="TrustDayBook" name="TrustDayBook">Day Book Report
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="TrustDayBookId" name="TrustDayBookId" value="<?php echo $TrustDayBookId; ?>">
									<?php }?>
										<!--Trust Inkind Report-->
									<?php if((isset($_SESSION['Trust_Inkind_Report']))) {?>
										<?php if(@$TrustInkindReport == "Trust Inkind Report") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="TrustInkindReport" name="TrustInkindReport" checked>Trust Inkind Report
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="TrustInkindReport" name="TrustInkindReport">Trust Inkind Report
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="TrustInkindReportId" name="TrustInkindReportId" value="<?php echo $TrustInkindReportId; ?>">
									<?php }?>
										<!--CURRENT EVENT RECEIPT REPORT-->
									<?php if( (isset($_SESSION['Current_Event_Receipt_Report']))) {?>
										<?php if(@$currentEventReceiptReport == "Current Event Receipt Report") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="currentEventReceiptReport" name="currentEventReceiptReport" checked>Current Event Receipt Report
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="currentEventReceiptReport" name="currentEventReceiptReport">Current Event Receipt Report
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="currentEventReceiptReportId" name="currentEventReceiptReportId" value="<?php echo $currentEventReceiptReportId; ?>">
									<?php }?>
										<!--CURRENT EVENT SEVA REPORT-->
									<?php if((isset($_SESSION['Current_Event_Seva_Report']))) {?>
										<?php if(@$currentEventSevaReport == "Current Event Seva Report") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="currentEventSevaReport" name="currentEventSevaReport" checked>Current Event Seva Report
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="currentEventSevaReport" name="currentEventSevaReport">Current Event Seva Report
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="currentEventSevaReportId" name="currentEventSevaReportId" value="<?php echo $currentEventSevaReportId; ?>">
									<?php }?>
										<!--EVENT SEVA SUMMARY-->
									<?php if((isset($_SESSION['Event_Seva_Summary']))) {?>
										<?php if(@$eventSevaSummary == "Event Seva Summary") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="eventSevaSummary" name="eventSevaSummary" checked>Event Seva Summary
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="eventSevaSummary" name="eventSevaSummary">Event Seva Summary
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="eventSevaSummaryId" name="eventSevaSummaryId" value="<?php echo $eventSevaSummaryId; ?>">
									<?php }?>
										<!--CURRENT EVENT MIS REPORT-->
									<?php if((isset($_SESSION['Current_Event_MIS_Report']))) {?>
										<?php if(@$currentEventMISReport == "Current Event MIS Report") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="currentEventMISReport" name="currentEventMISReport" checked>Current Event MIS Report
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="currentEventMISReport" name="currentEventMISReport">Current Event MIS Report
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="currentEventMISReportId" name="currentEventMISReportId" value="<?php echo $currentEventMISReportId; ?>">
									<?php }?>
										<!--USER EVENT COLLECTION REPORT-->
									<?php if((isset($_SESSION['User_Event_Collection_Report']))) {?>
										<?php if(@$userEventCollectionReport == "User Event Collection Report") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="userEventCollectionReport" name="userEventCollectionReport" checked>User Event Collection Report
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="userEventCollectionReport" name="userEventCollectionReport">User Event Collection Report
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="userEventCollectionReportId" name="userEventCollectionReportId" value="<?php echo $userEventCollectionReportId; ?>">
									<?php }?>
								</div>
					    <?php }?>
						<?php if(((isset($_SESSION['Add_Auction_Item'])) || 
						          (isset($_SESSION['Bid_Auction_Item'])) || 
								  (isset($_SESSION['Auction_Receipt'])) || 
								  (isset($_SESSION['Saree_Outward_Report'])) || 
								  (isset($_SESSION['Auction_Item_Report']))) 
								  && $_SESSION['trustLogin'] == "1") { ?>
							
								<div id="AUC" class="tab-pane fade">
										<h6>AUCTION</h6>
										<!--ADD AUCTION ITEM-->
									<?php if((isset($_SESSION['Add_Auction_Item']))) {?> 
										<?php if(@$addAuctionItem == "Add Auction Item") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="addAuctionItem" name="addAuctionItem" checked>Add Auction Item
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="addAuctionItem" name="addAuctionItem">Add Auction Item
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="addAuctionItemId" name="addAuctionItemId" value="<?php echo $addAuctionItemId; ?>">
									<?php }?>
										<!--BID AUCTION ITEM-->
									<?php if((isset($_SESSION['Bid_Auction_Item']))) {?>
										<?php if(@$bidAuctionItem == "Bid Auction Item") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="bidAuctionItem" name="bidAuctionItem" checked>Bid Auction Item
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="bidAuctionItem" name="bidAuctionItem">Bid Auction Item
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="bidAuctionItemId" name="bidAuctionItemId" value="<?php echo $bidAuctionItemId; ?>">
									<?php }?>
										<!--AUCTION RECEIPT-->
									<?php if((isset($_SESSION['Auction_Receipt']))) {?>
										<?php if(@$auctionReceipt == "Auction Receipt") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="auctionReceipt" name="auctionReceipt" checked>Auction Receipt
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="auctionReceipt" name="auctionReceipt">Auction Receipt
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="auctionReceiptId" name="auctionReceiptId" value="<?php echo $auctionReceiptId; ?>">
									<?php }?>
										<!--SAREE OUTWARD REPORT-->
									<?php if((isset($_SESSION['Saree_Outward_Report']))) {?>
										<?php if(@$sareeOutwardReport == "Saree Outward Report") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="sareeOutwardReport" name="sareeOutwardReport" checked>Saree Outward Report
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="sareeOutwardReport" name="sareeOutwardReport">Saree Outward Report
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="sareeOutwardReportId" name="sareeOutwardReportId" value="<?php echo $sareeOutwardReportId; ?>">
									<?php }?>
										<!--AUCTION ITEM REPORT-->
									<?php if((isset($_SESSION['Auction_Item_Report']))) {?>
										<?php if(@$auctionItemReport == "Auction Item Report") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="auctionItemReport" name="auctionItemReport" checked>Auction Item Report
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="auctionItemReport" name="auctionItemReport">Auction Item Report
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="auctionItemReportId" name="auctionItemReportId" value="<?php echo $auctionItemReportId; ?>">
									<?php }?>
								</div>
						<?php }?>
						<?php if((isset($_SESSION['Event_Postage'])) ||
					             (isset($_SESSION['Event_Dispatch_Collection']))||
								 (isset($_SESSION['All_Event_Postage_Collection']))||
								 (isset($_SESSION['Trust_Event_Postage_Group']))
						         && $_SESSION['trustLogin'] == "1") {  ?>
							
								<div id="EVTPOS" class="tab-pane fade">
										<h6>EVENT POSTAGE</h6>
									<?php if((isset($_SESSION['Event_Postage']))) {?>
										<?php if(@$eventPostage == "Event Postage") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="eventPostage" name="eventPostage" checked>Event Postage
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="eventPostage" name="eventPostage">Event Postage
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="eventPostageId" name="eventPostageId" value="<?php echo $eventPostageId; ?>">
									<?php }?>
										<!--EVENT DISPATCH COLLECTION-->
									<?php if((isset($_SESSION['Event_Dispatch_Collection']))) {?>
										<?php if(@$eventDispatchCollection == "Event Dispatch Collection") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="eventDispatchCollection" name="eventDispatchCollection" checked>Event Dispatch Pending
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="eventDispatchCollection" name="eventDispatchCollection">Event Dispatch Pending
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="eventDispatchCollectionId" name="eventDispatchCollectionId" value="<?php echo $eventDispatchCollectionId; ?>">
									<?php }?>
										<!--ALL POSTAGE COLLECTION-->
									<?php if((isset($_SESSION['All_Event_Postage_Collection']))) {?>
										<?php if(@$allEventPostageCollection == "All Event Postage Collection") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="allEventPostageCollection" name="allEventPostageCollection" checked>All Event Postage Collection
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="allEventPostageCollection" name="allEventPostageCollection">All Event Postage Collection
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="allEventPostageCollectionId" name="allEventPostageCollectionId" value="<?php echo $allEventPostageCollectionId; ?>">
									<?php }?>
										<!--SLVT EVENT POSTAGE GROUP -->
									<?php if((isset($_SESSION['Trust_Event_Postage_Group']))) {?>
										<?php if(@$trustEvtPostageGroup == "Trust Event Postage Group") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="trustEvtPostageGroup" name="trustEvtPostageGroup" checked>Trust Event Postage Group
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="trustEvtPostageGroup" name="trustEvtPostageGroup">Trust Event Postage Group
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="trustEvtPostageGroupId" name="trustEvtPostageGroupId" value="<?php echo $trustEvtPostageGroupId; ?>">
									<?php }?>
								</div>
						<?php }?>
						<?php if((isset($_SESSION['E.O.D_Report'])) || 
						         (isset($_SESSION['E.O.D_Tally_Trust'])) 
								 && $_SESSION['trustLogin'] == "1") { ?>

								<div id="EOD" class="tab-pane fade">
										<h6>TRUST E.O.D.</h6>
										<!--E.O.D REPORT-->
									<?php if((isset($_SESSION['E.O.D_Report']))) {?>
										<?php if(@$eodReport == "E.O.D. Report") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="eodReport" name="eodReport" checked>E.O.D. Report
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="eodReport" name="eodReport">E.O.D. Report
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="eodReportId" name="eodReportId" value="<?php echo $eodReportId; ?>">
									<?php }?>
										<!--E.O.D TALLY-->
									<?php if((isset($_SESSION['E.O.D_Tally_Trust']))) {?>
										<?php if(@$eodTally == "E.O.D. Tally") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="eodTally" name="eodTally" checked>E.O.D. Tally
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="eodTally" name="eodTally">E.O.D. Tally
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="eodTallyId" name="eodTallyId" value="<?php echo $eodTallyId; ?>">
									<?php }?>
								</div>
						<?php }?>
						<?php if((isset($_SESSION['Event_E.O.D_Report'])) || 
						        (isset($_SESSION['Event_E.O.D_Tally'])) && 
								$_SESSION['trustLogin'] == "1") { ?>
						
								<div id="EVENTEOD" class="tab-pane fade">
										<h6>EVENT E.O.D.</h6>
										<!--E.O.D REPORT-->
									<?php if((isset($_SESSION['Event_E.O.D_Report']))) {?>
										<?php if(@$eventEodReport == "Event E.O.D. Report") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="eventEodReport" name="eventEodReport" checked>E.O.D. Report
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="eventEodReport" name="eventEodReport">E.O.D. Report
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="eventEodReportId" name="eventEodReportId" value="<?php echo $eventEodReportId; ?>">
									<?php }?>
										<!--E.O.D TALLY-->
									<?php if((isset($_SESSION['Event_E.O.D_Tally']))) {?>
										<?php if(@$eventEodTally == "Event E.O.D. Tally") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="eventEodTally" name="eventEodTally" checked>E.O.D. Tally
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="eventEodTally" name="eventEodTally">E.O.D. Tally
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="eventEodTallyId" name="eventEodTallyId" value="<?php echo $eventEodTallyId; ?>">
									<?php }?>
										<!-- adding the trust finance part by ADITHYA on 19-12-2023 start -->
								</div>
						<?php }?>
						<?php if((isset($_SESSION['Trust_Finance_Receipts'])) || 
	                             (isset($_SESSION['Trust_Finance_Payments'])) ||
				                 (isset($_SESSION['Trust_Finance_Journal'])) || 
				                 (isset($_SESSION['Trust_Finance_Contra'])) ||
				                 (isset($_SESSION['Trust_Balance_Sheet'])) ||
				                 (isset($_SESSION['Trust_Income_and_Expenditure'])) || 
				                 (isset($_SESSION['Trust_Receipts_and_Payments'])) || 
				                 (isset($_SESSION['Trust_Trial_Balance'])) || 
				                 (isset($_SESSION['Trust_Finance_Add_Groups'])) || 
				                 (isset($_SESSION['Trust_Finance_Add_Ledgers'])) || 
				                 (isset($_SESSION['Trust_Finance_Add_Opening_Balance'])) || 
				                 (isset($_SESSION['Trust_Finance_Day_Book']))|| 
				                 (isset($_SESSION['Trust_All_Ledgers_and_Groups']))) { ?>
							
								<div id="FIN" class="tab-pane fade">
										<h6>FINANCE</h6>
										<!--PRINT Finance Receipts DETAILS-->
									<?php if((isset($_SESSION['Trust_Finance_Receipts']))) {?>
										<?php if(@$financeReceipts == "Finance Receipts") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="financeReceipts" name="financeReceipts" checked>Receipts
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="financeReceipts" name="financeReceipts">Receipts
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="financeReceiptsId" name="financeReceiptsId" value="<?php echo $financeReceiptsId; ?>">
									<?php }?>
										<!--PRINT Finance Payments DETAILS-->
									<?php if((isset($_SESSION['Trust_Finance_Payments']))) {?>
										<?php if(@$financePayments == "Finance Payments") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="financePayments" name="financePayments" checked>Payments
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="financePayments" name="financePayments">Payments
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="financePaymentsId" name="financePaymentsId" value="<?php echo $financePaymentsId; ?>">
									<?php }?>
										<!--Finance Journal-->
									<?php if((isset($_SESSION['Trust_Finance_Journal']))) {?>
										<?php if(@$financeJournal == "Finance Journal") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="financeJournal" name="financeJournal" checked>Journal
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="financeJournal" name="financeJournal">Journal
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="financeJournalId" name="financeJournalId" value="<?php echo $financeJournalId; ?>">
									<?php }?>
										<!--Finance Contra-->
									<?php if((isset($_SESSION['Trust_Finance_Contra']))) {?>
										<?php if(@$financeContra == "Finance Contra") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="financeContra" name="financeContra" checked>Contra
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="financeContra" name="financeContra">Contra
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="financeContraId" name="financeContraId" value="<?php echo $financeContraId; ?>">
									<?php }?>
										<!--Balance Sheet-->
									<?php if((isset($_SESSION['Trust_Balance_Sheet']))) {?>
										<?php if(@$balanceSheet == "Balance Sheet") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="balanceSheet" name="balanceSheet" checked>Balance Sheet
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="balanceSheet" name="balanceSheet">Balance Sheet
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="balanceSheetId" name="balanceSheetId" value="<?php echo $balanceSheetId; ?>">
									<?php }?>
										<!--Income and Expenditure-->
									<?php if((isset($_SESSION['Trust_Income_and_Expenditure']))) {?> 
										<?php if(@$incomeAndExpenditure == "Income and Expenditure") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="incomeAndExpenditure" name="incomeAndExpenditure" checked>Income and Expenditure
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="incomeAndExpenditure" name="incomeAndExpenditure">Income and Expenditure
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="incomeAndExpenditureId" name="incomeAndExpenditureId" value="<?php echo $incomeAndExpenditureId; ?>">
									<?php }?>
										<!--Receipts and Payments-->
									<?php if((isset($_SESSION['Trust_Receipts_and_Payments']))) {?>
										<?php if(@$receiptsAndPayments == "Receipts and Payments") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="receiptsAndPayments" name="receiptsAndPayments" checked>Receipts and Payments
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="receiptsAndPayments" name="receiptsAndPayments">Receipts and Payments
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="receiptsAndPaymentsId" name="receiptsAndPaymentsId" value="<?php echo $receiptsAndPaymentsId; ?>">
									<?php }?>
										<!--Trial Balance-->
									<?php if((isset($_SESSION['Trust_Trial_Balance']))) {?>
										<?php if(@$trialBalance == "Trial Balance") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="trialBalance" name="trialBalance" checked>Trial Balance
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="trialBalance" name="trialBalance">Trial Balance
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="trialBalanceId" name="trialBalanceId" value="<?php echo $trialBalanceId; ?>">
									<?php }?>
										<!--Finance Day Book-->
									<?php if((isset($_SESSION['Trust_Finance_Day_Book']))) {?>
										<?php if(@$financeDayBook == "Finance Day Book") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="financeDayBook" name="financeDayBook" checked>Finance Day Book
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="financeDayBook" name="financeDayBook">Finance Day Book
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="financeDayBookId" name="financeDayBookId" value="<?php echo $financeDayBookId; ?>">
									<?php }?>
										<!--Finance Add Groups-->
									<?php if((isset($_SESSION['Trust_Finance_Add_Groups']))) {?>
										<?php if(@$financeAddGroups == "Finance Add Groups") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="financeAddGroups" name="financeAddGroups" checked>Add Groups
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="financeAddGroups" name="financeAddGroups">Add Groups
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="financeAddGroupsId" name="financeAddGroupsId" value="<?php echo $financeAddGroupsId; ?>">
									<?php }?>
										<!--Finance Add Ledgers-->
									<?php if((isset($_SESSION['Trust_Finance_Add_Ledgers']))) {?>
										<?php if(@$financeAddLedgers == "Finance Add Ledgers") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="financeAddLedgers" name="financeAddLedgers" checked>Add Ledgers
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="financeAddLedgers" name="financeAddLedgers">Add Ledgers
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="financeAddLedgersId" name="financeAddLedgersId" value="<?php echo $financeAddLedgersId; ?>">
									<?php }?>
										<!--Finance Add Opening Balance-->
									<?php if((isset($_SESSION['Trust_Finance_Add_Opening_Balance']))) {?>
										<?php if(@$financeAddOpeningBalance == "Finance Add Opening Balance") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="financeAddOpeningBalance" name="financeAddOpeningBalance" checked>Add Opening Balance
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="financeAddOpeningBalance" name="financeAddOpeningBalance">Add Opening Balance
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="financeAddOpeningBalanceId" name="financeAddOpeningBalanceId" value="<?php echo $financeAddOpeningBalanceId; ?>">
									<?php }?>
										<!--Finance All Ledgers and Groups-->
									<?php if((isset($_SESSION['Trust_All_Ledgers_and_Groups']))) {?>
										<?php if(@$allLedgersandGroups == "All Ledgers and Groups") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="allLedgersandGroups" name="allLedgersandGroups" checked>All Ledgers and Groups
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="allLedgersandGroups" name="allLedgersandGroups">All Ledgers and Groups
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="allLedgersandGroupsId" name="allLedgersandGroupsId" value="<?php echo $allLedgersandGroupsId; ?>">
									<?php }?>
										<!-- adding the trust finance part by ADITHYA on 19-12-2023 end -->
								</div>
						<?php }?>
					</div>
			   </div>
		 </div>
						<br/><br/>
						<div class="row form-group">
							<div class="control-group col-md-12 col-lg-12 col-sm-12 col-xs-12">
								<label class="control-label" style="color:#800000;font-size: 12px;"><i>* Indicates mandatory fields.</i></label>
							</div>
						</div>
						
						<div class="row form-group">
							<div class="control-group col-md-6 col-lg-6 col-sm-6 col-xs-12 text-left">
								<button type="submit" class="btn btn-default btn-md"><strong>UPDATE</strong></button>
								<button type="button" class="btn btn-default btn-md" onclick="golist('admin_settings/Admin_Trust_setting/groups_setting');"><strong>CANCEL</strong></button>
							</div>
						</div>
					</div>
			   </section>
		  </div>
		</div>
	</section>
</form>
<script>
	//INPUT KEYPRESS
	$(':input').on('keypress change', function() {
		var id = this.id;
		$('#' + id).css('border-color', "#000000");
	});
		
	//SELECT CHANGE
	$('select').on('change', function() {
		var id = this.id;
		$('#' + id).css('border-color', "#000000");
	});
	
	<!-- Validating Fields -->
	function field_validation() {
		var count = 0;
		
		$('input[type=text]').each(function(){
			var id = this.id;
			if($('#' + id).val() != "") {
				$('#' + id).css('border-color', "#000000");
			} else {
				$('#' + id).css('border-color', "#FF0000");
				++count;
			}
		});
		
		$('select').each(function(){
			var id = this.id;
			if($('#' + id).val() != "") {
				$('#' + id).css('border-color', "#000000");
			} else {
				$('#' + id).css('border-color', "#FF0000");
				++count;
			}
		});
		
		if(count != 0) {
			alert("Information","Please fill required fields","OK");
			return false;
		}
	}

    function golist(url){
		location.href = "<?php echo site_url();?>"+url;
    }
</script>
<style>
.badgebox { opacity: 0; }
.badgebox + .badge { text-indent: -999999px; width: 27px; }
.badgebox:focus + .badge { box-shadow: inset 0px 0px 5px; }
.badgebox:checked + .badge { text-indent: 0; }
</style>