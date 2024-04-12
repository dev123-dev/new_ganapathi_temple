 <img class="img-responsive bgImg2" src="<?=site_url()?>images/TempleLogo.png" />
 <div class="container-fluid container">
    <div class="row form-group">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">               
            <h3><span class="icon icone-crop"></span>Add Opening Balance for Ledger</h3>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4" style = "padding-top:10px;">
            <a class="pull-right" style="border:none; outline:0;" href="<?=site_url() ?>/Sevas" title="Back"><img style="border:none; outline: 0;" src="<?php echo base_url();?>images/back_icon.svg"></a>
        </div>
    </div>
    <form id="frmOp" action="<?=site_url()?>finance/addOpeningBal" method="post" enctype="multipart/form-data" accept-charset="utf-8">
            <div>       
                <div class="row form-group"> 
                  <div class="control-group col-lg-2 col-md-3 col-sm-4 col-xs-6">   
                     <label>Choose:</label><br>
                      <select id="led" name="led" style="height: 30px; width: 370px;" class="form-control">
                         <option value="">Select Ledger</option>
                        <?php   if(!empty($allLedger)) {
                        foreach($allLedger as $row1) { ?> 
                        <option value="<?php echo $row1->FGLH_ID;?>|<?php echo $row1->FGLH_NAME;?>"><?php echo $row1->FGLH_NAME;?></option>
                       <?php } } ?>
                     </select>
                    </div>
                     <div class="control-group  col-lg-2 col-md-3 col-sm-6 col-xs-6" style="margin-top: 1.7em; margin-left: 13.5em;">               
                        <div class="input-group input-group-sm ">
                            <input type="hidden" name="date" value="<?=@$date; ?>" id="date" value="" >
                            <input type="hidden" name="load" id="load" value="">
                            <input autocomplete="" name= "todayDate" id="todayDate" type="text" value="<?=date('d-m-Y'); ?>" class="form-control todayDate2 "  onchange="GetDataOnDate(this.value)" placeholder="dd-mm-yyyy" readonly = "readonly" />
                            <div class="input-group-btn">
                                <button class="btn btn-default todayDate" type="button">
                                    <i class="glyphicon glyphicon-calendar"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                  </div>
                    <div class="row form-group" style = "padding-top:15px;">
                        <div class="control-group col-md-3 col-lg-2 col-sm-4 col-xs-6">
                            <label>Assign Committee: <span style="color:#800000;">*</span></label>
                        </div>
                        <div class="control-group col-md-3 col-lg-2 col-sm-4 col-xs-6">
                            <select id="Committee" name="Committee" class="form-control" style="margin-left: -50px; width: 225px;"><!-- height: 30px; width: 200px; -->
                                    <option value="" style="width: 300px;">Select Committee</option>
                                    <?php   if(!empty($committee)) {
                                        foreach($committee as $row1) { ?> 
                                            <option value="<?php echo $row1->COMP_ID;?>"><?php echo $row1->COMP_NAME;?></option>
                                        <?php } } ?>
                            </select>
                        </div>
                        <div class="control-group col-lg-2 col-md-2 col-sm-12 col-xs-6">
                           <input style="width:147px;margin-left: -10px;" type="number" class="form-control" name="committeeOpAmt" id="committeeOpAmt" placeholder="Opening Balance" autocomplete="off" min="0">
                           <a onClick="addRow1()"> <img style="width:24px; height:24px ;margin-top: -28px; margin-left: -35px; " class="img-responsive pull-right" title="Add Committee" src="<?=site_url();?>images/add.svg"> </a>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="table-responsive col-lg-6 col-md-2 col-sm-12 col-xs-6">              
                        <table id="addCommittee" class="table table-bordered table-hover">
                                    <thead>
                                      <tr>
                                        <th style="width: 1%">SI.NO</th>
                                        <th style="width: 10%" id="committeeName" name="committeeName">Committee Name</th>
                                        <th style="width: 5%">OP Bal</th>
                                        <th style="width: 1%">Operation</th>
                                    </tr>
                                    </thead>
                                  <tbody id="eventUpdate">
                                </tbody>
                             </table>
                        </div>
                    </div>

                    <div class="row form-group" >
                        <div class="control-group col-lg-6 col-md-12 col-sm-12 col-xs-12" >
                            <label for="comment">Narration </label>
                            <textarea class="form-control" rows="5" name="naration" id="naration"onkeyup="alphaonly(this)" placeholder="" style="height:100%;resize:none;"></textarea>
                         </div>
                     </div>
                   <div class="row form-group">
                      <div class="control-group col-md-6 col-lg-6 col-sm-6 col-xs-12" >
                      <input type="button" class="btn btn-default btn-md custom" value="Submit" onclick="validateSubmit()">
                    </div>
                   </div>
                    
                </div>
            <input type="hidden" id="committee1" name="committee1"  value="" />
            <input type="hidden" id="committeeOpBal1" name="committeeOpBal1"  value="" />                
    </form>
</div>
<div class="modal fade bs-example-modal-lg" tabindex="-1"id="opBalModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Opening Balance Preview</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer text-left" style="text-align:left;">
        <label>Are you sure you want to save..?</label>
        <!-- <h5>Are You Sure ?</h5> --><br/>
        <button type="button" style="width: 8%;" class="btn " onclick="document.getElementById('frmOp').submit();">Yes</button>
        <button type="button" style="width: 8%;" class="btn " data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

  function validateSubmit() {
    let count = 0;
    let led = $('#led').val().split("|");
    let opAmt = $('#opAmt').val();
    let todayDate = $('#todayDate').val();
    let naration=$('#naration').val();  
    let url = "<?=site_url()?>finance/addOpeningBal";
    if( led == "" || opAmt == "" || todayDate == ""){    
      alert("Please Fill Required Fields");
      return;
    }

    //TO ASSIGN COMMITTEE
    document.getElementById('committee1').value = "";
    let committeeId = document.getElementsByClassName('committeeId');
    let committeeName = document.getElementsByClassName('Committee');
    let committeeOp = document.getElementsByClassName('ComOpAmt');

    let committeeIdVal = [];
    let committeeOpVal = [];
    let opTotal=0;
    let selcommitteeName = "";
    for (let i = 0; i < committeeId.length; ++i) {
        committeeIdVal[i] = committeeId[i].innerHTML.trim();
        committeeOpVal[i] = committeeOp[i].innerHTML.trim();
        selcommitteeName += committeeName[i].innerHTML.trim() + " ";
        opTotal += parseInt(committeeOp[i].innerHTML.trim());

    }
    document.getElementById('committee1').value = committeeIdVal;
    document.getElementById('committeeOpBal1').value = committeeOpVal;
    
    opAmt = opTotal;
    //END ASSIGN COMMITTEE

    if (document.getElementById("led").value != "") {
      $('#led').css('border-color', "#000000");
    } else {
      $('#led').css('border-color', "#FF0000");
     ++count;
    }
    if (count != 0) {
      alert("Information", "Please fill required fields", "OK");
      return false;
    }

    if (document.getElementById("committee1").value == "") {
      alert("Information", "Please Assign Committee ", "OK");
      return false;
    }

    $("#opBalModal").modal();
    $('.modal-body').append("<label>DATE:</label> " + todayDate + "<br/>");
    if(led)
      $('.modal-body').append("<label>LEDGER NAME:</label> " + led[1] + "<br/>");
    if (selcommitteeName) 
        $('.modal-body').append("<label>COMMITTEE:</label>"+ selcommitteeName +" <br/>");
    if(opAmt)
      $('.modal-body').append("<label>OPENING BALANCE AMOUNT:</label> " + opAmt + "<br/>");
    if (naration) 
          $('.modal-body').append("<label>NARRATION:</label> " + naration + "<br/>");

    $(".modal").on("hidden.bs.modal", function(){
        $(".modal-body").html("");
    });
  
  }
     function alphaonly(input) {
      var regex=/[^-a-z-0-9 ]/gi;
      input.value=input.value.replace(regex,"");
    }
  function GetDataOnDate() {
      }

  var currentTime = new Date();
  var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
  var maxDate =  new Date(); // one day before next month
  $( ".todayDate2" ).datepicker({ 
      'yearRange': "2007:+50",
      dateFormat: 'dd-mm-yy',
      changeMonth:true,
      changeYear:true
  });

  $('.todayDate').on('click', function() {
      $( ".todayDate2" ).focus();
  })

  function addRow1() {
   var count = 0;

    if(document.getElementById("Committee").value != "") {
        $('#Committee').css('border-color', "#000000");
    } else {
        $('#Committee').css('border-color', "#FF0000");
        ++count;
    }
    if(document.getElementById("committeeOpAmt").value != "") {
        $('#committeeOpAmt').css('border-color', "#000000");
    } else {
        $('#committeeOpAmt').css('border-color', "#FF0000");
        ++count;
    }

    if(count != 0) {
        alert("Information","Please fill required fields","OK");
    }else{
        let Committee = $('#Committee option:selected').html();
        let committeeOpAmt = $('#committeeOpAmt').val();
        let ledId = $('#Committee').val().split("|");
          let flag=0;
         $(".committeeIdCheck").each(function() {
            if(ledId[0]==this.id)
                flag++; 
        });
        if(flag!=0){
            alert("Information","Already Exist,Please Select Other Committee");
            return;
        }

            let si = $('#addCommittee tr:last-child td:first-child').html();
            if (!si)
                si = 1
            else
                ++si;
            $('#addCommittee').append('<tr class="' + si + ' si1"><td class="si">' + si + '</td><td class="committeeId committeeIdCheck" id="' + ledId[0] + '" style="display:none">' + ledId[0] + '</td><td class="Committee">' + Committee + '</td><td class="ComOpAmt">' + committeeOpAmt + '</td><td class="link1"><a style="cursor:pointer;" onClick="updateTable1(' + si + ');"><img style="width:24px; height:24px;" title="delete" src="<?=base_url()?>images/delete1.svg"></a></td></tr>');
            $('#committeeOpAmt').val("");
            $('#Committee').val("");
    }
}
function updateTable1(si) {
        if(si != 0) {
            let si1 = document.getElementsByClassName(si);
            si1[0].remove();
        }
        for (let i = 0; i < tableValues['addCommittee'].length; ++i) {
            tableValues['si'][i].innerHTML = (i + 1);
            tableValues['link1'][i].innerHTML = '<a style="cursor:pointer;" onClick="updateTable1(' + (i + 1) + ');"><img style="width:24px; height:24px;" title="delete" src="<?=base_url()?>images/delete1.svg"></a>';
            tableValues['si1'][i].className = (i + 1) + " si1";
        }
    }

</script>
