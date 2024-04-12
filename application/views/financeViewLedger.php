<?php error_reporting(0); ?>
<style type="text/css">
	.breakup:hover{
		color:#800000;
	}
</style>

<?php
$opItems = array();
$otherItems = array();

foreach ($ledgerDetails as $item) {
    if ($item->RP_TYPE === "OP") {
        $opItems[] = $item;
    } else {
        $otherItems[] = $item;
    }
}

// Merge OP items and other items with OP items first
$sortedData = array_merge($opItems, $otherItems);

?>

<div class="container">
<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
</div>
      <div class="container">
           <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
      	<h3><label style="margin-left:-25px">Ledger summary of :
      	<b><?php echo $ledgerName ?>
         </b>
         <?php  if($TYPE_ID == "A"){
      	echo "(Asset)";
          }else if($TYPE_ID == "L"){
          echo "(Liability)";
          } else if($TYPE_ID == "I"){
          	echo "(Income)";
          }else{
          	echo "(Expense)";
          }?>
          </label><h3>
      
      </div>
<!-- adding the code here start by adithya -->
<!--new code added by adithya  -->
<form id="frmOpenReceiptPayment" action="<?=site_url()?>finance/ViewLedger" method="post" >

<div class="container row" style="clear:both;" class="form-group" >

<div class=" col-lg-3 col-md-3 col-sm-3 col-xs-3" style="margin-left:60px">
<b style="margin-left:-80px">Committee :</b>
<select id="CommitteeId" name="CommitteeId" class="form-control" style="margin-left:-90px; margin-top:8px;" onChange="onCommitteeChange();">
            	<option value="">All</option>
              <?php   if(!empty($committee)) {
                  foreach($committee as $row1) { 
                    if($row1->COMP_ID == $compId) { ?> 
                      <option value="<?php echo $row1->COMP_ID;?>" selected><?php echo $row1->COMP_NAME;?></option>
                    <?php } else { ?> 
                      <option value="<?php echo $row1->COMP_ID;?>"><?php echo $row1->COMP_NAME;?></option>
                  <?php } } } ?>
            </select>
		</div>

      <input name="FinancialYear" id="FinancialYear"    type="hidden" value=""  />
	
           <div class=" col-lg-2 col-md-2 col-sm-2 col-xs-2" style="margin-left:-30px; margin-top:10px" > 
	          <b>Financial Year : </b>
		       <select id="financialYearDropdown" name="finYear"  class="form-control" style="margin-top:-1px;" onclick="">	
		       </select>
           </div>
		</div>
	         <!-- new code end -->
			<div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2"  style="margin-left:-30px;">
				<b>From : </b>
				<div class="input-group input-group-sm">
					<input name="fromRP" id="fromRP"  type="text" value="<?php echo $fromDate; ?>" class="form-control fromRP" placeholder="dd-mm-yyyy" />
					<div class="input-group-btn">
						<button class="btn btn-default todayDate" type="button">
							<i class="glyphicon glyphicon-calendar"></i>
						</button>
					</div>
				</div>
			</div>
			<div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
				<b> To : </b>
				<div class="input-group input-group-sm">
					<input name="toRP" id="toRP"  type="text" value="<?php echo $toDate; ?>" class="form-control toRP" placeholder="dd-mm-yyyy" onchange="get_datefield_change(this.value)"/>
					<div class="input-group-btn">
						<button class="btn btn-default todayDate1" type="button">
							<i class="glyphicon glyphicon-calendar"></i>
						</button>
					</div>
				</div>
			</div>

	        <div class=" col-lg-4 col-md-4 col-sm-4 col-xs-4" style = "padding:10px">
               <a style="text-decoration:none;cursor:pointer; margin-left:210%" 
			        title="Back" onClick="goback()">
			  <img style="width:24px; height:24px;" 
			      title="Go back"  src="<?=site_url();?>images/back_icon.svg"/></a>
            </div>
	</div>	
</form>
<!-- addinf the code here end by adithya -->
<!-- <?php print_r($ledgerDetails) ?> -->
<!-- new code added by adithya start -->
<div class="container " style="border:2px solid #800000">
        <div class="container">
            <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12 " >
				<section> 
			        <table class="table" style="border:0px;">
					<tr style="border-bottom:2px solid #800000;">
								<h5><center><b>Debit</b><center></h5>
								
								<th width="10%">Date</th> 
								<th width="10%">PARTICULARS</th>
								 <th width="10%">Amount</th>
							</tr>
							<?php $total_dr = 0; 
							     $totalIncome = 0;
                               foreach($sortedData as $result){
                                if($result->FLT_DR !=0){
										$total_dr += $result->FLT_DR;		
								}
								if($result->FLT_CR !=0){
									$totalIncome += $result->FLT_CR;
								}
								?>
								
							<?php if(($result->RP_TYPE == 'OP' && $TYPE_ID == 'A') && $result->FLT_DR != 0) {?>
							<tr>
							   <td style="color:#800000"><?php echo $result->FLT_DATE ?></td>
							   <td>Opening Balance :To Balance B/d</td>	 
						   </tr>
							<tr>
								<td></td>	
								<td style="color:#800000"><?php echo $result->FGLH_NAME ?></td>
                                <td style="color:#800000"><?php echo $result->FLT_DR ?></td>	
							</tr>
							<?php } else if($result->Particular == '' ) { ?>
							<?php } else if($result->FLT_DR != 0) {?>
                            <tr>
								<td><?php echo $result->FLT_DATE ?></td>	
								<td><?php echo $result->Particular ?></td>
                                <td><?php echo  $result->FLT_DR?></td>	
							</tr>
                            <?php
							}
						} 
					 ?> 
					 <?php 
					  if($TYPE_ID == 'L') {?>
					  <?php if($total_dr >$totalIncome) {?>
					  
					 <?php } else {?>
						
								<?php
								$diff_L = 0; 
								   if($totalIncome >= $total_dr) {
									$diff_L = $totalIncome - $total_dr;
								}else{
									$diff_L = $total_dr - $totalIncome;
								} ?>
							   <tr>
							   <td style="color:#800000;"><?php echo  $toDate ?></td>
								<td>Closing Amount : To Balance B/d</td>
							   </tr>
							   <tr>
							  <td></td>
						        <td style="color:#800000;"><?php echo  $ledgerName ?></td>	
								<td style="color:#800000;"><?php echo $diff_L ?></td>
							</tr>
							
						<?php }?>
					     
					<?php   } else if($TYPE_ID == 'I') {?> 
						   <?php
								$diff_L = 0; 
								   if($totalIncome >= $total_dr) {
									$diff_L = $totalIncome - $total_dr;
								}else{
									$diff_L = $total_dr - $totalIncome;
								} ?>
							   <tr>
								   <td></td>
								   <td>By Balance Transferred to I/E a/c  :</td>
							   </tr>
							<tr>
								<td></td>
						        <td style="color:#800000;"><?php echo $ledgerName ?></td>	
								<td style="color:#800000;"><?php echo $diff_L ?></td>
							</tr>
							
						<?php }?>
						<?php if($TYPE_ID == 'A') {?>
							<tr>
								<?php
								$diff_A = 0; 
								
								   if($totalIncome >= $total_dr) {
									$diff_A = $totalIncome - $total_dr;
								}else{
									$diff_A = $total_dr - $totalIncome;		
								} ?>

								<?php if($totalIncome > $total_dr){?>
							   <tr>
								<td style="color:#800000;"><?php echo  $toDate ?></td>
								<td>Closing Amount : To Balance C/d </td>
							   </tr>
							<tr>
							       <td></td>
						            <td style="color:#800000;"><?php echo $ledgerName ?></td>	
							       <td style="color:#800000;"><?php echo $diff_A ?></td>
							</tr>
							<?php }?>
							<?php } ?>


					</table> 
				</section> 
			</div>

			<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
					<section> 
						<table class="table" style="border:0px;">
							<tr style="border-bottom:2px solid #800000;">
								<h5><center><b>Credit</b><center></h5>
								<th width="10%">Date</th>
								<th width="10%">PARTICULARS</th>
								<th width="10%">Amount</th>
							</tr>
							<?php $total_cr = 0; 
							      $totalExpense = 0;
							    foreach($sortedData  as $result){
                                if($result->FLT_CR !=0){
									$total_cr+=$result->FLT_CR;
								}
								if($result->FLT_DR !=0){
									$totalExpense += $result->FLT_DR;
								}
								?>
									<?php if((($result->RP_TYPE == 'OP' ) && $TYPE_ID == 'L') && $result->FLT_CR != 0) {?>
										<tr>
										<td style="color:#800000"><?php echo $result->FLT_DATE ?></td>	
											<td>Opening Balance :By Balance B/d </td>
										</tr>
							               <tr>
								            <td></td>
								             <td style="color:#800000"><?php echo $result->FGLH_NAME ?></td>
                                             <td style="color:#800000"><?php echo $result->FLT_CR ?></td>	
							               </tr>
										  
									<?php } else if($result->Particular == '') {?>
									
									<?php } else if($result->FLT_CR != 0){?>
                                  <tr>
								     <td><?php echo $result->FLT_DATE ?></td>	
								     <td><?php echo $result->Particular ?></td>
                                     <td><?php echo $result->FLT_CR ?></td>	
							      </tr>
                            <?php 
							 } 
                            } ?> 

                            <?php if($total_dr > $total_cr) {?>
								<?php if($TYPE_ID == 'L') {?>
					    
								<?php
								$diff_L = 0; 
								   if($totalIncome >= $total_dr) {
									$diff_L = $totalIncome - $total_dr;
								}else{
									$diff_L = $total_dr - $totalIncome;
								} ?>
							   <tr>
								     <td style="color:#800000;"><?php echo  $toDate ?></td>
								     <td>Closing Amount : To Balance B/d</td>
							   </tr>

							   <tr>
							     <td></td>
						          <td style="color:#800000;"><?php echo  $ledgerName ?></td>	
							     <td style="color:#800000;"><?php echo $diff_L ?></td>
							   </tr>
					
					<?php }
							}?>
  
							<?php if($TYPE_ID == 'A') {?>
							
								<?php
								$diff_A = 0; 
								
								   if($total_cr >= $total_dr) {
									$diff_A = $total_cr - $total_dr;
								}else{
									$diff_A = $total_dr - $total_cr;		
								} ?>

								<?php if($total_cr < $total_dr){?>
							   <tr>
								<td style="color:#800000;"><?php echo  $toDate ?></td>
								<td>Closing Amount : By Balance C/d </td>
							   </tr>
							<tr>
							    <td></td>
						        <td style="color:#800000;"><?php echo $ledgerName ?></td>	
							    <td style="color:#800000;"><?php echo $diff_A ?></td>
							</tr>
							
							<?php }?>
							<?php } else if($TYPE_ID == 'E') {?>
						
								<?php
								$diff_A = 0; 
								
								   if($total_cr >= $total_dr) {
									$diff_A = $total_cr - $total_dr;
								}else{
									$diff_A = $total_dr - $total_cr;	
								} ?>
							   <th>To Balance Transferred to I/E a/c : </th>
							   <tr>
								<td></td>
						        <td style="color:#800000;"><?php echo $ledgerName; ?></td>	
								<td style="color:#800000;"><?php echo  $totalExpense;?></td>
							</tr>
							<?php }?>
					

						</table> 
					</section>
			</div>
		</div>	   
		<div class="container">
				<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
					<section> 
						<table class="table"  >
							<tr style='border-top:2px solid#800000;padding:50px;'>
								<th width="60%"><h6><b>Total:</b></h6></th> 
								
								<th width="20%">
									<?php if($TYPE_ID == 'I') { echo $totalIncome;?>
										
									<?php }else {?>
									<?php  if($total_dr < $total_cr){
										if($TYPE_ID == "A"){
											echo  $total_dr + $diff_A ;	
										}else{
											echo  $total_dr + $diff_L ;
										}   
									} 
									else {
									echo  $total_dr ;
									} 
								}
								 ?></th> 
								<th></th>
							</tr>

						</table> 
					</section> 
				</div>

				<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
					<section> 
						<table class="table"  >
							<tr style='border-top:2px solid#800000;padding:50px;'>
								<th width="60%"><h6><b>Total:</b></h6></th> 
								<?php   ?>
								<th> </th>
								<th width="20%" >
									<?php if($TYPE_ID == 'E'){
                                     echo $totalExpense;
									} else {?>
									<?php if($total_cr < $total_dr){
										if($TYPE_ID == 'L'){
											echo $diff_L;
										}else{
											echo $total_cr  + $diff_A ;	
										}
								} else{
									echo  $total_cr;
									// - $diff_A ;
								}
							}
								 ?></th> 
								<th></th>
							</tr>

						</table> 
					</section> 
				</div>
		</div>
</div>
<form>
   <input type="hidden" id="callFrom" name="" value="<?php echo $callFrom ?>">
</form>
<!-- new code added by adithya end -->

<script type="text/javascript">
 function goback(){
        let callFrom = $('#callFrom').val();
        if(callFrom==""){
            window.location.href = "<?=site_url() ?>finance/allGroupLedgerDetails";
        }else{
            window.history.back();
        } 
    }
	/////////////////////////new date code starting ///////////////////////////////////////
var currentTime = new Date();
	var Limit = currentTime.getFullYear();
   var newLimit = new Date("04-01-"+Limit);
  
	var maxDate = currentTime.getMonth() + 1 >= 4 ? currentTime.getFullYear() + 1 : currentTime.getFullYear();
	
    var minFinYear = '<?=$ledgerFinanceDate  ?>'
     var minDate = new Date(minFinYear.split("-")[2])

	 // Function to calculate financial years
function getFinancialYears(startYear) {
    const currentYear = new Date().getFullYear();
    const currentMonth = new Date().getMonth();

    // If the current month is April or later, include the current financial year
    const endYear = currentMonth >= 3 ? currentYear + 1 : currentYear;

    const financialYears = [];
    for (let year = startYear; year < endYear; year++) {
        financialYears.push(`${year}-${year + 1}`);
    }

    return financialYears;
}

// Get the backend year (assumed received from backend)
const backendYear = '<?=$ledgerFinanceDate?>'; // Assuming $ledgerFinanceDate is a PHP variable containing the backend year
let year = backendYear.split("-")[2];
// Parse backendYear to a number
const startYear = parseInt(year);

// Calculate financial years based on backend year
const financialYears = getFinancialYears(startYear);

// Populate the dropdown with financial years
const dropdown = document.getElementById('financialYearDropdown');
let finYears = financialYears.reverse();
financialYears.forEach(year => {
    const option = document.createElement('option');
    option.text = year;
    option.value = year;
    dropdown.add(option);
});

// Calculate and set the default financial year
const currentYear = new Date().getFullYear();
const currentMonth = new Date().getMonth();
let defaultFinancialYear = "";

if (currentMonth >= 3) {
    let sessionYear = '<?=$FinancialYear ?>';
    defaultFinancialYear = sessionYear ? sessionYear : `${currentYear}-${currentYear + 1}`;
} else {
    let sessionYear = '<?=$FinancialYear ?>';
    if(sessionYear){
		let sameDate = sessionYear.split("-")
		if(sameDate[0] === sameDate[1]){
			let oldDate = sameDate[0];
			let newDate = Number(sameDate[1]) + 1;
			defaultFinancialYear = `${oldDate}-${newDate}`;
		}
		else {
			defaultFinancialYear = sessionYear;
		}
	}
	else {
		defaultFinancialYear = `${currentYear - 1}-${currentYear}`;
	
}
}

let toDate = '<?=$toDate ?>';
let fromDate = '<?=$fromDate ?>'
dropdown.value = defaultFinancialYear;
$('#FinancialYear').val(defaultFinancialYear);

// Function to calculate start and end dates based on financial year
function calculateDates(financialYear,toDate,fromDate) {
    const startYear = parseInt(financialYear.split('-')[0]);
    const endYear = parseInt(financialYear.split('-')[1]);
	
    const startDate =fromDate ? fromDate : `01-04-${startYear}`;
    const endDate = toDate ? toDate: `31-03-${endYear}`;

    return {
        startDate,
        endDate
    };
}
// Set initial dates based on defaultFinancialYear
const initialDates = calculateDates(defaultFinancialYear,toDate,fromDate);

$('#fromRP').val(initialDates.startDate);
$('#toRP').val(initialDates.endDate);

// Event listener for financial year dropdown change
$('#financialYearDropdown').on('change', function(event) {
    // Get the selected financial year
    const selectedYear = $(this).val();
    $('#FinancialYear').val(selectedYear);
    
    // Calculate start and end dates based on selected financial year
    const { startDate, endDate } = calculateDates(selectedYear);

    // Set start and end dates in the respective input fields
    $('#fromRP').val(startDate);
    $('#toRP').val(endDate);

	// const formData = $('#frmOpenBalSheet').serialize();

    // Trigger form submission
    $('#frmOpenReceiptPayment').submit();
});
	 
/////////////////////////////new date code ending////////////////////////////////////////////////////////


let frommin =  $('#fromRP').val();
   let fromminYear = frommin.split("-")[2];
   let frmomaxYear = Number(fromminYear) + 1;
   let Financeyear = $('#financialYearDropdown').val();
 let minmaxYear =Financeyear.split("-"); 

	$('#fromRP').css('border-color','black');
	$( ".fromRP" ).datepicker({
		minDate: "01-04-"+minmaxYear[0],
		maxDate:  "31-03-"+minmaxYear[1],
		dateFormat: 'dd-mm-yy',
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50",
		// onSelect: function(selected) {
	    //   $("#toRP").datepicker("option","minDate", selected);
	    //   get_datefield_change();
	  	// }
	});

	$('.todayDate').on('click',function() {
		$( ".fromRP" ).focus();
	});
	let min =  $('#fromRP').val();
	let minYear = min.split("-")[2];
   let maxYear = Number(minYear) + 1;
	$('#toRP').css('border-color','black');
	$( ".toRP" ).datepicker({
		minDate:"01-04-"+minmaxYear[0],
		maxDate:"31-03-"+minmaxYear[1],
		dateFormat: 'dd-mm-yy',
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50",
		// onSelect: function(selected) {
	    //   $("#toRP").datepicker("option","minDate", $('#fromRP').val());
	    //   get_datefield_change();
	    // }
	});

	$('.todayDate1').on('click',function() {
		$( ".toRP" ).focus();
	});

	function get_datefield_change(date) {
		let count = 0;
		if(!$('#fromRP').val()) {
			$('#fromRP').css('border', "1px solid #FF0000"); 
			++count
		} else {
			$('#fromRP').css('border', "1px solid #000000"); 
		}

		if(!$('#toRP').val()) {
			$('#toRP').css('border', "1px solid #FF0000"); 
			++count
		} else {
			$('#toRP').css('border', "1px solid #000000"); 
		}

		if(count != 0) {
			alert("Information","Please fill required fields","OK");
			return false;
		}
		$("#frmOpenReceiptPayment").submit();
		getProgressSpinner();
	}

	function onCommitteeChange(){
        $('#frmOpenReceiptPayment').submit();   
     }

</script>
