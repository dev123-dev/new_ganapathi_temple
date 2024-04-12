<div class="container">
<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
<!--Heading And Refresh Button-->
<div class="row form-group">
	<div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
		<span class="eventsFont2">Shashwath Deficit Report</span>
	</div>
	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4" style="margin-top:3.5px;">
		<a style="width:24px; height:24px" class="pull-right img-responsive" href="<?=site_url()?>Shashwath/lossReport" title="Reset"><img title="reset" src="<?=site_url();?>images/refresh.svg"/></a>
	</div>
</div>
	
<div class="row form-group" style="margin-top:-0.5em">
	<form action="<?=site_url();?>Shashwath/search_lossReport" id="lossForm" enctype="multipart/form-data" method="post" accept-charset="utf-8">

			<!-- <input autocomplete="" id="todayDate" type="hidden" value="<?=@$date; ?>" class="form-control todayDate2" placeholder="dd-mm-yyyy" readonly = "readonly" /> -->
			<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
				<div class="input-group input-group-sm">
					<input type="hidden" name="date" value="<?=@$date; ?>" id="date" value="" >
					<input type="hidden" name="load" id="load" value="">
					<input autocomplete="" id="todayDate" type="text" value="<?=@$date; ?>" class="form-control todayDate2"  onchange="GetDataOnDate(this.value,'<?php echo site_url()?>Shashwath/search_lossReport')" placeholder="dd-mm-yyyy" readonly = "readonly"  />
					<div class="input-group-btn">
					  <button class="btn btn-default todayDate" type="button">
						<i class="glyphicon glyphicon-calendar"></i>
					  </button>
					</div>
				</div>
			</div>					
			<div class="col-lg-2 col-md-4 col-sm-3 col-xs-6" style="padding-bottom:5px;">
				<div class="input-group input-group-sm">
					<input autocomplete="off" type="text" id="name_phone" name="name_phone" value="<?php echo @$name_phone ?>" class="form-control" placeholder="Name/Phone" />
					<div class="input-group-btn">
						<button class="btn btn-default name_phone" type="submit">
							<i class="glyphicon glyphicon-search"></i>
						</button>
					</div>
				</div>
			</div>
			
		<!-- 	<div class="col-lg-2 col-md-4 col-sm-3 col-xs-6" >
				<div class="input-group input-group-sm form-group"> -->
				<!-- 	<input type="hidden" name="date" value="<?=@$date; ?>" id="date" value="" >
					<strong>Date :</strong> <?=@$date; ?> -->
						<!--<?php $this->session->set_userdata('losspageDate',@$date)?>  -->
				<!-- </div>
			</div> -->
	</form>	
	<div class="col-lg-4 col-md-2 col-sm-4 col-xs-12 pull-right text-right">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-left:15px;margin-top:0.1em">
		<a style="cursor:pointer;"><img style="width:24px; height:24px" title="Download Excel Loss Report" id="buttonExcel" src="<?=site_url();?>images/excel_icon.svg"/></a>&nbsp;&nbsp;
		<a 	style="cursor:pointer;"><img style="width:24px; height:24px" title="Download PDF Loss Report" id="buttonPDF" src="<?=site_url();?>images/pdf_icon.svg"/></a>&nbsp;&nbsp;
		<a href="#" id="buttonPrint"><img style="width:24px; height:24px" title="Print Loss Report" src="<?=site_url();?>images/print_icon.svg"/></a>
		</div>
	</div>
</div>
	
</div>
<div class="container" style="margin-top:-1em;">
	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th width="5%" ><center>SS_ID</center></th>
							<th>Name (Phone)</th>
							<th>Deity Name</th>
							<th>Seva Name</th>
							<th>Accumulated Deficit</th>
						</tr>
					</thead>
					<tbody>
						<?php if(isset($mainLoss)){ $count = 0; $totalLoss = 0;?>
						<?php foreach($mainLoss as $res){?>
						<tr>
							<td ><center><a style = "color:#800000;" title ="Click Here For Shashwath Detailed Loss Report" onclick="lossDetail('<?=@$date; ?>','<?php echo $mainLoss[$count]->SS_ID;?>','<?php echo $mainLoss[$count]->SM_ID;?>','<?php echo $mainLoss[$count]->ACCUMULATED_LOSS;?>','<?php echo site_url();?>Shashwath/lossDetail','<?php echo $mainLoss[$count]->SO_ID;?>')"><?php echo $res->SS_ID;?> </a></center></td>
							<!-- <td><a style = "color:#800000;" title ="Click Here For Shashwath Detailed Loss Report" onclick="lossDetail('<?=@$date; ?>','<?php echo $mainLoss[$count]->SS_ID;?>','<?php echo $mainLoss[$count]->ACCUMULATED_LOSS;?>','<?php echo site_url();?>Shashwath/lossDetail','<?php echo $mainLoss[$count]->SO_ID;?>')"> <?php echo $res->NAME_PHONE; ?></a></td> -->
							<td><?php echo $res->NAME_PHONE; ?></td>
							<td><?php echo $res->DEITY_NAME;?></td>
							<td><?php echo $res->SEVA_NAME;?></td>
							<td><?php echo $res->ACCUMULATED_LOSS;?></td>
						</tr>
						
						<?php $count++; }} ?>
					</tbody>
				</table>
				
				<?php foreach($TotalAccumulatedLoss as $res){?>
					<?php $ACCUMULATED_LOSS = explode(' ',$res->ACCUMULATED_LOSS)[1];?>
					<?php $totalLoss += explode('/',$ACCUMULATED_LOSS)[0];?>
				<?php } ?>
				
				<!-- <ul class="pagination pagination-sm">
					<?=$pages;?>
				</ul>
			</div>
			<label style="float:right;padding-right:0px;font-size:16px;margin-top:-3em;"><strong>Total Deficit&nbsp;</strong>: Rs. <?php echo $totalLoss;?>/-</label>  -->
		</div>
	</div>

</div>
	<div class= "row">
		<ul class="pagination pagination-sm" style="margin-left:15px;margin-top:-1em;">
			<?=$pages; ?>
		</ul> 
			<label style="float:right;font-size:16px;margin-top:-1em;margin-right:1em;"><strong>Total Deficit&nbsp;</strong>: Rs. <?php echo $totalLoss;?>/-</label> 			
	</div> 

<form action="" id="lossDetailForm" enctype="multipart/form-data" method="post" accept-charset="utf-8">
	<input type="hidden" id="ssVal" name="ssVal" />
	<input type="hidden" id="memberId" name="memberId" />
	<input type="hidden" id="soVal" name="soVal" />
	<input type="hidden" id="searchDate" name="searchDate" />
	<input type="hidden" id="total" name="total" />
</form>

<form id="formGenReport" method="post">
	<input type="hidden" name="date" id="dateForReport" value="" />
</form>

<script>
	var maxDate =  0;
	$( ".todayDate2" ).datepicker({ 
		changeMonth: true,
		changeYear: true,
		//minDate: minDate, 
		maxDate: maxDate,
		dateFormat: 'dd-mm-yy',
		'yearRange': "2007:+50"
	});
	
	
	$('.todayDate').on('click', function() {
		$( ".todayDate2" ).focus();
	});
		
	function GetDataOnDate(receiptDate,url) {
		document.getElementById('date').value = receiptDate;
		document.getElementById('load').value = "lossForm";
	 	// document.getElementById("ssVal").value = todayDate;
		$("#lossForm").attr("action",url)
		$("#lossForm").submit();
	}
	function GetLossOnDate(lossDate,url) {
		document.getElementById('date').value = lossDate;
		//var date = document.getElementById('load').value = "DateChange";
		$("#lossForm").attr("action",url)
		$("#lossForm").submit(); 
	}
	
	function lossDetail(date,ssVal,smId,total,url,soVal){
		document.getElementById("ssVal").value = ssVal;
		document.getElementById("memberId").value = smId;
		document.getElementById("soVal").value = soVal;
		document.getElementById("searchDate").value = date;
		// document.getElementById("total").value = total;
		$("#lossDetailForm").attr("action",url)
		$("#lossDetailForm").submit(); 
	}
	
	$('#buttonExcel').on('click',function(e){
		var url = '<?php echo site_url();?>Report/shashwath_report_excel'
		$('#dateForReport').val(document.getElementById('todayDate').value);
		$("#formGenReport").attr("action",url)
		$("#formGenReport").submit(); 
	});

	$('#buttonPDF').on('click',function(e){
		var url = '<?php echo site_url();?>generatePDF/create_ShashwathPdf'
		$('#dateForReport').val(document.getElementById('todayDate').value);
		$("#formGenReport").attr("action",url)
		$("#formGenReport").submit(); 
	}); 
	
	$('#buttonPrint').on('click',function(e){
		var url = '<?php echo site_url();?>generatePDF/create_ShashwathPdf'
		$('#dateForReport').val(document.getElementById('todayDate').value);
		$("#formGenReport").attr("action",url)
		$("#formGenReport").submit(); 
	});
</script>