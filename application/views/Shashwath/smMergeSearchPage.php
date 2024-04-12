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
			/*code for progress bar*/
	#work-in-progress {
	  position: fixed;
	  width: 100%;
	  height: 100%;
	  font-size: 100px;
	  top: 50%;
	  text-align: center;
	  vertical-align: middle;
	  color: #00000;
	  z-index: 100000;
	}

	#loading-progress-text{
	  position: fixed;
	  width: 100%;
	  height: 100%;
	  top: 55%;
	  font-size: 20px;
	  font-weight: bold;
	  color: black;
	  text-align: center;
	  vertical-align: middle;
	  z-index: 100000;
	}

	.work-spinner {
	  background-color: #fdfdd9;
	  border: 9px solid rgba(128, 0, 0, 0.92);
	  opacity: .9;
	  border-left: 5px solid rgba(0,0,0,0);
	  border-radius: 120px;
	  
	  width: 100px; 
	  height: 100px;
	  margin: 0 auto;
	  -moz-animation: spin .5s infinite linear;
	  -webkit-animation: spin .5s infinite linear;
	  -o-animation: spin .5s infinite linear;
	  animation: spin .5s infinite linear;
	}

	@-moz-keyframes spin {
	 from {
	     -moz-transform: rotate(0deg);
	 }
	 to {
	     -moz-transform: rotate(360deg);
	 }
	}

	@-webkit-keyframes spin {
	 from {
	     -webkit-transform: rotate(0deg);
	 }
	 to {
	     -webkit-transform: rotate(360deg);
	 }
	}

	@keyframes spin {
	 from {
	     transform: rotate(0deg);
	 }
	 to {
	     transform: rotate(360deg);
	 }
	}
	@-o-keyframes spin {
	 from {transform: rotate(0deg);}
	 to {transform: rotate(360deg);}
	}
	 /* progress bar code ends here*/
</style>
<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png">
	<div class="col-lg-4 col-md-6 col-sm-4 col-xs-12" style="margin-bottom:0em">
		<span class="eventsFont2">Shashwath Members Merge</span>
	</div>
	<div class="col-lg-8 col-md-6 col-sm-4 col-xs-12 pull-right text-right" style="padding:0px 0px 0px;">
		<a style="text-decoration:none;cursor:pointer;" href="<?=site_url()?>Shashwath/shashwathMergeSearch" title="Refresh"><img style="width:24px; height:24px" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
		<a style="margin-left: 9px;pull-right;" href="<?=site_url()?>Shashwath/shashwath_member" title="Back"><img style="width:24px; height:24px" src="<?=site_url();?>images/back_icon.svg"/></a>
	</div>
</div>
	<div class="container">
		<div  id="work-in-progress" style="display:none;" >
  		  <div class="work-spinner"></div>
		</div>	
		<div class="col-lg-6 col-md-12 col-sm-8 col-xs-8" id="searchModal">
			<div class="form-group">							
				<div class="col-lg-12 col-md-12 col-sm-8 col-xs-8" style = "padding-right:0px;padding-top:10px;">
					<h4 style="margin-top:10px">All Members</h4>
				</div>
			</div>
			<div class="row form-group">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
					<div class="table-responsive table-cont" id="table-cont" style="width:100%;overflow:scroll;height:500px;display: block;overflow-x: hidden;" >
						<table id="searchingTable" class="table table-bordered table-hover" style="overflow-y: scroll;">
							<thead>
								<tr>
									<th width="90%" id="#header-fixed">Search Name &nbsp;&nbsp;
										<input type="hidden" name="callFromGroup" id="callFromGroup" value="<?=@$callFrom;?>">
										<input id="idSrchGroup" class="" type="text" name="nameSearch" value="<?=@$nameSearch; ?>" placeholder="Search"  style="color: maroon;">
										<a style="text-decoration:none;cursor:pointer;" onclick="clearSearchBox()" title="Refresh"><img style="width:24px; height:24px;margin-left:10px;color: white;" title="Refresh" src="<?=site_url();?>images/refreshwhite.png"/></a>
									</th>
									<th width="10%"><center>Op</center></th>
								</tr>
							</thead>
							<tbody id="selectingElement">
								<?php $i = 1;
								foreach($ShashwathMemberName as $result) {
									echo "<tr class='y_$i serial'>";
									echo "<td class='si' style='display:none;'>".$i."</td>";
									echo "<td>".$result['SM_NAME']."</td>";?>
									<td><center> <a title="Add Name" onclick="addMemberName('<?=$result['SM_ID']; ?>','<?php echo str_replace("'","\'",$result['SM_NAME']);?>','<?=$i;?>')"><img style="width:24px; height:24px" src="<?=site_url();?>images/add_icon.svg"/></a></center></td>  
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
			<div class="form-group">							
				<div class="col-lg-12 col-md-12 col-sm-8 col-xs-8" style = "padding-right:0px;padding-top:10px;">
					<h4 style="margin-top:10px">Selected Members for Merging</h4>
				</div>
			</div>
			<div class="row form-group">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="table-responsive table-cont1" id="table-cont1" style="width:100%;overflow:scroll;height:500px;display: block;overflow-x: hidden;">
						<table id="searchedTable" class="table table-bordered table-hover" style="overflow-y: scroll;">
							<thead id="#header-sticky">
								<tr>
									<th width="90%" >Name</th>
									<th width="10%"><center>Op</center></th>
								</tr>
							</thead>
							<tbody id="selectedElement">
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	<div class="modal-footer" style="text-align:left;">
		<button type="button" style="width: 8%;" class="btn " id="submit" onclick="searchSubmit()">Yes</button>
		<button type="button" style="width: 8%;" class="btn " data-dismiss="modal" onclick="clearall()">No</button>
	</div>
</div>	

<form action="<?=site_url();?>Shashwath/allSevasMemberFilter" enctype="multipart/form-data" method="post" id="allSevasMasaMonthchange">
	<input type="hidden" name="selectedNames" id="selectedNames" value="">
</form>

<script type="text/javascript">

	function searchModal(){
		$("#searchModal").modal({backdrop: 'static', keyboard: false});
	}

	function clearSearchBox(){
		$("#idSrchGroup").val("");
		getProgressSpinner();
		myFunction('false');
		return false;
	}

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
       $("#allSevasMasaMonthchange").submit();
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

	$('#idSrchGroup').on("keypress", function(e) {
		if (e.keyCode == 13) {
			getProgressSpinner();
			myFunction('false');
		}
	});

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

	function clearall(){
		$(".searchedItems").remove();
		$("#idSrchGroup").val("");
		window.location.href = "<?=site_url() ?>Shashwath/shashwathMergeSearch";
	}

	function myFunction(close='false') {
		var searchEle = document.getElementById('idSrchGroup').value;
		$.post("<?=site_url()?>Shashwath/memberFilterSearch", {'nameSearch': searchEle}, function (e) {
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

				document.getElementById("work-in-progress").style.display = "none";
				document.getElementById("loading-progress-text").style.display = "none";
			}
			else
				alert("Information","Something went wrong, Please try again after some time","OK");
		});	
	}

	function getProgressSpinner(){
		document.getElementById("work-in-progress").style.display = "block";
		document.getElementById("loading-progress-text").style.display = "block";		
	}

</script>
