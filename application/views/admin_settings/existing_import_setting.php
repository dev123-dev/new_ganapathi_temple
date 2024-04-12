<section id="section-register" class="bg_register">
    <div class="container-fluid sub_reg" style="min-height:100%;">  	
		<!-- START Content -->
		<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
		
		<div class="container reg_top adminside">
			<!-- START Row -->
			<div class="row-fluid">
				<!-- START Datatable 2 -->
				<div class="span12 widget lime">
					<section class="body">
						
						<div class="row form-group"> 
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
								<span class="eventsFont2">Shashwath Old Members</span>
							</div>		
							<form action="<?=site_url();?>admin_settings/Admin_setting/search_existing_shashwath_member" enctype="multipart/form-data" method="post" accept-charset="utf-8">
								<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6" style="padding-left:0px;">
									<div class="input-group input-group-sm">
										<input autocomplete="off" type="text" id="reciept_no" name="reciept_no" value="<?=@$reciept_no?>" class="form-control" placeholder="Receipt No">
										<div class="input-group-btn">
										  <button class="btn btn-default reciept_no" type="submit">
											<i class="glyphicon glyphicon-search"></i>
										  </button>
										</div>
									</div>
								</div>
							</form>

							<!-- reciept_name -->
							 <form action="<?=site_url();?>admin_settings/Admin_setting/search_existing_shashwath_member_name" enctype="multipart/form-data" method="post" accept-charset="utf-8">
								<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6" style="padding-left:0px;">
									<div class="input-group input-group-sm">
										<input autocomplete="off" type="text" id="reciept_name" name="reciept_name" value="<?=@$reciept_name?>" class="form-control" placeholder="Member Name">
											<div class="input-group-btn">
												<button class="btn btn-default reciept_name" type="submit">
													<i class="glyphicon glyphicon-search"></i>
												</button>
											</div>
										</div>
									</div>
							</form>
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 no-pad" style="float:right;clear:both; margin-top: -30px;">
								<a style="width:24px; height:24px;margin-left:.5em;" class="pull-right img-responsive" href="<?=site_url()?>admin_settings/Admin_setting/existing_import_setting" title="Reset"><img src="<?=site_url();?>images/refresh.svg"/></a>

								<a style="width:24px; height:24px;" class="pull-right img-responsive" title="Import"><img id ="edithide1" onclick="show_import()" src="<?=site_url();?>images/import.svg"  style="display: block;"/></a>

								<a style="width:24px; height:24px;margin-right:.5em;" class="pull-right img-responsive" href="<?=site_url()?>Shashwath/shashwath_member" title="Back"><img id ="edithide2"  src="<?=site_url();?>images/back_icon.svg" /></a>
							</div>
						</div>
						
						<br />
							<div class="table-responsive" id="calendar_data">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th style="width:2%;"><strong>RECEIPT NO</strong></th>
											<th style="width:2%"><strong>RECEIPT DATE</strong></th>
											<th style="width:5%"><strong>MEMBER NAME</strong></th>
											<th style="width:5%;"><strong>ADDRESS1</strong></th>
											<th style="width:1%"><strong>CITY</strong></th>
											<th style="width:5%"><strong>PURPOSE</strong></th>
											<th style="width:1%"><strong>OPERATION</strong></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($existing_import_setting  as $result) {
										    echo "<tr>";
											echo "<td><center>".$result['sm_reciept_no']."</center></td>";
											echo "<td>".$result['sm_reciept_date']."</td>";
											echo "<td>".$result['sm_member_name']."</td>";
											echo "<td>".$result['sm_addr1']."</td>";
											echo "<td>".$result['sm_city']."</td>";
											echo "<td>".$result['sm_purpose']."</td>";
											echo "<td class='text-center' >
													<a style='border:none; outline: 0;' href='javascript:sendId(".$result['sm_id'].");' title='Edit Member Details'><img style='border:none; outline: 0;text-align:center' src='".base_url()."images/edit_icon.svg'></a>
												 </td>";	
											echo "</tr>";
										} ?> 
									</tbody>
								</table>
								
							</div>
					</section>
				</div>
			</div>
				<div class= "row">
				<ul class="pagination pagination-sm" style="margin-left:15px;margin-top: -0.2em;">
					<?=$pages; ?>
				</ul>
				<label class="pull-right" style="font-size:18px;margin-right:15px;margin-top: -0.2em;">Total Members: <strong style="font-size:18px"><?php echo $total_rows ?></strong></label>			
			</div>
		</div>
	</div>
</section>
<!-- Import Modal2 -->
<div id="myModalImport" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content" style="padding-bottom:1em;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Import Details</h4>
			</div>
			<div class="modal-body" id="importdet" >
				
					<!--code for importing excel file starts-->
						<div class="container">
							<br />
							<!--<h3>Import Excel Details </h3>-->
							<form method="post" id="import_form" enctype="multipart/form-data">
								<p><label>Select Excel File</label>
								<input type="file" name="file" id="file" required accept=".xls, .xlsx" /></p>
								<br />
								<input type="submit" name="import" value="Import" class="btn btn-info" />
							</form>
							
						</div>
						<!--code for importing excel file ends-->
						
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>
<form id="formEditMember" method="post" action="<?php echo site_url();?>Shashwath/edit_existing_shashwath_member">
	<input type="hidden" id="identity" name="memberId" value=""/>	
</form> 

<script>
	//code for importing excel file starts
	
	$(document).ready(function(){
		
		$('#import_form').on('submit', function(event){
			 $('#myModalImport').modal('toggle');
			event.preventDefault();
			$.ajax({
				url:"<?php echo base_url(); ?>existing_excel_import/import",
				method:"POST",
				data:new FormData(this),
				contentType:false,
				cache:false,
				processData:false,
				success:function(data){
					$('#file').val('');
					window.location.href = "<?php echo base_url(); ?>admin_settings/Admin_setting/existing_import_setting";
					alert("Information",data,"OK");

				}
			})
		});
	});
	//code for importing excel file ends
   /* if('<?php echo $editStatus ?>' == 0){
		$("#edithide").hide();
    }*/

	$('#submitform').on('click',function(){
		 $('#formval').submit();
	});

	//DATEFIELD
	var currentTime = new Date()
	var minDate = "-1Y"; //one day next before month
	var maxDate =  0; // one day before next month
	$( ".todayDate2" ).datepicker({ 
		minDate: minDate, 
		maxDate: maxDate,
		dateFormat: 'dd-mm-yy'
	});
			
	$('.todayDate').on('click', function() {
		$( ".todayDate2" ).focus();
	})
/*
	//DATEFIELD AND FILTER CHANGE
	function GetDataOnDate(date,url) {
		document.getElementById('date').value = date;
		document.getElementById('paymentMethod').value = $('#modeOfPayment').val();
		document.getElementById('users_id').value = $('#users').val();
		$("#dateChange").attr("action",url)
		$("#dateChange").submit();
	}
	
	//DATEFIELD AND FILTER CHANGE
	function GetDataOnUser(users,url) {
		document.getElementById('date').value = $('#todayDate').val();
		document.getElementById('users_id').value = users;
		document.getElementById('paymentMethod').value = $('#modeOfPayment').val();
		$("#dateChange").attr("action",url)
		$("#dateChange").submit();
	}
	
	//DATEFIELD AND FILTER CHANGE
	function GetDataOnFilter(payMode,url) {
		document.getElementById('date').value = $('#todayDate').val();
		document.getElementById('users_id').value = $('#users').val();
		document.getElementById('paymentMethod').value = payMode;
		$("#dateChange").attr("action",url)
		$("#dateChange").submit();
	}
	*/
	//SHOW MODAL
	function show_import() {
		$('#myModalImport').modal('show');  
	}

	//IMPORT DETAILS
	function save_import() {
		var users = ($('#users_active').val()).split("|");
		var events = ($('#events_active').val()).split("|");
		
		document.getElementById('userId').value = users[0];
		document.getElementById('userName').value = users[1];
		document.getElementById('eventId').value = events[0];
		document.getElementById('eventName').value = events[1];
		return true;
	}

	function sendId(sm_id) {
		 $('#identity').val(sm_id);
		 $('#formEditMember').submit();
	}
</script>