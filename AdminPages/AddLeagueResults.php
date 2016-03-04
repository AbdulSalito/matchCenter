<?php
	// ask for the functions from it's file
	require_once('AFunctions.php');
include 'db_conn.php';
// insert the header
echo makeHeader("Add league");
// insert the navigation
echo makeMenu();

if (isset($_GET["League"]) && isset($_GET["Season"]) && isset($_GET["Round"])) {
	$LeagueName = $_GET["League"];
	$Season = $_GET["Season"];
	$round = $_GET["Round"];

	echo "<div id = \"maincontent\">\n";
	echo "<form id = \"addLeagueResult\" action = \"\" method = \"post\">\n";
	echo "<table dir=\"rtl\" cellSpacing=\"1\" cellPadding=\"0\" id=\"table1\" border=\"1\" width=\"550\" bordercolor=\"#FFFFFF\" style=\"border-collapse: collapse\">\n";

	$sqlMatch = "SELECT * FROM `matchcenter`.`match` WHERE matchSeason='$Season' AND matchComp='$LeagueName' AND matchRound='$round' ORDER BY matchDate,matchTime,matchRound,matchTime,matchTeamHome";
	$queryresultMatch = mysql_query($sqlMatch)
			or die(mysql_error());
	$previousMatchDate = "";
	$TrClass = "";
	while($rowMatch = mysql_fetch_assoc($queryresultMatch)){
		$dateMatch = $rowMatch['matchDate'];
		$team1 = $rowMatch['matchTeamHome'];
		$team2 = $rowMatch['matchTeamAway'];
		$time = $rowMatch['matchTime'];
		$matchID = $rowMatch['matchID'];
		$round = $rowMatch['matchRound'];
		$comment = $rowMatch['matchComment'];
		//check result
		$sqlMatchAnalysis = "SELECT * FROM matchanalysis WHERE analysisMatch='$matchID'";
		$queryresultMatchAnalysis = mysql_query($sqlMatchAnalysis)
			or die(mysql_error());
		$result1 = 0;
		$result2 = 0;
		$MatchAnalysisRowsNumber = mysql_num_rows($queryresultMatchAnalysis);
		if ($MatchAnalysisRowsNumber == 0) {
			$result1 = "";
			$result2 = "";
			$goals1 = "";
			$goals2 = "";

		}
		else {
			while($rowMatchAnalysis = mysql_fetch_assoc($queryresultMatchAnalysis)){
				$mins = $rowMatchAnalysis['analysisMins'];
				$half = $rowMatchAnalysis['analysisHalf'];
				$team = $rowMatchAnalysis['analysisTeam'];
				$analysEvent = $rowMatchAnalysis['analysisEvent'];
				if ($half == 0 && $mins == 90) {
					if ($result1 != 0 || $result2 != 0) {
						break;
					}
					else {
						$result1 = 0;
						$result2 = 0;
					}
				}
				elseif ($analysEvent == 2) {
					if ($team == $team1) {
						$result1 ++;
					}
					elseif ($team == $team2) {
						$result2 ++;
					}
				}
			}
		}
		//end of checking result
		// start teams table
		$sqlTeam1 = "SELECT * FROM `matchcenter`.`teams` WHERE teamID='$team1'";
		$sqlTeam2 = "SELECT * FROM `matchcenter`.`teams` WHERE teamID='$team2'";
		$queryresultTeam1 = mysql_query($sqlTeam1)
				or die(mysql_error());
		$queryresultTeam2 = mysql_query($sqlTeam2)
				or die(mysql_error());
		$rowTeam1 = mysql_fetch_assoc($queryresultTeam1);
		$rowTeam2 = mysql_fetch_assoc($queryresultTeam2);

		// End teams table
		$outputTable = "";
		if ($previousMatchDate != $dateMatch) {
			$outputTable .= "<tr class=\"dates\"><td class=\"whiteBorder\" colspan=\"7\">";
			$dateDayEn = date('l', strtotime($dateMatch));
			$dateArr = array("Saturday"=>"«·”» ","Sunday"=>"«·√Õœ","Monday"=>"«·√À‰Ì‰","Tuesday"=>"«·À·«À«¡","Wednesday"=>"«·√—»⁄«¡","Thursday"=>"«·Œ„Ì”","Friday"=>"«·Ã„⁄…");
			$dateDayAr = $dateArr[$dateDayEn];
			$outputTable .= "$dateDayAr $dateMatch</td></tr>";
		}
		if ($team1 == "1" || $team2 == "1") {
			if (trim($result1) == "" || trim($result2) == "") {
				$outputTable .=  "<tr class=\"hilalMatches\">";
				$outputTable .= "<td class=\"whiteBorder\"> </td>";
				$outputTable .= "<td class=\"whiteBorder\">".$rowTeam1['teamNameAr']."</td>";
				$outputTable .= "<td class=\"whiteBorder\"><a href=\"liveMatch.php?match=$matchID\"> $result1 - $result2 </a></td>";
				$outputTable .= "<td class=\"whiteBorder\">".$rowTeam2['teamNameAr']." </td>";
				$outputTable .= "<td class=\"whiteBorder\">$time</td>";
				$outputTable .= "<td class=\"whiteBorder\"> «·ÃÊ·… ".$round."</td>";
				$outputTable .= "<td class=\"whiteBorder\"> </td>";
			}
			else {
				$outputTable .=  "<tr class=\"hilalMatches\">";
				$outputTable .= "<td class=\"whiteBorder\"> </td>";
				$outputTable .= "<td class=\"whiteBorder\">".$rowTeam1['teamNameAr']."</td>";
				$outputTable .= "<td class=\"whiteBorder\"><a href=\"liveMatch.php?match=$matchID\"> $result1 - $result2 </a></td>";
				$outputTable .= "<td class=\"whiteBorder\">".$rowTeam2['teamNameAr']." </td>";
				$outputTable .= "<td class=\"whiteBorder\">$time</td>";
				$outputTable .= "<td class=\"whiteBorder\"> «·ÃÊ·… ".$round."</td>";
				$outputTable .= "<td class=\"whiteBorder\"> </td>";
			}
		}
		else {
			if (trim($result1) == "" || trim($result2) == "") {
				$outputTable .= "<tr class=\"Matches\">";
				$outputTable .= "<td class=\"whiteBorder\"> <input type=\"checkbox\" checked=\"checked\" name=\"matchs[]\" value=\"$matchID\"></td>";
				$outputTable .= "<td class=\"whiteBorder\">".$rowTeam1['teamNameAr']."</td>";
				$outputTable .= "<td class=\"whiteBorder\"> <input type=\"text\" name=\"$team1\" class=\"result\"> - <input type=\"text\" name=\"$team2\" class=\"result\"> </td>";
				$outputTable .= "<td class=\"whiteBorder\">".$rowTeam2['teamNameAr']." </td>";
				$outputTable .= "<td class=\"whiteBorder\">$time</td>";
				$outputTable .= "<td class=\"whiteBorder\"> «·ÃÊ·… ".$round."</td>";
				$outputTable .= "<td class=\"whiteBorder\"> </td>";
			}
			else {
				$outputTable .= "<tr class=\"Matches\">";
				$outputTable .= "<td class=\"whiteBorder\"> </td>";
				$outputTable .= "<td class=\"whiteBorder\">".$rowTeam1['teamNameAr']."</td>";
				$outputTable .= "<td class=\"whiteBorder\"> $result1 - $result2 </td>";
				$outputTable .= "<td class=\"whiteBorder\">".$rowTeam2['teamNameAr']." </td>";
				$outputTable .= "<td class=\"whiteBorder\">$time</td>";
				$outputTable .= "<td class=\"whiteBorder\"> «·ÃÊ·… ".$round."</td>";
				$outputTable .= "<td class=\"whiteBorder\"> </td>";
			}
		}
		$outputTable .= "</tr>";
		echo $outputTable;
		$previousMatchDate = $dateMatch;
	}
	mysql_free_result($queryresultMatch);
	echo "	<tr>\n";
	echo "	<td colspan=\"7\" class=\"whiteBorder\"><input type=\"submit\" value=\"Add content\"></td>\n";
	echo "	</tr>\n";
	echo "</table>\n";
	echo "</form>\n";
	echo "</div>";
}

if (isset($_POST['matchs']) && isset($_GET["League"]) && isset($_GET["Season"]) && isset($_GET["Round"])) {
	$matchs = $_POST['matchs'];
	$League = $_GET["League"];
	$SeasonIDGet = $_GET["Season"];
	$RoundIDGet = $_GET["Round"];

	foreach ($matchs as $match){
		$sqlMatch = "SELECT * FROM `matchcenter`.`match` WHERE matchID='$match'";
		$queryresultMatch = mysql_query($sqlMatch)
		or die(mysql_error());
		$rowMatch = mysql_fetch_assoc($queryresultMatch);
		$team1ID = $rowMatch['matchTeamHome'];
		$team2ID = $rowMatch['matchTeamAway'];
		$team1Result = $_POST[$team1ID];
		$team2Result = $_POST[$team2ID];

		// add the beginning of the match
		$sqlMatchAnalysisStart = "INSERT INTO matchanalysis (`analysisMatch`,`analysisTeam`,`analysisPlayer`,`analysisEvent`,`analysisHalf`,`analysisMins`,`analysisComment`)
				VALUES ('$match','0','0','0','0','0','1');";
		mysql_query($sqlMatchAnalysisStart) or die (mysql_error());

		// add goals as it inserted for team home
		for ($Goal = 0; $Goal < $team1Result; $Goal++) {
			$sqlMatchAnalysis1 = "INSERT INTO matchanalysis (`analysisMatch`,`analysisTeam`,`analysisPlayer`,`analysisEvent`,`analysisHalf`,`analysisMins`,`analysisComment`)
				VALUES ('$match','$team1ID','0','2','1','1','0');";
					mysql_query($sqlMatchAnalysis1) or die (mysql_error());
		}
		// add goals as it inserted for team away
		for ($Goal = 0; $Goal < $team2Result; $Goal++) {
			$sqlMatchAnalysis2 = "INSERT INTO matchanalysis (`analysisMatch`,`analysisTeam`,`analysisPlayer`,`analysisEvent`,`analysisHalf`,`analysisMins`,`analysisComment`)
				VALUES ('$match','$team2ID','0','2','1','1','0');";
			mysql_query($sqlMatchAnalysis2) or die (mysql_error());
		}
		// end the match!
		$sqlMatchAnalysisEnd = "INSERT INTO matchanalysis (`analysisMatch`,`analysisTeam`,`analysisPlayer`,`analysisEvent`,`analysisHalf`,`analysisMins`,`analysisComment`)
				VALUES ('$match','0','0','0','0','90','9');";
		mysql_query($sqlMatchAnalysisEnd) or die (mysql_error());
	}
}

// making footer
echo makeFooter();

?>