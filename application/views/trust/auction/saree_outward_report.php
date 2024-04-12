<style>
    .datepicker {
      z-index: 1600 !important; /* has to be larger than 1050 */
    } .chequedate {
      z-index: 1600 !important; /* has to be larger than 1050 */
    }
</style>
<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<!--Heading And Refresh Button-->
	<div class="row form-group">
		<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
			<span class="eventsFont2">Saree Outward Report: <span class="samFont"><?php echo $events[0]->TET_NAME; ?></span></span>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="margin-top: 1em;">
			<a style="width:24px; height:24px" class="pull-right img-responsive" href="<?=site_url()?>TrustReport/saree_outward_report" title="Refresh"><img title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
		</div>
	</div>
	
	<!--DateField, Reports Button -->
	<div class="row form-group">
		<form id="tddate" enctype="multipart/form-data" method="post" accept-charset="utf-8">
			<div class="multiDate">
				<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5">
					<div class="input-group input-group-sm">
						<input id="todayDate" name="todayDate" type="text" value="<?php echo $date; ?>" class="form-control todayDate" placeholder="dd-mm-yyyy" onchange="get_datefield_change(this.value)" readonly="readonly">
						<div class="input-group-btn">
						  <button class="btn btn-default todayDateBtn" type="button">
							<i class="glyphicon glyphicon-calendar"></i>
						  </button>
						</div>
					</div>
					<?php if(isset($date)) { ?>
						<input type="hidden" name="tdate" id="tdate" value="<?php echo $date; ?>">
					<?php } ?>
				</div>
			</div>
		</form>
		
		<form id="report" enctype="multipart/form-data" method="post" accept-charset="utf-8">
			<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right pull-right">
				<a onclick="GetSendField()" style="cursor:pointer;"><img style="width:24px; height:24px" title="Download Excel Report" src="<?=site_url();?>images/excel_icon.svg"/></a>&nbsp;&nbsp;
				<a onclick="generatePDF()"><img style="width:24px; height:24px" title="Download PDF Report" src="<?=site_url();?>images/pdf_icon.svg"/></a>&nbsp;&nbsp;
				<a onClick="print();"><img style="width:24px; height:24px" title="Print Report" src="<?=site_url();?>images/print_icon.svg"/></a>
			</div>
			<!--HIDDEN FIELDS -->
			<input type="hidden" name="dateField" id="dateField">
		</form>
	</div>
</div>	
<!--Datagrid -->
<div class="container">
	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
					  <tr>
						<th style="width:10%;">Reference No.</th>
						<th style="width:20%;">Name</th>
						<th style="width:20%;">Phone</th>
						<th style="width:20%;">Category</th>
						<th>Saree Details</th>
						<th style="width:5%">Operation</th>
					  </tr>
					</thead>
					<tbody>
						<?php foreach($auction_item_report as $result) { ?>
							<tr class="row1">
								<td><?php echo $result->ITEM_REF_NO; ?></td>
								<td><?php echo $result->AIL_NAME; ?></td>
								<td><?php echo $result->AIL_NUMBER; ?></td>
								<td><?php echo $result->AIL_AIC_NAME; ?></td>
								<td><?php echo $result->AIL_ITEM_DETAILS; ?></td>
								<td style='cursor:pointer;'>
									<center><a title='Edit Seva Offered Date' onClick='editOption("<?=$result->AIL_ID; ?>", "<?=$result->AIL_AIC_ID; ?>", "<?=$result->AIL_EVENT_ID; ?>", "<?=$result->AIC_SEVA_DATE; ?>", "<?=$result->ITEM_REF_NO; ?>", event)';><span style='color:#800000' class='glyphicon glyphicon-pencil'></span></a></center>
								</td>
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

<div class="modal fade" id="chequeRemmittance" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" style="margin-top:-14px;">&times;</button>
				<h4 style="font-weight:600;" class="modal-title text-center">Edit Saree Date</h4>
			</div>
			<div class="modal-body">
				<div class="col-md-6 text-left">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-inline">
							<label for="name"><span style="font-weight:600;">Reference No: </span><?php echo $result->ITEM_REF_NO; ?></label>
							
						</div>
					</div>
					
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-inline">
							<label for="name"><span style="font-weight:600;">Name: </span><?php echo $result->AIL_NAME; ?></label>
							
						</div>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-inline">
							<label for="name"><span style="font-weight:600;">Phone: </span><?php echo $result->AIL_NUMBER; ?></label>
							
						</div>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-inline">
							<label for="name"><span style="font-weight:600;">Category: </span><?php echo $result->AIL_AIC_NAME; ?></label>
							
						</div>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-inline">
							<label for="name"><span style="font-weight:600;">Saree Details: </span><?php echo $result->AIL_ITEM_DETAILS; ?></label>
							
						</div>
					</div>
					
					<div style="clear:both;" class="form-group">
						<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<label for="seva"><span style="font-weight:600;">Seva Date:</span><span style="color:#800000;">*</span></label>
							<div class="input-group input-group-sm">
								<input name="chequedate" id="chequedate" type="text" value="" class="form-control chequedate" placeholder="dd-mm-yyyy" />
								<div class="input-group-btn">
								  <button class="btn btn-default todayDate1" type="button">
									<i class="glyphicon glyphicon-calendar"></i>
								  </button>
								</div>
							</div>
						</div>
					</div>
					<!-- HIDDEN -->
					
				</div>
				<div class="col-md-6 text-left alreadyExist" style="visibility:hidden;">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-inline">
							<label for="name"><strong style="color:red;text-decoration:underline;">Seva Already Exists</strong></label>
						</div>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-inline">
							<label for="name"><span style="font-weight:600;">Reference No: </span><span id="refno"></span></label>
							
						</div>
					</div>
					
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-inline">
							<label for="name"><span style="font-weight:600;">Name: </span><span id="name"></span></label>
							
						</div>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-inline">
							<label for="name"><span style="font-weight:600;">Phone: </span><span id="phone"></span></label>
							
						</div>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-inline">
							<label for="name"><span style="font-weight:600;">Category: </span><span id="category"></span></label>
							
						</div>
					</div>
					
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-inline">
							<label for="name"><span style="font-weight:600;">Saree Details: </span><span id="sareeDet"></span></label>
						</div>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-inline">
							<label for="name"><span style="font-weight:600;">Seva Date: </span><span id="sevaDate"></span></label>
						</div>
					</div>
					<!-- HIDDEN -->
					
				</div>
				<div class="modal-footer">
					<button type="button" id="submit" class="btn btn-default">Save</button>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	var currentTime = new Date()
	//alert(currentTime.getTime())
	
	var fromDate = "<?=$activeDate[0]->TET_FROM_DATE_TIME; ?>";
	if(fromDate < "<?=date('d-m-Y'); ?>") {
		fromDate = "<?=date('d-m-Y'); ?>";
	}
	
	var toDate = "<?=$activeDate[0]->TET_TO_DATE_TIME; ?>"; 
	fromDate = fromDate.split("-");
	toDate = toDate.split("-");
	
	var minDate = new Date(Number(fromDate[2]), (Number(fromDate[1])-1), + Number(fromDate[0])); 
	var maxDate =  new Date(Number(toDate[2]), (Number(toDate[1])-1), + Number(toDate[0]));
	
	$( ".chequedate" ).datepicker({ 
		minDate: minDate, 
		maxDate: maxDate,
		dateFormat: 'dd-mm-yy',
		 onSelect: function (date, inst) {
			if(sareeType == "1") {
			
				$('#submit').html("Check Availability");
			
			}
			else if(sareeType == "2") {
				$('#submit').html("Save");
				
			}else {
				$('#submit').html("Check Availability");
			}
		}
	});
	
	$('.todayDate1').on('click', function() {
		$( ".chequedate" ).focus();
	});
	
	var itemId = "";
	var sareeType = "";
	var eventName = "";
	var sevadate = "";
	var currentDate = "";
	var currentRefNo = "";
	
	$('#submit').on('click', function() {
		sevadate = $('#chequedate').val();
		let currentDate12 = currentDate.split("-");
		
		let day = currentDate12[0];
		let month = currentDate12[1];
		let year = currentDate12[2];
		
		let date = new Date(Number(year),(Number(month)-1),Number(day));
		
		let currentDate123 = sevadate.split("-");
		
		let day1 = currentDate123[0];
		let month1 = currentDate123[1];
		let year1 = currentDate123[2];
		
		let date12 = new Date(Number(year1),(Number(month1)-1),Number(day1));
		let date2 = new Date(Number("<?=date('Y')?>"),(Number("<?=date('m')?>")-1),Number("<?=date('d')?>"));
		
		$('#chequedate').css('border-color','black');
		
		if(sevadate == "") {
			$('#chequedate').css('border-color','red');
			alert("Please select the date to update")
			return false;
		} else if(date < date2) {
			// $('.modal').modal("hide");
			$('#chequedate').css('border-color','red');
			alert("Information","Please change the date to update")
			return false;
		}
		
		let opt = $('#submit').html().trim();
		if(opt == "Check Availability") {
			url = "<?=site_url(); ?>TrustAuction/checkSareeDate"
			$.post(url,{'itemId':itemId,'sareeType':sareeType,'event_name':eventName,'sevadate':sevadate}, function(e) {
				if(e != "0") {
					let st = JSON.parse(e);
					if(currentRefNo != st.ITEM_REF_NO) {
						$('#submit').html("Swap");
						$('.alreadyExist').css('visibility','visible');
						
						$('#refno').html(st.ITEM_REF_NO)
						$('#name').html(st.AIL_NAME)
						$('#phone').html(st.AIL_NUMBER)
						$('#sareeDet').html(st.AIL_ITEM_DETAILS)
						$('#category').html(st.AIL_AIC_NAME)
						$('#sevaDate').html(st.AIC_SEVA_DATE)
						
						$('#submit').html("Swap");
					} else {
						alert("Information", "Date is already set for selected Saree, Please select different date")
						$('#submit').html("Check Availability");
					}
				} else {
					$('#submit').html("Save");
				}  
					
			});
		} else if(opt == "Save") {
			if(date.getTime() == date12.getTime()) {
				alert("Information", "Date is already set for selected Saree, Please select different date")
				return false;
			} else {
			
				url = "<?=site_url(); ?>TrustAuction/updateSareeDate"
				$.post(url,{'itemId':itemId,'sareeType':sareeType,'event_name':eventName,'sevadate':sevadate}, function(e) {
					alert("Information",e)
					$('.modal').modal("hide");	
				});
			}
		} else if(opt == "Swap") {
			let swapDate = $('#sevaDate').html();
			url = "<?=site_url(); ?>TrustAuction/updateSareeDate"
			$.post(url,{'itemId':itemId,'sareeType':sareeType,'event_name':eventName,'sevadate':currentDate,'swapDate':swapDate,'refno':$('#refno').html().trim()}, function(e) {
				alert("Information",e)
				$('.modal').modal("hide");
			});
		}
	});
	
	function editOption(itemId1, sareeType1, eventName1, currentDate1, currentRefNo1, event) {
		let currentDate12 = currentDate1.split("-");
		
		let day = currentDate12[0];
		let month = currentDate12[1];
		let year = currentDate12[2];
		
		let date = new Date(Number(year),(Number(month)-1),Number(day));
		let date2 = new Date(Number("<?=date('Y')?>"),(Number("<?=date('m')?>")-1),Number("<?=date('d')?>"));
		
		if(date < date2) {
			event.preventDefault();
			alert("Information", "Edit option is not available for this date");
			return false;
		}
			
		itemId = itemId1;
		sareeType = sareeType1;
		eventName = eventName1;
		currentDate = currentDate1;
		currentRefNo = currentRefNo1;
		
		$('.alreadyExist').css('visibility','hidden');
		
		if(sareeType == "1") {
			$('.modal').modal();
			$('#submit').html("Check Availability");
		} else if(sareeType == "2") {
			$('.modal').modal();
			$('#submit').html("Save");	
		} else {
			return false;
		}
	}

	//FOR DATEFIELD
	var currentTime = new Date()
	var fromDate = "<?=$events[0]->TET_FROM_DATE_TIME; ?>";
	var toDate = "<?=$events[0]->TET_TO_DATE_TIME; ?>"; 
	fromDate = fromDate.split("-");
	toDate = toDate.split("-");
	var minDate = new Date(Number(fromDate[2]), (Number(fromDate[1])-1), +(Number(fromDate[0]))); 
	var maxDate =  new Date(Number(toDate[2]), (Number(toDate[1])-1), + Number(toDate[0]));
	
	$( ".todayDate" ).datepicker({ 
		//maxDate: maxDate,
		minDate: minDate,
		changeYear: true,
		changeMonth: true,
		'yearRange': "2007:+50",
		dateFormat: 'dd-mm-yy'
    });
     
	$('.todayDateBtn').on('click', function() {
		$( ".todayDate" ).focus();
	});
	
	//CREATE Print
	function print() {
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
		let url = "<?php echo site_url(); ?>generatePDF/create_trustAuctionItemSession";
		$.post(url,{'date':$('#todayDate').val()}, function(data) {
			let url2 = "<?php echo site_url(); ?>generatePDF/create_trustAuctionItemPrint";
			if(data == 1) {
				downloadClicked = 0;
				var win = window.open(
				  url2,
				  '_blank'
				);
				
				setTimeout(function(){ win.print();}, 1000); //setTimeout(function(){ win.close();}, 5000);
			}
		})
	}
	
	//CREATE PDF
	function generatePDF() {
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
		document.getElementById('tdate').value = $('#todayDate').val();
		url = "<?php echo site_url(); ?>generatePDF/create_trustAuctionItemPDF";
		$("#tddate").attr("action",url)
		$("#tddate").submit();
	}
	
	//CREATE EXCEL
	function GetSendField() {
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
		document.getElementById('tdate').value = $('#todayDate').val();
		url = "<?php echo site_url(); ?>TrustReport/event_auction_report_excel";
		$("#tddate").attr("action",url)
		$("#tddate").submit();
	}
	
	//ON CHANGE OF DATEFIELD
	function get_datefield_change(date) {
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
		document.getElementById('tdate').value = date;
		url = "<?php echo site_url(); ?>TrustReport/get_change_datefield";
		$("#tddate").attr("action",url)
		$("#tddate").submit();
	}
</script>
