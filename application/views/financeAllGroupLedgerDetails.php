<?php error_reporting(0); ?>
<div class="container">
	<div class="row">
	
	<div class="col-lg-6 col-md-12 col-sm-8 col-xs-8">
	<div class="row form-group">							
		<div class="col-lg-12 col-md-12 col-sm-8 col-xs-8" style = "padding-right:0px;padding-top:10px;">
				<h3 style="margin-top:0px">All Groups </h3>
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
					  	<form id="joinForm" method="POST">
							<th width="90%">Group Name &nbsp;&nbsp;
								<input type="hidden" name="callFromGroup" value="SearchGroup">
								<input id="idSrchGroup" class="" type="text" name="GroupName" value="<?=@$GroupName; ?>" placeholder="Search"  style="color: maroon;">
							</th>
						</form>
						<!-- <th width="10%"><center>Operations</center></th>'<?php echo str_replace("'","\'",$row2->FGLH_NAME);?>' -->
						<th width="10%"><center>Edit</center></th>
						<th width="10%"><center>Delete</center></th>
						<th width="10%"><center>Transfer</center></th>
					  </tr>
					</thead>
					<tbody>
					<?php foreach($allGroups as $row) { ?>
					<tr>
						<td><?php echo $row->FGLH_NAME; ?></td>
						<?php foreach($parentDetails as $parentResult) { 
							if($parentResult->FGLH_ID == $row->FGLH_PARENT_ID){
								$parentName = $parentResult->FGLH_NAME;
								$parentLevel = $parentResult->LEVELS; ?>
							<?php }
						 } ?>

						<td class="text-center">				
							<a style="border:none; outline: 0;" href="#" title="Edit Group" ><img style="border:none; outline: 0;" 
								onclick="editGroups('<?=$row->FGLH_ID; ?>','<?php echo str_replace("'","\'",$row->FGLH_NAME);?>','<?=$parentName?>','<?=$parentLevel?>','<?=$row->FGLH_PARENT_ID; ?>','<?=$row->LEVELS; ?>')" src="<?php echo	base_url(); ?>images/edit_icon.svg"></a>
						</td>	
						<td class="text-center">
						<a style="border:none; outline: 0;" title="Delete Group" ><img style="border:none; outline: 0;" 
								onclick="deleteGroups('<?=$row->FGLH_ID; ?>','<?php echo str_replace("'","\'",$row->FGLH_NAME);?>','<?=$parentName?>','<?=$parentLevel?>','<?=$row->FGLH_PARENT_ID; ?>','<?=$row->LEVELS; ?>')" src="<?php echo	base_url(); ?>images/delete.svg"></a>	
							<!-- <a style="border:none; outline: 0;" title="Delete Group"><img style="cursor:pointer;border:none; outline: 0;" src="<?php echo base_url(); ?>images/delete.svg"  onclick = "deleteGroups(<?php echo $row->FGLH_ID.",'".$row->FGLH_NAME."','".$parentName."','".$parentLevel."',".$row->FGLH_PARENT_ID.",'".$row->LEVELS."'" ?>)"></a>	 -->						
						</td>
						<td class="text-center">	
							<a style="border:none; outline: 0;" title="Transfer  Group" ><img style="border:none; outline: 0;" 
								onclick="transferGroup('<?=$row->FGLH_ID; ?>','<?php echo str_replace("'","\'",$row->FGLH_NAME);?>','<?=$parentName?>','<?=$parentLevel?>','<?=$row->FGLH_PARENT_ID; ?>','<?=$row->LEVELS; ?>')" src="<?php echo	base_url(); ?>images/transfer.svg"></a>
							<!-- <a style="border:none; outline: 0;" title="Transfer Group"><img style="cursor:pointer;border:none; outline: 0;" src="<?php echo base_url(); ?>images/transfer.svg"  onclick = "transferGroup(<?php echo $row->FGLH_ID.",'".$row->FGLH_NAME."','".$parentName."','".$parentLevel."',".$row->FGLH_PARENT_ID.",'".$row->LEVELS."'" ?>)"></a>	 -->						
						</td>	
					</tr>
					<?php } ?>
					</tbody>
				</table>
				<!-- <ul id="page1" class="pagination pagination-sm" style="margin-top: 1px;">
					<?=$_SESSION['pages1']; ?>
				</ul> -->
				<label style="font-size:18px;color:#5b5b5b;margin-top: -0.2px;" class="pull-right">Total: <strong style="font-size:18px"><?php echo isset($allGroupsCount) ? $allGroupsCount : 0?></strong>
				</label> 
			</div>
		</div>
	</div>
	</div>
	<div class="col-lg-6 col-md-12 col-sm-8 col-xs-8">
	<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
	<div class="row form-group">							
		<div class="col-lg-12 col-md-12 col-sm-8 col-xs-8" style = "padding-right:0px;padding-top:10px;">
				<h3 style="margin-top:0px">All Ledgers</h3>
				<!-- adding the filter by adithya start -->
		
        <form id="frmCommitteeChange" action="<?=site_url()?>finance/allGroupLedgerDetails" method="post">
            <select id="TYPE_ID" name="TYPE_ID" class="form-control " style="width:100px; margin-top:-40px;margin-left:150px" onChange="onCommitteeChange();">
            	<option value="">All</option>
              	<?php   if(!empty($types)) {
                  foreach($types as $row1) { 
                  if($TYPE_ID == $row1->FGLH_NAME) {?>
				  <option value="<?php echo $row1->FGLH_NAME;?>"  selected ><?php echo $row1->FGLH_NAME;?></option>
               
				  <?php }else{?>
                      <option value="<?php echo $row1->FGLH_NAME;?>" ><?php echo $row1->FGLH_NAME;?></option>
                    
                  <?php } } } ?>
            </select>
        </form>  
		
				<!-- adding the filter by adithya end -->
		</div>
	</div>
	<div class="col-offset-lg-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-right text-right" style = "padding-right:0px;padding-bottom:0px; margin-top:-3.7em">
			<a style="margin-left: 9px;pull-right;" href="<?=site_url()?>finance/Ledger" title="Add Ledger"><img style="width:24px; height:24px" src="<?=site_url();?>images/add_icon.svg"/></a>
			<a style="text-decoration:none;cursor:pointer;pull-right;" href="<?=site_url()?>finance/allGroupLedgerDetails" title="Refresh"><img style="width:24px; height:24px" title="Refresh" src="<?=site_url();?>images/refresh.svg"/></a>
	</div>
	<div class="row form-group " style="margin-top:20px"  >
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
					  <tr>
						<form id="joinForm" method="POST">
							<th width="90%">Ledger Name &nbsp;&nbsp;
								<input id="idSrchLedger" class="" type="text" name="LedgerName" value="<?=@$LedgerName; ?>" placeholder="Search" keyup="srchOnLedgerSide()" style="color: maroon;">
								<input type="hidden" name="callFromLedger" value="SearchLedger">
							</th>
						</form>
						<th width="10%"><center>Edit</center></th>
						<th width="10%"><center>Delete</center></th>
						<th width="10%"><center>Transfer</center></th>
						<th width="10%"><center>View Ledger</center></th>
					  </tr>
					</thead>
					<tbody>
					<?php foreach($allLedger as $result) { ?>
					<tr>
						<td><?php echo $result->FGLH_NAME; ?></td>
						<td class="text-center">
						<a style="border:none; outline: 0;" title="Edit Ledger" ><img style="border:none; outline: 0;" 
								onclick="editLedger('<?=$result->FGLH_ID; ?>','<?php echo str_replace("'","\'",$result->FGLH_NAME);?>','<?=$result->FGLH_PARENT_ID; ?>','<?=$result->IS_JOURNAL_STATUS; ?>','<?=$result->IS_TERMINAL; ?>','<?=$result->IS_FD_STATUS; ?>','<?=$result->FD_MATURITY_START_DATE; ?>','<?=$result->FD_MATURITY_END_DATE; ?>','<?=$result->FD_INTEREST_RATE; ?>')" src="<?php echo	base_url(); ?>images/edit_icon.svg"></a>
						</td> 

						<td class="text-center">	
							<a style="border:none; outline: 0;" title="Delete Ledger" ><img style="border:none; outline: 0;" 
								onclick="deleteLedger('<?=$result->FGLH_ID; ?>','<?php echo str_replace("'","\'",$result->FGLH_NAME);?>','<?=$result->FGLH_PARENT_ID; ?>','<?=$result->IS_JOURNAL_STATUS; ?>','<?=$result->IS_TERMINAL; ?>','<?=$result->BALANCE; ?>','<?=$result->OPBALANCE; ?>','<?=$result->CURRENT_BALANCE; ?>')" src="<?php echo	base_url(); ?>images/delete.svg"></a>
						</td>

						<td class="text-center">	
							<a style="border:none; outline: 0;" title="Transfer  Ledger" ><img style="border:none; outline: 0;" 
								onclick="transferLedger('<?=$result->FGLH_ID; ?>','<?php echo str_replace("'","\'",$result->FGLH_NAME);?>','<?=$result->FGLH_PARENT_ID; ?>','<?=$result->TRANSACTION_AMT; ?>')" src="<?php echo	base_url(); ?>images/transfer.svg"></a>
						</td>	
						<td class="text-center">
						<a style="border:none; outline: 0; text-decoration:none" title="View Ledger"  >
						<div class="glyphicon glyphicon-search" style="; outline: 0;" onclick="ViewLedger('<?=$result->FGLH_ID; ?>','<?php echo str_replace("'","\'",$result->FGLH_NAME);?>','<?=$result->FGLH_PARENT_ID; ?>')"></div></a>
						    
					</td>
					</tr>
					<?php } ?>
					</tbody>
				</table>
				<!-- <ul class="pagination pagination-sm" style="margin-top: 1px;">
					<?=$_SESSION['pages2']; ?>
				</ul> -->
				<label style="font-size:18px;color:#5b5b5b;margin-top: -0.2px;" class="pull-right">Total: <strong style="font-size:18px"><?php echo isset($allLedgerCount) ? $allLedgerCount : 0?></strong>
				</label>
			</div>
		</div>
	</div>
	</div>
</div>
</div>

<!--Edit  Modal -->
<div class="modal fade" id="editGroupModal" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content" style="width: 70%">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" onClick="refreshPage()">&times;</button>
				<h4 style="font-weight:600;" class="modal-title text-center">Edit Group or Subgroup</h4>
			</div>
			<form id="editGroupsForm" method="post" action="<?php echo site_url();?>finance/updateGroup">
			<div class="modal-body">
				<div class="form-group">
					<div style="clear:both;" class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-6">
						<label for="inputLimit" style="margin-top: 5px;" ><span style="font-weight:600;">Type:</span></label><span ></span>
					</div>
					<div class="form-group col-lg-9 col-md-6 col-sm-6 col-xs-6">
						<input type="text" id="groupType" style="background: transparent;font-size: 17px; border: none; width: 100%;" name="groupType" value="" readonly >
					</div>
				</div>
				<div style="clear:both;" class="form-group">
					<div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-6">
						<label for="inputLimit" style="margin-top: 5px;" ><span style="font-weight:600;">Under:</span></label><span ></span>
					</div>
					<div class="form-group col-lg-9 col-md-6 col-sm-6 col-xs-6">
						<input type="text"  name="under" class="form-control"  style="width:100%;"  id="under" autocomplete="off" value="" readonly>
					</div>
				</div>
				
				<div style="clear:both;" class="form-group">				
					<div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-6">
						<label for="inputLimit" style="margin-top: 5px;"  ><span style="font-weight:600;">Name: </span> </label><span id="branch"></span>
					</div>
					<div class="form-group col-lg-9 col-md-6 col-sm-6 col-xs-6">
						<input type="text"  name="name" class="form-control"  style="width:100%;" id="name" onkeyup="alphaonlypurpose(this)" autocomplete="off" value="<?php echo $GROUP_NAME ?>" required>
					</div>
				</div>
				<input type="hidden" value="" name="GROUP_ID" id="GROUP_ID"/>
				<input type="hidden" value="" name="GROUP_LEVEL" id="GROUP_LEVEL"/>
				
				<!-- HIDDEN -->
					<div class="modal-footer">
						<div id="editDiv" class="modal-footer" style="clear: both;">
							<button type="button" id="editSubmit" class="btn btn-default">Edit</button>
							<button type="button" class="btn" data-dismiss="modal">Cancel</button>
						</div>
					</div>
					<!-- HIDDEN -->
					<div id="confirmEdit" class="modal-footer" style="text-align:left;clear: both;display:none;">
						<div>
							<label style="font-weight:600;font-size: 16px; color: maroon;text-align:left">Are you sure you want to Edit ?</label>
						</div>
						<br/>
						<div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
							<button style="width: 15%;" type="submit" class="btn btn-default sevaButton" id="submit">Yes</button>
							<button style="width: 15%;" type="button" class="btn btn-default sevaButton" data-dismiss="modal" onClick="refreshPage()">No</button>
						</div>
					</div>
			</div>
			</form>
		</div>
	</div>
</div>
<!--Edit  Modal Ends -->

<!--Delete  Modal -->
<div class="modal fade" id="deleteGroupModal" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content" style="width: 70%">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" style="margin-top: -12px;margin-right: -10px;" onClick="refreshPage()">&times;</button>
				<h4 style="font-weight:600;" class="modal-title text-center">Delete Group or Subgroup</h4>
			</div>
			<form id="deleteGroupsForm" method="post" action="<?php echo site_url();?>finance/discardGroup">
				<div class="modal-body">
					<div class="form-group">
						<div style="clear:both;" class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-6">
							<label for="inputLimit" style="margin-top: 5px;"  ><span style="font-weight:600;">Type:</span></label><span ></span>
						</div>
						<div class="form-group col-lg-9 col-md-6 col-sm-6 col-xs-6">
							<input type="text" id="groupDltType" style="background: transparent;font-size: 17px; border: none; width: 100%;" name="groupDltType" value="" readonly >
						</div>
					</div>
					<div style="clear:both;" class="form-group">
						<div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-6">
							<label for="inputLimit" style="margin-top: 5px;" ><span style="font-weight:600;">Under:</span></label><span ></span>
						</div>
						<div class="form-group col-lg-9 col-md-6 col-sm-6 col-xs-6">
							<input type="text"  name="parentName" class="form-control"  style="width:100%;"  id="parentName" autocomplete="off" value="" readonly>
							<input type="hidden" name="underId" id="underId" value="<?php echo $parentDetails[0]->FGLH_ID;?>">
						</div>
					</div>
					
					<div style="clear:both;" class="form-group">				
						<div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-6">
							<label for="inputLimit" style="margin-top: 5px;" ><span style="font-weight:600;">Name: </span> </label><span id="branch"></span>
						</div>
						<div class="form-group col-lg-9 col-md-6 col-sm-6 col-xs-6">
							<input type="text"  name="grpName" class="form-control"  style="width:100%;"  id="grpName" autocomplete="off" value="<?php echo $GROUP_NAME ?>" readOnly >

						</div>
					</div>
					<input type="hidden" value="" name="DLT_GROUP_ID" id="DLT_GROUP_ID"/>
					<input type="hidden" value="" name="DLT_GROUP_LEVEL" id="DLT_GROUP_LEVEL"/>
                  
					<!-- HIDDEN -->
					<div class="modal-footer">
						<div id="deleteDiv" class="modal-footer" style="clear: both;">
							<button type="button" id="deleteSubmit" class="btn btn-default">Delete</button>
							<button type="button" class="btn" data-dismiss="modal">Cancel</button>
						</div>
					</div>

					<!-- HIDDEN -->
					<div id="confirmDelete" class="modal-footer" style="text-align:left;clear: both;display:none;">
						<div>
							<label style="font-weight:600;font-size: 16px; color: maroon;text-align:left">Are you sure you want to Delete ?</label>
						</div>
						<br/>
						<div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
							<button style="width: 15%;" type="submit" class="btn btn-default sevaButton" id="submit">Yes</button>
							<button style="width: 15%;" type="button" class="btn btn-default sevaButton" data-dismiss="modal" onClick="refreshPage()">No</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<!--Delete  Modal Ends -->

<!--Transfer Ledger Modal -->
<div class="modal fade" id="transferLedgerModal" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content" style="width: 70%">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" onClick="refreshPage()">&times;</button>
				<h4 style="font-weight:600;" class="modal-title text-center">Transfer Ledger</h4>
			</div>
			<form id="transferLedgerForm" method="post" action="<?php echo site_url();?>finance/transferLedger">
				<div class="modal-body">
					<div style="clear:both;" class="form-group">				
						<div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-6">
							<label for="inputLimit" style="margin-top: 5px;" ><span style="font-weight:600;">Name: </span> </label><span id="branch"></span>
						</div>
						<div class="form-group col-lg-9 col-md-6 col-sm-6 col-xs-6">
							<input type="text"  name="transferLedgerName" class="form-control"  style="width:100%;"  id="transferLedgerName" autocomplete="off" value="" readOnly >

						</div>
					</div>
					<div style="clear:both;" class="form-group">
						<div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-6">
							<label for="inputLimit" style="margin-top: 5px;"><span style="font-weight:600;">Under:</span></label><span ></span>
						</div>
						<div class="form-group col-lg-9 col-md-6 col-sm-6 col-xs-6">
							 <select id="transferLedgerparentId" name="transferLedgerparentId" class="form-control" >
		                        <option value="" >Select Group</option>
		                        <?php   if(!empty($groups)) {
		                            foreach($groups as $row1) { ?> 
		                                <option value="<?php echo $row1->FGLH_ID;?>"><?php echo $row1->FGLH_NAME;?></option>
		                        <?php } } ?>
                			</select>
							<input type="hidden" name="transferLedgerId" id="transferLedgerId" value="">
							<input type="hidden" name="oldLedgerParentId" id="oldLedgerParentId" value="">
						</div>
					</div>

					<!-- HIDDEN -->
					<div class="modal-footer" >
						<div id="transferDiv" class="modal-footer" style="clear: both;">
							<button type="button" id="transferSubmit" class="btn btn-default">Transfer</button>
							<button type="button" class="btn" data-dismiss="modal">Cancel</button>
						</div>
					</div>

					<!-- HIDDEN -->
					<div id="confirmTransfer" class="modal-footer" style="text-align:left;clear: both;display:none;">
						<div>
							<label style="font-weight:600;font-size: 16px; color: maroon;text-align:left">Are you sure you want to Transfer This Ledger?</label>
						</div>
						<br/>
						<div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
							<button style="width: 15%;" type="submit" class="btn btn-default sevaButton" id="submit">Yes</button>
							<button style="width: 15%;" type="button" class="btn btn-default sevaButton" data-dismiss="modal"onClick="refreshPage()">No</button>
						</div>
					</div>

				</div>
			</form>
		</div>
	</div>
</div>

<!--Transfer Ledger Modal Ends -->

<!--Transfer Group Modal -->
<div class="modal fade" id="transferGroupModal" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content" style="width: 70%">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" onClick="refreshPage()">&times;</button>
				<h4 style="font-weight:600;" class="modal-title text-center">Transfer Group</h4>
			</div>
			<form id="transferGroupForm" method="post" action="<?php echo site_url();?>finance/transferGroup">
				<div class="modal-body">
					<div style="clear:both;" class="form-group">				
						<div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-6">
							<label for="inputLimit" style="margin-top: 5px;" ><span style="font-weight:600;">Name: </span> </label><span id="branch"></span>
						</div>
						<div class="form-group col-lg-9 col-md-6 col-sm-6 col-xs-6">
							<input type="text"  name="transferGroupName" class="form-control"  style="width:100%;"  id="transferGroupName" autocomplete="off" value="" readOnly >

						</div>
					</div>
					<div style="clear:both;" class="form-group">
						<div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-6">
							<label for="inputLimit" style="margin-top: 5px;"><span style="font-weight:600;">Under:</span></label><span ></span>
						</div>
						<div class="form-group col-lg-9 col-md-6 col-sm-6 col-xs-6">
							 <select id="transferGroupParentId" name="transferGroupParentId" class="form-control" onchange="validateGroup()" >
		                        <option value="" >Select Group</option>
		                        <?php   if(!empty($group)) {
		                            foreach($group as $row1) { ?> 
		                                <option value="<?php echo $row1->FGLH_ID;?>"><?php echo $row1->FGLH_NAME;?></option>
		                        <?php } } ?>
                			</select>
							<input type="hidden" name="transferGroupId" id="transferGroupId" value="">
							<input type="hidden" name="oldGroupParentId" id="oldGroupParentId" value="">
							<input type="hidden" name="transferGroup" id="transferGroup" value="">

						</div>
					</div>

					<!-- HIDDEN -->
					<div class="modal-footer">
						<div id="groupTransferDiv" class="modal-footer" style="clear: both;">
							<button type="button" id="groupTransferSubmit" class="btn btn-default"  onClick="validation()">Transfer</button>
							<button type="button" class="btn" data-dismiss="modal" >Cancel</button>
						</div>
					</div>

					<!-- HIDDEN -->
					<div id="confirmGroupTransfer" class="modal-footer" style="text-align:left;clear: both;display:none;">
						<div>
							<label id="confirmId" style="font-weight:600;font-size: 16px; color: maroon;text-align:left">Are you sure you want to Transfer This Group ?</label>
							<label id="differentGrpId" style="font-weight:600;font-size: 16px; color: maroon;text-align:left"></label>
						</div>
						<br/>
						<div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
							<button style="width: 15%;margin-left: 190px" type="submit" class="btn btn-default sevaButton" id="submit1">Yes</button>
							<button style="width: 15%;margin-top:-55px;margin-right: 30px" type="button" class="btn btn-default sevaButton" data-dismiss="modal" onClick="refreshPage()">No</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<!--Transfer Group Modal Ends -->

<form id="editLedgerForm" method="post" action="<?php echo site_url();?>finance/editLedger">
	<input type="hidden" value="" name="LEDGER_ID" id="LEDGER_ID"/>
	<input type="hidden" value="" name="LEDGER_NAME" id="LEDGER_NAME"/>
	<input type="hidden" value="" name="LEDGER_PARENT_ID" id="LEDGER_PARENT_ID"/>
	<input type="hidden" value="" name="IS_JOURNAL_STATUS" id="IS_JOURNAL_STATUS"/>
	<input type="hidden" value="" name="IS_FD_STATUS" id="IS_FD_STATUS"/>
	<input type="hidden" value="" name="FD_MATURITY_START_DATE" id="FD_MATURITY_START_DATE"/>
	<input type="hidden" value="" name="FD_MATURITY_END_DATE" id="FD_MATURITY_END_DATE"/>
		<input type="hidden" value="" name="FD_INTEREST_RATE" id="FD_INTEREST_RATE"/>

	<input type="hidden" value="" name="IS_TERMINAL" id="IS_TERMINAL"/>
</form>

<form id="deleteLedgerForm" method="post" action="<?php echo site_url();?>finance/deleteLedger">
	<input type="hidden" value="" name="LED_ID" id="LED_ID"/>
	<input type="hidden" value="" name="LED_NAME" id="LED_NAME"/>
	<input type="hidden" value="" name="LED_PARENT_ID" id="LED_PARENT_ID"/>
	<input type="hidden" value="" name="JOURNAL_STATUS" id="JOURNAL_STATUS"/>
	<input type="hidden" value="" name="TERMINAL" id="TERMINAL"/>
	<input type="hidden" value="" name="BALANCE" id="BALANCE"/>
	<input type="hidden" value="" name="OPBALANCE" id="OPBALANCE"/>
	<input type="hidden" value="" name="CURRENT_BALANCE" id="CURRENT_BALANCE"/>	
</form>

<form id="ViewLedger" method="post" action="<?php echo site_url();?>finance/ViewLedger">
<input type="hidden" value="" name="FGLH_ID" id="FGLH_ID"/>
</form>

<script>
	function editGroups(GROUP_ID,GROUP_NAME,parentName,parentLevel,GROUP_PARENT_ID,GROUP_LEVEL){
		$('#GROUP_ID').val(GROUP_ID);
		$('#name').val(GROUP_NAME);
		$('#under').val(parentName);
		$('#GROUP_LEVEL').val(GROUP_LEVEL);
		$('#groupType').val((parentLevel=='MG'?'Group':'Subgroup'));
		$('#editGroupModal').modal({backdrop: 'static', keyboard: false});
	}

	function deleteGroups(GROUP_ID,GROUP_NAME,parentName,parentLevel,GROUP_PARENT_ID,GROUP_LEVEL){
		let url = "<?=site_url()?>finance/checkGroupTransactionAmt";
        $.post(url, { 'GROUP_ID': GROUP_ID}, function (e) {
			if(e > 0){
				alert("Information","Group Cannot Be Deleted!! ","OK");
				return;
			} else {
				$('#DLT_GROUP_ID').val(GROUP_ID);
				$('#grpName').val(GROUP_NAME);
				$('#parentName').val(parentName);
				$('#DLT_GROUP_LEVEL').val(GROUP_LEVEL);
				$('#groupDltType').val((parentLevel=='MG'?'Group':'Subgroup'));
				$('#confirm').hide(); 
				$('#save').show();
				$('#deleteGroupModal').modal({backdrop: 'static', keyboard: false});
			}
		});
	}
  function alphaonly(input) {
      var regex=/[^-a-z ]/gi;
      input.value=input.value.replace(regex,"");
    }
	function editLedger(LEDGER_ID,LEDGER_NAME,LEDGER_PARENT_ID,IS_JOURNAL_STATUS,IS_TERMINAL,IS_FD_STATUS,FD_MATURITY_START_DATE,
          FD_MATURITY_END_DATE,FD_INTEREST_RATE){
		$('#LEDGER_ID').val(LEDGER_ID);
		$('#LEDGER_NAME').val(LEDGER_NAME);
		$('#LEDGER_PARENT_ID').val(LEDGER_PARENT_ID);
		$('#IS_JOURNAL_STATUS').val(IS_JOURNAL_STATUS);
		$('#IS_TERMINAL').val(IS_TERMINAL);
		$('#IS_FD_STATUS').val(IS_FD_STATUS);
		$('#FD_MATURITY_START_DATE').val(FD_MATURITY_START_DATE);
		$('#FD_MATURITY_END_DATE').val(FD_MATURITY_END_DATE);
		$('#FD_INTEREST_RATE').val(FD_INTEREST_RATE);
		$('#editLedgerForm').submit();
	}

	function deleteLedger(LEDGER_ID,LEDGER_NAME,LEDGER_PARENT_ID,IS_JOURNAL_STATUS,IS_TERMINAL,BALANCE,OPBALANCE,CURRENT_BALANCE){
		$('#LED_ID').val(LEDGER_ID);
		$('#LED_NAME').val(LEDGER_NAME);
		$('#LED_PARENT_ID').val(LEDGER_PARENT_ID);
		$('#JOURNAL_STATUS').val(IS_JOURNAL_STATUS);
		$('#TERMINAL').val(IS_TERMINAL);
		$('#BALANCE').val(BALANCE);
		$('#OPBALANCE').val(OPBALANCE);
		$('#CURRENT_BALANCE').val(CURRENT_BALANCE);
		$('#deleteLedgerForm').submit();
	}

	function transferLedger(LEDGER_ID,LEDGER_NAME,LEDGER_PARENT_ID,TRANSACTION_AMT){
		let url = "<?=site_url()?>finance/checkTransactionAmt";
        $.post(url, { 'LEDGER_ID': LEDGER_ID}, function (e) {
			if(e > 0){
				alert("Information","Ledger With Transcation Cannot Be Transfered!! Please Contact Development Team.","OK");
				return;
			} else {
				$('#transferLedgerId').val(LEDGER_ID);
				$('#transferLedgerName').val(LEDGER_NAME);
				$('#transferLedgerparentId').val(LEDGER_PARENT_ID);
				$('#oldLedgerParentId').val(LEDGER_PARENT_ID);
				$('#transferLedgerModal').modal({backdrop: 'static', keyboard: false});
			}
		});
	}

	function ViewLedger(FGLH_ID){
		$('#FGLH_ID').val(FGLH_ID);
		$('#ViewLedger').submit();
	}
	function alphaonlypurpose(input) {
      var regex=/[^-a-z ]/gi;
      input.value=input.value.replace(regex,"");
    }

	function transferGroup(GROUP_ID,GROUP_NAME,parentName,parentLevel,GROUP_PARENT_ID,GROUP_LEVEL){
		let url = "<?=site_url()?>finance/checkGroupTransactionAmt";
        $.post(url, { 'GROUP_ID': GROUP_ID}, function (e) {
			if(e > 0){
				alert("Information","Ledger With Transcation Cannot Be Transfered!! Please Contact Development Team.","OK");
				return;
			} else {
				$('#transferGroupId').val(GROUP_ID);
				$('#transferGroupName').val(GROUP_NAME);
				$('#transferGroupParentName').val(parentName);
				$('#transferGroupParentId').val(GROUP_PARENT_ID);
				$('#oldGroupParentId').val(GROUP_PARENT_ID);
				$('#transferGroup').val(GROUP_LEVEL);
				$('#groupDltType').val((parentLevel=='MG'?'Group':'Subgroup'));
				$('#transferGroupModal').modal({backdrop: 'static', keyboard: false});
			}
		});
	}

	$(function() {	
		$('#deleteSubmit').on('click', function() {
			$('#confirmDelete').show(); 
			$('#deleteDiv').hide();
		});
		$('#editSubmit').on('click', function() {
			$('#confirmEdit').show(); 
			$('#editDiv').hide();
		});
		$('#transferSubmit').on('click', function() {
			$('#confirmTransfer').show(); 
			$('#transferDiv').hide();
		});
		$('#groupTransferSubmit').on('click', function() {
			$('#confirmGroupTransfer').show(); 
			$('#groupTransferDiv').hide();
		});
	});

	function refreshPage(){
		window.location.reload();
	}

	function validation(){
		// document.getElementById('confirmGroupTransfer').style.display =	"block";
		document.getElementById('submit1').style.display = "block";
		$('#confirmId').show();
		let grpId = $('#transferGroupId').val();
		let underId = $('#transferGroupParentId').val();
		if(grpId == underId) {
			$('#differentGrpId').html("*Group Name and Parent Name are Same. Please Select Different Group or Subgroup Name");
			$('#confirmId').hide();
			document.getElementById('submit1').style.display = "none";
			return ;		
		}
		if(grpId != underId){
			$('#differentGrpId').hide();
		}
	}

	function validateGroup(){
		document.getElementById('groupTransferDiv').style.display =	"block";
		document.getElementById('confirmGroupTransfer').style.display =	"none";
	}
	function onCommitteeChange(){
        $('#frmCommitteeChange').submit();   
     }
</script>