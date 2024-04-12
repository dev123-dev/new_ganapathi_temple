<style type="text/css">
   #multichequepayment{
    background-color: transparent;
    background-repeat: no-repeat;
    border: none;
    cursor: pointer;
    overflow: hidden;
    outline: none; 
    text-decoration: underline;
    color:#800000;
   }
</style>
<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
<div class="container-fluid container">
    <div class="row form-group">
        <div class="col-lg-2 col-md-10 col-sm-10 col-xs-8">               
            <h3><b>Payment For</b></h3>
        </div>
        <div class="col-lg-3 col-md-10 col-sm-10 col-xs-8">
            <form id="frmCommitteeChange" action="<?=site_url()?>finance/Payment" method="post">
                <select id="CommitteeId" name="CommitteeId" class="form-control" style="margin-left:-40px; margin-top:8px;" onChange="onCommitteeChange();" autofocus>
                  <?php   if(!empty($committee)) {
                      foreach($committee as $row1) { 
                        if($row1->COMP_ID == $compId) { ?> 
                          <option value="<?php echo $row1->COMP_ID;?>" selected><?php echo $row1->COMP_NAME;?></option>
                        <?php } else { ?> 
                          <option value="<?php echo $row1->COMP_ID;?>"><?php echo $row1->COMP_NAME;?></option>
                      <?php } } } ?>
                </select>
                 <input type="hidden" name="todayDateVal" id="todayDateVal">
            </form>               
        </div>
        <div class="col-lg-5 col-md-10 col-sm-10 col-xs-8">           
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4" style = "padding-top:10px;">
            <a style="text-decoration:none;cursor:pointer;pull-right;" href="<?=site_url()?>finance/Payment" title="Refresh"><img style="width:24px; height:24px" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
        </div>
    </div>
    <form id="frmPayment" action="<?=site_url()?>finance/addPaymentTrans" method="post" enctype="multipart/form-data"
        accept-charset="utf-8">
        <div class="row form-group">
            <div class="control-group col-md-4 col-lg-4 col-sm-4 col-xs-6">               
                <label>Voucher No:</label><input type="text" id="countNoP" style="background: transparent; border: none; width: 50%;" name="countNoP" value="" readonly >
            </div>
            <div class="control-group col-lg-2 col-md-3 col-sm-4 col-xs-6">               
                <div class="input-group input-group-sm">
                    <input autocomplete="" name= "todayDate" id="todayDate" type="text"  class="form-control todayDate2"  onchange="GetDataOnDate(this.value)" placeholder="dd-mm-yyyy" readonly = "readonly" autofocus/>
                    <div class="input-group-btn">
                        <button class="btn btn-default todayDate" type="button">
                            <i class="glyphicon glyphicon-calendar"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row form-group">
            <div class="control-group col-md-4 col-lg-4 col-sm-4 col-xs-6">
                <label>Account: <span style="color:#800000;">*</span></label>
                <select id="aidP"  class="form-control" name="aidP" style="height: 30px;width:100%" onChange="AccountChange();">
                    <option value="">Select Account</option>
                    <?php   if(!empty($account)) { 
                        foreach($account as $row1) { ?> 
                            <?php if($_SESSION['aidSes'] == $row1->FGLH_ID) { ?>
                                <option value="<?php echo $row1->FGLH_ID;?>|<?php echo $row1->BALANCE;?>|<?php echo $row1->FGLH_NAME;?>|<?php echo $row1->FGLH_PARENT_ID;?>|<?php echo str_replace("'","\'",$row1->BANK_NAME);?>|<?php echo str_replace("'","\'",$row1->BANK_BRANCH);?>" selected><?php echo $row1->FGLH_NAME;?></option>
                            <?php } else { ?>
                            <option value="<?php echo $row1->FGLH_ID;?>|<?php echo $row1->BALANCE;?>|<?php echo $row1->FGLH_NAME;?>|<?php echo $row1->FGLH_PARENT_ID;?>|<?php echo str_replace("'","\'",$row1->BANK_NAME);?>|<?php echo str_replace("'","\'",$row1->BANK_BRANCH);?>"><?php echo $row1->FGLH_NAME;?>  
                            </option>
                        <?php } ?>
                    <?php } } ?>
                </select> 
                <label for="abid" value="">Cur Bal :
                    <span id="abid"></span><span id="bdr"></span>
                </label>
            </div>
            <div class="control-group col-md-4 col-lg-4 col-sm-4 col-xs-6">
                <label>Ledger: <span style="color:#800000;">*</span></label>
                <select id="lidP" class="form-control" name="lidP" style="height: 30px;width:100%" onChange="LedgerChange();">
                    <option value="">Select Ledger</option>
                    <?php   if(!empty($ledger)) {
                        foreach($ledger as $row1) { ?> 
                             <?php if($_SESSION['lidSes'] == $row1->FGLH_ID) { ?>
                                <option value="<?php echo $row1->FGLH_ID;?>|<?php echo $row1->BALANCE;?>|<?php echo $row1->FGLH_NAME;?>|<?php echo $row1->TYPE_ID;?>" selected><?php echo $row1->FGLH_NAME;?></option>
                            <?php } else { ?>
                                <option value="<?php echo $row1->FGLH_ID;?>|<?php echo $row1->BALANCE;?>|<?php echo $row1->FGLH_NAME;?>|<?php echo $row1->TYPE_ID;?>"><?php echo $row1->FGLH_NAME;?></option>
                            <?php } ?>
                        <?php } } ?>
                    </select>
                    <label for="lbid" value="" >Cur Bal:</label>
                    <span id="lbid"></span><span id="ldr"></span>          
                </div>
            </div>

            <div class="row form-group" style="display: none;" id="pettycash">
                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                    <label for="comment">Please Select corresponding Bank connected to this payment <span style="color:#800000;">*</span></label></br>
                </div>
                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                              <tr>
                                <th></th>
                                <th>Bank</th>
                                <th>Ledger Name</th>
                                <th>Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                              <?php foreach($pettyCashData as $result) { ?>
                                    <tr>
                                        <td><center><input type="checkbox" name="<?php echo $result->FGLH_ID; ?>" id="<?php echo $result->FGLH_ID; ?>" onchange="GetUnselect('<?php echo $result->FGLH_ID; ?>','<?php echo $result->AMOUNT; ?>')" class="sel" /></center></td>
                                        <td class="Bank"><?php echo $result->FGLH_NAME; ?></td>
                                        <td><?php echo $result->OTHER_LEDGER_NAME; ?></td>
                                        <td class="amount text-right"><?php echo $result->AMOUNT; ?></td>
                                    </tr>
                                <?php } ?>
                                <input type="hidden" name="selectedId" id="selectedId" value=""/>
                                <input type="hidden" name="selectedIdsAmt" id="selectedIdsAmt" value=""/>
                                </tbody> 
                         </table>
                    </div>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-6">              
                    <label for="comment">Amount <span id="selectedAmt" style="color:#800000;">*</span></label></br>
                    <input type="text" class="form-control amtsP" name="amtsP" id="amtsP" value="<?php if(isset($_SESSION['amtsSes'])) echo $_SESSION['amtsSes']?>" placeholder="" autocomplete="off" min="0" style="width:100%" />                
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-6">
                    <label for="comment">Favouring Name <span style="color:#800000;">*</span></label></br>
                    <input type="text" class="form-control" name="favouring" id="favouring" placeholder="" value="<?php if(isset($_SESSION['favSes'])) echo $_SESSION['favSes']?>" autocomplete="off" min="0" style="width:100%" />
                </div>
            </div>
            
            <div class="mode" id="mode" style="display:none;">
                <div class="row form-group">
                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-6" > 
                        <label for="comment">Payment Method</label></br>
                        <select id="paymentmethod" name="paymentmethod" style="height: 30px;width:100%">
                          <option value="Cheque">Cheque</option>
                      </select> 
                  </div>
              </div>
              <div class="row form-group">
                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-6" >
                    <label for="comment">Cheque No <span style="color:#800000;">*</span></label></br>
                    <select id="rid" name="rid" style="height: 30px;width:100%">
                      <option value="">Select Cheque</option>
                      <?php   if(!empty($range)) {
                          foreach($range as $row1) { ?> 

                          </option>
                      <?php } } ?>
                  </select> 
              </div>
              <div class="col-lg-2 col-md-12 col-sm-12 col-xs-6" >
                <label for="comment">Cheque Date <span style="color:#800000;">*</span></label></br>
                <div class="input-group input-group-sm">
                  <input autocomplete="" name= "chequeDate" id="chequeDate" type="text" value="" class="form-control todayDate2"  onchange="GetDataOnDate(this.value)" placeholder="dd-mm-yyyy" readonly = "readonly" />
                  <div class="input-group-btn">
                      <button class="btn btn-default todayDate" type="button">
                        <i class="glyphicon glyphicon-calendar"></i>
                    </button>
                </div>
                </div>
        </div>
    </div> 
</div>
<div class="row form-group">
    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-6" >
        <label for="comment">Narration </label>
        <textarea class="form-control" rows="5" name="naration" onkeyup="alphaonlypurpose(this)" id="naration" placeholder="" style="width:100%;height:100%;font-weight: bold;font-size:15px; resize:none;"><?php if(isset($_SESSION['narationSes'])) echo $_SESSION['narationSes']?></textarea>
    </div>
</div>
<div id="multicheque"  class="container-fluid container multicheque" style=" display:none;">
          <input type="hidden" name="bankfglhid" id="bankfglhid" value="">
           <input type="hidden" name="FGLH_NAME" id="FGLH_NAME" value="">
           <input type="button" name="multichequepayment" id="multichequepayment" value="Add cheque to the bank" onclick="cheqfunc()"></input>
</div>
<div class="row form-group">
    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-6 text-right" >
        <input type="button" class="btn btn-default btn-md custom" value="Submit" onclick="validatePayment()">
    </div>
</div>
</div>
</form>
<form>
    
</form>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="paymentModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Payment Preview</h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer text-left" style="text-align:left;">
                <label>Are you sure you want to save..?</label>
                <br/>
                <button type="button" style="width: 8%;" class="btn " onclick="PrintSubmit()">Yes</button>
                <button type="button" style="width: 8%;" class="btn " data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div> 

<!-- Modal -->
<div class="modal fade" id="contraModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 style="font-weight:600;" class="modal-title text-center">Auto Contra (Insufficient Fund Petty Cash) </h4>
            </div>
            <div class="modal-body">
                <div style="clear:both;" class="form-group">
                    <div style="clear:both;" class="form-group">
                        <div class="form-group col-lg-12 col-md-6 col-sm-6 col-xs-6">
                            <label>Voucher No: </label><input type="text" id="countNoC" style="background: transparent; border: none; width: 50%;" name="countNoC" value="<?php echo $receiptFormatContra;?>"readonly >
                        </div>
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                         <select id="aidC" class="form-control go" name="aidC" style="height: 30px;width:100%" onChange="AccountChange1();">
                            <option value="">Select Account</option>
                            <?php   if(!empty($account)) {
                                foreach($account as $row1) { 
                                    if( $row1->FGLH_ID != 27) {?> 
                                        <option value="<?php echo $row1->FGLH_ID;?>|<?php echo $row1->BALANCE;?>|<?php echo $row1->FGLH_NAME;?>|<?php echo $row1->FGLH_PARENT_ID;?>|<?php echo $row1->BANK_NAME;?>|<?php echo $row1->BANK_BRANCH;?>"><?php echo $row1->FGLH_NAME;?></option>
                            <?php } } } ?>
                        </select> 
                        <label for="contraCurbal" value="">Cur Bal:
                            <span id="contraCurbal"></span><span> Dr</span>
                        </label>
                    </div>
                    
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <label for="inputLimit" ><span style="font-weight:600;">To: Petty Cash </span></label>
                    </div>
                </div>
                <div style="clear:both;" class="form-group">
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                       <label for="comment">Amount <span style="color:#800000;" >*</span></label></br>
                        <input type="number" class="form-control amtsC" name="amtsC" id="amtsC" placeholder="" autocomplete="off" min="0" style="width:100%;">
                    </div>
                    
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <label for="comment" >Favouring Name <span style="color:#800000;">*</span></label></br>
                        <input type="text" class="form-control" name="favouringC" id="favouringC" value="Ourselves" placeholder="" autocomplete="off" min="0" style="width:100%;">
                    </div>
                </div>
                
                <div style="clear:both;" class="form-group">
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <label for="comment">Payment Method</label></br>
                        <select id="paymentmethodC" name="paymentmethodC" style="height: 30px;width:100%">
                            <option value="Cheque">Cheque</option>
                        </select> 
                    </div>
                </div>

                <div style="clear:both;" class="form-group">
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <label for="comment">Cheque No <span style="color:#800000;">*</span></label></br>
                        <select id="ridC" name="ridC" style="height: 30px;width:100%">
                            <option value="">Select Cheque</option>
                            <?php   if(!empty($range)) {
                                foreach($range as $row1) { ?> 
                                    
                                </option>
                            <?php } } ?>
                        </select>
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <label for="seva"><span style="font-weight:600;">Cheque Credited Date </span><span style="color:#800000;">*</span></label>
                        <div class="input-group input-group-sm">
                            <input autocomplete="" name= "todayDateC" id="todayDateC" type="hidden" value="<?=date('d-m-Y'); ?>">
                            <input name="chequedateC" id="chequedateC" type="text" value="" class="form-control chequedateC" placeholder="dd-mm-yyyy" />
                            <div class="input-group-btn">
                              <button class="btn btn-default todayDateC" type="button">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </button>
                            </div>
                        </div>
                    </div>                    
                </div>
                <div style="clear:both;" class="form-group">
                    <div class="form-group col-lg-12 col-md-6 col-sm-6 col-xs-6">
                        <label for="comment">Narration </label>
                        <textarea class="form-control" rows="5" name="narationC" id="narationC" placeholder="" style="width:100%;height:100%;resize:none;"></textarea>
                    </div>
                </div>
            </div>

                <!-- HIDDEN -->
            <div class="modal-footer">
                <button type="button" id="saveC" onclick="validatePettycash()" class="btn btn-default">SAVE</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
            </div>
           
        </div>
    </div>
</div>

</div>

 <form id="multichequeform" action="" method="post">
    <input type="hidden" id="bankcheque" name="bankcheque" />
     <input type="hidden" id="bank_fglh_name" name="bank_fglh_name" />
</form>
<script type="text/javascript">
     function cheqfunc(){
         let bankcheque=$('#bankfglhid').val();
         let bank_fglh_name =$('#FGLH_NAME').val();
          $('#bankcheque').val(bankcheque);
          $('#bank_fglh_name').val(bank_fglh_name);
          $('#multichequeform').attr('action','<?=site_url()?>finance/chequeDetailsPayment');
          $('#multichequeform').submit();
     }


     $(document).ready(function(){
        let arr1 = "<?php echo @$receiptFormatBank; ?>";  
        let arr2 = "<?php echo @$receiptFormatPc; ?>" ; 
        if(document.getElementById("aidP").value!=""){
        let acc1 = document.getElementById("aidP").value.split("|");  
 
        if(acc1[3] == 9){
            document.getElementById('mode').style.display = 'block';
            document.getElementById('countNoP').value = arr1;
        }
        else{
            document.getElementById('mode').style.display = 'none';
            document.getElementById('countNoP').value = arr2;
        }
        if(acc1[0] == 27){
            document.getElementById('pettycash').style.display = 'block';
        }
        else{
            document.getElementById('pettycash').style.display = 'none';
        }
        $('#abid').html(acc1[1]);
       
        if (acc1[1]>=0) {
          $('#bdr').html(" Dr");
        }else{
          $('#bdr').html(" Cr");
        }
        $('#rid').html("");
        }
        if(document.getElementById("lidP").value!=""){
        let lid1 = document.getElementById("lidP").value.split("|");  
        $('#lbid').html(lid1[1]);
        if (lid1[3]=='A' || lid1[3]=='E') {
            if (lid1[1]>=0) {
                $('#ldr').html("Dr");
            }else{
                $('#ldr').html("Cr");
            }
        }else{
            if (lid1[1]>=0) {
                $('#ldr').html("Cr");
            }else{
                $('#ldr').html("Dr");
            }
        }
        }      
    });

    $(document).ready(function(){
        $('.sel').click(function() {
            $('.sel').not(this).prop('checked', false);
        });
    });
    function alphaonlypurpose(input) {
      var regex=/[^-a-z-0-9 ]/gi;
      input.value=input.value.replace(regex,"");
    }
    function validatePayment() {
        let count = 0;
        let aidP = $('#aidP').val().split("|");
         if (document.getElementById("todayDate").value != "") {
          $('#todayDate').css('border-color', "#000000");
        } else {
          $('#todayDate').css('border-color', "#FF0000");
         ++count;
        }
        if (document.getElementById("aidP").value != "") {
            $('#aidP').css('border-color', "#000000");
        } else {
            $('#aidP').css('border-color', "#FF0000");
            ++count;
        }
        if (document.getElementById("lidP").value != "") {
            $('#lidP').css('border-color', "#000000");
        } else {
            $('#lidP').css('border-color', "#FF0000");
            ++count;
        }
        if (document.getElementById("amtsP").value == "" ) {
            $('#amtsP').css('border-color', "#FF0000");
            ++count;
        } else {
            $('#amtsP').css('border-color', "#000000");
        }
         if (document.getElementById("favouring").value != "") {
            $('#favouring').css('border-color', "#000000");
        } else {
            $('#favouring').css('border-color', "#FF0000");
            ++count;
        }
        if (document.getElementById("selectedId").value == "" && aidP[3]==8) {
            alert('Please select atleast one checkbox');
            return false;
        }

        if(aidP[3]!=8)
        {
            if (document.getElementById("rid").value != "") {
                $('#rid').css('border-color', "#000000");
            } else {
                $('#rid').css('border-color', "#FF0000");
                ++count;
            }
            if (document.getElementById("chequeDate").value != "") {
                $('#chequeDate').css('border-color', "#000000");
            } else {
                $('#chequeDate').css('border-color', "#FF0000");
                ++count;
            }
            if (document.getElementById("paymentmethod").value != "") {
                $('#paymentmethod').css('border-color', "#000000");
            } else {
                $('#paymentmethod').css('border-color', "#FF0000");
                ++count;
            }

        }
        if (count != 0) {
            alert("Information", "Please fill required fields", "OK");
            return false;
        }

        let lidP = $('#lidP').val().split("|");
        let countNoP = $('#countNoP').val();
        let amtsP = $('#amtsP').val();
        let todayDate = $('#todayDate').val();
        let naration=$('#naration').val(); 
        let favouring=$('#favouring').val();
        if(aidP[3]!=8)
        {
            let rid= $('#rid').val().split("|");
            let chequeDate = $('#chequeDate').val();
            let paymentmethod = $('#paymentmethod').val();
        }


        //pettycash payment validation 
        // if(aidP[3] == 8){
        //     if(parseInt($('#selectedIdsAmt').val()) < amtsP && parseInt(amtsP)<parseInt(aidP[1])){      //new change
        //         alert("Information", "Insufficient Balance", "OK");
        //         return;
        //     }
        // }


        
        if(aidP[3] != 8){
            //IF NO CHEQUES AVAILABLE
            if (document.getElementById("rid").value == "") {
                alert('No Cheques Available In This Bank');
                return false;
            }
            //For amount greater than current account balance OR if current balance is less than amount ->Bank
            
            // if(parseInt(aidP[1])<= 0 || parseInt(aidP[1])<amtsP){
            //     alert("Information", "Insufficient Balance In This Particular Account", "OK");
            //     return false;
            // }  //These lines are commented to go ahead and make a Payment Voucher inspite of no balance
        }
        //let committeeSelected = $('#CommitteeId').val();
         $('#selCommittee').val($('#CommitteeId').val());
        let committeeSelected = $('#CommitteeId option:selected').html();
        //For Contra modal
        if((aidP[0]==27 && parseInt(aidP[1])<parseInt(amtsP)) || ( aidP[0]==27 && parseInt($('#selectedIdsAmt').val()) < amtsP && parseInt(amtsP)<parseInt(aidP[1]))){
                $('#contraModal').modal();
        }
        else{
            $(' #paymentModal .modal-body').html("");
            $('#paymentModal .modal-body').append("<label>VOUCHER NO:</label> " + countNoP +"&emsp;&emsp;&emsp;&emsp;<label>DATE:</label> "  + todayDate + "<br/>");
            if(aidP)
                $('#paymentModal .modal-body').append("<label>ACCOUNT:</label> " + aidP[2].replace("'","'") + "<br/>");
            if(lidP)
                $('#paymentModal .modal-body').append("<label>LEDGER:</label> " + lidP[2] + "<br/>");
            if (amtsP) 
                $('#paymentModal .modal-body').append("<label>AMOUNT:</label> " + amtsP + "<br/>");
            if (favouring) 
                $('#paymentModal .modal-body').append("<label>FAVOURING NAME:</label> " + favouring + "<br/>");
            if (committeeSelected) 
                $('#paymentModal .modal-body').append("<label>COMMITTEE:</label> " + committeeSelected + "<br/>");
            if(aidP[3]!=8)
            {
                let rid= $('#rid').val().split("|");
                let chequeDate = $('#chequeDate').val();
                let paymentmethod = $('#paymentmethod').val();

                if (rid) 
                    $('#paymentModal .modal-body').append("<label>CHEQUE NO:</label> " + rid[0] + "<br/>");
                if (chequeDate) 
                    $('#paymentModal .modal-body').append("<label>CHEQUE DATE:</label> " + chequeDate + "<br/>");
                if (paymentmethod) 
                    $('#paymentModal .modal-body').append("<label>PAYMENT METHOD:</label> " + paymentmethod + "<br/>");
            }
            if (naration) 
                $('#paymentModal .modal-body').append("<label>NARRATION:</label> " + naration + "<br/>");
            $("#paymentModal").modal();
        }
    }
    //INPUT KEYPRESS
    $(':input').on('keypress change', function() {
        var id = this.id;
        try {$('#' + id).css('border-color', "#000000");}catch(e) {}

    });


    $('#chequedateC').val("");
    $('#chequedateC').css('border-color','black');
    $('#chequedateC').css('z-index','9999');
    $( ".chequedateC" ).datepicker({
        dateFormat: 'dd-mm-yy',
        onSelect: function (selectedDate) {
            $('#chequedateC').css('border-color','black');
        } 
    });
    
    $('.todayDateC').on('click',function() {
        $( ".chequedateC" ).focus();
    });


    function PrintSubmit(){

        let aidP = $('#aidP').val();
        let lidP = $('#lidP').val();
        let countNoP = $('#countNoP').val();
        let amtsP = $('#amtsP').val();
        let todayDate = $('#todayDate').val();
        let naration=$('#naration').val(); 
        let favouring=$('#favouring').val();
        let paymentmethod = $('#paymentmethod').val();
        let rid= $('#rid').val();
        let chequeDate = $('#chequeDate').val();
        let aidP1 = $('#aidP').val().split("|");
        let lidP1 = $('#lidP').val().split("|");
        let chkno= $('#rid').val();
        let selectedId = $('#selectedId').val();
        let committeeSelected = $('#CommitteeId').val();
        if(chkno == null)
            paymentmethod = "Cash";
        else {
            rid1 = $('#rid').val().split("|");
            chkno = rid1[0];
        }

        let url = "<?=site_url()?>finance/addPaymentTrans";
        $.post(url, { 'aidP': aidP, 'lidP': lidP, 'countNoP': countNoP,'amtsP': amtsP, 'todayDate': todayDate, 'naration': naration, 'favouring': favouring, 'rid': rid, 'chequeDate': chequeDate, 'paymentmethod': paymentmethod,'selectedId':selectedId,'selCommittee':committeeSelected}, function (e) {
console.log(e)
        e1 = e.split("|")
        if (e1[0] == "success"){
            let url = "<?php echo site_url(); ?>generatePDF/create_PaymentSession";
            $.post(url,{'aidP':aidP1[2],'lidP':lidP1[2],'countNoP':countNoP,'todayDate':todayDate,'favouring':favouring,'naration':naration,'amtsP':amtsP, 'paymentmethod': paymentmethod , 'chequeDate':chequeDate,'chkno':chkno,'bankName':aidP1[4],'branchName':aidP1[5]}, function(data) {

            let url2 = "<?php echo site_url(); ?>generatePDF/create_PaymentPrint";
                if(data == 1) {
                    downloadClicked = 0;
                    var win = window.open(
                      url2,
                      '_blank'
                    );
                    setTimeout(function(){ win.print();}, 1000); //setTimeout(function(){ win.close();}, 5000);
                    location.href = "<?=site_url();?>finance/Payment";
                }
            })
        }
        else
            alert("Something went wrong, Please try again after some time");
        });
    }

    function AccountChange(){
        let acc1 = document.getElementById("aidP").value.split("|");
        let arr1 = "<?php echo @$receiptFormatBank; ?>";  
        let arr2 = "<?php echo @$receiptFormatPc; ?>" ; 
        //console.log(acc1)
        if(acc1[3] == 9){
            document.getElementById('mode').style.display = 'block';
            document.getElementById('multicheque').style.display = 'block';
            document.getElementById('countNoP').value = arr1;
        }
        else{
            document.getElementById('mode').style.display = 'none';
             document.getElementById('multicheque').style.display = 'none';
            document.getElementById('countNoP').value = arr2;
        }    
        if(acc1[3] == 9){
            document.getElementById('mode').style.display = 'block';
            document.getElementById('multicheque').style.display = 'block';
        }
        else{
            document.getElementById('mode').style.display = 'none';
             document.getElementById('multicheque').style.display = 'none';
        }
        if(acc1[3] == 8){
            document.getElementById('pettycash').style.display = 'block';
        }
        else{
            document.getElementById('pettycash').style.display = 'none';
        }
        // // let select = document.getElementById('aidC').value;
        // if(document.getElementById('aidC').value==""){
        //     document.getElementById('abid').value = "";
        // }
        console.log("acc1[1]",acc1[1])
        if(acc1 ==''){
             $('#abid').html("");
               $('#bdr').html("");
        }else{
            $('#abid').html(acc1[1]);
            if (acc1[1]>=0) {
              $('#bdr').html(" Dr");
            }else{
              $('#bdr').html(" Cr");
            }
        }
        // $('#abid').html(acc1[1]);
        
        $('#rid').html("");
        $('#selectedAmt').html("*");
        $('#selectedId').val("");
        $('#amtsP').val("");
        $(".sel").each(function() {
            document.getElementById(this.id).checked = false;               
        }); 

        arr = <?php echo @$range; ?>; 
        acNo = acc1[0];
   
        for (let i = 0; i < arr.length; ++i) {
            if (arr[i]['FGLH_ID'] == acNo){
                $('#rid').append('<option value="' + arr[i]['CHEQUE_NO'] +"|" + arr[i]['FCD_ID'] + "|" + arr[i]['FCBD_ID'] +'">' + arr[i]['CHEQUE_NO'] + '</option>');
            }
        }
        if(acc1[3] == 8){
            if($('#selectedId').val()!=""){
                document.getElementById('amtsP').readOnly = false;
            }else{
                document.getElementById('amtsP').readOnly = true;
            }
        }else {document.getElementById('amtsP').readOnly = false;}
    }

     $(function() {
        var selectedValue = ''; // declare variable here

        // on drop down change
        $('#aidP').change(function() {
            selectedValue = $(this).val().split("|"); // store value in variable
            $('#bankfglhid').val(selectedValue[0]); // update on change
             $('#FGLH_NAME').val(selectedValue[2]); 
        });

      
    });
      

    function AccountChange1(){
       
        let accC = document.getElementById("aidC").value.split("|"); 
        // console.log("accC[1]",accC[1])
        $('#ridC').html("");
        $('#contraCurbal').html(accC[1]);

        arr = <?php echo @$range; ?>; 
        acNo = accC[0];
        for (let i = 0; i < arr.length; ++i) {
            if (arr[i]['FGLH_ID'] == acNo){
                $('#ridC').append('<option value="' + arr[i]['CHEQUE_NO'] +"|" + arr[i]['FCD_ID'] + "|" + arr[i]['FCBD_ID'] +'">' + arr[i]['CHEQUE_NO'] + '</option>');
            }
        }
    }

    function LedgerChange(){
        let acc1 = document.getElementById("lidP").value.split("|");  
        //let acc2 = abs();
        //$('#lbid').html(Math.abs(acc1[1]));
        if(acc1 ==''){
             $('#lbid').html("");
               $('#ldr').html("");
        }else{
            $('#lbid').html(acc1[1]);
            if (acc1[3]=='A' || acc1[3]=='E') {
                if (acc1[1]>=0) {
                    $('#ldr').html(" Dr");
                }else{
                    $('#ldr').html(" Cr");
                }
            }else{
                if (acc1[1]>=0) {
                    $('#ldr').html(" Cr");
                }else{
                    $('#ldr').html(" Dr");
                }
            }
        }


        // $('#lbid').html(acc1[1]);
        // $('#ldr').html(" Dr");
    }

    function validatePettycash()
    {
     
        let countC = 0;


        if (document.getElementById("aidC").value != "") {
            $('#aidC').css('border-color', "#000000");
        } else {
            $('#aidC').css('border-color', "#FF0000");
            ++countC;
        }

        if (document.getElementById("amtsC").value == "" ) {
            $('#amtsC').css('border-color', "#FF0000");
            ++countC;
        } else {
            $('#amtsC').css('border-color', "#000000");
        }
        if (document.getElementById("favouringC").value != "") {
            $('#favouringC').css('border-color', "#000000");
        } else {
            $('#favouringC').css('border-color', "#FF0000");
            ++countC;
        }
        if(ridC!=""){
            if (document.getElementById("ridC").value != "") {
                $('#ridC').css('border-color', "#000000");
            } else {
                $('#ridC').css('border-color', "#FF0000");
                ++countC;
            }
        }
        if (document.getElementById("chequedateC").value != "") {
            $('#chequedateC').css('border-color', "#000000");
        } else {
            $('#chequedateC').css('border-color', "#FF0000");
            ++countC;
        }
        if (document.getElementById("paymentmethodC").value != "") {
            $('#paymentmethodC').css('border-color', "#000000");
        } else {
            $('#paymentmethodC').css('border-color', "#FF0000");
            ++countC;
        }
        if (countC != 0) {
            alert("Information", "Please fill required fields", "OK");
            return false;
        }
        else{

            let count = 0;
            let aidC  = $('#aidC').val();
            let acidC  = $('#aidP').val();
            let countNoC  = $('#countNoC ').val();
            let amtsC  = $('#amtsC ').val();
            let todayDateC = $('#todayDateC').val();
            let narationC=$('#narationC').val(); 
            let favouringC=$('#favouringC').val();
            let ridC= $('#ridC').val();
            let chequedateC = $('#chequedateC').val();
            let paymentmethodC = $('#paymentmethodC').val();
           
            let aidC1=aidC.toString();
            let acidC1=acidC.toString();
            let ridC1=ridC.toString();

            //for session
            let aidP = $('#aidP').val().split("|");
            let lidP = $('#lidP').val().split("|");
            let amtsP = $('#amtsP').val();
            let favouring=$('#favouring').val();
            let naration=$('#naration').val(); 
            let committeeSelected = $('#CommitteeId').val();
           

             let url = "<?=site_url()?>finance/addContraTrans";
             $.post(url, { 'aidC': aidC1, 'acidC': acidC1, 'countNoC': countNoC,'amtsC': amtsC, 'todayDate': todayDateC, 'naration': narationC, 'favouring': favouringC, 'rid': ridC1, 'chequeDate': chequedateC, 'paymentmethod': paymentmethodC,'from':'Payment','aidSes':aidP[0],'lidSes':lidP[0],'amtsSes':amtsP,'favSes':favouring,'narationSes':naration,'selCommittee':committeeSelected}, function (e) {

            e1 = e.split("|")
            if (e1[0] == "success"){
                location.href = "<?=site_url();?>finance/Payment?unsetCall=No";
            }
            else
                alert("Something went wrong, Please try again after some time");
            });
        }
    }


    function GetDataOnDate() {
    }


    /////////////code for checking the logged user whether its admin or manager for backdate entry start//////// 
    let loggedUser = '<?php echo $loggedUser ?>';
     var currentTime = new Date()
     var startDate;
     var endDate;
     let new_year = '<?php echo $FinancialYear ?>';
     
    if(loggedUser == 31 || loggedUser == 26 ){
      let startYear = Number(new_year.split("-")[0]) - 1;
     let endYear = Number(new_year.split("-")[1]);
      startDate = "01-04-"+startYear ;
      endDate = "31-03-"+endYear;
    }else{
       startDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
      endDate =  new Date(); // one day before next month
    }
   /////////////code for checking the logged user whether its admin or manager for backdate entry end////////  



    var currentTime = new Date()
    var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
    var maxDate =  new Date(); // one day before next month
    $( ".todayDate2" ).datepicker({ 
    minDate: startDate, 
    maxDate: endDate,
    'yearRange': "2007:+50",
    dateFormat: 'dd-mm-yy',
    changeMonth:true,
    changeYear:true
    });

    $('.todayDate').on('click', function() {
        $( ".todayDate2" ).focus();
    })



    $('.amtsP').keypress(function(event) {
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


    function GetUnselect(id,accuAmt) {
        arr1 = <?php echo @$account1; ?>;

        var selId = "",selAmt="";
        var checkInput = document.getElementsByClassName("sel");
        if($('#' + id).prop('checked') == true) {
            for(var i = 0; i < checkInput.length; i++) {
                if(checkInput[i].checked == true) {
                    selId = checkInput[i].id;
                    selAmt = accuAmt;
                }
            }
            document.getElementById('selectedId').value = selId;
            document.getElementById('selectedIdsAmt').value = selAmt;
        } else {
            for(var i = 0; i < checkInput.length; i++) {
                if(checkInput[i].checked == true) {
                    selId = checkInput[i].id ;
                    selAmt = accuAmt;
                }
            }
            document.getElementById('selectedId').value = selId;
            document.getElementById('selectedIdsAmt').value = selAmt;
        }
        for (let i = 0; i < arr1.length; ++i) {
            if (arr1[i]['LEDGER_FGLH_ID'] == selId) {
                document.getElementById('selectedId').value = arr1[i]['BANK_FGLH_ID'];
            }
        }

        $('#selectedAmt').html("* ("+$('#selectedIdsAmt').val()+")");
        let acc1 = document.getElementById("aidP").value.split("|");    
        if(acc1[3] == 8){
            if($('#selectedId').val()!=""){
                document.getElementById('amtsP').readOnly = false;

            }else{
                document.getElementById('amtsP').readOnly = true;
                document.getElementById('amtsP').value="";
            }
        }
    }

    function onCommitteeChange(){
        let checkTodayDate = document.getElementById('todayDate').value;
        document.getElementById('todayDateVal').value = checkTodayDate;
        $('#frmCommitteeChange').submit(); 
    }
</script>