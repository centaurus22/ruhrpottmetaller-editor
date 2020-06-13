<!DOCTYPE html>
<html>
	<head>
		<title><?= $this->_['pagetitle'].$this->_['subtitle'] ?></title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    	<link rel="stylesheet" type="text/css" href="style.css" />
    	<link rel="icon" type="image/vnd.microsoft.icon" href="favicon.ico">
		<script  type="text/javascript" src="scripte.js" ></script>
	</head>
	<body>
		<div class="leiste_top">
			<div id="navigation">
<?php
	foreach ($this->_['menu_entrys'] as $menu_entry) {
		printf("\t\t\t\t<a href='?display_type=%s&month=%s'>%s</a>\n", $menu_entry[1], $this->_['month'], $menu_entry[0]);
	}
?>
			</div>
		</div>
		<div class="leiste_bottom"> 
			(c) Klaus Thorres 2020. This Software is provided under the <a href="?display_type=license">MIT License</a>.
		</div>
	</body>
</html>
