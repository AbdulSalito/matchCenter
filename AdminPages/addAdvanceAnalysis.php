<?php
	// ask for the functions from it's file
	require_once('AFunctions.php');
include 'db_conn.php';
// insert the header
echo makeHeader("Add league");
// insert the navigation
echo makeMenu();

echo "<div id = \"maincontent\">\n";
$beginTable = "<table  class=\"mcenter\">\n";
$beginTable .= "	<tr class=\"mcenter\">\n";
$beginTable .= "	<td colspan=\"2\"> ≈÷«›… √Õœ«À «·„»«—«…</td>\n";
$beginTable .= "	</tr>\n";

if (isset($_GET["match"]) && isset($_GET["team"])) {
	$matchIDGet = $_GET["match"];
	$teamID = $_GET["team"];
	echo $beginTable;

	echo "	<tr>\n";
	echo "	<td>«·„»«—«…</td>\n";
	echo "	<td>\n";
	$sqlMatch = "SELECT * FROM `matchcenter`.`match` WHERE matchID='$matchIDGet'";
$queryresultMatch = mysql_query($sqlMatch)
			or die(mysql_error());
	$previousMatchDate = "";
	$TrClass = "";
	$rowMatch = mysql_fetch_assoc($queryresultMatch);
	$dateMatch = $rowMatch['matchDate'];
	$team1 = $rowMatch['matchTeamHome'];
	$team2 = $rowMatch['matchTeamAway'];
	$outputTable = "<table>";
	$outputTable .= "<tr>";
	$sqlTeam1 = "SELECT * FROM `matchcenter`.`teams` WHERE teamID='$team1'";
	$sqlTeam2 = "SELECT * FROM `matchcenter`.`teams` WHERE teamID='$team2'";
	$queryresultTeam1 = mysql_query($sqlTeam1)
					or die(mysql_error());
	$queryresultTeam2 = mysql_query($sqlTeam2)
					or die(mysql_error());
	$rowTeam1 = mysql_fetch_assoc($queryresultTeam1);
	$rowTeam2 = mysql_fetch_assoc($queryresultTeam2);
	$teamPlaying1 =$rowTeam1['teamNameAr'];
	$teamPlaying2 =$rowTeam2['teamNameAr'];

	$outputTable .= "<td>$teamPlaying1</td>";
	$outputTable .= "<td>-</td>";
	$outputTable .= "<td>$teamPlaying2</td>";
	$outputTable .= "</tr></table>";
	echo $outputTable;
	mysql_free_result($queryresultMatch);
	echo "</td></tr>\n";
	echo "<tr><td>\n";
	echo "‰Ê⁄ «·«Õ’«∆ÌÂ";
	echo "</td>\n";
	echo "<td>\n";
	echo "<script type=\"text/javascript\" src=\"../js/getRequest.js\"></script>\n<script type=\"text/javascript\" src=\"../js/advStat.js\"></script>\n";
	global $EventAdvanceAr;
	for ($i = 0; $i < sizeof($EventAdvanceAr); $i++) {
		if ($i == 0) {
			echo "<input type=\"radio\" name=\"StatType\" checked=\"checked\" onclick=\"getStat('$matchIDGet','$teamID','$i','playerList')\" value=\"$i\">".$EventAdvanceAr[$i]."";
		} else {
			echo "<input type=\"radio\" name=\"StatType\" onclick=\"getStat('$matchIDGet','$teamID','$i','playerList')\" value=\"$i\">".$EventAdvanceAr[$i]."";
		}
	}
	echo "</td></tr>\n";
	echo "	<tr>\n";
	echo "	<td colspan=\"2\">";
	echo "<div id=\"playerList\"></div>";
	echo "</td>\n</tr>";
}

echo "</table>\n";
echo "</div>";
// making footer
echo makeFooter();

?>