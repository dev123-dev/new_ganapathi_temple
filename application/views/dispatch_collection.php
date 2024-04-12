<?php 
	//$this->output->enable_profiler(TRUE);
	//print_r("<pre>");
	//print_r($_SESSION);
	//print_r("</pre>");
?>
<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<div class="row form-group">
		<form id="tddate" enctype="multipart/form-data" method="post" accept-charset="utf-8">
			<div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
				<div class="input-group input-group-sm">
					<input type="hidden" name="tdate" value="<?=@$date; ?>" id="tdate">
					<input type="hidden" name="load" id="load" value="">
					<input autocomplete="" id="todayDate" type="text" value="<?=@$date; ?>" class="form-control todayDate2" onchange="get_datefield_change(this.value)" readonly = "readonly" placeholder="dd-mm-yyyy" />
					<div class="input-group-btn">
					  <button class="btn btn-default todayDate" type="button">
						<i class="glyphicon glyphicon-calendar"></i>
					  </button>
					</div>
				</div>
			</div>
			
			<div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
				<div class="input-group input-group-sm">
					<input autocomplete="" type="text" id="name_phone" name="name_phone" value="<?=@$name_phone; ?>" class="form-control" placeholder="Name / Phone">
					<div class="input-group-btn">
					  <button class="btn btn-default name_phone" type="button" onClick="get_name_phone_search()">
						<i class="glyphicon glyphicon-search"></i>
					  </button>
					</div>
				</div>
			</div>
			
			<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12" style="margin-bottom:1em;">
			  <select id="lblCounter" name="lblCounter" class="form-control" onchange="get_label_change(this.value)">
					<option value="All">All</option>
					<?php foreach($labelCounter as $result) { ?>
						<?php if($lblCount == $result->LABEL_COUNTER) { ?>
							<?php if($result->LABEL_COUNTER != 0) { ?>
								<option value="<?php echo $result->LABEL_COUNTER; ?>" selected><?php echo "Label ".$result->LABEL_COUNTER." (".$result->TOTAL.")"; ?></option>
							<?php } else { ?>
								<option value="<?php echo $result->LABEL_COUNTER; ?>" selected><?php echo "No Label"." (".$result->TOTAL.")" ?></option>
							<?php } ?>
						<?php } else { ?>
							<?php if($result->LABEL_COUNTER != 0) { ?>
								<option value="<?php echo $result->LABEL_COUNTER; ?>"><?php echo "Label ".$result->LABEL_COUNTER." (".$result->TOTAL.")"; ?></option>
							<?php } else { ?>
								<option value="<?php echo $result->LABEL_COUNTER; ?>"><?php echo "No Label"." (".$result->TOTAL.")" ?></option>
							<?php } ?>
						<?php } ?>
					<?php } ?>
			  </select>
			  <!--HIDDEN FIELDS -->
			  <input type="hidden" name="labelCounter" id="labelCounter" value="<?=@$lblCount; ?>">
			</div>
			
			<div class="col-offset-lg-5 col-lg-2 col-md-3 col-sm-12 col-xs-12 pull-right text-right">
				<?php if(isset($_SESSION['Add'])) { 
						$label = ""; 
						foreach($labelCounter as $result) { 
							if($result->LABEL_COUNTER != 0) { 
								$label .= "<input style=margin-top:.2em; type=checkbox class=postChk name=chk_".$result->LABEL_COUNTER." id=chk_".$result->LABEL_COUNTER." onchange=getOnSelect(this.id)>Label ".$result->LABEL_COUNTER ." generated ".$result->TOTAL." times.<br>";
							} else {
								$label .= "<input style=margin-top:.2em; type=checkbox class=postChk name=chk_".$result->LABEL_COUNTER." id=chk_".$result->LABEL_COUNTER." onchange=getOnSelect(this.id)>".$result->TOTAL ." Labels is pending.<br>";
							}
						}
						?>
					<a style="pull-right;" onClick="GetSendField()" title="Download Excel Report"><img style="width:24px; height:24px" src="<?=site_url();?>images/excel_icon.svg"/></a>
					<a style="pull-right;" onClick="edit('<?=$label; ?>')" title="Add"><img style="width:24px; height:24px" src="<?=site_url();?>images/add_icon.svg"/></a>
				<?php } ?>
				<a style="margin-left:2px;cursor:pointer;pull-right;" href="<?=site_url()?>Postage/dispatch_collection" title="Refresh"><img style="width:24px; height:24px" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
			</div>
		</form>
	</div>
</div>

<div class="container">
	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th style="width: 15%;">Receipt No.</th>
							<th>Name (Phone)</th>
							<th>Post. Amt.</th>
							<th>Post. Actual Amt.</th>
							<th>Company</th>
							<th>Tracking No.</th>
							<th>Label Count</th>
							<th><center>Operation</center></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($dispatchData as $result) { ?>
							<tr class="row1">
								<td><?php echo $result->RECEIPT_NO; ?></td>
								<?php if($result->RECEIPT_PHONE == "") { ?>
									<td><?php echo $result->RECEIPT_NAME; ?></td>
								<?php } else { ?>
									<td><?php echo $result->RECEIPT_NAME." ("; ?><?php echo $result->RECEIPT_PHONE.")"; ?></td>
								<?php } ?>
								<td><?php echo $result->POSTAGE_PRICE; ?></td>
								<td><?php echo $result->REVISED_PRICE; ?></td>
								<td><?php echo $result->POSTAGE_COMPANY; ?></td>
								<td><?php echo $result->POSTAGE_TRACKING; ?></td>
								<td><?php echo $result->LABEL_COUNTER; ?></td>
								<td class="text-center">
									<a style="border:none; outline: 0;" onClick="callModal('<?=$result->POSTAGE_ID; ?>')" title="Add Dispatch Details"><img style="border:none; outline: 0;" src="<?php echo base_url(); ?>images/add_icon.svg"></a></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			
				<ul class="pagination pagination-sm">
					<?=$pages; ?>
				</ul>
			</div>
		</div>
	</div>
</div>

<form id="formSub" action="<?php echo site_url(); ?>GenerationFPDF/" enctype="multipart/form-data" method="post" accept-charset="utf-8">
	<div class="modal fade bs-example-modal-lg" id="lblGen" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Label Generation</h4>
				</div>
				<div class="modal-body labelGen" id="creditdet" style="overflow-y: auto;max-height: 80vmin;">
					
				</div>
				
				<div class="modal-footer text-left" style="text-align:left;">
					<label>Are you sure you want to generate..?</label><br/>
					<button style="width: 10%;" type="button" class="btn btn-default sevaButton" id="submit2">Generate</button>
					<button style="width: 8%;" type="button" class="btn btn-default sevaButton" data-dismiss="modal">Verify</button>
				</div>
			</div>
		</div>
	</div>
	<!--HIDDEN FIELDS-->
	<input type="hidden" name="selPostChk" id="selPostChk">
	<input type="hidden" name="start" id="start">
	<input type="hidden" name="posDate" id="posDate">
	<input type="hidden" name="posSearch" id="posSearch">
</form>

<!-- Modal -->
<div class="modal fade" id="dispatchDetails" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 style="font-weight:600;" class="modal-title text-center">Add Dispatch Details</h4>
			</div>
			<div class="modal-body">
				<div class="row form-group">
					<div class="control-group col-md-12 col-lg-12 col-sm-12 col-xs-12">
						<label class="control-label color_black">Company Name<span style="color:#800000;">*</span></label>
						<div class="controls">
							<input name="company_name" id="company_name" type="text" class="span6  form-control register_form">
							<span class="form-input-info positioning" style="color:#FF0000"></span>
						</div>
					</div>        
				</div>
				<div class="row form-group">
					<div class="control-group col-md-9 col-lg-9 col-sm-9 col-xs-12">
						<label class="control-label color_black">Tracking No.<span style="color:#800000;">*</span></label>
						<div class="controls">
							<input name="tracking_no" id="tracking_no" type="text" class="span6  form-control register_form">
							<span class="form-input-info positioning" style="color:#FF0000"></span>
						</div>
					</div>   

					<div class="control-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
						<label class="control-label color_black">Actual Amount<span style="color:#800000;">*</span></label>
						<div class="controls">
							<input name="actual_amount" id="actual_amount" type="text" onkeyup="checkPriceVal(event)" class="span6  form-control register_form">
							<span class="form-input-info positioning" style="color:#FF0000"></span>
						</div>
					</div> 			
				</div>
				<div class="modal-footer">
					<button type="button" id="submit" class="btn btn-default">SAVE</button>
				</div>
			</div>
		</div>
	</div>
</div>
<form id="submitForm" action="<?php echo site_url(); ?>postage/save_dispatch_details" class="form-group" role="form" enctype="multipart/form-data" method="post">
	<input type="hidden" id="post_track_no" name="post_track_no">
	<input type="hidden" id="post_actual_amt" name="post_actual_amt">
	<input type="hidden" id="post_comp_name" name="post_comp_name">
	<input type="hidden" id="post_id" name="post_id">
</form>

<script type="text/javascript">	
	var currentTime = new Date()
	var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
	var maxDate =  new Date(currentTime.getFullYear(), currentTime.getMonth() +12, +0); // one day before next month
	$( ".todayDate2" ).datepicker({ 
		//minDate: minDate, 
		//maxDate: maxDate,
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50",
		dateFormat: 'dd-mm-yy'
	});
			
	$('.todayDate').on('click', function() {
		$( ".todayDate2" ).focus();
	});

	//MODAL TO ADD DISPATCH DETAILS
	function callModal(postageId) {
		document.getElementById("post_id").value = postageId;
		$('#company_name').css('border-color','black');
		$('#tracking_no').css('border-color','black');
		$('#actual_amount').css('border-color','black');
		$('#dispatchDetails').modal();
	}

	<!-- Check If Price Is Zero -->
	function checkPriceVal(evt){
		inputPrice = evt.currentTarget;
		if($(inputPrice).val() && Number($(inputPrice).val()) == 0){
			$(inputPrice).val("");
		} 			
	}

	<!-- Actual Amount Validation -->
	$('#actual_amount').keyup(function() {
		var $th = $(this);
		$th.val( $th.val().replace(/[^0-9]/g, function(str) { return ''; } ) );
	});

	$('#submit').on('click', function() {
		var count = 0;

		if (document.getElementById("company_name").value != "") {
			$('#company_name').css('border-color', "#000000");
		} else {
			$('#company_name').css('border-color', "#FF0000");
			++count;
		}

		if (document.getElementById("tracking_no").value != "") {
			$('#tracking_no').css('border-color', "#000000");
		} else {
			$('#tracking_no').css('border-color', "#FF0000");
			++count;
		}

		if (document.getElementById("actual_amount").value != "") {
			$('#actual_amount').css('border-color', "#000000");
		} else {
			$('#actual_amount').css('border-color', "#FF0000");
			++count;
		}

		if(count != 0) {
			alert("Information","Please fill required fields","OK");
			return false;
		} else {
			document.getElementById("post_track_no").value = document.getElementById("tracking_no").value;
			document.getElementById("post_actual_amt").value = document.getElementById("actual_amount").value;
			document.getElementById("post_comp_name").value = document.getElementById("company_name").value;
			$('#submitForm').submit();
		} 
	});


	<!-- Validating Fields -->
	$('#submit2').on('click', function() {
		if(document.getElementById("startFrom").value == 0 && document.getElementById("startFrom").value == "") {
			$('#startFrom').css('border-color', "#FF0000");
			return;
		}
		var count = 0;
		var checkInput = document.getElementsByClassName("postChk");
		for(var i = 0; i < checkInput.length; i++) {
			if(checkInput[i].checked == true) {
				count++;
			}
		}
		if(count == 0) {
			alert('Information','Please select the labels to generate');
			return;
		}
		document.getElementById("start").value = document.getElementById("startFrom").value;
		document.getElementById("posSearch").value = $('#name_phone').val();
		document.getElementById("posDate").value = $('#todayDate').val();
		$('#formSub').submit();
	});
	
	//ON CHECKBOX CLICK
	function getOnSelect(checkBoxId) {
		var str = $('#selPostChk').val();
		var res = str.split(",");
		var selId = "";
		var checkInput = document.getElementsByClassName("postChk");
		if($('#' + checkBoxId).prop('checked') == true) {
			for(var i = 0; i < checkInput.length; i++) {
				if(checkInput[i].checked == true) {
					selId += checkInput[i].id + ",";
				}
			}
			document.getElementById('selPostChk').value = selId;
		} else {
			for(var i = 0; i < checkInput.length; i++) {
				if(checkInput[i].checked == true) {
					selId += checkInput[i].id + ",";
				}
			}
			document.getElementById('selPostChk').value = selId;
		}
	}
	
	//ON CLICK ADD BUTTON
	function edit(lblCnt) {
	
		$('.labelGen').html(lblCnt);
		$('.labelGen').append("<br/><label>Get Label Start From: </label> <input type=text name=startFrom id=startFrom maxlength=2 style=width:3%;><br/>");
		$('#lblGen').modal();
	}
	
	//ON DATE CHANGE
	function get_datefield_change(date) {
		document.getElementById('tdate').value = date;
		document.getElementById('labelCounter').value = $('#lblCounter').val();
		document.getElementById('name_phone').value = $('#name_phone').val();
		
		url = "<?php echo site_url(); ?>Postage/get_filter_data";
		$("#tddate").attr("action",url)
		$("#tddate").submit();
	}
	
	//ON CHANGE OF LABEL
	function get_label_change(label) {
		document.getElementById('tdate').value = $('#todayDate').val();
		document.getElementById('labelCounter').value = label;
		document.getElementById('name_phone').value = $('#name_phone').val();
		
		url = "<?php echo site_url(); ?>Postage/get_filter_data";
		$("#tddate").attr("action",url)
		$("#tddate").submit();
	}
	
	//ON NAME PHONE SEARCH
	function get_name_phone_search() {
		document.getElementById('tdate').value = $('#todayDate').val();
		document.getElementById('labelCounter').value = $('#lblCounter').val();
		document.getElementById('name_phone').value = $('#name_phone').val();
		
		url = "<?php echo site_url(); ?>Postage/get_filter_data";
		$("#tddate").attr("action",url)
		$("#tddate").submit();
	}

	//GET EXCEL REPORT
	function GetSendField() {
		document.getElementById('tdate').value = $('#todayDate').val();
		document.getElementById('labelCounter').value = $('#lblCounter').val();
		document.getElementById('name_phone').value = $('#name_phone').val();

		url = "<?php echo site_url(); ?>Postage/get_excel_report";
		$("#tddate").attr("action",url)
		$("#tddate").submit();
	}
</script>