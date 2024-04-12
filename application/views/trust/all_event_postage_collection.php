<?php 
	//$this->output->enable_profiler(TRUE);
	//print_r("<pre>");
	//print_r($_SESSION);
	//print_r("</pre>");
?>
<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<!--Heading And Refresh Button-->
	<div class="row form-group">
		<div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
			<span class="eventsFont2">All Postage Collection</span>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
			<a style="width:24px; height:24px" class="pull-right img-responsive" href="<?=site_url()?>TrustEventPostage/all_postage_collection" title="Refresh"><img title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
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
							<th style="width: 15%;">Receipt No.</th>
							<th>Name (Phone)</th>
							<th>Post. Amt.</th>
							<th>Post. Actual Amt.</th>
							<th>Company</th>
							<th>Tracking No.</th>
							<th>Label Count</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($allCollection as $result) { ?>
							<tr class="row1">
								<td><?php echo $result->TET_RECEIPT_DATE; ?></td>
								<?php if($result->TET_RECEIPT_PHONE == "") { ?>
									<td><?php echo $result->TET_RECEIPT_NAME; ?></td>
								<?php } else { ?>
									<td><?php echo $result->TET_RECEIPT_NAME." ("; ?><?php echo $result->TET_RECEIPT_PHONE.")"; ?></td>
								<?php } ?>
								<td><?php echo $result->POSTAGE_PRICE; ?></td>
								<td><?php echo $result->REVISED_PRICE; ?></td>
								<td><?php echo $result->POSTAGE_COMPANY; ?></td>
								<td><?php echo $result->POSTAGE_TRACKING; ?></td>
								<td><?php echo $result->LABEL_COUNTER; ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			
			</div>
		</div>
	</div>
	<div class= "row">
		<ul class="pagination pagination-sm" style="margin-left:15px;margin-top:-1em;">
			<?=$pages; ?>
		</ul> 					
	</div> 
</div>