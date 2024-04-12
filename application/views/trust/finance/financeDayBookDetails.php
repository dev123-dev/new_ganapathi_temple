<style>
	input::-webkit-inner-spin-button {
		-webkit-appearance: none;
		margin: 0;

	}
	.new
	{	
		border:none;
		border-radius: 0px;
		border-bottom: 1px solid #800000;
		font-size: 20px;
	}
	.heading
	{
		font-size: 15px;
	}
</style>
<?php error_reporting(0); ?>
<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />

	<div class="row form-group">							
		<div class="col-lg-12 col-md-12 col-sm-8 col-xs-8" style = "padding-right:0px;padding-top:10px;">
			<h3 style="margin-top:0px"><b><?php echo $voucherType ?> Voucher Details  </b> </h3>
		</div>
	</div>

	<div class="col-lg-12 col-md-12 col-sm-8 col-xs-8 pull-right text-right" style = "padding-right:0px;padding-bottom:10px;padding-top:10px; margin-top:-4em">
		<!-- <a style="text-decoration:none;cursor:pointer;pull-right; margin-left: 5px;" href="<?=site_url()?>finance/dayBookDetail" title="Refresh"><img style="width:24px; height:24px" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a> -->
		<a  style="margin-left: 5px;  "class="pull-right" style="border:none; outline:0;"  title="Back"  href="<?php echo $base_url ?>" ><img style="border:none; outline: 0; width:24px; height:24px" src="<?php echo base_url();?>images/back_icon.svg"></a>
	</div>

	  <div class="row form-group">
                <div class="control-group col-md-6 col-lg-10 col-sm-4 col-xs-6">               
                	<label style="margin-left: 10px"><h5>Voucher Number : <?php echo $VOUCHER_NO;?></label>
                </div>

                <div class="control-group col-lg-2 col-md-3 col-sm-4 col-xs-6 ">      
                	<label><h5>Date : <?php echo $FLT_DATE;?></label>
                </div>

                 <?php if($chequeno != '') { ?> 
	                 <div class="control-group col-lg-2 col-md-3 col-sm-4 col-xs-6 ">      
	                	<label style="margin-left: 10px"><h5>Cheque No:<?php echo $chequeno ?></label>
	                </div>
                <?php } else { ?>

                	<?php } ?>
       </div>
	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th width="10%"><center>Account/Particular</center></th>
							<th width="8%"><center>Debit Amount</center></th>
							<th width="8%"><center>Credit Amount</center></th>
						</tr>
					</thead>
				<tbody>
						<?php foreach($dayBookDetail as $result) {  ?>
							<tr>
								<?php if($result->Account == 'From:') { ?> 
									<td><?php echo  $result->Account . '&nbsp;&nbsp;&nbsp;&nbsp;' . $result->T_FGLH_NAME;  ?></td>
									<input type="hidden" name="fromfghlh" id="fromfghlh" value="<?php echo $result->T_FGLH_NAME; ?>">
								<?php } else { ?>
									<td><?php echo $result->Account . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $result->T_FGLH_NAME;  ?></td>
									<input type="hidden" name="tofghlh" id="tofghlh" value="<?php echo $result->T_FGLH_NAME; ?>">
								<?php } ?>
								<td align="right"></style><?php echo $result->T_FLT_DR; ?></td>
								<td align="right"><?php echo $result->T_FLT_CR; ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>

			<label for="comment">Narration </label>
    		<textarea class="form-control" rows="5" name="naration" id="naration" placeholder="" style="width:70%;height:100%;resize:none;" readonly ><?php echo $naration ?></textarea><br/>
    		<div style="clear:both;" class="form-group">
	    		<button style="width:10%;font-weight: bold;" type="button" id="print" onClick="printdayBookDetail('<?=$result->FGLH_ID; ?>','<?php echo str_replace("'","\'",$result->FGLH_NAME);?>','<?=$result->VOUCHER_NO; ?>','<?=$result->VOUCHER_TYPE; ?>','<?=$result->FLT_DATE; ?>','<?=$chequeno; ?>','<?=$result->FLT_DR; ?>','<?=$naration; ?>','<?=$FLT_DATE; ?>','<?=$result->FLT_CR; ?>','<?=$chequedate; ?>','<?=$result->PAYMENT_METHOD; ?>')" class="btn btn-default"> <span class="glyphicon glyphicon-print"></span> Print</button>

				<?php if(($this->session->userdata('userGroup') == 1 || $this->session->userdata('userGroup') == 6) && $dayBookDetail[0]->RECEIPT_ID==0 && !($dayBookDetail[0]->RP_TYPE=="C1" && $dayBookDetail[0]->FGLH_ID == 21) && $dayBookDetail[0]->RP_TYPE!="OP" && $dayBookDetail[0]->TRANSACTION_STATUS != "Cancelled") { ?>
	    			<button style="font-weight: bold;float: right;" type="button" id="print" onClick="cancelTransaction('<?=$result->T_VOUCHER_NO; ?>','<?=$result->T_FLT_DATE; ?>','<?=$result->T_CHEQUE_NO; ?>','<?=$result->VOUCHER_TYPE ?>')" class="btn btn-default"><span class="glyphicon glyphicon-remove-circle"></span> Cancel Transaction</button>
	    		<?php } ?>
	    	</div>
    </div>
		</div>
	</div>
</div>

<form id="chequeDetailForm" action="" method="post">
	<input type="hidden" id="FCBD_ID" name="FCBD_ID" />
	<input type="hidden" id="CHEQUE_BOOK_NAME" name="CHEQUE_BOOK_NAME" />
</form>

<form id="cancelTransactionForm" action="" method="post">
	<input type="hidden" id="VOUCHER_NO" name="VOUCHER_NO" />
	<input type="hidden" id="FLT_DATE" name="FLT_DATE" />
	<input type="hidden" id="chequeno" name="chequeno" />
	<input type="hidden" id="voucherType" name="voucherType" />
</form>

<script>
	
	function indChequeDetail(FCBD_ID,CHEQUE_BOOK_NAME){
		$('#FCBD_ID').val(FCBD_ID);
		$('#CHEQUE_BOOK_NAME').val(CHEQUE_BOOK_NAME);
		$('#chequeDetailForm').attr('action','<?=site_url()?>Trustfinance/individualChequeDetails');
		$('#chequeDetailForm').submit();
	}	

	function cancelTransaction(VOUCHER_NO,FLT_DATE,chequeno,voucherType){
		$('#VOUCHER_NO').val(VOUCHER_NO);
		$('#FLT_DATE').val(FLT_DATE);
		$('#chequeno').val(chequeno);
		$('#voucherType').val(voucherType);
		$('#cancelTransactionForm').attr('action','<?=site_url()?>Trustfinance/cancelTransaction');
		$('#cancelTransactionForm').submit();
	}

	function printdayBookDetail(FGLH_ID,FGLH_NAME,VOUCHER_NO,VOUCHER_TYPE,FLT_DATE,CHEQUE_NO,FLT_DR,naration,FLT_DATE,FLT_CR,chequedate,PAYMENT_METHOD) {
	
		let VOUCHERTYPE = VOUCHER_TYPE;
	   	let vouchernumber= VOUCHER_NO;
	   	let chkno= CHEQUE_NO;
	   	let narration= naration;
	   	let FLTDATE =FLT_DATE;
	   	let FLT_DR_AMT =FLT_DR;
	   	let FLT_CR_AMT =FLT_CR;
	   	let PAYMENTMETHOD=PAYMENT_METHOD;
	   	let chkdate =chequedate;
	    let tofghlh= $('#tofghlh').val();
	    let fromfghlh=$('#fromfghlh').val();
	   
	    if( VOUCHER_TYPE =='Receipt' || VOUCHER_TYPE =='Journal' || VOUCHER_TYPE =='Contra'){
			let url = "<?php echo site_url(); ?>generatePDF/create_Sessiondaybook";
			$.post(url,{'VOU_CHER_TYPE':VOUCHERTYPE,'FGLH_NAME':FGLH_NAME,'VOUCHER_NUMBER':vouchernumber,'CHEQUE_NO':chkno,'naration':narration,'FLT_DATE':FLTDATE,'FLTDR':FLT_DR_AMT,'TONAME':tofghlh,'FROMNAME':fromfghlh,'chequedate':chkdate}, function(data) {
				let url2 = "<?php echo site_url(); ?>generatePDF/create_Printdaybook";
				if(data == 1) {
						downloadClicked = 0;
					 	var win = window.open(
						  url2,
						  '_blank'
						); 
						setTimeout(function(){ win.print();}, 1000);
					}
			})
		} else if(VOUCHER_TYPE =='Payment') {
			let url = "<?php echo site_url(); ?>generatePDF/create_PaymentSessiondaybook";
			$.post(url,{'VOU_CHER_TYPE':VOUCHERTYPE,'FGLH_NAME':FGLH_NAME,'VOUCHER_NUMBER':vouchernumber,'CHEQUE_NO':chkno,'naration':narration,'FLT_DATE':FLTDATE,'FLT_CR':FLT_CR_AMT,'TONAME':tofghlh,'FROMNAME':fromfghlh,'chequedate':chkdate,'PAYMENT_METHOD':PAYMENTMETHOD}, function(data) {
				let url2 = "<?php echo site_url(); ?>generatePDF/create_PaymentPrintdaybook";
				if(data == 1) {
						downloadClicked = 0;
					 	var win = window.open(
						  url2,
						  '_blank'
						); 
						setTimeout(function(){ win.print();}, 1000);
					}
			})
		} else
            alert("Something went wrong, Please try again after some time");
	}
	

</script>