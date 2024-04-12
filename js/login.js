document.getElementById("modalLoader").style.display = "none";

$('.log').click(function() {
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
	  }else {
		  $('#invalidloader').html("");
	  }
	  
	  if(!password) {
		  document.getElementById("errorPassword").style.display = "block";
		  ++count;
	  }else {
		  $('#invalidloader').html("");
	  }
	  
	  if(count == 0) {
			$("#login").css('pointer-events', 'none');
			$("#disableBtn").css('pointer-events', 'none');
		  document.getElementById("modalLoader").style.display = "block";
		  
		  $.ajax(
		   {
			   url: "login/checkForUser",
			   data: {username: username, password: password},
			   type: 'POST',
			   async: false
		   })
		   .done(function(response) 
		   {
			   if(response == "success") {
				   location.href = "Events"; 
				
			  }else {
				   $("#login").css('pointer-events', 'auto');
				   $("#disableBtn").css('pointer-events', 'auto');
					document.getElementById("modalLoader").style.display = "none";
				  $('#invalidloader').html('Invalid Username or Password');
				  $('#myModal').shake("fast");
			  }
		   })
		}
	}