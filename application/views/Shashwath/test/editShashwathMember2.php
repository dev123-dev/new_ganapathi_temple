<div style="clear:both;" class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<div class="row form-group">
	<div class="row form-group">							
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
			<span class="eventsFont2">Edit Shashwath Member Details</span>
			<a class="pull-right" href="<?=site_url()?>Shashwath/shashwath_member" title="Refresh"><img style="width:24px; height:24px;" title="Refresh" src="<?=site_url();?>images/back_icon.svg"/></a>
		</div>
	</div>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-left:0px;margin-left:-3.3em;margin-top:4em">
		<div id="1" class="w5-container city">
				<div class= "col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class= "col-lg-6 col-md-6 col-sm-12 col-xs-9">
						<div class="form-group">
						  <label for="name">Name <span style="color:#800000;">*</span></label>
						  <input type="text" class="form-control form_contct2" id="name" placeholder="" name="name"/>
						</div>
					</div>
					<div class= "col-lg-6 col-md-6 col-sm-12 col-xs-9">
						<div class="form-group">
						  <label for="number">Number</label>
						  <input type="text" class="form-control form_contct2" id="phone" placeholder="" name="phone" />
						</div>
					</div>
					<div class= "col-lg-6 col-md-6 col-sm-12 col-xs-9" style="padding-top:25px;">
						<div class="form-group">
						  <label for="rashi">Rashi</label>
						  <input type="hidden" id="baseurl" name="baseurl" value="<?php echo site_url(); ?>" />
							<div class="dropdown">
								<input type="text" class="form-control form_contct2" id="rashi" placeholder="" name="rashi">
								<ul class="dropdown-menu txtpin" style="margin-left:0px;margin-right:0px;max-height:400px;" role="menu" aria-labelledby="dropdownMenu"  id="DropdownRashi">
								</ul>
							</div>
						</div>
					</div>
					<div class= "col-lg-6 col-md-6 col-sm-12 col-xs-9" style="padding-top:25px;">
						<div class="form-group">
						  <label for="nakshatra">Nakshatra </label>
						  <input type="hidden" id="baseurl" name="baseurl" value="<?php echo site_url(); ?>" />
							<div class="dropdown">
								<input type="text" class="form-control form_contct2" id="nakshatra" placeholder="" name="nakshatra">
								<ul class="dropdown-menu txtpin1" style="margin-left:0px;margin-right:0px;max-height:400px;" role="menu" aria-labelledby="dropdownMenu"  id="Dropdownnakshatra">
								</ul>
							</div>
						</div>
					</div>
					<div class= "col-lg-6 col-md-6 col-sm-12 col-xs-9" style="padding-top:20px;">
						<div class="form-group">
						  <label for="gotra">Gotra </label>
						  <input type="hidden" id="baseurl" name="baseurl" value="<?php echo site_url(); ?>" />
							<div class="dropdown">
								<input type="text" class="form-control form_contct2" id="gotra" placeholder="" name="Gotra">
								<ul class="dropdown-menu txtpin1" style="margin-left:0px;margin-right:0px;max-height:400px;" role="menu" aria-labelledby="dropdownMenu"  id="Dropdowngotra">
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class= "col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class= "col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-group">
						  <label for="name">Address <span style="color:#800000;">*</span></label>
						  <input type="text" class="form-control form_contct2" id="name" placeholder="Address Line1" name="name"/>
						</div>
					</div>
					<div class= "col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-group">
						  <input type="text" class="form-control form_contct2" id="name" placeholder="Address Line2" name="name"/>
						</div>
					</div>
					<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="form-group">
						  <input type="text" class="form-control form_contct2" id="name" placeholder="City" name="name"/>
						</div>
					</div>
					<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="form-group">
						  <input type="text" class="form-control form_contct2" id="name" placeholder="State" name="name"/>
						</div>
					</div>
					<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="form-group">
						  <input type="text" class="form-control form_contct2" id="name" placeholder="Country" name="name"/>
						</div>
					</div>
					<div class= "col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="form-group">
						  <input type="text" class="form-control form_contct2" id="name" placeholder="Pin Code" name="name"/></br>
						</div>
					</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:50px;">
					<div class="container-fluid">
						<center>
							<button type="button" onClick="validateSubmit();" class="btn btn-default btn-lg">SUBMIT & SAVE</button>
						</center>
					</div>
				</div>
			</div>
			
	</div>
	</div>
</div>