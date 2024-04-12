<?php error_reporting(0); ?>
<div class="container">
<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />

<div class="row form-group">							
	<div class="col-lg-12 col-md-12 col-sm-8 col-xs-8" style = "padding-right:0px;padding-top:10px;">
			<h3 style="margin-top:0px">Bank Cheque Configuration</h3>
	</div>
</div>

<div class="col-lg-12 col-md-12 col-sm-8 col-xs-8 pull-right text-right" style = "padding-right:0px;padding-bottom:10px;padding-top:10px; margin-top:-4em">
	<a style="margin-left: 9px;pull-right;" href="<?=site_url()?>Trustfinance/Ledger" title="Add Bank Details"><img style="width:24px; height:24px" src="<?=site_url();?>images/add_icon.svg"/></a>
	<a style="margin-left: 5px;text-decoration:none;cursor:pointer;pull-right;" href="<?=site_url()?>Trustfinance/chequeConfiguartion" title="Refresh"><img style="width:24px; height:24px" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
</div>

<div class="row form-group">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
				  <tr>
					<th width="30%"><center>Bank Name</center></th>
					<th width="20%"><center>Account Number</center></th>
					<th width="10%"><center>IFSC Code</center></th>
					<th width="15%"><center>Branch</center></th>
					<th width="10%"><center>Location</center></th>
					<th width="20%"><center>Curr. Cheque Books</center></th>
				  </tr>
				</thead>
				<tbody>
					<?php foreach($chequeConfiguartion as $result) { ?>
						<tr>
							<td><a style="text-decoration:none;cursor:pointer;color:#800000;" onClick="chequeDetail('<?=$result->T_FGLH_ID; ?>','<?php echo str_replace("'","\'",$result->T_BANK_NAME);?>','<?php echo str_replace("'","\'",$result->T_FGLH_NAME);?>')"><?php echo $result->T_FGLH_NAME; ?></a></td> 
							<td><center><?php echo $result->T_ACCOUNT_NO; ?></center></td>
							<td><?php echo $result->T_BANK_IFSC_CODE; ?></td>
							<td><?php echo $result->T_BANK_BRANCH; ?></td>
							<td><?php echo $result->T_BANK_LOCATION; ?></td>
							<td><center><?php echo $result->CurrChequeBooks ?></center></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	
	</div>
	 <div class= "row">
		<ul class="pagination pagination-sm" style="margin-left:30px;margin-top: 0.2em;">
			<?=$pages; ?>
		</ul>
		<!--Total Bank TextField -->
		<?php if($bankCount != 0) { ?>
		<label class="pull-right"  style="font-size:18px;margin-right:30px;margin-top:0.1em;">Total Banks: <strong style="font-size:18px"><?php echo $bankCount ?></strong></label>
		<?php } else { ?>
		<label> </label>
		<?php } ?>					
	</div>
</div>
</div>

<form id="chequeConfigForm" action="" method="post">
	<input type="hidden" id="T_FGLH_ID" name="T_FGLH_ID" />
	<input type="hidden" id="BANK_NAME" name="BANK_NAME" />
	<input type="hidden" id="T_FGLH_NAME" name="T_FGLH_NAME" />
</form>

<script>
	function chequeDetail(T_FGLH_ID,T_BANK_NAME,T_FGLH_NAME){
		$('#T_FGLH_ID').val(T_FGLH_ID);
		$('#BANK_NAME').val(T_BANK_NAME);
		$('#T_FGLH_NAME').val(T_FGLH_NAME);
		$('#chequeConfigForm').attr('action','<?=site_url()?>Trustfinance/chequeDetails');
		$('#chequeConfigForm').submit();
	}
	
</script>