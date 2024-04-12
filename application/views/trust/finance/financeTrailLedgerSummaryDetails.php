<div class="container">
<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />


	<div class="row form-group">							
		<div class="col-lg-12 col-md-12 col-sm-8 col-xs-8" style = "padding-right:0px;padding-top:10px;">
			<h3 style="margin-top:0px">Ledger Summary of <?php echo $FGLH_NAME ?></h3>
		</div>
	</div>

	<div class="col-lg-12 col-md-12 col-sm-8 col-xs-8 pull-right text-right" style = "padding-right:0px;padding-bottom:10px;padding-top:10px; margin-top:-4em">
		<a  style="margin-left: 5px;  "class="pull-right" style="border:none; outline:0;"  title="Back" onclick="backTosameDate()" ><img style="border:none; outline: 0; width:24px; height:24px" src="<?php echo base_url();?>images/back_icon.svg"></a>
		<form action="<?=site_url()?>Trustfinance/displayTrialBalance" id="backtoTbSheet" method="post">
			<input type="hidden" name="fromTB" value="<?php echo $firstFrom ?>">
			<input type="hidden" name="toTB" value="<?php echo $to ?>">
		</form>
	</div>

	<div class="row form-group">							
		<div class="col-lg-12 col-md-12 col-sm-8 col-xs-8" style = "padding-right:0px;padding-top:10px;">
			<h3 style="margin-top:0px">Opening Balance as on <?php echo $firstFrom ?>: <?php echo abs($Closing)?></h3>
		</div>
	</div>

	<div class="row form-group" style="border:2px solid #800000; >
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				
			<!-- new code added by adithya start -->
<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12 " >
				  <section> 
			         <table class="table" style="border:0px;">
							<tr style="border-bottom:2px solid #800000;">
								<h5><center><b>Debit</b><center></h5>
								<th width="10%">Date</th>
								<th width="10%">PARTICULARS</th>
								<th width="10%">Amount</th>
								<!-- <th width ="10%">Closing</th> -->
							</tr>
							<?php
							    $DrTotal = 0;
							    foreach($breakupDetail as $result) { if($result->T_FLT_DR > 0) { 
							    $DrTotal +=$result->T_FLT_DR;
								?> 	
						     <tr>
								<td><?php echo $result->T_FLT_DATE; ?></td>
								<?php if($result->T_RP_TYPE == 'OP'){ ?>
									<td><?php echo $result->FGLH_NAME; ?></td>
								<?php } else { ?>
									<td><?php echo $result->Particular; ?></td>	
								<?php  }?>			
									
								<!-- <td><center><?php echo $result->VOUCHER_TYPE; ?></center></td> -->
								<!-- <td><center><?php echo $result->VOUCHER_NO; ?></center></td> -->
								<!-- <td align="right"><?php echo $opening; ?></td> -->
								<td><?php echo $result->T_FLT_DR; ?></td>
								
								<!-- <td align="right"><?php echo $close; ?></td> -->
								<!-- <td align=""><?php echo ($Closing) + ($result->T_FLT_DR); ?></td> -->
								
							</tr>
							<?php } }?>
						</table> 
					</section> 
				</div>

				<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
					<section> 
						<table class="table" style="border:0px;">
							<tr style="border-bottom:2px solid #800000;">
								<h5><center><b>Credit</b><center></h5>
								<th width="10%">Date</th>
								<th width="10%">PARTICULARS</th>
								<th width="10%">Amount</th>
								<!-- <th width="10%">Closing</th> -->
							</tr>
							<?php
							
							$CrTotal = 0;
							$opening=abs($Closing);
							foreach($breakupDetail as $result) { if($result->T_FLT_CR > 0) { 
								$CrTotal += $result->T_FLT_CR;
								//$close=$opening+$fltdr-$fltcr;
								?> 
									
						   <tr>
								<td><?php echo $result->T_FLT_DATE; ?></td>
								<?php if($result->T_RP_TYPE == 'OP'){ ?>
									<td><?php echo $result->FGLH_NAME; ?></td>
								<?php } else { ?>
									<td><?php echo $result->Particular; ?></td>	
								<?php  }?>			
									
								<!-- <td><center><?php echo $result->VOUCHER_TYPE; ?></center></td> -->
								<!-- <td><center><?php echo $result->VOUCHER_NO; ?></center></td> -->
								<!-- <td align="right"><?php echo $opening; ?></td> -->
								<td ><?php echo $result->T_FLT_CR; ?></td>
								
								<!-- <td align="right"><?php echo $close; ?></td> -->
								<!-- <td align=""><?php echo ($Closing) + ($result->T_FLT_CR); ?></td> -->
								
						  </tr>



							<?php } }?>

						</table> 
					</section>
				</div>
		   </div>

		   <div class="row">
				<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
					<section> 
						<table class="table"  >
							<tr style='border-top:2px solid#800000;padding:50px;'>
								<th width="60%"><h6><b>Total:</b></h6></th> 
								<?php  $receipt_tot= $DrTotal?>
								<th width="20%"><?php echo "<h6><center><b>".$receipt_tot."</b><center></h6>";?></th> 
								<th></th>
							</tr>

						</table> 
					</section> 
				</div>

				<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
					<section> 
						<table class="table"  >
							<tr style='border-top:2px solid#800000;padding:50px;'>
								<th width="60%"><h6><b>Total:</b></h6></th> 
								<?php  $payment_tot=$CrTotal;?>
								<th width="20%" ><?php echo "<h6><center><b>".$payment_tot."</b><center></h6>";?></th> 
								<th></th>
							</tr>

						</table> 
					</section> 
				</div>
			</div>
<!-- new code added by adithya end -->

			</div>
			<!-- <div class="pull-right" style="padding-right:0px;">
				<?php if($breakupCount != 0) { ?>
					 <label  style="font-size:18px;margin-top:-5em;">Total Records: <strong style="font-size:18px"><?php echo $breakupCount; ?></strong></label> 
				<?php } else { ?>
					<label> </label>
				<?php } ?>
			</div> 
		 	<ul class="pagination pagination-sm" style="margin-top: 1px">
				<?=$pages; ?>
			</ul>  -->
		</div>
	</div>
</div>
<script type="text/javascript">	
	function backTosameDate(){
		$('#backtoTbSheet').submit();
	}
</script>