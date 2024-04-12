<style>
	#errorUserName {width: 100%; font-size: 10px; color: red; position: absolute; top: 138px; display:none; }
	#errorPassword {width: 100%; font-size: 10px; color: red; position: absolute; top: 254px; display:none; }
	#invalidloader {width: 100%; font-size: 10px; color: red; }
</style>
<div class="container">
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog model_center" role="document">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" id="disableBtn" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><img src="<?php echo  base_url(); ?>images/close.png"></span></button>
					<center><h2 class="modal-title" id="myModalLabel"></h2></center>
					<br/>
					<form id="login" method="post" action="">
						<p class="invalidlogin" id="invalidloader"></p>   
						<div class="form-group form_top">
							<input type="text" name="username" id="username" class="form-control form_contct" value="" placeholder="" required>
							<span style="width:100%;font-size:10px;color:red" id="errorUserName">Username cannot be empty</span>	
							<label class="pop_up"><span class="label-content">Username *</span><br/></label>
						</div>
						<div class="modalLoader" id="modalLoader"></div>
                      
						<div class="form-group form_top">		
							<input name="password" id="password" type="password" class="form-control form_contct" placeholder="" required>
							<span style="width:100%;font-size:10px;color:red" id="errorPassword">Password cannot be empty</span>	
							<label class="pop_up">Password *</label>
						</div>
						<div style="text-align: center;visibility:hidden;" class="form-group form_top">
							<label style="clear:both;font-size: 12px;font-weight: 700;" class="checkbox-inline"><input style="margin-top: 13px;letter-spacing: 0.1em;font-style: italic;" name="trustLogin" id="trustLogin" type="checkbox" value="1"><span style="color: #c46207;text-transform: uppercase;">Login as Trust</span></label>
						</div>
						<div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 text-center">
							<input type="button" class="btn contact_reg" id="submit" value="SIGN IN" />
						</div>
					</form>
				</div>      
			</div>
		</div>
    </div>
	
</div> 
 <script>
	<!-- User Name Validation -->
	$('#username').keyup(function() {
		var $th = $(this);
		$th.val($th.val().replace(/[^A-Za-z]/g, function(str) { return '';} ) );
	});
	document.getElementById("modalLoader").style.display = "none";
	$('.log').click(function() {
		document.getElementById("errorUserName").style.display = "none";
		document.getElementById("errorPassword").style.display = "none";
		$('#invalidloader').html('');
		$('#username').val('');
		$('#password').val('');
	})
	
	$('.close').click(function() {
		document.getElementById("errorUserName").style.display = "none";
		document.getElementById("errorPassword").style.display = "none";
		$('#invalidloader').html('');
		$('#username').val('');
		$('#password').val('');
	})

	$(':input').on('keyup', function(e) {
		document.getElementById("errorUserName").style.display = "none";
		document.getElementById("errorPassword").style.display = "none";
		$('#invalidloader').html('');
		 var key = e.which || e.keyCode;
		if(key == 13) {
			validateSubmit();
		}
	});


	$('#submit').on('click', function() {
		validateSubmit();
	});
	  
	function validateSubmit() {
		let count = 0;
		let username = $('#username').val();
		let password = $('#password').val();
	  
		if(!username) {  
			document.getElementById("errorUserName").style.display = "block";
			++count;
		} else {
			$('#invalidloader').html("");
		}
	  
		if(!password) {
			document.getElementById("errorPassword").style.display = "block";
			++count;
		} else {
			$('#invalidloader').html("");
		}
	  
		if(count == 0) {
			$("#login").css('pointer-events', 'none');
			$("#disableBtn").css('pointer-events', 'none');
			document.getElementById("modalLoader").style.display = "block";
			
			let trustLogin = 0;
			if(document.getElementById('trustLogin').checked) {
				trustLogin = 1;
			}
		
			$.ajax({
			   url: "<?=site_url();?>login/checkForUser",
			   data: {username: username, password: password, trustLogin: trustLogin},
			   type: 'POST',
			   async: false
			})
			
		   .done(function(response) {
				var res = response.split("#");
				if(res[0] == "success") {
					location.href = "<?=base_url()?>"+res[1]; 
				} else {
					$("#login").css('pointer-events', 'auto');
					$("#disableBtn").css('pointer-events', 'auto');
					document.getElementById("modalLoader").style.display = "none";
					$('#invalidloader').html('Invalid Username or Password');
					$('#myModal').shake("fast");
				}
		   })
		}
	}
</script>