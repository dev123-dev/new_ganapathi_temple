<style type="text/css">
.ifsc{
   text-transform:uppercase;
}
</style>
<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
<div class="container-fluid container">
    <div class="row form-group">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-8" >               
            <h3><span class="icon icone-crop"></span>Edit Ledger</h3> 
        </div>
       <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4" style = "padding-top:10px;">
            <a style="text-decoration:none;cursor:pointer;pull-right;" title="Back" href="<?=site_url() ?>finance/allGroupLedgerDetails"><img style="width:24px; height:24px; margin-left: 13em;" title="Go back"  src="<?=site_url();?>images/back_icon.svg"/></a>
        </div>
    </div>
</div> 

<div id="addLedgerDiv" style="">
    <div class="container py-5" >
        <form id="frmEditLedger" action="<?=site_url()?>finance/updateLedger" method="post">
        <div class="row form-group">
            <div class="control-group col-md-2 col-lg-2 col-sm-4 col-xs-6">               
                    <label>Ledger Name: <span style="color:#800000;" >*</span></label>                     
            </div>
             <div class="control-group col-md-4 col-lg-2 col-sm-4 col-xs-6">               
                     <input style="height:30px; width: 320px;"  class="form-control"  type="text" name="nameL" placeholder="Ledger Name" id="nameL" onkeyup="alphaonlypurpose(this)" autocomplete="off" value="<?php echo $LEDGER_NAME ?>">
                     <input class="form-control"  type="hidden" name="editLedgerId" id="editLedgerId" value="<?php echo $LEDGER_ID ?>">
            </div> 
        </div>
        <div class="row form-group">
            <div class="control-group col-md-4 col-lg-2 col-sm-4 col-xs-6">
                <label>Under: <span style="color:#800000;">*</span></label>
            </div>
            <div class="control-group col-md-4 col-lg-2 col-sm-4 col-xs-6">
               <input type="text"  name="under" id="under" class="form-control"  style="width:100%;"  id="under" autocomplete="off" value="<?php echo $parentDetails[0]->FGLH_NAME;?>" readonly>
               <input type="hidden" name="underId" id="underId" value="<?php echo $parentDetails[0]->FGLH_ID;?>">
            </div>
             <div class="control-group col-md-4 col-lg-2 col-sm-4 col-xs-6" id="combo" style="margin-left: 10.9em;">
                 <label style="margin-left: 4.5em; margin-top: 5px;">Assign Ledger: <span style="color:#800000;">*</span></label> 
            </div>
             <div class="control-group col-md-4 col-lg-1 col-sm-4 col-xs-6" id="combo2" >
             <select id="ledgers" name="ledgers" class="form-control" style="width:190px;">
                      <option value="">Select Ledger</option>
                  </select> 
            </div>
              <div class="control-group col-md-4 col-lg-1 col-sm-4 col-xs-6" id="addicon" style="margin-left:4.7em;">
                <a onClick="addRow()">
                        <img style="width:24px; height:24px " class="img-responsive pull-right" title="Add Seva" src="<?=site_url();?>images/add.svg">
                </a>
            </div>
            </div>
               <div class="row form-group">
                 <div class="control-group col-md-4 col-lg-2 col-sm-4 col-xs-6" style="width: 220px;">
                      <label>Does this belong to Fd?</label>  
                 </div>

                 <div class="control-group col-md-4 col-lg-2 col-sm-4 col-xs-6" style="margin-left: -1.6em;">
             
                 
                <?php if($IS_FD_STATUS == 1) { ?> 
                     <input type="checkbox" id="fdyes" name="fdyes" class="fdyes" value="<?php echo $IS_FD_STATUS ?>" onclick
                     ="showfddiv();"  checked/> Yes</center>

                <?php } else {?>
                    <input type="checkbox" id="fdyes" name="fdyes" class="fdyes" value="<?php echo $IS_FD_STATUS ?>" onclick
                     ="showfddiv();"/> Yes</center>
                <?php } ?>
                 </div>
              <input type="hidden" name="fdyesId" id="fdyesId" value="<?php echo $ledgerDetails[0]->IS_FD_STATUS;?>">
              
            </div>
            <!-- new FD NAME and Bank Name Section start -->
           
    <div class="row form-group" id="fdNameDiv" style="display: none;">

             <div class="control-group col-md-2 col-lg-2 col-sm-2 col-xs-6">               
                <label>FD Number: <span style="color:#800000;" >*</span></label>
             </div>
             <div class="control-group col-md-4 col-lg-2 col-sm-4 col-xs-6"> 
                <?php if($ledgerDetails[0]->FD_NUMBER) {?>
               <input autocomplete="off" type="hidden" id="baseurl"  name="baseurl" id="FDNumber" value="<?php echo $ledgerDetails[0]->FD_NUMBER; ?>" /> 
               <?php } else {?>
                <input autocomplete="off" type="hidden" id="baseurl"  name="baseurl" id="FDNumber" value="" /> 
                <?php }?>
               <input autocomplete="off" style="height:30px; "  class="form-control"  type="text" name="FDNumber" placeholder="FD Number" id="FDNumber" value="<?php echo $ledgerDetails[0]->FD_NUMBER; ?>">
             </div>  
             </div>

          <div class="row form-group" id="fdBankName" style="display: none;">
          
                  <div class="control-group col-md-2 col-lg-2 col-sm-2 col-xs-6">
                     <label>FD Bank Name: <span style="color:#800000;" >*</span>
                     </label>
                  </div>
          
                  <select id="Bank" name="Bank" class="form-control" style="height: 30px; width: 200px; margin-left:18%">
                            <option value="" style="width: 300px;">Select Bank</option>
                            <?php if(!empty($bank)) {
                                foreach($bank as $row1) { 
                                    if($ledgerDetails[0]->FD_BANK_ID == $row1->FGLH_ID){ 
                                        $FD_BANK_NAME = $row1->FGLH_NAME; ?> 
                                       <option value="<?php echo $row1->FGLH_ID;?>|<?php echo $row1->FGLH_NAME;?>" selected><?php echo $FD_BANK_NAME; ?></option>
                                <?php } else { ?> 
                                <option value="<?php echo $row1->FGLH_ID;?>|<?php echo $row1->FGLH_NAME;?>"><?php echo $row1->FGLH_NAME;?></option>                                <?php } } } ?>

                  </select>
          </div>

<!-- new FD NAME and Bank name section End  -->
            <div class="row form-group" id="fddive" style="display: none;">

            <div class="control-group col-md-2 col-lg-2 col-sm-4 col-xs-6">               
                    <label>FD Start Date: <span style="color:#800000;" >*</span></label>    
            </div>
            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-6" id="opDate">              
                  <div class="input-group input-group-sm col-lg-2" style="width: 120px;">
                  <input type="hidden" name="date" value="<?=@$date; ?>" id="date" value="" >
                  <input type="hidden" name="load" id="load" value="">
                  <input autocomplete="" name= "todayDate3" id="todayDate3" type="text" value="<?php echo $ledgerDetails[0]->FD_MATURITY_START_DATE;?>" class="form-control fdstartDate" onchange="GetDataOnDate(this.value)" placeholder="dd-mm-yyyy" readonly = "readonly" />
                <div class="input-group-btn">
                    <button class="btn btn-default todayDate3" type="button">
                        <i class="glyphicon glyphicon-calendar"></i>
                    </button>
                </div>
            </div>
            </div>

           
        </div>
        <div class="row form-group" id="fddiv" style="display: none;">

            <div class="control-group col-md-2 col-lg-2 col-sm-4 col-xs-6">               
                    <label>FD Maturity Date: <span style="color:#800000;" >*</span></label>     
            </div>

            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-6" id="opDate">              
                  <div class="input-group input-group-sm col-lg-2" style="width: 120px;">
                  <input type="hidden" name="date" value="<?=@$date; ?>" id="date" value="" >
                  <input type="hidden" name="load" id="load" value="">
                  <input autocomplete="" name= "todayDate1" id="todayDate1" type="text" value="<?php echo $ledgerDetails[0]->FD_MATURITY_END_DATE;?>" class="form-control fdendDate" onchange="GetDataOnDate(this.value)" placeholder="dd-mm-yyyy" readonly = "readonly" />
                <div class="input-group-btn">
                    <button class="btn btn-default todayDate1" type="button">
                        <i class="glyphicon glyphicon-calendar"></i>
                    </button>
                </div>
            </div>

        </div>
                
           
        </div>

          <div class="row form-group" id="fdinterestrate" style="display: none;">

            <div class="control-group col-md-2 col-lg-2 col-sm-4 col-xs-6">               
                    <label>FD Intrest Rate: <span style="color:#800000;" >*</span></label>
                     
            </div>
           <div class="control-group col-md-4 col-lg-2 col-sm-4 col-xs-6"> 
             <input autocomplete="off" type="hidden" id="baseurl" name="baseurl" value="<?php echo site_url(); ?>" /> 
                          
                    <input autocomplete="off" style="height:30px; "  class="form-control"  type="text" name="intrestrate" placeholder="Intrest Rate" id="intrestrate" value="<?php echo $ledgerDetails[0]->FD_INTEREST_RATE;?>">
                   
            </div>
                
           
        </div>
        <!-- abhipra -->
        <div class="row form-group">
            <div class="control-group col-md-4 col-lg-2 col-sm-4 col-xs-6" style="width: 220px;">
                  <label>Does this belong to Jounal?</label>  
            </div>
            <div class="control-group col-md-4 col-lg-2 col-sm-4 col-xs-6" style="margin-left: -1.6em;">
                <?php if($IS_JOURNAL_STATUS == 1) { ?> 
                    <input type="checkbox" id="jouranalyes" name="jouranalyes" class="jouranalyes" value="<?php echo $IS_JOURNAL_STATUS ?>" checked/> Yes</center>
                <?php } else {?>
                    <input type="checkbox" id="jouranalyes" name="jouranalyes" class="jouranalyes" value="<?php echo $IS_JOURNAL_STATUS ?>" /> Yes</center>
                <?php } ?>
            </div>
        </div>

        <div class="row form-group" id="terminal" style="display:none;">
             <div class="control-group col-md-4 col-lg-2 col-sm-4 col-xs-6" style="width: 220px;">
                  <label>Is Terminal?</label>  
             </div>
             <div class="control-group col-md-4 col-lg-2 col-sm-4 col-xs-6" style="margin-left: -1.6em;">
                 <?php if($IS_TERMINAL == 1) { ?> 
                    <input type="checkbox" id="terminalyes" name="terminalyes" class="terminalyes" value="<?php echo $IS_TERMINAL ?>" checked /> Yes</center>
                <?php } else {?>
                    <input type="checkbox" id="terminalyes" name="terminalyes" class="terminalyes" value="<?php echo $IS_TERMINAL ?>" /> Yes</center>
                <?php } ?>  
             </div>
        </div>
        <!-- abhipra ends-->

            <!-- NEW CODE START-->
            <div id="committeeContainer" style="display: none;">
            <div class="row form-group" >
                <div class="control-group col-md-3 col-lg-2 col-sm-4 col-xs-6">
                    <label>Committee it belongs to: <span style="color:#800000;">*</span></label>
                </div>
                <div class="control-group col-md-3 col-lg-2 col-sm-4 col-xs-6">
                    <select id="Committee" name="Committee" class="form-control" style=""><!-- height: 30px; width: 200px; -->
                            <option value="" style="width: 300px;">Select Committee</option>
                            <?php   if(!empty($committee)) {
                                foreach($committee as $row1) { ?> 
                                    <option value="<?php echo $row1->COMP_ID;?>"><?php echo $row1->COMP_NAME;?></option>
                                <?php } } ?>
                    </select>
                </div>
                <!-- <div class="control-group col-lg-2 col-md-2 col-sm-12 col-xs-6">
                   <input style="width:147px;margin-left: -23px;" type="number" class="form-control" name="committeeOpAmt" id="committeeOpAmt" placeholder="Opening Balance" autocomplete="off" min="0">
                   <a onClick="addRow1()"> <img style="width:24px; height:24px ;margin-top: -28px; margin-left: -70px; " class="img-responsive pull-right" title="Add Committee" src="<?=site_url();?>images/add.svg"> </a>
                </div> -->
                <div class="control-group col-lg-1 col-md-1 col-sm-1 col-xs-6 " id="OpeningBal" style="display : none">
                   <input style="width:150px; margin-left: -23px;" type="number" class="form-control" name="committeeOpAmt" id="committeeOpAmt" placeholder="Opening Balance" autocomplete="off" min="0" value="">
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 " style="margin-left : 55px" >
                <a onClick="addRow1()"> <img style=" width:24px; height:24px ;margin-top: 5px;" class="img-responsive " title="Add Committee" src="<?=site_url();?>images/add.svg"> </a>
                </div>
            </div>
            <div class="row form-group">
                <div class="table-responsive col-lg-6 col-md-2 col-sm-12 col-xs-6">              
                <table id="addCommittee" class="table table-bordered table-hover">
                            <thead>
                              <tr>
                                <th style="width: 1%">SI.NO</th>
                                <th style="width: 10%" id="committeeName" name="committeeName">Committee Name</th>
                                <th style="width: 10%">OP Bal</th>
                                <th style="width: 1%">Operation</th>
                            </tr>
                            </thead>
                            <tbody id="committeeUpdate">
                            <?php  $si = 1;
                            foreach($assignedComp as $result) { ?>
                            <tr class=" <?php echo $si; ?> si1">
                                <td class="si"><?php echo $si; ?></td>
                                <td class="Committee"><?php echo $result->COMP_NAME; ?></td>
                                <td class="ComOpAmt" style="display: none;"></td>
                                <?php if(@$_SESSION['userGroup'] == "1" || @$_SESSION['userGroup'] == "6" || @$_SESSION['userGroup'] == "2" ){ ?>
                                    <td ><input class="form-control"  type="text" name="Balance" id="Balance_<?php echo $result->COMP_ID; ?>" autocomplete="off" value="<?php echo $result->BALANCE ?>"></td>
                                <?php } else { ?>
                                     <td class=""><?php echo $result->BALANCE; ?></td>
                                <?php } ?>
                                <td class="committeeId committeeIdCheck" id="<?php echo $result->COMP_ID; ?>" style="display: none;"><?php echo $result->COMP_ID; ?></td>
                                <td class="text-center"> 
                                    <?php if(@$_SESSION['userGroup'] == "1" || @$_SESSION['userGroup'] == "6" || @$_SESSION['userGroup'] == "2" ){ ?>               
                                    <a style="border:none; outline: 0;" href="#" title="Edit Opening Balance" ><img style="border:none; outline: 0;" width="24px" height="24px" onclick = "editOpeningBalance(<?php echo $result->FLT_ID.",".$result->BALANCE.",".$result->COMP_ID; ?>)" src="<?php echo base_url(); ?>images/check_icon.svg"></a>
                                    <?php } ?>
                                </td>
                                <!-- <td><center><a style="cursor:pointer;" id="removeComBtn_<?php echo $result->COMP_ID; ?>" onClick="updateTable1('<?php echo $si; ?>')"><img style="width:24px; height:24px;" title="delete" src="<?=base_url()?>images/delete1.svg"></a></center></td> -->
                            </tr>
                            <?php $si++;
                             } ?>
                            </tbody>
                     </table>
                </div>
            </div>
            </div>

            <div class="row form-group" id="bankCommitteeContainer" style="display: none;">
                <div class="control-group col-md-4 col-lg-2 col-sm-4 col-xs-6">
                    <label>Committee it belongs to: <span style="color:#800000;">*</span></label>
                </div>
                <div class="control-group col-md-4 col-lg-3 col-sm-4 col-xs-6">
                    <select id="CommitteeBank" name="CommitteeBank" class="form-control" style="height: 30px; width: 200px;" onChange="groupChange();" disabled>
                        <option value="" style="width: 300px;">Select Committee</option>
                        <?php   if(!empty($committee)) {
                            foreach($committee as $row1) { 
                                if($assignedComp[0]->COMP_ID == $row1->COMP_ID){ ?> 
                                <option value="<?php echo $row1->COMP_ID;?>" selected><?php echo $row1->COMP_NAME;?></option>
                                <?php } else { ?> 
                                <option value="<?php echo $row1->COMP_ID;?>"><?php echo $row1->COMP_NAME;?></option>
                        <?php } } } ?>
                    </select>
                </div>
            </div>
            <div class="row form-group" id="opBalDiv" style="display: none;">
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-6">              
                    <!-- <label for="comment">Opening Balance  </label></br> -->
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-6">
                    <?php if(($ledgerDetails[0]->TYPE_ID == 'A' || $ledgerDetails[0]->TYPE_ID == 'L')&& count($assignedComp) != 0) {?> 
                   <input style="height: 31px;width: 200px; " type="text" class="opening form-control" name="opAmt" id="opAmt" placeholder="Opening Balance Amount" autocomplete="off" min="0" value="<?php echo $assignedComp[0]->BALANCE;?>">
                   <?php }?>
                </div>
                 <div class="col-lg-2 col-md-2 col-sm-12 col-xs-6">
                   <?php if((@$_SESSION['userGroup'] == "1" || @$_SESSION['userGroup'] == "6" || @$_SESSION['userGroup'] == "2") && ($ledgerDetails[0]->TYPE_ID == 'A' || $ledgerDetails[0]->TYPE_ID == 'L') && count($assignedComp) != 0   ){ ?>               
                    <a style="margin-left: 12px;" href="#" title="Edit Opening Balance" ><img style="border:none; outline: 0;" width="24px" height="24px" 
                    onclick = "editOpeningBalance(<?php echo $assignedComp[0]->FLT_ID.",".$assignedComp[0]->BALANCE.",".$assignedComp[0]->COMP_ID; ?>)" src="<?php echo base_url(); ?>images/check_icon.svg"></a>
                    <?php } ?>
                </div>

            </div>
            <!-- NEW CODE END-->

            <div class="container-fluid container" id="bankdetail" >
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-left: 0px;">
                    <div class="form-group"><br>
                        <label for="comment" style="text-decoration: underline;width: 300px; margin-left: -1em;"><span style="font-size: 18px;text-align: center;">Bank Account Details:</span></label></br>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <div class="form-inline">
                            <label for="comment" style="height: 30px; margin-left: -2em;">Account Number <span style="color:#800000;">*</span></label>
                            <input type="text" maxlength="20" name="accountno" id="accountno" class="form-control"  placeholder="" autocomplete="off" onkeyup="alphaonlynumber(this)" style="height: 30px; margin-left: 20px; width:48%" value="<?php echo $ledgerDetails[0]->ACCOUNT_NO;?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-inline">
                            <label for="comment" style="height: 30px;margin-left: -2em;">IFSC Code <span style="color:#800000;">*</span></label>
                            <input type="text"  maxlength="11" name="ifsccode" class="form-control ifsc" id="ifsccode" placeholder="" autocomplete="off" min="0" style="height: 30px; margin-left: 62px; width:48%" value="<?php echo $ledgerDetails[0]->BANK_IFSC_CODE;?>">
                        </div>
                    </div>

                    <div class="form-group" >
                        <div class="form-inline">
                            <label for="comment" style="height: 30px;margin-left: -2em;">Bank Name <span style="color:#800000;">*</span></label>
                            <input type="text" name="bankname" id="bankname" class="form-control" onkeyup="alphaonly(this)" autocomplete="off"  style="height: 30px; margin-left: 52px; width:48%" value="<?php echo $ledgerDetails[0]->BANK_NAME;?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-inline">
                            <label for="comment" style="height: 30px;margin-left: -2em;">Bank Branch <span style="color:#800000;">*</span></label>
                            <input type="text" name="branch" id="branch" class="form-control" onkeyup="alphaonly(this)" autocomplete="off"  style="height: 30px; margin-left: 46px; width:48%" value="<?php echo $ledgerDetails[0]->BANK_BRANCH;?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-inline">
                            <label for="comment" style="height: 30px;margin-left: -2em;">Location <span style="color:#800000;">*</span></label>
                            <input type="text" name="location" class="form-control" id="location" placeholder="" autocomplete="off" style="height: 30px; margin-left: 72px;width:48%" value="<?php echo $ledgerDetails[0]->BANK_LOCATION;?>">
                        </div>
                    </div>
                </div>
                   <div class="table-responsive col-lg-6" style=" margin-top: -7em;">
                        <table id="addledger" class="table table-bordered table-hover">
                            <thead>
                              <tr>
                                <th style="width: 10%" id="ledgerName" name="ledgerName">Ledger Name</th>
                                <th style="width: 1%" class="text-center">Operation</th>
                            </tr>
                            </thead>
                          <tbody id="eventUpdate">
                            <?php foreach($assignedBankLedger as $result) { ?>
                            <tr>
                                <td class="ledgerIdCheck" style="display: none;" id="<?php echo $result->LEDGER_FGLH_ID; ?>"></td>
                                <td><?php echo $result->AssignedLedgerName; ?></td>
                                <?php if($result->AMT==0 ) { ?>
                                    <td><center><a style="cursor:pointer;" id="removeBtn_<?php echo $result->BLA_ID; ?>" onClick="removeExisting('<?php echo $result->BLA_ID; ?>')"><img style="width:24px; height:24px;" title="delete" src="<?=base_url()?>images/delete1.svg"></a></center></td>
                                <?php }else{ ?> <td></td> <?php } ?>
                            </tr>
                    <?php } ?>
                        </tbody>
                     </table>
                </div>
            </div>
            <div class="col-lg-5 col-md-12 col-sm-12 col-xs-6 text-right" style="margin-left: 3.5em;">
                <input type="button" class="btn btn-default btn-md custom" value="Submit"  onclick="editLedger()">
            </div>
            <input type="hidden" id="ledger1" name="ledger1"  value="" />
            <input type="hidden" id="removingLedgers" name="removingLedgers"  value="" />
            <input type="hidden" id="ledgerdate" name="" value="<?php echo $ledgerdate ?>">
            <input type="hidden" id="committee1" name="committee1"  value="" />
            <input type="hidden" id="committeeOpBal1" name="committeeOpBal1"  value="" />
        </form>
    </div>
</div> 

<div class="modal fade bs-example-modal-lg" id="editLedgerModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Ledger Preview</h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer text-left" style="text-align:left;">
                <label>Are you sure you want to save..?</label>
                <br/>
                <button type="button" style="width: 8%;" class="btn " onclick="document.getElementById('frmEditLedger').submit();">Yes</button>
                <button type="button" style="width: 8%;" class="btn " data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bs-example-modal-lg" id="editOpeningBalanceModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Opening Balance Preview</h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer text-left" style="text-align:left;">
                <label>Are you sure you want to save..?</label>
                <br/>
            </div>
        </div>
    </div>
</div>

<form id="editForm1" action="<?=site_url()?>finance/editLedger" method="post">
    <input type="hidden" id="LEDGER_ID" name="LEDGER_ID" value="<?php echo $LEDGER_ID ?>">
    <input type="hidden" id="LEDGER_NAME" name="LEDGER_NAME" value="<?php echo $LEDGER_NAME ?>">
    <input type="hidden" id="LEDGER_PARENT_ID" name="LEDGER_PARENT_ID" value="<?php echo $LEDGER_PARENT_ID ?>">
    <input type="hidden" name="IS_JOURNAL_STATUS" id="IS_JOURNAL_STATUS" value="<?php echo $IS_JOURNAL_STATUS ?>"/>
    <input type="hidden" name="IS_TERMINAL" id="IS_TERMINAL" value="<?php echo $IS_TERMINAL ?>"/>
    <input type="hidden" name="IS_FD_STATUS" id="IS_FD_STATUS" value="<?php echo $IS_FD_STATUS ?>"/>
    <input type="hidden" name="FD_MATURITY_START_DATE" id="FD_MATURITY_START_DATE" value="<?php echo $FD_MATURITY_START_DATE ?>"/>
    <input type="hidden" name="FD_MATURITY_END_DATE" id="FD_MATURITY_END_DATE" value="<?php echo $FD_MATURITY_END_DATE ?>"/>
    <input type="hidden" name="FD_INTEREST_RATE" id="FD_INTEREST_RATE" value="<?php echo $FD_INTEREST_RATE ?>"/>

    

</form>


<script type="text/javascript">
    function addRow() {
       var count = 0;
        if(document.getElementById("ledgers").value != "") {
            $('#ledgers').css('border-color', "#000000");
        } else {
            $('#ledgers').css('border-color', "#FF0000");
            ++count;
        }
        //   if(document.getElementById("groups").value != "") {
        //     $('#groups').css('border-color', "#000000");
        // } else {
        //     $('#groups').css('border-color', "#FF0000");
        //     ++count;
        // }

        if(count != 0) {
            alert("Information","Please fill required fields","OK");
        }else{
            //let groups = $('#groups option:selected').html();
            let ledgers = $('#ledgers option:selected').html();
            let ledId = $('#ledgers').val().split("|");
            let flag=0;
            $(".ledgerIdCheck").each(function() {
                if(ledId[0]==this.id)
                    flag++; 
            });
            if(flag!=0){
                alert("Already Exist");
                return;
            }

            let si = $('#addledger tr:last-child td:first-child').html();
            if (!si)
                si = 1
            else
                ++si;
            $('#addledger').append('<tr class="' + si + ' si1"><td class="si" style="display:none">' + si + '</td><td class="ledgerId ledgerIdCheck" id="' + ledId[0] + '" style="display:none">' + ledId[0] + '</td><td class="ledgers" >' + ledgers + '</td><td class="link1"><center><a style="cursor:pointer;" onClick="updateTable(' + si + ');"><img style="width:24px; height:24px;" title="delete" src="<?=base_url()?>images/delete1.svg"></a></center></td></tr>');
             $('#ledgers').val("");
        }
    }
     function showfddiv() {
       if($('#fdyes').prop('checked') == true) {
             document.getElementById('fddiv').style.display = 'block';
               document.getElementById('fddive').style.display = 'block';
                document.getElementById('fdinterestrate').style.display = 'block';
                document.getElementById('fdNameDiv').style.display = 'block';
               document.getElementById('fdBankName').style.display = 'block'
               
             
        }  else {
             document.getElementById('fddiv').style.display = 'none';
               document.getElementById('fddive').style.display = 'none';
                document.getElementById('fdinterestrate').style.display = 'none';
                document.getElementById('fdNameDiv').style.display = 'none';
            document.getElementById('fdBankName').style.display = 'none'
        }
        
    }
    function alphaonlypurpose(input) {
      var regex=/[^-a-z-0-9 ]/gi;
      input.value=input.value.replace(regex,"");
    }
    function updateTable(si) {
        if(si != 0) {
            let si1 = document.getElementsByClassName(si);
            si1[0].remove();
        }
        for (let i = 0; i < tableValues['addledger'].length; ++i) {
            tableValues['si'][i].innerHTML = (i + 1);
            tableValues['link1'][i].innerHTML = '<a style="cursor:pointer;" onClick="updateTable(' + (i + 1) + ');"><img style="width:24px; height:24px;" title="delete" src="<?=base_url()?>images/delete1.svg"></a>';
            tableValues['si1'][i].className = (i + 1) + " si1";
        }
    }

    function addRow1() {
        let bankdetail = '<?php echo $parentDetails[0]->TYPE_ID ?>';
       var count = 0;

       if(bankdetail == 'A' || bankdetail == 'L'){
        if(document.getElementById("Committee").value != "") {
            $('#Committee').css('border-color', "#000000");
        } else {
            $('#Committee').css('border-color', "#FF0000");
            ++count;
        }
        if(document.getElementById("committeeOpAmt").value != "") {
            $('#committeeOpAmt').css('border-color', "#000000");
        } else {
            $('#committeeOpAmt').css('border-color', "#FF0000");
            ++count;
        }
        document.getElementById('opBalDiv').style.display = 'block'; 
       }else{
        if(document.getElementById("Committee").value != "") {
            $('#Committee').css('border-color', "#000000");
        } else {
            $('#Committee').css('border-color', "#FF0000");
            ++count;
        }
        document.getElementById('opBalDiv').style.display = 'none'; 
       }
       

        if(count != 0) {
            alert("Information","Please fill required fields","OK");
        }else{
            let Committee = $('#Committee option:selected').html();
            let committeeOpAmt = $('#committeeOpAmt').val();
            let ledId = $('#Committee').val().split("|");
              let flag=0;
             $(".committeeIdCheck").each(function() {
                if(ledId[0]==this.id)
                    flag++; 
            });
            if(flag!=0){
                alert("Information","Already Exist,Please Select Other Committee");
                return;
            }

                let si = $('#addCommittee tr:last-child td:first-child').html();
                if (!si)
                    si = 1
                else
                    ++si;
                $('#addCommittee').append('<tr class="' + si + ' si1"><td class="si">' + si + '</td><td class="committeeId committeeIdCheck" id="' + ledId[0] + '" style="display:none">' + ledId[0] + '</td><td class="Committee">' + Committee + '</td><td class="ComOpAmt">' + committeeOpAmt + '</td><td class="link1"><center><a style="cursor:pointer;" onClick="updateTable1(' + si + ');"><img style="width:24px; height:24px;" title="delete" src="<?=base_url()?>images/delete1.svg"></a></center></td></tr>');
                $('#committeeOpAmt').val("");
                 $('#Committee').val("");
        }
      
    }
    function updateTable1(si) {
            if(si != 0) {
                let si1 = document.getElementsByClassName(si);
                si1[0].remove();
            }
            for (let i = 0; i < tableValues['addCommittee'].length; ++i) {
                tableValues['si'][i].innerHTML = (i + 1);
                tableValues['link1'][i].innerHTML = '<a style="cursor:pointer;" onClick="updateTable1(' + (i + 1) + ');"><img style="width:24px; height:24px;" title="delete" src="<?=base_url()?>images/delete1.svg"></a>';
                tableValues['si1'][i].className = (i + 1) + " si1";
            }
        }

    function removeExisting($BLA_ID){
        $('#removingLedgers').val((($('#removingLedgers').val() != "")?$('#removingLedgers').val() + "," + $BLA_ID:$BLA_ID));
        document.getElementById('removeBtn_'+$BLA_ID).style.display = 'none';
    }

    $(document).ready(function(){
        let bankdetail = '<?php echo $parentDetails[0]->TYPE_ID ?>';

        if(document.getElementById("underId").value == '9') {
            document.getElementById('bankdetail').style.display = 'block';
            document.getElementById('combo').style.display = 'block';
            //document.getElementById('combo1').style.display = 'block';
            document.getElementById('combo2').style.display = 'block';
            document.getElementById('addicon').style.display = 'block';
            document.getElementById('bankCommitteeContainer').style.display = 'block';
            document.getElementById('opBalDiv').style.display = 'block'; 
            document.getElementById('committeeContainer').style.display = 'none';
            document.getElementById('opAmt').style.display = 'block'; 
            document.getElementById('terminal').style.display = 'block';
            document.getElementById('OpeningBal').style.display = 'block';
        }else {
            document.getElementById('bankdetail').style.display = 'none'; 
            document.getElementById('combo').style.display = 'none';
            //document.getElementById('combo1').style.display = 'none';
            document.getElementById('combo2').style.display = 'none';
            document.getElementById('addicon').style.display = 'none';
            document.getElementById('bankCommitteeContainer').style.display = 'none';
            if(bankdetail == 'A' || bankdetail == 'L')  {
                 document.getElementById('OpeningBal').style.display = 'block';
            }else{
                document.getElementById('OpeningBal').style.display = 'none';
            }
            document.getElementById('opBalDiv').style.display = 'none'; 
            document.getElementById('committeeContainer').style.display = 'block';
             
            document.getElementById('opAmt').style.display = 'none';
            document.getElementById('terminal').style.display = 'none'; 
        }

       if(document.getElementById("fdyesId").value == '1') {
          document.getElementById('fddiv').style.display = 'block';
          document.getElementById('fddive').style.display = 'block';
          document.getElementById('fdinterestrate').style.display = 'block';
          document.getElementById('fdNameDiv').style.display = 'block';
          document.getElementById('fdBankName').style.display = 'block'
        }
        // else {
        //     document.getElementById('bankdetail').style.display = 'none'; 
        //     document.getElementById('combo').style.display = 'none';
        // }
        
        groupChange();
    });

    function editLedger() {
        let count = 0;
        let nameL = $('#nameL').val();
        let under = $('#under').val();
        let opAmt = $('#opAmt').val();
        let todayDate = $('#todayDate').val();
        let accountno = $('#accountno').val();
        let ifsccode = $('#ifsccode').val();
        let bankname = $('#bankname').val();
        let branch = $('#branch').val();
        let location = $('#location').val();
        let underId = $('#underId').val();
        let todayDate3 = $('#todayDate3').val();
        let intrestrate = $('#intrestrate').val();
        let Bank = $('#Bank').val();
        let FDNumber = $('#FDNumber').val();
        let todayDate1 = $('#todayDate1').val();
         if($('#jouranalyes').prop('checked') == true) {
            document.getElementById('jouranalyes').value = 1;
        }  else {
            document.getElementById('jouranalyes').value = 0;
        }
        let jouranalyes = $('#jouranalyes').val();

        if($('#terminalyes').prop('checked') == true) {
            document.getElementById('terminalyes').value = 1;
        }  else {
            document.getElementById('terminalyes').value = 0;
        }
        let terminalyes = $('#terminalyes').val();
        if($('#fdyes').prop('checked') == true) {

        document.getElementById('fdyes').value = 1;
        // ADDED BY ADITHYA START
        if(document.getElementById("Bank").value != ""){
            $('#Bank').css('border-color', "#000000");  
        }else {
            $('#Bank').css('border-color', "#FF0000");
         ++count;  
        }
        if(document.getElementById("FDNumber").value != ""){
            $('#FDNumber').css('border-color', "#000000");
        }else {
            $('#FDNumber').css('border-color', "#FF0000");
         ++count;
        }
        // ADDED BY ADITHYA END
        }  else {
            document.getElementById('fdyes').value = 0;
        }
            let fdyes = $('#fdyes').val();
            if($('#fdyes').prop('checked') == true) {
             
            if (document.getElementById("todayDate3").value != "") {
              $('#todayDate3').css('border-color', "#000000");
            } else {
              $('#todayDate3').css('border-color', "#FF0000");
             ++count;
            }
            if (document.getElementById("todayDate1").value != "") {
              $('#todayDate1').css('border-color', "#000000");
            } else {
              $('#todayDate1').css('border-color', "#FF0000");
             ++count;
            }
              
        }
        //TO ASSIGN LEDGER
        let ledgerId = document.getElementsByClassName('ledgerId');
        let LedgerName = document.getElementsByClassName('ledgers');

        let ledgerIdVal = [];
        let selId;
        let selLedgerName="";
        for (let i = 0; i < ledgerId.length; ++i) {
            ledgerIdVal[i] = ledgerId[i].innerHTML.trim();
            selLedgerName += LedgerName[i].innerHTML.trim() + " ";
            
        }
        let ids = JSON.stringify(ledgerIdVal);
        document.getElementById('ledger1').value = ids;
        //END ASSIGN

        //TO ASSIGN COMMITTEE
        let committeeId = document.getElementsByClassName('committeeId');
        let committeeName = document.getElementsByClassName('Committee');
        let committeeOp = document.getElementsByClassName('ComOpAmt');

        let committeeIdVal = [];
        let committeeOpVal = [];
        let opTotal=0;
        let selcommitteeName = "";
        if(underId != '9'){
            for (let i = 0; i < committeeId.length; ++i) {
                committeeIdVal[i] = committeeId[i].innerHTML.trim();
                committeeOpVal[i] = committeeOp[i].innerHTML.trim();
                selcommitteeName += committeeName[i].innerHTML.trim() + " ";
                if(parseInt(committeeOp[i].innerHTML.trim())){
                    opTotal += parseInt(committeeOp[i].innerHTML.trim());
                }
            }
            document.getElementById('committee1').value = committeeIdVal;
            document.getElementById('committeeOpBal1').value = committeeOpVal;
        }else{

            document.getElementById('committee1').value =  $('#CommitteeBank').val();
            document.getElementById('committeeOpBal1').value = $('#opAmt').val();
            //selcommitteeName = $('#CommitteeBank option:selected').html();
            opTotal = $('#opAmt').val();
        }
        opAmt = opTotal;
        //END ASSIGN COMMITTEE

        if (document.getElementById("nameL").value != "") {
          $('#nameL').css('border-color', "#000000");
        } else {
          $('#nameL').css('border-color', "#FF0000");
         ++count;
        }
        // if (document.getElementById("opAmt").value != "") {
        //   $('#opAmt').css('border-color', "#000000");
        // } else {
        //   $('#opAmt').css('border-color', "#FF0000");
        //  ++count;
        // }
        if(document.getElementById("underId").value == '9'){
            if (document.getElementById("accountno").value != "") {
              $('#accountno').css('border-color', "#000000");
            } else {
              $('#accountno').css('border-color', "#FF0000");
             ++count;
            }
            if (document.getElementById("ifsccode").value != "") {
              $('#ifsccode').css('border-color', "#000000");
            } else {
              $('#ifsccode').css('border-color', "#FF0000");
             ++count;
            }
            if (document.getElementById("bankname").value != "") {
              $('#bankname').css('border-color', "#000000");
            } else {
              $('#bankname').css('border-color', "#FF0000");
             ++count;
            }
            if (document.getElementById("branch").value != "") {
              $('#branch').css('border-color', "#000000");
            } else {
              $('#branch').css('border-color', "#FF0000");
             ++count;
            }
            if (document.getElementById("location").value != "") {
              $('#location').css('border-color', "#000000");
            } else {
              $('#location').css('border-color', "#FF0000");
             ++count;
            }
            // if (document.getElementById("ledger1").value != "" && document.getElementById("ledger1").value != "[]") {
            //   $('#ledger1').css('border-color', "#000000");
            // } else {
            //   $('#ledger1').css('border-color', "#FF0000");
            //  ++count;
            // }
        }
        if (count != 0) {
          alert("Information", "Please fill required fields", "OK");
          return false;
        }

        

        $("#editLedgerModal").modal();
        $('.modal-body').html("");
        $('.modal-body').append("<label>DATE:</label> " + "<?=date('d-m-Y'); ?>" + "<br/>");
        if(nameL)
            $('.modal-body').append("<label>LEDGER NAME:</label> " +nameL+ "<br/>");
        if(under)
            $('.modal-body').append("<label>UNDER GROUP:</label> " + under + "<br/>");
       if (opAmt) 
            $('.modal-body').append("<label>OPENING BALANCE AMOUNT:</label> " + opAmt + "<br/>");
        if (selcommitteeName) 
            $('.modal-body').append("<label>COMMITTEE:</label>"+ selcommitteeName +" <br/>");
          if (todayDate3) 
            $('.modal-body').append("<label>FD Start Date:</label>"+ todayDate3 +" <br/>");
          if (todayDate1) 
            $('.modal-body').append("<label>FD End Date:</label>"+ todayDate1 +" <br/>");
           if (intrestrate) 
            $('.modal-body').append("<label>FD Intrest Rate:</label>"+ intrestrate +" <br/>");
        if(document.getElementById("underId").value == '9'){
            if (accountno) 
                $('.modal-body').append("<label>ACCOUNT NUMBER:</label> " + accountno + "<br/>");
            if (ifsccode) 
                $('.modal-body').append("<label>IFSC CODE:</label> " + ifsccode + "<br/>");
            if (bankname) 
                $('.modal-body').append("<label>BANK NAME:</label> " + bankname + "<br/>");
            if (branch) 
                $('.modal-body').append("<label>BANK BRANCH:</label> " + branch + "<br/>");
            if (location) 
                $('.modal-body').append("<label>LOCATION:</label> " + location + "<br/>");
            if (selLedgerName) 
                $('.modal-body').append("<label>ASSIGNED LEDGER:</label> " + String(selLedgerName) + "<br/>");
            if(Bank)
                $('.modal-body').append("<label>Bank Name:</label>"+ Bank +" <br/>");
            if(FDNumber)
               $('.modal-body').append("<label>FD Number:</label>"+ FDNumber +" <br/>");
        }
    }

    //INPUT KEYPRESS
    $(':input').on('keypress change', function() {
        var id = this.id;
        try {$('#' + id).css('border-color', "#000000");}catch(e) {}

    });

    function GetDataOnDate() {
        // document.getElementById('date').value = ledgerDate;
        // document.getElementById('load').value = "DateChange";
    }

    var ldate = document.getElementById('ledgerdate').value;
    var currentTime = new Date(ldate);
    var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
    var maxDate =  new Date(); // one day before next month
    $( ".todayDate2" ).datepicker({ 
        minDate: ldate, 
        maxDate: maxDate,
        'yearRange': "2007:+50",
        dateFormat: 'dd-mm-yy',
        changeMonth:true,
        changeYear:true
    });

    $('.todayDate').on('click', function() {
        $( ".todayDate2" ).focus();
    })
  $( ".fdendDate" ).datepicker({ 
       
        'yearRange': "2007:+50",
        dateFormat: 'dd-mm-yy',
        changeMonth:true,
        changeYear:true
    });

    $('.todayDate1').on('click', function() {
        $( ".fdendDate" ).focus();
    })

     $( ".fdstartDate" ).datepicker({ 
       
        'yearRange': "2007:+50",
        dateFormat: 'dd-mm-yy',
        changeMonth:true,
        changeYear:true
    });

    $('.todayDate3').on('click', function() {
        $( ".fdstartDate" ).focus();
    })

    function alphaonly(input) {
      var regex=/[^a-z&']/gi;
      input.value=input.value.replace(regex,"");
    }

     function alphaonlynumber(input) {
      var regex=/[^0-9 ]/gi;
      input.value=input.value.replace(regex,"");
    }

    function groupChange(){
        $('#ledgers').html("");
        let groupVal = document.getElementById("CommitteeBank").value; 
        arr = <?php echo @$allocationLedgers; ?>; 
        groupNo = groupVal;
        $('#ledgers').append('<option value="">Select Ledger</option>');
        for (let i = 0; i < arr.length; ++i) {
            let compid =arr[i]['COMP_ID'].split(","); 
            for (let j = 0; j < compid.length; ++j) {        
                if (compid[j] == groupNo){
                    $('#ledgers').append('<option value="' + arr[i]['FGLH_ID'] +"|" + arr[i]['FGLH_NAME'] +'">' + arr[i]['FGLH_NAME'] + '</option>');
                }
            }
        }
    }

    $('.opening').keypress(function(event) {
      if ((event.which != 46 || $(this).val().indexOf('.') != -1) &&
        ((event.which < 48 || event.which > 57) &&
          (event.which != 0 && event.which != 8))) {
        event.preventDefault();
      }
  
      var text = $(this).val();
  
      if ((text.indexOf('.') != -1) &&
        (text.substring(text.indexOf('.')).length > 2) &&
        (event.which != 0 && event.which != 8) &&
        ($(this)[0].selectionStart >= text.length - 2)) {
        event.preventDefault();
      }
    });

    function editOpeningBalance(fltId,oldBalance,compId){
       let Balance="";
        if(document.getElementById("underId").value != '9'){
            Balance  = $('#Balance_'+compId).val();
        }else{
            Balance  = document.getElementById("opAmt").value;
        }
        let LedgerFglhId  = $('#editLedgerId').val();
        if(Balance==oldBalance){
            alert("Edit Opening Balance Amount");
            return;
        }
        $('#editOpeningBalanceModal .modal-body').html("");
        $('#editOpeningBalanceModal .modal-footer').html("");

        $('#editOpeningBalanceModal .modal-body').append("<label>OLD BALANCE:</label> " + oldBalance + "<br/>");
        $('#editOpeningBalanceModal .modal-body').append("<label>NEW BALANCE:</label> " + Balance + "<br/>");

        $('#editOpeningBalanceModal .modal-footer').append("<button type='button' style='width: 8%;' class='btn' onclick='editOpeningBalanceAmount("+fltId+","+oldBalance+","+compId+");'>Yes</button>");
        $('#editOpeningBalanceModal .modal-footer').append("<button type='button' id='opModalClose' style='width: 8%;' class='btn' data-dismiss='modal'>No</button>");
        $("#editOpeningBalanceModal").modal();
    }

    function editOpeningBalanceAmount(fltId,oldBalance,compId){
        let Balance="";
         if(document.getElementById("underId").value != '9'){
            Balance  = $('#Balance_'+compId).val();
        }else{
            Balance  = document.getElementById("opAmt").value;
        }
        let LedgerFglhId  = $('#editLedgerId').val();
        let LedgerFglhName  = $('#nameL').val();

        let url = "<?=site_url()?>finance/updateOpeningBalance";
        $.post(url, { 'fltId': fltId, 'Balance': Balance, 'LedgerFglhId': LedgerFglhId, 'oldBalance': oldBalance, 'LedgerFglhName': LedgerFglhName, 'compId': compId}, function (e) {

        e1 = e.split("|")
        if (e1[0] == "success"){
            $('#opModalClose').click();
            alert2("Information","Opening Balance Updated Successfully","Ok");
            //editForm1 submit
        }
        else
            alert("Something went wrong, Please try again after some time");
        });
    }

    nameL.addEventListener("blur", function () {
        $('#nameL').attr("data-toggle", "");
        $('#DropdownLedgers').hide();
    });

</script>