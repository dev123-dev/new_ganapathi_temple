<style>
	.datepicker {
		z-index: 1600 !important; /* has to be larger than 1050 */
		} .chequedate {
			z-index: 1600 !important; /* has to be larger than 1050 */
		}
	</style>
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
								<div class="col-lg-12 col-md-12 col-sm-8 col-xs-8" style = "padding-right:0px;padding-top:10px;">
									<h3 style="margin-top:0px">Shashwath Member smRef Issue</h3>
								</div>
								<div class="col-lg-2 col-md-12 col-sm-8 col-xs-8">
									<form action="<?=site_url();?>Shashwath/updateMemRefDetails" id="updateRefDetail" method="post">
										 <input type="submit" class="btn btn-default " style="cursor: pointer;" value="Submit">
									</form>
								</div>
							</div>
							<div class="col-lg-10 col-md-12 col-sm-8 col-xs-8 pull-right text-right" style = "padding-right:0px;padding-bottom:10px;padding-top:10px; margin-top:-4em">
								<a style="text-decoration:none;cursor:pointer;pull-right; margin-left: 5px;" href="<?=site_url()?>Shashwath/smRefIssue" title="Refresh"><img style="width:24px; height:24px" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
							</div>
							<div class="body-inner no-padding table-responsive">
								<table class="table table-bordered table-hover">
									<thead>
										<tr>
											<th style="width:8%;"><center><strong>Wrong SM_ID</center></strong></th>
											<th style="width:15%;"><center><strong>Wrong SM_REF</center></strong></th>
											<th style="width:10%;"><center><strong>Valid SM_REF</center></strong></th>
											<th style="width:15%;"><center><strong>SS_ID</center></strong></th>
											<th style="width:6%;"><center><strong>Receipt_number</center></strong></th>
											<th style="width:15%;"><center><strong>SS_Receipt_number</center></strong></th>
											<th style="width:15%;"><center><strong>SS_ENTERED_BY_ID</center></strong></th>
											<th style="width:25%;"><center><strong>SS_ENTERED_DATE_TIME</center></strong></th>
											<!-- <th style="width:25%;"><center><strong>Operation</center></strong></th> -->
										</tr>
									</thead>
									<tbody>
										<?php $i = 1;
										foreach($smReferenceIssue as $result) {?>												
											<tr class="row1">
												<td><?php echo $result->SM_REF;?></td>
												<td><?php echo $result->SM_ID; ?></td>				
												<td><?php echo $result->smRefID; ?></td>
												<td><?php echo $result->SS_ID; ?></td>
												<td><?php echo $result->RECEIPT_NO; ?></td>			
												<td><?php echo $result->SS_RECEIPT_NO; ?></td>											
												<td><?php echo $result->SS_ENTERED_BY_ID; ?></td>											
												<td><?php echo $result->SS_ENTERED_DATE_TIME; ?></td>
												<!-- <td><center><a style="text-decoration:none;cursor:pointer;color:#800000;" onClick="updateMembRef('<?=$result->SM_REF; ?>','<?=$result->SM_ID; ?>','<?=$result->smRefID; ?>','<?=$result->SS_ID; ?>','<?=$result->RECEIPT_NO; ?>','<?=$result->SS_RECEIPT_NO; ?>')" ><img style="border:none; outline: 0;" width="24px" height="24px" src="<?php echo base_url(); ?>images/check_icon.svg" /></a></center></td>		 -->
											</tr>
											<?php $i++; }
											?>
									</tbody>
								</table>						
							</div>
						</section>
					</div>
				</div>
			</div>

		</div>
	</section>

<script>
	
</script>