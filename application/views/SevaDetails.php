<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" >
	<div class="row form-group">
		<form action="" id="" enctype="multipart/form-data" method="post" accept-charset="utf-8">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:2.5em">
			<span class="eventsFont2">Shashwath Member Details</span>
		</div>
		<div class="col-lg-12 col-md-12 col-xs-12">
			<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6" style="padding-left:0px;">
				<div class="input-group input-group-sm">
					<input autocomplete="" type="text" id="name_phone" name="name_phone" value="" class="form-control" placeholder="Name / Phone">
					<div class="input-group-btn">
					  <button class="btn btn-default name_phone" type="submit">
						<i class="glyphicon glyphicon-search"></i>
					  </button>
					</div>
				</div>
			</div>
			
			<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
				<div class="input-group input-group-sm">
					<input autocomplete="" type="text" id="city_state" name="city_state" value="" class="form-control" placeholder="City/State">
					<div class="input-group-btn">
					  <button class="btn btn-default name_phone" type="submit">
						<i class="glyphicon glyphicon-search"></i>
					  </button>
					</div>
				</div>
			</div>
			
			<div class="col-lg-1 col-md-2 col-sm-4 col-xs-12 pull-right text-right" style="padding-right:0px;margin-top:.60em;">
				<?php if(isset($_SESSION['Add'])) { ?>
					<a style="margin-left: 9px;pull-right;" href="<?=site_url()?>Shashwath_Seva/addMember" title="New Shashwath Member"><img style="width:24px; height:24px" src="<?=site_url();?>images/add_icon.svg"/></a>
				<?php } ?>
				<a style="text-decoration:none;cursor:pointer;pull-right;" href="<?=site_url()?>Shashwath_Seva/" title="Refresh"><img style="width:24px; height:24px" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
			</div>
		</div>	
		</form>
	</div>
</div>

<div class="container">
	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th width="30%">Name (Phone)</th>
							<th width="20%">Rashi (Nakshatra)</th>
							<th width="10%">Country (City)</th>
							<th width="10%">Thithi Code</th>
							<th width="10%">Corpus Amount</th>
							<th width="5%">Seva Count</th>
							<th width="8%">Status</th>
							<th width="5%">Operation</th>
						</tr>
				</thead>
				<tbody>
				<?php for ($i=0;$i<10;$i++) { ?>
					<tr>
					<td width="30%"><a href="#" style="color:#800000">PRABHAKAR BHAT(8452103582)</a></td>
					<td>Vrishchika (Anuradha)</td>
					<td>India(Udupi)</td>
					<td>PSH0<?php echo $i ?></td>
					<td>Rs. <?php echo $i+5000 ?></td>
					<td><?php echo $i?></td>
					<td>Active</td>
					<td class="text-center" width="5%">
						<a style="border:none; outline: 0;" href="#" title="Edit Member Details"><img style="border:none; outline: 0;" src="<?php echo	base_url(); ?>images/edit_icon.svg"></a>&nbsp;&nbsp;
					</td>
					</tr>
				<?php } ?>
				</tbody>
				</table>
            	<ul class="pagination pagination-sm">
				</ul>
				<div class="pull-right">
			<label style="font-size:18px">Total Members: </label> <strong style="font-size:18px">35</strong>
			</div>
			</div>
		</div>
	</div>
</div>