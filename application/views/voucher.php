<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Home page</title>
    <style>
      body {
        margin: 0;
        font-family: "Lato", sans-serif;
        background-color:#fdfdd9;
        font-weight: bold;
        overflow: hidden;
      }

      .container {
        color: #800000;
      }

      .head1 {
        background-color: #800000;
        height: 50px;
        color: #fbb917;
      }

      .sidebar {
        margin: 0;
        padding: 0;
        width: 250px;
        background-color:#fbb917;
        position: fixed;
        height: 100%;
        overflow: auto;
      }

      .sidebar a {
        display: block;
        color: black;
        padding: 16px;
        text-decoration: none;
      }

      .sidebar a.active {
        background-color: #800000;
        color: white;
      }

      .sidebar a:hover:not(.active) {
        background-color: #800000;
        color: white;
      }

      div.content {
        margin-left: 200px;
        padding: 1px 16px;
        height: 1000px;
      }

      @media screen and (max-width: 700px) {
        .sidebar {
          width: 100%;
          height: auto;
          position: relative;
        }
        .sidebar a {float: left;}
        div.content {margin-left: 0;}
      }

      @media screen and (max-width: 400px) {
        .sidebar a {
          text-align: center;
          float: none;
        }
      }
      .btn {
        background-color: #800000;
        color:white;
      }
      
      input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
      }
      span {
        color: #800000;
      }
      .sidebar a:hover span {
        color: white;
      }
    </style>
  </head>
  <body>

    <div class="sidebar">
      <a class="active" href="#home" id="btnOp" onclick="funHome()">Home</a>
      <a style="font-weight: bold;"><u>Vouchers</u></a>
      <a href="#1" id="btnContra" onclick="funContra()"><span>C</span>ontra</a>
      <a href="#2" id="btnJournal" onclick="funJournal()"><span>J</span>ournal</a>
      <a href="#3" id="btnReceipt" onclick="funReceipt()"><span>R</span>eceipt</a>
      <a href="#4" id="btnPayment" onclick="funPayment()"><span>P</span>ayment</a><hr>
      <a href="#" id="btnBal" data-toggle="modal" data-target="#balanceSheetModal" style="cursor: pointer;"><span>B</span>alance Sheet</a>
      <a href="#" id="btnIE" data-toggle="modal" data-target="#incomeExpenceModal" style="cursor: pointer;"><span>I</span>ncome and Expenditure</a>
      <a href="#" id="btnRP" data-toggle="modal" data-target="#receiptPaymentModal" style="cursor: pointer;">Receipt and Pa<span>Y</span>ment</a>
      <a href="#" id="btnTB" data-toggle="modal" data-target="#trialBalanceModal"><span>T</span>rial Balance</a><hr>
      <a href="#5" id="btnOp" onclick="funOpeningBal()"><span>O</span>pening Balance</a>
      <a href="#6" id="btnGrp" onclick="funAddGroup()">Add <span>G</span>roup</a>
      <a href="#7" id="btnLed" onclick="funAddLedger()">Add <span>L</span>edger</a>
    </div>

    <div class="content">
      <div id="home">
        <div class="container py-5">
          <h1 style="color:#800000; text-align: center; ">Welcome To GateWay of our Finance System</h1>
           <div class="col-lg-12 col-md-6 col-sm-4 col-xs-12 pull-right text-right" style="padding:0px 0px 0px;">
                  <a style="margin-left: 9px;pull-right;" href="<?=site_url();?>/Sevas" title="Back"><img style="width:30px; height:30px" src="<?=site_url();?>images/back_icon.svg"/></a>         
              </div>
        </div>
      </div>

      <div id="contra" style="display: none;">
        <div class="container py-5">
          <div class="row">              
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
               <h1>Contra</h1>     
              
              <div class="col-lg-8 col-md-6 col-sm-4 col-xs-12 pull-right text-right" style="padding:0px 0px 0px;">
                  <a style="margin-left: 9px;pull-right;" href="<?=site_url();?>/finance" title="Back"><img style="width:30px; height:30px" src="<?=site_url();?>images/back_icon.svg"/></a>         
              </div>
              </div>
          </div>  
          <div class="row">
            <form id="frmContra" action="<?=site_url()?>finance/addContraTrans" method="post">
              <br><label>No:</label><input type="text" id="countNoC" style="background: transparent; border: none; width: 30px;" name="countNoC" value="<?php echo $contraCount+1;?>"readonly ><br>
              <label>Account:</label>
              <select id="aidC" name="aidC" style="height: 30px;">
                <option value="">Select Account</option>
                <?php   if(!empty($account)) {
                  foreach($account as $row1) { ?> 
                    <option value="<?php echo $row1->FGLH_ID;?>"><?php echo $row1->FGLH_NAME;?>(cur bal: <?php echo $row1->BALANCE;?> )</option>
                  <?php } } ?>
              </select>  
              <br>
              <label>Account:</label>
              <select id="acidC" name="acidC" style="height: 30px;">
                <option value="">Select Account</option>
                <?php   if(!empty($account)) {
                  foreach($account as $row1) { ?> 
                    <option value="<?php echo $row1->FGLH_ID;?>"><?php echo $row1->FGLH_NAME;?>(cur bal: <?php echo $row1->BALANCE;?> )</option>
                  <?php } } ?>
              </select>
              <br><br>
              <input type="number" name="amtsC" id="amtsC" placeholder="Amount" autocomplete="off" min="0">
              <input type="date" name="tDateC" id="tDateC">
              <input type="text" name="naration" id="naration" placeholder="Naration">
              <input type="button" class="btn" value="Submit" onclick="validateContra()">
            </form>
          </div>
        </div>
      </div>

      <div id="journal" style="display: none;">
        <div class="container pt-5 ">
          
          <div class="row">              
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
               <h1>Journal</h1>    
              
              <div class="col-lg-8 col-md-6 col-sm-4 col-xs-12 pull-right text-right" style="padding:0px 0px 0px;">
                  <a style="margin-left: 9px;pull-right;" href="<?=site_url();?>/finance" title="Back"><img style="width:30px; height:30px" src="<?=site_url();?>images/back_icon.svg"/></a>         
              </div>
              </div>
          </div> 
            <div class="row">
              <form id="frmJournal" action="<?=site_url()?>finance/addJournalTrans" method="post">
                <br><label>No:</label><input type="text" id="countNoJ" style="background: transparent; border: none; width: 30px;" name="countNoJ" value="<?php echo $journalCount+1;?>"readonly ><br>
                <label>BY:</label>
                <select id="lidJ" name="lidJ" style="height: 30px;">
                  <option value="">Select Ledger</option>
                  <?php   if(!empty($ledger)) {
                    foreach($ledger as $row1) { ?> 
                      <option value="<?php echo $row1->FGLH_ID;?>"><?php echo $row1->FGLH_NAME;?>(cur bal: <?php echo abs($row1->BALANCE);?> )</option>
                    <?php } } ?>
                </select>  
                  <br>
                  <label>TO:</label>
                <select id="lid1J" name="lid1J" style="height: 30px;">
                  <option value="">Select Ledger</option>
                  <?php   if(!empty($ledger)) {
                    foreach($ledger as $row1) { ?> 
                      <option value="<?php echo $row1->FGLH_ID;?>"><?php echo $row1->FGLH_NAME;?>(cur bal: <?php echo abs($row1->BALANCE);?> )</option>
                    <?php } } ?>
                </select>

                <br><br>
                <input type="number" name="amtsJ" id="amtsJ" placeholder="Amount" autocomplete="off" min="0">
                <input type="date" name="tDateJ" id="tDateJ">
                <input type="text" name="naration" id="naration" placeholder="Naration">
                <input type="button" class="btn" value="Submit" onclick="validateJournal()">
              </form>
            </div>
        </div>
      </div>

      <div id="receipt" style="display: none;">
        <div class="container pt-5 ">
           <div class="row">              
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
               <h1>Receipt</h1>    
              
              <div class="col-lg-8 col-md-6 col-sm-4 col-xs-12 pull-right text-right" style="padding:0px 0px 0px;">
                  <a style="margin-left: 9px;pull-right;" href="<?=site_url();?>/finance" title="Back"><img style="width:30px; height:30px" src="<?=site_url();?>images/back_icon.svg"/></a>         
              </div>
              </div>
          </div>
            <div class="row">
              <form id="frmReceipt" action="<?=site_url()?>finance/addReceiptTrans" method="post">
                <br><label>No:</label><input type="text" id="countNoR" style="background: transparent; border: none; width: 30px;" name="countNoR" value="<?php echo $recCount+1;?>"readonly ><br>
                <label>Account:</label>
                <select id="aidR" name="aidR" style="height: 30px;">
                  <option value="">Select Account</option>
                  <?php   if(!empty($account)) {
                    foreach($account as $row1) { ?> 
                      <option value="<?php echo $row1->FGLH_ID;?>"><?php echo $row1->FGLH_NAME;?> (cur bal: <?php echo $row1->BALANCE;?> ) </option>
                    <?php } } ?>
                </select>  
                <br>
                <label>Ledger:</label>
                <select id="lidR" name="lidR" style="height: 30px;">
                  <option value="">Select Ledger</option>
                  <?php   if(!empty($ledger)) {
                    foreach($ledger as $row1) { ?> 
                      <option value="<?php echo $row1->FGLH_ID;?>"><?php echo $row1->FGLH_NAME;?>(cur bal: <?php echo abs($row1->BALANCE);?> )</option>
                    <?php } } ?>
                </select>
                    
                  <br><br>
                  <input type="number" name="amtsR" id="amtsR" placeholder="Amount" autocomplete="off" min="0">
                  <input type="date" name="tDateR" id="tDateR">
                  <input type="text" name="naration" id="naration" placeholder="Naration">
                  <input type="button" class="btn" value="Submit" onclick="validateReceipt()">
              </form>
            </div>
        </div>
      </div>

      <div id="payment" style="display: none;">
        <div class="container py-5">
           <div class="row">              
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
               <h1>Payment</h1>   
              
              <div class="col-lg-8 col-md-6 col-sm-4 col-xs-12 pull-right text-right" style="padding:0px 0px 0px;">
                  <a style="margin-left: 9px;pull-right;" href="<?=site_url();?>/finance" title="Back"><img style="width:30px; height:30px" src="<?=site_url();?>images/back_icon.svg"/></a>         
              </div>
            </div>
          </div>
            <div class="row">
              <form id="frmPayment" action="<?=site_url()?>finance/addPaymentTrans" method="post">
                <br><label>No:</label><input type="text" id="countNoP" style="background: transparent; border: none; width: 30px;" name="countNoP" value="<?php echo $payCount+1;?>"readonly ><br>

                <label>Account:</label>
                  <select id="aidP" name="aidP" style="height: 30px;">
                    <option value="">Select Account</option>
                    <?php   if(!empty($account)) {
                      foreach($account as $row1) { ?> 
                        <option value="<?php echo $row1->FGLH_ID;?>"><?php echo $row1->FGLH_NAME;?>(cur bal: <?php echo $row1->BALANCE;?> )</option>
                      <?php } } ?>
                  </select>  
                  <br>
                  <label>Ledger:</label>
                  <select id="lidP" name="lidP" style="height: 30px;">
                    <option value="">Select Ledger</option>
                    <?php   if(!empty($ledger)) {
                      foreach($ledger as $row1) { ?> 
                        <option value="<?php echo $row1->FGLH_ID;?>"><?php echo $row1->FGLH_NAME;?>(cur bal: <?php echo  abs($row1->BALANCE);?> )</option>
                      <?php } } ?>
                  </select>

                  <br><br>
                  <input type="number" name="amtsP" id="amtsP" placeholder="Amount" autocomplete="off" min="0">
                  <input type="date" name="tDateP" id="tDateP">
                  <input type="text" name="naration" id="naration" placeholder="Naration">
                  <input type="button" class="btn" value="Submit" onclick="validatePayment()">
              </form>
            </div>
        </div> 
      </div>

      <div id="openingBalance"  style="display: none;">

        <div class="container py-5">
           <div class="row">              
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
               <h1>Opening Balance For Ledger</h1>    
              
              <div class="col-lg-8 col-md-6 col-sm-4 col-xs-12 pull-right text-right" style="padding:0px 0px 0px;">
                  <a style="margin-left: 9px;pull-right;" href="<?=site_url();?>/finance" title="Back"><img style="width:30px; height:30px" src="<?=site_url();?>images/back_icon.svg"/></a>         
              </div>
              </div>
            </div>
            <div class="row">
              <form id="frmOp" action="<?=site_url()?>finance/addOpeningBal" method="post">
                <br><br>
                <label>Choose:</label>
                <select id="led" name="led" style="height: 30px;">
                  <option value="">Select Ledger</option>
                  <?php   if(!empty($allLedger)) {
                    foreach($allLedger as $row1) { ?> 
                      <option value="<?php echo $row1->FGLH_ID;?>"><?php echo $row1->FGLH_NAME;?></option>
                    <?php } } ?>
                </select>      
                <br><br>
                <input type="number" name="opAmt" id="opAmt" placeholder="Opening Balance Amount" autocomplete="off" min="0"><br><br>
                <input type="date" name="tDateOP" id="tDateOP">
                <input type="text" name="naration" id="naration" placeholder="Naration">
                <input type="button" class="btn" value="Submit" onclick="validateSubmit()" >
              </form>
            </div>
        </div>
      </div>

      <div id="addGroup" style="display: none;">
        <div class="container py-5" >
           <div class="row">              
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
               <h1>Add Group</h1>    
              
              <div class="col-lg-8 col-md-6 col-sm-4 col-xs-12 pull-right text-right" style="padding:0px 0px 0px;">
                  <a style="margin-left: 9px;pull-right;" href="<?=site_url();?>/finance" title="Back"><img style="width:30px; height:30px; " src="<?=site_url();?>images/back_icon.svg"/></a>         
              </div>
              </div>
            </div>
            <form id="frmAddGroup" action="<?=site_url()?>finance/addNewGroup" method="post">
              <h6>Select Type</h6>
              <input type="radio" name="radioGrp" value="mGroup" id="mGroup" onclick="javascript:yesnoCheck();" >  Group  &ensp;&emsp;  
              <input type="radio"  name="radioGrp" value="subGroup" id="subGroup" onclick="javascript:yesnoCheck();" >  Sub Group<br/><br/>Under
                <div class="row">
                  <div id="group1" name="group1" style="height: 30px; display: none" class=" col-lg-6">
                    <select id="mainGroupId" name="mainGroupId" style="height: 30px;">
                      <option value="">Select Group</option>
                      <?php   if(!empty($maingroups)) {
                        foreach($maingroups as $row1) { ?> 
                          <option value="<?php echo $row1->FGLH_ID?>"><?php echo $row1->FGLH_NAME;?></option>
                        <?php } } ?>
                    </select>  
                  </div>
                  <div id="group2" name="group2" style="height: 30px;display: none" class=" col-lg-6">
                    <select id="groupId" name="groupId" style="height: 30px;">
                      <option value="">Select Group</option>
                      <?php   if(!empty($groups)) {
                      foreach($groups as $row1) { ?> 
                        <option value="<?php echo $row1->FGLH_ID;?>"><?php echo $row1->FGLH_NAME;?></option>
                      <?php } } ?>
                    </select>
                  </div>
                </div>                              
                <br>
                <br><input type="text" name="nameG" placeholder="Name" id="nameG" autocomplete="off">
                <input type="button" class="btn" value="Submit" onclick="addNewGroup()">
            </form>
        </div>
      </div>

      <div id="addLedgerDiv" style="display: none;">
        <div class="container py-5" >
             <div class="row">              
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
               <h1>Add Ledger</h1>    
              
              <div class="col-lg-8 col-md-6 col-sm-4 col-xs-12 pull-right text-right" style="padding:0px 0px 0px;">
                  <a style="margin-left: 9px;pull-right;" href="<?=site_url();?>/finance" title="Back"><img style="width:30px; height:30px" src="<?=site_url();?>images/back_icon.svg"/></a>         
              </div>
              </div>
            </div>
            <form id="frmAddLedger" action="<?=site_url()?>finance/addLedger" method="post">
              <br><br>
              <label>Choose:</label>
              <select id="group" name="group" style="height: 30px;">
                <option value="">Select Group</option>
                <?php   if(!empty($groups)) {
                  foreach($groups as $row1) { ?> 
                    <option value="<?php echo $row1->FGLH_ID;?>"><?php echo $row1->FGLH_NAME;?></option>
                <?php } } ?>
              </select>   

              <br><br>
              <input type="text" name="nameL" placeholder="Name" id="nameL" autocomplete="off">
              <input type="button" class="btn" value="Submit" onclick="addLedger()">
            </form>
          </div>
      </div> 

      <div class="modal fade" id="balanceSheetModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Select Period</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="frmOpenBalSheet" action="<?=site_url()?>finance/dispBalSheet" method="post" >
               <div class="container">From : <input type="date" class="date" id="fromDate" name="fromDate">&nbsp; To : <input type="date" class="date" id="toDate" name="toDate"></div>
             </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn " onclick="openBalanceSheet()">Submit</button>
            </div>
          </div>
        </div>
      </div>

       <div class="modal fade" id="incomeExpenceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Select Period</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="frmOpenIncomeExpence" action="<?=site_url()?>finance/income" method="post" >
               <div class="container">From : <input type="date" class="date" id="fromIe" name="fromIe">&nbsp; To : <input type="date" class="date" id="toIe" name="toIe"></div>
             </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn " onclick="openIncomeExpence()">Submit</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="receiptPaymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Select Period</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="frmOpenReceiptPayment" action="<?=site_url()?>finance/dispReceipt" method="post" >
               <div class="container">From : <input type="date" class="date" id="fromRP" name="fromRP">&nbsp; To : <input type="date" class="date" id="toRP" name="toRP"></div>
              </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn " onclick="openReceiptPayment()">Submit</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="trialBalanceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Select Period</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="frmOpentrialBalance" action="<?=site_url()?>finance/dispTrialBalance" method="post" >
               <div class="container">From : <input type="date" class="date" id="fromTB" name="fromTB">&nbsp; To : <input type="date" class="date" id="toTB" name="toTB"></div>
              </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn " onclick="openTrialBalance()">Submit</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="opBalModal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-body">
              <h5>Are You Sure ?</h5>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn " onclick="document.getElementById('frmOp').submit();">Yes</button>
              <button type="button" class="btn " data-dismiss="modal">No</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="receiptModal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-body">
              <h5>Are You Sure ?</h5>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn " onclick="document.getElementById('frmReceipt').submit();">Yes</button>
              <button type="button" class="btn " data-dismiss="modal">No</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="paymentModal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-body">
              <h5>Are You Sure ?</h5>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn " onclick="document.getElementById('frmPayment').submit();">Yes</button>
              <button type="button" class="btn " data-dismiss="modal">No</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="contraModal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-body">
              <h5>Are You Sure ?</h5>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn " onclick="document.getElementById('frmContra').submit();">Yes</button>
              <button type="button" class="btn " data-dismiss="modal">No</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="journalModal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-body">
              <h5>Are You Sure ?</h5>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn " onclick="document.getElementById('frmJournal').submit();">Yes</button>
              <button type="button" class="btn " data-dismiss="modal">No</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="addGroupModal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-body">
              <h5>Are You Sure ?</h5>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn " onclick="document.getElementById('frmAddGroup').submit();">Yes</button>
              <button type="button" class="btn " data-dismiss="modal">No</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="addLedgerModal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-body">
              <h5>Are You Sure ?</h5>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn " onclick="document.getElementById('frmAddLedger').submit();">Yes</button>
              <button type="button" class="btn " data-dismiss="modal">No</button>
            </div>
          </div>
        </div>
      </div>


  </div>
      
    <script type="text/javascript">
      function funHome() {
        document.getElementById('home').style.display = "block";
        document.getElementById('contra').style.display = "none";
        document.getElementById('journal').style.display = "none";
        document.getElementById('receipt').style.display = "none";
        document.getElementById('payment').style.display = "none";
        document.getElementById('openingBalance').style.display = "none";
        document.getElementById('addGroup').style.display = "none";
        document.getElementById('addLedgerDiv').style.display = "none";
      }

      function funContra() {  
        document.getElementById('home').style.display = "none"; 
        document.getElementById('contra').style.display = "block";
        document.getElementById('journal').style.display = "none";
        document.getElementById('receipt').style.display = "none";
        document.getElementById('payment').style.display = "none";
        document.getElementById('openingBalance').style.display = "none";
        document.getElementById('addGroup').style.display = "none";
        document.getElementById('addLedgerDiv').style.display = "none";
      }

      function funJournal() {
        document.getElementById('home').style.display = "none";
        document.getElementById('contra').style.display = "none";
        document.getElementById('journal').style.display = "block";
        document.getElementById('receipt').style.display = "none";
        document.getElementById('payment').style.display = "none";
        document.getElementById('openingBalance').style.display = "none";
        document.getElementById('addGroup').style.display = "none";
        document.getElementById('addLedgerDiv').style.display = "none";
      }

      function funReceipt() {
        document.getElementById('home').style.display = "none";
        document.getElementById('contra').style.display = "none";
        document.getElementById('journal').style.display = "none";
        document.getElementById('receipt').style.display = "block";
        document.getElementById('payment').style.display = "none";
        document.getElementById('openingBalance').style.display = "none";
        document.getElementById('addGroup').style.display = "none";
        document.getElementById('addLedgerDiv').style.display = "none";
      }

      function funPayment() {
        document.getElementById('home').style.display = "none";
        document.getElementById('contra').style.display = "none";
        document.getElementById('journal').style.display = "none";
        document.getElementById('receipt').style.display = "none";
        document.getElementById('payment').style.display = "block";
        document.getElementById('openingBalance').style.display = "none";
        document.getElementById('addGroup').style.display = "none";
        document.getElementById('addLedgerDiv').style.display = "none";
      }

      function funOpeningBal() {
        document.getElementById('home').style.display = "none";        
        document.getElementById('contra').style.display = "none";
        document.getElementById('journal').style.display = "none";
        document.getElementById('receipt').style.display = "none";
        document.getElementById('payment').style.display = "none";
        document.getElementById('openingBalance').style.display = "block";
        document.getElementById('addGroup').style.display = "none";
        document.getElementById('addLedgerDiv').style.display = "none";
      }

      function funAddGroup() {    
        document.getElementById('home').style.display = "none";
        document.getElementById('contra').style.display = "none";
        document.getElementById('journal').style.display = "none";
        document.getElementById('receipt').style.display = "none";
        document.getElementById('payment').style.display = "none";
        document.getElementById('openingBalance').style.display = "none";
        document.getElementById('addGroup').style.display = "block";
        document.getElementById('addLedgerDiv').style.display = "none";
      }

      function funAddLedger() {
        document.getElementById('home').style.display = "none";
        document.getElementById('contra').style.display = "none";
        document.getElementById('journal').style.display = "none";
        document.getElementById('receipt').style.display = "none";
        document.getElementById('payment').style.display = "none";
        document.getElementById('openingBalance').style.display = "none";
        document.getElementById('addGroup').style.display = "none";
        document.getElementById('addLedgerDiv').style.display = "block";
      }

      function validateSubmit() {
        let led = $('#led').val();
        let opAmt = $('#opAmt').val();
        let tDateOP = $('#tDateOP').val();
        let naration=$('#naration').val();  
        let url = "<?=site_url()?>finance/addOpeningBal";
         if( led == "" || opAmt == "" || tDateOP == ""){    
          alert("Please Fill Required Fields");
          return;
        }
         $("#opBalModal").modal();
      }

      function validateReceipt() {
        let aidR = $('#aidR').val();
        let lidR = $('#lidR').val();
        let countNoR = $('#countNoR').val();
        let amtsR = $('#amtsR').val();
        let tDateR = $('#tDateR').val();
        let naration=$('#naration').val();  
        let url = "<?=site_url()?>finance/addReceiptTrans";
        if(aidR == "" || lidR == "" || countNoR == "" || amtsR == "" || tDateR == "") {
          alert("Please Fill Required Fields");
          return;
        } 
         $("#receiptModal").modal(); 
        //$('#frmReceipt').submit();    
      }

      function validatePayment() {
        let aidP = $('#aidP').val();
        let lidP = $('#lidP').val();
        let countNoP = $('#countNoP').val();
        let amtsP = $('#amtsP').val();
        let tDateP = $('#tDateP').val();
        let naration=$('#naration').val();
        let url = "<?=site_url()?>finance/addPaymentTrans";
        if(aidP == "" || lidP == "" || countNoP == "" || amtsP == "" || tDateP == "") {
          alert("Please Fill Required Fields");
          return;
        }
         $("#paymentModal").modal();
        //$('#frmPayment').submit();  
      }

      function validateContra() {
        let aidC = $('#aidC').val();
        let acidC = $('#acidC').val();
        let countNoC = $('#countNoC').val();
        let amtsC = $('#amtsC').val();
        let tDateC = $('#tDateC').val();
        let naration=$('#naration').val();
        let url = "<?=site_url()?>finance/addContraTrans";
        if(aidC == "" || acidC == "" || countNoC == "" || amtsC == "" || tDateC == "") {
          alert("Please Fill Required Fields");
          return;
        }
         $("#contraModal").modal();
        //$('#frmContra').submit();   
      }

      function validateJournal() {
        let LidJ = $('#lidJ').val();
        let Lid1J = $('#lid1J').val();
        let countNoJ = $('#countNoJ').val();
        let amtsJ = $('#amtsJ').val();
        let tDateJ = $('#tDateJ').val();
        let naration=$('#naration').val();
        let url = "<?=site_url()?>finance/addJournalTrans";
        if(LidJ == "" || Lid1J == "" || countNoJ == "" || amtsJ == "" || tDateJ == "") {
          alert("Please Fill Required Fields");
          return;
        }
         $("#journalModal").modal();
        //$('#frmJournal').submit();   
      }

      function addNewGroup() {
          if($('#mGroup').prop('checked')){
            let mainGroupId = $('#mainGroupId').val();
            if(mainGroupId == "") {
              alert("Please Fill Required Fields");
              return;
            }
          }else{
            let groupId = $('#groupId').val();
            if(groupId == "") {
              alert("Please Fill Required Fields");
              return;
            }

          }
          let nameG = $('#nameG').val();
          let url = "<?=site_url()?>finance/addNewGroup";
          if(nameG == "") {
            alert("Please Fill Required Fields");
            return;
          }
          $("#addGroupModal").modal(); 
          //$('#frmAddGroup').submit();   
      }

      function addLedger() {
          let group = $('#group').val();
          let nameL = $('#nameL').val();
          let url = "<?=site_url()?>finance/addLedger";
          if(nameL == "" || group == "") {
            alert("Please Fill Required Fields");
            return;
          }
          $("#addLedgerModal").modal();
          //$('#frmAddLedger').submit();   
      }

      function yesnoCheck() {
         if (document.getElementById('mGroup').checked) {
           document.getElementById('group1').style.display = 'block';
         } else {
          document.getElementById('group1').style.display = 'none';
        }
        if (document.getElementById('subGroup').checked) {
          document.getElementById('group2').style.display = 'block';
        }else {
          document.getElementById('group2').style.display = 'none';
        }
      }

      function openBalanceSheet() {
        let fromDate = $('#fromDate').val();
        let toDate = $('#toDate').val();

        if(fromDate == "" || toDate == "") {
          alert("Please select appropriate Date");
          return;
        }
        $('#frmOpenBalSheet').submit(); 
      }

      function openIncomeExpence() {
        let fromIe = $('#fromIe').val();
        let toIe = $('#toIe').val();

        if(fromIe == "" || toIe == "") {
          alert("Please select appropriate Date");
          return;
        }
        $('#frmOpenIncomeExpence').submit(); 
      }

      function openReceiptPayment() {
        let fromRP = $('#fromRP').val();
        let toRP = $('#toRP').val();

        if(fromRP == "" || toRP == "") {
          alert("Please select appropriate Date");
          return;
        }
        $('#frmOpenReceiptPayment').submit(); 
      }

      function openTrialBalance() {
        let fromTB = $('#fromTB').val();
        let toTB = $('#toTB').val();

        if(fromTB == "" || toTB == "") {
          alert("Please select appropriate Date");
          return;
        }
        $('#frmOpentrialBalance').submit(); 
      }

      $(document).ready(function () {
        var altPressed = false;
        $(document).keydown(function (event) {
          if(event.which == 18) 
            altPressed = true;
          if(altPressed) {
            switch(event.which)
            {
               case 79:
                   $('#btnOp').trigger('click');
                   return false;
                   break;
               case 71:
                   $('#btnGrp').trigger('click');
                   return false;
                   break;
               case 76:
                   $('#btnLed').trigger('click');
                   return false;
                   break;
                case 67:
                   $('#btnContra').trigger('click');
                   return false;
                   break;
                case 74:
                   $('#btnJournal').trigger('click');
                   return false;
                   break;
                case 82:
                   $('#btnReceipt').trigger('click');
                   return false;
                   break;
                case 80:
                   $('#btnPayment').trigger('click');
                   return false;
                   break;
                case 66:
                   $('#btnBal').trigger('click');
                   return false;
                   break;
                case 73:
                   $('#btnIE').trigger('click');
                   return false;
                   break;
                case 89:
                   $('#btnRP').trigger('click');
                   return false;
                   break;
                case 84:
                   $("#btnTB")[0].click();
                   return false;
                   break;
                case 72:
                   $("#btnTB")[0].click();
                   return false;
                   break;
            }
          }
        });

        $(document).keyup(function (event) {
          if(event.which == 18) 
            altPressed = false;
        });
      });

      $(document).ready(function () {
        var ctrlPressed = false;
        $(document).keydown(function (event) {
          if(event.which == 17) 
            ctrlPressed = true;
          if(ctrlPressed) {
            switch(event.which)
            {
               case 81:
                   $('#btnOp').trigger('click');
                   return false;
                   break;
            }
          }
        });

        $(document).keyup(function (event) {
          if(event.which == 17) 
            ctrlPressed = false;
        });
      });
    </script>
  </body>
</html>