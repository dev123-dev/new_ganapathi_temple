<?php error_reporting(0); ?>
<style type="text/css">
	.breakup:hover{
		color:#800000;
	}
</style>
<div class="container">
<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />

<div class="row form-group">
	<div class="col-lg-3 col-md-10 col-sm-10 col-xs-8" style = "padding-right:0px;padding-top:10px;">
			<h3 style="margin-top:0px"><b>Trial Balance For</b></h3>
	</div>
	 <div class="col-lg-3 col-md-10 col-sm-10 col-xs-8">
        <form id="frmCommitteeChange" action="<?=site_url()?>Trustfinance/displayTrialBalance" method="post">
            <select id="CommitteeId" name="CommitteeId" class="form-control" style="margin-left:-80px; margin-top:8px;" onChange="onCommitteeChange();">
            	<option value="">All</option>
              <?php   if(!empty($committee)) {
                  foreach($committee as $row1) { 
                    if($row1->T_COMP_ID == $compId) { ?> 
                      <option value="<?php echo $row1->T_COMP_ID;?>" selected><?php echo $row1->T_COMP_NAME;?></option>
                    <?php } else { ?> 
                      <option value="<?php echo $row1->T_COMP_ID;?>"><?php echo $row1->T_COMP_NAME;?></option>
                  <?php } } } ?>
            </select>
        </form>               
      </div>
</div>

<form id="frmOpenTrailBalance" action="<?=site_url()?>Trustfinance/displayTrialBalance" method="post" >
<!--new code added by adithya  -->
<input name="FinancialYear" id="FinancialYear"   type="hidden" value=""  />
<b style="margin-left:-15%">Financial Year : </b>
<div class=" col-lg-2 col-md-2 col-sm-2 col-xs-2" style="margin-left: -15px;"  > 
	
	<select id="financialYearDropdown" name="finYear"  class="form-control" style="margin-top:18px;" onclick="">
		
	</select>
			</div>
<!-- new code end -->

	<div class="container row" style="clear:both;" class="form-group" >
		<div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2"  style="margin-left: -15px;">
			<b>From : </b>
			<div class="input-group input-group-sm">
				<input name="fromTB" id="fromTB" type="text" value="<?php echo $fromDate; ?>" class="form-control fromTB" placeholder="dd-mm-yyyy" />
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
				<input name="toTB" id="toTB" type="text" value="<?php echo $toDate; ?>" class="form-control toTB" placeholder="dd-mm-yyyy" onchange="get_datefield_change(this.value)"/>
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
	<a style="text-decoration:none;cursor:pointer;margin-right: -30px" href="<?=site_url()?>Trustfinance/displayTrialBalance" title="Refresh"><img style="width:24px; height:24px" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
</div>
	
<div class="container-fluid container" style="border: 2px solid#800000;padding: 5px;" >
	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12" >
			<section> 
				<table class="table"> 
					<tr style="border-bottom:2px solid#800000;">
						<th>PARTICULARS</th> 
						<th>Debit Amount</th> 
						<th>Credit Amount</th>
					</tr> 
					<?php
					$sum_dr=0;$sum_cr=0;$i=1;
					foreach($trialData as $row) {
						echo "<tr>";
						if($row->Debit >0 || $row->Credit >0){
							if($row->T_LEVELS =='LG'){ 
							 ?>
								<td><a class="breakup" style="text-decoration:none;cursor: pointer;" onClick="TrailbreakupDetails('<?=$row->T_FGLH_ID; ?>','<?php echo str_replace("'","\'",$row->T_FGLH_NAME);?>')"><?php echo $row->T_FGLH_NAME; ?></a></td>
							<?php }else{ ?> 
								<td><?php echo $row->T_FGLH_NAME; ?></td>
							<?php  } ?>
							<?php if($row->T_TYPE_ID == 'A' || $row->T_TYPE_ID == 'E') {
								echo "<td>".$row->Debit."</td>";
								echo "<td>0</td>";
								$sum_dr+=$row->Debit;
							} else if($row->T_TYPE_ID == 'L' || $row->T_TYPE_ID == 'I'){
								echo "<td>0</td>";
								echo "<td>".$row->Credit."</td>";
								$sum_cr+=$row->Credit;
							}
						}
						echo "</tr>";
						$i++;
					}
					echo "<tr style='border-top:2px solid#800000;'>";
					echo "<td><h6><b>Total</b></h6></td>";
					echo "<td><h6><b>".$sum_dr."</b></h6></td>";
					echo "<td><h6><b>".$sum_cr."</b></h6></td>";
					echo "</tr>";
					?>
				</table> 
			</section> 
		</div>
	</div>
</div>	
<!--  -->
<form id="TrialbreakupDetailForm" action="" method="post">
	<input type="hidden" id="FGLH_ID" name="FGLH_ID" />
	<input type="hidden" id="FGLH_NAME" name="FGLH_NAME" />	
	<input type="hidden" id="from" name="from" />
	<input type="hidden" id="to" name="to" />
	<input type="hidden" id="compIdVal" name="compIdVal" value="<?php echo $compId; ?>" />
</form>
<script type="text/javascript">

	function get_datefield_change(date) {
		let count = 0;
		if(!$('#fromTB').val()) {
			$('#fromTB').css('border', "1px solid #FF0000"); 
			++count
		} else {
			$('#fromTB').css('border', "1px solid #000000"); 
		}
	
		if(!$('#toTB').val()) {
			$('#toTB').css('border', "1px solid #FF0000"); 
			++count
		} else {
			$('#toTB').css('border', "1px solid #000000"); 
		}
		
		if(count != 0) {
			alert("Information","Please fill required fields","OK");
			return false;
		}
		$("#frmOpenTrailBalance").submit();
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
finYears.forEach(year => {
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

$('#fromTB').val(initialDates.startDate);
$('#toTB').val(initialDates.endDate);
// Event listener for financial year dropdown change
$('#financialYearDropdown').on('change', function(event) {
    // Get the selected financial year
    const selectedYear = $(this).val();
    $('#FinancialYear').val(selectedYear);
    
    // Calculate start and end dates based on selected financial year
    const { startDate, endDate } = calculateDates(selectedYear);

    // Set start and end dates in the respective input fields
    $('#fromTB').val(startDate);
    $('#toTB').val(endDate);

	// const formData = $('#frmOpenBalSheet').serialize();

    // Trigger form submission
    $('#frmOpenTrailBalance').submit();
});
	 
/////////////////////////////new date code ending////////////////////////////////////////////////////////
let frommin =  $('#fromTB').val();
   let fromminYear = frommin.split("-")[2];
   let frmomaxYear = Number(fromminYear) + 1;
   let Financeyear = $('#financialYearDropdown').val();
 let minmaxYear =Financeyear.split("-");
	$('#fromTB').css('border-color','black');
	$( ".fromTB" ).datepicker({
		minDate: "01-04-"+minmaxYear[0],
		maxDate:  "31-03-"+minmaxYear[1],
		dateFormat: 'dd-mm-yy',
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50",
		onSelect: function(selected) {
          $("#toTB").datepicker("option","minDate", selected);
          get_datefield_change();
      	}
	});
	
	$('.todayDate').on('click',function() {
		$( ".fromTB" ).focus();
	});

	let min =  $('#fromTB').val();
	let minYear = min.split("-")[2];
   let maxYear = Number(minYear) + 1;
	$('#toTB').css('border-color','black');
	$( ".toTB" ).datepicker({
		minDate:"01-04-"+minmaxYear[0],
		maxDate:"31-03-"+minmaxYear[1],
		dateFormat: 'dd-mm-yy',
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50",
		onSelect: function(selected) {
          $("#toTB").datepicker("option","minDate", $('#fromTB').val());
          get_datefield_change();
        }
	});
	
	$('.todayDate1').on('click',function() {
		$( ".toTB" ).focus();
	});
	
	function TrailbreakupDetails(T_FGLH_ID,T_FGLH_NAME){
		$('#FGLH_ID').val(T_FGLH_ID);
		$('#FGLH_NAME').val(T_FGLH_NAME);
		let from = $('#fromTB').val();
		let to = $('#toTB').val();
		$('#from').val(from);
		$('#to').val(to);		
		$('#TrialbreakupDetailForm').attr('action','<?=site_url()?>Trustfinance/TrialledgerSummaryDetail');
		$('#TrialbreakupDetailForm').submit();
	}

	function onCommitteeChange(){
        $('#frmCommitteeChange').submit();   
    }
</script>
