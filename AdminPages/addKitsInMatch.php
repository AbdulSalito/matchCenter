<?php
	// ask for the functions from it's file
	require_once('AFunctions.php');
include 'db_conn.php';
// insert the header
echo makeHeader("Add in match");
// insert the navigation
echo makeMenu();
$postAction = "";

echo "<div id = \"maincontent\">\n";
$beginForm = "<form id = \"addClub\" action = \"\" method = \"post\">\n";
$beginTable = "<table  class=\"mcenter\">\n";
$beginTable .= "	<tr class=\"mcenter\">\n";
$beginTable .= "	<td colspan=\"2\"> ≈÷«›… ≈·Ï „»«—«…</td>\n";
$beginTable .= "	</tr>\n";

if (isset($_GET["match"])) {
	$matchIDGet = $_GET["match"];

	echo "<form id = \"addClub\" action = \"\" method = \"post\">\n";
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
	$seasonIDGet = $rowMatch['matchSeason'];
	$dateMatch = $rowMatch['matchDate'];
	$team1 = $rowMatch['matchTeamHome'];
	$team2 = $rowMatch['matchTeamAway'];
	$outputTable = "<table>";
	$outputTable .= "<tr><td>";
	$dateDayEn = date('l', strtotime($dateMatch));
	$dateArr = array("Saturday"=>"«·”» ","Sunday"=>"«·√Õœ","Monday"=>"«·√À‰Ì‰","Tuesday"=>"«·À·«À«¡","Wednesday"=>"«·√—»⁄«¡","Thursday"=>"«·Œ„Ì”","Friday"=>"«·Ã„⁄…");
	$dateDayAr = $dateArr[$dateDayEn];
	$outputTable .= "$dateDayAr $dateMatch</td>";

	$outputTable .= "<td>".teamNameAr($team1)."</td>";
	$outputTable .= "<td>-</td>";
	$outputTable .= "<td>".teamNameAr($team2)."</td>";
	$outputTable .= "</tr></table>";
	echo $outputTable;
	mysql_free_result($queryresultMatch);
	echo "</td></tr>\n";
	echo "	<tr>\n";
	echo "	<td>".teamNameAr($team1)."</td>\n";
	echo "	<td>\n";
	echo "<select name = \"kitTeamHome\" id =\"kitTeamHome\">";
	echo "	<option value=\"1\">«·ÿﬁ„ «·√”«”Ì</option>";
	echo "	<option value=\"2\">«·ÿﬁ„ «·≈Õ Ì«ÿÌ</option>";
	echo "	<option value=\"3\">«·ÿﬁ„ «·À«·À</option>";
	echo "</select>\n";
	echo "</td></tr>\n";
	echo "	<tr>\n";
	echo "	<td>".teamNameAr($team2)."</td>\n";
	echo "	<td>\n";
	echo "<select name = \"kitTeamAway\" id =\"kitTeamAway\">";
	echo "	<option value=\"1\">«·ÿﬁ„ «·√”«”Ì</option>";
	echo "	<option value=\"2\">«·ÿﬁ„ «·≈Õ Ì«ÿÌ</option>";
	echo "	<option value=\"3\">«·ÿﬁ„ «·À«·À</option>";
	echo "</select>\n";
	echo "</td></tr>\n";

	echo "	<tr>\n";
	echo "	<td colspan=\"2\"><input type=\"submit\" value=\"Add content\"></td>\n";
	echo "	</tr>\n";
}

echo "</table>\n";
echo "</form>\n";

if (isset($_POST['kitTeamHome']) && isset($_POST['kitTeamAway']) && isset($_GET["match"])) {
	include 'db_conn.php';
	$kitHome = $_POST['kitTeamHome'];
	$kitAway = $_POST['kitTeamAway'];
	$match = $_GET["match"];

	$sql = "UPDATE `matchcenter`.`match` SET matchTeamHomeKit='$kitHome',matchTeamAwayKit='$kitAway'
	WHERE matchID='$match'";
	mysql_query($sql) or die (mysql_error());

	echo " „ «÷«›… «·„œŒ·«  »‰Ã«Õ!";
	echo "<a href=\"addInSeason.php\">«·⁄Êœ…</a>";
	echo redirection();
	$redirectAction = "addInMatch.php?";
	$redirectAction .= "match=";
	$redirectAction .= $matchIDGet;
	$redirectAction .= "&team=";
	global $team1;
	$redirectAction .= $team1;
	$redirectAction .= "&type=";
	$redirectAction .= "0";
	header("Refresh: 4; url=$redirectAction");
	//header("location: $redirectAction") ;
	mysql_close($conn);
}
echo "</div>";
// making footer
echo makeFooter();

?>