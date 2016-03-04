<?php
	// ask for the functions from it's file
require_once('Functions.php');
include 'AdminPages/db_conn.php';
// insert the header
echo makeHeader("Add league");
// insert the navigation
echo makeMenu();
$postAction = "";

echo "<div id = \"maincontent\">\n";
$beginTable = "<table  class=\"mcenter\">\n";
$beginTable .= "	<tr class=\"mcenter\">\n";

if (isset($_GET["ID"])) {
	$IDGet = $_GET["ID"];

	$sqlPlayer = "SELECT * FROM chairmen WHERE chairmanID='$IDGet'";
	$queryresultPlayer = mysql_query($sqlPlayer)
		or die(mysql_error());
	$rowPlayer = mysql_fetch_assoc($queryresultPlayer);
	$firstNameAr = $rowPlayer['chairmanFirstNameAr'];
	$lastNameAr = $rowPlayer['chairmanLastNameAr'];
	$Nationality = $rowPlayer['chairmanNationality'];
	$Position = $rowPlayer['chairmanPosition'];
	$Pic = $rowPlayer['chairmanPic'];
	$team = $rowPlayer['chairmanTeam'];

	$beginTable .= "<td colspan=\"3\"><strong>$firstNameAr $lastNameAr</strong></td>\n";
	$beginTable .= "</tr>\n";
	$beginTable .= "<tr>\n<td>\n";
	$beginTable .= "«·Ã‰”Ì…";
	$beginTable .= "</td>\n";
	$beginTable .= "<td>\n";
	$beginTable .= nationalityAdj($Nationality,"ar");
	$beginTable .= "</td>\n";
	$beginTable .= "<td rowspan=\"2\">\n";
	$beginTable .= "<img src=\"admins/$Pic\">";
	$beginTable .= "</td>\n</tr>\n";
	$beginTable .= "<tr>\n<td>\n";
	$beginTable .= "«·„‰’»";
	$beginTable .= "</td>\n";
	$beginTable .= "<td>\n";
	global $AdminAr;
	$beginTable .= "$AdminAr[$Position]";
	$beginTable .= "</td>\n</tr>\n";

	echo $beginTable;
	mysql_free_result($queryresultPlayer);

}

echo "</table>\n";
echo "</div>";
// making footer
echo makeFooter();

?>