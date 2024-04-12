<style>
.grid-container { display: grid; grid-template-columns: auto auto auto; background-color: #fbb917; padding: 3px; }
.grid-item { background-color: rgba(255, 255, 255, 0.8); border: 1px solid rgba(0, 0, 0, 0.5); border-color:#fbb917; padding: 30px; font-size: 20px; font-weight:bold; text-align: center; }
.grid-item:hover { background-color: #800000; color: white; }
</style>
<!--for printing --><div id="printScreen" style="display:none;">
<?php for($s = 0; $s < count($eventCounter); ++$s) { ?>
	<page style="margin-top:25px;margin-left:75%;width:115%;height:auto;margin-right:75%;margin-height:auto;">
			<form>
				<div style="margin-top:45px;"></div>
				<center><span class="eventsFont2" style="font-size:14px;font-family:switzerland;"><strong>
					<?=$eventCounter[$s][0]["RECEIPT_TET_NAME"]; ?>	
				</strong></span></center><br/>
				<div style="margin-top:-8px;"></div>
				<center class="eventsFont2" style="font-size:14px;font-family:switzerland;"><strong>
						<?=$templename[0]["TRUST_NAME"]?>
				</strong></center>
				<div style="margin-top:52px;"></div>
				<center class="eventsFont2" style="font-size:11px;padding-bottom:4px;" id="sevaPrint"><strong>Seva Receipt</strong></center>
				<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Receipt Date&nbsp;: </strong><?=$eventCounter[$s][0]["TET_RECEIPT_DATE"];?></span><br/>
				<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Receipt No&nbsp;&nbsp;&nbsp;&thinsp;: </strong><?=$eventCounter[$s][0]['TET_RECEIPT_NO'] ?></span>
				<div style="margin-bottom:6px;"></div>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Name&emsp;&ensp;&ensp;&nbsp;&thinsp;: <?=$eventCounter[$s][0]['TET_RECEIPT_NAME'] ?></strong></span><br/>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Number&ensp;&ensp;&ensp;: </strong><?=$eventCounter[$s][0]['TET_RECEIPT_PHONE'] ?></span><br/>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Email&emsp;&ensp;&nbsp;&nbsp;&thinsp;&thinsp;: </strong><?=$eventCounter[$s][0]['TET_RECEIPT_EMAIL'] ?></span><br/>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Rashi&ensp;&ensp;&ensp;&nbsp;&nbsp;&thinsp;&thinsp;: </strong><?=$eventCounter[$s][0]['TET_RECEIPT_RASHI'] ?></span><br/>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Nakshatra&nbsp;: </strong><?=$eventCounter[$s][0]['TET_RECEIPT_NAKSHATRA'] ?></span><br/>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Address&nbsp;&nbsp;&thinsp;&thinsp;&thinsp;: </strong><?=$eventCounter[$s][0]['TET_RECEIPT_ADDRESS'] ?></span>
				<div style="margin-bottom:6px;"></div>
				<?php if($eventCounter[$s][0]['TET_RECEIPT_RASHI'] != "" || $eventCounter[$s][0]['TET_RECEIPT_PHONE'] != "" || $eventCounter[$s][0]['TET_RECEIPT_NAKSHATRA'] != "") { ?>
					<!--your code goes here -->
				<?php } ?>
			
		<!-- 	 <?php if($eventCounter[$s][0]['TET_SO_IS_SEVA'] == 0) { ?> -->
			<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Prasad&nbsp;&nbsp;&nbsp;&thinsp;: <?=$eventCounter[$s][0]['TET_SO_SEVA_NAME'] ?></strong></span><br/>
			<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Quantity&nbsp;: <?=$eventCounter[$s][0]['TET_SO_QUANTITY'] ?></strong></span><br/>
			<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Price&nbsp;: Rs. <?=$eventCounter[$s][0]['TET_SO_PRICE']; ?>/- <?=AmountInWords($eventCounter[$s][0]['TET_SO_PRICE']);?></strong></span><br/><!-- <br/> -->
			<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Amount&nbsp;: <?=$eventCounter[$s][0]['TET_RECEIPT_PRICE'] ?><?=AmountInWords($eventCounter[$s][0]['TET_RECEIPT_PRICE']);?></strong></span>
			<!-- <?php } else { ?> -->
			<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Seva&nbsp;: <?=$eventCounter[$s][0]['TET_SO_SEVA_NAME'] ?></strong></span><br/>
			<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Date&nbsp;: </strong><?=$eventCounter[$s][0]['TET_RECEIPT_DATE'] ?></span><br/>
			<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Quantity&nbsp;: <?=$eventCounter[$s][0]['TET_SO_QUANTITY'] ?></strong></span><br/>
			<span style="font-size:11px;letter-spacing:1px;" class="eventsFont2"><strong>Price&nbsp;: Rs. <?=$eventCounter[$s][0]['TET_RECEIPT_PRICE'] ?>/-<?=AmountInWords($eventCounter[$s][0]['TET_RECEIPT_PRICE']);?></strong></span>
			<!-- <?php } ?> -->
			<br/>
				<div style="margin-bottom:6px;"></div>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Payment Mode&nbsp;: </strong><?=$eventCounter[$s][0]['TET_RECEIPT_PAYMENT_METHOD']; ?></span><br/>
				
				<?php if($eventCounter[$s][0]['TET_RECEIPT_PAYMENT_METHOD'] == "Cheque") { ?>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Cheque Number&nbsp;: </strong><?=$eventCounter[$s][0]['CHEQUE_NO']; ?></span>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Cheque Date&nbsp;: </strong><?=$eventCounter[$s][0]['CHEQUE_DATE']; ?></span>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Bank&nbsp;: </strong><?=$eventCounter[$s][0]['BANK_NAME']; ?></span>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Branch&nbsp;: </strong><?=$eventCounter[$s][0]['BRANCH_NAME']; ?></span><br/>
				<?php } else if($eventCounter[$s][0]['TET_RECEIPT_PAYMENT_METHOD'] == "Credit / Debit Card") { ?><br/>
					<span style="font-size:11px;letter-spacing:1px;"><strong>Transaction Id&nbsp;: </strong><?=$eventCounter[$s][0]['TRANSACTION_ID']; ?></span><br/>
				<?php } ?>
				<span style="font-size:11px;letter-spacing:1px;"><strong>Notes&nbsp;: </strong><?=$eventCounter[$s][0]['TET_RECEIPT_PAYMENT_METHOD_NOTES'] ?></span><br/><br/>
				<span style="font-size:11px;margin-left:24.5%;position:fixed;letter-spacing:1px;"><strong>Issued By&nbsp;: </strong><?=$eventCounter[$s][0]['TET_RECEIPT_ISSUED_BY'] ?></span><br/>
				<span style="font-size:7px;letter-spacing:1px;position:fixed;margin-bottom:12px;"><strong><span style="color:red;">* </span> Seva Prasadam should be collected on the same day of the seva </strong></span>
				<!--<center style="clear:both;font-size: 30px;">*************************</center><br/><br/>-->
			</form>
		</page>
<?php } ?>
</div><!--for printing ends -->

<div class="container">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="col-lg-10 col-md-10  col-sm-10 col-xs-10">
				<span class="eventsFont2">Event Token: <span class="samFont"><?php echo $event['TET_NAME']; ?></span></span>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
				<a style="width:24px; height:24px" class="pull-right img-responsive" href="<?=site_url()?>TrustEvents/event_token" title="Reset"><img title="Reset" src="<?=site_url();?>images/refresh.svg"/></a>
			</div>
		</div>
	</div>
	<?php if(@$eventSevas) { ?>
		<div class="form-group">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="grid-container">
					<?php foreach($eventSevas as $result) { ?>
						<div class="grid-item" style="cursor: pointer;" onclick="sevaClick('<?php echo $result->TET_SEVA_ID; ?>','<?php echo $result->TET_SEVA_NAME; ?>','<?php echo $result->TET_SEVA_PRICE; ?>','<?php echo $result->IS_SEVA; ?>')"><?php echo $result->TET_SEVA_NAME; ?></div>
					<?php } ?>
				</div>
			</div>
		</div>
	<?php } ?> 
</div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Receipt Preview</h4>
			</div>
			<div class="modal-body" id="creditdet" style="overflow-y: auto;max-height: 80vmin;">
				
			</div>
			<form id="formSub" action="<?php echo site_url(); ?>TrustReceipt/save_token_receipt" enctype="multipart/form-data" method="post" accept-charset="utf-8">
				<div class="modal-footer text-left" style="text-align:left;">
					<button style="width: 8%;" type="button" class="btn btn-default sevaButton" id="submit2">Print</button>
					<button style="width: 8%;" type="button" class="btn btn-default sevaButton" data-dismiss="modal">Cancel</button>
				</div>
				<!--HIDDEN FIELDS -->
				<input type="hidden" id="uName" name="uName">
				<input type="hidden" id="sevaId" name="sevaId">
				<input type="hidden" id="sevaName" name="sevaName">
				<input type="hidden" id="sevaQty" name="sevaQty">
				<input type="hidden" id="sevaPrice" name="sevaPrice">
				<input type="hidden" id="is_seva" name="is_seva">
				<input type="hidden" id="event" name="event" value="<?php echo $event['TET_ID']."|".$event['TET_NAME']; ?>">
			</form>
		</div>
	</div>
</div>

<iframe style="width:76mm;height:1px;visibility:hidden;" id="printing-frame" name="print_frame" src="about:blank"></iframe>

<script>
	<!-- Amount Validation -->
	function checkValue(id,price) {
		$('#qty').css('border-color', '#ffffff');
		var $th = $("#" + id);
		$th.val( $th.val().replace(/[^0-9]/g, function(str) { return ''; } ) );
		if($th.val() && Number($th.val()) == 0){
			$th.val(""); return '';
		} 
		var tamount = (price * $th.val());
		$("#tAmt").val(tamount);
	}

	$('#submit2').on('click', function() {
		if(document.getElementById("qty").value == 0 && document.getElementById("qty").value == "") {
			$('#qty').css('border-color', "#FF0000");
			return;
		}
		//ADD VALUES TO HIDDEN TEXT BOX
		document.getElementById("uName").value = document.getElementById("uname").value;
		document.getElementById("sevaQty").value = document.getElementById("qty").value;
		//ENDS HERE ADD VALUES TO HIDDEN TEXT BOX
		$('#formSub').submit();
	});
	
	function sevaClick(id, name, price, is_seva) {
		//ADD VALUES TO HIDDEN TEXT BOX
		document.getElementById("sevaId").value = id;
		document.getElementById("sevaName").value = name;
		document.getElementById("sevaPrice").value = price;
		document.getElementById("is_seva").value = is_seva;
		//ENDS HERE ADD VALUES TO HIDDEN TEXT BOX
		
		$('.modal-body').html("<label style='width:5%'>NAME:</label> <input type='text' id='uname' name='uname' value ='Sevadhar'><br/>");
		$('.modal-body').append("<label style='width:5%'>QTY:</label> <input type='text' id='qty' name='qty' value ='1' onkeyup='checkValue(this.id,"+ price +")'><br/>");
		$('.modal-body').append("<label>SEVA DATE:</label> "+ "<?=date('d-m-Y'); ?>" +"<br/>");
		$('.modal-body').append("<label>SEVA NAME:</label> "+ name +"<br/>");
		$('.modal-body').append("<label>PRICE:</label> Rs "+ price +"<br/>");
		$('.modal-body').append("<label>TOTAL AMOUNT:</label> Rs <input type='text' id='tAmt' name='tAmt' value ="+price+" style='width:10%;border:none;background-color:white;' disabled><br/>");
		$('.modal-body').append("<label>PAYMENT MODE:</label> Cash<br/>");
		
		
		$('.modal').modal();
		$('.bs-example-modal-lg').focus();
	}
	
	var print1 = function() {		
		var newWin = window.frames["print_frame"]; 
		newWin.document.write('<html><head><link href="<?php echo  base_url(); ?>css/print.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/quickSand.css" rel="stylesheet"><link href="<?php echo base_url(); ?>css/fonts.googleapis.css" rel="stylesheet" type="text/css"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" crossorigin="anonymous"><link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-theme.min.css" crossorigin="anonymous"><link href="<?php echo  base_url(); ?>css/jquery-ui.theme.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.min.css" rel="stylesheet"><link href="<?php echo  base_url(); ?>css/jquery-ui.structure.min.css" rel="stylesheet"</head>' + '<body onload="window.print()">'+ $('#printScreen').html() +'</body></html>');
		newWin.document.close();
	}
	
	var prt = '<?=@$_SESSION['DataAdded']?>';
	$('document').ready(function() {
		if(prt == 'Done') {
			print1();
		}
		prt = "";
	});
</script>
<?php unset($_SESSION['DataAdded']); ?>