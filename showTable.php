<?php
	// ask for the functions from it's file
	require_once('Functions.php');
include 'AdminPages/db_conn.php';
// insert the header
echo makeHeaderSimple("'Show competition","ar");
// insert the navigation
if (isset($_GET['Team']) && isset($_GET["Comp"]) && isset($_GET["Season"])) {
	$LeagueName = $_GET["Comp"];
	$Season = $_GET["Season"];
	$teamID = $_GET["Team"];

	$sqlMatch = "SELECT * FROM `matchcenter`.`match` WHERE matchSeason='$Season' AND matchComp='$LeagueName' AND
	(matchTeamHome='$teamID' OR matchTeamAway='$teamID') ORDER BY matchGroup";
	$queryresultMatch = mysql_query($sqlMatch)
	or die(mysql_error());
	$playsH = 0;
	$winH = 0;
	$drawH = 0;
	$looseH = 0;
	$goalsForH = 0;
	$goalsAgainstH = 0;
	$pointsH = 0;
	$playsA = 0;
	$winA = 0;
	$drawA = 0;
	$looseA = 0;
	$goalsForA = 0;
	$goalsAgainstA = 0;
	$pointsA = 0;

	while($rowMatch = mysql_fetch_assoc($queryresultMatch)){
		$matchID = $rowMatch['matchID'];
		$matchTeam = $rowMatch['matchTeamHome'];
		//check result
		$sqlMatchAnalysis = "SELECT * FROM matchanalysis WHERE analysisMatch='$matchID'";
		$queryresultMatchAnalysis = mysql_query($sqlMatchAnalysis)
			or die(mysql_error());
		$result1 = 0;
		$result2 = 0;
		$MatchAnalysisRowsNumber = mysql_num_rows($queryresultMatchAnalysis);
		if ($MatchAnalysisRowsNumber == 0) {
			$result1 = 0;
			$result2 = 0;
		}
		else {
			while($rowMatchAnalysis = mysql_fetch_assoc($queryresultMatchAnalysis)){
				$Mins = $rowMatchAnalysis['analysisMins'];
				$half = $rowMatchAnalysis['analysisHalf'];
				$team = $rowMatchAnalysis['analysisTeam'];
				$analysEvent = $rowMatchAnalysis['analysisEvent'];
				if ($half == 0 && $Mins == 90) {
					if ($result1 != 0 || $result2 != 0) {
						break;
					}
					else {
						$result1 = 0;
						$result2 = 0;
					}
				}
				elseif ($analysEvent == 2) {
					if ($team == $teamID) {
						$result1 ++;
					}
					else {
						$result2 ++;
					}
				}
			}
			if ($result1 > $result2) {
				if ($teamID == $matchTeam) {
					$playsH ++;
					$winH ++ ;
					$goalsForH += $result1;
					$goalsAgainstH += $result2;
					$pointsH += 3;
				} else {
					$playsA ++;
					$winA ++ ;
					$goalsForA += $result1;
					$goalsAgainstA += $result2;
					$pointsA += 3;
				}
			}
			elseif ($result1 < $result2) {
				if ($teamID == $matchTeam) {
					$playsH ++;
					$looseH ++ ;
					$goalsForH += $result1;
					$goalsAgainstH += $result2;
					$pointsH += 0;
				} else {
					$playsA ++;
					$looseA ++ ;
					$goalsForA += $result1;
					$goalsAgainstA += $result2;
					$pointsA += 0;
				}
			}
			else {
				if ($teamID == $matchTeam) {
					$playsH ++;
					$drawH ++ ;
					$goalsForH += $result1;
					$goalsAgainstH += $result2;
					$pointsH += 1;
				} else {
					$playsA ++;
					$drawA ++ ;
					$goalsForA += $result1;
					$goalsAgainstA += $result2;
					$pointsA += 1;
				}
			}
		}
		//end of checking result
	}
	// Start filling each teams Table

	$outputTable = " <tr class=\"dates\"> ";
	$outputTable .= " <td colspan=\"16\"><h3>".TeamNameAr($teamID)."</h3></td>\n";
	$outputTable .= "</tr>\n";
	$outputTable .= " <tr class=\"dates\"> ";
	$outputTable .= " <td colspan=\"2\">·⁄»</td>\n";
	$outputTable .= " <td colspan=\"2\">›«“</td>\n";
	$outputTable .= " <td colspan=\"2\"> ⁄«œ·</td>\n";
	$outputTable .= " <td colspan=\"2\">Œ”—</td>\n";
	$outputTable .= " <td colspan=\"2\">·Â</td>\n";
	$outputTable .= " <td colspan=\"2\">⁄·ÌÂ</td>\n";
	$outputTable .= " <td colspan=\"2\">›«—ﬁ</td>\n";
	$outputTable .= " <td colspan=\"2\">‰ﬁ«ÿ</td>\n";
	$outputTable .= "</tr>\n";
	$outputTable .= " <tr class=\"Matches\"> ";
	$outputTable .= " <td colspan=\"2\">".($playsH + $playsA) ."</td>\n";
	$outputTable .= " <td colspan=\"2\">". ($winH + $winA )."</td>\n";
	$outputTable .= " <td colspan=\"2\">".($drawH + $drawA )."</td>\n";
	$outputTable .= " <td colspan=\"2\">".($looseH + $looseA) ."</td>\n";
	$outputTable .= " <td colspan=\"2\">".($goalsForH + $goalsForA)."</td>\n";
	$outputTable .= " <td colspan=\"2\">".($goalsAgainstH + $goalsAgainstA)."</td>\n";
	$gd = ($goalsForH + $goalsForA) - ($goalsAgainstH + $goalsAgainstA);
	if ($gd > 0) {
		$gd .= "+";
	}
	$outputTable .= " <td colspan=\"2\">".$gd ."</td>\n";
	$outputTable .= " <td colspan=\"2\">".($pointsH + $pointsA) ."</td>\n";
	$outputTable .= "</tr>\n";
	$outputTable .= " <tr class=\"dates\"> ";
	$outputTable .= " <td colspan=\"8\">›Ì „·⁄»Â</td>\n";
	$outputTable .= " <td colspan=\"8\">Œ«—Ã „·⁄»Â</td>\n";
	$outputTable .= "</tr>\n";
	$outputTable .= " <tr class=\"dates\"> ";
	$outputTable .= " <td>·⁄»</td>\n";
	$outputTable .= " <td>›«“</td>\n";
	$outputTable .= " <td> ⁄«œ·</td>\n";
	$outputTable .= " <td>Œ”—</td>\n";
	$outputTable .= " <td>·Â</td>\n";
	$outputTable .= " <td>⁄·ÌÂ</td>\n";
	$outputTable .= " <td>›«—ﬁ</td>\n";
	$outputTable .= " <td>‰ﬁ«ÿ</td>\n";
	$outputTable .= " <td>·⁄»</td>\n";
	$outputTable .= " <td>›«“</td>\n";
	$outputTable .= " <td> ⁄«œ·</td>\n";
	$outputTable .= " <td>Œ”—</td>\n";
	$outputTable .= " <td>·Â</td>\n";
	$outputTable .= " <td>⁄·ÌÂ</td>\n";
	$outputTable .= " <td>›«—ﬁ</td>\n";
	$outputTable .= " <td>‰ﬁ«ÿ</td>\n";
	$outputTable .= "</tr>\n";

	$outputTable .=  "<tr class=\"Matches\">";
	$gdH = $goalsForH - $goalsAgainstH;
	$gdA = $goalsForA - $goalsAgainstA;
	if ($gdH > 0) {
		$gdH .= "+";
	}
	if ($gdA > 0) {
		$gdA .= "+";
	}
	$outputTable .= "<td bgcolor=\"#C9D7FA\">$playsH</td>";
	$outputTable .= "<td bgcolor=\"#C9D7FA\">$winH</td>";
	$outputTable .= "<td bgcolor=\"#C9D7FA\">$drawH</td>";
	$outputTable .= "<td bgcolor=\"#C9D7FA\">$looseH</td>";
	$outputTable .= "<td bgcolor=\"#C9D7FA\">$goalsForH</td>";
	$outputTable .= "<td bgcolor=\"#C9D7FA\">$goalsAgainstH</td>";
	$outputTable .= "<td bgcolor=\"#C9D7FA\"> $gdH</td>";
	$outputTable .= "<td bgcolor=\"#C9D7FA\"> $pointsH</td>";
	$outputTable .= "<td>$playsA</td>";
	$outputTable .= "<td>$winA</td>";
	$outputTable .= "<td>$drawA</td>";
	$outputTable .= "<td>$looseA</td>";
	$outputTable .= "<td>$goalsForA</td>";
	$outputTable .= "<td>$goalsAgainstA</td>";
	$outputTable .= "<td> $gdA</td>";
	$outputTable .= "<td> $pointsA</td>";
	$outputTable .= "</tr>";
	$outputTable .= "</table>";
	//do nothing
	// Start adding to the team info
	echo "<table dir=\"rtl\" cellSpacing=\"1\" cellPadding=\"0\" name =\"A\" id=\"A\" border=\"1\" width=\"550\" bordercolor=\"#FFFFFF\" style=\"border-collapse: collapse\">\n";
	echo $outputTable;
	// End adding to the team info

	mysql_free_result($queryresultMatch);
}

elseif (isset($_GET["Comp"]) && isset($_GET["Season"])) {
	$LeagueName = $_GET["Comp"];
	$Season = $_GET["Season"];
	// check if the competition league or Groups
	$sqlComp = "SELECT * FROM competition WHERE compID='$LeagueName'";
	$queryresultComp = mysql_query($sqlComp)
		or die(mysql_error());
	$rowComp = mysql_fetch_assoc($queryresultComp);
	$compSys = $rowComp['compSys'];
	// END check if the competition league or Groups
	if (isset($_GET['Stage'])) {
		$Stages = $_GET['Stage'];
	} else {
		$Stages = "";
	}

	if ($compSys == 0 OR ($compSys == 2 AND $Stages != "KO")) {
		if ($compSys == 0) {
			$whereClause = "matchSeason='$Season' AND matchComp='$LeagueName'";
		}
		elseif ($compSys == 2) {
			if (isset($_GET["Group"])) {
				$GroupId = $_GET["Group"];
				$whereClause = "matchSeason='$Season' AND matchComp='$LeagueName' AND matchRound='32' AND matchGroup='$GroupId'";
			} else {
				$whereClause = "matchSeason='$Season' AND matchComp='$LeagueName' AND matchRound='32'";
			}
		}
		$plays = 0;
		$win = 0;
		$draw = 0;
		$loose = 0;
		$goalsFor = 0;
		$goalsAgainst = 0;
		$points = 0;
		$Number = 0;

		$sqlCreatTempror = "CREATE TEMPORARY TABLE tableStanding (
		teamGroup int(1),
		teamID int(3),
		played int(3),
		won int(2),
		draw int(2),
		lost int(2),
		goalsFor int(3),
		goalsAgainst int(3),
		goalsDif int(3),
		points int(3))";
		mysql_query($sqlCreatTempror) or die (mysql_error());

		$sqlCreatTemprorPrevious = "CREATE TEMPORARY TABLE tableStandingPrevious (
		teamGroup int(1),
		teamID int(3),
		played int(3),
		won int(2),
		draw int(2),
		lost int(2),
		goalsFor int(3),
		goalsAgainst int(3),
		goalsDif int(3),
		points int(3))";
		mysql_query($sqlCreatTemprorPrevious) or die (mysql_error());
		$lastMatch = "";

		$sqlMatch = "SELECT DISTINCT matchTeamHome, matchGroup FROM `matchcenter`.`match` WHERE $whereClause ORDER BY matchGroup";
		$queryresultMatch = mysql_query($sqlMatch)
			or die(mysql_error());
		while($rowMatch = mysql_fetch_assoc($queryresultMatch)){
			$teamID = $rowMatch['matchTeamHome'];
			$group = $rowMatch['matchGroup'];
			$sqlMatch2 = "SELECT matchID,matchGroup FROM `matchcenter`.`match` WHERE matchSeason='$Season' AND matchComp='$LeagueName'
			AND (matchTeamHome='$teamID' OR matchTeamAway='$teamID') ORDER BY matchDate ASC,matchGroup DESC";
			$queryresultMatch2 = mysql_query($sqlMatch2)
				or die(mysql_error());
			while($rowMatch2 = mysql_fetch_assoc($queryresultMatch2)){
				$matchIDFromTeam = $rowMatch2['matchID'];
				//check result
				$sqlMatchAnalysis = "SELECT * FROM matchanalysis WHERE analysisMatch='$matchIDFromTeam'";
				$queryresultMatchAnalysis = mysql_query($sqlMatchAnalysis)
					or die(mysql_error());
				$result1 = 0;
				$result2 = 0;
				$MatchAnalysisRowsNumber = mysql_num_rows($queryresultMatchAnalysis);
				if ($MatchAnalysisRowsNumber == 0) {
					$result1 = 0;
					$result2 = 0;
				}
				else {
					$lastMatch = $matchIDFromTeam;
					while($rowMatchAnalysis = mysql_fetch_assoc($queryresultMatchAnalysis)){
						$Mins = $rowMatchAnalysis['analysisMins'];
						$half = $rowMatchAnalysis['analysisHalf'];
						$team = $rowMatchAnalysis['analysisTeam'];
						$analysEvent = $rowMatchAnalysis['analysisEvent'];
						if ($half == 0 && $Mins == 90) {
							if ($result1 != 0 || $result2 != 0) {
								break;
							}
							else {
								$result1 = 0;
								$result2 = 0;
							}
						}
						elseif ($analysEvent == 2) {
							if ($team == $teamID) {
								$result1 ++;
							}
							else {
								$result2 ++;
							}
						}
					}
					if ($result1 > $result2) {
						$plays ++;
						$win ++ ;
						$goalsFor += $result1;
						$goalsAgainst += $result2;
						$points += 3;
					}
					elseif ($result1 < $result2) {
						$plays ++;
						$loose ++;
						$goalsFor += $result1;
						$goalsAgainst += $result2;
						$points += 0;
					}
					else {
						$plays++;
						$draw ++;
						$goalsFor += $result1;
						$goalsAgainst += $result2;
						$points += 1;
					}
				}
				//end of checking result
			}
			// start teams table
			$goalsDef = $goalsFor - $goalsAgainst;
			$sqlTableStanding = "INSERT INTO tableStanding (teamGroup, teamID, played, won, draw, lost, goalsFor,	goalsAgainst, goalsDif,	points)
				VALUES ('$group','$teamID','$plays','$win','$draw','$loose','$goalsFor','$goalsAgainst','$goalsDef','$points');";
			mysql_query($sqlTableStanding) or die (mysql_error());

			LastTblStanding($lastMatch,$group,$teamID,$plays,$win,$draw,$loose,$goalsFor,$goalsAgainst,$goalsDef,$points);

			$plays = 0;
			$win = 0;
			$draw = 0;
			$loose = 0;
			$goalsFor = 0;
			$goalsAgainst = 0;
			$points = 0;
			// End filling tables
		}
		// Start filling each teams Table
		$outputTableBegin = " <tr class=\"dates\"> ";
		$outputTableBegin .= " <td> </td>\n";
		$outputTableBegin .= " <td>«·›—Ìﬁ</td>\n";
		$outputTableBegin .= " <td>·⁄»</td>\n";
		$outputTableBegin .= " <td>›«“</td>\n";
		$outputTableBegin .= " <td> ⁄«œ·</td>\n";
		$outputTableBegin .= " <td>Œ”—</td>\n";
		$outputTableBegin .= " <td>·Â</td>\n";
		$outputTableBegin .= " <td>⁄·ÌÂ</td>\n";
		$outputTableBegin .= " <td>›«—ﬁ</td>\n";
		$outputTableBegin .= " <td>‰ﬁ«ÿ</td>\n";
		$outputTableBegin .= "</tr>\n";
		$outputTableBegin .= "";
		$outputTable = "";
		$outputTableClose = "";
		$previousTeamGroup = 0;

		$sqlTblStandingPrevious = "SELECT * FROM tableStandingPrevious ORDER BY teamGroup,points DESC,goalsDif DESC,goalsFor DESC";
		$queryresultTblStandingPrevious = mysql_query($sqlTblStandingPrevious)
			or die(mysql_error());
		$previousStanding = array();
		$previousGroupStanding = array();
		while($rowTblPre = mysql_fetch_assoc($queryresultTblStandingPrevious)){
			$teamTbl = $rowTblPre['teamID'];
			$teamGrpPrevious = $rowTblPre['teamGroup'];
			array_push($previousStanding, "$teamTbl");
		}


		$sqlTblStanding = "SELECT * FROM tableStanding ORDER BY teamGroup,points DESC,goalsDif DESC,goalsFor DESC";
		$queryresultTblStanding = mysql_query($sqlTblStanding)
			or die(mysql_error());
		$previousGroup = 0;
		$groupNum = 1;
		while($rowTbl = mysql_fetch_assoc($queryresultTblStanding)){
			$teamGroup = $rowTbl['teamGroup'];
			$teamTbl = $rowTbl['teamID'];
			$pld = $rowTbl['played'];
			$won = $rowTbl['won'];
			$drw = $rowTbl['draw'];
			$los = $rowTbl['lost'];
			$gf = $rowTbl['goalsFor'];
			$ga = $rowTbl['goalsAgainst'];
			$gd = $rowTbl['goalsDif'];
			$pts = $rowTbl['points'];

			if ($previousGroup != $teamGroup) {
				$outputTable .= $outputTableClose;
				$outputTable .= "  <tr class=\"dates\"> ";
				if (isset($_GET['Group'])) {
					$outputTable .= " <td colspan=\"10\"> «·„Ã„Ê⁄… ".$_GET['Group']."</td>\n";
				} else {
					$outputTable .= " <td colspan=\"10\"> «·„Ã„Ê⁄… $groupNum</td>\n";
				}
				$outputTable .= "</tr>\n";
				$outputTable .= $outputTableBegin;
				$i = 0;
				$Number = 0;
				$groupNum ++ ;
			}
			if ($teamTbl == 1) {
				$outputTable .=  "<tr class=\"hilalMatches\">";
			}
			else {
				$outputTable .=  "<tr class=\"Matches\">";
			}
			$key = array_search("$teamTbl", $previousStanding);
			$key ++;
			$Number += 1;
			if ($key > $Number) {
				$Standing = "<img src=\"images/up.gif\"> $Number";
			}
			elseif ($key < $Number) {
				$Standing = "<img src=\"images/down.gif\"> $Number";
			}
			elseif ($key == $Number) {
				$Standing = "<img src=\"images/even.gif\"> $Number";
			}
			$outputTable .= "<td class=\"whiteBorder\">". $Standing ."</td>";
			$outputTable .= "<td class=\"whiteBorder\"> ".TeamNameAr($teamTbl)."</td>";
			$outputTable .= "<td class=\"whiteBorder\">$pld</td>";
			$outputTable .= "<td class=\"whiteBorder\">$won</td>";
			$outputTable .= "<td class=\"whiteBorder\">$drw</td>";
			$outputTable .= "<td class=\"whiteBorder\"> $los</td>";
			$outputTable .= "<td class=\"whiteBorder\"> $gf</td>";
			$outputTable .= "<td class=\"whiteBorder\"> $ga</td>";
			if ($gd > 0) {
				$gd .= "+";
			}
			$outputTable .= "<td class=\"whiteBorder\"> $gd</td>";
			$outputTable .= "<td class=\"whiteBorder\"> $pts</td>";
			$outputTable .= "</tr>";
			$previousGroup = $teamGroup;
		}
		$outputTableClose .= "</table>";
		//do nothing
		// Start adding to the team info
		echo "<table dir=\"rtl\" cellSpacing=\"1\" cellPadding=\"0\" name =\"A\" id=\"A\" border=\"1\" width=\"550\" bordercolor=\"#FFFFFF\" style=\"border-collapse: collapse\">\n";

		if ($compSys == 0) {
			echo $outputTableBegin;
		}
		echo $outputTable;
		echo $outputTableClose;
		// End adding to the team info

		mysql_free_result($queryresultMatch);
	}
	// if the competition was a CUP ########################################################################
	else {
		if ($Stages == "KO") {
			$whereClause = "matchSeason='$Season' AND matchComp='$LeagueName' AND matchRound <> '32'";
		} else {
			$whereClause = "matchSeason='$Season' AND matchComp='$LeagueName'";
		}

		$sqlMatch = "SELECT * FROM `matchcenter`.`match` WHERE $whereClause ORDER BY matchRound, matchGroup,matchDate";
		$queryresultMatch = mysql_query($sqlMatch)
				or die(mysql_error());
		$team1Away = "";
		$team2Away = "";
		$previousMatchID = "";
		$matchArray = array();
		while($rowMatch = mysql_fetch_assoc($queryresultMatch)){
			$team1 = $rowMatch['matchTeamHome'];
			$team2 = $rowMatch['matchTeamAway'];
			$matchID = $rowMatch['matchID'];
			$round = $rowMatch['matchRound'];
			$Group = $rowMatch['matchGroup'];
			$comment = $rowMatch['matchComment'];
			$checkMatch = array_search("$matchID",$matchArray );

			//check result
			$sqlMatchAnalysis = "SELECT * FROM matchanalysis WHERE analysisMatch='$matchID' ORDER BY analysisID DESC";
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
					if (($half == 0 && $Mins == 90) OR ($half == 0 && $Mins == 120)) {
						if ($result1 != 0 || $result2 != 0) {

						}
						else {
							if ($matchID != $previousMatchID) {
								$resultAway1 = 0;
								$resultAway2 = 0;
							} else {
								$result1 = 0;
								$result2 = 0;
							}
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
				// check if there is a match away
				$sqlMatchAway = "SELECT * FROM `matchcenter`.`match` WHERE matchSeason='$Season' AND matchComp='$LeagueName'
				AND (matchTeamHome='$team2' AND matchTeamAway='$team1')";
				$queryresultMatchAway = mysql_query($sqlMatchAway)
					or die(mysql_error());
				array_push($matchArray, "$matchID" );
				$matchAwayRowNum = mysql_num_rows($queryresultMatchAway);
				if ($matchAwayRowNum != 0) {
					$rowMatchAway = mysql_fetch_assoc($queryresultMatchAway);
					$previousMatchID = $rowMatchAway['matchID'];
					$resultAway1 = 0;
					$resultAway2 = 0;
					// check Match Away results ............................................................
					$sqlMatchAnalysis2 = "SELECT * FROM matchanalysis WHERE analysisMatch='$previousMatchID' ORDER BY analysisID DESC";
					$queryresultMatchAnalysis2 = mysql_query($sqlMatchAnalysis2)
						or die(mysql_error());
					$MatchAnalysisRowsNumber2 = mysql_num_rows($queryresultMatchAnalysis2);
					if ($MatchAnalysisRowsNumber2 == 0) {
						$resultAway1 = "";
						$resultAway2 = "";
						$penaltiesTeam1 = "";
						$penaltiesTeam2 = "";
					}
					else {
						while($rowMatchAnalysis2 = mysql_fetch_assoc($queryresultMatchAnalysis2)){
							$Mins = $rowMatchAnalysis2['analysisMins'];
							$half = $rowMatchAnalysis2['analysisHalf'];
							$Player = $rowMatchAnalysis2['analysisPlayer'];
							$team = $rowMatchAnalysis2['analysisTeam'];
							$analysEvent = $rowMatchAnalysis2['analysisEvent'];
							if (($half == 0 && $Mins == 90) OR ($half == 0 && $Mins == 120)) {
								if ($resultAway1 != 0 || $resultAway2 != 0) {
								}
								else {
									$resultAway1 = 0;
									$resultAway2 = 0;
								}
							}
							elseif ($analysEvent == 2 && ($half == 1 OR $half == 2 OR $half == 3 OR $half == 4)) {
								if ($team == $team1) {
									$resultAway1 ++;
								}
								elseif ($team == $team2) {
									$resultAway2 ++;
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
					//end of Match Away  checking result ##########################################################
				}
				// end checking
				else {
					unset($resultAway1);
					unset($resultAway2);
				}
			}
			//end of checking result
			if ($team1 == 1 OR $team2 == 1) {
				$teamsInCup["TeamHome$round$Group"] = " class=\"cupTblTDHilal\">";
				if ($round == 2) {
					$teamsInCup["Result$round$Group"] = "";
					$teamsInCup["TeamAway$round$Group"] = "";
				} else {
					$teamsInCup["Result$round$Group"] = " class=\"cupTblTDHilal\">";
					$teamsInCup["TeamAway$round$Group"] = " class=\"cupTblTDHilal\">";
				}
				$teamsInCup["TeamHome$round$Group"] .= teamNameAr($team1);
				if ((trim($penaltiesTeam1) == "" || trim($penaltiesTeam2) == "") || ($penaltiesTeam1 == 0 && $penaltiesTeam2 == 0)) {
					if (isset($resultAway1) OR isset($resultAway2)) {
						$teamsInCup["Result$round$Group"] .= "<a href=\"liveMatch.php?match=$previousMatchID\">$resultAway1 - $resultAway2</a>";
						$teamsInCup["Result$round$Group"] .= "<br><a href=\"liveMatch.php?match=$matchID\">$result1 - $result2</a>";
					} else {
						$teamsInCup["Result$round$Group"] .= "<a href=\"liveMatch.php?match=$matchID\">$result1 - $result2</a>";
					}
				} else {
					$teamsInCup["Result$round$Group"] .= "<a href=\"liveMatch.php?match=$matchID\">$result1 ($penaltiesTeam1 - $penaltiesTeam2) $result2</a>";
				}
				$teamsInCup["TeamAway$round$Group"] .= teamNameAr($team2);
			} else {
				$teamsInCup["TeamHome$round$Group"] = " class=\"cupTblTD\">";
				if ($round == 2) {
					$teamsInCup["Result$round$Group"] = "";
					$teamsInCup["TeamAway$round$Group"] = "";
				} else {
					$teamsInCup["Result$round$Group"] = " class=\"cupTblTD\">";
					$teamsInCup["TeamAway$round$Group"] = " class=\"cupTblTD\">";
				}
				$teamsInCup["TeamHome$round$Group"] .= teamNameAr($team1);
				if ((trim($penaltiesTeam1) == "" || trim($penaltiesTeam2) == "") || ($penaltiesTeam1 == 0 && $penaltiesTeam2 == 0)) {
					if (isset($resultAway1) OR isset($resultAway2)) {
						$teamsInCup["Result$round$Group"] .= "<a href=\"liveMatch.php?match=$previousMatchID\">$resultAway1 - $resultAway2</a>";
						$teamsInCup["Result$round$Group"] .= "<br><a href=\"liveMatch.php?match=$matchID\">$result1 - $result2</a>";
					} else {
						$teamsInCup["Result$round$Group"] .= "<a href=\"liveMatch.php?match=$matchID\">$result1 - $result2</a>";
					}
				} else {
					$teamsInCup["Result$round$Group"] .= "$result1 ($penaltiesTeam1 - $penaltiesTeam2) $result2";
				}
				$teamsInCup["TeamAway$round$Group"] .= teamNameAr($team2);
			}
			$resultAway1 = "";
			$resultAway2 = "";
		}
		//do nothing
		// Start adding to the team info
		mysql_free_result($queryresultMatch);

		if (isset($teamsInCup["TeamHome161"])) {
			echo "<table border=\"0\" width=\"100%\">";
			echo "<tr class=\"dates\">";
			echo "<td>œÊ— «·‹16</td>";
			echo "<td>œÊ— «·‹8</td>";
			echo "<td>œÊ— «·‹4</td>";
			echo "<td>«·‰Â«∆Ì</td>";
			echo "<td>œÊ— «·‹4</td>";
			echo "<td>œÊ— «·‹8</td>";
			echo "<td>œÊ— «·‹16</td>";
			echo "</tr><tr>";

			echo "<td ";
			echo $teamsInCup["TeamHome161"];
			echo "</td>";
			echo "<td rowspan=\"3\" ";
			echo $teamsInCup["TeamHome81"];
			echo "</td>";
			echo "<td class=\"whiteBorder\">&nbsp;</td>";
			echo "<td class=\"whiteBorder\">&nbsp;</td>";
			echo "<td class=\"whiteBorder\">&nbsp;</td>";
			echo "<td rowspan=\"3\" ";
			echo $teamsInCup["TeamHome83"];
			echo "</td>";
			echo "<td ";
			echo $teamsInCup["TeamHome165"];
			echo "</td>";

			echo "</tr><tr>";
			echo "<td ";
			echo $teamsInCup["Result161"];
			echo "</td>";
			echo "<td rowspan=\"5\" ";
			echo $teamsInCup["TeamHome41"];
			echo "</td>";
			echo "<td  class=\"whiteBorder\" rowspan=\"4\">&nbsp;</td>";
			echo "<td rowspan=\"5\" ";
			echo $teamsInCup["TeamHome42"];
			echo "</td>";
			echo "<td ";
			echo $teamsInCup["Result165"];
			echo "</td>";

			echo "</tr><tr>";
			echo "<td ";
			echo $teamsInCup["TeamAway161"];
			echo "</td>";
			echo "<td ";
			echo $teamsInCup["TeamAway165"];
			echo "</td>";

			echo "</tr><tr>";
			echo "<td class=\"whiteBorder\">&nbsp;</td>";
			echo "<td ";
			echo $teamsInCup["Result81"];
			echo "</td>";
			echo "<td ";
			echo $teamsInCup["Result83"];
			echo "</td>";
			echo "<td class=\"whiteBorder\">&nbsp;</td>";

			echo "</tr><tr>";
			echo "<td ";
			echo $teamsInCup["TeamHome162"];
			echo "</td>";
			echo "<td rowspan=\"3\" ";
			echo $teamsInCup["TeamAway81"];
			echo "</td>";
			echo "<td rowspan=\"3\" ";
			echo $teamsInCup["TeamAway83"];
			echo "</td>";
			echo "<td ";
			echo $teamsInCup["TeamHome166"];
			echo "</td>";

			echo "</tr><tr>";
			echo "<td ";
			echo $teamsInCup["Result162"];
			echo "</td>";
			echo "<td rowspan=\"5\" ";
			echo $teamsInCup["TeamHome21"];
			echo "<br>";
			echo $teamsInCup["Result21"];
			echo "<br>";
			echo $teamsInCup["TeamAway21"];
			echo "</td>";
			echo "<td ";
			echo $teamsInCup["Result166"];
			echo "</td>";

			echo "</tr><tr>";
			echo "<td ";
			echo $teamsInCup["TeamAway162"];
			echo "</td>";
			echo "<td rowspan=\"3\" ";
			echo $teamsInCup["Result41"];
			echo "</td>";
			echo "<td rowspan=\"3\" ";
			echo $teamsInCup["Result42"];
			echo "</td>";
			echo "<td ";
			echo $teamsInCup["TeamAway166"];
			echo "</td>";

			echo "</tr><tr>";
			echo "<td class=\"whiteBorder\">&nbsp;</td>";
			echo "<td class=\"whiteBorder\">&nbsp;</td>";
			echo "<td class=\"whiteBorder\">&nbsp;</td>";
			echo "<td class=\"whiteBorder\">&nbsp;</td>";

			echo "</tr><tr>";
			echo "<td ";
			echo $teamsInCup["TeamHome163"];
			echo "</td>";
			echo "<td rowspan=\"3\" ";
			echo $teamsInCup["TeamHome82"];
			echo "</td>";
			echo "<td rowspan=\"3\" ";
			echo $teamsInCup["TeamHome84"];
			echo "</td>";
			echo "<td ";
			echo $teamsInCup["TeamHome167"];
			echo "</td>";

			echo "</tr><tr>";
			echo "<td ";
			echo $teamsInCup["Result163"];
			echo "</td>";
			echo "<td rowspan=\"5\" ";
			echo $teamsInCup["TeamAway41"];
			echo "</td>";
			echo "<td rowspan=\"5\" ";
			echo $teamsInCup["TeamAway42"];
			echo "</td>";
			echo "<td ";
			echo $teamsInCup["Result167"];
			echo "</td>";

			echo "</tr><tr>";
			echo "<td ";
			echo $teamsInCup["TeamAway163"];
			echo "</td>";
			echo "<td class=\"whiteBorder\" rowspan=\"4\">&nbsp;</td>";
			echo "<td ";
			echo $teamsInCup["TeamAway167"];
			echo "</td>";

			echo "</tr><tr>";
			echo "<td class=\"whiteBorder\">&nbsp;</td>";
			echo "<td ";
			echo $teamsInCup["Result82"];
			echo "</td>";
			echo "<td ";
			echo $teamsInCup["Result84"];
			echo "</td>";
			echo "<td class=\"whiteBorder\">&nbsp;</td>";

			echo "</tr><tr>";
			echo "<td ";
			echo $teamsInCup["TeamHome164"];
			echo "</td>";
			echo "<td rowspan=\"3\" ";
			echo $teamsInCup["TeamAway82"];
			echo "</td>";
			echo "<td rowspan=\"3\" ";
			echo $teamsInCup["TeamAway84"];
			echo "</td>";
			echo "<td ";
			echo $teamsInCup["TeamHome168"];
			echo "</td>";

			echo "</tr><tr>";
			echo "<td ";
			echo $teamsInCup["Result164"];
			echo "</td>";
			echo "<td ";
			echo $teamsInCup["Result168"];
			echo "</td>";

			echo "</tr><tr>";
			echo "<td ";
			echo $teamsInCup["TeamAway164"];
			echo "</td>";
			echo "<td class=\"whiteBorder\">&nbsp;</td>";
			echo "<td class=\"whiteBorder\">&nbsp;</td>";
			echo "<td class=\"whiteBorder\">&nbsp;</td>";
			echo "<td ";
			echo $teamsInCup["TeamAway168"];
			echo "</td>";
			echo "</tr></table>";
		}
		else {
			echo "<table border=\"0\" width=\"100%\">";
			echo "<tr class=\"dates\">";
			echo "<td>œÊ— «·‹8</td>";
			echo "<td>œÊ— «·‹4</td>";
			echo "<td>«·‰Â«∆Ì</td>";
			echo "<td>œÊ— «·‹4</td>";
			echo "<td>œÊ— «·‹8</td>";
			echo "</tr><tr>";

			echo "<td rowspan=\"2\" ";
			echo $teamsInCup["TeamHome81"];
			echo "</td>";
			echo "<td class=\"whiteBorder\">&nbsp;</td>";
			echo "<td class=\"whiteBorder\">&nbsp;</td>";
			echo "<td class=\"whiteBorder\">&nbsp;</td>";
			echo "<td rowspan=\"2\" ";
			echo $teamsInCup["TeamHome83"];
			echo "</td>";

			echo "</tr><tr>";
			echo "<td rowspan=\"4\" ";
			echo $teamsInCup["TeamHome41"];
			echo "</td>";
			echo "<td  class=\"whiteBorder\" rowspan=\"3\">&nbsp;</td>";
			echo "<td rowspan=\"4\" ";
			echo $teamsInCup["TeamHome42"];
			echo "</td>";

			echo "</tr><tr>";
			echo "<td ";
			echo $teamsInCup["Result81"];
			echo "</td>";
			echo "<td ";
			echo $teamsInCup["Result83"];
			echo "</td>";

			echo "</tr><tr>";
			echo "<td rowspan=\"3\" ";
			echo $teamsInCup["TeamAway81"];
			echo "</td>";
			echo "<td rowspan=\"3\" ";
			echo $teamsInCup["TeamAway83"];
			echo "</td>";

			echo "</tr><tr>";
			echo "<td rowspan=\"5\" ";
			echo $teamsInCup["TeamHome21"];
			echo "<br>";
			echo $teamsInCup["Result21"];
			echo "<br>";
			echo $teamsInCup["TeamAway21"];
			echo "</td>";

			echo "</tr><tr>";
			echo "<td rowspan=\"3\" ";
			echo $teamsInCup["Result41"];
			echo "</td>";
			echo "<td rowspan=\"3\" ";
			echo $teamsInCup["Result42"];
			echo "</td>";

			echo "</tr><tr>";
			echo "<td class=\"whiteBorder\">&nbsp;</td>";
			echo "<td class=\"whiteBorder\">&nbsp;</td>";

			echo "</tr><tr>";
			echo "<td rowspan=\"3\" ";
			echo $teamsInCup["TeamHome82"];
			echo "</td>";
			echo "<td rowspan=\"3\" ";
			echo $teamsInCup["TeamHome84"];
			echo "</td>";

			echo "</tr><tr>";
			echo "<td rowspan=\"4\" ";
			echo $teamsInCup["TeamAway41"];
			echo "</td>";
			echo "<td rowspan=\"4\" ";
			echo $teamsInCup["TeamAway42"];
			echo "</td>";

			echo "</tr><tr>";
			echo "<td class=\"whiteBorder\" rowspan=\"3\">&nbsp;</td>";

			echo "</tr><tr>";
			echo "<td ";
			echo $teamsInCup["Result82"];
			echo "</td>";
			echo "<td ";
			echo $teamsInCup["Result84"];
			echo "</td>";

			echo "</tr><tr>";
			echo "<td rowspan=\"2\" ";
			echo $teamsInCup["TeamAway82"];
			echo "</td>";
			echo "<td rowspan=\"2\" ";
			echo $teamsInCup["TeamAway84"];
			echo "</td>";

			echo "</tr><tr>";
			echo "<td class=\"whiteBorder\">&nbsp;</td>";
			echo "<td class=\"whiteBorder\">&nbsp;</td>";
			echo "<td class=\"whiteBorder\">&nbsp;</td>";

			echo "</tr></table>";
		}
	}
}
//echo "</div>";
// making footer
echo makeFooterSimple();

?>