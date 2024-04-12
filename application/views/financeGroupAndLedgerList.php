<?php error_reporting(0); ?>
<div class="container">
	<div class="row">
	
	<div class="col-lg-12 col-md-12 col-sm-8 col-xs-8">
	<div class="row form-group">							
		<div class="col-lg-12 col-md-12 col-sm-8 col-xs-8" style = "padding-right:0px;padding-top:10px;">
				<h3 style="margin-top:0px">All Groups and Ledgers</h3>
		</div>
	</div>
	<div class="col-offset-lg-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-right text-right" style = "padding-right:0px;padding-bottom:0px; margin-top:-3.7em">
			<a style="margin-left: 9px;pull-right;" href="<?=site_url()?>finance/Group" title="Add Group"><img style="width:24px; height:24px" src="<?=site_url();?>images/add_icon.svg"/></a>
	</div>
	<div class="row form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
					  <tr>
					  	<th>Group Name</th>
					  </tr>
					</thead>
					<tbody>
					<?php foreach($allLedgerList as $row){
					
						if($row->LEVELS =='LG'){ ?>
						 	<tr class="child-row<?php echo $row->FGLH_PARENT_ID; ?> childClose-type<?php echo $row->TYPE_ID; ?> childClose-row<?php echo $row->LEDGER_PRIMARY_PARENT_CODE; ?>" style="display: none;border-bottom:2px solid#f1e5e5;" for="">
								<td><a style="text-decoration:none;color: #681212" onClick="openLedgerList('<?=$row->FGLH_ID; ?>')"><?php echo $row->FGLH_NAME; ?></a></td>
							</tr>
						<?php } else if($row->LEVELS =='SG'){ ?>
						 	<tr class="child-row<?php echo $row->FGLH_PARENT_ID; ?> parent childClose-type<?php echo $row->TYPE_ID; ?> childClose-row<?php echo $row->LEDGER_PRIMARY_PARENT_CODE; ?> subGroup" id="row<?php echo $row->FGLH_ID; ?>" style="display: none;border-bottom:2px solid#f1e5e5;" for="">
								<td><a style="text-decoration:none;cursor: pointer;" ><?php echo $row->FGLH_NAME; ?></a></td>
							</tr>
						<?php } else if($row->LEVELS == 'PG'){ ?>
						 	<tr class="child-row<?php echo $row->FGLH_PARENT_ID; ?> parent childClose-type<?php echo $row->TYPE_ID; ?> childClose-row<?php echo $row->LEDGER_PRIMARY_PARENT_CODE; ?>" id="row<?php echo $row->FGLH_ID; ?>" style="display: none;border-bottom:2px solid#f1e5e5;">
								<td><a style="text-decoration:none;cursor: pointer;" ><?php echo $row->FGLH_NAME; ?></a></td>
							</tr>
						<?php } else{ ?> 
							<tr class="parent" id="row<?php echo $row->FGLH_ID; ?>" name="type<?php echo $row->TYPE_ID; ?>" style="cursor: pointer;border-bottom:2px solid#f1e5e5;">
								<td><?php echo $row->FGLH_NAME; ?></td>
							</tr>
						<?php  } ?>
					<?php } ?>
					</tbody>
				</table>
				
			</div>
		</div>
	</div>
	</div>
</div>
</div>

<form id="openLedgerForm" action="" method="post">
	<input type="hidden" id="FGLH_ID" name="FGLH_ID" />
</form>

<script type="text/javascript">

	$(document).ready(function () {    
        $('tr.parent')  
            .css("cursor", "pointer")  
            .attr("title", "Click to expand/collapse")  
            .click(function () { 
                $(this).siblings('.child-' + this.id).toggle(); 
                if($(this).hasClass( "opened" )){
                	$(this).siblings('.childClose-' + $(this).attr('name')).hide(); 
                	$(this).siblings('.childClose-' +this.id).hide(); 
                	$(this).siblings('.for-' +this.id).hide(); 
                }
	            $(this).toggleClass("opened");
	            if($(this).hasClass( "subGroup" )){
	            	$(this).siblings('.child-' +this.id).addClass($(this).attr('for'));
		            $(this).siblings('.child-' +this.id).attr('for',$(this).attr('for')+' for-' +this.id);
		        }
        });  
    });  

    $(document).ready(function () { 
    	let openItems='<?php echo @$openedRowsActive ?>';
    	if(openItems!=""){
	    	let arrOpen =openItems.split(",");
	    	for(let i=0;i<arrOpen.length-1;i++){
	            $('#'+arrOpen[i]).siblings('.child-'+arrOpen[i]).toggle(); 
	            $('#'+arrOpen[i]).siblings('.childClose-'+arrOpen[i]).hide(); 
	        	$('#'+arrOpen[i]).toggleClass("opened");
	        }
	    }
    }); 

    function openLedgerList(FGLH_ID){
		$('#FGLH_ID').val(FGLH_ID);
		$('#openLedgerForm').attr('action','<?=site_url()?>finance/allLedgerTranscation');
		$('#openLedgerForm').submit();
	}
</script>