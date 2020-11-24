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
	var datei = "index.php?special=lineup_sub&type=band_select_options&first_sign=" + first_sign + "&band_id=" +band_id;
	xmlhttp.open("GET",datei,true);
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
	var datei = "index.php?special=lineup&type=add&row=" + row;
	xmlhttp.open("GET",datei,true);
	xmlhttp.send();
}

function del_band_lineup(row) {
	var xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		document.getElementById("lineup").innerHTML=xmlhttp.responseText;
		}
	  }
	var datei = "index.php?special=lineup&type=del&row=" + row;
	xmlhttp.open("GET",datei,true);
	xmlhttp.send();
}


function shift_band_lineup(row, direction) {
	var xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
    		document.getElementById("lineup").innerHTML=xmlhttp.responseText;
    	}
  	}
	var datei = "index.php?special=lineup&type=shift&row=" + row + "&direction=" + direction;
	xmlhttp.open("GET",datei,true);
	xmlhttp.send();
}

function save_band_lineup(row, field)
{
	var value = document.getElementById(field + "_" + row).value;
	value=encodeURIComponent(value);
	var xmlhttp=new XMLHttpRequest();
	var datei = "index.php?special=lineup&type=save&row=" + row + "&field=" + field + "&value=" + value;
	xmlhttp.open("GET",datei,true);
	xmlhttp.send();
}

//Displays a window containing a concert export.
function display_concert(concert_id) {
	var xmlhttp=new XMLHttpRequest();
    var window = document.createElement("div");
    window.className = "window";
    window.id = "window_" + concert_id;
    var window_stack = document.getElementById("window_stack");
	xmlhttp.onreadystatechange=function() {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			window.innerHTML=xmlhttp.responseText;
            window_stack.appendChild(window);
		}
  	}
	var file = "index.php?display=concert&display_id=" + concert_id;
	xmlhttp.open("GET", file, true);
	xmlhttp.send();
}

//Remove a window containing a concert export by using the mouse
function remove_concert_mouse(concert_id) {
    var window = document.getElementById("window_" + concert_id);
    var window_stack = document.getElementById("window_stack");
    window_stack.removeChild(window);
}

//Remove a window containing a concert export by using the keyboard
function remove_concert_keyboard() {
    var keyCode = ('which' in event) ? event.which : event.keyCode;
    if (keyCode !== 27) {
        return;
    }
    var window_stack = document.getElementById("window_stack");
    if (window_stack === null) {
        return;
    }
    var window = window_stack.lastElementChild;
    if (window !== null) {
        window_stack.removeChild(window);
    }
}

function get_band_table() {
	var anfang = document.getElementById("band_anfang").value;
	var xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		document.getElementById("data").innerHTML=xmlhttp.responseText;
		}
	  }
	var datei = "get_band_table.php?anfang=" + anfang;
	xmlhttp.open("GET",datei,true);
	xmlhttp.send();
}

function datenuebernahme(pos, edit_id) {
	var feld_id = pos + "_" + edit_id;
	var xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
    		document.getElementById(feld_id).innerHTML=xmlhttp.responseText;
    	}
  	}
	var datei = "daten_uebernahme.php?pos=" + pos + "&edit_id=" + edit_id;
	xmlhttp.open("GET", datei, true);
	xmlhttp.send();
}

function band_uebernahme(pos, band_id, edit_id) {
	var feld_id = "band_" + pos + "_" + edit_id;
	var xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
    		document.getElementById(feld_id).innerHTML=xmlhttp.responseText;
    	}
  	}
	var datei = "band_uebernahme.php?pos=" + pos + "&band_id=" + band_id + "&edit_id=" + edit_id;
	xmlhttp.open("GET", datei, true);
	xmlhttp.send();
}

function reset_aenderung(edit_id) {
	var feld_id = "todo_" + edit_id;
	var xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
    		document.getElementById(feld_id).innerHTML=xmlhttp.responseText;
    	}
  	}
	var datei = "reset_aenderung.php?edit_id=" + edit_id;
	xmlhttp.open("GET", datei, true);
	xmlhttp.send();
}

function loeschen_aenderung(edit_id) {
	var feld_id = "todo_" + edit_id;
	var xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
    		document.getElementById(feld_id).innerHTML=xmlhttp.responseText;
    	}
  	}
	var datei = "loeschen_aenderung.php?edit_id=" + edit_id;
	xmlhttp.open("GET", datei, true);
	xmlhttp.send();
}

function speichern_aenderung(edit_id) {
	var feld_id = "todo_" + edit_id;
	var xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
    		document.getElementById(feld_id).innerHTML=xmlhttp.responseText;
    	}
  	}
	var datei = "speichern_aenderung.php?edit_id=" + edit_id;
	xmlhttp.open("GET", datei, true);
	xmlhttp.send();
}

function edit_blog_entry(id) {
	var nachricht_id = "nachricht_" + id;
	var xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
    		document.getElementById(nachricht_id).innerHTML=xmlhttp.responseText;
    	}
  	}
	var datei = "edit_blog_entry.php?id=" + id;
	xmlhttp.open("GET", datei, true);
	xmlhttp.send();
}


function close_blog_entry(id) {
	var nachricht_id = "nachricht_" + id;
	var xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
    		document.getElementById(nachricht_id).innerHTML=xmlhttp.responseText;
    	}
  	}
	var datei = "blog_entry.php?id=" + id;
	xmlhttp.open("GET", datei, true);
	xmlhttp.send();
}

function save_blog_entry(id) {
	var ueberschrift = document.getElementById('ueberschrift_' + id).value;
	var text = document.getElementById('text_' + id).value;
	var xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById(nachricht_id).innerHTML=xmlhttp.responseText;
		}
  	}
	var datei = "blog_entry.php?id=" + id + "&text=" + text + "&ueberschrift=" + ueberschrift;
	xmlhttp.open("GET", datei, true);
	xmlhttp.send();
}

function change_binary(table, field){
	var xmlhttp=new XMLHttpRequest();
	var datei = "change_binary.php?table=" + table + "&field=" + field;
	xmlhttp.open("GET",datei,true);
	xmlhttp.send();
}

function change_binary_row(table, field, id) {
	var xmlhttp=new XMLHttpRequest();
	var datei = "change_binary_row.php?table=" + table + "&field=" + field + "&id=" +id;
	xmlhttp.open("GET",datei,true);
	xmlhttp.send();
}

function change_value(table, field) {
        var xmlhttp=new XMLHttpRequest();
        const data = new FormData();
        data.append("table", table);
        data.append("field", field);
        data.append("value_new", document.getElementById(field).value);
        xmlhttp.open("POST","change_value.php",true);
        xmlhttp.send(data);
}

function change_value_row(table, field, id) {
	var xmlhttp=new XMLHttpRequest();
	var value_new = document.getElementById(field + "_" +  id).value;
	var datei = "change_value_row.php?table=" + table + "&field=" + field + "&id=" + id + "&value_new=" + value_new;
	xmlhttp.open("GET",datei,true);
	xmlhttp.send();
}
