<?php
	// ask for the functions from it's file
	require_once('AFunctions.php');
include 'db_conn.php';
// insert the header
echo makeHeader("Add league");
// insert the navigation
echo makeMenu();


// start the form with an empty text box to insert the new data
echo "<div id = \"maincontent\">\n";
echo "<form id = \"addCup\" action = \"\" method = \"post\">\n";
echo "<table  class=\"mcenter\">\n";
echo "	<tr class=\"mcenter\">\n";
echo "	<td colspan=\"2\">  √ÂÌ· ›—ﬁ ·œÊ— „ ﬁœ„</td>\n";
echo "	</tr>\n";

if (isset($_GET['Season']) && isset($_GET['Comp'])) {
	$seasonStart = $_GET['Season'];
	$Comp = $_GET['Comp'];
	echo "	<tr>\n";
	echo "	<td>«·„Ê”„</td>\n";
	echo "	<td>\n";
	echo season($seasonStart);
	echo " </td></tr>\n";

	echo "	<tr>\n";
	echo "	<td>\n «·»ÿÊ·… ";
	echo " </td>\n";
	echo "	<td>\n";
	echo CompAr($Comp);
	echo " </td></tr>\n";

	echo "	<tr>\n";
	echo "	<td>\n";
	echo " </td>\n";
	echo "	<td>";
	// start Adding the teams are in the competition
	$sqlMatchRound = "SELECT MAX(matchRound) FROM `matchcenter`.`match` WHERE matchSeason='$seasonStart' AND matchComp='$Comp'
	AND matchTeamHome='0' AND matchTeamAway='0'";
	$queryresultMatchRound = mysql_query($sqlMatchRound)
		or die(mysql_error());
	$rowMatchRound = mysql_fetch_assoc($queryresultMatchRound);
	$cupRound = $rowMatchRound['MAX(matchRound)'];

	function teamList($fieldName,$Ses,$Com){
		global $cupRound;
		if ($cupRound == 3) {
			$cupRound = 2;
			$whereClause = "AND (matchRound='3' OR matchRound='2')";
		} else {
			$whereClause = "AND matchRound='$cupRound'";
		}
		$CupStage = $cupRound * 2;
		$sqlMatch = "SELECT DISTINCT matchTeamHome FROM `matchcenter`.`match` WHERE matchSeason='$Ses' AND matchComp='$Com'
		AND matchRound='$CupStage' ORDER BY matchTeamHome";
		$queryresultMatch = mysql_query($sqlMatch)
			or die(mysql_error());
		$sqlMatch2 = "SELECT DISTINCT matchTeamAway FROM `matchcenter`.`match` WHERE matchSeason='$Ses' AND matchComp='$Com'
		AND matchRound='$CupStage' ORDER BY matchTeamAway";
		$queryresultMatch2 = mysql_query($sqlMatch2)
			or die(mysql_error());
		$sqlMatchAway = "SELECT * FROM `matchcenter`.`match` WHERE matchSeason='$Ses' AND matchComp='$Com'
		$whereClause";
		$queryresultMatchAway = mysql_query($sqlMatchAway)
			or die(mysql_error());
		//$rowMatch = mysql_fetch_assoc($queryresultMatch);
		//$rowMatch2 = mysql_fetch_assoc($queryresultMatch2);
		$outPutList = "<select name=\"$fieldName\">";
		if ($CupStage == 32) {
			while($rowMatch = mysql_fetch_assoc($queryresultMatch)){
				$team1 = $rowMatch['matchTeamHome'];
				// team name
				$sqlTeam = "SELECT * FROM teams WHERE teamID='$team1'";
				$queryresultTeam = mysql_query($sqlTeam)
					or die(mysql_error());
				$rowTeam = mysql_fetch_assoc($queryresultTeam);
				$teamNameAr = $rowTeam['teamNameAr'];
				$teamCity = $rowTeam['teamCity'];
				// add stuff !!
				$outPutList .= "<option value=\"$team1\">";
				$outPutList .= "$teamNameAr ".CityNameAr($teamCity);
				$outPutList .= "</option>";
			}
		}
		elseif (mysql_num_rows($queryresultMatchAway) == $cupRound) {
			while($rowMatch = mysql_fetch_assoc($queryresultMatch)){
				$team1 = $rowMatch['matchTeamHome'];
				// team name
				$sqlTeam = "SELECT * FROM teams WHERE teamID='$team1'";
				$queryresultTeam = mysql_query($sqlTeam)
					or die(mysql_error());
				$rowTeam = mysql_fetch_assoc($queryresultTeam);
				$teamNameAr = $rowTeam['teamNameAr'];
				$teamCity = $rowTeam['teamCity'];
				// add stuff !!
				$outPutList .= "<option value=\"$team1\">";
				$outPutList .= "$teamNameAr ".CityNameAr($teamCity);
				$outPutList .= "</option>";
			}
		}
		else {
			while($rowMatch = mysql_fetch_assoc($queryresultMatch)){
				$team1 = $rowMatch['matchTeamHome'];
				// team name
				$sqlTeam = "SELECT * FROM teams WHERE teamID='$team1'";
				$queryresultTeam = mysql_query($sqlTeam)
					or die(mysql_error());
				$rowTeam = mysql_fetch_assoc($queryresultTeam);
				$teamNameAr = $rowTeam['teamNameAr'];
				$teamCity = $rowTeam['teamCity'];
				// add stuff !!
				$outPutList .= "<option value=\"$team1\">";
				$outPutList .= "$teamNameAr ".CityNameAr($teamCity);
				$outPutList .= "</option>";
			}
			while($rowMatch2 = mysql_fetch_assoc($queryresultMatch2)){
				$team1 = $rowMatch2['matchTeamAway'];
				// team name
				$sqlTeam = "SELECT * FROM teams WHERE teamID='$team1'";
				$queryresultTeam = mysql_query($sqlTeam)
					or die(mysql_error());
				$rowTeam = mysql_fetch_assoc($queryresultTeam);
				$teamNameAr = $rowTeam['teamNameAr'];
				$teamCity = $rowTeam['teamCity'];
				// add stuff !!
				$outPutList .= "<option value=\"$team1\">";
				$outPutList .= "$teamNameAr ".CityNameAr($teamCity);
				$outPutList .= "</option>";
			}
		}
		$outPutList .= "</select>";
		//mysql_free_result($queryresultMatch);
		return $outPutList;
	}

	if ($cupRound == 16) {
		echo "<table border=\"0\" width=\"100%\" id=\"table1\"><tr>\n";
		echo "<td class=\"cupTblTD\">16</td>\n";
		echo "<td class=\"cupTblTD\">8</td>\n";
		echo "<td class=\"cupTblTD\">4</td>\n";
		echo "<td class=\"cupTblTD\">2</td>\n";
		echo "</tr><tr>\n";

		echo "<td class=\"cupTblTD\">\n";
		echo teamList("team11",$seasonStart,$Comp);
		echo " Vs ";
		echo teamList("team12",$seasonStart,$Comp);
		echo "</td>\n";
		echo "<td rowspan=\"3\" class=\"cupTblTD\"></td>\n";
		echo "<td>&nbsp;</td>\n";
		echo "<td>&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td class=\"cupTblTD\">&nbsp;</td>\n";
		echo "<td rowspan=\"5\" class=\"cupTblTD\">&nbsp;</td>\n";
		echo "<td rowspan=\"4\">&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td class=\"cupTblTD\">\n";
		echo teamList("team21",$seasonStart,$Comp);
		echo " Vs ";
		echo teamList("team22",$seasonStart,$Comp);
		echo "</td>\n";

		echo "</tr><tr>\n";
		echo "<td>&nbsp;</td>\n";
		echo "<td class=\"cupTblTD\">&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td class=\"cupTblTD\">\n";
		echo teamList("team31",$seasonStart,$Comp);
		echo " Vs ";
		echo teamList("team32",$seasonStart,$Comp);
		echo "</td>\n";
		echo "<td rowspan=\"3\" class=\"cupTblTD\">&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td class=\"cupTblTD\">&nbsp;</td>\n";
		echo "<td rowspan=\"5\" class=\"cupTblTD\">&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td class=\"cupTblTD\">\n";
		// 23 24
		echo teamList("team41",$seasonStart,$Comp);
		echo " Vs ";
		echo teamList("team42",$seasonStart,$Comp);
		echo "</td>\n";
		echo "<td rowspan=\"3\" class=\"cupTblTD\">&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td>&nbsp;</td>\n";
		echo "<td>&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td class=\"cupTblTD\">\n";
		//31 32
		echo teamList("team51",$seasonStart,$Comp);
		echo " Vs ";
		echo teamList("team52",$seasonStart,$Comp);
		echo "</td>\n";
		echo "<td rowspan=\"3\" class=\"cupTblTD\">&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td class=\"cupTblTD\">&nbsp;</td>\n";
		echo "<td rowspan=\"5\" class=\"cupTblTD\">&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td class=\"cupTblTD\">\n";
		// 33 34
		echo teamList("team61",$seasonStart,$Comp);
		echo " Vs ";
		echo teamList("team62",$seasonStart,$Comp);
		echo "</td>\n";
		echo "<td rowspan=\"4\">&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td>&nbsp;</td>\n";
		echo "<td class=\"cupTblTD\">&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td class=\"cupTblTD\">\n";
		// 41 42
		echo teamList("team71",$seasonStart,$Comp);
		echo " Vs ";
		echo teamList("team72",$seasonStart,$Comp);
		echo "</td>\n";
		echo "<td rowspan=\"3\" class=\"cupTblTD\">&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td class=\"cupTblTD\">&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td class=\"cupTblTD\">\n";
		// 43 44
		echo teamList("team81",$seasonStart,$Comp);
		echo " Vs ";
		echo teamList("team82",$seasonStart,$Comp);
		echo "</td>\n";
		echo "<td>&nbsp;</td>\n";
		echo "<td>&nbsp;</td>\n";
		echo "</tr></table>\n";
	}
	elseif ($cupRound == 8) {
		echo "<table border=\"0\" width=\"100%\" id=\"table1\"><tr>\n";
		echo "<td class=\"cupTblTD\">8</td>\n";
		echo "<td class=\"cupTblTD\">4</td>\n";
		echo "<td class=\"cupTblTD\">2</td>\n";
		echo "</tr><tr>\n";

		echo "<td rowspan=\"2\" class=\"cupTblTD\">\n";
		echo teamList("team11",$seasonStart,$Comp);
		echo " Vs ";
		echo teamList("team12",$seasonStart,$Comp);
		echo "</td>\n";
		echo "<td>&nbsp;</td>\n";
		echo "<td>&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td rowspan=\"4\" class=\"cupTblTD\">&nbsp;</td>\n";
		echo "<td rowspan=\"3\">&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td class=\"cupTblTD\">\n";
		echo "</td>\n";

		echo "</tr><tr>\n";
		echo "<td class=\"cupTblTD\" rowspan=\"3\">\n";
		echo teamList("team21",$seasonStart,$Comp);
		echo " Vs ";
		echo teamList("team22",$seasonStart,$Comp);
		echo "</td>\n";

		echo "</tr><tr>\n";
		echo "<td rowspan=\"5\" class=\"cupTblTD\">&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td rowspan=\"3\" class=\"cupTblTD\">&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td>&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td rowspan=\"3\" class=\"cupTblTD\">\n";
		echo teamList("team31",$seasonStart,$Comp);
		echo " Vs ";
		echo teamList("team32",$seasonStart,$Comp);
		echo "</td>\n";

		echo "</tr><tr>\n";
		echo "<td rowspan=\"4\" class=\"cupTblTD\">&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td rowspan=\"3\">&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td class=\"cupTblTD\">\n";
		echo "</td>\n";

		echo "</tr><tr>\n";
		echo "<td class=\"cupTblTD\">\n";
		echo teamList("team41",$seasonStart,$Comp);
		echo " Vs ";
		echo teamList("team42",$seasonStart,$Comp);
		echo "</td>\n";

		echo "</tr></table>\n";
	}

	elseif ($cupRound == 4) {
		echo "<table border=\"0\" width=\"100%\" id=\"table1\"><tr>\n";
		echo "<td class=\"cupTblTD\">4</td>\n";
		echo "<td class=\"cupTblTD\">2</td>\n";
		echo "</tr><tr>\n";

		echo "<td rowspan=\"2\" class=\"cupTblTD\">\n";
		echo teamList("team11",$seasonStart,$Comp);
		echo " Vs ";
		echo teamList("team12",$seasonStart,$Comp);
		echo "</td>\n";
		echo "<td>&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td rowspan=\"2\" class=\"cupTblTD\">&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td class=\"cupTblTD\">\n";
		echo "</td>\n";

		echo "</tr><tr>\n";
		echo "<td class=\"cupTblTD\" rowspan=\"3\">\n";
		echo teamList("team21",$seasonStart,$Comp);
		echo " Vs ";
		echo teamList("team22",$seasonStart,$Comp);
		echo "</td>\n";

		echo "</tr><tr>\n";
		echo "<td rowspan=\"2\">&nbsp;</td>\n";

		echo "</tr></table>\n";
	}
	elseif ($cupRound == 3 OR $cupRound == 2) {
		echo "<table border=\"0\" width=\"100%\" id=\"table1\"><tr>\n";
		echo "<td class=\"cupTblTD\">«·‰Â«∆Ì</td>\n";
		echo "</tr><tr>\n";

		echo "<td class=\"cupTblTD\">\n";
		echo teamList("team1",$seasonStart,$Comp);
		echo " Vs ";
		echo teamList("team2",$seasonStart,$Comp);
		echo "</td>\n";
		echo "</tr></table>\n";
	}

	// End Adding the teams are in the competition
	echo " </td></tr>\n";

	echo "	<tr>\n";
	echo "	<td colspan=\"2\"><input type=\"submit\" value=\"Add content\"></td>\n";
	echo "	</tr>\n";

}

elseif (isset($_GET['Season'])) {
	$seasonStart = $_GET['Season'];
	echo "	<tr>\n";
	echo "	<td>«·„Ê”„</td>\n";
	echo "	<td>\n";
	echo season($seasonStart);
	echo " </td></tr>\n";

	echo "	<td>«·»ÿÊ·…</td>\n";
	echo "	<td>\n <select name = \"comptetion\" id =\"comptetion\" onchange=\"window.location='addCupQualify.php?Season=$seasonStart&Comp='+this.value\">";
	$sqlComp = "SELECT * FROM competition WHERE compSys='2'";
	$queryresultComp = mysql_query($sqlComp)
	or die(mysql_error());
	echo "	<option value=\"\"></option>";
	while ($rowComp = mysql_fetch_assoc($queryresultComp)) {
		$CompID = $rowComp['compID'];
		$CompNameAr = $rowComp['compNameAr'];
		echo "	<option value=\"$CompID\">$CompNameAr</option>";
	}
	mysql_free_result($queryresultComp);
	echo "	</select></td></tr>\n";
}

else {
	echo "	<tr>\n";
	echo "	<td>«·„Ê”„</td>\n";
	echo "	<td>\n <select name = \"season\" id =\"season\" onchange=\"window.location='addCupQualify.php?Season='+this.value\">";
	$sqlSes = "SELECT * FROM season";
	$queryresultSes = mysql_query($sqlSes)
			or die(mysql_error());
	echo "	<option value=\"\"> </option>";
	while ($rowSes = mysql_fetch_assoc($queryresultSes)) {
		$sesID = $rowSes['seasonID'];
		$start = $rowSes['seasonYearStart'];
		$end = $rowSes['seasonYearEnd'];
		echo "	<option value=\"$sesID\">$start - $end</option>";
	}
	mysql_free_result($queryresultSes);
	echo "	</select></td></tr>\n";
}
echo "</table>\n";
echo "</form>\n";

if (isset($_GET['Season']) && isset($_GET['Comp']) && isset($_POST['team11'])) {
	$Season = $_GET['Season'];
	$Comptetion = $_GET['Comp'];
	$AutoNumber = 0;

	$sqlMatchRound = "SELECT MAX(matchRound) FROM `matchcenter`.`match` WHERE matchSeason='$Season' AND matchComp='$Comptetion'
	AND matchTeamHome='0' AND matchTeamAway='0'";
	$queryresultMatchRound = mysql_query($sqlMatchRound)
		or die(mysql_error());
	$rowMatchRound = mysql_fetch_assoc($queryresultMatchRound);
	$cupRound = $rowMatchRound['MAX(matchRound)'];
	$MatchNumber = $cupRound / 2;
	if ($cupRound == 3) {
		$team1ID = "team1";
		$team1IDPost = $_POST[$team1ID];
		$team2ID = "team1";
		$team2IDPost = $_POST[$team2ID];
		$sql = "UPDATE `matchcenter`.`match` SET matchTeamHome='$team1IDPost',matchTeamAway='$team2IDPost'
				WHERE matchSeason='$Season' AND matchComp='$Comptetion' AND matchRound='2'";
		mysql_query($sql) or die (mysql_error());
		echo $team1IDPost ."Vs". $team2IDPost;
		/*$sqlMatchThird = "SELECT * FROM `matchcenter`.`match` WHERE matchSeason='$Season' AND matchComp='$Comptetion'
		AND (matchRound='4' OR matchRound='2') ORDER BY matchRound DESC";
		$queryresultMatchThird = mysql_query($sqlMatchThird)
			or die(mysql_error());
		while($rowMatchThird = mysql_fetch_assoc($queryresultMatchThird)){
			$Round = $rowMatchThird['matchRound'];
			if ($Round == 2) {
				$teamOne = $rowMatchThird['matchTeamHome'];
				$teamTwo = $rowMatchThird['matchTeamAway'];
			}
			else {
				if ($teamOne != $rowMatchThird['matchTeamHome'] && $teamTwo != $rowMatchThird['matchTeamHome']) {
					$teamQualified1 = $rowMatchThird['matchTeamHome'];
				}
				elseif ($teamOne != $rowMatchThird['matchTeamAway'] && $teamTwo != $rowMatchThird['matchTeamAway']) {
					$teamQualified2 = $rowMatchThird['matchTeamAway'];
				}
			}
		}
		echo "<br>".$teamQualified1 ."Vs". $teamQualified2;
		$sql = "UPDATE `matchcenter`.`match` SET matchTeamHome='$teamQualified1',matchTeamAway='$teamQualified2'
				WHERE matchSeason='$Season' AND matchComp='$Comptetion' AND matchRound='3'";
		mysql_query($sql) or die (mysql_error());*/
	}
	elseif ($cupRound == 2) {
		$team1ID = "team1";
		$team1IDPost = $_POST[$team1ID];
		$team2ID = "team1";
		$team2IDPost = $_POST[$team2ID];
		$sql = "UPDATE `matchcenter`.`match` SET matchTeamHome='$team1IDPost',matchTeamAway='$team2IDPost'
				WHERE matchSeason='$Season' AND matchComp='$Comptetion' AND matchRound='2'";
		mysql_query($sql) or die (mysql_error());
	}
	else {
		for ($i1 = 1; $i1 <= $MatchNumber; $i1++) {
			$sqlMatchHomeAway = "SELECT * FROM `matchcenter`.`match` WHERE matchSeason='$Season' AND matchComp='$Comptetion'
		AND matchRound='$cupRound' AND matchGroup='$i1'";
			$queryresultMatchHomeAway = mysql_query($sqlMatchHomeAway)
				or die(mysql_error());

			for ($i2 = 1; $i2 <= 2; $i2++) {
				if ($i2 % 2 == 0) {
					$team2IDNumber = "$i1$i2";
					$team2ID = "team$team2IDNumber";
					$team2IDPost = $_POST[$team2ID];
				}
				else {
					$team1IDNumber = "$i1$i2";
					$team1ID = "team$team1IDNumber";
					$team1IDPost = $_POST[$team1ID];
				}
				$AutoNumber ++;
				if ($AutoNumber == 2) {
					if ($team1IDPost == $team2IDPost) {
						echo "Not Possiable <br>";
					}
					else {
						if (mysql_num_rows($queryresultMatchHomeAway) == 2) {
							include 'db_conn.php';
							$previousMatchID = 1;
							while($matchRow = mysql_fetch_assoc($queryresultMatchHomeAway)){
								$matchID = $matchRow['matchID'];
								if ($previousMatchID == 1) {
									$sql = "UPDATE `matchcenter`.`match` SET matchTeamHome='$team1IDPost',matchTeamAway='$team2IDPost'
								WHERE matchID='$matchID'";
									mysql_query($sql) or die (mysql_error());
								}
								else {
									$sql = "UPDATE `matchcenter`.`match` SET matchTeamHome='$team2IDPost',matchTeamAway='$team1IDPost'
								WHERE matchID='$matchID'";
									mysql_query($sql) or die (mysql_error());
								}
								$previousMatchID ++;
							}
						}
						else {
							include 'db_conn.php';
							$sql = "UPDATE `matchcenter`.`match` SET matchTeamHome='$team1IDPost',matchTeamAway='$team2IDPost'
				WHERE matchSeason='$Season' AND matchComp='$Comptetion' AND matchRound='$cupRound' AND matchGroup='$i1'";
							mysql_query($sql) or die (mysql_error());
						}
					}
					$AutoNumber = 0;
				}
			}
		}
	}
	echo "<table  class=\"mcenter\">\n";
	echo "	<tr class=\"mcenter\">\n";
	echo "	<td colspan=\"2\"> „  √ÂÌ· «·›—ﬁ »‰Ã«Õ! </td>\n";
	echo "	</tr>\n";
	echo "</table>\n";
	// end displaying data
	echo redirection();
	mysql_close($conn);
}

echo "</div>";

// making footer
echo makeFooter();

?>