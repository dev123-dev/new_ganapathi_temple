<form action="<?php echo site_url(); ?>admin_settings/Admin_setting/update_group" enctype="multipart/form-data" method="post" accept-charset="utf-8" onsubmit="return field_validation()">
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
									$add = "";$edit = "";$actDcr = "";$auth = "";$addId = "";$notif = ""; $editId = "";$actDctId = "";$authId = "";$notifId = "";
									$rights = explode(", ", $edit_group[0]->R_NAME); 
									$grId = explode(", ", $edit_group[0]->GR_ID); 
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
										} else if(@$rights[$i] == "Notification") {
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
								
								<?php if(@$notif == "Notification") { ?>
									<label class="checkbox-inline" style="font-weight:bold;">
										<input type="checkbox" id="notification" name="notification" checked />Notification
									</label>
								<?php } else { ?>
									<label class="checkbox-inline" style="font-weight:bold;">
										<input type="checkbox" id="notification" name="notification" />Notification
									</label>
								<?php } ?>
								
								<!--HIDDEN FIELDS-->
								<input type="hidden" id="notifyId" name="notifyId" value="<?php echo $notifId; ?>">
							</div>
						</div>
						
						<div class="row form-group">
							<div class="control-group col-md-12 col-lg-12 col-sm-12 col-xs-12">
								<?php 
									$deitySevas = "";$deitySevasId = "";
									$eventSevas = "";$eventSevasId = "";
									$allDeityReceipt = "";$allDeityReceiptId = "";
									$allEventReceipt = "";$allEventReceiptId = "";
									$deitySeva = "";$deitySevaId = "";
									$deityDonation = "";$deityDonationId = "";
									$deityKanike = "";$deityKanikeId = "";$eventSeva = "";$eventSevaId = "";
									$eventDonationKanike = "";$eventDonationKanikeId = "";
									$deityEventHundi = "";$deityEventHundiId = "";
									$deityEventInkind = "";$deityEventInkindId = "";
									$deityReceiptReport = "";$deityReceiptReportId = "";
									$deitySevaReport = "";$deitySevaReportId = "";
									$deityMISReport = "";$deityMISReportId = "";
									$currentEventReceiptReport = "";$currentEventReceiptReportId = "";
									$currentEventSevaReport = "";$currentEventSevaReportId = "";
									$currentEventMISReport = "";$currentEventMISReportId = "";
									$eventSevaSummary = "";$eventSevaSummaryId = "";
									$userEventCollectionReport = "";$userEventCollectionReportId = "";
									$addAuctionItem = "";$addAuctionItemId = "";
									$bidAuctionItem = "";$bidAuctionItemId ="";
									$auctionReceipt = "";$auctionReceiptId = "";
									$sareeOutwardReport = "";$sareeOutwardReportId = "";
									$auctionItemReport = "";$auctionItemReportId = "";
									$deitySevaSettings = "";$deitySevaSettingsId = "";
									$eventSevaSettings = "";$eventSevaSettingsId = "";
									$receiptSettings = "";$receiptSettingsId = "";
									$financePrerequisites = "";$financePrerequisitesId = ""; //Suraksha
									$voucherCounter = "";$voucherCounterId = ""; //Suraksha
									$bankChequeConfiguration = "";$bankChequeConfigurationId = ""; //Suraksha
									$kanikeSettings = "";$kanikeSettingsId = ""; //Suraksha

									$timeSettings = "";$timeSettingsId = "";
									$groupSettings = "";$groupSettingsId = "";
									$userSettings = "";$userSettingsId = "";
									$importSettings = "";$importSettingsId = "";
									$auctionSettings = "";$auctionSettingsId = "";
									$printDeityDetails = "";$printDeityDetailsId = "";
									$printEventDetails = "";$printEventDetailsId = "";
									$inkindItems = "";$inkindItemsId = "";
									$chequeRemmittance = "";$chequeRemmittanceId = "";
									$changeDonation = "";$changeDonationId = "";
									$backUp = "";$backUpId = "";
									$deityChequeRemmittance = "";$deityChequeRemmittanceId = "";
									$bookSeva = "";$bookSevaId = "";
									$allBookedSevas = "";$allBookedSevasId = "";
									$bookedPendingReceipts = "";$bookedPendingReceiptsId = "";//Suraksha
									$financialMonthSettings = "";$financialMonthSettingsId = "";
									$deityEOD = "";$deityEODId = "";
									$EODTally = "";$EODTallyId = "";
									$bankSettings = "";$bankSettingsId = "";
									$deitySevaSummary = "";$deitySevaSummaryId = "";
									$eventEOD = "";$eventEODId = "";$eventEODTally = "";$eventEODTallyId = "";
									$Temple_Day_Book = "";$Temple_Day_Book_Id = "";
									$Temple_Inkind_Report = "";$Temple_Inkind_Report_Id = "";
									$srnsFund = "";$srnsFundId = "";$eventToken = "";$eventTokenId = "";
									$deitySplRecpPrice = "";$deitySplRecpPriceId = "";
									$deityToken = "";$deityTokenId = "";
									$postage = "";$postageId = "";
									$dispatchCollection = "";$dispatchCollectionId = "";
									$allPostageCollection = "";$allPostageCollectionId = "";
									$eventPostage = "";$eventPostageId = "";
									$eventDispatchCollection = "";$eventDispatchCollectionId = "";
									$allEventPostageCollection = "";$allEventPostageCollectionId = "";
									$shashwath = "";$shashwathId = "";
									$shashwathseva = "";$shashwathsevaId = "";
									$shashwathlossreport = "";$shashwathlossreportId = "";
									$shashwathnewmember = "";$shashwathnewmemberId = "";
									$shashwathmember = "";$shashwathmemberId = "";
									$shashwathsettings = "";$shashwathsettingsId = "";
									$shashwathperiodsettings = "";$shashwathperiodsettingsId = "";
									$shashwathcalendarsettings = "";$shashwathcalendarsettingsId = "";
									$shashwathfestivalsettings = "";$shashwathfestivalsettingsId = "";
									$shashwathexistingimport = "";$shashwathexistingimportId = "";
									$jeernodhara = "";$jeernodharaId = "";
									$jeernodharakanike = "";$jeernodharakanikeId = "";
									$jeernodharahundi = "";$jeernodharahundiId = "";
									$jeernodharainkind = "";$jeernodharainkindId = "";
									$jeernodharadailyreport = "";$jeernodharadailyreportId = "";
									
									$postageGroup = ""; $postageGroupId = "";
									$slvtEvtPostageGroup = ""; $slvtEvtPostageGroupId = "";
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

								
									$pages = explode(" , ", $edit_group[0]->P_NAME); 
									$gmId = explode(", ", $edit_group[0]->GM_ID); 
									for($j = 0; $j < count($pages); $j++) {
										
										if(@$pages[$j] == "Deity Sevas") {
											$deitySevas = @$pages[$j]; 
											$deitySevasId = @$gmId[$j]; 
										} else if(@$pages[$j] == "Event Sevas") {
											$eventSevas = @$pages[$j]; 
											$eventSevasId = @$gmId[$j];
										} else if(@$pages[$j] == "All Deity Receipt") {
											$allDeityReceipt = @$pages[$j]; 
											$allDeityReceiptId = @$gmId[$j]; 
										} else if(@$pages[$j] == "All Event Receipt") {
											$allEventReceipt = @$pages[$j]; 
											$allEventReceiptId = @$gmId[$j]; 
										} else if(@$pages[$j] == "Deity Seva") {
											$deitySeva = @$pages[$j]; 
											$deitySevaId = @$gmId[$j]; 
										} else if(@$pages[$j] == "Deity Donation") {
											$deityDonation = @$pages[$j]; 
											$deityDonationId = @$gmId[$j]; 
										} else if(@$pages[$j] == "Deity Kanike") {
											$deityKanike = @$pages[$j]; 
											$deityKanikeId = @$gmId[$j];
										} else if(@$pages[$j] == "Event Seva") {
											$eventSeva = @$pages[$j]; 
											$eventSevaId = @$gmId[$j];
										} else if(@$pages[$j] == "Event Donation/Kanike") {
											$eventDonationKanike = @$pages[$j]; 
											$eventDonationKanikeId = @$gmId[$j];
										} else if(@$pages[$j] == "Deity/Event Hundi") {
											$deityEventHundi = @$pages[$j]; 
											$deityEventHundiId = @$gmId[$j];
										} else if(@$pages[$j] == "Deity/Event Inkind") {
											$deityEventInkind = @$pages[$j]; 
											$deityEventInkindId = @$gmId[$j];
										} else if(@$pages[$j] == "Deity Receipt Report") {
											$deityReceiptReport = @$pages[$j]; 
											$deityReceiptReportId = @$gmId[$j];
										} else if(@$pages[$j] == "Deity Seva Report") {
											$deitySevaReport = @$pages[$j]; 
											$deitySevaReportId = @$gmId[$j];
										} else if(@$pages[$j] == "Deity MIS Report") {
											$deityMISReport = @$pages[$j]; 
											$deityMISReportId = @$gmId[$j];
										} else if(@$pages[$j] == "Current Event Receipt Report") {
											$currentEventReceiptReport = @$pages[$j]; 
											$currentEventReceiptReportId = @$gmId[$j];
										} else if(@$pages[$j] == "Current Event Seva Report") {
											$currentEventSevaReport = @$pages[$j]; 
											$currentEventSevaReportId = @$gmId[$j];
										} else if(@$pages[$j] == "Current Event MIS Report") {
											$currentEventMISReport = @$pages[$j]; 
											$currentEventMISReportId = @$gmId[$j];
										} else if(@$pages[$j] == "Event Seva Summary") {
											$eventSevaSummary = @$pages[$j];
											$eventSevaSummaryId = @$gmId[$j];
										} else if(@$pages[$j] == "User Event Collection Report") {
											$userEventCollectionReport = @$pages[$j]; 
											$userEventCollectionReportId = @$gmId[$j];
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
										} else if(@$pages[$j] == "Deity Seva Settings") {
											$deitySevaSettings = @$pages[$j]; 
											$deitySevaSettingsId = @$gmId[$j]; 
										} else if(@$pages[$j] == "Event Seva Settings") {
											$eventSevaSettings = @$pages[$j]; 
											$eventSevaSettingsId = @$gmId[$j]; 
										} else if(@$pages[$j] == "Receipt Settings") {
											$receiptSettings = @$pages[$j]; 
											$receiptSettingsId = @$gmId[$j]; 
										}//Voucher Counter Suraksha
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
										 //kanikeSettings Suraksha
										 else if(@$pages[$j] == "Kanike Settings") {
											$kanikeSettings = @$pages[$j]; 
											$kanikeSettingsId = @$gmId[$j]; 
										}
										else if(@$pages[$j] == "Time Settings") {
											$timeSettings = @$pages[$j]; 
											$timeSettingsId = @$gmId[$j]; 
										} else if(@$pages[$j] == "Group Settings") {
											$groupSettings = @$pages[$j]; 
											$groupSettingsId = @$gmId[$j]; 
										} else if(@$pages[$j] == "Users Settings") {
											$userSettings = @$pages[$j]; 
											$userSettingsId = @$gmId[$j]; 
										} else if(@$pages[$j] == "Import Settings") {
											$importSettings = @$pages[$j]; 
											$importSettingsId = @$gmId[$j]; 
										} else if(@$pages[$j] == "Auction Settings") {
											$auctionSettings = @$pages[$j]; 
											$auctionSettingsId = @$gmId[$j]; 
										} else if(@$pages[$j] == "Print Deity Details") {
											$printDeityDetails = @$pages[$j]; 
											$printDeityDetailsId = @$gmId[$j]; 
										} else if(@$pages[$j] == "Print Event Details") {
											$printEventDetails = @$pages[$j]; 
											$printEventDetailsId = @$gmId[$j]; 
										} else if(@$pages[$j] == "Inkind Items") {
											$inkindItems = @$pages[$j]; 
											$inkindItemsId = @$gmId[$j]; 
										} else if(@$pages[$j] == "Cheque Remmittance") {
											$chequeRemmittance = @$pages[$j]; 
											$chequeRemmittanceId = @$gmId[$j]; 
										} else if(@$pages[$j] == "Change Donation/Kanike") {
											$changeDonation = @$pages[$j]; 
											$changeDonationId = @$gmId[$j]; 
										} else if(@$pages[$j] == "Back Up") {
											$backUp = @$pages[$j]; 
											$backUpId = @$gmId[$j]; 
										} else if(@$pages[$j] == "Book Seva") {
											$bookSeva = @$pages[$j];
											$bookSevaId = @$gmId[$j];
										} else if(@$pages[$j] == "All Booked Sevas") {
											$allBookedSevas = @$pages[$j];
											$allBookedSevasId = @$gmId[$j];
										} else if(@$pages[$j] == "Booked Pending Receipts") {
											$bookedPendingReceipts = @$pages[$j];
											$bookedPendingReceiptsId = @$gmId[$j];
										}else if(@$pages[$j] == "Financial Month Settings") {
											$financialMonthSettings = @$pages[$j];
											$financialMonthSettingsId = @$gmId[$j];
										} else if(@$pages[$j] == "Deity Cheque Remmittance") {
											$deityChequeRemmittance = @$pages[$j];
											$deityChequeRemmittanceId = @$gmId[$j];
										} else if(@$pages[$j] == "Deity E.O.D") {
											$deityEOD = @$pages[$j];
											$deityEODId = @$gmId[$j];
										} else if(@$pages[$j] == "Bank Settings") {
											$bankSettings = @$pages[$j];
											$bankSettingsId = @$gmId[$j];
										} else if(@$pages[$j] == "E.O.D Tally") {
											$EODTally = @$pages[$j];
											$EODTallyId = @$gmId[$j];
										} else if(@$pages[$j] == "Deity Seva Summary") {
											$deitySevaSummary = @$pages[$j];
											$deitySevaSummaryId = @$gmId[$j];
										} else if(@$pages[$j] == "Event E.O.D") {
											$eventEOD = @$pages[$j];
											$eventEODId = @$gmId[$j];
										} else if(@$pages[$j] == "Event E.O.D Tally") {
											$eventEODTally = @$pages[$j];
											$eventEODTallyId = @$gmId[$j];
										}  else if(@$pages[$j] == "Temple Day Book") {
											$Temple_Day_Book = @$pages[$j];
											$Temple_Day_Book_Id = @$gmId[$j];
										}else if(@$pages[$j] == "Temple Inkind Report") {
											$Temple_Inkind_Report = @$pages[$j];
											$Temple_Inkind_Report_Id = @$gmId[$j];
										} else if(@$pages[$j] == "SRNS Fund") {
											$srnsFund = @$pages[$j];
											$srnsFundId = @$gmId[$j];
										} else if(@$pages[$j] == "Event Token") {
											$eventToken = @$pages[$j];
											$eventTokenId = @$gmId[$j];
										} else if(@$pages[$j] == "Deity Special Receipt Price") {
											$deitySplRecpPrice = @$pages[$j];
											$deitySplRecpPriceId = @$gmId[$j];
										} else if(@$pages[$j] == "Deity Token") {
											$deityToken = @$pages[$j];
											$deityTokenId = @$gmId[$j];
										} else if(@$pages[$j] == "Postage") {
											$postage = @$pages[$j];
											$postageId = @$gmId[$j];
										} else if(@$pages[$j] == "Dispatch Collection") {
											$dispatchCollection = @$pages[$j];
											$dispatchCollectionId = @$gmId[$j];
										} else if(@$pages[$j] == "All Postage Collection") {	
											$allPostageCollection = @$pages[$j];
											$allPostageCollectionId = @$gmId[$j];
										} else if(@$pages[$j] == "Event Postage") {
											$eventPostage = @$pages[$j];
											$eventPostageId = @$gmId[$j];
										} else if(@$pages[$j] == "Event Dispatch Collection") {
											$eventDispatchCollection = @$pages[$j];
											$eventDispatchCollectionId = @$gmId[$j];
										} else if(@$pages[$j] == "All Event Postage Collection") {	
											$allEventPostageCollection = @$pages[$j];
											$allEventPostageCollectionId = @$gmId[$j];
										} else if(@$pages[$j] == "Shashwath") {	
											$shashwath = @$pages[$j];
											$shashwathId = @$gmId[$j];
										}else if(@$pages[$j] == "Shashwath Seva") {	
											$shashwathseva = @$pages[$j];
											$shashwathsevaId = @$gmId[$j];
										}else if(@$pages[$j] == "Shashwath Loss Report") {	
											$shashwathlossreport = @$pages[$j];
											$shashwathlossreportId = @$gmId[$j];
										}else if(@$pages[$j] == "Shashwath New Member") {	
											$shashwathnewmember = @$pages[$j];
											$shashwathnewmemberId = @$gmId[$j];
										} else if(@$pages[$j] == "Shashwath Member") {	
											$shashwathmember = @$pages[$j];
											$shashwathmemberId = @$gmId[$j];
										}  else if(@$pages[$j] == "Shashwath Period Settings") {	
											$shashwathperiodsettings = @$pages[$j];
											$shashwathperiodsettingsId = @$gmId[$j];
										} else if(@$pages[$j] == "Shashwath Calendar Settings") {	
											$shashwathcalendarsettings = @$pages[$j];
											$shashwathcalendarsettingsId = @$gmId[$j];
										} else if(@$pages[$j] == "Shashwath Festival Settings") {	
											$shashwathfestivalsettings = @$pages[$j];
											$shashwathfestivalsettingsId = @$gmId[$j];
										} else if(@$pages[$j] == "Shashwath Existing Import") {	
											$shashwathexistingimport = @$pages[$j];
											$shashwathexistingimportId = @$gmId[$j];
										}else if(@$pages[$j] == "Jeernodhara") {	
											$jeernodhara = @$pages[$j];
											$jeernodharaId = @$gmId[$j];
										}else if(@$pages[$j] == "Jeernodhara Kanike") {	
											$jeernodharakanike = @$pages[$j];
											$jeernodharakanikeId = @$gmId[$j];
										}else if(@$pages[$j] == "Jeernodhara Hundi") {	
											$jeernodharahundi = @$pages[$j];
											$jeernodharahundiId = @$gmId[$j];
										}else if(@$pages[$j] == "Jeernodhara Inkind") {	
											$jeernodharainkind = @$pages[$j];
											$jeernodharainkindId = @$gmId[$j];
										}else if(@$pages[$j] == "Jeernodhara Daily Report") {	
											$jeernodharadailyreport = @$pages[$j];
											$jeernodharadailyreportId = @$gmId[$j];
										}else if(@$pages[$j] == "Postage Group") {	
											$postageGroup = @$pages[$j];
											$postageGroupId = @$gmId[$j];
										}else if(@$pages[$j] == "Event Postage Group") {	
											$slvtEvtPostageGroup = @$pages[$j];
											$slvtEvtPostageGroupId = @$gmId[$j];
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
									}	
								?>
								
						    <ul class="nav nav-tabs">
							
								<?php if((isset($_SESSION['Deity_Sevas']))) { ?>
									<li class="active"><a data-toggle="tab" href="#DS">DEITY SEVAS</a></li>
								<?php } ?>

								<?php if(((isset($_SESSION['Shashwath']))) || 
									     (isset($_SESSION['Shashwath_Seva']))|| 
										 (isset($_SESSION['Shashwath_Member']))|| 
										 (isset($_SESSION['Shashwath_Loss_Report']))|| 
										 (isset($_SESSION['Shashwath_New_Member']))) { ?>
									    <li><a data-toggle="tab" href="#SH">SHASHWATH</a></li>
								<?php } ?>

								<?php if((isset($_SESSION['Jeernodhara']))||
									     (isset($_SESSION['Jeernodhara_Kanike']))|| 
										 (isset($_SESSION['Jeernodhara_Hundi']))|| 
										 (isset($_SESSION['Jeernodhara_Inkind']))|| 
										 (isset($_SESSION['Jeernodhara_Daily_Report']))) {?>
 									             <li><a data-toggle="tab" href="#JH">JEERNODHARA</a></li>
								<?php }?>
                                  	
								<?php if((isset($_SESSION['Deity_Token']))) { ?>
										<li><a data-toggle="tab" href="#DT">DEITY TOKEN</a></li>
							    <?php }?>

								<?php if((isset($_SESSION['Event_Sevas']))) { ?>
									<li><a data-toggle="tab" href="#ES">EVENT SEVAS</a></li>
                                <?php } ?>

								<?php if((isset($_SESSION['Event_Token']))) { ?>
									 <li><a data-toggle="tab" href="#ET">EVENT TOKEN</a></li>
                                <?php }?>
 
				                <?php if((isset($_SESSION['Book_Seva'])) || 
								          (isset($_SESSION['All_Booked_Sevas'])) || 
										   (isset($_SESSION['Booked_Pending_Receipts']))) {?>
					                     <li><a data-toggle="tab" href="#BOOKING">BOOKING</a></li>
				                <?php } ?>

                                <?php if((isset($_SESSION['All_Deity_Receipt'])) ||  
										    (isset($_SESSION['All_Event_Receipt'])) || 
											(isset($_SESSION['Deity_Seva'])) || 
											(isset($_SESSION['Deity_Donation'])) || 
											(isset($_SESSION['Deity_Kanike'])) || 
											(isset($_SESSION['Event_Seva'])) || 
											(isset($_SESSION['Event_Donation/Kanike'])) || 
											(isset($_SESSION['Deity/Event_Hundi'])) || 
											(isset($_SESSION['Deity/Event_Inkind'])) && $_SESSION['trustLogin'] != "1") { ?>	
                                             <li><a data-toggle="tab" href="#RECPT">RECEIPT</a></li>
						      
								<?php }?>
								
				                <?php if((isset($_SESSION['Balance_Sheet'])) ||
							            (isset($_SESSION['Income_and_Expenditure'])) || 
										(isset($_SESSION['Receipts_and_Payments'])) || 
										(isset($_SESSION['Trial_Balance'])) || 
										(isset($_SESSION['Finance_Day_Book'])) ){ ?>
									<li><a data-toggle="tab" href="#REPT">REPORTS</a></li>
								<?php } ?>

								<?php if((isset($_SESSION['Add_Auction_Item'])) || 
								         (isset($_SESSION['Bid_Auction_Item'])) || 
										 (isset($_SESSION['Auction_Receipt'])) || 
										 (isset($_SESSION['Saree_Outward_Report'])) || 
										 (isset($_SESSION['Auction_Item_Report']))) { ?>
									<li><a data-toggle="tab" href="#AUC">AUCTION</a></li>
                                <?php }?>

								<?php if((isset($_SESSION['Postage']))) { ?>
									  <li><a data-toggle="tab" href="#POS">POSTAGE</a></li>
								<?php }?>

								<?php if((isset($_SESSION['Event_Postage'])) ) { ?>
									<li><a data-toggle="tab" href="#EVTPOS">EVENT POSTAGE</a></li>
                                <?php }?>

								<?php if((isset($_SESSION['Deity_EOD'])) || 
									         (isset($_SESSION['EOD_Tally']))) { ?>
									    <li><a data-toggle="tab" href="#EOD">DEITY E.O.D</a></li>
                                <?php }?>

								<?php if((isset($_SESSION['Event_EOD'])) || 
							                 (isset($_SESSION['Event_EOD_Tally']))) { ?>
									   <li><a data-toggle="tab" href="#EVENTEOD">EVENT E.O.D</a></li>
                                <?php }?>

								<?php if($_SESSION['trustLogin'] != "1") {
									   if($this->session->userdata('userGroup') == 1 || 
									      $this->session->userdata('userGroup') == 6 || 
									      $this->session->userdata('userGroup') == 4 || 
									      $this->session->userdata('userGroup') == 2) { ?>	

									<?php if(
										  (isset($_SESSION['Bank_Settings'])) || 
									      (isset($_SESSION['Financial_Month'])) || 
										  (isset($_SESSION['Deity_Seva_Settings'])) || 
										  (isset($_SESSION['Event_Seva_Settings'])) || 
										  (isset($_SESSION['Receipt_Settings'])) ||
										  (isset($_SESSION['Kanike_Settings'])) || 
										  (isset($_SESSION['Shashwath_Period_Settings'])) || 
										  (isset($_SESSION['Shashwath_Calendar_Settings'])) ||
										  (isset($_SESSION['Shashwath_Festival_Settings'])) || 
										  (isset($_SESSION['Time_Settings'])) || 
										  (isset($_SESSION['Group_Settings'])) || 
										  (isset($_SESSION['Users_Settings'])) || 
										  (isset($_SESSION['Deity_Special_Receipt_Price'])) || 
										  (isset($_SESSION['Import_Settings'])) || 
										  (isset($_SESSION['Auction_Settings']))
										  ) { ?>
                                           <li><a data-toggle="tab" href="#SET">SETTINGS</a></li>										
										<?php } ?>	
									<?php } ?>
								<?php }?>
		
							    <?php if((isset($_SESSION['Print_Event_Details'])) ||
							        (isset($_SESSION['Print_Event_Details'])) ||
									(isset($_SESSION['Inkind_Items'])) || 
									(isset($_SESSION['Cheque_Remmittance']))||
									(isset($_SESSION['Deity_Cheque_Remmittance'])) ||
									(isset($_SESSION['Change_Donation/Kanike'])) ||
									(isset($_SESSION['Back_Up']) )) { ?>
									<li><a data-toggle="tab" href="#OTH">OTHERS</a></li>	
							    <?php }?>

				                <?php if((isset($_SESSION['Finance_Receipts'])) || (isset($_SESSION['Finance_Payments'])) || 
				                 	(isset($_SESSION['Finance_Journal'])) || (isset($_SESSION['Finance_Contra'])) || 
				                 	(isset($_SESSION['Balance_Sheet'])) || (isset($_SESSION['Income_and_Expenditure'])) || 
				                 	(isset($_SESSION['Receipts_and_Payments'])) || (isset($_SESSION['Trial_Balance'])) || 
				                 	(isset($_SESSION['Finance_Add_Groups'])) || (isset($_SESSION['Finance_Add_Ledgers'])) || 
				                 	(isset($_SESSION['Finance_Add_Opening_Balance']))) { ?>
				                 	
									<li><a data-toggle="tab" href="#FIN">FINANCE</a></li>
			                    <?php }?>
					    </ul>
					
					<div class="tab-content">
						<?php  if((isset($_SESSION['Deity_Sevas']))) {  ?>	
							<div id="DS" class="tab-pane fade in active">
								<!--DEITY SEVAS-->
						     	<h6>DEITY SEVAS</h6>	
									<?php if((isset($_SESSION['Deity_Sevas']))) { ?>
										 <?php if(@$deitySevas == "Deity Sevas") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="deitySevas" name="deitySevas" checked>Deity Sevas
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="deitySevas" name="deitySevas">Deity Sevas
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="deitySevasId" name="deitySevasId" value="<?php echo $deitySevasId; ?>">
									<?php }?>
							</div>
						<?php }?>
<!-- ////////////////////////////////////////////////////ds end/////////////////////////////////////////// -->
						<?php if((isset($_SESSION['Shashwath_Seva'])) ||
							(isset($_SESSION['Shashwath_Loss_Report'])) ||
							(isset($_SESSION['Shashwath_New_Member'])) || 
							(isset($_SESSION['Shashwath_Member'])) || 
							(isset($_SESSION['Shashwath_Existing_Import']))) {?>
							   <div id="SH" class="tab-pane fade">
										<h6>SHASHWATH</h6>
                                    
										<!--DEITY SEVAS-->
								    <?php if((isset($_SESSION['Shashwath_Seva']))) { ?>
										<?php if(@$shashwathseva == "Shashwath Seva") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="shashwathseva" name="shashwathseva" checked>Shashwath Seva
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="shashwathseva" name="shashwathseva">Shashwath Seva
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="shashwathsevaId" name="shashwathsevaId" value="<?php echo $shashwathsevaId; ?>">
								    <?php }?>
     
								    <?php if((isset($_SESSION['Shashwath_Loss_Report']))) { ?> 
										<?php if(@$shashwathlossreport == "Shashwath Loss Report") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="shashwathlossreport" name="shashwathlossreport" checked>Shashwath Loss Report
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="shashwathlossreport" name="shashwathlossreport">Shashwath Loss Report
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="shashwathlossreportId" name="shashwathlossreportId" value="<?php echo $shashwathlossreportId; ?>">
								    <?php }?>
								     	
								    <?php if((isset($_SESSION['Shashwath_New_Member']))) { ?>
										<?php if(@$shashwathnewmember == "Shashwath New Member") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="shashwathnewmember" name="shashwathnewmember" checked>Shashwath New Member
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="shashwathnewmember" name="shashwathnewmember">Shashwath New Member
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="shashwathnewmemberId" name="shashwathnewmemberId" value="<?php echo $shashwathnewmemberId; ?>">
								    <?php }?>

									<?php if((isset($_SESSION['Shashwath_Member']))) { ?>
										<?php if(@$shashwathmember == "Shashwath Member") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="shashwathmember" name="shashwathmember" checked>Shashwath Member
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="shashwathmember" name="shashwathmember">Shashwath Member
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="shashwathmemberId" name="shashwathmemberId" value="<?php echo $shashwathmemberId; ?>">
								    <?php }?>
								     		<!---Shashwath Existing Import -->
								    <?php if((isset($_SESSION['Shashwath_Existing_Import']))) { ?>
										<?php if(@$shashwathexistingimport == "Shashwath Existing Import") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="shashwathexistingimport" name="shashwathexistingimport" checked>Shashwath Existing Import
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="shashwathexistingimport" name="shashwathexistingimport">Shashwath Existing Import
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="shashwathexistingimportId" name="shashwathexistingimportId" value="<?php echo $shashwathexistingimportId; ?>">
								    <?php }?>
							   </div>
						<?php }?>
                               
<!--/////////////////////////////////////////////////////SH END///////////////////////////////////////////  -->
                        <?php if((isset($_SESSION['Jeernodhara_Kanike'])) ||
					     	 (isset($_SESSION['Jeernodhara_Hundi']))||
					     	 (isset($_SESSION['Jeernodhara_Inkind']))||
					     	 (isset($_SESSION['Jeernodhara_Daily_Report']))) { ?> 
					     	<div id="JH" class="tab-pane fade">
						    <h6>JEERNODHARA</h6>		
										<!--DEITY SEVAS-->
							 <?php if((isset($_SESSION['Jeernodhara_Kanike']))) { ?>
										
										<?php if(@$jeernodharakanike == "Jeernodhara Kanike") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="jeernodharakanike" name="jeernodharakanike" checked>Jeernodhara Kanike
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="jeernodharakanike" name="jeernodharakanike">Jeernodhara Kanike
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="jeernodharakanikeId" name="jeernodharakanikeId" value="<?php echo $jeernodharakanikeId; ?>">
							 <?php }?>
    
							 <?php if((isset($_SESSION['Jeernodhara_Hundi']))) { ?>
										<?php if(@$jeernodharahundi == "Jeernodhara Hundi") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="jeernodharahundi" name="jeernodharahundi" checked>Jeernodhara Hundi
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="jeernodharahundi" name="jeernodharahundi">Jeernodhara Hundi
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="jeernodharahundiId" name="jeernodharahundiId" value="<?php echo $jeernodharahundiId; ?>">
							 <?php }?>
    
							 <?php if((isset($_SESSION['Jeernodhara_Inkind']))) { ?>
										<?php if(@$jeernodharainkind == "Jeernodhara Inkind") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="jeernodharainkind" name="jeernodharainkind" checked>Jeernodhara Inkind
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="jeernodharainkind" name="jeernodharainkind">Jeernodhara Inkind
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="jeernodharainkindId" name="jeernodharainkindId" value="<?php echo $jeernodharainkindId; ?>">
							 <?php }?>
    
							 <?php if((isset($_SESSION['Jeernodhara_Daily_Report']))) { ?>
										<?php if(@$jeernodharadailyreport == "Jeernodhara Daily Report") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="jeernodharadailyreport" name="jeernodharadailyreport" checked>Jeernodhara Daily Report
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="jeernodharadailyreport" name="jeernodharadailyreport">Jeernodhara Daily Report
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="jeernodharadailyreportId" name="jeernodharadailyreportId" value="<?php echo $jeernodharadailyreportId; ?>">
							 <?php }?>
					     	</div> 
					     <?php } ?>       
<!-- //////////////////////////////////////////////JH end //////////////////////////////////////////////////// -->
                         <?php if((isset($_SESSION['Deity_Token']))) {?>
                             <div id="DT" class="tab-pane fade">
							   <h6>DEITY TOKEN</h6>	
										<!--EVENT TOKEN-->
									<?php if((isset($_SESSION['Deity_Token'])) && $_SESSION['trustLogin'] != "1") { ?>
										
										<?php if(@$deityToken == "Deity Token") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="deityToken" name="deityToken" checked>Deity Token
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="deityToken" name="deityToken">Deity Token
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="deityTokenId" name="deityTokenId" value="<?php echo $deityTokenId; ?>">
									<?php }?>
						  	</div>
						  <?php }?>
<!-- ///////////////////////////////////////////// DT end ////////////////////////////////////////////////////// -->
                          <?php  if((isset($_SESSION['Event_Sevas'])) && $_SESSION['trustLogin'] != "1"){ ?>
                               <div id="ES" class="tab-pane fade">
										<h6>EVENT SEVAS</h6>
										<!--EVENT SEVAS-->
									<?php if((isset($_SESSION['Event_Sevas']))) { ?>
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
<!-- /////////////////////////////////////////////ES end /////////////////////////////////////////////////////// -->
                         <?php if((isset($_SESSION['Event_Token'])) && $_SESSION['trustLogin'] != "1") {?> 
                            <div id="ET" class="tab-pane fade">
										<h6>EVENT TOKEN</h6>
										<!--EVENT TOKEN-->
									<?php if((isset($_SESSION['Event_Token']))) { ?>
										<?php if(@$eventToken == "Event Token") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="eventToken" name="eventToken" checked>Event Token
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="eventToken" name="eventToken">Event Token
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="eventTokenId" name="eventTokenId" value="<?php echo $eventTokenId; ?>">
									<?php }?>
						    </div>
						<?php }?>
<!-- //////////////////////////////////////////////ET end/////////////////////////////////////////////////////// -->
                            <?php if((isset($_SESSION['Book_Seva'])) || 
							          (isset($_SESSION['All_Booked_Sevas'])) ||
									  (isset($_SESSION['Booked_Pending_Receipts']))) {?> 
                                <div id="BOOKING" class="tab-pane fade">
										<h6>BOOKING</h6>
										<!--BOOK SEVA-->
									<?php if((isset($_SESSION['Book_Seva']))) { ?>
										<?php if(@$bookSeva == "Book Seva") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="bookSeva" name="bookSeva" checked>Book Seva
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="bookSeva" name="bookSeva">Book Seva
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="bookSevaId" name="bookSevaId" value="<?php echo $bookSevaId; ?>">
									<?php }?>
 
									 	<!--ALL BOOKED SEVAS-->
									<?php if((isset($_SESSION['All_Booked_Sevas']))) { ?>
										<?php if(@$allBookedSevas == "All Booked Sevas") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="allBookedSevas" name="allBookedSevas" checked>All Booked Sevas
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="allBookedSevas" name="allBookedSevas">All Booked Sevas
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="allBookedSevasId" name="allBookedSevasId" value="<?php echo $allBookedSevasId; ?>">
                                    <?php }?>
									 	<!-- Suraksha -->
									 	<!--ALL BOOKED SEVAS-->
									<?php if((isset($_SESSION['Booked_Pending_Receipts']))) { ?>
										<?php if(@$bookedPendingReceipts == "Booked Pending Receipts") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="bookedPendingReceipts" name="bookedPendingReceipts" checked>Booked Pending Receipts
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="bookedPendingReceipts" name="bookedPendingReceipts">Booked Pending Receipts
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="bookedPendingReceiptsId" name="bookedPendingReceiptsId" value="<?php echo $bookedPendingReceiptsId; ?>">
									<?php }?>
				            	</div>
							<?php }?>
<!-- /////////////  ///////////////////////////////////BOOKING end/////////////////////////////////////////////// -->
                            <?php if((isset($_SESSION['All_Deity_Receipt']))||
							          (isset($_SESSION['All_Event_Receipt']))||
									  (isset($_SESSION['Deity_Seva'])) || 
									  (isset($_SESSION['Deity_Donation'])) ||
									  (isset($_SESSION['Deity_Kanike'])) ||
									  (isset($_SESSION['Event_Seva']))||
									   (isset($_SESSION['Event_Donation/Kanike']))||
									  (isset($_SESSION['Deity/Event_Hundi']))||
									   (isset($_SESSION['Deity/Event_Inkind']))||
									  (isset($_SESSION['SRNS_Fund'])) ) {?> 
                                 <div id="RECPT" class="tab-pane fade">
										<h6>RECEIPT</h6>
										<!--ALL DEITY RECEIPT-->
									<?php if((isset($_SESSION['All_Deity_Receipt']))) { ?>
										
										<?php if(@$allDeityReceipt == "All Deity Receipt") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="allDeityReceipt" name="allDeityReceipt" checked>All Deity Receipt
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="allDeityReceipt" name="allDeityReceipt">All Deity Receipt
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="allDeityReceiptId" name="allDeityReceiptId" value="<?php echo $allDeityReceiptId; ?>">
									<?php }?>
									    	<!--ALL EVENT RECEIPT-->
									<?php if((isset($_SESSION['All_Event_Receipt']))) { ?>
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
    
									    	<!--DEITY SEVA-->
									<?php if((isset($_SESSION['Deity_Seva']))) { ?>
										<?php if(@$deitySeva == "Deity Seva") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="deitySeva" name="deitySeva" checked>Deity Seva
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="deitySeva" name="deitySeva">Deity Seva
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="deitySevaId" name="deitySevaId" value="<?php echo $deitySevaId; ?>">
									<?php }?>
									    	<!--DEITY DONATION-->
									<?php if((isset($_SESSION['Deity_Donation']))) { ?>
										<?php if(@$deityDonation == "Deity Donation") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="deityDonation" name="deityDonation" checked>Deity Donation
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="deityDonation" name="deityDonation">Deity Donation
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="deityDonationId" name="deityDonationId" value="<?php echo $deityDonationId; ?>">
									<?php }?>
									    	<!--DEITY KANIKE-->
									<?php if((isset($_SESSION['Deity_Kanike']))) { ?>
										<?php if(@$deityKanike == "Deity Kanike") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="deityKanike" name="deityKanike" checked>Deity Kanike
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="deityKanike" name="deityKanike">Deity Kanike
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="deityKanikeId" name="deityKanikeId" value="<?php echo $deityKanikeId; ?>">
									<?php }?>
    
										<!--EVENT SEVA-->
									<?php if((isset($_SESSION['Event_Seva']))) { ?>
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
									<?php if((isset($_SESSION['Event_Donation/Kanike']))) { ?>
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
									<?php if((isset($_SESSION['Deity/Event_Hundi']))) { ?>
										<?php if(@$deityEventHundi == "Deity/Event Hundi") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="deityEventHundi" name="deityEventHundi" checked>Deity/Event Hundi
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="deityEventHundi" name="deityEventHundi">Deity/Event Hundi
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="deityEventHundiId" name="deityEventHundiId" value="<?php echo $deityEventHundiId; ?>">
									<?php }?>

										<!--DEITY/EVENT INKIND-->
									<?php if((isset($_SESSION['Deity/Event_Inkind']))) { ?>
										<?php if(@$deityEventInkind == "Deity/Event Inkind") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="deityEventInkind" name="deityEventInkind" checked>Deity/Event Inkind
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="deityEventInkind" name="deityEventInkind">Deity/Event Inkind
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="deityEventInkindId" name="deityEventInkindId" value="<?php echo $deityEventInkindId; ?>">
									<?php }?>

										<!--SRNS FUND-->
									<?php if((isset($_SESSION['SRNS_Fund']))) { ?>
										<?php if(@$srnsFund == "SRNS Fund") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="srnsFund" name="srnsFund" checked>S.R.N.S. Fund
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="srnsFund" name="srnsFund">S.R.N.S. Fund
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="srnsFundId" name="srnsFundId" value="<?php echo $srnsFundId; ?>">
									<?php }?>
								</div>
							<?php }?>
<!-- /////////////////////////////////////RECPT//////////////////////////////////////////////////////////// -->
                              <?php if((isset($_SESSION['Deity_Receipt_Report'])) ||
							          (isset($_SESSION['Deity_Seva_Report']))||
									   (isset($_SESSION['Deity_MIS_Report']))||
									   (isset($_SESSION['Deity_Seva_Summary']))||
									   (isset($_SESSION['Temple_Day_Book']))||
									   (isset($_SESSION['Temple_Inkind_Report']))||
									   (isset($_SESSION['Current_Event_Receipt_Report']))||
									   (isset($_SESSION['Current_Event_Seva_Report'])) ||
									   (isset($_SESSION['Current_Event_MIS_Report']))||
									   (isset($_SESSION['Event_Seva_Summary']))||
									   (isset($_SESSION['User_Event_Collection_Report']))) {?> 
                                 <div id="REPT" class="tab-pane fade">
										<h6>REPORT</h6>
										<!--DEITY RECEIPT REPORT-->
								    <?php if((isset($_SESSION['Deity_Receipt_Report']))) { ?>	
										<?php if(@$deityReceiptReport == "Deity Receipt Report") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="deityReceiptReport" name="deityReceiptReport" checked>Deity Receipt Report
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="deityReceiptReport" name="deityReceiptReport">Deity Receipt Report
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="deityReceiptReportId" name="deityReceiptReportId" value="<?php echo $deityReceiptReportId; ?>">
								    <?php }?>
								    		<!--DEITY SEVA REPORT-->
								    <?php if((isset($_SESSION['Deity_Seva_Report']))) { ?>
										<?php if(@$deitySevaReport == "Deity Seva Report") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="deitySevaReport" name="deitySevaReport" checked>Deity Seva Report
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="deitySevaReport" name="deitySevaReport">Deity Seva Report
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="deitySevaReportId" name="deitySevaReportId" value="<?php echo $deitySevaReportId; ?>">
								    <?php }?>
								    		<!--DEITY MIS REPORT-->
								    <?php if((isset($_SESSION['Deity_MIS_Report']))) { ?>	
										<?php if(@$deityMISReport == "Deity MIS Report") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="deityMISReport" name="deityMISReport" checked>Deity MIS Report
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="deityMISReport" name="deityMISReport">Deity MIS Report
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="deityMISReportId" name="deityMISReportId" value="<?php echo $deityMISReportId; ?>">
								    <?php }?>
								    		<!--DEITY SEVA SUMMARY-->
								    <?php if((isset($_SESSION['Deity_Seva_Summary']))) { ?>	
										<?php if(@$deitySevaSummary == "Deity Seva Summary") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="deitySevaSummary" name="deitySevaSummary" checked>Deity Seva Summary
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="deitySevaSummary" name="deitySevaSummary">Deity Seva Summary
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="deitySevaSummaryId" name="deitySevaSummaryId" value="<?php echo $deitySevaSummaryId; ?>">
                                    <?php }?>

											<!--DEITY SEVA SUMMARY-->
								    <?php if((isset($_SESSION['Temple_Day_Book']))) { ?>	
											<?php if(@$Temple_Day_Book == "Temple Day Book") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="Temple_Day_Book" name="Temple_Day_Book" checked>Day Book
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="Temple_Day_Book" name="Temple_Day_Book">Day Book
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="Temple_Day_Book_Id" name="Temple_Day_Book_Id" value="<?php echo $Temple_Day_Book_Id; ?>">
                                    <?php }?>
								    		<!--Temple Inkind Report-->
								    <?php if((isset($_SESSION['Temple_Inkind_Report']))) { ?>	
											<?php if(@$Temple_Inkind_Report == "Temple Inkind Report") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="Temple_Inkind_Report" name="Temple_Inkind_Report" checked>Temple Inkind Report
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="Temple_Inkind_Report" name="Temple_Inkind_Report">Temple Inkind Report
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="Temple_Inkind_Report_Id" name="Temple_Inkind_Report_Id" value="<?php echo $Temple_Inkind_Report_Id; ?>">
                                    <?php }?>
								    		<!--CURRENT EVENT RECEIPT REPORT-->
								    <?php if((isset($_SESSION['Current_Event_Receipt_Report']))) { ?>	
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
								    <?php if((isset($_SESSION['Current_Event_Seva_Report']))) { ?>
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
									   	<!--CURRENT EVENT MIS REPORT-->
								   <?php if((isset($_SESSION['Current_Event_MIS_Report']))) { ?>	
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
      
								   	   	<!-- EVENT SEVA SUMMARY -->
								   <?php if((isset($_SESSION['Event_Seva_Summary']))) { ?>	
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
   
								   		<!--USER EVENT COLLECTION REPORT-->
								   <?php if((isset($_SESSION['User_Event_Collection_Report']))) { ?>	
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
<!-- /////////////////////////////////// REPT //////////////////////////////////////////////////////////// -->
                               <?php if((isset($_SESSION['Add_Auction_Item'])) ||
							            (isset($_SESSION['Bid_Auction_Item'])) ||
										(isset($_SESSION['Auction_Receipt'])) ||
										(isset($_SESSION['Saree_Outward_Report']))||
										(isset($_SESSION['Auction_Item_Report']))) { ?>
                                 <div id="AUC" class="tab-pane fade">
										<h6>AUCTION</h6>
										<!--ADD AUCTION ITEM-->
								     <?php if((isset($_SESSION['Add_Auction_Item']))) { ?>	
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
								     <?php if((isset($_SESSION['Bid_Auction_Item']))) { ?>
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
								     <?php if((isset($_SESSION['Auction_Receipt']))) { ?>	
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
								    <?php if((isset($_SESSION['Saree_Outward_Report']))) { ?>	
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
								    <?php if((isset($_SESSION['Auction_Item_Report']))) { ?>	
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

<!-- ///////////////////////////////////// AUC ////////////////////////////////////////////////////////// -->
                               <?php if((isset($_SESSION['Postage'])) || 
							            (isset($_SESSION['Dispatch_Collection']) ) ||
										(isset($_SESSION['All_Postage_Collection']) )||
										(isset($_SESSION['Postage_Group']))  ) {?> 
                                 <div id="POS" class="tab-pane fade">
										<h6>POSTAGE</h6>
										<!--POSTAGE-->
								    <?php if((isset($_SESSION['Postage']))) { ?>
									
										<?php if(@$postage == "Postage") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="postage" name="postage" checked>Postage
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="postage" name="postage">Postage
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="postageId" name="postageId" value="<?php echo $postageId; ?>">
								    <?php }?>
									    	<!--DISPATCH COLLECTION-->
								    <?php if((isset($_SESSION['Dispatch_Collection']))) { ?>
										<?php if(@$dispatchCollection == "Dispatch Collection") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="dispatchCollection" name="dispatchCollection" checked>Dispatch Pending
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="dispatchCollection" name="dispatchCollection">Dispatch Pending
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="dispatchCollectionId" name="dispatchCollectionId" value="<?php echo $dispatchCollectionId; ?>">
								    <?php }?>
									    	<!--ALL POSTAGE COLLECTION-->
								    <?php if((isset($_SESSION['All_Postage_Collection']))) { ?>
										<?php if(@$allPostageCollection == "All Postage Collection") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="allPostageCollection" name="allPostageCollection" checked>All Postage Collection
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="allPostageCollection" name="allPostageCollection">All Postage Collection
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="allPostageCollectionId" name="allPostageCollectionId" value="<?php echo $allPostageCollectionId; ?>">
                                    <?php }?>
									    	<!--POSTAGE GROUP-->
								    <?php if((isset($_SESSION['Postage_Group']))) { ?>	
										<?php if(@$postageGroup == "Postage Group") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="postageGroup" name="postageGroup" checked>Postage Group
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="postageGroup" name="postageGroup">Postage Group
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="postageGroupId" name="postageGroupId" value="<?php echo $postageGroupId; ?>">
								    <?php }?>
							    </div>
							   <?php }?>
<!--//////////////////////////////////// POS ////////////////////////////////////////////////////////////  -->
                               <?php if((isset($_SESSION['Event_Postage'])) || 
							             (isset($_SESSION['Event_Dispatch_Collection']))||
										 (isset($_SESSION['All_Event_Postage_Collection']))||
										 (isset($_SESSION['SLVT_Event_Postage_Group']))) {?> 
                                 <div id="EVTPOS" class="tab-pane fade">
									<h6>EVENT POSTAGE</h6>	
									<?php if((isset($_SESSION['Event_Postage'])) && $_SESSION['trustLogin'] != "1") { ?>
										
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
									<?php if((isset($_SESSION['Event_Dispatch_Collection'])) &&  $_SESSION['trustLogin'] != "1" ) { ?>	
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
									<?php if((isset($_SESSION['All_Event_Postage_Collection']))&&  $_SESSION['trustLogin'] != "1" ) { ?>	
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
									<?php if((isset($_SESSION['SLVT_Event_Postage_Group']))&&  $_SESSION['trustLogin'] != "1") { ?>
										<?php if(@$slvtEvtPostageGroup == "Event Postage Group") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="slvtEvtPostageGroup" name="slvtEvtPostageGroup" checked>Event Postage Group
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="slvtEvtPostageGroup" name="slvtEvtPostageGroup">Event Postage Group
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="slvtEvtPostageGroupId" name="slvtEvtPostageGroupId" value="<?php echo $slvtEvtPostageGroupId; ?>">
									<?php }?>
							    </div>
                              <?php }?>
<!-- /////////////////////////////////// EVTPOS ///////////////////////////////////////////////////////// -->
                             <?php  if((isset($_SESSION['Deity_EOD'])) || (isset($_SESSION['EOD_Tally']))){ ?>
                                <div id="EOD" class="tab-pane fade">
									<h6>DEITY E.O.D</h6>	
										<!--DEITY E.O.D-->
									<?php if((isset($_SESSION['Deity_EOD']))) {?>
										
										<?php if(@$deityEOD == "Deity E.O.D") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="deityEOD" name="deityEOD" checked>Deity E.O.D
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="deityEOD" name="deityEOD">Deity E.O.D
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="deityEODId" name="deityEODId" value="<?php echo $deityEODId; ?>">
									<?php }?>

										<!--E.O.D Tally-->
									<?php if((isset($_SESSION['EOD_Tally']))) { ?>
										<?php if(@$EODTally == "E.O.D Tally") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="EODTally" name="EODTally" checked>E.O.D. Tally
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="EODTally" name="EODTally">E.O.D. Tally
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="EODTallyId" name="EODTallyId" value="<?php echo $EODTallyId; ?>">
									<?php }?>
					            </div>
                             <?php }?>
<!-- //////////////////////////////////////////// EOD ////////////////////////////////////////////////// -->
                            <?php if((isset($_SESSION['Event_EOD'])) || 
							         (isset($_SESSION['Event_EOD_Tally'])) ) {?> 
                                <div id="EVENTEOD" class="tab-pane fade">
										<!--EVENT E.O.D-->
										<h6>EVENT E.O.D</h6>
									<?php if((isset($_SESSION['Event_EOD']))) {?>
										
										<?php if(@$eventEOD == "Event E.O.D") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="eventEOD" name="eventEOD" checked>Event E.O.D
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="eventEOD" name="eventEOD">Event E.O.D
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="eventEODId" name="eventEODId" value="<?php echo $eventEODId; ?>">
                                    <?php }?>
									   	<!--E.O.D Tally-->
									<?php if((isset($_SESSION['Event_EOD_Tally']))) { ?>	
										<?php if(@$eventEODTally == "Event E.O.D Tally") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="eventEODTally" name="eventEODTally" checked>E.O.D. Tally
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="eventEODTally" name="eventEODTally">E.O.D. Tally
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="eventEODTallyId" name="eventEODTallyId" value="<?php echo $eventEODTallyId; ?>">
                                    <?php }?>
						        </div>
                            <?php }?>
<!-- ///////////////////////////////////////// EVENTeod//////////////////////////////////////////////////// -->
                            <?php if((isset($_SESSION['Deity_Seva_Settings']))|| 
							         (isset($_SESSION['Event_Seva_Settings'])) ||
									  (isset($_SESSION['Shashwath_Period_Settings'])) || 
									  (isset($_SESSION['Shashwath_Calendar_Settings'])) || 
									  (isset($_SESSION['Shashwath_Festival_Settings'])) ||
									  (isset($_SESSION['Receipt_Settings'])) || 
									  (isset($_SESSION['Finance_Prerequisites'])) || 
									  (isset($_SESSION['Voucher_Counter'])) || 
									  (isset($_SESSION['Bank_Cheque_Configuration'])) ||
									   (isset($_SESSION['Kanike_Settings'])) || 
									  (isset($_SESSION['Time_Settings'])) ||
									   (isset($_SESSION['Group_Settings'])) ||
									   (isset($_SESSION['Users_Settings'])) || 
									   (isset($_SESSION['Import_Settings'])) || 
									   (isset($_SESSION['Auction_Settings'])) ||
									  (isset($_SESSION['Deity_Special_Receipt_Price']))||
									   (isset($_SESSION['Financial_Month'])) ||
									   (isset($_SESSION['Bank_Settings']))) {?> 
                                <div id="SET" class="tab-pane fade">
						            <h6>SETTINGS</h6>
									<!--DEITY SEVA SETTINGS-->
                                    <?php if((isset($_SESSION['Deity_Seva_Settings']))) { ?> 
										
											<?php if(@$deitySevaSettings == "Deity Seva Settings") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="deitySevaSettings" name="deitySevaSettings" checked>Deity Seva Settings
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="deitySevaSettings" name="deitySevaSettings">Deity Seva Settings
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="deitySevaSettingsId" name="deitySevaSettingsId" value="<?php echo $deitySevaSettingsId; ?>">
										
									<?php } ?>
	
									<!--EVENT SEVA SETTINGS-->
									<?php if((isset($_SESSION['Event_Seva_Settings']))) { ?>
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
										
									<?php } ?>

                                    <?php if((isset($_SESSION['Shashwath_Period_Settings']))) {?> 
										 <?php if(@$shashwathperiodsettings == "Shashwath Period Settings") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="shashwathperiodsettings" name="shashwathperiodsettings" checked>Shashwath Period Settings
											</label>
										 <?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="shashwathperiodsettings" name="shashwathperiodsettings">Shashwath Period Settings
											</label>
										 <?php } ?>
										 <!--HIDDEN FIELDS-->
										 <input type="hidden" id="shashwathperiodsettingsId" name="shashwathperiodsettingsId" value="<?php echo @$shashwathperiodsettingsId; ?>">
												
										
									<?php }?>
											
									<?php if((isset($_SESSION['Shashwath_Calendar_Settings']))) {?> 
										<?php if(@$shashwathcalendarsettings == "Shashwath Calendar Settings") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="shashwathcalendarsettings" name="shashwathcalendarsettings" checked>Shashwath Calendar Settings
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="shashwathcalendarsettings" name="shashwathcalendarsettings">Shashwath Calendar Settings
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="shashwathcalendarsettingsId" name="shashwathcalendarsettingsId" value="<?php echo @$shashwathcalendarsettingsId; ?>">

									<?php }?>

									<?php if((isset($_SESSION['Shashwath_Festival_Settings']))) {?>
									   <!-- Shashwath Festival Settings Suraksha -->
											<?php if(@$shashwathfestivalsettings == "Shashwath Festival Settings") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="shashwathfestivalsettings" name="shashwathfestivalsettings" checked>Shashwath Festival Settings
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="shashwathfestivalsettings" name="shashwathfestivalsettings">Shashwath Festival Settings
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="shashwathfestivalsettingsId" name="shashwathfestivalsettingsId" value="<?php echo @$shashwathfestivalsettingsId; ?>">

										<!-- Shashwath Festival Settings Suraksha -->
									<?php }?>	

									<?php if((isset($_SESSION['Receipt_Settings']))) {?>
									    <!--RECEIPT SETTINGS-->
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

									<!-- Finance Prerequisites-->
									<?php if((isset($_SESSION['Finance_Prerequisites']))) {?>
									     <!-- Suraksha -->
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
									<?php if((isset($_SESSION['Voucher_Counter']))) {?>
									  <!-- Suraksha -->
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
									<?php if((isset($_SESSION['Bank_Cheque_Configuration']))) {?>
									    <!-- Suraksha -->
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
										
									<?php } ?>

									<!-- KANIKE SETTINGS  -->
									<?php if((isset($_SESSION['Kanike_Settings']))) {?>
								        <!-- Suraksha -->
										<?php if(@$kanikeSettings == "Kanike Settings") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="kanikeSettings" name="kanikeSettings" checked>Kanike Settings
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="kanikeSettings" name="kanikeSettings">Kanike Settings
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="kanikeSettingsId" name="kanikeSettingsId" value="<?php echo $kanikeSettingsId; ?>">

									<?php }?>

									<!--TIME SETTINGS-->
									<?php if((isset($_SESSION['Time_Settings']))) { ?>
										<?php if(@$timeSettings == "Time Settings") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="timeSettings" name="timeSettings" checked>Time Settings
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="timeSettings" name="timeSettings">Time Settings
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="timeSettingsId" name="timeSettingsId" value="<?php echo $timeSettingsId; ?>">
									<?php }?>

									<?php if((isset($_SESSION['Group_Settings']))) { ?>
										<!--GROUP SETTINGS-->
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

									<!--USERS SETTINGS-->
									<?php if((isset($_SESSION['Users_Settings']))) { ?>
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

									<!--IMPORT SETTINGS-->
									<?php if((isset($_SESSION['Import_Settings']))) { ?>	
										<?php if(@$importSettings == "Import Settings") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="importSettings" name="importSettings" checked>Import Settings
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="importSettings" name="importSettings">Import Settings
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="importSettingsId" name="importSettingsId" value="<?php echo $importSettingsId; ?>">
									<?php }?>

									<!--AUCTION SETTINGS-->
									<?php if((isset($_SESSION['Auction_Settings']))) { ?>	
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

									<!--DEITY SPECIAL RECEIPT PRICE SETTINGS-->
									<?php if((isset($_SESSION['Deity_Special_Receipt_Price']))) { ?>	
										<?php if(@$deitySplRecpPrice == "Deity Special Receipt Price") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="deitySplRecpPrice" name="deitySplRecpPrice" checked>Deity Special Receipt Price
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="deitySplRecpPrice" name="deitySplRecpPrice">Deity Special Receipt Price
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="deitySplRecpPriceId" name="deitySplRecpPriceId" value="<?php echo $deitySplRecpPriceId; ?>">
									<?php }?>

									<!--FINANCIAL MONTH SETTINGS-->
									<?php if((isset($_SESSION['Financial_Month']))) { ?>	
										<?php if(@$financialMonthSettings == "Financial Month Settings") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="financialMonthSettings" name="financialMonthSettings" checked>Financial Month Settings
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="financialMonthSettings" name="financialMonthSettings">Financial Month Settings
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="financialMonthSettingsId" name="financialMonthSettingsId" value="<?php echo $financialMonthSettingsId; ?>">
									<?php }?>

										<!--BANK SETTINGS-->
									<?php if((isset($_SESSION['Bank_Settings']))) { ?>
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

						        </div>
                            <?php }?>
                            <?php if((isset($_SESSION['Print_Deity_Details'])) ||
							          (isset($_SESSION['Print_Event_Details'])) ||
									  (isset($_SESSION['Inkind_Items'])) ||
									  (isset($_SESSION['Cheque_Remmittance'])) ||
									  (isset($_SESSION['Deity_Cheque_Remmittance'])) ||
									  (isset($_SESSION['Change_Donation/Kanike'])) ||
									  (isset($_SESSION['Back_Up'])) 
									  ) {?> 
						        <div id="OTH" class="tab-pane fade">
								    <h6>OTHERS</h6>
										<!--PRINT DEITY DETAILS-->
									<?php if((isset($_SESSION['Print_Deity_Details']))) { ?>	
										<?php if(@$printDeityDetails == "Print Deity Details") { ?>
											
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="printDeityDetails" name="printDeityDetails" checked>Print Deity Details
											</label>
										 <?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="printDeityDetails" name="printDeityDetails">Print Deity Details
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="printDeityDetailsId" name="printDeityDetailsId" value="<?php echo $printDeityDetailsId; ?>">
									<?php }?>
										<!--PRINT EVENT DETAILS-->
									<?php if((isset($_SESSION['Print_Event_Details']))) { ?>	
										<?php if(@$printEventDetails == "Print Event Details") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="printEventDetails" name="printEventDetails" checked>Print Event Details
											</label>
										 <?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="printEventDetails" name="printEventDetails">Print Event Details
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="printEventDetailsId" name="printEventDetailsId" value="<?php echo $printEventDetailsId; ?>">
									<?php }?>
										<!--INKIND ITEMS-->
									<?php if((isset($_SESSION['Inkind_Items']))) { ?>	
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
									<?php if((isset($_SESSION['Cheque_Remmittance']))) { ?>	
										<?php if(@$chequeRemmittance == "Cheque Remmittance") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="chequeRemmittance" name="chequeRemmittance" checked>Event Cheque Remmittance
											</label>
										 <?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="chequeRemmittance" name="chequeRemmittance">Event Cheque Remmittance
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="chequeRemmittanceId" name="chequeRemmittanceId" value="<?php echo $chequeRemmittanceId; ?>">
									<?php }?>
										<!--DEITY CHEQUE REMMITTANCE-->
									<?php if((isset($_SESSION['Deity_Cheque_Remmittance']))) { ?>	
										<?php if(@$deityChequeRemmittance == "Deity Cheque Remmittance") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="deityChequeRemmittance" name="deityChequeRemmittance" checked>Deity Cheque Remmittance
											</label>
										 <?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="deityChequeRemmittance" name="deityChequeRemmittance">Deity Cheque Remmittance
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="deityChequeRemmittanceId" name="deityChequeRemmittanceId" value="<?php echo $deityChequeRemmittanceId; ?>">
									<?php }?>
										<!--CHANGE DONATION/KANIKE-->
									<?php if((isset($_SESSION['Change_Donation/Kanike']))) { ?>	
										<?php if(@$changeDonation == "Change Donation/Kanike") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="changeDonation" name="changeDonation" checked>Change Donation/Kanike
											</label>
										 <?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="changeDonation" name="changeDonation">Change Donation/Kanike
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="changeDonationId" name="changeDonationId" value="<?php echo $changeDonationId; ?>">
									<?php }?>
										<!--BACKUP-->
									<?php if((isset($_SESSION['Back_Up']))) { ?>	
										<?php if(@$backUp == "Back Up") { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="backUp" name="backUp" checked>Back Up
											</label>
										<?php } else { ?>
											<label class="checkbox-inline" style="font-weight:bold;margin-right:5px;">
												<input type="checkbox" id="backUp" name="backUp">Back Up
											</label>
										<?php } ?>
										<!--HIDDEN FIELDS-->
										<input type="hidden" id="backUpId" name="backUpId" value="<?php echo $backUpId; ?>">
						            <?php }?>
								</div>
							<?php }?>
                            <?php  if((isset($_SESSION['Finance_Receipts'])) || 
							          (isset($_SESSION['Finance_Payments']))||
									   (isset($_SESSION['Finance_Journal'])) ||
									   (isset($_SESSION['Finance_Contra'])) ||
									    (isset($_SESSION['Balance_Sheet'])) ||
										(isset($_SESSION['Income_and_Expenditure']))||
										(isset($_SESSION['Receipts_and_Payments'])) ||
										(isset($_SESSION['Trial_Balance'])) || 
										(isset($_SESSION['Finance_Day_Book'])) || 
										(isset($_SESSION['Finance_Add_Groups'])) ||
										(isset($_SESSION['Finance_Add_Ledgers'])) ||
										(isset($_SESSION['Finance_Add_Opening_Balance'])) ||
										(isset($_SESSION['All_Ledgers_and_Groups']))) {?> 
						          <div id="FIN" class="tab-pane fade">
										<h6>FINANCE</h6>
										<!--PRINT Finance Receipts DETAILS-->
									<?php if(isset($_SESSION['Finance_Receipts'])) { ?>
										
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
									<?php if(isset($_SESSION['Finance_Payments'])) { ?>	
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
									<?php if(isset($_SESSION['Finance_Journal'])) { ?>
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
									<?php if(isset($_SESSION['Finance_Contra'])) { ?>
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
									<?php if((isset($_SESSION['Balance_Sheet']))) {?>
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
									<?php if(isset($_SESSION['Income_and_Expenditure'])) { ?>	
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
									<?php if(isset($_SESSION['Receipts_and_Payments'])) { ?>	
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
									<?php if(isset($_SESSION['Trial_Balance'])) { ?>
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
									<?php if(isset($_SESSION['Finance_Day_Book'])) { ?>
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
									<?php if(isset($_SESSION['Finance_Add_Groups'])) { ?>
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
									<?php if(isset($_SESSION['Finance_Add_Ledgers'])) { ?>	
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
									<?php if(isset($_SESSION['Finance_Add_Opening_Balance'])) { ?>
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
									<?php if(isset($_SESSION['All_Ledgers_and_Groups'])) { ?>
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
						          </div>
							<?php }?>

		</div>
<!-- ///////////////////////////////////////// set ///////////////////////////////////////////////////////// -->
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
								<button type="button" class="btn btn-default btn-md" onclick="golist('admin_settings/Admin_setting/groups_setting');"><strong>CANCEL</strong></button>
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