<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:0em">
			<div class="col-lg-4 col-md-6 col-sm-4 col-xs-12" style="padding:0px 0px 0px;">
					<span class="eventsFont2">Shashwath Member Merge </span>
			</div>
			<div class="col-lg-2 col-md-6 col-sm-4 col-xs-12 pull-right text-right" style="padding:0px 0px 0px;">
				<input type="button" class="btn btn-default" style="text-decoration:none;cursor:pointer;margin-left:-100px;"  title="Merge" onclick="mergeMember()" value="Merge" /> 
				<a style="text-decoration:none;cursor:pointer;" href="<?=site_url()?>Shashwath/allSevasMemberFilter" onclick="clearSessionValues()" title="Refresh"><img style="width:24px; height:24px" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
				<a style="margin-left: 9px;pull-right;" href="<?=site_url()?>Shashwath/shashwathMergeSearch" title="Back"  onclick="clearSessionValues()"><img style="width:24px; height:24px" src="<?=site_url();?>images/back_icon.svg"/></a>
			</div>
		</div>
</div>
<div class="container">
	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 3em">
			<div class="table-responsive">
				<table class="table table-bordered" id="tblMemberName">
					<thead>
						<tr>
							<th></th>
							<th>Old Receipt Number</th>
							<th>Name</th>
							<th>Address</th>
							<th>Total Corpus</th>
							<th>Seva Count</th>
							<th>Op</th>
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

<form  action="<?=site_url();?>Shashwath/shashwathAddlMemberMerge" enctype="multipart/form-data" method="post" id="mergeForm">
	<input type="hidden" name="selectedMembersSearchItems" id="selectedMembersSearchItems" value="">
	<input type="hidden" name="selectedMembersSearchSsId" id="selectedMembersSearchSsId" value="">
	<input type="hidden" name="call" id="call" value="<?php echo $base_url ?>">
</form>

<script>
	function mergeMember() {
		let SM_ID = JSON.parse(sessionStorage.getItem("SelectedSMID"));
		var inputElements = document.getElementsByClassName('mergeMemberCheck');
		let checkedValue = [];
		let checkedSSID = [];
		let thithiCode=""; 
		let j = 0; 
		var  compare = "";
		var flag =0 ;
		if (!SM_ID) {
        	alert("Information","Please Select Multiple Members to Merge");
        	return;
        }
		for(var i=0; i<SM_ID.length; ++i){
	      	checkedValue[j] = SM_ID[i];
		  	j++;
		}
		let checkedItems = JSON.stringify(checkedValue);
        document.getElementById('selectedMembersSearchItems').value = checkedItems;
         if (checkedValue.length < 2) {
        	alert("Information","Please Select Multiple Members to Merge");
        	return;
        }
        clearSessionValues()
        $("#mergeForm").submit();
	}

	var arrSelectedSMID = [];
	var arrLocalItems = []; 
	var arrItems = []; 
	
	$(document).ready(function() {
	    if(sessionStorage.getItem("SelectedSMID") !== null && sessionStorage.getItem("SelectedSMID") != "") {
	    	arrSelectedSMID = JSON.parse(sessionStorage.getItem("SelectedSMID"));	 	
	    }
	   	else {
	   		arrSelectedSMID = [];
	   	} 
	   	arrItems = <?php echo $nameDetails; ?>;
	    for(var i = 0; i < arrItems.length; i++) {
    		if(sessionStorage.getItem("SelectedSMID") !== null && sessionStorage.getItem("SelectedSMID") != "") {
    			if(arrSelectedSMID.indexOf(parseInt(arrItems[i]["SM_ID"])) > -1) {
    				arrLocalItems.push(parseInt(arrItems[i]["SM_ID"]));
    				$('#tblMemberName').append('<tr class="row1">	<td><center><input id="checkerId_'+i+'" type="checkbox" onchange="GetOnSelection('+arrItems[i]["SM_ID"]+',this.checked)" checked /></center></td><td>'+arrItems[i]["SS_RECEIPT_NO"]+'</td><td>'+arrItems[i]["SM_NAME"]+'</td><td>'+arrItems[i]["ADDRESS"]+'</td><td>'+arrItems[i]["corpus"]+'</td><td>'+arrItems[i]["sevaCount"]+'</td><td><center><a title="Apear Down" onclick="apearMember('+ arrItems[i]['SM_ID']+')"><img style="width:24px; height:24px" src="<?=site_url();?>images/delete.svg"/></a></center></td></tr>');
    			} else {
    				$('#tblMemberName').append('<tr class="row1">	<td><center><input id="checkerId_'+i+'" type="checkbox" onchange="GetOnSelection('+arrItems[i]["SM_ID"]+',this.checked)" /></center></td><td>'+arrItems[i]["SS_RECEIPT_NO"]+'</td><td>'+arrItems[i]["SM_NAME"]+'</td><td>'+arrItems[i]["ADDRESS"]+'</td><td>'+arrItems[i]["corpus"]+'</td><td>'+arrItems[i]["sevaCount"]+'</td><td><center><a title="Apear Down" onclick="apearMember('+ arrItems[i]['SM_ID']+')"><img style="width:24px; height:24px" src="<?=site_url();?>images/delete.svg"/></a></center></td></tr>');
    			}
    		} else {
    			$('#tblMemberName').append('<tr class="row1">	<td><center><input id="checkerId_'+i+'" type="checkbox" onchange="GetOnSelection('+arrItems[i]["SM_ID"]+',this.checked)" /></center></td><td>'+arrItems[i]["SS_RECEIPT_NO"]+'</td><td>'+arrItems[i]["SM_NAME"]+'</td><td>'+arrItems[i]["ADDRESS"]+'</td><td>'+arrItems[i]["corpus"]+'</td><td>'+arrItems[i]["sevaCount"]+'</td><td><center><a title="Apear Down" onclick="apearMember('+ arrItems[i]['SM_ID']+')"><img style="width:24px; height:24px" src="<?=site_url();?>images/delete.svg"/></a></center></td></tr>');
    		}
	    }
	});	

	function GetOnSelection(SMID,checker) {
		if(checker) {
			arrSelectedSMID.push(parseInt(SMID));
		} else {
			const sindex = arrSelectedSMID.indexOf(SMID);
			const lindex = arrLocalItems.indexOf(SMID);
			if (sindex > -1) {
				arrSelectedSMID.splice(sindex, 1);
			}

			if(lindex > -1) {
				arrSelectedSMID.splice(lindex, 1);
			}
		}
		sessionStorage.setItem("SelectedSMID",JSON.stringify(arrSelectedSMID));
		// console.log(arrSelectedItems);
		// console.log(arrSelectedSMID);
	}

	function clearSessionValues(){
		sessionStorage.removeItem("SelectedSMID");
	}

	function apearMember(SM_ID){
		$.post("<?=site_url()?>Shashwath/updateAppearence", {'SM_ID': SM_ID}, function (e) {
			e1 = e;
			if (e1 == "success"){
				alert("Information","Member appear status activated","OK");
			}
			else
				alert("Information","Something went wrong, Please try again after some time","OK");
		});	
	}
</script>