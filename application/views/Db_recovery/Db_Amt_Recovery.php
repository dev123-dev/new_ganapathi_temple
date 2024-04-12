
<div class="container">
	<div class="row form-group">
		
	</div>
</div>

<div class="container">
	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>RECEIPT_ID </th>
							<th>New Rno(SS_Rno) </th>
							
							<th>SS_RECEIPT_DATE</th>
							<th>SM_NAME</th>
							<th>SS_ID</th>
							<th>Old Rno(SS_Rno)</th>
							<th>RECEIPT_PRICE</th>
							<th style="width: 5%;">Operation</th>
						</tr>
					</thead>
					<tbody id="eventUpdate">
						<?php $i = 1; ?>
						<?php foreach($result_query as $result) { ?> 
						<tr>
							<td><?php echo $result->RECEIPT_ID; ?></td>
							<td><?php echo $result->RECEIPT_NO; ?></td>
							
							<td><?php echo $result->SS_RECEIPT_DATE;?></td>
							<td><?php echo $result->SM_NAME; ?></td>
							<td><?php echo $result->SS_ID; ?></td>
							<td><?php echo $result->SS_RECEIPT_NO;?></td>
							<td><!-- <?php echo $result->RECEIPT_PRICE; ?> --><input autocomplete="none" type="text" class="form-control form_contct2" id="Corpus_<?php echo $i ?>" placeholder="" name="name" value=""/></td>
							<td><a style="cursor:pointer;" onclick="addReceiptPrice(<?=$result->RECEIPT_ID; ?>,document.getElementById('Corpus_<?php echo $i?>').value)">Update</a></td>
						</tr>
						<?php $i++; } ?>
					</tbody>
					
				</table>
            	<ul class="pagination pagination-sm">
					<?=$pages; ?>
				</ul>
				<label style="font-size:18px;color:#5b5b5b;margin-top: -0.2px;" class="pull-right">Total Categories: <strong style="font-size:18px">	<?php echo isset($result_query_count) ? $result_query_count : 0?></strong>
				</label>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">	
	function addReceiptPrice(ReceiptId,ReceiptPrice) {
		$.post("<?=site_url()?>Db_recovery/Db_Amt_Recovery_controller/insertPrice", {'ReceiptId': ReceiptId, 'ReceiptPrice': ReceiptPrice}, function (e) {
			e1 = e.split("|");
			if (e1[0] == "success")
				location.href = "<?=site_url();?>Db_recovery/Db_Amt_Recovery_controller/";
			else
				alert("Information","Something went wrong, Please try again after some time","OK");
		});
	}
</script>

