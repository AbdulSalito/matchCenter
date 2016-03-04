<?php
require_once('AFunctions.php');
include 'db_conn.php';
// insert the header
echo makeHeader("");

echo makeMenu();

echo "<div id = \"maincontent\">\n";
$beginTable = "<table  class=\"mcenter\">\n";
$beginTable .= "	<tr class=\"mcenter\">\n";
$beginTable .= "	<td colspan=\"2\">  ⁄œÌ· √Õœ«À «·„»«—«…</td>\n";
$beginTable .= "	</tr>\n";

// insert the navigation
if (isset($_GET["match"])) {
	$matchIDGet = $_GET["match"];

	echo "<form id = \"editMatchAnalysis\" action = \"\" method = \"post\">\n";
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
	$Comp = $rowMatch['matchComp'];
	$Season = $rowMatch['matchSeason'];
	$outputTable = "<table>";
	$outputTable .= "<tr><td>";
	$dateDayEn = date('l', strtotime($dateMatch));
	$dateArr = array("Saturday"=>"«·”» ","Sunday"=>"«·√Õœ","Monday"=>"«·√À‰Ì‰","Tuesday"=>"«·À·«À«¡","Wednesday"=>"«·√—»⁄«¡","Thursday"=>"«·Œ„Ì”","Friday"=>"«·Ã„⁄…");
	$dateDayAr = $dateArr[$dateDayEn];
	$outputTable .= "$dateDayAr $dateMatch</td>";

	$teamPlaying1 = TeamNameAr($team1);
	$teamPlaying2 = TeamNameAr($team2);

	$outputTable .= "<td>$teamPlaying1</td>";
	$outputTable .= "<td>-</td>";
	$outputTable .= "<td>$teamPlaying2</td>";
	$outputTable .= "</tr></table>";
	echo $outputTable;

	echo "<br><a href=\"addMatchAnalysis.php?match=$matchIDGet\">«·⁄Êœ… ·≈÷«›…  Õ·Ì· «·„»«—«…</a>";
	echo " - <a href=\"editComment.php?match=$matchIDGet\"> ⁄œÌ· «· ⁄·Ìﬁ« </a>";
	echo "</td></tr>\n";
	echo "	<tr>\n";
	echo "	<td>";
	echo "<select name=\"Events\" size=\"11\" onclick=\"CityExFile('getPlayerCheck.php','editAnalysis',this.value,'analysis')\">";
	$sqlMatch = "SELECT * FROM matchanalysis WHERE analysisMatch='$matchIDGet' ORDER BY analysisID";
	$queryresultMatch = mysql_query($sqlMatch)
		or die(mysql_error());
	while ($rowMatch = mysql_fetch_assoc($queryresultMatch)) {
		$analysisID = $rowMatch['analysisID'];
		$analysisTeam = $rowMatch['analysisTeam'];
		$analysisPlayer = $rowMatch['analysisPlayer'];
		$analysisEvent = $rowMatch['analysisEvent'];
		$analysisMins = $rowMatch['analysisMins'];
		$analysisHalf = $rowMatch['analysisHalf'];
		if ($analysisHalf == 0 && $analysisEvent == 0 && ($analysisMins == 0 OR $analysisMins == 45 OR $analysisMins == 46 OR $analysisMins == 90 OR $analysisMins == 91 OR $analysisMins == 105 OR $analysisMins == 106 OR $analysisMins == 120)) {
				echo "";
		} else {
			echo "	<option value=\"$analysisID\">$analysisMins - ";
			global $EventSimpleLiveAr;
			echo $EventSimpleLiveAr[$analysisEvent];
			echo " ";
			echo playerShortNameAr($analysisPlayer);
			echo "</option>";
		}
	}
	echo "</select>";
	echo "</td>\n<td>\n";
	echo "<script type=\"text/javascript\" src=\"../js/getRequest.js\"></script>\n<script type=\"text/javascript\" src=\"../js/getNewDiv.js\"></script>\n";
	echo "<div id=\"analysis\"></div>";
	echo "</td>\n</tr>";
	echo "	<tr>\n";
	echo "	<td colspan=\"2\"><input type=\"submit\" value=\"Add content\"></td>\n";
	echo "	</tr>\n";
}

echo "</table>\n";
echo "</form>\n";

if (isset($_POST['players']) && isset($_GET["match"]) && isset($_POST["event"])) { // && isset($_POST['playerOne'])
	//$commentPost = trim($_POST['commentPost']);
	$mins = $_POST['mins'];
	$Event = $_POST['event'];
	$half = $_POST['half'];
	$team = $_POST['teamsPlaying'];
	$player = $_POST['players'];
	$match = $_GET["match"];
	$OrginalEvent = $_POST['Events'];
	$Penalty = $_POST['penalty'];

	$redirectAction = "editMatchAnalysis.php?match=";
	$redirectAction .= $match;
	$redirection =  " „ «÷«›… «·„œŒ·«  »‰Ã«Õ!";
	$redirection .= "<a href=\"editMatchAnalysis.php\">«·⁄Êœ…</a>";
	$redirection .= header("location: $redirectAction") ;


	$sql = "UPDATE matchanalysis SET analysisTeam='$team', analysisPlayer='$player', analysisEvent='$Event', analysisPenalty='$Penalty',
	analysisHalf='$half', analysisMins='$mins'
	WHERE analysisID='$OrginalEvent' AND analysisMatch='$match'";
	mysql_query($sql) or die (mysql_error());
	if ($Event == 4) {
		$sql = "UPDATE inmatch SET inmatchType='6' WHERE inmatchMatch='$match' AND inmatchTeam='$team' AND inmatchMember='$player'
			AND (inmatchType='0' OR inmatchType='5')";
		mysql_query($sql) or die (mysql_error());
	}

	echo $redirection;

	mysql_close($conn);
}
echo "</div>";
// making footer
echo makeFooter();

?>