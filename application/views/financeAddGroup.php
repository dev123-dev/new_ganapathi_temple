<img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
    <div id="addGroup" style="">
        <div class="container py-5" >
            <div class="row form-group">
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">               
                    <h3><span class="icon icone-crop"></span>Add Group/SubGroup</h3> 
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4" style = "padding-top:10px;">
                    <a style="text-decoration:none;cursor:pointer;pull-right;" onClick="goback()"  title="Back"><img style="width:24px; height:24px" title="Go Back"  src="<?=site_url();?>images/back_icon.svg"/></a>
                </div>
            </div>

            <form id="frmAddGroup" action="<?=site_url()?>finance/addNewGroup" method="post">
                <h4>Select Type</h4><br>
                <input type="radio" name="radioGrp" value="mGroup" id="mGroup" onclick="javascript:yesnoCheck();" autofocus>  Group  &ensp;&emsp; 
                <input type="radio" name="radioGrp" value="subGroup" id="subGroup" onclick="javascript:yesnoCheck();" >  Sub Group<br/>
                <div class="row">
                    <div id="group1" name="group1" style="height: 30px; display: none" class=" col-lg-6">
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-8" style="margin-left: -1em;font-weight: bold;">
                            <br> 
                             <label for="comment">Under: <span style="color:#800000;">*</span></label></br>           
                            <!-- <h5><span class="icon icone-crop"></span>Under</h5> -->
                        </div>


                        <select id="mainGroupId" name="mainGroupId" class="form-control" style="height: 30px;  width:50%">
                            <option value="">Select Group</option>
                            <?php   if(!empty($maingroups)) {
                                foreach($maingroups as $row1) { ?> 
                                    <option value="<?php echo $row1->FGLH_ID?>|<?php echo $row1->FGLH_NAME;?>"><?php echo $row1->FGLH_NAME;?></option>
                                <?php } } ?>
                        </select></br> 
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-8" style="margin-left: -1em;font-weight: bold;">    <label for="comment">Group Name: <span style="color:#800000;">*</span></label></br>     
                            <!-- <h5><span class="icon icone-crop"></span>Group Name:</h5> -->
                        </div> 
                        <div class="" >
                            <input type="text"  name="nameG" class="form-control"  style="width:50%;" placeholder="Group Name" id="nameG" autocomplete="off">
                        </div>
                        <div class="" ><br>
                            <input type="button" class="btn btn-default btn-md custom" value="Submit" 
                            onclick="addNewGroup()">
                        </div>
                    </div>

                    <div id="group2" name="group2" style="height: 30px;display: none ;margin-top: 20px;" 
                    class="col-lg-6">
                        <!-- <div class="col-lg-10 col-md-10 col-sm-10 col-xs-8" style="margin-left: -1em;">   -->
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-8" style="margin-left: -1em;font-weight: bold;">     <label for="comment">Under: <span style="color:#800000;">*</span></label></br>               
                            <!-- <h5><span class=""></span>Under</h5> -->
                        </div>

                        <select id="groupId" name="groupId" class="form-control" style="height: 30px;  width:50%">
                            <option value="">Select Sub Group</option>
                            <?php   if(!empty($groups)) {
                                foreach($groups as $row1) { ?> 
                                    <option value="<?php echo $row1->FGLH_ID;?>|<?php echo $row1->FGLH_NAME;?>"><?php echo $row1->FGLH_NAME;?></option>
                                <?php } } ?>
                        </select></br>  
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-8" style="margin-left: -1em;font-weight: bold;">     <label for="comment">Sub Group Name : <span style="color:#800000;">*</span></label></br>     
                            <!-- <h5><span class=""></span>Sub Group Name:</h5> -->
                        </div>
                        <div class="">
                            <input type="text" class="form-control"  style="width:50%;" name="nameSG" placeholder="Sub Group Name" id="nameSG" autocomplete="off">
                        </div>

                        <div class="" ><br>
                            <input type="button" class="btn btn-default btn-md custom" value="Submit" 
                            onclick="addNewGroup()">
                        </div>
                    </div> 
                </div>                             
            </form>
        </div>
    </div> 
    <input type="hidden" id="callFrom" name="" value="<?php echo $callFrom ?>">
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="addGroupModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Group/Sub Group Preview</h4>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer text-left" style="text-align:left;">
                    <label>Are you sure you want to save..?</label>
                    <br/>
                    <button type="button" style="width: 8%;" class="btn " onclick="document.getElementById('frmAddGroup').submit();">Yes</button>
                    <button type="button" style="width: 8%;" class="btn " data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function addNewGroup() {
            let count = 0;            
            let mainGroupId ="";
            let name="";
            let groupId="";
            if($('#mGroup').prop('checked')){

                mainGroupId = $('#mainGroupId').val().split("|");
               
                name = $('#nameG').val();
                if (document.getElementById("mainGroupId").value != "") {
                    $('#mainGroupId').css('border-color', "#000000");
                } else {
                    $('#mainGroupId').css('border-color', "#FF0000");
                    ++count;
                }
                if (document.getElementById("nameG").value != "") {
                    $('#nameG').css('border-color', "#000000");
                } else {
                    $('#nameG').css('border-color', "#FF0000");
                    ++count;
                }
                if (count != 0) {
                    alert("Information", "Please fill required fields", "OK");
                    return false;
                }
            } else{
                groupId = $('#groupId').val().split("|");
               
                name = $('#nameSG').val();
                 if (document.getElementById("groupId").value != "") {
                    $('#groupId').css('border-color', "#000000");
                } else {
                    $('#groupId').css('border-color', "#FF0000");
                    ++count;
                }
                if (document.getElementById("nameSG").value != "") {
                    $('#nameSG').css('border-color', "#000000");
                } else {
                    $('#nameSG').css('border-color', "#FF0000");
                    ++count;
                }
                if (count != 0) {
                    alert("Information", "Please fill required fields", "OK");
                    return false;
                }

            }
            let url = "<?=site_url()?>finance/addNewGroup";
            $("#addGroupModal").modal(); 
            $(".modal-body").html("");
            $('.modal-body').append("<label>DATE:</label> " + "<?=date('d-m-Y'); ?>" + "<br/>");
            if(name!="")
                $('.modal-body').append("<label>NAME:</label> " + name + "<br/>");
            if(mainGroupId != "")
                $('.modal-body').append("<label>GROUP NAME:</label> " + mainGroupId[1] + "<br/>");
            if(groupId != "")
                $('.modal-body').append("<label>SUB GROUP NAME:</label> " + groupId[1] + "<br/>");

            $(".modal").on("hidden.bs.modal", function(){

            });
        }

        function yesnoCheck() {
            if (document.getElementById('mGroup').checked) {
                document.getElementById('group1').style.display = 'block';
                $('#nameG').val('');
                $('#mainGroupId').val("");
            } else {
                document.getElementById('group1').style.display = 'none';
            }
            if (document.getElementById('subGroup').checked) {
                document.getElementById('group2').style.display = 'block';
                $('#nameSG').val();
                $('#groupId').val("");
            }else {
                document.getElementById('group2').style.display = 'none';
            }
        }

         //INPUT KEYPRESS
        $(':input').on('keypress change', function() {
            var id = this.id;
            try {$('#' + id).css('border-color', "#000000");}catch(e) {}
            
        });

        function goback(){
            let callFrom = $('#callFrom').val();
            if(callFrom=="allGroupLedger"){
                window.location.href = "<?=site_url() ?>finance/allGroupLedgerDetails";
            }else{
                window.history.back();
            }
        }
    </script>
</body>