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
<div class="container-fluid container" style="font-size: 16px;">
    <div class="row form-group">
        <div class="col-lg-12 col-md-10 col-sm-10 col-xs-8">               
            <h3><b>Shashwath Seva Corpus Additional Corpus</b></h3>
        </div>
        <div class="col-lg-10 col-md-10 col-sm-2 col-xs-8"> 
            <a  style=" "class="pull-right" style="border:none; outline:0; "  href="<?php echo $base_url ?>" title="Back" ><img style="border:none; outline: 0; width:24px;margin-top: -80px;" src="<?php echo base_url();?>images/back_icon.svg"></a>
        </div>
    </div>
    
        <div class="row form-group">
            <div class="control-group col-md-4 col-lg-6 col-sm-4 col-xs-6">               
                <label>Receipt Name : &nbsp;</label><b> <span><?php echo $nameph ?></span></b>
            </div>
            <div class="control-group col-md-4 col-lg-6 col-sm-4 col-xs-6">               
                <label>Receipt No : &nbsp;</label><b><?php echo $receipt_number ?></span></b>
            </div>
           
        </div>
     
        <div class="row form-group">
            <div class="control-group col-md-4 col-lg-6 col-sm-4 col-xs-6">
                <label>Seva Name : &nbsp;</label><b><span><?php echo $sevaname ?></span></b>
            </div>
             <div class="control-group col-md-4 col-lg-6 col-sm-4 col-xs-6">
                    <label>Deity Name : &nbsp;</label><b><span><?php echo $deityIdName ?></span></b>
             </div>
        </div>
        <div class="row form-group">  
            <div class="control-group col-md-4 col-lg-12 col-sm-4 col-xs-6">
                <label>Additional Corpus :&nbsp;</label><b><span ><?php echo $corpusraiseamt ?></span></b>   
                
             </div>   
        </div>
        <div class="row form-group">
             <div class="control-group col-md-4 col-lg-4 col-sm-4 col-xs-6">
                 <label>Receipt Book Details : </label>  <input  autocomplete="off" type="text" class = "form_contct2" name="bookreceiptno" id="bookreceiptno" maxlength="5" onkeyup="validNum(this)">          
             </div>
              <div class="control-group col-md-4 col-lg-6 col-sm-4 col-xs-6">
                  
                <div class="input-group input-group-sm form-group col-lg-4 col-md-3 col-sm-4">  
                    <input  type="text" class="form-control adlCrpBookDate" placeholder="dd-mm-yyyy" id="adlCrpBookDate" name="adlCrpBookDate" value="" autocomplete="off" />
                    <div class="input-group-btn">
                        <button class="btn btn-default adlCrpBookDate" id="adlCrpBookDate3" name="adlCrpBookDate3" type="button" >
                            <i class="glyphicon glyphicon-calendar"></i>
                        </button>
                    </div>
                </div>     
             </div>
        </div>

        <div class="row form-group">
            <div class="control-group col-md-4 col-lg-4 col-sm-4 col-xs-6">
                <label>Your Corpus :</label>
                 <input  autocomplete="off" type="text" class = "form_contct2" name="corpus" id="corpus" onkeyup="validNum(this)" >
            </div>
        </div>
       <?php if($members[0]->IS_MANDALI == 1){ ?> 
         <div class="row form-group">
            <div class="control-group col-md-4 col-lg-3 col-sm-4 col-xs-6">
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
            </div>
            
        </div>
     <?php } ?>
       <div class="row form-group">
            <div class="control-group col-md-4 col-lg-12 col-sm-4 col-xs-6">
                <label for="modeOfPayment">Mode Of Payment:
                    <span style="color:#800000;">*</span>
                </label>
            </div>
             <div class="control-group col-md-4 col-lg-3 col-sm-4 col-xs-6">
                <select id="modeOfPayment" name="modeOfPayment" class="form-control">
                    <option value="">Select Payment Mode</option>
                    <option value="Cash">Cash</option>
                    <option value="Cheque">Cheque</option>
                    <option value="Direct Credit">Direct Credit</option>
                    <option value="Credit / Debit Card">Credit / Debit Card</option>
                   <?php if(isset($_SESSION['Authorise'])){ ?>
                        <option value="Transfer">Adjustment</option>
                    <?php } ?>
                </select>
            </div>
       </div>
            
        <div style="margin-top: 10px;display:none;margin-left: -14px;" id="showChequeList">
            <div style="padding-top: 15px;" class="control-group col-md-6 col-lg-2 col-sm-12 col-xs-12">
                <label for="name">Cheque No:
                    <span style="color:#800000;">*</span>
                </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="text" class="form-control form_contct2" id="chequeNo" name="chequeNo" placeholder="" autocomplete="off" >
            </div>

            <div style="padding-top: 15px;" class="control-group col-md-6 col-lg-2 col-sm-12 col-xs-12">
                <label for="rashi">Cheque Date:
                    <span style="color:#800000;">*</span>
                </label>&nbsp;&nbsp;
                <div class="input-group input-group-sm">
                    <input  type="text" id="checkdate" name="checkdate" value="" class="form-control chequeDate3 form_contct2" placeholder="<?=date(" d-m-Y ")?>" autocomplete="off">
                    <div class="input-group-btn">
                        <button class="btn btn-default chequeDate1" type="button">
                            <i class="glyphicon glyphicon-calendar"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div style="padding-top: 15px;clear: both;" class="control-group col-md-6 col-lg-2 col-sm-12 col-xs-12">
                <label for="number">Bank Name:
                    <span style="color:#800000;">*</span>
                </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="text" class="form-control form_contct2" name="bank" id="bank" placeholder="" autocomplete="off">
            </div>
            <div style="padding-top: 15px;" class="control-group col-md-6 col-lg-2 col-sm-12 col-xs-12">
                <label for="nakshatra">Branch Name:
                    <span style="color:#800000;">*</span>
                </label>&nbsp;&nbsp;
                <input type="text" class="form-control form_contct2"  name="branch" id="branch" placeholder="" autocomplete="off">
                 <br>
            </div>
        </div>

        <div style="display:none;" id="showDebitCredit">
            <div class="row form-group">                                    
                <div style="padding-top: 15px;" class="control-group col-md-6 col-lg-2 col-sm-12 col-xs-12">
                    <label for="bank">To Bank: </label>
                     <select id="DCtobank" name="DCtobank" class="form-control">
                            <option value="0">Select Bank</option>
                            <?php foreach($terminal as $result) { ?>
                                <option value="<?=$result->FGLH_ID; ?>">
                                    <?=$result->FGLH_NAME; ?>
                                </option>
                            <?php } ?>
                        </select>   
                </div>
            </div>
             <div class="row form-group">                                    
                <div style="" class="control-group col-md-6 col-lg-4 col-sm-12 col-xs-12">
                    <label for="bank">Transaction Id : </label> <input type="text" class="form-control form_contct2" id="transactionId" placeholder="" name="transactionId">
                      
                </div>
                
            </div>
        </div>
        <div style=" display:none;" id="showDirectCredit">
             <div class="row form-group">                                    
                    <div style="padding-top: 15px;" class="control-group col-md-6 col-lg-3 col-sm-12 col-xs-12">
                        <label for="bank">To Bank: </label>&nbsp;&nbsp;
                            <select id="tobank" name="tobank" class="form-control">
                                <option value="0">Select Bank</option>
                                <?php foreach($terminal as $result) { ?>
                                    <option value="<?=$result->FGLH_ID; ?>">
                                        <?=$result->FGLH_NAME; ?>
                                    </option>
                                <?php } ?>
                            </select>
                    </div>
             </div>
        </div>

         <div class="row form-group" id="showtransfer" style="display: none;" >
      
            <div class="row form-group">
                <div class="control-group col-md-12 col-lg-10 col-sm-12 col-xs-6">
                    <hr style="border-top:1px solid #800000; width: 780px; margin-left: -11px; margin-bottom: 3px;">
                    <div class="control-group col-md-12 col-lg-2 col-sm-12 col-xs-6">

                    </div>

                    <div class="control-group col-md-12 col-lg-4 col-sm-12 col-xs-6">
                        <label for="comment">Ledger </label>
                    </div>

                    <div class="control-group col-md-12 col-lg-2 col-sm-12 col-xs-6 text-center">
                        <label for="comment">Debit </label>
                    </div>
                    <hr style="border-top:1px solid #800000; width:780px; margin-left: -12px;" />
                </div>
            </div>
            <div class="row form-group" style="margin-top: -35px;">
                <div class="control-group col-md-12 col-lg-8 col-sm-12 col-xs-6" id="addNewDiv">
                    <div id="idChildContactDiv_1" class ="row">
                        <div class="control-group col-lg-2 col-md-3 col-sm-3 col-xs-3"  >
                            <select id="type_1" name="type" onchange="changeTransactionType(event,id)" class="form-control label_size" disabled>
                                <option value="from">FROM</option>
                            </select>
                        </div>
                        <div class="control-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <select id="ledger_1" class="form-control ledger" name="ledger" style="width:100%" onChange="getLedgerChange(id)">
                                <option value="">Select Ledger</option>
                                <?php   if(!empty($ledger)) {
                                    foreach($ledger as $row1) { ?> 
                                        <option value="<?php echo $row1->FGLH_ID;?>|<?php echo $row1->BALANCE;?>|<?php echo $row1->FGLH_NAME;?>"><?php echo $row1->FGLH_NAME;?></option>

                                    <?php } } ?>
                                </select>
                                <label for="curBal_1" value="">Cur Bal:
                                    <span id="curBal_1"></span>
                                </label>
                            </div>
                            <div class="control-group col-lg-2 col-md-2 col-sm-4 col-xs-4 right">
                                <input type="text" class="form-control amounts text-right dec" name="number" id="debit_1" autocomplete="off" style="width:100%" onkeyup="getCheckedEditedFields(id)" onkeypress="return validateFloatKeyPress(this,event);" />

                            </div>
                            
                            <div class="control-group col-lg-1 col-md-1 col-sm-1 col-xs-1"> 
                                <a style="text-decoration:none;cursor:pointer;" class="add" id="add_1" onclick="getFinalData()"><img style="width:24px;height:24px" title="Additional Contact Number" src="<?=site_url();?>images/add_icon.svg"/></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row form-group " style="margin-top: -30px;">
                    <div class="control-group col-md-12 col-lg-8 col-sm-12 col-xs-6" >
                        <hr style="border-top:1px solid #800000;width: 255px; margin-left: 27em; margin-bottom: 3px;" />
                        <div class="control-group col-lg-6 col-md-6 col-sm-3 col-xs-3">

                        </div>
                        <div class="control-group col-lg-2 col-md-2 col-sm-12 col-xs-6">                                        
                            <input type="text" id="debitTot" disabled class="text-right" name="" style="width:100% ;background: transparent; border:none;"> 
                        </div>
                        
                    </div>
                </div>
                <hr style="border-top:1px solid #800000;width: 255px;margin-left: 27em; margin-top: -10px;" /> 

                <div class="row form-group" style="margin-top: -20px;">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="comment">Narration </label>
                            <textarea class="form-control" rows="5" name="naration" id="naration" placeholder="" style="width:67%;height:100%;resize:none;"></textarea>
                        </div>
                    </div>
                </div>
           
     </div>
       
        <div class="row form-group">        
           <div class="control-group col-lg-12" style="">
                <label for="comment">Payment Notes:</label>
                <textarea class="form-control" rows="5" style="resize:none; width: 60%" id="paymentNotes" name="paymentNotes"></textarea>
            </div>
        </div>

        <div class="form-group ">
            <input type="button" class="btn btn-default" value="Submit" onclick="return validateCorpus();" />
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>

        
        <input type="hidden" id="namePhone" name="namePhone" value="<?php echo $nameph ?>" />
         <input type="hidden" id="deityIdName" name="deityIdName" value="<?php echo $deityIdName ?>" />
        <input type="hidden" id="corpusCallFrom" name="corpusCallFrom" value="<?php echo $corpusCallFrom ?>"/>
        <input type="hidden" id="ssId" name="ssId"  value="<?php echo $shashid ?>"/>
        <input type="hidden" id="addr2" name="addr2"  value="<?php echo $addr2 ?>"/>
        <input type="hidden" id="sccity" name="sccity"  value="<?php echo $sccity ?>"/>
        <input type="hidden" id="ssstate" name="ssstate"  value="<?php echo $ssstate ?>"/>
        <input type="hidden" id="sccountry" name="sccountry"  value="<?php echo $sccountry ?>"/>
        <input type="hidden" id="addr1" name="addr1"  value="<?php echo $addr1 ?>"/>
        <input type="hidden" id="cpin" name="cpin"  value="<?php echo $cpin ?>"/>
        <input type="hidden" id="sevaname" name="sevaname"  value="<?php echo $sevaname ?>"/>
        <input type="hidden" id="smphone" name="smphone"  value="<?php echo $smphone ?>"/>
       
         <div class="modal fade" id="corpusModal">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                 <div class="modal-header">
                  <h4 class="modal-title">Additional Corpus Preview</h4>
                </div>
                <div class="modal-body">
                </div>
               <div class="modal-footer text-left" style="text-align:left;">
                    <label>Are you sure you want to save..?</label>
                    <br/>
                    <button type="button" id="modalYes" style="width: 8%;" class="btn btn-primary btn-default" onclick="validateCorpus('true')">Yes</button>
                    <button type="button" style="width: 8%;" class="btn btn-default" data-dismiss="modal">No</button>
                </div>

                </div>
              </div>
         </div>
   
</div>
 
      
<script type="text/javascript">
    $('#modeOfPayment').on('change', function () {
        if (this.value == "Cheque") {
            $('#showChequeList').fadeIn("slow");
            $('#showDebitCredit').fadeOut("slow");
            $('#showDirectCredit').fadeOut("slow");
             $('#showtransfer').fadeOut("slow");
            
        }
        else if (this.value == "Credit / Debit Card") {
            $('#showChequeList').fadeOut("slow");
            $('#showDebitCredit').fadeIn("slow");
            $('#showDirectCredit').fadeOut("slow");
             $('#showtransfer').fadeOut("slow");

        }
        else if (this.value == "Direct Credit") {
            $('#showDebitCredit').fadeOut("slow");
            $('#showChequeList').fadeOut("slow");
            $('#showDirectCredit').fadeIn("slow");
             $('#showtransfer').fadeOut("slow");
        }
        else if (this.value == "Transfer") {
            $('#showDebitCredit').fadeOut("slow");
            $('#showChequeList').fadeOut("slow");
            $('#showtransfer').fadeIn("slow");
        }
        else {
            $('#showChequeList').fadeOut("slow");
            $('#showDebitCredit').fadeOut("slow");
            $('#showDirectCredit').fadeOut("slow");
             $('#showtransfer').fadeOut("slow");

        }
    });
    function GetDataOnDate() {
    }

    var currentTime = new Date()
    var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
    var maxDate =  new Date(); // one day before next month
    $( ".todayDate2" ).datepicker({ 
  
    'yearRange': "2007:+50",
    dateFormat: 'dd-mm-yy',
    changeMonth:true,
    changeYear:true
    });

    $('.todayDate').on('click', function() {
        $( ".todayDate2" ).focus();
    })

    function validNum(input){
        var regex=/[^0-9 ]/gi;
        input.value=input.value.replace(regex,"");
    }

    //INPUT KEYPRESS
    $(':input').on('keypress change', function() {
        var id = this.id;
        try {$('#' + id).css('border-color', "#000000");}catch(e) {}
        
    });

    function validateCorpus(done="false"){
        let count = 0;
        let namePhone=$('#namePhone').val();
        let deityIdName=$('#deityIdName').val();
        let ssId=$('#ssId').val();
        let addr2=$('#addr2').val();
        let sccity=$('#sccity').val();
        let ssstate=$('#ssstate').val();
        let sccountry=$('#sccountry').val();
        let addr1=$('#addr1').val();
        let cpin=$('#cpin').val();
        let sevaname=$('#sevaname').val();
        let smphone=$('#smphone').val();
        let modeOfPayment = $('#modeOfPayment option:selected').val();
        let transactionId = $(' #transactionId').val();
        let corpus = $('#corpus').val();
        let chequeNo = $('#chequeNo').val();
        let checkdate = $('#checkdate').val();
        let bank = $('#bank').val();
        let branch = $('#branch').val();
        let bookreceiptno = $('#bookreceiptno').val();
        let adlCrpBookDate = $('#adlCrpBookDate').val();
        let paymentNotes = $('#paymentNotes').val();
        let corpusCallFrom=$('#corpusCallFrom').val();
        let DCtobank=$('#DCtobank').val();
        let tobank=$('#tobank').val();
        let paidBy=$('#paidBy').val();


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
            chequeDate = $(' #checkdate').val();
            bank = $(' #bank').val();
            branch = $(' #branch').val();
            if (chequeNo.length == 6) {
                $('#chequeNo').css('border-color', "#800000");
            } else {
                $('#chequeNo').css('border-color', "#FF0000");
                ++count;
            }

            if (chequeDate) {
                $('#checkdate').css('border-color', "#800000");
            } else {
                $('#checkdate').css('border-color', "#FF0000");
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
            DCtobank = $('#DCtobank').val();
            if (DCtobank!= 0) {
                $('#DCtobank').css('border-color', "#800000");
            } else {
                $('#DCtobank').css('border-color', "#FF0000");
                ++count;
            }
        } else if (modeOfPayment == "Direct Credit") {  
            tobank = $('#tobank').val();
            if (tobank!= 0) {
                $('#tobank').css('border-color', "#800000");
            } else {
                $('#tobank').css('border-color', "#FF0000");
                ++count;
            }                                                                               //laz new..
        } else {
            $('#chequeNo').css('border-color', "#800000");
            $('#branch').css('border-color', "#800000");
            $('#bank').css('border-color', "#800000");
            $('#chequeDateM').css('border-color', "#800000");
        }

        if (modeOfPayment) {
            $('#modeOfPayment').css('border-color', "#ccc")
            
        } else {
            $('#modeOfPayment').css('border-color', "#FF0000")
            ++count;
        }

       
        if (adlCrpBookDate) {
            $('#adlCrpBookDate').css('border-color', "#ccc")
            
        } else {
            $('#adlCrpBookDate').css('border-color', "#FF0000")
            ++count;
        }

        if (count != 0) {
            alert("Information", "Please fill required fields", "OK");
            return false;
        }
        
        let type = [];
        let ledgers = [];
        let amount = [];
        let ledgerName =[];
        let toLedgerName="";
        let j=0,pos=0,getLedg=0,dispType="";
        // let countNoJ = $('#countNoJ').val();
        let naration = $('#naration').val();
        let corpustot=0;
        let Transfertot=0;

        let url = "<?=site_url()?>Receipt/addCorpusReceipt";

        $('.ledger').each(function(i, ele) {
            pos = ele.id.split('_')[1];
            type[j]= $('#type_'+pos).val()
            getLedg = $('#ledger_'+pos).val().split("|");

            ledgers[j]= getLedg[0];
            ledgerName[j]= getLedg[2];

            if(type[j]=="from") {
                amount[j]= $('#debit_'+pos).val()
                 Transfertot +=parseInt(amount[j]);
            }
            j++;
        });


        if (modeOfPayment == "Transfer") {                                  //laz
            if($('#debitTot').val() == "" ) {
                alert("Information","Please fill required fields");
                return;
            } if($('#debitTot').val() == 0 ) {
                alert("Information","Please fill required fields");
                return;
            }
            let flag=0;
            $('.ledger').each(function(i, ele) {
                pos = ele.id.split('_')[1];
                if($('#ledger_'+pos).val()=="") {
                    alert("Information","Please fill required fields");
                    flag++;
                }

            });
            if(flag!=0)
                    return;   
             if(corpus != Transfertot){
                     alert("Information", "Corpus amount and adjustmenet amount should be equal", "OK");
            return;
        }                                                          //laz..
        }

         $("#corpusModal").modal(); 
            $('.modal-body').html("<tr><td><label>DATE:&nbsp;&nbsp;</label></td><td> " + "<?=date('d-m-Y'); ?>" + "</td></tr><br/>");
             if (namePhone) 
                $('.modal-body').append("<tr><td><label>NAME:&nbsp;&nbsp;</label></td><td> " + namePhone + "</td></tr><br/></table>");
            if (deityIdName) 
                $('.modal-body').append("<tr><td><label>DEITY NAME:&nbsp;&nbsp;</label></td><td> " + deityIdName + "</td></tr><br/></table>");
            if (sevaname) 
                $('.modal-body').append("<tr><td><label>SEVA NAME:&nbsp;&nbsp;</label></td><td> " + sevaname + "</td></tr><br/></table>");
            if (bookreceiptno) 
                $('.modal-body').append("<tr><td><label>BOOK RECEIPT NO:&nbsp;&nbsp;</label></td><td> " + bookreceiptno + "</td></tr><br/></table>");
            if (adlCrpBookDate) 
                $('.modal-body').append("<tr><td><label>BOOK RECEIPT DATE:&nbsp;&nbsp;</label></td><td> " + adlCrpBookDate + "</td></tr><br/></table>");
            if (corpus) 
                $('.modal-body').append("<tr><td><label>CORPUS:&nbsp;&nbsp;</label></td><td> " + corpus + "</td></tr><br/></table>");
            if (modeOfPayment) 
            $('.modal-body').append("<tr><td><label>MODE OF PAYMENT:&nbsp;&nbsp;</label></td><td> " + modeOfPayment + "</td></tr><br/></table>");

            if (modeOfPayment == "Cheque") {
            $('.modal-body').append("<label>CHEQUE NO:</label> " + chequeNo + ",&nbsp;&nbsp;");
            $('.modal-body').append("<label>CHEQUE DATE:</label> " + chequeDate + ",&nbsp;&nbsp;");
            $('.modal-body').append("<label>BANK:</label> " + bank + ",&nbsp;&nbsp;");
            $('.modal-body').append("<label>BRANCH:</label> " + branch + "<br/>");


        } else if (modeOfPayment == "Credit / Debit Card") {
            $('.modal-body').append("<label>TRANSACTION ID:</label> " + transactionId + "<br/>");
             $('.modal-body').append("<label>TO BANK:</label> " + tobank + "<br/>");
        }
        else if (modeOfPayment == "Direct Credit") {
            $('.modal-body').append("<label>TO BANK:</label> " + DCtobank + "<br/>");
        }
         else if (modeOfPayment == "Transfer") {
            for($i = 0; $i < j; ++$i) {
                    dispType = type[$i].toUpperCase();
                    $('.modal-body').append("<tr><td><label>"+dispType+":&nbsp;&nbsp;</label></td><td>" + ledgerName[$i] + "</td><td>&emsp;<label>"+ (dispType=="FROM"?"DEBIT":"CREDIT")+":&nbsp;&nbsp;</label> " +amount[$i] + "</td></tr><br/>");
                     if (dispType=="TO") {
                        toLedgerName+=ledgerName[$i]+", "
                    }
                }
                 $('.modal-body').append("<tr><td><label>NARATION:&nbsp;&nbsp;</label></td><td> " + naration + "</td></tr><br/></table>");
        }

     if (paymentNotes) 
            $('.modal-body').append("<tr><td><label>PAYMENT NOTES:&nbsp;&nbsp;</label></td><td> " + paymentNotes + "</td></tr><br/></table>");
         

     if(done=="true"){
        $.post(url, {'namePhone': namePhone, 'deityIdName': deityIdName, 'ssId': ssId, 'addr1': addr1, 'addr2': addr2, 'sccity': sccity, 'ssstate': ssstate, 'sccountry': sccountry, 'cpin': cpin, 'sevaname': sevaname,'smphone': smphone, 'modeOfPayment': modeOfPayment,'transactionId': transactionId, 'corpus': corpus,'chequeNo':chequeNo,'checkdate':checkdate,'bank':bank,'branch':branch,'bookreceiptno':bookreceiptno,'paymentNotes':paymentNotes,'adlCrpBookDate':adlCrpBookDate,'corpusCallFrom':corpusCallFrom,'type':JSON.stringify(type),'ledgers':JSON.stringify(ledgers),'amount':JSON.stringify(amount),'ledgerName':JSON.stringify(ledgerName),'naration':naration,'DCtobank':DCtobank,
            'tobank':tobank,'paidBy':paidBy}, function (e) {
                e1 = e.split("|")
                    if (e1[0] == "success")
                         location.href = "<?=site_url();?>Receipt/receipt_corpusTopup_print";
                    else
                        alert("Something went wrong, Please try again after some time");
            }); 
    }
    }


    $(document).ready(function() { 
    $(document).on("click", "a.add" , function(e) {  
        $(document).ready(function () {
            $('.ledger').change(function () {
                if ($('.ledger option[value="' + $(this).val() + '"]:selected').length > 1) {
                  $(this).val('').change();
                 let pos = this.id.split('_')[1];
                 $('#curBal_'+ pos).html("");
                  return;
            }
        }); 
    });              
    if($('#ledger_'+e.currentTarget.id.split("_")[1]).prop('selectedIndex') == 0) {
        $('#ledger_'+e.currentTarget.id.split("_")[1]).css("border-color","#ff0000");
        alert("Information","Please fill required fields in red");
        return;
    }

    if($('#type_'+e.currentTarget.id.split("_")[1]+' option:selected').text() == "FROM") {
        if($('#debit_'+e.currentTarget.id.split("_")[1]).val() == "" || $('#debit_'+e.currentTarget.id.split("_")[1]).val() == "0") {
            $('#debit_'+e.currentTarget.id.split("_")[1]).css("border-color","#ff0000");
            alert("Information","Please fill required fields in red");
            return;
        }                     
    } else {
        if($('#credit_'+e.currentTarget.id.split("_")[1]).val() == "" || $('#credit_'+e.currentTarget.id.split("_")[1]).val() == "0") {
            $('#credit_'+e.currentTarget.id.split("_")[1]).css("border-color","#ff0000");
            alert("Information","Please fill required fields in red");
            return;  
        }    
    }

    if(parseInt(($('#ledger_'+e.currentTarget.id.split("_")[1]).val()).split('|')[1]) < parseInt(($('#debit_'+e.currentTarget.id.split("_")[1]).val()+ $('#credit_'+e.currentTarget.id.split("_")[1]).val()))) {
        alert("Information","Insufficient Balance");
        return;
    } 

    if(!parseInt(($('#ledger_'+e.currentTarget.id.split("_")[1]).val()).split('|')[1])) {
        alert("Information","Insufficient Balance");
        return;
    }

            

    $('#ledger_'+e.currentTarget.id.split("_")[1]).css("border-color","#ccc");
    $("#addNewDiv").append('<div id="idChildContactDiv_'+(parseInt(e.currentTarget.id.split("_")[1])+1)+'" style="padding-top:15px;" class ="row alignContactDiv">     <div class="control-group col-lg-2 col-md-3 col-sm-3 col-xs-3">   <select id="type_'+(parseInt(e.currentTarget.id.split("_")[1])+1)+'" name="type" class="form-control label_size" onchange="changeTransactionType(event,id)" disabled><option value="from" >FROM</option></select></div>      <div class="control-group col-lg-4 col-md-3 col-sm-3 col-xs-3"> <select id="ledger_'+(parseInt(e.currentTarget.id.split("_")[1])+1)+'" name="ledger" class="form-control label_size ledger" onChange="getLedgerChange(id)"><option value="">Select Ledger</option><?php   if(!empty($ledger)) { foreach($ledger as $row1) { ?> <option value="<?php echo $row1->FGLH_ID;?>|<?php echo $row1->BALANCE;?>|<?php echo str_replace("'","\'",$row1->FGLH_NAME);?>"><?php echo str_replace("'","\'",$row1->FGLH_NAME);?></option><?php } } ?></select><label for="curBal" value="">Cur Bal:<span id="curBal_'+(parseInt(e.currentTarget.id.split("_")[1])+1)+'"></span></label> </div>    <div class="control-group col-lg-2 col-md-3 col-sm-3 col-xs-3">  <input type="text" class="dec form-control amounts text-right " name="number" autocomplete="off" id="debit_'+(parseInt(e.currentTarget.id.split("_")[1])+1)+'" style="width:100%" onkeyup="getCheckedEditedFields(id)" onkeypress="return validateFloatKeyPress(this,event);"/> </div>     <div class="control-group col-lg-2 col-md-3 col-sm-3 col-xs-3">  <input type="text" class="form-control amounts text-right dec" name="number" autocomplete="off" id="credit_'+(parseInt(e.currentTarget.id.split("_")[1])+1)+'" style="width:100%; visibility: hidden;" onkeyup="getCheckedEditedFields(id)" onkeypress="return validateFloatKeyPress(this,event);"/></div>      <div id="remove" class="control-group col-lg-1 col-md-1 col-sm-1 col-xs-1 "><a style="text-decoration:none;cursor:pointer;" class="removeContact" id="removeContact_'+(parseInt(e.currentTarget.id.split("_")[1])+1)+'" ><img style="width:24px;height:24px" src="<?=site_url();?>images/delete1.svg"/></a></div>        <div id="add" class="control-group col-lg-1 col-md-1 col-sm-1 col-xs-1"> <a style="text-decoration:none;cursor:pointer;" class="add" id="add_'+(parseInt(e.currentTarget.id.split("_")[1])+1)+'" onclick="getFinalData()"><img style="width:24px;height:24px"  src="<?=site_url();?>images/add_icon.svg"/></a></div>    </div>');

        $('#'+e.currentTarget.id).hide();                  

    }); 

    $(document).on("click", "a.removeContact" , function(e) {
        e.preventDefault();

        var clickPos = 0, count = 0;
        $('.ledger').each(function(i, ele) {
            if(ele.id.split('_')[1] == e.currentTarget.id.split('_')[1]) {                      
                clickPos = i+1;  
            }
            count++;
        });
        $(this).parents(".alignContactDiv").remove();
        if(clickPos == count)
            $('#add_'+(parseInt(e.currentTarget.id.split("_")[1])-1)).show();
        getFinalData();
    }); 
    });

    function alphaonlypurpose(input) {
      var regex=/[^-a-z-0-9 ]/gi;
      input.value=input.value.replace(regex,"");
    }
    function getFinalData() {
        let debit=0,credit=0,debitAmt=0,creditAmt=0;
        $(".amounts").each(function(i, ele) {
            if(ele.id.split('_')[0] == "debit") {
                debit = Number($('#'+ele.id).val());
                debitAmt += debit;
            } else {
                credit = $('#'+ele.id).val();
                credit = Number($('#'+ele.id).val()); 
                creditAmt += credit;
            }
        });
        $('#debitTot').val(debitAmt); 
    }

    function validateFloatKeyPress(el, evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        var number = el.value.split('.');
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        if(number.length>1 && charCode == 46){
            return false;
        }
        var text = $(el).val();

        if ((text.indexOf('.') != -1) &&
            (text.substring(text.indexOf('.')).length > 2) &&
            (evt.which != 0 && evt.which != 8) &&
            ($(el)[0].selectionStart >= text.length - 2)) {
            event.preventDefault();
        }

        getFinalData();
        return true;
    }

    function getLedgerChange(id) {
        if($('#'+id).prop('selectedIndex') == 0) {
            $('#'+id).css("border-color","#ff0000");
            alert("Information","Ledger Cannot be same as the previously selected ledger");
            return;
        } else {
            $('#'+id).css("border-color","#ccc"); 
        }

        let pos = id.split('_')[1];
        let curLedger = document.getElementById(id).value.split("|");    
        $('#curBal_'+ pos).html(curLedger[1]);

        if(parseInt(($('#'+id).val()).split('|')[1]) < parseInt(($('#debit_'+id.split("_")[1]).val() + $('#credit_'+id.split("_")[1]).val()))) {
            alert("Information","Insufficient Balance");
            $('#debit_'+id.split("_")[1]).val("");
            $('#credit_'+id.split("_")[1]).val("");
            getFinalData();
            return;
        }
    }

    function getCheckedEditedFields(id) {
        if($('#'+id).val() != "") {
            $('#'+id).css("border-color","#ccc");
        } else {
            $('#'+id).css("border-color","#ff0000");
        }

        if(id.split("_")[0]!="credit"){
            if(parseInt(($('#ledger_'+id.split("_")[1]).val()).split('|')[1]) < parseInt($('#'+id).val())) {
                alert("Information","Insufficient Balance");
                $('#'+id).val("");
                getFinalData();
                return;
            }
        }
        getFinalData();
    }

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


    
    $(".chequeDate3").datepicker({
        dateFormat: 'dd-mm-yy',
        changeYear: true,
        changeMonth: true,
        beforeShow: function() {
            setTimeout(function(){
                $('.ui-datepicker').css('z-index', 99999999999999);
            }, 0);
        }
    });

    $('.chequeDate1').on('click', function () {
        $(".chequeDate3").focus();
    });
    var currentTime = new Date()
    var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
     var maxDate =  new Date(); // one day before next month
     $( ".todayDate2" ).datepicker({ 

        'yearRange': "2007:+50",
        dateFormat: 'dd-mm-yy',
        changeMonth:true,
        changeYear:true
      });
     
    

    function onCommitteeChange(){
        $('#frmCommitteeChange').submit();   
    }


   
</script>



  