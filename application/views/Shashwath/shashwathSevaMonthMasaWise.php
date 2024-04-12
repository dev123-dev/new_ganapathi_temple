<style type="text/css">
	#header-fixed {
	  background: white;
	  position: sticky;
	  top: 0; /* Don't forget this, required for the stickiness */
	  box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
	}
	#header-sticky{
		background: white;
	  	position: sticky;
	 	top: 0; /* Don't forget this, required for the stickiness */
	  	box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
	}
</style>

<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png">
	<form action="<?=site_url();?>Shashwath/allSevasMasaMonthFilter" enctype="multipart/form-data" method="post" id="allSevasMasaMonthchange">
		<div class="row form-group" style="margin-top:-0.5em">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:0em">
				<span class="eventsFont2">Shashwath Corpus Merge </span>
			</div>
			<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12" style="margin-top:1em">	
				<div class= "col-lg-6 col-md-6 col-sm-5 col-xs-12" id="HinduCal" style="display: block;" >
					<div id="moonThithi" style="margin-left: -28px;">
						<div class= "col-lg-3 col-md-4 col-sm-4 col-xs-12" style="width: 30%"> 
							<select id="masaCode" name="masaCode" class="form-control" onchange="masaMonthDDChange()"  >
								<option value="" style="display: none;"> Select Masa </option>
								<?php   if(!empty($masa1)) {
									foreach($masa1 as $row1) { ?> 
										<?php if($row1->MASA_NAME == $masa) { ?>
											<option value="<?php echo $row1->MASA_NAME;?>" selected><?php echo $row1->MASA_NAME;?> </option>
										<?php } else { ?>
											<option value="<?php echo $row1->MASA_NAME;?>"><?php echo $row1->MASA_NAME;?> </option>
										<?php } ?>
									<?php } } ?>
							</select>
						</div>
						<div class= "col-lg-3 col-md-4 col-sm-4 col-xs-12" style="width: 30%">
							<select id="thithiMasaCode" name="thithiMasaCode" style="height: 33px;margin-left:-10px;" onchange="masaMonthChange()">
								<option value="">Select ThithiCode</option>
							 <?php   if(!empty($masaThithiCode)) {
										foreach($masaThithiCode as $row1) { ?> 
											<?php if($row1->THITHI_CODE == $thithiMasaCode) { ?>
												<option value="<?php echo $row1->THITHI_CODE;?>" selected><?php echo $row1->THITHI_CODE;?> </option>
											<?php } else { ?>
												<option value="<?php echo $row1->THITHI_CODE;?>"><?php echo $row1->THITHI_CODE;?> </option>
											<?php } ?>
								<?php } } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="display: none;" id="gregorianCal">
					<div style="margin-left: -28px;">
						<div class= "col-lg-3 col-md-4 col-sm-4 col-xs-12" style="width: 30%"> 
							<select id="monthCode" class="form-control"  onchange="masaMonthDDChange()" >
								<option value="" style="display: none;"> Select Month </option>
									<?php if(isset($month)) {?>
										<?php if($month == "-01") { ?>
											<option selected value="-01">January</option>
										<?php } else { ?>
											<option value="-01">January</option>
										<?php } ?>
										<?php if($month == "-02") { ?>
											<option selected value="-02">February</option>
										<?php } else { ?>
											<option value="-02">February</option>
										<?php } ?>
										<?php if($month == "-03") { ?>
											<option selected value="-03">March</option>
										<?php } else { ?>
											<option value="-03">March</option>
										<?php } ?>
										<?php if($month == "-04") { ?>
											<option selected value="-04">April</option>
										<?php } else { ?>
											<option value="-04">April</option>
										<?php } ?>	
										<?php if($month == "-05") { ?>
											<option selected value="-05">May</option>
										<?php } else { ?>
											<option value="-05">May</option>
										<?php } ?>	
										<?php if($month == "-06") { ?>
											<option selected value="-06">June</option>
										<?php } else { ?>
											<option value="-06">June</option>
										<?php } ?>
										<?php if($month == "-07") { ?>
											<option selected value="-07">July</option>
										<?php } else { ?>
											<option value="-07">July</option>
										<?php } ?>
										<?php if($month == "-08") { ?>
											<option selected value="-08">August</option>
										<?php } else { ?>
											<option value="-08">August</option>
										<?php } ?>
										<?php if($month == "-09") { ?>
											<option selected value="-09">September</option>
										<?php } else { ?>
											<option value="-09">September</option>
										<?php } ?>
										<?php if($month == "-10") { ?>
											<option selected value="-10">October</option>
										<?php } else { ?>
											<option value="-10">October</option>
										<?php } ?>
										<?php if($month == "-11") { ?>
											<option selected value="-11">November</option>
										<?php } else { ?>
											<option value="-11">November</option>
										<?php } ?>
										<?php if($month == "-12") { ?>
											<option selected value="-12">December</option>
										<?php } else { ?>
											<option value="-12">December</option>
										<?php } ?>
									<?php } ?>
							</select>
						</div>
						<div class= "col-lg-3 col-md-4 col-sm-4 col-xs-12" style="width: 30%"> 
							<select id="selDate" name="selDate" style="height: 33px;margin-left:-10px;" onchange="masaMonthChange()">
								<option value="">Select Date</option>
							 		<?php if(!empty($engDates)) {
										foreach($engDates as $row1) { ?> 
											<?php if($row1->ENG_DATE == $selDate) { ?>
												<option value="<?php echo $row1->ENG_DATE;?>" selected><?php echo $row1->ENG_DATE;?> </option>
											<?php } else { ?>
												<option value="<?php echo $row1->ENG_DATE;?>"><?php echo $row1->ENG_DATE;?> </option>
											<?php } ?>
									<?php } } ?>
							</select>
						</div>
					</div>
				</div>
				<div class= "col-lg-6 col-md-6 col-sm-6 col-xs-12" style="display: none;" id="everyCal">	
					<div style="margin-left: -28px;">		
						<div class= "col-lg-3 col-md-4 col-sm-4 col-xs-12" style="width: 30%"> 
							<select id="everyCode" name="festivalCode" class="form-control" onchange="masaMonthDDChange()" >
								<?php if(isset($every)) {?>
									<?php if($every == "Year") { ?>
										<option selected value="Year">Year</option>
									<?php } else { ?>
										<option value="Year">Year</option>
									<?php } ?>
									<?php if($every == "Month") { ?>
										<option selected value="Month">Month</option>
									<?php } else { ?>
										<option value="Month">Month</option>
									<?php } ?>
									<?php if($every == "Week") { ?>
										<option selected value="Week">Week</option>
									<?php } else { ?>
										<option value="Week">Week</option>
									<?php } ?>	
								<?php } else { ?>
									<option value="">Select Every </option>
									<option value="Year">Year</option>
									<option value="Month">Month</option>
									<option value="Week">Week</option>
								<?php } ?>	
							</select>
						</div>
						<div class= "col-lg-3 col-md-4 col-sm-4 col-xs-12" style="width: 30%"> 
							<select id="selEvery" name="selEvery" style="height: 33px;margin-left:-10px;" onchange="masaMonthChange()">
								<option value="">Select </option>
							 		<?php if(!empty($everyCode)) {
										foreach($everyCode as $row1) { ?> 
											<?php if($row1->EVERY_WEEK_MONTH == $selEvery) { ?>
												<option value="<?php echo $row1->EVERY_WEEK_MONTH;?>" selected><?php echo $row1->EVERY_WEEK_MONTH;?> </option>
											<?php } else { ?>
												<option value="<?php echo $row1->EVERY_WEEK_MONTH;?>"><?php echo $row1->EVERY_WEEK_MONTH;?> </option>
											<?php } ?>
									<?php } } ?>
							</select>
						</div>
					</div>	
				</div>
				<div class= "col-lg-2 col-md-4 col-sm-4 col-xs-12" style="margin-left:-180px;">
					<!-- style="margin-left:-280px;" -->
					<div class="form-group">
						<input type="button" class="btn btn-default" style="text-decoration:none;cursor:pointer;"  title="search" 
						onclick="searchModal()" value="Name Filter" />
						<a style="text-decoration:none;cursor:pointer;" onclick="refreshMasaMonth()" title="Clear Name Filter" ><img style="width:24px; height:24px;margin-left:10px;" title="Clear Name Filter" src="<?=site_url();?>images/refresh1.png"/></a>
					</div>
				</div>
				<div class="col-lg-2 col-md-6 col-sm-4 col-xs-12 pull-right text-right" style="padding:0px 0px 0px;">
					<input type="button" class="btn btn-default" style="text-decoration:none;cursor:pointer;margin-left:-100px;"  title="Merge" onclick="merge()" value="Merge" /> 
					<a style="text-decoration:none;cursor:pointer;" onclick="goBack()" title="Refresh"><img style="width:24px; height:24px;margin-left:10px;" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
					<a style="margin-left: 9px;pull-right;" href="<?=site_url()?>Shashwath/shashwath_member" title="Back"><img style="width:24px; height:24px" src="<?=site_url();?>images/back_icon.svg"/></a>
				</div>
			</div>
		</div>
		<input type="hidden" name="selectedNames" id="selectedNames" value="">
		<input type="hidden" name="masa" id="masa" value="<?php echo $masa ?>">
		<input type="hidden" name="month" id="month" value="<?php echo $month ?>">
		<input type="hidden" name="every" id="every" value="<?php echo $every ?>">
		<!-- <input type="text" name="selectedId" id="selectedId" value=""/> -->
	</form>
</div>	
<div class="container">
	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-bordered" id="tblMasaMonth">
					<thead>
						<tr>
							<th></th>
							<th>Thithi / Date </th>
							<th>SS Receipt No</th>
							<th>Name</th>
							<th>Place</th>
							<th>Deity Name</th>
							<th>Seva Name</th>
							<th>Purpose</th>
							<th>Corpus</th>
							<th>Seva Qty</th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>				
			</div>
		</div>
	</div>
	<div class= "row">
		<ul class="pagination pagination-sm" style="margin-left:15px;margin-top: -1em;">
			<?=$pages; ?>
		</ul>
		<label class="pull-right" style="font-size:18px;margin-right:15px;margin-top: -1em;">Total Members: <strong style="font-size:18px"><?php echo $total_rows ?></strong></label>		
	</div>
</div>

<div id="searchModal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg" style="width: 65%;" >
		<div class="modal-content">
			<div class="modal-body">
					<div class="row">
						<div class="col-lg-6 col-md-12 col-sm-8 col-xs-8">
							<div class="row form-group">							
								<div class="col-lg-12 col-md-12 col-sm-8 col-xs-8" style = "padding-right:0px;padding-top:10px;">
									<h3 style="margin-top:0px">All Members</h3>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="table-responsive table-cont" id="table-cont" style="width:100%;max-height:700px;min-height:300px;overflow:scroll;display:block;overflow-x:hidden;" >
										<table id="searchingTable" class="table table-bordered table-hover table-striped" style="overflow-y: scroll;">
											<thead>
												<tr>
													<!-- <form >id="joinForm" method="POST" -->
														<th width="100%" id="#header-fixed">Search Name &nbsp;&nbsp;
															<input type="hidden" name="callFromGroup" id="callFromGroup" value="<?=@$callFrom;?>">
															<input id="idSrchName" class="" type="text" name="searchName" value="<?=@$searchName; ?>" placeholder="Search"  style="color: maroon;">
															<input type="button" value="Search" name="" onclick="searchFunction('false')" class="btn btn-default" style="height: 26px; padding: 1px 7px;">
															<a style="text-decoration:none;cursor:pointer;" onclick="clearSearchBox()" title="Refresh"><img style="width:24px; height:24px;margin-left:10px;color: white;" title="Refresh" src="<?=site_url();?>images/refreshwhite.png"/></a>
														</th>
													<!-- </form> -->
													<th width="10%"><center>OP</center></th>
												</tr>
											</thead>
											<tbody id="selectingElement">
												<?php $i = 1;
												 foreach($searchMasaMonthDetail  as $result) {
													echo "<tr class='y_$i serial'>";
													echo "<td class='si' style='display:none;'>".$i."</td>";
													echo "<td>".$result->SM_NAME."</td>";?>
													<td><center> <a title="Add Name" onclick="addMemberName('<?=$result->SM_ID; ?>','<?php echo str_replace("'","\'",$result->SM_NAME);?>','<?=$i;?>')"><img style="width:24px; height:24px" src="<?=site_url();?>images/add_icon.svg"/></a></center></td>
													<?php
													 echo "</tr>";
													$i++;
												} ?>
											</tbody>

										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-8 col-xs-8">
							<!-- <img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" /> -->
							<div class="row form-group">							
								<div class="col-lg-12 col-md-12 col-sm-8 col-xs-8" style = "padding-right:0px;padding-top:10px;">
									<h3 style="margin-top:0px">Selected Members</h3>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="table-responsive table-cont1"  id="table-cont1" style="width:100%;max-height:700px;min-height:300px;overflow:scroll;display: block;overflow-x: hidden;">
										<table id="searchedTable" class="table table-bordered table-hover table-striped">
											<thead id="#header-sticky">
												<tr>
													<th width="90%">Name</th>
													<th width="10%"><center>OP</center></th>
												</tr>
											</thead>
											<tbody id="selectedElement">
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
			 
				<div class="modal-footer" style="text-align:left;">
					<button type="button" style="width: 8%;" class="btn " id="submit" onclick="searchSubmit()">Yes</button>
					<button type="button" style="width: 8%;" class="btn " onclick="clearall()">No</button>
				</div>
			</div>
		</div>
	</div>
</div>

<form action="<?=site_url();?>Shashwath/shashwathAddlCorpusMerge" enctype="multipart/form-data" method="post" id="mergeForm">
	<input type="hidden" name="selectedMembersSearchItems" id="selectedMembersSearchItems" value="">
	<input type="hidden" name="selectedMembersSearchSsId" id="selectedMembersSearchSsId" value="">
	<input type="hidden" name="call" id="call" value="<?php echo $base_url ?>">
</form>

<form  action="<?=site_url();?>Shashwath/allSevasMasaMonth" enctype="multipart/form-data" method="post" id="masaMonthchangeForm">
	<input type="hidden" name="masa" id="masaChangeVal" value="">
	<input type="hidden" name="month" id="monthChangeVal" value="">
	<input type="hidden" name="every" id="everyChangeVal" value="">
</form>

<script>
	var arrSelectedItems = []; 
	var arrSelectedSMID = [];
	var arrSelectedDeity = [];
	var arrSelectedSeva = [];
	var arrSelectedDateMasa = [];
	var arrLocalItems = []; 
	var arrItems = []; 
	
	$(document).ready(function() {
	    if(sessionStorage.getItem("SelectedItems") !== null && sessionStorage.getItem("SelectedItems") != "") {
	    	arrSelectedItems = JSON.parse(sessionStorage.getItem("SelectedItems"));	
	    	arrSelectedSMID = JSON.parse(sessionStorage.getItem("SelectedSMID"));	 
	    	arrSelectedDeity = JSON.parse(sessionStorage.getItem("SelectedDeity"));	
	    	arrSelectedSeva = JSON.parse(sessionStorage.getItem("SelectedSeva"));
	    	arrSelectedDateMasa = JSON.parse(sessionStorage.getItem("SelectedDateMasa"));	
	    }
	   	else {
	   		arrSelectedItems = [];
	   		arrSelectedSMID = [];
	   		arrSelectedDeity = [];
	   		arrSelectedSeva = [];
	   		arrSelectedDateMasa = [];
	   	} 

		let dateMasa = "";
	   	arrItems = <?php echo $masaMonthDetail; ?>;
	    for(var i = 0; i < arrItems.length; i++) {
	    	if(arrItems[i]["THITHI_CODE"] != ""){
	    		dateMasa = arrItems[i]['THITHI_CODE'];
	    	} else if(arrItems[i]["ENG_DATE"] !="" ){
	    		dateMasa = arrItems[i]['ENG_DATE'];
	    	} else{
	    		dateMasa = arrItems[i]['EVERY_WEEK_MONTH'];
	    	}
    		if(sessionStorage.getItem("SelectedItems") !== null && sessionStorage.getItem("SelectedItems") != "") {
    			if(arrSelectedItems.indexOf(parseInt(arrItems[i]["SS_ID"])) > -1) {
    				arrLocalItems.push(parseInt(arrItems[i]["SS_ID"]));
    				$('#tblMasaMonth').append('<tr class="row1">	<td><center><input id="checkerId_'+i+'" type="checkbox" onchange="GetOnSelection('+arrItems[i]["SS_ID"]+','+arrItems[i]["SM_ID"]+',\''+dateMasa+'\','+arrItems[i]["DEITY_ID"]+','+arrItems[i]["SEVA_ID"]+',this.checked)" checked /></center></td><td>'+dateMasa+'</td><td>'+arrItems[i]["SS_RECEIPT_NO"]+'</td><td>'+arrItems[i]["SM_NAME"]+'</td><td>'+arrItems[i]["PLACE"]+'</td><td>'+arrItems[i]["DEITY_NAME"]+'</td><td>'+arrItems[i]["SEVA_NAME"]+'</td><td>'+arrItems[i]["SEVA_NOTES"]+'</td><td>'+arrItems[i]["CORPUS"]+'</td><td>'+arrItems[i]["SEVA_QTY"]+'</td><td class="cId" id="catid_'+i+'" style="display:none;">'+arrItems[i]["SEVA_NAME"]+'</td></tr>');
    			} else {
    				$('#tblMasaMonth').append('<tr class="row1">	<td><center><input id="checkerId_'+i+'" type="checkbox" onchange="GetOnSelection('+arrItems[i]["SS_ID"]+','+arrItems[i]["SM_ID"]+',\''+dateMasa+'\','+arrItems[i]["DEITY_ID"]+','+arrItems[i]["SEVA_ID"]+',this.checked)" /></center></td><td>'+dateMasa+'</td><td>'+arrItems[i]["SS_RECEIPT_NO"]+'</td><td>'+arrItems[i]["SM_NAME"]+'</td><td>'+arrItems[i]["PLACE"]+'</td><td>'+arrItems[i]["DEITY_NAME"]+'</td><td>'+arrItems[i]["SEVA_NAME"]+'</td><td>'+arrItems[i]["SEVA_NOTES"]+'</td><td>'+arrItems[i]["CORPUS"]+'</td><td>'+arrItems[i]["SEVA_QTY"]+'</td><td class="cId" id="catid_'+i+'" style="display:none;">'+arrItems[i]["SEVA_NAME"]+'</td></tr>');
    			}
    		} else {
    			$('#tblMasaMonth').append('<tr class="row1">	<td><center><input id="checkerId_'+i+'" type="checkbox" onchange="GetOnSelection('+arrItems[i]["SS_ID"]+','+arrItems[i]["SM_ID"]+',\''+dateMasa+'\','+arrItems[i]["DEITY_ID"]+','+arrItems[i]["SEVA_ID"]+',this.checked)" /></center></td><td>'+dateMasa+'</td><td>'+arrItems[i]["SS_RECEIPT_NO"]+'</td><td>'+arrItems[i]["SM_NAME"]+'</td><td>'+arrItems[i]["PLACE"]+'</td><td>'+arrItems[i]["DEITY_NAME"]+'</td><td>'+arrItems[i]["SEVA_NAME"]+'</td><td>'+arrItems[i]["SEVA_NOTES"]+'</td><td>'+arrItems[i]["CORPUS"]+'</td><td>'+arrItems[i]["SEVA_QTY"]+'</td><td class="cId" id="catid_'+i+'" style="display:none;">'+arrItems[i]["SEVA_NAME"]+'</td></tr>');
    		}
	    }
	});	

	function GetOnSelection(SSId,SMID,dateMasa,DEITY_ID,SEVA_ID,checker) {
		if(checker) {
			arrSelectedItems.push(parseInt(SSId));
			arrSelectedSMID.push(parseInt(SMID));
			arrSelectedDeity.push(parseInt(DEITY_ID));
			arrSelectedSeva.push(parseInt(SEVA_ID));
			arrSelectedDateMasa.push(dateMasa);
		} else {
			const sindex = arrSelectedItems.indexOf(SSId);
			const lindex = arrLocalItems.indexOf(SSId);
			if (sindex > -1) {
				arrSelectedItems.splice(sindex, 1);
				arrSelectedSMID.splice(sindex, 1);
				arrSelectedDeity.splice(sindex, 1);
				arrSelectedSeva.splice(sindex, 1);
				arrSelectedDateMasa.splice(sindex, 1);
			}

			if(lindex > -1) {
				arrLocalItems.splice(lindex, 1);
				arrSelectedSMID.splice(lindex, 1);
				arrSelectedDeity.splice(lindex, 1);	
				arrSelectedSeva.splice(lindex, 1);
				arrSelectedDateMasa.splice(lindex, 1);
			}
		}
		sessionStorage.setItem("SelectedItems",JSON.stringify(arrSelectedItems));
		sessionStorage.setItem("SelectedSMID",JSON.stringify(arrSelectedSMID));
		sessionStorage.setItem("SelectedDeity",JSON.stringify(arrSelectedDeity));
		sessionStorage.setItem("SelectedSeva",JSON.stringify(arrSelectedSeva));
		sessionStorage.setItem("SelectedDateMasa",JSON.stringify(arrSelectedDateMasa));
		// console.log(arrSelectedItems);
		// console.log(arrSelectedSMID);
	}

	$(document).ready(function() {
		var DDSel = document.getElementById("masa").value;
		var Dropsel = document.getElementById("month").value;
		if(DDSel != '') {
			document.getElementById("HinduCal").style.display ="block";
			document.getElementById("gregorianCal").style.display ="none";
			document.getElementById("everyCal").style.display ="none";
		} else if(Dropsel != '') {
			document.getElementById("HinduCal").style.display ="none";
			document.getElementById("gregorianCal").style.display ="block";
			document.getElementById("everyCal").style.display ="none";
		} else {
			document.getElementById("HinduCal").style.display ="none";
			document.getElementById("gregorianCal").style.display ="none";
			document.getElementById("everyCal").style.display ="block";
		}
	});

	function addMemberName(SM_ID,SM_NAME,i) {
		let si = $('#searchedTable tr:last-child td:first-child').html();
		if (!si)
			si = 1;
		else
			++si;
		let sm_Name = SM_NAME.replace(/'/g, "\\'");
		$('#searchedTable').append('<tr class="x_' + si + ' si1 searchedItems"><td class="si" style="display:none;">' + si + '</td><td class="selectedSMName">' + SM_NAME + '</td><td style="display:none;"><input type="text" class="selectedSMName1" value="' + SM_NAME + '"</td><td class="smId serSmId" style="display:none;">' + SM_ID + '</td><td><a style="margin-left: 9px;pull-right;" title="Remove Name" onclick="removeMemberName(' +SM_ID + ',\'' + sm_Name + '\',' + si + ');"><img style="width:24px; height:24px" src="<?=site_url();?>images/delete1.svg"/></a></td></tr>');

		if(i != 0) {
            let i1 = document.getElementsByClassName('y_'+i);
            i1[0].remove();
        }
	}

	function removeMemberName(SM_ID,SM_NAME,si) {
		let si1 = document.getElementsByClassName('x_'+si);
        si1[0].remove();
        let j = $('#searchingTable tr:last-child td:first-child').html();
		if (!j)
			j = 1;
		else
			++j;
		let sm_Name = SM_NAME.replace(/'/g, "\\'");
        $('#searchingTable').append('<tr class="y_' + j + ' j1 serial"><td class="j" style="display:none;">' + j + '</td><td class="smName">' + SM_NAME + '</td><td class="smId" style="display:none;">' + SM_ID + '</td><td><center><a style="" title="Remove Name" onclick="addMemberName(' +SM_ID + ',\'' + sm_Name + '\',' + j + ')"><img style="width:24px; height:24px" src="<?=site_url();?>images/add_icon.svg"/></a></center></tr>');
	}

	function searchModal(){
		$("#searchModal").modal({backdrop: 'static', keyboard: false});
	}

	function searchSubmit(){
		let smNames = document.getElementsByClassName('selectedSMName1');
        let smNamesVal = [];
        let selsmNames="";
        for (let i = 0; i < smNames.length; ++i) {
            smNamesVal[i] = smNames[i].value;
            selsmNames += smNames[i].innerText.trim() + " ";
        }
        let names = JSON.stringify(smNamesVal);
        document.getElementById('selectedNames').value = names;

        if (smNamesVal=="") {
        	alert("Information","Please Select Any Member");
        	return;
        }
        clearSessionValues()
        $("#allSevasMasaMonthchange").submit();
	}

	function merge() {
		let SS_ID = JSON.parse(sessionStorage.getItem("SelectedItems"));
		let SM_ID = JSON.parse(sessionStorage.getItem("SelectedSMID"));
		let DateMasa = JSON.parse(sessionStorage.getItem("SelectedDateMasa"));
		let DEITY_ID = JSON.parse(sessionStorage.getItem("SelectedDeity"));
		let SEVA_ID = JSON.parse(sessionStorage.getItem("SelectedSeva"));
		var inputElements = document.getElementsByClassName('mergeCheck');
		let checkedValue = [];
		let checkedSSID = [];
		let thithiCode=""; 
		let j = 0; 
		var  compare = "",compareSeva="",compareDeity="";
		var flag =0 ;
		if (!SS_ID) {
        	alert("Information","Please Select Multiple Members to Merge");
        	return;
        }
		for(var i=0; i<SS_ID.length; ++i){
		        checkedValue[j] = SM_ID[i];
		        checkedSSID[j] = SS_ID[i];
		        if (j== 0) {
		        	compare = DateMasa[i];
		        	compareDeity = DEITY_ID[i];
		        	compareSeva = SEVA_ID[i];
		        }else{
		        	
		        	if(compareDeity != DEITY_ID[i]){
		        		alert("Information","Please make sure that Deity is same");
        				return;
		        	}
		        	if(compareSeva != SEVA_ID[i]){
		        		alert("Information","Please make sure that sevas are same");
        				return;
		        	}
		        	if(compare != DateMasa[i]){
		        		alert("Information","Please Select Members of Same ThithiCode / Date for Merging");
        				return;
		        	}
		        }
		        j++;
		}
		let checkedItems = JSON.stringify(checkedValue);
		let checkedSsId = JSON.stringify(checkedSSID);
        document.getElementById('selectedMembersSearchItems').value = checkedItems;
        document.getElementById('selectedMembersSearchSsId').value = checkedSsId;
         if (checkedValue.length < 2) {
        	alert("Information","Please Select Multiple Members to Merge");
        	return;
        }
        clearSessionValues()
        $("#mergeForm").submit();
	}

	function searchFunction(close='false') {
		var searchEle = document.getElementById('idSrchName').value;
		var masa = document.getElementById('masa').value;
		var month = document.getElementById('month').value;
		var every = document.getElementById('every').value;
		var thithiMasaCode = document.getElementById('thithiMasaCode').value;
		var selDate = document.getElementById('selDate').value;
		var selEvery = document.getElementById('selEvery').value;

		$.post("<?=site_url()?>Shashwath/masaMonthFilterSearch", {'searchName': searchEle,'masa': masa,'month': month,'every':every,'thithiMasaCode': thithiMasaCode,'selDate': selDate,'selEvery':selEvery}, function (e) {
			e1 = e;
			if (e1 != ""){
				$(".serial").remove();
				var arrData = JSON.parse(e1);
				for(let r=1; r <= arrData.length; r++){
					let serSmId = document.getElementsByClassName('serSmId');
					let flag=0;
					for (let l = 0; l < serSmId.length; ++l) {
						if(arrData[r-1].SM_ID == serSmId[l].innerText.trim()) {
							flag = 1;
						}
					}
					if (flag==0) {
						let j = $('#searchingTable tr:last-child td:first-child').html();
						if (!j)
							j = 1;
						else
							++j;
						let sm_Name = arrData[r-1].SM_NAME.replace(/'/g, "\\'");
						$('#searchingTable').append('<tr class="y_' + j + ' j1 serial"><td class="j" style="display:none;">' + j + '</td><td class="smName">' + arrData[r-1].SM_NAME + '</td><td class="smId" style="display:none;">' + arrData[r-1].SM_ID + '</td><td><center><a style="" title="Remove Name" onclick="addMemberName(' +arrData[r-1].SM_ID + ',\'' + sm_Name + '\',' + j + ')"><img style="width:24px; height:24px" src="<?=site_url();?>images/add_icon.svg"/></a></center></td></tr>');
					}
				}
				if(close=='false'){
					$("#searchModal").modal({backdrop: 'static', keyboard: false});
				}
			}
			else
				alert("Information","Something went wrong, Please try again after some time","OK");
		});	
	}

	function clearSearchBox(){
		$("#idSrchName").val("");
		searchFunction('false');
	}

	function clearall(){
		$(".searchedItems").remove();
		$("#idSrchName").val("");
		searchFunction('true');
		$('#searchModal').modal('hide');
	}

	function masaMonthChange(){
		clearSessionValues();
		$('#allSevasMasaMonthchange').submit();
	}

	function goBack(){
		clearSessionValues();
        window.location.href = "<?=site_url() ?>Shashwath/allSevasMasaMonth";
	}

	function clearSessionValues(){
		sessionStorage.removeItem("SelectedSMID");
		sessionStorage.removeItem("SelectedItems");
		sessionStorage.removeItem("SelectedDeity");
		sessionStorage.removeItem("SelectedSeva");
		sessionStorage.removeItem("SelectedDateMasa");
	}

	$('#idSrchName').on("keypress", function(e) {
        if (e.keyCode == 13) {
           searchFunction('false');
        }
	});

	function masaMonthDDChange(){
		document.getElementById('masaChangeVal').value = $('#masaCode').val();;
        document.getElementById('monthChangeVal').value = $('#monthCode').val();
        document.getElementById('everyChangeVal').value = $('#everyCode').val();
        clearSessionValues();
        $('#masaMonthchangeForm').submit();
	}

	window.onload = function(){
		var tableCont = document.querySelector('#table-cont')
		var tableCont1 = document.querySelector('#table-cont1')
		function scrollHandle (e){
		    var scrollTop = this.scrollTop;
		    this.querySelector('thead').style.transform = 'translateY(' + scrollTop + 'px)';
		}  
		tableCont.addEventListener('scroll',scrollHandle)
		tableCont1.addEventListener('scroll',scrollHandle)

	}

	function refreshMasaMonth(){
		clearSessionValues();
		$('#allSevasMasaMonthchange').submit();
	}
</script>