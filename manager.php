<?php
	// ask for the functions from it's file
	require_once('Functions.php');
include 'AdminPages/db_conn.php';
// insert the header
echo makeHeader("Manager");
// insert the navigation
echo makeMenu();
$postAction = "";

echo "<div id = \"maincontent\">\n";
$beginTable = "<table  class=\"mcenter\">\n";
$beginTable .= "	<tr class=\"mcenter\">\n";

if (isset($_GET["ID"])) {
	$IDGet = $_GET["ID"];

	$sqlPlayer = "SELECT * FROM managers WHERE managerID='$IDGet'";
	$queryresultPlayer = mysql_query($sqlPlayer)
		or die(mysql_error());
	$rowPlayer = mysql_fetch_assoc($queryresultPlayer);
	$firstNameAr = $rowPlayer['managerFirstNameAr'];
	$lastNameAr = $rowPlayer['managerLastNameAr'];
	$DOB = $rowPlayer['managerDOB'];
	$POB = $rowPlayer['managerPOB'];
	$Nationality = $rowPlayer['managerNationality'];
	$Position = $rowPlayer['managerLevel'];
	$Pic = $rowPlayer['managerPic'];
	$team = $rowPlayer['managerTeam'];

	$beginTable .= "<td colspan=\"3\"><strong>$firstNameAr $lastNameAr</strong></td>\n";
	$beginTable .= "</tr>\n";
	$beginTable .= "<tr>\n<td>\n";
	$beginTable .= " «—ÌŒ «·„Ì·«œ";
	$beginTable .= "</td>\n";
	$beginTable .= "<td>\n";
	$beginTable .= "$DOB (";
	$beginTable .= GetAge($DOB);
	$beginTable .= ")</td>\n";
	$beginTable .= "<td rowspan=\"4\">\n";
	$beginTable .= "<img src=\"managers/$Pic\">";
	$beginTable .= "</td>\n</tr>\n";
	$beginTable .= "<tr>\n<td>\n";
	$beginTable .= "„ﬂ«‰ «·„Ì·«œ";
	$beginTable .= "</td>\n";
	$beginTable .= "<td>\n";
	$beginTable .= CityNameAr($POB);
	$beginTable .= "</td>\n</tr>\n";
	$beginTable .= "<tr>\n<td>\n";
	$beginTable .= "«·Ã‰”Ì…";
	$beginTable .= "</td>\n";
	$beginTable .= "<td>\n";
	$beginTable .= nationalityAdj($Nationality,"ar");
	$beginTable .= "</td>\n</tr>\n";
	$beginTable .= "<tr>\n<td>\n";
	$beginTable .= "«·„‰’»";
	$beginTable .= "</td>\n";
	$beginTable .= "<td>\n";
	global $LevelAr;
	$beginTable .= "$LevelAr[$Position]";
	$beginTable .= "</td>\n</tr>\n";

	echo $beginTable;
	mysql_free_result($queryresultPlayer);

}

echo "</table>\n";
echo "</div>";
// making footer
echo makeFooter();

?>