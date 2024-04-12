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
								<h3>Deity</h3>
							</div>
						</div>
						<div class="body-inner no-padding table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th style="width:90%;"><strong>Receipt No</strong></th>
										<th style="width:10%;"><strong>Print Count</strong></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($print_deity as $result) { ?>
										<tr class="row1">
											<td><a style="color:#800000;" onclick="show_deity('<?php echo $result->RECEIPT_ID; ?>')"><?php echo $result->RECEIPT_NO; ?></a></td>
											<td><?php echo $result->PRINT_COUNT; ?></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
						<ul class="pagination pagination-sm">
							<?=$pages; ?>
						</ul>
					</section>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Deity Modal -->
<div id="myModalDeity" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content" style="padding-bottom:1em;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Print Details</h4>
			</div>
			<div class="modal-body" id="deitydet" style="overflow-y: auto;max-height: 330px;">
			</div>
		</div>
	</div>
</div> 
<script>
	function show_deity(id){
		var c_url ="<?php echo site_url(); ?>admin_settings/Admin_setting/ViewDeity";
		$.ajax({
			url: c_url,
			data: {'id':id},          
			type: 'post', 
			success: function(data){  
				$('#deitydet').html(data);
				$('#myModalDeity').modal('show');   
			},
			error: function(data) {
				alert("Error Occured!");
			}
		});         
	}
</script>