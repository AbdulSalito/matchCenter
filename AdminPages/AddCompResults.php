<?php
	// ask for the functions from it's file
	require_once('AFunctions.php');
include 'db_conn.php';
// insert the header
echo makeHeader("Add league");
// insert the navigation
echo makeMenu();

if (isset($_GET["League"]) && isset($_GET["Season"])) {
	$LeagueName = $_GET["League"];
	$Season = $_GET["Season"];

	echo "<div id = \"maincontent\">\n";
	echo "<form id = \"addLeagueResult\" action = \"\" method = \"post\">\n";
	echo "<table dir=\"rtl\" cellSpacing=\"1\" cellPadding=\"0\" id=\"table1\" border=\"1\" width=\"550\" bordercolor=\"#FFFFFF\" style=\"border-collapse: collapse\">\n";

	$whereClause = "matchSeason='$Season' AND matchComp='$LeagueName' ";
	$OrderByClause = "ORDER BY matchDate,matchTime,matchRound,matchTime,matchTeamHome ";
	if (isset($_GET['Group'])) {
		$group = $_GET['Group'];
		$whereClause .= "AND matchRound='32' AND matchGroup='$group' ";
	} elseif (isset($_GET["Round"])) {
		$round = $_GET["Round"];
		$whereClause .= "AND matchRound='$round' ";
	}

	$sqlMatch = "SELECT * FROM `matchcenter`.`match` WHERE $whereClause $OrderByClause";
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
		$outputTable = "";
		$dateMatch = date("d - m - Y",strtotime($dateMatch));
		if ($previousMatchDate != $dateMatch) {
			$outputTable .= "<tr class=\"dates\"><td class=\"whiteBorder\" colspan=\"7\">";
			$dateDayEn = date('l', strtotime($dateMatch));
			$dateArr = array("Saturday"=>"«·”» ","Sunday"=>"«·√Õœ","Monday"=>"«·√À‰Ì‰","Tuesday"=>"«·À·«À«¡","Wednesday"=>"«·√—»⁄«¡","Thursday"=>"«·Œ„Ì”","Friday"=>"«·Ã„⁄…");
			$dateDayAr = $dateArr[$dateDayEn];
			$outputTable .= "$dateDayAr  $dateMatch</td></tr>";
		}
		if ($team1 == "1" || $team2 == "1") {
			$outputTable .=  "<tr class=\"hilalMatches\">";
			$outputTable .= "<td class=\"whiteBorder\"> </td>";
			$outputTable .= "<td class=\"whiteBorder\">".TeamNameAr($team1)."</td>";
			$outputTable .= "<td class=\"whiteBorder\"><a href=\"../liveMatch.php?match=$matchID\"> $result1 - $result2 </a></td>";
			$outputTable .= "<td class=\"whiteBorder\">".TeamNameAr($team2)." </td>";
			$outputTable .= "<td class=\"whiteBorder\">$time</td>";
			$outputTable .= "<td class=\"whiteBorder\"> «·ÃÊ·… ".$round."</td>";
			$outputTable .= "<td class=\"whiteBorder\"> </td>";
		}
		else {
			if (trim($result1) == "" || trim($result2) == "") {
				$outputTable .= "<tr class=\"Matches\">";
				$outputTable .= "<td class=\"whiteBorder\"> <input type=\"checkbox\" checked=\"checked\" name=\"matchs[]\" value=\"$matchID\"></td>";
				$outputTable .= "<td class=\"whiteBorder\">".TeamNameAr($team1)."</td>";
				$outputTable .= "<td class=\"whiteBorder\"> <input type=\"text\" name=\"$matchID$team1\" class=\"result\"> - <input type=\"text\" name=\"$matchID$team2\" class=\"result\"> </td>";
				$outputTable .= "<td class=\"whiteBorder\">".TeamNameAr($team2)." </td>";
				$outputTable .= "<td class=\"whiteBorder\">$time</td>";
				$outputTable .= "<td class=\"whiteBorder\"> «·ÃÊ·… ".$round."</td>";
				$outputTable .= "<td class=\"whiteBorder\"> </td>";
			}
			else {
				$outputTable .= "<tr class=\"Matches\">";
				$outputTable .= "<td class=\"whiteBorder\"> </td>";
				$outputTable .= "<td class=\"whiteBorder\">".TeamNameAr($team1)."</td>";
				$outputTable .= "<td class=\"whiteBorder\"> $result1 - $result2 </td>";
				$outputTable .= "<td class=\"whiteBorder\">".TeamNameAr($team2)." </td>";
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

elseif (isset($_GET["Cup"]) && isset($_GET["Season"]) && isset($_GET["Round"])) {
	$CupName = $_GET["Cup"];
	$Season = $_GET["Season"];
	$round = $_GET["Round"];

	echo "<div id = \"maincontent\">\n";
	echo "<form id = \"addCupResult\" action = \"\" method = \"post\">\n";
	echo "<table dir=\"rtl\" cellSpacing=\"1\" cellPadding=\"0\" id=\"table1\" border=\"1\" width=\"550\" bordercolor=\"#FFFFFF\" style=\"border-collapse: collapse\">\n";

	$sqlMatch = "SELECT * FROM `matchcenter`.`match` WHERE matchSeason='$Season' AND matchComp='$CupName' AND matchRound='$round' ORDER BY matchDate,matchTime,matchRound,matchTime,matchTeamHome";
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
		// check if there is a match away
		$sqlMatchAway = "SELECT * FROM `matchcenter`.`match` WHERE matchSeason='$Season' AND matchComp='$CupName'
		AND (matchTeamHome='$team2' AND matchTeamAway='$team1')";
		$queryresultMatchAway = mysql_query($sqlMatchAway)
			or die(mysql_error());
		// end checking
		//check result
		$sqlMatchAnalysis = "SELECT * FROM matchanalysis WHERE analysisMatch='$matchID'";
		$queryresultMatchAnalysis = mysql_query($sqlMatchAnalysis)
			or die(mysql_error());
		$result1 = 0;
		$result2 = 0;
		$MatchAnalysisRowsNumber = mysql_num_rows($queryresultMatchAnalysis);
		$result1 = 0;
		$result2 = 0;
		$penaltiesTeam1 = 0;
		$penaltiesTeam2 = 0;
		$MatchAnalysisRowsNumber = mysql_num_rows($queryresultMatchAnalysis);
		if ($MatchAnalysisRowsNumber == 0) {
			$result1 = "";
			$result2 = "";
			$penaltiesTeam1 = "";
			$penaltiesTeam2 = "";

		}
		else {
			while($rowMatchAnalysis = mysql_fetch_assoc($queryresultMatchAnalysis)){
				$Mins = $rowMatchAnalysis['analysisMins'];
				$half = $rowMatchAnalysis['analysisHalf'];
				$Player = $rowMatchAnalysis['analysisPlayer'];
				$team = $rowMatchAnalysis['analysisTeam'];
				$analysEvent = $rowMatchAnalysis['analysisEvent'];
				if ($half == 0 && $Mins == 90) {
					if ($result1 != 0 || $result2 != 0) {

					}
					else {
						$result1 = 0;
						$result2 = 0;
					}
				}
				elseif ($analysEvent == 2 && ($half == 1 OR $half == 2 OR $half == 3 OR $half == 4)) {
					if ($team == $team1) {
						$result1 ++;
					}
					elseif ($team == $team2) {
						$result2 ++;
					}
				}
				elseif ($analysEvent == 2 && $half == 5) {
					if ($team == $team1) {
						$penaltiesTeam1 ++;
					}
					elseif ($team == $team2) {
						$penaltiesTeam2 ++;
					}
				}
			}
		}
		//end of checking result
		$outputTable = "";
		$dateMatch = date("d-m-Y",strtotime($dateMatch));
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
				$outputTable .= "<td class=\"whiteBorder\">".TeamNameAr($team1)."</td>";
				$outputTable .= "<td class=\"whiteBorder\"><a href=\"../liveMatch.php?match=$matchID\"> $result1 - $result2 </a></td>";
				$outputTable .= "<td class=\"whiteBorder\">".TeamNameAr($team2)." </td>";
				$outputTable .= "<td class=\"whiteBorder\">$time</td>";
				$outputTable .= "<td class=\"whiteBorder\"> «·ÃÊ·… ".$round."</td>";
				$outputTable .= "<td class=\"whiteBorder\"> </td>";
			}
			else {
				$outputTable .=  "<tr class=\"hilalMatches\">";
				$outputTable .= "<td class=\"whiteBorder\"> </td>";
				$outputTable .= "<td class=\"whiteBorder\">".TeamNameAr($team1)."</td>";
				if (trim($penaltiesTeam1) == "" || trim($penaltiesTeam2) == "" || ($penaltiesTeam1 == 0 && $penaltiesTeam2 == 0)) {
					$outputTable .= "<td class=\"whiteBorder\"><a href=\"../liveMatch.php?match=$matchID\"> $result1 - $result2 </a></td>";
				} else {
					$outputTable .= "<td class=\"whiteBorder\"><a href=\"../liveMatch.php?match=$matchID\"> $result1 - $result2 ";
					$outputTable .= "<br> ($penaltiesTeam1 - $penaltiesTeam2) </a></td>";
				}
				$outputTable .= "<td class=\"whiteBorder\">".TeamNameAr($team2)." </td>";
				$outputTable .= "<td class=\"whiteBorder\">$time</td>";
				$outputTable .= "<td class=\"whiteBorder\"> «·ÃÊ·… ".$round."</td>";
				$outputTable .= "<td class=\"whiteBorder\"> </td>";
			}
		}
		else {
			if (trim($result1) == "" || trim($result2) == "") {
				$outputTable .= "<tr class=\"Matches\">";
				$outputTable .= "<td class=\"whiteBorder\"> <input type=\"checkbox\" checked=\"checked\" name=\"matchs[]\" value=\"$matchID\"></td>";
				$outputTable .= "<td class=\"whiteBorder\">".TeamNameAr($team1)."</td>";
				$outputTable .= "<td class=\"whiteBorder\"> <input type=\"text\" id=\"$matchID$team1\" name=\"$matchID$team1\" class=\"result\"> - <input type=\"text\" id=\"$matchID$team2\" name=\"$matchID$team2\" class=\"result\"";
				if (mysql_num_rows($queryresultMatchAway) != 0) {
					$outputTable .= "></td>";
				}
				else {
					$outputTable .= "onchenge=\"CheckDraw('$team1','$team2','$team1$team2');\"> <div id=\"$team1$team2\"></div> </td>";
				}
				$outputTable .= "<td class=\"whiteBorder\">".TeamNameAr($team2)." </td>";
				$outputTable .= "<td class=\"whiteBorder\">$time</td>";
				$outputTable .= "<td class=\"whiteBorder\"> «·ÃÊ·… ".$round."</td>";
				$outputTable .= "<td class=\"whiteBorder\"> </td>";
			}
			else {
				$outputTable .= "<tr class=\"Matches\">";
				$outputTable .= "<td class=\"whiteBorder\"> </td>";
				$outputTable .= "<td class=\"whiteBorder\">".TeamNameAr($team1)."</td>";
				if (trim($penaltiesTeam1) == "" || trim($penaltiesTeam2) == "" || ($penaltiesTeam1 == 0 && $penaltiesTeam2 == 0)) {
					$outputTable .= "<td class=\"whiteBorder\"> $result1 - $result2 </td>";
				} else {
					$outputTable .= "<td class=\"whiteBorder\"> $result1 - $result2 ";
					$outputTable .= "<br> ($penaltiesTeam1 - $penaltiesTeam2) </td>";
				}
				$outputTable .= "<td class=\"whiteBorder\">".TeamNameAr($team2)." </td>";
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
	echo "<script type=\"text/javascript\" src=\"../js/getRequest.js\"></script>\n<script type=\"text/javascript\" src=\"../js/checkResult.js\"></script>\n";
	echo "	<tr>\n";
	echo "	<td colspan=\"7\" class=\"whiteBorder\"><input type=\"submit\" value=\"Add content\"></td>\n";
	echo "	</tr>\n";
	echo "</table>\n";
	echo "</form>\n";
	echo "</div>";
}

if (isset($_POST['matchs']) && isset($_GET["League"]) && isset($_GET["Season"])) {
	$matchs = $_POST['matchs'];
	$League = $_GET["League"];
	$SeasonIDGet = $_GET["Season"];

	foreach ($matchs as $match){
		$sqlMatch = "SELECT * FROM `matchcenter`.`match` WHERE matchID='$match'";
		$queryresultMatch = mysql_query($sqlMatch)
		or die(mysql_error());
		$rowMatch = mysql_fetch_assoc($queryresultMatch);
		$team1ID = $rowMatch['matchTeamHome'];
		$team2ID = $rowMatch['matchTeamAway'];
		$PostTeam1ID = "$match$team1ID";
		$PostTeam2ID = "$match$team2ID";
		$team1Result = $_POST[$PostTeam1ID];
		$team2Result = $_POST[$PostTeam2ID];

		if (trim($team1Result) != "" && trim($team2Result) != "") {
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
		} else {
			echo "<script type=\"text/javascript\">";
			echo "alert('ÌÃ» ≈œŒ«· ‰ ÌÃ… ’ÕÌÕ…');</script>";
		}
	}
	$redirectURL = "AddCompResults.php?";
	$redirectURL .= "League=";
	$redirectURL .= $League;
	$redirectURL .= "&Season=";
	$redirectURL .= $SeasonIDGet;
	if (isset($_GET["Round"])) {
		$RoundIDGet = $_GET["Round"];
		$redirectURL .= "&Round=";
		$redirectURL .= $RoundIDGet;
	}
	if (isset($_GET["Group"])) {
		$RoundIDGet = $_GET["Group"];
		$redirectURL .= "&Group=";
		$redirectURL .= $RoundIDGet;
	}
	header("location: $redirectURL") ;
}

elseif (isset($_POST['matchs']) && isset($_GET["Cup"]) && isset($_GET["Season"]) && isset($_GET["Round"])) {
	$matchs = $_POST['matchs'];
	$League = $_GET["Cup"];
	$SeasonIDGet = $_GET["Season"];
	$RoundIDGet = $_GET["Round"];

	foreach ($matchs as $match){
		$sqlMatch = "SELECT * FROM `matchcenter`.`match` WHERE matchID='$match'";
		$queryresultMatch = mysql_query($sqlMatch)
		or die(mysql_error());
		$rowMatch = mysql_fetch_assoc($queryresultMatch);
		$matchSeason = $rowMatch['matchSeason'];
		$matchComp = $rowMatch['matchComp'];
		$matchRound = $rowMatch['matchRound'];
		$matchGroup = $rowMatch['matchGroup'];
		$team1ID = $rowMatch['matchTeamHome'];
		$team2ID = $rowMatch['matchTeamAway'];
		$PostTeam1ID = "$match$team1ID";
		$PostTeam2ID = "$match$team2ID";
		$team1Result = $_POST[$PostTeam1ID];
		$team2Result = $_POST[$PostTeam2ID];

		if (trim($team1Result) != "" && trim($team2Result) != "") {
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
			// start adding penalty kicks --------------------------
			if ($team1Result == $team2Result) {
				$team1PenaltiesPost = "P$team1ID";
				$team2PenaltiesPost = "P$team2ID";
				$team1Penalties = $_POST[$team1PenaltiesPost];
				$team2Penalties = $_POST[$team2PenaltiesPost];
				for ($Goal = 0; $Goal < $team1Penalties; $Goal++) {
					$sqlMatchAnalysisP1 = "INSERT INTO matchanalysis (`analysisMatch`,`analysisTeam`,`analysisPlayer`,`analysisEvent`,`analysisHalf`,`analysisMins`,`analysisComment`)
				VALUES ('$match','$team1ID','0','2','5','1','0');";
					mysql_query($sqlMatchAnalysisP1) or die (mysql_error());
				}
				for ($Goal = 0; $Goal < $team2Penalties; $Goal++) {
					$sqlMatchAnalysisP2 = "INSERT INTO matchanalysis (`analysisMatch`,`analysisTeam`,`analysisPlayer`,`analysisEvent`,`analysisHalf`,`analysisMins`,`analysisComment`)
				VALUES ('$match','$team2ID','0','2','5','1','0');";
					mysql_query($sqlMatchAnalysisP2) or die (mysql_error());
				}
				$sqlMatchAnalysisEnd = "INSERT INTO matchanalysis (`analysisMatch`,`analysisTeam`,`analysisPlayer`,`analysisEvent`,`analysisHalf`,`analysisMins`,`analysisComment`)
				VALUES ('$match','0','0','0','0','130','9');";
				mysql_query($sqlMatchAnalysisEnd) or die (mysql_error());
			}
			// end adding penalty kicks --------------------------
			else {
				$sqlMatchAnalysisEnd = "INSERT INTO matchanalysis (`analysisMatch`,`analysisTeam`,`analysisPlayer`,`analysisEvent`,`analysisHalf`,`analysisMins`,`analysisComment`)
				VALUES ('$match','0','0','0','0','90','9');";
				mysql_query($sqlMatchAnalysisEnd) or die (mysql_error());
			}
		} else {
			echo "<script type=\"text/javascript\">";
			echo "alert('ÌÃ» ≈œŒ«· ‰ ÌÃ… ’ÕÌÕ…');</script>";
		}
		$sqlMatch2 = "SELECT * FROM `matchcenter`.`match` WHERE matchSeason='$matchSeason' AND matchComp='$matchComp' AND matchRound='$matchRound'
		AND matchGroup='$matchGroup' AND matchTeamHome='$team2ID' AND matchTeamAway='$team1ID'";
		$queryresultMatch2 = mysql_query($sqlMatch2)
			or die(mysql_error());
		$rowMatch2 = mysql_num_rows($queryresultMatch2);
		$matchNextRound = $matchRound / 2;
		if ($rowMatch2 == 0) {
			if ($team1Result < $team2Result) {
				$winnerTeam = $team2ID;
			}
			elseif ($team1Result > $team2Result) {
				$winnerTeam = $team1ID;
			}
			else {
				if ($team1Penalties < $team2Penalties) {
					$winnerTeam = $team2ID;
				}
				elseif ($team1Penalties > $team2Penalties) {
					$winnerTeam = $team1ID;
				}
			}
			switch($matchGroup){
				case 1:
					$sql = "UPDATE `matchcenter`.`match` SET matchTeamHome='$winnerTeam'
		WHERE matchSeason='$matchSeason' AND matchComp='$matchComp' AND matchRound='$matchNextRound'
		AND matchGroup='1'";
					mysql_query($sql) or die (mysql_error());
					break;
				case 2:
					$sql = "UPDATE `matchcenter`.`match` SET matchTeamAway='$winnerTeam'
		WHERE matchSeason='$matchSeason' AND matchComp='$matchComp' AND matchRound='$matchNextRound'
		AND matchGroup='1'";
					mysql_query($sql) or die (mysql_error());
					break;
				case 3:
					$sql = "UPDATE `matchcenter`.`match` SET matchTeamHome='$winnerTeam'
		WHERE matchSeason='$matchSeason' AND matchComp='$matchComp' AND matchRound='$matchNextRound'
		AND matchGroup='2'";
					mysql_query($sql) or die (mysql_error());
					break;
				case 4:
					$sql = "UPDATE `matchcenter`.`match` SET matchTeamAway='$winnerTeam'
		WHERE matchSeason='$matchSeason' AND matchComp='$matchComp' AND matchRound='$matchNextRound'
		AND matchGroup='2'";
					mysql_query($sql) or die (mysql_error());
					break;
				case 5:
					$sql = "UPDATE `matchcenter`.`match` SET matchTeamHome='$winnerTeam'
		WHERE matchSeason='$matchSeason' AND matchComp='$matchComp' AND matchRound='$matchNextRound'
		AND matchGroup='3'";
					mysql_query($sql) or die (mysql_error());
					break;
				case 6:
					$sql = "UPDATE `matchcenter`.`match` SET matchTeamAway='$winnerTeam'
		WHERE matchSeason='$matchSeason' AND matchComp='$matchComp' AND matchRound='$matchNextRound'
		AND matchGroup='3'";
					mysql_query($sql) or die (mysql_error());
					break;
				case 7:
					$sql = "UPDATE `matchcenter`.`match` SET matchTeamHome='$winnerTeam'
		WHERE matchSeason='$matchSeason' AND matchComp='$matchComp' AND matchRound='$matchNextRound'
		AND matchGroup='4'";
					mysql_query($sql) or die (mysql_error());
					break;
				case 8:
					$sql = "UPDATE `matchcenter`.`match` SET matchTeamAway='$winnerTeam'
		WHERE matchSeason='$matchSeason' AND matchComp='$matchComp' AND matchRound='$matchNextRound'
		AND matchGroup='4'";
					mysql_query($sql) or die (mysql_error());
					break;
			} // switch
		}
		else {
			$rowMatch2 = mysql_fetch_assoc($queryresultMatch2);
			$SecondMatch = $rowMatch2['matchID'];
			// for the second leg check if it's played or no
		}
	}
	$redirectURL = "AddCompResults.php?";
	$redirectURL .= "Cup=";
	$redirectURL .= $League;
	$redirectURL .= "&Season=";
	$redirectURL .= $SeasonIDGet;
	$redirectURL .= "&Round=";
	$redirectURL .= $RoundIDGet;
	header("location: $redirectURL") ;
}

// making footer
echo makeFooter();

?>