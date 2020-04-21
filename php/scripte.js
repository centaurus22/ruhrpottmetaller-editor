function init()
{
	window.editurl=0;
}

function get_locations_1()
{
var stadt_id = document.getElementById("stadt_id").value;
xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("locationwahl1").innerHTML=xmlhttp.responseText;
    }
  }
var datei = "get_location1.php?stadt_id=" + stadt_id;
xmlhttp.open("GET",datei,true);
xmlhttp.send();
}

function get_locations_2()
{
	var location_id = document.getElementById("location_id").value;
	var stadt_id = document.getElementById("stadt_id").value;
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()
	{
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	  {
		 document.getElementById("locationwahl2").innerHTML=xmlhttp.responseText;
	  }
	}
	var datei = "get_location2.php?stadt_id=" + stadt_id + "&location_id=" + location_id;
	xmlhttp.open("GET",datei,true);
	xmlhttp.send();

	/*Wenn noch keine URL angegeben ist, soll die Standard-URL einer Location eingesetzt werden,
	insofern diese Vorhangen ist*/
	var url = document.getElementById("url").value;
	if ((url == '' || window.editurl == 0) && location_id != "n")
	{
		xmlhttp_url=new XMLHttpRequest();
		xmlhttp_url.onreadystatechange=function()
		{
		  if (xmlhttp_url.readyState==4 && xmlhttp_url.status==200)
		  {
			 document.getElementById("url").value=xmlhttp_url.responseText;
		  }
		}
		var datei = "get_url.php?location_id=" + location_id;
		xmlhttp_url.open("GET",datei,true);
		xmlhttp_url.send();
	}
}


function get_band_1(zeile)
{
var anfang = document.getElementById("anfang_" + zeile).value;
xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("band_id_" + zeile).innerHTML=xmlhttp.responseText;
    }
  }
var datei = "get_band.php?anfang=" + anfang + "&zeile=" + zeile;
xmlhttp.open("GET",datei,true);
xmlhttp.send();
}

function get_band_2(zeile)
{
	var band_id  = document.getElementById("band_id_" + zeile).value;
	if (band_id == "n")
	{
		document.getElementById("band_" + zeile).innerHTML="<input class='inputbox' type='text' id='neue_band_" + zeile + "' name='band_" + zeile + "' onchange='save(\"neue_band\",\"" + zeile + "\")' />";
	}
	else
	{
		document.getElementById("band_" + zeile).innerHTML="";
	}
	xmlhttp=new XMLHttpRequest();
	var datei = "save.php?zeile=" + zeile + "&feld=band_id&wert=" + band_id;
	xmlhttp.open("GET",datei,true);
	xmlhttp.send();
}

function edit_url()
{
	window.editurl = 1;
}

function add_band(zeile)
{
xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("lineup").innerHTML=xmlhttp.responseText;
    }
  }
var datei = "add_band.php?zeile=" + zeile;
xmlhttp.open("GET",datei,true);
xmlhttp.send();
}

function del_band(zeile)
{
xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("lineup").innerHTML=xmlhttp.responseText;
    }
  }
var datei = "del_band.php?zeile=" + zeile;
xmlhttp.open("GET",datei,true);
xmlhttp.send();
}


function shiftup_band(zeile)
{
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()
  	{
  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
    	{
    		document.getElementById("lineup").innerHTML=xmlhttp.responseText;
    	}
  	}
	var datei = "shift_band.php?zeile=" + zeile + "&direction=up";
	xmlhttp.open("GET",datei,true);
	xmlhttp.send();
}

function shiftdown_band(zeile)
{
xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("lineup").innerHTML=xmlhttp.responseText;
    }
  }
var datei = "shift_band.php?zeile=" + zeile + "&direction=down";
xmlhttp.open("GET",datei,true);
xmlhttp.send();
}

function save(feld, zeile)
{
	var wert = document.getElementById(feld + "_" + zeile).value;
	wert=encodeURIComponent(wert);
	xmlhttp=new XMLHttpRequest();
	var datei = "save.php?zeile=" + zeile + "&feld=" + feld + "&wert=" + wert;
	xmlhttp.open("GET",datei,true);
	xmlhttp.send();
}

function show_message(event_id)
{
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()
  	{
  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
    	{
    	document.getElementById("event_" + event_id).innerHTML=xmlhttp.responseText;
    	}
  	}
	var datei = "show_message.php?event_id=" + event_id;
	xmlhttp.open("GET",datei,true);
	xmlhttp.send();
}

function get_band_table()
{
	var anfang = document.getElementById("band_anfang").value;
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		document.getElementById("data").innerHTML=xmlhttp.responseText;
		}
	  }
	var datei = "get_band_table.php?anfang=" + anfang;
	xmlhttp.open("GET",datei,true);
	xmlhttp.send();
}

function datenuebernahme(pos, edit_id)
{
	var feld_id = pos + "_" + edit_id;
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()
  	{
  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
    	{
    		document.getElementById(feld_id).innerHTML=xmlhttp.responseText;
    	}
  	}
	var datei = "daten_uebernahme.php?pos=" + pos + "&edit_id=" + edit_id;
	xmlhttp.open("GET", datei, true);
	xmlhttp.send();
}

function band_uebernahme(pos, band_id, edit_id)
{
	var feld_id = "band_" + pos + "_" + edit_id;
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()
  	{
  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
    	{
    		document.getElementById(feld_id).innerHTML=xmlhttp.responseText;
    	}
  	}
	var datei = "band_uebernahme.php?pos=" + pos + "&band_id=" + band_id + "&edit_id=" + edit_id;
	xmlhttp.open("GET", datei, true);
	xmlhttp.send();
}

function reset_aenderung(edit_id)
{
	var feld_id = "todo_" + edit_id;
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()
  	{
  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
    	{
    		document.getElementById(feld_id).innerHTML=xmlhttp.responseText;
    	}
  	}
	var datei = "reset_aenderung.php?edit_id=" + edit_id;
	xmlhttp.open("GET", datei, true);
	xmlhttp.send();
}

function loeschen_aenderung(edit_id)
{
	var feld_id = "todo_" + edit_id;
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()
  	{
  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
    		{
    			document.getElementById(feld_id).innerHTML=xmlhttp.responseText;
    		}
  	}
	var datei = "loeschen_aenderung.php?edit_id=" + edit_id;
	xmlhttp.open("GET", datei, true);
	xmlhttp.send();
}

function speichern_aenderung(edit_id)
{
	var feld_id = "todo_" + edit_id;
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()
  	{
  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
    		{
    			document.getElementById(feld_id).innerHTML=xmlhttp.responseText;
    		}
  	}
	var datei = "speichern_aenderung.php?edit_id=" + edit_id;
	xmlhttp.open("GET", datei, true);
	xmlhttp.send();
}

function edit_blog_entry(id)
{
	var nachricht_id = "nachricht_" + id;
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()
  	{
  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
    		{
    			document.getElementById(nachricht_id).innerHTML=xmlhttp.responseText;
    		}
  	}
	var datei = "edit_blog_entry.php?id=" + id;
	xmlhttp.open("GET", datei, true);
	xmlhttp.send();
}


function close_blog_entry(id)
{
	var nachricht_id = "nachricht_" + id;
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()
  	{
  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
    	{
    		document.getElementById(nachricht_id).innerHTML=xmlhttp.responseText;
    	}
  	}
	var datei = "blog_entry.php?id=" + id;
	xmlhttp.open("GET", datei, true);
	xmlhttp.send();
}

function save_blog_entry(id)
{
	var ueberschrift = document.getElementById('ueberschrift_' + id).value;
	var text = document.getElementById('text_' + id).value;
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()
  	{
  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
    		{
    			document.getElementById(nachricht_id).innerHTML=xmlhttp.responseText;
    		}
  	}
	var datei = "blog_entry.php?id=" + id + "&text=" + text + "&ueberschrift=" + ueberschrift;
	xmlhttp.open("GET", datei, true);
	xmlhttp.send();
}

function change_binary(table, field)
{
	xmlhttp=new XMLHttpRequest();
	var datei = "change_binary.php?table=" + table + "&field=" + field;
	xmlhttp.open("GET",datei,true);
	xmlhttp.send();
}

function change_binary_row(table, field, id)
{
	xmlhttp=new XMLHttpRequest();
	var datei = "change_binary_row.php?table=" + table + "&field=" + field + "&id=" +id;
	xmlhttp.open("GET",datei,true);
	xmlhttp.send();
}

function change_value(table, field)
{
        xmlhttp=new XMLHttpRequest();
        const data = new FormData();
        data.append("table", table);
        data.append("field", field);
        data.append("value_new", document.getElementById(field).value);
        xmlhttp.open("POST","change_value.php",true);
        xmlhttp.send(data);
}

function change_value_row(table, field, id)
{
	xmlhttp=new XMLHttpRequest();
	var value_new = document.getElementById(field + "_" +  id).value;
	var datei = "change_value_row.php?table=" + table + "&field=" + field + "&id=" + id + "&value_new=" + value_new;
	xmlhttp.open("GET",datei,true);
	xmlhttp.send();
}
