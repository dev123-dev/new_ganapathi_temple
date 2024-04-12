<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<link href="https://cdn.rawgit.com/dubrox/Multiple-Dates-Picker-for-jQuery-UI/master/jquery-ui.multidatespicker.css" rel="stylesheet"/>
	<link href="https://code.jquery.com/ui/1.12.1/themes/pepper-grinder/jquery-ui.css" rel="stylesheet"/>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
	<script src="https://cdn.rawgit.com/dubrox/Multiple-Dates-Picker-for-jQuery-UI/master/jquery-ui.multidatespicker.js"></script>
	
  <style>
	.marginBottom-0 {margin-bottom:0;}
	.dropdown-submenu{position:relative;}
	.dropdown-submenu>.dropdown-menu{top:0;left:100%;margin-top:-6px;margin-left:-1px;-webkit-border-radius:0 6px 6px 6px;-moz-border-radius:0 6px 6px 		6px;border-radius:0 6px 6px 6px;}
	.dropdown-submenu>a:after{display:block;content:" ";float:right;width:0;height:0;border-color:transparent;border-style:solid;border-width:5px 0 5px 5px;border-left-color:#cccccc;margin-top:5px;margin-right:-10px;}
	.dropdown-submenu:hover>a:after{border-left-color:#555;}
	.dropdown-submenu.pull-left{float:none;}.dropdown-submenu.pull-left>.dropdown-menu{left:-100%;margin-left:10px;-webkit-border-radius:6px 0 6px 6px;-moz-border-radius:6px 0 6px 6px;border-radius:6px 0 6px 6px;}

	.bgImg2{
    max-height:80vmin;
	 margin: auto; 
	 position:fixed;
	 left:0;
	 right:0;
	 margin-left:auto;
	 margin-right:auto;
	 z-index:-2;
	}

	.ui-datepicker {
    background: #FFFFFF;
    border: 1px solid #000000;
    color: #000000;
	}
	
}

  </style>
</head>
  
<body style="background-color:#F1C40F;" name="bodyname" id="bodyId">
	<nav class="navbar navbar-inverse navbar-static-top marginBottom-0" role="navigation">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		  <a class="navbar-brand" href="#" target="_blank">Temple</a>
		</div>
		
		<div class="collapse navbar-collapse" id="navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Seva's Today<b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Lakshmi Venkatesha</a>
							<ul class="dropdown-menu">
								<li><a href="#" >Panchamratha Abhisheka</a></li>
								<li><a href="#" >Ksheerabhisheka</a></li>
								<li><a href="#" >Pulukabhisheka</a></li>
								<li><a href="#" >Gangajalabhisheka</a></li>
							</ul>
						</li>
						<li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Lakshmi Devi</a>
							<ul class="dropdown-menu">
								<li><a href="#" >Pulukabhisheka</a></li>
								<li><a href="#" >Kumkumarchana </a></li>
								<li><a href="#" >Sri Saptashathi Parayana </a></li>
								<li><a href="#" >Whole day Seva</a></li>
							</ul>
						</li>
						<li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Mukhya Prana</a>
							<ul class="dropdown-menu">
								<li><a href="#" >Pavamana Abhisheka</a></li>
								<li><a href="#" >Rudrabhisheka</a></li>
							</ul>
						</li>
						<li class="dropdown dropdown-submenu"><a  href="#" class="dropdown-toggle" data-toggle="dropdown">Garuda Venkatesh</a>
							<ul class="dropdown-menu">
								<li><a href="#" >Astothara Pooja</a></li>
								<li><a href="#" >Sukrunde Naivedya</a></li>
							</ul>
						</li>
						<li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown" > MahaGanapathi</a>
							<ul class="dropdown-menu">
								<li><a href="#" >Durvarchana</a></li>
								<li><a href="#" >Apupa Naivedya</a></li>
							</ul>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
	
	<div class="container">
	
	 <img id="img1" class="bgImg2" src="<?=base_url()?>images/TempleLogo.png" />
	 <img id="img2" class="img-responsive bgImg2" style="display:none;" src="<?=base_url()?>images/03-LAKSHMI.jpg" />
	 <img id="img3" class="img-responsive bgImg2" style="display:none;" src="<?=base_url()?>images/04-HANUMANTHA.jpg" />
	 <img id="img4" class="img-responsive bgImg2" style="display:none;" src="<?=base_url()?>images/05-GARUDA.jpg" />
	 <img id="img5" class="img-responsive bgImg2" style="display:none;" src="<?=base_url()?>images/06-GANAPATHI.jpg" />
	 	 
	  <ul>
	  <li  class="radio-default" style=" list-style:none;">
		
		<input type="radio" id="f-option" name="selector" onChange="myFunction()">
				
		<label for="f-option"> <?php echo 'Today(' . date('d/m/Y'); ?>) </label>
		
		<div class="check"><div class="inside"></div></div>
	  </li>
	  
	  <li style=" list-style:none;">
		<input type="radio" id="datepicker" name="selector" onChange="Multidate()">
		
		<label for="s-option">Multiple Dates</label>
		<div class="check"><div class="inside"></div></div>
	  </li>
	  
	  <li style=" list-style:none;">
		<input type="radio" id="t-option" name="selector" onChange="DateRange()">
		<label for="t-option" >Every </label>
		
		
		<select class="form-control" id="SelectOpt" style="width:100px;margin-top:-25px;margin-left:95px;"
		onChange="DateSelect()">
			<option>Day</option>
			<option>Week</option>
			<option>Month</option>
		</select>
		
		<select class="form-control" id="WeekDays" style="width:100px;margin-top:-35px;margin-left:250px;">
			<option>Monday</option>
			<option>Tuesday</option>
			<option>Wednesday</option>
			<option>Thursday</option>
			<option>Friday</option>
			<option>Saturday</option>
			<option>Sunday</option>
		</select>
		
		<select class="form-control" id="MnthDay" style="width:100px;margin-top:-35px;margin-left:250px;">
			<option>1</option>
			<option>2</option>
			<option>3</option>
			<option>4</option>
			<option>5</option>
			<option>6</option>
			<option>7</option>
			<option>8</option>
			<option>9</option>
			<option>10</option>
			<option>11</option>
			<option>12</option>
			<option>13</option>
			<option>14</option>
			<option>15</option>
			<option>16</option>
			<option>17</option>
			<option>18</option>
			<option>19</option>
			<option>20</option>
			<option>21</option>
			<option>22</option>
			<option>23</option>
			<option>24</option>
			<option>25</option>
			<option>26</option>
			<option>27</option>
			<option>28</option>
			<option>29</option>
			<option>30</option>
			<option>31</option>
		</select>
	  </li>
	</ul>
	
				
		<br/><br/>
		<label id="lblfrom">from</label>&nbsp;<input id="from"/>
		&nbsp;&nbsp;<label id="lblto">till</label>&nbsp;<input id="to"/>
			
		<br/><br/><br/><br/>
			
			<div >
				
				
				<label>Deity:</label>
				<select name="Deity" class="form-control" id="DietyName" style="width:170px;margin-top:-15px;display:inline-block;">
				
				<?php 
				
					$j = 0;
					foreach($result as $category => $value) 
					{
					   $Allcategory = $result[$j]->DEITY_NAME . "|" . $result[$j]->DEITY_ID . "|" . $result[$j]->SEVA;  
					   
					   $category = $result[$j]->DEITY_NAME; 
					   $id = $result[$j]->DEITY_ID; 		
					   
					   echo '<option value="'. $Allcategory .'">'. $category .'</option>';
					   $j++;
					}
				?>
				</select>

				<label>Seva:</label>
				<select class="form-control" id="DietySeva" style="width:150px;display:inline-block;" >
				</select>
				
			</div>
			
		
		<div class="check"><div class="inside"></div></div>
	</div>
	
	<div class="Container Disp" id="display">
		<p id="displayPanel" > </p>
	</div>
	
	
	<!--<div class="Container Disp" id="display" style="background-color:#000000;">-->
	
	<div class="Container Disp" id="display">
		<p id="displayPanel12" > </p>
	</div>
	
	
	<select name="DeityTest" class="form-control" id="DietyNameTest" style="width:170px;margin-top:-15px;visibility:hidden;">
			<?php 
			
				$j = 0;
				foreach($result as $category => $value) 
				{
				   $Allcategory = $result[$j]->DEITY_NAME . "|" . $result[$j]->DEITY_ID . "|" . $result[$j]->SEVA;  //scroipt var = a = $('#sdf').val(); var arraytest = a.split("|"); arraytest[0] //htmlspecialchars($category); 
				   
				   $category = $result[$j]->DEITY_NAME; 
				   $id = $result[$j]->DEITY_ID; 		//htmlspecialchars($category); 
				   
				   echo '<option value="'. $Allcategory .'">'. $category .'</option>';
				   $j++;
				}
			?>
			
		</select>
	
	
	<label>Mode Of Payment:</label><select id="ModeOfPayment">
		<option>Cash</option>
		<option>Credit/Debit Card</option>
		<option>Cheque</option>
		<option>Direct Credit</option>
	</select><br/><br/>
	
	<label id="lblChequeNo" style="visibility:hidden;">Cheque No:</label><input id="txtChequeNo" style="visibility:hidden;"/>&nbsp;&nbsp;<label id="lblChequeDate" style="visibility:hidden;">Cheque Date:</label><input id="txtChequeDate" style="visibility:hidden;"/><br/><br/>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label id="lblBank" style="visibility:hidden;">Bank:</label>&nbsp;<input style="visibility:hidden;" id="txtBank"/>&nbsp;&nbsp;<label id="lblBranch" style="visibility:hidden;">Branch:</label><input style="visibility:hidden;" id="txtBranch"/>
	
	<!--<a href="<?php echo site_url() ?>Example"><input type="submit" name="Back" onclick="location.href = 'Example.php';"></a>-->
	
	<a href="<?php echo site_url() ?>InkindReceipt"><input type="submit" name="Back" value="Inkind Receipt" onclick="location.href = 'InkindReceipt.php';"></a>
	
	
	
</body>
</html>

<script>

 
 
				$('#ModeOfPayment').on('change', function () {
					
					if($("#ModeOfPayment option:selected").text() == "Cheque")
					{
						
						$('#lblChequeDate').css({'visibility':'visible'});
						$('#txtChequeDate').css({'visibility':'visible'});
						$('#txtChequeNo').css({'visibility':'visible'});
						$('#lblChequeNo').css({'visibility':'visible'});
						$('#lblBank').css({'visibility':'visible'});
						$('#txtBank').css({'visibility':'visible'});
						$('#lblBranch').css({'visibility':'visible'});
						$('#txtBranch').css({'visibility':'visible'});
					}
					else{
						
						$('#lblChequeDate').css({'visibility':'hidden'});
						$('#txtChequeDate').css({'visibility':'hidden'});
						$('#txtChequeNo').css({'visibility':'hidden'});
						$('#lblChequeNo').css({'visibility':'hidden'});
						$('#lblBank').css({'visibility':'hidden'});
						$('#txtBank').css({'visibility':'hidden'});
						$('#lblBranch').css({'visibility':'hidden'});
						$('#txtBranch').css({'visibility':'hidden'});
					}
				});
 
				var code = {};
				$("select[name='Deity'] > option").each(function () {
					if(code[this.text]) {
						$(this).remove();
					} else {
						code[this.text] = this.value;
					}
				});

				
				var DName = "";
				$('#DietyNameTest option').each(function(){
						DName += $(this).val() + "&";
				});
				
				
				$('#DietyName').on('change', function () {
					
					 $('#DietySeva').empty(); 
					
					var ddl = DName.split("&");
					
					for (i = 0; i < ddl.length-1; i++) {
					
						var e = document.getElementById("DietyName");
						var strUser = e.options[e.selectedIndex].value;
					
						if(ddl[i].split("|")[0] == strUser.split("|")[0])
						 {
							  var opt = document.createElement("option");
        
							// Add an Option object to Drop Down/List Box
							document.getElementById("DietySeva").options.add(opt);
							// Assign text and value to Option object
							opt.text = ddl[i].split("|")[2];
							opt.value =ddl[i].split("|")[2];
						}
					}
					
					 if($("#DietyName option:selected").text() == "Shree Lakshmi Venkatesh")
					 {
						document.getElementById("img2").style.display = "none";
						document.getElementById("img3").style.display = "none";
						document.getElementById("img4").style.display = "none";
						document.getElementById("img1").style.display = "block";
						document.getElementById("img5").style.display = "none";
					 }
					 else if($("#DietyName option:selected").text() == "Shree Lakshmi devi")
					 {
						document.getElementById("img3").style.display = "none";
						document.getElementById("img4").style.display = "none";
						document.getElementById("img1").style.display = "none";					
						document.getElementById("img2").style.display = "block";					
						document.getElementById("img5").style.display = "none";
					}
					 else if($("#DietyName option:selected").text() == "Shree Mukhya Prana")
					 {
						document.getElementById("img1").style.display = "none";
						document.getElementById("img3").style.display = "block";
						document.getElementById("img4").style.display = "none";
						document.getElementById("img2").style.display = "none";					
						document.getElementById("img5").style.display = "none";
					 }
					 else if($("#DietyName option:selected").text() == "Shree Garuda Venkatesh")
					 {
						document.getElementById("img1").style.display = "none";
						document.getElementById("img2").style.display = "none";
						document.getElementById("img4").style.display = "block";
						document.getElementById("img3").style.display = "none";
						document.getElementById("img5").style.display = "none";
						
					}
					 else if($("#DietyName option:selected").text() == "Shree MahaGanapathi")
					 {
						document.getElementById("img1").style.display = "none";
						document.getElementById("img2").style.display = "none";
						document.getElementById("img3").style.display = "none";
						document.getElementById("img4").style.display = "none";
						document.getElementById("img5").style.display = "block";
						
						//document.body.style.backgroundImage = "url('<?php echo  base_url(); ?>images/06-GANAPATHI.jpg')";
						//document.getElementById("img1").style.display = "none";
						//document.body.style.maxHeight = 80vmin;
						//document.body.style.backgroundRepeat = "no-repeat";
						//document.body.style.backgroundPosition = "center";
					 }
					 
				});
				
				function GetControllerForGetSava()
				{
					var val = $('#DietyName option:selected').val();					
					
					location.href = '<?php echo site_url(); ?>TempleReceipt/GetSevas/' + val;
				}
				
				$(document).ready(function(){
					$('ul.dropdown-menu [data-toggle=dropdown]').on("click", function() {
					event.preventDefault(); 
					event.stopPropagation(); 
					$(this).parent().siblings().removeClass('open');
					$(this).parent().toggleClass('open');
				   });
				   
				   if(window.innerWidth > 668) {
					$( "ul.dropdown-menu [data-toggle=dropdown]" ).mouseover(function() {
					 event.preventDefault(); 
					 event.stopPropagation(); 
					 $(this).parent().siblings().removeClass('open');
					 $(this).parent().toggleClass('open');
					});
				   }
				});
				
				$('#WeekDays').css({'visibility':'hidden'});
				$('#MnthDay').css({'visibility':'hidden'});
				$('#from').css({'visibility':'hidden'});
				$('#to').css({'visibility':'hidden'});
				$('#lblfrom').css({'visibility':'hidden'});
				$('#lblto').css({'visibility':'hidden'});
				
				var currentTime = new Date()
				var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
				var maxDate =  new Date(currentTime.getFullYear(), currentTime.getMonth() +12, +0); // one day before next month
				$( "#from" ).datepicker({ 
				minDate: minDate, 
				maxDate: maxDate 
				});
				
				$( "#to" ).datepicker({ 
				minDate: minDate, 
				maxDate: maxDate 
				});
				
				
				$('#to').on('change', function () {
					
					var sDate1 = "";
					
				var start = $("#from").datepicker("getDate"),
					end = $("#to").datepicker("getDate"),
					currentDate = new Date(start),
					between = [];
		
					 
					if($("#SelectOpt option:selected").text() == "Week")
					{
							var weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];	
							
							while (currentDate <= end) {
						
							var btnDate = (currentDate).toLocaleDateString();
							
							var SelectedDay = new Date(btnDate);
							
							if(weekday[SelectedDay.getDay()] == $("#WeekDays option:selected").text()){
								between.push(new Date(currentDate).toLocaleDateString());	
							}
							
							currentDate.setDate(currentDate.getDate() + 1);
						}
						
						$('#displayPanel').html(between.join('<br/> '));
					}					
					else if ($("#SelectOpt option:selected").text() == "Day") 
					{
							while (currentDate <= end) {
						
							var btnDate = (currentDate).toLocaleDateString();
							
							var SelectedDay = new Date(btnDate);
							
							between.push(new Date(currentDate).toLocaleDateString());	
							
							currentDate.setDate(currentDate.getDate() + 1);
						}
						
						for(var i = 0; i < between.length; ++i) {
							sDate1 += between[i] + "<br/>";
						}
						
						$('#displayPanel').html(between.join('<br> '));
					}
					else if ($("#SelectOpt option:selected").text() == "Month") 
					{
						while (currentDate <= end) {
							
							var btnDate = (currentDate).toLocaleDateString();
							if(currentDate.getDate() == $("#MnthDay option:selected").text()){	
								between.push(new Date(currentDate).toLocaleDateString());	
							}
							currentDate.setDate(currentDate.getDate() + 1);
						}
						$('#displayPanel').html(between.join('<br> '));
					}
				
				});
		
			
				function DateRange(){
					$('#to').css({'visibility':'visible'});
					$('#from').css({'visibility':'visible'});
					$('#lblto').css({'visibility':'visible'});
					$('#lblfrom').css({'visibility':'visible'});
				
					var currentTime = new Date()
					var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
					var maxDate =  new Date(currentTime.getFullYear(), currentTime.getMonth() +12, +0); // one day before next month
					$( "#to" ).datepicker({ 
					minDate: minDate, 
					maxDate: maxDate 
					});
				
					document.getElementById("displayPanel").innerHTML="";
				}
			
				function Multidate() {
					document.getElementById("displayPanel").innerHTML="";
					 $('#to').val("");
					 $('#from').val("");
					$('#to').css({'visibility':'hidden'});
					$('#from').css({'visibility':'hidden'});
					$('#lblfrom').css({'visibility':'hidden'});
					$('#lblto').css({'visibility':'hidden'});
					
				}
	
				var currentTime = new Date()
				var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), + currentTime.getDate()); //one day next before month
				var maxDate =  new Date(currentTime.getFullYear(), currentTime.getMonth() +12, +0); // one day before next month
				$( "#datepicker" ).datepicker({ 
				minDate: minDate, 
				maxDate: maxDate 
				});

				$( "#to" ).datepicker({ 
				minDate: minDate, 
				maxDate: maxDate 
				});	
				
				$( "#from" ).datepicker({ 
				minDate: minDate, 
				maxDate: maxDate 
				});
				
				var sDate1 = "";
				var array = [];
				
				$("#datepicker").multiDatesPicker({
					onSelect: function (selectedDate) {
						var sDate1 = "";
						var arrayResult = [];
						
						document.getElementById("displayPanel").innerHTML  = "";
						
						if(array.includes(selectedDate))
						{
							item2 = [];
							for(var i = 0; i < array.length; ++i) {
								if(array[i] != selectedDate) {
									item2.push(array[i]);
								}
							}
							array = item2;
						}
						else {
							array.push(selectedDate);
							array.sort();
						}
						
						for(var i = 0; i < array.length; ++i) {
							sDate1 += array[i] + "<br/>";
						}
						
						document.getElementById("displayPanel").innerHTML  = sDate1;
						
						document.getElementById("displayPanel").style.fontWeight = "bold";
						
					}
				});
			
			
				function myFunction() {
					
				var today = new Date();
				var dd = today.getDate();
				var mm = today.getMonth()+1; //January is 0!

				var yyyy = today.getFullYear();
				if(dd<10){
					dd='0'+dd;
				} 
				if(mm<10){
					mm='0'+mm;
				} 
				var today = dd+'/'+mm+'/'+yyyy;
				
				document.getElementById("displayPanel").innerHTML = today
			
				document.getElementById("displayPanel").style.fontWeight = "bold";
									
					$('#to').val("");
					$('#from').val("");
					$('#to').css({'visibility':'hidden'});
					$('#from').css({'visibility':'hidden'});
					$('#lblto').css({'visibility':'hidden'});
					$('#lblfrom').css({'visibility':'hidden'});
				}

				 $("input[id='f-option']").click(function() {
				  				  
				  ('.displayPanel').text('Today');
				});
	
			function DateSelect() {
				
				document.getElementById("displayPanel").innerHTML="";
				$('#to').val("");
				$('#from').val("");
				
				switch($("#SelectOpt option:selected").text())
				{
					case 'Day':
								$('#WeekDays').css({'visibility':'hidden'});
								$('#MnthDay').css({'visibility':'hidden'});
								break;
					case 'Week':
								$('#WeekDays').css({'visibility':'visible'});
								$('#MnthDay').css({'visibility':'hidden'});
								break;
					case 'Month':
								$('#WeekDays').css({'visibility':'hidden'});
								$('#MnthDay').css({'visibility':'visible'});
							break;
				}
			}
			
</script>