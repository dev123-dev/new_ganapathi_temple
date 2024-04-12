<?php //$this->output->enable_profiler(TRUE);
	
 ?>
<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<div class="row form-group">
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 marginTop">
			<span class="samFont1"><?=$event['TET_NAME']; ?></span>
		</div>
		<form action="<?=site_url();?>TrustEvents/searchSeva" id="dateChange" enctype="multipart/form-data" method="post" accept-charset="utf-8" onsubmit="return field_validation();">
			<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
				<div class="input-group input-group-sm">
					 <input type="hidden" name="date" value="<?=@$date; ?>" id="date" value="">
					<input type="hidden" name="load" id="load" value="">
					<input autocomplete="" id="todayDate" type="text" value="<?=@$date; ?>" class="form-control todayDate2" style="margin-top:0.5em;" onchange="GetDataOnDate(this.value,'<?php echo site_url()?>TrustEvents/searchSeva/')" placeholder="dd-mm-yyyy" readonly="readonly"/>
					<div class="input-group-btn">
					  <button class="btn btn-default todayDate" type="button"style="margin-top:0.5em;">
						<i class="glyphicon glyphicon-calendar"></i>
					  </button>
					</div>
				</div>
			</div>
			
			<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 ">
				<div class="input-group input-group-sm">
					<input autocomplete="" type="text" id="name_phone" name="name_phone"  style="margin-top:0.5em;" value="<?=@$name_phone; ?>" class="form-control" placeholder="Name / Phone">
					<div class="input-group-btn">
					  <button class="btn btn-default name_phone" type="submit" style="margin-top:0.5em;">
						<i class="glyphicon glyphicon-search"></i>
					  </button>
					</div>
				</div>
			</div>
			
		<div class="col-offset-lg-6 col-lg-1 col-md-2 col-sm-4 col-xs-12 pull-right text-right">
			<?php if(isset($_SESSION['Add'])) { ?>
				<a style="margin-left: 9px;pull-right;" href="<?=site_url()?>TrustEvents/event_receipt" title="Add Event Seva"><img style="width:24px; height:24px;margin-top:0.8em;" src="<?=site_url();?>images/add_icon.svg"/></a>
			<?php } ?>
			<a style="text-decoration:none;cursor:pointer;pull-right;" href="<?=site_url()?>TrustEvents" title="Refresh"><img style="width:24px; height:24px;margin-top:0.8em;" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
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
						<th style="width: 13%;">Rashi (Nakshatra)</th>
						<th>Seva</th>
						<?php if(isset($_SESSION['Edit'])) { ?>
							<th style="width: 5%;">Operation</th>
						<?php } ?>
					  </tr>
					</thead>
					 <tbody>
					   <?php foreach($eventSeva as $result) {
						   $receiptNo = $result['TET_RECEIPT_NO'];
							echo "<tr>";
							echo "<td><a style='cursor:pointer;color:#800000;text-decoration:none;' onClick='printReceipt(`$receiptNo`,1)'>".$result['TET_RECEIPT_NO']."</a></td>";
							if($result['TET_RECEIPT_PHONE'] != "") 
								echo "<td>".$result['TET_RECEIPT_NAME']. " (".$result['TET_RECEIPT_PHONE'].")"."</td>";
							else
								echo "<td>".$result['TET_RECEIPT_NAME']."</td>";
							if($result['TET_RECEIPT_NAKSHATRA'] != "") {
								echo "<td>".$result['TET_RECEIPT_RASHI']. " (".$result['TET_RECEIPT_NAKSHATRA'].")"."</td>";
							}else
								echo "<td>".$result['TET_RECEIPT_RASHI']."</td>";
							echo "<td>".$result['TET_SO_SEVA_NAME']."</td>";
							if(isset($_SESSION['Edit'])) { 
								echo "<td style='cursor:pointer;'><center><a title='Edit Seva Offered Date' onClick='printReceipt(`$receiptNo`, 2)';><span style='color:#800000' class='glyphicon glyphicon-pencil'></span></a></center></td>";
							} 
							echo "</tr>";
					    } ?>
					</tbody>
				</table>
				<ul class="pagination pagination-sm">
					<?=$pages; ?>
				</ul>
			</div>
			</div>
			</div>
		</div>
		
		<form id="printReceipt" method="post" action="<?=site_url()?>TrustEvents/editReceipt/">
			<input type="hidden" name="receiptNo" id="receiptNo"/>
		</form>
		<script>
			var currentTime = new Date()
					var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
					var maxDate =  new Date(currentTime.getFullYear(), currentTime.getMonth() +12, +0); // one day before next month
					$( ".todayDate2" ).datepicker({ 
						minDate: minDate, 
						//maxDate: maxDate,
						dateFormat: 'dd-mm-yy',
						changeYear: true,
						changeMonth: true,
						'yearRange': "2007:+50",
					});
					
			$('.todayDate').on('click', function() {
				$( ".todayDate2" ).focus();
			})
			
			function printReceipt(receiptNo, num) {
				if(num == 1) {
					$('#receiptNo').val(receiptNo);
					$('#printReceipt').attr('action',"<?=site_url()?>TrustEvents/printSevaReceipt/");
					$('#printReceipt').submit();
				}else {
					$('#receiptNo').val(receiptNo);
					$('#printReceipt').attr('action',"<?=site_url()?>TrustEvents/editReceipt/");
					$('#printReceipt').submit();
				}
			}
			
			 function field_validation() {
				  var count = 0;
				  
				  if(!$('#todayDate').val()) {
				   $('#todayDate').css('border', "1px solid #FF0000"); 
				   ++count
				   
				  } else {
				   $('#todayDate').css('border', "1px solid #000000"); 
				  }
				  
				  if(count != 0) {
				   alert("Information","Please fill required fields","OK");
				   return false;
				  }
			 }
				 
				function GetDataOnDate(receiptDate,url) {
				  document.getElementById('date').value = receiptDate;
				  document.getElementById('load').value = "DateChange";
				  
				  $("#dateChange").attr("action",url)
				  $("#dateChange").submit();
				 }
		
		</script>



