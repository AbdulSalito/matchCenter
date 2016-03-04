<?php
	// ask for the functions from it's file
	require_once('Functions.php');
include 'AdminPages/db_conn.php';
// insert the header
echo makeHeaderSimple("'Show matchs","ar");
// insert the navigation

if (isset($_GET["League"]) && isset($_GET["Season"]) && isset($_GET["Team"])) {
	$LeagueName = $_GET["League"];
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
	// get the start date and end date of the selected season
	$sqlMatch = "SELECT * FROM `matchcenter`.`match` WHERE matchComp='$LeagueName' AND (matchDate >= '$dateStarting' AND matchDate <= '$dateFinishin') AND
	(matchTeamHome='$TeamIdGet' OR matchTeamAway='$TeamIdGet') ORDER BY matchDate,matchTime,matchRound,matchTime,matchTeamHome";
	$queryresultMatch = mysql_query($sqlMatch)
			or die(mysql_error());
	$previousMatchDate = "";
	$sqlComp = "SELECT * FROM competition WHERE compID='$LeagueName'";
	$queryresultComp = mysql_query($sqlComp)
	or die(mysql_error());
	$rowComp = mysql_fetch_assoc($queryresultComp);
	$CompSys = $rowComp['compSys'];
	mysql_free_result($queryresultComp);

	while($rowMatch = mysql_fetch_assoc($queryresultMatch)){
		$dateMatch = $rowMatch['matchDate'];
		$team1 = $rowMatch['matchTeamHome'];
		$team2 = $rowMatch['matchTeamAway'];
		$time = $rowMatch['matchTime'];
		$matchID = $rowMatch['matchID'];
		$round = $rowMatch['matchRound'];
		$group = $rowMatch['matchGroup'];
		$comment = $rowMatch['matchComment'];
		//check result
		$sqlMatchAnalysis = "SELECT * FROM matchanalysis WHERE analysisMatch='$matchID'";
		$queryresultMatchAnalysis = mysql_query($sqlMatchAnalysis)
			or die(mysql_error());
		$result1 = 0;
		$result2 = 0;
		$penaltiesTeam1 = 0;
		$penaltiesTeam2 = 0;
		$MatchAnalysisRowsNumber = mysql_num_rows($queryresultMatchAnalysis);
		if ($MatchAnalysisRowsNumber == 0) {
			$result1 = "";
			$result2 = "";
			$goals1 = "";
			$goals2 = "";
			$penaltiesTeam1 = "";
			$penaltiesTeam2 = "";

		}
		else {
			$goals1 = "<table class=\"goalsTeam1\">\n";
			$goals2 = "<table class=\"goalsTeam2\">\n";
			while($rowMatchAnalysis = mysql_fetch_assoc($queryresultMatchAnalysis)){
				$Mins = $rowMatchAnalysis['analysisMins'];
				$half = $rowMatchAnalysis['analysisHalf'];
				$Player = $rowMatchAnalysis['analysisPlayer'];
				$team = $rowMatchAnalysis['analysisTeam'];
				$analysEvent = $rowMatchAnalysis['analysisEvent'];
				$analysPenalty = $rowMatchAnalysis['analysisPenalty'];
				/*if ($half == 0 && $Mins == 90) {
					if ($result1 != 0 || $result2 != 0) {

					}
					else {
						$result1 = 0;
						$result2 = 0;
					}
				}
				else*/
				if ($analysEvent == 2 && ($half == 1 OR $half == 2 OR $half == 3 OR $half == 4)) {
					if ($Player == 0) {
						$playerName = "unKnown";
					}
					else {
						if ($analysPenalty == 2) {
							$playerName = "<a href=\"player.php?ID=$Player\">";
							$playerName .= playerShortNameAr($Player);
							$playerName .= "</a>";
							$playerName .= " (p)";
						}
						elseif ($analysPenalty == 5) {
							$playerName = "<a href=\"player.php?ID=$Player\">";
							$playerName .= playerShortNameAr($Player);
							$playerName .= "</a>";
							$playerName .= " (OG)";
						}
						else {
							$playerName = "<a href=\"player.php?ID=$Player\">";
							$playerName .= playerShortNameAr($Player);
							$playerName .= "</a>";
						}
					}
					if ($team == $team1) {
						$goals1 .= "	<tr>\n";
						$goals1 .= "	<td class=\"goalsInMatch\">$Mins </td>\n";
						$goals1 .= "	<td class=\"goalsInMatch\">\n";
						$goals1 .= "$playerName";
						$goals1 .= "</td>\n";
						$goals1 .= "	</tr>\n";
						$result1 ++;
					}
					elseif ($team == $team2) {
						$goals2 .= "	<tr>\n";
						$goals2 .= "	<td class=\"goalsInMatch\">\n";
						$goals2 .= "$playerName";
						$goals2 .= "</td>\n";
						$goals2 .= "	<td class=\"goalsInMatch\">$Mins </td>\n";
						$goals2 .= "	</tr>\n";
						$result2 ++;
					}
				}
			}
			$goals1 .= "</table>\n";
			$goals2 .= "</table>\n";
		}
		//end of checking result
		$outputTable = "";
		$outputTable .= "<tr class=\"dates\"><td class=\"whiteBorder\" colspan=\"8\">";
		$dateDayEn = date('l', strtotime($dateMatch));
		$dateArr = array("Saturday"=>"«·”» ","Sunday"=>"«·√Õœ","Monday"=>"«·√À‰Ì‰","Tuesday"=>"«·À·«À«¡","Wednesday"=>"«·√—»⁄«¡","Thursday"=>"«·Œ„Ì”","Friday"=>"«·Ã„⁄…");
		$dateDayAr = $dateArr[$dateDayEn];
		$dateMatch = date("d-m-Y",strtotime($dateMatch));
		$outputTable .= "$dateDayAr $dateMatch</td></tr>";
		if ($team1 == "1" || $team2 == "1") {
			$strf=strtotime($time);
			$outputTable .=  "<tr class=\"hilalMatches\">";
			$outputTable .= "<td class=\"whiteBorder\">".teamNameAr($team1)."</td>";
			if (trim($penaltiesTeam1) == "" || trim($penaltiesTeam2) == "" || ($penaltiesTeam1 == 0 && $penaltiesTeam2 == 0)) {
				$outputTable .= "<td class=\"whiteBorder\"><a href=\"liveMatch.php?match=$matchID\"> $result1 - $result2 </a></td>";
			} else {
				$outputTable .= "<td class=\"whiteBorder\"><a href=\"liveMatch.php?match=$matchID\"> $result1 - $result2 ";
				$outputTable .= "<br> ($penaltiesTeam1 - $penaltiesTeam2) </a></td>";
			}
			$outputTable .= "<td class=\"whiteBorder\">".teamNameAr($team2)." </td>";

			//check if the match finished
			$sqlMatchAnalysis = "SELECT * FROM matchanalysis WHERE analysisMatch='$matchID' ORDER BY analysisID DESC";
			$queryresultMatchAnalysis = mysql_query($sqlMatchAnalysis)
				or die(mysql_error());
			while($rowMatchAnalysis = mysql_fetch_assoc($queryresultMatchAnalysis)){
				$Mins = $rowMatchAnalysis['analysisMins'];
				$half = $rowMatchAnalysis['analysisHalf'];
				if ($half == 0 && $Mins == 120) {
					$outputTable .= "<td class=\"whiteBorder\">$time</td>";
					break;
				}
				elseif ($half == 0 && $Mins == 90) {
					$outputTable .= "<td class=\"whiteBorder\">$time</td>";
					break;
				}
				else {
					$outputTable .= "<td class=\"whiteBorder\">$time<br>«·„»«—«… Ã«—Ì…</td>";
				}
			}
			//end of checking if the match finished

			if ($CompSys == 0) {
				$outputTable .= "<td class=\"whiteBorder\"> «·ÃÊ·… ".$round."</td>";
			}
			elseif ($CompSys == 1) {
				if ($round == 2) {
					$outputTable .= "<td class=\"whiteBorder\"> «·‰‹Â«∆Ì</td>";
				} elseif ($round == 3) {
					$outputTable .= "<td class=\"whiteBorder\">  ÕœÌœ «·„—ﬂ“ «·À«·À</td>";
				} else {
					$outputTable .= "<td class=\"whiteBorder\"> œÊ— «·‹ ".$round."</td>";
				}
			}
			elseif ($CompSys == 2) {
				if ($round == 32) {
					$outputTable .= "<td class=\"whiteBorder\">«·„Ã„Ê⁄…".$group."</td>";
				} elseif ($round == 2) {
					$outputTable .= "<td class=\"whiteBorder\"> «·‰‹Â«∆Ì</td>";
				} elseif ($round == 3) {
					$outputTable .= "<td class=\"whiteBorder\">  ÕœÌœ «·„—ﬂ“ «·À«·À</td>";
				} else {
					$outputTable .= "<td class=\"whiteBorder\"> œÊ— «·‹ ".$round."</td>";
				}
			}
			$outputTable .= "<td class=\"whiteBorder\"> $goals1</td>";
			$outputTable .= "<td class=\"whiteBorder\"> $goals2</td>";
		}
		else {
			$outputTable .= "<tr class=\"Matches\">";
			$outputTable .= "<td class=\"whiteBorder\">".teamNameAr($team1)."</td>";
			if ((trim($penaltiesTeam1) == "" || trim($penaltiesTeam2) == "") || ($penaltiesTeam1 == 0 && $penaltiesTeam2 == 0)) {
				$outputTable .= "<td class=\"whiteBorder\">$result1 - $result2</td>";
			} else {
				$outputTable .= "<td class=\"whiteBorder\"> $result1 - $result2 ";
				$outputTable .= "<br> ($penaltiesTeam1 - $penaltiesTeam2)</td>";
			}
			$outputTable .= "<td class=\"whiteBorder\">".teamNameAr($team2)." </td>";
			$outputTable .= "<td class=\"whiteBorder\">$time</td>";
			if ($CompSys == 0) {
				$outputTable .= "<td class=\"whiteBorder\"> «·ÃÊ·… ".$round."</td>";
			}
			elseif ($CompSys == 1) {
				if ($round == 2) {
					$outputTable .= "<td class=\"whiteBorder\"> «·‰‹Â«∆Ì</td>";
				} elseif ($round == 3) {
					$outputTable .= "<td class=\"whiteBorder\">  ÕœÌœ «·„—ﬂ“ «·À«·À</td>";
				} else {
					$outputTable .= "<td class=\"whiteBorder\"> œÊ— «·‹ ".$round."</td>";
				}
			}
			elseif ($CompSys == 2) {
				if ($round == 32) {
					$outputTable .= "<td class=\"whiteBorder\">«·„Ã„Ê⁄…".$group."</td>";
				} elseif ($round == 2) {
					$outputTable .= "<td class=\"whiteBorder\"> «·‰‹Â«∆Ì</td>";
				} elseif ($round == 3) {
					$outputTable .= "<td class=\"whiteBorder\">  ÕœÌœ «·„—ﬂ“ «·À«·À</td>";
				} else {
					$outputTable .= "<td class=\"whiteBorder\"> œÊ— «·‹ ".$round."</td>";
				}
			}
			$outputTable .= "<td class=\"whiteBorder\"> </td>";
			$outputTable .= "<td class=\"whiteBorder\"> </td>";
		}
		if ($comment == 0) {
			$outputTable .= "";
		}
		else {
			$sqlComment = "SELECT * FROM comment WHERE commentID='$comment'";
			$queryresultComment = mysql_query($sqlComment)
				or die(mysql_error());
			$rowcomment = mysql_fetch_assoc($queryresultComment);
			$commentText = $rowcomment['commentText'];
			mysql_free_result($queryresultComment);
			$outputTable .= "</tr>";
			$outputTable .= "<tr class=\"hilalMatches\"><td class=\"whiteBorder\" colspan=\"8\">";
			$outputTable .= "<font class=\"Comment\">$commentText</font>";
			$outputTable .= "</td></tr>";
		}

		$outputTable .= "</tr>";
		echo $outputTable;
	}
	mysql_free_result($queryresultMatch);
}

elseif (isset($_GET["League"]) && isset($_GET["Season"])) {
	$LeagueName = $_GET["League"];
	$Season = $_GET["Season"];

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

	if (isset($_GET['Group'])) {
		$whereClause = " AND matchGroup='".$_GET['Group']."' AND matchRound='32' ";
	} else {
		$whereClause = "";
	}
	if (isset($_GET['Round'])) {
		$whereClause = " AND matchRound='".$_GET['Round']."' ";
	} else {
		$whereClause = "";
	}
	// get the start date and end date of the selected season
	$sqlMatch = "SELECT * FROM `matchcenter`.`match` WHERE matchComp='$LeagueName' AND (matchDate >= '$dateStarting' AND matchDate <= '$dateFinishin') $whereClause
	ORDER BY matchDate,matchGroup,matchTime,matchRound,matchTime,matchTeamHome";
	$queryresultMatch = mysql_query($sqlMatch)
			or die(mysql_error());
	$previousMatchDate = "";
	$sqlComp = "SELECT * FROM competition WHERE compID='$LeagueName'";
	$queryresultComp = mysql_query($sqlComp)
	or die(mysql_error());
	$rowComp = mysql_fetch_assoc($queryresultComp);
	$CompSys = $rowComp['compSys'];
	mysql_free_result($queryresultComp);

	while($rowMatch = mysql_fetch_assoc($queryresultMatch)){
		$dateMatch = $rowMatch['matchDate'];
		$team1 = $rowMatch['matchTeamHome'];
		$team2 = $rowMatch['matchTeamAway'];
		$time = $rowMatch['matchTime'];
		$matchID = $rowMatch['matchID'];
		$round = $rowMatch['matchRound'];
		$stad = $rowMatch['matchStadium'];
		$group = $rowMatch['matchGroup'];
		$comment = $rowMatch['matchComment'];

		//check result
		$sqlMatchAnalysis = "SELECT * FROM matchanalysis WHERE analysisMatch='$matchID'";
		$queryresultMatchAnalysis = mysql_query($sqlMatchAnalysis)
			or die(mysql_error());
		$result1 = 0;
		$result2 = 0;
		$penaltiesTeam1 = 0;
		$penaltiesTeam2 = 0;
		$MatchAnalysisRowsNumber = mysql_num_rows($queryresultMatchAnalysis);
		if ($MatchAnalysisRowsNumber == 0) {
			$result1 = "";
			$result2 = "";
			$goals1 = "";
			$goals2 = "";
			$penaltiesTeam1 = "";
			$penaltiesTeam2 = "";

		}
		else {
			$goals1 = "<table class=\"goalsTeam1\">\n";
			$goals2 = "<table class=\"goalsTeam2\">\n";
			while($rowMatchAnalysis = mysql_fetch_assoc($queryresultMatchAnalysis)){
				$Mins = $rowMatchAnalysis['analysisMins'];
				$half = $rowMatchAnalysis['analysisHalf'];
				$Player = $rowMatchAnalysis['analysisPlayer'];
				$team = $rowMatchAnalysis['analysisTeam'];
				$analysEvent = $rowMatchAnalysis['analysisEvent'];
				$analysPenalty = $rowMatchAnalysis['analysisPenalty'];
				if ($half == 0 && $Mins == 90) {
					if ($result1 != 0 || $result2 != 0) {

					}
					else {
						$result1 = 0;
						$result2 = 0;
					}
				}
				elseif ($analysEvent == 2 && ($half == 1 OR $half == 2 OR $half == 3 OR $half == 4)) {
					if ($Player == 0) {
						$playerName = "unKnown";
					}
					else {
						if ($analysPenalty == 2) {
							$playerName = "<a href=\"player.php?ID=$Player\">";
							$playerName .= playerShortNameAr($Player);
							$playerName .= "</a>";
							$playerName .= " (p)";
						}
						elseif ($analysPenalty == 5) {
							$playerName = "<a href=\"player.php?ID=$Player\">";
							$playerName .= playerShortNameAr($Player);
							$playerName .= "</a>";
							$playerName .= " (OG)";
						}
						else {
							$playerName = "<a href=\"player.php?ID=$Player\">";
							$playerName .= playerShortNameAr($Player);
							$playerName .= "</a>";
						}
					}
					if ($team == $team1) {
						$goals1 .= "	<tr>\n";
						$goals1 .= "	<td class=\"goalsInMatch\">$Mins </td>\n";
						$goals1 .= "	<td class=\"goalsInMatch\">\n";
						$goals1 .= "$playerName";
						$goals1 .= "</td>\n";
						$goals1 .= "	</tr>\n";
						$result1 ++;
					}
					elseif ($team == $team2) {
						$goals2 .= "	<tr>\n";
						$goals2 .= "	<td class=\"goalsInMatch\">\n";
						$goals2 .= "$playerName";
						$goals2 .= "</td>\n";
						$goals2 .= "	<td class=\"goalsInMatch\">$Mins </td>\n";
						$goals2 .= "	</tr>\n";
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
			$goals1 .= "</table>\n";
			$goals2 .= "</table>\n";
		}
		//end of checking result
		$outputTable = "";
		$dateMatch = date("d-m-Y",strtotime($dateMatch));
		if ($previousMatchDate != $dateMatch) {
			$outputTable .= "<tr class=\"dates\"><td class=\"whiteBorder\" colspan=\"8\">";
			$dateDayEn = date('l', strtotime($dateMatch));
			$dateArr = array("Saturday"=>"«·”» ","Sunday"=>"«·√Õœ","Monday"=>"«·√À‰Ì‰","Tuesday"=>"«·À·«À«¡","Wednesday"=>"«·√—»⁄«¡","Thursday"=>"«·Œ„Ì”","Friday"=>"«·Ã„⁄…");
			$dateDayAr = $dateArr[$dateDayEn];
			$outputTable .= "$dateDayAr $dateMatch</td></tr>";
		}
		if ($team1 == "1" || $team2 == "1") {
			$strf=strtotime($time);
			$outputTable .=  "<tr class=\"hilalMatches\">";
			$outputTable .= "<td class=\"whiteBorder\">".teamNameAr($team1)."</td>";
			if (trim($penaltiesTeam1) == "" || trim($penaltiesTeam2) == "" || ($penaltiesTeam1 == 0 && $penaltiesTeam2 == 0)) {
				$outputTable .= "<td class=\"whiteBorder\"><a href=\"liveMatch.php?match=$matchID\"> $result1 - $result2 </a></td>";//
			} else {
				$outputTable .= "<td class=\"whiteBorder\"><a href=\"liveMatch.php?match=$matchID\"> $result1 - $result2 ";
				$outputTable .= "<br> ($penaltiesTeam1 - $penaltiesTeam2) </a></td>";
			}
			$outputTable .= "<td class=\"whiteBorder\">".teamNameAr($team2)." </td>";
			//check if the match finished
			$sqlMatchAnalysis = "SELECT * FROM matchanalysis WHERE analysisMatch='$matchID' ORDER BY analysisID DESC";
			$queryresultMatchAnalysis = mysql_query($sqlMatchAnalysis)
				or die(mysql_error());
			if (mysql_num_rows($queryresultMatchAnalysis) == 0) {
				$outputTable .= "<td class=\"whiteBorder\">$time</td>";
			}
			while($rowMatchAnalysis = mysql_fetch_assoc($queryresultMatchAnalysis)){
				$Mins = $rowMatchAnalysis['analysisMins'];
				$half = $rowMatchAnalysis['analysisHalf'];
				if ($half == 0 && $Mins == 120) {
					$outputTable .= "<td class=\"whiteBorder\">$time</td>";
					break;
				}
				elseif ($half == 0 && $Mins == 90) {
					$outputTable .= "<td class=\"whiteBorder\">$time</td>";
					break;
				}
				else {
					$outputTable .= "<td class=\"whiteBorder\">$time<br>«·„»«—«… Ã«—Ì…</td>";
				}
			}
			//end of checking if the match finished
			//$outputTable .= "<td class=\"whiteBorder\">$time</td>";
			if ($CompSys == 0) {
				$outputTable .= "<td class=\"whiteBorder\"> «·ÃÊ·… ".$round."</td>";
			}
			elseif ($CompSys == 1) {
				if ($round == 2) {
					$outputTable .= "<td class=\"whiteBorder\"> «·‰‹Â«∆Ì</td>";
				} elseif ($round == 3) {
					$outputTable .= "<td class=\"whiteBorder\">  ÕœÌœ «·„—ﬂ“ «·À«·À</td>";
				} else {
					$outputTable .= "<td class=\"whiteBorder\"> œÊ— «·‹ ".$round."</td>";
				}
			}
			elseif ($CompSys == 2) {
				if ($round == 32) {
					$outputTable .= "<td class=\"whiteBorder\">«·„Ã„Ê⁄…".$group."</td>";
				} elseif ($round == 2) {
					$outputTable .= "<td class=\"whiteBorder\"> «·‰‹Â«∆Ì</td>";
				} elseif ($round == 3) {
					$outputTable .= "<td class=\"whiteBorder\">  ÕœÌœ «·„—ﬂ“ «·À«·À</td>";
				} else {
					$outputTable .= "<td class=\"whiteBorder\"> œÊ— «·‹ ".$round."</td>";
				}
			}
			$outputTable .= "<td class=\"whiteBorder\"> $goals1</td>";
			$outputTable .= "<td class=\"whiteBorder\"> $goals2</td>";
			/// insert Links
			if (trim($result1) == "" || trim($result2) == "") {
				$outputTable .= "<td class=\"whiteBorder\"><font class=\"small\">".StadiumName($stad,"ar")."</font></td>";
			}
			else {
				$outputTable .= "<td class=\"whiteBorder\">";

				$sqlLinks = "SELECT * FROM links WHERE linkMatch='$matchID'";
				$queryresultLinks = mysql_query($sqlLinks)
					or die(mysql_error());
				$outputTable .= "<table class=\"matchLinks\">"; //  border=\"0\" width=\"100%\" height=\"100%\" style=\"border-collapse: collapse\"
				while($rowLinks = mysql_fetch_assoc($queryresultLinks)){
					$video = $rowLinks['linkVideo'];
					$fullMatch = $rowLinks['linkFullMatch'];
					$pics = $rowLinks['linkPics'];
					if ($video != "0") {
						$outputTable .= "<tr><td class=\"matchLinks\">"; // <font face=\"Tahoma\" size=\"1\">
						$outputTable .= "<a target=\"_blank\" href=\"$video\">›ÌœÌÊ </a>";
						$outputTable .= "</td></tr>"; //</font>
					}
					if ($fullMatch != "0") {
						$outputTable .= "<tr><td class=\"matchLinks\">";
						$outputTable .= "<a target=\"_blank\" href=\"$fullMatch\">„»«—«… ﬂ«„·… </a>";
						$outputTable .= "</td></tr>";
					}
					if ($pics != "0") {
						$outputTable .= "<tr><td class=\"matchLinks\">";
						$outputTable .= "<a target=\"_blank\" href=\"$pics\">’Ê— </a>";
						$outputTable .= "</td></tr>";
					}
				}
				$outputTable .= "</table>";
				$outputTable .= "</td>";
			}
		}
		else {
			$outputTable .= "<tr class=\"Matches\">";
			$outputTable .= "<td class=\"whiteBorder\">".teamNameAr($team1)."</td>";
			if ((trim($penaltiesTeam1) == "" || trim($penaltiesTeam2) == "") || ($penaltiesTeam1 == 0 && $penaltiesTeam2 == 0)) {
				$outputTable .= "<td class=\"whiteBorder\">$result1 - $result2</td>";
			} else {
				$outputTable .= "<td class=\"whiteBorder\"> $result1 - $result2 ";
				$outputTable .= "<br> ($penaltiesTeam1 - $penaltiesTeam2)</td>";
			}
			$outputTable .= "<td class=\"whiteBorder\">".teamNameAr($team2)." </td>";
			$outputTable .= "<td class=\"whiteBorder\">$time</td>";
			if ($CompSys == 0) {
				$outputTable .= "<td class=\"whiteBorder\"> «·ÃÊ·… ".$round."</td>";
			}
			elseif ($CompSys == 1) {
				if ($round == 2) {
					$outputTable .= "<td class=\"whiteBorder\"> «·‰‹Â«∆Ì</td>";
				} elseif ($round == 3) {
					$outputTable .= "<td class=\"whiteBorder\">  ÕœÌœ «·„—ﬂ“ «·À«·À</td>";
				} else {
					$outputTable .= "<td class=\"whiteBorder\"> œÊ— «·‹ ".$round."</td>";
				}
			}
			elseif ($CompSys == 2) {
				if ($round == 32) {
					$outputTable .= "<td class=\"whiteBorder\">«·„Ã„Ê⁄…".$group."</td>";
				} elseif ($round == 2) {
					$outputTable .= "<td class=\"whiteBorder\"> «·‰‹Â«∆Ì</td>";
				} elseif ($round == 3) {
					$outputTable .= "<td class=\"whiteBorder\">  ÕœÌœ «·„—ﬂ“ «·À«·À</td>";
				} else {
					$outputTable .= "<td class=\"whiteBorder\"> œÊ— «·‹ ".$round."</td>";
				}
			}
			$outputTable .= "<td class=\"whiteBorder\"> </td>";
			$outputTable .= "<td class=\"whiteBorder\"> </td>";
			$outputTable .= "<td class=\"whiteBorder\"> </td>";
		}
		if ($comment == 0) {
			$outputTable .= "";
		}
		else {
			$sqlComment = "SELECT * FROM comment WHERE commentID='$comment'";
			$queryresultComment = mysql_query($sqlComment)
				or die(mysql_error());
			$rowcomment = mysql_fetch_assoc($queryresultComment);
			$commentText = $rowcomment['commentText'];
			mysql_free_result($queryresultComment);
			$outputTable .= "</tr>";
			$outputTable .= "<tr class=\"hilalMatches\"><td class=\"whiteBorder\" colspan=\"8\">";
			$outputTable .= "<font class=\"Comment\">$commentText</font>";
			$outputTable .= "</td></tr>";
		}

		$outputTable .= "</tr>";
		echo $outputTable;
		$previousMatchDate = $dateMatch;
	}
	mysql_free_result($queryresultMatch);
}

elseif (isset($_GET["Season"]) && isset($_GET["Team"])) {
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
	// get the start date and end date of the selected season
	$sqlMatch = "SELECT * FROM `matchcenter`.`match` WHERE (matchDate >= '$dateStarting' AND matchDate <= '$dateFinishin') AND
	(matchTeamHome='$TeamIdGet' OR matchTeamAway='$TeamIdGet') ORDER BY matchDate,matchTime,matchRound,matchTime,matchTeamHome";
	$queryresultMatch = mysql_query($sqlMatch)
			or die(mysql_error());

	while($rowMatch = mysql_fetch_assoc($queryresultMatch)){
		$dateMatch = $rowMatch['matchDate'];
		$team1 = $rowMatch['matchTeamHome'];
		$team2 = $rowMatch['matchTeamAway'];
		$time = $rowMatch['matchTime'];
		$matchID = $rowMatch['matchID'];
		$round = $rowMatch['matchRound'];
		$group = $rowMatch['matchGroup'];
		$comment = $rowMatch['matchComment'];
		$comp = $rowMatch['matchComp'];
		//check result
		$sqlMatchAnalysis = "SELECT * FROM matchanalysis WHERE analysisMatch='$matchID'";
		$queryresultMatchAnalysis = mysql_query($sqlMatchAnalysis)
			or die(mysql_error());
		$result1 = 0;
		$result2 = 0;
		$penaltiesTeam1 = 0;
		$penaltiesTeam2 = 0;
		$MatchAnalysisRowsNumber = mysql_num_rows($queryresultMatchAnalysis);
		if ($MatchAnalysisRowsNumber == 0) {
			$result1 = "";
			$result2 = "";
			$goals1 = "";
			$goals2 = "";
			$penaltiesTeam1 = "";
			$penaltiesTeam2 = "";

		}
		else {
			$goals1 = "<table class=\"goalsTeam1\">\n";
			$goals2 = "<table class=\"goalsTeam2\">\n";
			while($rowMatchAnalysis = mysql_fetch_assoc($queryresultMatchAnalysis)){
				$Mins = $rowMatchAnalysis['analysisMins'];
				$half = $rowMatchAnalysis['analysisHalf'];
				$Player = $rowMatchAnalysis['analysisPlayer'];
				$team = $rowMatchAnalysis['analysisTeam'];
				$analysEvent = $rowMatchAnalysis['analysisEvent'];
				$analysPenalty = $rowMatchAnalysis['analysisPenalty'];
				if ($half == 0 && $Mins == 90) {
					if ($result1 != 0 || $result2 != 0) {

					}
					else {
						$result1 = 0;
						$result2 = 0;
					}
				}
				elseif ($analysEvent == 2 && ($half == 1 OR $half == 2 OR $half == 3 OR $half == 4)) {
					if ($Player == 0) {
						$playerName = "unKnown";
					}
					else {
						if ($analysPenalty == 2) {
							$playerName = "<a href=\"player.php?ID=$Player\">";
							$playerName .= playerShortNameAr($Player);
							$playerName .= "</a>";
							$playerName .= " (p)";
						}
						elseif ($analysPenalty == 5) {
							$playerName = "<a href=\"player.php?ID=$Player\">";
							$playerName .= playerShortNameAr($Player);
							$playerName .= "</a>";
							$playerName .= " (OG)";
						}
						else {
							$playerName = "<a href=\"player.php?ID=$Player\">";
							$playerName .= playerShortNameAr($Player);
							$playerName .= "</a>";
						}
					}
					if ($team == $team1) {
						$goals1 .= "	<tr>\n";
						$goals1 .= "	<td class=\"goalsInMatch\">$Mins </td>\n";
						$goals1 .= "	<td class=\"goalsInMatch\">\n";
						$goals1 .= "$playerName";
						$goals1 .= "</td>\n";
						$goals1 .= "	</tr>\n";
						$result1 ++;
					}
					elseif ($team == $team2) {
						$goals2 .= "	<tr>\n";
						$goals2 .= "	<td class=\"goalsInMatch\">\n";
						$goals2 .= "$playerName";
						$goals2 .= "</td>\n";
						$goals2 .= "	<td class=\"goalsInMatch\">$Mins </td>\n";
						$goals2 .= "	</tr>\n";
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
			$goals1 .= "</table>\n";
			$goals2 .= "</table>\n";
		}
		//end of checking result
		// start checking the competition
		$sqlComp = "SELECT * FROM competition WHERE compID='$comp'";
		$queryresultComp = mysql_query($sqlComp)
			or die(mysql_error());
		$rowComp = mysql_fetch_assoc($queryresultComp);
		$CompSys = $rowComp['compSys'];
		$CompNameAr = $rowComp['compNameAr'];
		mysql_free_result($queryresultComp);
		// End checking the competition
		$outputTable = "";
		$outputTable .= "<tr class=\"dates\"><td class=\"whiteBorder\" colspan=\"7\">";
		$dateDayEn = date('l', strtotime($dateMatch));
		$dateArr = array("Saturday"=>"«·”» ","Sunday"=>"«·√Õœ","Monday"=>"«·√À‰Ì‰","Tuesday"=>"«·À·«À«¡","Wednesday"=>"«·√—»⁄«¡","Thursday"=>"«·Œ„Ì”","Friday"=>"«·Ã„⁄…");
		$dateDayAr = $dateArr[$dateDayEn];
		$dateMatch = date("d-m-Y",strtotime($dateMatch));
		$outputTable .= "$dateDayAr $dateMatch</td></tr>";
		if ($CompSys == 0) {
			$strf=strtotime($time);
			$outputTable .=  "<tr class=\"hilalMatches\">";
			$outputTable .= "<td class=\"whiteBorder\">".teamNameAr($team1)."</td>";
			if (trim($penaltiesTeam1) == "" || trim($penaltiesTeam2) == "" || ($penaltiesTeam1 == 0 && $penaltiesTeam2 == 0)) {
				$outputTable .= "<td class=\"whiteBorder\"><a href=\"liveMatch.php?match=$matchID\"> $result1 - $result2 </a></td>";
			} else {
				$outputTable .= "<td class=\"whiteBorder\"><a href=\"liveMatch.php?match=$matchID\"> $result1 - $result2 ";
				$outputTable .= "<br> ($penaltiesTeam1 - $penaltiesTeam2) </a></td>";
			}
			$outputTable .= "<td class=\"whiteBorder\">".teamNameAr($team2)." </td>";
			$outputTable .= "<td class=\"whiteBorder\">$time</td>";
			$outputTable .= "<td class=\"whiteBorder\">$CompNameAr <br> «·ÃÊ·… ".$round."</td>";
			$outputTable .= "<td class=\"whiteBorder\"> $goals1</td>";
			$outputTable .= "<td class=\"whiteBorder\"> $goals2</td>";
		}
		else {
			$outputTable .= "<tr class=\"Matches\">";
			$outputTable .= "<td class=\"whiteBorder\">".teamNameAr($team1)."</td>";
			if ((trim($penaltiesTeam1) == "" || trim($penaltiesTeam2) == "") || ($penaltiesTeam1 == 0 && $penaltiesTeam2 == 0)) {
				$outputTable .= "<td class=\"whiteBorder\">$result1 - $result2</td>";
			} else {
				$outputTable .= "<td class=\"whiteBorder\"> $result1 - $result2 ";
				$outputTable .= "<br> ($penaltiesTeam1 - $penaltiesTeam2)</td>";
			}
			$outputTable .= "<td class=\"whiteBorder\">".teamNameAr($team2)." </td>";
			$outputTable .= "<td class=\"whiteBorder\">$time</td>";
			if ($CompSys == 1) {
				if ($round == 2) {
					$outputTable .= "<td class=\"whiteBorder\">$CompNameAr <br> «·‰‹Â«∆Ì</td>";
				} elseif ($round == 3) {
					$outputTable .= "<td class=\"whiteBorder\">$CompNameAr <br>  ÕœÌœ «·„—ﬂ“ «·À«·À</td>";
				} else {
					$outputTable .= "<td class=\"whiteBorder\">$CompNameAr <br> œÊ— «·‹ ".$round."</td>";
				}
			}
			elseif ($CompSys == 2) {
				if ($round == 32) {
					$outputTable .= "<td class=\"whiteBorder\">$CompNameAr <br>«·„Ã„Ê⁄…".$group."</td>";
				} elseif ($round == 2) {
					$outputTable .= "<td class=\"whiteBorder\">$CompNameAr <br> «·‰‹Â«∆Ì</td>";
				} elseif ($round == 3) {
					$outputTable .= "<td class=\"whiteBorder\">$CompNameAr <br>  ÕœÌœ «·„—ﬂ“ «·À«·À</td>";
				} else {
					$outputTable .= "<td class=\"whiteBorder\">$CompNameAr <br> œÊ— «·‹ ".$round."</td>";
				}
			}
			$outputTable .= "<td class=\"whiteBorder\"> $goals1</td>";
			$outputTable .= "<td class=\"whiteBorder\"> $goals2</td>";
		}
		if ($comment == 0) {
			$outputTable .= "";
		}
		else {
			$sqlComment = "SELECT * FROM comment WHERE commentID='$comment'";
			$queryresultComment = mysql_query($sqlComment)
				or die(mysql_error());
			$rowcomment = mysql_fetch_assoc($queryresultComment);
			$commentText = $rowcomment['commentText'];
			mysql_free_result($queryresultComment);
			$outputTable .= "</tr>";
			$outputTable .= "<tr class=\"hilalMatches\"><td class=\"whiteBorder\" colspan=\"7\">";
			$outputTable .= "<font class=\"Comment\">$commentText</font>";
			$outputTable .= "</td></tr>";
		}

		$outputTable .= "</tr>";
		echo $outputTable;
	}
	mysql_free_result($queryresultMatch);
}

echo "</table>\n";

// making footer
echo makeFooterSimple();

?>