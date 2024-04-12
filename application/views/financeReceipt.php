<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
<div class="container-fluid container">
    <div class="row form-group">
      <div class="col-lg-2 col-md-10 col-sm-10 col-xs-8">               
        <h3><b>Receipt For </b></h3>
      </div>
      <div class="col-lg-3 col-md-10 col-sm-10 col-xs-8" style="padding-left: -20px;">
        <form id="frmCommitteeChange" action="<?=site_url()?>finance/Receipt" method="post">
            <select id="CommitteeId" name="CommitteeId" class="form-control" style="margin-left:-60px; margin-top:8px;" onChange="onCommitteeChange();"autofocus>
              <?php   if(!empty($committee)) {
                  foreach($committee as $row1) { 
                    if($row1->COMP_ID == $compId) { ?> 
                      <option value="<?php echo $row1->COMP_ID;?>" selected><?php echo $row1->COMP_NAME;?></option>
                    <?php } else { ?> 
                      <option value="<?php echo $row1->COMP_ID;?>"><?php echo $row1->COMP_NAME;?></option>
                  <?php } } } ?>
                  <input type="hidden" name="todayDateVal" id="todayDateVal">
            </select>
        </form>               
      </div>
      <div class="col-lg-5 col-md-10 col-sm-10 col-xs-8">           
      </div>
      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4" style = "padding-top:10px;">
        <a style="text-decoration:none;cursor:pointer;pull-right;" href="<?=site_url()?>finance/Receipt" title="Refresh"><img style="width:24px; height:24px" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
      </div>
    </div>
    <form id="frmReceipt" action="<?=site_url()?>finance/addReceiptTrans" method="post" enctype="multipart/form-data"
      accept-charset="utf-8">
        <div class="row form-group">
          <div class="control-group col-md-4 col-lg-4 col-sm-4 col-xs-6">               
            <label>Voucher No:</label><input type="text" id="countNoR" style="background: transparent; border: none; width: 50%;" name="countNoR" value="<?php echo $receiptFormat;?>"readonly >
          </div>
          <div class="control-group col-lg-2 col-md-3 col-sm-4 col-xs-6">               
            <div class="input-group input-group-sm">
              <input autocomplete="" name= "todayDate" id="todayDate" type="text"  class="form-control todayDate2"  onchange="GetDataOnDate(this.value)" placeholder="dd-mm-yyyy" readonly = "readonly" />
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
            <label>Ledger: <span style="color:#800000;">*</span></label>
            <select id="lidR" class="form-control" name="lidR" style="height: 30px;width:100%" onChange="LedgerChange();">
              <option value="">Select Ledger</option>
              <?php   if(!empty($ledger)) {
                foreach($ledger as $row1) { ?> 
                  <option value="<?php echo $row1->FGLH_ID;?>|<?php echo $row1->BALANCE;?>|<?php echo $row1->FGLH_NAME;?>|<?php echo $row1->TYPE_ID;?>"><?php echo $row1->FGLH_NAME;?></option>

                <?php } } ?>
              </select>
              <label for="lbid" value="" >Cur Bal:</label>
              <span id="lbid"></span><span id="ldr"></span>         
            </div>
            <div class="control-group col-md-4 col-lg-4 col-sm-4 col-xs-6">
            <label>Account: <span style="color:#800000;">*</span></label>
            <select id="aidR"  class="form-control" name="aidR" style="height: 30px;width:100%" onChange="AccountChange();">
              <option value="">Select Account</option>
              <?php   if(!empty($account)) {
                foreach($account as $row1) { ?> 
                  <option value="<?php echo $row1->FGLH_ID;?>|<?php echo $row1->BALANCE;?>|<?php echo $row1->FGLH_NAME;?>|<?php echo $row1->FGLH_PARENT_ID;?>"><?php echo $row1->FGLH_NAME;?>  
                </option>
              <?php } } ?>
            </select> 
            <label for="abid" value="">Cur Bal:
              <span id="abid"></span><span id="bdr"></span>
            </label>
          </div>
        </div>
        <div class="row form-group">
          <div class="col-lg-4 col-md-12 col-sm-12 col-xs-6">              
            <label for="comment">Amount <span style="color:#800000;">*</span></label></br>
            <input type="text" class="form-control amtsR" name="amtsR" id="amtsR" placeholder="" autocomplete="off" min="0" style="width:100%" />                
          </div>
          <div class="col-lg-4 col-md-12 col-sm-12 col-xs-6">
            <label for="comment">Received From <span style="color:#800000;">*</span></label></br>
            <input type="text" class="form-control" name="receivedfrom" id="receivedfrom" placeholder="" autocomplete="off" min="0" style="width:100%" />
          </div>
        </div>
        <div class="mode" id="mode" style="display:none;">
            <div class="row form-group">
                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-6" > 
                    <label for="comment">Receipt Method </label></br>
                    <select class="form-control" id="receiptmethod" name="receiptmethod" style="height: 30px;width:100%">
                        <option value="Cheque">Cheque</option>
                    </select> 
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-6" >
                    <label for="comment">Cheque No <span style="color:#800000;">*</span></label></br>
                    <input type="text" class="form-control" name="chkno" id="chkno" placeholder="" autocomplete="off" min="0" style="width:100%" onkeypress="return isNumberKey(event)"  maxlength="6"> 
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
            <div class="row form-group">
                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-6" >
                    <label for="comment">Bank Name <span style="color:#800000;">*</span></label></br>
                    <input type="text" class="form-control" name="bankname" id="bankname" onkeyup="alphaonly(this)"  autocomplete="off" style="width:100%"> 
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-6" >
                    <label for="comment">Bank Branch <span style="color:#800000;">*</span></label></br>
                    <input type="text" class="form-control" name="branchname" id="branchname" onkeyup="alphaonly(this)"  autocomplete="off" style="width:100%;"> 
                </div>
            </div>
        </div>
            <div class="row form-group">
                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-6" >
                    <label for="comment">Narration </label>
                    <textarea class="form-control" rows="5" name="naration" onkeyup="alphaonlypurpose(this)" id="naration" placeholder="" style="width:100%;height:100%;font-weight: bold;font-size:15px; resize:none;"></textarea>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-6 text-right" >
                    <input type="button" class="btn btn-default btn-md custom" value="Submit" onclick="validateReceipt()">
                </div>
            </div>
        </div>
        <input type="hidden" name="selCommittee" id="selCommittee">
    </form>
    <div class="modal fade" id="receiptModal">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
         <div class="modal-header">
          <h4 class="modal-title">Receipt Preview</h4>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer text-left" style="text-align:left;">
         <label>Are you sure you want to save..?</label>
         <br/>
         <button type="button" style="width: 8%;" class="btn " onclick="document.getElementById('frmReceipt').submit();">Yes</button>
         <button type="button" style="width: 8%;" class="btn " data-dismiss="modal">No</button>
       </div>

        </div>
      </div>
    </div>
</div>

<script type="text/javascript">

    function validateReceipt() {
      let count = 0;
      let aidR = $('#aidR').val().split("|");
      let lidR = $('#lidR').val().split("|");
      let countNoR = $('#countNoR').val();
      let amtsR = $('#amtsR').val();
      let todayDate = $('#todayDate').val();
      let receivedfrom = $('#receivedfrom').val();

      let naration=$('#naration').val();  
      let url = "<?=site_url()?>finance/addReceiptTrans";

       if (document.getElementById("todayDate").value != "") {
          $('#todayDate').css('border-color', "#000000");
        } else {
          $('#todayDate').css('border-color', "#FF0000");
         ++count;
        }
    if (document.getElementById("aidR").value != "") {
      $('#aidR').css('border-color', "#000000");
    } else {
      $('#aidR').css('border-color', "#FF0000");
     ++count;
    }
      if (document.getElementById("lidR").value != "") {
      $('#lidR').css('border-color', "#000000");
    } else {
      $('#lidR').css('border-color', "#FF0000");
     ++count;
    }
    if (document.getElementById("amtsR").value != "") {
      $('#amtsR').css('border-color', "#000000");
    } else {
      $('#amtsR').css('border-color', "#FF0000");
     ++count;
    }
    if (document.getElementById("receivedfrom").value != "") {
      $('#receivedfrom').css('border-color', "#000000");
    } else {
      $('#receivedfrom').css('border-color', "#FF0000");
     ++count;
    }
     if(aidR[3]!=8 )
    {
        let receiptmethod = $('#receiptmethod').val();
        let chkno = $('#chkno').val();
        let chequeDate = $('#chequeDate').val();
        let bankname = $('#bankname').val();
        let branchname = $('#branchname').val();

        if (document.getElementById("chkno").value != "") {
          $('#chkno').css('border-color', "#000000");
        } else {
          $('#chkno').css('border-color', "#FF0000");
         ++count;
        }
         if (document.getElementById("chequeDate").value != "") {
          $('#chequeDate').css('border-color', "#000000");
        } else {
          $('#chequeDate').css('border-color', "#FF0000");
         ++count;
        }
        if (document.getElementById("bankname").value != "") {
          $('#bankname').css('border-color', "#000000");
        } else {
          $('#bankname').css('border-color', "#FF0000");
         ++count;
        }
        if (document.getElementById("branchname").value != "") {
          $('#branchname').css('border-color', "#000000");
        } else {
          $('#branchname').css('border-color', "#FF0000");
         ++count;
        }
        
    }
    if (count != 0) {
      alert("Information", "Please fill required fields", "OK");
      return false;
    }
   // $('#selCommittee').val($('#CommitteeId').val());
    $('#selCommittee').val($('#CommitteeId').val());
    let committeeSelected = $('#CommitteeId option:selected').html();
    $("#receiptModal").modal(); 
    $('.modal-body').html("");
    $('.modal-body').append("<label>DATE:</label> " + "<?=date('d-m-Y'); ?>" + "<br/>");
    if(aidR)
     $('.modal-body').append("<label>ACCOUNT:</label> " + aidR[2] + "<br/>");
    if(lidR)
     $('.modal-body').append("<label>LEDGER:</label> " + lidR[2] + "<br/>");
  if (amtsR) 
    $('.modal-body').append("<label>AMOUNT:</label> " + amtsR + "<br/>");
  if (committeeSelected) 
    $('.modal-body').append("<label>AMOUNT:</label> " + committeeSelected + "<br/>");
  if (receivedfrom) 
    $('.modal-body').append("<label>RECEIVED FROM:</label> " + receivedfrom + "<br/>");
     if(aidR[3]!=8 )
    {
            let receiptmethod = $('#receiptmethod').val();
            let chkno = $('#chkno').val();
            let chequeDate = $('#chequeDate').val();
            let bankname = $('#bankname').val();
            let branchname = $('#branchname').val();
      if (bankname) 
        $('.modal-body').append("<label>BANK NAME:</label> " + bankname + "<br/>");
      if (branchname) 
        $('.modal-body').append("<label>BANK BRANCH:</label> " + branchname + "<br/>");
      if (chkno) 
        $('.modal-body').append("<label>CHEQUE NO:</label> " + chkno + "<br/>");
      if (chequeDate) 
        $('.modal-body').append("<label>CHEQUE DATE:</label> " + chequeDate + "<br/>");
      if (receiptmethod) 
        $('.modal-body').append("<label>RECIEPT METHOD:</label> " + receiptmethod + "<br/>");
    }
  if (naration) 
    $('.modal-body').append("<label>NARRATION:</label> " + naration + "<br/>");
  
    }

    //INPUT KEYPRESS
    $(':input').on('keypress change', function() {
        var id = this.id;
        try {$('#' + id).css('border-color', "#000000");}catch(e) {}
        
    });

    function AccountChange(){
      let acc1 = document.getElementById("aidR").value.split("|"); 
      if(acc1[3] == 9){
       document.getElementById('mode').style.display = 'block';
     }
     else{
       document.getElementById('mode').style.display = 'none';
     }
     // $('#abid').html(acc1[1]);
     // $('#bdr').html(" Dr");   

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
   }

    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
    function alphaonly(input) {
      var regex=/[^a-z&']/gi;
      input.value=input.value.replace(regex,"");
    }

    function alphaonlypurpose(input) {
      var regex=/[^-a-z-0-9 ]/gi;
      input.value=input.value.replace(regex,"");
    }



   function LedgerChange(){
    let acc1 = document.getElementById("lidR").value.split("|");  
        //$('#lbid').html(Math.abs(acc1[1]));
        $('#lbid').html(acc1[1]);
         if (acc1[3]== 'A' || acc1[3] == 'E') {
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
        
         if(acc1 ==''){
             $('#lbid').html("");
               $('#ldr').html("");
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

     $('.amtsR').keypress(function(event) {
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

     function onCommitteeChange(){
       let checkTodayDate = document.getElementById('todayDate').value;
       document.getElementById('todayDateVal').value = checkTodayDate;
        $('#frmCommitteeChange').submit();   
     }
</script>