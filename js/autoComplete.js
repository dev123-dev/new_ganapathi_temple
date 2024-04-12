var dropdownRashi = $('#DropdownRashi');
//Down arrow key
var position;
//Up arrow key
var positionOne;
var listExists  = false;
$("#rashi").on("keyup",function(e){
	
    var base_url= $("#baseurl").val();

    if(e.keyCode === 40 && listExists){
            var nextSelection = dropdownRashi.find('li.newli.active').next('li');
            if(nextSelection.length > 0){
                dropdownRashi.find('li.active').removeClass('active');
                nextSelection.addClass('active');
                e.stopPropagation();
            }
            else{
                dropdownRashi.find('li.active').removeClass('active');
                dropdownRashi.find('li.newli:nth-child(1)').addClass('active');
                e.stopPropagation();
            }
            $('#rashi').val(dropdownRashi.find('li.active').text());
			//Scroll Code On Keyboard Down Arrow Key
			position = $('li.active').position();
			if(position.top > 380) {
				$(dropdownRashi)[0].scrollTop = $(dropdownRashi)[0].scrollTop + (100);
			}
            return;

    }
    if( e.keyCode === 38 && listExists){
        var nextSelection = dropdownRashi.find('li.newli.active').prev('li');
        if(nextSelection.length > 0){
            dropdownRashi.find('li.active').removeClass('active');
            nextSelection.addClass('active');            
            e.stopPropagation();
        }
        else{
            dropdownRashi.find('li.active').removeClass('active');
            dropdownRashi.find('li.newli:nth-child(1)').addClass('active');
            e.stopPropagation();
        }
        $('#rashi').val(dropdownRashi.find('li.active').text());
		//Scroll Code On Keyboard Up Arrow Key
		positionOne = $('li.active').position();
		if(positionOne.top < 1) {
			$(dropdownRashi)[0].scrollTop = $(dropdownRashi)[0].scrollTop - (100);
		}
        return;

    }
    if(e.keyCode == 13){
        var selectedLi = dropdownRashi.find('li.newli.active');
		getNakshatra(selectedLi[0].id);
        if(selectedLi && selectedLi.length > 0){
            $('#rashi').val(selectedLi.text());
            $('#DropdownRashi').hide();
			$("#myform").submit();
        }
		e.preventDefault();
		return false;
    } else {
		if($("#rashi").val() != "") {
			listExists = false;
			
			var response = $.ajax({
				type: "POST",
				url: base_url+"Receipt/getRashi",
				data: {
					keyword: $("#rashi").val()
				},
				dataType: "json",
				success: function (data) {
					if (data.length > 0) {
						$('#DropdownRashi').empty();
						$('#rashi').attr("data-toggle", "dropdown");
						$('#DropdownRashi').dropdown('toggle');
						$('#DropdownRashi').show();
					}
					else if (data.length == 0) {
						$('#rashi').attr("data-toggle", "");
						$('#DropdownRashi').html("");
						$('#DropdownRashi').hide();
					}
					for(let i = 0; i < data.length; ++i) {
						if (data.length >= 0) {
							//$('#DropdownRashi').append('<li id="" role="presentation" onClick="getNakshatra()" class="newli"><a>' + data[i]['RASHI_NAME'] + '</a></li>');
							$('#DropdownRashi').append('<li id="r'+ data[i]['RASHI_ID'] +'" role="presentation" onClick="getNakshatra('+ data[i]['RASHI_ID'] +')" class="newli"><a>' + data[i]['RASHI_NAME'] + '</a></li>');
							//alert(data[i]['RASHI_NAME'])
						}
					}
					listExists = true;
				}
			});
		} else {
			
			$('#rashi').attr("data-toggle", "");
			$('#dropdownRashi').hide();
		}
    }
    });


    $('ul.txtpin').on('click', 'li', function (e) {
        $('#rashi').val($(this).text());
		$('#DropdownRashi').hide();
       
    });




var nak = ""	
function getNakshatra(nak) {
	this.nak = nak;
}
	
//for nakshtra

var dropdownnakshatra = $('#Dropdownnakshatra');
//Down arrow key
var position;
//Up arrow key
var positionOne;
var listExists  = false;
$("#nakshatra").on("keyup", function(e){
    var base_url= $("#baseurl").val();
    if(e.keyCode === 40 && listExists){
            var nextSelection = dropdownnakshatra.find('li.newli.active').next('li');
            if(nextSelection.length > 0){
                dropdownnakshatra.find('li.active').removeClass('active');
                nextSelection.addClass('active');
                e.stopPropagation();
            }
            else{
                dropdownnakshatra.find('li.active').removeClass('active');
                dropdownnakshatra.find('li.newli:nth-child(1)').addClass('active');
                e.stopPropagation();
            }
            $('#nakshatra').val(dropdownnakshatra.find('li.active').text());
			//Scroll Code On Keyboard Down Arrow Key
			position = $('li.active').position();
			if(position.top > 380) {
				$(dropdownnakshatra)[0].scrollTop = $(dropdownnakshatra)[0].scrollTop + (100);
			}
            return;

    }
    if( e.keyCode === 38 && listExists){
        var nextSelection = dropdownnakshatra.find('li.newli.active').prev('li');
        if(nextSelection.length > 0){
            dropdownnakshatra.find('li.active').removeClass('active');
            nextSelection.addClass('active');            
            e.stopPropagation();
        }
        else{
            dropdownnakshatra.find('li.active').removeClass('active');
            dropdownnakshatra.find('li.newli:nth-child(1)').addClass('active');
            e.stopPropagation();
        }
        $('#nakshatra').val(dropdownnakshatra.find('li.active').text());
		//Scroll Code On Keyboard Up Arrow Key
		positionOne = $('li.active').position();
		if(positionOne.top < 1) {
			$(dropdownnakshatra)[0].scrollTop = $(dropdownnakshatra)[0].scrollTop - (100);
		}
        return;

    }
    if(e.keyCode == 13){
        console.log("Enter");
        var selectedLi = dropdownnakshatra.find('li.newli.active');
        console.log(selectedLi);
        if(selectedLi && selectedLi.length > 0){
            $('#nakshatra').val(selectedLi.text());
			$('#Dropdownnakshatra').hide();
        }
    }
    else {
		if($("#nakshatra").val() != "") {
			listExists = false;
			var response = $.ajax({
				type: "POST",
				url: base_url+"/Receipt/getNakshatra",
				data: {
					keyword: $("#nakshatra").val(), id: nak
				},
				dataType: "json",
				success: function (data) {
					if (data.length > 0) {
						$('#Dropdownnakshatra').empty();
						$('#nakshatra').attr("data-toggle", "dropdown");
						$('#Dropdownnakshatra').dropdown('toggle');
						$('#Dropdownnakshatra').show();
					}
					else if (data.length == 0) {
						$('#nakshatra').attr("data-toggle", "");
						$('#Dropdownnakshatra').html("");
						$('#Dropdownnakshatra').hide();
					}
					for(let i = 0; i < data.length; ++i) {
						if (data.length >= 0) {
							$('#Dropdownnakshatra').append('<li role="presentation" class="newli"><a>' + data[i]['NAKSHATRA_NAME'] + '</a></li>');
							//alert(data[i]['RASHI_NAME'])
						}
					}
					listExists = true;
				}
			});
		} else {
			$('#nakshatra').attr("data-toggle", "");
			$('#dropdownRashi').hide();
		}
    }
    });

    $('ul.txtpin1').on('click', 'li', function (e) {
        $('#nakshatra').val($(this).text());
		$('#Dropdownnakshatra').hide();
       
    });


	//FOR LEDGERS
	var dropdownLedgers = $('#DropdownLedgers');
	$("#nameL").on("keyup", function(e){
	var base_url= $("#baseurl").val();
		if($("#nameL").val() != "") {
			var response = $.ajax({
				type: "POST",
				url: base_url+"/Receipt/getLedgers",
				data: {
					keyword: $("#nameL").val()
				},
				dataType: "json",
				success: function (data) {
					if (data.length > 0) {
						$('#DropdownLedgers').empty();
						$('#nameL').attr("data-toggle", "dropdown");
						$('#DropdownLedgers').dropdown('toggle');
						$('#DropdownLedgers').show();
					}
					else if (data.length == 0) {
						$('#nameL').attr("data-toggle", "");
						$('#DropdownLedgers').html("");
						$('#DropdownLedgers').hide();
					}
					for(let i = 0; i < data.length; ++i) {
						if (data.length >= 0) {
							$('#DropdownLedgers').append('<li role="presentation" class="newli"><a>' + data[i]['FGLH_NAME'] + '</a></li>');
						}
					}
				}
			});
		} else {
			$('#nameL').attr("data-toggle", "");
			$('#DropdownLedgers').hide();
		}
	});

