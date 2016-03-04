<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="rtl" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-language" content="en" />
<meta http-equiv="Content-Type" content="text/html; charset=Windows-1256" />
<title>MatchCenter</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<?php
$nationalityIDGet = $_GET["country"];
include 'db_conn.php';
echo "<select name = \"city\" id =\"city\">";
$sqlcity = "SELECT * FROM city WHERE cityContry='$nationalityIDGet'";
$queryresultcity = mysql_query($sqlcity)
		or die(mysql_error());
while ($rowCity = mysql_fetch_assoc($queryresultcity)) {
	$cityID = $rowCity['cityID'];
	$cityNameAr = $rowCity['cityNameAr'];
	echo "<option value=\"$cityID\">$cityNameAr</option>\n";
}
echo "</select>";
mysql_free_result($queryresultcity);
mysql_close($conn);
?>
	</body>
</html>