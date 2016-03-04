<?php
	// ask for the functions from it's file
	require_once('Functions.php');
include 'AdminPages/db_conn.php';
// insert the header
echo makeHeaderSimple("'Show Minutes","ar");
// insert the navigation
//echo makeMenu();

if (isset($_GET["Season"]) && isset($_GET["Team"])) {
	$Season = $_GET["Season"];
	$TeamIdGet = $_GET["Team"];

	echo "<table dir=\"rtl\" cellSpacing=\"1\" cellPadding=\"0\" id=\"table1\" border=\"1\" width=\"550\" bordercolor=\"#FFFFFF\" style=\"border-collapse: collapse\">\n";
	// get the start date and end date of the selected season
	$sqlSes = "SELECT * FROM season WHERE seasonID='$Season'";
	$queryresultSes = mysql_query($sqlSes)
		or die(mysql_error());
	$rowSes = mysql_fetch_assoc($queryresultSes);
	$start = $rowSes['seasonYearStart'];
	$end = $rowSes['seasonYearEnd'];
	$dateStarting = "$start-07-01";
	$dateFinishin = "$end-06-01";
	mysql_free_result($queryresultSes);

	$NewTr = 1;
	$outputTable = "";
	if (isset($_GET["League"])) {
		$LeagueName = $_GET["League"];
		$whereClause = "matchComp='$LeagueName' AND (matchDate >= '$dateStarting' AND matchDate <= '$dateFinishin') AND ";
	} else {
		$whereClause = "(matchDate >= '$dateStarting' AND matchDate <= '$dateFinishin') AND ";
	}
	// get the start date and end date of the selected season
	$sqlMatch = "SELECT * FROM `matchcenter`.`match` WHERE $whereClause
	(matchTeamHome='$TeamIdGet' OR matchTeamAway='$TeamIdGet') ORDER BY matchDate,matchTime,matchRound,matchTime,matchTeamHome";
	$queryresultMatch = mysql_query($sqlMatch)
		or die(mysql_error());
	$YelCardsTbl = "<table class=\"CardsTbl\">\n";
	$RedCardsTbl = "<table class=\"CardsTbl\">\n";
	while($rowMatch = mysql_fetch_assoc($queryresultMatch)){
		$matchsPlayed = $rowMatch['matchID'];
		$matchsTeamHome = $rowMatch['matchTeamHome'];
		$matchsTeamAway = $rowMatch['matchTeamAway'];
		$sqlMatchAnalysis = "SELECT * FROM matchanalysis WHERE analysisMatch='$matchsPlayed' AND analysisEvent=2 AND
	(analysisHalf=1 OR analysisHalf=2 OR analysisHalf=3 OR analysisHalf=4)";
		$queryresultMatchAnalysis = mysql_query($sqlMatchAnalysis)
			or die(mysql_error());
		$result1 = 0;
		$result2 = 0;
		if (mysql_num_rows($queryresultMatchAnalysis) == 0) {
			$result1 = "";
			$result2 = "";
		} else {
			while($rowMatchAnalysis = mysql_fetch_assoc($queryresultMatchAnalysis)){
				$team = $rowMatchAnalysis['analysisTeam'];
				if ($team == $matchsTeamHome) {
					$result1 ++;
				}
				elseif ($team == $matchsTeamAway) {
					$result2 ++;
				}
			}
		}
		// search for cards
		$sqlMatchAnalyCards = "SELECT * FROM matchanalysis WHERE analysisMatch='$matchsPlayed' AND analysisEvent='3'";
		$queryresultMatchAnalyCards = mysql_query($sqlMatchAnalyCards)
			or die(mysql_error());
		$YelCardsBeginTbl = "<table class=\"CardsTbl\">\n";
		$RedCardsBeginTbl = "<table class=\"CardsTbl\">\n";
		$YelCardsTbl = "";
		$RedCardsTbl = "";
		if (mysql_num_rows($queryresultMatchAnalyCards) == 0) {
			$YelCardsTbl .= "<tr><td class=\"matchLinks\">\n";
			$YelCardsTbl .= "-\n";
			$YelCardsTbl .= "</td></tr>\n";
		}
		while ($rowMatchAnalyCards = mysql_fetch_assoc($queryresultMatchAnalyCards)) {
			$playerID = $rowMatchAnalyCards['analysisPlayer'];
			$Event = $rowMatchAnalyCards['analysisEvent'];
			$Mins = $rowMatchAnalyCards['analysisMins'];
			$YelCardsTbl .= "<tr><td class=\"CardsTbl\">\n";
			$YelCardsTbl .= "$Mins ".playerFullNameAr($playerID)."\n";
			$YelCardsTbl .= "</td></tr>\n";
		}
		$sqlMatchAnalyCards = "SELECT * FROM matchanalysis WHERE analysisMatch='$matchsPlayed' AND analysisEvent='4'";
		$queryresultMatchAnalyCards = mysql_query($sqlMatchAnalyCards)
			or die(mysql_error());
		if (mysql_num_rows($queryresultMatchAnalyCards) == 0) {
			$RedCardsTbl .= "<tr><td class=\"matchLinks\">\n";
			$RedCardsTbl .= "-\n";
			$RedCardsTbl .= "</td></tr>\n";
		}
		while ($rowMatchAnalyCards = mysql_fetch_assoc($queryresultMatchAnalyCards)) {
			$playerID = $rowMatchAnalyCards['analysisPlayer'];
			$Event = $rowMatchAnalyCards['analysisEvent'];
			$Mins = $rowMatchAnalyCards['analysisMins'];
			$RedCardsTbl .= "<tr><td class=\"CardsTbl\">\n";
			$RedCardsTbl .= "$Mins ".playerFullNameAr($playerID)."\n";
			$RedCardsTbl .= "</td></tr>\n";
		}
		$YelCardsCloseTbl = "</table>\n";
		$RedCardsCloseTbl = "</table>\n";
		if ($NewTr == 2) {
			$outputTable .= "<tr class=\"hilalMatches\">\n";
			$NewTr = 0;
		} else {
			$outputTable .= "<tr class=\"Matches\">\n";
		}
		$outputTable .= "<td class=\"whiteBorder\">". TeamNameAr($matchsTeamHome)."</td>\n";
		$outputTable .= "<td class=\"whiteBorder\"> $result1 - $result2 </td>\n";
		$outputTable .= "<td class=\"whiteBorder\">". TeamNameAr($matchsTeamAway)."</td>\n";
		$outputTable .= "<td class=\"whiteBorder\"> $YelCardsBeginTbl ". $YelCardsTbl ."$YelCardsCloseTbl </td>\n";
		$outputTable .= "<td class=\"whiteBorder\"> $RedCardsBeginTbl ". $RedCardsTbl ."$RedCardsCloseTbl </td>\n";
		$outputTable .= "</tr>\n";
		$NewTr ++ ;
	}

	$outputTableBegin = " <tr class=\"dates\"> \n";
	$outputTableBegin .= " <td colspan=\"3\">«·„»«—«…</td>\n";
	$outputTableBegin .= " <td>ﬂ—  √’›—</td>\n";
	$outputTableBegin .= " <td>ﬂ—  √Õ„—</td>\n";
	$outputTableBegin .= "</tr>\n";
	$outputTableBegin .= "";

	echo $outputTableBegin;
	echo $outputTable;
	echo "</table>";
	mysql_free_result($queryresultMatch);
}

echo "</table>\n";

// making footer
echo makeFooterSimple();

?>