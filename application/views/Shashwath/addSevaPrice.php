<div class="container">
<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" >
<form action="" id="dateChange" enctype="multipart/form-data" method="post" accept-charset="utf-8">
	<div class="row form-group">
		<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:0em">
			<span class="eventsFont2">Add Shashwath Seva Price </span>
		</div>
	</div>
	<div class="row form-group" style="margin-top:-0.5em">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6" style="padding-left:0px;">
				<div class="input-group input-group-sm">
				<strong>Date :</strong> <?=@$date; ?>
				</div>
			</div>
			</form>
			<div class="col-lg-8 col-md-6 col-sm-6 col-xs-12 pull-right text-right" style="padding-right:0px;">
				<a style="text-decoration:none;cursor:pointer;pull-right;" href="<?=site_url()?>Shashwath/addSevaPrice" title="Refresh"><img style="width:24px; height:24px;margin-top:-0.3em;" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
			</div>
		</div>	
	</div>
</div>
				
<div class="container">
	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th width="30%">Name </th>
							<th width="30%">Deity Name</th>
							<th width="30%">Seva Name</th>
							<th width="15%">Seva (Price)</th>
							<th width="15%">Operation</th>
							
						</tr>
					</thead>
					<tbody>
					    <?php if(isset($shashwath_Sevas)){ $count =0;?>
						<?php foreach($shashwath_Sevas as $result) { ?>
						<tr>
							<td width="10%"><?php echo $result->SM_NAME;?> </td>
							<td width="20%"><?php echo $result->SO_DEITY_NAME;?></td>
							<td width="20%"><?php echo $result->SO_SEVA_NAME;?></td>
							<td><?php echo $result->SO_PRICE;?></td>
							<td> <?php if($result->SO_PRICE == 0){
										  $todayDate = strtotime(date('d-m-Y'));
										  $soDate = strtotime($result->SO_DATE);
										  
										if($todayDate >= $soDate){
	echo "<a onclick='priceAdd(".$shashwath_Sevas[$count]->SO_ID.");'><img style='width:24px; height:24px' class='img-responsive pull-right' title='Add Seva Price' src=".site_url()."images/add.svg></a>";
}   
  
  
									  }
											$count ++; ?>  
							</td>
						</tr>
						<?php }} ?>
					</tbody>
				</table>
				<ul class="pagination pagination-sm">
					<?=$pages;?>
				</ul>
			</div>
		</div>
	</div>

		 <!-- Modal -->
<form action="<?=site_url();?>Shashwath/priceSubmit" id="priceForm" method="post">
  <div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog">
	
	  <!-- Modal content-->
	  <div class="modal-content">
		<div class="modal-header">
		<h4 class="modal-title">Add Seva Price</h4>
		  <button type="button" class="close" data-dismiss="modal" style="margin-top:-10px;">&times;</button>
		</div>
		<div class="modal-body">
		  <p><b>Name :</b> <span id="sm_name"></span></p>
		  <p><b>Seva Name :</b> <span id="seva_name"></span></p>
		  <p><b>Seva Price :</b> <input type="text" class = "form_contct2" name="price" id="price" autocomplete="off" /></p>
		  <input type="hidden" name="id" id="id" value="" />
		  <input type="hidden" name="selectedDate" id="selectedDate" value="<?=@$date; ?>" />
		  <input type="hidden" name="fromAddSevaPrice"  value="fromAddSevaPrice" />
		</div>
		<div class="modal-footer">
		  <input type="submit" class="btn btn-default" value="Submit" />
		  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
	  </div>
	</div>
  </div>
 </form>	
</div>

<script type="text/javascript">	
    $('#price').keyup(function (e) {
		var $th = $(this);
		if (e.keyCode != 46 && e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 38 && e.keyCode != 39 && e.keyCode != 40) {
			$th.val($th.val().replace(/[^0-9]/g, function (str) { return ''; }));
		} return;
	});

    var soNumber = "";
	function priceAdd(indexVal) {
		 document.getElementById("id").value = indexVal ;
		 document.getElementById("selectedDate").value = "<?=@$date; ?>";
		 $.ajax({
			type: "POST",
			url: "<?php echo base_url();?>/Shashwath/priceAdd",
			data: { indexVal: indexVal },
			success: function (response) {
			var member = response.split("$");
				 $('#sm_name').text(member[0]);
				 $('#seva_name').text(member[1]);
				 $('#id').val(member[2]);
				 $("#myModal").modal();  
			}
		}); 
	}
	var currentTime = new Date()
	var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
	var maxDate =  new Date(currentTime.getFullYear(), currentTime.getMonth() +12, +0); // one day before next month
	$( ".todayDate2" ).datepicker({ 
		//minDate: minDate;
		//maxDate: maxDate,
		dateFormat: 'dd-mm-yy',
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50"
	});
	$('.todayDate').on('click', function() {
		$( ".todayDate2" ).focus();
	});

	function GetSevaOnDate(receiptDate,url) {
		document.getElementById('date').value = receiptDate;
		$("#dateChange").attr("action",url)
		$("#dateChange").submit(); 
	}
	

</script>