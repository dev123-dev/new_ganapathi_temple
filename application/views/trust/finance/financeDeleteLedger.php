<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
<div class="container-fluid container">
    <div class="row form-group">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-8" >               
            <h3><span class="icon icone-crop"></span>Delete Ledger</h3> 
        </div>
       <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4" style = "padding-top:10px;">
            <a style="text-decoration:none;cursor:pointer;pull-right;" title="Back" href="<?=site_url();?>Trustfinance/allGroupLedgerDetails"><img style="width:24px; height:24px; margin-left: 13em;" title="Go back"  src="<?=site_url();?>images/back_icon.svg"/></a>
        </div>
    </div>
</div> 

<div id="addLedgerDiv" style="">
    <div class="container py-5" >
        <form id="frmDeleteLedger" action="<?=site_url()?>Trustfinance/discardLedger" method="post">
            <div class="row form-group">
                <div class="control-group col-md-2 col-lg-2 col-sm-4 col-xs-6">               
                    <label>Ledger Name: <span style="color:#800000;" >*</span></label>                     
                </div>
                <div class="control-group col-md-4 col-lg-2 col-sm-4 col-xs-6">               
                     <input style="height:30px; width: 200px;"  class="form-control" type="text" name="nameL" placeholder="Ledger Name" id="nameL" autocomplete="off" value="<?php echo $LED_NAME ?>" readonly>
                     <input class="form-control"  type="hidden" name="deleteLedgerId" id="deLedgerId" value="<?php echo $LED_ID ?>">
                </div> 
            </div>

            <div class="row form-group">
                <div class="control-group col-md-4 col-lg-2 col-sm-4 col-xs-6">
                    <label>Under: <span style="color:#800000;">*</span></label>
                </div>
                <div class="control-group col-md-4 col-lg-2 col-sm-4 col-xs-6">
                    <input type="text"  name="under" id="under" class="form-control"  style="width:100%;"  id="under" autocomplete="off" value="<?php echo $parentDetails[0]->T_FGLH_NAME;?>" readonly>
                    <input type="hidden" name="underId" id="underId" value="<?php echo $parentDetails[0]->T_FGLH_ID;?>">
                </div>
                <div class="control-group col-md-4 col-lg-2 col-sm-4 col-xs-6" id="combo" style="margin-left: 10.9em;display: none">
                    <label style="margin-left: 4.5em; margin-top: 5px;display: none">Assign Ledger: <span style="color:#800000;">*</span></label> 
                </div>
                 <div class="control-group col-md-4 col-lg-1 col-sm-4 col-xs-6" id="combo2" style=" margin-left: 5.2em;">
                    <select id="ledgers" name="ledgers" class="form-control" style="width:190px;display: none">
                          <option value="">Select Ledger</option>
                    </select> 
                </div>
                <div class="control-group col-md-4 col-lg-1 col-sm-4 col-xs-6" id="addicon" style="margin-left:4.7em;">
                    <a onClick="addRow()">
                        <img style="width:24px; height:24px;display: none " class="img-responsive pull-right" title="Add Seva" src="<?=site_url();?>images/add.svg">
                    </a>
                </div>
            </div>

             <div class="row form-group">
                <div class="control-group col-md-4 col-lg-2 col-sm-4 col-xs-6" style="width: 220px;">
                    <label>Opening Balance</label>  
                </div>
                 <div class="control-group col-md-4 col-lg-2 col-sm-4 col-xs-6" style="margin-left: -1.6em;">
                    <?php if($OPBALANCE == 0) { ?> 
                         <input style="height:30px; width: 200px;"  class="form-control"  type="text" name="balance" placeholder="Opening Amount" id="opbalance" autocomplete="off" value="0" readonly>
                    <?php } else {?>    
                        <input style="height:30px; width: 200px;"  class="form-control"  type="text" name="balance" placeholder="Opening Amount" id="opbalance" autocomplete="off" value="<?php echo $OPBALANCE ?>" readonly> 
                     <?php } ?>    
                </div>
            </div>

            <div class="row form-group">
                <div class="control-group col-md-4 col-lg-2 col-sm-4 col-xs-6" style="width: 220px;">
                    <label>Current Balance</label>  
                </div>
                 <div class="control-group col-md-4 col-lg-2 col-sm-4 col-xs-6" style="margin-left: -1.6em;">
                    <?php if($BALANCE == 0) { ?> 
                         <input style="height:30px; width: 200px;"  class="form-control"  type="text" name="balance" placeholder="Current Amount" id="balance" autocomplete="off" value="0" readonly>
                    <?php } else {?>    
                        <input style="height:30px; width: 200px;"  class="form-control"  type="text" name="balance" placeholder="Current Amount" id="balance" autocomplete="off" value="<?php echo $BALANCE ?>" readonly> 
                     <?php } ?>    
                </div>
            </div>

            <!-- abhipra -->
            <div class="row form-group">
                <div class="control-group col-md-4 col-lg-2 col-sm-4 col-xs-6" style="width: 220px;">
                      <label>Does this belong to Jounal?</label>  
                </div>
                <div class="control-group col-md-4 col-lg-2 col-sm-4 col-xs-6" style="margin-left: -1.6em;">
                    <?php if($JOURNAL_STATUS == 1) { ?> 
                        <input type="checkbox" id="jouranalyes" name="jouranalyes" class="jouranalyes" value="<?php echo $JOURNAL_STATUS ?>" checked  onclick="return false"/> Yes</center>
                    <?php } else {?>
                        <input type="checkbox" id="jouranalyes" name="jouranalyes" class="jouranalyes" value="<?php echo $JOURNAL_STATUS ?>"  onclick="return false" /> Yes</center>
                    <?php } ?>
                </div>
            </div>

            <div class="row form-group" id="terminal" style="display:none;">
                <div class="control-group col-md-4 col-lg-2 col-sm-4 col-xs-6" style="width: 220px;">
                    <label>Is Terminal?</label>  
                </div>
                <div class="control-group col-md-4 col-lg-2 col-sm-4 col-xs-6" style="margin-left: -1.6em;">
                    <?php if($TERMINAL == 1) { ?> 
                        <input type="checkbox" id="terminalyes" name="terminalyes" class="terminalyes" value="<?php echo $TERMINAL ?>" checked   onclick="return false"/> Yes</center>
                    <?php } else {?>
                        <input type="checkbox" id="terminalyes" name="terminalyes" class="terminalyes" value="<?php echo $TERMINAL ?>"  onclick="return false" /> Yes</center>
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
                </div>
                <div class="row form-group">
                    <div class="table-responsive col-lg-5 col-md-2 col-sm-12 col-xs-6">              
                        <table id="addCommittee" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 1%">SI.NO</th>
                                    <th style="width: 10%" id="committeeName" name="committeeName">Committee Name</th>
                                </tr>
                            </thead>
                            <tbody id="committeeUpdate">
                                <?php  $si = 1;
                                foreach($assignedComp as $result) { ?>
                                <tr class=" <?php echo $si; ?> si1">
                                    <td class="si"><?php echo $si; ?></td>
                                    <td class="Committee"><?php echo $result->T_COMP_NAME; ?></td>
                                   <!--  <td></td> -->
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
                    <select id="CommitteeBank" name="CommitteeBank" class="form-control" style="height: 30px; width: 200px;"  disabled>
                        <option value="" style="width: 300px;">Select Committee</option>
                        <?php   if(!empty($committee)) {
                            foreach($committee as $row1) { 
                                if($assignedComp[0]->T_COMP_ID == $row1->T_COMP_ID){ ?> 
                                    <option value="<?php echo $row1->COMP_ID;?>" selected><?php echo $row1->T_COMP_NAME;?></option>
                                <?php } else { ?> 
                                    <option value="<?php echo $row1->COMP_ID;?>"><?php echo $row1->T_COMP_NAME;?></option>
                        <?php } } } ?>
                    </select>
                </div>
            </div>

            <div class="row form-group" id="opBalDiv" style="display: none">
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-6">              
                    <label for="comment">Opening Balance as on  <span style="color:#800000;">*</span></label></br>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-6" id="opDate">              
                    <div class="input-group input-group-sm col-lg-2" style="width: 120px;">
                        <input type="hidden" name="date" value="<?=@$date; ?>" id="date" value="" >
                        <input type="hidden" name="load" id="load" value="">
                        <input autocomplete="" name= "todayDate" id="todayDate" type="text" value="<?=date('d-m-Y'); ?>" class="form-control todayDate2"  onchange="GetDataOnDate(this.value)" placeholder="dd-mm-yyyy" readonly = "readonly" />
                        <div class="input-group-btn">
                            <button class="btn btn-default todayDate" type="button">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-6">
                   <input style="height: 31px;width: 195px; margin-left:-5em;" type="text" class="opening form-control" name="opAmt" id="opAmt" placeholder="Opening Balance Amount" autocomplete="off" min="0">
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
                            <input type="number" maxlength="10" name="accountno" id="accountno" class="form-control"  placeholder="" autocomplete="off" style="height: 30px; margin-left: 20px; width:48%" value="<?php echo $ledgerDetails[0]->T_ACCOUNT_NO;?>" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-inline">
                            <label for="comment" style="height: 30px;margin-left: -2em;">IFSC Code <span style="color:#800000;">*</span></label>
                            <input type="text"  maxlength="10" name="ifsccode" class="form-control" id="ifsccode" placeholder="" autocomplete="off" min="0" style="height: 30px; margin-left: 62px; width:48%" value="<?php echo $ledgerDetails[0]->T_BANK_IFSC_CODE;?>" readonly>
                        </div>
                    </div>

                    <div class="form-group" >
                        <div class="form-inline">
                            <label for="comment" style="height: 30px;margin-left: -2em;">Bank Name <span style="color:#800000;">*</span></label>
                            <input type="text" name="bankname" id="bankname" class="form-control" autocomplete="off"  style="height: 30px; margin-left: 52px; width:48%" value="<?php echo $ledgerDetails[0]->T_BANK_NAME;?>" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-inline">
                            <label for="comment" style="height: 30px;margin-left: -2em;">Bank Branch <span style="color:#800000;">*</span></label>
                            <input type="text" name="branch" id="branch" class="form-control" autocomplete="off"  style="height: 30px; margin-left: 46px; width:48%" value="<?php echo $ledgerDetails[0]->T_BANK_BRANCH;?>" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-inline">
                            <label for="comment" style="height: 30px;margin-left: -2em;">Location <span style="color:#800000;">*</span></label>
                            <input type="text" name="location" class="form-control" id="location" placeholder="" autocomplete="off" style="height: 30px; margin-left: 72px;width:48%" value="<?php echo $ledgerDetails[0]->T_BANK_LOCATION;?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="table-responsive col-lg-6" style=" margin-top: -23.5em;">
                    <table id="addledger" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="width: 5%" id="ledgerName" name="ledgerName">Ledger Name</th>
                            </tr>
                        </thead>
                        <tbody id="eventUpdate">
                            <?php foreach($assignedBankLedger as $result) { ?>
                                <tr>
                                    <td class="ledgerIdCheck" style="display: none;" id="<?php echo $result->T_LEDGER_FGLH_ID; ?>"></td>
                                    <td style="width: 5%"><?php echo $result->AssignedLedgerName; ?></td>
                                  
                                </tr>
                         <?php } ?>
                        </tbody>
                     </table>
                </div>
            </div>
            <div class="col-lg-5 col-md-12 col-sm-12 col-xs-6 text-right" style="margin-left: 3.5em;">
                <input type="button" class="btn btn-default btn-md custom" value="Delete"  onclick="deleteLedger()">
            </div>
            <input type="hidden" id="ledger1" name="ledger1"  value="" />
            <input type="hidden" id="removingLedgers" name="removingLedgers"  value="" />
            <input type="hidden" id="ledgerdate" name="" value="<?php echo $ledgerdate ?>">
            <input type="hidden" id="committee1" name="committee1"  value="" />
            <input type="hidden" id="committeeOpBal1" name="committeeOpBal1"  value="" />
            <input type="hidden" name="current_balance" id="current_balance" value="<?php echo abs($CURRENT_BALANCE) ?>" >    

        </form>
    </div>
</div> 

<div class="modal fade bs-example-modal-lg" id="deleteLedgerModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Ledger Preview</h4>
            </div>
            <!-- <div class="modal-body">
            </div> -->
            <div class="modal-footer text-left" style="text-align:left;">
                <label>Are you sure you want to delete..?</label>
                <br/>
                <button type="button" style="width: 8%;" class="btn " onclick="document.getElementById('frmDeleteLedger').submit();">Yes</button>
                <button type="button" style="width: 8%;" class="btn " data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function(){
        if(document.getElementById("underId").value == '9') {
            document.getElementById('bankdetail').style.display = 'block';
            document.getElementById('combo').style.display = 'block';
            //document.getElementById('combo1').style.display = 'block';
            document.getElementById('combo2').style.display = 'block';
            document.getElementById('addicon').style.display = 'block';
            document.getElementById('bankCommitteeContainer').style.display = 'block'; 
            document.getElementById('committeeContainer').style.display = 'none';
            document.getElementById('opAmt').style.display = 'block'; 
            document.getElementById('terminal').style.display = 'block';  
        }else {
            document.getElementById('bankdetail').style.display = 'none'; 
            document.getElementById('combo').style.display = 'none';
            document.getElementById('combo2').style.display = 'none';
            document.getElementById('addicon').style.display = 'none';
            document.getElementById('bankCommitteeContainer').style.display = 'none';
            document.getElementById('committeeContainer').style.display = 'block'; 
            document.getElementById('opAmt').style.display = 'none';
            document.getElementById('terminal').style.display = 'none'; 
        }
        // groupChange();
    });

    function deleteLedger() {
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
        let balance = $('#balance').val();
        let current_balance = $('#current_balance').val();
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

         if (current_balance > 0) {
            alert("Information", "You Can't Delete ledger with Trasncation!!", "OK");
            return false;
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
                opTotal += parseInt(committeeOp[i].innerHTML.trim());

            }
            document.getElementById('committee1').value = committeeIdVal;
            document.getElementById('committeeOpBal1').value = committeeOpVal;
        }else{

            document.getElementById('committee1').value =  $('#CommitteeBank').val();
            document.getElementById('committeeOpBal1').value = $('#opAmt').val();
            opTotal = $('#opAmt').val();
        }
        opAmt = opTotal;
        //END ASSIGN COMMITTEE

        $("#deleteLedgerModal").modal();
        $('.modal-body').html("");
        $('.modal-body').append("<label>DATE:</label> " + "<?=date('d-m-Y'); ?>" + "<br/>");
        if(nameL)
            $('.modal-body').append("<label>LEDGER NAME:</label> " +nameL+ "<br/>");
        if(under)
            $('.modal-body').append("<label>UNDER GROUP:</label> " + under + "<br/>");
        if (opAmt) 
            $('.modal-body').append("<label>OPENING BALANCE AMOUNT:</label> " + opAmt + "<br/>");
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
        }
    }

    //INPUT KEYPRESS
    $(':input').on('keypress change', function() {
        var id = this.id;
        try {$('#' + id).css('border-color', "#000000");}catch(e) {}

    });

    function GetDataOnDate() {
        document.getElementById('date').value = ledgerDate;
        document.getElementById('load').value = "DateChange";
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

    function goback(){
        window.history.back();
    }

    nameL.addEventListener("blur", function () {
        $('#nameL').attr("data-toggle", "");
        $('#DropdownLedgers').hide();
    });


</script>