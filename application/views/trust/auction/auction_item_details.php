
<div class="container">
	<form class="form-group" action="<?=site_url()?>TrustAuction/add_auction_item">
		<div class="form-group">
			<center><label class="eventsFont2 samFont1">Sri Sharada Mahostava Samithi</label></center>
			<?php if(@$fromAllReceipt == "1") { ?>
				<a class="pull-right" style="border:none; outline:0;" href="<?=$_SESSION['actual_link'] ?>" title="Back"><img style="border:none; outline: 0;margin-top: -71px;" src="<?php echo base_url(); ?>images/back_icon.svg"></a>
			<?php } else { ?>
				<a class="pull-right" style="border:none; outline:0;" href="<?=site_url() ?>TrustAuction/add_auction_item_list" title="Back"><img style="border:none; outline: 0;margin-top: -71px;" src="<?php echo base_url(); ?>images/back_icon.svg"></a>
			<?php } ?>
		</div>
		
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="form-group">
				<span class="eventsFont2">Item Reference No: <?=$refNo; ?></span>
			</div><br/><br/>
		  
			<div class="form-group">
				<label for="name" style="font-size:18px;"><strong>Name: </label></strong>
				<span style="font-size:16px;" class=""> <?=$name; ?></span>
			</div>
		  
			<div class="form-group">
				<label for="number" style="font-size:18px;"><strong>Number: </label></strong>
				<span style="font-size:16px;" class=""> <?=$number; ?></span>
			</div>
		  
		  <?php if($email): ?>
			<div class="form-group">
				<label for="email" style="font-size:18px;"><strong>Email: </label></strong>
				<span style="font-size:16px;" class=""> <?=$email; ?></span>
			</div>
		  <?php endif; ?>
		   <?php if($address): ?>
			<div class="form-group">
				<label for="address" style="font-size:18px;"><strong>Address: </label></strong>
				<span style="font-size:16px;" class=""> <?=$address; ?></span>
			</div>
			<?php endif; ?>
		</div>
		    
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<br/><br/><br/><br/>
			 <?php if($item[1]): ?>
			<div class="form-group text-right">
				<label for="item" style="font-size:18px;"><strong>Item: </label></strong>
				<span style="font-size:16px;" class=""> <?=$item[1]; ?></span>
			</div>
			<?php endif; ?>
			 <?php if($itemDetails): ?>
			<div class="form-group text-right">
				<label for="itemDetails" style="font-size:18px;"><strong>Item Details: </label></strong>
				<span style="font-size:16px;" class=""> <?=$itemDetails; ?></span>
			</div>
			<?php endif; ?>
			<?php if($AI_ID == 2) { ?>
				<div class="form-group text-right">
					<label for="SareeFor" style="font-size:18px;"><strong>Saree For: </label></strong>
					<span style="font-size:16px;" class=""> 
					<?=$AIC_NAME;
					?></span>
				</div>
				
				<div class="form-group text-right">
					<label for="sevaDate" style="font-size:18px;"><strong>Seva Date: </label></strong>
					<span style="font-size:16px;" class=""> <?=$sevadate; ?></span>
				</div>
			<?php } ?>
		</div>
		  
		<!-- <div style="clear:both;" class="form-group">
			<center><button type="submit" id="print" class="btn btn-default btn-lg">Add Auction Item</button></center>
		</div> -->
	</form>
</div>