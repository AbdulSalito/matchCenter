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
$TeamIDGet = $_GET["team"];
//echo "<div id=\"cBoxes\">";
echo "<a href=\"#\" onClick=\" return checkAll();\">إختيار الكل</a> ||
<a href=\"#\" onClick=\" return checkNone();\">عدم إختيار الكل</a>";
echo "<table  class=\"player\">\n";
echo "<tr>";

$i = 0;
include 'db_conn.php';
$sqlPlayer = "SELECT * FROM players WHERE playerTeam='$TeamIDGet'";
$queryresultPlayer = mysql_query($sqlPlayer)
		or die(mysql_error());
while ($rowPlayer = mysql_fetch_assoc($queryresultPlayer)) {
	$teamID = $rowPlayer['playerID'];
	$PlayerFirstNameAr = $rowPlayer['playerFirstNameAr'];
	$PlayerMidNameAr = $rowPlayer['playerMidNameAr'];
	$PlayerLastNameAr = $rowPlayer['playerLastNameAr'];
if ($i % 3 == 0) {
		echo "</tr><tr>";
	}
	echo "<td><input type=\"checkbox\" value=\"1\"> $PlayerFirstNameAr $PlayerMidNameAr $PlayerLastNameAr</td>";
	$i ++;
}
mysql_free_result($queryresultPlayer);
mysql_close($conn);

echo "	</tr>\n";
echo "</table>\n";
//echo "</div>"
?>
	</body>
</html>