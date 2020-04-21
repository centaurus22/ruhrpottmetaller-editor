<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

error_reporting(E_ALL|E_STRICT|E_WARNING|E_NOTICE);
ini_set('display_errors', 1);
date_default_timezone_set('Europe/Berlin');
setlocale(LC_TIME, "de_DE.utf8", "de_DE", "en_GB", "de_DE@euro", "de_DE.utf", "DE", "de");

require 'connect.php';

if (isset($_GET['site']))
{
	switch ($_GET['site'])
	{
	case 'create':
		$site='kreator';
		break;
	case 'edit':
		$site='edit';
		break;
	case 'del':
		/*Translation muss statfinden, damit sämtliche Befehle in einem Auswahlmenü
			aufgeführt werden können.*/
		$site='show';
		$action='del';
		break;
	case 'publiziert':
		$site='show';
		$action='publiziert';
		break;
	case 'sold_out':
		$site='show';
		$action='sold_out';
		break;
	case 'band':
		$site='band';
		break;
	case 'stadt':
		$site='stadt';
		break;
	case 'location':
		$site='location';
		break;
	case 'aenderungen':
		$site='aenderungen';
		break;
	case 'blog':
		$site='blog';
		break;
	case 'export':
		$site='export';
		break;
	case 'preferences':
		$site='preferences';
		break;
	default:
		$site='show';
	}
}
else {
	$site='show';
}

if (isset($_GET['month'])) {	
	$startdate = $_GET['month'];
} else {
	$startdate = date('Y-m', time());
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Administration – Metal-Termine</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="style.css" />
	<link rel="icon" type="image/vnd.microsoft.icon" href="favicon.ico">
	<script  type="text/javascript" src="scripte.js" ></script>
</head>
<body onload="init()">
	<div class="leiste_top">
		<div id="navigation">
			<a href="?site=show&amp;month=<?=$startdate?>">Termine</a>
			<a href="?site=band&amp;month=<?=$startdate?>">Bands</a>
			<a href="?site=stadt&amp;month=<?=$startdate?>">Städte</a>
			<a href="?site=location&amp;month=<?=$startdate?>">Locations</a>
			<a href="?site=export&amp;month=<?=$startdate?>">Export</a>
			<a href="?site=preferences&amp;month=<?=$startdate?>">Einstellungen</a>
		</div>
	</div>
<?php 

if ($site == 'show' or $site == 'export') { 
	echo "\t<div id=\"leiste_buttons\">";
	$heute = date("Y-m", time());
	$ongoing_month=strtotime($startdate);
	$ongoing_month=strftime('%B %Y', $ongoing_month);
	$next_month=strtotime($startdate." + 1 month");
	$next_month = date("Y-m", $next_month);
	$previous_month=strtotime($startdate." - 1 month");
	$previous_month = date("Y-m", $previous_month);
	printf('<form id="backwards" action="" method="get">
			<input type="hidden" name="site" value="%4$s"/>
			<input type="hidden" name="month" value="%1$s" />
			<button form="backwards" type="submit">&lt;</button>
		</form> 
		<form id="today" action="" method="get">
			<input type="hidden" name="site" value="%4$s" />
			<input type="hidden" name="month" value="%2$s" />
			<button form="today" type="submit">o</button>
		</form>
		<form id="forwards" action="" method="get">
			<input type="hidden" name="site" value="%4$s" />
			<input type="hidden" name="month" value="%3$s" />
			<button form="forwards" type="submit">></button>
		</form>', $previous_month, $heute, $next_month, $site); 
	echo "<div class=\"month\"> $ongoing_month</div>\n\t</div>\n";
} elseif ($site == 'band') {
	echo "\t<div id=\"leiste_buttons\">
		<div id=\"button\">
			<select id=\"band_anfang\" onchange=\"get_band_table()\" >
				<option value=\" \"> </option>\n";
	$alphabet = range('A','Z');
	foreach ($alphabet as $buchstabe) {
		printf("\t\t\t\t<option value=\"%1\$s\">%1\$s</option>\n", $buchstabe);
	}
	echo "\t\t\t\t<option value=\"s\">#</option>
			</select>
		</div>
	</div>\n";
} elseif ($site == 'kreator') {
	if (isset($_GET['date'])) {
		$date=htmlspecialchars($_GET['date'], ENT_QUOTES);
		$startdate = date("Y-m", strtotime($date));
	} else {
		$date='';
	}
}
?>
	<div class="leiste_bottom"> 
	(c) Klaus Thorres 2020. This Software is provided under the <a href="LICENSE">MIT License</a>.
	</div>
<?php 
include($site.'.php');
?>
</body>
</html>
