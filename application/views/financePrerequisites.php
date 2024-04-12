<div class="container-fluid container">
	<form id="frmprerequisites" action="<?=site_url()?>finance/save_finance_prerequisites" method="post" enctype="multipart/form-data"
		accept-charset="utf-8">
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
									<div class="col-md-10 col-lg-10 col-sm-10 col-xs-10 no-pad">
										<h3>Finance Prequisites</h3>
									</div>
								</div>
								<div class="body-inner no-padding ">
									<div class="row">
										<div class="col-md-3 col-lg-3 col-sm-3 col-xs-12 no-pad">
											<label >Financial Year Beginning From :</label>
										</div>
										<div class="col-md-2 col-lg-2 col-sm-2 col-xs-12 ">
											
											<div class="input-group input-group-sm">
												<input type="hidden" name="date" value="<?=@$date; ?>" id="date" value="" ><!-- if($result->DUC_DEBIT != Null) echo date('d-m-Y',strtotime($result->DUC_EOD_DATE)); else echo "-"; -->
												<input type="hidden" name="load" id="load" value="">
												<input autocomplete="" name= "todayDate" id="todayDate" type="text" value="<?php echo $fyear->FP_FIN_BEGIN_DATE;  ?>" class="form-control todayDate2"  onchange="GetDataOnDate(this.value)" placeholder="dd-mm-yyyy" readonly = "readonly" />
												<div class="input-group-btn">
													<button class="btn btn-default todayDate" type="button">
														<i class="glyphicon glyphicon-calendar"></i>
													</button>
												</div>
											</div>
										
										</div>
									</div></br>

									<div class="row">
										<div class="col-md-3 col-lg-3 col-sm-3 col-xs-12 no-pad">
											<label >Financial Book Beginning From :</label>
										</div>
										<div class="col-md-2 col-lg-2 col-sm-2 col-xs-12 ">
											<div class="input-group input-group-sm">
												<input type="hidden" name="date" value="<?=@$date1; ?>" id="date1" value="" >
												<input type="hidden" name="load" id="load1" value="">
												<input autocomplete="" name= "toDate" id="toDate" type="text" value="<?php echo $fyear->FP_BOOKS_BEGIN_DATE;?>" class="form-control todayDate3"  onchange="GetDataOnDate1(this.value)" placeholder="dd-mm-yyyy" readonly = "readonly" />
												<div class="input-group-btn">
													<button class="btn btn-default toDate" type="button">
														<i class="glyphicon glyphicon-calendar"></i>
													</button>
												</div>
											</div>
										</div>
									</div>
								</div></br>

							</section>
						</div>
						<div class="row form-group">
							<div class="control-group col-md-6 col-lg-6 col-sm-6 col-xs-12 text-left">
								<?php  if($user == 26){ ?> <input type="button" class="btn btn-default btn-md custom" value="Submit" onclick="validateFinancePrerequisites()"> <?php }?>
              					
              					<input type="button" class="btn btn-default btn-md custom" value="Cancel" onclick="golist('Sevas');">
							</div>
						</div>
					</div>
				</div>
			</div>

		</section>
	</form>
</div>
<div class="modal fade" id="prerequisitesModal">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-body">
				<h5>Are You Sure ?</h5>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn " onclick="document.getElementById('frmprerequisites').submit();">Yes</button>
				<button type="button" class="btn " data-dismiss="modal">No</button>
			</div>
		</div>
	</div>
</div> 
<script>
	function validateFinancePrerequisites() {
		let todayDate = $('#todayDate').val();
		let toDate = $('#toDate').val();
		let url = "<?=site_url()?>finance/save_finance_prerequisites";
		if( todayDate == "" || toDate == "") {
			alert("Please Fill Required Fields");
			return;
		} 
		$("#prerequisitesModal").modal(); 
	}

	function golist(url){
		location.href = "<?php echo site_url();?>"+url;
	}

	function GetDataOnDate() {
        // document.getElementById('date').value = receiptDate;
        document.getElementById('load').value = "DateChange";
        // $("#frmReceipt").attr("action",url);
    }

    function GetDataOnDate1() {
        // document.getElementById('date1').value = receiptDate;
        document.getElementById('load1').value = "DateChange";
        // $("#frmReceipt").attr("action",url);
    }


    var currentTime = new Date()
    var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
     var maxDate =  new Date(); // one day before next month
     $( ".todayDate2" ).datepicker({ 
        // minDate: minDate, 
        // maxDate: maxDate,
        'yearRange': "2007:+50",
        dateFormat: 'dd-mm-yy',
        changeMonth:true,
        changeYear:true
    });

     $('.todayDate').on('click', function() {
     	$( ".todayDate2" ).focus();
     })

    $( ".todayDate3" ).datepicker({ 
        // minDate: minDate, 
        // maxDate: maxDate,
        'yearRange': "2007:+50",
        dateFormat: 'dd-mm-yy',
        changeMonth:true,
        changeYear:true
    });

     $('.toDate').on('click', function() {
     	$( ".todayDate3" ).focus();
     })
 </script>