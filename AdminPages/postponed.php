<?php
	// ask for the functions from it's file
	require_once('AFunctions.php');
include 'db_conn.php';
// insert the header
echo makeHeader("Postponed");
// insert the navigation
echo makeMenu();

if (isset($_GET['match']) && isset($_GET['type'])) {
	$match = $_GET['match'];
	$type = $_GET['type'];
	// start the form with an empty text box to insert the new data
	echo "<div id = \"maincontent\">\n";
	echo "<table  class=\"mcenter\">\n";
	echo "	<tr class=\"mcenter\">\n";
	if ($type == "confirm") {
		$sql = "UPDATE `matchcenter`.`match` SET matchComment='18' WHERE matchID='$match'";
		mysql_query($sql) or die (mysql_error());
		echo "	<td colspan=\"5\">  „  √ÃÌ· «·„»«—«… </td>\n";
	} elseif ($type == "cancel") {
		$sql = "UPDATE `matchcenter`.`match` SET matchComment='0' WHERE matchID='$match'";
		mysql_query($sql) or die (mysql_error());
		echo "	<td colspan=\"5\">  „ ≈·€«¡ «· √ÃÌ· </td>\n";
	}
	echo "	</tr>\n";
	$sqlMatch = "SELECT * FROM `matchcenter`.`match` WHERE matchID='$match'";
	$queryresultMatch = mysql_query($sqlMatch)
		or die(mysql_error());
	$rowMatch = mysql_fetch_assoc($queryresultMatch);
	$dateMatch = $rowMatch['matchDate'];
	$team1 = $rowMatch['matchTeamHome'];
	$team2 = $rowMatch['matchTeamAway'];
	$time = $rowMatch['matchTime'];
	mysql_free_result($queryresultMatch);
	echo "<tr>";
	echo "<td class=\"whiteBorder\">$dateMatch</td>";
	echo "<td class=\"whiteBorder\">$time</td>";
	echo "<td class=\"whiteBorder\">";
	echo teamNameAr($team1);
	echo "</td>";
	echo "<td class=\"whiteBorder\"><a href=\"liveMatch.php?match=$match\"> - </a></td>";
	echo "<td class=\"whiteBorder\">";
	echo teamNameAr($team2);
	echo "</td>";
	echo "</tr>";
	echo "</table>\n";
}
echo "</div>";

// making footer
echo makeFooter();

?>