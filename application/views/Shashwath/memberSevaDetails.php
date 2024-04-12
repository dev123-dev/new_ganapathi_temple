<div class="container">
	<div class="row form-group">
		<div class="col-lg-10 col-md-10 col-sm-10 col-xs-8" style="margin-bottom:0em">
			<span class="eventsFont2">Shashwath Member Seva Details</span>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
				<a class="pull-right" style="border:none; outline:0;" href="<?=site_url()?>Shashwath/shashwath_member" title="Back"><img style="border:none; outline: 0;" src="<?php echo base_url(); ?>images/back_icon.svg"></a>
		</div>
	</div>
	<div class="form-group" style="margin-top:-0.1em">
		<span style="font-size:18px;"><strong>Name: </strong>PRABHAKAR BHAT</span>
	</div>
	<div class="clear:both;table-responsive">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>				
						<th>Sl. No.</th>
						<th>Deity Name</th>
						<th>Seva Name</th>
						<th>Corpus</th>
						<th>Accumulated Loss</th>
				</tr>
			</thead>

			<tbody id="eventUpdate">
				<?php for ($i=1;$i<4;$i++) { ?>
					<tr>
						<td><?php echo $i; ?></td>
						<td>Sri Lakshmi Venkatesha Devaru</td>
						<td>Alankara Pooja</td>
						<td>Rs. <?php echo 5000+$i*1000; ?></td>
						<td style="color:#F00000">Rs. 300</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<div class="container">
	<div class="form-group">
		<span style="float:right" class="eventsFont2">Total Sevas: 3</span>
	</div>
</div>
			

