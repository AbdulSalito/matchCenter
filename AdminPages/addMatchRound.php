<?php
	// ask for the functions from it's file
	require_once('AFunctions.php');
include 'db_conn.php';
// insert the header
echo makeHeader("Add league");
// insert the navigation
echo makeMenu();
$postAction = "";

echo "<div id = \"maincontent\">\n";
$beginForm = "<form id = \"addClub\" action = \"\" method = \"post\">\n";
$beginTable = "<table  class=\"mcenter\">\n";
$beginTable .= "	<tr class=\"mcenter\">\n";
$beginTable .= "	<td colspan=\"3\"> ≈÷«›… «·ÃÊ·« </td>\n";
$beginTable .= "	</tr>\n";

if (isset($_GET["season"]) && isset($_GET["comp"]) && isset($_GET["round"])) {
	$seasonIDGet = $_GET["season"];
	$compIDGet = $_GET["comp"];
	$roundIDGet = $_GET["round"];

	$postAction .= "season=";
	$postAction .= $seasonIDGet;
	$postAction .= "&comp=";
	$postAction .= $compIDGet;
	$postAction .= "&round=";
	$postAction .= $roundIDGet;

	echo "<form id = \"addMatchRound\" action = \"addMatchRound.php?$postAction\" method = \"post\">\n";
	echo $beginTable;

	echo "	<tr>\n";
	echo "	<td colspan=\"3\">«·„»«—Ì« </td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "<td colspan=\"3\"><table width=\"200px\">\n";
	$sqlMatch = "SELECT * FROM `matchcenter`.`match` WHERE matchSeason='$seasonIDGet' AND matchComp='$compIDGet' AND matchRound='0'";
	$queryresultMatch = mysql_query($sqlMatch)
			or die(mysql_error());
	$i = 0;
	$previousTeam = "";
	$sqlMatchTeamHome = "SELECT DISTINCT matchTeamHome FROM `matchcenter`.`match` WHERE matchSeason='$seasonIDGet' AND matchComp='$compIDGet'";
	$queryresultMatchTeamHome = mysql_query($sqlMatchTeamHome)
	or die(mysql_error());
	$NumberOfMatchesHome = 0;
	while($rowMatchTeamHome = mysql_fetch_assoc($queryresultMatchTeamHome)){
		$NumberOfMatchesHome ++ ;
	}
	$selectLimit = $NumberOfMatchesHome / 2;
	echo selectedLimit($selectLimit);
	while($rowMatch = mysql_fetch_assoc($queryresultMatch)){
		$matchID = $rowMatch['matchID'];
		$team1 = $rowMatch['matchTeamHome'];
		$team2 = $rowMatch['matchTeamAway'];
		/*$sqlTeam1 = "SELECT * FROM `matchcenter`.`teams` WHERE teamID='$team1'";
		$sqlTeam2 = "SELECT * FROM `matchcenter`.`teams` WHERE teamID='$team2'";
		$queryresultTeam1 = mysql_query($sqlTeam1)
				or die(mysql_error());
		$queryresultTeam2 = mysql_query($sqlTeam2)
				or die(mysql_error());
		$rowTeam1 = mysql_fetch_assoc($queryresultTeam1);
		$rowTeam2 = mysql_fetch_assoc($queryresultTeam2);*/
		if ($previousTeam != $team1) {
			echo "</table>\n</td>";
			if ($i % 3 == 0) {
				echo "</tr><tr><td colspan=\"3\"><hr></td></tr><tr>";
			}
			echo "<td><table width=\"200px\">\n";
			$i ++;
		}
		echo "<tr id=\"$matchID\">\n<td>\n";
		echo "<input type=\"checkbox\" onclick=\"setChecks(this);hightLight(this,'$matchID');\" name=\"matches[]\" value=\"$matchID\">".TeamNameAr($team1)." - ".TeamNameAr($team2)."\n";
		echo "</td>\n</tr>\n";
		$previousTeam = $team1;
	}
	mysql_free_result($queryresultMatch);

	echo "</table>\n</td>";
	echo "	<td colspan=\"3\">\n";
	echo "	</td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td colspan=\"3\"><input type=\"submit\" value=\"Add content\"></td>\n";
	echo "	</tr>\n";
}

echo "</table>\n";
echo "</form>\n";

if (isset($_POST['matches']) && isset($_GET["season"]) && isset($_GET["comp"])  && isset($_GET["round"])) {
	include 'db_conn.php';
	$matchesPost = $_POST['matches'];
	$seasonIDGet = $_GET["season"];
	$comp = $_GET["comp"];
	$round = $_GET["round"];

	$sqlMatch = "SELECT DISTINCT matchTeamHome FROM `matchcenter`.`match` WHERE matchSeason='$seasonIDGet' AND matchComp='$comp'";
	$queryresultMatch = mysql_query($sqlMatch)
		or die(mysql_error());
	$NumberOfMatchesHome = 0;
	while($rowMatch = mysql_fetch_assoc($queryresultMatch)){
		$NumberOfMatchesHome ++ ;
	}
	foreach ($matchesPost as $matches){
		$sqlMatch = "SELECT * FROM `matchcenter`.`match` WHERE matchID='$matches'";
		$queryresultMatch = mysql_query($sqlMatch)
			or die(mysql_error());
		$rowMatch = mysql_fetch_assoc($queryresultMatch);
		$teamHome = $rowMatch['matchTeamHome'];
		$teamAway = $rowMatch['matchTeamAway'];
		$sql = "UPDATE `matchcenter`.`match` SET matchRound='$round' WHERE matchSeason='$seasonIDGet' AND matchComp ='$comp'
		AND matchTeamHome='$teamHome' AND matchTeamAway='$teamAway'";
		mysql_query($sql) or die (mysql_error());
		$SecondRound = $round + ($NumberOfMatchesHome - 1);
		$sql = "UPDATE `matchcenter`.`match` SET matchRound='$SecondRound' WHERE matchSeason='$seasonIDGet' AND matchComp ='$comp'
		AND matchTeamHome='$teamAway' AND matchTeamAway='$teamHome'";
		mysql_query($sql) or die (mysql_error());
	}
	echo " „ «÷«›… «·„œŒ·«  »‰Ã«Õ!";
	echo "<a href=\"addInSeason.php\">«·⁄Êœ…</a>";
	echo redirection();
	if ($round < $NumberOfMatchesHome) {
		$round ++;
		$redirectAction = "addMatchRound.php?";
		$redirectAction .= "season=";
		$redirectAction .= $seasonIDGet;
		$redirectAction .= "&comp=";
		$redirectAction .= $comp;
		$redirectAction .= "&round=";
		$redirectAction .= $round;
		header("location: $redirectAction") ;
	}
	mysql_close($conn);
}
echo "</div>";
// making footer
echo makeFooter();

?>