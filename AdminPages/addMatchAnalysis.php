<?php
require_once('AFunctions.php');
include 'db_conn.php';
// insert the header
echo makeHeader("");
//echo loginSys();

echo makeMenu();

echo "<div id = \"maincontent\">\n";
$beginTable = "<table  class=\"mcenter\">\n";
$beginTable .= "	<tr class=\"mcenter\">\n";
$beginTable .= "	<td colspan=\"2\"> ≈÷«›… √Õœ«À «·„»«—«…</td>\n";
$beginTable .= "	</tr>\n";
// insert the navigation
if (isset($_GET["match"]) && isset($_GET["team"])) {
	$matchIDGet = $_GET["match"];
	$teamID = $_GET["team"];

	// add the result and match summery .........................................................
	$sqlMatch = "SELECT * FROM `matchcenter`.`match` WHERE matchID='$matchIDGet'";
	$queryresultMatch = mysql_query($sqlMatch)
	or die(mysql_error());
	$previousMatchDate = "";
	$TrClass = "";
	$rowMatch = mysql_fetch_assoc($queryresultMatch);
	$season = $rowMatch['matchSeason'];
	$Comp = $rowMatch['matchComp'];
	$team1 = $rowMatch['matchTeamHome'];
	$team2 = $rowMatch['matchTeamAway'];
	$sqlMatchAnalysis = "SELECT * FROM matchanalysis WHERE analysisMatch='$matchIDGet' AND analysisEvent=2 AND
	(analysisHalf=1 OR analysisHalf=2 OR analysisHalf=3 OR analysisHalf=4)";
	$queryresultMatchAnalysis = mysql_query($sqlMatchAnalysis)
	or die(mysql_error());
	$result1 = 0;
	$result2 = 0;
	while($rowMatchAnalysis = mysql_fetch_assoc($queryresultMatchAnalysis)){
		$team = $rowMatchAnalysis['analysisTeam'];
		if ($team == $team1) {
			$result1 ++;
		}
		elseif ($team == $team2) {
			$result2 ++;
		}
	}
	$sqlTeam1 = "SELECT * FROM `matchcenter`.`teams` WHERE teamID='$team1'";
	$sqlTeam2 = "SELECT * FROM `matchcenter`.`teams` WHERE teamID='$team2'";
	$queryresultTeam1 = mysql_query($sqlTeam1)
				or die(mysql_error());
	$queryresultTeam2 = mysql_query($sqlTeam2)
				or die(mysql_error());
	$rowTeam1 = mysql_fetch_assoc($queryresultTeam1);
	$rowTeam2 = mysql_fetch_assoc($queryresultTeam2);
	$bgColorT1 = "#";
	$fhColorT1 = "#";
	$bgColorT2 = "#";
	$fhColorT2 = "#";
	$bgColorT1 .= $rowTeam1['teamColor1'];
	$fhColorT1 .= $rowTeam1['teamColor2'];
	$bgColorT2 .= $rowTeam2['teamColor1'];
	$fhColorT2 .= $rowTeam2['teamColor2'];

	$outputTable = "<table width=\"100%\" class=\"result\"><tr class=\"teams\">";
	$outputTable .= "<td class=\"teams\" bgcolor=\"$bgColorT1\"><font color=\"$fhColorT1\">".$rowTeam1['teamNameAr']."</font></td>";
	$outputTable .= "<td class=\"result\">$result1 - $result2</td>";
	$outputTable .= "<td class=\"teams\" bgcolor=\"$bgColorT2\"><font color=\"$fhColorT2\">".$rowTeam2['teamNameAr']."</font></td>";
	$outputTable .= "</tr></table>";
	mysql_free_result($queryresultMatch);
	// add the texts last 3 ............................................................................................
	$textOutPut = "";
	$previousEvent = "";
	$previousHalf = "";
	$previousMins = "";
	$doublePreviousEvent = "";
	$commentText = "";
	function playerNameAr($PlayerInt){
		if ($PlayerInt == 0) {
			$outPutFun = "";
		}
		else {
			$outPutFun = "<strong><a href=\"../player.php?ID=$PlayerInt\">";
			$outPutFun .= playerShortNameAr($PlayerInt);
			$outPutFun .= "</a></strong>";
		}
	return $outPutFun;
	}
	$sqlMatchAna = "SELECT * FROM matchanalysis WHERE analysisMatch='$matchIDGet' ORDER BY analysisMins DESC, analysisID DESC LIMIT 6";
	$queryresultMatchAna = mysql_query($sqlMatchAna)
	or die(mysql_error());
	while ($rowMatchAna = mysql_fetch_assoc($queryresultMatchAna)) {
		$MatchMin = $rowMatchAna['analysisMins'];
		$MatchPlayer = $rowMatchAna['analysisPlayer'];
		$MatchEvent = $rowMatchAna['analysisEvent'];
		$MatchPen = $rowMatchAna['analysisPenalty'];
		$MatchComment = $rowMatchAna['analysisComment'];
		$MatchHalf = $rowMatchAna['analysisHalf'];
		$MatchTeam = $rowMatchAna['analysisTeam'];
		if ($MatchComment == 0) {
			$commentText .= "";
		}
		else {
			$sqlcity = "SELECT * FROM comment WHERE commentID='$MatchComment'";
			$queryresultcity = mysql_query($sqlcity)
			or die(mysql_error());
			$rowCity = mysql_fetch_assoc($queryresultcity);
			$Comment = $rowCity['commentText'];
			$commentText .= "	<td>\n $Comment</td></tr>\n";
		}
		global $EventSimpleAr;
		if ($MatchEvent == 0) {
			if ($MatchHalf == 0 && $MatchMin == 0 && $MatchTeam == 0 && $MatchEvent == 0) {
				$textOutPut .= "	<tr class=\"startEnd\">\n";
				$textOutPut .= "	<td><img src=\"../images/1start.gif\"> </td>\n";
				$textOutPut .= "<td>\n<strong>$Comment</strong>";
				$textOutPut .= "</td></tr>\n";
				$textOutPut .= "<tr><td colspan=\"2\">\n <hr></td></tr>\n";
				$commentText = "";
			}
			elseif ($MatchHalf == 0 && $MatchMin == 45 && $MatchTeam == 0  && $MatchEvent == 0) {
				$textOutPut .= "	<tr class=\"startEnd\">\n";
				$textOutPut .= "	<td><img src=\"../images/1end.gif\"> </td>\n";
				$textOutPut .= "<td>\n<strong>$Comment</strong>";
				$textOutPut .= "</td></tr>\n";
				$textOutPut .= "<tr><td colspan=\"2\">\n <hr></td></tr>\n";
				$commentText = "";
			}
			elseif ($MatchHalf == 0 && $MatchMin == 46 && $MatchTeam == 0  && $MatchEvent == 0) {
				$textOutPut .= "	<tr class=\"startEnd\">\n";
				$textOutPut .= "	<td><img src=\"../images/2start.gif\"> </td>\n";
				$textOutPut .= "<td>\n<strong>$Comment</strong>";
				$textOutPut .= "</td></tr>\n";
				$textOutPut .= "<tr><td colspan=\"2\">\n <hr></td></tr>\n";
				$commentText = "";
			}
			elseif ($MatchHalf == 0 && $MatchMin == 90 && $MatchTeam == 0  && $MatchEvent == 0) {
				$textOutPut .= "	<tr class=\"startEnd\">\n";
				$textOutPut .= "	<td><img src=\"../images/2end.gif\"> </td>\n";
				$textOutPut .= "<td>\n<strong>$Comment</strong>";
				$textOutPut .= "</td></tr>\n";
				$textOutPut .= "<tr><td colspan=\"2\">\n <hr></td></tr>\n";
				$commentText = "";
			}
			elseif ($MatchHalf == 0 && $MatchMin == 91 && $MatchTeam == 0  && $MatchEvent == 0) {
				$textOutPut .= "	<tr class=\"startEnd\">\n";
				$textOutPut .= "	<td><img src=\"../images/1start.gif\"> </td>\n";
				$textOutPut .= "<td>\n<strong>$Comment</strong>";
				$textOutPut .= "</td></tr>\n";
				$textOutPut .= "<tr><td colspan=\"2\">\n <hr></td></tr>\n";
				$commentText = "";
			}
			elseif ($MatchHalf == 0 && $MatchMin == 105 && $MatchTeam == 0  && $MatchEvent == 0) {
				$textOutPut .= "	<tr class=\"startEnd\">\n";
				$textOutPut .= "	<td><img src=\"../images/1end.gif\"> </td>\n";
				$textOutPut .= "<td>\n<strong>$Comment</strong>";
				$textOutPut .= "</td></tr>\n";
				$textOutPut .= "<tr><td colspan=\"2\">\n <hr></td></tr>\n";
				$commentText = "";
			}
			elseif ($MatchHalf == 0 && $MatchMin == 106 && $MatchTeam == 0  && $MatchEvent == 0) {
				$textOutPut .= "	<tr class=\"startEnd\">\n";
				$textOutPut .= "	<td><img src=\"../images/2start.gif\"> </td>\n";
				$textOutPut .= "<td>\n<strong>$Comment</strong>";
				$textOutPut .= "</td></tr>\n";
				$textOutPut .= "<tr><td colspan=\"2\">\n <hr></td></tr>\n";
				$commentText = "";
			}
			elseif ($MatchHalf == 0 && $MatchMin == 120 && $MatchTeam == 0  && $MatchEvent == 0) {
				$textOutPut .= "	<tr class=\"startEnd\">\n";
				$textOutPut .= "	<td><img src=\"../images/2end.gif\"> </td>\n";
				$textOutPut .= "<td>\n<strong>$Comment</strong>";
				$textOutPut .= "</td></tr>\n";
				$textOutPut .= "<tr><td colspan=\"2\">\n <hr></td></tr>\n";
				$commentText = "";
			}
			elseif ($MatchPen == 1) {
				$textOutPut .= "	<tr>\n";
				$textOutPut .= "	<td rowspan=\"2\">$MatchMin </td>\n";
				$textOutPut .= "	<td>\n <img src=\"../images/whistle.gif\"> ÷—»… Ã“«¡ ·‹ ";
				$textOutPut .= teamNameAr($MatchTeam);
				$textOutPut .= "  ”»» ›ÌÂ« ";
				$textOutPut .= playerNameAr($MatchPlayer,$MatchTeam);
				$textOutPut .= "</td></tr>\n";
				$textOutPut .= "	<tr>\n";
				$textOutPut .= $commentText;
				$commentText = "";
				$textOutPut .= "<tr><td colspan=\"2\">\n <hr></td></tr>\n";
			}
			elseif ($MatchPen == 3) {
				$textOutPut .= "	<tr>\n";
				$textOutPut .= "	<td rowspan=\"2\">$MatchMin </td>\n";
				$textOutPut .= "	<td>\n <img src=\"../images/penaltyMissed.gif\"> √÷«⁄ ÷—»… «·Ã“«¡ ";
				$textOutPut .= playerNameAr($MatchPlayer,$MatchTeam);
				$textOutPut .= "</td></tr>\n";
				$textOutPut .= "	<tr>\n";
				$textOutPut .= $commentText;
				$commentText = "";
				$textOutPut .= "<tr><td colspan=\"2\">\n <hr></td></tr>\n";
			}
			else {
				$textOutPut .= "	<tr>\n";
				$textOutPut .= "	<td rowspan=\"2\">$MatchMin </td>\n";
				$textOutPut .= "	<td>\n ";
				$textOutPut .= playerNameAr($MatchPlayer);
				$textOutPut .= "</td></tr>\n";
				$textOutPut .= "	<tr>\n";
				$textOutPut .= $commentText;
				$commentText = "";
				$textOutPut .= "<tr><td colspan=\"2\">\n <hr></td></tr>\n";
			}
		}
		elseif ($MatchEvent == 1) {
			if ($MatchEvent == $doublePreviousEvent) {
				$previousEvent = 0;
			}
			if ($previousHalf == 0 && $previousEvent == 0 && $previousMins == 46) {
				if ($previousEvent != $MatchEvent) {
					$textOutPut .= "	<tr>\n";
					$textOutPut .= "	<td rowspan=\"2\"> </td>\n";
					$textOutPut .= "	<td>\n ";
					$textOutPut .= "<strong> »œÌ·</strong>";
					$textOutPut .= " œŒÊ· <img src=\"../images/in.gif\">";
					$textOutPut .= playerNameAr($MatchPlayer);
				}
				else {
					$textOutPut .= " Œ—ÊÃ <img src=\"../images/out.gif\">";
					$textOutPut .= playerNameAr($MatchPlayer);
					$textOutPut .= "</td></tr>\n";
					$textOutPut .= "	<tr>\n";
					$textOutPut .= $commentText;
					$commentText = "";
					$textOutPut .= "<tr><td colspan=\"2\">\n <hr></td></tr>\n";
				}
			}
			else {
				if ($previousEvent != $MatchEvent) {
					$textOutPut .= "	<tr>\n";
					$textOutPut .= "	<td rowspan=\"2\">$MatchMin </td>\n";
					$textOutPut .= "	<td>\n ";
					$textOutPut .= "<strong> »œÌ·</strong>";
					$textOutPut .= " œŒÊ· <img src=\"../images/in.gif\">";
					$textOutPut .= playerNameAr($MatchPlayer);
				}
				else {
					$textOutPut .= " Œ—ÊÃ <img src=\"../images/out.gif\">";
					$textOutPut .= playerNameAr($MatchPlayer);
					$textOutPut .= "</td></tr>\n";
					$textOutPut .= "	<tr>\n";
					$textOutPut .= $commentText;
					$commentText = "";
					$textOutPut .= "<tr><td colspan=\"2\">\n <hr></td></tr>\n";
				}
			}
		}
		elseif ($MatchEvent == 2 || $MatchEvent == 5) {
			if ($MatchEvent == 5) {
				$GoalAssist = $MatchPlayer;
			}
			elseif ($MatchEvent == 2 && $previousEvent!= 5) {
				$textOutPut .=  "	<tr>\n";
				$textOutPut .= "	<td rowspan=\"2\">$MatchMin </td>\n";
				$textOutPut .= "	<td>\n ";
				if ($MatchPen == 2) {
					$textOutPut .= "<img src=\"../images/penaltyScored.gif\"> ”Ã· ÷—»… «·Ã“«¡ ";
				}
				elseif ($MatchPen == 0) {
					$textOutPut .= "<img src=\"../images/goal.gif\">Âœ›\n";
				}
				//$textOutPut .= "<img src=\"images/goal.gif\"> Âœ› ";
				$textOutPut .= playerNameAr($MatchPlayer,$MatchTeam);
				$textOutPut .= "</td></tr>\n";
				$textOutPut .= "	<tr>\n";
				$textOutPut .= $commentText;
				$textOutPut .= "<tr><td colspan=\"2\">\n <hr></td></tr>\n";
				$commentText = "";
			}
			else {
				$textOutPut .=  "	<tr>\n";
				$textOutPut .= "	<td rowspan=\"2\">$MatchMin </td>\n";
				$textOutPut .= "	<td>\n ";
				$textOutPut .= "<img src=\"../images/goal.gif\"> Âœ› ";
				$textOutPut .= playerNameAr($MatchPlayer,$MatchTeam);
				$textOutPut .= " » „—Ì—… „‰ ";
				$textOutPut .= playerNameAr($GoalAssist,$MatchTeam);
				$textOutPut .= "</td></tr>\n";
				$textOutPut .= "	<tr>\n";
				$textOutPut .= $commentText;
				$textOutPut .= "<tr><td colspan=\"2\">\n <hr></td></tr>\n";
				$commentText = "";
			}
		}
		elseif ($MatchEvent == 3) {
			$textOutPut .= "	<tr>\n";
			$textOutPut .= "	<td rowspan=\"2\">$MatchMin </td>\n";
			$textOutPut .= "	<td>\n ";
			$textOutPut .= "<img class=\"card\" src=\"../images/yellow.gif\"> ". $EventSimpleAr[$MatchEvent] ."";
			$textOutPut .= playerNameAr($MatchPlayer);
			$textOutPut .= "</td></tr>\n";
			$textOutPut .= "	<tr>\n";
			$textOutPut .= $commentText;
			$commentText = "";
			$textOutPut .= "<tr><td colspan=\"2\">\n <hr></td></tr>\n";
		}
		elseif ($MatchEvent == 4) {
			$textOutPut .= "	<tr>\n";
			$textOutPut .= "	<td rowspan=\"2\">$MatchMin </td>\n";
			$textOutPut .= "	<td>\n ";
			$textOutPut .= "<img class=\"card\" src=\"../images/red.gif\"> ". $EventSimpleAr[$MatchEvent] ."";
			$textOutPut .= playerNameAr($MatchPlayer);
			$textOutPut .= "</td></tr>\n";
			$textOutPut .= "	<tr>\n";
			$textOutPut .= $commentText;
			$commentText = "";
			$textOutPut .= "<tr><td colspan=\"2\">\n <hr></td></tr>\n";
		}
		$doublePreviousEvent = $previousEvent;
		$previousEvent = $MatchEvent;
		$previousHalf = $MatchHalf;
		$previousMins = $MatchMin;
	}
	mysql_free_result($queryresultMatchAna);
	/// ####################################################################################################
	$matchSummery = "<div id=\"resultAdmin\">\n";
	$matchSummery .= $outputTable;
	$matchSummery .= "</div>\n";
	$matchSummery .= "<div id=\"CommentsAdmin\">\n";
	$matchSummery .= $textOutPut;
	$matchSummery .= "</div>\n";
	echo $matchSummery;

	$PostAction = "addMatchAnalysis.php?match=";
	$PostAction .= $matchIDGet;
	$PostAction .= "&team=";
	$PostAction .= $teamID;

	echo "<form id = \"addMatchAnlysis\" action = \"$PostAction\" method = \"post\">\n";
	echo $beginTable;

	$teamPlaying1 = teamNameAr($team1);
	$teamPlaying2 = teamNameAr($team2);

	echo "<tr><td colspan=\"2\">\n";
	/// check if the Comp is league or Cup
	$sqlComp = "SELECT * FROM competition WHERE compID='$Comp'";
	$queryresultComp = mysql_query($sqlComp)
		or die(mysql_error());
	$rowComp = mysql_fetch_assoc($queryresultComp);
	$CompSys = $rowComp['compSys'];
	// finish checking
	// check the result to give an extra time or no
	$sqlMatchAnalysis = "SELECT * FROM matchanalysis WHERE analysisMatch='$matchIDGet' AND analysisEvent=2";
	$queryresultMatchAnalysis = mysql_query($sqlMatchAnalysis)
		or die(mysql_error());
	$result1 = 0;
	$result2 = 0;
	$penaltiesTeam1 = 0;
	$penaltiesTeam2 = 0;
	if (mysql_num_rows($queryresultMatchAnalysis) == 0) {
		$result1 = 0;
		$result2 = 0;
	}
	else {
		while($rowMatchAnalysis = mysql_fetch_assoc($queryresultMatchAnalysis)){
			$Mins = $rowMatchAnalysis['analysisMins'];
			$half = $rowMatchAnalysis['analysisHalf'];
			$team = $rowMatchAnalysis['analysisTeam'];
			if ($half == 1 OR $half == 2 OR $half == 3 OR $half == 4) {
				if ($team == $team1) {
					$result1 ++;
				}
				elseif ($team == $team2) {
					$result2 ++;
				}
			}
			elseif ($half == 5) {
				if ($team == $team1) {
					$penaltiesTeam1 ++;
				}
				elseif ($team == $team2) {
					$penaltiesTeam2 ++;
				}
			}
		}
	}
	/// finish checkinh the result
	$showBotton = 0;
	$sqlMatchAnalysis = "SELECT * FROM matchanalysis WHERE analysisMatch='$matchIDGet' AND analysisHalf='0' ORDER BY analysisID DESC";
	$queryresultMatchAnalysis = mysql_query($sqlMatchAnalysis)
		or die(mysql_error());
	//$rowMatchAnalysis = mysql_fetch_assoc($queryresultMatchAnalysis);
	echo "<div id=\"matchBotton\">";
	if (mysql_num_rows($queryresultMatchAnalysis) == 0) {
		echo "<input type=\"button\" onclick=\"CityExFile('getPlayerCheck.php','match=$matchIDGet&botton','startmatch','matchBotton');window.location.reload()\" value=\"»œ√  «·„»«—«…\">";
	}
	while($rowMatchAnalysis = mysql_fetch_assoc($queryresultMatchAnalysis)){
		$Min = $rowMatchAnalysis['analysisMins'];
		$half = $rowMatchAnalysis['analysisHalf'];
		if ($Min == 0) {
			echo "<input type=\"button\" onclick=\"CityExFile('getPlayerCheck.php','match=$matchIDGet&botton','end1st','matchBotton');window.location.reload()\" value=\"«‰ ÂÏ «·‘Êÿ «·√Ê·\">";
			break;
		}
		elseif ($Min == 45) {
			echo "<input type=\"button\" onclick=\"CityExFile('getPlayerCheck.php','match=$matchIDGet&botton','start2nd','matchBotton');window.location.reload()\" value=\"»œ√ «·‘Êÿ «·À«‰Ì\">";
			break;
		}
		if ($CompSys == 0 OR $CompSys == 2) {
			if ($Min == 46) {
				echo "<input type=\"button\" onclick=\"CityExFile('getPlayerCheck.php','match=$matchIDGet&botton','endMatch','matchBotton');window.location.reload()\" value=\"«‰ Â  «·„»«—«…\">";
				break;
			}
			elseif ($Min == 90) {
				echo "«‰ Â  «·„»«—«…";
				break;
			}
			elseif ($Min != 0 && $Min != 45 && $Min != 46 && $Min != 90) {
				echo "<input type=\"button\" onclick=\"CityExFile('getPlayerCheck.php','match=$matchIDGet&botton','startmatch','matchBotton');window.location.reload()\" value=\"»œ√  «·„»«—«…\">";
			}
		}
		else {
			if ($result1 == $result2 && $Min == 46) {
				echo "<input type=\"button\" onclick=\"CityExFile('getPlayerCheck.php','match=$matchIDGet&botton','end2nd','matchBotton');window.location.reload()\" value=\"«‰ ÂÏ «·‘Êÿ «·À«‰Ì\">";
				break;
			}
			elseif ($result1 != $result2 && $Min == 46) {
				echo "<input type=\"button\" onclick=\"CityExFile('getPlayerCheck.php','match=$matchIDGet&botton','endMatch','matchBotton');window.location.reload()\" value=\"«‰ Â  «·„»«—«…\">";
				break;
			}
			elseif ($result1 == $result2 && $Min == 90) {
				echo "<input type=\"button\" onclick=\"CityExFile('getPlayerCheck.php','match=$matchIDGet&botton','StartEx1st','matchBotton');window.location.reload()\" value=\"»œ√ «·‘Êÿ «·≈÷«›Ì «·√Ê·\">";
				break;
			}
			elseif ($result1 != $result2 && $Min == 90) {
				echo "«‰ Â  «·„»«—«…";
				echo "<input type=\"button\" onclick=\"CityExFile('getPlayerCheck.php','match=$matchIDGet&Submission','1','matchBotton');window.location.reload()\" value=\"«⁄ „œ «·‰ ÌÃ… Ê√Â· «·›—Ìﬁ «·›«∆“\">";
				break;
			}
			elseif ($Min == 91) {
				echo "<input type=\"button\" onclick=\"CityExFile('getPlayerCheck.php','match=$matchIDGet&botton','endEx1st','matchBotton');window.location.reload()\" value=\"«‰ ÂÏ «·‘Êÿ «·≈÷«›Ì «·√Ê·\">";
				break;
			}
			elseif ($Min == 105) {
				echo "<input type=\"button\" onclick=\"CityExFile('getPlayerCheck.php','match=$matchIDGet&botton','StartEx2nd','matchBotton');window.location.reload()\" value=\"»œ√ «·‘Êÿ «·≈÷«›Ì «·À«‰Ì\">";
				break;
			}
			elseif ($result1 == $result2 && $Min == 106) {
				echo "<input type=\"button\" onclick=\"CityExFile('getPlayerCheck.php','match=$matchIDGet&botton','EndEx2nd','matchBotton');window.location.reload()\" value=\"«‰ ÂÏ «·‘Êÿ «·≈÷«›Ì «·À«‰Ì\">";
				break;
			}
			elseif ($result1 != $result2 && $Min == 106) {
				echo "<input type=\"button\" onclick=\"CityExFile('getPlayerCheck.php','match=$matchIDGet&botton','endMatchEx','matchBotton');window.location.reload()\" value=\"«‰ Â  «·„»«—«…\">";
				break;
			}
			elseif ($result1 != $result2 && $Min == 120) {
				echo "«‰ Â  «·„»«—«…";
				echo "<input type=\"button\" onclick=\"CityExFile('getPlayerCheck.php','match=$matchIDGet&Submission','1','matchBotton');window.location.reload()\" value=\"«⁄ „œ «·‰ ÌÃ… Ê√Â· «·›—Ìﬁ «·›«∆“\">";
				break;
			}
			elseif ($result1 == $result2 && $Min == 120) {
				echo "<input type=\"button\" onclick=\"CityExFile('getPlayerCheck.php','match=$matchIDGet&botton','StartPenalty','matchBotton');window.location.reload()\" value=\"»œ√  ÷—»«  «· —ÃÌÕ\">";
				break;
			}
			elseif ($Min == 125) {
				echo "<input type=\"button\" onclick=\"CityExFile('getPlayerCheck.php','match=$matchIDGet&botton','EndPenalty','matchBotton');window.location.reload()\" value=\"«‰ Â  ÷—»«  «· —ÃÌÕ\">";
				break;
			}
			elseif ($Min == 130) {
				echo "<input type=\"button\" onclick=\"CityExFile('getPlayerCheck.php','match=$matchIDGet&Submission','1','matchBotton');window.location.reload()\" value=\"«⁄ „œ «·‰ ÌÃ… Ê√Â· «·›—Ìﬁ «·›«∆“\">";
				break;
			}
			elseif ($Min != 0 && $Min != 45 && $Min != 46 && $Min != 90) {
				echo "<input type=\"button\" onclick=\"CityExFile('getPlayerCheck.php','match=$matchIDGet&botton','startmatch','matchBotton');window.location.reload()\" value=\"»œ√  «·„»«—«…\">";
			}
		}
	}
	echo "</div>";
	mysql_free_result($queryresultMatchAnalysis);


	echo "</td></tr>\n";
	echo "<tr><td>\n";
	echo "«·›—Ìﬁ";
	echo "</td>\n";
	echo "<td>\n";
		if ($teamID == $team1) {
			echo "<input type=\"radio\" checked=\"checked\" name=\"teamsPlaying\" onclick=\"window.location='addMatchAnalysis.php?match=$matchIDGet&team=$team1';\" value=\"$team1\"><font color=\"red\">$teamPlaying1</font>";
			echo "<input type=\"radio\" name=\"teamsPlaying\" onclick=\"window.location='addMatchAnalysis.php?match=$matchIDGet&team=$team2';\" value=\"$team2\">$teamPlaying2";
		}
		elseif ($teamID == $team2) {
			echo "<input type=\"radio\" name=\"teamsPlaying\" onclick=\"window.location='addMatchAnalysis.php?match=$matchIDGet&team=$team1';\" value=\"$team1\">$teamPlaying1";
			echo "<input type=\"radio\" checked=\"checked\" name=\"teamsPlaying\" onclick=\"window.location='addMatchAnalysis.php?match=$matchIDGet&team=$team2';\" value=\"$team2\"><font color=\"red\">$teamPlaying2</font>";
		}
	echo "</td></tr>\n";
	echo "<tr><td>\n";
	echo "</td>\n";
	echo "<td>\n";
	echo "<a href=\"addInMatch.php?match=$matchIDGet&team=$teamID&type=0\">≈÷«›… ﬁ«∆„… «·„»«—«…</a> - ";
	echo "<a href=\"editInMatch.php?match=$matchIDGet&team=$teamID\"> ⁄œÌ· ﬁ«∆„… «·„»«—«…</a>";
	echo "<br><a href=\"editMatchAnalysis.php?match=$matchIDGet\"> ⁄œÌ· „œŒ·«  «· Õ·Ì·</a>";
	echo "</td></tr>\n";
	echo "	<tr>\n";
	echo "	<td rowspan=\"5\">";
	echo "<div id=\"playersLinedUp\">";
	echo "<select name=\"playersLineUp\" size=\"11\" onclick=\"CityExFile('getPlayerCheck.php','playerID',this.value,'playerCxBx')\">";
	$sqlMatch = "SELECT * FROM inmatch WHERE inmatchMatch='$matchIDGet' AND inmatchTeam='$teamID' AND (inmatchType=0 OR inmatchType=5)
	ORDER BY inmatchPosition,inmatchNumber";
	$queryresultMatch = mysql_query($sqlMatch)
	or die(mysql_error());
	if (mysql_num_rows($queryresultMatch) != 0) {
		while ($rowMatch = mysql_fetch_assoc($queryresultMatch)) {
			$PlayerInMatch = $rowMatch['inmatchMember'];
			$PlayerNumber = $rowMatch['inmatchNumber'];
			echo "	<option value=\"$PlayerInMatch\">$PlayerNumber - ";
			echo playerShortNameAr($PlayerInMatch);
			echo "</option>";

		}
		mysql_free_result($queryresultMatch);
	} else {
		$sqlInSeason = "SELECT * FROM inseason WHERE inseasonSeason='$season' AND inseasonTeam='$teamID' AND inseasonType=0 AND inseasonTransfer=0";
		$queryresultSeason = mysql_query($sqlInSeason)
			or die(mysql_error());
		while ($rowInSeason = mysql_fetch_assoc($queryresultSeason)) {
			$PlayerInSeason = $rowInSeason['inseasonMember'];
			echo "	<option value=\"$PlayerInSeason\"> ";
			echo playerShortNameAr($PlayerInSeason);
			echo "</option>";
		}
		mysql_free_result($queryresultMatch);
	}
	echo "</select>";
	echo "</div>";
	echo "<div id=\"LinedUpPlayers\"></div>";
	echo "<div id=\"Subs\"></div>";
	echo " </td>\n";
	echo "</td>\n</tr>";
	echo "	<tr>\n";
	echo "<td>\n «·œﬁÌﬁ…";
	echo "<select name=\"mins\" id=\"mins\">";
	$sqlMins = "SELECT * FROM matchanalysis WHERE analysisMatch='$matchIDGet' ORDER BY analysisID DESC"; // AND analysisID=(SELECT MAX(analysisID) FROM matchanalysis)
	$queryresultMins = mysql_query($sqlMins)
		or die(mysql_error());
		$rowMins = mysql_fetch_assoc($queryresultMins);
		$PreviousMin = $rowMins['analysisMins'];
		$PreviousHalf = $rowMins['analysisHalf'];
		$PreviousComment = $rowMins['analysisComment'];
		mysql_free_result($queryresultMins);
	$ExtraTime = 90;
	$ExtraTime2 = 105;
	if (mysql_num_rows($queryresultMins) == 0) {
	}
	for ($i=1; $i <= 45; $i++){
		if ($PreviousHalf == 1) {
			if ($i == $PreviousMin) {
				echo "	<option selected=\"selected\" value=\"$i\">$i</option>";
			}
			elseif ($i == 45) {
				echo "	<option value=\"$i\">$i</option>";
				/*echo "	<option value=\"451\">45+1</option>";
				   echo "	<option value=\"452\">45+2</option>";
				   echo "	<option value=\"453\">45+3</option>";*/
			} else {
				echo "	<option value=\"$i\">$i</option>";
			}
		}
		elseif ($PreviousHalf == 2) {
			$minuteNow = $i + 45;
			if ($minuteNow == $PreviousMin) {
				echo "	<option selected=\"selected\" value=\"$minuteNow\">$minuteNow</option>";
			}
			elseif ($minuteNow == 90) {
				echo "	<option value=\"$minuteNow\">$minuteNow</option>";
				/*echo "	<option value=\"901\">90+1</option>";
				   echo "	<option value=\"902\">90+2</option>";
				   echo "	<option value=\"903\">90+3</option>";
				   echo "	<option value=\"904\">90+4</option>";
				   echo "	<option value=\"905\">90+5</option>";
				   echo "	<option value=\"906\">90+6</option>";*/
			}
			else {
				echo "	<option value=\"$minuteNow\">$minuteNow</option>";
			}
		}
		elseif ($PreviousHalf == 3) {
			$ExtraTime += 1;
			echo "	<option value=\"$ExtraTime\">$ExtraTime</option>";
			$i += 2;
		}
		elseif ($PreviousHalf == 4) {
			$ExtraTime2 += 1;
			echo "	<option value=\"$ExtraTime2\">$ExtraTime2</option>";
			$i += 2;
		}
		elseif ($PreviousHalf == 0) {
			if ($PreviousMin == 0) {
				if ($i == 1) {
					echo "	<option value=\"0\">0</option>";
					echo "	<option value=\"$i\">$i</option>";
				} else {
					echo "	<option value=\"$i\">$i</option>";
				}
			}
			elseif ($PreviousMin == 45) {
				echo "	<option value=\"45\">45</option>";
				break;
			}
			elseif ($PreviousMin == 46) {
				$minuteNow = $i + 45;
				if ($minuteNow == $PreviousMin) {
					echo "	<option selected=\"selected\" value=\"$minuteNow\">$minuteNow</option>";
				}
				else {
					echo "	<option value=\"$minuteNow\">$minuteNow</option>";
				}
			}
			elseif ($PreviousMin == 90) {
				echo "	<option value=\"90\">90</option>";
				break;
			}
			elseif ($PreviousMin == 91) {
				$ExtraTime += 1;
				echo "	<option value=\"$ExtraTime\">$ExtraTime</option>";
				$i += 2;
			}
			elseif ($PreviousMin == 105) {
				echo "	<option value=\"105\">105</option>";
				break;
			}
			elseif ($PreviousMin == 106) {
				$ExtraTime2 += 1;
				echo "	<option value=\"$ExtraTime2\">$ExtraTime2</option>";
				$i += 2;
			}
			elseif ($PreviousMin == 120) {
				echo "	<option value=\"120\">120</option>";
				break;
			}
		}
	}
	echo "</select>";
	echo "</td>\n</tr>";
	echo " <td>\n";
	global $EventSimpleLiveAr;
		for ($i=0; $i < sizeof($EventSimpleLiveAr); $i++){
			if ($i == 0) {
				echo " | <input type=\"radio\" checked=\"checked\" name=\"event\" onclick=\"HideDiv('playerCxBxSub');HideDiv('penalties');HideDiv('assist');HideDiv('Subs')\" value=\"$i\">".$EventSimpleLiveAr[$i]." | ";
			}
			elseif ($i == 1) {
				echo "<input type=\"radio\" name=\"event\" value=\"$i\" onclick=\"CityExFile('getPlayerCheck.php','teamID=$teamID&Subs','".$matchIDGet."','Subs');HideDiv('penalties');HideDiv('assist');HideDiv('playerCxBxSub')\">".$EventSimpleLiveAr[$i]." | ";
			}
			elseif ($i == 2){
				echo "<input type=\"radio\" name=\"event\" value=\"$i\" onclick=\"CityExFile('getPlayerCheck.php','teamID=$teamID&assist','".$matchIDGet."','Subs');ShowDiv('assist');ShowDiv('Goal');HideDiv('penalties');HideDiv('playerCxBxSub')\">".$EventSimpleLiveAr[$i]." | ";
			}
			elseif ($i == 5) {
				echo "";
			}
			elseif ($i == 6) {
				echo "<input type=\"radio\" name=\"event\" onclick=\"ShowDiv('penalties');HideDiv('playerCxBxSub');HideDiv('assist');HideDiv('Subs')\" value=\"$i\">".$EventSimpleLiveAr[$i]." | ";
			}
			else {
				echo "<input type=\"radio\" name=\"event\" onclick=\"HideDiv('playerCxBxSub');HideDiv('penalties');HideDiv('assist');HideDiv('Subs')\" value=\"$i\">".$EventSimpleLiveAr[$i]." | ";
			}
		}
	echo "<div id=\"penalties\" style=\"visibility:hidden;\">";
	global $PenaltiesAr;
	for ($i = 0; $i < sizeof($PenaltiesAr); $i++){
		if ($i == 0) {
			echo "";
		} else {
			echo "<input type=\"radio\" name=\"penalty\" value=\"$i\">".$PenaltiesAr[$i]." | ";
		}
	}
	echo "</div>";
	echo "<div id=\"Goal\" style=\"visibility:hidden;\">";
	global $GoalAr;
	foreach ($GoalAr AS $key => $value){
		if ($value == 0) {
			echo "<input type=\"radio\" name=\"penalty\" value=\"$value\" checked=\"true\" onclick=\"CityExFile('getPlayerCheck.php','teamID=$teamID&LinedUp','".$matchIDGet."','playersLinedUp');CityExFile('getPlayerCheck.php','teamID=$teamID&assist','".$matchIDGet."','Subs');ShowDiv('assist');HideDiv('penalties');ShowDiv('playerCxBxSub')\"> $key |";
		}
		elseif($value == 5) {
			if ($teamID == $team1) {
				echo "<input type=\"radio\" name=\"penalty\" value=\"$value\" onclick=\"CityExFile('getPlayerCheck.php','teamID=$team2&LinedUp','".$matchIDGet."','playersLinedUp');HideDiv('assist');HideDiv('penalties');HideDiv('playerCxBxSub')\"> $key |";
			}
			elseif ($teamID == $team2) {
				echo "<input type=\"radio\" name=\"penalty\" value=\"$value\" onclick=\"CityExFile('getPlayerCheck.php','teamID=$team1&LinedUp','".$matchIDGet."','playersLinedUp');HideDiv('assist');HideDiv('penalties');HideDiv('playerCxBxSub')\"> $key |";
			}
		}
		else {
			echo "<input type=\"radio\" name=\"penalty\" value=\"$value\" onclick=\"CityExFile('getPlayerCheck.php','teamID=$teamID&LinedUp','".$matchIDGet."','playersLinedUp');ShowDiv('assist');HideDiv('penalties');ShowDiv('playerCxBxSub')\">$key | ";
		}
	}
	echo "</div>";
	echo "</td>\n</tr>";
	echo "	<tr>\n";
	echo "<td>\n";
	echo "<script type=\"text/javascript\" src=\"../js/getRequest.js\"></script>\n<script type=\"text/javascript\" src=\"../js/getNewDiv.js\"></script>\n";
	echo "<div id=\"playerCxBx\"></div>";
	echo "<div id=\"assist\" style=\"visibility:hidden;\"><input type=\"checkbox\" checked=\"checked\" name=\"assist\" id=\"assist\" value=\"5\" onclick=\"ChangeDiv('playerCxBxSub')\">".$EventSimpleAr[5]."</div>";
	echo "<div id=\"playerCxBxSub\"></div>";
	echo "</td>\n</tr>";
	echo "<tr>";
	echo "	<td><textarea rows=\"7\" style=\"width:90%;\" type=\"text\" name=\"commentPost\" id=\"commentPost\"></textarea></td>\n";
	echo "</tr>";
	echo "	<tr>\n";
	echo "	<td colspan=\"2\"><input type=\"submit\" value=\"Add content\"></td>\n";
	echo "	</tr>\n";
}

elseif (isset($_GET["match"])) {
	$matchIDGet = $_GET["match"];
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
	$outputTable .= "<tr><td>";
	$dateDayEn = date('l', strtotime($dateMatch));
	$dateArr = array("Saturday"=>"«·”» ","Sunday"=>"«·√Õœ","Monday"=>"«·√À‰Ì‰","Tuesday"=>"«·À·«À«¡","Wednesday"=>"«·√—»⁄«¡","Thursday"=>"«·Œ„Ì”","Friday"=>"«·Ã„⁄…");
	$dateDayAr = $dateArr[$dateDayEn];
	$outputTable .= "$dateDayAr $dateMatch</td>";
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

	echo "</td></tr>\n";
	echo "<tr><td>\n";
	echo "«·›—Ìﬁ";
	echo "</td>\n";
	echo "<td>\n";
	echo "<input type=\"radio\" name=\"teamsPlaying\" onclick=\"window.location='addMatchAnalysis.php?match=$matchIDGet&team=$team1';\" value=\"$team1\">$teamPlaying1";
	echo "<input type=\"radio\" name=\"teamsPlaying\" onclick=\"window.location='addMatchAnalysis.php?match=$matchIDGet&team=$team2';\" value=\"$team2\">$teamPlaying2";

	echo "</td></tr>\n";
}

echo "</table>\n";
echo "</form>\n";

if (isset($_POST['event']) && isset($_GET["match"]) && isset($_GET["team"])) { // && isset($_POST['playerOne'])
	$commentPost = trim($_POST['commentPost']);
	$mins = $_POST['mins'];
	$Event = $_POST['event'];
	$match = $_GET["match"];
	$teamIDGet = $_GET["team"];

	$redirectAction = "addMatchAnalysis.php?match=";
	$redirectAction .= $match;
	$redirectAction .= "&team=";
	$redirectAction .= $teamIDGet;
	$redirection =  " „ «÷«›… «·„œŒ·«  »‰Ã«Õ!";
	$redirection .= "<a href=\"addInSeason.php\">«·⁄Êœ…</a>";
	$redirection .= header("location: $redirectAction") ;

	$sqlMatchAnalysis = "SELECT * FROM matchanalysis WHERE analysisMatch='$match' ORDER BY analysisID DESC";
	$queryresultMatchAnalysis = mysql_query($sqlMatchAnalysis)
	or die(mysql_error());
	//$rowMatchAnalysis = mysql_fetch_assoc($queryresultMatchAnalysis);
	while($rowMatchAnalysis = mysql_fetch_assoc($queryresultMatchAnalysis)){
		$Min = $rowMatchAnalysis['analysisMins'];
		$half = $rowMatchAnalysis['analysisHalf'];
		if ($half == 0 && $Min == 0) {
			$halfNum = 1;
			break;
		}
		elseif ($half == 0 && $Min == 45) {
			$halfNum = 0;
			break;
		}
		elseif ($half == 0 && $Min == 46) {
			$halfNum = 2;
			break;
		}
		elseif ($half == 0 && $Min == 90) {
			$halfNum = 0;
			break;
		}
		elseif ($half == 0 && $Min == 91) {
			$halfNum = 3;
			break;
		}
		elseif ($half == 0 && $Min == 105) {
			$halfNum = 0;
			break;
		}
		elseif ($half == 0 && $Min == 106) {
			$halfNum = 4;
			break;
		}
		elseif ($half == 0 && $Min == 120) {
			$halfNum = 0;
			break;
		}
	}
	mysql_free_result($queryresultMatchAnalysis);

	if (isset($_POST['playerOne'])) {
		$playerOne = $_POST['playerOne'];
	}
	else {
		$playerOne = 0;
	}
	if ($commentPost != "" ) {
		$sql = "INSERT INTO comment (`commentText`)	VALUES ('$commentPost');";
		mysql_query($sql) or die (mysql_error());
		$sqlComment = "SELECT * FROM comment";
		$queryresultComment = mysql_query($sqlComment)
			or die(mysql_error());
		$commentID = mysql_num_rows($queryresultComment);
		mysql_free_result($queryresultComment);
	}
	else {
		$commentID = 0;
	}
	if ($Event == 0) {
		$sqlMatchAnalysis = "INSERT INTO matchanalysis (`analysisMatch`,`analysisTeam`,`analysisPlayer`,`analysisEvent`,`analysisHalf`,`analysisMins`,`analysisComment`)
		VALUES ('$match','$teamIDGet','$playerOne','$Event','$halfNum','$mins','$commentID');";
		mysql_query($sqlMatchAnalysis) or die (mysql_error());
		echo $redirection;
	}
	elseif ($Event == 1) {
		$playerTwo = $_POST['playerTwo'];
		$sqlMatchAnalysis = "INSERT INTO matchanalysis (`analysisMatch`,`analysisTeam`,`analysisPlayer`,`analysisEvent`,`analysisHalf`,`analysisMins`,`analysisComment`)
		VALUES ('$match','$teamIDGet','$playerOne','$Event','$halfNum','$mins','$commentID');";
			mysql_query($sqlMatchAnalysis) or die (mysql_error());
		$sql = "UPDATE inmatch SET inmatchType='6' WHERE inmatchMatch='$match' AND inmatchTeam='$teamIDGet' AND inmatchType='0' AND inmatchMember='$playerOne'";
			mysql_query($sql) or die (mysql_error());
		$sqlMatchAnalysis2 = "INSERT INTO matchanalysis (`analysisMatch`,`analysisTeam`,`analysisPlayer`,`analysisEvent`,`analysisHalf`,`analysisMins`,`analysisComment`)
		VALUES ('$match','$teamIDGet','$playerTwo','$Event','$halfNum','$mins','0');";
			mysql_query($sqlMatchAnalysis2) or die (mysql_error());
		$sql = "UPDATE inmatch SET inmatchType='5' WHERE inmatchMatch='$match' AND inmatchTeam='$teamIDGet' AND inmatchType='1' AND inmatchMember='$playerTwo'";
			mysql_query($sql) or die (mysql_error());
		echo $redirection;
	}
	elseif ($Event == 2) {
		$goalType = $_POST['penalty'];
		if (isset($_POST['assist'])) {
			$playerTwo = $_POST['playerTwo'];
			$assist = $_POST['assist'];
			$sqlMatchAnalysis = "INSERT INTO matchanalysis (`analysisMatch`,`analysisTeam`,`analysisPlayer`,`analysisEvent`,`analysisHalf`,`analysisMins`,`analysisComment`)
			VALUES ('$match','$teamIDGet','$playerOne','$Event','$halfNum','$mins','$commentID');";
			mysql_query($sqlMatchAnalysis) or die (mysql_error());
			$sqlMatchAnalysis2 = "INSERT INTO matchanalysis (`analysisMatch`,`analysisTeam`,`analysisPlayer`,`analysisEvent`,`analysisHalf`,`analysisMins`,`analysisComment`)
			VALUES ('$match','$teamIDGet','$playerTwo','$assist','$halfNum','$mins','0');";
			mysql_query($sqlMatchAnalysis2) or die (mysql_error());
			echo $redirection;
		}
		else {
			$sqlMatchAnalysis = "INSERT INTO matchanalysis (`analysisMatch`,`analysisTeam`,`analysisPlayer`,`analysisEvent`,`analysisPenalty`,`analysisHalf`,`analysisMins`,`analysisComment`)
			VALUES ('$match','$teamIDGet','$playerOne','$Event','$goalType','$halfNum','$mins','$commentID');";
			mysql_query($sqlMatchAnalysis) or die (mysql_error());
			echo $redirection;

		}
	}
	elseif ($Event == 3 || $Event == 4) {
		$sqlMatchAnalysis = "INSERT INTO matchanalysis (`analysisMatch`,`analysisTeam`,`analysisPlayer`,`analysisEvent`,`analysisHalf`,`analysisMins`,`analysisComment`)
		VALUES ('$match','$teamIDGet','$playerOne','$Event','$halfNum','$mins','$commentID');";
			mysql_query($sqlMatchAnalysis) or die (mysql_error());

		if ($Event == 4) {
			$sql = "UPDATE inmatch SET inmatchType='6' WHERE inmatchMatch='$match' AND inmatchTeam='$teamIDGet' AND inmatchMember='$playerOne'
			AND (inmatchType='0' OR inmatchType='5')";
			mysql_query($sql) or die (mysql_error());
		}
		echo $redirection;
	}
	elseif ($Event == 6) {
		$penalty = $_POST['penalty'];
		switch($penalty){
			case 1:
				$EventPen = 0;
				break;
			case 2:
				$EventPen = 2;
				break;
			case 3:
				$EventPen = 0;
				break;
		} // switch
		$sqlMatchAnalysis = "INSERT INTO matchanalysis (`analysisMatch`,`analysisTeam`,`analysisPlayer`,`analysisEvent`,`analysisPenalty`,`analysisHalf`,`analysisMins`,`analysisComment`)
		VALUES ('$match','$teamIDGet','$playerOne','$EventPen','$penalty','$halfNum','$mins','$commentID');";
		mysql_query($sqlMatchAnalysis) or die (mysql_error());
		echo $redirection;
	}
	/*elseif ($commentPost == "") {
		if ($Event == 0) {
			$sqlMatchAnalysis = "INSERT INTO matchanalysis (`analysisMatch`,`analysisTeam`,`analysisPlayer`,`analysisEvent`,`analysisHalf`,`analysisMins`,`analysisComment`)
			VALUES ('$match','$teamIDGet','$playerOne','$Event','$halfNum','$mins','0');";
			mysql_query($sqlMatchAnalysis) or die (mysql_error());
			echo $redirection;
		}
		elseif ($Event == 1) {
			$playerTwo = $_POST['playerTwo'];
			$sqlMatchAnalysis = "INSERT INTO matchanalysis (`analysisMatch`,`analysisTeam`,`analysisPlayer`,`analysisEvent`,`analysisHalf`,`analysisMins`,`analysisComment`)
			VALUES ('$match','$teamIDGet','$playerOne','$Event','$halfNum','$mins','0');";
			mysql_query($sqlMatchAnalysis) or die (mysql_error());
			$sql = "UPDATE inmatch SET inmatchType='6' WHERE inmatchMatch='$match' AND inmatchTeam='$teamIDGet' AND inmatchType='0' AND inmatchMember='$playerOne'";
			mysql_query($sql) or die (mysql_error());
			$sqlMatchAnalysis2 = "INSERT INTO matchanalysis (`analysisMatch`,`analysisTeam`,`analysisPlayer`,`analysisEvent`,`analysisHalf`,`analysisMins`,`analysisComment`)
			VALUES ('$match','$teamIDGet','$playerTwo','$Event','$halfNum','$mins','0');";
			mysql_query($sqlMatchAnalysis2) or die (mysql_error());
			$sql = "UPDATE inmatch SET inmatchType='5' WHERE inmatchMatch='$match' AND inmatchTeam='$teamIDGet' AND inmatchType='1' AND inmatchMember='$playerTwo'";
			mysql_query($sql) or die (mysql_error());
			echo $redirection;
		}
		elseif ($Event == 2) {
			if (isset($_POST['assist'])) {
				$playerTwo = $_POST['playerTwo'];
				$assist = $_POST['assist'];
				$sqlMatchAnalysis = "INSERT INTO matchanalysis (`analysisMatch`,`analysisTeam`,`analysisPlayer`,`analysisEvent`,`analysisHalf`,`analysisMins`,`analysisComment`)
				VALUES ('$match','$teamIDGet','$playerOne','$Event','$halfNum','$mins','0');";
				mysql_query($sqlMatchAnalysis) or die (mysql_error());
				$sqlMatchAnalysis2 = "INSERT INTO matchanalysis (`analysisMatch`,`analysisTeam`,`analysisPlayer`,`analysisEvent`,`analysisHalf`,`analysisMins`,`analysisComment`)
				VALUES ('$match','$teamIDGet','$playerTwo','$assist','$halfNum','$mins','0');";
				mysql_query($sqlMatchAnalysis2) or die (mysql_error());
				echo $redirection;
			}
			else {
				$sqlMatchAnalysis = "INSERT INTO matchanalysis (`analysisMatch`,`analysisTeam`,`analysisPlayer`,`analysisEvent`,`analysisHalf`,`analysisMins`,`analysisComment`)
				VALUES ('$match','$teamIDGet','$playerOne','$Event','$halfNum','$mins','0');";
				mysql_query($sqlMatchAnalysis) or die (mysql_error());
				echo $redirection;

			}
		}
		elseif ($Event == 3 || $Event == 4) {
			$sqlMatchAnalysis = "INSERT INTO matchanalysis (`analysisMatch`,`analysisTeam`,`analysisPlayer`,`analysisEvent`,`analysisHalf`,`analysisMins`,`analysisComment`)
			VALUES ('$match','$teamIDGet','$playerOne','$Event','$halfNum','$mins','0');";
			mysql_query($sqlMatchAnalysis) or die (mysql_error());
			if ($Event == 4) {
				$sql = "UPDATE inmatch SET inmatchType='6' WHERE inmatchMatch='$match' AND inmatchTeam='$teamIDGet' AND inmatchType='0' AND inmatchMember='$playerOne'";
				mysql_query($sql) or die (mysql_error());
			}
			echo $redirection;
		}
	}
	else {
		$sqlMatchAnalysis = "INSERT INTO matchanalysis (`analysisMatch`,`analysisTeam`,`analysisPlayer`,`analysisEvent`,`analysisHalf`,`analysisMins`,`analysisComment`)
		VALUES ('$match','$teamIDGet','$playerOne','$Event','$mins', 0);";
		mysql_query($sqlMatchAnalysis) or die (mysql_error());
		echo $redirection;
	}*/
	mysql_close($conn);
}
echo "</div>";
// making footer
echo makeFooter();

?>