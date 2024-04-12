<div id="printScreen" style="display:none;">
	<page style="margin-top:25px;margin-left:75%;width:115%;margin-right:75%;" data-size="A6">
		<form>
			<center style="margin-top:45px;"><span class="eventsFont2 " style="font-size:14px;font-family:switzerland"><strong>
			<?=$event['ET_NAME']; ?>
			</strong></span></center><br/>
			<center class="eventsFont2" style="font-size:14px;margin-top:-6px;font-family:switzerland"><strong>
			<?=$templename[0]["TEMPLE_NAME"]?>
			</strong></center>
			<div style="margin-top:50px;"></div>
			<span style="font-size:11px;letter-spacing:1px;display:none;" class="eventsFont2" id="duplicate"><center><strong>Duplicate Receipt</strong></center></span>
			<div style="margin-bottom:6px;"></div>
			<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Bid Reference No&nbsp;: </strong><strong><?=@$bidRefNo; ?></strong></span>
			<div style="margin-bottom:6px;"></div>
			<span style="font-size:11px;letter-spacing:1px;"><strong>Name&nbsp;&nbsp;&nbsp;&thinsp;: <?=$name; ?></strong></span><br/>
			<span style="font-size:11px;letter-spacing:1px;"><strong>Number&nbsp;: </strong><?=$phone; ?></span><br/>
			<span style="font-size:11px;letter-spacing:1px;"><strong>Email&nbsp;&nbsp;&nbsp;&nbsp;&thinsp;: </strong><?=$email; ?></span><br/>
			<span style="font-size:11px;letter-spacing:1px;"><strong>Address&nbsp;: </strong><?=$address; ?></span><br/>
			<div style="margin-bottom:6px;"></div>
			<span style="font-size:11px;letter-spacing:1px;"><strong>Item&nbsp;&nbsp;&nbsp;&thinsp;&nbsp;&nbsp;&nbsp;: </strong><?=$item; ?></span><br/>
			<span style="font-size:11px;letter-spacing:1px;"><strong>Item Details&nbsp;: </strong><?=$itemDet; ?></span><br/>
			<div style="margin-bottom:6px;"></div>
			<span style="font-size:11px;letter-spacing:1px;"><strong>Bid Price&nbsp;: Rs. <?=$bidPrice; ?>/- <?=AmountInWords($bidPrice);?></strong></span><br/><br/>
			<span id="issuedBy" style="font-size:11px;float:right;letter-spacing:1px;"><strong>Issued By&nbsp;: </strong><?=$issuedBy[0]->USER_FULL_NAME; ?></span><br/>
			<center style="clear:both;font-size: 20px;letter-spacing:1px;">*************************</center><br/><br/>
		</form>
	</page>
</div>
<div class="container">
	<div class="row form-group">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div style="text-align:center;" class="col-lg-12 col-md-12  col-sm-12 col-xs-12">
                <span class="eventsFont2">Bid Auction Item Details</span>
            </div>
        </div>
	</div>

	<div class="row form-group">
		<div class="col-md-6 text-left">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <span class="eventsFont2">Bid Reference No:<?=@$bidRefNo;?></span>
            </div><br/><br/>
		
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
				<label for="number" style="font-size:18px;"><strong>Item:</label></strong>
				<span class=""> <?=$item; ?></span>
			</div>
				
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<label for="number" style="font-size:18px;"><strong>Item Reference No:</label></strong>
				<span class=""> <?=$itemRef; ?></span>
			</div>
			
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="number" style="font-size:18px;"><strong>Item Details: </label></strong>
					<span class=""> <?=$itemDet; ?></span>
                </div>
            </div>
		</div>
		
		<div class="col-md-6 text-right">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<label for="number">Event: </label>
				<span class="eventsFont2 samFont"> <?=$event['ET_NAME']; ?></span>
			</div><br/><br/>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="form-inline">
					<label for="name" style="font-size:18px;"><strong>Name:</strong>
					</label>
					<span class=""> <?=$name; ?></span>
				</div>
			</div>
			
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="form-inline">
					<label for="name" style="font-size:18px;"><strong>Number:</strong>
					</label>
					<span class=""> <?=$phone; ?></span>
				</div>
			</div>
			
			<?php if(@$email != "") { ?>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="form-inline">
						<label for="name" style="font-size:18px;"><strong>Email:</strong>
						</label><span class=""> <?=$email; ?></span>
					</div>
				</div>
			<?php } ?>
			
			<?php if(@$address != "") { ?> 
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-inline">
                    <label for="number" style="font-size:18px;"><strong>Address: </strong></label>
                    </label><span class=""> <?=$address; ?></span>
                </div>
            </div>
			<?php } ?>
			
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-inline">
                    <label for="name" style="font-size:18px;"><strong>Bid Price:</strong>
                    </label>
                    <span class=""> <?=$bidPrice; ?></span>
                </div>
            </div>
		</div>
    </div>
	<div style="clear:both;" class="form-group">
			<center><button type="button" id="print" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-print"></span> Print</button></center>
	</div>
</div>
<iframe style="width:76mm;height:1px;visibility:hidden;" id="printing-frame" name="print_frame" src="about:blank"></iframe>
<script>
	if('<?php echo $printStatus->PRINT_STATUS ?>' == 1) {
		$('#duplicate').show();
		$('#print').html(" Re-Print Receipt");
	}
	
	var duplicate = 0;
	var print = function() {
		var newWin = window.frames["print_frame"]; 
		newWin.document.write('<html><head><link href="<?php echo  base_url(); ?>css/print.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/quickSand.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/fonts.googleapis.css" rel="stylesheet" type="text/css"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" crossorigin="anonymous"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-theme.min.css" crossorigin="anonymous"><link href="<?php echo  base_url(); ?>css/jquery-ui.theme.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.structure.min.css" rel="stylesheet"</head>' + '<body onload="window.print()" style="min-height:90%;">'+ $('#printScreen').html() +'</body></html>');
		newWin.document.close();
	}
	
	$('#print').on('click',function() {
		let url = "<?=site_url(); ?>Auction/bid_auction_preview"
		$.post(url,{'bidRefNoView':'<?=@$bidRefNo; ?>'})
		if(duplicate == 1){
			$('#duplicate').show();
			$('#print').html(" Re-Print Receipt");
		}
		print();
		$('#print').html(" Re-Print Receipt");
		duplicate++;
	});
</script>