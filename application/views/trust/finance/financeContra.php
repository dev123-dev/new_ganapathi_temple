<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
<div class="container-fluid container">

    <div class="row form-group">
        <div class="col-lg-2 col-md-10 col-sm-10 col-xs-8">               
            <h3><b>Contra For</b></h3>
        </div>
        <div class="col-lg-3 col-md-10 col-sm-10 col-xs-8">
            <form id="frmCommitteeChange" action="<?=site_url()?>Trustfinance/Contra" method="post">
                <select id="CommitteeId" name="CommitteeId" class="form-control" style="margin-left:-40px; margin-top:8px;" onChange="onCommitteeChange();" autofocus>
                  <?php   if(!empty($committee)) {
                      foreach($committee as $row1) { 
                        if($row1->T_COMP_ID == $compId) { ?> 
                          <option value="<?php echo $row1->T_COMP_ID;?>" selected><?php echo $row1->T_COMP_NAME;?></option>
                        <?php } else { ?> 
                          <option value="<?php echo $row1->T_COMP_ID;?>"><?php echo $row1->T_COMP_NAME;?></option>
                      <?php } } } ?>
                </select>
                 <input type="hidden" name="todayDateVal" id="todayDateVal">
            </form>               
        </div>
        <div class="col-lg-5 col-md-10 col-sm-10 col-xs-8">           
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4" style = "padding-top:10px;">
            <a style="text-decoration:none;cursor:pointer;pull-right;" href="<?=site_url()?>Trustfinance/Contra" title="Refresh"><img style="width:24px; height:24px" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
        </div>
    </div>
    <form id="frmContra" action="<?=site_url()?>Trustfinance/addContraTrans" method="post" enctype="multipart/form-data"
        accept-charset="utf-8">
       <!--  <div style = "padding-top:15px;">   -->     
            <div class="row form-group">
                <div class="control-group col-md-4 col-lg-4 col-sm-4 col-xs-6">               
                    <label>Voucher No: </label><input type="text" id="countNoC" style="background: transparent; border: none; width: 50%;" name="countNoC" value="<?php echo $receiptFormat;?>"readonly >
                </div>
                <div class="control-group col-lg-2 col-md-3 col-sm-4 col-xs-6">               
                    <div class="input-group input-group-sm">
                        <input type="hidden" name="date" value="<?=@$date; ?>" id="date" value="" >
                        <input type="hidden" name="load" id="load" value="">
                        <input autocomplete="" name= "todayDate" id="todayDate" type="text" class="form-control todayDate2"  onchange="GetDataOnDate(this.value)" placeholder="dd-mm-yyyy" readonly = "readonly" />
                        <div class="input-group-btn">
                            <button class="btn btn-default todayDate" type="button">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="control-group col-md-4 col-lg-4 col-sm-4 col-xs-6"> 
                    <label>From Account: <span style="color:#800000;">*</span></label>
                </div>  
                <div class="control-group col-md-4 col-lg-4 col-sm-4 col-xs-6">
                    <label>To Account: <span style="color:#800000;">*</span></label>
                </div> 
            </div>

            <div class="row control-group col-md-4 col-lg-4 col-sm-4 col-xs-6">
                <select id="aidC" class="form-control go" name="aidC" style="height: 30px;width:100%" onChange="AccountChange();">
                    <option value="">Select Account</option>
                    <?php   if(!empty($account)) {
                        foreach($account as $row1) { ?> 
                            <option value="<?php echo $row1->T_FGLH_ID;?>|<?php echo $row1->BALANCE;?>|<?php echo $row1->T_FGLH_NAME;?>|<?php echo $row1->T_FGLH_PARENT_ID;?>|<?php echo str_replace("'","\'",$row1->T_BANK_NAME);?>|<?php echo str_replace("'","\'",$row1->T_BANK_BRANCH);?>"><?php echo $row1->T_FGLH_NAME;?>  
                        </option>
                    <?php } } ?>
                </select> 

                <select id="acidC" class="form-control go" name="acidC" style="height: 30px;width:100%;margin-left: 28em;margin-top: -32px;display: flex;" onChange="AccountChange1();">
                    <option value="">Select Account</option>
                    <?php   if(!empty($account3)) {
                        foreach($account3 as $row1) { ?> 
                            <option value="<?php echo $row1->T_FGLH_ID;?>|<?php echo $row1->BALANCE;?>|<?php echo $row1->T_FGLH_NAME;?>|<?php echo $row1->T_FGLH_PARENT_ID;?>|<?php echo str_replace("'","\'",$row1->T_BANK_NAME);?>|<?php echo str_replace("'","\'",$row1->T_BANK_BRANCH);?>"><?php echo $row1->T_FGLH_NAME;?>   
                        </option>
                    <?php } } ?>
                </select> 
            </div>
            <br/>
            <div class="row" style="display: initial;">
                <div class="control-group col-md-4 col-lg-4 col-sm-4 col-xs-6" style="margin-left: -1em;margin-top: -0.7em;"> 
                    <label for="abid" value="">Cur Bal:
                        <span id="abid"></span> <span id="bdr"></span>
                    </label>
                </div>  
                <div class="control-group col-md-4 col-lg-4 col-sm-4 col-xs-6" style="margin-left: 1em;margin-top: -0.7em;">
                    <label for="abid1" value="">Cur Bal:
                        <span id="abid1"></span> <span id="bdr1"></span>
                    </label>
                </div> 
            </div>

            <div class="row form-group" style="display: none;" id="cashcombo">
                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                              <tr>
                                <th width="50%" class="text-left" colspan="2">Ledger Name</th>
                                <th width="30%" class="text-left" colspan="2">Amount</th>
                                <th width="20%" class="text-left">Amount To Deposit</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php $selectedId = ""; 
                                $selectedLedgerId= ""; 
                                 foreach($cashReceipts as $result) { ?>
                                    <tr class="parent" id="row<?php echo $result->T_FGLH_ID; ?>" name="<?php echo $result->BankLedgerId; ?>" title="Click to expand/collapse" style="cursor: pointer;">
                                        <td><center><input type="checkbox" class="rowcheckbox" onclick="mainCheckboxClick('<?php echo $result->T_FGLH_ID; ?>')" name="<?php echo $result->BankLedgerId; ?>" id="checkboxrow<?php echo $result->T_FGLH_ID; ?>" /></center></td>
                                        <td><input type="text" class="ledgerGroupName" id="ledgerGroupName_<?php echo $result->T_FGLH_ID; ?>" value="<?php echo $result->T_FGLH_NAME; ?>" style="width:100% ;background: transparent; border:none;cursor: pointer" readonly/></td>
                                        <td class="text-right "><?php echo $result->AMOUNT; ?></td>
                                        <td></td>
                                        <td><input type="text" class="text-right ledgerGroupTotAmt" name="<?php echo $result->T_FGLH_ID; ?>" id="selLedgerTotAmt_<?php echo $result->T_FGLH_ID; ?>" style="width:100% ;background: transparent; border:none;" readonly/> </td>
                                    </tr> 
                                        <?php
                                        $i=1;
                                         foreach($indCashReceipts as $row) { 
                                            if($result->T_FGLH_ID==$row->T_FGLH_ID) {
                                            ?>
                                            <tr class="child-row<?php echo $result->T_FGLH_ID; ?>" style="display: none;">
                                                <td></td>    
                                                <td class="text-right"><?php echo $row->T_FLT_DATE; ?></td>
                                                <td class="text-right"><?php echo $row->AMOUNT; ?></td>
                                                <td><center><input type="checkbox" name="<?php echo $row->BankLedgerId; ?>" id="<?php echo $row->T_FGLH_ID;?>_<?php echo $i ?>" onchange="GetSelectLedgerOption('<?php echo $row->T_FGLH_ID; ?>','<?php echo $row->AMOUNT; ?>','<?php echo $i ?>','<?php echo $row->T_FLT_ID; ?>')" class="sel <?php echo $row->T_FGLH_ID; ?>" /></center></td>
                                                <td></td>
                                            </tr>
                                        <?php  $i++;
                                         } 
                                       } ?>
                                <?php } ?>
                                <input type="hidden" name="selectedId" id="selectedId" value="<?php echo $selectedId; ?>"/>
                                <input type="hidden" name="selectedLedgerId" id="selectedLedgerId" value="<?php echo $selectedId; ?>"/>
                            </tbody>
                           </table>
                    </div>
                </div>
            </div>

            <div class="row form-group" style="margin-top: -0.4em;">
                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-6">
                        <label for="comment">Amount <span style="color:#800000;">*</span></label></br>
                        <input type="text" class="form-control amtsC" name="amtsC" id="amtsC" placeholder="" autocomplete="off" min="0" style="width:100%;">
                </div>

                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-6">
                    <!-- <label for="comment" >Favouring Name <span style="color:#800000;">*</span></label></br> -->
                    <input type="hidden" class="form-control" name="favouring" id="favouring" placeholder="" value="Ourselves" autocomplete="off" min="0" style="width:100%;">
                </div>
            </div>

            <div class="mode" id="mode" style="display:none; ">
                    <div class="row form-group">
                        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-6">
                        <label for="comment">Payment Method</label></br>
                        <select id="paymentmethod" name="paymentmethod" style="height: 30px;width:100%">
                            <option value="Cheque">Cheque</option>
                        </select> 
                    </div>
            </div>

            <div class="row form-group">
                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-6" > 
                    <label for="comment">Cheque No<span style="color:#800000;">*</span></label></br>
                    <select id="rid" name="rid" style="height: 30px;width:100%">
                        <option value="">Select Cheque</option>
                        <?php   if(!empty($range)) {
                            foreach($range as $row1) { ?> 
                                
                            </option>
                        <?php } } ?>
                    </select>       
                </div>

                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-6" >   
                    <label for="comment">Cheque Date  <span style="color:#800000;">*</span></label></br>
                    <div class="input-group input-group-sm">
                        <input type="hidden" name="chkdate" value="<?=@$date; ?>" id="chkdate" value="" >
                        <input type="hidden" name="load" id="load" value="">
                        <input autocomplete="" name= "chequeDate" id="chequeDate" type="text" value="" class="form-control todayDate2"  onchange="GetDataOnDate(this.value)" placeholder="dd-mm-yyyy" readonly = "readonly" />
                        <div class="input-group-btn">
                            <button class="btn btn-default todayDate" type="button">
                                <i class="glyphicon glyphicon-calendar"></i></button>
                        </div>
                    </div>
                </div>
            </div>
    </div>
<!-- </div> -->
    <div class="row form-group">
        <div class="col-lg-8 col-md-12 col-sm-12 col-xs-6">
            <label for="comment">Narration </label>
            <textarea class="form-control" rows="5" name="naration" onkeyup="alphaonlypurpose(this)" id="naration" placeholder="" style="width:100%;height:100%;font-weight: bold;font-size:15px; resize:none;"></textarea>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-lg-8 col-md-12 col-sm-12 col-xs-6 text-right" >
          <input type="button" class="btn btn-default btn-md custom" value="Submit" onclick="validateContra()">
        </div>
    </div>

</div>
 <input type="hidden" name="selCommittee" id="selCommittee">
</form>

<div class="modal fade bs-example-modal-lg"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="contraModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Contra Preview</h4>
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

</div>
<script type="text/javascript">  
    $(document).ready(function () {    
        $('tr.parent')  
            .css("cursor", "pointer")  
            .attr("title", "Click to expand/collapse")  
            .click(function () {  
                $(this).siblings('.child-' + this.id).toggle(); 
        });  
        checkBoxActiveOrDeactive();
    });  
</script> 
<script type="text/javascript">
    function validateContra() {
        let count = 0;
        let aidC  = $('#aidC ').val().split("|");
         if (document.getElementById("todayDate").value != "") {
          $('#todayDate').css('border-color', "#000000");
        } else {
          $('#todayDate').css('border-color', "#FF0000");
         ++count;
        }
        if (document.getElementById("aidC").value != "") {
          $('#aidC').css('border-color', "#000000");
        } else {
          $('#aidC').css('border-color', "#FF0000");
         ++count;
        }
        if (document.getElementById("acidC").value != "") {
          $('#acidC').css('border-color', "#000000");
        } else {
          $('#acidC').css('border-color', "#FF0000");
         ++count;
        }
        if (document.getElementById("amtsC").value != "") {
          $('#amtsC').css('border-color', "#000000");
        } else {
          $('#amtsC').css('border-color', "#FF0000");
         ++count;
        }
         if (document.getElementById("favouring").value != "") {
          $('#favouring').css('border-color', "#000000");
        } else {
          $('#favouring').css('border-color', "#FF0000");
         ++count;
        }

         if(aidC[3]!=8)
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


        let acidC  = $('#acidC ').val().split("|");
        let countNoC  = $('#countNoC ').val();
        let amtsC  = $('#amtsC ').val();
        let todayDate = $('#todayDate').val();
        let naration=$('#naration').val(); 
        let favouring=$('#favouring').val();
        if(aidC[3]!=8 && aidC != ""){
            let rid= $('#rid').val().split("|");
            let chequeDate = $('#chequeDate').val();
            let paymentmethod = $('#paymentmethod').val();
        }
        if(parseInt(aidC[1])<amtsC){
            alert("Information", "Insufficient Balance In This Particular Account", "OK");
            return false;
        }
        $('#selCommittee').val($('#CommitteeId').val());
        let committeeSelected = $('#CommitteeId option:selected').html();

        //$("#contraModal").modal();  
        $('.modal-body').html("");
        $('.modal-body').append("<label>VOUCHER NO:</label> " + countNoC +"&emsp;&emsp;&emsp;&emsp;<label>DATE:</label>  " + todayDate + "<br/>");
        if(aidC)
            $('.modal-body').append("<label>FROM ACCOUNT:</label> " + aidC[2] + "<br/>");
        if(acidC)
           $('.modal-body').append("<label>TO ACCOUNT:</label> " + acidC[2] + "<br/>");
        if(aidC[3]!=8)
        {
            let rid= $('#rid').val().split("|");
            let chequeDate = $('#chequeDate').val();
            let paymentmethod = $('#paymentmethod').val();
           
            if (rid) 
                $('.modal-body').append("<label>CHEQUE NO:</label> " + rid[0] + "<br/>");
            if (chequeDate) 
                $('.modal-body').append("<label>CHEQUE DATE:</label> " + chequeDate + "<br/>");
            if (paymentmethod) 
                $('.modal-body').append("<label>PAYMENT METHOD:</label> " + paymentmethod + "<br/>");
        } else {
            let allSelAmt = [];
            let allSelName = [];
            let j=0,pos=0;
            $(".ledgerGroupTotAmt").each(function(i, ele) {
                pos = ele.id.split('_')[1];
                if($('#selLedgerTotAmt_'+pos).val()!=""){
                    allSelAmt[j]= $('#selLedgerTotAmt_'+pos).val()
                    allSelName[j]= $('#ledgerGroupName_'+pos).val()
                    j++;
                }
            });
            for($i = 0; $i < j; ++$i) {
                $('.modal-body').append("<label>LEDGER:&nbsp;&nbsp;</label>" + allSelName[$i] + "&emsp;<label>AMOUNT:&nbsp;&nbsp;</label> " +allSelAmt[$i] + "<br/>");
            }           
        }
        if (amtsC) 
            $('.modal-body').append("<label>TOTAL AMOUNT:</label> " + amtsC + "<br/>");
        if (favouring) 
            $('.modal-body').append("<label>FAVOURING NAME:</label> " + favouring + "<br/>");
         if (committeeSelected) 
             $('.modal-body').append("<label>COMMITTEE:</label> " + committeeSelected + "<br/>");
         if (naration) 
            $('.modal-body').append("<label>NARRATION:</label> " + naration + "<br/>");
        $('.modal').modal();
        $('.bs-example-modal-lg').focus();
    }
    //INPUT KEYPRESS
    $(':input').on('keypress change', function() {
        var id = this.id;
        try {$('#' + id).css('border-color', "#000000");}catch(e) {} 
    });

    $(".go").change(function(){
        var selVal=[];
        $(".go").each(function(){
            selVal.push(this.value);
        });

        $(this).siblings(".go").find("option").removeAttr("disabled").filter(function(){
            var a=$(this).parent("select").val();
            return (($.inArray(this.value, selVal) > -1) && (this.value!=a))
        }).attr("disabled","disabled");
        let acc2 = document.getElementById("acidC").value.split("|"); 
        let acc1 = document.getElementById("aidC").value.split("|");   
        if(acc1[0]==21 && acc2[0]==27)
        {
            alert("Information", "Invalid Transaction", "OK");
            $('#acidC').val("");
            $('#abid1').html("");
            return false;
        }
    });

    $(".go").eq(0).trigger('change');

    function AccountChange(){
        let acc1 = document.getElementById("aidC").value.split("|");    
        $('#abid').html(acc1[1]);
        if(acc1[3] == 9){
            document.getElementById('mode').style.display = 'block';
        }
        else{
            document.getElementById('mode').style.display = 'none';
        }
        document.getElementById('amtsC').value="";
        document.getElementById('selectedId').value="";
        if(acc1[0] == 21){
            document.getElementById('cashcombo').style.display = 'block';
            document.getElementById('amtsC').readOnly = true;
        }
        else{
            document.getElementById('cashcombo').style.display = 'none';
            document.getElementById('amtsC').readOnly = false;

        }
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
        $('#rid').html("");

        arr = <?php echo @$range; ?>; 
        acNo = acc1[0];
// console.log(arr,"hiiii") 
// changed the name fglh_id to t_fglh_id and same other inside arr  by adithya on 29-12-23
        for (let i = 0; i < arr.length; ++i) {
            if (arr[i]['T_FGLH_ID'] == acNo){
                $('#rid').append('<option value="' + 
                arr[i]['T_CHEQUE_NO'] +"|" + 
                arr[i]['T_FCD_ID'] + "|" + 
                arr[i]['T_FCBD_ID'] +'">' + 
                arr[i]['T_CHEQUE_NO'] + '</option>');
            }
        }
        let aidC  = $('#aidC ').val().split("|");
        clearCashGridValues();
    }

        
    function AccountChange1(){
        let acc2 = document.getElementById("acidC").value.split("|");   
        if(acc2 ==''){
             $('#abid1').html("");
               $('#bdr1').html("");
        }else{
            $('#abid1').html(acc2[1]);
            if (acc2[1]>=0) {
              $('#bdr1').html(" Dr");
            }else{
              $('#bdr1').html(" Cr");
            }
        } 
        $('#abid1').html(acc2[1]);
        checkBoxActiveOrDeactive();
        clearCashGridValues();

    }

    function clearCashGridValues() {
        $(".sel").each(function() {
            document.getElementById(this.id).checked = false;               
        }); 
         $(".rowcheckbox").each(function() {
            document.getElementById(this.id).checked = false;               
        }); 
         $(".ledgerGroupTotAmt").each(function() {
            document.getElementById(this.id).value = "";               
        });
        $('#selectedId').val("");
        $('#selectedLedgerId').val("");
        $('#amtsC').val("");

    }
    
    function alphaonlypurpose(input) {
      var regex=/[^-a-z-0-9 ]/gi;
      input.value=input.value.replace(regex,"");
    }

    function checkBoxActiveOrDeactive() {
        // Code to Keep Checkboxes of Ledgers With Same Banks Active/Deactive  
        let acc2 = document.getElementById("acidC").value.split("|");
        $(".sel").each(function() {
            let canEnable=0;
            for(let m = 0; m < $('#' + this.id).prop('name').split(',').length; m++) {
                if($('#' + this.id).prop('name').split(',')[m]==acc2[0]){
                    canEnable++;
                }
            }
            if(canEnable>0){
                $('#' + this.id).attr("disabled",false);
            } else {
                $('#' + this.id).attr("disabled",true);
            }
        });
        
        $(".rowcheckbox").each(function() {
            let canEnable=0;
            for(let m = 0; m < $('#' + this.id).prop('name').split(',').length; m++) {
                if($('#' + this.id).prop('name').split(',')[m]==acc2[0]){
                    canEnable++;
                }
            }
            if(canEnable>0){
                $('#' + this.id).attr("disabled",false);
            } else {
                $('#' + this.id).attr("disabled",true);
            }
            if($('#' + this.id).prop('name')==""){
                $('#' + this.id).attr("disabled",true);
            }
        });
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

    $('.amtsC').keypress(function(event) {
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

    var strSelectedBanks = "";
    function GetSelectLedgerOption(id,accuAmt,idPos,fltId) {   
        if($('#' + id +'_' +idPos).prop('checked') == true) {
            $('#amtsC').val(Number($('#amtsC').val())+Number(accuAmt));
            $('#selLedgerTotAmt_'+ id).val(Number($('#selLedgerTotAmt_'+ id).val())+Number(accuAmt));
            $('#selectedId').val((($('#selectedId').val() != "")?$('#selectedId').val() + "," + id:id));
            $('#selectedLedgerId').val((($('#selectedLedgerId').val() != "")?$('#selectedLedgerId').val() + "," + fltId:fltId));
        } else {
            $('#amtsC').val(((Number($('#amtsC').val())-Number(accuAmt)) == 0)?'':Number($('#amtsC').val())-Number(accuAmt));
            $('#selLedgerTotAmt_'+ id).val(((Number($('#selLedgerTotAmt_'+ id).val())-Number(accuAmt)) == 0)?'':Number($('#selLedgerTotAmt_'+ id).val())-Number(accuAmt));
            $('#selectedId').val((($('#selectedId').val().indexOf(id) == 0)?(($('#selectedId').val().indexOf(',') != -1)?$('#selectedId').val().replace(id+',',''):$('#selectedId').val().replace(id,'')):$('#selectedId').val().replace(','+id,''))); 
            $('#selectedLedgerId').val((($('#selectedLedgerId').val().indexOf(fltId) == 0)?(($('#selectedLedgerId').val().indexOf(',') != -1)?$('#selectedLedgerId').val().replace(fltId+',',''):$('#selectedLedgerId').val().replace(fltId,'')):$('#selectedLedgerId').val().replace(','+fltId,''))); 
        }
        $(".ledgerGroupTotAmt").each(function() {
            let idVal = $('#' + this.id).prop('name');
            if(document.getElementById(this.id).value!="")
                document.getElementById('checkboxrow'+idVal).checked = true;
             else 
                document.getElementById('checkboxrow'+idVal).checked = false;
                       
        });
    }
    function mainCheckboxClick(FGLH_ID) {
        let className = FGLH_ID;
        $("."+className).each(function() {
            if($('#' +this.id).prop('checked') == true)
                document.getElementById(this.id).click();
        });
    }
    function onCommitteeChange(){
        let checkTodayDate = document.getElementById('todayDate').value;
        document.getElementById('todayDateVal').value = checkTodayDate;
        $('#frmCommitteeChange').submit();       
    }

      function PrintSubmit(){
        let aidC = $('#aidC').val();
        let acidC = $('#acidC').val();
        let countNoC = $('#countNoC').val();
        let amtsC = $('#amtsC').val();
        let todayDate = $('#todayDate').val();
        let naration=$('#naration').val(); 
        let favouring=$('#favouring').val();
        let paymentmethod = $('#paymentmethod').val();
        let rid= $('#rid').val();
        let chequeDate = $('#chequeDate').val();
        let aidC1 = $('#aidC').val().split("|");
        let acidC1 = $('#acidC').val().split("|");
        let chkno= $('#rid').val();
        let selectedLedgerId = $('#selectedLedgerId').val();
        let committeeSelected = $('#CommitteeId').val();
        let committeeSelectedName = $('#CommitteeId option:selected').html();
        if(chkno == null)
            paymentmethod = "Cash";
        else {
            rid1 = $('#rid').val().split("|");
            chkno = rid1[0];
        }

        let url = "<?=site_url()?>Trustfinance/addContraTrans";
        $.post(url, { 'aidC': aidC, 'acidC': acidC, 'countNoC': countNoC,'amtsC': amtsC, 'todayDate': todayDate, 'naration': naration, 'favouring': favouring, 'rid': rid, 'chequeDate': chequeDate, 'paymentmethod': paymentmethod,'selectedLedgerId':selectedLedgerId,'selCommittee':committeeSelected}, function (e) {

        e1 = e.split("|")
        // added the trim part by adithya on 29-12-23
        if (e1[0].trim() == "success"){
            let url = "<?php echo site_url(); ?>generatePDF/create_ContraSession";
            $.post(url,{'aidC':aidC1[2],'acidC':acidC1[2],'countNoC':countNoC,'todayDate':todayDate,'favouring':favouring,'naration':naration,'amtsC':amtsC, 'paymentmethod': paymentmethod , 'chequeDate':chequeDate,'chkno':chkno,'bankName':aidC1[4],'branchName':aidC1[5],'committeeSelectedName':committeeSelectedName}, function(data) {

            let url2 = "<?php echo site_url(); ?>generatePDF/create_ContraPrint";
                if(data == 1) {
                    downloadClicked = 0;
                    var win = window.open(
                      url2,
                      '_blank'
                    );
                    setTimeout(function(){ win.print();}, 1000); //setTimeout(function(){ win.close();}, 5000);
                    location.href = "<?=site_url();?>Trustfinance/Contra";
                }
            })
        }
        else
            alert("Something went wrong, Please try again after some time ");
        });
    }

</script>
