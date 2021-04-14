// selects the content of an element. Receives the object with that element
function selectElmCnt(elm) {
  // for Internet Explorer
  if(document.body.createTextRange) {
    var range = document.body.createTextRange();
    range.moveToElementText(elm);
    range.select();
  }
  else if(window.getSelection) {
    // other browsers
    var selection = window.getSelection();
    var range = document.createRange();
    range.selectNodeContents(elm);
    selection.removeAllRanges();
    selection.addRange(range);
  }
}

function display_city_venue_form() {
	var city_id = document.getElementById("city_id").value;
	if (city_id !== 1) {
		var venue_id_element = document.getElementById("venue_id");
		if (venue_id_element != null) {
			var venue_id = document.getElementById("venue_id").value;
		}
	} else {
		var venue_id = 1;
	}
	var xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("city_venue_form").innerHTML=xmlhttp.responseText;
		}
	}
	var file = "index.php?special=edit_sub&city_id=" + city_id + "&venue_id=" + venue_id;
	xmlhttp.open("GET", file, true);
	xmlhttp.send();
}

function display_venue_new_form() {
	var city_id = document.getElementById("city_id").value;
	if (city_id == 1) {
		var venue_id = 1;
	} else {
		var venue_id_element = document.getElementById("venue_id");
		if (venue_id_element == null) {
			var venue_id = 0;
		} else {
			var venue_id = document.getElementById("venue_id").value;
		}
	}
	var xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		 document.getElementById("venue_new_form").innerHTML=xmlhttp.responseText;
	  }
	}
	var file = "index.php?special=edit_sub&venue_id=" + venue_id;
	xmlhttp.open("GET",file,true);
	xmlhttp.send();

	//Wenn noch keine URL angegeben ist, soll die Standard-URL einer Location eingesetzt werden,
	//insofern diese Vorhangen ist
	var url = document.getElementById("url").value;
	if ((url == '' || window.editurl == 0) && venue_id != 1 && venue_id != 0) {
		xmlhttp_url=new XMLHttpRequest();
		xmlhttp_url.onreadystatechange=function() {
		  if (xmlhttp_url.readyState==4 && xmlhttp_url.status==200) {
			 document.getElementById("url").value=xmlhttp_url.responseText;
		  }
		}
		var datei = "index.php?special=set_url&venue_id=" + venue_id;
		xmlhttp_url.open("GET",datei,true);
		xmlhttp_url.send();
	}
}

function get_band_select_options(row) {
	var first_sign = document.getElementById("first_sign_" + row).value;
	var band_id = document.getElementById("band_id_" + row).value;
	var xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		document.getElementById("band_id_" + row).innerHTML=xmlhttp.responseText;
		}
	  }
	var file = "index.php?special=lineup_sub&type=band_select_options&first_sign=" + first_sign + "&band_id=" +band_id;
	xmlhttp.open("GET",file , true);
	xmlhttp.send();
}

function get_band_new_form(row) {
	var band_id = document.getElementById("band_id_" + row).value;
	var xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		document.getElementById("band_new_form_" + row).innerHTML=xmlhttp.responseText;
		}
	  }
	var file = "index.php?special=lineup_sub&type=band_new_form&band_id=" + band_id + "&row=" + row;
	xmlhttp.open("GET", file, true);
	xmlhttp.send();
}

function set_band_lineup(row) {
	var xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("lineup").innerHTML=xmlhttp.responseText;
		}
	}
	var file = "index.php?special=lineup&type=add&row=" + row;
	xmlhttp.open("GET",file,true);
	xmlhttp.send();
}

function del_band_lineup(row) {
	var xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		document.getElementById("lineup").innerHTML=xmlhttp.responseText;
		}
	  }
	var file = "index.php?special=lineup&type=del&row=" + row;
	xmlhttp.open("GET",file,true);
	xmlhttp.send();
}


function shift_band_lineup(row, direction) {
	var xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
    		document.getElementById("lineup").innerHTML=xmlhttp.responseText;
    	}
  	}
	var file = "index.php?special=lineup&type=shift&row=" + row + "&direction=" + direction;
	xmlhttp.open("GET",file,true);
	xmlhttp.send();
}

function save_band_lineup(row, field) {
	var value = document.getElementById(field + "_" + row).value;
	value=encodeURIComponent(value);
	var xmlhttp=new XMLHttpRequest();
	var file = "index.php?special=lineup&type=save&row=" + row + "&field=" + field + "&value=" + value;
	xmlhttp.open("GET", file,true);
	xmlhttp.send();
}

function display_concert(concert_id, concert_status) {
	var xmlhttp=new XMLHttpRequest();
    var concert_low = document.getElementById("concert_low_" + concert_id);
    var concert_high = document.getElementById("concert_high_" + concert_id);
    var image = document.getElementById("image_" + concert_id);
    if (concert_low.innerHTML === "") {
        xmlhttp.onreadystatechange=function() {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                document.getElementById("concert_low_" + concert_id).innerHTML=xmlhttp.responseText;
            }
        }
        var file = "index.php?display=concert&display_id=" + concert_id;
        xmlhttp.open("GET",file,true);
        xmlhttp.send();
        image.src = "images/minus_small.png";
        concert_high.className = "concert_high_opened concert_" + concert_status;
        concert_low.className = "concert_low_opened concert_" + concert_status;
    } else {
        concert_low.innerHTML = "";
        image.src = "images/plus_small.png";
        concert_high.className = "concert_high_closed concert_" + concert_status;
        concert_low.className = "concert_low_closed concert_" + concert_status;
    }
}
