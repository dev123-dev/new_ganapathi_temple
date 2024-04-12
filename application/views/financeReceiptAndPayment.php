<?php error_reporting(0); ?>
<style type="text/css">
	.breakup:hover{
		color:#800000;
	}
</style>
<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />

	<div class="row form-group">							
		<div class="col-lg-4 col-md-12 col-sm-8 col-xs-8" style = "padding-right:0px;padding-top:10px;">
			<h3 style="margin-top:0px"><b>Receipt and Payment For</b></h3>
		</div>
		<div class="col-lg-3 col-md-10 col-sm-10 col-xs-8">
        <form id="frmCommitteeChange" action="<?=site_url()?>finance/displayReceiptAndPayment" method="post">
            <select id="CommitteeId" name="CommitteeId" class="form-control" style="margin-left:-80px; margin-top:8px;" onChange="onCommitteeChange();">
            	<option value="">All</option>
              <?php   if(!empty($committee)) {
                  foreach($committee as $row1) { 
                    if($row1->COMP_ID == $compId) { ?> 
                      <option value="<?php echo $row1->COMP_ID;?>" selected><?php echo $row1->COMP_NAME;?></option>
                    <?php } else { ?> 
                      <option value="<?php echo $row1->COMP_ID;?>"><?php echo $row1->COMP_NAME;?></option>
                  <?php } } } ?>
            </select>
        </form>               
      </div>
	</div>

<form id="frmOpenReceiptPayment" action="<?=site_url()?>finance/displayReceiptAndPayment" method="post" >
		
	<!--new code added by adithya  -->
	<input name="FinancialYear" id="FinancialYear"    type="hidden" value=""  />
	<b style="margin-left:-15%">Financial Year : </b>
	<div class=" col-lg-2 col-md-2 col-sm-2 col-xs-2" style="margin-left: -15px;"  > 
	
		<select id="financialYearDropdown" name="finYear"  class="form-control" style="margin-top:18px;" onclick="">
			<!-- <option value=""></option> -->
		</select>
				</div>
	<!-- new code end -->
	
	
	<div class="container row" style="clear:both;" class="form-group" >
			<div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2"  style="margin-left: -15px;">
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
		</div>
	</form>

	<div class="col-lg-12 col-md-12 col-sm-8 col-xs-8 pull-right text-right" style = "padding-right:0px;padding-bottom:10px;padding-top:10px; margin-top:-4em">
		<a style="text-decoration:none;cursor:pointer;margin-right: -30px" href="<?=site_url()?>finance/displayReceiptAndPayment" title="Refresh"><img style="width:24px; height:24px" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
	</div>

		<div class="container" style="border: 2px solid#800000;padding: 5px;">
			<div class="row form-group">
				<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
					<section> 
						<table class="table" style="border:0px;">
							<tr style="border-bottom:2px solid #800000;">
								<h3><b><center>Receipt</center></b></h3>
								<th width="60%">PARTICULARS</th>
								<th width="20%">Amount</th>
								<th width="20%">Amount</th>
							</tr>
							<?php
							$i=1;
							$sum_op=0;
							echo "<tr style='border-bottom:2px solid#f1e5e5;'>";
							echo "<td><u>Opening Balance</u></td>";
							echo "</tr>";
							foreach($opening as $row){
								echo "<tr>";
								echo "<td>".$row->FGLH_NAME."</td>";
								echo "<td>".$row->AMOUNT."</td><td></td>";
								$sum_op+=$row->AMOUNT;
								echo "</tr>";
								$i++;
							}
							echo "<tr style='border-bottom:2px solid#f1e5e5;'>";
							echo "<td></br></td> <td> </td> <td> </td>";
							echo "</tr>";
                            
							$some=0;$trail=0;$x=1;$sum_dr=0;$i=1;
							
							foreach($receipt as $row) {
								if($row->LEVELS == 'SG'){
									$trail = $row->FGLH_ID;
									$y=1;
									$some=0;
									foreach($receipt as $row1) {
										if($row1->FGLH_PARENT_ID == $trail) {	
											$some+=$row1->AMT;
										}
										$y++;
									}
									if($some>0){ ?>						
										<tr class="child-row<?php echo $row->LEDGER_PRIMARY_PARENT_CODE; ?>" style="display: none;border-bottom:2px solid#f1e5e5;">
											<td><?php echo $row->FGLH_NAME; ?></td>
										</tr>
									<?php }
								}
								$x++;
								if($row->AMT != 0 || $row->PBalance != 0  ) {
									if($row->LEVELS =='LG'){ ?>
										<tr class="child-row<?php echo $row->LEDGER_PRIMARY_PARENT_CODE; ?> parent"  id="rowSub<?php echo $row->FGLH_ID; ?>" style="display: none;border-bottom:2px solid#f1e5e5;">
											<td><a class="breakup" style="text-decoration:none;cursor: pointer;"><?php echo $row->FGLH_NAME; ?></a></td>
											<td><?php echo $row->AMT ?></td>
											<?php $sum_dr+=$row->AMT  ?> 
										</tr>
										<?php foreach($Cash as $row2) {
											if($row->FGLH_ID == $row2->FGLH_ID && $row2->CASH>0) {?> 
												<tr class="child-rowSub<?php echo $row2->FGLH_ID; ?> childClose-row<?php echo $row->LEDGER_PRIMARY_PARENT_CODE; ?>" style="display: none;border-bottom:2px solid#f1e5e5;">
												<td><a class="breakup" style="text-decoration:none;cursor: pointer;color:#ca7933 !important;" onClick="recPaybreakupDetails('<?=$row2->FGLH_ID; ?>','<?php echo str_replace("'","\'",$row2->FGLH_NAME);?>','<?=$row2->COMP_ID; ?>')">&emsp;&emsp;-><?php echo $row2->COMP_NAME; ?></td>
												<td style="color:#ca7933 !important;"><?php echo $row2->CASH; ?></td>
												</tr>
											<?php }
										} ?>
							<?php }else{ ?> 
								<tr class="parent" id="row<?php echo $row->FGLH_ID; ?>" name="" title="Click to expand/collapse" style="cursor: pointer;border-bottom:2px solid#f1e5e5;">
									<td><?php echo $row->FGLH_NAME; ?></td>
									<td></td>
									<td>
										<?php echo $row->PBalance  ?>
									
								</td>
								</tr>
							<?php  } ?>
							<?php }
								$i++;
							}?>
						</table> 
					</section> 
				</div>

				<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
					<section> 
						<table class="table" style="border:0px;">
							<tr style="border-bottom:2px solid #800000;">
								<h3><b><center>Payment </center></b></h3>
								<th width="60%">PARTICULARS</th>
								<th width="20%">Amount</th>
								<th width="20%">Amount</th>
							</tr>
							<?php
							
							$some=0;$trail=0;$x=1;$sum_cr=0;$i=1;
						
							foreach($payment as $row) {
								if($row->LEVELS == 'SG'){
									$trail = $row->FGLH_ID;
									$y=1;
									$some=0;
									foreach($payment as $row1) {
										if($row1->FGLH_PARENT_ID == $trail) 
										{	
											$some+=$row1->AMT;
										}
										$y++;
									}
									if($some>0) { ?>						
										<tr class="child-row<?php echo $row->LEDGER_PRIMARY_PARENT_CODE; ?>" style="display: none;border-bottom:2px solid#f1e5e5;">
											<td><?php echo $row->FGLH_NAME; ?></td>
										</tr>
									<?php }
								}
								$x++;

								if($row->AMT != 0 || $row->PBalance != 0  ) {
									if($row->LEVELS =='LG'){ ?>
								
										<tr class="child-row<?php echo $row->LEDGER_PRIMARY_PARENT_CODE; ?> parent"  id="rowSub<?php echo $row->FGLH_ID; ?>" style="display: none;border-bottom:2px solid#f1e5e5;">
											<td><a class="breakup" style="text-decoration:none;cursor: pointer;"><?php echo $row->FGLH_NAME; ?></a></td>
											<td><?php echo $row->AMT ?></td>
											<?php $sum_cr+=$row->AMT; ?> 
										</tr>
										<?php foreach($Cash as $row2) {
											if($row->FGLH_ID == $row2->FGLH_ID && $row2->CASH>0) {?> 
												<tr class="child-rowSub<?php echo $row2->FGLH_ID; ?> childClose-row<?php echo $row->LEDGER_PRIMARY_PARENT_CODE; ?>" style="display: none;border-bottom:2px solid#f1e5e5;">
												<td><a class="breakup" style="text-decoration:none;cursor: pointer;color:#ca7933 !important;" onClick="recPaybreakupDetails('<?=$row2->FGLH_ID; ?>','<?php echo str_replace("'","\'",$row2->FGLH_NAME);?>','<?=$row2->COMP_ID; ?>')">&emsp;&emsp;-><?php echo $row2->COMP_NAME; ?></td>
												<td style="color:#ca7933 !important;"><?php echo $row2->CASH; ?></td>
												</tr>
											<?php }
										} ?>
							<?php }else{ ?> 
									<tr class="parent" id="row<?php echo $row->FGLH_ID; ?>" name="" title="Click to expand/collapse" style="cursor: pointer;border-bottom:2px solid#f1e5e5;">
										<td><?php echo $row->FGLH_NAME; ?></td>
										<td></td>
										<td><?php echo $row->PBalance ?></td>
									</tr>
							<?php  } ?>
							<?php  }
							$i++;
							}
							echo "<tr style='border-bottom:2px solid#f1e5e5;'>";
							echo "<td></br></td> <td> </td> ";
							echo "</tr>";

							echo "<tr style='border-bottom:2px solid#f1e5e5;'>";
							echo "<td><u>Closing Balance</u></td><td> </td><td> </td>";
							echo "</tr>";
							$sum_close=0;
							$i=1;
							foreach($closing as $row) {
								echo "<tr style='border-bottom:2px solid#f1e5e5;'>";
								echo "<td>".$row->FGLH_NAME."</td>";
								echo "<td>".$row->AMOUNT."</td>";
								$sum_close+=$row->AMOUNT;
								echo "</tr>";
								$i++;
							}
							?>
						</table> 
					</section> 
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
					<section> 
						<table class="table"  >
							<tr style='border-top:2px solid#800000;padding:50px;'>
								<th width="60%"><h6><b>Total:</b></h6></th> 
								<?php  $receipt_tot=$sum_dr+$sum_op?>
								<th width="20%"><?php echo "<h6><b>".$receipt_tot."</b></h6>";?></th> 
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
								<?php  $payment_tot=$sum_cr+$sum_close?>
								<th width="20%"><?php echo "<h6><b>".$payment_tot."</b></h6>";?></th> 
								<th></th>
							</tr>

						</table> 
					</section> 
				</div>
			</div>
		</div>
</div>

<form id="ReceiptbreakupDetailForm" action="" method="post">
	<input type="hidden" id="FGLH_ID" name="FGLH_ID" />
	<input type="hidden" id="FGLH_NAME" name="FGLH_NAME" />	
	<input type="hidden" id="from" name="from" />
	<input type="hidden" id="to" name="to" />
	<input type="hidden" id="compIdVal" name="compIdVal" value="" />
	<input type="hidden" id="openedRows" name="openedRows" value="" />
</form>

<script type="text/javascript">
	$(document).ready(function () {    
        $('tr.parent')  
            .css("cursor", "pointer")  
            .attr("title", "Click to expand/collapse")  
            .click(function () {  
                $(this).siblings('.child-' + this.id).toggle(); 
                $(this).siblings('.childClose-' + this.id).hide(); 
                $(this).toggleClass("opened");
        });  
    });

    $(document).ready(function () { 
    	let openItems='<?php echo @$openedRowsActive ?>';
    	if(openItems!=""){
	    	let arrOpen =openItems.split(",");
	    	for(let i=0;i<arrOpen.length-1;i++){
	            $('#'+arrOpen[i]).siblings('.child-'+arrOpen[i]).toggle(); 
	            $('#'+arrOpen[i]).siblings('.childClose-'+arrOpen[i]).hide(); 
	        	$('#'+arrOpen[i]).toggleClass("opened");
	        }
	    }
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
		}else{
			defaultFinancialYear = sessionYear;
		}
		
	}else{
		defaultFinancialYear = `${currentYear - 1}-${currentYear}`;
	}
	console.log("defaultFinancialYear",defaultFinancialYear)

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

	function recPaybreakupDetails(FGLH_ID,FGLH_NAME,COMP_ID=""){
		$('#FGLH_ID').val(FGLH_ID);
		$('#FGLH_NAME').val(FGLH_NAME);
		let from = $('#fromRP').val();
		let to = $('#toRP').val();
		let commid = $('#CommitteeId').val();
		$('#from').val(from);
		$('#to').val(to);	
		if(COMP_ID!=""){
			$('#compIdVal').val(COMP_ID);	
		} else {
			$('#compIdVal').val(commid);
		}	
		let selActiveRows="";
		var checkInput = document.getElementsByClassName("opened");
	    for(var i = 0; i < checkInput.length; i++) {
	        selActiveRows += checkInput[i].id+",";
	    }
	    $('#openedRows').val(selActiveRows);
		$('#ReceiptbreakupDetailForm').attr('action','<?=site_url()?>finance/RPledgerSummaryDetail');
		$('#ReceiptbreakupDetailForm').submit();
	}

	function onCommitteeChange(){
	    $('#frmCommitteeChange').submit();   
	}
</script>
