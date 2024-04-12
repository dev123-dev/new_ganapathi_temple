<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<div class="row form-group">
		<div class="col-lg-6 col-md-4 col-sm-2 col-xs-12 marginTop">
			<span class="eventsFont2">Auction Receipt</span>
		</div>
		<form enctype="multipart/form-data" method="post" accept-charset="utf-8" action="<?=site_url();?>TrustAuction/SearchAuctionReceipt">
			<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
				<div class="input-group input-group-sm">
					<input autocomplete="" type="text" id="searchName" name="searchName" onKeyDown="GetSearch('Name')" value="<?php echo $name; ?>" class="form-control" placeholder="Name">
					<div class="input-group-btn">
					  <button class="btn btn-default name_phone" type="submit">
						<i class="glyphicon glyphicon-search"></i>
					  </button>
					</div>
				</div>
			</div>
			
			<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
				<div class="input-group input-group-sm">
					<input autocomplete="" type="text" id="searchBidNo" name="searchBidNo" onKeyDown="GetSearch('BidNo')" value="<?php echo $bidNo; ?>" class="form-control" placeholder="Bid Ref. No.">
					<div class="input-group-btn">
					  <button class="btn btn-default name_phone" type="submit">
						<i class="glyphicon glyphicon-search"></i>
					  </button>
					</div>
				</div>
			</div>
		</form>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-right">
			<a style="width:24px; height:24px" class="pull-right img-responsive" href="<?=site_url()?>TrustAuction/issue_auction" title="Refresh"><img title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
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
							<th style="width:10%;">Bid Ref. No.</th>
							<th style="width:10%;">Item Ref. No.</th>
							<th>Item Details</th>
							<th>Bidder Details</th>
							<th>Bid Price</th>
							<th style="width:20%;">Issue/Print Receipt</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($bid_item_list as $result) { ?>
							<tr>
								<td><?php echo $result->BID_REF_NO;  ?></td>
								<td><?php echo $result->ITEM_REF_NO;  ?></td>
								<td><?php echo $result->BIL_ITEM_DETAILS; ?></td>
								<td><a class="log mymodelcancel" style="color:#800000;" onclick="show_bid('<?php echo $result->BIL_NAME ; ?>','<?php echo $result->BIL_NUMBER; ?>','<?php echo $result->BIL_EMAIL; ?>','<?php echo str_replace(PHP_EOL,' ',$result->BIL_ADDRESS); ?>')"><?php echo $result->BIL_NAME; ?></a></td>
								<td><?php echo $result->BIL_BID_PRICE; ?></td>
								<?php 
									$i = 0; 
									$receiptNo = "";
									$receiptId = "";
									foreach($auction_receipt as $res) {
										if($result->BIL_ID == $res->BIL_ID) {
											$receiptId = $res->AR_ID;
											$receiptNo = $res->AR_RECEIPT_NO;
											$i = 1;
											break;
										} else {
											$i = 0;
										}
									}
								?>
								<?php if($i == 1) { ?>
									<td><a style="color:#800000;" href="<?php echo site_url(); ?>TrustAuction/issue_receipt_print/<?php echo $receiptId; ?>"><?php echo $receiptNo; ?></a></td>
								<?php } else { ?>
									<td><a style="color:#800000;" href="<?php echo site_url(); ?>TrustAuction/issue_auction_receipt/<?php echo $result->BIL_ID; ?>"><?php echo "Issue Receipt" ?></a></td>
								<?php } ?>
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

<!-- Bidder Details Modal2 -->
<div id="myModalBidder" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content" style="padding-bottom:1em;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" style="margin-top:-14px;">&times;</button>
				<h4 class="modal-title">Bidder Details</h4>
			</div>
			<div class="modal-body" id="bidderdet" style="overflow-y: auto;max-height: 330px;">
			</div>
		</div>
	</div>
</div>
<script>
	function GetSearch(search) {
		if(search == "Name") {
			$('#searchBidNo').val("");
		} else if(search == "BidNo") {
			$('#searchName').val("");
		}
	}
	
	function show_bid(name,number,email,address){
        var c_url ="<?php echo site_url(); ?>TrustAuction/View";
        $.ajax({
			url: c_url,
			data: {'name':name,'number':number,'email':email,'address':address},          
			type: 'post', 
			success: function(data){ 			
				$('#bidderdet').html(data);
				$('#myModalBidder').modal('show');  
			},
			error: function(data) {
				alert("Error Occured!");
			}
		});         
    }
</script> 