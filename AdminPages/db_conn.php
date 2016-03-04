<?php
$hostname = "localhost"; // your host name
$dbusername = "root"; // database username
$dbpassword = ""; // database password
$databasename = "matchcenter"; // the database name

// DO NOT change anything after this note ........

	$conn = mysql_connect ($hostname, $dbusername, $dbpassword)
	or die("Could Not Connect to MySQL!");
	mysql_select_db($databasename)
	or die("Could Not Open Database:".mysql_error());

	$result = mysql_query("SET NAMES 'cp1256'");
	if (!$result) {
		die("Charset Failed");
	}
?>