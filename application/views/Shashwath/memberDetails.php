<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png">
	<form action="<?=site_url();?>Shashwath/search_shashwath_member" enctype="multipart/form-data" method="post" accept-charset="utf-8">
		<div class="row form-group">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:0em">
				<span class="eventsFont2">Shashwath Members</span>
				<label style="padding-left:10px;color: red;font-size:18px ">Un-verified Seva: <strong ><?php echo $ShashwathUnverifedCount  ?></strong></label> 
				<label style="padding-left:10px;color: red;font-size:18px ">Un-verified Member: <strong ><?php echo $ShashwathUnverifedMemberCount  ?></strong></label> 
				<!-- $ShashwathUnverifedCount -->
			</div>
		</div>
		<div class="row form-group" style="margin-top:-0.5em">
			<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
				<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6" style="padding-left:0px;">
					<div class="input-group input-group-sm">
						<input autocomplete="off" type="text"   style="width: 200px;" id="name_phone" name="name_phone" value="<?=@$name_phone?>" class="form-control" placeholder="Name / Phone / Rno">
						<div class="input-group-btn">
							<button class="btn btn-default name_phone" type="submit">
								<i class="glyphicon glyphicon-search"></i>
							</button>
						</div>
					</div>
				</div>
				<div class="col-lg-8 col-md-6 col-sm-4 col-xs-12 pull-right text-right" style="padding:0px 0px 0px;">
					<input type="button" class="btn btn-default" style="text-decoration:none;cursor:pointer;"  title="search" 
					onclick="nameSearchModal()" value="Member Merge" />	
					<img style="width:24px; height:24px; " onClick="monthMasaSevas()" title="Monthwise and Masawise Sevas Merge" src="<?=site_url();?>images/Merge.png"/>
					<img style="width:24px; height:24px; " onClick="edit()" title="Un-verified Shashwath Details" src="<?=site_url();?>images/print_icon.svg"/>
					<?php if(isset($_SESSION['Add'])) { ?>
						<a href="<?=site_url()?>Shashwath/addMember" title="New Shashwath Member"><img style="width:24px; height:24px" src="<?=site_url();?>images/add_icon.svg"/></a>
					<?php } ?>
					<a style="text-decoration:none;cursor:pointer;" href="<?=site_url()?>Shashwath/shashwath_member" title="Refresh"><img style="width:24px; height:24px" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
				</div>
			</div>
		</div>
	</form>
</div>	
<div class="container">
	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Reference</th>
							<th>Old RecieptNo</th>
							<th>Name (Phone)</th>
							<th>Rashi (Nakshatra)</th>
							<th>Country (City)</th>
							<th>Total Corpus</th>
							<th>Seva Count</th>
							<th>Verification</th>
							<th width="5%">Operation</th>
							
						</tr>
					</thead>
					<tbody>
						<?php foreach($ShashwathMember  as $result) {
							echo "<tr>";
							echo "<td><center>".$result['SM_REF']."</center></td>";
							echo "<td><center>".$result['SS_RECEIPT_NO']."</center></td>";
							if($result['SM_PHONE'] != "") 
								echo "<td>".$result['SM_NAME']." (".$result['SM_PHONE'].")"."</td>";
							else
								echo "<td>".$result['SM_NAME']."</td>";
							if($result['SM_RASHI'] != "" && $result['SM_NAKSHATRA'] != "") {
								echo "<td>".$result['SM_RASHI']." (".$result['SM_NAKSHATRA'].")"."</td>";
							} else
							echo "<td>".$result['SM_RASHI']."</td>";
							if($result['SM_CITY'] != "") 
								echo "<td>".$result['SM_COUNTRY']." (".$result['SM_CITY'].")"."</td>";
							else
								echo "<td>".$result['SM_COUNTRY']."</td>";
							echo "<td><center>".$result['corpus']."</center></td>";
							echo "<td style='color:#800000;' title='".$result['SS_REC_REF']."'><center>".$result['sevaCount']."</center></td>";
							echo "<td><center>".$result['SS_VERIFICATION']."</center></td>";
							echo "<td class='text-center' width='9%'>
							<a style='border:none; outline: 0;' href='javascript:sendId(".$result['SM_ID'].");' title='Edit Member Details'><img style='border:none; outline: 0;' src='".base_url()."images/edit_icon.svg'></a>
							<a style='border:none; outline: 0;' href='javascript:sendDeleteId(".$result['SM_ID'].");' title='Delete Member Details'><img style='border:none; width:24px; height:24px; outline: 0;' src='".base_url()."images/trash.svg'></a>
							<a style='border:none; outline: 0;' onClick='printMemberdetails(".$result['SM_ID'].",".$result['corpus'].");' src='<?=site_url();?>images/print_icon.svg' title='Print'><img style='border:none; width:24px; height:24px; outline: 0;' src='".base_url()."images/print_icon.svg'></a>
							</td>";
							echo "</tr>";
						} ?>
					</tbody>
				</table>				
			</div>
		</div>
	</div>
	<div class= "row">
		<ul class="pagination pagination-sm" style="margin-left:15px;margin-top: -1em;">
			<?=$pages; ?>
		</ul>
		<?php if($ShashwathMemberCount != 0) { ?>
			<label class="pull-right" style="font-size:18px;margin-right:15px;margin-top: -1em;">Total Members: <strong style="font-size:18px"><?php echo $ShashwathMemberCount ?></strong></label>
		<?php } ?>					
	</div>
</div>

<form id="formEditMember" method="post" action="<?php echo site_url();?>Shashwath/edit_shashwath_member">
	<input type="hidden" id="identity" name="memberId" value=""/>	
</form>

<form id="formDeleteMember" method="post" action="<?php echo site_url();?>Shashwath/delete_shashwath_member">
	<input type="hidden" id="memberDeleteId" name="memberDeleteId" value=""/>	
</form>

<div>
	<div class="modal fade bs-example-modal-lg" id="lblGen" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Un Verified Shashwath Member Report</h4>
				</div>
				<div class="modal-body labelGen" id="creditdet" style="overflow-y: auto;max-height: 80vmin;">
					<br/><label>Members Start From: </label> <input type=text name=startFrom id=startFrom  style=width:30%;><br/>
					<label style="padding-left:10px;color: red;font-size:12px ">*Only 500 records can be generated at a time</strong></label> 
				</div>
				
				<div class="modal-footer text-left" style="text-align:left;">
					<label>Are you sure you want to generate..?</label><br/>
					<button style="width: 30%;" type="button" class="btn btn-default sevaButton" onclick="checkForExport()" id="submit2">Generate</button>
					<button style="width: 30%;" type="button" class="btn btn-default sevaButton" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
</div>

<form id="monthChange" method="post">
	<div class="modal fade bs-example-modal-lg" id="monthMasaSevasModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Shashwath Additional Corpus Search</h4>
				</div>
				<div class="modal-body labelGen" id="creditdet" style="overflow-y: auto;max-height: 80vmin;">
					<div class="col-lg-3 col-md-6 col-sm-4 col-xs-6" >
						<select id="modeOfChangeMonth" data-plugin="selectpicker" data-live-search="true" class="form-control"  onchange="GetDataOnMonth(this.value)" >
							<?php if(isset($Date)) {?>
								<?php if($Date == "0") { ?>
									<option value="0" selected="selected">Select Gregorian</option>
								<?php } else { ?>
									<option value="0" selected="selected">Select Gregorian</option>
								<?php } ?>
								<?php if($Date == "-01") { ?>
									<option selected value="-01">January</option>
								<?php } else { ?>
									<option value="-01">January</option>
								<?php } ?>
								<?php if($Date == "-02") { ?>
									<option selected value="-02">February</option>
								<?php } else { ?>
									<option value="-02">February</option>
								<?php } ?>
								<?php if($Date == "-03") { ?>
									<option selected value="-03">March</option>
								<?php } else { ?>
									<option value="-03">March</option>
								<?php } ?>
								<?php if($Date == "-04") { ?>
									<option selected value="-04">April</option>
								<?php } else { ?>
									<option value="-04">April</option>
								<?php } ?>	
								<?php if($Date == "-05") { ?>
									<option selected value="-05">May</option>
								<?php } else { ?>
									<option value="-05">May</option>
								<?php } ?>	
								<?php if($Date == "-06") { ?>
									<option selected value="-06">June</option>
								<?php } else { ?>
									<option value="-06">June</option>
								<?php } ?>
								<?php if($Date == "-07") { ?>
									<option selected value="-07">July</option>
								<?php } else { ?>
									<option value="-07">July</option>
								<?php } ?>
								<?php if($Date == "-08") { ?>
									<option selected value="-08">August</option>
								<?php } else { ?>
									<option value="-08">August</option>
								<?php } ?>
								<?php if($Date == "-09") { ?>
									<option selected value="-09">September</option>
								<?php } else { ?>
									<option value="-09">September</option>
								<?php } ?>
								<?php if($Date == "-10") { ?>
									<option selected value="-10">October</option>
								<?php } else { ?>
									<option value="-10">October</option>
								<?php } ?>
								<?php if($Date == "-11") { ?>
									<option selected value="-11">November</option>
								<?php } else { ?>
									<option value="-11">November</option>
								<?php } ?>
								<?php if($Date == "-12") { ?>
									<option selected value="-12">December</option>
								<?php } else { ?>
									<option value="-12">December</option>
								<?php } ?>
							<?php } else { ?>
								<option value="">Select Gregorian</option>			
								<option value="-01">January</option>
								<option value="-02">February </option>
								<option value="-03">March</option>
								<option value="-04">April</option>
								<option value="-05">May</option>
								<option value="-06">June</option>
								<option value="-07">July</option>
								<option value="-08">August</option>
								<option value="-09">September</option>
								<option value="-10">October</option>
								<option value="-11">November</option>
								<option value="-12">December</option>
							<?php } ?>
						</select>
						<input type="hidden" name="month" id="month">  
					</div>

					<div class="col-lg-3 col-md-6 col-sm-4 col-xs-6">
						<select id="masaCode" data-plugin="selectpicker" data-live-search="true" name="masaCode" class="form-control" onchange="GetDataOnMasa(this.value)">
							<option value="" selected="selected">Select Hindu</option>
							<?php   if(!empty($masa)) {
								foreach($masa as $row1) { ?> 
									<option value="<?php echo $row1->MASA_NAME;?>"><?php echo $row1->MASA_NAME;?></option>
								<?php } } ?>
						</select>
					</div>	
					<input type="hidden" name="masa" id="masa">

					<div class= "col-lg-3 col-md-6 col-sm-4 col-xs-6">					 
						<div class="form-group" >
							<select id="modeOfChangeEvery" data-plugin="selectpicker" data-live-search="true" name="festivalCode" class="form-control"  onchange="GetDataOnEvery(this.value)" >
								<?php if(isset($Every)) {?>
									<?php if($Every == "0") { ?>
										<option value="0" selected="selected">Select Every</option>
									<?php } else { ?>
										<option value="0" selected="selected">Select Every</option>
									<?php } ?>
									<?php if($Every == "Year") { ?>
										<option selected value="Year">Year</option>
									<?php } else { ?>
										<option value="Year">Year</option>
									<?php } ?>
									<?php if($Every == "Month") { ?>
										<option selected value="Month">Month</option>
									<?php } else { ?>
										<option value="Month">Month</option>
									<?php } ?>
									<?php if($Every == "Week") { ?>
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
					</div>
					<input type="hidden" name="every" id="every"> 
				</div>

				<div class="modal-footer text-left" style="text-align:left;">
					<label>Are you sure you want to generate..?</label><br/>
					<button style="width: 30%;" type="button" class="btn btn-default sevaButton" onclick="getMasaMonthSevasMember()" id="submit2">Submit</button>
					<button style="width: 30%;" type="button" class="btn btn-default sevaButton" data-dismiss="modal">Cancel</button>
				</div>
			</div>

		</div>
	</div>
</form>

</div>

<form action="<?=site_url();?>Shashwath/allSevasMemberFilter" enctype="multipart/form-data" method="post" id="allSevasMasaMonthchange">
	<input type="hidden" name="selectedNames" id="selectedNames" value="">
</form>

<form  action="<?=site_url();?>Shashwath/shashwathMergeSearch" enctype="multipart/form-data" method="post" id="nameSearchForm">
</form>

<script>
	function sendId(id) {
		$('#identity').val(id);
		$('#formEditMember').submit();
	}

	function sendDeleteId(id) {
		$('#memberDeleteId').val(id);
		$('#formDeleteMember').submit();
	}

	function edit(){
		var php_var = <?php echo $ShashwathUnverifedMemberCount; ?>;								
		if(php_var == '0') {
			alert('There are no Unverified Shashwath Members to Export...!');
		} else {
			$('#lblGen').modal();
		}
	}

	function checkForExport() {
		var php_var = <?php echo $ShashwathUnverifedMemberCount; ?>;								
		if($('#startFrom').val() >= php_var || $('#startFrom').val() == "" ) {
			alert('There are no Unverified Shashwath Members to Export...!');
			return false;
		}else if($('#startFrom').val() == 0){
			alert('Please Select Number Greater than 0');
			return false;
		}else {		
			let url2 = '<?php echo site_url(); ?>GenerationUnVerifiedShashwathFPDF/index?startFrom='+$('#startFrom').val();	
			var win = window.open(
				url2,
				'_blank');
			setTimeout(function(){ win.print();}, 1000);							
			// window.open('<?php echo site_url(); ?>GenerationUnVerifiedShashwathFPDF='+$('#startFrom').val(),'_blank'); 
			// $('#lblGen').modal('toggle') = "none";
			
		}
	}
	function monthMasaSevas(){
		document.getElementById('masa').value ="";
		document.getElementById('masaCode').value ="";
		document.getElementById('month').value ="";
		document.getElementById('modeOfChangeMonth').value ="";
		document.getElementById('every').value ="";	
		document.getElementById('modeOfChangeEvery').value ="";	
		$('#monthMasaSevasModal').modal();		
	}

	function getMasaMonthSevasMember() {
		$month = $('#modeOfChangeMonth').val();
		$masa = $('#masaCode').val();
		$every = $('#modeOfChangeEvery').val();

		if($month == '' && $masa == '' && $every == ''){
			alert('Please Select Gregorian or Hindu or Every ');	
			return false;
		}else{
			sessionStorage.removeItem("SelectedSMID");
			sessionStorage.removeItem("SelectedItems");
			sessionStorage.removeItem("SelectedDeity");
			sessionStorage.removeItem("SelectedSeva");
			sessionStorage.removeItem("SelectedDateMasa");
			var url = '<?php echo site_url();?>Shashwath/allSevasMasaMonth';
			$("#monthChange").attr("action",url);
			$("#monthChange").submit();		
			$('#monthMasaSevasModal').modal('hide');
		}							
	}

	function GetDataOnMonth(date) {
		document.getElementById('masa').value ="";
		document.getElementById('masaCode').value ="";	
		document.getElementById('every').value ="";	
		document.getElementById('modeOfChangeEvery').value ="";	
		document.getElementById('month').value = $('#modeOfChangeMonth').val();
	}

	function GetDataOnMasa(masa) {
		document.getElementById('month').value ="";
		document.getElementById('modeOfChangeMonth').value ="";
		document.getElementById('every').value ="";	
		document.getElementById('modeOfChangeEvery').value ="";	
		document.getElementById('masa').value =$('#masaCode').val();	
	}

	function GetDataOnEvery(every) {
		document.getElementById('month').value = "";
		document.getElementById('modeOfChangeMonth').value ="";
		document.getElementById('masa').value ="";
		document.getElementById('masaCode').value ="";
		document.getElementById('every').value = $('#modeOfChangeEvery').val();
	}
	
	function nameSearchModal(){
		$("#nameSearchForm").submit();
	}

	function printMemberdetails(MEM_SMID,corpus) {
		let MEMSMID = MEM_SMID;
		let url = "<?php echo site_url(); ?>generatePDF/create_shashwathIndMemReportSession";
		$.post(url,{'MEM_SM_ID':MEMSMID,'MEM_TOT_CORPUS':corpus}, function(data) {
			let url2 = "<?php echo site_url(); ?>generatePDF/create_shashwathIndividualMemberReport";
			if(data == 1) {
				downloadClicked = 0;
				var win = window.open(
					url2,
					'_blank'
					); 
				setTimeout(function(){ win.print();}, 1000);
			}
		})
	}
</script>