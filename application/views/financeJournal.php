<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
    <div class="container-fluid container">
        <div class="row form-group">
            <div class="col-lg-2 col-md-10 col-sm-10 col-xs-8">               
                <h3><b>Journal For</b></h3>
            </div>
            <div class="col-lg-3 col-md-10 col-sm-10 col-xs-8">
                <form id="frmCommitteeChange" action="<?=site_url()?>finance/Journal" method="post">
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
                <a style="text-decoration:none;cursor:pointer;pull-right;" href="<?=site_url()?>finance/Journal" title="Refresh"><img style="width:24px; height:24px" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
            </div>
        </div>
        <form id="frmReceipt" action="<?=site_url()?>finance/addReceiptTrans" method="post" enctype="multipart/form-data"
            accept-charset="utf-8">
            <div class="row form-group">
                <div class="control-group col-md-4 col-lg-6 col-sm-4 col-xs-6">               
                    <label>Voucher No:</label><input type="text" id="countNoJ" style="background: transparent; border: none; width: 50%;" name="countNoJ" value="<?php echo $receiptFormat;?>"readonly >
                </div>
                <div class="control-group col-lg-2 col-md-3 col-sm-4 col-xs-6" style="margin-top:-5px; ">               
                    <div class="input-group input-group-sm">
                        <input autocomplete="" name= "todayDate" id="todayDate" type="text"  class="form-control todayDate2"  onchange="GetDataOnDate(this.value)" placeholder="dd-mm-yyyy" readonly = "readonly"  />
                        <div class="input-group-btn">
                            <button class="btn btn-default todayDate" type="button">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row form-group">
                <div class="control-group col-md-12 col-lg-8 col-sm-12 col-xs-6">
                    <hr style="border-top:1px solid #800000; width: 780px; margin-left: -11px; margin-bottom: 3px;">
                    <div class="control-group col-md-12 col-lg-2 col-sm-12 col-xs-6">

                    </div>

                    <div class="control-group col-md-12 col-lg-4 col-sm-12 col-xs-6">
                        <label for="comment">Ledger </label>
                    </div>

                    <div class="control-group col-md-12 col-lg-2 col-sm-12 col-xs-6 text-center">
                        <label for="comment">Debit </label>
                    </div>

                    <div class="control-group col-md-12 col-lg-2 col-sm-12 col-xs-6  text-center">
                        <label for="comment">Credit</label>
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
                                <option value="to">TO</option>
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
                            <div class="control-group col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                <input type="text" class="form-control amounts dec " name="number" id="credit_1" autocomplete="off" style="width:100%;visibility: hidden;" onkeyup="getCheckedEditedFields(id)"/>
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
                        <!-- <hr style="border-top:1px soledger #800000;"/> -->
                        <div class="control-group col-lg-6 col-md-6 col-sm-3 col-xs-3">

                        </div>
                        <div class="control-group col-lg-2 col-md-2 col-sm-12 col-xs-6">              
                            <!-- <output id="debitTot" class="text-right" style="font-weight: bold; padding-top: 0px">0</output>         -->
                            <input type="text" id="debitTot" disabled class="text-right" name="" style="width:100% ;background: transparent; border:none;"> 
                        </div>
                        <div class="control-group col-lg-2 col-md-2 col-sm-12 col-xs-6">
                            <!-- <output id="creditTot" class="text-right" style="font-weight: bold;padding-top: 0px">0</output>          -->
                             <input type="text" id="creditTot" disabled class="text-right" name="" style="width:100% ;  background: transparent; border:none;">

                        </div>

                    </div>
                </div>
                <hr style="border-top:1px solid #800000;width: 255px;margin-left: 27em; margin-top: -10px;" /> 

                <div class="row form-group" style="margin-top: -20px;">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="comment">Narration </label>
                            <textarea class="form-control" rows="5" name="naration" onkeyup="alphaonlypurpose(this)" id="naration" placeholder="" style="width:67%;height:100%;resize:none;"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-6 text-right" >
                        <input type="button" class="btn btn-default btn-md custom" value="Submit" onclick="validateJournal()">
                    </div>
                </div>
            </form>
            <div class="modal fade" id="journalModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Journal Preview</h4>
                        </div>
                        <div class="modal-body">
                        </div>
                        <div class="modal-footer text-left" style="text-align:left;">
                            <label>Are you sure you want to save..?</label>
                            <br/>
                            <button type="button" id="modalYes" style="width: 8%;" class="btn btn-primary btn-default" onclick="validateJournal('true')">Yes</button>
                            <button type="button" style="width: 8%;" class="btn btn-default" data-dismiss="modal">No</button>
                        </div>
                </div>
            </div>
        </div>
    </div> 

<script type="text/javascript">

    $(document).ready(function() { 
    //To focus modal textbox
    $(document).on("click", "a.add" , function(e) {  
        $(document).ready(function () {
            $('.ledger').change(function () {
                if ($('.ledger option[value="' + $(this).val() + '"]:selected').length > 1) {
                  $(this).val('').change();
                 //alert('You have already selected this option previously - please choose another.');
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

    // if(parseInt(($('#ledger_'+e.currentTarget.id.split("_")[1]).val()).split('|')[1]) < parseInt(($('#debit_'+e.currentTarget.id.split("_")[1]).val()+ $('#credit_'+e.currentTarget.id.split("_")[1]).val()))) {
    //     alert("Information","Insufficient Balance1");
    //     return;
    // } 

    // if(!parseInt(($('#ledger_'+e.currentTarget.id.split("_")[1]).val()).split('|')[1])) {
    //     alert("Information","Insufficient Balance2");
    //     return;
    // }

    if($('#debitTot').val() == $('#creditTot').val()) {
        alert("Information","Please note the Debits are equal to Credits");
        return;
    }  

    if(parseInt($('#creditTot').val()) > parseInt($('#debitTot').val())) {
        alert("Information","Please note the Credits are grater than Debits");
        return;
    }                  

    $('#ledger_'+e.currentTarget.id.split("_")[1]).css("border-color","#ccc");
    $("#addNewDiv").append('<div id="idChildContactDiv_'+(parseInt(e.currentTarget.id.split("_")[1])+1)+'" style="padding-top:15px;" class ="row alignContactDiv">     <div class="control-group col-lg-2 col-md-3 col-sm-3 col-xs-3">   <select id="type_'+(parseInt(e.currentTarget.id.split("_")[1])+1)+'" name="type" class="form-control label_size" onchange="changeTransactionType(event,id)"><option value="from" >FROM</option><option value="to">TO</option></select></div>      <div class="control-group col-lg-4 col-md-3 col-sm-3 col-xs-3"> <select id="ledger_'+(parseInt(e.currentTarget.id.split("_")[1])+1)+'" name="ledger" class="form-control label_size ledger" onChange="getLedgerChange(id)"><option value="">Select Ledger</option><?php   if(!empty($ledger)) { foreach($ledger as $row1) { ?> <option value="<?php echo $row1->FGLH_ID;?>|<?php echo $row1->BALANCE;?>|<?php echo str_replace("'","\'",$row1->FGLH_NAME);?>"><?php echo str_replace("'","\'",$row1->FGLH_NAME);?></option><?php } } ?></select><label for="curBal" value="">Cur Bal:<span id="curBal_'+(parseInt(e.currentTarget.id.split("_")[1])+1)+'"></span></label> </div>    <div class="control-group col-lg-2 col-md-3 col-sm-3 col-xs-3">  <input type="text" class="dec form-control amounts text-right " name="number" autocomplete="off" id="debit_'+(parseInt(e.currentTarget.id.split("_")[1])+1)+'" style="width:100%" onkeyup="getCheckedEditedFields(id)" onkeypress="return validateFloatKeyPress(this,event);"/> </div>     <div class="control-group col-lg-2 col-md-3 col-sm-3 col-xs-3">  <input type="text" class="form-control amounts text-right dec" name="number" autocomplete="off" id="credit_'+(parseInt(e.currentTarget.id.split("_")[1])+1)+'" style="width:100%; visibility: hidden;" onkeyup="getCheckedEditedFields(id)" onkeypress="return validateFloatKeyPress(this,event);"/></div>      <div id="remove" class="control-group col-lg-1 col-md-1 col-sm-1 col-xs-1 "><a style="text-decoration:none;cursor:pointer;" class="removeContact" id="removeContact_'+(parseInt(e.currentTarget.id.split("_")[1])+1)+'" ><img style="width:24px;height:24px" src="<?=site_url();?>images/delete1.svg"/></a></div>        <div id="add" class="control-group col-lg-1 col-md-1 col-sm-1 col-xs-1"> <a style="text-decoration:none;cursor:pointer;" class="add" id="add_'+(parseInt(e.currentTarget.id.split("_")[1])+1)+'" onclick="getFinalData()"><img style="width:24px;height:24px"  src="<?=site_url();?>images/add_icon.svg"/></a></div>    </div>');

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

    function changeTransactionType(e,id) {
        if($('#debitTot').val() == $('#creditTot').val()) {
            e.preventDefault();
            return;
        }
        if($('#type_'+id.split('_')[1]+' option:selected').text() == "FROM") {
            $('#credit_'+id.split('_')[1]).val("");
            $('#credit_'+id.split('_')[1]).css("visibility", "hidden");
            $('#debit_'+id.split('_')[1]).css("visibility", "visible");
            // $('#debit_'+id+id.split('_')[1]).focus();               
        } else { 
            if($('#debitTot').val() == $('#creditTot').val()) {
                $('#type_'+id.split('_')[1]).prop('selectedIndex',0);
                return;
            }

            $('#debit_'+id.split('_')[1]).val("");
            $('#debit_'+id.split('_')[1]).css("visibility", "hidden");
            $('#credit_'+id.split('_')[1]).css("visibility", "visible");
            // $('#credit_'+id.split('_')[1]).focus();                
        }
        getFinalData();
    }
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
        $('#creditTot').val(creditAmt);
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

        // if(parseInt(($('#'+id).val()).split('|')[1]) < parseInt(($('#debit_'+id.split("_")[1]).val() + $('#credit_'+id.split("_")[1]).val()))) {
        //     alert("Information","Insufficient Balance3");
        //     $('#debit_'+id.split("_")[1]).val("");
        //     $('#credit_'+id.split("_")[1]).val("");
        //     getFinalData();
        //     return;
        // }
    }

    function getCheckedEditedFields(id) {
        if($('#'+id).val() != "") {
            $('#'+id).css("border-color","#ccc");
        } else {
            $('#'+id).css("border-color","#ff0000");
        }

        // if(id.split("_")[0]!="credit"){
        //     if(parseInt(($('#ledger_'+id.split("_")[1]).val()).split('|')[1]) < parseInt($('#'+id).val())) {
        //         alert("Information","Insufficient Balance");
        //         $('#'+id).val("");
        //         getFinalData();
        //         return;
        //     }
        // }
        getFinalData();
    }

    function validateJournal(done="false"){
         if (document.getElementById("todayDate").value != "") {
          $('#todayDate').css('border-color', "#000000");
        } else {
          $('#todayDate').css('border-color', "#FF0000");
         ++count;
        }
        if($('#debitTot').val() == "" || $('#creditTot').val()=="") {
            alert("Information","Please fill required fields");
            return;
        }   
        if($('#debitTot').val() == 0 || $('#creditTot').val()==0) {
            alert("Information","Please fill required fields");
            return;
        }
        let flag=0;
        $('.ledger').each(function(i, ele) {
            pos = ele.id.split('_')[1];
            if($('#ledger_'+pos).val()=="")
            {
                alert("Information","Please fill required fields");
                flag++;
            }

        });
        if(flag!=0)
            return;
        if($('#debitTot').val() == $('#creditTot').val()) {
            let type = [];
            let ledgers = [];
            let amount = [];
            let ledgerName =[];
            let toLedgerName="";
            let j=0,pos=0,getLedg=0,dispType="";
            let countNoJ = $('#countNoJ').val();
            let todayDate = $('#todayDate').val();
            let naration = $('#naration').val();
            let committeeSelected = $('#CommitteeId option:selected').html();
            let committeeSelectedId = $('#CommitteeId').val();
            let committeeSelectedName = $('#CommitteeId option:selected').html();

            let url = "<?=site_url()?>finance/addJournalTrans";
            $('.ledger').each(function(i, ele) {
                pos = ele.id.split('_')[1];
                type[j]= $('#type_'+pos).val()
                getLedg = $('#ledger_'+pos).val().split("|");
                ledgers[j]= getLedg[0];
                ledgerName[j]= getLedg[2];
                if(type[j]=="from")
                {
                    amount[j]= $('#debit_'+pos).val()
                }else{
                    amount[j]= $('#credit_'+pos).val()
                }
                j++;
            });

            $("#journalModal").modal();
            $('.modal').on('shown.bs.modal', function() {
              $('#modalYes').find('[autofocus]').focus();
               // $('#modalYes').find('[autofocus]').focus(); 
            });
            
            
            $('.modal-body').html("<table>");
            $('.modal-body').append("<tr><td><label>DATE:&nbsp;&nbsp;</label></td><td> " + "<?=date('d-m-Y'); ?>" + "</td></tr><br/>");
            $('.modal-body').append("<tr><td><label>VOUCHER NO:&nbsp;&nbsp;</label></td><td> " + countNoJ + "</td></tr><br/>");
            for($i = 0; $i < j; ++$i) {
                dispType = type[$i].toUpperCase();
                $('.modal-body').append("<tr><td><label>"+dispType+":&nbsp;&nbsp;</label></td><td>" + ledgerName[$i] + "</td><td>&emsp;<label>"+ (dispType=="FROM"?"DEBIT":"CREDIT")+":&nbsp;&nbsp;</label> " +amount[$i] + "</td></tr><br/>");
                 if (dispType=="TO") {
                    toLedgerName+=ledgerName[$i]+", "
                }
            }
             if (committeeSelected) 
                $('.modal-body').append("<label>COMMITTEE:</label> " + committeeSelected + "<br/>");
            if (naration) 
                $('.modal-body').append("<tr><td><label>NARRATION:&nbsp;&nbsp;</label></td><td> " + naration + "</td></tr><br/></table>");
            if(done=="true"){
                $.post(url, { 'type': JSON.stringify(type),'ledgers': JSON.stringify(ledgers), 'amount': JSON.stringify(amount) ,'countNoJ': countNoJ, 'todayDate': todayDate, 'naration': naration,'selCommittee':committeeSelectedId}, function (e) {

                    e1 = e.split("|")
                    if (e1[0] == "success"){
                        let url = "<?php echo site_url(); ?>generatePDF/create_JournalSession";
                        $.post(url,{'type': JSON.stringify(type),'ledgers': JSON.stringify(ledgers), 'amount': JSON.stringify(amount) ,'countNoJ': countNoJ, 'todayDate': todayDate, 'naration': naration,'selCommittee':committeeSelectedId,'committeeSelectedName':committeeSelectedName,'toLedgerName':toLedgerName}, function(data) {

                        let url2 = "<?php echo site_url(); ?>generatePDF/create_JournalPrint";
                            if(data == 1) {
                                downloadClicked = 0;
                                var win = window.open(
                                  url2,
                                  '_blank'
                                );
                                setTimeout(function(){ win.print();}, 1000); //setTimeout(function(){ win.close();}, 5000);
                                location.href = "<?=site_url();?>finance/Journal";
                            }
                        })
                    } else
                        alert("Something went wrong, Please try again after some time");
                });
            }
        } else{
            alert("Information","Debits and Credits are not equal");
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

    function onCommitteeChange(){
        $('#frmCommitteeChange').submit();   
    }
</script>
</body>